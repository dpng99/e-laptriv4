<?php

namespace Database\Seeders;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\UnitKerja;
use App\Services\Calculation\StatusResolver;
use App\Services\PengukuranService;
use App\Services\TargetResolver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanKinerjaTriwulanII2026Seeder extends Seeder
{
    private const SOURCE_REFERENCE = 'Laporan Kinerja Triwulan II Tahun 2026 Jaksa Agung Muda Bidang Pembinaan';

    private const EVIDENCE_REFERENCE = 'laptriII2026.md (laporan sumber direkonsiliasi pada 16 September 2026)';

    /**
     * Seed reconciled operands as normal DRAFT measurements. Published report
     * values whose canonical operands are incomplete or inconsistent are kept
     * as REPORTED, without inventing raw inputs or overwriting their source.
     */
    public function run(): void
    {
        $calculatedRows = [
            'IKP 4.1' => [
                'unit' => 'RO-KEU',
                'inputs' => ['X1' => 18.70, 'X2' => 99.27],
                'analisis_capaian' => 'Nilai Kinerja Anggaran per 20 Juli 2026 sebesar 58,99, dari nilai perencanaan anggaran 18,70 dan pelaksanaan anggaran 99,27.',
                'kendala' => 'Nilai efisiensi Standar Biaya Keluaran menjadi faktor utama yang belum optimal; nilai NKA masih bergerak sampai batas waktu Kementerian Keuangan.',
                'upaya' => 'Memperkuat pemantauan output, pemahaman penilaian SBK, dan koordinasi satker untuk meningkatkan nilai penggunaan serta efisiensi SBK.',
            ],
            'IKP 6.2' => [
                'unit' => 'RO-REN',
                'inputs' => ['jumlah_satker_patuh' => 389, 'jumlah_satker_dinilai' => 486],
                'analisis_capaian' => 'Data terakhir tahun 2025 yang digunakan pada Triwulan II 2026: 389 dari 486 satker dinyatakan patuh terhadap SOP (80,04%).',
                'kendala' => 'Pemantauan kepatuhan SOP masih menggunakan data terakhir tahun 2025.',
                'upaya' => 'Melanjutkan monitoring, evaluasi, dan tindak lanjut kepatuhan SOP pada satuan kerja.',
            ],
            'IKP 8.2' => [
                'unit' => 'RO-PEG',
                'inputs' => ['KECUKUPAN' => 83.61, 'PENGEMBANGAN' => 84.34, 'PENGELOLAAN' => 82.61],
                'analisis_capaian' => 'Hasil indikator merupakan rata-rata tingkat kecukupan personil 83,61%, pengembangan kapasitas 84,34%, dan pengelolaan SDM 82,61%, yaitu 83,52%.',
                'kendala' => 'Masih terdapat kesenjangan jumlah personil Jaksa terhadap proyeksi kebutuhan organisasi.',
                'upaya' => 'Melanjutkan pemenuhan kebutuhan personil, pengembangan kapasitas, dan penguatan pengelolaan SDM.',
            ],
        ];

        $reportedRows = [
            ['code' => 'IKP 1.1', 'unit' => 'RO-REN', 'realisasi' => 71.27, 'capaian' => 97.63, 'note' => 'Nilai SAKIP hasil evaluasi Kementerian PANRB tahun 2025 yang tetap digunakan sampai evaluasi tahun 2026 tersedia.'],
            ['code' => 'IKP 5.1', 'unit' => 'RO-KAP', 'realisasi' => 3.75, 'capaian' => 104.17, 'note' => 'Nilai IPA tahun 2025 yang masih digunakan pada Triwulan II 2026 karena belum terdapat penilaian terbaru.'],
            ['code' => 'IKP 5.2', 'unit' => 'RO-KAP', 'realisasi' => 88.34, 'capaian' => 97.61, 'note' => 'Nilai ITKP tahun 2025 yang digunakan sebagai acuan karena indeks tahun 2026 belum tersedia.'],
            ['code' => 'IKP 6.1', 'unit' => 'RO-REN', 'realisasi' => 80.03, 'capaian' => 98.80, 'note' => 'Baseline hasil evaluasi kelembagaan tahun 2024 yang masih digunakan karena evaluasi berikutnya dijadwalkan tahun 2027.'],
            ['code' => 'IKP 7.1', 'unit' => 'RO-HUK-HLN', 'realisasi' => 80.04, 'capaian' => 114.34, 'note' => 'Nilai Indeks Kualitas Kebijakan instansi berdasarkan penilaian LAN RI; operand canonical lima dimensi tidak tersedia lengkap pada laporan.'],
            ['code' => 'IKP 7.2', 'unit' => 'RO-HUK-HLN', 'realisasi' => 98.10, 'capaian' => 99.90, 'note' => 'Nilai akhir Indeks Reformasi Hukum tahun 2025, kategori AA/Istimewa, yang digunakan sampai evaluasi tahunan berikutnya tersedia.'],
            ['code' => 'IKP 8.1', 'unit' => 'RO-PEG', 'realisasi' => 0.82, 'capaian' => 101.23, 'note' => 'Indeks Sistem Merit setara 0,82, berdasarkan penilaian tahun 2023 yang masih dipakai pada masa transisi penilaian.'],
            ['code' => 'IKP 8.3', 'unit' => 'RO-PEG', 'realisasi' => 3.30, 'capaian' => 89.19, 'note' => 'Nilai Indeks Profesionalitas SDM yang dilaporkan adalah 82,98 pada skala 100 atau setara 3,319 pada skala 4; empat dimensi berbobot canonical tidak tersedia.'],
            ['code' => 'IKP 10.1', 'unit' => 'RO-REN', 'realisasi' => 3.70, 'capaian' => 100.00, 'note' => 'Laporan mencatat rata-rata indeks layanan 94,33% atau 3,77 pada skala 4, sedangkan matriks menetapkan hasil 3,70; delapan komponen canonical tidak tersedia lengkap.'],
            ['code' => 'IKP 10.2', 'unit' => 'PKY', 'realisasi' => 98.25, 'capaian' => 115.59, 'note' => 'Laporan mencatat indeks 98,25%; pembagian skor tertulis 1.060/1.080 menghasilkan 98,15%, sehingga nilai laporan dipertahankan tanpa memasukkan operand yang bertentangan.'],
            ['code' => 'IKP 11.1', 'unit' => 'RO-PEG', 'realisasi' => 47.18, 'capaian' => 62.91, 'note' => 'Nilai competency fit index yang dicantumkan pada matriks; angka pembilang dan penyebut di uraian menghasilkan nilai berbeda.'],
            ['code' => 'IKP 11.2', 'unit' => 'RO-PEG', 'realisasi' => 71.50, 'capaian' => 110.00, 'note' => 'Nilai sertifikasi kompetensi yang dilaporkan; empat jumlah sumber menghasilkan hasil berbeda apabila rasio dihitung tanpa pembulatan antara.'],
            ['code' => 'IKP 13.1', 'unit' => 'RO-HUK-HLN', 'realisasi' => 4.00, 'capaian' => 108.11, 'note' => 'Rata-rata NRR layanan hukum yang dilaporkan adalah 4,00 pada skala 1 sampai 4; total skor survei canonical tidak tersedia.'],
            ['code' => 'IKP 13.2', 'unit' => 'RO-HUK-HLN', 'realisasi' => 3.71, 'capaian' => 100.27, 'note' => 'Rata-rata NRR kepuasan institusi mitra luar negeri yang dilaporkan adalah 3,71; laporan menyatakan nilai masih bersumber dari Triwulan IV 2025.'],
            ['code' => 'IKP 15.1', 'unit' => 'PUSDASKRIMTI', 'realisasi' => 100.00, 'capaian' => 117.65, 'note' => 'Laporan menghitung 4 dari 4 proses bisnis terdigitalisasi, sementara bagian lain menjelaskan 10 proses bisnis inti; nilai publikasi dipertahankan sampai denominator resmi direkonsiliasi.'],
            ['code' => 'IKP 16.1', 'unit' => 'RO-KAP', 'realisasi' => 87.90, 'capaian' => 107.20, 'note' => 'Laporan mencatat utilisasi 87,90%; penjumlahan angka pada tabel BMN menghasilkan 496.724/565.190 atau 87,89%, sehingga nilai publikasi dipertahankan tanpa mengasumsikan komponen yang hilang.'],
        ];

        $reportedNarratives = [
            'IKP 1.1' => ['kendala' => 'Pemahaman SAKIP belum merata, kualitas perencanaan belum sepenuhnya berorientasi hasil, budaya kinerja dan integrasi sistem informasi masih perlu diperkuat.', 'upaya' => 'Melakukan sosialisasi SAKIP, memperbaiki dokumen perencanaan, memperkuat budaya kinerja dan SDM perencana, serta menyempurnakan aplikasi SICANA.'],
            'IKP 5.1' => ['kendala' => 'Masih ada tindak lanjut rekomendasi BPK atas BMN, status penggunaan dan sertifikasi tanah belum lengkap, serta BMN rusak berat belum dihapuskan.', 'upaya' => 'Mengawasi penetapan status penggunaan, tindak lanjut persetujuan pengelolaan, sertifikasi BMN, dan penghapusan BMN rusak berat.'],
            'IKP 5.2' => ['kendala' => 'Jumlah SDM Kejaksaan untuk menjalankan peran pelaku pengadaan pada seluruh satuan kerja masih terbatas.', 'upaya' => 'Memantau tiap subindikator ITKP serta mendorong peningkatan kompetensi dan sertifikasi pelaku pengadaan di satker pusat maupun daerah.'],
            'IKP 6.1' => ['kendala' => 'Struktur dan nomenklatur unit, kebutuhan jabatan fungsional, pembaruan SOP, serta pemutakhiran data kelembagaan masih perlu disempurnakan.', 'upaya' => 'Menghimpun usulan perubahan Ortaker, melakukan telaah dan harmonisasi internal, memperbarui SOP, dan memperkuat kualitas data kelembagaan.'],
            'IKP 7.1' => ['kendala' => 'Laporan tidak menguraikan hambatan operasional khusus; hasil penilaian indeks masih bergantung pada evaluasi instansi pembina.', 'upaya' => 'Menindaklanjuti hasil penilaian dan menyiapkan data dukung untuk evaluasi indeks berikutnya.'],
            'IKP 7.2' => ['kendala' => 'Rekomendasi penilaian masih menyoroti kompetensi perancang peraturan dan pengelolaan JDIH.', 'upaya' => 'Menindaklanjuti rekomendasi Kementerian Hukum melalui penguatan kompetensi perancang dan pembenahan pengelolaan JDIH.'],
            'IKP 8.1' => ['kendala' => 'Belum ada pembaruan hasil monitoring dan evaluasi resmi Sistem Merit pada masa transisi penilaian KASN ke BKN.', 'upaya' => 'Memantau penerbitan hasil penilaian resmi dan menyiapkan data dukung manajemen ASN untuk evaluasi berikutnya.'],
            'IKP 8.3' => ['kendala' => 'Nilai profesionalitas masih berasal dari penilaian terdahulu dan rincian empat dimensi berbobot tidak tersedia pada laporan.', 'upaya' => 'Memutakhirkan data kualifikasi, kompetensi, kinerja, dan disiplin untuk penilaian profesionalitas berikutnya.'],
            'IKP 10.1' => ['kendala' => 'Laporan menyebut enam layanan, tetapi hanya menyajikan tiga hasil layanan dan tidak menyediakan delapan komponen canonical lengkap.', 'upaya' => 'Melengkapi cakupan survei serta data komponen layanan agar pengukuran berikutnya dapat direkonsiliasi.'],
            'IKP 10.2' => ['kendala' => 'Jumlah responden survei masih terbatas dan angka skor sumber tidak konsisten dengan hasil persentase yang dipublikasikan.', 'upaya' => 'Memperluas responden, menjaga mutu layanan, dan memverifikasi total skor survei sebelum pelaporan berikutnya.'],
            'IKP 11.1' => ['kendala' => 'Angka pembilang dan penyebut pada uraian laporan belum konsisten dengan hasil competency fit index yang dicantumkan.', 'upaya' => 'Memverifikasi basis data kompetensi dan menghitung ulang indikator dari data sumber yang telah divalidasi.'],
            'IKP 11.2' => ['kendala' => 'Hasil dari empat angka sertifikasi berbeda apabila dihitung tanpa pembulatan antara.', 'upaya' => 'Mendokumentasikan aturan pembulatan dan memverifikasi data sertifikasi Jaksa maupun ASN non-Jaksa sebelum publikasi.'],
            'IKP 13.1' => ['kendala' => 'Laporan tidak menguraikan hambatan khusus; seluruh unsur survei dicatat dengan nilai maksimal.', 'upaya' => 'Mempertahankan mutu layanan hukum dan melanjutkan survei kepuasan sesuai instrumen yang berlaku.'],
            'IKP 13.2' => ['kendala' => 'Nilai masih mengacu pada laporan Triwulan IV 2025 karena pengukuran indeks dilakukan tahunan.', 'upaya' => 'Menyiapkan pengumpulan serta validasi data survei untuk pembaruan nilai pada evaluasi tahunan berikutnya.'],
            'IKP 15.1' => ['kendala' => 'Denominator proses bisnis inti tidak konsisten: laporan menggunakan 4 proses, sedangkan uraian lain menyebut 10 proses.', 'upaya' => 'Merekonsiliasi daftar dan denominator proses bisnis inti dengan dokumen resmi sebelum pengukuran berikutnya.'],
            'IKP 16.1' => ['kendala' => 'Masih terdapat BMN rusak berat yang belum dihapuskan, BMN rusak ringan yang belum atau tidak ekonomis diperbaiki, serta perencanaan kebutuhan BMN belum tertata optimal.', 'upaya' => 'Mengumpulkan data kebutuhan BMN secara bertahap per jenis dan mengoordinasikan hasil analisis kebutuhan dengan perencanaan anggaran serta pengadaan.'],
        ];

        $service = app(PengukuranService::class);
        $targets = app(TargetResolver::class);
        $statusResolver = app(StatusResolver::class);

        DB::transaction(function () use ($calculatedRows, $reportedRows, $reportedNarratives, $service, $targets, $statusResolver): void {
            foreach ($calculatedRows as $code => $row) {
                $node = KinerjaNode::query()->where('kode', $code)->firstOrFail();
                $unit = UnitKerja::query()->where('kode', $row['unit'])->firstOrFail();

                $service->storeMeasurement($node, $unit->id, 2026, 2, [
                    'inputs' => $row['inputs'],
                    'analisis_capaian' => $row['analisis_capaian'],
                    'kendala' => $row['kendala'],
                    'upaya' => $row['upaya'],
                    'source_reference' => self::SOURCE_REFERENCE,
                    'evidence_reference' => self::EVIDENCE_REFERENCE,
                ], 'laptri-ii-2026-seeder');
            }

            foreach ($reportedRows as $row) {
                $row = array_merge($reportedNarratives[$row['code']], $row);
                $node = KinerjaNode::query()->where('kode', $row['code'])->with('formulas')->firstOrFail();
                $unit = UnitKerja::query()->where('kode', $row['unit'])->firstOrFail();
                $target = $targets->resolve($node->id, 2026, 2);
                $formula = $node->formulas->where('is_active', true)->sortByDesc('versi')->first();

                Pengukuran::query()->updateOrCreate(
                    [
                        'node_id' => $node->id,
                        'unit_kerja_id' => $unit->id,
                        'tahun' => 2026,
                        'triwulan' => 2,
                    ],
                    [
                        'target_id' => $target?->id,
                        'realisasi' => $row['realisasi'],
                        'capaian' => $row['capaian'],
                        'target_snapshot' => $target?->nilai_target,
                        'formula_key_snapshot' => $node->formula_key,
                        'formula_version_snapshot' => $formula ? (string) $formula->versi : null,
                        'status_capaian' => $statusResolver->resolve($row['capaian'], 2, $row['realisasi']),
                        'status' => 'REPORTED',
                        'source_reference' => self::SOURCE_REFERENCE,
                        'evidence_reference' => self::EVIDENCE_REFERENCE,
                        'analisis_capaian' => $row['note'],
                        'kendala' => $row['kendala'],
                        'upaya' => $row['upaya'],
                        'calculation_trace' => [
                            'import_mode' => 'REPORTED',
                            'reported_realisasi' => $row['realisasi'],
                            'reported_capaian' => $row['capaian'],
                            'note' => $row['note'],
                            'imported_at' => now()->toIso8601String(),
                        ],
                        'created_by' => 'laptri-ii-2026-seeder',
                        'updated_by' => 'laptri-ii-2026-seeder',
                    ],
                );
            }
        });
    }
}
