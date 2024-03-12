<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" id="addVictima" data-bs-target="#createVictimaForm">
  Agregar víctima
</button>
<button type="button" class="btn btn-primary" id="addVictimaT" onclick="javascript:fnVictima('0')">
  Agregar víctima
</button>
<!-- Modal -->
<div class="modal fade" id="createVictimaForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createVictimaFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createVictimaFormLabel">Agregar víctima</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @include("datos_expedientes.victimas.form")
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:saveVictima()">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  function saveVictima(){
    var respuesta=true;
    var campos=[];
      $("#frmDE_V input:not(.noValidate):visible").each(function(){
        if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}
      });      
      
      $("#frmDE_V select:not(.noValidate):visible").each(function(){
        if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}        
      });
    if (respuesta) {$("#frmDE_V").submit();}
    else
    { 
        showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
    }
  }
  
   function fnVictima(idVictima){
       // location.replace("{{ route('dash',['e3v',Request::segment(3)]) }}/"+idVictima);
        $("#idVictima").val(idVictima);
		$(".victima select").html("");
        $(".victima input").val("");
        
		var params = new Object();    
		params._token = '{{csrf_token()}}';
		params.idVictima = idVictima;
        params.carpeta = 'e3';
        params = JSON.stringify(params);
		$.ajax({      
        url: "{{Route('addVictimas')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {        
            $('#victima_municipio_nacimiento').html('<option value="-1">Seleccione una opción</option>'); 
            $('#victima_municipio_residencia').html('<option value="-1">Seleccione una opción</option>'); 
            $('.sinonoi').html('<option value="-1">Seleccione una opción</option>');
			$('.sinonoi').each( function(index){
				var sinonoiE=$(this);
				$.each(result.respuestas.SiNoNoI, function (key, value) {
					sinonoiE.append('<option value="' + value.id + '">' + value.Valor + '</option>');
				});	
			});            
            $('#victima_H_poblacion_indigena_victima').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.PobInd, function (key, value) {
                $("#victima_H_poblacion_indigena_victima").append('<option value="' + value.id + '">' 
                + value.Valor + '</option>');
            });
            $('#victima_H_lengua_victima').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.LenInd, function (key, value) {
                $("#victima_H_lengua_victima").append('<option value="' + value.id + '">' 
                + value.Valor + '</option>');
            });

            $('#victima_tipo_victima').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoVictima, function (key, value) {
                $("#victima_tipo_victima").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#victima_delitos_victima').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.delitoRelacionado, function (key, value) {
                $("#victima_delitos_victima").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#victima_sector_victimas').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sector, function (key, value) {
                $("#victima_sector_victimas").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#victima_tipo_persona_victimas').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoPersonaMoral, function (key, value) {
                $("#victima_tipo_persona_victimas").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#victima_sexo_victima').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sexo, function (key, value) {
                $("#victima_sexo_victima").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#victima_situacion_conyugal_victimas').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sConyugal, function (key, value) {
                $("#victima_situacion_conyugal_victimas").append('<option value="' + value.id + '">' + value.Valor + '</option>');
            });
            $('#victima_situacion_migratoria_victimas').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sMigratoria, function (key, value) {
                $("#victima_situacion_migratoria_victimas").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#victima_entidad_nacimiento_victimas').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.entidades, function (key, value) {
                $("#victima_entidad_nacimiento_victimas").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#victima_entidad_nacimiento_victimas').val(5).change();

            $('#victima_nacionalidad').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.paises, function (key, value) {
                $("#victima_nacionalidad").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#victima_nacionalidad').val(52);

            $('#victima_pais_nacimiento').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.paises, function (key, value) {
                $("#victima_pais_nacimiento").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#victima_pais_nacimiento').val(52);

            $('#victima_pais_residencia').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.paises, function (key, value) {
                $("#victima_pais_residencia").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#victima_pais_residencia').val(52);

            $('#victima_entidad_residencia_victimas').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.entidades, function (key, value) {
                $("#victima_entidad_residencia_victimas").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#victima_entidad_residencia_victimas').val(5).change();
            
            $('#victima_tipo_discapacidad_victimas').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoDiscapacidad, function (key, value) {
                $("#victima_tipo_discapacidad_victimas").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#victima_escolaridad').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.escolaridad, function (key, value) {
                $("#victima_escolaridad").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });			
            $('#victima_ocupacion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.ocupacion, function (key, value) {
                $("#victima_ocupacion").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });			
            $('#victima_relacion_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.relacionImp, function (key, value) {
                $("#victima_relacion_imputado").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });			
            $('#victima_tipo_de_asesoria').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoAsesoria, function (key, value) {
                $("#victima_tipo_de_asesoria").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });			
            $('#victima_tipo_lengua_extranjera_victima').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.lenguaExtranejera, function (key, value) {
                $("#victima_tipo_lengua_extranjera_victima").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });			


                $('#victima_def_tipo_defuncion').html('<option value="-1">Seleccione una opción</option>');
                $.each(result.respuestas.tipoDef, function (key, value) {
                    $("#victima_def_tipo_defuncion").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                });
                $('#victima_def_certificado_por').html('<option value="-1">Seleccione una opción</option>');
                $.each(result.respuestas.certDef, function (key, value) {
                    $("#victima_def_certificado_por").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                });
                $('#victima_def_sitio_defuncion').html('<option value="-1">Seleccione una opción</option>');
                $.each(result.respuestas.sitioDef, function (key, value) {
                    $("#victima_def_sitio_defuncion").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                });
                $('#victima_def_sitio_lesion').html('<option value="-1">Seleccione una opción</option>');
                $.each(result.respuestas.lesionDef, function (key, value) {
                    $("#victima_def_sitio_lesion").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                });
                $('#victima_def_fue_en_el_trabajo').html('<option value="-1">Seleccione una opción</option>');
                $.each(result.respuestas.SiNoNoE, function (key, value) {
                    $("#victima_def_fue_en_el_trabajo").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                });
                $('#victima_def_tipo_evento').html('<option value="-1">Seleccione una opción</option>');
                $.each(result.respuestas.eventoDef, function (key, value) {
                    $("#victima_def_tipo_evento").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                });
                $('#victima_def_tipo_victima').html('<option value="-1">Seleccione una opción</option>');
                $.each(result.respuestas.victimaDef, function (key, value) {
                    $("#victima_def_tipo_victima").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                });
                $('#victima_def_tipo_arma').html('<option value="-1">Seleccione una opción</option>');
                $.each(result.respuestas.armaDef, function (key, value) {
                    $("#victima_def_tipo_arma").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                });
                $('#victima_def_entidad_denunica').html('<option value="-1">Seleccione una opción</option>');
                $.each(result.respuestas.entidades, function (key, value) {
                    $("#victima_def_entidad_denunica").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                });
                $('#victima_def_entidad_denunica').val(5).change();
                // $('#victima_def_municipio_denunica').html('<option value="-1">Seleccione una opción</option>');
                // $.each(result.respuestas.SiNo, function (key, value) {
                //     $("#victima_def_municipio_denunica").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                // });
                $('#victima_def_entidad_defuncion').html('<option value="-1">Seleccione una opción</option>');
                $.each(result.respuestas.entidades, function (key, value) {
                    $("#victima_def_entidad_defuncion").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                });
                $('#victima_def_entidad_defuncion').val(5).change();
                // $('#victima_def_municipio_defuncion').html('<option value="-1">Seleccione una opción</option>');
                // $.each(result.respuestas.SiNo, function (key, value) {
                //     $("#victima_def_municipio_defuncion").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                // });
                $('#victima_def_condicion_embarazo').html('<option value="-1">Seleccione una opción</option>');
                $.each(result.respuestas.SiNo, function (key, value) {
                    $("#victima_def_condicion_embarazo").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                });
                $('#victima_def_periodo_posparto').html('<option value="-1">Seleccione una opción</option>');
                $.each(result.respuestas.SiNo, function (key, value) {
                    $("#victima_def_periodo_posparto").append('<option value="' + value.id + '">'+value.Valor + '</option>');
                });
            if(result.datos){
                $("#victima_tipo_victima").val(result.datos.TIPO_VICTIMA??-1).change();
                $("#victima_delitos_victima").val(result.datos.DELITOS_VICTIMA??-1);
                $("#victima_relacion_imputado").val(result.datos.RELACION_IMPUTADO??-1);
                $("#victima_razon_social").val(result.datos.RAZON_SOCIAL);
                $("#victima_representante_legal").val(result.datos.REPRESENTANTE_LEGAL??-1);
                $("#victima_H_tipo_representante_legal").val(result.datos.TIPO_REPRESENTANTE_LEGAL);
                $("#victima_asesoria").val(result.datos.ASESORIA??-1);
                $("#victima_tipo_de_asesoria").val(result.datos.TIPO_DE_ASESORIA??-1);
                $("#victima_tipo_persona_victimas").val(result.datos.TIPO_PERSONA_VICTIMAS??-1);
                $("#victima_sector_victimas").val(result.datos.SECTOR_VICTIMAS??-1);
                $("#victima_nombre_victima").val(result.datos.NOMBRE_VICTIMA);
                $("#victima_primer_apellido").val(result.datos.PRIMER_APELLIDO);
                $("#victima_segundo_apellido_victimas").val(result.datos.SEGUNDO_APELLIDO_VICTIMAS);
                $("#victima_curp_victimas").val(result.datos.CURP_VICTIMAS);
                $("#victima_fecha_nacimiento_victimas").val(result.datos.FECHA_NACIMIENTO_VICTIMAS);
                $("#victima_edad_hechos_victimas").val(result.datos.EDAD_HECHOS_VICTIMAS);
                $("#victima_sexo_victima").val(result.datos.SEXO_VICTIMA??-1);
                $("#victima_situacion_conyugal_victimas").val(result.datos.SITUACION_CONYUGAL_VICTIMAS??-1);
                $("#victima_nacionalidad").val((result.datos.NACIONALIDAD??-1)==-1?52:result.datos.NACIONALIDAD);
                $("#victima_situacion_migratoria_victimas").val(result.datos.SITUACION_MIGRATORIA_VICTIMAS??-1);
                $("#victima_pais_nacimiento").val((result.datos.PAIS_NACIMIENTO??-1)==-1?52:result.datos.PAIS_NACIMIENTO);
                $("#victima_entidad_nacimiento_victimas").val((result.datos.ENTIDAD_NACIMIENTO_VICTIMAS??-1)==-1?5:result.datos.ENTIDAD_NACIMIENTO_VICTIMAS).change();
                $("#victima_municipio_nacimiento").val(result.datos.MUNICIPIO_NACIMIENTO??-1);
                
                $("#victima_pais_residencia").val((result.datos.PAIS_RESIDENCIA??-1)==-1?52:result.datos.PAIS_RESIDENCIA);
                $("#victima_entidad_residencia_victimas").val((result.datos.ENTIDAD_RESIDENCIA_VICTIMAS??-1)==-1?5:result.datos.ENTIDAD_RESIDENCIA_VICTIMAS).change();
                $("#victima_municipio_residencia").val(result.datos.MUNICIPIO_RESIDENCIA??-1);
                
                $("#victima_telefono_victimas").val(result.datos.TELEFONO_VICTIMAS);
                $("#victima_H_domicilio_victima").val(result.datos.DOMICILIO_VICTIMA);
                // $("#victima_H_victima_id").val(result.datos.VICTIMA_ID);
                $("#victima_H_ingreso_victima").val(result.datos.INGRESO_VICTIMA);
                $("#victima_habla_español_victima").val(result.datos.HABLA_ESPAÑOL_VICTIMA??-1);
                $("#victima_habla_leng_extr_victima").val(result.datos.HABLA_LENG_EXTR_VICTIMA??-1);
                $("#victima_tipo_lengua_extranjera_victima").val(result.datos.TIPO_LENGUA_EXTRANJERA_VICTIMA??-1);
                $("#victima_traductor_victima").val(result.datos.TRADUCTOR_VICTIMA??-1);
                $("#victima_interprete").val(result.datos.INTERPRETE??-1);
                $("#victima_discapacidad_victimas").val(result.datos.DISCAPACIDAD_VICTIMAS??-1);
                $("#victima_tipo_discapacidad_victimas").val(result.datos.TIPO_DISCAPACIDAD_VICTIMAS??-1);
                $("#victima_interprete_por_discapacidad_victima").val(result.datos.INTERPRETE_POR_DISCAPACIDAD_VICTIMA??-1);
                $("#victima_aten_medica").val(result.datos.ATEN_MEDICA??-1);
                $("#victima_aten_psicologica").val(result.datos.ATEN_PSICOLOGICA??-1);
                $("#victima_H_numero_de_atencion").val(result.datos.NUMERO_DE_ATENCION);
                $("#victima_poblacion_calle").val(result.datos.POBLACION_CALLE??-1);
                $("#victima_leer_escribir").val(result.datos.LEER_ESCRIBIR??-1);
                $("#victima_escolaridad").val(result.datos.ESCOLARIDAD??-1);
                $("#victima_ocupacion").val(result.datos.OCUPACION??-1);
                $("#victima_H_se_identifica_indigena_victima").val(result.datos.SE_IDENTIFICA_INDIGENA_VICTIMA??-1);
                $("#victima_H_poblacion_indigena_victima").val(result.datos.POBLACION_INDIGENA_VICTIMA??-1);
                $("#victima_habla_leng_indig_victima").val(result.datos.HABLA_LENG_INDIG_VICTIMA??-1);
                $("#victima_H_lengua_victima").val(result.datos.LENGUA_VICTIMA??-1);
                $("#victima_victima_violencia").val(result.datos.VICTIMA_VIOLENCIA??-1);
                $("#victima_H_vestimenta_victima").val(result.datos.VESTIMENTA_VICTIMA);
                  $("#victima_def_folio_defuncion").val(result.datos.DEF_FOLIO_DEFUNCION);
                  $("#victima_def_fecha_exp").val(result.datos.DEF_FECHA_EXP);
                  $("#victima_def_fecha_defuncion").val(result.datos.DEF_FECHA_DEFUNCION);
                  $("#victima_def_tipo_defuncion").val(result.datos.DEF_TIPO_DEFUNCION??-1);
                  $("#victima_def_certificado_por").val(result.datos.DEF_CERTIFICADO_POR??-1);
                  $("#victima_def_sitio_defuncion").val(result.datos.DEF_SITIO_DEFUNCION??-1);
                  $("#victima_def_sitio_lesion").val(result.datos.DEF_SITIO_LESION??-1);
                  $("#victima_def_fue_en_el_trabajo").val(result.datos.DEF_FUE_EN_EL_TRABAJO??-1);
                  $("#victima_def_agente_externo").val(result.datos.DEF_AGENTE_EXTERNO);
                  $("#victima_def_tipo_evento").val(result.datos.DEF_TIPO_EVENTO??-1);
                  $("#victima_def_tipo_victima").val(result.datos.DEF_TIPO_VICTIMA??-1);
                  $("#victima_def_tipo_arma").val(result.datos.DEF_TIPO_ARMA??-1);
                  $("#victima_def_entidad_denunica").val((result.datos.DEF_ENTIDAD_DENUNICA??-1) == -1 ? 5 : result.datos.DEF_ENTIDAD_DENUNICA).change();
                  $("#victima_def_municipio_denunica").val(result.datos.DEF_MUNICIPIO_DENUNICA??-1);
                  $("#victima_def_colonia_denunica").val(result.datos.DEF_COLONIA_DENUNICA);
                  $("#victima_def_entidad_defuncion").val((result.datos.DEF_ENTIDAD_DEFUNCION??-1) == -1 ? 5 : result.datos.DEF_ENTIDAD_DEFUNCION).change();
                  $("#victima_def_municipio_defuncion").val(result.datos.DEF_MUNICIPIO_DEFUNCION??-1);
                  $("#victima_def_colonia_defuncion").val(result.datos.DEF_COLONIA_DEFUNCION);
                  $("#victima_def_causa_a").val(result.datos.DEF_CAUSA_A);
                  $("#victima_def_duracion_bcd").val(result.datos.DEF_DURACION_BCD);
                  $("#victima_def_estado_patologico").val(result.datos.DEF_ESTADO_PATOLOGICO);
                  $("#victima_def_duracion_patologico").val(result.datos.DEF_DURACION_PATOLOGICO);
                  $("#victima_def_condicion_embarazo").val(result.datos.DEF_CONDICION_EMBARAZO??-1);
                  $("#victima_def_periodo_posparto").val(result.datos.DEF_PERIODO_POSPARTO??-1);

            }
            SiDefuncion();
            $('#addVictima').click();
          },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });
	}
</script>