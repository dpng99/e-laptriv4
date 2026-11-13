import { useState } from 'react';
import { Head, router, useForm, usePage } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import {
    Box, Paper, Grid, Card, CardContent, Typography, Stack, Chip, Button,
    TextField, Switch, FormControlLabel, Select, MenuItem, Tabs, Tab,
    Alert, Divider, Table, TableBody, TableCell, TableContainer, TableHead,
    TableRow, Tooltip
} from '@mui/material';
import {
    Security as SecurityIcon,
    VpnKey as VpnKeyIcon,
    Send as SendIcon,
    ContentCopy as CopyIcon,
    CheckCircle as CheckCircleIcon,
    Error as ErrorIcon,
    Warning as WarningIcon,
    SyncAlt as SyncIcon,
    Assessment as NilaiIcon,
    Description as NarasiIcon,
    History as HistoryIcon,
    Code as CodeIcon,
    Save as SaveIcon
} from '@mui/icons-material';

export default function AdminSerenataIndex({
    currentTahun = 2025,
    currentTriwulan = 1,
    config = {},
    endpoints = {},
    nilaiPayload = { meta: {}, data: [] },
    narasiPayload = { meta: {}, data: [] },
    syncLogs = [],
    generatedCredentials = null,
}) {
    const { flash, errors } = usePage().props;
    const [tahun, setTahun] = useState(currentTahun);
    const [triwulan, setTriwulan] = useState(currentTriwulan);
    const [activeTab, setActiveTab] = useState(0);
    const [showNilaiJson, setShowNilaiJson] = useState(false);
    const [showNarasiJson, setShowNarasiJson] = useState(false);
    const [copiedLabel, setCopiedLabel] = useState('');
    const [pushingModule, setPushingModule] = useState(null);
    const [rotating, setRotating] = useState(false);

    const form = useForm({
        is_enabled: Boolean(config.is_enabled ?? true),
        webhook_nilai_url: config.webhook_nilai_url || '',
        webhook_narasi_url: config.webhook_narasi_url || '',
        webhook_token: '',
        clear_webhook_token: false,
        allowed_ips: config.allowed_ips || '',
        rate_limit_per_minute: config.rate_limit_per_minute || 30,
    });

    const handlePeriodChange = (nextTahun, nextTriwulan) => {
        setTahun(nextTahun);
        setTriwulan(nextTriwulan);
        router.get(
            route('admin.serenata.index'),
            { tahun: nextTahun, triwulan: nextTriwulan },
            { preserveState: true, preserveScroll: true }
        );
    };

    const handleCopy = (text, label) => {
        if (!text) return;
        navigator.clipboard?.writeText(text);
        setCopiedLabel(label);
        setTimeout(() => setCopiedLabel(''), 2200);
    };

    const handleSaveConfig = (e) => {
        e.preventDefault();
        form.put(route('admin.serenata.config.update'), {
            preserveScroll: true,
        });
    };

    const handleRotateCredentials = () => {
        if (rotating) return;
        setRotating(true);
        router.post(
            route('admin.serenata.rotate'),
            {},
            {
                preserveScroll: true,
                onFinish: () => setRotating(false),
            }
        );
    };

    const handlePushModule = (moduleType) => {
        if (pushingModule) return;
        setPushingModule(moduleType);
        const routeName = moduleType === 'NARASI'
            ? 'admin.serenata.push.narasi'
            : 'admin.serenata.push.nilai';

        router.post(
            route(routeName),
            { tahun, triwulan },
            {
                preserveScroll: true,
                onFinish: () => setPushingModule(null),
            }
        );
    };

    const nilaiItems = Array.isArray(nilaiPayload?.data) ? nilaiPayload.data : [];
    const narasiItems = Array.isArray(narasiPayload?.data) ? narasiPayload.data : [];
    const nilaiTerisiCount = nilaiItems.filter((item) => item.nilai_realisasi !== null || item.nilai_capaian !== null).length;
    const narasiLengkapCount = narasiItems.filter((item) => item.is_narasi_lengkap).length;

    return (
        <AppLayout title="Integrasi API Aman SERENATA PANEV">
            <Head title="Integrasi SERENATA PANEV" />

            {flash?.success && (
                <Alert severity="success" sx={{ mb: 2.5, borderRadius: 2.5, fontWeight: 600 }}>
                    {flash.success}
                </Alert>
            )}

            {(errors?.push_nilai || errors?.push_narasi || errors?.webhook_nilai_url || errors?.webhook_narasi_url || errors?.credentials || errors?.is_enabled) && (
                <Alert severity="error" sx={{ mb: 2.5, borderRadius: 2.5, fontWeight: 600 }}>
                    {errors.push_nilai || errors.push_narasi || errors.webhook_nilai_url || errors.webhook_narasi_url || errors.credentials || errors.is_enabled}
                </Alert>
            )}

            {copiedLabel && (
                <Alert severity="info" sx={{ mb: 2, borderRadius: 2 }}>
                    Berhasil menyalin <strong>{copiedLabel}</strong> ke clipboard.
                </Alert>
            )}

            {/* ONE-TIME CREDENTIAL DISPLAY ALERT */}
            {generatedCredentials && (
                <Paper
                    elevation={0}
                    sx={{
                        p: 3,
                        mb: 3,
                        borderRadius: 3,
                        bgcolor: '#fffbeb',
                        border: '2px solid #f59e0b',
                    }}
                >
                    <Stack direction="row" spacing={1.5} alignItems="center" sx={{ mb: 1 }}>
                        <VpnKeyIcon sx={{ color: '#d97706' }} />
                        <Typography variant="h6" fontWeight={800} sx={{ color: '#92400e' }}>
                            Kredensial Keamanan Baru SERENATA PANEV (Hanya Ditampilkan Satu Kali)
                        </Typography>
                    </Stack>
                    <Typography variant="body2" sx={{ color: '#78350f', mb: 2 }}>
                        Salin dan simpan <strong>Bearer API Key</strong> serta <strong>HMAC-SHA256 Shared Secret</strong> di bawah ini sekarang. Demi keamanan, sistem hanya menyimpan hash SHA-256 untuk API Key dan tidak akan menampilkannya lagi dalam bentuk teks biasa.
                    </Typography>

                    <Grid container spacing={2}>
                        <Grid item xs={12} md={6}>
                            <Box sx={{ p: 1.5, bgcolor: '#ffffff', borderRadius: 2, border: '1px solid #fcd34d' }}>
                                <Stack direction="row" justifyContent="space-between" alignItems="center">
                                    <Typography variant="caption" fontWeight={800} sx={{ color: '#92400e' }}>
                                        BEARER API KEY (Authorization: Bearer ...)
                                    </Typography>
                                    <Button
                                        size="small"
                                        startIcon={<CopyIcon fontSize="small" />}
                                        onClick={() => handleCopy(generatedCredentials.api_key, 'Bearer API Key')}
                                        sx={{ textTransform: 'none', fontWeight: 700 }}
                                    >
                                        Salin
                                    </Button>
                                </Stack>
                                <Typography
                                    variant="body2"
                                    sx={{ fontFamily: 'monospace', fontWeight: 700, wordBreak: 'break-all', color: '#0f172a', mt: 0.5 }}
                                >
                                    {generatedCredentials.api_key}
                                </Typography>
                            </Box>
                        </Grid>

                        <Grid item xs={12} md={6}>
                            <Box sx={{ p: 1.5, bgcolor: '#ffffff', borderRadius: 2, border: '1px solid #fcd34d' }}>
                                <Stack direction="row" justifyContent="space-between" alignItems="center">
                                    <Typography variant="caption" fontWeight={800} sx={{ color: '#92400e' }}>
                                        HMAC-SHA256 SHARED SECRET (X-Serenata-Signature)
                                    </Typography>
                                    <Button
                                        size="small"
                                        startIcon={<CopyIcon fontSize="small" />}
                                        onClick={() => handleCopy(generatedCredentials.hmac_secret, 'HMAC Secret')}
                                        sx={{ textTransform: 'none', fontWeight: 700 }}
                                    >
                                        Salin
                                    </Button>
                                </Stack>
                                <Typography
                                    variant="body2"
                                    sx={{ fontFamily: 'monospace', fontWeight: 700, wordBreak: 'break-all', color: '#0f172a', mt: 0.5 }}
                                >
                                    {generatedCredentials.hmac_secret}
                                </Typography>
                            </Box>
                        </Grid>
                    </Grid>
                </Paper>
            )}

            {/* HERO HEADER */}
            <Paper
                elevation={0}
                sx={{
                    p: { xs: 3, md: 3.5 },
                    mb: 3,
                    borderRadius: 3.5,
                    background: 'linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #064e3b 100%)',
                    color: '#ffffff',
                    border: '1px solid rgba(255,255,255,0.08)',
                }}
            >
                <Stack
                    direction={{ xs: 'column', md: 'row' }}
                    justifyContent="space-between"
                    alignItems={{ md: 'center' }}
                    spacing={2}
                >
                    <Box>
                        <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1 }} flexWrap="wrap" useFlexGap>
                            <Chip
                                icon={<SecurityIcon sx={{ fontSize: '15px !important', color: '#34d399 !important' }} />}
                                label="HMAC-SHA256 + Anti-Replay + SSRF Guard"
                                size="small"
                                sx={{ bgcolor: 'rgba(16, 185, 129, 0.2)', color: '#34d399', fontWeight: 700, border: '1px solid rgba(16, 185, 129, 0.4)' }}
                            />
                            <Chip
                                label="2 API Terpisah: Modul Nilai IKP & Modul Narasi IKP"
                                size="small"
                                sx={{ bgcolor: 'rgba(56, 189, 248, 0.2)', color: '#38bdf8', fontWeight: 700 }}
                            />
                        </Stack>
                        <Typography variant="h4" fontWeight={800} sx={{ letterSpacing: -0.5 }}>
                            Gateway Integrasi SERENATA PANEV
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#94a3b8', mt: 0.5, maxWidth: 740 }}>
                            Pertukaran data eksplisit <strong>Indikator Kinerja Program (IKP)</strong> JAMBIN yang dipisahkan secara khusus menjadi <strong>API Modul Nilai IKP</strong> (kuantitatif) dan <strong>API Modul Narasi IKP</strong> (evaluasi kualitatif).
                        </Typography>
                    </Box>

                    {/* Period Filter */}
                    <Stack
                        direction="row"
                        spacing={1.5}
                        alignItems="center"
                        sx={{
                            bgcolor: 'rgba(15, 23, 42, 0.75)',
                            p: 1.5,
                            borderRadius: 3,
                            border: '1px solid rgba(255, 255, 255, 0.12)',
                        }}
                    >
                        <Box>
                            <Typography variant="caption" sx={{ color: '#94a3b8', fontWeight: 700, fontSize: '0.7rem', display: 'block', mb: 0.5 }}>
                                TAHUN
                            </Typography>
                            <Select
                                size="small"
                                value={tahun}
                                onChange={(e) => handlePeriodChange(e.target.value, triwulan)}
                                sx={{
                                    minWidth: 110,
                                    height: 38,
                                    color: '#ffffff',
                                    fontWeight: 700,
                                    bgcolor: 'rgba(30, 41, 59, 0.8)',
                                    borderRadius: 2,
                                    '& .MuiOutlinedInput-notchedOutline': { borderColor: 'rgba(255,255,255,0.15)' },
                                    '& .MuiSvgIcon-root': { color: '#34d399' },
                                }}
                            >
                                {[2025, 2026, 2027, 2028, 2029].map((y) => (
                                    <MenuItem key={y} value={y}>Tahun {y}</MenuItem>
                                ))}
                            </Select>
                        </Box>

                        <Box>
                            <Typography variant="caption" sx={{ color: '#94a3b8', fontWeight: 700, fontSize: '0.7rem', display: 'block', mb: 0.5 }}>
                                TRIWULAN
                            </Typography>
                            <Select
                                size="small"
                                value={triwulan}
                                onChange={(e) => handlePeriodChange(tahun, e.target.value)}
                                sx={{
                                    minWidth: 130,
                                    height: 38,
                                    color: '#ffffff',
                                    fontWeight: 700,
                                    bgcolor: 'rgba(30, 41, 59, 0.8)',
                                    borderRadius: 2,
                                    '& .MuiOutlinedInput-notchedOutline': { borderColor: 'rgba(255,255,255,0.15)' },
                                    '& .MuiSvgIcon-root': { color: '#34d399' },
                                }}
                            >
                                <MenuItem value={1}>Triwulan I</MenuItem>
                                <MenuItem value={2}>Triwulan II</MenuItem>
                                <MenuItem value={3}>Triwulan III</MenuItem>
                                <MenuItem value={4}>Triwulan IV</MenuItem>
                            </Select>
                        </Box>
                    </Stack>
                </Stack>

                {/* SUMMARY METRIC CARDS */}
                <Grid container spacing={2} sx={{ mt: 1.5 }}>
                    <Grid item xs={12} sm={6} md={3}>
                        <Card sx={{ bgcolor: 'rgba(255,255,255,0.08)', color: '#fff', borderRadius: 2.5, border: '1px solid rgba(255,255,255,0.12)' }}>
                            <CardContent sx={{ py: 1.5, '&:last-child': { pb: 1.5 } }}>
                                <Typography variant="caption" sx={{ color: '#cbd5e1', fontWeight: 700 }}>
                                    STATUS GATEWAY
                                </Typography>
                                <Stack direction="row" spacing={1} alignItems="center" sx={{ mt: 0.75 }}>
                                    <Chip
                                        label={config.is_enabled ? 'AKTIF' : 'NONAKTIF'}
                                        size="small"
                                        color={config.is_enabled ? 'success' : 'error'}
                                        sx={{ fontWeight: 800 }}
                                    />
                                    <Chip
                                        label={config.has_credentials ? 'Key Terpasang' : 'Belum Ada Key'}
                                        size="small"
                                        variant="outlined"
                                        sx={{ color: '#e2e8f0', borderColor: 'rgba(255,255,255,0.3)', fontWeight: 700 }}
                                    />
                                </Stack>
                            </CardContent>
                        </Card>
                    </Grid>

                    <Grid item xs={12} sm={6} md={3}>
                        <Card sx={{ bgcolor: 'rgba(255,255,255,0.08)', color: '#fff', borderRadius: 2.5, border: '1px solid rgba(255,255,255,0.12)' }}>
                            <CardContent sx={{ py: 1.5, '&:last-child': { pb: 1.5 } }}>
                                <Typography variant="caption" sx={{ color: '#cbd5e1', fontWeight: 700 }}>
                                    API 1: MODUL NILAI IKP
                                </Typography>
                                <Typography variant="h5" fontWeight={800} sx={{ mt: 0.5, color: '#38bdf8' }}>
                                    {nilaiTerisiCount} / {nilaiItems.length} IKP Terisi
                                </Typography>
                            </CardContent>
                        </Card>
                    </Grid>

                    <Grid item xs={12} sm={6} md={3}>
                        <Card sx={{ bgcolor: 'rgba(255,255,255,0.08)', color: '#fff', borderRadius: 2.5, border: '1px solid rgba(255,255,255,0.12)' }}>
                            <CardContent sx={{ py: 1.5, '&:last-child': { pb: 1.5 } }}>
                                <Typography variant="caption" sx={{ color: '#cbd5e1', fontWeight: 700 }}>
                                    API 2: MODUL NARASI IKP
                                </Typography>
                                <Typography variant="h5" fontWeight={800} sx={{ mt: 0.5, color: '#34d399' }}>
                                    {narasiLengkapCount} / {narasiItems.length} Narasi Lengkap
                                </Typography>
                            </CardContent>
                        </Card>
                    </Grid>

                    <Grid item xs={12} sm={6} md={3}>
                        <Card sx={{ bgcolor: 'rgba(255,255,255,0.08)', color: '#fff', borderRadius: 2.5, border: '1px solid rgba(255,255,255,0.12)' }}>
                            <CardContent sx={{ py: 1.5, '&:last-child': { pb: 1.5 } }}>
                                <Typography variant="caption" sx={{ color: '#cbd5e1', fontWeight: 700 }}>
                                    PREFIX API KEY AKTIF
                                </Typography>
                                <Typography variant="body1" fontWeight={800} sx={{ mt: 0.75, fontFamily: 'monospace', color: '#fbbf24' }}>
                                    {config.api_key_prefix || 'Belum Di-generate'}
                                </Typography>
                            </CardContent>
                        </Card>
                    </Grid>
                </Grid>
            </Paper>

            {/* KONFIGURASI KEAMANAN & 2 ENDPOINT TERPISAH */}
            <Paper elevation={0} sx={{ p: 3, mb: 3, borderRadius: 3, border: '1px solid #e2e8f0' }}>
                <Stack direction={{ xs: 'column', md: 'row' }} justifyContent="space-between" alignItems={{ md: 'center' }} spacing={2} sx={{ mb: 2.5 }}>
                    <Box>
                        <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                            Konfigurasi Keamanan & Kanal Endpoint Terpisah (Nilai vs Narasi)
                        </Typography>
                        <Typography variant="caption" sx={{ color: '#64748b' }}>
                            Atur kredensial kriptografi HMAC-SHA256 serta URL Webhook terpisah untuk modul Nilai IKP dan modul Narasi IKP di SERENATA PANEV.
                        </Typography>
                    </Box>

                    <Button
                        variant="contained"
                        color="warning"
                        startIcon={<VpnKeyIcon />}
                        disabled={rotating}
                        onClick={handleRotateCredentials}
                        sx={{ fontWeight: 700, textTransform: 'none', borderRadius: 2 }}
                    >
                        {config.has_credentials ? 'Rotasi / Buat Ulang API Key & HMAC Secret' : 'Generate API Key & HMAC Secret Pertama'}
                    </Button>
                </Stack>

                {/* PULL ENDPOINTS INFO BOX */}
                <Grid container spacing={2} sx={{ mb: 3 }}>
                    <Grid item xs={12} md={6}>
                        <Box sx={{ p: 2, borderRadius: 2.5, bgcolor: '#f0f9ff', border: '1px solid #bae6fd' }}>
                            <Stack direction="row" justifyContent="space-between" alignItems="center">
                                <Chip label="PULL API 1 — KHUSUS MODUL NILAI IKP" size="small" color="info" sx={{ fontWeight: 800, fontSize: '0.7rem' }} />
                                <Button
                                    size="small"
                                    startIcon={<CopyIcon fontSize="small" />}
                                    onClick={() => handleCopy(`${endpoints.pull_nilai_url}?tahun=${tahun}&triwulan=${triwulan}`, 'Endpoint Pull Nilai IKP')}
                                    sx={{ textTransform: 'none', fontWeight: 700 }}
                                >
                                    Salin URL
                                </Button>
                            </Stack>
                            <Typography variant="body2" sx={{ fontFamily: 'monospace', fontWeight: 700, color: '#0369a1', mt: 1, wordBreak: 'break-all' }}>
                                GET {endpoints.pull_nilai_url}?tahun={tahun}&triwulan={triwulan}
                            </Typography>
                            <Typography variant="caption" sx={{ color: '#475569', display: 'block', mt: 0.5 }}>
                                Mengembalikan murni nilai akhir IKP (<code>pengukuran.capaian</code>, <code>id_satker=005016</code>, <code>bulan</code>, <code>khusus=2</code>) dan referensi target untuk 20 IKP JAMBIN tanpa komponen pembilang/penyebut.
                            </Typography>
                        </Box>
                    </Grid>

                    <Grid item xs={12} md={6}>
                        <Box sx={{ p: 2, borderRadius: 2.5, bgcolor: '#ecfdf5', border: '1px solid #a7f3d0' }}>
                            <Stack direction="row" justifyContent="space-between" alignItems="center">
                                <Chip label="PULL API 2 — KHUSUS MODUL NARASI IKP" size="small" color="success" sx={{ fontWeight: 800, fontSize: '0.7rem' }} />
                                <Button
                                    size="small"
                                    startIcon={<CopyIcon fontSize="small" />}
                                    onClick={() => handleCopy(`${endpoints.pull_narasi_url}?tahun=${tahun}&triwulan=${triwulan}`, 'Endpoint Pull Narasi IKP')}
                                    sx={{ textTransform: 'none', fontWeight: 700 }}
                                >
                                    Salin URL
                                </Button>
                            </Stack>
                            <Typography variant="body2" sx={{ fontFamily: 'monospace', fontWeight: 700, color: '#047857', mt: 1, wordBreak: 'break-all' }}>
                                GET {endpoints.pull_narasi_url}?tahun={tahun}&triwulan={triwulan}
                            </Typography>
                            <Typography variant="caption" sx={{ color: '#475569', display: 'block', mt: 0.5 }}>
                                Mengembalikan narasi IKP yang dipetakan ke <code>pelaporan_ikp.faktor</code> (Analisis + Kendala) &amp; <code>langkah_optimalisasi</code> (Upaya) beserta field asli e-Laptri.
                            </Typography>
                        </Box>
                    </Grid>
                </Grid>

                {/* FORM KONFIGURASI */}
                <Box component="form" onSubmit={handleSaveConfig}>
                    <Grid container spacing={2.5}>
                        <Grid item xs={12} md={6}>
                            <TextField
                                fullWidth
                                size="small"
                                label="Webhook URL Tujuan Push — Modul NILAI IKP (SERENATA)"
                                placeholder="https://serenata-panev.kejaksaan.go.id/api/v1/receive/ikp-nilai"
                                value={form.data.webhook_nilai_url}
                                onChange={(e) => form.setData('webhook_nilai_url', e.target.value)}
                                error={Boolean(form.errors.webhook_nilai_url)}
                                helperText={form.errors.webhook_nilai_url || 'Endpoint di SERENATA PANEV yang menerima pengiriman (POST) khusus angka nilai IKP.'}
                            />
                        </Grid>

                        <Grid item xs={12} md={6}>
                            <TextField
                                fullWidth
                                size="small"
                                label="Webhook URL Tujuan Push — Modul NARASI IKP (SERENATA)"
                                placeholder="https://serenata-panev.kejaksaan.go.id/api/v1/receive/ikp-narasi"
                                value={form.data.webhook_narasi_url}
                                onChange={(e) => form.setData('webhook_narasi_url', e.target.value)}
                                error={Boolean(form.errors.webhook_narasi_url)}
                                helperText={form.errors.webhook_narasi_url || 'Endpoint di SERENATA PANEV yang menerima pengiriman (POST) khusus narasi IKP.'}
                            />
                        </Grid>

                        <Grid item xs={12} md={5}>
                            <TextField
                                fullWidth
                                size="small"
                                type="password"
                                label={config.has_webhook_token ? 'Bearer Token Webhook Outbound (Tersimpan Terenkripsi — Isi untuk Mengubah)' : 'Bearer Token Webhook Outbound (Opsional)'}
                                value={form.data.webhook_token}
                                onChange={(e) => form.setData('webhook_token', e.target.value)}
                                helperText="Token otorisasi tambahan saat e-Laptri melakukan Push ke SERENATA PANEV."
                            />
                        </Grid>

                        <Grid item xs={12} md={5}>
                            <TextField
                                fullWidth
                                size="small"
                                label="IP Allowlist Server SERENATA PANEV (Opsional)"
                                placeholder="Contoh: 103.12.34.56, 202.45.67.0/24"
                                value={form.data.allowed_ips}
                                onChange={(e) => form.setData('allowed_ips', e.target.value)}
                                error={Boolean(form.errors.allowed_ips)}
                                helperText={form.errors.allowed_ips || 'Kosongkan untuk mengizinkan semua IP yang memiliki API Key & HMAC Signature sah.'}
                            />
                        </Grid>

                        <Grid item xs={12} md={2}>
                            <TextField
                                fullWidth
                                size="small"
                                type="number"
                                label="Rate Limit / Menit"
                                value={form.data.rate_limit_per_minute}
                                onChange={(e) => form.setData('rate_limit_per_minute', Number(e.target.value))}
                                error={Boolean(form.errors.rate_limit_per_minute)}
                            />
                        </Grid>

                        <Grid item xs={12}>
                            <Stack direction={{ xs: 'column', sm: 'row' }} justifyContent="space-between" alignItems={{ sm: 'center' }} spacing={2}>
                                <FormControlLabel
                                    control={
                                        <Switch
                                            color="success"
                                            checked={form.data.is_enabled}
                                            onChange={(e) => form.setData('is_enabled', e.target.checked)}
                                        />
                                    }
                                    label={
                                        <Typography variant="body2" fontWeight={700}>
                                            Aktifkan Gateway Pertukaran Data SERENATA PANEV (Pull & Push)
                                        </Typography>
                                    }
                                />

                                <Button
                                    type="submit"
                                    variant="contained"
                                    startIcon={<SaveIcon />}
                                    disabled={form.processing}
                                    sx={{ fontWeight: 700, textTransform: 'none', borderRadius: 2, bgcolor: '#0f172a' }}
                                >
                                    Simpan Konfigurasi Keamanan
                                </Button>
                            </Stack>
                        </Grid>
                    </Grid>
                </Box>
            </Paper>

            {/* TABS MODUL NILAI IKP vs MODUL NARASI IKP vs AUDIT LOG */}
            <Paper elevation={0} sx={{ borderRadius: 3, border: '1px solid #e2e8f0', overflow: 'hidden', mb: 4 }}>
                <Box sx={{ borderBottom: '1px solid #e2e8f0', bgcolor: '#f8fafc', px: 2 }}>
                    <Tabs
                        value={activeTab}
                        onChange={(_, val) => setActiveTab(val)}
                        variant="scrollable"
                        scrollButtons="auto"
                        sx={{
                            '& .MuiTab-root': { fontWeight: 800, textTransform: 'none', fontSize: '0.9rem', py: 2 },
                        }}
                    >
                        <Tab
                            icon={<NilaiIcon fontSize="small" />}
                            iconPosition="start"
                            label={`1. API Modul Nilai IKP (${nilaiItems.length} IKP)`}
                        />
                        <Tab
                            icon={<NarasiIcon fontSize="small" />}
                            iconPosition="start"
                            label={`2. API Modul Narasi IKP (${narasiItems.length} IKP)`}
                        />
                        <Tab
                            icon={<HistoryIcon fontSize="small" />}
                            iconPosition="start"
                            label={`3. Spesifikasi Keamanan & Log Audit (${syncLogs.length})`}
                        />
                    </Tabs>
                </Box>

                {/* TAB 1: MODUL NILAI IKP */}
                {activeTab === 0 && (
                    <Box sx={{ p: 3 }}>
                        <Stack direction={{ xs: 'column', md: 'row' }} justifyContent="space-between" alignItems={{ md: 'center' }} spacing={2} sx={{ mb: 2.5 }}>
                            <Box>
                                <Stack direction="row" spacing={1} alignItems="center">
                                    <Chip label="MODULE_TYPE: NILAI" size="small" color="info" sx={{ fontWeight: 800 }} />
                                    <Typography variant="subtitle1" fontWeight={800}>
                                        Payload Eksplisit Nilai Kuantitatif IKP — TW {triwulan} Tahun {tahun}
                                    </Typography>
                                </Stack>
                                <Typography variant="caption" sx={{ color: '#64748b', display: 'block', mt: 0.5, fontFamily: 'monospace' }}>
                                    SHA-256 Integrity Hash: {nilaiPayload?.meta?.payload_sha256}
                                </Typography>
                            </Box>

                            <Stack direction="row" spacing={1.25}>
                                <Button
                                    variant="outlined"
                                    size="small"
                                    startIcon={<CodeIcon />}
                                    onClick={() => setShowNilaiJson(!showNilaiJson)}
                                    sx={{ fontWeight: 700, textTransform: 'none', borderRadius: 2 }}
                                >
                                    {showNilaiJson ? 'Sembunyikan JSON' : 'Lihat Raw JSON Nilai'}
                                </Button>

                                <Button
                                    variant="contained"
                                    color="info"
                                    size="small"
                                    startIcon={<SendIcon />}
                                    disabled={pushingModule !== null}
                                    onClick={() => handlePushModule('NILAI')}
                                    sx={{ fontWeight: 700, textTransform: 'none', borderRadius: 2 }}
                                >
                                    {pushingModule === 'NILAI' ? 'Mengirim Nilai IKP...' : 'Kirim (Push) Nilai IKP ke SERENATA'}
                                </Button>
                            </Stack>
                        </Stack>

                        {showNilaiJson && (
                            <Box sx={{ mb: 3, p: 2, borderRadius: 2.5, bgcolor: '#0f172a', color: '#38bdf8', maxHeight: 380, overflow: 'auto' }}>
                                <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 1 }}>
                                    <Typography variant="caption" sx={{ color: '#94a3b8', fontWeight: 700 }}>
                                        JSON PAYLOAD — GET /api/v1/serenata-panev/ikp/nilai?tahun={tahun}&triwulan={triwulan}
                                    </Typography>
                                    <Button
                                        size="small"
                                        variant="outlined"
                                        color="info"
                                        startIcon={<CopyIcon fontSize="small" />}
                                        onClick={() => handleCopy(JSON.stringify(nilaiPayload, null, 2), 'JSON Payload Nilai IKP')}
                                        sx={{ textTransform: 'none', fontWeight: 700 }}
                                    >
                                        Salin JSON
                                    </Button>
                                </Stack>
                                <pre style={{ margin: 0, fontSize: '0.78rem', fontFamily: 'monospace' }}>
                                    {JSON.stringify(nilaiPayload, null, 2)}
                                </pre>
                            </Box>
                        )}

                        <TableContainer sx={{ border: '1px solid #e2e8f0', borderRadius: 2.5 }}>
                            <Table size="small">
                                <TableHead sx={{ bgcolor: '#f8fafc' }}>
                                    <TableRow>
                                        <TableCell sx={{ fontWeight: 800 }}>Kode IKP</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }}>Indikator &amp; SP</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }}>Atribut SERENATA</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }} align="right">Nilai Akhir IKP (pengukuran.capaian)</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }} align="right">Ref Target &amp; Capaian e-Laptri</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }} align="center">Status</TableCell>
                                    </TableRow>
                                </TableHead>
                                <TableBody>
                                    {nilaiItems.map((item) => (
                                        <TableRow key={item.source_key} hover>
                                            <TableCell>
                                                <Chip label={item.kode_ikp} size="small" sx={{ fontWeight: 800, bgcolor: '#0f172a', color: '#fff', fontSize: '0.73rem' }} />
                                            </TableCell>
                                            <TableCell sx={{ fontWeight: 600, maxWidth: 340 }}>
                                                {item.nama_ikp}
                                                <Typography variant="caption" sx={{ display: 'block', color: '#64748b' }}>
                                                    {item.kode_sp} &mdash; Satuan: {item.satuan || '-'}
                                                </Typography>
                                            </TableCell>
                                            <TableCell>
                                                <Stack direction="row" spacing={0.5} flexWrap="wrap" useFlexGap>
                                                    <Chip label={`Satker: ${item.id_satker || '005016'}`} size="small" variant="outlined" sx={{ fontSize: '0.68rem', fontWeight: 700 }} />
                                                    <Chip label={`Bulan: ${item.bulan ?? triwulan * 3}`} size="small" variant="outlined" sx={{ fontSize: '0.68rem', fontWeight: 700 }} />
                                                    <Chip label={`Khusus: ${item.khusus ?? 2}`} size="small" variant="outlined" sx={{ fontSize: '0.68rem', fontWeight: 700 }} />
                                                </Stack>
                                            </TableCell>
                                            <TableCell align="right" sx={{ fontWeight: 800, color: '#0369a1' }}>
                                                {(item.capaian ?? item.nilai_realisasi) !== null && (item.capaian ?? item.nilai_realisasi) !== undefined
                                                    ? `${item.capaian ?? item.nilai_realisasi}${item.satuan === '%' ? '%' : ''}`
                                                    : '-'}
                                            </TableCell>
                                            <TableCell align="right">
                                                <Typography variant="caption" sx={{ display: 'block', fontWeight: 700, color: '#334155' }}>
                                                    Target: {item.nilai_target ?? item.target_teks ?? '-'}
                                                </Typography>
                                                <Typography variant="caption" sx={{ display: 'block', fontWeight: 800, color: item.nilai_capaian >= 100 ? '#059669' : '#d97706' }}>
                                                    Capaian: {item.nilai_capaian !== null ? `${item.nilai_capaian}%` : '-'}
                                                </Typography>
                                            </TableCell>
                                            <TableCell align="center">
                                                <Chip
                                                    label={item.status_capaian}
                                                    size="small"
                                                    color={item.status_capaian === 'TERCAPAI' ? 'success' : (item.status_capaian === 'BELUM_DIINPUT' ? 'default' : 'warning')}
                                                    sx={{ fontWeight: 700, fontSize: '0.7rem' }}
                                                />
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </TableContainer>
                    </Box>
                )}

                {/* TAB 2: MODUL NARASI IKP */}
                {activeTab === 1 && (
                    <Box sx={{ p: 3 }}>
                        <Stack direction={{ xs: 'column', md: 'row' }} justifyContent="space-between" alignItems={{ md: 'center' }} spacing={2} sx={{ mb: 2.5 }}>
                            <Box>
                                <Stack direction="row" spacing={1} alignItems="center">
                                    <Chip label="MODULE_TYPE: NARASI" size="small" color="success" sx={{ fontWeight: 800 }} />
                                    <Typography variant="subtitle1" fontWeight={800}>
                                        Payload Eksplisit Evaluasi & Narasi IKP — TW {triwulan} Tahun {tahun}
                                    </Typography>
                                </Stack>
                                <Typography variant="caption" sx={{ color: '#64748b', display: 'block', mt: 0.5, fontFamily: 'monospace' }}>
                                    SHA-256 Integrity Hash: {narasiPayload?.meta?.payload_sha256}
                                </Typography>
                            </Box>

                            <Stack direction="row" spacing={1.25}>
                                <Button
                                    variant="outlined"
                                    size="small"
                                    startIcon={<CodeIcon />}
                                    onClick={() => setShowNarasiJson(!showNarasiJson)}
                                    sx={{ fontWeight: 700, textTransform: 'none', borderRadius: 2 }}
                                >
                                    {showNarasiJson ? 'Sembunyikan JSON' : 'Lihat Raw JSON Narasi'}
                                </Button>

                                <Button
                                    variant="contained"
                                    color="success"
                                    size="small"
                                    startIcon={<SendIcon />}
                                    disabled={pushingModule !== null}
                                    onClick={() => handlePushModule('NARASI')}
                                    sx={{ fontWeight: 700, textTransform: 'none', borderRadius: 2 }}
                                >
                                    {pushingModule === 'NARASI' ? 'Mengirim Narasi IKP...' : 'Kirim (Push) Narasi IKP ke SERENATA'}
                                </Button>
                            </Stack>
                        </Stack>

                        {showNarasiJson && (
                            <Box sx={{ mb: 3, p: 2, borderRadius: 2.5, bgcolor: '#0f172a', color: '#34d399', maxHeight: 380, overflow: 'auto' }}>
                                <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 1 }}>
                                    <Typography variant="caption" sx={{ color: '#94a3b8', fontWeight: 700 }}>
                                        JSON PAYLOAD — GET /api/v1/serenata-panev/ikp/narasi?tahun={tahun}&triwulan={triwulan}
                                    </Typography>
                                    <Button
                                        size="small"
                                        variant="outlined"
                                        color="success"
                                        startIcon={<CopyIcon fontSize="small" />}
                                        onClick={() => handleCopy(JSON.stringify(narasiPayload, null, 2), 'JSON Payload Narasi IKP')}
                                        sx={{ textTransform: 'none', fontWeight: 700 }}
                                    >
                                        Salin JSON
                                    </Button>
                                </Stack>
                                <pre style={{ margin: 0, fontSize: '0.78rem', fontFamily: 'monospace' }}>
                                    {JSON.stringify(narasiPayload, null, 2)}
                                </pre>
                            </Box>
                        )}

                        <TableContainer sx={{ border: '1px solid #e2e8f0', borderRadius: 2.5 }}>
                            <Table size="small">
                                <TableHead sx={{ bgcolor: '#f8fafc' }}>
                                    <TableRow>
                                        <TableCell sx={{ fontWeight: 800, width: 110 }}>Kode IKP</TableCell>
                                        <TableCell sx={{ fontWeight: 800, width: 220 }}>Nama IKP</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }}>Faktor (Analisis + Kendala) &rarr; pelaporan_ikp.faktor</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }}>Langkah Optimalisasi (Upaya) &rarr; pelaporan_ikp.langkah_optimalisasi</TableCell>
                                        <TableCell sx={{ fontWeight: 800, width: 120 }} align="center">Kelengkapan</TableCell>
                                    </TableRow>
                                </TableHead>
                                <TableBody>
                                    {narasiItems.map((item) => (
                                        <TableRow key={item.source_key} hover>
                                            <TableCell>
                                                <Chip label={item.kode_ikp} size="small" sx={{ fontWeight: 800, bgcolor: '#0f172a', color: '#fff', fontSize: '0.73rem' }} />
                                            </TableCell>
                                            <TableCell sx={{ fontWeight: 600 }}>
                                                {item.nama_ikp}
                                            </TableCell>
                                            <TableCell sx={{ fontSize: '0.78rem', color: item.faktor ? '#0f172a' : '#94a3b8', whiteSpace: 'pre-line', maxWidth: 360 }}>
                                                {item.faktor || 'Belum diisi'}
                                                {(item.analisis_capaian || item.kendala) && (
                                                    <Typography variant="caption" sx={{ display: 'block', color: '#64748b', mt: 0.75 }}>
                                                        Sumber e-Laptri: {item.analisis_capaian ? 'Analisis ✓' : 'Analisis -'} &bull; {item.kendala ? 'Kendala ✓' : 'Kendala -'}
                                                    </Typography>
                                                )}
                                            </TableCell>
                                            <TableCell sx={{ fontSize: '0.78rem', color: item.langkah_optimalisasi ? '#065f46' : '#94a3b8', whiteSpace: 'pre-line', maxWidth: 320 }}>
                                                {item.langkah_optimalisasi || item.upaya || 'Belum diisi'}
                                            </TableCell>
                                            <TableCell align="center">
                                                <Chip
                                                    label={item.is_narasi_lengkap ? 'Lengkap' : 'Belum Lengkap'}
                                                    size="small"
                                                    color={item.is_narasi_lengkap ? 'success' : 'default'}
                                                    sx={{ fontWeight: 700, fontSize: '0.7rem' }}
                                                />
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </TableContainer>
                    </Box>
                )}

                {/* TAB 3: SPESIFIKASI KEAMANAN & AUDIT LOG */}
                {activeTab === 2 && (
                    <Box sx={{ p: 3 }}>
                        <Box sx={{ p: 2.5, mb: 3, borderRadius: 2.5, bgcolor: '#f8fafc', border: '1px solid #cbd5e1' }}>
                            <Typography variant="subtitle2" fontWeight={800} sx={{ color: '#0f172a', mb: 1 }}>
                                Spesifikasi Verifikasi Keamanan Berlapis (Zero-Trust HMAC-SHA256 Contract)
                            </Typography>
                            <Typography variant="caption" sx={{ color: '#334155', display: 'block', mb: 1 }}>
                                Setiap request ke <code>/api/v1/serenata-panev/ikp/nilai</code> maupun <code>/api/v1/serenata-panev/ikp/narasi</code> wajib menyertakan header berikut:
                            </Typography>
                            <Box sx={{ p: 1.5, bgcolor: '#0f172a', color: '#e2e8f0', borderRadius: 2, fontFamily: 'monospace', fontSize: '0.76rem', overflowX: 'auto' }}>
                                <div>Authorization: Bearer &lt;API_KEY&gt;</div>
                                <div>X-Serenata-Timestamp: &lt;UNIX_EPOCH_SECONDS (toleransi ±300 detik)&gt;</div>
                                <div>X-Serenata-Nonce: &lt;16-128_CHAR_UNIQUE_RANDOM_STRING (sekali pakai)&gt;</div>
                                <div>X-Serenata-Signature: HMAC_SHA256(&quot;&#123;timestamp&#125;.&#123;nonce&#125;.&#123;METHOD&#125;.&#123;path_with_sorted_query&#125;.&#123;sha256_body&#125;&quot;, &lt;HMAC_SECRET&gt;)</div>
                            </Box>
                        </Box>

                        <Typography variant="subtitle1" fontWeight={800} sx={{ mb: 1.5, color: '#0f172a' }}>
                            Riwayat Log Audit Transmisi & Keamanan API
                        </Typography>

                        <TableContainer sx={{ border: '1px solid #e2e8f0', borderRadius: 2.5 }}>
                            <Table size="small">
                                <TableHead sx={{ bgcolor: '#f8fafc' }}>
                                    <TableRow>
                                        <TableCell sx={{ fontWeight: 800 }}>Waktu</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }}>Modul</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }}>Arah</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }}>Status</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }} align="center">HTTP</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }} align="center">Periode</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }} align="center">Jml IKP</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }}>IP / Aktor</TableCell>
                                        <TableCell sx={{ fontWeight: 800 }}>Keterangan / Diagnostik</TableCell>
                                    </TableRow>
                                </TableHead>
                                <TableBody>
                                    {syncLogs.length === 0 ? (
                                        <TableRow>
                                            <TableCell colSpan={9} align="center" sx={{ py: 3, color: '#64748b' }}>
                                                Belum ada riwayat transaksi API SERENATA PANEV.
                                            </TableCell>
                                        </TableRow>
                                    ) : (
                                        syncLogs.map((log) => (
                                            <TableRow key={log.id} hover>
                                                <TableCell sx={{ fontSize: '0.75rem', whiteSpace: 'nowrap' }}>{log.created_at}</TableCell>
                                                <TableCell>
                                                    <Chip
                                                        label={log.module_type}
                                                        size="small"
                                                        color={log.module_type === 'NARASI' ? 'success' : 'info'}
                                                        variant="outlined"
                                                        sx={{ fontWeight: 800, fontSize: '0.68rem' }}
                                                    />
                                                </TableCell>
                                                <TableCell>
                                                    <Chip
                                                        label={log.direction}
                                                        size="small"
                                                        sx={{ fontWeight: 800, fontSize: '0.68rem' }}
                                                    />
                                                </TableCell>
                                                <TableCell>
                                                    <Chip
                                                        label={log.status}
                                                        size="small"
                                                        color={log.status === 'SUCCESS' ? 'success' : 'error'}
                                                        sx={{ fontWeight: 800, fontSize: '0.68rem' }}
                                                    />
                                                </TableCell>
                                                <TableCell align="center" sx={{ fontWeight: 700 }}>{log.http_status}</TableCell>
                                                <TableCell align="center" sx={{ fontSize: '0.75rem' }}>
                                                    {log.tahun ? `${log.tahun} / TW ${log.triwulan}` : '-'}
                                                </TableCell>
                                                <TableCell align="center" sx={{ fontWeight: 700 }}>{log.ikp_count}</TableCell>
                                                <TableCell sx={{ fontSize: '0.75rem' }}>
                                                    {log.ip_address || '-'} ({log.actor || '-'})
                                                </TableCell>
                                                <TableCell sx={{ fontSize: '0.75rem', color: log.error_message ? '#b91c1c' : '#334155' }}>
                                                    {log.error_message || log.response_summary || '-'}
                                                </TableCell>
                                            </TableRow>
                                        ))
                                    )}
                                </TableBody>
                            </Table>
                        </TableContainer>
                    </Box>
                )}
            </Paper>
        </AppLayout>
    );
}
