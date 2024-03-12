<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relusuarioexpedientes extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'relusuarioexpedientes';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'idUsuario',
        'idExpediente',
        'tabla',
        'Activo'];
    
    public $timestamps = false;
    use HasFactory;
}
