<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_jo_imputados extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_jo_imputados';

    /**
    * @var array $fillable
    */
    protected $fillable = [
        'idImputado', 
        'idCausa', 
        'idExpediente', 
        'FECHA_SENTENCIA', 
        'LIBERTAD_CONDICIONAL',
        'TIPO_SENTENCIA', 
        'OBSERVACIONES',
        'SENTENCIA_CONDENATORIA', 
        'FIRME', 
        'TIEMPO', 
        // 'FECHA_PROCED_ABREV', 
      ];

    use HasFactory, SoftDeletes;
}
