import { useState, useMemo } from 'react';
import {
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions,
    Button,
    Typography,
    Box,
    Chip,
    TextField,
    InputAdornment,
    Table,
    TableHead,
    TableBody,
    TableRow,
    TableCell,
    TableContainer,
    Paper,
    Stack,
    IconButton
} from '@mui/material';
import {
    Search as SearchIcon,
    Close as CloseIcon,
    CheckCircle as CheckCircleIcon,
    Warning as WarningIcon,
    Error as ErrorIcon,
    HelpOutlineOutlined as HelpIcon,
    Dashboard as DashboardIcon
} from '@mui/icons-material';

const STATUS_CONFIG = {
    ALL: {
        title: 'Seluruh Indikator Kinerja Program (IKP)',
        subtitle: '20 Indikator Sasaran Program Renstra JAMBIN',
        color: '#2563eb',
        bg: '#eff6ff',
        icon: <DashboardIcon fontSize="small" />
    },
    TERCAPAI: {
        title: 'IKP dengan Target Tercapai',
        subtitle: 'Indikator dengan capaian \u2265 100% dari target',
        color: '#059669',
        bg: '#ecfdf5',
        icon: <CheckCircleIcon fontSize="small" />
    },
    BELUM_TERCAPAI: {
        title: 'IKP Belum Tercapai',
        subtitle: 'Indikator dengan capaian < 100% dari target',
        color: '#d97706',
        bg: '#fffbeb',
        icon: <WarningIcon fontSize="small" />
    },
    BELUM_DIISI: {
        title: 'IKP Belum Diisi',
        subtitle: 'Indikator yang belum memiliki input realisasi kinerja',
        color: '#dc2626',
        bg: '#fef2f2',
        icon: <ErrorIcon fontSize="small" />
    }
};

export default function IkpDetailModal({
    open,
    onClose,
    statusFilter = 'ALL',
    ikpList = [],
    currentTahun,
    currentTriwulan
}) {
    const [searchTerm, setSearchTerm] = useState('');

    const config = STATUS_CONFIG[statusFilter] || STATUS_CONFIG.ALL;

    // Filter items based on selected card status and search term
    const filteredItems = useMemo(() => {
        let items = ikpList;
        if (statusFilter === 'TERCAPAI') {
            items = items.filter(item => item.status === 'Tercapai');
        } else if (statusFilter === 'BELUM_TERCAPAI') {
            items = items.filter(item => item.status === 'Belum Tercapai' || item.status === 'Tidak Tercapai');
        } else if (statusFilter === 'BELUM_DIISI') {
            items = items.filter(item => item.status === 'Belum Diisi');
        }

        if (!searchTerm.trim()) return items;

        const term = searchTerm.toLowerCase();
        return items.filter(item =>
            (item.kode && item.kode.toLowerCase().includes(term)) ||
            (item.nama && item.nama.toLowerCase().includes(term)) ||
            (item.unit && item.unit.toLowerCase().includes(term))
        );
    }, [ikpList, statusFilter, searchTerm]);

    return (
        <Dialog
            open={open}
            onClose={onClose}
            maxWidth="lg"
            fullWidth
            PaperProps={{
                sx: {
                    borderRadius: 3.5,
                    overflow: 'hidden',
                    boxShadow: '0 25px 50px -12px rgba(15, 23, 42, 0.25)'
                }
            }}
        >
            {/* Header */}
            <DialogTitle sx={{ p: 2.5, bgcolor: config.bg, borderBottom: '1px solid #e2e8f0' }}>
                <Stack direction="row" justifyContent="space-between" alignItems="center">
                    <Stack direction="row" spacing={1.5} alignItems="center">
                        <Box
                            sx={{
                                width: 40,
                                height: 40,
                                borderRadius: 2.5,
                                bgcolor: '#ffffff',
                                color: config.color,
                                display: 'flex',
                                alignItems: 'center',
                                justifyContent: 'center',
                                boxShadow: '0 2px 8px rgba(0,0,0,0.06)'
                            }}
                        >
                            {config.icon}
                        </Box>
                        <Box>
                            <Stack direction="row" spacing={1} alignItems="center">
                                <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', lineHeight: 1.2 }}>
                                    {config.title}
                                </Typography>
                                <Chip
                                    label={`${filteredItems.length} Indikator`}
                                    size="small"
                                    sx={{
                                        fontWeight: 800,
                                        bgcolor: config.color,
                                        color: '#ffffff',
                                        fontSize: '0.75rem'
                                    }}
                                />
                            </Stack>
                            <Typography variant="caption" sx={{ color: '#64748b' }}>
                                {config.subtitle} &middot; Tahun {currentTahun} TW {currentTriwulan}
                            </Typography>
                        </Box>
                    </Stack>
                    <IconButton onClick={onClose} size="small" sx={{ color: '#64748b' }}>
                        <CloseIcon />
                    </IconButton>
                </Stack>
            </DialogTitle>

            {/* Content */}
            <DialogContent sx={{ p: 3 }}>
                {/* Search Bar */}
                <Box sx={{ mb: 2.5 }}>
                    <TextField
                        size="small"
                        fullWidth
                        placeholder="Cari kode indikator (contoh: IKP 1.1), nama indikator, atau unit pengampu..."
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        InputProps={{
                            startAdornment: (
                                <InputAdornment position="start">
                                    <SearchIcon sx={{ color: '#94a3b8' }} fontSize="small" />
                                </InputAdornment>
                            )
                        }}
                        sx={{
                            '& .MuiOutlinedInput-root': {
                                borderRadius: 2.5,
                                bgcolor: '#f8fafc'
                            }
                        }}
                    />
                </Box>

                {/* Table */}
                <TableContainer component={Paper} elevation={0} sx={{ border: '1px solid #e2e8f0', borderRadius: 2.5, maxHeight: 460 }}>
                    <Table stickyHeader size="small">
                        <TableHead>
                            <TableRow sx={{ '& th': { bgcolor: '#f8fafc', fontWeight: 800, color: '#0f172a', py: 1.5 } }}>
                                <TableCell width={110}>Kode</TableCell>
                                <TableCell>Nama Indikator Kinerja Program (IKP)</TableCell>
                                <TableCell width={180}>Unit Pengampu</TableCell>
                                <TableCell width={100} align="center">Target</TableCell>
                                <TableCell width={110} align="center">Realisasi</TableCell>
                                <TableCell width={130} align="center">Capaian (%)</TableCell>
                                <TableCell width={140} align="center">Status</TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {filteredItems.length > 0 ? (
                                filteredItems.map((item) => {
                                    const capaianVal = item.capaian;
                                    let statusColor = '#64748b';
                                    let statusBg = '#f1f5f9';
                                    let statusIcon = <HelpIcon sx={{ fontSize: '0.85rem !important' }} />;

                                    if (item.status === 'Tercapai') {
                                        statusColor = '#059669';
                                        statusBg = '#ecfdf5';
                                        statusIcon = <CheckCircleIcon sx={{ fontSize: '0.85rem !important' }} />;
                                    } else if (item.status === 'Belum Tercapai') {
                                        statusColor = '#d97706';
                                        statusBg = '#fffbeb';
                                        statusIcon = <WarningIcon sx={{ fontSize: '0.85rem !important' }} />;
                                    } else if (item.status === 'Tidak Tercapai') {
                                        statusColor = '#dc2626';
                                        statusBg = '#fef2f2';
                                        statusIcon = <ErrorIcon sx={{ fontSize: '0.85rem !important' }} />;
                                    }

                                    return (
                                        <TableRow key={item.id} hover sx={{ '&:last-child td, &:last-child th': { border: 0 } }}>
                                            <TableCell>
                                                <Chip
                                                    label={item.kode}
                                                    size="small"
                                                    sx={{
                                                        fontWeight: 800,
                                                        bgcolor: '#0f172a',
                                                        color: '#ffffff',
                                                        fontSize: '0.72rem'
                                                    }}
                                                />
                                            </TableCell>
                                            <TableCell>
                                                <Typography variant="body2" fontWeight={600} sx={{ color: '#0f172a', lineHeight: 1.35 }}>
                                                    {item.nama}
                                                </Typography>
                                                {item.satuan && (
                                                    <Typography variant="caption" sx={{ color: '#94a3b8' }}>
                                                        Satuan: {item.satuan}
                                                    </Typography>
                                                )}
                                            </TableCell>
                                            <TableCell>
                                                <Typography variant="caption" sx={{ fontWeight: 600, color: '#475569', display: 'block' }}>
                                                    {item.unit}
                                                </Typography>
                                            </TableCell>
                                            <TableCell align="center">
                                                <Typography variant="body2" sx={{ fontWeight: 600, color: '#334155' }}>
                                                    {item.target != null ? item.target : '-'}
                                                </Typography>
                                            </TableCell>
                                            <TableCell align="center">
                                                <Typography variant="body2" sx={{ fontWeight: 700, color: item.realisasi != null ? '#0f172a' : '#94a3b8' }}>
                                                    {item.realisasi != null ? item.realisasi : '-'}
                                                </Typography>
                                            </TableCell>
                                            <TableCell align="center">
                                                {capaianVal != null ? (
                                                    <Chip
                                                        label={`${Number(capaianVal).toFixed(1)}%`}
                                                        size="small"
                                                        sx={{
                                                            fontWeight: 800,
                                                            color: statusColor,
                                                            bgcolor: statusBg,
                                                            border: `1px solid ${statusColor}40`,
                                                            fontSize: '0.75rem'
                                                        }}
                                                    />
                                                ) : (
                                                    <Typography variant="caption" color="text.secondary">-</Typography>
                                                )}
                                            </TableCell>
                                            <TableCell align="center">
                                                <Chip
                                                    icon={statusIcon}
                                                    label={item.status}
                                                    size="small"
                                                    sx={{
                                                        fontWeight: 700,
                                                        color: statusColor,
                                                        bgcolor: statusBg,
                                                        fontSize: '0.75rem'
                                                    }}
                                                />
                                            </TableCell>
                                        </TableRow>
                                    );
                                })
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={7} sx={{ textAlign: 'center', py: 5 }}>
                                        <Typography variant="body2" color="text.secondary">
                                            Tidak ada indikator yang sesuai dengan filter ini.
                                        </Typography>
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </TableContainer>
            </DialogContent>

            {/* Footer */}
            <DialogActions sx={{ p: 2, px: 3, borderTop: '1px solid #e2e8f0', bgcolor: '#f8fafc' }}>
                <Button onClick={onClose} variant="outlined" sx={{ borderRadius: 2, textTransform: 'none', fontWeight: 700 }}>
                    Tutup
                </Button>
            </DialogActions>
        </Dialog>
    );
}
