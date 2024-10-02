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

                                <th class="table-th text-white text-center">CORREO</th>
                                <th class="table-th text-white text-center">ESTATUS</th>
                                <th class="table-th text-white text-center">RUTINA</th>
                                <th class="table-th text-white text-center">PERFIL COMPLETO</th>
                                <th class="table-th text-white text-center">PESO</th>
                                <th class="table-th text-white text-center">ALTURA</th>
                                <th class="table-th text-white text-center">IMC</th>

                                <th class="table-th text-white text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $r)
                            <tr>
                                <td class="text-center">
                                    <h6>{{$r->nombre}} {{$r->apellido}} {{$r->apellido2}}</h6>
                                </td>

                                </td>
                                <td class="text-center">
                                    <h6>{{$r->correo}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{$r->status}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{$r->rutina}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{$r->profileIsComplete ? 'Sí' : 'No'}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{$r->peso}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{$r->altura}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{ number_format($r->IMC, 2) }}</h6>
                                </td>


                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click="edit({{$r->id}})"
                                        class="btn btn-primary btn-rounded mb-2" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(Auth()->user()->id != $r->id)
                                    <a href="javascript:void(0)" onclick="Confirm('{{$r->id}}')"
                                        class="btn btn-danger btn-rounded mb-2" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.clientes.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('user-added', Msg => {
            $('#theModal').modal('hide')
            resetInputFile()
            noty(Msg)
        })
        window.livewire.on('user-updated', Msg => {
            $('#theModal').modal('hide')
            resetInputFile()
            noty(Msg)
        })
        window.livewire.on('user-deleted', Msg => {
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('user-withsales', Msg => {
            noty(Msg)
        })

    })

    function resetInputFile() {
        $('input[type=file]').val('');
    }


    function Confirm(id) {

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
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                swal.close()
            }

        })
    }
</script>
