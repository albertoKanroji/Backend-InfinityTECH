@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: Luis">
            @error('nombre') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Apellido</label>
            <input type="text" wire:model.lazy="apellido" class="form-control" placeholder="ej: García">
            @error('apellido') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Segundo Apellido</label>
            <input type="text" wire:model.lazy="apellido2" class="form-control" placeholder="ej: López">
            @error('apellido2') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="text" wire:model.lazy="correo" class="form-control" placeholder="ej: luisfaax@gmail.com">
            @error('correo') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" wire:model.lazy="password" class="form-control">
            @error('password') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <!-- <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Rutina</label>
            <input type="text" wire:model.lazy="rutina" class="form-control" placeholder="ej: Rutina de Ejercicio">
            @error('rutina') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Perfil Completo</label>
            <select wire:model.lazy="profileIsComplete" class="form-control">
                <option value="0" selected>No</option>
                <option value="1">Sí</option>
            </select>
            @error('profileIsComplete') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div> -->
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Peso (kg)</label>
            <input type="number" wire:model.lazy="peso" class="form-control" placeholder="ej: 70">
            @error('peso') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Altura (cm)</label>
            <input type="number" wire:model.lazy="altura" class="form-control" placeholder="ej: 175">
            @error('altura') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>IMC</label>
            <input type="number" wire:model.lazy="IMC" class="form-control" placeholder="ej: 22.5" readonly step="0.1">
            @error('IMC') <span class="text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

</div>

@include('common.modalFooter')
