<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="pills-carpeta-tab" data-bs-toggle="pill" data-bs-target="#pills-carpeta" type="button" role="tab" aria-controls="pills-carpeta" aria-selected="true">Carpeta de investigación</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-causas-tab" data-bs-toggle="pill" data-bs-target="#pills-causas" type="button" role="tab" aria-controls="pills-causas" aria-selected="false">Causas</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-inicial-tab" data-bs-toggle="pill" data-bs-target="#pills-inicial" type="button" role="tab" aria-controls="pills-inicial" aria-selected="false">Etapa inicial</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-intermedia-tab" data-bs-toggle="pill" data-bs-target="#pills-intermedia" type="button" role="tab" aria-controls="pills-intermedia" aria-selected="false">Etapa intermedia</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-salidas-tab" data-bs-toggle="pill" data-bs-target="#pills-salidas" type="button" role="tab" aria-controls="pills-salidas" aria-selected="false">Salidas alternas</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-juicio-tab" data-bs-toggle="pill" data-bs-target="#pills-juicio" type="button" role="tab" aria-controls="pills-juicio" aria-selected="false">Juicio</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-complementarios-tab" data-bs-toggle="pill" data-bs-target="#pills-complementarios" type="button" role="tab" aria-controls="pills-complementarios" aria-selected="false">Datos complementarios</button>
  </li>  
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-carpeta" role="tabpanel" aria-labelledby="pills-carpeta-tab" tabindex="0">
    @include("causas_penales.form_datos_generales")
  </div>
  <div class="tab-pane fade" id="pills-causas" role="tabpanel" aria-labelledby="pills-causas-tab" tabindex="0">
    @include("causas_penales.causas")
  </div>
  <div class="tab-pane fade" id="pills-inicial" role="tabpanel" aria-labelledby="pills-inicial-tab" tabindex="0">
    @include("causas_penales.etapa_inicial")
  </div>
  <div class="tab-pane fade" id="pills-intermedia" role="tabpanel" aria-labelledby="pills-intermedia-tab" tabindex="0">
    @include("causas_penales.etapa_intermedia")
  </div>
  <div class="tab-pane fade" id="pills-salidas" role="tabpanel" aria-labelledby="pills-salidas-tab" tabindex="0">
    @include("causas_penales.salidas_alternas")
  </div>
  <div class="tab-pane fade" id="pills-juicio" role="tabpanel" aria-labelledby="pills-juicio-tab" tabindex="0">
    @include("causas_penales.juicio")
  </div>  
  <div class="tab-pane fade" id="pills-complementarios" role="tabpanel" aria-labelledby="pills-complementarios-tab" tabindex="0">
    @include("causas_penales.complementarios")
  </div>  
</div>

<script type="text/javascript">
	{
	  $("#pills-causas-tab").click(function()
	  {
		$(".causasCausas select").html(""); 

		var params = new Object();    
		params._token = '{{csrf_token()}}';
		params.seccion = 2;
		params = JSON.stringify(params);
		$.ajax({      
			url: "{{Route('Causas')}}",
			type: "POST",
			data: params,
			contentType: "application/json; charset=utf-8",
			dataType: 'json',
			async: false,
			success: function (result) {
				$('#causa_H_actos_de_inv').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_actos_de_inv").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_tipos_de_actos_con_control').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.actosCon, function (key, value) {
					$("#causa_H_tipos_de_actos_con_control").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_acuerdos_prop').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_acuerdos_prop").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_masc').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_masc").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_autoridad_deriva_masc').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.autMASC, function (key, value) {
					$("#causa_H_autoridad_deriva_masc").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_tipo_suspension').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.tipoConImp, function (key, value) {
					$("#causa_H_tipo_suspension").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_audiencia_inicial').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_audiencia_inicial").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_intermedia').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_intermedia").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_estatus_mandamiento').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.estatusMJ, function (key, value) {
					$("#causa_H_estatus_mandamiento").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_etapa_suspension').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.etapaSusp, function (key, value) {
					$("#causa_H_etapa_suspension").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_etapa_sobreseimiento').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.etapaSobre, function (key, value) {
					$("#causa_H_etapa_sobreseimiento").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_etapa_proces').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.etapaProc, function (key, value) {
					$("#causa_H_etapa_proces").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_reapertura').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_reapertura").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_momento_reclas').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.momentoReclas, function (key, value) {
					$("#causa_H_momento_reclas").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				
			  },
			error: function (XMLHttpRequest, textStatus, errorThrown) {
			  alert(textStatus + ": " + XMLHttpRequest.responseText);
			  }
		  });
	  });
	
	  $("#pills-inicial-tab").click(function()
	  {
		$(".causasInicial select").html(""); 

		var params = new Object();    
		params._token = '{{csrf_token()}}';
		params.seccion = 3;
		params = JSON.stringify(params);
		$.ajax({      
			url: "{{Route('Causas')}}",
			type: "POST",
			data: params,
			contentType: "application/json; charset=utf-8",
			dataType: 'json',
			async: false,
			success: function (result) {
				$('#causa_H_decreto_legal_detencion').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNo, function (key, value) {
					$("#causa_H_decreto_legal_detencion").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_imputado_conocido').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNo, function (key, value) {
					$("#causa_H_imputado_conocido").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});   
				$('#causa_H_unidad_de_investigacion').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.unidad, function (key, value) {
					$("#causa_H_unidad_de_investigacion").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_forma_de_conduccion_del_imputado_a_proceso').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.conduccionImp, function (key, value) {
					$("#causa_H_forma_de_conduccion_del_imputado_a_proceso").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_formulacion').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_formulacion").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_causa_proceso').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.causasSus, function (key, value) {
					$("#causa_H_causa_proceso").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_medidas_cautelares').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_medidas_cautelares").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_tipo_medidas_cautelares').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.TMCautelares, function (key, value) {
					$("#causa_H_tipo_medidas_cautelares").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_forma_proceso').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.formaProc, function (key, value) {
					$("#causa_H_forma_proceso").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_liberacion').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_liberacion").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_medio_de_conocimiento').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.medioCon, function (key, value) {
					$("#causa_H_medio_de_conocimiento").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_motivo_noaud').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.motivoNoAud, function (key, value) {
					$("#causa_H_motivo_noaud").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_reclasificacion').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_reclasificacion").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_resolucion').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.resolAuto, function (key, value) {
					$("#causa_H_resolucion").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_inv_con_detenido').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNo, function (key, value) {
					$("#causa_H_inv_con_detenido").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});				
			  },
			error: function (XMLHttpRequest, textStatus, errorThrown) {
			  alert(textStatus + ": " + XMLHttpRequest.responseText);
			  }
		  });
	  });

	  $("#pills-intermedia-tab").click(function()
	  {
		$(".causasIntermedia select").html(""); 

		var params = new Object();    
		params._token = '{{csrf_token()}}';
		params.seccion = 4;
		params = JSON.stringify(params);
		$.ajax({      
			url: "{{Route('Causas')}}",
			type: "POST",
			data: params,
			contentType: "application/json; charset=utf-8",
			dataType: 'json',
			async: false,
			success: function (result) {
				$('#causa_H_medio_prueba').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_medio_prueba").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_medios_pruebas').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.mediosPruebas, function (key, value) {
					$("#causa_H_medios_pruebas").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
			  },
			error: function (XMLHttpRequest, textStatus, errorThrown) {
			  alert(textStatus + ": " + XMLHttpRequest.responseText);
			  }
		  });
	  });	

	  $("#pills-salidas-tab").click(function()
	  {
		$(".causasSalidas select").html(""); 

		var params = new Object();    
		params._token = '{{csrf_token()}}';
		params.seccion = 5;
		params = JSON.stringify(params);
		$.ajax({      
			url: "{{Route('Causas')}}",
			type: "POST",
			data: params,
			contentType: "application/json; charset=utf-8",
			dataType: 'json',
			async: false,
			success: function (result) {
				$('#causa_H_acuerdo_reparatorio').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.acuerdo, function (key, value) {
					$("#causa_H_acuerdo_reparatorio").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_suspension_condicional').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_suspension_condicional").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_acuerdos_reparatorios').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.tipoAcuerdo, function (key, value) {
					$("#causa_H_acuerdos_reparatorios").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_tipo_cumplimiento').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.tipoCump, function (key, value) {
					$("#causa_H_tipo_cumplimiento").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
			  alert(textStatus + ": " + XMLHttpRequest.responseText);
			  }
		  });
	  });

	  $("#pills-juicio-tab").click(function()
	  {
		$(".causasJuicio select").html(""); 

		var params = new Object();    
		params._token = '{{csrf_token()}}';
		params.seccion = 6;
		params = JSON.stringify(params);
		$.ajax({      
			url: "{{Route('Causas')}}",
			type: "POST",
			data: params,
			contentType: "application/json; charset=utf-8",
			dataType: 'json',
			async: false,
			success: function (result) {
				$('#causa_H_abreviado').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_abreviado").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_juicio_oral').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_juicio_oral").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_tipo_sentencia').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.tipoSentencia, function (key, value) {
					$("#causa_H_tipo_sentencia").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_firme').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_firme").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_tipos_de_pruebas').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.tipoPruebas, function (key, value) {
					$("#causa_H_tipos_de_pruebas").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
			  alert(textStatus + ": " + XMLHttpRequest.responseText);
			  }
		  });
	  });
	  
	  $("#pills-complementarios-tab").click(function()
	  {
		$(".causasComplementarios select").html(""); 

		var params = new Object();    
		params._token = '{{csrf_token()}}';
		params.seccion = 7;
		params = JSON.stringify(params);
		$.ajax({      
			url: "{{Route('Causas')}}",
			type: "POST",
			data: params,
			contentType: "application/json; charset=utf-8",
			dataType: 'json',
			async: false,
			success: function (result) {
				$('#causa_H_acusacion').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					$("#causa_H_acusacion").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_causas_sobreseimiento').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.causasSobre, function (key, value) {
					$("#causa_H_causas_sobreseimiento").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_tipo_sobreseimiento').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.tipoSobre, function (key, value) {
					$("#causa_H_tipo_sobreseimiento").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_tipo_de_recurso').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.tipoRecurso, function (key, value) {
					$("#causa_H_tipo_de_recurso").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
				$('#causa_H_tipo_masc').html('<option selected>Seleccione una opción</option>');
				$.each(result.respuestas.tipoMASC, function (key, value) {
					$("#causa_H_tipo_masc").append('<option value="' + value
						.id + '">' + value.Valor + '</option>');
				});
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
			  alert(textStatus + ": " + XMLHttpRequest.responseText);
			  }
		  });
	  });	  
	}
</script>