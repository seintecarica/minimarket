<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'marca_id',
        'categoria_id',
        'nombre',
        'codigo',
        'unidad_id',
        'unid_caja',
        'precio',
        'precio_unid',
        'precio_oferta',
        'min',
        'usuario_id',
        'estado'
    ];

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function marca(){
        return $this->belongsTo(Brand::class);
    }

    public function unidad(){
        return $this->belongsTo(Unit::class);
    }

    public function categoria(){
        return $this->belongsTo(Category::class);
    }
    //falta relación de productos con las demás tablas
}
