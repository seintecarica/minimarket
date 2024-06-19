<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bodega_id',
        'pago_id',
        'producto_id',
        'usuario_id',
        'unidad_id',
        'cantidad',
        'precio',
        'total'
    ];

    public function bodega(){
        return $this->belongsTo(Store::class);
    }

    public function pago(){
        return $this->belongsTo(PaymentForm::class);
    }

    public function producto(){
        return $this->belongsTo(Product::class);
    }

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function unidad(){
        return $this->belongsTo(Unit::class);
    }
}
