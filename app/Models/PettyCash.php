<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'total_inicio',
        'ingr_v_efect',
        'ingr_v_deb',
        'ingr_v_transf',
        'ingr_v_gratis',
        'ingr_aportes',
        'ingr_total',
        'egre_p_fact',
        'egre_p_bol',
        'egre_p_otros',
        'egre_total',
        'total_transac',
        'total_rendido',
        'catn_10',
        'total_10',
        'catn_50',
        'total_50',
        'catn_100',
        'total_100',
        'catn_500',
        'total_500',
        'catn_1000',
        'total_1000',
        'catn_2000',
        'total_2000',
        'catn_5000',
        'total_5000',
        'catn_10000',
        'total_10000',
        'catn_20000',
        'total_20000',
        'total_efect_esperado',
        'total_efect_rendido',
        'saldo',
        'closet_at',
        'estado'
    ];

    public function usuario(){
        return $this->belongsTo(User::class);
    }
}
