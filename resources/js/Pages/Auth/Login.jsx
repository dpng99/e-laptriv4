import { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import { 
    Box, Card, CardContent, Typography, TextField, Button, Checkbox, 
    FormControlLabel, CircularProgress, Container, Stack,
    InputAdornment, IconButton, Alert
} from '@mui/material';
import {
    AccountCircleOutlined as UserIcon,
    LockOutlined as LockIcon,
    Visibility as VisibilityIcon,
    VisibilityOff as VisibilityOffIcon,
    Shield as ShieldIcon
} from '@mui/icons-material';

export default function Login({ status, canResetPassword }) {
    const [showPassword, setShowPassword] = useState(false);

    const { data, setData, post, processing, errors, reset } = useForm({
        username: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <Box sx={{
            minHeight: '100vh',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            bgcolor: '#0f172a',
            backgroundImage: 'radial-gradient(ellipse at 50% 10%, rgba(5, 150, 105, 0.18) 0%, rgba(15, 23, 42, 0.95) 75%)',
            py: 4,
            px: 2
        }}>
            <Head title="Masuk — e-LKjIP Pembinaan" />
            
            <Container maxWidth="xs" sx={{ mx: 'auto' }}>
                {/* Header Brand */}
                <Box sx={{ textAlign: 'center', mb: 3 }}>
                    <Box sx={{
                        width: 56,
                        height: 56,
                        borderRadius: '16px',
                        background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                        mx: 'auto',
                        mb: 2,
                        boxShadow: '0 8px 24px rgba(5, 150, 105, 0.35)',
                        color: '#ffffff'
                    }}>
                        <ShieldIcon sx={{ fontSize: 32 }} />
                    </Box>
                    <Typography variant="h5" sx={{ fontWeight: 800, color: '#f8fafc', letterSpacing: '-0.02em', mb: 0.5 }}>
                        e-LKjIP Pembinaan
                    </Typography>
                    <Typography variant="body2" sx={{ color: '#94a3b8', fontWeight: 500 }}>
                        Kejaksaan Agung Republik Indonesia
                    </Typography>
                </Box>

                {/* Login Form Card */}
                <Card sx={{
                    borderRadius: 3.5,
                    bgcolor: 'rgba(30, 41, 59, 0.85)',
                    backdropFilter: 'blur(16px)',
                    border: '1px solid rgba(51, 65, 85, 0.8)',
                    boxShadow: '0 20px 45px -10px rgba(0, 0, 0, 0.6), 0 0 25px rgba(5, 150, 105, 0.1)',
                    p: { xs: 2.5, sm: 3.5 }
                }}>
                    <CardContent sx={{ p: '0 !important' }}>
                        <Box sx={{ mb: 3 }}>
                            <Typography variant="h6" sx={{ fontWeight: 700, color: '#f8fafc', mb: 0.5 }}>
                                Masuk ke Sistem
                            </Typography>
                            <Typography variant="body2" sx={{ color: '#94a3b8', fontSize: '0.85rem' }}>
                                Silakan masukkan kredensial akun Anda.
                            </Typography>
                        </Box>

                        {status && (
                            <Alert severity="success" sx={{ mb: 2.5, borderRadius: 2, bgcolor: 'rgba(5, 150, 105, 0.15)', color: '#34d399', border: '1px solid rgba(5, 150, 105, 0.4)' }}>
                                {status}
                            </Alert>
                        )}

                        <form onSubmit={submit}>
                            <Stack spacing={2.5}>
                                <Box>
                                    <Typography variant="caption" sx={{ color: '#cbd5e1', fontWeight: 700, mb: 0.75, display: 'block' }}>
                                        Username / NIP
                                    </Typography>
                                    <TextField
                                        fullWidth
                                        id="username"
                                        name="username"
                                        placeholder="Masukkan username atau NIP"
                                        value={data.username}
                                        onChange={(e) => setData('username', e.target.value)}
                                        error={!!errors.username}
                                        helperText={errors.username}
                                        autoFocus
                                        autoComplete="username"
                                        InputProps={{
                                            startAdornment: (
                                                <InputAdornment position="start">
                                                    <UserIcon sx={{ color: '#64748b', fontSize: 20 }} />
                                                </InputAdornment>
                                            ),
                                            sx: {
                                                bgcolor: 'rgba(15, 23, 42, 0.6)',
                                                color: '#f8fafc',
                                                borderRadius: 2,
                                                border: '1px solid rgba(51, 65, 85, 0.8)',
                                                '&:hover': {
                                                    borderColor: 'rgba(100, 116, 139, 1)'
                                                },
                                                '&.Mui-focused': {
                                                    borderColor: '#10b981',
                                                    boxShadow: '0 0 0 2px rgba(16, 185, 129, 0.25)'
                                                }
                                            }
                                        }}
                                    />
                                </Box>

                                <Box>
                                    <Typography variant="caption" sx={{ color: '#cbd5e1', fontWeight: 700, mb: 0.75, display: 'block' }}>
                                        Kata Sandi
                                    </Typography>
                                    <TextField
                                        fullWidth
                                        id="password"
                                        type={showPassword ? 'text' : 'password'}
                                        name="password"
                                        placeholder="Masukkan kata sandi"
                                        value={data.password}
                                        onChange={(e) => setData('password', e.target.value)}
                                        error={!!errors.password}
                                        helperText={errors.password}
                                        autoComplete="current-password"
                                        InputProps={{
                                            startAdornment: (
                                                <InputAdornment position="start">
                                                    <LockIcon sx={{ color: '#64748b', fontSize: 20 }} />
                                                </InputAdornment>
                                            ),
                                            endAdornment: (
                                                <InputAdornment position="end">
                                                    <IconButton
                                                        onClick={() => setShowPassword(!showPassword)}
                                                        edge="end"
                                                        sx={{ color: '#94a3b8' }}
                                                        aria-label="toggle password visibility"
                                                    >
                                                        {showPassword ? <VisibilityOffIcon fontSize="small" /> : <VisibilityIcon fontSize="small" />}
                                                    </IconButton>
                                                </InputAdornment>
                                            ),
                                            sx: {
                                                bgcolor: 'rgba(15, 23, 42, 0.6)',
                                                color: '#f8fafc',
                                                borderRadius: 2,
                                                border: '1px solid rgba(51, 65, 85, 0.8)',
                                                '&:hover': {
                                                    borderColor: 'rgba(100, 116, 139, 1)'
                                                },
                                                '&.Mui-focused': {
                                                    borderColor: '#10b981',
                                                    boxShadow: '0 0 0 2px rgba(16, 185, 129, 0.25)'
                                                }
                                            }
                                        }}
                                    />
                                </Box>

                                <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                                    <FormControlLabel
                                        control={
                                            <Checkbox
                                                name="remember"
                                                checked={data.remember}
                                                onChange={(e) => setData('remember', e.target.checked)}
                                                sx={{
                                                    color: '#64748b',
                                                    '&.Mui-checked': { color: '#10b981' }
                                                }}
                                            />
                                        }
                                        label={<Typography variant="body2" sx={{ color: '#94a3b8', fontSize: '0.85rem' }}>Ingat sesi saya</Typography>}
                                    />
                                </Box>

                                <Button
                                    type="submit"
                                    fullWidth
                                    variant="contained"
                                    size="large"
                                    disabled={processing}
                                    sx={{
                                        py: 1.4,
                                        borderRadius: 2.5,
                                        fontWeight: 700,
                                        fontSize: '0.95rem',
                                        background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                                        color: '#ffffff',
                                        boxShadow: '0 4px 14px rgba(5, 150, 105, 0.35)',
                                        textTransform: 'none',
                                        '&:hover': {
                                            background: 'linear-gradient(135deg, #047857 0%, #059669 100%)',
                                            boxShadow: '0 6px 18px rgba(5, 150, 105, 0.5)'
                                        }
                                    }}
                                >
                                    {processing ? <CircularProgress size={24} color="inherit" /> : 'Masuk ke Portal'}
                                </Button>
                            </Stack>
                        </form>
                    </CardContent>
                </Card>

                {/* Footer Note */}
                <Box sx={{ textAlign: 'center', mt: 3 }}>
                    <Typography variant="caption" sx={{ color: '#64748b', fontSize: '0.75rem' }}>
                        © {new Date().getFullYear()} Jaksa Agung Muda Bidang Pembinaan
                    </Typography>
                </Box>
            </Container>
        </Box>
    );
}
