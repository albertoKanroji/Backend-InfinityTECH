<?php

namespace App\Http\Livewire\Rutinas;

use Livewire\Component;
use App\Models\Rutinas;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class RutinasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    private $pagination = 3;
    public $nombre;
    public $imagen;
    public $descripcion;
    public $tipo;
    public $max_puntaje;
    public $min_puntaje;
    public $estado;

    public $pageTitle, $componentName;
    public $selected_id;
    public function render()
    {
        $rutinas = Rutinas::where('estado', 'publica')->paginate($this->pagination);

        return view('livewire.rutinas.rutinas-controller', [
            'rutinas' => $rutinas
        ])->extends('layouts.theme.app')
            ->section('content');
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Rutinas';
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function resetUI()
    {
        $this->nombre = '';
        $this->imagen = '';
        $this->descripcion = '';
        $this->tipo = '';
        $this->max_puntaje = '';
        $this->min_puntaje = '';
        $this->estado = '';

        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
    }

    public function edit(Rutinas $user)
    {
        $this->selected_id = $user->id;
        $this->nombre = $user->nombre;
        $this->imagen = $user->imagen;
        $this->descripcion = $user->descripcion;
        $this->tipo = $user->tipo;
        $this->max_puntaje = $user->max_puntaje;
        $this->min_puntaje = $user->min_puntaje;
        $this->estado = $user->estado;

        $this->emit('show-modal', 'open!');
    }

    public function Store()
    {
        $rules = [
            'nombre' => 'required|min:3',
            'descripcion' => 'required|min:3',

            'tipo' => 'required|min:3',
            // 'max_puntaje' => 'required|numeric',
            // 'min_puntaje' => 'required|numeric',
            'estado' => 'required|in:publica,perzonalizada',
        ];

        $this->validate($rules);

        try {
            $miniatura = $this->imagen->store('miniaturas', 'public');
            $miniaturaPath = storage_path("app/public/{$miniatura}");
            $miniaturaData = file_get_contents($miniaturaPath);
            $miniaturaBase64 = base64_encode($miniaturaData);



            $user = Rutinas::create([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'imagen' => $miniaturaBase64,
                'tipo' => $this->tipo,
                'max_puntaje' => $this->max_puntaje,
                'min_puntaje' => $this->min_puntaje,
                'estado' => $this->estado,
            ]);

            $this->resetUI();
            $this->emit('user-added', 'Usuario Registrado');
        } catch (\Exception $e) {
            // Manejar la excepción (puedes personalizar este mensaje o realizar otras acciones)
            $this->emit('error', 'Ocurrió un error al registrar el usuario: ' . $e->getMessage());
        }
    }

    public function Update()
    {
        $rules = [
            'nombre' => 'required|min:3',
            'descripcion' => 'required|min:3',

            'tipo' => 'required|min:3',
            // 'max_puntaje' => 'required|numeric',
            // 'min_puntaje' => 'required|numeric',
            'estado' => 'required|in:publica,perzonalizada',
        ];

        $this->validate($rules);
        $miniaturaBase64 = $this->imagen;
        try {
            // $miniatura = $this->imagen->store('miniaturas', 'public');
            // $miniaturaPath = storage_path("app/public/{$miniatura}");
            // $miniaturaData = file_get_contents($miniaturaPath);
            // $miniaturaBase64 = base64_encode($miniaturaData);
            if ($this->imagen instanceof \Livewire\TemporaryUploadedFile) {
                $miniatura = $this->imagen->store('miniaturas', 'public');
                $miniaturaPath = storage_path("app/public/{$miniatura}");
                $miniaturaData = file_get_contents($miniaturaPath);
                $miniaturaBase64 = base64_encode($miniaturaData);
            }

            $user = Rutinas::find($this->selected_id);
            $user->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'imagen' => $miniaturaBase64,
                'tipo' => $this->tipo,
                'max_puntaje' => $this->max_puntaje,
                'min_puntaje' => $this->min_puntaje,
                'estado' => $this->estado,
            ]);

            $this->resetUI();
            $this->emit('user-updated', 'Usuario Actualizado');
        } catch (\Exception $e) {
            dd($e);
            // Manejar la excepción (puedes personalizar este mensaje o realizar otras acciones)
            $this->emit('error', 'Ocurrió un error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'

    ];

    public function destroy(Rutinas $user)
    {



        $user->delete();
        $this->resetUI();
        $this->emit('user-deleted', 'Usuario Eliminado');
    }
}
