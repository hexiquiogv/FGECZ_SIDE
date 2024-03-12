<div class="mb-3">
    <label for="imputado" class="form-label">Imputado:</label>
    <select class="form-select" aria-label="Imputado" id="imputadoRelB" name="imputadoRelB">
    <option value="-1">Seleccione una opción</option>
        @foreach ($listados['imputados'] as $imputado)      
          <option value="{{ $imputado->id }}">
              {{strtoupper($imputado->NOMBRE_IMPUTADO.' '.$imputado->PRIMER_APELLIDO.' '.$imputado->SEGUNDO_APELLIDO_IMPUTADOS)}}
          </option>
        @endforeach     
    </select>
</div>
<div class="mb-3">
    <label for="victima" class="form-label">Víctima:</label>
    <select class="form-select" aria-label="Víctima" id="victimaRelB" name="victimaRelB">
    <option value="-1">Seleccione una opción</option>
        @foreach ($listados['victimas'] as $victima)      
          <option value="{{ $victima->id }}">
              {{strtoupper($victima->NOMBRE_VICTIMA.' '.$victima->PRIMER_APELLIDO.' '.$victima->SEGUNDO_APELLIDO_VICTIMAS)}}
          </option>
        @endforeach 
    </select>
</div>
<div class="mb-3">
    <label for="delito" class="form-label">Delito:</label>
    <select class="form-select" aria-label="Delito" id="delitoRelB" name="delitoRelB">
    <option value="-1">Seleccione una opción</option>
        @foreach ($listados['hechos'] as $delito)      
          <option value="{{ $delito->id }}">
             {{strtoupper($delito->Valor)}}
          </option>
        @endforeach 
    </select>
</div>

<div class="mb-3">
<button type="button" onclick="javascript:buscarRelacion()" class="btn btn-primary btn-sm">Buscar</button>
</div>
<script type="text/javascript">
function buscarRelacion()
{
  if ($("#imputadoRelB").val()<0 && $("#victimaRelB").val()<0 && $("#delitoRelB").val()<0) {}
  else
  {
    var params = new Object();
    params._token = '{{csrf_token()}}';
    params.imputadoRelB = $("#imputadoRelB").val();
    params.victimaRelB = $("#victimaRelB").val();
    params.delitoRelB = $("#delitoRelB").val();
    params.idExp = $("#idExp").val();
    params = JSON.stringify(params);
    $.ajax({      
      url: "{{Route('buscarR')}}",
      type: "POST",
      data: params,
      contentType: "application/json; charset=utf-8",
      dataType: 'json',
      async: false,
      success: function (result) {
        $("#relDelImpVic tbody").html('');
        $.each(result, function(k, v) {            
          var newrow='<tr><th scope="row">'+v.id+'</th>'+
            '<td>'+v.delito+'</td><td>'+v.imputados+'</td><td>'+v.victimas+'</td><td>'+
            '<a class="btn btn-outline-danger btn-sm" href="#" role="button">Eliminar</a></td></tr>';
           $("#relDelImpVic tbody").append(newrow); 
        });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert(textStatus + ": " + XMLHttpRequest.responseText);
        }
    });
  }
}
</script>