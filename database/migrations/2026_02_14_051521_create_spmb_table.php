<?php
// database/migrations/2024_01_01_000001_create_spmb_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spmb', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran')->unique();
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->enum('status_pendaftaran', ['Diterima', 'Menunggu Verifikasi', 'Mundur'])->default('Menunggu Verifikasi');
            
            // Data Anak (Bagian 1)
            $table->string('nama_lengkap_anak');
            $table->string('nama_panggilan_anak')->nullable();
            $table->string('nik_anak', 16)->unique();
            $table->string('tempat_lahir_anak');
            $table->date('tanggal_lahir_anak');
            
            // Alamat Rumah
            $table->string('provinsi_rumah');
            $table->string('kota_kabupaten_rumah');
            $table->string('kecamatan_rumah');
            $table->string('kelurahan_rumah');
            $table->string('nama_jalan_rumah');
            
            // Alamat KK (jika berbeda)
            $table->boolean('alamat_kk_sama')->default(true);
            $table->text('alamat_kk')->nullable();
            $table->string('provinsi_kk')->nullable();
            $table->string('kota_kabupaten_kk')->nullable();
            $table->string('kecamatan_kk')->nullable();
            $table->string('kelurahan_kk')->nullable();
            $table->string('nama_jalan_kk')->nullable();
            
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('agama', ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya']);
            $table->integer('anak_ke');
            $table->string('tinggal_bersama'); // Ayah dan Ibu, Keluarga Ayah, Keluarga Ibu, Lainnya
            $table->enum('status_tempat_tinggal', ['Milik Sendiri', 'Milik Keluarga', 'Kontrakan']); // Diubah sesuai form
            $table->string('bahasa_sehari_hari');
            $table->integer('jarak_rumah_ke_sekolah')->nullable(); // dalam meter
            $table->integer('waktu_tempuh_ke_sekolah')->nullable(); // dalam menit
            $table->decimal('berat_badan', 5, 2)->nullable(); // dalam kg
            $table->decimal('tinggi_badan', 5, 2)->nullable(); // dalam cm
            $table->string('golongan_darah')->nullable();
            $table->text('penyakit_pernah_diderita')->nullable();
            $table->text('imunisasi_pernah_diterima')->nullable();
            
            // Data Ayah
            $table->string('nama_lengkap_ayah')->nullable();
            $table->string('nik_ayah', 16)->nullable();
            $table->string('tempat_lahir_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->text('alamat_ayah')->nullable();
            $table->string('provinsi_ayah')->nullable();
            $table->string('kota_kabupaten_ayah')->nullable();
            $table->string('kecamatan_ayah')->nullable();
            $table->string('kelurahan_ayah')->nullable();
            $table->string('nama_jalan_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->enum('pekerjaan_ayah', ['Pekerja Informal', 'Wirausaha', 'Pegawai Swasta', 'PNS'])->nullable(); // Diubah sesuai form
            $table->string('bidang_pekerjaan_ayah')->nullable();
            $table->string('penghasilan_per_bulan_ayah')->nullable();
            $table->string('nomor_telepon_ayah')->nullable();
            $table->string('email_ayah')->nullable();
            
            // Data Ibu
            $table->string('nama_lengkap_ibu')->nullable();
            $table->string('nik_ibu', 16)->nullable();
            $table->string('tempat_lahir_ibu')->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->text('alamat_ibu')->nullable();
            $table->string('provinsi_ibu')->nullable();
            $table->string('kota_kabupaten_ibu')->nullable();
            $table->string('kecamatan_ibu')->nullable();
            $table->string('kelurahan_ibu')->nullable();
            $table->string('nama_jalan_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->enum('pekerjaan_ibu', ['Ibu Rumah Tangga', 'Pekerja Informal', 'Wirausaha', 'Pegawai Swasta', 'PNS'])->nullable(); // Diubah sesuai form
            $table->string('bidang_pekerjaan_ibu')->nullable();
            $table->string('penghasilan_per_bulan_ibu')->nullable();
            $table->string('nomor_telepon_ibu')->nullable();
            $table->string('email_ibu')->nullable();
            
            // Data Wali (jika ada)
            $table->boolean('punya_wali')->default(false);
            $table->string('nama_lengkap_wali')->nullable();
            $table->string('hubungan_dengan_anak')->nullable();
            $table->string('nik_wali', 16)->nullable();
            $table->string('tempat_lahir_wali')->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('provinsi_wali')->nullable();
            $table->string('kota_kabupaten_wali')->nullable();
            $table->string('kecamatan_wali')->nullable();
            $table->string('kelurahan_wali')->nullable();
            $table->string('nama_jalan_wali')->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('bidang_pekerjaan_wali')->nullable();
            $table->string('penghasilan_per_bulan_wali')->nullable();
            $table->string('nomor_telepon_wali')->nullable();
            $table->string('email_wali')->nullable();
            
            // Informasi Tambahan (Bagian 4)
            $table->string('sumber_informasi_ppdb')->nullable();
            $table->enum('punya_saudara_sekolah_tk', ['Ya', 'Tidak'])->default('Tidak'); // Diubah dari boolean ke enum
            $table->enum('jenis_daftar', ['Siswa Baru', 'Pindahan'])->default('Siswa Baru');
            
            // Verifikasi Dokumen
            $table->boolean('verifikasi_akte')->default(false);
            $table->boolean('verifikasi_kk')->default(false);
            $table->boolean('verifikasi_ktp')->default(false);
            $table->boolean('verifikasi_bukti_transfer')->default(false);
            
            $table->timestamp('tanggal_verifikasi_akte')->nullable();
            $table->timestamp('tanggal_verifikasi_kk')->nullable();
            $table->timestamp('tanggal_verifikasi_ktp')->nullable();
            $table->timestamp('tanggal_verifikasi_bukti_transfer')->nullable();
            
            $table->unsignedBigInteger('diverifikasi_oleh')->nullable();
            
            // Approval Kepala Sekolah
            $table->boolean('approved_by_kepsek')->default(false);
            $table->unsignedBigInteger('kepsek_id')->nullable();
            $table->timestamp('tanggal_approval')->nullable();
            
            // Data Kelas
            $table->string('kelas')->nullable();
            $table->string('guru_kelas')->nullable();
            $table->unsignedBigInteger('operator_input_kelas')->nullable();
            
            // Data Siswa Aktif
            $table->boolean('is_aktif')->default(false);
            $table->string('nomor_induk_siswa')->unique()->nullable();
            $table->boolean('is_lulus')->default(false);
            $table->boolean('is_mengulang')->default(false);
            
            // Catatan Admin
            $table->text('catatan_admin')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajarans')->onDelete('cascade');
            $table->foreign('diverifikasi_oleh')->references('id')->on('users')->onDelete('set null');
            $table->foreign('kepsek_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('operator_input_kelas')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmb');
    }
};