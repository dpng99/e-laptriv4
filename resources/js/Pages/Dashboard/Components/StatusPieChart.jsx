import { Paper, Stack, Box, Typography, Divider, Chip } from '@mui/material';
import {
    PieChart as PieChartIcon,
    CheckCircle as CheckCircleIcon,
    Warning as WarningIcon,
    HelpOutlineOutlined as HelpIcon
} from '@mui/icons-material';
import { PieChart } from '@mui/x-charts/PieChart';

export default function StatusPieChart({
    statusPieData = [],
    actualStats = {},
    currentTriwulan
}) {
    return (
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

            <Box sx={{ width: '100%', maxWidth: '100%', overflow: 'hidden', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center', minHeight: 260 }}>
                {statusPieData.length > 0 ? (
                    <>
                        <PieChart
                            series={[{ 
                                data: statusPieData,
                                highlightScope: { faded: 'global', highlighted: 'item' },
                                faded: { innerRadius: 25, additionalRadius: -25, color: 'gray' },
                                innerRadius: 45,
                                outerRadius: 85,
                                paddingAngle: 3,
                                cornerRadius: 6,
                            }]}
                            width={320}
                            height={220}
                        />
                        <Stack direction="row" spacing={1.5} flexWrap="wrap" justifyContent="center" sx={{ mt: 1 }}>
                            <Chip 
                                icon={<CheckCircleIcon sx={{ fontSize: '0.9rem !important' }} />}
                                label={`Tercapai: ${actualStats.tercapai || 0}`}
                                size="small"
                                sx={{ bgcolor: '#ecfdf5', color: '#059669', fontWeight: 700, border: '1px solid #a7f3d0' }}
                            />
                            <Chip 
                                icon={<WarningIcon sx={{ fontSize: '0.9rem !important' }} />}
                                label={`Belum Tercapai: ${actualStats.belum_tercapai || 0}`}
                                size="small"
                                sx={{ bgcolor: '#fffbeb', color: '#d97706', fontWeight: 700, border: '1px solid #fde68a' }}
                            />
                            <Chip 
                                icon={<HelpIcon sx={{ fontSize: '0.9rem !important' }} />}
                                label={`Belum Diisi: ${actualStats.belum_diisi || 0}`}
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
    );
}
