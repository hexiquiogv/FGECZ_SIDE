<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ei_medios extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ei_medios';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'id_cp_etapaintermedia', 
      'idCausa', 
      'idExpediente',       
      'MEDIOS_PRUEBAS', 
      'MEDIOS_PRUEBAS_PE',
      'ACUERDOS_REPARATORIOS',
      'usuario'
    ];

    use HasFactory, SoftDeletes;
}
