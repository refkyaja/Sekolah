<?php

namespace App\Livewire\Admin\Accounts;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';
    public $status = '';
    public $sort = 'terbaru';

    protected $queryString = [
        'search' => ['except' => '', 'history' => false],
        'role' => ['except' => '', 'history' => false],
        'status' => ['except' => '', 'history' => false],
        'sort' => ['except' => 'terbaru', 'history' => false],
        'page' => ['except' => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRole()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function getUsersProperty()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->search . '%');
            });
        }

        if ($this->role) {
            $query->where('role', $this->role);
        }

        if ($this->status && Schema::hasColumn('users', 'is_active')) {
            $isActive = $this->status === 'active';
            $query->where('is_active', $isActive);
        }

        switch ($this->sort) {
            case 'nama_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'login_terbaru':
                $query->orderBy('last_login_at', 'desc');
                break;
            case 'login_terlama':
                $query->orderBy('last_login_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->paginate(15);
    }

    public function getStatsProperty()
    {
        return [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'admin' => User::where('role', 'admin')->count(),
            'kepala_sekolah' => User::where('role', 'kepala_sekolah')->count(),
            'operator' => User::where('role', 'operator')->count(),
            'guru' => User::where('role', 'guru')->count(),
        ];
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->role = '';
        $this->status = '';
        $this->sort = 'terbaru';
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.accounts.index');
    }
}
