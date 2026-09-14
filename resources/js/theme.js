import { createTheme } from '@mui/material/styles';

const theme = createTheme({
    palette: {
        mode: 'light',
        primary: {
            main: '#0f172a', // Slate 900 Executive Navy
            light: '#334155',
            dark: '#020617',
            contrastText: '#ffffff',
        },
        secondary: {
            main: '#059669', // Kejaksaan Emerald
            light: '#34d399',
            dark: '#064e3b',
            contrastText: '#ffffff',
        },
        warning: {
            main: '#f59e0b',
            light: '#fef3c7',
            dark: '#b45309',
            contrastText: '#ffffff',
        },
        success: {
            main: '#10b981',
            light: '#d1fae5',
            dark: '#047857',
            contrastText: '#ffffff',
        },
        error: {
            main: '#ef4444',
            light: '#fee2e2',
            dark: '#b91c1c',
            contrastText: '#ffffff',
        },
        info: {
            main: '#3b82f6',
            light: '#dbeafe',
            dark: '#1d4ed8',
            contrastText: '#ffffff',
        },
        background: {
            default: '#f8fafc',
            paper: '#ffffff',
        },
        text: {
            primary: '#0f172a',
            secondary: '#475569',
            disabled: '#94a3b8',
        },
        divider: '#e2e8f0',
    },
    typography: {
        fontFamily: '"Plus Jakarta Sans", "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        h1: { fontWeight: 800, letterSpacing: '-0.025em' },
        h2: { fontWeight: 800, letterSpacing: '-0.02em' },
        h3: { fontWeight: 700, letterSpacing: '-0.02em' },
        h4: { fontWeight: 700, letterSpacing: '-0.015em' },
        h5: { fontWeight: 700, letterSpacing: '-0.01em' },
        h6: { fontWeight: 700, letterSpacing: '-0.005em' },
        subtitle1: { fontWeight: 600, letterSpacing: '0.005em' },
        subtitle2: { fontWeight: 600 },
        body1: { fontSize: '0.9375rem', lineHeight: 1.6 },
        body2: { fontSize: '0.875rem', lineHeight: 1.55 },
        button: { fontWeight: 600, textTransform: 'none', letterSpacing: '0.01em' },
        caption: { fontSize: '0.75rem', letterSpacing: '0.01em' },
    },
    shape: {
        borderRadius: 12,
    },
    components: {
        MuiButton: {
            styleOverrides: {
                root: {
                    borderRadius: 10,
                    padding: '8px 20px',
                    boxShadow: 'none',
                    fontWeight: 600,
                    transition: 'all 0.2s cubic-bezier(0.4, 0, 0.2, 1)',
                    '&:hover': {
                        transform: 'translateY(-1px)',
                        boxShadow: '0 6px 16px -2px rgba(15, 23, 42, 0.12)',
                    },
                    '&:active': {
                        transform: 'translateY(0)',
                    },
                },
                containedPrimary: {
                    background: 'linear-gradient(135deg, #0f172a 0%, #1e293b 100%)',
                    '&:hover': {
                        background: 'linear-gradient(135deg, #1e293b 0%, #334155 100%)',
                    }
                },
                containedSecondary: {
                    background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                    '&:hover': {
                        background: 'linear-gradient(135deg, #047857 0%, #059669 100%)',
                    }
                },
                outlined: {
                    borderColor: '#cbd5e1',
                    '&:hover': {
                        borderColor: '#0f172a',
                        backgroundColor: 'rgba(15, 23, 42, 0.04)',
                    }
                }
            },
        },
        MuiCard: {
            styleOverrides: {
                root: {
                    backgroundImage: 'none',
                    borderRadius: 16,
                    border: '1px solid #e2e8f0',
                    boxShadow: '0 1px 3px 0 rgb(0 0 0 / 0.04), 0 1px 2px -1px rgb(0 0 0 / 0.04)',
                    transition: 'all 0.25s cubic-bezier(0.4, 0, 0.2, 1)',
                    '&:hover': {
                        boxShadow: '0 10px 25px -4px rgba(15, 23, 42, 0.07)',
                    }
                },
            },
        },
        MuiPaper: {
            styleOverrides: {
                root: {
                    backgroundImage: 'none',
                },
                outlined: {
                    borderColor: '#e2e8f0',
                },
            },
        },
        MuiTextField: {
            styleOverrides: {
                root: {
                    '& .MuiOutlinedInput-root': {
                        borderRadius: 10,
                        transition: 'all 0.2s ease',
                        '& fieldset': {
                            borderColor: '#cbd5e1',
                        },
                        '&:hover fieldset': {
                            borderColor: '#94a3b8',
                        },
                        '&.Mui-focused fieldset': {
                            borderColor: '#059669',
                            borderWidth: 1.5,
                        },
                        '&.Mui-focused': {
                            boxShadow: '0 0 0 3px rgba(5, 150, 105, 0.12)',
                        }
                    }
                }
            }
        },
        MuiSelect: {
            styleOverrides: {
                root: {
                    borderRadius: 10,
                }
            }
        },
        MuiChip: {
            styleOverrides: {
                root: {
                    fontWeight: 600,
                    borderRadius: 9999,
                    fontSize: '0.78rem',
                }
            }
        },
        MuiDivider: {
            styleOverrides: {
                root: {
                    borderColor: '#e2e8f0',
                }
            }
        },
        MuiTableHead: {
            styleOverrides: {
                root: {
                    '& .MuiTableCell-root': {
                        backgroundColor: '#f8fafc',
                        fontWeight: 700,
                        color: '#334155',
                        borderBottom: '2px solid #e2e8f0',
                        fontSize: '0.8125rem',
                        textTransform: 'uppercase',
                        letterSpacing: '0.05em',
                    }
                }
            }
        },
        MuiTableCell: {
            styleOverrides: {
                root: {
                    borderColor: '#f1f5f9',
                    padding: '14px 16px',
                }
            }
        }
    },
});

export default theme;

