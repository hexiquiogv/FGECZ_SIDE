<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" id="addImputado" data-bs-target="#createImputadoForm">
  Agregar imputado
</button>
<button type="button" class="btn btn-primary" id="addImputadoT" onclick="javascript:fnImputado('0')">
  Agregar imputado
</button>
<!-- Modal -->
<div class="modal fade" id="createImputadoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createImputadoFormLabel" 
    aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createImputadoFormLabel">Agregar imputado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @include("carpeta_conduccion.imputados.form")
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:saveImputado()">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function saveImputado(){
    var respuesta=true;
    var campos=[];
      $("#frmDE_I input:not(.noValidate):visible").each(function(){
        if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}
      });      
      
      $("#frmDE_I select:not(.noValidate):visible").each(function(){
        if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}        
      });
      if ($("#conduccionImputado_folio_rnd").val().length<1 && !($("#conduccionImputado_folio_rnd").hasClass('noValidate')) ) {
        if ($("#conduccionImputado_razon_rnd").val()<1) {respuesta=false;$("#conduccionImputado_razon_rnd").addClass("border-3 border-danger");campos.push("conduccionImputado_razon_rnd" );}
        else{$("#conduccionImputado_razon_rnd").removeClass("border-3 border-danger");}
      }
      else
      {$("#conduccionImputado_razon_rnd").removeClass("border-3 border-danger");}      
    if (respuesta) {$("#frmDE_I").submit();}
    else
    { 
        showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
    }
  }
    function fnImputado(idImputado){ 

        $("#idImputado").val(idImputado);
        $(".imputado select").html("");  
        $(".imputado input").val("");

        var params = new Object();    
        params._token = '{{csrf_token()}}';
        params.idImputado = idImputado;
        params.carpeta = 'd9';
		params = JSON.stringify(params);
		$.ajax({      
        url: "{{Route('addImputados')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {
			$('#conduccionImputado_municipio_nacimiento').html('<option value="-1">seleccione una opción</option>'); 
			$('#conduccionImputado_municipio_residencia').html('<option value="-1">seleccione una opción</option>'); 


            $('#conduccionImputado_interprete_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#conduccionImputado_interprete_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_tipo_imputado_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoImputado, function (key, value) {
                $("#conduccionImputado_tipo_imputado_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            
            $('#conduccionImputado_sector_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sector, function (key, value) {
                $("#conduccionImputado_sector_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_tipo_persona_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoPersonaMoral, function (key, value) {
                $("#conduccionImputado_tipo_persona_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_delitos_imputado_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.delitoRelacionado, function (key, value) {
                $("#conduccionImputado_delitos_imputado_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_relacion_victima').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.relacionVict, function (key, value) {
                $("#conduccionImputado_relacion_victima").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_situacion_conyugal_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sConyugal, function (key, value) {
                $("#conduccionImputado_situacion_conyugal_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_nacionalidad').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.paises, function (key, value) {
                $("#conduccionImputado_nacionalidad").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_nacionalidad').val(52);

            $('#conduccionImputado_situacion_migratoria_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sMigratoria, function (key, value) {
                $("#conduccionImputado_situacion_migratoria_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_pais_nacimiento').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.paises, function (key, value) {
                $("#conduccionImputado_pais_nacimiento").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_pais_nacimiento').val(52);

            $('#conduccionImputado_entidad_nacimiento_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.entidades, function (key, value) {
                $("#conduccionImputado_entidad_nacimiento_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_entidad_nacimiento_imputados_conduccion').val(5).change();

            $('#conduccionImputado_pais_residencia').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.paises, function (key, value) {
                $("#conduccionImputado_pais_residencia").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_pais_residencia').val(52);

            $('#conduccionImputado_entidad_residencia_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.entidades, function (key, value) {
                $("#conduccionImputado_entidad_residencia_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_entidad_residencia_imputados_conduccion').val(5).change();

            $('#conduccionImputado_traductor_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#conduccionImputado_traductor_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            

            $('#conduccionImputado_poblacion_calle').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#conduccionImputado_poblacion_calle").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_leer_escribir_imputados').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#conduccionImputado_leer_escribir_imputados").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_detenido_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNo, function (key, value) {
                $("#conduccionImputado_detenido_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_estado_imputado_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.situacionImp, function (key, value) {
                $("#conduccionImputado_estado_imputado_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_tipo_detencion_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoDetencion, function (key, value) {
                $("#conduccionImputado_tipo_detencion_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_entidad_detencion_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.entidades, function (key, value) {
                $("#conduccionImputado_entidad_detencion_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_autoridad_detencion_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.autDetencion, function (key, value) {
                $("#conduccionImputado_autoridad_detencion_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_razon_rnd').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.razonRND, function (key, value) {
                $("#conduccionImputado_razon_rnd").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_examen_detencion_imputados_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.examen, function (key, value) {
                $("#conduccionImputado_examen_detencion_imputados_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_estado_presentacion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.estadoPres, function (key, value) {
                $("#conduccionImputado_estado_presentacion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionImputado_lesionado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#conduccionImputado_lesionado").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });


            $('#conduccionImputado_representante_legal').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#conduccionImputado_representante_legal").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_rel_pers_moral').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#imputado_rel_pers_moral").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_H_imputado_conocido').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNo, function (key, value) {
                $("#imputado_H_imputado_conocido").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_sexo_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sexo, function (key, value) {
                $("#imputado_sexo_imputado").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_H_habla_español_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#imputado_H_habla_español_imputado").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_H_habla_leng_extr_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#imputado_H_habla_leng_extr_imputado").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_H_tipo_lengua_extranjera_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.lenguaExtranejera, function (key, value) {
                $("#imputado_H_tipo_lengua_extranjera_imputado").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_discapacidad_imputados').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#imputado_discapacidad_imputados").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_tipo_discapacidad_imputados').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoDiscapacidad, function (key, value) {
                $("#imputado_tipo_discapacidad_imputados").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_interprete_por_discapacidad_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#imputado_interprete_por_discapacidad_imputado").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_escolaridad_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.escolaridad, function (key, value) {
                $("#imputado_escolaridad_imputado").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_H_ocupacion_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.ocupacion, function (key, value) {
                $("#imputado_H_ocupacion_imputado").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_H_se_identifica_indigena_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#imputado_H_se_identifica_indigena_imputado").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_H_indigena_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.PobInd, function (key, value) {
                $("#imputado_H_indigena_imputado").append('<option value="' + value.id + '">' 
                + value.Valor + '</option>');
            });
            $('#imputado_H_habla_leng_indig_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#imputado_H_habla_leng_indig_imputado").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_H_lengua_imputado').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.LenInd, function (key, value) {
                $("#imputado_H_lengua_imputado").append('<option value="' + value.id + '">' 
                + value.Valor + '</option>');
            });            
            $('#imputado_H_antecedentes').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#imputado_H_antecedentes").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_H_defensa').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNoNoI, function (key, value) {
                $("#imputado_H_defensa").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_H_tipo_defensa').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoAsesDef, function (key, value) {
                $("#imputado_H_tipo_defensa").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_H_tipo_mandamiento').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoMand, function (key, value) {
                $("#imputado_H_tipo_mandamiento").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#imputado_H_grado_de_participacion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.gradoPart, function (key, value) {
                $("#imputado_H_grado_de_participacion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });

            if(result.datos){
                    $("#imputado_H_tipo_representante_legal").val(result.datos.TIPO_REPRESENTANTE_LEGAL);                
                    $("#imputado_rel_pers_moral").val(result.datos.REL_PERS_MORAL??-1);
                    $("#imputado_alias_imputado").val(result.datos.ALIAS_IMPUTADO);
                    $("#imputado_H_imputado_conocido").val(result.datos.IMPUTADO_CONOCIDO??-1);    
                    $("#imputado_nombre_imputado").val(result.datos.NOMBRE_IMPUTADO);
                    $("#imputado_curp_imputados").val(result.datos.CURP_IMPUTADOS);
                    $("#imputado_fecha_nacimiento_imputados").val(result.datos.FECHA_NACIMIENTO_IMPUTADOS);
                    $("#imputado_edad_hechos_imputados").val(result.datos.EDAD_HECHOS_IMPUTADOS);       
                    $("#imputado_sexo_imputado").val(result.datos.SEXO_IMPUTADO??-1);
                    $("#imputado_H_domicilio_imputado").val(result.datos.DOMICILIO_IMPUTADO);
                    $("#imputado_H_ingreso_imputado").val(result.datos.INGRESO_IMPUTADO);
                    $("#imputado_H_habla_español_imputado").val(result.datos.HABLA_ESPAÑOL_IMPUTADO??-1);
                    $("#imputado_H_habla_leng_extr_imputado").val(result.datos.HABLA_LENG_EXTR_IMPUTADO??-1);
                    $("#imputado_H_tipo_lengua_extranjera_imputado").val(result.datos.TIPO_LENGUA_EXTRANJERA_IMPUTADO??-1);
                    $("#imputado_discapacidad_imputados").val(result.datos.DISCAPACIDAD_IMPUTADOS??-1);
                    $("#imputado_tipo_discapacidad_imputados").val(result.datos.TIPO_DISCAPACIDAD_IMPUTADOS??-1);
                    $("#imputado_interprete_por_discapacidad_imputado").val(result.datos.INTERPRETE_POR_DISCAPACIDAD_IMPUTADO??-1);
                    $("#imputado_escolaridad_imputado").val(result.datos.ESCOLARIDAD_IMPUTADO??-1);
                    $("#imputado_H_ocupacion_imputado").val(result.datos.OCUPACION_IMPUTADO??-1);
                    $("#imputado_H_se_identifica_indigena_imputado").val(result.datos.SE_IDENTIFICA_INDIGENA_IMPUTADO??-1);
                    $("#imputado_H_indigena_imputado").val(result.datos.INDIGENA_IMPUTADO??-1);
                    $("#imputado_H_habla_leng_indig_imputado").val(result.datos.HABLA_LENG_INDIG_IMPUTADO??-1);
                    $("#imputado_H_lengua_imputado").val(result.datos.LENGUA_IMPUTADO??-1);
                    $("#imputado_H_nombre_de_grupo").val(result.datos.NOMBRE_DE_GRUPO);                    
                    $("#imputado_H_antecedentes").val(result.datos.ANTECEDENTES??-1);
                    $("#imputado_H_defensa").val(result.datos.DEFENSA??-1);
                    $("#imputado_H_tipo_defensa").val(result.datos.TIPO_DEFENSA??-1);
                    $("#imputado_H_media_filiacion_imputado").val(result.datos.MEDIA_FILIACION_IMPUTADO);
                    $("#imputado_H_tipo_mandamiento").val(result.datos.TIPO_MANDAMIENTO??-1);
                    $("#imputado_H_grado_de_participacion").val(result.datos.GRADO_DE_PARTICIPACION??-1);

                $("#conduccionImputado_tipo_imputado_conduccion").val(result.datos.TIPO_IMPUTADO_CONDUCCION??-1).change();
                $("#conduccionImputado_razon_social").val(result.datos.RAZON_SOCIAL);
                $("#conduccionImputado_primer_apellido").val(result.datos.PRIMER_APELLIDO);
                $("#conduccionImputado_segundo_apellido_imputados_conduccion").val(result.datos.SEGUNDO_APELLIDO_IMPUTADOS_CONDUCCION);
                $("#conduccionImputado_telefono_imputados_conduccion").val(result.datos.TELEFONO_IMPUTADOS_CONDUCCION);
                $("#conduccionImputado_sector_imputados_conduccion").val(result.datos.SECTOR_IMPUTADOS_CONDUCCION??-1);
                $("#conduccionImputado_tipo_persona_imputados_conduccion").val(result.datos.TIPO_PERSONA_IMPUTADOS_CONDUCCION??-1);
                $("#conduccionImputado_delitos_imputado_conduccion").val(result.datos.DELITOS_IMPUTADO_CONDUCCION??-1);
                $("#conduccionImputado_relacion_victima").val(result.datos.RELACION_VICTIMA??-1);
                $("#conduccionImputado_situacion_conyugal_imputados_conduccion").val(result.datos.SITUACION_CONYUGAL_IMPUTADOS_CONDUCCION??-1);
                $("#conduccionImputado_nacionalidad").val((result.datos.NACIONALIDAD??-1)==-1?52:result.datos.NACIONALIDAD);
                $("#conduccionImputado_situacion_migratoria_imputados_conduccion").val(result.datos.SITUACION_MIGRATORIA_IMPUTADOS_CONDUCCION??-1);
                $("#conduccionImputado_pais_nacimiento").val((result.datos.PAIS_NACIMIENTO??-1)==-1?52:result.datos.PAIS_NACIMIENTO);
                $("#conduccionImputado_entidad_nacimiento_imputados_conduccion").val((result.datos.ENTIDAD_NACIMIENTO_IMPUTADOS_CONDUCCION??-1)==-1?5:result.datos.ENTIDAD_NACIMIENTO_IMPUTADOS_CONDUCCION).change();
                $("#conduccionImputado_municipio_nacimiento").val(result.datos.MUNICIPIO_NACIMIENTO??-1);
                $("#conduccionImputado_pais_residencia").val((result.datos.PAIS_RESIDENCIA??-1)==-1?52:result.datos.PAIS_RESIDENCIA);
                $("#conduccionImputado_entidad_residencia_imputados_conduccion").val((result.datos.ENTIDAD_RESIDENCIA_IMPUTADOS_CONDUCCION??-1)==-1?5:result.datos.ENTIDAD_RESIDENCIA_IMPUTADOS_CONDUCCION).change();
                $("#conduccionImputado_municipio_residencia").val(result.datos.MUNICIPIO_RESIDENCIA??-1);
                $("#conduccionImputado_traductor_imputados_conduccion").val(result.datos.TRADUCTOR_IMPUTADOS_CONDUCCION??-1);
                $("#conduccionImputado_poblacion_calle").val(result.datos.POBLACION_CALLE??-1);
                $("#conduccionImputado_leer_escribir_imputados").val(result.datos.LEER_ESCRIBIR_IMPUTADOS??-1);
                $("#conduccionImputado_detenido_imputados_conduccion").val(result.datos.DETENIDO_IMPUTADOS_CONDUCCION??-1);
                $("#conduccionImputado_estado_imputado_conduccion").val(result.datos.ESTADO_IMPUTADO_CONDUCCION??-1);
                $("#conduccionImputado_fecha_detencion_conduccion").val(result.datos.FECHA_DETENCION_CONDUCCION);
                $("#conduccionImputado_hora_detencion").val(result.datos.HORA_DETENCION);
                $("#conduccionImputado_tipo_detencion_imputados_conduccion").val(result.datos.TIPO_DETENCION_IMPUTADOS_CONDUCCION??-1);
                $("#conduccionImputado_entidad_detencion_imputados_conduccion").val(result.datos.ENTIDAD_DETENCION_IMPUTADOS_CONDUCCION??-1);
                $("#conduccionImputado_autoridad_detencion_imputados_conduccion").val(result.datos.AUTORIDAD_DETENCION_IMPUTADOS_CONDUCCION??-1);
                $("#conduccionImputado_folio_rnd").val(result.datos.FOLIO_RND);
                $("#conduccionImputado_razon_rnd").val(result.datos.RAZON_RND??-1);
                $("#conduccionImputado_examen_detencion_imputados_conduccion").val(result.datos.EXAMEN_DETENCION_IMPUTADOS_CONDUCCION??-1);
                $("#conduccionImputado_lesionado").val(result.datos.LESIONADO??-1);
                $("#conduccionImputado_estado_presentacion").val(result.datos.ESTADO_PRESENTACION??-1);
                $("#conduccionImputado_representante_legal").val(result.datos.REPRESENTANTE_LEGAL??-1);
                $("#conduccionImputado_interprete_imputados_conduccion").val(result.datos.INTERPRETE_IMPUTADOS_CONDUCCION??-1);
            }
            $('#addImputado').click();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });
    }

</script>
