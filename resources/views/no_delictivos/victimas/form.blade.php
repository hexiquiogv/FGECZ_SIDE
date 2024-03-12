<form method='post' name="frmDE_V" id="frmDE_V" action="{{ route('save') }}" enctype="multipart/form-data">
  @csrf        
  <input type="hidden" name="idVictima" id="idVictima" value="">
  <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
  <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">		
	<div class="row victima">
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="nodVictima_tipo_victima_no_delictivo" class="form-label">Tipo de víctima:</label>
		  <select class="form-select" name="nodVictima_tipo_victima_no_delictivo" id="nodVictima_tipo_victima_no_delictivo"
		   onchange="SiDefuncion()">
				<option value="-1">Seleccione una opción</option>
		  </select>
		</div>	
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		<label for="victima_nombre_victima" class="form-label">Nombre:</label>
		<input type="text" class="form-control nonum camponuevo" name="victima_nombre_victima" id="victima_nombre_victima" placeholder="">
  </div>		
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
			<label for="nodVictima_primer_apellido" class="form-label">Primer apellido:</label>
			<input type="text" class="form-control nonum" name="nodVictima_primer_apellido" id="nodVictima_primer_apellido" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
			<label for="nodVictima_segundo_apellido_victimas_no_delictivo" class="form-label">Segundo apellido:</label>
			<input type="text" class="form-control nonum" name="nodVictima_segundo_apellido_victimas_no_delictivo" id="nodVictima_segundo_apellido_victimas_no_delictivo" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="nodVictima_fecha_nacimiento" class="form-label">Fecha de nacimiento:</label>
			<input type="date" class="form-control noFnoM" name="nodVictima_fecha_nacimiento" id="nodVictima_fecha_nacimiento" placeholder="">
	  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_edad_hechos_victimas" class="form-label">Edad al momento de los hechos:</label>
		<input type="text" class="form-control camponuevo noFnoM" name="victima_edad_hechos_victimas" id="victima_edad_hechos_victimas" 
		onkeyup="mujer1054()">
  </div>

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="nodVictima_sexo" class="form-label">Sexo:</label>
		  <select class="form-select noFnoM" name="nodVictima_sexo" id="nodVictima_sexo" onchange="mujer1054()">
				<option value="-1">Seleccione una opción</option>
		  </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="nodVictima_sit_conyugal_victimas_no_delictivo" class="form-label">Situación conyugal:</label>
		  <select class="form-select noFnoM" name="nodVictima_sit_conyugal_victimas_no_delictivo" id="nodVictima_sit_conyugal_victimas_no_delictivo">
				<option value="-1">Seleccione una opción</option>
		  </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="victima_nacionalidad" class="form-label">Nacionalidad:</label>
		  <select class="form-select noFnoM" name="victima_nacionalidad" id="victima_nacionalidad">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>		
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="nodVictima_escolaridad" class="form-label">Escolaridad:</label>
		  <select class="form-select noFnoM" name="nodVictima_escolaridad" id="nodVictima_escolaridad">
				<option value="-1">Seleccione una opción</option>
		  </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="nodVictima_ocupacion" class="form-label">Ocupación:</label>
		  <select class="form-select noFnoM" name="nodVictima_ocupacion" id="nodVictima_ocupacion">
				<option value="-1">Seleccione una opción</option>
		  </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="nodVictima_occiso" class="form-label">Occiso:</label>
		  <select class="form-select noFnoM" name="nodVictima_occiso" id="nodVictima_occiso" onchange="SiDefuncion()">
				<option value="-1">Seleccione una opción</option>
		 	</select>
		</div>
	 <div class="row defuncion" style="display:none;">
		<div class="mb-4 col-12 pestanaBase">
		  <div class="pestanaTop">
		    <h4>Datos de la defunción</h4>
		  </div>
		</div>
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
				<label for="victima_def_folio_defuncion" class="form-label">Folio Defunción:</label>
				<input type="text" class="form-control" name="victima_def_folio_defuncion" id="victima_def_folio_defuncion">
		  </div>
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
				<label for="victima_def_fecha_exp" class="form-label">Fecha Expediente:</label>
				<input type="date" class="form-control" name="victima_def_fecha_exp" id="victima_def_fecha_exp">
		  </div>
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
				<label for="victima_def_fecha_defuncion" class="form-label">Fecha de defunción:</label>
				<input type="date" class="form-control" name="victima_def_fecha_defuncion" id="victima_def_fecha_defuncion">
		  </div>	  
			<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			  <label for="victima_def_tipo_defuncion" class="form-label">Tipo de defunción:</label>
			  <select class="form-select" name="victima_def_tipo_defuncion" id="victima_def_tipo_defuncion">
					<option value="-1">Seleccione una opción</option>
			 	</select>
			</div>
			<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			    <label for="victima_def_certificado_por" class="form-label">Certificado Por:</label>
			    <select class="form-select" name="victima_def_certificado_por" id="victima_def_certificado_por">
			        <option value="-1">Seleccione una opción</option>
			    </select>
			</div>

			<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			    <label for="victima_def_sitio_defuncion" class="form-label">Sitio Defunción:</label>
			    <select class="form-select" name="victima_def_sitio_defuncion" id="victima_def_sitio_defuncion">
			        <option value="-1">Seleccione una opción</option>
			    </select>
			</div>

			<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			    <label for="victima_def_sitio_lesion" class="form-label">Sitio Lesión:</label>
			    <select class="form-select" name="victima_def_sitio_lesion" id="victima_def_sitio_lesion">
			        <option value="-1">Seleccione una opción</option>
			    </select>
			</div>

			<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			    <label for="victima_def_fue_en_el_trabajo" class="form-label">Fue en el Trabajo:</label>
			    <select class="form-select" name="victima_def_fue_en_el_trabajo" id="victima_def_fue_en_el_trabajo">
			        <option value="-1">Seleccione una opción</option>
			    </select>
			</div>
			<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
				<label for="victima_def_agente_externo" class="form-label">Agente Externo:</label>
				<input type="text" class="form-control" name="victima_def_agente_externo" id="victima_def_agente_externo">
		  </div>
			<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			    <label for="victima_def_tipo_evento" class="form-label">Tipo de Evento:</label>
			    <select class="form-select" name="victima_def_tipo_evento" id="victima_def_tipo_evento">
			        <option value="-1">Seleccione una opción</option>
			    </select>
			</div>

			<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			    <label for="victima_def_tipo_victima" class="form-label">Tipo de Victima:</label>
			    <select class="form-select" name="victima_def_tipo_victima" id="victima_def_tipo_victima">
			        <option value="-1">Seleccione una opción</option>
			    </select>
			</div>

			<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			    <label for="victima_def_tipo_arma" class="form-label">Tipo de Arma:</label>
			    <select class="form-select" name="victima_def_tipo_arma" id="victima_def_tipo_arma">
			        <option value="-1">Seleccione una opción</option>
			    </select>
			</div>					
		<div class="mb-4 col-12 pestanaBase">
		  <div class="pestanaTop">
		    <h4>Domicilio de denuncia</h4>
		  </div>
		</div>
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		    <label for="victima_def_entidad_denunica" class="form-label">Entidad:</label>
		    <select class="form-select" name="victima_def_entidad_denunica" id="victima_def_entidad_denunica" aria-label="Entidad">
		      <option value="-1">Seleccione una opción</option>
		   </select>
		  </div> 
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		    <label for="victima_def_municipio_denunica" class="form-label">Municipio:</label>
		    <select class="form-select" name="victima_def_municipio_denunica" id="victima_def_municipio_denunica" aria-label="Municipio">
		      <option value="-1">Seleccione una opción</option>
		   </select>
		  </div> 
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		    <label for="victima_def_colonia_denunica" class="form-label">Colonia:</label>
		    <input type="text" class="form-control alfanum" name="victima_def_colonia_denunica" id="victima_def_colonia_denunica" >
		  </div>

		<div class="mb-4 col-12 pestanaBase">
		  <div class="pestanaTop">
		    <h4>Domicilio de defunción</h4>
		  </div>
		</div>
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		    <label for="victima_def_entidad_defuncion" class="form-label">Entidad:</label>
		    <select class="form-select" name="victima_def_entidad_defuncion" id="victima_def_entidad_defuncion" aria-label="Entidad">
		      <option value="-1">Seleccione una opción</option>
		   </select>
		  </div> 
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		    <label for="victima_def_municipio_defuncion" class="form-label">Municipio:</label>
		    <select class="form-select" name="victima_def_municipio_defuncion" id="victima_def_municipio_defuncion" aria-label="Municipio">
		      <option value="-1">Seleccione una opción</option>
		   </select>
		  </div> 
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		    <label for="victima_def_colonia_defuncion" class="form-label">Colonia:</label>
		    <input type="text" class="form-control alfanum" name="victima_def_colonia_defuncion" id="victima_def_colonia_defuncion" >
		  </div>
		<div class="mb-4 col-12 pestanaBase">
		  <div class="pestanaTop">
		    <h4>Causas de la defunción</h4>
		  </div>
		</div>
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		    <label for="victima_def_causa_a" class="form-label">Causa A en caso de ser más llenar B C Y D:</label>
		    <input type="text" class="form-control alfanum" name="victima_def_causa_a" id="victima_def_causa_a">
		  </div>
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		    <label for="victima_def_duracion_bcd" class="form-label">Duración (B, C, D):</label>
		    <input type="text" class="form-control alfanum" name="victima_def_duracion_bcd" id="victima_def_duracion_bcd">
		  </div>
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		    <label for="victima_def_estado_patologico" class="form-label">Estado Patológico:</label>
		    <input type="text" class="form-control alfanum" name="victima_def_estado_patologico" id="victima_def_estado_patologico">
		  </div>
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		    <label for="victima_def_duracion_patologico" class="form-label">Duración Patológico:</label>
		    <input type="text" class="form-control alfanum" name="victima_def_duracion_patologico" id="victima_def_duracion_patologico">
		  </div>

		<div class="mb-4 col-12 pestanaBase mujer1054" style="display:none;">
		  <div class="pestanaTop">
		    <h4>PARA MUJERES DE 10 A 54 AÑOS</h4>
		  </div>
		</div>
			<div class="mb-3 col-sm-12 col-md-6 col-lg-4 mujer1054" style="display:none;">
			  <label for="victima_def_condicion_embarazo" class="form-label">Condición de Embarazo:</label>
			  <select class="form-select" name="victima_def_condicion_embarazo" id="victima_def_condicion_embarazo">
					<option value="-1">Seleccione una opción</option>
			 	</select>
			</div>
			<div class="mb-3 col-sm-12 col-md-6 col-lg-4 mujer1054" style="display:none;">
			  <label for="victima_def_periodo_posparto" class="form-label">Estaba en periodo de posparto:</label>
			  <select class="form-select" name="victima_def_periodo_posparto" id="victima_def_periodo_posparto">
					<option value="-1">Seleccione una opción</option>
			 	</select>
			</div>
	 </div>

	</div>	
</form>	
<script type="text/javascript">
$("#victima_edad_hechos_victimas").mask("00")

$("#nodVictima_tipo_victima_no_delictivo").change(function(){
  var delId=this.value;

  if ($("#nodVictima_tipo_victima_no_delictivo").val()==1 || $("#nodVictima_tipo_victima_no_delictivo").val()==4) {
  	$(".fisica").show();
  }
  else
  {$(".fisica").hide();
  $(".fisica select").val(-1);
	$(".fisica input").val('');}
	
  if ($("#nodVictima_tipo_victima_no_delictivo").val()!=1 && $("#nodVictima_tipo_victima_no_delictivo").val()!=4) {
  	$(".noFnoM").addClass('noValidate'); $(".noFnoM").removeClass("border-3 border-danger"); }
  else
  { $(".noFnoM").removeClass('noValidate'); }		
});
  if ($("#nodVictima_tipo_victima_no_delictivo").val()==1 || $("#nodVictima_tipo_victima_no_delictivo").val()==4) {
  	$(".fisica").show();
  }
  else
  {$(".fisica").hide();
  $(".fisica select").val(-1);
	$(".fisica input").val('');}
	
  if ($("#nodVictima_tipo_victima_no_delictivo").val()!=1 && $("#nodVictima_tipo_victima_no_delictivo").val()!=4) {
  	$(".noFnoM").addClass('noValidate'); $(".noFnoM").removeClass("border-3 border-danger"); }
  else
  { $(".noFnoM").removeClass('noValidate'); }

	function SiDefuncion()
	{
		
		@if(in_array(($datos->HECHO_NO_DELITO??-1), [2,3,4,5,7]))
			if(($("#nodVictima_tipo_victima_no_delictivo").val()==1 || $("#nodVictima_tipo_victima_no_delictivo").val()==4 
				|| $("#nodVictima_tipo_victima_no_delictivo").val()==5) && $("#nodVictima_occiso").val()==1)
			{
				$(".defuncion").show();
			}
		  else
		  {$(".defuncion").hide();
		  $(".defuncion select").val(-1);
			$(".defuncion input").val('');}
			mujer1054();			
		@endif
	}
	function mujer1054()
	{
		if($("#nodVictima_sexo").val()==2 && ($("#victima_edad_hechos_victimas").val()>=10 && $("#victima_edad_hechos_victimas").val()<=54))
		{
			$(".mujer1054").show();
		}
	  else
	  {$(".mujer1054").hide();
	  $(".mujer1054 select").val(-1);
		$(".mujer1054 input").val('');}
	}
$("#victima_def_entidad_denunica").change(function(){
  var delId=this.value;
  $("#victima_def_municipio_denunica").html("");
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
          $('#victima_def_municipio_denunica').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.municipios, function (key, value) {
              $("#victima_def_municipio_denunica").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });
  });
$("#victima_def_entidad_defuncion").change(function(){
  var delId=this.value;
  $("#victima_def_municipio_defuncion").html("");
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
          $('#victima_def_municipio_defuncion').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.municipios, function (key, value) {
              $("#victima_def_municipio_defuncion").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });
  });
</script>