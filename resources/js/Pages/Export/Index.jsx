import { useState } from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    Box, Card, CardContent, Typography, FormControl, InputLabel, Select, MenuItem, Button,
    Paper, Stack, Chip, Divider, Grid, Alert
} from '@mui/material';
import { 
    Download as DownloadIcon, 
    Description as DescriptionIcon,
    CheckCircle as CheckIcon,
    VerifiedUser as ShieldIcon,
    AutoAwesome as SparklesIcon
} from '@mui/icons-material';
import { motion } from 'framer-motion';

export default function ExportIndex({ currentTahun, currentTriwulan }) {
    const [tahun, setTahun] = useState(currentTahun);
    const [triwulan, setTriwulan] = useState(currentTriwulan);
    const [downloading, setDownloading] = useState(false);

    const handleDownload = () => {
        setDownloading(true);
        window.location.href = route('export.word', { tahun, triwulan });
        setTimeout(() => setDownloading(false), 3000);
    };

    return (
        <AppLayout title="Export Laporan Kinerja (LKjIP)">
            <Head title="Export Laporan Kinerja" />

            {/* Top Hero Banner */}
            <Paper 
                elevation={0}
                sx={{
                    p: { xs: 3, md: 3.5 },
                    mb: 4,
                    borderRadius: 3.5,
                    background: 'linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #064e3b 100%)',
                    color: '#ffffff',
                    position: 'relative',
                    overflow: 'hidden',
                    border: '1px solid rgba(255,255,255,0.08)'
                }}
            >
                <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1 }}>
                    <Chip label="LKjIP Official Generator" size="small" sx={{ bgcolor: 'rgba(16, 185, 129, 0.2)', color: '#34d399', fontWeight: 700, border: '1px solid rgba(16, 185, 129, 0.4)' }} />
                    <Chip label="Kepja 1184/2025" size="small" sx={{ bgcolor: 'rgba(255,255,255,0.1)', color: '#e2e8f0', fontWeight: 600 }} />
                </Stack>
                <Typography variant="h4" fontWeight={800} sx={{ letterSpacing: -0.5 }}>
                    Generate Laporan Akuntabilitas Kinerja (LKjIP)
                </Typography>
                <Typography variant="body2" sx={{ color: '#94a3b8', mt: 0.5, maxWidth: 650 }}>
                    Unduh dokumen laporan kinerja resmi dalam format Microsoft Word (.docx) lengkap dengan tabel capaian, evaluasi formula, kendala, dan strategi tindak lanjut.
                </Typography>
            </Paper>

            <Grid container spacing={3} justifyContent="center">
                <Grid item xs={12} md={8} lg={7}>
                    <Card sx={{ 
                        borderRadius: 3.5, 
                        border: '1px solid #e2e8f0', 
                        boxShadow: '0 10px 30px -5px rgba(15, 23, 42, 0.08)',
                        overflow: 'hidden'
                    }}>
                        <Box sx={{ p: 3, bgcolor: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                            <Stack direction="row" spacing={2} alignItems="center">
                                <Box sx={{ width: 44, height: 44, borderRadius: 2.5, bgcolor: '#eff6ff', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#2563eb' }}>
                                    <DescriptionIcon fontSize="medium" />
                                </Box>
                                <Box>
                                    <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                                        Konfigurasi Dokumen Laporan
                                    </Typography>
                                    <Typography variant="caption" sx={{ color: '#64748b' }}>
                                        Pilih tahun anggaran dan periode triwulan yang ingin diekspor
                                    </Typography>
                                </Box>
                            </Stack>
                        </Box>

                        <CardContent sx={{ p: { xs: 3, md: 4 } }}>
                            <Grid container spacing={2.5} sx={{ mb: 4 }}>
                                <Grid item xs={12} sm={6}>
                                    <Typography variant="caption" sx={{ color: '#475569', fontWeight: 700, mb: 1, display: 'block' }}>
                                        Tahun Anggaran
                                    </Typography>
                                    <FormControl fullWidth size="medium">
                                        <Select 
                                            value={tahun} 
                                            onChange={(e) => setTahun(e.target.value)}
                                            sx={{ borderRadius: 2.5, bgcolor: '#f8fafc' }}
                                        >
                                            {[2025, 2026, 2027, 2028, 2029].map(y => (
                                                <MenuItem key={y} value={y}>Tahun {y}</MenuItem>
                                            ))}
                                        </Select>
                                    </FormControl>
                                </Grid>

                                <Grid item xs={12} sm={6}>
                                    <Typography variant="caption" sx={{ color: '#475569', fontWeight: 700, mb: 1, display: 'block' }}>
                                        Periode Pelaporan
                                    </Typography>
                                    <FormControl fullWidth size="medium">
                                        <Select 
                                            value={triwulan} 
                                            onChange={(e) => setTriwulan(e.target.value)}
                                            sx={{ borderRadius: 2.5, bgcolor: '#f8fafc' }}
                                        >
                                            <MenuItem value={1}>Triwulan I (Januari - Maret)</MenuItem>
                                            <MenuItem value={2}>Triwulan II (April - Juni)</MenuItem>
                                            <MenuItem value={3}>Triwulan III (Juli - September)</MenuItem>
                                            <MenuItem value={4}>Triwulan IV (Oktober - Desember)</MenuItem>
                                        </Select>
                                    </FormControl>
                                </Grid>
                            </Grid>

                            {/* Report Specification Details */}
                            <Paper variant="outlined" sx={{ p: 2.5, mb: 4, borderRadius: 2.5, bgcolor: '#f8fafc', borderColor: '#e2e8f0' }}>
                                <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5, mb: 1.5, display: 'block' }}>
                                    Kandungan Dokumen LKjIP Tergenerate
                                </Typography>
                                <Stack spacing={1}>
                                    <Stack direction="row" spacing={1} alignItems="center">
                                        <CheckIcon sx={{ fontSize: 18, color: '#059669' }} />
                                        <Typography variant="body2" sx={{ color: '#334155', fontWeight: 600 }}>
                                            Cover & Lembar Pengesahan Resmi Jaksa Agung Muda Bidang Pembinaan
                                        </Typography>
                                    </Stack>
                                    <Stack direction="row" spacing={1} alignItems="center">
                                        <CheckIcon sx={{ fontSize: 18, color: '#059669' }} />
                                        <Typography variant="body2" sx={{ color: '#334155', fontWeight: 600 }}>
                                            Matriks Kinerja 6 Sasaran Program (SP) & 18 IKP Renstra
                                        </Typography>
                                    </Stack>
                                    <Stack direction="row" spacing={1} alignItems="center">
                                        <CheckIcon sx={{ fontSize: 18, color: '#059669' }} />
                                        <Typography variant="body2" sx={{ color: '#334155', fontWeight: 600 }}>
                                            Uraian Analisis Capaian, Kendala Riil, dan Rencana Aksi per Satker
                                        </Typography>
                                    </Stack>
                                </Stack>
                            </Paper>

                            <Button 
                                fullWidth
                                variant="contained" 
                                size="large"
                                startIcon={<DownloadIcon />}
                                onClick={handleDownload}
                                disabled={downloading}
                                sx={{ 
                                    py: 1.6,
                                    borderRadius: 2.5,
                                    fontWeight: 700,
                                    fontSize: '1rem',
                                    bgcolor: '#059669',
                                    color: '#ffffff',
                                    background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                                    boxShadow: '0 4px 14px rgba(5, 150, 105, 0.4)',
                                    '&:hover': {
                                        background: 'linear-gradient(135deg, #047857 0%, #059669 100%)',
                                        boxShadow: '0 6px 20px rgba(5, 150, 105, 0.6)'
                                    }
                                }}
                            >
                                {downloading ? 'Menyiapkan Dokumen...' : `Download LKjIP Tahun ${tahun} (TW ${triwulan}) .DOCX`}
                            </Button>
                        </CardContent>
                    </Card>
                </Grid>
            </Grid>
        </AppLayout>
    );
}

