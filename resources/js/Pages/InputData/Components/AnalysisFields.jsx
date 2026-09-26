import { Box, Typography, Grid, TextField } from '@mui/material';

export default function AnalysisFields({ value = {}, onChange }) {
    return (
        <Box sx={{ mt: 1 }}>
            <Typography variant="caption" sx={{ color: '#475569', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5, mb: 1.5, display: 'block' }}>
                Analisis Kualitatif & Rekomendasi
            </Typography>
            <Grid container spacing={2}>
                <Grid item xs={12} md={4}>
                    <TextField
                        fullWidth
                        size="small"
                        multiline
                        minRows={3}
                        label="Analisis Capaian Kinerja"
                        placeholder="Uraian faktor penyebab keberhasilan capaian..."
                        value={value.analisis_capaian ?? ''}
                        onChange={(e) => onChange('analisis_capaian', e.target.value)}
                        InputProps={{ sx: { bgcolor: '#ffffff', borderRadius: 2 } }}
                    />
                </Grid>
                <Grid item xs={12} md={4}>
                    <TextField
                        fullWidth
                        size="small"
                        multiline
                        minRows={3}
                        label="Kendala / Hambatan"
                        placeholder="Permasalahan yang dihadapi selama pelaksanaan kegiatan..."
                        value={value.kendala ?? ''}
                        onChange={(e) => onChange('kendala', e.target.value)}
                        InputProps={{ sx: { bgcolor: '#ffffff', borderRadius: 2 } }}
                    />
                </Grid>
                <Grid item xs={12} md={4}>
                    <TextField
                        fullWidth
                        size="small"
                        multiline
                        minRows={3}
                        label="Upaya / Rencana Tindak Lanjut"
                        placeholder="Solusi atau strategi perbaikan untuk periode selanjutnya..."
                        value={value.upaya ?? ''}
                        onChange={(e) => onChange('upaya', e.target.value)}
                        InputProps={{ sx: { bgcolor: '#ffffff', borderRadius: 2 } }}
                    />
                </Grid>
            </Grid>
        </Box>
    );
}
