<?php

namespace App\Models\carpeta_conduccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cc_victimas extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'procc_victimas';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'idExpediente', 
        'MUNICIPIO_NACIMIENTO', 
        'SITUACION_MIGRATORIA_VICTIMAS_CONDUCCION', 
        'INTERPRETE_VICTIMAS_CONDUCCION', 
        'TIPO_VICTIMA_CONDUCCION', 
        'DELITOS_VICTIMA_CONDUCCION', 
        'RAZON_SOCIAL', 
        'REPRESENTANTE_LEGAL', 
        'SECTOR_VICTIMAS_CONDUCCION', 
        'TIPO_PERSONA_VICTIMAS_CONDUCCION', 
        'PRIMER_APELLIDO', 
        'SEGUNDO_APELLIDO_VICTIMAS_CONDUCCION', 
        'SITUACION_CONYUGAL_VICTIMAS_CONDUCCION', 
        'NACIONALIDAD', 
        'PAIS_NACIMIENTO', 
        'ENTIDAD_NACIMIENTO_VICTIMAS_CONDUCCION', 
        'PAIS_RESIDENCIA', 
        'ENTIDAD_RESIDENCIA_VICTIMAS_CONDUCCION', 
        'MUNICIPIO_RESIDENCIA', 
        'TELEFONO_VICTIMAS_CONDUCCION', 
        'TRADUCTOR_VICTIMAS_CONDUCCION', 
        'POBLACION_CALLE', 
        'LEER_ESCRIBIR', 
        'ESCOLARIDAD', 
        'OCUPACION', 
        'RELACION_IMPUTADO',
        ////////campos agregados 30/06/2023
        'TIPO_REPRESENTANTE_LEGAL',
        'ASESORIA',
        'TIPO_DE_ASESORIA',
        'NOMBRE_VICTIMA',
        'CURP_VICTIMAS',
        'FECHA_NACIMIENTO_VICTIMAS',
        'EDAD_HECHOS_VICTIMAS',
        'SEXO_VICTIMA',
        'DOMICILIO_VICTIMA',
        'INGRESO_VICTIMA',
        'HABLA_ESPAÑOL_VICTIMA',
        'HABLA_LENG_EXTR_VICTIMA',
        'TIPO_LENGUA_EXTRANJERA_VICTIMA',
        'DISCAPACIDAD_VICTIMAS',
        'TIPO_DISCAPACIDAD_VICTIMAS',
        'INTERPRETE_POR_DISCAPACIDAD_VICTIMA',
        'ATEN_MEDICA',
        'ATEN_PSICOLOGICA',
        'SE_IDENTIFICA_INDIGENA_VICTIMA',
        'POBLACION_INDIGENA_VICTIMA',
        'HABLA_LENG_INDIG_VICTIMA',
        'LENGUA_VICTIMA',
        'VICTIMA_VIOLENCIA',
        'VESTIMENTA_VICTIMA',                      
    ];

    use HasFactory, SoftDeletes;
}
