<div class="accordion" id="accordionFiltrosMedidas_{{$imputado->id}}">
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsFiltrosMedidas_{{$imputado->id}}">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsStayOpen-collapseOneMedidas_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneMedidas_{{$imputado->id}}">
        Listado de medidas cautelares
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOneMedidas_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosMedidas_{{$imputado->id}}">
      <div class="accordion-body row">
        <div class="mb-3 col-sm-12 input-group">
          <label for="causa_H_medidas_cautelares" class="input-group-text">Medidas:</label>
          <select class="form-select imp{{$imputado->id}}" name="causa_H_medidas_cautelares" id="causa_H_medidas_cautelares">
            <option value="-1">Seleccione una opción</option>
            @foreach ($SiNoNoI as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>
            @endforeach
          </select> 
          <label for="causa_H_tipo_medidas_cautelares" class="input-group-text">Tipo:</label>
          <select class="form-select imp{{$imputado->id}}" name="causa_H_tipo_medidas_cautelares" id="causa_H_tipo_medidas_cautelares">
            <option value="-1">Seleccione una opción</option>
            @foreach ($TMCautelares as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
            @endforeach        
          </select>         
          <label for="causa_H_temporalidad_medida" class="input-group-text">Temporalidad:</label>
          <select class="form-select imp{{$imputado->id}}" name="causa_H_temporalidad_medida" id="causa_H_temporalidad_medida">
            <option value="-1">Seleccione una opción</option>
            @for ($i=1;$i<4;$i++)      
              <option value="{{ $i }}">{{$i>1? $i.' MESES':$i.' MES'}}</option>      
            @endfor
          </select>
          <button type="button" class="btn btn-primary"onclick="javascript:addMedida({{$imputado->id}})">
            Agregar medida
          </button>
        </div> 
        <input type="hidden" name="hdnMedidas{{$imputado->id}}" id="hdnMedidas{{$imputado->id}}">
        <table id="medidas{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
            <caption></caption>    
            <thead class="table-light">
            <tr>
              <th scope="col">Medidas cautelares</th>
              <th scope="col">Tipo de medida cautelar impuesta</th>
              <th scope="col">Temporalidad de la medida</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody> 

           @foreach ($medidas[$imputado->id] as $medida)
            <tr class="tr{{$imputado->id}}_{{$medida->id}}">
              <td>{{$medida->MEDIDAS}}</td>
              <td>{{$medida->TIPOMEDIDA}}</td>
              <td>{{$medida->TEMPORALIDAD_MEDIDA > 1 ? $medida->TEMPORALIDAD_MEDIDA.' MESES':$medida->TEMPORALIDAD_MEDIDA.' MES'}}</td>
              <td>
                <button type="button" title="Eliminar medida" class="btn btn-danger" 
                onclick="eliminarMedida('{{$imputado->id}}','{{$medida->id}}',1)">×</button>
              </td>
            </tr>
           @endforeach
          </tbody>
        </table>    
      </div>
    </div>
  </div>
</div>

<!-- <div class="row medidas">
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_medidas_cautelares" class="form-label">Medidas cautelares:</label>
      <select class="form-select" name="causa_H_medidas_cautelares" id="causa_H_medidas_cautelares">
        <option value="-1">Seleccione una opción</option>
        @foreach ($SiNoNoI as $item)      
          <option value="{{ $item->id }}"
            {{isset($imputado->MEDIDAS_CAUTELARES)?$imputado->MEDIDAS_CAUTELARES==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_tipo_medidas_cautelares" class="form-label">
      Tipo de medidas cautelares impuestas:</label>
      <select class="form-select" name="causa_H_tipo_medidas_cautelares" id="causa_H_tipo_medidas_cautelares">
        <option value="-1">Seleccione una opción</option>
        @foreach ($TMCautelares as $item)      
          <option value="{{ $item->id }}"
            {{isset($imputado->TIPO_MEDIDAS_CAUTELARES)?$imputado->TIPO_MEDIDAS_CAUTELARES==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach        
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_temporalidad_medida" class="form-label">Temporalidad de la medida:</label>
      <select class="form-select" name="causa_H_temporalidad_medida" id="causa_H_temporalidad_medida">
        <option value="-1">Seleccione una opción</option>
        @for ($i=1;$i<4;$i++)      
          <option value="{{ $i }}" {{isset($imputado->TEMPORALIDAD_MEDIDA) ?
           $imputado->TEMPORALIDAD_MEDIDA==$i ?'selected':'':''}}>{{$i>1? $i.' meses':$i.' mes'}}</option>      
        @endfor
      </select>     -->
    <!-- <input type="text" class="form-control temporalidad" name="causa_H_temporalidad_medida" id="causa_H_temporalidad_medida" value="{{$imputado->TEMPORALIDAD_MEDIDA}}"> -->
 <!--  </div>
</div> -->