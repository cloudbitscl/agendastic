<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    public function __toString()
    {
        return $this->nombre;
    }

    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class, 'servicios_proveedores', 'servicio_id', 'proveedor_id');
    }
}
