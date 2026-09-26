import { Head, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { Grid } from '@mui/material';
import ErrorBoundary from '@/Components/Common/ErrorBoundary';
import DashboardHero from './Dashboard/Components/DashboardHero';
import DashboardStats from './Dashboard/Components/DashboardStats';
import StatusPieChart from './Dashboard/Components/StatusPieChart';
import ProgressPieChart from './Dashboard/Components/ProgressPieChart';
import SkBarChart from './Dashboard/Components/SkBarChart';
import IkkBarChart from './Dashboard/Components/IkkBarChart';

export default function Dashboard({ 
    unitName, 
    totalSp = 0, 
    totalIkk = 0, 
    ikkTerisi = 0, 
    rataCapaian = 0, 
    currentTahun = 2025, 
    currentTriwulan = 1, 
    statusList = [],
    skPerformance = [],
    stats = {}
}) {
    const actualStats = stats?.total !== undefined ? stats : {
        total: totalIkk || statusList.length,
        terisi: ikkTerisi || 0,
        tercapai: statusList.filter(i => i.status === 'Tercapai').length,
        belum_tercapai: statusList.filter(i => i.status === 'Belum Tercapai' || i.status === 'Tidak Tercapai').length,
        belum_diisi: statusList.filter(i => i.status === 'Belum Diisi').length
    };

    const progress = actualStats.total > 0 ? (actualStats.terisi / actualStats.total) * 100 : 0;

    const handleTriwulanChange = (event, newTw) => {
        if (newTw !== null && newTw !== currentTriwulan) {
            router.get(route('dashboard'), { tahun: currentTahun, triwulan: newTw }, { preserveState: true });
        }
    };

    // Data for Status Kinerja Donut Chart
    const statusPieData = [
        { id: 0, value: actualStats.tercapai, label: 'Tercapai', color: '#10b981' },
        { id: 1, value: actualStats.belum_tercapai, label: 'Belum Tercapai', color: '#f59e0b' },
        { id: 2, value: actualStats.belum_diisi, label: 'Belum Diisi', color: '#94a3b8' },
    ].filter(item => item.value > 0);

    // Data for Kelengkapan Pengisian Donut Chart
    const pengisianPieData = [
        { id: 0, value: actualStats.terisi, label: 'Sudah Diisi', color: '#059669' },
        { id: 1, value: Math.max(0, actualStats.total - actualStats.terisi), label: 'Belum Diisi', color: '#ef4444' },
    ].filter(item => item.value > 0);

    // Data for SK Performance Bar Chart
    const skBarData = skPerformance && skPerformance.length > 0 
        ? skPerformance.map(sk => ({
            sk: sk.sk_kode,
            nama: sk.sk_nama,
            capaian: Number(sk.rata_capaian || 0),
            terisi: sk.terisi,
            total: sk.total
        }))
        : [];

    // Data for IKK Performance Bar Chart (all indicators)
    const ikkBarData = statusList.map(item => ({
        ikk: item.kode,
        nama: item.nama,
        capaian: item.capaian !== null && item.capaian !== undefined ? Number(item.capaian) : 0,
        status: item.status
    }));

    return (
        <AppLayout title="Dashboard LKjIP Unit Kerja">
            <Head title={`Dashboard — ${unitName || 'Unit Kerja'}`} />

            {/* Top Hero Banner */}
            <ErrorBoundary fallbackMessage="Gagal memuat panel informasi dashboard.">
                <DashboardHero
                    unitName={unitName}
                    currentTahun={currentTahun}
                    currentTriwulan={currentTriwulan}
                    onTriwulanChange={handleTriwulanChange}
                />
            </ErrorBoundary>

            {/* Top KPI Metrics Cards */}
            <ErrorBoundary fallbackMessage="Gagal memuat kartu metrik ringkasan kinerja.">
                <DashboardStats
                    totalSp={totalSp}
                    actualStats={actualStats}
                    progress={progress}
                    rataCapaian={rataCapaian}
                />
            </ErrorBoundary>

            {/* DIAGRAM SECTION 1: Sebaran Status Ketercapaian & Progres Pengisian */}
            <Grid container spacing={3} sx={{ mb: 4 }}>
                <Grid item xs={12} md={6}>
                    <ErrorBoundary fallbackMessage="Gagal memuat diagram sebaran status kinerja.">
                        <StatusPieChart
                            statusPieData={statusPieData}
                            actualStats={actualStats}
                            currentTriwulan={currentTriwulan}
                        />
                    </ErrorBoundary>
                </Grid>

                <Grid item xs={12} md={6}>
                    <ErrorBoundary fallbackMessage="Gagal memuat diagram kelengkapan pengisian.">
                        <ProgressPieChart
                            pengisianPieData={pengisianPieData}
                            actualStats={actualStats}
                            progress={progress}
                        />
                    </ErrorBoundary>
                </Grid>
            </Grid>

            {/* DIAGRAM SECTION 2: Capaian Kinerja per Sasaran Kegiatan (SK) */}
            <ErrorBoundary fallbackMessage="Gagal memuat diagram capaian sasaran kegiatan.">
                <SkBarChart
                    skBarData={skBarData}
                    rataCapaian={rataCapaian}
                />
            </ErrorBoundary>

            {/* DIAGRAM SECTION 3: Capaian Kinerja Seluruh Indikator IKK */}
            <ErrorBoundary fallbackMessage="Gagal memuat diagram capaian indikator kegiatan.">
                <IkkBarChart
                    ikkBarData={ikkBarData}
                    currentTahun={currentTahun}
                    currentTriwulan={currentTriwulan}
                />
            </ErrorBoundary>
        </AppLayout>
    );
}
