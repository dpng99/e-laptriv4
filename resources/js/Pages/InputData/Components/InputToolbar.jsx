import { Paper, Stack, TextField, InputAdornment, Button, Typography } from '@mui/material';
import {
    Search as SearchIcon,
    UnfoldMore as UnfoldMoreIcon,
    UnfoldLess as UnfoldLessIcon
} from '@mui/icons-material';

export default function InputToolbar({
    searchKeyword,
    onSearchChange,
    onResetSearch,
    onExpandAll,
    onCollapseAll
}) {
    return (
        <Paper
            elevation={0}
            sx={{
                p: 2,
                mb: 3,
                borderRadius: 2.5,
                bgcolor: '#ffffff',
                border: '1px solid #e2e8f0',
                display: 'flex',
                flexDirection: { xs: 'column', sm: 'row' },
                justifyContent: 'space-between',
                alignItems: { xs: 'stretch', sm: 'center' },
                gap: 2,
            }}
        >
            <Stack direction="row" spacing={1.5} alignItems="center" sx={{ flexGrow: 1, maxWidth: { sm: 380 } }}>
                <TextField
                    fullWidth
                    size="small"
                    placeholder="Cari indikator, nama kegiatan, atau kode..."
                    value={searchKeyword}
                    onChange={(e) => onSearchChange(e.target.value)}
                    InputProps={{
                        startAdornment: (
                            <InputAdornment position="start">
                                <SearchIcon sx={{ color: '#94a3b8', fontSize: 20 }} />
                            </InputAdornment>
                        ),
                        sx: { borderRadius: 2, bgcolor: '#f8fafc' }
                    }}
                />
                {searchKeyword && (
                    <Button 
                        size="small" 
                        onClick={onResetSearch} 
                        sx={{ color: '#64748b', textTransform: 'none', whiteSpace: 'nowrap' }}
                    >
                        Reset
                    </Button>
                )}
            </Stack>

            <Stack direction="row" spacing={1} alignItems="center" justifyContent={{ xs: 'space-between', sm: 'flex-end' }}>
                <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 600, display: { xs: 'none', md: 'block' } }}>
                    Kontrol Tampilan:
                </Typography>
                <Button
                    size="small"
                    variant="outlined"
                    startIcon={<UnfoldMoreIcon />}
                    onClick={onExpandAll}
                    sx={{
                        fontWeight: 700,
                        textTransform: 'none',
                        borderRadius: 2,
                        borderColor: '#cbd5e1',
                        color: '#334155',
                        bgcolor: '#ffffff',
                        '&:hover': { bgcolor: '#f8fafc', borderColor: '#94a3b8' }
                    }}
                >
                    Buka Semua
                </Button>
                <Button
                    size="small"
                    variant="outlined"
                    startIcon={<UnfoldLessIcon />}
                    onClick={onCollapseAll}
                    sx={{
                        fontWeight: 700,
                        textTransform: 'none',
                        borderRadius: 2,
                        borderColor: '#cbd5e1',
                        color: '#334155',
                        bgcolor: '#ffffff',
                        '&:hover': { bgcolor: '#f8fafc', borderColor: '#94a3b8' }
                    }}
                >
                    Tutup Semua
                </Button>
            </Stack>
        </Paper>
    );
}
