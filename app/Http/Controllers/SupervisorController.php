<?php

namespace App\Http\Controllers;
use Hash;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\relusuarioexpedientes;

use App\Models\datos_expediente;
use App\Models\causas_penales;
use App\Models\carpeta_conduccion;
use App\Models\no_delictivos;
use App\Models\biteventousario;
use App\Models\bitCorreccionesValidaciones;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExport;
use App\Exports\datosTablas;

use Carbon\Carbon;

class SupervisorController extends Controller
{
    function reasignar(Request $request)
    {
        $expediente = $request->input('expRe');
        $usuario = $request->input('usuarioRe');
        $tabla = '';
        switch ($request->input('tblRe')) {
            case 1:
                $tabla='prode_datosgenerales';
                break;
            
            case 2:
                $tabla='prond_datosgenerales';
                break;
            
            case 3:
                $tabla='procc_datosgenerales';
                break;
        }

         relusuarioexpedientes::where('idExpediente',$expediente)->where('tabla',$tabla)
            ->update(['Activo' => 0]);
            relusuarioexpedientes::updateOrCreate(
                ['idUsuario'=>$usuario,'idExpediente'=>$expediente],
                ['Activo' => 1,'tabla'=>$tabla]);
            return back();
    }

    function correccionExpedientesSuper(Request $request)
    {
      $request->validate(['CorreccionObservaciones' =>   'required',],
      ['CorreccionObservaciones.required'=>'Para solicitar una correción, es necesario anotar una observación.',]);
        $idtabla=0;
      
      $ob=[];
      $corr=bitCorreccionesValidaciones::where(
        ['idExpediente' => hex2bin($request->idExp),
        'tabla'=>'pro'.$request->Ctrl.'_datosgenerales',
        'Activo'=>1,'Correccion'=> 1,])->first();

        if ( ( $corr->id ?? 0 )<0) {
          $ob=$corr;
        }
        else
        {
          $ob = bitCorreccionesValidaciones::create(['idExpediente' => hex2bin($request->idExp),
            'tabla'=>'pro'.$request->Ctrl.'_datosgenerales','idUsuario' => Auth::User()->id,
            'Activo'=>1,'Correccion'=> 1,'Validacion'=> 0,        
            'Observaciones'=>$request->CorreccionObservaciones]);
        }

      if ($ob->id) {      
        $bitEvUsu=biteventousario::create(
        ['idUsuario' => Auth::User()->id,
        'idExpediente' => hex2bin($request->idExp),
        'idRegistro' => $ob->id,
        'idEvento' => 69,
        'Evento' =>'Supervisor Solicita Correción a Expediente']);
        return redirect()->route('detalle.super',[$request->Ctrl,hex2bin($request->idExp)]);
      }
    }

    function validacionExpedientesSuper(Request $request)
    {
      $idtabla=0;
      $ob=bitCorreccionesValidaciones::updateOrCreate(
        ['idExpediente' => hex2bin($request->idExp),
        'tabla'=>'pro'.$request->Ctrl.'_datosgenerales',
        'Activo'=>1,'Validacion'=> 1,
        ],
        [
        'idUsuario' => Auth::User()->id,        
        'Correccion'=> 0,
        'Observaciones'=>'']);
      if ($ob->id) {      
        $bitEvUsu=biteventousario::create(
        ['idUsuario' => Auth::User()->id,
        'idExpediente' => hex2bin($request->idExp),
        'idRegistro' => $ob->id,
        'idEvento' => 70,
        'Evento' =>'Supervisor Valida Expediente']);
        return redirect()->route('listado.super');      
      }
    }
    function redirigirExpedientesSuper(Request $request)
    {            
      $ctrl = $request->Ctrl == 'de' ? 'e3' : ($request->Ctrl == 'nd' ? 'he' : ($request->Ctrl == 'cc' ? 'd9' : ''));
        return redirect()->route("dash",[$ctrl,hex2bin($request->idExp)]);
    }    
    function detalleExpedientesSuper($tabla,$idExpediente)
    {
      if(is_null(Auth::User())) { return redirect("Salir"); }
      else
      {              
        DB::statement("SET SQL_MODE=''");        
        $victimas = []; $imputados = []; $hechos = []; $relaciones = [];$datos=[];$delitosGrl=[];
        $Correcc=0;$Validac=0;
        if ($tabla=='de') {
          $datos = datos_expediente\de_datosgenerales::leftJoin('catrespuestas as cr', function($join)
            {
                $join->on('prode_datosgenerales.FORMA_','=','cr.id')
                ->Where('cr.idTipoRespuesta','=',50);
            })
          
            ->leftJoin('catrespuestas as cr96', function($join)
            {
                $join->on('prode_datosgenerales.UNIDAD_QUE_RECIBE','=','cr96.id')
                ->Where('cr96.idTipoRespuesta','=',96);
            })
            ->leftJoin('relusuarioexpedientes as rUE', function($join)
            {
              $join->on('rUE.idExpediente', '=', 'prode_datosgenerales.idExpediente')
              ->Where('rUE.tabla','=','prode_datosgenerales')->where('rUE.Activo','=',1);
            })
            ->leftJoin('catdelegaciones','prode_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
            ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
            ->select('users.name AS MP_NAME','catdelegaciones.Valor AS MP_DELEGACION',
              DB::raw("CASE".
                      " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS MP_UNIDAD"),
              'FECHA_INICIO_CARPETA as FECHA_INICIO','FECHA_HECHOS','NUC_COMPLETA','NO_EXPEDIENTE','cr96.Valor as UNIDAD_QUE_RECIBE','cr.Valor as DETENIDOS')
            ->where('prode_datosgenerales.idExpediente',$idExpediente)->first();          

            $datos->FECHA_INICIO = date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_INICIO)));
            $datos->FECHA_HECHOS = date("Y-m-d",strtotime(str_replace('/', '-',$datos->FECHA_HECHOS)));

          $delitosGrl=datos_expediente\de_hechos::leftJoin('catdelitosespecificos as cde', 'cde.id','=','prode_hechos.DELITO')
            ->leftJoin('catdelitosgenerales as cdg', 'cdg.id','=','cde.idDelitoGeneral')
            ->where('idExpediente',$idExpediente)->orderBy('prode_hechos.id')->groupby('idExpediente')
            ->select(DB::raw('GROUP_CONCAT(DISTINCT(CONCAT(cdg.Valor))) as delito'))->first();

          $victimas = datos_expediente\de_victimas::where('idExpediente',$idExpediente)
            ->leftJoin('catrespuestas as cr', function($join)
            {
                $join->on('prode_victimas.SEXO_VICTIMA','=','cr.id')
                ->Where('cr.idTipoRespuesta','=',17);
            })->select('prode_victimas.id',
            DB::raw('CONCAT(NOMBRE_VICTIMA," ", PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_VICTIMAS) as Nombre'),
            DB::raw('IFNULL(cr.Valor,"-") as Sexo'),
            'EDAD_HECHOS_VICTIMAS')->get();

          $imputados= datos_expediente\de_imputados::where('idExpediente',$idExpediente)
            ->leftJoin('catrespuestas as cr', function($join)
            {
                $join->on('prode_imputados.SEXO_IMPUTADO','=','cr.id')
                ->Where('cr.idTipoRespuesta','=',17);
            })
            ->select('prode_imputados.id',
            DB::raw('CONCAT(NOMBRE_IMPUTADO," ", PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS) as Nombre'),
            DB::raw('IFNULL(cr.Valor,"-") as Sexo'),
            'EDAD_HECHOS_IMPUTADOS')->get();
          
          $hechos=datos_expediente\de_hechos::join('catdelitosespecificos as catD','prode_hechos.DELITO', '=', 'catD.id')
            ->where('idExpediente',$idExpediente)->orderByDesc('prode_hechos.id')->select('prode_hechos.id','catD.Valor')->get();

          $relaciones=datos_expediente\bitde_relaciondelito::leftjoin('prode_relaciondelito as pdr','bitde_relaciondelito.id','=','pdr.idRelacion')
            ->leftjoin('prode_victimas as pdv','pdr.idVictima','=','pdv.id')
            ->leftjoin('prode_imputados as pdi','pdr.idImputado','=','pdi.id')
            ->leftjoin('prode_hechos as pdh','bitde_relaciondelito.idDelito','=','pdh.id')
            ->leftjoin('catdelitosespecificos as cde','pdh.DELITO','=','cde.id')
            ->select(DB::raw('GROUP_CONCAT(DISTINCT(cde.Valor)) AS delito'),
                DB::raw("GROUP_CONCAT(DISTINCT(CONCAT(pdv.NOMBRE_VICTIMA,' ', pdv.PRIMER_APELLIDO,' ', pdv.SEGUNDO_APELLIDO_VICTIMAS))) victimas"),
                DB::raw("GROUP_CONCAT(DISTINCT(CONCAT(pdi.NOMBRE_IMPUTADO,' ', pdi.PRIMER_APELLIDO,' ', pdi.SEGUNDO_APELLIDO_IMPUTADOS))) imputados"),
            )->where('bitde_relaciondelito.idExpediente',$idExpediente)->groupby('bitde_relaciondelito.id') ->get();            
              
        }
        else if ($tabla=='cc') {
          $datos = carpeta_conduccion\cc_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
            {
              $join->on('rUE.idExpediente', '=', 'procc_datosgenerales.idExpediente')
              ->Where('rUE.tabla','=','procc_datosgenerales')->where('rUE.Activo','=',1);
            })
            ->leftJoin('catdelegaciones','procc_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
            ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
            ->select('users.name AS MP_NAME','catdelegaciones.Valor AS MP_DELEGACION',
              DB::raw("CASE".
                      " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS MP_UNIDAD"),            
              'FECHA_INICIO_CONDUCCION as FECHA_INICIO','FECHA_HECHOS_CONDUCCION as FECHA_HECHOS',DB::raw("'N/A' as NUC_COMPLETA"),
            'NO_EXPEDIENTE_CONDUCCION as NO_EXPEDIENTE','UNIDAD_QUE_RECIBE_CONDUCCION as UNIDAD_QUE_RECIBE',DB::raw("'N/A' as DETENIDOS"))
            ->where('procc_datosgenerales.idExpediente',$idExpediente)->first();          

            $datos->FECHA_INICIO = date("d/m/Y",strtotime(str_replace('/', '-',$datos->FECHA_INICIO)));
            $datos->FECHA_HECHOS = date("d/m/Y",strtotime(str_replace('/', '-',$datos->FECHA_HECHOS)));
          $delitosGrl=carpeta_conduccion\cc_hechos::leftJoin('catdelitosespecificos as cde', 'cde.id','=','procc_hechos.DELITO')
            ->leftJoin('catdelitosgenerales as cdg', 'cdg.id','=','cde.idDelitoGeneral')
            ->where('idExpediente',$idExpediente)->orderBy('procc_hechos.id')->groupby('idExpediente')
            ->select(DB::raw('GROUP_CONCAT(DISTINCT(CONCAT(cdg.Valor))) as delito'))->first();

          $victimas = carpeta_conduccion\cc_victimas::where('idExpediente',$idExpediente)
            ->select('procc_victimas.id',
            DB::raw('CONCAT(NOMBRE_VICTIMA," ",PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_VICTIMAS_CONDUCCION) as Nombre'),
            DB::raw("'-' as Sexo"),
            DB::raw("'-' as EDAD_HECHOS_VICTIMAS"))->get();

          $imputados= carpeta_conduccion\cc_imputados::where('idExpediente',$idExpediente)
            ->select('procc_imputados.id',
            DB::raw('CONCAT(NOMBRE_IMPUTADO," ",PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_IMPUTADOS_CONDUCCION) as Nombre'),
            DB::raw("'-' as Sexo"),
            DB::raw("'-' as EDAD_HECHOS_IMPUTADOS"))->get();
          
          $hechos=carpeta_conduccion\cc_hechos::join('catdelitosespecificos as catD','procc_hechos.DELITO', '=', 'catD.id')
            ->where('idExpediente',$idExpediente)->orderByDesc('procc_hechos.id')->select('procc_hechos.id','catD.Valor')->get();

        }
        else if ($tabla=='nd') {
          $datos = no_delictivos\nd_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
            {
              $join->on('rUE.idExpediente', '=', 'prond_datosgenerales.idExpediente')
              ->Where('rUE.tabla','=','prond_datosgenerales')->where('rUE.Activo','=',1);
            })
            ->leftJoin('catdelegaciones','prond_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
            ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
            ->select('users.name AS MP_NAME','catdelegaciones.Valor AS MP_DELEGACION',
              DB::raw("CASE".
                      " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS MP_UNIDAD"), 
              'FECHA_INICIO as FECHA_INICIO','FECHA_HECHOS_NO_DELICTIVOS as FECHA_HECHOS',DB::raw("'N/A' as NUC_COMPLETA"),
              'NO_EXPEDIENTE as NO_EXPEDIENTE',DB::raw("'N/A' as UNIDAD_QUE_RECIBE"),DB::raw("'N/A' as DETENIDOS"))
            ->where('prond_datosgenerales.idExpediente',$idExpediente)->first();          

            $datos->FECHA_INICIO = date("d/m/Y",strtotime(str_replace('/', '-',$datos->FECHA_INICIO)));
            $datos->FECHA_HECHOS = date("d/m/Y",strtotime(str_replace('/', '-',$datos->FECHA_HECHOS)));
          
          $delitosGrl=no_delictivos\nd_datosgenerales::leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('prond_datosgenerales.HECHO_NO_DELITO','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',70);
            })
            ->where('idExpediente',$idExpediente)->groupby('idExpediente')
            ->select(DB::raw('GROUP_CONCAT(DISTINCT(CONCAT(cr1.Valor))) as delito'))->first();

          $victimas = no_delictivos\nd_victimas::where('idExpediente',$idExpediente)
            ->leftJoin('catrespuestas as cr', function($join)
            {
                $join->on('prond_victimas.SEXO','=','cr.id')
                ->Where('cr.idTipoRespuesta','=',17);
            })          
            ->select('prond_victimas.id',
            DB::raw('CONCAT(NOMBRE_VICTIMA," ",PRIMER_APELLIDO," ", SEGUNDO_APELLIDO_VICTIMAS_NO_DELICTIVO) as Nombre'),
            DB::raw('IFNULL(cr.Valor,"-") as Sexo'),
            DB::raw("'-' as EDAD_HECHOS_VICTIMAS"))->get();
          
          $hechos=no_delictivos\nd_datosgenerales::leftJoin('catrespuestas as cr', function($join)
            {
              $join->on('prond_datosgenerales.HECHO_NO_DELITO','=','cr.id')
              ->Where('cr.idTipoRespuesta','=',70);
            })
            ->where('idExpediente',$idExpediente)->orderByDesc('prond_datosgenerales.id')->select('prond_datosgenerales.id','cr.Valor')->get();

        }
          $Correcc=bitCorreccionesValidaciones::where(
            ['idExpediente' => $idExpediente,
            'tabla'=>'pro'.$tabla.'_datosgenerales',
            'Activo'=>1,'Correccion'=> 1,])->count();
          $CorreccDATA=bitCorreccionesValidaciones::where(
            ['idExpediente' => $idExpediente,
            'tabla'=>'pro'.$tabla.'_datosgenerales',
            'Activo'=>1,'Correccion'=> 1,])->orderByDesc("created_at")->get();
          $Validac=bitCorreccionesValidaciones::where(
            ['idExpediente' => $idExpediente,
            'tabla'=>'pro'.$tabla.'_datosgenerales',
            'Activo'=>1,'Validacion'=> 1,])->count();  

        $idExp=bin2hex($idExpediente);
        $data=['idExp'=>$idExp,'tabla'=>$tabla,'datos'=>$datos,'delitosGrl'=>$delitosGrl,
        'Correcc'=>$Correcc,'CorreccDATA'=>$CorreccDATA,'Validac'=>$Validac,
        'victimas'=>$victimas,'imputados'=>$imputados,'hechos'=>$hechos,'relaciones'=>$relaciones];
        return view('supervisor.detalleExpediente')->with($data);
      }
    }

    function listadoExpedientesSuper(Request $request) {
     if(is_null(Auth::User())) { return redirect("Salir"); }
      else
      {          
        DB::statement("SET SQL_MODE=''");
        $expedientes=[]; $expedientesCC=[]; $expedientesND=[]; $tipo='';$User=Auth::User();
        $expedientes=datos_expediente\de_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
          {
            $join->on('rUE.idExpediente', '=', 'prode_datosgenerales.idExpediente')
            ->Where('rUE.tabla','=','prode_datosgenerales')->where('rUE.Activo','=',1);
          }) 
          ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
          ->leftJoin('bitbasecaptura as bbc', function($join)
          {
            $join->on('bbc.idExpediente', '=', 'prode_datosgenerales.idExpediente')
            ->Where('bbc.tipoExpediente','=',1);
          })
          ->leftJoin('catdelegaciones','prode_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
          ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CAUSA_PENAL_ID)) causas, idExpediente FROM procp_datosgenerales WHERE deleted_at IS NULL GROUP BY idExpediente) as pcp"),'pcp.idExpediente', '=', 'prode_datosgenerales.idExpediente')
          ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_IMPUTADO,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS))) imputados, idExpediente FROM prode_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 
            'prode_datosgenerales.idExpediente')
          ->leftjoin(DB::raw("(select GROUP_CONCAT(Valor) as delitos ,idExpediente FROM prode_hechos pdh left join catdelitosespecificos cde on pdh.DELITO=cde.id WHERE deleted_at IS NULL GROUP BY idExpediente) as pdhg"),'pdhg.idExpediente', '=', 'prode_datosgenerales.idExpediente')
          ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_VICTIMA,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS))) victimas, idExpediente FROM prode_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 
            'prode_datosgenerales.idExpediente')
          ->leftjoin(DB::raw("(select idExpediente,MAX(id) id from bitcorreccionesvalidaciones WHERE activo=1 and tabla='prode_datosgenerales' GROUP BY idExpediente) as maxcv"),
            'maxcv.idExpediente','=','prode_datosgenerales.id')
          ->leftjoin('bitcorreccionesvalidaciones as cv','cv.id','=','maxcv.id')
          ->leftJoin('procp_audienciainicial as pa','pa.idExpediente','=','rUE.idExpediente')
          ->select('catdelegaciones.Valor AS MP_DELEGACION',
            //'bbc.RESPONSABLE','bbc.UNIDAD',
            DB::raw("CASE".
                      " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS UNIDAD"),
            'prode_datosgenerales.FECHA_INICIO_CARPETA',
            DB::raw('IFNULL(pcp.causas,"-") as causas'),
            DB::raw("CASE WHEN IFNULL(pa.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),pa.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
            'cv.Validacion','cv.Correccion','prode_datosgenerales.idExpediente','prode_datosgenerales.NUC_COMPLETA AS NUC',
            'prode_datosgenerales.NO_EXPEDIENTE','users.id','users.name as RESPONSABLE','bbc.RESPONSABLE as name',
            'users.email','rUE.Activo','prode_datosgenerales.created_at','prode_datosgenerales.FECHA_HECHOS',
            'prode_datosgenerales.updated_at',
            DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),
            DB::raw('IFNULL(pdig.imputados,"-") as imputados'),
            DB::raw('IFNULL(pdvg.victimas,"-") as victimas'))
          ->where('rUE.Activo',1)->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
          })          
          ->groupby('rUE.idExpediente')->OrderByDesc('users.id')->OrderByDesc('prode_datosgenerales.idExpediente')
          ->paginate(10);
        $expedientesCC=carpeta_conduccion\cc_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
          {
            $join->on('rUE.idExpediente', '=', 'procc_datosgenerales.idExpediente')
            ->Where('rUE.tabla','=','procc_datosgenerales')->where('rUE.Activo','=',1);
          })
          ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
          ->leftJoin('bitbasecaptura as bbc', function($join)
          {
            $join->on('bbc.idExpediente', '=', 'procc_datosgenerales.idExpediente')
            ->Where('bbc.tipoExpediente','=',2);
          })
          ->leftJoin('catdelegaciones','procc_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
          ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_IMPUTADO,' ',PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS_CONDUCCION))) imputados, idExpediente FROM procc_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'procc_datosgenerales.idExpediente')
          ->leftjoin(DB::raw("(select GROUP_CONCAT(Valor) as delitos ,idExpediente FROM procc_hechos pdh left join catdelitosespecificos cde on pdh.DELITO=cde.id WHERE deleted_at IS NULL GROUP BY idExpediente) as pdhg"),'pdhg.idExpediente', '=', 'procc_datosgenerales.idExpediente')
          ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_VICTIMA,' ',PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS_CONDUCCION))) victimas, idExpediente FROM procc_victimas WHERE deleted_at IS NULL GROUP by idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'procc_datosgenerales.idExpediente')          
          ->leftjoin(DB::raw("(select idExpediente,MAX(id) id from bitcorreccionesvalidaciones WHERE activo=1 and tabla='procc_datosgenerales' GROUP BY idExpediente) as maxcv"),
            'maxcv.idExpediente','=','procc_datosgenerales.id')
          ->leftjoin('bitcorreccionesvalidaciones as cv','cv.id','=','maxcv.id')
          ->select('catdelegaciones.Valor AS MP_DELEGACION',
            //'bbc.RESPONSABLE','bbc.UNIDAD',
            DB::raw("CASE".
                      " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS UNIDAD"),
            'cv.Validacion','cv.Correccion','procc_datosgenerales.idExpediente','procc_datosgenerales.NO_EXPEDIENTE_CONDUCCION','users.id',
            'users.name as RESPONSABLE','bbc.RESPONSABLE as name','users.email','rUE.Activo',
            'procc_datosgenerales.created_at','procc_datosgenerales.FECHA_HECHOS_CONDUCCION as FECHA_HECHOS',
            'procc_datosgenerales.updated_at','procc_datosgenerales.FECHA_INICIO_CONDUCCION as FECHA_INICIO_CARPETA',
            DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),
            DB::raw('IFNULL(pdig.imputados,"-") as imputados'),
            DB::raw('IFNULL(pdvg.victimas,"-") as victimas'))
          ->where('rUE.Activo',1)->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
          })   
          ->groupby('rUE.idExpediente')->OrderByDesc('users.id')->OrderByDesc('procc_datosgenerales.idExpediente')
          ->paginate(10);
        $expedientesND=no_delictivos\nd_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
          {
            $join->on('rUE.idExpediente', '=', 'prond_datosgenerales.idExpediente')
            ->Where('rUE.tabla','=','prond_datosgenerales')->where('rUE.Activo','=',1);
          })
          ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
          ->leftJoin('bitbasecaptura as bbc', function($join)
          {
            $join->on('bbc.idExpediente', '=', 'prond_datosgenerales.idExpediente')
            ->Where('bbc.tipoExpediente','=',3);
          })          
          ->leftJoin('catdelegaciones','prond_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
          ->leftJoin('catrespuestas as cr1', function($join)
          {
            $join->on('prond_datosgenerales.HECHO_NO_DELITO','=','cr1.id')
            ->Where('cr1.idTipoRespuesta','=',70);
          })           
          ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_VICTIMA,' ',PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS_NO_DELICTIVO))) victimas, idExpediente FROM prond_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'prond_datosgenerales.idExpediente')

          ->leftjoin(DB::raw("(select idExpediente,MAX(id) id from bitcorreccionesvalidaciones WHERE activo=1 and tabla='prond_datosgenerales' GROUP BY idExpediente) as maxcv"),
            'maxcv.idExpediente','=','prond_datosgenerales.id')
          ->leftjoin('bitcorreccionesvalidaciones as cv','cv.id','=','maxcv.id')
          ->select('catdelegaciones.Valor AS MP_DELEGACION',
            //'bbc.RESPONSABLE','bbc.UNIDAD',
            DB::raw("CASE".
                      " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS UNIDAD"),
            'cv.Validacion','cv.Correccion','prond_datosgenerales.idExpediente','prond_datosgenerales.NO_EXPEDIENTE','users.id',
            'users.name as RESPONSABLE','bbc.RESPONSABLE as name','users.email','rUE.Activo',
            'prond_datosgenerales.created_at','prond_datosgenerales.FECHA_HECHOS_NO_DELICTIVOS as FECHA_HECHOS',
            'prond_datosgenerales.updated_at','prond_datosgenerales.FECHA_INICIO as FECHA_INICIO_CARPETA',
            DB::raw("cr1.Valor as delitos"),DB::raw("'' as imputados"), DB::raw('IFNULL(pdvg.victimas,"-") as victimas'))
          ->where('rUE.Activo',1)->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
          })   
          ->groupby('rUE.idExpediente')->OrderByDesc('users.id')->OrderByDesc('prond_datosgenerales.idExpediente')
          ->paginate(10);                    

        $SupExpV=[];$SumaExpV=0;$SupExpP=[];$SupExpC=[];$arrAlert=[];
          $prode_ = datos_expediente\de_datosgenerales::leftjoin('bitcorreccionesvalidaciones as bcv', function($join)
            {
                $join->on('prode_datosgenerales.idExpediente','=','bcv.idExpediente')
                ->Where('bcv.tabla','=','prode_datosgenerales');
            })
            ->leftJoin('relusuarioexpedientes as rUE', function($join)
            {
              $join->on('rUE.idExpediente', '=', 'prode_datosgenerales.idExpediente')
              ->Where('rUE.tabla','=','prode_datosgenerales')->where('rUE.Activo','=',1);
            })
            ->leftJoin('catdelegaciones','prode_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
            ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
            ->select('users.name AS MP_NAME','catdelegaciones.Valor AS MP_DELEGACION',
              'prode_datosgenerales.created_at','NUC_COMPLETA as NUC','NO_EXPEDIENTE',
              DB::raw("'Carpeta iniciada' as tabla"),DB::raw("'de' as carpeta"),
              DB::raw("CASE".
                      " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS MP_UNIDAD"), 'prode_datosgenerales.idExpediente')
            //->where(['bcv.Validacion'=>1,'bcv.Activo'=>1])
            //->whereRaw("IFNULL(bcv.Validacion,0)!=1")
            ->whereRaw("prode_datosgenerales.idExpediente NOT IN (SELECT idExpediente FROM `bitcorreccionesvalidaciones` WHERE Validacion=1 and tabla ='prode_datosgenerales')")
            ->whereRaw("prode_datosgenerales.idExpediente NOT IN (SELECT idExpediente FROM `bitcorreccionesvalidaciones` WHERE Correccion=1 and Activo=1 and tabla ='prode_datosgenerales')")
            ->whereRaw("prode_datosgenerales.created_at > DATE_SUB(CURRENT_DATE(),INTERVAL WEEKDAY(CURRENT_DATE()) DAY)")
            ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
            });
          $prodeCount=count(datos_expediente\de_datosgenerales::leftjoin('bitcorreccionesvalidaciones as bcv', function($join)
            {
                $join->on('prode_datosgenerales.idExpediente','=','bcv.idExpediente')
                ->Where('bcv.tabla','=','prode_datosgenerales');
            })
            ->leftJoin('relusuarioexpedientes as rUE', function($join)
            {
              $join->on('rUE.idExpediente', '=', 'prode_datosgenerales.idExpediente')
              ->Where('rUE.tabla','=','prode_datosgenerales')->where('rUE.Activo','=',1);
            })
            ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
            ->select('prode_datosgenerales.created_at','NUC_COMPLETA as NUC','NO_EXPEDIENTE',DB::raw("'Carpeta iniciada' as tabla"))
            //->where(['bcv.Validacion'=>1,'bcv.Activo'=>1])
            //->whereRaw("IFNULL(bcv.Validacion,0)!=1")
            ->whereRaw("prode_datosgenerales.idExpediente NOT IN (SELECT idExpediente FROM `bitcorreccionesvalidaciones` WHERE Validacion=1 and tabla ='prode_datosgenerales')")            
            ->whereRaw("prode_datosgenerales.idExpediente NOT IN (SELECT idExpediente FROM `bitcorreccionesvalidaciones` WHERE Correccion=1 and Activo=1 and tabla ='prode_datosgenerales')")
            ->whereRaw("prode_datosgenerales.created_at < DATE_SUB(CURRENT_DATE(),INTERVAL WEEKDAY(CURRENT_DATE()) DAY)")
            ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
            })->distinct()->get());

          $procc_ = carpeta_conduccion\cc_datosgenerales::leftjoin('bitcorreccionesvalidaciones as bcv', function($join)
            {
                $join->on('procc_datosgenerales.idExpediente','=','bcv.idExpediente')
                ->Where('bcv.tabla','=','procc_datosgenerales');
            })
            ->leftJoin('relusuarioexpedientes as rUE', function($join)
            {
              $join->on('rUE.idExpediente', '=', 'procc_datosgenerales.idExpediente')
              ->Where('rUE.tabla','=','procc_datosgenerales')->where('rUE.Activo','=',1);
            })
            ->leftJoin('catdelegaciones','procc_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
            ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
            ->select('users.name AS MP_NAME','catdelegaciones.Valor AS MP_DELEGACION',
              'procc_datosgenerales.created_at',DB::raw('"-" as NUC'),'NO_EXPEDIENTE_CONDUCCION as NO_EXPEDIENTE',
              DB::raw("'Carpeta de conducción' as tabla"),DB::raw("'cc' as carpeta"),
              DB::raw("CASE".
                      " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS MP_UNIDAD"), 'procc_datosgenerales.idExpediente')
            //->where(['bcv.Validacion'=>1,'bcv.Activo'=>1])
            //->whereRaw("IFNULL(bcv.Validacion,0)!=1")
            ->whereRaw("procc_datosgenerales.idExpediente NOT IN (SELECT idExpediente FROM `bitcorreccionesvalidaciones` WHERE Validacion=1 and tabla ='procc_datosgenerales')")
            ->whereRaw("procc_datosgenerales.idExpediente NOT IN (SELECT idExpediente FROM `bitcorreccionesvalidaciones` WHERE Correccion=1 and Activo=1 and tabla ='procc_datosgenerales')")
            ->whereRaw("procc_datosgenerales.created_at > DATE_SUB(CURRENT_DATE(),INTERVAL WEEKDAY(CURRENT_DATE()) DAY)")
            ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
            });
          $proccCount = count(carpeta_conduccion\cc_datosgenerales::leftjoin('bitcorreccionesvalidaciones as bcv', function($join)
            {
                $join->on('procc_datosgenerales.idExpediente','=','bcv.idExpediente')
                ->Where('bcv.tabla','=','procc_datosgenerales');
            })
            ->leftJoin('relusuarioexpedientes as rUE', function($join)
            {
              $join->on('rUE.idExpediente', '=', 'procc_datosgenerales.idExpediente')
              ->Where('rUE.tabla','=','procc_datosgenerales')->where('rUE.Activo','=',1);
            })
            ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
            ->select('procc_datosgenerales.created_at',DB::raw('"-" as NUC'),'NO_EXPEDIENTE_CONDUCCION as NO_EXPEDIENTE',
              DB::raw("'Carpeta de conducción' as tabla"))
            //->where(['bcv.Validacion'=>1,'bcv.Activo'=>1])
            //->whereRaw("IFNULL(bcv.Validacion,0)!=1")
            ->whereRaw("procc_datosgenerales.idExpediente NOT IN (SELECT idExpediente FROM `bitcorreccionesvalidaciones` WHERE Validacion=1 and tabla ='procc_datosgenerales')")
            ->whereRaw("procc_datosgenerales.idExpediente NOT IN (SELECT idExpediente FROM `bitcorreccionesvalidaciones` WHERE Correccion=1 and Activo=1 and tabla ='procc_datosgenerales')")
            ->whereRaw("procc_datosgenerales.created_at < DATE_SUB(CURRENT_DATE(),INTERVAL WEEKDAY(CURRENT_DATE()) DAY)")
            ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
            })->distinct()->get());
          $prond_ = no_delictivos\nd_datosgenerales::leftjoin('bitcorreccionesvalidaciones as bcv', function($join)
            {
                $join->on('prond_datosgenerales.idExpediente','=','bcv.idExpediente')
                ->Where('bcv.tabla','=','prond_datosgenerales');
            })
            ->leftJoin('relusuarioexpedientes as rUE', function($join)
            {
              $join->on('rUE.idExpediente', '=', 'prond_datosgenerales.idExpediente')
              ->Where('rUE.tabla','=','prond_datosgenerales')->where('rUE.Activo','=',1);
            })
            ->leftJoin('catdelegaciones','prond_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
            ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
            ->select('users.name AS MP_NAME','catdelegaciones.Valor AS MP_DELEGACION',
              'prond_datosgenerales.created_at',DB::raw('"-" as NUC'),'NO_EXPEDIENTE',
              DB::raw("'Expediente no delictivo' as tabla"),DB::raw("'nd' as carpeta"),
              DB::raw("CASE".
                      " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS MP_UNIDAD"),
            'prond_datosgenerales.idExpediente')
            //->where(['bcv.Validacion'=>1,'bcv.Activo'=>1])
            //->whereRaw("IFNULL(bcv.Validacion,0)!=1")
            ->whereRaw("prond_datosgenerales.idExpediente NOT IN (SELECT idExpediente FROM `bitcorreccionesvalidaciones` WHERE Validacion=1 and tabla ='prond_datosgenerales')")
            ->whereRaw("prond_datosgenerales.idExpediente NOT IN (SELECT idExpediente FROM `bitcorreccionesvalidaciones` WHERE Correccion=1 and Activo=1 and tabla ='prond_datosgenerales')")
            ->whereRaw("prond_datosgenerales.created_at > DATE_SUB(CURRENT_DATE(),INTERVAL WEEKDAY(CURRENT_DATE()) DAY)")
            ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
            });
          $prondCount = count(no_delictivos\nd_datosgenerales::leftjoin('bitcorreccionesvalidaciones as bcv', function($join)
            {
                $join->on('prond_datosgenerales.idExpediente','=','bcv.idExpediente')
                ->Where('bcv.tabla','=','prond_datosgenerales');
            })
            ->leftJoin('relusuarioexpedientes as rUE', function($join)
            {
              $join->on('rUE.idExpediente', '=', 'prond_datosgenerales.idExpediente')
              ->Where('rUE.tabla','=','prond_datosgenerales')->where('rUE.Activo','=',1);
            })
            ->leftJoin('users','rUE.idUsuario', '=', 'users.id')          
            ->select('prond_datosgenerales.created_at',DB::raw('"-" as NUC'),'NO_EXPEDIENTE',DB::raw("'Expediente no delictivo' as tabla"))
            //->where(['bcv.Validacion'=>1,'bcv.Activo'=>1])
            //->whereRaw("IFNULL(bcv.Validacion,0)!=1")
            ->whereRaw("prond_datosgenerales.idExpediente NOT IN (SELECT idExpediente FROM `bitcorreccionesvalidaciones` WHERE Validacion=1 and tabla ='prond_datosgenerales')")
            ->whereRaw("prond_datosgenerales.idExpediente NOT IN (SELECT idExpediente FROM `bitcorreccionesvalidaciones` WHERE Correccion=1 and Activo=1 and tabla ='prond_datosgenerales')")
            ->whereRaw("prond_datosgenerales.created_at < DATE_SUB(CURRENT_DATE(),INTERVAL WEEKDAY(CURRENT_DATE()) DAY)")
            ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
            })->distinct()->get()); 
        $SupExpV=$prode_->union($procc_)->union($prond_)->get();
        $SumaExpV=$prodeCount+$proccCount+$prondCount;        
          $prode_ = bitCorreccionesValidaciones::join('prode_datosgenerales as pde', function($join)
            {
                $join->on('pde.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                ->Where('bitcorreccionesvalidaciones.tabla','=','prode_datosgenerales');
            })
            ->leftJoin('relusuarioexpedientes as rUE', function($join)
            {
              $join->on('rUE.idExpediente', '=', 'pde.idExpediente')
              ->Where('rUE.tabla','=','prode_datosgenerales')->where('rUE.Activo','=',1);
            })
            ->leftJoin('catdelegaciones','pde.DELEGACION', '=', 'catdelegaciones.id')
            ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
            ->select('NUC_COMPLETA as NUC','NO_EXPEDIENTE',DB::raw("'Carpeta iniciada' as tabla"),DB::raw("'de' as carpeta"),
              'users.name AS MP_NAME','catdelegaciones.Valor AS MP_DELEGACION',DB::raw("CASE".
                      " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS MP_UNIDAD"),'pde.idExpediente')
            ->where(['bitcorreccionesvalidaciones.Correccion'=>1,'bitcorreccionesvalidaciones.Activo'=>1])
            ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
          });

          $procc_ = bitCorreccionesValidaciones::join('procc_datosgenerales as pcc', function($join)
            {
                $join->on('pcc.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                ->Where('bitcorreccionesvalidaciones.tabla','=','procc_datosgenerales');
            })
            ->leftJoin('relusuarioexpedientes as rUE', function($join)
            {
              $join->on('rUE.idExpediente', '=', 'pcc.idExpediente')
              ->Where('rUE.tabla','=','procc_datosgenerales')->where('rUE.Activo','=',1);
            })
            ->leftJoin('catdelegaciones','pcc.DELEGACION', '=', 'catdelegaciones.id')
            ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
            ->select(DB::raw('"-" as NUC'),'NO_EXPEDIENTE_CONDUCCION as NO_EXPEDIENTE',DB::raw("'Carpeta de conducción' as tabla"),DB::raw("'cc' as carpeta")
            ,'users.name AS MP_NAME','catdelegaciones.Valor AS MP_DELEGACION',DB::raw("CASE".
                      " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS MP_UNIDAD"),
            'pcc.idExpediente')
            ->where(['bitcorreccionesvalidaciones.Correccion'=>1,'bitcorreccionesvalidaciones.Activo'=>1])
            ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
          });

          $prond_ = bitCorreccionesValidaciones::join('prond_datosgenerales as pnd', function($join)
            {
                $join->on('pnd.idExpediente','=','bitcorreccionesvalidaciones.idExpediente')
                ->Where('bitcorreccionesvalidaciones.tabla','=','prond_datosgenerales');
            })
            ->leftJoin('relusuarioexpedientes as rUE', function($join)
            {
              $join->on('rUE.idExpediente', '=', 'pnd.idExpediente')
              ->Where('rUE.tabla','=','prond_datosgenerales')->where('rUE.Activo','=',1);
            })
            ->leftJoin('catdelegaciones','pnd.DELEGACION', '=', 'catdelegaciones.id')
            ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
            ->select(DB::raw('"-" as NUC'),'NO_EXPEDIENTE',DB::raw("'Expediente no delictivo' as tabla"),DB::raw("'nd' as carpeta"),
              'users.name AS MP_NAME','catdelegaciones.Valor AS MP_DELEGACION',DB::raw("CASE".
                      " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS MP_UNIDAD"),'pnd.idExpediente')
            ->where(['bitcorreccionesvalidaciones.Correccion'=>1,'bitcorreccionesvalidaciones.Activo'=>1])
            ->when($User->TipoUsuario==2,function($query) use ($User){
              $query->where('users.Unidad',$User->Unidad);
          });
        
        $SupExpC=$prode_->union($procc_)->union($prond_)->get();

        $SupExpP=causas_penales\cp_audienciainicial::Join('relusuarioexpedientes as rue', function($join)
            {
              $join->on('procp_audienciainicial.idExpediente','=','rue.idExpediente')
              ->Where('rue.tabla','=','prode_datosgenerales')->where('rue.Activo','=',1);
            })
          ->leftJoin('prode_datosgenerales as pdg','rue.idExpediente','=','pdg.idExpediente')
          ->leftJoin('users as us','rue.idUsuario','=','us.id')
          ->leftJoin('catdelegaciones','pdg.DELEGACION', '=', 'catdelegaciones.id')
          ->whereraw('(90-DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)<15)')
          ->whereraw("IFNULL(procp_audienciainicial.FECHA_CIERRE,'')=''")
          ->where('rue.Activo','=',1)
          ->groupby('rue.idExpediente')->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('us.Unidad',$User->Unidad);
          })   
          ->select('NUC_COMPLETA as NUC','NO_EXPEDIENTE',DB::raw("'Carpeta iniciada' as tabla"),DB::raw("'de' as carpeta"),
            'us.name AS MP_NAME','catdelegaciones.Valor AS MP_DELEGACION',DB::raw("CASE".
                      " WHEN us.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                      " WHEN us.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                      " WHEN us.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                      " WHEN us.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                      " WHEN us.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                      " WHEN us.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                      " WHEN us.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                      " WHEN us.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                      " WHEN us.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                      " WHEN us.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                      " WHEN us.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                      " WHEN us.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                      " WHEN us.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                      " WHEN us.Unidad = '80' THEN 'UNIDAD I'".
                      " ELSE '-'".
                  " END AS MP_UNIDAD"),'pdg.idExpediente',
            'procp_audienciainicial.FECHA_INICIO_INVESTIGACION',
            DB::raw('90-(DATEDIFF(NOW(),procp_audienciainicial.FECHA_INICIO_INVESTIGACION)) as dias'))->get();

        // array_push($arrAlert,['tipo'=>'primary']);
        // array_push($arrAlert,['tipo'=>'info','icon'=>'','mensaje'=>'']);
        // array_push($arrAlert,['icon'=>'info-fill','mensaje'=>'']);
        // array_push($arrAlert,['tipo'=>'dark','icon'=>'info-fill','mensaje'=>'aaaaaajaa!']);

        $post=0;                    
        #region Obtener listado de expedientes 
          if ($request->isMethod('post')){
            $post=1;

              switch ($request->tipo) {
                case 'de':
                  $tipo='';
                  $filtro=$request->input('filtroListado');
                
                  $filtro = str_replace('_c1_','prode_datosgenerales.idExpediente',$filtro);
                  $filtro = str_replace('_c2_','prode_datosgenerales.NO_EXPEDIENTE',$filtro);
                  $filtro = str_replace('_c3_','prode_datosgenerales.NUC_COMPLETA',$filtro);
                  $filtro = str_replace('_c3cp_','IFNULL(pcp.causas,"")',$filtro);                  
                  $filtro = str_replace('_c5_','users.name',$filtro);
                  $filtro = str_replace('_c6_','prode_datosgenerales.FECHA_INICIO_CARPETA',$filtro);
                  $filtro = str_replace('_c7_','prode_datosgenerales.FECHA_INICIO_CARPETA',$filtro);
                  $filtro = str_replace('_cFRD_','prode_datosgenerales.created_at',$filtro);
                  $filtro = str_replace('_cFRH_','prode_datosgenerales.created_at',$filtro);
                  $filtro = str_replace('_cFHD_',"STR_TO_DATE(prode_datosgenerales.FECHA_HECHOS, '%Y-%m-%d')",$filtro);
                  $filtro = str_replace('_cFHH_',"STR_TO_DATE(prode_datosgenerales.FECHA_HECHOS, '%Y-%m-%d')",$filtro);
                  $filtro = str_replace('_c81_','cv.Validacion',$filtro);
                  $filtro = str_replace("_c82_='1'",'IFNULL(cv.Validacion,0)!=1',$filtro);
                  $filtro = str_replace('_c83_','cv.Correccion',$filtro);
                  $filtro = str_replace("_c84_='1'",'(90-DATEDIFF(NOW(),pa.FECHA_INICIO_INVESTIGACION)<15)',$filtro);
                  $filtro = str_replace('_c9_','IFNULL(pdhg.delitos,"") LIKE "%',$filtro);
                  $filtro = str_replace('_c10_','IFNULL(pdig.imputados,"") LIKE "%',$filtro);
                  $filtro = str_replace('_c11_','IFNULL(pdvg.victimas,"") LIKE "%',$filtro);
                  $filtro = str_replace('_c12_','prode_datosgenerales.DELEGACION',$filtro);
                  $filtro = str_replace('_c13_',"(CASE WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE' WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE' WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE' WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA' WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA' WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA' WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA' WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA' WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA' WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO' WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO' WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO' WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS' WHEN users.Unidad = '80' THEN 'UNIDAD I' ELSE '-' END)",$filtro);
                  $filtro = str_replace('_LE_','%"',$filtro);

                  if ($filtro=='') {
                    $expedientes=datos_expediente\de_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
                        {
                          $join->on('rUE.idExpediente', '=', 'prode_datosgenerales.idExpediente')
                          ->Where('rUE.tabla','=','prode_datosgenerales')->where('rUE.Activo','=',1);
                        })
                        ->leftJoin('bitbasecaptura as bbc', function($join)
                          {
                            $join->on('bbc.idExpediente', '=', 'prode_datosgenerales.idExpediente')
                            ->Where('bbc.tipoExpediente','=',1);
                          })
                        ->leftJoin('catdelegaciones','prode_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
                      ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CAUSA_PENAL_ID)) causas, idExpediente FROM procp_datosgenerales WHERE deleted_at IS NULL GROUP BY idExpediente) as pcp"),'pcp.idExpediente', '=', 'prode_datosgenerales.idExpediente')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_IMPUTADO,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS))) imputados, idExpediente FROM prode_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'prode_datosgenerales.idExpediente')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(Valor) as delitos ,idExpediente FROM prode_hechos pdh left join catdelitosespecificos cde on pdh.DELITO=cde.id WHERE deleted_at IS NULL GROUP BY idExpediente) as pdhg"),'pdhg.idExpediente', '=', 'prode_datosgenerales.idExpediente')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_VICTIMA,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS))) victimas, idExpediente FROM prode_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'prode_datosgenerales.idExpediente')          
                      ->leftjoin(DB::raw("(select idExpediente,MAX(id) id from bitcorreccionesvalidaciones WHERE activo=1 and tabla='prode_datosgenerales' GROUP BY idExpediente) as maxcv"),
                        'maxcv.idExpediente','=','prode_datosgenerales.id')
                      ->leftjoin('bitcorreccionesvalidaciones as cv','cv.id','=','maxcv.id')
                      ->leftJoin('procp_audienciainicial as pa','pa.idExpediente','=','rUE.idExpediente')
                      ->select('catdelegaciones.Valor AS MP_DELEGACION',
                        //'bbc.RESPONSABLE','bbc.UNIDAD',
                        DB::raw("CASE".
                                  " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                                  " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                                  " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                                  " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                                  " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                                  " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                                  " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                                  " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                                  " ELSE '-'".
                              " END AS UNIDAD"),
                        DB::raw("CASE WHEN IFNULL(pa.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),pa.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                        'prode_datosgenerales.FECHA_INICIO_CARPETA',
                        'cv.Validacion','cv.Correccion','prode_datosgenerales.idExpediente','prode_datosgenerales.NUC_COMPLETA AS NUC','prode_datosgenerales.NO_EXPEDIENTE','users.id',
                        'users.name as RESPONSABLE','bbc.RESPONSABLE as name','users.email','rUE.Activo',
                        'prode_datosgenerales.created_at','prode_datosgenerales.FECHA_HECHOS',
                        'prode_datosgenerales.updated_at',
                        DB::raw('IFNULL(pcp.causas,"-") as causas'),
                        DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),
                        DB::raw('IFNULL(pdig.imputados,"-") as imputados'),
                        DB::raw('IFNULL(pdvg.victimas,"-") as victimas'))
                      ->where('rUE.Activo',1)
                      ->when($User->TipoUsuario==2,function($query) use ($User){
                          $query->where('users.Unidad',$User->Unidad);
                        })   
                      ->groupby('rUE.idExpediente')->OrderByDesc('users.id')->OrderByDesc('prode_datosgenerales.idExpediente')
                      ->paginate(10);
                  }
                  else
                  {
                    $expedientes=datos_expediente\de_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
                        {
                          $join->on('rUE.idExpediente', '=', 'prode_datosgenerales.idExpediente')
                          ->Where('rUE.tabla','=','prode_datosgenerales')->where('rUE.Activo','=',1);
                        })
                        ->leftJoin('bitbasecaptura as bbc', function($join)
                          {
                            $join->on('bbc.idExpediente', '=', 'prode_datosgenerales.idExpediente')
                            ->Where('bbc.tipoExpediente','=',1);
                          })
                        ->leftJoin('catdelegaciones','prode_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
                      ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CAUSA_PENAL_ID)) causas, idExpediente FROM procp_datosgenerales WHERE deleted_at IS NULL GROUP BY idExpediente) as pcp"),'pcp.idExpediente', '=', 'prode_datosgenerales.idExpediente')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_IMPUTADO,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS))) imputados, idExpediente FROM prode_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'prode_datosgenerales.idExpediente')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(Valor) as delitos ,idExpediente FROM prode_hechos pdh left join catdelitosespecificos cde on pdh.DELITO=cde.id WHERE deleted_at IS NULL GROUP BY idExpediente) as pdhg"),'pdhg.idExpediente', '=', 'prode_datosgenerales.idExpediente')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_VICTIMA,' ', PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS))) victimas, idExpediente FROM prode_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'prode_datosgenerales.idExpediente')          
                      ->leftjoin(DB::raw("(select idExpediente,MAX(id) id from bitcorreccionesvalidaciones WHERE activo=1 and tabla='prode_datosgenerales' GROUP BY idExpediente) as maxcv"),
                        'maxcv.idExpediente','=','prode_datosgenerales.id')
                      ->leftjoin('bitcorreccionesvalidaciones as cv','cv.id','=','maxcv.id')
                      ->leftJoin('procp_audienciainicial as pa','pa.idExpediente','=','rUE.idExpediente')
                      ->select('catdelegaciones.Valor AS MP_DELEGACION',
                        //'bbc.RESPONSABLE','bbc.UNIDAD',
                        DB::raw("CASE".
                                  " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                                  " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                                  " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                                  " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                                  " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                                  " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                                  " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                                  " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                                  " ELSE '-'".
                              " END AS UNIDAD"),
                        DB::raw("CASE WHEN IFNULL(pa.FECHA_CIERRE,'')!='' THEN 0 ELSE IFNULL((90-DATEDIFF(NOW(),pa.FECHA_INICIO_INVESTIGACION)<15),0) END as Vigencia"),
                        'prode_datosgenerales.FECHA_INICIO_CARPETA',
                        'cv.Validacion','cv.Correccion','prode_datosgenerales.idExpediente','prode_datosgenerales.NUC_COMPLETA AS NUC','prode_datosgenerales.NO_EXPEDIENTE','users.id',
                        'users.name as RESPONSABLE','bbc.RESPONSABLE as name','users.email','rUE.Activo',
                        'prode_datosgenerales.created_at','prode_datosgenerales.FECHA_HECHOS',
                        'prode_datosgenerales.updated_at',
                        DB::raw('IFNULL(pcp.causas,"-") as causas'),
                        DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),
                        DB::raw('IFNULL(pdig.imputados,"-") as imputados'),
                        DB::raw('IFNULL(pdvg.victimas,"-") as victimas'))
                      ->where('rUE.Activo',1)->whereRaw($filtro)
                      ->when($User->TipoUsuario==2,function($query) use ($User){
                          $query->where('users.Unidad',$User->Unidad);
                        })   
                      ->groupby('rUE.idExpediente')->OrderByDesc('users.id')->OrderByDesc('prode_datosgenerales.idExpediente')
                      ->paginate(100);
                 }
                 
                break;
                case 'cc':
                  $tipo='CC';              
                  $filtro=$request->input('filtroListado');
                  $filtro = str_replace('_c1_','procc_datosgenerales.idExpediente',$filtro);
                  $filtro = str_replace('_c2_','procc_datosgenerales.NO_EXPEDIENTE_CONDUCCION',$filtro);
                  $filtro = str_replace('_c5_','users.name',$filtro);
                  $filtro = str_replace('_c6_','procc_datosgenerales.FECHA_INICIO_CONDUCCION',$filtro);
                  $filtro = str_replace('_c7_','procc_datosgenerales.FECHA_INICIO_CONDUCCION',$filtro);
                  $filtro = str_replace('_cFRD_','procc_datosgenerales.created_at',$filtro);
                  $filtro = str_replace('_cFRH_','procc_datosgenerales.created_at',$filtro);
                  $filtro = str_replace('_cFHD_',"STR_TO_DATE(procc_datosgenerales.FECHA_HECHOS_CONDUCCION, '%Y-%m-%d')",$filtro);
                  $filtro = str_replace('_cFHH_',"STR_TO_DATE(procc_datosgenerales.FECHA_HECHOS_CONDUCCION, '%Y-%m-%d')",$filtro);                  
                  $filtro = str_replace('_c81_','cv.Validacion',$filtro);
                  $filtro = str_replace("_c82_='1'",'IFNULL(cv.Validacion,0)!=1',$filtro);
                  $filtro = str_replace('_c83_','cv.Correccion',$filtro);
                  $filtro = str_replace('_c9_','IFNULL(pdhg.delitos,"-") LIKE "%',$filtro);
                  $filtro = str_replace('_c10_','IFNULL(pdig.imputados,"-") LIKE "%',$filtro);
                  $filtro = str_replace('_c11_','IFNULL(pdvg.victimas,"-") LIKE "%',$filtro);
                  $filtro = str_replace('_c12_','procc_datosgenerales.DELEGACION',$filtro);
                  $filtro = str_replace('_c13_',"(CASE WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE' WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE' WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE' WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA' WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA' WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA' WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA' WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA' WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA' WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO' WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO' WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO' WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS' WHEN users.Unidad = '80' THEN 'UNIDAD I' ELSE '-' END)",$filtro);                  
                  $filtro = str_replace('_LE_','%"',$filtro);
                  
                  if ($filtro=='') {
                    $expedientesCC=carpeta_conduccion\cc_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
                        {
                          $join->on('rUE.idExpediente', '=', 'procc_datosgenerales.idExpediente')
                          ->Where('rUE.tabla','=','procc_datosgenerales')->where('rUE.Activo','=',1);
                        })
                        ->leftJoin('bitbasecaptura as bbc', function($join)
                          {
                            $join->on('bbc.idExpediente', '=', 'procc_datosgenerales.idExpediente')
                            ->Where('bbc.tipoExpediente','=',2);
                          })
                        ->leftJoin('catdelegaciones','procc_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
                      ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_IMPUTADO,' ',PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS_CONDUCCION))) imputados, idExpediente FROM procc_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'procc_datosgenerales.idExpediente')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(Valor) as delitos ,idExpediente FROM procc_hechos pdh left join catdelitosespecificos cde on pdh.DELITO=cde.id WHERE deleted_at IS NULL GROUP BY idExpediente) as pdhg"),'pdhg.idExpediente', '=', 'procc_datosgenerales.idExpediente')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_VICTIMA,' ',PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS_CONDUCCION))) victimas, idExpediente FROM procc_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'procc_datosgenerales.idExpediente')          
                      ->leftjoin(DB::raw("(select idExpediente,MAX(id) id from bitcorreccionesvalidaciones WHERE activo=1 and tabla='procc_datosgenerales' GROUP BY idExpediente) as maxcv"),
                        'maxcv.idExpediente','=','procc_datosgenerales.id')
                      ->leftjoin('bitcorreccionesvalidaciones as cv','cv.id','=','maxcv.id')
                      ->select('catdelegaciones.Valor AS MP_DELEGACION',
                        //'bbc.RESPONSABLE','bbc.UNIDAD',
                        DB::raw("CASE".
                                  " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                                  " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                                  " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                                  " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                                  " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                                  " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                                  " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                                  " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                                  " ELSE '-'".
                              " END AS UNIDAD"),
                        'cv.Validacion','cv.Correccion','procc_datosgenerales.idExpediente','procc_datosgenerales.NO_EXPEDIENTE_CONDUCCION','users.id',
                        'users.name as RESPONSABLE','bbc.RESPONSABLE as name',
                        'users.email','rUE.Activo',
                        'procc_datosgenerales.created_at','procc_datosgenerales.FECHA_HECHOS_CONDUCCION as FECHA_HECHOS',
                        'procc_datosgenerales.updated_at',
                        'procc_datosgenerales.FECHA_INICIO_CONDUCCION as FECHA_INICIO_CARPETA',
                        DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),
                        DB::raw('IFNULL(pdig.imputados,"-") as imputados'),
                        DB::raw('IFNULL(pdvg.victimas,"-") as victimas'))
                      ->where('rUE.Activo',1)->when($User->TipoUsuario==2,function($query) use ($User){
                          $query->where('users.Unidad',$User->Unidad);
                        })   
                      ->groupby('rUE.idExpediente')->OrderByDesc('users.id')->OrderByDesc('procc_datosgenerales.idExpediente')
                      ->paginate(10);
                  }
                  else
                  {
                    $expedientesCC=carpeta_conduccion\cc_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
                        {
                          $join->on('rUE.idExpediente', '=', 'procc_datosgenerales.idExpediente')
                          ->Where('rUE.tabla','=','procc_datosgenerales')->where('rUE.Activo','=',1);
                        })
                        ->leftJoin('bitbasecaptura as bbc', function($join)
                          {
                            $join->on('bbc.idExpediente', '=', 'procc_datosgenerales.idExpediente')
                            ->Where('bbc.tipoExpediente','=',2);
                          })
                        ->leftJoin('catdelegaciones','procc_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
                      ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_IMPUTADO,' ',PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_IMPUTADOS_CONDUCCION))) imputados, idExpediente FROM procc_imputados WHERE deleted_at IS NULL GROUP BY idExpediente) as pdig"),'pdig.idExpediente', '=', 'procc_datosgenerales.idExpediente')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(Valor) as delitos ,idExpediente FROM procc_hechos pdh left join catdelitosespecificos cde on pdh.DELITO=cde.id WHERE deleted_at IS NULL GROUP BY idExpediente) as pdhg"),'pdhg.idExpediente', '=', 'procc_datosgenerales.idExpediente')
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_VICTIMA,' ',PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS_CONDUCCION))) victimas, idExpediente FROM procc_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'procc_datosgenerales.idExpediente')          
                      ->leftjoin(DB::raw("(select idExpediente,MAX(id) id from bitcorreccionesvalidaciones WHERE activo=1 and tabla='procc_datosgenerales' GROUP BY idExpediente) as maxcv"),
                        'maxcv.idExpediente','=','procc_datosgenerales.id')
                      ->leftjoin('bitcorreccionesvalidaciones as cv','cv.id','=','maxcv.id')
                      ->select('catdelegaciones.Valor AS MP_DELEGACION',
                        //'bbc.RESPONSABLE','bbc.UNIDAD',
                        DB::raw("CASE".
                                  " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                                  " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                                  " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                                  " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                                  " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                                  " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                                  " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                                  " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                                  " ELSE '-'".
                              " END AS UNIDAD"),
                        'cv.Validacion','cv.Correccion','procc_datosgenerales.idExpediente','procc_datosgenerales.NO_EXPEDIENTE_CONDUCCION','users.id',
                        'users.name as RESPONSABLE','bbc.RESPONSABLE as name','users.email','rUE.Activo',
                        'procc_datosgenerales.created_at','procc_datosgenerales.FECHA_HECHOS_CONDUCCION as FECHA_HECHOS',
                        'procc_datosgenerales.updated_at',
                        'procc_datosgenerales.FECHA_INICIO_CONDUCCION as FECHA_INICIO_CARPETA',
                        DB::raw('IFNULL(pdhg.delitos,"-") as delitos'),
                        DB::raw('IFNULL(pdig.imputados,"-") as imputados'),
                        DB::raw('IFNULL(pdvg.victimas,"-") as victimas'))
                      ->where('rUE.Activo',1)->whereRaw($filtro)->when($User->TipoUsuario==2,function($query) use ($User){
                          $query->where('users.Unidad',$User->Unidad);
                        })   
                      ->groupby('rUE.idExpediente')->OrderByDesc('users.id')->OrderByDesc('procc_datosgenerales.idExpediente')->paginate(100);
                 }
                break;
                case 'nd':
                  $tipo='ND';              
                  $filtro=$request->input('filtroListado');
                  $filtro = str_replace('_c1_','prond_datosgenerales.idExpediente',$filtro);
                  $filtro = str_replace('_c2_','prond_datosgenerales.NO_EXPEDIENTE',$filtro);
                  $filtro = str_replace('_c5_','users.name',$filtro);
                  $filtro = str_replace('_c6_','prond_datosgenerales.FECHA_INICIO',$filtro);
                  $filtro = str_replace('_c7_','prond_datosgenerales.FECHA_INICIO',$filtro);
                  $filtro = str_replace('_cFRD_','prond_datosgenerales.created_at',$filtro);
                  $filtro = str_replace('_cFRH_','prond_datosgenerales.created_at',$filtro);
                  $filtro = str_replace('_cFHD_',"STR_TO_DATE(prond_datosgenerales.FECHA_HECHOS_NO_DELICTIVOS, '%Y-%m-%d')",$filtro);
                  $filtro = str_replace('_cFHH_',"STR_TO_DATE(prond_datosgenerales.FECHA_HECHOS_NO_DELICTIVOS, '%Y-%m-%d')",$filtro);                  
                  $filtro = str_replace('_c81_','cv.Validacion',$filtro);
                  $filtro = str_replace("_c82_='1'",'IFNULL(cv.Validacion,0)!=1',$filtro);
                  $filtro = str_replace('_c83_','cv.Correccion',$filtro);
                  $filtro = str_replace('_c9_','cr1.Valor LIKE "%',$filtro);
                  $filtro = str_replace('_c11_','IFNULL(pdvg.victimas,"-") LIKE "%',$filtro);
                  $filtro = str_replace('_c12_','prond_datosgenerales.DELEGACION',$filtro);
                  $filtro = str_replace('_c13_',"(CASE WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE' WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE' WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE' WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA' WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA' WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA' WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA' WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA' WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA' WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO' WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO' WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO' WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS' WHEN users.Unidad = '80' THEN 'UNIDAD I' ELSE '-' END)",$filtro);                  
                  $filtro = str_replace('_LE_','%"',$filtro);

                  if ($filtro=='') {
                    $expedientesND=no_delictivos\nd_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
                        {
                          $join->on('rUE.idExpediente', '=', 'prond_datosgenerales.idExpediente')
                          ->Where('rUE.tabla','=','prond_datosgenerales')->where('rUE.Activo','=',1);
                        })
                        ->leftJoin('bitbasecaptura as bbc', function($join)
                          {
                            $join->on('bbc.idExpediente', '=', 'prond_datosgenerales.idExpediente')
                            ->Where('bbc.tipoExpediente','=',3);
                          })
                        ->leftJoin('catdelegaciones','prond_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
                      ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
                      ->leftJoin('catrespuestas as cr1', function($join)
                      {
                        $join->on('prond_datosgenerales.HECHO_NO_DELITO','=','cr1.id')
                        ->Where('cr1.idTipoRespuesta','=',70);
                      })           
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_VICTIMA,' ',PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS_NO_DELICTIVO))) victimas, idExpediente FROM prond_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'prond_datosgenerales.idExpediente')

                      ->leftjoin(DB::raw("(select idExpediente,MAX(id) id from bitcorreccionesvalidaciones WHERE activo=1 and tabla='prond_datosgenerales' GROUP BY idExpediente) as maxcv"),
                        'maxcv.idExpediente','=','prond_datosgenerales.id')
                      ->leftjoin('bitcorreccionesvalidaciones as cv','cv.id','=','maxcv.id')
                      ->select('catdelegaciones.Valor AS MP_DELEGACION',
                        //'bbc.RESPONSABLE','bbc.UNIDAD',
                        DB::raw("CASE".
                                  " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                                  " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                                  " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                                  " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                                  " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                                  " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                                  " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                                  " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                                  " ELSE '-'".
                              " END AS UNIDAD"),
                        'cv.Validacion','cv.Correccion','prond_datosgenerales.idExpediente','prond_datosgenerales.NO_EXPEDIENTE','users.id',
                        'users.name as RESPONSABLE','bbc.RESPONSABLE as name', 'users.email','rUE.Activo',
                        'prond_datosgenerales.created_at','prond_datosgenerales.FECHA_HECHOS_NO_DELICTIVOS as FECHA_HECHOS',
                        'prond_datosgenerales.updated_at',
                        'prond_datosgenerales.FECHA_INICIO as FECHA_INICIO_CARPETA',
                        DB::raw("cr1.Valor as delitos"),DB::raw("'' as imputados"), DB::raw('IFNULL(pdvg.victimas,"-") as victimas'))
                      ->where('rUE.Activo',1)->when($User->TipoUsuario==2,function($query) use ($User){
                          $query->where('users.Unidad',$User->Unidad);
                        })   
                      ->groupby('rUE.idExpediente')->OrderByDesc('users.id')->OrderByDesc('prond_datosgenerales.idExpediente')
                      ->paginate(10);
                  }
                  else
                  {
                    $expedientesND=no_delictivos\nd_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
                        {
                          $join->on('rUE.idExpediente', '=', 'prond_datosgenerales.idExpediente')
                          ->Where('rUE.tabla','=','prond_datosgenerales')->where('rUE.Activo','=',1);
                        })
                        ->leftJoin('bitbasecaptura as bbc', function($join)
                          {
                            $join->on('bbc.idExpediente', '=', 'prond_datosgenerales.idExpediente')
                            ->Where('bbc.tipoExpediente','=',3);
                          })
                        ->leftJoin('catdelegaciones','prond_datosgenerales.DELEGACION', '=', 'catdelegaciones.id')
                      ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
                      ->leftJoin('catrespuestas as cr1', function($join)
                      {
                        $join->on('prond_datosgenerales.HECHO_NO_DELITO','=','cr1.id')
                        ->Where('cr1.idTipoRespuesta','=',70);
                      })           
                      ->leftjoin(DB::raw("(select GROUP_CONCAT(DISTINCT(CONCAT(NOMBRE_VICTIMA,' ',PRIMER_APELLIDO,' ', SEGUNDO_APELLIDO_VICTIMAS_NO_DELICTIVO))) victimas, idExpediente FROM prond_victimas WHERE deleted_at IS NULL GROUP BY idExpediente) as pdvg"),'pdvg.idExpediente', '=', 'prond_datosgenerales.idExpediente')

                      ->leftjoin(DB::raw("(select idExpediente,MAX(id) id from bitcorreccionesvalidaciones WHERE activo=1 and tabla='prond_datosgenerales' GROUP BY idExpediente) as maxcv"),
                        'maxcv.idExpediente','=','prond_datosgenerales.id')
                      ->leftjoin('bitcorreccionesvalidaciones as cv','cv.id','=','maxcv.id')
                      ->select('catdelegaciones.Valor AS MP_DELEGACION',
                        //'bbc.RESPONSABLE','bbc.UNIDAD',
                        DB::raw("CASE".
                                  " WHEN users.Unidad = '1' THEN 'ATENCION TEMPRANA RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '2' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '3' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE'".
                                  " WHEN users.Unidad = '4' THEN 'ATENCION TEMPRANA ARTEAGA'".
                                  " WHEN users.Unidad = '5' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA'".
                                  " WHEN users.Unidad = '6' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA'".
                                  " WHEN users.Unidad = '7' THEN 'ATENCION TEMPRANA GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '8' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '9' THEN 'UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA'".
                                  " WHEN users.Unidad = '10' THEN 'ATENCION TEMPRANA SALTILLO'".
                                  " WHEN users.Unidad = '11' THEN 'ATENCION TEMPRANA CON DETENIDO SALTILLO'".
                                  " WHEN users.Unidad = '12' THEN 'ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO'".
                                  " WHEN users.Unidad = '13' THEN 'ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS'".
                                  " WHEN users.Unidad = '80' THEN 'UNIDAD I'".
                                  " ELSE '-'".
                              " END AS UNIDAD"),
                        'cv.Validacion','cv.Correccion','prond_datosgenerales.idExpediente','prond_datosgenerales.NO_EXPEDIENTE','users.id',
                        'users.name as RESPONSABLE','bbc.RESPONSABLE as name','users.email','rUE.Activo',
                        'prond_datosgenerales.created_at','prond_datosgenerales.FECHA_HECHOS_NO_DELICTIVOS as FECHA_HECHOS',
                        'prond_datosgenerales.updated_at',
                        'prond_datosgenerales.FECHA_INICIO as FECHA_INICIO_CARPETA',
                        DB::raw("cr1.Valor as delitos"),DB::raw("'' as imputados"), DB::raw('IFNULL(pdvg.victimas,"-") as victimas'))
                      ->where('rUE.Activo',1)->whereRaw($filtro)->when($User->TipoUsuario==2,function($query) use ($User){
                            $query->where('users.Unidad',$User->Unidad);
                          })   
                      ->groupby('rUE.idExpediente')->OrderByDesc('users.id')->OrderByDesc('prond_datosgenerales.idExpediente')
                      ->paginate(100);
                 }
                break;
              }

          }
        #endregion
        $usuarios=User::whereNotIn('TipoUsuario',[99,2,3])->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
          })->get();
        $RegistrosTT = 0;
        $RegistrosDE = datos_expediente\de_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
                        {
                          $join->on('rUE.idExpediente', '=', 'prode_datosgenerales.idExpediente')
                          ->Where('rUE.tabla','=','prode_datosgenerales')->where('rUE.Activo','=',1);
                        })
                      ->leftJoin('users','rUE.idUsuario', '=', 'users.id')->where('rUE.Activo',1)
                      ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
          })   
                      ->groupby('rUE.idExpediente')->get();                      
        $RegistrosCC = carpeta_conduccion\cc_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
                        {
                          $join->on('rUE.idExpediente', '=', 'procc_datosgenerales.idExpediente')
                          ->Where('rUE.tabla','=','procc_datosgenerales')->where('rUE.Activo','=',1);
                        })
                      ->leftJoin('users','rUE.idUsuario', '=', 'users.id')->where('rUE.Activo',1)
                      ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
          })   
                      ->groupby('rUE.idExpediente')->get();
        $RegistrosND = no_delictivos\nd_datosgenerales::leftJoin('relusuarioexpedientes as rUE', function($join)
                        {
                          $join->on('rUE.idExpediente', '=', 'prond_datosgenerales.idExpediente')
                          ->Where('rUE.tabla','=','prond_datosgenerales')->where('rUE.Activo','=',1);
                        })
                      ->leftJoin('users','rUE.idUsuario', '=', 'users.id')->where('rUE.Activo',1)
                      ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
          })   
                      ->groupby('rUE.idExpediente')->get();
        $RegistrosTT=count($RegistrosDE)+count($RegistrosCC)+count($RegistrosND);
        $prode_ = datos_expediente\de_datosgenerales::leftjoin('bitcorreccionesvalidaciones as bcv', function($join)
                  {
                      $join->on('prode_datosgenerales.idExpediente','=','bcv.idExpediente')
                      ->Where('bcv.tabla','=','prode_datosgenerales');
                  })
                  ->leftJoin('relusuarioexpedientes as rUE', function($join)
                  {
                    $join->on('rUE.idExpediente', '=', 'prode_datosgenerales.idExpediente')
                    ->Where('rUE.tabla','=','prode_datosgenerales')->where('rUE.Activo','=',1);
                  })
                  ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
                  ->select('prode_datosgenerales.created_at','NUC_COMPLETA as NUC','NO_EXPEDIENTE',DB::raw("'Carpeta iniciada' as tabla"))
                  ->where(['bcv.Validacion'=>1,'bcv.Activo'=>1])
                  ->when($User->TipoUsuario==2,function($query) use ($User){
                    $query->where('users.Unidad',$User->Unidad);
                  });

        $procc_ = carpeta_conduccion\cc_datosgenerales::leftjoin('bitcorreccionesvalidaciones as bcv', function($join)
          {
              $join->on('procc_datosgenerales.idExpediente','=','bcv.idExpediente')
              ->Where('bcv.tabla','=','procc_datosgenerales');
          })
          ->leftJoin('relusuarioexpedientes as rUE', function($join)
          {
            $join->on('rUE.idExpediente', '=', 'procc_datosgenerales.idExpediente')
            ->Where('rUE.tabla','=','procc_datosgenerales')->where('rUE.Activo','=',1);
          })
          ->leftJoin('users','rUE.idUsuario', '=', 'users.id')
          ->select('procc_datosgenerales.created_at',DB::raw('"-" as NUC'),'NO_EXPEDIENTE_CONDUCCION as NO_EXPEDIENTE',
            DB::raw("'Carpeta de conducción' as tabla"))
          ->where(['bcv.Validacion'=>1,'bcv.Activo'=>1])
          ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
          });

        $prond_ = no_delictivos\nd_datosgenerales::leftjoin('bitcorreccionesvalidaciones as bcv', function($join)
          {
              $join->on('prond_datosgenerales.idExpediente','=','bcv.idExpediente')
              ->Where('bcv.tabla','=','prond_datosgenerales');
          })
          ->leftJoin('relusuarioexpedientes as rUE', function($join)
          {
            $join->on('rUE.idExpediente', '=', 'prond_datosgenerales.idExpediente')
            ->Where('rUE.tabla','=','prond_datosgenerales')->where('rUE.Activo','=',1);
          })
          ->leftJoin('users','rUE.idUsuario', '=', 'users.id')          
          ->select('prond_datosgenerales.created_at',DB::raw('"-" as NUC'),'NO_EXPEDIENTE',DB::raw("'Expediente no delictivo' as tabla"))
          ->where(['bcv.Validacion'=>1,'bcv.Activo'=>1])                
          ->when($User->TipoUsuario==2,function($query) use ($User){
            $query->where('users.Unidad',$User->Unidad);
          });
        $RegistrosTV=count($prode_->union($procc_)->union($prond_)->get());
        $delegaciones = DB::table('catdelegaciones')->where('Activo',1)->orderBy('id')->get();
        return view('supervisor.listadoExpedientes')->with([
          'SupExpC'=>$SupExpC,'SupExpP'=>$SupExpP,'SupExpV'=>$SupExpV,'SumaExpV'=>$SumaExpV,'arrAlert'=>$arrAlert,
          'expedientes'=>$expedientes, 'expedientesCC'=>$expedientesCC,'expedientesND'=>$expedientesND,
          'post'=>$post,'tipo'=>$tipo,'usuarios'=>$usuarios,
          'RegistrosTT'=>$RegistrosTT,'RegistrosDE'=>count($RegistrosDE),
          'RegistrosCC'=>count($RegistrosCC),'RegistrosND'=>count($RegistrosND),'RegistrosTV'=>$RegistrosTV
          ,'delegaciones'=>$delegaciones]); 
      }
    }

    function estadistica(Request $request)
    {
      if(is_null(Auth::User())) { return redirect("Salir"); }
      else
      {
        return view('supervisor.estadistica');
      }
    }
    public function GraficaPorDesagregacion(Request $request)
    {
      
        $desagregacion = $request->desagregacion;
        $data=[];
        switch ($request->grafica) {
          case '1':
              $xValues = [];
              $yValues1 = [];
              $yValues2 = []; 
              $yValues3 = [];          
            if ($desagregacion=="1") {
              $fechaInicio = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFin = Carbon::createFromFormat('m/Y', $request->periodoF);
              //for ($i=11; $i >=0 ; $i--) {
              while($fechaInicio->lessThanOrEqualTo($fechaFin)) {
              
              $yr='';$mn='';$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
              // $yr=now()->subMonth($i)->format('Y');
              // $mn=$meses[now()->subMonth($i)->format('n')-1];              
              $yr=$fechaInicio->format('Y');
              $mn=$meses[$fechaInicio->format('n')-1];

              $conc=datos_expediente\de_datosgenerales::where('ESTATUS_CARPETA','=',1)
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();
              $enpr=datos_expediente\de_datosgenerales::where('ESTATUS_CARPETA','=',2)
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();
              $inic=datos_expediente\de_datosgenerales::whereRaw('IFNULL(ESTATUS_CARPETA,-1) NOT IN (1,2)')
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();  
              $xValues[]=$mn."-".$yr;
              $yValues1[]=$conc;
              $yValues2[]=$enpr;
              $yValues3[]=$inic;
                $fechaInicio->addMonth();
              }
            }

            if ($desagregacion=="2") {

              foreach (DB::table('catdelegaciones')->get() as $key => $value) {
                $conc=datos_expediente\de_datosgenerales::where('ESTATUS_CARPETA','=',1)->where('DELEGACION','=',$value->id)->count();
                $enpr=datos_expediente\de_datosgenerales::where('ESTATUS_CARPETA','=',2)->where('DELEGACION','=',$value->id)->count();
                $inic=datos_expediente\de_datosgenerales::whereRaw('IFNULL(ESTATUS_CARPETA,-1) NOT IN (1,2)')->where('DELEGACION','=',$value->id)->count();
                $xValues[]=$value->Valor;
                $yValues1[]=$conc;
                $yValues2[]=$enpr;
                $yValues3[]=$inic;

              }
            }

            if ($desagregacion=="3") {


              foreach (DB::table('catuats')->where('Activo','=',1)->get() as $key => $value) {
                $conc=datos_expediente\de_datosgenerales::where('ESTATUS_CARPETA','=',1)->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $enpr=datos_expediente\de_datosgenerales::where('ESTATUS_CARPETA','=',2)->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $inic=datos_expediente\de_datosgenerales::whereRaw('IFNULL(ESTATUS_CARPETA,-1) NOT IN (1,2)')->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $xValues[]=$value->Valor;
                $yValues1[]=$conc;
                $yValues2[]=$enpr;
                $yValues3[]=$inic;
              }

            }
              $data=['xValues'=>$xValues,'yValues1'=>$yValues1,'yValues2'=>$yValues2,'yValues3'=>$yValues3];
          break;
          case '2':
              $xValues = [];
              $yValues1 = [];
              $yValues2 = []; 
              $totAT=0;
              $totDT=0;
            if ($desagregacion=="1") {
              $fechaInicio = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFin = Carbon::createFromFormat('m/Y', $request->periodoF);
              $fechaInicioT = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFinT = Carbon::createFromFormat('m/Y', $request->periodoF);
              $fechaFinT2 = Carbon::createFromFormat('m/Y', $request->periodoF);

              $totAT=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',4)
                ->whereRaw("FECHA_INICIO_CARPETA BETWEEN '".$fechaInicioT->firstOfMonth()."' AND '".$fechaFinT->lastOfMonth()."'")->count();
              $totDT=datos_expediente\de_datosgenerales::whereRaw('IFNULL(SENTIDO_DETERMINACION,-1) NOT IN (4)')
                ->whereRaw("FECHA_INICIO_CARPETA BETWEEN '".$fechaInicioT->firstOfMonth()."' AND '".$fechaFinT->lastOfMonth()."'")->count();
                // ->whereRaw("FECHA_INICIO_CARPETA>='".$fechaInicioT->firstOfMonth()."'")
                // ->whereRaw("FECHA_INICIO_CARPETA<'".$fechaFinT2->addMonth()->firstOfMonth()."'")->count();
              //for ($i=11; $i >=0 ; $i--) {

              while($fechaInicio->lessThanOrEqualTo($fechaFin)) {
              
              $yr='';$mn='';$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
              // $yr=now()->subMonth($i)->format('Y');
              // $mn=$meses[now()->subMonth($i)->format('n')-1];              
              $yr=$fechaInicio->format('Y');
              $mn=$meses[$fechaInicio->format('n')-1];              
              $conc=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',4)
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();
              $inic=datos_expediente\de_datosgenerales::whereRaw('IFNULL(SENTIDO_DETERMINACION,-1) NOT IN (4)')
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();  
              $xValues[]=$mn."-".$yr;
              $yValues1[]=$conc;
              $yValues2[]=$inic;
              $fechaInicio->addMonth();
              }
            }
            if ($desagregacion=="2") {

              $totAT=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',4)
              ->whereRaw('DELEGACION IN (SELECT id FROM catdelegaciones WHERE activo=1)')->count();
              $totDT=datos_expediente\de_datosgenerales::whereRaw('IFNULL(SENTIDO_DETERMINACION,-1) NOT IN (4)')
              ->whereRaw('DELEGACION IN (SELECT id FROM catdelegaciones WHERE activo=1)')->count();
              foreach (DB::table('catdelegaciones')->get() as $key => $value) {
                $conc=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',4)->where('DELEGACION','=',$value->id)->count();
                $inic=datos_expediente\de_datosgenerales::whereRaw('IFNULL(SENTIDO_DETERMINACION,-1) NOT IN (4)')->where('DELEGACION','=',$value->id)->count();
                $xValues[]=$value->Valor;
                $yValues1[]=$conc;
                $yValues2[]=$inic;
              }             
            }

            if ($desagregacion=="3") {
              $totAT=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',4)
              ->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4) IN (SELECT id FROM catuats WHERE activo=1)')->count();
              $totDT=datos_expediente\de_datosgenerales::whereRaw('IFNULL(SENTIDO_DETERMINACION,-1) NOT IN (4)')
              ->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4) IN (SELECT id FROM catuats WHERE activo=1)')->count();
              foreach (DB::table('catuats')->where('Activo','=',1)->get() as $key => $value) {
                $conc=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',4)->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)
                  ->count();
                $inic=datos_expediente\de_datosgenerales::whereRaw('IFNULL(SENTIDO_DETERMINACION,-1) NOT IN (4)')->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $xValues[]=$value->Valor;
                $yValues1[]=$conc;
                $yValues2[]=$inic;
              }             
            }              
              $data=['xValues'=>$xValues,'yValues1'=>$yValues1,'yValues2'=>$yValues2,'totAT'=>$totAT,'totDT'=>$totDT];
          break;
          case '3':
              $xValues = [];
              $yValues1 = [];
              $yValues2 = []; 
            if ($desagregacion=="1") {
              $fechaInicio = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFin = Carbon::createFromFormat('m/Y', $request->periodoF);
              //for ($i=11; $i >=0 ; $i--) {
              while($fechaInicio->lessThanOrEqualTo($fechaFin)) {
              
              $yr='';$mn='';$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
              // $yr=now()->subMonth($i)->format('Y');
              // $mn=$meses[now()->subMonth($i)->format('n')-1];              
              $yr=$fechaInicio->format('Y');
              $mn=$meses[$fechaInicio->format('n')-1];

              $xValues[]=$mn."-".$yr;              
              $yValues1[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',1)
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();
              $yValues2[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',2)
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();  
              $yValues3[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',3)
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();
              $yValues4[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',4)
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();  
              $yValues5[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',5)
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();  
              $yValues6[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',6)
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();
              $yValues7[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',7)
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();
              $yValues8[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',8)
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();
              $yValues9[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',9)
                ->whereRaw('YEAR(FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();
                $fechaInicio->addMonth();
              }
            }
            if ($desagregacion=="2") {

              foreach (DB::table('catdelegaciones')->get() as $key => $value) {
                $xValues[]=$value->Valor;
                $yValues1[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',1)->where('DELEGACION','=',$value->id)->count();
                $yValues2[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',2)->where('DELEGACION','=',$value->id)->count();
                $yValues3[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',3)->where('DELEGACION','=',$value->id)->count();
                $yValues4[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',4)->where('DELEGACION','=',$value->id)->count();
                $yValues5[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',5)->where('DELEGACION','=',$value->id)->count();
                $yValues6[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',6)->where('DELEGACION','=',$value->id)->count();
                $yValues7[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',7)->where('DELEGACION','=',$value->id)->count();
                $yValues8[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',8)->where('DELEGACION','=',$value->id)->count();
                $yValues9[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',9)->where('DELEGACION','=',$value->id)->count();
              }             
            }
            if ($desagregacion=="3") {

              foreach (DB::table('catuats')->where('Activo','=',1)->get() as $key => $value) {
                $xValues[]=$value->Valor;
                $yValues1[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',1)->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $yValues2[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',2)->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $yValues3[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',3)->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $yValues4[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',4)->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $yValues5[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',5)->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $yValues6[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',6)->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $yValues7[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',7)->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $yValues8[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',8)->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $yValues9[]=datos_expediente\de_datosgenerales::where('SENTIDO_DETERMINACION','=',9)->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count();
              }             
            }
              $data=['xValues'=>$xValues,'yValues1'=>$yValues1,'yValues2'=>$yValues2,'yValues3'=>$yValues3,'yValues4'=>$yValues4,
              'yValues5'=>$yValues5,'yValues6'=>$yValues6,'yValues7'=>$yValues7,'yValues8'=>$yValues8,'yValues9'=>$yValues9,];
          break;  
          case '4':
              $xValues = [];
              $yValues1 = [];
              $totalExp=0;
              $totalCP=0;              
            if ($desagregacion=="1") {
              $fechaInicio = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFin = Carbon::createFromFormat('m/Y', $request->periodoF);
              $fechaInicioT = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFinT = Carbon::createFromFormat('m/Y', $request->periodoF);
              $fechaFinT2 = Carbon::createFromFormat('m/Y', $request->periodoF);

              $totalExp=
              datos_expediente\de_datosgenerales::whereRaw("FECHA_INICIO_CARPETA BETWEEN '".$fechaInicioT->firstOfMonth()."' AND '".$fechaFinT->lastOfMonth()."'")
                ->count('id');
              $totalCP=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','procp_datosgenerales.idExpediente','=','pdg.id')
                ->whereRaw("FECHA_INICIO_CARPETA BETWEEN '".$fechaInicioT->firstOfMonth()."' AND '".$fechaFinT->lastOfMonth()."'")
                ->distinct('procp_datosgenerales.idExpediente')
                ->count('procp_datosgenerales.idExpediente');

              //for ($i=11; $i >=0 ; $i--) {
              while($fechaInicio->lessThanOrEqualTo($fechaFin)) {
              
              $yr='';$mn='';$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
              // $yr=now()->subMonth($i)->format('Y');
              // $mn=$meses[now()->subMonth($i)->format('n')-1];              
              $yr=$fechaInicio->format('Y');
              $mn=$meses[$fechaInicio->format('n')-1];

              $xValues[]=$mn."-".$yr;              
              $yValues1[]=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','procp_datosgenerales.idExpediente','=','pdg.id')
                ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->distinct('procp_datosgenerales.idExpediente')
                ->count('procp_datosgenerales.idExpediente');
                $fechaInicio->addMonth();
              }
            }
            if ($desagregacion=="2") {

              $totalExp=datos_expediente\de_datosgenerales::whereRaw('DELEGACION IN (SELECT id FROM catdelegaciones WHERE activo=1)')->count('id');
              $totalCP=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','procp_datosgenerales.idExpediente','=','pdg.id')
                ->whereRaw('DELEGACION IN (SELECT id FROM catdelegaciones WHERE activo=1)')->distinct('procp_datosgenerales.idExpediente')
                ->count('procp_datosgenerales.idExpediente');
              foreach (DB::table('catdelegaciones')->get() as $key => $value) {
                $xValues[]=$value->Valor;
                $yValues1[]=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','procp_datosgenerales.idExpediente','=','pdg.id')
                  ->where('DELEGACION','=',$value->id)->distinct('procp_datosgenerales.idExpediente')->count('procp_datosgenerales.idExpediente');

              }             
            }

            if ($desagregacion=="3") {
              $totalExp=datos_expediente\de_datosgenerales::whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4) IN (SELECT id FROM catuats WHERE activo=1)')
                ->count('id');
              $totalCP=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','procp_datosgenerales.idExpediente','=','pdg.id')
                ->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4) IN (SELECT id FROM catuats WHERE activo=1)')->distinct('procp_datosgenerales.idExpediente')
                ->count('procp_datosgenerales..idExpediente');

              foreach (DB::table('catuats')->where('Activo','=',1)->get() as $key => $value) {
                $xValues[]=$value->Valor;
                $yValues1[]=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','procp_datosgenerales.idExpediente','=','pdg.id')
                  ->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->distinct('procp_datosgenerales.idExpediente')
                  ->count('procp_datosgenerales.idExpediente');
              }             
            }              
              $data=['xValues'=>$xValues,'yValues1'=>$yValues1,'totalExp'=>$totalExp,'totalCP'=>$totalCP];
          break;
          case '5':
              $xValues = [];
              $yValues1 = [];

            if ($desagregacion=="1") {

              $fechaInicio = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFin = Carbon::createFromFormat('m/Y', $request->periodoF);
              //for ($i=11; $i >=0 ; $i--) {
              while($fechaInicio->lessThanOrEqualTo($fechaFin)) {
              
              $yr='';$mn='';$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
              // $yr=now()->subMonth($i)->format('Y');
              // $mn=$meses[now()->subMonth($i)->format('n')-1];              
              $yr=$fechaInicio->format('Y');
              $mn=$meses[$fechaInicio->format('n')-1];

              $xValues[]=$mn."-".$yr;              
              $yValues1[]=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','procp_datosgenerales.idExpediente','=','pdg.id')
              ->leftJoin('procp_ai_imputados as paii', function($join)
              {
                $join->on('paii.idCausa','=','procp_datosgenerales.id')
                ->whereNull('paii.deleted_at');
              })
              ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
              ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))
              ->where('paii.RESOLUCION','=',1)->distinct('procp_datosgenerales.idExpediente')->count('procp_datosgenerales.idExpediente');
              
              $yValues2[]=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','procp_datosgenerales.idExpediente','=','pdg.id')
              ->leftJoin('procp_ai_imputados as paii', function($join)
              {
                $join->on('paii.idCausa','=','procp_datosgenerales.id')
                ->whereNull('paii.deleted_at');
              })
              ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
              ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))
              ->where('paii.RESOLUCION','=',2)->distinct('procp_datosgenerales.idExpediente')->count('procp_datosgenerales.idExpediente');
              $fechaInicio->addMonth();
              }
            }
            if ($desagregacion=="2") {

              foreach (DB::table('catdelegaciones')->get() as $key => $value) {
                $xValues[]=$value->Valor;
                $yValues1[]=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','procp_datosgenerales.idExpediente','=','pdg.id')
                ->leftJoin('procp_ai_imputados as paii', function($join)
                {
                  $join->on('paii.idCausa','=','procp_datosgenerales.id')
                  ->whereNull('paii.deleted_at');
                })
                ->where('DELEGACION','=',$value->id)
                ->where('paii.RESOLUCION','=',1)->distinct('procp_datosgenerales.idExpediente')->count('procp_datosgenerales.idExpediente');

                $yValues2[]=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','procp_datosgenerales.idExpediente','=','pdg.id')
                ->leftJoin('procp_ai_imputados as paii', function($join)
                {
                  $join->on('paii.idCausa','=','procp_datosgenerales.id')
                  ->whereNull('paii.deleted_at');
                })
                ->where('DELEGACION','=',$value->id)
                ->where('paii.RESOLUCION','=',2)->distinct('procp_datosgenerales.idExpediente')->count('procp_datosgenerales.idExpediente');

              }             
            }

            if ($desagregacion=="3") {

              foreach (DB::table('catuats')->where('Activo','=',1)->get() as $key => $value) {
                $xValues[]=$value->Valor;
                $yValues1[]=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','procp_datosgenerales.idExpediente','=','pdg.id')
                ->leftJoin('procp_ai_imputados as paii', function($join)
                {
                  $join->on('paii.idCausa','=','procp_datosgenerales.id')
                  ->whereNull('paii.deleted_at');
                })
                ->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)
                ->where('paii.RESOLUCION','=',1)->distinct('procp_datosgenerales.idExpediente')->count('procp_datosgenerales.idExpediente');
                
                $yValues2[]=causas_penales\cp_datosgenerales::leftjoin('prode_datosgenerales as pdg','procp_datosgenerales.idExpediente','=','pdg.id')
                ->leftJoin('procp_ai_imputados as paii', function($join)
                {
                  $join->on('paii.idCausa','=','procp_datosgenerales.id')
                  ->whereNull('paii.deleted_at');
                })
                ->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)
                ->where('paii.RESOLUCION','=',2)->distinct('procp_datosgenerales.idExpediente')->count('procp_datosgenerales.idExpediente');
              }             
            }

              $data=['xValues'=>$xValues,'yValues1'=>$yValues1,'yValues2'=>$yValues2];
          break;
          case '6':
              $xValues = [];
              $yValues1 = [];
              $yValues2 = [];
              $yValues3 = [];
              $yValues4 = [];

            if ($desagregacion=="1") {
              $fechaInicio = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFin = Carbon::createFromFormat('m/Y', $request->periodoF);
              //for ($i=11; $i >=0 ; $i--) {
              while($fechaInicio->lessThanOrEqualTo($fechaFin)) {
              
              $yr='';$mn='';$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
              // $yr=now()->subMonth($i)->format('Y');
              // $mn=$meses[now()->subMonth($i)->format('n')-1];              
              $yr=$fechaInicio->format('Y');
              $mn=$meses[$fechaInicio->format('n')-1];

                $xValues[]=$mn."-".$yr;              
                $count2=causas_penales\cp_sa_suspensiones::leftjoin('procp_salidasalternas as psa','procp_sa_suspensiones.id_cp_salidasalternas','=','psa.id')
                  ->leftjoin('prode_datosgenerales as pdg','psa.idExpediente','=','pdg.id')
                  ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                  ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))
                  ->count('procp_sa_suspensiones.id');
                $yValues2[]=$count2;
                $count3=causas_penales\cp_sa_acuerdos::leftjoin('procp_salidasalternas as psa','procp_sa_acuerdos.id_cp_salidasalternas','=','psa.id')
                  ->leftjoin('prode_datosgenerales as pdg','psa.idExpediente','=','pdg.id')
                  ->where('ACUERDO_REPARATORIO','=',1)
                  ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                  ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))
                  ->count('procp_sa_acuerdos.id');
                $yValues3[]=$count3;
                $count4=causas_penales\cp_sa_acuerdos::leftjoin('procp_salidasalternas as psa','procp_sa_acuerdos.id_cp_salidasalternas','=','psa.id')
                  ->leftjoin('prode_datosgenerales as pdg','psa.idExpediente','=','pdg.id')
                  ->where('ACUERDO_REPARATORIO','=',2)
                  ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                  ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))
                  ->count('procp_sa_acuerdos.id');
                $yValues4[]=$count4;
                $yValues1[]=$count2+$count3+$count4;
                $fechaInicio->addMonth();
              }
            }
            if ($desagregacion=="2") {

              foreach (DB::table('catdelegaciones')->get() as $key => $value) {
                $xValues[]=$value->Valor;
                $count2=causas_penales\cp_sa_suspensiones::leftjoin('procp_salidasalternas as psa','procp_sa_suspensiones.id_cp_salidasalternas','=','psa.id')
                  ->leftjoin('prode_datosgenerales as pdg','psa.idExpediente','=','pdg.id')
                  ->where('DELEGACION','=',$value->id)
                  ->count('procp_sa_suspensiones.id');
                $yValues2[]=$count2;
                $count3=causas_penales\cp_sa_acuerdos::leftjoin('procp_salidasalternas as psa','procp_sa_acuerdos.id_cp_salidasalternas','=','psa.id')
                  ->leftjoin('prode_datosgenerales as pdg','psa.idExpediente','=','pdg.id')
                  ->where('ACUERDO_REPARATORIO','=',1)
                  ->where('DELEGACION','=',$value->id)
                  ->count('procp_sa_acuerdos.id');
                $yValues3[]=$count3;
                $count4=causas_penales\cp_sa_acuerdos::leftjoin('procp_salidasalternas as psa','procp_sa_acuerdos.id_cp_salidasalternas','=','psa.id')
                  ->leftjoin('prode_datosgenerales as pdg','psa.idExpediente','=','pdg.id')
                  ->where('ACUERDO_REPARATORIO','=',2)
                  ->where('DELEGACION','=',$value->id)
                  ->count('procp_sa_acuerdos.id');
                $yValues4[]=$count4;
                $yValues1[]=$count2+$count3+$count4;                  
              }             
            }
            if ($desagregacion=="3") {

              foreach (DB::table('catuats')->where('Activo','=',1)->get() as $key => $value) {
                $xValues[]=$value->Valor;

                $count2=causas_penales\cp_sa_suspensiones::leftjoin('procp_salidasalternas as psa','procp_sa_suspensiones.id_cp_salidasalternas','=','psa.id')
                  ->leftjoin('prode_datosgenerales as pdg','psa.idExpediente','=','pdg.id')
                  ->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)->count('procp_sa_suspensiones.id');
                $yValues2[]=$count2;
                $count3=causas_penales\cp_sa_acuerdos::leftjoin('procp_salidasalternas as psa','procp_sa_acuerdos.id_cp_salidasalternas','=','psa.id')
                  ->leftjoin('prode_datosgenerales as pdg','psa.idExpediente','=','pdg.id')
                  ->where('ACUERDO_REPARATORIO','=',1)
                  ->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)
                  ->count('procp_sa_acuerdos.id');
                $yValues3[]=$count3;
                $count4=causas_penales\cp_sa_acuerdos::leftjoin('procp_salidasalternas as psa','procp_sa_acuerdos.id_cp_salidasalternas','=','psa.id')
                  ->leftjoin('prode_datosgenerales as pdg','psa.idExpediente','=','pdg.id')
                  ->where('ACUERDO_REPARATORIO','=',2)
                  ->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4)='.$value->id)
                  ->count('procp_sa_acuerdos.id');
                $yValues4[]=$count4;
                $yValues1[]=$count2+$count3+$count4;
              }             
            }
              $data=['xValues'=>$xValues,'yValues1'=>$yValues1,'yValues2'=>$yValues2,'yValues3'=>$yValues3,'yValues4'=>$yValues4];
          break;
          case '7':
              $xValues = [];
              $yValues1 = [];
              $yValues2 = [];
              $yValues3 = [];
              $yValues4 = [];
              $yValues5 = [];
              $yValues6 = [];                            

            if ($desagregacion=="1") {
              $fechaInicio = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFin = Carbon::createFromFormat('m/Y', $request->periodoF);
              //for ($i=11; $i >=0 ; $i--) {
              while($fechaInicio->lessThanOrEqualTo($fechaFin)) {
              
              $yr='';$mn='';$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
              // $yr=now()->subMonth($i)->format('Y');
              // $mn=$meses[now()->subMonth($i)->format('n')-1];              
              $yr=$fechaInicio->format('Y');
              $mn=$meses[$fechaInicio->format('n')-1];
                $xValues[]=$mn."-".$yr;              
                $count2=causas_penales\cp_procedimientoabreviado::leftjoin('prode_datosgenerales as pdg','procp_procedimientoabreviado.idExpediente','=','pdg.id')
                  ->where('ESTATUS_ABREVIADO','=',2)
                  ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                  ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))
                  ->count('procp_procedimientoabreviado.id');
                $yValues2[]=$count2;   
                $count3=causas_penales\cp_jo_imputados::leftjoin('prode_datosgenerales as pdg','procp_jo_imputados.idExpediente','=','pdg.id')
                  ->where('TIPO_SENTENCIA','=',2)
                  ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                  ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))
                  ->count('procp_jo_imputados.id');
                $yValues3[]=$count3;
                $yValues1[]=$count2+$count3;

                $count5=causas_penales\cp_jo_imputados::leftjoin('prode_datosgenerales as pdg','procp_jo_imputados.idExpediente','=','pdg.id')
                  ->where('TIPO_SENTENCIA','=',2)
                  ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                  ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))
                  ->count('procp_jo_imputados.id');
                $yValues5[]=$count5;   
                $count6=causas_penales\cp_jo_imputados::leftjoin('prode_datosgenerales as pdg','procp_jo_imputados.idExpediente','=','pdg.id')
                  ->where('TIPO_SENTENCIA','=',1)
                  ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                  ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))
                  ->count('procp_jo_imputados.id');
                $yValues6[]=$count6;
                $yValues4[]=$count5+$count6;
                $fechaInicio->addMonth();
              }
            }
            if ($desagregacion=="2") {

              foreach (DB::table('catdelegaciones')->get() as $key => $value) {
                $xValues[]=$value->Valor;
                $count2=causas_penales\cp_procedimientoabreviado::leftjoin('prode_datosgenerales as pdg','procp_procedimientoabreviado.idExpediente','=','pdg.id')
                  ->where('ESTATUS_ABREVIADO','=',2)
                  ->where('DELEGACION','=',$value->id)
                  ->count('procp_procedimientoabreviado.id');
                $yValues2[]=$count2;
                $count3=causas_penales\cp_jo_imputados::leftjoin('prode_datosgenerales as pdg','procp_jo_imputados.idExpediente','=','pdg.id')
                  ->where('procp_jo_imputados.TIPO_SENTENCIA','=',2)
                  ->where('DELEGACION','=',$value->id)
                  ->count('procp_jo_imputados.id');
                $yValues3[]=$count3;
                $yValues1[]=$count2+$count3;
                $count5=causas_penales\cp_jo_imputados::leftjoin('prode_datosgenerales as pdg','procp_jo_imputados.idExpediente','=','pdg.id')
                  ->where('procp_jo_imputados.TIPO_SENTENCIA','=',2)
                  ->where('DELEGACION','=',$value->id)
                  ->count('procp_jo_imputados.id');
                $yValues5[]=$count5;
                $count6=causas_penales\cp_jo_imputados::leftjoin('prode_datosgenerales as pdg','procp_jo_imputados.idExpediente','=','pdg.id')
                  ->where('procp_jo_imputados.TIPO_SENTENCIA','=',1)
                  ->where('DELEGACION','=',$value->id)
                  ->count('procp_jo_imputados.id');
                $yValues6[]=$count6;
                $yValues4[]=$count5+$count6;
              }             
            }
            if ($desagregacion=="3") {

              foreach (DB::table('catrespuestas')->where('idTipoRespuesta','=',17)->get() as $key => $value) {
                $xValues[]=$value->Valor;
                $count2=causas_penales\cp_procedimientoabreviado::leftjoin('procp_dg_imputados as pdgi','procp_procedimientoabreviado.idImputado','=','pdgi.id')
                ->leftjoin('prode_imputados as pdi','pdgi.idImputado','=','pdi.id')
                  ->where('pdi.SEXO_IMPUTADO','=',$value->id)
                  ->count('procp_procedimientoabreviado.id');
                $yValues2[]=$count2;

                $count3=causas_penales\cp_jo_imputados::leftjoin('procp_dg_imputados as pdgi','procp_jo_imputados.idImputado','=','pdgi.id')
                ->leftjoin('prode_imputados as pdi','pdgi.idImputado','=','pdi.id')
                  ->where('procp_jo_imputados.TIPO_SENTENCIA','=',2)
                  ->where('pdi.SEXO_IMPUTADO','=',$value->id)
                  ->count('procp_jo_imputados.id');
                $yValues3[]=$count3;
                $yValues1[]=$count2+$count3;
                
                $count5=causas_penales\cp_jo_imputados::leftjoin('procp_dg_imputados as pdgi','procp_jo_imputados.idImputado','=','pdgi.id')
                ->leftjoin('prode_imputados as pdi','pdgi.idImputado','=','pdi.id')
                  ->where('procp_jo_imputados.TIPO_SENTENCIA','=',2)
                  ->where('pdi.SEXO_IMPUTADO','=',$value->id)
                  ->count('procp_jo_imputados.id');
                $yValues5[]=$count5;
                $count6=causas_penales\cp_jo_imputados::leftjoin('procp_dg_imputados as pdgi','procp_jo_imputados.idImputado','=','pdgi.id')
                ->leftjoin('prode_imputados as pdi','pdgi.idImputado','=','pdi.id')
                  ->where('procp_jo_imputados.TIPO_SENTENCIA','=',1)
                  ->where('pdi.SEXO_IMPUTADO','=',$value->id)
                  ->count('procp_jo_imputados.id');
                $yValues6[]=$count6;
                $yValues4[]=$count5+$count6;                

              }             
            }
              $data=['xValues'=>$xValues,'yValues1'=>$yValues1,'yValues2'=>$yValues2,'yValues3'=>$yValues3,'yValues4'=>$yValues4,'yValues5'=>$yValues5,'yValues6'=>$yValues6];
          break;
          case '8':
              $xValues = [];
              $yValues1 = [];
            if ($desagregacion=="1") {
              $fechaInicio = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFin = Carbon::createFromFormat('m/Y', $request->periodoF);
              //for ($i=11; $i >=0 ; $i--) {
              while($fechaInicio->lessThanOrEqualTo($fechaFin)) {
              
              $yr='';$mn='';$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
              // $yr=now()->subMonth($i)->format('Y');
              // $mn=$meses[now()->subMonth($i)->format('n')-1];              
              $yr=$fechaInicio->format('Y');
              $mn=$meses[$fechaInicio->format('n')-1];

              $xValues[]=$mn."-".$yr;              
              $suma=causas_penales\cp_sa_acuerdos::leftjoin('procp_salidasalternas as pcpsa','procp_sa_acuerdos.id_cp_salidasalternas','=','pcpsa.id')
                  ->leftjoin('prode_datosgenerales as pdg','pcpsa.idExpediente','=','pdg.id')
                  ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))
                ->select(DB::raw('SUM(REPLACE(procp_sa_acuerdos.MONTO_REP_DAÑO,",","")) as suma'))->first();
              $yValues1[]=$suma->suma;
              $fechaInicio->addMonth();
              }
            }
            if ($desagregacion=="2") {
              $fechaInicio = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFin = Carbon::createFromFormat('m/Y', $request->periodoF);
              //for ($i=5; $i >=0 ; $i--) {
              while($fechaInicio->lessThanOrEqualTo($fechaFin)) {                            
                $yr='';
                $yr=$fechaInicio->format('Y');
                $xValues[]=$yr;              
                $suma=causas_penales\cp_sa_acuerdos::leftjoin('procp_salidasalternas as pcpsa','procp_sa_acuerdos.id_cp_salidasalternas','=','pcpsa.id')
                  ->leftjoin('prode_datosgenerales as pdg','pcpsa.idExpediente','=','pdg.id')
                  ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->select(DB::raw('SUM(REPLACE(procp_sa_acuerdos.MONTO_REP_DAÑO,",","")) as suma'))->first();
                $yValues1[]=$suma->suma;
                $fechaInicio->addYear();
              }

            }

            if ($desagregacion=="3") {              
              foreach (DB::table('catdelegaciones')->where('Activo','=',1)->get() as $key => $value) {
                $xValues[]=$value->Valor;
                $suma=causas_penales\cp_sa_acuerdos::leftjoin('procp_salidasalternas as pcpsa','procp_sa_acuerdos.id_cp_salidasalternas','=','pcpsa.id')
                  ->leftjoin('prode_datosgenerales as pdg','pcpsa.idExpediente','=','pdg.id')
                  ->where('DELEGACION','=',$value->id)->select(DB::raw('SUM(REPLACE(procp_sa_acuerdos.MONTO_REP_DAÑO,",","")) as suma'))->first();
                $yValues1[]=$suma->suma;


              }                 
            }            
              $data=['xValues'=>$xValues,'yValues1'=>$yValues1];
          break;          
          case '9':
              $xValues = [];
              $yValues1 = [];
              $yValues2 = []; 
              $totAT=0;
              $totDT=0;              
            if ($desagregacion=="1") {
              $fechaInicio = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFin = Carbon::createFromFormat('m/Y', $request->periodoF);
              $fechaInicioT = Carbon::createFromFormat('m/Y', $request->periodoI);
              $fechaFinT = Carbon::createFromFormat('m/Y', $request->periodoF);
              $fechaFinT2 = Carbon::createFromFormat('m/Y', $request->periodoF);  

              $totDL=datos_expediente\de_imputados::leftjoin('prode_datosgenerales as pdg','prode_imputados.idExpediente','=','pdg.id')
                ->where('EXAMEN_DETENCION_IMPUTADOS','=',1)
                ->whereRaw("FECHA_INICIO_CARPETA BETWEEN '".$fechaInicioT->firstOfMonth()."' AND '".$fechaFinT->lastOfMonth()."'")->count();
              $totDI=datos_expediente\de_imputados::leftjoin('prode_datosgenerales as pdg','prode_imputados.idExpediente','=','pdg.id')
                ->whereRaw('IFNULL(EXAMEN_DETENCION_IMPUTADOS,-1) NOT IN (1)')
                ->whereRaw("FECHA_INICIO_CARPETA BETWEEN '".$fechaInicioT->firstOfMonth()."' AND '".$fechaFinT->lastOfMonth()."'")->count();
                
              //for ($i=11; $i >=0 ; $i--) {
              while($fechaInicio->lessThanOrEqualTo($fechaFin)) {
              
              $yr='';$mn='';$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
              // $yr=now()->subMonth($i)->format('Y');
              // $mn=$meses[now()->subMonth($i)->format('n')-1];              
              $yr=$fechaInicio->format('Y');
              $mn=$meses[$fechaInicio->format('n')-1];              
              $detL=datos_expediente\de_imputados::leftjoin('prode_datosgenerales as pdg','prode_imputados.idExpediente','=','pdg.id')
                ->where('EXAMEN_DETENCION_IMPUTADOS','=',1)
                ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();
              $detI=datos_expediente\de_imputados::leftjoin('prode_datosgenerales as pdg','prode_imputados.idExpediente','=','pdg.id')
                ->whereRaw('IFNULL(EXAMEN_DETENCION_IMPUTADOS,-1) NOT IN (1)')
                ->whereRaw('YEAR(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('Y'))
                ->whereRaw('MONTH(pdg.FECHA_INICIO_CARPETA)='.$fechaInicio->format('n'))->count();  
              $xValues[]=$mn."-".$yr;
              $yValues1[]=$detL;
              $yValues2[]=$detI;
              $fechaInicio->addMonth();
              }
            }
            if ($desagregacion=="2") {
              $totDL=datos_expediente\de_imputados::leftjoin('prode_datosgenerales as pdg','prode_imputados.idExpediente','=','pdg.id')
                ->where('EXAMEN_DETENCION_IMPUTADOS','=',1)
                ->whereRaw('DELEGACION IN (SELECT id FROM catdelegaciones WHERE activo=1)')->count();
              $totDI=datos_expediente\de_imputados::leftjoin('prode_datosgenerales as pdg','prode_imputados.idExpediente','=','pdg.id')
                ->whereRaw('IFNULL(EXAMEN_DETENCION_IMPUTADOS,-1) NOT IN (1)')
                ->whereRaw('DELEGACION IN (SELECT id FROM catdelegaciones WHERE activo=1)')->count();

              foreach (DB::table('catdelegaciones')->get() as $key => $value) {
                $detL=datos_expediente\de_imputados::leftjoin('prode_datosgenerales as pdg','prode_imputados.idExpediente','=','pdg.id')
                  ->where('EXAMEN_DETENCION_IMPUTADOS','=',1)->where('pdg.DELEGACION','=',$value->id)->count();
                $detI=datos_expediente\de_imputados::leftjoin('prode_datosgenerales as pdg','prode_imputados.idExpediente','=','pdg.id')
                  ->whereRaw('IFNULL(EXAMEN_DETENCION_IMPUTADOS,-1) NOT IN (1)')->where('pdg.DELEGACION','=',$value->id)->count();
                $xValues[]=$value->Valor;
                $yValues1[]=$detL;
                $yValues2[]=$detI;
              }             
            }

            if ($desagregacion=="3") {
              $totDL=datos_expediente\de_imputados::leftjoin('prode_datosgenerales as pdg','prode_imputados.idExpediente','=','pdg.id')
                ->where('EXAMEN_DETENCION_IMPUTADOS','=',1)
                ->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4) IN (SELECT id FROM catuats WHERE activo=1)')->count();
              $totDI=datos_expediente\de_imputados::leftjoin('prode_datosgenerales as pdg','prode_imputados.idExpediente','=','pdg.id')
                ->whereRaw('IFNULL(EXAMEN_DETENCION_IMPUTADOS,-1) NOT IN (1)')
                ->whereRaw('IFNULL(NULLIF(UNIDAD_ATENCION,-1),4) IN (SELECT id FROM catuats WHERE activo=1)')->count();

              foreach (DB::table('catuats')->where('Activo','=',1)->get() as $key => $value) {
                $detL=datos_expediente\de_imputados::leftjoin('prode_datosgenerales as pdg','prode_imputados.idExpediente','=','pdg.id')
                  ->where('EXAMEN_DETENCION_IMPUTADOS','=',1)->whereRaw('IFNULL(NULLIF(pdg.UNIDAD_ATENCION,-1),4)='.$value->id)->count();
                $detI=datos_expediente\de_imputados::leftjoin('prode_datosgenerales as pdg','prode_imputados.idExpediente','=','pdg.id')
                  ->whereRaw('IFNULL(EXAMEN_DETENCION_IMPUTADOS,-1) NOT IN (1)')->whereRaw('IFNULL(NULLIF(pdg.UNIDAD_ATENCION,-1),4)='.$value->id)
                  ->count();
                $xValues[]=$value->Valor;
                $yValues1[]=$detL;
                $yValues2[]=$detI;
              }             
            }
              $data=['xValues'=>$xValues,'yValues1'=>$yValues1,'yValues2'=>$yValues2,'totDL'=>$totDL,'totDI'=>$totDI];
          break;
        }

        return response()->json($data);
    }

    public function exportDE_DG(request $request) 
    {
        // return Excel::download(new datosExpediente('2023-05-25 11:57:54','2023-05-25 11:58:00'),'users.xlsx');
      $v=$request->validate([
      'fechaInicio' => 'required',
      'fechaFin' => 'required',
      ],
      [
        'fechaInicio.required'=>'la fecha de inicio es requerida',
        'fechaFin.required'=>'la Fecha de conclusión es requerida',
      ]);

      return (new ExcelExport($request->fechaInicio,$request->fechaFin))
        ->download('baseGeneral_SIDE_Coahuila_'.now()->format('Ymd-His').'.xlsx');

     }
    public function exportINEGI(request $request) 
    {      
        if ($request->parte && $request->anio) {      
          $v=$request->validate([
          'anio' => 'required',
          'parte' => 'required',
          ],
          [
            'anio.required'=>'el campo es requerida',
            'parte.required'=>'el campo es requerida',
          ]);    
          return (new datosTablas($request->anio,$request->parte))->download('extraccion_'.$request->parte.'_'.now()->format('Ymd-His').'.xlsx');
        }
        if ($request->parte2 && $request->anio2) {
          $v=$request->validate([
          'anio2' => 'required',
          'parte2' => 'required',
          ],
          [
            'anio2.required'=>'el campo es requerida',
            'parte2.required'=>'el campo es requerida',
          ]);    
          return (new datosTablas($request->anio2,$request->parte2))->download('extraccion_'.$request->parte2.'_'.now()->format('Ymd-His').'.xlsx');
        }

        

     }
}
