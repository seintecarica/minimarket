<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'movil',
        'responsable_id',
        'observacion',
        'estado'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
