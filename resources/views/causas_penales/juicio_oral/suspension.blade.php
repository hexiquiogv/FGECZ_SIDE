<div class="accordion" id="accordionFiltrosSuspension_{{$imputado->id}}">
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsFiltrosSuspension_{{$imputado->id}}">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsStayOpen-collapseOneSuspension_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneSuspension_{{$imputado->id}}">
        Listado de Causas de Suspensión
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOneSuspension_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosSuspension_{{$imputado->id}}">
      <div class="accordion-body row">
	      <div class="mb-3 col-sm-12 input-group">
            <label for="causa_H_suspension_juicio" class="input-group-text">Suspensión del juicio:</label>
            <select class="form-select imp{{$imputado->id}}" name="causa_H_suspension_juicio" id="causa_H_suspension_juicio">
              <option value="-1">Seleccione una opción</option>
              @foreach ($SiNoNoI as $item)      
                <option value="{{ $item->id }}">{{$item->Valor}}</option>      
              @endforeach
           </select>	      	
            <label for="causa_H_causas_suspension" class="input-group-text">Causas suspensión de juicio:</label>
            <input type="text" class="form-control imp{{$imputado->id}} nonum" name="causa_H_causas_suspension" 
            	id="causa_H_causas_suspension" placeholder="">
	        <button type="button" class="btn btn-primary"onclick="javascript:addCausaS({{$imputado->id}})">
	          Agregar causas de suspensión
	        </button>
	      </div> 
	      <input type="hidden" name="hdnSuspension{{$imputado->id}}" id="hdnSuspension{{$imputado->id}}">
	      <table id="Suspension{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
	          <caption></caption>    
	          <thead class="table-light">
	          <tr>
	            <th scope="col">Suspensión del Juicio</th>
	            <th scope="col">Causa de suspensión</th>
	            <th scope="col">Eliminar</th>
	          </tr>
	        </thead>
	        <tbody> 

	         @foreach ($suspension[$imputado->id] as $causa)						
						<tr class="tr{{$imputado->id}}_{{$causa->id}}">
							<td>{{$causa->SUSPENSION}}</td>
							<td>{{$causa->CAUSAS_SUSPENSION}}</td>
							<td>
								<button type="button" title="Eliminar causa" class="btn btn-danger" 
								onclick="eliminarCausaS('{{$imputado->id}}','{{$causa->id}}',1)">×</button>
							</td>
						</tr>
					 @endforeach
	        </tbody>
	      </table>    
      </div>
    </div>
  </div>
</div>