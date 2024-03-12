<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ai_vinculaciones extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ai_vinculaciones';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'idcp_audienciainicial',
      'idcp_ai_imputados', 
      'idCausa', 
      'idExpediente', 
      'idImputado',
      'RESOLUCION', 
      'FECHA_RESOL', 
      'DELITO_VINCULO',      
    ];

    use HasFactory;
}
