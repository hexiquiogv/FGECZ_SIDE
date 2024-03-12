<div class="row suspension">
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_suspension_condicional" class="form-label">Suspensión condicional del proceso:</label>
    <select class="form-select" name="causa_H_suspension_condicional" id="causa_H_suspension_condicional">
      <option value="-1">Seleccione una opción</option>
      @foreach ($SiNoNoI as $item)      
        <option value="{{ $item->id }}"
          {{isset($imputado->SUSPENSION_CONDICIONAL)?$imputado->SUSPENSION_CONDICIONAL==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach
   </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_fecha_suspension" class="form-label">Fecha en que se dictó la suspensión condicional del proceso:</label>
    <input type="date" class="form-control" name="causa_H_fecha_suspension" id="causa_H_fecha_suspension" value="{{$imputado->FECHA_SUSPENSION}}">
  </div> 
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_tipo_suspension" class="form-label">Tipo de condiciones impuestas durante la suspensión condicional del proceso:</label>
    <select class="form-select" name="causa_H_tipo_suspension" id="causa_H_tipo_suspension">
      <option value="-1">Seleccione una opción</option>
      @foreach ($tipoConImp as $item)      
        <option value="{{ $item->id }}"
          {{isset($imputado->TIPO_SUSPENSION)?$imputado->TIPO_SUSPENSION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach      
    </select>
  </div>   
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_fecha_cumpl" class="form-label">Fecha en que se cumplimentó la suspensión condicional del proceso:</label>
    <input type="date" class="form-control" name="causa_H_fecha_cumpl" id="causa_H_fecha_cumpl" value="{{$imputado->FECHA_CUMPL}}">
  </div>              
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 d-none">
    <label for="causa_H_suspension_del_proceso" class="form-label">Suspensión del proceso:</label>
    <input type="text" class="form-control nonum" name="causa_H_suspension_del_proceso" id="causa_H_suspension_del_proceso" value="{{$imputado->SUSPENSION_DEL_PROCESO}}">
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_causa_proceso" class="form-label">Causa de la suspensión:</label>
      <select class="form-select" name="causa_H_causa_proceso" id="causa_H_causa_proceso">
        <option value="-1">Seleccione una opción</option>
        @foreach ($causasSus as $item)      
          <option value="{{ $item->id }}"
            {{isset($imputado->CAUSA_PROCESO)?$imputado->CAUSA_PROCESO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach        
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_fecha_de_reanudacion" class="form-label">Fecha de reanudación de audiencia:</label>
    <input type="date" class="form-control" name="causa_H_fecha_de_reanudacion" id="causa_H_fecha_de_reanudacion" value="{{$imputado->FECHA_DE_REANUDACION}}">
  </div> 
</div>