import { Paper, Stack, Box, Typography, Divider, Chip } from '@mui/material';
import { AssignmentTurnedIn as AssignmentTurnedInIcon } from '@mui/icons-material';
import { PieChart } from '@mui/x-charts/PieChart';

export default function ProgressPieChart({
    pengisianPieData = [],
    actualStats = {},
    progress = 0
}) {
    return (
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

            <Box sx={{ width: '100%', maxWidth: '100%', overflow: 'hidden', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center', minHeight: 260 }}>
                {pengisianPieData.length > 0 ? (
                    <>
                        <PieChart
                            series={[{ 
                                data: pengisianPieData,
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
                                label={`Sudah Diisi: ${actualStats.terisi || 0} (${progress.toFixed(0)}%)`}
                                size="small"
                                sx={{ bgcolor: '#ecfdf5', color: '#059669', fontWeight: 700, border: '1px solid #a7f3d0' }}
                            />
                            <Chip 
                                label={`Belum Diisi: ${Math.max(0, (actualStats.total || 0) - (actualStats.terisi || 0))} (${(100 - progress).toFixed(0)}%)`}
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
    );
}
