<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_sa_acuerdos extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_sa_acuerdos';

    /**
    * @var array $fillable
    */
    protected $fillable = [
        'id',
        'id_cp_salidasalternas', 
        'ACUERDO_REPARATORIO',
        'FECHA_CUMPLIMIENTO',
        'FECHA_ACUERDOS_REPARATORIOS',
        'ACUERDOS_REPARATORIOS',
        'ACUERDOS_REPARATORIOS_OBSERVACIONES',
        'MONTO_REP_DAÑO',
        'REPARACION_DEL_DAÑO',
        'TEMPORALIDAD',
        'usuario'
      ];

    use HasFactory, SoftDeletes;
}
