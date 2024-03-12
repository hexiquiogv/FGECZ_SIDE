<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" id="addRelacion" data-bs-target="#relDelitoForm">
  Relacionar delito
</button>
<button type="button" class="btn btn-primary" id="addfnRelacionT" onclick="javascript:fnRelacion('0')">
  Relacionar delito
</button>
<!-- Modal -->
<div class="modal fade" id="relDelitoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createDelitoFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createDelitoFormLabel">Relacionar delito con imputado y víctima</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @include("datos_expedientes.relacion.form")
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:saveRelacion()">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function validSaveRelacion()
  {
    var respuesta=true;
      $("#frmDE_R input").each(function(){
        if (this.value.length<1){respuesta=false;$(this).addClass("border-3 border-danger");}
        else{$(this).removeClass("border-3 border-danger");}
      });
      
      $("#frmDE_R div .alert-dark").each(function(){
        if($(this).html().trim(" ").length<1){respuesta=false;$(this).addClass("border-3 border-danger");}
          else{$(this).removeClass("border-3 border-danger");}
      });
      
      $("#frmDE_R select:not(.noValidate)").each(function(){
        if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");}
        else{$(this).removeClass("border-3 border-danger");}        
      });
    return respuesta;
  }
  function saveRelacion(){
    if (!validSaveRelacion()) {
      showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
    }
    else
    {
    $("#frmDE_R").submit();
    }
  }
  function fnRelacion(idRelacion){ 
    $("#idRelacion").val(idRelacion);
    $("#ddlI").html("");$("#ddlV").html("");$("#relDelito").html("");

        var params = new Object();    
    params._token = '{{csrf_token()}}';
    params.idExp = '{{$idExp}}';
    params = JSON.stringify(params);
    $.ajax({      
        url: "{{Route('addRelacion')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {
            $('#ddlI').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.imputados, function (key, value) {
                $("#ddlI").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
             $('#ddlV').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.victimas, function (key, value) {
                $("#ddlV").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#relDelito').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.delitos, function (key, value) {
                $("#relDelito").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });            
          $("#addRelacion").click();
          },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });

    
  }
</script>