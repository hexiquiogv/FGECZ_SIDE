<?php

namespace App\Models\carpeta_conduccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cc_datosgenerales extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'procc_datosgenerales';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'DELEGACION',                 
        'MUNICIPIO', 
        'UNIDAD_ATENCION', 
        'FECHA_INICIO_CONDUCCION', 
        'FECHA_HECHOS_CONDUCCION', 
        'HORA_HECHOS', 
        'NO_EXPEDIENTE_CONDUCCION', 
        'ENTIDAD_HECHOS_CONDUCCION', 
        'MUNICIPIO_HECHOS', 
        'COLONIA_HECHOS', 
        'CALLE_HECHOS_CONDUCCION', 
        'CP', 
        'REF_1', 
        'REF_2', 
        'UNIDAD_QUE_RECIBE_CONDUCCION', 
        'RECIBIDA_POR', 
        'TIPO_RECEPCION', 
        'DESCRIPCION', 
        'OBSERVACIONES',
        'AUTORIDAD_IPH'
    ];
     ////public $timestamps = false;
    use HasFactory, SoftDeletes;
}
