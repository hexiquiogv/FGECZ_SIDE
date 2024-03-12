<div class="row sobreseimiento">
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_fecha_sobreseimiento" class="form-label">Fecha sobreseimiento:</label>
    <input type="date" class="form-control" name="causa_H_fecha_sobreseimiento" id="causa_H_fecha_sobreseimiento" value="{{$imputado->FECHA_SOBRESEIMIENTO}}">
  </div> 
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_causas_sobreseimiento" class="form-label">Causas de sobreseimiento</label>
      <select class="form-select" name="causa_H_causas_sobreseimiento" id="causa_H_causas_sobreseimiento">
        <option value="-1">Seleccione una opción</option>
        @foreach ($causasSobre as $item)      
          <option value="{{ $item->id }}"
            {{isset($imputado->CAUSAS_SOBRESEIMIENTO)?$imputado->CAUSAS_SOBRESEIMIENTO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach
     </select>
  </div> 
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_tipo_sobreseimiento" class="form-label">Tipo de sobreseimiento</label>
    <select class="form-select" name="causa_H_tipo_sobreseimiento" id="causa_H_tipo_sobreseimiento">
      <option value="-1">Seleccione una opción</option>
      @foreach ($tipoSobre as $item)      
        <option value="{{ $item->id }}"
          {{isset($imputado->TIPO_SOBRESEIMIENTO)?$imputado->TIPO_SOBRESEIMIENTO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach      
   </select>
  </div>    
</div>