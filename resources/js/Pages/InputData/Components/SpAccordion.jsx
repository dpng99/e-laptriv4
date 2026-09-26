import { Paper, Box, Stack, Chip, Typography, IconButton, Collapse } from '@mui/material';
import {
    FolderSpecial as FolderSpecialIcon,
    ExpandMore as ExpandMoreIcon,
    ExpandLess as ExpandLessIcon
} from '@mui/icons-material';

export default function SpAccordion({
    spKode,
    spNama,
    isCollapsed = false,
    onToggle,
    badgeChips = [],
    children
}) {
    return (
        <Paper
            elevation={0}
            sx={{
                mb: 3.5,
                borderRadius: 3.5,
                border: '1px solid #cbd5e1',
                overflow: 'hidden',
                boxShadow: '0 4px 20px -4px rgba(15, 23, 42, 0.06)'
            }}
        >
            {/* SP Header with Toggle */}
            <Box
                onClick={onToggle}
                sx={{
                    p: { xs: 2, md: 2.5 },
                    background: 'linear-gradient(135deg, #0f172a 0%, #1e293b 100%)',
                    color: '#ffffff',
                    cursor: 'pointer',
                    display: 'flex',
                    flexDirection: { xs: 'column', sm: 'row' },
                    justifyContent: 'space-between',
                    alignItems: { xs: 'flex-start', sm: 'center' },
                    gap: 1.5,
                    userSelect: 'none',
                    transition: 'background 0.2s',
                    '&:hover': { background: 'linear-gradient(135deg, #1e293b 0%, #334155 100%)' }
                }}
            >
                <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5, flex: 1, minWidth: 0, mr: { sm: 2 } }}>
                    <Box sx={{
                        width: 40,
                        height: 40,
                        borderRadius: 2.5,
                        bgcolor: 'rgba(16, 185, 129, 0.2)',
                        color: '#34d399',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                        border: '1px solid rgba(16, 185, 129, 0.3)',
                        flexShrink: 0
                    }}>
                        <FolderSpecialIcon sx={{ fontSize: 22 }} />
                    </Box>
                    <Box sx={{ flex: 1, minWidth: 0 }}>
                        <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 0.5, flexWrap: 'wrap' }}>
                            <Chip
                                label={spKode}
                                size="small"
                                sx={{ bgcolor: '#10b981', color: '#ffffff', fontWeight: 800, fontSize: '0.75rem', height: 24 }}
                            />
                            <Typography variant="caption" sx={{ color: '#94a3b8', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                Sasaran Program
                            </Typography>
                        </Stack>
                        <Typography variant="subtitle1" fontWeight={800} sx={{ color: '#f8fafc', lineHeight: 1.3, wordBreak: 'break-word' }}>
                            {spNama}
                        </Typography>
                    </Box>
                </Box>

                <Stack direction="row" spacing={1.5} alignItems="center" sx={{ alignSelf: { xs: 'flex-end', sm: 'center' }, flexShrink: 0 }}>
                    {badgeChips.map((badge, idx) => (
                        <Chip
                            key={idx}
                            label={badge.label}
                            size="small"
                            sx={badge.sx || { bgcolor: 'rgba(255,255,255,0.12)', color: '#e2e8f0', fontWeight: 700 }}
                        />
                    ))}
                    <IconButton size="small" sx={{ color: '#ffffff' }}>
                        {isCollapsed ? <ExpandMoreIcon /> : <ExpandLessIcon />}
                    </IconButton>
                </Stack>
            </Box>

            {/* Collapsible SP Content */}
            <Collapse in={!isCollapsed}>
                <Box sx={{ p: { xs: 2, md: 3 }, bgcolor: '#f8fafc' }}>
                    {children}
                </Box>
            </Collapse>
        </Paper>
    );
}
