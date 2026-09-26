import { Paper, Box, Stack, Chip, Typography, IconButton, Collapse } from '@mui/material';
import {
    AccountTree as TreeIcon,
    ExpandMore as ExpandMoreIcon,
    ExpandLess as ExpandLessIcon
} from '@mui/icons-material';

export default function SkAccordion({
    skKode,
    skNama,
    ikkCount = 0,
    isCollapsed = false,
    onToggle,
    children
}) {
    return (
        <Paper
            elevation={0}
            sx={{
                mb: 3,
                borderRadius: 3,
                border: '1px solid #e2e8f0',
                bgcolor: '#ffffff',
                overflow: 'hidden'
            }}
        >
            {/* SK Header with Toggle */}
            <Box
                onClick={onToggle}
                sx={{
                    p: 2,
                    bgcolor: '#f1f5f9',
                    cursor: 'pointer',
                    display: 'flex',
                    flexDirection: { xs: 'column', sm: 'row' },
                    justifyContent: 'space-between',
                    alignItems: { xs: 'flex-start', sm: 'center' },
                    gap: 1.5,
                    borderBottom: isCollapsed ? 'none' : '1px solid #e2e8f0',
                    userSelect: 'none',
                    transition: 'background 0.2s',
                    '&:hover': { bgcolor: '#e2e8f0' }
                }}
            >
                <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5, flex: 1, minWidth: 0, mr: { sm: 2 } }}>
                    <Box sx={{
                        width: 32,
                        height: 32,
                        borderRadius: 2,
                        bgcolor: '#e0f2fe',
                        color: '#0284c7',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                        flexShrink: 0
                    }}>
                        <TreeIcon sx={{ fontSize: 18 }} />
                    </Box>
                    <Box sx={{ flex: 1, minWidth: 0 }}>
                        <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 0.25, flexWrap: 'wrap' }}>
                            <Chip
                                label={skKode}
                                size="small"
                                sx={{ bgcolor: '#0284c7', color: '#ffffff', fontWeight: 800, fontSize: '0.72rem', height: 22 }}
                            />
                            <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                Sasaran Kegiatan
                            </Typography>
                        </Stack>
                        <Typography variant="body2" fontWeight={700} sx={{ color: '#1e293b', wordBreak: 'break-word' }}>
                            {skNama}
                        </Typography>
                    </Box>
                </Box>

                <Stack direction="row" spacing={1.5} alignItems="center" sx={{ alignSelf: { xs: 'flex-end', sm: 'center' }, flexShrink: 0 }}>
                    <Chip
                        label={`${ikkCount} IKK`}
                        size="small"
                        variant="outlined"
                        sx={{ fontWeight: 700, borderColor: '#cbd5e1', bgcolor: '#ffffff' }}
                    />
                    <IconButton size="small" sx={{ color: '#64748b' }}>
                        {isCollapsed ? <ExpandMoreIcon /> : <ExpandLessIcon />}
                    </IconButton>
                </Stack>
            </Box>

            {/* Collapsible SK Content with IKK cards */}
            <Collapse in={!isCollapsed}>
                <Box sx={{ p: { xs: 2, md: 2.5 }, bgcolor: '#ffffff' }}>
                    {children}
                </Box>
            </Collapse>
        </Paper>
    );
}
