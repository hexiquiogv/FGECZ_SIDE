<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_sa_suspensiones extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_sa_suspensiones';

    /**
    * @var array $fillable
    */
    protected $fillable = [
        'id',
        'id_cp_salidasalternas', 
        'FECHA_SUSPENSION',
        'TIPO_SUSPENSION',
        'SUSPENSION_OBSERVACIONES',
        'FECHA_CUMPL',
        'REVOCACION_SUSPENSION',
        'MOTIVO_REVOCACION',
        'REAPERTURA',
        'FECHA_REAPERTURA',
        'usuario'
      ];

    use HasFactory, SoftDeletes;
}
