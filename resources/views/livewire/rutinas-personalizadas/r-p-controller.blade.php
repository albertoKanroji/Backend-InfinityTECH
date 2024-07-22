<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="btn btn-primary btn-rounded mb-2" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white text-center">NOMBRE</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">DESCRIPCIÓN</th>
                                <th class="table-th text-white text-center">TIPO</th>
                                <th class="table-th text-white text-center">MAX PUNTAJE</th>
                                <th class="table-th text-white text-center">MIN PUNTAJE</th>
                                <th class="table-th text-white text-center">ESTADO</th>
                                <th class="table-th text-white text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rutinas as $video)
                            <tr>
                                <td class="text-center">
                                    <h6>{{ $video->nombre }}</h6>
                                </td>
                                <td class="text-center">
                                    <img src="data:image/jpeg;base64,{{ $video->imagen }}" alt="Imagen"
                                        style="width: 50px; height: 50px;">
                                </td>
                                <td class="text-center">
                                    <h6>{{ $video->descripcion }}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{ $video->tipo }}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{ $video->max_puntaje }}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{ $video->min_puntaje }}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{ $video->estado }}</h6>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click="edit({{ $video->id }})"
                                        class="btn btn-primary btn-rounded mb-2" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="Confirm('{{ $video->id }}')"
                                        class="btn btn-danger btn-rounded mb-2" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{$rutinas->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.rutinas.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('video-added', Msg => {
            $('#theModal').modal('hide');
            resetInputFile();
            noty(Msg);
        });
        window.livewire.on('video-updated', Msg => {
            $('#theModal').modal('hide');
            resetInputFile();
            noty(Msg);
        });
        window.livewire.on('video-deleted', Msg => {
            noty(Msg);
        });
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show');
        });
    });

    function resetInputFile()
    {
        $('input[type=file]').val('');
    }

    function Confirm(id)
    {
        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if(result.value){
                window.livewire.emit('deleteRow', id);
                swal.close();
            }
        });
    }
</script>