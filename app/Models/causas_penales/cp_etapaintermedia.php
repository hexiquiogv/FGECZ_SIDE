<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_etapaintermedia extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_etapaintermedia';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'idCausa', 
      'idExpediente', 
      'idImputado',
      'ACUSACION', 
      'FECHA_ESCRITO_ACUS', 
      // 'FECHA_ACUSACION', 
      'INTERMEDIA', 
      'FECHA_AUDIENCIA_INTERMEDIA', 
      'SUSPENSION_DE_AUDIENCIA', 
      'CAUSAS_SUSPENSION_INTERMEDIA', 
      'FECHA_DE_REANUDACION_INTERMEDIA', 
      // 'CAUSAS_NO_ADMISION', 
      'MEDIO_PRUEBA', 
      // 'MEDIOS_PRUEBAS', 
      'ACUERDOS_PROP',
      'OBSERVACIONES_ACUERDOS',
      'JUICIO_ORAL', 
      'AUTO_DE_APERTURA', 
      'FECHA_AUDIENCIA_JUICIO',
      'bitAcusacion',
      'bitAudienciaIntermedia',
      'bitAcuerdosProbatorios',
      'bitDatosJuicioOral', ];

    use HasFactory, SoftDeletes;
}
