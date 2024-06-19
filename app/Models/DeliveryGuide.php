<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'bodega_origen',
        'bodega_destino',
        'usuario_id',
        'estado'
    ];

    public function origen(){
        return $this->belongsTo(Store::class);
    }

    public function destino(){
        return $this->belongsTo(Store::class);
    }

    public function usuario(){
        return $this->belongsTo(User::class);
    }
}
