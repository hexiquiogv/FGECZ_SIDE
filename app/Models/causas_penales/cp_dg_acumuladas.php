<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_dg_acumuladas extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_dg_acumuladas';

    /**
    * @var array $fillable
    */
    protected $fillable = [
        'idCausa',
        'idCausaRel',
        'usuario'
    ];
    use HasFactory, SoftDeletes;
}
