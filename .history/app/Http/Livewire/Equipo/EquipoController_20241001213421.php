<?php

namespace App\Http\Livewire\Equipo;

use Livewire\Component;
use App\Models\Equipo;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EquipoController extends Component
{
    use WithPagination;
    use WithFileUploads;
    private $pagination = 3;
    public $imagen;
    public $nombre;
    public $descripcion;
    public $pageTitle, $componentName;
    public $selected_id;
    public function render()
{
    // Obtener los equipos únicos por nombre y paginarlos
    $tags = Equipo::select('nombre')->distinct()->paginate($this->pagination);

    return view('livewire.equipo.equipo-controller', [
        'tags' => $tags
    ])->extends('layouts.theme.app')
        ->section('content');
}

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Equipo de Trabajo';
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function resetUI()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->imagen = '';


        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
    }

    public function edit(Equipo $user)
    {
        $this->selected_id = $user->id;
        $this->nombre = $user->nombre;


        $this->emit('show-modal', 'open!');
    }
    public function Store()
    {
        $rules = [
            'nombre' => 'required|min:3',

        ];

        $this->validate($rules);

        try {


            $user = Equipo::create([
                'nombre' => $this->nombre,

            ]);

            $this->resetUI();
            $this->emit('user-added', 'Usuario Registrado');
        } catch (\Exception $e) {
            dd($e);
            // Manejar la excepción (puedes personalizar este mensaje o realizar otras acciones)
            $this->emit('error', 'Ocurrió un error al registrar el usuario: ' . $e->getMessage());
        }
    }


    public function Update()
    {
        $rules = [
            'nombre' => 'required|min:3',


        ];



        $this->validate($rules);

        $user = Equipo::find($this->selected_id);
        $user->update([
            'nombre' => $this->nombre,


        ]);

        $this->resetUI();
        $this->emit('user-updated', 'Usuario Actualizado');
    }
    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'

    ];

    public function destroy(Equipo $user)
    {



        $user->delete();
        $this->resetUI();
        $this->emit('user-deleted', 'Usuario Eliminado');
    }
}
