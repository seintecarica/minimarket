<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetailGuide extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $filliable = [
        'guia_venta_id',
        'producto_id',
        'cantidad',
        'precio',
        'subtotal'
    ];

    public function producto(){
        return $this->belongsTo(Product::class);
    }

    public function guia_venta(){
        return $this->belongsTo(SalesGuide::class);
    }
}
