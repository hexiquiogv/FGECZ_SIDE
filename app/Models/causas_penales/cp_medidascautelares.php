<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_medidascautelares extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_medidascautelares';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'idImputado', 
      'idCausa', 
      'idExpediente', 
    ];

    use HasFactory, SoftDeletes;
}
