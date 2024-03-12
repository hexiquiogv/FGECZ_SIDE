<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_audiencia_de_garantias" class="form-label">Audiencia de garantías:</label>
  <input type="text" class="form-control nonum" name="causa_H_audiencia_de_garantias" id="causa_H_audiencia_de_garantias" maxlength="70" placeholder=""
  value="{{$imputado->AUDIENCIA_DE_GARANTIAS??''}}">
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_promovida_por" class="form-label">Audiencia promovida por:</label>
    <select class="form-select" name="causa_H_promovida_por" id="causa_H_promovida_por">
      <option value="-1">Seleccione una opción</option>
      @foreach ($audineciaPx as $item)      
        <option value="{{ $item->id }}" {{isset($imputado->PROMOVIDA_POR) ? $imputado->PROMOVIDA_POR==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach 
   </select>
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_resultado_audiencia_de_garantias" class="form-label">Resultado de la audiencia:</label>
  <input type="text" class="form-control nonum" name="causa_H_resultado_audiencia_de_garantias" id="causa_H_resultado_audiencia_de_garantias" placeholder=""
  value="{{$imputado->RESULTADO_AUDIENCIA_DE_GARANTIAS??''}}">
</div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_fecha_cita" class="form-label">Fecha para la cita para imputación:</label>
    <input type="date" class="form-control" name="causa_H_fecha_cita" id="causa_H_fecha_cita" value="{{$imputado->FECHA_CITA??''}}">
  </div>

<script type="text/javascript">

</script>