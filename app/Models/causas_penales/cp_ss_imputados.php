<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ss_imputados extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ss_imputados';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'id_cp_suspensionsobreseimiento',
      'idImputado', 
      'idCausa', 
      'idExpediente', 
      'FECHA_SOBRESEIMIENTO',
      'TIPO_SOBRESEIMIENTO',
      'CAUSAS_SOBRESEIMIENTO',
      'SOBRESEIMIENTO_OBSERVACIONES',      
      ];

    use HasFactory, SoftDeletes;
}
