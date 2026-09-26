import { Card, CardContent, Stack, Box, Chip, Typography, Divider, Button, CircularProgress } from '@mui/material';
import { Save as SaveIcon } from '@mui/icons-material';
import InputHelp from './InputHelp';
import FormulaFields from './FormulaFields';
import AnalysisFields from './AnalysisFields';
import { calculationLabel, formatCleanNumber } from '../Utils/inputHelpers';

export default function IkpCard({
    ikp,
    target,
    measurement,
    value = {},
    onChange,
    onSaveSingle,
    isSaving = false,
    loading = false
}) {
    const node = ikp?.node || {};
    const isTercapai = measurement?.status_capaian === 'TERCAPAI';

    return (
        <Card
            sx={{
                mb: 2.5,
                borderRadius: 3,
                border: '1px solid #e2e8f0',
                boxShadow: '0 2px 10px -2px rgba(15, 23, 42, 0.04)',
                borderLeft: `5px solid ${isTercapai ? '#059669' : '#3b82f6'}`
            }}
        >
            <CardContent sx={{ p: { xs: 2.5, md: 3 } }}>
                <Stack direction={{ xs: 'column', lg: 'row' }} justifyContent="space-between" alignItems={{ xs: 'flex-start', lg: 'center' }} spacing={1.5} sx={{ mb: 2 }}>
                    <Box sx={{ flex: 1, minWidth: 0, pr: { lg: 2 } }}>
                        <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 0.5, flexWrap: 'wrap' }}>
                            <Chip label={ikp.kode_ikp} size="small" sx={{ fontWeight: 800, bgcolor: '#0f172a', color: '#ffffff', borderRadius: 1.5 }} />
                            <Chip size="small" label={calculationLabel[node.calculation_type] || node.calculation_type || 'Formula'} sx={{ fontWeight: 600, bgcolor: '#eff6ff', color: '#2563eb' }} />
                            {node.satuan && <Chip size="small" variant="outlined" label={`Satuan: ${node.satuan}`} sx={{ fontWeight: 600 }} />}
                        </Stack>
                        <Typography fontWeight={800} variant="h6" sx={{ color: '#0f172a', mt: 0.5, wordBreak: 'break-word' }}>
                            {ikp.nama_ikp || node.nama}
                        </Typography>
                    </Box>

                    <Stack direction="row" flexWrap="wrap" gap={1} alignItems="center" sx={{ flexShrink: 0, mt: { xs: 1, lg: 0 } }}>
                        {target && (
                            <Chip
                                size="small"
                                variant="outlined"
                                label={`Target: ${formatCleanNumber(target.nilai_target ?? target.nilai_teks_sumber)} ${node.satuan || ''}`}
                                sx={{ fontWeight: 700, borderColor: '#cbd5e1', bgcolor: '#f8fafc' }}
                            />
                        )}
                        {measurement?.realisasi !== undefined && measurement?.realisasi !== null && (
                            <Chip
                                size="small"
                                label={`Realisasi: ${formatCleanNumber(measurement.realisasi)} ${node.satuan || ''}`}
                                sx={{ fontWeight: 700, bgcolor: '#eff6ff', color: '#1d4ed8' }}
                            />
                        )}
                        {measurement?.capaian !== undefined && measurement?.capaian !== null && (
                            <Chip
                                size="small"
                                label={`Capaian: ${formatCleanNumber(measurement.capaian)}%`}
                                sx={{ 
                                    fontWeight: 800, 
                                    bgcolor: measurement.capaian >= 100 ? '#f0fdf4' : '#fffbeb', 
                                    color: measurement.capaian >= 100 ? '#059669' : '#d97706',
                                    border: `1px solid ${measurement.capaian >= 100 ? '#bbf7d0' : '#fde68a'}`
                                }}
                            />
                        )}
                        {measurement?.status_capaian && (
                            <Chip
                                size="small"
                                color={
                                    measurement.status_capaian === 'TERCAPAI' ? 'success' :
                                    measurement.status_capaian === 'BELUM_TERCAPAI' ? 'warning' :
                                    measurement.status_capaian === 'TIDAK_TERCAPAI' ? 'error' : 'default'
                                }
                                label={measurement.status_capaian}
                                sx={{ fontWeight: 800 }}
                            />
                        )}
                    </Stack>
                </Stack>

                <Divider sx={{ mb: 2.5 }} />
                <InputHelp entity={ikp} />
                <FormulaFields entity={ikp} value={value} onChange={onChange} />
                <AnalysisFields value={value} onChange={onChange} />

                {/* Single IKP Save & Calculate Action */}
                <Box
                    sx={{
                        mt: 3,
                        pt: 2,
                        borderTop: '1px solid #e2e8f0',
                        display: 'flex',
                        flexDirection: { xs: 'column', sm: 'row' },
                        justifyContent: 'space-between',
                        alignItems: { xs: 'stretch', sm: 'center' },
                        gap: 1.5,
                    }}
                >
                    <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 600 }}>
                        Simpan data untuk indikator <strong>{ikp.kode_ikp}</strong> secara mandiri tanpa harus submit bulk.
                    </Typography>
                    <Button
                        type="button"
                        variant="contained"
                        size="small"
                        onClick={() => onSaveSingle('IKP', ikp.kode_ikp)}
                        disabled={isSaving || loading}
                        startIcon={isSaving ? <CircularProgress size={16} color="inherit" /> : <SaveIcon />}
                        sx={{
                            bgcolor: '#0284c7',
                            color: '#ffffff',
                            background: 'linear-gradient(135deg, #0284c7 0%, #0369a1 100%)',
                            fontWeight: 700,
                            borderRadius: 2,
                            px: 2.5,
                            py: 0.8,
                            boxShadow: '0 2px 8px rgba(2, 132, 199, 0.25)',
                            textTransform: 'none',
                            fontSize: '0.875rem',
                            whiteSpace: 'nowrap',
                            '&:hover': {
                                background: 'linear-gradient(135deg, #0369a1 0%, #075985 100%)',
                            }
                        }}
                    >
                        {isSaving ? 'Menyimpan & Menghitung...' : 'Simpan & Hitung Kinerja'}
                    </Button>
                </Box>
            </CardContent>
        </Card>
    );
}
