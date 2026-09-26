import { Paper, Stack, Box, Typography, Divider, Chip } from '@mui/material';
import {
    BarChart as BarChartIcon,
    TrendingUp as TrendingUpIcon
} from '@mui/icons-material';
import { BarChart } from '@mui/x-charts/BarChart';

export default function SkBarChart({
    skBarData = [],
    rataCapaian = 0
}) {
    return (
        <Paper sx={{ p: 3, mb: 4, borderRadius: 3.5, border: '1px solid #e2e8f0', boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)' }}>
            <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 0.5 }}>
                <Stack direction="row" spacing={1.5} alignItems="center">
                    <Box sx={{ width: 36, height: 36, borderRadius: 2, bgcolor: '#f5f3ff', color: '#7c3aed', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                        <BarChartIcon fontSize="small" />
                    </Box>
                    <Box>
                        <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', lineHeight: 1.2 }}>
                            Rata-Rata Capaian per Sasaran Kegiatan (SK)
                        </Typography>
                        <Typography variant="caption" sx={{ color: '#64748b' }}>
                            Perbandingan performa capaian agregat pada tiap Sasaran Kegiatan yang diampu
                        </Typography>
                    </Box>
                </Stack>
                <Chip 
                    icon={<TrendingUpIcon sx={{ fontSize: '0.9rem !important' }} />}
                    label={`Rata-rata Unit: ${rataCapaian}%`}
                    size="small"
                    sx={{ bgcolor: '#eff6ff', color: '#2563eb', fontWeight: 700, border: '1px solid #bfdbfe' }}
                />
            </Stack>
            <Divider sx={{ my: 2 }} />

            <Box sx={{ height: 320, width: '100%' }}>
                {skBarData.length > 0 ? (
                    <BarChart
                        dataset={skBarData}
                        xAxis={[{ 
                            scaleType: 'band', 
                            dataKey: 'sk',
                            tickLabelStyle: { fontSize: 11, fontWeight: 700 }
                        }]}
                        series={[{ 
                            dataKey: 'capaian', 
                            label: 'Rata-Rata Capaian (%)', 
                            color: '#0d9488'
                        }]}
                        height={300}
                        margin={{ top: 20, bottom: 45, left: 55, right: 20 }}
                    />
                ) : (
                    <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '100%' }}>
                        <Typography color="text.secondary">Belum ada data sasaran kegiatan untuk ditampilkan</Typography>
                    </Box>
                )}
            </Box>
        </Paper>
    );
}
