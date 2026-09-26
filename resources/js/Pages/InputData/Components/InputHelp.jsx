import { Paper, Typography, Box } from '@mui/material';
import { Functions as FunctionsIcon } from '@mui/icons-material';
import { formulaFor } from '../Utils/inputHelpers';

export default function InputHelp({ entity }) {
    const formula = formulaFor(entity);
    if (!formula?.rumus_tampilan && !formula?.status_formula) return null;

    return (
        <Paper
            variant="outlined"
            sx={{
                p: 2,
                mb: 2.5,
                borderRadius: 2,
                bgcolor: '#f0fdf4',
                borderColor: '#bbf7d0',
                display: 'flex',
                gap: 1.5,
                alignItems: 'flex-start'
            }}
        >
            <FunctionsIcon sx={{ color: '#059669', mt: 0.25, fontSize: 20, flexShrink: 0 }} />
            <Box sx={{ flex: 1, minWidth: 0 }}>
                {formula.rumus_tampilan && (
                    <Typography variant="body2" sx={{ color: '#065f46', fontWeight: 700, wordBreak: 'break-word' }}>
                        Formula Perhitungan:{' '}
                        <Box component="code" sx={{ px: 1, py: 0.25, bgcolor: '#ffffff', border: '1px solid #a7f3d0', borderRadius: 1, fontFamily: 'monospace', fontWeight: 600, display: 'inline-block', maxWidth: '100%', wordBreak: 'break-word', whiteSpace: 'normal' }}>
                            {formula.rumus_tampilan}
                        </Box>
                    </Typography>
                )}
                {formula.status_formula && (
                    <Typography variant="caption" sx={{ color: '#047857', display: 'block', mt: 0.5, wordBreak: 'break-word' }}>
                        {formula.status_formula}
                    </Typography>
                )}
            </Box>
        </Paper>
    );
}
