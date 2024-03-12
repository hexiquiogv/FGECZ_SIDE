<?php

namespace App\Exports;

use App\Models\datos_expediente;
use App\Models\causas_penales;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class datosTablas implements FromQuery,WithHeadings
{
    use Exportable;

    public function __construct(int $year, string $tipo)
    {
        $this->year = $year;
        $this->tipo = $tipo;
    }
    public function headings(): array
    {
     switch ($this->tipo) {
      case 'INEGI1':
      case 'INEGI2':
      case 'INEGI3':
      case 'INEGI4':
      case 'INEGI5':
      case 'INEGI6':
      case 'INEGI7':
      case 'INEGI8':
      case 'INEGI9':
      case 'INEGI10':
      case 'INEGI11':
      case 'INEGI12':
      case 'INEGI13':
      case 'INEGI14':
      case 'INEGI15':
      case 'INEGI16':
      case 'INEGI17':
      case 'INEGI18':
      case 'INEGI19':
      case 'INEGI20':
      case 'INEGI21':
      case 'INEGI22':
      case 'INEGI23':
      case 'INEGI24':
      case 'INEGI25':
      case 'INEGI26':
      case 'INEGI27':
      case 'INEGI28':
      case 'INEGI29':
      case 'INEGI30':
      case 'INEGI31':
      case 'INEGI32':
      case 'INEGI33':
      case 'INEGI34':      
      case 'INEGI35':      
      case 'INEGI36':      
      case 'INEGI37':      
      case 'INEGI38':      
      case 'INEGI39':      
      case 'INEGI40':      
      case 'INEGI41':      
        return [
          'AÑO', 'MES', 'DELEGACION',  'INDICADOR', 'TIPO DE DESAGREGACION', 'DESAGREGACION_1','DESAGREGACION_2', 'UNIDAD'
        ];
      break;
      case 'SESNSP1':
      case 'SESNSP2':
      case 'SESNSP3':
      case 'SESNSP4':
      case 'SESNSP5':
        return [
          'AÑO', 'MES', 'DELEGACION',  'INDICADOR', 'TIPO DE DESAGREGACION', 'DESAGREGACION_1','DESAGREGACION_2', 'UNIDAD'
        ];
      break;
      }
    }
    public function query()
    {DB::statement("SET SQL_MODE=''");
       $sql=datos_expediente\de_datosgenerales::query()->take(1);
        switch ($this->tipo) {
          case 'INEGI1':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;
            //001 - "ACTOS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA " - "TIPO DE ACTO SIN CONTROL JUDICIAL" ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {

                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_ev_actosconsin as b', function($join) use($mes)
                    {
                      $join->on('b.TIPO_ACTOS_CONSIN','=','a.id')
                      ->whereNull('b.deleted_at')->Where('b.CONSIN','=','sin')
                      ->WhereRaw('YEAR(b.created_at)=1000')
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',30)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"ACTOS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA " as INDICADOR'),
                      DB::raw('"TIPO DE ACTO SIN CONTROL JUDICIAL" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //002 - "ACTOS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA " - "TIPO DE ACTO CON CONTROL JUDICIAL" ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {

                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_ev_actosconsin as b', function($join) use($mes)
                    {
                      $join->on('b.TIPO_ACTOS_CONSIN','=','a.id')
                      ->whereNull('b.deleted_at')->Where('b.CONSIN','=','con')
                      ->WhereRaw('YEAR(b.created_at)=1000')
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',29)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"ACTOS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA " as INDICADOR'),
                      DB::raw('"TIPO DE ACTO CON CONTROL JUDICIAL" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }              
            //003 - "ACTOS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" - "TIPO DE ACTO SIN CONTROL JUDICIAL"
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {

                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_ev_actos as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_ACTOS_DE_INV','=','a.id')
                      ->whereNull('b.deleted_at')->Where('b.TIPO_CONTROL_ACTOS_DE_INV','=',2)
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',30)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"ACTOS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"TIPO DE ACTO SIN CONTROL JUDICIAL" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('CASE WHEN YEAR(b.created_at) IS NULL OR MONTH(b.created_at) IS NULL OR c.DELEGACION IS NULL THEN "0" ELSE CAST(COUNT(b.TIPO_ACTOS_DE_INV) as char) END as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //004 - "ACTOS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" - "TIPO DE ACTO CON CONTROL JUDICIAL"
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {

                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_ev_actos  as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_ACTOS_DE_INV','=','a.id')
                      ->whereNull('b.deleted_at')->Where('b.TIPO_CONTROL_ACTOS_DE_INV','=',1)
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',29)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"ACTOS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"TIPO DE ACTO CON CONTROL JUDICIAL" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('CASE WHEN YEAR(b.created_at) IS NULL OR MONTH(b.created_at) IS NULL OR c.DELEGACION IS NULL THEN "0" ELSE CAST(COUNT(b.TIPO_ACTOS_DE_INV) AS char) END as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //005 - ARCHIVOS TEMPORALES DETERMINADOS Y REACTIVADOS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - MOTIVO ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $motivos=['POR CONTAR CON NUEVOS ANTECEDENTES, DATOS O ELEMENTOS',
                  'POR RESOLUCIÓN D ELA PERSONA JUZGADORA DE CONTROL O GARANTÍAS',
                  'POR DECRETAR EL NO EJERCICIO DE LA ACCIÓN PENAL',
                  'A PETICIÓN DE LA VÍCTIMA O PERSONA OFENDIDA',
                  'OTRO MOTIVO',
                  'NO IDENTIFICADO'];
                  foreach ($motivos as $keyM => $valueM) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"ARCHIVOS TEMPORALES DETERMINADOS Y REACTIVADOS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                        DB::raw('"MOTIVO" as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueM.'" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                  }               
                }
              }   
            //006 - "BIENES REPORTADOS Y/O DENUNCIADOS COMO ROBADOS " - "TIPO DE BIEN" ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=["PARES DE CALZADO", 
                    "PARES DE CALZADO DEPORTIVO", 
                    "ROPA", 
                    "JUGUETES", 
                    "BEBIDAS ALCOHÓLICAS", 
                    "CABLEADO O INSTALACIÓN DE COBRE", 
                    "CILINDROS O TANQUES DE GAS LP", 
                    "MOBILIARIO", 
                    "EQUIPO ELECTRÓNICO", 
                    "EQUIPO MÉDICO", 
                    "EQUIPO Y/O HERRAMIENTAS DE TRABAJO PARA LA CONSTRUCCIÓN", 
                    "ELECTRODOMÉSTICOS", 
                    "BOLSAS, MALETAS O PORTAFOLIOS", 
                    "JOYAS", 
                    "RELOJES", 
                    "DINERO EN EFECTIVO", 
                    "CHEQUES O TARJETAS DE CRÉDITO O DÉBITO", 
                    "IDENTIFICACIONES OFICIALES O DOCUMENTOS ", 
                    "TELÉFONOS CELULARES", 
                    "BICICLETAS ", 
                    "AUTOPARTES", 
                    "PLACAS DE VEHÍCULOS", 
                    "OTRO TIPO DE BIENES", 
                  ];
                  foreach ($rangos as $keyR => $valueR) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"BIENES REPORTADOS Y/O DENUNCIADOS COMO ROBADOS" as INDICADOR'),
                      DB::raw('"TIPO DE BIEN" as TIPO_DESAGREGACION'),
                      DB::raw('"'.$valueR.'" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }  
              // foreach ($delegaciones as $key => $value) {
                //   $del=$value->id;
                //   for ($mes = 1; $mes <= 12; $mes++) {

                //     $sql = DB::table('catrespuestas as a')
                //       ->Where('a.idTipoRespuesta','=',25)
                //       ->select(DB::raw($anio.' as year'),
                //         DB::raw($mes.' as month'),
                //         DB::raw('"'.$value->Valor.'" as delVal'),
                //         DB::raw('"BIENES REPORTADOS Y/O DENUNCIADOS COMO ROBADOS" as INDICADOR'),
                //         DB::raw('"TIPO DE BIEN" as TIPO_DESAGREGACION'),
                //         'a.Valor as DESAGREGACION_1',
                //         DB::raw('"" as DESAGREGACION_2'),
                //         DB::raw('"0" as UNIDAD')
                //       )
                //       ->groupby('a.id');

                //     if($c < 1){
                //         $salida1 = $sql;
                //     }else{
                //         $salida1->union($sql);
                //     }
                //     $c++;                  
                //   }
              // }

            //007 si- "CARPETAS DE INVESTIGACIÓN ABIERTAS - PERSONA INCULPADA
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $siD = datos_expediente\de_imputados::leftJoin('prode_datosgenerales as c','prode_imputados.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('YEAR(c.created_at)='.$anio)
                      ->WhereRaw('MONTH(c.created_at)='.$mes)
                    ->select('prode_imputados.idExpediente',DB::raw("'SI' as DETENIDO"))
                    ->groupby('prode_imputados.idExpediente')
                    ->havingRaw('SUM(CASE WHEN DETENIDO_IMPUTADOS<0 THEN 0 ELSE DETENIDO_IMPUTADOS END)=COUNT(DETENIDO_IMPUTADOS)')->get();                  
                    $subsqlSI = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"PERSONA INCULPADA" as TIPO_DESAGREGACION'),
                        DB::raw('"CON PERSONA INCULPADA" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"'.$siD->count().'" as UNIDAD')
                      );

                    $sql = $subsqlSI;
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //007 no - "CARPETAS DE INVESTIGACIÓN ABIERTAS - PERSONA INCULPADA
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {                  
                  $noD = datos_expediente\de_imputados::leftJoin('prode_datosgenerales as c','prode_imputados.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('YEAR(c.created_at)='.$anio)
                      ->WhereRaw('MONTH(c.created_at)='.$mes)
                    ->select('prode_imputados.idExpediente',DB::raw("'SI' as DETENIDO"))
                    ->groupby('prode_imputados.idExpediente')
                    ->havingRaw('SUM(CASE WHEN DETENIDO_IMPUTADOS<0 THEN 0 ELSE DETENIDO_IMPUTADOS END)=0')->get();

                    $subsqlNO = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"PERSONA INCULPADA" as TIPO_DESAGREGACION'),
                        DB::raw('"SIN PERSONA INCULPADA" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"'.$noD->count().'" as UNIDAD')
                      );

                    $sql = $subsqlNO;
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }        
            //007 mix - "CARPETAS DE INVESTIGACIÓN ABIERTAS - PERSONA INCULPADA
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {                  
                  $mixD = datos_expediente\de_imputados::leftJoin('prode_datosgenerales as c','prode_imputados.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('YEAR(c.created_at)='.$anio)
                      ->WhereRaw('MONTH(c.created_at)='.$mes)
                    ->select('prode_imputados.idExpediente',DB::raw("'SI' as DETENIDO"))
                    ->groupby('prode_imputados.idExpediente')
                    ->havingRaw('SUM(CASE WHEN DETENIDO_IMPUTADOS<0 THEN 0 ELSE DETENIDO_IMPUTADOS END)!=COUNT(DETENIDO_IMPUTADOS) AND SUM(CASE WHEN DETENIDO_IMPUTADOS<0 THEN 0 ELSE DETENIDO_IMPUTADOS END)>0')->get();

                    $subsqlMIX = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"PERSONA INCULPADA" as TIPO_DESAGREGACION'),
                        DB::raw('"MIXTA" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"'.$mixD->count().'" as UNIDAD')
                      );

                    $sql = $subsqlMIX;
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                            

          break;
          case 'INEGI2':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;
            //008 - "CARPETAS DE INVESTIGACIÓN ABIERTAS - FUERO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join)
                    {
                      $join->on('b.FUERO','=','a.id')
                      ->whereNull('b.deleted_at');
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del,$anio,$mes)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('YEAR(c.created_at)='.$anio)
                      ->WhereRaw('MONTH(c.created_at)='.$mes);
                    })
                    ->Where('a.idTipoRespuesta','=',8)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"FUERO" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');


                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //009 - "CARPETAS DE INVESTIGACIÓN ABIERTAS - MOTIVO ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"DERIVACIÓN A MASC" as TIPO_DESAGREGACION'),
                        DB::raw('"" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;          
                }
              } 
            //010 - "CARPETAS DE INVESTIGACIÓN EN LAS QUE SE REALIZARON ACTOS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA  ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"CARPETAS DE INVESTIGACIÓN EN LAS QUE SE REALIZARON ACTOS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                        DB::raw('"" as TIPO_DESAGREGACION'),
                        DB::raw('"" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;             
                }
              }   
            //011 - "CARPETAS DE INVESTIGACIÓN EN LAS QUE SE REALIZARON ACTOS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL"
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $siD = causas_penales\cp_ev_actos::leftJoin('prode_datosgenerales as c','procp_ev_actos.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('YEAR(c.created_at)='.$anio)
                      ->WhereRaw('MONTH(c.created_at)='.$mes)
                    ->select('procp_ev_actos.idExpediente',DB::raw("'SI' as DETENIDO"))
                    ->groupby('procp_ev_actos.idExpediente')
                    ->havingRaw('COUNT(procp_ev_actos.id) > 0')->get();

                  $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"CARPETAS DE INVESTIGACIÓN EN LAS QUE SE REALIZARON ACTOS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"" as TIPO_DESAGREGACION'),
                      DB::raw('"" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"'.$siD->count().'" as UNIDAD')
                    );                      


                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }     
            //012 - "CONDUCTAS NO CONSTITUTIVAS DE DELITOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS  ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"CONDUCTAS NO CONSTITUTIVAS DE DELITOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"" as TIPO_DESAGREGACION'),
                        DB::raw('"" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;                
                }
              } 
            //013 - "CONDUCTAS NO CONSTITUTIVAS DE DELITOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL  ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"CONDUCTAS NO CONSTITUTIVAS DE DELITOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                        DB::raw('"" as TIPO_DESAGREGACION'),
                        DB::raw('"" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;    
                }
              } 
            //014 - "CONDUCTAS NO CONSTITUTIVAS DE DELITOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - - OTRAS DETERMINACIONES Y/O CONCLUSIONES ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"CONDUCTAS NO CONSTITUTIVAS DE DELITOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                        DB::raw('"" as TIPO_DESAGREGACION'),
                        DB::raw('"OTRAS DETERMINACIONES Y/O CONCLUSIONES" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                }
              } 
            //015 - "CONDUCTAS NO CONSTITUTIVAS DE DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA  ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"CONDUCTAS NO CONSTITUTIVAS DE DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                        DB::raw('"" as TIPO_DESAGREGACION'),
                        DB::raw('"" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;         
                }
              } 
            //016 - "CONDUCTAS NO CONSTITUTIVAS DE DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL  ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"CONDUCTAS NO CONSTITUTIVAS DE DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                        DB::raw('"" as TIPO_DESAGREGACION'),
                        DB::raw('"" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;           
                }
              } 
          break;
          case 'INEGI3':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;

            //017 CyS- "DELITO DE COMERCIO DE NARCÓTICOS, DELITO DE POSESIÓN CON FINES DE COMERCIO O SUMINISTRO DE NARCÓTICOS y DELITO DE POSESIÓN SIMPLE DE NARCÓTICOS - GRADO DE CONSUMACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $CyS = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.CONSUMACION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereBetween('b.DELITO_JUR',[788,792])
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',5)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITO DE COMERCIO Y SUMINISTRO DE NARCÓTICOS" as INDICADOR'),
                      DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');

                  $sql=$CyS;

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //017 PF- "DELITO DE COMERCIO DE NARCÓTICOS, DELITO DE POSESIÓN CON FINES DE COMERCIO O SUMINISTRO DE NARCÓTICOS y DELITO DE POSESIÓN SIMPLE DE NARCÓTICOS - GRADO DE CONSUMACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  
                  $PFC = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.CONSUMACION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereBetween('b.DELITO_JUR',[793,793])
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',5)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITO DE POSESIÓN CON FINES DE COMERCIO O SUMINISTRO DE NARCÓTICOS" as INDICADOR'),
                      DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');
                                     
                  $sql=$PFC;

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //017 PS- "DELITO DE COMERCIO DE NARCÓTICOS, DELITO DE POSESIÓN CON FINES DE COMERCIO O SUMINISTRO DE NARCÓTICOS y DELITO DE POSESIÓN SIMPLE DE NARCÓTICOS - GRADO DE CONSUMACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $PS = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.CONSUMACION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereBetween('b.DELITO_JUR',[794,794])
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',5)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITO DE POSESIÓN SIMPLE DE NARCÓTICOS" as INDICADOR'),
                      DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                      
                  $sql=$PS;

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                             
            //018 - "DELITOS COMETIDOS A LAS VÍCTIMAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DE PERSONA - FISICA - SEXO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_victimas as b', function($join)
                    {
                      $join->on('b.SEXO_VICTIMA','=','a.id')
                      ->where('b.TIPO_VICTIMA','=',1)
                      ->whereNull('b.deleted_at');
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('c.id','=','b.idExpediente')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->leftJoin('bitde_relaciondelito as d', function($join)
                    {
                      $join->on('d.idExpediente','=','c.id')
                      ->whereNull('d.deleted_at');
                    })
                    ->leftJoin('prode_relaciondelito as e', function($join) use($anio,$mes)
                    {
                      $join->on('e.idVictima','=','b.id')->on('e.idRelacion','=','d.id')
                      ->whereNull('e.deleted_at')
                      ->WhereRaw('YEAR(e.created_at)='.$anio)
                      ->WhereRaw('MONTH(e.created_at)='.$mes);                        
                    })

                                         
                    ->Where('a.idTipoRespuesta','=',17)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS COMETIDOS A LAS VÍCTIMAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"TIPO DE PERSONA" as TIPO_DESAGREGACION'),
                      DB::raw('"FISICA" as DESAGREGACION_1'),
                      'a.Valor as DESAGREGACION_2',
                      DB::raw('count(e.idRelacion) as UNIDAD')
                    )
                    ->groupby('a.id');
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //019 - "DELITOS COMETIDOS A LAS VÍCTIMAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DE PERSONA - MORAL - SECTOR
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_victimas as b', function($join)
                    {
                      $join->on('b.SECTOR_VICTIMAS','=','a.id')
                      ->where('b.TIPO_VICTIMA','=',2)
                      ->whereNull('b.deleted_at');
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('c.id','=','b.idExpediente')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->leftJoin('bitde_relaciondelito as d', function($join)
                    {
                      $join->on('d.idExpediente','=','c.id')
                      ->whereNull('d.deleted_at');
                    })
                    ->leftJoin('prode_relaciondelito as e', function($join) use($anio,$mes)
                    {
                      $join->on('e.idVictima','=','b.id')->on('e.idRelacion','=','d.id')
                      ->whereNull('e.deleted_at')
                      ->WhereRaw('YEAR(e.created_at)='.$anio)
                      ->WhereRaw('MONTH(e.created_at)='.$mes);                        
                    })

                                         
                    ->Where('a.idTipoRespuesta','=',15)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS COMETIDOS A LAS VÍCTIMAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"TIPO DE PERSONA" as TIPO_DESAGREGACION'),
                      DB::raw('"MORAL" as DESAGREGACION_1'),
                      'a.Valor as DESAGREGACION_2',
                      DB::raw('count(e.idRelacion) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //020 - "DELITOS COMETIDOS A LAS VÍCTIMAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DE PERSONA - OTRO TIPO DE VÍCTIMA y NO IDENTIFICADA
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {

                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_victimas as b', function($join)
                    {
                      $join->on('b.TIPO_VICTIMA','=','a.id')
                      ->whereIn('b.TIPO_VICTIMA',[5,6])
                      ->whereNull('b.deleted_at');
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('c.id','=','b.idExpediente')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->leftJoin('bitde_relaciondelito as d', function($join)
                    {
                      $join->on('d.idExpediente','=','c.id')
                      ->whereNull('d.deleted_at');
                    })
                    ->leftJoin('prode_relaciondelito as e', function($join) use($anio,$mes)
                    {
                      $join->on('e.idVictima','=','b.id')->on('e.idRelacion','=','d.id')
                      ->whereNull('e.deleted_at')
                      ->WhereRaw('YEAR(e.created_at)='.$anio)
                      ->WhereRaw('MONTH(e.created_at)='.$mes);                        
                    })
                    ->Where('a.idTipoRespuesta','=',13)->whereIn('a.id',[5,6])
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS COMETIDOS A LAS VÍCTIMAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"TIPO DE PERSONA" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(e.idRelacion) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 

          break;
          case 'INEGI4':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;

            //021 a - "DELITOS COMETIDOS A LAS VÍCTIMAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[
                    ["VIDA E INTEGRIDAD CORPORAL", "HOMICIDIO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "FEMINICIDIO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "ABORTO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "LESIONES"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "OTROS DELITOS CONTRA LA VIDA Y LA INTEGRIDAD"], 
                    ["LIBERTAD PERSONAL ", "PRIVACIÓN DE LA LIBERTAD"], 
                    ["LIBERTAD PERSONAL ", "TRÁFICO DE MENORES"], 
                    ["LIBERTAD PERSONAL ", "RETENCIÓN O SUSTRACCIÓN DE MENORES E INCAPACES"], 
                    ["LIBERTAD PERSONAL ", "RAPTO"], 
                    ["LIBERTAD PERSONAL ", "DESAPARICIÓN FORZADA DE PERSONAS"], 
                    ["LIBERTAD PERSONAL ", "SECUESTRO"], 
                    ["LIBERTAD PERSONAL ", "OTROS DELITOS CONTRA LA LIBERTAD PERSONAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ABUSO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ACOSO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "HOSTIGAMIENTO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "VIOLACIÓN"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ESTUPRO"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "INCESTO"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "OTROS DELITOS CONTRA LA LIBERTAD Y SEGURIDAD SEXUAL"], 
                    ["PATRIMONIO", "ROBO"], 
                    ["PATRIMONIO", "HIDROCARBUROS Y DERIVADOS"], 
                    ["PATRIMONIO", "FRAUDE"], 
                    ["PATRIMONIO", "ABUSO DE CONFIANZA"], 
                    ["PATRIMONIO", "EXTORSIÓN"], 
                    ["PATRIMONIO", "DAÑO A LA PROPIEDAD"], 
                    ["PATRIMONIO", "DESPOJO"], 
                    ["PATRIMONIO", "OTROS DELITOS CONTRA EL PATRIMONIO"], 
                    ["FAMILIA", "VIOLENCIA FAMILIAR"], 
                    ["FAMILIA", "INCUMPLIMIENTO DE OBLIGACIONES FAMILIARES"], 
                    ["FAMILIA", "OTROS DELITOS CONTRA LA FAMILIA"], 
                    ["SOCIEDAD", "LIBRE DESARROLLO DE LA PERSONALIDAD"], 
                    ["SOCIEDAD", "TRATA DE PERSONAS"], 
                    ["SOCIEDAD", "VIOLENCIA DE GÉNERO "], 
                    ["SOCIEDAD", "DISCRIMINACIÓN"], 
                    ["SOCIEDAD", "LENOCINIO"], 
                    ["SOCIEDAD", "OTROS DELITOS COTRA LA SOCIEDAD "]
                  ];
                  foreach ($valores as $keyV => $valueV) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS COMETIDOS A LAS VÍCTIMAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }   
          break;
          case 'INEGI5':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;
            //021 b - "DELITOS COMETIDOS A LAS VÍCTIMAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS CONTRA LA SALUD MODALIDAD NARCOMENUDEO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS FEDERALES CONTRA LA SALUD RELACIONADOS CON NARCÓTICOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "EVASIÓN DE PRESOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS Y OBJETOS PROHIBIDOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELINCUENCIA ORGANIZADA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS, EXPLOSIVOS Y OTROS MATERIALES DESTRUCTIVOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "ASOCIACIÓN DELICTUOSA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "TERRORISMO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "OTROS DELITOS CONTRA LA SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "HECHOS DE CORRUPCIÓN"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS CONTRA LA ADMINISTRACIÓN DE JUSTICIA"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS EN MATERIAL FISCAL"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS ELECTORALES"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "OTROS DELITOS CONTRA LA ADMINISTRACIÓN DEL ESTADO"], 
                    ["OTROS DELITOS", "AMENAZAS"], 
                    ["OTROS DELITOS", "ALLANAMIENTO DE MORADA"], 
                    ["OTROS DELITOS", "FALSEDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA EL MEDIO AMBIENTE"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE VÍAS DE COMUNICACIÓN Y CORRRESPONDENCIA"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE MIGRACIÓN"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE DERECHOS DE AUTOR"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE INSTITUCIONES DE CRÉDITO, INVERSIÓN, FINANZAS Y SEGUROS"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE PROPIEDAD INTELECTUAL"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SALUD NO RELACIONADOS CON NARCÓTICOS"], 
                    ["OTROS DELITOS", "ENCUBRIMIENTO"], 
                    ["OTROS DELITOS", "OPERACIONES CON RECURSOS DE PROCEDENCIA ILÍCITA "], 
                    ["OTROS DELITOS", "TORTURA"], 
                    ["OTROS DELITOS", "SUPLANTACIÓN Y USURPACIÓN DE IDENTIDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SEGURIDAD D ELOS DATOS Y/O SISTEMAS O EQUIPOS INFORMÁTICOS"], 
                    ["OTROS DELITOS", "TRATOS O PENAS CRUELES, INHUMANOS O DEGRADANTES"], 
                    ["OTROS DELITOS", "OTROS DELITOS"]
                  ];
                  foreach ($valores as $keyV => $valueV) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS COMETIDOS A LAS VÍCTIMAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }                                         
          break;
          case 'INEGI6':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //022 a - "DELITOS COMETIDOS POR LAS PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[                    
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS CONTRA LA SALUD MODALIDAD NARCOMENUDEO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS FEDERALES CONTRA LA SALUD RELACIONADOS CON NARCÓTICOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "EVASIÓN DE PRESOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS Y OBJETOS PROHIBIDOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELINCUENCIA ORGANIZADA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS, EXPLOSIVOS Y OTROS MATERIALES DESTRUCTIVOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "ASOCIACIÓN DELICTUOSA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "TERRORISMO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "OTROS DELITOS CONTRA LA SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "HECHOS DE CORRUPCIÓN"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS CONTRA LA ADMINISTRACIÓN DE JUSTICIA"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS EN MATERIAL FISCAL"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS ELECTORALES"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "OTROS DELITOS CONTRA LA ADMINISTRACIÓN DEL ESTADO"], 
                    ["OTROS DELITOS", "AMENAZAS"], 
                    ["OTROS DELITOS", "ALLANAMIENTO DE MORADA"], 
                    ["OTROS DELITOS", "FALSEDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA EL MEDIO AMBIENTE"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE VÍAS DE COMUNICACIÓN Y CORRRESPONDENCIA"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE MIGRACIÓN"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE DERECHOS DE AUTOR"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE INSTITUCIONES DE CRÉDITO, INVERSIÓN, FINANZAS Y SEGUROS"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE PROPIEDAD INTELECTUAL"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SALUD NO RELACIONADOS CON NARCÓTICOS"], 
                    ["OTROS DELITOS", "ENCUBRIMIENTO"], 
                    ["OTROS DELITOS", "OPERACIONES CON RECURSOS DE PROCEDENCIA ILÍCITA "], 
                    ["OTROS DELITOS", "TORTURA"], 
                    ["OTROS DELITOS", "SUPLANTACIÓN Y USURPACIÓN DE IDENTIDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SEGURIDAD D ELOS DATOS Y/O SISTEMAS O EQUIPOS INFORMÁTICOS"], 
                    ["OTROS DELITOS", "TRATOS O PENAS CRUELES, INHUMANOS O DEGRADANTES"], 
                    ["OTROS DELITOS", "OTROS DELITOS"]
                  ];
                  foreach ($valores as $keyV => $valueV) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS COMETIDOS POR LAS PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }    
          break;
          case 'INEGI7':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //022 b - "DELITOS COMETIDOS POR LAS PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS CONTRA LA SALUD MODALIDAD NARCOMENUDEO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS FEDERALES CONTRA LA SALUD RELACIONADOS CON NARCÓTICOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "EVASIÓN DE PRESOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS Y OBJETOS PROHIBIDOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELINCUENCIA ORGANIZADA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS, EXPLOSIVOS Y OTROS MATERIALES DESTRUCTIVOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "ASOCIACIÓN DELICTUOSA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "TERRORISMO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "OTROS DELITOS CONTRA LA SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "HECHOS DE CORRUPCIÓN"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS CONTRA LA ADMINISTRACIÓN DE JUSTICIA"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS EN MATERIAL FISCAL"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS ELECTORALES"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "OTROS DELITOS CONTRA LA ADMINISTRACIÓN DEL ESTADO"], 
                    ["OTROS DELITOS", "AMENAZAS"], 
                    ["OTROS DELITOS", "ALLANAMIENTO DE MORADA"], 
                    ["OTROS DELITOS", "FALSEDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA EL MEDIO AMBIENTE"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE VÍAS DE COMUNICACIÓN Y CORRRESPONDENCIA"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE MIGRACIÓN"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE DERECHOS DE AUTOR"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE INSTITUCIONES DE CRÉDITO, INVERSIÓN, FINANZAS Y SEGUROS"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE PROPIEDAD INTELECTUAL"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SALUD NO RELACIONADOS CON NARCÓTICOS"], 
                    ["OTROS DELITOS", "ENCUBRIMIENTO"], 
                    ["OTROS DELITOS", "OPERACIONES CON RECURSOS DE PROCEDENCIA ILÍCITA "], 
                    ["OTROS DELITOS", "TORTURA"], 
                    ["OTROS DELITOS", "SUPLANTACIÓN Y USURPACIÓN DE IDENTIDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SEGURIDAD D ELOS DATOS Y/O SISTEMAS O EQUIPOS INFORMÁTICOS"], 
                    ["OTROS DELITOS", "TRATOS O PENAS CRUELES, INHUMANOS O DEGRADANTES"], 
                    ["OTROS DELITOS", "OTROS DELITOS"]
                  ];
                  foreach ($valores as $keyV => $valueV) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS COMETIDOS POR LAS PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }    
          break;          
          case 'INEGI8':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;               
            //023 - "DELITOS COMETIDOS POR LAS PERSONAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DE PERSONA - FISICA - SEXO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join)
                    {
                      $join->on('b.SEXO_IMPUTADO','=','a.id')
                      ->where('b.TIPO_IMPUTADO','=',1)
                      ->whereNull('b.deleted_at');
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('c.id','=','b.idExpediente')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->leftJoin('bitde_relaciondelito as d', function($join)
                    {
                      $join->on('d.idExpediente','=','c.id')
                      ->whereNull('d.deleted_at');
                    })
                    ->leftJoin('prode_relaciondelito as e', function($join) use($anio,$mes)
                    {
                      $join->on('e.idImputado','=','b.id')->on('e.idRelacion','=','d.id')
                      ->whereNull('e.deleted_at')
                      ->WhereRaw('YEAR(e.created_at)='.$anio)
                      ->WhereRaw('MONTH(e.created_at)='.$mes);                        
                    })
                    ->Where('a.idTipoRespuesta','=',17)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS COMETIDOS POR LAS PERSONAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"TIPO DE PERSONA" as TIPO_DESAGREGACION'),
                      DB::raw('"FISICA" as DESAGREGACION_1'),
                      'a.Valor as DESAGREGACION_2',
                      DB::raw('count(e.idRelacion) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                              
            //024 - "DELITOS COMETIDOS POR LAS PERSONAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DE PERSONA - MORAL - SECTOR
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join)
                    {
                      $join->on('b.SECTOR_IMPUTADOS','=','a.id')
                      ->where('b.TIPO_IMPUTADO','=',2)
                      ->whereNull('b.deleted_at');
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('c.id','=','b.idExpediente')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->leftJoin('bitde_relaciondelito as d', function($join)
                    {
                      $join->on('d.idExpediente','=','c.id')
                      ->whereNull('d.deleted_at');
                    })
                    ->leftJoin('prode_relaciondelito as e', function($join) use($anio,$mes)
                    {
                      $join->on('e.idImputado','=','b.id')->on('e.idRelacion','=','d.id')
                      ->whereNull('e.deleted_at')
                      ->WhereRaw('YEAR(e.created_at)='.$anio)
                      ->WhereRaw('MONTH(e.created_at)='.$mes);                        
                    })
                    ->Where('a.idTipoRespuesta','=',15)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS COMETIDOS POR LAS PERSONAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"TIPO DE PERSONA" as TIPO_DESAGREGACION'),
                      DB::raw('"MORAL" as DESAGREGACION_1'),
                      'a.Valor as DESAGREGACION_2',
                      DB::raw('count(e.idRelacion) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //025 - "DELITOS COMETIDOS POR LAS PERSONAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DE PERSONA - OTRO TIPO DE VÍCTIMA y NO IDENTIFICADA
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {

                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join)
                    {
                      $join->on('b.TIPO_IMPUTADO','=','a.id')
                      ->whereIn('b.TIPO_IMPUTADO',[5,6])
                      ->whereNull('b.deleted_at');
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('c.id','=','b.idExpediente')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->leftJoin('bitde_relaciondelito as d', function($join)
                    {
                      $join->on('d.idExpediente','=','c.id')
                      ->whereNull('d.deleted_at');
                    })
                    ->leftJoin('prode_relaciondelito as e', function($join) use($anio,$mes)
                    {
                      $join->on('e.idImputado','=','b.id')->on('e.idRelacion','=','d.id')
                      ->whereNull('e.deleted_at')
                      ->WhereRaw('YEAR(e.created_at)='.$anio)
                      ->WhereRaw('MONTH(e.created_at)='.$mes);                        
                    })
                    ->Where('a.idTipoRespuesta','=',13)->whereIn('a.id',[5,6])
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS COMETIDOS POR LAS PERSONAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"TIPO DE PERSONA" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(e.idRelacion) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
 
          break;
          case 'INEGI9':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;
            //026 a - "DELITOS COMETIDOS POR LAS PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[                    
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS CONTRA LA SALUD MODALIDAD NARCOMENUDEO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS FEDERALES CONTRA LA SALUD RELACIONADOS CON NARCÓTICOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "EVASIÓN DE PRESOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS Y OBJETOS PROHIBIDOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELINCUENCIA ORGANIZADA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS, EXPLOSIVOS Y OTROS MATERIALES DESTRUCTIVOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "ASOCIACIÓN DELICTUOSA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "TERRORISMO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "OTROS DELITOS CONTRA LA SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "HECHOS DE CORRUPCIÓN"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS CONTRA LA ADMINISTRACIÓN DE JUSTICIA"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS EN MATERIAL FISCAL"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS ELECTORALES"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "OTROS DELITOS CONTRA LA ADMINISTRACIÓN DEL ESTADO"], 
                    ["OTROS DELITOS", "AMENAZAS"], 
                    ["OTROS DELITOS", "ALLANAMIENTO DE MORADA"], 
                    ["OTROS DELITOS", "FALSEDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA EL MEDIO AMBIENTE"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE VÍAS DE COMUNICACIÓN Y CORRRESPONDENCIA"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE MIGRACIÓN"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE DERECHOS DE AUTOR"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE INSTITUCIONES DE CRÉDITO, INVERSIÓN, FINANZAS Y SEGUROS"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE PROPIEDAD INTELECTUAL"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SALUD NO RELACIONADOS CON NARCÓTICOS"], 
                    ["OTROS DELITOS", "ENCUBRIMIENTO"], 
                    ["OTROS DELITOS", "OPERACIONES CON RECURSOS DE PROCEDENCIA ILÍCITA "], 
                    ["OTROS DELITOS", "TORTURA"], 
                    ["OTROS DELITOS", "SUPLANTACIÓN Y USURPACIÓN DE IDENTIDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SEGURIDAD D ELOS DATOS Y/O SISTEMAS O EQUIPOS INFORMÁTICOS"], 
                    ["OTROS DELITOS", "TRATOS O PENAS CRUELES, INHUMANOS O DEGRADANTES"], 
                    ["OTROS DELITOS", "OTROS DELITOS"]
                  ];
                  foreach ($valores as $keyV => $valueV) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS COMETIDOS POR LAS PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }
          break;
          case 'INEGI10':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;
            //026 b - "DELITOS COMETIDOS POR LAS PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[ 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS CONTRA LA SALUD MODALIDAD NARCOMENUDEO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS FEDERALES CONTRA LA SALUD RELACIONADOS CON NARCÓTICOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "EVASIÓN DE PRESOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS Y OBJETOS PROHIBIDOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELINCUENCIA ORGANIZADA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS, EXPLOSIVOS Y OTROS MATERIALES DESTRUCTIVOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "ASOCIACIÓN DELICTUOSA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "TERRORISMO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "OTROS DELITOS CONTRA LA SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "HECHOS DE CORRUPCIÓN"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS CONTRA LA ADMINISTRACIÓN DE JUSTICIA"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS EN MATERIAL FISCAL"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS ELECTORALES"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "OTROS DELITOS CONTRA LA ADMINISTRACIÓN DEL ESTADO"], 
                    ["OTROS DELITOS", "AMENAZAS"], 
                    ["OTROS DELITOS", "ALLANAMIENTO DE MORADA"], 
                    ["OTROS DELITOS", "FALSEDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA EL MEDIO AMBIENTE"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE VÍAS DE COMUNICACIÓN Y CORRRESPONDENCIA"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE MIGRACIÓN"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE DERECHOS DE AUTOR"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE INSTITUCIONES DE CRÉDITO, INVERSIÓN, FINANZAS Y SEGUROS"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE PROPIEDAD INTELECTUAL"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SALUD NO RELACIONADOS CON NARCÓTICOS"], 
                    ["OTROS DELITOS", "ENCUBRIMIENTO"], 
                    ["OTROS DELITOS", "OPERACIONES CON RECURSOS DE PROCEDENCIA ILÍCITA "], 
                    ["OTROS DELITOS", "TORTURA"], 
                    ["OTROS DELITOS", "SUPLANTACIÓN Y USURPACIÓN DE IDENTIDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SEGURIDAD D ELOS DATOS Y/O SISTEMAS O EQUIPOS INFORMÁTICOS"], 
                    ["OTROS DELITOS", "TRATOS O PENAS CRUELES, INHUMANOS O DEGRADANTES"], 
                    ["OTROS DELITOS", "OTROS DELITOS"]
                  ];
                  foreach ($valores as $keyV => $valueV) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS COMETIDOS POR LAS PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }
          break;
          case 'INEGI11':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;              
            //027 C- "DELITOS DE NARCOMENUDEO REGISTRADOS EN LAS AVERIGUACIONES PREVIAS INICIADAS Y EN LAS CARPETAS DE INVESTIGACIÓN ABIERTAS - GRADO DE CONSUMACIÓN ----EN BLANCO (NO EXISTE EL DELITO)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sqlC = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS DE NARCOMENUDEO REGISTRADOS EN LAS AVERIGUACIONES PREVIAS INICIADAS Y EN LAS CARPETAS DE INVESTIGACIÓN ABIERTAS " as INDICADOR'),
                        DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"CONSUMADO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );
                                                  
                    $sql=$sqlC;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }    
            //027 T- "DELITOS DE NARCOMENUDEO REGISTRADOS EN LAS AVERIGUACIONES PREVIAS INICIADAS Y EN LAS CARPETAS DE INVESTIGACIÓN ABIERTAS - GRADO DE CONSUMACIÓN ----EN BLANCO (NO EXISTE EL DELITO)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    
                    $sqlT = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS DE NARCOMENUDEO REGISTRADOS EN LAS AVERIGUACIONES PREVIAS INICIADAS Y EN LAS CARPETAS DE INVESTIGACIÓN ABIERTAS " as INDICADOR'),
                        DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"TENTATIVA" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                                          
                    $sql=$sqlT;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }    
            //027 NI- "DELITOS DE NARCOMENUDEO REGISTRADOS EN LAS AVERIGUACIONES PREVIAS INICIADAS Y EN LAS CARPETAS DE INVESTIGACIÓN ABIERTAS - GRADO DE CONSUMACIÓN ----EN BLANCO (NO EXISTE EL DELITO)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                     
                    $sqlNI = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS DE NARCOMENUDEO REGISTRADOS EN LAS AVERIGUACIONES PREVIAS INICIADAS Y EN LAS CARPETAS DE INVESTIGACIÓN ABIERTAS " as INDICADOR'),
                        DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"NO IDENTIFICADO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                                                      
                    $sql=$sqlNI;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }    
            //028 C- "DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA - GRADO DE CONSUMACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {

                    $sqlC = causas_penales\cp_dg_delitos::leftJoin('prode_hechos as b', function($join)
                    {
                      $join->on('b.id','=','procp_dg_delitos.idDelito')
                      ->whereNull('b.deleted_at');
                    })
                    ->leftJoin('procp_audienciainicial as c', function($join)
                    {
                      $join->on('c.idCausa','=','procp_dg_delitos.idCausa')
                      ->whereNull('c.deleted_at');
                    })
                    ->leftJoin('procp_jo_imputados as d', function($join)
                    {
                      $join->on('d.idCausa','=','procp_dg_delitos.idCausa')
                      ->whereNull('d.deleted_at');
                    })
                    ->leftjoin('prode_datosgenerales as e','e.id','=','b.idExpediente')
                    ->whereNotNull('c.id')->whereNull('d.id')->where('b.CONSUMACION','=',1)
                      ->WhereRaw('YEAR(procp_dg_delitos.created_at)='.$anio)
                      ->WhereRaw('MONTH(procp_dg_delitos.created_at)='.$mes)
                      ->Where('e.DELEGACION','=',$del)
                    ->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                        DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"CONSUMADO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('count(procp_dg_delitos.idDelito) as UNIDAD')
                      );
                                                              
                    $sql=$sqlC;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }

            //028 T- "DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA - GRADO DE CONSUMACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    
                    $sqlT = causas_penales\cp_dg_delitos::leftJoin('prode_hechos as b', function($join)
                    {
                      $join->on('b.id','=','procp_dg_delitos.idDelito')
                      ->whereNull('b.deleted_at');
                    })
                    ->leftJoin('procp_audienciainicial as c', function($join)
                    {
                      $join->on('c.idCausa','=','procp_dg_delitos.idCausa')
                      ->whereNull('c.deleted_at');
                    })
                    ->leftJoin('procp_jo_imputados as d', function($join)
                    {
                      $join->on('d.idCausa','=','procp_dg_delitos.idCausa')
                      ->whereNull('d.deleted_at');
                    })
                    ->leftjoin('prode_datosgenerales as e','e.id','=','b.idExpediente')
                    ->whereNotNull('c.id')->whereNull('d.id')->where('b.CONSUMACION','=',2)
                      ->WhereRaw('YEAR(procp_dg_delitos.created_at)='.$anio)
                      ->WhereRaw('MONTH(procp_dg_delitos.created_at)='.$mes)
                      ->Where('e.DELEGACION','=',$del)
                    ->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                        DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"TENTATIVA" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('count(procp_dg_delitos.idDelito) as UNIDAD')
                      );  
                    
                    $sql=$sqlT;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }

            //028 NI- "DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA - GRADO DE CONSUMACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    
                    $sqlNI = causas_penales\cp_dg_delitos::leftJoin('prode_hechos as b', function($join)
                    {
                      $join->on('b.id','=','procp_dg_delitos.idDelito')
                      ->whereNull('b.deleted_at');
                    })
                    ->leftJoin('procp_audienciainicial as c', function($join)
                    {
                      $join->on('c.idCausa','=','procp_dg_delitos.idCausa')
                      ->whereNull('c.deleted_at');
                    })
                    ->leftJoin('procp_jo_imputados as d', function($join)
                    {
                      $join->on('d.idCausa','=','procp_dg_delitos.idCausa')
                      ->whereNull('d.deleted_at');
                    })
                    ->leftjoin('prode_datosgenerales as e','e.id','=','b.idExpediente')
                    ->whereNotNull('c.id')->whereNull('d.id')->where('b.CONSUMACION','=',3)
                      ->WhereRaw('YEAR(procp_dg_delitos.created_at)='.$anio)
                      ->WhereRaw('MONTH(procp_dg_delitos.created_at)='.$mes)
                      ->Where('e.DELEGACION','=',$del)
                    ->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                        DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"NO IDENTIFICADO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('count(procp_dg_delitos.idDelito) as UNIDAD')
                      );                                                      
                    $sql=$sqlNI;                      
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                            
          break;
          case 'INEGI12':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //029 a - "DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[
                    ["VIDA E INTEGRIDAD CORPORAL", "HOMICIDIO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "FEMINICIDIO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "ABORTO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "LESIONES"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "OTROS DELITOS CONTRA LA VIDA Y LA INTEGRIDAD"], 
                    ["LIBERTAD PERSONAL ", "PRIVACIÓN DE LA LIBERTAD"], 
                    ["LIBERTAD PERSONAL ", "TRÁFICO DE MENORES"], 
                    ["LIBERTAD PERSONAL ", "RETENCIÓN O SUSTRACCIÓN DE MENORES E INCAPACES"], 
                    ["LIBERTAD PERSONAL ", "RAPTO"], 
                    ["LIBERTAD PERSONAL ", "DESAPARICIÓN FORZADA DE PERSONAS"], 
                    ["LIBERTAD PERSONAL ", "SECUESTRO"], 
                    ["LIBERTAD PERSONAL ", "OTROS DELITOS CONTRA LA LIBERTAD PERSONAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ABUSO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ACOSO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "HOSTIGAMIENTO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "VIOLACIÓN"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ESTUPRO"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "INCESTO"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "OTROS DELITOS CONTRA LA LIBERTAD Y SEGURIDAD SEXUAL"], 
                    ["PATRIMONIO", "ROBO"], 
                    ["PATRIMONIO", "HIDROCARBUROS Y DERIVADOS"], 
                    ["PATRIMONIO", "FRAUDE"], 
                    ["PATRIMONIO", "ABUSO DE CONFIANZA"], 
                    ["PATRIMONIO", "EXTORSIÓN"], 
                    ["PATRIMONIO", "DAÑO A LA PROPIEDAD"], 
                    ["PATRIMONIO", "DESPOJO"], 
                    ["PATRIMONIO", "OTROS DELITOS CONTRA EL PATRIMONIO"], 
                    ["FAMILIA", "VIOLENCIA FAMILIAR"], 
                    ["FAMILIA", "INCUMPLIMIENTO DE OBLIGACIONES FAMILIARES"], 
                    ["FAMILIA", "OTROS DELITOS CONTRA LA FAMILIA"], 
                    ["SOCIEDAD", "LIBRE DESARROLLO DE LA PERSONALIDAD"], 
                    ["SOCIEDAD", "TRATA DE PERSONAS"], 
                    ["SOCIEDAD", "VIOLENCIA DE GÉNERO "], 
                    ["SOCIEDAD", "DISCRIMINACIÓN"], 
                    ["SOCIEDAD", "LENOCINIO"], 
                    ["SOCIEDAD", "OTROS DELITOS COTRA LA SOCIEDAD "]
                  ];
                  foreach ($valores as $keyV => $valueV) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }        
          break;
          case 'INEGI13':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //029 b - "DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[                    
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS CONTRA LA SALUD MODALIDAD NARCOMENUDEO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS FEDERALES CONTRA LA SALUD RELACIONADOS CON NARCÓTICOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "EVASIÓN DE PRESOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS Y OBJETOS PROHIBIDOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELINCUENCIA ORGANIZADA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS, EXPLOSIVOS Y OTROS MATERIALES DESTRUCTIVOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "ASOCIACIÓN DELICTUOSA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "TERRORISMO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "OTROS DELITOS CONTRA LA SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "HECHOS DE CORRUPCIÓN"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS CONTRA LA ADMINISTRACIÓN DE JUSTICIA"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS EN MATERIAL FISCAL"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS ELECTORALES"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "OTROS DELITOS CONTRA LA ADMINISTRACIÓN DEL ESTADO"], 
                    ["OTROS DELITOS", "AMENAZAS"], 
                    ["OTROS DELITOS", "ALLANAMIENTO DE MORADA"], 
                    ["OTROS DELITOS", "FALSEDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA EL MEDIO AMBIENTE"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE VÍAS DE COMUNICACIÓN Y CORRRESPONDENCIA"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE MIGRACIÓN"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE DERECHOS DE AUTOR"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE INSTITUCIONES DE CRÉDITO, INVERSIÓN, FINANZAS Y SEGUROS"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE PROPIEDAD INTELECTUAL"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SALUD NO RELACIONADOS CON NARCÓTICOS"], 
                    ["OTROS DELITOS", "ENCUBRIMIENTO"], 
                    ["OTROS DELITOS", "OPERACIONES CON RECURSOS DE PROCEDENCIA ILÍCITA "], 
                    ["OTROS DELITOS", "TORTURA"], 
                    ["OTROS DELITOS", "SUPLANTACIÓN Y USURPACIÓN DE IDENTIDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SEGURIDAD D ELOS DATOS Y/O SISTEMAS O EQUIPOS INFORMÁTICOS"], 
                    ["OTROS DELITOS", "TRATOS O PENAS CRUELES, INHUMANOS O DEGRADANTES"], 
                    ["OTROS DELITOS", "OTROS DELITOS"]
                  ];
                  foreach ($valores as $keyV => $valueV) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }   
          break;             
          case 'INEGI14':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //030 C- "DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL - GRADO DE CONSUMACIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sqlC = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                        DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"CONSUMADO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );
                                                  
                    $sql=$sqlC;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //030 T- "DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL - GRADO DE CONSUMACIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                   
                    $sqlT = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                        DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"TENTATIVA" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                            
                    $sql=$sqlT;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //030 NI- "DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL - GRADO DE CONSUMACIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    
                    $sqlNI = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                        DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"NO IDENTIFICADO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                                                      
                    $sql=$sqlNI;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
          break;
          case 'INEGI15':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //031 a - "DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[
                    ["VIDA E INTEGRIDAD CORPORAL", "HOMICIDIO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "FEMINICIDIO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "ABORTO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "LESIONES"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "OTROS DELITOS CONTRA LA VIDA Y LA INTEGRIDAD"], 
                    ["LIBERTAD PERSONAL ", "PRIVACIÓN DE LA LIBERTAD"], 
                    ["LIBERTAD PERSONAL ", "TRÁFICO DE MENORES"], 
                    ["LIBERTAD PERSONAL ", "RETENCIÓN O SUSTRACCIÓN DE MENORES E INCAPACES"], 
                    ["LIBERTAD PERSONAL ", "RAPTO"], 
                    ["LIBERTAD PERSONAL ", "DESAPARICIÓN FORZADA DE PERSONAS"], 
                    ["LIBERTAD PERSONAL ", "SECUESTRO"], 
                    ["LIBERTAD PERSONAL ", "OTROS DELITOS CONTRA LA LIBERTAD PERSONAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ABUSO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ACOSO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "HOSTIGAMIENTO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "VIOLACIÓN"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ESTUPRO"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "INCESTO"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "OTROS DELITOS CONTRA LA LIBERTAD Y SEGURIDAD SEXUAL"], 
                    ["PATRIMONIO", "ROBO"], 
                    ["PATRIMONIO", "HIDROCARBUROS Y DERIVADOS"], 
                    ["PATRIMONIO", "FRAUDE"], 
                    ["PATRIMONIO", "ABUSO DE CONFIANZA"], 
                    ["PATRIMONIO", "EXTORSIÓN"], 
                    ["PATRIMONIO", "DAÑO A LA PROPIEDAD"], 
                    ["PATRIMONIO", "DESPOJO"], 
                    ["PATRIMONIO", "OTROS DELITOS CONTRA EL PATRIMONIO"], 
                    ["FAMILIA", "VIOLENCIA FAMILIAR"], 
                    ["FAMILIA", "INCUMPLIMIENTO DE OBLIGACIONES FAMILIARES"], 
                    ["FAMILIA", "OTROS DELITOS CONTRA LA FAMILIA"], 
                    ["SOCIEDAD", "LIBRE DESARROLLO DE LA PERSONALIDAD"], 
                    ["SOCIEDAD", "TRATA DE PERSONAS"], 
                    ["SOCIEDAD", "VIOLENCIA DE GÉNERO "], 
                    ["SOCIEDAD", "DISCRIMINACIÓN"], 
                    ["SOCIEDAD", "LENOCINIO"], 
                    ["SOCIEDAD", "OTROS DELITOS COTRA LA SOCIEDAD "], 
                  ];
                  foreach ($valores as $keyV => $valueV) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }            

          break;
          case 'INEGI16':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //031 b - "DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS CONTRA LA SALUD MODALIDAD NARCOMENUDEO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS FEDERALES CONTRA LA SALUD RELACIONADOS CON NARCÓTICOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "EVASIÓN DE PRESOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS Y OBJETOS PROHIBIDOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELINCUENCIA ORGANIZADA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS, EXPLOSIVOS Y OTROS MATERIALES DESTRUCTIVOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "ASOCIACIÓN DELICTUOSA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "TERRORISMO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "OTROS DELITOS CONTRA LA SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "HECHOS DE CORRUPCIÓN"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS CONTRA LA ADMINISTRACIÓN DE JUSTICIA"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS EN MATERIAL FISCAL"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS ELECTORALES"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "OTROS DELITOS CONTRA LA ADMINISTRACIÓN DEL ESTADO"], 
                    ["OTROS DELITOS", "AMENAZAS"], 
                    ["OTROS DELITOS", "ALLANAMIENTO DE MORADA"], 
                    ["OTROS DELITOS", "FALSEDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA EL MEDIO AMBIENTE"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE VÍAS DE COMUNICACIÓN Y CORRRESPONDENCIA"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE MIGRACIÓN"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE DERECHOS DE AUTOR"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE INSTITUCIONES DE CRÉDITO, INVERSIÓN, FINANZAS Y SEGUROS"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE PROPIEDAD INTELECTUAL"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SALUD NO RELACIONADOS CON NARCÓTICOS"], 
                    ["OTROS DELITOS", "ENCUBRIMIENTO"], 
                    ["OTROS DELITOS", "OPERACIONES CON RECURSOS DE PROCEDENCIA ILÍCITA "], 
                    ["OTROS DELITOS", "TORTURA"], 
                    ["OTROS DELITOS", "SUPLANTACIÓN Y USURPACIÓN DE IDENTIDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SEGURIDAD D ELOS DATOS Y/O SISTEMAS O EQUIPOS INFORMÁTICOS"], 
                    ["OTROS DELITOS", "TRATOS O PENAS CRUELES, INHUMANOS O DEGRADANTES"], 
                    ["OTROS DELITOS", "OTROS DELITOS"]
                  ];
                  foreach ($valores as $keyV => $valueV) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }            

          break;          
          case 'INEGI17':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;               
            //032 - "DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - GRADO DE CONSUMACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.CONSUMACION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',5)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                   
            //033 - "DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - CALIFICACIÓN DEL DELITO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.CALIFICACION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',10)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"CALIFICACIÓN DEL DELITO" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //034 - "DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - FORMA DE COMISIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.COMISION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',11)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"FORMA DE COMISIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
          break;
          case 'INEGI18':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;               
            //035 - "DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - FORMA DE ACCIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.FORMA_ACCION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',49)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"FORMA DE ACCIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                 
            //036 - "DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - MODALIDAD
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.MODALIDAD','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',6)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"MODALIDAD" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }   
            //037 - "DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - INSTRUMENTOS COMISIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.INSTRUMENTO','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del);
                    })
                    ->Where('a.idTipoRespuesta','=',7)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      DB::raw('"INSTRUMENTOS COMISIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
          break;
          case 'INEGI19':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;               
            //038 a - "DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[
                    ["VIDA E INTEGRIDAD CORPORAL", "HOMICIDIO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "FEMINICIDIO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "ABORTO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "LESIONES"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "OTROS DELITOS CONTRA LA VIDA Y LA INTEGRIDAD"], 
                    ["LIBERTAD PERSONAL ", "PRIVACIÓN DE LA LIBERTAD"], 
                    ["LIBERTAD PERSONAL ", "TRÁFICO DE MENORES"], 
                    ["LIBERTAD PERSONAL ", "RETENCIÓN O SUSTRACCIÓN DE MENORES E INCAPACES"], 
                    ["LIBERTAD PERSONAL ", "RAPTO"], 
                    ["LIBERTAD PERSONAL ", "DESAPARICIÓN FORZADA DE PERSONAS"], 
                    ["LIBERTAD PERSONAL ", "SECUESTRO"], 
                    ["LIBERTAD PERSONAL ", "OTROS DELITOS CONTRA LA LIBERTAD PERSONAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ABUSO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ACOSO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "HOSTIGAMIENTO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "VIOLACIÓN"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ESTUPRO"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "INCESTO"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "OTROS DELITOS CONTRA LA LIBERTAD Y SEGURIDAD SEXUAL"], 
                    ["PATRIMONIO", "ROBO"], 
                    ["PATRIMONIO", "HIDROCARBUROS Y DERIVADOS"], 
                    ["PATRIMONIO", "FRAUDE"], 
                    ["PATRIMONIO", "ABUSO DE CONFIANZA"], 
                    ["PATRIMONIO", "EXTORSIÓN"], 
                    ["PATRIMONIO", "DAÑO A LA PROPIEDAD"], 
                    ["PATRIMONIO", "DESPOJO"], 
                    ["PATRIMONIO", "OTROS DELITOS CONTRA EL PATRIMONIO"], 
                    ["FAMILIA", "VIOLENCIA FAMILIAR"], 
                    ["FAMILIA", "INCUMPLIMIENTO DE OBLIGACIONES FAMILIARES"], 
                    ["FAMILIA", "OTROS DELITOS CONTRA LA FAMILIA"], 
                    ["SOCIEDAD", "LIBRE DESARROLLO DE LA PERSONALIDAD"], 
                    ["SOCIEDAD", "TRATA DE PERSONAS"], 
                    ["SOCIEDAD", "VIOLENCIA DE GÉNERO "], 
                    ["SOCIEDAD", "DISCRIMINACIÓN"], 
                    ["SOCIEDAD", "LENOCINIO"], 
                    ["SOCIEDAD", "OTROS DELITOS COTRA LA SOCIEDAD "], 
                  ];
                  foreach ($valores as $keyV => $valueV) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }           
          break;
          case 'INEGI20':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;               
            //038 b - "DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS CONTRA LA SALUD MODALIDAD NARCOMENUDEO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS FEDERALES CONTRA LA SALUD RELACIONADOS CON NARCÓTICOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "EVASIÓN DE PRESOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS Y OBJETOS PROHIBIDOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELINCUENCIA ORGANIZADA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS, EXPLOSIVOS Y OTROS MATERIALES DESTRUCTIVOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "ASOCIACIÓN DELICTUOSA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "TERRORISMO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "OTROS DELITOS CONTRA LA SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "HECHOS DE CORRUPCIÓN"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS CONTRA LA ADMINISTRACIÓN DE JUSTICIA"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS EN MATERIAL FISCAL"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS ELECTORALES"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "OTROS DELITOS CONTRA LA ADMINISTRACIÓN DEL ESTADO"], 
                    ["OTROS DELITOS", "AMENAZAS"], 
                    ["OTROS DELITOS", "ALLANAMIENTO DE MORADA"], 
                    ["OTROS DELITOS", "FALSEDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA EL MEDIO AMBIENTE"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE VÍAS DE COMUNICACIÓN Y CORRRESPONDENCIA"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE MIGRACIÓN"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE DERECHOS DE AUTOR"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE INSTITUCIONES DE CRÉDITO, INVERSIÓN, FINANZAS Y SEGUROS"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE PROPIEDAD INTELECTUAL"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SALUD NO RELACIONADOS CON NARCÓTICOS"], 
                    ["OTROS DELITOS", "ENCUBRIMIENTO"], 
                    ["OTROS DELITOS", "OPERACIONES CON RECURSOS DE PROCEDENCIA ILÍCITA "], 
                    ["OTROS DELITOS", "TORTURA"], 
                    ["OTROS DELITOS", "SUPLANTACIÓN Y USURPACIÓN DE IDENTIDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SEGURIDAD D ELOS DATOS Y/O SISTEMAS O EQUIPOS INFORMÁTICOS"], 
                    ["OTROS DELITOS", "TRATOS O PENAS CRUELES, INHUMANOS O DEGRADANTES"], 
                    ["OTROS DELITOS", "OTROS DELITOS"]
                  ];
                  foreach ($valores as $keyV => $valueV) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS REGISTRADOS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }           
          break;
          case 'INEGI21':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;            
            //039 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - GRADO DE CONSUMACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.CONSUMACION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('IFNULL(c.SENTIDO_DETERMINACION,-1)>=0');
                    })
                    ->Where('a.idTipoRespuesta','=',5)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                      DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }   
            //040 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - CALIFICACIÓN DEL DELITO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.CALIFICACION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('IFNULL(c.SENTIDO_DETERMINACION,-1)>=0');
                    })
                    ->Where('a.idTipoRespuesta','=',10)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                      DB::raw('"CALIFICACIÓN DEL DELITO" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //041 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - FORMA DE COMISIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.COMISION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('IFNULL(c.SENTIDO_DETERMINACION,-1)>=0');
                    })
                    ->Where('a.idTipoRespuesta','=',11)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                      DB::raw('"FORMA DE COMISIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //042 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - FORMA DE ACCIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.FORMA_ACCION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('IFNULL(c.SENTIDO_DETERMINACION,-1)>=0');
                    })
                    ->Where('a.idTipoRespuesta','=',49)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                      DB::raw('"FORMA DE ACCIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                 
          break;
          case 'INEGI22':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;                             
            //043 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - MODALIDAD
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.MODALIDAD','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('IFNULL(c.SENTIDO_DETERMINACION,-1)>=0');
                    })
                    ->Where('a.idTipoRespuesta','=',6)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                      DB::raw('"MODALIDAD" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }   
            //044 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - INSTRUMENTOS COMISIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.INSTRUMENTO','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('IFNULL(c.SENTIDO_DETERMINACION,-1)>=0');
                    })
                    ->Where('a.idTipoRespuesta','=',7)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                      DB::raw('"INSTRUMENTOS COMISIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //046 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - TIPO DETERMINACIÓN 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_datosgenerales as b', function($join) use($del)
                    {
                      $join->on('b.SENTIDO_DETERMINACION','=','a.id')
                      ->Where('b.DELEGACION','=',$del);
                    })
                    ->leftJoin('prode_hechos as c', function($join) use ($anio,$mes)
                    {
                      $join->on('c.idExpediente','=','b.id')
                      ->whereNull('c.deleted_at')
                      ->WhereRaw('YEAR(c.created_at)='.$anio)
                      ->WhereRaw('MONTH(c.created_at)='.$mes);
                    })
                    ->Where('a.idTipoRespuesta','=',58)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                      DB::raw('"TIPO DETERMINACIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }    
            //047 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - TIPO DETERMINACIÓN ----PENDIENTE (FALTARON ELEMENTOS DEL CATÁLOGO QUE NO EXISTE)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $motivos=["SUSPENSIÓN DEL PROCESO", 
                            "SOBRESEIMIENTO", 
                            "SOLUCIONES ALTERNAS", 
                            "PROCEDIMIENTO ABREVIADO", 
                            "FORMULACIÓN DE LA ACUSACIÓN", 
                            "ACUMULACIÓN", 
                            "OTRAS DETERMINACIONES Y/O CONCLUSIONES"];
                  foreach ($motivos as $keyM => $valueM) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                        DB::raw('"TIPO DETERMINACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueM.'" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                  }
                }
              }                                         
          break;
          case 'INEGI23':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;      
            //045 a - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[
                    ["VIDA E INTEGRIDAD CORPORAL", "HOMICIDIO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "FEMINICIDIO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "ABORTO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "LESIONES"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "OTROS DELITOS CONTRA LA VIDA Y LA INTEGRIDAD"], 
                    ["LIBERTAD PERSONAL ", "PRIVACIÓN DE LA LIBERTAD"], 
                    ["LIBERTAD PERSONAL ", "TRÁFICO DE MENORES"], 
                    ["LIBERTAD PERSONAL ", "RETENCIÓN O SUSTRACCIÓN DE MENORES E INCAPACES"], 
                    ["LIBERTAD PERSONAL ", "RAPTO"], 
                    ["LIBERTAD PERSONAL ", "DESAPARICIÓN FORZADA DE PERSONAS"], 
                    ["LIBERTAD PERSONAL ", "SECUESTRO"], 
                    ["LIBERTAD PERSONAL ", "OTROS DELITOS CONTRA LA LIBERTAD PERSONAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ABUSO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ACOSO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "HOSTIGAMIENTO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "VIOLACIÓN"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ESTUPRO"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "INCESTO"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "OTROS DELITOS CONTRA LA LIBERTAD Y SEGURIDAD SEXUAL"], 
                    ["PATRIMONIO", "ROBO"], 
                    ["PATRIMONIO", "HIDROCARBUROS Y DERIVADOS"], 
                    ["PATRIMONIO", "FRAUDE"], 
                    ["PATRIMONIO", "ABUSO DE CONFIANZA"], 
                    ["PATRIMONIO", "EXTORSIÓN"], 
                    ["PATRIMONIO", "DAÑO A LA PROPIEDAD"], 
                    ["PATRIMONIO", "DESPOJO"], 
                    ["PATRIMONIO", "OTROS DELITOS CONTRA EL PATRIMONIO"], 
                    ["FAMILIA", "VIOLENCIA FAMILIAR"], 
                    ["FAMILIA", "INCUMPLIMIENTO DE OBLIGACIONES FAMILIARES"], 
                    ["FAMILIA", "OTROS DELITOS CONTRA LA FAMILIA"], 
                    ["SOCIEDAD", "LIBRE DESARROLLO DE LA PERSONALIDAD"], 
                    ["SOCIEDAD", "TRATA DE PERSONAS"], 
                    ["SOCIEDAD", "VIOLENCIA DE GÉNERO "], 
                    ["SOCIEDAD", "DISCRIMINACIÓN"], 
                    ["SOCIEDAD", "LENOCINIO"], 
                    ["SOCIEDAD", "OTROS DELITOS COTRA LA SOCIEDAD "], 
                  ];
                  foreach ($valores as $keyV => $valueV) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }

          break;
          case 'INEGI24':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;      
            //045 b - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS CONTRA LA SALUD MODALIDAD NARCOMENUDEO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS FEDERALES CONTRA LA SALUD RELACIONADOS CON NARCÓTICOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "EVASIÓN DE PRESOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS Y OBJETOS PROHIBIDOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELINCUENCIA ORGANIZADA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS, EXPLOSIVOS Y OTROS MATERIALES DESTRUCTIVOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "ASOCIACIÓN DELICTUOSA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "TERRORISMO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "OTROS DELITOS CONTRA LA SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "HECHOS DE CORRUPCIÓN"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS CONTRA LA ADMINISTRACIÓN DE JUSTICIA"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS EN MATERIAL FISCAL"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS ELECTORALES"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "OTROS DELITOS CONTRA LA ADMINISTRACIÓN DEL ESTADO"], 
                    ["OTROS DELITOS", "AMENAZAS"], 
                    ["OTROS DELITOS", "ALLANAMIENTO DE MORADA"], 
                    ["OTROS DELITOS", "FALSEDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA EL MEDIO AMBIENTE"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE VÍAS DE COMUNICACIÓN Y CORRRESPONDENCIA"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE MIGRACIÓN"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE DERECHOS DE AUTOR"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE INSTITUCIONES DE CRÉDITO, INVERSIÓN, FINANZAS Y SEGUROS"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE PROPIEDAD INTELECTUAL"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SALUD NO RELACIONADOS CON NARCÓTICOS"], 
                    ["OTROS DELITOS", "ENCUBRIMIENTO"], 
                    ["OTROS DELITOS", "OPERACIONES CON RECURSOS DE PROCEDENCIA ILÍCITA "], 
                    ["OTROS DELITOS", "TORTURA"], 
                    ["OTROS DELITOS", "SUPLANTACIÓN Y USURPACIÓN DE IDENTIDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SEGURIDAD D ELOS DATOS Y/O SISTEMAS O EQUIPOS INFORMÁTICOS"], 
                    ["OTROS DELITOS", "TRATOS O PENAS CRUELES, INHUMANOS O DEGRADANTES"], 
                    ["OTROS DELITOS", "OTROS DELITOS"]
                  ];
                  foreach ($valores as $keyV => $valueV) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }

          break;
          case 'INEGI25':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;  
            //048 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - GRADO DE CONSUMACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.CONSUMACION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('IFNULL(c.SENTIDO_DETERMINACION,-1)>=0');
                    })
                    ->Where('a.idTipoRespuesta','=',5)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }   
            //049 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - CALIFICACIÓN DEL DELITO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.CALIFICACION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('IFNULL(c.SENTIDO_DETERMINACION,-1)>=0');
                    })
                    ->Where('a.idTipoRespuesta','=',10)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"CALIFICACIÓN DEL DELITO" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //050 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - FORMA DE COMISIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.COMISION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('IFNULL(c.SENTIDO_DETERMINACION,-1)>=0');
                    })
                    ->Where('a.idTipoRespuesta','=',11)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"FORMA DE COMISIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //051 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - FORMA DE ACCIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.FORMA_ACCION','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('IFNULL(c.SENTIDO_DETERMINACION,-1)>=0');
                    })
                    ->Where('a.idTipoRespuesta','=',49)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"FORMA DE ACCIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                 
            //052 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - MODALIDAD
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.MODALIDAD','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('IFNULL(c.SENTIDO_DETERMINACION,-1)>=0');
                    })
                    ->Where('a.idTipoRespuesta','=',6)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"MODALIDAD" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }   
            //053 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - INSTRUMENTOS COMISIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_hechos as b', function($join) use ($anio,$mes)
                    {
                      $join->on('b.INSTRUMENTO','=','a.id')
                      ->whereNull('b.deleted_at')
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->leftJoin('prode_datosgenerales as c', function($join) use($del)
                    {
                      $join->on('b.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('IFNULL(c.SENTIDO_DETERMINACION,-1)>=0');
                    })
                    ->Where('a.idTipoRespuesta','=',7)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"INSTRUMENTOS COMISIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //055 - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - TIPO DETERMINACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_datosgenerales as b', function($join) use($del)
                    {
                      $join->on('b.SENTIDO_DETERMINACION','=','a.id')
                      ->Where('b.DELEGACION','=',$del);
                    })
                    ->leftJoin('prode_hechos as c', function($join) use ($anio,$mes)
                    {
                      $join->on('c.idExpediente','=','b.id')
                      ->whereNull('c.deleted_at')
                      ->WhereRaw('YEAR(c.created_at)='.$anio)
                      ->WhereRaw('MONTH(c.created_at)='.$mes);
                    })
                    ->Where('a.idTipoRespuesta','=',58)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"TIPO DETERMINACIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(c.idExpediente) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
          
          break;
          case 'INEGI26':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //054 a - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[
                    ["VIDA E INTEGRIDAD CORPORAL", "HOMICIDIO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "FEMINICIDIO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "ABORTO"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "LESIONES"], 
                    ["VIDA E INTEGRIDAD CORPORAL", "OTROS DELITOS CONTRA LA VIDA Y LA INTEGRIDAD"], 
                    ["LIBERTAD PERSONAL ", "PRIVACIÓN DE LA LIBERTAD"], 
                    ["LIBERTAD PERSONAL ", "TRÁFICO DE MENORES"], 
                    ["LIBERTAD PERSONAL ", "RETENCIÓN O SUSTRACCIÓN DE MENORES E INCAPACES"], 
                    ["LIBERTAD PERSONAL ", "RAPTO"], 
                    ["LIBERTAD PERSONAL ", "DESAPARICIÓN FORZADA DE PERSONAS"], 
                    ["LIBERTAD PERSONAL ", "SECUESTRO"], 
                    ["LIBERTAD PERSONAL ", "OTROS DELITOS CONTRA LA LIBERTAD PERSONAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ABUSO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ACOSO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "HOSTIGAMIENTO SEXUAL"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "VIOLACIÓN"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "ESTUPRO"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "INCESTO"], 
                    ["LIBERTAD Y SEGURIDAD SEXUAL", "OTROS DELITOS CONTRA LA LIBERTAD Y SEGURIDAD SEXUAL"], 
                    ["PATRIMONIO", "ROBO"], 
                    ["PATRIMONIO", "HIDROCARBUROS Y DERIVADOS"], 
                    ["PATRIMONIO", "FRAUDE"], 
                    ["PATRIMONIO", "ABUSO DE CONFIANZA"], 
                    ["PATRIMONIO", "EXTORSIÓN"], 
                    ["PATRIMONIO", "DAÑO A LA PROPIEDAD"], 
                    ["PATRIMONIO", "DESPOJO"], 
                    ["PATRIMONIO", "OTROS DELITOS CONTRA EL PATRIMONIO"], 
                    ["FAMILIA", "VIOLENCIA FAMILIAR"], 
                    ["FAMILIA", "INCUMPLIMIENTO DE OBLIGACIONES FAMILIARES"], 
                    ["FAMILIA", "OTROS DELITOS CONTRA LA FAMILIA"], 
                    ["SOCIEDAD", "LIBRE DESARROLLO DE LA PERSONALIDAD"], 
                    ["SOCIEDAD", "TRATA DE PERSONAS"], 
                    ["SOCIEDAD", "VIOLENCIA DE GÉNERO "], 
                    ["SOCIEDAD", "DISCRIMINACIÓN"], 
                    ["SOCIEDAD", "LENOCINIO"], 
                    ["SOCIEDAD", "OTROS DELITOS COTRA LA SOCIEDAD "]
                  ];
                  foreach ($valores as $keyV => $valueV) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }
          break;
          case 'INEGI27':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //054 b - "DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - TIPO DELITO ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $valores=[
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS CONTRA LA SALUD MODALIDAD NARCOMENUDEO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS FEDERALES CONTRA LA SALUD RELACIONADOS CON NARCÓTICOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "EVASIÓN DE PRESOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS Y OBJETOS PROHIBIDOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELINCUENCIA ORGANIZADA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "DELITOS EN MATERIA DE ARMAS, EXPLOSIVOS Y OTROS MATERIALES DESTRUCTIVOS"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "ASOCIACIÓN DELICTUOSA"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "TERRORISMO"], 
                    ["SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO", "OTROS DELITOS CONTRA LA SEGURIDAD PÚBLICA Y SEGURIDAD DEL ESTADO"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "HECHOS DE CORRUPCIÓN"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS CONTRA LA ADMINISTRACIÓN DE JUSTICIA"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS EN MATERIAL FISCAL"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "DELITOS ELECTORALES"], 
                    ["ADMINISTRACIÓN DEL ESTADO", "OTROS DELITOS CONTRA LA ADMINISTRACIÓN DEL ESTADO"], 
                    ["OTROS DELITOS", "AMENAZAS"], 
                    ["OTROS DELITOS", "ALLANAMIENTO DE MORADA"], 
                    ["OTROS DELITOS", "FALSEDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA EL MEDIO AMBIENTE"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE VÍAS DE COMUNICACIÓN Y CORRRESPONDENCIA"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE MIGRACIÓN"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE DERECHOS DE AUTOR"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE INSTITUCIONES DE CRÉDITO, INVERSIÓN, FINANZAS Y SEGUROS"], 
                    ["OTROS DELITOS", "DELITOS EN MATERIA DE PROPIEDAD INTELECTUAL"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SALUD NO RELACIONADOS CON NARCÓTICOS"], 
                    ["OTROS DELITOS", "ENCUBRIMIENTO"], 
                    ["OTROS DELITOS", "OPERACIONES CON RECURSOS DE PROCEDENCIA ILÍCITA "], 
                    ["OTROS DELITOS", "TORTURA"], 
                    ["OTROS DELITOS", "SUPLANTACIÓN Y USURPACIÓN DE IDENTIDAD"], 
                    ["OTROS DELITOS", "DELITOS CONTRA LA SEGURIDAD D ELOS DATOS Y/O SISTEMAS O EQUIPOS INFORMÁTICOS"], 
                    ["OTROS DELITOS", "TRATOS O PENAS CRUELES, INHUMANOS O DEGRADANTES"], 
                    ["OTROS DELITOS", "OTROS DELITOS"]
                  ];
                  foreach ($valores as $keyV => $valueV) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DELITOS REGISTRADOS EN LAS DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                        DB::raw('"TIPO DELITO " as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueV[0].'" as DESAGREGACION_1'),
                        DB::raw('"'.$valueV[1].'" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }
          break;          
          case 'INEGI28':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;  
            //056 FO- "DENUNCIAS - MEDIO RECEPCIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sqlFO = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DENUNCIAS" as INDICADOR'),
                        DB::raw('"MEDIO RECEPCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"FORMA ORAL" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );
                    
                    $sql=$sqlFO;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //056 PE- "DENUNCIAS - MEDIO RECEPCIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    
                    $sqlPE = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DENUNCIAS" as INDICADOR'),
                        DB::raw('"MEDIO RECEPCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"POR ESCRITO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );  
                    
                    $sql=$sqlPE;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //056 EL- "DENUNCIAS - MEDIO RECEPCIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    
                    $sqlEL = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DENUNCIAS" as INDICADOR'),
                        DB::raw('"MEDIO RECEPCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"EN LÍNEA" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );   
                    $sql=$sqlEL;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }   
            //056 OM- "DENUNCIAS - MEDIO RECEPCIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sqlOM = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DENUNCIAS" as INDICADOR'),
                        DB::raw('"MEDIO RECEPCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"OTRO MEDIO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );    
                    $sql=$sqlOM;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                            
            //057 - "DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - TIPO DETERMINACIÓN ----PENDIENTE (NO EXISTE)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $motivos=["DESISTIMIENTO DE LA ACCIÓN PENAL", 
                            "INCOMPETENCIAS", 
                            "CRITERIOS DE OPORTUNIDAD", 
                            "SUSPENSIÓN DEL PROCESO", 
                            "SOBRESEIMIENTO", 
                            "SOLUCIONES ALTERNAS", 
                            "PROCEDIMIENTO ABREVIADO", 
                            "FORMULACIÓN DE LA ACUSACIÓN", 
                            "ACUMULACIÓN", 
                            "OTRAS DETERMINACIONES Y/O CONCLUSIONES"];
                  foreach ($motivos as $keyM => $valueM) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                        DB::raw('"TIPO DETERMINACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueM.'" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                  }
                }
              }  
            //058 - "DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - TIPO DETERMINACIÓN ----PENDIENTE ??
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_datosgenerales as b', function($join) use($del,$anio,$mes)
                    {
                      $join->on('b.SENTIDO_DETERMINACION','=','a.id')
                      ->Where('b.DELEGACION','=',$del)
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->Where('a.idTipoRespuesta','=',58)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"DETERMINACIONES Y/O CONCLUSIONES EFECTUADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"TIPO DETERMINACIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(b.id) as UNIDAD')
                    )
                    ->groupby('a.id');    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }   
          break;
          case 'INEGI29':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //059 - "MEDIDAS CAUTELARES SOLICITADAS QUE FUERON DECRETADAS IMPUESTAS A PERSONAS FÍSICAS - TIPO DE MEDIDA CAUTELAR -  - MENOS DE 3 MESES
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_mc_medidas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_MEDIDAS_CAUTELARES','=','a.id')
                      ->whereraw('(b.TEMPORALIDAD_MEDIDA_D+(b.TEMPORALIDAD_MEDIDA_M*31)+(b.TEMPORALIDAD_MEDIDA_A*365))<93')
                      ->wherenull('b.deleted_at')
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('procp_medidascautelares  as c', function($join)
                    {
                      $join->on('c.id','=','b.id_cp_medidascautelares')
                      ->wherenull('c.deleted_at');
                    }) 
                    ->leftjoin('procp_dg_imputados as d', function($join)
                    {
                      $join->on('d.id','=','c.idImputado')
                      ->wherenull('d.deleted_at');
                    })
                    ->leftjoin('prode_imputados as e', function($join)
                    {
                      $join->on('e.id','=','d.idImputado')
                      ->where('e.TIPO_IMPUTADO','=',1)
                      ->wherenull('e.deleted_at');
                    })
                    ->leftjoin('prode_datosgenerales as f', function($join) use($del)
                    {
                      $join->on('f.id','=','e.idExpediente')
                      ->where('f.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',34)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"MEDIDAS CAUTELARES SOLICITADAS QUE FUERON DECRETADAS IMPUESTAS A PERSONAS FÍSICAS" as INDICADOR'),
                      db::raw('"TIPO DE MEDIDA CAUTELAR" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"MENOS DE 3 MESES" as DESAGREGACION_2'),
                      db::raw('COUNT(f.id) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                                               
            //060 - "MEDIDAS CAUTELARES SOLICITADAS QUE FUERON DECRETADAS IMPUESTAS A PERSONAS FÍSICAS - TIPO DE MEDIDA CAUTELAR -  - MÁS DE 3 MESES
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = db::table('catrespuestas as a')
                    ->leftjoin('procp_mc_medidas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_MEDIDAS_CAUTELARES','=','a.id')
                      ->whereraw('(b.TEMPORALIDAD_MEDIDA_D+(b.TEMPORALIDAD_MEDIDA_M*31)+(b.TEMPORALIDAD_MEDIDA_A*365))>92')
                      ->wherenull('b.deleted_at')
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('procp_medidascautelares  as c', function($join)
                    {
                      $join->on('c.id','=','b.id_cp_medidascautelares')
                      ->wherenull('c.deleted_at');
                    }) 
                    ->leftjoin('procp_dg_imputados as d', function($join)
                    {
                      $join->on('d.id','=','c.idImputado')
                      ->wherenull('d.deleted_at');
                    })
                    ->leftjoin('prode_imputados as e', function($join)
                    {
                      $join->on('e.id','=','d.idImputado')
                      ->where('e.tipo_imputado','=',1)
                      ->wherenull('e.deleted_at');
                    })
                    ->leftjoin('prode_datosgenerales as f', function($join) use($del)
                    {
                      $join->on('f.id','=','e.idExpediente')
                      ->where('f.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',34)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"MEDIDAS CAUTELARES SOLICITADAS QUE FUERON DECRETADAS IMPUESTAS A PERSONAS FÍSICAS" AS INDICADOR'),
                      db::raw('"TIPO DE MEDIDA CAUTELAR" AS TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"MÁS DE 3 MESES" as DESAGREGACION_2'),
                      db::raw('count(f.id) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //061 - "MEDIDAS CAUTELARES SOLICITADAS QUE FUERON DECRETADAS IMPUESTAS A PERSONAS MORALES - TIPO DE MEDIDA CAUTELAR -  - MENOS DE 3 MESES
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = db::table('catrespuestas as a')
                    ->leftjoin('procp_mc_medidas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_MEDIDAS_CAUTELARES','=','a.id')
                      ->whereraw('(b.TEMPORALIDAD_MEDIDA_D+(b.TEMPORALIDAD_MEDIDA_M*31)+(b.TEMPORALIDAD_MEDIDA_A*365))<93')
                      ->wherenull('b.deleted_at')
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('procp_medidascautelares  as c', function($join)
                    {
                      $join->on('c.id','=','b.id_cp_medidascautelares')
                      ->wherenull('c.deleted_at');
                    }) 
                    ->leftjoin('procp_dg_imputados as d', function($join)
                    {
                      $join->on('d.id','=','c.idImputado')
                      ->wherenull('d.deleted_at');
                    })
                    ->leftjoin('prode_imputados as e', function($join)
                    {
                      $join->on('e.id','=','d.idImputado')
                      ->where('e.tipo_imputado','=',2)
                      ->wherenull('e.deleted_at');
                    })
                    ->leftjoin('prode_datosgenerales as f', function($join) use($del)
                    {
                      $join->on('f.id','=','e.idExpediente')
                      ->where('f.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',34)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"MEDIDAS CAUTELARES SOLICITADAS QUE FUERON DECRETADAS IMPUESTAS A PERSONAS MORALES" AS INDICADOR'),
                      db::raw('"TIPO DE MEDIDA CAUTELAR" AS TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"MENOS DE 3 MESES" as DESAGREGACION_2'),
                      db::raw('count(f.id) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                                               
            //062 - "MEDIDAS CAUTELARES SOLICITADAS QUE FUERON DECRETADAS IMPUESTAS A PERSONAS MORALES - TIPO DE MEDIDA CAUTELAR -  - MÁS DE 3 MESES
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = db::table('catrespuestas as a')
                    ->leftjoin('procp_mc_medidas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_MEDIDAS_CAUTELARES','=','a.id')
                      ->whereraw('(b.TEMPORALIDAD_MEDIDA_D+(b.TEMPORALIDAD_MEDIDA_M*31)+(b.TEMPORALIDAD_MEDIDA_A*365))>92')
                      ->wherenull('b.deleted_at')
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('procp_medidascautelares  as c', function($join)
                    {
                      $join->on('c.id','=','b.id_cp_medidascautelares')
                      ->wherenull('c.deleted_at');
                    }) 
                    ->leftjoin('procp_dg_imputados as d', function($join)
                    {
                      $join->on('d.id','=','c.idImputado')
                      ->wherenull('d.deleted_at');
                    })
                    ->leftjoin('prode_imputados as e', function($join)
                    {
                      $join->on('e.id','=','d.idImputado')
                      ->where('e.tipo_imputado','=',2)
                      ->wherenull('e.deleted_at');
                    })
                    ->leftjoin('prode_datosgenerales as f', function($join) use($del)
                    {
                      $join->on('f.id','=','e.idExpediente')
                      ->where('f.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',34)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"MEDIDAS CAUTELARES SOLICITADAS QUE FUERON DECRETADAS IMPUESTAS A PERSONAS MORALES" as INDICADOR'),
                      db::raw('"TIPO DE MEDIDA CAUTELAR" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"MÁS DE 3 MESES" as DESAGREGACION_2'),
                      db::raw('count(f.id) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //063 - "MEDIDAS CAUTELARES SOLICITADAS QUE FUERON DECRETADAS IMPUESTAS A PERSONAS NO IDENTIFICADAS - TIPO DE MEDIDA CAUTELAR -  - MENOS DE 3 MESES
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = db::table('catrespuestas as a')
                    ->leftjoin('procp_mc_medidas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_MEDIDAS_CAUTELARES','=','a.id')
                      ->whereraw('(b.TEMPORALIDAD_MEDIDA_D+(b.TEMPORALIDAD_MEDIDA_M*31)+(b.TEMPORALIDAD_MEDIDA_A*365))<93')
                      ->wherenull('b.deleted_at')
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('procp_medidascautelares as c', function($join)
                    {
                      $join->on('c.id','=','b.id_cp_medidascautelares')
                      ->wherenull('c.deleted_at');
                    }) 
                    ->leftjoin('procp_dg_imputados as d', function($join)
                    {
                      $join->on('d.id','=','c.idImputado')
                      ->wherenull('d.deleted_at');
                    })
                    ->leftjoin('prode_imputados as e', function($join)
                    {
                      $join->on('e.id','=','d.idImputado')
                      ->where('e.tipo_imputado','=',5)
                      ->wherenull('e.deleted_at');
                    })
                    ->leftjoin('prode_datosgenerales as f', function($join) use($del)
                    {
                      $join->on('f.id','=','e.idExpediente')
                      ->where('f.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',34)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"MEDIDAS CAUTELARES SOLICITADAS QUE FUERON DECRETADAS IMPUESTAS A PERSONAS NO IDENTIFICADAS" AS INDICADOR'),
                      db::raw('"TIPO DE MEDIDA CAUTELAR" AS TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"MENOS DE 3 MESES" AS DESAGREGACION_2'),
                      db::raw('count(f.id) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                                               
            //064 - "MEDIDAS CAUTELARES SOLICITADAS QUE FUERON DECRETADAS IMPUESTAS A PERSONAS NO IDENTIFICADAS - TIPO DE MEDIDA CAUTELAR -  - MÁS DE 3 MESES
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = db::table('catrespuestas as a')
                    ->leftjoin('procp_mc_medidas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_MEDIDAS_CAUTELARES','=','a.id')
                      ->whereraw('(b.TEMPORALIDAD_MEDIDA_D+(b.TEMPORALIDAD_MEDIDA_M*31)+(b.TEMPORALIDAD_MEDIDA_A*365))>92')
                      ->wherenull('b.deleted_at')
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('procp_medidascautelares  as c', function($join)
                    {
                      $join->on('c.id','=','b.id_cp_medidascautelares')
                      ->wherenull('c.deleted_at');
                    }) 
                    ->leftjoin('procp_dg_imputados as d', function($join)
                    {
                      $join->on('d.id','=','c.idImputado')
                      ->wherenull('d.deleted_at');
                    })
                    ->leftjoin('prode_imputados as e', function($join)
                    {
                      $join->on('e.id','=','d.idImputado')
                      ->where('e.tipo_imputado','=',5)
                      ->wherenull('e.deleted_at');
                    })
                    ->leftjoin('prode_datosgenerales as f', function($join) use($del)
                    {
                      $join->on('f.id','=','e.idExpediente')
                      ->where('f.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',34)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"MEDIDAS CAUTELARES SOLICITADAS QUE FUERON DECRETADAS IMPUESTAS A PERSONAS NO IDENTIFICADAS" AS INDICADOR'),
                      db::raw('"TIPO DE MEDIDA CAUTELAR" AS TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"MÁS DE 3 MESES" AS DESAGREGACION_2'),
                      db::raw('count(f.id) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
          break;
          case 'INEGI30':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;  
            //065 - "MEDIDAS DE PROTECCIÓN NO OTORGADAS  ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"MEDIDAS DE PROTECCIÓN NO OTORGADAS" as INDICADOR'),
                        DB::raw('"" as TIPO_DESAGREGACION'),
                        DB::raw('"" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;           
                }
              }
            //066 - "MEDIDAS DE PROTECCIÓN OTORGADAS A PERSONAS FÍSICAS - TIPO DE MEDIDA DE PROTECCIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_ev_medidas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_DE_MEDIDA','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('procp_dg_victimas as c', function($join)
                    {
                      $join->on('c.id','=','b.idVictima')
                      ->wherenull('c.deleted_at');
                    })
                    ->leftjoin('prode_victimas as d', function($join)
                    {
                      $join->on('d.id','=','c.idVictima')
                      ->where('d.TIPO_VICTIMA','=',1)
                      ->wherenull('d.deleted_at');
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','d.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',28)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"MEDIDAS DE PROTECCIÓN OTORGADAS A PERSONAS FÍSICAS" as INDICADOR'),
                      db::raw('"TIPO DE MEDIDA DE PROTECCIÓN" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //067 - "MEDIDAS DE PROTECCIÓN OTORGADAS A PERSONAS FÍSICAS - TIPO DE MEDIDA DE PROTECCIÓN ----EN BLANCO (NO EXISTEN)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $medidas=["SEPARACIÓN INMEDIATA DEL DOMICILIO", 
                    
                    "REINGRESO DE LA VÍCTIMA O PERSONA OFENDIDA A SU DOMICILIO,UNA VEZ QUE SE SALVAGUARDE SU SEGURIDAD ",

                    "PROHIBICIÓN INMEDIATA A LA PERSONA AGRESORA DE ACERCARSE AL DOMICILIO Y AL DE FAMILIARES Y AMISTADES,AL LUGAR DE TRABAJO, DE ESTUDIOS, O CUALQUIER OTRO QUE FRECUENTE LA VÍCTIMA DIRECTA O VÍCTIMAS INDIRECTAS ", 

                    "SOLICITUD A LA AUTORIDAD JUDICIAL COMPETENTE, LA SUSPENSIÓN TEMPORAL A LA PERSONA AGRESORA DEL RÉGIMEN DE VISITAS Y CONVIVENCIA CON SUS DESCENDIENTES", 

                    "PROHIBICIÓN A LA PERSONA AGRESORA DE INTIMIDAR O MOLESTAR POR SÍ, POR CUALQUIER MEDIO O INTERPÓSITA PERSONA, A LA MUJER EN SITUACIÓN DE VIOLENCIA Y, EN SU CASO, A SUS HIJAS E HIJOS U OTRAS VÍCTIMAS INDIRECTAS, TESTIGOS DE LOS HECHOS O CUALQUIER OTRA PERSONA CON QUIEN LA MUJER TENGA UNA RELACIÓN FAMILIAR, AFECTIVA, DE CONFIANZA O DE HECHO", 

                    "RESGUARDAR LAS ARMAS DE FUEGO U OBJETOS UTILIZADOS PARA AMENAZAR O AGREDIR A LA MUJER, O NIÑA, EN SITUACIÓN DE VIOLENCIA", 

                    "SOLICITAR A LA AUTORIDAD JURISDICCIONAL COMPETENTE, PARA GARANTIZAR LAS OBLIGACIONES ALIMENTARIAS, LA ELABORACIÓN DE UN INVENTARIO DE LOS BIENES DE LA PERSONA AGRESORA Y SU EMBARGO PRECAUTORIO, EL CUAL DEBERÁ INSCRIBIRSE CON CARÁCTER TEMPORAL EN EL REGISTRO PÚBLICO DE LA PROPIEDAD", 

                    "REINGRESO DE LA MUJER Y EN SU CASO A SUS HIJAS E HIJOS EN SITUACIÓN DE VIOLENCIA AL DOMICILIO, O BIEN, PARA ACCEDER AL DOMICILIO, LUGAR DE TRABAJO U OTRO, CON EL PROPÓSITO DE RECUPERAR SUS PERTENENCIAS PERSONALES Y LAS DE SUS HIJAS E HIJOS, UNA VEZ QUE SE SALVAGUARDE SU SEGURIDAD, ACOMPAÑADA DEL MINISTERIO PÚBLICO, O PERSONAL DE LA POLICÍA MINISTERIAL, O PERSONAL DE LA INSTITUCIÓN DE SEGURIDAD PÚBLICA O DE UNA PERSONA DE SU CONFIANZA", 

                    "ORDENAR LA ENTREGA INMEDIATA DE OBJETOS DE USO PERSONAL Y DOCUMENTOS DE IDENTIDAD A LA MUJER EN SITUACIÓN DE VIOLENCIA, O NIÑA, Y EN SU CASO, A SUS HIJAS E HIJOS", 

                    "CANALIZAR Y TRASLADAR SIN DEMORA ALGUNA A LAS MUJERES, O LAS NIÑAS, EN SITUACIÓN DE VIOLENCIA SEXUAL A LAS INSTITUCIONES QUE INTEGRAN EL SISTEMA NACIONAL DE SALUD PARA QUE PROVEAN GRATUITAMENTE Y DE MANERA INMEDIATA LOS SERVICIOS QUE CORRESPONDAN", 

                    "CUSTODIA PERSONAL Y O DOMICILIARIA A LAS VÍCTIMAS, QUE ESTARÁ A CARGO DE LOS CUERPOS POLICIACOS ADSCRITOS A LA INSTITUCIÓN DE PROCURACIÓN DE JUSTICIA DE LA ENTIDAD FEDERATIVA, O BIEN, A CARGO DE LA INSTITUCIÓN DE SEGURIDAD PÚBLICA DE LA ENTIDAD FEDERATIVA", 

                    "ORDENAR A LAS EMPRESAS DE PLATAFORMAS DIGITALES, DE MEDIOS DE COMUNICACIÓN, DE REDES SOCIALES O DE PÁGINAS ELECTRÓNICAS (PERSONAS FÍSICAS O MORALES), LA INTERRUPCIÓN, BLOQUEO, DESTRUCCIÓN O ELIMINACIÓN DE IMÁGENES, AUDIOS O VIDEOS RELACIONADOS CON LA INVESTIGACIÓN DE VIOLENCIA DIGITAL O MEDIÁTICA PARA GARANTIZAR LA INTEGRIDAD DE LA VÍCTIMA", 

                    "SOLICITUD A LA AUTORIDAD JUDICIAL COMPETENTE, SOBRE LA DESOCUPACIÓN INMEDIATA DEL DOMICILIO CONYUGAL O DONDE HABITE LA VÍCTIMA", 

                    "OTRAS MEDIDAS DE PROTECCIÓN CONTEMPLADAS PARA DELITOS POR SITUACIONES DE GÉNERO ", 

                    "OTRO TIPO DE MEDIDAS DE PROTECCIÓN ",

                    "NO IDENTIFICADO"
                  ];
                  foreach ($medidas as $keyM => $valueM) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"MEDIDAS DE PROTECCIÓN OTORGADAS A PERSONAS FÍSICAS" as INDICADOR'),
                        DB::raw('"TIPO DE MEDIDA DE PROTECCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueM.'" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                  }
                }
              }

            //068 - "MEDIDAS DE PROTECCIÓN OTORGADAS A PERSONAS MORALES - TIPO DE MEDIDA DE PROTECCIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_ev_medidas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_DE_MEDIDA','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('procp_dg_victimas as c', function($join)
                    {
                      $join->on('c.id','=','b.idVictima')
                      ->wherenull('c.deleted_at');
                    })
                    ->leftjoin('prode_victimas as d', function($join)
                    {
                      $join->on('d.id','=','c.idVictima')
                      ->where('d.TIPO_VICTIMA','=',2)
                      ->wherenull('d.deleted_at');
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','d.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',28)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"MEDIDAS DE PROTECCIÓN OTORGADAS A PERSONAS MORALES" as INDICADOR'),
                      db::raw('"TIPO DE MEDIDA DE PROTECCIÓN" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //069 - "MEDIDAS DE PROTECCIÓN OTORGADAS A PERSONAS MORALES - TIPO DE MEDIDA DE PROTECCIÓN ----EN BLANCO (NO EXISTEN)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $medidas=["SEPARACIÓN INMEDIATA DEL DOMICILIO", 
                    
                    "REINGRESO DE LA VÍCTIMA O PERSONA OFENDIDA A SU DOMICILIO,UNA VEZ QUE SE SALVAGUARDE SU SEGURIDAD ",

                    "PROHIBICIÓN INMEDIATA A LA PERSONA AGRESORA DE ACERCARSE AL DOMICILIO Y AL DE FAMILIARES Y AMISTADES,AL LUGAR DE TRABAJO, DE ESTUDIOS, O CUALQUIER OTRO QUE FRECUENTE LA VÍCTIMA DIRECTA O VÍCTIMAS INDIRECTAS ", 

                    "SOLICITUD A LA AUTORIDAD JUDICIAL COMPETENTE, LA SUSPENSIÓN TEMPORAL A LA PERSONA AGRESORA DEL RÉGIMEN DE VISITAS Y CONVIVENCIA CON SUS DESCENDIENTES", 

                    "PROHIBICIÓN A LA PERSONA AGRESORA DE INTIMIDAR O MOLESTAR POR SÍ, POR CUALQUIER MEDIO O INTERPÓSITA PERSONA, A LA MUJER EN SITUACIÓN DE VIOLENCIA Y, EN SU CASO, A SUS HIJAS E HIJOS U OTRAS VÍCTIMAS INDIRECTAS, TESTIGOS DE LOS HECHOS O CUALQUIER OTRA PERSONA CON QUIEN LA MUJER TENGA UNA RELACIÓN FAMILIAR, AFECTIVA, DE CONFIANZA O DE HECHO", 

                    "RESGUARDAR LAS ARMAS DE FUEGO U OBJETOS UTILIZADOS PARA AMENAZAR O AGREDIR A LA MUJER, O NIÑA, EN SITUACIÓN DE VIOLENCIA", 

                    "SOLICITAR A LA AUTORIDAD JURISDICCIONAL COMPETENTE, PARA GARANTIZAR LAS OBLIGACIONES ALIMENTARIAS, LA ELABORACIÓN DE UN INVENTARIO DE LOS BIENES DE LA PERSONA AGRESORA Y SU EMBARGO PRECAUTORIO, EL CUAL DEBERÁ INSCRIBIRSE CON CARÁCTER TEMPORAL EN EL REGISTRO PÚBLICO DE LA PROPIEDAD", 

                    "REINGRESO DE LA MUJER Y EN SU CASO A SUS HIJAS E HIJOS EN SITUACIÓN DE VIOLENCIA AL DOMICILIO, O BIEN, PARA ACCEDER AL DOMICILIO, LUGAR DE TRABAJO U OTRO, CON EL PROPÓSITO DE RECUPERAR SUS PERTENENCIAS PERSONALES Y LAS DE SUS HIJAS E HIJOS, UNA VEZ QUE SE SALVAGUARDE SU SEGURIDAD, ACOMPAÑADA DEL MINISTERIO PÚBLICO, O PERSONAL DE LA POLICÍA MINISTERIAL, O PERSONAL DE LA INSTITUCIÓN DE SEGURIDAD PÚBLICA O DE UNA PERSONA DE SU CONFIANZA", 

                    "ORDENAR LA ENTREGA INMEDIATA DE OBJETOS DE USO PERSONAL Y DOCUMENTOS DE IDENTIDAD A LA MUJER EN SITUACIÓN DE VIOLENCIA, O NIÑA, Y EN SU CASO, A SUS HIJAS E HIJOS", 

                    "CANALIZAR Y TRASLADAR SIN DEMORA ALGUNA A LAS MUJERES, O LAS NIÑAS, EN SITUACIÓN DE VIOLENCIA SEXUAL A LAS INSTITUCIONES QUE INTEGRAN EL SISTEMA NACIONAL DE SALUD PARA QUE PROVEAN GRATUITAMENTE Y DE MANERA INMEDIATA LOS SERVICIOS QUE CORRESPONDAN", 

                    "CUSTODIA PERSONAL Y O DOMICILIARIA A LAS VÍCTIMAS, QUE ESTARÁ A CARGO DE LOS CUERPOS POLICIACOS ADSCRITOS A LA INSTITUCIÓN DE PROCURACIÓN DE JUSTICIA DE LA ENTIDAD FEDERATIVA, O BIEN, A CARGO DE LA INSTITUCIÓN DE SEGURIDAD PÚBLICA DE LA ENTIDAD FEDERATIVA", 

                    "ORDENAR A LAS EMPRESAS DE PLATAFORMAS DIGITALES, DE MEDIOS DE COMUNICACIÓN, DE REDES SOCIALES O DE PÁGINAS ELECTRÓNICAS (PERSONAS FÍSICAS O MORALES), LA INTERRUPCIÓN, BLOQUEO, DESTRUCCIÓN O ELIMINACIÓN DE IMÁGENES, AUDIOS O VIDEOS RELACIONADOS CON LA INVESTIGACIÓN DE VIOLENCIA DIGITAL O MEDIÁTICA PARA GARANTIZAR LA INTEGRIDAD DE LA VÍCTIMA", 

                    "SOLICITUD A LA AUTORIDAD JUDICIAL COMPETENTE, SOBRE LA DESOCUPACIÓN INMEDIATA DEL DOMICILIO CONYUGAL O DONDE HABITE LA VÍCTIMA", 

                    "OTRAS MEDIDAS DE PROTECCIÓN CONTEMPLADAS PARA DELITOS POR SITUACIONES DE GÉNERO ", 

                    "OTRO TIPO DE MEDIDAS DE PROTECCIÓN ",

                    "NO IDENTIFICADO"
                  ];
                  foreach ($medidas as $keyM => $valueM) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"MEDIDAS DE PROTECCIÓN OTORGADAS A PERSONAS MORALES" as INDICADOR'),
                        DB::raw('"TIPO DE MEDIDA DE PROTECCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueM.'" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                  }
                }
              }  
          break;
          case 'INEGI31':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;  
            //070 - "MEDIDAS DE PROTECCIÓN OTORGADAS A PERSONAS NO IDENTIFICADAS - TIPO DE MEDIDA DE PROTECCIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_ev_medidas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_DE_MEDIDA','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('procp_dg_victimas as c', function($join)
                    {
                      $join->on('c.id','=','b.idVictima')
                      ->wherenull('c.deleted_at');
                    })
                    ->leftjoin('prode_victimas as d', function($join)
                    {
                      $join->on('d.id','=','c.idVictima')
                      ->where('d.TIPO_VICTIMA','=',5)
                      ->wherenull('d.deleted_at');
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','d.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',28)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"MEDIDAS DE PROTECCIÓN OTORGADAS A PERSONAS NO IDENTIFICADAS" as INDICADOR'),
                      db::raw('"TIPO DE MEDIDA DE PROTECCIÓN" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //071 - "MEDIDAS DE PROTECCIÓN OTORGADAS A PERSONAS NO IDENTIFICADAS - TIPO DE MEDIDA DE PROTECCIÓN ----EN BLANCO (NO EXISTEN)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $medidas=["SEPARACIÓN INMEDIATA DEL DOMICILIO", 
                    
                    "REINGRESO DE LA VÍCTIMA O PERSONA OFENDIDA A SU DOMICILIO,UNA VEZ QUE SE SALVAGUARDE SU SEGURIDAD ",

                    "PROHIBICIÓN INMEDIATA A LA PERSONA AGRESORA DE ACERCARSE AL DOMICILIO Y AL DE FAMILIARES Y AMISTADES,AL LUGAR DE TRABAJO, DE ESTUDIOS, O CUALQUIER OTRO QUE FRECUENTE LA VÍCTIMA DIRECTA O VÍCTIMAS INDIRECTAS ", 

                    "SOLICITUD A LA AUTORIDAD JUDICIAL COMPETENTE, LA SUSPENSIÓN TEMPORAL A LA PERSONA AGRESORA DEL RÉGIMEN DE VISITAS Y CONVIVENCIA CON SUS DESCENDIENTES", 

                    "PROHIBICIÓN A LA PERSONA AGRESORA DE INTIMIDAR O MOLESTAR POR SÍ, POR CUALQUIER MEDIO O INTERPÓSITA PERSONA, A LA MUJER EN SITUACIÓN DE VIOLENCIA Y, EN SU CASO, A SUS HIJAS E HIJOS U OTRAS VÍCTIMAS INDIRECTAS, TESTIGOS DE LOS HECHOS O CUALQUIER OTRA PERSONA CON QUIEN LA MUJER TENGA UNA RELACIÓN FAMILIAR, AFECTIVA, DE CONFIANZA O DE HECHO", 

                    "RESGUARDAR LAS ARMAS DE FUEGO U OBJETOS UTILIZADOS PARA AMENAZAR O AGREDIR A LA MUJER, O NIÑA, EN SITUACIÓN DE VIOLENCIA", 

                    "SOLICITAR A LA AUTORIDAD JURISDICCIONAL COMPETENTE, PARA GARANTIZAR LAS OBLIGACIONES ALIMENTARIAS, LA ELABORACIÓN DE UN INVENTARIO DE LOS BIENES DE LA PERSONA AGRESORA Y SU EMBARGO PRECAUTORIO, EL CUAL DEBERÁ INSCRIBIRSE CON CARÁCTER TEMPORAL EN EL REGISTRO PÚBLICO DE LA PROPIEDAD", 

                    "REINGRESO DE LA MUJER Y EN SU CASO A SUS HIJAS E HIJOS EN SITUACIÓN DE VIOLENCIA AL DOMICILIO, O BIEN, PARA ACCEDER AL DOMICILIO, LUGAR DE TRABAJO U OTRO, CON EL PROPÓSITO DE RECUPERAR SUS PERTENENCIAS PERSONALES Y LAS DE SUS HIJAS E HIJOS, UNA VEZ QUE SE SALVAGUARDE SU SEGURIDAD, ACOMPAÑADA DEL MINISTERIO PÚBLICO, O PERSONAL DE LA POLICÍA MINISTERIAL, O PERSONAL DE LA INSTITUCIÓN DE SEGURIDAD PÚBLICA O DE UNA PERSONA DE SU CONFIANZA", 

                    "ORDENAR LA ENTREGA INMEDIATA DE OBJETOS DE USO PERSONAL Y DOCUMENTOS DE IDENTIDAD A LA MUJER EN SITUACIÓN DE VIOLENCIA, O NIÑA, Y EN SU CASO, A SUS HIJAS E HIJOS", 

                    "CANALIZAR Y TRASLADAR SIN DEMORA ALGUNA A LAS MUJERES, O LAS NIÑAS, EN SITUACIÓN DE VIOLENCIA SEXUAL A LAS INSTITUCIONES QUE INTEGRAN EL SISTEMA NACIONAL DE SALUD PARA QUE PROVEAN GRATUITAMENTE Y DE MANERA INMEDIATA LOS SERVICIOS QUE CORRESPONDAN", 

                    "CUSTODIA PERSONAL Y O DOMICILIARIA A LAS VÍCTIMAS, QUE ESTARÁ A CARGO DE LOS CUERPOS POLICIACOS ADSCRITOS A LA INSTITUCIÓN DE PROCURACIÓN DE JUSTICIA DE LA ENTIDAD FEDERATIVA, O BIEN, A CARGO DE LA INSTITUCIÓN DE SEGURIDAD PÚBLICA DE LA ENTIDAD FEDERATIVA", 

                    "ORDENAR A LAS EMPRESAS DE PLATAFORMAS DIGITALES, DE MEDIOS DE COMUNICACIÓN, DE REDES SOCIALES O DE PÁGINAS ELECTRÓNICAS (PERSONAS FÍSICAS O MORALES), LA INTERRUPCIÓN, BLOQUEO, DESTRUCCIÓN O ELIMINACIÓN DE IMÁGENES, AUDIOS O VIDEOS RELACIONADOS CON LA INVESTIGACIÓN DE VIOLENCIA DIGITAL O MEDIÁTICA PARA GARANTIZAR LA INTEGRIDAD DE LA VÍCTIMA", 

                    "SOLICITUD A LA AUTORIDAD JUDICIAL COMPETENTE, SOBRE LA DESOCUPACIÓN INMEDIATA DEL DOMICILIO CONYUGAL O DONDE HABITE LA VÍCTIMA", 

                    "OTRAS MEDIDAS DE PROTECCIÓN CONTEMPLADAS PARA DELITOS POR SITUACIONES DE GÉNERO ", 

                    "OTRO TIPO DE MEDIDAS DE PROTECCIÓN ",

                    "NO IDENTIFICADO"
                  ];
                  foreach ($medidas as $keyM => $valueM) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"MEDIDAS DE PROTECCIÓN OTORGADAS A PERSONAS NO IDENTIFICADAS" as INDICADOR'),
                        DB::raw('"TIPO DE MEDIDA DE PROTECCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueM.'" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                  }
                }
              }  
            //072 - "MEDIDAS DE PROTECCIÓN OTORGADAS DE OFICIO  ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"MEDIDAS DE PROTECCIÓN OTORGADAS DE OFICIO" as INDICADOR'),
                        DB::raw('"" as TIPO_DESAGREGACION'),
                        DB::raw('"" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;           
                }
              }
            //073 FO- "NOTIFICACIONES - MEDIO RECEPCIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sqlFO = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"NOTIFICACIONES" as INDICADOR'),
                        DB::raw('"MEDIO RECEPCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"FORMA ORAL" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );
                    
                    $sql=$sqlFO;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
            //073 PE- "NOTIFICACIONES - MEDIO RECEPCIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    
                    $sqlPE = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"NOTIFICACIONES" as INDICADOR'),
                        DB::raw('"MEDIO RECEPCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"POR ESCRITO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );  
                    $sql=$sqlPE;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
             //073 EL- "NOTIFICACIONES - MEDIO RECEPCIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                     
                    $sqlEL = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"NOTIFICACIONES" as INDICADOR'),
                        DB::raw('"MEDIO RECEPCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"EN LÍNEA" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );   
                    $sql=$sqlEL;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
             //073 OM- "NOTIFICACIONES - MEDIO RECEPCIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                                                                      
                    $sqlOM = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"NOTIFICACIONES" as INDICADOR'),
                        DB::raw('"MEDIO RECEPCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"OTRO MEDIO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );    
                    $sql=$sqlOM;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
          break;
          case 'INEGI32':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;  
            //074 - "ÓRDENES DE APREHENSIÓN CONCLUIDAS - TIPO DE CONCLUSIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_ev_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.ESTATUS_MANDAMIENTO','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_MANDAMIENTO',3)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',80)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"ÓRDENES DE APREHENSIÓN CONCLUIDAS" as INDICADOR'),
                      db::raw('"TIPO DE CONCLUSIÓN" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //075 - "ÓRDENES DE CITACIÓN CONCLUIDAS - TIPO DE CONCLUSIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_ev_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.ESTATUS_MANDAMIENTO','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_MANDAMIENTO',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',80)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"ÓRDENES DE CITACIÓN CONCLUIDAS" as INDICADOR'),
                      db::raw('"TIPO DE CONCLUSIÓN" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
            //076 - "ÓRDENES DE COMPARECENCIA CONCLUIDAS - TIPO DE CONCLUSIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_ev_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.ESTATUS_MANDAMIENTO','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_MANDAMIENTO',2)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',80)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"ÓRDENES DE COMPARECENCIA CONCLUIDAS" as INDICADOR'),
                      db::raw('"TIPO DE CONCLUSIÓN" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //077 - "ÓRDENES DE REAPREHENSIÓN CONCLUIDAS - TIPO DE CONCLUSIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_ev_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.ESTATUS_MANDAMIENTO','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_MANDAMIENTO',4)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',80)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"ÓRDENES DE REAPREHENSIÓN CONCLUIDAS" as INDICADOR'),
                      db::raw('"TIPO DE CONCLUSIÓN" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //078 - "ÓRDENES JUDICIALES CONCLUIDAS  - TIPO DE CONCLUSIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $motivos=['CUMPLIMENTADAS','CANCELADAS','OTRO TIPO DE CONCLUSIÓN'];
                  foreach ($motivos as $keyM => $valueM) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"ÓRDENES JUDICIALES CONCLUIDAS" as INDICADOR'),
                        DB::raw('"TIPO DE CONCLUSIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueM.'" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                  }               
                }
              }                 
            //079 - "ÓRDENES JUDICIALES GIRADAS - TIPO DE ÓRDEN JUDICIAL ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $motivos=['APREHENSIÓN','REAPREHENSIÓN','COMPARECENCIA','CITACIÓN','OTRO TIPO DE ORDEN JUDICIAL'];
                  foreach ($motivos as $keyM => $valueM) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"ÓRDENES JUDICIALES GIRADAS" as INDICADOR'),
                        DB::raw('"TIPO DE ÓRDEN JUDICIAL" as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueM.'" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                  }               
                }
              }     
            //080 - "ÓRDENES JUDICIALES PENDIENTES DE CUMPLIMENTARSE AL CIERRE DEL AÑO - TIPO DE ÓRDEN JUDICIAL ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $motivos=['APREHENSIÓN','REAPREHENSIÓN','COMPARECENCIA','CITACIÓN','OTRO TIPO DE ORDEN JUDICIAL'];
                  foreach ($motivos as $keyM => $valueM) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"ÓRDENES JUDICIALES PENDIENTES DE CUMPLIMENTARSE AL CIERRE DEL AÑO" as INDICADOR'),
                        DB::raw('"TIPO DE ÓRDEN JUDICIAL" as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueM.'" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                  }               
                }
              }    
            //081 - "ÓRDENES JUDICIALES PENDIENTES DE CUMPLIMENTARSE AL INICIO DEL AÑO - TIPO DE ÓRDEN JUDICIAL ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $motivos=['APREHENSIÓN','REAPREHENSIÓN','COMPARECENCIA','CITACIÓN','OTRO TIPO DE ORDEN JUDICIAL'];
                  foreach ($motivos as $keyM => $valueM) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"ÓRDENES JUDICIALES PENDIENTES DE CUMPLIMENTARSE AL INICIO DEL AÑO" as INDICADOR'),
                        DB::raw('"TIPO DE ÓRDEN JUDICIAL" as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueM.'" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                  }               
                }
              }  
            //082 - "OTRO TIPO DE ÓRDENES JUDICIALES CONCLUIDAS - TIPO DE CONCLUSIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $motivos=['CUMPLIMENTADAS','CANCELADAS','OTRO TIPO DE CONCLUSIÓN'];
                  foreach ($motivos as $keyM => $valueM) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"OTRO TIPO DE ÓRDENES JUDICIALES CONCLUIDAS" as INDICADOR'),
                        DB::raw('"TIPO DE CONCLUSIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueM.'" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                  }               
                }
              }                                     
          break;
          case 'INEGI33':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //083 C- "OTROS DELITOS CONTRA LA SALUDO RELACIONADOS CON NARCÓTICOS EN SU MODALIDAD DE NARCOMENUDEO  - GRADO DE CONSUMACIÓN ----EN BLANCO (NO EXISTE EL DELITO)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sqlC = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"OTROS DELITOS CONTRA LA SALUDO RELACIONADOS CON NARCÓTICOS EN SU MODALIDAD DE NARCOMENUDEO " as INDICADOR'),
                        DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"CONSUMADO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );
                                                 
                    $sql=$sqlC;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                  
            //083 T- "OTROS DELITOS CONTRA LA SALUDO RELACIONADOS CON NARCÓTICOS EN SU MODALIDAD DE NARCOMENUDEO  - GRADO DE CONSUMACIÓN ----EN BLANCO (NO EXISTE EL DELITO)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    
                    $sqlT = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"OTROS DELITOS CONTRA LA SALUDO RELACIONADOS CON NARCÓTICOS EN SU MODALIDAD DE NARCOMENUDEO " as INDICADOR'),
                        DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"TENTATIVA" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );  
                    
                    $sql=$sqlT;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                  
            //083 NI- "OTROS DELITOS CONTRA LA SALUDO RELACIONADOS CON NARCÓTICOS EN SU MODALIDAD DE NARCOMENUDEO  - GRADO DE CONSUMACIÓN ----EN BLANCO (NO EXISTE EL DELITO)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    
                    $sqlNI = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"OTROS DELITOS CONTRA LA SALUDO RELACIONADOS CON NARCÓTICOS EN SU MODALIDAD DE NARCOMENUDEO " as INDICADOR'),
                        DB::raw('"GRADO DE CONSUMACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"NO IDENTIFICADO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                                                      
                    $sql=$sqlNI;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                  
              
            //084 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - SEXO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.SEXO_IMPUTADO','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',17)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"SEXO" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //085 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - ESTATUS JURÍDICO Y TIPO DE DETENCIÓN - PERSONAS IMPUTADAS DETENIDAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_DETENCION','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',1)
                      ->where('DETENIDO_IMPUTADOS',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',23)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"ESTATUS JURÍDICO Y TIPO DE DETENCIÓN" as TIPO_DESAGREGACION'),
                      db::raw('"PERSONAS IMPUTADAS DETENIDAS" as DESAGREGACION_1'),
                      'a.valor as DESAGREGACION_2',                        
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
            //086 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - ESTATUS JUDICIAL Y ORDEN JUDICIAL - PERSONAS IMPUTADAS DETENIDAS Y/O PRESENTADAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_MANDAMIENTO','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',1)
                      ->where('DETENIDO_IMPUTADOS',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',66)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"ESTATUS JUDICIAL Y ORDEN JUDICIAL" as TIPO_DESAGREGACION'),
                      db::raw('"PERSONAS IMPUTADAS DETENIDAS Y/O PRESENTADAS" as DESAGREGACION_1'),
                      'a.valor as DESAGREGACION_2',                        
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                           
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }   
            //087 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - ESTATUS JUDICIAL Y ORDEN JUDICIAL - PERSONAS IMPUTADAS NO DETENIDAS Y/O NO PRESENTADAS 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_MANDAMIENTO','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',1)
                      ->where('DETENIDO_IMPUTADOS',0)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',66)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"ESTATUS JUDICIAL Y ORDEN JUDICIAL" as TIPO_DESAGREGACION'),
                      db::raw('"PERSONAS IMPUTADAS NO DETENIDAS Y/O NO PRESENTADAS " as DESAGREGACION_1'),
                      'a.valor as DESAGREGACION_2',                        
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
          break;
          case 'INEGI34':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //088 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - AUTORIDAD A CARGO DE LA DETENCIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.AUTORIDAD_DETENCION_IMPUTADOS','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',1)
                      ->where('DETENIDO_IMPUTADOS',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',24)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"AUTORIDAD A CARGO DE LA DETENCIÓN" as TIPO_DESAGREGACION'),
                      db::raw('CASE WHEN a.id IN (1) THEN "SECRETARÍA DE SEGURIDAD PÚBLICA U HOMÓLOGA DE LA ENTIDAD FEDERATIVA" WHEN a.id IN (2) THEN "SECRETARÍA DE SEGURIDAD PÚBLICA U HOMÓLOGA DE ALGÚN MUNICIPIO O DEMARCACIÓN TERRITORIAL DE LA ENTIDAD FEDERATIVA" WHEN a.id IN (3) THEN "FISCALÍA GENERAL O PROCURADURÍA GENERAL DE JUSTICIA DE LA ENTIDAD FEDERATIVA" WHEN a.id IN (4) THEN "Secretaría de la Defensa Nacional" WHEN a.id IN (5) THEN "SECRETARÍA DE MARINA" WHEN a.id IN (6) THEN "SECRETARÍA DE SEGURIDAD Y PROTECCIÓN CIUDADANA (INCLUYE GUARDIA NACIONAL)" WHEN a.id IN (7) THEN "OTRA AUTORIDAD, NO IDENTIFICADO" ELSE a.valor END as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //089 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - VERIFICACIÓN DE EXISTENCIA DE FLAGRANCIA 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.EXAMEN_DETENCION_IMPUTADOS','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',1)
                      ->where('DETENIDO_IMPUTADOS',1)
                      ->where('TIPO_DETENCION',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',74)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"VERIFICACIÓN DE EXISTENCIA DE FLAGRANCIA" as TIPO_DESAGREGACION'),
                      db::raw('CASE WHEN a.Valor ="JUSTIFICADO" THEN "LEGAL" WHEN a.Valor ="NO JUSTIFICADO" THEN "ILEGAL" ELSE a.Valor END as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                                
            //090 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - RANGO DE EDAD 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=[
                    ["0 A 4 AÑOS", 0,4], 
                    ["DE 5 A 9 AÑOS", 5,9], 
                    ["DE 10 A 14 AÑOS", 10,14], 
                    ["DE 15 A 17 AÑOS", 15,17], 
                    ["DE 18 A 19 AÑOS", 18,19], 
                    ["DE 20 A 24 AÑOS", 20,24], 
                    ["DE 25 A 29 AÑOS", 25,29], 
                    ["DE 30 A 34 AÑOS", 30,34], 
                    ["DE 35 A 39 AÑOS", 35,39], 
                    ["DE 40 A 44 AÑOS", 40,44], 
                    ["DE 45 A 49 AÑOS", 45,49], 
                    ["DE 50 A 54 AÑOS", 50,54], 
                    ["DE 55 A 59 AÑOS", 55,59], 
                    ["DE 60 AÑOS O MÁS", 60,200], 
                    //["NO IDENTIFICADO", 0,0], 
                  ];
                  foreach ($rangos as $keyR => $valueR) {
                    $dwn=$valueR[1];
                    $up=$valueR[2];
                    $sql = datos_expediente\de_datosgenerales::leftjoin('prode_imputados as im', function($join) use($anio,$mes,$dwn,$up)
                      {
                        $join->on('prode_datosgenerales.id','=','im.idExpediente')                          
                        ->where('TIPO_IMPUTADO',1)
                        ->whereNull('im.deleted_at')                          
                        ->whereraw('YEAR(im.created_at)='.$anio)
                        ->whereraw('MONTH(im.created_at)='.$mes)
                        ->Where('EDAD_HECHOS_IMPUTADOS','!=','')
                        ->WhereBetween('EDAD_HECHOS_IMPUTADOS',[$dwn,$up]);
                      })                        
                        ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"RANGO DE EDAD" as TIPO_DESAGREGACION'),
                      db::raw('"'.$valueR[0].'" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(im.id) as UNIDAD')); 
            
                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;    
                  }
                  $sql = datos_expediente\de_datosgenerales::leftjoin('prode_imputados as im', function($join) use($anio,$mes)
                      {
                        $join->on('prode_datosgenerales.id','=','im.idExpediente')                          
                        ->where('TIPO_IMPUTADO',1)
                        ->whereNull('im.deleted_at')
                        ->whereraw('YEAR(im.created_at)='.$anio)
                        ->whereraw('MONTH(im.created_at)='.$mes)
                        ->Where('EDAD_HECHOS_IMPUTADOS','=','');
                      })                        
                        ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"RANGO DE EDAD" as TIPO_DESAGREGACION'),
                      db::raw('"NO IDENTIFICADO" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(im.id) as UNIDAD'));
           
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                      
                                  
                }
              } 
            //091 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - NACIONALIDAD 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=[
                    ["MEXICANA", 52], 
                    ["ESTADOUNIDENSE",1], 
                    ["CANADIENSE",11], 
                    ["BELICEÑA", 7], 
                    ["COSTARRICENSE", 109], 
                    ["GUATEMALTECA",120], 
                    ["HONDUREÑA", 126], 
                    ["NICARAGÜENSE",150], 
                    ["PANAMEÑA", 152], 
                    ["SALVADOREÑA", 176], 
                    ["ARGENTINA", 92], 
                    ["BRASILEÑA", 188], 
                    ["COLOMBIANA", 106], 
                  ];
                  foreach ($rangos as $keyR => $valueR) {
                    $pais=$valueR[1];
                    $sql = datos_expediente\de_datosgenerales::leftjoin('prode_imputados as im', function($join) use($anio,$mes,$pais)
                      {
                        $join->on('prode_datosgenerales.id','=','im.idExpediente')                          
                        ->where('TIPO_IMPUTADO',1)
                        ->whereNull('im.deleted_at')                          
                        ->whereraw('YEAR(im.created_at)='.$anio)
                        ->whereraw('MONTH(im.created_at)='.$mes)
                        ->Where('NACIONALIDAD','=',$pais);
                      })                        
                        ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"NACIONALIDAD" as TIPO_DESAGREGACION'),
                      db::raw('"'.$valueR[0].'" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(im.id) as UNIDAD')); 
            
                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;    
                  }
                  $sql = datos_expediente\de_datosgenerales::leftjoin('prode_imputados as im', function($join) use($anio,$mes)
                      {
                        $join->on('prode_datosgenerales.id','=','im.idExpediente')                          
                        ->where('TIPO_IMPUTADO',1)
                        ->whereNull('im.deleted_at')
                        ->whereraw('YEAR(im.created_at)='.$anio)
                        ->whereraw('MONTH(im.created_at)='.$mes)
                        ->whereNotIn('NACIONALIDAD',[52, 1, 11, 7, 109, 120,126,150,152,176,92, 188,106]);
                      })                        
                        ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"NACIONALIDAD" as TIPO_DESAGREGACION'),
                      db::raw('"OTRAS NACIONALIDADES" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(im.id) as UNIDAD'));
           
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                      
                                  
                }
              }
            //092 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - OCUPACIÓN ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=[["PERSONAS FUNCIONARIAS, DIRECTORAS Y JEFAS ",["ALCALDE","DIRECTOR DE EMPRESA PRIVADA","DIRECTOR DE INSTITUCIÓN PÚBLICA","EMBAJADOR","GERENTE DE EMPRESA PRIVADA","GOBERNADOR DE ENTIDAD FEDERATIVA","JEFE DE DEPARTAMENTO DE INSTITUCIÓN PÚBLICA","JEFE DE EMPRESA PRIVADA","MINISTRO","PRESIDENTE DE CÁMARA EMPRESARIAL","PRESIDENTE DE INSTITUCIÓN PÚBLICA","PRESIDENTE DE LA REPÚBLICA","PRESIDENTE DE LA SUPREMA CORTE DE JUSTICIA","PRESIDENTE DE PARTIDO POLÍTICO","PRESIDENTE MUNICIPAL","SECRETARIO DE ESTADO","SECRETARIO GENERAL DEL SINDICATO","SENADOR DE LA REPÚBLICA","SUBDIRECTOR DE INSTITUCIÓN PÚBLICA","SUBSECRETARIO DE ESTADO","TESORERO"]], 

                    ["PERSONAS PROFESIONALES Y TÉCNICAS",["ABOGADO","ACTUARIO","AGRÓNOMO","ANALISTA","ANTROPÓLOGO","ARQUEÓLOGO","ARQUITECTO","ASTRÓLOGO O ASTRÓNOMO","BIÓLOGO","CONSULTOR","CONTADOR","DENTISTA","DISEÑADOR","FARMACÓLOGO","FILÓSOFO","FÍSICO","FOTÓGRAFO","INGENIERO","LINGÜISTA","MATEMÁTICO","MÉDICO","NUTRIÓLOGO","OFTALMÓLOGO","PERITO","PSICOANALISTA","PSICÓLOGO","PSICOTERAPEUTA","PSIQUIATRA","QUÍMICO","RADIÓLOGO","SOCIÓLOGO","TRABAJADOR SOCIAL","TRADUCTOR","VETERINARIO"]], 

                    ["PERSONAS TRABAJADORAS AUXILIARES EN ACTIVIDADES ADMINISTRATIVAS",["AGENTE DEL MINISTERIO PÚBLICO","AGENTE MINISTERIAL O DE INVESTIGACIÓN","AUXILIAR","CAPTURISTA DE DATOS","RECEPCIONISTA","SECRETARIA","SECRETARIO(A) DE JUZGADO","SUBSECRETARIO DE ESTADO","VALUADOR"]], 

                    ["PERSONAS COMERCIANTES, EMPLEADAS EN VENTAS Y AGENTE DE VENTAS",["ABARROTERO","COMERCIANTE","VENDEDOR(A)"]], 

                    ["PERSONAS TRABAJADORAS EN SERVICIOS PERSONALES Y DE VIGILANCIA",["AEROMOZA","AZAFATA O SOBRECARGO","ANIMADOR O MAESTRO DE CEREMONIAS","BARBERO","BARISTA","CUIDADOR O NIÑERA","DAMA DE COMPAÑÍA","ESTILISTA","MASAJISTA","MODELO","MOZO","SASTRE","SEXOSERVIDOR(A)","VELADOR","TATUADOR"]], 

                    ["PERSONAS TRABAJADORAS EN ACTIVIDADES AGRÍCOLAS, GANADERAS, FORESTALES, CAZA Y PESCA",["AGRICULTOR","GANADERO","GUARDABOSQUES","PESCADOR"]], 

                    ["PERSONAS TRABAJADORAS ARTESANALES, EN LA CONSTRUCCIÓN Y OTROS OFICIOS",["ALBAÑIL","ARTESANO","CARPINTERO","CERRAJERO","DECORADOR","HOJALATERO","JARDINERO","JOYERO","LAPIDARIO","MECÁNICO","PINTOR","PLOMERO","SASTRE","TABLAJERO O CARNICERO","ZAPATERO","TITIRITERO"]], 

                    ["PERSONAS OPERADORAS DE MAQUINARIA INDUSTRIAL, ENSAMBLADORES, CHOFERES Y CONDUCTORES DE TRANSPORTE",["BICITAXISTA","CHOFER","MAQUINISTA","OPERADOR","REPARTIDOR","TAXISTA"]], 
                    ["PERSONAS TRABJADORAS EN ACTIVIDADES ELEMENTALES Y DE APOYO",["AYUDANTE","CARGADOR","EMPLEADA DOMÉSTICA","LAVACOCHES","RECOLECTOR DE BASURA"]], 
                    ["OCUPACIÓN NO IDENTIFICADA",["OCUPACIÓN NO IDENTIFICADA"]], 
                    //["NINGUNA",[]], 
                    ["NO IDENTIFICADO",["NO IDENTIFICADO"]]];
                  foreach ($rangos as $keyR => $valueR) {
                    $sql = datos_expediente\de_imputados::leftJoin('catocupaciones as a','prode_imputados.OCUPACION_IMPUTADO','=','a.id')
                      ->leftjoin('prode_datosgenerales as e','e.id','=','prode_imputados.idExpediente')
                        ->where('TIPO_IMPUTADO',1)
                        ->whereraw('YEAR(prode_imputados.created_at)='.$anio)
                        ->whereraw('MONTH(prode_imputados.created_at)='.$mes)
                        ->where('e.DELEGACION','=',$del)
                        ->whereIn('a.Valor',$valueR[1])
                      ->select(db::raw($anio.' as year'),
                        db::raw($mes.' as month'),
                        db::raw('"'.$value->Valor.'" as delVal'),
                        db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        db::raw('"OCUPACIÓN" as TIPO_DESAGREGACION'),
                        db::raw('"'.$valueR[0].'" as DESAGREGACION_1'),
                        db::raw('"" as DESAGREGACION_2'),
                        db::raw('COUNT(prode_imputados.id) as UNIDAD'));
                
                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                    $sql = datos_expediente\de_imputados::leftjoin('prode_datosgenerales as e','e.id','=','prode_imputados.idExpediente')
                        ->where('TIPO_IMPUTADO',1)->where('prode_imputados.OCUPACION_IMPUTADO','<',0)
                        ->whereraw('YEAR(prode_imputados.created_at)='.$anio)
                        ->whereraw('MONTH(prode_imputados.created_at)='.$mes)
                        ->where('e.DELEGACION','=',$del)
                      ->select(db::raw($anio.' as year'),
                        db::raw($mes.' as month'),
                        db::raw('"'.$value->Valor.'" as delVal'),
                        db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        db::raw('"OCUPACIÓN" as TIPO_DESAGREGACION'),
                        db::raw('"NINGUNA" as DESAGREGACION_1'),
                        db::raw('"" as DESAGREGACION_2'),
                        db::raw('COUNT(prode_imputados.id) as UNIDAD'));
                
                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;                 
                }
              }
            //093 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - CONDICIÓN DE PERTENENCIA A PUEBLO INDÍGENA 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.SE_IDENTIFICA_INDIGENA_IMPUTADO','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',4)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"CONDICIÓN DE PERTENENCIA A PUEBLO INDÍGENA " as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                                                  
            //094 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DE DISCAPACIDAD
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_DISCAPACIDAD_IMPUTADOS','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',19)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"TIPO DE DISCAPACIDAD" as TIPO_DESAGREGACION'),
                      db::raw('CASE WHEN a.Valor ="DIFICULTAD FÍSICA (CAMINAR, SUBIR O BAJAR)" THEN "DIFICULTAD O IMPEDIMENTO PARA MOVER O USAR SUS BRAZO O MANOS" ELSE a.Valor END as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //095 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - ESCOLARIDAD
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.ESCOLARIDAD_IMPUTADO','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',20)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"ESCOLARIDAD" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //096 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - ESTADO PSICOFÍSICO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.ESTADO_PRESENTACION','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',75)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"ESTADO PSICOFÍSICO" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //097 - "PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - PRESENTA LESIONES
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.LESIONADO','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',4)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS FÍSICAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"PRESENTA LESIONES" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
          break;
          case 'INEGI35':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 

            //098 - "PERSONAS FÍSICAS IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - SEXO ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=["HOMBRE","MUJER", "NO IDENTIFICADO"];
                  foreach ($rangos as $keyR => $valueR) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PERSONAS FÍSICAS IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                      DB::raw('"SEXO" as TIPO_DESAGREGACION'),
                      DB::raw('"'.$valueR.'" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }
            //099 - "PERSONAS FÍSICAS IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - SEXO ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=["HOMBRE","MUJER", "NO IDENTIFICADO"];
                  foreach ($rangos as $keyR => $valueR) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PERSONAS FÍSICAS IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"SEXO" as TIPO_DESAGREGACION'),
                      DB::raw('"'.$valueR.'" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              } 
            //100 - "PERSONAS FÍSICAS IMPUTADAS REGISTRADAS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - SEXO ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=["HOMBRE","MUJER", "NO IDENTIFICADO"];
                  foreach ($rangos as $keyR => $valueR) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PERSONAS FÍSICAS IMPUTADAS REGISTRADAS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"SEXO" as TIPO_DESAGREGACION'),
                      DB::raw('"'.$valueR.'" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }
            //101 - "PERSONAS FÍSICAS IMPUTADAS REGISTRADAS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL - TIPO DETERMINACIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=["FACULTAD DE ABSTENERSE DE INVESTIGAR", 
                    "CRITERIOS DE OPORTUNIDAD ", 
                    "ACUERDOS REPARATORIOS", 
                    "NO EJERCICIO DE LA ACCIÓN PENAL", 
                    "ARCHIVO TEMPORAL ", 
                    "INCOMPENTENCIA ", 
                    "EJERCICIO DE LA ACCIÓN PENAL", 
                    "ACUMULACIÓN", 
                    "OTRAS DETERMINACIONES Y/O CONCLUSIONES"];
                  foreach ($rangos as $keyR => $valueR) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PERSONAS FÍSICAS IMPUTADAS REGISTRADAS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"TIPO DETERMINACIÓN" as TIPO_DESAGREGACION'),
                      DB::raw('"'.$valueR.'" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }
            //102 - "PERSONAS IMPUTADAS - FORMULACIÓN DE LA IMPUTACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('procp_ai_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.FORMULACION','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',2)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS IMPUTADAS" as INDICADOR'),
                      db::raw('"FORMULACIÓN DE LA IMPUTACIÓN" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //103 - "PERSONAS IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - ESTATUS ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=["EN CURSO DE PROCEDIMIENTO", 
                    "EN PLAZO DE CIERRE DE LA INVESTIGACIÓN COMPLEMENTARIA ", 
                    "EN TRÁMITE EN EL ÓRGANO O UNIDAD ADMINISTRATIVA ENCARGADA DEL EJERCICIO DE LA FUNCIÓN DE LOS MECANISMOS ALTERNATIVOS DE SOLUCIÓN DE CONTROVERSIAS EN MATERIA PENAL", 
                    "EN SUSPENSIÓN CONDICIONAL DEL PROCESO", 
                    "EN PROCEDIMIENTO ABREVIADO", 
                    "EN SUSPENSIÓN DEL PROCESO", 
                    "EN OTRO ESTATUS EN ETAPA DE INVESTIGACIÓN COMPLEMENTARIA", 
                    "NO IDENTIFICADO", 
                    "EN PROCESO DE INVESTIGACIÓN", 
                    "EN TRÁMITE EN EL ÓRGANO O UNIDAD ADMINISTRATIVA ENCARGADA DEL EJERCICIO DE LA FUNCIÓN DE LOS MECANISMOS ALTERNATIVOS DE SOLUCIÓN DE CONTROVERSIAS EN MATERIA PENAL", 
                    "ARCHIVO TEMPORAL", 
                    "ORDEN JUDICIAL PENDIENTE DE CUMPLIMENTARSE", 
                    "EN OTRO ESTATUS EN ETAPA DE INVESTIGACIÓN INICIAL", 
                    "NO IDENTIFICADO"
                  ];
                  foreach ($rangos as $keyR => $valueR) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PERSONAS IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                      DB::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      DB::raw('"'.$valueR.'" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              } 
            //104 - "PERSONAS IMPUTADAS NO VINCULADAS A PROCESO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftJoin('procp_ai_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('prode_datosgenerales.id','=','b.idExpediente')
                      ->wherenull('b.deleted_at')
                      ->where('RESOLUCION','=',2)
                      ->whereraw('YEAR(b.created_at)='.$anio)                        
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS IMPUTADAS NO VINCULADAS A PROCESO" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(b.id) as UNIDAD')
                    );
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //105 - "PERSONAS IMPUTADAS REGISTRADAS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA - TIPO DETERMINACIÓN ----PENDIENTE (NO EXISTE)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $motivos=["DESISTIMIENTO DE LA ACCIÓN PENAL", 
                            "INCOMPETENCIAS", 
                            "CRITERIOS DE OPORTUNIDAD", 
                            "SUSPENSIÓN DEL PROCESO", 
                            "SOBRESEIMIENTO", 
                            "SOLUCIONES ALTERNAS", 
                            "PROCEDIMIENTO ABREVIADO", 
                            "FORMULACIÓN DE LA ACUSACIÓN", 
                            "ACUMULACIÓN", 
                            "OTRAS DETERMINACIONES Y/O CONCLUSIONES"];
                  foreach ($motivos as $keyM => $valueM) {
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"PERSONAS IMPUTADAS REGISTRADAS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                        DB::raw('"TIPO DETERMINACIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"'.$valueM.'" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;   
                  }
                }
              }      
            //106 - "PERSONAS IMPUTADAS VINCULADAS A PROCESO 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftJoin('procp_ai_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('prode_datosgenerales.id','=','b.idExpediente')
                      ->wherenull('b.deleted_at')
                      ->where('RESOLUCION','=',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)                        
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS IMPUTADAS VINCULADAS A PROCESO" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(b.id) as UNIDAD')
                    );
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
          break;
          case 'INEGI36':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;               
            //107 - "PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('prode_datosgenerales.id','=','b.idExpediente')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO','=',2)
                      ->whereraw('YEAR(b.created_at)='.$anio)                        
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(b.id) as UNIDAD')
                    );
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //108 - "PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - SECTOR
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.SECTOR_IMPUTADOS','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',2)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',15)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"SECTOR" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //109 - "PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - ESTATUS JURÍDICO Y TIPO DE DETENCIÓN - PERSONAS IMPUTADAS DETENIDAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_DETENCION','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',2)
                      ->where('DETENIDO_IMPUTADOS',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',23)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"ESTATUS JURÍDICO Y TIPO DE DETENCIÓN" as TIPO_DESAGREGACION'),
                      db::raw('"PERSONAS IMPUTADAS DETENIDAS" as DESAGREGACION_1'),
                      'a.valor as DESAGREGACION_2',                        
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //110 - "PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - ESTATUS JUDICIAL Y ORDEN JUDICIAL - PERSONAS IMPUTADAS DETENIDAS Y/O PRESENTADAS
                foreach ($delegaciones as $key => $value) {
                  $del=$value->id;
                  for ($mes = 1; $mes <= 12; $mes++) {
                    $sql = DB::table('catrespuestas as a')
                      ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                      {
                        $join->on('b.TIPO_MANDAMIENTO','=','a.id')
                        ->wherenull('b.deleted_at')
                        ->where('TIPO_IMPUTADO',1)
                        ->where('DETENIDO_IMPUTADOS',1)
                        ->whereraw('YEAR(b.created_at)='.$anio)
                        ->whereraw('MONTH(b.created_at)='.$mes);                        
                      })
                      ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                      {
                        $join->on('e.id','=','b.idExpediente')
                        ->where('e.DELEGACION','=',$del);
                      })
                      ->where('a.idtiporespuesta','=',66)
                      ->select(db::raw($anio.' as year'),
                        db::raw($mes.' as month'),
                        db::raw('"'.$value->Valor.'" as delVal'),
                        db::raw('"PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        db::raw('"ESTATUS JUDICIAL Y ORDEN JUDICIAL" as TIPO_DESAGREGACION'),
                        db::raw('"PERSONAS IMPUTADAS DETENIDAS Y/O PRESENTADAS" as DESAGREGACION_1'),
                        'a.valor as DESAGREGACION_2',                        
                        db::raw('COUNT(e.id) as UNIDAD')
                      )
                      ->groupby('a.id');                           
                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;                  
                  }
                } 
            //111 - "PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS - AUTORIDAD A CARGO DE LA DETENCIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.AUTORIDAD_DETENCION_IMPUTADOS','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO',2)
                      ->where('DETENIDO_IMPUTADOS',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',24)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS MORALES IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"AUTORIDAD A CARGO DE LA DETENCIÓN" as TIPO_DESAGREGACION'),
                      db::raw('CASE WHEN a.id IN (1) THEN "SECRETARÍA DE SEGURIDAD PÚBLICA U HOMÓLOGA DE LA ENTIDAD FEDERATIVA" WHEN a.id IN (2) THEN "SECRETARÍA DE SEGURIDAD PÚBLICA U HOMÓLOGA DE ALGÚN MUNICIPIO O DEMARCACIÓN TERRITORIAL DE LA ENTIDAD FEDERATIVA" WHEN a.id IN (3) THEN "FISCALÍA GENERAL O PROCURADURÍA GENERAL DE JUSTICIA DE LA ENTIDAD FEDERATIVA" WHEN a.id IN (4) THEN "Secretaría de la Defensa Nacional" WHEN a.id IN (5) THEN "SECRETARÍA DE MARINA" WHEN a.id IN (6) THEN "SECRETARÍA DE SEGURIDAD Y PROTECCIÓN CIUDADANA (INCLUYE GUARDIA NACIONAL)" WHEN a.id IN (7) THEN "OTRA AUTORIDAD, NO IDENTIFICADO" ELSE a.valor END as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //112 - "PERSONAS MORALES IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {               
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PERSONAS MORALES IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                      DB::raw('"" as TIPO_DESAGREGACION'),
                      DB::raw('"" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                }
              } 
            //113 - "PERSONAS MORALES IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {                     
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PERSONAS MORALES IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"" as TIPO_DESAGREGACION'),
                      DB::raw('"" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                }
              } 
            //114 - "PERSONAS MORALES IMPUTADAS REGISTRADAS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL  ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
            
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PERSONAS MORALES IMPUTADAS REGISTRADAS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"SEXO" as TIPO_DESAGREGACION'),
                      DB::raw('"" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                }
              } 
          break;
          case 'INEGI37':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;             
            //115 - "PERSONAS NO IDENTIFICADAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('prode_datosgenerales.id','=','b.idExpediente')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_IMPUTADO','=',5)
                      ->whereraw('YEAR(b.created_at)='.$anio)                        
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PERSONAS NO IDENTIFICADAS IMPUTADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(b.id) as UNIDAD')
                    );
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //116 - "PERSONAS NO IDENTIFICADAS IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {               
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PERSONAS NO IDENTIFICADAS IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                      DB::raw('"" as TIPO_DESAGREGACION'),
                      DB::raw('"" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                }
              } 
            //117 - "PERSONAS NO IDENTIFICADAS IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {                     
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PERSONAS NO IDENTIFICADAS IMPUTADAS EN LOS PROCEDIMIENTOS PENDIENTES DE CONCLUIR REGISTRADAS EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"" as TIPO_DESAGREGACION'),
                      DB::raw('"" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                }
              } 
            //118 - "PERSONAS NO IDENTIFICADAS IMPUTADAS REGISTRADAS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
            
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PERSONAS NO IDENTIFICADAS IMPUTADAS REGISTRADAS EN LAS DETERMINACIONES Y/O CONCLUSIONES EN LAS CARPETAS DE INVESTIGACIÓN EN LA ETAPA DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"SEXO" as TIPO_DESAGREGACION'),
                      DB::raw('"" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                }
              }          

            //119 - "PROCEDIMIENTOS ABREVIADOS APROBADOS 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftJoin('procp_procedimientoabreviado as b', function($join) use($anio,$mes)
                    {
                      $join->on('prode_datosgenerales.id','=','b.idExpediente')
                      ->wherenull('b.deleted_at')
                      ->where('NO_ADMISION_DEL_ABREVIADO','=',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)                        
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"PROCEDIMIENTOS ABREVIADOS APROBADOS" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(b.id) as UNIDAD')
                    );
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //120 - "PROCEDIMIENTOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
            
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PROCEDIMIENTOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN COMPLEMENTARIA" as INDICADOR'),
                      DB::raw('"" as TIPO_DESAGREGACION'),
                      DB::raw('"ESTATUS" as DESAGREGACION_1'),
                      DB::raw('"EN PROCESO DE INVESTIGACIÓN" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                }
              }
            //121 - "PROCEDIMIENTOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
            
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"PROCEDIMIENTOS PENDIENTES DE CONCLUIR EN LAS CARPETAS DE INVESTIGACIÓN INICIAL" as INDICADOR'),
                      DB::raw('"" as TIPO_DESAGREGACION'),
                      DB::raw('"ESTATUS" as DESAGREGACION_1'),
                      DB::raw('"EN PROCESO DE INVESTIGACIÓN" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                }
              }    
          break;
          case 'INEGI38':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //122 FO- "QUERELLAS - MEDIO RECEPCIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sqlFO = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"QUERELLAS" as INDICADOR'),
                        DB::raw('"MEDIO RECEPCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"FORMA ORAL" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );
                    
                    $sql=$sqlFO;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }          
            //122 PE- "QUERELLAS - MEDIO RECEPCIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    
                    $sqlPE = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"QUERELLAS" as INDICADOR'),
                        DB::raw('"MEDIO RECEPCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"POR ESCRITO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );  
                    
                    $sql=$sqlPE;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }      
            //122 EL- "QUERELLAS - MEDIO RECEPCIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    
                    $sqlEL = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"QUERELLAS" as INDICADOR'),
                        DB::raw('"MEDIO RECEPCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"EN LÍNEA" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );                                                      
                   
                    $sql=$sqlEL;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }      
            //122 OM- "QUERELLAS - MEDIO RECEPCIÓN ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                    $sqlOM = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"QUERELLAS" as INDICADOR'),
                        DB::raw('"MEDIO RECEPCIÓN" as TIPO_DESAGREGACION'),
                        DB::raw('"OTRO MEDIO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"0" as UNIDAD')
                      );    
                    $sql=$sqlOM;
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                                  
            //123 - "SUSPENSIONES CONDICIONALES DEL PROCESO APROBADAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftJoin('procp_salidasalternas as b', function($join)
                    {
                      $join->on('prode_datosgenerales.id','=','b.idExpediente')
                      ->wherenull('b.deleted_at');
                    })
                    ->leftJoin('procp_sa_suspensiones as c', function($join) use($anio,$mes)
                    {
                      $join->on('c.id_cp_salidasalternas','=','b.id')
                      ->wherenull('c.deleted_at')
                      ->whereraw('YEAR(c.created_at)='.$anio)                        
                      ->whereraw('MONTH(c.created_at)='.$mes);                        
                    })
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"SUSPENSIONES CONDICIONALES DEL PROCESO APROBADAS" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(c.id) as UNIDAD'));                      
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }    
 
            //124 - "VEHÍCULOS RECUPERADOS - TIPO DE VEHÍCULO ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=["AUTOMÓVILES", "CAMIONETAS", "CAMIONES", "MOTOCICLETAS", "CUATRIMOTOS", "OTRO TIPO DE VEHÍCULO"];
                  foreach ($rangos as $keyR => $valueR) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"VEHÍCULOS RECUPERADOS" as INDICADOR'),
                      DB::raw('"TIPO DE VEHÍCULO" as TIPO_DESAGREGACION'),
                      DB::raw('"'.$valueR.'" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }
            //125 - "VEHÍCULOS REPORTADOS Y/O DENUNCIADOS COMO ROBADOS  - TIPO DE VEHÍCULO ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=["AUTOMÓVILES", "CAMIONETAS", "CAMIONES", "MOTOCICLETAS", "CUATRIMOTOS", "OTRO TIPO DE VEHÍCULO"];
                  foreach ($rangos as $keyR => $valueR) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"VEHÍCULOS REPORTADOS Y/O DENUNCIADOS COMO ROBADOS" as INDICADOR'),
                      DB::raw('"TIPO DE VEHÍCULO" as TIPO_DESAGREGACION'),
                      DB::raw('"'.$valueR.'" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }
          break;
          case 'INEGI39':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;  
            //126 - "VÍCTIMAS FÍSICAS A QUIENES SE LES DICTARON MEDIDAS DE PROTECCIÓN OTORGADAS - SEXO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_victimas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.SEXO_VICTIMA','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_VICTIMA',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })                      
                    ->leftjoin('procp_dg_victimas as di', function($join)
                    {
                      $join->on('di.idVictima','=','b.id')
                      ->wherenull('di.deleted_at');
                    })
                    ->leftjoin('procp_ev_medidas as m', function($join)
                    {
                      $join->on('m.idVictima','=','di.id')->on('m.idExpediente','=','e.id')
                      ->wherenull('m.deleted_at');
                    })                      

                    ->where('a.idtiporespuesta','=',17)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS FÍSICAS A QUIENES SE LES DICTARON MEDIDAS DE PROTECCIÓN OTORGADAS" as INDICADOR'),
                      db::raw('"SEXO" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(DISTINCT(m.idVictima)) as UNIDAD')
                    )->groupby('a.id');
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //127 - "VÍCTIMAS FÍSICAS A QUIENES SE LES DICTARON MEDIDAS DE PROTECCIÓN OTORGADAS - RANGO DE EDAD 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=[
                    ["0 A 4 AÑOS", 0,4], 
                    ["DE 5 A 9 AÑOS", 5,9], 
                    ["DE 10 A 14 AÑOS", 10,14], 
                    ["DE 15 A 17 AÑOS", 15,17], 
                    ["DE 18 A 19 AÑOS", 18,19], 
                    ["DE 20 A 24 AÑOS", 20,24], 
                    ["DE 25 A 29 AÑOS", 25,29], 
                    ["DE 30 A 34 AÑOS", 30,34], 
                    ["DE 35 A 39 AÑOS", 35,39], 
                    ["DE 40 A 44 AÑOS", 40,44], 
                    ["DE 45 A 49 AÑOS", 45,49], 
                    ["DE 50 A 54 AÑOS", 50,54], 
                    ["DE 55 A 59 AÑOS", 55,59], 
                    ["DE 60 AÑOS O MÁS", 60,200], 
                    //["NO IDENTIFICADO", 0,0], 
                  ];
                  foreach ($rangos as $keyR => $valueR) {
                    $dwn=$valueR[1];
                    $up=$valueR[2];
                    $sql = datos_expediente\de_victimas::leftJoin('prode_datosgenerales as b', function($join) use($del)
                    {
                      $join->on('b.id','=','prode_victimas.idExpediente')
                      ->where('b.DELEGACION','=',$del);
                    })
                    ->leftJoin('procp_dg_victimas as di', function($join)
                    {
                      $join->on('di.idVictima','=','prode_victimas.id')
                      ->wherenull('di.deleted_at');
                    })
                    ->leftjoin('procp_ev_medidas as m', function($join)
                    {
                      $join->on('m.idVictima','=','di.id')->on('m.idExpediente','=','b.id')
                      ->wherenull('m.deleted_at');
                    })
                      ->where('TIPO_VICTIMA',1)
                      ->whereraw('YEAR(prode_victimas.created_at)='.$anio)
                      ->whereraw('MONTH(prode_victimas.created_at)='.$mes)
                      ->Where('EDAD_HECHOS_VICTIMAS','!=','')
                      ->WhereBetween('EDAD_HECHOS_VICTIMAS',[$dwn,$up])
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS FÍSICAS A QUIENES SE LES DICTARON MEDIDAS DE PROTECCIÓN OTORGADAS" as INDICADOR'),
                      db::raw('"RANGO DE EDAD" as TIPO_DESAGREGACION'),
                      db::raw('"'.$valueR[0].'" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(DISTINCT(m.idVictima)) as UNIDAD'));
                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;    
                  }
                  $sql = datos_expediente\de_victimas::leftJoin('prode_datosgenerales as b', function($join) use($del)
                    {
                      $join->on('b.id','=','prode_victimas.idExpediente')
                      ->where('b.DELEGACION','=',$del);
                    })
                    ->leftJoin('procp_dg_victimas as di', function($join)
                    {
                      $join->on('di.idVictima','=','prode_victimas.id')
                      ->wherenull('di.deleted_at');
                    })
                    ->leftjoin('procp_ev_medidas as m', function($join) use($del)
                    {
                      $join->on('m.idVictima','=','di.id')->on('m.idExpediente','=','b.id')
                      ->wherenull('m.deleted_at');
                    })
                      ->where('TIPO_VICTIMA',1)
                      ->whereraw('YEAR(prode_victimas.created_at)='.$anio)
                      ->whereraw('MONTH(prode_victimas.created_at)='.$mes)
                      ->Where('EDAD_HECHOS_VICTIMAS','=','')
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS FÍSICAS A QUIENES SE LES DICTARON MEDIDAS DE PROTECCIÓN OTORGADAS" as INDICADOR'),
                      db::raw('"RANGO DE EDAD" as TIPO_DESAGREGACION'),
                      db::raw('"NO IDENTIFICADO" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(DISTINCT(m.idVictima)) as UNIDAD'));                    
           
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                      
                                  
                }
              }
            //128 - "VÍCTIMAS FÍSICAS A QUIENES SE LES DICTARON MEDIDAS DE PROTECCIÓN OTORGADAS - TIPO DE RELACIÓN VÍCTIMA-IMPUTADO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_victimas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.RELACION_IMPUTADO','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_VICTIMA',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->leftjoin('procp_dg_victimas as di', function($join) use($del)
                    {
                      $join->on('di.idVictima','=','b.id')
                      ->wherenull('di.deleted_at');
                    })
                    ->leftjoin('procp_ev_medidas as m', function($join) use($del)
                    {
                      $join->on('m.idVictima','=','di.id')->on('m.idExpediente','=','e.id')
                      ->wherenull('m.deleted_at');
                    })                      
                    ->where('a.idtiporespuesta','=',21)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS FÍSICAS A QUIENES SE LES DICTARON MEDIDAS DE PROTECCIÓN OTORGADAS" as INDICADOR'),
                      db::raw('"TIPO DE RELACIÓN VÍCTIMA-IMPUTADO" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(DISTINCT(m.idVictima)) as UNIDAD')
                    )->groupby('a.id');
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //129 - "VÍCTIMAS NO IDENTIFICADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftJoin('prode_victimas  as b', function($join) use($anio,$mes)
                    {
                      $join->on('prode_datosgenerales.id','=','b.idExpediente')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_VICTIMA','=',5)
                      ->whereraw('YEAR(b.created_at)='.$anio)                        
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS NO IDENTIFICADAS EN CARPETAS DE INVESTIGACIÓN ABIERTAS " as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(b.id) as UNIDAD')
                    );
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
            //130 - "VÍCTIMAS NO IDENTIFICADAS QUIENES SE LES DICTARON MEDIDAS DE PROTECCIÓN OTORGADAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {                  
                  $sql = datos_expediente\de_victimas::leftJoin('prode_datosgenerales as b', function($join) use($del)
                    {
                      $join->on('b.id','=','prode_victimas.idExpediente')
                      ->where('b..DELEGACION','=',$del);
                    })
                    ->leftjoin('procp_dg_victimas as di', function($join) use($del)
                    {
                      $join->on('di.idVictima','=','prode_victimas.id')
                      ->wherenull('di.deleted_at');
                    })
                    ->leftjoin('procp_ev_medidas as m', function($join) use($del)
                    {
                      $join->on('m.idVictima','=','di.id')->on('m.idExpediente','=','b.id')
                      ->wherenull('m.deleted_at');
                    })
                    ->where('TIPO_VICTIMA',5)
                      ->whereraw('YEAR(prode_victimas.created_at)='.$anio)
                      ->whereraw('MONTH(prode_victimas.created_at)='.$mes)                      
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS NO IDENTIFICADAS QUIENES SE LES DICTARON MEDIDAS DE PROTECCIÓN OTORGADAS" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(DISTINCT(m.idVictima)) as UNIDAD'));                    
           
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                      
                                  
                }
              }
          break;
          case 'INEGI40':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //131 - "VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS - SEXO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_victimas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.SEXO_VICTIMA','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_VICTIMA',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',17)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"SEXO" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //132 - "VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS - RANGO DE EDAD 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=[
                    ["0 A 4 AÑOS", 0,4], 
                    ["DE 5 A 9 AÑOS", 5,9], 
                    ["DE 10 A 14 AÑOS", 10,14], 
                    ["DE 15 A 17 AÑOS", 15,17], 
                    ["DE 18 A 19 AÑOS", 18,19], 
                    ["DE 20 A 24 AÑOS", 20,24], 
                    ["DE 25 A 29 AÑOS", 25,29], 
                    ["DE 30 A 34 AÑOS", 30,34], 
                    ["DE 35 A 39 AÑOS", 35,39], 
                    ["DE 40 A 44 AÑOS", 40,44], 
                    ["DE 45 A 49 AÑOS", 45,49], 
                    ["DE 50 A 54 AÑOS", 50,54], 
                    ["DE 55 A 59 AÑOS", 55,59], 
                    ["DE 60 AÑOS O MÁS", 60,200], 
                    //["NO IDENTIFICADO", 0,0], 
                  ];
                  foreach ($rangos as $keyR => $valueR) {
                    $dwn=$valueR[1];
                    $up=$valueR[2];
                    $sql = datos_expediente\de_datosgenerales::leftjoin('prode_victimas as im', function($join) use($anio,$mes,$dwn,$up)
                      {
                        $join->on('prode_datosgenerales.id','=','im.idExpediente')                          
                        ->where('TIPO_VICTIMA',1)
                        ->whereNull('im.deleted_at')                          
                        ->whereraw('YEAR(im.created_at)='.$anio)
                        ->whereraw('MONTH(im.created_at)='.$mes)
                        ->Where('EDAD_HECHOS_VICTIMAS','!=','')
                        ->WhereBetween('EDAD_HECHOS_VICTIMAS',[$dwn,$up]);
                      })                        
                        ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"RANGO DE EDAD" as TIPO_DESAGREGACION'),
                      db::raw('"'.$valueR[0].'" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(im.id) as UNIDAD')); 
            
                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;    
                  }
                  $sql = datos_expediente\de_datosgenerales::leftjoin('prode_victimas as im', function($join) use($anio,$mes)
                      {
                        $join->on('prode_datosgenerales.id','=','im.idExpediente')                          
                        ->where('TIPO_VICTIMA',1)
                        ->whereNull('im.deleted_at')
                        ->whereraw('YEAR(im.created_at)='.$anio)
                        ->whereraw('MONTH(im.created_at)='.$mes)
                        ->Where('EDAD_HECHOS_VICTIMAS','=','');
                      })                        
                        ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"RANGO DE EDAD" as TIPO_DESAGREGACION'),
                      db::raw('"NO IDENTIFICADO" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(im.id) as UNIDAD'));
           
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                      
                                  
                }
              } 
            //133 - "VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS - NACIONALIDAD 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=[
                    ["MEXICANA", 52], 
                    ["ESTADOUNIDENSE",1], 
                    ["CANADIENSE",11], 
                    ["BELICEÑA", 7], 
                    ["COSTARRICENSE", 109], 
                    ["GUATEMALTECA",120], 
                    ["HONDUREÑA", 126], 
                    ["NICARAGÜENSE",150], 
                    ["PANAMEÑA", 152], 
                    ["SALVADOREÑA", 176], 
                    ["ARGENTINA", 92], 
                    ["BRASILEÑA", 188], 
                    ["COLOMBIANA", 106], 
                  ];
                  foreach ($rangos as $keyR => $valueR) {
                    $pais=$valueR[1];
                    $sql = datos_expediente\de_datosgenerales::leftjoin('prode_victimas as im', function($join) use($anio,$mes,$pais)
                      {
                        $join->on('prode_datosgenerales.id','=','im.idExpediente')                          
                        ->where('TIPO_VICTIMA',1)
                        ->whereNull('im.deleted_at')                          
                        ->whereraw('YEAR(im.created_at)='.$anio)
                        ->whereraw('MONTH(im.created_at)='.$mes)
                        ->Where('NACIONALIDAD','=',$pais);
                      })                        
                        ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"NACIONALIDAD" as TIPO_DESAGREGACION'),
                      db::raw('"'.$valueR[0].'" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(im.id) as UNIDAD')); 
            
                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;    
                  }
                  $sql = datos_expediente\de_datosgenerales::leftjoin('prode_victimas as im', function($join) use($anio,$mes)
                      {
                        $join->on('prode_datosgenerales.id','=','im.idExpediente')                          
                        ->where('TIPO_VICTIMA',1)
                        ->whereNull('im.deleted_at')
                        ->whereraw('YEAR(im.created_at)='.$anio)
                        ->whereraw('MONTH(im.created_at)='.$mes)
                        ->whereNotIn('NACIONALIDAD',[52, 1, 11, 7, 109, 120,126,150,152,176,92, 188,106]);
                      })                        
                        ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"NACIONALIDAD" as TIPO_DESAGREGACION'),
                      db::raw('"OTRAS NACIONALIDADES" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(im.id) as UNIDAD'));
           
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                      
                                  
                }
              }
            //134 - "VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS - OCUPACIÓN ----PENDIENTE (EQUIVALENCIAS)
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=[["PERSONAS FUNCIONARIAS, DIRECTORAS Y JEFAS ",["ALCALDE","DIRECTOR DE EMPRESA PRIVADA","DIRECTOR DE INSTITUCIÓN PÚBLICA","EMBAJADOR","GERENTE DE EMPRESA PRIVADA","GOBERNADOR DE ENTIDAD FEDERATIVA","JEFE DE DEPARTAMENTO DE INSTITUCIÓN PÚBLICA","JEFE DE EMPRESA PRIVADA","MINISTRO","PRESIDENTE DE CÁMARA EMPRESARIAL","PRESIDENTE DE INSTITUCIÓN PÚBLICA","PRESIDENTE DE LA REPÚBLICA","PRESIDENTE DE LA SUPREMA CORTE DE JUSTICIA","PRESIDENTE DE PARTIDO POLÍTICO","PRESIDENTE MUNICIPAL","SECRETARIO DE ESTADO","SECRETARIO GENERAL DEL SINDICATO","SENADOR DE LA REPÚBLICA","SUBDIRECTOR DE INSTITUCIÓN PÚBLICA","SUBSECRETARIO DE ESTADO","TESORERO"]], 

                    ["PERSONAS PROFESIONALES Y TÉCNICAS",["ABOGADO","ACTUARIO","AGRÓNOMO","ANALISTA","ANTROPÓLOGO","ARQUEÓLOGO","ARQUITECTO","ASTRÓLOGO O ASTRÓNOMO","BIÓLOGO","CONSULTOR","CONTADOR","DENTISTA","DISEÑADOR","FARMACÓLOGO","FILÓSOFO","FÍSICO","FOTÓGRAFO","INGENIERO","LINGÜISTA","MATEMÁTICO","MÉDICO","NUTRIÓLOGO","OFTALMÓLOGO","PERITO","PSICOANALISTA","PSICÓLOGO","PSICOTERAPEUTA","PSIQUIATRA","QUÍMICO","RADIÓLOGO","SOCIÓLOGO","TRABAJADOR SOCIAL","TRADUCTOR","VETERINARIO"]], 

                    ["PERSONAS TRABAJADORAS AUXILIARES EN ACTIVIDADES ADMINISTRATIVAS",["AGENTE DEL MINISTERIO PÚBLICO","AGENTE MINISTERIAL O DE INVESTIGACIÓN","AUXILIAR","CAPTURISTA DE DATOS","RECEPCIONISTA","SECRETARIA","SECRETARIO(A) DE JUZGADO","SUBSECRETARIO DE ESTADO","VALUADOR"]], 

                    ["PERSONAS COMERCIANTES, EMPLEADAS EN VENTAS Y AGENTE DE VENTAS",["ABARROTERO","COMERCIANTE","VENDEDOR(A)"]], 

                    ["PERSONAS TRABAJADORAS EN SERVICIOS PERSONALES Y DE VIGILANCIA",["AEROMOZA","AZAFATA O SOBRECARGO","ANIMADOR O MAESTRO DE CEREMONIAS","BARBERO","BARISTA","CUIDADOR O NIÑERA","DAMA DE COMPAÑÍA","ESTILISTA","MASAJISTA","MODELO","MOZO","SASTRE","SEXOSERVIDOR(A)","VELADOR","TATUADOR"]], 

                    ["PERSONAS TRABAJADORAS EN ACTIVIDADES AGRÍCOLAS, GANADERAS, FORESTALES, CAZA Y PESCA",["AGRICULTOR","GANADERO","GUARDABOSQUES","PESCADOR"]], 

                    ["PERSONAS TRABAJADORAS ARTESANALES, EN LA CONSTRUCCIÓN Y OTROS OFICIOS",["ALBAÑIL","ARTESANO","CARPINTERO","CERRAJERO","DECORADOR","HOJALATERO","JARDINERO","JOYERO","LAPIDARIO","MECÁNICO","PINTOR","PLOMERO","SASTRE","TABLAJERO O CARNICERO","ZAPATERO","TITIRITERO"]], 

                    ["PERSONAS OPERADORAS DE MAQUINARIA INDUSTRIAL, ENSAMBLADORES, CHOFERES Y CONDUCTORES DE TRANSPORTE",["BICITAXISTA","CHOFER","MAQUINISTA","OPERADOR","REPARTIDOR","TAXISTA"]], 
                    ["PERSONAS TRABJADORAS EN ACTIVIDADES ELEMENTALES Y DE APOYO",["AYUDANTE","CARGADOR","EMPLEADA DOMÉSTICA","LAVACOCHES","RECOLECTOR DE BASURA"]], 
                    ["OCUPACIÓN NO IDENTIFICADA",["OCUPACIÓN NO IDENTIFICADA"]], 
                    //["NINGUNA",[]], 
                    ["NO IDENTIFICADO",["NO IDENTIFICADO"]]];
                  foreach ($rangos as $keyR => $valueR) {
                    $sql = datos_expediente\de_victimas::leftJoin('catocupaciones as a','prode_victimas.OCUPACION','=','a.id')
                      ->leftjoin('prode_datosgenerales as e','e.id','=','prode_victimas.idExpediente')
                        ->where('TIPO_VICTIMA',1)
                        ->whereraw('YEAR(prode_victimas.created_at)='.$anio)
                        ->whereraw('MONTH(prode_victimas.created_at)='.$mes)
                        ->where('e.DELEGACION','=',$del)
                        ->whereIn('a.Valor',$valueR[1])
                      ->select(db::raw($anio.' as year'),
                        db::raw($mes.' as month'),
                        db::raw('"'.$value->Valor.'" as delVal'),
                        db::raw('"VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        db::raw('"OCUPACIÓN" as TIPO_DESAGREGACION'),
                        db::raw('"'.$valueR[0].'" as DESAGREGACION_1'),
                        db::raw('"" as DESAGREGACION_2'),
                        db::raw('COUNT(prode_victimas.id) as UNIDAD'));
                
                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                    $sql = datos_expediente\de_victimas::leftjoin('prode_datosgenerales as e','e.id','=','prode_victimas.idExpediente')
                        ->where('TIPO_VICTIMA',1)->where('prode_victimas.OCUPACION','<',0)
                        ->whereraw('YEAR(prode_victimas.created_at)='.$anio)
                        ->whereraw('MONTH(prode_victimas.created_at)='.$mes)
                        ->where('e.DELEGACION','=',$del)
                      ->select(db::raw($anio.' as year'),
                        db::raw($mes.' as month'),
                        db::raw('"'.$value->Valor.'" as delVal'),
                        db::raw('"VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                        db::raw('"OCUPACIÓN" as TIPO_DESAGREGACION'),
                        db::raw('"NINGUNA" as DESAGREGACION_1'),
                        db::raw('"" as DESAGREGACION_2'),
                        db::raw('COUNT(prode_victimas.id) as UNIDAD'));
                
                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;                 
                }
              }
            //135 - "VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS - CONDICIÓN DE PERTENENCIA A PUEBLO INDÍGENA 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_victimas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.SE_IDENTIFICA_INDIGENA_VICTIMA','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_VICTIMA',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',4)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"CONDICIÓN DE PERTENENCIA A PUEBLO INDÍGENA " as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                                                  
            //136 - "VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DE DISCAPACIDAD
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_victimas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_DISCAPACIDAD_VICTIMAS','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_VICTIMA',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',19)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"TIPO DE DISCAPACIDAD" as TIPO_DESAGREGACION'),
                      db::raw('CASE WHEN a.Valor ="DIFICULTAD FÍSICA (CAMINAR, SUBIR O BAJAR)" THEN "DIFICULTAD O IMPEDIMENTO PARA MOVER O USAR SUS BRAZO O MANOS" ELSE a.Valor END as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //137 - "VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS - TIPO DE RELACIÓN VÍCTIMA-IMPUTADO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_victimas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.SE_IDENTIFICA_INDIGENA_VICTIMA','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_VICTIMA',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',21)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS PERSONAS FÍSICAS  EN CARPETAS DE INVESTIGACIÓN ABIERTAS" as INDICADOR'),
                      db::raw('"TIPO DE RELACIÓN VÍCTIMA-IMPUTADO" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
          break;
          case 'INEGI41':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year; 
            //138 - "VÍCTIMAS PERSONAS MORALES A QUIENES SE LES DICTARON MEDIDAS DE PROTECCIÓN OTORGADAS - SECTOR
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_victimas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.SECTOR_VICTIMAS','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_VICTIMA',2)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })                      
                    ->leftjoin('procp_dg_victimas as di', function($join)
                    {
                      $join->on('di.idVictima','=','b.id')
                      ->wherenull('di.deleted_at');
                    })
                    ->leftjoin('procp_ev_medidas as m', function($join)
                    {
                      $join->on('m.idVictima','=','di.id')->on('m.idExpediente','=','e.id')
                      ->wherenull('m.deleted_at');
                    })                      

                    ->where('a.idtiporespuesta','=',15)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS PERSONAS MORALES A QUIENES SE LES DICTARON MEDIDAS DE PROTECCIÓN OTORGADAS" as INDICADOR'),
                      db::raw('"SECTOR" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(DISTINCT(m.idVictima)) as UNIDAD')
                    )->groupby('a.id');
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //139 - "VÍCTIMAS PERSONAS MORALES EN CARPETAS DE INVESTIGACIÓN ABIERTA - SECTOR
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_victimas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.SECTOR_VICTIMAS','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_VICTIMA',2)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',15)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS PERSONAS MORALES EN CARPETAS DE INVESTIGACIÓN ABIERTA" as INDICADOR'),
                      db::raw('"SECTOR" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                               
            //140 - "VÍCTIMAS PERSONAS MORALES EN CARPETAS DE INVESTIGACIÓN ABIERTA
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftJoin('prode_victimas  as b', function($join) use($anio,$mes)
                    {
                      $join->on('prode_datosgenerales.id','=','b.idExpediente')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_VICTIMA','=',2)
                      ->whereraw('YEAR(b.created_at)='.$anio)                        
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS PERSONAS MORALES EN CARPETAS DE INVESTIGACIÓN ABIERTA" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(b.id) as UNIDAD')
                    );
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                                
            //141 - "DENUNCIAS               
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::whereraw('YEAR(created_at)='.$anio)->whereraw('MONTH(created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)->where('RECIBIDA_POR','=',1)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"DENUNCIAS" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(id) as UNIDAD'));

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //142 - "NOTIFICACIONES
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::whereraw('YEAR(created_at)='.$anio)->whereraw('MONTH(created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)->where('RECIBIDA_POR','!=',1)->where('RECIBIDA_POR','!=',-1)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"NOTIFICACIONES" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(id) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
          break;
        }
        switch ($this->tipo) {
          case 'SESNSP1':
            $delegaciones=DB::table('catdelegaciones')->get();
            $c = 0;
            $anio=$this->year;
            //001 - "DENUNCIAS               
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::whereraw('YEAR(created_at)='.$anio)->whereraw('MONTH(created_at)='.$mes)
                    ->where('DELEGACION','=',$del)->where('RECIBIDA_POR','=',1)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"DENUNCIAS" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(id) as UNIDAD'));

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //002 - "QUERELLAS               
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::whereraw('YEAR(created_at)='.$anio)->whereraw('MONTH(created_at)='.$mes)
                    ->where('DELEGACION','=',$del)->where('RECIBIDA_POR','=',2)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"QUERELLAS" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(id) as UNIDAD'));

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }              
            //003 - "OTROS REQUISITOS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::whereraw('YEAR(created_at)='.$anio)->whereraw('MONTH(created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)->where('RECIBIDA_POR','!=',1)->where('RECIBIDA_POR','!=',-1)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"OTROS REQUISITOS" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(id) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
            //004 - "CARPETAS DE INVESTIGACIÓN INICIADAS 
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::whereraw('YEAR(created_at)='.$anio)->whereraw('MONTH(created_at)='.$mes)
                    ->where('DELEGACION','=',$del)
                    ->where(function($query){
                      $query->whereNotIn('ESTATUS_CARPETA',[1,2])->orWhereNull('ESTATUS_CARPETA');                      
                    })
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"CARPETAS DE INVESTIGACIÓN INICIADAS " as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(id) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }    
            //005 - "VÍCTIMAS - SEXO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_victimas as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.SEXO_VICTIMA','=','a.id')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_VICTIMA',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',17)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VÍCTIMAS" as INDICADOR'),
                      db::raw('"SEXO" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }              
            //006 - "OTRO TIPO DE VÍCTIMAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftJoin('prode_victimas  as b', function($join) use($anio,$mes)
                    {
                      $join->on('prode_datosgenerales.id','=','b.idExpediente')
                      ->wherenull('b.deleted_at')
                      ->where('TIPO_VICTIMA','!=',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)                        
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"OTRO TIPO DE VÍCTIMAS" as INDICADOR'),
                      db::raw('"" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(b.id) as UNIDAD')
                    );
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                             
            //007 si- "CARPETAS DE INVESTIGACIÓN INICIADAS  TIPO DETENIDO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $siD = datos_expediente\de_imputados::leftJoin('prode_datosgenerales as c','prode_imputados.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('YEAR(c.created_at)='.$anio)
                      ->WhereRaw('MONTH(c.created_at)='.$mes)
                    ->select('prode_imputados.idExpediente',DB::raw("'SI' as DETENIDO"))
                    ->groupby('prode_imputados.idExpediente')
                    ->havingRaw('SUM(CASE WHEN DETENIDO_IMPUTADOS<0 THEN 0 ELSE DETENIDO_IMPUTADOS END)=COUNT(DETENIDO_IMPUTADOS)')->get();
                
                    $subsqlSI = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"CARPETAS DE INVESTIGACIÓN INICIADAS" as INDICADOR'),
                        DB::raw('"TIPO DETENIDO" as TIPO_DESAGREGACION'),
                        DB::raw('"DETENIDO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"'.$siD->count().'" as UNIDAD')
                      );
                    $sql = $subsqlSI;
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //007 no- "CARPETAS DE INVESTIGACIÓN INICIADAS  TIPO DETENIDO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  
                  $noD = datos_expediente\de_imputados::leftJoin('prode_datosgenerales as c','prode_imputados.idExpediente','=','c.id')
                      ->Where('c.DELEGACION','=',$del)
                      ->WhereRaw('YEAR(c.created_at)='.$anio)
                      ->WhereRaw('MONTH(c.created_at)='.$mes)
                    ->select('prode_imputados.idExpediente',DB::raw("'SI' as DETENIDO"))
                    ->groupby('prode_imputados.idExpediente')
                    ->havingRaw('SUM(CASE WHEN DETENIDO_IMPUTADOS<0 THEN 0 ELSE DETENIDO_IMPUTADOS END)=0')->get();                  
                    
                    $subsqlNO = DB::query()->select(DB::raw($anio.' as year'),
                        DB::raw($mes.' as month'),
                        DB::raw('"'.$value->Valor.'" as delVal'),
                        DB::raw('"CARPETAS DE INVESTIGACIÓN INICIADAS" as INDICADOR'),
                        DB::raw('"TIPO DETENIDO" as TIPO_DESAGREGACION'),
                        DB::raw('"SIN DETENIDO" as DESAGREGACION_1'),
                        DB::raw('"" as DESAGREGACION_2'),
                        DB::raw('"'.$noD->count().'" as UNIDAD')
                      );

                    $sql =$subsqlNO;
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
            //008 - "ÓRDENES DE APREHENSIÓN - ESTATUS - SOLICITADAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ev_mandamientos as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.TIPO_MANDAMIENTO','=',3)->WhereRaw('IFNULL(SOLICITUD_DE_MANDAMIENTO_JUDICIAL,"")!=""')
                      ->whereNull('pevi.deleted_at');
                    })
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"ÓRDENES DE APREHENSIÓN" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"SOLICITADAS" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(pevi.id) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //009 - "ÓRDENES DE APREHENSIÓN - ESTATUS - ORDENADAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ev_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.TIPO_MANDAMIENTO','=',3)->WhereRaw('IFNULL(FECHA_MANDAMIENTO,"")!=""')
                      ->whereNull('pevi.deleted_at');
                    })
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"ÓRDENES DE APREHENSIÓN" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"ORDENADAS" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(pevi.id) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //010 - "ÓRDENES DE APREHENSIÓN - ESTATUS - CUMPLIMENTADAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ev_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.TIPO_MANDAMIENTO','=',3)->Where('ESTATUS_MANDAMIENTO','=',2)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"ÓRDENES DE APREHENSIÓN" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"CUMPLIMENTADAS" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(pevi.id) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                                                                   
            //011 - "ÓRDENES DE DETENCIÓN CASO URGENTE - ESTATUS - EMITIDAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ev_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.TIPO_MANDAMIENTO','=',3)->Where('CASO_URGENTE_ESTATUS','=',2)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"ÓRDENES DE DETENCIÓN CASO URGENTE" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"EMITIDAS" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(pevi.id) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //012 - "ÓRDENES DE DETENCIÓN CASO URGENTE - ESTATUS - CUMPLIMENTADAS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ev_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.TIPO_MANDAMIENTO','=',3)->Where('CASO_URGENTE_ESTATUS','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"ÓRDENES DE DETENCIÓN CASO URGENTE" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"CUMPLIMENTADAS" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(pevi.id) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //013 - "DETENIDOS  TIPO DETENCIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_imputados as b', function($join) use($anio,$mes)
                    {
                      $join->on('b.TIPO_DETENCION','=','a.id')
                      ->wherenull('b.deleted_at')
                      // ->where('TIPO_IMPUTADO',1)
                      ->whereraw('YEAR(b.created_at)='.$anio)
                      ->whereraw('MONTH(b.created_at)='.$mes);                        
                    })
                    ->leftjoin('prode_datosgenerales as e', function($join) use($del)
                    {
                      $join->on('e.id','=','b.idExpediente')
                      ->where('e.DELEGACION','=',$del);
                    })
                    ->where('a.idtiporespuesta','=',23)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"DETENIDOS" as INDICADOR'),
                      db::raw('"TIPO DETENCIÓN" as TIPO_DESAGREGACION'),
                      'a.valor as DESAGREGACION_1',
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(e.id) as UNIDAD')
                    )
                    ->groupby('a.id');                   
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //014 - "CARPETAS DE INVESTIGACIÓN INICIADAS - TIPO DETERMINACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = DB::table('catrespuestas as a')
                    ->leftJoin('prode_datosgenerales as b', function($join) use($del,$anio,$mes)
                    {
                      $join->on('b.SENTIDO_DETERMINACION','=','a.id')
                      ->Where('b.DELEGACION','=',$del)
                      ->WhereRaw('YEAR(b.created_at)='.$anio)
                      ->WhereRaw('MONTH(b.created_at)='.$mes);
                    })
                    ->Where('a.idTipoRespuesta','=',58)
                    ->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"CARPETAS DE INVESTIGACIÓN INICIADAS" as INDICADOR'),
                      DB::raw('"TIPO DETERMINACIÓN" as TIPO_DESAGREGACION'),
                      'a.Valor as DESAGREGACION_1',
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('count(b.id) as UNIDAD')
                    )
                    ->groupby('a.id');    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }   
            //015 - "CARPETAS DE INVESTIGACIÓN INICIADAS - TRÁMITE ETAPA DE INVESTIGACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::whereraw('YEAR(created_at)='.$anio)->whereraw('MONTH(created_at)='.$mes)
                    ->where('DELEGACION','=',$del)->where('ESTATUS_CARPETA','=',2)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"CARPETAS DE INVESTIGACIÓN INICIADAS " as INDICADOR'),
                      db::raw('"TRÁMITE ETAPA DE INVESTIGACIÓN" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(id) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //016 - " CARPETAS DE INVESTIGACIÓN INICIADAS - VINCULADAS A PROCESO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('" CARPETAS DE INVESTIGACIÓN INICIADAS" as INDICADOR'),
                      db::raw('"VINCULADAS A PROCESO" as TIPO_DESAGREGACION'),
                      db::raw('"" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(pevi.id) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //017 - " CARPETAS DE INVESTIGACIÓN INICIADAS -  ESTATUS - TRÁMITE MASC ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $rangos=["SIN ACUERDO", "CON ACUERDO", "MEDIACIÓN", "CONCILIACIÓN", "JUNTA RESTAURATIVA"];
                  foreach ($rangos as $keyR => $valueR) {                      
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"CARPETAS DE INVESTIGACIÓN INICIADAS" as INDICADOR'),
                      DB::raw('"ESTATUS" as TIPO_DESAGREGACION'),                      
                      DB::raw('"TRÁMITE MASC" as DESAGREGACION_1'),
                      DB::raw('"'.$valueR.'" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                  }
                }
              }
            //018 - "  VINCULACIONES A PROCESO - ESTATUS - EN TRÁMITE JUEZ DE CONTROL
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"EN TRÁMITE JUEZ DE CONTROL" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(pevi.id) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //019 - "  VINCULACIONES A PROCESO - ESTATUS - CRITERIO DE OPORTUNIDAD
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)->where('SENTIDO_DETERMINACION',5)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"CRITERIO DE OPORTUNIDAD" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(pevi.id) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //020 - "  VINCULACIONES A PROCESO - ESTATUS - EN TRÁMITE - SUSPENSIÓN CONDICIONAL DEL PROCESO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_salidasalternas as psa', function($join)
                    {
                      $join->on('psa.idExpediente','=','prode_datosgenerales.id')->on('psa.idImputado','=','pevi.idImputado')
                      ->whereNull('psa.deleted_at');
                    })
                    ->leftjoin('procp_sa_suspensiones as psas', function($join)
                    {
                      $join->on('psas.id_cp_salidasalternas','=','psa.id')
                      ->whereNull('psas.deleted_at');
                    })                    
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"EN TRÁMITE" as DESAGREGACION_1'),
                      db::raw('"SUSPENSIÓN CONDICIONAL DEL PROCESO" as DESAGREGACION_2'),
                      db::raw('COUNT(NULLIF(psas.FECHA_SUSPENSION,"")) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //021 - "  VINCULACIONES A PROCESO - ESTATUS - CUMPLIDA - SUSPENSIÓN CONDICIONAL DEL PROCESO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_salidasalternas as psa', function($join)
                    {
                      $join->on('psa.idExpediente','=','prode_datosgenerales.id')->on('psa.idImputado','=','pevi.idImputado')
                      ->whereNull('psa.deleted_at');
                    })
                    ->leftjoin('procp_sa_suspensiones as psas', function($join)
                    {
                      $join->on('psas.id_cp_salidasalternas','=','psa.id')
                      ->whereNull('psas.deleted_at');
                    })                    
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"CUMPLIDA" as DESAGREGACION_1'),
                      db::raw('"SUSPENSIÓN CONDICIONAL DEL PROCESO" as DESAGREGACION_2'),
                      db::raw('COUNT(NULLIF(psas.FECHA_CUMPL,"")) as UNIDAD'));
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //022 - "  VINCULACIONES A PROCESO - ESTATUS - RESUELTOS - OTROS SOBRESEIMIENTOS
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_ss_imputados as psa', function($join)
                    {
                      $join->on('psa.idExpediente','=','prode_datosgenerales.id')->on('psa.idImputado','=','pevi.idImputado')
                      ->whereNull('psa.deleted_at');
                    })                  
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"CUMPLIDA" as DESAGREGACION_1'),
                      db::raw('"OTROS SOBRESEIMIENTOS" as DESAGREGACION_2'),
                      db::raw('COUNT(NULLIF(psa.FECHA_SOBRESEIMIENTO,"")) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
            //023 - "  VINCULACIONES A PROCESO - ESTATUS - TRÁMITE - PROCEDIMIENTO ABREVIADO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_procedimientoabreviado as psa', function($join)
                    {
                      $join->on('psa.idExpediente','=','prode_datosgenerales.id')->on('psa.idImputado','=','pevi.idImputado')
                      ->where('psa.NO_ADMISION_DEL_ABREVIADO','=',1)->where('psa.ESTATUS_ABREVIADO','=',1)
                      ->whereNull('psa.deleted_at');
                    })                  
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"TRÁMITE" as DESAGREGACION_1'),
                      db::raw('"PROCEDIMIENTO ABREVIADO" as DESAGREGACION_2'),
                      db::raw('COUNT(psa.id) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  
 
            //024 - "  VINCULACIONES A PROCESO - ESTATUS - RESUELTOS - PROCEDIMIENTO ABREVIADO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_procedimientoabreviado as psa', function($join)
                    {
                      $join->on('psa.idExpediente','=','prode_datosgenerales.id')->on('psa.idImputado','=','pevi.idImputado')
                      ->where('psa.NO_ADMISION_DEL_ABREVIADO','=',1)->where('psa.ESTATUS_ABREVIADO','=',2)
                      ->whereNull('psa.deleted_at');
                    })                  
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"RESUELTOS" as DESAGREGACION_1'),
                      db::raw('"PROCEDIMIENTO ABREVIADO" as DESAGREGACION_2'),
                      db::raw('COUNT(psa.id) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }  

            //025 - "  VINCULACIONES A PROCESO - ESTATUS - EN TRÁMITE - TRIBUNAL ENJUICIAMIENTO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_etapaintermedia  as psa', function($join)
                    {
                      $join->on('psa.idExpediente','=','prode_datosgenerales.id')
                      ->where('psa.JUICIO_ORAL','=',1)
                      ->whereNull('psa.deleted_at');
                    })                  
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"EN TRÁMITE" as DESAGREGACION_1'),
                      db::raw('"TRIBUNAL ENJUICIAMIENTO" as DESAGREGACION_2'),
                      db::raw('COUNT(psa.id) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //026 - "  VINCULACIONES A PROCESO - ESTATUS - RESUELTOS - JUICIO ORAL
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_jo_imputados as psa', function($join)
                    {
                      $join->on('psa.idExpediente','=','prode_datosgenerales.id')->on('psa.idImputado','=','pevi.idImputado')
                      ->whereIn('psa.TIPO_SENTENCIA',[1,2])
                      ->whereNull('psa.deleted_at');
                    })                  
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"RESUELTOS" as DESAGREGACION_1'),
                      db::raw('"JUICIO ORAL" as DESAGREGACION_2'),
                      db::raw('COUNT(psa.id) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
            //027 - "  VINCULACIONES A PROCESO - ESTATUS - TRÁMITE MASC - SIN ACUERDO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_dg_imputados as psa', function($join)
                    {
                      $join->on('psa.id','=','pevi.idImputado')
                      ->where('psa.MASC','=',2)
                      ->whereNull('psa.deleted_at');
                    })         
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"TRÁMITE MASC" as DESAGREGACION_1'),
                      db::raw('"SIN ACUERDO" as DESAGREGACION_2'),
                      db::raw('COUNT(psa.id) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //028 - "  VINCULACIONES A PROCESO - ESTATUS - TRÁMITE MASC - CON ACUERDO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_dg_imputados as psa', function($join)
                    {
                      $join->on('psa.id','=','pevi.idImputado')
                      ->where('psa.MASC','=',1)
                      ->whereNull('psa.deleted_at');
                    })         
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"TRÁMITE MASC" as DESAGREGACION_1'),
                      db::raw('"CON ACUERDO" as DESAGREGACION_2'),
                      db::raw('COUNT(psa.id) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //029 - "  VINCULACIONES A PROCESO - ESTATUS - TRÁMITE MASC - MEDIACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_dg_imputados as psa', function($join)
                    {
                      $join->on('psa.id','=','pevi.idImputado')
                      ->where('psa.MASC','=',1)->where('psa.TIPO_MASC','=',1)
                      ->whereNull('psa.deleted_at');
                    })         
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"TRÁMITE MASC" as DESAGREGACION_1'),
                      db::raw('"MEDIACIÓN" as DESAGREGACION_2'),
                      db::raw('COUNT(psa.id) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //030 - "  VINCULACIONES A PROCESO - ESTATUS - TRÁMITE MASC - CONCILIACIÓN
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_dg_imputados as psa', function($join)
                    {
                      $join->on('psa.id','=','pevi.idImputado')
                      ->where('psa.MASC','=',1)->where('psa.TIPO_MASC','=',2)
                      ->whereNull('psa.deleted_at');
                    })         
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"TRÁMITE MASC" as DESAGREGACION_1'),
                      db::raw('"CONCILIACIÓN" as DESAGREGACION_2'),
                      db::raw('COUNT(psa.id) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }    
            //031 - "  VINCULACIONES A PROCESO - ESTATUS - TRÁMITE MASC - JUSTICIA RESTAURATIVA
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_ai_imputados as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.RESOLUCION','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_dg_imputados as psa', function($join)
                    {
                      $join->on('psa.id','=','pevi.idImputado')
                      ->where('psa.MASC','=',1)->where('psa.TIPO_MASC','=',3)
                      ->whereNull('psa.deleted_at');
                    })         
                    ->whereraw('YEAR(prode_datosgenerales.created_at)='.$anio)->whereraw('MONTH(prode_datosgenerales.created_at)='.$mes)
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"VINCULACIONES A PROCESO" as INDICADOR'),
                      db::raw('"ESTATUS" as TIPO_DESAGREGACION'),
                      db::raw('"TRÁMITE MASC" as DESAGREGACION_1'),
                      db::raw('"JUSTICIA RESTAURATIVA" as DESAGREGACION_2'),
                      db::raw('COUNT(psa.id) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }
            //032 - "  IMPUTADOS EN PROCEDIMIENTO ABREVIADO - TIPO DE SENTENCIA - CONDENATORIA
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_procedimientoabreviado as pevi', function($join) use($anio,$mes)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.NO_ADMISION_DEL_ABREVIADO','=',1)
                      ->whereraw('YEAR(pevi.created_at)='.$anio)
                      ->whereraw('MONTH(pevi.created_at)='.$mes)
                      ->whereNull('pevi.deleted_at');
                    })                        
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"IMPUTADOS EN PROCEDIMIENTO ABREVIADO" as INDICADOR'),
                      db::raw('"TIPO DE SENTENCIA" as TIPO_DESAGREGACION'),
                      db::raw('"CONDENATORIA" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(pevi.id) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }              
            //033 - " IMPUTADOS EN PROCEDIMIENTO ABREVIADO -  TIPO DE SENTENCIA - ABSOLUTORIA ----EN BLANCO
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {                   
                    $sql = DB::query()->select(DB::raw($anio.' as year'),
                      DB::raw($mes.' as month'),
                      DB::raw('"'.$value->Valor.'" as delVal'),
                      DB::raw('"IMPUTADOS EN PROCEDIMIENTO ABREVIADO" as INDICADOR'),
                      DB::raw('"TIPO DE SENTENCIA" as TIPO_DESAGREGACION'),                      
                      DB::raw('"ABSOLUTORIA" as DESAGREGACION_1'),
                      DB::raw('"" as DESAGREGACION_2'),
                      DB::raw('"0" as UNIDAD')
                    );                    

                    if($c < 1){
                        $salida1 = $sql;
                    }else{
                        $salida1->union($sql);
                    }
                    $c++;      
                }
              }
            //034 - "  IMPUTADOS EN JUICIO ORAL -TIPO DE SENTENCIA - CONDENATORIA
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_etapaintermedia as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.JUICIO_ORAL','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_jo_imputados as pjo', function($join) use($anio,$mes)
                    {
                      $join->on('pjo.idExpediente','=','prode_datosgenerales.id')
                      ->where('pjo.TIPO_SENTENCIA','=',2)
                      ->whereraw('YEAR(pjo.created_at)='.$anio)->whereraw('MONTH(pjo.created_at)='.$mes)
                      ->whereNull('pjo.deleted_at');
                    })                    
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"IMPUTADOS EN JUICIO ORAL" as INDICADOR'),
                      db::raw('"TIPO DE SENTENCIA" as TIPO_DESAGREGACION'),
                      db::raw('"CONDENATORIA" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(pjo.id) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }                
            //035 - "  IMPUTADOS EN JUICIO ORAL -TIPO DE SENTENCIA - ABSOLUTORIA
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('procp_etapaintermedia as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')
                      ->where('pevi.JUICIO_ORAL','=',1)
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_jo_imputados as pjo', function($join) use($anio,$mes)
                    {
                      $join->on('pjo.idExpediente','=','prode_datosgenerales.id')
                      ->where('pjo.TIPO_SENTENCIA','=',1)
                      ->whereraw('YEAR(pjo.created_at)='.$anio)->whereraw('MONTH(pjo.created_at)='.$mes)
                      ->whereNull('pjo.deleted_at');
                    })                    
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"IMPUTADOS EN JUICIO ORAL" as INDICADOR'),
                      db::raw('"TIPO DE SENTENCIA" as TIPO_DESAGREGACION'),
                      db::raw('"ABSOLUTORIA" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(pjo.id) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //036 - "  IMPUTADOS CON MEDIDA CAUTELAR -TIPO DE MEDIDA CAUTELAR - PRISIÓN PREVENTIVA OFICIOSA
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('prode_imputados as pdi', function($join) use($anio,$mes)
                    {
                      $join->on('pdi.idExpediente','=','prode_datosgenerales.id')
                      ->whereraw('YEAR(pdi.created_at)='.$anio)->whereraw('MONTH(pdi.created_at)='.$mes)
                      ->whereNull('pdi.deleted_at');
                    })
                    ->leftjoin('procp_dg_imputados as pdgi', function($join)
                    {
                      $join->on('pdgi.idImputado','=','pdi.id')
                      ->whereNull('pdgi.deleted_at');
                    })                  
                    ->leftjoin('procp_medidascautelares as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')->on('pevi.idImputado','=','pdgi.id')
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_mc_medidas as pmd', function($join) 
                    {
                      $join->on('pmd.id_cp_medidascautelares','=','pevi.id')
                      ->where('pmd.TIPO_MEDIDAS_CAUTELARES','=',15)                      
                      ->whereNull('pmd.deleted_at');
                    })                    
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"IMPUTADOS CON MEDIDA CAUTELAR" as INDICADOR'),
                      db::raw('"TIPO DE MEDIDA CAUTELAR" as TIPO_DESAGREGACION'),
                      db::raw('"PRISIÓN PREVENTIVA OFICIOSA" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(DISTINCT(pmd.id_cp_medidascautelares)) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //037 - "  IMPUTADOS CON MEDIDA CAUTELAR -TIPO DE MEDIDA CAUTELAR - PRISIÓN PREVENTIVA NO OFICIOSA
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('prode_imputados as pdi', function($join) use($anio,$mes)
                    {
                      $join->on('pdi.idExpediente','=','prode_datosgenerales.id')
                      ->whereraw('YEAR(pdi.created_at)='.$anio)->whereraw('MONTH(pdi.created_at)='.$mes)
                      ->whereNull('pdi.deleted_at');
                    })
                    ->leftjoin('procp_dg_imputados as pdgi', function($join)
                    {
                      $join->on('pdgi.idImputado','=','pdi.id')
                      ->whereNull('pdgi.deleted_at');
                    })                  
                    ->leftjoin('procp_medidascautelares as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')->on('pevi.idImputado','=','pdgi.id')
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_mc_medidas as pmd', function($join) 
                    {
                      $join->on('pmd.id_cp_medidascautelares','=','pevi.id')
                      ->where('pmd.TIPO_MEDIDAS_CAUTELARES','=',14)                      
                      ->whereNull('pmd.deleted_at');
                    })                    
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"IMPUTADOS CON MEDIDA CAUTELAR" as INDICADOR'),
                      db::raw('"TIPO DE MEDIDA CAUTELAR" as TIPO_DESAGREGACION'),
                      db::raw('"PRISIÓN PREVENTIVA NO OFICIOSA" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(DISTINCT(pmd.id_cp_medidascautelares)) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              }               
            //038 - "  IMPUTADOS CON MEDIDA CAUTELAR -TIPO DE MEDIDA CAUTELAR - OTRA MEDIDA CAUTELAR
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('prode_imputados as pdi', function($join) use($anio,$mes)
                    {
                      $join->on('pdi.idExpediente','=','prode_datosgenerales.id')
                      ->whereraw('YEAR(pdi.created_at)='.$anio)->whereraw('MONTH(pdi.created_at)='.$mes)
                      ->whereNull('pdi.deleted_at');
                    })
                    ->leftjoin('procp_dg_imputados as pdgi', function($join)
                    {
                      $join->on('pdgi.idImputado','=','pdi.id')
                      ->whereNull('pdgi.deleted_at');
                    })                  
                    ->leftjoin('procp_medidascautelares as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')->on('pevi.idImputado','=','pdgi.id')
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_mc_medidas as pmd', function($join) 
                    {
                      $join->on('pmd.id_cp_medidascautelares','=','pevi.id')
                      ->whereNotIn('pmd.TIPO_MEDIDAS_CAUTELARES',[14,15])                      
                      ->whereNull('pmd.deleted_at');
                    })                    
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"IMPUTADOS CON MEDIDA CAUTELAR" as INDICADOR'),
                      db::raw('"TIPO DE MEDIDA CAUTELAR" as TIPO_DESAGREGACION'),
                      db::raw('"OTRA MEDIDA CAUTELAR" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(DISTINCT(pmd.id_cp_medidascautelares)) as UNIDAD'));
                    
                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
            //040 - "  IMPUTADOS CON MEDIDA CAUTELAR -TIPO DE MEDIDA CAUTELAR - SIN MEDIDA CAUTELAR


              // $sqlImp = datos_expediente\de_datosgenerales::leftjoin('prode_imputados as pdi', function($join) use($anio,$mes)
              //     {
              //       $join->on('pdi.idExpediente','=','prode_datosgenerales.id')
              //       ->whereraw('YEAR(pdi.created_at)='.$anio)->whereraw('MONTH(pdi.created_at)>0')
              //       ->whereNull('pdi.deleted_at');
              //     })
              //     ->leftjoin('procp_dg_imputados as pdgi', function($join)
              //     {
              //       $join->on('pdgi.idImputado','=','pdi.id')
              //       ->whereNull('pdgi.deleted_at');
              //     })                  
              //     ->leftjoin('procp_medidascautelares as pevi', function($join)
              //     {
              //       $join->on('pevi.idExpediente','=','prode_datosgenerales.id')->on('pevi.idImputado','=','pdgi.id')
              //       ->whereNull('pevi.deleted_at');
              //     })
              //     ->leftjoin('procp_mc_medidas as pmd', function($join) 
              //     {
              //       $join->on('pmd.id_cp_medidascautelares','=','pevi.id')                                        
              //       ->whereNull('pmd.deleted_at');
              //     })                    
              //     ->whereRaw('prode_datosgenerales.DELEGACION>0')->where('pmd.TIPO_MEDIDAS_CAUTELARES','>',0)  
              //     ->select(db::raw('DISTINCT(pdi.id) as id'))->pluck('id');  
              //    $ids=$sqlImp->toArray();
              foreach ($delegaciones as $key => $value) {
                $del=$value->id;
                for ($mes = 1; $mes <= 12; $mes++) {
                  $sql = datos_expediente\de_datosgenerales::leftjoin('prode_imputados as pdi', function($join) use($anio,$mes)
                    {
                      $join->on('pdi.idExpediente','=','prode_datosgenerales.id')
                      ->whereraw('YEAR(pdi.created_at)='.$anio)->whereraw('MONTH(pdi.created_at)='.$mes)
                      ->whereNull('pdi.deleted_at');
                    })
                    ->leftjoin('procp_dg_imputados as pdgi', function($join)
                    {
                      $join->on('pdgi.idImputado','=','pdi.id')
                      ->whereNull('pdgi.deleted_at');
                    })                  
                    ->leftjoin('procp_medidascautelares as pevi', function($join)
                    {
                      $join->on('pevi.idExpediente','=','prode_datosgenerales.id')->on('pevi.idImputado','=','pdgi.id')
                      ->whereNull('pevi.deleted_at');
                    })
                    ->leftjoin('procp_mc_medidas as pmd', function($join) 
                    {
                      $join->on('pmd.id_cp_medidascautelares','=','pevi.id')
                      ->where('pmd.TIPO_MEDIDAS_CAUTELARES','=',19)                      
                      ->whereNull('pmd.deleted_at');
                    })  
                    ->where('prode_datosgenerales.DELEGACION','=',$del)
                    ->select(db::raw($anio.' as year'),
                      db::raw($mes.' as month'),
                      db::raw('"'.$value->Valor.'" as delVal'),
                      db::raw('"IMPUTADOS CON MEDIDA CAUTELAR" as INDICADOR'),
                      db::raw('"TIPO DE MEDIDA CAUTELAR" as TIPO_DESAGREGACION'),
                      db::raw('"SIN MEDIDA CAUTELAR" as DESAGREGACION_1'),
                      db::raw('"" as DESAGREGACION_2'),
                      db::raw('COUNT(pdi.id) as UNIDAD'));
                                      

                  if($c < 1){
                      $salida1 = $sql;
                  }else{
                      $salida1->union($sql);
                  }
                  $c++;                  
                }
              } 
           
          break;        
        }     

        return $salida1->orderby('month')->orderby('delVal')->orderby('INDICADOR')
        ->orderby('TIPO_DESAGREGACION')->orderby('DESAGREGACION_1')->orderby('DESAGREGACION_2')->take(200000);
    }
}