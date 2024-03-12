<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ev_victimas extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ev_victimas';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'id_cp_etapainvestigacion',
      'idVictima', 
      'idCausa', 
      'idExpediente',
      'usuario'
    ];

    use HasFactory, SoftDeletes;
}
