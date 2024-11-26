<?php

namespace App\Http\Livewire\Logs;

use App\Models\Customers;
use App\Models\Logs;
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
        $logs = Logs::all();
        $clientes = Customers::all();
        return view('livewire.logs.logs-controller', ['logs' => $logs,'clientes' => $clientes])
            ->extends('layouts.theme.app')
            ->section('content');
    }
}
