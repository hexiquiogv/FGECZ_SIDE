<form method='post' name="frmDatosGenerales" id="frmDatosGenerales" action="{{ route('save') }}" enctype="multipart/form-data">
  <div class="row">
    @csrf  
    <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
    <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="conduccion_delegacion" class="form-label">Delegación:</label>
        <select class="form-select" name="conduccion_delegacion" id="conduccion_delegacion" aria-label="Delegación">
          <option value="-1">Seleccione una opción</option>
          @foreach ($delegaciones as $item)      
            <option value="{{ $item->id }}" {{isset($datos->DELEGACION)?$datos->DELEGACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>
          @endforeach 
       </select>
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="conduccion_municipio" class="form-label">Municipio:</label>
        <select class="form-select" name="conduccion_municipio" id="conduccion_municipio" aria-label="Municipio">
          <option value="-1">Seleccione una opción</option>
          @foreach ($municipiosDel as $item)      
            <option value="{{ $item->id }}" {{isset($datos->MUNICIPIO)?$datos->MUNICIPIO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>
          @endforeach 
       </select>
    </div>
    {{--<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="conduccion_unidad_atencion" class="form-label">Unidad de Atención Temprana:</label>
        <select class="form-select" name="conduccion_unidad_atencion" id="conduccion_unidad_atencion" aria-label="Unidad de Atención">
        <option value="-1">Seleccione una opción</option>
          @foreach ($uats as $item)      
            <option value="{{ $item->id }}" {{isset($datos->UNIDAD_ATENCION)?$datos->UNIDAD_ATENCION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>
          @endforeach 
        </select>
    </div>--}}
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  		<label for="conduccion_fecha_inicio_conduccion" class="form-label">Fecha de inicio:</label>
  		<input type="date" class="form-control" name="conduccion_fecha_inicio_conduccion" id="conduccion_fecha_inicio_conduccion" 
      value="{{$datos->FECHA_INICIO_CONDUCCION??''}}">
  	</div> 
  	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  		<label for="conduccion_fecha_hechos_conduccion" class="form-label">Fecha de hechos:</label>
  		<input type="date" class="form-control" name="conduccion_fecha_hechos_conduccion" id="conduccion_fecha_hechos_conduccion" 
      value="{{$datos->FECHA_HECHOS_CONDUCCION??''}}">
  	</div> 
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="conduccion_hora_hechos" class="form-label">Hora de los hechos:</label>
        <input type="text" class="form-control horaMask" name="conduccion_hora_hechos" id="conduccion_hora_hechos" placeholder="hh:mm" 
        value="{{$datos->HORA_HECHOS??''}}">
    </div>		
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  		<label for="conduccion_no_expediente_conduccion" class="form-label">No. Expediente:</label>
  		<input type="text" class="form-control" name="conduccion_no_expediente_conduccion" id="conduccion_no_expediente_conduccion" placeholder=""
      value="{{$datos->NO_EXPEDIENTE_CONDUCCION??''}}">
    </div>	
    <div class="mb-4 col-12 pestanaBase">
    	<div class="pestanaTop">
        <h4>Lugar de los hechos</h4>
      </div>
    </div>
  	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  	  <label for="conduccion_entidad_hechos_conduccion" class="form-label">Entidad:</label>
  	  <select class="form-select" name="conduccion_entidad_hechos_conduccion" id="conduccion_entidad_hechos_conduccion">
  		<option value="-1">Seleccione una opción</option>
          @foreach ($entidades as $item)      
            <option value="{{ $item->id }}" 
              {{isset($datos->ENTIDAD_HECHOS_CONDUCCION)?$datos->ENTIDAD_HECHOS_CONDUCCION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach 		
  	 </select>
  	</div>
  	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  	  <label for="conduccion_municipio_hechos" class="form-label">Municipio:</label>
  	  <select class="form-select" name="conduccion_municipio_hechos" id="conduccion_municipio_hechos">
  		<option value="-1">Seleccione una opción</option>
          @foreach ($municipios as $item)      
            <option value="{{ $item->id }}" {{isset($datos->MUNICIPIO_HECHOS)?$datos->MUNICIPIO_HECHOS==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach 		
  	 </select>
  	</div>
    {{--<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="conduccion_colonia_hechos" class="form-label">Colonia:</label>
      <select class="form-select" name="conduccion_colonia_hechos" id="conduccion_colonia_hechos" aria-label="Colonia">
      	<option value="-1">Seleccione una opción</option>
  	      @foreach ($colonias as $item)      
  		      <option value="{{ $item->id }}" {{isset($datos->COLONIA_HECHOS)?$datos->COLONIA_HECHOS==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
  	      @endforeach 
  		</select>
    </div>  	--}}
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="conduccion_colonia_hechos" class="form-label">Colonia:</label>
      <input type="text" class="form-control alfanum" name="conduccion_colonia_hechos" id="conduccion_colonia_hechos" 
      value="{{$datos->COLONIA_HECHOS??''}}">
    </div>
  	  <div class="mb-3 col-sm-12 col-md-8">
  			<label for="conduccion_calle_hechos_conduccion" class="form-label">Calle y número:</label>
  			<input type="text" class="form-control alfanum noValidate" name="conduccion_calle_hechos_conduccion" id="conduccion_calle_hechos_conduccion"
        value="{{$datos->CALLE_HECHOS_CONDUCCION??''}}">
  	  </div>
  	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  			<label for="conduccion_cp" class="form-label">CP:</label>
  			<input type="text" class="form-control noValidate" name="conduccion_cp" id="conduccion_cp"
        value="{{$datos->CP??''}}">
  	  </div>
  	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  			<label for="conduccion_ref_1" class="form-label">Referencia 1:</label>
  			<input type="text" class="form-control alfanum noValidate" name="conduccion_ref_1" id="conduccion_ref_1"
        value="{{$datos->REF_1??''}}">
  	  </div>
  	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  			<label for="conduccion_ref_2" class="form-label">Referencia 2:</label>
  			<input type="text" class="form-control alfanum noValidate" name="conduccion_ref_2" id="conduccion_ref_2"
        value="{{$datos->REF_2??''}}">
  	  </div>
    <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
        <h4>Recepción de denuncia</h4>
      </div>
    </div>	  
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4 d-none">
  		<label for="conduccion_unidad_que_recibe_conduccion" class="form-label">Unidad que recibe:</label>
  		<input type="text" class="form-control alfanum" name="conduccion_unidad_que_recibe_conduccion" id="conduccion_unidad_que_recibe_conduccion" 
      value="{{$datos->UNIDAD_QUE_RECIBE_CONDUCCION??''}}">
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="conduccion_unidad_atencion" class="form-label">Unidad que recibe:</label>
        <select class="form-select" name="conduccion_unidad_atencion" id="conduccion_unidad_atencion" aria-label="Unidad de Atención">
        <option value="-1">Seleccione una opción</option>
          @foreach ($UnidadQueRecibe as $item)      
            <option value="{{ $item->id }}" {{isset($datos->UNIDAD_ATENCION)?$datos->UNIDAD_ATENCION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>
          @endforeach 
        </select>
    </div>
  	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  	  <label for="conduccion_recibida_por" class="form-label">Recibida por :</label>
  	  <select class="form-select" name="conduccion_recibida_por" id="conduccion_recibida_por">
  		<option value="-1">Seleccione una opción</option> 
          @foreach ($recibida_por as $item)      
            <option value="{{ $item->id }}" {{isset($datos->RECIBIDA_POR)?$datos->RECIBIDA_POR==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach 		
  	 </select>
  	</div>
  	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  	  <label for="conduccion_tipo_recepcion" class="form-label">¿Es querella?</label>
  	  <select class="form-select" name="conduccion_tipo_recepcion" id="conduccion_tipo_recepcion">
  		<option value="-1">Seleccione una opción</option>
          @foreach ($tipo_recepcion as $item)      
            <option value="{{ $item->id }}" {{isset($datos->TIPO_RECEPCION)?$datos->TIPO_RECEPCION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach 		
  	 </select>
  	</div>

    <div class="mb-3 col-12">
      <label for="conduccion_descripcion" class="form-label">Descripción o narración de los hechos:</label>
      <textarea  type="textarea" class="form-control" rows="3" name="conduccion_descripcion" id="conduccion_descripcion" placeholder="">{{$datos->DESCRIPCION??''}}</textarea>
    </div> 
    <div class="mb-3 col-12">
      <label for="conduccion_H_observaciones" class="form-label">Observaciones:</label>
      <textarea  type="textarea" class="form-control noValidate" rows="3" name="conduccion_H_observaciones" id="conduccion_H_observaciones" placeholder="">{{$datos->OBSERVACIONES??''}}
      </textarea>
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

$(".horaMask").mask("00:00");
$("#conduccion_cp").mask("00000");
// $("#conduccion_no_expediente_conduccion").mask("00000/AAA/AAA/AAAA");
$("#conduccion_no_expediente_conduccion").mask("CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC",
  {translation: {'C': {pattern: /[0-9a-zA-Z\s\/\-]/}}});
$("#conduccion_entidad_hechos_conduccion").change(function(){
  var delId=this.value;
  $("#conduccion_municipio_hechos").html("");
  $('#conduccion_colonia_hechos').html('<option value="-1">Seleccione una opción</option>');
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
          $('#conduccion_municipio_hechos').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.municipios, function (key, value) {
              $("#conduccion_municipio_hechos").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });

  });
$("#conduccion_municipio_hechos").change(function(){
  var delId=this.value;
  $("#conduccion_colonia_hechos").html("");
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
          $('#conduccion_colonia_hechos').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.colonias, function (key, value) {
              $("#conduccion_colonia_hechos").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });

  });

  $("#conduccion_delegacion").change(function(){
  var delId=this.value;
  $("#conduccion_municipio").html("");
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
          $('#conduccion_municipio').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.municipios, function (key, value) {
              $("#conduccion_municipio").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });

  });

</script>
