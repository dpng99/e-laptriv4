import React from 'react';
import { Alert, Box, Button, Typography, Paper } from '@mui/material';
import { Refresh as RefreshIcon, WarningAmber as WarningIcon } from '@mui/icons-material';

/**
 * ErrorBoundary Component
 * Catches JavaScript errors anywhere in their child component tree,
 * logs those errors, and displays a fallback UI instead of crashing the whole page.
 */
export class ErrorBoundary extends React.Component {
    constructor(props) {
        super(props);
        this.state = { hasError: false, error: null, errorInfo: null };
    }

    static getDerivedStateFromError(error) {
        return { hasError: true, error };
    }

    componentDidCatch(error, errorInfo) {
        console.error('ErrorBoundary caught an error:', error, errorInfo);
        this.setState({ errorInfo });
    }

    handleReset = () => {
        this.setState({ hasError: false, error: null, errorInfo: null });
    };

    render() {
        if (this.state.hasError) {
            if (this.props.fallback) {
                return this.props.fallback;
            }

            return (
                <Paper
                    variant="outlined"
                    sx={{
                        p: 2.5,
                        my: 1.5,
                        borderRadius: 2.5,
                        borderColor: '#fca5a5',
                        bgcolor: '#fff5f5'
                    }}
                >
                    <Alert
                        severity="error"
                        icon={<WarningIcon fontSize="inherit" />}
                        action={
                            <Button
                                color="inherit"
                                size="small"
                                startIcon={<RefreshIcon />}
                                onClick={this.handleReset}
                                sx={{ fontWeight: 700, textTransform: 'none' }}
                            >
                                Coba Lagi
                            </Button>
                        }
                        sx={{ bgcolor: 'transparent', p: 0, '& .MuiAlert-message': { width: '100%' } }}
                    >
                        <Typography variant="subtitle2" fontWeight={800} sx={{ color: '#991b1b' }}>
                            {this.props.fallbackMessage || 'Gagal memuat komponen ini'}
                        </Typography>
                        <Typography variant="caption" sx={{ color: '#b91c1c', display: 'block', mt: 0.5 }}>
                            Terjadi kesalahan teknis pada bagian ini. Anda dapat mencoba memuat ulang komponen tanpa perlu me-refresh seluruh halaman.
                        </Typography>
                        {process.env.NODE_ENV === 'development' && this.state.error && (
                            <Box
                                component="pre"
                                sx={{
                                    mt: 1,
                                    p: 1,
                                    bgcolor: 'rgba(0,0,0,0.05)',
                                    borderRadius: 1,
                                    fontSize: '0.72rem',
                                    overflowX: 'auto',
                                    color: '#7f1d1d'
                                }}
                            >
                                {this.state.error.toString()}
                            </Box>
                        )}
                    </Alert>
                </Paper>
            );
        }

        return this.props.children;
    }
}

export default ErrorBoundary;
