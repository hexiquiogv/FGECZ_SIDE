<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ev_mandamientos extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ev_mandamientos';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'id_cp_ev_imputados',
      'idImputado', 
      'idCausa', 
      'idExpediente',       
      'TIPO_MANDAMIENTO',       
      'SOLICITUD_DE_MANDAMIENTO_JUDICIAL', 
      'ESTATUS_MANDAMIENTO',
      'FECHA_LIBERA',
      'FECHA_MANDAMIENTO',
      'usuario'
    ];

    use HasFactory, SoftDeletes;
}
