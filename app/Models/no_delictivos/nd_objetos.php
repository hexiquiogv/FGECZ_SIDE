<?php

namespace App\Models\no_delictivos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class nd_objetos extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'prond_objetos';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'idExpediente', 
        'OBJETO_1', 
        'DESC_OBJ_1', 
        'CANT_OBJ_1', 
        'VALOR_OBJ_1', 
        'ESTATUS_OBJ_1',

        'OBJETO_2', 
        'DESC_OBJ_2', 
        'CANT_OBJ_2', 
        'VALOR_OBJ_2', 
        'ESTATUS_OBJ_2',

        'OBJETO_3', 
        'DESC_OBJ_3', 
        'CANT_OBJ_3', 
        'VALOR_OBJ_3', 
        'ESTATUS_OBJ_3',

        'TIPO_NARCOTICO_1',
        'PRESENTACION_NARCO_1',
        'CANTIDAD_NARCO_1',
        'GRAMAJE_NARCO_1',
        'TIPO_NARCOTICO_2',
        'PRESENTACION_NARCO_2',
        'CANTIDAD_NARCO_2',
        'GRAMAJE_NARCO_2',
        'TIPO_NARCOTICO_3',
        'PRESENTACION_NARCO_3',
        'CANTIDAD_NARCO_3',
        'GRAMAJE_NARCO_3',

        'ESTATUS_NO_DELICTIVOS', 'FECHA_ASEGURADO', 'FECHA_DEVUELTO', 'FECHA_ROBADO',
        'MARCA_NO_DELICTIVOS', 
        'MODELO_NO_DELICTIVOS', 
        'COLOR_NO_DELICTIVOS', 
        'TIPO_NO_DELICTIVOS', 
        'PLACA_NO_DELICTIVOS', 
        'NUMERO_NO_DELICTIVOS', 
        'ESTADO_PLACAS_NO_DELICTIVOS',
        'LUGAR_VEHICULO_NO_DELICTIVOS'
    ];
     ////public $timestamps = false;
    use HasFactory, SoftDeletes;
}
