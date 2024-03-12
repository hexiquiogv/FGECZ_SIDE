<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bitbasecaptura extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'bitbasecaptura';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'idExpediente', 
        'tipoExpediente', 
        'idUsuario', 
        'NUC', 
        'DELEGACION', 
        'UNIDAD', 
        'MESA', 
        'RESPONSABLE', 
        'CAPTURA', 
        'PUESTO_CAPTURA', 
        'TIMESTAMP', 
        'NO_EXPEDIENTE'];

    use HasFactory;
}
