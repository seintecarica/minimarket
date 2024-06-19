<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'bodega_id',
        'producto_id',
        'tratamiento',
        'cantidad',
    ];

    public function bodega(){
        return $this->belongsTo(Store::class);
    }

    public function producto(){
        return $this->belongsTo(Product::class);
    }
}
