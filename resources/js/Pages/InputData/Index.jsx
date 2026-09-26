import { useEffect, useMemo, useState } from 'react';
import { Head, router, usePage } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { Alert, Box, Chip, Paper, Snackbar, Stack, Typography } from '@mui/material';
import ErrorBoundary from '@/Components/Common/ErrorBoundary';
import InputHero from './Components/InputHero';
import LevelTabs from './Components/LevelTabs';
import InputToolbar from './Components/InputToolbar';
import IkpCard from './Components/IkpCard';
import IkkCard from './Components/IkkCard';
import SpAccordion from './Components/SpAccordion';
import SkAccordion from './Components/SkAccordion';
import StickyActionBar from './Components/StickyActionBar';
import { formatCleanNumber, measurementInputs } from './Utils/inputHelpers';

export default function InputData({
    selectedBiro,
    bidangId,
    currentTahun,
    currentTriwulan,
    ikks = [],
    pengukuranIkk = {},
    targetIkk = {},
    ikpMandiris = [],
    ikpInputs = [],
    pengukuranIkp = {},
    targetIkpMandiri = {},
    targetIkp = {},
}) {
    const { flash } = usePage().props;
    const effectiveIkpInputs = ikpInputs.length > 0 ? ikpInputs : ikpMandiris;
    const effectiveTargetIkp = Object.keys(targetIkp).length > 0 ? targetIkp : targetIkpMandiri;

    const [activeTab, setActiveTab] = useState(effectiveIkpInputs.length > 0 && ikks.length === 0 ? 'IKP' : 'IKK');
    const [tahun, setTahun] = useState(currentTahun);
    const [triwulan, setTriwulan] = useState(currentTriwulan);
    const [loading, setLoading] = useState(false);
    const [savingCode, setSavingCode] = useState(null);
    const [toast, setToast] = useState({ open: !!flash?.success, message: flash?.success || '', severity: 'success' });

    const initialIkkData = useMemo(() => ikks.reduce((acc, ikk) => {
        const measurement = pengukuranIkk[ikk.node_id] || {};
        const inputsObj = measurementInputs(measurement);
        acc[ikk.kode_ikk] = {
            kode_ikk: ikk.kode_ikk,
            pembilang: formatCleanNumber(measurement.pembilang) || inputsObj.pembilang || '',
            penyebut: formatCleanNumber(measurement.penyebut) || inputsObj.penyebut || '',
            realisasi: formatCleanNumber(measurement.realisasi) || inputsObj.realisasi || inputsObj.direct_value || inputsObj.nilai || '',
            inputs: inputsObj,
            analisis_capaian: measurement.analisis_capaian ?? '',
            kendala: measurement.kendala ?? '',
            upaya: measurement.upaya ?? '',
        };
        return acc;
    }, {}), [ikks, pengukuranIkk]);

    const initialIkpData = useMemo(() => effectiveIkpInputs.reduce((acc, ikp) => {
        const measurement = pengukuranIkp[ikp.node_id] || {};
        const inputsObj = measurementInputs(measurement);
        acc[ikp.kode_ikp] = {
            kode_ikp: ikp.kode_ikp,
            pembilang: formatCleanNumber(measurement.pembilang) || inputsObj.pembilang || '',
            penyebut: formatCleanNumber(measurement.penyebut) || inputsObj.penyebut || '',
            realisasi: formatCleanNumber(measurement.realisasi) || inputsObj.realisasi || inputsObj.direct_value || inputsObj.nilai || '',
            inputs: inputsObj,
            analisis_capaian: measurement.analisis_capaian ?? '',
            kendala: measurement.kendala ?? '',
            upaya: measurement.upaya ?? '',
        };
        return acc;
    }, {}), [effectiveIkpInputs, pengukuranIkp]);

    const [formData, setFormData] = useState(initialIkkData);
    const [ikpFormData, setIkpFormData] = useState(initialIkpData);

    useEffect(() => {
        setFormData(initialIkkData);
    }, [initialIkkData]);

    useEffect(() => {
        setIkpFormData(initialIkpData);
    }, [initialIkpData]);

    const updateIkk = (code, field, value) => setFormData((prev) => ({
        ...prev,
        [code]: { ...prev[code], [field]: value },
    }));

    const updateIkp = (code, field, value) => setIkpFormData((prev) => ({
        ...prev,
        [code]: { ...prev[code], [field]: value },
    }));

    const [collapsedSps, setCollapsedSps] = useState({});
    const [collapsedSks, setCollapsedSks] = useState({});
    const [searchKeyword, setSearchKeyword] = useState('');

    const toggleSp = (spKode) => {
        setCollapsedSps((prev) => ({ ...prev, [spKode]: !prev[spKode] }));
    };

    const toggleSk = (skKey) => {
        setCollapsedSks((prev) => ({ ...prev, [skKey]: !prev[skKey] }));
    };

    // Group IKKs hierarchically by SP and SK
    const groupedIkksBySp = useMemo(() => {
        const spMap = new Map();

        ikks.forEach((ikk) => {
            const matchesSearch = !searchKeyword ||
                (ikk.nama_ikk || '').toLowerCase().includes(searchKeyword.toLowerCase()) ||
                (ikk.kode_ikk || '').toLowerCase().includes(searchKeyword.toLowerCase()) ||
                (ikk.sk_nama || '').toLowerCase().includes(searchKeyword.toLowerCase()) ||
                (ikk.sk_kode || '').toLowerCase().includes(searchKeyword.toLowerCase()) ||
                (ikk.sp_nama || '').toLowerCase().includes(searchKeyword.toLowerCase());

            if (!matchesSearch) return;

            const spKode = ikk.sp_kode || 'SP';
            const spNama = ikk.sp_nama || 'Sasaran Program';
            const skKode = ikk.sk_kode || 'SK';
            const skNama = ikk.sk_nama || 'Sasaran Kegiatan';

            if (!spMap.has(spKode)) {
                spMap.set(spKode, {
                    sp_kode: spKode,
                    sp_nama: spNama,
                    skMap: new Map(),
                    total_ikks: 0,
                });
            }

            const spItem = spMap.get(spKode);
            spItem.total_ikks += 1;

            if (!spItem.skMap.has(skKode)) {
                spItem.skMap.set(skKode, {
                    sk_kode: skKode,
                    sk_nama: skNama,
                    ikks: [],
                });
            }

            spItem.skMap.get(skKode).ikks.push(ikk);
        });

        return Array.from(spMap.values()).map((sp) => ({
            sp_kode: sp.sp_kode,
            sp_nama: sp.sp_nama,
            total_ikks: sp.total_ikks,
            sks: Array.from(sp.skMap.values()),
        }));
    }, [ikks, searchKeyword]);

    // Group IKPs hierarchically by SP
    const groupedIkpsBySp = useMemo(() => {
        const spMap = new Map();

        effectiveIkpInputs.forEach((ikp) => {
            const matchesSearch = !searchKeyword ||
                (ikp.nama_ikp || '').toLowerCase().includes(searchKeyword.toLowerCase()) ||
                (ikp.kode_ikp || '').toLowerCase().includes(searchKeyword.toLowerCase()) ||
                (ikp.sp_nama || '').toLowerCase().includes(searchKeyword.toLowerCase());

            if (!matchesSearch) return;

            const spKode = ikp.sp_kode || 'SP';
            const spNama = ikp.sp_nama || 'Sasaran Program';

            if (!spMap.has(spKode)) {
                spMap.set(spKode, {
                    sp_kode: spKode,
                    sp_nama: spNama,
                    ikps: [],
                });
            }

            spMap.get(spKode).ikps.push(ikp);
        });

        return Array.from(spMap.values());
    }, [effectiveIkpInputs, searchKeyword]);

    const expandAll = () => {
        setCollapsedSps({});
        setCollapsedSks({});
    };

    const collapseAll = () => {
        const sps = {};
        const sks = {};
        groupedIkksBySp.forEach((sp) => {
            sps[sp.sp_kode] = true;
            sp.sks.forEach((sk) => {
                sks[`${sp.sp_kode}_${sk.sk_kode}`] = true;
            });
        });
        groupedIkpsBySp.forEach((sp) => {
            sps[sp.sp_kode] = true;
        });
        setCollapsedSps(sps);
        setCollapsedSks(sks);
    };

    const hasPayload = (row) => {
        const inputValues = Object.values(row.inputs || {});
        return row.pembilang !== ''
            || row.penyebut !== ''
            || row.realisasi !== ''
            || inputValues.some((value) => value !== '')
            || row.analisis_capaian !== ''
            || row.kendala !== ''
            || row.upaya !== '';
    };

    const handleSaveSingle = (type, code) => {
        setSavingCode(code);

        const sourceData = type === 'IKK' ? formData[code] : ikpFormData[code];
        const row = sourceData || (type === 'IKK' ? { kode_ikk: code, inputs: {} } : { kode_ikp: code, inputs: {} });

        const normalizedInputs = {};
        Object.entries(row.inputs || {}).forEach(([k, v]) => {
            normalizedInputs[k] = typeof v === 'string' ? v.replace(',', '.') : v;
        });

        const normalizedRow = {
            ...row,
            pembilang: typeof row.pembilang === 'string' ? row.pembilang.replace(',', '.') : row.pembilang,
            penyebut: typeof row.penyebut === 'string' ? row.penyebut.replace(',', '.') : row.penyebut,
            realisasi: typeof row.realisasi === 'string' ? row.realisasi.replace(',', '.') : row.realisasi,
            inputs: normalizedInputs,
        };

        router.post(route('input-data.store'), {
            tahun,
            triwulan,
            data: type === 'IKK' ? [normalizedRow] : [],
            ikp_data: type === 'IKP' ? [normalizedRow] : [],
        }, {
            preserveScroll: true,
            onFinish: () => setSavingCode(null),
            onSuccess: () => setToast({
                open: true,
                message: `Data ${code} berhasil disimpan dan capaian kinerja telah dikalkulasi ulang.`,
                severity: 'success',
            }),
            onError: (errors) => {
                const errorMsg = Object.values(errors)[0] || `Gagal menyimpan data ${code}.`;
                setToast({
                    open: true,
                    message: errorMsg,
                    severity: 'error',
                });
            },
        });
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        setLoading(true);

        const normalizeData = (list) => Object.values(list).filter(hasPayload).map((row) => {
            const normalizedInputs = {};
            Object.entries(row.inputs || {}).forEach(([k, v]) => {
                normalizedInputs[k] = typeof v === 'string' ? v.replace(',', '.') : v;
            });
            return {
                ...row,
                pembilang: typeof row.pembilang === 'string' ? row.pembilang.replace(',', '.') : row.pembilang,
                penyebut: typeof row.penyebut === 'string' ? row.penyebut.replace(',', '.') : row.penyebut,
                realisasi: typeof row.realisasi === 'string' ? row.realisasi.replace(',', '.') : row.realisasi,
                inputs: normalizedInputs,
            };
        });

        router.post(route('input-data.store'), {
            tahun,
            triwulan,
            data: normalizeData(formData),
            ikp_data: normalizeData(ikpFormData),
        }, {
            preserveScroll: true,
            onFinish: () => setLoading(false),
            onSuccess: () => setToast({
                open: true,
                message: 'Data pengukuran berhasil disimpan dan realisasi capaian telah dikalkulasi ulang.',
                severity: 'success',
            }),
            onError: (errors) => {
                const errorMsg = Object.values(errors)[0] || 'Gagal menyimpan data pengukuran.';
                setToast({
                    open: true,
                    message: errorMsg,
                    severity: 'error',
                });
            },
        });
    };

    const changePeriod = (field, value) => {
        const nextTahun = field === 'tahun' ? value : tahun;
        const nextTriwulan = field === 'triwulan' ? value : triwulan;
        setTahun(nextTahun);
        setTriwulan(nextTriwulan);
        router.get(route('input-data.index'), { tahun: nextTahun, triwulan: nextTriwulan });
    };

    return (
        <AppLayout title="Pengukuran Kinerja LKjIP">
            <Head title={`Input Data Kinerja — ${selectedBiro || 'Unit'}`} />

            <Snackbar open={toast.open} autoHideDuration={6000} onClose={() => setToast((prev) => ({ ...prev, open: false }))}>
                <Alert severity={toast.severity || 'success'} variant="filled">{toast.message}</Alert>
            </Snackbar>

            {/* Top Hero Banner */}
            <ErrorBoundary fallbackMessage="Gagal memuat header panel pengukuran.">
                <InputHero
                    selectedBiro={selectedBiro}
                    bidangId={bidangId}
                    tahun={tahun}
                    triwulan={triwulan}
                    onPeriodChange={changePeriod}
                />
            </ErrorBoundary>

            {/* Level Tab Switcher if both exist */}
            {effectiveIkpInputs.length > 0 && ikks.length > 0 && (
                <ErrorBoundary fallbackMessage="Gagal memuat navigasi level indikator.">
                    <LevelTabs
                        activeTab={activeTab}
                        onTabChange={setActiveTab}
                        ikkCount={ikks.length}
                        ikpCount={effectiveIkpInputs.length}
                    />
                </ErrorBoundary>
            )}

            {/* Expand / Collapse & Search Action Toolbar */}
            <ErrorBoundary fallbackMessage="Gagal memuat kontrol pencarian dan tampilan.">
                <InputToolbar
                    searchKeyword={searchKeyword}
                    onSearchChange={setSearchKeyword}
                    onResetSearch={() => setSearchKeyword('')}
                    onExpandAll={expandAll}
                    onCollapseAll={collapseAll}
                />
            </ErrorBoundary>

            <form onSubmit={handleSubmit}>
                {/* IKP Section Grouped by SP */}
                {effectiveIkpInputs.length > 0 && (activeTab === 'IKP' || ikks.length === 0) && (
                    <Box sx={{ mb: 4 }}>
                        <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 2 }}>
                            <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                                Indikator Sasaran Program (IKP)
                            </Typography>
                            <Chip
                                label={`${groupedIkpsBySp.reduce((acc, sp) => acc + sp.ikps.length, 0)} IKP Terfilter`}
                                size="small"
                                sx={{ bgcolor: '#eff6ff', color: '#2563eb', fontWeight: 700, border: '1px solid #bfdbfe' }}
                            />
                        </Stack>

                        {groupedIkpsBySp.map((spGroup) => {
                            const isSpCollapsed = !!collapsedSps[spGroup.sp_kode];

                            return (
                                <ErrorBoundary key={spGroup.sp_kode} fallbackMessage={`Gagal memuat sasaran program ${spGroup.sp_kode}.`}>
                                    <SpAccordion
                                        spKode={spGroup.sp_kode}
                                        spNama={spGroup.sp_nama}
                                        isCollapsed={isSpCollapsed}
                                        onToggle={() => toggleSp(spGroup.sp_kode)}
                                        badgeChips={[
                                            {
                                                label: `${spGroup.ikps.length} IKP`,
                                                sx: { bgcolor: 'rgba(16, 185, 129, 0.2)', color: '#34d399', fontWeight: 700, border: '1px solid rgba(16, 185, 129, 0.3)' }
                                            }
                                        ]}
                                    >
                                        {spGroup.ikps.map((ikp) => {
                                            const target = effectiveTargetIkp[ikp.node_id];
                                            const measurement = pengukuranIkp[ikp.node_id];
                                            const value = ikpFormData[ikp.kode_ikp] || { inputs: {} };

                                            return (
                                                <ErrorBoundary key={ikp.kode_ikp} fallbackMessage={`Gagal memuat kartu indikator ${ikp.kode_ikp}.`}>
                                                    <IkpCard
                                                        ikp={ikp}
                                                        target={target}
                                                        measurement={measurement}
                                                        value={value}
                                                        onChange={(field, fieldValue) => updateIkp(ikp.kode_ikp, field, fieldValue)}
                                                        onSaveSingle={handleSaveSingle}
                                                        isSaving={savingCode === ikp.kode_ikp}
                                                        loading={loading}
                                                    />
                                                </ErrorBoundary>
                                            );
                                        })}
                                    </SpAccordion>
                                </ErrorBoundary>
                            );
                        })}
                    </Box>
                )}

                {/* IKK Section Grouped by SP and SK with Expand & Collapse */}
                {ikks.length > 0 && (activeTab === 'IKK' || effectiveIkpInputs.length === 0) && (
                    <Box sx={{ mb: 4 }}>
                        <Stack direction="row" justifyContent="space-between" alignItems="center" sx={{ mb: 2 }}>
                            <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                                Indikator Kinerja Kegiatan (IKK)
                            </Typography>
                            <Chip
                                label={`${groupedIkksBySp.reduce((acc, sp) => acc + sp.total_ikks, 0)} IKK Terfilter`}
                                size="small"
                                sx={{ bgcolor: '#f0fdf4', color: '#059669', fontWeight: 700, border: '1px solid #bbf7d0' }}
                            />
                        </Stack>

                        {groupedIkksBySp.map((spGroup) => {
                            const isSpCollapsed = !!collapsedSps[spGroup.sp_kode];

                            return (
                                <ErrorBoundary key={spGroup.sp_kode} fallbackMessage={`Gagal memuat sasaran program ${spGroup.sp_kode}.`}>
                                    <SpAccordion
                                        spKode={spGroup.sp_kode}
                                        spNama={spGroup.sp_nama}
                                        isCollapsed={isSpCollapsed}
                                        onToggle={() => toggleSp(spGroup.sp_kode)}
                                        badgeChips={[
                                            { label: `${spGroup.sks.length} Sasaran Kegiatan` },
                                            {
                                                label: `${spGroup.total_ikks} IKK`,
                                                sx: { bgcolor: 'rgba(16, 185, 129, 0.25)', color: '#34d399', fontWeight: 800, border: '1px solid rgba(16, 185, 129, 0.4)' }
                                            }
                                        ]}
                                    >
                                        {spGroup.sks.map((skGroup) => {
                                            const skKey = `${spGroup.sp_kode}_${skGroup.sk_kode}`;
                                            const isSkCollapsed = !!collapsedSks[skKey];

                                            return (
                                                <ErrorBoundary key={skKey} fallbackMessage={`Gagal memuat sasaran kegiatan ${skGroup.sk_kode}.`}>
                                                    <SkAccordion
                                                        skKode={skGroup.sk_kode}
                                                        skNama={skGroup.sk_nama}
                                                        ikkCount={skGroup.ikks.length}
                                                        isCollapsed={isSkCollapsed}
                                                        onToggle={() => toggleSk(skKey)}
                                                    >
                                                        {skGroup.ikks.map((ikk) => {
                                                            const target = targetIkk[ikk.node_id];
                                                            const measurement = pengukuranIkk[ikk.node_id];
                                                            const value = formData[ikk.kode_ikk] || { inputs: {} };

                                                            return (
                                                                <ErrorBoundary key={ikk.kode_ikk} fallbackMessage={`Gagal memuat kartu indikator ${ikk.kode_ikk}.`}>
                                                                    <IkkCard
                                                                        ikk={ikk}
                                                                        target={target}
                                                                        measurement={measurement}
                                                                        value={value}
                                                                        onChange={(field, fieldValue) => updateIkk(ikk.kode_ikk, field, fieldValue)}
                                                                        onSaveSingle={handleSaveSingle}
                                                                        isSaving={savingCode === ikk.kode_ikk}
                                                                        loading={loading}
                                                                    />
                                                                </ErrorBoundary>
                                                            );
                                                        })}
                                                    </SkAccordion>
                                                </ErrorBoundary>
                                            );
                                        })}
                                    </SpAccordion>
                                </ErrorBoundary>
                            );
                        })}
                    </Box>
                )}

                {effectiveIkpInputs.length === 0 && ikks.length === 0 && (
                    <Alert severity="warning" sx={{ borderRadius: 3, p: 2.5 }}>
                        Tidak ada indikator input yang terhubung dengan unit kerja akun ini.
                    </Alert>
                )}

                {/* Floating Bottom Sticky Action Bar */}
                <StickyActionBar loading={loading} />
            </form>
        </AppLayout>
    );
}
