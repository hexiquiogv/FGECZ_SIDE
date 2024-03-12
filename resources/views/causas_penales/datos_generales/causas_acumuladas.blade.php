<div class="accordion" id="accordionFiltrosCausasPenales">
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsFiltrosCausasPenales">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsStayOpen-collapseOneCausasPenales" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneCausasPenales">
        Causas Acumuladas
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOneCausasPenales" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosCausasPenales">
      <div class="accordion-body">
        <div class="mb-3 input-group">
				  <label for="NoCausaPenal" class="input-group-text">No. Causa penal:</label>
				  <input type="text" class="form-control" id="NoCausaPenal">
					<button type="button" class="btn btn-primary btn-sm" onclick="javascript:buscarCP()">Buscar</button>					
				</div>
					<table class="table table-striped table-hover table-responsive caption-top" id="tbCausaAC">
					    <caption>Listado de Causas acumuladas</caption>    
					    <thead class="table-light">
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Causa Penal</th>
					      <th scope="col">Imputados</th>
					      <th scope="col">Delitos</th>
					      <th scope="col">Víctimas</th>
					      <th scope="col">Acciones</th>
					    </tr>
					  </thead>
					  <tbody>   
							@foreach($listados['causasAC'] as $causa)
						    	<tr>
		 					      <th scope="row">{{$causa->id}}</th>
							      <td>{{$causa->CAUSA_PENAL_ID}}</td>
							      <td>{{$causa->imputados}}</td>
							      <td>{{$causa->delitos}}</td>
							      <td>{{$causa->victimas}}</td>							      
							      <td>
								      @if(!$causa->idCausaRel)
								        <a class="btn btn-outline-primary btn-sm" id="btn_{{$causa->id}}" onclick="javascript:acumular('{{$causa->id}}','{{$causa->CAUSA_PENAL_ID}}')" role="button">Acumular</a>
								      @else
								      	<a class="btn btn-outline-light btn-sm" role="button">Acumulado</a>
								      @endif
							    	</td>  
	 					    	</tr>
							@endforeach

						</tbody>
					</table>		
					<div class="alert alert-dark" id="txtacumulado">
						<input type="hidden" id="hdnacumulado" name="hdnacumulado">
						{!!$CAhtml!!}
					</div>			
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	function buscarCP()
	{
		if ($("#NoCausaPenal").val().length >0) {
			var params = new Object();
	    params._token = '{{csrf_token()}}';
	    params.filtro=$("#NoCausaPenal").val();
	    params.idCausa = $("#idCausa").val();
	    params.idExpediente = $("#idExp").val();
	    params = JSON.stringify(params);
       $.ajax({
        url: "{{Route('BuscarCausaPenal')}}",
        type: "POST",
        data: params,
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        async: false,
        success: function (result) {
        	var tbody="";
        	$("#tbCausaAC tbody").html(tbody);
					result.causa.forEach(function(elemento, indice) {
						tbody+='<tr><th scope="row">'+elemento.id+'</th>'+
							      '<td>'+elemento.CAUSA_PENAL_ID+'</td>'+
							      '<td>'+(elemento.imputados??'')+'</td>'+
							      '<td>'+(elemento.delitos??'')+'</td>'+
							      '<td>'+(elemento.victimas??'')+'</td>'+
							      '<td>';
							      if(!elemento.idCausaRel)
							      {
							      tbody+='<a class="btn btn-outline-primary btn-sm" id="btn_'+elemento.id+'" onclick="javascript:acumular(\''+elemento.id+'\',\''+elemento.CAUSA_PENAL_ID+'\')" role="button">Acumular</a>';	
							      }
								    else
								    {tbody+='<a class="btn btn-outline-light btn-sm" role="button">Acumulado</a>';}
										tbody+='</td></tr>';
					});
					$("#tbCausaAC tbody").html(tbody);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus + ": " + XMLHttpRequest.responseText);
          }
      });
		}
	}
function acumular(idCausa,nCausa)
{
//	var badge='<div class="mx-2 badge rounded-pill bg-info  text-dark">'+idCausa+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
	var badge="<span class='mx-1 badge rounded-pill bg-info text-dark' id='span_"+idCausa+"'>"+nCausa+
	"<button type='button' class='btn-close' onclick='eliminar(this)'></button></span>";
	
	var ids = JSON.parse("["+$("#hdnacumulado").val()+"]");
	
	if (!(ids.includes(parseInt(idCausa)))) {

		ids.push(idCausa.toString());
		$("#hdnacumulado").val(ids.toString());
		$("#btn_"+idCausa).addClass('btn-outline-light');
		$("#btn_"+idCausa).removeClass('btn-outline-primary');
		$("#btn_"+idCausa).text('Acumulado');
		$("#txtacumulado").append(badge);
	}
	else
		{
		showtoast('Esa causa ya fue acumulada.','info');
		$("#btn_"+idCausa).addClass('btn-outline-light');
		$("#btn_"+idCausa).removeClass('btn-outline-primary');
		$("#btn_"+idCausa).text('Acumulado');
		}
}
function eliminar(element,DB=0)
{	
	var idCausa=element.parentElement.id.slice(5);
	if (DB>0) {
		eliminarReload(idCausa,'cpdgac');
	}
	else
	{
		var ids = JSON.parse("["+$("#hdnacumulado").val()+"]");
		
		if (ids.includes(parseInt(idCausa))) {				
				var result=ids.filter(function(ele){  return ele != idCausa; });
			$("#hdnacumulado").val(result.toString());
			$("#btn_"+idCausa).addClass('btn-outline-primary');
			$("#btn_"+idCausa).removeClass('btn-outline-light');		
			$("#btn_"+idCausa).text('Acumular');
			element.parentElement.remove();
		}
	}	
}

</script>
