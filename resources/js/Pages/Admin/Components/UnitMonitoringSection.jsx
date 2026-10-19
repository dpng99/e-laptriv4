import { useState, useMemo } from 'react';
import {
    Paper,
    Box,
    Typography,
    Stack,
    Chip,
    Table,
    TableHead,
    TableBody,
    TableRow,
    TableCell,
    TableContainer,
    LinearProgress,
    Button,
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions,
    TextField,
    InputAdornment,
    IconButton,
    Grid,
    Tooltip
} from '@mui/material';
import {
    CorporateFare as CorporateFareIcon,
    CheckCircle as CheckCircleIcon,
    HourglassTop as HourglassIcon,
    Cancel as CancelIcon,
    Visibility as VisibilityIcon,
    Search as SearchIcon,
    Close as CloseIcon,
    HelpOutlineOutlined as HelpIcon,
    Warning as WarningIcon,
    Error as ErrorIcon
} from '@mui/icons-material';

const STATUS_PENGISIAN_CONFIG = {
    'Lengkap': {
        color: '#059669',
        bgcolor: '#ecfdf5',
        border: '1px solid #a7f3d0',
        icon: <CheckCircleIcon sx={{ fontSize: '0.85rem !important' }} />
    },
    'Sebagian Terisi': {
        color: '#d97706',
        bgcolor: '#fffbeb',
        border: '1px solid #fde68a',
        icon: <HourglassIcon sx={{ fontSize: '0.85rem !important' }} />
    },
    'Belum Mengisi': {
        color: '#dc2626',
        bgcolor: '#fef2f2',
        border: '1px solid #fecaca',
        icon: <CancelIcon sx={{ fontSize: '0.85rem !important' }} />
    }
};

export default function UnitMonitoringSection({
    unitMonitoring = [],
    currentTahun = 2025,
    currentTriwulan = 1
}) {
    const [selectedUnit, setSelectedUnit] = useState(null);
    const [searchRincian, setSearchRincian] = useState('');

    // Summary counts
    const totalUnits = unitMonitoring.length;
    const lengkapCount = unitMonitoring.filter(u => u.status_pengisian === 'Lengkap').length;
    const sebagianCount = unitMonitoring.filter(u => u.status_pengisian === 'Sebagian Terisi').length;
    const belumCount = unitMonitoring.filter(u => u.status_pengisian === 'Belum Mengisi').length;

    // Filter indicators inside the selected unit's rincian dialog
    const filteredRincian = useMemo(() => {
        if (!selectedUnit || !selectedUnit.rincian) return [];
        if (!searchRincian.trim()) return selectedUnit.rincian;

        const term = searchRincian.toLowerCase();
        return selectedUnit.rincian.filter(item =>
            (item.kode && item.kode.toLowerCase().includes(term)) ||
            (item.nama && item.nama.toLowerCase().includes(term)) ||
            (item.status && item.status.toLowerCase().includes(term))
        );
    }, [selectedUnit, searchRincian]);

    const selectedStatusCfg = selectedUnit
        ? (STATUS_PENGISIAN_CONFIG[selectedUnit.status_pengisian] || STATUS_PENGISIAN_CONFIG['Belum Mengisi'])
        : null;

    return (
        <Paper
            elevation={0}
            sx={{
                borderRadius: 3.5,
                border: '1px solid #e2e8f0',
                boxShadow: '0 4px 20px -3px rgba(15, 23, 42, 0.05)',
                overflow: 'hidden',
                mb: 4
            }}
        >
            {/* Header */}
            <Box sx={{ p: 3, borderBottom: '1px solid #e2e8f0', bgcolor: '#f8fafc' }}>
                <Stack
                    direction={{ xs: 'column', md: 'row' }}
                    justifyContent="space-between"
                    alignItems={{ xs: 'flex-start', md: 'center' }}
                    spacing={2}
                >
                    <Box>
                        <Stack direction="row" spacing={1.5} alignItems="center" sx={{ mb: 0.5 }}>
                            <Box
                                sx={{
                                    width: 36,
                                    height: 36,
                                    borderRadius: 2,
                                    bgcolor: '#eff6ff',
                                    color: '#2563eb',
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center'
                                }}
                            >
                                <CorporateFareIcon fontSize="small" />
                            </Box>
                            <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                                Monitoring Pengisian Kinerja Biro & Pusat
                            </Typography>
                        </Stack>
                        <Typography variant="body2" sx={{ color: '#64748b' }}>
                            Pantau kepatuhan pengisian data indikator kinerja per unit kerja JAMBIN pada TW {currentTriwulan} {currentTahun}.
                        </Typography>
                    </Box>

                    {/* Summary Badges */}
                    <Stack direction="row" spacing={1} flexWrap="wrap">
                        <Chip
                            icon={<CheckCircleIcon sx={{ fontSize: '0.85rem !important' }} />}
                            label={`Lengkap: ${lengkapCount}`}
                            size="small"
                            sx={{ bgcolor: '#ecfdf5', color: '#059669', fontWeight: 700, border: '1px solid #a7f3d0' }}
                        />
                        <Chip
                            icon={<HourglassIcon sx={{ fontSize: '0.85rem !important' }} />}
                            label={`Sebagian: ${sebagianCount}`}
                            size="small"
                            sx={{ bgcolor: '#fffbeb', color: '#d97706', fontWeight: 700, border: '1px solid #fde68a' }}
                        />
                        <Chip
                            icon={<CancelIcon sx={{ fontSize: '0.85rem !important' }} />}
                            label={`Belum Mengisi: ${belumCount}`}
                            size="small"
                            sx={{ bgcolor: '#fef2f2', color: '#dc2626', fontWeight: 700, border: '1px solid #fecaca' }}
                        />
                    </Stack>
                </Stack>
            </Box>

            {/* Monitoring Table */}
            <TableContainer sx={{ maxHeight: 520 }}>
                <Table size="small" stickyHeader>
                    <TableHead>
                        <TableRow sx={{ '& th': { bgcolor: '#ffffff', fontWeight: 800, color: '#0f172a', py: 1.5, borderBottom: '2px solid #e2e8f0' } }}>
                            <TableCell width={260}>Biro / Pusat</TableCell>
                            <TableCell width={280}>Progres Pengisian</TableCell>
                            <TableCell width={160} align="center">Status Pengisian</TableCell>
                            <TableCell width={150} align="center">Rata-rata Capaian</TableCell>
                            <TableCell width={140} align="center">Aksi</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {unitMonitoring.length > 0 ? (
                            unitMonitoring.map((unit) => {
                                const statusCfg = STATUS_PENGISIAN_CONFIG[unit.status_pengisian] || STATUS_PENGISIAN_CONFIG['Belum Mengisi'];
                                const barColor = unit.persentase_terisi >= 100 ? '#059669' : (unit.persentase_terisi > 0 ? '#d97706' : '#dc2626');

                                return (
                                    <TableRow key={unit.unit_id} hover sx={{ '&:last-child td, &:last-child th': { border: 0 } }}>
                                        {/* Unit Name & Code */}
                                        <TableCell>
                                            <Stack spacing={0.5}>
                                                <Typography variant="body2" fontWeight={700} sx={{ color: '#0f172a' }}>
                                                    {unit.unit_nama}
                                                </Typography>
                                                <Box>
                                                    <Chip
                                                        label={unit.unit_kode}
                                                        size="small"
                                                        sx={{
                                                            fontSize: '0.7rem',
                                                            fontWeight: 800,
                                                            bgcolor: '#f1f5f9',
                                                            color: '#475569',
                                                            height: 20
                                                        }}
                                                    />
                                                </Box>
                                            </Stack>
                                        </TableCell>

                                        {/* Progress Bar & Indicators Count */}
                                        <TableCell>
                                            <Box sx={{ width: '100%', pr: 2 }}>
                                                <Stack direction="row" justifyContent="space-between" sx={{ mb: 0.5 }}>
                                                    <Typography variant="caption" fontWeight={700} sx={{ color: '#0f172a' }}>
                                                        {unit.terisi_count} / {unit.total_indikator} Indikator Terisi
                                                    </Typography>
                                                    <Typography variant="caption" fontWeight={800} sx={{ color: barColor }}>
                                                        {unit.persentase_terisi}%
                                                    </Typography>
                                                </Stack>
                                                <LinearProgress
                                                    variant="determinate"
                                                    value={Number(unit.persentase_terisi)}
                                                    sx={{
                                                        height: 8,
                                                        borderRadius: 4,
                                                        bgcolor: '#f1f5f9',
                                                        '& .MuiLinearProgress-bar': {
                                                            bgcolor: barColor,
                                                            borderRadius: 4
                                                        }
                                                    }}
                                                />
                                            </Box>
                                        </TableCell>

                                        {/* Status Chip */}
                                        <TableCell align="center">
                                            <Chip
                                                icon={statusCfg.icon}
                                                label={unit.status_pengisian}
                                                size="small"
                                                sx={{
                                                    fontWeight: 800,
                                                    color: statusCfg.color,
                                                    bgcolor: statusCfg.bgcolor,
                                                    border: statusCfg.border,
                                                    fontSize: '0.75rem'
                                                }}
                                            />
                                        </TableCell>

                                        {/* Average Performance */}
                                        <TableCell align="center">
                                            {unit.terisi_count > 0 ? (
                                                <Typography variant="body2" fontWeight={800} sx={{ color: '#0f172a' }}>
                                                    {unit.rata_capaian}%
                                                </Typography>
                                            ) : (
                                                <Typography variant="caption" color="text.secondary">-</Typography>
                                            )}
                                        </TableCell>

                                        {/* Action Button */}
                                        <TableCell align="center">
                                            <Button
                                                variant="outlined"
                                                size="small"
                                                startIcon={<VisibilityIcon fontSize="small" />}
                                                onClick={() => {
                                                    setSelectedUnit(unit);
                                                    setSearchRincian('');
                                                }}
                                                sx={{
                                                    textTransform: 'none',
                                                    fontWeight: 700,
                                                    fontSize: '0.75rem',
                                                    borderRadius: 2,
                                                    borderColor: '#cbd5e1',
                                                    color: '#334155',
                                                    '&:hover': {
                                                        bgcolor: '#f1f5f9',
                                                        borderColor: '#94a3b8'
                                                    }
                                                }}
                                            >
                                                Lihat Rincian
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                );
                            })
                        ) : (
                            <TableRow>
                                <TableCell colSpan={5} sx={{ textAlign: 'center', py: 5 }}>
                                    <Typography variant="body2" color="text.secondary">
                                        Belum ada data unit kerja yang ditemukan.
                                    </Typography>
                                </TableCell>
                            </TableRow>
                        )}
                    </TableBody>
                </Table>
            </TableContainer>

            {/* Modal Detail Rincian Indikator Per Unit */}
            {selectedUnit && (
                <Dialog
                    open={Boolean(selectedUnit)}
                    onClose={() => setSelectedUnit(null)}
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
                    {/* Dialog Header */}
                    <DialogTitle sx={{ p: 2.5, bgcolor: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                        <Stack direction="row" justifyContent="space-between" alignItems="center">
                            <Box>
                                <Stack direction="row" spacing={1} alignItems="center">
                                    <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                                        {selectedUnit.unit_nama}
                                    </Typography>
                                    <Chip
                                        label={selectedUnit.unit_kode}
                                        size="small"
                                        sx={{ bgcolor: '#0f172a', color: '#ffffff', fontWeight: 800, fontSize: '0.72rem' }}
                                    />
                                    {selectedStatusCfg && (
                                        <Chip
                                            icon={selectedStatusCfg.icon}
                                            label={selectedUnit.status_pengisian}
                                            size="small"
                                            sx={{
                                                fontWeight: 800,
                                                fontSize: '0.72rem',
                                                color: selectedStatusCfg.color,
                                                bgcolor: selectedStatusCfg.bgcolor,
                                                border: selectedStatusCfg.border
                                            }}
                                        />
                                    )}
                                </Stack>
                                <Typography variant="caption" sx={{ color: '#64748b', mt: 0.5, display: 'block' }}>
                                    Rincian Seluruh Indikator (IKK & IKP) &middot; TW {currentTriwulan} {currentTahun} &middot; Terisi {selectedUnit.terisi_count} dari {selectedUnit.total_indikator} Indikator ({selectedUnit.persentase_terisi}%)
                                </Typography>
                            </Box>
                            <IconButton onClick={() => setSelectedUnit(null)} size="small" sx={{ color: '#64748b' }}>
                                <CloseIcon />
                            </IconButton>
                        </Stack>
                    </DialogTitle>

                    {/* Dialog Content */}
                    <DialogContent sx={{ p: 3 }}>
                        {/* Search Bar */}
                        <Box sx={{ mb: 2.5 }}>
                            <TextField
                                size="small"
                                fullWidth
                                placeholder="Cari kode indikator atau nama indikator di unit ini..."
                                value={searchRincian}
                                onChange={(e) => setSearchRincian(e.target.value)}
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

                        {/* Indicators Table */}
                        <TableContainer component={Paper} elevation={0} sx={{ border: '1px solid #e2e8f0', borderRadius: 2.5, maxHeight: 440 }}>
                            <Table stickyHeader size="small">
                                <TableHead>
                                    <TableRow sx={{ '& th': { bgcolor: '#f8fafc', fontWeight: 800, color: '#0f172a', py: 1.5 } }}>
                                        <TableCell width={110}>Kode</TableCell>
                                        <TableCell width={80}>Level</TableCell>
                                        <TableCell>Nama Indikator</TableCell>
                                        <TableCell width={100} align="center">Target</TableCell>
                                        <TableCell width={100} align="center">Realisasi</TableCell>
                                        <TableCell width={120} align="center">Capaian (%)</TableCell>
                                        <TableCell width={130} align="center">Status Kinerja</TableCell>
                                    </TableRow>
                                </TableHead>
                                <TableBody>
                                    {filteredRincian.length > 0 ? (
                                        filteredRincian.map((item) => {
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
                                                <TableRow key={`${item.id}-${item.kode}`} hover sx={{ '&:last-child td, &:last-child th': { border: 0 } }}>
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
                                                        <Chip
                                                            label={item.tipe}
                                                            size="small"
                                                            color={item.tipe === 'IKP' ? 'info' : 'default'}
                                                            variant="outlined"
                                                            sx={{ fontWeight: 800, fontSize: '0.7rem' }}
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
                                                        {item.capaian != null ? (
                                                            <Chip
                                                                label={`${Number(item.capaian).toFixed(1)}%`}
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
                                                    Tidak ada indikator yang sesuai dengan pencarian.
                                                </Typography>
                                            </TableCell>
                                        </TableRow>
                                    )}
                                </TableBody>
                            </Table>
                        </TableContainer>
                    </DialogContent>

                    {/* Dialog Footer */}
                    <DialogActions sx={{ p: 2, px: 3, borderTop: '1px solid #e2e8f0', bgcolor: '#f8fafc' }}>
                        <Button onClick={() => setSelectedUnit(null)} variant="outlined" sx={{ borderRadius: 2, textTransform: 'none', fontWeight: 700 }}>
                            Tutup
                        </Button>
                    </DialogActions>
                </Dialog>
            )}
        </Paper>
    );
}
