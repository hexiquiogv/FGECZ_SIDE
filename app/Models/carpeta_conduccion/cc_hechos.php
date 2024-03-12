<?php

namespace App\Models\carpeta_conduccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cc_hechos extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'procc_hechos';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'idExpediente', 
        'CONSUMACION', 
        'MODALIDAD', 
        'INSTRUMENTO_CONDUCCION', 
        'TIPO_SITIO_OCURRENCIA_CONDUCCION', 
        'COMISION_CONDUCCION', 
        'DELITO', 'DELITO_JUR', 
        'FUERO_CONDUCCION', 
        'CALIFICACION_CONDUCCION'        
    ];

    use HasFactory, SoftDeletes;
}
