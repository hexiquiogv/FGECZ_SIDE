<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_juiciooral extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_juiciooral';

    /**
    * @var array $fillable
    */
    protected $fillable = [
        // 'idImputado', 
        'idCausa', 
        'idExpediente', 
        // 'JUICIO_ORAL', 
        // 'AUTO_DE_APERTURA', 
        // 'FECHA_AUDIENCIA_JUICIO', 
        // 'SUSPENSION_JUICIO', 
        // 'CAUSAS_SUSPENSION', 
        // 'FECHA_SENTENCIA', 
        // 'TIPO_SENTENCIA', 
        // 'OBSERVACIONES',
        // 'SENTENCIA_CONDENATORIA', 
        // 'FIRME', 
        // 'TIEMPO', 
        // 'FECHA_PROCED_ABREV', 
        // 'FECHA_RECURSO', 
        // 'TIPO_DE_RECURSO', 
        // 'RESOLUCION_DEL_RECURSO'
      ];

    use HasFactory, SoftDeletes;
}
