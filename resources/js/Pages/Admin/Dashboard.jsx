import { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    Grid, Card, CardContent, Typography, Box, Paper, Chip, Divider, Stack,
    ToggleButton, ToggleButtonGroup, Select, MenuItem, FormControl, Tooltip
} from '@mui/material';
import {
    CheckCircle as CheckCircleIcon,
    Warning as WarningIcon,
    Error as ErrorIcon,
    Dashboard as DashboardIcon,
    Assignment as AssignmentIcon,
    Insights as InsightsIcon,
    TouchApp as TouchAppIcon,
    ArrowForward as ArrowForwardIcon
} from '@mui/icons-material';
import { motion } from 'framer-motion';
import { PieChart } from '@mui/x-charts/PieChart';
import { BarChart } from '@mui/x-charts/BarChart';
import { DataGrid, GridToolbar } from '@mui/x-data-grid';

import IkpDetailModal from './Components/IkpDetailModal';
import UnitMonitoringSection from './Components/UnitMonitoringSection';

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

export default function AdminDashboard({ 
    currentTahun = 2025, 
    currentTriwulan = 1, 
    statusList = [], 
    ikpList = [], 
    unitMonitoring = [], 
    stats = {} 
}) {
    const [modalOpen, setModalOpen] = useState(false);
    const [modalFilter, setModalFilter] = useState('ALL');

    const handleOpenModal = (filterType) => {
        setModalFilter(filterType);
        setModalOpen(true);
    };

    const handlePeriodChange = (newTahun, newTw) => {
        router.get(
            route('admin.dashboard'),
            { tahun: newTahun, triwulan: newTw },
            { preserveState: true }
        );
    };

    // Calculate percentages for Sebaran Status Ketercapaian
    const totalStats = stats.total_indikator || (stats.tercapai + stats.belum_tercapai + stats.belum_diisi) || 1;
    const tercapaiPct = stats.total_indikator > 0 ? ((stats.tercapai / stats.total_indikator) * 100).toFixed(1) : '0.0';
    const belumTercapaiPct = stats.total_indikator > 0 ? ((stats.belum_tercapai / stats.total_indikator) * 100).toFixed(1) : '0.0';
    const belumDiisiPct = stats.total_indikator > 0 ? ((stats.belum_diisi / stats.total_indikator) * 100).toFixed(1) : '0.0';

    // Data for PieChart
    const pieData = [
        { id: 0, value: stats.tercapai, label: `Tercapai (${tercapaiPct}%)`, color: '#10b981' },
        { id: 1, value: stats.belum_tercapai, label: `Belum Tercapai (${belumTercapaiPct}%)`, color: '#f59e0b' },
        { id: 2, value: stats.belum_diisi, label: `Belum Diisi (${belumDiisiPct}%)`, color: '#ef4444' },
    ].filter(item => item.value > 0);

    // Grouping by Unit for BarChart
    const unitPerformance = {};
    statusList.forEach(item => {
        if (!unitPerformance[item.unit]) {
            unitPerformance[item.unit] = { unit: item.unit, capaianRataRata: 0, total: 0 };
        }
        if (item.capaian_terhadap_target !== null && item.capaian_terhadap_target !== undefined) {
            unitPerformance[item.unit].capaianRataRata += Number(item.capaian_terhadap_target);
            unitPerformance[item.unit].total += 1;
        }
    });

    const barData = Object.values(unitPerformance).map(u => ({
        unit: u.unit.length > 18 ? u.unit.substring(0, 18) + '...' : u.unit,
        rataRata: u.total > 0 ? Number((u.capaianRataRata / u.total).toFixed(2)) : 0
    })).sort((a, b) => b.rataRata - a.rataRata).slice(0, 5); // Top 5 Unit

    // DataGrid Columns
    const columns = [
        { 
            field: 'kode', 
            headerName: 'Kode', 
            width: 120,
            renderCell: (params) => (
                <Chip 
                    label={params.value} 
                    size="small" 
                    sx={{ fontWeight: 800, bgcolor: '#0f172a', color: '#ffffff', fontSize: '0.75rem' }} 
                />
            )
        },
        { 
            field: 'tipe', 
            headerName: 'Level', 
            width: 90, 
            renderCell: (params) => (
                <Chip 
                    label={params.value} 
                    size="small" 
                    color={params.value === 'SP' ? 'primary' : (params.value === 'IKP' ? 'info' : (params.value === 'SK' ? 'secondary' : 'default'))} 
                    variant="outlined"
                    sx={{ fontWeight: 700 }}
                />
            )
        },
        { 
            field: 'nama', 
            headerName: 'Nama Sasaran / Indikator', 
            flex: 1, 
            minWidth: 280,
            renderCell: (params) => (
                <Typography variant="body2" fontWeight={600} sx={{ color: '#0f172a', whiteSpace: 'normal', wordBreak: 'break-word', lineHeight: 1.4 }}>
                    {params.value}
                </Typography>
            )
        },
        { 
            field: 'unit', 
            headerName: 'Unit Pengampu', 
            width: 200,
            renderCell: (params) => (
                <Typography variant="caption" sx={{ fontWeight: 600, color: '#64748b' }}>
                    {params.value}
                </Typography>
            )
        },
        { 
            field: 'target', 
            headerName: 'Target', 
            width: 110, 
            renderCell: (params) => (
                <Typography variant="body2" sx={{ fontWeight: 600, color: '#334155' }}>
                    {params.value != null ? params.value : '-'}
                </Typography>
            )
        },
        { 
            field: 'hasil_kinerja', 
            headerName: 'Hasil Kinerja', 
            width: 135, 
            renderCell: (params) => (
                <Typography variant="body2" sx={{ fontWeight: 700, color: '#0f172a' }}>
                    {params.value != null ? params.value : '-'}
                </Typography>
            )
        },
        { 
            field: 'capaian_terhadap_target', 
            headerName: 'Capaian terhadap Target (%)', 
            width: 175, 
            type: 'number', 
            renderCell: (params) => {
                const val = params.value;
                if (val === null || val === undefined) return <Typography variant="caption" color="text.secondary">-</Typography>;
                const color = val >= 100 ? '#059669' : (val >= 80 ? '#d97706' : '#dc2626');
                const bg = val >= 100 ? '#f0fdf4' : (val >= 80 ? '#fffbeb' : '#fef2f2');
                return (
                    <Chip 
                        label={`${Number(val).toFixed(1)}%`} 
                        size="small"
                        sx={{ 
                            fontWeight: 800, 
                            color, 
                            bgcolor: bg, 
                            border: `1px solid ${color}40`,
                            fontSize: '0.8rem'
                        }} 
                    />
                );
            }
        },
        { 
            field: 'status', 
            headerName: 'Status Kinerja', 
            width: 160, 
            renderCell: (params) => {
                let color = 'default';
                let icon = <ErrorIcon fontSize="small" />;
                if (params.value === 'Tercapai') {
                    color = 'success';
                    icon = <CheckCircleIcon fontSize="small" />;
                } else if (params.value === 'Belum Tercapai') {
                    color = 'warning';
                    icon = <WarningIcon fontSize="small" />;
                } else if (params.value === 'Tidak Tercapai') {
                    color = 'error';
                    icon = <ErrorIcon fontSize="small" />;
                }
                return (
                    <Chip 
                        icon={icon} 
                        label={params.value} 
                        color={color} 
                        size="small" 
                        sx={{ fontWeight: 700 }} 
                    />
                );
            }
        }
    ];

    return (
        <AppLayout title="Executive Intelligence Dashboard (BI)">
            <Head title="Executive BI Dashboard" />

            {/* Top Hero Banner with Interactive Period Selectors */}
            <Paper 
                elevation={0}
                sx={{
                    p: { xs: 3, md: 3.5 },
                    mb: 3.5,
                    borderRadius: 3.5,
                    background: 'linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #064e3b 100%)',
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
                                icon={<InsightsIcon sx={{ fontSize: '1rem !important', color: '#38bdf8' }} />}
                                label="Executive Business Intelligence" 
                                size="small" 
                                sx={{ bgcolor: 'rgba(255,255,255,0.1)', color: '#e2e8f0', fontWeight: 600 }} 
                            />
                        </Stack>

                        <Typography variant="h4" fontWeight={800} sx={{ letterSpacing: -0.5, color: '#f8fafc', mb: 1 }}>
                            Monitoring & Analitik Capaian SAKIP JAMBIN
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#94a3b8', lineHeight: 1.6, maxWidth: 680 }}>
                            Konsolidasi analitik tingkat Sasaran Program (SP), Indikator Kinerja Program (IKP), serta monitoring kepatuhan pengisian seluruh unit kerja JAMBIN.
                        </Typography>
                    </Grid>

                    {/* Period Selectors */}
                    <Grid item xs={12} md={5}>
                        <Stack 
                            direction={{ xs: 'column', sm: 'row' }} 
                            spacing={1.5} 
                            justifyContent={{ xs: 'flex-start', md: 'flex-end' }} 
                            alignItems={{ xs: 'stretch', sm: 'center' }}
                        >
                            <FormControl size="small" sx={{ minWidth: 110 }}>
                                <Select
                                    value={currentTahun}
                                    onChange={(e) => handlePeriodChange(e.target.value, currentTriwulan)}
                                    sx={{
                                        bgcolor: 'rgba(255, 255, 255, 0.12)',
                                        color: '#ffffff',
                                        borderRadius: 2.5,
                                        fontWeight: 700,
                                        '& .MuiSvgIcon-root': { color: '#ffffff' },
                                        '& .MuiOutlinedInput-notchedOutline': { borderColor: 'rgba(255, 255, 255, 0.2)' },
                                        '&:hover .MuiOutlinedInput-notchedOutline': { borderColor: 'rgba(255, 255, 255, 0.4)' },
                                    }}
                                >
                                    {[2025, 2026, 2027, 2028, 2029].map((yr) => (
                                        <MenuItem key={yr} value={yr} sx={{ fontWeight: 600 }}>
                                            Tahun {yr}
                                        </MenuItem>
                                    ))}
                                </Select>
                            </FormControl>

                            <ToggleButtonGroup
                                value={currentTriwulan}
                                exclusive
                                onChange={(e, newTw) => {
                                    if (newTw !== null) handlePeriodChange(currentTahun, newTw);
                                }}
                                size="small"
                                sx={{
                                    bgcolor: 'rgba(255, 255, 255, 0.08)',
                                    borderRadius: 2.5,
                                    border: '1px solid rgba(255, 255, 255, 0.15)',
                                    '& .MuiToggleButton-root': {
                                        color: '#cbd5e1',
                                        border: 'none',
                                        px: 1.5,
                                        py: 0.75,
                                        fontWeight: 700,
                                        fontSize: '0.8rem',
                                        '&.Mui-selected': {
                                            bgcolor: '#10b981',
                                            color: '#ffffff',
                                            fontWeight: 800,
                                            '&:hover': { bgcolor: '#059669' }
                                        },
                                        '&:hover': { bgcolor: 'rgba(255, 255, 255, 0.15)' }
                                    }
                                }}
                            >
                                <ToggleButton value={1}>TW 1</ToggleButton>
                                <ToggleButton value={2}>TW 2</ToggleButton>
                                <ToggleButton value={3}>TW 3</ToggleButton>
                                <ToggleButton value={4}>TW 4</ToggleButton>
                            </ToggleButtonGroup>
                        </Stack>
                    </Grid>
                </Grid>
            </Paper>

            {/* Interactive 4 KPI Cards Grid */}
            <Grid container spacing={2.5} component={motion.div} variants={containerVariants} initial="hidden" animate="visible" sx={{ mb: 4 }}>
                {/* Card 1: Total Indikator */}
                <Grid item xs={12} sm={6} md={3} component={motion.div} variants={itemVariants}>
                    <Tooltip title="Klik untuk melihat rincian seluruh 20 IKP" arrow placement="top">
                        <Card 
                            onClick={() => handleOpenModal('ALL')}
                            sx={{ 
                                borderRadius: 3, 
                                border: '1px solid #e2e8f0',
                                boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)',
                                cursor: 'pointer',
                                transition: 'all 0.25s ease',
                                '&:hover': { 
                                    transform: 'translateY(-4px)', 
                                    boxShadow: '0 12px 25px -5px rgba(37, 99, 235, 0.15)',
                                    borderColor: '#93c5fd'
                                }
                            }}
                        >
                            <CardContent sx={{ p: 2.5 }}>
                                <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 1.5 }}>
                                    <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                        Total Indikator (IKP)
                                    </Typography>
                                    <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#eff6ff', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#2563eb' }}>
                                        <DashboardIcon fontSize="small" />
                                    </Box>
                                </Stack>
                                <Typography variant="h3" fontWeight={800} sx={{ color: '#0f172a', lineHeight: 1.1 }}>
                                    {stats.total_indikator}
                                </Typography>
                                <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mt: 1 }}>
                                    <Typography variant="caption" sx={{ color: '#94a3b8' }}>
                                        20 IKP Renstra JAMBIN
                                    </Typography>
                                    <Typography variant="caption" sx={{ color: '#2563eb', fontWeight: 700, display: 'flex', alignItems: 'center', gap: 0.3 }}>
                                        Rincian <ArrowForwardIcon sx={{ fontSize: '0.8rem' }} />
                                    </Typography>
                                </Stack>
                            </CardContent>
                        </Card>
                    </Tooltip>
                </Grid>

                {/* Card 2: Target Tercapai */}
                <Grid item xs={12} sm={6} md={3} component={motion.div} variants={itemVariants}>
                    <Tooltip title="Klik untuk melihat daftar IKP yang targetnya tercapai" arrow placement="top">
                        <Card 
                            onClick={() => handleOpenModal('TERCAPAI')}
                            sx={{ 
                                borderRadius: 3, 
                                border: '1px solid #e2e8f0',
                                boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)',
                                cursor: 'pointer',
                                transition: 'all 0.25s ease',
                                '&:hover': { 
                                    transform: 'translateY(-4px)', 
                                    boxShadow: '0 12px 25px -5px rgba(5, 150, 105, 0.15)',
                                    borderColor: '#a7f3d0'
                                }
                            }}
                        >
                            <CardContent sx={{ p: 2.5 }}>
                                <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 1.5 }}>
                                    <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                        Target Tercapai
                                    </Typography>
                                    <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#f0fdf4', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#16a34a' }}>
                                        <CheckCircleIcon fontSize="small" />
                                    </Box>
                                </Stack>
                                <Typography variant="h3" fontWeight={800} sx={{ color: '#059669', lineHeight: 1.1 }}>
                                    {stats.tercapai}
                                </Typography>
                                <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mt: 1 }}>
                                    <Typography variant="caption" sx={{ color: '#94a3b8' }}>
                                        Capaian &ge; 100% Target
                                    </Typography>
                                    <Typography variant="caption" sx={{ color: '#059669', fontWeight: 700, display: 'flex', alignItems: 'center', gap: 0.3 }}>
                                        Rincian <ArrowForwardIcon sx={{ fontSize: '0.8rem' }} />
                                    </Typography>
                                </Stack>
                            </CardContent>
                        </Card>
                    </Tooltip>
                </Grid>

                {/* Card 3: Belum Tercapai */}
                <Grid item xs={12} sm={6} md={3} component={motion.div} variants={itemVariants}>
                    <Tooltip title="Klik untuk melihat daftar IKP yang belum tercapai" arrow placement="top">
                        <Card 
                            onClick={() => handleOpenModal('BELUM_TERCAPAI')}
                            sx={{ 
                                borderRadius: 3, 
                                border: '1px solid #e2e8f0',
                                boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)',
                                cursor: 'pointer',
                                transition: 'all 0.25s ease',
                                '&:hover': { 
                                    transform: 'translateY(-4px)', 
                                    boxShadow: '0 12px 25px -5px rgba(217, 119, 6, 0.15)',
                                    borderColor: '#fde68a'
                                }
                            }}
                        >
                            <CardContent sx={{ p: 2.5 }}>
                                <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 1.5 }}>
                                    <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                        Belum Tercapai
                                    </Typography>
                                    <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#fffbeb', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#d97706' }}>
                                        <WarningIcon fontSize="small" />
                                    </Box>
                                </Stack>
                                <Typography variant="h3" fontWeight={800} sx={{ color: '#d97706', lineHeight: 1.1 }}>
                                    {stats.belum_tercapai}
                                </Typography>
                                <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mt: 1 }}>
                                    <Typography variant="caption" sx={{ color: '#94a3b8' }}>
                                        Capaian &lt; 100% Target
                                    </Typography>
                                    <Typography variant="caption" sx={{ color: '#d97706', fontWeight: 700, display: 'flex', alignItems: 'center', gap: 0.3 }}>
                                        Rincian <ArrowForwardIcon sx={{ fontSize: '0.8rem' }} />
                                    </Typography>
                                </Stack>
                            </CardContent>
                        </Card>
                    </Tooltip>
                </Grid>
                
                {/* Card 4: Belum Diisi */}
                <Grid item xs={12} sm={6} md={3} component={motion.div} variants={itemVariants}>
                    <Tooltip title="Klik untuk melihat daftar IKP yang belum diisi" arrow placement="top">
                        <Card 
                            onClick={() => handleOpenModal('BELUM_DIISI')}
                            sx={{ 
                                borderRadius: 3, 
                                border: '1px solid #e2e8f0',
                                boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)',
                                cursor: 'pointer',
                                transition: 'all 0.25s ease',
                                '&:hover': { 
                                    transform: 'translateY(-4px)', 
                                    boxShadow: '0 12px 25px -5px rgba(220, 38, 38, 0.15)',
                                    borderColor: '#fecaca'
                                }
                            }}
                        >
                            <CardContent sx={{ p: 2.5 }}>
                                <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 1.5 }}>
                                    <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                        Belum Diisi
                                    </Typography>
                                    <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#fef2f2', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#dc2626' }}>
                                        <AssignmentIcon fontSize="small" />
                                    </Box>
                                </Stack>
                                <Typography variant="h3" fontWeight={800} sx={{ color: '#dc2626', lineHeight: 1.1 }}>
                                    {stats.belum_diisi}
                                </Typography>
                                <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mt: 1 }}>
                                    <Typography variant="caption" sx={{ color: '#94a3b8' }}>
                                        Menunggu input unit kerja
                                    </Typography>
                                    <Typography variant="caption" sx={{ color: '#dc2626', fontWeight: 700, display: 'flex', alignItems: 'center', gap: 0.3 }}>
                                        Rincian <ArrowForwardIcon sx={{ fontSize: '0.8rem' }} />
                                    </Typography>
                                </Stack>
                            </CardContent>
                        </Card>
                    </Tooltip>
                </Grid>
            </Grid>

            {/* Charts Section */}
            <Grid container spacing={3} sx={{ mb: 4 }}>
                {/* Donut Chart: Sebaran Status Ketercapaian with Percentages */}
                <Grid item xs={12} md={5}>
                    <Paper sx={{ p: 3, height: '100%', borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)' }}>
                        <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', mb: 0.5 }}>
                            Sebaran Status Ketercapaian
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#94a3b8', mb: 2 }}>
                            Proporsi status 20 IKP Renstra JAMBIN pada TW {currentTriwulan} {currentTahun}
                        </Typography>
                        <Divider sx={{ mb: 2.5 }} />
                        <Box sx={{ width: '100%', maxWidth: '100%', overflow: 'hidden', display: 'flex', flexDirection: 'column', justifyContent: 'center', alignItems: 'center', minHeight: 250 }}>
                            {pieData.length > 0 ? (
                                <>
                                    <PieChart
                                        series={[{ 
                                            data: pieData,
                                            highlightScope: { faded: 'global', highlighted: 'item' },
                                            faded: { innerRadius: 25, additionalRadius: -25, color: 'gray' },
                                            innerRadius: 45,
                                            outerRadius: 85,
                                            paddingAngle: 3,
                                            cornerRadius: 6,
                                            arcLabel: (item) => `${((item.value / totalStats) * 100).toFixed(0)}%`,
                                            arcLabelMinAngle: 25,
                                        }]}
                                        sx={{
                                            [`& .MuiPieArcLabel-root`]: {
                                                fill: '#ffffff',
                                                fontWeight: 800,
                                                fontSize: '0.75rem',
                                            },
                                        }}
                                        width={320}
                                        height={210}
                                    />
                                    <Stack direction="row" spacing={1} flexWrap="wrap" justifyContent="center" sx={{ mt: 1.5 }}>
                                        <Chip 
                                            icon={<CheckCircleIcon sx={{ fontSize: '0.85rem !important' }} />}
                                            label={`Tercapai: ${stats.tercapai} (${tercapaiPct}%)`}
                                            size="small"
                                            sx={{ bgcolor: '#ecfdf5', color: '#059669', fontWeight: 700, border: '1px solid #a7f3d0' }}
                                        />
                                        <Chip 
                                            icon={<WarningIcon sx={{ fontSize: '0.85rem !important' }} />}
                                            label={`Belum Tercapai: ${stats.belum_tercapai} (${belumTercapaiPct}%)`}
                                            size="small"
                                            sx={{ bgcolor: '#fffbeb', color: '#d97706', fontWeight: 700, border: '1px solid #fde68a' }}
                                        />
                                        <Chip 
                                            icon={<AssignmentIcon sx={{ fontSize: '0.85rem !important' }} />}
                                            label={`Belum Diisi: ${stats.belum_diisi} (${belumDiisiPct}%)`}
                                            size="small"
                                            sx={{ bgcolor: '#fef2f2', color: '#dc2626', fontWeight: 700, border: '1px solid #fecaca' }}
                                        />
                                    </Stack>
                                </>
                            ) : (
                                <Typography color="text.secondary">Tidak ada data untuk ditampilkan</Typography>
                            )}
                        </Box>
                    </Paper>
                </Grid>

                {/* Top Unit Bar Chart */}
                <Grid item xs={12} md={7}>
                    <Paper sx={{ p: 3, height: '100%', borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)' }}>
                        <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', mb: 0.5 }}>
                            Top 5 Unit dengan Rata-rata Capaian Tertinggi
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#94a3b8', mb: 2 }}>
                            Performa rata-rata capaian kinerja per unit pengampu
                        </Typography>
                        <Divider sx={{ mb: 2.5 }} />
                        <Box sx={{ height: 260 }}>
                            {barData.length > 0 ? (
                                <BarChart
                                    dataset={barData}
                                    xAxis={[{ scaleType: 'band', dataKey: 'unit' }]}
                                    series={[{ dataKey: 'rataRata', label: 'Rata-rata Capaian (%)', color: '#059669' }]}
                                    height={250}
                                    margin={{ top: 15, bottom: 35, left: 45, right: 15 }}
                                />
                            ) : (
                                <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '100%' }}>
                                    <Typography color="text.secondary">Belum ada data capaian unit</Typography>
                                </Box>
                            )}
                        </Box>
                    </Paper>
                </Grid>
            </Grid>

            {/* Monitoring Pengisian Biro & Pusat Section */}
            <UnitMonitoringSection 
                unitMonitoring={unitMonitoring}
                currentTahun={currentTahun}
                currentTriwulan={currentTriwulan}
            />

            {/* Comprehensive DataGrid Section */}
            <Paper sx={{ borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -3px rgba(15, 23, 42, 0.05)', overflow: 'hidden' }}>
                <Box sx={{ p: 3, borderBottom: '1px solid #e2e8f0', bgcolor: '#f8fafc' }}>
                    <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                        Detail Seluruh Sasaran & Indikator (SP, IKP, SK, IKK)
                    </Typography>
                    <Typography variant="body2" sx={{ color: '#64748b', mt: 0.5 }}>
                        Tabel pemantauan komprehensif seluruh tingkatan kinerja di lingkungan JAMBIN.
                    </Typography>
                </Box>
                <Box sx={{ height: 550, width: '100%' }}>
                    <DataGrid
                        rows={statusList}
                        columns={columns}
                        getRowHeight={() => 'auto'}
                        initialState={{
                            pagination: {
                                paginationModel: { pageSize: 10 },
                            },
                        }}
                        pageSizeOptions={[5, 10, 25, 50]}
                        disableRowSelectionOnClick
                        slots={{ toolbar: GridToolbar }}
                        slotProps={{
                            toolbar: {
                                showQuickFilter: true,
                                quickFilterProps: { debounceMs: 500 },
                            },
                        }}
                        sx={{
                            border: 'none',
                            '& .MuiDataGrid-cell': {
                                borderBottom: '1px solid #f1f5f9',
                                py: 1.5,
                                whiteSpace: 'normal',
                                wordBreak: 'break-word',
                            },
                            '& .MuiDataGrid-columnHeaders': {
                                backgroundColor: '#f8fafc',
                                borderBottom: '2px solid #e2e8f0',
                                fontWeight: 800,
                                color: '#0f172a'
                            },
                            '& .MuiDataGrid-toolbarContainer': {
                                padding: 2,
                                borderBottom: '1px solid #e2e8f0',
                                bgcolor: '#ffffff'
                            }
                        }}
                    />
                </Box>
            </Paper>

            {/* IkpDetailModal for Card Click Drilldown */}
            <IkpDetailModal
                open={modalOpen}
                onClose={() => setModalOpen(false)}
                statusFilter={modalFilter}
                ikpList={ikpList}
                currentTahun={currentTahun}
                currentTriwulan={currentTriwulan}
            />
        </AppLayout>
    );
}
