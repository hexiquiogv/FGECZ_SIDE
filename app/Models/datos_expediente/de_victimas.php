<?php

namespace App\Models\datos_expediente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class de_victimas extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'prode_victimas';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'idExpediente',
        'TIPO_VICTIMA',
        'INTERPRETE',
        'DELITOS_VICTIMA',
        'RAZON_SOCIAL',
        'REPRESENTANTE_LEGAL',
        'TIPO_REPRESENTANTE_LEGAL',
        'SECTOR_VICTIMAS',
        'TIPO_PERSONA_VICTIMAS',
        'NOMBRE_VICTIMA',
        'PRIMER_APELLIDO',
        'SEGUNDO_APELLIDO_VICTIMAS',
        'CURP_VICTIMAS',
        'EDAD_HECHOS_VICTIMAS',
        'SEXO_VICTIMA',
        'SITUACION_CONYUGAL_VICTIMAS',
        'NACIONALIDAD',
        'SITUACION_MIGRATORIA_VICTIMAS',
        'PAIS_NACIMIENTO',
        'ENTIDAD_NACIMIENTO_VICTIMAS',
        'MUNICIPIO_NACIMIENTO',
        'PAIS_RESIDENCIA',
        'ENTIDAD_RESIDENCIA_VICTIMAS',
        'MUNICIPIO_RESIDENCIA',
        'TELEFONO_VICTIMAS',
        'TRADUCTOR_VICTIMA',
        'DISCAPACIDAD_VICTIMAS',
        'TIPO_DISCAPACIDAD_VICTIMAS',
        'INTERPRETE_POR_DISCAPACIDAD_VICTIMA',
        'POBLACION_CALLE',
        'LEER_ESCRIBIR',
        'ESCOLARIDAD',
        'OCUPACION',
        'SE_IDENTIFICA_INDIGENA_VICTIMA',
        'POBLACION_INDIGENA_VICTIMA',
        'RELACION_IMPUTADO',
        'FECHA_NACIMIENTO_VICTIMAS',
        'ASESORIA',
        'ATEN_MEDICA',
        'ATEN_PSICOLOGICA',
        'DOMICILIO_VICTIMA',
        // 'VICTIMA_ID',
        'HABLA_ESPAÑOL_VICTIMA',
        'HABLA_LENG_EXTR_VICTIMA',
        'HABLA_LENG_INDIG_VICTIMA',
        'NUMERO_DE_ATENCION',
        'INGRESO_VICTIMA',
        'TIPO_DE_ASESORIA',
        'TIPO_LENGUA_EXTRANJERA_VICTIMA',
        'LENGUA_VICTIMA',
        'VESTIMENTA_VICTIMA',
        'VICTIMA_VIOLENCIA',
          'DEF_FOLIO_DEFUNCION',
          'DEF_FECHA_EXP',
          'DEF_FECHA_DEFUNCION',
          'DEF_TIPO_DEFUNCION',
          'DEF_CERTIFICADO_POR',
          'DEF_SITIO_DEFUNCION',
          'DEF_SITIO_LESION',
          'DEF_FUE_EN_EL_TRABAJO',
          'DEF_AGENTE_EXTERNO',
          'DEF_TIPO_EVENTO',
          'DEF_TIPO_VICTIMA',
          'DEF_TIPO_ARMA',
          'DEF_ENTIDAD_DENUNICA',
          'DEF_MUNICIPIO_DENUNICA',
          'DEF_COLONIA_DENUNICA',
          'DEF_ENTIDAD_DEFUNCION',
          'DEF_MUNICIPIO_DEFUNCION',
          'DEF_COLONIA_DEFUNCION',
          'DEF_CAUSA_A',
          'DEF_DURACION_BCD',
          'DEF_ESTADO_PATOLOGICO',
          'DEF_DURACION_PATOLOGICO',
          'DEF_CONDICION_EMBARAZO',
          'DEF_PERIODO_POSPARTO',        
    ];

    use HasFactory, SoftDeletes;
}
