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
        @include("carpeta_conduccion.victimas.form")
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
            $("#idVictima").val(idVictima);
        $(".victima select").html("");
        $(".victima input").val("");

		var params = new Object();    
        params._token = '{{csrf_token()}}';
        params.idVictima = idVictima;
        params.carpeta = 'd9';
		params = JSON.stringify(params);
		$.ajax({      
        url: "{{Route('addVictimas')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {
            $('#conduccionVictima_municipio_nacimiento').html('<option value="-1">seleccione una opción</option>'); 
            $('#conduccionVictima_municipio_residencia').html('<option value="-1">seleccione una opción</option>'); 
            $('.sinonoi').html('<option value="-1">Seleccione una opción</option>');
            $('.sinonoi').each( function(index){
                var sinonoiE=$(this);
                $.each(result.respuestas.SiNoNoI, function (key, value) {
                    sinonoiE.append('<option value="' + value.id + '">' + value.Valor + '</option>');
                }); 
            }); 
            $('#victima_sexo_victima').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sexo, function (key, value) {
                $("#victima_sexo_victima").append('<option value="' + value.id + '">' 
                + value.Valor + '</option>');
            });
            $('#victima_tipo_lengua_extranjera_victima').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.lenguaExtranejera, function (key, value) {
                $("#victima_tipo_lengua_extranjera_victima").append('<option value="' + value.id + '">' 
                + value.Valor + '</option>');
            }); 
            
            $('#victima_tipo_discapacidad_victimas').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoDiscapacidad, function (key, value) {
                $("#victima_tipo_discapacidad_victimas").append('<option value="' + value.id + '">' 
                + value.Valor + '</option>');
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
            $('#victima_tipo_de_asesoria').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoAsesoria, function (key, value) {
                $("#victima_tipo_de_asesoria").append('<option value="' + value.id + '">' 
                + value.Valor + '</option>');
            }); 

			$('#conduccionVictima_tipo_victima_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoVictima, function (key, value) {
                $("#conduccionVictima_tipo_victima_conduccion").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#conduccionVictima_delitos_victima_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.delitoRelacionado, function (key, value) {
                $("#conduccionVictima_delitos_victima_conduccion").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#conduccionVictima_sector_victimas_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sector, function (key, value) {
                $("#conduccionVictima_sector_victimas_conduccion").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#conduccionVictima_tipo_persona_victimas_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoPersonaMoral, function (key, value) {
                $("#conduccionVictima_tipo_persona_victimas_conduccion").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#conduccionVictima_situacion_conyugal_victimas_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sConyugal, function (key, value) {
                $("#conduccionVictima_situacion_conyugal_victimas_conduccion").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#conduccionVictima_situacion_migratoria_victimas_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sMigratoria, function (key, value) {
                $("#conduccionVictima_situacion_migratoria_victimas_conduccion").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#conduccionVictima_entidad_nacimiento_victimas_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.entidades, function (key, value) {
                $("#conduccionVictima_entidad_nacimiento_victimas_conduccion").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#conduccionVictima_entidad_nacimiento_victimas_conduccion').val(5).change();

            $('#conduccionVictima_nacionalidad').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.paises, function (key, value) {
                $("#conduccionVictima_nacionalidad").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#conduccionVictima_nacionalidad').val(52);

            $('#conduccionVictima_pais_nacimiento').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.paises, function (key, value) {
                $("#conduccionVictima_pais_nacimiento").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#conduccionVictima_pais_nacimiento').val(52);

            $('#conduccionVictima_pais_residencia').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.paises, function (key, value) {
                $("#conduccionVictima_pais_residencia").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#conduccionVictima_pais_residencia').val(52);

            $('#conduccionVictima_entidad_residencia_victimas_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.entidades, function (key, value) {
                $("#conduccionVictima_entidad_residencia_victimas_conduccion").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });
            $('#conduccionVictima_entidad_residencia_victimas_conduccion').val(5).change();

            $('#conduccionVictima_escolaridad').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.escolaridad, function (key, value) {
                $("#conduccionVictima_escolaridad").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });			
            $('#conduccionVictima_ocupacion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.ocupacion, function (key, value) {
                $("#conduccionVictima_ocupacion").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });			
            $('#conduccionVictima_relacion_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.relacionImp, function (key, value) {
                $("#conduccionVictima_relacion_imputado").append('<option value="' + value.id + '">' 
				+ value.Valor + '</option>');
            });		
            if(result.datos){
                    $("#victima_H_tipo_representante_legal").val(result.datos.TIPO_REPRESENTANTE_LEGAL);
                    $("#victima_asesoria").val(result.datos.ASESORIA??-1);
                    $("#victima_tipo_de_asesoria").val(result.datos.TIPO_DE_ASESORIA??-1);
                    $("#victima_nombre_victima").val(result.datos.NOMBRE_VICTIMA);
                    $("#victima_curp_victimas").val(result.datos.CURP_VICTIMAS);
                    $("#victima_fecha_nacimiento_victimas").val(result.datos.FECHA_NACIMIENTO_VICTIMAS);
                    $("#victima_edad_hechos_victimas").val(result.datos.EDAD_HECHOS_VICTIMAS);
                    $("#victima_sexo_victima").val(result.datos.SEXO_VICTIMA??-1);
                    $("#victima_H_domicilio_victima").val(result.datos.DOMICILIO_VICTIMA);
                    $("#victima_H_ingreso_victima").val(result.datos.INGRESO_VICTIMA);
                    $("#victima_habla_español_victima").val(result.datos.HABLA_ESPAÑOL_VICTIMA??-1);
                    $("#victima_habla_leng_extr_victima").val(result.datos.HABLA_LENG_EXTR_VICTIMA??-1);
                    $("#victima_tipo_lengua_extranjera_victima").val(result.datos.TIPO_LENGUA_EXTRANJERA_VICTIMA??-1);
                    $("#victima_discapacidad_victimas").val(result.datos.DISCAPACIDAD_VICTIMAS??-1);
                    $("#victima_tipo_discapacidad_victimas").val(result.datos.TIPO_DISCAPACIDAD_VICTIMAS??-1);
                    $("#victima_interprete_por_discapacidad_victima").val(result.datos.INTERPRETE_POR_DISCAPACIDAD_VICTIMA??-1);
                    $("#victima_aten_medica").val(result.datos.ATEN_MEDICA??-1);
                    $("#victima_aten_psicologica").val(result.datos.ATEN_PSICOLOGICA??-1);
                    $("#victima_H_se_identifica_indigena_victima").val(result.datos.SE_IDENTIFICA_INDIGENA_VICTIMA??-1);
                    $("#victima_H_poblacion_indigena_victima").val(result.datos.POBLACION_INDIGENA_VICTIMA??-1);
                    $("#victima_habla_leng_indig_victima").val(result.datos.HABLA_LENG_INDIG_VICTIMA??-1);
                    $("#victima_H_lengua_victima").val(result.datos.LENGUA_VICTIMA??-1);
                    $("#victima_victima_violencia").val(result.datos.VICTIMA_VIOLENCIA??-1);
                    $("#victima_H_vestimenta_victima").val(result.datos.VESTIMENTA_VICTIMA);                
                
                $("#conduccionVictima_tipo_victima_conduccion").val(result.datos.TIPO_VICTIMA_CONDUCCION??-1).change();
                $("#conduccionVictima_interprete_victimas_conduccion").val(result.datos.INTERPRETE_VICTIMAS_CONDUCCION??-1);
                $("#conduccionVictima_delitos_victima_conduccion").val(result.datos.DELITOS_VICTIMA_CONDUCCION??-1);
                $("#conduccionVictima_razon_social").val(result.datos.RAZON_SOCIAL);
                $("#conduccionVictima_representante_legal").val(result.datos.REPRESENTANTE_LEGAL??-1);
                $("#conduccionVictima_sector_victimas_conduccion").val(result.datos.SECTOR_VICTIMAS_CONDUCCION??-1);
                $("#conduccionVictima_tipo_persona_victimas_conduccion").val(result.datos.TIPO_PERSONA_VICTIMAS_CONDUCCION??-1);
                $("#conduccionVictima_primer_apellido").val(result.datos.PRIMER_APELLIDO);
                $("#conduccionVictima_segundo_apellido_victimas_conduccion").val(result.datos.SEGUNDO_APELLIDO_VICTIMAS_CONDUCCION);
                $("#conduccionVictima_telefono_victimas_conduccion").val(result.datos.TELEFONO_VICTIMAS_CONDUCCION);
                $("#conduccionVictima_situacion_conyugal_victimas_conduccion").val(result.datos.SITUACION_CONYUGAL_VICTIMAS_CONDUCCION??-1);
                $("#conduccionVictima_nacionalidad").val((result.datos.NACIONALIDAD??-1)==-1?52:result.datos.NACIONALIDAD);
                $("#conduccionVictima_situacion_migratoria_victimas_conduccion").val(result.datos.SITUACION_MIGRATORIA_VICTIMAS_CONDUCCION??-1);
                $("#conduccionVictima_pais_nacimiento").val((result.datos.PAIS_NACIMIENTO??-1)==-1?52:result.datos.PAIS_NACIMIENTO);
                $("#conduccionVictima_entidad_nacimiento_victimas_conduccion").val((result.datos.ENTIDAD_NACIMIENTO_VICTIMAS_CONDUCCION??-1)==-1?5:result.datos.ENTIDAD_NACIMIENTO_VICTIMAS_CONDUCCION).change();
                $("#conduccionVictima_municipio_nacimiento").val(result.datos.MUNICIPIO_NACIMIENTO??-1);
                $("#conduccionVictima_pais_residencia").val((result.datos.PAIS_RESIDENCIA??-1)==-1?52:result.datos.PAIS_RESIDENCIA);
                $("#conduccionVictima_entidad_residencia_victimas_conduccion").val((result.datos.ENTIDAD_RESIDENCIA_VICTIMAS_CONDUCCION??-1)==-1?5:result.datos.ENTIDAD_RESIDENCIA_VICTIMAS_CONDUCCION).change();
                $("#conduccionVictima_municipio_residencia").val(result.datos.MUNICIPIO_RESIDENCIA??-1);
                $("#conduccionVictima_traductor_victimas_conduccion").val(result.datos.TRADUCTOR_VICTIMAS_CONDUCCION??-1);
                $("#conduccionVictima_poblacion_calle").val(result.datos.POBLACION_CALLE??-1);
                $("#conduccionVictima_leer_escribir").val(result.datos.LEER_ESCRIBIR??-1);
                $("#conduccionVictima_escolaridad").val(result.datos.ESCOLARIDAD??-1);
                $("#conduccionVictima_ocupacion").val(result.datos.OCUPACION??-1);
                $("#conduccionVictima_relacion_imputado").val(result.datos.RELACION_IMPUTADO??-1);
            }
            $('#addVictima').click();
	
          },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });
	}
</script>