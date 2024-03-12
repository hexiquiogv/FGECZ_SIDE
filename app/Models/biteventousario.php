<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class biteventousario extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'biteventousario';

    /**
     * @var array $fillable
     */
    protected $fillable = [
    'idUsuario',
    'idExpediente',
    'idRegistro',
    'idEvento',
    'Evento'];

    public $timestamps = false;
    use HasFactory;
}
