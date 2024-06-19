<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryDetailGuide extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $filliable = [
        'guia_entrega_id',
        'producto_id',
        'cantidad'
    ];

    public function producto(){
        return $this->belongsTo(Product::class);
    }

    public function guia_entrega(){
        return $this->belongsTo(DeliveryGuide::class);
    }
}
