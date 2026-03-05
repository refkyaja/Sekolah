<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kurikulums', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('tipe')->nullable(); 
            $table->string('ikon')->nullable();
            $table->json('poin_penting')->nullable();
            $table->timestamps();
        });

        // Insert initial data based on the provided text
        DB::table('kurikulums')->insert([
            [
                'judul' => 'Kurikulum Merdeka',
                'deskripsi' => "Sekolah kami menerapkan Kurikulum Merdeka sebagai acuan utama dalam proses pembelajaran, sesuai dengan kebijakan dari Kementerian Pendidikan Dasar dan Menengah Republik Indonesia.\n\nKurikulum Merdeka memberikan ruang belajar yang lebih fleksibel, berpusat pada anak, serta mendorong pengembangan kompetensi dan karakter secara seimbang. Anak tidak hanya diajak untuk mengenal pengetahuan dasar, tetapi juga dilatih untuk berpikir kritis, kreatif, mandiri, serta memiliki rasa percaya diri sejak usia dini.\n\nPendekatan ini memungkinkan guru merancang pembelajaran yang menyenangkan, kontekstual, dan sesuai dengan tahap perkembangan anak.",
                'tipe' => 'utama',
                'ikon' => 'public',
                'poin_penting' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Penguatan Pendidikan Holistik Berbasis Karakter',
                'deskripsi' => "Kami meyakini bahwa pendidikan bukan hanya tentang kemampuan akademik, tetapi juga pembentukan karakter dan nilai kehidupan.\n\nMelalui pendekatan pendidikan holistik berbasis karakter, kami mengintegrasikan aspek : Spiritual, Emosional, Sosial, Intelektual, dan Fisik.\n\nAnak dibimbing untuk mengenal nilai tanggung jawab, disiplin, empati, kemandirian, serta kebiasaan baik yang menjadi fondasi kuat dalam perjalanan pendidikan mereka selanjutnya.",
                'tipe' => 'pendekatan',
                'ikon' => 'favorite',
                'poin_penting' => json_encode(['Spiritual', 'Emosional', 'Sosial', 'Intelektual', 'Fisik']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Layanan PAUD HIBER',
                'deskripsi' => "Sekolah kami juga menerapkan layanan PAUD Holistik integratif berdimensi sosial, budaya, dan ekonomi (PAUD HIBER), yaitu layanan terpadu yang tidak hanya berfokus pada pembelajaran, tetapi juga mencakup:\n\nPendekatan ini memastikan bahwa setiap anak mendapatkan perhatian secara utuh dan optimal sesuai tahap perkembangannya.",
                'tipe' => 'layanan',
                'ikon' => 'diversity_1',
                'poin_penting' => json_encode([
                    'Layanan Pendidikan',
                    'Layanan Gizi dan Kesehatan',
                    'Layanan Pengasuhan',
                    'Layanan Perlindungan',
                    'Layanan Kesejahteraan',
                    'Layanan Sosial',
                    'Layanan Budaya',
                    'Layanan Ekonomi'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'PAUD Percontohan & Rujukan Dinas Pendidikan',
                'deskripsi' => "Kami bersyukur dipercaya sebagai PAUD Percontohan dan Rujukan Dinas Pendidikan, yang menjadi model praktik baik dalam pengelolaan pembelajaran dan penguatan karakter.\n\nStatus ini menjadi bukti komitmen kami dalam menjaga mutu, inovasi, dan kualitas layanan pendidikan anak usia dini.",
                'tipe' => 'status',
                'ikon' => 'verified',
                'poin_penting' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Mengapa Memilih Sekolah Kami?',
                'deskripsi' => "Karena kami tidak hanya mengajar, tetapi membentuk fondasi kehidupan.\n\nKami tidak sekadar mengenalkan huruf dan angka, tetapi menanamkan nilai, membangun kepercayaan diri, serta menumbuhkan kecintaan anak terhadap proses belajar.\n\nKami percaya bahwa kombinasi dari layanan pengembangan holistik integratif dan pendidikan pilar karakter, dapat menghasilkan individu yang tidak hanya cerdas, tetapi juga membentuk pribadi yang berkarakter dan berakhlak mulia.\n\nMari bersama kami, membangun generasi yang cerdas, berkarakter, dan siap melangkah menuju masa depan.",
                'tipe' => 'alasan',
                'ikon' => 'school',
                'poin_penting' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulums');
    }
};
