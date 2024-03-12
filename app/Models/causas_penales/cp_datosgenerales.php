<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_datosgenerales extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_datosgenerales';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'idExpediente',
      'CAUSA_PENAL_ID', 
      'FECHA_CAUSA_PENAL', 
      // 'FECHA_INICIO_ATENCION', 
      // 'FECHA_CONCLUSION_ATENCION', 
      // 'TIPO_DE_ATENCION', 
      // 'SENTIDO', 
      // 'FECHA_DETERMINACION', 
      // 'SENTIDO_DETERMINACION', 
      'UNIDAD_DE_INVESTIGACION',
      'DISTRITO_JUDICIAL',
      // 'DETENCION_LEGAL_ILEGAL',
      // 'MASC', 
      // 'FECHA_DERIVA_MASC', 
      // 'FECHA_CUMPL_MAS', 
      // 'TIPO_CUMPLIMIENTO', 
      // 'TIPO_MASC', 
      // 'AUTORIDAD_DERIVA_MASC', 
      // 'TIPOS_DE_ACTOS_CON_CONTROL', 
      // 'TIPOS_DE_ACTOS_SIN_CONTROL', 
      // 'REAPERTURA', 
      // 'FECHA_REAPERTURA_', 
      'MOMENTO_RECLAS', 
      'FECHA_RECLAS', 
      'OBSERVACIONES'];

    use HasFactory, SoftDeletes;
}
