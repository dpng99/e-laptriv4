import { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    Grid, Card, CardContent, Typography, Box, Paper, LinearProgress,
    Chip, Stack, Button, Divider, ToggleButtonGroup, ToggleButton
} from '@mui/material';
import {
    AssignmentTurnedIn as AssignmentTurnedInIcon,
    Storage as StorageIcon,
    DataUsage as DataUsageIcon,
    CheckCircle as CheckCircleIcon,
    Warning as WarningIcon,
    HelpOutlineOutlined as HelpIcon,
    EditNote as EditNoteIcon,
    Speed as SpeedIcon,
    BarChart as BarChartIcon,
    PieChart as PieChartIcon,
    TrendingUp as TrendingUpIcon,
    ArrowForward as ArrowForwardIcon
} from '@mui/icons-material';
import { motion } from 'framer-motion';
import { PieChart } from '@mui/x-charts/PieChart';
import { BarChart } from '@mui/x-charts/BarChart';

const itemVariants = {
    hidden: { opacity: 0, y: 15 },
    visible: { opacity: 1, y: 0, transition: { duration: 0.4 } }
};

const containerVariants = {
    hidden: { opacity: 0 },
    visible: {
        opacity: 1,
        transition: { staggerChildren: 0.08 }
    }
};

export default function Dashboard({ 
    unitName, 
    totalSp = 0, 
    totalIkk = 0, 
    ikkTerisi = 0, 
    rataCapaian = 0, 
    currentTahun = 2025, 
    currentTriwulan = 1, 
    statusList = [],
    skPerformance = [],
    stats = {}
}) {
    const actualStats = stats?.total !== undefined ? stats : {
        total: totalIkk || statusList.length,
        terisi: ikkTerisi || 0,
        tercapai: statusList.filter(i => i.status === 'Tercapai').length,
        belum_tercapai: statusList.filter(i => i.status === 'Belum Tercapai' || i.status === 'Tidak Tercapai').length,
        belum_diisi: statusList.filter(i => i.status === 'Belum Diisi').length
    };

    const progress = actualStats.total > 0 ? (actualStats.terisi / actualStats.total) * 100 : 0;

    const handleTriwulanChange = (event, newTw) => {
        if (newTw !== null && newTw !== currentTriwulan) {
            router.get(route('dashboard'), { tahun: currentTahun, triwulan: newTw }, { preserveState: true });
        }
    };

    // Data for Status Kinerja Donut Chart
    const statusPieData = [
        { id: 0, value: actualStats.tercapai, label: 'Tercapai', color: '#10b981' },
        { id: 1, value: actualStats.belum_tercapai, label: 'Belum Tercapai', color: '#f59e0b' },
        { id: 2, value: actualStats.belum_diisi, label: 'Belum Diisi', color: '#94a3b8' },
    ].filter(item => item.value > 0);

    // Data for Kelengkapan Pengisian Donut Chart
    const pengisianPieData = [
        { id: 0, value: actualStats.terisi, label: 'Sudah Diisi', color: '#059669' },
        { id: 1, value: Math.max(0, actualStats.total - actualStats.terisi), label: 'Belum Diisi', color: '#ef4444' },
    ].filter(item => item.value > 0);

    // Data for SK Performance Bar Chart
    const skBarData = skPerformance && skPerformance.length > 0 
        ? skPerformance.map(sk => ({
            sk: sk.sk_kode,
            nama: sk.sk_nama,
            capaian: Number(sk.rata_capaian || 0),
            terisi: sk.terisi,
            total: sk.total
        }))
        : [];

    // Data for IKK Performance Bar Chart (all indicators)
    const ikkBarData = statusList.map(item => ({
        ikk: item.kode,
        nama: item.nama,
        capaian: item.capaian !== null && item.capaian !== undefined ? Number(item.capaian) : 0,
        status: item.status
    }));

    return (
        <AppLayout title="Dashboard LKjIP Unit Kerja">
            <Head title={`Dashboard — ${unitName || 'Unit Kerja'}`} />

            {/* Top Hero Banner */}
            <Paper 
                elevation={0}
                sx={{
                    p: { xs: 3, md: 3.5 },
                    mb: 3.5,
                    borderRadius: 3.5,
                    background: 'linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #064e3b 100%)',
                    color: '#ffffff',
                    position: 'relative',
                    overflow: 'hidden',
                    border: '1px solid rgba(255,255,255,0.08)'
                }}
            >
                <Grid container spacing={3} alignItems="center" justifyContent="space-between">
                    <Grid item xs={12} md={7}>
                        <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1.5 }}>
                            <Chip 
                                label={`Tahun ${currentTahun} · Triwulan ${currentTriwulan}`}
                                size="small"
                                sx={{ 
                                    bgcolor: 'rgba(16, 185, 129, 0.2)', 
                                    color: '#34d399', 
                                    fontWeight: 700, 
                                    border: '1px solid rgba(16, 185, 129, 0.4)' 
                                }}
                            />
                            <Chip 
                                label="Unit Operator" 
                                size="small" 
                                sx={{ bgcolor: 'rgba(255,255,255,0.1)', color: '#e2e8f0', fontWeight: 600 }} 
                            />
                        </Stack>

                        <Typography variant="h4" fontWeight={800} sx={{ letterSpacing: -0.5, color: '#f8fafc', mb: 1 }}>
                            Kinerja {unitName}
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#94a3b8', lineHeight: 1.6, maxWidth: 620 }}>
                            Visualisasi diagram capaian kinerja Indikator Kinerja Kegiatan (IKK) dan Sasaran Kegiatan (SK) unit kerja secara komprehensif.
                        </Typography>
                    </Grid>

                    <Grid item xs={12} md={5} sx={{ textAlign: { xs: 'left', md: 'right' } }}>
                        <Stack direction={{ xs: 'column', sm: 'row' }} spacing={1.5} justifyContent={{ md: 'flex-end' }} alignItems="center">
                            {/* Quarter Selector */}
                            <ToggleButtonGroup
                                value={currentTriwulan}
                                exclusive
                                onChange={handleTriwulanChange}
                                size="small"
                                sx={{
                                    bgcolor: 'rgba(255,255,255,0.1)',
                                    borderRadius: 2.5,
                                    border: '1px solid rgba(255,255,255,0.15)',
                                    '& .MuiToggleButton-root': {
                                        color: '#cbd5e1',
                                        fontWeight: 700,
                                        px: 1.8,
                                        py: 0.8,
                                        border: 'none',
                                        fontSize: '0.8rem',
                                        '&.Mui-selected': {
                                            bgcolor: '#10b981',
                                            color: '#ffffff',
                                            '&:hover': { bgcolor: '#059669' }
                                        }
                                    }
                                }}
                            >
                                <ToggleButton value={1}>TW I</ToggleButton>
                                <ToggleButton value={2}>TW II</ToggleButton>
                                <ToggleButton value={3}>TW III</ToggleButton>
                                <ToggleButton value={4}>TW IV</ToggleButton>
                            </ToggleButtonGroup>

                            <Button
                                component={Link}
                                href={route('input-data.index', { tahun: currentTahun, triwulan: currentTriwulan })}
                                variant="contained"
                                size="large"
                                startIcon={<EditNoteIcon />}
                                sx={{
                                    bgcolor: '#059669',
                                    color: '#ffffff',
                                    background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                                    fontWeight: 700,
                                    borderRadius: 2.5,
                                    px: 2.5,
                                    whiteSpace: 'nowrap',
                                    boxShadow: '0 4px 14px rgba(5, 150, 105, 0.4)',
                                    '&:hover': {
                                        background: 'linear-gradient(135deg, #047857 0%, #059669 100%)',
                                    }
                                }}
                            >
                                Input Pengukuran
                            </Button>
                        </Stack>
                    </Grid>
                </Grid>
            </Paper>

            {/* Top KPI Metrics Cards */}
            <Grid container spacing={2.5} component={motion.div} variants={containerVariants} initial="hidden" animate="visible" sx={{ mb: 4 }}>
                {/* SP Card */}
                <Grid item xs={12} sm={6} md={3} component={motion.div} variants={itemVariants}>
                    <Card sx={{ 
                        borderRadius: 3, 
                        border: '1px solid #e2e8f0',
                        boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)',
                        transition: 'transform 0.2s, box-shadow 0.2s',
                        '&:hover': { transform: 'translateY(-3px)', boxShadow: '0 10px 25px -5px rgba(15, 23, 42, 0.1)' }
                    }}>
                        <CardContent sx={{ p: 2.5 }}>
                            <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 1.5 }}>
                                <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                    Sasaran Program
                                </Typography>
                                <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#eff6ff', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#2563eb' }}>
                                    <StorageIcon fontSize="small" />
                                </Box>
                            </Stack>
                            <Typography variant="h3" fontWeight={800} sx={{ color: '#0f172a', lineHeight: 1.1 }}>
                                {totalSp}
                            </Typography>
                            <Typography variant="caption" sx={{ color: '#94a3b8', mt: 1, display: 'block' }}>
                                Total Sasaran Terkait Renstra
                            </Typography>
                        </CardContent>
                    </Card>
                </Grid>

                {/* IKK Total Card */}
                <Grid item xs={12} sm={6} md={3} component={motion.div} variants={itemVariants}>
                    <Card sx={{ 
                        borderRadius: 3, 
                        border: '1px solid #e2e8f0',
                        boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)',
                        transition: 'transform 0.2s, box-shadow 0.2s',
                        '&:hover': { transform: 'translateY(-3px)', boxShadow: '0 10px 25px -5px rgba(15, 23, 42, 0.1)' }
                    }}>
                        <CardContent sx={{ p: 2.5 }}>
                            <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 1.5 }}>
                                <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                    Total Indikator (IKK)
                                </Typography>
                                <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#f0fdfa', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#0d9488' }}>
                                    <DataUsageIcon fontSize="small" />
                                </Box>
                            </Stack>
                            <Typography variant="h3" fontWeight={800} sx={{ color: '#0f172a', lineHeight: 1.1 }}>
                                {actualStats.total}
                            </Typography>
                            <Typography variant="caption" sx={{ color: '#94a3b8', mt: 1, display: 'block' }}>
                                Indikator Unit Pengampu
                            </Typography>
                        </CardContent>
                    </Card>
                </Grid>

                {/* Progress Terisi Card */}
                <Grid item xs={12} sm={6} md={3} component={motion.div} variants={itemVariants}>
                    <Card sx={{ 
                        borderRadius: 3, 
                        border: '1px solid #e2e8f0',
                        boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)',
                        transition: 'transform 0.2s, box-shadow 0.2s',
                        '&:hover': { transform: 'translateY(-3px)', boxShadow: '0 10px 25px -5px rgba(15, 23, 42, 0.1)' }
                    }}>
                        <CardContent sx={{ p: 2.5 }}>
                            <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 1.5 }}>
                                <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                    IKK Terisi
                                </Typography>
                                <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#f0fdf4', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#16a34a' }}>
                                    <AssignmentTurnedInIcon fontSize="small" />
                                </Box>
                            </Stack>
                            <Typography variant="h3" fontWeight={800} sx={{ color: '#059669', lineHeight: 1.1 }}>
                                {actualStats.terisi} <Typography component="span" variant="h6" sx={{ color: '#94a3b8', fontWeight: 600 }}>/ {actualStats.total}</Typography>
                            </Typography>
                            <Box sx={{ mt: 1.5 }}>
                                <LinearProgress 
                                    variant="determinate" 
                                    value={progress} 
                                    sx={{ 
                                        height: 6, 
                                        borderRadius: 3, 
                                        bgcolor: '#e2e8f0', 
                                        '& .MuiLinearProgress-bar': { bgcolor: '#059669', borderRadius: 3 } 
                                    }} 
                                />
                            </Box>
                            <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 600, mt: 0.5, display: 'block' }}>
                                {progress.toFixed(0)}% telah terisi
                            </Typography>
                        </CardContent>
                    </Card>
                </Grid>

                {/* Rata-rata Capaian */}
                <Grid item xs={12} sm={6} md={3} component={motion.div} variants={itemVariants}>
                    <Card sx={{ 
                        borderRadius: 3, 
                        border: '1px solid #e2e8f0',
                        boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)',
                        transition: 'transform 0.2s, box-shadow 0.2s',
                        '&:hover': { transform: 'translateY(-3px)', boxShadow: '0 10px 25px -5px rgba(15, 23, 42, 0.1)' }
                    }}>
                        <CardContent sx={{ p: 2.5 }}>
                            <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 1.5 }}>
                                <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                    Rata-Rata Capaian
                                </Typography>
                                <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#fffbeb', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#d97706' }}>
                                    <SpeedIcon fontSize="small" />
                                </Box>
                            </Stack>
                            <Typography variant="h3" fontWeight={800} sx={{ color: Number(rataCapaian) >= 100 ? '#059669' : '#d97706', lineHeight: 1.1 }}>
                                {rataCapaian}%
                            </Typography>
                            <Typography variant="caption" sx={{ color: '#94a3b8', mt: 1, display: 'block' }}>
                                Rata-rata capaian terhadap target
                            </Typography>
                        </CardContent>
                    </Card>
                </Grid>
            </Grid>

            {/* DIAGRAM SECTION 1: Sebaran Status Ketercapaian & Progres Pengisian */}
            <Grid container spacing={3} sx={{ mb: 4 }}>
                {/* Diagram 1: Status Kinerja Donut Chart */}
                <Grid item xs={12} md={6}>
                    <Paper sx={{ p: 3, height: '100%', borderRadius: 3.5, border: '1px solid #e2e8f0', boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)' }}>
                        <Stack direction="row" spacing={1.5} alignItems="center" sx={{ mb: 0.5 }}>
                            <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#ecfdf5', color: '#059669', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                <PieChartIcon fontSize="small" />
                            </Box>
                            <Box>
                                <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', lineHeight: 1.2 }}>
                                    Sebaran Status Kinerja Indikator (IKK)
                                </Typography>
                                <Typography variant="caption" sx={{ color: '#64748b' }}>
                                    Proporsi indikator tercapai, belum tercapai, dan belum diisi pada TW {currentTriwulan}
                                </Typography>
                            </Box>
                        </Stack>
                        <Divider sx={{ my: 2 }} />

                        <Box sx={{ display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center', minHeight: 280 }}>
                            {statusPieData.length > 0 ? (
                                <>
                                    <PieChart
                                        series={[{ 
                                            data: statusPieData,
                                            highlightScope: { faded: 'global', highlighted: 'item' },
                                            faded: { innerRadius: 30, additionalRadius: -30, color: 'gray' },
                                            innerRadius: 55,
                                            outerRadius: 105,
                                            paddingAngle: 3,
                                            cornerRadius: 6,
                                        }]}
                                        width={420}
                                        height={240}
                                    />
                                    {/* Summary tags below chart */}
                                    <Stack direction="row" spacing={1.5} flexWrap="wrap" justifyContent="center" sx={{ mt: 1 }}>
                                        <Chip 
                                            icon={<CheckCircleIcon sx={{ fontSize: '0.9rem !important' }} />}
                                            label={`Tercapai: ${actualStats.tercapai}`}
                                            size="small"
                                            sx={{ bgcolor: '#ecfdf5', color: '#059669', fontWeight: 700, border: '1px solid #a7f3d0' }}
                                        />
                                        <Chip 
                                            icon={<WarningIcon sx={{ fontSize: '0.9rem !important' }} />}
                                            label={`Belum Tercapai: ${actualStats.belum_tercapai}`}
                                            size="small"
                                            sx={{ bgcolor: '#fffbeb', color: '#d97706', fontWeight: 700, border: '1px solid #fde68a' }}
                                        />
                                        <Chip 
                                            icon={<HelpIcon sx={{ fontSize: '0.9rem !important' }} />}
                                            label={`Belum Diisi: ${actualStats.belum_diisi}`}
                                            size="small"
                                            sx={{ bgcolor: '#f8fafc', color: '#64748b', fontWeight: 700, border: '1px solid #e2e8f0' }}
                                        />
                                    </Stack>
                                </>
                            ) : (
                                <Box sx={{ textAlign: 'center', py: 6 }}>
                                    <Typography color="text.secondary">Belum ada data indikator</Typography>
                                </Box>
                            )}
                        </Box>
                    </Paper>
                </Grid>

                {/* Diagram 2: Kelengkapan Pengisian Realisasi */}
                <Grid item xs={12} md={6}>
                    <Paper sx={{ p: 3, height: '100%', borderRadius: 3.5, border: '1px solid #e2e8f0', boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)' }}>
                        <Stack direction="row" spacing={1.5} alignItems="center" sx={{ mb: 0.5 }}>
                            <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#eff6ff', color: '#2563eb', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                <AssignmentTurnedInIcon fontSize="small" />
                            </Box>
                            <Box>
                                <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', lineHeight: 1.2 }}>
                                    Tingkat Kelengkapan Pengisian Data
                                </Typography>
                                <Typography variant="caption" sx={{ color: '#64748b' }}>
                                    Persentase indikator yang telah diinputkan nilai pengukurannya
                                </Typography>
                            </Box>
                        </Stack>
                        <Divider sx={{ my: 2 }} />

                        <Box sx={{ display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center', minHeight: 280 }}>
                            {pengisianPieData.length > 0 ? (
                                <>
                                    <PieChart
                                        series={[{ 
                                            data: pengisianPieData,
                                            highlightScope: { faded: 'global', highlighted: 'item' },
                                            faded: { innerRadius: 30, additionalRadius: -30, color: 'gray' },
                                            innerRadius: 55,
                                            outerRadius: 105,
                                            paddingAngle: 3,
                                            cornerRadius: 6,
                                        }]}
                                        width={420}
                                        height={240}
                                    />
                                    <Stack direction="row" spacing={1.5} flexWrap="wrap" justifyContent="center" sx={{ mt: 1 }}>
                                        <Chip 
                                            label={`Sudah Diisi: ${actualStats.terisi} (${progress.toFixed(0)}%)`}
                                            size="small"
                                            sx={{ bgcolor: '#ecfdf5', color: '#059669', fontWeight: 700, border: '1px solid #a7f3d0' }}
                                        />
                                        <Chip 
                                            label={`Belum Diisi: ${Math.max(0, actualStats.total - actualStats.terisi)} (${(100 - progress).toFixed(0)}%)`}
                                            size="small"
                                            sx={{ bgcolor: '#fef2f2', color: '#dc2626', fontWeight: 700, border: '1px solid #fecaca' }}
                                        />
                                    </Stack>
                                </>
                            ) : (
                                <Box sx={{ textAlign: 'center', py: 6 }}>
                                    <Typography color="text.secondary">Belum ada data pengisian</Typography>
                                </Box>
                            )}
                        </Box>
                    </Paper>
                </Grid>
            </Grid>

            {/* DIAGRAM SECTION 2: Capaian Kinerja per Sasaran Kegiatan (SK) */}
            <Paper sx={{ p: 3, mb: 4, borderRadius: 3.5, border: '1px solid #e2e8f0', boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)' }}>
                <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 0.5 }}>
                    <Stack direction="row" spacing={1.5} alignItems="center">
                        <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#f5f3ff', color: '#7c3aed', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                            <BarChartIcon fontSize="small" />
                        </Box>
                        <Box>
                            <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', lineHeight: 1.2 }}>
                                Rata-Rata Capaian per Sasaran Kegiatan (SK)
                            </Typography>
                            <Typography variant="caption" sx={{ color: '#64748b' }}>
                                Perbandingan performa capaian agregat pada tiap Sasaran Kegiatan yang diampu
                            </Typography>
                        </Box>
                    </Stack>
                    <Chip 
                        icon={<TrendingUpIcon sx={{ fontSize: '0.9rem !important' }} />}
                        label={`Rata-rata Unit: ${rataCapaian}%`}
                        size="small"
                        sx={{ bgcolor: '#eff6ff', color: '#2563eb', fontWeight: 700, border: '1px solid #bfdbfe' }}
                    />
                </Stack>
                <Divider sx={{ my: 2 }} />

                <Box sx={{ height: 320, width: '100%' }}>
                    {skBarData.length > 0 ? (
                        <BarChart
                            dataset={skBarData}
                            xAxis={[{ 
                                scaleType: 'band', 
                                dataKey: 'sk',
                                tickLabelStyle: { fontSize: 11, fontWeight: 700 }
                            }]}
                            series={[{ 
                                dataKey: 'capaian', 
                                label: 'Rata-Rata Capaian (%)', 
                                color: '#0d9488'
                            }]}
                            height={300}
                            margin={{ top: 20, bottom: 45, left: 55, right: 20 }}
                        />
                    ) : (
                        <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '100%' }}>
                            <Typography color="text.secondary">Belum ada data sasaran kegiatan untuk ditampilkan</Typography>
                        </Box>
                    )}
                </Box>
            </Paper>

            {/* DIAGRAM SECTION 3: Capaian Kinerja Seluruh Indikator IKK */}
            <Paper sx={{ p: 3, mb: 4, borderRadius: 3.5, border: '1px solid #e2e8f0', boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)' }}>
                <Stack direction={{ xs: 'column', sm: 'row' }} justifyContent="space-between" alignItems={{ sm: 'center' }} spacing={1} sx={{ mb: 0.5 }}>
                    <Stack direction="row" spacing={1.5} alignItems="center">
                        <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#fff7ed', color: '#ea580c', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                            <SpeedIcon fontSize="small" />
                        </Box>
                        <Box>
                            <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', lineHeight: 1.2 }}>
                                Capaian Kinerja per Indikator (IKK)
                            </Typography>
                            <Typography variant="caption" sx={{ color: '#64748b' }}>
                                Distribusi persentase capaian seluruh IKK terhadap target Renstra Triwulan {currentTriwulan}
                            </Typography>
                        </Box>
                    </Stack>

                    <Button
                        component={Link}
                        href={route('input-data.index', { tahun: currentTahun, triwulan: currentTriwulan })}
                        size="small"
                        endIcon={<ArrowForwardIcon />}
                        sx={{ fontWeight: 700, textTransform: 'none', color: '#059669', alignSelf: { xs: 'flex-start', sm: 'center' } }}
                    >
                        Buka Menu Pengukuran & Input Data
                    </Button>
                </Stack>
                <Divider sx={{ my: 2 }} />

                <Box sx={{ height: 340, width: '100%' }}>
                    {ikkBarData.length > 0 ? (
                        <BarChart
                            dataset={ikkBarData}
                            xAxis={[{ 
                                scaleType: 'band', 
                                dataKey: 'ikk',
                                tickLabelStyle: { 
                                    angle: -40, 
                                    textAnchor: 'end',
                                    fontSize: 10,
                                    fontWeight: 700
                                }
                            }]}
                            series={[{ 
                                dataKey: 'capaian', 
                                label: 'Capaian (%)', 
                                color: '#2563eb' 
                            }]}
                            height={320}
                            margin={{ top: 20, bottom: 65, left: 55, right: 20 }}
                        />
                    ) : (
                        <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '100%' }}>
                            <Typography color="text.secondary">Belum ada indikator yang terdaftar</Typography>
                        </Box>
                    )}
                </Box>
            </Paper>
        </AppLayout>
    );
}
