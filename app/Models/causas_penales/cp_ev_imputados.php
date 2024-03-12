<?php

namespace App\Models\causas_penales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class cp_ev_imputados extends Model
{
    /**
    * @var string $table
    */
    protected $table = 'procp_ev_imputados';

    /**
    * @var array $fillable
    */
    protected $fillable = [
      'id_cp_etapainvestigacion',        
      'idImputado', 
      'idCausa', 
      'idExpediente',       
      'AUDIENCIA_DE_GARANTIAS', 
      'PROMOVIDA_POR', 
      'RESULTADO_AUDIENCIA_DE_GARANTIAS', 
      'FECHA_CITA', 
      'SOLICITUD_DE_ORDEN_DE_APREHENSION', 
      'OA_SIN_EFECTO', 
      'OA_NEGADA', 
      'OA_CUMPLIDA', 
      'ORDEN_DE_COMPARECENCIA_GIRADA', 
      'ORDEN_DE_COMPARECENCIA_NEGADA',
      'FORMA_PROCESO',
      'FECHA_DETENCION',  
      'DETENCION_LEGAL',
      'CASO_URGENTE_FECHA_LIBRAMIENTO',
      'CASO_URGENTE_ESTATUS',
      'CASO_URGENTE_FECHA_CUMPLIMIENTO',      
      'SOLICITUD_DE_MANDAMIENTO_JUDICIAL',
      'TIPO_MANDAMIENTO',
      'FECHA_LIBERA',
      'ESTATUS_MANDAMIENTO',
      'FECHA_MANDAMIENTO',
      'bitFlagrancia',
      'bitMandamientos',
      'bitAudiencia',
      'bitCasoUrgente',
      'usuario'
    ];

    use HasFactory, SoftDeletes;
}

