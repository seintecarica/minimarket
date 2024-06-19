<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'bodega_id',
        'cantidad',
        'estado'
    ];
    
    public function cliente(){
        return $this->belongsTo(Customer::class);
    }

    public function bodega(){
        return $this->belongsTo(Store::class);
    }
}
