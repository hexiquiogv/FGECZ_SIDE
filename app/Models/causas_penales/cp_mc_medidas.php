<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_mc_medidas extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_mc_medidas';

    /**
    * @var array $fillable
    */
    protected $fillable = [
        'id',
        'id_cp_medidascautelares', 
        'MEDIDAS_CAUTELARES', 
        'TIPO_MEDIDAS_CAUTELARES', 
        'TEMPORALIDAD_MEDIDA_D',
        'TEMPORALIDAD_MEDIDA_M',
        'TEMPORALIDAD_MEDIDA_A',
        'RECURRENCIA',
        'MEDIDAS_OBSERVACIONES',
        'usuario'
      ];

    use HasFactory, SoftDeletes;
}
