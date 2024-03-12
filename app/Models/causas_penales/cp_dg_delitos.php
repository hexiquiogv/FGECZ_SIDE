<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_dg_delitos extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_dg_delitos';

    /**
    * @var array $fillable
    */
    protected $fillable = [
        'idCausa', 
        'idDelito', 
        'RECLASIFICACION', 
        'MOMENTO_RECLAS',
        'FECHA_RECLAS',
        'DELITO_DE_ACUERDO_CON_LEY', 
        'usuario'
    ];
    use HasFactory, SoftDeletes;
}