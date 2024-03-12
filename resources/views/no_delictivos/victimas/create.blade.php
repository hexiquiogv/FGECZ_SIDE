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
        @include("no_delictivos.victimas.form")
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
      params.carpeta = 'he';
		params = JSON.stringify(params);
		$.ajax({      
        url: "{{Route('addVictimas')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {            
						
			      $('#nodVictima_tipo_victima_no_delictivo').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipoVictima, function (key, value) {
                $("#nodVictima_tipo_victima_no_delictivo").append('<option value="' + value.id + '">'+value.Valor + '</option>');
            });
            $('#nodVictima_sexo').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sexo, function (key, value) {
                $("#nodVictima_sexo").append('<option value="' + value.id + '">'+value.Valor + '</option>');
            });
            $('#nodVictima_sit_conyugal_victimas_no_delictivo').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.sConyugal, function (key, value) {
                $("#nodVictima_sit_conyugal_victimas_no_delictivo").append('<option value="' + value.id + '">'+value.Valor + '</option>');
            });
            $('#victima_nacionalidad').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.paises, function (key, value) {
                $("#victima_nacionalidad").append('<option value="' + value.id + '">' + value.Valor + '</option>');
            });
            $('#victima_nacionalidad').val(52);
            $('#nodVictima_escolaridad').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.escolaridad, function (key, value) {
                $("#nodVictima_escolaridad").append('<option value="' + value.id + '">'+value.Valor + '</option>');
            });			
            $('#nodVictima_ocupacion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.ocupacion, function (key, value) {
                $("#nodVictima_ocupacion").append('<option value="' + value.id + '">'+value.Valor + '</option>');
            });			
            $('#nodVictima_occiso').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.SiNo, function (key, value) {
                $("#nodVictima_occiso").append('<option value="' + value.id + '">'+value.Valor + '</option>');
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
                $("#victima_nombre_victima").val(result.datos.NOMBRE_VICTIMA);
                $("#victima_edad_hechos_victimas").val(result.datos.EDAD_HECHOS_VICTIMAS);              
                
              $("#nodVictima_tipo_victima_no_delictivo").val(result.datos.TIPO_VICTIMA_NO_DELICTIVO??-1).change();
              $("#nodVictima_primer_apellido").val(result.datos.PRIMER_APELLIDO);
              $("#nodVictima_segundo_apellido_victimas_no_delictivo").val(result.datos.SEGUNDO_APELLIDO_VICTIMAS_NO_DELICTIVO);
              $("#nodVictima_sexo").val(result.datos.SEXO??-1);
              $("#nodVictima_sit_conyugal_victimas_no_delictivo").val(result.datos.SIT_CONYUGAL_VICTIMAS_NO_DELICTIVO??-1);
              $("#victima_nacionalidad").val((result.datos.NACIONALIDAD??-1)==-1?52:result.datos.NACIONALIDAD);
              $("#nodVictima_escolaridad").val(result.datos.ESCOLARIDAD??-1);
              $("#nodVictima_ocupacion").val(result.datos.OCUPACION??-1);
              $("#nodVictima_fecha_nacimiento").val(result.datos.FECHA_NACIMIENTO??-1);
              $("#nodVictima_occiso").val(result.datos.OCCISO??-1).change();
            
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