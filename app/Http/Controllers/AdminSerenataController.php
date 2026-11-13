<?php

namespace App\Http\Controllers;

use App\Models\SerenataConfig;
use App\Models\SerenataSyncLog;
use App\Services\Serenata\SerenataIkpPayloadService;
use App\Services\Serenata\SerenataPushService;
use App\Services\Serenata\SsrfUrlValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AdminSerenataController extends Controller
{
    public function __construct(
        private readonly SerenataIkpPayloadService $payloadService,
        private readonly SerenataPushService $pushService,
        private readonly SsrfUrlValidator $ssrfValidator,
    ) {}

    public function index(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'nullable|integer|between:2025,2029',
            'triwulan' => 'nullable|integer|between:1,4',
        ]);

        $tahun = (int) ($validated['tahun'] ?? 2025);
        $triwulan = (int) ($validated['triwulan'] ?? 1);

        $config = SerenataConfig::current();
        $nilaiPayload = $this->payloadService->buildNilaiPayload($tahun, $triwulan);
        $narasiPayload = $this->payloadService->buildNarasiPayload($tahun, $triwulan);

        $syncLogs = SerenataSyncLog::query()
            ->orderByDesc('id')
            ->limit(40)
            ->get()
            ->map(fn (SerenataSyncLog $log) => [
                'id' => $log->id,
                'module_type' => $log->module_type,
                'direction' => $log->direction,
                'status' => $log->status,
                'http_status' => $log->http_status,
                'tahun' => $log->tahun,
                'triwulan' => $log->triwulan,
                'ikp_count' => $log->ikp_count,
                'payload_hash' => $log->payload_hash,
                'ip_address' => $log->ip_address,
                'endpoint' => $log->endpoint,
                'actor' => $log->actor,
                'error_message' => $log->error_message,
                'response_summary' => $log->response_summary,
                'duration_ms' => $log->duration_ms,
                'created_at' => $log->created_at?->format('Y-m-d H:i:s'),
            ]);

        return Inertia::render('Admin/Serenata/Index', [
            'currentTahun' => $tahun,
            'currentTriwulan' => $triwulan,
            'config' => [
                'is_enabled' => $config->is_enabled,
                'has_credentials' => $config->hasCredentials(),
                'api_key_prefix' => $config->api_key_prefix,
                'webhook_nilai_url' => $config->webhook_nilai_url ?? '',
                'webhook_narasi_url' => $config->webhook_narasi_url ?? '',
                'has_webhook_token' => !empty($config->webhook_token_encrypted),
                'allowed_ips' => is_array($config->allowed_ips) ? implode(', ', $config->allowed_ips) : '',
                'rate_limit_per_minute' => $config->rate_limit_per_minute ?? 30,
                'last_rotated_at' => $config->last_rotated_at?->format('Y-m-d H:i:s'),
                'updated_by' => $config->updated_by,
            ],
            'endpoints' => [
                'pull_nilai_url' => url('/api/v1/serenata-panev/ikp/nilai'),
                'pull_narasi_url' => url('/api/v1/serenata-panev/ikp/narasi'),
            ],
            'nilaiPayload' => $nilaiPayload,
            'narasiPayload' => $narasiPayload,
            'syncLogs' => $syncLogs,
            'generatedCredentials' => $request->session()->get('generated_serenata_credentials'),
        ]);
    }

    public function updateConfig(Request $request)
    {
        $validated = $request->validate([
            'is_enabled' => 'required|boolean',
            'webhook_nilai_url' => 'nullable|string|max:500',
            'webhook_narasi_url' => 'nullable|string|max:500',
            'webhook_token' => 'nullable|string|max:255',
            'clear_webhook_token' => 'nullable|boolean',
            'allowed_ips' => 'nullable|string|max:1000',
            'rate_limit_per_minute' => 'required|integer|between:5,300',
        ]);

        $nilaiUrl = isset($validated['webhook_nilai_url']) && trim($validated['webhook_nilai_url']) !== ''
            ? $this->ssrfValidator->validateOrFail($validated['webhook_nilai_url'], 'webhook_nilai_url')
            : null;

        $narasiUrl = isset($validated['webhook_narasi_url']) && trim($validated['webhook_narasi_url']) !== ''
            ? $this->ssrfValidator->validateOrFail($validated['webhook_narasi_url'], 'webhook_narasi_url')
            : null;

        $ipList = [];
        if (!empty($validated['allowed_ips'])) {
            $rawIps = preg_split('/[\s,;]+/', (string) $validated['allowed_ips'], -1, PREG_SPLIT_NO_EMPTY);
            foreach ($rawIps as $entry) {
                $entry = trim($entry);
                $ipPart = str_contains($entry, '/') ? explode('/', $entry, 2)[0] : $entry;
                if (filter_var($ipPart, FILTER_VALIDATE_IP) === false) {
                    throw ValidationException::withMessages([
                        'allowed_ips' => "Format alamat IP / CIDR tidak valid: '{$entry}'.",
                    ]);
                }
                $ipList[] = $entry;
            }
        }

        $actor = $request->user()?->username ?? 'admin';
        $config = SerenataConfig::current();
        $config->is_enabled = (bool) $validated['is_enabled'];
        $config->webhook_nilai_url = $nilaiUrl;
        $config->webhook_narasi_url = $narasiUrl;
        $config->allowed_ips = array_values(array_unique($ipList));
        $config->rate_limit_per_minute = (int) $validated['rate_limit_per_minute'];
        $config->updated_by = $actor;

        if (!empty($validated['clear_webhook_token'])) {
            $config->setWebhookToken(null);
        } elseif (!empty($validated['webhook_token'])) {
            $config->setWebhookToken($validated['webhook_token']);
        }

        $config->save();

        Log::info('SERENATA PANEV Configuration Updated', [
            'actor' => $actor,
            'is_enabled' => $config->is_enabled,
            'webhook_nilai_url' => $config->webhook_nilai_url,
            'webhook_narasi_url' => $config->webhook_narasi_url,
            'allowed_ips_count' => count($config->allowed_ips ?? []),
        ]);

        return redirect()->back()->with('success', 'Konfigurasi integrasi & keamanan SERENATA PANEV berhasil disimpan.');
    }

    public function rotateCredentials(Request $request)
    {
        $actor = $request->user()?->username ?? 'admin';
        $config = SerenataConfig::current();
        $credentials = $config->rotateCredentials($actor);

        Log::info('SERENATA PANEV Credentials Rotated', [
            'actor' => $actor,
            'api_key_prefix' => $credentials['prefix'],
            'ip' => $request->ip(),
        ]);

        return redirect()->back()
            ->with('generated_serenata_credentials', $credentials)
            ->with('success', 'API Key & HMAC Secret baru berhasil di-generate. Salin kredensial di bawah sekarang karena hanya ditampilkan satu kali.');
    }

    public function pushNilai(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|between:2025,2029',
            'triwulan' => 'required|integer|between:1,4',
            'kode_ikp' => 'nullable|string|max:30',
        ]);

        $actor = $request->user()?->username ?? 'admin';
        $result = $this->pushService->pushNilai(
            (int) $validated['tahun'],
            (int) $validated['triwulan'],
            $validated['kode_ikp'] ?? null,
            $actor,
            $request->ip()
        );

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->withErrors(['push_nilai' => $result['message']]);
    }

    public function pushNarasi(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|between:2025,2029',
            'triwulan' => 'required|integer|between:1,4',
            'kode_ikp' => 'nullable|string|max:30',
        ]);

        $actor = $request->user()?->username ?? 'admin';
        $result = $this->pushService->pushNarasi(
            (int) $validated['tahun'],
            (int) $validated['triwulan'],
            $validated['kode_ikp'] ?? null,
            $actor,
            $request->ip()
        );

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->withErrors(['push_narasi' => $result['message']]);
    }
}
