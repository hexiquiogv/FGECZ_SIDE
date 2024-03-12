<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" id="addDelito" data-bs-target="#createDelitoForm">
  agregar delito
</button>
<!-- Modal -->

<div class="modal fade" id="createDelitoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createDelitoFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createDelitoFormLabel">Agregar delito</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @include("no_delictivos.hechos.form")
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
   $("#addDelito").click(function(){ 
		$("#nodDelito_entidad_hechos_no_delictivos").html(""); $("#nodDelito_municipio_hechos").html("");   
		$("#nodDelito_recibida_por").html(""); $("#nodDelito_hecho_no_delito").html("");

		var params = new Object();    
		params._token = '{{csrf_token()}}';
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
            $.each(result.entidades, function (key, value) {
                $("#nodDelito_entidad_hechos_no_delictivos").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            })
            $('#nodDelito_municipio_hechos').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.municipios, function (key, value) {
                $("#nodDelito_municipio_hechos").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#nodDelito_hecho_no_delito').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.noDelitos, function (key, value) {
                $("#nodDelito_hecho_no_delito").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });
            $('#nodDelito_recibida_por').html('<option value="-1">Seleccione una opción</option>');
            $.each(result.respuestas.recibida_por, function (key, value) {
                $("#nodDelito_recibida_por").append('<option value="' + value
                    .id + '">' + value.Valor + '</option>');
            });              
 
          },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });
	}
  );
</script>