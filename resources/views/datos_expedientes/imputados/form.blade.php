<form method='post' name="frmDE_I" id="frmDE_I" action="{{ route('save') }}" enctype="multipart/form-data">
  @csrf        
  <input type="hidden" name="idImputado" id="idImputado" value="">
  <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
  <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">	
	 <div class="row imputado">
	 	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_tipo_imputado" class="form-label">Tipo de imputado:</label>
		  <select class="form-select" name="imputado_tipo_imputado" id="imputado_tipo_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
			<label for="imputado_razon_social" class="form-label">Nombre o razón social:</label>
			<input type="text" class="form-control alfanum" name="imputado_razon_social" id="imputado_razon_social" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
			<label for="imputado_representante_legal" class="form-label">Representante legal:</label>
			<!-- <input type="text" class="form-control alfanum" name="imputado_representante_legal" id="imputado_representante_legal" placeholder=""> -->
	  <select class="form-select sinonoi" name="imputado_representante_legal" id="imputado_representante_legal">
			<option value="-1">Seleccione una opción</option>
	 	</select>	  
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
			<label for="imputado_H_tipo_representante_legal" class="form-label">Nombre del representante legal:</label>
			<input type="text" class="form-control alfanum" name="imputado_H_tipo_representante_legal" id="imputado_H_tipo_representante_legal" placeholder="">
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
		  <label for="imputado_sector_imputados" class="form-label">Sector:</label>
		  <select class="form-select" name="imputado_sector_imputados" id="imputado_sector_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
		  <label for="imputado_tipo_persona_imputados" class="form-label">Tipo de persona moral:</label>
		  <select class="form-select" name="imputado_tipo_persona_imputados" id="imputado_tipo_persona_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		  <label for="imputado_rel_pers_moral" class="form-label">¿El imputado tiene relación con alguna persona moral?</label>
		  <select class="form-select detenido" name="imputado_rel_pers_moral" id="imputado_rel_pers_moral">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		  <label for="imputado_delitos_imputado" class="form-label">Delitos de los que se le imputa</label>
		  <select class="form-select" name="imputado_delitos_imputado" id="imputado_delitos_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
			<label for="imputado_alias_imputado" class="form-label">Alias:</label>
			<input type="text" class="form-control alfanum" name="imputado_alias_imputado" id="imputado_alias_imputado" placeholder="">
	  </div>	
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_relacion_victima" class="form-label">Relación con la víctima:</label>
		  <select class="form-select" name="imputado_relacion_victima" id="imputado_relacion_victima">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	    <label for="imputado_H_imputado_conocido" class="form-label">Imputado conocido:</label>
	    <select class="form-select" name="imputado_H_imputado_conocido" id="imputado_H_imputado_conocido">
	      <option>Seleccione una opción</option>
	   </select>
	  </div>		
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		<label for="imputado_nombre_imputado" class="form-label">Nombre:</label>
		<input type="text" class="form-control nonum" name="imputado_nombre_imputado" id="imputado_nombre_imputado" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		<label for="imputado_primer_apellido" class="form-label">Primer apellido:</label>
		<input type="text" class="form-control nonum" name="imputado_primer_apellido" id="imputado_primer_apellido" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		<label for="imputado_segundo_apellido_imputados" class="form-label">Segundo apellido:</label>
		<input type="text" class="form-control nonum" name="imputado_segundo_apellido_imputados" id="imputado_segundo_apellido_imputados" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="imputado_curp_imputados" class="form-label">CURP:</label>
		<input type="text" class="form-control noValidate" name="imputado_curp_imputados" id="imputado_curp_imputados" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="imputado_fecha_nacimiento_imputados" class="form-label">Fecha de nacimiento:</label>
		<input type="date" class="form-control noFnoM detenido" name="imputado_fecha_nacimiento_imputados" id="imputado_fecha_nacimiento_imputados">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="imputado_edad_hechos_imputados" class="form-label">Edad al momento de los hechos:</label>
		<input type="text" class="form-control noFnoM detenido" name="imputado_edad_hechos_imputados" id="imputado_edad_hechos_imputados">
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_sexo_imputado" class="form-label">Sexo:</label>
		  <select class="form-select noFnoM" name="imputado_sexo_imputado" id="imputado_sexo_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_situacion_conyugal_imputados" class="form-label">Situación conyugal:</label>
		  <select class="form-select noFnoM detenido" name="imputado_situacion_conyugal_imputados" id="imputado_situacion_conyugal_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>  
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_nacionalidad" class="form-label">Nacionalidad:</label>
		  <select class="form-select noFnoM detenido" name="imputado_nacionalidad" id="imputado_nacionalidad">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_situacion_migratoria_imputados" class="form-label">Situación migratoria:</label>
		  <select class="form-select noFnoM detenido" name="imputado_situacion_migratoria_imputados" id="imputado_situacion_migratoria_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_pais_nacimiento" class="form-label">País de nacimiento:</label>
		  <select class="form-select noFnoM detenido" name="imputado_pais_nacimiento" id="imputado_pais_nacimiento">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_entidad_nacimiento_imputados" class="form-label">Entidad de nacimiento:</label>
		  <select class="form-select noFnoM detenido" name="imputado_entidad_nacimiento_imputados" id="imputado_entidad_nacimiento_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>	
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_municipio_nacimiento" class="form-label">Municipio de nacimiento:</label>
		  <select class="form-select noFnoM detenido" name="imputado_municipio_nacimiento" id="imputado_municipio_nacimiento">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_pais_residencia" class="form-label">País de residencia:</label>
		  <select class="form-select noFnoM detenido" name="imputado_pais_residencia" id="imputado_pais_residencia">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_entidad_residencia_imputados" class="form-label">Entidad de residencia:</label>
		  <select class="form-select noFnoM detenido" name="imputado_entidad_residencia_imputados" id="imputado_entidad_residencia_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_municipio_residencia" class="form-label">Municipio de residencia:</label>
		  <select class="form-select noFnoM detenido" name="imputado_municipio_residencia" id="imputado_municipio_residencia">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_telefono_imputados" class="form-label">Teléfono:</label>
			<input type="text" class="form-control noValidate" name="imputado_telefono_imputados" id="imputado_telefono_imputados" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_H_domicilio_imputado" class="form-label">Domicilio de residencia habitual del imputado:</label>
			<input type="text" class="form-control alfanum noFnoM detenido" name="imputado_H_domicilio_imputado" id="imputado_H_domicilio_imputado">
	  </div>
    <!-- 		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_H_imputado_id" class="form-label">ID Imputado:</label>
			<input type="text" class="form-control" name="imputado_H_imputado_id" id="imputado_H_imputado_id" placeholder="">
	  </div> -->
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_H_ingreso_imputado" class="form-label">Rango de ingreso mensual neto:</label>
			<input type="text" class="form-control noValidate" name="imputado_H_ingreso_imputado" id="imputado_H_ingreso_imputado">
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_habla_español_imputado" class="form-label">¿Habla español?</label>
		  <select class="form-select noFnoM detenido" name="imputado_H_habla_español_imputado" id="imputado_H_habla_español_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_habla_leng_extr_imputado" class="form-label">¿Habla lengua extranjera?</label>
		  <select class="form-select noFnoM detenido" name="imputado_H_habla_leng_extr_imputado" id="imputado_H_habla_leng_extr_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengExt" style="display:none;">
		  <label for="imputado_H_tipo_lengua_extranjera_imputado" class="form-label">Tipo de lengua extranjera:</label>
		  <select class="form-select" name="imputado_H_tipo_lengua_extranjera_imputado" id="imputado_H_tipo_lengua_extranjera_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengExt" style="display:none;">
		  <label for="imputado_interprete" class="form-label">¿Utilizó algún intérprete?</label>
		  <select class="form-select" name="imputado_interprete" id="imputado_interprete">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengExt" style="display:none;">
		  <label for="imputado_traductor_imputado" class="form-label">¿Utilizó algún traductor?</label>
		  <select class="form-select" name="imputado_traductor_imputado" id="imputado_traductor_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_discapacidad_imputados" class="form-label">¿Presenta algún tipo de discapacidad?</label>
		  <select class="form-select noFnoM detenido" name="imputado_discapacidad_imputados" id="imputado_discapacidad_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 discapacidad" style="display:none;">
		  <label for="imputado_tipo_discapacidad_imputados" class="form-label">Tipo de discapacidad:</label>
		  <select class="form-select" name="imputado_tipo_discapacidad_imputados" id="imputado_tipo_discapacidad_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 discapacidad" style="display:none;">
		  <label for="imputado_interprete_por_discapacidad_imputado" class="form-label">¿Utilizó intérprete y/o medio tecnológico por discapacidad?</label>
		  <select class="form-select" name="imputado_interprete_por_discapacidad_imputado" id="imputado_interprete_por_discapacidad_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_poblacion_calle" class="form-label">¿Pertenece a población en situación de calle?</label>
		  <select class="form-select noFnoM detenido" name="imputado_poblacion_calle" id="imputado_poblacion_calle">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_leer_escribir_imputados" class="form-label">¿Sabe leer y escribir?</label>
		  <select class="form-select noFnoM detenido" name="imputado_leer_escribir_imputados" id="imputado_leer_escribir_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_escolaridad_imputado" class="form-label">Nivel de escolaridad:</label>
		  <select class="form-select noFnoM detenido" name="imputado_escolaridad_imputado" id="imputado_escolaridad_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_H_ocupacion_imputado" class="form-label">Ocupación:</label>
		  <select class="form-select noFnoM detenido" name="imputado_H_ocupacion_imputado" id="imputado_H_ocupacion_imputado">
				<option value="-1">Seleccione una opción</option>
		 	</select>
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_se_identifica_indigena_imputado" class="form-label">¿Se identifica como persona indígena?</label>
		  <select class="form-select noFnoM detenido" name="imputado_H_se_identifica_indigena_imputado" id="imputado_H_se_identifica_indigena_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 pobIndigena" style="display:none;">
		  <label for="imputado_H_indigena_imputado" class="form-label">Población indígena a la que pertenece:</label>
		  <select class="form-select" name="imputado_H_indigena_imputado" id="imputado_H_indigena_imputado">
				<option value="-1">Seleccione una opción</option>
		 </select>
		</div> 		
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_habla_leng_indig_imputado" class="form-label">¿Habla alguna lengua indígena?</label>
		  <select class="form-select noFnoM detenido" name="imputado_H_habla_leng_indig_imputado" id="imputado_H_habla_leng_indig_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengIndigena" style="display:none;">
		  <label for="imputado_H_lengua_imputado" class="form-label">Tipo de lengua indígena:</label>
		  <select class="form-select" name="imputado_H_lengua_imputado" id="imputado_H_lengua_imputado">
				<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_nombre_de_grupo" class="form-label">Nombre del grupo al que pertenece:</label>
		  <input type="text" class="form-control alfanum noValidate" name="imputado_H_nombre_de_grupo" id="imputado_H_nombre_de_grupo">
		  <!-- <select class="form-select" name="imputado_H_nombre_de_grupo" id="imputado_H_nombre_de_grupo">
			<option value="-1">Seleccione una opción</option>
		 </select> -->
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		  <label for="imputado_detenido_imputados" class="form-label">Detenido:</label>
		  <select class="form-select" name="imputado_detenido_imputados" id="imputado_detenido_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_estado_imputado" class="form-label">Situación imputado:</label>
		  <select class="form-select noFnoM detenido" name="imputado_estado_imputado" id="imputado_estado_imputado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="imputado_fecha_detencion" class="form-label">Fecha de detención:</label>
		<input type="date" class="form-control noFnoM detenido" name="imputado_fecha_detencion" id="imputado_fecha_detencion" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="imputado_hora_detencion" class="form-label">Hora de detención:</label>
		<input type="text" class="form-control horaMask noFnoM detenido" name="imputado_hora_detencion" id="imputado_hora_detencion" placeholder="">
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_tipo_detencion" class="form-label">Tipo de detención:</label>
		  <select class="form-select noFnoM detenido" name="imputado_tipo_detencion" id="imputado_tipo_detencion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_entidad_detencion_imputados" class="form-label">Entidad de la detención:</label>
		  <select class="form-select noFnoM detenido" name="imputado_entidad_detencion_imputados" id="imputado_entidad_detencion_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_autoridad_detencion_imputados" class="form-label">Autoridad que registra la detención:</label>
		  <select class="form-select noFnoM detenido" name="imputado_autoridad_detencion_imputados" id="imputado_autoridad_detencion_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_folio_rnd" class="form-label">Folio RND:</label>
			<input type="text" class="form-control noFnoM detenido" name="imputado_folio_rnd" id="imputado_folio_rnd" placeholder="">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_razon_rnd" class="form-label">Razón por la que no se capturó RND:</label>
		  <select class="form-select noValidate" name="imputado_razon_rnd" id="imputado_razon_rnd">
			<option value="-1">Seleccione una opción</option>
		 </select>
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_examen_detencion_imputados" class="form-label">Examen de detención :</label>
		  <select class="form-select noFnoM detenido" name="imputado_examen_detencion_imputados" id="imputado_examen_detencion_imputados">
			<option value="-1">Seleccione una opción</option>
		 </select>
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_lesionado" class="form-label">Lesionado:</label>
		  <select class="form-select noFnoM detenido" name="imputado_lesionado" id="imputado_lesionado">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_estado_presentacion" class="form-label">Estado de presentación:</label>
		  <select class="form-select noFnoM detenido" name="imputado_estado_presentacion" id="imputado_estado_presentacion">
				<option value="-1">Seleccione una opción</option>
		 </select>
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_situacion_libertad" class="form-label">Situación de libertad:</label>
		  <select class="form-select noValidate" name="imputado_situacion_libertad" id="imputado_situacion_libertad">
				<option value="-1">Seleccione una opción</option>
		 </select>
	  </div>	  
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_antecedentes" class="form-label">Antecedentes penales:</label>
		  <select class="form-select noValidate detenido" name="imputado_H_antecedentes" id="imputado_H_antecedentes">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_defensa" class="form-label">Contó con persona defensora:</label>
		  <select class="form-select noFnoM detenido" name="imputado_H_defensa" id="imputado_H_defensa">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_tipo_defensa" class="form-label">Tipo de defensoría:</label>
		  <select class="form-select noFnoM detenido conDefensora" name="imputado_H_tipo_defensa" id="imputado_H_tipo_defensa">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>  
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
			<label for="imputado_H_media_filiacion_imputado" class="form-label">Filiación:</label>
			<input type="text" class="form-control nonum noValidate" name="imputado_H_media_filiacion_imputado" id="imputado_H_media_filiacion_imputado" placeholder="">
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_tipo_mandamiento" class="form-label">Tipo de mandamiento:</label>
		  <select class="form-select noValidate" name="imputado_H_tipo_mandamiento" id="imputado_H_tipo_mandamiento">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="imputado_H_grado_de_participacion" class="form-label">Grado de autoría y participación en la comisión del(os) delito(s):</label>
		  <select class="form-select noValidate" name="imputado_H_grado_de_participacion" id="imputado_H_grado_de_participacion">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-4 col-12 pestanaBase">
		  <div class="pestanaTop">
		    <h4>Audiencia de garantías</h4>
		  </div>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="causa_H_audiencia_de_garantias" class="form-label">Audiencia de garantías:</label>
		  <input type="text" class="form-control nonum noValidate" name="causa_H_audiencia_de_garantias" id="causa_H_audiencia_de_garantias" maxlength="70">
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		    <label for="causa_H_promovida_por" class="form-label">Audiencia promovida por:</label>
		    <select class="form-select noValidate" name="causa_H_promovida_por" id="causa_H_promovida_por">
		      <option value="-1">Seleccione una opción</option>
		   </select>
		</div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="causa_H_resultado_audiencia_de_garantias" class="form-label">Resultado de la audiencia:</label>
		  <input type="text" class="form-control nonum noValidate" name="causa_H_resultado_audiencia_de_garantias" id="causa_H_resultado_audiencia_de_garantias">
		</div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	    <label for="causa_H_fecha_cita" class="form-label">Fecha para la cita para imputación:</label>
	    <input type="date" class="form-control noValidate" name="causa_H_fecha_cita" id="causa_H_fecha_cita" value="">
	  </div>
		<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="causa_H_previo_a_causa" class="form-label">Previo a causa:</label>
		  <input type="text" class="form-control nonum noValidate" name="causa_H_previo_a_causa" id="causa_H_previo_a_causa" maxlength="70">
		</div>
	</div>
</form>
<script type="text/javascript">

	$(".horaMask").mask('00:00');
	$("#imputado_edad_hechos_imputados").mask('00');
	$("#imputado_telefono_imputados").mask('(000)000-0000');
	// $("#imputado_H_imputado_id").mask('00000000');
	$("#imputado_folio_rnd").mask('SS/SS/000/00000000/0000');
	$("#imputado_curp_imputados").mask("SSSS000000SSSSSS00");
	$("#imputado_H_ingreso_imputado").mask("#,##0.00",{reverse: true});

	$("#imputado_tipo_imputado").change(function(){
	  var delId=this.value;
	  if ($("#imputado_tipo_imputado").val()!=1 && $("#imputado_tipo_imputado").val()!=4) {
	  	$(".noFnoM").addClass('noValidate'); $(".noFnoM").removeClass("border-3 border-danger");}
	  else
	  { $(".noFnoM").removeClass('noValidate'); }
		$("select.noFnoM:visible").change();
	  if ($("#imputado_tipo_imputado").val()==2 || $("#imputado_tipo_imputado").val()==4) {
	  	$(".moral").show();
	  }
	  else
	  {
			$(".moral").hide();
			$(".moral select").val(-1);
			$(".moral input").val('');		
		}
		$(".moral select:visible").change();
	  if ($("#imputado_tipo_imputado").val()==1 || $("#imputado_tipo_imputado").val()==4) {
	  	$(".fisica").show();
	  	$(".fisica select").change();
	  }
	  else
	  {
			$(".fisica").hide();
			$(".fisica select").val(-1).change();
			$(".fisica input").val('');		
		}
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

	$("#imputado_detenido_imputados").change(function(){
	  var delId=this.value;
	  if ($("#imputado_detenido_imputados").val()!=1) {
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

  if ($("#imputado_tipo_imputado").val()!=1 && $("#imputado_tipo_imputado").val()!=4) {
  	$(".noFnoM").addClass('noValidate');$(".noFnoM").removeClass("border-3 border-danger"); }
  else
  { $(".noFnoM").removeClass('noValidate'); }
	$("select.noFnoM:visible").change();
  if ($("#imputado_tipo_imputado").val()==2 || $("#imputado_tipo_imputado").val()==4) {
  	$(".moral").show();
  }
  else
  {
  	$(".moral").hide();
	  $(".moral select").val(-1);
		$(".moral input").val('');
  }
  $(".moral select:visible").change();
  if ($("#imputado_tipo_imputado").val()==1 || $("#imputado_tipo_imputado").val()==4) {
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

  if ($("#imputado_detenido_imputados").val()!=1) {
  	$(".detenido").addClass('noValidate');$(".detenido").removeClass("border-3 border-danger"); }	  
  else
  {$(".detenido").removeClass('noValidate'); $("select.detenido:visible").change();}
	
  if ($("#imputado_H_defensa").val()!=1) {
  	$(".conDefensora").addClass('noValidate');$(".conDefensora").removeClass("border-3 border-danger"); }	  
  else
  {$(".conDefensora").removeClass('noValidate'); }
  	
	$("#imputado_entidad_nacimiento_imputados").change(function(){
	  var delId=this.value;
	  $("#imputado_municipio_nacimiento").html("");
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
	          $('#imputado_municipio_nacimiento').html('<option value="-1">Seleccione una opción</option>');
	          $.each(result.municipios, function (key, value) {
	              $("#imputado_municipio_nacimiento").append('<option value="' + value
	                  .id + '">' + value.Valor + '</option>');
	          });
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
	        alert(textStatus + ": " + XMLHttpRequest.responseText);
	        }
	    });

	  });
	$("#imputado_entidad_residencia_imputados").change(function(){
	  var delId=this.value;
	  $("#imputado_municipio_residencia").html("");
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
	          $('#imputado_municipio_residencia').html('<option value="-1">Seleccione una opción</option>');
	          $.each(result.municipios, function (key, value) {
	              $("#imputado_municipio_residencia").append('<option value="' + value
	                  .id + '">' + value.Valor + '</option>');
	          });
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
	        alert(textStatus + ": " + XMLHttpRequest.responseText);
	        }
	    });

	  });

</script>
