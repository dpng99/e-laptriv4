export const calculationLabel = {
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

export function formatCleanNumber(val, maxDecimals = 3) {
    if (val === null || val === undefined || val === '') return '';
    const num = Number(typeof val === 'string' ? val.replace(',', '.') : val);
    if (isNaN(num)) return String(val);
    return parseFloat(num.toFixed(maxDecimals)).toString();
}

export function isValidDecimalInput(str) {
    if (str === '' || str === '-') return true;
    return /^-?\d*[.,]?\d*$/.test(str);
}

export function measurementInputs(pengukuran) {
    return (pengukuran?.inputs || []).reduce((acc, item) => {
        acc[item.input_key] = formatCleanNumber(item.nilai);
        return acc;
    }, {});
}

export function formulaFor(entity) {
    return entity?.node?.formulas?.find((formula) => formula.is_active !== false)
        || entity?.node?.formulas?.[0]
        || null;
}

export function componentsFor(entity) {
    return formulaFor(entity)?.components || [];
}
