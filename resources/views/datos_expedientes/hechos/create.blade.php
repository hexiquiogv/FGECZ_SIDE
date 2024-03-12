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
        @include("datos_expedientes.hechos.form")
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
        $("#Delitos_ordenamiento_JUR").html(""); $("#Delitos_delito_JUR").html("");
        $("#Delitos_delito_especifico").html(""); $("#Delitos_delito_general").html("");
		$("#Delitos_ordenamiento").html("");    $("#Delitos_H_contexto").html("");    
		$("#Delitos_consumacion").html("");    $("#Delitos_modalidad").html("");
		$("#Delitos_H_forma_accion").html("");    $("#Delitos_instrumento").html("");
		$("#Delitos_fuero").html("");    $("#Delitos_tipo_sitio_ocurrencia").html("");
		$("#Delitos_comision").html(""); $('#Delitos_calificacion').html("");
        $("#Delitos_delito_JUR_Display").hide();

		var params = new Object();    
        params._token = '{{csrf_token()}}';
        params.idDelito = idDelito;
        params.carpeta = 'e3';
		params = JSON.stringify(params);
		$.ajax({      
        url: "{{Route('addDelitos')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {
            $('#Delitos_delito_JUR').html('<option value="-1">Seleccione una opción</option>');
            $('#Delitos_ordenamiento_JUR').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.ordenamientosJur, function (key, value) {
                $("#Delitos_ordenamiento_JUR").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#Delitos_calificacion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.calDelito, function (key, value) {
                $("#Delitos_calificacion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#Delitos_ordenamiento').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.ordenamientos, function (key, value) {
                $("#Delitos_ordenamiento").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#Delitos_H_contexto').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.contexto, function (key, value) {
                $("#Delitos_H_contexto").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#Delitos_consumacion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.consumacion, function (key, value) {
                $("#Delitos_consumacion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });            
            $('#Delitos_modalidad').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.modalidad, function (key, value) {
                $("#Delitos_modalidad").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            }); 
            $('#Delitos_H_forma_accion').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.formaAccion, function (key, value) {
                $("#Delitos_H_forma_accion").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            }); 
            $('#Delitos_instrumento').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.instrumento, function (key, value) {
                $("#Delitos_instrumento").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            }); 
            $('#Delitos_fuero').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.fuero, function (key, value) {
                $("#Delitos_fuero").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            }); 
            $('#Delitos_tipo_sitio_ocurrencia').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.tipo_sitio_ocurrencia, function (key, value) {
                $("#Delitos_tipo_sitio_ocurrencia").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            }); 
            $('#Delitos_comision').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.comision, function (key, value) {
                $("#Delitos_comision").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            }); 
            if(result.datos){
                $("#Delitos_ordenamiento").val(result.datos.idOrdenamiento??-1).change();
                $("#Delitos_delito_general").val(result.datos.idDelitoGeneral??-1).change();
                $("#Delitos_delito_especifico").val(result.datos.DELITO??-1);
                $("#Delitos_H_contexto").val(result.datos.CONTEXTO??-1);
                $("#Delitos_ordenamiento_JUR").val(result.datos.idOrdenamientoJUR??-1).change();
                $("#Delitos_delito_JUR").val(result.datos.DELITO_JUR??-1).change();
                $("#Delitos_consumacion").val(result.datos.CONSUMACION??-1);
                $("#Delitos_modalidad").val(result.datos.MODALIDAD??-1);
                $("#Delitos_instrumento").val(result.datos.INSTRUMENTO??-1);
                $("#Delitos_fuero").val(result.datos.FUERO??-1);
                $("#Delitos_tipo_sitio_ocurrencia").val(result.datos.TIPO_SITIO_OCURRENCIA??-1);
                $("#Delitos_calificacion").val(result.datos.CALIFICACION??-1);
                $("#Delitos_comision").val(result.datos.COMISION??-1);
                $("#Delitos_H_forma_accion").val(result.datos.FORMA_ACCION??-1);
            }            
            $('#addDelito').click();             
          },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });
	}
</script>