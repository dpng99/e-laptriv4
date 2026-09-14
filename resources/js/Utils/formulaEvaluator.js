/**
 * formulaEvaluator.js
 * Utility helper untuk parsing, validasi sintaks, dan simulasi evaluasi rumus secara aman di frontend.
 */

const RESERVED_WORDS = new Set([
    'Math', 'min', 'max', 'abs', 'round', 'ceil', 'floor', 'sqrt', 'pow', 'log', 'exp',
    'true', 'false', 'null', 'undefined', 'return', 'function', 'var', 'let', 'const'
]);

/**
 * Ekstrak semua nama variabel dari teks rumus.
 * Mengembalikan array unik nama variabel (contoh: ['X1', 'X2']).
 */
export function extractVariables(formulaText) {
    if (!formulaText || typeof formulaText !== 'string') return [];
    
    // Cari token huruf diikuti alfanumerik/underscore
    const matches = formulaText.match(/\b[A-Za-z][A-Za-z0-9_]*\b/g) || [];
    const uniqueVars = [];
    
    for (const token of matches) {
        if (!RESERVED_WORDS.has(token) && !uniqueVars.includes(token)) {
            uniqueVars.push(token);
        }
    }
    
    return uniqueVars;
}

/**
 * Validasi keseimbangan tanda kurung dan karakter yang diperbolehkan.
 */
export function validateFormulaSyntax(formulaText) {
    if (!formulaText || !formulaText.trim()) {
        return { isValid: true, error: null };
    }

    // 1. Cek tanda kurung
    let depth = 0;
    for (let i = 0; i < formulaText.length; i++) {
        const char = formulaText[i];
        if (char === '(') depth++;
        if (char === ')') depth--;
        if (depth < 0) {
            return { isValid: false, error: 'Terdapat tanda kurung tutup ")" tanpa pembuka "(" di posisi ' + (i + 1) };
        }
    }
    if (depth > 0) {
        return { isValid: false, error: `Ada ${depth} tanda kurung buka "(" yang belum ditutup ")"` };
    }

    // 2. Cek karakter yang tidak diperbolehkan (hanya izinkan variabel, angka, spasi, dan operator aritmatika)
    // Karakter yang diizinkan: A-Z, a-z, 0-9, _, +, -, *, /, (, ), ., ,, %, spasi
    const invalidChars = formulaText.match(/[^A-Za-z0-9_+\-*/().,\s%]/g);
    if (invalidChars && invalidChars.length > 0) {
        const uniqueInvalid = [...new Set(invalidChars)].join(' ');
        return { isValid: false, error: `Karakter tidak valid ditemukan: "${uniqueInvalid}"` };
    }

    return { isValid: true, error: null };
}

/**
 * Evaluasi matematis yang aman (Sandbox)
 * Mengganti variabel dengan nilai angka, sanitasi ketat, lalu hitung hasil.
 */
export function evaluateFormula(formulaText, variableValues = {}) {
    if (!formulaText || !formulaText.trim()) {
        return { success: false, error: 'Rumus belum diisi' };
    }

    // Cek sintaks dasar
    const syntaxCheck = validateFormulaSyntax(formulaText);
    if (!syntaxCheck.isValid) {
        return { success: false, error: syntaxCheck.error };
    }

    // Ambil variabel dari formula
    const vars = extractVariables(formulaText);
    
    // Sort variabel dari nama terpanjang ke terpendek untuk mencegah partial replacement (misal X10 sebelum X1)
    const sortedVars = [...vars].sort((a, b) => b.length - a.length);

    let parsedExpr = formulaText;

    for (const v of sortedVars) {
        const rawVal = variableValues[v];
        if (rawVal === undefined || rawVal === null || rawVal === '') {
            return { success: false, error: `Nilai untuk variabel "${v}" belum dimasukkan` };
        }
        const numVal = Number(String(rawVal).replace(',', '.'));
        if (isNaN(numVal)) {
            return { success: false, error: `Nilai variabel "${v}" harus berupa angka valid` };
        }
        // Ganti token variabel utuh dengan kurung angka
        const regex = new RegExp(`\\b${v}\\b`, 'g');
        parsedExpr = parsedExpr.replace(regex, `(${numVal})`);
    }

    // Ganti koma desimal jika ada menjadi titik
    parsedExpr = parsedExpr.replace(/(\d+),(\d+)/g, '$1.$2');

    // Hapus spasi
    const sanitized = parsedExpr.replace(/\s+/g, '');

    // Pastikan HANYA mengandung angka dan operator aman
    if (!/^[0-9+\-*/().]+$/.test(sanitized)) {
        return { success: false, error: 'Ekspresi matematika mengandung karakter yang tidak dapat dievaluasi' };
    }

    try {
        // Evaluasi aman menggunakan Function constructor dengan konteks terisolasi
        const result = Function(`"use strict"; return (${sanitized});`)();
        
        if (typeof result !== 'number' || isNaN(result)) {
            return { success: false, error: 'Hasil kalkulasi bukan angka yang valid (NaN)' };
        }
        if (!isFinite(result)) {
            return { success: false, error: 'Terjadi pembagian dengan angka nol (nilai tak terhingga)' };
        }

        return { success: true, result };
    } catch (err) {
        return { success: false, error: 'Sintaks rumus belum lengkap atau terjadi kesalahan perhitungan' };
    }
}

/**
 * Hitung capaian persentase terhadap target sesuai aturan SAKIP JAMBIN.
 */
export function calculateCapaianSimulasi(realisasi, target, arahKinerja = 'POSITIF', batasCapaian = null, jumlahDesimal = 2) {
    const numRealisasi = Number(String(realisasi ?? '').replace(',', '.'));
    const numTarget = Number(String(target ?? '').replace(',', '.'));

    if (isNaN(numRealisasi) || isNaN(numTarget) || numTarget <= 0) {
        return { capaian: null, formatted: '-', status: 'Target belum diisi / bernilai 0', color: '#64748b' };
    }

    let capaian = 0;
    const isNegatif = (arahKinerja || '').toUpperCase() === 'NEGATIF';

    if (isNegatif) {
        if (numRealisasi <= 0) {
            capaian = 100;
        } else {
            capaian = (numTarget / numRealisasi) * 100;
        }
    } else {
        capaian = (numRealisasi / numTarget) * 100;
    }

    // Terapkan batas capaian (capping)
    const numBatas = batasCapaian !== null && batasCapaian !== '' ? Number(String(batasCapaian).replace(',', '.')) : null;
    if (numBatas !== null && !isNaN(numBatas) && numBatas > 0) {
        capaian = Math.min(capaian, numBatas);
    }

    const precision = Math.max(0, Math.min(Number(jumlahDesimal) || 2, 4));
    const roundedCapaian = Number(capaian.toFixed(precision));

    let status = 'Tercapai (Memenuhi Target)';
    let color = '#059669'; // hijau

    if (roundedCapaian >= 100) {
        status = 'Tercapai (≥ 100%)';
        color = '#059669';
    } else if (roundedCapaian >= 80) {
        status = 'Mendekati Target (80% - 99%)';
        color = '#d97706'; // amber
    } else {
        status = 'Di Bawah Target (< 80%)';
        color = '#dc2626'; // merah
    }

    return {
        capaian: roundedCapaian,
        formatted: `${roundedCapaian.toLocaleString('id-ID', { minimumFractionDigits: precision, maximumFractionDigits: precision })}%`,
        status,
        color
    };
}
