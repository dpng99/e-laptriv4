import { useForm } from '@inertiajs/react';
import { useRef } from 'react';
import { Box, Typography, TextField, Button, Alert, Stack, CircularProgress } from '@mui/material';
import { LockReset as LockIcon } from '@mui/icons-material';

export default function UpdatePasswordForm() {
    const passwordInput = useRef();
    const currentPasswordInput = useRef();

    const {
        data,
        setData,
        errors,
        put,
        reset,
        processing,
        recentlySuccessful,
    } = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    const updatePassword = (e) => {
        e.preventDefault();

        put(route('password.update'), {
            preserveScroll: true,
            onSuccess: () => reset(),
            onError: (errors) => {
                if (errors.password) {
                    reset('password', 'password_confirmation');
                    passwordInput.current?.focus();
                }

                if (errors.current_password) {
                    reset('current_password');
                    currentPasswordInput.current?.focus();
                }
            },
        });
    };

    return (
        <Box>
            <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', mb: 0.5 }}>
                Ubah Kata Sandi
            </Typography>
            <Typography variant="body2" sx={{ color: '#64748b', mb: 3 }}>
                Pastikan akun Anda menggunakan kata sandi yang aman dan tidak mudah ditebak.
            </Typography>

            {recentlySuccessful && (
                <Alert severity="success" sx={{ mb: 2.5, borderRadius: 2 }}>
                    Kata sandi berhasil diperbarui.
                </Alert>
            )}

            <form onSubmit={updatePassword}>
                <Stack spacing={2.5}>
                    <TextField
                        fullWidth
                        type="password"
                        label="Kata Sandi Saat Ini"
                        inputRef={currentPasswordInput}
                        value={data.current_password}
                        onChange={(e) => setData('current_password', e.target.value)}
                        error={!!errors.current_password}
                        helperText={errors.current_password}
                        InputProps={{ sx: { borderRadius: 2 } }}
                    />

                    <TextField
                        fullWidth
                        type="password"
                        label="Kata Sandi Baru"
                        inputRef={passwordInput}
                        value={data.password}
                        onChange={(e) => setData('password', e.target.value)}
                        error={!!errors.password}
                        helperText={errors.password}
                        InputProps={{ sx: { borderRadius: 2 } }}
                    />

                    <TextField
                        fullWidth
                        type="password"
                        label="Konfirmasi Kata Sandi Baru"
                        value={data.password_confirmation}
                        onChange={(e) => setData('password_confirmation', e.target.value)}
                        error={!!errors.password_confirmation}
                        helperText={errors.password_confirmation}
                        InputProps={{ sx: { borderRadius: 2 } }}
                    />

                    <Box sx={{ display: 'flex', justifyContent: 'flex-end' }}>
                        <Button
                            type="submit"
                            variant="contained"
                            disabled={processing}
                            startIcon={processing ? <CircularProgress size={16} color="inherit" /> : <LockIcon />}
                            sx={{
                                bgcolor: '#059669',
                                color: '#ffffff',
                                background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                                borderRadius: 2,
                                fontWeight: 700,
                                px: 3,
                                py: 1,
                                boxShadow: '0 4px 14px rgba(5, 150, 105, 0.4)',
                                '&:hover': {
                                    background: 'linear-gradient(135deg, #047857 0%, #059669 100%)',
                                }
                            }}
                        >
                            Perbarui Sandi
                        </Button>
                    </Box>
                </Stack>
            </form>
        </Box>
    );
}

