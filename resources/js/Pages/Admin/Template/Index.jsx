import { useState } from 'react';
import { Head, router, useForm } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import {
    Box, Card, CardContent, Typography, Button, TextField,
    Paper, Stack, Chip, Divider, Grid, Alert, Table, TableBody,
    TableCell, TableContainer, TableHead, TableRow, IconButton,
    Tooltip, Dialog, DialogTitle, DialogContent, DialogActions,
    Accordion, AccordionSummary, AccordionDetails, Snackbar
} from '@mui/material';
import {
    CloudUpload as UploadIcon,
    Download as DownloadIcon,
    CheckCircle as CheckIcon,
    Delete as DeleteIcon,
    TaskAlt as ActivateIcon,
    RestartAlt as ResetIcon,
    ExpandMore as ExpandMoreIcon,
    ContentCopy as CopyIcon,
    Description as DocIcon,
    AutoAwesome as SparklesIcon,
    InfoOutlined as InfoIcon
} from '@mui/icons-material';
import { motion } from 'framer-motion';

export default function TemplateIndex({ templates = [], activeTemplate = null, placeholders = [] }) {
    const [openDeleteModal, setOpenDeleteModal] = useState(false);
    const [selectedTemplate, setSelectedTemplate] = useState(null);
    const [snackbarMsg, setSnackbarMsg] = useState('');

    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        file: null,
        description: '',
    });

    const handleFileUpload = (e) => {
        e.preventDefault();
        post(route('admin.template.upload'), {
            onSuccess: () => {
                reset();
                setSnackbarMsg('Template berhasil diunggah dan diaktifkan!');
            },
        });
    };

    const handleActivate = (id) => {
        router.post(route('admin.template.activate', id), {}, {
            onSuccess: () => setSnackbarMsg('Template berhasil diaktifkan!'),
        });
    };

    const handleResetDefault = () => {
        if (confirm('Kembalikan generator ke format bawaan resmi sistem?')) {
            router.post(route('admin.template.reset'), {}, {
                onSuccess: () => setSnackbarMsg('Sistem kembali menggunakan template default resmi.'),
            });
        }
    };

    const confirmDelete = (template) => {
        setSelectedTemplate(template);
        setOpenDeleteModal(true);
    };

    const handleDelete = () => {
        if (selectedTemplate) {
            router.delete(route('admin.template.destroy', selectedTemplate.id), {
                onSuccess: () => {
                    setOpenDeleteModal(false);
                    setSelectedTemplate(null);
                    setSnackbarMsg('Template berhasil dihapus.');
                },
            });
        }
    };

    const handleCopy = (text) => {
        navigator.clipboard.writeText(text);
        setSnackbarMsg(`Disalin: ${text}`);
    };

    const formatFileSize = (bytes) => {
        if (!bytes) return '-';
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    };

    return (
        <AppLayout title="Pengaturan & Builder Template LKjIP">
            <Head title="Pengaturan Template LKjIP" />

            {/* Top Hero Banner */}
            <Paper
                elevation={0}
                sx={{
                    p: { xs: 3, md: 3.5 },
                    mb: 4,
                    borderRadius: 3.5,
                    background: 'linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #1e3a8a 100%)',
                    color: '#ffffff',
                    position: 'relative',
                    overflow: 'hidden',
                    border: '1px solid rgba(255,255,255,0.08)'
                }}
            >
                <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1 }}>
                    <Chip
                        label="Template Builder & Customizer"
                        size="small"
                        sx={{ bgcolor: 'rgba(56, 189, 248, 0.2)', color: '#38bdf8', fontWeight: 700, border: '1px solid rgba(56, 189, 248, 0.4)' }}
                    />
                    <Chip
                        label="Admin Only"
                        size="small"
                        sx={{ bgcolor: 'rgba(255,255,255,0.1)', color: '#e2e8f0', fontWeight: 600 }}
                    />
                </Stack>
                <Typography variant="h4" fontWeight={800} sx={{ letterSpacing: -0.5 }}>
                    Pengaturan & Builder Template Dokumen LKjIP
                </Typography>
                <Typography variant="body2" sx={{ color: '#94a3b8', mt: 0.5, maxWidth: 800 }}>
                    Rancang dan sesuaikan template laporan Word (.docx) langsung menggunakan Microsoft Word (mengatur logo, header, ukuran font, alinea, nomor halaman, dan nomor tabel/gambar), lalu unggah ke sistem untuk mengotomatiskan pengisian data.
                </Typography>

                <Stack direction={{ xs: 'column', sm: 'row' }} spacing={2} sx={{ mt: 3 }}>
                    <Button
                        variant="contained"
                        startIcon={<DownloadIcon />}
                        href={route('admin.template.download-default')}
                        sx={{
                            bgcolor: '#2563eb',
                            color: '#ffffff',
                            fontWeight: 700,
                            borderRadius: 2.5,
                            textTransform: 'none',
                            px: 2.5,
                            '&:hover': { bgcolor: '#1d4ed8' }
                        }}
                    >
                        Download Template Acuan (.docx)
                    </Button>
                    <Button
                        variant="outlined"
                        startIcon={<ResetIcon />}
                        onClick={handleResetDefault}
                        sx={{
                            color: '#e2e8f0',
                            borderColor: 'rgba(255,255,255,0.2)',
                            fontWeight: 600,
                            borderRadius: 2.5,
                            textTransform: 'none',
                            '&:hover': { borderColor: '#ffffff', bgcolor: 'rgba(255,255,255,0.05)' }
                        }}
                    >
                        Gunakan Format Bawaan Resmi Sistem
                    </Button>
                </Stack>
            </Paper>

            {/* Active Template Status Card */}
            <Card
                sx={{
                    mb: 4,
                    borderRadius: 3,
                    border: '1px solid',
                    borderColor: activeTemplate ? '#bbf7d0' : '#e2e8f0',
                    bgcolor: activeTemplate ? '#f0fdf4' : '#f8fafc',
                    boxShadow: '0 4px 15px -3px rgba(0,0,0,0.05)'
                }}
            >
                <CardContent sx={{ p: 3 }}>
                    <Stack direction={{ xs: 'column', sm: 'row' }} justifyContent="space-between" alignItems={{ xs: 'flex-start', sm: 'center' }} spacing={2}>
                        <Stack direction="row" spacing={2} alignItems="center">
                            <Box
                                sx={{
                                    width: 48,
                                    height: 48,
                                    borderRadius: 2.5,
                                    bgcolor: activeTemplate ? '#dcfce7' : '#e2e8f0',
                                    color: activeTemplate ? '#16a34a' : '#64748b',
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center'
                                }}
                            >
                                <DocIcon />
                            </Box>
                            <Box>
                                <Stack direction="row" spacing={1} alignItems="center">
                                    <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                                        {activeTemplate ? activeTemplate.name : 'Generator Bawaan Resmi LKjIP JAMBIN'}
                                    </Typography>
                                    <Chip
                                        label={activeTemplate ? 'Template Custom Aktif' : 'Default Sistem Aktif'}
                                        size="small"
                                        color={activeTemplate ? 'success' : 'default'}
                                        sx={{ fontWeight: 700 }}
                                    />
                                </Stack>
                                <Typography variant="body2" sx={{ color: '#64748b', mt: 0.2 }}>
                                    {activeTemplate
                                        ? `File: ${activeTemplate.file_name} (${formatFileSize(activeTemplate.file_size)}) • Diunggah oleh: ${activeTemplate.uploader}`
                                        : 'Menggunakan generator terstruktur bawaan lengkap dengan Cover, Bab I - IV, tabel matriks, rincian komponen, dan tampilan rumus pecahan bersusun.'}
                                </Typography>
                            </Box>
                        </Stack>

                        {activeTemplate && (
                            <Stack direction="row" spacing={1.5}>
                                <Button
                                    size="small"
                                    variant="outlined"
                                    startIcon={<DownloadIcon />}
                                    href={route('admin.template.download', activeTemplate.id)}
                                    sx={{ borderRadius: 2, textTransform: 'none', fontWeight: 600 }}
                                >
                                    Unduh File Aktif
                                </Button>
                                <Button
                                    size="small"
                                    variant="outlined"
                                    color="warning"
                                    startIcon={<ResetIcon />}
                                    onClick={handleResetDefault}
                                    sx={{ borderRadius: 2, textTransform: 'none', fontWeight: 600 }}
                                >
                                    Nonaktifkan
                                </Button>
                            </Stack>
                        )}
                    </Stack>
                </CardContent>
            </Card>

            <Grid container spacing={4}>
                {/* Upload Form (Left Column) */}
                <Grid item xs={12} lg={5}>
                    <Card sx={{ borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -4px rgba(0,0,0,0.05)' }}>
                        <Box sx={{ p: 2.5, bgcolor: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                            <Stack direction="row" spacing={1.5} alignItems="center">
                                <UploadIcon sx={{ color: '#2563eb' }} />
                                <Typography variant="subtitle1" fontWeight={800} sx={{ color: '#0f172a' }}>
                                    Unggah Template Word Baru (.docx)
                                </Typography>
                            </Stack>
                        </Box>
                        <CardContent sx={{ p: 3 }}>
                            <form onSubmit={handleFileUpload}>
                                <Stack spacing={2.5}>
                                    <Box>
                                        <Typography variant="caption" fontWeight={700} sx={{ color: '#475569', mb: 0.5, display: 'block' }}>
                                            Nama Template
                                        </Typography>
                                        <TextField
                                            fullWidth
                                            size="small"
                                            placeholder="Contoh: Template Master LKjIP JAMBIN 2026"
                                            value={data.name}
                                            onChange={(e) => setData('name', e.target.value)}
                                            error={!!errors.name}
                                            helperText={errors.name}
                                            sx={{ '& .MuiOutlinedInput-root': { borderRadius: 2 } }}
                                        />
                                    </Box>

                                    <Box>
                                        <Typography variant="caption" fontWeight={700} sx={{ color: '#475569', mb: 0.5, display: 'block' }}>
                                            File Template (.docx)
                                        </Typography>
                                        <Box
                                            sx={{
                                                border: '2px dashed',
                                                borderColor: errors.file ? '#ef4444' : '#cbd5e1',
                                                borderRadius: 2.5,
                                                p: 3,
                                                textAlign: 'center',
                                                bgcolor: '#f8fafc',
                                                cursor: 'pointer',
                                                '&:hover': { borderColor: '#3b82f6', bgcolor: '#eff6ff' }
                                            }}
                                            onClick={() => document.getElementById('template-file-input').click()}
                                        >
                                            <input
                                                id="template-file-input"
                                                type="file"
                                                accept=".docx"
                                                style={{ display: 'none' }}
                                                onChange={(e) => setData('file', e.target.files[0])}
                                            />
                                            <DocIcon sx={{ fontSize: 36, color: '#64748b', mb: 1 }} />
                                            <Typography variant="body2" fontWeight={600} sx={{ color: '#334155' }}>
                                                {data.file ? data.file.name : 'Klik untuk memilih file .docx'}
                                            </Typography>
                                            <Typography variant="caption" sx={{ color: '#94a3b8' }}>
                                                {data.file ? formatFileSize(data.file.size) : 'Maksimal ukuran file: 15 MB'}
                                            </Typography>
                                        </Box>
                                        {errors.file && (
                                            <Typography variant="caption" sx={{ color: '#ef4444', mt: 0.5, display: 'block' }}>
                                                {errors.file}
                                            </Typography>
                                        )}
                                    </Box>

                                    <Box>
                                        <Typography variant="caption" fontWeight={700} sx={{ color: '#475569', mb: 0.5, display: 'block' }}>
                                            Catatan / Deskripsi (Opsional)
                                        </Typography>
                                        <TextField
                                            fullWidth
                                            multiline
                                            rows={3}
                                            size="small"
                                            placeholder="Keterangan perubahan layout atau peruntukan template..."
                                            value={data.description}
                                            onChange={(e) => setData('description', e.target.value)}
                                            sx={{ '& .MuiOutlinedInput-root': { borderRadius: 2 } }}
                                        />
                                    </Box>

                                    <Button
                                        type="submit"
                                        variant="contained"
                                        size="large"
                                        disabled={processing || !data.file || !data.name}
                                        startIcon={<UploadIcon />}
                                        sx={{
                                            py: 1.4,
                                            borderRadius: 2.5,
                                            fontWeight: 700,
                                            textTransform: 'none',
                                            bgcolor: '#2563eb',
                                            '&:hover': { bgcolor: '#1d4ed8' }
                                        }}
                                    >
                                        {processing ? 'Mengunggah & Menyimpan...' : 'Upload & Terapkan Template'}
                                    </Button>
                                </Stack>
                            </form>
                        </CardContent>
                    </Card>

                    {/* Quick Guide Card */}
                    <Card sx={{ mt: 3, borderRadius: 3, border: '1px solid #e2e8f0', bgcolor: '#f8fafc' }}>
                        <CardContent sx={{ p: 2.5 }}>
                            <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1.5 }}>
                                <SparklesIcon sx={{ fontSize: 20, color: '#f59e0b' }} />
                                <Typography variant="subtitle2" fontWeight={800} sx={{ color: '#0f172a' }}>
                                    Alur Praktis Membuat Template di Word
                                </Typography>
                            </Stack>
                            <Typography variant="caption" component="div" sx={{ color: '#475569', lineHeight: 1.7 }}>
                                1. Klik tombol <b>Download Template Acuan (.docx)</b> di atas.<br />
                                2. Buka file tersebut di aplikasi Microsoft Word di laptop Anda.<br />
                                3. Atur sesuka hati: ganti logo, margin, tata letak bab, nomor halaman, atau nomor tabel.<br />
                                4. Letakkan kode variabel seperti <code>${'{tahun}'}</code> atau <code>${'{bab3_akuntabilitas}'}</code> di posisi yang diinginkan.<br />
                                5. Simpan dan unggah kembali file tersebut melalui formulir di atas.
                            </Typography>
                        </CardContent>
                    </Card>
                </Grid>

                {/* Right Column: Placeholders & History Table */}
                <Grid item xs={12} lg={7}>
                    {/* Placeholder Reference */}
                    <Card sx={{ mb: 4, borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -4px rgba(0,0,0,0.05)' }}>
                        <Box sx={{ p: 2.5, bgcolor: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                            <Stack direction="row" justifyContent="space-between" alignItems="center">
                                <Stack direction="row" spacing={1.5} alignItems="center">
                                    <InfoIcon sx={{ color: '#0284c7' }} />
                                    <Typography variant="subtitle1" fontWeight={800} sx={{ color: '#0f172a' }}>
                                        Daftar Variabel (Placeholder) untuk Microsoft Word
                                    </Typography>
                                </Stack>
                                <Typography variant="caption" sx={{ color: '#64748b' }}>
                                    Klik tombol salin untuk menempel di Word
                                </Typography>
                            </Stack>
                        </Box>
                        <CardContent sx={{ p: 2 }}>
                            {placeholders.map((group, gIdx) => (
                                <Accordion key={gIdx} defaultExpanded={gIdx === 0} elevation={0} sx={{ '&:before': { display: 'none' }, border: '1px solid #f1f5f9', mb: 1, borderRadius: 2, overflow: 'hidden' }}>
                                    <AccordionSummary expandIcon={<ExpandMoreIcon />} sx={{ bgcolor: '#f8fafc', minHeight: 44 }}>
                                        <Typography variant="caption" fontWeight={800} sx={{ color: '#334155', textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                            {group.kategori}
                                        </Typography>
                                    </AccordionSummary>
                                    <AccordionDetails sx={{ p: 0 }}>
                                        <Table size="small">
                                            <TableBody>
                                                {group.items.map((item, iIdx) => (
                                                    <TableRow key={iIdx} hover>
                                                        <TableCell sx={{ width: { xs: '50%', sm: '42%' }, py: 1 }}>
                                                            <Chip
                                                                label={item.tag}
                                                                size="small"
                                                                sx={{ fontFamily: 'monospace', fontWeight: 700, bgcolor: '#eff6ff', color: '#1d4ed8', maxWidth: '100%', height: 'auto', py: 0.25, '& .MuiChip-label': { whiteSpace: 'normal', wordBreak: 'break-all' } }}
                                                            />
                                                        </TableCell>
                                                        <TableCell sx={{ py: 1, color: '#475569', fontSize: '0.8125rem' }}>
                                                            {item.deskripsi}
                                                        </TableCell>
                                                        <TableCell align="right" sx={{ width: 48, py: 1 }}>
                                                            <Tooltip title="Salin Variabel">
                                                                <IconButton size="small" onClick={() => handleCopy(item.tag)}>
                                                                    <CopyIcon fontSize="small" sx={{ color: '#94a3b8' }} />
                                                                </IconButton>
                                                            </Tooltip>
                                                        </TableCell>
                                                    </TableRow>
                                                ))}
                                            </TableBody>
                                        </Table>
                                    </AccordionDetails>
                                </Accordion>
                            ))}
                        </CardContent>
                    </Card>

                    {/* Uploaded Templates History */}
                    <Card sx={{ borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -4px rgba(0,0,0,0.05)' }}>
                        <Box sx={{ p: 2.5, bgcolor: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                            <Typography variant="subtitle1" fontWeight={800} sx={{ color: '#0f172a' }}>
                                Riwayat Template yang Diunggah
                            </Typography>
                        </Box>
                        <TableContainer>
                            <Table size="small">
                                <TableHead sx={{ bgcolor: '#f8fafc' }}>
                                    <TableRow>
                                        <TableCell sx={{ fontWeight: 700, color: '#475569' }}>Nama & File</TableCell>
                                        <TableCell sx={{ fontWeight: 700, color: '#475569' }}>Status</TableCell>
                                        <TableCell sx={{ fontWeight: 700, color: '#475569' }}>Pengunggah</TableCell>
                                        <TableCell align="right" sx={{ fontWeight: 700, color: '#475569' }}>Aksi</TableCell>
                                    </TableRow>
                                </TableHead>
                                <TableBody>
                                    {templates.length === 0 ? (
                                        <TableRow>
                                            <TableCell colSpan={4} align="center" sx={{ py: 4, color: '#94a3b8' }}>
                                                Belum ada template kustom yang diunggah. Sistem menggunakan template default.
                                            </TableCell>
                                        </TableRow>
                                    ) : (
                                        templates.map((tpl) => (
                                            <TableRow key={tpl.id} hover>
                                                <TableCell>
                                                    <Typography variant="body2" fontWeight={700} sx={{ color: '#1e293b' }}>
                                                        {tpl.name}
                                                    </Typography>
                                                    <Typography variant="caption" sx={{ color: '#64748b' }}>
                                                        {tpl.file_name} ({formatFileSize(tpl.file_size)}) • {tpl.created_at}
                                                    </Typography>
                                                </TableCell>
                                                <TableCell>
                                                    <Chip
                                                        label={tpl.is_active ? 'AKTIF' : 'NONAKTIF'}
                                                        size="small"
                                                        color={tpl.is_active ? 'success' : 'default'}
                                                        sx={{ fontWeight: 700, height: 22, fontSize: '0.6875rem' }}
                                                    />
                                                </TableCell>
                                                <TableCell>
                                                    <Typography variant="caption" sx={{ color: '#475569' }}>
                                                        {tpl.uploader}
                                                    </Typography>
                                                </TableCell>
                                                <TableCell align="right">
                                                    <Stack direction="row" spacing={0.5} justifyContent="flex-end">
                                                        <Tooltip title="Download Template">
                                                            <IconButton
                                                                size="small"
                                                                href={route('admin.template.download', tpl.id)}
                                                                sx={{ color: '#2563eb' }}
                                                            >
                                                                <DownloadIcon fontSize="small" />
                                                            </IconButton>
                                                        </Tooltip>
                                                        {!tpl.is_active && (
                                                            <Tooltip title="Jadikan Template Aktif">
                                                                <IconButton
                                                                    size="small"
                                                                    onClick={() => handleActivate(tpl.id)}
                                                                    sx={{ color: '#16a34a' }}
                                                                >
                                                                    <ActivateIcon fontSize="small" />
                                                                </IconButton>
                                                            </Tooltip>
                                                        )}
                                                        <Tooltip title="Hapus Template">
                                                            <IconButton
                                                                size="small"
                                                                onClick={() => confirmDelete(tpl)}
                                                                sx={{ color: '#ef4444' }}
                                                            >
                                                                <DeleteIcon fontSize="small" />
                                                            </IconButton>
                                                        </Tooltip>
                                                    </Stack>
                                                </TableCell>
                                            </TableRow>
                                        ))
                                    )}
                                </TableBody>
                            </Table>
                        </TableContainer>
                    </Card>
                </Grid>
            </Grid>

            {/* Delete Confirmation Modal */}
            <Dialog open={openDeleteModal} onClose={() => setOpenDeleteModal(false)} maxWidth="xs" fullWidth>
                <DialogTitle sx={{ fontWeight: 800, color: '#0f172a' }}>Hapus Template Word?</DialogTitle>
                <DialogContent>
                    <Typography variant="body2" sx={{ color: '#475569' }}>
                        Apakah Anda yakin ingin menghapus template <b>{selectedTemplate?.name}</b>? File yang dihapus tidak dapat dipulihkan.
                    </Typography>
                </DialogContent>
                <DialogActions sx={{ p: 2 }}>
                    <Button onClick={() => setOpenDeleteModal(false)} sx={{ color: '#64748b' }}>Batal</Button>
                    <Button onClick={handleDelete} variant="contained" color="error" sx={{ borderRadius: 2 }}>Hapus</Button>
                </DialogActions>
            </Dialog>

            {/* Feedback Snackbar */}
            <Snackbar
                open={!!snackbarMsg}
                autoHideDuration={3000}
                onClose={() => setSnackbarMsg('')}
                message={snackbarMsg}
                anchorOrigin={{ vertical: 'bottom', horizontal: 'center' }}
            />
        </AppLayout>
    );
}
