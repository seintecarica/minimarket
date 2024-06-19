<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchDetailGuide extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $filliable = [
        'guia_despacho_id',
        'producto_id',
        'cantidad',
        'costo_unit'
    ];

    public function producto(){
        return $this->belongsTo(Product::class);
    }

    public function guia_despacho(){
        return $this->belongsTo(DispatchGuide::class);
    }
}
