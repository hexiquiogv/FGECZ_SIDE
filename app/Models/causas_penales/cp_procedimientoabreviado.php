<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_procedimientoabreviado extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_procedimientoabreviado';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'idImputado', 
      'idCausa', 
      'idExpediente', 
      'PROCEDIMIENTO_ABREVIADO', 
      'PENA_CONDENATORIA_EN_ABREVIADO', 
      'NO_ADMISION_DEL_ABREVIADO', 
      'ESTATUS_ABREVIADO',
      'NARRACION_PROCEDIMIENTO',
      // 'ABREVIADO', 
      'CAUSAS_ABREVIADO'
      ];

    use HasFactory, SoftDeletes;
}
