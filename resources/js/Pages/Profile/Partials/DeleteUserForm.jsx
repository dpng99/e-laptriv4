import { useForm } from '@inertiajs/react';
import { useRef, useState } from 'react';
import { 
    Box, Typography, TextField, Button, Dialog, DialogTitle, DialogContent, 
    DialogActions, Alert, Stack, CircularProgress 
} from '@mui/material';
import { Delete as DeleteIcon, Warning as WarningIcon } from '@mui/icons-material';

export default function DeleteUserForm() {
    const [confirmingUserDeletion, setConfirmingUserDeletion] = useState(false);
    const passwordInput = useRef();

    const {
        data,
        setData,
        delete: destroy,
        processing,
        reset,
        errors,
        clearErrors,
    } = useForm({
        password: '',
    });

    const confirmUserDeletion = () => {
        setConfirmingUserDeletion(true);
    };

    const deleteUser = (e) => {
        e.preventDefault();

        destroy(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput.current?.focus(),
            onFinish: () => reset(),
        });
    };

    const closeModal = () => {
        setConfirmingUserDeletion(false);
        clearErrors();
        reset();
    };

    return (
        <Box>
            <Typography variant="h6" fontWeight={800} sx={{ color: '#b91c1c', mb: 0.5 }}>
                Hapus Akun Pengguna
            </Typography>
            <Typography variant="body2" sx={{ color: '#7f1d1d', mb: 3 }}>
                Setelah akun Anda dihapus, seluruh data dan akses Anda pada sistem e-LKjIP Pembinaan akan dicabut secara permanen.
            </Typography>

            <Button
                variant="outlined"
                color="error"
                startIcon={<DeleteIcon />}
                onClick={confirmUserDeletion}
                sx={{ borderRadius: 2, fontWeight: 700, textTransform: 'none' }}
            >
                Hapus Akun Saya
            </Button>

            <Dialog open={confirmingUserDeletion} onClose={closeModal} maxWidth="sm" fullWidth>
                <form onSubmit={deleteUser}>
                    <DialogTitle sx={{ fontWeight: 800, color: '#b91c1c', display: 'flex', alignItems: 'center', gap: 1 }}>
                        <WarningIcon color="error" /> Konfirmasi Penghapusan Akun
                    </DialogTitle>
                    <DialogContent dividers>
                        <Typography variant="body2" color="text.secondary" sx={{ mb: 2.5 }}>
                            Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan. Masukkan kata sandi Anda untuk mengonfirmasi.
                        </Typography>

                        <TextField
                            fullWidth
                            type="password"
                            label="Kata Sandi Anda"
                            inputRef={passwordInput}
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            error={!!errors.password}
                            helperText={errors.password}
                            autoFocus
                            InputProps={{ sx: { borderRadius: 2 } }}
                        />
                    </DialogContent>
                    <DialogActions sx={{ p: 2 }}>
                        <Button onClick={closeModal} variant="outlined" sx={{ borderRadius: 2 }}>
                            Batal
                        </Button>
                        <Button
                            type="submit"
                            variant="contained"
                            color="error"
                            disabled={processing}
                            startIcon={processing ? <CircularProgress size={16} color="inherit" /> : <DeleteIcon />}
                            sx={{ borderRadius: 2, fontWeight: 700 }}
                        >
                            Hapus Akun Permanen
                        </Button>
                    </DialogActions>
                </form>
            </Dialog>
        </Box>
    );
}

