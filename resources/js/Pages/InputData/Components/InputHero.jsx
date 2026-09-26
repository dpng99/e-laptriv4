import { Paper, Stack, Box, Chip, Typography, Select, MenuItem } from '@mui/material';

export default function InputHero({
    selectedBiro,
    bidangId,
    tahun,
    triwulan,
    onPeriodChange
}) {
    return (
        <Paper 
            elevation={0} 
            sx={{ 
                p: { xs: 3, md: 3.5 }, 
                mb: 3.5, 
                borderRadius: 3.5, 
                background: 'linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #064e3b 100%)', 
                color: 'white',
                border: '1px solid rgba(255,255,255,0.08)' 
            }}
        >
            <Stack direction={{ xs: 'column', md: 'row' }} justifyContent="space-between" alignItems={{ md: 'center' }} spacing={2.5}>
                <Box sx={{ flex: 1, minWidth: 0 }}>
                    <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1, flexWrap: 'wrap' }}>
                        <Chip 
                            label={bidangId || 'UNIT KERJA'} 
                            size="small" 
                            sx={{ bgcolor: 'rgba(16, 185, 129, 0.2)', color: '#34d399', fontWeight: 700, border: '1px solid rgba(16, 185, 129, 0.4)' }} 
                        />
                        <Chip 
                            label="Canonical Formula Engine" 
                            size="small" 
                            sx={{ bgcolor: 'rgba(255,255,255,0.1)', color: '#e2e8f0', fontWeight: 600 }} 
                        />
                    </Stack>
                    <Typography variant="h4" fontWeight={800} sx={{ letterSpacing: -0.5, wordBreak: 'break-word' }}>
                        Pengukuran Kinerja — {selectedBiro}
                    </Typography>
                    <Typography variant="body2" sx={{ color: '#94a3b8', mt: 0.5, maxWidth: 650, wordBreak: 'break-word' }}>
                        Input mengikuti formula resmi indikator; Realisasi dan Capaian terhadap target dihitung otomatis dan independen.
                    </Typography>
                </Box>

                {/* Period Switcher */}
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
                            onChange={(e) => onPeriodChange('tahun', e.target.value)}
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
                            {[2025, 2026, 2027, 2028, 2029].map((year) => (
                                <MenuItem key={year} value={year}>Tahun {year}</MenuItem>
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
                            onChange={(e) => onPeriodChange('triwulan', e.target.value)}
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
                            {[1, 2, 3, 4].map((quarter) => (
                                <MenuItem key={quarter} value={quarter}>Triwulan {quarter}</MenuItem>
                            ))}
                        </Select>
                    </Box>
                </Stack>
            </Stack>
        </Paper>
    );
}
