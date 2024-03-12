<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ev_medidas extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ev_medidas';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'id_cp_ev_victimas',
      'idVictima', 
      'idCausa', 
      'idExpediente',       
      'TIPO_DE_MEDIDA',       
      'TEMPORALIDAD_DE_LA_MEDIDA', 
      'MEDIDA_IMPUESTA_POR',
      'usuario'
    ];

    use HasFactory, SoftDeletes;
}
