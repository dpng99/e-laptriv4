import { Link } from '@inertiajs/react';
import { Paper, Grid, Stack, Chip, Typography, ToggleButtonGroup, ToggleButton, Button } from '@mui/material';
import { EditNote as EditNoteIcon } from '@mui/icons-material';

export default function DashboardHero({
    unitName,
    currentTahun,
    currentTriwulan,
    onTriwulanChange
}) {
    return (
        <Paper 
            elevation={0}
            sx={{
                p: { xs: 3, md: 3.5 },
                mb: 3.5,
                borderRadius: 3.5,
                background: 'linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #064e3b 100%)',
                color: '#ffffff',
                position: 'relative',
                overflow: 'hidden',
                border: '1px solid rgba(255,255,255,0.08)'
            }}
        >
            <Grid container spacing={3} alignItems="center" justifyContent="space-between">
                <Grid item xs={12} md={7}>
                    <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1.5 }}>
                        <Chip 
                            label={`Tahun ${currentTahun} · Triwulan ${currentTriwulan}`}
                            size="small"
                            sx={{ 
                                bgcolor: 'rgba(16, 185, 129, 0.2)', 
                                color: '#34d399', 
                                fontWeight: 700, 
                                border: '1px solid rgba(16, 185, 129, 0.4)' 
                            }}
                        />
                        <Chip 
                            label="Unit Operator" 
                            size="small" 
                            sx={{ bgcolor: 'rgba(255,255,255,0.1)', color: '#e2e8f0', fontWeight: 600 }} 
                        />
                    </Stack>

                    <Typography variant="h4" fontWeight={800} sx={{ letterSpacing: -0.5, color: '#f8fafc', mb: 1, wordBreak: 'break-word' }}>
                        Kinerja {unitName}
                    </Typography>
                    <Typography variant="body2" sx={{ color: '#94a3b8', lineHeight: 1.6, maxWidth: 620, wordBreak: 'break-word' }}>
                        Visualisasi diagram capaian kinerja Indikator Kinerja Kegiatan (IKK) dan Sasaran Kegiatan (SK) unit kerja secara komprehensif.
                    </Typography>
                </Grid>

                <Grid item xs={12} md={5} sx={{ textAlign: { xs: 'left', md: 'right' } }}>
                    <Stack direction={{ xs: 'column', sm: 'row' }} spacing={1.5} justifyContent={{ md: 'flex-end' }} alignItems="center">
                        {/* Quarter Selector */}
                        <ToggleButtonGroup
                            value={currentTriwulan}
                            exclusive
                            onChange={onTriwulanChange}
                            size="small"
                            sx={{
                                bgcolor: 'rgba(255,255,255,0.1)',
                                borderRadius: 2.5,
                                border: '1px solid rgba(255,255,255,0.15)',
                                '& .MuiToggleButton-root': {
                                    color: '#cbd5e1',
                                    fontWeight: 700,
                                    px: 1.8,
                                    py: 0.8,
                                    border: 'none',
                                    fontSize: '0.8rem',
                                    '&.Mui-selected': {
                                        bgcolor: '#10b981',
                                        color: '#ffffff',
                                        '&:hover': { bgcolor: '#059669' }
                                    }
                                }
                            }}
                        >
                            <ToggleButton value={1}>TW I</ToggleButton>
                            <ToggleButton value={2}>TW II</ToggleButton>
                            <ToggleButton value={3}>TW III</ToggleButton>
                            <ToggleButton value={4}>TW IV</ToggleButton>
                        </ToggleButtonGroup>

                        <Button
                            component={Link}
                            href={route('input-data.index', { tahun: currentTahun, triwulan: currentTriwulan })}
                            variant="contained"
                            size="large"
                            startIcon={<EditNoteIcon />}
                            sx={{
                                bgcolor: '#059669',
                                color: '#ffffff',
                                background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                                fontWeight: 700,
                                borderRadius: 2.5,
                                px: 2.5,
                                whiteSpace: 'nowrap',
                                boxShadow: '0 4px 14px rgba(5, 150, 105, 0.4)',
                                '&:hover': {
                                    background: 'linear-gradient(135deg, #047857 0%, #059669 100%)',
                                }
                            }}
                        >
                            Input Pengukuran
                        </Button>
                    </Stack>
                </Grid>
            </Grid>
        </Paper>
    );
}
