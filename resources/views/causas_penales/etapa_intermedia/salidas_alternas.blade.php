<div class="row salidas">
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_acuerdo_reparatorio" class="form-label">Acuerdo reparatorio:</label>
      <select class="form-select" name="causa_H_acuerdo_reparatorio" id="causa_H_acuerdo_reparatorio">
        <option value="-1">Seleccione una opción</option>
        @foreach ($acuerdo as $item)      
          <option value="{{ $item->id }}"
            {{isset($imputado->ACUERDO_REPARATORIO)?$imputado->ACUERDO_REPARATORIO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fechaCump">
    <label for="causa_H_fecha_cumplimiento" class="form-label">Fecha de cumplimiento:</label>
    <input type="date" class="form-control" name="causa_H_fecha_cumplimiento" id="causa_H_fecha_cumplimiento" 
    value="{{$imputado->FECHA_CUMPLIMIENTO}}">
  </div>    
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_fecha_acuerdos_reparatorios" class="form-label">Fecha de acuerdo reparatorio:</label>
    <input type="date" class="form-control" name="causa_H_fecha_acuerdos_reparatorios" id="causa_H_fecha_acuerdos_reparatorios" 
    value="{{$imputado->FECHA_ACUERDOS_REPARATORIOS}}">
  </div>  
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_acuerdos_reparatorios" class="form-label">Tipo de acuerdos reparatorios:</label>
    <select class="form-select" name="causa_H_acuerdos_reparatorios" id="causa_H_acuerdos_reparatorios">
      <option value="-1">Seleccione una opción</option>
      @foreach ($tipoAcuerdo as $item)      
        <option value="{{ $item->id }}"
          {{isset($imputado->ACUERDOS_REPARATORIOS)?$imputado->ACUERDOS_REPARATORIOS==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach      
    </select>
  </div>              
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_monto_rep_daño" class="form-label">Monto de la reparación del daño:</label>
    <input type="text" class="form-control monto" name="causa_H_monto_rep_daño" id="causa_H_monto_rep_daño" value="{{$imputado->MONTO_REP_DAÑO}}">
  </div> 
<!--   <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_condicion_impuesta" class="form-label">Condición impuesta:</label>
    <input type="text" class="form-control alfanum" name="causa_H_condicion_impuesta" id="causa_H_condicion_impuesta" value="{{$imputado->CONDICION_IMPUESTA}}">
  </div> -->
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_temporalidad" class="form-label">Temporalidad de la condición impuesta:</label>
    <input type="text" class="form-control temporalidadMA" name="causa_H_temporalidad" id="causa_H_temporalidad" value="{{$imputado->TEMPORALIDAD}}" placeholder="xx años, xx meses">
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_reparacion_del_daño_" class="form-label">Tipo de reparación del daño:</label>
    <input type="text" class="form-control alfanum" name="causa_H_reparacion_del_daño_" id="causa_H_reparacion_del_daño_" value="{{$imputado->REPARACION_DEL_DAÑO}}">
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_temporalidad_salidad_alternas" class="form-label">Temporalidad de salidas alternas:</label>
    <input type="text" class="form-control temporalidad" name="causa_H_temporalidad_salidad_alternas" id="causa_H_temporalidad_salidad_alternas" 
    value="{{$imputado->TEMPORALIDAD_SALIDAD_ALTERNAS}}" placeholder="xxx días">
  </div>
</div>
<script type="text/javascript">
  $("#frmCausasPenalesEI_{{$imputado->id}} #causa_H_acuerdo_reparatorio").change(function() {
    if (this.value==2) {$("#frmCausasPenalesEI_{{$imputado->id}} .fechaCump").show();}
    else
    {
      $("#frmCausasPenalesEI_{{$imputado->id}} .fechaCump").hide();
      $("#frmCausasPenalesEI_{{$imputado->id}} .fechaCump #causa_H_fecha_cumplimiento").val('');
    }
  });
  if ($("#frmCausasPenalesEI_{{$imputado->id}} #causa_H_acuerdo_reparatorio").val()==2) 
    {$("#frmCausasPenalesEI_{{$imputado->id}} .fechaCump").show();}
    else
    {
      $("#frmCausasPenalesEI_{{$imputado->id}} .fechaCump").hide();
      $("#frmCausasPenalesEI_{{$imputado->id}} .fechaCump #causa_H_fecha_cumplimiento").val('');
    }
</script>