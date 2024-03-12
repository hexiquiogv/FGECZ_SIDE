<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ei_imputados extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ei_imputados';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'idcp_etapaintermedia', 
      'idCausa', 
      'idExpediente', 
      'idImputado',
      'FECHA_SOBRESEIMIENTO', 
      'CAUSAS_SOBRESEIMIENTO', 
      'TIPO_SOBRESEIMIENTO',      
      'ACUERDO_REPARATORIO', 
      'FECHA_CUMPLIMIENTO',
      'FECHA_ACUERDOS_REPARATORIOS', 
      'ACUERDOS_REPARATORIOS', 
      'MONTO_REP_DAÑO', 
      'CONDICION_IMPUESTA', 
      'TEMPORALIDAD', 
      'REPARACION_DEL_DAÑO', 
      'TEMPORALIDAD_SALIDAD_ALTERNAS',
      ];

    use HasFactory, SoftDeletes;
}
