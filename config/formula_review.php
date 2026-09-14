<?php

// Technical findings from the source audit, not new official formulas.
// Keep input schemas and target values intact while preventing false results.
return [
    'unresolved' => [
        'IKP:5.1' => 'Skala komponen IPA 0-100 belum selaras dengan skala target indeks.',
        'IKP:8.1' => 'Skala Sistem Merit dan target 0,81 perlu rekonsiliasi sumber.',
        'IKP:8.3' => 'Skala komponen profesionalitas dan target 3,7 perlu rekonsiliasi sumber.',
        'IKP:10.1' => 'Skala komponen layanan 0-100 dan target 3,7 perlu rekonsiliasi sumber.',
        'IKP:13.1' => 'Persentase hasil survei dan skala target indeks perlu rekonsiliasi sumber.',
        'IKP:13.2' => 'Persentase hasil survei dan skala target indeks perlu rekonsiliasi sumber.',
        'IKK:1.1.1' => 'Status nilai eksternal atau komponen SAKIP belum diputuskan untuk IKK ini.',
        'IKK:4.1.1' => 'Formula UAPA bertingkat belum memiliki kontrak operand lengkap.',
        'IKK:4.2.1' => 'Komponen dan bobot NKA belum dikonfigurasi.',
        'IKK:5.1.2' => 'Rata-rata dua rasio memerlukan empat operand; perubahan form menunggu keputusan UI.',
        'IKK:8.2.1' => 'Definisi P/S dan komponen KPT perlu rekonsiliasi sumber.',
        'IKK:8.2.2' => 'Rata-rata komponen lintas skala belum direkonsiliasi.',
        'IKK:8.3.1' => 'Polaritas dan perlakuan realisasi nol memerlukan keputusan sumber.',
        'IKK:10.1.1' => 'Survei TS/(R x P x M) belum memiliki empat operand eksplisit.',
        'IKK:10.2.1' => 'Survei TS/(R x P x M) belum memiliki empat operand eksplisit.',
        'IKK:10.3.1' => 'Survei TS/(R x P x M) belum memiliki empat operand eksplisit.',
        'IKK:10.4.1' => 'Survei TS/(R x P x M) belum memiliki empat operand eksplisit.',
        'IKK:10.9.1' => 'Indikator jumlah rumah sakit tidak boleh menjadi rasio generik.',
        'IKK:10.5.1' => 'Rata-rata survei per layanan belum mempunyai kontrak operand.',
        'IKK:10.7.1' => 'Rata-rata rasio layanan tidak sama dengan rasio gabungan.',
        'IKK:10.8.2' => 'Rata-rata skor Likert tidak boleh otomatis dikalikan 100.',
        'IKK:10.9.3' => 'Normalisasi distribusi rating memerlukan kontrak operand.',
        'IKK:10.9.5' => 'Penjumlahan nilai per fasilitas atau total resmi belum diputuskan.',
        'IKK:15.2.3' => 'Sumber indeks dan metode komposit belum diputuskan.',
        'IKK:15.3.1' => 'Sumber indeks kualitas data dan metode komposit belum diputuskan.',
        'IKK:15.3.2' => 'Sumber indeks statistik dan metode komposit belum diputuskan.',
        'IKK:15.4.1' => 'Sumber indeks keamanan dan metode komposit belum diputuskan.',
        'IKK:15.5.1' => 'Rata-rata skor Likert tidak boleh otomatis dikalikan 100.',
    ],
];
