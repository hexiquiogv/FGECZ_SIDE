<?php

namespace App\Models\datos_expediente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class de_hechos extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'prode_hechos';

    /**
     * @var array $fillable
     */
    protected $fillable = [
    'idExpediente',
    'DELITO', 
    'DELITO_JUR',
    'CONSUMACION', 
    'MODALIDAD', 
    'INSTRUMENTO', 
    'FUERO', 
    'TIPO_SITIO_OCURRENCIA', 
    'CALIFICACION', 
    'COMISION', 
    'CONTEXTO', 
    'FORMA_ACCION'];
    use HasFactory, SoftDeletes;
}
