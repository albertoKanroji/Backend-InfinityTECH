@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: Press Banca">
            @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>


</div>

@include('common.modalFooter')