<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'rut',
        'bodega_id',
        'razon_social',
        'nombre_contacto',
        'telefono',
        'direccion',
        'estado'
    ];

    public function bodega(){
        return $this->belongsTo(Store::class);
    }
}
