<form method='post' name="frmCausasPenalesDG" onsubmit="return validarFormulario(this)" id="frmCausasPenalesDG" action="{{ route('saveCP') }}" enctype="multipart/form-data">
 <div class="row causasCarpeta">
      @csrf  
    <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
    <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
    <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_numero_expediente" class="form-label">No. de expediente:</label>
    <input disabled type="text" class="form-control" name="causa_H_numero_expediente" id="causa_H_numero_expediente" placeholder="8490520108" 
    value="{{$datos->NO_EXPEDIENTE??''}}">
  </div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_nuc" class="form-label">N.U.C:</label>
    <input disabled type="text" class="form-control" name="causa_nuc" id="causa_nuc" placeholder="XX99999" value="{{$datos->NUC_COMPLETA??''}}">
  </div>  
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_causa_penal_id" class="form-label">Causa penal:</label>
    <input type="text" class="form-control" name="causa_H_causa_penal_id" id="causa_H_causa_penal_id" placeholder="" value="{{$datosCP->CAUSA_PENAL_ID??''}}">
    @if($errors->has('causa_H_causa_penal_id'))
      <span class="text-danger">{{ $errors->first('causa_H_causa_penal_id') }}</span>
    @endif
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_fecha_causa_penal" class="form-label">Fecha de inicio causa penal:</label>
    <input type="date" class="form-control" name="causa_H_fecha_causa_penal" id="causa_H_fecha_causa_penal" value="{{$datosCP->FECHA_CAUSA_PENAL??''}}">
  </div> 
  {{--COMENTADO 29/05/2023 MxCONJ01_Ajustes SIDE (Causas Penales)_20230504
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_fecha_inicio_atencion" class="form-label">Fecha de inicio de la atención:</label>
      <input type="date" class="form-control" name="causa_H_fecha_inicio_atencion" id="causa_H_fecha_inicio_atencion" value="{{$datosCP->FECHA_INICIO_ATENCION??''}}">
    </div> 
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_fecha_conclusion_atencion" class="form-label">Fecha de conclusión de la atención:</label>
      <input type="date" class="form-control" name="causa_H_fecha_conclusion_atencion" id="causa_H_fecha_conclusion_atencion" value="{{$datosCP->FECHA_CONCLUSION_ATENCION??''}}">
    </div> 
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_tipo_de_atencion" class="form-label">Tipo de atencion:</label>
      <select class="form-select" name="causa_H_tipo_de_atencion" id="causa_H_tipo_de_atencion">
        <option value="-1">Seleccione una opción</option>
        @foreach ($tipoAtencion as $item)      
          <option value="{{ $item->id }}" {{isset($datosCP->TIPO_DE_ATENCION)?$datosCP->TIPO_DE_ATENCION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
     </select>
    </div>  
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_sentido" class="form-label">Sentido de la conclusión de la atención:</label>
      <select class="form-select" name="causa_H_sentido" id="causa_H_sentido">
        <option value="-1">Seleccione una opción</option>
        @foreach ($sentidoConc as $item)      
          <option value="{{ $item->id }}" {{isset($datosCP->SENTIDO)?$datosCP->SENTIDO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
     </select>
    </div>

    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_fecha_determinacion" class="form-label">Fecha de la determinación:</label>
      <input type="date" class="form-control" name="causa_H_fecha_determinacion" id="causa_H_fecha_determinacion" value="{{$datosCP->FECHA_DETERMINACION??''}}">   
    </div> 
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_sentido_determinacion" class="form-label">Sentido de la determinación:</label>
      <select class="form-select" name="causa_H_sentido_determinacion" id="causa_H_sentido_determinacion">
        <option value="-1">Seleccione una opción</option>
        @foreach ($sentidoDete as $item)      
          <option value="{{ $item->id }}" {{isset($datosCP->SENTIDO_DETERMINACION)?$datosCP->SENTIDO_DETERMINACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
     </select>
    </div>
  --}}
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_unidad_de_investigacion" class="form-label">Unidad de investigación:</label>
      <select class="form-select" name="causa_H_unidad_de_investigacion" id="causa_H_unidad_de_investigacion">
        <option value="-1">Seleccione una opción</option>
        @foreach ($unidad as $item)      
          <option value="{{ $item->id }}" {{isset($datosCP->UNIDAD_DE_INVESTIGACION)?$datosCP->UNIDAD_DE_INVESTIGACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach         
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_distrito_judicial" class="form-label">Distrito Judicial:</label>
      <select class="form-select" name="causa_H_distrito_judicial" id="causa_H_distrito_judicial">
        <option value="-1">Seleccione una opción</option>
        @foreach ($distJud as $item)      
          <option value="{{ $item->id }}" {{isset($datosCP->DISTRITO_JUDICIAL)?$datosCP->DISTRITO_JUDICIAL==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach         
     </select>
  </div>  
  {{--COMENTADO 29/05/2023 MxCONJ01_Ajustes SIDE (Causas Penales)_20230504
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for=" causa_H_forma_" class="form-label">¿Con o sin detenido?</label>
    <select class="form-select" name=" causa_H_forma_" id=" causa_H_forma_">
    <option value="-1">Seleccione una opción</option>
        @foreach ($formaInicioCarpeta as $item)      
          <option value="{{ $item->id }}" {{isset($datos->FORMA_)?$datos->FORMA_==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach     
   </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for=" causa_H_detencion_legal_ilegal" class="form-label">Tipo de detención:</label>
    <select class="form-select" name=" causa_H_detencion_legal_ilegal" id=" causa_H_detencion_legal_ilegal">
    <option value="-1">Seleccione una opción</option>
        @foreach ($detencionLI as $item)      
          <option value="{{ $item->id }}" 
          {{isset($datosCP->DETENCION_LEGAL_ILEGAL)?
            $datosCP->DETENCION_LEGAL_ILEGAL==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>
        @endforeach
   </select>
  </div>  
  --}}  
	<div class="mb-3 col-12">
		@include("causas_penales.datos_generales.causas_acumuladas")
	</div>
	<div class="mb-3 col-12">
		@include("causas_penales.datos_generales.delitos")
	</div>
	<div class="mb-3 col-12">
		@include("causas_penales.datos_generales.victimas")
	</div>	
  <div class="mb-3 col-12">
    @include("causas_penales.datos_generales.imputados")
  </div>
  <div class="mb-3 col-12">
    @include("causas_penales.datos_generales.imputadosv2")
  </div>  
  {{--COMENTADO 29/05/2023 MxCONJ01_Ajustes SIDE (Causas Penales)_20230504 
    <div class="mb-4 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Datos MASC</h4>
      </div>
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_masc" class="form-label">El asunto se derivó a MASC?</label>
      <select class="form-select" name="causa_H_masc" id="causa_H_masc">
        <option value="-1">Seleccione una opción</option>
        @foreach ($SiNoNoI as $item)      
          <option value="{{ $item->id }}" {{isset($datosCP->MASC)?$datosCP->MASC==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>
        @endforeach   
     </select>
    </div>  
  	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 masc">
  		<label for="causa_H_fecha_deriva_masc" class="form-label">Fecha en que se deriva a MASC:</label>
  		<input type="date" class="form-control" name="causa_H_fecha_deriva_masc" id="causa_H_fecha_deriva_masc" value="{{$datosCP->FECHA_DERIVA_MASC??''}}">
  	</div>
  	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 masc">
  		<label for="causa_H_fecha_cumpl_mas" class="form-label">Fecha en que se cumplimentó el MASC:</label>
  		<input type="date" class="form-control" name="causa_H_fecha_cumpl_mas" id="causa_H_fecha_cumpl_mas" value="{{$datosCP->FECHA_DERIVA_MASC??''}}">
  	</div> 
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4 masc">
      <label for="causa_H_tipo_cumplimiento" class="form-label">Tipo de cumplimiento:</label>
      <select class="form-select" name="causa_H_tipo_cumplimiento" id="causa_H_tipo_cumplimiento">
        <option value="-1">Seleccione una opción</option>
        @foreach ($tipoCump as $item)      
          <option value="{{ $item->id }}" {{isset($datosCP->TIPO_CUMPLIMIENTO)?$datosCP->TIPO_CUMPLIMIENTO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach   
      </select>
    </div>  
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4 masc">
        <label for="causa_H_tipo_masc" class="form-label">Tipo de MASC:</label>
        <select class="form-select" name="causa_H_tipo_masc" id="causa_H_tipo_masc">
          <option value="-1">Seleccione una opción</option>
          @foreach ($tipoMASC as $item)      
            <option value="{{ $item->id }}" {{isset($datosCP->TIPO_MASC)?$datosCP->TIPO_MASC==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach  
       </select>
    </div>	
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4 masc">
      <label for="causa_H_autoridad_deriva_masc" class="form-label">Autoridad que deriva a MASC :</label>
      <select class="form-select" name="causa_H_autoridad_deriva_masc" id="causa_H_autoridad_deriva_masc">
        <option value="-1">Seleccione una opción</option>
          @foreach ($tipoMASC as $item)      
            <option value="{{ $item->id }}" {{isset($datosCP->AUTORIDAD_DERIVA_MASC)?$datosCP->AUTORIDAD_DERIVA_MASC==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach  
     </select>
    </div>
  --}}
  	<div class="mb-3 col-12"><hr></div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="causa_H_no_acuerdo_reparatorio" class="form-label">Acuerdos reparatorios:</label>
		<input disabled type="text" class="form-control" name="causa_H_no_acuerdo_reparatorio" id="causa_H_no_acuerdo_reparatorio" value="{{$noAcuerdos??''}}">
	</div>
  <!-- NUMERO DE ACUERDOS de estos de abajo -->
  <!--  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_acuerdo_reparatorio" class="form-label">Acuerdo reparatorio:</label>
      <select class="form-select" name="causa_H_acuerdo_reparatorio" id="causa_H_acuerdo_reparatorio">
        <option value="-1">Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_acuerdos_reparatorios" class="form-label">Tipo de acuerdos reparatorios:</label>
      <select class="form-select" name="causa_H_acuerdos_reparatorios" id="causa_H_acuerdos_reparatorios">
        <option value="-1">Seleccione una opción</option>
     </select>
  </div>   -->
  {{--COMENTADO 29/05/2023 MxCONJ01_Ajustes SIDE (Causas Penales)_20230504
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_tipos_de_actos_con_control" class="form-label">Tipos de actos con control judicial:</label>
      <select class="form-select" name="causa_H_tipos_de_actos_con_control" id="causa_H_tipos_de_actos_con_control">
        <option value="-1">Seleccione una opción</option>
          @foreach ($actosCon as $item)      
            <option value="{{ $item->id }}" {{isset($datosCP->TIPOS_DE_ACTOS_CON_CONTROL)?$datosCP->TIPOS_DE_ACTOS_CON_CONTROL==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach  
     </select>
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causaH_tipos_de_actos_sin_control" class="form-label">Tipos de actos sin control judicial:</label>
      <select class="form-select" name="causa_H_tipos_de_actos_sin_control" id="causa_H_tipos_de_actos_sin_control">
        <option value="-1">Seleccione una opción</option>
        @foreach ($actosSin as $item)      
          <option value="{{ $item->id }}" {{isset($datosCP->TIPOS_DE_ACTOS_SIN_CONTROL)?$datosCP->TIPOS_DE_ACTOS_SIN_CONTROL==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach   
     </select>
    </div>  
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_reapertura" class="form-label">Reapertura del proceso:</label>
      <select class="form-select" name="causa_H_reapertura" id="causa_H_reapertura">
        <option value="-1">Seleccione una opción</option>
        @foreach ($SiNoNoI as $item)      
          <option value="{{ $item->id }}" {{isset($datosCP->REAPERTURA)?$datosCP->REAPERTURA==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach         
     </select>
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_fecha_reapertura" class="form-label">Fecha de la reapertura del proceso:</label>
      <input type="date" class="form-control" name="causa_H_fecha_reapertura" id="causa_H_fecha_reapertura" value="{{$datosCP->FECHA_REAPERTURA_??''}}">
    </div>  
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_momento_reclas" class="form-label">Momento reclasificación:</label>
      <select class="form-select" name="causa_H_momento_reclas" id="causa_H_momento_reclas">
        <option value="-1">Seleccione una opción</option>
        @foreach ($momentoReclas as $item)      
          <option value="{{ $item->id }}" {{isset($datosCP->MOMENTO_RECLAS)?$datosCP->MOMENTO_RECLAS==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach         
     </select>
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_fecha_reclas" class="form-label">Fecha de reclasificación:</label>
      <input type="date" class="form-control" name="causa_H_fecha_reclas" id="causa_H_fecha_reclas" value="{{$datosCP->FECHA_RECLAS??''}}">
    </div>  
  --}}    
	<div class="mb-3 col-12">
		<label for="causa_H_observaciones" class="form-label">Observaciones:</label>
		<textarea type="textarea" class="form-control" maxlength="255" rows="3" name="causa_H_observaciones" id="causa_H_observaciones" 
    placeholder="">{{$datosCP->OBSERVACIONES??''}}</textarea>
      @if($errors->has('causa_H_observaciones'))
       <span class="text-danger">{{ $errors->first('causa_H_observaciones') }}</span>
      @endif
	</div>	
 </div>
 <div class="border-top pt-2 modal-footer">
  <button type="submit" class="btn btn-primary">Guardar</button>
 </div> 
</form>   

<div class="modal fade" id="eliminarReloadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarReloadModalLabel"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="eliminarReloadModalLabel">Eliminar permanentemente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Realmente deseas eliminar un registro anteriormente guardado?
        <input type="hidden" id="idR">
        <input type="hidden" id="idT">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:eliminarReload(0,0,true)">Eliminar</button>
      </div>
    </div>
  </div>
</div>  


<script type="text/javascript">
$("#causa_H_masc").change(function(){
  console.log(this.value);
  if (this.value==1) {$(".masc").show();}
  else
  {
    $(".masc").hide();
    $(".masc select").val(-1);
    $(".masc input").val('');
  }
});
if ($("#causa_H_masc").val()==1) {$(".masc").show();}
else
{
  $(".masc").hide();
  $(".masc select").val(-1);
  $(".masc input").val('');
}
// $("#causa_H_numero_expediente").mask("0000/AAA/AAA/AAAA");
// $("#causa_nuc").mask("AAA/AA/AA/AAA/AAAA/AA-00000");
$("#causa_H_numero_expediente").mask("CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC",
  {translation: {'C': {pattern: /[0-9a-zA-Z\s\/\-]/}}});
$("#causa_nuc").mask("CCCCCCCCCCCCCCCCCCCCCCCCCCCCCC",
  {translation: {'C': {pattern: /[0-9a-zA-Z\s\/\-]/}}});
$("#causa_H_causa_penal_id").mask("CCCCCCCCCCCCCCCCCCCC",
  {translation: {'C': {pattern: /[0-9a-zA-Z\s\/\-]/}}});
$(".nonum").mask('ZZZZ',
    {translation:  {'Z': {pattern: /[a-zA-Z\s]/, recursive: true}}});
$("#causa_H_no_acuerdo_reparatorio").mask("00");

function eliminarReload(idR,idT,modalOn=false)
{
  if (modalOn) {    
    var params = new Object();
    params.idR = $("#idR").val();
    params.idT = $("#idT").val();
    params._token = '{{csrf_token()}}';
    params = JSON.stringify(params);
    $.ajax({      
        url: "{{Route('delDataCP')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {
          if (result>0) {
            location.reload();
          }else{$("#eliminarReloadModal").modal('hide');}
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });
    
  }
  else
  {
    $("#idR").val(idR);
    $("#idT").val(idT);
    $("#eliminarReloadModal").modal('show');}
}
$("#causa_H_causa_penal_id").blur(function(){
 $("#causa_H_causa_penal_id").siblings('span').remove();
 $("#causa_H_causa_penal_id").removeClass("border-3 border-danger");
 if ($("#causa_H_causa_penal_id").val().length>0) {
  var params = new Object();    
  params._token = '{{csrf_token()}}';
  params.valor = $("#causa_H_causa_penal_id").val();
  params.idCausa = $("#idCausa").val();
  params = JSON.stringify(params);
       $.ajax({      
        url: "{{Route('CausasDuplicadas')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {
          if (!result.respuesta) {
            $('<span class="text-danger">El número de causa penal ya fue registrado</span>').insertAfter('#causa_H_causa_penal_id');
            $("#causa_H_causa_penal_id").addClass("border-3 border-danger");
          }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });
 }
});

function validarFormulario(frm)
{
  if (validSave(frm)) {return true;}
  else
  {
  showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
  event.preventDefault();
  return false; 
  }
}

  function validSave(frm)
  {
    var respuesta=true;
    var campos=[];
      $("#"+frm.id+" input:not(.noValidate):visible").each(function(){
        if (this.value.length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}
      });      
      
      $("#"+frm.id+" select:not(.noValidate):visible").each(function(){
        if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}        
      });
    var opcionesAceptables = $("#ddlImputadosMASC option:not(:disabled)").filter(function() {
            return $(this).val() > -1;
        });
    if (opcionesAceptables.length>0) {
      respuesta=false;$("#ddlImputadosMASC").addClass("border-3 border-danger");campos.push('ddlImputadosMASC'); 
      showtoast('Se deben capturar todos los imputados dados de alta en la sección "Datos MASC de Poder Judicial"','warning');
    }
    else
    {
      $("#ddlImputadosMASC").removeClass("border-3 border-danger");

    }
    var DelVicImp="Se debe agregar a la causa por lo menos: ";
    var DelVicImpBool=false;
    if($("#tbDelitosCP tbody tr").length <1)
    {
      DelVicImp+="<br/>un delito";
      DelVicImpBool=true;
    }
    if($("#tbVitimasCP tbody tr").length <1)
    {
      DelVicImp+="<br/>una víctima";
      DelVicImpBool=true;
    }
    if($("#tbImputadosCP tbody tr").length <1)
    {
      DelVicImp+="<br/>un imputado";
      DelVicImpBool=true;
    }
    
    if (DelVicImpBool) {respuesta=false; showtoast(DelVicImp,'danger_dvi');}
    return respuesta;
  }
</script>
