<?php

namespace App\Models\datos_expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class de_etapainvestigacion extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'prode_etapainvestigacion';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      // 'idImputado', 
      // 'idCausa', 
      'idExpediente', 
    ];

    use HasFactory, SoftDeletes;
}
