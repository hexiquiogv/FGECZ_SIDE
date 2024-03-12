<form method='post' name="frmDE_V" id="frmDE_V" action="{{ route('save') }}" enctype="multipart/form-data">
  @csrf        
  <input type="hidden" name="idVictima" id="idVictima" value="">
  <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
  <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">	
	<div class="row victima">
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_tipo_victima_conduccion" class="form-label">Tipo de víctima:</label>
		  <select class="form-select" name="conduccionVictima_tipo_victima_conduccion" id="conduccionVictima_tipo_victima_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_delitos_victima_conduccion" class="form-label">Delitos de los que fue víctima:</label>
		  <select class="form-select" name="conduccionVictima_delitos_victima_conduccion" id="conduccionVictima_delitos_victima_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_relacion_imputado" class="form-label">Relación con el imputado:</label>
		  <select class="form-select" name="conduccionVictima_relacion_imputado" id="conduccionVictima_relacion_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
		<label for="conduccionVictima_razon_social" class="form-label">Razon social:</label>
		<input type="text" class="form-control alfanum" name="conduccionVictima_razon_social" id="conduccionVictima_razon_social"
	 placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
		<label for="conduccionVictima_representante_legal" class="form-label">Representante legal:</label>
		<!-- <input type="text" class="form-control alfanum" name="conduccionVictima_representante_legal" id="conduccionVictima_representante_legal" placeholder="">-->
		<select class="form-select sinonoi" name="conduccionVictima_representante_legal" id="conduccionVictima_representante_legal">
			<option value="-1">Seleccione una opción</option>
	 	</select>
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
			<label for="victima_H_tipo_representante_legal" class="form-label">Nombre del representante legal:</label>
			<input type="text" class="form-control alfanum camponuevo" name="victima_H_tipo_representante_legal" id="victima_H_tipo_representante_legal" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
		  <label for="conduccionVictima_tipo_persona_victimas_conduccion" class="form-label">Tipo de persona moral:</label>
		  <select class="form-select" name="conduccionVictima_tipo_persona_victimas_conduccion" id="conduccionVictima_tipo_persona_victimas_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
		  <label for="conduccionVictima_sector_victimas_conduccion" class="form-label">Sector:</label>
		  <select class="form-select" name="conduccionVictima_sector_victimas_conduccion" id="conduccionVictima_sector_victimas_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_asesoria" class="form-label">Asesoría jurídica:</label>
	  <select class="form-select sinonoi camponuevo noValidate" name="victima_asesoria" id="victima_asesoria">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_tipo_de_asesoria" class="form-label">Tipo de asesoría jurídica:</label>
	  <select class="form-select camponuevo noValidate" name="victima_tipo_de_asesoria" id="victima_tipo_de_asesoria">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="col-12"></div>
		
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		<label for="victima_nombre_victima" class="form-label">Nombre:</label>
		<input type="text" class="form-control nonum camponuevo" name="victima_nombre_victima" id="victima_nombre_victima" placeholder="">
  </div>		
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		<label for="conduccionVictima_primer_apellido" class="form-label">Primer apellido:</label>
		<input type="text" class="form-control nonum" name="conduccionVictima_primer_apellido" id="conduccionVictima_primer_apellido"
	 placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		<label for="conduccionVictima_segundo_apellido_victimas_conduccion" class="form-label">Segundo apellido:</label>
		<input type="text" class="form-control nonum" name="conduccionVictima_segundo_apellido_victimas_conduccion" id="conduccionVictima_segundo_apellido_victimas_conduccion"
	 placeholder="">
	  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_curp_victimas" class="form-label">CURP:</label>
		<input type="text" class="form-control camponuevo noValidate" name="victima_curp_victimas" id="victima_curp_victimas" placeholder="">
  </div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_fecha_nacimiento_victimas" class="form-label">Fecha de nacimiento:</label>
		<input type="date" class="form-control camponuevo noFnoM" name="victima_fecha_nacimiento_victimas" id="victima_fecha_nacimiento_victimas" value="">
	</div>   
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_edad_hechos_victimas" class="form-label">Edad al momento de los hechos:</label>
		<input type="text" class="form-control camponuevo noFnoM" name="victima_edad_hechos_victimas" id="victima_edad_hechos_victimas" placeholder="">
  </div>
	
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_sexo_victima" class="form-label">Sexo de la víctima:</label>
	  <select class="form-select camponuevo noFnoM" name="victima_sexo_victima" id="victima_sexo_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>

	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_situacion_conyugal_victimas_conduccion" class="form-label">Situación conyugal:</label>
		  <select class="form-select noFnoM" name="conduccionVictima_situacion_conyugal_victimas_conduccion" id="conduccionVictima_situacion_conyugal_victimas_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_nacionalidad" class="form-label">Nacionalidad:</label>
		  <select class="form-select noFnoM" name="conduccionVictima_nacionalidad" id="conduccionVictima_nacionalidad">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_situacion_migratoria_victimas_conduccion" class="form-label">Situación migratoria:</label>
		  <select class="form-select noFnoM" name="conduccionVictima_situacion_migratoria_victimas_conduccion" id="conduccionVictima_situacion_migratoria_victimas_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_pais_nacimiento" class="form-label">País de nacimiento:</label>
		  <select class="form-select noFnoM" name="conduccionVictima_pais_nacimiento" id="conduccionVictima_pais_nacimiento">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_entidad_nacimiento_victimas_conduccion" class="form-label">Entidad de nacimiento:</label>
		  <select class="form-select noFnoM" name="conduccionVictima_entidad_nacimiento_victimas_conduccion" id="conduccionVictima_entidad_nacimiento_victimas_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_municipio_nacimiento" class="form-label">Municipio de nacimiento:</label>
		  <select class="form-select noFnoM" name="conduccionVictima_municipio_nacimiento" id="conduccionVictima_municipio_nacimiento">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_pais_residencia" class="form-label">País de residencia:</label>
		  <select class="form-select noFnoM" name="conduccionVictima_pais_residencia" id="conduccionVictima_pais_residencia">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_entidad_residencia_victimas_conduccion" class="form-label">Entidad de residencia:</label>
		  <select class="form-select noFnoM" name="conduccionVictima_entidad_residencia_victimas_conduccion" id="conduccionVictima_entidad_residencia_victimas_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_municipio_residencia" class="form-label">Municipio de residencia:</label>
		  <select class="form-select noFnoM" name="conduccionVictima_municipio_residencia" id="conduccionVictima_municipio_residencia">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="conduccionVictima_telefono_victimas_conduccion" class="form-label">Teléfono:</label>
		<input type="text" class="form-control noValidate" name="conduccionVictima_telefono_victimas_conduccion" id="conduccionVictima_telefono_victimas_conduccion" placeholder="">
	  </div>

  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_H_domicilio_victima" class="form-label">Domicilio de la víctima:</label>
		<input type="text" class="form-control alfanum camponuevo noFnoM" name="victima_H_domicilio_victima" id="victima_H_domicilio_victima" placeholder="">
  </div>

  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_H_ingreso_victima" class="form-label">Rango de ingreso mensual neto:</label>
		<input type="text" class="form-control camponuevo noValidate" name="victima_H_ingreso_victima" id="victima_H_ingreso_victima" placeholder="">
  </div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_habla_español_victima" class="form-label">¿La víctima habla español?</label>
	  <select class="form-select sinonoi camponuevo noFnoM" name="victima_habla_español_victima" id="victima_habla_español_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_habla_leng_extr_victima" class="form-label">¿La víctima habla lengua extranjera?</label>
	  <select class="form-select sinonoi camponuevo noFnoM" name="victima_habla_leng_extr_victima" id="victima_habla_leng_extr_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengExt" style="display:none;">
	  <label for="victima_tipo_lengua_extranjera_victima" class="form-label">Tipo de lengua extranjera:</label>
	  <select class="form-select camponuevo" name="victima_tipo_lengua_extranjera_victima" id="victima_tipo_lengua_extranjera_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>	  		

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengExt" style="display:none;">
		  <label for="conduccionVictima_traductor_victimas_conduccion" class="form-label">¿Utilizó algún traductor?</label>
		  <select class="form-select sinonoi" name="conduccionVictima_traductor_victimas_conduccion" id="conduccionVictima_traductor_victimas_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengExt" style="display:none;">
		  <label for="conduccionVictima_interprete_victimas_conduccion" class="form-label">¿Utilizó algún intérprete?</label>
		  <select class="form-select sinonoi" name="conduccionVictima_interprete_victimas_conduccion" id="conduccionVictima_interprete_victimas_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>		

	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_discapacidad_victimas" class="form-label">¿Presenta algún tipo de discapacidad?</label>
	  <select class="form-select sinonoi camponuevo noFnoM" name="victima_discapacidad_victimas" id="victima_discapacidad_victimas">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 discapacidad" style="display:none;">
	  <label for="victima_tipo_discapacidad_victimas" class="form-label">Tipo de discapacidad:</label>
	  <select class="form-select camponuevo" name="victima_tipo_discapacidad_victimas" id="victima_tipo_discapacidad_victimas">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 discapacidad" style="display:none;">
	  <label for="victima_interprete_por_discapacidad_victima" class="form-label">¿Utilizó intérprete y/o medio tecnológico por discapacidad?</label>
	  <select class="form-select sinonoi camponuevo" name="victima_interprete_por_discapacidad_victima" id="victima_interprete_por_discapacidad_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_aten_medica" class="form-label">¿Necesitó de atención médica?</label>
	  <select class="form-select sinonoi camponuevo noFnoM" name="victima_aten_medica" id="victima_aten_medica">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_aten_psicologica" class="form-label">¿Necesitó de atención psicológica?</label>
	  <select class="form-select sinonoi camponuevo noFnoM" name="victima_aten_psicologica" id="victima_aten_psicologica">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_poblacion_calle" class="form-label">¿Pertenece a población en situación de calle?</label>
		  <select class="form-select sinonoi noFnoM" name="conduccionVictima_poblacion_calle" id="conduccionVictima_poblacion_calle">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_leer_escribir" class="form-label">¿Sabe leer y escribir?</label>
		  <select class="form-select sinonoi noFnoM" name="conduccionVictima_leer_escribir" id="conduccionVictima_leer_escribir">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_escolaridad" class="form-label">Nivel de escolaridad:</label>
		  <select class="form-select noFnoM" name="conduccionVictima_escolaridad" id="conduccionVictima_escolaridad">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionVictima_ocupacion" class="form-label">Ocupación:</label>
		  <select class="form-select noFnoM" name="conduccionVictima_ocupacion" id="conduccionVictima_ocupacion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_H_se_identifica_indigena_victima" class="form-label">¿Se identifica como persona indígena?</label>
	  <select class="form-select sinonoi camponuevo noFnoM" name="victima_H_se_identifica_indigena_victima" id="victima_H_se_identifica_indigena_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 pobIndigena" style="display:none;">
	  <label for="victima_H_poblacion_indigena_victima" class="form-label">Población indígena a la que pertenece:</label>
	  <select class="form-select camponuevo" name="victima_H_poblacion_indigena_victima" id="victima_H_poblacion_indigena_victima">
			<option value="-1">Seleccione una opción</option>
	 </select>
	</div>  
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_habla_leng_indig_victima" class="form-label">¿La víctima habla lengua indígena?</label>
	  <select class="form-select sinonoi camponuevo noFnoM" name="victima_habla_leng_indig_victima" id="victima_habla_leng_indig_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengIndigena" style="display:none;">
	  <label for="victima_H_lengua_victima" class="form-label">Tipo de lengua indígena:</label>
	  <select class="form-select camponuevo" name="victima_H_lengua_victima" id="victima_H_lengua_victima">
			<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_victima_violencia" class="form-label">¿La víctima vivió violencia?</label>
	  <select class="form-select sinonoi camponuevo noFnoM" name="victima_victima_violencia" id="victima_victima_violencia">
			<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_H_vestimenta_victima" class="form-label">Vestimenta y rasgos visibles (en caso de que la víctima no esté identificada):</label>
		<input type="text" class="form-control alfanum camponuevo noValidate" name="victima_H_vestimenta_victima" id="victima_H_vestimenta_victima" placeholder="">
  </div>

	</div>	
</form>
<script type="text/javascript">
$("#victima_edad_hechos_victimas").mask("00")
// $("#victima_H_victima_id").mask("00000000")
// $("#victima_H_numero_de_atencion").mask("00000000")
$("#victima_H_ingreso_victima").mask("#,##0.00",{reverse: true});
$("#victima_curp_victimas").mask("SSSS000000SSSSSS00");
$("#conduccionVictima_telefono_victimas_conduccion").mask("(000)000-0000")

$("#conduccionVictima_tipo_victima_conduccion").change(function(){
  var delId=this.value;
  if ($("#conduccionVictima_tipo_victima_conduccion").val()==2 || $("#conduccionVictima_tipo_victima_conduccion").val()==4) {
  	$(".moral").show();
  }
  else
  {$(".moral").hide();
  $(".moral select").val(-1);
	$(".moral input").val('');}

  if ($("#conduccionVictima_tipo_victima_conduccion").val()==1 || $("#conduccionVictima_tipo_victima_conduccion").val()==4) {
  	$(".fisica").show();
  }
  else
  {$(".fisica").hide();
  $(".fisica select").val(-1);
	$(".fisica input").val('');}

  if ($("#conduccionVictima_tipo_victima_conduccion").val()!=1 && $("#conduccionVictima_tipo_victima_conduccion").val()!=4) {
  	$(".noFnoM").addClass('noValidate'); $(".noFnoM").removeClass("border-3 border-danger");}
  else
  { $(".noFnoM").removeClass('noValidate'); }	
});
$("#victima_habla_leng_extr_victima").change(function(){
  var delId=this.value;
  if ($("#victima_habla_leng_extr_victima").val()==1) {
  	$(".lengExt").show();
  }
  else
  {$(".lengExt").hide();
  $(".lengExt select").val(-1);
	$(".lengExt input").val('');}
});
$("#victima_discapacidad_victimas").change(function(){
  var delId=this.value;
  if ($("#victima_discapacidad_victimas").val()==1) {
  	$(".discapacidad").show();
  }
  else
  {$(".discapacidad").hide();
  $(".discapacidad select").val(-1);
	$(".discapacidad input").val('');}
});
$("#victima_H_se_identifica_indigena_victima").change(function(){
  var delId=this.value;
  if ($("#victima_H_se_identifica_indigena_victima").val()==1) {
  	$(".pobIndigena").show();
  }
  else
  {$(".pobIndigena").hide();
  $(".pobIndigena select").val(-1);
	$(".pobIndigena input").val('');}
});
$("#victima_habla_leng_indig_victima").change(function(){
  var delId=this.value;
  if ($("#victima_habla_leng_indig_victima").val()==1) {
  	$(".lengIndigena").show();
  }
  else
  {$(".lengIndigena").hide();
  $(".lengIndigena select").val(-1);
	$(".lengIndigena input").val('');}
});
  if ($("#conduccionVictima_tipo_victima_conduccion").val()==2 || $("#conduccionVictima_tipo_victima_conduccion").val()==4) {
  	$(".moral").show();
  }
  else
  {	$(".moral").hide();
	  $(".moral select").val(-1);
		$(".moral input").val('');
  }
  if ($("#conduccionVictima_tipo_victima_conduccion").val()==1 || $("#conduccionVictima_tipo_victima_conduccion").val()==4) {
  	$(".fisica").show();
  }
  else
  { $(".fisica").hide();
	  $(".fisica select").val(-1);
		$(".fisica input").val('');
	}
  if ($("#conduccionVictima_tipo_victima_conduccion").val()!=1 && $("#conduccionVictima_tipo_victima_conduccion").val()!=4) {
  	$(".noFnoM").addClass('noValidate'); $(".noFnoM").removeClass("border-3 border-danger");}
  else
  { $(".noFnoM").removeClass('noValidate'); }

  if ($("#victima_habla_leng_extr_victima").val()==1) {
  	$(".lengExt").show();
  }
  else
  {$(".lengExt").hide();
  $(".lengExt select").val(-1);
	$(".lengExt input").val('');}
	if ($("#victima_discapacidad_victimas").val()==1) {
	  	$(".discapacidad").show();
	  }
	  else
	  {$(".discapacidad").hide();
	  $(".discapacidad select").val(-1);
		$(".discapacidad input").val('');}	

  if ($("#victima_H_se_identifica_indigena_victima").val()==1) {
  	$(".pobIndigena").show();
  }
  else
  {$(".pobIndigena").hide();
  $(".pobIndigena select").val(-1);
	$(".pobIndigena input").val('');}

  if ($("#victima_habla_leng_indig_victima").val()==1) {
  	$(".lengIndigena").show();
  }
  else
  {$(".lengIndigena").hide();
  $(".lengIndigena select").val(-1);
	$(".lengIndigena input").val('');}

$("#conduccionVictima_entidad_nacimiento_victimas_conduccion").change(function(){
  var delId=this.value;
  $("#conduccionVictima_municipio_nacimiento").html("");
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
          $('#conduccionVictima_municipio_nacimiento').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.municipios, function (key, value) {
              $("#conduccionVictima_municipio_nacimiento").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });

  });
$("#conduccionVictima_entidad_residencia_victimas_conduccion").change(function(){
  var delId=this.value;
  $("#conduccionVictima_municipio_residencia").html("");
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
          $('#conduccionVictima_municipio_residencia').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.municipios, function (key, value) {
              $("#conduccionVictima_municipio_residencia").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });

  });
</script>