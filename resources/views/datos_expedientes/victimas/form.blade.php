<form method='post' name="frmDE_V" id="frmDE_V" action="{{ route('save') }}" enctype="multipart/form-data">
  @csrf        
  <input type="hidden" name="idVictima" id="idVictima" value="">
  <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
  <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">	
 <div class="row victima"> 
 	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_tipo_victima" class="form-label">Tipo de víctima:</label>
	  <select class="form-select" name="victima_tipo_victima" id="victima_tipo_victima" onchange="SiDefuncion()">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_delitos_victima" class="form-label">Delitos de los que fue víctima:</label>
	  <select class="form-select" name="victima_delitos_victima" id="victima_delitos_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_relacion_imputado" class="form-label">Relación con el imputado:</label>
	  <select class="form-select" name="victima_relacion_imputado" id="victima_relacion_imputado">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
		<label for="victima_razon_social" class="form-label">Nombre o razón social:</label>
		<input type="text" class="form-control alfanum" name="victima_razon_social" id="victima_razon_social" placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
		<label for="victima_representante_legal" class="form-label">Representante legal:</label>
		<!-- <input type="text" class="form-control alfanum" name="victima_representante_legal" id="victima_representante_legal" placeholder=""> -->
	  <select class="form-select sinonoi" name="victima_representante_legal" id="victima_representante_legal">
			<option value="-1">Seleccione una opción</option>
	 	</select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
		<label for="victima_H_tipo_representante_legal" class="form-label">Nombre del representante legal:</label>
		<input type="text" class="form-control alfanum" name="victima_H_tipo_representante_legal" id="victima_H_tipo_representante_legal" placeholder="">
  </div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
	  <label for="victima_tipo_persona_victimas" class="form-label">Tipo de persona moral:</label>
	  <select class="form-select" name="victima_tipo_persona_victimas" id="victima_tipo_persona_victimas">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 moral" style="display:none;">
	  <label for="victima_sector_victimas" class="form-label">Sector:</label>
	  <select class="form-select" name="victima_sector_victimas" id="victima_sector_victimas">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>  
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_asesoria" class="form-label">Asesoría jurídica:</label>
	  <select class="form-select sinonoi noValidate" name="victima_asesoria" id="victima_asesoria">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_tipo_de_asesoria" class="form-label">Tipo de asesoría jurídica:</label>
	  <select class="form-select noValidate" name="victima_tipo_de_asesoria" id="victima_tipo_de_asesoria">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	
	<div class="col-12"></div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		<label for="victima_nombre_victima" class="form-label">Nombre:</label>
		<input type="text" class="form-control nonum" name="victima_nombre_victima" id="victima_nombre_victima" placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		<label for="victima_primer_apellido" class="form-label">Primer apellido:</label>
		<input type="text" class="form-control nonum" name="victima_primer_apellido" id="victima_primer_apellido" placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fisica" style="display:none;">
		<label for="victima_segundo_apellido_victimas" class="form-label">Segundo apellido:</label>
		<input type="text" class="form-control nonum" name="victima_segundo_apellido_victimas" id="victima_segundo_apellido_victimas" placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_curp_victimas" class="form-label">CURP:</label>
		<input type="text" class="form-control noValidate" name="victima_curp_victimas" id="victima_curp_victimas" placeholder="">
  </div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_fecha_nacimiento_victimas" class="form-label">Fecha de nacimiento:</label>
		<input type="date" class="form-control noFnoM" name="victima_fecha_nacimiento_victimas" id="victima_fecha_nacimiento_victimas" value="">
	</div>   
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_edad_hechos_victimas" class="form-label">Edad al momento de los hechos:</label>
		<input type="text" class="form-control noFnoM" name="victima_edad_hechos_victimas" id="victima_edad_hechos_victimas" onkeyup="mujer1054()">
  </div>
	
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_sexo_victima" class="form-label">Sexo de la víctima:</label>
	  <select class="form-select noFnoM" name="victima_sexo_victima" id="victima_sexo_victima" onchange="mujer1054()">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_situacion_conyugal_victimas" class="form-label">Situación conyugal:</label>
	  <select class="form-select noFnoM" name="victima_situacion_conyugal_victimas" id="victima_situacion_conyugal_victimas">
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
	  <label for="victima_situacion_migratoria_victimas" class="form-label">Situación migratoria:</label>
	  <select class="form-select noFnoM" name="victima_situacion_migratoria_victimas" id="victima_situacion_migratoria_victimas">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_pais_nacimiento" class="form-label">País de nacimiento:</label>
	  <select class="form-select noFnoM" name="victima_pais_nacimiento" id="victima_pais_nacimiento">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>

	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_entidad_nacimiento_victimas" class="form-label">Entidad de nacimiento:</label>
	  <select class="form-select noFnoM" name="victima_entidad_nacimiento_victimas" id="victima_entidad_nacimiento_victimas">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_municipio_nacimiento" class="form-label">Municipio de nacimiento:</label>
	  <select class="form-select noFnoM" name="victima_municipio_nacimiento" id="victima_municipio_nacimiento">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_pais_residencia" class="form-label">País de residencia:</label>
	  <select class="form-select noFnoM" name="victima_pais_residencia" id="victima_pais_residencia">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_entidad_residencia_victimas" class="form-label">Entidad de residencia:</label>
	  <select class="form-select noFnoM" name="victima_entidad_residencia_victimas" id="victima_entidad_residencia_victimas">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_municipio_residencia" class="form-label">Municipio de residencia:</label>
	  <select class="form-select noFnoM" name="victima_municipio_residencia" id="victima_municipio_residencia">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_telefono_victimas" class="form-label">Teléfono:</label>
		<input type="text" class="form-control noValidate" name="victima_telefono_victimas" id="victima_telefono_victimas" placeholder="">
	  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_H_domicilio_victima" class="form-label">Domicilio de la víctima:</label>
		<input type="text" class="form-control alfanum noFnoM" name="victima_H_domicilio_victima" id="victima_H_domicilio_victima" placeholder="">
  </div>
	<!--   <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_H_victima_id" class="form-label">ID Víctima:</label>
		<input type="text" class="form-control" name="victima_H_victima_id" id="victima_H_victima_id" placeholder="">
  </div> -->
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_H_ingreso_victima" class="form-label">Rango de ingreso mensual neto:</label>
		<input type="text" class="form-control noValidate" name="victima_H_ingreso_victima" id="victima_H_ingreso_victima" placeholder="">
  </div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_habla_español_victima" class="form-label">¿La víctima habla español?</label>
	  <select class="form-select sinonoi noFnoM" name="victima_habla_español_victima" id="victima_habla_español_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_habla_leng_extr_victima" class="form-label">¿La víctima habla lengua extranjera?</label>
	  <select class="form-select sinonoi noFnoM" name="victima_habla_leng_extr_victima" id="victima_habla_leng_extr_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengExt" style="display:none;">
	  <label for="victima_tipo_lengua_extranjera_victima" class="form-label">Tipo de lengua extranjera:</label>
	  <select class="form-select" name="victima_tipo_lengua_extranjera_victima" id="victima_tipo_lengua_extranjera_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>

	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengExt" style="display:none;">
	  <label for="victima_traductor_victima" class="form-label">¿Utilizó algún traductor?</label>
	  <select class="form-select sinonoi" name="victima_traductor_victima" id="victima_traductor_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengExt" style="display:none;">
	  <label for="victima_interprete" class="form-label">¿Utilizó algún intérprete?</label>
	  <select class="form-select sinonoi" name="victima_interprete" id="victima_interprete">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	

	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_discapacidad_victimas" class="form-label">¿Presenta algún tipo de discapacidad?</label>
	  <select class="form-select sinonoi noFnoM" name="victima_discapacidad_victimas" id="victima_discapacidad_victimas">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 discapacidad" style="display:none;">
	  <label for="victima_tipo_discapacidad_victimas" class="form-label">Tipo de discapacidad:</label>
	  <select class="form-select" name="victima_tipo_discapacidad_victimas" id="victima_tipo_discapacidad_victimas">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 discapacidad" style="display:none;">
	  <label for="victima_interprete_por_discapacidad_victima" class="form-label">¿Utilizó intérprete y/o medio tecnológico por discapacidad?</label>
	  <select class="form-select sinonoi" name="victima_interprete_por_discapacidad_victima" id="victima_interprete_por_discapacidad_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_aten_medica" class="form-label">¿Necesitó de atención médica?</label>
	  <select class="form-select sinonoi noFnoM" name="victima_aten_medica" id="victima_aten_medica">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_aten_psicologica" class="form-label">¿Necesitó de atención psicológica?</label>
	  <select class="form-select sinonoi noFnoM" name="victima_aten_psicologica" id="victima_aten_psicologica">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 d-none">
		<label for="victima_H_numero_de_atencion" class="form-label">Número de la atención:</label>
		<input type="text" class="form-control noletra" name="victima_H_numero_de_atencion" id="victima_H_numero_de_atencion" placeholder="">
  </div>

	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_poblacion_calle" class="form-label">¿Pertenece a población en situación de calle?</label>
	  <select class="form-select sinonoi noFnoM" name="victima_poblacion_calle" id="victima_poblacion_calle">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_leer_escribir" class="form-label">¿Sabe leer y escribir?</label>
	  <select class="form-select sinonoi noFnoM" name="victima_leer_escribir" id="victima_leer_escribir">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_escolaridad" class="form-label">Nivel de escolaridad:</label>
	  <select class="form-select noFnoM" name="victima_escolaridad" id="victima_escolaridad">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_ocupacion" class="form-label">Ocupación:</label>
	  <select class="form-select noFnoM" name="victima_ocupacion" id="victima_ocupacion">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_H_se_identifica_indigena_victima" class="form-label">¿Se identifica como persona indígena?</label>
	  <select class="form-select sinonoi noFnoM" name="victima_H_se_identifica_indigena_victima" id="victima_H_se_identifica_indigena_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 pobIndigena" style="display:none;">
	  <label for="victima_H_poblacion_indigena_victima" class="form-label">Población indígena a la que pertenece:</label>
	  <select class="form-select" name="victima_H_poblacion_indigena_victima" id="victima_H_poblacion_indigena_victima">
			<option value="-1">Seleccione una opción</option>
	 </select>
	</div>  
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_habla_leng_indig_victima" class="form-label">¿La víctima habla lengua indígena?</label>
	  <select class="form-select sinonoi noFnoM" name="victima_habla_leng_indig_victima" id="victima_habla_leng_indig_victima">
		<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4 lengIndigena" style="display:none;">
	  <label for="victima_H_lengua_victima" class="form-label">Tipo de lengua indígena:</label>
	  <select class="form-select" name="victima_H_lengua_victima" id="victima_H_lengua_victima">
			<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
	  <label for="victima_victima_violencia" class="form-label">¿La víctima vivió violencia?</label>
	  <select class="form-select sinonoi noFnoM" name="victima_victima_violencia" id="victima_victima_violencia">
			<option value="-1">Seleccione una opción</option>
	 </select>
	</div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		<label for="victima_H_vestimenta_victima" class="form-label">Vestimenta y rasgos visibles (en caso de que la víctima no esté identificada):</label>
		<input type="text" class="form-control alfanum noValidate" name="victima_H_vestimenta_victima" id="victima_H_vestimenta_victima" placeholder="">
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
$("#victima_telefono_victimas").mask("(000)000-0000")
// $("#victima_H_victima_id").mask("00000000")
$("#victima_H_numero_de_atencion").mask("00000000")
$("#victima_H_ingreso_victima").mask("#,##0.00",{reverse: true});
$("#victima_curp_victimas").mask("SSSS000000SSSSSS00");

$("#victima_tipo_victima").change(function(){
  var delId=this.value;

  if ($("#victima_tipo_victima").val()==2 || $("#victima_tipo_victima").val()==4) {
  	$(".moral").show();
  }
  else
  {$(".moral").hide();
  $(".moral select").val(-1);
	$(".moral input").val('');}

  if ($("#victima_tipo_victima").val()==1 || $("#victima_tipo_victima").val()==4) {
  	$(".fisica").show();
  }
  else
  {$(".fisica").hide();
  $(".fisica select").val(-1);
	$(".fisica input").val('');}
  if ($("#victima_tipo_victima").val()!=1 && $("#victima_tipo_victima").val()!=4) {
  	$(".noFnoM").addClass('noValidate'); $(".noFnoM").removeClass("border-3 border-danger"); }
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
  if ($("#victima_tipo_victima").val()==2 || $("#victima_tipo_victima").val()==4) {
  	$(".moral").show();
  }
  else
  {
  	$(".moral").hide();
	  $(".moral select").val(-1);
		$(".moral input").val('');
  }
  if ($("#victima_tipo_victima").val()==1 || $("#victima_tipo_victima").val()==4) {
  	$(".fisica").show();
  }
  else
  {
  	$(".fisica").hide();
	  $(".fisica select").val(-1);
		$(".fisica input").val('');
  }  
  if ($("#victima_tipo_victima").val()!=1 && $("#victima_tipo_victima").val()!=4) {
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

$("#victima_entidad_nacimiento_victimas").change(function(){
  var delId=this.value;
  $("#victima_municipio_nacimiento").html("");
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
          $('#victima_municipio_nacimiento').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.municipios, function (key, value) {
              $("#victima_municipio_nacimiento").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });

  });
$("#victima_entidad_residencia_victimas").change(function(){
  var delId=this.value;
  $("#victima_municipio_residencia").html("");
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
          $('#victima_municipio_residencia').html('<option value="-1">Seleccione una opción</option>');
          $.each(result.municipios, function (key, value) {
              $("#victima_municipio_residencia").append('<option value="' + value
                  .id + '">' + value.Valor + '</option>');
          });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });

  });

	function SiDefuncion()
	{
		
		@if($esHomicidios>0)
			if($("#victima_tipo_victima").val()==1 || $("#victima_tipo_victima").val()==4 || $("#victima_tipo_victima").val()==5)
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
		if($("#victima_sexo_victima").val()==2 && ($("#victima_edad_hechos_victimas").val()>=10 && $("#victima_edad_hechos_victimas").val()<=54))
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