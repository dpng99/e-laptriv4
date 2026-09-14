import { Head } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    Grid, Card, CardContent, Typography, Box, Paper, Chip, Divider, Stack
} from '@mui/material';
import {
    CheckCircle as CheckCircleIcon,
    Warning as WarningIcon,
    Error as ErrorIcon,
    Dashboard as DashboardIcon,
    Assignment as AssignmentIcon,
    Insights as InsightsIcon,
    Equalizer as EqualizerIcon
} from '@mui/icons-material';
import { motion } from 'framer-motion';
import { PieChart } from '@mui/x-charts/PieChart';
import { BarChart } from '@mui/x-charts/BarChart';
import { DataGrid, GridToolbar } from '@mui/x-data-grid';

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

export default function AdminDashboard({ currentTahun, currentTriwulan, statusList = [], stats }) {
    
    // Data for PieChart
    const pieData = [
        { id: 0, value: stats.tercapai, label: 'Tercapai', color: '#10b981' },
        { id: 1, value: stats.belum_tercapai, label: 'Belum Tercapai', color: '#f59e0b' },
        { id: 2, value: stats.belum_diisi, label: 'Belum Diisi', color: '#ef4444' },
    ].filter(item => item.value > 0);

    // Grouping by Unit for BarChart
    const unitPerformance = {};
    statusList.forEach(item => {
        if (!unitPerformance[item.unit]) {
            unitPerformance[item.unit] = { unit: item.unit, capaianRataRata: 0, total: 0 };
        }
        if (item.capaian !== null && item.capaian !== undefined) {
            unitPerformance[item.unit].capaianRataRata += Number(item.capaian);
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
                    color={params.value === 'SP' ? 'primary' : 'secondary'} 
                    variant="outlined"
                    sx={{ fontWeight: 700 }}
                />
            )
        },
        { 
            field: 'nama', 
            headerName: 'Nama Sasaran / Indikator', 
            flex: 1, 
            minWidth: 320,
            renderCell: (params) => (
                <Typography variant="body2" fontWeight={600} sx={{ color: '#0f172a' }}>
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
            field: 'realisasi', 
            headerName: 'Realisasi', 
            width: 110, 
            renderCell: (params) => (
                <Typography variant="body2" sx={{ fontWeight: 700, color: '#0f172a' }}>
                    {params.value != null ? params.value : '-'}
                </Typography>
            )
        },
        { 
            field: 'capaian', 
            headerName: 'Capaian (%)', 
            width: 140, 
            type: 'number', 
            renderCell: (params) => {
                const val = params.value;
                if (val === null || val === undefined) return <Typography variant="caption" color="text.secondary">-</Typography>;
                const color = val >= 100 ? '#059669' : (val >= 80 ? '#d97706' : '#dc2626');
                const bg = val >= 100 ? '#f0fdf4' : (val >= 80 ? '#fffbeb' : '#fef2f2');
                return (
                    <Chip 
                        label={`${val}%`} 
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

            {/* Top Hero Banner */}
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
                    <Grid item xs={12} md={8}>
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
                            Konsolidasi analitik tingkat Sasaran Program (SP), Sasaran Kegiatan (SK), dan seluruh Indikator Penunjang unit kerja di lingkungan Jaksa Agung Muda Bidang Pembinaan.
                        </Typography>
                    </Grid>
                </Grid>
            </Paper>

            {/* KPI Cards Grid */}
            <Grid container spacing={2.5} component={motion.div} variants={containerVariants} initial="hidden" animate="visible" sx={{ mb: 4 }}>
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
                                    Total Indikator
                                </Typography>
                                <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#eff6ff', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#2563eb' }}>
                                    <DashboardIcon fontSize="small" />
                                </Box>
                            </Stack>
                            <Typography variant="h3" fontWeight={800} sx={{ color: '#0f172a', lineHeight: 1.1 }}>
                                {stats.total_indikator}
                            </Typography>
                            <Typography variant="caption" sx={{ color: '#94a3b8', mt: 1, display: 'block' }}>
                                SP dan SK Renstra 2025–2029
                            </Typography>
                        </CardContent>
                    </Card>
                </Grid>

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
                                    Target Tercapai
                                </Typography>
                                <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#f0fdf4', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#16a34a' }}>
                                    <CheckCircleIcon fontSize="small" />
                                </Box>
                            </Stack>
                            <Typography variant="h3" fontWeight={800} sx={{ color: '#059669', lineHeight: 1.1 }}>
                                {stats.tercapai}
                            </Typography>
                            <Typography variant="caption" sx={{ color: '#94a3b8', mt: 1, display: 'block' }}>
                                Capaian &ge; 100% Target
                            </Typography>
                        </CardContent>
                    </Card>
                </Grid>

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
                                    Belum Tercapai
                                </Typography>
                                <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#fffbeb', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#d97706' }}>
                                    <WarningIcon fontSize="small" />
                                </Box>
                            </Stack>
                            <Typography variant="h3" fontWeight={800} sx={{ color: '#d97706', lineHeight: 1.1 }}>
                                {stats.belum_tercapai}
                            </Typography>
                            <Typography variant="caption" sx={{ color: '#94a3b8', mt: 1, display: 'block' }}>
                                Capaian &lt; 100% Target
                            </Typography>
                        </CardContent>
                    </Card>
                </Grid>
                
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
                                    Belum Diisi
                                </Typography>
                                <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#fef2f2', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#dc2626' }}>
                                    <AssignmentIcon fontSize="small" />
                                </Box>
                            </Stack>
                            <Typography variant="h3" fontWeight={800} sx={{ color: '#dc2626', lineHeight: 1.1 }}>
                                {stats.belum_diisi}
                            </Typography>
                            <Typography variant="caption" sx={{ color: '#94a3b8', mt: 1, display: 'block' }}>
                                Menunggu input unit kerja
                            </Typography>
                        </CardContent>
                    </Card>
                </Grid>
            </Grid>

            {/* Charts Section */}
            <Grid container spacing={3} sx={{ mb: 4 }}>
                {/* Donut Chart */}
                <Grid item xs={12} md={5}>
                    <Paper sx={{ p: 3, height: '100%', borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)' }}>
                        <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', mb: 0.5 }}>
                            Sebaran Status Ketercapaian
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#94a3b8', mb: 2 }}>
                            Proporsi indikator SP & SK pada triwulan aktif
                        </Typography>
                        <Divider sx={{ mb: 3 }} />
                        <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: 260 }}>
                            {pieData.length > 0 ? (
                                <PieChart
                                    series={[{ 
                                        data: pieData,
                                        highlightScope: { faded: 'global', highlighted: 'item' },
                                        faded: { innerRadius: 30, additionalRadius: -30, color: 'gray' },
                                        innerRadius: 50,
                                        outerRadius: 105,
                                        paddingAngle: 3,
                                        cornerRadius: 6,
                                    }]}
                                    width={380}
                                    height={240}
                                />
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
                            Performa rata-rata indikator per unit pengampu
                        </Typography>
                        <Divider sx={{ mb: 3 }} />
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

            {/* DataGrid Section */}
            <Paper sx={{ borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -3px rgba(15, 23, 42, 0.05)', overflow: 'hidden' }}>
                <Box sx={{ p: 3, borderBottom: '1px solid #e2e8f0', bgcolor: '#f8fafc' }}>
                    <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                        Detail Capaian Indikator (SP dan SK)
                    </Typography>
                    <Typography variant="body2" sx={{ color: '#64748b', mt: 0.5 }}>
                        Tabel pemantauan komprehensif seluruh indikator tingkat program dan kegiatan.
                    </Typography>
                </Box>
                <Box sx={{ height: 550, width: '100%' }}>
                    <DataGrid
                        rows={statusList}
                        columns={columns}
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
        </AppLayout>
    );
}

