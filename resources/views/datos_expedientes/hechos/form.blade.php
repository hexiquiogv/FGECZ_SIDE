<form method='post' name="frmDE_D" id="frmDE_D" action="{{ route('save') }}" enctype="multipart/form-data">
  @csrf        
  <input type="hidden" name="idDelito" id="idDelito" value="">
  <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
  <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">	
 <div class="row">
	<div class="mb-4 col-12 pestanaBase">
	  <div class="pestanaTop">
	    <h4>Delito clasificación estadística</h4>
	  </div>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_ordenamiento" class="form-label">Ordenamiento:</label>
	  <select class="form-select" name="Delitos_ordenamiento" id="Delitos_ordenamiento"
 		aria-label="Ordenamiento">
	    <option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_delito_general" class="form-label">Delito general:</label>
	  <select class="form-select" name="Delitos_delito_general" id="Delitos_delito_general"
 		aria-label="general">
	    <option value="-1">Seleccione una opción</option>
	 </select>
	</div>  
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_delito_especifico" class="form-label">Delito específico:</label>
	  <select class="form-select" name="Delitos_delito_especifico" id="Delitos_delito_especifico"
 		aria-label="especifico">
	    <option value="-1">Seleccione una opción</option>
	 </select>
	</div> 
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_H_contexto" class="form-label">Contexto situacional (homicidio y lesiones):</label>
	  <select class="form-select noValidate" name="Delitos_H_contexto" id="Delitos_H_contexto"
 		aria-label="">
	    <option value="-1">Seleccione una opción</option>
	 </select>
	</div> 
	<div class="mb-4 col-12 pestanaBase">
	  <div class="pestanaTop">
	    <h4>Delito clasificación jurídica</h4>
	  </div>
	</div>	
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_ordenamiento_JUR" class="form-label">Ordenamiento:</label>
	  <select class="form-select" name="Delitos_ordenamiento_JUR" id="Delitos_ordenamiento_JUR">
	    <option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-12 col-lg-12">
	  <label for="Delitos_delito_JUR" class="form-label">Clasificación jurídica:</label>
	  <select class="form-select" name="Delitos_delito_JUR" id="Delitos_delito_JUR">
	    <option value="-1">Seleccione una opción</option>	   	    
	 </select>
	</div> 
 	<div class="alert alert-dark" id="Delitos_delito_JUR_Display" style="display:none;">  
	</div>	

	<div class="mb-4 col-12"><hr></div>	
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_consumacion" class="form-label">Grado de consumación:</label>
	  <select class="form-select" name="Delitos_consumacion" id="Delitos_consumacion" aria-label="Consumación">
	    <option value="-1">Seleccione una opción</option>
	 </select>
	</div>	
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_modalidad" class="form-label">Modalidad:</label>
	  <select class="form-select noValidate" name="Delitos_modalidad" id="Delitos_modalidad" aria-label="Modalidad">
	    <option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_instrumento" class="form-label">Instrumento utilizado para la comisión del delito</label>
	  <select class="form-select" name="Delitos_instrumento" id="Delitos_instrumento" aria-label="Instrumento">
	    <option value="-1">Seleccione una opción</option>
	 </select>
	</div>	
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_fuero" class="form-label">Fuero:</label>
	  <select class="form-select" name="Delitos_fuero" id="Delitos_fuero" aria-label="Fuero">
	    <option value="-1">Seleccione una opción</option>
	 </select>
	</div>	
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_tipo_sitio_ocurrencia" class="form-label">Tipo de sitio de ocurrencia:</label>
	  <select class="form-select" name="Delitos_tipo_sitio_ocurrencia" id="Delitos_tipo_sitio_ocurrencia" aria-label="Tipo_sitio">
	    <option value="-1">Seleccione una opción</option>
	 </select>
	</div>	
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_calificacion" class="form-label">Calificación del delito:</label>
	  <select class="form-select noValidate" name="Delitos_calificacion" id="Delitos_calificacion">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_comision" class="form-label">Forma de comisión:</label>
	  <select class="form-select" name="Delitos_comision" id="Delitos_comision" aria-label="Comisión">
	    <option value="-1">Seleccione una opción</option>
	 </select>
	</div>	
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="Delitos_H_forma_accion" class="form-label">Forma de acción:</label>
	  <select class="form-select" name="Delitos_H_forma_accion" id="Delitos_H_forma_accion" aria-label="Modalidad">
	    <option value="-1">Seleccione una opción</option>
	 </select>
	</div>	
 </div>
</form>
<script type="text/javascript">
$("#Delitos_delito_JUR").change(function(){
	if (this.value=='-1') 
		{$("#Delitos_delito_JUR_Display").hide();}
		else
	{
		$("#Delitos_delito_JUR_Display").text(this.selectedOptions[0].text);
	$("#Delitos_delito_JUR_Display").show();
}
});
$("#Delitos_ordenamiento_JUR").change(function(){
  var delId=this.value;
  $("#Delitos_delito_JUR").html("");
  $("#Delitos_delito_JUR_Display").hide();
  var params = new Object();
  params.idOrdenamiento = delId;
  params._token = '{{csrf_token()}}';
  params = JSON.stringify(params);
  $.ajax({      
      url: "{{Route('delitosJUR')}}",
      type: "POST",
      data: params,
      contentType: "application/json; charset=utf-8",
      dataType: 'json',
      async: false,
      success: function (result) {
          $('#Delitos_delito_JUR').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.delitosJUR, function (key, value) {
              $("#Delitos_delito_JUR").append('<option value="' + value
                  .id + '" title="' + value.cClaveDelito+' - '+value.Valor + '">' +  value.cClaveDelito+' - '+value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });
  });

$("#Delitos_ordenamiento").change(function(){
  var delId=this.value;
  $("#Delitos_delito_general").html("");
  $("#Delitos_delito_especifico").html('<option value="-1">Seleccione una opción</option>');
  var params = new Object();
  params.idOrdenamiento = delId;
  params._token = '{{csrf_token()}}';
  params = JSON.stringify(params);
  $.ajax({      
      url: "{{Route('delitosG')}}",
      type: "POST",
      data: params,
      contentType: "application/json; charset=utf-8",
      dataType: 'json',
      async: false,
      success: function (result) {
          $('#Delitos_delito_general').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.delitosG, function (key, value) {
              $("#Delitos_delito_general").append('<option value="' + value
                  .id + '" title="' + value.Valor + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });
  });

$("#Delitos_delito_general").change(function(){
  var delId=this.value;
  $("#Delitos_delito_especifico").html("");
  var params = new Object();
  params.idDelitoG = delId;
  params._token = '{{csrf_token()}}';
  params = JSON.stringify(params);
  $.ajax({      
      url: "{{Route('delitosE')}}",
      type: "POST",
      data: params,
      contentType: "application/json; charset=utf-8",
      dataType: 'json',
      async: false,
      success: function (result) {
          $('#Delitos_delito_especifico').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.delitosE, function (key, value) {
              $("#Delitos_delito_especifico").append('<option value="' + value
                  .id + '" title="' + value.Valor + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });
  });


</script>