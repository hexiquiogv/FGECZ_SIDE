<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ai_prorrogas extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ai_prorrogas';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'id_cp_audienciainicial', 
      'idCausa', 
      'idExpediente',     
      'idImputado',  
      'PRORROGA',
      'TEMPORALIDAD_PRORROGA', 
      'usuario'
    ];

    use HasFactory, SoftDeletes;
}
