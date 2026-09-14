import { Link, useForm, usePage } from '@inertiajs/react';
import { Box, Typography, TextField, Button, Alert, Stack, CircularProgress } from '@mui/material';
import { Save as SaveIcon, Person as PersonIcon } from '@mui/icons-material';

export default function UpdateProfileInformation({
    mustVerifyEmail,
    status,
}) {
    const user = usePage().props.auth.user;

    const { data, setData, patch, errors, processing, recentlySuccessful } =
        useForm({
            name: user.name,
            email: user.email,
        });

    const submit = (e) => {
        e.preventDefault();
        patch(route('profile.update'));
    };

    return (
        <Box>
            <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', mb: 0.5 }}>
                Informasi Akun
            </Typography>
            <Typography variant="body2" sx={{ color: '#64748b', mb: 3 }}>
                Perbarui nama profil dan alamat email resmi kedinasan Anda.
            </Typography>

            {recentlySuccessful && (
                <Alert severity="success" sx={{ mb: 2.5, borderRadius: 2 }}>
                    Profil berhasil diperbarui.
                </Alert>
            )}

            <form onSubmit={submit}>
                <Stack spacing={2.5}>
                    <TextField
                        fullWidth
                        label="Nama Lengkap"
                        value={data.name}
                        onChange={(e) => setData('name', e.target.value)}
                        error={!!errors.name}
                        helperText={errors.name}
                        required
                        InputProps={{ sx: { borderRadius: 2 } }}
                    />

                    <TextField
                        fullWidth
                        type="email"
                        label="Alamat Email"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                        error={!!errors.email}
                        helperText={errors.email}
                        required
                        InputProps={{ sx: { borderRadius: 2 } }}
                    />

                    {mustVerifyEmail && user.email_verified_at === null && (
                        <Alert severity="warning" sx={{ borderRadius: 2 }}>
                            Email belum diverifikasi.{' '}
                            <Link href={route('verification.send')} method="post" as="button" style={{ fontWeight: 'bold' }}>
                                Kirim ulang link verifikasi.
                            </Link>
                        </Alert>
                    )}

                    <Box sx={{ display: 'flex', justifyContent: 'flex-end' }}>
                        <Button
                            type="submit"
                            variant="contained"
                            disabled={processing}
                            startIcon={processing ? <CircularProgress size={16} color="inherit" /> : <SaveIcon />}
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
                            Simpan Perubahan
                        </Button>
                    </Box>
                </Stack>
            </form>
        </Box>
    );
}

