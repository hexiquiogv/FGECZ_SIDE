  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Sobreseimiento</h4>
    </div>
  </div> 
  <div class="row sobreseimiento">
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_fecha_sobreseimiento" class="form-label">Fecha sobreseimiento:</label>
      <input type="date" class="form-control" name="causa_H_fecha_sobreseimiento" id="causa_H_fecha_sobreseimiento" value="">
    </div> 
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_causas_sobreseimiento" class="form-label">Causas de sobreseimiento</label>
        <select class="form-select" name="causa_H_causas_sobreseimiento" id="causa_H_causas_sobreseimiento">
          <option value="-1">Seleccione una opción</option>
          @foreach ($causasSobre as $item)      
            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
          @endforeach
       </select>
    </div> 
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_tipo_sobreseimiento" class="form-label">Tipo de sobreseimiento</label>
      <select class="form-select" name="causa_H_tipo_sobreseimiento" id="causa_H_tipo_sobreseimiento">
        <option value="-1">Seleccione una opción</option>
        @foreach ($tipoSobre as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach      
     </select>
    </div>    
  </div>
  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Salidas alternas</h4>
    </div>
  </div>
  <div class="row salidas">
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_acuerdo_reparatorio" class="form-label">Acuerdo reparatorio:</label>
        <select class="form-select" name="causa_H_acuerdo_reparatorio" id="causa_H_acuerdo_reparatorio">
          <option value="-1">Seleccione una opción</option>
          @foreach ($acuerdo as $item)      
            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
          @endforeach
       </select>
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4 fechaCump" style="display:none;">
      <label for="causa_H_fecha_cumplimiento" class="form-label">Fecha de cumplimiento:</label>
      <input type="date" class="form-control" name="causa_H_fecha_cumplimiento" id="causa_H_fecha_cumplimiento">
    </div>      
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_fecha_acuerdos_reparatorios" class="form-label">Fecha de acuerdo reparatorio:</label>
      <input type="date" class="form-control" name="causa_H_fecha_acuerdos_reparatorios" id="causa_H_fecha_acuerdos_reparatorios" 
      value="">
    </div>  
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_acuerdos_reparatorios" class="form-label">Tipo de acuerdos reparatorios:</label>
      <select class="form-select" name="causa_H_acuerdos_reparatorios" id="causa_H_acuerdos_reparatorios">
        <option value="-1">Seleccione una opción</option>
        @foreach ($tipoAcuerdo as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach      
      </select>
    </div>              
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_monto_rep_daño" class="form-label">Monto de la reparación del daño:</label>
      <input type="text" class="form-control monto" name="causa_H_monto_rep_daño" id="causa_H_monto_rep_daño" value="">
    </div> 
<!--     <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_condicion_impuesta" class="form-label">Condición impuesta:</label>
      <input type="text" class="form-control alfanum" name="causa_H_condicion_impuesta" id="causa_H_condicion_impuesta" value="">
    </div> -->
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_temporalidad" class="form-label">Temporalidad de la condición impuesta:</label>
      <input type="text" class="form-control temporalidadMA" name="causa_H_temporalidad" id="causa_H_temporalidad" 
       placeholder="xx años, xx meses">
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_reparacion_del_daño_" class="form-label">Tipo de reparación del daño:</label>
      <input type="text" class="form-control alfanum" name="causa_H_reparacion_del_daño_" id="causa_H_reparacion_del_daño_" value="">
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_temporalidad_salidad_alternas" class="form-label">Temporalidad de salidas alternas:</label>
      <input type="text" class="form-control temporalidad" name="causa_H_temporalidad_salidad_alternas" id="causa_H_temporalidad_salidad_alternas" 
      value="" placeholder="xxx días">
    </div>
  </div>
<script type="text/javascript">
  $("#frmCausasPenalesEI_0 #causa_H_acuerdo_reparatorio").change(function() {
    if (this.value==2) {$("#frmCausasPenalesEI_0 .fechaCump").show();}
    else
    {
      $("#frmCausasPenalesEI_0 .fechaCump").hide();
      $("#frmCausasPenalesEI_0 .fechaCump #causa_H_fecha_cumplimiento").val('');
    }
  });  
</script>  