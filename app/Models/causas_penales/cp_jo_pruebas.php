<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_jo_pruebas extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_jo_pruebas';

    /**
    * @var array $fillable
    */
    protected $fillable = [
        'id',
        'id_cp_juiciooral', 
        'idCausa', 
        'idExpediente',
        'idImputado', 
        'TIPOS_DE_PRUEBAS', 
        'ACTOR_PRUEBAS', 
        'FECHA_PRUEBAS',
        'CANTIDAD',
        'usuario'
      ];

    use HasFactory, SoftDeletes;
}
