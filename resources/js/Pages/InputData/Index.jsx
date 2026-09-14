import { useEffect, useMemo, useState } from 'react';
import { Head, router, usePage } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import {
    Alert,
    Box,
    Button,
    Card,
    CardContent,
    Chip,
    CircularProgress,
    Collapse,
    Divider,
    FormControl,
    Grid,
    IconButton,
    InputAdornment,
    InputLabel,
    MenuItem,
    Paper,
    Select,
    Snackbar,
    Stack,
    Tab,
    Tabs,
    TextField,
    Tooltip,
    Typography,
} from '@mui/material';
import {
    CalculateOutlined as CalculateIcon,
    InfoOutlined as InfoIcon,
    Save as SaveIcon,
    CheckCircle as CheckCircleIcon,
    WarningAmber as WarningIcon,
    Error as ErrorIcon,
    FormatListBulleted as ListIcon,
    Functions as FunctionsIcon,
    AssignmentOutlined as AssignmentIcon,
    ExpandMore as ExpandMoreIcon,
    ExpandLess as ExpandLessIcon,
    UnfoldMore as UnfoldMoreIcon,
    UnfoldLess as UnfoldLessIcon,
    FolderSpecial as FolderSpecialIcon,
    AccountTree as TreeIcon,
    Search as SearchIcon,
} from '@mui/icons-material';
import { motion } from 'framer-motion';

const calculationLabel = {
    DIRECT_VALUE: 'Nilai Langsung',
    EXTERNAL_SCORE: 'Nilai Eksternal',
    RATIO: 'Rasio (Pembilang / Penyebut)',
    AVERAGE: 'Rata-rata Komponen',
    SUM: 'Penjumlahan Komponen',
    WEIGHTED_SUM: 'Komposit Berbobot',
    COUNT: 'Jumlah / Hitungan',
    SURVEY_INDEX: 'Indeks Survei',
    CUSTOM: 'Formula Khusus',
    DOCUMENTED: 'Formula Dokumen',
};

function formatCleanNumber(val, maxDecimals = 3) {
    if (val === null || val === undefined || val === '') return '';
    const num = Number(typeof val === 'string' ? val.replace(',', '.') : val);
    if (isNaN(num)) return String(val);
    return parseFloat(num.toFixed(maxDecimals)).toString();
}

function isValidDecimalInput(str) {
    if (str === '' || str === '-') return true;
    return /^-?\d*[.,]?\d*$/.test(str);
}

function measurementInputs(pengukuran) {
    return (pengukuran?.inputs || []).reduce((acc, item) => {
        acc[item.input_key] = formatCleanNumber(item.nilai);
        return acc;
    }, {});
}

function formulaFor(entity) {
    return entity?.node?.formulas?.find((formula) => formula.is_active !== false)
        || entity?.node?.formulas?.[0]
        || null;
}

function componentsFor(entity) {
    return formulaFor(entity)?.components || [];
}

function InputHelp({ entity }) {
    const formula = formulaFor(entity);
    if (!formula?.rumus_tampilan && !formula?.status_formula) return null;

    return (
        <Paper
            variant="outlined"
            sx={{
                p: 2,
                mb: 2.5,
                borderRadius: 2,
                bgcolor: '#f0fdf4',
                borderColor: '#bbf7d0',
                display: 'flex',
                gap: 1.5,
                alignItems: 'flex-start'
            }}
        >
            <FunctionsIcon sx={{ color: '#059669', mt: 0.25, fontSize: 20 }} />
            <Box>
                {formula.rumus_tampilan && (
                    <Typography variant="body2" sx={{ color: '#065f46', fontWeight: 700 }}>
                        Formula Perhitungan: <Box component="code" sx={{ px: 1, py: 0.25, bgcolor: '#ffffff', border: '1px solid #a7f3d0', borderRadius: 1, fontFamily: 'monospace', fontWeight: 600 }}>{formula.rumus_tampilan}</Box>
                    </Typography>
                )}
                {formula.status_formula && (
                    <Typography variant="caption" sx={{ color: '#047857', display: 'block', mt: 0.5 }}>
                        {formula.status_formula}
                    </Typography>
                )}
            </Box>
        </Paper>
    );
}

function FormulaFields({ entity, value, onChange }) {
    const node = entity?.node || {};
    const schema = entity?.input_schema;
    const inputs = value.inputs || {};
    const formula = formulaFor(entity);
    const components = componentsFor(entity);

    const handleDecimalChange = (setter) => (e) => {
        const inputStr = e.target.value;
        if (isValidDecimalInput(inputStr)) {
            setter(inputStr);
        }
    };

    const updateInput = (key, inputValue) => {
        onChange('inputs', { ...inputs, [key]: inputValue });
    };

    // Specific descriptive texts for pembilang and penyebut from formula or components
    const pembilangDesc = formula?.judul_pembilang
        || components.find(c => ['pembilang', 's', 'x1_pembilang'].includes((c.kode_komponen || '').toLowerCase()))?.penjelasan
        || 'Nilai capaian aktual riil yang diperoleh';

    const penyebutDesc = formula?.judul_penyebut
        || components.find(c => ['penyebut', 't', 'x2_penyebut'].includes((c.kode_komponen || '').toLowerCase()))?.penjelasan
        || 'Total target / populasi keseluruhan';

    if (schema?.fields && schema.fields.length > 0) {
        return (
            <Paper variant="outlined" sx={{ p: 2.5, borderRadius: 2.5, bgcolor: '#ffffff', mb: 2.5, border: '1px solid #e2e8f0' }}>
                <Typography variant="caption" sx={{ color: '#475569', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5, mb: 1.5, display: 'block' }}>
                    Variabel Input Formula
                </Typography>
                <Grid container spacing={2}>
                    {schema.fields.map((field) => {
                        let fieldVal = '';
                        let fieldChange = null;

                        const keyLower = (field.key || '').toLowerCase();
                        const isPembilang = keyLower === 'pembilang' || ['s', 'x1_pembilang', 'pembilang'].includes(keyLower) || keyLower.includes('terdigitalisasi') || keyLower.includes('dimanfaatkan') || keyLower.includes('bersertifikat') || (keyLower.includes('skor') && keyLower.includes('aktual'));
                        const isPenyebut = keyLower === 'penyebut' || ['t', 'x2_penyebut', 'penyebut'].includes(keyLower) || keyLower.startsWith('total_') || keyLower.includes('maksimal') || keyLower.includes('ideal');
                        const isRealisasi = keyLower === 'realisasi';

                        if (field.key === 'pembilang') {
                            fieldVal = value.pembilang ?? '';
                            fieldChange = handleDecimalChange((val) => onChange('pembilang', val));
                        } else if (field.key === 'penyebut') {
                            fieldVal = value.penyebut ?? '';
                            fieldChange = handleDecimalChange((val) => onChange('penyebut', val));
                        } else if (field.key === 'realisasi') {
                            fieldVal = value.realisasi ?? '';
                            fieldChange = handleDecimalChange((val) => onChange('realisasi', val));
                        } else {
                            fieldVal = inputs[field.key] ?? '';
                            fieldChange = handleDecimalChange((val) => updateInput(field.key, val));
                        }

                        const numFields = schema.fields.length;
                        const colMd = numFields === 1 ? 12 : numFields === 2 ? 6 : numFields <= 4 ? 6 : 4;

                        const descText = field.description
                            || field.help_text
                            || (field.key === 'pembilang' ? pembilangDesc : (field.key === 'penyebut' ? penyebutDesc : ''))
                            || field.label;

                        const fieldPlaceholder = field.placeholder
                            || (field.key === 'pembilang' ? pembilangDesc : (field.key === 'penyebut' ? penyebutDesc : null))
                            || `Contoh: Masukkan ${field.label.toLowerCase()}...`;

                        const roleLabel = field.key === 'pembilang' || isPembilang 
                            ? 'Pembilang: ' 
                            : (field.key === 'penyebut' || isPenyebut 
                                ? 'Penyebut: ' 
                                : (isRealisasi ? 'Realisasi: ' : 'Komponen: '));

                        const boxBg = isPembilang ? '#f0fdf4' : (isPenyebut ? '#eff6ff' : '#f8fafc');
                        const boxBorder = isPembilang ? '#bbf7d0' : (isPenyebut ? '#bfdbfe' : '#e2e8f0');
                        const textColor = isPembilang ? '#065f46' : (isPenyebut ? '#1e40af' : '#334155');
                        const iconColor = isPembilang ? '#059669' : (isPenyebut ? '#2563eb' : '#64748b');

                        return (
                            <Grid item xs={12} sm={numFields > 1 ? 6 : 12} md={colMd} key={field.key}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    type="text"
                                    inputMode="decimal"
                                    label={field.label}
                                    placeholder={fieldPlaceholder}
                                    value={fieldVal}
                                    onChange={fieldChange}
                                    required={field.required}
                                    InputProps={{
                                        sx: { bgcolor: '#f8fafc', borderRadius: 2 }
                                    }}
                                />

                                {/* Keterangan Spesifik Tepat di Bawah Kolom Pengisian */}
                                {descText && (
                                    <Box
                                        sx={{
                                            mt: 1,
                                            p: 1.2,
                                            bgcolor: boxBg,
                                            borderRadius: 2,
                                            border: `1px solid ${boxBorder}`,
                                            display: 'flex',
                                            alignItems: 'flex-start',
                                            gap: 1
                                        }}
                                    >
                                        <InfoIcon sx={{ fontSize: 16, color: iconColor, mt: 0.2, flexShrink: 0 }} />
                                        <Typography variant="caption" sx={{ color: textColor, fontWeight: 600, lineHeight: 1.45 }}>
                                            <strong>{roleLabel}</strong>
                                            {descText}
                                        </Typography>
                                    </Box>
                                )}
                            </Grid>
                        );
                    })}
                </Grid>
            </Paper>
        );
    }

    const type = node.calculation_type || 'DOCUMENTED';

    if (type === 'RATIO') {
        return (
            <Paper variant="outlined" sx={{ p: 2.5, borderRadius: 2.5, bgcolor: '#ffffff', mb: 2.5, border: '1px solid #e2e8f0' }}>
                <Typography variant="caption" sx={{ color: '#475569', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5, mb: 1.5, display: 'block' }}>
                    Variabel Rasio (Pembilang & Penyebut)
                </Typography>
                <Grid container spacing={2}>
                    <Grid item xs={12} md={6}>
                        <TextField
                            fullWidth
                            size="small"
                            type="text"
                            inputMode="decimal"
                            label="Pembilang / Numerator"
                            placeholder={pembilangDesc}
                            value={value.pembilang ?? ''}
                            onChange={handleDecimalChange((val) => onChange('pembilang', val))}
                            InputProps={{ sx: { bgcolor: '#f8fafc', borderRadius: 2 } }}
                        />
                        <Box sx={{ mt: 1, p: 1.2, bgcolor: '#f0fdf4', borderRadius: 2, border: '1px solid #bbf7d0', display: 'flex', alignItems: 'flex-start', gap: 1 }}>
                            <InfoIcon sx={{ fontSize: 16, color: '#059669', mt: 0.2, flexShrink: 0 }} />
                            <Typography variant="caption" sx={{ color: '#065f46', fontWeight: 600, lineHeight: 1.45 }}>
                                <strong>Pembilang: </strong>{pembilangDesc}
                            </Typography>
                        </Box>
                    </Grid>
                    <Grid item xs={12} md={6}>
                        <TextField
                            fullWidth
                            size="small"
                            type="text"
                            inputMode="decimal"
                            label="Penyebut / Denominator"
                            placeholder={penyebutDesc}
                            value={value.penyebut ?? ''}
                            onChange={handleDecimalChange((val) => onChange('penyebut', val))}
                            InputProps={{ sx: { bgcolor: '#f8fafc', borderRadius: 2 } }}
                        />
                        <Box sx={{ mt: 1, p: 1.2, bgcolor: '#eff6ff', borderRadius: 2, border: '1px solid #bfdbfe', display: 'flex', alignItems: 'flex-start', gap: 1 }}>
                            <InfoIcon sx={{ fontSize: 16, color: '#2563eb', mt: 0.2, flexShrink: 0 }} />
                            <Typography variant="caption" sx={{ color: '#1e40af', fontWeight: 600, lineHeight: 1.45 }}>
                                <strong>Penyebut: </strong>{penyebutDesc}
                            </Typography>
                        </Box>
                    </Grid>
                </Grid>
            </Paper>
        );
    }

    if (components.length > 0 && ['WEIGHTED_SUM', 'SUM', 'AVERAGE'].includes(type)) {
        return (
            <Paper variant="outlined" sx={{ p: 2.5, borderRadius: 2.5, bgcolor: '#ffffff', mb: 2.5, border: '1px solid #e2e8f0' }}>
                <Typography variant="caption" sx={{ color: '#475569', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5, mb: 1.5, display: 'block' }}>
                    Komponen Variabel Terbobot
                </Typography>
                <Grid container spacing={2}>
                    {components.map((component) => (
                        <Grid item xs={12} md={components.length <= 2 ? 6 : 4} key={component.id || component.kode_komponen}>
                            <TextField
                                fullWidth
                                size="small"
                                type="text"
                                inputMode="decimal"
                                label={`${component.kode_komponen} — ${component.nama_komponen}`}
                                placeholder={component.penjelasan || `Contoh: Masukkan nilai ${component.nama_komponen.toLowerCase()}...`}
                                value={inputs[component.input_key || component.kode_komponen] ?? ''}
                                onChange={handleDecimalChange((val) => updateInput(component.input_key || component.kode_komponen, val))}
                                InputProps={{ sx: { bgcolor: '#f8fafc', borderRadius: 2 } }}
                            />
                            <Box sx={{ mt: 1, p: 1.2, bgcolor: '#f8fafc', borderRadius: 2, border: '1px solid #e2e8f0', display: 'flex', alignItems: 'flex-start', gap: 1 }}>
                                <InfoIcon sx={{ fontSize: 16, color: '#64748b', mt: 0.2, flexShrink: 0 }} />
                                <Typography variant="caption" sx={{ color: '#334155', fontWeight: 600, lineHeight: 1.45 }}>
                                    {component.penjelasan || component.nama_komponen}
                                    {component.bobot !== null && component.bobot !== undefined && ` (Bobot: ${(Number(component.bobot) * 100).toFixed(0)}%)`}
                                </Typography>
                            </Box>
                        </Grid>
                    ))}
                </Grid>
            </Paper>
        );
    }

    const directDesc = `Nilai realisasi ${node.nama || 'indikator'}${node.satuan ? ` (${node.satuan})` : ''}`;

    return (
        <Paper variant="outlined" sx={{ p: 2.5, borderRadius: 2.5, bgcolor: '#ffffff', mb: 2.5, border: '1px solid #e2e8f0' }}>
            <Typography variant="caption" sx={{ color: '#475569', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5, mb: 1.5, display: 'block' }}>
                Nilai Realisasi Aktual
            </Typography>
            <TextField
                fullWidth
                size="small"
                type="text"
                inputMode="decimal"
                label="Realisasi Aktual"
                placeholder={directDesc}
                value={value.realisasi ?? ''}
                onChange={handleDecimalChange((val) => onChange('realisasi', val))}
                InputProps={{ sx: { bgcolor: '#f8fafc', borderRadius: 2 } }}
            />
            <Box sx={{ mt: 1, p: 1.2, bgcolor: '#f8fafc', borderRadius: 2, border: '1px solid #e2e8f0', display: 'flex', alignItems: 'flex-start', gap: 1 }}>
                <InfoIcon sx={{ fontSize: 16, color: '#64748b', mt: 0.2, flexShrink: 0 }} />
                <Typography variant="caption" sx={{ color: '#334155', fontWeight: 600, lineHeight: 1.45 }}>
                    <strong>Realisasi: </strong>{directDesc}
                </Typography>
            </Box>
        </Paper>
    );
}

function AnalysisFields({ value, onChange }) {
    return (
        <Box sx={{ mt: 1 }}>
            <Typography variant="caption" sx={{ color: '#475569', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5, mb: 1.5, display: 'block' }}>
                Analisis Kualitatif & Rekomendasi
            </Typography>
            <Grid container spacing={2}>
                <Grid item xs={12} md={4}>
                    <TextField
                        fullWidth
                        size="small"
                        multiline
                        minRows={3}
                        label="Analisis Capaian Kinerja"
                        placeholder="Uraian faktor penyebab keberhasilan capaian..."
                        value={value.analisis_capaian ?? ''}
                        onChange={(e) => onChange('analisis_capaian', e.target.value)}
                        InputProps={{ sx: { bgcolor: '#ffffff', borderRadius: 2 } }}
                    />
                </Grid>
                <Grid item xs={12} md={4}>
                    <TextField
                        fullWidth
                        size="small"
                        multiline
                        minRows={3}
                        label="Kendala / Hambatan"
                        placeholder="Permasalahan yang dihadapi selama pelaksanaan kegiatan..."
                        value={value.kendala ?? ''}
                        onChange={(e) => onChange('kendala', e.target.value)}
                        InputProps={{ sx: { bgcolor: '#ffffff', borderRadius: 2 } }}
                    />
                </Grid>
                <Grid item xs={12} md={4}>
                    <TextField
                        fullWidth
                        size="small"
                        multiline
                        minRows={3}
                        label="Upaya / Rencana Tindak Lanjut"
                        placeholder="Solusi atau strategi perbaikan untuk periode selanjutnya..."
                        value={value.upaya ?? ''}
                        onChange={(e) => onChange('upaya', e.target.value)}
                        InputProps={{ sx: { bgcolor: '#ffffff', borderRadius: 2 } }}
                    />
                </Grid>
            </Grid>
        </Box>
    );
}

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
        acc[ikk.kode_ikk] = {
            kode_ikk: ikk.kode_ikk,
            pembilang: formatCleanNumber(measurement.pembilang),
            penyebut: formatCleanNumber(measurement.penyebut),
            realisasi: formatCleanNumber(measurement.realisasi),
            inputs: measurementInputs(measurement),
            analisis_capaian: measurement.analisis_capaian ?? '',
            kendala: measurement.kendala ?? '',
            upaya: measurement.upaya ?? '',
        };
        return acc;
    }, {}), [ikks, pengukuranIkk]);

    const initialIkpData = useMemo(() => effectiveIkpInputs.reduce((acc, ikp) => {
        const measurement = pengukuranIkp[ikp.node_id] || {};
        acc[ikp.kode_ikp] = {
            kode_ikp: ikp.kode_ikp,
            pembilang: formatCleanNumber(measurement.pembilang),
            penyebut: formatCleanNumber(measurement.penyebut),
            realisasi: formatCleanNumber(measurement.realisasi),
            inputs: measurementInputs(measurement),
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
            <Paper 
                elevation={0} 
                sx={{ 
                    p: { xs: 3, md: 3.5 }, 
                    mb: 3.5, 
                    borderRadius: 3.5, 
                    background: 'linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #064e3b 100%)', 
                    color: 'white',
                    border: '1px solid rgba(255,255,255,0.08)' 
                }}
            >
                <Stack direction={{ xs: 'column', md: 'row' }} justifyContent="space-between" alignItems={{ md: 'center' }} spacing={2.5}>
                    <Box>
                        <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 1 }}>
                            <Chip label={bidangId || 'UNIT KERJA'} size="small" sx={{ bgcolor: 'rgba(16, 185, 129, 0.2)', color: '#34d399', fontWeight: 700, border: '1px solid rgba(16, 185, 129, 0.4)' }} />
                            <Chip label="Canonical Formula Engine" size="small" sx={{ bgcolor: 'rgba(255,255,255,0.1)', color: '#e2e8f0', fontWeight: 600 }} />
                        </Stack>
                        <Typography variant="h4" fontWeight={800} sx={{ letterSpacing: -0.5 }}>
                            Pengukuran Kinerja — {selectedBiro}
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#94a3b8', mt: 0.5, maxWidth: 650 }}>
                            Input mengikuti formula resmi indikator; Realisasi dan Capaian terhadap target dihitung otomatis dan independen.
                        </Typography>
                    </Box>

                    {/* Period Switcher */}
                    <Stack 
                        direction="row" 
                        spacing={1.5} 
                        alignItems="center"
                        sx={{ 
                            bgcolor: 'rgba(15, 23, 42, 0.75)', 
                            p: 1.5, 
                            borderRadius: 3, 
                            border: '1px solid rgba(255, 255, 255, 0.12)',
                            boxShadow: '0 4px 12px rgba(0, 0, 0, 0.2)'
                        }}
                    >
                        <Box>
                            <Typography variant="caption" sx={{ color: '#94a3b8', fontWeight: 700, fontSize: '0.7rem', display: 'block', mb: 0.5, px: 0.5 }}>
                                TAHUN
                            </Typography>
                            <Select 
                                size="small"
                                value={tahun} 
                                onChange={(e) => changePeriod('tahun', e.target.value)}
                                sx={{ 
                                    minWidth: 110,
                                    height: 38,
                                    color: '#ffffff', 
                                    fontWeight: 700,
                                    bgcolor: 'rgba(30, 41, 59, 0.8)',
                                    borderRadius: 2,
                                    '& .MuiOutlinedInput-notchedOutline': { borderColor: 'rgba(255, 255, 255, 0.15)' },
                                    '&:hover .MuiOutlinedInput-notchedOutline': { borderColor: '#10b981' },
                                    '&.Mui-focused .MuiOutlinedInput-notchedOutline': { borderColor: '#10b981' },
                                    '& .MuiSvgIcon-root': { color: '#34d399' }
                                }}
                            >
                                {[2025, 2026, 2027, 2028, 2029].map((year) => (
                                    <MenuItem key={year} value={year}>Tahun {year}</MenuItem>
                                ))}
                            </Select>
                        </Box>

                        <Box>
                            <Typography variant="caption" sx={{ color: '#94a3b8', fontWeight: 700, fontSize: '0.7rem', display: 'block', mb: 0.5, px: 0.5 }}>
                                TRIWULAN
                            </Typography>
                            <Select 
                                size="small"
                                value={triwulan} 
                                onChange={(e) => changePeriod('triwulan', e.target.value)}
                                sx={{ 
                                    minWidth: 130,
                                    height: 38,
                                    color: '#ffffff', 
                                    fontWeight: 700,
                                    bgcolor: 'rgba(30, 41, 59, 0.8)',
                                    borderRadius: 2,
                                    '& .MuiOutlinedInput-notchedOutline': { borderColor: 'rgba(255, 255, 255, 0.15)' },
                                    '&:hover .MuiOutlinedInput-notchedOutline': { borderColor: '#10b981' },
                                    '&.Mui-focused .MuiOutlinedInput-notchedOutline': { borderColor: '#10b981' },
                                    '& .MuiSvgIcon-root': { color: '#34d399' }
                                }}
                            >
                                {[1, 2, 3, 4].map((quarter) => (
                                    <MenuItem key={quarter} value={quarter}>Triwulan {quarter}</MenuItem>
                                ))}
                            </Select>
                        </Box>
                    </Stack>
                </Stack>
            </Paper>

            {/* Level Tab Switcher if both exist */}
            {effectiveIkpInputs.length > 0 && ikks.length > 0 && (
                <Paper sx={{ mb: 3, borderRadius: 2.5, border: '1px solid #e2e8f0', boxShadow: 'none' }}>
                    <Tabs 
                        value={activeTab} 
                        onChange={(e, val) => setActiveTab(val)}
                        sx={{
                            px: 2,
                            '& .MuiTab-root': { fontWeight: 700, textTransform: 'none', fontSize: '0.95rem', py: 2 }
                        }}
                    >
                        <Tab 
                            value="IKK" 
                            label={`Indikator Kinerja Kegiatan (${ikks.length} IKK)`} 
                            icon={<AssignmentIcon />} 
                            iconPosition="start" 
                        />
                        <Tab 
                            value="IKP" 
                            label={`Indikator Sasaran Program (${effectiveIkpInputs.length} IKP)`} 
                            icon={<CalculateIcon />} 
                            iconPosition="start" 
                        />
                    </Tabs>
                </Paper>
            )}

            {/* Expand / Collapse & Search Action Toolbar */}
            <Paper
                elevation={0}
                sx={{
                    p: 2,
                    mb: 3,
                    borderRadius: 2.5,
                    bgcolor: '#ffffff',
                    border: '1px solid #e2e8f0',
                    display: 'flex',
                    flexDirection: { xs: 'column', sm: 'row' },
                    justifyContent: 'space-between',
                    alignItems: { xs: 'stretch', sm: 'center' },
                    gap: 2,
                }}
            >
                <Stack direction="row" spacing={1.5} alignItems="center" sx={{ flexGrow: 1, maxWidth: { sm: 380 } }}>
                    <TextField
                        fullWidth
                        size="small"
                        placeholder="Cari indikator, nama kegiatan, atau kode..."
                        value={searchKeyword}
                        onChange={(e) => setSearchKeyword(e.target.value)}
                        InputProps={{
                            startAdornment: (
                                <InputAdornment position="start">
                                    <SearchIcon sx={{ color: '#94a3b8', fontSize: 20 }} />
                                </InputAdornment>
                            ),
                            sx: { borderRadius: 2, bgcolor: '#f8fafc' }
                        }}
                    />
                    {searchKeyword && (
                        <Button size="small" onClick={() => setSearchKeyword('')} sx={{ color: '#64748b', textTransform: 'none', whiteSpace: 'nowrap' }}>
                            Reset
                        </Button>
                    )}
                </Stack>

                <Stack direction="row" spacing={1} alignItems="center" justifyContent={{ xs: 'space-between', sm: 'flex-end' }}>
                    <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 600, display: { xs: 'none', md: 'block' } }}>
                        Kontrol Tampilan:
                    </Typography>
                    <Button
                        size="small"
                        variant="outlined"
                        startIcon={<UnfoldMoreIcon />}
                        onClick={expandAll}
                        sx={{
                            fontWeight: 700,
                            textTransform: 'none',
                            borderRadius: 2,
                            borderColor: '#cbd5e1',
                            color: '#334155',
                            bgcolor: '#ffffff',
                            '&:hover': { bgcolor: '#f8fafc', borderColor: '#94a3b8' }
                        }}
                    >
                        Buka Semua
                    </Button>
                    <Button
                        size="small"
                        variant="outlined"
                        startIcon={<UnfoldLessIcon />}
                        onClick={collapseAll}
                        sx={{
                            fontWeight: 700,
                            textTransform: 'none',
                            borderRadius: 2,
                            borderColor: '#cbd5e1',
                            color: '#334155',
                            bgcolor: '#ffffff',
                            '&:hover': { bgcolor: '#f8fafc', borderColor: '#94a3b8' }
                        }}
                    >
                        Tutup Semua
                    </Button>
                </Stack>
            </Paper>

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
                                <Paper
                                    key={spGroup.sp_kode}
                                    elevation={0}
                                    sx={{
                                        mb: 3,
                                        borderRadius: 3,
                                        border: '1px solid #cbd5e1',
                                        overflow: 'hidden',
                                        boxShadow: '0 4px 15px -3px rgba(15, 23, 42, 0.05)'
                                    }}
                                >
                                    <Box
                                        onClick={() => toggleSp(spGroup.sp_kode)}
                                        sx={{
                                            p: { xs: 2, md: 2.5 },
                                            background: 'linear-gradient(135deg, #0f172a 0%, #1e293b 100%)',
                                            color: '#ffffff',
                                            cursor: 'pointer',
                                            display: 'flex',
                                            flexDirection: { xs: 'column', sm: 'row' },
                                            justifyContent: 'space-between',
                                            alignItems: { xs: 'flex-start', sm: 'center' },
                                            gap: 1.5,
                                            userSelect: 'none',
                                            transition: 'background 0.2s',
                                            '&:hover': { background: 'linear-gradient(135deg, #1e293b 0%, #334155 100%)' }
                                        }}
                                    >
                                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5 }}>
                                            <Box sx={{
                                                width: 36,
                                                height: 36,
                                                borderRadius: 2,
                                                bgcolor: 'rgba(16, 185, 129, 0.2)',
                                                color: '#34d399',
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                                border: '1px solid rgba(16, 185, 129, 0.3)'
                                            }}>
                                                <FolderSpecialIcon sx={{ fontSize: 20 }} />
                                            </Box>
                                            <Box>
                                                <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 0.25 }}>
                                                    <Chip
                                                        label={spGroup.sp_kode}
                                                        size="small"
                                                        sx={{ bgcolor: '#10b981', color: '#ffffff', fontWeight: 800, fontSize: '0.72rem', height: 22 }}
                                                    />
                                                    <Typography variant="caption" sx={{ color: '#94a3b8', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                                        Sasaran Program
                                                    </Typography>
                                                </Stack>
                                                <Typography variant="subtitle1" fontWeight={800} sx={{ color: '#f8fafc', lineHeight: 1.3 }}>
                                                    {spGroup.sp_nama}
                                                </Typography>
                                            </Box>
                                        </Box>

                                        <Stack direction="row" spacing={1.5} alignItems="center" sx={{ alignSelf: { xs: 'flex-end', sm: 'center' } }}>
                                            <Chip
                                                label={`${spGroup.ikps.length} IKP`}
                                                size="small"
                                                sx={{ bgcolor: 'rgba(16, 185, 129, 0.2)', color: '#34d399', fontWeight: 700, border: '1px solid rgba(16, 185, 129, 0.3)' }}
                                            />
                                            <IconButton size="small" sx={{ color: '#ffffff' }}>
                                                {isSpCollapsed ? <ExpandMoreIcon /> : <ExpandLessIcon />}
                                            </IconButton>
                                        </Stack>
                                    </Box>

                                    <Collapse in={!isSpCollapsed}>
                                        <Box sx={{ p: { xs: 2, md: 3 }, bgcolor: '#f8fafc' }}>
                                            {spGroup.ikps.map((ikp) => {
                                                const node = ikp.node || {};
                                                const target = effectiveTargetIkp[ikp.node_id];
                                                const measurement = pengukuranIkp[ikp.node_id];
                                                const value = ikpFormData[ikp.kode_ikp] || { inputs: {} };
                                                const isTercapai = measurement?.status_capaian === 'TERCAPAI';

                                                return (
                                                    <Card
                                                        key={ikp.kode_ikp}
                                                        sx={{
                                                            mb: 2.5,
                                                            borderRadius: 3,
                                                            border: '1px solid #e2e8f0',
                                                            boxShadow: '0 2px 10px -2px rgba(15, 23, 42, 0.04)',
                                                            borderLeft: `5px solid ${isTercapai ? '#059669' : '#3b82f6'}`
                                                        }}
                                                    >
                                                        <CardContent sx={{ p: { xs: 2.5, md: 3 } }}>
                                                            <Stack direction={{ xs: 'column', md: 'row' }} justifyContent="space-between" alignItems={{ xs: 'flex-start', md: 'center' }} spacing={1.5} sx={{ mb: 2 }}>
                                                                <Box>
                                                                    <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 0.5 }}>
                                                                        <Chip label={ikp.kode_ikp} size="small" sx={{ fontWeight: 800, bgcolor: '#0f172a', color: '#ffffff', borderRadius: 1.5 }} />
                                                                        <Chip size="small" label={calculationLabel[node.calculation_type] || node.calculation_type || 'Formula'} sx={{ fontWeight: 600, bgcolor: '#eff6ff', color: '#2563eb' }} />
                                                                        {node.satuan && <Chip size="small" variant="outlined" label={`Satuan: ${node.satuan}`} sx={{ fontWeight: 600 }} />}
                                                                    </Stack>
                                                                    <Typography fontWeight={800} variant="h6" sx={{ color: '#0f172a', mt: 0.5 }}>
                                                                        {ikp.nama_ikp || node.nama}
                                                                    </Typography>
                                                                </Box>

                                                                <Stack direction="row" flexWrap="wrap" gap={1} alignItems="center">
                                                                    {target && (
                                                                        <Chip
                                                                            size="small"
                                                                            variant="outlined"
                                                                            label={`Target: ${formatCleanNumber(target.nilai_target ?? target.nilai_teks_sumber)} ${node.satuan || ''}`}
                                                                            sx={{ fontWeight: 700, borderColor: '#cbd5e1', bgcolor: '#f8fafc' }}
                                                                        />
                                                                    )}
                                                                    {measurement?.realisasi !== undefined && measurement?.realisasi !== null && (
                                                                        <Chip
                                                                            size="small"
                                                                            label={`Realisasi: ${formatCleanNumber(measurement.realisasi)} ${node.satuan || ''}`}
                                                                            sx={{ fontWeight: 700, bgcolor: '#eff6ff', color: '#1d4ed8' }}
                                                                        />
                                                                    )}
                                                                    {measurement?.capaian !== undefined && measurement?.capaian !== null && (
                                                                        <Chip
                                                                            size="small"
                                                                            label={`Capaian: ${formatCleanNumber(measurement.capaian)}%`}
                                                                            sx={{ 
                                                                                fontWeight: 800, 
                                                                                bgcolor: measurement.capaian >= 100 ? '#f0fdf4' : '#fffbeb', 
                                                                                color: measurement.capaian >= 100 ? '#059669' : '#d97706',
                                                                                border: `1px solid ${measurement.capaian >= 100 ? '#bbf7d0' : '#fde68a'}`
                                                                            }}
                                                                        />
                                                                    )}
                                                                    {measurement?.status_capaian && (
                                                                        <Chip
                                                                            size="small"
                                                                            color={
                                                                                measurement.status_capaian === 'TERCAPAI' ? 'success' :
                                                                                measurement.status_capaian === 'BELUM_TERCAPAI' ? 'warning' :
                                                                                measurement.status_capaian === 'TIDAK_TERCAPAI' ? 'error' : 'default'
                                                                            }
                                                                            label={measurement.status_capaian}
                                                                            sx={{ fontWeight: 800 }}
                                                                        />
                                                                    )}
                                                                </Stack>
                                                            </Stack>

                                                            <Divider sx={{ mb: 2.5 }} />
                                                            <InputHelp entity={ikp} />
                                                            <FormulaFields entity={ikp} value={value} onChange={(field, fieldValue) => updateIkp(ikp.kode_ikp, field, fieldValue)} />
                                                            <AnalysisFields value={value} onChange={(field, fieldValue) => updateIkp(ikp.kode_ikp, field, fieldValue)} />

                                                            {/* Single IKP Save & Calculate Action */}
                                                            <Box
                                                                sx={{
                                                                    mt: 3,
                                                                    pt: 2,
                                                                    borderTop: '1px solid #e2e8f0',
                                                                    display: 'flex',
                                                                    flexDirection: { xs: 'column', sm: 'row' },
                                                                    justifyContent: 'space-between',
                                                                    alignItems: { xs: 'stretch', sm: 'center' },
                                                                    gap: 1.5,
                                                                }}
                                                            >
                                                                <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 600 }}>
                                                                    Simpan data untuk indikator <strong>{ikp.kode_ikp}</strong> secara mandiri tanpa harus submit bulk.
                                                                </Typography>
                                                                <Button
                                                                    type="button"
                                                                    variant="contained"
                                                                    size="small"
                                                                    onClick={() => handleSaveSingle('IKP', ikp.kode_ikp)}
                                                                    disabled={savingCode === ikp.kode_ikp || loading}
                                                                    startIcon={savingCode === ikp.kode_ikp ? <CircularProgress size={16} color="inherit" /> : <SaveIcon />}
                                                                    sx={{
                                                                        bgcolor: '#0284c7',
                                                                        color: '#ffffff',
                                                                        background: 'linear-gradient(135deg, #0284c7 0%, #0369a1 100%)',
                                                                        fontWeight: 700,
                                                                        borderRadius: 2,
                                                                        px: 2.5,
                                                                        py: 0.8,
                                                                        boxShadow: '0 2px 8px rgba(2, 132, 199, 0.25)',
                                                                        textTransform: 'none',
                                                                        fontSize: '0.875rem',
                                                                        whiteSpace: 'nowrap',
                                                                        '&:hover': {
                                                                            background: 'linear-gradient(135deg, #0369a1 0%, #075985 100%)',
                                                                        }
                                                                    }}
                                                                >
                                                                    {savingCode === ikp.kode_ikp ? 'Menyimpan & Menghitung...' : 'Simpan & Hitung Kinerja'}
                                                                </Button>
                                                            </Box>
                                                        </CardContent>
                                                    </Card>
                                                );
                                            })}
                                        </Box>
                                    </Collapse>
                                </Paper>
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
                                <Paper
                                    key={spGroup.sp_kode}
                                    elevation={0}
                                    sx={{
                                        mb: 3.5,
                                        borderRadius: 3.5,
                                        border: '1px solid #cbd5e1',
                                        overflow: 'hidden',
                                        boxShadow: '0 4px 20px -4px rgba(15, 23, 42, 0.06)'
                                    }}
                                >
                                    {/* SP Header with Toggle */}
                                    <Box
                                        onClick={() => toggleSp(spGroup.sp_kode)}
                                        sx={{
                                            p: { xs: 2, md: 2.5 },
                                            background: 'linear-gradient(135deg, #0f172a 0%, #1e293b 100%)',
                                            color: '#ffffff',
                                            cursor: 'pointer',
                                            display: 'flex',
                                            flexDirection: { xs: 'column', sm: 'row' },
                                            justifyContent: 'space-between',
                                            alignItems: { xs: 'flex-start', sm: 'center' },
                                            gap: 1.5,
                                            userSelect: 'none',
                                            transition: 'background 0.2s',
                                            '&:hover': { background: 'linear-gradient(135deg, #1e293b 0%, #334155 100%)' }
                                        }}
                                    >
                                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5 }}>
                                            <Box sx={{
                                                width: 40,
                                                height: 40,
                                                borderRadius: 2.5,
                                                bgcolor: 'rgba(16, 185, 129, 0.2)',
                                                color: '#34d399',
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                                border: '1px solid rgba(16, 185, 129, 0.3)'
                                            }}>
                                                <FolderSpecialIcon sx={{ fontSize: 22 }} />
                                            </Box>
                                            <Box>
                                                <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 0.5 }}>
                                                    <Chip
                                                        label={spGroup.sp_kode}
                                                        size="small"
                                                        sx={{ bgcolor: '#10b981', color: '#ffffff', fontWeight: 800, fontSize: '0.75rem', height: 24 }}
                                                    />
                                                    <Typography variant="caption" sx={{ color: '#94a3b8', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                                        Sasaran Program
                                                    </Typography>
                                                </Stack>
                                                <Typography variant="subtitle1" fontWeight={800} sx={{ color: '#f8fafc', lineHeight: 1.3 }}>
                                                    {spGroup.sp_nama}
                                                </Typography>
                                            </Box>
                                        </Box>

                                        <Stack direction="row" spacing={1.5} alignItems="center" sx={{ alignSelf: { xs: 'flex-end', sm: 'center' } }}>
                                            <Chip
                                                label={`${spGroup.sks.length} Sasaran Kegiatan`}
                                                size="small"
                                                sx={{ bgcolor: 'rgba(255,255,255,0.12)', color: '#e2e8f0', fontWeight: 700 }}
                                            />
                                            <Chip
                                                label={`${spGroup.total_ikks} IKK`}
                                                size="small"
                                                sx={{ bgcolor: 'rgba(16, 185, 129, 0.25)', color: '#34d399', fontWeight: 800, border: '1px solid rgba(16, 185, 129, 0.4)' }}
                                            />
                                            <IconButton size="small" sx={{ color: '#ffffff' }}>
                                                {isSpCollapsed ? <ExpandMoreIcon /> : <ExpandLessIcon />}
                                            </IconButton>
                                        </Stack>
                                    </Box>

                                    {/* Collapsible SP Content */}
                                    <Collapse in={!isSpCollapsed}>
                                        <Box sx={{ p: { xs: 2, md: 3 }, bgcolor: '#f8fafc' }}>
                                            {spGroup.sks.map((skGroup) => {
                                                const skKey = `${spGroup.sp_kode}_${skGroup.sk_kode}`;
                                                const isSkCollapsed = !!collapsedSks[skKey];

                                                return (
                                                    <Paper
                                                        key={skKey}
                                                        elevation={0}
                                                        sx={{
                                                            mb: 3,
                                                            borderRadius: 3,
                                                            border: '1px solid #e2e8f0',
                                                            bgcolor: '#ffffff',
                                                            overflow: 'hidden'
                                                        }}
                                                    >
                                                        {/* SK Header with Toggle */}
                                                        <Box
                                                            onClick={() => toggleSk(skKey)}
                                                            sx={{
                                                                p: 2,
                                                                bgcolor: '#f1f5f9',
                                                                cursor: 'pointer',
                                                                display: 'flex',
                                                                flexDirection: { xs: 'column', sm: 'row' },
                                                                justifyContent: 'space-between',
                                                                alignItems: { xs: 'flex-start', sm: 'center' },
                                                                gap: 1.5,
                                                                borderBottom: isSkCollapsed ? 'none' : '1px solid #e2e8f0',
                                                                userSelect: 'none',
                                                                transition: 'background 0.2s',
                                                                '&:hover': { bgcolor: '#e2e8f0' }
                                                            }}
                                                        >
                                                            <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5 }}>
                                                                <Box sx={{
                                                                    width: 32,
                                                                    height: 32,
                                                                    borderRadius: 2,
                                                                    bgcolor: '#e0f2fe',
                                                                    color: '#0284c7',
                                                                    display: 'flex',
                                                                    alignItems: 'center',
                                                                    justifyContent: 'center'
                                                                }}>
                                                                    <TreeIcon sx={{ fontSize: 18 }} />
                                                                </Box>
                                                                <Box>
                                                                    <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 0.25 }}>
                                                                        <Chip
                                                                            label={skGroup.sk_kode}
                                                                            size="small"
                                                                            sx={{ bgcolor: '#0284c7', color: '#ffffff', fontWeight: 800, fontSize: '0.72rem', height: 22 }}
                                                                        />
                                                                        <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5 }}>
                                                                            Sasaran Kegiatan
                                                                        </Typography>
                                                                    </Stack>
                                                                    <Typography variant="body2" fontWeight={700} sx={{ color: '#1e293b' }}>
                                                                        {skGroup.sk_nama}
                                                                    </Typography>
                                                                </Box>
                                                            </Box>

                                                            <Stack direction="row" spacing={1.5} alignItems="center" sx={{ alignSelf: { xs: 'flex-end', sm: 'center' } }}>
                                                                <Chip
                                                                    label={`${skGroup.ikks.length} IKK`}
                                                                    size="small"
                                                                    variant="outlined"
                                                                    sx={{ fontWeight: 700, borderColor: '#cbd5e1', bgcolor: '#ffffff' }}
                                                                />
                                                                <IconButton size="small" sx={{ color: '#64748b' }}>
                                                                    {isSkCollapsed ? <ExpandMoreIcon /> : <ExpandLessIcon />}
                                                                </IconButton>
                                                            </Stack>
                                                        </Box>

                                                        {/* Collapsible SK Content with IKK cards */}
                                                        <Collapse in={!isSkCollapsed}>
                                                            <Box sx={{ p: { xs: 2, md: 2.5 }, bgcolor: '#ffffff' }}>
                                                                {skGroup.ikks.map((ikk) => {
                                                                    const node = ikk.node || {};
                                                                    const target = targetIkk[ikk.node_id];
                                                                    const measurement = pengukuranIkk[ikk.node_id];
                                                                    const value = formData[ikk.kode_ikk] || { inputs: {} };
                                                                    const isTercapai = measurement?.status_capaian === 'TERCAPAI';

                                                                    return (
                                                                        <Card
                                                                            key={ikk.kode_ikk}
                                                                            sx={{
                                                                                mb: 2.5,
                                                                                borderRadius: 3,
                                                                                border: '1px solid #e2e8f0',
                                                                                boxShadow: '0 2px 10px -2px rgba(15, 23, 42, 0.04)',
                                                                                borderLeft: `5px solid ${isTercapai ? '#059669' : '#0284c7'}`
                                                                            }}
                                                                        >
                                                                            <CardContent sx={{ p: { xs: 2.5, md: 3 } }}>
                                                                                {/* Card Top Title & Badges */}
                                                                                <Stack direction={{ xs: 'column', md: 'row' }} justifyContent="space-between" alignItems={{ xs: 'flex-start', md: 'center' }} spacing={1.5} sx={{ mb: 2 }}>
                                                                                    <Box>
                                                                                        <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 0.5 }}>
                                                                                            <Chip label={ikk.kode_ikk} size="small" sx={{ fontWeight: 800, bgcolor: '#0f172a', color: '#ffffff', borderRadius: 1.5 }} />
                                                                                            <Chip size="small" label={calculationLabel[node.calculation_type] || node.calculation_type || 'Formula'} sx={{ fontWeight: 600, bgcolor: '#f0fdfa', color: '#0f766e' }} />
                                                                                            {(ikk.satuan || node.satuan) && <Chip size="small" variant="outlined" label={`Satuan: ${ikk.satuan || node.satuan}`} sx={{ fontWeight: 600 }} />}
                                                                                        </Stack>
                                                                                        <Typography fontWeight={800} variant="h6" sx={{ color: '#0f172a', mt: 0.5 }}>
                                                                                            {ikk.nama_ikk || node.nama}
                                                                                        </Typography>
                                                                                    </Box>

                                                                                    {/* Status Badges */}
                                                                                    <Stack direction="row" flexWrap="wrap" gap={1} alignItems="center">
                                                                                        {target && (
                                                                                            <Chip
                                                                                                size="small"
                                                                                                variant="outlined"
                                                                                                label={`Target: ${formatCleanNumber(target.nilai_target ?? target.nilai_teks_sumber)} ${ikk.satuan || node.satuan || ''}`}
                                                                                                sx={{ fontWeight: 700, borderColor: '#cbd5e1', bgcolor: '#f8fafc' }}
                                                                                            />
                                                                                        )}
                                                                                        {measurement?.realisasi !== undefined && measurement?.realisasi !== null && (
                                                                                            <Chip
                                                                                                size="small"
                                                                                                label={`Realisasi: ${formatCleanNumber(measurement.realisasi)} ${ikk.satuan || node.satuan || ''}`}
                                                                                                sx={{ fontWeight: 700, bgcolor: '#eff6ff', color: '#1d4ed8' }}
                                                                                            />
                                                                                        )}
                                                                                        {measurement?.capaian !== undefined && measurement?.capaian !== null && (
                                                                                            <Chip
                                                                                                size="small"
                                                                                                label={`Capaian: ${formatCleanNumber(measurement.capaian)}%`}
                                                                                                sx={{ 
                                                                                                    fontWeight: 800, 
                                                                                                    bgcolor: measurement.capaian >= 100 ? '#f0fdf4' : '#fffbeb', 
                                                                                                    color: measurement.capaian >= 100 ? '#059669' : '#d97706',
                                                                                                    border: `1px solid ${measurement.capaian >= 100 ? '#bbf7d0' : '#fde68a'}`
                                                                                                }}
                                                                                            />
                                                                                        )}
                                                                                        {measurement?.status_capaian && (
                                                                                            <Chip
                                                                                                size="small"
                                                                                                color={
                                                                                                    measurement.status_capaian === 'TERCAPAI' ? 'success' :
                                                                                                    measurement.status_capaian === 'BELUM_TERCAPAI' ? 'warning' :
                                                                                                    measurement.status_capaian === 'TIDAK_TERCAPAI' ? 'error' : 'default'
                                                                                                }
                                                                                                label={measurement.status_capaian}
                                                                                                sx={{ fontWeight: 800 }}
                                                                                            />
                                                                                        )}
                                                                                    </Stack>
                                                                                </Stack>

                                                                                <Divider sx={{ mb: 2.5 }} />
                                                                                <InputHelp entity={ikk} />
                                                                                <FormulaFields entity={ikk} value={value} onChange={(field, fieldValue) => updateIkk(ikk.kode_ikk, field, fieldValue)} />
                                                                                <AnalysisFields value={value} onChange={(field, fieldValue) => updateIkk(ikk.kode_ikk, field, fieldValue)} />

                                                                                {/* Single IKK Save & Calculate Action */}
                                                                                <Box
                                                                                    sx={{
                                                                                        mt: 3,
                                                                                        pt: 2,
                                                                                        borderTop: '1px solid #e2e8f0',
                                                                                        display: 'flex',
                                                                                        flexDirection: { xs: 'column', sm: 'row' },
                                                                                        justifyContent: 'space-between',
                                                                                        alignItems: { xs: 'stretch', sm: 'center' },
                                                                                        gap: 1.5,
                                                                                    }}
                                                                                >
                                                                                    <Typography variant="caption" sx={{ color: '#64748b', fontWeight: 600 }}>
                                                                                        Simpan data untuk indikator <strong>{ikk.kode_ikk}</strong> secara mandiri tanpa harus submit bulk.
                                                                                    </Typography>
                                                                                    <Button
                                                                                        type="button"
                                                                                        variant="contained"
                                                                                        size="small"
                                                                                        onClick={() => handleSaveSingle('IKK', ikk.kode_ikk)}
                                                                                        disabled={savingCode === ikk.kode_ikk || loading}
                                                                                        startIcon={savingCode === ikk.kode_ikk ? <CircularProgress size={16} color="inherit" /> : <SaveIcon />}
                                                                                        sx={{
                                                                                            bgcolor: '#059669',
                                                                                            color: '#ffffff',
                                                                                            background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                                                                                            fontWeight: 700,
                                                                                            borderRadius: 2,
                                                                                            px: 2.5,
                                                                                            py: 0.8,
                                                                                            boxShadow: '0 2px 8px rgba(5, 150, 105, 0.25)',
                                                                                            textTransform: 'none',
                                                                                            fontSize: '0.875rem',
                                                                                            whiteSpace: 'nowrap',
                                                                                            '&:hover': {
                                                                                                background: 'linear-gradient(135deg, #047857 0%, #059669 100%)',
                                                                                            }
                                                                                        }}
                                                                                    >
                                                                                        {savingCode === ikk.kode_ikk ? 'Menyimpan & Menghitung...' : 'Simpan & Hitung Kinerja'}
                                                                                    </Button>
                                                                                </Box>
                                                                            </CardContent>
                                                                        </Card>
                                                                    );
                                                                })}
                                                            </Box>
                                                        </Collapse>
                                                    </Paper>
                                                );
                                            })}
                                        </Box>
                                    </Collapse>
                                </Paper>
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
                <Paper 
                    elevation={4} 
                    sx={{ 
                        position: 'sticky', 
                        bottom: 20, 
                        p: 2, 
                        borderRadius: 3, 
                        border: '1px solid rgba(0,0,0,0.08)', 
                        bgcolor: 'rgba(255, 255, 255, 0.95)', 
                        backdropFilter: 'blur(12px)',
                        boxShadow: '0 10px 30px rgba(0,0,0,0.12)',
                        zIndex: 10
                    }}
                >
                    <Stack direction="row" justifyContent="space-between" alignItems="center">
                        <Typography variant="body2" sx={{ color: '#64748b', fontWeight: 600, display: { xs: 'none', sm: 'block' } }}>
                            Pastikan data input telah terisi lengkap sebelum menyimpan.
                        </Typography>
                        <Button 
                            type="submit" 
                            variant="contained" 
                            size="large" 
                            startIcon={loading ? <CircularProgress size={18} color="inherit" /> : <SaveIcon />} 
                            disabled={loading}
                            sx={{
                                bgcolor: '#059669',
                                color: '#ffffff',
                                background: 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                                fontWeight: 700,
                                borderRadius: 2.5,
                                px: 4,
                                py: 1.2,
                                boxShadow: '0 4px 14px rgba(5, 150, 105, 0.4)',
                                '&:hover': {
                                    background: 'linear-gradient(135deg, #047857 0%, #059669 100%)',
                                }
                            }}
                        >
                            {loading ? 'Menyimpan & Menghitung...' : 'Simpan & Hitung Kinerja'}
                        </Button>
                    </Stack>
                </Paper>
            </form>
        </AppLayout>
    );
}

