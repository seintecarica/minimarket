<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraphicCustomer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'bodega_id',
        'id_mes',
        'mes',
        'cantidad',
        'anio'
    ];
}
