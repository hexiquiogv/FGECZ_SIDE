<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

use App\Models\biteventousario;
use App\Models\relusuarioexpedientes;
use App\Models\bitCorreccionesValidaciones;
use App\Models\bitbasecaptura;

use App\Models\datos_expediente;
use App\Models\causas_penales;
use App\Models\no_delictivos;

use App\Models\carpeta_conduccion;

class InicioController extends Controller
{
  #region Listado   
    function listadoExpedientes(Request $request) {

        if(is_null(Auth::User())) { return redirect("Salir"); }
      else
      {     
        DB::statement("SET SQL_MODE=''");
        #region Obtener listado de expedientes por usuario
          $expedientes=[]; $expedientesCC=[]; $expedientesND=[]; $tipo='';
          $expedientes=DB::table('relusuarioexpedientes as rUE')
           ->join('prode_datosgenerales as pdg','rUE.idExpediente', '=', 'pdg.idExpediente')
           ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CAUSA_PENAL_ID)) causas, idExpediente FROM procp_datosgenerales WHERE deleted_at IS NULL GROUP BY idExpediente) as pcp"),'pcp.idExpediente', '=', 'pdg.idExpediente')
           ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_IMPUTADO=2 THEN RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(NOMBRE_IMPUTADO,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS) END)) imputados, idExpediente FROM prode_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'pdg.idExpediente')
           ->leftjoin(DB::raw("(select GROUP_CONCAT(Valor) as delitos ,idExpediente FROM prode_hechos pdh left join catdelitosespecificos cde on pdh.DELITO=cde.id WHERE deleted_at IS NULL GROUP BY idExpediente) as pdhg"),'pdhg.idExpediente', '=', 'pdg.idExpediente')
           ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_VICTIMA=2 THEN RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(NOMBRE_VICTIMA,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS) END)) victimas, idExpediente FROM prode_victimas WHERE deleted_at IS NULL GROUP by idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'pdg.idExpediente')
           
           ->select('pdg.id as idExpediente','pdg.NUC','pdg.NUC_COMPLETA','pdg.FECHA_INICIO_CARPETA',
            DB::raw('IFNULL(pcp.causas,"-") as causas'),'pdg.NO_EXPEDIENTE',
            DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),'pdg.created_at','pdg.FECHA_HECHOS',
            DB::raw('IFNULL(pdig.imputados,"-") as imputados'),DB::raw('IFNULL(pdvg.victimas,"-") as victimas'),
            DB::raw("'e3' as carpeta"))
           ->where('rUE.Activo',1)->where('tabla','prode_datosgenerales')
           ->where('rUE.idUsuario',Auth::User()->id)->groupby('idExpediente')
           ->OrderByDesc('idExpediente')->paginate(10)->setPageName('page');

          $expedientesCC=DB::table('relusuarioexpedientes as rUE')
           ->join('procc_datosgenerales as pdg','rUE.idExpediente', '=', 'pdg.idExpediente')           
           ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_IMPUTADO_CONDUCCION=2 THEN RAZON_SOCIAL WHEN TIPO_IMPUTADO_CONDUCCION=3 THEN 'LA SOCIEDAD' WHEN TIPO_IMPUTADO_CONDUCCION=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_IMPUTADO_CONDUCCION=7 THEN 'LA SALUD' ELSE CONCAT(NOMBRE_IMPUTADO,' ',PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS_CONDUCCION) END)) imputados, idExpediente FROM procc_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'pdg.idExpediente')
           ->leftjoin(DB::raw("(select GROUP_CONCAT(Valor) as delitos ,idExpediente FROM procc_hechos pdh left join catdelitosespecificos cde on pdh.DELITO=cde.id WHERE deleted_at IS NULL GROUP BY idExpediente) as pdhg"),'pdhg.idExpediente', '=', 'pdg.idExpediente')
           ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_VICTIMA_CONDUCCION=2 THEN RAZON_SOCIAL WHEN TIPO_VICTIMA_CONDUCCION=3 THEN 'LA SOCIEDAD' WHEN TIPO_VICTIMA_CONDUCCION=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_VICTIMA_CONDUCCION=7 THEN 'LA SALUD' ELSE CONCAT(NOMBRE_VICTIMA,' ',PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS_CONDUCCION) END)) victimas, idExpediente FROM procc_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'pdg.idExpediente')
           ->select('pdg.id as idExpediente','pdg.NO_EXPEDIENTE_CONDUCCION as NO_EXPEDIENTE',
            'pdg.FECHA_INICIO_CONDUCCION as FECHA_INICIO_CARPETA',
            'pdg.created_at','pdg.FECHA_HECHOS_CONDUCCION as FECHA_HECHOS',
              DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),
              DB::raw('IFNULL(pdig.imputados,"-") as imputados'),
              DB::raw('IFNULL(pdvg.victimas,"-") as victimas'),
              DB::raw("'d9' as carpeta"))
           ->where('rUE.Activo',1)->where('tabla','procc_datosgenerales')
           ->where('rUE.idUsuario',Auth::User()->id)->groupby('idExpediente')
           ->OrderByDesc('idExpediente')->paginate(10)->setPageName('CC');

          $expedientesND=DB::table('relusuarioexpedientes as rUE')
           ->join('prond_datosgenerales as pdg','rUE.idExpediente', '=', 'pdg.idExpediente')
           // ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS))) imputados, idExpediente FROM prond_imputados GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'pdg.idExpediente')
           ->leftJoin('catrespuestas as cr1', function($join)
           {
              $join->on('pdg.HECHO_NO_DELITO','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',70);
           })           
           ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_VICTIMA,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS_NO_DELICTIVO))) victimas, idExpediente FROM prond_victimas WHERE deleted_at IS NULL GROUP by idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'pdg.idExpediente')
           ->select('pdg.id as idExpediente','pdg.NO_EXPEDIENTE','pdg.FECHA_INICIO as FECHA_INICIO_CARPETA',
            // DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),DB::raw('IFNULL(pdig.imputados,"-") as imputados'),
            'pdg.created_at','pdg.FECHA_HECHOS_NO_DELICTIVOS as FECHA_HECHOS',
            DB::raw("cr1.Valor as delitos"),DB::raw("'' as imputados"),
            DB::raw('IFNULL(pdvg.victimas,"-") as victimas'), DB::raw("'he' as carpeta"))
           ->where('rUE.Activo',1)->where('tabla','prond_datosgenerales')
           ->where('rUE.idUsuario',Auth::User()->id)->groupby('idExpediente')
           ->OrderByDesc('idExpediente')->paginate(10)->setPageName('ND');
          #region Validación y Corrección
            $ExpV=[];$SupExpP=[];$ExpC=[];$arrAlert=[];
            $prode_ = bitCorreccionesValidaciones::join('prode_datosgenerales as pde', function($join)
              {
                  $join->on('pde.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                  ->Where('bitcorreccionesvalidaciones.tabla','=','prode_datosgenerales');
              })
              ->join('relusuarioexpedientes as rux', function($join)
              {
                  $join->on('rux.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                  ->on('bitcorreccionesvalidaciones.tabla','=','rux.tabla');
              })
              ->select('NUC_COMPLETA as NUC','NO_EXPEDIENTE',DB::raw("'Expediente Delictivo' as tabla"),DB::raw("'e3' as carpeta"),'pde.idExpediente')
              ->where(['Validacion'=>1,'bitcorreccionesvalidaciones.Activo'=>1,'rux.idUsuario'=>Auth::User()->id]);

            $procc_ = bitCorreccionesValidaciones::join('procc_datosgenerales as pcc', function($join)
              {
                  $join->on('pcc.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                  ->Where('bitcorreccionesvalidaciones.tabla','=','procc_datosgenerales');
              })
              ->join('relusuarioexpedientes  as rux', function($join)
              {
                  $join->on('rux.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                  ->on('bitcorreccionesvalidaciones.tabla','=','rux.tabla');
              })
              ->select(DB::raw('"-" as NUC'),'NO_EXPEDIENTE_CONDUCCION as NO_EXPEDIENTE',DB::raw("'Expediente de conducción' as tabla"),DB::raw("'d9' as carpeta"),
              'pcc.idExpediente')
              ->where(['Validacion'=>1,'bitcorreccionesvalidaciones.Activo'=>1,'rux.idUsuario'=>Auth::User()->id]);

            $prond_ = bitCorreccionesValidaciones::join('prond_datosgenerales as pnd', function($join)
              {
                  $join->on('pnd.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                  ->Where('bitcorreccionesvalidaciones.tabla','=','prond_datosgenerales');
              })
              ->join('relusuarioexpedientes  as rux', function($join)
              {
                  $join->on('rux.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                  ->on('bitcorreccionesvalidaciones.tabla','=','rux.tabla');
              })
              ->select(DB::raw('"-" as NUC'),'NO_EXPEDIENTE',DB::raw("'Expediente no delictivo' as tabla"),DB::raw("'he' as carpeta"),'pnd.idExpediente')
              ->where(['Validacion'=>1,'bitcorreccionesvalidaciones.Activo'=>1,'rux.idUsuario'=>Auth::User()->id]);

            $ExpV=$prode_->union($procc_)->union($prond_)->get();

            $prode_ = bitCorreccionesValidaciones::join('prode_datosgenerales as pde', function($join)
              {
                  $join->on('pde.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                  ->Where('bitcorreccionesvalidaciones.tabla','=','prode_datosgenerales');
              })
              ->join('relusuarioexpedientes as rux', function($join)
              {
                  $join->on('rux.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                  ->on('bitcorreccionesvalidaciones.tabla','=','rux.tabla');
              })->select('NUC_COMPLETA as NUC','NO_EXPEDIENTE',DB::raw("'Expediente Delictivo' as tabla"),DB::raw("'e3' as carpeta"),'pde.idExpediente'
              ,DB::raw("GROUP_CONCAT(DISTINCT(`bitcorreccionesvalidaciones`.`Observaciones`)) as Observaciones"))
              ->groupby('bitcorreccionesvalidaciones.idExpediente')
              ->where(['Correccion'=>1,'bitcorreccionesvalidaciones.Activo'=>1,'rux.idUsuario'=>Auth::User()->id]);
              
            $procc_ = bitCorreccionesValidaciones::join('procc_datosgenerales as pcc', function($join)
              {
                  $join->on('pcc.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                  ->Where('bitcorreccionesvalidaciones.tabla','=','procc_datosgenerales');
              })
              ->join('relusuarioexpedientes as rux', function($join)
              {
                  $join->on('rux.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                  ->on('bitcorreccionesvalidaciones.tabla','=','rux.tabla');
              })
              ->select(DB::raw('"-" as NUC'),'NO_EXPEDIENTE_CONDUCCION as NO_EXPEDIENTE',DB::raw("'Expediente de conducción' as tabla"),DB::raw("'d9' as carpeta")
                ,'pcc.idExpediente',DB::raw("GROUP_CONCAT(DISTINCT(`bitcorreccionesvalidaciones`.`Observaciones`)) as Observaciones"))
              ->groupby('bitcorreccionesvalidaciones.idExpediente')
              ->where(['Correccion'=>1,'bitcorreccionesvalidaciones.Activo'=>1,'rux.idUsuario'=>Auth::User()->id]);

            $prond_ = bitCorreccionesValidaciones::join('prond_datosgenerales as pnd', function($join)
              {
                  $join->on('pnd.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                  ->Where('bitcorreccionesvalidaciones.tabla','=','prond_datosgenerales');
              })
              ->join('relusuarioexpedientes  as rux', function($join)
              {
                  $join->on('rux.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                  ->on('bitcorreccionesvalidaciones.tabla','=','rux.tabla');
              })
              ->select(DB::raw('"-" as NUC'),'NO_EXPEDIENTE',DB::raw("'Expediente no delictivo' as tabla"),DB::raw("'he' as carpeta"),'pnd.idExpediente'
                ,DB::raw("GROUP_CONCAT(DISTINCT(`bitcorreccionesvalidaciones`.`Observaciones`)) as Observaciones"))
              ->groupby('bitcorreccionesvalidaciones.idExpediente')
              ->where(['Correccion'=>1,'bitcorreccionesvalidaciones.Activo'=>1,'rux.idUsuario'=>Auth::User()->id]);
            $ExpC=$prode_->union($procc_)->union($prond_)->get();            
            $FechasInv=causas_penales\cp_audienciainicial::join('relusuarioexpedientes as rue','procp_audienciainicial.idExpediente','=','rue.idExpediente')
            ->leftJoin('prode_datosgenerales as pdg','rue.idExpediente','=','pdg.idExpediente')
            ->where('rue.Activo','=',1)->where('rue.idUsuario',Auth::User()->id)->groupby('procp_audienciainicial.idImputado')->get();

            foreach ($FechasInv as $key => $value) {
              if (strlen($value->FECHA_CIERRE??'')<1) {
                $diff=90-(now()->diffInDays($value->FECHA_INICIO_INVESTIGACION));
                $msj='';
                if (strlen($value->NO_EXPEDIENTE)>0 && strlen($value->NUC_COMPLETA)>0) {
                  $msj='A la carpeta con expediente <b>'.$value->NO_EXPEDIENTE.'</b> y NUC <b>'.$value->NUC_COMPLETA.
                '</b>, le quedan <b>'.$diff.' días</b> para vencer el plazo de investigación.';
                } elseif (strlen($value->NO_EXPEDIENTE)>0) {
                  $msj='A la carpeta con expediente <b>'.$value->NO_EXPEDIENTE.
                  '</b>, le quedan <b>'.$diff.' días</b> para vencer el plazo de investigación.';
                } elseif (strlen($value->NUC_COMPLETA)>0) {
                  $msj='A la carpeta con NUC <b>'.$value->NUC_COMPLETA.
                  '</b>, le quedan <b>'.$diff.' días</b> para vencer el plazo de investigación.';
                }
                if ($diff>=0 && $diff<30) {
                array_push($arrAlert,['tipo'=>'danger','icon'=>'exclamation-triangle-fill','mensaje'=>'<p onclick="javascript:parent.location.href=\''.route('dash',['od0',$value->idExpediente]).'\'">'.$msj.'</a>']);
                }
                elseif ($diff>=30 && $diff<60) {                
                  array_push($arrAlert,['tipo'=>'warning','icon'=>'exclamation-triangle-fill','mensaje'=>'<p onclick="javascript:parent.location.href=\''.route('dash',['od0',$value->idExpediente]).'\'">'.$msj.'</a>']);
                }
                elseif ($diff>=60 && $diff<90) {
                  array_push($arrAlert,['tipo'=>'info','icon'=>'info-fill','mensaje'=>'<p onclick="javascript:parent.location.href=\''.route('dash',['od0',$value->idExpediente]).'\'">'.$msj.'</a>']);

                }
              }
            }
          #endregion

          $post=0;                    
          if ($request->isMethod('post')){ 
            $post=1;            
            switch ($request->tipo) {
              case 'de':
                $tipo='';
                
                $filtro=$request->input('filtroListado');
                $filtro = str_replace('_c1_','pdg.idExpediente',$filtro);
                $filtro = str_replace('_c2_','pdg.NO_EXPEDIENTE',$filtro);
                $filtro = str_replace('_c3_','pdg.NUC_COMPLETA',$filtro);
                $filtro = str_replace('_c3cp_','IFNULL(pcp.causas,"")',$filtro);
                $filtro = str_replace('_c4_',"STR_TO_DATE(pdg.FECHA_INICIO_CARPETA, '%Y-%m-%d')",$filtro);
                $filtro = str_replace('_c5_',"STR_TO_DATE(pdg.FECHA_INICIO_CARPETA, '%Y-%m-%d')",$filtro);
                $filtro = str_replace('_cFRD_','pdg.created_at',$filtro);
                $filtro = str_replace('_cFRH_','pdg.created_at',$filtro);
                $filtro = str_replace('_cFHD_',"STR_TO_DATE(pdg.FECHA_HECHOS, '%Y-%m-%d')",$filtro);
                $filtro = str_replace('_cFHH_',"STR_TO_DATE(pdg.FECHA_HECHOS, '%Y-%m-%d')",$filtro);
                $filtro = str_replace('_c6_','IFNULL(pdhg.delitos,"") LIKE "%',$filtro);
                $filtro = str_replace('_c7_','IFNULL(pdig.imputados,"") LIKE "%',$filtro);
                $filtro = str_replace('_c8_','IFNULL(pdvg.victimas,"") LIKE "%',$filtro);
                $filtro = str_replace('_LE_','%"',$filtro);
                
                if ($filtro=='') {
                  $expedientes=DB::table('relusuarioexpedientes as rUE')
                   ->join('prode_datosgenerales as pdg','rUE.idExpediente', '=', 'pdg.idExpediente')
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CAUSA_PENAL_ID)) causas, idExpediente FROM procp_datosgenerales WHERE deleted_at IS NULL GROUP BY idExpediente) as pcp"),'pcp.idExpediente', '=', 'pdg.idExpediente')
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_IMPUTADO=2 THEN RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(NOMBRE_IMPUTADO,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS) END)) imputados, idExpediente FROM prode_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'pdg.idExpediente')
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(Valor) as delitos ,idExpediente FROM prode_hechos pdh left join catdelitosespecificos cde on pdh.DELITO=cde.id WHERE deleted_at IS NULL GROUP BY idExpediente) as pdhg"),'pdhg.idExpediente', '=', 'pdg.idExpediente')
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_VICTIMA=2 THEN RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(NOMBRE_VICTIMA,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS) END)) victimas, idExpediente FROM prode_victimas WHERE deleted_at IS NULL GROUP by idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'pdg.idExpediente')
                   ->select('pdg.id as idExpediente','pdg.NUC','pdg.NUC_COMPLETA','pdg.FECHA_INICIO_CARPETA',
                    DB::raw('IFNULL(pcp.causas,"-") as causas'),'pdg.NO_EXPEDIENTE',
                    DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),'pdg.created_at','pdg.FECHA_HECHOS',
                      DB::raw('IFNULL(pdig.imputados,"-") as imputados'),DB::raw('IFNULL(pdvg.victimas,"-") as victimas'), DB::raw("'e3' as carpeta"))
                   ->where('rUE.Activo',1)->where('tabla','prode_datosgenerales')
                   ->where('rUE.idUsuario',Auth::User()->id)->groupby('idExpediente')
                   ->OrderByDesc('idExpediente')->paginate(10)->setPageName('page');
                }
                else
                {
                  $expedientes=DB::table('relusuarioexpedientes as rUE')
                   ->join('prode_datosgenerales as pdg','rUE.idExpediente', '=', 'pdg.idExpediente')
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CAUSA_PENAL_ID)) causas, idExpediente FROM procp_datosgenerales WHERE deleted_at IS NULL GROUP BY idExpediente) as pcp"),'pcp.idExpediente', '=', 'pdg.idExpediente')
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_IMPUTADO=2 THEN RAZON_SOCIAL WHEN TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(NOMBRE_IMPUTADO,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS) END)) imputados, idExpediente FROM prode_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'pdg.idExpediente')
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(Valor) as delitos ,idExpediente FROM prode_hechos pdh left join catdelitosespecificos cde on pdh.DELITO=cde.id WHERE deleted_at IS NULL GROUP BY idExpediente) as pdhg"),'pdhg.idExpediente', '=', 'pdg.idExpediente')
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_VICTIMA=2 THEN RAZON_SOCIAL WHEN TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(NOMBRE_VICTIMA,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS) END)) victimas, idExpediente FROM prode_victimas WHERE deleted_at IS NULL GROUP by idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'pdg.idExpediente')
                   ->select('pdg.id as idExpediente','pdg.NUC','pdg.NUC_COMPLETA','pdg.FECHA_INICIO_CARPETA',
                    DB::raw('IFNULL(pcp.causas,"-") as causas'),'pdg.NO_EXPEDIENTE',
                    DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),'pdg.created_at','pdg.FECHA_HECHOS',
                      DB::raw('IFNULL(pdig.imputados,"-") as imputados'),DB::raw('IFNULL(pdvg.victimas,"-") as victimas'), DB::raw("'e3' as carpeta"))
                   ->where('rUE.Activo',1)->where('tabla','prode_datosgenerales')
                   ->where('rUE.idUsuario',Auth::User()->id)->groupby('idExpediente')
                   ->whereRaw($filtro)->paginate(100)->setPageName('page');                
                }
              break;
              case 'cc':
                $tipo='CC';
                $filtro=$request->input('filtroListado');
                $filtro = str_replace('_c1_','pdg.idExpediente',$filtro);
                $filtro = str_replace('_c2_','pdg.NO_EXPEDIENTE_CONDUCCION',$filtro);
                $filtro = str_replace('_c4_',"STR_TO_DATE(pdg.FECHA_INICIO_CONDUCCION, '%Y-%m-%d')",$filtro);
                $filtro = str_replace('_c5_',"STR_TO_DATE(pdg.FECHA_INICIO_CONDUCCION, '%Y-%m-%d')",$filtro);
                $filtro = str_replace('_cFRD_','pdg.created_at',$filtro);
                $filtro = str_replace('_cFRH_','pdg.created_at',$filtro);
                $filtro = str_replace('_cFHD_',"STR_TO_DATE(pdg.FECHA_HECHOS_CONDUCCION, '%Y-%m-%d')",$filtro);
                $filtro = str_replace('_cFHH_',"STR_TO_DATE(pdg.FECHA_HECHOS_CONDUCCION, '%Y-%m-%d')",$filtro);
                $filtro = str_replace('_c6_','IFNULL(pdhg.delitos,"-") LIKE "%',$filtro);
                $filtro = str_replace('_c7_','IFNULL(pdig.imputados,"-") LIKE "%',$filtro);
                $filtro = str_replace('_c8_','IFNULL(pdvg.victimas,"-") LIKE "%',$filtro);
                $filtro = str_replace('_LE_','%"',$filtro);
                if ($filtro=='') {
                  $expedientesCC=DB::table('relusuarioexpedientes as rUE')
                   ->join('procc_datosgenerales as pdg','rUE.idExpediente', '=', 'pdg.idExpediente')                   
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_IMPUTADO_CONDUCCION=2 THEN RAZON_SOCIAL WHEN TIPO_IMPUTADO_CONDUCCION=3 THEN 'LA SOCIEDAD' WHEN TIPO_IMPUTADO_CONDUCCION=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_IMPUTADO_CONDUCCION=7 THEN 'LA SALUD' ELSE CONCAT(NOMBRE_IMPUTADO,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS_CONDUCCION) END)) imputados, idExpediente FROM procc_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'pdg.idExpediente')
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(Valor) as delitos ,idExpediente FROM procc_hechos pdh left join catdelitosespecificos cde on pdh.DELITO=cde.id WHERE deleted_at IS NULL GROUP BY idExpediente) as pdhg"),'pdhg.idExpediente', '=', 'pdg.idExpediente')
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_VICTIMA_CONDUCCION=2 THEN RAZON_SOCIAL WHEN TIPO_VICTIMA_CONDUCCION=3 THEN 'LA SOCIEDAD' WHEN TIPO_VICTIMA_CONDUCCION=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_VICTIMA_CONDUCCION=7 THEN 'LA SALUD' ELSE CONCAT(NOMBRE_VICTIMA,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS_CONDUCCION) END)) victimas, idExpediente FROM procc_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'pdg.idExpediente')
                   ->select('pdg.id as idExpediente','pdg.NO_EXPEDIENTE_CONDUCCION as NO_EXPEDIENTE',
                    DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),'pdg.FECHA_INICIO_CONDUCCION as FECHA_INICIO_CARPETA',
                    'pdg.created_at','pdg.FECHA_HECHOS_CONDUCCION as FECHA_HECHOS',
                      DB::raw('IFNULL(pdig.imputados,"-") as imputados'),
                      DB::raw('IFNULL(pdvg.victimas,"-") as victimas'),
                      DB::raw("'d9' as carpeta"))
                   ->where('rUE.Activo',1)->where('tabla','procc_datosgenerales')
                   ->where('rUE.idUsuario',Auth::User()->id)->groupby('idExpediente')
                   ->OrderByDesc('idExpediente')->paginate(10)->setPageName('CC');
                }
                else
                {
                  $expedientesCC=DB::table('relusuarioexpedientes as rUE')
                   ->join('procc_datosgenerales as pdg','rUE.idExpediente', '=', 'pdg.idExpediente')                   
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_IMPUTADO_CONDUCCION=2 THEN RAZON_SOCIAL WHEN TIPO_IMPUTADO_CONDUCCION=3 THEN 'LA SOCIEDAD' WHEN TIPO_IMPUTADO_CONDUCCION=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_IMPUTADO_CONDUCCION=7 THEN 'LA SALUD' ELSE CONCAT(NOMBRE_IMPUTADO,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS_CONDUCCION) END)) imputados, idExpediente FROM procc_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'pdg.idExpediente')
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(Valor) as delitos ,idExpediente FROM procc_hechos pdh left join catdelitosespecificos cde on pdh.DELITO=cde.id WHERE deleted_at IS NULL GROUP BY idExpediente) as pdhg"),'pdhg.idExpediente', '=', 'pdg.idExpediente')
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CASE WHEN TIPO_VICTIMA_CONDUCCION=2 THEN RAZON_SOCIAL WHEN TIPO_VICTIMA_CONDUCCION=3 THEN 'LA SOCIEDAD' WHEN TIPO_VICTIMA_CONDUCCION=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN TIPO_VICTIMA_CONDUCCION=7 THEN 'LA SALUD' ELSE CONCAT(NOMBRE_VICTIMA,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS_CONDUCCION) END)) victimas, idExpediente FROM procc_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'pdg.idExpediente')
                   ->select('pdg.id as idExpediente','pdg.NO_EXPEDIENTE_CONDUCCION as NO_EXPEDIENTE',
                    DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),'pdg.FECHA_INICIO_CONDUCCION as FECHA_INICIO_CARPETA',
                    'pdg.created_at','pdg.FECHA_HECHOS_CONDUCCION as FECHA_HECHOS',
                      DB::raw('IFNULL(pdig.imputados,"-") as imputados'),
                      DB::raw('IFNULL(pdvg.victimas,"-") as victimas'),
                      DB::raw("'d9' as carpeta"))
                   ->where('rUE.Activo',1)->where('tabla','procc_datosgenerales')
                   ->where('rUE.idUsuario',Auth::User()->id)->groupby('idExpediente')
                   ->whereRaw($filtro)->paginate(100)->setPageName('CC');
                }
              break;              
              case 'nd':
                $tipo='ND';
                $filtro=$request->input('filtroListado');
                $filtro = str_replace('_c1_','pdg.idExpediente',$filtro);
                $filtro = str_replace('_c2_','pdg.NO_EXPEDIENTE',$filtro);
                $filtro = str_replace('_c4_',"STR_TO_DATE(pdg.FECHA_INICIO, '%Y-%m-%d')",$filtro);
                $filtro = str_replace('_c5_',"STR_TO_DATE(pdg.FECHA_INICIO, '%Y-%m-%d')",$filtro);
                $filtro = str_replace('_cFRD_','pdg.created_at',$filtro);
                $filtro = str_replace('_cFRH_','pdg.created_at',$filtro);
                $filtro = str_replace('_cFHD_',"STR_TO_DATE(pdg.FECHA_HECHOS_NO_DELICTIVOS, '%Y-%m-%d')",$filtro);
                $filtro = str_replace('_cFHH_',"STR_TO_DATE(pdg.FECHA_HECHOS_NO_DELICTIVOS, '%Y-%m-%d')",$filtro);
                $filtro = str_replace('_c6_','cr1.Valor LIKE "%',$filtro);              
                $filtro = str_replace('_c8_','IFNULL(pdvg.victimas,"-") LIKE "%',$filtro);
                $filtro = str_replace('_LE_','%"',$filtro);                
                if ($filtro=='') {
                  $expedientesND=DB::table('relusuarioexpedientes as rUE')
                   ->join('prond_datosgenerales as pdg','rUE.idExpediente', '=', 'pdg.idExpediente')
                   // ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS))) imputados, idExpediente FROM prond_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'pdg.idExpediente')
                   ->leftJoin('catrespuestas as cr1', function($join)
                   {
                      $join->on('pdg.HECHO_NO_DELITO','=','cr1.id')
                      ->Where('cr1.idTipoRespuesta','=',70);
                   })           
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_VICTIMA,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS_NO_DELICTIVO))) victimas, idExpediente FROM prond_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'pdg.idExpediente')
                   ->select('pdg.id as idExpediente','pdg.NO_EXPEDIENTE',
                    'pdg.created_at','pdg.FECHA_HECHOS_NO_DELICTIVOS as FECHA_HECHOS',
                    // DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),DB::raw('IFNULL(pdig.imputados,"-") as imputados'),
                    DB::raw("cr1.Valor as delitos"),DB::raw("'' as imputados"),'pdg.FECHA_INICIO as FECHA_INICIO_CARPETA',
                    DB::raw('IFNULL(pdvg.victimas,"-") as victimas'), DB::raw("'he' as carpeta"))
                   ->where('rUE.Activo',1)->where('tabla','prond_datosgenerales')
                   ->where('rUE.idUsuario',Auth::User()->id)->groupby('idExpediente')
                   ->OrderByDesc('idExpediente')->paginate(10)->setPageName('ND');
                }
                else
                {
                  $expedientesND=DB::table('relusuarioexpedientes as rUE')
                   ->join('prond_datosgenerales as pdg','rUE.idExpediente', '=', 'pdg.idExpediente')
                   // ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS))) imputados, idExpediente FROM prond_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'pdg.idExpediente')
                   ->leftJoin('catrespuestas as cr1', function($join)
                   {
                      $join->on('pdg.HECHO_NO_DELITO','=','cr1.id')
                      ->Where('cr1.idTipoRespuesta','=',70);
                   })           
                   ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_VICTIMA,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS_NO_DELICTIVO))) victimas, idExpediente FROM prond_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'pdg.idExpediente')
                   ->select('pdg.id as idExpediente','pdg.NO_EXPEDIENTE',
                    'pdg.created_at','pdg.FECHA_HECHOS_NO_DELICTIVOS as FECHA_HECHOS',
                    'pdg.FECHA_INICIO as FECHA_INICIO_CARPETA',
                    // DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),DB::raw('IFNULL(pdig.imputados,"-") as imputados'),
                    DB::raw("cr1.Valor as delitos"),DB::raw("'' as imputados"),
                    DB::raw('IFNULL(pdvg.victimas,"-") as victimas'), DB::raw("'he' as carpeta"))
                   ->where('rUE.Activo',1)->where('tabla','prond_datosgenerales')
                   ->where('rUE.idUsuario',Auth::User()->id)->groupby('idExpediente')
                   ->whereRaw($filtro)->paginate(100)->setPageName('ND');
                }
              break;                            
            }
          }
        #endregion            
        $delegaciones = DB::table('catdelegaciones')->where('Activo',1)->orderBy('id')->get();        
        return view('inicio.listadoExpedientes')
        ->with(['ExpC'=>$ExpC,'ExpV'=>$ExpV,'arrAlert'=>$arrAlert,
          'post'=>$post,'tipo'=>$tipo,'delegaciones'=>$delegaciones,
          'expedientes'=>$expedientes, 'expedientesCC'=>$expedientesCC,'expedientesND'=>$expedientesND]);
      }
    }
  #endregion
  #region LogIn/LogOut
    function index()
    {
        return view('inicio.login');
    }

    function registration()
    {
        return view('inicio.registration');
    }

    function validate_registration(Request $request)
    {
      $request->validate([
        'name'         =>   'required',
        'email'        =>   'required|email|unique:users',
        'password'     =>   'required|min:6',
        'tipo'         =>   'required',
        'unidad'       =>   'required',
        'nivel'        =>   'required',
      ],
      [
        'name.required'=>'el nombre es requerido',
        'email.required'=>'el correo es requerido',
        'email.email'=>'el correo tiene un formato incorrecto',
        'email.unique'=>'el correo ya fue registrado',
        'password.required'=>'el password es requerido',
        'password.min'=>'mínimo del password: :min',
        'tipo.required'=>'el tipo de usuario es requerido',
        'unidad.required'=>'la unidad es requerida',
        'nivel.required'=>'el nivel es requerido', ]);

      $data = $request->all();

      User::create([
          'name'  =>  $data['name'],
          'email' =>  $data['email'],
          'password' => Hash::make($data['password']),
          'TipoUsuario'=>$data['tipo'],
          'Unidad' => $data['unidad'],
          'Nivel' => $data['nivel'],
      ]);

      return back()->with('registration', 'El registro del usuario finalizó correctamente.');
    }

    function validate_login(Request $request)
    {
      $request->validate([
          'email' =>  'required',
          'password'  =>  'required'
      ],
      [   'email.required'=>'El correo es requerido',
          'password.required'=>'la contraseña es requerida']);

      $credentials = $request->only('email', 'password');

      if(Auth::attempt($credentials))
      {
          if (Auth::User()->TipoUsuario==99) {
              return redirect('Inicio');}
          else if (Auth::User()->TipoUsuario==2||Auth::User()->TipoUsuario==3) {
              return redirect()->route('listado.super');}
          else{
              return redirect()->route('listado');}            
      }

      return redirect('IniciarSesion')
      ->with('login', 'Las credenciales no son correctas, intente de nuevo.');
    }

    function dashboard()
    {
      if(Auth::check())
      {
          return redirect()->route('dash',['q7']);
      }

      return redirect('IniciarSesion')->with('login', 'No tienes sesión iniciada');
    }
    function logout()
    {
        Session::flush();

        Auth::logout();

        return Redirect('IniciarSesion');
    }
  #endregion

  // Import data 
    public function importData(Request $request)
    {
      if(is_null(Auth::User())) { return redirect("Salir"); }
      else
      {      
        $file = $request->file('file');
        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes
            //Check for file extension and size
            $this->checkUploadedFileProperties($extension, $fileSize);
            //Where uploaded file will be stored on the server 
            $location = 'uploads'; //Created an "uploads" folder for that
            // Upload file
            $file->move($location, $filename);
            // In case the uploaded file path is to be stored in the database 
            $filepath = public_path($location . "/" . $filename);
            // Reading file
            $file = fopen($filepath, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;
            //Read the contents of the uploaded file 
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                // Skip first row (Remove below comment if you want to skip the first row)
                // if ($i == 0) {
                // $i++;
                //  continue;
                // }
                for ($c = 0; $c < $num; $c++) {

                 $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file); //Close after reading
            unlink($filepath);
            $j = 0;
            $correoRepetido=array();
            foreach ($importData_arr as $importData) {

                if (User::whereEmail($importData[1])->count()>0) {
                    $correoRepetido[]= $importData[1];      
                }
            }   

            if(count($correoRepetido)==0)
            {             
            foreach ($importData_arr as $importData) {
                
                    User::create([
                        'name'  =>  utf8_encode($importData[0]),
                        'email' =>  $importData[1],
                        'password' => Hash::make($importData[2]),
                        'TipoUsuario'=>$importData[3],
                        'Unidad' => $importData[4],
                        'Nivel' => $importData[5],                        
                    
                    ]);
                $j++;
                // try {
      
                // //Send Email
                // $this->sendEmail($email, $name);
                // }
                //  catch (\Exception $e) {
                // //throw $th;
                // }
                }
            }        

            $msjcorreoRepetido=null;
            $msjmasivo='El registro de usuarios finalizó correctamente.';
            if(count($correoRepetido)>0) {
                $msjmasivo=null;
                $msjcorreoRepetido=count($correoRepetido)==1?'El correo '.$correoRepetido[0].' ya existe'
                :'Los siguientes correos ya existen:<br><br> '.implode(',<br>', $correoRepetido);
               // $msjcorreoRepetido=json_encode($importData_arr);
            }
          return back()->with(['registration'=> $msjmasivo,
            'correoRepetido'=>$msjcorreoRepetido]);
        } else {
            return back()->with(['registration'=> null,
            'correoRepetido'=>'Es necesario cargar un archivo']);
            //no file was uploaded
            //throw new \Exception('Es necesario cargar un archivo', Response::HTTP_BAD_REQUEST);
        }
      }
    }
    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
        if ($fileSize <= $maxFileSize) {
        } else {
            throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
        }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }
    public function sendEmail($email, $name)
    {
        $data = array(
        'email' => $email,
        'name' => $name,
        'subject' => 'Welcome Message',
        );
        Mail::send('welcomeEmail', $data, function ($message) use ($data) {
        $message->from('welcome@myapp.com');
        $message->to($data['email']);
        $message->subject($data['subject']);
        });
    }

    public function importExcel(Request $request)
    {

     if(is_null(Auth::User())) { return redirect("Salir"); }
     else
     {
      try{ 
        $file = $request->file('file');
        if ($file) 
        {
          $disk = env('FILESYSTEM_DRIVER','local');
          
          $uploaded_file = $file->getClientOriginalName();
          $extension = $file->extension();
          $mimeType = $file->getMimeType();
          $filename = "f_".date("YmdHis").".$extension";
           $path = Storage::disk($disk)->putFileAs("drafts", $file, $filename);
           $path = Storage::path($path);
            $reader = ReaderEntityFactory::createReaderFromFile($path);
            $reader->setShouldFormatDates(TRUE);
            $reader2 = ReaderEntityFactory::createReaderFromFile($path);
            $reader2->setShouldFormatDates(TRUE);          
            $reader3 = ReaderEntityFactory::createReaderFromFile($path);
            $reader3->setShouldFormatDates(TRUE);                                
            $reader4 = ReaderEntityFactory::createReaderFromFile($path);
            $reader4->setShouldFormatDates(TRUE);          
            $reader5 = ReaderEntityFactory::createReaderFromFile($path);
            $reader5->setShouldFormatDates(TRUE);                                
            $reader6 = ReaderEntityFactory::createReaderFromFile($path);
            $reader6->setShouldFormatDates(TRUE);          
            $reader7 = ReaderEntityFactory::createReaderFromFile($path);
            $reader7->setShouldFormatDates(TRUE);           
          $reader->open($path);
          
          $sheets=$reader->getSheetIterator();
          $horas=[];
          $NUCR_base_carpetas = [];
          $NUCR_base_carpetas2 = [];
          
          $NUCR_base_imputadosI = [];
          $NUCR_base_delitosI = [];
          $NUCR_base_victimasI = [];

          $EXPR_base_hechos_no_delictivos = [];
          $EXPR_base_conduccion = [];
          $idExpedienteArray = [];
          foreach ($sheets as $sheet) {
            if ($sheet->getName()=='base_carpetas'){
                //$cellValues=[]; $de_DG=[]; $de_OB=[];
                $i=0;
                $key=[];
                
                foreach ($sheet->getRowIterator() as $k=>$row) {
                  // $cellValues[] = array_map(function($cell) {
                  //         return $cell->getValue();
                  //     }, $row->getCells());
                  $rowValues = array_map(function($cell) {
                        return $cell->getValue();
                    }, $row->getCells());

                  if($k>0 && ($rowValues[0]??'')!='DELEGACION' && ($rowValues[1]??'')!='MUNICIPIO' && ($rowValues[6]??'')!='NUC' && ($rowValues[8]??'')!='NUC_COMPLETA'){
                    if (isset($rowValues[6],$rowValues[8])) {
                        $key=[];
                      #region catálogos
                        $key['DELEGACION']=DB::table('catdelegaciones')->where('Valor',trim($rowValues[0] ?? ''))->first('id');
                        $key['MUNICIPIO']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[1] ?? ''))->first('id');
                        $key['UNIDAD_ATENCION']=DB::table('catuats')->where('Valor',trim($rowValues[2] ?? ''))->first('id');                        
                        $key['UNIDAD_QUE_RECIBE']=DB::table('catrespuestas')->where('idTipoRespuesta',96)
                        ->where('Valor',str_replace('_', ' ',trim($rowValues[9] ?? '')))->first('id');
                        $key['ENTIDAD_HECHOS']
                          =DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[12] ?? ''))->first('id');
                        $key['MUNICIPIO_HECHOS']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[13] ?? ''))
                        ->where('CVE_ENT',$key['ENTIDAD_HECHOS']->id ?? -1)->first('id');                        
                        //$key['COLONIA_HECHOS']=DB::table('catcolonias')->where('Valor',trim($rowValues[14] ?? ''))->where('idMunicipio',$key['MUNICIPIO_HECHOS']->id ?? -1)->first('id');
    
                        $key['RECIBIDA_POR']=DB::table('catrespuestas')->where('idTipoRespuesta',12)->where('Valor',trim($rowValues[10] ?? ''))->first('id');
                        $key['TIPO_RECEPCION']=DB::table('catrespuestas')->where('idTipoRespuesta',2)->where('Valor',trim($rowValues[11] ?? ''))->first('id');
                        $key['AUTORIDAD']=DB::table('catrespuestas')->where('idTipoRespuesta',41)->where('Valor',trim($rowValues[11] ?? ''))->first('id');                        
                        $key['AUTORIDAD_IPH']=DB::table('catrespuestas')->where('idTipoRespuesta',24)
                        ->where('Valor',str_replace('_', ' ',trim($rowValues[51] ?? '')))->first('id');                        
                      #enregion
                        $de_DG = datos_expediente\de_datosgenerales::firstOrCreate(
                          [ 'NUC_COMPLETA' => $rowValues[8] ?? '' ],
                          ['NUC' => $rowValues[6] ?? '',
                            'DELEGACION'=>$key['DELEGACION']->id ?? -1,
                            'MUNICIPIO' => $key['MUNICIPIO']->id ?? -1,
                            'UNIDAD_ATENCION' => $key['UNIDAD_ATENCION']->id ?? -1,
                            'FECHA_INICIO_CARPETA' => strtotime($rowValues[3] ?? '') ? date('Y-m-d',strtotime($rowValues[3])): '',
                            'HORA_APERTURA_CARPETA' => null,
                            'NO_EXPEDIENTE' => $rowValues[7] ?? '',
                            'ESTATUS_CARPETA' => null,
                            'AGENTE_ID' => Auth::User()->id,
                            'NOMBRE_FISCALIA' => null,
                            'NOMBRE_AGENTE_MP' => null,
                            'MP_NOM' => null,
                            'MP_NUM' => Auth::User()->Unidad,
                            'CARPETA_ID' => null,
                            'TIPO_MP' => null,
                            'TIPO_FISCALIA' => null,
                            'UBICACION_MP' => null,
                            // 'ID_SEGUIMIENTO' => null,
                            'FECHA_HECHOS' => strtotime($rowValues[4] ?? '') ? date('Y-m-d',strtotime($rowValues[4])): '',
                            'HORA_HECHOS' => strtotime($rowValues[5] ?? '') ? date('H:i',strtotime($rowValues[5])) : '',
                            'ENTIDAD_HECHOS' => $key['ENTIDAD_HECHOS']->id ?? -1,
                            'MUNICIPIO_HECHOS' => $key['MUNICIPIO_HECHOS']->id ?? -1,
                            'COLONIA_HECHOS' => trim($rowValues[14] ?? ''),
                            'CALLE_HECHOS' => $rowValues[15] ?? '',
                            'CP' => substr($rowValues[16] ?? '',0,5),
                            'REF_1' => $rowValues[17] ?? '',
                            'REF_2' => $rowValues[18] ?? '',
                            'RECIBIDA_POR' => $key['RECIBIDA_POR']->id ?? -1,
                            'UNIDAD_QUE_RECIBE' => $key['UNIDAD_QUE_RECIBE']->id ?? -1,
                            'TIPO_RECEPCION' => $key['TIPO_RECEPCION']->id ?? -1,
                            'AUTORIDAD' => $key['AUTORIDAD']->id ?? -1,
                            'HORA_DENUNCIA' => null,
                            'PARENTESCO' => -1,
                            'FORMA_' => -1,
                            'ASEGURAMIENTO'=> -1, 
                            'TIPO_DE_BIEN'=>null, 
                            'OPORTUNIDAD'=> -1,  
                            'ETAPA_PROCES'=> -1, 
                            'MEDIO_DE_CONOCIMIENTO'=> -1, 
                            'FECHA_DENUNCIA'=>null,
                            'REACTIVACION'=> -1, 
                            'DESCRIPCION' => $rowValues[48] ?? '',
                            'OBSERVACIONES' => $rowValues[49] ?? '',
                            'AUTORIDAD_IPH' => $key['AUTORIDAD_IPH']->id ?? -1,
                          ]
                        );
                        if ($de_DG->wasRecentlyCreated) {
                           $upd=datos_expediente\de_datosgenerales::where('id', '=',$de_DG->id)->firstOrFail();
                           $upd->idExpediente=$de_DG->id;
                           $upd->save();
                           $relUsuExp=relusuarioexpedientes::create(
                            ['idUsuario' => Auth::User()->id,
                            'idExpediente' => $de_DG->id,
                            'tabla' => 'prode_datosgenerales',
                            'Activo' => 1]); 
                           $bitEvUsu=biteventousario::create(
                            ['idUsuario' => Auth::User()->id,
                            'idExpediente' => $de_DG->id,
                            'idRegistro' => 0,
                            'idEvento' => 50,
                            'Evento' =>'Insertar Expediente de Datos generales']);
                           $key=[];
                           if (empty(trim($rowValues[19] ?? '')) && empty(trim($rowValues[20] ?? '')) &&
                            empty(trim($rowValues[21] ?? '')) && empty(trim($rowValues[22] ?? '')) &&
                            empty(trim($rowValues[23] ?? '')) && empty(trim($rowValues[24] ?? '')) &&
                            empty(trim($rowValues[25] ?? '')) && empty(trim($rowValues[26] ?? '')) &&
                            empty(trim($rowValues[27] ?? '')) && empty(trim($rowValues[28] ?? '')) &&
                            empty(trim($rowValues[29] ?? '')) && empty(trim($rowValues[30] ?? '')) &&

                            empty(trim($rowValues[31] ?? '')) && empty(trim($rowValues[32] ?? '')) && empty(trim($rowValues[33] ?? '')) &&
                            empty(trim($rowValues[34] ?? '')) && empty(trim($rowValues[35] ?? '')) && empty(trim($rowValues[36] ?? '')) &&
                            empty(trim($rowValues[37] ?? '')) && empty(trim($rowValues[38] ?? '')) && empty(trim($rowValues[39] ?? '')) &&

                            empty(trim($rowValues[40] ?? '')) && empty(trim($rowValues[41] ?? '')) && empty(trim($rowValues[42] ?? '')) &&
                            empty(trim($rowValues[43] ?? '')) && empty(trim($rowValues[44] ?? '')) && empty(trim($rowValues[45] ?? '')) &&
                            empty(trim($rowValues[46] ?? '')) && empty(trim($rowValues[47] ?? '')) && empty(trim($rowValues[50] ?? ''))) {
                             // code...
                           }
                           else
                           {
                            #region catálogos
                              $key['OBJETO_1']=DB::table('catrespuestas')->where('idTipoRespuesta',25)->where('Valor',trim($rowValues[19] ?? ''))->first('id');
                              $key['OBJETO_2']=DB::table('catrespuestas')->where('idTipoRespuesta',25)->where('Valor',trim($rowValues[23] ?? ''))->first('id');
                              $key['OBJETO_3']=DB::table('catrespuestas')->where('idTipoRespuesta',25)->where('Valor',trim($rowValues[27] ?? ''))->first('id');
                              $key['TIPO_NARCOTICO_1']=DB::table('catrespuestas')->where('idTipoRespuesta',26)->where('Valor',trim($rowValues[31] ?? ''))->first('id');
                              $key['TIPO_NARCOTICO_2']=DB::table('catrespuestas')->where('idTipoRespuesta',26)->where('Valor',trim($rowValues[34] ?? ''))->first('id');
                              $key['TIPO_NARCOTICO_3']=DB::table('catrespuestas')->where('idTipoRespuesta',26)->where('Valor',trim($rowValues[37] ?? ''))->first('id');
                              $key['ESTATUS']=DB::table('catrespuestas')->where('idTipoRespuesta',77)->where('Valor',trim($rowValues[40] ?? ''))->first('id');
                            #endregion
                              $de_OB=new datos_expediente\de_objetos([
                                  'idExpediente' => $de_DG->id,
                                  'OBJETO_1' => $key['OBJETO_1']->id ?? -1,
                                  'DESC_OBJ_1' => $rowValues[20] ?? '',
                                  'CANT_OBJ_1' => $rowValues[21] ?? '',
                                  'VALOR_OBJ_1' => $rowValues[22] ?? '',
                                  'OBJETO_2' => $key['OBJETO_2']->id ?? -1,
                                  'DESC_OBJ_2' => $rowValues[24] ?? '',
                                  'CANT_OBJ_2' => $rowValues[25] ?? '',
                                  'VALOR_OBJ_2' => $rowValues[26] ?? '',
                                  'OBJETO_3' => $key['OBJETO_3']->id ?? -1,
                                  'DESC_OBJ_3' => $rowValues[28] ?? '',
                                  'CANT_OBJ_3' => $rowValues[29] ?? '',
                                  'VALOR_OBJ_3' => $rowValues[30] ?? '',
                                  'TIPO_NARCOTICO_1' => $key['TIPO_NARCOTICO_1']->id ?? -1,
                                  'CANTIDAD_NARCO_1' => $rowValues[32] ?? '',
                                  'GRAMAJE_NARCO_1' => $rowValues[33] ?? '',
                                  'TIPO_NARCOTICO_2' => $key['TIPO_NARCOTICO_2']->id ?? -1,                                
                                  'CANTIDAD_NARCO_2' => $rowValues[35] ?? '',
                                  'GRAMAJE_NARCO_2' => $rowValues[36] ?? '',
                                  'TIPO_NARCOTICO_3' => $key['TIPO_NARCOTICO_3']->id ?? -1,                                
                                  'CANTIDAD_NARCO_3' => $rowValues[38] ?? '',
                                  'GRAMAJE_NARCO_3' => $rowValues[39] ?? '',
                                  'ESTATUS' => $key['ESTATUS']->id ?? -1,
                                  'MARCA' => $rowValues[41] ?? '',
                                  'MODELO' => $rowValues[42] ?? '',
                                  'COLOR' => $rowValues[43] ?? '',
                                  'TIPO' => $rowValues[44] ?? '',
                                  'PLACA' => $rowValues[45] ?? '',
                                  'NUMERO' => $rowValues[46] ?? '',
                                  'ESTADO_PLACAS' => $rowValues[47] ?? '' ,
                                  'LUGAR_VEHICULO' => $rowValues[50] ?? ''                  
                              ]);
                              $de_OB->save();
                           }
                            //if (count($NUCR_base_carpetas)<1) {

                            $reader2->open($path);
                            $sheets2=$reader2->getSheetIterator();
                            foreach ($sheets2 as $sheet2) {
                              if ($sheet2->getName()=='base_imputados'){
                                  foreach ($sheet2->getRowIterator() as $k=>$row) {
                                    $insertarI=true;
                                      $rowValues = array_map(function($cell) {
                                              return $cell->getValue();
                                          }, $row->getCells());
                                      if($k>0 && ($rowValues[0]??'')!='NUC' && ($rowValues[1]??'')!='TIPO_IMPUTADO'){
                                          if (isset($rowValues[0],$rowValues[45])) {
                                            $idExpediente = datos_expediente\de_datosgenerales::where('NO_EXPEDIENTE', '=', $rowValues[45])
                                              ->Where('NUC_COMPLETA', '=', $rowValues[0])->first();                                

                                            $idExpedienteArray[0][]=$idExpediente;
                                            if ($idExpediente) {
                                              if ($idExpediente->idExpediente > 0) {
                                               $idImputado = datos_expediente\de_imputados::where('idExpediente','=', $idExpediente->idExpediente)->first(); 
                                               if ($idImputado) {
                                                if ($idImputado->idExpediente > 0) {    
                                                 if (in_array($rowValues[0],$NUCR_base_carpetas2)) {
                                                  $insertarI=false;
                                                 }
                                                }
                                               }
                                               if ($insertarI) {
                                                  $key=[];
                                                #region catálogos
                                                  ////4 =SiNoNoI                                
                                                  $key['TIPO_IMPUTADO']=DB::table('catrespuestas')->where('idTipoRespuesta',13)->where('Valor',trim($rowValues[1] ?? ''))->first('id');
                                                  $key['SECTOR_IMPUTADOS']=DB::table('catrespuestas')->where('idTipoRespuesta',15)->where('Valor',trim($rowValues[4] ?? ''))->first('id');
                                                  $key['REL_PERS_MORAL']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[3] ?? ''))->first('id');
                                                  $key['TIPO_PERSONA_IMPUTADOS']=DB::table('catrespuestas')->where('idTipoRespuesta',16)->where('Valor',trim($rowValues[5] ?? ''))->first('id');
                                                  $key['DELITOS_IMPUTADO']=DB::table('catrespuestas')->where('idTipoRespuesta',14)->where('Valor',trim($rowValues[6] ?? ''))->first('id');    
                                                  $key['RELACION_VICTIMA']=DB::table('catrespuestas')->where('idTipoRespuesta',21)->where('Valor',trim($rowValues[8] ?? ''))->first('id');    
                                                  $key['SEXO_IMPUTADO']=DB::table('catrespuestas')->where('idTipoRespuesta',17)->where('Valor',trim($rowValues[15] ?? ''))->first('id');
                                                  $key['SITUACION_CONYUGAL_IMPUTADOS']
                                                  =DB::table('catrespuestas')->where('idTipoRespuesta',18)->where('Valor',trim($rowValues[16] ?? ''))->first('id');
                                                  $key['NACIONALIDAD']=DB::table('catpaises')->where('Valor',trim($rowValues[17] ?? ''))->first('id');
                                                  $key['SITUACION_MIGRATORIA_IMPUTADOS']
                                                  =DB::table('catrespuestas')->where('idTipoRespuesta',1)->where('Valor',trim($rowValues[18] ?? ''))->first('id');
                                                  $key['PAIS_NACIMIENTO']=DB::table('catpaises')->where('Valor',trim($rowValues[19] ?? ''))->first('id');
                                                  $key['ENTIDAD_NACIMIENTO_IMPUTADOS']=DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[20] ?? ''))->first('id');
                                                  $key['MUNICIPIO_NACIMIENTO']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[21] ?? ''))->first('id');        
                                                  $key['PAIS_RESIDENCIA']=DB::table('catpaises')->where('Valor',trim($rowValues[22] ?? ''))->first('id');
                                                  $key['ENTIDAD_RESIDENCIA_IMPUTADOS']=DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[23] ?? ''))->first('id');
                                                  $key['MUNICIPIO_RESIDENCIA']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[24] ?? ''))->first('id');
                                                  $key['TRADUCTOR_IMPUTADO']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[26] ?? ''))->first('id');
                                                  $key['DISCAPACIDAD_IMPUTADOS']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[27] ?? ''))->first('id');
                                                  $key['TIPO_DISCAPACIDAD_IMPUTADOS']=DB::table('catrespuestas')->where('idTipoRespuesta',19)->where('Valor',trim($rowValues[28] ?? ''))->first('id');
                                                  $key['INTERPRETE_POR_DISCAPACIDAD_IMPUTADO']
                                                      =DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[29] ?? ''))->first('id');
                                                  $key['POBLACION_CALLE']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[30] ?? ''))->first('id');
                                                  $key['LEER_ESCRIBIR_IMPUTADOS']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[31] ?? ''))->first('id');
                                                  $key['ESCOLARIDAD_IMPUTADO']=DB::table('catrespuestas')->where('idTipoRespuesta',20)->where('Valor',trim($rowValues[32] ?? ''))->first('id');
                                                  $key['DETENIDO_IMPUTADOS']=DB::table('catrespuestas')->where('idTipoRespuesta',2)->where('Valor',trim($rowValues[33] ?? ''))->first('id');
                                                  $key['ESTADO_IMPUTADO']=DB::table('catrespuestas')->where('idTipoRespuesta',22)->where('Valor',trim($rowValues[34] ?? ''))->first('id');                                
                                                  $key['TIPO_DETENCION']=DB::table('catrespuestas')->where('idTipoRespuesta',23)->where('Valor',trim($rowValues[37] ?? ''))->first('id');
                                                  $key['ENTIDAD_DETENCION_IMPUTADOS']=DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[38] ?? ''))->first('id');
                                                  $key['AUTORIDAD_DETENCION_IMPUTADOS']
                                                      =DB::table('catrespuestas')->where('idTipoRespuesta',24)->where('Valor',trim($rowValues[39] ?? ''))->first('id');
                                                  $key['RAZON_RND']=DB::table('catrespuestas')->where('idTipoRespuesta',73)->where('Valor',trim($rowValues[41] ?? ''))->first('id');
                                                  $key['EXAMEN_DETENCION_IMPUTADOS']=DB::table('catrespuestas')->where('idTipoRespuesta',74)->where('Valor',trim($rowValues[42] ?? ''))->first('id');
                                                  $key['LESIONADO']=DB::table('catrespuestas')->where('idTipoRespuesta',2)->where('Valor',trim($rowValues[43] ?? ''))->first('id');
                                                  $key['ESTADO_PRESENTACION']=DB::table('catrespuestas')->where('idTipoRespuesta',75)->where('Valor',trim($rowValues[44] ?? ''))->first('id');
                                                #endregion
                                                $de_IM = datos_expediente\de_imputados::updateOrCreate(
                                                  ['idExpediente'=> $idExpediente->idExpediente,
                                                  'NOMBRE_IMPUTADO'=> $rowValues[9] ?? '',
                                                  'PRIMER_APELLIDO'=> $rowValues[10] ?? '',
                                                  'SEGUNDO_APELLIDO_IMPUTADOS'=> $rowValues[11] ?? '',],
                                                  ['INTERPRETE'=> -1,
                                                  'TIPO_IMPUTADO'=> $key['TIPO_IMPUTADO']->id ?? -1,
                                                  'RAZON_SOCIAL'=> $rowValues[2] ?? '',
                                                  'REL_PERS_MORAL'=>  $key['REL_PERS_MORAL']->id ?? -1,
                                                  'SECTOR_IMPUTADOS'=> $key['SECTOR_IMPUTADOS']->id ?? -1,
                                                  'TIPO_PERSONA_IMPUTADOS'=> $key['TIPO_PERSONA_IMPUTADOS']->id ?? -1,
                                                  'DELITOS_IMPUTADO'=> $key['DELITOS_IMPUTADO']->id ?? -1,
                                                  'ALIAS_IMPUTADO'=> $rowValues[7] ?? '',
                                                  'RELACION_VICTIMA'=> $key['RELACION_VICTIMA']->id ?? -1,                                                  
                                                  'CURP_IMPUTADOS'=> $rowValues[12] ?? '',
                                                  'FECHA_NACIMIENTO_IMPUTADOS'=> strtotime($rowValues[13] ?? '') ? date('Y-m-d',strtotime($rowValues[13])): '',
                                                  'EDAD_HECHOS_IMPUTADOS'=> $rowValues[14] ?? '',
                                                  'SEXO_IMPUTADO'=> $key['SEXO_IMPUTADO']->id ?? -1,
                                                  'SITUACION_CONYUGAL_IMPUTADOS'=> $key['SITUACION_CONYUGAL_IMPUTADOS']->id ?? -1,
                                                  'NACIONALIDAD'=> $key['NACIONALIDAD']->id ?? -1,
                                                  'SITUACION_MIGRATORIA_IMPUTADOS'=> $key['SITUACION_MIGRATORIA_IMPUTADOS']->id ?? -1,
                                                  'PAIS_NACIMIENTO'=> $key['PAIS_NACIMIENTO']->id ?? -1,
                                                  'ENTIDAD_NACIMIENTO_IMPUTADOS'=> $key['ENTIDAD_NACIMIENTO_IMPUTADOS']->id ?? -1,
                                                  'MUNICIPIO_NACIMIENTO'=> $key['MUNICIPIO_NACIMIENTO']->id ?? -1,
                                                  'PAIS_RESIDENCIA'=> $key['PAIS_RESIDENCIA']->id ?? -1,
                                                  'ENTIDAD_RESIDENCIA_IMPUTADOS'=> $key['ENTIDAD_RESIDENCIA_IMPUTADOS']->id ?? -1,
                                                  'MUNICIPIO_RESIDENCIA'=> $key['MUNICIPIO_RESIDENCIA']->id ?? -1,
                                                  'TELEFONO_IMPUTADOS'=> str_replace(' ', '',$rowValues[25] ?? ''),
                                                  'TRADUCTOR_IMPUTADO'=> $key['TRADUCTOR_IMPUTADO']->id ?? -1,
                                                  'DISCAPACIDAD_IMPUTADOS'=> $key['DISCAPACIDAD_IMPUTADOS']->id ?? -1,
                                                  'TIPO_DISCAPACIDAD_IMPUTADOS'=> $key['TIPO_DISCAPACIDAD_IMPUTADOS']->id ?? -1,
                                                  'INTERPRETE_POR_DISCAPACIDAD_IMPUTADO'=> $key['INTERPRETE_POR_DISCAPACIDAD_IMPUTADO']->id ?? -1,
                                                  'POBLACION_CALLE'=> $key['POBLACION_CALLE']->id ?? -1,
                                                  'LEER_ESCRIBIR_IMPUTADOS'=> $key['LEER_ESCRIBIR_IMPUTADOS']->id ?? -1,
                                                  'ESCOLARIDAD_IMPUTADO'=> $key['ESCOLARIDAD_IMPUTADO']->id ?? -1,
                                                  'SE_IDENTIFICA_INDIGENA_IMPUTADO'=> -1,
                                                  'INDIGENA_IMPUTADO'=> -1,
                                                  'DETENIDO_IMPUTADOS'=> $key['DETENIDO_IMPUTADOS']->id ?? -1,
                                                  'ESTADO_IMPUTADO'=> $key['ESTADO_IMPUTADO']->id ?? -1,
                                                  'FECHA_DETENCION'=> strtotime($rowValues[35] ?? '') ? date('Y-m-d',strtotime($rowValues[35])): '',
                                                  'HORA_DETENCION'=> strtotime($rowValues[36] ?? '') ? date('H:i',strtotime($rowValues[36])) : '',
                                                  'TIPO_DETENCION'=> $key['TIPO_DETENCION']->id ?? -1,
                                                  'ENTIDAD_DETENCION_IMPUTADOS'=> $key['ENTIDAD_DETENCION_IMPUTADOS']->id ?? -1,
                                                  'AUTORIDAD_DETENCION_IMPUTADOS'=> $key['AUTORIDAD_DETENCION_IMPUTADOS']->id ?? -1,
                                                  'FOLIO_RND'=> $rowValues[40] ?? '',
                                                  'RAZON_RND'=> $key['RAZON_RND']->id ?? -1,
                                                  'EXAMEN_DETENCION_IMPUTADOS'=> $key['EXAMEN_DETENCION_IMPUTADOS']->id ?? -1,
                                                  'LESIONADO'=> $key['LESIONADO']->id ?? -1,
                                                  'ESTADO_PRESENTACION'=> $key['ESTADO_PRESENTACION']->id ?? -1,
                                                  'ANTECEDENTES'=> -1,
                                                  'DEFENSA'=> -1,
                                                  'DOMICILIO_IMPUTADO'=> null,
                                                  'GRADO_DE_PARTICIPACION'=> -1,
                                                  'HABLA_ESPAÑOL_IMPUTADO'=> -1,
                                                  'HABLA_LENG_EXTR_IMPUTADO'=> -1,
                                                  'HABLA_LENG_INDIG_IMPUTADO'=> -1,
                                                  // 'IMPUTADO_ID'=> $rowValues[8] ?? '',
                                                  'MEDIA_FILIACION_IMPUTADO'=> null,
                                                  'NOMBRE_DE_GRUPO'=> null,
                                                  'OCUPACION_IMPUTADO'=> -1,
                                                  'INGRESO_IMPUTADO'=> null,
                                                  'REPRESENTANTE_LEGAL'=>null,
                                                  'TIPO_REPRESENTANTE_LEGAL'=> null,
                                                  'TIPO_DEFENSA'=> -1,
                                                  'TIPO_LENGUA_EXTRANJERA_IMPUTADO'=> -1,
                                                  'LENGUA_IMPUTADO'=> -1,
                                                  'TIPO_MANDAMIENTO'=> -1,
                                                  'IMPUTADO_CONOCIDO' => -1,
                                                  ]
                                                  );
                                                if (($key['DETENIDO_IMPUTADOS']->id ?? -1) > 0) {
                                                 $upd=datos_expediente\de_datosgenerales::where('id', '=',$idExpediente->idExpediente)->firstOrFail();
                                                 $upd->FORMA_ =1;
                                                 $upd->save();
                                                }                                                   
                                               }
                                              }
                                            }
                                          }
                                      }
                                  }
                              }
                              if ($sheet2->getName()=='base_delitos'){
                                  foreach ($sheet2->getRowIterator() as $k=>$row) {
                                    $insertarD=true;
                                      $rowValues = array_map(function($cell) {
                                              return $cell->getValue();
                                          }, $row->getCells());        

                                      if($k>0 && ($rowValues[0]??'')!='NUC' && ($rowValues[11]??'')!='NO_EXPEDIENTE'){
                                          if (isset($rowValues[0],$rowValues[11])) {
                                             $idExpediente = datos_expediente\de_datosgenerales::where('NO_EXPEDIENTE', '=', $rowValues[11])
                                              ->Where('NUC_COMPLETA', '=', $rowValues[0])->first();                                
                                              $idExpedienteArray[1][]=$idExpediente;
                                            if ($idExpediente) {
                                              if ($idExpediente->idExpediente > 0) {
                                               $idDelito = datos_expediente\de_hechos::where('idExpediente','=', $idExpediente->idExpediente)->first(); 
                                               if ($idDelito) {
                                                if ($idDelito->idExpediente > 0) {    
                                                 if (in_array($rowValues[0],$NUCR_base_carpetas2)) {
                                                  $insertarD=false;
                                                 }
                                                }
                                               }

                                               
                                               if ($insertarD) {
                                                  $key=[];
                                                #region catálogos
                                                  ////4 =SiNoNoI                                                                    
                                                  $key['DELITO']=DB::table('catdelitosespecificos')->where('Valor',str_replace('_', ' ',$rowValues[3] ?? ''))->first('id');
                                                  $key['CONSUMACION']=DB::table('catrespuestas')->where('idTipoRespuesta',5)->where('Valor',trim($rowValues[4] ?? ''))->first('id');
                                                  $key['MODALIDAD']=DB::table('catrespuestas')->where('idTipoRespuesta',6)->where('Valor',trim($rowValues[5] ?? ''))->first('id');
                                                  $key['INSTRUMENTO']=DB::table('catrespuestas')->where('idTipoRespuesta',7)->where('Valor',trim($rowValues[6] ?? ''))->first('id');
                                                  $key['FUERO']=DB::table('catrespuestas')->where('idTipoRespuesta',8)->where('Valor',trim($rowValues[7] ?? ''))->first('id');
                                                  $key['TIPO_SITIO_OCURRENCIA']=DB::table('catrespuestas')->where('idTipoRespuesta',9)->where('Valor',trim($rowValues[8] ?? ''))->first('id');
                                                  $key['CALIFICACION']=DB::table('catrespuestas')->where('idTipoRespuesta',10)->where('Valor',trim($rowValues[9] ?? ''))->first('id');
                                                  $key['COMISION']=DB::table('catrespuestas')->where('idTipoRespuesta',11)->where('Valor',trim($rowValues[10] ?? ''))->first('id');

                                                #endregion
                                                $de_IM = datos_expediente\de_hechos::updateOrCreate(
                                                  ['idExpediente'=> $idExpediente->idExpediente,
                                                  'DELITO' => $key['DELITO']->id ?? -1,],
                                                  [
                                                  'DELITO_JUR' => -1,
                                                  'CONSUMACION' => $key['CONSUMACION']->id ?? -1,                                         
                                                  'MODALIDAD' => $key['MODALIDAD']->id ?? -1, 
                                                  'INSTRUMENTO' => $key['INSTRUMENTO']->id ?? -1, 
                                                  'FUERO' => $key['FUERO']->id ?? -1, 
                                                  'TIPO_SITIO_OCURRENCIA' => $key['TIPO_SITIO_OCURRENCIA']->id ?? -1, 
                                                  'CALIFICACION' => $key['CALIFICACION']->id ?? -1, 
                                                  'COMISION' => $key['COMISION']->id ?? -1, 
                                                  'CONTEXTO' => -1, 
                                                  'FORMA_ACCION' => -1
                                                  ]
                                                  );                               
                                               }
                                              }
                                            }
                                          }
                                      }
                                  }                    
                              }
                              if ($sheet2->getName()=='base_victimas'){
                                  foreach ($sheet2->getRowIterator() as $k=>$row) {
                                    $insertarV=true;
                                      $rowValues = array_map(function($cell) {
                                              return $cell->getValue();
                                          }, $row->getCells());

                                      if($k>0 && ($rowValues[0]??'')!='NUC' && ($rowValues[1]??'')!='TIPO' && ($rowValues[2]??'')!='DELITOS'){
                                          if (isset($rowValues[0])) {
                                             $idExpediente = datos_expediente\de_datosgenerales::where('NUC_COMPLETA', '=', $rowValues[0])->first();
                                              $idExpedienteArray[2][]=$idExpediente;
                                            if ($idExpediente) {
                                              if ($idExpediente->idExpediente > 0) {
                                               $idVictima = datos_expediente\de_victimas::where('idExpediente','=', $idExpediente->idExpediente)->first(); 
                                               if ($idVictima) {
                                                if ($idVictima->idExpediente > 0) {   
                                                 if (in_array($rowValues[0],$NUCR_base_carpetas2)) {
                                                  $insertarV=false;
                                                 }
                                                }
                                               }                             
                                               if ($insertarV) { 
                                                  $key=[];
                                                #region catálogos
                                                  ////4 =SiNoNoI                                
                                                  $key['TIPO_VICTIMA']=DB::table('catrespuestas')->where('idTipoRespuesta',13)->where('Valor',trim($rowValues[1] ?? ''))->first('id');
                                                  $key['DELITOS_VICTIMA']=DB::table('catrespuestas')->where('idTipoRespuesta',14)->where('Valor',trim($rowValues[2] ?? ''))->first('id');
                                                  $key['SECTOR_VICTIMAS']=DB::table('catrespuestas')->where('idTipoRespuesta',15)->where('Valor',trim($rowValues[5] ?? ''))->first('id');
                                                  $key['TIPO_PERSONA_VICTIMAS']=DB::table('catrespuestas')->where('idTipoRespuesta',16)->where('Valor',trim($rowValues[6] ?? ''))->first('id');
                                                  $key['SEXO_VICTIMA']=DB::table('catrespuestas')->where('idTipoRespuesta',17)->where('Valor',trim($rowValues[13] ?? ''))->first('id');
                                                  $key['SITUACION_CONYUGAL_VICTIMAS']
                                                  =DB::table('catrespuestas')->where('idTipoRespuesta',18)->where('Valor',trim($rowValues[14] ?? ''))->first('id');
                                                  $key['NACIONALIDAD']=DB::table('catpaises')->where('Valor',trim($rowValues[15] ?? ''))->first('id');
                                                  $key['SITUACION_MIGRATORIA_VICTIMAS']
                                                  =DB::table('catrespuestas')->where('idTipoRespuesta',1)->where('Valor',trim($rowValues[16] ?? ''))->first('id');
                                                  $key['PAIS_NACIMIENTO']=DB::table('catpaises')->where('Valor',trim($rowValues[17] ?? ''))->first('id');
                                                  $key['ENTIDAD_NACIMIENTO_VICTIMAS']=DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[18] ?? ''))->first('id');
                                                  $key['MUNICIPIO_NACIMIENTO']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[19] ?? ''))->first('id');        
                                                  $key['PAIS_RESIDENCIA']=DB::table('catpaises')->where('Valor',trim($rowValues[20] ?? ''))->first('id');
                                                  $key['ENTIDAD_RESIDENCIA_VICTIMAS']=DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[21] ?? ''))->first('id');
                                                  $key['MUNICIPIO_RESIDENCIA']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[22] ?? ''))->first('id');
                                                  
                                                  $key['TRADUCTOR_VICTIMA']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[24] ?? ''))->first('id');
                                                  $key['DISCAPACIDAD_VICTIMAS']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[25] ?? ''))->first('id');
                                                  $key['TIPO_DISCAPACIDAD_VICTIMAS']=DB::table('catrespuestas')->where('idTipoRespuesta',19)->where('Valor',trim($rowValues[26] ?? ''))->first('id');
                                                  $key['INTERPRETE_POR_DISCAPACIDAD_VICTIMA']
                                                      =DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[27] ?? ''))->first('id');
                                                  $key['POBLACION_CALLE']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[28] ?? ''))->first('id');
                                                  $key['LEER_ESCRIBIR']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[29] ?? ''))->first('id');
                                                  $key['ESCOLARIDAD']=DB::table('catrespuestas')->where('idTipoRespuesta',20)->where('Valor',trim($rowValues[30] ?? ''))->first('id');
                                                  $key['OCUPACION']=DB::table('catocupaciones')->where('Valor',trim($rowValues[31] ?? ''))->first('id');
                                                  $key['RELACION_IMPUTADO']=DB::table('catrespuestas')->where('idTipoRespuesta',21)->where('Valor',trim($rowValues[32] ?? ''))->first('id');    
                                                #endregion
                                                  
                                                $de_IM = datos_expediente\de_victimas::updateOrCreate(
                                                  ['idExpediente'=> $idExpediente->idExpediente,
                                                   'NOMBRE_VICTIMA' => $rowValues[7] ?? '',
                                                   'PRIMER_APELLIDO' => $rowValues[8] ?? '',
                                                   'SEGUNDO_APELLIDO_VICTIMAS' => $rowValues[9] ?? '',],
                                                  [
                                                  'TIPO_VICTIMA' => $key['TIPO_VICTIMA']->id ?? -1,
                                                  'INTERPRETE' => -1,
                                                  'DELITOS_VICTIMA' => $key['DELITOS_VICTIMA']->id ?? -1,
                                                  'RAZON_SOCIAL' => $rowValues[3] ?? '',
                                                  'REPRESENTANTE_LEGAL' => $rowValues[4] ?? '',
                                                  'TIPO_REPRESENTANTE_LEGAL' => null,
                                                  'SECTOR_VICTIMAS' => $key['SECTOR_VICTIMAS']->id ?? -1,
                                                  'TIPO_PERSONA_VICTIMAS' => $key['TIPO_PERSONA_VICTIMAS']->id ?? -1,                                                  
                                                  'CURP_VICTIMAS' => $rowValues[10] ?? '',
                                                  'EDAD_HECHOS_VICTIMAS' => $rowValues[12] ?? '',
                                                  'SEXO_VICTIMA' => $key['SEXO_VICTIMA']->id ?? -1,
                                                  'SITUACION_CONYUGAL_VICTIMAS' => $key['SITUACION_CONYUGAL_VICTIMAS']->id ?? -1,
                                                  'NACIONALIDAD' => $key['NACIONALIDAD']->id ?? -1,
                                                  'SITUACION_MIGRATORIA_VICTIMAS' => $key['SITUACION_MIGRATORIA_VICTIMAS']->id ?? -1,
                                                  'PAIS_NACIMIENTO' => $key['PAIS_NACIMIENTO']->id ?? -1,
                                                  'ENTIDAD_NACIMIENTO_VICTIMAS' => $key['ENTIDAD_NACIMIENTO_VICTIMAS']->id ?? -1,
                                                  'MUNICIPIO_NACIMIENTO' => $key['MUNICIPIO_NACIMIENTO']->id ?? -1,
                                                  'PAIS_RESIDENCIA' => $key['PAIS_RESIDENCIA']->id ?? -1,
                                                  'ENTIDAD_RESIDENCIA_VICTIMAS' => $key['ENTIDAD_RESIDENCIA_VICTIMAS']->id ?? -1,
                                                  'MUNICIPIO_RESIDENCIA' => $key['MUNICIPIO_RESIDENCIA']->id ?? -1,
                                                  'TELEFONO_VICTIMAS' => str_replace(' ', '',$rowValues[23] ?? ''),
                                                  'TRADUCTOR_VICTIMA' => $key['TRADUCTOR_VICTIMA']->id ?? -1,
                                                  'DISCAPACIDAD_VICTIMAS' => $key['DISCAPACIDAD_VICTIMAS']->id ?? -1,
                                                  'TIPO_DISCAPACIDAD_VICTIMAS' => $key['TIPO_DISCAPACIDAD_VICTIMAS']->id ?? -1,
                                                  'INTERPRETE_POR_DISCAPACIDAD_VICTIMA' => $key['INTERPRETE_POR_DISCAPACIDAD_VICTIMA']->id ?? -1,
                                                  'POBLACION_CALLE' => $key['POBLACION_CALLE']->id ?? -1,
                                                  'LEER_ESCRIBIR' => $key['LEER_ESCRIBIR']->id ?? -1,
                                                  'ESCOLARIDAD' => $key['ESCOLARIDAD']->id ?? -1,
                                                  'OCUPACION' => $key['OCUPACION']->id ?? -1,
                                                  'SE_IDENTIFICA_INDIGENA_VICTIMA' => -1,
                                                  'POBLACION_INDIGENA_VICTIMA' => -1,
                                                  'RELACION_IMPUTADO' => $key['RELACION_IMPUTADO']->id ?? -1,
                                                  'FECHA_NACIMIENTO_VICTIMAS' => strtotime($rowValues[11] ?? '') ? date('Y-m-d',strtotime($rowValues[11])): '',
                                                  'ASESORIA' => -1,
                                                  'ATEN_MEDICA' => -1,
                                                  'ATEN_PSICOLOGICA' => -1,
                                                  'DOMICILIO_VICTIMA' => null,
                                                  'HABLA_ESPAÑOL_VICTIMA' => -1,
                                                  'HABLA_LENG_EXTR_VICTIMA' => -1,
                                                  'HABLA_LENG_INDIG_VICTIMA' => -1,
                                                  'NUMERO_DE_ATENCION' => $idExpediente->idExpediente,
                                                  'INGRESO_VICTIMA' => null,
                                                  'TIPO_DE_ASESORIA' => -1,
                                                  'TIPO_LENGUA_EXTRANJERA_VICTIMA' => -1,
                                                  'LENGUA_VICTIMA' => -1,
                                                  'VESTIMENTA_VICTIMA' => null,
                                                  'VICTIMA_VIOLENCIA' => -1,
                                                  ]
                                                  );                                    
                                               }
                                              }
                                            }
                                          }
                                      }
                                  }
                              }
                            }
                            //}                              
                        }
                        else
                        {
                            $NUCR_base_carpetas[$i]['NUC'] = $rowValues[6] ?? '';
                            $NUCR_base_carpetas[$i]['NUC_COMPLETA'] = $rowValues[8] ?? '';
                            $NUCR_base_carpetas2[] = $rowValues[8] ?? '';
                            $i++;                                                  
                        }   
                    }
                  }
                }
            }
          } 

          $reader3->open($path);
          $sheets3=$reader3->getSheetIterator();          
          foreach ($sheets3 as $sheet3) {
            if ($sheet3->getName()=='base_hechos_no_delictivos'){
                $key=[];                
                foreach ($sheet3->getRowIterator() as $k=>$row) {
                    // $cellValues[] = array_map(function($cell) {
                    //         return $cell->getValue();
                    //     }, $row->getCells());
                    $rowValues = array_map(function($cell) {
                            return $cell->getValue();
                        }, $row->getCells());
                    if($k>0 && ($rowValues[0]??'')!='DELEGACION' && ($rowValues[1]??'')!='MUNICIPIO' && ($rowValues[6]??'')!='NO_EXPEDIENTE'){
                        if (isset($rowValues[6])) {
                            $key=[];
                          #region catálogos
                            $key['DELEGACION']=DB::table('catdelegaciones')->where('Valor',trim($rowValues[0] ?? ''))->first('id');
                            $key['MUNICIPIO']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[1] ?? ''))->first('id');
                            $key['UNIDAD_ATENCION_NO_DELICTIVOS']=DB::table('catuats')->where('Valor',trim($rowValues[2] ?? ''))->first('id');
                            $key['RECIBIDA_POR']=DB::table('catrespuestas')->where('idTipoRespuesta',12)->where('Valor',trim($rowValues[8] ?? ''))->first('id');

                            $key['ENTIDAD_HECHOS_NO_DELICTIVOS']=DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[9] ?? ''))->first('id');
                            $key['MUNICIPIO_HECHOS']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[10] ?? ''))
                              ->where('CVE_ENT',$key['ENTIDAD_HECHOS_NO_DELICTIVOS']->id ?? -1)->first('id');
                            //$key['COLONIA_HECHOS']=DB::table('catcolonias')->where('Valor',trim($rowValues[11] ?? ''))->where('idMunicipio',$key['MUNICIPIO_HECHOS']->id ?? -1)->first('id');
                            $key['HECHO_NO_DELITO']=DB::table('catrespuestas')->where('idTipoRespuesta',70)->where('Valor',trim($rowValues[46] ?? ''))->first('id');
                          #enregion
                            $nd_DG = no_delictivos\nd_datosgenerales::firstOrCreate(
                            [ 'NO_EXPEDIENTE' => $rowValues[6] ?? ''],
                                [
                                'DELEGACION' => $key['DELEGACION']->id ?? -1, 
                                'UNIDAD_ATENCION_NO_DELICTIVOS'=>$key['UNIDAD_ATENCION_NO_DELICTIVOS']->id ?? -1,
                                'FECHA_INICIO'=>strtotime($rowValues[3] ?? '') ? date('Y-m-d',strtotime($rowValues[3])): '', 
                                'MUNICIPIO'=>$key['MUNICIPIO']->id ?? -1,
                                'FECHA_HECHOS_NO_DELICTIVOS'=>strtotime($rowValues[4] ?? '') ? date('Y-m-d',strtotime($rowValues[4])): '',
                                'HORA_HECHOS'=> strtotime($rowValues[5] ?? '') ? date('H:i',strtotime($rowValues[5])) : '',
                                'RECIBIDA_POR' =>$key['RECIBIDA_POR']->id ?? -1, 
                                'UNIDAD_QUE_RECIBE'=>$rowValues[7] ?? '',
                                'HECHO_NO_DELITO'=>$key['HECHO_NO_DELITO']->id ?? -1,
                                'CAUSA_MUERTE'=>$rowValues[47] ?? '',
                                'MOTIVO'=>$rowValues[48] ?? '',
                                'MEDIO_UTILIZADO'=>$rowValues[49] ?? '',
                                'ENTIDAD_HECHOS_NO_DELICTIVOS'=>$key['ENTIDAD_HECHOS_NO_DELICTIVOS']->id ?? -1, 
                                'MUNICIPIO_HECHOS'=>$key['MUNICIPIO_HECHOS']->id ?? -1, 
                                'COLONIA_HECHOS'=>trim($rowValues[11] ?? ''),
                                'CALLE_HECHOS_NO_DELICTIVOS'=>$rowValues[12] ?? '', 
                                'CP'=>substr($rowValues[13] ?? '',0,5), 
                                'REF_1'=>$rowValues[14] ?? '', 
                                'REF_2'=>$rowValues[15] ?? '', 
                                'DESCRIPCION'=>null,//$rowValues[47] ?? ''.' '.$rowValues[48] ?? ''.' '.$rowValues[49] ?? '', 
                                'OBSERVACIONES' => $rowValues[45] ?? '',
                                ]
                            );
                            if ($nd_DG->wasRecentlyCreated) {
                               $upd=no_delictivos\nd_datosgenerales::where('id', '=',$nd_DG->id)->firstOrFail();
                               $upd->idExpediente=$nd_DG->id;
                               $upd->save();
                               $relUsuExp=relusuarioexpedientes::create(
                                ['idUsuario' => Auth::User()->id,
                                'idExpediente' => $nd_DG->id,
                                'tabla' => 'prond_datosgenerales',
                                'Activo' => 1]);
                               $bitEvUsu=biteventousario::create(
                                ['idUsuario' => Auth::User()->id,
                                'idExpediente' => $nd_DG->id,
                                'idRegistro' => 0,
                                'idEvento' => 51,
                                'Evento' =>'Insertar Expediente No delictivo']);
                                 $key=[];
                              if (empty(trim($rowValues[16] ?? '')) && empty(trim($rowValues[17] ?? '')) &&
                                empty(trim($rowValues[18] ?? '')) && empty(trim($rowValues[19] ?? '')) &&
                                empty(trim($rowValues[20] ?? '')) && empty(trim($rowValues[21] ?? '')) &&
                                empty(trim($rowValues[22] ?? '')) && empty(trim($rowValues[23] ?? '')) &&
                                empty(trim($rowValues[24] ?? '')) && empty(trim($rowValues[25] ?? '')) &&
                                empty(trim($rowValues[26] ?? '')) && empty(trim($rowValues[27] ?? '')) &&

                                empty(trim($rowValues[28] ?? '')) && empty(trim($rowValues[29] ?? '')) && empty(trim($rowValues[30] ?? '')) &&
                                empty(trim($rowValues[31] ?? '')) && empty(trim($rowValues[32] ?? '')) && empty(trim($rowValues[33] ?? '')) &&
                                empty(trim($rowValues[34] ?? '')) && empty(trim($rowValues[35] ?? '')) && empty(trim($rowValues[36] ?? '')) &&

                                empty(trim($rowValues[37] ?? '')) && empty(trim($rowValues[38] ?? '')) && empty(trim($rowValues[39] ?? '')) &&
                                empty(trim($rowValues[40] ?? '')) && empty(trim($rowValues[41] ?? '')) && empty(trim($rowValues[42] ?? '')) &&
                                empty(trim($rowValues[43] ?? '')) && empty(trim($rowValues[44] ?? '')) && empty(trim($rowValues[50] ?? '')) ) {
                               // code...
                              }
                              else
                              {
                                #region catálogos    
                                  $key['OBJETO_1']=DB::table('catrespuestas')->where('idTipoRespuesta',25)->where('Valor',trim($rowValues[16] ?? ''))->first('id');
                                  $key['OBJETO_2']=DB::table('catrespuestas')->where('idTipoRespuesta',25)->where('Valor',trim($rowValues[20] ?? ''))->first('id');
                                  $key['OBJETO_3']=DB::table('catrespuestas')->where('idTipoRespuesta',25)->where('Valor',trim($rowValues[24] ?? ''))->first('id');
                                  $key['ESTATUS_NO_DELICTIVOS']=DB::table('catrespuestas')->where('idTipoRespuesta',77)->where('Valor',trim($rowValues[37] ?? ''))->first('id');
                                  $key['TIPO_NARCOTICO_1']=DB::table('catrespuestas')->where('idTipoRespuesta',26)->where('Valor',trim($rowValues[28] ?? ''))->first('id');
                                  $key['TIPO_NARCOTICO_2']=DB::table('catrespuestas')->where('idTipoRespuesta',26)->where('Valor',trim($rowValues[31] ?? ''))->first('id');
                                  $key['TIPO_NARCOTICO_3']=DB::table('catrespuestas')->where('idTipoRespuesta',26)->where('Valor',trim($rowValues[34] ?? ''))->first('id');
                                #endregion
                                  $nd_OB=new no_delictivos\nd_objetos([
                                      'idExpediente' => $nd_DG->id,
                                      'OBJETO_1' => $key['OBJETO_1']->id ?? -1,
                                      'DESC_OBJ_1' => $rowValues[17] ?? '',
                                      'CANT_OBJ_1' => $rowValues[18] ?? '',
                                      'VALOR_OBJ_1' => $rowValues[19] ?? '',
                                      'OBJETO_2' => $key['OBJETO_2']->id ?? -1,
                                      'DESC_OBJ_2' => $rowValues[21] ?? '',
                                      'CANT_OBJ_2' => $rowValues[22] ?? '',
                                      'VALOR_OBJ_2' => $rowValues[23] ?? '',
                                      'OBJETO_3' => $key['OBJETO_3']->id ?? -1,
                                      'DESC_OBJ_3' => $rowValues[25] ?? '',
                                      'CANT_OBJ_3' => $rowValues[26] ?? '',
                                      'VALOR_OBJ_3' => $rowValues[27] ?? '',  
                                  'TIPO_NARCOTICO_1' => $key['TIPO_NARCOTICO_1']->id ?? -1,
                                  'CANTIDAD_NARCO_1' => $rowValues[29] ?? '',                                
                                  'GRAMAJE_NARCO_1' => $rowValues[30] ?? '',
                                  'TIPO_NARCOTICO_2' => $key['TIPO_NARCOTICO_2']->id ?? -1,                                
                                  'CANTIDAD_NARCO_2' => $rowValues[32] ?? '',
                                  'GRAMAJE_NARCO_2' => $rowValues[33] ?? '',
                                  'TIPO_NARCOTICO_3' => $key['TIPO_NARCOTICO_3']->id ?? -1,                                
                                  'CANTIDAD_NARCO_3' => $rowValues[35] ?? '',
                                  'GRAMAJE_NARCO_3' => $rowValues[36] ?? '',
                                      'ESTATUS_NO_DELICTIVOS' => $key['ESTATUS_NO_DELICTIVOS']->id ?? -1,
                                      'MARCA_NO_DELICTIVOS' => $rowValues[38] ?? '',
                                      'MODELO_NO_DELICTIVOS' => $rowValues[39] ?? '',
                                      'COLOR_NO_DELICTIVOS' => $rowValues[40] ?? '',
                                      'TIPO_NO_DELICTIVOS' => $rowValues[41] ?? '',
                                      'PLACA_NO_DELICTIVOS' => $rowValues[42] ?? '',
                                      'NUMERO_NO_DELICTIVOS' => $rowValues[43] ?? '',
                                      'ESTADO_PLACAS_NO_DELICTIVOS' => $rowValues[44] ?? '',
                                  'LUGAR_VEHICULO_NO_DELICTIVOS' => $rowValues[50] ?? '',
                                  ]);       
                                  $nd_OB->save();
                              }
                                $reader4->open($path);
                                $sheets4=$reader4->getSheetIterator();
                                foreach ($sheets4 as $sheet4) {
                                  if ($sheet4->getName()=='base_victimas_hechos'){
                                      foreach ($sheet4->getRowIterator() as $k=>$row) {
                                        $insertarV=true;
                                          $rowValues = array_map(function($cell) {
                                                  return $cell->getValue();
                                              }, $row->getCells());
                                          if($k>0 && ($rowValues[0]??'')!='NO_EXPEDIENTE_HECHOS' && ($rowValues[1]??'')!='TIPO_VICTIMA_HECHOS'){
                                              if (isset($rowValues[0])) {
                                                 $idExpediente = no_delictivos\nd_datosgenerales::where('NO_EXPEDIENTE', '=', $rowValues[0])
                                                 ->first();
                                                  $idExpedienteArray[2][]=$idExpediente;
                                                if ($idExpediente) {
                                                  if ($idExpediente->idExpediente > 0) {
                                                   $idVictima = no_delictivos\nd_victimas::where('idExpediente','=', $idExpediente->idExpediente)->first(); 
                                                   if ($idVictima) {
                                                    if ($idVictima->idExpediente > 0) {   
                                                     if (in_array($rowValues[0],$EXPR_base_hechos_no_delictivos)) {
                                                      $insertarV=false;
                                                     }
                                                    }
                                                   }                             
                                                   if ($insertarV) { 
                                                      $key=[];
                                                    #region catálogos
                                                      $key['TIPO_VICTIMA_NO_DELICTIVO']=DB::table('catrespuestas')->where('idTipoRespuesta',13)
                                                        ->where('Valor',trim($rowValues[1] ?? ''))->first('id');
                                                      $key['SEXO']=DB::table('catrespuestas')->where('idTipoRespuesta',17)
                                                        ->where('Valor',trim($rowValues[7] ?? ''))->first('id');
                                                      $key['OCUPACION']=DB::table('catocupaciones')->where('Valor',trim($rowValues[8] ?? ''))->first('id');
                                                      $key['ESCOLARIDAD']=DB::table('catrespuestas')->where('idTipoRespuesta',20)
                                                        ->where('Valor',trim($rowValues[9] ?? ''))->first('id');                                
                                                      $key['SIT_CONYUGAL_VICTIMAS_NO_DELICTIVO']
                                                        =DB::table('catrespuestas')->where('idTipoRespuesta',18)->where('Valor',trim($rowValues[10] ?? ''))
                                                        ->first('id');
                                                      $key['OCCISO']
                                                        =DB::table('catrespuestas')->where('idTipoRespuesta',2)->where('Valor',trim($rowValues[11] ?? ''))
                                                        ->first('id');
                         
                                                    #endregion
                                                    $de_IM = no_delictivos\nd_victimas::updateOrCreate(
                                                      ['idExpediente'=> $idExpediente->idExpediente,
                                                       'NOMBRE_VICTIMA' => $rowValues[2] ?? '',
                                                       'PRIMER_APELLIDO'=>$rowValues[3] ?? '',
                                                       'SEGUNDO_APELLIDO_VICTIMAS_NO_DELICTIVO'=>$rowValues[4] ?? '', ],
                                                      [
                                                      'TIPO_VICTIMA_NO_DELICTIVO' => $key['TIPO_VICTIMA_NO_DELICTIVO']->id ?? -1,
                                                      'EDAD_HECHOS_VICTIMAS' => $rowValues[5] ?? '',
                                                      'FECHA_NACIMIENTO'=> strtotime($rowValues[6] ?? '') ? date('Y-m-d',strtotime($rowValues[6])): '',
                                                      'SEXO' => $key['SEXO']->id ?? -1,
                                                      'SIT_CONYUGAL_VICTIMAS_NO_DELICTIVO' => $key['SIT_CONYUGAL_VICTIMAS_NO_DELICTIVO']->id ?? -1,
                                                      'ESCOLARIDAD' => $key['ESCOLARIDAD']->id ?? -1,
                                                      'OCUPACION' => $key['OCUPACION']->id ?? -1,                                
                                                      'OCCISO' => $key['OCCISO']->id ?? -1, 
                                                      ]
                                                      );                                    
                                                   }
                                                  }
                                                }
                                              }
                                          }
                                      }
                                  }          
                                }                                
                            }
                            else
                            {
                                $EXPR_base_hechos_no_delictivos[] = $rowValues[6] ?? '';                                         
                            }   
                        }
                    }
                }
            }
          }

          $reader5->open($path);
          $sheets5=$reader5->getSheetIterator();
          foreach ($sheets5 as $sheet5) {          
            if ($sheet5->getName()=='base_conduccion'){
                $key=[];
                
                foreach ($sheet5->getRowIterator() as $k=>$row) {
                    // $cellValues[] = array_map(function($cell) {
                    //         return $cell->getValue();
                    //     }, $row->getCells());
                    $rowValues = array_map(function($cell) {
                            return $cell->getValue();
                        }, $row->getCells());
                    
                    if($k>0 && ($rowValues[0]??'')!='DELEGACION' && ($rowValues[1]??'')!='MUNICIPIO' && ($rowValues[6]??'')!='NO_EXPEDIENTE'){
                        if (isset($rowValues[6])) {
                            $key=[];
                          #region catálogos
                            $key['DELEGACION']=DB::table('catdelegaciones')->where('Valor',trim($rowValues[0] ?? ''))->first('id');
                            $key['MUNICIPIO']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[1] ?? ''))->first('id');
                            $key['UNIDAD_ATENCION']=DB::table('catrespuestas')->where('idTipoRespuesta',96)
                              ->where('Valor',str_replace('_', ' ',trim($rowValues[2] ?? '')))->first('id');
                              //DB::table('catuats')->where('Valor',trim($rowValues[2] ?? ''))->first('id');
                            $key['RECIBIDA_POR']=DB::table('catrespuestas')->where('idTipoRespuesta',12)->where('Valor',trim($rowValues[7] ?? ''))->first('id');
                            $key['TIPO_RECEPCION']=DB::table('catrespuestas')->where('idTipoRespuesta',2)->where('Valor',trim($rowValues[10] ?? ''))->first('id');
                            $key['ENTIDAD_HECHOS_CONDUCCION']=DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[11] ?? ''))->first('id');
                            $key['MUNICIPIO_HECHOS']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[12] ?? ''))
                              ->where('CVE_ENT',$key['ENTIDAD_HECHOS_CONDUCCION']->id ?? -1)->first('id');
                            //$key['COLONIA_HECHOS']=DB::table('catcolonias')->where('Valor',trim($rowValues[13] ?? ''))->where('idMunicipio',$key['MUNICIPIO_HECHOS']->id ?? -1)->first('id');

                          #endregion
                            $cc_DG = carpeta_conduccion\cc_datosgenerales::firstOrCreate(
                            [ 'NO_EXPEDIENTE_CONDUCCION' => $rowValues[6] ?? ''],
                                [                                    
                                'DELEGACION' => $key['DELEGACION']->id ?? -1, 
                                'MUNICIPIO'=>$key['MUNICIPIO']->id ?? -1,
                                'UNIDAD_ATENCION'=>$key['UNIDAD_ATENCION']->id ?? -1,
                                'FECHA_INICIO_CONDUCCION'=>strtotime($rowValues[3] ?? '') ? date('Y-m-d',strtotime($rowValues[3])): '',
                                'FECHA_HECHOS_CONDUCCION'=>strtotime($rowValues[4] ?? '') ? date('Y-m-d',strtotime($rowValues[4])): '',
                                'HORA_HECHOS'=> strtotime($rowValues[5] ?? '') ? date('H:i',strtotime($rowValues[5])) : '',
                                'UNIDAD_QUE_RECIBE_CONDUCCION'=>null,//$rowValues[7] ?? '',
                                'RECIBIDA_POR' =>$key['RECIBIDA_POR']->id ?? -1, 
                                'TIPO_RECEPCION' => $key['TIPO_RECEPCION']->id ?? -1,
                                'ENTIDAD_HECHOS_CONDUCCION'=>$key['ENTIDAD_HECHOS_CONDUCCION']->id ?? -1, 
                                'MUNICIPIO_HECHOS'=>$key['MUNICIPIO_HECHOS']->id ?? -1, 
                                'COLONIA_HECHOS'=>trim($rowValues[13] ?? ''), 
                                'CALLE_HECHOS_CONDUCCION'=>$rowValues[14] ?? '', 
                                'CP'=>substr($rowValues[15] ?? '',0,5), 
                                'REF_1'=>$rowValues[16] ?? '', 
                                'REF_2'=>$rowValues[17] ?? '', 
                                'DESCRIPCION'=> $rowValues[47] ?? '',
                                'OBSERVACIONES' => $rowValues[48] ?? '',
                                'AUTORIDAD_IPH' => $rowValues[9] ?? '',
                                ]
                            );
                            if ($cc_DG->wasRecentlyCreated) {
                                 $upd=carpeta_conduccion\cc_datosgenerales::where('id', '=',$cc_DG->id)->firstOrFail();
                                 $upd->idExpediente=$cc_DG->id;
                                 $upd->save();
                                 $relUsuExp=relusuarioexpedientes::create(
                                  ['idUsuario' => Auth::User()->id,
                                  'idExpediente' => $cc_DG->id,
                                  'tabla' => 'procc_datosgenerales',
                                  'Activo' => 1]);
                                 $bitEvUsu=biteventousario::create(
                                  ['idUsuario' => Auth::User()->id,
                                  'idExpediente' => $cc_DG->id,
                                  'idRegistro' => 0,
                                  'idEvento' => 52,
                                  'Evento' =>'Insertar Expediente Carpeta de conducción']);
                                 $key=[];
                              if (empty(trim($rowValues[18] ?? '')) && empty(trim($rowValues[19] ?? '')) &&
                                empty(trim($rowValues[20] ?? '')) && empty(trim($rowValues[21] ?? '')) &&
                                empty(trim($rowValues[22] ?? '')) && empty(trim($rowValues[23] ?? '')) &&
                                empty(trim($rowValues[24] ?? '')) && empty(trim($rowValues[25] ?? '')) &&
                                empty(trim($rowValues[26] ?? '')) && empty(trim($rowValues[27] ?? '')) &&
                                empty(trim($rowValues[28] ?? '')) && empty(trim($rowValues[29] ?? '')) &&

                                empty(trim($rowValues[30] ?? '')) && empty(trim($rowValues[31] ?? '')) && empty(trim($rowValues[32] ?? '')) &&
                                empty(trim($rowValues[33] ?? '')) && empty(trim($rowValues[34] ?? '')) && empty(trim($rowValues[35] ?? '')) &&
                                empty(trim($rowValues[36] ?? '')) && empty(trim($rowValues[37] ?? '')) && empty(trim($rowValues[38] ?? '')) &&

                                empty(trim($rowValues[39] ?? '')) && empty(trim($rowValues[40] ?? '')) && empty(trim($rowValues[41] ?? '')) &&
                                empty(trim($rowValues[42] ?? '')) && empty(trim($rowValues[43] ?? '')) && empty(trim($rowValues[44] ?? '')) &&
                                empty(trim($rowValues[45] ?? '')) && empty(trim($rowValues[46] ?? '')) && empty(trim($rowValues[49] ?? '')) ) {
                               // code...
                              }
                              else
                              {
                                #region catálogos    
                                  $key['OBJETO_1']=DB::table('catrespuestas')->where('idTipoRespuesta',25)->where('Valor',trim($rowValues[18] ?? ''))->first('id');
                                  $key['OBJETO_2']=DB::table('catrespuestas')->where('idTipoRespuesta',25)->where('Valor',trim($rowValues[22] ?? ''))->first('id');
                                  $key['OBJETO_3']=DB::table('catrespuestas')->where('idTipoRespuesta',25)->where('Valor',trim($rowValues[26] ?? ''))->first('id');
                                  $key['TIPO_NARCOTICO_1']=DB::table('catrespuestas')->where('idTipoRespuesta',26)->where('Valor',trim($rowValues[30] ?? ''))->first('id');
                                  $key['TIPO_NARCOTICO_2']=DB::table('catrespuestas')->where('idTipoRespuesta',26)->where('Valor',trim($rowValues[33] ?? ''))->first('id');
                                  $key['TIPO_NARCOTICO_3']=DB::table('catrespuestas')->where('idTipoRespuesta',26)->where('Valor',trim($rowValues[36] ?? ''))->first('id');
                                  $key['ESTATUS']=DB::table('catrespuestas')->where('idTipoRespuesta',77)->where('Valor',trim($rowValues[39] ?? ''))->first('id');
                                #endregion
                                  $cc_OB=new carpeta_conduccion\cc_objetos([
                                      'idExpediente' => $cc_DG->id,
                                      'OBJETO_1' => $key['OBJETO_1']->id ?? -1,
                                      'DESC_OBJ_1' => $rowValues[19] ?? '',
                                      'CANT_OBJ_1' => $rowValues[20] ?? '',
                                      'VALOR_OBJ_1' => $rowValues[21] ?? '',
                                      'OBJETO_2' => $key['OBJETO_2']->id ?? -1,
                                      'DESC_OBJ_2' => $rowValues[23] ?? '',
                                      'CANT_OBJ_2' => $rowValues[24] ?? '',
                                      'VALOR_OBJ_2' => $rowValues[25] ?? '',
                                      'OBJETO_3' => $key['OBJETO_3']->id ?? -1,
                                      'DESC_OBJ_3' => $rowValues[27] ?? '',
                                      'CANT_OBJ_3' => $rowValues[28] ?? '',
                                      'VALOR_OBJ_3' => $rowValues[29] ?? '',   
                                  'TIPO_NARCOTICO_1' => $key['TIPO_NARCOTICO_1']->id ?? -1,                                
                                  'CANTIDAD_NARCO_1' => $rowValues[31] ?? '',
                                  'GRAMAJE_NARCO_1' => $rowValues[32] ?? '',
                                  'TIPO_NARCOTICO_2' => $key['TIPO_NARCOTICO_2']->id ?? -1,                                
                                  'CANTIDAD_NARCO_2' => $rowValues[34] ?? '',
                                  'GRAMAJE_NARCO_2' => $rowValues[35] ?? '',
                                  'TIPO_NARCOTICO_3' => $key['TIPO_NARCOTICO_3']->id ?? -1,
                                  'CANTIDAD_NARCO_3' => $rowValues[37] ?? '',
                                  'GRAMAJE_NARCO_3' => $rowValues[38] ?? '',
                                  'ESTATUS' => $key['ESTATUS']->id ?? -1,
                                  'MARCA' => $rowValues[40] ?? '',
                                  'MODELO' => $rowValues[41] ?? '',
                                  'COLOR' => $rowValues[42] ?? '',
                                  'TIPO' => $rowValues[43] ?? '',
                                  'PLACA' => $rowValues[44] ?? '',
                                  'NUMERO' => $rowValues[45] ?? '',
                                  'ESTADO_PLACAS' => $rowValues[46] ?? '',
                                  'LUGAR_VEHICULO' => $rowValues[49] ?? '',

                                  ]);       
                                  $cc_OB->save();
                              }
                                $reader6->open($path);
                                $sheets6=$reader6->getSheetIterator();
                                foreach ($sheets6 as $sheet6) {
                                  if ($sheet6->getName()=='base_imputados_conduccion'){
                                      foreach ($sheet6->getRowIterator() as $k=>$row) {
                                        $insertarI=true;
                                          $rowValues = array_map(function($cell) {
                                                  return $cell->getValue();
                                              }, $row->getCells());
                                          if($k>0 && ($rowValues[0]??'')!='NO_EXPEDIENTE_CONDUCCION' && ($rowValues[1]??'')!='TIPO_IMPUTADO_CONDUCCION'){
                                              if (isset($rowValues[0])) {
                                                $idExpediente = carpeta_conduccion\cc_datosgenerales::where('NO_EXPEDIENTE_CONDUCCION', '=', $rowValues[0])
                                                ->first();                                

                                                $idExpedienteArray[0][]=$idExpediente;
                                                if ($idExpediente) {
                                                  if ($idExpediente->idExpediente > 0) {
                                                   $idImputado = carpeta_conduccion\cc_imputados::where('idExpediente','=', $idExpediente->idExpediente)
                                                   ->first(); 
                                                   if ($idImputado) {
                                                    if ($idImputado->idExpediente > 0) {    
                                                     if (in_array($rowValues[0],$EXPR_base_conduccion)) {
                                                      $insertarI=false;
                                                     }
                                                    }
                                                   }
                                                   if ($insertarI) {
                                                      $key=[];
                                                    #region catálogos
                                                      ////4 =SiNoNoI                                
                                                      $key['TIPO_IMPUTADO_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',13)->where('Valor',trim($rowValues[1] ?? ''))->first('id');
                                                      $key['REL_PERS_MORAL']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[3] ?? ''))->first('id');
                                                      $key['SECTOR_IMPUTADOS_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',15)->where('Valor',trim($rowValues[4] ?? ''))->first('id');
                                                      $key['TIPO_PERSONA_IMPUTADOS_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',16)->where('Valor',trim($rowValues[5] ?? ''))->first('id');
                                                      $key['DELITOS_IMPUTADO_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',14)->where('Valor',trim($rowValues[6] ?? ''))->first('id');    
                                                      $key['RELACION_VICTIMA']=DB::table('catrespuestas')->where('idTipoRespuesta',21)->where('Valor',trim($rowValues[8] ?? ''))->first('id');
                                                      
                                                      $key['SEXO_IMPUTADO']=DB::table('catrespuestas')->where('idTipoRespuesta',17)->where('Valor',trim($rowValues[15] ?? ''))->first('id');
                                                      
                                                      $key['SITUACION_CONYUGAL_IMPUTADOS_CONDUCCION']
                                                      =DB::table('catrespuestas')->where('idTipoRespuesta',18)->where('Valor',trim($rowValues[16] ?? ''))->first('id');

                                                      $key['NACIONALIDAD']=DB::table('catpaises')->where('Valor',trim($rowValues[17] ?? ''))->first('id');
                                                      $key['SITUACION_MIGRATORIA_IMPUTADOS_CONDUCCION']
                                                      =DB::table('catrespuestas')->where('idTipoRespuesta',1)->where('Valor',trim($rowValues[18] ?? ''))->first('id');
                                                      $key['PAIS_NACIMIENTO']=DB::table('catpaises')->where('Valor',trim($rowValues[19] ?? ''))->first('id');
                                                      $key['ENTIDAD_NACIMIENTO_IMPUTADOS_CONDUCCION']=DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[20] ?? ''))->first('id');
                                                      $key['MUNICIPIO_NACIMIENTO']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[21] ?? ''))->first('id');        
                                                      $key['PAIS_RESIDENCIA']=DB::table('catpaises')->where('Valor',trim($rowValues[22] ?? ''))->first('id');
                                                      $key['ENTIDAD_RESIDENCIA_IMPUTADOS_CONDUCCION']=DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[23] ?? ''))->first('id');
                                                      $key['MUNICIPIO_RESIDENCIA']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[24] ?? ''))->first('id');
                                                      $key['TRADUCTOR_IMPUTADOS_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[26] ?? ''))->first('id');
                                                      $key['DISCAPACIDAD_IMPUTADOS']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[27] ?? ''))->first('id');
                                                      $key['TIPO_DISCAPACIDAD_IMPUTADOS']=DB::table('catrespuestas')->where('idTipoRespuesta',19)->where('Valor',trim($rowValues[28] ?? ''))->first('id');
                                                      $key['INTERPRETE_POR_DISCAPACIDAD_IMPUTADO']
                                                          =DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[29] ?? ''))->first('id');

                                                      $key['POBLACION_CALLE']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[30] ?? ''))->first('id');
                                                      $key['LEER_ESCRIBIR_IMPUTADOS']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[31] ?? ''))->first('id');
                                                      $key['ESCOLARIDAD_IMPUTADO']=DB::table('catrespuestas')->where('idTipoRespuesta',20)->where('Valor',trim($rowValues[32] ?? ''))->first('id');

                                                      $key['DETENIDO_IMPUTADOS_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',2)->where('Valor',trim($rowValues[33] ?? ''))->first('id');   
                                                      $key['ESTADO_IMPUTADO_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',22)->where('Valor',trim($rowValues[34] ?? ''))->first('id');                             
                                                      $key['TIPO_DETENCION_IMPUTADOS_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',23)->where('Valor',trim($rowValues[37] ?? ''))->first('id');
                                                      $key['ENTIDAD_DETENCION_IMPUTADOS_CONDUCCION']=DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[38] ?? ''))->first('id');
                                                      $key['AUTORIDAD_DETENCION_IMPUTADOS_CONDUCCION']
                                                          =DB::table('catrespuestas')->where('idTipoRespuesta',24)->where('Valor',trim($rowValues[39] ?? ''))->first('id');
                                                      $key['RAZON_RND']=DB::table('catrespuestas')->where('idTipoRespuesta',73)->where('Valor',trim($rowValues[41] ?? ''))->first('id');
                                                      $key['EXAMEN_DETENCION_IMPUTADOS_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',74)->where('Valor',trim($rowValues[42] ?? ''))->first('id');
                                                      $key['LESIONADO']=DB::table('catrespuestas')->where('idTipoRespuesta',2)->where('Valor',trim($rowValues[43] ?? ''))->first('id');
                                                      $key['ESTADO_PRESENTACION']=DB::table('catrespuestas')->where('idTipoRespuesta',75)->where('Valor',trim($rowValues[44] ?? ''))->first('id');
                                                    #endregion
                                                    $de_IM = carpeta_conduccion\cc_imputados::updateOrCreate(
                                                      ['idExpediente'=> $idExpediente->idExpediente,
                                                       'NOMBRE_IMPUTADO'=>$rowValues[9] ?? '',
                                                       'PRIMER_APELLIDO'=>$rowValues[10] ?? '',
                                                       'SEGUNDO_APELLIDO_IMPUTADOS_CONDUCCION'=>$rowValues[11] ?? '',],
                                                      [
                                                        'TIPO_IMPUTADO_CONDUCCION'=>$key['TIPO_IMPUTADO_CONDUCCION']->id ?? -1,
                                                        'RAZON_SOCIAL'=>$rowValues[2] ?? '',
                                                        'REL_PERS_MORAL'=>$key['REL_PERS_MORAL']->id ?? -1,
                                                        'SECTOR_IMPUTADOS_CONDUCCION'=>$key['SECTOR_IMPUTADOS_CONDUCCION']->id ?? -1,
                                                        'TIPO_PERSONA_IMPUTADOS_CONDUCCION'=>$key['TIPO_PERSONA_IMPUTADOS_CONDUCCION']->id ?? -1,
                                                        'DELITOS_IMPUTADO_CONDUCCION'=>$key['DELITOS_IMPUTADO_CONDUCCION']->id ?? -1,  
                                                        'ALIAS_IMPUTADO'=>$rowValues[7] ?? '',
                                                        'RELACION_VICTIMA'=>$key['RELACION_VICTIMA']->id ?? -1,     
                                                        'CURP_IMPUTADOS'=> $rowValues[12] ?? '',
                                                        'FECHA_NACIMIENTO_IMPUTADOS'=> strtotime($rowValues[13] ?? '') ? date('Y-m-d',strtotime($rowValues[13])): '',
                                                        'EDAD_HECHOS_IMPUTADOS'=> $rowValues[14] ?? '',
                                                        'SEXO_IMPUTADO'=> $key['SEXO_IMPUTADO']->id ?? -1,
                                                        'SITUACION_CONYUGAL_IMPUTADOS_CONDUCCION'=>$key['SITUACION_CONYUGAL_IMPUTADOS_CONDUCCION']->id ?? -1,  
                                                        'NACIONALIDAD'=>$key['NACIONALIDAD']->id ?? -1,  
                                                        'SITUACION_MIGRATORIA_IMPUTADOS_CONDUCCION'=>$key['SITUACION_MIGRATORIA_IMPUTADOS_CONDUCCION']->id ?? -1,
                                                        'PAIS_NACIMIENTO'=>$key['PAIS_NACIMIENTO']->id ?? -1,  
                                                        'ENTIDAD_NACIMIENTO_IMPUTADOS_CONDUCCION'=>$key['ENTIDAD_NACIMIENTO_IMPUTADOS_CONDUCCION']->id ?? -1,  
                                                        'MUNICIPIO_NACIMIENTO'=>$key['MUNICIPIO_NACIMIENTO']->id ?? -1,
                                                        'PAIS_RESIDENCIA'=>$key['PAIS_RESIDENCIA']->id ?? -1,  
                                                        'ENTIDAD_RESIDENCIA_IMPUTADOS_CONDUCCION'=>$key['ENTIDAD_RESIDENCIA_IMPUTADOS_CONDUCCION']->id ?? -1,  
                                                        'MUNICIPIO_RESIDENCIA'=>$key['MUNICIPIO_RESIDENCIA']->id ?? -1,  
                                                        'TELEFONO_IMPUTADOS_CONDUCCION'=>str_replace(' ', '',$rowValues[25] ?? ''),
                                                        'TRADUCTOR_IMPUTADOS_CONDUCCION'=>$key['TRADUCTOR_IMPUTADOS_CONDUCCION']->id ?? -1,  
                                                        'DISCAPACIDAD_IMPUTADOS'=> $key['DISCAPACIDAD_IMPUTADOS']->id ?? -1,
                                                        'TIPO_DISCAPACIDAD_IMPUTADOS'=> $key['TIPO_DISCAPACIDAD_IMPUTADOS']->id ?? -1,
                                                        'INTERPRETE_POR_DISCAPACIDAD_IMPUTADO'=> $key['INTERPRETE_POR_DISCAPACIDAD_IMPUTADO']->id ?? -1,
                                                        'POBLACION_CALLE'=>$key['POBLACION_CALLE']->id ?? -1,  
                                                        'LEER_ESCRIBIR_IMPUTADOS'=>$key['LEER_ESCRIBIR_IMPUTADOS']->id ?? -1,
                                                        'ESCOLARIDAD_IMPUTADO'=> $key['ESCOLARIDAD_IMPUTADO']->id ?? -1,
                                                        'DETENIDO_IMPUTADOS_CONDUCCION'=>$key['DETENIDO_IMPUTADOS_CONDUCCION']->id ?? -1,  
                                                        'ESTADO_IMPUTADO_CONDUCCION'=>$key['ESTADO_IMPUTADO_CONDUCCION']->id ?? -1,  
                                                        'FECHA_DETENCION_CONDUCCION'=>strtotime($rowValues[35] ?? '') ? date('Y-m-d',strtotime($rowValues[35])): '',
                                                        'HORA_DETENCION'=>strtotime($rowValues[36] ?? '') ? date('H:i',strtotime($rowValues[36])) : '',
                                                        'TIPO_DETENCION_IMPUTADOS_CONDUCCION'=>$key['TIPO_DETENCION_IMPUTADOS_CONDUCCION']->id ?? -1,  
                                                        'ENTIDAD_DETENCION_IMPUTADOS_CONDUCCION'=>$key['ENTIDAD_DETENCION_IMPUTADOS_CONDUCCION']->id ?? -1,  
                                                        'AUTORIDAD_DETENCION_IMPUTADOS_CONDUCCION'=>$key['AUTORIDAD_DETENCION_IMPUTADOS_CONDUCCION']->id ?? -1,  
                                                        'FOLIO_RND'=>$rowValues[40] ?? '',
                                                        'RAZON_RND'=>$key['RAZON_RND']->id ?? -1,  
                                                        'EXAMEN_DETENCION_IMPUTADOS_CONDUCCION'=>$key['EXAMEN_DETENCION_IMPUTADOS_CONDUCCION']->id ?? -1,  
                                                        'LESIONADO'=>$key['LESIONADO']->id ?? -1,  
                                                        'ESTADO_PRESENTACION'=>$key['ESTADO_PRESENTACION']->id ?? -1,  
                                                        'REPRESENTANTE_LEGAL'=>null,
                                                        'INTERPRETE_IMPUTADOS_CONDUCCION'=>-1, 

                                                        'TIPO_REPRESENTANTE_LEGAL'=> null,
                                                        'TIPO_DEFENSA'=> -1,
                                                        'TIPO_LENGUA_EXTRANJERA_IMPUTADO'=> -1,
                                                        'LENGUA_IMPUTADO'=> -1,
                                                        'TIPO_MANDAMIENTO'=> -1,
                                                        'IMPUTADO_CONOCIDO' => -1,
                                                        'DOMICILIO_IMPUTADO'=> null,
                                                        'GRADO_DE_PARTICIPACION'=> -1,
                                                        'HABLA_ESPAÑOL_IMPUTADO'=> -1,
                                                        'HABLA_LENG_EXTR_IMPUTADO'=> -1,
                                                        'HABLA_LENG_INDIG_IMPUTADO'=> -1,
                                                        'INGRESO_IMPUTADO'=> null,  
                                                        'OCUPACION_IMPUTADO'=> -1,
                                                        'SE_IDENTIFICA_INDIGENA_IMPUTADO'=> -1,
                                                        'INDIGENA_IMPUTADO'=> -1,
                                                        'NOMBRE_DE_GRUPO'=> null,
                                                        'ANTECEDENTES'=> -1,
                                                        'DEFENSA'=> -1,
                                                        'MEDIA_FILIACION_IMPUTADO'=> null,
                                                      ]
                                                      );
                                                   }
                                                  }
                                                }
                                              }
                                          }
                                      }
                                  }
                                  if ($sheet6->getName()=='base_delito_conduccion'){
                                      foreach ($sheet6->getRowIterator() as $k=>$row) {
                                        $insertarD=true;
                                          $rowValues = array_map(function($cell) {
                                                  return $cell->getValue();
                                              }, $row->getCells());
                                          if($k>0 && ($rowValues[0]??'')!='NO_EXPEDIENTE'&& ($rowValues[3]??'')!='DELITO'){
                                              if (isset($rowValues[0])) {
                                                 $idExpediente = carpeta_conduccion\cc_datosgenerales::where('NO_EXPEDIENTE_CONDUCCION', '=', $rowValues[0])
                                                  ->first();                                
                                                  $idExpedienteArray[1][]=$idExpediente;
                                                if ($idExpediente) {
                                                  if ($idExpediente->idExpediente > 0) {
                                                   $idDelito = carpeta_conduccion\cc_hechos::where('idExpediente','=', $idExpediente->idExpediente)->first(); 
                                                   if ($idDelito) {
                                                    if ($idDelito->idExpediente > 0) {    
                                                     if (in_array($rowValues[0],$EXPR_base_conduccion)) {
                                                      $insertarD=false;
                                                     }
                                                    }
                                                   }
                                                   if ($insertarD) {
                                                      $key=[];
                                                    #region catálogos
                                                      ////4 =SiNoNoI                                                                    
                                                      $key['DELITO']=DB::table('catdelitosespecificos')->where('Valor',str_replace('_', ' ',$rowValues[3] ?? ''))->first('id');
                                                      $key['CONSUMACION']=DB::table('catrespuestas')->where('idTipoRespuesta',5)->where('Valor',trim($rowValues[4] ?? ''))->first('id');
                                                      $key['MODALIDAD']=DB::table('catrespuestas')->where('idTipoRespuesta',6)->where('Valor',trim($rowValues[5] ?? ''))->first('id');
                                                      $key['INSTRUMENTO_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',7)->where('Valor',trim($rowValues[6] ?? ''))->first('id');
                                                      $key['FUERO_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',8)->where('Valor',trim($rowValues[7] ?? ''))->first('id');
                                                      $key['TIPO_SITIO_OCURRENCIA_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',9)->where('Valor',trim($rowValues[8] ?? ''))->first('id');
                                                      $key['CALIFICACION_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',10)->where('Valor',trim($rowValues[9] ?? ''))->first('id');
                                                      $key['COMISION_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',11)->where('Valor',trim($rowValues[10] ?? ''))->first('id');

                                                    #endregion
                                                    $de_IM = carpeta_conduccion\cc_hechos::updateOrCreate(
                                                      ['idExpediente'=> $idExpediente->idExpediente,
                                                       'DELITO' => $key['DELITO']->id ?? -1,],
                                                      [
                                                      'DELITO_JUR' => -1,
                                                      'CONSUMACION' => $key['CONSUMACION']->id ?? -1,                                         
                                                      'MODALIDAD' => $key['MODALIDAD']->id ?? -1, 
                                                      'INSTRUMENTO_CONDUCCION' => $key['INSTRUMENTO_CONDUCCION']->id ?? -1, 
                                                      'FUERO_CONDUCCION' => $key['FUERO_CONDUCCION']->id ?? -1, 
                                                      'TIPO_SITIO_OCURRENCIA_CONDUCCION' => $key['TIPO_SITIO_OCURRENCIA_CONDUCCION']->id ?? -1, 
                                                      'CALIFICACION_CONDUCCION' => $key['CALIFICACION_CONDUCCION']->id ?? -1, 
                                                      'COMISION_CONDUCCION' => $key['COMISION_CONDUCCION']->id ?? -1, 
                                                      'CONTEXTO' => -1, 
                                                      'FORMA_ACCION' => -1
                                                      ]
                                                      );                                
                                                   }
                                                  }
                                                }
                                              }
                                          }
                                      }                    
                                  }
                                  if ($sheet6->getName()=='base_victimas_conduccion'){
                                      foreach ($sheet6->getRowIterator() as $k=>$row) {
                                        $insertarV=true;
                                          $rowValues = array_map(function($cell) {
                                                  return $cell->getValue();
                                              }, $row->getCells());
                                          if($k>0 && ($rowValues[0]??'')!='NO_EXPEDIENTE_CONDUCCION' && ($rowValues[1]??'')!='TIPO_VICTIMA_CONDUCCION' && ($rowValues[2]??'')!='DELITOS_CONDUCCION'){
                                              if (isset($rowValues[0])) {
                                                 $idExpediente = carpeta_conduccion\cc_datosgenerales::where('NO_EXPEDIENTE_CONDUCCION', '=', $rowValues[0])
                                                 ->first();
                                                  $idExpedienteArray[2][]=$idExpediente;
                                                if ($idExpediente) {
                                                  if ($idExpediente->idExpediente > 0) {
                                                   $idVictima = carpeta_conduccion\cc_victimas::where('idExpediente','=', $idExpediente->idExpediente)->first(); 
                                                   if ($idVictima) {
                                                    if ($idVictima->idExpediente > 0) {   
                                                     if (in_array($rowValues[0],$EXPR_base_conduccion)) {
                                                      $insertarV=false;
                                                     }
                                                    }
                                                   }                             
                                                   if ($insertarV) { 
                                                      $key=[];
                                                    #region catálogos
                                                      ////4 =SiNoNoI                                
                                                      $key['TIPO_VICTIMA_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',13)->where('Valor',trim($rowValues[1] ?? ''))->first('id');
                                                      $key['DELITOS_VICTIMA_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',14)->where('Valor',trim($rowValues[2] ?? ''))->first('id');
                                                      $key['SECTOR_VICTIMAS_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',15)->where('Valor',trim($rowValues[5] ?? ''))->first('id');
                                                      $key['TIPO_PERSONA_VICTIMAS_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',16)->where('Valor',trim($rowValues[6] ?? ''))->first('id');
                                                      $key['SEXO_VICTIMA']=DB::table('catrespuestas')->where('idTipoRespuesta',17)->where('Valor',trim($rowValues[13] ?? ''))->first('id');
                                                      
                                                      $key['SITUACION_CONYUGAL_VICTIMAS_CONDUCCION']
                                                      =DB::table('catrespuestas')->where('idTipoRespuesta',18)->where('Valor',trim($rowValues[14] ?? ''))->first('id');
                                                      $key['NACIONALIDAD']=DB::table('catpaises')->where('Valor',trim($rowValues[15] ?? ''))->first('id');
                                                      $key['SITUACION_MIGRATORIA_VICTIMAS_CONDUCCION']
                                                      =DB::table('catrespuestas')->where('idTipoRespuesta',1)->where('Valor',trim($rowValues[16] ?? ''))->first('id');
                                                      $key['PAIS_NACIMIENTO']=DB::table('catpaises')->where('Valor',trim($rowValues[17] ?? ''))->first('id');
                                                      $key['ENTIDAD_NACIMIENTO_VICTIMAS_CONDUCCION']=DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[18] ?? ''))->first('id');
                                                      $key['MUNICIPIO_NACIMIENTO']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[19] ?? ''))->first('id');        
                                                      $key['PAIS_RESIDENCIA']=DB::table('catpaises')->where('Valor',trim($rowValues[20] ?? ''))->first('id');
                                                      $key['ENTIDAD_RESIDENCIA_VICTIMAS_CONDUCCION']=DB::table('catentidadesfederativas_inegi')->where('Valor',trim($rowValues[21] ?? ''))->first('id');
                                                      $key['MUNICIPIO_RESIDENCIA']=DB::table('catmunicipios_inegi')->where('Valor',trim($rowValues[22] ?? ''))->first('id');
                                                      $key['TRADUCTOR_VICTIMAS_CONDUCCION']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[24] ?? ''))->first('id');
                                                      $key['DISCAPACIDAD_VICTIMAS']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[25] ?? ''))->first('id');
                                                      $key['TIPO_DISCAPACIDAD_VICTIMAS']=DB::table('catrespuestas')->where('idTipoRespuesta',19)->where('Valor',trim($rowValues[26] ?? ''))->first('id');
                                                      $key['INTERPRETE_POR_DISCAPACIDAD_VICTIMA']
                                                        =DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[27] ?? ''))->first('id');                                                      
                                                      $key['POBLACION_CALLE']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[28] ?? ''))->first('id');
                                                      $key['LEER_ESCRIBIR']=DB::table('catrespuestas')->where('idTipoRespuesta',4)->where('Valor',trim($rowValues[29] ?? ''))->first('id');
                                                      $key['ESCOLARIDAD']=DB::table('catrespuestas')->where('idTipoRespuesta',20)->where('Valor',trim($rowValues[30] ?? ''))->first('id');
                                                      $key['OCUPACION']=DB::table('catocupaciones')->where('Valor',trim($rowValues[31] ?? ''))->first('id');
                                                      $key['RELACION_IMPUTADO']=DB::table('catrespuestas')->where('idTipoRespuesta',21)->where('Valor',trim($rowValues[32] ?? ''))->first('id');    
                                                    #endregion
                                                    $de_IM = carpeta_conduccion\cc_victimas::updateOrCreate(
                                                      ['idExpediente'=> $idExpediente->idExpediente,
                                                       'NOMBRE_VICTIMA' => $rowValues[7] ?? '',
                                                       'PRIMER_APELLIDO'=>$rowValues[8] ?? '',
                                                       'SEGUNDO_APELLIDO_VICTIMAS_CONDUCCION'=>$rowValues[9] ?? '', ],
                                                      [
                                                      'TIPO_VICTIMA_CONDUCCION' => $key['TIPO_VICTIMA_CONDUCCION']->id ?? -1,
                                                      'INTERPRETE_VICTIMAS_CONDUCCION' => -1,
                                                      'DELITOS_VICTIMA_CONDUCCION' => $key['DELITOS_VICTIMA_CONDUCCION']->id ?? -1,
                                                      'RAZON_SOCIAL'=>$rowValues[3] ?? '',
                                                      'REPRESENTANTE_LEGAL'=>trim($rowValues[4] ?? '') == '' ? -1 : 1, 
                                                      'TIPO_REPRESENTANTE_LEGAL'=>$rowValues[4] ?? '', 
                                                      'CURP_VICTIMAS' => $rowValues[10] ?? '',
                                                      'FECHA_NACIMIENTO_VICTIMAS' => strtotime($rowValues[11] ?? '') ? date('Y-m-d',strtotime($rowValues[11])): '',
                                                      'EDAD_HECHOS_VICTIMAS' => $rowValues[12] ?? '',
                                                      'SEXO_VICTIMA' => $key['SEXO_VICTIMA']->id ?? -1,

                                                      'SECTOR_VICTIMAS_CONDUCCION' => $key['SECTOR_VICTIMAS_CONDUCCION']->id ?? -1,
                                                      'TIPO_PERSONA_VICTIMAS_CONDUCCION' => $key['TIPO_PERSONA_VICTIMAS_CONDUCCION']->id ?? -1,
                                                      'SITUACION_CONYUGAL_VICTIMAS_CONDUCCION' => $key['SITUACION_CONYUGAL_VICTIMAS_CONDUCCION']->id ?? -1,
                                                      'NACIONALIDAD' => $key['NACIONALIDAD']->id ?? -1,
                                                      'SITUACION_MIGRATORIA_VICTIMAS_CONDUCCION' => $key['SITUACION_MIGRATORIA_VICTIMAS_CONDUCCION']->id ?? -1,
                                                      'PAIS_NACIMIENTO' => $key['PAIS_NACIMIENTO']->id ?? -1,
                                                      'ENTIDAD_NACIMIENTO_VICTIMAS_CONDUCCION' => $key['ENTIDAD_NACIMIENTO_VICTIMAS_CONDUCCION']->id ?? -1,
                                                      'MUNICIPIO_NACIMIENTO' => $key['MUNICIPIO_NACIMIENTO']->id ?? -1,
                                                      'PAIS_RESIDENCIA' => $key['PAIS_RESIDENCIA']->id ?? -1,
                                                      'ENTIDAD_RESIDENCIA_VICTIMAS_CONDUCCION' => $key['ENTIDAD_RESIDENCIA_VICTIMAS_CONDUCCION']->id ?? -1,
                                                      'MUNICIPIO_RESIDENCIA' => $key['MUNICIPIO_RESIDENCIA']->id ?? -1,
                                                      'TELEFONO_VICTIMAS_CONDUCCION' => str_replace(' ', '',$rowValues[23] ?? ''),
                                                      'TRADUCTOR_VICTIMAS_CONDUCCION' => $key['TRADUCTOR_VICTIMAS_CONDUCCION']->id ?? -1,
                                                      'DISCAPACIDAD_VICTIMAS' => $key['DISCAPACIDAD_VICTIMAS']->id ?? -1,
                                                      'TIPO_DISCAPACIDAD_VICTIMAS' => $key['TIPO_DISCAPACIDAD_VICTIMAS']->id ?? -1,
                                                      'INTERPRETE_POR_DISCAPACIDAD_VICTIMA' => $key['INTERPRETE_POR_DISCAPACIDAD_VICTIMA']->id ?? -1,

                                                      'POBLACION_CALLE' => $key['POBLACION_CALLE']->id ?? -1,
                                                      'LEER_ESCRIBIR' => $key['LEER_ESCRIBIR']->id ?? -1,
                                                      'ESCOLARIDAD' => $key['ESCOLARIDAD']->id ?? -1,
                                                      'OCUPACION' => $key['OCUPACION']->id ?? -1,
                                                      'RELACION_IMPUTADO' => $key['RELACION_IMPUTADO']->id ?? -1,

                                                  'ASESORIA' => -1,
                                                  'TIPO_DE_ASESORIA' => -1,
                                                  'DOMICILIO_VICTIMA' => null,
                                                  'INGRESO_VICTIMA' => null,
                                                  'HABLA_ESPAÑOL_VICTIMA' => -1,
                                                  'HABLA_LENG_EXTR_VICTIMA' => -1,
                                                  'TIPO_LENGUA_EXTRANJERA_VICTIMA' => -1,
                                                  'ATEN_MEDICA' => -1,
                                                  'ATEN_PSICOLOGICA' => -1,                                                  
                                                  'SE_IDENTIFICA_INDIGENA_VICTIMA' => -1,
                                                  'POBLACION_INDIGENA_VICTIMA' => -1,
                                                  'HABLA_LENG_INDIG_VICTIMA' => -1,                                                  
                                                  'LENGUA_VICTIMA' => -1,
                                                  'VICTIMA_VIOLENCIA' => -1,
                                                  'VESTIMENTA_VICTIMA' => null,

                                                      ]
                                                      );                                    
                                                   }
                                                  }
                                                }
                                              }
                                          }
                                      }
                                  }          
                                }  
                            }
                            else
                            {
                                $EXPR_base_conduccion[] = $rowValues[6] ?? '';                                         
                            }   
                        }
                    }
                }
            }
          }

          $reader7->open($path);
          $sheets7=$reader7->getSheetIterator();
          foreach ($sheets7 as $sheet7) {
            if ($sheet7->getName()=='base_bitacora'){
              $key=[];
              foreach ($sheet7->getRowIterator() as $k=>$row) {
                $insertarB=true;
                $rowValues = array_map(function($cell) {
                    return $cell->getValue();
                }, $row->getCells());           
                if($k>0 && ($rowValues[0]??'')!='NUC' && ($rowValues[1]??'')!='DELEGACION' && ($rowValues[9]??'')!='NO_EXPEDIENTE') {
                  if (isset($rowValues[9])) {
                    $tipoExp=1;
                    $idExpediente = datos_expediente\de_datosgenerales::where('NO_EXPEDIENTE', '=', $rowValues[9])->first();
                    if (!isset($idExpediente)) {
                      $tipoExp=2;
                      $idExpediente = carpeta_conduccion\cc_datosgenerales::where('NO_EXPEDIENTE_CONDUCCION', '=', $rowValues[9])->first();
                      if (!isset($idExpediente)) {
                        $tipoExp=3;
                        $idExpediente = no_delictivos\nd_datosgenerales::where('NO_EXPEDIENTE', '=', $rowValues[9])->first();
                      }
                    }
                    $idExpedienteArray[3][]=$idExpediente;
                    if ($idExpediente) {
                      if ($idExpediente->idExpediente > 0) {
                       // $idVictima = datos_expediente\de_victimas::where('idExpediente','=', $idExpediente->idExpediente)->first(); 
                       // if ($idVictima) {
                       //  if ($idVictima->idExpediente > 0) {    
                       //   // if (($tipoExp==1 && in_array($rowValues[0],$NUCR_base_carpetas2)) ||
                       //   //      $tipoExp==2 && in_array($rowValues[9],$EXPR_base_conduccion) ||
                       //   //      $tipoExp==3 && in_array($rowValues[9],$EXPR_base_hechos_no_delictivos)) {
                       //    $insertarB=false;
                       //   //}
                       //  }
                       // }
                       if ($insertarB) {
                          $key=[];
                        #region catálogos
                            $key['DELEGACION']=DB::table('catdelegaciones')->where('Valor',trim($rowValues[1] ?? ''))->first('id');                      
                        #endregion
                        $bitBC = bitbasecaptura::updateOrCreate(
                          ['idExpediente'=> $idExpediente->idExpediente, 
                            'tipoExpediente'=>$tipoExp],[ 
                            'idUsuario' => Auth::User()->id, 
                            'NUC' =>$rowValues[0]??'', 
                            'DELEGACION'=> $key['DELEGACION']->id ?? -1, 
                            'UNIDAD'=>$rowValues[2]??'', 
                            'MESA'=>$rowValues[3]??'', 
                            'RESPONSABLE'=>$rowValues[4]??'', 
                            'CAPTURA'=>$rowValues[5]??'', 
                            'PUESTO_CAPTURA'=>$rowValues[6]??'', 
                            'TIMESTAMP'=>$rowValues[8]??'', 
                            'NO_EXPEDIENTE'=>$rowValues[9]??'', 
                          ]
                          );
                        if($tipoExp==1) {
                            $upd=datos_expediente\de_datosgenerales::where('id', '=',$idExpediente->idExpediente)->first();
                            $upd->NOMBRE_AGENTE_MP=Auth::User()->name;
                            //$upd->NOMBRE_AGENTE_MP=$rowValues[4]??'';
                            $upd->save();
                        }
                       }
                      }
                    }
                  }
                }
              }
            }
          }

          $reader->close();
          $reader2->close();
          $reader3->close();        
          $reader4->close();
          $reader5->close();
          $reader6->close();
          $reader7->close();
          $de_msj='';$nd_msj='';$cc_msj='';
          $correcto=true;
          $msjRepetido=null;
          $msjmasivo='La carga de datos finalizó correctamente.';

          if(count($NUCR_base_carpetas2) > 0) {
           $correcto=false;
           $de_msj=count($NUCR_base_carpetas2)==1?'El NUC '.$NUCR_base_carpetas2[0].' NO se insertó porque ya existe.'
              :'Los siguientes NUC NO se insertaron porque ya existen:<br><br> '.implode(',<br>', $NUCR_base_carpetas2);                
          }
          if(count($EXPR_base_hechos_no_delictivos) > 0) {
           $correcto=false;
           $nd_msj=$de_msj==''?'':'<hr>';
           $nd_msj.=count($EXPR_base_hechos_no_delictivos)==1?'El EXPEDIENTE '.$EXPR_base_hechos_no_delictivos[0].' NO se insertó porque ya existe.'
              :'Los siguientes EXPEDIENTES NO se insertaron porque ya existen:<br><br> '.implode(',<br>', $EXPR_base_hechos_no_delictivos);
          }
          if(count($EXPR_base_conduccion) > 0) {
           $correcto=false;
           $cc_msj=$de_msj.$nd_msj==''?'':'<hr>';
           $cc_msj.=count($EXPR_base_conduccion)==1?'El EXPEDIENTE '.$EXPR_base_conduccion[0].' NO se insertó porque ya existe.'
              :'Los siguientes EXPEDIENTES NO se insertaron porque ya existen:<br><br> '.implode(',<br>', $EXPR_base_conduccion);
          }

          if(!$correcto) {
              $msjRepetido=$de_msj.$nd_msj.$cc_msj;
              $msjmasivo=null;                
          }
          return back()->with(['registration'=> $msjmasivo,
          'correoRepetido'=>$msjRepetido]);
        }
        else
        {
          return back()->with(['registration'=> null, 'correoRepetido'=>'Es necesario cargar un archivo']);
        }
      } catch (Exception $e){
        Log::error($e->getMessage());
      }
     }
    }
}