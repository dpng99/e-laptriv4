import { Head, Link, useForm } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    Box, Typography, Button, Paper, Chip, IconButton, Stack, Tooltip 
} from '@mui/material';
import { Add as AddIcon, Edit as EditIcon, Delete as DeleteIcon, Functions as FunctionsIcon } from '@mui/icons-material';
import { DataGrid, GridToolbar } from '@mui/x-data-grid';

export default function RumusIndex({ formulas = [] }) {
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus rumus ini?')) {
            destroy(route('admin.rumus.destroy', id));
        }
    };

    const columns = [
        { 
            field: 'index', 
            headerName: 'No', 
            width: 70, 
            renderCell: (params) => (
                <Typography variant="body2" sx={{ fontWeight: 700, color: '#64748b' }}>
                    {params.api.getAllRowIds().indexOf(params.id) + 1}
                </Typography>
            )
        },
        { 
            field: 'kode_indikator', 
            headerName: 'Indikator Kinerja', 
            flex: 1, 
            minWidth: 360, 
            renderCell: (params) => (
                <Box sx={{ py: 1.5 }}>
                    <Chip 
                        label={params.row.kode_indikator} 
                        size="small" 
                        sx={{ fontWeight: 800, bgcolor: '#0f172a', color: '#ffffff', mb: 0.5 }} 
                    />
                    <Typography variant="body2" fontWeight={700} sx={{ color: '#0f172a', lineHeight: 1.3 }}>
                        {params.row.nama_indikator}
                    </Typography>
                </Box>
            )
        },
        { 
            field: 'tipe_indikator', 
            headerName: 'Tipe Node', 
            width: 130, 
            renderCell: (params) => (
                <Chip 
                    label={params.value} 
                    size="small" 
                    color={params.value === 'MANDIRI' ? 'primary' : 'secondary'} 
                    variant="outlined" 
                    sx={{ fontWeight: 700 }}
                />
            )
        },
        { 
            field: 'tipe_formula', 
            headerName: 'Tipe Formula', 
            width: 200,
            renderCell: (params) => (
                <Chip 
                    label={params.value} 
                    size="small" 
                    sx={{ bgcolor: '#eff6ff', color: '#1d4ed8', fontWeight: 700, border: '1px solid #bfdbfe' }} 
                />
            )
        },
        { 
            field: 'versi', 
            headerName: 'Versi', 
            width: 90,
            renderCell: (params) => (
                <Typography variant="body2" sx={{ fontWeight: 600, color: '#475569' }}>
                    v{params.value || 1}
                </Typography>
            )
        },
        { 
            field: 'is_active', 
            headerName: 'Status', 
            width: 120, 
            renderCell: (params) => (
                <Chip 
                    label={params.value ? 'Aktif' : 'Non-aktif'} 
                    color={params.value ? 'success' : 'default'} 
                    size="small" 
                    sx={{ fontWeight: 700 }}
                />
            )
        },
        { 
            field: 'actions', 
            headerName: 'Aksi', 
            width: 120, 
            sortable: false, 
            filterable: false, 
            renderCell: (params) => (
                <Stack direction="row" spacing={0.5}>
                    <Tooltip title="Edit Rumus">
                        <IconButton component={Link} href={route('admin.rumus.edit', params.row.id)} color="primary" size="small" sx={{ bgcolor: '#eff6ff' }}>
                            <EditIcon fontSize="small" />
                        </IconButton>
                    </Tooltip>
                    <Tooltip title="Hapus">
                        <IconButton onClick={() => handleDelete(params.row.id)} color="error" size="small" sx={{ bgcolor: '#fef2f2' }}>
                            <DeleteIcon fontSize="small" />
                        </IconButton>
                    </Tooltip>
                </Stack>
            )
        }
    ];

    return (
        <AppLayout title="Manajemen Rumus Indikator">
            <Head title="Manajemen Formula" />

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
                <Box sx={{ display: 'flex', flexDirection: { xs: 'column', md: 'row' }, justifyContent: 'space-between', alignItems: { md: 'center' }, gap: 2 }}>
                    <Box>
                        <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1 }}>
                            <Chip label="Admin System" size="small" sx={{ bgcolor: 'rgba(16, 185, 129, 0.2)', color: '#34d399', fontWeight: 700, border: '1px solid rgba(16, 185, 129, 0.4)' }} />
                            <Chip label="Formula Registry" size="small" sx={{ bgcolor: 'rgba(255,255,255,0.1)', color: '#e2e8f0', fontWeight: 600 }} />
                        </Stack>
                        <Typography variant="h4" fontWeight={800} sx={{ letterSpacing: -0.5 }}>
                            Manajemen Rumus & Variabel Indikator
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#94a3b8', mt: 0.5, maxWidth: 650 }}>
                            Konfigurasi formula matematis, rasio pembilang/penyebut, variabel bobot, dan arah kinerja (positif/negatif) untuk setiap indikator.
                        </Typography>
                    </Box>

                    <Button 
                        component={Link} 
                        href={route('admin.rumus.create')} 
                        variant="contained" 
                        size="large"
                        startIcon={<AddIcon />}
                        sx={{
                            bgcolor: '#059669',
                            color: '#ffffff',
                            background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                            borderRadius: 2.5,
                            fontWeight: 700,
                            px: 3,
                            boxShadow: '0 4px 14px rgba(5, 150, 105, 0.4)',
                            '&:hover': {
                                background: 'linear-gradient(135deg, #047857 0%, #059669 100%)',
                            }
                        }}
                    >
                        Tambah Rumus
                    </Button>
                </Box>
            </Paper>

            <Paper sx={{ width: '100%', mb: 4, borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -2px rgba(15, 23, 42, 0.05)', overflow: 'hidden' }}>
                <Box sx={{ height: 600, width: '100%' }}>
                    <DataGrid
                        rows={formulas}
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
                                display: 'flex',
                                alignItems: 'center',
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

