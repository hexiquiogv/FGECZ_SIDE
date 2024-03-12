<?php

namespace App\Models\datos_expediente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class de_objetos extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'prode_objetos';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'idExpediente',
        'OBJETO_1', 'DESC_OBJ_1', 'CANT_OBJ_1', 'VALOR_OBJ_1', 'ESTATUS_OBJ_1',
        'OBJETO_2', 'DESC_OBJ_2', 'CANT_OBJ_2', 'VALOR_OBJ_2', 'ESTATUS_OBJ_2',
        'OBJETO_3', 'DESC_OBJ_3', 'CANT_OBJ_3', 'VALOR_OBJ_3', 'ESTATUS_OBJ_3',
        'TIPO_NARCOTICO_1', 'PRESENTACION_NARCO_1', 'CANTIDAD_NARCO_1', 'GRAMAJE_NARCO_1',
        'TIPO_NARCOTICO_2', 'PRESENTACION_NARCO_2', 'CANTIDAD_NARCO_2', 'GRAMAJE_NARCO_2',
        'TIPO_NARCOTICO_3', 'PRESENTACION_NARCO_3', 'CANTIDAD_NARCO_3', 'GRAMAJE_NARCO_3',
        'ESTATUS', 'FECHA_ASEGURADO', 'FECHA_DEVUELTO', 'FECHA_ROBADO', 'MARCA', 'MODELO', 'COLOR', 'TIPO', 'PLACA', 'NUMERO', 'ESTADO_PLACAS','LUGAR_VEHICULO'
    ];
     ////public $timestamps = false;
    use HasFactory, SoftDeletes;
}
