@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: Press Banca">
            @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Imagen (Base64)</label>
            <input type="file" wire:model.lazy="imagen" class="form-control">
            @error('imagen') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Descripción</label>
            <textarea wire:model.lazy="descripcion" class="form-control"
                placeholder="ej: Ejercicio para el pecho"></textarea>
            @error('descripcion') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Tipo</label>
            <input type="text" wire:model.lazy="tipo" class="form-control" placeholder="ej: Fuerza">
            @error('tipo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <!-- <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Max Puntaje</label>
            <input type="number" wire:model.lazy="max_puntaje" class="form-control" placeholder="ej: 100">
            @error('max_puntaje') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Min Puntaje</label>
            <input type="number" wire:model.lazy="min_puntaje" class="form-control" placeholder="ej: 0">
            @error('min_puntaje') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div> -->

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estado</label>
            <select wire:model.lazy="estado" class="form-control">
                <option value="">Seleccionar Estado</option>
                <option value="publica">Publica</option>
                <option value="perzonalizada">Perzonalizada</option>
            </select>
            @error('estado') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

@include('common.modalFooter')
