<form method='post' name="frmDE_D" id="frmDE_D" action="{{ route('save') }}" enctype="multipart/form-data">
  @csrf        
  <input type="hidden" name="idDelito" id="idDelito" value="">
  <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
  <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">	
	<div class="row delitos">
		<div class="mb-4 col-12 pestanaBase">
		  <div class="pestanaTop">
		    <h4>Delito clasificación jurídica&nbsp;</h4>
		  </div>
		</div>	
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionDelito_ordenamiento_JUR" class="form-label">Ordenamiento:</label>
		  <select class="form-select" name="conduccionDelito_ordenamiento_JUR" id="conduccionDelito_ordenamiento_JUR">
		    <option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-12 col-lg-12">
		  <label for="conduccionDelito_delito_JUR" class="form-label">Clasificación jurídica:</label>
		  <select class="form-select" name="conduccionDelito_delito_JUR" id="conduccionDelito_delito_JUR">
		    <option value="-1">Seleccione una opción</option>	   	    
		 </select>
		</div> 
	 	<div class="alert alert-dark" id="conduccionDelito_delito_JUR_Display" style="display:none;">  
		</div>	
		<hr>	
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionDelito_delito" class="form-label">Delito :</label>
		  <select class="form-select" name="conduccionDelito_delito" id="conduccionDelito_delito">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionDelito_consumacion" class="form-label">Grado de consumación:</label>
		  <select class="form-select" name="conduccionDelito_consumacion" id="conduccionDelito_consumacion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>		
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionDelito_modalidad" class="form-label">Modalidad:</label>
		  <select class="form-select noValidate" name="conduccionDelito_modalidad" id="conduccionDelito_modalidad">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionDelito_instrumento_conduccion" class="form-label">Instrumento utilizado para la comisión del delito:</label>
		  <select class="form-select" name="conduccionDelito_instrumento_conduccion" id="conduccionDelito_instrumento_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
			<div class="mb-3 col-sm-12 col-md-6 col-lg-4 col-lg-4">
		  <label for="conduccionDelito_fuero_conduccion" class="form-label">Fuero:</label>
		  <select class="form-select" name="conduccionDelito_fuero_conduccion" id="conduccionDelito_fuero_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionDelito_tipo_sitio_ocurrencia_conduccion" class="form-label">Tipo de sitio de ocurrencia:</label>
		  <select class="form-select" name="conduccionDelito_tipo_sitio_ocurrencia_conduccion" id="conduccionDelito_tipo_sitio_ocurrencia_conduccion">
			<option value="-1">Seleccione una opción</option>       
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionDelito_calificacion_conduccion" class="form-label">Calificación del delito:</label>
		  <select class="form-select" name="conduccionDelito_calificacion_conduccion" id="conduccionDelito_calificacion_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionDelito_comision_conduccion" class="form-label">Forma de comisión:</label>
		  <select class="form-select" name="conduccionDelito_comision_conduccion" id="conduccionDelito_comision_conduccion">
			<option value="-1">Seleccione una opción</option>       
		 </select>
		</div>
	</div>
</form>	
<script type="text/javascript">
$(".horaMask").mask("00:00");
$("#conduccionDelito_delito_JUR").change(function(){
	if (this.value=='-1') 
		{$("#conduccionDelito_delito_JUR_Display").hide();}
		else
	{
		$("#conduccionDelito_delito_JUR_Display").text(this.selectedOptions[0].text);
	$("#conduccionDelito_delito_JUR_Display").show();
	}
});
$("#conduccionDelito_ordenamiento_JUR").change(function(){
  var delId=this.value;
  $("#conduccionDelito_delito_JUR").html("");
  $("#conduccionDelito_delito_JUR_Display").hide();
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
          $('#conduccionDelito_delito_JUR').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.delitosJUR, function (key, value) {
          	if (value.id==473 || value.id==474) {
              $("#conduccionDelito_delito_JUR").append('<option value="' + value
                  .id + '" title="' + value.cClaveDelito+' - '+ value.Valor + '">' + value.cClaveDelito+' - '+ value.Valor + '</option>');
            }
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });
});
$("#conduccionDelito_entidad_hechos_conduccion").change(function(){
  var delId=this.value;
  $("#conduccionDelito_municipio_hechos").html("");
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
          $('#conduccionDelito_municipio_hechos').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.municipios, function (key, value) {
              $("#conduccionDelito_municipio_hechos").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });
});

</script>