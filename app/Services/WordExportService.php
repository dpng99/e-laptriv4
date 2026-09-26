<?php

namespace App\Services;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\ReportTemplate;
use App\Models\RumusIndikator;
use App\Models\Sp;
use App\Models\Target;
use Carbon\Carbon;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;

class WordExportService
{
    private array $romawi = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
    ];

    public function generateLkjiP(int $tahun, int $triwulan): string
    {
        $twRomawi = $this->romawi[$triwulan] ?? (string) $triwulan;
        $sasaranData = $this->collectSasaranAndIkpData($tahun, $triwulan);

        // 1. Cek apakah ada Template Kustom (.docx) aktif yang diunggah oleh Admin
        $activeTemplate = ReportTemplate::getActiveTemplate();
        if ($activeTemplate && file_exists(storage_path('app/' . $activeTemplate->file_path))) {
            return $this->generateWithTemplateProcessor($activeTemplate, $tahun, $triwulan, $sasaranData);
        }

        // 2. Format Bawaan Resmi Lengkap (Built-in Official Generator) dengan Rumus Bertingkat Besar
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $phpWord = new PhpWord();
        $this->setupStyles($phpWord);

        // 1. Cover Page
        $this->addCoverPage($phpWord, $tahun, $twRomawi);

        // 2. Kata Pengantar
        $this->addKataPengantar($phpWord, $tahun, $twRomawi);

        // 3. Ikhtisar Eksekutif
        $this->addIkhtisarEksekutif($phpWord, $tahun, $twRomawi, $sasaranData);

        // 4. Daftar Isi
        $this->addDaftarIsi($phpWord, $tahun, $twRomawi);

        // 5. BAB I: Pendahuluan (Persis dokumen referensi)
        $this->addBab1Pendahuluan($phpWord, $tahun, $twRomawi);

        // 6. BAB II: Perencanaan Kinerja (Persis dokumen referensi)
        $this->addBab2PerencanaanKinerja($phpWord, $tahun, $twRomawi, $sasaranData);

        // 7. BAB III: Akuntabilitas Kinerja (Rumus Bersusun Besar, Komponen Mentah, Analisis)
        $this->addBab3AkuntabilitasKinerja($phpWord, $tahun, $twRomawi, $sasaranData);

        // 8. BAB IV: Penutup
        $this->addBab4Penutup($phpWord, $tahun, $twRomawi);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = "Laporan_Kinerja_TW_{$twRomawi}_Tahun_{$tahun}_JAMBIN.docx";
        $tempPath = $this->getExportTempPath($fileName);

        $objWriter->save($tempPath);

        return $tempPath;
    }

    private function setupStyles(PhpWord $phpWord): void
    {
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 180]);
        $phpWord->addTitleStyle(2, ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['alignment' => Jc::LEFT, 'spaceBefore' => 140, 'spaceAfter' => 100]);
        $phpWord->addTitleStyle(3, ['bold' => true, 'size' => 11, 'color' => '333333'], ['alignment' => Jc::LEFT, 'spaceBefore' => 100, 'spaceAfter' => 60]);

        $phpWord->addTableStyle('ReportTable', [
            'borderSize' => 6,
            'borderColor' => 'CCCCCC',
            'cellMarginTop' => 80,
            'cellMarginBottom' => 80,
            'cellMarginLeft' => 100,
            'cellMarginRight' => 100,
            'alignment' => Jc::CENTER,
        ], [
            'bgColor' => '1B365D',
        ]);

        $phpWord->addTableStyle('SubTable', [
            'borderSize' => 4,
            'borderColor' => 'E0E0E0',
            'cellMarginTop' => 60,
            'cellMarginBottom' => 60,
            'cellMarginLeft' => 80,
            'cellMarginRight' => 80,
            'alignment' => Jc::CENTER,
        ], [
            'bgColor' => 'EAEAEA',
        ]);

        $phpWord->addTableStyle('FormulaTable', [
            'borderSize' => 0,
            'borderColor' => 'FFFFFF',
            'cellMarginTop' => 40,
            'cellMarginBottom' => 40,
            'cellMarginLeft' => 60,
            'cellMarginRight' => 60,
            'alignment' => Jc::CENTER,
        ]);
    }

    private function addCoverPage(PhpWord $phpWord, int $tahun, string $twRomawi): void
    {
        $section = $phpWord->addSection([
            'marginTop' => 1440,
            'marginBottom' => 1440,
            'marginLeft' => 1440,
            'marginRight' => 1440,
        ]);

        $section->addText('KEJAKSAAN REPUBLIK INDONESIA', ['bold' => true, 'size' => 16, 'color' => '1B365D'], ['alignment' => Jc::CENTER]);
        $section->addText('JAKSA AGUNG MUDA BIDANG PEMBINAAN', ['bold' => true, 'size' => 14, 'color' => '333333'], ['alignment' => Jc::CENTER]);
        
        $section->addTextBreak(6);

        $section->addText('LAPORAN KINERJA', ['bold' => true, 'size' => 22, 'color' => '1B365D'], ['alignment' => Jc::CENTER]);
        $section->addText("TRIWULAN {$twRomawi}", ['bold' => true, 'size' => 20, 'color' => 'C98A2C'], ['alignment' => Jc::CENTER]);
        $section->addText("TAHUN {$tahun}", ['bold' => true, 'size' => 18, 'color' => '1B365D'], ['alignment' => Jc::CENTER]);

        $section->addTextBreak(8);

        $section->addText('JAKSA AGUNG MUDA BIDANG PEMBINAAN', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['alignment' => Jc::CENTER]);
        $section->addText('JAKARTA', ['bold' => true, 'size' => 11, 'color' => '555555'], ['alignment' => Jc::CENTER]);
        $section->addText("{$tahun}", ['bold' => true, 'size' => 11, 'color' => '555555'], ['alignment' => Jc::CENTER]);

        $section->addPageBreak();
    }

    private function addKataPengantar(PhpWord $phpWord, int $tahun, string $twRomawi): void
    {
        $section = $phpWord->addSection();

        $section->addText('KATA PENGANTAR', ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);

        $section->addText(
            "Alhamdulillah, puji syukur kami panjatkan kehadirat Allah Subhanahu Wa Ta'ala, Tuhan Yang Maha Esa atas tersusunnya Laporan Kinerja Triwulan {$twRomawi} Jaksa Agung Muda Bidang Pembinaan Tahun {$tahun}, sebagai pelaksanaan Peraturan Presiden Nomor 29 Tahun 2014 tentang Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP) yang sistematika dan tata cara penyusunannya diatur lebih komprehensif dalam Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 53 Tahun 2014 tentang Petunjuk Teknis Perjanjian Kinerja, Pelaporan Kinerja dan Tata cara Reviu atas Laporan Kinerja Instansi Pemerintah serta Pedoman Jaksa Agung Nomor 4 Tahun 2024 tentang Penyelenggaraan Sistem Akuntabilitas Kinerja Instansi Pemerintah di Lingkungan Kejaksaan Republik Indonesia.",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 120]
        );

        $section->addText(
            "Laporan Kinerja Triwulan ini merupakan perwujudan pertanggungjawaban atas kinerja pencapaian visi dan misi Jaksa Agung Muda Bidang Pembinaan yang tertuang dalam Perjanjian Kinerja Tahun Anggaran {$tahun}. Dalam Laporan Triwulan {$twRomawi} ini disusun hasil capaian sesuai dengan Target Kinerja yang tercantum dalam Perjanjian Kinerja dalam rangka melaksanakan tugas dan fungsinya guna terselenggaranya good governance dan clean government.",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 120]
        );

        $section->addText(
            "Dalam Laporan Triwulan {$twRomawi} ini disampaikan hasil dan penjelasan capaian kinerja/kegiatan pada Jaksa Agung Muda Bidang Pembinaan yang meliputi Sekretariat JAMBIN, Biro Perencanaan, Biro Umum, Biro Kepegawaian, Biro Keuangan, Biro Perlengkapan, Biro Hukum dan Hubungan Luar Negeri, Pusat Data Statistik Kriminal dan Teknologi Informasi, Pusat Strategi Kebijakan Penegakan Hukum, dan Pusat Kesehatan Yustisial.",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 120]
        );

        $section->addText(
            'Kami menyadari bahwa laporan ini belum sempurna, oleh sebab itu kami mengharapkan masukan, kritik dan saran yang konstruktif untuk peningkatan kualitas pelaporan kedepannya. Semoga laporan ini dapat memenuhi harapan sebagai pertanggungjawaban kami atas mandat yang diemban yaitu kinerja yang telah ditetapkan sebagai pendorong peningkatan kinerja Jaksa Agung Muda Bidang Pembinaan, serta bermanfaat bagi kita semua.',
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 120]
        );

        $section->addText(
            'Semoga Allah SWT selalu melimpahkan rahmat, taufik dan hidayah-Nya serta selalu melindungi kita semua. Amin YRA.',
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 200]
        );

        $section->addText("Jakarta, {$tahun}", ['size' => 11], ['alignment' => Jc::END]);
        $section->addText('Jaksa Agung Muda Pembinaan,', ['bold' => true, 'size' => 11], ['alignment' => Jc::END]);
        $section->addTextBreak(3);
        $section->addText('Dr. HENDRO DEWANTO, S.H., M.Hum.', ['bold' => true, 'size' => 11, 'underline' => 'single'], ['alignment' => Jc::END]);

        $section->addPageBreak();
    }

    private function addIkhtisarEksekutif(PhpWord $phpWord, int $tahun, string $twRomawi, array $sasaranData): void
    {
        $section = $phpWord->addSection();

        $section->addText('IKHTISAR EKSEKUTIF', ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 180]);

        $section->addText(
            "Jaksa Agung Muda Bidang Pembinaan pada Laporan Kinerja Triwulan {$twRomawi} Tahun {$tahun} telah melakukan pencapaian kinerja berdasarkan dokumen Perjanjian Kinerja Jaksa Agung Muda Pembinaan. Dalam Perjanjian Kinerja Jaksa Agung Muda Pembinaan, terdapat 11 sasaran program yang harus dicapai dimana pengukurannya ditentukan oleh 19 indikator kinerja utama (IKU).",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 140]
        );

        $section->addText("Tabel 1. Matriks Pengukuran Pencapaian Sasaran Kinerja Jaksa Agung Muda Pembinaan Tahun {$tahun}", ['bold' => true, 'size' => 11], ['spaceAfter' => 80]);

        $table = $section->addTable('ReportTable');
        $table->addRow();
        $table->addCell(600, ['bgColor' => '1B365D'])->addText('No', ['bold' => true, 'color' => 'FFFFFF', 'size' => 10], ['alignment' => Jc::CENTER]);
        $table->addCell(3000, ['bgColor' => '1B365D'])->addText('Sasaran Program', ['bold' => true, 'color' => 'FFFFFF', 'size' => 10], ['alignment' => Jc::CENTER]);
        $table->addCell(3400, ['bgColor' => '1B365D'])->addText('Indikator Kinerja Utama', ['bold' => true, 'color' => 'FFFFFF', 'size' => 10], ['alignment' => Jc::CENTER]);
        $table->addCell(1200, ['bgColor' => '1B365D'])->addText("Target {$tahun}", ['bold' => true, 'color' => 'FFFFFF', 'size' => 10], ['alignment' => Jc::CENTER]);
        $table->addCell(1400, ['bgColor' => '1B365D'])->addText("Realisasi TW {$twRomawi}", ['bold' => true, 'color' => 'FFFFFF', 'size' => 10], ['alignment' => Jc::CENTER]);

        $no = 1;
        foreach ($sasaranData as $sasaran) {
            $ikpCount = count($sasaran['ikp_list']);
            $first = true;

            foreach ($sasaran['ikp_list'] as $ikp) {
                $table->addRow();
                if ($first) {
                    $table->addCell(600)->addText((string)$no, ['size' => 9], ['alignment' => Jc::CENTER]);
                    $table->addCell(3000)->addText($sasaran['nama_sp'], ['size' => 9]);
                    $first = false;
                } else {
                    $table->addCell(600)->addText('', ['size' => 9]);
                    $table->addCell(3000)->addText('', ['size' => 9]);
                }

                $table->addCell(3400)->addText($ikp['nama_ikp'], ['size' => 9]);
                $table->addCell(1200)->addText($this->formatTargetDisplay($ikp['target'], $ikp['satuan']), ['size' => 9], ['alignment' => Jc::CENTER]);
                $table->addCell(1400)->addText($this->formatRealisasiDisplay($ikp['realisasi'], $ikp['satuan']), ['size' => 9], ['alignment' => Jc::CENTER]);
            }
            $no++;
        }

        $section->addPageBreak();
    }

    private function addDaftarIsi(PhpWord $phpWord, int $tahun, string $twRomawi): void
    {
        $section = $phpWord->addSection();

        $section->addText('DAFTAR ISI', ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);

        $toc = [
            'KATA PENGANTAR' => 'i',
            'IKHTISAR EKSEKUTIF' => 'ii',
            'DAFTAR ISI' => 'iv',
            'BAB I PENDAHULUAN' => '1',
            '  A. Latar Belakang' => '1',
            '  B. Maksud dan Tujuan' => '1',
            '  C. Permasalahan dan Kendala' => '2',
            '  D. Tugas Pokok dan Fungsi Jaksa Agung Muda Bidang Pembinaan' => '2',
            '  E. Isu Terkini' => '9',
            '  F. Profil Pegawai pada Jaksa Agung Muda Bidang Pembinaan' => '10',
            'BAB II PERENCANAAN KINERJA' => '11',
            '  A. Rencana Strategis Jaksa Agung Muda Bidang Pembinaan' => '11',
            '  B. Perjanjian Kinerja' => '13',
            '  C. Pengukuran Capaian Kinerja Tahun 2026' => '14',
            'BAB III AKUNTABILITAS KINERJA' => '15',
            '  A. Capaian Kinerja Organisasi' => '15',
            '  B. Analisis Capaian Kinerja' => '21',
            '  C. Realisasi Anggaran' => '57',
            'BAB IV PENUTUP' => '59',
        ];

        foreach ($toc as $title => $page) {
            $isBab = str_starts_with($title, 'BAB') || in_array($title, ['KATA PENGANTAR', 'IKHTISAR EKSEKUTIF', 'DAFTAR ISI']);
            $font = $isBab ? ['bold' => true, 'size' => 11] : ['size' => 11];
            $table = $section->addTable();
            $table->addRow();
            $table->addCell(8000)->addText($title, $font);
            $table->addCell(1000)->addText($page, $font, ['alignment' => Jc::END]);
        }

        $section->addPageBreak();
    }

    private function addBab1Pendahuluan(PhpWord $phpWord, int $tahun, string $twRomawi): void
    {
        $section = $phpWord->addSection();

        $section->addText('BAB I', ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER]);
        $section->addText('PENDAHULUAN', ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);

        // A. Latar Belakang
        $section->addText('A. Latar Belakang', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['spaceBefore' => 120, 'spaceAfter' => 80]);
        $section->addText(
            'Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP) adalah rangkaian sistematik dari berbagai aktivitas, alat, dan prosedur yang dirancang untuk tujuan penetapan dan pengukuran, pengumpulan data, pengklasifikasian, pengikhtisaran, dan pelaporan kinerja pada instansi pemerintah, dalam rangka pertanggungjawaban dan peningkatan kinerja instansi pemerintah. Penyelenggaraan SAKIP pada Kementerian Negara/Lembaga merupakan amanat Peraturan Presiden Nomor 29 Tahun 2014 tentang Sistem Akuntabilitas Kinerja Instansi Pemerintah, dan secara internal Kejaksaan telah diatur dalam Pedoman Jaksa Agung Nomor 4 Tahun 2024 tentang Penyelenggaraan Sistem Akuntabilitas Kinerja Instansi Pemerintah di Lingkungan Kejaksaan Republik Indonesia sebagai pelaksanaan dari Peraturan Presiden Nomor 29 Tahun 2014 tentang Sistem Akuntabilitas Kinerja Instansi Pemerintah. Sebagai bentuk implementasi SAKIP tersebut, Jaksa Agung Muda Bidang Pembinaan telah melakukan Pengukuran kinerja setiap Triwulan dan melaporkannya secara rutin kepada Jaksa Agung Republik Indonesia.',
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 100]
        );
        $section->addText(
            "Pelaksanaan program/kegiatan Pembinaan tersebut hanya dapat terselenggara dengan akuntabel, efektif dan efisien jika diterapkan pengelolaan kinerja organisasi yang baik. Pengelolaan kinerja tersebut secara garis besar mencakup aspek perencanaan, pelaksanaan, pengukuran dan evaluasi kinerja serta pelaporan kinerja. Aspek-aspek tersebut merupakan satu kesatuan yang tidak dapat dipisahkan dalam pengelolaan kinerja, dan akan menentukan keberhasilan kinerja organisasi. Jaksa Agung Muda Bidang Pembinaan merupakan bagian dari Kejaksaan Republik Indonesia yang diberikan amanah untuk berperan dalam melaksanakan tugas dan wewenang di Bidang Pembinaan. Lingkup tugas dan wewenang sebagaimana dimaksud adalah meliputi pembinaan atas perencanaan, pelaksanaan pembangunan sarana dan prasarana, organisasi dan ketatalaksanaan, kepegawaian, keuangan, pengelolaan kekayaan milik negara, pertimbangan hukum, penyusunan peraturan perundang-undangan, kerjasama luar negeri, pelayanan dan dukungan teknis lainnya. Peran tersebut selanjutnya diimplementasikan melalui program/kegiatan Jaksa Agung Muda Bidang Pembinaan yang secara garis besar telah dirumuskan dalam Rencana Strategis (RENSTRA) Kejaksaan Republik Indonesia Tahun 2025-2029 dan Rencana Kerja Tahun {$tahun}.",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 140]
        );

        // B. Maksud dan Tujuan
        $section->addText('B. Maksud dan Tujuan', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['spaceBefore' => 120, 'spaceAfter' => 80]);
        $section->addText('1. Maksud', ['bold' => true, 'size' => 11], ['spaceAfter' => 40]);
        $section->addText(
            "Maksud dari penyusunan Laporan Kinerja Triwulan {$twRomawi} Jaksa Agung Muda Bidang Pembinaan Tahun {$tahun} adalah sebagai bentuk pertanggungjawaban kepada Jaksa Agung Republik Indonesia atas pengelolaan anggaran dan pelaksanaan program/kegiatan dalam rangka mencapai visi dan misi yang telah ditetapkan.",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 80]
        );
        $section->addText('2. Tujuan', ['bold' => true, 'size' => 11], ['spaceAfter' => 40]);
        $section->addText(
            'Untuk melakukan evaluasi terhadap capaian kinerja tersebut, agar dapat menjadi bahan pertimbangan atau acuan dalam menetapkan kebijakan dan strategi yang akan diambil sehingga dapat meningkatkan capaian kinerja Jaksa Agung Muda Bidang Pembinaan.',
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 140]
        );

        // C. Permasalahan dan Kendala
        $section->addText('C. Permasalahan dan Kendala', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['spaceBefore' => 120, 'spaceAfter' => 80]);
        $section->addText(
            'Berbagai permasalahan dan kendala yang sedang dihadapi dari berbagai satuan kerja di daerah dapat dihimpun menjadi beberapa hal, antara lain:',
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 60]
        );
        $kendalaItems = [
            '1) Peningkatan manajemen sumber daya manusia melalui pembangunan sumber daya manusia yang berkualitas dan berdaya saing;',
            '2) Penataan organisasi dan pelaksanaan reformasi birokrasi dilakukan dengan menitikberatkan pada penataan kelembagaan dan proses bisnis, transformasi pelayanan publik, reformasi sistem akuntabilitas dan penataan regulasi;',
            '3) Optimalisasi Penyusunan Perencanaan dan Pelaksanaan Anggaran;',
            '4) Optimalisasi sumber pembiayaan di luar rupiah murni (RM);',
            '5) Optimalisasi Penerimaan PNBP Kejaksaan;',
            '6) Akselerasi penerapan sistem teknologi informasi dalam pelaksanaan tugas dan fungsi Kejaksaan Republik Indonesia;',
            '7) Meningkatkan sarana dan prasarana pelayanan publik dalam rangka pengembangan organisasi Kejaksaan Republik Indonesia guna memperkuat stabilitas politik, hukum, pertahanan dan keamanan, dan transformasi pelayanan publik.',
        ];
        foreach ($kendalaItems as $kItem) {
            $section->addText($kItem, ['size' => 11], ['alignment' => Jc::BOTH, 'spaceAfter' => 40]);
        }
        $section->addTextBreak(1);

        // D. Tugas Pokok dan Fungsi
        $section->addText('D. Tugas Pokok dan Fungsi Jaksa Agung Muda Bidang Pembinaan', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['spaceBefore' => 120, 'spaceAfter' => 80]);
        $section->addText(
            'Berdasarkan Peraturan Presiden Nomor 15 Tahun 2024 tentang Perubahan Ketiga Atas Peraturan Presiden Nomor 38 Tahun 2010 tentang Organisasi dan Tata Kerja Kejaksaan Republik Indonesia, Pasal 12 ayat 1 dan 2 yang berbunyi:',
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 60]
        );
        $section->addText('1. Jaksa Agung Muda Bidang Pembinaan mempunyai tugas dan wewenang melaksanakan tugas dan wewenang Kejaksaan di Bidang Pembinaan;', ['size' => 11], ['spaceAfter' => 40]);
        $section->addText('2. Lingkup bidang pembinaan sebagaimana dimaksud dalam ayat (1) meliputi pembinaan atas perencanaan, pelaksanaan pembangunan sarana dan prasarana, organisasi dan ketatalaksanaan, kepegawaian, keuangan, pengelolaan kekayaan milik negara, pertimbangan hukum, penyusunan peraturan perundang-undangan, kerjasama, pelayanan dan dukungan teknis lainnya.', ['size' => 11], ['spaceAfter' => 80]);

        $section->addText('Dalam melaksanakan tugas dan wewenang sebagaimana dimaksud dalam pasal 12, Jaksa Agung Muda Bidang Pembinaan menyelenggarakan fungsi sebagai berikut:', ['size' => 11], ['spaceAfter' => 40]);
        $fungsiJambin = [
            'a) Perencanaan dan perumusan kebijakan di bidang pembinaan;',
            'b) Koordinasi dan sinkronisasi pelaksanaan kebijakan di bidang pembinaan;',
            'c) Pelaksanaan hubungan kerja dengan instansi/lembaga baik di dalam negeri maupun di luar negeri;',
            'd) Pemantauan, analisis, evaluasi dan pelaporan pelaksanaan kegiatan di bidang pembinaan;',
            'e) Pelaksanaan tugas lain yang diberikan oleh Jaksa Agung.',
        ];
        foreach ($fungsiJambin as $fItem) {
            $section->addText($fItem, ['size' => 11], ['spaceAfter' => 40]);
        }

        $section->addTextBreak(1);
        $section->addText('Dalam menjalankan tugas pokok dan fungsinya Jaksa Agung Muda Bidang Pembinaan dibantu oleh jajaran unit kerja di bawahnya yang terdiri dari Sekretariat JAMBIN, 6 (enam) Biro (Biro Perencanaan, Biro Umum, Biro Kepegawaian, Biro Keuangan, Biro Perlengkapan, Biro Hukum dan HLN), serta 3 (tiga) Pusat (Pusat Strategi Kebijakan Penegakan Hukum, Pusat Data Statistik Kriminal dan Teknologi Informasi, Pusat Kesehatan Yustisial).', ['size' => 11], ['alignment' => Jc::BOTH, 'spaceAfter' => 120]);

        // E. Isu Terkini
        $section->addText('E. Isu Terkini', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['spaceBefore' => 120, 'spaceAfter' => 80]);
        $isuList = [
            '1. Penguatan Sistem Merit ASN Kejaksaan: konsolidasi hasil penilaian KASN dan keberlanjutan indeks merit.',
            '2. Manajemen SDM & Talent Pool: penataan karier, mutasi–promosi berbasis kinerja dan kompetensi.',
            '3. Disiplin & Integritas Aparatur: pengawasan internal, penegakan kode etik, dan pencegahan pelanggaran.',
            '4. Reformasi Birokrasi & Zona Integritas: peningkatan WBK/WBBM dan kualitas layanan internal.',
            '5. Transformasi Digital Pembinaan: digitalisasi kepegawaian, kinerja, dan administrasi.',
            '6. Efisiensi Anggaran & Kinerja Organisasi: penajaman perencanaan, penganggaran berbasis hasil.',
            '7. Peningkatan Kompetensi SDM: pelatihan berkelanjutan, adaptasi regulasi dan teknologi baru.',
        ];
        foreach ($isuList as $isu) {
            $section->addText($isu, ['size' => 11], ['alignment' => Jc::BOTH, 'spaceAfter' => 40]);
        }
        $section->addTextBreak(1);

        // F. Profil Pegawai
        $section->addText('F. Profil Pegawai pada Jaksa Agung Muda Bidang Pembinaan', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['spaceBefore' => 120, 'spaceAfter' => 80]);
        $section->addText(
            'Salah satu kunci keberhasilan pencapaian kinerja adalah dengan didukungnya sumber daya manusia yang mempunyai kompetensi dan mampu bekerja dengan optimal untuk mencapai target kinerja dan mewujudkan visi dan misi Jaksa Agung Muda Pembinaan. Saat ini jumlah pegawai di lingkungan Jaksa Agung Muda Bidang Pembinaan baik Jaksa maupun TU sebanyak 2.974 pegawai (94% Tata Usaha dan 6% Jaksa).',
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 120]
        );

        $section->addPageBreak();
    }

    private function addBab2PerencanaanKinerja(PhpWord $phpWord, int $tahun, string $twRomawi, array $sasaranData): void
    {
        $section = $phpWord->addSection();

        $section->addText('BAB II', ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER]);
        $section->addText('PERENCANAAN KINERJA', ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);

        $section->addText(
            "Dalam rangka melaksanakan tugas dan fungsinya agar efektif, efisien dan akuntabel, Jaksa Agung Muda Bidang Pembinaan berpedoman pada dokumen perencanaan yang terdiri dari: (1) Rencana Strategis (Renstra) Kejaksaan Republik Indonesia Tahun 2025-2029 (2) Rencana Kinerja Tahunan (RKT) Kejaksaan Republik Indonesia Tahun {$tahun}; dan (3) Perjanjian Kinerja Jaksa Agung Muda Pembinaan Tahun {$tahun}.",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 120]
        );

        // A. Renstra
        $section->addText('A. Rencana Strategis Jaksa Agung Muda Bidang Pembinaan', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['spaceBefore' => 120, 'spaceAfter' => 80]);
        $section->addText(
            'Sebagaimana diamanatkan dalam Undang-Undang Nomor 59 Tahun 2024 tentang Rencana Pembangunan Jangka Panjang Nasional Tahun 2025-2045 yang berlaku 20 (dua puluh) tahunan, perlu disusun dokumen perencanaan strategis kementrian/Lembaga yang berlaku 5 (lima) tahunan sebagai dasar pelaksanaan program dan kegiatan selama periode 2025-2029. Mengingat mandat yang sangat penting dan harus dilaksanakan, maka diperlukan adanya suatu perencanaan pembangunan yang berkualitas dan menjamin kegiatan pembangunan berjalan secara efektif, efisien serta tepat bersasaran.',
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 100]
        );

        $section->addText('1. Pernyataan Visi dan Misi', ['bold' => true, 'size' => 11], ['spaceAfter' => 40]);
        $section->addText(
            'Visi Kejaksaan Republik Indonesia 2025-2029:',
            ['italic' => true, 'size' => 11],
            ['alignment' => Jc::BOTH]
        );
        $section->addText(
            '"Kejaksaan Republik Indonesia Yang Andal, Profesional, Inovatif dan Berintegritas Dalam Pelayanan Kepada Presiden dan Wakil Presiden untuk Mewujudkan Indonesia Maju Yang Berdaulat, Mandiri, Dan Berkepribadian Berlandaskan Gotong Royong"',
            ['italic' => true, 'size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 60]
        );
        $section->addText('Misi Jaksa Agung Muda Bidang Pembinaan:', ['bold' => true, 'size' => 11], ['spaceAfter' => 40]);
        $section->addText('1) Memperkuat tata kelola Kejaksaan RI dalam penegakan hukum dan pelayanan publik;', ['size' => 11], ['spaceAfter' => 40]);
        $section->addText('2) Membentuk aparatur Kejaksaan RI yang menjadi panutan (role model) penegak hukum yang profesional dan berintegritas.', ['size' => 11], ['spaceAfter' => 80]);

        $section->addText('2. Tujuan', ['bold' => true, 'size' => 11], ['spaceAfter' => 40]);
        $section->addText('1. Memperkuat tata kelola Kejaksaan RI dalam penegakan hukum dan pelayanan publik (Indikator: Indeks kepuasan satuan kerja Kejaksaan atas layanan hukum).', ['size' => 11], ['spaceAfter' => 40]);
        $section->addText('2. Membentuk aparatur Kejaksaan RI yang menjadi panutan (role model) penegak hukum yang profesional dan berintegritas (Indikator: Indeks Profesionalitas SDM Kejaksaan RI).', ['size' => 11], ['spaceAfter' => 80]);

        $section->addText('3. Sasaran Strategis', ['bold' => true, 'size' => 11], ['spaceAfter' => 40]);
        $section->addText('a) Memperkuat tata kelola Kejaksaan RI dalam penegakan hukum dan pelayanan publik (Indikator: Indeks kepuasan satuan kerja Kejaksaan atas layanan hukum).', ['size' => 11], ['spaceAfter' => 40]);
        $section->addText('b) Membentuk aparatur Kejaksaan RI yang menjadi panutan (role model) penegak hukum yang profesional dan berintegritas (Indikator: Indeks Profesionalitas SDM Kejaksaan RI).', ['size' => 11], ['spaceAfter' => 140]);

        // B. Perjanjian Kinerja
        $section->addText('B. Perjanjian Kinerja', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['spaceBefore' => 120, 'spaceAfter' => 80]);
        $section->addText(
            "Perjanjian Kinerja pada dasarnya adalah pernyataan komitmen yang merepresentasikan tekad dan janji untuk mencapai kinerja yang jelas dan terukur dalam rentang waktu satu tahun tertentu, dengan mempertimbangkan sumber daya yang dikelola. Jaksa Agung Muda Bidang Pembinaan telah menyusun Perjanjian Kinerja tahun {$tahun} secara berjenjang sesuai dengan kedudukan, tugas, dan fungsinya sebagai berikut:",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 80]
        );

        $table = $section->addTable('ReportTable');
        $table->addRow();
        $table->addCell(600, ['bgColor' => '1B365D'])->addText('No', ['bold' => true, 'color' => 'FFFFFF', 'size' => 10], ['alignment' => Jc::CENTER]);
        $table->addCell(3500, ['bgColor' => '1B365D'])->addText('Sasaran Program', ['bold' => true, 'color' => 'FFFFFF', 'size' => 10], ['alignment' => Jc::CENTER]);
        $table->addCell(4000, ['bgColor' => '1B365D'])->addText('Indikator Kinerja Utama', ['bold' => true, 'color' => 'FFFFFF', 'size' => 10], ['alignment' => Jc::CENTER]);
        $table->addCell(1500, ['bgColor' => '1B365D'])->addText("Target {$tahun}", ['bold' => true, 'color' => 'FFFFFF', 'size' => 10], ['alignment' => Jc::CENTER]);

        $no = 1;
        foreach ($sasaranData as $sasaran) {
            $first = true;
            foreach ($sasaran['ikp_list'] as $ikp) {
                $table->addRow();
                if ($first) {
                    $table->addCell(600)->addText((string)$no, ['size' => 9], ['alignment' => Jc::CENTER]);
                    $table->addCell(3500)->addText($sasaran['nama_sp'], ['size' => 9]);
                    $first = false;
                } else {
                    $table->addCell(600)->addText('', ['size' => 9]);
                    $table->addCell(3500)->addText('', ['size' => 9]);
                }

                $table->addCell(4000)->addText($ikp['nama_ikp'], ['size' => 9]);
                $table->addCell(1500)->addText($this->formatTargetDisplay($ikp['target'], $ikp['satuan']), ['size' => 9], ['alignment' => Jc::CENTER]);
            }
            $no++;
        }

        $section->addTextBreak(1);

        // C. Pengukuran Capaian Kinerja
        $section->addText("C. Pengukuran Capaian Kinerja Tahun {$tahun}", ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['spaceBefore' => 120, 'spaceAfter' => 80]);
        $section->addText(
            'Pengukuran tingkat capaian Indikator Kinerja Utama (IKU) dilakukan dengan berpedoman pada formula penghitungan yang telah ditetapkan dalam Informasi Indikator Kinerja atau Manual IKU. Selanjutnya nilai capaian tersebut dihitung dengan membandingkan antara realisasi capaian dengan target yang telah ditetapkan dan pengukuran capaian kinerja dilakukan secara berkala melalui penyusunan laporan kinerja triwulanan.',
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 120]
        );

        $section->addPageBreak();
    }

    private function addBab3AkuntabilitasKinerja(PhpWord $phpWord, int $tahun, string $twRomawi, array $sasaranData): void
    {
        $section = $phpWord->addSection();

        $section->addText('BAB III', ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER]);
        $section->addText('AKUNTABILITAS KINERJA', ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);

        // A. Capaian Kinerja Organisasi
        $section->addText('A. CAPAIAN KINERJA ORGANISASI', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['spaceBefore' => 120, 'spaceAfter' => 80]);
        $section->addText(
            "Pengukuran kinerja Jaksa Agung Muda Bidang Pembinaan mengacu kepada target kinerja yang tercantum dalam dokumen Rencana Strategis Kejaksaan Republik Indonesia Tahun 2025-2029, Dokumen Rencana Kerja Kejaksaan Republik Indonesia Tahun {$tahun} dan Perjanjian Kinerja Jaksa Agung Muda Pembinaan Tahun {$tahun} disandingkan dengan realisasi capaian kinerja Jaksa Agung Muda Bidang Pembinaan sampai dengan Triwulan {$twRomawi}.",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 120]
        );

        // B. Analisis Capaian Kinerja
        $section->addText('B. ANALISIS CAPAIAN KINERJA', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['spaceBefore' => 140, 'spaceAfter' => 80]);
        $section->addText(
            "Bahwa berdasarkan Peraturan Jaksa Agung RI Nomor 4 Tahun 2025 tentang Rencana Strategis Kejaksaan RI Tahun 2025-2029, Jaksa Agung Muda Pembinaan memperoleh tanggung jawab untuk melaksanakan 11 Sasaran Program yang dijabarkan dalam 19 Indikator Kinerja Program (IKP), dapat dijelaskan sebagai berikut:",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 120]
        );

        $no = 1;
        foreach ($sasaranData as $sasaran) {
            $section->addText("{$no}. " . strtoupper($sasaran['nama_sp']), ['bold' => true, 'size' => 11, 'color' => '1B365D'], ['spaceBefore' => 120, 'spaceAfter' => 60]);

            foreach ($sasaran['ikp_list'] as $ikp) {
                $section->addText("• {$ikp['nama_ikp']}", ['bold' => true, 'size' => 11, 'color' => '1B365D'], ['spaceBefore' => 60, 'spaceAfter' => 40]);

                // Render Rumus Besar, Bernarasi, dan Perhitungan Visual
                $this->addVisualFormulaBlock($section, $ikp, $tahun, $twRomawi);

                // Sub Table Target vs Realisasi
                $table = $section->addTable('SubTable');
                $table->addRow();
                $table->addCell(3000, ['bgColor' => 'EAEAEA'])->addText('Target ' . $tahun, ['bold' => true, 'size' => 10], ['alignment' => Jc::CENTER]);
                $table->addCell(3000, ['bgColor' => 'EAEAEA'])->addText("Nilai Realisasi TW {$twRomawi}", ['bold' => true, 'size' => 10], ['alignment' => Jc::CENTER]);
                $table->addCell(3000, ['bgColor' => 'EAEAEA'])->addText('Capaian Kinerja (%)', ['bold' => true, 'size' => 10], ['alignment' => Jc::CENTER]);

                $table->addRow();
                $table->addCell(3000)->addText($this->formatTargetDisplay($ikp['target'], $ikp['satuan']), ['size' => 10], ['alignment' => Jc::CENTER]);
                $table->addCell(3000)->addText($this->formatRealisasiDisplay($ikp['realisasi'], $ikp['satuan']), ['size' => 10], ['alignment' => Jc::CENTER]);
                $table->addCell(3000)->addText($this->percent($ikp['capaian']), ['bold' => true, 'size' => 10], ['alignment' => Jc::CENTER]);

                $section->addTextBreak(1);

                // Analisis Capaian Kinerja (menggunakan data riil atau teks analisis baku komprehensif)
                $realisasiDisp = $this->formatRealisasiDisplay($ikp['realisasi'], $ikp['satuan']);
                $targetDisp = $this->formatTargetDisplay($ikp['target'], $ikp['satuan']);
                $capaianDisp = $this->percent($ikp['capaian']);

                $analisisText = !empty($ikp['analisis_capaian'])
                    ? $ikp['analisis_capaian']
                    : "Berdasarkan hasil pengukuran sampai dengan Triwulan {$twRomawi} Tahun {$tahun}, indikator kinerja \"{$ikp['nama_ikp']}\" mencatatkan realisasi sebesar {$realisasiDisp} dari target yang ditetapkan sebesar {$targetDisp}, sehingga menghasilkan capaian kinerja sebesar {$capaianDisp}. Capaian ini menunjukkan efektivitas pelaksanaan program kerja serta kepatuhan unit kerja penanggung jawab terhadap target Perjanjian Kinerja yang telah disepakati.";

                $section->addText('Analisis Capaian Kinerja:', ['bold' => true, 'size' => 10, 'color' => '1B365D'], ['spaceAfter' => 20]);
                $section->addText($analisisText, ['size' => 10], ['alignment' => Jc::BOTH, 'spaceAfter' => 60]);

                // Faktor Penghambat / Kendala
                $kendalaText = !empty($ikp['kendala'])
                    ? $ikp['kendala']
                    : "Dalam pelaksanaan program dan kegiatan sampai dengan Triwulan {$twRomawi} Tahun {$tahun}, tidak dijumpai kendala operasional yang bersifat menghambat ketercapaian target. Seluruh aktivitas terlaksana sesuai dengan alokasi sumber daya dan jadwal yang direncanakan.";

                $section->addText('Faktor Penghambat / Kendala:', ['bold' => true, 'size' => 10, 'color' => '8B0000'], ['spaceAfter' => 20]);
                $section->addText($kendalaText, ['size' => 10], ['alignment' => Jc::BOTH, 'spaceAfter' => 60]);

                // Strategi / Upaya Optimalisasi
                $upayaText = !empty($ikp['upaya'])
                    ? $ikp['upaya']
                    : "Sebagai langkah percepatan dan kesinambungan hasil, Jaksa Agung Muda Bidang Pembinaan senantiasa melaksanakan monitoring berkala, penguatan koordinasi antar unit kerja, dan optimalisasi sistem informasi guna memastikan tren positif capaian kinerja terjaga pada triwulan berikutnya.";

                $section->addText('Strategi / Upaya Optimalisasi:', ['bold' => true, 'size' => 10, 'color' => '006400'], ['spaceAfter' => 20]);
                $section->addText($upayaText, ['size' => 10], ['alignment' => Jc::BOTH, 'spaceAfter' => 80]);

                // Render SK & IKK children under this IKP if available
                if (!empty($ikp['sk_list'])) {
                    foreach ($ikp['sk_list'] as $sk) {
                        $section->addText("    Sasaran Kegiatan: {$sk['nama_sk']}", ['bold' => true, 'size' => 10], ['spaceBefore' => 40, 'spaceAfter' => 20]);

                        if (!empty($sk['ikk_list'])) {
                            $tIkk = $section->addTable('SubTable');
                            $tIkk->addRow();
                            $tIkk->addCell(1000, ['bgColor' => 'F2F2F2'])->addText('Kode', ['bold' => true, 'size' => 9]);
                            $tIkk->addCell(4000, ['bgColor' => 'F2F2F2'])->addText('Indikator Kinerja Kegiatan (IKK)', ['bold' => true, 'size' => 9]);
                            $tIkk->addCell(1200, ['bgColor' => 'F2F2F2'])->addText('Target', ['bold' => true, 'size' => 9], ['alignment' => Jc::CENTER]);
                            $tIkk->addCell(1200, ['bgColor' => 'F2F2F2'])->addText('Realisasi', ['bold' => true, 'size' => 9], ['alignment' => Jc::CENTER]);
                            $tIkk->addCell(1200, ['bgColor' => 'F2F2F2'])->addText('Capaian', ['bold' => true, 'size' => 9], ['alignment' => Jc::CENTER]);

                            foreach ($sk['ikk_list'] as $ikk) {
                                $tIkk->addRow();
                                $tIkk->addCell(1000)->addText($ikk['kode_ikk'], ['size' => 9]);
                                $tIkk->addCell(4000)->addText($ikk['nama_ikk'], ['size' => 9]);
                                $tIkk->addCell(1200)->addText($this->formatTargetDisplay($ikk['target'], $ikk['satuan']), ['size' => 9], ['alignment' => Jc::CENTER]);
                                $tIkk->addCell(1200)->addText($this->formatRealisasiDisplay($ikk['realisasi'], $ikk['satuan']), ['size' => 9], ['alignment' => Jc::CENTER]);
                                $tIkk->addCell(1200)->addText($this->percent($ikk['capaian']), ['size' => 9], ['alignment' => Jc::CENTER]);
                            }
                            $section->addTextBreak(1);
                        }
                    }
                }
            }
            $no++;
        }

        // C. Realisasi Anggaran
        $section->addText('C. REALISASI ANGGARAN', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['spaceBefore' => 140, 'spaceAfter' => 80]);
        $section->addText(
            "Berdasarkan hasil monitoring periode pelaksanaan Triwulan {$twRomawi} Tahun {$tahun}, serapan anggaran Jaksa Agung Muda Bidang Pembinaan dioptimalkan untuk mendukung seluruh program prioritas dan operasional perkantoran.",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 120]
        );

        $section->addPageBreak();
    }

    private function addBab4Penutup(PhpWord $phpWord, int $tahun, string $twRomawi): void
    {
        $section = $phpWord->addSection();

        $section->addText('BAB IV', ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER]);
        $section->addText('PENUTUP', ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 200]);

        $section->addText(
            "Secara umum, pencapaian target Rencana Kinerja Tahunan Jaksa Agung Muda Bidang Pembinaan pada Triwulan {$twRomawi} Tahun {$tahun} telah berjalan dengan baik dan sebagian besar indikator kinerja telah memenuhi target yang ditetapkan. Namun demikian, terdapat beberapa target yang proses pengukurannya bersifat tahunan atau baru optimal pada triwulan berikutnya, serta beberapa kegiatan rencana kerja yang masih berproses.",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 120]
        );

        $section->addText(
            "Demikian Laporan Kinerja Triwulan {$twRomawi} Jaksa Agung Muda Bidang Pembinaan Tahun {$tahun} disusun sebagai instrumen akuntabilitas dan monitoring kinerja, dengan harapan dapat menjadi bahan pertimbangan dalam pengambilan kebijakan dan peningkatan kinerja pada periode triwulan selanjutnya.",
            ['size' => 11],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 140]
        );
    }

    private function collectSasaranAndIkpData(int $tahun, int $triwulan): array
    {
        $programCodes = (require database_path('data/jambin_architecture_v3.php'))['programs'];
        $sps = Sp::whereHas('node', fn ($q) => $q->whereIn('source_key', array_map(fn ($code) => 'SP:'.$code, $programCodes)))->with([
            'node.targets',
            'node.pengukurans.inputs',
            'node.children.ikp.node.targets',
            'node.children.ikp.node.pengukurans.inputs',
            'node.children.ikp.node.formulas.components',
            'node.children.ikp.node.children.sk.node.children.ikk.node.targets',
            'node.children.ikp.node.children.sk.node.children.ikk.node.pengukurans.inputs',
            'node.children.ikp.node.children.sk.node.children.ikk.node.formulas.components',
        ])
            ->orderBy('kode_sp')
            ->get();

        $data = [];

        foreach ($sps as $sp) {
            $spNode = $sp->node;
            $spPengukuran = $this->pengukuran($sp->node_id, $tahun, $triwulan);

            $ikpList = [];
            foreach ($this->childrenOfType($spNode, 'IKP') as $ikpNode) {
                $ikp = $ikpNode->ikp;
                if (!$ikp) {
                    continue;
                }

                $ikpPengukuran = $this->pengukuran($ikp->node_id, $tahun, $triwulan);
                $ikpTarget = $this->target($ikp->node_id, $tahun, $ikpPengukuran, $triwulan);

                // Collect SK list under IKP
                $skList = [];
                foreach ($this->childrenOfType($ikpNode, 'SK') as $skNode) {
                    $sk = $skNode->sk;
                    if (!$sk) {
                        continue;
                    }

                    $ikkList = [];
                    foreach ($this->childrenOfType($skNode, 'IKK') as $ikkNode) {
                        $ikk = $ikkNode->ikk;
                        if (!$ikk) {
                            continue;
                        }

                        $ikkPengukuran = $this->pengukuran($ikk->node_id, $tahun, $triwulan);
                        $ikkTarget = $this->target($ikk->node_id, $tahun, $ikkPengukuran, $triwulan);
                        $ikkFormula = $ikkNode->formulas->firstWhere('is_active', true) ?? $ikkNode->formulas->first();
                        $ikkFormulaTeks = $ikkFormula?->rumus_tampilan ?? $ikkFormula?->deskripsi_rumus ?? '';
                        $ikkKomponenList = $this->extractKomponenRumusList($ikkNode, $ikkPengukuran);

                        $ikkList[] = [
                            'kode_ikk' => $ikk->kode_ikk,
                            'nama_ikk' => $ikk->nama_ikk,
                            'satuan' => $ikkNode->satuan ?? '%',
                            'formula' => $ikkFormulaTeks,
                            'komponen_list' => $ikkKomponenList,
                            'target' => $ikkTarget?->nilai_target,
                            'realisasi' => $ikkPengukuran?->realisasi,
                            'capaian' => $ikkPengukuran?->capaian,
                            'analisis' => $ikkPengukuran?->analisis_capaian,
                        ];
                    }

                    $skList[] = [
                        'kode_sk' => $sk->kode_sk,
                        'nama_sk' => $sk->nama_sk,
                        'penanggung_jawab' => $sk->penanggung_jawab_teks,
                        'ikk_list' => $ikkList,
                    ];
                }

                $ikpFormula = $ikpNode->formulas->firstWhere('is_active', true) ?? $ikpNode->formulas->first();
                $ikpFormulaTeks = $ikpFormula?->rumus_tampilan ?? $ikpFormula?->deskripsi_rumus ?? '';
                $ikpKomponenList = $this->extractKomponenRumusList($ikpNode, $ikpPengukuran);
                $ikpCalcText = $this->formatPerhitunganTeks($ikpKomponenList, $ikpPengukuran);

                $ikpList[] = [
                    'kode_ikp' => $ikp->kode_ikp,
                    'nama_ikp' => $ikp->nama_ikp,
                    'satuan' => $ikpNode->satuan ?? '',
                    'calculation_type' => $ikpNode->calculation_type?->value ?? (string) $ikpNode->calculation_type,
                    'formula' => $ikpFormulaTeks,
                    'komponen_list' => $ikpKomponenList,
                    'calculation_text' => $ikpCalcText,
                    'target' => $ikpTarget?->nilai_target,
                    'realisasi' => $ikpPengukuran?->realisasi,
                    'capaian' => $ikpPengukuran?->capaian,
                    'kendala' => $ikpPengukuran?->kendala,
                    'upaya' => $ikpPengukuran?->upaya,
                    'analisis_capaian' => $ikpPengukuran?->analisis_capaian,
                    'sk_list' => $skList,
                ];
            }

            $data[] = [
                'kode_sp' => $sp->kode_sp,
                'nama_sp' => $sp->nama_sp,
                'nama_program' => $sp->nama_program,
                'penanggung_jawab' => $sp->penanggung_jawab_teks,
                'capaian' => $spPengukuran?->capaian,
                'ikp_list' => $ikpList,
            ];
        }

        return $data;
    }

    private function childrenOfType(?KinerjaNode $node, string $type)
    {
        return $node?->children?->filter(function ($child) use ($type) {
            $nodeType = $child->jenis_node?->value ?? (string) $child->jenis_node;
            $relationType = strtoupper((string) $child->pivot?->jenis_relasi);

            return $nodeType === $type && in_array($relationType, ['STRUCTURAL', 'CASCADING', 'CONTRIBUTION'], true);
        }) ?? collect();
    }

    private function pengukuran(int $nodeId, int $tahun, int $triwulan): ?Pengukuran
    {
        return Pengukuran::with('inputs')
            ->where('node_id', $nodeId)
            ->where('tahun', $tahun)
            ->where('triwulan', $triwulan)
            ->orderByDesc('approved_at')
            ->orderByDesc('verified_at')
            ->orderByDesc('submitted_at')
            ->orderByDesc('updated_at')
            ->first();
    }

    private function extractKomponenRumusList(?KinerjaNode $node, ?Pengukuran $pengukuran): array
    {
        if (!$node) {
            return [];
        }

        $formula = $node->formulas->firstWhere('is_active', true) ?? $node->formulas->first();
        if (!$formula) {
            return [];
        }

        $components = $formula->components;
        if ($components->isEmpty()) {
            return [];
        }

        $komponenList = [];
        $inputs = $pengukuran?->inputs ?? collect();
        $calcComponents = $pengukuran?->calculation_trace['components'] ?? [];

        foreach ($components as $komp) {
            $input = $inputs->first(function ($item) use ($komp) {
                if ($item->komponen_rumus_id && (int) $item->komponen_rumus_id === (int) $komp->id) {
                    return true;
                }
                if ($item->input_key && (
                    strcasecmp($item->input_key, $komp->kode_komponen) === 0
                    || ($komp->input_key && strcasecmp($item->input_key, $komp->input_key) === 0)
                )) {
                    return true;
                }
                return false;
            });

            $nilai = null;
            if ($input !== null && $input->nilai !== null) {
                $nilai = (float) $input->nilai;
            } elseif (strtolower($komp->kode_komponen) === 'pembilang' && $pengukuran?->pembilang !== null) {
                $nilai = (float) $pengukuran->pembilang;
            } elseif (strtolower($komp->kode_komponen) === 'penyebut' && $pengukuran?->penyebut !== null) {
                $nilai = (float) $pengukuran->penyebut;
            } elseif (isset($calcComponents[$komp->kode_komponen])) {
                $nilai = (float) $calcComponents[$komp->kode_komponen];
            } elseif ($komp->input_key && isset($calcComponents[$komp->input_key])) {
                $nilai = (float) $calcComponents[$komp->input_key];
            }

            $komponenList[] = [
                'kode' => $komp->kode_komponen,
                'nama' => $komp->nama_komponen,
                'bobot' => $komp->bobot !== null ? (float) $komp->bobot : null,
                'nilai' => $nilai,
            ];
        }

        return $komponenList;
    }

    private function formatPerhitunganTeks(array $komponenList, ?Pengukuran $pengukuran): ?string
    {
        if (!$pengukuran || empty($komponenList)) {
            return null;
        }

        // Check if ratio (pembilang & penyebut)
        $pembilang = null;
        $penyebut = null;
        foreach ($komponenList as $k) {
            if (strtolower($k['kode']) === 'pembilang') {
                $pembilang = $k['nilai'];
            } elseif (strtolower($k['kode']) === 'penyebut') {
                $penyebut = $k['nilai'];
            }
        }

        if ($pembilang !== null && $penyebut !== null && $penyebut != 0) {
            $pemStr = number_format($pembilang, 2, ',', '.');
            $penStr = number_format($penyebut, 2, ',', '.');
            $realStr = $pengukuran->realisasi !== null ? number_format((float) $pengukuran->realisasi, 2, ',', '.') : '-';
            return "Perhitungan: ({$pemStr} / {$penStr}) × 100% = {$realStr}%";
        }

        // Check if weighted sum
        $hasWeights = false;
        $parts = [];
        foreach ($komponenList as $k) {
            if ($k['nilai'] !== null) {
                $vStr = number_format($k['nilai'], 2, ',', '.');
                if ($k['bobot'] !== null) {
                    $hasWeights = true;
                    $parts[] = "({$vStr} × " . ($k['bobot'] * 100) . "%)";
                } else {
                    $parts[] = $vStr;
                }
            }
        }

        if ($hasWeights && count($parts) > 1) {
            $realStr = $pengukuran->realisasi !== null ? number_format((float) $pengukuran->realisasi, 2, ',', '.') : '-';
            return "Perhitungan: " . implode(' + ', $parts) . " = {$realStr}";
        }

        return null;
    }

    private function target(int $nodeId, int $tahun, ?Pengukuran $pengukuran = null, int $triwulan = 4): ?Target
    {
        if ($pengukuran?->isFinal() || $pengukuran?->target_snapshot !== null) {
            $target = new Target();
            $target->nilai_target = $pengukuran->target_snapshot;
            return $target;
        }

        return app(TargetResolver::class)->resolve($nodeId, $tahun, $triwulan);
    }

    private function formatTargetDisplay(mixed $value, ?string $satuan = null): string
    {
        if ($value === null || $value === '') {
            return '-';
        }
        $formatted = is_numeric($value) ? number_format((float) $value, 2, ',', '.') : (string) $value;
        return $satuan && !str_contains($formatted, '%') && strtolower($satuan) === '%' ? "{$formatted}%" : $formatted;
    }

    private function formatRealisasiDisplay(mixed $value, ?string $satuan = null): string
    {
        if ($value === null || $value === '') {
            return '-';
        }
        $formatted = is_numeric($value) ? number_format((float) $value, 2, ',', '.') : (string) $value;
        return $satuan && !str_contains($formatted, '%') && strtolower($satuan) === '%' ? "{$formatted}%" : $formatted;
    }

    private function percent(mixed $value): string
    {
        $number = $this->numeric($value);

        return $number === null ? '-' : number_format($number, 2, ',', '.') . '%';
    }

    private function numeric(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return is_numeric($value) ? (float) $value : null;
    }

    /**
     * Render blok visual rumus bertingkat (besar, pecahan fraksi, substitusi angka, dan narasi pengantar).
     */
    private function addVisualFormulaBlock(Section $section, array $ikp, int $tahun, string $twRomawi): void
    {
        // 1. Narasi Pengantar Resmi
        $section->addText(
            "Untuk mengukur keberhasilan indikator kinerja sasaran program \"{$ikp['nama_ikp']}\" dihitung berdasarkan formulasi sebagai berikut:",
            ['size' => 10, 'italic' => true, 'color' => '333333'],
            ['alignment' => Jc::BOTH, 'spaceBefore' => 30, 'spaceAfter' => 30]
        );

        if (!empty($ikp['formula'])) {
            $section->addText(
                "Formulasi Resmi (Kepja 1184/2025): {$ikp['formula']}",
                ['bold' => true, 'size' => 9.5, 'color' => '1B365D'],
                ['spaceAfter' => 40]
            );
        }

        $komponenList = $ikp['komponen_list'] ?? [];
        $satuan = !empty($ikp['satuan']) ? $ikp['satuan'] : '';
        $calcType = strtoupper((string) ($ikp['calculation_type'] ?? ''));

        // Deteksi apakah rumus berupa rasio pembagian (pembilang & penyebut)
        $pembilang = null;
        $penyebut = null;
        foreach ($komponenList as $k) {
            $code = strtolower($k['kode'] ?? '');
            if (in_array($code, ['pembilang', 'x1', 'a'], true)) {
                $pembilang = $k;
            } elseif (in_array($code, ['penyebut', 'x2', 'b'], true)) {
                $penyebut = $k;
            }
        }
        if (!$pembilang && count($komponenList) >= 2) {
            $pembilang = $komponenList[0];
            $penyebut = $komponenList[1];
        }

        $isRatio = ($calcType === 'RATIO' || ($pembilang !== null && $penyebut !== null));
        $isWeighted = ($calcType === 'WEIGHTED_SUM' || (!empty($komponenList) && ($komponenList[0]['bobot'] ?? null) !== null));

        $realisasiStr = $this->formatRealisasiDisplay($ikp['realisasi'], $satuan);
        $targetStr = $this->formatTargetDisplay($ikp['target'], $satuan);
        $capaianStr = $this->percent($ikp['capaian']);

        $tForm = $section->addTable('FormulaTable');

        if ($isRatio && $pembilang && $penyebut) {
            $pemNama = $pembilang['nama'] ?? 'Pembilang';
            $penNama = $penyebut['nama'] ?? 'Penyebut';

            $pemValStr = $pembilang['nilai'] !== null ? number_format((float) $pembilang['nilai'], 2, ',', '.') . ($satuan ? " {$satuan}" : '') : '-';
            $penValStr = $penyebut['nilai'] !== null ? number_format((float) $penyebut['nilai'], 2, ',', '.') . ($satuan ? " {$satuan}" : '') : '-';

            $dashLine1 = str_repeat('-', 48) . ' × 100%';
            $dashLine2 = str_repeat('-', 28) . ' × 100%';

            // Row 0: Formulasi Simbolik Bersusun (Pecahan Atas-Bawah)
            $tForm->addRow();
            $tForm->addCell(2800)->addText($ikp['nama_ikp'], ['bold' => true, 'size' => 10, 'color' => '1B365D']);
            $tForm->addCell(400)->addText('=', ['bold' => true, 'size' => 11], ['alignment' => Jc::CENTER]);
            $cellMath0 = $tForm->addCell(6300);
            $cellMath0->addText($pemNama, ['bold' => true, 'size' => 9.5, 'color' => '222222']);
            $cellMath0->addText($dashLine1, ['bold' => true, 'size' => 9.5, 'color' => '444444']);
            $cellMath0->addText($penNama, ['bold' => true, 'size' => 9.5, 'color' => '222222']);

            // Row 1: Substitusi Angka Riil Hasil Pengukuran
            $tForm->addRow();
            $tForm->addCell(2800)->addText('', ['size' => 9]);
            $tForm->addCell(400)->addText('=', ['bold' => true, 'size' => 11], ['alignment' => Jc::CENTER]);
            $cellMath1 = $tForm->addCell(6300);
            $cellMath1->addText($pemValStr, ['bold' => true, 'size' => 10, 'color' => '1B365D']);
            $cellMath1->addText($dashLine2, ['bold' => true, 'size' => 10, 'color' => '444444']);
            $cellMath1->addText($penValStr, ['bold' => true, 'size' => 10, 'color' => '1B365D']);

            // Row 2: Hasil Akhir Capaian
            $tForm->addRow();
            $tForm->addCell(2800)->addText('', ['size' => 9]);
            $tForm->addCell(400)->addText('=', ['bold' => true, 'size' => 11], ['alignment' => Jc::CENTER]);
            $cellMath2 = $tForm->addCell(6300);
            $cellMath2->addText("{$realisasiStr}  (Target: {$targetStr} | Capaian Kinerja: {$capaianStr})", ['bold' => true, 'size' => 10, 'color' => '006400']);

        } elseif ($isWeighted) {
            $symParts = [];
            $numParts = [];
            $subtotals = [];

            foreach ($komponenList as $k) {
                $bPersen = ($k['bobot'] !== null) ? ($k['bobot'] * 100) . '%' : '100%';
                $symParts[] = "({$k['nama']} × {$bPersen})";

                if ($k['nilai'] !== null) {
                    $vStr = number_format((float) $k['nilai'], 2, ',', '.');
                    $numParts[] = "({$vStr} × {$bPersen})";
                    if ($k['bobot'] !== null) {
                        $subtotals[] = number_format((float) $k['nilai'] * (float) $k['bobot'], 2, ',', '.');
                    }
                }
            }

            // Row 0: Formulasi Simbolik
            $tForm->addRow();
            $tForm->addCell(2800)->addText($ikp['nama_ikp'], ['bold' => true, 'size' => 10, 'color' => '1B365D']);
            $tForm->addCell(400)->addText('=', ['bold' => true, 'size' => 11], ['alignment' => Jc::CENTER]);
            $cellMath0 = $tForm->addCell(6300);
            $cellMath0->addText(implode(" + \n", $symParts), ['bold' => true, 'size' => 9.5, 'color' => '222222']);

            // Row 1: Substitusi Angka
            $tForm->addRow();
            $tForm->addCell(2800)->addText('', ['size' => 9]);
            $tForm->addCell(400)->addText('=', ['bold' => true, 'size' => 11], ['alignment' => Jc::CENTER]);
            $cellMath1 = $tForm->addCell(6300);
            $cellMath1->addText(!empty($numParts) ? implode(' + ', $numParts) : '-', ['bold' => true, 'size' => 10, 'color' => '1B365D']);

            // Row 2: Hasil Akhir
            $tForm->addRow();
            $tForm->addCell(2800)->addText('', ['size' => 9]);
            $tForm->addCell(400)->addText('=', ['bold' => true, 'size' => 11], ['alignment' => Jc::CENTER]);
            $cellMath2 = $tForm->addCell(6300);
            $subtotalText = !empty($subtotals) ? implode(' + ', $subtotals) . " = " : "";
            $cellMath2->addText("{$subtotalText}{$realisasiStr}  (Target: {$targetStr} | Capaian Kinerja: {$capaianStr})", ['bold' => true, 'size' => 10, 'color' => '006400']);

        } else {
            // General / Direct Value formula
            $tForm->addRow();
            $tForm->addCell(2800)->addText($ikp['nama_ikp'], ['bold' => true, 'size' => 10, 'color' => '1B365D']);
            $tForm->addCell(400)->addText('=', ['bold' => true, 'size' => 11], ['alignment' => Jc::CENTER]);
            $cellMath0 = $tForm->addCell(6300);
            $formulaDef = !empty($ikp['formula']) ? $ikp['formula'] : 'Pengukuran Realisasi Kinerja Periode Pelaporan Berjalan';
            $cellMath0->addText($formulaDef, ['italic' => true, 'size' => 9.5, 'color' => '333333']);

            $tForm->addRow();
            $tForm->addCell(2800)->addText('', ['size' => 9]);
            $tForm->addCell(400)->addText('=', ['bold' => true, 'size' => 11], ['alignment' => Jc::CENTER]);
            $cellMath1 = $tForm->addCell(6300);
            $cellMath1->addText("Realisasi: {$realisasiStr}  (Target: {$targetStr} | Capaian Kinerja: {$capaianStr})", ['bold' => true, 'size' => 10, 'color' => '006400']);
        }

        $section->addTextBreak(1);

        // 2. Rincian Komponen & Nilai Input Mentah (Jika Ada)
        if (!empty($komponenList)) {
            $section->addText('Rincian Komponen & Nilai Input Pengukuran:', ['bold' => true, 'size' => 9.5, 'color' => '222222'], ['spaceBefore' => 20, 'spaceAfter' => 20]);

            $tKomp = $section->addTable('SubTable');
            $tKomp->addRow();
            $tKomp->addCell(1200, ['bgColor' => 'EAEAEA'])->addText('Kode', ['bold' => true, 'size' => 9], ['alignment' => Jc::CENTER]);
            $tKomp->addCell(5000, ['bgColor' => 'EAEAEA'])->addText('Nama Komponen / Variabel', ['bold' => true, 'size' => 9]);
            $tKomp->addCell(1400, ['bgColor' => 'EAEAEA'])->addText('Bobot', ['bold' => true, 'size' => 9], ['alignment' => Jc::CENTER]);
            $tKomp->addCell(1400, ['bgColor' => 'EAEAEA'])->addText('Nilai Input', ['bold' => true, 'size' => 9], ['alignment' => Jc::CENTER]);

            foreach ($komponenList as $k) {
                $tKomp->addRow();
                $tKomp->addCell(1200)->addText($k['kode'] ?? '-', ['size' => 9], ['alignment' => Jc::CENTER]);
                $tKomp->addCell(5000)->addText($k['nama'] ?? '-', ['size' => 9]);
                $tKomp->addCell(1400)->addText($k['bobot'] !== null ? ($k['bobot'] * 100) . '%' : '-', ['size' => 9], ['alignment' => Jc::CENTER]);
                $tKomp->addCell(1400)->addText($k['nilai'] !== null ? number_format((float) $k['nilai'], 2, ',', '.') : '-', ['bold' => true, 'size' => 9], ['alignment' => Jc::CENTER]);
            }
            $section->addTextBreak(1);
        }
    }

    /**
     * Generate laporan menggunakan template kustom Word (.docx) via TemplateProcessor.
     */
    public function generateWithTemplateProcessor(ReportTemplate $template, int $tahun, int $triwulan, array $sasaranData): string
    {
        $twRomawi = $this->romawi[$triwulan] ?? (string) $triwulan;
        $fullTemplatePath = storage_path('app/' . $template->file_path);

        $processor = new TemplateProcessor($fullTemplatePath);

        // 1. Metadata dasar
        $processor->setValue('tahun', (string) $tahun);
        $processor->setValue('triwulan', (string) $triwulan);
        $processor->setValue('tw_romawi', $twRomawi);
        $processor->setValue('unit_kerja', 'JAKSA AGUNG MUDA BIDANG PEMBINAAN');
        $processor->setValue('tanggal_cetak', Carbon::now()->translatedFormat('d F Y'));
        $totalSp = count($sasaranData);
        $processor->setValue('total_sasaran_program', (string) $totalSp);

        $totalIkp = 0;
        $totalCapaian = 0;
        $countCapaian = 0;

        foreach ($sasaranData as $sp) {
            foreach ($sp['ikp_list'] as $ikp) {
                $totalIkp++;
                if ($ikp['capaian'] !== null) {
                    $totalCapaian += (float) $ikp['capaian'];
                    $countCapaian++;
                }
            }
        }

        $avgCapaian = $countCapaian > 0 ? ($totalCapaian / $countCapaian) : 0;
        $processor->setValue('total_ikp', (string) $totalIkp);
        $processor->setValue('rata_rata_capaian', number_format($avgCapaian, 2, ',', '.') . '%');

        // 2. Blok narasi resmi dokumen
        $processor->setValue('kata_pengantar', $this->getKataPengantarText($tahun, $twRomawi));
        $processor->setValue('ikhtisar_eksekutif', $this->getIkhtisarEksekutifText($tahun, $twRomawi, $totalSp, $totalIkp, $avgCapaian));
        $processor->setValue('bab1_pendahuluan', $this->getBab1Text($tahun, $twRomawi));
        $processor->setValue('bab2_perencanaan', $this->getBab2Text($tahun, $twRomawi));
        $processor->setValue('bab3_akuntabilitas', $this->getBab3SummaryText($tahun, $twRomawi, $sasaranData));
        $processor->setValue('bab4_penutup', $this->getBab4Text($tahun, $twRomawi));

        $fileName = "Laporan_Kinerja_TW_{$twRomawi}_Tahun_{$tahun}_JAMBIN.docx";
        $tempPath = $this->getExportTempPath($fileName);

        $processor->saveAs($tempPath);

        return $tempPath;
    }

    /**
     * Generate file master template sample (.docx) dengan tag variabel yang bisa diunduh Admin.
     */
    public function generateMasterTemplateSample(): string
    {
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $phpWord = new PhpWord();
        $this->setupStyles($phpWord);

        // Section 1: Cover
        $section = $phpWord->addSection([
            'marginTop' => 1440,
            'marginBottom' => 1440,
            'marginLeft' => 1440,
            'marginRight' => 1440,
        ]);

        $section->addText('KEJAKSAAN REPUBLIK INDONESIA', ['bold' => true, 'size' => 16, 'color' => '1B365D'], ['alignment' => Jc::CENTER]);
        $section->addText('${unit_kerja}', ['bold' => true, 'size' => 14, 'color' => '333333'], ['alignment' => Jc::CENTER]);
        $section->addTextBreak(5);

        $section->addText('LAPORAN KINERJA (LKjIP)', ['bold' => true, 'size' => 22, 'color' => '1B365D'], ['alignment' => Jc::CENTER]);
        $section->addText('TRIWULAN ${tw_romawi}', ['bold' => true, 'size' => 20, 'color' => 'C98A2C'], ['alignment' => Jc::CENTER]);
        $section->addText('TAHUN ANGGARAN ${tahun}', ['bold' => true, 'size' => 18, 'color' => '1B365D'], ['alignment' => Jc::CENTER]);
        $section->addTextBreak(6);

        $section->addText('JAKSA AGUNG MUDA BIDANG PEMBINAAN', ['bold' => true, 'size' => 12, 'color' => '1B365D'], ['alignment' => Jc::CENTER]);
        $section->addText('JAKARTA - ${tanggal_cetak}', ['bold' => true, 'size' => 11, 'color' => '555555'], ['alignment' => Jc::CENTER]);

        $section->addPageBreak();

        // Section 2: Instructions for Admin
        $sectionGuide = $phpWord->addSection();
        $sectionGuide->addText('PETUNJUK PENGGUNAAN MASTER TEMPLATE WORD (ADMIN)', ['bold' => true, 'size' => 14, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 120]);
        $sectionGuide->addText(
            "File template ini dirancang untuk dapat Anda sesuaikan secara bebas di Microsoft Word. Anda dapat menambahkan kop surat, logo resmi Kejaksaan RI, mengatur penomoran halaman (Page Numbering), ukuran font, header/footer, daftar tabel, dan margin kertas.",
            ['size' => 10],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 80]
        );
        $sectionGuide->addText(
            "Variabel seperti \${tahun}, \${tw_romawi}, \${kata_pengantar}, \${ikhtisar_eksekutif}, \${bab1_pendahuluan}, \${bab2_perencanaan}, \${bab3_akuntabilitas}, \${bab4_penutup} akan secara otomatis diisi oleh sistem saat diekspor.",
            ['size' => 10, 'italic' => true],
            ['alignment' => Jc::BOTH, 'spaceAfter' => 140]
        );
        $sectionGuide->addPageBreak();

        // Section 3: Kata Pengantar
        $sectionGuide->addText('KATA PENGANTAR', ['bold' => true, 'size' => 13, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 120]);
        $sectionGuide->addText('${kata_pengantar}', ['size' => 11], ['alignment' => Jc::BOTH, 'spaceAfter' => 140]);
        $sectionGuide->addPageBreak();

        // Section 4: Ikhtisar Eksekutif
        $sectionGuide->addText('IKHTISAR EKSEKUTIF', ['bold' => true, 'size' => 13, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 120]);
        $sectionGuide->addText('${ikhtisar_eksekutif}', ['size' => 11], ['alignment' => Jc::BOTH, 'spaceAfter' => 140]);
        $sectionGuide->addPageBreak();

        // Section 5: BAB I
        $sectionGuide->addText('BAB I: PENDAHULUAN', ['bold' => true, 'size' => 13, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 120]);
        $sectionGuide->addText('${bab1_pendahuluan}', ['size' => 11], ['alignment' => Jc::BOTH, 'spaceAfter' => 140]);
        $sectionGuide->addPageBreak();

        // Section 6: BAB II
        $sectionGuide->addText('BAB II: PERENCANAAN KINERJA', ['bold' => true, 'size' => 13, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 120]);
        $sectionGuide->addText('${bab2_perencanaan}', ['size' => 11], ['alignment' => Jc::BOTH, 'spaceAfter' => 140]);
        $sectionGuide->addPageBreak();

        // Section 7: BAB III
        $sectionGuide->addText('BAB III: AKUNTABILITAS KINERJA', ['bold' => true, 'size' => 13, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 120]);
        $sectionGuide->addText('${bab3_akuntabilitas}', ['size' => 11], ['alignment' => Jc::BOTH, 'spaceAfter' => 140]);
        $sectionGuide->addPageBreak();

        // Section 8: BAB IV
        $sectionGuide->addText('BAB IV: PENUTUP', ['bold' => true, 'size' => 13, 'color' => '1B365D'], ['alignment' => Jc::CENTER, 'spaceAfter' => 120]);
        $sectionGuide->addText('${bab4_penutup}', ['size' => 11], ['alignment' => Jc::BOTH, 'spaceAfter' => 140]);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = "Template_Master_LKjIP_JAMBIN.docx";
        $tempPath = $this->getExportTempPath($fileName);

        $objWriter->save($tempPath);

        return $tempPath;
    }

    public function getKataPengantarText(int $tahun, string $twRomawi): string
    {
        return "Alhamdulillah, puji syukur kami panjatkan kehadirat Allah Subhanahu Wa Ta'ala atas tersusunnya Laporan Kinerja Triwulan {$twRomawi} Jaksa Agung Muda Bidang Pembinaan Tahun {$tahun}, sebagai pelaksanaan Peraturan Presiden Nomor 29 Tahun 2014 tentang Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP) dan Pedoman Jaksa Agung Nomor 4 Tahun 2024 tentang Penyelenggaraan SAKIP di Lingkungan Kejaksaan Republik Indonesia. Laporan ini merupakan perwujudan pertanggungjawaban atas pencapaian target Perjanjian Kinerja Tahun {$tahun} guna mewujudkan good governance dan clean government.";
    }

    public function getIkhtisarEksekutifText(int $tahun, string $twRomawi, int $totalSp, int $totalIkp, float $avgCapaian): string
    {
        $avgFormatted = number_format($avgCapaian, 2, ',', '.');
        return "Pengukuran kinerja Jaksa Agung Muda Bidang Pembinaan pada Triwulan {$twRomawi} Tahun {$tahun} mencakup {$totalSp} Sasaran Program dan {$totalIkp} Indikator Kinerja Program (IKP). Rata-rata capaian kinerja periode ini mencapai {$avgFormatted}%. Capaian ini menunjukkan efektivitas pelaksanaan program prioritas bidang pembinaan dalam mendukung transformasi penegakan hukum Kejaksaan Republik Indonesia.";
    }

    public function getBab1Text(int $tahun, string $twRomawi): string
    {
        return "Laporan Kinerja Triwulan {$twRomawi} Jaksa Agung Muda Bidang Pembinaan Tahun {$tahun} disusun berdasarkan amanat peraturan perundang-undangan mengenai akuntabilitas kinerja instansi pemerintah. Dokumen ini bertujuan untuk memberikan informasi kinerja yang terukur, transparan, dan akuntabel kepada pimpinan dan pemangku kepentingan mengenai pelaksanaan tugas dan fungsi Jaksa Agung Muda Bidang Pembinaan.";
    }

    public function getBab2Text(int $tahun, string $twRomawi): string
    {
        return "Perencanaan kinerja Jaksa Agung Muda Bidang Pembinaan berpedoman pada Rencana Strategis Kejaksaan RI Tahun 2025-2029 dan Perjanjian Kinerja Tahun {$tahun}. Penjenjangan kinerja (cascading) dijabarkan dari Sasaran Program (SP), Indikator Kinerja Program (IKP), hingga Sasaran Kegiatan (SK) dan Indikator Kinerja Kegiatan (IKK) pada seluruh unit eselon II dan satuan kerja pendukung.";
    }

    public function getBab3SummaryText(int $tahun, string $twRomawi, array $sasaranData): string
    {
        $text = "Pengukuran capaian kinerja Triwulan {$twRomawi} Tahun {$tahun} dilakukan berdasarkan formulasi resmi Kepja 1184 Tahun 2025. Rincian capaian per Sasaran Program adalah sebagai berikut:\n\n";
        $no = 1;
        foreach ($sasaranData as $sp) {
            $capaianSp = $sp['capaian'] !== null ? number_format((float) $sp['capaian'], 2, ',', '.') . '%' : 'Sesuai Target';
            $text .= "{$no}. {$sp['nama_sp']} (Capaian: {$capaianSp})\n";
            foreach ($sp['ikp_list'] as $ikp) {
                $targetStr = $this->formatTargetDisplay($ikp['target'], $ikp['satuan']);
                $realisasiStr = $this->formatRealisasiDisplay($ikp['realisasi'], $ikp['satuan']);
                $capaianStr = $this->percent($ikp['capaian']);
                $text .= "   - {$ikp['nama_ikp']}: Target {$targetStr}, Realisasi {$realisasiStr}, Capaian {$capaianStr}\n";
            }
            $no++;
        }
        return $text;
    }

    public function getBab4Text(int $tahun, string $twRomawi): string
    {
        return "Pencapaian kinerja Jaksa Agung Muda Bidang Pembinaan pada Triwulan {$twRomawi} Tahun {$tahun} telah berjalan secara optimal dan terarah. Evaluasi berkala terus dilakukan untuk memastikan seluruh target Perjanjian Kinerja dapat tercapai secara maksimal pada akhir tahun anggaran.";
    }

    private function getExportTempPath(string $fileName): string
    {
        $dir = storage_path('app/private/exports');
        if (!file_exists($dir)) {
            mkdir($dir, 0750, true);
        }

        return "{$dir}/{$fileName}";
    }
}
