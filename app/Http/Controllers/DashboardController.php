<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\biteventousario;
use App\Models\relusuarioexpedientes;
use App\Models\bitCorreccionesValidaciones;
use App\Models\bitbasecaptura;

use App\Models\datos_expediente;
use App\Models\causas_penales;
use App\Models\carpeta_conduccion;
use App\Models\no_delictivos;


class DashboardController extends Controller
{
    
    public function SolcitarRevision(Request $request)
    {      
      $upd=bitCorreccionesValidaciones::where(['idExpediente'=>$request->idExpCorr,'tabla'=>$request->tablaCorr,'Correccion'=>1])->update(['Activo'=>0]);
      //$upd->save();
      $tabla=0;
      switch ($request->tablaCorr) {
        case 'prode_datosgenerales':
            $tabla=1;
          break;
        case 'procc_datosgenerales':
            $tabla=2;
          break;
        case 'prond_datosgenerales':
            $tabla=3;
          break;          
      }
      $bitEvUsu=biteventousario::create(
      ['idUsuario' => Auth::User()->id,
      'idExpediente' => $request->idExpCorr,
      'idRegistro' => $tabla,
      'idEvento' => 71,
      'Evento' =>'petición de revisión de Expediente de '.$request->tablaCorr]);
      return back();
    }

    public function GuardarCP(Request $request)
    {
      if(is_null(Auth::User())) { return redirect("Salir"); }
      else
      {
        foreach ($request->except(['_token','Ctrl','idExp']) as $key => $value) {
             if (is_string($value)) {
               $request[$key]=strtoupper($value);
             }             
         }
        $routeid = 0;
        $idExp=hex2bin($request->idExp);
        $idCausa=hex2bin($request->idCausa); 
        
        switch ($request->Ctrl) {
           case 'od0'://////LISTADO CAUSAS PENALES
           case 'd0'://////CAUSAS PENALES
             if ($idCausa==0) {
              $request->validate(['causa_H_causa_penal_id'         =>   'required|unique:procp_datosgenerales,CAUSA_PENAL_ID',],
              [ 'causa_H_causa_penal_id.required'=>'el número de causa es requerido','causa_H_causa_penal_id.unique'=>'El número de causa penal ya fue registrado']);
             }
             else
             {
              $countCP=causas_penales\cp_datosgenerales::where('CAUSA_PENAL_ID','=',$request->causa_H_causa_penal_id)
              ->Where('id','!=', $idCausa)->count();            
              if ($countCP>0) {
                $request->validate(['causa_H_causa_penal_id'         =>   'required|unique:procp_datosgenerales,CAUSA_PENAL_ID',],
                [ 'causa_H_causa_penal_id.required'=>'el número de causa es requerido','causa_H_causa_penal_id.unique'=>'El número de causa penal ya fue registrado']);
              }
              else
              {
                $request->validate(['causa_H_causa_penal_id'         =>   'required',],
                [ 'causa_H_causa_penal_id.required'=>'el número de causa es requerido']);
              }
             }
            $post = causas_penales\cp_datosgenerales::updateOrCreate(['id' => $idCausa],
                ['idExpediente'=>$idExp,
                'CAUSA_PENAL_ID'=>$request->causa_H_causa_penal_id, 
                'FECHA_CAUSA_PENAL'=>$request->causa_H_fecha_causa_penal, 
                  // 'FECHA_INICIO_ATENCION'=>$request->causa_H_fecha_inicio_atencion, 
                  // 'FECHA_CONCLUSION_ATENCION'=>$request->causa_H_fecha_conclusion_atencion, 
                  // 'TIPO_DE_ATENCION'=>$request->causa_H_tipo_de_atencion, 
                  // 'SENTIDO'=>$request->causa_H_sentido, 
                  // 'FECHA_DETERMINACION'=>$request->causa_H_fecha_determinacion, 
                  // 'SENTIDO_DETERMINACION'=>$request->causa_H_sentido_determinacion, 
                'UNIDAD_DE_INVESTIGACION'=>$request->causa_H_unidad_de_investigacion, 
                'DISTRITO_JUDICIAL'=>$request->causa_H_distrito_judicial,
                  // 'DETENCION_LEGAL_ILEGAL'=>$request->causa_H_detencion_legal_ilegal, 
                  // 'MASC'=>$request->causa_H_masc, 
                  // 'FECHA_DERIVA_MASC'=>$request->causa_H_fecha_deriva_masc, 
                  // 'FECHA_CUMPL_MAS'=>$request->causa_H_fecha_cumpl_mas, 
                  // 'TIPO_CUMPLIMIENTO'=>$request->causa_H_tipo_cumplimiento, 
                  // 'TIPO_MASC'=>$request->causa_H_tipo_masc, 
                  // 'AUTORIDAD_DERIVA_MASC'=>$request->causa_H_autoridad_deriva_masc, 
                  // 'TIPOS_DE_ACTOS_CON_CONTROL'=>$request->causa_H_tipos_de_actos_con_control, 
                  // 'TIPOS_DE_ACTOS_SIN_CONTROL'=>$request->causa_H_tipos_de_actos_sin_control, 
                  // 'REAPERTURA'=>$request->causa_H_reapertura, 
                  // 'FECHA_REAPERTURA_'=>$request->causa_H_fecha_reapertura, 
                  // 'MOMENTO_RECLAS'=>$request->causa_H_momento_reclas, 
                  // 'FECHA_RECLAS'=>$request->causa_H_fecha_reclas, 
                'OBSERVACIONES'=>$request->causa_H_observaciones ]);

            $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $idExp,
                'idRegistro' => $post->id,
                'idEvento' => $post->wasRecentlyCreated ?13:14,
                'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Datos Genrales':'Actualizar Causa Penal - Datos Genrales']);

            if (strlen($request->hdnacumulado)>0) {
              foreach (explode(",",$request->hdnacumulado??'') as $key => $value) {
                $acumuladosCP=causas_penales\cp_dg_acumuladas::updateOrCreate(
                  ['idCausa' => $post->id,
                  'idCausaRel' => $value],
                  ['usuario'=>Auth::User()->id,]);
                $acumuladosCP=causas_penales\cp_dg_acumuladas::updateOrCreate(
                  ['idCausa' => $value,
                  'idCausaRel' => $post->id],
                  ['usuario'=>Auth::User()->id]);
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $post->id,
                  'idEvento' => $acumuladosCP->wasRecentlyCreated ?15:16,
                  'Evento' => $acumuladosCP->wasRecentlyCreated ?'Insertar Causas Penales Acumuladas':'Actualizar Causas Penales Acumuladas']);
              }
            }
            if (strlen($request->hdnVictimasCP)>0) {
              foreach (explode(",",$request->hdnVictimasCP) as $key => $value) {
                $victimasCP=causas_penales\cp_dg_victimas::updateOrCreate(['idCausa'=>$post->id, 'idVictima'=>$value ],
                  ['usuario'=>Auth::User()->id]);
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $victimasCP->id,
                  'idEvento' => $victimasCP->wasRecentlyCreated ?17:18,
                  'Evento' => $victimasCP->wasRecentlyCreated ?'Insertar Vícitma de Causa Penal':'Actualizar Vícitma de Causa Penal']);
              }
            }
            if (strlen($request->hdnDelitosCP)>0) {
              foreach (json_decode("[".rtrim($request->hdnDelitosCP,",")."]",true) as $key => $value) {
                $delitosCP=causas_penales\cp_dg_delitos::updateOrCreate(['idCausa'=>$post->id, 'idDelito'=>$value['IDDELITO']??'' ],
                  ['RECLASIFICACION'=>$value['RECLAS']??'', 
                  'MOMENTO_RECLAS'=>$value['MOMENTO']??'',
                  'FECHA_RECLAS'=>$value['FECHA']??'',
                  'DELITO_DE_ACUERDO_CON_LEY'=>$value['DELITORECLAS']??'', 
                  'usuario'=>Auth::User()->id]);
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $delitosCP->id,
                  'idEvento' => $delitosCP->wasRecentlyCreated ?19:20,
                  'Evento' => $delitosCP->wasRecentlyCreated ?'Insertar Delito de Causa Penal':'Actualizar Delito de Causa Penal']);
              }
            }

            if (strlen($request->hdnImputadosCP)>0) {
              foreach (json_decode("[".rtrim($request->hdnImputadosCP,",")."]",true) as $key => $value) {              
                $imputadosCP=causas_penales\cp_dg_imputados::create(['idCausa'=>$post->id, 
                  'idImputado'=>$value['IMPUTADO'],
                    // 'FORMA_PROCESO' => $value['FORMA']??'', 
                    // 'FECHA_MANDAMIENTO' => $value['FECHAM']??'',  
                    // 'ESTATUS_MANDAMIENTO' => $value['ESTATUS']??'', 
                    // 'FECHA_LIBERA' => $value['FECHAL']??'', 
                  'FORMA_' => $value['FORMA'],
                  'DETENCION_LEGAL_ILEGAL' => $value['DETENCION'],
                  'OBSERVACIONES_ILEGAL' => $value['OBSERVACIONES'],
                  'FORMA_PROCESO' => $value['FORMAPROCESO'],                  
                  'MASC'=>strlen(preg_replace('/MASC1/i', '',preg_replace('/__\d+__/i', '', $value['MASC1']))) < 1 ? -1:preg_replace('/MASC1/i', '',preg_replace('/__\d+__/i', '', $value['MASC1'])),
                  'FECHA_DERIVA_MASC'=>strlen(preg_replace('/MASC2/i', '',preg_replace('/__\d+__/i', '', $value['MASC2']))) < 1 ? null:
                  preg_replace('/MASC2/i', '',preg_replace('/__\d+__/i', '', $value['MASC2'])),
                  'FECHA_CUMPL_MAS'=>strlen(preg_replace('/MASC3/i', '',preg_replace('/__\d+__/i', '', $value['MASC3']))) < 1 ? null:
                  preg_replace('/MASC3/i', '',preg_replace('/__\d+__/i', '', $value['MASC3'])),
                  'TIPO_CUMPLIMIENTO'=>strlen(preg_replace('/MASC4/i', '',preg_replace('/__\d+__/i', '', $value['MASC4']))) < 1 ? -1:preg_replace('/MASC4/i', '',preg_replace('/__\d+__/i', '', $value['MASC4'])),
                  'TIPO_MASC'=>strlen(preg_replace('/MASC5/i', '',preg_replace('/__\d+__/i', '', $value['MASC5']))) < 1 ? -1:preg_replace('/MASC5/i', '',preg_replace('/__\d+__/i', '', $value['MASC5'])),
                  'AUTORIDAD_DERIVA_MASC'=>strlen(preg_replace('/MASC6/i', '',preg_replace('/__\d+__/i', '', $value['MASC6']))) < 1 ? -1:preg_replace('/MASC6/i', '',preg_replace('/__\d+__/i', '', $value['MASC6'])),
                  'usuario'=>Auth::User()->id]);
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $imputadosCP->id,
                  'idEvento' => 21,
                  'Evento' => 'Insertar Imputado de Causa Penal']);

                  // 'idEvento' => $imputadosCP->wasRecentlyCreated ?21:22,
                  // 'Evento' => $imputadosCP->wasRecentlyCreated ?'Insertar Imputado de Causa Penal':'Actualizar Imputado de Causa Penal']);
                foreach (explode(",",$value['VICTIMAS']??'') as $keyV => $valueV) {
                  foreach (explode(",",$value['DELITOS']??'') as $keyD => $valueD) {
                    $relacionCP = causas_penales\cp_dg_relacionimputado::updateOrCreate(['idcp_dg_imputados' => $imputadosCP->id, 'idDelito'=>$valueD, 'idVictima'=>$valueV],
                      ['usuario'=>Auth::User()->id]);
                    $bitEvUsu=biteventousario::create(
                      ['idUsuario' => Auth::User()->id,
                      'idExpediente' => $idExp,
                      'idRegistro' => $relacionCP->id,
                      'idEvento' => $relacionCP->wasRecentlyCreated ?23:24,
                      'Evento' => $relacionCP->wasRecentlyCreated ?'Insertar Relación de Imputado de CP':'Actualizar Relación de Imputado de CP']);
                  }
                }
              }
            }
            $routeid=$post->id;
           break;
           case 'd0ev'://////CAUSAS PENALES ETAPA INVESTIGACIÓN           
            if (!isset($request->idImputadoEN) && !isset($request->idVictimaEN)) {
              $post = causas_penales\cp_etapainvestigacion::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp],);
              $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $idExp,
                'idRegistro' => $post->id,
                'idEvento' => $post->wasRecentlyCreated ?34:35,
                'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Etapa Investigación':'Actualizar Causa Penal - Etapa Investigacion']);
              
              if (strlen($request['hdnActos'])>0) {
                foreach (json_decode("[".rtrim($request['hdnActos'],",")."]",true) as $key => $value) {
                  $actosEV=causas_penales\cp_ev_actos::create(
                    ['id_cp_etapainvestigacion'=>$post->id,
                    'idCausa'=>$idCausa,
                    'idExpediente'=>$idExp,
                    'FECHA_ACTOS_DE_INV'=>$value['FECHA']??'',
                    'TIPO_CONTROL_ACTOS_DE_INV'=>$value['CONTROL']??'',
                    'TIPO_ACTOS_DE_INV'=>$value['TIPO']??'',
                    'OBSERVACIONES_ACTOS_DE_INV'=>$value['OBSERVACION']??'',
                    'usuario'=>Auth::User()->id]);
                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $idExp,
                    'idRegistro' => $actosEV->id,
                    'idEvento' =>98,
                    'Evento' => 'Insertar actos de investigación en Etapa investigación']);
                }
              }
              $routeid=$idCausa;
            }
            else
            {
              $post = causas_penales\cp_etapainvestigacion::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp],);
              $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $idExp,
                'idRegistro' => $post->id,
                'idEvento' => $post->wasRecentlyCreated ?34:35,
                'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Etapa Investigación':'Actualizar Causa Penal - Etapa Investigacion']);

              if (isset($request->idImputadoEN)) {
                $cp_en=causas_penales\cp_etapainvestigacion::where('idCausa',$idCausa)->first();
                if (isset($cp_en)) {
                  switch ($request->frmSecc) {
                    case 'F':
                      $post=causas_penales\cp_ev_imputados::updateOrCreate(['id'=>$request->idImputadoEN],
                        ['id_cp_etapainvestigacion'=>$cp_en->id,
                        'idImputado'=>$request->idImputado,
                        'idCausa'=>$idCausa,
                        'idExpediente'=>$idExp,
                        
                        'FECHA_DETENCION'=>$request->causa_H_fecha_detencion,  
                        'DETENCION_LEGAL'=>$request->causa_H_detencion_legal,
                        'bitFlagrancia'=>1,
                        'usuario'=>Auth::User()->id,                 
                        ]);
                      break;
                    case 'M':
                      $post=causas_penales\cp_ev_imputados::updateOrCreate(['id'=>$request->idImputadoEN],
                        ['id_cp_etapainvestigacion'=>$cp_en->id,
                        'idImputado'=>$request->idImputado,
                        'idCausa'=>$idCausa,
                        'idExpediente'=>$idExp,
                          // 'SOLICITUD_DE_MANDAMIENTO_JUDICIAL'=>$request->causa_H_solicitud_de_mandamiento_judicial,
                          // 'TIPO_MANDAMIENTO'=>$request->causa_H_tipo_mandamiento,
                          // 'FECHA_LIBERA'=>$request->causa_H_fecha_libera,
                          // 'ESTATUS_MANDAMIENTO'=>$request->causa_H_estatus_mandamiento,
                          // 'FECHA_MANDAMIENTO'=>$request->causa_H_fecha_mandamiento,
                        'bitMandamientos'=>1,
                        'usuario'=>Auth::User()->id,                 
                        ]);
                        
                        if (strlen($request['hdnMandamientos'.$request->idImputadoEN])>0) {
                          foreach (json_decode("[".rtrim($request['hdnMandamientos'.$request->idImputadoEN],",")."]",true)
                          as $key => $value){                      
                            $medidasAI=causas_penales\cp_ev_mandamientos::create(
                              ['id_cp_ev_imputados'=>$post->id,
                              'idImputado'=>$request->idImputado,
                              'idCausa'=>$idCausa,
                              'idExpediente'=>$idExp,

                              'SOLICITUD_DE_MANDAMIENTO_JUDICIAL'=>$value['FSOLICITUD']??'',
                              'TIPO_MANDAMIENTO'=>$value['TIPO']??'',
                              'FECHA_LIBERA'=>$value['FLIBRAMINETO']??'',
                              'ESTATUS_MANDAMIENTO'=>$value['ESTATUS']??'',
                              'FECHA_MANDAMIENTO'=>$value['FMANDAMIENTO']??'',                              
                              'usuario'=>Auth::User()->id]);
                            $bitEvUsu=biteventousario::create(
                              ['idUsuario' => Auth::User()->id,
                              'idExpediente' => $idExp,
                              'idRegistro' => $medidasAI->id,
                              'idEvento' =>129,
                              'Evento' => 'Insertar mandamientos de Imputado en Etapa Investigación']);
                          }
                        }
                      break;
                    case 'A':
                      $post=causas_penales\cp_ev_imputados::updateOrCreate(['id'=>$request->idImputadoEN],
                        ['id_cp_etapainvestigacion'=>$cp_en->id,
                        'idImputado'=>$request->idImputado,
                        'idCausa'=>$idCausa,
                        'idExpediente'=>$idExp,

                        'AUDIENCIA_DE_GARANTIAS'=>$request->causa_H_audiencia_de_garantias, 
                        'PROMOVIDA_POR'=>$request->causa_H_promovida_por, 
                        'RESULTADO_AUDIENCIA_DE_GARANTIAS'=>$request->causa_H_resultado_audiencia_de_garantias, 
                        'FECHA_CITA'=>$request->causa_H_fecha_cita,   
                        'bitAudiencia'=>1,                      
                        'usuario'=>Auth::User()->id,                 
                        ]);
                      break;
                    case 'C':
                      $post=causas_penales\cp_ev_imputados::updateOrCreate(['id'=>$request->idImputadoEN],
                        ['id_cp_etapainvestigacion'=>$cp_en->id,
                        'idImputado'=>$request->idImputado,
                        'idCausa'=>$idCausa,
                        'idExpediente'=>$idExp,
                          // 'AUDIENCIA_DE_GARANTIAS'=>$request->causa_H_audiencia_de_garantias, 
                          // 'PROMOVIDA_POR'=>$request->causa_H_promovida_por, 
                          // 'RESULTADO_AUDIENCIA_DE_GARANTIAS'=>$request->causa_H_resultado_audiencia_de_garantias, 
                          // 'FECHA_CITA'=>$request->causa_H_fecha_cita, 
                          //// 'SOLICITUD_DE_ORDEN_DE_APREHENSION'=>$request->causa_H_solicitud_de_orden_de_aprehension, 
                          //// 'OA_SIN_EFECTO'=>$request->causa_H_oa_sin_efecto, 
                          //// 'OA_NEGADA'=>$request->causa_H_oa_negada, 
                          //// 'OA_CUMPLIDA'=>$request->causa_H_oa_cumplida, 
                          //// 'ORDEN_DE_COMPARECENCIA_GIRADA'=>$request->causa_H_orden_de_comparecencia_girada, 
                          //// 'ORDEN_DE_COMPARECENCIA_NEGADA'=>$request->causa_H_orden_de_comparecencia_negada,
                          //// 'FORMA_PROCESO'=>$request->causa_H_forma_proceso,
                          // 'FECHA_DETENCION'=>$request->causa_H_fecha_detencion,  
                          // 'DETENCION_LEGAL'=>$request->causa_H_detencion_legal,
                        'CASO_URGENTE_FECHA_LIBRAMIENTO'=>$request->causa_H_caso_urgente_fecha_libramiento,
                        'CASO_URGENTE_ESTATUS'=>$request->causa_H_caso_urgente_estatus,
                        'CASO_URGENTE_FECHA_CUMPLIMIENTO'=>$request->causa_H_caso_urgente_fecha_cumplimiento,
                          // 'SOLICITUD_DE_MANDAMIENTO_JUDICIAL'=>$request->causa_H_solicitud_de_mandamiento_judicial,
                          // 'TIPO_MANDAMIENTO'=>$request->causa_H_tipo_mandamiento,
                          // 'FECHA_LIBERA'=>$request->causa_H_fecha_libera,
                          // 'ESTATUS_MANDAMIENTO'=>$request->causa_H_estatus_mandamiento,
                          // 'FECHA_MANDAMIENTO'=>$request->causa_H_fecha_mandamiento,
                        'bitCasoUrgente'=>1,
                        'usuario'=>Auth::User()->id,                 
                        ]);
                      break;                                                                
                    default:
                      break;
                  }

                  $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $post->id,
                  'idEvento' => $post->wasRecentlyCreated ?99:100,
                  'Evento' => $post->wasRecentlyCreated ?'Insertar Vícitma de Etapa Investigación':'Actualizar Vícitma de Etapa Investigación']);                
                  if (strlen($request['hdnActos_con'.$request->idImputadoEN])>0) {
                    foreach (json_decode("[".rtrim($request['hdnActos_con'.$request->idImputadoEN],",")."]",true)
                    as $key => $value){                      
                      $medidasAI=causas_penales\cp_ev_actosconsin::create(
                        ['id_cp_ev_imputados'=>$post->id,
                        'idImputado'=>$request->idImputado,
                        'idCausa'=>$idCausa,
                        'idExpediente'=>$idExp,                          
                        'TIPO_ACTOS_CONSIN'=>$value['ACTO']??'',
                        'CONSIN'=>'con',
                        'usuario'=>Auth::User()->id]);
                      $bitEvUsu=biteventousario::create(
                        ['idUsuario' => Auth::User()->id,
                        'idExpediente' => $idExp,
                        'idRegistro' => $medidasAI->id,
                        'idEvento' =>106,
                        'Evento' => 'Insertar acto con control judicial en Etapa Investigación']);
                    }
                  }
                  if (strlen($request['hdnActos_sin'.$request->idImputadoEN])>0) {
                    foreach (json_decode("[".rtrim($request['hdnActos_sin'.$request->idImputadoEN],",")."]",true)
                    as $key => $value){                      
                      $medidasAI=causas_penales\cp_ev_actosconsin::create(
                        ['id_cp_ev_imputados'=>$post->id,
                        'idImputado'=>$request->idImputado,
                        'idCausa'=>$idCausa,
                        'idExpediente'=>$idExp,                          
                        'TIPO_ACTOS_CONSIN'=>$value['ACTO']??'',
                        'CONSIN'=>'sin',
                        'usuario'=>Auth::User()->id]);
                      $bitEvUsu=biteventousario::create(
                        ['idUsuario' => Auth::User()->id,
                        'idExpediente' => $idExp,
                        'idRegistro' => $medidasAI->id,
                        'idEvento' =>107,
                        'Evento' => 'Insertar acto sin control judicial de Vícitma en Etapa Investigación']);
                    }
                  }
                  $upd=causas_penales\cp_dg_imputados::where('id',$request->idImputado)->firstOrFail();
                  $upd->cp_ev=1;
                  $upd->save();  
                  $routeid=$idCausa;                
                }
              }
              else if (isset($request->idVictimaEN)) {
                $cp_en=causas_penales\cp_etapainvestigacion::where('idCausa',$idCausa)->first();
                if (isset($cp_en)) {
                  $post=causas_penales\cp_ev_victimas::updateOrCreate(['id'=>$request->idVictimaEN],
                    ['id_cp_etapainvestigacion'=>$cp_en->id,
                    'idVictima'=>$request->idVictima,
                    'idCausa'=>$idCausa,
                    'idExpediente'=>$idExp, 
                    'usuario'=>Auth::User()->id,                 
                    ]);
                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $idExp,
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?99:100,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Vícitma de Etapa Investigación':'Actualizar Vícitma de Etapa Investigación']);                
                  if (strlen($request['hdnMedidas'.$request->idVictimaEN])>0) {
                    foreach (json_decode("[".rtrim($request['hdnMedidas'.$request->idVictimaEN],",")."]",true)
                    as $key => $value){                      
                      $medidasAI=causas_penales\cp_ev_medidas::create(
                        ['id_cp_ev_victimas'=>$post->id,
                        'idVictima'=>$request->idVictima,
                        'idCausa'=>$idCausa,
                        'idExpediente'=>$idExp,                          
                        'TIPO_DE_MEDIDA'=>$value['TIPO']??'',
                        'TEMPORALIDAD_DE_LA_MEDIDA'=>$value['TEMPORALIDAD']??'',
                        'MEDIDA_IMPUESTA_POR'=>$value['IMPUESTA']??'',
                        'usuario'=>Auth::User()->id]);
                      $bitEvUsu=biteventousario::create(
                        ['idUsuario' => Auth::User()->id,
                        'idExpediente' => $idExp,
                        'idRegistro' => $medidasAI->id,
                        'idEvento' =>101,
                        'Evento' => 'Insertar medida de Vícitma en Etapa Investigación']);
                    }
                  }
                }
                $routeid=$idCausa;
              }
            }
           break;
           case 'd0ai'://////CAUSAS PENALES AUDIENCIA INICIAL
            //if (!isset($request->idImputadoAI)) {
            
              switch ($request->frmSecc) {
                case 'C':
                  $post=causas_penales\cp_audienciainicial::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp,'idImputado'=>$request->idImputado],
                    ['AUDIENCIA_INICIAL'=>$request->causa_H_audiencia_inicial,
                    'FECHA_AUDIENCIA_INICIAL'=>$request->causa_H_fecha_audiencia_inicial,
                    'MOTIVO_NOAUD'=>$request->causa_H_motivo_noaud,
                    // 'FECHA_INICIO_INVESTIGACION'=>$request->causa_H_fecha_inicio_investigacion,
                    // 'FECHA_CIERRE'=>$request->causa_H_fecha_cierre,
                    ////'PRORROGA'=>$request->causa_H_prorroga,
                    'NOMBRE_JUEZ_CONTROL'=>$request->causa_H_nombre_juez_control,
                    'bitCelebracion'=>1,
                    ]);
                  $bitCeleb=causas_penales\cp_ai_celebracion::create([
                    'idCausa'=>$idCausa,
                    'idExpediente'=>$idExp,
                    'idImputado'=>$request->idImputado,
                    'AUDIENCIA_INICIAL'=>$request->causa_H_audiencia_inicial,
                    'FECHA_AUDIENCIA_INICIAL'=>$request->causa_H_fecha_audiencia_inicial,
                    'MOTIVO_NOAUD'=>$request->causa_H_motivo_noaud,
                    'NOMBRE_JUEZ_CONTROL'=>$request->causa_H_nombre_juez_control,
                    ]);
                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $idExp,
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?36:37,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Celebración de Audiencia inicial':'Actualizar Causa Penal - Celebración de Audiencia inicial']);
                  break;
                case 'O':
                  $postcpAI=causas_penales\cp_audienciainicial::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp,'idImputado'=>$request->idImputado],
                    ['AUDIENCIA_INICIAL'=>DB::raw('AUDIENCIA_INICIAL'),
                    'FECHA_AUDIENCIA_INICIAL'=>DB::raw('FECHA_AUDIENCIA_INICIAL'),
                    'MOTIVO_NOAUD'=>DB::raw('MOTIVO_NOAUD'),
                    'FECHA_INICIO_INVESTIGACION'=>DB::raw('FECHA_INICIO_INVESTIGACION'),
                    'FECHA_CIERRE'=>DB::raw('FECHA_CIERRE'),
                    'NOMBRE_JUEZ_CONTROL'=>DB::raw('NOMBRE_JUEZ_CONTROL'),
                    ]);
                    //$cp_ai=causas_penales\cp_audienciainicial::where('idCausa',$idCausa)->first();
                    //if (isset($cp_ai)) {
                  $post=causas_penales\cp_ai_imputados::updateOrCreate(['id'=>$request->idImputadoAI],
                    ['bitControl'=>1,
                    'idcp_audienciainicial'=>$postcpAI->id,//$cp_ai->id,
                    'idCausa'=>$idCausa,
                    'idExpediente'=>$idExp,
                    'idImputado'=>$request->idImputado,
                    'DECRETO_LEGAL_DETENCION'=>$request->causa_H_decreto_legal_detencion, 
                    'FECHA_CONTROL'=>$request->causa_H_fecha_control, 
                    'FORMA_DE_CONDUCCION_DEL_IMPUTADO_A_PROCESO'=>$request->causa_H_forma_de_conduccion_del_imputado_a_proceso, 
                      // 'FECHA_FORM'=>$request->causa_H_fecha_form, 
                      // 'FORMULACION'=>$request->causa_H_formulacion, 
                      // 'OBSERVACIONES'=>$request->causa_H_observaciones,
                      // 'RESOLUCION'=>$request->causa_H_resolucion, 
                      // 'FECHA_RESOL'=>$request->causa_H_fecha_resol, 
                      // 'DELITO_VINCULO'=>implode(', ', $request->causa_H_delito_vinculo),//$request->causa_H_delito_vinculo,
                      //  // 'INV_CON_DETENIDO'=>$request->causa_H_inv_con_detenido, 
                      //  // 'MEDIDAS_CAUTELARES'=>$request->causa_H_medidas_cautelares, 
                      //  // 'TIPO_MEDIDAS_CAUTELARES'=>$request->causa_H_tipo_medidas_cautelares, 
                      //  // 'TEMPORALIDAD_MEDIDA'=>$request->causa_H_temporalidad_medida, 
                      //  // 'ACUERDO_REPARATORIO'=>$request->causa_H_acuerdo_reparatorio, 
                      //  // 'FECHA_CUMPLIMIENTO'=>$request->causa_H_fecha_cumplimiento,
                      //  // 'FECHA_ACUERDOS_REPARATORIOS'=>$request->causa_H_fecha_acuerdos_reparatorios, 
                      //  // 'ACUERDOS_REPARATORIOS'=>$request->causa_H_acuerdos_reparatorios, 
                      //  // 'MONTO_REP_DAÑO'=>$request->causa_H_monto_rep_daño, 
                      //  // 'CONDICION_IMPUESTA'=>$request->causa_H_condicion_impuesta, 
                      //  // 'TEMPORALIDAD'=>$request->causa_H_temporalidad, 
                      //  // 'REPARACION_DEL_DAÑO'=>$request->causa_H_reparacion_del_daño_, 
                      //  // 'TEMPORALIDAD_SALIDAD_ALTERNAS'=>$request->causa_H_temporalidad_salidad_alternas, 
                      //  // 'SUSPENSION_CONDICIONAL'=>$request->causa_H_suspension_condicional, 
                      //  // 'FECHA_SUSPENSION'=>$request->causa_H_fecha_suspension, 
                      //  // 'TIPO_SUSPENSION'=>$request->causa_H_tipo_suspension, 
                      //  // 'FECHA_CUMPL'=>$request->causa_H_fecha_cumpl, 
                      //  // 'SUSPENSION_DEL_PROCESO'=>$request->causa_H_suspension_del_proceso, 
                      //  // 'CAUSA_PROCESO'=>$request->causa_H_causa_proceso, 
                      //  // 'FECHA_DE_REANUDACION'=>$request->causa_H_fecha_de_reanudacion, 
                      //  // 'FECHA_SOBRESEIMIENTO'=>$request->causa_H_fecha_sobreseimiento, 
                      //  // 'CAUSAS_SOBRESEIMIENTO'=>$request->causa_H_causas_sobreseimiento, 
                      //  // 'TIPO_SOBRESEIMIENTO'=>$request->causa_H_tipo_sobreseimiento, 
                    ]);
                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $idExp,
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?38:39,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Imputado - Control de detención de Audiencia inicial':'Actualizar Imputado - Control de detención de Audiencia inicial']);

                  break;
                case 'F':
                  $postcpAI=causas_penales\cp_audienciainicial::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp,'idImputado'=>$request->idImputado],
                    ['AUDIENCIA_INICIAL'=>DB::raw('AUDIENCIA_INICIAL'),
                    'FECHA_AUDIENCIA_INICIAL'=>DB::raw('FECHA_AUDIENCIA_INICIAL'),
                    'MOTIVO_NOAUD'=>DB::raw('MOTIVO_NOAUD'),
                    'FECHA_INICIO_INVESTIGACION'=>DB::raw('FECHA_INICIO_INVESTIGACION'),
                    'FECHA_CIERRE'=>DB::raw('FECHA_CIERRE'),
                    'NOMBRE_JUEZ_CONTROL'=>DB::raw('NOMBRE_JUEZ_CONTROL'),
                    ]);
                    //$cp_ai=causas_penales\cp_audienciainicial::where('idCausa',$idCausa)->first();
                    //if (isset($cp_ai)) {
                  $post=causas_penales\cp_ai_imputados::updateOrCreate(['id'=>$request->idImputadoAI],
                    ['bitFormulacion'=>1,
                    'idcp_audienciainicial'=>$postcpAI->id,//$cp_ai->id,
                    'idCausa'=>$idCausa,
                    'idExpediente'=>$idExp,
                    'idImputado'=>$request->idImputado,
                      // 'DECRETO_LEGAL_DETENCION'=>$request->causa_H_decreto_legal_detencion, 
                      // 'FECHA_CONTROL'=>$request->causa_H_fecha_control, 
                      // 'FORMA_DE_CONDUCCION_DEL_IMPUTADO_A_PROCESO'=>$request->causa_H_forma_de_conduccion_del_imputado_a_proceso, 
                    'FECHA_FORM'=>$request->causa_H_fecha_form, 
                    'FORMULACION'=>$request->causa_H_formulacion, 
                    'OBSERVACIONES'=>$request->causa_H_observaciones,
                      // 'RESOLUCION'=>$request->causa_H_resolucion, 
                      // 'FECHA_RESOL'=>$request->causa_H_fecha_resol, 
                      // 'DELITO_VINCULO'=>implode(', ', $request->causa_H_delito_vinculo),//$request->causa_H_delito_vinculo,
                      //  // 'INV_CON_DETENIDO'=>$request->causa_H_inv_con_detenido, 
                      //  // 'MEDIDAS_CAUTELARES'=>$request->causa_H_medidas_cautelares, 
                      //  // 'TIPO_MEDIDAS_CAUTELARES'=>$request->causa_H_tipo_medidas_cautelares, 
                      //  // 'TEMPORALIDAD_MEDIDA'=>$request->causa_H_temporalidad_medida, 
                      //  // 'ACUERDO_REPARATORIO'=>$request->causa_H_acuerdo_reparatorio, 
                      //  // 'FECHA_CUMPLIMIENTO'=>$request->causa_H_fecha_cumplimiento,
                      //  // 'FECHA_ACUERDOS_REPARATORIOS'=>$request->causa_H_fecha_acuerdos_reparatorios, 
                      //  // 'ACUERDOS_REPARATORIOS'=>$request->causa_H_acuerdos_reparatorios, 
                      //  // 'MONTO_REP_DAÑO'=>$request->causa_H_monto_rep_daño, 
                      //  // 'CONDICION_IMPUESTA'=>$request->causa_H_condicion_impuesta, 
                      //  // 'TEMPORALIDAD'=>$request->causa_H_temporalidad, 
                      //  // 'REPARACION_DEL_DAÑO'=>$request->causa_H_reparacion_del_daño_, 
                      //  // 'TEMPORALIDAD_SALIDAD_ALTERNAS'=>$request->causa_H_temporalidad_salidad_alternas, 
                      //  // 'SUSPENSION_CONDICIONAL'=>$request->causa_H_suspension_condicional, 
                      //  // 'FECHA_SUSPENSION'=>$request->causa_H_fecha_suspension, 
                      //  // 'TIPO_SUSPENSION'=>$request->causa_H_tipo_suspension, 
                      //  // 'FECHA_CUMPL'=>$request->causa_H_fecha_cumpl, 
                      //  // 'SUSPENSION_DEL_PROCESO'=>$request->causa_H_suspension_del_proceso, 
                      //  // 'CAUSA_PROCESO'=>$request->causa_H_causa_proceso, 
                      //  // 'FECHA_DE_REANUDACION'=>$request->causa_H_fecha_de_reanudacion, 
                      //  // 'FECHA_SOBRESEIMIENTO'=>$request->causa_H_fecha_sobreseimiento, 
                      //  // 'CAUSAS_SOBRESEIMIENTO'=>$request->causa_H_causas_sobreseimiento, 
                      //  // 'TIPO_SOBRESEIMIENTO'=>$request->causa_H_tipo_sobreseimiento, 
                    ]);
                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $idExp,
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?152:153,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Imputado - Formulación de imputación de Audiencia inicial':'Actualizar Imputado - Formulación de imputación de Audiencia inicial']);                  
                  break;
                case 'V':
                  $postcpAI=causas_penales\cp_audienciainicial::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp,'idImputado'=>$request->idImputado],
                    ['AUDIENCIA_INICIAL'=>DB::raw('AUDIENCIA_INICIAL'),
                    'FECHA_AUDIENCIA_INICIAL'=>DB::raw('FECHA_AUDIENCIA_INICIAL'),
                    'MOTIVO_NOAUD'=>DB::raw('MOTIVO_NOAUD'),
                    'FECHA_INICIO_INVESTIGACION'=>DB::raw('FECHA_INICIO_INVESTIGACION'),
                    'FECHA_CIERRE'=>DB::raw('FECHA_CIERRE'),
                    'NOMBRE_JUEZ_CONTROL'=>DB::raw('NOMBRE_JUEZ_CONTROL'),
                    ]);
                    //$cp_ai=causas_penales\cp_audienciainicial::where('idCausa',$idCausa)->first();
                    //if (isset($cp_ai)) {
                  $post=causas_penales\cp_ai_imputados::updateOrCreate(['id'=>$request->idImputadoAI],
                    ['bitVinculacion'=>1,
                    'idcp_audienciainicial'=>$postcpAI->id,//$cp_ai->id,
                    'idCausa'=>$idCausa,
                    'idExpediente'=>$idExp,
                    'idImputado'=>$request->idImputado,
                      // 'DECRETO_LEGAL_DETENCION'=>$request->causa_H_decreto_legal_detencion, 
                      // 'FECHA_CONTROL'=>$request->causa_H_fecha_control, 
                      // 'FORMA_DE_CONDUCCION_DEL_IMPUTADO_A_PROCESO'=>$request->causa_H_forma_de_conduccion_del_imputado_a_proceso, 
                      // 'FECHA_FORM'=>$request->causa_H_fecha_form, 
                      // 'FORMULACION'=>$request->causa_H_formulacion, 
                      // 'OBSERVACIONES'=>$request->causa_H_observaciones,
                    'RESOLUCION'=>$request->causa_H_resolucion, 
                    'FECHA_RESOL'=>$request->causa_H_fecha_resol, 
                    'DELITO_VINCULO'=>implode(', ', $request->causa_H_delito_vinculo?? [] ),//$request->causa_H_delito_vinculo,
                      //  // 'INV_CON_DETENIDO'=>$request->causa_H_inv_con_detenido, 
                      //  // 'MEDIDAS_CAUTELARES'=>$request->causa_H_medidas_cautelares, 
                      //  // 'TIPO_MEDIDAS_CAUTELARES'=>$request->causa_H_tipo_medidas_cautelares, 
                      //  // 'TEMPORALIDAD_MEDIDA'=>$request->causa_H_temporalidad_medida, 
                      //  // 'ACUERDO_REPARATORIO'=>$request->causa_H_acuerdo_reparatorio, 
                      //  // 'FECHA_CUMPLIMIENTO'=>$request->causa_H_fecha_cumplimiento,
                      //  // 'FECHA_ACUERDOS_REPARATORIOS'=>$request->causa_H_fecha_acuerdos_reparatorios, 
                      //  // 'ACUERDOS_REPARATORIOS'=>$request->causa_H_acuerdos_reparatorios, 
                      //  // 'MONTO_REP_DAÑO'=>$request->causa_H_monto_rep_daño, 
                      //  // 'CONDICION_IMPUESTA'=>$request->causa_H_condicion_impuesta, 
                      //  // 'TEMPORALIDAD'=>$request->causa_H_temporalidad, 
                      //  // 'REPARACION_DEL_DAÑO'=>$request->causa_H_reparacion_del_daño_, 
                      //  // 'TEMPORALIDAD_SALIDAD_ALTERNAS'=>$request->causa_H_temporalidad_salidad_alternas, 
                      //  // 'SUSPENSION_CONDICIONAL'=>$request->causa_H_suspension_condicional, 
                      //  // 'FECHA_SUSPENSION'=>$request->causa_H_fecha_suspension, 
                      //  // 'TIPO_SUSPENSION'=>$request->causa_H_tipo_suspension, 
                      //  // 'FECHA_CUMPL'=>$request->causa_H_fecha_cumpl, 
                      //  // 'SUSPENSION_DEL_PROCESO'=>$request->causa_H_suspension_del_proceso, 
                      //  // 'CAUSA_PROCESO'=>$request->causa_H_causa_proceso, 
                      //  // 'FECHA_DE_REANUDACION'=>$request->causa_H_fecha_de_reanudacion, 
                      //  // 'FECHA_SOBRESEIMIENTO'=>$request->causa_H_fecha_sobreseimiento, 
                      //  // 'CAUSAS_SOBRESEIMIENTO'=>$request->causa_H_causas_sobreseimiento, 
                      //  // 'TIPO_SOBRESEIMIENTO'=>$request->causa_H_tipo_sobreseimiento, 
                    ]);
                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $idExp,
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?154:155,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Imputado - Vinculación a proceso de Audiencia inicial':'Actualizar Imputado - Vinculación a proceso de Audiencia inicial']);
                  causas_penales\cp_ai_vinculaciones::where('idcp_ai_imputados',$post->id)->delete();
                  foreach ($request->causa_H_delito_vinculo?? [] as $key => $value) {
                    $postdV=causas_penales\cp_ai_vinculaciones::create(['idcp_ai_imputados'=>$post->id,
                    'idcp_audienciainicial'=>$postcpAI->id,//$cp_ai->id,
                    'idCausa'=>$idCausa,
                    'idExpediente'=>$idExp,
                    'idImputado'=>$request->idImputado,

                    'RESOLUCION'=>$request->causa_H_resolucion, 
                    'FECHA_RESOL'=>$request->causa_H_fecha_resol, 
                    'DELITO_VINCULO'=>$value
                    ]);
                  }
                  break;
                case 'P':
                  $post=causas_penales\cp_audienciainicial::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp,'idImputado'=>$request->idImputado,],
                    [//'AUDIENCIA_INICIAL'=>$request->causa_H_audiencia_inicial,
                    // 'FECHA_AUDIENCIA_INICIAL'=>$request->causa_H_fecha_audiencia_inicial,
                    // 'MOTIVO_NOAUD'=>$request->causa_H_motivo_noaud,
                    'FECHA_INICIO_INVESTIGACION'=>$request->causa_H_fecha_inicio_investigacion,
                    'FECHA_CIERRE'=>$request->causa_H_fecha_cierre,
                    ////'PRORROGA'=>$request->causa_H_prorroga,
                    // 'NOMBRE_JUEZ_CONTROL'=>$request->causa_H_nombre_juez_control,
                    'bitPlazo'=>1,
                    ]);

                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $idExp,
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?150:151,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Audiencia inicial - Plazo de investigación complementaria':'Actualizar Causa Penal - Audiencia inicial - Plazo de investigación complementaria']);
                  if (strlen($request['hdnProrrogas'.$request->idImputadoAI])>0) {
                    $cp_ai=causas_penales\cp_audienciainicial::where('idCausa',$idCausa)->first();
                    if (isset($cp_ai)) {
                      foreach (json_decode("[".rtrim($request['hdnProrrogas'.$request->idImputadoAI],",")."]",true) as $key => $value) {
                        $prorrogasAI=causas_penales\cp_ai_prorrogas::create(
                          ['id_cp_audienciainicial'=>$cp_ai->id,//$post->id,
                          'idCausa'=>$idCausa,
                          'idExpediente'=>$idExp,
                          'idImputado'=>$request->idImputado,
                          'PRORROGA'=>$value['PRORROGA']??'',
                          'TEMPORALIDAD_PRORROGA'=>$value['TEMPORALIDAD']??'',
                          'usuario'=>Auth::User()->id]);
                        $bitEvUsu=biteventousario::create(
                          ['idUsuario' => Auth::User()->id,
                          'idExpediente' => $idExp,
                          'idRegistro' => $prorrogasAI->id,
                          'idEvento' =>108,
                          'Evento' => 'Insertar prorrogas de en Audiencia inicial']);
                      }
                    }
                  }
                  break;
                default:
                  // code...
                  break;
              }
                  $upd=causas_penales\cp_dg_imputados::where('id',$request->idImputado)->firstOrFail();
                  $upd->cp_ai=1;
                  $upd->save();

              $routeid=$idCausa;
            //}
           break;
           case 'd0mc'://////CAUSAS PENALES MEDIDAS CAUTELARES
                     
            $post = causas_penales\cp_medidascautelares::updateOrCreate(['id' => $request->idImputadoAI],
              ['idImputado'=>$request->idImputado, 
                'idCausa'=>$idCausa,
                'idExpediente'=>$idExp,]);
            $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $idExp,
              'idRegistro' => $post->id,
              'idEvento' => $post->wasRecentlyCreated ?110:111,
              'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Medida Cautelar':
              'Actualizar Causa Penal - Medida Cautelar']);
            
            if (strlen($request['hdnMedidas'.$request->idImputadoAI])>0) {
              foreach (json_decode("[".rtrim($request['hdnMedidas'.$request->idImputadoAI],",")."]",true) as $key => $value) {
                $medidasAI=causas_penales\cp_mc_medidas::create(
                  ['id_cp_medidascautelares'=>$post->id,
                  'MEDIDAS_CAUTELARES'=>'1',
                  'TIPO_MEDIDAS_CAUTELARES'=>$value['TIPO']??'',
                  'TEMPORALIDAD_MEDIDA_D'=>$value['TEMPORALIDAD_D']??'',
                  'TEMPORALIDAD_MEDIDA_M'=>$value['TEMPORALIDAD_M']??'',
                  'TEMPORALIDAD_MEDIDA_A'=>$value['TEMPORALIDAD_A']??'',
                  'RECURRENCIA'=>$value['RECURRENCIA']??'',
                  'MEDIDAS_OBSERVACIONES'=>$value['OBSERVACIONES']??'',
                  'usuario'=>Auth::User()->id]);
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $medidasAI->id,
                  'idEvento' =>112,
                  'Evento' => 'Insertar medida cautalares']);
              }
                $total_anios=0;
                $prision=causas_penales\cp_mc_medidas::where('id_cp_medidascautelares',$post->id)
                ->whereIn('TIPO_MEDIDAS_CAUTELARES',[14,15,16])
                ->select(DB::raw("FLOOR(IFNULL((SUM(TEMPORALIDAD_MEDIDA_D)/365.25)+(SUM(TEMPORALIDAD_MEDIDA_M)/12)+SUM(TEMPORALIDAD_MEDIDA_A),0)) as tiempo"))
                ->first();
                if ($prision) {
                    $total_anios = $prision->tiempo;
                    // $tiempo contiene el resultado de la consulta
                    // Puedes usar $tiempo como necesites
                }
                 $total_anios=floor($total_anios);
                 $tiempo=causas_penales\cp_jo_imputados::where('idImputado',$request->idImputado)
                 ->update(['TIEMPO'=>$total_anios]);              
            }
            $routeid=$idCausa;           
           break;
           case 'd0sa'://////CAUSAS PENALES SALIDAS ALTERNAS 
            $post = causas_penales\cp_salidasalternas::updateOrCreate(['id' => $request->idImputadoAI],
              ['idImputado'=>$request->idImputado, 
                'FOLIO_AE'=>$request->expediente_H_Folio_AE,
                'ACTO_EQUIVALENTE_MONTO'=>$request->expediente_H_acto_equivalente_monto,
                'idCausa'=>$idCausa,
                'idExpediente'=>$idExp,]);
            $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $idExp,
              'idRegistro' => $post->id,
              'idEvento' => $post->wasRecentlyCreated ?114:115,
              'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Salidas Alternas':
              'Actualizar Causa Penal - Salidas Alternas']);

            if ($request->frmSecc=='A') {
              if (strlen($request['hdnAcuerdos'.$request->idImputadoAI])>0) {
                foreach (json_decode("[".rtrim($request['hdnAcuerdos'.$request->idImputadoAI],",")."]",true) as $key => $value) {
                  $medidasAI=causas_penales\cp_sa_acuerdos::create(
                    ['id_cp_salidasalternas'=>$post->id,
                    'ACUERDO_REPARATORIO'=>$value['ACUERDO']??'',
                    'FECHA_CUMPLIMIENTO'=>$value['CUMPLIMIENTO']??'',
                    'FECHA_ACUERDOS_REPARATORIOS'=>$value['FECHA_ACUERDOS']??'',
                    'ACUERDOS_REPARATORIOS'=>$value['ACUERDOS']??'',
                    'ACUERDOS_REPARATORIOS_OBSERVACIONES'=>$value['ACUERDOS_OBS']??'',
                    'MONTO_REP_DAÑO'=>$value['MONTO']??'',
                    'REPARACION_DEL_DAÑO'=>$value['REPARACION']??'',
                    'TEMPORALIDAD'=>$value['TEMPORALIDAD']??'',
                    'usuario'=>Auth::User()->id]);
                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $idExp,
                    'idRegistro' => $medidasAI->id,
                    'idEvento' =>116,
                    'Evento' => 'Insertar Acuerdo reparatorio']);
                  $actualizarBitA = causas_penales\cp_salidasalternas::where('id', $post->id)->update(['bitAcuerdosReparatorios'=>1]);                  
                }
              }
            }
            if ($request->frmSecc=='S') {
              if (strlen($request['hdnSuspensiones'.$request->idImputadoAI])>0) {
                foreach (json_decode("[".rtrim($request['hdnSuspensiones'.$request->idImputadoAI],",")."]",true) as $key => $value) {
                  $medidasAI=causas_penales\cp_sa_suspensiones::create(
                    ['id_cp_salidasalternas'=>$post->id,
                    'FECHA_SUSPENSION'=>$value['FECHA_SUS']??'',
                    'TIPO_SUSPENSION'=>$value['TIPO_SUS']??'',
                    'SUSPENSION_OBSERVACIONES'=>$value['SUS_OBS']??'',
                    'FECHA_CUMPL'=>$value['FECHA_CUMPL']??'',
                    'REVOCACION_SUSPENSION'=>$value['REVOCACION']??'',
                    'MOTIVO_REVOCACION'=>$value['MOTIVO']??'',
                    'REAPERTURA'=>$value['REAPERTURA']??'',
                    'FECHA_REAPERTURA'=>$value['FECHA_REAPERTURA']??'',
                    'usuario'=>Auth::User()->id]);
                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $idExp,
                    'idRegistro' => $medidasAI->id,
                    'idEvento' =>117,
                    'Evento' => 'Insertar suspensión condicional']);
                  $actualizarBitS = causas_penales\cp_salidasalternas::where('id', $post->id)->update(['bitSuspension'=>1]);
                }
              }
            }
            $routeid=$idCausa;           
           break;           
           case 'd0pa'://////CAUSAS PENALES PROCEDIMIENTO ABREVIADO

              $post = causas_penales\cp_procedimientoabreviado::updateOrCreate(['id' => $request->idImputadoPA],
                ['idImputado'=>$request->idImputado, 
                'idCausa'=>$idCausa,
                'idExpediente'=>$idExp,
                'PROCEDIMIENTO_ABREVIADO'=>$request->causa_H_procedimiento_abreviado,
                'PENA_CONDENATORIA_EN_ABREVIADO'=>$request->causa_H_pena_condenatoria_en_abreviado,
                'NO_ADMISION_DEL_ABREVIADO'=>$request->causa_H_no_admision_del_abreviado,
                'ESTATUS_ABREVIADO'=>$request->causa_H_estatus_abreviado,
                'NARRACION_PROCEDIMIENTO'=>$request->causa_H_narracion_procedimiento,
                //'ABREVIADO'=>$request->causa_H_abreviado,
                'CAUSAS_ABREVIADO'=>$request->causa_H_causas_abreviado,]);

              $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $idExp,
                'idRegistro' => $post->id,
                'idEvento' => $post->wasRecentlyCreated ?40:41,
                'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Procedimiento abreviado':'Actualizar Causa Penal - Procedimiento abreviado']);
                
              $upd=causas_penales\cp_dg_imputados::where('id',$request->idImputado)->firstOrFail();
              $upd->cp_pa=1;
              $upd->save();
                            
              $routeid=$idCausa;
           break;
           case 'd0ss'://////CAUSAS PENALES SUSPENSION Y SOBRESEIMIENTO
            if (!isset($request->idImputadoAI)) {
              $postSS = causas_penales\cp_suspensionsobreseimiento::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp],
                ['FECHA_SUSPENSION'=>$request->causa_H_fecha_suspension,
                'CAUSA_PROCESO'=>$request->causa_H_causa_proceso,
                'REAPERTURA_PROCESO'=>$request->causa_H_reapertura_proceso,
                'FECHA_DE_REANUDACION'=>$request->causa_H_fecha_de_reanudacion,
                ]);
              $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $idExp,
                'idRegistro' => $postSS->id,
                'idEvento' => $postSS->wasRecentlyCreated ?120:121,
                'Evento' => $postSS->wasRecentlyCreated ?'Insertar Causa Penal - suspensión y sobreseimiento':'Actualizar Causa Penal - suspensión y sobreseimiento']);              
            }
            else
            {
              $postSS = causas_penales\cp_suspensionsobreseimiento::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp]);
              $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $idExp,
                'idRegistro' => $postSS->id,
                'idEvento' => $postSS->wasRecentlyCreated ?120:121,
                'Evento' => $postSS->wasRecentlyCreated ?'Insertar Causa Penal - suspensión y sobreseimiento':'Actualizar Causa Penal - suspensión y sobreseimiento']);

              $post = causas_penales\cp_ss_imputados::updateOrCreate(['id' => $request->idImputadoAI],
                ['id_cp_suspensionsobreseimiento'=>$postSS->id,
                'idImputado'=>$request->idImputado, 
                'idCausa'=>$idCausa,
                'idExpediente'=>$idExp,
                'FECHA_SOBRESEIMIENTO'=>$request->causa_H_fecha_sobreseimiento,
                'TIPO_SOBRESEIMIENTO'=>$request->causa_H_tipo_sobreseimiento,
                'CAUSAS_SOBRESEIMIENTO'=>$request->causa_H_causas_sobreseimiento,
                'SOBRESEIMIENTO_OBSERVACIONES'=>$request->causa_H_sobreseimiento_observaciones,
                // 'FECHA_SUSPENSION'=>$request->causa_H_fecha_suspension,
                // 'CAUSA_PROCESO'=>$request->causa_H_causa_proceso,
                // 'REAPERTURA_PROCESO'=>$request->causa_H_reapertura_proceso,
                // 'FECHA_DE_REANUDACION'=>$request->causa_H_fecha_de_reanudacion,
                ]);
                $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $idExp,
                'idRegistro' => $postSS->id,
                'idEvento' => $postSS->wasRecentlyCreated ?131:132,
                'Evento' => $postSS->wasRecentlyCreated ?'Insertar Causa Penal - Imputado sobreseimiento':'Actualizar Causa Penal - Imputado sobreseimiento']);
              }
              


                
              // $upd=causas_penales\cp_dg_imputados::where('id',$request->idImputado)->firstOrFail();
              // $upd->cp_pa=1;
              // $upd->save();
                            
              $routeid=$idCausa;
           break;
           case 'd0ei'://////CAUSAS PENALES ETAPA INTERMEDIA
           
            // if (!isset($request->idImputadoEI)) {
             switch ($request->frmSecc) {
               case 'A':
                $post=causas_penales\cp_etapaintermedia::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp,'idImputado'=>$request->idImputado],
                  [
                  'ACUSACION'=>$request->causa_H_acusacion,
                  'FECHA_ESCRITO_ACUS'=>$request->causa_H_fecha_escrito_acus,
                    // // 'FECHA_ACUSACION'=>$request->causa_H_fecha_acusacion,
                    // 'INTERMEDIA'=>$request->causa_H_intermedia,
                    // 'FECHA_AUDIENCIA_INTERMEDIA'=>$request->causa_H_fecha_audiencia_intermedia,
                    // 'SUSPENSION_DE_AUDIENCIA'=>$request->causa_H_suspension_de_audiencia,
                    // 'CAUSAS_SUSPENSION_INTERMEDIA'=>$request->causa_H_causas_suspension_intermedia,
                    // 'FECHA_DE_REANUDACION_INTERMEDIA'=>$request->causa_H_fecha_de_reanudacion_intermedia,
                    // // 'CAUSAS_NO_ADMISION'=>$request->causa_H_causas_no_admision,
                    // 'MEDIO_PRUEBA'=>$request->causa_H_medio_prueba,
                    // // 'MEDIOS_PRUEBAS'=>$request->causa_H_medios_pruebas,
                    // 'ACUERDOS_PROP'=>$request->causa_H_acuerdos_prop,
                    // 'OBSERVACIONES_ACUERDOS'=>$request->causa_H_observaciones_acuerdos,
                    // 'JUICIO_ORAL'=>$request->causa_H_juicio_oral,
                    // 'AUTO_DE_APERTURA'=>$request->causa_H_auto_de_apertura,
                    // 'FECHA_AUDIENCIA_JUICIO'=>$request->causa_H_fecha_audiencia_juicio,
                  'bitAcusacion'=>1
                  ]);
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $post->id,
                  'idEvento' => $post->wasRecentlyCreated ?42:43,
                  'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Etapa intermedia':'Actualizar Causa Penal - Etapa intermedia']);
                 break;
               case 'I':
                $post=causas_penales\cp_etapaintermedia::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp,'idImputado'=>$request->idImputado],
                  [
                    // 'ACUSACION'=>$request->causa_H_acusacion,
                    // 'FECHA_ESCRITO_ACUS'=>$request->causa_H_fecha_escrito_acus,
                    // // 'FECHA_ACUSACION'=>$request->causa_H_fecha_acusacion,
                  'INTERMEDIA'=>$request->causa_H_intermedia,
                  'FECHA_AUDIENCIA_INTERMEDIA'=>$request->causa_H_fecha_audiencia_intermedia,
                  'SUSPENSION_DE_AUDIENCIA'=>$request->causa_H_suspension_de_audiencia,
                  'CAUSAS_SUSPENSION_INTERMEDIA'=>$request->causa_H_causas_suspension_intermedia,
                  'FECHA_DE_REANUDACION_INTERMEDIA'=>$request->causa_H_fecha_de_reanudacion_intermedia,
                    // // 'CAUSAS_NO_ADMISION'=>$request->causa_H_causas_no_admision,
                    // 'MEDIO_PRUEBA'=>$request->causa_H_medio_prueba,
                    // // 'MEDIOS_PRUEBAS'=>$request->causa_H_medios_pruebas,
                    // 'ACUERDOS_PROP'=>$request->causa_H_acuerdos_prop,
                    // 'OBSERVACIONES_ACUERDOS'=>$request->causa_H_observaciones_acuerdos,
                    // 'JUICIO_ORAL'=>$request->causa_H_juicio_oral,
                    // 'AUTO_DE_APERTURA'=>$request->causa_H_auto_de_apertura,
                    // 'FECHA_AUDIENCIA_JUICIO'=>$request->causa_H_fecha_audiencia_juicio,
                  'bitAudienciaIntermedia'=>1
                  ]);
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $post->id,
                  'idEvento' => $post->wasRecentlyCreated ?42:43,
                  'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Etapa intermedia':'Actualizar Causa Penal - Etapa intermedia']);
                if ($request->causa_H_intermedia==0) {
                  $bitSusp=causas_penales\cp_ei_suspension::create([
                    'idCausa'=>$idCausa,
                    'idExpediente'=>$idExp,
                    'idImputado'=>$request->idImputado,
                    'SUSPENSION_DE_AUDIENCIA'=>$request->causa_H_suspension_de_audiencia,
                    'CAUSAS_SUSPENSION_INTERMEDIA'=>$request->causa_H_causas_suspension_intermedia,
                    'FECHA_DE_REANUDACION_INTERMEDIA'=>$request->causa_H_fecha_de_reanudacion_intermedia,
                    ]);
                }
                 break;
               case 'P':
                $post=causas_penales\cp_etapaintermedia::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp,'idImputado'=>$request->idImputado],
                  [
                    // 'ACUSACION'=>$request->causa_H_acusacion,
                    // 'FECHA_ESCRITO_ACUS'=>$request->causa_H_fecha_escrito_acus,
                    // // 'FECHA_ACUSACION'=>$request->causa_H_fecha_acusacion,
                    // 'INTERMEDIA'=>$request->causa_H_intermedia,
                    // 'FECHA_AUDIENCIA_INTERMEDIA'=>$request->causa_H_fecha_audiencia_intermedia,
                    // 'SUSPENSION_DE_AUDIENCIA'=>$request->causa_H_suspension_de_audiencia,
                    // 'CAUSAS_SUSPENSION_INTERMEDIA'=>$request->causa_H_causas_suspension_intermedia,
                    // 'FECHA_DE_REANUDACION_INTERMEDIA'=>$request->causa_H_fecha_de_reanudacion_intermedia,
                    // // 'CAUSAS_NO_ADMISION'=>$request->causa_H_causas_no_admision,
                    // 'MEDIO_PRUEBA'=>$request->causa_H_medio_prueba,
                    // // 'MEDIOS_PRUEBAS'=>$request->causa_H_medios_pruebas,
                  'ACUERDOS_PROP'=>$request->causa_H_acuerdos_prop,
                  'OBSERVACIONES_ACUERDOS'=>$request->causa_H_observaciones_acuerdos,
                    // 'JUICIO_ORAL'=>$request->causa_H_juicio_oral,
                    // 'AUTO_DE_APERTURA'=>$request->causa_H_auto_de_apertura,
                    // 'FECHA_AUDIENCIA_JUICIO'=>$request->causa_H_fecha_audiencia_juicio,
                  'bitAcuerdosProbatorios'=>1
                  ]);
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $post->id,
                  'idEvento' => $post->wasRecentlyCreated ?42:43,
                  'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Etapa intermedia':'Actualizar Causa Penal - Etapa intermedia']);
                 break;
               case 'D':
                $post=causas_penales\cp_etapaintermedia::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp,'idImputado'=>$request->idImputado],
                  [
                    // 'ACUSACION'=>$request->causa_H_acusacion,
                    // 'FECHA_ESCRITO_ACUS'=>$request->causa_H_fecha_escrito_acus,
                    // // 'FECHA_ACUSACION'=>$request->causa_H_fecha_acusacion,
                    // 'INTERMEDIA'=>$request->causa_H_intermedia,
                    // 'FECHA_AUDIENCIA_INTERMEDIA'=>$request->causa_H_fecha_audiencia_intermedia,
                    // 'SUSPENSION_DE_AUDIENCIA'=>$request->causa_H_suspension_de_audiencia,
                    // 'CAUSAS_SUSPENSION_INTERMEDIA'=>$request->causa_H_causas_suspension_intermedia,
                    // 'FECHA_DE_REANUDACION_INTERMEDIA'=>$request->causa_H_fecha_de_reanudacion_intermedia,
                    // // 'CAUSAS_NO_ADMISION'=>$request->causa_H_causas_no_admision,
                    // 'MEDIO_PRUEBA'=>$request->causa_H_medio_prueba,
                    // // 'MEDIOS_PRUEBAS'=>$request->causa_H_medios_pruebas,
                    // 'ACUERDOS_PROP'=>$request->causa_H_acuerdos_prop,
                    // 'OBSERVACIONES_ACUERDOS'=>$request->causa_H_observaciones_acuerdos,
                  'JUICIO_ORAL'=>$request->causa_H_juicio_oral,
                  'AUTO_DE_APERTURA'=>$request->causa_H_auto_de_apertura,
                  'FECHA_AUDIENCIA_JUICIO'=>$request->causa_H_fecha_audiencia_juicio,
                  'bitDatosJuicioOral'=>1
                  ]);
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $post->id,
                  'idEvento' => $post->wasRecentlyCreated ?42:43,
                  'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Etapa intermedia':'Actualizar Causa Penal - Etapa intermedia']);
                 break;                                                 
               default:
                 // code...
                 break;
             }

              // if ($request->causa_H_medio_prueba!=1) {
              //   $deleted = causas_penales\cp_ei_medios::where('id_cp_etapaintermedia', $post->id)->delete();
              // }
              // if (strlen($request['hdnMedidas0'])>0) {
              //   foreach (json_decode("[".rtrim($request['hdnMedidas0'],",")."]",true) as $key => $value) {
              //     $actosEV=causas_penales\cp_ei_medios::create(
              //       ['id_cp_etapaintermedia'=>$post->id,
              //       'idCausa'=>$idCausa,
              //       'idExpediente'=>$idExp,
              //       'MEDIOS_PRUEBAS'=>$value['MEDIOS']??'',
              //       'MEDIOS_PRUEBAS_PE'=>$value['MEDIOS_PE']??'',
              //       'ACUERDOS_REPARATORIOS'=>$value['REPARA']??'',                    
              //       'usuario'=>Auth::User()->id]);
              //     $bitEvUsu=biteventousario::create(
              //       ['idUsuario' => Auth::User()->id,
              //       'idExpediente' => $idExp,
              //       'idRegistro' => $actosEV->id,
              //       'idEvento' =>122,
              //       'Evento' => 'Insertar medios de prueba en Etapa intermedia']);
              //   }
              // }
              $routeid=$idCausa;
            // }
            // else
            // {
            //   $cp_ei=causas_penales\cp_etapaintermedia::where('idCausa',$idCausa)->first();
            //   if (isset($cp_ei)) {
            //   $post=causas_penales\cp_ei_imputados::updateOrCreate(['id'=>$request->idImputadoEI],
            //     ['idcp_etapaintermedia'=>$cp_ei->id,
            //     'idCausa'=>$idCausa,
            //     'idExpediente'=>$idExp,
            //     'idImputado'=>$request->idImputado,
            //     'FECHA_SOBRESEIMIENTO'=>$request->causa_H_fecha_sobreseimiento, 
            //     'CAUSAS_SOBRESEIMIENTO'=>$request->causa_H_causas_sobreseimiento, 
            //     'TIPO_SOBRESEIMIENTO'=>$request->causa_H_tipo_sobreseimiento, 
            //     // 'ACUERDO_REPARATORIO'=>$request->causa_H_acuerdo_reparatorio, 
            //     // 'FECHA_CUMPLIMIENTO'=>$request->causa_H_fecha_cumplimiento,
            //     // 'FECHA_ACUERDOS_REPARATORIOS'=>$request->causa_H_fecha_acuerdos_reparatorios, 
            //     // 'ACUERDOS_REPARATORIOS'=>$request->causa_H_acuerdos_reparatorios, 
            //     // 'MONTO_REP_DAÑO'=>$request->causa_H_monto_rep_daño, 
            //     //'CONDICION_IMPUESTA'=>$request->causa_H_condicion_impuesta, 
            //     // 'TEMPORALIDAD'=>$request->causa_H_temporalidad, 
            //     // 'REPARACION_DEL_DAÑO'=>$request->causa_H_reparacion_del_daño_, 
            //     // 'TEMPORALIDAD_SALIDAD_ALTERNAS'=>$request->causa_H_temporalidad_salidad_alternas, 
            //     ]);
            //   $bitEvUsu=biteventousario::create(
            //     ['idUsuario' => Auth::User()->id,
            //     'idExpediente' => $idExp,
            //     'idRegistro' => $post->id,
            //     'idEvento' => $post->wasRecentlyCreated ?44:45,
            //     'Evento' => $post->wasRecentlyCreated ?'Insertar Imputado de Etapa intermedia':'Actualizar Imputado de Etapa intermedia']);
                
            //   $upd=causas_penales\cp_dg_imputados::where('id',$request->idImputado)->firstOrFail();
            //   $upd->cp_ei=1;
            //   $upd->save();
            //   }
            //   $routeid=$idCausa;
            // }
           break;
           case 'd0jo'://////CAUSAS PENALES JUICIO ORAL           
            // if (!isset($request->idImputadoJO)) {
              $post = causas_penales\cp_juiciooral::updateOrCreate(['idCausa'=>$idCausa,'idExpediente'=>$idExp],);

              $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $idExp,
                'idRegistro' => $post->id,
                'idEvento' => $post->wasRecentlyCreated ?46:47,
                'Evento' => $post->wasRecentlyCreated ?'Insertar Causa Penal - Juicio oral':'Actualizar Causa Penal - Juicio oral']);
              if ($request->frmSecc=='P') {
                if (strlen($request['hdnPruebas'.$request->idImputadoJO])>0) {
                  foreach (json_decode("[".rtrim($request['hdnPruebas'.$request->idImputadoJO],",")."]",true) as $key => $value) {
                    $pruebaJO=causas_penales\cp_jo_pruebas::create(
                      ['id_cp_juiciooral'=>$post->id,                    
                      'idCausa'=>$idCausa,'idExpediente'=>$idExp,
                      'idImputado'=>$request->idImputado,
                      'FECHA_PRUEBAS'=>$value['FECHA']??'',
                      'TIPOS_DE_PRUEBAS'=>$value['PRUEBA']??'',
                      'ACTOR_PRUEBAS'=>$value['ACTOR']??'',
                      'CANTIDAD'=>$value['CANTIDAD']??'',
                      'usuario'=>Auth::User()->id]);
                    $bitEvUsu=biteventousario::create(
                      ['idUsuario' => Auth::User()->id,
                      'idExpediente' => $idExp,
                      'idRegistro' => $pruebaJO->id,
                      'idEvento' =>48,
                      'Evento' => 'Insertar prueba de Juicio oral']);
                  }
                }
              }

              if ($request->frmSecc=='S') {
                if (strlen($request['hdnSuspension'.$request->idImputadoJO])>0) {
                  foreach (json_decode("[".rtrim($request['hdnSuspension'.$request->idImputadoJO],",")."]",true) as $key => $value) {
                    $suspensionJO=causas_penales\cp_jo_suspension::create(
                      ['id_cp_juiciooral'=>$post->id,
                      'idCausa'=>$idCausa,'idExpediente'=>$idExp,
                      'idImputado'=>$request->idImputado,
                      'FECHA_SUSPENSION'=>$value['FECHA']??'',
                      'CAUSAS_SUSPENSION'=>$value['SUSPENSION']??'',
                      'REANUDACION_JUICIO'=>$value['REANUDACION']??'',
                      'usuario'=>Auth::User()->id]);
                    $bitEvUsu=biteventousario::create(
                      ['idUsuario' => Auth::User()->id,
                      'idExpediente' => $idExp,
                      'idRegistro' => $suspensionJO->id,
                      'idEvento' =>91,
                      'Evento' => 'Insertar causas de suspensión de Juicio oral']);
                  }
                }
              }
              // $routeid=$idCausa; 
            // }
            // else
            // {
              // $cp_jo=causas_penales\cp_juiciooral::where('idCausa',$idCausa)->first();
              
              // if (isset($cp_jo)) {
              if ($request->frmSecc=='N') {
                $postIM = causas_penales\cp_jo_imputados::updateOrCreate(['id' => $request->idImputadoJO],
                  ['idImputado'=>$request->idImputado, 
                  'idCausa'=>$idCausa,
                  'idExpediente'=>$idExp,
                  'id_cp_juiciooral'=>$post->id,
                    // 'JUICIO_ORAL'=>$request->causa_H_juicio_oral,
                    // 'AUTO_DE_APERTURA'=>$request->causa_H_auto_de_apertura,
                    // 'FECHA_AUDIENCIA_JUICIO'=>$request->causa_H_fecha_audiencia_juicio,
                    // 'SUSPENSION_JUICIO'=>$request->causa_H_suspension_juicio,
                    // 'CAUSAS_SUSPENSION'=>$request->causa_H_causas_suspension,
                  'FECHA_SENTENCIA'=>$request->causa_H_fecha_sentencia,
                  'LIBERTAD_CONDICIONAL'=>$request->causa_H_libertad_condicional,
                  'TIPO_SENTENCIA'=>$request->causa_H_tipo_sentencia,
                  'OBSERVACIONES'=>$request->causa_H_observaciones,
                  'SENTENCIA_CONDENATORIA'=>$request->causa_H_sentencia_condenatoria,
                  'FIRME'=>$request->causa_H_firme,
                  'TIEMPO'=>$request->causa_H_tiempo,
                    // 'FECHA_PROCED_ABREV'=>$request->causa_H_fecha_proced_abrev,
                    // 'FECHA_RECURSO'=>$request->causa_H_fecha_recurso,
                    // 'TIPO_DE_RECURSO'=>$request->causa_H_tipo_de_recurso,
                    // 'RESOLUCION_DEL_RECURSO'=>$request->causa_H_resolucion_del_recurso,
                  ]);
                $total_anios=0;
                $Exp = causas_penales\cp_mc_medidas::leftjoin('procp_medidascautelares  as pai',
                'procp_mc_medidas.id_cp_medidascautelares','=','pai.id')
                ->where('pai.idImputado',$request->idImputado)->first();
                
                $prision=causas_penales\cp_mc_medidas::where('id_cp_medidascautelares',$Exp->id_cp_medidascautelares??0)
                ->whereIn('TIPO_MEDIDAS_CAUTELARES',[14,15,16])
                ->select(DB::raw("FLOOR(IFNULL((SUM(TEMPORALIDAD_MEDIDA_D)/365.25)+(SUM(TEMPORALIDAD_MEDIDA_M)/12)+SUM(TEMPORALIDAD_MEDIDA_A),0)) as tiempo"))
                ->first();
                if ($prision) {
                  $total_anios = $prision->tiempo;
                    // $tiempo contiene el resultado de la consulta
                    // Puedes usar $tiempo como necesites
                }
                 $total_anios=floor($total_anios);
                 $tiempo=causas_penales\cp_jo_imputados::where('idImputado',$request->idImputado)->update(['TIEMPO'=>$total_anios]);
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $postIM->id,
                  'idEvento' => $postIM->wasRecentlyCreated ?124:125,
                  'Evento' => $postIM->wasRecentlyCreated ?'Insertar Imputado de Juicio Oral':'Actualizar Imputado de Juicio Oral']);
                    // if (strlen($request['hdnRecursos'.$request->idImputadoJO])>0) {
                    //   foreach (json_decode("[".rtrim($request['hdnRecursos'.$request->idImputadoJO],",")."]",true) as $key => $value) {
                    //     $recursosJO=causas_penales\cp_jo_recursos::create(
                    //       ['id_cp_juiciooral'=>$post->id,
                    //       'FECHA_RECURSO'=>$value['FECHA']??'',
                    //       'TIPO_DE_RECURSO'=>$value['TIPO']??'',
                    //       'RESOLUCION_DEL_RECURSO'=>$value['RESOLUCION']??'',
                    //       'usuario'=>Auth::User()->id]);
                    //     $bitEvUsu=biteventousario::create(
                    //       ['idUsuario' => Auth::User()->id,
                    //       'idExpediente' => $idExp,
                    //       'idRegistro' => $recursosJO->id,
                    //       'idEvento' =>92,
                    //       'Evento' => 'Insertar recursos de Juicio oral']);
                    //   }
                    // }
                $upd=causas_penales\cp_dg_imputados::where('id',$request->idImputado)->firstOrFail();
                $upd->cp_jo=1;
                $upd->save();
              // }
              }
              $routeid=$idCausa;
            // }      
           break;
           case 'd0re'://////CAUSAS PENALES RECURSOS

                $post = causas_penales\cp_recursos::updateOrCreate(['id' => $request->idImputadoJO],
                    ['idImputado'=>$request->idImputado, 
                    'idCausa'=>$idCausa,
                    'idExpediente'=>$idExp,                    
                  ]);

                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $post->id,
                  'idEvento' => $post->wasRecentlyCreated ?126:127,
                  'Evento' => $post->wasRecentlyCreated ?'Insertar Imputado de Recursos':'Actualizar Imputado de Recursos']);
                if (strlen($request['hdnRecursos'.$request->idImputadoJO])>0) {
                  foreach (json_decode("[".rtrim($request['hdnRecursos'.$request->idImputadoJO],",")."]",true) as $key => $value) {
                    $recursosJO=causas_penales\cp_re_recursos::create(
                      ['id_cp_recursos'=>$post->id,
                      'FECHA_RECURSO'=>$value['FECHA']??'',
                      'TIPO_DE_RECURSO'=>$value['TIPO']??'',
                      'RESOLUCION_DEL_RECURSO'=>$value['RESOLUCION']??'',
                      'usuario'=>Auth::User()->id]);
                    $bitEvUsu=biteventousario::create(
                      ['idUsuario' => Auth::User()->id,
                      'idExpediente' => $idExp,
                      'idRegistro' => $recursosJO->id,
                      'idEvento' =>92,
                      'Evento' => 'Insertar recursos de Recursos']);
                  }
                }
                // $upd=causas_penales\cp_dg_imputados::where('id',$request->idImputado)->firstOrFail();
                // $upd->cp_jo=1;
                // $upd->save();
              
              $routeid=$idCausa;           
           break;

           case 'e3ev'://////DATOS EXPEDIENTE - ETAPA INVESTIGACIÓN            

            if (!isset($request->idImputadoEN) && !isset($request->idVictimaEN)) {
              $post = datos_expediente\de_etapainvestigacion::updateOrCreate(['idExpediente'=>$idExp],);
              $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $idExp,
                'idRegistro' => $post->id,
                'idEvento' => $post->wasRecentlyCreated ?144:145,
                'Evento' => $post->wasRecentlyCreated ?'Insertar Datos Expediente - Etapa Investigación':'Actualizar Datos Expediente - Etapa Investigacion']);
              
              if (strlen($request['hdnActos'])>0) {
                foreach (json_decode("[".rtrim($request['hdnActos'],",")."]",true) as $key => $value) {
                  $actosEV=datos_expediente\de_ev_actos::create(
                    ['id_de_etapainvestigacion'=>$post->id,
                    'idExpediente'=>$idExp,
                    'FECHA_ACTOS_DE_INV'=>$value['FECHA']??'',
                    'TIPO_CONTROL_ACTOS_DE_INV'=>$value['CONTROL']??'',
                    'TIPO_ACTOS_DE_INV'=>$value['TIPO']??'',
                    'OBSERVACIONES_ACTOS_DE_INV'=>$value['OBSERVACION']??'',
                    'usuario'=>Auth::User()->id]);
                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $idExp,
                    'idRegistro' => $actosEV->id,
                    'idEvento' =>133,
                    'Evento' => 'Insertar actos de investigación en Datos Expediente - Etapa investigación']);
                }
              }
              $routeid=$idExp;
            }
            else
            {
              $post = datos_expediente\de_etapainvestigacion::updateOrCreate(['idExpediente'=>$idExp],);
              $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $idExp,
                'idRegistro' => $post->id,
                'idEvento' => $post->wasRecentlyCreated ?134:135,
                'Evento' => $post->wasRecentlyCreated ?'Insertar Datos Expediente - Etapa Investigación':'Actualizar Datos Expediente - Etapa Investigacion']);

              if (isset($request->idImputadoEN)) {
                $cp_en=datos_expediente\de_etapainvestigacion::where('idExpediente',$idExp)->first();
                if (isset($cp_en)) {
                  switch ($request->frmSecc) {
                    case 'F':
                      $post=datos_expediente\de_ev_imputados::updateOrCreate(['id'=>$request->idImputadoEN],
                        ['id_de_etapainvestigacion'=>$cp_en->id,
                        'idImputado'=>$request->idImputado,
                        'idExpediente'=>$idExp,
                        
                        'FECHA_DETENCION'=>$request->causa_H_fecha_detencion,  
                        'DETENCION_LEGAL'=>$request->causa_H_detencion_legal,
                        'usuario'=>Auth::User()->id,                 
                        ]);
                      break;
                    case 'M':
                      $post=datos_expediente\de_ev_imputados::updateOrCreate(['id'=>$request->idImputadoEN],
                        ['id_de_etapainvestigacion'=>$cp_en->id,
                        'idImputado'=>$request->idImputado,
                        'idExpediente'=>$idExp,
                          // 'SOLICITUD_DE_MANDAMIENTO_JUDICIAL'=>$request->causa_H_solicitud_de_mandamiento_judicial,
                          // 'TIPO_MANDAMIENTO'=>$request->causa_H_tipo_mandamiento,
                          // 'FECHA_LIBERA'=>$request->causa_H_fecha_libera,
                          // 'ESTATUS_MANDAMIENTO'=>$request->causa_H_estatus_mandamiento,
                          // 'FECHA_MANDAMIENTO'=>$request->causa_H_fecha_mandamiento,
                        'usuario'=>Auth::User()->id,                 
                        ]);
                        
                        if (strlen($request['hdnMandamientos'.$request->idImputadoEN])>0) {
                          foreach (json_decode("[".rtrim($request['hdnMandamientos'.$request->idImputadoEN],",")."]",true)
                          as $key => $value){                      
                            $medidasAI=datos_expediente\de_ev_mandamientos::create(
                              ['id_de_ev_imputados'=>$post->id,
                              'idImputado'=>$request->idImputado,
                              'idExpediente'=>$idExp,

                              'SOLICITUD_DE_MANDAMIENTO_JUDICIAL'=>$value['FSOLICITUD']??'',
                              'TIPO_MANDAMIENTO'=>$value['TIPO']??'',
                              'FECHA_LIBERA'=>$value['FLIBRAMINETO']??'',
                              'ESTATUS_MANDAMIENTO'=>$value['ESTATUS']??'',
                              'FECHA_MANDAMIENTO'=>$value['FMANDAMIENTO']??'',                              
                              'usuario'=>Auth::User()->id]);
                            $bitEvUsu=biteventousario::create(
                              ['idUsuario' => Auth::User()->id,
                              'idExpediente' => $idExp,
                              'idRegistro' => $medidasAI->id,
                              'idEvento' =>136,
                              'Evento' => 'Insertar mandamientos de Imputado en Datos Expediente - Etapa Investigación']);
                          }
                        }
                      break;
                    case 'A':
                      $post=datos_expediente\de_ev_imputados::updateOrCreate(['id'=>$request->idImputadoEN],
                        ['id_de_etapainvestigacion'=>$cp_en->id,
                        'idImputado'=>$request->idImputado,
                        'idExpediente'=>$idExp,

                        'AUDIENCIA_DE_GARANTIAS'=>$request->causa_H_audiencia_de_garantias, 
                        'PROMOVIDA_POR'=>$request->causa_H_promovida_por, 
                        'RESULTADO_AUDIENCIA_DE_GARANTIAS'=>$request->causa_H_resultado_audiencia_de_garantias, 
                        'FECHA_CITA'=>$request->causa_H_fecha_cita,                         
                        'usuario'=>Auth::User()->id,                 
                        ]);
                      break;
                    case 'C':
                      $post=datos_expediente\de_ev_imputados::updateOrCreate(['id'=>$request->idImputadoEN],
                        ['id_de_etapainvestigacion'=>$cp_en->id,
                        'idImputado'=>$request->idImputado,
                        'idExpediente'=>$idExp,
                          // 'AUDIENCIA_DE_GARANTIAS'=>$request->causa_H_audiencia_de_garantias, 
                          // 'PROMOVIDA_POR'=>$request->causa_H_promovida_por, 
                          // 'RESULTADO_AUDIENCIA_DE_GARANTIAS'=>$request->causa_H_resultado_audiencia_de_garantias, 
                          // 'FECHA_CITA'=>$request->causa_H_fecha_cita, 
                          //// 'SOLICITUD_DE_ORDEN_DE_APREHENSION'=>$request->causa_H_solicitud_de_orden_de_aprehension, 
                          //// 'OA_SIN_EFECTO'=>$request->causa_H_oa_sin_efecto, 
                          //// 'OA_NEGADA'=>$request->causa_H_oa_negada, 
                          //// 'OA_CUMPLIDA'=>$request->causa_H_oa_cumplida, 
                          //// 'ORDEN_DE_COMPARECENCIA_GIRADA'=>$request->causa_H_orden_de_comparecencia_girada, 
                          //// 'ORDEN_DE_COMPARECENCIA_NEGADA'=>$request->causa_H_orden_de_comparecencia_negada,
                          //// 'FORMA_PROCESO'=>$request->causa_H_forma_proceso,
                          // 'FECHA_DETENCION'=>$request->causa_H_fecha_detencion,  
                          // 'DETENCION_LEGAL'=>$request->causa_H_detencion_legal,
                        'CASO_URGENTE_FECHA_LIBRAMIENTO'=>$request->causa_H_caso_urgente_fecha_libramiento,
                        'CASO_URGENTE_ESTATUS'=>$request->causa_H_caso_urgente_estatus,
                        'CASO_URGENTE_FECHA_CUMPLIMIENTO'=>$request->causa_H_caso_urgente_fecha_cumplimiento,
                          // 'SOLICITUD_DE_MANDAMIENTO_JUDICIAL'=>$request->causa_H_solicitud_de_mandamiento_judicial,
                          // 'TIPO_MANDAMIENTO'=>$request->causa_H_tipo_mandamiento,
                          // 'FECHA_LIBERA'=>$request->causa_H_fecha_libera,
                          // 'ESTATUS_MANDAMIENTO'=>$request->causa_H_estatus_mandamiento,
                          // 'FECHA_MANDAMIENTO'=>$request->causa_H_fecha_mandamiento,
                        'usuario'=>Auth::User()->id,                 
                        ]);
                      break;                                                                
                    default:
                      break;
                  }

                  $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $idExp,
                  'idRegistro' => $post->id,
                  'idEvento' => $post->wasRecentlyCreated ?137:138,
                  'Evento' => $post->wasRecentlyCreated ?'Insertar Vícitma de Datos Expediente - Etapa Investigación':'Actualizar Vícitma de Datos Expediente - Etapa Investigación']);                
                  if (strlen($request['hdnActos_con'.$request->idImputadoEN])>0) {
                    foreach (json_decode("[".rtrim($request['hdnActos_con'.$request->idImputadoEN],",")."]",true)
                    as $key => $value){                      
                      $medidasAI=datos_expediente\de_ev_actosconsin::create(
                        ['id_de_ev_imputados'=>$post->id,
                        'idImputado'=>$request->idImputado,
                        'idExpediente'=>$idExp,                          
                        'TIPO_ACTOS_CONSIN'=>$value['ACTO']??'',
                        'CONSIN'=>'con',
                        'usuario'=>Auth::User()->id]);
                      $bitEvUsu=biteventousario::create(
                        ['idUsuario' => Auth::User()->id,
                        'idExpediente' => $idExp,
                        'idRegistro' => $medidasAI->id,
                        'idEvento' =>139,
                        'Evento' => 'Insertar acto con control judicial en Datos Expediente - Etapa Investigación']);
                    }
                  }
                  if (strlen($request['hdnActos_sin'.$request->idImputadoEN])>0) {
                    foreach (json_decode("[".rtrim($request['hdnActos_sin'.$request->idImputadoEN],",")."]",true)
                    as $key => $value){                      
                      $medidasAI=datos_expediente\de_ev_actosconsin::create(
                        ['id_de_ev_imputados'=>$post->id,
                        'idImputado'=>$request->idImputado,
                        'idExpediente'=>$idExp,                          
                        'TIPO_ACTOS_CONSIN'=>$value['ACTO']??'',
                        'CONSIN'=>'sin',
                        'usuario'=>Auth::User()->id]);
                      $bitEvUsu=biteventousario::create(
                        ['idUsuario' => Auth::User()->id,
                        'idExpediente' => $idExp,
                        'idRegistro' => $medidasAI->id,
                        'idEvento' =>140,
                        'Evento' => 'Insertar acto sin control judicial de Vícitma en Datos Expediente - Etapa Investigación']);
                    }
                  }
                }
                $routeid=$idExp;                
              }
              else if (isset($request->idVictimaEN)) {
                $cp_en=datos_expediente\de_etapainvestigacion::where('idExpediente',$idExp)->first();
                if (isset($cp_en)) {
                  $post=datos_expediente\de_ev_victimas::updateOrCreate(['id'=>$request->idVictimaEN],
                    ['id_de_etapainvestigacion'=>$cp_en->id,
                    'idVictima'=>$request->idVictima,
                    'idExpediente'=>$idExp, 
                    'usuario'=>Auth::User()->id,                 
                    ]);
                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $idExp,
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?141:142,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Vícitma de Datos Expediente - Etapa Investigación':'Actualizar Vícitma de Datos Expediente - Etapa Investigación']);                
                  if (strlen($request['hdnMedidas'.$request->idVictimaEN])>0) {
                    foreach (json_decode("[".rtrim($request['hdnMedidas'.$request->idVictimaEN],",")."]",true)
                    as $key => $value){                      
                      $medidasAI=datos_expediente\de_ev_medidas::create(
                        ['id_de_ev_victimas'=>$post->id,
                        'idVictima'=>$request->idVictima,
                        'idExpediente'=>$idExp,                          
                        'TIPO_DE_MEDIDA'=>$value['TIPO']??'',
                        'TEMPORALIDAD_DE_LA_MEDIDA'=>$value['TEMPORALIDAD']??'',
                        'MEDIDA_IMPUESTA_POR'=>$value['IMPUESTA']??'',
                        'usuario'=>Auth::User()->id]);
                      $bitEvUsu=biteventousario::create(
                        ['idUsuario' => Auth::User()->id,
                        'idExpediente' => $idExp,
                        'idRegistro' => $medidasAI->id,
                        'idEvento' =>143,
                        'Evento' => 'Insertar medida de Vícitma en Datos Expediente - Etapa Investigación']);
                    }
                  }
                }
                $routeid=$idExp;
              }
            }
            return redirect()->route("dash",[$request->Ctrl,$routeid]);
           break;           
        }   
        return redirect()->route("dash",[$request->Ctrl,$idExp,$routeid]);
      }
    }

    public function Guardar(Request $request)
    {
      if(is_null(Auth::User())) { return redirect("Salir"); }
      else
      {
        foreach ($request->except(['_token','Ctrl','idExp']) as $key => $value) {
             $request[$key]=strtoupper($value);
         }
        $routeid = 0;
        switch ($request->Ctrl) {
          #region Datos Expediente
            case 'e3':  //////DATOS GENERALES  
                $idExp=hex2bin($request->idExp);
                $exploded=explode('/',$request->expediente_nuc??'');

                if ($idExp==0) {
                  $post = datos_expediente\de_datosgenerales::updateOrCreate(['id' => $idExp],
                    ['DELEGACION' => $request->expediente_delegacion
                    , 'MUNICIPIO' => $request->expediente_municipio
                    , 'UNIDAD_ATENCION' => $request->expediente_unidad_atencion
                    , 'FECHA_INICIO_CARPETA' => $request->expediente_fecha_inicio_carpeta
                    , 'HORA_APERTURA_CARPETA' => $request->expediente_hora_apertura_carpeta
                    , 'NUC' => end($exploded)
                    , 'NUC_COMPLETA'=>$request->expediente_nuc
                    , 'NO_EXPEDIENTE' => $request->expediente_numero_expediente
                    , 'ESTATUS_CARPETA' => $request->expediente_H_estatus_carpeta
                    //, 'AGENTE_ID' => $request->expediente_H_agente_id
                    , 'NOMBRE_FISCALIA' => $request->expediente_H_nombre_fiscalia
                    //, 'NOMBRE_AGENTE_MP' => $request->expediente_H_nombre_agente_mp
                    //, 'MP_NOM' => $request->expediente_H_mp_nom
                    //, 'MP_NUM' => $request->expediente_H_mp_num
                    //, 'CARPETA_ID' => null
                    //, 'TIPO_MP' => $request->expediente_H_tipo_mp
                    , 'TIPO_FISCALIA' => $request->expediente_H_tipo_fiscalia
                    , 'UBICACION_MP' => $request->expediente_H_ubicacion_mp
                    // , 'ID_SEGUIMIENTO' => $request->expediente_H_id_seguimiento
                    , 'FECHA_HECHOS' => $request->expediente_fecha_hechos
                    , 'HORA_HECHOS' => $request->expediente_hora_hechos
                    , 'ENTIDAD_HECHOS' => $request->expediente_entidad_hechos
                    , 'MUNICIPIO_HECHOS' => $request->expediente_municipio_hechos
                    , 'COLONIA_HECHOS' => $request->expediente_colonia_hechos
                    , 'CALLE_HECHOS' => $request->expediente_calle_hechos
                    , 'CP' => $request->expediente_CP
                    , 'REF_1' => $request->expediente_ref_1
                    , 'REF_2' => $request->expediente_ref_2
                    , 'RECIBIDA_POR' => $request->expediente_recibida_por
                    , 'UNIDAD_QUE_RECIBE' => $request->expediente_unidad_que_recibe
                    , 'MEDIO_RECEPCION' => $request->expediente_medio_recepcion
                    , 'TIPO_RECEPCION' => $request->expediente_tipo_recepcion
                    , 'AUTORIDAD' => $request->expediente_H_autoridad
                    , 'AUTORIDAD_IPH' =>$request->expediente_autoridad_iph
                    , 'HORA_DENUNCIA' => $request->expediente_H_hora_denuncia
                    //, 'PARENTESCO' => $request->expediente_parentesco
                    , 'FORMA_' => $request->expediente_H_forma_
                    , 'ASEGURAMIENTO' => $request->expediente_H_aseguramiento
                    , 'TIPO_DE_BIEN' => $request->expediente_H_tipo_de_bien
                    , 'OPORTUNIDAD' => $request->expediente_H_oportunidad
                    , 'ETAPA_PROCES' => $request->expediente_H_etapa_proces
                    , 'MEDIO_DE_CONOCIMIENTO' => $request->expediente_H_medio_de_conocimiento
                    , 'FECHA_DENUNCIA' => $request->expediente_H_fecha_denuncia
                    , 'REACTIVACION' => $request->expediente_H_reactivacion
                    , 'MOTIVO_REACTIVACION'=>$request->causa_H_motivo_reactivacion
                    , 'DESCRIPCION' => $request->expediente_descripcion
                    , 'OBSERVACIONES' => $request->expediente_H_observaciones]);
                }
                else
                {
                  $post = datos_expediente\de_datosgenerales::updateOrCreate(['id' => $idExp],
                    ['DELEGACION' => $request->expediente_delegacion
                    , 'MUNICIPIO' => $request->expediente_municipio
                    , 'UNIDAD_ATENCION' => $request->expediente_unidad_atencion
                    , 'FECHA_INICIO_CARPETA' => $request->expediente_fecha_inicio_carpeta
                    , 'HORA_APERTURA_CARPETA' => $request->expediente_hora_apertura_carpeta
                    //, 'NUC' => end($exploded)
                    //, 'NUC_COMPLETA'=>$request->expediente_nuc
                    , 'NO_EXPEDIENTE' => $request->expediente_numero_expediente
                    , 'ESTATUS_CARPETA' => $request->expediente_H_estatus_carpeta
                    //, 'AGENTE_ID' => $request->expediente_H_agente_id
                    , 'NOMBRE_FISCALIA' => $request->expediente_H_nombre_fiscalia
                    //, 'NOMBRE_AGENTE_MP' => $request->expediente_H_nombre_agente_mp
                    //, 'MP_NOM' => $request->expediente_H_mp_nom
                    //, 'MP_NUM' => $request->expediente_H_mp_num
                    //, 'CARPETA_ID' => null
                    //, 'TIPO_MP' => $request->expediente_H_tipo_mp
                    , 'TIPO_FISCALIA' => $request->expediente_H_tipo_fiscalia
                    , 'UBICACION_MP' => $request->expediente_H_ubicacion_mp
                    // , 'ID_SEGUIMIENTO' => $request->expediente_H_id_seguimiento
                    , 'FECHA_HECHOS' => $request->expediente_fecha_hechos
                    , 'HORA_HECHOS' => $request->expediente_hora_hechos
                    , 'ENTIDAD_HECHOS' => $request->expediente_entidad_hechos
                    , 'MUNICIPIO_HECHOS' => $request->expediente_municipio_hechos
                    , 'COLONIA_HECHOS' => $request->expediente_colonia_hechos
                    , 'CALLE_HECHOS' => $request->expediente_calle_hechos
                    , 'CP' => $request->expediente_CP
                    , 'REF_1' => $request->expediente_ref_1
                    , 'REF_2' => $request->expediente_ref_2
                    , 'RECIBIDA_POR' => $request->expediente_recibida_por
                    , 'UNIDAD_QUE_RECIBE' => $request->expediente_unidad_que_recibe
                    , 'MEDIO_RECEPCION' => $request->expediente_medio_recepcion
                    , 'TIPO_RECEPCION' => $request->expediente_tipo_recepcion
                    , 'AUTORIDAD' => $request->expediente_H_autoridad
                    , 'AUTORIDAD_IPH' =>$request->expediente_autoridad_iph
                    , 'HORA_DENUNCIA' => $request->expediente_H_hora_denuncia
                    //, 'PARENTESCO' => $request->expediente_parentesco
                    , 'FORMA_' => $request->expediente_H_forma_
                    , 'ASEGURAMIENTO' => $request->expediente_H_aseguramiento
                    , 'TIPO_DE_BIEN' => $request->expediente_H_tipo_de_bien
                    , 'OPORTUNIDAD' => $request->expediente_H_oportunidad
                    , 'ETAPA_PROCES' => $request->expediente_H_etapa_proces
                    , 'MEDIO_DE_CONOCIMIENTO' => $request->expediente_H_medio_de_conocimiento
                    , 'FECHA_DENUNCIA' => $request->expediente_H_fecha_denuncia
                    , 'REACTIVACION' => $request->expediente_H_reactivacion
                    , 'MOTIVO_REACTIVACION'=>$request->causa_H_motivo_reactivacion
                    , 'DESCRIPCION' => $request->expediente_descripcion
                    , 'OBSERVACIONES' => $request->expediente_H_observaciones]);
                }
                    // $request->getQueryString());
                $upd=datos_expediente\de_datosgenerales::where('id', '=',$post->id)->firstOrFail();
                $upd->idExpediente=$post->id;
                $upd->save();

                $relUsuExp=relusuarioexpedientes::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $post->id,
                    'tabla' => 'prode_datosgenerales',
                    'Activo' => 1]);
                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $post->id,
                    'idRegistro' => 0,
                    'idEvento' => $post->wasRecentlyCreated ?1:2,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Expediente':'Actualizar Expediente']);

                $routeid = $post->id;
                break;
            case 'e3v': //////DATOS GENERALES VICTIMAS
                $id=$request->idVictima;

                $post = datos_expediente\de_victimas::updateOrCreate(['id' => $id],
                    ['idExpediente' => hex2bin($request->idExp),
                    'TIPO_VICTIMA' => $request->victima_tipo_victima,
                    'INTERPRETE' => $request->victima_interprete,
                    'DELITOS_VICTIMA' => $request->victima_delitos_victima,
                    'RAZON_SOCIAL' => strtoupper($request->victima_razon_social),
                    'REPRESENTANTE_LEGAL' => $request->victima_representante_legal,
                    'TIPO_REPRESENTANTE_LEGAL' => $request->victima_H_tipo_representante_legal,
                    'SECTOR_VICTIMAS' => $request->victima_sector_victimas,
                    'TIPO_PERSONA_VICTIMAS' => $request->victima_tipo_persona_victimas,
                    'NOMBRE_VICTIMA' => $request->victima_nombre_victima,
                    'PRIMER_APELLIDO' => $request->victima_primer_apellido,
                    'SEGUNDO_APELLIDO_VICTIMAS' => $request->victima_segundo_apellido_victimas,
                    'CURP_VICTIMAS' => $request->victima_curp_victimas,
                    'EDAD_HECHOS_VICTIMAS' => $request->victima_edad_hechos_victimas,
                    'SEXO_VICTIMA' => $request->victima_sexo_victima,
                    'SITUACION_CONYUGAL_VICTIMAS' => $request->victima_situacion_conyugal_victimas,
                    'NACIONALIDAD' => $request->victima_nacionalidad,
                    'SITUACION_MIGRATORIA_VICTIMAS' => $request->victima_situacion_migratoria_victimas,
                    'PAIS_NACIMIENTO' => $request->victima_pais_nacimiento,
                    'ENTIDAD_NACIMIENTO_VICTIMAS' => $request->victima_entidad_nacimiento_victimas,
                    'MUNICIPIO_NACIMIENTO' => $request->victima_municipio_nacimiento,
                    'PAIS_RESIDENCIA' => $request->victima_pais_residencia,
                    'ENTIDAD_RESIDENCIA_VICTIMAS' => $request->victima_entidad_residencia_victimas,
                    'MUNICIPIO_RESIDENCIA' => $request->victima_municipio_residencia,
                    'TELEFONO_VICTIMAS' => $request->victima_telefono_victimas,
                    'TRADUCTOR_VICTIMA' => $request->victima_traductor_victima,
                    'DISCAPACIDAD_VICTIMAS' => $request->victima_discapacidad_victimas,
                    'TIPO_DISCAPACIDAD_VICTIMAS' => $request->victima_tipo_discapacidad_victimas,
                    'INTERPRETE_POR_DISCAPACIDAD_VICTIMA' => $request->victima_interprete_por_discapacidad_victima,
                    'POBLACION_CALLE' => $request->victima_poblacion_calle,
                    'LEER_ESCRIBIR' => $request->victima_leer_escribir,
                    'ESCOLARIDAD' => $request->victima_escolaridad,
                    'OCUPACION' => $request->victima_ocupacion,
                    'SE_IDENTIFICA_INDIGENA_VICTIMA' => $request->victima_H_se_identifica_indigena_victima,
                    'POBLACION_INDIGENA_VICTIMA' => $request->victima_H_poblacion_indigena_victima,
                    'RELACION_IMPUTADO' => $request->victima_relacion_imputado,
                    'FECHA_NACIMIENTO_VICTIMAS' => $request->victima_fecha_nacimiento_victimas,
                    'ASESORIA' => $request->victima_asesoria,
                    'ATEN_MEDICA' => $request->victima_aten_medica,
                    'ATEN_PSICOLOGICA' => $request->victima_aten_psicologica,
                    'DOMICILIO_VICTIMA' => $request->victima_H_domicilio_victima,
                    // 'VICTIMA_ID' => $request->victima_H_victima_id,
                    'HABLA_ESPAÑOL_VICTIMA' => $request->victima_habla_español_victima,
                    'HABLA_LENG_EXTR_VICTIMA' => $request->victima_habla_leng_extr_victima,
                    'HABLA_LENG_INDIG_VICTIMA' => $request->victima_habla_leng_indig_victima,
                    'NUMERO_DE_ATENCION' => $request->victima_H_numero_de_atencion,
                    'INGRESO_VICTIMA' => $request->victima_H_ingreso_victima,
                    'TIPO_DE_ASESORIA' => $request->victima_tipo_de_asesoria,
                    'TIPO_LENGUA_EXTRANJERA_VICTIMA' => $request->victima_tipo_lengua_extranjera_victima,
                    'LENGUA_VICTIMA' => $request->victima_H_lengua_victima,
                    'VESTIMENTA_VICTIMA' => $request->victima_H_vestimenta_victima,
                    'VICTIMA_VIOLENCIA' => $request->victima_victima_violencia,
                      'DEF_FOLIO_DEFUNCION'=>$request->victima_def_folio_defuncion,
                      'DEF_FECHA_EXP'=>$request->victima_def_fecha_exp,
                      'DEF_FECHA_DEFUNCION'=>$request->victima_def_fecha_defuncion,
                      'DEF_TIPO_DEFUNCION'=>$request->victima_def_tipo_defuncion,
                      'DEF_CERTIFICADO_POR'=>$request->victima_def_certificado_por,
                      'DEF_SITIO_DEFUNCION'=>$request->victima_def_sitio_defuncion,
                      'DEF_SITIO_LESION'=>$request->victima_def_sitio_lesion,
                      'DEF_FUE_EN_EL_TRABAJO'=>$request->victima_def_fue_en_el_trabajo,
                      'DEF_AGENTE_EXTERNO'=>$request->victima_def_agente_externo,
                      'DEF_TIPO_EVENTO'=>$request->victima_def_tipo_evento,
                      'DEF_TIPO_VICTIMA'=>$request->victima_def_tipo_victima,
                      'DEF_TIPO_ARMA'=>$request->victima_def_tipo_arma,
                      'DEF_ENTIDAD_DENUNICA'=>$request->victima_def_entidad_denunica,
                      'DEF_MUNICIPIO_DENUNICA'=>$request->victima_def_municipio_denunica,
                      'DEF_COLONIA_DENUNICA'=>$request->victima_def_colonia_denunica,
                      'DEF_ENTIDAD_DEFUNCION'=>$request->victima_def_entidad_defuncion,
                      'DEF_MUNICIPIO_DEFUNCION'=>$request->victima_def_municipio_defuncion,
                      'DEF_COLONIA_DEFUNCION'=>$request->victima_def_colonia_defuncion,
                      'DEF_CAUSA_A'=>$request->victima_def_causa_a,
                      'DEF_DURACION_BCD'=>$request->victima_def_duracion_bcd,
                      'DEF_ESTADO_PATOLOGICO'=>$request->victima_def_estado_patologico,
                      'DEF_DURACION_PATOLOGICO'=>$request->victima_def_duracion_patologico,
                      'DEF_CONDICION_EMBARAZO'=>$request->victima_def_condicion_embarazo,
                      'DEF_PERIODO_POSPARTO'=>$request->victima_def_periodo_posparto,
                    ]);

                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?3:4,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Vícitma':'Actualizar Vícitma']);

                    $routeid = hex2bin($request->idExp);
                break;
            case 'e3i': //////DATOS GENERALES IMPUTADOS
                $id=$request->idImputado;

                $post = datos_expediente\de_imputados::updateOrCreate(['id' => $id],
                    ['idExpediente' => hex2bin($request->idExp),
                    'INTERPRETE' =>$request->imputado_interprete,
                    'TIPO_IMPUTADO' =>$request->imputado_tipo_imputado,
                    'RAZON_SOCIAL' =>$request->imputado_razon_social,
                    'REL_PERS_MORAL' =>$request->imputado_rel_pers_moral,
                    'SECTOR_IMPUTADOS' =>$request->imputado_sector_imputados,
                    'TIPO_PERSONA_IMPUTADOS' =>$request->imputado_tipo_persona_imputados,
                    'DELITOS_IMPUTADO' =>$request->imputado_delitos_imputado,
                    'ALIAS_IMPUTADO' =>$request->imputado_alias_imputado,
                    'RELACION_VICTIMA' =>$request->imputado_relacion_victima,
                    'NOMBRE_IMPUTADO' =>$request->imputado_nombre_imputado,
                    'PRIMER_APELLIDO' =>$request->imputado_primer_apellido,
                    'SEGUNDO_APELLIDO_IMPUTADOS' =>$request->imputado_segundo_apellido_imputados,
                    'CURP_IMPUTADOS' =>$request->imputado_curp_imputados,
                    'FECHA_NACIMIENTO_IMPUTADOS' =>$request->imputado_fecha_nacimiento_imputados,
                    'EDAD_HECHOS_IMPUTADOS' =>$request->imputado_edad_hechos_imputados,
                    'SEXO_IMPUTADO' =>$request->imputado_sexo_imputado,
                    'SITUACION_CONYUGAL_IMPUTADOS' =>$request->imputado_situacion_conyugal_imputados,
                    'NACIONALIDAD' =>$request->imputado_nacionalidad,
                    'SITUACION_MIGRATORIA_IMPUTADOS' =>$request->imputado_situacion_migratoria_imputados,
                    'PAIS_NACIMIENTO' =>$request->imputado_pais_nacimiento,
                    'ENTIDAD_NACIMIENTO_IMPUTADOS' =>$request->imputado_entidad_nacimiento_imputados,
                    'MUNICIPIO_NACIMIENTO' =>$request->imputado_municipio_nacimiento,
                    'PAIS_RESIDENCIA' =>$request->imputado_pais_residencia,
                    'ENTIDAD_RESIDENCIA_IMPUTADOS' =>$request->imputado_entidad_residencia_imputados,
                    'MUNICIPIO_RESIDENCIA' =>$request->imputado_municipio_residencia,
                    'TELEFONO_IMPUTADOS' =>$request->imputado_telefono_imputados,
                    'TRADUCTOR_IMPUTADO' =>$request->imputado_traductor_imputado,
                    'DISCAPACIDAD_IMPUTADOS' =>$request->imputado_discapacidad_imputados,
                    'TIPO_DISCAPACIDAD_IMPUTADOS' =>$request->imputado_tipo_discapacidad_imputados,
                    'INTERPRETE_POR_DISCAPACIDAD_IMPUTADO' =>$request->imputado_interprete_por_discapacidad_imputado,
                    'POBLACION_CALLE' =>$request->imputado_poblacion_calle,
                    'LEER_ESCRIBIR_IMPUTADOS' =>$request->imputado_leer_escribir_imputados,
                    'ESCOLARIDAD_IMPUTADO' =>$request->imputado_escolaridad_imputado,
                    'SE_IDENTIFICA_INDIGENA_IMPUTADO' =>$request->imputado_H_se_identifica_indigena_imputado,
                    'INDIGENA_IMPUTADO' =>$request->imputado_H_indigena_imputado,
                    'DETENIDO_IMPUTADOS' =>$request->imputado_detenido_imputados,
                    'ESTADO_IMPUTADO' =>$request->imputado_estado_imputado,
                    'FECHA_DETENCION' =>$request->imputado_fecha_detencion,
                    'HORA_DETENCION' =>$request->imputado_hora_detencion,
                    'TIPO_DETENCION' =>$request->imputado_tipo_detencion,
                    'ENTIDAD_DETENCION_IMPUTADOS' =>$request->imputado_entidad_detencion_imputados,
                    'AUTORIDAD_DETENCION_IMPUTADOS' =>$request->imputado_autoridad_detencion_imputados,
                    'FOLIO_RND' =>$request->imputado_folio_rnd,
                    'RAZON_RND' =>$request->imputado_razon_rnd,
                    'EXAMEN_DETENCION_IMPUTADOS' =>$request->imputado_examen_detencion_imputados,
                    'LESIONADO' =>$request->imputado_lesionado,
                    'ESTADO_PRESENTACION' =>$request->imputado_estado_presentacion,
                    'SITUACION_LIBERTAD' =>$request->imputado_situacion_libertad,
                    'ANTECEDENTES' =>$request->imputado_H_antecedentes,
                    'DEFENSA' =>$request->imputado_H_defensa,
                    'DOMICILIO_IMPUTADO' =>$request->imputado_H_domicilio_imputado,
                    'GRADO_DE_PARTICIPACION' =>$request->imputado_H_grado_de_participacion,
                    'HABLA_ESPAÑOL_IMPUTADO' =>$request->imputado_H_habla_español_imputado,
                    'HABLA_LENG_EXTR_IMPUTADO' =>$request->imputado_H_habla_leng_extr_imputado,
                    'HABLA_LENG_INDIG_IMPUTADO' =>$request->imputado_H_habla_leng_indig_imputado,
                    // 'IMPUTADO_ID' =>$request->imputado_H_imputado_id,
                    'MEDIA_FILIACION_IMPUTADO' =>$request->imputado_H_media_filiacion_imputado,
                    'NOMBRE_DE_GRUPO' =>$request->imputado_H_nombre_de_grupo,
                    'OCUPACION_IMPUTADO' =>$request->imputado_H_ocupacion_imputado,
                    'INGRESO_IMPUTADO' =>$request->imputado_H_ingreso_imputado,
                    'REPRESENTANTE_LEGAL' =>$request->imputado_representante_legal,
                    'TIPO_REPRESENTANTE_LEGAL' => $request->imputado_H_tipo_representante_legal,
                    'TIPO_DEFENSA' =>$request->imputado_H_tipo_defensa,
                    'TIPO_LENGUA_EXTRANJERA_IMPUTADO' =>$request->imputado_H_tipo_lengua_extranjera_imputado,
                    'LENGUA_IMPUTADO' =>$request->imputado_H_lengua_imputado,
                    'TIPO_MANDAMIENTO' =>$request->imputado_H_tipo_mandamiento,
                    'IMPUTADO_CONOCIDO' =>$request->imputado_H_imputado_conocido,
                    'AUDIENCIA_DE_GARANTIAS'=>$request->causa_H_audiencia_de_garantias,
                    'PROMOVIDA_POR'=>$request->causa_H_promovida_por,
                    'RESULTADO_AUDIENCIA_DE_GARANTIAS'=>$request->causa_H_resultado_audiencia_de_garantias,
                    'FECHA_CITA'=>$request->causa_H_fecha_cita,
                    'PREVIO_A_CAUSA'=>$request->causa_H_previo_a_causa, ]);

                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?5:6,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Imputado':'Actualizar Imputado']);

                    $routeid = hex2bin($request->idExp);
                break;
            case 'e3d': //////DATOS GENERALES DELITOS
                $id=$request->idDelito;

                $post = datos_expediente\de_hechos::updateOrCreate(['id' => $id],
                    ['idExpediente' => hex2bin($request->idExp),
                    'DELITO' => $request->Delitos_delito_especifico,
                    'DELITO_JUR' => $request->Delitos_delito_JUR,
                    'CONSUMACION' => $request->Delitos_consumacion,
                    'MODALIDAD' => $request->Delitos_modalidad,
                    'INSTRUMENTO' => $request->Delitos_instrumento,
                    'FUERO' => $request->Delitos_fuero,
                    'TIPO_SITIO_OCURRENCIA' => $request->Delitos_tipo_sitio_ocurrencia,
                    'CALIFICACION' => $request->Delitos_calificacion,
                    'COMISION' => $request->Delitos_comision,
                    'CONTEXTO' => $request->Delitos_H_contexto,
                    'FORMA_ACCION' => $request->Delitos_H_forma_accion ]);

                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?7:8,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Delito':'Actualizar Imputado']);

                $routeid = hex2bin($request->idExp);
                break;
            case 'e3o': //////DATOS GENERALES OBJETOS
                $id=$request->idObjeto;

                $post = datos_expediente\de_objetos::updateOrCreate(['id' => $id],
                    ['idExpediente' => hex2bin($request->idExp),
                    'OBJETO_1' => $request->objeto_objeto_1,
                    'DESC_OBJ_1' => $request->objeto_desc_obj_1,
                    'CANT_OBJ_1' => $request->objeto_cant_obj_1,
                    'VALOR_OBJ_1' => $request->objeto_valor_obj_1,
                    'ESTATUS_OBJ_1' => $request->objeto_estatus_obj_1,
                    'OBJETO_2' => $request->objeto_objeto_2,
                    'DESC_OBJ_2' => $request->objeto_desc_obj_2,
                    'CANT_OBJ_2' => $request->objeto_cant_obj_2,
                    'VALOR_OBJ_2' => $request->objeto_valor_obj_2,
                    'ESTATUS_OBJ_2' => $request->objeto_estatus_obj_2,
                    'OBJETO_3' => $request->objeto_objeto_3,
                    'DESC_OBJ_3' => $request->objeto_desc_obj_3,
                    'CANT_OBJ_3' => $request->objeto_cant_obj_3,
                    'VALOR_OBJ_3' => $request->objeto_valor_obj_3,
                    'ESTATUS_OBJ_3' => $request->objeto_estatus_obj_3,
                    'TIPO_NARCOTICO_1' => $request->objeto_tipo_narcotico_1,
                    'PRESENTACION_NARCO_1' => $request->objeto_presentacion_narco_1,
                    'CANTIDAD_NARCO_1' => $request->objeto_cantidad_narco_1,
                    'GRAMAJE_NARCO_1' => $request->objeto_gramaje_narco_1,
                    'TIPO_NARCOTICO_2' => $request->objeto_tipo_narcotico_2,
                    'PRESENTACION_NARCO_2' => $request->objeto_presentacion_narco_2,
                    'CANTIDAD_NARCO_2' => $request->objeto_cantidad_narco_2,
                    'GRAMAJE_NARCO_2' => $request->objeto_gramaje_narco_2,
                    'TIPO_NARCOTICO_3' => $request->objeto_tipo_narcotico_3,
                    'PRESENTACION_NARCO_3' => $request->objeto_presentacion_narco_3,
                    'CANTIDAD_NARCO_3' => $request->objeto_cantidad_narco_3,
                    'GRAMAJE_NARCO_3' => $request->objeto_gramaje_narco_3,
                    'ESTATUS' => $request->objeto_estatus,
                    'FECHA_ASEGURADO'=> $request->objeto_estatus == 1 ? $request->objeto_fecha_asegurado : DB::raw('FECHA_ASEGURADO'),
                    'FECHA_DEVUELTO'=> $request->objeto_estatus == 2 ? $request->objeto_fecha_devuelto : DB::raw('FECHA_DEVUELTO'),
                    'FECHA_ROBADO'=> $request->objeto_estatus == 3 ? $request->objeto_fecha_robado : DB::raw('FECHA_ROBADO'),
                    'MARCA' => $request->objeto_marca,
                    'MODELO' => $request->objeto_modelo,
                    'COLOR' => $request->objeto_color,
                    'TIPO' => $request->objeto_tipo,
                    'PLACA' => $request->objeto_placa,
                    'NUMERO' => $request->objeto_numero,
                    'ESTADO_PLACAS' => $request->objeto_estado_placas,
                    'LUGAR_VEHICULO' => $request->objeto_lugar_vehiculo, ]);

                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?9:10,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Objetos':'Actualizar Objetos']);

                    $routeid = hex2bin($request->idExp);
                break;
            case 'e3r': //////DATOS GENERALES RELACIÓN
                $nRegistros=0;
                Session::forget('43iqd89h');
                foreach (explode(',', $request->hdnacumuladoI) as $keyI => $valueI) {
                    foreach (explode(',', $request->hdnacumuladoV) as $keyV => $valueV) {
                      $nRegistros = $nRegistros+datos_expediente\bitde_relaciondelito::leftjoin('prode_relaciondelito as pdrd', function($join){
                          $join->on('bitde_relaciondelito.id','=','pdrd.idRelacion')
                          ->whereNull('pdrd.deleted_at');
                        })->where('idDelito',$request->relDelito)->where('idImputado',$valueI)->where('idVictima',$valueV)
                        ->count();
                    }
                }

                if ($nRegistros>0) {
                  Session::put('43iqd89h',$nRegistros);
                }
                else
                {
                $post = datos_expediente\bitde_relaciondelito::updateOrCreate(['id' => $request->idRelacion],
                    ['idExpediente' => hex2bin($request->idExp),
                    'Usuario'=>Auth::User()->id,
                    'idDelito'=>$request->relDelito,]);
                if (!$post->wasRecentlyCreated) {
                    $deleted = datos_expediente\de_relaciondelito::where('idRelacion', $post->id)->delete();
                }
                foreach (explode(',', $request->hdnacumuladoI) as $keyI => $valueI) {
                    foreach (explode(',', $request->hdnacumuladoV) as $keyV => $valueV) {
                        $rel = datos_expediente\de_relaciondelito::create(
                        [
                        'idRelacion'=>$post->id,
                        'idImputado'=>$valueI,
                        'idVictima'=>$valueV,
                        ]);
                    }
                }

                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?11:12,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Relación delito':'Actualizar Relación delito']);
              }
                $routeid = hex2bin($request->idExp);
              break;
            case 'e3t': //////DATOS GENERALES DETERMINACIÓN
                $idExp=hex2bin($request->idExp);
                $post = datos_expediente\de_datosgenerales::updateOrCreate(['id' => $idExp],
                    ['FECHA_DETERMINACION'=>$request->causa_H_fecha_determinacion, 
                     'SENTIDO_DETERMINACION'=>$request->causa_H_sentido_determinacion, 
                     'TIPO_DETERMINACION'=>$request->causa_H_tipo_determinacion, 
                     'TIPO_ACCION_PENAL'=>$request->causa_H_tipo_accion_penal, 
                     'MOTIVO_DETERMINA'=>$request->expediente_H_motivo_determina, 
                     'FOLIO_AE'=>$request->expediente_H_Folio_AE,
                     'PAGO_ECONOMICO_MONTO'=>$request->expediente_H_pago_economico_monto,
                     'ACTO_EQUIVALENTE_MONTO'=>$request->expediente_H_acto_equivalente_monto,
                     'REMISION_OTRA_AREA'=>$request->expediente_H_remision_otra_area,
                     'FECHA_EJERCICIO_ACCION_PENAL'=>$request->expediente_H_fecha_EAP,
                     'TIPO_ACUERDO_PERDON_REPARACION'=>$request->causa_H_tipo_acuerdo_perdon_reparacion
                     
                     // 'ARCHIVO_TEMPORAL'=>$request->causa_H_archivo_temporal, 
                     // 'MOTIVO_REACTIVACION'=>$request->causa_H_motivo_reactivacion, 
                    ]);

                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $post->id,
                    'idEvento' => 97,
                    'Evento' => 'Actualizar Determinación Carpeta de Investigación']);

                $routeid = hex2bin($request->idExp);
              break;
            case 'e3masc': //////DATOS GENERALES MASC
                $idExp=hex2bin($request->idExp);
                $post = datos_expediente\de_imputados::where(['id' => $request->ddlImputadosMASC])
                ->update(['MASC'=>$request->causa_H_masc, 
                          'FECHA_DERIVA_MASC'=>$request->causa_H_fecha_deriva_masc, 
                          'FECHA_CUMPL_MAS'=>$request->causa_H_fecha_cumpl_mas, 
                          'TIPO_CUMPLIMIENTO'=>$request->causa_H_tipo_cumplimiento, 
                          'TIPO_MASC'=>$request->causa_H_tipo_masc, 
                          'AUTORIDAD_DERIVA_MASC'=>$request->causa_H_autoridad_deriva_masc,
                        ]);
                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $request->ddlImputadosMASC,
                    'idEvento' => 149,
                    'Evento' => 'Actualizar MASC Imputado en Carpeta de Investigación']);

                $routeid = hex2bin($request->idExp);            
              break;              
          #endregion
          
          #region Carpeta de Conducción
            case 'd9'://////CONDUCCION
                $idExp=hex2bin($request->idExp);
                $post = carpeta_conduccion\cc_datosgenerales::updateOrCreate(['id' => $idExp],
                  [ 'DELEGACION' =>$request->conduccion_delegacion,
                    'MUNICIPIO' =>$request->conduccion_municipio, 
                    'UNIDAD_ATENCION' =>$request->conduccion_unidad_atencion, 
                    'FECHA_INICIO_CONDUCCION' =>$request->conduccion_fecha_inicio_conduccion, 
                    'FECHA_HECHOS_CONDUCCION' =>$request->conduccion_fecha_hechos_conduccion, 
                    'HORA_HECHOS' =>$request->conduccion_hora_hechos, 
                    'NO_EXPEDIENTE_CONDUCCION' =>$request->conduccion_no_expediente_conduccion, 
                    'ENTIDAD_HECHOS_CONDUCCION' =>$request->conduccion_entidad_hechos_conduccion, 
                    'MUNICIPIO_HECHOS' =>$request->conduccion_municipio_hechos, 
                    'COLONIA_HECHOS' =>$request->conduccion_colonia_hechos, 
                    'CALLE_HECHOS_CONDUCCION' =>$request->conduccion_calle_hechos_conduccion, 
                    'CP' =>$request->conduccion_cp, 
                    'REF_1' =>$request->conduccion_ref_1, 
                    'REF_2' =>$request->conduccion_ref_2, 
                    'UNIDAD_QUE_RECIBE_CONDUCCION' =>$request->conduccion_unidad_que_recibe_conduccion, 
                    'RECIBIDA_POR' =>$request->conduccion_recibida_por, 
                    'TIPO_RECEPCION' =>$request->conduccion_tipo_recepcion, 
                    'DESCRIPCION' =>$request->conduccion_descripcion, 
                    'OBSERVACIONES' =>$request->conduccion_H_observaciones, 
                  ]);
                $upd=carpeta_conduccion\cc_datosgenerales::where('id', '=',$post->id)->firstOrFail();
                  $upd->idExpediente=$post->id;
                  $upd->save();
                $relUsuExp=relusuarioexpedientes::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $post->id,
                  'tabla' => 'procc_datosgenerales',
                  'Activo' => 1]);
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $post->id,
                  'idRegistro' => 0,
                  'idEvento' => $post->wasRecentlyCreated ?53:54,
                  'Evento' => $post->wasRecentlyCreated ?'Insertar Expediente Carpeta de conducción':'Actualizar Expediente Carpeta de conducción']);

                $routeid = $post->id;                
              break;            
            case 'd9v'://////CONDUCCION VICTIMAS
                $id=$request->idVictima;
                $post = carpeta_conduccion\cc_victimas::updateOrCreate(['id' => $id],
                    ['idExpediente' => hex2bin($request->idExp),
                    'MUNICIPIO_NACIMIENTO'=>$request->conduccionVictima_municipio_nacimiento, 
                    'SITUACION_MIGRATORIA_VICTIMAS_CONDUCCION'=>$request->conduccionVictima_situacion_migratoria_victimas_conduccion,
                    'INTERPRETE_VICTIMAS_CONDUCCION'=>$request->conduccionVictima_interprete_victimas_conduccion, 
                    'TIPO_VICTIMA_CONDUCCION'=>$request->conduccionVictima_tipo_victima_conduccion, 
                    'DELITOS_VICTIMA_CONDUCCION'=>$request->conduccionVictima_delitos_victima_conduccion, 
                    'RAZON_SOCIAL'=>$request->conduccionVictima_razon_social, 
                    'REPRESENTANTE_LEGAL'=>$request->conduccionVictima_representante_legal, 
                    'SECTOR_VICTIMAS_CONDUCCION'=>$request->conduccionVictima_sector_victimas_conduccion, 
                    'TIPO_PERSONA_VICTIMAS_CONDUCCION'=>$request->conduccionVictima_tipo_persona_victimas_conduccion, 
                    'PRIMER_APELLIDO'=>$request->conduccionVictima_primer_apellido, 
                    'SEGUNDO_APELLIDO_VICTIMAS_CONDUCCION'=>$request->conduccionVictima_segundo_apellido_victimas_conduccion, 
                    'SITUACION_CONYUGAL_VICTIMAS_CONDUCCION'=>$request->conduccionVictima_situacion_conyugal_victimas_conduccion, 
                    'NACIONALIDAD'=>$request->conduccionVictima_nacionalidad, 
                    'PAIS_NACIMIENTO'=>$request->conduccionVictima_pais_nacimiento, 
                    'ENTIDAD_NACIMIENTO_VICTIMAS_CONDUCCION'=>$request->conduccionVictima_entidad_nacimiento_victimas_conduccion, 
                    'PAIS_RESIDENCIA'=>$request->conduccionVictima_pais_residencia, 
                    'ENTIDAD_RESIDENCIA_VICTIMAS_CONDUCCION'=>$request->conduccionVictima_entidad_residencia_victimas_conduccion, 
                    'MUNICIPIO_RESIDENCIA'=>$request->conduccionVictima_municipio_residencia, 
                    'TELEFONO_VICTIMAS_CONDUCCION'=>$request->conduccionVictima_telefono_victimas_conduccion, 
                    'TRADUCTOR_VICTIMAS_CONDUCCION'=>$request->conduccionVictima_traductor_victimas_conduccion, 
                    'POBLACION_CALLE'=>$request->conduccionVictima_poblacion_calle, 
                    'LEER_ESCRIBIR'=>$request->conduccionVictima_leer_escribir, 
                    'ESCOLARIDAD'=>$request->conduccionVictima_escolaridad, 
                    'OCUPACION'=>$request->conduccionVictima_ocupacion, 
                    'RELACION_IMPUTADO'=>$request->conduccionVictima_relacion_imputado,

                    'TIPO_REPRESENTANTE_LEGAL'=>$request->victima_H_tipo_representante_legal,
                    'ASESORIA'=>$request->victima_asesoria,
                    'TIPO_DE_ASESORIA'=>$request->victima_tipo_de_asesoria,
                    'NOMBRE_VICTIMA'=>$request->victima_nombre_victima,
                    'CURP_VICTIMAS'=>$request->victima_curp_victimas,
                    'FECHA_NACIMIENTO_VICTIMAS'=>$request->victima_fecha_nacimiento_victimas,
                    'EDAD_HECHOS_VICTIMAS'=>$request->victima_edad_hechos_victimas,
                    'SEXO_VICTIMA'=>$request->victima_sexo_victima,
                    'DOMICILIO_VICTIMA'=>$request->victima_H_domicilio_victima,
                    'INGRESO_VICTIMA'=>$request->victima_H_ingreso_victima,
                    'HABLA_ESPAÑOL_VICTIMA'=>$request->victima_habla_español_victima,
                    'HABLA_LENG_EXTR_VICTIMA'=>$request->victima_habla_leng_extr_victima,
                    'TIPO_LENGUA_EXTRANJERA_VICTIMA'=>$request->victima_tipo_lengua_extranjera_victima,
                    'DISCAPACIDAD_VICTIMAS'=>$request->victima_discapacidad_victimas,
                    'TIPO_DISCAPACIDAD_VICTIMAS'=>$request->victima_tipo_discapacidad_victimas,
                    'INTERPRETE_POR_DISCAPACIDAD_VICTIMA'=>$request->victima_interprete_por_discapacidad_victima,
                    'ATEN_MEDICA'=>$request->victima_aten_medica,
                    'ATEN_PSICOLOGICA'=>$request->victima_aten_psicologica,
                    'SE_IDENTIFICA_INDIGENA_VICTIMA'=>$request->victima_H_se_identifica_indigena_victima,
                    'POBLACION_INDIGENA_VICTIMA'=>$request->victima_H_poblacion_indigena_victima,
                    'HABLA_LENG_INDIG_VICTIMA'=>$request->victima_habla_leng_indig_victima,
                    'LENGUA_VICTIMA'=>$request->victima_H_lengua_victima,
                    'VICTIMA_VIOLENCIA'=>$request->victima_victima_violencia,
                    'VESTIMENTA_VICTIMA'=>$request->victima_H_vestimenta_victima,
                     ]);

                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?55:56,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Vícitma Carpeta de conducción':'Actualizar Vícitma Carpeta de conducción']);

                $routeid = hex2bin($request->idExp);            
              break;
            case 'd9i'://////CONDUCCION IMPUTADOS
                $id=$request->idImputado;
                $post = carpeta_conduccion\cc_imputados::updateOrCreate(['id' => $id],
                    ['idExpediente' => hex2bin($request->idExp),
                        'MUNICIPIO_NACIMIENTO'=>$request->conduccionImputado_municipio_nacimiento, 
                        'TIPO_IMPUTADO_CONDUCCION'=>$request->conduccionImputado_tipo_imputado_conduccion,
                        'RAZON_SOCIAL'=>$request->conduccionImputado_razon_social,
                        'SECTOR_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_sector_imputados_conduccion,
                        'TIPO_PERSONA_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_tipo_persona_imputados_conduccion,
                        'DELITOS_IMPUTADO_CONDUCCION'=>$request->conduccionImputado_delitos_imputado_conduccion,
                        'RELACION_VICTIMA'=>$request->conduccionImputado_relacion_victima,
                        'PRIMER_APELLIDO'=>$request->conduccionImputado_primer_apellido,
                        'SEGUNDO_APELLIDO_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_segundo_apellido_imputados_conduccion,
                        'SITUACION_CONYUGAL_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_situacion_conyugal_imputados_conduccion,
                        'NACIONALIDAD'=>$request->conduccionImputado_nacionalidad,
                        'SITUACION_MIGRATORIA_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_situacion_migratoria_imputados_conduccion,
                        'PAIS_NACIMIENTO'=>$request->conduccionImputado_pais_nacimiento,
                        'ENTIDAD_NACIMIENTO_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_entidad_nacimiento_imputados_conduccion,
                        'PAIS_RESIDENCIA'=>$request->conduccionImputado_pais_residencia,
                        'ENTIDAD_RESIDENCIA_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_entidad_residencia_imputados_conduccion,
                        'MUNICIPIO_RESIDENCIA'=>$request->conduccionImputado_municipio_residencia,
                        'TELEFONO_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_telefono_imputados_conduccion,
                        'TRADUCTOR_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_traductor_imputados_conduccion,
                        'POBLACION_CALLE'=>$request->conduccionImputado_poblacion_calle,
                        'LEER_ESCRIBIR_IMPUTADOS'=>$request->conduccionImputado_leer_escribir_imputados,
                        'DETENIDO_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_detenido_imputados_conduccion,
                        'ESTADO_IMPUTADO_CONDUCCION'=>$request->conduccionImputado_estado_imputado_conduccion,
                        'FECHA_DETENCION_CONDUCCION'=>$request->conduccionImputado_fecha_detencion_conduccion,
                        'HORA_DETENCION'=>$request->conduccionImputado_hora_detencion,
                        'TIPO_DETENCION_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_tipo_detencion_imputados_conduccion,
                        'ENTIDAD_DETENCION_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_entidad_detencion_imputados_conduccion,
                        'AUTORIDAD_DETENCION_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_autoridad_detencion_imputados_conduccion,
                        'FOLIO_RND'=>$request->conduccionImputado_folio_rnd,
                        'RAZON_RND'=>$request->conduccionImputado_razon_rnd,
                        'EXAMEN_DETENCION_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_examen_detencion_imputados_conduccion,
                        'LESIONADO'=>$request->conduccionImputado_lesionado,
                        'ESTADO_PRESENTACION'=>$request->conduccionImputado_estado_presentacion,
                        'REPRESENTANTE_LEGAL'=>$request->conduccionImputado_representante_legal,
                        'INTERPRETE_IMPUTADOS_CONDUCCION'=>$request->conduccionImputado_interprete_imputados_conduccion,
                      'TIPO_REPRESENTANTE_LEGAL'=>$request->imputado_H_tipo_representante_legal,
                      'REL_PERS_MORAL'=>$request->imputado_rel_pers_moral,
                      'ALIAS_IMPUTADO'=>$request->imputado_alias_imputado,
                      'IMPUTADO_CONOCIDO'=>$request->imputado_H_imputado_conocido,    
                      'NOMBRE_IMPUTADO'=>$request->imputado_nombre_imputado,
                      'CURP_IMPUTADOS'=>$request->imputado_curp_imputados,
                      'FECHA_NACIMIENTO_IMPUTADOS'=>$request->imputado_fecha_nacimiento_imputados,
                      'EDAD_HECHOS_IMPUTADOS'=>$request->imputado_edad_hechos_imputados,       
                      'SEXO_IMPUTADO'=>$request->imputado_sexo_imputado,
                      'DOMICILIO_IMPUTADO'=>$request->imputado_H_domicilio_imputado,
                      'INGRESO_IMPUTADO'=>$request->imputado_H_ingreso_imputado,
                      'HABLA_ESPAÑOL_IMPUTADO'=>$request->imputado_H_habla_español_imputado,
                      'HABLA_LENG_EXTR_IMPUTADO'=>$request->imputado_H_habla_leng_extr_imputado,
                      'TIPO_LENGUA_EXTRANJERA_IMPUTADO'=>$request->imputado_H_tipo_lengua_extranjera_imputado,
                      'DISCAPACIDAD_IMPUTADOS'=>$request->imputado_discapacidad_imputados,
                      'TIPO_DISCAPACIDAD_IMPUTADOS'=>$request->imputado_tipo_discapacidad_imputados,
                      'INTERPRETE_POR_DISCAPACIDAD_IMPUTADO'=>$request->imputado_interprete_por_discapacidad_imputado,
                      'ESCOLARIDAD_IMPUTADO'=>$request->imputado_escolaridad_imputado,
                      'OCUPACION_IMPUTADO'=>$request->imputado_H_ocupacion_imputado,
                      'SE_IDENTIFICA_INDIGENA_IMPUTADO'=>$request->imputado_H_se_identifica_indigena_imputado,
                      'INDIGENA_IMPUTADO'=>$request->imputado_H_indigena_imputado,
                      'HABLA_LENG_INDIG_IMPUTADO'=>$request->imputado_H_habla_leng_indig_imputado,
                      'LENGUA_IMPUTADO'=>$request->imputado_H_lengua_imputado,
                      'NOMBRE_DE_GRUPO'=>$request->imputado_H_nombre_de_grupo,                    
                      'ANTECEDENTES'=>$request->imputado_H_antecedentes,
                      'DEFENSA'=>$request->imputado_H_defensa,
                      'TIPO_DEFENSA'=>$request->imputado_H_tipo_defensa,
                      'MEDIA_FILIACION_IMPUTADO'=>$request->imputado_H_media_filiacion_imputado,
                      'TIPO_MANDAMIENTO'=>$request->imputado_H_tipo_mandamiento,
                      'GRADO_DE_PARTICIPACION'=>$request->imputado_H_grado_de_participacion
                    ]);

                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?57:58,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Imputado Carpeta de conducción':'Actualizar Imputado Carpeta de conducción']);

                $routeid = hex2bin($request->idExp);
              break;            
            case 'd9d'://////CONDUCCION DELITOS
                $id=$request->idDelito;

                $post = carpeta_conduccion\cc_hechos::updateOrCreate(['id' => $id],
                    ['idExpediente' => hex2bin($request->idExp),
                      'CONSUMACION'=>$request->conduccionDelito_consumacion, 
                      'MODALIDAD'=>$request->conduccionDelito_modalidad, 
                      'INSTRUMENTO_CONDUCCION'=>$request->conduccionDelito_instrumento_conduccion, 
                      'TIPO_SITIO_OCURRENCIA_CONDUCCION'=>$request->conduccionDelito_tipo_sitio_ocurrencia_conduccion, 
                      'COMISION_CONDUCCION'=>$request->conduccionDelito_comision_conduccion, 
                      'DELITO'=>$request->conduccionDelito_delito, 
                      'DELITO_JUR'=>$request->conduccionDelito_delito_JUR, 
                      'FUERO_CONDUCCION'=>$request->conduccionDelito_fuero_conduccion, 
                      'CALIFICACION_CONDUCCION'=>$request->conduccionDelito_calificacion_conduccion, 
                    ]);

                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?59:60,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Delito Carpeta de conducción':'Actualizar Imputado Carpeta de conducción']);

                $routeid = hex2bin($request->idExp);            
              break;
            case 'd9o'://////CONDUCCION OBJETOS
                $id=$request->idObjeto;

                $post = carpeta_conduccion\cc_objetos::updateOrCreate(['id' => $id],
                  ['idExpediente' => hex2bin($request->idExp),
                    'OBJETO_1'=>$request->conduccionObjeto_objeto_1, 
                    'DESC_OBJ_1'=>$request->conduccionObjeto_desc_obj_1, 
                    'CANT_OBJ_1'=>$request->conduccionObjeto_cant_obj_1, 
                    'VALOR_OBJ_1'=>$request->conduccionObjeto_valor_obj_1, 
                    'ESTATUS_OBJ_1' => $request->objeto_estatus_obj_1,
                    'OBJETO_2'=>$request->conduccionObjeto_objeto_2, 
                    'DESC_OBJ_2'=>$request->conduccionObjeto_desc_obj_2, 
                    'CANT_OBJ_2'=>$request->conduccionObjeto_cant_obj_2, 
                    'VALOR_OBJ_2'=>$request->conduccionObjeto_valor_obj_2, 
                    'ESTATUS_OBJ_2' => $request->objeto_estatus_obj_2,                    
                    'OBJETO_3'=>$request->conduccionObjeto_objeto_3, 
                    'DESC_OBJ_3'=>$request->conduccionObjeto_desc_obj_3, 
                    'CANT_OBJ_3'=>$request->conduccionObjeto_cant_obj_3, 
                    'VALOR_OBJ_3'=>$request->conduccionObjeto_valor_obj_3,
                    'ESTATUS_OBJ_3' => $request->objeto_estatus_obj_3,

                    'TIPO_NARCOTICO_1' => $request->objeto_tipo_narcotico_1,
                    'PRESENTACION_NARCO_1' => $request->objeto_presentacion_narco_1,
                    'CANTIDAD_NARCO_1' => $request->objeto_cantidad_narco_1,
                    'GRAMAJE_NARCO_1' => $request->objeto_gramaje_narco_1,
                    'TIPO_NARCOTICO_2' => $request->objeto_tipo_narcotico_2,
                    'PRESENTACION_NARCO_2' => $request->objeto_presentacion_narco_2,
                    'CANTIDAD_NARCO_2' => $request->objeto_cantidad_narco_2,
                    'GRAMAJE_NARCO_2' => $request->objeto_gramaje_narco_2,
                    'TIPO_NARCOTICO_3' => $request->objeto_tipo_narcotico_3,
                    'PRESENTACION_NARCO_3' => $request->objeto_presentacion_narco_3,
                    'CANTIDAD_NARCO_3' => $request->objeto_cantidad_narco_3,
                    'GRAMAJE_NARCO_3' => $request->objeto_gramaje_narco_3,
                    'ESTATUS' => $request->objeto_estatus,
                    'FECHA_ASEGURADO'=> $request->objeto_estatus == 1 ? $request->objeto_fecha_asegurado : DB::raw('FECHA_ASEGURADO'),
                    'FECHA_DEVUELTO'=> $request->objeto_estatus == 2 ? $request->objeto_fecha_devuelto : DB::raw('FECHA_DEVUELTO'),
                    'FECHA_ROBADO'=> $request->objeto_estatus == 3 ? $request->objeto_fecha_robado : DB::raw('FECHA_ROBADO'),
                    'MARCA' => $request->objeto_marca,
                    'MODELO' => $request->objeto_modelo,
                    'COLOR' => $request->objeto_color,
                    'TIPO' => $request->objeto_tipo,
                    'PLACA' => $request->objeto_placa,
                    'NUMERO' => $request->objeto_numero,
                    'ESTADO_PLACAS' => $request->objeto_estado_placas,
                    'LUGAR_VEHICULO' =>$request->objeto_lugar_vehiculo,
                  ]);

                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?61:62,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Objetos Carpeta de conducción':'Actualizar Objetos Carpeta de conducción']);

                $routeid = hex2bin($request->idExp);
              break;
            case 'd9r'://////CONDUCCION RELACION 
              break;
          #endregion

          #region No Delictivos
            case 'he'://////NO DELICTIVOS
                $idExp=hex2bin($request->idExp);
                $post = no_delictivos\nd_datosgenerales::updateOrCreate(['id' => $idExp],
                  [ 'DELEGACION' =>$request->nod_delegacion,
                    'MUNICIPIO' =>$request->nod_municipio, 
                    'UNIDAD_ATENCION_NO_DELICTIVOS' =>$request->nod_unidad_atencion_no_delictivos, 
                    'FECHA_INICIO' =>$request->nod_fecha_inicio, 
                    'FECHA_HECHOS_NO_DELICTIVOS' =>$request->nod_fecha_hechos_no_delictivos, 
                    'HORA_HECHOS' =>$request->nod_hora_hechos, 
                    'NO_EXPEDIENTE' =>$request->nod_no_expediente, 
                    'RECIBIDA_POR' =>$request->nod_recibida_por, 
                    'ENTIDAD_HECHOS_NO_DELICTIVOS' =>$request->nod_entidad_hechos_no_delictivos, 
                    'MUNICIPIO_HECHOS' =>$request->nod_municipio_hechos, 
                    'COLONIA_HECHOS' =>$request->nod_colonia_hechos,                   
                    'CALLE_HECHOS_NO_DELICTIVOS' =>$request->nod_calle_hechos_no_delictivos, 
                    'CP' =>$request->nod_cp, 
                    'REF_1' =>$request->nod_ref_1, 
                    'REF_2' =>$request->nod_ref_2, 
                    'HECHO_NO_DELITO'=>$request->nod_hecho_no_delito,
                    'CAUSA_MUERTE'=>$request->nod_causa_muerte,
                    'MOTIVO'=>$request->nod_motivo,
                    'MEDIO_UTILIZADO'=>$request->nod_medio_utilizado,
                    'DESCRIPCION' =>$request->nod_descripcion, 
                    'OBSERVACIONES' =>$request->nod_H_observaciones, 
                  ]);
                $upd=no_delictivos\nd_datosgenerales::where('id', '=',$post->id)->firstOrFail();
                  $upd->idExpediente=$post->id;
                  $upd->save();
                $relUsuExp=relusuarioexpedientes::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $post->id,
                  'tabla' => 'prond_datosgenerales',
                  'Activo' => 1]);
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $post->id,
                  'idRegistro' => 0,
                  'idEvento' => $post->wasRecentlyCreated ?63:64,
                  'Evento' => $post->wasRecentlyCreated ?'Insertar Expediente No delictivos':'Actualizar Expediente No delictivos']);

                $routeid = $post->id;                
              break; 
            case 'hev'://////NO DELICTIVOS VICTIMAS            
                $id=$request->idVictima;
                $post = no_delictivos\nd_victimas::updateOrCreate(['id' => $id],
                    ['idExpediente' => hex2bin($request->idExp),
                      'TIPO_VICTIMA_NO_DELICTIVO'=>$request->nodVictima_tipo_victima_no_delictivo, 
                      'NOMBRE_VICTIMA'=>$request->victima_nombre_victima,                      
                      'PRIMER_APELLIDO'=>$request->nodVictima_primer_apellido, 
                      'SEGUNDO_APELLIDO_VICTIMAS_NO_DELICTIVO'=>$request->nodVictima_segundo_apellido_victimas_no_delictivo, 
                      'SEXO'=>$request->nodVictima_sexo, 
                      'SIT_CONYUGAL_VICTIMAS_NO_DELICTIVO'=>$request->nodVictima_sit_conyugal_victimas_no_delictivo, 
                      'ESCOLARIDAD'=>$request->nodVictima_escolaridad, 
                      'OCUPACION'=>$request->nodVictima_ocupacion, 
                      'EDAD_HECHOS_VICTIMAS'=>$request->victima_edad_hechos_victimas,
                      'FECHA_NACIMIENTO'=>$request->nodVictima_fecha_nacimiento, 
                      'OCCISO'=>$request->nodVictima_occiso,
                        'DEF_FOLIO_DEFUNCION'=>$request->victima_def_folio_defuncion,
                        'DEF_FECHA_EXP'=>$request->victima_def_fecha_exp,
                        'DEF_FECHA_DEFUNCION'=>$request->victima_def_fecha_defuncion,
                        'DEF_TIPO_DEFUNCION'=>$request->victima_def_tipo_defuncion,
                        'DEF_CERTIFICADO_POR'=>$request->victima_def_certificado_por,
                        'DEF_SITIO_DEFUNCION'=>$request->victima_def_sitio_defuncion,
                        'DEF_SITIO_LESION'=>$request->victima_def_sitio_lesion,
                        'DEF_FUE_EN_EL_TRABAJO'=>$request->victima_def_fue_en_el_trabajo,
                        'DEF_AGENTE_EXTERNO'=>$request->victima_def_agente_externo,
                        'DEF_TIPO_EVENTO'=>$request->victima_def_tipo_evento,
                        'DEF_TIPO_VICTIMA'=>$request->victima_def_tipo_victima,
                        'DEF_TIPO_ARMA'=>$request->victima_def_tipo_arma,
                        'DEF_ENTIDAD_DENUNICA'=>$request->victima_def_entidad_denunica,
                        'DEF_MUNICIPIO_DENUNICA'=>$request->victima_def_municipio_denunica,
                        'DEF_COLONIA_DENUNICA'=>$request->victima_def_colonia_denunica,
                        'DEF_ENTIDAD_DEFUNCION'=>$request->victima_def_entidad_defuncion,
                        'DEF_MUNICIPIO_DEFUNCION'=>$request->victima_def_municipio_defuncion,
                        'DEF_COLONIA_DEFUNCION'=>$request->victima_def_colonia_defuncion,
                        'DEF_CAUSA_A'=>$request->victima_def_causa_a,
                        'DEF_DURACION_BCD'=>$request->victima_def_duracion_bcd,
                        'DEF_ESTADO_PATOLOGICO'=>$request->victima_def_estado_patologico,
                        'DEF_DURACION_PATOLOGICO'=>$request->victima_def_duracion_patologico,
                        'DEF_CONDICION_EMBARAZO'=>$request->victima_def_condicion_embarazo,
                        'DEF_PERIODO_POSPARTO'=>$request->victima_def_periodo_posparto,
                    ]);

                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?65:66,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Vícitma No delictivos':'Actualizar Vícitma No delictivos']);

                $routeid = hex2bin($request->idExp);            
              break;
            case 'heo'://////NO DELICTIVOS OBJETOS
                $id=$request->idObjeto;

                $post = no_delictivos\nd_objetos::updateOrCreate(['id' => $id],
                  ['idExpediente' => hex2bin($request->idExp),
                    'OBJETO_1'=>$request->nodObjeto_objeto_1, 
                    'DESC_OBJ_1'=>$request->nodObjeto_desc_obj_1, 
                    'CANT_OBJ_1'=>$request->nodObjeto_cant_obj_1, 
                    'VALOR_OBJ_1'=>$request->nodObjeto_valor_obj_1, 
                    'ESTATUS_OBJ_1' => $request->objeto_estatus_obj_1,
                    'OBJETO_2'=>$request->nodObjeto_objeto_2, 
                    'DESC_OBJ_2'=>$request->nodObjeto_desc_obj_2, 
                    'CANT_OBJ_2'=>$request->nodObjeto_cant_obj_2, 
                    'VALOR_OBJ_2'=>$request->nodObjeto_valor_obj_2, 
                    'ESTATUS_OBJ_2' => $request->objeto_estatus_obj_2,
                    'OBJETO_3'=>$request->nodObjeto_objeto_3, 
                    'DESC_OBJ_3'=>$request->nodObjeto_desc_obj_3, 
                    'CANT_OBJ_3'=>$request->nodObjeto_cant_obj_3, 
                    'VALOR_OBJ_3'=>$request->nodObjeto_valor_obj_3,
                    'ESTATUS_OBJ_3' => $request->objeto_estatus_obj_3,

                    'TIPO_NARCOTICO_1' => $request->objeto_tipo_narcotico_1,
                    'PRESENTACION_NARCO_1' => $request->objeto_presentacion_narco_1,
                    'CANTIDAD_NARCO_1' => $request->objeto_cantidad_narco_1,
                    'GRAMAJE_NARCO_1' => $request->objeto_gramaje_narco_1,
                    'TIPO_NARCOTICO_2' => $request->objeto_tipo_narcotico_2,
                    'PRESENTACION_NARCO_2' => $request->objeto_presentacion_narco_2,
                    'CANTIDAD_NARCO_2' => $request->objeto_cantidad_narco_2,
                    'GRAMAJE_NARCO_2' => $request->objeto_gramaje_narco_2,
                    'TIPO_NARCOTICO_3' => $request->objeto_tipo_narcotico_3,
                    'PRESENTACION_NARCO_3' => $request->objeto_presentacion_narco_3,
                    'CANTIDAD_NARCO_3' => $request->objeto_cantidad_narco_3,
                    'GRAMAJE_NARCO_3' => $request->objeto_gramaje_narco_3,
                    'ESTATUS_NO_DELICTIVOS'=>$request->nodObjeto_estatus_no_delictivos,
                    'FECHA_ASEGURADO'=> $request->nodObjeto_estatus_no_delictivos == 1 ? $request->objeto_fecha_asegurado : DB::raw('FECHA_ASEGURADO'),
                    'FECHA_DEVUELTO'=> $request->nodObjeto_estatus_no_delictivos == 2 ? $request->objeto_fecha_devuelto : DB::raw('FECHA_DEVUELTO'),
                    'FECHA_ROBADO'=> $request->nodObjeto_estatus_no_delictivos == 3 ? $request->objeto_fecha_robado : DB::raw('FECHA_ROBADO'),
                    'MARCA_NO_DELICTIVOS'=>$request->nodObjeto_marca_no_delictivos,
                    'MODELO_NO_DELICTIVOS'=>$request->nodObjeto_modelo_no_delictivos,
                    'COLOR_NO_DELICTIVOS'=>$request->nodObjeto_color_no_delictivos,
                    'TIPO_NO_DELICTIVOS'=>$request->nodObjeto_tipo_no_delictivos,
                    'PLACA_NO_DELICTIVOS'=>$request->nodObjeto_placa_no_delictivos,
                    'NUMERO_NO_DELICTIVOS'=>$request->nodObjeto_numero_no_delictivos,
                    'ESTADO_PLACAS_NO_DELICTIVOS'=>$request->nodObjeto_estado_placas_no_delictivos,
                    'LUGAR_VEHICULO_NO_DELICTIVOS'=>$request->objeto_lugar_vehiculo_no_delictivos,
                  ]);

                $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => hex2bin($request->idExp),
                    'idRegistro' => $post->id,
                    'idEvento' => $post->wasRecentlyCreated ?67:68,
                    'Evento' => $post->wasRecentlyCreated ?'Insertar Objetos No delictivos':'Actualizar Objetos No delictivos']);

                $routeid = hex2bin($request->idExp);

              break;
          #endregion

        }
        // $v=$request->validate([
        //     'causa_H_observaciones' => 'required|min:6',
        // ],
        // [
        //     'causa_H_observaciones.required'=>'el causa_H_observaciones es requerido',
        //     'causa_H_observaciones.min'=>'el causa_H_observaciones es de mínimo :min',
        // ]);
        // $request->getQueryString());
        return redirect()->route("dash",[$request->Ctrl,$routeid]);
      }
    }

    public function index(string $Ctrl, string $idExp=null, string $idRegistro=null)
    {
        if(is_null(Auth::User())) { return redirect("Salir"); }
        else
        {           
         if((is_null($idExp) && Auth::User()->TipoUsuario==99) ||
            (isset($idExp) && Auth::User()->TipoUsuario!=99) ||
            (is_null($idExp) && Auth::User()->TipoUsuario!=99 && $Ctrl=='rs'))
         {
          if (!Session::missing('43i')) {
            Session::forget('43iqd89h');
            Session::forget('43i');
          }          

          switch($Ctrl)
          {
             case 'q7'://////AGREGAR USUARIO
             case 'dj'://////CARGA MASIVA
              if(is_null($idExp))
              {
                if(Auth::User()->TipoUsuario==99) {
                  switch ($Ctrl) {
                    case 'q7':
                      return view('inicio.dashboard');
                      break;
                    case 'dj':
                      return view('inicio.dashboardCM');
                      break;
                  }
                }
                else
                {
                  return redirect("Salir");
                }
              }
                break;
             case 'rs'://////CARGA FORM EXCEL
                return view('inicio.dashboardFX');
                break;
             case 'e3'://////DATOS EXPEDIENTE
             case 'e3v'://////DATOS EXPEDIENTE VICTIMAS
             case 'e3i'://////DATOS EXPEDIENTE IMPUTADOS
             case 'e3d'://////DATOS EXPEDIENTE DELITOS
             case 'e3o'://////DATOS EXPEDIENTE OBJETOS
             case 'e3r'://////DATOS EXPEDIENTE RELACION
             case 'e3ev'://////DATOS EXPEDIENTE DETERMINACION
             case 'e3masc'://////DATOS EXPEDIENTE MASC
             case 'e3t'://////DATOS EXPEDIENTE DETERMINACION            
                #region Catalogos iniciales
                 $delegaciones = $this->GetCatalogo('catdelegaciones');
                 $entidades = $this->GetDataById('catentidadesfederativas_inegi','id',5);
                 $entidades = $this->GetCatalogo('catentidadesfederativas_inegi');
                 $uats = $this->GetCatalogo('catuats');
                 $estatusCarpeta = $this->GetDataById('catrespuestas','idTipoRespuesta',44);
                 $recibida_por = $this->GetDataById('catrespuestas','idTipoRespuesta',12);
                 $medio_recepcion = $this->GetDataById('catrespuestas','idTipoRespuesta',90);
                 $tipo_recepcion = $this->GetDataById('catrespuestas','idTipoRespuesta',2);
                 $autoridad = $this->GetDataById('catrespuestas','idTipoRespuesta',41);
                 $parentesco = $this->GetDataById('catrespuestas','idTipoRespuesta',60);
                 $formaInicioCarpeta = $this->GetDataById('catrespuestas','idTipoRespuesta',50);
                 $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);                 
                 $tipoCriterio= $this->GetDataById('catrespuestas','idTipoRespuesta',63);
                 $etapaProc= $this->GetDataById('catrespuestas','idTipoRespuesta',48);
                 $medioCon= $this->GetDataById('catrespuestas','idTipoRespuesta',53);
                 $sentidoDete= $this->GetDataById('catrespuestas','idTipoRespuesta',58);
                 
                 $tipoDete= $this->GetDataById('catrespuestas','idTipoRespuesta',92);
                 $accionPenal= $this->GetDataById('catrespuestas','idTipoRespuesta',93);
                 $SiNo= $this->GetDataById('catrespuestas','idTipoRespuesta',2);
                 $motivoReac= $this->GetDataById('catrespuestas','idTipoRespuesta',94);
                 $autDetencion = $this->GetDataById('catrespuestas','idTipoRespuesta',24);    
                 $UnidadQueRecibe = $this->GetDataById('catrespuestas','idTipoRespuesta',96);
                 $motivoDetermina = $this->GetDataById('catrespuestas','idTipoRespuesta',106);
                 $remisionOtraArea = $this->GetDataById('catrespuestas','idTipoRespuesta',107);
                 $acuerdo_P_RD = $this->GetDataById('catrespuestas','idTipoRespuesta',108);

                 $municipiosDel = []; $municipios = []; $colonias = []; $datos = []; $resumen = [];
                 $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];
                 $victimas = []; $imputados = []; $hechos = []; $objetos = []; $relaciones = [];
                 $listados=['victimas'=>$victimas,'imputados'=>$imputados,'hechos'=>$hechos,'objetos'=>$objetos,'relaciones'=>$relaciones];
                #endregion
                 DB::statement("SET SQL_MODE=''");
                #region Obtener Datos
                  if ($idExp>0)
                  {
                    $datos = datos_expediente\de_datosgenerales::where('idExpediente',$idExp)->first();
                    $datos->FECHA_INICIO_CARPETA = empty(trim($datos->FECHA_INICIO_CARPETA))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO_CARPETA)));
                    $datos->FECHA_HECHOS = date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_HECHOS)));
                    $municipiosDel = $this->GetDataById('catmunicipios_inegi','idDelegacion',$datos->DELEGACION);
                    $municipios = $this->GetDataById('catmunicipios_inegi','CVE_ENT',$datos->ENTIDAD_HECHOS);
                    $colonias = $this->GetDataById('catcolonias','idMunicipio',$datos->MUNICIPIO_HECHOS);

                    $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                                      
                    $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                    $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                    $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();
                    
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                    'NUC' => $datos->NUC_COMPLETA??'-','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO_CARPETA))?'-':$datos->FECHA_INICIO_CARPETA??'-',
                    'validacion'=>$validacion,'correccion'=>$correccion,'idExpCorr'=>$idExp,'tablaCorr'=>'prode_datosgenerales'];
                    #region listados de victimas hechos imputados y objetos
                        $victimas=datos_expediente\de_victimas::where('idExpediente',$idExp)->orderByDesc('id')->get();
                        $imputados=datos_expediente\de_imputados::where('idExpediente',$idExp)->orderByDesc('id')->get();
                        $hechos=datos_expediente\de_hechos::leftjoin('catdelitosespecificos as catD','prode_hechos.DELITO', '=', 'catD.id')
                        ->where('idExpediente',$idExp)->orderByDesc('prode_hechos.id')->select('prode_hechos.id','catD.Valor')->get();
                        $objetos=datos_expediente\de_objetos::select(
                          DB::raw('cr1.Valor as v1 ,cr2.Valor as v2,cr3.Valor as v3,crn1.Valor as vn1 ,crn2.Valor as vn2,crn3.Valor as vn3, prode_objetos.*'))
                          ->leftJoin('catrespuestas as cr1', function($join)
                          {
                              $join->on('prode_objetos.OBJETO_1','=','cr1.id')
                              ->Where('cr1.idTipoRespuesta','=',25);
                          })
                          ->leftJoin('catrespuestas as cr2', function($join)
                          {
                              $join->on('prode_objetos.OBJETO_2','=','cr2.id')
                              ->Where('cr2.idTipoRespuesta','=',25);
                          })
                          ->leftJoin('catrespuestas as cr3', function($join)
                          {
                              $join->on('prode_objetos.OBJETO_3','=','cr3.id')
                              ->Where('cr3.idTipoRespuesta','=',25);
                          })
                          ->leftJoin('catrespuestas as crn1', function($join)
                          {
                              $join->on('prode_objetos.TIPO_NARCOTICO_1','=','crn1.id')
                              ->Where('crn1.idTipoRespuesta','=',26);
                          })
                          ->leftJoin('catrespuestas as crn2', function($join)
                          {
                              $join->on('prode_objetos.TIPO_NARCOTICO_2','=','crn2.id')
                              ->Where('crn2.idTipoRespuesta','=',26);
                          })
                          ->leftJoin('catrespuestas as crn3', function($join)
                          {
                              $join->on('prode_objetos.TIPO_NARCOTICO_3','=','crn3.id')
                              ->Where('crn3.idTipoRespuesta','=',26);
                          })
                          ->where('idExpediente',$idExp)->orderByDesc('prode_objetos.id')->get();
                        $relaciones=datos_expediente\bitde_relaciondelito::leftjoin('prode_relaciondelito as pdr', function($join){
                            $join->on('bitde_relaciondelito.id','=','pdr.idRelacion')
                            ->whereNull('pdr.deleted_at');
                          })
                          ->leftjoin('prode_victimas as pdv','pdr.idVictima','=','pdv.id')
                          ->leftjoin('prode_imputados as pdi','pdr.idImputado','=','pdi.id')
                          ->leftjoin('prode_hechos as pdh','bitde_relaciondelito.idDelito','=','pdh.id')
                          ->leftjoin('catdelitosespecificos as cde','pdh.DELITO','=','cde.id')
                          ->select('bitde_relaciondelito.id',DB::raw('GROUP_CONCAT(DISTINCT(cde.Valor)) AS delito'),
                              DB::raw("GROUP_CONCAT(DISTINCT(CASE WHEN pdv.TIPO_VICTIMA=2 THEN pdv.RAZON_SOCIAL WHEN pdv.TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN pdv.TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdv.TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(pdv.NOMBRE_VICTIMA,' ', pdv.PRIMER_APELLIDO,' ', pdv.SEGUNDO_APELLIDO_VICTIMAS) END)) victimas"),
                              DB::raw("GROUP_CONCAT(DISTINCT(CASE WHEN pdi.TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN pdi.TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN pdi.TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdi.TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(pdi.NOMBRE_IMPUTADO,' ', pdi.PRIMER_APELLIDO,' ', pdi.SEGUNDO_APELLIDO_IMPUTADOS) END)) imputados"),
                          )->where('bitde_relaciondelito.idExpediente',$idExp)->groupby('bitde_relaciondelito.id') ->get();

                        $listados=['victimas'=>$victimas,'imputados'=>$imputados,'hechos'=>$hechos,'objetos'=>$objetos,'relaciones'=>$relaciones];
                    #endregion
                  }
                #endregion
                #region menus
                    $menuActivo=['1m' => '','1d' => '', '2m' => '','2d' => '', '3m' => '','3d' => '', '4m' => '','4d' => '', '5m' => '','5d' => '', 
                    '6m' => '','6d' => '','7m' => '','7d' => '','8m' => '','8d' => '','9m' => '','9d' => '',];
                    switch ($Ctrl) {
                        case 'e3':
                            $menuActivo['1m']='active';
                            $menuActivo['1d']='show active';
                            break;
                        case 'e3v':
                            $menuActivo['2m']='active';
                            $menuActivo['2d']='show active';
                            break;
                        case 'e3i':
                            $menuActivo['3m']='active';
                            $menuActivo['3d']='show active';
                            break;
                        case 'e3d':
                            $menuActivo['4m']='active';
                            $menuActivo['4d']='show active';
                            break;
                        case 'e3o':
                            $menuActivo['5m']='active';
                            $menuActivo['5d']='show active';
                            break;
                        case 'e3r':
                            $menuActivo['6m']='active';
                            $menuActivo['6d']='show active';
                            break;
                        case 'e3t':
                            $menuActivo['7m']='active';
                            $menuActivo['7d']='show active';
                            break;
                        case 'e3ev':
                            $menuActivo['8m']='active';
                            $menuActivo['8d']='show active';
                            break;
                        case 'e3masc':
                            $menuActivo['9m']='active';
                            $menuActivo['9d']='show active';
                          break;
                        }
                #endregion

                #region Investigación Inicial
                  $idRegistro =0;
                  #region Catalogos iniciales
                    $SiNoNoA= $this->GetDataById('catrespuestas','idTipoRespuesta',3);
                    $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
                    $TMRestriccion= $this->GetDataById('catrespuestas','idTipoRespuesta',28);
                    $audineciaPx= $this->GetDataById('catrespuestas','idTipoRespuesta',31);
                    $TipoControl= $this->GetDataById('catrespuestas','idTipoRespuesta',89);
                    $TipoActo= $this->GetDataById('catrespuestas','idTipoRespuesta',78);
                    $impuestaPor= $this->GetDataById('catrespuestas','idTipoRespuesta',79);
                    $filteredCollection = $impuestaPor->filter(function ($item, $key) {
                        return $item->id === 2; // Filtrar solo elementos con 'id' par
                    });
                    $impuestaPor=$filteredCollection;
                    $estatusMJ= $this->GetDataById('catrespuestas','idTipoRespuesta',80);
                    $TipoMJ= $this->GetDataById('catrespuestas','idTipoRespuesta',81);
                    $actosCon= $this->GetDataById('catrespuestas','idTipoRespuesta',29);
                    $actosSin= $this->GetDataById('catrespuestas','idTipoRespuesta',30);
                    $formaProc=$this->GetDataById('catrespuestas','idTipoRespuesta',51);
                    $EstatusCU= $this->GetDataById('catrespuestas','idTipoRespuesta',87);                  
                  #endregion
                  $imputadosCP=[]; $imputadosDDL=[];$victimasDDL=[];$audienciaInicial=[];
                  $actosEV=[];$victimasCP=[];$medidas=[];$actosConL=[];$actosSinL=[];$CP_EV=0;$mandamientos=[];
                  $actosEV_DE=[];$mandamientos_DE=[];$medidas_DE=[];
                  #region Obtener Datos
                   if ($idExp > 0)
                   {
                      DB::statement("SET SQL_MODE=''");                      
                      $imputadosDDL = datos_expediente\de_imputados::leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('prode_imputados.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idExpediente',$idExp)
                        ->whereRaw("prode_imputados.id NOT IN (select pei.idImputado from prode_ev_imputados pei where pei.idExpediente='".$idExp."' AND pei.deleted_at IS NULL)")
                        ->select('prode_imputados.id','prode_imputados.id as idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN prode_imputados.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", prode_imputados.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),'prode_imputados.FECHA_DETENCION',
                        DB::raw("'' as DETENCION_LEGAL_ILEGAL")
                        )->groupby('prode_imputados.id')->get();  

                      $imputadosCP = datos_expediente\de_ev_imputados::leftjoin('prode_imputados as pdi','prode_ev_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('prode_ev_imputados.idExpediente',$idExp)
                        ->select('prode_ev_imputados.*','prode_ev_imputados.id','prode_ev_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                        )->groupby('prode_ev_imputados.idImputado')->get(); 
                        foreach ($imputadosCP as $key => $value) {

                         $mandamientos [$value->id]= datos_expediente\de_ev_mandamientos::leftjoin('catrespuestas as cr', function($join)
                          {
                              $join->on('prode_ev_mandamientos.TIPO_MANDAMIENTO','=','cr.id')
                              ->Where('cr.idTipoRespuesta','=',81);
                          })
                          ->leftjoin('catrespuestas as cr2', function($join)
                          {
                              $join->on('prode_ev_mandamientos.ESTATUS_MANDAMIENTO','=','cr2.id')
                              ->Where('cr2.idTipoRespuesta','=',80);
                          })
                          ->where('id_de_ev_imputados',$value->id)->select('prode_ev_mandamientos.*',
                          'cr.Valor as TIPO_MANDAMIENTO','cr2.Valor as ESTATUS_MANDAMIENTO')->get();                        
                        }

                      $victimasDDL = datos_expediente\de_victimas::leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('prode_victimas.SEXO_VICTIMA','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idExpediente',$idExp)
                        ->whereRaw("prode_victimas.id NOT IN (select pev.idVictima from prode_ev_victimas pev where pev.idExpediente='".$idExp."' AND pev.deleted_at IS NULL)")
                        ->select('prode_victimas.id','prode_victimas.id as idVictima',
                        DB::raw('CASE WHEN TIPO_VICTIMA=2 THEN RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN "LA SOCIEDAD" WHEN TIPO_VICTIMA=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_VICTIMA=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_VICTIMA," ", prode_victimas.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_VICTIMAS) END as Valor'),
                        )->groupby('prode_victimas.id')->get();  
                      $victimasCP =datos_expediente\de_ev_victimas::leftjoin('prode_victimas as pdv','prode_ev_victimas.idVictima','=','pdv.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdv.SEXO_VICTIMA','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('pdv.idExpediente',$idExp)                      
                        ->select('pdv.id','prode_ev_victimas.id as idcp_ev_victimas','pdv.id as idVictima',
                        DB::raw('CASE WHEN TIPO_VICTIMA=2 THEN RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN "LA SOCIEDAD" WHEN TIPO_VICTIMA=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_VICTIMA=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_VICTIMA," ", pdv.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_VICTIMAS) END as Valor'),  
                        DB::raw('CASE WHEN TIPO_VICTIMA=2 THEN CONCAT(RAZON_SOCIAL," / - / -") WHEN TIPO_VICTIMA=3 THEN CONCAT("LA SOCIEDAD / - / -") WHEN TIPO_VICTIMA=5 THEN CONCAT("SIN IDENTIFICAR/DESCONOCIDO / - / -") WHEN TIPO_VICTIMA=7 THEN CONCAT("LA SALUD / - / -") ELSE CONCAT(NOMBRE_VICTIMA," ", pdv.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_VICTIMAS," / ",IFNULL(cr.Valor,"-")," / ",pdv.EDAD_HECHOS_VICTIMAS) END as encabezado'),
                        )->groupby('pdv.id')->get(); 
                        foreach ($victimasCP as $key => $value) {  
                         $medidas [$value->id]= datos_expediente\de_ev_medidas::leftjoin('catrespuestas as cr', function($join)
                          {
                              $join->on('prode_ev_medidas.TIPO_DE_MEDIDA','=','cr.id')
                              ->Where('cr.idTipoRespuesta','=',28);
                          })
                          ->leftjoin('catrespuestas as cr2', function($join)
                          {
                              $join->on('prode_ev_medidas.MEDIDA_IMPUESTA_POR','=','cr2.id')
                              ->Where('cr2.idTipoRespuesta','=',79);
                          })
                          ->where('id_de_ev_victimas',$value->idcp_ev_victimas)->select('prode_ev_medidas.*',
                            'cr.Valor as TIPOMEDIDA','cr2.Valor as IMPUESTAPOR')->get();

                        }
                      
                      $CP_EV = 0;
                      $actosEV=datos_expediente\de_ev_actos::where('idExpediente',$idExp)
                        ->leftJoin('catrespuestas as cr', function($join)
                          {
                              $join->on('prode_ev_actos.TIPO_ACTOS_DE_INV','=','cr.id')
                              ->Where('cr.idTipoRespuesta','=',78);
                          })
                        ->leftJoin('catrespuestas as cr1', function($join)
                          {
                              $join->on('prode_ev_actos.TIPO_CONTROL_ACTOS_DE_INV','=','cr1.id')
                              ->Where('cr1.idTipoRespuesta','=',89);
                          })->select('prode_ev_actos.*',DB::raw('IFNULL(cr1.Valor,"-") AS Control'),DB::raw('IFNULL(cr.Valor,"-") AS Valor'))->get();
                   }
                  #endregion
                  
                  $listados2=['imputadosDDL'=>$imputadosDDL,'victimasDDL'=>$victimasDDL,'imputadosCP'=>$imputadosCP,'victimasCP'=>$victimasCP];
                  $listados=$listados+$listados2;
                #endregion

                #region MASC
                  #region Catalogos iniciales
                    $unidad= $this->GetDataById('catrespuestas','idTipoRespuesta',27);
                    $tipoCump= $this->GetDataById('catrespuestas','idTipoRespuesta',64);
                    $tipoMASC= $this->GetDataById('catrespuestas','idTipoRespuesta',67);
                    $autMASC= $this->GetDataById('catrespuestas','idTipoRespuesta',40);
                  #endregion                       
                  $imputadosMASC=[];
                  $imputadosMASC =  datos_expediente\de_imputados::leftJoin('catrespuestas as cr', function($join)
                    {
                        $join->on('prode_imputados.SEXO_IMPUTADO','=','cr.id')
                        ->Where('cr.idTipoRespuesta','=',17);
                    })
                    ->leftJoin('catrespuestas as cr2', function($join)
                    {
                        $join->on('prode_imputados.TIPO_MANDAMIENTO','=','cr2.id')
                        ->Where('cr2.idTipoRespuesta','=',66);
                    })
                    // ->leftJoin('catrespuestas as cr3', function($join)
                    // {
                    //     $join->on('procp_dg_imputados.FORMA_','=','cr3.id')
                    //     ->Where('cr3.idTipoRespuesta','=',50);
                    // })
                    // ->leftJoin('catrespuestas as cr4', function($join)
                    // {
                    //     $join->on('procp_dg_imputados.FORMA_','=','cr4.id')
                    //     ->Where('cr4.idTipoRespuesta','=',76);
                    // })
                    ->leftJoin('catrespuestas as crm1', function($join)
                    {
                        $join->on('prode_imputados.MASC','=','crm1.id')
                        ->Where('crm1.idTipoRespuesta','=',4);
                    })
                    ->leftJoin('catrespuestas as crm4', function($join)
                    {
                        $join->on('prode_imputados.TIPO_CUMPLIMIENTO','=','crm4.id')
                        ->Where('crm4.idTipoRespuesta','=',64);
                    })
                    ->leftJoin('catrespuestas as crm5', function($join)
                    {
                        $join->on('prode_imputados.TIPO_MASC','=','crm5.id')
                        ->Where('crm5.idTipoRespuesta','=',67);
                    })
                    ->leftJoin('catrespuestas as crm6', function($join)
                    {
                        $join->on('prode_imputados.AUTORIDAD_DERIVA_MASC','=','crm6.id')
                        ->Where('crm6.idTipoRespuesta','=',40);
                    })                       
                  ->where('idExpediente',$idExp)
                  ->select('prode_imputados.id','prode_imputados.id as idImputado',
                      DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN prode_imputados.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", prode_imputados.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Nombre'),
                      DB::raw('IFNULL(cr.Valor,"-") as Sexo'),DB::raw('IFNULL(cr2.Valor,"-") as tipoMandamiento'),'prode_imputados.EDAD_HECHOS_IMPUTADOS',
                      // DB::raw('IFNULL(cr3.Valor,"-") as forma'),DB::raw('IFNULL(cr4.Valor,"-") as estatus'),
                      // DB::raw('IFNULL(cr3.Valor,"-") as forma'),DB::raw('IFNULL(cr4.Valor,"-") as detencion'),
                      'prode_imputados.MASC',DB::raw('IFNULL(crm1.Valor,"-") as MASC1'),'prode_imputados.FECHA_DERIVA_MASC',
                      'prode_imputados.FECHA_CUMPL_MAS',DB::raw('IFNULL(crm4.Valor,"-") as MASC4'),
                      DB::raw('IFNULL(crm5.Valor,"-") as MASC5'),DB::raw('IFNULL(crm6.Valor,"-") as MASC6'),
                      )->groupby('prode_imputados.id')->get();                  
                #endregion
                  $esHomicidios=datos_expediente\de_hechos::where('idExpediente',$idExp)->whereIn('DELITO',[186,187,188,189,190])->count();
                $respuestas=['delegaciones' => $delegaciones, 'entidades' => $entidades, 'municipiosDel'=> $municipiosDel,
                        'uats'=> $uats, 'estatusCarpeta'=> $estatusCarpeta, 'recibida_por' => $recibida_por,
                        'medio_recepcion'=>$medio_recepcion, 'tipo_recepcion' => $tipo_recepcion, 'autoridad' => $autoridad,
                        'formaInicioCarpeta' => $formaInicioCarpeta, 'parentesco' => $parentesco, 'municipios' => $municipios,
                        'colonias' => $colonias, 'SiNoNoI' => $SiNoNoI, 'tipoCriterio' => $tipoCriterio,
                        'etapaProc' => $etapaProc, 'medioCon' => $medioCon, 'sentidoDete' => $sentidoDete,

                        'tipoDete'=>$tipoDete,'accionPenal'=>$accionPenal,'SiNo'=>$SiNo,'motivoReac'=>$motivoReac,
                        'autDetencion'=>$autDetencion,'UnidadQueRecibe'=>$UnidadQueRecibe,
                        'motivoDetermina'=>$motivoDetermina,'remisionOtraArea'=>$remisionOtraArea,'acuerdo_P_RD'=>$acuerdo_P_RD];

                $data= ['idExp' => bin2hex($idExp),'esHomicidios'=>$esHomicidios,
                        'idRegistro' => bin2hex($idRegistro), 'respuestas' => $respuestas, 'datos'=>$datos, 'listados'=>$listados,
                        'menuActivo' => $menuActivo, 'Ctrl' => $Ctrl, 'resumen'=>$resumen,
                  'SiNoNoA'=>$SiNoNoA,'SiNoNoI'=>$SiNoNoI, 'TMRestriccion'=>$TMRestriccion,'audineciaPx'=>$audineciaPx,
                  'TipoActo'=>$TipoActo,'TipoControl'=>$TipoControl,'impuestaPor'=>$impuestaPor,'estatusMJ'=>$estatusMJ,'formaProc'=>$formaProc,'EstatusCU'=>$EstatusCU,
                  'TipoMJ'=>$TipoMJ,'actosCon'=>$actosCon,'actosSin'=>$actosSin,
                  'CP_EV'=>$CP_EV,'actosEV'=>$actosEV,'medidas'=>$medidas,'actosConL'=>$actosConL,'actosSinL'=>$actosSinL,
                  'actosEV_DE'=>$actosEV_DE,'mandamientos_DE'=>$mandamientos_DE,'medidas_DE'=>$medidas_DE, 
                  'mandamientos'=>$mandamientos,'listados'=>$listados,

                  'imputadosMASC'=>$imputadosMASC,'unidad'=>$unidad, 'tipoCump'=>$tipoCump,'tipoMASC' => $tipoMASC,'autMASC'=>$autMASC,
                        ];                        
                return view('datos_expedientes.dashboard')->with($data);
                break;

             case 'd9'://////CONDUCCION
             case 'd9v'://////CONDUCCION VICTIMAS
             case 'd9i'://////CONDUCCION IMPUTADOS
             case 'd9d'://////CONDUCCION DELITOS
             case 'd9o'://////CONDUCCION OBJETOS
             case 'd9r'://////CONDUCCION RELACION 
                #region Catalogos iniciales
                 $delegaciones = $this->GetCatalogo('catdelegaciones');
                 $entidades = $this->GetDataById('catentidadesfederativas_inegi','id',5);
                 $entidades = $this->GetCatalogo('catentidadesfederativas_inegi');
                 $uats = $this->GetCatalogo('catuats');
                 $recibida_por = $this->GetDataById('catrespuestas','idTipoRespuesta',12);
                 $tipo_recepcion = $this->GetDataById('catrespuestas','idTipoRespuesta',2);
                 $UnidadQueRecibe = $this->GetDataById('catrespuestas','idTipoRespuesta',96);

                 $municipiosDel = []; $municipios = []; $colonias = []; $datos = []; $resumen = [];
                 $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];
                 $victimas = []; $imputados = []; $hechos = []; $objetos = []; $relaciones = [];
                 $listados=['victimas'=>$victimas,'imputados'=>$imputados,'hechos'=>$hechos,'objetos'=>$objetos,'relaciones'=>$relaciones];
                #endregion
                #region Obtener Datos
                  if ($idExp>0)
                  {
                    $datos =carpeta_conduccion\cc_datosgenerales::where('idExpediente',$idExp)->first();                   
                    $datos->FECHA_INICIO_CONDUCCION = empty(trim($datos->FECHA_INICIO_CONDUCCION))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO_CONDUCCION)));
                    $datos->FECHA_HECHOS_CONDUCCION = date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_HECHOS_CONDUCCION)));
                    $municipiosDel = $this->GetDataById('catmunicipios_inegi','idDelegacion',$datos->DELEGACION);
                    $municipios = $this->GetDataById('catmunicipios_inegi','CVE_ENT',$datos->ENTIDAD_HECHOS_CONDUCCION);
                    $colonias = $this->GetDataById('catcolonias','idMunicipio',$datos->MUNICIPIO_HECHOS);
                    $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                    $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                    $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                    $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                      'NUC' => 'N/A','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO_CONDUCCION))?'-':$datos->FECHA_INICIO_CONDUCCION??'-',
                      'validacion'=>$validacion,'correccion'=>$correccion,'idExpCorr'=>$idExp,'tablaCorr'=>'procc_datosgenerales'];

                    #region listados de victimas hechos imputados y objetos
                      $victimas=carpeta_conduccion\cc_victimas::where('idExpediente',$idExp)->orderByDesc('id')->get();
                      $imputados=carpeta_conduccion\cc_imputados::where('idExpediente',$idExp)->orderByDesc('id')->get();
                      $hechos=carpeta_conduccion\cc_hechos::join('catdelitosespecificos as catD','procc_hechos.DELITO', '=', 'catD.id')
                      ->where('idExpediente',$idExp)->orderByDesc('procc_hechos.id')->select('procc_hechos.id','catD.Valor')->get();
                      $objetos=carpeta_conduccion\cc_objetos::select(DB::raw('cr1.Valor as v1 ,cr2.Valor as v2,cr3.Valor as v3,crn1.Valor as vn1 ,crn2.Valor as vn2,crn3.Valor as vn3, procc_objetos.*'))
                      ->leftJoin('catrespuestas as cr1', function($join)
                      {
                          $join->on('procc_objetos.OBJETO_1','=','cr1.id')
                          ->Where('cr1.idTipoRespuesta','=',25);
                      })
                      ->leftJoin('catrespuestas as cr2', function($join)
                      {
                          $join->on('procc_objetos.OBJETO_2','=','cr2.id')
                          ->Where('cr2.idTipoRespuesta','=',25);
                      })
                      ->leftJoin('catrespuestas as cr3', function($join)
                      {
                          $join->on('procc_objetos.OBJETO_3','=','cr3.id')
                          ->Where('cr3.idTipoRespuesta','=',25);
                      })
                      ->leftJoin('catrespuestas as crn1', function($join)
                      {
                          $join->on('procc_objetos.TIPO_NARCOTICO_1','=','crn1.id')
                          ->Where('crn1.idTipoRespuesta','=',26);
                      })
                      ->leftJoin('catrespuestas as crn2', function($join)
                      {
                          $join->on('procc_objetos.TIPO_NARCOTICO_2','=','crn2.id')
                          ->Where('crn2.idTipoRespuesta','=',26);
                      })
                      ->leftJoin('catrespuestas as crn3', function($join)
                      {
                          $join->on('procc_objetos.TIPO_NARCOTICO_3','=','crn3.id')
                          ->Where('crn3.idTipoRespuesta','=',26);
                      })                      
                      ->where('idExpediente',$idExp)->orderByDesc('procc_objetos.id')->get();
                      // $relaciones=carpeta_conduccion\bitcc_relaciondelito::leftjoin('procc_relaciondelito as pdr','bitcc_relaciondelito.id','=','pdr.idRelacion')
                      // ->leftjoin('procc_victimas as pdv','pdr.idVictima','=','pdv.id')
                      // ->leftjoin('procc_imputados as pdi','pdr.idImputado','=','pdi.id')
                      // ->leftjoin('procc_hechos as pdh','bitcc_relaciondelito.idDelito','=','pdh.id')
                      // ->leftjoin('catdelitosespecificos as cde','pdh.DELITO','=','cde.id')
                      // ->select(DB::raw('GROUP_CONCAT(DISTINCT(cde.Valor)) AS delito'),
                      //     DB::raw("GROUP_CONCAT(DISTINCT(CONCAT(pdv.NOMBRE_VICTIMA,' ', pdv.PRIMER_APELLIDO,' ', pdv.SEGUNDO_APELLIDO_VICTIMAS))) victimas"),
                      //     DB::raw("GROUP_CONCAT(DISTINCT(CONCAT(pdi.NOMBRE_IMPUTADO,' ', pdi.PRIMER_APELLIDO,' ', pdi.SEGUNDO_APELLIDO_IMPUTADOS))) imputados"),
                      // )->where('bitcc_relaciondelito.idExpediente',$idExp)->groupby('bitcc_relaciondelito.id') ->get();

                      $listados=['victimas'=>$victimas,'imputados'=>$imputados,'hechos'=>$hechos,'objetos'=>$objetos,'relaciones'=>$relaciones];
                    #endregion                      
                  }                  
                #endregion
                #region menus
                    $menuActivo=['1m' => '','1d' => '', '2m' => '','2d' => '', '3m' => '','3d' => '', '4m' => '','4d' => '', '5m' => '','5d' => '', '6m' => '','6d' => '',];
                    switch ($Ctrl) {
                        case 'd9':
                            $menuActivo['1m']='active';
                            $menuActivo['1d']='show active';
                            break;
                        case 'd9v':
                            $menuActivo['2m']='active';
                            $menuActivo['2d']='show active';
                            break;
                        case 'd9i':
                            $menuActivo['3m']='active';
                            $menuActivo['3d']='show active';
                            break;
                        case 'd9d':
                            $menuActivo['4m']='active';
                            $menuActivo['4d']='show active';
                            break;
                        case 'd9o':
                            $menuActivo['5m']='active';
                            $menuActivo['5d']='show active';
                            break;
                        case 'd9r':
                            $menuActivo['6m']='active';
                            $menuActivo['6d']='show active';
                            break;
                        }
                #endregion                                          
                $data= ['idExp' => bin2hex($idExp),
                        'idRegistro' => bin2hex($idRegistro),
                        'delegaciones' => $delegaciones,
                        'entidades' => $entidades,
                        'municipiosDel'=> $municipiosDel,
                        'uats'=> $uats,
                        'municipios' => $municipios,
                        'colonias' => $colonias,
                        'recibida_por' => $recibida_por,
                        'tipo_recepcion' => $tipo_recepcion,
                        'UnidadQueRecibe'=>$UnidadQueRecibe,
                        'datos'=>$datos,
                        'listados' => $listados,
                        'menuActivo' => $menuActivo,
                        'Ctrl' => $Ctrl,
                        'resumen'=>$resumen];
                return view('carpeta_conduccion.dashboard')->with($data);

                break;

             case 'he'://////NO DELICTIVOS
             case 'hev'://////NO DELICTIVOS VICTIMAS
             case 'heo'://////NO DELICTIVOS OBJETOS
                #region Catalogos iniciales
                 $delegaciones = $this->GetCatalogo('catdelegaciones');
                 $entidades = $this->GetDataById('catentidadesfederativas_inegi','id',5);
                 $entidades = $this->GetCatalogo('catentidadesfederativas_inegi');
                 $uats = $this->GetCatalogo('catuats');
                 $recibida_por = $this->GetDataById('catrespuestas','idTipoRespuesta',12);
                 $noDelitos = $this->GetDataById('catrespuestas','idTipoRespuesta',70);
                 $municipiosDel = []; $municipios = []; $colonias = []; $datos = []; $resumen = [];
                 $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];
                 $victimas = []; $imputados = []; $hechos = []; $objetos = []; $relaciones = [];
                 $listados=['victimas'=>$victimas,'imputados'=>$imputados,'hechos'=>$hechos,'objetos'=>$objetos,'relaciones'=>$relaciones];

                #endregion
                #region Obtener Datos
                  if ($idExp>0)
                  {
                    $datos =no_delictivos\nd_datosgenerales::where('idExpediente',$idExp)->first(); 

                    $datos->FECHA_INICIO = empty(trim($datos->FECHA_INICIO))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO)));
                    $datos->FECHA_HECHOS_NO_DELICTIVOS = date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_HECHOS_NO_DELICTIVOS)));
                    $municipiosDel = $this->GetDataById('catmunicipios_inegi','idDelegacion',$datos->DELEGACION);
                    $municipios = $this->GetDataById('catmunicipios_inegi','CVE_ENT',$datos->ENTIDAD_HECHOS_NO_DELICTIVOS);
                    $colonias = $this->GetDataById('catcolonias','idMunicipio',$datos->MUNICIPIO_HECHOS);
                    $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                    $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                    $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                    $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                      'NUC' => 'N/A','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO))?'-':$datos->FECHA_INICIO??'-',
                      'validacion'=>$validacion,'correccion'=>$correccion,'idExpCorr'=>$idExp,'tablaCorr'=>'prond_datosgenerales'];

                    #region listados de victimas hechos imputados y objetos
                      $victimas=no_delictivos\nd_victimas::where('idExpediente',$idExp)->orderByDesc('id')->get();
                      
                      // $hechos=DB::table('prond_hechos as ph')->join('catdelitosespecificos as catD','ph.DELITO', '=', 'catD.id')
                      //->where('idExpediente',$idExp)->orderByDesc('ph.id')->select('ph.id','catD.Valor')->get();
                      $objetos=no_delictivos\nd_objetos::select(DB::raw('cr1.Valor as v1 ,cr2.Valor as v2,cr3.Valor as v3,crn1.Valor as vn1 ,crn2.Valor as vn2,crn3.Valor as vn3, prond_objetos.*'))
                      ->leftJoin('catrespuestas as cr1', function($join)
                      {
                          $join->on('prond_objetos.OBJETO_1','=','cr1.id')
                          ->Where('cr1.idTipoRespuesta','=',25);
                      })
                      ->leftJoin('catrespuestas as cr2', function($join)
                      {
                          $join->on('prond_objetos.OBJETO_2','=','cr2.id')
                          ->Where('cr2.idTipoRespuesta','=',25);
                      })
                      ->leftJoin('catrespuestas as cr3', function($join)
                      {
                          $join->on('prond_objetos.OBJETO_3','=','cr3.id')
                          ->Where('cr3.idTipoRespuesta','=',25);
                      })
                      ->leftJoin('catrespuestas as crn1', function($join)
                      {
                          $join->on('prond_objetos.TIPO_NARCOTICO_1','=','crn1.id')
                          ->Where('crn1.idTipoRespuesta','=',26);
                      })
                      ->leftJoin('catrespuestas as crn2', function($join)
                      {
                          $join->on('prond_objetos.TIPO_NARCOTICO_2','=','crn2.id')
                          ->Where('crn2.idTipoRespuesta','=',26);
                      })
                      ->leftJoin('catrespuestas as crn3', function($join)
                      {
                          $join->on('prond_objetos.TIPO_NARCOTICO_3','=','crn3.id')
                          ->Where('crn3.idTipoRespuesta','=',26);
                      })

                      ->where('idExpediente',$idExp)->orderByDesc('prond_objetos.id')->get();
                      // $relaciones=carpeta_conduccion\bitcc_relaciondelito::leftjoin('procc_relaciondelito as pdr','bitcc_relaciondelito.id','=','pdr.idRelacion')
                      // ->leftjoin('procc_victimas as pdv','pdr.idVictima','=','pdv.id')
                      // ->leftjoin('procc_imputados as pdi','pdr.idImputado','=','pdi.id')
                      // ->leftjoin('procc_hechos as pdh','bitcc_relaciondelito.idDelito','=','pdh.id')
                      // ->leftjoin('catdelitosespecificos as cde','pdh.DELITO','=','cde.id')
                      // ->select(DB::raw('GROUP_CONCAT(DISTINCT(cde.Valor)) AS delito'),
                      //     DB::raw("GROUP_CONCAT(DISTINCT(CONCAT(pdv.NOMBRE_VICTIMA,' ', pdv.PRIMER_APELLIDO,' ', pdv.SEGUNDO_APELLIDO_VICTIMAS))) victimas"),
                      //     DB::raw("GROUP_CONCAT(DISTINCT(CONCAT(pdi.NOMBRE_IMPUTADO,' ', pdi.PRIMER_APELLIDO,' ', pdi.SEGUNDO_APELLIDO_IMPUTADOS))) imputados"),
                      // )->where('bitcc_relaciondelito.idExpediente',$idExp)->groupby('bitcc_relaciondelito.id') ->get();

                      $listados=['victimas'=>$victimas,'imputados'=>$imputados,'hechos'=>$hechos,'objetos'=>$objetos,'relaciones'=>$relaciones];
                    #endregion                      
                  }
                  
                #endregion
                #region menus
                    $menuActivo=['1m' => '','1d' => '', '2m' => '','2d' => '', '3m' => '','3d' => '', '4m' => '','4d' => ''];
                    switch ($Ctrl) {
                        case 'he':
                            $menuActivo['1m']='active';
                            $menuActivo['1d']='show active';
                            break;
                        case 'hev':
                            $menuActivo['2m']='active';
                            $menuActivo['2d']='show active';
                            break;
                        case 'heo':
                            $menuActivo['3m']='active';
                            $menuActivo['3d']='show active';
                            break;
                        case 'her':
                            $menuActivo['4m']='active';
                            $menuActivo['4d']='show active';
                            break;
                        }
                #endregion
                $data= ['idExp' => bin2hex($idExp),
                        'idRegistro' => bin2hex($idRegistro),
                        'delegaciones' => $delegaciones,
                        'entidades' => $entidades,
                        'municipiosDel'=> $municipiosDel,
                        'uats'=> $uats,
                        'municipios' => $municipios,
                        'colonias' => $colonias,
                        'recibida_por' => $recibida_por,
                        'noDelitos' => $noDelitos,
                        'datos' => $datos,
                        'listados' => $listados,
                        'menuActivo' => $menuActivo,
                        'Ctrl' => $Ctrl,
                        'resumen'=>$resumen];

                return view('no_delictivos.dashboard')->with($data);
                break;

             case 'od0'://////LISTADO CAUSAS PENALES
             case 'd0'://////CAUSAS PENALES        
              #region Catalogos iniciales
                // $SiNoNoA= $this->GetDataById('catrespuestas','idTipoRespuesta',3);
                // $tipoAtencion= $this->GetDataById('catrespuestas','idTipoRespuesta',62);
                // $sentidoConc= $this->GetDataById('catrespuestas','idTipoRespuesta',57);
                // $sentidoDete= $this->GetDataById('catrespuestas','idTipoRespuesta',58);
                $unidad= $this->GetDataById('catrespuestas','idTipoRespuesta',27);
                $formaInicioCarpeta = $this->GetDataById('catrespuestas','idTipoRespuesta',50);
                $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
                $SiNo = $this->GetDataById('catrespuestas','idTipoRespuesta',2);
                $tipoCump= $this->GetDataById('catrespuestas','idTipoRespuesta',64);
                $tipoMASC= $this->GetDataById('catrespuestas','idTipoRespuesta',67);
                $autMASC= $this->GetDataById('catrespuestas','idTipoRespuesta',40);
                // $actosCon= $this->GetDataById('catrespuestas','idTipoRespuesta',29);
                // $actosSin= $this->GetDataById('catrespuestas','idTipoRespuesta',30);
                $momentoReclas= $this->GetDataById('catrespuestas','idTipoRespuesta',69);
                // $estatusMJ= $this->GetDataById('catrespuestas','idTipoRespuesta',45);
                // $formaProc=$this->GetDataById('catrespuestas','idTipoRespuesta',51);
                $detencionLI=$this->GetDataById('catrespuestas','idTipoRespuesta',76);
                $distJud=$this->GetDataById('catrespuestas','idTipoRespuesta',97);
                $formaProc=$this->GetDataById('catrespuestas','idTipoRespuesta',51);
                $causas=[];$resumen=[]; $imputados=[]; $victimas=[]; $delitos=[];
                $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];
                $datos=null;$noAcuerdos=0;
                $datosCP=null;$CAhtml='';$delitosCP=[];$victimasCP=[];$imputadosCP=[];$imputadosMASC=[];
                $audienciaInicial=[];$causasAC=[];
              #endregion   
              DB::statement("SET SQL_MODE=''");           
              #region Obtener Datos
                if ($idExp > 0)
                {
                  $datos = datos_expediente\de_datosgenerales::where('id',$idExp)->first();
                  $datos->FECHA_INICIO_CARPETA = empty(trim($datos->FECHA_INICIO_CARPETA))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO_CARPETA)));
                  $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                    $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                    $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                    $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();                    
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                  'NUC' => $datos->NUC_COMPLETA??'-','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO_CARPETA))?'-':$datos->FECHA_INICIO_CARPETA??'-',
                  'validacion'=>$validacion,'correccion'=>$correccion,'idExpCorr'=>$idExp,'tablaCorr'=>'prode_datosgenerales'];                    
                    #region listados del expediente
                      $causas= causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','pdg.id','=','procp_datosgenerales.idExpediente')
                        ->where('pdg.id',$idExp)->where('procp_datosgenerales.id','!=',$idRegistro)->orderByDesc('procp_datosgenerales.id')
                        ->leftjoin(DB::raw("(select idCausa, GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_IMPUTADO=2 THEN pdei.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(pdei.NOMBRE_IMPUTADO,' ',pdei.PRIMER_APELLIDO,' ',pdei.SEGUNDO_APELLIDO_IMPUTADOS)END)) as imputados from procp_dg_imputados pcpi left join prode_imputados pdei on pcpi.idImputado=pdei.id WHERE pcpi.deleted_at IS NULL GROUP BY idCausa) as imp"),'imp.idCausa', '=', 'procp_datosgenerales.id')
                        ->leftjoin(DB::raw("(select idCausa, GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_VICTIMA=2 THEN pdev.RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(pdev.NOMBRE_VICTIMA,' ',pdev.PRIMER_APELLIDO,' ',pdev.SEGUNDO_APELLIDO_VICTIMAS)END)) as victimas from procp_dg_victimas pcpv left join prode_victimas pdev on pcpv.idVictima =pdev.id WHERE pcpv.deleted_at IS NULL GROUP BY idCausa) as vic"),'vic.idCausa', '=', 'procp_datosgenerales.id')                      
                        // ->leftjoin(DB::raw("(select idCausa, GROUP_CONCAT(DISTINCT(CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cde.Valor,' [',cdj.cClaveDelito,'-',cdj.Valor,']') END)) as delitos from procp_dg_delitos pcpd left join prode_hechos pdeh on pcpd.idDelito =pdeh.id left join catdelitosespecificos cde on cde.id=pdeh.DELITO left join catdelitosjur cdj on cdj.id=pdeh.DELITO_JUR WHERE pcpd.deleted_at IS NULL GROUP BY idCausa) as del"),'del.idCausa', '=', 'procp_datosgenerales.id')
                        ->leftjoin(DB::raw("(select idCausa, GROUP_CONCAT(DISTINCT(CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cdj.cClaveDelito,'-',cdj.Valor) END)) as delitos from procp_dg_delitos pcpd left join prode_hechos pdeh on pcpd.idDelito =pdeh.id left join catdelitosespecificos cde on cde.id=pdeh.DELITO left join catdelitosjur cdj on cdj.id=pdeh.DELITO_JUR WHERE pcpd.deleted_at IS NULL GROUP BY idCausa) as del"),'del.idCausa', '=', 'procp_datosgenerales.id')
                            // ->leftjoin('procp_dg_acumuladas as acum', function($join) use($idRegistro){
                            //     $join->on('acum.idCausaRel','=','procp_datosgenerales.id')->where('acum.idCausa', '=',$idRegistro)
                            //     ->whereNull('acum.deleted_at');
                            //   })
                            //->leftJoin('procp_audienciainicial as pa','pa.idCausa','=','procp_datosgenerales.id')
                            //->select('acum.idCausaRel')
                        ->leftjoin(DB::raw("(select idCausa, CASE WHEN count(idCausa)>0 THEN 1 ELSE 0 END as Vigencia from procp_audienciainicial pcpa WHERE IFNULL(pcpa.FECHA_CIERRE,'')='' AND IFNULL((90-DATEDIFF(NOW(),pcpa.FECHA_INICIO_INVESTIGACION)<15),0) GROUP BY idCausa) as vig"),'vig.idCausa', '=', 'procp_datosgenerales.id')
                      ->select('pdg.NUC_COMPLETA AS NUC','procp_datosgenerales.CAUSA_PENAL_ID','procp_datosgenerales.id','imp.imputados','vic.victimas','del.delitos',
                           // DB::raw("CASE WHEN IFNULL(pa.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),pa.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia")
                        DB::raw("vig.Vigencia as Vigencia"))->groupby('procp_datosgenerales.id')->get();


                      $causasAC= causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','pdg.id','=','procp_datosgenerales.idExpediente')
                        ->where('pdg.id','!=',$idExp)->where('procp_datosgenerales.id','!=',$idRegistro)->orderByDesc('procp_datosgenerales.id')
                        ->leftjoin(DB::raw("(select idCausa, GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_IMPUTADO=2 THEN pdei.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(pdei.NOMBRE_IMPUTADO,' ',pdei.PRIMER_APELLIDO,' ',pdei.SEGUNDO_APELLIDO_IMPUTADOS)END)) as imputados from procp_dg_imputados pcpi left join prode_imputados pdei on pcpi.idImputado=pdei.id WHERE pcpi.deleted_at IS NULL GROUP BY idCausa) as imp"),'imp.idCausa', '=', 'procp_datosgenerales.id')
                        ->leftjoin(DB::raw("(select idCausa, GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_VICTIMA=2 THEN pdev.RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(pdev.NOMBRE_VICTIMA,' ',pdev.PRIMER_APELLIDO,' ',pdev.SEGUNDO_APELLIDO_VICTIMAS)END)) as victimas from procp_dg_victimas pcpv left join prode_victimas pdev on pcpv.idVictima =pdev.id WHERE pcpv.deleted_at IS NULL GROUP BY idCausa) as vic"),'vic.idCausa', '=', 'procp_datosgenerales.id')                      
                        // ->leftjoin(DB::raw("(select idCausa, GROUP_CONCAT(DISTINCT(CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cde.Valor,' [',cdj.cClaveDelito,'-',cdj.Valor,']') END)) as delitos from procp_dg_delitos pcpd left join prode_hechos pdeh on pcpd.idDelito =pdeh.id left join catdelitosespecificos cde on cde.id=pdeh.DELITO left join catdelitosjur cdj on cdj.id=pdeh.DELITO_JUR WHERE pcpd.deleted_at IS NULL GROUP BY idCausa) as del"),'del.idCausa', '=', 'procp_datosgenerales.id')
                        ->leftjoin(DB::raw("(select idCausa, GROUP_CONCAT(DISTINCT(CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cdj.cClaveDelito,'-',cdj.Valor) END)) as delitos from procp_dg_delitos pcpd left join prode_hechos pdeh on pcpd.idDelito =pdeh.id left join catdelitosespecificos cde on cde.id=pdeh.DELITO left join catdelitosjur cdj on cdj.id=pdeh.DELITO_JUR WHERE pcpd.deleted_at IS NULL GROUP BY idCausa) as del"),'del.idCausa', '=', 'procp_datosgenerales.id')
                        ->leftjoin('procp_dg_acumuladas as acum', function($join) use($idRegistro){
                            $join->on('acum.idCausaRel','=','procp_datosgenerales.id')->where('acum.idCausa', '=',$idRegistro)
                            ->whereNull('acum.deleted_at');
                          })
                        ->leftJoin('procp_audienciainicial as pa','pa.idCausa','=','procp_datosgenerales.id')
                        ->select('acum.idCausaRel','pdg.NUC_COMPLETA AS NUC','procp_datosgenerales.CAUSA_PENAL_ID','procp_datosgenerales.id','imp.imputados','vic.victimas','del.delitos',DB::raw("CASE WHEN IFNULL(pa.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),pa.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"))
                      ->take(3)->distinct()->get();
                      $imputados= datos_expediente\de_imputados::where('idExpediente',$idExp)
                      // ->whereRaw("prode_imputados.id NOT IN (select idImputado from procp_dg_imputados where idCausa='".$idRegistro."')")
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('prode_imputados.SEXO_IMPUTADO','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })
                      ->leftJoin('catrespuestas as cr2', function($join)
                      {
                          $join->on('prode_imputados.TIPO_MANDAMIENTO','=','cr2.id')
                          ->Where('cr2.idTipoRespuesta','=',66);
                      })->select('prode_imputados.id',
                      DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),
                      DB::raw('CONCAT(IFNULL(cr.Valor,"-"),"|",EDAD_HECHOS_IMPUTADOS,"|",IFNULL(cr2.Valor,"-")) as addrow'),
                      'DETENIDO_IMPUTADOS')->get();
                      
                      $victimas = datos_expediente\de_victimas::where('idExpediente',$idExp)
                      ->whereRaw("prode_victimas.id NOT IN (select idVictima from procp_dg_victimas where idCausa='".$idRegistro."' AND deleted_at IS NULL)")
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('prode_victimas.SEXO_VICTIMA','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })->select('prode_victimas.id',
                      DB::raw('CASE WHEN TIPO_VICTIMA=2 THEN RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN "LA SOCIEDAD" WHEN TIPO_VICTIMA=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_VICTIMA=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_VICTIMA," ", PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_VICTIMAS) END as Valor'),
                      DB::raw('CASE WHEN TIPO_VICTIMA=2 THEN CONCAT(RAZON_SOCIAL,"|-|-|-|-") WHEN TIPO_VICTIMA=3 THEN CONCAT("LA SOCIEDAD|-|-|-|-") WHEN TIPO_VICTIMA=5 THEN CONCAT("SIN IDENTIFICAR/DESCONOCIDO|-|-|-|-") WHEN TIPO_VICTIMA=7 THEN CONCAT("LA SALUD|-|-|-|-") ELSE CONCAT(NOMBRE_VICTIMA,"|", PRIMER_APELLIDO,"|", SEGUNDO_APELLIDO_VICTIMAS,"|",IFNULL(cr.Valor,"-"),"|",EDAD_HECHOS_VICTIMAS) END as addrow'))->get();                      
                      $delitos =  datos_expediente\de_hechos::join('catdelitosespecificos as cde','prode_hechos.DELITO','=','cde.id')
                      ->leftjoin('catdelitosjur as cdj','prode_hechos.DELITO_JUR','=','cdj.id')
                      ->where('idExpediente',$idExp)
                      ->whereRaw("prode_hechos.id NOT IN (select idDelito from procp_dg_delitos where idCausa='".$idRegistro."' AND deleted_at IS NULL)")
                      ->select('prode_hechos.id',
                        // DB::raw('CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cde.Valor," [",cdj.cClaveDelito,"-",cdj.Valor,"]") END as Valor')
                        DB::raw('CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cdj.cClaveDelito,"-",cdj.Valor) END as Valor'))->get();                                 
                    #endregion                  
                  if ($idRegistro > 0) {
                    $datosCP = causas_penales\cp_datosgenerales::where('id',$idRegistro)->first();
                    $causasAcumuladas = causas_penales\cp_dg_acumuladas::leftjoin('procp_datosgenerales as cpdg','procp_dg_acumuladas.idCausaRel','=','cpdg.id')
                    ->where('idCausa',$idRegistro)->select('cpdg.CAUSA_PENAL_ID','cpdg.id')->get();
                    foreach ($causasAcumuladas as $key => $value) {                    
                    
                      $CAhtml.='<span class="mx-1 badge rounded-pill bg-info text-dark" id="span_'.$value['id'].'">'.$value['CAUSA_PENAL_ID'].
                      '<button type="button" class="btn-close" onclick="eliminar(this,1)"></button></span>';                                      
                    }
                      $audienciaInicial = causas_penales\cp_audienciainicial::where('idCausa',$idRegistro)
                        ->select(DB::raw("CASE WHEN IFNULL(procp_audienciainicial.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                          DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'),
                          'procp_audienciainicial.*')
                        ->whereRaw("IFNULL(procp_audienciainicial.FECHA_CIERRE,'')='' AND IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0)")
                        ->first();

                    $delitosCP =  causas_penales\cp_dg_delitos::leftjoin('prode_hechos as pdh','procp_dg_delitos.idDelito','=','pdh.id')
                      ->leftjoin('catdelitosespecificos as cde','cde.id','=','pdh.DELITO')
                      ->leftjoin('catdelitosjur as cdj','pdh.DELITO_JUR','=','cdj.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('procp_dg_delitos.RECLASIFICACION','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',2);
                      })
                      ->leftJoin('catrespuestas as cr2', function($join)
                      {
                          $join->on('procp_dg_delitos.MOMENTO_RECLAS','=','cr2.id')
                          ->Where('cr2.idTipoRespuesta','=',69);
                      })->where('idCausa',$idRegistro)
                      ->select('procp_dg_delitos.id','procp_dg_delitos.idDelito',
                        // DB::raw('CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cde.Valor," [",cdj.cClaveDelito,"-",cdj.Valor,"]") END as Valor'),
                        DB::raw('CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cdj.cClaveDelito,"-",cdj.Valor) END as Valor'),
                        DB::raw('IFNULL(cr.Valor,"-") as RECLASIFICACION'),
                        DB::raw('IFNULL(cr2.Valor,"-") as MOMENTO'),'procp_dg_delitos.FECHA_RECLAS','procp_dg_delitos.DELITO_DE_ACUERDO_CON_LEY')
                      ->get(); 

                    $victimasCP =  causas_penales\cp_dg_victimas::leftjoin('prode_victimas as pdv','procp_dg_victimas.idVictima','=','pdv.id')
                    ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdv.SEXO_VICTIMA','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })->where('idCausa',$idRegistro)
                    ->select('procp_dg_victimas.id','procp_dg_victimas.idVictima','TIPO_VICTIMA','RAZON_SOCIAL','NOMBRE_VICTIMA', 'PRIMER_APELLIDO','SEGUNDO_APELLIDO_VICTIMAS',DB::raw('IFNULL(cr.Valor,"-") as Sexo'),'EDAD_HECHOS_VICTIMAS')
                    ->get();  
                    DB::statement("SET SQL_MODE=''");
                    $imputadosCP =  causas_penales\cp_dg_relacionimputado::leftJoin('procp_dg_imputados as pcpi', function($join)
                      {
                        $join->on('pcpi.id','=','procp_dg_relacionimputado.idcp_dg_imputados')
                        ->whereNull('pcpi.deleted_at');
                      })
                      ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })
                      ->leftJoin('catrespuestas as cr2', function($join)
                      {
                          $join->on('pdi.TIPO_MANDAMIENTO','=','cr2.id')
                          ->Where('cr2.idTipoRespuesta','=',66);
                      })
                      ->leftJoin('catrespuestas as cr3', function($join)
                      {
                          $join->on('pcpi.FORMA_','=','cr3.id')
                          ->Where('cr3.idTipoRespuesta','=',50);
                      })
                      ->leftJoin('catrespuestas as cr4', function($join)
                      {
                          $join->on('pcpi.DETENCION_LEGAL_ILEGAL','=','cr4.id')
                          ->Where('cr4.idTipoRespuesta','=',76);
                      })
                      ->leftJoin('catrespuestas as cr4_', function($join)
                      {
                          $join->on('pcpi.FORMA_PROCESO','=','cr4_.id')
                          ->Where('cr4_.idTipoRespuesta','=',51);
                      })                                            
                      ->leftJoin('catrespuestas as crm1', function($join)
                      {
                          $join->on('pcpi.MASC','=','crm1.id')
                          ->Where('crm1.idTipoRespuesta','=',4);
                      })
                      ->leftJoin('catrespuestas as crm4', function($join)
                      {
                          $join->on('pcpi.TIPO_CUMPLIMIENTO','=','crm4.id')
                          ->Where('crm4.idTipoRespuesta','=',64);
                      })
                      ->leftJoin('catrespuestas as crm5', function($join)
                      {
                          $join->on('pcpi.TIPO_MASC','=','crm5.id')
                          ->Where('crm5.idTipoRespuesta','=',67);
                      })
                      ->leftJoin('catrespuestas as crm6', function($join)
                      {
                          $join->on('pcpi.AUTORIDAD_DERIVA_MASC','=','crm6.id')
                          ->Where('crm6.idTipoRespuesta','=',40);
                      })
                      ->leftjoin('prode_victimas as pdv','pdv.id','=','procp_dg_relacionimputado.idVictima')
                      ->leftjoin('prode_hechos as pdh','pdh.id','=','procp_dg_relacionimputado.idDelito')
                      ->leftjoin('catdelitosespecificos as cde','cde.id','=','pdh.DELITO')
                      ->leftjoin('catdelitosjur as cdj','pdh.DELITO_JUR','=','cdj.id')
                      ->where('idCausa',$idRegistro)
                      ->select('pcpi.id','pcpi.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Nombre'),
                        DB::raw('IFNULL(cr.Valor,"-") as Sexo'),DB::raw('IFNULL(cr2.Valor,"-") as tipoMandamiento'),'pdi.EDAD_HECHOS_IMPUTADOS',
                        // DB::raw('IFNULL(cr3.Valor,"-") as forma'),DB::raw('IFNULL(cr4.Valor,"-") as estatus'),
                        DB::raw('IFNULL(cr3.Valor,"-") as forma'),DB::raw('IFNULL(cr4.Valor,"-") as detencion'),DB::raw('IFNULL(cr4_.Valor,"-") as forma_proceso'),
                        DB::raw('IFNULL(crm1.Valor,"-") as MASC1'),'pcpi.FECHA_DERIVA_MASC',
                        'pcpi.FECHA_CUMPL_MAS',DB::raw('IFNULL(crm4.Valor,"-") as MASC4'),
                        DB::raw('IFNULL(crm5.Valor,"-") as MASC5'),DB::raw('IFNULL(crm6.Valor,"-") as MASC6'),
                        'pcpi.OBSERVACIONES_ILEGAL',
                        DB::raw("GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_VICTIMA=2 THEN pdv.RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(pdv.NOMBRE_VICTIMA,' ',pdv.PRIMER_APELLIDO,' ',pdv.SEGUNDO_APELLIDO_VICTIMAS) END)) as victimas"),
                        // DB::raw('GROUP_CONCAT(DISTINCT(CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cde.Valor," [",cdj.cClaveDelito,"-",cdj.Valor,"]") END)) as delitos')
                        DB::raw('GROUP_CONCAT(DISTINCT(CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cdj.cClaveDelito,"-",cdj.Valor) END)) as delitos')
                        // ,'pcpi.FECHA_MANDAMIENTO','pcpi.FECHA_LIBERA'
                        )->groupby('pcpi.id')->get();
                      $imputadosMASC =  causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })
                      ->leftJoin('catrespuestas as cr2', function($join)
                      {
                          $join->on('pdi.TIPO_MANDAMIENTO','=','cr2.id')
                          ->Where('cr2.idTipoRespuesta','=',66);
                      })
                      ->leftJoin('catrespuestas as cr3', function($join)
                      {
                          $join->on('procp_dg_imputados.FORMA_','=','cr3.id')
                          ->Where('cr3.idTipoRespuesta','=',50);
                      })
                      ->leftJoin('catrespuestas as cr4', function($join)
                      {
                          $join->on('procp_dg_imputados.FORMA_','=','cr4.id')
                          ->Where('cr4.idTipoRespuesta','=',76);
                      })
                      ->leftJoin('catrespuestas as crm1', function($join)
                      {
                          $join->on('procp_dg_imputados.MASC','=','crm1.id')
                          ->Where('crm1.idTipoRespuesta','=',4);
                      })
                      ->leftJoin('catrespuestas as crm4', function($join)
                      {
                          $join->on('procp_dg_imputados.TIPO_CUMPLIMIENTO','=','crm4.id')
                          ->Where('crm4.idTipoRespuesta','=',64);
                      })
                      ->leftJoin('catrespuestas as crm5', function($join)
                      {
                          $join->on('procp_dg_imputados.TIPO_MASC','=','crm5.id')
                          ->Where('crm5.idTipoRespuesta','=',67);
                      })
                      ->leftJoin('catrespuestas as crm6', function($join)
                      {
                          $join->on('procp_dg_imputados.AUTORIDAD_DERIVA_MASC','=','crm6.id')
                          ->Where('crm6.idTipoRespuesta','=',40);
                      })                       
                      ->where('idCausa',$idRegistro)
                      ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Nombre'),
                        DB::raw('IFNULL(cr.Valor,"-") as Sexo'),DB::raw('IFNULL(cr2.Valor,"-") as tipoMandamiento'),'pdi.EDAD_HECHOS_IMPUTADOS',
                        // DB::raw('IFNULL(cr3.Valor,"-") as forma'),DB::raw('IFNULL(cr4.Valor,"-") as estatus'),
                        DB::raw('IFNULL(cr3.Valor,"-") as forma'),DB::raw('IFNULL(cr4.Valor,"-") as detencion'),
                        'procp_dg_imputados.MASC',DB::raw('IFNULL(crm1.Valor,"-") as MASC1'),'procp_dg_imputados.FECHA_DERIVA_MASC',
                        'procp_dg_imputados.FECHA_CUMPL_MAS',DB::raw('IFNULL(crm4.Valor,"-") as MASC4'),
                        DB::raw('IFNULL(crm5.Valor,"-") as MASC5'),DB::raw('IFNULL(crm6.Valor,"-") as MASC6'),
                        )->groupby('procp_dg_imputados.id')->get();
                  }
                  // $ei_imAcuerdos=causas_penales\cp_ei_imputados::where('idCausa',$idRegistro)->where('ACUERDO_REPARATORIO','>',-1)
                  // ->count();
                  // $ai_imAcuerdos=causas_penales\cp_ai_imputados::where('idCausa',$idRegistro)->where('ACUERDO_REPARATORIO','>',-1)
                  // ->count();
                  //$noAcuerdos=$ei_imAcuerdos+$ai_imAcuerdos;
                  $noAcuerdos=causas_penales\cp_sa_acuerdos::leftJoin('procp_salidasalternas as pcpsa', function($join)
                      {
                        $join->on('pcpsa.id','=','procp_sa_acuerdos.id_cp_salidasalternas')
                        ->whereNull('pcpsa.deleted_at');
                      })->where('idCausa',$idRegistro)->count();
                }   
              #endregion
                $listados=['causas'=>$causas, 'causasAC'=>$causasAC,'imputados'=>$imputados, 'victimas'=>$victimas, 'delitos'=>$delitos];
                    
                #region menus
                 $menuActivo=['1m' => '','1d' => '', '2m' => '','2d' => '', '3m' => '','3d' => '', '4m' => '','4d' => '', '5m' => '','5d' => '', '6m' => '','6d' => '',
                 '7m' => '','7d' => '','8m' => '','8d' => '','9m' => '','9d' => '','10m' => '','10d' => '',];
                 $menuActivo['1m']='active';
                 $menuActivo['1d']='show active';
                #endregion
                $data=[//'tipoAtencion'=>$tipoAtencion, 'sentidoConc'=>$sentidoConc,'sentidoDete'=>$sentidoDete,
                        'unidad'=>$unidad, 'formaInicioCarpeta'=>$formaInicioCarpeta, 'SiNoNoI'=>$SiNoNoI,
                        'tipoCump'=>$tipoCump,'tipoMASC' => $tipoMASC,'autMASC'=>$autMASC,
                        //'actosCon'=>$actosCon,'actosSin'=>$actosSin, 
                        'momentoReclas'=>$momentoReclas,'SiNo' =>$SiNo,
                        //'estatusMJ'=>$estatusMJ,'formaProc'=>$formaProc,
                        'detencionLI'=>$detencionLI,'distJud'=>$distJud,'formaProc'=>$formaProc,
                        'datos'=>$datos,'noAcuerdos'=>$noAcuerdos, 
                        'datosCP'=>$datosCP, 'CAhtml'=>$CAhtml,'delitosCP'=>$delitosCP,'victimasCP'=>$victimasCP,'imputadosCP'=>$imputadosCP,'imputadosMASC'=>$imputadosMASC,'audienciaInicial'=>$audienciaInicial,
                        'listados'=>$listados,'menuActivo' => $menuActivo,'Ctrl'=>$Ctrl,'resumen'=>$resumen,
                        'idExp' => bin2hex($idExp), 'idRegistro' => bin2hex($idRegistro),];
                        // 'SiNo'=>$SiNo, 'SiNoNoA'=>$SiNoNoA,
                  $mostrarCP=datos_expediente\de_datosgenerales::where('idExpediente',$idExp)->where('SENTIDO_DETERMINACION','=',10)->count();
                    return view('causas_penales.dashboard',compact('mostrarCP'))->with($data);
                break;

             case 'd0ev'://////CAUSAS PENALES ETAPA INVESTIGACION
                #region Catalogos iniciales
                  $SiNoNoA= $this->GetDataById('catrespuestas','idTipoRespuesta',3);
                  $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
                  $TMRestriccion= $this->GetDataById('catrespuestas','idTipoRespuesta',28);
                  $audineciaPx= $this->GetDataById('catrespuestas','idTipoRespuesta',31);
                  $TipoControl= $this->GetDataById('catrespuestas','idTipoRespuesta',89);
                  $TipoActo= $this->GetDataById('catrespuestas','idTipoRespuesta',78);
                  $impuestaPor= $this->GetDataById('catrespuestas','idTipoRespuesta',79);
                  $estatusMJ= $this->GetDataById('catrespuestas','idTipoRespuesta',80);
                  $TipoMJ= $this->GetDataById('catrespuestas','idTipoRespuesta',81);
                  $actosCon= $this->GetDataById('catrespuestas','idTipoRespuesta',29);
                  $actosSin= $this->GetDataById('catrespuestas','idTipoRespuesta',30);
                  $formaProc=$this->GetDataById('catrespuestas','idTipoRespuesta',51);
                  $EstatusCU= $this->GetDataById('catrespuestas','idTipoRespuesta',87);
                  
                #endregion
                $resumen=[]; $victimasDDL=[];$audienciaInicial=[];
                $imputadosCP_F=[]; $imputadosDDL_F=[];
                $imputadosCP_M=[]; $imputadosDDL_M=[];
                $imputadosCP_A=[]; $imputadosDDL_A=[];
                $imputadosCP_C=[]; $imputadosDDL_C=[];
                $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];
                $actosEV=[]; $victimasCP=[];$medidas=[];$actosConL=[];$actosSinL=[];$CP_EV=0;$mandamientos=[];
                $actosEV_DE=[];$mandamientos_DE=[];$medidas_DE=[];
                #region Obtener Datos
                 if ($idExp > 0)
                 {
                  $datos = datos_expediente\de_datosgenerales::where('id',$idExp)->first();
                  $datos->FECHA_INICIO_CARPETA = empty(trim($datos->FECHA_INICIO_CARPETA))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO_CARPETA)));
                  $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                  $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                  $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                  $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();                    
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                  'NUC' => $datos->NUC_COMPLETA??'-','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO_CARPETA))?'-':$datos->FECHA_INICIO_CARPETA??'-','validacion'=>$validacion,'correccion'=>$correccion,
                  'idExpCorr'=>$idExp,'tablaCorr'=>'prode_datosgenerales'];
                  if ($idRegistro > 0) {
                    DB::statement("SET SQL_MODE=''");
                    $imputadosDDL_F = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })                                            
                      ->where('idCausa',$idRegistro)
                      ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_ev_imputados pei left join procp_dg_imputados pcpdgi on pei.idImputado=pcpdgi.id where pei.idCausa='".$idRegistro."' AND bitFlagrancia=1 AND pei.deleted_at IS NULL)")                    
                      ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                      DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),'pdi.FECHA_DETENCION',
                      DB::raw('CASE WHEN procp_dg_imputados.DETENCION_LEGAL_ILEGAL=1 THEN "LEGAL" ELSE "ILEGAL" END as DETENCION_LEGAL_ILEGAL')
                      )->groupby('procp_dg_imputados.idImputado')->get();  

                    $imputadosCP_F = causas_penales\cp_ev_imputados::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_ev_imputados.idImputado')
                      ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })                                            
                      ->where('procp_ev_imputados.idCausa',$idRegistro)->where('bitFlagrancia','=',1)
                      ->select('procp_ev_imputados.*','procp_ev_imputados.id','procp_ev_imputados.idImputado','pdi.id as idImputadoDE',
                      DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                      DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                      )->groupby('procp_ev_imputados.idImputado')->get(); 

                    $imputadosDDL_M = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })                                            
                      ->where('idCausa',$idRegistro)
                      ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_ev_imputados pei left join procp_dg_imputados pcpdgi on pei.idImputado=pcpdgi.id where pei.idCausa='".$idRegistro."' AND bitMandamientos=1 AND pei.deleted_at IS NULL)")                    
                      ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                      DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),'pdi.FECHA_DETENCION',
                      DB::raw('CASE WHEN procp_dg_imputados.DETENCION_LEGAL_ILEGAL=1 THEN "LEGAL" ELSE "ILEGAL" END as DETENCION_LEGAL_ILEGAL')
                      )->groupby('procp_dg_imputados.idImputado')->get();  

                    $imputadosCP_M = causas_penales\cp_ev_imputados::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_ev_imputados.idImputado')
                      ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })                                            
                      ->where('procp_ev_imputados.idCausa',$idRegistro)->where('bitMandamientos','=',1)
                      ->select('procp_ev_imputados.*','procp_ev_imputados.id','procp_ev_imputados.idImputado','pdi.id as idImputadoDE',
                      DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                      DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                      )->groupby('procp_ev_imputados.idImputado')->get(); 

                    $imputadosDDL_A = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })                                            
                      ->where('idCausa',$idRegistro)
                      ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_ev_imputados pei left join procp_dg_imputados pcpdgi on pei.idImputado=pcpdgi.id where pei.idCausa='".$idRegistro."' AND bitAudiencia=1 AND pei.deleted_at IS NULL)")                    
                      ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                      DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),'pdi.FECHA_DETENCION',
                      DB::raw('CASE WHEN procp_dg_imputados.DETENCION_LEGAL_ILEGAL=1 THEN "LEGAL" ELSE "ILEGAL" END as DETENCION_LEGAL_ILEGAL')
                      )->groupby('procp_dg_imputados.idImputado')->get();  

                    $imputadosCP_A = causas_penales\cp_ev_imputados::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_ev_imputados.idImputado')
                      ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })                                            
                      ->where('procp_ev_imputados.idCausa',$idRegistro)->where('bitAudiencia','=',1)
                      ->select('procp_ev_imputados.*','procp_ev_imputados.id','procp_ev_imputados.idImputado','pdi.id as idImputadoDE',
                      DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                      DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                      )->groupby('procp_ev_imputados.idImputado')->get(); 

                    $imputadosDDL_C = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })                                            
                      ->where('idCausa',$idRegistro)
                      ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_ev_imputados pei left join procp_dg_imputados pcpdgi on pei.idImputado=pcpdgi.id where pei.idCausa='".$idRegistro."' AND bitCasoUrgente=1 AND pei.deleted_at IS NULL)")                    
                      ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                      DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),'pdi.FECHA_DETENCION',
                      DB::raw('CASE WHEN procp_dg_imputados.DETENCION_LEGAL_ILEGAL=1 THEN "LEGAL" ELSE "ILEGAL" END as DETENCION_LEGAL_ILEGAL')
                      )->groupby('procp_dg_imputados.idImputado')->get();  

                    $imputadosCP_C = causas_penales\cp_ev_imputados::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_ev_imputados.idImputado')
                      ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })                                            
                      ->where('procp_ev_imputados.idCausa',$idRegistro)->where('bitCasoUrgente','=',1)
                      ->select('procp_ev_imputados.*','procp_ev_imputados.id','procp_ev_imputados.idImputado','pdi.id as idImputadoDE',
                      DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                      DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                      )->groupby('procp_ev_imputados.idImputado')->get(); 

                      foreach ($imputadosCP_M as $key => $value) {
                       // $actosConL [$value->id]= causas_penales\cp_ev_actosconsin::leftjoin('catrespuestas as cr', function($join)
                       //  {
                       //      $join->on('procp_ev_actosconsin.TIPO_ACTOS_CONSIN','=','cr.id')
                       //      ->Where('cr.idTipoRespuesta','=',29);
                       //  })
                       //  ->where('id_cp_ev_imputados',$value->id)->where('CONSIN','=','con')
                       //  ->select('procp_ev_actosconsin.*','cr.Valor as ACTO')->get();
                       // $actosSinL [$value->id]= causas_penales\cp_ev_actosconsin::leftjoin('catrespuestas as cr', function($join)
                       //  {
                       //      $join->on('procp_ev_actosconsin.TIPO_ACTOS_CONSIN','=','cr.id')
                       //      ->Where('cr.idTipoRespuesta','=',30);
                       //  })
                       //  ->where('id_cp_ev_imputados',$value->id)->where('CONSIN','=','sin')
                       //  ->select('procp_ev_actosconsin.*','cr.Valor as ACTO')->get();
                       $mandamientos [$value->id]= causas_penales\cp_ev_mandamientos::leftjoin('catrespuestas as cr', function($join)
                        {
                            $join->on('procp_ev_mandamientos.TIPO_MANDAMIENTO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',81);
                        })
                        ->leftjoin('catrespuestas as cr2', function($join)
                        {
                            $join->on('procp_ev_mandamientos.ESTATUS_MANDAMIENTO','=','cr2.id')
                            ->Where('cr2.idTipoRespuesta','=',80);
                        })
                        ->where('id_cp_ev_imputados',$value->id)->select('procp_ev_mandamientos.*',
                        'cr.Valor as TIPO_MANDAMIENTO','cr2.Valor as ESTATUS_MANDAMIENTO')->get();
                       $mandamientos_DE [$value->id]= datos_expediente\de_ev_mandamientos::leftjoin('catrespuestas as cr', function($join)
                        {
                            $join->on('prode_ev_mandamientos.TIPO_MANDAMIENTO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',81);
                        })
                        ->leftjoin('catrespuestas as cr2', function($join)
                        {
                            $join->on('prode_ev_mandamientos.ESTATUS_MANDAMIENTO','=','cr2.id')
                            ->Where('cr2.idTipoRespuesta','=',80);
                        })
                        ->where('idImputado',$value->idImputadoDE)->select('prode_ev_mandamientos.*',
                        'cr.Valor as TIPO_MANDAMIENTO','cr2.Valor as ESTATUS_MANDAMIENTO')->get();
                      }


                    $victimasDDL = causas_penales\cp_dg_victimas::leftjoin('prode_victimas as pdv','procp_dg_victimas.idVictima','=','pdv.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdv.SEXO_VICTIMA','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })                                            
                      ->where('idCausa',$idRegistro)
                      ->whereRaw("procp_dg_victimas.idVictima NOT IN (select pcpdgv.idVictima from procp_ev_victimas pev left join procp_dg_victimas pcpdgv on pev.idVictima=pcpdgv.id where pev.idCausa='".$idRegistro."' AND pev.deleted_at IS NULL)")
                      ->select('procp_dg_victimas.id','procp_dg_victimas.idVictima',
                      DB::raw('CASE WHEN TIPO_VICTIMA=2 THEN RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN "LA SOCIEDAD" WHEN TIPO_VICTIMA=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_VICTIMA=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_VICTIMA," ", pdv.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_VICTIMAS) END as Valor'),
                      )->groupby('procp_dg_victimas.idVictima')->get();  
                    $victimasCP =causas_penales\cp_ev_victimas::leftjoin('procp_dg_victimas as pcpv','procp_ev_victimas.idVictima','=','pcpv.id')
                      ->leftjoin('prode_victimas as pdv','pcpv.idVictima','=','pdv.id')
                      ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('pdv.SEXO_VICTIMA','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',17);
                      })                                            
                      ->where('pcpv.idCausa',$idRegistro)                      
                      ->select('pcpv.id','procp_ev_victimas.id as idcp_ev_victimas','pcpv.idVictima',
                      DB::raw('CASE WHEN TIPO_VICTIMA=2 THEN RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN "LA SOCIEDAD" WHEN TIPO_VICTIMA=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_VICTIMA=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_VICTIMA," ", pdv.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_VICTIMAS) END as Valor'),  
                      DB::raw('CASE WHEN TIPO_VICTIMA=2 THEN CONCAT(RAZON_SOCIAL," / - / -") WHEN TIPO_VICTIMA=3 THEN CONCAT("LA SOCIEDAD / - / -") WHEN TIPO_VICTIMA=5 THEN CONCAT("SIN IDENTIFICAR/DESCONOCIDO / - / -") WHEN TIPO_VICTIMA=7 THEN CONCAT("LA SALUD / - / -") ELSE CONCAT(NOMBRE_VICTIMA," ", pdv.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_VICTIMAS," / ",IFNULL(cr.Valor,"-")," / ",pdv.EDAD_HECHOS_VICTIMAS) END as encabezado'),
                      )->groupby('pcpv.idVictima')->get(); 
                      foreach ($victimasCP as $key => $value) {  
                       $medidas [$value->id]= causas_penales\cp_ev_medidas::leftjoin('catrespuestas as cr', function($join)
                        {
                            $join->on('procp_ev_medidas.TIPO_DE_MEDIDA','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',28);
                        })
                        ->leftjoin('catrespuestas as cr2', function($join)
                        {
                            $join->on('procp_ev_medidas.MEDIDA_IMPUESTA_POR','=','cr2.id')
                            ->Where('cr2.idTipoRespuesta','=',79);
                        })
                        ->where('id_cp_ev_victimas',$value->idcp_ev_victimas)->select('procp_ev_medidas.*',
                          'cr.Valor as TIPOMEDIDA','cr2.Valor as IMPUESTAPOR')->get();

                       $medidas_DE [$value->id]= datos_expediente\de_ev_medidas::leftjoin('catrespuestas as cr', function($join)
                          {
                              $join->on('prode_ev_medidas.TIPO_DE_MEDIDA','=','cr.id')
                              ->Where('cr.idTipoRespuesta','=',28);
                          })
                          ->leftjoin('catrespuestas as cr2', function($join)
                          {
                              $join->on('prode_ev_medidas.MEDIDA_IMPUESTA_POR','=','cr2.id')
                              ->Where('cr2.idTipoRespuesta','=',79);
                          })
                          ->where('prode_ev_medidas.idVictima',$value->idVictima)->select('prode_ev_medidas.*',
                            'cr.Valor as TIPOMEDIDA','cr2.Valor as IMPUESTAPOR')->get();                        

                      }
                    $CP_EV = causas_penales\cp_etapainvestigacion::where('idCausa',$idRegistro)->count();
                    $actosEV=causas_penales\cp_ev_actos::where('idCausa',$idRegistro)
                    ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('procp_ev_actos.TIPO_ACTOS_DE_INV','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',78);
                      })
                    ->leftJoin('catrespuestas as cr1', function($join)
                      {
                          $join->on('procp_ev_actos.TIPO_CONTROL_ACTOS_DE_INV','=','cr1.id')
                          ->Where('cr1.idTipoRespuesta','=',89);
                      })->select('procp_ev_actos.*',DB::raw('IFNULL(cr1.Valor,"-") AS Control'),DB::raw('IFNULL(cr.Valor,"-") AS Valor'))->get();
                      $audienciaInicial = causas_penales\cp_audienciainicial::where('idCausa',$idRegistro)
                        ->select(DB::raw("CASE WHEN IFNULL(procp_audienciainicial.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                          DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'),
                          'procp_audienciainicial.*')
                        ->whereRaw("IFNULL(procp_audienciainicial.FECHA_CIERRE,'')='' AND IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0)")
                        ->first();                  }
                  $actosEV_DE=datos_expediente\de_ev_actos::where('idExpediente',$idExp)
                    ->leftJoin('catrespuestas as cr', function($join)
                      {
                          $join->on('prode_ev_actos.TIPO_ACTOS_DE_INV','=','cr.id')
                          ->Where('cr.idTipoRespuesta','=',78);
                      })
                    ->leftJoin('catrespuestas as cr1', function($join)
                      {
                          $join->on('prode_ev_actos.TIPO_CONTROL_ACTOS_DE_INV','=','cr1.id')
                          ->Where('cr1.idTipoRespuesta','=',89);
                      })->select('prode_ev_actos.*',DB::raw('IFNULL(cr1.Valor,"-") AS Control'),DB::raw('IFNULL(cr.Valor,"-") AS Valor'))->get();
                 }
                #endregion
                
                $listados=['imputadosDDL_F'=>$imputadosDDL_F,
                'imputadosDDL_M'=>$imputadosDDL_M,
                'imputadosDDL_A'=>$imputadosDDL_A,
                'imputadosDDL_C'=>$imputadosDDL_C,
                'victimasDDL'=>$victimasDDL,
                'imputadosCP_F'=>$imputadosCP_F,
                'imputadosCP_M'=>$imputadosCP_M,
                'imputadosCP_A'=>$imputadosCP_A,
                'imputadosCP_C'=>$imputadosCP_C,
                'victimasCP'=>$victimasCP];
                #region menus
                  $menuActivo=['1m' => '','1d' => '','2m' => '','2d' => '','3m' => '','3d' => '','4m' => '','4d' => '','5m' => '','5d' => '','6m' => '','6d' => '',
                  '7m' => '','7d' => '','8m' => '','8d' => '','9m' => '','9d' => '','10m' => '','10d' => '',];
                  $menuActivo['2m']='active';
                  $menuActivo['2d']='show active';

                $data=['SiNoNoA'=>$SiNoNoA,'SiNoNoI'=>$SiNoNoI, 'TMRestriccion'=>$TMRestriccion,'audineciaPx'=>$audineciaPx,
                      'TipoActo'=>$TipoActo,'TipoControl'=>$TipoControl,'impuestaPor'=>$impuestaPor,'estatusMJ'=>$estatusMJ,'formaProc'=>$formaProc,'EstatusCU'=>$EstatusCU,
                      'TipoMJ'=>$TipoMJ,'actosCon'=>$actosCon,'actosSin'=>$actosSin,
                      'CP_EV'=>$CP_EV,'actosEV'=>$actosEV,'medidas'=>$medidas,'actosConL'=>$actosConL,'actosSinL'=>$actosSinL,
                      'mandamientos'=>$mandamientos,
                      'actosEV_DE'=>$actosEV_DE,'mandamientos_DE'=>$mandamientos_DE,'medidas_DE'=>$medidas_DE,
                      'listados'=>$listados,'audienciaInicial'=>$audienciaInicial, 'menuActivo' => $menuActivo,'Ctrl'=>$Ctrl,
                      'resumen'=>$resumen,
                      'idExp' => bin2hex($idExp), 'idRegistro' => bin2hex($idRegistro),];
                  $mostrarCP=datos_expediente\de_datosgenerales::where('idExpediente',$idExp)->where('SENTIDO_DETERMINACION','=',10)->count();
                    return view('causas_penales.dashboard',compact('mostrarCP'))->with($data);
                break;

             case 'd0ai'://////CAUSAS PENALES AUDIENCIA INICIAL
                #region Catalogos iniciales
                  $SiNo= $this->GetDataById('catrespuestas','idTipoRespuesta',2);
                  $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
                  $motivoNoAud= $this->GetDataById('catrespuestas','idTipoRespuesta',55);
                  $conduccionImp= $this->GetDataById('catrespuestas','idTipoRespuesta',32);
                  $resolAuto= $this->GetDataById('catrespuestas','idTipoRespuesta',56);
                    // $TMCautelares= $this->GetDataById('catrespuestas','idTipoRespuesta',34);
                    // $acuerdo= $this->GetDataById('catrespuestas','idTipoRespuesta',35);
                    // $tipoAcuerdo= $this->GetDataById('catrespuestas','idTipoRespuesta',59);
                    // $tipoConImp= $this->GetDataById('catrespuestas','idTipoRespuesta',42);
                    // $causasSus= $this->GetDataById('catrespuestas','idTipoRespuesta',33);
                    // $causasSobre= $this->GetDataById('catrespuestas','idTipoRespuesta',36);
                    // $tipoSobre= $this->GetDataById('catrespuestas','idTipoRespuesta',37);
                  $TipoProrroga= $this->GetDataById('catrespuestas','idTipoRespuesta',82);
                #endregion                
                $resumen=[]; $audienciaInicial=[];$medidas=[];$delitosCP=[];
                $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];
                $prorrogasAI=[];$CelebracionesAI=[];$CP_AI=0;
                
                $imputadosCP_C=[]; $imputadosDDL_C=[];
                $imputadosCP_O=[]; $imputadosDDL_O=[];
                $imputadosCP_F=[]; $imputadosDDL_F=[];
                $imputadosCP_V=[]; $imputadosDDL_V=[];
                $imputadosCP_P=[]; $imputadosDDL_P=[];
                #region Obtener Datos
                  if ($idExp > 0)
                  {
                    $datos = datos_expediente\de_datosgenerales::where('id',$idExp)->first();
                    $datos->FECHA_INICIO_CARPETA = empty(trim($datos->FECHA_INICIO_CARPETA))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO_CARPETA)));
                    $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                    $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                    $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                    $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();                    
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                    'NUC' => $datos->NUC_COMPLETA??'-','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO_CARPETA))?'-':$datos->FECHA_INICIO_CARPETA??'-','validacion'=>$validacion,'correccion'=>$correccion,
                    'idExpCorr'=>$idExp,'tablaCorr'=>'prode_datosgenerales'];
                    if ($idRegistro > 0) {
                      DB::statement("SET SQL_MODE=''");
                      $imputadosDDL_C = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi2.idImputado from procp_audienciainicial pai left join procp_dg_imputados pcpdgi2 on pai.idImputado=pcpdgi2.id where pai.idCausa='".$idRegistro."' AND bitCelebracion=1 AND pai.idImputado IS NOT NULL AND pai.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor') 
                        ,'procp_dg_imputados.FORMA_','procp_dg_imputados.DETENCION_LEGAL_ILEGAL')
                        ->groupby('procp_dg_imputados.idImputado')->get();                        
                      $imputadosDDL_O = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_ai_imputados paii left join procp_dg_imputados pcpdgi on paii.idImputado=pcpdgi.id where paii.idCausa='".$idRegistro."' AND bitControl=1 AND paii.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor') 
                        ,'procp_dg_imputados.FORMA_','procp_dg_imputados.DETENCION_LEGAL_ILEGAL')
                        ->groupby('procp_dg_imputados.idImputado')->get();
                      $imputadosDDL_F = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_ai_imputados paii left join procp_dg_imputados pcpdgi on paii.idImputado=pcpdgi.id where paii.idCausa='".$idRegistro."' AND bitFormulacion=1 AND paii.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor') 
                        ,'procp_dg_imputados.FORMA_','procp_dg_imputados.DETENCION_LEGAL_ILEGAL')
                        ->groupby('procp_dg_imputados.idImputado')->get();  
                      $imputadosDDL_V = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_ai_imputados paii left join procp_dg_imputados pcpdgi on paii.idImputado=pcpdgi.id where paii.idCausa='".$idRegistro."' AND bitVinculacion=1 AND paii.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor') 
                        ,'procp_dg_imputados.FORMA_','procp_dg_imputados.DETENCION_LEGAL_ILEGAL')
                        ->groupby('procp_dg_imputados.idImputado')->get();                          
                      $imputadosDDL_P = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi2.idImputado from procp_audienciainicial pai left join procp_dg_imputados pcpdgi2 on pai.idImputado=pcpdgi2.id where pai.idCausa='".$idRegistro."' AND bitPlazo=1 AND pai.idImputado IS NOT NULL AND pai.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor') 
                        ,'procp_dg_imputados.FORMA_','procp_dg_imputados.DETENCION_LEGAL_ILEGAL')
                        ->groupby('procp_dg_imputados.idImputado')->get();  

                      $imputadosCP_C = causas_penales\cp_audienciainicial::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_audienciainicial.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_audienciainicial.idCausa',$idRegistro)->where('bitCelebracion','=',1)->whereNotNull('procp_audienciainicial.idImputado')
                        ->select('procp_audienciainicial.*','procp_audienciainicial.id','procp_audienciainicial.idImputado',
                        DB::raw("CASE WHEN IFNULL(procp_audienciainicial.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                        DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'),
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'))
                        ->groupby('procp_audienciainicial.idImputado')->get();
                      $imputadosCP_O = causas_penales\cp_ai_imputados::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_ai_imputados.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_ai_imputados.idCausa',$idRegistro)->where('bitControl','=',1)
                        ->select('procp_ai_imputados.*','procp_ai_imputados.id','procp_ai_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'))
                        ->groupby('procp_ai_imputados.idImputado')->get();
                      $imputadosCP_F = causas_penales\cp_ai_imputados::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_ai_imputados.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_ai_imputados.idCausa',$idRegistro)->where('bitFormulacion','=',1)
                        ->select('procp_ai_imputados.*','procp_ai_imputados.id','procp_ai_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'))
                        ->groupby('procp_ai_imputados.idImputado')->get();
                      $imputadosCP_V = causas_penales\cp_ai_imputados::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_ai_imputados.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_ai_imputados.idCausa',$idRegistro)->where('bitVinculacion','=',1)
                        ->select('procp_ai_imputados.*','procp_ai_imputados.id','procp_ai_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'))
                        ->groupby('procp_ai_imputados.idImputado')->get();
                      $imputadosCP_P = causas_penales\cp_audienciainicial::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_audienciainicial.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_audienciainicial.idCausa',$idRegistro)->where('bitPlazo','=',1)->whereNotNull('procp_audienciainicial.idImputado')
                        ->select('procp_audienciainicial.*','procp_audienciainicial.id','procp_audienciainicial.idImputado',
                        DB::raw("CASE WHEN IFNULL(procp_audienciainicial.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                        DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'),
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'))
                        ->groupby('procp_audienciainicial.idImputado')->get();

                      $audienciaInicial = causas_penales\cp_audienciainicial::where('idCausa',$idRegistro)
                        ->select(DB::raw("CASE WHEN IFNULL(procp_audienciainicial.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                          DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'),
                          'procp_audienciainicial.*')
                        ->whereRaw("IFNULL(procp_audienciainicial.FECHA_CIERRE,'')='' AND IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0)")
                        ->first();
                      // foreach ($imputadosCP as $key => $value) {
                      //  $medidas [$value->id]= causas_penales\cp_ai_medidas::leftjoin('catrespuestas as cr', function($join)
                      //   {
                      //       $join->on('procp_ai_medidas.MEDIDAS_CAUTELARES','=','cr.id')
                      //       ->Where('cr.idTipoRespuesta','=',4);
                      //   })
                      //   ->leftjoin('catrespuestas as cr2', function($join)
                      //   {
                      //       $join->on('procp_ai_medidas.TIPO_MEDIDAS_CAUTELARES','=','cr2.id')
                      //       ->Where('cr2.idTipoRespuesta','=',34);
                      //   })
                      //   ->where('id_cp_ai_imputados',$value->id)->select('procp_ai_medidas.*',
                      //     'cr.Valor as MEDIDAS','cr2.Valor as TIPOMEDIDA')
                      //   ->get();
                      // }
                      foreach ($imputadosCP_C as $key => $value) {
                        $CelebracionesAI[$value->id]=causas_penales\cp_ai_celebracion::where('idCausa',$idRegistro)
                          ->where('idImputado',$value->idImputado)
                          ->leftJoin('catrespuestas as cr', function($join)
                            {
                                $join->on('bitcp_ai_celebracion.AUDIENCIA_INICIAL','=','cr.id')
                                ->Where('cr.idTipoRespuesta','=',4);
                            })
                          ->leftJoin('catrespuestas as cr1', function($join)
                            {
                                $join->on('bitcp_ai_celebracion.MOTIVO_NOAUD','=','cr1.id')
                                ->Where('cr1.idTipoRespuesta','=',55);
                            })
                            ->select('bitcp_ai_celebracion.*',DB::raw('IFNULL(cr.Valor,"-") AS Valor'),DB::raw('IFNULL(cr1.Valor,"-") AS Valor1'))
                            ->orderByDesc('bitcp_ai_celebracion.id')->take(5)->get();
                      }
                      foreach ($imputadosCP_P as $key => $value) {
                        $CelebracionesAI[$value->id]=causas_penales\cp_ai_celebracion::where('idCausa',$idRegistro)
                          ->where('idImputado',$value->idImputado)
                          ->leftJoin('catrespuestas as cr', function($join)
                            {
                                $join->on('bitcp_ai_celebracion.AUDIENCIA_INICIAL','=','cr.id')
                                ->Where('cr.idTipoRespuesta','=',4);
                            })
                          ->leftJoin('catrespuestas as cr1', function($join)
                            {
                                $join->on('bitcp_ai_celebracion.MOTIVO_NOAUD','=','cr1.id')
                                ->Where('cr1.idTipoRespuesta','=',55);
                            })
                            ->select('bitcp_ai_celebracion.*',DB::raw('IFNULL(cr.Valor,"-") AS Valor'),DB::raw('IFNULL(cr1.Valor,"-") AS Valor1'))
                            ->orderByDesc('bitcp_ai_celebracion.id')->take(5)->get();

                        $prorrogasAI[$value->id]=causas_penales\cp_ai_prorrogas::where('idCausa',$idRegistro)
                        ->where('idImputado',$value->idImputado)
                        ->leftJoin('catrespuestas as cr', function($join)
                          {
                              $join->on('procp_ai_prorrogas.PRORROGA','=','cr.id')
                              ->Where('cr.idTipoRespuesta','=',82);
                          })->select('procp_ai_prorrogas.*',DB::raw('IFNULL(cr.Valor,"-") AS Valor'))->get();                            
                      }                      

                      $delitosCP =  causas_penales\cp_dg_delitos::leftjoin('prode_hechos as pdh','procp_dg_delitos.idDelito','=','pdh.id')
                        ->leftjoin('catdelitosespecificos as cde','cde.id','=','pdh.DELITO')
                        ->leftjoin('catdelitosjur as cdj','pdh.DELITO_JUR','=','cdj.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('procp_dg_delitos.RECLASIFICACION','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',2);
                        })
                        ->leftJoin('catrespuestas as cr2', function($join)
                        {
                            $join->on('procp_dg_delitos.MOMENTO_RECLAS','=','cr2.id')
                            ->Where('cr2.idTipoRespuesta','=',69);
                        })->where('idCausa',$idRegistro)
                        ->select('procp_dg_delitos.id','procp_dg_delitos.idDelito',
                          // DB::raw('CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cde.Valor," [",cdj.cClaveDelito,"-",cdj.Valor,"]") END as Valor'),
                          DB::raw('CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cdj.cClaveDelito,"-",cdj.Valor) END as Valor'),
                          DB::raw('IFNULL(cr.Valor,"-") as RECLASIFICACION'),
                          DB::raw('IFNULL(cr2.Valor,"-") as MOMENTO'),'procp_dg_delitos.FECHA_RECLAS','procp_dg_delitos.DELITO_DE_ACUERDO_CON_LEY')
                        ->get();   
                      $CP_AI = causas_penales\cp_audienciainicial::where('idCausa',$idRegistro)->count();
                    }
                  }
                #endregion
                $listados=['imputadosCP_C'=>$imputadosCP_C,'imputadosDDL_C'=>$imputadosDDL_C,
                           'imputadosCP_O'=>$imputadosCP_O,'imputadosDDL_O'=>$imputadosDDL_O,
                           'imputadosCP_F'=>$imputadosCP_F,'imputadosDDL_F'=>$imputadosDDL_F,
                           'imputadosCP_V'=>$imputadosCP_V,'imputadosDDL_V'=>$imputadosDDL_V,
                           'imputadosCP_P'=>$imputadosCP_P,'imputadosDDL_P'=>$imputadosDDL_P,];
                #region menus
                  $menuActivo=['1m' => '','1d' => '','2m' => '','2d' => '','3m' => '','3d' => '','4m' => '','4d' => '','5m' => '','5d' => '','6m' => '','6d' => '',
                  '7m' => '','7d' => '','8m' => '','8d' => '','9m' => '','9d' => '','10m' => '','10d' => '',];
                  $menuActivo['3m']='active';
                  $menuActivo['3d']='show active';
                #endregion                
                $data=['SiNoNoI'=>$SiNoNoI,'SiNo'=>$SiNo,'motivoNoAud'=>$motivoNoAud, 'conduccionImp' =>$conduccionImp,
                        'resolAuto'=>$resolAuto,
                        //'TMCautelares'=>$TMCautelares,'acuerdo'=>$acuerdo,'tipoAcuerdo'=>$tipoAcuerdo,'tipoConImp'=>$tipoConImp,
                        //'causasSus'=>$causasSus, 'causasSobre'=>$causasSobre,'tipoSobre'=>$tipoSobre,
                        'TipoProrroga'=>$TipoProrroga,
                        'listados'=>$listados,'audienciaInicial'=>$audienciaInicial,//'medidas'=>$medidas,
                        'prorrogasAI'=>$prorrogasAI,'CelebracionesAI'=>$CelebracionesAI,'delitosCP'=>$delitosCP,'CP_AI'=>$CP_AI,
                        'menuActivo' => $menuActivo,'Ctrl'=>$Ctrl,'resumen'=>$resumen,
                        'idExp' => bin2hex($idExp), 'idRegistro' => bin2hex($idRegistro),];
                  $mostrarCP=datos_expediente\de_datosgenerales::where('idExpediente',$idExp)->where('SENTIDO_DETERMINACION','=',10)->count();
                    return view('causas_penales.dashboard',compact('mostrarCP'))->with($data);
                break;

             case 'd0pa'://////CAUSAS PENALES PROCEDIMIENTO ABREVIADO
                $SiNo= $this->GetDataById('catrespuestas','idTipoRespuesta',2);
                $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
                $EstatusAb= $this->GetDataById('catrespuestas','idTipoRespuesta',88);

                $resumen=[]; $imputadosCP=[]; $imputadosDDL=[];$audienciaInicial=[];
                $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];
                #region Obtener Datos
                  if ($idExp > 0)
                  {
                    $datos = datos_expediente\de_datosgenerales::where('id',$idExp)->first();
                    $datos->FECHA_INICIO_CARPETA = empty(trim($datos->FECHA_INICIO_CARPETA))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO_CARPETA)));
                    $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                    $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                    $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                    $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();                    
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                    'NUC' => $datos->NUC_COMPLETA??'-','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO_CARPETA))?'-':$datos->FECHA_INICIO_CARPETA??'-','validacion'=>$validacion,'correccion'=>$correccion,
                    'idExpCorr'=>$idExp,'tablaCorr'=>'prode_datosgenerales'];
                    if ($idRegistro > 0) {
                      DB::statement("SET SQL_MODE=''");
                      $imputadosDDL = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_procedimientoabreviado pcppa left join procp_dg_imputados pcpdgi on pcppa.idImputado=pcpdgi.id where pcppa.idCausa='".$idRegistro."' AND pcppa.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        )->groupby('procp_dg_imputados.idImputado')->get();  

                      $imputadosCP = causas_penales\cp_procedimientoabreviado::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_procedimientoabreviado.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_procedimientoabreviado.idCausa',$idRegistro)
                        ->select('procp_procedimientoabreviado.*','procp_procedimientoabreviado.id','procp_procedimientoabreviado.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                        )->groupby('procp_procedimientoabreviado.idImputado')->get();                        
                      
                      $audienciaInicial = causas_penales\cp_audienciainicial::where('idCausa',$idRegistro)
                        ->select(DB::raw("CASE WHEN IFNULL(procp_audienciainicial.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                          DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'),
                          'procp_audienciainicial.*')
                        ->whereRaw("IFNULL(procp_audienciainicial.FECHA_CIERRE,'')='' AND IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0)")
                        ->first();
                    }
                  }
                #endregion
                $listados=['imputadosDDL'=>$imputadosDDL,'imputadosCP'=>$imputadosCP];
                #region menus
                  $menuActivo=['1m' => '','1d' => '','2m' => '','2d' => '','3m' => '','3d' => '','4m' => '','4d' => '','5m' => '','5d' => '','6m' => '','6d' => '',
                  '7m' => '','7d' => '','8m' => '','8d' => '','9m' => '','9d' => '','10m' => '','10d' => '',];
                  $menuActivo['4m']='active';
                  $menuActivo['4d']='show active';
                #endregion                
                $data=['SiNo'=>$SiNo,'SiNoNoI'=>$SiNoNoI,'EstatusAb'=>$EstatusAb,'listados'=>$listados, 'audienciaInicial'=>$audienciaInicial, 
                  'menuActivo' => $menuActivo,'Ctrl'=>$Ctrl,'resumen'=>$resumen,
                  'idExp' => bin2hex($idExp), 'idRegistro' => bin2hex($idRegistro),];
                  $mostrarCP=datos_expediente\de_datosgenerales::where('idExpediente',$idExp)->where('SENTIDO_DETERMINACION','=',10)->count();
                    return view('causas_penales.dashboard',compact('mostrarCP'))->with($data);
                break;

             case 'd0ei'://////CAUSAS PENALES ETAPA INTERMEDIA
                #region Catalogos iniciales
                  $SiNo= $this->GetDataById('catrespuestas','idTipoRespuesta',2);
                  $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
                  $motivoNoAud= $this->GetDataById('catrespuestas','idTipoRespuesta',55);
                  $conduccionImp= $this->GetDataById('catrespuestas','idTipoRespuesta',32);
                  $resolAuto= $this->GetDataById('catrespuestas','idTipoRespuesta',56);
                  $TMCautelares= $this->GetDataById('catrespuestas','idTipoRespuesta',34);
                  $acuerdo= $this->GetDataById('catrespuestas','idTipoRespuesta',35);
                  $tipoAcuerdo= $this->GetDataById('catrespuestas','idTipoRespuesta',59);
                  $tipoConImp= $this->GetDataById('catrespuestas','idTipoRespuesta',42);
                  $causasSus= $this->GetDataById('catrespuestas','idTipoRespuesta',33);
                  $causasSobre= $this->GetDataById('catrespuestas','idTipoRespuesta',36);
                  $tipoSobre= $this->GetDataById('catrespuestas','idTipoRespuesta',37);
                  $mediosPruebas= $this->GetDataById('catrespuestas','idTipoRespuesta',54);
                  $presex= $this->GetDataById('catrespuestas','idTipoRespuesta',83);
                #endregion                
                $resumen=[];$etapaintermedia=[];$audienciaInicial=[];$mediosEI=[];$CelebracionesEI=[];
                $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];

                $imputadosCP_A=[]; $imputadosDDL_A=[];
                $imputadosCP_I=[]; $imputadosDDL_I=[];
                $imputadosCP_P=[]; $imputadosDDL_P=[];
                $imputadosCP_D=[]; $imputadosDDL_D=[];
                #region Obtener Datos
                  if ($idExp > 0)
                  {
                    $datos = datos_expediente\de_datosgenerales::where('id',$idExp)->first();
                    $datos->FECHA_INICIO_CARPETA = empty(trim($datos->FECHA_INICIO_CARPETA))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO_CARPETA)));
                    $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                    $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                    $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                    $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                    'NUC' => $datos->NUC_COMPLETA??'-','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO_CARPETA))?'-':$datos->FECHA_INICIO_CARPETA??'-',
                    'validacion'=>$validacion,'correccion'=>$correccion,'idExpCorr'=>$idExp,'tablaCorr'=>'prode_datosgenerales'];
                    if ($idRegistro > 0) {

                      DB::statement("SET SQL_MODE=''");
                      $imputadosDDL_A = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_etapaintermedia paii left join procp_dg_imputados pcpdgi on paii.idImputado=pcpdgi.id where paii.idCausa='".$idRegistro."' AND bitAcusacion=1 AND paii.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),
                        )->groupby('procp_dg_imputados.idImputado')->get();
                      $imputadosCP_A = causas_penales\cp_etapaintermedia::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_etapaintermedia.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })
                        ->where('procp_etapaintermedia.idCausa',$idRegistro)->where('bitAcusacion','=',1)
                        ->select('procp_etapaintermedia.*','procp_etapaintermedia.id','procp_etapaintermedia.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                        )->groupby('procp_etapaintermedia.idImputado')->get();


                      $imputadosDDL_I = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_etapaintermedia paii left join procp_dg_imputados pcpdgi on paii.idImputado=pcpdgi.id where paii.idCausa='".$idRegistro."' AND bitAudienciaIntermedia=1 AND paii.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),
                        )->groupby('procp_dg_imputados.idImputado')->get();
                      $imputadosCP_I = causas_penales\cp_etapaintermedia::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_etapaintermedia.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })
                        ->where('procp_etapaintermedia.idCausa',$idRegistro)->where('bitAudienciaIntermedia','=',1)
                        ->select('procp_etapaintermedia.*','procp_etapaintermedia.id','procp_etapaintermedia.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                        )->groupby('procp_etapaintermedia.idImputado')->get();


                      $imputadosDDL_P = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_etapaintermedia paii left join procp_dg_imputados pcpdgi on paii.idImputado=pcpdgi.id where paii.idCausa='".$idRegistro."' AND bitAcuerdosProbatorios=1 AND paii.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),
                        )->groupby('procp_dg_imputados.idImputado')->get();
                      $imputadosCP_P = causas_penales\cp_etapaintermedia::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_etapaintermedia.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })
                        ->where('procp_etapaintermedia.idCausa',$idRegistro)->where('bitAcuerdosProbatorios','=',1)
                        ->select('procp_etapaintermedia.*','procp_etapaintermedia.id','procp_etapaintermedia.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                        )->groupby('procp_etapaintermedia.idImputado')->get();


                      $imputadosDDL_D = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_etapaintermedia paii left join procp_dg_imputados pcpdgi on paii.idImputado=pcpdgi.id where paii.idCausa='".$idRegistro."' AND bitDatosJuicioOral=1 AND paii.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),
                        )->groupby('procp_dg_imputados.idImputado')->get();
                      $imputadosCP_D = causas_penales\cp_etapaintermedia::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_etapaintermedia.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })
                        ->where('procp_etapaintermedia.idCausa',$idRegistro)->where('bitDatosJuicioOral','=',1)
                        ->select('procp_etapaintermedia.*','procp_etapaintermedia.id','procp_etapaintermedia.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                        )->groupby('procp_etapaintermedia.idImputado')->get();                        


                      $etapaintermedia = causas_penales\cp_etapaintermedia::where('idCausa',$idRegistro)->first();
                      $mediosEI=causas_penales\cp_ei_medios::where('idCausa',$idRegistro)
                      ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('procp_ei_medios.MEDIOS_PRUEBAS','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',54);
                        })
                      ->leftJoin('catrespuestas as cr2', function($join)
                        {
                            $join->on('procp_ei_medios.MEDIOS_PRUEBAS_PE','=','cr2.id')
                            ->Where('cr2.idTipoRespuesta','=',83);
                        })
                      ->leftJoin('catrespuestas as cr3', function($join)
                        {
                            $join->on('procp_ei_medios.ACUERDOS_REPARATORIOS','=','cr3.id')
                            ->Where('cr3.idTipoRespuesta','=',2);
                        })
                      ->select('procp_ei_medios.*',DB::raw('IFNULL(cr.Valor,"-") AS Valor'),
                        DB::raw('IFNULL(cr2.Valor,"-") AS Valor2'),DB::raw('IFNULL(cr3.Valor,"-") AS Valor3'))->get();

                      $audienciaInicial = causas_penales\cp_audienciainicial::where('idCausa',$idRegistro)
                        ->select(DB::raw("CASE WHEN IFNULL(procp_audienciainicial.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                          DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'),
                          'procp_audienciainicial.*')
                        ->whereRaw("IFNULL(procp_audienciainicial.FECHA_CIERRE,'')='' AND IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0)")
                        ->first();
                        foreach ($imputadosCP_I as $key => $value) {
                          $CelebracionesEI[$value->id]=causas_penales\cp_ei_suspension::where('idCausa',$idRegistro)->where('idImputado',$value->idImputado)
                            ->select('bitcp_ei_suspension.*')
                            ->orderByDesc('bitcp_ei_suspension.id')->take(5)->get();
                        }

                    }
                  }
                #endregion
                $listados=['imputadosDDL_A'=>$imputadosDDL_A,'imputadosCP_A'=>$imputadosCP_A
                          ,'imputadosDDL_I'=>$imputadosDDL_I,'imputadosCP_I'=>$imputadosCP_I
                          ,'imputadosDDL_P'=>$imputadosDDL_P,'imputadosCP_P'=>$imputadosCP_P
                          ,'imputadosDDL_D'=>$imputadosDDL_D,'imputadosCP_D'=>$imputadosCP_D];
                #region menus
                  $menuActivo=['1m' => '','1d' => '','2m' => '','2d' => '','3m' => '','3d' => '','4m' => '','4d' => '','5m' => '','5d' => '','6m' => '','6d' => '',
                  '7m' => '','7d' => '','8m' => '','8d' => '','9m' => '','9d' => '','10m' => '','10d' => '',];
                  $menuActivo['5m']='active';
                  $menuActivo['5d']='show active';
                #endregion                
                $data=['SiNoNoI'=>$SiNoNoI,'SiNo'=>$SiNo,'motivoNoAud'=>$motivoNoAud,'conduccionImp' =>$conduccionImp,'resolAuto'=>$resolAuto,
                        'TMCautelares'=>$TMCautelares,'acuerdo'=>$acuerdo,'tipoAcuerdo'=>$tipoAcuerdo,'tipoConImp'=>$tipoConImp,'causasSus'=>$causasSus,
                        'causasSobre'=>$causasSobre,'tipoSobre'=>$tipoSobre,'mediosPruebas'=>$mediosPruebas,'presex'=>$presex,
                        'mediosEI'=>$mediosEI,'CelebracionesEI'=>$CelebracionesEI,
                        'listados'=>$listados,'etapaintermedia'=>$etapaintermedia, 'audienciaInicial'=>$audienciaInicial,
                        'menuActivo' => $menuActivo,'Ctrl'=>$Ctrl,
                        'resumen'=>$resumen,
                        'idExp' => bin2hex($idExp), 'idRegistro' => bin2hex($idRegistro),];
                  $mostrarCP=datos_expediente\de_datosgenerales::where('idExpediente',$idExp)->where('SENTIDO_DETERMINACION','=',10)->count();
                    return view('causas_penales.dashboard',compact('mostrarCP'))->with($data);
                break;

             case 'd0jo'://////CAUSAS PENALES JUICIO ORAL
                $SiNo= $this->GetDataById('catrespuestas','idTipoRespuesta',2);
                $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
                $tipoSentencia= $this->GetDataById('catrespuestas','idTipoRespuesta',38);
                $tipoPruebas= $this->GetDataById('catrespuestas','idTipoRespuesta',68);
                //$tipoRecurso= $this->GetDataById('catrespuestas','idTipoRespuesta',39);
                $actorPruebas= $this->GetDataById('catrespuestas','idTipoRespuesta',84);
                $resumen=[]; 
                $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];
                 $imputadosCP=[]; $imputadosCP_P=[]; $imputadosCP_S=[];
                 $imputadosDDL=[]; $imputadosDDL_P=[]; $imputadosDDL_S=[]; 
                 $pruebas=[];$suspension=[];//$recursos=[];
                $audienciaInicial=[];
                #region Obtener Datos
                  if ($idExp > 0)
                  {
                    $datos = datos_expediente\de_datosgenerales::where('id',$idExp)->first();
                    $datos->FECHA_INICIO_CARPETA = empty(trim($datos->FECHA_INICIO_CARPETA))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO_CARPETA)));
                    $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                    $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                    $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                    $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                    'NUC' => $datos->NUC_COMPLETA??'-','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO_CARPETA))?'-':$datos->FECHA_INICIO_CARPETA??'-',
                    'validacion'=>$validacion,'correccion'=>$correccion,'idExpCorr'=>$idExp,'tablaCorr'=>'prode_datosgenerales'];
                    if ($idRegistro > 0) {
                      DB::statement("SET SQL_MODE=''");
                      $imputadosDDL = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })
                        ->leftJoin('procp_medidascautelares as pcpmc', function($join)
                        {
                            $join->on('pcpmc.idImputado','=','procp_dg_imputados.id')
                            ->whereNull('pcpmc.deleted_at');
                        })
                        ->leftJoin('procp_mc_medidas as pcpmcm', function($join)
                        {
                            $join->on('pcpmcm.id_cp_medidascautelares','=','pcpmc.id')
                            ->whereNull('pcpmcm.deleted_at')
                            ->whereIn('pcpmcm.TIPO_MEDIDAS_CAUTELARES',[14,15,16]);
                        })
                        ->where('procp_dg_imputados.idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_jo_imputados pcpjo left join procp_dg_imputados pcpdgi on pcpjo.idImputado=pcpdgi.id where pcpjo.idCausa='".$idRegistro."' AND pcpjo.deleted_at IS NULL)")
                        ->select(DB::raw("FLOOR(IFNULL((SUM(TEMPORALIDAD_MEDIDA_D)/365.25)+(SUM(TEMPORALIDAD_MEDIDA_M)/12)+SUM(TEMPORALIDAD_MEDIDA_A),0)) as tiempo"),
                          'procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        )->groupby('procp_dg_imputados.idImputado')->get();
                      $imputadosDDL_P = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })
                        ->leftJoin('procp_medidascautelares as pcpmc', function($join)
                        {
                            $join->on('pcpmc.idImputado','=','procp_dg_imputados.id')
                            ->whereNull('pcpmc.deleted_at');
                        })
                        ->leftJoin('procp_mc_medidas as pcpmcm', function($join)
                        {
                            $join->on('pcpmcm.id_cp_medidascautelares','=','pcpmc.id')
                            ->whereNull('pcpmcm.deleted_at')
                            ->whereIn('pcpmcm.TIPO_MEDIDAS_CAUTELARES',[14,15,16]);
                        })
                        ->where('procp_dg_imputados.idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_jo_pruebas pcpjop left join procp_dg_imputados pcpdgi on pcpjop.idImputado=pcpdgi.id where pcpjop.idCausa='".$idRegistro."' AND pcpjop.deleted_at IS NULL)")
                        ->select(DB::raw("FLOOR(IFNULL((SUM(TEMPORALIDAD_MEDIDA_D)/365.25)+(SUM(TEMPORALIDAD_MEDIDA_M)/12)+SUM(TEMPORALIDAD_MEDIDA_A),0)) as tiempo"),
                          'procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        )->groupby('procp_dg_imputados.idImputado')->get();
                      $imputadosDDL_S = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })
                        ->leftJoin('procp_medidascautelares as pcpmc', function($join)
                        {
                            $join->on('pcpmc.idImputado','=','procp_dg_imputados.id')
                            ->whereNull('pcpmc.deleted_at');
                        })
                        ->leftJoin('procp_mc_medidas as pcpmcm', function($join)
                        {
                            $join->on('pcpmcm.id_cp_medidascautelares','=','pcpmc.id')
                            ->whereNull('pcpmcm.deleted_at')
                            ->whereIn('pcpmcm.TIPO_MEDIDAS_CAUTELARES',[14,15,16]);
                        })
                        ->where('procp_dg_imputados.idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_jo_suspension pcpjos left join procp_dg_imputados pcpdgi on pcpjos.idImputado=pcpdgi.id where pcpjos.idCausa='".$idRegistro."' AND pcpjos.deleted_at IS NULL)")
                        ->select(DB::raw("FLOOR(IFNULL((SUM(TEMPORALIDAD_MEDIDA_D)/365.25)+(SUM(TEMPORALIDAD_MEDIDA_M)/12)+SUM(TEMPORALIDAD_MEDIDA_A),0)) as tiempo"),
                          'procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        )->groupby('procp_dg_imputados.idImputado')->get();

                      $imputadosCP = causas_penales\cp_jo_imputados::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_jo_imputados.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_jo_imputados.idCausa',$idRegistro)
                        ->select('procp_jo_imputados.*','procp_jo_imputados.id','procp_jo_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                        )->groupby('procp_jo_imputados.idImputado')->get();
                      $imputadosCP_P = causas_penales\cp_jo_pruebas::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_jo_pruebas.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_jo_pruebas.idCausa',$idRegistro)
                        ->select('procp_jo_pruebas.*','procp_jo_pruebas.id','procp_jo_pruebas.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                        )->groupby('procp_jo_pruebas.idImputado')->get();
                      $imputadosCP_S = causas_penales\cp_jo_suspension::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_jo_suspension.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_jo_suspension.idCausa',$idRegistro)
                        ->select('procp_jo_suspension.*','procp_jo_suspension.id','procp_jo_suspension.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                        )->groupby('procp_jo_suspension.idImputado')->get();                                                

                      foreach ($imputadosCP_P as $key => $value) {
                       $pruebas [$value->id] = causas_penales\cp_jo_pruebas::leftjoin('catrespuestas as cr', function($join)
                        {
                            $join->on('procp_jo_pruebas.TIPOS_DE_PRUEBAS','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',68);
                        }) 
                       ->leftjoin('catrespuestas as cr2', function($join)
                        {
                            $join->on('procp_jo_pruebas.ACTOR_PRUEBAS','=','cr2.id')
                            ->Where('cr2.idTipoRespuesta','=',84);
                        }) 
                        ->where('idCausa',$idRegistro)->where('idImputado',$value->idImputado)
                        ->select('procp_jo_pruebas.*','cr.Valor as PRUEBA',
                        'cr2.Valor as ACTOR')->get();
                      }
                      foreach ($imputadosCP_S as $key => $value) {
                       $suspension [$value->id] = causas_penales\cp_jo_suspension::where('idCausa',$idRegistro)->where('idImputado',$value->idImputado)
                       ->get();
                         // leftjoin('catrespuestas as cr', function($join)
                         //  {
                         //      $join->on('procp_jo_suspension.SUSPENSION_JUICIO','=','cr.id')
                         //      ->Where('cr.idTipoRespuesta','=',4);
                         //  }) 


                         // $recursos [$value->id]= causas_penales\cp_jo_recursos::leftjoin('catrespuestas as cr', function($join)
                         //  {
                         //      $join->on('procp_jo_recursos.TIPO_DE_RECURSO','=','cr.id')
                         //      ->Where('cr.idTipoRespuesta','=',39);
                         //  }) 
                         //  ->where('id_cp_juiciooral',$value->id)->select('procp_jo_recursos.*','cr.Valor as RECURSO')->get();
                      }

                      $audienciaInicial = causas_penales\cp_audienciainicial::where('idCausa',$idRegistro)
                        ->select(DB::raw("CASE WHEN IFNULL(procp_audienciainicial.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                          DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'),
                          'procp_audienciainicial.*')
                        ->whereRaw("IFNULL(procp_audienciainicial.FECHA_CIERRE,'')='' AND IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0)")
                        ->first();
                    }
                  }
                #endregion
                $listados=['imputadosDDL'=>$imputadosDDL,'imputadosDDL_S'=>$imputadosDDL_S,'imputadosDDL_P'=>$imputadosDDL_P,
                'imputadosCP'=>$imputadosCP,'imputadosCP_P'=>$imputadosCP_P,'imputadosCP_S'=>$imputadosCP_S];
                #region menus
                  $menuActivo=['1m' => '','1d' => '','2m' => '','2d' => '','3m' => '','3d' => '','4m' => '','4d' => '','5m' => '','5d' => '','6m' => '','6d' => '',
                  '7m' => '','7d' => '','8m' => '','8d' => '','9m' => '','9d' => '','10m' => '','10d' => '',];
                  $menuActivo['6m']='active';
                  $menuActivo['6d']='show active';
                #endregion                
                $data=['SiNo'=>$SiNo,'SiNoNoI'=>$SiNoNoI,'tipoSentencia'=>$tipoSentencia,'tipoPruebas'=>$tipoPruebas,
                      'actorPruebas'=>$actorPruebas,//'tipoRecurso'=>$tipoRecurso,
                      'pruebas'=>$pruebas,'suspension'=>$suspension,//'recursos'=>$recursos,
                       'listados'=>$listados,'audienciaInicial'=>$audienciaInicial,
                       'menuActivo' => $menuActivo,'Ctrl'=>$Ctrl,'resumen'=>$resumen,
                      'idExp' => bin2hex($idExp), 'idRegistro' => bin2hex($idRegistro),];
                  $mostrarCP=datos_expediente\de_datosgenerales::where('idExpediente',$idExp)->where('SENTIDO_DETERMINACION','=',10)->count();
                    return view('causas_penales.dashboard',compact('mostrarCP'))->with($data);
                break;

             case 'd0mc'://////CAUSAS PENALES MEDIDAS CAUTELARES
                #region Catalogos iniciales
                  $SiNo= $this->GetDataById('catrespuestas','idTipoRespuesta',2);
                  $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
                  $TMCautelares= $this->GetDataById('catrespuestas','idTipoRespuesta',34);
                #endregion                
                $resumen=[]; $imputadosCP=[]; $imputadosDDL=[];$audienciaInicial=[];$medidas=[];
                $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];
                #region Obtener Datos
                  if ($idExp > 0)
                  {
                    $datos = datos_expediente\de_datosgenerales::where('id',$idExp)->first();
                    $datos->FECHA_INICIO_CARPETA = empty(trim($datos->FECHA_INICIO_CARPETA))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO_CARPETA)));
                    $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                    $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                    $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                    $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();                    
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                    'NUC' => $datos->NUC_COMPLETA??'-','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO_CARPETA))?'-':$datos->FECHA_INICIO_CARPETA??'-','validacion'=>$validacion,'correccion'=>$correccion,
                    'idExpCorr'=>$idExp,'tablaCorr'=>'prode_datosgenerales'];
                    if ($idRegistro > 0) {
                      DB::statement("SET SQL_MODE=''");
                      $imputadosDDL = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_medidascautelares paii left join procp_dg_imputados pcpdgi on paii.idImputado=pcpdgi.id where paii.idCausa='".$idRegistro."' AND paii.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor') 
                        ,'procp_dg_imputados.FORMA_','procp_dg_imputados.DETENCION_LEGAL_ILEGAL')
                        ->groupby('procp_dg_imputados.idImputado')->get();  

                      $imputadosCP = causas_penales\cp_medidascautelares::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_medidascautelares.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_medidascautelares.idCausa',$idRegistro)
                        ->select('procp_medidascautelares.*','procp_medidascautelares.id','procp_medidascautelares.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'))
                        ->groupby('procp_medidascautelares.idImputado')->get();                        
                      
                      $audienciaInicial = causas_penales\cp_audienciainicial::where('idCausa',$idRegistro)
                        ->select(DB::raw("CASE WHEN IFNULL(procp_audienciainicial.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                          DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'),
                          'procp_audienciainicial.*')
                        ->whereRaw("IFNULL(procp_audienciainicial.FECHA_CIERRE,'')='' AND IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0)")
                        ->first();
                      foreach ($imputadosCP as $key => $value) {
                       $medidas [$value->id]= causas_penales\cp_mc_medidas::leftjoin('catrespuestas as cr', function($join)
                        {
                            $join->on('procp_mc_medidas.MEDIDAS_CAUTELARES','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',4);
                        })
                        ->leftjoin('catrespuestas as cr2', function($join)
                        {
                            $join->on('procp_mc_medidas.TIPO_MEDIDAS_CAUTELARES','=','cr2.id')
                            ->Where('cr2.idTipoRespuesta','=',34);
                        })
                        ->where('id_cp_medidascautelares',$value->id)->select('procp_mc_medidas.*',
                          DB::raw('IFNULL(cr.Valor,"-") as MEDIDAS'),DB::raw('IFNULL(cr2.Valor,"-") as TIPOMEDIDA'))
                        ->get();
                      }                      
                    }
                  }
                #endregion
                $listados=['imputadosDDL'=>$imputadosDDL,'imputadosCP'=>$imputadosCP];
                #region menus
                  $menuActivo=['1m' => '','1d' => '','2m' => '','2d' => '','3m' => '','3d' => '','4m' => '','4d' => '','5m' => '','5d' => '','6m' => '','6d' => '',
                  '7m' => '','7d' => '','8m' => '','8d' => '','9m' => '','9d' => '','10m' => '','10d' => '',];
                  $menuActivo['7m']='active';
                  $menuActivo['7d']='show active';
                #endregion                
                $data=['SiNoNoI'=>$SiNoNoI,'SiNo'=>$SiNo,'TMCautelares'=>$TMCautelares,'listados'=>$listados,
                        'audienciaInicial'=>$audienciaInicial,'medidas'=>$medidas,
                        'menuActivo' => $menuActivo,'Ctrl'=>$Ctrl,'resumen'=>$resumen,
                        'idExp' => bin2hex($idExp), 'idRegistro' => bin2hex($idRegistro),];
                  $mostrarCP=datos_expediente\de_datosgenerales::where('idExpediente',$idExp)->where('SENTIDO_DETERMINACION','=',10)->count();
                    return view('causas_penales.dashboard',compact('mostrarCP'))->with($data);
                break;

             case 'd0sa'://////CAUSAS PENALES SALIDAS ALTERNAS
                #region Catalogos iniciales
                  $SiNo= $this->GetDataById('catrespuestas','idTipoRespuesta',2);
                  $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
                  $acuerdo= $this->GetDataById('catrespuestas','idTipoRespuesta',35);
                  $tipoAcuerdo= $this->GetDataById('catrespuestas','idTipoRespuesta',59);
                  $tipoConImp= $this->GetDataById('catrespuestas','idTipoRespuesta',42);                  
                #endregion                
                $resumen=[]; 
                $imputadosCP=[]; $imputadosDDL=[];
                $imputadosCP_A=[]; $imputadosDDL_A=[];
                $imputadosCP_S=[]; $imputadosDDL_S=[];
                $audienciaInicial=[];$medidas=[];
                $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];
                $acuerdos =[];$suspensiones =[];
                #region Obtener Datos
                  if ($idExp > 0)
                  {
                    $datos = datos_expediente\de_datosgenerales::where('id',$idExp)->first();
                    $datos->FECHA_INICIO_CARPETA = empty(trim($datos->FECHA_INICIO_CARPETA))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO_CARPETA)));
                    $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                    $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                    $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                    $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();                    
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                    'NUC' => $datos->NUC_COMPLETA??'-','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO_CARPETA))?'-':$datos->FECHA_INICIO_CARPETA??'-',
                    'validacion'=>$validacion,'correccion'=>$correccion,
                    'idExpCorr'=>$idExp,'tablaCorr'=>'prode_datosgenerales'];
                    if ($idRegistro > 0) {
                      DB::statement("SET SQL_MODE=''");
                      $imputadosDDL_A = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_salidasalternas paii left join procp_dg_imputados pcpdgi on paii.idImputado=pcpdgi.id where paii.idCausa='".$idRegistro."' AND bitAcuerdosReparatorios=1 AND paii.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor') 
                        ,'procp_dg_imputados.FORMA_','procp_dg_imputados.DETENCION_LEGAL_ILEGAL')
                        ->groupby('procp_dg_imputados.idImputado')->get();  

                      $imputadosCP_A = causas_penales\cp_salidasalternas::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_salidasalternas.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_salidasalternas.idCausa',$idRegistro)->where('bitAcuerdosReparatorios','=',1)
                        ->select('procp_salidasalternas.*','procp_salidasalternas.id','procp_salidasalternas.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'))
                        ->groupby('procp_salidasalternas.idImputado')->get();                        

                      $imputadosDDL_S = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_salidasalternas paii left join procp_dg_imputados pcpdgi on paii.idImputado=pcpdgi.id where paii.idCausa='".$idRegistro."' AND bitSuspension=1 AND paii.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor') 
                        ,'procp_dg_imputados.FORMA_','procp_dg_imputados.DETENCION_LEGAL_ILEGAL')
                        ->groupby('procp_dg_imputados.idImputado')->get();  

                      $imputadosCP_S = causas_penales\cp_salidasalternas::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_salidasalternas.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_salidasalternas.idCausa',$idRegistro)->where('bitSuspension','=',1)
                        ->select('procp_salidasalternas.*','procp_salidasalternas.id','procp_salidasalternas.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'))
                        ->groupby('procp_salidasalternas.idImputado')->get();                        

                      $imputadosDDL = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_salidasalternas paii left join procp_dg_imputados pcpdgi on paii.idImputado=pcpdgi.id where paii.idCausa='".$idRegistro."' AND paii.FOLIO_AE IS NOT NULL AND paii.ACTO_EQUIVALENTE_MONTO IS NOT NULL AND paii.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor') 
                        ,'procp_dg_imputados.FORMA_','procp_dg_imputados.DETENCION_LEGAL_ILEGAL')
                        ->groupby('procp_dg_imputados.idImputado')->get();  

                      $imputadosCP = causas_penales\cp_salidasalternas::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_salidasalternas.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_salidasalternas.idCausa',$idRegistro)
                        ->whereNotNull('procp_salidasalternas.FOLIO_AE')->whereNotNull('procp_salidasalternas.ACTO_EQUIVALENTE_MONTO')
                        ->select('procp_salidasalternas.*','procp_salidasalternas.id','procp_salidasalternas.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'))
                        ->groupby('procp_salidasalternas.idImputado')->get();

                      $audienciaInicial = causas_penales\cp_audienciainicial::where('idCausa',$idRegistro)
                        ->select(DB::raw("CASE WHEN IFNULL(procp_audienciainicial.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                          DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'),
                          'procp_audienciainicial.*')
                        ->whereRaw("IFNULL(procp_audienciainicial.FECHA_CIERRE,'')='' AND IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0)")
                        ->first();                        
                      foreach ($imputadosCP_A as $key => $value) {
                       $acuerdos [$value->id]= causas_penales\cp_sa_acuerdos::leftjoin('catrespuestas as cr', 
                        function($join)
                        {
                            $join->on('procp_sa_acuerdos.ACUERDO_REPARATORIO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',35);
                        })
                        ->leftjoin('catrespuestas as cr2', function($join)
                        {
                            $join->on('procp_sa_acuerdos.ACUERDOS_REPARATORIOS','=','cr2.id')
                            ->Where('cr2.idTipoRespuesta','=',59);
                        })
                        ->where('id_cp_salidasalternas',$value->id)->select('procp_sa_acuerdos.*',
                          DB::raw('IFNULL(cr.Valor,"-") as ACUERDO'),
                          DB::raw('IFNULL(cr2.Valor,"-") as ACUERDOS'))->get();
                      }
                      foreach ($imputadosCP_S as $key => $value) {                      
                       $suspensiones [$value->id]= causas_penales\cp_sa_suspensiones::leftjoin('catrespuestas as cr', 
                        function($join)
                        {
                            $join->on('procp_sa_suspensiones.TIPO_SUSPENSION','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',42);
                        })
                        ->leftjoin('catrespuestas as cr2', function($join)
                        {
                            $join->on('procp_sa_suspensiones.REVOCACION_SUSPENSION','=','cr2.id')
                            ->Where('cr2.idTipoRespuesta','=',2);
                        })
                        ->leftjoin('catrespuestas as cr3', function($join)
                        {
                            $join->on('procp_sa_suspensiones.REAPERTURA','=','cr3.id')
                            ->Where('cr3.idTipoRespuesta','=',4);
                        })
                        ->where('id_cp_salidasalternas',$value->id)->select('procp_sa_suspensiones.*',
                          DB::raw('IFNULL(cr.Valor,"-") as TIPOSUSPENSION'),
                          DB::raw('IFNULL(cr2.Valor,"-") as REVOCACION'),
                          DB::raw('IFNULL(cr3.Valor,"-") as REAPERTURAVALOR'))->get();                        
                      }
                    }
                  }
                #endregion
                $listados=['imputadosDDL'=>$imputadosDDL,'imputadosCP'=>$imputadosCP,
                          'imputadosDDL_S'=>$imputadosDDL_S,'imputadosCP_S'=>$imputadosCP_S,
                          'imputadosDDL_A'=>$imputadosDDL_A,'imputadosCP_A'=>$imputadosCP_A,];
                #region menus
                  $menuActivo=['1m' => '','1d' => '','2m' => '','2d' => '','3m' => '','3d' => '','4m' => '','4d' => '','5m' => '','5d' => '','6m' => '','6d' => '',
                  '7m' => '','7d' => '','8m' => '','8d' => '','9m' => '','9d' => '','10m' => '','10d' => '',];
                  $menuActivo['8m']='active';
                  $menuActivo['8d']='show active';
                #endregion                
                $data=['SiNoNoI'=>$SiNoNoI,'SiNo'=>$SiNo,
                        'acuerdo'=>$acuerdo,'tipoAcuerdo'=>$tipoAcuerdo,'tipoConImp'=>$tipoConImp,
                        'listados'=>$listados,'audienciaInicial'=>$audienciaInicial,
                        'acuerdos'=>$acuerdos,'suspensiones'=>$suspensiones,
                        'menuActivo' => $menuActivo,'Ctrl'=>$Ctrl,'resumen'=>$resumen,
                        'idExp' => bin2hex($idExp), 'idRegistro' => bin2hex($idRegistro),];
                  $mostrarCP=datos_expediente\de_datosgenerales::where('idExpediente',$idExp)->where('SENTIDO_DETERMINACION','=',10)->count();
                    return view('causas_penales.dashboard',compact('mostrarCP'))->with($data);
                break;
             case 'd0ss'://////CAUSAS PENALES SUSPENSION Y SOBRESEIMIENTO
                #region Catalogos iniciales
                  $SiNo= $this->GetDataById('catrespuestas','idTipoRespuesta',2);
                  $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
                  $causasSus= $this->GetDataById('catrespuestas','idTipoRespuesta',33);
                  $causasSobre= $this->GetDataById('catrespuestas','idTipoRespuesta',36);
                  $tipoSobre= $this->GetDataById('catrespuestas','idTipoRespuesta',37);
                #endregion                
                $resumen=[]; $imputadosCP=[]; $imputadosDDL=[];$audienciaInicial=[];$medidas=[];
                $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];
                $acuerdos =[];$suspension =[];$suspensiones=[];
                #region Obtener Datos
                  if ($idExp > 0)
                  {
                    $datos = datos_expediente\de_datosgenerales::where('id',$idExp)->first();
                    $datos->FECHA_INICIO_CARPETA = empty(trim($datos->FECHA_INICIO_CARPETA))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO_CARPETA)));
                    $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                    $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                    $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                    $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();                    
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                    'NUC' => $datos->NUC_COMPLETA??'-','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO_CARPETA))?'-':$datos->FECHA_INICIO_CARPETA??'-',
                    'validacion'=>$validacion,'correccion'=>$correccion,
                    'idExpCorr'=>$idExp,'tablaCorr'=>'prode_datosgenerales'];
                    if ($idRegistro > 0) {
                      DB::statement("SET SQL_MODE=''");
                      $imputadosDDL = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_ss_imputados paii left join procp_dg_imputados pcpdgi on paii.idImputado=pcpdgi.id where paii.idCausa='".$idRegistro."' AND paii.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor') 
                        ,'procp_dg_imputados.FORMA_','procp_dg_imputados.DETENCION_LEGAL_ILEGAL')
                        ->groupby('procp_dg_imputados.idImputado')->get();  

                      $imputadosCP = causas_penales\cp_ss_imputados::
                      leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_ss_imputados.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_ss_imputados.idCausa',$idRegistro)
                        ->select('procp_ss_imputados.*','procp_ss_imputados.id','procp_ss_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'))
                        ->groupby('procp_ss_imputados.idImputado')->get();                        
                      
                      $audienciaInicial = causas_penales\cp_audienciainicial::where('idCausa',$idRegistro)
                        ->select(DB::raw("CASE WHEN IFNULL(procp_audienciainicial.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                          DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'),
                          'procp_audienciainicial.*')
                        ->whereRaw("IFNULL(procp_audienciainicial.FECHA_CIERRE,'')='' AND IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0)")
                        ->first();
                     $suspension=causas_penales\cp_suspensionsobreseimiento::where('idCausa',$idRegistro)
                      ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('procp_suspensionsobreseimiento.CAUSA_PROCESO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',33);
                        })
                      ->leftJoin('catrespuestas as cr3', function($join)
                        {
                            $join->on('procp_suspensionsobreseimiento.REAPERTURA_PROCESO','=','cr3.id')
                            ->Where('cr3.idTipoRespuesta','=',2);
                        })
                      ->select('procp_suspensionsobreseimiento.*',DB::raw('IFNULL(cr.Valor,"-") AS Valor'),DB::raw('IFNULL(cr3.Valor,"-") AS Valor3'))->first();    
                     
                    }
                  }
                #endregion
                $listados=['imputadosDDL'=>$imputadosDDL,'imputadosCP'=>$imputadosCP];
                #region menus
                  $menuActivo=['1m' => '','1d' => '','2m' => '','2d' => '','3m' => '','3d' => '','4m' => '','4d' => '','5m' => '','5d' => '','6m' => '','6d' => '',
                  '7m' => '','7d' => '','8m' => '','8d' => '','9m' => '','9d' => '','10m' => '','10d' => '',];
                  $menuActivo['9m']='active';
                  $menuActivo['9d']='show active';
                #endregion                
                $data=['SiNoNoI'=>$SiNoNoI,'SiNo'=>$SiNo, 'causasSus'=>$causasSus, 
                      'causasSobre'=>$causasSobre, 'tipoSobre'=>$tipoSobre,
                      'listados'=>$listados,'audienciaInicial'=>$audienciaInicial,'suspension'=>$suspension,
                      'acuerdos'=>$acuerdos,'suspensiones'=>$suspensiones,
                      'menuActivo' => $menuActivo,'Ctrl'=>$Ctrl,'resumen'=>$resumen,
                      'idExp' => bin2hex($idExp), 'idRegistro' => bin2hex($idRegistro),];
                  $mostrarCP=datos_expediente\de_datosgenerales::where('idExpediente',$idExp)->where('SENTIDO_DETERMINACION','=',10)->count();
                    return view('causas_penales.dashboard',compact('mostrarCP'))->with($data);
                break;                
             case 'd0re'://////CAUSAS PENALES RECURSOS
                $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
                $tipoRecurso= $this->GetDataById('catrespuestas','idTipoRespuesta',39);
                $Resol= $this->GetDataById('catrespuestas','idTipoRespuesta',85);
                $resumen=[]; $imputadosCP=[]; $imputadosDDL=[];$pruebas=[];$suspension=[];$recursos=[];$audienciaInicial=[];
                $resumen = ['UNIDAD'=>$this->obtenerUnidadUser(Auth::User()->Unidad), 'RESPONSABLE'=>Auth::User()->name ?? '-'];
                #region Obtener Datos
                  if ($idExp > 0)
                  {
                    $datos = datos_expediente\de_datosgenerales::where('id',$idExp)->first();
                    $datos->FECHA_INICIO_CARPETA = empty(trim($datos->FECHA_INICIO_CARPETA))?'':date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO_CARPETA)));
                    $delegacion =DB::table('catdelegaciones')->where('id',$datos->DELEGACION)->first();
                    $validacion=bitCorreccionesValidaciones::where(['Activo'=>1,'validacion'=>1,'idExpediente'=>$idExp])->count();
                    $correccion=bitCorreccionesValidaciones::where(['Activo'=>1,'Correccion'=>1,'idExpediente'=>$idExp])->count();
                    $basecaptura= bitbasecaptura::where('idExpediente',$idExp)->first();
                    $unidadUser = $this->obtenerUnidadUser(Auth::User()->Unidad);
                    $resumen=['NO_EXPEDIENTE'=>$datos->NO_EXPEDIENTE??'-','DELEGACION'=>$delegacion->Valor??'-',
                    // 'UNIDAD'=>$basecaptura->UNIDAD??'-', 'RESPONSABLE'=>$basecaptura->RESPONSABLE??'-',
                    // 'RESPONSABLE'=>$datos->NOMBRE_AGENTE_MP??'-',
                    'UNIDAD'=>$unidadUser, 'RESPONSABLE'=>Auth::User()->name ?? '-',
                    'NUC' => $datos->NUC_COMPLETA??'-','FECHA_INICIO_CARPETA'=>empty(trim($datos->FECHA_INICIO_CARPETA))?'-':$datos->FECHA_INICIO_CARPETA??'-',
                    'validacion'=>$validacion,'correccion'=>$correccion,'idExpCorr'=>$idExp,'tablaCorr'=>'prode_datosgenerales'];
                    if ($idRegistro > 0) {
                      DB::statement("SET SQL_MODE=''");
                      $imputadosDDL = causas_penales\cp_dg_imputados::leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('idCausa',$idRegistro)
                        ->whereRaw("procp_dg_imputados.idImputado NOT IN (select pcpdgi.idImputado from procp_recursos pcpjo left join procp_dg_imputados pcpdgi on pcpjo.idImputado=pcpdgi.id where pcpjo.idCausa='".$idRegistro."' AND pcpjo.deleted_at IS NULL)")
                        ->select('procp_dg_imputados.id','procp_dg_imputados.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        )->groupby('procp_dg_imputados.idImputado')->get();  

                      $imputadosCP = causas_penales\cp_recursos::leftjoin('procp_dg_imputados as pcpi','pcpi.id','=','procp_recursos.idImputado')
                        ->leftjoin('prode_imputados as pdi','pcpi.idImputado','=','pdi.id')
                        ->leftJoin('catrespuestas as cr', function($join)
                        {
                            $join->on('pdi.SEXO_IMPUTADO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',17);
                        })                                            
                        ->where('procp_recursos.idCausa',$idRegistro)
                        ->select('procp_recursos.*','procp_recursos.id','procp_recursos.idImputado',
                        DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'),  
                        DB::raw('CONCAT(CASE WHEN TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", pdi.PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END," / ",IFNULL(cr.Valor,"-")," / ",pdi.EDAD_HECHOS_IMPUTADOS) as encabezado'),
                        )->groupby('procp_recursos.idImputado')->get();                        
                      foreach ($imputadosCP as $key => $value) {                       
                       $recursos [$value->id]= causas_penales\cp_re_recursos::leftjoin('catrespuestas as cr', function($join)
                        {
                            $join->on('procp_re_recursos.TIPO_DE_RECURSO','=','cr.id')
                            ->Where('cr.idTipoRespuesta','=',39);
                        })
                        ->leftjoin('catrespuestas as cr2', function($join)
                        {
                            $join->on('procp_re_recursos.RESOLUCION_DEL_RECURSO','=','cr2.id')
                            ->Where('cr2.idTipoRespuesta','=',85);
                        }) 
                        ->where('id_cp_recursos',$value->id)->select('procp_re_recursos.*','cr.Valor as RECURSO'
                        ,'cr2.Valor as RESOLUCION')->get();
                      }
                      $audienciaInicial = causas_penales\cp_audienciainicial::where('idCausa',$idRegistro)
                        ->select(DB::raw("CASE WHEN IFNULL(procp_audienciainicial.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                          DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'),
                          'procp_audienciainicial.*')
                        ->whereRaw("IFNULL(procp_audienciainicial.FECHA_CIERRE,'')='' AND IFNULL((90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15),0)")
                        ->first();

                    }
                  }
                #endregion
                $listados=['imputadosDDL'=>$imputadosDDL,'imputadosCP'=>$imputadosCP];
                #region menus
                  $menuActivo=['1m' => '','1d' => '','2m' => '','2d' => '','3m' => '','3d' => '','4m' => '','4d' => '','5m' => '','5d' => '','6m' => '','6d' => '',
                  '7m' => '','7d' => '','8m' => '','8d' => '','9m' => '','9d' => '','10m' => '','10d' => '',];
                  $menuActivo['10m']='active';
                  $menuActivo['10d']='show active';
                #endregion                
                $data=['SiNoNoI'=>$SiNoNoI,//'tipoSentencia'=>$tipoSentencia,'tipoPruebas'=>$tipoPruebas,
                      'tipoRecurso'=>$tipoRecurso,'Resol'=>$Resol,
                      //'pruebas'=>$pruebas,'suspension'=>$suspension,
                      'recursos'=>$recursos,
                       'listados'=>$listados,'audienciaInicial'=>$audienciaInicial,
                       'menuActivo' => $menuActivo,'Ctrl'=>$Ctrl,'resumen'=>$resumen,
                      'idExp' => bin2hex($idExp), 'idRegistro' => bin2hex($idRegistro),];
                  $mostrarCP=datos_expediente\de_datosgenerales::where('idExpediente',$idExp)->where('SENTIDO_DETERMINACION','=',10)->count();
                    return view('causas_penales.dashboard',compact('mostrarCP'))->with($data);
                break;

          }
         }
         else
         {
            return redirect("Salir");
         }

        }
    }

 #Cargar Datos Secciones
    public function CargarAddVictimas(Request $request)
    {
      #region Catalogos
        $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
        $SiNo= $this->GetDataById('catrespuestas','idTipoRespuesta',2);
        $entidades = $this->GetCatalogo('catentidadesfederativas_inegi');
        $paises = $this->GetCatalogo('catpaises');
        $ocupacion = $this->GetCatalogo('catocupaciones');
        $municipios = [];

        $tipoVictima = $this->GetDataById('catrespuestas','idTipoRespuesta',13);
        $delitoRelacionado = $this->GetDataById('catrespuestas','idTipoRespuesta',14);
        $sector = $this->GetDataById('catrespuestas','idTipoRespuesta',15);
        $tipoPersonaMoral = $this->GetDataById('catrespuestas','idTipoRespuesta',16);
        $sexo = $this->GetDataById('catrespuestas','idTipoRespuesta',17);
        $sConyugal = $this->GetDataById('catrespuestas','idTipoRespuesta',18);
        $sMigratoria = $this->GetDataById('catrespuestas','idTipoRespuesta',1);
        $tipoDiscapacidad = $this->GetDataById('catrespuestas','idTipoRespuesta',19);
        $escolaridad = $this->GetDataById('catrespuestas','idTipoRespuesta',20);
        $relacionImp = $this->GetDataById('catrespuestas','idTipoRespuesta',21);
        $tipoAsesoria = $this->GetDataById('catrespuestas','idTipoRespuesta',61);
        $lenguaExtranejera = $this->GetDataById('catrespuestas','idTipoRespuesta',65);
        $PobInd = $this->GetDataById('catrespuestas','idTipoRespuesta',71);
        $LenInd = $this->GetDataById('catrespuestas','idTipoRespuesta',72);

        $tipoDef = $this->GetDataById('catrespuestas','idTipoRespuesta',98);
        $certDef = $this->GetDataById('catrespuestas','idTipoRespuesta',99);
        $sitioDef = $this->GetDataById('catrespuestas','idTipoRespuesta',100);
        $lesionDef = $this->GetDataById('catrespuestas','idTipoRespuesta',101);
        $SiNoNoE = $this->GetDataById('catrespuestas','idTipoRespuesta',102);
        $eventoDef = $this->GetDataById('catrespuestas','idTipoRespuesta',103);
        $victimaDef = $this->GetDataById('catrespuestas','idTipoRespuesta',104);
        $armaDef = $this->GetDataById('catrespuestas','idTipoRespuesta',105);        

        $respuestas=['SiNoNoI'=>$SiNoNoI,
               'SiNo'=>$SiNo,
               'entidades'=>$entidades,
               'paises'=>$paises,
               'ocupacion'=>$ocupacion,
               'municipios'=>$municipios,
               'tipoVictima'=>$tipoVictima,
               'delitoRelacionado'=>$delitoRelacionado,
               'sector'=>$sector,
               'tipoPersonaMoral'=>$tipoPersonaMoral,
               'sexo'=>$sexo,
               'sConyugal'=>$sConyugal,
               'sMigratoria'=>$sMigratoria,
               'tipoDiscapacidad'=>$tipoDiscapacidad,
               'escolaridad'=>$escolaridad,
               'relacionImp'=>$relacionImp,
               'tipoAsesoria'=>$tipoAsesoria,
               'lenguaExtranejera'=>$lenguaExtranejera,
               'PobInd' => $PobInd,
               'LenInd' => $LenInd,
               'tipoDef'=>$tipoDef,'certDef'=>$certDef,'sitioDef'=>$sitioDef,'lesionDef'=>$lesionDef,
               'SiNoNoE'=>$SiNoNoE,'eventoDef'=>$eventoDef,'victimaDef'=>$victimaDef,'armaDef'=>$armaDef];
      #endregion

      #region Obtener Datos
        $datos=[];
        switch ($request->carpeta) {
        case 'e3':
          $datos=datos_expediente\de_victimas::where('id',$request->idVictima)->first();
        break;
        case 'd9':
          $datos=carpeta_conduccion\cc_victimas::where('id',$request->idVictima)->first();
        break;             
        case 'he':
          $datos=no_delictivos\nd_victimas::where('id',$request->idVictima)->first();
        break;
        }
      #endregion

      $data= ['respuestas' => $respuestas,'datos'=>$datos];

      return response()->json($data);
    }
    public function CargarAddImputados(Request $request)
    {
      #region Catalogos
       $SiNo= $this->GetDataById('catrespuestas','idTipoRespuesta',2);
       $SiNoNoI= $this->GetDataById('catrespuestas','idTipoRespuesta',4);
       $SiNoA= $this->GetDataById('catrespuestas','idTipoRespuesta',333);
       $entidades = $this->GetCatalogo('catentidadesfederativas_inegi');
       $paises = $this->GetCatalogo('catpaises');
       $ocupacion = $this->GetCatalogo('catocupaciones');
       $municipios = [];

       $tipoImputado = $this->GetDataById('catrespuestas','idTipoRespuesta',130);
       $sector = $this->GetDataById('catrespuestas','idTipoRespuesta',15);
       $tipoPersonaMoral = $this->GetDataById('catrespuestas','idTipoRespuesta',16);
       $delitoRelacionado = $this->GetDataById('catrespuestas','idTipoRespuesta',14);
       $relacionVict = $this->GetDataById('catrespuestas','idTipoRespuesta',21);
       $sexo = $this->GetDataById('catrespuestas','idTipoRespuesta',17);
       $sConyugal = $this->GetDataById('catrespuestas','idTipoRespuesta',18);
       $sMigratoria = $this->GetDataById('catrespuestas','idTipoRespuesta',1);
       $tipoDiscapacidad = $this->GetDataById('catrespuestas','idTipoRespuesta',19);
       $escolaridad = $this->GetDataById('catrespuestas','idTipoRespuesta',20);
       $tipoAsesDef = $this->GetDataById('catrespuestas','idTipoRespuesta',61);
       $situacionImp = $this->GetDataById('catrespuestas','idTipoRespuesta',22);
       $tipoDetencion = $this->GetDataById('catrespuestas','idTipoRespuesta',23);
       $autDetencion = $this->GetDataById('catrespuestas','idTipoRespuesta',24);
       $gradoPart = $this->GetDataById('catrespuestas','idTipoRespuesta',52);
       $lenguaExtranejera = $this->GetDataById('catrespuestas','idTipoRespuesta',65);
       $tipoMand = $this->GetDataById('catrespuestas','idTipoRespuesta',66);
       $PobInd = $this->GetDataById('catrespuestas','idTipoRespuesta',71);
       $LenInd = $this->GetDataById('catrespuestas','idTipoRespuesta',72);
       $razonRND =$this->GetDataById('catrespuestas','idTipoRespuesta',73);
       $examen =$this->GetDataById('catrespuestas','idTipoRespuesta',74);
       $estadoPres =$this->GetDataById('catrespuestas','idTipoRespuesta',75);
       $situacionLibertad =$this->GetDataById('catrespuestas','idTipoRespuesta',95);
       $audineciaPx= $this->GetDataById('catrespuestas','idTipoRespuesta',31);

       $respuestas=['SiNo'=>$SiNo, 'SiNoNoI'=>$SiNoNoI, 'SiNoA'=>$SiNoA,
                   'entidades'=>$entidades, 'paises'=>$paises, 'ocupacion'=>$ocupacion, 'municipios'=>$municipios, 'tipoImputado'=>$tipoImputado,
                   'sector'=>$sector, 'tipoPersonaMoral'=>$tipoPersonaMoral, 'delitoRelacionado'=>$delitoRelacionado, 'relacionVict'=>$relacionVict,
                   'sexo'=>$sexo, 'sConyugal'=>$sConyugal, 'sMigratoria'=>$sMigratoria, 'tipoDiscapacidad'=>$tipoDiscapacidad, 'escolaridad'=>$escolaridad,
                   'tipoAsesDef'=>$tipoAsesDef, 'situacionImp'=>$situacionImp, 'tipoDetencion'=>$tipoDetencion, 'autDetencion'=>$autDetencion,
                   'gradoPart'=>$gradoPart, 'lenguaExtranejera'=>$lenguaExtranejera, 'tipoMand'=>$tipoMand, 'PobInd' => $PobInd, 'LenInd' => $LenInd,
                   'razonRND'=>$razonRND, 'examen' => $examen, 'estadoPres' => $estadoPres,'situacionLibertad'=>$situacionLibertad,
                   'audineciaPx'=>$audineciaPx];
      #endregion

      #region Obtener Datos
       $datos=[];
       switch ($request->carpeta) {
           case 'e3':
              $datos=datos_expediente\de_imputados::where('id',$request->idImputado)->first();
           break;
           case 'd9':
              $datos=carpeta_conduccion\cc_imputados::where('id',$request->idImputado)->first();
           break;
       }
      #endregion

      $data= ['respuestas' => $respuestas,'datos'=>$datos];

      return response()->json($data);
    }
    public function CargarAddDelitos(Request $request)
    {
      #region Catalogos
       $ordenamientos = $this->GetCatalogo('catordenamientos');
       $delitosGrl = [];
       $delitosEsp = [];

       $ordenamientosJur=$this->GetCatalogo('catordenamientosjur');
       $delitosJur=[];

       $delitos = $this->GetDataById('catdelitosespecificosConduccion','Conduccion',1);

       $noDelitos = $this->GetDataById('catrespuestas','idTipoRespuesta',70);
       $contexto = $this->GetDataById('catrespuestas','idTipoRespuesta',43);
       $consumacion = $this->GetDataById('catrespuestas','idTipoRespuesta',5);
       $modalidad = $this->GetDataById('catrespuestas','idTipoRespuesta',6);
       $formaAccion = $this->GetDataById('catrespuestas','idTipoRespuesta',49);
       $instrumento = $this->GetDataById('catrespuestas','idTipoRespuesta',7);
       $fuero = $this->GetDataById('catrespuestas','idTipoRespuesta',8);
       $tipo_sitio_ocurrencia = $this->GetDataById('catrespuestas','idTipoRespuesta',9);
       $comision = $this->GetDataById('catrespuestas','idTipoRespuesta',11);
       $calDelito = $this->GetDataById('catrespuestas','idTipoRespuesta',10);

       $respuestas=['contexto'=>$contexto,
                   'consumacion'=>$consumacion,
                   'modalidad'=>$modalidad,
                   'formaAccion'=>$formaAccion,
                   'instrumento'=>$instrumento,
                   'fuero'=>$fuero,
                   'tipo_sitio_ocurrencia'=>$tipo_sitio_ocurrencia,
                   'comision'=>$comision,
                   'calDelito'=>$calDelito,];
      #endregion

      #region Obtener Datos
       $datos=[];
       switch ($request->carpeta) {
         case 'e3':
            $datos=datos_expediente\de_hechos::leftjoin('catdelitosespecificos as cde','cde.id','=','prode_hechos.DELITO')
            ->leftjoin('catdelitosgenerales as cdg','cde.idDelitoGeneral','=','cdg.id')
            ->leftjoin('catdelitosjur as cdj','prode_hechos.DELITO_JUR','=','cdj.id')
            ->select('prode_hechos.*',
              DB::raw("IFNULL(cdj.idOrdenamientoJUR,-1) as idOrdenamientoJUR"), 
              DB::raw("IFNULL(cdg.id,-1) as idDelitoGeneral"),
              DB::raw("IFNULL(cdg.idOrdenamiento,-1) as idOrdenamiento"))
            ->where('prode_hechos.id',$request->idDelito)->first();
         break;
         case 'd9':
            $datos=carpeta_conduccion\cc_hechos::leftjoin('catdelitosjur as cdj','procc_hechos.DELITO_JUR','=','cdj.id')
            ->select('procc_hechos.*',
              DB::raw("IFNULL(cdj.idOrdenamientoJUR,-1) as idOrdenamientoJUR"))
            ->where('procc_hechos.id',$request->idDelito)->first();
         break;
       }
      #endregion

      $data= ['ordenamientos' => $ordenamientos,
              'delitos'    =>$delitos,
              'ordenamientosJur'=>$ordenamientosJur,
              'delitosJur' =>$delitosJur,
              'noDelitos'  =>$noDelitos,
              'delitosGrl' => $delitosGrl,
              'delitosEsp' => $delitosEsp,
              'respuestas' => $respuestas,
              'datos'      =>$datos];

           return response()->json($data);
    }
    public function CargarAddObjetos(Request $request)
    {
        #region Catalogos
         $objetos= $this->GetDataById('catrespuestas','idTipoRespuesta',25);
         $estatus= $this->GetDataById('catrespuestas','idTipoRespuesta',91);
         $narcoticos = $this->GetDataById('catrespuestas','idTipoRespuesta',26);
         $estatusV = $this->GetDataById('catrespuestas','idTipoRespuesta',77);

         $respuestas=['objetos'=>$objetos,'estatus'=>$estatus,
                     'narcoticos'=>$narcoticos,
                     'estatusV'=>$estatusV];
                    #endregion

        #region Obtener Datos
          $datos=[];
         switch ($request->carpeta) {
             case 'e3':
                $datos=datos_expediente\de_objetos::where('id',$request->idObjeto)->first();
             break;
             case 'd9':
                $datos=carpeta_conduccion\cc_objetos::where('id',$request->idObjeto)->first();
             break;
             case 'he':
                $datos=no_delictivos\nd_objetos::where('id',$request->idObjeto)->first();
             break;
         }
        #endregion

        $data= ['respuestas' => $respuestas,'datos'=>$datos];

             return response()->json($data);
    }
    public function CargarAddRelacion(Request $request)
    {
      #region Catalogos
       $imputados= datos_expediente\de_imputados::where('idExpediente',hex2bin($request->idExp))
       ->select('id',DB::raw('CASE WHEN TIPO_IMPUTADO=2 THEN RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN "LA SOCIEDAD" WHEN TIPO_IMPUTADO=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_IMPUTADO=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_IMPUTADO," ", PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) END as Valor'))
       ->get();
       $victimas = datos_expediente\de_victimas::where('idExpediente',hex2bin($request->idExp))
       ->select('id',DB::raw('CASE WHEN TIPO_VICTIMA=2 THEN RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN "LA SOCIEDAD" WHEN TIPO_VICTIMA=5 THEN "SIN IDENTIFICAR/DESCONOCIDO" WHEN TIPO_VICTIMA=7 THEN "LA SALUD" ELSE CONCAT(NOMBRE_VICTIMA," ", PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_VICTIMAS) END as Valor'))
       ->get();
       $delitos =  datos_expediente\de_hechos::join('catdelitosespecificos as cde','prode_hechos.DELITO','=','cde.id')
       ->where('idExpediente',hex2bin($request->idExp))->select('prode_hechos.id','cde.Valor')->get();

       $respuestas=['imputados'=>$imputados,
                      'victimas'=>$victimas,
                      'delitos'=>$delitos,];
      #endregion
      #region Obtener Datos
      #endregion

      $data= ['respuestas' => $respuestas];

           return response()->json($data);
    }
    public function CargarCausas(Request $request)
    {

        #region Catalogos
            /// 1
            /// 2
            $etapaSusp= null;
            $etapaSobre= null;
            /// 4
            /// 5
            /// 6          
            /// 7
        switch ($request->seccion)
        {
            case 1:

                break;
            case 2:
                $etapaSusp= $this->GetDataById('catrespuestas','idTipoRespuesta',46);
                $etapaSobre= $this->GetDataById('catrespuestas','idTipoRespuesta',47);

                 break;
            case 3:                
                break;
            case 4:                
                break;
            case 5:
                break;
            case 6:
                break;
            case 7:                
                break;
            default:
                break;
        }

         $respuestas=[
                    'etapaSusp'=>$etapaSusp, 'etapaSobre'=>$etapaSobre,];
        #endregion

        #region Obtener Datos
        #endregion

        $data= ['respuestas' => $respuestas];

             return response()->json($data);
    }
    #region validaciones
      public function ValidarCausasDuplicadas(Request $request)
      {
        $idCausa=hex2bin($request->idCausa);
        $Causa=$request->valor;
        $data=[];
        $countCP=0;
          $countCP=causas_penales\cp_datosgenerales::where('CAUSA_PENAL_ID','=',$request->valor)->Where('id','!=', $idCausa)->count();

        $data=['countCP'=>$countCP,'respuesta'=>$countCP==0];
        return response()->json($data);
      }
      public function ValidarRelacionDuplicadas(Request $request)
      {
        $idCausa=hex2bin($request->idCausa);
        $json=$request->json;
        $data=[];
        $relacionCP=0;
        $value=json_decode(rtrim($json,","),true);
        if ((strlen($value['imputado']) > 0)  && (strlen($value['victimas']) > 0) && (strlen($value['delitos']) > 0)) {
          $imputado=$value['imputado'];$victimas=explode(",",$value['victimas']);$delitos=explode(",",$value['delitos']);
          $relacionCP = causas_penales\cp_dg_relacionimputado::
          leftjoin('procp_dg_imputados as pcpdgim', function($join){
            $join->on('pcpdgim.id','=','procp_dg_relacionimputado.idcp_dg_imputados')
            ->whereNull('pcpdgim.deleted_at');
          })->Where('idImputado',$imputado)->where('idCausa',$idCausa)->whereIn('idDelito',$delitos)->whereIn('idVictima',$victimas)->count();
        }
        $data=['idCausa'=>$idCausa,'respuesta'=>$relacionCP==0,'countRD'=>$relacionCP];
        return response()->json($data);
      }
      public function EditarMASC_CP(Request $request)
      {
      $idCausa=hex2bin($request->idCausa);
      $idExp=hex2bin($request->idExp);
      $data=[];
        $post=causas_penales\cp_dg_imputados::where('id',$request->idImputado)
        ->update(['MASC'=>$request->MASC1,
          'FECHA_DERIVA_MASC'=>$request->MASC2,
          'FECHA_CUMPL_MAS'=>$request->MASC3,
          'TIPO_CUMPLIMIENTO'=>$request->MASC4,
          'TIPO_MASC'=>$request->MASC5,
          'AUTORIDAD_DERIVA_MASC'=>$request->MASC6]);    
            $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $idExp,
              'idRegistro' => $request->idImputado,
              'idEvento' => 156,
              'Evento' => 'Editar Datos MASC Imputado Causa Penal']);
          $data=['respuesta'=>$post,'redirect' => route("dash",['d0',$idExp,$idCausa])];
        
        return response()->json($data);
      }
      public function eliminarMASC_CP(Request $request)
      {
      $idExp=hex2bin($request->idExp);
      $data=[];
        $post=datos_expediente\de_imputados::where('id',$request->idImputado)->update(['MASC'=>null,
          'FECHA_DERIVA_MASC'=>null,
          'FECHA_CUMPL_MAS'=>null,
          'TIPO_CUMPLIMIENTO'=>null,
          'TIPO_MASC'=>null,
          'AUTORIDAD_DERIVA_MASC'=>null]);
            $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $idExp,
              'idRegistro' => $request->idImputado,
              'idEvento' => 157,
              'Evento' => 'Editar Datos MASC Imputado Datos de expediente']);
          $data=['respuesta'=>$post,'redirect' => route("dash",['e3masc',$idExp])];
        
        return response()->json($data);
      }      

      public function BuscarCP(Request $request)
      {
        $idRegistro=hex2bin($request->idCausa);
        $idExp=hex2bin($request->idExpediente);      
        $filtro=$request->filtro;
        $data=[];

        $causa=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','pdg.id','=','procp_datosgenerales.idExpediente')
          ->whereraw("procp_datosgenerales.CAUSA_PENAL_ID LIKE '%".$filtro."%'")
          ->where('pdg.id','!=',$idExp)->where('procp_datosgenerales.id','!=',$idRegistro)->orderByDesc('procp_datosgenerales.id')
          ->leftjoin(DB::raw("(select idCausa, GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_IMPUTADO=2 THEN pdei.RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(pdei.NOMBRE_IMPUTADO,' ',pdei.PRIMER_APELLIDO,' ',pdei.SEGUNDO_APELLIDO_IMPUTADOS)END)) as imputados from procp_dg_imputados pcpi left join prode_imputados pdei on pcpi.idImputado=pdei.id WHERE pcpi.deleted_at IS NULL GROUP BY idCausa) as imp"),'imp.idCausa', '=', 'procp_datosgenerales.id')
          ->leftjoin(DB::raw("(select idCausa, GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_VICTIMA=2 THEN pdev.RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(pdev.NOMBRE_VICTIMA,' ',pdev.PRIMER_APELLIDO,' ',pdev.SEGUNDO_APELLIDO_VICTIMAS)END)) as victimas from procp_dg_victimas pcpv left join prode_victimas pdev on pcpv.idVictima =pdev.id WHERE pcpv.deleted_at IS NULL GROUP BY idCausa) as vic"),'vic.idCausa', '=', 'procp_datosgenerales.id')                      
          // ->leftjoin(DB::raw("(select idCausa, GROUP_CONCAT(DISTINCT(CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cde.Valor,' [',cdj.cClaveDelito,'-',cdj.Valor,']') END)) as delitos from procp_dg_delitos pcpd left join prode_hechos pdeh on pcpd.idDelito =pdeh.id left join catdelitosespecificos cde on cde.id=pdeh.DELITO left join catdelitosjur cdj on cdj.id=pdeh.DELITO_JUR WHERE pcpd.deleted_at IS NULL GROUP BY idCausa) as del"),'del.idCausa', '=', 'procp_datosgenerales.id')
          ->leftjoin(DB::raw("(select idCausa, GROUP_CONCAT(DISTINCT(CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cdj.cClaveDelito,'-',cdj.Valor) END)) as delitos from procp_dg_delitos pcpd left join prode_hechos pdeh on pcpd.idDelito =pdeh.id left join catdelitosespecificos cde on cde.id=pdeh.DELITO left join catdelitosjur cdj on cdj.id=pdeh.DELITO_JUR WHERE pcpd.deleted_at IS NULL GROUP BY idCausa) as del"),'del.idCausa', '=', 'procp_datosgenerales.id')
          ->leftjoin('procp_dg_acumuladas as acum', function($join) use($idRegistro){
              $join->on('acum.idCausaRel','=','procp_datosgenerales.id')->where('acum.idCausa', '=',$idRegistro)
              ->whereNull('acum.deleted_at');
            })
          ->leftJoin('procp_audienciainicial as pa','pa.idCausa','=','procp_datosgenerales.id')
          ->select('acum.idCausaRel','pdg.NUC_COMPLETA AS NUC','procp_datosgenerales.CAUSA_PENAL_ID','procp_datosgenerales.id','imp.imputados','vic.victimas','del.delitos',DB::raw("CASE WHEN IFNULL(pa.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),pa.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"))->get()->take(3);
        $data=['causa'=>$causa,];
        return response()->json($data);
      }      
    #endregion
 #endregion

 #region funciones generales
    public function obtenerUnidadUser($unidad)
    {
      $unidades=["1"=>"ATENCION TEMPRANA RAMOS ARIZPE",
      "2"=>"ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE",
      "3"=>"UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE",
      "4"=>"ATENCION TEMPRANA ARTEAGA",
      "5"=>"ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA",
      "6"=>"UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA",
      "7"=>"ATENCION TEMPRANA GENERAL CEPEDA",
      "8"=>"ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA",
      "9"=>"UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA",
      "10"=>"ATENCION TEMPRANA SALTILLO",
      "11"=>"ATENCION TEMPRANA CON DETENIDO SALTILLO",
      "12"=>"ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO",
      "13"=>"ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS",
      "80"=>"UNIDAD I"];
      return isset($unidades[$unidad]) ? $unidades[$unidad] : '-';

    }
    public function BuscarRelacion(Request $request)
    {  
    
      if(is_null(Auth::User())) { return redirect("Salir"); }
      else {
        $idExp=hex2bin($request->idExp);
      $filtro='';
      if ($request->delitoRelB>0) {
        $filtro ='bitde_relaciondelito.idDelito ='.$request->delitoRelB." AND ";
      }
      if ($request->imputadoRelB>0) {
        $filtro =$filtro.'pdr.idImputado ='.$request->imputadoRelB." AND ";
      }
      if ($request->victimaRelB>0) {
        $filtro =$filtro.'pdr.idVictima ='.$request->victimaRelB." AND ";
      }
      $filtro=substr($filtro, 0, -4);            
      $relaciones=datos_expediente\bitde_relaciondelito::leftjoin('prode_relaciondelito as pdr', function($join){
                            $join->on('bitde_relaciondelito.id','=','pdr.idRelacion')
                            ->whereNull('pdr.deleted_at');
                          })
        ->leftjoin('prode_victimas as pdv','pdr.idVictima','=','pdv.id')
        ->leftjoin('prode_imputados as pdi','pdr.idImputado','=','pdi.id')
        ->leftjoin('prode_hechos as pdh','bitde_relaciondelito.idDelito','=','pdh.id')
        ->leftjoin('catdelitosespecificos as cde','pdh.DELITO','=','cde.id')
        ->select('bitde_relaciondelito.id',DB::raw('GROUP_CONCAT(DISTINCT(cde.Valor)) AS delito'),
            DB::raw("GROUP_CONCAT(DISTINCT(CASE WHEN pdv.TIPO_VICTIMA=2 THEN pdv.RAZON_SOCIAL WHEN pdv.TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN pdv.TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdv.TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(pdv.NOMBRE_VICTIMA,' ', pdv.PRIMER_APELLIDO,' ', pdv.SEGUNDO_APELLIDO_VICTIMAS) END)) victimas"),
            DB::raw("GROUP_CONCAT(DISTINCT(CASE WHEN pdi.TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN pdi.TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN pdi.TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdi.TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(pdi.NOMBRE_IMPUTADO,' ', pdi.PRIMER_APELLIDO,' ', pdi.SEGUNDO_APELLIDO_IMPUTADOS) END)) imputados"),
        )->where('bitde_relaciondelito.idExpediente',$idExp)
        ->whereRaw($filtro)->groupby('bitde_relaciondelito.id') ->get();

        return response()->json($relaciones);
      }      
    }    
    private function GetCatalogo($NombreTabla)
    {
        switch($NombreTabla){
            case 'catpaises':
                $catalogo = DB::table($NombreTabla)//->select('id','Valor')
                ->where('Activo',1)->orderBy('Orden')->get();
                break;
            default:
               // $delegacionesDESC=DB::SELECT('select * FROM catdelegaciones ORDER BY id DESC');
                $catalogo = DB::table($NombreTabla)//->select('id','Valor')
                ->where('Activo',1)->orderBy('id')->get();
                //orderByDesc
                break;
        }

        return $catalogo;
    }

    public function GetDataById($catalogo,$idName,$idValue )
    {
        switch ($catalogo) {
            case 'catdelitosgenerales':
            case 'catdelitosespecificos':
                $data = DB::table($catalogo)->where('Activo',1)
                ->where($idName,$idValue)->where('Conduccion',0)
                ->orderBy('Valor')->get();
                //orderByDesc
            break;
            case 'catdelitosespecificosConduccion':
                $data = DB::table('catdelitosespecificos')->where('Activo',1)
                ->where($idName,$idValue)->orderBy('id')->get();
                //orderByDesc
            break;
            case 'catrespuestas':
                if ($idValue==2 || $idValue==3 || $idValue==4)
                {
                    $data = DB::table($catalogo)->where('Activo',1)
                    ->where($idName,$idValue)->orderBy('idCatalogo')->get();
                    //orderByDesc
                }
                else if($idValue==333)
                {
                    $data = DB::table($catalogo)->where('Activo',1)
                    ->where($idName,3)->where('id','>',0)->orderBy('idCatalogo')->get();
                    //orderByDesc
                }
                else if($idValue==130)
                {
                    $data = DB::table($catalogo)->where('Activo',1)
                    ->where($idName,13)->whereNotIn('id',[3, 7, 8])->orderBy('idCatalogo')->get();
                    //orderByDesc
                }                
                else
                {
                    $data = DB::table($catalogo)->where('Activo',1)
                    ->where($idName,$idValue)->orderBy('id')->get();
                    //orderByDesc
                }
            break;
            case 'catdelitosjur':
                $data = DB::table($catalogo)->where('Activo',1)
                ->where($idName,$idValue)->orderBy('cClaveDelito')->get();
            break;
            case 'catmunicipios_inegi':
              if ($idName=='idDelegacion' && $idValue==8) {
                $data = DB::table($catalogo)->where('Activo',1)->where('CVE_ENT',5)
                ->whereIn('id',[40,47,60,63,66])->orderBy('id')->get();
              }
              else if ($idName=='idDelegacion' && $idValue==9) {
                $data = DB::table($catalogo)->where('Activo',1)->where('CVE_ENT',5)
                ->whereIn('id',[45,53,69,71,72])->orderBy('id')->get();
              }
              else
              {
                $data = DB::table($catalogo)->where('Activo',1)
                ->where($idName,$idValue)->orderBy('id')->get();                
              }

            break;
            default:
                $data = DB::table($catalogo)->where('Activo',1)
                ->where($idName,$idValue)->orderBy('id')->get();
                //orderByDesc
            break;
        }

        return $data;
    }

    public function GetMunicipiosByDelegacion(Request $request)
    {

        $municipios = $this->GetDataById('catmunicipios_inegi','idDelegacion',$request->Delegacion);
        $data=['municipios'=>$municipios];
        return response()->json($data);
    }
    public function GetMunicipiosByEntidad(Request $request)
    {
        $municipios = $this->GetDataById('catmunicipios_inegi','CVE_ENT',$request->Entidad);
        $data=['municipios'=>$municipios];
        return response()->json($data);
    }
    public function GetDelitosByOrdenamiento(Request $request)
    {
        $delitosG = $this->GetDataById('catdelitosgenerales','idOrdenamiento',$request->idOrdenamiento);
        $data=['delitosG'=>$delitosG];
        return response()->json($data);
    }
    public function GetDelitosByOrdenamientoJUR(Request $request)
    {
        $delitosJUR = $this->GetDataById('catdelitosjur','idOrdenamientoJUR',$request->idOrdenamiento);
        $data=['delitosJUR'=>$delitosJUR];
        return response()->json($data);
    }
    public function GetDelitosByGeneral(Request $request)
    {
        $delitosE = $this->GetDataById('catdelitosespecificos','idDelitoGeneral',$request->idDelitoG);
        $data=['delitosE'=>$delitosE];
        return response()->json($data);
    }
    public function GetColoniasByMunicipios(Request $request)
    {
        $colonias = $this->GetDataById('catcolonias','idMunicipio',$request->idMun);
        $data=['colonias'=>$colonias];
        return response()->json($data);
    }

    public function eliminarDatosDE(Request $request)
    {
      switch ($request->idT) {
        case 'dev':
          $dr=0;
          $Exp = datos_expediente\de_victimas::where('id',$request->idR)->first();
            $orelDVI=datos_expediente\de_relaciondelito::where('idVictima',$request->idR)->get();
            foreach ($orelDVI as $key => $value) {
              $deleted = datos_expediente\de_relaciondelito::where('id',$value['id'])->delete();
              if ($deleted > 0) {
                $dr=$dr+$deleted;
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $value['id'], 
                  'idEvento' => 72,
                  'Evento' =>'Borrar registro de prode_relaciondelito por víctima']);
              }                
                if (datos_expediente\de_relaciondelito::where('idRelacion',$value['idRelacion'])->count()<1) {
                  $deleted = datos_expediente\bitde_relaciondelito::where('id',$value['idRelacion'])->delete();
                  if ($deleted > 0) {
                    $dr=$dr+$deleted;
                    $bitEvUsu=biteventousario::create(
                      ['idUsuario' => Auth::User()->id,
                      'idExpediente' => $Exp->idExpediente,
                      'idRegistro' => $value['idRelacion'],
                      'idEvento' => 73,
                      'Evento' =>'Borrar registro de bitde_relaciondelito por víctima']);
                  }
                }
              }
          $deleted = datos_expediente\de_victimas::where('id', $request->idR)->delete();
          if ($deleted>0) {
            $dr=$dr+$deleted;
            $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $Exp->idExpediente,
              'idRegistro' => $request->idR,
              'idEvento' => 74,
              'Evento' =>'Borrar víctima de expediente delictivo']);
          }
          $deleted=$dr;
        break;
        case 'dei':
          $dr=0;
          $Exp = datos_expediente\de_imputados::where('id',$request->idR)->first();
            $orelDVI=datos_expediente\de_relaciondelito::where('idImputado',$request->idR)->get();
            foreach ($orelDVI as $key => $value) {
              $deleted = datos_expediente\de_relaciondelito::where('id',$value['id'])->delete();
              if ($deleted > 0) {
                $dr=$dr+$deleted;
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $value['id'],
                  'idEvento' => 75,
                  'Evento' =>'Borrar registro de prode_relaciondelito por imputado']);
              }                
                if (datos_expediente\de_relaciondelito::where('idRelacion',$value['idRelacion'])->count()<1) {
                  $deleted = datos_expediente\bitde_relaciondelito::where('id',$value['idRelacion'])->delete();
                  if ($deleted > 0) {
                    $dr=$dr+$deleted;
                    $bitEvUsu=biteventousario::create(
                      ['idUsuario' => Auth::User()->id,
                      'idExpediente' => $Exp->idExpediente,
                      'idRegistro' => $value['idRelacion'],
                      'idEvento' => 76,
                      'Evento' =>'Borrar registro de bitde_relaciondelito por imputado']);
                  }
                }
              }
          $deleted = datos_expediente\de_imputados::where('id', $request->idR)->delete();
          if ($deleted>0) {
            $dr=$dr+$deleted;
            $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $Exp->idExpediente,
              'idRegistro' => $request->idR,
              'idEvento' => 77,
              'Evento' =>'Borrar imputado de expediente delictivo']);
          }
          $deleted=$dr;
        break;
        case 'ded':
          $dr=0;
          $Exp = datos_expediente\de_hechos::where('id',$request->idR)->first();
            $orelDVI=datos_expediente\bitde_relaciondelito::where('idDelito',$request->idR)->get();
            foreach ($orelDVI as $key => $value) {
              $deleted = datos_expediente\de_relaciondelito::where('idRelacion',$value['id'])->delete();            
              if ($deleted > 0) {
                $dr=$dr+$deleted;
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 78,
                  'Evento' =>'Borrar registro de prode_relaciondelito por delito']);
              }
            }            
              $deleted = datos_expediente\bitde_relaciondelito::where('idDelito',$request->idR)->delete();            
              if ($deleted > 0) {
                $dr=$dr+$deleted;
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 79,
                  'Evento' =>'Borrar registro de bitde_relaciondelito por delito']);
              }
                $deleted = datos_expediente\de_hechos::where('id', $request->idR)->delete();
                if ($deleted>0) {
                  $dr=$dr+$deleted;
                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $Exp->idExpediente,
                    'idRegistro' => $request->idR,
                    'idEvento' => 80,
                    'Evento' =>'Borrar delito de expediente delictivo']);
                }
              
          $deleted=$dr;
        break;
        case 'deo':
          $dr=0;
          $Exp = datos_expediente\de_objetos::where('id',$request->idR)->first();
            $deleted = datos_expediente\de_objetos::where('id',$request->idR)->delete();            
            if ($deleted > 0) {
              $dr=$dr+$deleted;
              $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $Exp->idExpediente,
                'idRegistro' => $request->idR,
                'idEvento' => 81,
                'Evento' =>'Borrar objetos de expediente delictivo']);
            }
          $deleted=$dr;
        break;
        case 'der':
          $dr=0;
          $Exp = datos_expediente\bitde_relaciondelito::where('id',$request->idR)->first();
            $deleted = datos_expediente\de_relaciondelito::where('idRelacion',$request->idR)->delete();            
            if ($deleted > 0) {
              $dr=$dr+$deleted;
              $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $Exp->idExpediente,
                'idRegistro' => $request->idR,
                'idEvento' => 82,
                'Evento' =>'Borrar registro de prode_relaciondelito por relación VID']);
            }
              $deleted = datos_expediente\bitde_relaciondelito::where('id',$request->idR)->delete();            
              if ($deleted > 0) {
                $dr=$dr+$deleted;
                $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 83,
                  'Evento' =>'Borrar relación VID de expediente delictivo']);
              }
            
          $deleted=$dr;
        break;

        case 'ccv':
          $dr=0;
          $Exp = carpeta_conduccion\cc_victimas::where('id',$request->idR)->first();
          $deleted = carpeta_conduccion\cc_victimas::where('id', $request->idR)->delete();
          if ($deleted>0) {
            $dr=$dr+$deleted;
            $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $Exp->idExpediente,
              'idRegistro' => $request->idR,
              'idEvento' => 84,
              'Evento' =>'Borrar víctima de carpeta de conducción']);
          }
          $deleted=$dr;
        break;
        case 'cci':
          $dr=0;
          $Exp = carpeta_conduccion\cc_imputados::where('id',$request->idR)->first();
          $deleted = carpeta_conduccion\cc_imputados::where('id', $request->idR)->delete();
          if ($deleted>0) {
            $dr=$dr+$deleted;
            $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $Exp->idExpediente,
              'idRegistro' => $request->idR,
              'idEvento' => 85,
              'Evento' =>'Borrar imputado de carpeta de conducción']);
          }
          $deleted=$dr;
        break;
        case 'ccd':
          $dr=0;
          $Exp = carpeta_conduccion\cc_hechos::where('id',$request->idR)->first();
          $deleted = carpeta_conduccion\cc_hechos::where('id', $request->idR)->delete();
          if ($deleted>0) {
            $dr=$dr+$deleted;
            $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $Exp->idExpediente,
              'idRegistro' => $request->idR,
              'idEvento' => 86,
              'Evento' =>'Borrar delito de carpeta de conducción']);
          }
          $deleted=$dr;
        break;
        case 'cco':
          $dr=0;
          $Exp = carpeta_conduccion\cc_objetos::where('id',$request->idR)->first();
          $deleted = carpeta_conduccion\cc_objetos::where('id', $request->idR)->delete();
          if ($deleted>0) {
            $dr=$dr+$deleted;
            $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $Exp->idExpediente,
              'idRegistro' => $request->idR,
              'idEvento' => 87,
              'Evento' =>'Borrar objeto de carpeta de conducción']);
          }
          $deleted=$dr;
        break;
      
        case 'ndv':
          $dr=0;
          $Exp = no_delictivos\nd_victimas::where('id',$request->idR)->first();
          $deleted = no_delictivos\nd_victimas::where('id', $request->idR)->delete();
          if ($deleted>0) {
            $dr=$dr+$deleted;
            $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $Exp->idExpediente,
              'idRegistro' => $request->idR,
              'idEvento' => 88,
              'Evento' =>'Borrar víctima de no delictivo']);
          }
          $deleted=$dr;
        break;
        case 'ndo':
          $dr=0;
            $Exp = no_delictivos\nd_objetos::where('id',$request->idR)->first();
            $deleted = no_delictivos\nd_objetos::where('id', $request->idR)->delete();
            if ($deleted>0) {
              $dr=$dr+$deleted;
              $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $Exp->idExpediente,
                'idRegistro' => $request->idR,
                'idEvento' => 89,
                'Evento' =>'Borrar objeto de no delictivo']);
            }
            $deleted=$dr;
        break;


          case 'deevac': ///prode_ev_actos 
            
            $Exp = datos_expediente\de_ev_actos::where('id',$request->idR)->first();

            $deleted = datos_expediente\de_ev_actos::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 146,
                  'Evento' =>'Borrar registro de prode_ev_actos']);
            }
          break;
          case 'deevmn': ///prode_ev_mandamientos
            
            $Exp = datos_expediente\de_ev_mandamientos::where('id',$request->idR)->first();

            $deleted = datos_expediente\de_ev_mandamientos::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 147,
                  'Evento' =>'Borrar registro de prode_ev_mandamientos']);
            }
          break;
          case 'deevmd': ///prode_ev_medidas 
            
            $Exp = datos_expediente\de_ev_medidas::where('id',$request->idR)->first();

            $deleted = datos_expediente\de_ev_medidas::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 148,
                  'Evento' =>'Borrar registro de prode_ev_medidas']);
            }
          break;


      }
      $data=[$deleted];
      return response()->json($data); 
    }
    public function eliminarDatosCP(Request $request)
    {
        switch ($request->idT) {
          case 'cp':
            $rowsD=0; 
            $Exp = causas_penales\cp_datosgenerales::where('id',$request->idR)->first();   
            $opruebas= causas_penales\cp_juiciooral::where('idCausa',$request->idR)->get();
            foreach ($opruebas as $key => $value) {
              $borrar_jo_pb = causas_penales\cp_jo_pruebas::where('id_cp_juiciooral', $value['id'])->delete();
              $rowsD=$rowsD+$borrar_jo_pb; 
              $borrar_jo_su = causas_penales\cp_jo_suspension::where('id_cp_juiciooral', $value['id'])->delete();
              $rowsD=$rowsD+$borrar_jo_su; 

            }
            $borrar_jo = causas_penales\cp_juiciooral::where('idCausa',$request->idR)->delete();
            $borrar_jo = causas_penales\cp_jo_imputados::where('idCausa',$request->idR)->delete();
            $rowsD=$rowsD+$borrar_jo; 

            $orecursos= causas_penales\cp_recursos::where('idCausa',$request->idR)->get();
            foreach ($orecursos as $key => $value) {
              $borrar_jo_re = causas_penales\cp_re_recursos::where('id_cp_recursos', $value['id'])->delete();
              $rowsD=$rowsD+$borrar_jo_re; 
            }
            $borrar_jo = causas_penales\cp_recursos::where('idCausa',$request->idR)->delete();

            $odg_imp= causas_penales\cp_dg_imputados::where('idCausa',$request->idR)->get();
            foreach ($odg_imp as $key => $value) {
              $borrar_dg_relimp = causas_penales\cp_dg_relacionimputado::where('idcp_dg_imputados', $value['id'])->delete();
              $rowsD=$rowsD+$borrar_dg_relimp;
            }
            $borrar_dg_imp = causas_penales\cp_dg_imputados::where('idCausa', $request->idR)->delete(); 
            $rowsD=$rowsD+$borrar_dg_imp;
            $borrar_dg = causas_penales\cp_datosgenerales::where('id', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_dg;
            $borrar_dg_acum = causas_penales\cp_dg_acumuladas::where('idCausa', $request->idR)->orWhere('idCausaRel', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_dg_acum;
            $borrar_dg_del = causas_penales\cp_dg_delitos::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_dg_del;
            $borrar_dg_vic = causas_penales\cp_dg_victimas::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_dg_vic;

            $borrar_en = causas_penales\cp_etapainvestigacion::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_en;
            $borrar_en_i = causas_penales\cp_ev_imputados::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_en_i;
            $borrar_en_cs = causas_penales\cp_ev_actosconsin::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_en_cs;            
            $borrar_en_a = causas_penales\cp_ev_actos::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_en_a;
            $borrar_en_v = causas_penales\cp_ev_victimas::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_en_v;
            $borrar_en_m = causas_penales\cp_ev_medidas::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_en_m;

            $borrar_ai = causas_penales\cp_audienciainicial::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_ai;
            $oMedidas = causas_penales\cp_ai_imputados::where('idCausa', $request->idR)->get();
            // foreach ($oMedidas as $key => $value) {
            //   $borrar_ai_me = causas_penales\cp_ai_medidas::where('id_cp_ai_imputados', $value['id'])->delete();
            //   $rowsD=$rowsD+$borrar_ai_me;               
            // }
            $borrar_ai_imp = causas_penales\cp_ai_imputados::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_ai_imp;
            
            $oMedidasMC = causas_penales\cp_medidascautelares::where('idCausa', $request->idR)->get();
            foreach ($oMedidasMC as $key => $value) {
              $borrar_mc_me = causas_penales\cp_mc_medidas::where('id_cp_medidascautelares', $value['id'])->delete();
              $rowsD=$rowsD+$borrar_mc_me;               
            }
            $borrar_medc = causas_penales\cp_medidascautelares::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_medc;

            $oMedidasSA = causas_penales\cp_salidasalternas::where('idCausa', $request->idR)->get();
            foreach ($oMedidasSA as $key => $value) {
              $borrar_sa_ac = causas_penales\cp_sa_acuerdos::where('id_cp_salidasalternas', $value['id'])->delete();
              $rowsD=$rowsD+$borrar_sa_ac;               
              $borrar_sa_su = causas_penales\cp_sa_suspensiones::where('id_cp_salidasalternas', $value['id'])->delete();
              $rowsD=$rowsD+$borrar_sa_su;
            }
            $borrar_sa = causas_penales\cp_salidasalternas::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_sa;            

            $borrar_pa = causas_penales\cp_procedimientoabreviado::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_pa;
            $borrar_pa = causas_penales\cp_suspensionsobreseimiento::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_pa;
            $borrar_pa = causas_penales\cp_ss_imputados::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_pa;            
            

            $borrar_ei = causas_penales\cp_etapaintermedia::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_ei;
            $borrar_ei_me = causas_penales\cp_ei_medios::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_ei_me;
            
            $borrar_ei_im = causas_penales\cp_ei_imputados::where('idCausa', $request->idR)->delete();
            $rowsD=$rowsD+$borrar_ei_im;
            if ($rowsD>0) {
              $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $Exp->idExpediente,
                'idRegistro' => $request->idR,
                'idEvento' => 90,
                'Evento' =>'Borrar datos de Causa Penal']);
            }
            $deleted=$rowsD;                        
          break;
          case 'cpdgac': ///procp_dg_acumuladas
            $Exp = causas_penales\cp_datosgenerales::where('id',$request->idR)->first();
            $deleted = causas_penales\cp_dg_acumuladas::where('idCausa', $request->idR)->orWhere('idCausaRel', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 25,
                  'Evento' =>'Borrar registro de procp_dg_acumuladas']);
            }
          break;          
          case 'cpdgdl': ///procp_dg_delitos
            $rowsD=0;            
            $Rdelito = causas_penales\cp_dg_delitos::where('id', $request->idR);
            $Rdelito2 = $Rdelito->first();
            $Exp = causas_penales\cp_datosgenerales::where('id',$Rdelito2->idCausa)->first();

            $Rimp = causas_penales\cp_dg_relacionimputado::
            leftjoin('procp_dg_imputados as pi','procp_dg_relacionimputado.idcp_dg_imputados','=','pi.id')
            ->where('idCausa', $Rdelito2->idCausa)->where('idDelito',$Rdelito2->idDelito)
            ->select('procp_dg_relacionimputado.id as idrel','pi.id as idImp')->get();
            
            foreach ($Rimp as $key => $value) {
              $deleted = causas_penales\cp_dg_relacionimputado::where('id',$value['idrel'])->delete();
              $rowsD+=$deleted;
              if ($deleted>0) {
                $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $Exp->idExpediente,
                'idRegistro' => $value['idrel'],
                'idEvento' => 26,
                'Evento' =>'Borrar registro de procp_dg_relacionimputado por delito']);
              }              
              if (causas_penales\cp_dg_relacionimputado::where('idcp_dg_imputados',$value['idImp'])->count()<1) {                              
                $deleted = causas_penales\cp_dg_imputados::where('id',$value['idImp'])->delete();              
                $rowsD+=$deleted;
                if ($deleted>0) {
                  $borrar_en=causas_penales\cp_ev_imputados::where('idImputado',$value['idImp'])->delete();
                  $borrar_en=causas_penales\cp_ev_actosconsin::where('idImputado',$value['idImp'])->delete();
                  $borrar_pa=causas_penales\cp_procedimientoabreviado::where('idImputado',$value['idImp'])->delete();
                  $borrar_pa=causas_penales\cp_ss_imputados::where('idImputado',$value['idImp'])->delete();
                  
                  // $borrar_jo=causas_penales\cp_juiciooral::where('idImputado',$value['idImp']);
                  // $idcp_juiciooral=$borrar_jo->first();
                  // $borrar_jo_pb=causas_penales\cp_jo_pruebas::where('id_cp_juiciooral',$idcp_juiciooral->id??0)->delete();
                  // $borrar_jo_su=causas_penales\cp_jo_suspension::where('id_cp_juiciooral',$idcp_juiciooral->id??0)->delete();
                  $borrar_jo_su=causas_penales\cp_jo_imputados::where('idImputado',$value['idImp'])->delete();
                  //$borrar_jo->delete();

                  $borrar_re=causas_penales\cp_recursos::where('idImputado',$value['idImp']);
                  $id_cp_recursos=$borrar_re->first();
                  $borrar_re_re=causas_penales\cp_re_recursos::where('id_cp_recursos',$id_cp_recursos->id??0)->delete();
                  $borrar_re->delete();

                  $borrar_ei_im=causas_penales\cp_ei_imputados::where('idImputado',$value['idImp'])->delete();                  
                  $borrar_ai_im=causas_penales\cp_ai_imputados::where('idImputado',$value['idImp']);
                  $idcp_ai_im=$borrar_ai_im->first();
                  //$borrar_ai_im_me=causas_penales\cp_ai_medidas::where('id_cp_ai_imputados',$idcp_ai_im->id??0)->delete();
                  $borrar_ai_im->delete();

                  $borrar_medc=causas_penales\cp_medidascautelares::where('idImputado',$value['idImp']);
                  $idcp_medc=$borrar_medc->first();
                  $borrar_mc_me=causas_penales\cp_mc_medidas::where('id_cp_medidascautelares',$idcp_medc->id??0)->delete();
                  $borrar_medc->delete();

                  $borrar_sa=causas_penales\cp_salidasalternas::where('idImputado',$value['idImp']);
                  $idcp_sa=$borrar_sa->first();
                  //$borrar_sa_mc=causas_penales\cp_mc_medidas::where('id_cp_salidasalternas',$idcp_sa->id??0)->delete();
                  $borrar_sa_ar=causas_penales\cp_sa_acuerdos::where('id_cp_salidasalternas',$idcp_sa->id??0)->delete();
                  $borrar_sa->delete();

                  $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $Exp->idExpediente,
                    'idRegistro' => $value['idImp'],
                    'idEvento' => 27,
                    'Evento' =>'Borrar registro de procp_dg_imputados por delito']);
                }
              }
            }                        
            $deleted = $Rdelito->delete();
            $rowsD+=$deleted;
            if ($deleted>0) {
              $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $Exp->idExpediente,
              'idRegistro' => $request->idR,
              'idEvento' => 28,
              'Evento' =>'Borrar registro de procp_dg_delitos']);
            }            
            $deleted=$rowsD;
          break;          
          case 'cpdgvc': ///procp_dg_victimas
            $rowsD=0;            
            $Rvictima = causas_penales\cp_dg_victimas::where('id', $request->idR);
            $Rvictima2 = $Rvictima->first();
            $Exp = causas_penales\cp_datosgenerales::where('id',$Rvictima2->idCausa)->first();

            $Rimp = causas_penales\cp_dg_relacionimputado::
            leftjoin('procp_dg_imputados as pi','procp_dg_relacionimputado.idcp_dg_imputados','=','pi.id')
            ->where('idCausa', $Rvictima2->idCausa)->where('idVictima',$Rvictima2->idVictima)
            ->select('procp_dg_relacionimputado.id as idrel','pi.id as idImp')->get();
            
            foreach ($Rimp as $key => $value) {
              $deleted = causas_penales\cp_dg_relacionimputado::where('id',$value['idrel'])->delete();
              $rowsD+=$deleted;
              if ($deleted>0) {
                $bitEvUsu=biteventousario::create(
                ['idUsuario' => Auth::User()->id,
                'idExpediente' => $Exp->idExpediente,
                'idRegistro' => $value['idrel'],
                'idEvento' => 29,
                'Evento' =>'Borrar registro de procp_dg_relacionimputado por víctima']);
              }
              if (causas_penales\cp_dg_relacionimputado::where('idcp_dg_imputados',$value['idImp'])->count()<1) {

                $deleted = causas_penales\cp_dg_imputados::where('id',$value['idImp'])->delete();   
                $rowsD+=$deleted;
                if ($deleted>0) {
                 $borrar_en=causas_penales\cp_ev_imputados::where('idImputado',$value['idImp'])->delete();
                 $borrar_en=causas_penales\cp_ev_actosconsin::where('idImputado',$value['idImp'])->delete();
                 $borrar_pa=causas_penales\cp_procedimientoabreviado::where('idImputado',$value['idImp'])->delete();
                 $borrar_pa=causas_penales\cp_ss_imputados::where('idImputado',$value['idImp'])->delete();
                 // $borrar_jo=causas_penales\cp_juiciooral::where('idImputado',$value['idImp']);
                 // $idcp_juiciooral=$borrar_jo->first();
                 // $borrar_jo_pb=causas_penales\cp_jo_pruebas::where('id_cp_juiciooral',$idcp_juiciooral->id??0)->delete();
                 // $borrar_jo->delete();
                 // $borrar_jo_pb=causas_penales\cp_jo_suspension::where('id_cp_juiciooral',$idcp_juiciooral->id??0)->delete();
                 // $borrar_jo->delete();
                 $borrar_jo_im=causas_penales\cp_jo_imputados::where('idImputado',$value['idImp'])->delete();
                 //$borrar_jo_im->delete();

                 $borrar_re=causas_penales\cp_recursos::where('idImputado',$value['idImp']);
                 $id_cp_recursos=$borrar_re->first();
                 $borrar_re_re=causas_penales\cp_re_recursos::where('id_cp_recursos',$id_cp_recursos->id??0)->delete();
                 $borrar_re->delete();

                 $borrar_ei_im=causas_penales\cp_ei_imputados::where('idImputado',$value['idImp'])->delete();
                 $borrar_ai_im=causas_penales\cp_ai_imputados::where('idImputado',$value['idImp']);
                 $idcp_ai_im=$borrar_ai_im->first();
                 //$borrar_ai_im_me=causas_penales\cp_ai_medidas::where('id_cp_ai_imputados',$idcp_ai_im->id??0)->delete();
                 $borrar_ai_im->delete();  

                 $borrar_medc=causas_penales\cp_medidascautelares::where('idImputado',$value['idImp']);
                 $idcp_medc=$borrar_medc->first();
                 $borrar_mc_me=causas_penales\cp_mc_medidas::where('id_cp_medidascautelares',$idcp_medc->id??0)->delete();
                 $borrar_medc->delete();                    

                  $borrar_sa=causas_penales\cp_salidasalternas::where('idImputado',$value['idImp']);
                  $idcp_sa=$borrar_sa->first();
                  //$borrar_sa_mc=causas_penales\cp_mc_medidas::where('id_cp_salidasalternas',$idcp_sa->id??0)->delete();
                  $borrar_sa_ar=causas_penales\cp_sa_acuerdos::where('id_cp_salidasalternas',$idcp_sa->id??0)->delete();
                  $borrar_sa->delete();

                 $bitEvUsu=biteventousario::create(
                    ['idUsuario' => Auth::User()->id,
                    'idExpediente' => $Exp->idExpediente,
                    'idRegistro' => $value['idImp'],
                    'idEvento' => 30,
                    'Evento' =>'Borrar registro de procp_dg_imputados por víctima']);
                }
              }
            }
            $Dcp_ev_medidas  = causas_penales\cp_ev_medidas::where('idVictima', $request->idR)->delete();
            $Dcp_ev_victimas = causas_penales\cp_ev_victimas::where('idVictima', $request->idR)->delete();
            $deleted = $Rvictima->delete();
            $rowsD+=$deleted;
            if ($deleted>0) {
              $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $Exp->idExpediente,
              'idRegistro' => $request->idR,
              'idEvento' => 31,
              'Evento' =>'Borrar registro de procp_dg_victimas']);
            }            
            $deleted=$rowsD;
          break;          
          case 'cpdgim': ///procp_dg_imputados
            $imp =causas_penales\cp_dg_imputados::where('id', $request->idR);
            $imp2=$imp->first();            
            $Exp = causas_penales\cp_datosgenerales::where('id',$imp2->idCausa)->first();
            $deleted = $imp->delete();
            $borrar_en=causas_penales\cp_ev_imputados::where('idImputado',$request->idR)->delete();
            $borrar_en=causas_penales\cp_ev_actosconsin::where('idImputado',$request->idR)->delete();            
            $borrar_pa=causas_penales\cp_procedimientoabreviado::where('idImputado',$request->idR)->delete();
            $borrar_pa=causas_penales\cp_ss_imputados::where('idImputado',$request->idR)->delete();
            
            // $borrar_jo=causas_penales\cp_juiciooral::where('idImputado',$request->idR);
            // $idcp_juiciooral=$borrar_jo->first();
            // $borrar_jo_pb=causas_penales\cp_jo_pruebas::where('id_cp_juiciooral',$idcp_juiciooral->id??0)->delete();
            // $borrar_jo->delete();   
            // $borrar_jo_pb=causas_penales\cp_jo_suspension::where('id_cp_juiciooral',$idcp_juiciooral->id??0)->delete();
            // $borrar_jo->delete();
            $borrar_jo=causas_penales\cp_jo_imputados::where('idImputado',$request->idR)->delete();

            $borrar_re=causas_penales\cp_recursos::where('idImputado',$request->idR);
            $id_cp_recursos=$borrar_re->first();
            $borrar_re_re=causas_penales\cp_re_recursos::where('id_cp_recursos',$id_cp_recursos->id??0)->delete();
            $borrar_re->delete();

            $borrar_ei_im=causas_penales\cp_ei_imputados::where('idImputado',$request->idR)->delete();
            $borrar_ai_im=causas_penales\cp_ai_imputados::where('idImputado',$request->idR);
            $idcp_ai_im=$borrar_ai_im->first();
            //$borrar_ai_im_me=causas_penales\cp_ai_medidas::where('id_cp_ai_imputados',$idcp_ai_im->id??0)->delete();
            $borrar_ai_im->delete();    

            $borrar_medc=causas_penales\cp_medidascautelares::where('idImputado',$request->idR);
            $idcp_medc=$borrar_medc->first();
            $borrar_mc_me=causas_penales\cp_mc_medidas::where('id_cp_medidascautelares',$idcp_medc->id??0)->delete();
            $borrar_medc->delete(); 

                  $borrar_sa=causas_penales\cp_salidasalternas::where('idImputado',$request->idR);
                  $idcp_sa=$borrar_sa->first();
                  //$borrar_sa_mc=causas_penales\cp_mc_medidas::where('id_cp_medidascautelares',$idcp_sa->id??0)->delete();
                  $borrar_sa_ar=causas_penales\cp_sa_acuerdos::where('id_cp_salidasalternas',$idcp_sa->id??0)->delete();
                  $borrar_sa->delete();            
            if ($deleted>0) {
              $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $Exp->idExpediente,
              'idRegistro' => $request->idR,
              'idEvento' => 32,
              'Evento' =>'Borrar registro de procp_dg_imputados']);
            } 
            $deleted = causas_penales\cp_dg_relacionimputado::where('idcp_dg_imputados', $request->idR)->delete();
            if ($deleted>0) {
              $bitEvUsu=biteventousario::create(
              ['idUsuario' => Auth::User()->id,
              'idExpediente' => $Exp->idExpediente,
              'idRegistro' => $request->idR,
              'idEvento' => 33,
              'Evento' =>'Borrar registro de procp_dg_relacionimputado por imputado']);
            } 
          break;   
          case 'cpjopb': ///procp_jo_pruebas
            
            $Exp = causas_penales\cp_jo_pruebas::leftjoin('procp_juiciooral as jo', 'procp_jo_pruebas.id_cp_juiciooral','=','jo.id')
            ->where('procp_jo_pruebas.id',$request->idR)->first();

            $deleted = causas_penales\cp_jo_pruebas::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 49,
                  'Evento' =>'Borrar registro de procp_jo_pruebas']);
            }
          break;
          case 'cpjore': ///procp_re_recursos
            
            $Exp = causas_penales\cp_re_recursos::leftjoin('procp_recursos as jo', 'procp_re_recursos.id_cp_recursos','=','jo.id')
            ->where('procp_re_recursos.id',$request->idR)->first();

            $deleted = causas_penales\cp_re_recursos::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 93,
                  'Evento' =>'Borrar registro de procp_re_recursos']);
            }
          break;
          case 'cpjosu': ///procp_jo_suspension
            
            $Exp = causas_penales\cp_jo_suspension::leftjoin('procp_juiciooral as jo', 'procp_jo_suspension.id_cp_juiciooral','=','jo.id')
            ->where('procp_jo_suspension.id',$request->idR)->first();

            $deleted = causas_penales\cp_jo_suspension::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 94,
                  'Evento' =>'Borrar registro de procp_jo_suspension']);
            }
          break;
          // case 'cpaime': ///procp_ai_medidas
            
          //   $Exp = causas_penales\cp_ai_medidas::leftjoin('procp_ai_imputados as pai', 'procp_ai_medidas.id_cp_ai_imputados','=','pai.id')
          //   ->where('procp_ai_medidas.id',$request->idR)->first();

          //   $deleted = causas_penales\cp_ai_medidas::where('id', $request->idR)->delete();            
          //   if ($deleted>0) {
          //      $bitEvUsu=biteventousario::create(
          //         ['idUsuario' => Auth::User()->id,
          //         'idExpediente' => $Exp->idExpediente,
          //         'idRegistro' => $request->idR,
          //         'idEvento' => 96,
          //         'Evento' =>'Borrar registro de procp_ai_medidas']);
          //   }
          // break;
          case 'cpmcme': ///procp_mc_medidas
            
            $Exp = causas_penales\cp_mc_medidas::leftjoin('procp_medidascautelares  as pai',
             'procp_mc_medidas.id_cp_medidascautelares','=','pai.id')
            ->where('procp_mc_medidas.id',$request->idR)->first();

            $deleted = causas_penales\cp_mc_medidas::where('id', $request->idR)->delete();            
            if ($deleted>0) {

               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 113,
                  'Evento' =>'Borrar registro de procp_mc_medidas']);
              $total_anios=0;
              $prision=causas_penales\cp_mc_medidas::where('id_cp_medidascautelares',$Exp->id_cp_medidascautelares??0)
              ->whereIn('TIPO_MEDIDAS_CAUTELARES',[14,15,16])
              ->select(DB::raw("FLOOR(IFNULL((SUM(TEMPORALIDAD_MEDIDA_D)/365.25)+(SUM(TEMPORALIDAD_MEDIDA_M)/12)+SUM(TEMPORALIDAD_MEDIDA_A),0)) as tiempo"))
              ->first();
              if ($prision) {
                  $total_anios = $prision->tiempo;
                  // $tiempo contiene el resultado de la consulta
                  // Puedes usar $tiempo como necesites
              }
               $total_anios=floor($total_anios);
               $tiempo=causas_penales\cp_jo_imputados::where('idImputado',$Exp->idImputado??0)
               ->update(['TIEMPO'=>$total_anios]); 
            }
          break;
          case 'cpevac': ///procp_ev_actos 
            
            $Exp = causas_penales\cp_ev_actos::where('id',$request->idR)->first();

            $deleted = causas_penales\cp_ev_actos::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 102,
                  'Evento' =>'Borrar registro de procp_ev_actos']);
            }
          break;
          case 'cpevmd': ///procp_ev_medidas 
            
            $Exp = causas_penales\cp_ev_medidas::where('id',$request->idR)->first();

            $deleted = causas_penales\cp_ev_medidas::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 103,
                  'Evento' =>'Borrar registro de procp_ev_medidas']);
            }
          break;  
          case 'cpevaccon': ///procp_ev_actosconsin            
            $Exp = causas_penales\cp_ev_actosconsin::where('id',$request->idR)->where('CONSIN','=','con')->first();

            $deleted = causas_penales\cp_ev_actosconsin::where('id', $request->idR)->where('CONSIN','=','con')->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 104,
                  'Evento' =>'Borrar registro de procp_ev_actosconsin (CON)']);
            }
          break;
          case 'cpevacsin': ///procp_ev_actosconsin            
            $Exp = causas_penales\cp_ev_actosconsin::where('id',$request->idR)->where('CONSIN','=','sin')->first();

            $deleted = causas_penales\cp_ev_actosconsin::where('id', $request->idR)->where('CONSIN','=','sin')->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 105,
                  'Evento' =>'Borrar registro de procp_ev_actosconsin (SIN)']);
            }
          break;  
          case 'cpaipr': ///procp_ai_prorrogas
            $Exp = causas_penales\cp_ai_prorrogas::where('id',$request->idR)->first();

            $deleted = causas_penales\cp_ai_prorrogas::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 109,
                  'Evento' =>'Borrar registro de procp_ai_prorrogas']);
            }
          break;
          case 'cpaica': ///bitcp_ai_celebracion
            $Exp = causas_penales\cp_ai_celebracion::where('id',$request->idR)->first();

            $deleted = causas_penales\cp_ai_celebracion::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 128,
                  'Evento' =>'Borrar registro de bitcp_ai_celebracion']);
            }
          break;          
          case 'cpsaac': ///procp_sa_acuerdos 
            
            $Exp = causas_penales\cp_sa_acuerdos::leftjoin('procp_salidasalternas as pai',
             'procp_sa_acuerdos.id_cp_salidasalternas','=','pai.id')
            ->where('procp_sa_acuerdos.id',$request->idR)->first();

            $deleted = causas_penales\cp_sa_acuerdos::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 118,
                  'Evento' =>'Borrar registro de procp_sa_acuerdos']);
            }
          break;
          case 'cpsasc': ///procp_sa_suspensiones 
            
            $Exp = causas_penales\cp_sa_suspensiones::leftjoin('procp_salidasalternas as pai',
             'procp_sa_suspensiones.id_cp_salidasalternas','=','pai.id')
            ->where('procp_sa_suspensiones.id',$request->idR)->first();

            $deleted = causas_penales\cp_sa_suspensiones::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 119,
                  'Evento' =>'Borrar registro de procp_sa_suspensiones']);
            }
          break;
          case 'cpeime': ///procp_ei_medios 
            
            $Exp = causas_penales\cp_ei_medios::where('id',$request->idR)->first();

            $deleted = causas_penales\cp_ei_medios::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 123,
                  'Evento' =>'Borrar registro de procp_ei_medios']);
            }
          break;          
          case 'cpevmn': ///procp_ev_mandamientos
            
            $Exp = causas_penales\cp_ev_mandamientos::where('id',$request->idR)->first();

            $deleted = causas_penales\cp_ev_mandamientos::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 130,
                  'Evento' =>'Borrar registro de procp_ev_mandamientos']);
            }
          break;

          case 'deevac': ///prode_ev_actos 
            
            $Exp = datos_expediente\de_ev_actos::where('id',$request->idR)->first();

            $deleted = datos_expediente\de_ev_actos::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 146,
                  'Evento' =>'Borrar registro de prode_ev_actos']);
            }
          break;
          case 'deevmn': ///prode_ev_mandamientos
            
            $Exp = datos_expediente\de_ev_mandamientos::where('id',$request->idR)->first();

            $deleted = datos_expediente\de_ev_mandamientos::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 147,
                  'Evento' =>'Borrar registro de prode_ev_mandamientos']);
            }
          break;
          case 'deevmd': ///procp_ev_medidas 
            
            $Exp = datos_expediente\de_ev_medidas::where('id',$request->idR)->first();

            $deleted = datos_expediente\de_ev_medidas::where('id', $request->idR)->delete();            
            if ($deleted>0) {
               $bitEvUsu=biteventousario::create(
                  ['idUsuario' => Auth::User()->id,
                  'idExpediente' => $Exp->idExpediente,
                  'idRegistro' => $request->idR,
                  'idEvento' => 148,
                  'Evento' =>'Borrar registro de prode_ev_medidas']);
            }
          break;
        }

        $data=[$deleted];
        return response()->json($data); 
    }
 #endregion

}
