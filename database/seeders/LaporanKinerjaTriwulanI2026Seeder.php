<?php

namespace Database\Seeders;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\UnitKerja;
use App\Services\Calculation\StatusResolver;
use App\Services\PengukuranService;
use App\Services\TargetResolver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanKinerjaTriwulanI2026Seeder extends Seeder
{
    private const SOURCE_REFERENCE = 'Laporan Kinerja Triwulan I Tahun 2026 Jaksa Agung Muda Bidang Pembinaan';

    private const EVIDENCE_REFERENCE = 'laptriIjambin.md (salinan laporan yang direkonsiliasi pada 16 September 2026)';

    /**
     * Seed fully reconciled operands as normal DRAFT measurements. When a report
     * only supplies a published realization/capaian, retain it as REPORTED rather
     * than inventing operands for the canonical formula.
     */
    public function run(): void
    {
        $calculatedRows = [
            'IKP 4.1' => [
                'unit' => 'RO-KEU',
                'inputs' => ['X1' => 84.63, 'X2' => 95.56],
                'analisis_capaian' => 'Nilai Kinerja Anggaran Kejaksaan RI per 14 April 2026 sebesar 90,10. Komponen perencanaan anggaran bernilai 84,63 dan pelaksanaan anggaran bernilai 95,56.',
                'kendala' => 'Nilai NKA masih bergerak sampai batas waktu penetapan Kementerian Keuangan. Nilai efisiensi Standar Biaya Keluaran menjadi faktor yang belum optimal.',
                'upaya' => 'Memperkuat pemantauan capaian output, pemahaman penilaian SBK, dan koordinasi satker untuk meningkatkan nilai penggunaan serta efisiensi SBK.',
            ],
            'IKP 6.2' => [
                'unit' => 'RO-REN',
                'inputs' => ['jumlah_satker_patuh' => 389, 'jumlah_satker_dinilai' => 486],
                'analisis_capaian' => 'Data terakhir tahun 2025 yang digunakan pada Triwulan I 2026: 389 dari 486 satker dinyatakan patuh terhadap SOP (80,04%).',
                'kendala' => 'Data kepatuhan masih menggunakan hasil monitoring terakhir tahun 2025.',
                'upaya' => 'Melanjutkan monitoring kepatuhan SOP dan evaluasi tindak lanjut hasil monitoring pada satuan kerja.',
            ],
            'IKP 16.1' => [
                'unit' => 'RO-KAP',
                'inputs' => ['sarpras_dimanfaatkan' => 496792, 'total_sarpras' => 565190],
                'analisis_capaian' => 'Utilisasi sarana dan prasarana Triwulan I 2026 dihitung dari BMN kondisi baik dan rusak ringan yang masih operasional dibandingkan total BMN: 496.792 dari 565.190 (87,90%).',
                'kendala' => 'Masih terdapat BMN rusak berat yang belum dihapuskan serta BMN rusak ringan yang belum atau tidak ekonomis untuk diperbaiki.',
                'upaya' => 'PIC wilayah melakukan pengawasan penghapusan BMN rusak berat dan mengumpulkan data kebutuhan BMN secara lebih komprehensif.',
            ],
        ];

        $reportedRows = [
            ['code' => 'IKP 1.1', 'unit' => 'RO-REN', 'realisasi' => 71.72, 'capaian' => 98.24, 'note' => 'Matriks laporan mencatat capaian 98,24% dengan nilai 71,72; tabel evaluasi sumber di bagian analisis juga menampilkan nilai 2025 sebesar 71,27.'],
            ['code' => 'IKP 5.1', 'unit' => 'RO-KAP', 'realisasi' => 3.75, 'capaian' => 104.17, 'note' => 'Nilai IPA tahun 2025 yang masih digunakan pada Triwulan I 2026.'],
            ['code' => 'IKP 5.2', 'unit' => 'RO-KAP', 'realisasi' => 88.34, 'capaian' => 97.61, 'note' => 'Nilai ITKP tahun 2025 yang digunakan sebagai acuan karena indeks 2026 belum tersedia.'],
            ['code' => 'IKP 6.1', 'unit' => 'RO-REN', 'realisasi' => 80.03, 'capaian' => 98.80, 'note' => 'Baseline hasil evaluasi kelembagaan tahun 2024 yang masih digunakan pada Triwulan I 2026.'],
            ['code' => 'IKP 7.1', 'unit' => 'RO-HUK-HLN', 'realisasi' => 80.04, 'capaian' => 114.34, 'note' => 'Nilai Indeks Kualitas Kebijakan instansi berdasarkan penilaian LAN RI.'],
            ['code' => 'IKP 7.2', 'unit' => 'RO-HUK-HLN', 'realisasi' => 98.10, 'capaian' => 99.90, 'note' => 'Nilai akhir Indeks Reformasi Hukum tahun 2025, kategori AA/Istimewa.'],
            ['code' => 'IKP 8.1', 'unit' => 'RO-PEG', 'realisasi' => 0.82, 'capaian' => 101.23, 'note' => 'Indeks Sistem Merit setara 0,82; laporan juga mencatat nilai 329 kategori Sangat Baik tahun 2023.'],
            ['code' => 'IKP 8.2', 'unit' => 'RO-PEG', 'realisasi' => 33.37, 'capaian' => 51.34, 'note' => 'Nilai yang dilaporkan untuk kecukupan, kesesuaian, dan pengembangan SDM.'],
            ['code' => 'IKP 8.3', 'unit' => 'RO-PEG', 'realisasi' => 3.40, 'capaian' => 91.89, 'note' => 'Laporan menyebut indeks profesionalitas 85,09% kategori tinggi, setara indeks 3,4.'],
            ['code' => 'IKP 10.1', 'unit' => 'RO-REN', 'realisasi' => 3.77, 'capaian' => 101.89, 'note' => 'Rata-rata indeks kepuasan layanan internal 94,33%, dikonversi ke skala 4 menjadi 3,77.'],
            ['code' => 'IKP 10.2', 'unit' => 'PKY', 'realisasi' => 98.25, 'capaian' => 115.59, 'note' => 'Laporan mencatat indeks 98,25%; angka tersebut berbeda dengan pembagian 1.060/1.080 yang menghasilkan 98,15%.'],
            ['code' => 'IKP 11.1', 'unit' => 'RO-PEG', 'realisasi' => 47.18, 'capaian' => 62.91, 'note' => 'Nilai yang dicantumkan matriks laporan untuk competency fit index.'],
            ['code' => 'IKP 11.2', 'unit' => 'RO-PEG', 'realisasi' => 0, 'capaian' => 0, 'note' => 'Sampai Maret 2026 asesmen belum dilaksanakan sehingga capaian yang dilaporkan 0%.'],
            ['code' => 'IKP 13.1', 'unit' => 'RO-HUK-HLN', 'realisasi' => 4.00, 'capaian' => 108.11, 'note' => 'Rata-rata NRR layanan hukum yang dilaporkan adalah 4,00 pada skala 1 sampai 4.'],
            ['code' => 'IKP 13.2', 'unit' => 'RO-HUK-HLN', 'realisasi' => 3.71, 'capaian' => 100.27, 'note' => 'Rata-rata NRR kepuasan institusi mitra luar negeri yang dilaporkan adalah 3,71.'],
            ['code' => 'IKP 15.1', 'unit' => 'PUSDASKRIMTI', 'realisasi' => 100, 'capaian' => 117.65, 'note' => 'Laporan menghitung 4 dari 4 proses bisnis terdigitalisasi; bagian lain laporan menyebut 10 proses bisnis inti.'],
        ];

        $reportedNarratives = [
            'IKP 1.1' => ['kendala' => 'Pemahaman SAKIP belum merata, kualitas perencanaan belum sepenuhnya berorientasi hasil, dan integrasi sistem informasi belum optimal.', 'upaya' => 'Memperkuat sosialisasi SAKIP, perbaikan dokumen perencanaan, budaya kinerja, pengembangan SDM perencana, dan penyempurnaan aplikasi SICANA.'],
            'IKP 5.1' => ['kendala' => 'Masih ada tindak lanjut rekomendasi BPK atas BMN, status penggunaan dan sertifikasi tanah belum lengkap, serta BMN rusak berat belum dihapuskan.', 'upaya' => 'Mengawasi penetapan status penggunaan, tindak lanjut persetujuan pengelolaan, sertifikasi BMN, dan penghapusan BMN rusak berat.'],
            'IKP 5.2' => ['kendala' => 'Jumlah SDM Kejaksaan untuk menjalankan peran pelaku pengadaan pada seluruh satuan kerja masih terbatas.', 'upaya' => 'Memantau tiap subindikator ITKP serta mendorong peningkatan kompetensi dan sertifikasi pelaku pengadaan di satker pusat maupun daerah.'],
            'IKP 6.1' => ['kendala' => 'Struktur dan nomenklatur unit, kebutuhan jabatan fungsional, pembaruan SOP, serta pemutakhiran data kelembagaan masih perlu disempurnakan.', 'upaya' => 'Menghimpun usulan perubahan Ortaker, melakukan telaah dan harmonisasi internal, memperbarui SOP, dan memperkuat kualitas data kelembagaan.'],
            'IKP 7.1' => ['kendala' => 'Laporan Triwulan I tidak menguraikan hambatan operasional khusus; nilai masih bergantung pada hasil penilaian instansi pembina.', 'upaya' => 'Menindaklanjuti rekomendasi hasil penilaian dan menyiapkan data dukung untuk evaluasi indeks berikutnya.'],
            'IKP 7.2' => ['kendala' => 'Terdapat rekomendasi perbaikan pada kompetensi perancang peraturan dan pengelolaan JDIH.', 'upaya' => 'Menindaklanjuti rekomendasi Kementerian Hukum melalui penguatan kompetensi perancang dan pembenahan pengelolaan JDIH.'],
            'IKP 8.1' => ['kendala' => 'Belum terdapat pembaruan hasil monitoring dan evaluasi resmi Sistem Merit pada masa transisi penilaian KASN ke BKN.', 'upaya' => 'Memantau penerbitan hasil penilaian resmi dan menyiapkan data dukung manajemen ASN untuk evaluasi berikutnya.'],
            'IKP 8.2' => ['kendala' => 'Laporan hanya memuat hasil publikasi tanpa tiga komponen canonical yang lengkap untuk direkonsiliasi sebagai input formula.', 'upaya' => 'Melengkapi data kecukupan, kesesuaian, dan pengembangan SDM pada pengukuran periode berikutnya.'],
            'IKP 8.3' => ['kendala' => 'Nilai profesionalitas masih berasal dari hasil penilaian terdahulu dan rincian empat dimensi berbobot belum tersedia pada laporan.', 'upaya' => 'Memutakhirkan data kualifikasi, kompetensi, kinerja, dan disiplin untuk penilaian profesionalitas berikutnya.'],
            'IKP 10.1' => ['kendala' => 'Laporan menyajikan hasil survei, tetapi komponen layanan canonical belum tersedia lengkap untuk dihitung ulang.', 'upaya' => 'Melengkapi cakupan survei dan data komponen layanan agar pengukuran berikutnya dapat direkonsiliasi.'],
            'IKP 10.2' => ['kendala' => 'Jumlah responden survei masih terbatas dan angka skor sumber tidak konsisten dengan hasil persentase yang dipublikasikan.', 'upaya' => 'Memperluas responden, menjaga mutu layanan, dan memverifikasi total skor survei sebelum pelaporan berikutnya.'],
            'IKP 11.1' => ['kendala' => 'Angka pembilang dan penyebut pada uraian laporan belum konsisten dengan hasil competency fit index yang dicantumkan.', 'upaya' => 'Memverifikasi basis data kompetensi dan menghitung ulang indikator dari data sumber yang telah divalidasi.'],
            'IKP 11.2' => ['kendala' => 'Sampai Triwulan I asesmen belum dilaksanakan sehingga capaian masih dilaporkan 0%.', 'upaya' => 'Melaksanakan asesmen serta pemutakhiran data sertifikasi aparatur pada triwulan berikutnya.'],
            'IKP 13.1' => ['kendala' => 'Laporan tidak menguraikan hambatan khusus; nilai survei layanan hukum yang dipublikasikan sudah sangat baik.', 'upaya' => 'Mempertahankan kualitas layanan dan melanjutkan pengukuran survei sesuai instrumen yang berlaku.'],
            'IKP 13.2' => ['kendala' => 'Data indeks masih mengacu pada hasil survei tahunan periode sebelumnya.', 'upaya' => 'Melaksanakan pengumpulan dan validasi data survei tahunan untuk pembaruan nilai pada periode evaluasi.'],
            'IKP 15.1' => ['kendala' => 'Denominator proses bisnis inti tidak konsisten: laporan menggunakan 4 proses, sedangkan uraian lain menyebut 10 proses.', 'upaya' => 'Merekonsiliasi daftar dan denominator proses bisnis inti dengan dokumen resmi sebelum pengukuran berikutnya.'],
        ];

        $service = app(PengukuranService::class);
        $targets = app(TargetResolver::class);
        $statusResolver = app(StatusResolver::class);

        DB::transaction(function () use ($calculatedRows, $reportedRows, $reportedNarratives, $service, $targets, $statusResolver): void {
            foreach ($calculatedRows as $code => $row) {
                $node = KinerjaNode::query()->where('kode', $code)->firstOrFail();
                $unit = UnitKerja::query()->where('kode', $row['unit'])->firstOrFail();

                $service->storeMeasurement($node, $unit->id, 2026, 1, [
                    'inputs' => $row['inputs'],
                    'analisis_capaian' => $row['analisis_capaian'],
                    'kendala' => $row['kendala'],
                    'upaya' => $row['upaya'],
                    'source_reference' => self::SOURCE_REFERENCE,
                    'evidence_reference' => self::EVIDENCE_REFERENCE,
                ], 'laptri-i-2026-seeder');
            }

            foreach ($reportedRows as $row) {
                $row = array_merge($reportedNarratives[$row['code']], $row);
                $node = KinerjaNode::query()->where('kode', $row['code'])->with('formulas')->firstOrFail();
                $unit = UnitKerja::query()->where('kode', $row['unit'])->firstOrFail();
                $target = $targets->resolve($node->id, 2026, 1);
                $formula = $node->formulas->where('is_active', true)->sortByDesc('versi')->first();

                Pengukuran::query()->updateOrCreate(
                    [
                        'node_id' => $node->id,
                        'unit_kerja_id' => $unit->id,
                        'tahun' => 2026,
                        'triwulan' => 1,
                    ],
                    [
                        'target_id' => $target?->id,
                        'realisasi' => $row['realisasi'],
                        'capaian' => $row['capaian'],
                        'target_snapshot' => $target?->nilai_target,
                        'formula_key_snapshot' => $node->formula_key,
                        'formula_version_snapshot' => $formula ? (string) $formula->versi : null,
                        'status_capaian' => $statusResolver->resolve($row['capaian'], 1, $row['realisasi']),
                        'status' => 'REPORTED',
                        'source_reference' => self::SOURCE_REFERENCE,
                        'evidence_reference' => self::EVIDENCE_REFERENCE,
                        'analisis_capaian' => $row['note'],
                        'kendala' => $row['kendala'],
                        'upaya' => $row['upaya'],
                        'calculation_trace' => [
                            'import_mode' => 'REPORTED',
                            'reported_realisasi' => $row['realisasi'],
                            'reported_capaian' => $row['capaian'],
                            'note' => $row['note'],
                            'imported_at' => now()->toIso8601String(),
                        ],
                        'created_by' => 'laptri-i-2026-seeder',
                        'updated_by' => 'laptri-i-2026-seeder',
                    ],
                );
            }
        });
    }
}
