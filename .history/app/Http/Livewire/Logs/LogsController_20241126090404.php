<?php

namespace App\Http\Livewire\Logs;

use Livewire\Component;

class LogsController extends Component
{

    public $permissionName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 10;
    public function mount()
    {

        $this->pageTitle = 'Buscador';
        $this->componentName = 'Historial';
    }
    public function render()
    {
        return view('livewire.logs.logs-controller')
            ->extends('layouts.theme.app')
            ->section('content');
    }
}
