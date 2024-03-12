<?php

namespace App\Models\datos_expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class bitde_relaciondelito extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'bitde_relaciondelito';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'idExpediente', 
        'Usuario', 
        'idDelito',
    ];
     ////public $timestamps = false;
    use HasFactory, SoftDeletes;
}
