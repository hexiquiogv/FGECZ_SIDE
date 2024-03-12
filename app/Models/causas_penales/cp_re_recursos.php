<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_re_recursos extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_re_recursos';

    /**
    * @var array $fillable
    */
    protected $fillable = [
        'id',
        'id_cp_recursos', 
        'FECHA_RECURSO', 
        'TIPO_DE_RECURSO', 
        'RESOLUCION_DEL_RECURSO',
        'usuario'
      ];

    use HasFactory, SoftDeletes;
}
