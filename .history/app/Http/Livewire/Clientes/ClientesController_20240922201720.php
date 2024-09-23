<?php

namespace App\Http\Livewire\Clientes;

use Livewire\Component;
use App\Models\Customers;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ClientesController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $pageTitle, $componentName;
    public $customers;
    private $pagination = 3;
    public $nombre;
    public $apellido;
    public $apellido2;
    public $correo;
    public $password;
    public $status = 'Elegir';
    public $rutina;
    public $profileIsComplete = 0;
    public $peso;
    public $altura;
    public $IMC;

    public $selected_id = 0;
    public $search;
    public $profile;
    public $roles;  // Asumiendo que tienes un listado de roles disponibles

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Clientes';
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        $customers = Customers::paginate($this->pagination);
        return view('livewire.clientes.clientes-controller', [
            'data' => $customers,

        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function resetUI()
    {
        $this->nombre = '';
        $this->apellido = '';
        $this->apellido2 = '';
        $this->correo = '';
        $this->password = '';
        $this->status = 'Elegir';
        $this->rutina = '';
        $this->profileIsComplete = 0;
        $this->peso = '';
        $this->altura = '';
        $this->IMC = '';

        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
    }
    public function edit(Customers $user)
    {
        $this->selected_id = $user->id;
        $this->nombre = $user->nombre;
        $this->apellido = $user->apellido;
        $this->apellido2 = $user->apellido2;
        $this->correo = $user->correo;
        $this->password = '';
        $this->status = $user->status;
        $this->rutina = $user->rutina;
        $this->profileIsComplete = $user->profileIsComplete;
        $this->peso = $user->peso;
        $this->altura = $user->altura;
        $this->IMC = $user->IMC;
        $this->emit('show-modal', 'open!');
    }
    public function Store()
    {
        $rules = [
            'nombre' => 'required|min:3',
            'apellido' => 'required|min:3',
            'apellido2' => 'required|min:3',
            'correo' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
            'rutina' => 'required|min:3',
            'profileIsComplete' => 'required|boolean',
            'peso' => 'required|numeric|min:1',
            'altura' => 'required|numeric|min:1',
            'IMC' => 'required|numeric|min:1',
            'password' => 'required|min:3'
        ];

        $messages = [
            'nombre.required' => 'Ingresa el nombre',
            'nombre.min' => 'El nombre del usuario debe tener al menos 3 caracteres',
            'apellido.required' => 'Ingresa el apellido',
            'apellido.min' => 'El apellido debe tener al menos 3 caracteres',
            'apellido2.required' => 'Ingresa el segundo apellido',
            'apellido2.min' => 'El segundo apellido debe tener al menos 3 caracteres',
            'correo.required' => 'Ingresa el correo',
            'correo.email' => 'Ingresa un correo válido',
            'correo.unique' => 'El email ya existe en el sistema',
            'status.required' => 'Selecciona el estatus del usuario',
            'status.not_in' => 'Selecciona el estatus',
            'rutina.required' => 'Ingresa la rutina',
            'rutina.min' => 'La rutina debe tener al menos 3 caracteres',
            'profileIsComplete.required' => 'Selecciona si el perfil está completo',
            'profileIsComplete.boolean' => 'Valor no válido para perfil completo',
            'peso.required' => 'Ingresa el peso',
            'peso.numeric' => 'El peso debe ser numérico',
            'peso.min' => 'El peso debe ser mayor a 0',
            'altura.required' => 'Ingresa la altura',
            'altura.numeric' => 'La altura debe ser numérica',
            'altura.min' => 'La altura debe ser mayor a 0',
            'IMC.required' => 'Ingresa el IMC',
            'IMC.numeric' => 'El IMC debe ser numérico',
            'IMC.min' => 'El IMC debe ser mayor a 0',
            'password.required' => 'Ingresa el password',
            'password.min' => 'El password debe tener al menos 3 caracteres'
        ];

        $this->validate($rules, $messages);
$IMC=$this->peso*($this->altura*2);
        $user = Customers::create([




            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'apellido2' => $this->apellido2,
            'correo' => $this->correo,
            'password' => bcrypt($this->password),
            'status' => $this->status,
            'rutina' => $this->rutina,
            'profileIsComplete' => $this->profileIsComplete,
            'peso' => $this->peso,
            'altura' => $this->altura,
            'IMC' => $IMC,
        ]);


        $this->resetUI();
        $this->emit('user-added', 'Usuario Registrado');
    }

    public function Update()
    {
        $rules = [
            'correo' => "required|email|unique:customers,correo,{$this->selected_id}",
            'nombre' => 'required|min:3',
            'apellido' => 'required|min:3',
            'apellido2' => 'required|min:3',
            'status' => 'required|not_in:Elegir',
            'rutina' => 'required|min:3',
            'profileIsComplete' => 'required|boolean',
            'peso' => 'required|numeric|min:1',
            'altura' => 'required|numeric|min:1',
            'IMC' => 'required|numeric|min:1'
        ];

        $messages = [
            'nombre.required' => 'Ingresa el nombre',
            'nombre.min' => 'El nombre del usuario debe tener al menos 3 caracteres',
            'apellido.required' => 'Ingresa el apellido',
            'apellido.min' => 'El apellido debe tener al menos 3 caracteres',
            'apellido2.required' => 'Ingresa el segundo apellido',
            'apellido2.min' => 'El segundo apellido debe tener al menos 3 caracteres',
            'correo.required' => 'Ingresa el correo',
            'correo.email' => 'Ingresa un correo válido',
            'correo.unique' => 'El email ya existe en el sistema',
            'status.required' => 'Selecciona el estatus del usuario',
            'status.not_in' => 'Selecciona el estatus',
            'rutina.required' => 'Ingresa la rutina',
            'rutina.min' => 'La rutina debe tener al menos 3 caracteres',
            'profileIsComplete.required' => 'Selecciona si el perfil está completo',
            'profileIsComplete.boolean' => 'Valor no válido para perfil completo',
            'peso.required' => 'Ingresa el peso',
            'peso.numeric' => 'El peso debe ser numérico',
            'peso.min' => 'El peso debe ser mayor a 0',
            'altura.required' => 'Ingresa la altura',
            'altura.numeric' => 'La altura debe ser numérica',
            'altura.min' => 'La altura debe ser mayor a 0',
            'IMC.required' => 'Ingresa el IMC',
            'IMC.numeric' => 'El IMC debe ser numérico',
            'IMC.min' => 'El IMC debe ser mayor a 0'
        ];

        $this->validate($rules, $messages);

        $user = Customers::find($this->selected_id);
        $user->update([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'apellido2' => $this->apellido2,
            'correo' => $this->correo,
            'password' => strlen($this->password) > 0 ? bcrypt($this->password) : $user->password,
            'status' => $this->status,
            'rutina' => $this->rutina,
            'profileIsComplete' => $this->profileIsComplete,
            'peso' => $this->peso,
            'altura' => $this->altura,
            'IMC' => $this->IMC,
        ]);

        $this->resetUI();
        $this->emit('user-updated', 'Usuario Actualizado');
    }
    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'

    ];

    public function destroy(Customers $user)
    {



        $user->delete();
        $this->resetUI();
        $this->emit('user-deleted', 'Usuario Eliminado');
    }
}