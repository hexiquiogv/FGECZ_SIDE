<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" id="addDelito" data-bs-target="#createDelitoForm">
  agregar delito
</button>
<button type="button" class="btn btn-primary" id="addDelitoT" onclick="javascript:fnDelito('0')">
  Agregar delito
</button>
<!-- Modal -->

<div class="modal fade" id="createDelitoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createDelitoFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createDelitoFormLabel">Agregar delito</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @include("carpeta_conduccion.hechos.form")
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:saveDelito()">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function saveDelito(){
    var respuesta=true;
    var campos=[];
      $("#frmDE_D input:not(.noValidate):visible").each(function(){
        if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}
      });      
      
      $("#frmDE_D select:not(.noValidate):visible").each(function(){
        if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}        
      });
    if (respuesta) {$("#frmDE_D").submit();}
    else
    { 
        showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
    }
  }
   function fnDelito(idDelito){ 
        
        $("#idDelito").val(idDelito);
        $(".delitos select").html("");  
        $(".delitos input").val("");
        $("#conduccionDelito_delito_JUR_Display").hide();

        var params = new Object();    
        params._token = '{{csrf_token()}}';
        params.idDelito = idDelito;
        params.carpeta = 'd9';
		params = JSON.stringify(params);
		$.ajax({      
        url: "{{Route('addDelitos')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {
            // $('#conduccionDelito_entidad_hechos_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $('#conduccionDelito_delito_JUR').html('<option value="-1">Seleccione una opción</option>');
            $('#conduccionDelito_ordenamiento_JUR').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.ordenamientosJur, function (key, value) {
              if (value.id==1) {
                $("#conduccionDelito_ordenamiento_JUR").append('<option value="' + value.id + '">' + value.Valor + '</option>');
              }
            });
            $('#conduccionDelito_calificacion_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.calDelito, function (key, value) {
                $("#conduccionDelito_calificacion_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });            
            $.each(result.entidades, function (key, value) {
                $("#conduccionDelito_entidad_hechos_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            })
            $('#conduccionDelito_municipio_hechos').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.municipios, function (key, value) {
                $("#conduccionDelito_municipio_hechos").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionDelito_delito').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.delitos, function (key, value) {
                $("#conduccionDelito_delito").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#conduccionDelito_consumacion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.consumacion, function (key, value) {
                $("#conduccionDelito_consumacion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });            
            $('#conduccionDelito_modalidad').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.modalidad, function (key, value) {
                $("#conduccionDelito_modalidad").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            }); 
            $('#conduccionDelito_instrumento_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.instrumento, function (key, value) {
                $("#conduccionDelito_instrumento_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            }); 
            $('#conduccionDelito_fuero_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.fuero, function (key, value) {
                $("#conduccionDelito_fuero_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            }); 
			
            $('#conduccionDelito_tipo_sitio_ocurrencia_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipo_sitio_ocurrencia, function (key, value) {
                $("#conduccionDelito_tipo_sitio_ocurrencia_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            }); 
            $('#conduccionDelito_comision_conduccion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.comision, function (key, value) {
                $("#conduccionDelito_comision_conduccion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            }); 
            $('#conduccionDelito_recibida_por').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.recibida_por, function (key, value) {
                $("#conduccionDelito_recibida_por").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            }); 
            $('#conduccionDelito_tipo_recepcion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipo_recepcion, function (key, value) {
                $("#conduccionDelito_tipo_recepcion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $("#conduccionDelito_ordenamiento_JUR").val(1).change();            
            if(result.datos){
              $("#conduccionDelito_ordenamiento_JUR").val(result.datos.idOrdenamientoJUR??-1).change();
              $("#conduccionDelito_delito_JUR").val(result.datos.DELITO_JUR??-1).change();                
              $("#conduccionDelito_delito").val(result.datos.DELITO??-1);
              $("#conduccionDelito_consumacion").val(result.datos.CONSUMACION??-1);
              $("#conduccionDelito_modalidad").val(result.datos.MODALIDAD??-1);
              $("#conduccionDelito_instrumento_conduccion").val(result.datos.INSTRUMENTO_CONDUCCION??-1);
              $("#conduccionDelito_fuero_conduccion").val(result.datos.FUERO_CONDUCCION??-1);
              $("#conduccionDelito_tipo_sitio_ocurrencia_conduccion").val(result.datos.TIPO_SITIO_OCURRENCIA_CONDUCCION??-1);
              $("#conduccionDelito_calificacion_conduccion").val(result.datos.CALIFICACION_CONDUCCION??-1);
              $("#conduccionDelito_comision_conduccion").val(result.datos.COMISION_CONDUCCION??-1);                        
            }  
            $('#addDelito').click();  
          },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });
	}
</script>