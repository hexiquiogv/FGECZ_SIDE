<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_suspensionsobreseimiento extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_suspensionsobreseimiento';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      // 'idImputado', 
      'idCausa', 
      'idExpediente', 
      // 'FECHA_SOBRESEIMIENTO',
      // 'TIPO_SOBRESEIMIENTO',
      // 'CAUSAS_SOBRESEIMIENTO',
      // 'SOBRESEIMIENTO_OBSERVACIONES',
      'FECHA_SUSPENSION',
      'CAUSA_PROCESO',
      'REAPERTURA_PROCESO',
      'FECHA_DE_REANUDACION',
      ];

    use HasFactory, SoftDeletes;
}
