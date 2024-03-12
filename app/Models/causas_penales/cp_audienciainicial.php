<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_audienciainicial extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_audienciainicial';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'idCausa', 
      'idExpediente',
      'idImputado', 
      'AUDIENCIA_INICIAL', 
      'FECHA_AUDIENCIA_INICIAL', 
      'MOTIVO_NOAUD', 
      'FECHA_INICIO_INVESTIGACION', 
      'FECHA_CIERRE', 
      //'PRORROGA', 
      'NOMBRE_JUEZ_CONTROL',
      'bitCelebracion',
      'bitPlazo'
      ];

    use HasFactory, SoftDeletes;
}
