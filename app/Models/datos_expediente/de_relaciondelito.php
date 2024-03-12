<?php

namespace App\Models\datos_expediente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class de_relaciondelito extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'prode_relaciondelito';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'idRelacion', 
        'idImputado', 
        'idVictima',
    ];
     ////public $timestamps = false;
    use HasFactory, SoftDeletes;
}
