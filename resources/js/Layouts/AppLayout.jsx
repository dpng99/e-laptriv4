import { useState } from 'react';
import { 
    Box, Drawer, AppBar, Toolbar, List, Typography, Divider, IconButton, 
    ListItem, ListItemButton, ListItemIcon, ListItemText, Menu, MenuItem, Avatar,
    Chip, Stack, Tooltip, useTheme, useMediaQuery
} from '@mui/material';
import {
    Menu as MenuIcon,
    Dashboard as DashboardIcon,
    EditNote as EditNoteIcon,
    TableChart as TableChartIcon,
    PictureAsPdf as PdfIcon,
    AccountCircle,
    DashboardCustomize as DashboardCustomizeIcon,
    Functions as FunctionsIcon,
    Logout as LogoutIcon,
    Person as PersonIcon,
    Shield as ShieldIcon,
    CalendarMonth as CalendarIcon,
    KeyboardArrowDown as ArrowDownIcon,
    Business as BusinessIcon,
    DesignServices as TemplateIcon
} from '@mui/icons-material';
import { Link, usePage, router } from '@inertiajs/react';

const drawerWidth = 270;

export default function AppLayout({ children, title }) {
    const { auth } = usePage().props;
    const user = auth?.user || {};
    const roleId = String(user.role_id || user.kinerja_role || '').trim().toUpperCase();
    const isAdmin = roleId === 'ADMIN' || roleId === '1';
    const [mobileOpen, setMobileOpen] = useState(false);
    const [anchorEl, setAnchorEl] = useState(null);

    const handleDrawerToggle = () => {
        setMobileOpen(!mobileOpen);
    };

    const handleMenu = (event) => {
        setAnchorEl(event.currentTarget);
    };

    const handleClose = () => {
        setAnchorEl(null);
    };

    const handleLogout = () => {
        router.post(route('logout'));
    };

    const currentUnitName = user.nama_satker || user.bidang_id || 'JAMBIN';

    const drawerContent = (
        <Box sx={{ 
            display: 'flex', 
            flexDirection: 'column', 
            height: '100%', 
            bgcolor: '#0f172a', 
            color: '#f8fafc' 
        }}>
            {/* Header Brand */}
            <Box sx={{ p: 2.5, pb: 2 }}>
                <Stack direction="row" spacing={1.5} alignItems="center">
                    <Box sx={{
                        width: 42,
                        height: 42,
                        borderRadius: '10px',
                        background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                        boxShadow: '0 4px 14px rgba(5, 150, 105, 0.4)',
                        color: 'white'
                    }}>
                        <ShieldIcon sx={{ fontSize: 24 }} />
                    </Box>
                    <Box>
                        <Stack direction="row" spacing={0.75} alignItems="center">
                            <Typography variant="subtitle1" sx={{ fontWeight: 800, color: '#ffffff', letterSpacing: '-0.02em', lineHeight: 1.2 }}>
                                e-LKjIP
                            </Typography>
                            <Chip 
                                label="JAMBIN" 
                                size="small" 
                                sx={{ 
                                    height: 18, 
                                    fontSize: '0.65rem', 
                                    fontWeight: 800, 
                                    bgcolor: 'rgba(245, 158, 11, 0.2)', 
                                    color: '#f59e0b',
                                    border: '1px solid rgba(245, 158, 11, 0.4)'
                                }} 
                            />
                        </Stack>
                        <Typography variant="caption" sx={{ color: '#94a3b8', fontSize: '0.7rem', fontWeight: 500 }}>
                            KEJAKSAAN AGUNG R.I.
                        </Typography>
                    </Box>
                </Stack>

                {/* User Active Unit Card */}
                <Box sx={{ 
                    mt: 2, 
                    p: 1.5, 
                    borderRadius: 2, 
                    bgcolor: 'rgba(30, 41, 59, 0.7)', 
                    border: '1px solid rgba(51, 65, 85, 0.8)' 
                }}>
                    <Stack direction="row" spacing={1} alignItems="center" sx={{ minWidth: 0 }}>
                        <BusinessIcon sx={{ fontSize: 16, color: '#38bdf8', flexShrink: 0 }} />
                        <Tooltip title={currentUnitName} arrow placement="top">
                            <Typography variant="caption" sx={{ color: '#cbd5e1', fontWeight: 600, flex: 1, minWidth: 0, overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>
                                {currentUnitName}
                            </Typography>
                        </Tooltip>
                        <Chip 
                            label={isAdmin ? 'ADMIN' : 'OPERATOR'} 
                            size="small" 
                            sx={{ 
                                height: 18, 
                                fontSize: '0.62rem', 
                                fontWeight: 700, 
                                flexShrink: 0,
                                bgcolor: isAdmin ? 'rgba(168, 85, 247, 0.2)' : 'rgba(16, 185, 129, 0.2)', 
                                color: isAdmin ? '#c084fc' : '#34d399' 
                            }} 
                        />
                    </Stack>
                </Box>
            </Box>

            <Divider sx={{ borderColor: 'rgba(51, 65, 85, 0.6)', my: 0.5 }} />

            {/* Navigation Menu */}
            <List sx={{ 
                flex: 1, 
                px: 1.5, 
                py: 1.5,
                '& .MuiListItemButton-root': { 
                    borderRadius: 2, 
                    mb: 0.75, 
                    color: '#94a3b8',
                    transition: 'all 0.2s cubic-bezier(0.4, 0, 0.2, 1)',
                    py: 1,
                    px: 1.5,
                    '&:hover': {
                        bgcolor: 'rgba(30, 41, 59, 0.8)',
                        color: '#ffffff',
                        transform: 'translateX(3px)',
                    },
                    '&.Mui-selected': { 
                        bgcolor: 'linear-gradient(135deg, rgba(5, 150, 105, 0.25) 0%, rgba(16, 185, 129, 0.15) 100%)',
                        color: '#34d399',
                        fontWeight: 700,
                        borderLeft: '3px solid #10b981',
                        '& .MuiListItemIcon-root': {
                            color: '#34d399',
                        }
                    }
                } 
            }}>
                {!isAdmin && (
                    <>
                        <Typography variant="overline" sx={{ px: 1.5, mb: 1, display: 'block', color: '#64748b', fontWeight: 700, fontSize: '0.68rem', letterSpacing: '0.08em' }}>
                            Kinerja Satuan Kerja
                        </Typography>
                        <ListItem disablePadding>
                            <ListItemButton component={Link} href={route('dashboard')} selected={route().current('dashboard')}>
                                <ListItemIcon sx={{ color: route().current('dashboard') ? '#34d399' : '#64748b', minWidth: 38 }}>
                                    <DashboardIcon fontSize="small" />
                                </ListItemIcon>
                                <ListItemText primary="Dashboard Kinerja" primaryTypographyProps={{ fontSize: '0.875rem', fontWeight: route().current('dashboard') ? 700 : 500 }} />
                            </ListItemButton>
                        </ListItem>
                        <ListItem disablePadding>
                            <ListItemButton component={Link} href={route('input-data.index')} selected={route().current('input-data.*')}>
                                <ListItemIcon sx={{ color: route().current('input-data.*') ? '#34d399' : '#64748b', minWidth: 38 }}>
                                    <EditNoteIcon fontSize="small" />
                                </ListItemIcon>
                                <ListItemText primary="Pengukuran & Input Data" primaryTypographyProps={{ fontSize: '0.875rem', fontWeight: route().current('input-data.*') ? 700 : 500 }} />
                            </ListItemButton>
                        </ListItem>
                    </>
                )}

                {isAdmin && (
                    <>
                        <Typography variant="overline" sx={{ px: 1.5, mb: 1, display: 'block', color: '#64748b', fontWeight: 700, fontSize: '0.68rem', letterSpacing: '0.08em' }}>
                            Executive & BI Center
                        </Typography>
                        <ListItem disablePadding>
                            <ListItemButton component={Link} href={route('admin.dashboard')} selected={route().current('admin.dashboard')}>
                                <ListItemIcon sx={{ color: route().current('admin.dashboard') ? '#34d399' : '#64748b', minWidth: 38 }}>
                                    <DashboardCustomizeIcon fontSize="small" />
                                </ListItemIcon>
                                <ListItemText primary="Executive Dashboard" primaryTypographyProps={{ fontSize: '0.875rem', fontWeight: route().current('admin.dashboard') ? 700 : 500 }} />
                            </ListItemButton>
                        </ListItem>
                        <ListItem disablePadding>
                            <ListItemButton component={Link} href={route('review-data.index')} selected={route().current('review-data.*')}>
                                <ListItemIcon sx={{ color: route().current('review-data.*') ? '#34d399' : '#64748b', minWidth: 38 }}>
                                    <TableChartIcon fontSize="small" />
                                </ListItemIcon>
                                <ListItemText primary="Review & Validasi LKjIP" primaryTypographyProps={{ fontSize: '0.875rem', fontWeight: route().current('review-data.*') ? 700 : 500 }} />
                            </ListItemButton>
                        </ListItem>
                        <ListItem disablePadding>
                            <ListItemButton component={Link} href={route('admin.rumus.index')} selected={route().current('admin.rumus.*')}>
                                <ListItemIcon sx={{ color: route().current('admin.rumus.*') ? '#34d399' : '#64748b', minWidth: 38 }}>
                                    <FunctionsIcon fontSize="small" />
                                </ListItemIcon>
                                <ListItemText primary="Master Registry Formula" primaryTypographyProps={{ fontSize: '0.875rem', fontWeight: route().current('admin.rumus.*') ? 700 : 500 }} />
                            </ListItemButton>
                        </ListItem>
                        <ListItem disablePadding>
                            <ListItemButton component={Link} href={route('admin.template.index')} selected={route().current('admin.template.*')}>
                                <ListItemIcon sx={{ color: route().current('admin.template.*') ? '#34d399' : '#64748b', minWidth: 38 }}>
                                    <TemplateIcon fontSize="small" />
                                </ListItemIcon>
                                <ListItemText primary="Template Laporan LKjIP" primaryTypographyProps={{ fontSize: '0.875rem', fontWeight: route().current('admin.template.*') ? 700 : 500 }} />
                            </ListItemButton>
                        </ListItem>
                        <ListItem disablePadding>
                            <ListItemButton component={Link} href={route('export.index')} selected={route().current('export.*')}>
                                <ListItemIcon sx={{ color: route().current('export.*') ? '#34d399' : '#64748b', minWidth: 38 }}>
                                    <PdfIcon fontSize="small" />
                                </ListItemIcon>
                                <ListItemText primary="Ekspor Laporan Word" primaryTypographyProps={{ fontSize: '0.875rem', fontWeight: route().current('export.*') ? 700 : 500 }} />
                            </ListItemButton>
                        </ListItem>
                    </>
                )}
            </List>

            {/* Bottom Footer User Pill */}
            <Divider sx={{ borderColor: 'rgba(51, 65, 85, 0.6)' }} />
            <Box sx={{ p: 2 }}>
                <Box 
                    onClick={handleMenu}
                    sx={{
                        display: 'flex',
                        alignItems: 'center',
                        gap: 1.25,
                        p: 1.25,
                        px: 1.5,
                        borderRadius: 2.5,
                        cursor: 'pointer',
                        bgcolor: 'rgba(30, 41, 59, 0.6)',
                        border: '1px solid rgba(51, 65, 85, 0.6)',
                        transition: 'all 0.2s cubic-bezier(0.4, 0, 0.2, 1)',
                        '&:hover': {
                            bgcolor: 'rgba(30, 41, 59, 0.95)',
                            borderColor: '#10b981',
                            boxShadow: '0 4px 14px rgba(0, 0, 0, 0.3)',
                        }
                    }}
                >
                    <Avatar sx={{ 
                        width: 34, 
                        height: 34, 
                        flexShrink: 0,
                        bgcolor: '#059669', 
                        fontSize: '0.875rem', 
                        fontWeight: 700,
                        border: '2px solid rgba(255, 255, 255, 0.2)'
                    }}>
                        {(user.username || 'U').charAt(0).toUpperCase()}
                    </Avatar>
                    <Box sx={{ flex: 1, minWidth: 0, overflow: 'hidden' }}>
                        <Typography 
                            variant="body2" 
                            sx={{ 
                                fontWeight: 700, 
                                color: '#ffffff', 
                                lineHeight: 1.25, 
                                overflow: 'hidden', 
                                textOverflow: 'ellipsis', 
                                whiteSpace: 'nowrap',
                                display: 'block'
                            }}
                        >
                            {user.username}
                        </Typography>
                        <Tooltip title={user.nama_satker || user.bidang_id || 'User'} arrow placement="top">
                            <Typography 
                                variant="caption" 
                                sx={{ 
                                    color: '#94a3b8', 
                                    fontSize: '0.7rem', 
                                    overflow: 'hidden', 
                                    textOverflow: 'ellipsis', 
                                    whiteSpace: 'nowrap',
                                    display: 'block',
                                    mt: 0.25
                                }}
                            >
                                {user.nama_satker || user.bidang_id || 'User'}
                            </Typography>
                        </Tooltip>
                    </Box>
                    <ArrowDownIcon sx={{ fontSize: 18, color: '#94a3b8', flexShrink: 0 }} />
                </Box>
            </Box>
        </Box>
    );

    return (
        <Box sx={{ display: 'flex', minHeight: '100vh', bgcolor: 'background.default' }}>
            {/* Top App Bar */}
            <AppBar
                position="fixed"
                elevation={0}
                sx={{
                    width: { sm: `calc(100% - ${drawerWidth}px)` },
                    ml: { sm: `${drawerWidth}px` },
                    bgcolor: 'rgba(255, 255, 255, 0.88)',
                    backdropFilter: 'blur(16px)',
                    color: '#0f172a',
                    borderBottom: '1px solid #e2e8f0',
                }}
            >
                <Toolbar sx={{ justifyContent: 'space-between', px: { xs: 2, sm: 3 } }}>
                    <Stack direction="row" spacing={1.5} alignItems="center">
                        <IconButton
                            color="inherit"
                            aria-label="open drawer"
                            edge="start"
                            onClick={handleDrawerToggle}
                            sx={{ display: { sm: 'none' }, color: '#334155' }}
                        >
                            <MenuIcon />
                        </IconButton>
                        <Box sx={{ minWidth: 0 }}>
                            <Typography variant="h6" noWrap sx={{ fontWeight: 800, color: '#0f172a', fontSize: { xs: '0.95rem', sm: '1.15rem' }, overflow: 'hidden', textOverflow: 'ellipsis' }}>
                                {title}
                            </Typography>
                        </Box>
                    </Stack>

                    <Stack direction="row" spacing={1.5} alignItems="center">
                        <Chip
                            icon={<CalendarIcon sx={{ fontSize: '14px !important', color: '#059669 !important' }} />}
                            label="Renstra 2025–2029"
                            size="small"
                            sx={{
                                display: { xs: 'none', md: 'flex' },
                                bgcolor: '#ecfdf5',
                                color: '#065f46',
                                fontWeight: 700,
                                border: '1px solid #a7f3d0'
                            }}
                        />

                        <IconButton
                            onClick={handleMenu}
                            sx={{
                                p: 0.5,
                                border: '1px solid #e2e8f0',
                                borderRadius: '10px',
                                bgcolor: '#ffffff',
                                '&:hover': { bgcolor: '#f8fafc' }
                            }}
                        >
                            <Avatar sx={{ width: 32, height: 32, bgcolor: '#0f172a', fontSize: '0.8rem', fontWeight: 700 }}>
                                {(user.username || 'U').charAt(0).toUpperCase()}
                            </Avatar>
                        </IconButton>

                        <Menu
                            id="menu-appbar"
                            anchorEl={anchorEl}
                            anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }}
                            keepMounted
                            transformOrigin={{ vertical: 'top', horizontal: 'right' }}
                            open={Boolean(anchorEl)}
                            onClose={handleClose}
                            PaperProps={{
                                elevation: 0,
                                sx: {
                                    minWidth: 200,
                                    borderRadius: 3,
                                    border: '1px solid #e2e8f0',
                                    boxShadow: '0 12px 28px -4px rgba(15, 23, 42, 0.12)',
                                    mt: 1,
                                    p: 0.5,
                                    '& .MuiMenuItem-root': {
                                        borderRadius: 1.5,
                                        fontSize: '0.875rem',
                                        fontWeight: 600,
                                        py: 1,
                                        my: 0.25,
                                    }
                                }
                            }}
                        >
                            <Box sx={{ px: 2, py: 1.5, borderBottom: '1px solid #f1f5f9', mb: 0.5 }}>
                                <Typography variant="subtitle2" sx={{ fontWeight: 800, color: '#0f172a' }}>
                                    {user.username}
                                </Typography>
                                <Typography variant="caption" sx={{ color: '#64748b' }}>
                                    {user.nama_satker || user.bidang_id}
                                </Typography>
                            </Box>
                            <MenuItem component={Link} href={route('profile.edit')} onClick={handleClose}>
                                <ListItemIcon><PersonIcon fontSize="small" /></ListItemIcon>
                                Pengaturan Profil
                            </MenuItem>
                            <Divider sx={{ my: 0.5 }} />
                            <MenuItem onClick={handleLogout} sx={{ color: '#ef4444' }}>
                                <ListItemIcon sx={{ color: '#ef4444' }}><LogoutIcon fontSize="small" /></ListItemIcon>
                                Keluar (Logout)
                            </MenuItem>
                        </Menu>
                    </Stack>
                </Toolbar>
            </AppBar>
            
            {/* Sidebar Navigation */}
            <Box
                component="nav"
                sx={{ width: { sm: drawerWidth }, flexShrink: { sm: 0 } }}
                aria-label="app navigation"
            >
                {/* Mobile Drawer */}
                <Drawer
                    variant="temporary"
                    open={mobileOpen}
                    onClose={handleDrawerToggle}
                    ModalProps={{ keepMounted: true }}
                    sx={{
                        display: { xs: 'block', sm: 'none' },
                        '& .MuiDrawer-paper': { 
                            boxSizing: 'border-box', 
                            width: drawerWidth,
                            border: 'none',
                        },
                    }}
                >
                    {drawerContent}
                </Drawer>

                {/* Desktop Permanent Drawer */}
                <Drawer
                    variant="permanent"
                    sx={{
                        display: { xs: 'none', sm: 'block' },
                        '& .MuiDrawer-paper': { 
                            boxSizing: 'border-box', 
                            width: drawerWidth,
                            border: 'none',
                            boxShadow: '4px 0 24px rgba(15, 23, 42, 0.04)',
                        },
                    }}
                    open
                >
                    {drawerContent}
                </Drawer>
            </Box>
            
            {/* Main Canvas with strict flex containment */}
            <Box
                component="main"
                sx={{ 
                    flexGrow: 1, 
                    p: { xs: 2, sm: 3.5 }, 
                    width: { sm: `calc(100% - ${drawerWidth}px)` }, 
                    minWidth: 0,
                    maxWidth: '100%',
                    overflowX: 'hidden',
                    mt: { xs: 7, sm: 8 },
                    minHeight: 'calc(100vh - 64px)',
                    bgcolor: '#f8fafc'
                }}
            >
                {children}
            </Box>
        </Box>
    );
}

