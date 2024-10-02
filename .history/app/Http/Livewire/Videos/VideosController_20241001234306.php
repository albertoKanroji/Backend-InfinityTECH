<?php

namespace App\Http\Livewire\Videos;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\GruposMuscularesVideos;
use App\Models\Tag;
use App\Models\Equipo;
use App\Models\GruposMusculares;

class VideosController extends Component
{
    public $nombre;
    public $miniatura;
    public $descripcion;
    public $gm_id;
    public $video_url;
    public $selected_id;
    public $search;
    public $tags;
    public $lesion;
    public $equipos;
    use WithPagination;
    use WithFileUploads;
    public $page = 1;
    public $pageTitle, $componentName;
    private $pagination = 3;
    protected $rules = [
        'nombre' => 'required|min:3',
        'miniatura' => 'nullable',
        'descripcion' => 'required|min:3',
        'gm_id' => 'required|exists:grupos_musculares,id',
        'video_url' => 'required|url',
        'tags' => 'nullable|array',
        'tags.*' => 'exists:tags,id',
        'equipos' => 'nullable|array',
        'equipos.*' => 'exists:equipos,id'
    ];

    protected $messages = [
        'nombre.required' => 'Ingresa el nombre',
        'nombre.min' => 'El nombre debe tener al menos 3 caracteres',


        'descripcion.required' => 'Ingresa la descripción',
        'descripcion.min' => 'La descripción debe tener al menos 3 caracteres',
        'gm_id.required' => 'Selecciona un grupo muscular',
        'gm_id.exists' => 'Grupo muscular no válido',
        'video_url.required' => 'Ingresa la URL del video',
        'video_url.url' => 'Ingresa una URL válida',
        'tags.array' => 'Las etiquetas deben ser un array',
        'tags.*.exists' => 'Etiqueta no válida',
        'equipos.array' => 'Los equipos deben ser un array',
        'equipos.*.exists' => 'Equipo no válido'
    ];
    public function mount()
    {
        $this->nombre = '';
        $this->miniatura = '';
        $this->descripcion = '';
        $this->gm_id = null;
        $this->video_url = '';
        $this->tags;
        $this->equipos;
        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
        $this->pageTitle = 'Listado';
        $this->componentName = 'Videos';
    }
    public function resetUI()
    {
        $this->nombre = '';
        $this->miniatura = '';
        $this->descripcion = '';
        $this->gm_id = null;
        $this->video_url = '';
        $this->tags;
        $this->equipos;
        $this->selected_id = 0;
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        $gruposMusculares = GruposMusculares::all();
        $equipo = Equipo::all();
        $tags = Tag::all();
        //dd($tags);
        $customers = GruposMuscularesVideos::with(['tags', 'equipos', 'grupoMuscular'])->paginate(10);
        return view('livewire.videos.videos-controller', [
            'data' => $customers,
            'gruposMusculares' => $gruposMusculares,
            'etiqueta' =>  $tags,
            'eq' => $equipo

        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Store()
    {
        //$this->validate();

        if ($this->miniatura instanceof \Livewire\TemporaryUploadedFile) {
            $miniatura = $this->miniatura->store('miniaturas', 'public');
            $miniaturaPath = storage_path("app/public/{$miniatura}");
            $miniaturaData = file_get_contents($miniaturaPath);
            $miniaturaBase64 = base64_encode($miniaturaData);
        }

        // Guardar los datos
        $data = [
            'nombre' => $this->nombre,
            'miniatura' => $miniaturaBase64,
            'descripcion' => $this->descripcion,
            'gm_id' => $this->gm_id,
            'video_url' => $this->video_url
        ];
        $video = GruposMuscularesVideos::create($data);

        if (!empty($this->tags)) {
            $video->tags()->sync($this->tags);
        }

        if (!empty($this->equipos)) {
            $video->equipos()->sync($this->equipos);
        }

        $this->resetUI();
        $this->emit('video-added', 'Video Registrado');
    }
    public function edit(GruposMuscularesVideos $video)
    {
        $this->selected_id = $video->id;
        $this->nombre = $video->nombre;
        $this->miniatura = $video->miniatura;
        $this->descripcion = $video->descripcion;
        $this->gm_id = $video->gm_id;
        $this->video_url = $video->video_url;
        $this->tags = $video->tags->pluck('id')->toArray(); // Cargar IDs de tags
        $this->equipos = $video->equipos->pluck('id')->toArray();

        $this->emit('show-modal', 'open!');
    }
    public function Update()
{
    // Validation
    $this->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'gm_id' => 'required|exists:grupos_musculares,id',
        'video_url' => 'required|url',
        'lesion' => 'nullable|string',

    ]);

    try {
        $video = GruposMuscularesVideos::findOrFail($this->selected_id);

        // Update basic data
        $video->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'gm_id' => $this->gm_id,
            'video_url' => $this->video_url,
            'lesion' => $this->lesion,
        ]);


         if ($this->miniatura instanceof \Livewire\TemporaryUploadedFile) {
             $miniaturaPath = $this->miniatura->store('miniaturas', 'public');
             $video->miniatura = $miniaturaPath;
         }

        // Save changes
        $video->save();

        // Synchronize tags and equipos
        $video->tags()->sync($this->tags ?? []);
        $video->equipos()->sync($this->equipos ?? []);

        $this->resetUI();
        $this->emit('video-updated', 'Video Actualizado');
    } catch (\Exception $e) {
        // Log the error for debugging

        // Provide a user-friendly error message
        $this->emit('video-updated', 'Error al actualizar el video');
    }
}


    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'
    ];

    public function destroy(GruposMuscularesVideos $video)
    {


        $video->tags()->detach();
        $video->equipos()->detach();
        $video->delete();

        $this->resetUI();
        $this->emit('video-deleted', 'Video Eliminado');
    }
}
