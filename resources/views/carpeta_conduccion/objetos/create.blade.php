<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" id="addObjeto" data-bs-target="#createObjetoForm">
  Agregar objeto
</button>
<button type="button" class="btn btn-primary" id="addObjetoT" onclick="javascript:fnObjeto('0')">
  Agregar objeto
</button>
<!-- Modal -->

<div class="modal fade" id="createObjetoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createObjetoFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen"><!--modal-dialog-scrollable modal-lg-->
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createObjetoFormLabel">Agregar objeto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @include("carpeta_conduccion.objetos.form")
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:saveObjeto()">Guardar</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  function saveObjeto(){
    var respuesta=true;
    var campos=[];
      $("#frmDE_O input:not(.noValidate):visible").each(function(){
        if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}
      });      
      
      $("#frmDE_O select:not(.noValidate):visible").each(function(){
        if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        else{$(this).removeClass("border-3 border-danger");}        
      });
    var extra="";
    var contador = 0;
    $('.noVacios').each(function() {
        var valorSeleccionado = $(this).val();
        if (parseFloat(valorSeleccionado) < 0) {
            contador++;
        }
    });

    if ($(".noVacios").length==contador) {
        respuesta=false;
        extra="Debes elegir al menos un objeto, un narcótico o el estatus del vehículo."
    }      
    if (respuesta) {$("#frmDE_O").submit();}
    else
    { var msj=extra==""?'Algunos campos no tienen valores válidos':extra;
        showtoast('<h6>&times; Validación</h6><hr>'+msj,'danger');
    }
  }
    function fnObjeto(idObjeto){ 
        $("#idObjeto").val(idObjeto);
		$("#objeto_objeto_1").html(""); $("#objeto_objeto_2").html(""); $("#objeto_objeto_3").html("");
    $("#objeto_estatus_obj_1").html("");    $("#objeto_estatus_obj_2").html("");    $("#objeto_estatus_obj_3").html("");    
    $("#objeto_tipo_narcotico_1").html("");    $("#objeto_tipo_narcotico_2").html("");    $("#objeto_tipo_narcotico_3").html("");  
    $("#objeto_estatus").html(""); 

    $(".objetos input").val("");

        var params = new Object();    
        params._token = '{{csrf_token()}}';
        params.idObjeto = idObjeto;
        params.carpeta = 'd9';
		params = JSON.stringify(params);
		$.ajax({      
        url: "{{Route('addObjetos')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {
            $('#conduccionObjeto_objeto_1').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.objetos, function (key, value) {
                $("#conduccionObjeto_objeto_1").append('<option value="' + value.id + '">' + value.Valor + '</option>');
            });
            $('#conduccionObjeto_objeto_2').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.objetos, function (key, value) {
                $("#conduccionObjeto_objeto_2").append('<option value="' + value.id + '">' + value.Valor + '</option>');
            });
            $('#conduccionObjeto_objeto_3').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.objetos, function (key, value) {
                $("#conduccionObjeto_objeto_3").append('<option value="' + value.id + '">' + value.Valor + '</option>');
            });
            $('#objeto_estatus_obj_1').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.estatus, function (key, value) {
                $("#objeto_estatus_obj_1").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#objeto_estatus_obj_2').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.estatus, function (key, value) {
                $("#objeto_estatus_obj_2").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#objeto_estatus_obj_3').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.estatus, function (key, value) {
                $("#objeto_estatus_obj_3").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });         

           $('#objeto_tipo_narcotico_1').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.narcoticos, function (key, value) {
                $("#objeto_tipo_narcotico_1").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#objeto_tipo_narcotico_2').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.narcoticos, function (key, value) {
                $("#objeto_tipo_narcotico_2").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#objeto_tipo_narcotico_3').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.narcoticos, function (key, value) {
                $("#objeto_tipo_narcotico_3").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });  
            $('#objeto_estatus').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.estatusV, function (key, value) {
                $("#objeto_estatus").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });

            if (result.datos) {
              $("#conduccionObjeto_objeto_1").val(result.datos.OBJETO_1??-1);
              $("#conduccionObjeto_desc_obj_1").val(result.datos.DESC_OBJ_1);
              $("#conduccionObjeto_cant_obj_1").val(result.datos.CANT_OBJ_1);
              $("#conduccionObjeto_valor_obj_1").val(result.datos.VALOR_OBJ_1);
              $("#objeto_estatus_obj_1").val(result.datos.ESTATUS_OBJ_1??-1);

              $("#conduccionObjeto_objeto_2").val(result.datos.OBJETO_2??-1);
              $("#conduccionObjeto_desc_obj_2").val(result.datos.DESC_OBJ_2);
              $("#conduccionObjeto_cant_obj_2").val(result.datos.CANT_OBJ_2);
              $("#conduccionObjeto_valor_obj_2").val(result.datos.VALOR_OBJ_2);
              $("#objeto_estatus_obj_2").val(result.datos.ESTATUS_OBJ_2??-1);

              $("#conduccionObjeto_objeto_3").val(result.datos.OBJETO_3??-1);
              $("#conduccionObjeto_desc_obj_3").val(result.datos.DESC_OBJ_3);
              $("#conduccionObjeto_cant_obj_3").val(result.datos.CANT_OBJ_3);
              $("#conduccionObjeto_valor_obj_3").val(result.datos.VALOR_OBJ_3); 
              $("#objeto_estatus_obj_3").val(result.datos.ESTATUS_OBJ_3??-1);

              $("#objeto_tipo_narcotico_1").val(result.datos.TIPO_NARCOTICO_1??-1);
              $("#objeto_presentacion_narco_1").val(result.datos.PRESENTACION_NARCO_1);
              $("#objeto_cantidad_narco_1").val(result.datos.CANTIDAD_NARCO_1);
              $("#objeto_gramaje_narco_1").val(result.datos.GRAMAJE_NARCO_1);
              $("#objeto_tipo_narcotico_2").val(result.datos.TIPO_NARCOTICO_2??-1);
              $("#objeto_presentacion_narco_2").val(result.datos.PRESENTACION_NARCO_2);
              $("#objeto_cantidad_narco_2").val(result.datos.CANTIDAD_NARCO_2);
              $("#objeto_gramaje_narco_2").val(result.datos.GRAMAJE_NARCO_2);
              $("#objeto_tipo_narcotico_3").val(result.datos.TIPO_NARCOTICO_3??-1);
              $("#objeto_presentacion_narco_3").val(result.datos.PRESENTACION_NARCO_3);
              $("#objeto_cantidad_narco_3").val(result.datos.CANTIDAD_NARCO_3);
              $("#objeto_gramaje_narco_3").val(result.datos.GRAMAJE_NARCO_3);
              $("#objeto_estatus").val(result.datos.ESTATUS??-1).change();
            $("#objeto_fecha_asegurado").val(result.datos.FECHA_ASEGURADO);
            $("#objeto_fecha_devuelto").val(result.datos.FECHA_DEVUELTO);
            $("#objeto_fecha_robado").val(result.datos.FECHA_ROBADO);              
              $("#objeto_marca").val(result.datos.MARCA);
              $("#objeto_modelo").val(result.datos.MODELO);
              $("#objeto_color").val(result.datos.COLOR);
              $("#objeto_tipo").val(result.datos.TIPO);
              $("#objeto_placa").val(result.datos.PLACA);
              $("#objeto_numero").val(result.datos.NUMERO);
              $("#objeto_estado_placas").val(result.datos.ESTADO_PLACAS);
              $("#objeto_lugar_vehiculo").val(result.datos.LUGAR_VEHICULO);
                         
            }
            $("#addObjeto").click();
          },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.RESPONSETEXT);
          }
      });
    }
</script>


