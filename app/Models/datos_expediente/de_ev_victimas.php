<?php

namespace App\Models\datos_expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class de_ev_victimas extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'prode_ev_victimas';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'id_de_etapainvestigacion',
      'idVictima', 
      // 'idCausa', 
      'idExpediente',
      'usuario'
    ];

    use HasFactory, SoftDeletes;
}
