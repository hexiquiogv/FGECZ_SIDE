<?php

namespace App\Models\datos_expediente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class de_imputados extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'prode_imputados';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'idExpediente',
        'INTERPRETE',
        'TIPO_IMPUTADO',
        'RAZON_SOCIAL',
        'REL_PERS_MORAL',
        'SECTOR_IMPUTADOS',
        'TIPO_PERSONA_IMPUTADOS',
        'DELITOS_IMPUTADO',
        'ALIAS_IMPUTADO',
        'RELACION_VICTIMA',
        'NOMBRE_IMPUTADO',
        'PRIMER_APELLIDO',
        'SEGUNDO_APELLIDO_IMPUTADOS',
        'CURP_IMPUTADOS',
        'FECHA_NACIMIENTO_IMPUTADOS',
        'EDAD_HECHOS_IMPUTADOS',
        'SEXO_IMPUTADO',
        'SITUACION_CONYUGAL_IMPUTADOS',
        'NACIONALIDAD',
        'SITUACION_MIGRATORIA_IMPUTADOS',
        'PAIS_NACIMIENTO',
        'ENTIDAD_NACIMIENTO_IMPUTADOS',
        'MUNICIPIO_NACIMIENTO',
        'PAIS_RESIDENCIA',
        'ENTIDAD_RESIDENCIA_IMPUTADOS',
        'MUNICIPIO_RESIDENCIA',
        'TELEFONO_IMPUTADOS',
        'TRADUCTOR_IMPUTADO',
        'DISCAPACIDAD_IMPUTADOS',
        'TIPO_DISCAPACIDAD_IMPUTADOS',
        'INTERPRETE_POR_DISCAPACIDAD_IMPUTADO',
        'POBLACION_CALLE',
        'LEER_ESCRIBIR_IMPUTADOS',
        'ESCOLARIDAD_IMPUTADO',
        'SE_IDENTIFICA_INDIGENA_IMPUTADO',
        'INDIGENA_IMPUTADO',
        'DETENIDO_IMPUTADOS',
        'ESTADO_IMPUTADO',
        'FECHA_DETENCION',
        'HORA_DETENCION',
        'TIPO_DETENCION',
        'ENTIDAD_DETENCION_IMPUTADOS',
        'AUTORIDAD_DETENCION_IMPUTADOS',
        'FOLIO_RND',
        'RAZON_RND',
        'EXAMEN_DETENCION_IMPUTADOS',
        'LESIONADO',
        'ESTADO_PRESENTACION',
        'SITUACION_LIBERTAD',
        'ANTECEDENTES',
        'DEFENSA',
        'DOMICILIO_IMPUTADO',
        'GRADO_DE_PARTICIPACION',
        'HABLA_ESPAÑOL_IMPUTADO',
        'HABLA_LENG_EXTR_IMPUTADO',
        'HABLA_LENG_INDIG_IMPUTADO',
        // 'IMPUTADO_ID',
        'MEDIA_FILIACION_IMPUTADO',
        'NOMBRE_DE_GRUPO',
        'OCUPACION_IMPUTADO',
        'INGRESO_IMPUTADO',
        'REPRESENTANTE_LEGAL',
        'TIPO_REPRESENTANTE_LEGAL',
        'TIPO_DEFENSA',
        'TIPO_LENGUA_EXTRANJERA_IMPUTADO',
        'LENGUA_IMPUTADO',
        'TIPO_MANDAMIENTO',
        'IMPUTADO_CONOCIDO',
      'AUDIENCIA_DE_GARANTIAS', 
      'PROMOVIDA_POR', 
      'RESULTADO_AUDIENCIA_DE_GARANTIAS', 
      'FECHA_CITA', 
      'PREVIO_A_CAUSA',     
        'MASC',
        'FECHA_DERIVA_MASC',
        'FECHA_CUMPL_MAS',
        'TIPO_CUMPLIMIENTO',
        'TIPO_MASC',
        'AUTORIDAD_DERIVA_MASC',          
    ];
    use HasFactory, SoftDeletes;
}
