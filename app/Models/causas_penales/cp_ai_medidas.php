<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ai_medidas extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ai_medidas';

    /**
    * @var array $fillable
    */
    protected $fillable = [
        'id',
        'id_cp_ai_imputados', 
        'MEDIDAS_CAUTELARES', 
        'TIPO_MEDIDAS_CAUTELARES', 
        'TEMPORALIDAD_MEDIDA',
        'usuario'
      ];

    use HasFactory, SoftDeletes;
}
