<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_dg_imputados extends Model
{
    /**
    *  @var string $table
    */
    protected $table = 'procp_dg_imputados';

    /**
    * @var array $fillable
    */
    protected $fillable = [
        'idCausa', 
        'idImputado', 
        'FORMA_PROCESO', 
        // 'FECHA_MANDAMIENTO', 
        // 'ESTATUS_MANDAMIENTO', 
        // 'FECHA_LIBERA', 
        'FORMA_',
        'DETENCION_LEGAL_ILEGAL',
        'OBSERVACIONES_ILEGAL',
        'MASC', 
        'FECHA_DERIVA_MASC', 
        'FECHA_CUMPL_MAS', 
        'TIPO_CUMPLIMIENTO', 
        'TIPO_MASC', 
        'AUTORIDAD_DERIVA_MASC',
        'usuario',
        'cp_dg', 'cp_ev', 'cp_ai', 'cp_pa', 'cp_ei', 'cp_jo',
    ];
    use HasFactory, SoftDeletes;
}
