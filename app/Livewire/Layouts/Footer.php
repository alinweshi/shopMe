<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        return view('livewire.layouts.footer')
        ->extends('layout.app')
        ->section('footer');
        ;
    }
}
