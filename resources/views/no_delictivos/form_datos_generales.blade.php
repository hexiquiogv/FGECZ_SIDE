<form method='post' name="frmDatosGenerales" id="frmDatosGenerales" action="{{ route('save') }}" enctype="multipart/form-data">
  <div class="row">
    @csrf  
    <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
    <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">  
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="nod_delegacion" class="form-label">Delegación:</label>
        <select class="form-select" name="nod_delegacion" id="nod_delegacion" aria-label="Delegación">
          <option value="-1">Seleccione una opción</option>
          @foreach ($delegaciones as $item)      
            <option value="{{ $item->id }}"
              {{isset($datos->DELEGACION)?$datos->DELEGACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>
          @endforeach 
       </select>
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="nod_municipio" class="form-label">Municipio:</label>
        <select class="form-select" name="nod_municipio" id="nod_municipio" aria-label="Municipio">
          <option value="-1">Seleccione una opción</option>
          @foreach ($municipiosDel as $item)      
            <option value="{{ $item->id }}" {{isset($datos->MUNICIPIO)?$datos->MUNICIPIO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach 
       </select>
    </div>
    <div class="mb-3 col-12 col-md-6 col-lg-4">
        <label for="nod_unidad_atencion_no_delictivos" class="form-label">Unidad de Atención Temprana:</label>
        <select class="form-select" name="nod_unidad_atencion_no_delictivos" id="nod_unidad_atencion_no_delictivos" aria-label="Unidad de Atención">
      		<option value="-1">Seleccione una opción</option>
          @foreach ($uats as $item)      
            <option value="{{ $item->id }}" 
              {{isset($datos->UNIDAD_ATENCION_NO_DELICTIVOS)?$datos->UNIDAD_ATENCION_NO_DELICTIVOS==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach 
        </select>
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="nod_fecha_inicio" class="form-label">Fecha de inicio:</label>
      <input type="date" class="form-control" name="nod_fecha_inicio" id="nod_fecha_inicio" value="{{$datos->FECHA_INICIO??''}}">
    </div>   
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="nod_fecha_hechos_no_delictivos" class="form-label">Fecha de hechos:</label>
        <input type="date" class="form-control" name="nod_fecha_hechos_no_delictivos" id="nod_fecha_hechos_no_delictivos" value="{{$datos->FECHA_HECHOS_NO_DELICTIVOS??''}}">
      </div> 
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="nod_hora_hechos" class="form-label">Hora de los hechos:</label>
        <input type="text" class="form-control horaMask" name="nod_hora_hechos" id="nod_hora_hechos" placeholder="hh:mm" value="{{$datos->HORA_HECHOS??''}}">
      </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="nod_no_expediente" class="form-label">No. Expediente:</label>
      <input type="text" class="form-control" name="nod_no_expediente" id="nod_no_expediente" placeholder=""value="{{$datos->NO_EXPEDIENTE??''}}">
    </div>       
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="nod_recibida_por" class="form-label">Recibida por :</label>
      <select class="form-select" name="nod_recibida_por" id="nod_recibida_por">
      <option value="-1">Seleccione una opción</option> 
          @foreach ($recibida_por as $item)      
            <option value="{{ $item->id }}" {{isset($datos->RECIBIDA_POR)?$datos->RECIBIDA_POR==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach     
      </select>
    </div>
    <div class="mb-4 col-12"><hr></div>
    
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="nod_hecho_no_delito" class="form-label">Hecho no constitutivo de delito:</label>
      <select class="form-select" name="nod_hecho_no_delito" id="nod_hecho_no_delito">
      <option value="-1">Seleccione una opción</option>
          @foreach ($noDelitos as $item)      
            <option value="{{ $item->id }}" {{isset($datos->HECHO_NO_DELITO)?$datos->HECHO_NO_DELITO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach    
     </select>
    </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4 suicidio muerteN">
        <label for="nod_causa_muerte" class="form-label">Causa de muerte:</label>
        <input type="text" class="form-control alfanum" name="nod_causa_muerte" id="nod_causa_muerte" 
        value="{{$datos->CAUSA_MUERTE??''}}">
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4 suicidio">
        <label for="nod_motivo" class="form-label">Motivo:</label>
        <input type="text" class="form-control alfanum noValidate" name="nod_motivo" id="nod_motivo" 
        value="{{$datos->MOTIVO??''}}">
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4 suicidio">
        <label for="nod_medio_utilizado" class="form-label">Medio utlizado:</label>
        <input type="text" class="form-control alfanum noValidate" name="nod_medio_utilizado" id="nod_medio_utilizado" 
        value="{{$datos->MEDIO_UTILIZADO??''}}">
      </div>                
    <div class="mb-3 col-12">
      <label for="nod_descripcion" class="form-label">Descripción o narración de los hechos:</label>
      <textarea type="textarea" class="form-control" rows="3" name="nod_descripcion" id="nod_descripcion">{{$datos->DESCRIPCION??''}}</textarea>
    </div> 
    <div class="mb-3 col-12">
      <label for="nod_H_observaciones" class="form-label">Observaciones:</label>
      <textarea type="textarea" class="form-control noValidate" rows="3" name="nod_H_observaciones" id="nod_H_observaciones">{{$datos->OBSERVACIONES??''}}</textarea>
    </div>    
    <div class="mb-4 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Lugar de los hechos</h4>
      </div>
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="nod_entidad_hechos_no_delictivos" class="form-label">Entidad:</label>
      <select class="form-select" name="nod_entidad_hechos_no_delictivos" id="nod_entidad_hechos_no_delictivos">
      <option value="-1">Seleccione una opción</option>
          @foreach ($entidades as $item)      
            <option value="{{ $item->id }}"
              {{isset($datos->ENTIDAD_HECHOS_NO_DELICTIVOS)?$datos->ENTIDAD_HECHOS_NO_DELICTIVOS==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach    
     </select>
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="nod_municipio_hechos" class="form-label">Municipio:</label>
      <select class="form-select" name="nod_municipio_hechos" id="nod_municipio_hechos">
      <option value="-1">Seleccione una opción</option>
          @foreach ($municipios as $item)      
            <option value="{{ $item->id }}"
              {{isset($datos->MUNICIPIO_HECHOS)?$datos->MUNICIPIO_HECHOS==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach    
     </select>
    </div>
    {{--<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="nod_colonia_hechos" class="form-label">Colonia:</label>
      <select class="form-select" name="nod_colonia_hechos" id="nod_colonia_hechos" aria-label="Colonia">
        <option value="-1">Seleccione una opción</option>
          @foreach ($colonias as $item)      
            <option value="{{ $item->id }}"
              {{isset($datos->COLONIA_HECHOS)?$datos->COLONIA_HECHOS==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach 
      </select>
    </div>--}}   
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="nod_colonia_hechos" class="form-label">Colonia:</label>
      <input type="text" class="form-control alfanum" name="nod_colonia_hechos" id="nod_colonia_hechos" 
      value="{{$datos->COLONIA_HECHOS??''}}">
    </div>    
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="nod_calle_hechos_no_delictivos" class="form-label">Calle y número:</label>
        <input type="text" class="form-control alfanum noValidate" name="nod_calle_hechos_no_delictivos" id="nod_calle_hechos_no_delictivos" 
        value="{{$datos->CALLE_HECHOS_NO_DELICTIVOS??''}}">
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="nod_cp" class="form-label">CP:</label>
        <input type="text" class="form-control noValidate" name="nod_cp" id="nod_cp" 
        value="{{$datos->CP??''}}">
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="nod_ref_1" class="form-label">Referencia 1:</label>
        <input type="text" class="form-control alfanum noValidate" name="nod_ref_1" id="nod_ref_1" 
        value="{{$datos->REF_1??''}}">
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="nod_ref_2" class="form-label">Referencia 2:</label>
        <input type="text" class="form-control alfanum noValidate" name="nod_ref_2" id="nod_ref_2" 
        value="{{$datos->REF_2??''}}">
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
  // $("#nod_no_expediente").mask("00000/AAA/AAA/AAAA");
  $("#nod_no_expediente").mask("CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC",
    {translation: {'C': {pattern: /[0-9a-zA-Z\s\/\-]/}}});
  $(".horaMask").mask("00:00");
  $("#nod_cp").mask("00000");

  $(".suicidio").hide();
  $(".muerteN").hide();
    if ($("#nod_hecho_no_delito").val()==7 || $("#nod_hecho_no_delito").val()==5) {
      if ($("#nod_hecho_no_delito").val()==7) {$(".suicidio").show();}
      else if ($("#nod_hecho_no_delito").val()==5) {$(".suicidio:not('.muerteN') input").val(''); $(".muerteN").show();}
    }
    else
    { $(".suicidio input").val('');}  

  $("#nod_hecho_no_delito").change(function(){
    $(".suicidio").hide();
    $(".muerteN").hide();
    if ($("#nod_hecho_no_delito").val()==7 || $("#nod_hecho_no_delito").val()==5) {
      if ($("#nod_hecho_no_delito").val()==7) {$(".suicidio").show();}
      else if ($("#nod_hecho_no_delito").val()==5) {$(".suicidio:not('.muerteN') input").val(''); $(".muerteN").show();}
    }
    else
    { $(".suicidio input").val('');}  
  });


  $("#nod_entidad_hechos_no_delictivos").change(function(){
    var delId=this.value;
    $("#nod_municipio_hechos").html("");
    $('#nod_colonia_hechos').html('<option value="-1">Seleccione una opción</option>');
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
            $('#nod_municipio_hechos').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.municipios, function (key, value) {
                $("#nod_municipio_hechos").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });

    });
  $("#nod_municipio_hechos").change(function(){
    var delId=this.value;
    $("#nod_colonia_hechos").html("");
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
            $('#nod_colonia_hechos').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.colonias, function (key, value) {
                $("#nod_colonia_hechos").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });

    });

  $("#nod_delegacion").change(function(){
  var delId=this.value;
  $("#nod_municipio").html("");
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
          $('#nod_municipio').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.municipios, function (key, value) {
              $("#nod_municipio").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });

  });

</script>
