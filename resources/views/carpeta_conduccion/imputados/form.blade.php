<form method='post' name="frmDE_I" id="frmDE_I" action="{{ route('save') }}" enctype="multipart/form-data">
  @csrf        
  <input type="hidden" name="idImputado" id="idImputado" value="">
  <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
  <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">	
	<div class="row imputado">
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_tipo_imputado_conduccion" class="form-label">Tipo de imputado:</label>
		  <select class="form-select" name="conduccionImputado_tipo_imputado_conduccion" id="conduccionImputado_tipo_imputado_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral">
			<label for="conduccionImputado_razon_social" class="form-label">Nombre o razón social:</label>
			<input type="text" class="form-control alfanum" name="conduccionImputado_razon_social" id="conduccionImputado_razon_social" placeholder="">
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral">
			<label for="conduccionImputado_representante_legal" class="form-label">Representante legal:</label>
			<!-- <input type="text" class="form-control alfanum" name="conduccionImputado_representante_legal" id="conduccionImputado_representante_legal" placeholder=""> -->
		  <select class="form-select sinonoi" name="conduccionImputado_representante_legal" id="conduccionImputado_representante_legal">
				<option value="-1">Seleccione una opción</option>
		 	</select>		
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral">
			<label for="imputado_H_tipo_representante_legal" class="form-label">Nombre del representante legal:</label>
			<input type="text" class="form-control alfanum camponuevo" name="imputado_H_tipo_representante_legal" id="imputado_H_tipo_representante_legal" placeholder="">
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral">
		  <label for="conduccionImputado_sector_imputados_conduccion" class="form-label">Sector:</label>
		  <select class="form-select" name="conduccionImputado_sector_imputados_conduccion" id="conduccionImputado_sector_imputados_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral">
		  <label for="conduccionImputado_tipo_persona_imputados_conduccion" class="form-label">Tipo de persona moral:</label>
		  <select class="form-select" name="conduccionImputado_tipo_persona_imputados_conduccion" id="conduccionImputado_tipo_persona_imputados_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		  <label for="imputado_rel_pers_moral" class="form-label">¿El imputado tiene relación con alguna persona moral?</label>
		  <select class="form-select camponuevo detenido" name="imputado_rel_pers_moral" id="imputado_rel_pers_moral">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		  <label for="conduccionImputado_delitos_imputado_conduccion" class="form-label">Delitos de los que se le imputa:</label>
		  <select class="form-select" name="conduccionImputado_delitos_imputado_conduccion" id="conduccionImputado_delitos_imputado_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>		
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
			<label for="imputado_alias_imputado" class="form-label">Alias:</label>
			<input type="text" class="form-control alfanum camponuevo" name="imputado_alias_imputado" id="imputado_alias_imputado" placeholder="">
	  </div>				
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_relacion_victima" class="form-label">Relación con la víctima:</label>
		  <select class="form-select" name="conduccionImputado_relacion_victima" id="conduccionImputado_relacion_victima">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	    <label for="imputado_H_imputado_conocido" class="form-label">Imputado conocido:</label>
	    <select class="form-select camponuevo" name="imputado_H_imputado_conocido" id="imputado_H_imputado_conocido">
	      <option>Seleccione una opción</option>
	   </select>
	  </div>

	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		<label for="imputado_nombre_imputado" class="form-label">Nombre:</label>
		<input type="text" class="form-control nonum camponuevo" name="imputado_nombre_imputado" id="imputado_nombre_imputado" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
			<label for="conduccionImputado_primer_apellido" class="form-label">Primer apellido:</label>
			<input type="text" class="form-control nonum" name="conduccionImputado_primer_apellido" id="conduccionImputado_primer_apellido" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
			<label for="conduccionImputado_segundo_apellido_imputados_conduccion" class="form-label">Segundo apellido:</label>
			<input type="text" class="form-control nonum" name="conduccionImputado_segundo_apellido_imputados_conduccion" id="conduccionImputado_segundo_apellido_imputados_conduccion" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="imputado_curp_imputados" class="form-label">CURP:</label>
		<input type="text" class="form-control camponuevo noValidate" name="imputado_curp_imputados" id="imputado_curp_imputados" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="imputado_fecha_nacimiento_imputados" class="form-label">Fecha de nacimiento:</label>
		<input type="date" class="form-control camponuevo noFnoM detenido" name="imputado_fecha_nacimiento_imputados" id="imputado_fecha_nacimiento_imputados" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="imputado_edad_hechos_imputados" class="form-label">Edad al momento de los hechos:</label>
		<input type="text" class="form-control camponuevo noFnoM detenido" name="imputado_edad_hechos_imputados" id="imputado_edad_hechos_imputados" placeholder="">
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_sexo_imputado" class="form-label">Sexo:</label>
		  <select class="form-select camponuevo noFnoM" name="imputado_sexo_imputado" id="imputado_sexo_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>


		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_situacion_conyugal_imputados_conduccion" class="form-label">Situación conyugal:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_situacion_conyugal_imputados_conduccion" id="conduccionImputado_situacion_conyugal_imputados_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_nacionalidad" class="form-label">Nacionalidad:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_nacionalidad" id="conduccionImputado_nacionalidad">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_situacion_migratoria_imputados_conduccion" class="form-label">Situación migratoria:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_situacion_migratoria_imputados_conduccion" id="conduccionImputado_situacion_migratoria_imputados_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_pais_nacimiento" class="form-label">País de nacimiento:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_pais_nacimiento" id="conduccionImputado_pais_nacimiento">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_entidad_nacimiento_imputados_conduccion" class="form-label">Entidad de nacimiento:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_entidad_nacimiento_imputados_conduccion" id="conduccionImputado_entidad_nacimiento_imputados_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_municipio_nacimiento" class="form-label">Municipio de nacimiento:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_municipio_nacimiento" id="conduccionImputado_municipio_nacimiento">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_pais_residencia" class="form-label">País de residencia:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_pais_residencia" id="conduccionImputado_pais_residencia">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_entidad_residencia_imputados_conduccion" class="form-label">Entidad de residencia:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_entidad_residencia_imputados_conduccion" id="conduccionImputado_entidad_residencia_imputados_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_municipio_residencia" class="form-label">Municipio de residencia:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_municipio_residencia" id="conduccionImputado_municipio_residencia">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="conduccionImputado_telefono_imputados_conduccion" class="form-label">Teléfono:</label>
			<input type="text" class="form-control noValidate" name="conduccionImputado_telefono_imputados_conduccion" id="conduccionImputado_telefono_imputados_conduccion" placeholder="">
	  </div>

	  	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_H_domicilio_imputado" class="form-label">Domicilio de residencia habitual del imputado:</label>
			<input type="text" class="form-control alfanum camponuevo noFnoM detenido" name="imputado_H_domicilio_imputado" id="imputado_H_domicilio_imputado">
	  </div>

	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_H_ingreso_imputado" class="form-label">Rango de ingreso mensual neto:</label>
			<input type="text" class="form-control camponuevo noValidate" name="imputado_H_ingreso_imputado" id="imputado_H_ingreso_imputado" placeholder="">
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_habla_español_imputado" class="form-label">¿Habla español?</label>
		  <select class="form-select camponuevo noFnoM detenido" name="imputado_H_habla_español_imputado" id="imputado_H_habla_español_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_habla_leng_extr_imputado" class="form-label">¿Habla lengua extranjera?</label>
		  <select class="form-select camponuevo noFnoM detenido" name="imputado_H_habla_leng_extr_imputado" id="imputado_H_habla_leng_extr_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengExt" style="display:none;">
		  <label for="imputado_H_tipo_lengua_extranjera_imputado" class="form-label">Tipo de lengua extranjera:</label>
		  <select class="form-select camponuevo" name="imputado_H_tipo_lengua_extranjera_imputado" id="imputado_H_tipo_lengua_extranjera_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengExt" style="display:none;">
		  <label for="conduccionImputado_interprete_imputados_conduccion" class="form-label">¿Utilizó algún intérprete?</label>
		  <select class="form-select" name="conduccionImputado_interprete_imputados_conduccion" id="conduccionImputado_interprete_imputados_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>				
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengExt" style="display:none;">
		  <label for="conduccionImputado_traductor_imputados_conduccion" class="form-label">¿Utilizó algún traductor?</label>
		  <select class="form-select" name="conduccionImputado_traductor_imputados_conduccion" id="conduccionImputado_traductor_imputados_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_discapacidad_imputados" class="form-label">¿Presenta algún tipo de discapacidad?</label>
		  <select class="form-select camponuevo noFnoM detenido" name="imputado_discapacidad_imputados" id="imputado_discapacidad_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 discapacidad" style="display:none;">
		  <label for="imputado_tipo_discapacidad_imputados" class="form-label">Tipo de discapacidad:</label>
		  <select class="form-select camponuevo" name="imputado_tipo_discapacidad_imputados" id="imputado_tipo_discapacidad_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 discapacidad" style="display:none;">
		  <label for="imputado_interprete_por_discapacidad_imputado" class="form-label">¿Utilizó intérprete y/o medio tecnológico por discapacidad?</label>
		  <select class="form-select camponuevo" name="imputado_interprete_por_discapacidad_imputado" id="imputado_interprete_por_discapacidad_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_poblacion_calle" class="form-label">¿Pertenece a población en situación de calle?</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_poblacion_calle" id="conduccionImputado_poblacion_calle">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_leer_escribir_imputados" class="form-label">¿Sabe leer y escribir?</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_leer_escribir_imputados" id="conduccionImputado_leer_escribir_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_escolaridad_imputado" class="form-label">Nivel de escolaridad:</label>
		  <select class="form-select camponuevo noFnoM detenido" name="imputado_escolaridad_imputado" id="imputado_escolaridad_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_H_ocupacion_imputado" class="form-label">Ocupación:</label>
		  <select class="form-select camponuevo noFnoM detenido" name="imputado_H_ocupacion_imputado" id="imputado_H_ocupacion_imputado">
				<option value="-1">Seleccione una opción</option>
		 	</select>
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_se_identifica_indigena_imputado" class="form-label">¿Se identifica como persona indígena?</label>
		  <select class="form-select camponuevo noFnoM detenido" name="imputado_H_se_identifica_indigena_imputado" id="imputado_H_se_identifica_indigena_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 pobIndigena" style="display:none;">
		  <label for="imputado_H_indigena_imputado" class="form-label">Población indígena a la que pertenece:</label>
		  <select class="form-select camponuevo" name="imputado_H_indigena_imputado" id="imputado_H_indigena_imputado">
				<option value="-1">Seleccione una opción</option>
		 </select>
		</div> 		
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_habla_leng_indig_imputado" class="form-label">¿Habla alguna lengua indígena?</label>
		  <select class="form-select camponuevo noFnoM detenido" name="imputado_H_habla_leng_indig_imputado" id="imputado_H_habla_leng_indig_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengIndigena" style="display:none;">
		  <label for="imputado_H_lengua_imputado" class="form-label">Tipo de lengua indígena:</label>
		  <select class="form-select camponuevo" name="imputado_H_lengua_imputado" id="imputado_H_lengua_imputado">
				<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_nombre_de_grupo" class="form-label">Nombre del grupo al que pertenece:</label>
		  <input type="text" class="form-control alfanum camponuevo noValidate" name="imputado_H_nombre_de_grupo" id="imputado_H_nombre_de_grupo">
		  <!-- <select class="form-select" name="imputado_H_nombre_de_grupo" id="imputado_H_nombre_de_grupo">
			<option value="-1">Seleccione una opción</option>
		 </select> -->
		</div>		
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		  <label for="conduccionImputado_detenido_imputados_conduccion" class="form-label">Detenido:</label>
		  <select class="form-select" name="conduccionImputado_detenido_imputados_conduccion" id="conduccionImputado_detenido_imputados_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_estado_imputado_conduccion" class="form-label">Situación imputado:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_estado_imputado_conduccion" id="conduccionImputado_estado_imputado_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="conduccionImputado_fecha_detencion_conduccion" class="form-label">Fecha de detención:</label>
			<input type="date" class="form-control noFnoM detenido" name="conduccionImputado_fecha_detencion_conduccion" id="conduccionImputado_fecha_detencion_conduccion" value="">
		</div> 
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="conduccionImputado_hora_detencion" class="form-label">Hora de detención:</label>
			<input type="text" class="form-control horaMask noFnoM detenido" name="conduccionImputado_hora_detencion" id="conduccionImputado_hora_detencion" placeholder="hh:mm">
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_tipo_detencion_imputados_conduccion" class="form-label">Tipo de detención:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_tipo_detencion_imputados_conduccion" 
		  id="conduccionImputado_tipo_detencion_imputados_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_entidad_detencion_imputados_conduccion" class="form-label">Entidad de la detención:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_entidad_detencion_imputados_conduccion" 
		  id="conduccionImputado_entidad_detencion_imputados_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_autoridad_detencion_imputados_conduccion" class="form-label">Autoridad que registra la detención:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_autoridad_detencion_imputados_conduccion" 
		  id="conduccionImputado_autoridad_detencion_imputados_conduccion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="conduccionImputado_folio_rnd" class="form-label">Folio RND:</label>
			<input type="text" class="form-control noFnoM detenido" name="conduccionImputado_folio_rnd" id="conduccionImputado_folio_rnd" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="conduccionImputado_razon_rnd" class="form-label">Razón por la que no se capturó RND:</label>
			  <select class="form-select noValidate" name="conduccionImputado_razon_rnd" id="conduccionImputado_razon_rnd">
				<option value="-1">Seleccione una opción</option>
			 </select>
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="conduccionImputado_examen_detencion_imputados_conduccion" class="form-label">Examen de detención :</label>
			  <select class="form-select noFnoM detenido" name="conduccionImputado_examen_detencion_imputados_conduccion" id="conduccionImputado_examen_detencion_imputados_conduccion">
				<option value="-1">Seleccione una opción</option>
			 </select>
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionImputado_lesionado" class="form-label">Lesionado:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_lesionado" id="conduccionImputado_lesionado">
				<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="conduccionImputado_estado_presentacion" class="form-label">Estado de presentación:</label>
		  <select class="form-select noFnoM detenido" name="conduccionImputado_estado_presentacion" id="conduccionImputado_estado_presentacion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_antecedentes" class="form-label">Antecedentes penales:</label>
		  <select class="form-select camponuevo noValidate detenido" name="imputado_H_antecedentes" id="imputado_H_antecedentes">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_defensa" class="form-label">Contó con persona defensora:</label>
		  <select class="form-select camponuevo noFnoM detenido" name="imputado_H_defensa" id="imputado_H_defensa">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_tipo_defensa" class="form-label">Tipo de defensoría:</label>
		  <select class="form-select camponuevo noFnoM detenido conDefensora" name="imputado_H_tipo_defensa" id="imputado_H_tipo_defensa">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>  
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_H_media_filiacion_imputado" class="form-label">Filiación:</label>
			<input type="text" class="form-control nonum camponuevo noValidate" name="imputado_H_media_filiacion_imputado" id="imputado_H_media_filiacion_imputado" placeholder="">
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_tipo_mandamiento" class="form-label">Tipo de mandamiento:</label>
		  <select class="form-select camponuevo noValidate" name="imputado_H_tipo_mandamiento" id="imputado_H_tipo_mandamiento">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_grado_de_participacion" class="form-label">Grado de autoría y participación en la comisión del(os) delito(s):</label>
		  <select class="form-select camponuevo noValidate" name="imputado_H_grado_de_participacion" id="imputado_H_grado_de_participacion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

	</div>
</form>
<script type="text/javascript">

$(".horaMask").mask('00:00');
$("#imputado_edad_hechos_imputados").mask('00');
$("#imputado_curp_imputados").mask("SSSS000000SSSSSS00");
$("#imputado_H_ingreso_imputado").mask("#,##0.00",{reverse: true});
$("#conduccionImputado_telefono_imputados_conduccion").mask('(000)000-0000');
$("#conduccionImputado_folio_rnd").mask('SS/SS/000/00000000/0000');

$("#conduccionImputado_tipo_imputado_conduccion").change(function(){
  var delId=this.value;
  if ($("#conduccionImputado_tipo_imputado_conduccion").val()==2 || $("#conduccionImputado_tipo_imputado_conduccion").val()==4) {
  	$(".moral").show();
  }
  else
  {
		$(".moral").hide();
		$(".moral select").val(-1);
		$(".moral input").val('');		
	}
	$(".moral select:visible").change();
	  if ($("#conduccionImputado_tipo_imputado_conduccion").val()==1 || $("#conduccionImputado_tipo_imputado_conduccion").val()==4) {
	  	$(".fisica").show();
	  	$(".fisica select").change();
	  }
	  else
	  {
			$(".fisica").hide();
			$(".fisica select").val(-1).change();
			$(".fisica input").val('');		
		}
	  if ($("#conduccionImputado_tipo_imputado_conduccion").val()!=1 && $("#conduccionImputado_tipo_imputado_conduccion").val()!=4) {
	  	$(".noFnoM").addClass('noValidate'); $(".noFnoM").removeClass("border-3 border-danger");}
	  else
	  { $(".noFnoM").removeClass('noValidate'); }	
	$("select.noFnoM:visible").change();
});
	$("#imputado_H_habla_leng_extr_imputado").change(function(){
	  var delId=this.value;
	  if ($("#imputado_H_habla_leng_extr_imputado").val()==1) {
	  	$(".lengExt").show();
	  }
	  else
	  {$(".lengExt").hide();
	  $(".lengExt select").val(-1);
		$(".lengExt input").val('');}
	});
	$("#imputado_discapacidad_imputados").change(function(){
	  var delId=this.value;
	  if ($("#imputado_discapacidad_imputados").val()==1) {
	  	$(".discapacidad").show();
	  }
	  else
	  {$(".discapacidad").hide();
	  $(".discapacidad select").val(-1);
		$(".discapacidad input").val('');}
	});
	$("#imputado_H_se_identifica_indigena_imputado").change(function(){
	  var delId=this.value;
	  if ($("#imputado_H_se_identifica_indigena_imputado").val()==1) {
	  	$(".pobIndigena").show();
	  }
	  else
	  {$(".pobIndigena").hide();
	  $(".pobIndigena select").val(-1);
		$(".pobIndigena input").val('');}
	});
	$("#imputado_H_habla_leng_indig_imputado").change(function(){
	  var delId=this.value;
	  if ($("#imputado_H_habla_leng_indig_imputado").val()==1) {
	  	$(".lengIndigena").show();
	  }
	  else
	  {$(".lengIndigena").hide();
	  $(".lengIndigena select").val(-1);
		$(".lengIndigena input").val('');}
	});
		$("#conduccionImputado_detenido_imputados_conduccion").change(function(){
	  var delId=this.value;
	  if ($("#conduccionImputado_detenido_imputados_conduccion").val()!=1) {
	  	$(".detenido").addClass('noValidate');$(".detenido").removeClass("border-3 border-danger"); }	  
	  else
	  {$(".detenido").removeClass('noValidate'); $("select.detenido:visible").change();}
	});
	$("#imputado_H_defensa").change(function(){
	  var delId=this.value;
	  if ($("#imputado_H_defensa").val()!=1) {
	  	$(".conDefensora").addClass('noValidate');$(".conDefensora").removeClass("border-3 border-danger"); }	  
	  else
	  {$(".conDefensora").removeClass('noValidate'); }
	});

	  if ($("#conduccionImputado_tipo_imputado_conduccion").val()!=1 && $("#conduccionImputado_tipo_imputado_conduccion").val()!=4) {
	  	$(".noFnoM").addClass('noValidate'); $(".noFnoM").removeClass("border-3 border-danger");}
	  else
	  { $(".noFnoM").removeClass('noValidate'); }
		$("select.noFnoM:visible").change();
  if ($("#conduccionImputado_tipo_imputado_conduccion").val()==2 || $("#conduccionImputado_tipo_imputado_conduccion").val()==4) {
  	$(".moral").show();
  }
  else
  {
  	$(".moral").hide();
	  $(".moral select").val(-1);
		$(".moral input").val('');
  }
  $(".moral select:visible").change();
  if ($("#conduccionImputado_tipo_imputado_conduccion").val()==1 || $("#conduccionImputado_tipo_imputado_conduccion").val()==4) {
	  	$(".fisica").show();
	  	$(".fisica select").change();
	  }
	  else
	  {
			$(".fisica").hide();
			$(".fisica select").val(-1).change();
			$(".fisica input").val('');		
		}


  if ($("#imputado_H_habla_leng_extr_imputado").val()==1) {
  	$(".lengExt").show();
  }
  else
  {$(".lengExt").hide();
  $(".lengExt select").val(-1);
	$(".lengExt input").val('');}
	if ($("#imputado_discapacidad_imputados").val()==1) {
	  	$(".discapacidad").show();
	  }
	  else
	  {$(".discapacidad").hide();
	  $(".discapacidad select").val(-1);
		$(".discapacidad input").val('');}	

  if ($("#imputado_H_se_identifica_indigena_imputado").val()==1) {
  	$(".pobIndigena").show();
  }
  else
  {$(".pobIndigena").hide();
  $(".pobIndigena select").val(-1);
	$(".pobIndigena input").val('');}

  if ($("#imputado_H_habla_leng_indig_imputado").val()==1) {
  	$(".lengIndigena").show();
  }
  else
  {$(".lengIndigena").hide();
  $(".lengIndigena select").val(-1);
	$(".lengIndigena input").val('');}

  if ($("#conduccionImputado_detenido_imputados_conduccion").val()!=1) {
  	$(".detenido").addClass('noValidate');$(".detenido").removeClass("border-3 border-danger"); }	  
  else
  {$(".detenido").removeClass('noValidate'); $("select.detenido:visible").change();}

  if ($("#imputado_H_defensa").val()!=1) {
  	$(".conDefensora").addClass('noValidate');$(".conDefensora").removeClass("border-3 border-danger"); }	  
  else
  {$(".conDefensora").removeClass('noValidate'); }
$("#conduccionImputado_entidad_nacimiento_imputados_conduccion").change(function(){
  var delId=this.value;
  $("#conduccionImputado_municipio_nacimiento").html("");
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
          $('#conduccionImputado_municipio_nacimiento').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.municipios, function (key, value) {
              $("#conduccionImputado_municipio_nacimiento").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });

  });
$("#conduccionImputado_entidad_residencia_imputados_conduccion").change(function(){
  var delId=this.value;
  $("#conduccionImputado_municipio_residencia").html("");
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
          $('#conduccionImputado_municipio_residencia').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.municipios, function (key, value) {
              $("#conduccionImputado_municipio_residencia").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });

  });

</script>
