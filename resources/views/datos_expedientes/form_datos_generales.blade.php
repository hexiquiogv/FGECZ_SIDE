
<form method='post' name="frmDatosGenerales" id="frmDatosGenerales" action="{{ route('save') }}" enctype="multipart/form-data">
 <div class="row"> 
  @csrf  
  <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
  <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_delegacion" class="form-label">Delegación:</label>
    <select class="form-select" name="expediente_delegacion" id="expediente_delegacion" aria-label="Delegación">
      <option value="-1">Seleccione una opción</option>
      @foreach ($respuestas['delegaciones'] as $item)      
        <option value="{{ $item->id }}" {{isset($datos->DELEGACION)?$datos->DELEGACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>
      @endforeach 
   </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_municipio" class="form-label">Municipio:</label>
    <select class="form-select" name="expediente_municipio" id="expediente_municipio" aria-label="Municipio">
      <option value="-1">Seleccione una opción</option>
      @foreach ($respuestas['municipiosDel'] as $item)
        <option value="{{ $item->id }}" {{isset($datos->MUNICIPIO)?$datos->MUNICIPIO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach 
    </select>
  </div>
  <div class="mb-3 col-12 col-md-6 col-lg-4">
    <label for="expediente_unidad_atencion" class="form-label">Unidad de Atención Temprana:</label>
    <select class="form-select" name="expediente_unidad_atencion" id="expediente_unidad_atencion" aria-label="Unidad de Atención">
    <option value="-1">Seleccione una opción</option>
      @foreach ($respuestas['uats'] as $item)      
        <option value="{{ $item->id }}" {{isset($datos->UNIDAD_ATENCION)?$datos->UNIDAD_ATENCION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach 
    </select>
  </div> 

  <div class="mb-3 col-sm-12 col-md-6">
    <label for="expediente_fecha_inicio_carpeta" class="form-label">Fecha de inicio de la carpeta:</label>
    <input type="date" class="form-control" name="expediente_fecha_inicio_carpeta"  id="expediente_fecha_inicio_carpeta" 
    value="{{$datos->FECHA_INICIO_CARPETA ?? ''}}">
  </div>  
  <div class="mb-3 col-sm-12 col-md-6">
    <label for="expediente_hora_apertura_carpeta" class="form-label">Hora de apertura de la carpeta:</label>
    <input type="text" class="form-control horaMask" name="expediente_hora_apertura_carpeta" id="expediente_hora_apertura_carpeta" placeholder="hh:mm"
    value="{{hex2bin($idExp) == 0 ? Carbon\Carbon::now()->format('H:i') : $datos->HORA_APERTURA_CARPETA??''}}">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
    <label for="expediente_fecha_hechos" class="form-label">Fecha de los hechos:</label>
    <input type="date" class="form-control" name="expediente_fecha_hechos" id="expediente_fecha_hechos" value="{{$datos->FECHA_HECHOS??''}}">
  </div> 
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="expediente_hora_hechos" class="form-label">Hora de los hechos:</label>
      <input type="text" class="form-control horaMask" name="expediente_hora_hechos" id="expediente_hora_hechos" 
      placeholder="hh:mm" value="{{$datos->HORA_HECHOS??''}}">
  </div>

  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
     <label for="expediente_nuc" class="form-label">N.U.C:</label>
    <input {{$idExp=="30"?"":"disabled"}} type="text" class="form-control" name="expediente_nuc" id="expediente_nuc" 
    placeholder="AAA/AA/AA/AAA/aaaa/AA-XXXXX" value="{{$datos->NUC_COMPLETA??''}}">
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_numero_expediente" class="form-label">No. de expediente:</label>
    <input type="text" class="form-control" name="expediente_numero_expediente" id="expediente_numero_expediente" 
    placeholder="" value="{{$datos->NO_EXPEDIENTE??''}}">
  </div>
  <!--<div class="mb-3 col-sm-12 col-md-6">
    <label for="expediente_H_carpeta_id" class="form-label">Número de la carpeta de investigación:</label>
    <input type="text" class="form-control" name="expediente_H_carpeta_id" id="expediente_H_carpeta_id" placeholder=""
    value="">
  </div> -->
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="expediente_H_estatus_carpeta" class="form-label">Estatus de la carpeta de investigación:</label>
      <select class="form-select" name="expediente_H_estatus_carpeta" id="expediente_H_estatus_carpeta" aria-label="Estatus carpeta">
      <option value="-1">Seleccione una opción</option>
        @foreach ($respuestas['estatusCarpeta'] as $item)      
          <option value="{{ $item->id }}" {{isset($datos->ESTATUS_CARPETA)?$datos->ESTATUS_CARPETA==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
      </select>
  </div> 

  {{--<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_H_nombre_fiscalia" class="form-label">Nombre de la Fiscalía:</label>
    <input type="text" class="form-control nonum" name="expediente_H_nombre_fiscalia" id="expediente_H_nombre_fiscalia" placeholder=""
    value="{{$datos->NOMBRE_FISCALIA??''}}">
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_H_tipo_fiscalia" class="form-label">Tipo de Fiscalía:</label>
    <input type="text" class="form-control nonum" name="expediente_H_tipo_fiscalia" id="expediente_H_tipo_fiscalia" placeholder=""
    value="{{$datos->TIPO_FISCALIA??''}}">
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_H_mp_num" class="form-label">No. de la agencia del Ministerio Público:</label>
    <input type="text" class="form-control noletra" name="expediente_H_mp_num" id="expediente_H_mp_num" placeholder=""
    value="{{$datos->MP_NUM??''}}">
  </div>--}}
  {{--
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="expediente_H_mp_nom" class="form-label">Nombre de la agencia del <br/>Ministerio Público:</label>
      <input type="text" class="form-control nonum" name="expediente_H_mp_nom" id="expediente_H_mp_nom" placeholder=""
      value="{{$datos->MP_NOM??''}}">
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="expediente_H_tipo_mp" class="form-label">Tipo de agencia del Ministerio Público:</label>
      <input type="text" class="form-control nonum noValidate" name="expediente_H_tipo_mp" id="expediente_H_tipo_mp" placeholder=""
      value="{{$datos->TIPO_MP??''}}">
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="expediente_H_ubicacion_mp" class="form-label">Ubicación de la agencia del Ministerio Público:</label>
      <input type="text" class="form-control alfanum" name="expediente_H_ubicacion_mp" id="expediente_H_ubicacion_mp" placeholder=""
      value="{{$datos->UBICACION_MP??''}}">
    </div>  
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="expediente_H_agente_id" class="form-label">ID del agente del M.P. responsable:</label>
      <input type="text" class="form-control alfanum" name="expediente_H_agente_id" id="expediente_H_agente_id" placeholder="" 
      value="{{$datos->AGENTE_ID??''}}">
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="expediente_H_nombre_agente_mp" class="form-label">Nombre del agente del M.P. responsable:</label>
      <input type="text" class="form-control nonum" name="expediente_H_nombre_agente_mp" id="expediente_H_nombre_agente_mp" placeholder=""
      value="{{$datos->NOMBRE_AGENTE_MP??''}}">
    </div>
  --}}
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 d-none">
    <label for="expediente_H_forma_" class="form-label">¿Con o sin detenido?</label>
    <select class="form-select" name="expediente_H_forma_" id="expediente_H_forma_">
    <option value="-1">Seleccione una opción</option>
      @foreach ($respuestas['formaInicioCarpeta'] as $item)      
        <option value="{{ $item->id }}" {{isset($datos->FORMA_)?$datos->FORMA_==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach 
   </select>
  </div>  
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_H_aseguramiento" class="form-label">Aseguramientos:</label>
    <select class="form-select" name="expediente_H_aseguramiento" id="expediente_H_aseguramiento">
      <option value="-1">Seleccione una opción</option>
      @foreach ($respuestas['SiNoNoI'] as $item)      
        <option value="{{ $item->id }}" {{isset($datos->ASEGURAMIENTO)?$datos->ASEGURAMIENTO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach 
    </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_H_tipo_de_bien" class="form-label">Tipo de bien asegurado:</label>
    <input type="text" class="form-control nonum noValidate" name="expediente_H_tipo_de_bien" id="expediente_H_tipo_de_bien" value="{{$datos->TIPO_DE_BIEN??''}}">
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_H_oportunidad" class="form-label">Tipo de criterios de oportunidad:</label>
    <select class="form-select noValidate" name="expediente_H_oportunidad" id="expediente_H_oportunidad">
      <option value="-1">Seleccione una opción</option>
      @foreach ($respuestas['tipoCriterio'] as $item)
        <option value="{{ $item->id }}" {{isset($datos->OPORTUNIDAD)?$datos->OPORTUNIDAD==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach 
   </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_H_etapa_proces" class="form-label">Etapa procesal en que se encuentra la carpeta de investigación:</label>
    <select class="form-select noValidate" name="expediente_H_etapa_proces" id="expediente_H_etapa_proces">
      <option value="-1">Seleccione una opción</option>
      @foreach ($respuestas['etapaProc'] as $item)
        <option value="{{ $item->id }}" {{isset($datos->ETAPA_PROCES)?$datos->ETAPA_PROCES==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach       
   </select>
  </div>   
  <!--   <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_H_id_seguimiento" class="form-label">ID Seguimiento del caso:</label>
    <input type="text" class="form-control alfanum" name="expediente_H_id_seguimiento" id="expediente_H_id_seguimiento" placeholder=""
    value="{{$datos->ID_SEGUIMIENTO??''}}">
  </div> -->
  <div class="mb-4 col-12 pestanaBase">
  <div class="pestanaTop">
      <h4>Lugar de los hechos</h4>
    </div>
  </div>

  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_entidad_hechos" class="form-label">Entidad:</label>
    <select class="form-select" name="expediente_entidad_hechos" id="expediente_entidad_hechos" aria-label="Entidad">
      <option value="-1">Seleccione una opción</option>
        @foreach ($respuestas['entidades'] as $item)      
          <option value="{{ $item->id }}" {{isset($datos->ENTIDAD_HECHOS)?$datos->ENTIDAD_HECHOS==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
   </select>
  </div> 
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_municipio_hechos" class="form-label">Municipio:</label>
    <select class="form-select" name="expediente_municipio_hechos" id="expediente_municipio_hechos" aria-label="Municipio">
      <option value="-1">Seleccione una opción</option>
        @foreach ($respuestas['municipios'] as $item)      
          <option value="{{ $item->id }}" {{isset($datos->MUNICIPIO_HECHOS)?$datos->MUNICIPIO_HECHOS==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
   </select>
  </div> 
  {{--    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="expediente_colonia_hechos" class="form-label">Colonia:</label>
      <select class="form-select" name="expediente_colonia_hechos" id="expediente_colonia_hechos" aria-label="Colonia">
      <option value="-1">Seleccione una opción</option>
        @foreach ($respuestas['colonias'] as $item)      
          <option value="{{ $item->id }}" {{isset($datos->COLONIA_HECHOS)?$datos->COLONIA_HECHOS==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
     </select>
    </div>  --}}
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_colonia_hechos" class="form-label">Colonia:</label>
    <input type="text" class="form-control alfanum" name="expediente_colonia_hechos" id="expediente_colonia_hechos" 
    value="{{$datos->COLONIA_HECHOS??''}}">
  </div>
  <div class="mb-3 col-sm-12 col-md-8">
    <label for="expediente_calle_hechos" class="form-label">Calle y número:</label>
    <input type="text" class="form-control alfanum noValidate" name="expediente_calle_hechos" id="expediente_calle_hechos" placeholder="" value="{{$datos->CALLE_HECHOS??''}}">
  </div>
  <div class="mb-3 col-sm-12 col-md-4">
    <label for="expediente_CP" class="form-label">C.P.:</label>
    <input type="text" class="form-control noValidate" name="expediente_CP" id="expediente_CP" placeholder="" value="{{$datos->CP??''}}">
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_ref_1" class="form-label">Referencia 1:</label>
    <input type="text" class="form-control alfanum noValidate" name="expediente_ref_1" id="expediente_ref_1" placeholder="" value="{{$datos->REF_1??''}}">
  </div>        
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_ref_2" class="form-label">Referencia 2:</label>
    <input type="text" class="form-control alfanum noValidate" name="expediente_ref_2" id="expediente_ref_2" placeholder="" value="{{$datos->REF_2??''}}">
  </div>  
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_H_medio_de_conocimiento" class="form-label">Medio de conocimiento de los hechos:</label>
    <select class="form-select" name="expediente_H_medio_de_conocimiento" id="expediente_H_medio_de_conocimiento">
      <option value="-1">Seleccione una opción</option>
        @foreach ($respuestas['medioCon'] as $item)      
          <option value="{{ $item->id }}" {{isset($datos->MEDIO_DE_CONOCIMIENTO)?$datos->MEDIO_DE_CONOCIMIENTO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach    
    </select>
  </div>
  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Recepción de denuncia</h4>
    </div>
  </div>
 
  {{--<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_unidad_que_recibe" class="form-label">Unidad que recibe:</label>
    <input type="text" class="form-control alfanum" name="expediente_unidad_que_recibe" id="expediente_unidad_que_recibe" placeholder="" value="{{$datos->UNIDAD_QUE_RECIBE??''}}">
  </div>  --}}
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_unidad_que_recibe" class="form-label">Unidad que recibe:</label>
    <select class="form-select" name="expediente_unidad_que_recibe" id="expediente_unidad_que_recibe">
    <option value="-1">Seleccione una opción</option>
      @foreach ($respuestas['UnidadQueRecibe'] as $item)      
        <option value="{{ $item->id }}" {{isset($datos->UNIDAD_QUE_RECIBE)?$datos->UNIDAD_QUE_RECIBE==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>
      @endforeach 
    </select>
  </div>  
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_recibida_por" class="form-label">Recibida por:</label>
    <select class="form-select" name="expediente_recibida_por" id="expediente_recibida_por" aria-label="RecibidaPor">
      <option value="-1">Seleccione una opción</option>
        @foreach ($respuestas['recibida_por'] as $item)      
          <option value="{{ $item->id }}" {{isset($datos->RECIBIDA_POR)?$datos->RECIBIDA_POR==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
    </select>
  </div> 
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 recibidaPorShow" style="display:none;">
    <label for="expediente_medio_recepcion" class="form-label">Medio de recepción</label>
    <select class="form-select" name="expediente_medio_recepcion" id="expediente_medio_recepcion" aria-label="Querella">
      <option value="-1">Seleccione una opción</option>
        @foreach ($respuestas['medio_recepcion'] as $item)      
          <option value="{{ $item->id }}" {{isset($datos->MEDIO_RECEPCION)?$datos->MEDIO_RECEPCION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
   </select>
  </div> 
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 d-none">
    <label for="expediente_tipo_recepcion" class="form-label">¿Es querella?</label>
    <select class="form-select" name="expediente_tipo_recepcion" id="expediente_tipo_recepcion" aria-label="Querella">
      <option value="-1">Seleccione una opción</option>
        @foreach ($respuestas['tipo_recepcion'] as $item)      
          <option value="{{ $item->id }}" {{isset($datos->TIPO_RECEPCION)?$datos->TIPO_RECEPCION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
   </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_H_autoridad" class="form-label">Autoridad que recibió la denuncia o querella:</label>
    <select class="form-select noValidate" name="expediente_H_autoridad" id="expediente_H_autoridad" aria-label="Querella">
      <option value="-1">Seleccione una opción</option>
        @foreach ($respuestas['autoridad'] as $item)      
          <option value="{{ $item->id }}" {{isset($datos->AUTORIDAD)?$datos->AUTORIDAD==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
   </select>
  </div>  
  {{--
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="expediente_H_fecha_denuncia" class="form-label">Fecha de presentación de la denuncia o querella:</label>
      <input type="date" class="form-control" name="expediente_H_fecha_denuncia" id="expediente_H_fecha_denuncia" value="{{$datos->FECHA_DENUNCIA??''}}">
    </div> 
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="expediente_H_hora_denuncia" class="form-label">Hora de presentación de la denuncia o querella:</label>
      <input type="text" class="form-control horaMask" name="expediente_H_hora_denuncia" id="expediente_H_hora_denuncia" placeholder="hh:mm" 
      value="{{$datos->HORA_DENUNCIA??''}}">  
    </div> 
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="expediente_autoridad_iph" class="form-label">Autoridad que entrega el IPH (si aplica):</label>
      <input type="text" class="form-control alfanum" name="expediente_autoridad_iph" id="expediente_autoridad_iph" value="{{$datos->AUTORIDAD_IPH??''}}">
    </div>
  --}}
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_autoridad_iph" class="form-label">Autoridad que entrega el IPH (si aplica):</label>
    <select class="form-select noValidate" name="expediente_autoridad_iph" id="expediente_autoridad_iph">
      <option value="-1">Seleccione una opción</option>
      @foreach ($respuestas['autDetencion'] as $item)      
        <option value="{{ $item->id }}" 
          {{isset($datos->AUTORIDAD_IPH)?$datos->AUTORIDAD_IPH==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>     
      @endforeach 
   </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_H_reactivacion" class="form-label">Reactivación de carpeta de investigación:</label>
    <select class="form-select noValidate" name="expediente_H_reactivacion" id="expediente_H_reactivacion">
      <option value="-1">Seleccione una opción</option>
      @foreach ($respuestas['SiNoNoI'] as $item)      
        <option value="{{ $item->id }}" {{isset($datos->REACTIVACION)?$datos->REACTIVACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>     
      @endforeach 
   </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 archivoTemp" style="display:none;">
    <label for="causa_H_motivo_reactivacion" class="form-label">Motivo de la reactivación:</label>
    <select class="form-select" name="causa_H_motivo_reactivacion" id="causa_H_motivo_reactivacion">
      <option value="-1">Seleccione una opción</option>
      @foreach ($respuestas['motivoReac'] as $item)      
        <option value="{{ $item->id }}" {{isset($datos->MOTIVO_REACTIVACION)?$datos->MOTIVO_REACTIVACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach 
   </select>
  </div>
  <!--   <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="expediente_parentesco" class="form-label">Parentesco:</label>
    <select class="form-select" name="expediente_parentesco" id="expediente_parentesco" aria-label="Parentesco">
      <option value="-1">Seleccione una opción</option>
        @foreach ($respuestas['parentesco'] as $item)      
          <option value="{{ $item->id }}" {{isset($datos->PARENTESCO)?$datos->PARENTESCO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
   </select>
  </div> -->
  <div class="mb-3 col-12">
    <label for="expediente_descripcion" class="form-label">Descripción o narración de los hechos:</label>
    <textarea  type="textarea" class="form-control" rows="3" name="expediente_descripcion" id="expediente_descripcion">{{$datos->DESCRIPCION??''}}</textarea>
  </div> 
  <div class="mb-3 col-12">
    <label for="expediente_H_observaciones" class="form-label">Observaciones:</label>
    <textarea  type="textarea" class="form-control noValidate" rows="3" name="expediente_H_observaciones" id="expediente_H_observaciones">{{$datos->OBSERVACIONES??''}}</textarea>
  </div>   
 </div>
 <div class="border-top pt-2 modal-footer">
  <button type="submit" class="btn btn-primary">Guardar</button>
 </div> 
</form>   


<script type="text/javascript">
  $("#frmDatosGenerales").on("submit",function(){
    var respuesta=true;
    var campos=[];
      $("#frmDatosGenerales input:not(.noValidate):visible").each(function(){
        if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}
      });      
      
      $("#frmDatosGenerales select:not(.noValidate):visible").each(function(){
        if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}        
      }); 
      $("#frmDatosGenerales textarea:not(.noValidate):visible").each(function(){
        if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}        
      });     
      if (!respuesta) {
        showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
      }           
    return respuesta;
  });
    // $("#expediente_numero_expediente").mask("00000/AAA/AAA/AAAA");
  $("#expediente_numero_expediente").mask("CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC",
    {translation: {'C': {pattern: /[0-9a-zA-Z\s\/\-]/}}});
    // $("#expediente_nuc").mask("AAA/AA/AA/AAA/AAAA/AA-00000");
  $("#expediente_nuc").mask("CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC",
    {translation: {'C': {pattern: /[0-9a-zA-Z\s\/\-]/}}});
  $("#expediente_H_carpeta_id").mask("00000000");
  $(".horaMask").mask("00:00");
  $("#expediente_CP").mask("00000");
  ////$("#expediente_H_reactivacion").val({{isset($datos->REACTIVACION)?$datos->REACTIVACION:-1}});
  $(".archivoTemp").hide();
  if($("#expediente_H_reactivacion").val()==1){
    $(".archivoTemp").show();
  }
  $("#expediente_H_reactivacion").change(function(){                   
    $(".archivoTemp").hide();
    $(".archivoTemp select").val(-1);
    if(this.value==1)
    {
      $(".archivoTemp").show();
    }                            
  });  

  if($("#expediente_recibida_por").val()==1 || $("#expediente_recibida_por").val()==2){
    $(".recibidaPorShow").show();}
  else{
    $(".recibidaPorShow").hide();}
  
  $("#expediente_recibida_por").change(function(){    
    $("#expediente_medio_recepcion").val(-1);
    if($("#expediente_recibida_por").val()==1 || $("#expediente_recibida_por").val()==2)
    {$(".recibidaPorShow").show();}
    else
    {$(".recibidaPorShow").hide();}
  });

  $("#expediente_entidad_hechos").change(function(){
    var delId=this.value;
    $("#expediente_municipio_hechos").html("");
    $('#expediente_colonia_hechos').html('<option value="-1">Seleccione una opción</option>');
    var params = new Object();
    params.Entidad = delId;
    params._token = '{{csrf_token()}}';
    params = JSON.stringify(params);
    $.ajax({      
        url: "{{Route('getME')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {
            $('#expediente_municipio_hechos').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.municipios, function (key, value) {
                $("#expediente_municipio_hechos").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });
  });
  $("#expediente_municipio_hechos").change(function(){
    var delId=this.value;
    $("#expediente_colonia_hechos").html("");
    var params = new Object();
    params.idMun = delId;
    params._token = '{{csrf_token()}}';
    params = JSON.stringify(params);
    $.ajax({      
        url: "{{Route('getCol')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {
            $('#expediente_colonia_hechos').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.colonias, function (key, value) {
                $("#expediente_colonia_hechos").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });
  });
  $("#expediente_delegacion").change(function(){
    var delId=this.value;
    $("#expediente_municipio").html("");
    var params = new Object();
    params.Delegacion = delId;
    params._token = '{{csrf_token()}}';
    params = JSON.stringify(params);
    $.ajax({      
        url: "{{Route('getM')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {
            $('#expediente_municipio').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.municipios, function (key, value) {
                $("#expediente_municipio").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });
  });  
</script>
