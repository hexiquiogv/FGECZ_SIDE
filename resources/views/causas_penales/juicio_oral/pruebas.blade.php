<div class="accordion" id="accordionFiltrosPruebas_{{$imputado->id}}">
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsFiltrosPruebas_{{$imputado->id}}">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsStayOpen-collapseOnePruebas_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOnePruebas_{{$imputado->id}}">
        Listado de pruebas
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOnePruebas_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosPruebas_{{$imputado->id}}">
      <div class="accordion-body row">
	      <div class="mb-3 col-sm-12 input-group">
	        <label for="causa_H_tipos_de_pruebas" class="input-group-text">Tipos de pruebas desahogadas:</label>
	        <select class="form-select imp{{$imputado->id}}" name="causa_H_tipos_de_pruebas" id="causa_H_tipos_de_pruebas">
	          <option value="-1">Seleccione una opción</option>
	          @foreach ($tipoPruebas as $item)      
	            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
	          @endforeach                 
	       </select>
	        <label for="causa_H_actor_pruebas" class="input-group-text">Actor que las presenta:</label>
	        <input type="text" class="form-control imp{{$imputado->id}} nonum" name="causa_H_actor_pruebas" id="causa_H_actor_pruebas" placeholder="">

	        <button type="button" class="btn btn-primary"onclick="javascript:addPrueba({{$imputado->id}})">
	          Agregar pruebas
	        </button>
	      </div> 
	      <input type="hidden" name="hdnPruebas{{$imputado->id}}" id="hdnPruebas{{$imputado->id}}">
	      <table id="pruebas{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
	          <caption></caption>    
	          <thead class="table-light">
	          <tr>
	            <th scope="col">Tipo de pruebas desahogadas</th>
	            <th scope="col">Actor que las presenta</th>
	            <th scope="col">Eliminar</th>
	          </tr>
	        </thead>
	        <tbody> 

	         @foreach ($pruebas[$imputado->id] as $prueba)						
						<tr class="tr{{$imputado->id}}_{{$prueba->id}}">
							<td>{{$prueba->PRUEBA}}</td>
							<td>{{$prueba->ACTOR_PRUEBAS}}</td>
							<td>
								<button type="button" title="Eliminar prueba" class="btn btn-danger" 
								onclick="eliminarPrueba('{{$imputado->id}}','{{$prueba->id}}',1)">×</button>
							</td>
						</tr>
					 @endforeach
	        </tbody>
	      </table>    
      </div>
    </div>
  </div>
</div>