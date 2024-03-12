<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_jo_suspension extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_jo_suspension';

    /**
    * @var array $fillable
    */
    protected $fillable = [
        'id',
        'id_cp_juiciooral', 
        'idCausa', 
        'idExpediente', 
        'idImputado',        
        // 'SUSPENSION_JUICIO', 
        'FECHA_SUSPENSION',
        'CAUSAS_SUSPENSION',
        'REANUDACION_JUICIO', 
        'usuario'
      ];

    use HasFactory, SoftDeletes;
}
