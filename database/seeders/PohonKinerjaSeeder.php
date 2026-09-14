<?php

namespace Database\Seeders;

use App\Models\PohonKinerja;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PohonKinerjaSeeder extends Seeder
{
    public function run(): void
    {
        // Data Pohon Kinerja berdasarkan Cetak Biru Cascading SAKIP & Renstra Kejaksaan RI 2025-2029 (Restrukturisasi v2)
        $data = [
            // ==========================================
            // SP 1: Meningkatnya akuntabilitas kinerja Kejaksaan RI
            // ==========================================
            [
                'level' => 'SASARAN_PROGRAM', 'kode_indikator' => 'SP 1', 'nama_kinerja' => 'Meningkatnya akuntabilitas kinerja Kejaksaan RI', 'unit_pengampu' => 'Jaksa Agung Muda Bidang Pembinaan (Kolaborasi Lintas UKE I)',
                'children' => [
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 1.1', 'nama_kinerja' => 'Nilai SAKIP Kejaksaan RI', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Hasil Evaluasi (LHE) AKIP Kementerian PANRB',
                        'children' => [
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 1.1.1', 'nama_kinerja' => 'Terwujudnya Perencanaan, Pemantauan, Evaluasi, dan Reformasi Birokrasi yang Efektif', 'unit_pengampu' => 'Biro Perencanaan',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 1.1.1.1', 'nama_kinerja' => 'Persentase layanan reformasi birokrasi sesuai SLA', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah layanan fasilitasi dan koordinasi Reformasi Birokrasi yang selesai tepat waktu sesuai SLA', 'nama_penyebut' => 'Total target layanan atau dokumen Reformasi Birokrasi wajib dalam setahun', 'sumber_data' => 'Log Sistem Informasi Reformasi Birokrasi / Biro Perencanaan'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 1.1.1.2', 'nama_kinerja' => 'Persentase satker Kejaksaan RI yang mendapat pendampingan pembangunan zona integritas menuju WBK/WBBM', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah satuan kerja (Kejati/Kejari/Cabjari) yang selesai didampingi dalam pembangunan ZI oleh Tim Kerja Biro Perencanaan', 'nama_penyebut' => 'Total seluruh satuan kerja Kejaksaan RI yang diusulkan dan menjadi target pendampingan pembangunan ZI', 'sumber_data' => 'Laporan Pendampingan ZI Biro Perencanaan'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 1.1.1.3', 'nama_kinerja' => 'Persentase layanan pemantauan dan evaluasi sesuai SLA', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah laporan pemantauan dan evaluasi kinerja yang selesai disusun tepat waktu sesuai SLA', 'nama_penyebut' => 'Total target laporan pemantauan dan evaluasi kinerja wajib (Laporan Triwulanan, Tahunan, LKjIP)', 'sumber_data' => 'Laporan Monev Kinerja Triwulanan (Sistem SICANA)'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 1.1.1.4', 'nama_kinerja' => 'Persentase layanan pengelolaan data kinerja sesuai SLA', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah permintaan layanan data kinerja dan perencanaan yang diselesaikan tepat waktu sesuai SLA', 'nama_penyebut' => 'Total seluruh berkas permohonan layanan pengelolaan data perencanaan dan kinerja yang masuk', 'sumber_data' => 'Log Layanan Data Seksi Kinerja Biro Perencanaan'],
                                ]
                            ],
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 1.1.2', 'nama_kinerja' => 'Terwujudnya Evaluasi Akuntabilitas Kinerja Internal Instansi', 'unit_pengampu' => 'Biro Perencanaan',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 1.1.2.1', 'nama_kinerja' => 'Nilai SAKIP UKE I Kejaksaan RI', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'INDEX_SCORE', 'nama_pembilang' => 'Jumlah total skor hasil evaluasi SAKIP internal dari seluruh Unit Kerja Eselon I Kejaksaan RI (9 UKE I)', 'nama_penyebut' => '9', 'sumber_data' => 'Laporan Hasil Evaluasi (LHE) AKIP internal tingkat UKE I yang diterbitkan oleh Jaksa Agung Muda Bidang Pengawasan'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 1.1.2.2', 'nama_kinerja' => 'Nilai SAKIP Kejaksaan Tinggi/Kejaksaan Negeri/Cabang Kejaksaan Negeri', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'INDEX_SCORE', 'nama_pembilang' => 'Jumlah total skor hasil evaluasi SAKIP internal dari seluruh satuan kerja daerah (Kejati, Kejari, Cabjari)', 'nama_penyebut' => 'Total jumlah satuan kerja daerah yang dievaluasi kinerjanya', 'sumber_data' => 'LHE SAKIP Satker Daerah dari Bidang Pengawasan Daerah/Pusat'],
                                ]
                            ],
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 1.1.3', 'nama_kinerja' => 'Meningkatnya Kualitas Perencanaan Kejaksaan RI', 'unit_pengampu' => 'Biro Perencanaan',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 1.1.3.1', 'nama_kinerja' => 'Indeks Perencanaan Pembangunan Nasional (IPPN)', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Hasil Evaluasi IPPN Tingkat Kelembagaan dari Kementerian PPN/Bappenas'],
                                ]
                            ],
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 1.1.4', 'nama_kinerja' => 'Meningkatnya Kualitas Tata Kelola Organisasi Kejaksaan yang Tepat Fungsi', 'unit_pengampu' => 'Biro Perencanaan',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 1.1.4.1', 'nama_kinerja' => 'Persentase Penyelesaian Restrukturisasi Organisasi', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah draf naskah usulan penataan struktur organisasi baru yang disetujui oleh KemenPAN-RB', 'nama_penyebut' => 'Total target restrukturisasi organisasi Kejaksaan RI yang diamanatkan dalam Renstra', 'sumber_data' => 'Dokumen Usulan Penataan Organisasi Biro Perencanaan'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 1.1.4.2', 'nama_kinerja' => 'Tingkat Realisasi Rencana Aksi RB General Kejaksaan RI', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah program rencana aksi Reformasi Birokrasi (RB) General yang berhasil direalisasikan', 'nama_penyebut' => 'Total seluruh target rencana aksi RB General Kejaksaan RI tahun berjalan', 'sumber_data' => 'Portal Penilaian Mandiri Pelaksanaan Reformasi Birokrasi (PMPRB) KemenPAN-RB'],
                                ]
                            ],
                        ]
                    ]
                ]
            ],

            // ==========================================
            // SP 4: Meningkatnya efisiensi dan efektivitas penggunaan anggaran Kejaksaan RI
            // ==========================================
            [
                'level' => 'SASARAN_PROGRAM', 'kode_indikator' => 'SP 4', 'nama_kinerja' => 'Meningkatnya efisiensi dan efektivitas penggunaan anggaran Kejaksaan RI', 'unit_pengampu' => 'Jaksa Agung Muda Bidang Pembinaan (JAMBIN)',
                'children' => [
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 4.1', 'nama_kinerja' => 'Nilai Kinerja Anggaran Kejaksaan RI', 'unit_pengampu' => 'Biro Keuangan', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Aplikasi Monev Kemenkeu (SMART Kemenkeu & OM-SPAN)',
                        'children' => [
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 4.1.1', 'nama_kinerja' => 'Meningkatnya efisiensi dan efektivitas Perencanaan dan penggunaan anggaran Kejaksaan UKE I', 'unit_pengampu' => 'Biro Keuangan',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 4.1.1.1', 'nama_kinerja' => 'NKA UKE I', 'unit_pengampu' => 'Biro Keuangan', 'tipe_formula' => 'INDEX_SCORE', 'nama_pembilang' => 'Akumulasi rata-rata Nilai Kinerja Pelaksanaan Anggaran (IKPA) + Rata-rata Nilai Kinerja Anggaran (NKPA) dari seluruh UKE I', 'nama_penyebut' => 'Target Nilai Kinerja Anggaran Eselon I', 'sumber_data' => 'Portal Sistem Informasi SMART/Monev Anggaran Kementerian Keuangan'],
                                ]
                            ],
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 4.1.2', 'nama_kinerja' => 'Meningkatnya efisiensi dan efektivitas Perencanaan dan penggunaan anggaran di Daerah', 'unit_pengampu' => 'Biro Keuangan',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 4.1.2.1', 'nama_kinerja' => 'NKA Kejaksaan Tinggi/Kejaksaan Negeri/Cabang Kejaksaan Negeri', 'unit_pengampu' => 'Biro Keuangan', 'tipe_formula' => 'INDEX_SCORE', 'nama_pembilang' => 'Akumulasi rata-rata Nilai Kinerja Pelaksanaan Anggaran (IKPA) + Rata-rata Nilai Kinerja Anggaran (NKPA) dari satker daerah', 'nama_penyebut' => 'Target Nilai Kinerja Anggaran satker daerah', 'sumber_data' => 'Portal Aplikasi OM-SPAN & SAKTI Kemenkeu tingkat Satker Daerah'],
                                ]
                            ]
                        ]
                    ]
                ]
            ],

            // ==========================================
            // SP 5: Meningkatnya kualitas tata kelola aset dan pengadaan Kejaksaan RI
            // ==========================================
            [
                'level' => 'SASARAN_PROGRAM', 'kode_indikator' => 'SP 5', 'nama_kinerja' => 'Meningkatnya kualitas tata kelola aset dan pengadaan Kejaksaan RI', 'unit_pengampu' => 'Jaksa Agung Muda Bidang Pembinaan (JAMBIN)',
                'children' => [
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 5.1', 'nama_kinerja' => 'Indeks Pengelolaan Aset Kejaksaan RI', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Indeks Pengelolaan Aset (IPA) Kementerian Keuangan',
                        // IKP Mandiri (Leaf Node) - Tidak ada SK/IKK di bawahnya
                    ],
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 5.2', 'nama_kinerja' => 'Indeks Tata Kelola Pengadaan Kejaksaan RI', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Portal ITKP LKPP',
                        // IKP Mandiri (Leaf Node) - Tidak ada SK/IKK di bawahnya
                    ]
                ]
            ],

            // ==========================================
            // SP 6: Meningkatnya kapasitas kelembagaan dan ketatalaksanaan Kejaksaan RI
            // ==========================================
            [
                'level' => 'SASARAN_PROGRAM', 'kode_indikator' => 'SP 6', 'nama_kinerja' => 'Meningkatnya kapasitas kelembagaan dan ketatalaksanaan Kejaksaan RI', 'unit_pengampu' => 'Jaksa Agung Muda Bidang Pembinaan (JAMBIN)',
                'children' => [
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 6.1', 'nama_kinerja' => 'Nilai Evaluasi Kelembagaan Kejaksaan RI', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Hasil Evaluasi Tata Kelola Kelembagaan KemenPAN-RB',
                        // IKP Mandiri (Leaf Node) - Tidak ada SK/IKK di bawahnya
                    ],
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 6.2', 'nama_kinerja' => 'Tingkat kepatuhan satuan kerja terhadap standar operasional prosedur', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'sumber_data' => 'Laporan Inspeksi Pemenuhan SOP Kejaksaan RI oleh JAMWAS',
                        'children' => [
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 6.2.1', 'nama_kinerja' => 'Meningkatnya kualitas Tata Kelola Organisasi UKE I Kejaksaan yang tepat fungsi', 'unit_pengampu' => 'Biro Perencanaan',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 6.2.1.1', 'nama_kinerja' => 'Persentase implementasi RB UKE I berdasarkan Rencana Aksi RB Tematik', 'unit_pengampu' => 'Biro Perencanaan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah program rencana aksi Reformasi Birokrasi (RB) Tematik yang berhasil diimplementasikan', 'nama_penyebut' => 'Total seluruh target rencana aksi RB Tematik nasional', 'sumber_data' => 'Laporan Pelaksanaan RB Tematik Biro Perencanaan'],
                                ]
                            ]
                        ]
                    ]
                ]
            ],

            // ==========================================
            // SP 7: Meningkatnya kualitas kebijakan penegakan hukum
            // ==========================================
            [
                'level' => 'SASARAN_PROGRAM', 'kode_indikator' => 'SP 7', 'nama_kinerja' => 'Meningkatnya kualitas kebijakan penegakan hukum', 'unit_pengampu' => 'Jaksa Agung Muda Bidang Pembinaan (JAMBIN)',
                'children' => [
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 7.1', 'nama_kinerja' => 'Indeks Kualitas Kebijakan Kejaksaan RI', 'unit_pengampu' => 'Pustrajakgakum', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Hasil Pengukuran Indeks Kualitas Kebijakan (IKK) oleh Lembaga Administrasi Negara (LAN RI)',
                        // IKP Mandiri (Leaf Node) - Tidak ada SK/IKK di bawahnya
                    ],
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 7.2', 'nama_kinerja' => 'Indeks Reformasi Hukum pada Kejaksaan RI', 'unit_pengampu' => 'Biro Hukum dan Hubungan Luar Negeri', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Evaluasi Indeks Reformasi Hukum Kejaksaan RI dari Kemenkumham',
                        // IKP Mandiri (Leaf Node) - Tidak ada SK/IKK di bawahnya
                    ]
                ]
            ],

            // ==========================================
            // SP 8: Meningkatnya kuantitas dan kualitas SDM aparatur Kejaksaan RI
            // ==========================================
            [
                'level' => 'SASARAN_PROGRAM', 'kode_indikator' => 'SP 8', 'nama_kinerja' => 'Meningkatnya kuantitas dan kualitas SDM aparatur Kejaksaan RI', 'unit_pengampu' => 'Jaksa Agung Muda Bidang Pembinaan (JAMBIN)',
                'children' => [
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 8.1', 'nama_kinerja' => 'Indeks Sistem Merit Kejaksaan RI', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Hasil Evaluasi Sistem Merit Kejaksaan RI oleh BKN',
                        // IKP Mandiri (Leaf Node) - Tidak ada SK/IKK di bawahnya
                    ],
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 8.2', 'nama_kinerja' => 'Persentase kecukupan, kesesuaian, dan pengembangan SDM Kejaksaan RI', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'RATIO_PERCENTAGE', 'sumber_data' => 'Analisis Kepegawaian Aplikasi MySimkari',
                        // IKP Mandiri (Leaf Node) - Tidak ada SK/IKK di bawahnya
                    ],
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 8.3', 'nama_kinerja' => 'Indeks Profesionalitas SDM Kejaksaan RI', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Hasil Pengukuran Indeks Profesionalitas ASN (IP-ASN) Kejaksaan RI oleh BKN',
                        'children' => [
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 8.1.1', 'nama_kinerja' => 'Meningkatnya Kegiatan Pembinaan dan Pengelolaan Kepegawaian di Kejaksaan RI', 'unit_pengampu' => 'Biro Kepegawaian',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 8.1.1.1', 'nama_kinerja' => 'Persentase layanan umum kepegawaian sesuai SLA', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah berkas administrasi umum pegawai selesai diproses tepat SLA', 'nama_penyebut' => 'Total seluruh usulan administrasi umum kepegawaian diajukan', 'sumber_data' => 'Database SIMPEG Aplikasi MySimkari Biro Kepegawaian'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 8.1.1.2', 'nama_kinerja' => 'Persentase layanan pengembangan kepegawaian sesuai SLA', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah berkas tugas belajar, izin belajar, dan UPA selesai tepat SLA', 'nama_penyebut' => 'Total seluruh berkas administrasi pengembangan karir diajukan', 'sumber_data' => 'Modul Pengembangan Karir MySimkari'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 8.1.1.3', 'nama_kinerja' => 'Persentase layanan kepangkatan dan mutasi kepegawaian sesuai SLA', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah draf SK kenaikan pangkat dan nota usul mutasi disahkan tepat SLA', 'nama_penyebut' => 'Total seluruh usulan kenaikan pangkat dan mutasi berkas lengkap', 'sumber_data' => 'Integrasi Sistem MySimkari dan SIASN BKN'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 8.1.1.4', 'nama_kinerja' => 'Persentase layanan pemberhentian dan pensiun sesuai SLA', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah penetapan SK pensiun selesai diproses tepat SLA', 'nama_penyebut' => 'Total berkas pegawai mencapai BUP wajib lapor', 'sumber_data' => 'Modul Layanan Pensiun Taspen / MySimkari'],
                                ]
                            ],
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 8.2.1', 'nama_kinerja' => 'Meningkatnya kecukupan dan kesesuaian SDM Kejaksaan RI', 'unit_pengampu' => 'Biro Kepegawaian',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 8.2.1.1', 'nama_kinerja' => 'Tingkat Kecukupan Personil Jaksa', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah riil personil Jaksa aktif eksisting secara nasional', 'nama_penyebut' => 'Jumlah ideal formasi kebutuhan Jaksa nasional', 'sumber_data' => 'Buku Bezetting Pegawai Biro Kepegawaian'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 8.2.1.2', 'nama_kinerja' => 'Tingkat kesesuaian pengelolaan SDM Jaksa', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah instrumen pengelolaan SDM Jaksa sesuai standar regulasi', 'nama_penyebut' => 'Total seluruh instrumen standar pengelolaan kompetensi Jaksa', 'sumber_data' => 'Laporan Evaluasi Pengelolaan Jabatan Fungsional Jaksa'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 8.2.1.3', 'nama_kinerja' => 'Tingkat kesesuaian kompetensi pegawai terhadap persyaratan kompetensi jabatan', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah pegawai yang memiliki kompetensi aktual sesuai dengan syarat jabatan', 'nama_penyebut' => 'Total seluruh pegawai yang telah mengikuti asesmen profil kompetensi', 'sumber_data' => 'Database Hasil Asesmen Profil Kompetensi MySimkari'],
                                ]
                            ],
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 8.3.1', 'nama_kinerja' => 'Meningkatnya kualitas pengelolaan dan pengembangan SDM Kejaksaan RI yang efektif', 'unit_pengampu' => 'Biro Kepegawaian',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 8.3.1.1', 'nama_kinerja' => 'Tingkat Pengembangan Kapasitas personil Jaksa', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah Jaksa yang telah mengikuti diklat teknis/pengembangan kompetensi min 20 JP', 'nama_penyebut' => 'Total keseluruhan jumlah Jaksa aktif eksisting nasional', 'sumber_data' => 'Register Pendidikan dan Pelatihan MySimkari'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 8.3.1.2', 'nama_kinerja' => 'Persentase SDM Kejaksaan RI yang telah memiliki sertifikat sesuai standar kompetensi', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah pegawai Kejaksaan yang memiliki sertifikat kompetensi keahlian spesifik yang sah', 'nama_penyebut' => 'Total seluruh SDM Kejaksaan RI wajib sertifikasi fungsional keahlian', 'sumber_data' => 'Bank Data Sertifikat Pegawai Biro Kepegawaian'],
                                ]
                            ],
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 8.5.1', 'nama_kinerja' => 'Meningkatnya kualitas ASN Kejaksaan yang berakhlak', 'unit_pengampu' => 'Biro Kepegawaian',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 8.5.1.1', 'nama_kinerja' => 'Indeks Kepuasan Pegawai terhadap Layanan Manajemen ASN', 'unit_pengampu' => 'Biro Kepegawaian', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Hasil Survei Kepuasan Manajemen Internal Biro Kepegawaian'],
                                ]
                            ],
                        ]
                    ]
                ]
            ],

            // ==========================================
            // SP 10: Meningkatnya kualitas layanan internal dukungan manajemen dan kesehatan yustisial
            // ==========================================
            [
                'level' => 'SASARAN_PROGRAM', 'kode_indikator' => 'SP 10', 'nama_kinerja' => 'Meningkatnya kualitas layanan internal dukungan manajemen dan kesehatan yustisial', 'unit_pengampu' => 'Jaksa Agung Muda Bidang Pembinaan (JAMBIN)',
                'children' => [
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 10.1', 'nama_kinerja' => 'Indeks kepuasan layanan dukungan internal manajemen Kejaksaan RI', 'unit_pengampu' => 'Sekretariat JAMBIN', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Hasil Survei Kepuasan Kesekretariatan Internal Kejaksaan',
                        // IKP Mandiri (Leaf Node) - Tidak ada SK/IKK di bawahnya
                    ],
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 10.2', 'nama_kinerja' => 'Tingkat kepuasan Stakeholder terhadap Rumah Sakit Adhyaksa, Klinik Adhyaksa, dan Fasilitas Kesehatan Yustisial lainnya', 'unit_pengampu' => 'Pusat Kesehatan Yustisial (PKY)', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Hasil Kuesioner Kepuasan Stakeholder Kesehatan Yustisial',
                        'children' => [
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 10.2.1', 'nama_kinerja' => 'Meningkatnya kualitas penyelenggaraan kegiatan kesehatan yustisial', 'unit_pengampu' => 'Pusat Kesehatan Yustisial (PKY)',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 10.2.1.1', 'nama_kinerja' => 'Persentase pemenuhan target Indikator Nasional Mutu Pelayanan Kesehatan di Rumah Sakit Adhyaksa', 'unit_pengampu' => 'Pusat Kesehatan Yustisial (PKY)', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah parameter nasional mutu pelayanan kesehatan di RS Adhyaksa memenuhi standar', 'nama_penyebut' => 'Total seluruh INM Pelayanan Kesehatan wajib dari Kemenkes', 'sumber_data' => 'Portal Indikator Mutu RS Adhyaksa / Aplikasi Mutu Kemenkes'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 10.2.1.2', 'nama_kinerja' => 'Tingkat pemahaman para stakeholder terhadap tugas dan fungsi Pusat Kesehatan Yustisial', 'unit_pengampu' => 'Pusat Kesehatan Yustisial (PKY)', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah responden stakeholder yustisial yang paham peran PKY dalam pembuktian hukum', 'nama_penyebut' => 'Total responden survei yang mengisi kuesioner', 'sumber_data' => 'Hasil Survei Pemahaman Stakeholder Yustisial PKY'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 10.2.1.3', 'nama_kinerja' => 'Persentase pemenuhan Hospital Safety Index di Rumah Sakit Adhyaksa', 'unit_pengampu' => 'Pusat Kesehatan Yustisial (PKY)', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Skor aktual penilaian Hospital Safety Index RS Adhyaksa', 'nama_penyebut' => 'Skor ideal maksimal standar keselamatan rumah sakit Kemenkes', 'sumber_data' => 'Laporan Penilaian MFK Akreditasi RS Adhyaksa'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 10.2.1.4', 'nama_kinerja' => 'Jumlah kegiatan pelayanan kesehatan yustisial pada Rumah Sakit Adhyaksa, Klinik Adhyaksa, dan Fasilitas Kesehatan Yustisial lainnya', 'unit_pengampu' => 'Pusat Kesehatan Yustisial (PKY)', 'tipe_formula' => 'RATIO_PERCENTAGE', 'sumber_data' => 'Berkas Register Tindakan Medis SIMRS Adhyaksa'],
                                ]
                            ]
                        ]
                    ]
                ]
            ],

            // ==========================================
            // SP 13: Meningkatnya Kualitas Layanan Hukum dan Hubungan Luar Negeri
            // ==========================================
            [
                'level' => 'SASARAN_PROGRAM', 'kode_indikator' => 'SP 13', 'nama_kinerja' => 'Meningkatnya Kualitas Layanan Hukum dan Hubungan Luar Negeri', 'unit_pengampu' => 'Jaksa Agung Muda Bidang Pembinaan (JAMBIN)',
                'children' => [
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 13.1', 'nama_kinerja' => 'Indeks kepuasan satker Kejaksaan atas layanan hukum', 'unit_pengampu' => 'Biro Hukum dan Hubungan Luar Negeri', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Hasil Evaluasi Pelayanan Hukum Biro Hukum & HLN',
                        // IKP Mandiri (Leaf Node) - Tidak ada SK/IKK di bawahnya
                    ],
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 13.2', 'nama_kinerja' => 'Indeks kepuasan institusi mitra luar negeri terhadap kualitas kerja sama kelembagaan Kejaksaan RI', 'unit_pengampu' => 'Biro Hukum dan Hubungan Luar Negeri', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Dokumen Lembar Umpan Balik (Feedback Sheet) dari Mitra Asing',
                        'children' => [
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 13.2.1', 'nama_kinerja' => 'Meningkatnya pelaksanaan kegiatan pelayanan penyusunan rancangan peraturan perundang-undangan, pertimbangan hukum, kerja sama dan hubungan luar negeri', 'unit_pengampu' => 'Biro Hukum dan Hubungan Luar Negeri',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 13.2.1.1', 'nama_kinerja' => 'Persentase layanan penelaahan, perancangan perundang-undangan dan pertimbangan hukum sesuai SLA', 'unit_pengampu' => 'Biro Hukum dan Hubungan Luar Negeri', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah rancangan regulasi yang selesai ditelaah secara yuridis tepat SLA', 'nama_penyebut' => 'Total seluruh berkas permohonan penelaahan perundang-undangan masuk', 'sumber_data' => 'Log Persuratan Masuk/Keluar Seksi Penelaahan Biro Hukum'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 13.2.1.2', 'nama_kinerja' => 'Persentase layanan kerja sama hukum dan hubungan luar negeri sesuai SLA', 'unit_pengampu' => 'Biro Hukum dan Hubungan Luar Negeri', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah dokumen administrasi kerja sama dan fasilitasi delegasi luar negeri selesai tepat SLA', 'nama_penyebut' => 'Total berkas permohonan kerja sama dan hubungan luar negeri masuk', 'sumber_data' => 'Laporan Kerja Sama Biro Hukum & HLN'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 13.2.1.3', 'nama_kinerja' => 'Persentase layanan perpustakaan dan dokumentasi hukum sesuai SLA', 'unit_pengampu' => 'Biro Hukum dan Hubungan Luar Negeri', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah transaksi layanan pencarian katalog buku, dokumentasi hukum, dan pinjaman perpustakaan dilayani tepat SLA', 'nama_penyebut' => 'Total seluruh transaksi/kunjungan ke perpustakaan Kejaksaan RI', 'sumber_data' => 'Log Pengunjung Digital Perpustakaan Kejaksaan Agung'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 13.2.1.4', 'nama_kinerja' => 'Persentase layanan hukum pada perwakilan Kejaksaan RI di luar negeri sesuai SLA', 'unit_pengampu' => 'Biro Hukum dan Hubungan Luar Negeri', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah pemberian bantuan hukum dan koordinasi MLA transnasional oleh atase Kejaksaan selesai tepat SLA', 'nama_penyebut' => 'Total berkas sengketa hukum transnasional yang didelegasikan penanganannya', 'sumber_data' => 'Laporan Kerja Atase Kejaksaan KBRI Luar Negeri'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 13.2.1.5', 'nama_kinerja' => 'Persentase layanan perkantoran perwakilan Kejaksaan RI di luar negeri sesuai SLA', 'unit_pengampu' => 'Biro Hukum dan Hubungan Luar Negeri', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah urusan administrasi kesekretariatan atase Kejaksaan yang difasilitasi tuntas tepat SLA', 'nama_penyebut' => 'Total target berkas administrasi rumah tangga atase Kejaksaan luar negeri', 'sumber_data' => 'Laporan Kinerja Bulanan Atase Kejaksaan'],
                                ]
                            ]
                        ]
                    ]
                ]
            ],

            // ==========================================
            // SP 15: Meningkatnya efektivitas pelaksanaan tugas dan fungsi Kejaksaan berbasis TI
            // ==========================================
            [
                'level' => 'SASARAN_PROGRAM', 'kode_indikator' => 'SP 15', 'nama_kinerja' => 'Meningkatnya efektivitas pelaksanaan tugas dan fungsi Kejaksaan berbasis TI', 'unit_pengampu' => 'Jaksa Agung Muda Bidang Pembinaan (JAMBIN)',
                'children' => [
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 15.1', 'nama_kinerja' => 'Persentase digitalisasi proses bisnis inti Kejaksaan RI', 'unit_pengampu' => 'Pusdaskrimti', 'tipe_formula' => 'RATIO_PERCENTAGE', 'sumber_data' => 'Hasil Audit Maturitas TI Pusdaskrimti',
                        'children' => [
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 15.1.1', 'nama_kinerja' => 'Meningkatnya kegiatan pengelolaan data, statistik kriminal serta penerapan dan pengembangan teknologi informasi', 'unit_pengampu' => 'Pusdaskrimti',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 15.1.1.1', 'nama_kinerja' => 'Persentase layanan pengelolaan data dan statistik kriminal', 'unit_pengampu' => 'Pusdaskrimti', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah berkas rilis statistik kriminal nasional yang dipublikasikan tuntas tepat waktu', 'nama_penyebut' => 'Total target publikasi statistik kriminal berkala wajib di portal Satu Data', 'sumber_data' => 'Pangkalan Data Statistik Kriminal Pusdaskrimti'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 15.1.1.2', 'nama_kinerja' => 'Persentase layanan penerapan dan pengembangan teknologi informasi sesuai SLA', 'unit_pengampu' => 'Pusdaskrimti', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah permohonan pengembangan sistem informasi yang tuntas dikembangkan tepat SLA', 'nama_penyebut' => 'Total seluruh tiket usulan pengembangan teknologi informasi satker yang masuk', 'sumber_data' => 'Log Tiket Helpdesk TI Pusdaskrimti'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 15.1.1.3', 'nama_kinerja' => 'Persentase layanan perkantoran sesuai SLA', 'unit_pengampu' => 'Pusdaskrimti', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah unit komputer dinas, konektivitas internet, dan lisensi software yang dipelihara tepat SLA', 'nama_penyebut' => 'Total target pemeliharaan sarana administrasi komputer perkantoran', 'sumber_data' => 'Log Pemeliharaan Infrastruktur TI Pusdaskrimti'],
                                ]
                            ],
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 15.2.1', 'nama_kinerja' => 'Meningkatnya pengembangan dan pemanfaatan Sistem Teknologi Informasi Kejaksaan RI', 'unit_pengampu' => 'Pusdaskrimti',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 15.2.1.1', 'nama_kinerja' => 'Persentase Satuan Kerja yang Menggunakan CMS dalam rangka Implementasi SPPT-TI', 'unit_pengampu' => 'Pusdaskrimti', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah satuan kerja yang tercatat aktif melakukan input dokumen perkara secara konsisten pada CMS', 'nama_penyebut' => 'Total seluruh satuan kerja Kejaksaan RI wajib menggunakan CMS (538 satker)', 'sumber_data' => 'Log Server Transaksi Database Terpusat Aplikasi CMS'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 15.2.1.2', 'nama_kinerja' => 'Indeks Pemerintah Digital', 'unit_pengampu' => 'Pusdaskrimti', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Hasil Evaluasi Indeks SPBE Nasional KemenPAN-RB'],
                                ]
                            ],
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 15.3.1', 'nama_kinerja' => 'Meningkatnya kualitas data Statistik Kriminal Kejaksaan RI', 'unit_pengampu' => 'Pusdaskrimti',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 15.3.1.1', 'nama_kinerja' => 'Indeks kualitas data Kejaksaan RI', 'unit_pengampu' => 'Pusdaskrimti', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Hasil Audit Penyelenggaraan Evaluasi Kualitas Data BPS Sektoral'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 15.3.1.2', 'nama_kinerja' => 'Indeks penyelenggaraan statistik sektoral', 'unit_pengampu' => 'Pusdaskrimti', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Hasil Penilaian IPS Kejaksaan RI dari BPS'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 15.3.1.3', 'nama_kinerja' => 'Persentase satuan kerja yang telah menerapkan SPPT-TI dengan kualitas data yang berhasil dipertukarkan dengan Lembaga Penegak Hukum (LPH) lainnya terhadap data shahih sebesar minimal 70%', 'unit_pengampu' => 'Pusdaskrimti', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah satuan kerja yang kualitas data perkara di CMS berhasil dipertukarkan secara shahih (>70%)', 'nama_penyebut' => 'Total seluruh satuan kerja Kejaksaan RI yang dihubungkan dengan SPPT-TI', 'sumber_data' => 'Dashboard Integrasi SPPT-TI Kemenko Polhukam / Pusdaskrimti'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 15.3.1.4', 'nama_kinerja' => 'Tingkat keberhasilan penyelenggaraan tata kelola sistem Satu Data Kejaksaan', 'unit_pengampu' => 'Pusdaskrimti', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah kluster database yustisial dan manajerial yang berhasil disinkronkan ke dalam Data Warehouse terpusat', 'nama_penyebut' => 'Total seluruh kluster sistem data mandiri yang eksis di lingkungan Kejaksaan RI', 'sumber_data' => 'Log Sinkronisasi Puskarda Pusdaskrimti'],
                                ]
                            ],
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 15.4.1', 'nama_kinerja' => 'Meningkatnya keamanan Sistem Teknologi Informasi Kejaksaan RI', 'unit_pengampu' => 'Pusdaskrimti',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 15.4.1.1', 'nama_kinerja' => 'Indeks Kematangan Keamanan Siber Kejaksaan RI', 'unit_pengampu' => 'Pusdaskrimti', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Hasil Audit Kematangan Keamanan Informasi (CSM) BSSN'],
                                ]
                            ],
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 15.5.1', 'nama_kinerja' => 'Meningkatnya kualitas tata kelola administrasi penanganan perkara berbasis teknologi informasi', 'unit_pengampu' => 'Pusdaskrimti',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 15.5.1.1', 'nama_kinerja' => 'Indeks kepuasan pengguna internal terhadap sistem administrasi perkara berbasis TI', 'unit_pengampu' => 'Pusdaskrimti', 'tipe_formula' => 'INDEX_SCORE', 'sumber_data' => 'Laporan Evaluasi Kepuasan Pengguna CMS Pusdaskrimti'],
                                ]
                            ]
                        ]
                    ]
                ]
            ],

            // ==========================================
            // SP 16: Meningkatnya kuantitas dan kualitas sarana dan prasarana yang mendukung Kinerja Kejaksaan RI
            // ==========================================
            [
                'level' => 'SASARAN_PROGRAM', 'kode_indikator' => 'SP 16', 'nama_kinerja' => 'Meningkatnya kuantitas dan kualitas sarana dan prasarana yang mendukung Kinerja Kejaksaan RI', 'unit_pengampu' => 'Jaksa Agung Muda Bidang Pembinaan (JAMBIN)',
                'children' => [
                    [
                        'level' => 'INDIKATOR_PROGRAM', 'kode_indikator' => 'IKP 16.1', 'nama_kinerja' => 'Tingkat utilisasi sarana dan prasarana Kejaksaan RI', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'sumber_data' => 'Buku Inventaris Sarpras Biro Perlengkapan / Aplikasi SIMAN v2',
                        'children' => [
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 16.1.1', 'nama_kinerja' => 'Meningkatnya jumlah gedung kantor, rumah negara, kendaraan jabatan, operasional, dan fungsional, perangkat pengolah data dan komunikasi, perlengkapan dan fasilitas perkantoran yang memadai', 'unit_pengampu' => 'Biro Perlengkapan',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.1.1.1', 'nama_kinerja' => 'Persentase gedung kantor yang direhabilitasi', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah gedung kantor Kejaksaan Agung/Daerah selesai direnovasi fisik', 'nama_penyebut' => 'Total target gedung kantor Kejaksaan yang direncanakan renovasi', 'sumber_data' => 'Berita Acara Serah Terima (BAST) Pekerjaan Fisik & SIMAN'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.1.1.2', 'nama_kinerja' => 'Persentase rumah negara yang direhabilitasi', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah unit rumah dinas Kejaksaan Agung/Daerah selesai direnovasi fisik', 'nama_penyebut' => 'Total target unit rumah dinas Kejaksaan yang dianggarkan renovasi', 'sumber_data' => 'BAST Pekerjaan Fisik & SIMAN'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.1.1.3', 'nama_kinerja' => 'Persentase pembangunan gedung kantor satuan kerja yang baru', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah gedung kantor satker baru yang selesai dibangun fisiknya', 'nama_penyebut' => 'Total target pembangunan gedung kantor baru yang dianggarkan', 'sumber_data' => 'Dokumen BAST Fisik Gedung Baru'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.1.1.4', 'nama_kinerja' => 'Persentase pembangunan rumah negara baru', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah unit rumah dinas baru selesai dibangun fisiknya', 'nama_penyebut' => 'Total target unit pembangunan rumah dinas baru yang direncanakan', 'sumber_data' => 'Dokumen BAST Fisik Rumah Dinas Baru'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.1.1.5', 'nama_kinerja' => 'Persentase pengadaan mobil jabatan dan operasional', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah unit mobil dinas jabatan/operasional selesai diadakan dan diserahterimakan', 'nama_penyebut' => 'Total target unit mobil dinas jabatan/operasional yang dianggarkan', 'sumber_data' => 'Laporan Buku Inventaris SIMAN'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.1.1.6', 'nama_kinerja' => 'Persentase pengadaan mobil tahanan dan mobil fungsional lainnya', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah unit mobil tahanan dan fungsional selesai diadakan', 'nama_penyebut' => 'Total target unit mobil tahanan dan fungsional yang direncanakan', 'sumber_data' => 'Laporan Buku Inventaris SIMAN'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.1.1.7', 'nama_kinerja' => 'Persentase pengadaan sepeda motor dinas', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah unit sepeda motor dinas selesai diadakan dan tercatat dalam SIMAN', 'nama_penyebut' => 'Total target unit sepeda motor dinas yang direncanakan diadakan', 'sumber_data' => 'Laporan Buku Inventaris SIMAN'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.1.1.8', 'nama_kinerja' => 'Persentase pengadaan perangkat pengolah data dan komunikasi', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah set komputer, laptop, scanner, dan server yang selesai diadakan', 'nama_penyebut' => 'Total target set perangkat pengolah data dan komunikasi', 'sumber_data' => 'Laporan Buku Inventaris SIMAN'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.1.1.9', 'nama_kinerja' => 'Persentase pengadaan perlengkapan dan fasilitas perkantoran', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah unit perlengkapan kantor selesai diadakan dan tercatat', 'nama_penyebut' => 'Total target unit perlengkapan perkantoran yang dianggarkan', 'sumber_data' => 'Laporan Buku Inventaris SIMAN'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.1.1.10', 'nama_kinerja' => 'Persentase terpenuhi sarana/prasarana intelijen dan penegakan hukum', 'unit_pengampu' => 'Biro Perlengkapan', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah unit sarana taktis intelijen selesai diadakan', 'nama_penyebut' => 'Total kebutuhan ideal unit sarana taktis intelijen dan penegakan hukum', 'sumber_data' => 'Laporan Inventaris Sarpras Biro Perlengkapan / SIMAN'],
                                ]
                            ],
                            [
                                'level' => 'SASARAN_KEGIATAN', 'kode_indikator' => 'SK 16.2.1', 'nama_kinerja' => 'Meningkatnya kegiatan pelayanan ketatausahaan Jaksa Agung, Wakil Jaksa Agung, Staf Ahli, tata usaha pimpinan, Protokol dan Keamanan Pimpinan, Keamanan, tata usaha dan kearsipan, sarana prasarana dan Rumah Tangga', 'unit_pengampu' => 'Biro Umum',
                                'children' => [
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.2.1.1', 'nama_kinerja' => 'Persentase layanan tata usaha pimpinan sesuai SLA', 'unit_pengampu' => 'Biro Umum', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah agenda persuratan, disposisi, dan registrasi pimpinan yang diselesaikan tepat SLA', 'nama_penyebut' => 'Total berkas permohonan layanan tata usaha pimpinan yang masuk', 'sumber_data' => 'Log Registrasi Surat Masuk pimpinan Biro Umum'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.2.1.2', 'nama_kinerja' => 'Persentase layanan protokol dan pengamanan pimpinan sesuai SLA', 'unit_pengampu' => 'Biro Umum', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah kegiatan pendampingan dan keprotokolan pimpinan terlaksana tuntas tanpa AGHT', 'nama_penyebut' => 'Total agenda kunjungan/kegiatan resmi pimpinan yang diajukan', 'sumber_data' => 'Log Agenda Keprotokolan Biro Umum'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.2.1.3', 'nama_kinerja' => 'Persentase layanan keamanan dalam sesuai SLA', 'unit_pengampu' => 'Biro Umum', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah hari penanganan patroli keamanan dalam kompleks kantor Kejagung selesai aman tanpa insiden', 'nama_penyebut' => 'Total jumlah hari dalam periode pelaporan (365 hari)', 'sumber_data' => 'Log Laporan Harian Kamdal Kejaksaan Agung'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.2.1.4', 'nama_kinerja' => 'Persentase layanan tata usaha dan kearsipan sesuai SLA', 'unit_pengampu' => 'Biro Umum', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah dokumen persuratan dan berkas arsip yang dikelola tepat SLA', 'nama_penyebut' => 'Total seluruh berkas persuratan dinas masuk dan keluar wajib kelola', 'sumber_data' => 'Aplikasi Persuratan Digital (Srikandi / Internal)'],
                                    ['level' => 'INDIKATOR_KEGIATAN', 'kode_indikator' => 'IKK 16.2.1.5', 'nama_kinerja' => 'Persentase layanan prasarana sarana, dan rumah tangga sesuai SLA', 'unit_pengampu' => 'Biro Umum', 'tipe_formula' => 'RATIO_PERCENTAGE', 'nama_pembilang' => 'Jumlah pengajuan perbaikan fasilitas, konsumsi, dan perawatan rumah tangga selesai tepat SLA', 'nama_penyebut' => 'Total seluruh usulan layanan prasarana sarana dan rumah tangga yang masuk', 'sumber_data' => 'Sistem Layanan Rumah Tangga / Biro Umum'],
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];

        // Insert or update data recursively using updateOrCreate based on kode_indikator
        foreach ($data as $sp) {
            DB::table('sp')->updateOrInsert(
                ['kode_sp' => $sp['kode_indikator']],
                [
                    'nama_kinerja' => $sp['nama_kinerja'],
                    'unit_pengampu' => $sp['unit_pengampu'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            if (isset($sp['children'])) {
                foreach ($sp['children'] as $ikp) {
                    $isMandiri = !isset($ikp['children']) || count($ikp['children']) === 0;
                    DB::table('ikp')->updateOrInsert(
                        ['kode_ikp' => $ikp['kode_indikator']],
                        [
                            'sp_kode' => $sp['kode_indikator'],
                            'nama_kinerja' => $ikp['nama_kinerja'],
                            'unit_pengampu' => $ikp['unit_pengampu'] ?? null,
                            'tipe_node' => $isMandiri ? 'MANDIRI' : 'AGREGATIF',
                            'created_at' => now(),
                            'updated_at' => now()
                        ]
                    );

                    if ($isMandiri) {
                        DB::table('rumus_indikator')->updateOrInsert(
                            ['kode_indikator' => $ikp['kode_indikator']],
                            [
                                'tipe_formula' => $ikp['tipe_formula'] ?? 'INDEX_SCORE',
                                'nama_pembilang' => $ikp['nama_pembilang'] ?? null,
                                'nama_penyebut' => $ikp['nama_penyebut'] ?? null,
                                'deskripsi' => $ikp['sumber_data'] ?? null,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]
                        );
                    }

                    if (isset($ikp['children'])) {
                        foreach ($ikp['children'] as $sk) {
                            DB::table('sk')->updateOrInsert(
                                ['kode_sk' => $sk['kode_indikator']],
                                [
                                    'ikp_kode' => $ikp['kode_indikator'],
                                    'nama_kinerja' => $sk['nama_kinerja'],
                                    'unit_pengampu' => $sk['unit_pengampu'] ?? null,
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ]
                            );

                            if (isset($sk['children'])) {
                                foreach ($sk['children'] as $ikk) {
                                    DB::table('ikk')->updateOrInsert(
                                        ['kode_ikk' => $ikk['kode_indikator']],
                                        [
                                            'sk_kode' => $sk['kode_indikator'],
                                            'nama_kinerja' => $ikk['nama_kinerja'],
                                            'unit_pengampu' => $ikk['unit_pengampu'] ?? null,
                                            'created_at' => now(),
                                            'updated_at' => now()
                                        ]
                                    );
                                    
                                    DB::table('rumus_indikator')->updateOrInsert(
                                        ['kode_indikator' => $ikk['kode_indikator']],
                                        [
                                            'tipe_formula' => $ikk['tipe_formula'] ?? 'RATIO_PERCENTAGE',
                                            'nama_pembilang' => $ikk['nama_pembilang'] ?? null,
                                            'nama_penyebut' => $ikk['nama_penyebut'] ?? null,
                                            'deskripsi' => $ikk['sumber_data'] ?? null,
                                            'created_at' => now(),
                                            'updated_at' => now()
                                        ]
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }

        // Sync all kinerja_ikk entries to rumus_indikator table
        $kinerjaIkks = DB::table('kinerja_ikk')->get();
        foreach ($kinerjaIkks as $kIkk) {
            $exists = DB::table('rumus_indikator')->where('kode_indikator', $kIkk->kode_ikk)->first();
            if (! $exists || empty($exists->nama_pembilang)) {
                $prefix = mb_substr(trim($kIkk->nama_ikk), 0, 15);
                $ikkSingular = DB::table('ikk')->where('nama_kinerja', 'LIKE', "%{$prefix}%")->first();
                $matchedRumus = $ikkSingular ? DB::table('rumus_indikator')->where('kode_indikator', $ikkSingular->kode_ikk)->first() : null;

                $pembilang = $matchedRumus?->nama_pembilang;
                $penyebut  = $matchedRumus?->nama_penyebut;
                $deskripsi = $matchedRumus?->deskripsi;

                if (! $pembilang) {
                    if (str_contains(strtolower($kIkk->nama_ikk), 'persentase')) {
                        $cleanName = trim(str_replace(['Persentase', 'persentase'], '', $kIkk->nama_ikk));
                        $pembilang = "Jumlah " . strtolower($cleanName) . " yang terealisasi tepat SLA / target";
                        $penyebut  = "Total target " . strtolower($cleanName) . " yang dianggarkan / wajib dalam setahun";
                    } elseif (str_contains(strtolower($kIkk->nama_ikk), 'indeks') || str_contains(strtolower($kIkk->nama_ikk), 'nilai')) {
                        $pembilang = "Skor / Nilai evaluasi " . strtolower($kIkk->nama_ikk) . " yang dicapai";
                        $penyebut  = "Target skor / nilai " . strtolower($kIkk->nama_ikk) . " sesuai Perjanjian Kinerja";
                    } else {
                        $pembilang = "Jumlah " . strtolower($kIkk->nama_ikk) . " yang terealisasi";
                        $penyebut  = "Total target " . strtolower($kIkk->nama_ikk) . " yang ditetapkan";
                    }
                }

                DB::table('rumus_indikator')->updateOrInsert(
                    ['kode_indikator' => $kIkk->kode_ikk],
                    [
                        'tipe_formula' => $matchedRumus?->tipe_formula ?? 'RATIO_PERCENTAGE',
                        'nama_pembilang' => mb_substr((string) $pembilang, 0, 250),
                        'nama_penyebut' => mb_substr((string) $penyebut, 0, 250),
                        'deskripsi' => mb_substr((string) ($deskripsi ?? "Laporan Evaluasi / Log Data " . $kIkk->nama_ikk), 0, 250),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
            }
        }
    }
}
