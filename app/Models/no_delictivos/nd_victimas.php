<?php

namespace App\Models\no_delictivos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class nd_victimas extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'prond_victimas';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'idExpediente', 
        'TIPO_VICTIMA_NO_DELICTIVO', 
        'PRIMER_APELLIDO', 
        'SEGUNDO_APELLIDO_VICTIMAS_NO_DELICTIVO', 
        'SEXO',
        'SIT_CONYUGAL_VICTIMAS_NO_DELICTIVO',
        'ESCOLARIDAD',
        'OCUPACION',
        'FECHA_NACIMIENTO',
        'OCCISO',
        'NOMBRE_VICTIMA',
        'EDAD_HECHOS_VICTIMAS',
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
