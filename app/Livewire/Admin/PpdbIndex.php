<?php

namespace App\Livewire\Admin;

use App\Models\Spmb;
use Livewire\Component;
use Livewire\WithPagination;

class PpdbIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status_pendaftaran = '';

    public $selectedIds = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => '', 'history' => false],
        'status_pendaftaran' => ['except' => '', 'history' => false],
        'page' => ['except' => 1],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedStatusPendaftaran()
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedIds = $this->getSpmbQuery()->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        } else {
            $this->selectedIds = [];
        }
    }

    public function updatedSelectedIds()
    {
        $count = $this->getSpmbQuery()->count();
        $this->selectAll = count($this->selectedIds) === $count && $count > 0;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'status_pendaftaran']);
        $this->resetSelection();
        $this->resetPage();
    }

    public function resetSelection()
    {
        $this->selectedIds = [];
        $this->selectAll = false;
    }

    public function bulkLulus()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        $count = count($this->selectedIds);

        Spmb::whereIn('id', $this->selectedIds)->update([
            'status_pendaftaran' => 'Lulus',
        ]);

        $this->resetSelection();
        session()->flash('success', $count . ' data berhasil diupdate menjadi Lulus.');
    }

    public function bulkDelete()
    {
        if (empty($this->selectedIds)) {
            return;
        }

        $count = count($this->selectedIds);

        Spmb::whereIn('id', $this->selectedIds)->delete();

        $this->resetSelection();
        session()->flash('success', $count . ' data berhasil dihapus.');

        $this->resetPage();
    }

    public function confirmBulkLulus()
    {
        $this->dispatch('show-confirm', [
            'title' => 'Konfirmasi',
            'text' => 'Ubah status Lulus untuk ' . count($this->selectedIds) . ' data?',
            'icon' => 'question',
            'confirmButtonText' => 'Ya, Lulus',
            'cancelButtonText' => 'Batal',
            'method' => 'bulkLulus'
        ]);
    }

    public function confirmBulkDelete()
    {
        $this->dispatch('show-confirm', [
            'title' => 'Konfirmasi Hapus',
            'text' => 'Hapus ' . count($this->selectedIds) . ' data? Tindakan ini tidak dapat dibatalkan.',
            'icon' => 'warning',
            'confirmButtonText' => 'Ya, Hapus',
            'cancelButtonText' => 'Batal',
            'method' => 'bulkDelete'
        ]);
    }

    public function getSpmbQuery()
    {
        $query = Spmb::query()->latest();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('no_pendaftaran', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_lengkap_anak', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status_pendaftaran) {
            $query->where('status_pendaftaran', $this->status_pendaftaran);
        }

        return $query;
    }

    public function render()
    {
        return view('livewire.admin.ppdb-index', [
            'spmb' => $this->getSpmbQuery()->paginate(15),
        ]);
    }
}
