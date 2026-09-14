import { Head, Link } from '@inertiajs/react';
import { 
    Box, Container, Typography, Button, Grid, Card, CardContent, 
    Stack, Chip, Paper, Divider 
} from '@mui/material';
import {
    Shield as ShieldIcon,
    AccountTree as CascadingIcon,
    CalculateOutlined as CalculateIcon,
    DescriptionOutlined as ExportIcon,
    ArrowForward as ArrowForwardIcon,
    Login as LoginIcon,
    Dashboard as DashboardIcon,
    CheckCircle as CheckIcon,
    Business as BusinessIcon
} from '@mui/icons-material';
import { motion } from 'framer-motion';

const biroList = [
    { code: 'RO-REN', name: 'Biro Perencanaan', desc: 'Pengampu IKP SAKIP, NKA, IPA & Cascading Kinerja' },
    { code: 'RO-PEG', name: 'Biro Kepegawaian', desc: 'Pengampu IKP Merit Sistem, Manajemen Talenta & SDM' },
    { code: 'RO-KEU', name: 'Biro Keuangan', desc: 'Pengampu IKP Akuntabilitas Keuangan & Tindak Lanjut BPK' },
    { code: 'RO-KAP', name: 'Biro Perlengkapan', desc: 'Pengampu IKP Pengadaan Barang/Jasa & Sarana Prasarana' },
    { code: 'RO-HUK-HLN', name: 'Biro Hukum & HLN', desc: 'Pengampu IKP Harmonisasi Regulasi & Kerja Sama Luar Negeri' },
    { code: 'RO-UMUM', name: 'Biro Umum', desc: 'Pengampu IKP Tata Kelola Administrasi & Kearsipan' },
    { code: 'PUSDASKRIMTI', name: 'Pusat Daskrimti', desc: 'Pengampu IKP Digitalisasi Proses Bisnis Kejaksaan' },
    { code: 'PUSTRAJAKGAKUM', name: 'Pusat Trajak Gakum', desc: 'Pengampu IKP Kajian Kebijakan Strategis Penegakan Hukum' },
    { code: 'PKY', name: 'Pusat Pelayanan Kesehatan', desc: 'Pengampu IKP Layanan Kesehatan Adhyaksa' },
];

export default function Welcome({ auth }) {
    const isLoggedIn = !!auth?.user;

    return (
        <Box sx={{ minHeight: '100vh', bgcolor: '#0f172a', color: '#ffffff', overflow: 'hidden' }}>
            <Head title="Sistem e-LKjIP JAMBIN — Kejaksaan RI" />

            {/* Background Decorative Gradient Blobs */}
            <Box sx={{
                position: 'absolute',
                top: '-15%',
                left: '20%',
                width: '600px',
                height: '600px',
                borderRadius: '50%',
                background: 'radial-gradient(circle, rgba(5, 150, 105, 0.25) 0%, rgba(15, 23, 42, 0) 70%)',
                filter: 'blur(60px)',
                pointerEvents: 'none'
            }} />
            <Box sx={{
                position: 'absolute',
                top: '30%',
                right: '-10%',
                width: '500px',
                height: '500px',
                borderRadius: '50%',
                background: 'radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, rgba(15, 23, 42, 0) 70%)',
                filter: 'blur(70px)',
                pointerEvents: 'none'
            }} />

            {/* Navbar */}
            <Container maxWidth="lg">
                <Box sx={{ py: 3, display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                    <Stack direction="row" spacing={1.5} alignItems="center">
                        <Box sx={{
                            width: 44,
                            height: 44,
                            borderRadius: '12px',
                            background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            boxShadow: '0 4px 16px rgba(5, 150, 105, 0.4)'
                        }}>
                            <ShieldIcon sx={{ fontSize: 26, color: 'white' }} />
                        </Box>
                        <Box>
                            <Stack direction="row" spacing={1} alignItems="center">
                                <Typography variant="h6" fontWeight={800} sx={{ letterSpacing: '-0.02em', color: '#ffffff' }}>
                                    e-LKjIP
                                </Typography>
                                <Chip label="JAMBIN" size="small" sx={{ height: 20, fontWeight: 800, bgcolor: 'rgba(245, 158, 11, 0.2)', color: '#f59e0b', border: '1px solid rgba(245, 158, 11, 0.4)' }} />
                            </Stack>
                            <Typography variant="caption" sx={{ color: '#94a3b8', fontWeight: 600 }}>
                                KEJAKSAAN AGUNG REPUBLIK INDONESIA
                            </Typography>
                        </Box>
                    </Stack>

                    <Stack direction="row" spacing={1.5}>
                        {isLoggedIn ? (
                            <Button 
                                component={Link} 
                                href={route('dashboard')} 
                                variant="contained" 
                                color="secondary" 
                                startIcon={<DashboardIcon />}
                                sx={{ borderRadius: 2.5, px: 3, py: 1 }}
                            >
                                Buka Dashboard
                            </Button>
                        ) : (
                            <Button 
                                component={Link} 
                                href={route('login')} 
                                variant="contained" 
                                color="secondary" 
                                startIcon={<LoginIcon />}
                                sx={{ borderRadius: 2.5, px: 3.5, py: 1 }}
                            >
                                Masuk (Login)
                            </Button>
                        )}
                    </Stack>
                </Box>
            </Container>

            {/* Hero Section */}
            <Container maxWidth="lg" sx={{ pt: { xs: 6, md: 10 }, pb: { xs: 8, md: 12 }, position: 'relative' }}>
                <Box sx={{ textAlign: 'center', maxWidth: 840, mx: 'auto' }} component={motion.div} initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.6 }}>
                    <Chip 
                        label="Renstra Kejaksaan RI 2025–2029 & Kepja 1184 Tahun 2025" 
                        size="small" 
                        sx={{ 
                            mb: 3, 
                            py: 2, 
                            px: 1.5,
                            bgcolor: 'rgba(5, 150, 105, 0.15)', 
                            color: '#34d399', 
                            border: '1px solid rgba(5, 150, 105, 0.3)',
                            fontWeight: 700,
                            fontSize: '0.8rem'
                        }} 
                    />
                    
                    <Typography variant="h2" sx={{ 
                        fontWeight: 800, 
                        fontSize: { xs: '2.25rem', sm: '3.25rem', md: '3.75rem' },
                        lineHeight: 1.15,
                        letterSpacing: '-0.03em',
                        background: 'linear-gradient(180deg, #ffffff 0%, #cbd5e1 100%)',
                        WebkitBackgroundClip: 'text',
                        WebkitTextFillColor: 'transparent',
                        mb: 2.5
                    }}>
                        Pengukuran Kinerja & Akuntabilitas Terintegrasi
                    </Typography>

                    <Typography variant="body1" sx={{ color: '#94a3b8', fontSize: { xs: '1rem', md: '1.15rem' }, lineHeight: 1.7, mb: 4.5, maxWidth: 700, mx: 'auto' }}>
                        Portal resmi sistem e-LKjIP Jaksa Agung Muda Bidang Pembinaan. Mengimplementasikan kalkulasi cascading canonical, validasi formula indikator, dan pelaporan akuntabilitas kinerja instansi pemerintah.
                    </Typography>

                    <Stack direction={{ xs: 'column', sm: 'row' }} spacing={2} justifyContent="center">
                        <Button 
                            component={Link} 
                            href={isLoggedIn ? route('dashboard') : route('login')} 
                            variant="contained" 
                            size="large"
                            color="secondary"
                            endIcon={<ArrowForwardIcon />}
                            sx={{ py: 1.5, px: 4, fontSize: '1rem', borderRadius: 3 }}
                        >
                            {isLoggedIn ? 'Masuk ke Dashboard' : 'Mulai Input Kinerja'}
                        </Button>
                    </Stack>
                </Box>

                {/* 3 Core Architecture Cards */}
                <Grid container spacing={3} sx={{ mt: { xs: 6, md: 10 } }}>
                    <Grid item xs={12} md={4}>
                        <Paper sx={{ 
                            p: 3.5, 
                            height: '100%', 
                            borderRadius: 4, 
                            bgcolor: 'rgba(30, 41, 59, 0.7)', 
                            border: '1px solid rgba(51, 65, 85, 0.8)',
                            backdropFilter: 'blur(12px)',
                            transition: 'all 0.3s ease',
                            '&:hover': {
                                transform: 'translateY(-4px)',
                                borderColor: '#10b981',
                                boxShadow: '0 12px 30px -4px rgba(5, 150, 105, 0.2)'
                            }
                        }}>
                            <Box sx={{ width: 48, height: 48, borderRadius: 3, bgcolor: 'rgba(5, 150, 105, 0.2)', display: 'flex', alignItems: 'center', justifyContent: 'center', mb: 2.5 }}>
                                <CascadingIcon sx={{ color: '#34d399', fontSize: 28 }} />
                            </Box>
                            <Typography variant="h6" fontWeight={700} sx={{ color: '#ffffff', mb: 1 }}>
                                Canonical Cascading V3
                            </Typography>
                            <Typography variant="body2" sx={{ color: '#94a3b8', lineHeight: 1.6 }}>
                                Penjenjangan 11 Sasaran Program, 19 IKP, SK, dan IKK dengan pemisahan tegas antara hierarki kinerja dan ketergantungan kalkulasi.
                            </Typography>
                        </Paper>
                    </Grid>

                    <Grid item xs={12} md={4}>
                        <Paper sx={{ 
                            p: 3.5, 
                            height: '100%', 
                            borderRadius: 4, 
                            bgcolor: 'rgba(30, 41, 59, 0.7)', 
                            border: '1px solid rgba(51, 65, 85, 0.8)',
                            backdropFilter: 'blur(12px)',
                            transition: 'all 0.3s ease',
                            '&:hover': {
                                transform: 'translateY(-4px)',
                                borderColor: '#38bdf8',
                                boxShadow: '0 12px 30px -4px rgba(56, 189, 248, 0.2)'
                            }
                        }}>
                            <Box sx={{ width: 48, height: 48, borderRadius: 3, bgcolor: 'rgba(56, 189, 248, 0.2)', display: 'flex', alignItems: 'center', justifyContent: 'center', mb: 2.5 }}>
                                <CalculateIcon sx={{ color: '#38bdf8', fontSize: 28 }} />
                            </Box>
                            <Typography variant="h6" fontWeight={700} sx={{ color: '#ffffff', mb: 1 }}>
                                Formula-Aware Engine
                            </Typography>
                            <Typography variant="body2" sx={{ color: '#94a3b8', lineHeight: 1.6 }}>
                                Otomasi kalkulasi realisasi dan capaian target untuk SAKIP, IPA (8 komponen berbobot), rasio kepatuhan SOP, survei indeks, dan snapshot historis.
                            </Typography>
                        </Paper>
                    </Grid>

                    <Grid item xs={12} md={4}>
                        <Paper sx={{ 
                            p: 3.5, 
                            height: '100%', 
                            borderRadius: 4, 
                            bgcolor: 'rgba(30, 41, 59, 0.7)', 
                            border: '1px solid rgba(51, 65, 85, 0.8)',
                            backdropFilter: 'blur(12px)',
                            transition: 'all 0.3s ease',
                            '&:hover': {
                                transform: 'translateY(-4px)',
                                borderColor: '#f59e0b',
                                boxShadow: '0 12px 30px -4px rgba(245, 158, 11, 0.2)'
                            }
                        }}>
                            <Box sx={{ width: 48, height: 48, borderRadius: 3, bgcolor: 'rgba(245, 158, 11, 0.2)', display: 'flex', alignItems: 'center', justifyContent: 'center', mb: 2.5 }}>
                                <ExportIcon sx={{ color: '#f59e0b', fontSize: 28 }} />
                            </Box>
                            <Typography variant="h6" fontWeight={700} sx={{ color: '#ffffff', mb: 1 }}>
                                Ekspor Laporan LKjIP
                            </Typography>
                            <Typography variant="body2" sx={{ color: '#94a3b8', lineHeight: 1.6 }}>
                                Penjanaan dokumen laporan LKjIP resmi format Microsoft Word (DOCX) sesuai standar pelaporan Renstra Kejaksaan RI.
                            </Typography>
                        </Paper>
                    </Grid>
                </Grid>

                {/* Unit Kerja Directory Section */}
                <Box sx={{ mt: { xs: 8, md: 12 } }}>
                    <Box sx={{ textAlign: 'center', mb: 4 }}>
                        <Typography variant="overline" sx={{ color: '#10b981', fontWeight: 800, letterSpacing: '0.1em' }}>
                            Satuan Kerja Lingkup JAMBIN
                        </Typography>
                        <Typography variant="h4" fontWeight={800} sx={{ color: '#ffffff', mt: 0.5 }}>
                            Biro & Pusat Pengampu Kinerja
                        </Typography>
                    </Box>

                    <Grid container spacing={2}>
                        {biroList.map((biro) => (
                            <Grid item xs={12} sm={6} md={4} key={biro.code}>
                                <Box sx={{ 
                                    p: 2.5, 
                                    borderRadius: 3, 
                                    bgcolor: 'rgba(30, 41, 59, 0.5)', 
                                    border: '1px solid rgba(51, 65, 85, 0.6)',
                                    display: 'flex',
                                    flexDirection: 'column',
                                    height: '100%'
                                }}>
                                    <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1 }}>
                                        <BusinessIcon sx={{ fontSize: 18, color: '#10b981' }} />
                                        <Typography variant="subtitle2" fontWeight={700} sx={{ color: '#ffffff' }}>
                                            {biro.name}
                                        </Typography>
                                    </Stack>
                                    <Typography variant="caption" sx={{ color: '#94a3b8', lineHeight: 1.5 }}>
                                        {biro.desc}
                                    </Typography>
                                </Box>
                            </Grid>
                        ))}
                    </Grid>
                </Box>
            </Container>

            {/* Footer */}
            <Box sx={{ borderTop: '1px solid rgba(51, 65, 85, 0.6)', py: 4, mt: 8, bgcolor: 'rgba(15, 23, 42, 0.95)' }}>
                <Container maxWidth="lg">
                    <Stack direction={{ xs: 'column', sm: 'row' }} justifyContent="space-between" alignItems="center" spacing={2}>
                        <Typography variant="body2" sx={{ color: '#64748b' }}>
                            &copy; 2026 Jaksa Agung Muda Bidang Pembinaan (JAMBIN) — Kejaksaan Republik Indonesia
                        </Typography>
                        <Typography variant="caption" sx={{ color: '#64748b' }}>
                            Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP / e-LKjIP)
                        </Typography>
                    </Stack>
                </Container>
            </Box>
        </Box>
    );
}
