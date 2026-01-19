<!-- resources/views/admin/berita/create.blade.php -->
<form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label>Judul Berita</label>
        <input type="text" name="judul" required>
    </div>
    <div>
        <label>Isi Berita</label>
        <textarea name="isi" rows="5" required></textarea>
    </div>
    <div>
        <label>Gambar</label>
        <input type="file" name="gambar">
    </div>
    <button type="submit">Simpan Berita</button>
</form>