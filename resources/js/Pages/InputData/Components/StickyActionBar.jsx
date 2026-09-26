import { Paper, Stack, Typography, Button, CircularProgress } from '@mui/material';
import { Save as SaveIcon } from '@mui/icons-material';

export default function StickyActionBar({
    loading = false
}) {
    return (
        <Paper 
            elevation={4} 
            sx={{ 
                position: 'sticky', 
                bottom: 20, 
                p: 2, 
                borderRadius: 3, 
                border: '1px solid rgba(0,0,0,0.08)', 
                bgcolor: 'rgba(255, 255, 255, 0.95)', 
                backdropFilter: 'blur(12px)',
                boxShadow: '0 10px 30px rgba(0,0,0,0.12)',
                zIndex: 10
            }}
        >
            <Stack direction="row" justifyContent="space-between" alignItems="center">
                <Typography variant="body2" sx={{ color: '#64748b', fontWeight: 600, display: { xs: 'none', sm: 'block' } }}>
                    Pastikan data input telah terisi lengkap sebelum menyimpan.
                </Typography>
                <Button 
                    type="submit" 
                    variant="contained" 
                    size="large" 
                    startIcon={loading ? <CircularProgress size={18} color="inherit" /> : <SaveIcon />} 
                    disabled={loading}
                    sx={{
                        bgcolor: '#059669',
                        color: '#ffffff',
                        background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                        fontWeight: 700,
                        borderRadius: 2.5,
                        px: 4,
                        py: 1.2,
                        boxShadow: '0 4px 14px rgba(5, 150, 105, 0.4)',
                        '&:hover': {
                            background: 'linear-gradient(135deg, #047857 0%, #059669 100%)',
                        }
                    }}
                >
                    {loading ? 'Menyimpan & Menghitung...' : 'Simpan & Hitung Kinerja'}
                </Button>
            </Stack>
        </Paper>
    );
}
