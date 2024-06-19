<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'cliente_id',
        'bodega_id',
        'pago_id',
        'usuario_id',
        'estado'
    ];

    public function cliente(){
        return $this->belongsTo(Customer::class);
    }

    public function bodega(){
        return $this->belongsTo(Store::class);
    }

    public function pago(){
        return $this->belongsTo(PaymentForm::class);
    }

    public function usuario(){
        return $this->belongsTo(User::class);
    }
}
