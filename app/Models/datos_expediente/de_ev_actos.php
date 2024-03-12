<?php

namespace App\Models\datos_expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class de_ev_actos extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'prode_ev_actos';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'id_de_etapainvestigacion', 
      // 'idCausa', 
      'idExpediente',       
      'FECHA_ACTOS_DE_INV', 
      'TIPO_CONTROL_ACTOS_DE_INV',
      'TIPO_ACTOS_DE_INV',
      'OBSERVACIONES_ACTOS_DE_INV', 
      'usuario'
    ];

    use HasFactory, SoftDeletes;
}
