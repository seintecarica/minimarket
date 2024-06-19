<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'bodega_id',
        'marca_id',
        'total_neto',
        'total_iva',
        'usuario_id',
        'estado'
    ];

    public function bodega(){
        return $this->belongsTo(Store::class);
    }

    public function marca(){
        return $this->belongsTo(Brand::class);
    }

    public function usuario(){
        return $this->belongsTo(User::class);
    }
}
