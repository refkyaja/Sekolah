<?php

namespace App\Livewire\Admin;

use App\Models\Activity;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityLogIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';
    public $role = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'date' => ['except' => ''],
        'role' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDate()
    {
        $this->resetPage();
    }

    public function updatingRole()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'date', 'role']);
        $this->resetPage();
    }

    public function deleteLog($id)
    {
        Activity::findOrFail($id)->delete();
        session()->flash('success', 'Log aktivitas berhasil dihapus');
    }

    public function render()
    {
        $query = Activity::with('causer')->latest();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('ip_address', 'like', '%' . $this->search . '%')
                    ->orWhereHas('causer', function ($uq) {
                        $uq->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->date) {
            $query->whereDate('created_at', $this->date);
        }

        if ($this->role) {
            $query->whereHas('causer', function ($uq) {
                $uq->where('role', $this->role);
            });
        }

        $activities = $query->paginate(10);

        return view('livewire.admin.activity-log-index', [
            'activities' => $activities,
        ]);
    }
}
