<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ev_actos extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ev_actos';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'id_cp_etapainvestigacion', 
      'idCausa', 
      'idExpediente',       
      'FECHA_ACTOS_DE_INV', 
      'TIPO_CONTROL_ACTOS_DE_INV',
      'TIPO_ACTOS_DE_INV',
      'OBSERVACIONES_ACTOS_DE_INV', 
      'usuario'
    ];

    use HasFactory, SoftDeletes;
}
