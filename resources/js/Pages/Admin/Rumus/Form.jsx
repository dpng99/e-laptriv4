import React, { useState, useRef, useMemo, useEffect } from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { 
    Box, Typography, Button, Paper, Grid, TextField, MenuItem, FormControl, 
    InputLabel, Select, IconButton, Divider, Switch, FormControlLabel, Card, 
    CardContent, Stack, Chip, Alert, AlertTitle, Tooltip, InputAdornment, 
    Collapse, LinearProgress, Badge
} from '@mui/material';
import DeleteIcon from '@mui/icons-material/Delete';
import AddIcon from '@mui/icons-material/Add';
import SaveIcon from '@mui/icons-material/Save';
import ArrowBackIcon from '@mui/icons-material/ArrowBack';
import FunctionsIcon from '@mui/icons-material/Functions';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import InfoIcon from '@mui/icons-material/InfoOutlined';
import CalculateIcon from '@mui/icons-material/CalculateOutlined';
import ArrowUpwardIcon from '@mui/icons-material/ArrowUpward';
import ArrowDownwardIcon from '@mui/icons-material/ArrowDownward';
import AutoFixHighIcon from '@mui/icons-material/AutoFixHigh';
import TuneIcon from '@mui/icons-material/Tune';
import ScienceIcon from '@mui/icons-material/Science';
import CopyIcon from '@mui/icons-material/ContentCopy';

import { 
    extractVariables, 
    validateFormulaSyntax, 
    evaluateFormula, 
    calculateCapaianSimulasi 
} from '@/Utils/formulaEvaluator';

const FORMULA_TYPE_SPECS = [
    {
        value: 'RATIO_PERCENTAGE',
        label: 'RATIO_PERCENTAGE — Rasio Persentase ((X1 / X2) × 100%)',
        group: 'Rasio & Persentase',
        badge: 'Rasio %',
        badgeColor: 'primary',
        isRatio: true,
        desc: 'Menghitung rasio pembagian pembilang terhadap penyebut dikalikan 100%. Cocok untuk tingkat pemenuhan, persentase kepatuhan, atau serapan anggaran.'
    },
    {
        value: 'RATIO',
        label: 'RATIO — Rasio Murni (X1 / X2)',
        group: 'Rasio & Persentase',
        badge: 'Rasio Murni',
        badgeColor: 'info',
        isRatio: true,
        desc: 'Perbandingan pembilang terhadap penyebut tanpa pengali 100. Contoh: rasio jaksa terhadap perkara, atau rasio beban kerja.'
    },
    {
        value: 'UNFAVORABLE_PERCENTAGE',
        label: 'UNFAVORABLE_PERCENTAGE — Persentase Negatif (Makin Rendah Makin Baik)',
        group: 'Rasio & Persentase',
        badge: 'Negatif / Efisiensi',
        badgeColor: 'warning',
        isRatio: true,
        desc: 'Untuk indikator negatif (seperti tingkat pelanggaran disiplin atau tunggakan perkara). Realisasi yang lebih rendah dari target menghasilkan capaian yang lebih baik.'
    },
    {
        value: 'AVERAGE',
        label: 'AVERAGE — Rata-rata Aritmatika Komponen',
        group: 'Agregasi Komponen',
        badge: 'Rata-rata',
        badgeColor: 'secondary',
        isRatio: false,
        desc: 'Rata-rata sederhana dari seluruh nilai variabel yang dimasukkan. Contoh: rata-rata nilai evaluasi unit kerja.'
    },
    {
        value: 'WEIGHTED_SUM',
        label: 'WEIGHTED_SUM — Penjumlahan Terbobot (Komposit)',
        group: 'Agregasi Komponen',
        badge: 'Komposit Bobot',
        badgeColor: 'success',
        isRatio: false,
        desc: 'Nilai komposit dari beberapa komponen dengan bobot masing-masing: ∑ (Bobot × Nilai). Contoh: Indeks Pelayanan Terpadu.'
    },
    {
        value: 'AGGREGATE_AVG',
        label: 'AGGREGATE_AVG — Rata-rata Agregasi Unit / Satker',
        group: 'Agregasi Satker',
        badge: 'Roll-up Unit',
        badgeColor: 'secondary',
        isRatio: false,
        desc: 'Konsolidasi otomatis dari realisasi indikator bawahan di seluruh Kejaksaan Tinggi/Negeri tanpa input manual variabel.'
    },
    {
        value: 'DIRECT_VALUE',
        label: 'DIRECT_VALUE — Input Nilai Langsung',
        group: 'Nilai Langsung & Eksternal',
        badge: 'Nilai Langsung',
        badgeColor: 'default',
        isRatio: false,
        desc: 'Nilai realisasi diinput langsung sebagai angka tunggal tanpa formula perantara. Contoh: Opini BPK (WTP/WDP) atau jumlah regulasi.'
    },
    {
        value: 'INDEX_SCORE',
        label: 'INDEX_SCORE — Skor Indeks / Nilai Kematangan',
        group: 'Nilai Langsung & Eksternal',
        badge: 'Skor Indeks',
        badgeColor: 'primary',
        isRatio: false,
        desc: 'Skor evaluasi atau maturitas dalam skala tertentu (misal skala 0-100). Contoh: Indeks SPBE, Indeks Kearsipan.'
    },
    {
        value: 'EXTERNAL_SCORE',
        label: 'EXTERNAL_SCORE — Penilaian Eksternal (Audit / KemenPAN-RB)',
        group: 'Nilai Langsung & Eksternal',
        badge: 'Audit Eksternal',
        badgeColor: 'info',
        isRatio: false,
        desc: 'Nilai resmi yang diterbitkan oleh instansi eksternal seperti KemenPAN-RB, BPKP, atau Ombudsman.'
    },
    {
        value: 'SURVEY_INDEX',
        label: 'SURVEY_INDEX — Indeks Hasil Survei',
        group: 'Nilai Langsung & Eksternal',
        badge: 'Survei',
        badgeColor: 'success',
        isRatio: false,
        desc: 'Indeks persepsi atau kepuasan yang dihitung melalui instrumen kuesioner/survei berkala.'
    },
    {
        value: 'CUSTOM',
        label: 'CUSTOM — Formula Matematika Kustom',
        group: 'Kustom',
        badge: 'Formula Bebas',
        badgeColor: 'warning',
        isRatio: false,
        desc: 'Formula bebas multi-variabel sesuai ketentuan teknis petunjuk operasional indikator.'
    }
];

const ARAH_KINERJA_OPTIONS = [
    {
        value: 'POSITIF',
        label: 'POSITIF (Makin Tinggi Makin Baik)',
        desc: 'Capaian = (Realisasi / Target) × 100%. Contoh: Serapan anggaran, jumlah pegawai terlatih.',
        color: '#059669',
        bgColor: '#ecfdf5',
        borderColor: '#a7f3d0'
    },
    {
        value: 'NEGATIF',
        label: 'NEGATIF (Makin Rendah Makin Baik)',
        desc: 'Capaian = (Target / Realisasi) × 100%. Contoh: Jumlah komplain publik, angka pelanggaran etik.',
        color: '#d97706',
        bgColor: '#fffbeb',
        borderColor: '#fde68a'
    }
];

const FORMULA_PRESETS = [
    { label: 'Rasio Persentase Standar', formula: '(X1 / X2) * 100', desc: 'Pembilang (X1) dibagi Penyebut (X2) × 100%' },
    { label: 'Rasio Murni', formula: 'X1 / X2', desc: 'Pembilang dibagi Penyebut' },
    { label: 'Persentase Efisiensi', formula: '(1 - (X1 / X2)) * 100', desc: '100% dikurangi rasio' },
    { label: 'Rata-rata 2 Komponen', formula: '(X1 + X2) / 2', desc: 'Nilai tengah antara X1 dan X2' },
    { label: 'Rata-rata 3 Komponen', formula: '(X1 + X2 + X3) / 3', desc: 'Rata-rata tiga variabel' },
    { label: 'Komposit Bobot (50% : 50%)', formula: '(X1 * 0.5) + (X2 * 0.5)', desc: 'Penjumlahan variabel berbobot seimbang' }
];

const MATH_OPERATORS = [
    { label: '+', value: ' + ', title: 'Penjumlahan' },
    { label: '-', value: ' - ', title: 'Pengurangan' },
    { label: '×', value: ' * ', title: 'Perkalian' },
    { label: '÷', value: ' / ', title: 'Pembagian' },
    { label: '(', value: '(', title: 'Kurung Buka' },
    { label: ')', value: ')', title: 'Kurung Tutup' },
    { label: '100', value: '100', title: 'Konstanta 100 (Persentase)' },
    { label: '0', value: '0', title: 'Angka Nol' }
];

export default function RumusForm({ nodes = [], formula = null }) {
    const isEdit = !!formula;
    const formulaInputRef = useRef(null);

    const { data, setData, post, put, processing, errors } = useForm({
        node_id: formula?.node_id || '',
        tipe_formula: formula?.tipe_formula || 'RATIO_PERCENTAGE',
        arah_kinerja: formula?.arah_kinerja || 'POSITIF',
        rumus_tampilan: formula?.rumus_tampilan || '',
        batas_capaian: formula?.batas_capaian ?? '',
        jumlah_desimal: formula?.jumlah_desimal ?? 2,
        judul_pembilang: formula?.judul_pembilang || '',
        judul_penyebut: formula?.judul_penyebut || '',
        is_active: formula?.is_active ?? true,
        komponen: formula?.komponen || []
    });

    // Cari node yang sedang dipilih
    const selectedNode = useMemo(() => {
        return nodes.find(n => String(n.id) === String(data.node_id)) || null;
    }, [nodes, data.node_id]);

    // Cari spesifikasi tipe formula yang dipilih
    const activeFormulaSpec = useMemo(() => {
        return FORMULA_TYPE_SPECS.find(s => s.value === data.tipe_formula) || {
            value: data.tipe_formula,
            label: data.tipe_formula,
            group: 'Lainnya',
            badge: 'Tipe Rumus',
            badgeColor: 'default',
            isRatio: false,
            desc: 'Model formula matematis indikator.'
        };
    }, [data.tipe_formula]);

    // State untuk Formula Simulator
    const [simTarget, setSimTarget] = useState('100');
    const [simValues, setSimValues] = useState({});
    const [showSimulator, setShowSimulator] = useState(true);

    // Sinkronkan nilai simulator dengan variabel yang ada
    useEffect(() => {
        const currentVars = data.komponen.map(k => k.kode_komponen).filter(Boolean);
        const formulaVars = extractVariables(data.rumus_tampilan);
        const allVars = Array.from(new Set([...currentVars, ...formulaVars]));

        setSimValues(prev => {
            const next = { ...prev };
            allVars.forEach((v, idx) => {
                if (next[v] === undefined) {
                    // Beri nilai awal yang wajar untuk pengujian (misal 80, 100, dst.)
                    next[v] = idx === 0 ? '85' : idx === 1 ? '100' : '50';
                }
            });
            return next;
        });
    }, [data.komponen, data.rumus_tampilan]);

    // Analisis & Validasi Sintaks Rumus secara Real-time
    const formulaDiagnostics = useMemo(() => {
        const text = data.rumus_tampilan || '';
        const syntaxResult = validateFormulaSyntax(text);
        const usedVars = extractVariables(text);
        const registeredVars = data.komponen.map(k => k.kode_komponen).filter(Boolean);

        const unregisteredVars = usedVars.filter(v => !registeredVars.includes(v));
        const unusedComponents = registeredVars.filter(v => !usedVars.includes(v));

        return {
            isValidSyntax: syntaxResult.isValid,
            syntaxError: syntaxResult.error,
            usedVars,
            registeredVars,
            unregisteredVars,
            unusedComponents
        };
    }, [data.rumus_tampilan, data.komponen]);

    // Hitung total akumulasi bobot
    const totalBobot = useMemo(() => {
        return data.komponen.reduce((acc, k) => {
            const val = Number(String(k.bobot || 0).replace(',', '.'));
            return isNaN(val) ? acc : acc + val;
        }, 0);
    }, [data.komponen]);

    // Hasil Eksekusi Simulasi Real-Time
    const simulationResult = useMemo(() => {
        const text = data.rumus_tampilan;
        if (!text || !text.trim()) {
            return {
                ready: false,
                message: 'Ketik atau susun rumus di atas untuk menjalankan simulasi perhitungan.'
            };
        }

        const evalResult = evaluateFormula(text, simValues);
        if (!evalResult.success) {
            return {
                ready: false,
                error: evalResult.error
            };
        }

        const decimals = Math.max(0, Math.min(Number(data.jumlah_desimal) || 2, 4));
        const realisasiNumber = evalResult.result;
        const formattedRealisasi = realisasiNumber.toLocaleString('id-ID', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });

        const capaianResult = calculateCapaianSimulasi(
            realisasiNumber,
            simTarget,
            data.arah_kinerja,
            data.batas_capaian,
            decimals
        );

        return {
            ready: true,
            realisasi: realisasiNumber,
            formattedRealisasi,
            capaianResult
        };
    }, [data.rumus_tampilan, simValues, simTarget, data.arah_kinerja, data.batas_capaian, data.jumlah_desimal]);

    // Handler untuk menyisipkan teks pada posisi kursor di Textarea rumus
    const insertAtCursor = (textToInsert) => {
        const input = formulaInputRef.current;
        const currentVal = data.rumus_tampilan || '';

        if (input) {
            const start = input.selectionStart ?? currentVal.length;
            const end = input.selectionEnd ?? currentVal.length;
            const updated = currentVal.substring(0, start) + textToInsert + currentVal.substring(end);
            setData('rumus_tampilan', updated);

            setTimeout(() => {
                input.focus();
                const newPos = start + textToInsert.length;
                input.setSelectionRange(newPos, newPos);
            }, 30);
        } else {
            setData('rumus_tampilan', currentVal + textToInsert);
        }
    };

    // Handler untuk menambah komponen variabel baru dengan auto-naming cerdas
    const addKomponen = (suggestedCode = null) => {
        const currentCodes = data.komponen.map(k => k.kode_komponen).filter(Boolean);
        let nextCode = suggestedCode;

        if (!nextCode) {
            // Deteksi penomoran X1, X2, X3...
            let maxIndex = 0;
            currentCodes.forEach(code => {
                const match = code.match(/^X(\d+)$/i);
                if (match) {
                    const num = parseInt(match[1], 10);
                    if (num > maxIndex) maxIndex = num;
                }
            });
            nextCode = `X${maxIndex + 1}`;
        }

        const newUrutan = data.komponen.length + 1;
        setData('komponen', [
            ...data.komponen,
            {
                kode_komponen: nextCode,
                nama_komponen: '',
                tipe_data: 'number',
                bobot: '',
                urutan: newUrutan,
                penjelasan: ''
            }
        ]);
    };

    // Handler perubahan atribut komponen
    const handleKomponenChange = (index, field, value) => {
        const updated = [...data.komponen];
        updated[index] = { ...updated[index], [field]: value };
        setData('komponen', updated);
    };

    // Handler menghapus komponen
    const removeKomponen = (index) => {
        const updated = data.komponen.filter((_, i) => i !== index);
        // Refresh urutan
        const reindexed = updated.map((item, idx) => ({ ...item, urutan: idx + 1 }));
        setData('komponen', reindexed);
    };

    // Handler memindahkan urutan komponen ke atas atau ke bawah
    const moveKomponen = (index, direction) => {
        const targetIndex = index + direction;
        if (targetIndex < 0 || targetIndex >= data.komponen.length) return;

        const list = [...data.komponen];
        const temp = list[index];
        list[index] = list[targetIndex];
        list[targetIndex] = temp;

        const reindexed = list.map((item, idx) => ({ ...item, urutan: idx + 1 }));
        setData('komponen', reindexed);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (isEdit) {
            put(route('admin.rumus.update', formula.id));
        } else {
            post(route('admin.rumus.store'));
        }
    };

    return (
        <AppLayout title={isEdit ? "Edit Konfigurasi Rumus" : "Tambah Formula Indikator"}>
            <Head title={isEdit ? "Edit Rumus Indikator" : "Tambah Rumus Indikator"} />

            {/* Tombol Navigasi Kembali */}
            <Box sx={{ mb: 3 }}>
                <Button 
                    component={Link} 
                    href={route('admin.rumus.index')} 
                    startIcon={<ArrowBackIcon />}
                    variant="outlined"
                    sx={{ 
                        borderRadius: 2.5, 
                        fontWeight: 700, 
                        textTransform: 'none',
                        color: '#475569',
                        borderColor: '#cbd5e1',
                        bgcolor: '#ffffff',
                        '&:hover': { bgcolor: '#f8fafc', borderColor: '#94a3b8' }
                    }}
                >
                    Kembali ke Registry Rumus
                </Button>
            </Box>

            {/* Header Hero Banner */}
            <Paper 
                elevation={0}
                sx={{
                    p: { xs: 3, md: 4 },
                    mb: 3.5,
                    borderRadius: 3.5,
                    background: 'linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #064e3b 100%)',
                    color: '#ffffff',
                    position: 'relative',
                    overflow: 'hidden',
                    border: '1px solid rgba(255,255,255,0.1)'
                }}
            >
                <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1.5, flexWrap: 'wrap', gap: 1 }}>
                    <Chip 
                        label={isEdit ? 'Mode Edit Formula' : 'Pembuatan Formula Baru'} 
                        size="small" 
                        sx={{ 
                            bgcolor: isEdit ? 'rgba(59, 130, 246, 0.25)' : 'rgba(16, 185, 129, 0.25)', 
                            color: isEdit ? '#93c5fd' : '#34d399', 
                            fontWeight: 800, 
                            border: `1px solid ${isEdit ? 'rgba(59, 130, 246, 0.4)' : 'rgba(16, 185, 129, 0.4)'}` 
                        }} 
                    />
                    <Chip 
                        label="Canonical Formula Studio" 
                        size="small" 
                        sx={{ bgcolor: 'rgba(255,255,255,0.12)', color: '#e2e8f0', fontWeight: 600 }} 
                    />
                    {isEdit && (
                        <Chip 
                            label={`Versi Aktif: v${formula?.versi || 1}`} 
                            size="small" 
                            sx={{ bgcolor: 'rgba(255,255,255,0.15)', color: '#f8fafc', fontWeight: 700 }} 
                        />
                    )}
                </Stack>

                <Typography variant="h4" fontWeight={800} sx={{ letterSpacing: -0.5, mb: 1 }}>
                    {isEdit ? "Konfigurasi & Formula Builder Indikator" : "Tambah Definisi Formula Baru"}
                </Typography>
                <Typography variant="body2" sx={{ color: '#94a3b8', maxWidth: 750, lineHeight: 1.6 }}>
                    Bangun model matematis, relasi variabel pembilang/penyebut, komponen input, dan arah kinerja capaian untuk indikator kinerja Kejaksaan RI.
                </Typography>

                {/* Badge Identitas Node yang Terpilih */}
                {selectedNode && (
                    <Paper 
                        elevation={0}
                        sx={{ 
                            mt: 2.5, 
                            p: 2, 
                            borderRadius: 2.5, 
                            bgcolor: 'rgba(255, 255, 255, 0.07)', 
                            backdropFilter: 'blur(10px)',
                            border: '1px solid rgba(255, 255, 255, 0.15)',
                            display: 'flex',
                            alignItems: 'center',
                            gap: 2,
                            flexWrap: 'wrap'
                        }}
                    >
                        <Chip 
                            label={selectedNode.tipe || 'NODE'} 
                            size="small" 
                            sx={{ bgcolor: '#34d399', color: '#064e3b', fontWeight: 800 }} 
                        />
                        <Typography variant="subtitle2" sx={{ color: '#e2e8f0', fontWeight: 700 }}>
                            {selectedNode.kode} — {selectedNode.nama}
                        </Typography>
                    </Paper>
                )}
            </Paper>

            {/* Form Kontainer Utama */}
            <form onSubmit={handleSubmit}>
                <Stack spacing={3.5}>
                    
                    {/* SEKSI 1: Parameter Inti Formula */}
                    <Paper sx={{ p: { xs: 3, md: 3.5 }, borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -2px rgba(15, 23, 42, 0.04)' }}>
                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5, mb: 0.5 }}>
                            <Box sx={{ p: 1, borderRadius: 2, bgcolor: '#eff6ff', color: '#1d4ed8' }}>
                                <TuneIcon fontSize="small" />
                            </Box>
                            <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                                1. Parameter Utama Formula
                            </Typography>
                        </Box>
                        <Typography variant="body2" sx={{ color: '#64748b', mb: 3 }}>
                            Tentukan indikator yang akan diatur, tipe kalkulasi matematis, dan arah kinerja capaian.
                        </Typography>

                        <Grid container spacing={2.5}>
                            {/* Pemilihan Indikator */}
                            <Grid item xs={12} md={7}>
                                <FormControl fullWidth error={!!errors.node_id} size="medium">
                                    <InputLabel>Indikator Sasaran (Node Kinerja)</InputLabel>
                                    <Select
                                        value={data.node_id}
                                        label="Indikator Sasaran (Node Kinerja)"
                                        onChange={e => setData('node_id', e.target.value)}
                                        disabled={isEdit}
                                        sx={{ borderRadius: 2.5 }}
                                    >
                                        {nodes.map(node => (
                                            <MenuItem key={node.id} value={node.id}>
                                                <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                                                    <Chip 
                                                        label={node.tipe} 
                                                        size="small" 
                                                        color={node.tipe === 'IKP' ? 'primary' : 'secondary'} 
                                                        sx={{ fontWeight: 700, height: 20, fontSize: '0.7rem' }} 
                                                    />
                                                    <Typography variant="body2" fontWeight={600}>
                                                        {node.kode} — {node.nama}
                                                    </Typography>
                                                </Box>
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    {errors.node_id && (
                                        <Typography variant="caption" color="error" sx={{ mt: 0.5, ml: 1.5 }}>
                                            {errors.node_id}
                                        </Typography>
                                    )}
                                </FormControl>
                            </Grid>

                            {/* Tipe Formula Matematis */}
                            <Grid item xs={12} md={5}>
                                <FormControl fullWidth error={!!errors.tipe_formula} size="medium">
                                    <InputLabel>Tipe Formula Matematis</InputLabel>
                                    <Select
                                        value={data.tipe_formula}
                                        label="Tipe Formula Matematis"
                                        onChange={e => setData('tipe_formula', e.target.value)}
                                        sx={{ borderRadius: 2.5 }}
                                    >
                                        {FORMULA_TYPE_SPECS.map(type => (
                                            <MenuItem key={type.value} value={type.value}>
                                                <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', width: '100%', py: 0.25 }}>
                                                    <Typography variant="body2" fontWeight={600}>
                                                        {type.value}
                                                    </Typography>
                                                    <Chip 
                                                        label={type.badge} 
                                                        size="small" 
                                                        color={type.badgeColor} 
                                                        variant="outlined" 
                                                        sx={{ height: 20, fontSize: '0.68rem', fontWeight: 700 }} 
                                                    />
                                                </Box>
                                            </MenuItem>
                                        ))}
                                    </Select>
                                </FormControl>
                            </Grid>

                            {/* Kartu Panduan Tipe Formula Terpilih */}
                            <Grid item xs={12}>
                                <Paper 
                                    variant="outlined" 
                                    sx={{ 
                                        p: 2, 
                                        borderRadius: 2.5, 
                                        bgcolor: '#f8fafc', 
                                        borderColor: '#cbd5e1',
                                        display: 'flex',
                                        alignItems: 'flex-start',
                                        gap: 1.5
                                    }}
                                >
                                    <InfoIcon sx={{ color: '#3b82f6', mt: 0.25, fontSize: 20 }} />
                                    <Box sx={{ flex: 1 }}>
                                        <Typography variant="subtitle2" fontWeight={700} sx={{ color: '#0f172a' }}>
                                            Karakteristik Tipe: <Box component="span" sx={{ color: '#2563eb' }}>{activeFormulaSpec.label}</Box>
                                        </Typography>
                                        <Typography variant="body2" sx={{ color: '#475569', mt: 0.25, fontSize: '0.85rem' }}>
                                            {activeFormulaSpec.desc}
                                        </Typography>
                                    </Box>
                                </Paper>
                            </Grid>

                            {/* Arah Kinerja Capaian */}
                            <Grid item xs={12} md={6}>
                                <Typography variant="subtitle2" fontWeight={700} sx={{ color: '#0f172a', mb: 1 }}>
                                    Arah Kinerja Capaian:
                                </Typography>
                                <Grid container spacing={1.5}>
                                    {ARAH_KINERJA_OPTIONS.map(opt => {
                                        const isSelected = data.arah_kinerja === opt.value;
                                        return (
                                            <Grid item xs={12} sm={6} key={opt.value}>
                                                <Paper
                                                    onClick={() => setData('arah_kinerja', opt.value)}
                                                    variant="outlined"
                                                    sx={{
                                                        p: 1.75,
                                                        borderRadius: 2.5,
                                                        cursor: 'pointer',
                                                        transition: 'all 0.2s',
                                                        borderColor: isSelected ? opt.color : '#e2e8f0',
                                                        bgcolor: isSelected ? opt.bgColor : '#ffffff',
                                                        boxShadow: isSelected ? `0 0 0 1px ${opt.color}` : 'none',
                                                        '&:hover': { borderColor: opt.color }
                                                    }}
                                                >
                                                    <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', mb: 0.5 }}>
                                                        <Typography variant="body2" fontWeight={800} sx={{ color: isSelected ? opt.color : '#0f172a' }}>
                                                            {opt.value}
                                                        </Typography>
                                                        {isSelected && <CheckCircleIcon sx={{ fontSize: 18, color: opt.color }} />}
                                                    </Box>
                                                    <Typography variant="caption" sx={{ color: '#64748b', display: 'block', lineHeight: 1.3 }}>
                                                        {opt.desc}
                                                    </Typography>
                                                </Paper>
                                            </Grid>
                                        );
                                    })}
                                </Grid>
                            </Grid>

                            {/* Batas Capaian & Presisi Desimal */}
                            <Grid item xs={12} md={6}>
                                <Typography variant="subtitle2" fontWeight={700} sx={{ color: '#0f172a', mb: 1 }}>
                                    Batasan & Presisi Tampilan:
                                </Typography>
                                <Grid container spacing={2}>
                                    <Grid item xs={12} sm={6}>
                                        <TextField 
                                            fullWidth 
                                            type="number"
                                            label="Batas Maksimum Capaian %" 
                                            value={data.batas_capaian} 
                                            onChange={e => setData('batas_capaian', e.target.value)}
                                            placeholder="Contoh: 120"
                                            helperText="Capping persentase capaian maksimal (kosongkan jika tanpa batas)"
                                            InputProps={{ 
                                                sx: { borderRadius: 2.5 },
                                                endAdornment: <InputAdornment position="end">%</InputAdornment>
                                            }}
                                        />
                                    </Grid>
                                    <Grid item xs={12} sm={6}>
                                        <TextField 
                                            fullWidth 
                                            type="number"
                                            label="Presisi Angka Desimal" 
                                            value={data.jumlah_desimal} 
                                            onChange={e => setData('jumlah_desimal', e.target.value)}
                                            inputProps={{ min: 0, max: 4 }}
                                            helperText="Jumlah digit di belakang koma (0 s.d. 4 angka)"
                                            InputProps={{ sx: { borderRadius: 2.5 } }}
                                        />
                                    </Grid>
                                    <Grid item xs={12}>
                                        <Paper variant="outlined" sx={{ p: 1.5, borderRadius: 2.5, bgcolor: '#f8fafc', display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                                            <Box>
                                                <Typography variant="body2" fontWeight={700} sx={{ color: '#0f172a' }}>
                                                    Status Keaktifan Formula
                                                </Typography>
                                                <Typography variant="caption" sx={{ color: '#64748b' }}>
                                                    Hanya formula aktif yang digunakan pada form pengukuran & laporan triwulan.
                                                </Typography>
                                            </Box>
                                            <FormControlLabel
                                                control={
                                                    <Switch
                                                        checked={data.is_active}
                                                        onChange={e => setData('is_active', e.target.checked)}
                                                        color="success"
                                                    />
                                                }
                                                label={<Chip label={data.is_active ? 'AKTIF' : 'NON-AKTIF'} size="small" color={data.is_active ? 'success' : 'default'} sx={{ fontWeight: 800 }} />}
                                                labelPlacement="start"
                                                sx={{ m: 0 }}
                                            />
                                        </Paper>
                                    </Grid>
                                </Grid>
                            </Grid>
                        </Grid>
                    </Paper>

                    {/* SEKSI 2: Petunjuk Input Pecahan (Pembilang & Penyebut) */}
                    <Paper 
                        sx={{ 
                            p: { xs: 3, md: 3.5 }, 
                            borderRadius: 3, 
                            border: '1px solid',
                            borderColor: activeFormulaSpec.isRatio ? '#a7f3d0' : '#e2e8f0', 
                            bgcolor: activeFormulaSpec.isRatio ? '#f0fdf4' : '#ffffff',
                            boxShadow: '0 4px 20px -2px rgba(15, 23, 42, 0.04)' 
                        }}
                    >
                        <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', mb: 1, flexWrap: 'wrap', gap: 1 }}>
                            <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5 }}>
                                <Box sx={{ p: 1, borderRadius: 2, bgcolor: activeFormulaSpec.isRatio ? '#d1fae5' : '#f1f5f9', color: activeFormulaSpec.isRatio ? '#059669' : '#64748b' }}>
                                    <FunctionsIcon fontSize="small" />
                                </Box>
                                <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                                    2. Label Petunjuk Input Pecahan (Pembilang & Penyebut)
                                </Typography>
                            </Box>
                            {activeFormulaSpec.isRatio ? (
                                <Chip label="Sangat Direkomendasikan untuk Tipe Rasio" size="small" color="success" sx={{ fontWeight: 700 }} />
                            ) : (
                                <Chip label="Opsional untuk Tipe Non-Rasio" size="small" variant="outlined" sx={{ fontWeight: 600, color: '#64748b' }} />
                            )}
                        </Box>
                        <Typography variant="body2" sx={{ color: '#64748b', mb: 3 }}>
                            Memberikan label penjelas pada formulir input pengukuran data triwulan agar pengisi data tidak keliru memasukkan angka.
                        </Typography>

                        <Grid container spacing={2.5}>
                            <Grid item xs={12} md={6}>
                                <TextField 
                                    fullWidth 
                                    label="Label Petunjuk Pembilang (Numerator)" 
                                    value={data.judul_pembilang} 
                                    onChange={e => setData('judul_pembilang', e.target.value)}
                                    placeholder="Contoh: Jumlah ASN yang telah menyelesaikan diklat"
                                    helperText="Akan ditampilkan sebagai judul input angka di bagian atas pecahan"
                                    InputProps={{ 
                                        sx: { bgcolor: '#ffffff', borderRadius: 2.5 },
                                        startAdornment: <InputAdornment position="start"><Chip label="Pembilang (X1)" size="small" sx={{ fontWeight: 700, height: 22 }} /></InputAdornment>
                                    }}
                                />
                            </Grid>
                            <Grid item xs={12} md={6}>
                                <TextField 
                                    fullWidth 
                                    label="Label Petunjuk Penyebut (Denominator)" 
                                    value={data.judul_penyebut} 
                                    onChange={e => setData('judul_penyebut', e.target.value)}
                                    placeholder="Contoh: Total seluruh pegawai yang menjadi target diklat"
                                    helperText="Akan ditampilkan sebagai judul input angka di bagian bawah pecahan"
                                    InputProps={{ 
                                        sx: { bgcolor: '#ffffff', borderRadius: 2.5 },
                                        startAdornment: <InputAdornment position="start"><Chip label="Penyebut (X2)" size="small" sx={{ fontWeight: 700, height: 22 }} /></InputAdornment>
                                    }}
                                />
                            </Grid>
                        </Grid>

                        {/* Preview Visual Representasi Pecahan */}
                        {(data.judul_pembilang || data.judul_penyebut) && (
                            <Box sx={{ mt: 2.5, p: 2, borderRadius: 2.5, bgcolor: '#ffffff', border: '1px dashed #bbf7d0', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                <Box sx={{ textAlign: 'center' }}>
                                    <Typography variant="caption" sx={{ color: '#059669', fontWeight: 800, textTransform: 'uppercase', letterSpacing: 0.5, display: 'block', mb: 0.5 }}>
                                        Preview Tampilan Form Pecahan di Input Data:
                                    </Typography>
                                    <Box sx={{ display: 'inline-flex', flexDirection: 'column', alignItems: 'center' }}>
                                        <Typography variant="body2" fontWeight={700} sx={{ color: '#0f172a', px: 2 }}>
                                            {data.judul_pembilang || '[Belum diisi pembilang]'}
                                        </Typography>
                                        <Box sx={{ width: '100%', height: '2px', bgcolor: '#0f172a', my: 0.5 }} />
                                        <Typography variant="body2" fontWeight={700} sx={{ color: '#0f172a', px: 2 }}>
                                            {data.judul_penyebut || '[Belum diisi penyebut]'}
                                        </Typography>
                                    </Box>
                                    {activeFormulaSpec.isRatio && (
                                        <Typography variant="body2" fontWeight={800} sx={{ color: '#059669', display: 'inline', ml: 1 }}>
                                            × 100%
                                        </Typography>
                                    )}
                                </Box>
                            </Box>
                        )}
                    </Paper>

                    {/* SEKSI 3: Komponen Variabel Rumus (Multi-Variable Builder) */}
                    <Paper sx={{ p: { xs: 3, md: 3.5 }, borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -2px rgba(15, 23, 42, 0.04)' }}>
                        <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', mb: 1, flexWrap: 'wrap', gap: 2 }}>
                            <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5 }}>
                                <Box sx={{ p: 1, borderRadius: 2, bgcolor: '#ecfdf5', color: '#059669' }}>
                                    <CalculateIcon fontSize="small" />
                                </Box>
                                <Box>
                                    <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                                        3. Komponen Variabel Rumus (Multi-Variable Inputs)
                                    </Typography>
                                    <Typography variant="body2" sx={{ color: '#64748b' }}>
                                        Definisikan variabel pembentuk nilai indikator yang akan diisi oleh unit penanggung jawab.
                                    </Typography>
                                </Box>
                            </Box>

                            <Stack direction="row" spacing={1.5} alignItems="center">
                                {totalBobot > 0 && (
                                    <Chip 
                                        label={`Total Bobot: ${(totalBobot * 100).toFixed(0)}% (${totalBobot.toFixed(2)})`} 
                                        color={Math.abs(totalBobot - 1.0) < 0.001 ? 'success' : 'warning'}
                                        variant="filled"
                                        sx={{ fontWeight: 800 }}
                                    />
                                )}
                                <Button 
                                    variant="contained" 
                                    startIcon={<AddIcon />} 
                                    onClick={() => addKomponen()}
                                    sx={{ 
                                        borderRadius: 2.5, 
                                        fontWeight: 700, 
                                        textTransform: 'none',
                                        bgcolor: '#059669',
                                        background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)'
                                    }}
                                >
                                    Tambah Variabel Baru
                                </Button>
                            </Stack>
                        </Box>

                        {/* Indikator Akumulasi Bobot */}
                        {totalBobot > 0 && (
                            <Box sx={{ my: 2, p: 1.5, borderRadius: 2, bgcolor: '#f8fafc', border: '1px solid #e2e8f0' }}>
                                <Box sx={{ display: 'flex', justifyContent: 'space-between', mb: 0.5 }}>
                                    <Typography variant="caption" fontWeight={700} sx={{ color: '#475569' }}>
                                        Keseimbangan Akumulasi Bobot Komponen:
                                    </Typography>
                                    <Typography variant="caption" fontWeight={800} sx={{ color: Math.abs(totalBobot - 1.0) < 0.001 ? '#059669' : '#d97706' }}>
                                        {Math.abs(totalBobot - 1.0) < 0.001 ? '✓ Bobot Pas 1.0 (100%)' : `⚠ Total saat ini ${(totalBobot * 100).toFixed(0)}% (Harus 100% jika komposit berbobot)`}
                                    </Typography>
                                </Box>
                                <LinearProgress 
                                    variant="determinate" 
                                    value={Math.min(totalBobot * 100, 100)} 
                                    color={Math.abs(totalBobot - 1.0) < 0.001 ? 'success' : totalBobot > 1.0 ? 'error' : 'warning'} 
                                    sx={{ height: 6, borderRadius: 3 }}
                                />
                            </Box>
                        )}

                        {/* Daftar Komponen Variabel */}
                        {data.komponen.length === 0 ? (
                            <Paper 
                                variant="outlined" 
                                sx={{ 
                                    p: 4, 
                                    my: 2, 
                                    textAlign: 'center', 
                                    borderRadius: 3, 
                                    borderStyle: 'dashed', 
                                    borderColor: '#cbd5e1', 
                                    bgcolor: '#f8fafc' 
                                }}
                            >
                                <FunctionsIcon sx={{ fontSize: 44, color: '#94a3b8', mb: 1 }} />
                                <Typography variant="subtitle1" fontWeight={700} sx={{ color: '#1e293b' }}>
                                    Belum Ada Komponen Variabel Terdaftar
                                </Typography>
                                <Typography variant="body2" sx={{ color: '#64748b', maxWidth: 500, mx: 'auto', mt: 0.5, mb: 2 }}>
                                    Klik tombol di bawah untuk menambahkan variabel seperti <code>X1</code> (Pembilang) dan <code>X2</code> (Penyebut) atau variabel multi-komponen lainnya.
                                </Typography>
                                <Button 
                                    variant="outlined" 
                                    startIcon={<AddIcon />} 
                                    onClick={() => addKomponen('X1')}
                                    sx={{ borderRadius: 2.5, fontWeight: 700, textTransform: 'none' }}
                                >
                                    Tambah Variabel Pertama (X1)
                                </Button>
                            </Paper>
                        ) : (
                            <Stack spacing={2} sx={{ mt: 2.5 }}>
                                {data.komponen.map((komp, index) => (
                                    <Paper 
                                        key={index} 
                                        variant="outlined" 
                                        sx={{ 
                                            p: 2.5, 
                                            borderRadius: 2.5, 
                                            bgcolor: '#ffffff', 
                                            borderColor: '#e2e8f0',
                                            boxShadow: '0 2px 8px rgba(15, 23, 42, 0.03)',
                                            transition: 'border-color 0.2s',
                                            '&:hover': { borderColor: '#cbd5e1' }
                                        }}
                                    >
                                        {/* Header Bar Komponen */}
                                        <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', mb: 2, pb: 1.5, borderBottom: '1px solid #f1f5f9' }}>
                                            <Stack direction="row" spacing={1} alignItems="center">
                                                <Chip 
                                                    label={komp.kode_komponen || `Var ${index + 1}`} 
                                                    size="small" 
                                                    sx={{ 
                                                        bgcolor: '#0f172a', 
                                                        color: '#ffffff', 
                                                        fontWeight: 800, 
                                                        fontFamily: 'monospace',
                                                        letterSpacing: 0.5
                                                    }} 
                                                />
                                                <Typography variant="subtitle2" fontWeight={700} sx={{ color: '#1e293b' }}>
                                                    {komp.nama_komponen ? komp.nama_komponen : `Variabel #${index + 1}`}
                                                </Typography>
                                                {komp.bobot && (
                                                    <Chip 
                                                        label={`Bobot: ${(Number(komp.bobot) * 100).toFixed(0)}%`} 
                                                        size="small" 
                                                        sx={{ bgcolor: '#ecfdf5', color: '#059669', fontWeight: 700, height: 22 }} 
                                                    />
                                                )}
                                            </Stack>

                                            <Stack direction="row" spacing={0.5} alignItems="center">
                                                {/* Tombol Sisipkan Cepat ke Formula */}
                                                <Tooltip title="Sisipkan kode variabel ini ke dalam teks rumus di bawah">
                                                    <Button 
                                                        size="small" 
                                                        variant="text" 
                                                        startIcon={<CopyIcon fontSize="small" />}
                                                        onClick={() => insertAtCursor(komp.kode_komponen || `X${index + 1}`)}
                                                        sx={{ textTransform: 'none', fontWeight: 700, color: '#2563eb', py: 0.25 }}
                                                    >
                                                        Sisipkan ke Rumus
                                                    </Button>
                                                </Tooltip>

                                                {/* Pindah Posisi Naik / Turun */}
                                                <IconButton 
                                                    size="small" 
                                                    disabled={index === 0} 
                                                    onClick={() => moveKomponen(index, -1)}
                                                    sx={{ color: '#64748b' }}
                                                >
                                                    <ArrowUpwardIcon fontSize="small" />
                                                </IconButton>
                                                <IconButton 
                                                    size="small" 
                                                    disabled={index === data.komponen.length - 1} 
                                                    onClick={() => moveKomponen(index, 1)}
                                                    sx={{ color: '#64748b' }}
                                                >
                                                    <ArrowDownwardIcon fontSize="small" />
                                                </IconButton>

                                                {/* Hapus Komponen */}
                                                <IconButton 
                                                    size="small" 
                                                    color="error"
                                                    onClick={() => removeKomponen(index)}
                                                    sx={{ bgcolor: '#fef2f2', '&:hover': { bgcolor: '#fee2e2' } }}
                                                >
                                                    <DeleteIcon fontSize="small" />
                                                </IconButton>
                                            </Stack>
                                        </Box>

                                        {/* Input Data Komponen */}
                                        <Grid container spacing={2}>
                                            <Grid item xs={12} sm={6} md={3}>
                                                <TextField 
                                                    fullWidth 
                                                    label="Kode Variabel" 
                                                    value={komp.kode_komponen} 
                                                    onChange={e => handleKomponenChange(index, 'kode_komponen', e.target.value.replace(/\s+/g, '_'))}
                                                    placeholder="Contoh: X1, X2"
                                                    size="small"
                                                    required
                                                    helperText="Hanya huruf, angka, underscore"
                                                    InputProps={{ 
                                                        sx: { borderRadius: 2, fontFamily: 'monospace', fontWeight: 700 } 
                                                    }}
                                                />
                                            </Grid>

                                            <Grid item xs={12} sm={6} md={4}>
                                                <TextField 
                                                    fullWidth 
                                                    label="Nama Label Komponen" 
                                                    value={komp.nama_komponen} 
                                                    onChange={e => handleKomponenChange(index, 'nama_komponen', e.target.value)}
                                                    placeholder="Contoh: Realisasi Anggaran Belanja"
                                                    size="small"
                                                    required
                                                    helperText="Label yang tampil pada form input data"
                                                    InputProps={{ sx: { borderRadius: 2 } }}
                                                />
                                            </Grid>

                                            <Grid item xs={6} sm={6} md={2.5}>
                                                <FormControl fullWidth size="small">
                                                    <InputLabel>Tipe Data</InputLabel>
                                                    <Select
                                                        value={komp.tipe_data || 'number'}
                                                        label="Tipe Data"
                                                        onChange={e => handleKomponenChange(index, 'tipe_data', e.target.value)}
                                                        sx={{ borderRadius: 2 }}
                                                    >
                                                        <MenuItem value="number">Number (Angka)</MenuItem>
                                                        <MenuItem value="text">Text (Teks)</MenuItem>
                                                        <MenuItem value="boolean">Boolean (Ya / Tidak)</MenuItem>
                                                    </Select>
                                                </FormControl>
                                            </Grid>

                                            <Grid item xs={6} sm={6} md={2.5}>
                                                <TextField 
                                                    fullWidth 
                                                    type="number"
                                                    label="Bobot (0 s.d. 1)" 
                                                    value={komp.bobot} 
                                                    onChange={e => handleKomponenChange(index, 'bobot', e.target.value)}
                                                    size="small"
                                                    inputProps={{ min: 0, max: 1, step: 0.05 }}
                                                    helperText={komp.bobot ? `Setara ${(Number(komp.bobot) * 100).toFixed(0)}%` : 'Opsional (0 - 1.0)'}
                                                    InputProps={{ sx: { borderRadius: 2 } }}
                                                />
                                            </Grid>

                                            <Grid item xs={12}>
                                                <TextField 
                                                    fullWidth 
                                                    label="Petunjuk / Penjelasan Komponen bagi Penginput" 
                                                    value={komp.penjelasan || ''} 
                                                    onChange={e => handleKomponenChange(index, 'penjelasan', e.target.value)}
                                                    placeholder="Contoh: Masukkan total nominal realisasi belanja pegawai yang bersumber dari OM-SPAN"
                                                    size="small"
                                                    helperText="Panduan operasional pengisian bagi operator satuan kerja"
                                                    InputProps={{ sx: { borderRadius: 2 } }}
                                                />
                                            </Grid>
                                        </Grid>
                                    </Paper>
                                ))}
                            </Stack>
                        )}
                    </Paper>

                    {/* SEKSI 4: Interactive Formula Builder (Notasi Formula) */}
                    <Paper sx={{ p: { xs: 3, md: 3.5 }, borderRadius: 3, border: '1px solid #e2e8f0', boxShadow: '0 4px 20px -2px rgba(15, 23, 42, 0.04)' }}>
                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5, mb: 1 }}>
                            <Box sx={{ p: 1, borderRadius: 2, bgcolor: '#fdf4ff', color: '#a855f7' }}>
                                <AutoFixHighIcon fontSize="small" />
                            </Box>
                            <Box>
                                <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                                    4. Notasi & Studio Formula Matematis
                                </Typography>
                                <Typography variant="body2" sx={{ color: '#64748b' }}>
                                    Tuliskan ekspresi matematika untuk menghitung realisasi indikator dari variabel yang sudah didefinisikan.
                                </Typography>
                            </Box>
                        </Box>

                        {/* Interactive Toolbar: Variabel & Operator Cepat */}
                        <Paper 
                            variant="outlined" 
                            sx={{ 
                                p: 2, 
                                mt: 2.5, 
                                mb: 2, 
                                borderRadius: 2.5, 
                                bgcolor: '#f8fafc', 
                                borderColor: '#e2e8f0' 
                            }}
                        >
                            {/* Toolbar Baris 1: Tombol Sisipkan Variabel Terdaftar */}
                            <Box sx={{ mb: 1.5 }}>
                                <Typography variant="caption" fontWeight={800} sx={{ color: '#475569', textTransform: 'uppercase', letterSpacing: 0.5, display: 'block', mb: 1 }}>
                                    Sisipkan Variabel Terdaftar (Klik untuk menyisipkan ke kursor):
                                </Typography>
                                {data.komponen.length === 0 ? (
                                    <Typography variant="caption" sx={{ color: '#94a3b8', fontStyle: 'italic' }}>
                                        Belum ada variabel di Seksi 3. Tambahkan variabel di atas agar tombol muncul di sini.
                                    </Typography>
                                ) : (
                                    <Stack direction="row" spacing={1} flexWrap="wrap" useFlexGap>
                                        {data.komponen.map((komp, idx) => (
                                            <Chip 
                                                key={idx}
                                                label={`+ ${komp.kode_komponen || `X${idx + 1}`}`} 
                                                onClick={() => insertAtCursor(komp.kode_komponen || `X${idx + 1}`)}
                                                clickable
                                                sx={{ 
                                                    fontWeight: 800, 
                                                    fontFamily: 'monospace',
                                                    bgcolor: '#ffffff', 
                                                    borderColor: '#3b82f6', 
                                                    color: '#1d4ed8',
                                                    border: '1px solid #bfdbfe',
                                                    '&:hover': { bgcolor: '#eff6ff', borderColor: '#2563eb' }
                                                }} 
                                            />
                                        ))}
                                    </Stack>
                                )}
                            </Box>

                            {/* Toolbar Baris 2: Operator Matematika Cepat */}
                            <Box sx={{ mb: 1.5 }}>
                                <Typography variant="caption" fontWeight={800} sx={{ color: '#475569', textTransform: 'uppercase', letterSpacing: 0.5, display: 'block', mb: 1 }}>
                                    Operator Aritmatika:
                                </Typography>
                                <Stack direction="row" spacing={1} flexWrap="wrap" useFlexGap>
                                    {MATH_OPERATORS.map((op, idx) => (
                                        <Button
                                            key={idx}
                                            variant="outlined"
                                            size="small"
                                            onClick={() => insertAtCursor(op.value)}
                                            title={op.title}
                                            sx={{ 
                                                minWidth: 42, 
                                                fontWeight: 800, 
                                                fontSize: '0.95rem',
                                                bgcolor: '#ffffff',
                                                borderColor: '#cbd5e1',
                                                color: '#1e293b',
                                                borderRadius: 2,
                                                '&:hover': { bgcolor: '#f1f5f9', borderColor: '#94a3b8' }
                                            }}
                                        >
                                            {op.label}
                                        </Button>
                                    ))}
                                </Stack>
                            </Box>

                            {/* Toolbar Baris 3: Template Rumus Populer */}
                            <Box>
                                <Typography variant="caption" fontWeight={800} sx={{ color: '#475569', textTransform: 'uppercase', letterSpacing: 0.5, display: 'block', mb: 1 }}>
                                    Template Formula Standar:
                                </Typography>
                                <Stack direction="row" spacing={1} flexWrap="wrap" useFlexGap>
                                    {FORMULA_PRESETS.map((preset, idx) => (
                                        <Chip 
                                            key={idx}
                                            label={preset.label}
                                            onClick={() => setData('rumus_tampilan', preset.formula)}
                                            clickable
                                            variant="outlined"
                                            size="small"
                                            sx={{ 
                                                borderRadius: 2, 
                                                bgcolor: '#ffffff', 
                                                borderColor: '#e2e8f0', 
                                                fontWeight: 600,
                                                '&:hover': { bgcolor: '#f8fafc', borderColor: '#94a3b8' } 
                                            }}
                                        />
                                    ))}
                                </Stack>
                            </Box>
                        </Paper>

                        {/* Input Teks Rumus Tampilan Utama */}
                        <TextField 
                            fullWidth 
                            multiline
                            rows={3}
                            label="Rumus Tampilan / Notasi Formula" 
                            value={data.rumus_tampilan} 
                            onChange={e => setData('rumus_tampilan', e.target.value)}
                            inputRef={formulaInputRef}
                            placeholder="Contoh: (X1 / X2) * 100 atau (X1 * 0.4) + (X2 * 0.6)"
                            error={!formulaDiagnostics.isValidSyntax || !!errors.rumus_tampilan}
                            helperText={errors.rumus_tampilan || formulaDiagnostics.syntaxError || "Gunakan variabel yang terdaftar di Seksi 3 dan operator matematika standar."}
                            InputProps={{ 
                                sx: { 
                                    borderRadius: 2.5, 
                                    fontFamily: 'monospace', 
                                    fontSize: '1.05rem', 
                                    fontWeight: 700,
                                    letterSpacing: 0.5,
                                    bgcolor: '#ffffff'
                                } 
                            }}
                        />

                        {/* Peringatan & Umpan Balik Diagnostik Validasi Rumus */}
                        <Stack spacing={1.5} sx={{ mt: 2 }}>
                            {/* Warning: Variabel di rumus belum ada di komponen */}
                            {formulaDiagnostics.unregisteredVars.length > 0 && (
                                <Alert 
                                    severity="warning" 
                                    sx={{ borderRadius: 2.5 }}
                                    action={
                                        <Button 
                                            color="inherit" 
                                            size="small" 
                                            onClick={() => addKomponen(formulaDiagnostics.unregisteredVars[0])}
                                            sx={{ fontWeight: 800, textTransform: 'none' }}
                                        >
                                            + Daftarkan "{formulaDiagnostics.unregisteredVars[0]}"
                                        </Button>
                                    }
                                >
                                    <AlertTitle sx={{ fontWeight: 800 }}>Variabel Belum Terdaftar Sebagai Komponen</AlertTitle>
                                    Variabel <strong>{formulaDiagnostics.unregisteredVars.join(', ')}</strong> tertulis pada rumus, namun belum ditambahkan pada daftar Komponen di Seksi 3.
                                </Alert>
                            )}

                            {/* Info: Komponen belum dipakai di rumus */}
                            {formulaDiagnostics.unusedComponents.length > 0 && (
                                <Alert severity="info" variant="outlined" sx={{ borderRadius: 2.5 }}>
                                    <Typography variant="body2" sx={{ fontSize: '0.85rem' }}>
                                        Variabel komponen <strong>{formulaDiagnostics.unusedComponents.join(', ')}</strong> sudah didefinisikan, tetapi belum digunakan dalam notasi rumus di atas.
                                    </Typography>
                                </Alert>
                            )}

                            {/* Sukses: Validasi Sintaks Baik */}
                            {formulaDiagnostics.isValidSyntax && formulaDiagnostics.unregisteredVars.length === 0 && data.rumus_tampilan.trim() !== '' && (
                                <Box sx={{ p: 1.5, borderRadius: 2, bgcolor: '#f0fdf4', border: '1px solid #bbf7d0', display: 'flex', alignItems: 'center', gap: 1 }}>
                                    <CheckCircleIcon sx={{ color: '#059669', fontSize: 18 }} />
                                    <Typography variant="body2" sx={{ color: '#065f46', fontWeight: 700 }}>
                                        Sintaks rumus valid: menggunakan variabel [{formulaDiagnostics.usedVars.join(', ')}]
                                    </Typography>
                                </Box>
                            )}
                        </Stack>
                    </Paper>

                    {/* SEKSI 5: Interactive Formula Simulator & Live Tester */}
                    <Paper 
                        sx={{ 
                            p: { xs: 3, md: 3.5 }, 
                            borderRadius: 3, 
                            border: '1px solid #cbd5e1', 
                            boxShadow: '0 8px 30px -4px rgba(15, 23, 42, 0.06)',
                            bgcolor: '#ffffff'
                        }}
                    >
                        <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', mb: 1, flexWrap: 'wrap', gap: 1 }}>
                            <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5 }}>
                                <Box sx={{ p: 1, borderRadius: 2, bgcolor: '#e0e7ff', color: '#4338ca' }}>
                                    <ScienceIcon fontSize="small" />
                                </Box>
                                <Box>
                                    <Typography variant="h6" fontWeight={800} sx={{ color: '#0f172a' }}>
                                        5. Simulator & Pengujian Rumus Real-Time (Live Sandbox)
                                    </Typography>
                                    <Typography variant="body2" sx={{ color: '#64748b' }}>
                                        Uji coba langsung rumus yang Anda buat dengan angka uji coba untuk memastikan kalkulasi realisasi dan capaian target sudah tepat.
                                    </Typography>
                                </Box>
                            </Box>

                            <Button 
                                size="small" 
                                variant="outlined" 
                                onClick={() => setShowSimulator(!showSimulator)}
                                sx={{ borderRadius: 2, textTransform: 'none', fontWeight: 700 }}
                            >
                                {showSimulator ? 'Sembunyikan Simulator' : 'Buka Simulator'}
                            </Button>
                        </Box>

                        <Collapse in={showSimulator}>
                            <Divider sx={{ my: 2.5 }} />

                            <Grid container spacing={3}>
                                {/* Kolom Kiri: Input Nilai Dummy Pengujian */}
                                <Grid item xs={12} md={6}>
                                    <Typography variant="subtitle2" fontWeight={800} sx={{ color: '#1e293b', mb: 1.5 }}>
                                        Masukkan Angka Uji Coba Variabel:
                                    </Typography>

                                    <Stack spacing={1.5}>
                                        {/* Input Target Uji Coba */}
                                        <TextField 
                                            fullWidth 
                                            size="small"
                                            label="Target Uji Coba" 
                                            value={simTarget} 
                                            onChange={e => setSimTarget(e.target.value)}
                                            InputProps={{ 
                                                sx: { borderRadius: 2, bgcolor: '#f8fafc', fontWeight: 700 },
                                                startAdornment: <InputAdornment position="start"><Chip label="TARGET" size="small" color="primary" sx={{ fontWeight: 800, height: 20 }} /></InputAdornment>
                                            }}
                                        />

                                        {/* Input Variabel yang Digunakan di Rumus */}
                                        {formulaDiagnostics.usedVars.length === 0 ? (
                                            <Typography variant="body2" sx={{ color: '#94a3b8', fontStyle: 'italic', py: 1 }}>
                                                Belum ada variabel dalam rumus. Masukkan rumus di atas terlebih dahulu.
                                            </Typography>
                                        ) : (
                                            formulaDiagnostics.usedVars.map((vName, idx) => {
                                                const matchedKomp = data.komponen.find(k => k.kode_komponen === vName);
                                                return (
                                                    <TextField 
                                                        key={idx}
                                                        fullWidth 
                                                        size="small"
                                                        label={`Nilai Uji Coba ${vName} ${matchedKomp?.nama_komponen ? `(${matchedKomp.nama_komponen})` : ''}`}
                                                        value={simValues[vName] ?? ''} 
                                                        onChange={e => setSimValues({ ...simValues, [vName]: e.target.value })}
                                                        InputProps={{ 
                                                            sx: { borderRadius: 2, bgcolor: '#ffffff', fontWeight: 700 },
                                                            startAdornment: <InputAdornment position="start"><Chip label={vName} size="small" sx={{ fontWeight: 800, height: 20, bgcolor: '#0f172a', color: '#ffffff' }} /></InputAdornment>
                                                        }}
                                                    />
                                                );
                                            })
                                        )}
                                    </Stack>
                                </Grid>

                                {/* Kolom Kanan: Hasil Kalkulasi Real-Time */}
                                <Grid item xs={12} md={6}>
                                    <Typography variant="subtitle2" fontWeight={800} sx={{ color: '#1e293b', mb: 1.5 }}>
                                        Hasil Simulasi Real-Time:
                                    </Typography>

                                    {simulationResult.ready ? (
                                        <Paper 
                                            elevation={0}
                                            sx={{ 
                                                p: 2.5, 
                                                borderRadius: 2.5, 
                                                bgcolor: '#f8fafc', 
                                                border: '1px solid #cbd5e1' 
                                            }}
                                        >
                                            <Grid container spacing={2}>
                                                {/* Output Realisasi */}
                                                <Grid item xs={6}>
                                                    <Typography variant="caption" fontWeight={700} sx={{ color: '#64748b', textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                                        Realisasi Hitung:
                                                    </Typography>
                                                    <Typography variant="h4" fontWeight={800} sx={{ color: '#0f172a', mt: 0.5 }}>
                                                        {simulationResult.formattedRealisasi}
                                                    </Typography>
                                                    <Typography variant="caption" sx={{ color: '#94a3b8' }}>
                                                        Sesuai format {data.jumlah_desimal} desimal
                                                    </Typography>
                                                </Grid>

                                                {/* Output Capaian */}
                                                <Grid item xs={6}>
                                                    <Typography variant="caption" fontWeight={700} sx={{ color: '#64748b', textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                                        Capaian Target:
                                                    </Typography>
                                                    <Typography variant="h4" fontWeight={800} sx={{ color: simulationResult.capaianResult.color, mt: 0.5 }}>
                                                        {simulationResult.capaianResult.formatted}
                                                    </Typography>
                                                    <Chip 
                                                        label={simulationResult.capaianResult.status} 
                                                        size="small" 
                                                        sx={{ 
                                                            mt: 0.5, 
                                                            fontWeight: 700, 
                                                            bgcolor: '#ffffff', 
                                                            border: `1px solid ${simulationResult.capaianResult.color}`,
                                                            color: simulationResult.capaianResult.color
                                                        }} 
                                                    />
                                                </Grid>

                                                <Grid item xs={12}>
                                                    <Divider sx={{ my: 1 }} />
                                                    <Typography variant="caption" sx={{ color: '#475569', display: 'block' }}>
                                                        <strong>Logika Evaluasi:</strong> Arah kinerja <strong>{data.arah_kinerja}</strong>
                                                        {data.batas_capaian ? `, dibatasi maksimal ${data.batas_capaian}%` : ', tanpa capping batas'}.
                                                    </Typography>
                                                </Grid>
                                            </Grid>
                                        </Paper>
                                    ) : (
                                        <Alert severity={simulationResult.error ? 'error' : 'info'} sx={{ borderRadius: 2.5 }}>
                                            {simulationResult.error || simulationResult.message}
                                        </Alert>
                                    )}
                                </Grid>
                            </Grid>
                        </Collapse>
                    </Paper>

                    {/* SEKSI 6: Action Footer Bar (Batal & Simpan) */}
                    <Paper 
                        elevation={0}
                        sx={{ 
                            p: 2.5, 
                            borderRadius: 3, 
                            bgcolor: '#f8fafc', 
                            border: '1px solid #e2e8f0',
                            display: 'flex',
                            justifyContent: 'space-between',
                            alignItems: 'center',
                            flexWrap: 'wrap',
                            gap: 2
                        }}
                    >
                        <Typography variant="body2" sx={{ color: '#64748b' }}>
                            Pastikan notasi formula dan daftar variabel sudah sesuai dengan Kepja 1184 Tahun 2025 sebelum menyimpan.
                        </Typography>

                        <Stack direction="row" spacing={2}>
                            <Button 
                                component={Link} 
                                href={route('admin.rumus.index')} 
                                variant="outlined"
                                sx={{ 
                                    borderRadius: 2.5, 
                                    fontWeight: 700, 
                                    textTransform: 'none', 
                                    px: 3,
                                    borderColor: '#cbd5e1',
                                    color: '#475569',
                                    '&:hover': { borderColor: '#94a3b8', bgcolor: '#ffffff' }
                                }}
                            >
                                Batal
                            </Button>
                            
                            <Button 
                                type="submit" 
                                variant="contained" 
                                disabled={processing || !formulaDiagnostics.isValidSyntax}
                                startIcon={<SaveIcon />}
                                sx={{
                                    bgcolor: '#059669',
                                    color: '#ffffff',
                                    background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                                    borderRadius: 2.5,
                                    fontWeight: 800,
                                    px: 4,
                                    py: 1.2,
                                    boxShadow: '0 4px 14px rgba(5, 150, 105, 0.35)',
                                    '&:hover': {
                                        background: 'linear-gradient(135deg, #047857 0%, #059669 100%)',
                                    }
                                }}
                            >
                                {processing ? 'Menyimpan...' : isEdit ? 'Perbarui Formula Indikator' : 'Simpan Formula Baru'}
                            </Button>
                        </Stack>
                    </Paper>

                </Stack>
            </form>
        </AppLayout>
    );
}
