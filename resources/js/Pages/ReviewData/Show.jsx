import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    Box, Card, CardContent, Typography, Grid, Button, 
    Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Chip, Stack, Divider 
} from '@mui/material';
import { ArrowBack as ArrowBackIcon, Functions as FunctionsIcon, Assessment as AssessmentIcon } from '@mui/icons-material';

export default function ReviewDataShow({ indikator, pengukurans = [] }) {
    return (
        <AppLayout title={`Detail Indikator — ${indikator.kode_indikator}`}>
            <Head title={`Detail ${indikator.kode_indikator}`} />

            <Box sx={{ mb: 3 }}>
                <Button 
                    component={Link} 
                    href={route('review-data.index')} 
                    startIcon={<ArrowBackIcon />}
                    variant="outlined"
                    sx={{ borderRadius: 2, fontWeight: 700, textTransform: 'none' }}
                >
                    Kembali ke Daftar Review Data
                </Button>
            </Box>

            {/* Main Info Card */}
            <Card sx={{ mb: 4, borderRadius: 3.5, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -2px rgba(15, 23, 42, 0.05)', overflow: 'hidden' }}>
                <Box sx={{ p: 3, bgcolor: '#0f172a', color: '#ffffff' }}>
                    <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1 }}>
                        <Chip label={indikator.level} size="small" sx={{ bgcolor: 'rgba(16, 185, 129, 0.2)', color: '#34d399', fontWeight: 800, border: '1px solid rgba(16, 185, 129, 0.4)' }} />
                        <Chip label={indikator.tipe_formula || 'Formula Engine'} size="small" sx={{ bgcolor: 'rgba(255,255,255,0.1)', color: '#e2e8f0', fontWeight: 600 }} />
                    </Stack>
                    <Typography variant="h5" fontWeight={800} sx={{ letterSpacing: -0.5 }}>
                        [{indikator.kode_indikator}] {indikator.nama_kinerja}
                    </Typography>
                </Box>

                <CardContent sx={{ p: 3 }}>
                    <Grid container spacing={3}>
                        <Grid item xs={12} sm={4}>
                            <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase' }}>Unit Pengampu</Typography>
                            <Typography variant="body1" fontWeight={700} sx={{ color: '#0f172a', mt: 0.5 }}>
                                {indikator.unit_pengampu || 'Seluruh Satuan Kerja'}
                            </Typography>
                        </Grid>
                        <Grid item xs={12} sm={4}>
                            <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase' }}>Level Hirarki Kinerja</Typography>
                            <Typography variant="body1" fontWeight={700} sx={{ color: '#0f172a', mt: 0.5 }}>
                                Tingkat {indikator.level} (Canonical Renstra JAMBIN)
                            </Typography>
                        </Grid>
                        <Grid item xs={12} sm={4}>
                            <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase' }}>Tipe Perhitungan</Typography>
                            <Typography variant="body1" fontWeight={700} sx={{ color: '#0f172a', mt: 0.5 }}>
                                {indikator.tipe_formula || 'Direct Value'}
                            </Typography>
                        </Grid>
                    </Grid>
                </CardContent>
            </Card>

            <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a', mb: 2 }}>
                Riwayat Pengukuran per Triwulan
            </Typography>
            
            <TableContainer component={Paper} sx={{ borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -2px rgba(15, 23, 42, 0.05)', overflow: 'hidden' }}>
                <Table>
                    <TableHead sx={{ bgcolor: '#f8fafc' }}>
                        <TableRow>
                            <TableCell sx={{ fontWeight: 800, color: '#0f172a' }}>Tahun</TableCell>
                            <TableCell sx={{ fontWeight: 800, color: '#0f172a' }}>Triwulan</TableCell>
                            <TableCell sx={{ fontWeight: 800, color: '#0f172a' }}>Target</TableCell>
                            <TableCell sx={{ fontWeight: 800, color: '#0f172a' }}>Hasil Kinerja (Realisasi)</TableCell>
                            <TableCell sx={{ fontWeight: 800, color: '#0f172a' }}>Capaian terhadap Target (%)</TableCell>
                            <TableCell sx={{ fontWeight: 800, color: '#0f172a' }}>Analisis Capaian</TableCell>
                            <TableCell sx={{ fontWeight: 800, color: '#0f172a' }}>Kendala</TableCell>
                            <TableCell sx={{ fontWeight: 800, color: '#0f172a' }}>Upaya Tindak Lanjut</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {pengukurans.length === 0 ? (
                            <TableRow>
                                <TableCell colSpan={8} align="center" sx={{ py: 5, color: '#94a3b8' }}>
                                    Belum ada data pengukuran untuk indikator ini pada periode terpilih.
                                </TableCell>
                            </TableRow>
                        ) : (
                            pengukurans.map((p) => {
                                const isTercapai = p.capaian_terhadap_target >= 100;
                                const isWarning = p.capaian_terhadap_target >= 80 && p.capaian_terhadap_target < 100;
                                const color = isTercapai ? '#059669' : (isWarning ? '#d97706' : '#dc2626');
                                const bg = isTercapai ? '#f0fdf4' : (isWarning ? '#fffbeb' : '#fef2f2');

                                return (
                                    <TableRow key={p.id} hover sx={{ '&:hover': { bgcolor: '#f8fafc' } }}>
                                        <TableCell sx={{ fontWeight: 700 }}>{p.tahun}</TableCell>
                                        <TableCell sx={{ fontWeight: 700 }}>TW {p.triwulan}</TableCell>
                                        <TableCell sx={{ fontWeight: 600 }}>{p.target ?? '-'}</TableCell>
                                        <TableCell sx={{ fontWeight: 700 }}>{p.hasil_kinerja ?? '-'}</TableCell>
                                        <TableCell>
                                            {p.capaian_terhadap_target != null ? (
                                                <Chip 
                                                    label={`${p.capaian_terhadap_target}%`} 
                                                    size="small" 
                                                    sx={{ fontWeight: 800, color, bgcolor: bg, border: `1px solid ${color}40` }} 
                                                />
                                            ) : '-'}
                                        </TableCell>
                                        <TableCell sx={{ maxWidth: 200 }}>
                                            <Typography variant="body2" sx={{ color: '#334155' }}>
                                                {p.analisis_capaian || '-'}
                                            </Typography>
                                        </TableCell>
                                        <TableCell sx={{ maxWidth: 180, color: '#b91c1c', fontStyle: 'italic' }}>
                                            {p.kendala || '-'}
                                        </TableCell>
                                        <TableCell sx={{ maxWidth: 180, color: '#059669', fontStyle: 'italic' }}>
                                            {p.upaya || '-'}
                                        </TableCell>
                                    </TableRow>
                                );
                            })
                        )}
                    </TableBody>
                </Table>
            </TableContainer>
        </AppLayout>
    );
}
