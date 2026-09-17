import { useState } from 'react';
import { Head, router, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    Box, Paper, FormControl, InputLabel, Select, MenuItem, Chip, 
    Typography, Grid, Card, CardContent, Stack, Tooltip, Button, IconButton 
} from '@mui/material';
import { DataGrid, GridToolbar } from '@mui/x-data-grid';
import {
    TrendingUp as TrendingUpIcon,
    Assessment as AssessmentIcon,
    Storage as StorageIcon,
    HelpOutlineOutlined as HelpIcon,
    CheckCircle as CheckCircleIcon,
    Warning as WarningIcon,
    Error as ErrorIcon,
    Visibility as VisibilityIcon,
    Tune as TuneIcon
} from '@mui/icons-material';
import { motion } from 'framer-motion';

const LEVEL_COLOR = {
    SP:  'primary',
    IKP: 'info',
    SK:  'secondary',
    IKK: 'default'
};

const STATUS_CHIP = {
    'Tercapai':       { color: 'success', icon: <CheckCircleIcon fontSize="small" /> },
    'Belum Tercapai': { color: 'warning', icon: <WarningIcon fontSize="small" /> },
    'Tidak Tercapai': { color: 'error', icon: <ErrorIcon fontSize="small" /> },
    'Belum Diisi':    { color: 'default', icon: <HelpIcon fontSize="small" /> },
};

export default function ReviewData({ data = [], summary = {}, currentTahun, currentTriwulan }) {
    const [tahun, setTahun]       = useState(currentTahun);
    const [triwulan, setTriwulan] = useState(currentTriwulan);

    const handleFilterChange = (field, val) => {
        if (field === 'tahun') {
            setTahun(val);
            router.get(route('review-data.index'), { tahun: val, triwulan });
        } else {
            setTriwulan(val);
            router.get(route('review-data.index'), { tahun, triwulan: val });
        }
    };

    const columns = [
        { 
            field: 'kode_indikator', 
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
            field: 'nama_kinerja', 
            headerName: 'Nama Indikator / Sasaran', 
            flex: 1, 
            minWidth: 280,
            renderCell: (params) => (
                <Typography variant="body2" fontWeight={600} sx={{ color: '#0f172a' }}>
                    {params.value}
                </Typography>
            )
        },
        {
            field: 'tipe_indikator',
            headerName: 'Level',
            width: 90,
            renderCell: (params) => (
                <Chip 
                    label={params.value} 
                    size="small" 
                    color={LEVEL_COLOR[params.value] || 'default'} 
                    variant="outlined"
                    sx={{ fontWeight: 800, fontSize: '0.72rem' }} 
                />
            )
        },
        { 
            field: 'unit_pengampu', 
            headerName: 'Unit Pengampu', 
            width: 190,
            renderCell: (params) => (
                <Typography variant="caption" sx={{ fontWeight: 600, color: '#64748b' }}>
                    {params.value || '-'}
                </Typography>
            )
        },
        { 
            field: 'target', 
            headerName: 'Target', 
            width: 100,
            renderCell: (params) => (
                <Typography variant="body2" sx={{ fontWeight: 600, color: '#334155' }}>
                    {params.value != null ? params.value : '-'}
                </Typography>
            )
        },
        { 
            field: 'hasil_kinerja', 
            headerName: 'Hasil Kinerja (Realisasi)', 
            width: 180,
            renderCell: (params) => (
                <Typography variant="body2" sx={{ fontWeight: 700, color: '#0f172a' }}>
                    {params.value != null ? params.value : '-'}
                </Typography>
            )
        },
        {
            field: 'capaian_terhadap_target',
            headerName: 'Capaian terhadap Target (%)',
            width: 210,
            renderCell: (params) => {
                const val = params.value;
                if (val == null) return <Typography variant="caption" color="text.secondary">-</Typography>;
                const color = val >= 100 ? '#059669' : (val >= 80 ? '#d97706' : '#dc2626');
                return (
                    <Typography variant="body2" fontWeight={800} sx={{ color }}>
                        {val}%
                    </Typography>
                );
            }
        },
        {
            field: 'kendala',
            headerName: 'Kendala',
            width: 160,
            renderCell: (params) => (
                params.value ? (
                    <Tooltip title={params.value} arrow placement="top">
                        <Typography variant="caption" noWrap sx={{ color: '#b91c1c', fontStyle: 'italic', display: 'block', maxWidth: 140 }}>
                            {params.value}
                        </Typography>
                    </Tooltip>
                ) : <Typography variant="caption" color="text.secondary">-</Typography>
            )
        },
        {
            field: 'upaya',
            headerName: 'Upaya',
            width: 160,
            renderCell: (params) => (
                params.value ? (
                    <Tooltip title={params.value} arrow placement="top">
                        <Typography variant="caption" noWrap sx={{ color: '#059669', fontStyle: 'italic', display: 'block', maxWidth: 140 }}>
                            {params.value}
                        </Typography>
                    </Tooltip>
                ) : <Typography variant="caption" color="text.secondary">-</Typography>
            )
        },
        {
            field: 'status',
            headerName: 'Status',
            width: 150,
            renderCell: (params) => {
                const statusCfg = STATUS_CHIP[params.value] || STATUS_CHIP['Belum Diisi'];
                return (
                    <Chip 
                        icon={statusCfg.icon} 
                        label={params.value} 
                        size="small" 
                        color={statusCfg.color}
                        sx={{ fontWeight: 700 }}
                    />
                );
            }
        },
    ];

    return (
        <AppLayout title="Review Data Kinerja SAKIP">
            <Head title="Review Data Kinerja" />

            {/* HEADER HERO & SUMMARY METRICS */}
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
                <Box sx={{ display: 'flex', flexDirection: { xs: 'column', md: 'row' }, justifyContent: 'space-between', alignItems: { md: 'center' }, gap: 2, mb: 3 }}>
                    <Box>
                        <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1 }}>
                            <Chip label="Admin Review Console" size="small" sx={{ bgcolor: 'rgba(16, 185, 129, 0.2)', color: '#34d399', fontWeight: 700, border: '1px solid rgba(16, 185, 129, 0.4)' }} />
                            <Chip label="SAKIP Verification" size="small" sx={{ bgcolor: 'rgba(255,255,255,0.1)', color: '#e2e8f0', fontWeight: 600 }} />
                        </Stack>
                        <Typography variant="h4" fontWeight={800} sx={{ letterSpacing: -0.5 }}>
                            Monitoring & Review Data Kinerja
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#94a3b8', mt: 0.5, maxWidth: 650 }}>
                            Evaluasi komprehensif ketercapaian SP, IKP, SK, IKK, target tahunan, serta isian kendala & upaya tindak lanjut.
                        </Typography>
                    </Box>

                    {/* Filter Controls */}
                    <Stack 
                        direction="row" 
                        spacing={1.5} 
                        alignItems="center"
                        sx={{ 
                            bgcolor: 'rgba(15, 23, 42, 0.75)', 
                            p: 1.5, 
                            borderRadius: 3, 
                            border: '1px solid rgba(255, 255, 255, 0.12)',
                            boxShadow: '0 4px 12px rgba(0, 0, 0, 0.2)'
                        }}
                    >
                        <Box>
                            <Typography variant="caption" sx={{ color: '#94a3b8', fontWeight: 700, fontSize: '0.7rem', display: 'block', mb: 0.5, px: 0.5 }}>
                                TAHUN
                            </Typography>
                            <Select 
                                size="small"
                                value={tahun} 
                                onChange={e => handleFilterChange('tahun', e.target.value)}
                                sx={{ 
                                    minWidth: 110,
                                    height: 38,
                                    color: '#ffffff', 
                                    fontWeight: 700,
                                    bgcolor: 'rgba(30, 41, 59, 0.8)',
                                    borderRadius: 2,
                                    '& .MuiOutlinedInput-notchedOutline': { borderColor: 'rgba(255, 255, 255, 0.15)' },
                                    '&:hover .MuiOutlinedInput-notchedOutline': { borderColor: '#10b981' },
                                    '&.Mui-focused .MuiOutlinedInput-notchedOutline': { borderColor: '#10b981' },
                                    '& .MuiSvgIcon-root': { color: '#34d399' }
                                }}
                            >
                                {[2025, 2026, 2027, 2028, 2029].map(y => (
                                    <MenuItem key={y} value={y}>Tahun {y}</MenuItem>
                                ))}
                            </Select>
                        </Box>

                        <Box>
                            <Typography variant="caption" sx={{ color: '#94a3b8', fontWeight: 700, fontSize: '0.7rem', display: 'block', mb: 0.5, px: 0.5 }}>
                                TRIWULAN
                            </Typography>
                            <Select 
                                size="small"
                                value={triwulan} 
                                onChange={e => handleFilterChange('triwulan', e.target.value)}
                                sx={{ 
                                    minWidth: 130,
                                    height: 38,
                                    color: '#ffffff', 
                                    fontWeight: 700,
                                    bgcolor: 'rgba(30, 41, 59, 0.8)',
                                    borderRadius: 2,
                                    '& .MuiOutlinedInput-notchedOutline': { borderColor: 'rgba(255, 255, 255, 0.15)' },
                                    '&:hover .MuiOutlinedInput-notchedOutline': { borderColor: '#10b981' },
                                    '&.Mui-focused .MuiOutlinedInput-notchedOutline': { borderColor: '#10b981' },
                                    '& .MuiSvgIcon-root': { color: '#34d399' }
                                }}
                            >
                                <MenuItem value={1}>Triwulan I</MenuItem>
                                <MenuItem value={2}>Triwulan II</MenuItem>
                                <MenuItem value={3}>Triwulan III</MenuItem>
                                <MenuItem value={4}>Triwulan IV</MenuItem>
                            </Select>
                        </Box>
                    </Stack>
                </Box>

                {/* SUMMARY CARDS */}
                <Grid container spacing={2}>
                    <Grid item xs={12} sm={6} md={3}>
                        <Card sx={{ bgcolor: 'rgba(255, 255, 255, 0.08)', color: '#ffffff', backdropFilter: 'blur(10px)', border: '1px solid rgba(255, 255, 255, 0.12)', borderRadius: 2.5 }}>
                            <CardContent sx={{ py: 1.5, '&:last-child': { pb: 1.5 } }}>
                                <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                                    <Typography variant="caption" sx={{ color: '#cbd5e1', fontWeight: 700, textTransform: 'uppercase' }}>Total SP</Typography>
                                    <StorageIcon sx={{ color: '#818cf8', fontSize: 20 }} />
                                </Box>
                                <Typography variant="h4" fontWeight="800" sx={{ mt: 0.5 }}>{summary.totalSp ?? 0}</Typography>
                            </CardContent>
                        </Card>
                    </Grid>

                    <Grid item xs={12} sm={6} md={3}>
                        <Card sx={{ bgcolor: 'rgba(255, 255, 255, 0.08)', color: '#ffffff', backdropFilter: 'blur(10px)', border: '1px solid rgba(255, 255, 255, 0.12)', borderRadius: 2.5 }}>
                            <CardContent sx={{ py: 1.5, '&:last-child': { pb: 1.5 } }}>
                                <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                                    <Typography variant="caption" sx={{ color: '#cbd5e1', fontWeight: 700, textTransform: 'uppercase' }}>Rata Capaian SP</Typography>
                                    <TrendingUpIcon sx={{ color: '#34d399', fontSize: 20 }} />
                                </Box>
                                <Typography variant="h4" fontWeight="800" sx={{ mt: 0.5, color: '#34d399' }}>{summary.avgCapaianSp ?? 0}%</Typography>
                            </CardContent>
                        </Card>
                    </Grid>

                    <Grid item xs={12} sm={6} md={3}>
                        <Card sx={{ bgcolor: 'rgba(255, 255, 255, 0.08)', color: '#ffffff', backdropFilter: 'blur(10px)', border: '1px solid rgba(255, 255, 255, 0.12)', borderRadius: 2.5 }}>
                            <CardContent sx={{ py: 1.5, '&:last-child': { pb: 1.5 } }}>
                                <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                                    <Typography variant="caption" sx={{ color: '#cbd5e1', fontWeight: 700, textTransform: 'uppercase' }}>Total IKP</Typography>
                                    <AssessmentIcon sx={{ color: '#38bdf8', fontSize: 20 }} />
                                </Box>
                                <Typography variant="h4" fontWeight="800" sx={{ mt: 0.5 }}>{summary.totalIkp ?? 0}</Typography>
                            </CardContent>
                        </Card>
                    </Grid>

                    <Grid item xs={12} sm={6} md={3}>
                        <Card sx={{ bgcolor: 'rgba(255, 255, 255, 0.08)', color: '#ffffff', backdropFilter: 'blur(10px)', border: '1px solid rgba(255, 255, 255, 0.12)', borderRadius: 2.5 }}>
                            <CardContent sx={{ py: 1.5, '&:last-child': { pb: 1.5 } }}>
                                <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                                    <Typography variant="caption" sx={{ color: '#cbd5e1', fontWeight: 700, textTransform: 'uppercase' }}>Rata Capaian IKP</Typography>
                                    <TrendingUpIcon sx={{ color: '#fbbf24', fontSize: 20 }} />
                                </Box>
                                <Typography variant="h4" fontWeight="800" sx={{ mt: 0.5, color: '#fbbf24' }}>{summary.avgCapaianIkp ?? 0}%</Typography>
                            </CardContent>
                        </Card>
                    </Grid>
                </Grid>
            </Paper>

            {/* DATAGRID TABEL REVIEW DATA */}
            <Paper sx={{ height: 650, width: '100%', mb: 4, borderRadius: 3, overflow: 'hidden', border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -2px rgba(15, 23, 42, 0.05)' }}>
                <DataGrid
                    rows={data}
                    columns={columns}
                    pageSizeOptions={[10, 25, 50, 100]}
                    initialState={{ pagination: { paginationModel: { pageSize: 25 } } }}
                    slots={{ toolbar: GridToolbar }}
                    slotProps={{ toolbar: { showQuickFilter: true, quickFilterProps: { debounceMs: 500 } } }}
                    disableRowSelectionOnClick
                    sx={{
                        border: 'none',
                        '& .MuiDataGrid-cell': {
                            borderBottom: '1px solid #f1f5f9',
                        },
                        '& .MuiDataGrid-columnHeaders': {
                            backgroundColor: '#f8fafc',
                            borderBottom: '2px solid #e2e8f0',
                            fontWeight: 800,
                            color: '#0f172a',
                            fontSize: '0.85rem'
                        },
                        '& .MuiDataGrid-toolbarContainer': {
                            padding: 2,
                            borderBottom: '1px solid #e2e8f0',
                            bgcolor: '#ffffff'
                        }
                    }}
                />
            </Paper>
        </AppLayout>
    );
}
