<?php

namespace App\Exports;

use App\Models\datos_expediente;
use App\Models\causas_penales;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
//use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class datosExpediente implements FromQuery,WithHeadings, WithTitle
{       
    //public function __construct(string $dateS,string $dateF,string $Titulo)
    public function __construct(array $IDs,string $Titulo)
    {
        // $this->dateS = $dateS;
        // $this->dateF = $dateF;
        $this->IDs = $IDs;
        $this->Title = $Titulo;
        
        return $this;
    }
    public function headings(): array
    {
     switch ($this->Title) {
      #region Descarga Masica
        case 'base_carpetas':
          return [
           'ID', 'IDEXPEDIENTE', 'DELEGACION', 'MUNICIPIO', 'UNIDAD_ATENCION', 'FECHA_INICIO_CARPETA', 'HORA_APERTURA_CARPETA', 
           'NUC_COMPLETA', 'NUC', 'NO_EXPEDIENTE', 'ESTATUS_CARPETA', 'AGENTE_ID', 'NOMBRE_FISCALIA', 'NOMBRE_AGENTE_MP', 
           'MP_NOMBRE', 'MP_NUMERO', 'TIPO_MP', 'TIPO_FISCALIA', 'UBICACION_MP',
           'FECHA_HECHOS', 'HORA_HECHOS', 'ENTIDAD_HECHOS', 'MUNICIPIO_HECHOS', 'COLONIA_HECHOS', 'CALLE_HECHOS', 'CP', 
           'REF_1', 'REF_2', 'RECIBIDA_POR','MEDIO_RECEPCION', 'UNIDAD_QUE_RECIBE', //'¿ES QUERELLA?',
            'AUTORIDAD_QUE_RECIBE', 'HORA_DENUNCIA', 
           '¿CON O SIN DETENIDO?', 'ASEGURAMIENTO', 'TIPO_DE_BIEN', 'OPORTUNIDAD', 'ETAPA_PROCESAL', 'MEDIO_DE_CONOCIMIENTO', 
           'FECHA_DENUNCIA', 'REACTIVACION', 'DESCRIPCION', 'OBSERVACIONES', 'FECHA_DETERMINACION', 'SENTIDO_DETERMINACION',
           'TIPO_DETERMINACION','TIPO_ACCION_PENAL','ARCHIVO_TEMPORAL','MOTIVO_REACTIVACION' ,
           'FECHACAPTURA', //'CREATED_AT', 'UPDATED_AT', 'DELETED_AT'
          ];
        break;
        case 'base_objetos':
        return [
         'ID', 'IDEXPEDIENTE','NUC_COMPLETA','OBJETO', 'DESCRIPCION', 'CANTIDAD','VALOR','ESTATUS','FECHACAPTURA'
         ];
        break;
        case 'base_narcoticos':
        return [
        'ID', 'IDEXPEDIENTE','NUC_COMPLETA','TIPO', 'CANTIDAD', 'GRAMAJE','FECHACAPTURA'
        ];
        break;
        case 'base_vehiculos':
        return [
        'ID', 'IDEXPEDIENTE','NUC_COMPLETA','ESTATUS', ' FECHA_ASEGURADO', 'FECHA_DEVUELTO', 'FECHA_ROBADO', 'MARCA','MODELO','COLOR','TIPO','PLACA','NUMERO_SERIE','ESTADO_PLACAS','LUGAR_DONDE_SE_ENCONTRO_EL_VEHICULO','FECHACAPTURA'
        ];
        break;
        case 'base_victimas':
          return [
            'ID', 'IDEXPEDIENTE', 'NUC_COMPLETA', 'TIPO_VICTIMA', 'INTERPRETE', 'DELITOS_VICTIMA', 'RAZON_SOCIAL', 'REPRESENTANTE_LEGAL', 'TIPO_REPRESENTANTE_LEGAL', 'SECTOR_VICTIMAS', 'TIPO_PERSONA_VICTIMAS', 'NOMBRE_VICTIMA', 'PRIMER_APELLIDO', 'SEGUNDO_APELLIDO_VICTIMAS', 'CURP_VICTIMAS', 'EDAD_HECHOS_VICTIMAS', 'SEXO_VICTIMA', 'SITUACION_CONYUGAL_VICTIMAS', 'NACIONALIDAD', 'SITUACION_MIGRATORIA_VICTIMAS', 'PAIS_NACIMIENTO', 'ENTIDAD_NACIMIENTO_VICTIMAS', 'MUNICIPIO_NACIMIENTO', 'PAIS_RESIDENCIA', 'ENTIDAD_RESIDENCIA_VICTIMAS', 'MUNICIPIO_RESIDENCIA', 'TELEFONO_VICTIMAS', 'TRADUCTOR_VICTIMA', 'DISCAPACIDAD_VICTIMAS', 'TIPO_DISCAPACIDAD_VICTIMAS', 'INTERPRETE_POR_DISCAPACIDAD_VICTIMA', 'POBLACION_CALLE', 'LEER_ESCRIBIR', 'ESCOLARIDAD', 'OCUPACION', 'SE_IDENTIFICA_INDIGENA_VICTIMA', 'POBLACION_INDIGENA_VICTIMA', 'RELACION_IMPUTADO', 'FECHA_NACIMIENTO_VICTIMAS', 'ASESORIA', 'ATEN_MEDICA', 'ATEN_PSICOLOGICA', 'DOMICILIO_VICTIMA', 'HABLA_ESPAÑOL_VICTIMA', 'HABLA_LENG_EXTR_VICTIMA', 'HABLA_LENG_INDIG_VICTIMA', 'NUMERO_DE_ATENCION', 'INGRESO_VICTIMA', 'TIPO_DE_ASESORIA', 'TIPO_LENGUA_EXTRANJERA_VICTIMA', 'LENGUA_VICTIMA', 'VESTIMENTA_VICTIMA', 'VICTIMA_VIOLENCIA', 'FECHACAPTURA', 
            //'CREATED_AT', 'UPDATED_AT', 'DELETED_AT'
          ];        
        break;
        case 'base_imputados':
          return [
            'ID', 'IDEXPEDIENTE', 'NUC_COMPLETA',  'INTERPRETE', 'TIPO_IMPUTADO', 'RAZON_SOCIAL', 'REL_PERS_MORAL', 'SECTOR_IMPUTADOS', 'TIPO_PERSONA_IMPUTADOS', 'DELITOS_IMPUTADO', 'ALIAS_IMPUTADO', 'RELACION_VICTIMA', 'NOMBRE_IMPUTADO', 'PRIMER_APELLIDO', 'SEGUNDO_APELLIDO_IMPUTADOS', 'CURP_IMPUTADOS', 'FECHA_NACIMIENTO_IMPUTADOS', 'EDAD_HECHOS_IMPUTADOS', 'SEXO_IMPUTADO', 'SITUACION_CONYUGAL_IMPUTADOS', 'NACIONALIDAD', 'SITUACION_MIGRATORIA_IMPUTADOS', 'PAIS_NACIMIENTO', 'ENTIDAD_NACIMIENTO_IMPUTADOS', 'MUNICIPIO_NACIMIENTO', 'PAIS_RESIDENCIA', 'ENTIDAD_RESIDENCIA_IMPUTADOS', 'MUNICIPIO_RESIDENCIA', 'TELEFONO_IMPUTADOS', 'TRADUCTOR_IMPUTADO', 'DISCAPACIDAD_IMPUTADOS', 'TIPO_DISCAPACIDAD_IMPUTADOS', 'INTERPRETE_POR_DISCAPACIDAD_IMPUTADO', 'POBLACION_CALLE', 'LEER_ESCRIBIR_IMPUTADOS', 'ESCOLARIDAD_IMPUTADO', 'SE_IDENTIFICA_INDIGENA_IMPUTADO', 'INDIGENA_IMPUTADO', 'DETENIDO_IMPUTADOS', 'ESTADO_IMPUTADO', 'FECHA_DETENCION', 'HORA_DETENCION', 'TIPO_DETENCION', 'ENTIDAD_DETENCION_IMPUTADOS', 'AUTORIDAD_DETENCION_IMPUTADOS', 'FOLIO_RND', 'RAZON_RND', 'EXAMEN_DETENCION_IMPUTADOS', 'LESIONADO', 'ESTADO_PRESENTACION','SITUACION_LIBERTAD', 'ANTECEDENTES', 'DEFENSA', 'DOMICILIO_IMPUTADO', 'GRADO_DE_PARTICIPACION', 'HABLA_ESPAÑOL_IMPUTADO', 'HABLA_LENG_EXTR_IMPUTADO', 'HABLA_LENG_INDIG_IMPUTADO', 'MEDIA_FILIACION_IMPUTADO', 'NOMBRE_DE_GRUPO', 'OCUPACION_IMPUTADO', 'INGRESO_IMPUTADO', 'REPRESENTANTE_LEGAL', 'TIPO_REPRESENTANTE_LEGAL', 'TIPO_DEFENSA', 'TIPO_LENGUA_EXTRANJERA_IMPUTADO', 'LENGUA_IMPUTADO', 'TIPO_MANDAMIENTO', 'IMPUTADO_CONOCIDO', 'FECHACAPTURA', //'CREATED_AT', 'UPDATED_AT', 'DELETED_AT'
          ];        
        break;
        case 'base_delitos':
          return [
            'ID', 'IDEXPEDIENTE', 'NUC_COMPLETA', 'ORDENAMIENTO','DELITO_GENERAL','DELITO_ESPECIFICO', 'ORDENAMIENTO_JURIDICO','DELITO_JUR', 'CONSUMACION', 'MODALIDAD', 'INSTRUMENTO', 'FUERO', 'TIPO_SITIO_OCURRENCIA', 'CALIFICACION', 'COMISION', 'CONTEXTO', 'FORMA_ACCION', 'FECHACAPTURA', 
            //'created_at', 'updated_at', 'deleted_at'
          ];        
        break;
        case 'base_relacion':
          return [
            'ID', 'IDEXPEDIENTE', 'NUC_COMPLETA', 'ID_DELITO', 'DELITO_ESPECIFICO', 'ID_VICTIMA', 'VICTIMA', 'ID_IMPUTADO', 'IMPUTADO',
          ];        
        break;

        case 'base_causasPenales':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID', 'FECHA_CAUSA_PENAL', 'UNIDAD_DE_INVESTIGACION', 'OBSERVACIONES', 'FECHACAPTURA'
          ];        
        break; 
        case 'causas_acumuladas':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID_A', 'CAUSA_PENAL_ID_B'
          ];        
        break;                    
        case 'causas_delitos':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID','IDDELITO','DELITO', 'RECLASIFICACION', 'DELITO_DE_ACUERDO_CON_LEY', 'MOMENTO_RECLAS', 'FECHA_RECLAS', 'USUARIO', 'FECHACAPTURA'
          ];        
        break; 
        case 'causas_victimas':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID','IDVICTIMA','VICTIMA', 'USUARIO', 'FECHACAPTURA'
          ];        
        break;
        case 'causas_medidasProteccion':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID',
            'IDVICTIMA','VICTIMA','TIPO_DE_MEDIDA','TEMPORALIDAD_DE_LA_MEDIDA','MEDIDA_IMPUESTA_POR', 
            'FECHACAPTURA'
          ];
        break;                 
        case 'causas_imputados':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID','IDIMPUTADO','IMPUTADO', '¿CON O SIN DETENIDO?', 'DETENCION_LEGAL_ILEGAL', 'MASC', 'FECHA_DERIVA_MASC', 'FECHA_CUMPL_MAS',
            'TIPO_CUMPLIMIENTO', 'TIPO_MASC', 'AUTORIDAD_DERIVA_MASC','FORMA_PROCESO','SOLICITUD_DE_ORDEN_DE_APREHENSION', 'OA_SIN_EFECTO', 'OA_NEGADA', 'OA_CUMPLIDA', 
            'ORDEN_DE_COMPARECENCIA_GIRADA', 'ORDEN_DE_COMPARECENCIA_NEGADA',
            'FECHA_DETENCION', 'DETENCION_LEGAL', 
            'CASO_URGENTE_FECHA_LIBRAMIENTO', 'CASO_URGENTE_ESTATUS', 'CASO_URGENTE_FECHA_CUMPLIMIENTO',
            'SOLICITUD_DE_MANDAMIENTO_JUDICIAL', 'TIPO_MANDAMIENTO', 'FECHA_LIBERA', 'ESTATUS_MANDAMIENTO', 'FECHA_MANDAMIENTO',
            'AUDIENCIA_DE_GARANTIAS', 'PROMOVIDA_POR', 'RESULTADO_AUDIENCIA_DE_GARANTIAS', 'FECHA_CITA',
            'DECRETO_LEGAL_DETENCION', 'FECHA_CONTROL', 'FORMA_DE_CONDUCCION_DEL_IMPUTADO_A_PROCESO', 
            'FORMULACION','FECHA_FORM',  'OBSERVACIONES', 
            'RESOLUCION', 'FECHA_RESOL', 'DELITO_POR_EL_QUE_SE_VINCULO',//'INV_CON_DETENIDO',   
            'NO_ADMISION_DEL_ABREVIADO', 'CAUSAS_NO_ADM_ABREVIADO','FECHA_PROCEDIMIENTO_ABREVIADO', 'PENA_CONDENATORIA_EN_ABREVIADO',//'ESTATUS_ABREVIADO',
            'FECHA_SOBRESEIMIENTO', 'TIPO_SOBRESEIMIENTO', 'CAUSAS_SOBRESEIMIENTO', 'SOBRESEIMIENTO_OBSERVACIONES', 
            //'FECHA_SUSPENSION', 'CAUSA_PROCESO', 'REAPERTURA_PROCESO', 'FECHA_DE_REANUDACION',
            'FECHA_SENTENCIA', 'LIBERTAD_CONDICIONAL', 'TIPO_SENTENCIA', 'OBSERVACIONES_ABSOLUTORIA', 'SENTENCIA_CONDENATORIA', 'FIRME', 'TIEMPO_EN_PRISIOM',
             'USUARIO', 'FECHACAPTURA'
          ];        
        break;
        case 'causas_relacion_imputados':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID','IDIMPUTADO','IMPUTADO','IDDELITO','DELITO','IDVICTIMA','VICTIMA', 'USUARIO', 'FECHACAPTURA'
          ];
        break;
        case 'causas_actosInvestigacion':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID','FECHA_ACTOS_DE_INV','TIPO_CONTROL_ACTOS_DE_INV','TIPO_ACTOS_DE_INV','OBSERVACIONES_ACTOS_DE_INV', 'FECHACAPTURA'
          ];
        break;     
        case 'causas_actosConSinControl':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID','IDIMPUTADO','TIPO_ACTOS_CONSIN','CON_SIN_CONTROL', 'FECHACAPTURA'
          ];
        break;
        case 'causas_audienciaInicial':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID',
            'AUDIENCIA_INICIAL', 'FECHA_AUDIENCIA_INICIAL', 'MOTIVO_NOAUD', 'NOMBRE_JUEZ_CONTROL', 'FECHA_INICIO_INVESTIGACION', 'FECHA_CIERRE',
            'FECHACAPTURA'
          ];
        break; 
        case 'causas_prorrogas':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID',
            'QUIEN_SOLICITO_LA_PRORROGA','TEMPORALIDAD_PRORROGA',
            'FECHACAPTURA'
          ];
        break; 
        case 'causas_medidasCautelares':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID','IDIMPUTADO','IMPUTADO',
            'TIPO_MEDIDAS_CAUTELARES', 'TEMPORALIDAD_MEDIDA_DIAS', 'TEMPORALIDAD_MEDIDA_MESES', 'TEMPORALIDAD_MEDIDA_AÑOS', 'MEDIDAS_OBSERVACIONES',
            'FECHACAPTURA'
          ];
        break;                 
        case 'causas_acuerdosReparatorios':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID','IDIMPUTADO','IMPUTADO',
            'ACUERDO_REPARATORIO', 'FECHA_CUMPLIMIENTO', 'FECHA_ACUERDOS_REPARATORIOS', 'ACUERDOS_REPARATORIOS', 'ACUERDOS_REPARATORIOS_OBSERVACIONES', 
            'MONTO_REP_DAÑO', 'REPARACION_DEL_DAÑO', 'TEMPORALIDAD',
            'FECHACAPTURA'
          ];
        break; 
        case 'causas_susCondicionales':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID','IDIMPUTADO','IMPUTADO',
            'FECHA_SUSPENSION', 'TIPO_SUSPENSION', 'SUSPENSION_OBSERVACIONES', 'FECHA_CUMPL', 'REVOCACION_SUSPENSION', 'MOTIVO_REVOCACION', 
            'REAPERTURA', 'FECHA_REAPERTURA', 
            'FECHACAPTURA'
          ];
        break; 
        case 'causas_suspension':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID',
            'FECHA_SUSPENSION', 'CAUSA_PROCESO', 'REAPERTURA_PROCESO', 'FECHA_DE_REANUDACION','FECHACAPTURA'
          ];        
        case 'causas_etapaIntermedia':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID',
            'ACUSACION', 'FECHA_ESCRITO_ACUS', 'AUDIENCIA_INTERMEDIA', 'FECHA_AUDIENCIA_INTERMEDIA', 'SUSPENSION_DE_AUDIENCIA', 'CAUSAS_SUSPENSION_INTERMEDIA', 'FECHA_DE_REANUDACION_INTERMEDIA', 'MEDIO_PRUEBA', 'ACUERDOS_PROP', 'AUTO_DE_APERTURA_JUICIO_ORAL', 'FECHA_AUTO_DE_APERTURA', 'FECHA_AUDIENCIA_JUICIO',
            'FECHACAPTURA'
          ];
        break; 
        case 'causas_mediosPruebas':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID',
            'MEDIOS_PRUEBAS','PRESENTADOS_EXCLUIDOS',//'ACUERDOS_REPARATORIOS',
             'FECHACAPTURA'
          ];
        break; 
        case 'causas_suspensionJuicio':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID',
            'FECHA_SUSPENSION','CAUSAS_SUSPENSION','REANUDACION_JUICIO',            
             'FECHACAPTURA'
          ];
        break; 
        case 'causas_pruebas':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID',
            'TIPOS_DE_PRUEBAS','ACTOR_PRUEBAS','FECHA_PRUEBAS','CANTIDAD',            
             'FECHACAPTURA'
          ];
        break; 
        case 'causas_recursos':
          return [
            'ID', 'IDEXPEDIENTE','NUC_COMPLETA', 'CAUSA_PENAL_ID','IDIMPUTADO','IMPUTADO',
            'FECHA_RECURSO','TIPO_DE_RECURSO','RESOLUCION_DEL_RECURSO',
             'FECHACAPTURA'
          ];
        break;
      #endregion
                                                        
     }
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->Title;
    }

    public function query()
    {   $sql=datos_expediente\de_datosgenerales::query()->take(1);
      switch ($this->Title) {
       #region Datos Expediente
        case 'base_carpetas':
          $sql=datos_expediente\de_datosgenerales::leftJoin('catdelegaciones as catD','catD.id','=','prode_datosgenerales.DELEGACION')
            ->leftJoin('catmunicipios_inegi as catM','catM.id','=','prode_datosgenerales.MUNICIPIO')
            ->leftJoin('catuats','catuats.id','=','prode_datosgenerales.UNIDAD_ATENCION')
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('prode_datosgenerales.ESTATUS_CARPETA','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',44);
            })
            ->leftJoin('catentidadesfederativas_inegi as catEFH','catEFH.id','=','prode_datosgenerales.ENTIDAD_HECHOS')
            ->leftJoin('catmunicipios_inegi as catMH','catMH.id','=','prode_datosgenerales.MUNICIPIO_HECHOS')
            //->leftJoin('catcolonias as catCH','catCH.id','=','prode_datosgenerales.COLONIA_HECHOS')
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('prode_datosgenerales.RECIBIDA_POR','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',12);
            }) 
            ->leftJoin('catrespuestas as cr3', function($join)
            {
              $join->on('prode_datosgenerales.MEDIO_RECEPCION','=','cr3.id')
              ->Where('cr3.idTipoRespuesta','=',90);
            })
            // ->leftJoin('catrespuestas as cr3', function($join)
            // {
            //   $join->on('prode_datosgenerales.TIPO_RECEPCION','=','cr3.id')
            //   ->Where('cr3.idTipoRespuesta','=',2);
            // })
            ->leftJoin('catrespuestas as cr4', function($join)
            {
              $join->on('prode_datosgenerales.AUTORIDAD','=','cr4.id')
              ->Where('cr4.idTipoRespuesta','=',41);
            })
            ->leftJoin('catrespuestas as cr5', function($join)
            {
              $join->on('prode_datosgenerales.FORMA_','=','cr5.id')
              ->Where('cr5.idTipoRespuesta','=',50);
            }) 
            ->leftJoin('catrespuestas as cr6', function($join)
            {
              $join->on('prode_datosgenerales.ASEGURAMIENTO','=','cr6.id')
              ->Where('cr6.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr7', function($join)
            {
              $join->on('prode_datosgenerales.OPORTUNIDAD','=','cr7.id')
              ->Where('cr7.idTipoRespuesta','=',63);
            })
            ->leftJoin('catrespuestas as cr8', function($join)
            {
              $join->on('prode_datosgenerales.ETAPA_PROCES','=','cr8.id')
              ->Where('cr8.idTipoRespuesta','=',48);
            })
            ->leftJoin('catrespuestas as cr9', function($join)
            {
              $join->on('prode_datosgenerales.MEDIO_DE_CONOCIMIENTO','=','cr9.id')
              ->Where('cr9.idTipoRespuesta','=',53);
            })          
            ->leftJoin('catrespuestas as cr10', function($join)
            {
              $join->on('prode_datosgenerales.REACTIVACION','=','cr10.id')
              ->Where('cr10.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr11', function($join)
            {
              $join->on('prode_datosgenerales.SENTIDO_DETERMINACION','=','cr11.id')
              ->Where('cr11.idTipoRespuesta','=',58);
            })
            ->leftJoin('catrespuestas as cr12', function($join)
            {
              $join->on('prode_datosgenerales.TIPO_DETERMINACION','=','cr12.id')
              ->Where('cr12.idTipoRespuesta','=',92);
            })
            ->leftJoin('catrespuestas as cr13', function($join)
            {
              $join->on('prode_datosgenerales.TIPO_ACCION_PENAL','=','cr13.id')
              ->Where('cr13.idTipoRespuesta','=',93);
            })
            ->leftJoin('catrespuestas as cr14', function($join)
            {
              $join->on('prode_datosgenerales.ARCHIVO_TEMPORAL','=','cr14.id')
              ->Where('cr14.idTipoRespuesta','=',2);
            })
            ->leftJoin('catrespuestas as cr15', function($join)
            {
              $join->on('prode_datosgenerales.MOTIVO_REACTIVACION','=','cr15.id')
              ->Where('cr15.idTipoRespuesta','=',94);
            })
            ->leftJoin('catrespuestas as cr96', function($join)
            {
              $join->on('prode_datosgenerales.UNIDAD_QUE_RECIBE','=','cr96.id')
              ->Where('cr96.idTipoRespuesta','=',96);
            })            
          //->whereBetween('created_at', [$this->dateS, $this->dateF])
          ->whereIn('prode_datosgenerales.id',$this->IDs)
          ->select('prode_datosgenerales.id', 'idExpediente', 'catD.Valor as DELEGACIONv', 'catM.Valor as MUNICIPIOv', 
            'catuats.Valor as UAT', 'FECHA_INICIO_CARPETA', 
            'HORA_APERTURA_CARPETA', 'NUC_COMPLETA', 'NUC', 'NO_EXPEDIENTE', 'cr1.Valor as ESTATUS_CARPETAtxt', 'AGENTE_ID', 
            'NOMBRE_FISCALIA', 'NOMBRE_AGENTE_MP', 'MP_NOM', 'MP_NUM', 'TIPO_MP', 'TIPO_FISCALIA', 
            'UBICACION_MP', 'FECHA_HECHOS', 'HORA_HECHOS', 'catEFH.Valor as ENTIDAD_HECHOStxt', 'catMH.Valor as MUNICIPIO_HECHOStxt',
            'prode_datosgenerales.COLONIA_HECHOS',
            //'catCH.Valor as COLONIA_HECHOStxt', 
            'CALLE_HECHOS', 'CP', 'REF_1', 'REF_2', 'cr2.Valor as RECIBIDA_PORtxt', 
            'cr96.Valor as UNIDAD_QUE_RECIBE','cr3.Valor as MEDIO_RECEPCIONtxt',  //'cr3.Valor as TIPO_RECEPCIONtxt', 
            'cr4.Valor as AUTORIDADtxt', 'HORA_DENUNCIA', 'cr5.Valor as FORMA_txt', 'cr6.Valor as ASEGURAMIENTOtxt', 'TIPO_DE_BIEN', 
            'cr7.Valor as OPORTUNIDADtxt', 'cr8.Valor as ETAPA_PROCEStxt', 
            'cr9.Valor as MEDIO_DE_CONOCIMIENTOtxt', 'FECHA_DENUNCIA', 'cr10.Valor as REACTIVACIONtxt', 'DESCRIPCION', 
            'OBSERVACIONES', 'FECHA_DETERMINACION','cr11.Valor as SENTIDO_DETERMINACIONtxt','cr12.Valor as TIPO_DETERMINACION','cr13.Valor as TIPO_ACCION_PENAL',
            'cr14.Valor as ARCHIVO_TEMPORAL','cr15.Valor as MOTIVO_REACTIVACION',
            DB::raw('DATE_FORMAT(created_at, "%Y/%m/%d %T") as created_at2'));
        break;
        case 'base_objetos':
          $sql=datos_expediente\de_objetos::whereIn('prode_objetos.idExpediente',$this->IDs)
          ->join('catrespuestas as cr', function($join)
            {
              $join->on('prode_objetos.OBJETO_1','=','cr.id')
              ->Where('cr.idTipoRespuesta','=',25)->Where('cr.Activo','=',1);
            })
          ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','prode_objetos.idExpediente')
          ->where('OBJETO_1', '>=',0)
          ->select('prode_objetos.id as id_1', 'prode_objetos.idExpediente','pdg.NUC_COMPLETA','cr.Valor AS OBJETO', 'DESC_OBJ_1 AS DESCRIPCION', 'CANT_OBJ_1 AS CANTIDAD',
            'VALOR_OBJ_1 AS VALOR','ESTATUS_OBJ_1 as ESTATUS', DB::raw('DATE_FORMAT(prode_objetos.created_at, "%Y/%m/%d %T") as created_at2'))
          ->union(
            datos_expediente\de_objetos::whereIn('prode_objetos.idExpediente',$this->IDs)
            ->join('catrespuestas as cr', function($join)
              {
                $join->on('prode_objetos.OBJETO_2','=','cr.id')
                ->Where('cr.idTipoRespuesta','=',25)->Where('cr.Activo','=',1);
              })
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','prode_objetos.idExpediente')
            ->where('OBJETO_2', '>=',0)
            ->select('prode_objetos.id', 'prode_objetos.idExpediente','pdg.NUC_COMPLETA','cr.Valor AS OBJETO', 'DESC_OBJ_2 AS DESCRIPCION', 'CANT_OBJ_2 AS CANTIDAD','VALOR_OBJ_2 AS VALOR','ESTATUS_OBJ_2 as ESTATUS', DB::raw('DATE_FORMAT(prode_objetos.created_at, "%Y/%m/%d %T") as created_at2'))
          )
          ->union(
            datos_expediente\de_objetos::whereIn('prode_objetos.idExpediente',$this->IDs)
            ->join('catrespuestas as cr', function($join)
              {
                $join->on('prode_objetos.OBJETO_3','=','cr.id')
                ->Where('cr.idTipoRespuesta','=',25)->Where('cr.Activo','=',1);
              })
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','prode_objetos.idExpediente')
            ->where('OBJETO_3', '>=',0)
            ->select('prode_objetos.id', 'prode_objetos.idExpediente','pdg.NUC_COMPLETA','cr.Valor AS OBJETO', 'DESC_OBJ_3 AS DESCRIPCION', 'CANT_OBJ_3 AS CANTIDAD',
              'VALOR_OBJ_3 AS VALOR','ESTATUS_OBJ_3 as ESTATUS', DB::raw('DATE_FORMAT(prode_objetos.created_at, "%Y/%m/%d %T") as created_at2'))
          )->orderby('id_1');
        break;
         case 'base_narcoticos':
          $sql=datos_expediente\de_objetos::whereIn('prode_objetos.idExpediente',$this->IDs)
          ->join('catrespuestas as cr', function($join)
            {
              $join->on('prode_objetos.TIPO_NARCOTICO_1','=','cr.id')
              ->Where('cr.idTipoRespuesta','=',26)->Where('cr.Activo','=',1);
            })
          ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','prode_objetos.idExpediente')
          ->where('TIPO_NARCOTICO_1', '>=',0)
          ->select('prode_objetos.id as id_1', 'prode_objetos.idExpediente','pdg.NUC_COMPLETA','cr.Valor AS TIPO', 'CANTIDAD_NARCO_1', 'GRAMAJE_NARCO_1',
           DB::raw('DATE_FORMAT(prode_objetos.created_at, "%Y/%m/%d %T") as created_at2'))
          ->union(
            datos_expediente\de_objetos::whereIn('prode_objetos.idExpediente',$this->IDs)
            ->join('catrespuestas as cr', function($join)
              {
                $join->on('prode_objetos.TIPO_NARCOTICO_2','=','cr.id')
                ->Where('cr.idTipoRespuesta','=',26)->Where('cr.Activo','=',1);
              })
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','prode_objetos.idExpediente')
            ->where('TIPO_NARCOTICO_2', '>=',0)
            ->select('prode_objetos.id', 'prode_objetos.idExpediente','pdg.NUC_COMPLETA','cr.Valor AS TIPO', 'CANTIDAD_NARCO_2', 'GRAMAJE_NARCO_2',
             DB::raw('DATE_FORMAT(prode_objetos.created_at, "%Y/%m/%d %T") as created_at2'))
          )
          ->union(
            datos_expediente\de_objetos::whereIn('prode_objetos.idExpediente',$this->IDs)
            ->join('catrespuestas as cr', function($join)
              {
                $join->on('prode_objetos.TIPO_NARCOTICO_3','=','cr.id')
                ->Where('cr.idTipoRespuesta','=',26)->Where('cr.Activo','=',1);
              })
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','prode_objetos.idExpediente')
            ->where('TIPO_NARCOTICO_3', '>=',0)
            ->select('prode_objetos.id', 'prode_objetos.idExpediente','pdg.NUC_COMPLETA','cr.Valor AS TIPO', 'CANTIDAD_NARCO_3', 'GRAMAJE_NARCO_3',
             DB::raw('DATE_FORMAT(prode_objetos.created_at, "%Y/%m/%d %T") as created_at2'))
          )->orderby('id_1');
         break;
        case 'base_vehiculos':
          $sql=datos_expediente\de_objetos::whereIn('prode_objetos.idExpediente',$this->IDs)
          ->join('catrespuestas as cr', function($join)
            {
              $join->on('prode_objetos.ESTATUS','=','cr.id')
              ->Where('cr.idTipoRespuesta','=',77)->Where('cr.Activo','=',1);
            })
          ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','prode_objetos.idExpediente')
          ->where('ESTATUS', '>=',0)
          ->select('prode_objetos.id as id_1', 'prode_objetos.idExpediente','pdg.NUC_COMPLETA',
            'cr.Valor AS ESTATUS', 'FECHA_ASEGURADO', 'FECHA_DEVUELTO', 'FECHA_ROBADO', 
            'MARCA', 'MODELO', 'COLOR', 'TIPO', 'PLACA', 'NUMERO', 'ESTADO_PLACAS', 'LUGAR_VEHICULO',
           DB::raw('DATE_FORMAT(prode_objetos.created_at, "%Y/%m/%d %T") as created_at2'));        
        break;
        case 'base_victimas':
          $sql=datos_expediente\de_victimas::whereIn('prode_victimas.idExpediente',$this->IDs)
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('prode_victimas.TIPO_VICTIMA','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',13);
            })
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('prode_victimas.INTERPRETE','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr3', function($join)
            {
              $join->on('prode_victimas.DELITOS_VICTIMA','=','cr3.id')
              ->Where('cr3.idTipoRespuesta','=',14);
            })            
            ->leftJoin('catrespuestas as cr4', function($join)
            {
              $join->on('prode_victimas.SECTOR_VICTIMAS','=','cr4.id')
              ->Where('cr4.idTipoRespuesta','=',15);
            })  
            ->leftJoin('catrespuestas as cr5', function($join)
            {
              $join->on('prode_victimas.TIPO_PERSONA_VICTIMAS','=','cr5.id')
              ->Where('cr5.idTipoRespuesta','=',16);
            })
            ->leftJoin('catrespuestas as cr5s', function($join)
            {
              $join->on('prode_victimas.SEXO_VICTIMA','=','cr5s.id')
              ->Where('cr5s.idTipoRespuesta','=',17);
            })
            ->leftJoin('catrespuestas as cr6', function($join)
            {
              $join->on('prode_victimas.SITUACION_CONYUGAL_VICTIMAS','=','cr6.id')
              ->Where('cr6.idTipoRespuesta','=',18);
            })
            ->leftJoin('catpaises as catPN','catPN.id','=','prode_victimas.NACIONALIDAD')
            ->leftJoin('catrespuestas as cr7', function($join)
            {
              $join->on('prode_victimas.SITUACION_MIGRATORIA_VICTIMAS','=','cr7.id')
              ->Where('cr7.idTipoRespuesta','=',1);
            })
            ->leftJoin('catpaises as catPNC','catPNC.id','=','prode_victimas.PAIS_NACIMIENTO')
            ->leftJoin('catentidadesfederativas_inegi as catENC','catENC.id','=','prode_victimas.ENTIDAD_NACIMIENTO_VICTIMAS')
            ->leftJoin('catmunicipios_inegi as catMNC','catMNC.id','=','prode_victimas.MUNICIPIO_NACIMIENTO')
            ->leftJoin('catpaises as catPR','catPR.id','=','prode_victimas.PAIS_RESIDENCIA')
            ->leftJoin('catentidadesfederativas_inegi as catER','catER.id','=','prode_victimas.ENTIDAD_RESIDENCIA_VICTIMAS')
            ->leftJoin('catmunicipios_inegi as catMR','catMR.id','=','prode_victimas.MUNICIPIO_RESIDENCIA')
            ->leftJoin('catrespuestas as cr8', function($join)
            {
              $join->on('prode_victimas.TRADUCTOR_VICTIMA','=','cr8.id')
              ->Where('cr8.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr9', function($join)
            {
              $join->on('prode_victimas.DISCAPACIDAD_VICTIMAS','=','cr9.id')
              ->Where('cr9.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr10', function($join)
            {
              $join->on('prode_victimas.TIPO_DISCAPACIDAD_VICTIMAS','=','cr10.id')
              ->Where('cr10.idTipoRespuesta','=',19);
            })
            ->leftJoin('catrespuestas as cr11', function($join)
            {
              $join->on('prode_victimas.INTERPRETE_POR_DISCAPACIDAD_VICTIMA','=','cr11.id')
              ->Where('cr11.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr12', function($join)
            {
              $join->on('prode_victimas.POBLACION_CALLE','=','cr12.id')
              ->Where('cr12.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr13', function($join)
            {
              $join->on('prode_victimas.LEER_ESCRIBIR','=','cr13.id')
              ->Where('cr13.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr14', function($join)
            {
              $join->on('prode_victimas.ESCOLARIDAD','=','cr14.id')
              ->Where('cr14.idTipoRespuesta','=',20);
            })
            ->leftJoin('catocupaciones as catO','catO.id','=','prode_victimas.OCUPACION')
            ->leftJoin('catrespuestas as cr15', function($join)
            {
              $join->on('prode_victimas.SE_IDENTIFICA_INDIGENA_VICTIMA','=','cr15.id')
              ->Where('cr15.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr16', function($join)
            {
              $join->on('prode_victimas.POBLACION_INDIGENA_VICTIMA','=','cr16.id')
              ->Where('cr16.idTipoRespuesta','=',71);
            })
            ->leftJoin('catrespuestas as cr17', function($join)
            {
              $join->on('prode_victimas.RELACION_IMPUTADO','=','cr17.id')
              ->Where('cr17.idTipoRespuesta','=',21);
            })
            ->leftJoin('catrespuestas as cr18', function($join)
            {
              $join->on('prode_victimas.ASESORIA','=','cr18.id')
              ->Where('cr18.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr19', function($join)
            {
              $join->on('prode_victimas.ATEN_MEDICA','=','cr19.id')
              ->Where('cr19.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr20', function($join)
            {
              $join->on('prode_victimas.ATEN_PSICOLOGICA','=','cr20.id')
              ->Where('cr20.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr21', function($join)
            {
              $join->on('prode_victimas.HABLA_ESPAÑOL_VICTIMA','=','cr21.id')
              ->Where('cr21.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr22', function($join)
            {
              $join->on('prode_victimas.HABLA_LENG_EXTR_VICTIMA','=','cr22.id')
              ->Where('cr22.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr23', function($join)
            {
              $join->on('prode_victimas.HABLA_LENG_INDIG_VICTIMA','=','cr23.id')
              ->Where('cr23.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr24', function($join)
            {
              $join->on('prode_victimas.TIPO_DE_ASESORIA','=','cr24.id')
              ->Where('cr24.idTipoRespuesta','=',61);
            })
            ->leftJoin('catrespuestas as cr25', function($join)
            {
              $join->on('prode_victimas.TIPO_LENGUA_EXTRANJERA_VICTIMA','=','cr25.id')
              ->Where('cr25.idTipoRespuesta','=',65);
            })
            ->leftJoin('catrespuestas as cr26', function($join)
            {
              $join->on('prode_victimas.LENGUA_VICTIMA','=','cr26.id')
              ->Where('cr26.idTipoRespuesta','=',72);
            })
            ->leftJoin('catrespuestas as cr27', function($join)
            {
              $join->on('prode_victimas.VICTIMA_VIOLENCIA','=','cr27.id')
              ->Where('cr27.idTipoRespuesta','=',4);
            })
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','prode_victimas.idExpediente')
          ->select('prode_victimas.id', 'prode_victimas.idExpediente','pdg.NUC_COMPLETA', 'cr1.Valor as TIPO_VICTIMA', 'cr2.Valor as INTERPRETE', 'cr3.Valor as DELITOS_VICTIMA', 'RAZON_SOCIAL', 'REPRESENTANTE_LEGAL', 'TIPO_REPRESENTANTE_LEGAL', 'cr4.Valor as SECTOR_VICTIMAS', 'cr5.Valor as TIPO_PERSONA_VICTIMAS', 'NOMBRE_VICTIMA', 'PRIMER_APELLIDO', 'SEGUNDO_APELLIDO_VICTIMAS', 'CURP_VICTIMAS', 'EDAD_HECHOS_VICTIMAS', 'cr5s.Valor as SEXO_VICTIMA', 'cr6.Valor as SITUACION_CONYUGAL_VICTIMAS', 'catPN.Valor as NACIONALIDAD', 'cr7.Valor as SITUACION_MIGRATORIA_VICTIMAS', 'catPNC.Valor as PAIS_NACIMIENTO', 'catENC.Valor as ENTIDAD_NACIMIENTO_VICTIMAS', 'catMNC.Valor as MUNICIPIO_NACIMIENTO', 'catPR.Valor as PAIS_RESIDENCIA', 'catER.Valor as ENTIDAD_RESIDENCIA_VICTIMAS', 'catMR.Valor as MUNICIPIO_RESIDENCIA', 'TELEFONO_VICTIMAS', 'cr8.Valor as TRADUCTOR_VICTIMA', 'cr9.Valor as DISCAPACIDAD_VICTIMAS', 'cr10.Valor as TIPO_DISCAPACIDAD_VICTIMAS', 'cr11.Valor as INTERPRETE_POR_DISCAPACIDAD_VICTIMA', 'cr12.Valor as POBLACION_CALLE', 'cr13.Valor as LEER_ESCRIBIR', 'cr14.Valor as ESCOLARIDAD', 'catO.Valor as OCUPACION', 'cr15.Valor as SE_IDENTIFICA_INDIGENA_VICTIMA', 'cr16.Valor as POBLACION_INDIGENA_VICTIMA', 'cr17.Valor as RELACION_IMPUTADO', 'FECHA_NACIMIENTO_VICTIMAS', 'cr18.Valor as ASESORIA', 'cr19.Valor as ATEN_MEDICA', 'cr20.Valor as ATEN_PSICOLOGICA', 'DOMICILIO_VICTIMA', 'cr21.Valor as HABLA_ESPAÑOL_VICTIMA', 'cr22.Valor as HABLA_LENG_EXTR_VICTIMA', 'cr23.Valor as HABLA_LENG_INDIG_VICTIMA', 'NUMERO_DE_ATENCION', 'INGRESO_VICTIMA', 'cr24.Valor as TIPO_DE_ASESORIA', 'cr25.Valor as TIPO_LENGUA_EXTRANJERA_VICTIMA', 'cr26.Valor as LENGUA_VICTIMA', 'VESTIMENTA_VICTIMA', 'cr27.Valor as VICTIMA_VIOLENCIA', 
            DB::raw('DATE_FORMAT(prode_victimas.created_at, "%Y/%m/%d %T") as created_at2'));        
        break;
        case 'base_imputados':
          $sql=datos_expediente\de_imputados::whereIn('prode_imputados.idExpediente',$this->IDs)
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('prode_imputados.INTERPRETE','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('prode_imputados.TIPO_IMPUTADO','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',13);
            })
            ->leftJoin('catrespuestas as cr3', function($join)
            {
              $join->on('prode_imputados.REL_PERS_MORAL','=','cr3.id')
              ->Where('cr3.idTipoRespuesta','=',4);
            })            
            ->leftJoin('catrespuestas as cr4', function($join)
            {
              $join->on('prode_imputados.SECTOR_IMPUTADOS','=','cr4.id')
              ->Where('cr4.idTipoRespuesta','=',15);
            })  
            ->leftJoin('catrespuestas as cr5', function($join)
            {
              $join->on('prode_imputados.TIPO_PERSONA_IMPUTADOS','=','cr5.id')
              ->Where('cr5.idTipoRespuesta','=',16);
            })
            ->leftJoin('catrespuestas as cr5d', function($join)
            {
              $join->on('prode_imputados.DELITOS_IMPUTADO','=','cr5d.id')
              ->Where('cr5d.idTipoRespuesta','=',14);
            })
            ->leftJoin('catrespuestas as cr5r', function($join)
            {
              $join->on('prode_imputados.RELACION_VICTIMA','=','cr5r.id')
              ->Where('cr5r.idTipoRespuesta','=',21);
            })                        
            ->leftJoin('catrespuestas as cr5s', function($join)
            {
              $join->on('prode_imputados.SEXO_IMPUTADO','=','cr5s.id')
              ->Where('cr5s.idTipoRespuesta','=',17);
            })
            ->leftJoin('catrespuestas as cr6', function($join)
            {
              $join->on('prode_imputados.SITUACION_CONYUGAL_IMPUTADOS','=','cr6.id')
              ->Where('cr6.idTipoRespuesta','=',18);
            })
            ->leftJoin('catpaises as catPN','catPN.id','=','prode_imputados.NACIONALIDAD')
            ->leftJoin('catrespuestas as cr7', function($join)
            {
              $join->on('prode_imputados.SITUACION_MIGRATORIA_IMPUTADOS','=','cr7.id')
              ->Where('cr7.idTipoRespuesta','=',1);
            })
            ->leftJoin('catpaises as catPNC','catPNC.id','=','prode_imputados.PAIS_NACIMIENTO')
            ->leftJoin('catentidadesfederativas_inegi as catENC','catENC.id','=','prode_imputados.ENTIDAD_NACIMIENTO_IMPUTADOS')
            ->leftJoin('catmunicipios_inegi as catMNC','catMNC.id','=','prode_imputados.MUNICIPIO_NACIMIENTO')
            ->leftJoin('catpaises as catPR','catPR.id','=','prode_imputados.PAIS_RESIDENCIA')
            ->leftJoin('catentidadesfederativas_inegi as catER','catER.id','=','prode_imputados.ENTIDAD_RESIDENCIA_IMPUTADOS')
            ->leftJoin('catmunicipios_inegi as catMR','catMR.id','=','prode_imputados.MUNICIPIO_RESIDENCIA')
            ->leftJoin('catrespuestas as cr8', function($join)
            {
              $join->on('prode_imputados.TRADUCTOR_IMPUTADO','=','cr8.id')
              ->Where('cr8.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr9', function($join)
            {
              $join->on('prode_imputados.DISCAPACIDAD_IMPUTADOS','=','cr9.id')
              ->Where('cr9.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr10', function($join)
            {
              $join->on('prode_imputados.TIPO_DISCAPACIDAD_IMPUTADOS','=','cr10.id')
              ->Where('cr10.idTipoRespuesta','=',19);
            })
            ->leftJoin('catrespuestas as cr11', function($join)
            {
              $join->on('prode_imputados.INTERPRETE_POR_DISCAPACIDAD_IMPUTADO','=','cr11.id')
              ->Where('cr11.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr12', function($join)
            {
              $join->on('prode_imputados.POBLACION_CALLE','=','cr12.id')
              ->Where('cr12.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr13', function($join)
            {
              $join->on('prode_imputados.LEER_ESCRIBIR_IMPUTADOS','=','cr13.id')
              ->Where('cr13.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr14', function($join)
            {
              $join->on('prode_imputados.ESCOLARIDAD_IMPUTADO','=','cr14.id')
              ->Where('cr14.idTipoRespuesta','=',20);
            })
            ->leftJoin('catrespuestas as cr15', function($join)
            {
              $join->on('prode_imputados.SE_IDENTIFICA_INDIGENA_IMPUTADO','=','cr15.id')
              ->Where('cr15.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr16', function($join)
            {
              $join->on('prode_imputados.INDIGENA_IMPUTADO','=','cr16.id')
              ->Where('cr16.idTipoRespuesta','=',71);
            })
            ->leftJoin('catrespuestas as cr16d', function($join)
            {
              $join->on('prode_imputados.DETENIDO_IMPUTADOS','=','cr16d.id')
              ->Where('cr16d.idTipoRespuesta','=',2);
            })
            ->leftJoin('catrespuestas as cr17', function($join)
            {
              $join->on('prode_imputados.ESTADO_IMPUTADO','=','cr17.id')
              ->Where('cr17.idTipoRespuesta','=',22);
            })            
            ->leftJoin('catrespuestas as cr18', function($join)
            {
              $join->on('prode_imputados.TIPO_DETENCION','=','cr18.id')
              ->Where('cr18.idTipoRespuesta','=',23);
            })
            ->leftJoin('catentidadesfederativas_inegi as catED','catED.id','=','prode_imputados.ENTIDAD_DETENCION_IMPUTADOS')            

            ->leftJoin('catrespuestas as cr19', function($join)
            {
              $join->on('prode_imputados.AUTORIDAD_DETENCION_IMPUTADOS','=','cr19.id')
              ->Where('cr19.idTipoRespuesta','=',24);
            })
            ->leftJoin('catrespuestas as cr20', function($join)
            {
              $join->on('prode_imputados.RAZON_RND','=','cr20.id')
              ->Where('cr20.idTipoRespuesta','=',73);
            })
            ->leftJoin('catrespuestas as cr20x', function($join)
            {
              $join->on('prode_imputados.RAZON_RND','=','cr20x.id')
              ->Where('cr20x.idTipoRespuesta','=',74);
            })
            ->leftJoin('catrespuestas as cr20l', function($join)
            {
              $join->on('prode_imputados.LESIONADO','=','cr20l.id')
              ->Where('cr20l.idTipoRespuesta','=',2);
            })
            ->leftJoin('catrespuestas as cr20e', function($join)
            {
              $join->on('prode_imputados.ESTADO_PRESENTACION','=','cr20e.id')
              ->Where('cr20e.idTipoRespuesta','=',75);
            })
            ->leftJoin('catrespuestas as cr20sl', function($join)
            {
              $join->on('prode_imputados.SITUACION_LIBERTAD','=','cr20sl.id')
              ->Where('cr20sl.idTipoRespuesta','=',95);
            })            
            ->leftJoin('catrespuestas as cr20a', function($join)
            {
              $join->on('prode_imputados.ANTECEDENTES','=','cr20a.id')
              ->Where('cr20a.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr20d', function($join)
            {
              $join->on('prode_imputados.DEFENSA','=','cr20d.id')
              ->Where('cr20d.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr20g', function($join)
            {
              $join->on('prode_imputados.GRADO_DE_PARTICIPACION','=','cr20g.id')
              ->Where('cr20g.idTipoRespuesta','=',52);
            })
            ->leftJoin('catrespuestas as cr21', function($join)
            {
              $join->on('prode_imputados.HABLA_ESPAÑOL_IMPUTADO','=','cr21.id')
              ->Where('cr21.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr22', function($join)
            {
              $join->on('prode_imputados.HABLA_LENG_EXTR_IMPUTADO','=','cr22.id')
              ->Where('cr22.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr23', function($join)
            {
              $join->on('prode_imputados.HABLA_LENG_INDIG_IMPUTADO','=','cr23.id')
              ->Where('cr23.idTipoRespuesta','=',4);
            })
            ->leftJoin('catocupaciones as catO','catO.id','=','prode_imputados.OCUPACION_IMPUTADO')

            ->leftJoin('catrespuestas as cr24', function($join)
            {
              $join->on('prode_imputados.TIPO_DEFENSA','=','cr24.id')
              ->Where('cr24.idTipoRespuesta','=',61);
            })
            ->leftJoin('catrespuestas as cr25', function($join)
            {
              $join->on('prode_imputados.TIPO_LENGUA_EXTRANJERA_IMPUTADO','=','cr25.id')
              ->Where('cr25.idTipoRespuesta','=',65);
            })
            ->leftJoin('catrespuestas as cr26', function($join)
            {
              $join->on('prode_imputados.LENGUA_IMPUTADO','=','cr26.id')
              ->Where('cr26.idTipoRespuesta','=',72);
            })
            ->leftJoin('catrespuestas as cr27', function($join)
            {
              $join->on('prode_imputados.TIPO_MANDAMIENTO','=','cr27.id')
              ->Where('cr27.idTipoRespuesta','=',66);
            })  
            ->leftJoin('catrespuestas as cr28', function($join)
            {
              $join->on('prode_imputados.IMPUTADO_CONOCIDO','=','cr28.id')
              ->Where('cr28.idTipoRespuesta','=',2);
            })                      
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','prode_imputados.idExpediente')            
          ->select('prode_imputados.id', 'prode_imputados.idExpediente','pdg.NUC_COMPLETA', 'cr1.Valor as INTERPRETE', 'cr2.Valor as TIPO_IMPUTADO', 'RAZON_SOCIAL', 'cr3.Valor as REL_PERS_MORAL', 'cr4.Valor as SECTOR_IMPUTADOS', 'cr5.Valor as TIPO_PERSONA_IMPUTADOS', 'cr5d.Valor as DELITOS_IMPUTADO', 'ALIAS_IMPUTADO', 'cr5r.Valor as RELACION_VICTIMA', 'NOMBRE_IMPUTADO', 'PRIMER_APELLIDO', 'SEGUNDO_APELLIDO_IMPUTADOS', 'CURP_IMPUTADOS', 'FECHA_NACIMIENTO_IMPUTADOS', 'EDAD_HECHOS_IMPUTADOS', 'cr5s.Valor as SEXO_IMPUTADO', 'cr6.Valor as SITUACION_CONYUGAL_IMPUTADOS', 'catPN.Valor as NACIONALIDAD', 'cr7.Valor as SITUACION_MIGRATORIA_IMPUTADOS', 'catPNC.Valor as PAIS_NACIMIENTO', 'catENC.Valor as ENTIDAD_NACIMIENTO_IMPUTADOS', 'catMNC.Valor as MUNICIPIO_NACIMIENTO', 'catPR.Valor as PAIS_RESIDENCIA', 'catER.Valor as ENTIDAD_RESIDENCIA_IMPUTADOS', 'catMR.Valor as MUNICIPIO_RESIDENCIA', 'TELEFONO_IMPUTADOS', 'cr8.Valor as TRADUCTOR_IMPUTADO', 'cr9.Valor as DISCAPACIDAD_IMPUTADOS', 'cr10.Valor as TIPO_DISCAPACIDAD_IMPUTADOS', 'cr11.Valor as INTERPRETE_POR_DISCAPACIDAD_IMPUTADO', 'cr12.Valor as POBLACION_CALLE', 'cr13.Valor as LEER_ESCRIBIR_IMPUTADOS', 'cr14.Valor as ESCOLARIDAD_IMPUTADO', 'cr15.Valor as SE_IDENTIFICA_INDIGENA_IMPUTADO', 'cr16.Valor as INDIGENA_IMPUTADO', 'cr16d.Valor as DETENIDO_IMPUTADOS', 'cr17.Valor as ESTADO_IMPUTADO', 'FECHA_DETENCION', 'HORA_DETENCION', 'cr18.Valor as TIPO_DETENCION', 'catED.Valor as ENTIDAD_DETENCION_IMPUTADOS', 'cr19.Valor as AUTORIDAD_DETENCION_IMPUTADOS', 'FOLIO_RND', 'cr20.Valor as RAZON_RND', 'cr20x.Valor as EXAMEN_DETENCION_IMPUTADOS', 'cr20l.Valor as LESIONADO', 'cr20e.Valor as ESTADO_PRESENTACION', 'cr20sl.Valor as SITUACION_LIBERTAD', 'cr20a.Valor as ANTECEDENTES', 'cr20d.Valor as DEFENSA', 'DOMICILIO_IMPUTADO', 'cr20g.Valor as GRADO_DE_PARTICIPACION', 'cr21.Valor as HABLA_ESPAÑOL_IMPUTADO', 'cr22.Valor as HABLA_LENG_EXTR_IMPUTADO', 'cr23.Valor as HABLA_LENG_INDIG_IMPUTADO', 'MEDIA_FILIACION_IMPUTADO', 'NOMBRE_DE_GRUPO', 'catO.Valor as OCUPACION_IMPUTADO', 'INGRESO_IMPUTADO', 'REPRESENTANTE_LEGAL', 'TIPO_REPRESENTANTE_LEGAL', 'cr24.Valor as TIPO_DEFENSA', 'cr25.Valor as TIPO_LENGUA_EXTRANJERA_IMPUTADO', 'cr26.Valor as LENGUA_IMPUTADO', 'cr27.Valor as TIPO_MANDAMIENTO', 'cr28.Valor as IMPUTADO_CONOCIDO', 
            DB::raw('DATE_FORMAT(prode_imputados.created_at, "%Y/%m/%d %T") as created_at2'));
        break;
        case 'base_delitos':
          $sql=datos_expediente\de_hechos::whereIn('prode_hechos.idExpediente',$this->IDs)
            ->leftJoin('catdelitosespecificos as catDS','catDS.id','=','prode_hechos.DELITO')
            ->leftJoin('catdelitosgenerales as catDG','catDG.id','=','catDS.idDelitoGeneral')
            ->leftJoin('catordenamientos as catOR','catOR.id','=','catDG.idOrdenamiento')
            ->leftJoin('catdelitosjur as catDJ','catDJ.id','=','prode_hechos.DELITO_JUR')
            ->leftJoin('catordenamientosjur as catOJ','catOJ.id','=','catDJ.idOrdenamientoJUR')
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('prode_hechos.CONSUMACION','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',5);
            })
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('prode_hechos.MODALIDAD','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',6);
            })
            ->leftJoin('catrespuestas as cr3', function($join)
            {
              $join->on('prode_hechos.INSTRUMENTO','=','cr3.id')
              ->Where('cr3.idTipoRespuesta','=',7);
            })
            ->leftJoin('catrespuestas as cr4', function($join)
            {
              $join->on('prode_hechos.FUERO','=','cr4.id')
              ->Where('cr4.idTipoRespuesta','=',8);
            })
            ->leftJoin('catrespuestas as cr5', function($join)
            {
              $join->on('prode_hechos.TIPO_SITIO_OCURRENCIA','=','cr5.id')
              ->Where('cr5.idTipoRespuesta','=',9);
            })
            ->leftJoin('catrespuestas as cr6', function($join)
            {
              $join->on('prode_hechos.CALIFICACION','=','cr6.id')
              ->Where('cr6.idTipoRespuesta','=',10);
            })            
            ->leftJoin('catrespuestas as cr7', function($join)
            {
              $join->on('prode_hechos.COMISION','=','cr7.id')
              ->Where('cr7.idTipoRespuesta','=',11);
            })
            ->leftJoin('catrespuestas as cr8', function($join)
            {
              $join->on('prode_hechos.CONTEXTO','=','cr8.id')
              ->Where('cr8.idTipoRespuesta','=',43);
            })
            ->leftJoin('catrespuestas as cr9', function($join)
            {
              $join->on('prode_hechos.FORMA_ACCION','=','cr9.id')
              ->Where('cr9.idTipoRespuesta','=',49);
            })                                                                                  
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','prode_hechos.idExpediente')
          ->select('prode_hechos.id', 'prode_hechos.idExpediente','pdg.NUC_COMPLETA', 'catOR.Valor as ORDENAMIENTO','catDG.Valor as DELITO GENERAL','catDS.Valor as DELITO', 'catOJ.Valor as ORDENAMIENTO JURIDICO','catDJ.Valor as DELITO_JUR', 'cr1.Valor as CONSUMACION', 'cr2.Valor as MODALIDAD', 'cr3.Valor as INSTRUMENTO', 'cr4.Valor as FUERO', 'cr5.Valor as TIPO_SITIO_OCURRENCIA', 'cr6.Valor as CALIFICACION', 'cr7.Valor as COMISION', 
            'cr8.Valor as CONTEXTO', 'cr9.Valor as FORMA_ACCION', 
            DB::raw('DATE_FORMAT(prode_hechos.created_at, "%Y/%m/%d %T") as created_at2'));
        break;         
        case 'base_relacion':
         $sql=datos_expediente\bitde_relaciondelito::leftjoin('prode_relaciondelito as pdr','bitde_relaciondelito.id','=','pdr.idRelacion')
          ->leftjoin('prode_victimas as pdv','pdr.idVictima','=','pdv.id')
          ->leftjoin('prode_imputados as pdi','pdr.idImputado','=','pdi.id')
          ->leftjoin('prode_hechos as pdh','bitde_relaciondelito.idDelito','=','pdh.id')
          ->leftjoin('catdelitosespecificos as cde','pdh.DELITO','=','cde.id')
          ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','bitde_relaciondelito.idExpediente')
         ->select('pdr.id','bitde_relaciondelito.idExpediente','pdg.NUC_COMPLETA','pdh.id as idDelito','cde.Valor AS delito','pdv.id as idVictima',
            DB::raw("CASE WHEN pdv.TIPO_VICTIMA=2 THEN pdv.RAZON_SOCIAL WHEN pdv.TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN pdv.TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdv.TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(pdv.NOMBRE_VICTIMA,' ', pdv.PRIMER_APELLIDO,' ', pdv.SEGUNDO_APELLIDO_VICTIMAS) END AS victimas"),
            'pdi.id as idImputado',
            DB::raw("CASE WHEN pdi.TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN pdi.TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN pdi.TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdi.TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(pdi.NOMBRE_IMPUTADO,' ', pdi.PRIMER_APELLIDO,' ', pdi.SEGUNDO_APELLIDO_IMPUTADOS) END AS imputados"),
         )->whereIn('bitde_relaciondelito.idExpediente',$this->IDs);              
        break;
       #endregion
       #region Datos CAUSAS
        case 'base_causasPenales':
         $sql=causas_penales\cp_datosgenerales::whereIn('procp_datosgenerales.idExpediente',$this->IDs)
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('procp_datosgenerales.UNIDAD_DE_INVESTIGACION','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',27);
            })
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('procp_datosgenerales.DISTRITO_JUDICIAL','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',97);
            })
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','procp_datosgenerales.idExpediente')
         ->select('procp_datosgenerales.id', 'procp_datosgenerales.idExpediente','pdg.NUC_COMPLETA', 'CAUSA_PENAL_ID', 'FECHA_CAUSA_PENAL', 'cr1.Valor as UNIDAD_DE_INVESTIGACION', 'cr2.Valor as DISTRITO_JUDICIAL', 
          'procp_datosgenerales.OBSERVACIONES', 
          DB::raw('DATE_FORMAT(procp_datosgenerales.created_at, "%Y/%m/%d %T") as created_at2'));
        break;  
        case 'causas_acumuladas':
         $sql=causas_penales\cp_dg_acumuladas::leftJoin('procp_datosgenerales as causaA','causaA.id','=','procp_dg_acumuladas.idCausa')
            ->leftJoin('procp_datosgenerales as causaB','causaB.id','=','procp_dg_acumuladas.idCausaRel')
            ->leftJoin('prode_datosgenerales as pdgA','pdgA.id','=','causaA.idExpediente')            
         ->whereIn('causaA.idExpediente',$this->IDs)
         ->select('procp_dg_acumuladas.id', 'causaA.idExpediente','pdgA.NUC_COMPLETA', 'causaA.CAUSA_PENAL_ID as CAUSA_PENAL_ID_A', 'causaB.CAUSA_PENAL_ID as CAUSA_PENAL_ID_B');
        break;  
        case 'causas_delitos':
         $sql=causas_penales\cp_dg_delitos::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_dg_delitos.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('procp_dg_delitos.RECLASIFICACION','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',2);
            })            
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('procp_dg_delitos.MOMENTO_RECLAS','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',69);
            })  
          ->leftjoin('prode_hechos as pdh','procp_dg_delitos.idDelito','=','pdh.id')
          ->leftjoin('catdelitosespecificos as cde','pdh.DELITO','=','cde.id')            
         ->whereIn('causa.idExpediente',$this->IDs)
         ->select('procp_dg_delitos.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID','idDelito','cde.Valor AS delito', 'cr1.Valor as RECLASIFICACION', 
          'DELITO_DE_ACUERDO_CON_LEY', 'cr2.Valor as MOMENTO_RECLAS', 'FECHA_RECLAS', 'usuario', 
          DB::raw('DATE_FORMAT(procp_dg_delitos.created_at, "%Y/%m/%d %T") as created_at2'));         
        break; 
        case 'causas_victimas':
         $sql=causas_penales\cp_dg_victimas::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_dg_victimas.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')
            ->leftjoin('prode_victimas as pdv','procp_dg_victimas.idVictima','=','pdv.id')
         ->whereIn('causa.idExpediente',$this->IDs)
         ->select('procp_dg_victimas.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID','idVictima',
          DB::raw("CASE WHEN pdv.TIPO_VICTIMA=2 THEN pdv.RAZON_SOCIAL WHEN pdv.TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN pdv.TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdv.TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(pdv.NOMBRE_VICTIMA,' ', pdv.PRIMER_APELLIDO,' ', pdv.SEGUNDO_APELLIDO_VICTIMAS) END AS victimas"), 'usuario', 
          DB::raw('DATE_FORMAT(procp_dg_victimas.created_at, "%Y/%m/%d %T") as created_at2'));
        break;  
        case 'causas_medidasProteccion':
         $sql=causas_penales\cp_ev_medidas::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_ev_medidas.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')    
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('procp_ev_medidas.TIPO_DE_MEDIDA','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',28);
            })
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('procp_ev_medidas.MEDIDA_IMPUESTA_POR','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',79);
            })
            ->leftJoin('procp_dg_victimas as pdv','procp_ev_medidas.idVictima','=','pdv.id')
            ->leftjoin('prode_victimas as pdvDE','pdv.idVictima','=','pdvDE.id')
         ->whereIn('procp_ev_medidas.idExpediente',$this->IDs)
         ->select('procp_ev_medidas.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID','pdv.idVictima',
          DB::raw("CASE WHEN pdvDE.TIPO_VICTIMA=2 THEN pdvDE.RAZON_SOCIAL WHEN pdvDE.TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN pdvDE.TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdvDE.TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(pdvDE.NOMBRE_VICTIMA,' ', pdvDE.PRIMER_APELLIDO,' ', pdvDE.SEGUNDO_APELLIDO_VICTIMAS) END AS victimas"),
          'cr1.Valor as TIPO_DE_MEDIDA',
          DB::raw('CASE WHEN TEMPORALIDAD_DE_LA_MEDIDA > 1 THEN CONCAT(TEMPORALIDAD_DE_LA_MEDIDA," MESES") ELSE CONCAT(TEMPORALIDAD_DE_LA_MEDIDA," MES") END AS TEMPORALIDAD_DE_LA_MEDIDA'),'cr2.Valor as MEDIDA_IMPUESTA_POR',
          DB::raw('DATE_FORMAT(procp_ev_medidas.created_at, "%Y/%m/%d %T") as created_at2'));
        break;          
        case 'causas_imputados':
         $sql=causas_penales\cp_dg_imputados::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_dg_imputados.idCausa')
         ->leftjoin('prode_imputados as pdi','procp_dg_imputados.idImputado','=','pdi.id')
          ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('procp_dg_imputados.FORMA_','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',50);
            })
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('procp_dg_imputados.DETENCION_LEGAL_ILEGAL','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',76);
            })
            ->leftJoin('catrespuestas as cr3', function($join)
            {
              $join->on('procp_dg_imputados.MASC','=','cr3.id')
              ->Where('cr3.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as cr4', function($join)
            {
              $join->on('procp_dg_imputados.TIPO_CUMPLIMIENTO','=','cr4.id')
              ->Where('cr4.idTipoRespuesta','=',64);
            })
            ->leftJoin('catrespuestas as cr5', function($join)
            {
              $join->on('procp_dg_imputados.TIPO_MASC','=','cr5.id')
              ->Where('cr5.idTipoRespuesta','=',67);
            })
            ->leftJoin('catrespuestas as cr6', function($join)
            {
              $join->on('procp_dg_imputados.AUTORIDAD_DERIVA_MASC','=','cr6.id')
              ->Where('cr6.idTipoRespuesta','=',40);
            })

          ->leftJoin('procp_ev_imputados as pevi','pevi.idImputado','=','procp_dg_imputados.id')
            ->leftJoin('catrespuestas as crEV1', function($join)
            {
              $join->on('pevi.FORMA_PROCESO','=','crEV1.id')
              ->Where('crEV1.idTipoRespuesta','=',51);
            })
            ->leftJoin('catrespuestas as crEV11', function($join)
            {
              $join->on('pevi.CASO_URGENTE_ESTATUS','=','crEV11.id')
              ->Where('crEV11.idTipoRespuesta','=',87);
            })            
            ->leftJoin('catrespuestas as crEV4', function($join)
            {
              $join->on('pevi.PROMOVIDA_POR','=','crEV4.id')
              ->Where('crEV4.idTipoRespuesta','=',31);
            })
          ->leftJoin('procp_ev_mandamientos as pevimand','pevimand.id_cp_ev_imputados','=','pevi.id')
            ->leftJoin('catrespuestas as crEV2', function($join)
            {
              $join->on('pevimand.TIPO_MANDAMIENTO','=','crEV2.id')
              ->Where('crEV2.idTipoRespuesta','=',81);
            })
            ->leftJoin('catrespuestas as crEV3', function($join)
            {
              $join->on('pevimand.ESTATUS_MANDAMIENTO','=','crEV3.id')
              ->Where('crEV3.idTipoRespuesta','=',80);
            })          

          ->leftJoin('procp_ai_imputados as paii','paii.idImputado','=','procp_dg_imputados.id')
            ->leftJoin('catrespuestas as crAI1', function($join)
            {
              $join->on('paii.DECRETO_LEGAL_DETENCION','=','crAI1.id')
              ->Where('crAI1.idTipoRespuesta','=',2);
            })
            ->leftJoin('catrespuestas as crAI2', function($join)
            {
              $join->on('paii.FORMA_DE_CONDUCCION_DEL_IMPUTADO_A_PROCESO','=','crAI2.id')
              ->Where('crAI2.idTipoRespuesta','=',32);
            })
            ->leftJoin('catrespuestas as crAI3', function($join)
            {
              $join->on('paii.FORMULACION','=','crAI3.id')
              ->Where('crAI3.idTipoRespuesta','=',4);
            })
            ->leftJoin('catrespuestas as crAI4', function($join)
            {
              $join->on('paii.RESOLUCION','=','crAI4.id')
              ->Where('crAI4.idTipoRespuesta','=',56);
            })  
            ->leftjoin('procp_ai_vinculaciones as paiv','paiv.idcp_ai_imputados','=','paii.id')
            ->leftjoin('prode_hechos as pdh','paiv.DELITO_VINCULO','=','pdh.id')
            ->leftjoin('catdelitosespecificos as cde','cde.id','=','pdh.DELITO')
            ->leftjoin('catdelitosjur as cdj','pdh.DELITO_JUR','=','cdj.id')                                 
            
            // ->leftJoin('catrespuestas as crAI5', function($join)
            // {
            //   $join->on('paii.INV_CON_DETENIDO','=','crAI5.id')
            //   ->Where('crAI5.idTipoRespuesta','=',2);
            // })

          ->leftJoin('procp_procedimientoabreviado as ppa','ppa.idImputado','=','procp_dg_imputados.id')
            ->leftJoin('catrespuestas as crPA1', function($join)
            {
              $join->on('ppa.NO_ADMISION_DEL_ABREVIADO','=','crPA1.id')
              ->Where('crPA1.idTipoRespuesta','=',2);
            })       
            // ->leftJoin('catrespuestas as crPA2', function($join)
            // {
            //   $join->on('ppa.ESTATUS_ABREVIADO','=','crPA2.id')
            //   ->Where('crPA2.idTipoRespuesta','=',88);
            // }) 
          ->leftJoin('procp_ss_imputados as pss','pss.idImputado','=','procp_dg_imputados.id')
            ->leftJoin('catrespuestas as crSS1', function($join)
            {
              $join->on('pss.TIPO_SOBRESEIMIENTO','=','crSS1.id')
              ->Where('crSS1.idTipoRespuesta','=',37);
            })  
            ->leftJoin('catrespuestas as crSS2', function($join)
            {
              $join->on('pss.CAUSAS_SOBRESEIMIENTO','=','crSS2.id')
              ->Where('crSS2.idTipoRespuesta','=',36);
            })  
            // ->leftJoin('catrespuestas as crSS3', function($join)
            // {
            //   $join->on('pss.CAUSA_PROCESO','=','crSS3.id')
            //   ->Where('crSS3.idTipoRespuesta','=',33);
            // })  
            // ->leftJoin('catrespuestas as crSS4', function($join)
            // {
            //   $join->on('pss.REAPERTURA_PROCESO','=','crSS4.id')
            //   ->Where('crSS4.idTipoRespuesta','=',2);
            // })
          ->leftJoin('procp_jo_imputados as pjo','pjo.idImputado','=','procp_dg_imputados.id')
            ->leftJoin('catrespuestas as crJO1', function($join)
            {
              $join->on('pjo.LIBERTAD_CONDICIONAL','=','crJO1.id')
              ->Where('crJO1.idTipoRespuesta','=',2);
            })  
            ->leftJoin('catrespuestas as crJO2', function($join)
            {
              $join->on('pjo.TIPO_SENTENCIA','=','crJO2.id')
              ->Where('crJO2.idTipoRespuesta','=',38);
            })  
            ->leftJoin('catrespuestas as crJO3', function($join)
            {
              $join->on('pjo.FIRME','=','crJO3.id')
              ->Where('crJO3.idTipoRespuesta','=',4);
            })  
         ->whereIn('causa.idExpediente',$this->IDs)
         ->select('procp_dg_imputados.id','causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID','procp_dg_imputados.idImputado',
          DB::raw("CASE WHEN pdi.TIPO_IMPUTADO=2 THEN pdi.RAZON_SOCIAL WHEN pdi.TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN pdi.TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdi.TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(pdi.NOMBRE_IMPUTADO,' ', pdi.PRIMER_APELLIDO,' ', pdi.SEGUNDO_APELLIDO_IMPUTADOS) END AS imputados"),
          'cr1.Valor as FORMA_', 'cr2.Valor as DETENCION_LEGAL_ILEGAL', 'cr3.Valor as MASC', 'procp_dg_imputados.FECHA_DERIVA_MASC', 'procp_dg_imputados.FECHA_CUMPL_MAS', 'cr4.Valor as TIPO_CUMPLIMIENTO', 
          'cr5.Valor as TIPO_MASC', 'cr6.Valor as AUTORIDAD_DERIVA_MASC',    

          'crEV1.Valor as FORMA_PROCESO',
          'SOLICITUD_DE_ORDEN_DE_APREHENSION', 'OA_SIN_EFECTO', 'OA_NEGADA', 'OA_CUMPLIDA', 'ORDEN_DE_COMPARECENCIA_GIRADA', 'ORDEN_DE_COMPARECENCIA_NEGADA',
          'pevi.FECHA_DETENCION', 'DETENCION_LEGAL', 
          'CASO_URGENTE_FECHA_LIBRAMIENTO', 'crEV11.Valor as CASO_URGENTE_ESTATUS', 'CASO_URGENTE_FECHA_CUMPLIMIENTO',
          'pevimand.SOLICITUD_DE_MANDAMIENTO_JUDICIAL', 'crEV2.Valor as TIPO_MANDAMIENTO', 'pevimand.FECHA_LIBERA', 
          'crEV3.Valor as ESTATUS_MANDAMIENTO', 'pevimand.FECHA_MANDAMIENTO',
          'pevi.AUDIENCIA_DE_GARANTIAS', 'crEV4.Valor as PROMOVIDA_POR', 'pevi.RESULTADO_AUDIENCIA_DE_GARANTIAS', 'pevi.FECHA_CITA',

          'crAI1.Valor as DECRETO_LEGAL_DETENCION', 'FECHA_CONTROL', 'crAI2.Valor as FORMA_DE_CONDUCCION_DEL_IMPUTADO_A_PROCESO', 
          'crAI3.Valor as FORMULACION','FECHA_FORM',  'paii.OBSERVACIONES', 
          'crAI4.Valor as RESOLUCION', 'paii.FECHA_RESOL',DB::raw('CASE WHEN cdj.id IS NULL THEN cde.Valor ELSE CONCAT(cde.Valor," [",cdj.cClaveDelito,"-",cdj.Valor,"]") END as Valor'), //'crAI5.Valor as INV_CON_DETENIDO',

          'crPA1.Valor as NO_ADMISION_DEL_ABREVIADO', 'CAUSAS_ABREVIADO','PROCEDIMIENTO_ABREVIADO', 'PENA_CONDENATORIA_EN_ABREVIADO', //'crPA2.Valor as ESTATUS_ABREVIADO',

          'pss.FECHA_SOBRESEIMIENTO', 'crSS1.Valor as TIPO_SOBRESEIMIENTO', 'crSS2.Valor as CAUSAS_SOBRESEIMIENTO', 'SOBRESEIMIENTO_OBSERVACIONES', 
          //'pss.FECHA_SUSPENSION','crSS3.Valor as CAUSA_PROCESO', 'crSS4.Valor as REAPERTURA_PROCESO','pss.FECHA_DE_REANUDACION',
          'FECHA_SENTENCIA', 'crJO1.Valor as LIBERTAD_CONDICIONAL', 'crJO2.Valor as TIPO_SENTENCIA', 'pjo.OBSERVACIONES as OBSERVACIONES_ABSOLUTORIA', 'SENTENCIA_CONDENATORIA',
          'crJO3.Valor as FIRME', 'TIEMPO',

          'procp_dg_imputados.usuario', DB::raw('DATE_FORMAT(procp_dg_imputados.created_at, "%Y/%m/%d %T") as created_at2'));

        break; 
        case 'causas_relacion_imputados':
         $sql=causas_penales\cp_dg_relacionimputado::leftJoin('procp_dg_imputados as pdi','pdi.id','=','procp_dg_relacionimputado.idcp_dg_imputados')
            ->leftJoin('procp_datosgenerales as causa','causa.id','=','pdi.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')
            ->leftjoin('prode_victimas as pdv','procp_dg_relacionimputado.idVictima','=','pdv.id')
            ->leftjoin('prode_imputados as pdiDE','pdi.idImputado','=','pdiDE.id')
            ->leftjoin('prode_hechos as pdh','procp_dg_relacionimputado.idDelito','=','pdh.id')
            ->leftjoin('catdelitosespecificos as cde','pdh.DELITO','=','cde.id')            
         ->whereIn('causa.idExpediente',$this->IDs)
         ->select('procp_dg_relacionimputado.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID',
         'pdi.idImputado',
          DB::raw("CASE WHEN pdiDE.TIPO_IMPUTADO=2 THEN pdiDE.RAZON_SOCIAL WHEN pdiDE.TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN pdiDE.TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdiDE.TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(pdiDE.NOMBRE_IMPUTADO,' ', pdiDE.PRIMER_APELLIDO,' ', pdiDE.SEGUNDO_APELLIDO_IMPUTADOS) END AS imputados"),
         'procp_dg_relacionimputado.idDelito','cde.Valor AS delito',
         'procp_dg_relacionimputado.idVictima',
          DB::raw("CASE WHEN pdv.TIPO_VICTIMA=2 THEN pdv.RAZON_SOCIAL WHEN pdv.TIPO_VICTIMA=3 THEN 'LA SOCIEDAD' WHEN pdv.TIPO_VICTIMA=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdv.TIPO_VICTIMA=7 THEN 'LA SALUD' ELSE CONCAT(pdv.NOMBRE_VICTIMA,' ', pdv.PRIMER_APELLIDO,' ', pdv.SEGUNDO_APELLIDO_VICTIMAS) END AS victimas"),
         'procp_dg_relacionimputado.usuario',
          DB::raw('DATE_FORMAT(procp_dg_relacionimputado.created_at, "%Y/%m/%d %T") as created_at2') );
        break; 
        case 'causas_actosInvestigacion':
         $sql=causas_penales\cp_ev_actos::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_ev_actos.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')    
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('procp_ev_actos.TIPO_ACTOS_DE_INV','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',78);
            })
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('procp_ev_actos.TIPO_CONTROL_ACTOS_DE_INV','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',89);
            })                                
         ->whereIn('procp_ev_actos.idExpediente',$this->IDs)
         ->select('procp_ev_actos.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID',
          'FECHA_ACTOS_DE_INV','cr2.Valor as TIPO_CONTROL_ACTOS_DE_INV', 'cr1.Valor as TIPO_ACTOS_DE_INV', 'OBSERVACIONES_ACTOS_DE_INV',
          DB::raw('DATE_FORMAT(procp_ev_actos.created_at, "%Y/%m/%d %T") as created_at2'));
        break;  
        case 'causas_actosConSinControl':
         $sql=causas_penales\cp_ev_actosconsin::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_ev_actosconsin.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')    
            ->leftJoin('catrespuestas as crCON', function($join)
            {
              $join->on('procp_ev_actosconsin.TIPO_ACTOS_CONSIN','=','crCON.id')
              ->Where('crCON.idTipoRespuesta','=',29);
            })
            ->leftJoin('catrespuestas as crSIN', function($join)
            {
              $join->on('procp_ev_actosconsin.TIPO_ACTOS_CONSIN','=','crSIN.id')
              ->Where('crSIN.idTipoRespuesta','=',30);
            })
         ->leftJoin('procp_dg_imputados as pdi','procp_ev_actosconsin.idImputado','=','pdi.id')            
         ->whereIn('procp_ev_actosconsin.idExpediente',$this->IDs)
         ->select('procp_ev_actosconsin.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID','pdi.idImputado',
          DB::raw('CASE WHEN CONSIN="con" THEN crCON.Valor ELSE crSIN.Valor END as TIPO_ACTOS_CONSIN'),
          DB::raw('CASE WHEN CONSIN="con" THEN "ACTO CON CONTROL JUDICIAL" ELSE "ACTO SIN CONTROL JUDICIAL" END as CONSIN'),
          DB::raw('DATE_FORMAT(procp_ev_actosconsin.created_at, "%Y/%m/%d %T") as created_at2'));
        break;  
        case 'causas_audienciaInicial':
         $sql=causas_penales\cp_audienciainicial::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_audienciainicial.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')    
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('procp_audienciainicial.AUDIENCIA_INICIAL','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',4);
            })  
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('procp_audienciainicial.MOTIVO_NOAUD','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',55);
            })                               
         ->whereIn('procp_audienciainicial.idExpediente',$this->IDs)
         ->select('procp_audienciainicial.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID',
          'cr1.Valor as AUDIENCIA_INICIAL', 'FECHA_AUDIENCIA_INICIAL', 'cr2.Valor as MOTIVO_NOAUD', 'NOMBRE_JUEZ_CONTROL', 'FECHA_INICIO_INVESTIGACION', 'FECHA_CIERRE',
          DB::raw('DATE_FORMAT(procp_audienciainicial.created_at, "%Y/%m/%d %T") as created_at2'));
        break;   
        case 'causas_prorrogas':
         $sql=causas_penales\cp_ai_prorrogas::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_ai_prorrogas.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')    
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('procp_ai_prorrogas.PRORROGA','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',82);
            })                              
         ->whereIn('procp_ai_prorrogas.idExpediente',$this->IDs)
         ->select('procp_ai_prorrogas.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID',
          'cr1.Valor as PRORROGA','TEMPORALIDAD_PRORROGA',
          DB::raw('DATE_FORMAT(procp_ai_prorrogas.created_at, "%Y/%m/%d %T") as created_at2'));
        break;
        case 'causas_medidasCautelares':
         $sql=causas_penales\cp_medidascautelares::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_medidascautelares.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')    
            ->leftJoin('procp_dg_imputados as pdi','procp_medidascautelares.idImputado','=','pdi.id')
            ->leftjoin('prode_imputados as pdiDE','pdi.idImputado','=','pdiDE.id')
            ->leftJoin('procp_mc_medidas as med','med.id_cp_medidascautelares','=','procp_medidascautelares.id')
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('med.TIPO_MEDIDAS_CAUTELARES','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',34);
            })            
         ->whereNull('med.deleted_at')
         ->whereIn('procp_medidascautelares.idExpediente',$this->IDs)
         ->select('procp_medidascautelares.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID','pdi.idImputado',
          DB::raw("CASE WHEN pdiDE.TIPO_IMPUTADO=2 THEN pdiDE.RAZON_SOCIAL WHEN pdiDE.TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN pdiDE.TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdiDE.TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(pdiDE.NOMBRE_IMPUTADO,' ', pdiDE.PRIMER_APELLIDO,' ', pdiDE.SEGUNDO_APELLIDO_IMPUTADOS) END AS imputados"),
          'cr1.Valor as TIPO_MEDIDAS_CAUTELARES', 'TEMPORALIDAD_MEDIDA_D', 'TEMPORALIDAD_MEDIDA_M', 'TEMPORALIDAD_MEDIDA_A', 'MEDIDAS_OBSERVACIONES',
          DB::raw('DATE_FORMAT(med.created_at, "%Y/%m/%d %T") as created_at2'));
        break;
        case 'causas_acuerdosReparatorios':
         $sql=causas_penales\cp_salidasalternas::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_salidasalternas.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')  
            ->leftJoin('procp_sa_acuerdos as acuerdos','acuerdos.id_cp_salidasalternas','=','procp_salidasalternas.id')              
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('acuerdos.ACUERDO_REPARATORIO','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',35);
            })
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('acuerdos.ACUERDOS_REPARATORIOS','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',59);
            })
         ->leftJoin('procp_dg_imputados as pdi','procp_salidasalternas.idImputado','=','pdi.id')  
         ->leftjoin('prode_imputados as pdiDE','pdi.idImputado','=','pdiDE.id')
         ->whereNull('acuerdos.deleted_at')          
         ->whereIn('procp_salidasalternas.idExpediente',$this->IDs)
         ->select('procp_salidasalternas.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID','pdi.idImputado',
          DB::raw("CASE WHEN pdiDE.TIPO_IMPUTADO=2 THEN pdiDE.RAZON_SOCIAL WHEN pdiDE.TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN pdiDE.TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdiDE.TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(pdiDE.NOMBRE_IMPUTADO,' ', pdiDE.PRIMER_APELLIDO,' ', pdiDE.SEGUNDO_APELLIDO_IMPUTADOS) END AS imputados"),
          'cr1.Valor as ACUERDO_REPARATORIO', 'FECHA_CUMPLIMIENTO', 'FECHA_ACUERDOS_REPARATORIOS', 'cr2.Valor as ACUERDOS_REPARATORIOS', 'ACUERDOS_REPARATORIOS_OBSERVACIONES', 'MONTO_REP_DAÑO', 'REPARACION_DEL_DAÑO', 'TEMPORALIDAD',
          DB::raw('DATE_FORMAT(acuerdos.created_at, "%Y/%m/%d %T") as created_at2'));
        break; 
        case 'causas_susCondicionales':
         $sql=causas_penales\cp_salidasalternas::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_salidasalternas.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')  
            ->leftJoin('procp_sa_suspensiones as susp','susp.id_cp_salidasalternas','=','procp_salidasalternas.id')              
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('susp.TIPO_SUSPENSION','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',42);
            })
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('susp.REVOCACION_SUSPENSION','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',2);
            })
            ->leftJoin('catrespuestas as cr3', function($join)
            {
              $join->on('susp.REAPERTURA','=','cr3.id')
              ->Where('cr3.idTipoRespuesta','=',4);
            })
         ->leftJoin('procp_dg_imputados as pdi','procp_salidasalternas.idImputado','=','pdi.id')            
         ->leftjoin('prode_imputados as pdiDE','pdi.idImputado','=','pdiDE.id')
         ->whereNull('susp.deleted_at')          
         ->whereIn('procp_salidasalternas.idExpediente',$this->IDs)
         ->select('procp_salidasalternas.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID','pdi.idImputado',
          DB::raw("CASE WHEN pdiDE.TIPO_IMPUTADO=2 THEN pdiDE.RAZON_SOCIAL WHEN pdiDE.TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN pdiDE.TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdiDE.TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(pdiDE.NOMBRE_IMPUTADO,' ', pdiDE.PRIMER_APELLIDO,' ', pdiDE.SEGUNDO_APELLIDO_IMPUTADOS) END AS imputados"),

          'FECHA_SUSPENSION', 'cr1.Valor as TIPO_SUSPENSION', 'SUSPENSION_OBSERVACIONES', 'FECHA_CUMPL', 'cr2.Valor as REVOCACION_SUSPENSION', 'MOTIVO_REVOCACION', 
          'cr3.Valor as REAPERTURA', 'FECHA_REAPERTURA',
          DB::raw('DATE_FORMAT(susp.created_at, "%Y/%m/%d %T") as created_at2'));
        break;    
        case 'causas_suspension':
          $sql=causas_penales\cp_suspensionsobreseimiento::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_suspensionsobreseimiento.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')    
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('procp_suspensionsobreseimiento.CAUSA_PROCESO','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',33);
            })  
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('procp_suspensionsobreseimiento.REAPERTURA_PROCESO','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',2);
            })
         ->whereIn('procp_suspensionsobreseimiento.idExpediente',$this->IDs)
         ->select('procp_suspensionsobreseimiento.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID',
          'FECHA_SUSPENSION','cr1.Valor  as CAUSA_PROCESO', 'cr2.Valor  as REAPERTURA_PROCESO', 'FECHA_DE_REANUDACION',
          DB::raw('DATE_FORMAT(procp_suspensionsobreseimiento.created_at, "%Y/%m/%d %T") as created_at2'));
        break;                     
        case 'causas_etapaIntermedia':
         $sql=causas_penales\cp_etapaintermedia::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_etapaintermedia.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')    
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('procp_etapaintermedia.ACUSACION','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',4);
            })  
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('procp_etapaintermedia.INTERMEDIA','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',4);
            })                               
            ->leftJoin('catrespuestas as cr3', function($join)
            {
              $join->on('procp_etapaintermedia.MEDIO_PRUEBA','=','cr3.id')
              ->Where('cr3.idTipoRespuesta','=',4);
            })  
            ->leftJoin('catrespuestas as cr4', function($join)
            {
              $join->on('procp_etapaintermedia.ACUERDOS_PROP','=','cr4.id')
              ->Where('cr4.idTipoRespuesta','=',4);
            })   
            ->leftJoin('catrespuestas as cr5', function($join)
            {
              $join->on('procp_etapaintermedia.JUICIO_ORAL','=','cr5.id')
              ->Where('cr5.idTipoRespuesta','=',4);
            })            
         ->whereIn('procp_etapaintermedia.idExpediente',$this->IDs)
         ->select('procp_etapaintermedia.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID',
          'cr1.Valor  as ACUSACION', 'FECHA_ESCRITO_ACUS', 'cr2.Valor  as INTERMEDIA', 'FECHA_AUDIENCIA_INTERMEDIA', 'SUSPENSION_DE_AUDIENCIA', 'CAUSAS_SUSPENSION_INTERMEDIA', 'FECHA_DE_REANUDACION_INTERMEDIA', 'cr3.Valor  as MEDIO_PRUEBA', 'cr4.Valor  as ACUERDOS_PROP', 'cr5.Valor  as JUICIO_ORAL', 'AUTO_DE_APERTURA', 'FECHA_AUDIENCIA_JUICIO',
          DB::raw('DATE_FORMAT(procp_etapaintermedia.created_at, "%Y/%m/%d %T") as created_at2'));
        break;  
        case 'causas_mediosPruebas':
         $sql=causas_penales\cp_ei_medios::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_ei_medios.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')    
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('procp_ei_medios.MEDIOS_PRUEBAS','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',54);
            })
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('procp_ei_medios.MEDIOS_PRUEBAS_PE','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',83);
            })
            // ->leftJoin('catrespuestas as cr3', function($join)
            // {
            //   $join->on('procp_ei_medios.ACUERDOS_REPARATORIOS','=','cr3.id')
            //   ->Where('cr3.idTipoRespuesta','=',2);
            // })
         ->whereIn('procp_ei_medios.idExpediente',$this->IDs)
         ->select('procp_ei_medios.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID',
          'cr1.Valor as MEDIOS_PRUEBAS','cr2.Valor as MEDIOS_PRUEBAS_PE',//'cr3.Valor as ACUERDOS_REPARATORIOS',
          DB::raw('DATE_FORMAT(procp_ei_medios.created_at, "%Y/%m/%d %T") as created_at2'));
        break;  
        case 'causas_suspensionJuicio':
         $sql=causas_penales\cp_jo_suspension::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_jo_suspension.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')    
         ->whereIn('procp_jo_suspension.idExpediente',$this->IDs)
         ->select('procp_jo_suspension.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID',
          'FECHA_SUSPENSION','CAUSAS_SUSPENSION','REANUDACION_JUICIO',
          DB::raw('DATE_FORMAT(procp_jo_suspension.created_at, "%Y/%m/%d %T") as created_at2'));
        break;  
        case 'causas_pruebas':
         $sql=causas_penales\cp_jo_pruebas::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_jo_pruebas.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('procp_jo_pruebas.TIPOS_DE_PRUEBAS','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',68);
            })
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('procp_jo_pruebas.ACTOR_PRUEBAS','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',84);
            })            
         ->whereIn('procp_jo_pruebas.idExpediente',$this->IDs)
         ->select('procp_jo_pruebas.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID',
          'cr1.Valor as TIPOS_DE_PRUEBAS','cr2.Valor as ACTOR_PRUEBAS','FECHA_PRUEBAS','CANTIDAD',
          DB::raw('DATE_FORMAT(procp_jo_pruebas.created_at, "%Y/%m/%d %T") as created_at2'));
        break;  
        case 'causas_recursos':
         $sql=causas_penales\cp_recursos::leftJoin('procp_datosgenerales as causa','causa.id','=','procp_recursos.idCausa')
            ->leftJoin('prode_datosgenerales as pdg','pdg.id','=','causa.idExpediente')    
            ->leftJoin('procp_dg_imputados as pdi','procp_recursos.idImputado','=','pdi.id')
            ->leftjoin('prode_imputados as pdiDE','pdi.idImputado','=','pdiDE.id')
            ->leftJoin('procp_re_recursos as recursos','recursos.id_cp_recursos','=','procp_recursos.id')
            ->leftJoin('catrespuestas as cr1', function($join)
            {
              $join->on('recursos.TIPO_DE_RECURSO','=','cr1.id')
              ->Where('cr1.idTipoRespuesta','=',39);
            })
            ->leftJoin('catrespuestas as cr2', function($join)
            {
              $join->on('recursos.RESOLUCION_DEL_RECURSO','=','cr2.id')
              ->Where('cr2.idTipoRespuesta','=',85);
            })
         ->whereNull('recursos.deleted_at')
         ->whereIn('procp_recursos.idExpediente',$this->IDs)
         ->select('procp_recursos.id', 'causa.idExpediente','pdg.NUC_COMPLETA', 'causa.CAUSA_PENAL_ID','pdi.idImputado',
          DB::raw("CASE WHEN pdiDE.TIPO_IMPUTADO=2 THEN pdiDE.RAZON_SOCIAL WHEN pdiDE.TIPO_IMPUTADO=3 THEN 'LA SOCIEDAD' WHEN pdiDE.TIPO_IMPUTADO=5 THEN 'SIN IDENTIFICAR/DESCONOCIDO' WHEN pdiDE.TIPO_IMPUTADO=7 THEN 'LA SALUD' ELSE CONCAT(pdiDE.NOMBRE_IMPUTADO,' ', pdiDE.PRIMER_APELLIDO,' ', pdiDE.SEGUNDO_APELLIDO_IMPUTADOS) END AS imputados"),
          'FECHA_RECURSO','cr1.Valor as TIPO_DE_RECURSO','cr2.Valor as RESOLUCION_DEL_RECURSO',
          DB::raw('DATE_FORMAT(recursos.created_at, "%Y/%m/%d %T") as created_at2'));
        break;
       #endregion       
      }   

      return $sql;

    }
}
