import { Link } from '@inertiajs/react';
import { Paper, Stack, Box, Typography, Divider, Button } from '@mui/material';
import {
    Speed as SpeedIcon,
    ArrowForward as ArrowForwardIcon
} from '@mui/icons-material';
import { BarChart } from '@mui/x-charts/BarChart';

export default function IkkBarChart({
    ikkBarData = [],
    currentTahun = 2025,
    currentTriwulan = 1
}) {
    return (
        <Paper sx={{ p: 3, mb: 4, borderRadius: 3.5, border: '1px solid #e2e8f0', boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)' }}>
            <Stack direction={{ xs: 'column', sm: 'row' }} justifyContent="space-between" alignItems={{ sm: 'center' }} spacing={1} sx={{ mb: 0.5 }}>
                <Stack direction="row" spacing={1.5} alignItems="center">
                    <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#fff7ed', color: '#ea580c', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                        <SpeedIcon fontSize="small" />
                    </Box>
                    <Box>
                        <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', lineHeight: 1.2 }}>
                            Capaian Kinerja per Indikator (IKK)
                        </Typography>
                        <Typography variant="caption" sx={{ color: '#64748b' }}>
                            Distribusi persentase capaian seluruh IKK terhadap target Renstra Triwulan {currentTriwulan}
                        </Typography>
                    </Box>
                </Stack>

                <Button
                    component={Link}
                    href={route('input-data.index', { tahun: currentTahun, triwulan: currentTriwulan })}
                    size="small"
                    endIcon={<ArrowForwardIcon />}
                    sx={{ fontWeight: 700, textTransform: 'none', color: '#059669', alignSelf: { xs: 'flex-start', sm: 'center' } }}
                >
                    Buka Menu Pengukuran & Input Data
                </Button>
            </Stack>
            <Divider sx={{ my: 2 }} />

            <Box sx={{ height: 340, width: '100%' }}>
                {ikkBarData.length > 0 ? (
                    <BarChart
                        dataset={ikkBarData}
                        xAxis={[{ 
                            scaleType: 'band', 
                            dataKey: 'ikk',
                            tickLabelStyle: { 
                                angle: -40, 
                                textAnchor: 'end',
                                fontSize: 10,
                                fontWeight: 700
                            }
                        }]}
                        series={[{ 
                            dataKey: 'capaian', 
                            label: 'Capaian (%)', 
                            color: '#2563eb' 
                        }]}
                        height={320}
                        margin={{ top: 20, bottom: 65, left: 55, right: 20 }}
                    />
                ) : (
                    <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '100%' }}>
                        <Typography color="text.secondary">Belum ada indikator yang terdaftar</Typography>
                    </Box>
                )}
            </Box>
        </Paper>
    );
}
