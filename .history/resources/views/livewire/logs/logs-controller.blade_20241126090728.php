<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName}} | {{ $pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>

            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white text-center">ID</th>
                                <th class="table-th text-white text-center">cliente</th>
                                <th class="table-th text-white text-center">Accion</th>
                                <th class="table-th text-white text-center">Contenido</th>
                                <th class="table-th text-white text-center">Creado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr>
                                <td class="text-center">
                                    <h6>{{$log->id}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{$log->usuario}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{$log->accion}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{$log->contenido}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{$log->created_at}}</h6>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>


        </div>


    </div>

</div>
