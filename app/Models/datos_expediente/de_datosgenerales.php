<?php

namespace App\Models\datos_expediente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class de_datosgenerales extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'prode_datosgenerales';

    /**
     * @var array $fillable
     */
    protected $fillable = [
          'DELEGACION',
          'MUNICIPIO',
          'UNIDAD_ATENCION',
          'FECHA_INICIO_CARPETA',
          'HORA_APERTURA_CARPETA',
          'NUC',
          'NUC_COMPLETA',
          'NO_EXPEDIENTE',
          'ESTATUS_CARPETA',
          'AGENTE_ID',
          'NOMBRE_FISCALIA',
          'NOMBRE_AGENTE_MP',
          'MP_NOM',
          'MP_NUM',
          //'CARPETA_ID',
          'TIPO_MP',
          'TIPO_FISCALIA',
          'UBICACION_MP',
          // 'ID_SEGUIMIENTO',
          'FECHA_HECHOS',
          'HORA_HECHOS',
          'ENTIDAD_HECHOS',
          'MUNICIPIO_HECHOS',
          'COLONIA_HECHOS',
          'CALLE_HECHOS',
          'CP',
          'REF_1',
          'REF_2',
          'RECIBIDA_POR',
          'UNIDAD_QUE_RECIBE',
          'MEDIO_RECEPCION',
          'TIPO_RECEPCION',
          'AUTORIDAD',
          'HORA_DENUNCIA',
          'PARENTESCO',
          'FORMA_',
          'ASEGURAMIENTO', 
          'TIPO_DE_BIEN', 
          'OPORTUNIDAD', 
          'ETAPA_PROCES', 
          'MEDIO_DE_CONOCIMIENTO', 
          'FECHA_DENUNCIA', 
          'REACTIVACION',
          'DESCRIPCION',
          'OBSERVACIONES',
        'AUTORIDAD_IPH',
          'FECHA_DETERMINACION', 
          'SENTIDO_DETERMINACION', 
          'TIPO_DETERMINACION',
          'TIPO_ACCION_PENAL',
          'ARCHIVO_TEMPORAL',
          'MOTIVO_REACTIVACION',
          'MOTIVO_DETERMINA',
          'FOLIO_AE',
          'PAGO_ECONOMICO_MONTO',
          'ACTO_EQUIVALENTE_MONTO',
          'REMISION_OTRA_AREA',
          'FECHA_EJERCICIO_ACCION_PENAL',
          'TIPO_ACUERDO_PERDON_REPARACION'
    ];
     ////public $timestamps = false;
    use HasFactory, SoftDeletes;
}
