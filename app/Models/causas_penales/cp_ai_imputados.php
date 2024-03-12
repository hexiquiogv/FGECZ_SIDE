<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ai_imputados extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ai_imputados';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'idcp_audienciainicial', 
      'idCausa', 
      'idExpediente', 
      'idImputado',
      'DECRETO_LEGAL_DETENCION', 
      'FECHA_CONTROL', 
      'FORMA_DE_CONDUCCION_DEL_IMPUTADO_A_PROCESO', 
      'FECHA_FORM', 
      'FORMULACION', 
      'OBSERVACIONES',
      'RESOLUCION', 
      'FECHA_RESOL', 
      'DELITO_VINCULO',
      'INV_CON_DETENIDO', 
      // 'MEDIDAS_CAUTELARES', 
      // 'TIPO_MEDIDAS_CAUTELARES', 
      // 'TEMPORALIDAD_MEDIDA', 
      // 'ACUERDO_REPARATORIO', 
      // 'FECHA_CUMPLIMIENTO',       
      // 'FECHA_ACUERDOS_REPARATORIOS', 
      // 'ACUERDOS_REPARATORIOS', 
      // 'MONTO_REP_DAÑO', 
      // 'CONDICION_IMPUESTA', 
      // 'TEMPORALIDAD', 
      // 'REPARACION_DEL_DAÑO', 
      // 'TEMPORALIDAD_SALIDAD_ALTERNAS', 
      // 'SUSPENSION_CONDICIONAL', 
      // 'FECHA_SUSPENSION', 
      // 'TIPO_SUSPENSION', 
      // 'FECHA_CUMPL', 
      // 'SUSPENSION_DEL_PROCESO', 
      // 'CAUSA_PROCESO', 
      // 'FECHA_DE_REANUDACION', 
      // 'FECHA_SOBRESEIMIENTO', 
      // 'CAUSAS_SOBRESEIMIENTO', 
      // 'TIPO_SOBRESEIMIENTO'
      'bitControl','bitFormulacion','bitVinculacion'
    ];

    use HasFactory, SoftDeletes;
}
