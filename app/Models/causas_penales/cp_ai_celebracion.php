<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ai_celebracion extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'bitcp_ai_celebracion';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'id_cp_audienciainicial',
      'idCausa',
      'idExpediente',
      'idImputado',
      'FECHA_AUDIENCIA_INICIAL',
      'AUDIENCIA_INICIAL',
      'MOTIVO_NOAUD',
      'NOMBRE_JUEZ_CONTROL'
    ];

    use HasFactory, SoftDeletes;
}
