<?php

namespace App\Models\carpeta_conduccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cc_imputados extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'procc_imputados';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'idExpediente', 
        'MUNICIPIO_NACIMIENTO', 
        'TIPO_IMPUTADO_CONDUCCION', 
        'RAZON_SOCIAL', 
        'SECTOR_IMPUTADOS_CONDUCCION', 
        'TIPO_PERSONA_IMPUTADOS_CONDUCCION', 
        'DELITOS_IMPUTADO_CONDUCCION', 
        'RELACION_VICTIMA', 
        'PRIMER_APELLIDO', 
        'SEGUNDO_APELLIDO_IMPUTADOS_CONDUCCION', 
        'SITUACION_CONYUGAL_IMPUTADOS_CONDUCCION', 
        'NACIONALIDAD', 
        'SITUACION_MIGRATORIA_IMPUTADOS_CONDUCCION', 
        'PAIS_NACIMIENTO', 
        'ENTIDAD_NACIMIENTO_IMPUTADOS_CONDUCCION', 
        'PAIS_RESIDENCIA', 
        'ENTIDAD_RESIDENCIA_IMPUTADOS_CONDUCCION', 
        'MUNICIPIO_RESIDENCIA', 
        'TELEFONO_IMPUTADOS_CONDUCCION', 
        'TRADUCTOR_IMPUTADOS_CONDUCCION', 
        'POBLACION_CALLE', 
        'LEER_ESCRIBIR_IMPUTADOS', 
        'DETENIDO_IMPUTADOS_CONDUCCION', 
        'ESTADO_IMPUTADO_CONDUCCION', 
        'FECHA_DETENCION_CONDUCCION', 
        'HORA_DETENCION', 
        'TIPO_DETENCION_IMPUTADOS_CONDUCCION', 
        'ENTIDAD_DETENCION_IMPUTADOS_CONDUCCION', 
        'AUTORIDAD_DETENCION_IMPUTADOS_CONDUCCION', 
        'FOLIO_RND', 
        'RAZON_RND', 
        'EXAMEN_DETENCION_IMPUTADOS_CONDUCCION', 
        'LESIONADO', 
        'ESTADO_PRESENTACION', 
        'REPRESENTANTE_LEGAL', 
        'INTERPRETE_IMPUTADOS_CONDUCCION',
        ////////campos agregados 30/06/2023
          'TIPO_REPRESENTANTE_LEGAL',
          'REL_PERS_MORAL',
          'ALIAS_IMPUTADO',
          'IMPUTADO_CONOCIDO',    
          'NOMBRE_IMPUTADO',
          'CURP_IMPUTADOS',
          'FECHA_NACIMIENTO_IMPUTADOS',
          'EDAD_HECHOS_IMPUTADOS',       
          'SEXO_IMPUTADO',
          'DOMICILIO_IMPUTADO',
          'INGRESO_IMPUTADO',
          'HABLA_ESPAÑOL_IMPUTADO',
          'HABLA_LENG_EXTR_IMPUTADO',
          'TIPO_LENGUA_EXTRANJERA_IMPUTADO',
          'DISCAPACIDAD_IMPUTADOS',
          'TIPO_DISCAPACIDAD_IMPUTADOS',
          'INTERPRETE_POR_DISCAPACIDAD_IMPUTADO',
          'ESCOLARIDAD_IMPUTADO',
          'OCUPACION_IMPUTADO',
          'SE_IDENTIFICA_INDIGENA_IMPUTADO',
          'INDIGENA_IMPUTADO',
          'HABLA_LENG_INDIG_IMPUTADO',
          'LENGUA_IMPUTADO',
          'NOMBRE_DE_GRUPO',                    
          'ANTECEDENTES',
          'DEFENSA',
          'TIPO_DEFENSA',
          'MEDIA_FILIACION_IMPUTADO',
          'TIPO_MANDAMIENTO',
          'GRADO_DE_PARTICIPACION'      
    ];

    use HasFactory, SoftDeletes;
}
