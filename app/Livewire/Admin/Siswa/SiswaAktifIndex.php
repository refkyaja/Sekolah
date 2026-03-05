<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Siswa;
use Livewire\Component;
use Livewire\WithPagination;

class SiswaAktifIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $kelompok = '';
    public $sort = 'terbaru';
    public $selectedIds = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => '', 'history' => false],
        'kelompok' => ['except' => '', 'history' => false],
        'sort' => ['except' => 'terbaru', 'history' => false],
        'page' => ['except' => 1],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedKelompok()
    {
        $this->resetPage();
    }

    public function updatedSort()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedIds = $this->getSiswasQuery()->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        } else {
            $this->selectedIds = [];
        }
    }

    public function updatedSelectedIds()
    {
        $count = $this->getSiswasQuery()->count();
        $this->selectAll = count($this->selectedIds) === $count && $count > 0;
    }

    public function getSiswasQuery()
    {
        $query = Siswa::with(['tahunAjaran'])->aktif();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_lengkap', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('nis', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('nik', 'LIKE', '%' . $this->search . '%');
            });
        }

        if ($this->kelompok) {
            $query->where('kelompok', $this->kelompok);
        }

        switch ($this->sort) {
            case 'nama_asc':
                $query->orderBy('nama_lengkap', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('nama_lengkap', 'desc');
                break;
            case 'terbaru':
                $query->orderBy('created_at', 'desc');
                break;
            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'kelompok', 'sort', 'selectedIds', 'selectAll']);
        $this->resetPage();
    }

    public function deleteSelected()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        $count = count($this->selectedIds);
        Siswa::whereIn('id', $this->selectedIds)->delete();

        $this->selectedIds = [];
        $this->selectAll = false;

        $this->dispatch('swal:alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => $count . ' data siswa berhasil dihapus.'
        ]);
    }

    public function updateStatusSelected($status)
    {
        if (empty($this->selectedIds)) {
            return;
        }

        $updateData = ['status_siswa' => $status];
        if ($status === 'lulus' || $status === 'pindah') {
            $updateData['tanggal_keluar'] = now()->toDateString();
        }

        Siswa::whereIn('id', $this->selectedIds)->update($updateData);

        $count = count($this->selectedIds);
        $this->selectedIds = [];
        $this->selectAll = false;

        $this->dispatch('swal:alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => "{$count} data siswa berhasil diupdate ke status {$status}."
        ]);

        if ($status === 'lulus') {
            return redirect()->route('admin.siswa.siswa-lulus.index');
        }
    }

    public function deleteSiswa($id)
    {
        Siswa::find($id)?->delete();

        $this->dispatch('swal:alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Data siswa berhasil dihapus.'
        ]);
    }

    public function updateKelompokSelected($kelompok)
    {
        if (empty($this->selectedIds)) {
            return;
        }

        $count = count($this->selectedIds);
        Siswa::whereIn('id', $this->selectedIds)->update(['kelompok' => $kelompok]);

        $this->selectedIds = [];
        $this->selectAll = false;

        $this->dispatch('swal:alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => "{$count} siswa berhasil dipindahkan ke Kelompok {$kelompok}."
        ]);
    }

    public function render()
    {
        return view('livewire.admin.siswa.siswa-aktif-index', [
            'siswas' => $this->getSiswasQuery()->paginate(15),
            'stats' => [
                'total' => Siswa::aktif()->count(),
                'kelompok_a' => Siswa::aktif()->where('kelompok', 'A')->count(),
                'kelompok_b' => Siswa::aktif()->where('kelompok', 'B')->count(),
                'laki_laki' => Siswa::aktif()->where('jenis_kelamin', 'L')->count(),
                'perempuan' => Siswa::aktif()->where('jenis_kelamin', 'P')->count(),
            ]
        ]);
    }
}
