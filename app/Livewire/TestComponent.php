<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Computed;

class TestComponent extends Component
{
    public $count = 0;
    public $message = 'Hello from Livewire!';
    public $input = '';

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function resetCount()
    {
        $this->count = 0;
    }

    public function submit()
    {
        $this->message = 'Submitted: ' . $this->input;
        $this->input = '';
    }

    #[Computed]
    public function timestamp()
    {
        return now()->format('H:i:s');
    }

    #[Computed]
    public function sessionId()
    {
        return session()->getId();
    }

    public function render()
    {
        return view('livewire.test-component');
    }
}
