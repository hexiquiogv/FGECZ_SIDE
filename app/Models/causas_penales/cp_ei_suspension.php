<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ei_suspension extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'bitcp_ei_suspension';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'idCausa', 
      'idExpediente', 
      'idImputado',      
      'SUSPENSION_DE_AUDIENCIA',
      'CAUSAS_SUSPENSION_INTERMEDIA',
      'FECHA_DE_REANUDACION_INTERMEDIA',
    ];

    use HasFactory, SoftDeletes;
}
