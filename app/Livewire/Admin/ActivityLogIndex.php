<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityLogIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';
    public $role = '';
    public $sort = 'terbaru';

    protected $queryString = [
        'search' => ['except' => ''],
        'date' => ['except' => ''],
        'role' => ['except' => ''],
        'sort' => ['except' => 'terbaru'],
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

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'date', 'role', 'sort']);
        $this->resetPage();
    }

    public function deleteLog($id)
    {
        ActivityLog::findOrFail($id)->delete();
        session()->flash('success', 'Log aktivitas berhasil dihapus');
    }

    public function render()
    {
        $query = ActivityLog::with('user');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('ip_address', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($uq) {
                        $uq->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->date) {
            $query->whereDate('created_at', $this->date);
        }

        if ($this->role) {
            $query->whereHas('user', function ($uq) {
                $uq->where('role', $this->role);
            });
        }

        if ($this->sort === 'terbaru') {
            $query->latest();
        } else {
            $query->oldest();
        }

        $activities = $query->paginate(10);

        return view('livewire.admin.activity-log-index', [
            'activities' => $activities,
        ]);
    }
}
