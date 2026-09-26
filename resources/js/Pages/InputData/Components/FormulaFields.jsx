import { Paper, Typography, Grid, TextField, Box } from '@mui/material';
import { InfoOutlined as InfoIcon } from '@mui/icons-material';
import { formulaFor, componentsFor, isValidDecimalInput } from '../Utils/inputHelpers';

export default function FormulaFields({ entity, value = {}, onChange }) {
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

    const directDesc = `Nilai hasil kinerja (realisasi) ${node.nama || 'indikator'}${node.satuan ? ` (${node.satuan})` : ''}`;

    return (
        <Paper variant="outlined" sx={{ p: 2.5, borderRadius: 2.5, bgcolor: '#ffffff', mb: 2.5, border: '1px solid #e2e8f0' }}>
            <Typography variant="caption" sx={{ color: '#475569', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 0.5, mb: 1.5, display: 'block' }}>
                Hasil Kinerja (Realisasi)
            </Typography>
            <TextField
                fullWidth
                size="small"
                type="text"
                inputMode="decimal"
                label="Hasil Kinerja"
                placeholder={directDesc}
                value={value.realisasi ?? ''}
                onChange={handleDecimalChange((val) => onChange('realisasi', val))}
                InputProps={{ sx: { bgcolor: '#f8fafc', borderRadius: 2 } }}
            />
            <Box sx={{ mt: 1, p: 1.2, bgcolor: '#f8fafc', borderRadius: 2, border: '1px solid #e2e8f0', display: 'flex', alignItems: 'flex-start', gap: 1 }}>
                <InfoIcon sx={{ fontSize: 16, color: '#64748b', mt: 0.2, flexShrink: 0 }} />
                <Typography variant="caption" sx={{ color: '#334155', fontWeight: 600, lineHeight: 1.45 }}>
                    <strong>Hasil Kinerja: </strong>{directDesc}
                </Typography>
            </Box>
        </Paper>
    );
}
