<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = [
        'nombre',
        'apellido',
        'apellido2',
        'correo',
        'password',
        'rutina',
        'profileIsComplete',
        'peso',
        'altura',
        'IMC',
        'sexo',
        'fecha_embresia'

    ];
    public function rutinas()
    {
        return $this->belongsToMany(Rutinas::class, 'rutinas_clientes', 'customers_id', 'rutinas_id');
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'customers_id');
    }
    public function seguimientoImagenes()
    {
        return $this->hasMany(SeguimientoClientesImagenes::class, 'customers_id');
    }
}
