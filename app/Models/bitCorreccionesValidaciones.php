<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bitCorreccionesValidaciones extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'bitcorreccionesvalidaciones';

    /**
     * @var array $fillable
     */
    protected $fillable = [
    'idUsuario',
    'idExpediente',
    'tabla',
    'Validacion',
    'Correccion',
    'Observaciones',
    'Activo'];

    use HasFactory;
}
