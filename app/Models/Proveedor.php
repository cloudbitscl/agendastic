<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    public function __toString()
    {
        return $this->nombre;
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicios_proveedores', 'proveedor_id', 'servicio_id');
    }
}
