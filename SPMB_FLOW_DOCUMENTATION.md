# Dokumentasi Alur SPMB 2026/2027

## 🎯 Ringkasan Alur

Sistem SPMB TK Ceria Bangsa memiliki 3 tahap utama yang dapat diatur sepenuhnya oleh admin:

```
┌─────────────────────────────────────────────────────────────────┐
│                    HOMEPAGE SPMB (spmb.index)                   │
│                                                                 │
│  ┌──────────────────────┐        ┌──────────────────────┐     │
│  │  TOMBOL PENDAFTARAN  │        │  TOMBOL PENGUMUMAN   │     │
│  │  (Dikontrol Admin)   │        │  (Dikontrol Admin)   │     │
│  └──────┬───────────────┘        └──────┬───────────────┘     │
│         │                                 │                    │
│         │ Jika Terbuka                   │ Jika Countdown    │
│         │ (Tgl Mulai ≤ Sekarang ≤       │ (Tgl Mulai ≤     │
│         │  Tgl Selesai)                  │  Sekarang < 1 jam)│
│         │                                 │                   │
│         ▼                                 ▼                   │
│   ┌─────────────────┐              ┌──────────────────┐     │
│   │ Form Pendaftaran │              │ Countdown Page   │     │
│   │ (spmb.pendaftaran)              │ (spmb.countdown) │     │
│   └─────────────────┘              └────────┬─────────┘     │
│                                             │                 │
│                                      Countdown Habis          │
│                                      Auto-Redirect            │
│                                             │                 │
│                                             ▼                 │
│                                   ┌─────────────────────┐    │
│  Jika Published:                  │ Hasil Pengumuman    │    │
│  ┌─────────────────────┐          │ (spmb.pengumuman)   │    │
│  │ Tombol "Cek Hasil"  │──────┐   └─────────────────────┘    │
│  │ Langsung ke Hasil   │      │                              │
│  └─────────────────────┘      │   Jika NOT Published:       │
│                                │   Tunggu hingga admin      │
│                                │   publish hasil di admin   │
└────────────────────────────────┴──────────────────────────────┘
```

---

## 📋 Tahap 1: PENDAFTARAN

### Status & Kondisi

| Kondisi                    | Status       | Tampilan               | Tombol                          |
| -------------------------- | ------------ | ---------------------- | ------------------------------- |
| Belum sampai tgl mulai     | Belum Dibuka | Countdown ke tgl mulai | Tombol Disabled (Gray)          |
| Antara tgl mulai & selesai | **BUKA** ✅  | Periode aktif          | Tombol "Daftar Sekarang" (Blue) |
| Sudah lewat tgl selesai    | Ditutup      | Pesan "Sudah Berakhir" | Tombol Disabled (Gray)          |

### Pengaturan Admin

Admin mengatur pendaftaran di: **Admin → SPMB → Pengaturan**

```
- Tanggal Mulai Pendaftaran: [input date/time]
- Tanggal Selesai Pendaftaran: [input date/time]
```

### File Terkait

- Route: `GET /spmb/pendaftaran` → `spmb.pendaftaran`
- View: `resources/views/Home/spmb/pendaftaran.blade.php`
- Controller: `SpmbController@pendaftaran()`

---

## ⏱️ Tahap 2: COUNTDOWN PENGUMUMAN

### Status & Kondisi

| Kondisi                             | Status           | Tampilan                 | Tombol                             |
| ----------------------------------- | ---------------- | ------------------------ | ---------------------------------- |
| Belum sampai tgl pengumuman         | Belum Waktunya   | Info waktu mulai         | Tombol Disabled                    |
| Pengumuman mulai tapi NOT published | **COUNTDOWN** ⏳ | Countdown Timer          | Tombol "Lihat Countdown" (Purple)  |
| Published & periode aktif           | **PUBLISHED** ✅ | Form Cek Hasil           | Tombol "Cek Hasil Seleksi" (Green) |
| Periode pengumuman berakhir         | Berakhir         | Pesan "Periode Berakhir" | Tombol Disabled                    |

### Timer Countdown

**Trigger:**

- Status = `COUNTDOWN` dapat terjadi dalam rentang: **Tgl Pengumuman Mulai** hingga **1 jam setelahnya**
- Selama ini, admin belum meng-publish hasil

**Alur Countdown:**

1. User masuk Homepage → Lihat tombol "Lihat Countdown Pengumuman"
2. Klik tombol → Pergi ke halaman `/spmb/countdown`
3. Lihat countdown timer dengan formatasi: **Hari | Jam | Menit | Detik**
4. Setelah countdown 0 → Auto refresh & redirect ke `/spmb/pengumuman`
5. Hasil pengumuman ditampilkan (jika admin sudah publish)

### Pengaturan Admin

Admin mengatur pengumuman di: **Admin → SPMB → Pengaturan**

```
- Tanggal Mulai Pengumuman: [input date/time]
- Tanggal Selesai Pengumuman: [input date/time]
- Publikasi Hasil: [button PUBLISH atau status "Published"]
```

**Catatan:** Admin dapat mengklik tombol "PUBLISH" ketika sudah siap menampilkan hasil. Sebelum publish, pengumuman status tetap "COUNTDOWN".

### File Terkait

- Route: `GET /spmb/countdown` → `spmb.countdown`
- View: `resources/views/Home/spmb/countdown.blade.php`
- Controller: `SpmbController@countdown()`

---

## 📢 Tahap 3: PENGUMUMAN HASIL

### Status & Kondisi

| Kondisi                   | Status           | Tampilan       | Detail                                     |
| ------------------------- | ---------------- | -------------- | ------------------------------------------ |
| Sudah Dipublish           | **PUBLISHED** ✅ | Form Cek Hasil | User bisa cek dengan No. Pendaftaran + NIK |
| Periode Aktif & Published | Buka             | Hasil SPMB     | Daftar peserta yang lulus ditampilkan      |

### Alur Pengumuman

**User Flow:**

1. Homepage → Tombol "Cek Hasil Seleksi" (jika published)
2. Atau: Countdown auto-redirect ke halaman pengumuman
3. Masuk form dengan: **No. Pendaftaran** + **NIK**
4. Submit → Cek hasil
5. Tampilkan: **Status Lolos/Tidak Lolos**

**Admin Flow (Publishing):**

1. Admin → Spmb → Pengaturan
2. Klik tombol "PUBLISH PENGUMUMAN"
3. Sistem: Update `is_published = true`
4. Hasil langsung tampil ke publik

### Daftar Hasil (Optional)

- View: `resources/views/Home/spmb/daftar-lulus.blade.php`
- Menampilkan daftar lengkap semua peserta yang lulus
- Dapat diakses setelah hasil dipublish

### File Terkait

- Route: `GET /spmb/pengumuman` → `spmb.pengumuman`
- Route: `POST /spmb/cek-pengumuman` → `spmb.cekPengumuman`
- Route: `GET /spmb/hasil-pengumuman` → `spmb.hasilPengumuman`
- View: `resources/views/Home/spmb/pengumuman.blade.php`
- View: `resources/views/Home/spmb/daftar-lulus.blade.php`
- Controller: `SpmbController@pengumuman()`, `cekPengumuman()`, `hasilPengumuman()`

---

## 🔧 Pengaturan di Admin Panel

### Lokasi

**Admin Dashboard → SPMB → Pengaturan** (`/admin/spmb/pengaturan`)

### Field yang Dapat Dikontrol

```
1. PERIODE PENDAFTARAN
   - Tanggal Mulai Pendaftaran
   - Tanggal Selesai Pendaftaran
   - Jalur yang Tersedia (Zonasi, Afirmasi, Prestasi, Mutasi)

2. PERIODE PENGUMUMAN
   - Tanggal Mulai Pengumuman
   - Tanggal Selesai Pengumuman
   - Tombol: PUBLISH PENGUMUMAN (aktifkan hasil)

3. KUOTA PER JALUR
   - Kuota Zonasi (%): default 50%
   - Kuota Afirmasi (%): default 15%
   - Kuota Prestasi (%): default 30%
   - Kuota Mutasi (%): default 5%

4. PENGUMUMAN HASIL
   - Status: Published / Not Published
   - Display: Daftar peserta lulus atau countdown
```

### Contoh Skenario

**Skenario 1: Pendaftaran Aktif**

```
Maret 1, 2026 09:00 - Mulai pendaftaran
Maret 15, 2026 17:00 - Selesai pendaftaran

Homepage SPMB:
↳ Tombol "Daftar Sekarang" AKTIF (warna biru)
↳ Periode pendaftaran ditampilkan
```

**Skenario 2: Countdown Pengumuman**

```
April 1, 2026 10:00 - Mulai pengumuman
Admin BELUM klik "Publish Pengumuman"

Homepage SPMB:
↳ Tombol "Lihat Countdown Pengumuman" AKTIF (warna purple)
↳ Countdown: "... Hari ... Jam ... Menit ... Detik lagi"
↳ Countdown selesai → Auto-redirect ke hasil
```

**Skenario 3: Pengumuman Sudah Dibuka**

```
April 1, 2026 10:30 - Mulai pengumuman
Admin sudah klik "Publish Pengumuman"

Homepage SPMB:
↳ Tombol "Cek Hasil Seleksi" AKTIF (warna hijau)
↳ User bisa langsung cek hasil dengan form
```

---

## 📊 Database Model

### SpmbSetting Migration

```php
Schema::create('spmb_settings', function (Blueprint $table) {
    $table->id();
    $table->string('tahun_ajaran');

    // Pendaftaran
    $table->dateTime('pendaftaran_mulai');
    $table->dateTime('pendaftaran_selesai');

    // Pengumuman
    $table->dateTime('pengumuman_mulai');
    $table->dateTime('pengumuman_selesai');
    $table->boolean('is_published')->default(false);

    // Kuota
    $table->integer('kuota_zonasi')->default(50);
    $table->integer('kuota_afirmasi')->default(15);
    $table->integer('kuota_prestasi')->default(30);
    $table->integer('kuota_mutasi')->default(5);

    $table->timestamps();
});
```

### Spmb Registration Model

```php
Schema::create('spmb', function (Blueprint $table) {
    $table->id();
    $table->string('no_pendaftaran')->unique();
    $table->string('nik', 16);
    $table->enum('status_pendaftaran', ['Menunggu Verifikasi', 'Revisi Dokumen', 'Dokumen Verified', 'Lulus', 'Tidak Lulus']);
    $table->enum('jalur_pendaftaran', ['zonasi', 'afirmasi', 'prestasi', 'mutasi']);

    // ... data calon siswa

    $table->timestamps();
});
```

---

## 🔐 Routes & Middleware

### Public Routes

```
GET  /spmb                    → spmb.index       (Homepage)
GET  /spmb/pendaftaran        → spmb.pendaftaran (Form Pendaftaran)
POST /spmb/pendaftaran        → spmb.store       (Submit Pendaftaran)
GET  /spmb/countdown          → spmb.countdown   (Countdown Page)
GET  /spmb/pengumuman         → spmb.pengumuman  (Cek Hasil)
POST /spmb/cek-pengumuman     → spmb.cekPengumuman
GET  /spmb/hasil-pengumuman   → spmb.hasilPengumuman
```

### Admin Routes

```
GET  /admin/spmb              → admin.spmb.index
GET  /admin/spmb/pengaturan   → admin.spmb.pengaturan
POST /admin/spmb/pengaturan   → admin.spmb.updatePengaturan
POST /admin/spmb/pengumuman/publish → admin.spmb.publishPengumuman
```

---

## 🎨 Styling & Responsive

Semua halaman SPMB menggunakan:

- **Framework CSS:** Tailwind CSS
- **Responsive:** Mobile-first design (sm:, md:, lg: breakpoints)
- **Icons:** FontAwesome 6
- **Animasi:** CSS transitions & Tailwind animations

---

## 🐛 Troubleshooting

### Countdown tidak berjalan

- ✓ Check: `php artisan route:list | grep countdown`
- ✓ Verifikasi: SpmbSetting exist di DB
- ✓ Browser console check untuk JS errors

### Pengumuman tidak muncul

- ✓ Pastikan: Admin sudah "PUBLISH PENGUMUMAN"
- ✓ Check: `is_published` field di `spmb_settings`
- ✓ Timeline: Sekarang harus dalam rentang `pengumuman_mulai` - `pengumuman_selesai`

### Form Pendaftaran tidak muncul

- ✓ Check: Periode pendaftaran aktif
- ✓ Check: `pendaftaran_mulai` <= sekarang <= `pendaftaran_selesai`

---

## 📝 Checklist Setup

- [ ] Create `spmb_settings` table dengan migration
- [ ] Seed initial SpmbSetting untuk tahun ajaran 2026/2027
- [ ] Setup Admin SPMB Dashboard → Pengaturan form
- [ ] Test Homepage SPMB dengan berbagai skenario
- [ ] Setup email notification untuk admin saat countdown mulai
- [ ] Backup database sebelum publish pengumuman
- [ ] Sosialisasi ke parent/siswa tentang jadwal

---

## 📞 Support

Jika ada pertanyaan atau bug report, hubungi tim development.

**Last Updated:** Februari 10, 2026
**Version:** 1.0
