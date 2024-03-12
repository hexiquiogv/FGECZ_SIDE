<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ev_actosconsin extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ev_actosconsin';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'id_cp_ev_imputados',
      'idImputado',
      'idCausa', 
      'idExpediente',       
      'TIPO_ACTOS_CONSIN',
      'CONSIN', 
      'usuario'
    ];

    use HasFactory, SoftDeletes;
}
