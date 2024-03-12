<?php

namespace App\Models\no_delictivos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class nd_datosgenerales extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'prond_datosgenerales';

    /**
     * @var array $fillable
     */
    protected $fillable = [
           'DELEGACION',
           'MUNICIPIO',
           'UNIDAD_ATENCION_NO_DELICTIVOS',
           'FECHA_INICIO',
           'FECHA_HECHOS_NO_DELICTIVOS',
           'HORA_HECHOS',
           'NO_EXPEDIENTE',
           'RECIBIDA_POR',
           'ENTIDAD_HECHOS_NO_DELICTIVOS',
           'MUNICIPIO_HECHOS',
           'COLONIA_HECHOS',
           // 'UNIDAD_QUE_RECIBE',           
           'CALLE_HECHOS_NO_DELICTIVOS', 
           'CP', 
           'REF_1', 
           'REF_2', 
           'HECHO_NO_DELITO', 
            'CAUSA_MUERTE',
            'MOTIVO',
            'MEDIO_UTILIZADO',

           'DESCRIPCION', 
           'OBSERVACIONES',
    ];

    use HasFactory, SoftDeletes;
}
