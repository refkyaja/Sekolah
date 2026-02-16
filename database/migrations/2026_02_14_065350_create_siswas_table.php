<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke SPMB (jika siswa berasal dari pendaftaran SPMB)
            $table->unsignedBigInteger('spmb_id')->nullable();
            
            // Nomor Induk Siswa
            $table->string('nis')->unique()->nullable();
            $table->string('nisn')->unique()->nullable();

            // Data siswa (sesuai dengan SPMB)
            $table->string('nik', 16)->unique(); 
            $table->string('nama_lengkap', 255);
            $table->string('nama_panggilan', 100)->nullable();
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']); // L untuk Laki-laki, P untuk Perempuan
            $table->enum('agama', ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'])->nullable();
            
            // Foto siswa
            $table->string('foto')->nullable(); // Path ke file foto siswa
            
            // Alamat lengkap (per komponen)
            $table->text('alamat'); // Untuk kompatibilitas ke belakang
            $table->string('provinsi')->nullable();
            $table->string('kota_kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('nama_jalan')->nullable();

            // Data kesehatan (dari SPMB)
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->string('golongan_darah', 5)->nullable();
            $table->text('penyakit_pernah_diderita')->nullable();
            $table->text('imunisasi')->nullable();

            // Data orang tua (Ayah)
            $table->string('nama_ayah', 255);
            $table->string('nik_ayah', 16)->nullable();
            $table->string('tempat_lahir_ayah', 100)->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('pendidikan_ayah', 100)->nullable();
            $table->string('pekerjaan_ayah', 100)->nullable();
            $table->string('bidang_pekerjaan_ayah', 100)->nullable();
            $table->string('penghasilan_ayah', 100)->nullable();

            // Data orang tua (Ibu)
            $table->string('nama_ibu', 255);
            $table->string('nik_ibu', 16)->nullable();
            $table->string('tempat_lahir_ibu', 100)->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('pendidikan_ibu', 100)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->string('bidang_pekerjaan_ibu', 100)->nullable();
            $table->string('penghasilan_ibu', 100)->nullable();

            // Data wali (jika ada)
            $table->boolean('punya_wali')->default(false);
            $table->string('nama_wali', 255)->nullable();
            $table->string('hubungan_wali', 100)->nullable();
            $table->string('nik_wali', 16)->nullable();
            $table->string('pekerjaan_wali', 100)->nullable();
            $table->string('nomor_telepon_wali', 20)->nullable();

            // Kontak orang tua
            $table->string('no_hp_ayah', 20)->nullable();
            $table->string('email_ayah', 255)->nullable();
            $table->string('no_hp_ibu', 20)->nullable();
            $table->string('email_ibu', 255)->nullable();
            
            // Kontak gabungan (untuk kompatibilitas)
            $table->string('no_hp_ortu', 20)->nullable();
            $table->string('email_ortu', 255)->nullable();

            // Informasi akademik
            $table->enum('kelompok', ['A', 'B']); // Kelompok A (3-4 thn), B (5-6 thn)
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->string('tahun_ajaran', 9); // Untuk kompatibilitas
            $table->enum('status_siswa', ['aktif', 'lulus'])->default('aktif');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->string('jalur_masuk', 50)->nullable(); // zonasi, afirmasi, prestasi, mutasi, reguler

            // Informasi kelas
            $table->string('kelas')->nullable();
            $table->string('guru_kelas')->nullable();

            // Catatan
            $table->text('catatan')->nullable();

            // Soft deletes dan timestamps
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('spmb_id')->references('id')->on('spmb')->onDelete('set null');
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajarans')->onDelete('restrict');

            // Indexes
            $table->index('nik');
            $table->index('nis');
            $table->index('nisn');
            $table->index('nama_lengkap');
            $table->index('kelompok');
            $table->index('tahun_ajaran_id');
            $table->index('status_siswa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};