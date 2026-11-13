import { useState } from 'react';
import { Head, router, usePage } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    Box, Paper, FormControl, Select, MenuItem, Chip, 
    Typography, Grid, Card, CardContent, Stack, Tooltip, Button, Switch,
    FormControlLabel, Alert, Divider
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
    VisibilityOff as VisibilityOffIcon,
    LockOutlined as LockIcon,
    Tune as TuneIcon
} from '@mui/icons-material';

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

export default function ReviewData({ 
    data = [], 
    allData = null,
    summary = {}, 
    visibilitySummary = {},
    units = [],
    showHidden = false,
    currentTahun, 
    currentTriwulan 
}) {
    const { flash } = usePage().props;
    const [tahun, setTahun] = useState(currentTahun);
    const [triwulan, setTriwulan] = useState(currentTriwulan);
    const [displayHidden, setDisplayHidden] = useState(Boolean(showHidden));
    const [selectedUnitId, setSelectedUnitId] = useState('');
    const [processingVisibility, setProcessingVisibility] = useState(false);

    const handleFilterChange = (field, val) => {
        const nextTahun = field === 'tahun' ? val : tahun;
        const nextTriwulan = field === 'triwulan' ? val : triwulan;
        if (field === 'tahun') setTahun(val);
        if (field === 'triwulan') setTriwulan(val);

        router.get(
            route('review-data.index'),
            { tahun: nextTahun, triwulan: nextTriwulan, show_hidden: displayHidden ? 1 : 0 },
            { preserveState: true, preserveScroll: true }
        );
    };

    const handleToggleNodeVisibility = (row) => {
        if (!row.can_toggle_visibility || processingVisibility) return;
        setProcessingVisibility(true);
        router.patch(
            route('admin.visibility.toggle', row.id),
            { is_active: !row.is_active },
            {
                preserveScroll: true,
                onFinish: () => setProcessingVisibility(false),
            }
        );
    };

    const handleBulkVisibility = (targetLevel, isActive) => {
        if (processingVisibility) return;
        setProcessingVisibility(true);
        router.post(
            route('admin.visibility.bulk'),
            {
                target_level: targetLevel,
                is_active: isActive,
                unit_kerja_id: selectedUnitId !== '' ? Number(selectedUnitId) : null,
            },
            {
                preserveScroll: true,
                onFinish: () => setProcessingVisibility(false),
            }
        );
    };

    const sourceRows = Array.isArray(allData) ? allData : data;
    const displayedRows = displayHidden
        ? sourceRows
        : sourceRows.filter((row) => row.effective_visible !== false);

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
            minWidth: 260,
            renderCell: (params) => (
                <Typography 
                    variant="body2" 
                    fontWeight={600} 
                    sx={{ 
                        color: params.row.effective_visible === false ? '#94a3b8' : '#0f172a', 
                        textDecoration: params.row.effective_visible === false ? 'line-through' : 'none',
                        whiteSpace: 'normal', 
                        wordBreak: 'break-word', 
                        lineHeight: 1.4 
                    }}
                >
                    {params.value}
                </Typography>
            )
        },
        {
            field: 'tipe_indikator',
            headerName: 'Level',
            width: 85,
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
            width: 180,
            renderCell: (params) => (
                <Typography variant="caption" sx={{ fontWeight: 600, color: '#64748b' }}>
                    {params.value || '-'}
                </Typography>
            )
        },
        { 
            field: 'target', 
            headerName: 'Target', 
            width: 95,
            renderCell: (params) => (
                <Typography variant="body2" sx={{ fontWeight: 600, color: '#334155' }}>
                    {params.value != null ? params.value : '-'}
                </Typography>
            )
        },
        { 
            field: 'hasil_kinerja', 
            headerName: 'Hasil Kinerja (Realisasi)', 
            width: 165,
            renderCell: (params) => (
                <Typography variant="body2" sx={{ fontWeight: 700, color: '#0f172a' }}>
                    {params.value != null ? params.value : '-'}
                </Typography>
            )
        },
        {
            field: 'capaian_terhadap_target',
            headerName: 'Capaian vs Target (%)',
            width: 185,
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
            width: 150,
            renderCell: (params) => (
                params.value ? (
                    <Tooltip title={params.value} arrow placement="top">
                        <Typography variant="caption" noWrap sx={{ color: '#b91c1c', fontStyle: 'italic', display: 'block', maxWidth: 135 }}>
                            {params.value}
                        </Typography>
                    </Tooltip>
                ) : <Typography variant="caption" color="text.secondary">-</Typography>
            )
        },
        {
            field: 'upaya',
            headerName: 'Upaya',
            width: 150,
            renderCell: (params) => (
                params.value ? (
                    <Tooltip title={params.value} arrow placement="top">
                        <Typography variant="caption" noWrap sx={{ color: '#059669', fontStyle: 'italic', display: 'block', maxWidth: 135 }}>
                            {params.value}
                        </Typography>
                    </Tooltip>
                ) : <Typography variant="caption" color="text.secondary">-</Typography>
            )
        },
        {
            field: 'status',
            headerName: 'Status',
            width: 145,
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
        {
            field: 'effective_visible',
            headerName: 'Visibilitas SK/IKK',
            width: 185,
            sortable: false,
            renderCell: (params) => {
                const row = params.row;
                if (!row.can_toggle_visibility) {
                    return (
                        <Chip
                            icon={<LockIcon sx={{ fontSize: '14px !important' }} />}
                            label="Utama (PK)"
                            size="small"
                            variant="outlined"
                            sx={{ fontWeight: 700, fontSize: '0.7rem', color: '#475569', borderColor: '#cbd5e1' }}
                        />
                    );
                }

                if (row.tipe_indikator === 'IKK' && row.parent_sk_active === false) {
                    return (
                        <Tooltip title={`IKK ini otomatis tersembunyi karena induk ${row.parent_sk_kode || 'SK'} sedang disembunyikan.`} arrow>
                            <Chip
                                icon={<VisibilityOffIcon sx={{ fontSize: '14px !important' }} />}
                                label={`Induk ${row.parent_sk_kode || 'SK'} Off`}
                                size="small"
                                color="warning"
                                variant="outlined"
                                sx={{ fontWeight: 700, fontSize: '0.7rem' }}
                            />
                        </Tooltip>
                    );
                }

                return (
                    <Stack direction="row" spacing={0.5} alignItems="center">
                        <Switch
                            size="small"
                            color="success"
                            checked={Boolean(row.is_active)}
                            disabled={processingVisibility}
                            onChange={() => handleToggleNodeVisibility(row)}
                        />
                        <Chip
                            label={row.is_active ? 'Tampil' : 'Tersembunyi'}
                            size="small"
                            color={row.is_active ? 'success' : 'default'}
                            variant={row.is_active ? 'filled' : 'outlined'}
                            sx={{ fontWeight: 700, fontSize: '0.68rem', height: 22 }}
                        />
                    </Stack>
                );
            }
        },
    ];

    return (
        <AppLayout title="Review Data Kinerja SAKIP">
            <Head title="Review Data Kinerja" />

            {flash?.success && (
                <Alert severity="success" sx={{ mb: 2.5, borderRadius: 2.5, fontWeight: 600 }}>
                    {flash.success}
                </Alert>
            )}

            {/* HEADER HERO & SUMMARY METRICS */}
            <Paper 
                elevation={0}
                sx={{
                    p: { xs: 3, md: 3.5 },
                    mb: 3,
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
                            Evaluasi komprehensif ketercapaian SP, IKP, SK, IKK, target tahunan, kendala & upaya, serta kontrol kemunculan (Show/Hide) SK dan IKK.
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

            {/* PANEL KONTROL VISIBILITAS (SHOW / HIDE) SK & IKK */}
            <Paper
                elevation={0}
                sx={{
                    p: 2.5,
                    mb: 3,
                    borderRadius: 3,
                    border: '1px solid #e2e8f0',
                    bgcolor: '#ffffff',
                    boxShadow: '0 4px 16px -4px rgba(15, 23, 42, 0.04)'
                }}
            >
                <Stack
                    direction={{ xs: 'column', lg: 'row' }}
                    spacing={2}
                    justifyContent="space-between"
                    alignItems={{ lg: 'center' }}
                >
                    <Box>
                        <Stack direction="row" spacing={1} alignItems="center" flexWrap="wrap" useFlexGap>
                            <TuneIcon sx={{ color: '#059669', fontSize: 20 }} />
                            <Typography variant="subtitle1" fontWeight={800} sx={{ color: '#0f172a' }}>
                                Kontrol Kemunculan (Show / Hide) SK & IKK
                            </Typography>
                            <Chip
                                label={`SK Tampil: ${visibilitySummary.active_sk ?? 0}/${visibilitySummary.total_sk ?? 0}`}
                                size="small"
                                color={(visibilitySummary.hidden_sk ?? 0) === 0 ? 'success' : 'warning'}
                                sx={{ fontWeight: 700, fontSize: '0.73rem' }}
                            />
                            <Chip
                                label={`IKK Tampil: ${visibilitySummary.visible_ikk ?? 0}/${visibilitySummary.total_ikk ?? 0}`}
                                size="small"
                                color={(visibilitySummary.hidden_ikk ?? 0) === 0 ? 'success' : 'warning'}
                                sx={{ fontWeight: 700, fontSize: '0.73rem' }}
                            />
                        </Stack>
                        <Typography variant="caption" sx={{ color: '#64748b', display: 'block', mt: 0.5 }}>
                            Menyembunyikan SK atau IKK akan menghilangkannya dari Dashboard Operator, Form Input Operator, Dashboard Admin, Tabel Review, dan Ekspor Word. Jika SK disembunyikan, seluruh IKK di bawahnya otomatis ikut tersembunyi.
                        </Typography>
                    </Box>

                    <Stack direction={{ xs: 'column', sm: 'row' }} spacing={1.25} alignItems={{ sm: 'center' }} flexWrap="wrap" useFlexGap>
                        <FormControl size="small" sx={{ minWidth: 190 }}>
                            <Select
                                displayEmpty
                                value={selectedUnitId}
                                onChange={(e) => setSelectedUnitId(e.target.value)}
                                sx={{ fontSize: '0.8rem', fontWeight: 600, borderRadius: 2 }}
                            >
                                <MenuItem value="">Semua Biro & Pusat</MenuItem>
                                {units.map((u) => (
                                    <MenuItem key={u.id} value={u.id}>
                                        {u.nama}
                                    </MenuItem>
                                ))}
                            </Select>
                        </FormControl>

                        <Button
                            variant="contained"
                            color="success"
                            size="small"
                            startIcon={<VisibilityIcon />}
                            disabled={processingVisibility}
                            onClick={() => handleBulkVisibility('ALL_SK_IKK', true)}
                            sx={{ fontWeight: 700, textTransform: 'none', borderRadius: 2 }}
                        >
                            Munculkan Semua SK & IKK
                        </Button>

                        <Button
                            variant="outlined"
                            color="error"
                            size="small"
                            startIcon={<VisibilityOffIcon />}
                            disabled={processingVisibility}
                            onClick={() => handleBulkVisibility('ALL_SK_IKK', false)}
                            sx={{ fontWeight: 700, textTransform: 'none', borderRadius: 2 }}
                        >
                            Sembunyikan Semua SK & IKK
                        </Button>

                        <Button
                            variant="outlined"
                            color="warning"
                            size="small"
                            disabled={processingVisibility}
                            onClick={() => handleBulkVisibility('IKK', false)}
                            sx={{ fontWeight: 700, textTransform: 'none', borderRadius: 2 }}
                        >
                            Sembunyikan Hanya IKK
                        </Button>
                    </Stack>
                </Stack>

                <Divider sx={{ my: 1.5 }} />

                <Stack direction="row" justifyContent="space-between" alignItems="center" flexWrap="wrap">
                    <FormControlLabel
                        control={
                            <Switch
                                size="small"
                                checked={displayHidden}
                                onChange={(e) => setDisplayHidden(e.target.checked)}
                            />
                        }
                        label={
                            <Typography variant="body2" fontWeight={700} sx={{ color: '#334155' }}>
                                Tampilkan baris SK & IKK yang sedang disembunyikan pada tabel di bawah (untuk mengatur switch satu per satu)
                            </Typography>
                        }
                    />
                    <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 600 }}>
                        Menampilkan {displayedRows.length} dari {sourceRows.length} baris kinerja
                    </Typography>
                </Stack>
            </Paper>

            {/* DATAGRID TABEL REVIEW DATA */}
            <Paper sx={{ height: 650, width: '100%', mb: 4, borderRadius: 3, overflow: 'hidden', border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -2px rgba(15, 23, 42, 0.05)' }}>
                <DataGrid
                    rows={displayedRows}
                    columns={columns}
                    getRowHeight={() => 'auto'}
                    pageSizeOptions={[10, 25, 50, 100]}
                    initialState={{ pagination: { paginationModel: { pageSize: 25 } } }}
                    slots={{ toolbar: GridToolbar }}
                    slotProps={{ toolbar: { showQuickFilter: true, quickFilterProps: { debounceMs: 500 } } }}
                    disableRowSelectionOnClick
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
