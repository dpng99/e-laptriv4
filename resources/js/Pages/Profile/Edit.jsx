import AppLayout from '@/Layouts/AppLayout';
import { Head } from '@inertiajs/react';
import { Box, Paper, Typography, Grid, Stack, Chip } from '@mui/material';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';
import { Person as PersonIcon, Security as SecurityIcon } from '@mui/icons-material';

export default function Edit({ mustVerifyEmail, status }) {
    return (
        <AppLayout title="Profil Pengguna">
            <Head title="Pengaturan Profil" />

            {/* Top Hero Banner */}
            <Paper 
                elevation={0}
                sx={{
                    p: { xs: 3, md: 3.5 },
                    mb: 4,
                    borderRadius: 3.5,
                    background: 'linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #064e3b 100%)',
                    color: '#ffffff',
                    position: 'relative',
                    overflow: 'hidden',
                    border: '1px solid rgba(255,255,255,0.08)'
                }}
            >
                <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1 }}>
                    <Chip label="User Account" size="small" sx={{ bgcolor: 'rgba(16, 185, 129, 0.2)', color: '#34d399', fontWeight: 700, border: '1px solid rgba(16, 185, 129, 0.4)' }} />
                    <Chip label="Keamanan Akun" size="small" sx={{ bgcolor: 'rgba(255,255,255,0.1)', color: '#e2e8f0', fontWeight: 600 }} />
                </Stack>
                <Typography variant="h4" fontWeight={800} sx={{ letterSpacing: -0.5 }}>
                    Pengaturan Profil & Keamanan
                </Typography>
                <Typography variant="body2" sx={{ color: '#94a3b8', mt: 0.5, maxWidth: 650 }}>
                    Perbarui identitas pengguna, kata sandi, dan kredensial akses sistem pelaporan e-LKjIP Pembinaan.
                </Typography>
            </Paper>

            <Grid container spacing={3}>
                <Grid item xs={12} md={6}>
                    <Paper sx={{ p: { xs: 3, md: 4 }, borderRadius: 3.5, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -2px rgba(15, 23, 42, 0.05)', height: '100%' }}>
                        <UpdateProfileInformationForm
                            mustVerifyEmail={mustVerifyEmail}
                            status={status}
                        />
                    </Paper>
                </Grid>

                <Grid item xs={12} md={6}>
                    <Paper sx={{ p: { xs: 3, md: 4 }, borderRadius: 3.5, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -2px rgba(15, 23, 42, 0.05)', height: '100%' }}>
                        <UpdatePasswordForm />
                    </Paper>
                </Grid>

                <Grid item xs={12}>
                    <Paper sx={{ p: { xs: 3, md: 4 }, borderRadius: 3.5, border: '1px solid #fee2e2', bgcolor: '#fff5f5', boxShadow: '0 4px 20px -2px rgba(220, 38, 38, 0.05)' }}>
                        <DeleteUserForm />
                    </Paper>
                </Grid>
            </Grid>
        </AppLayout>
    );
}

