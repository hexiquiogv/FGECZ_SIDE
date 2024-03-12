
<div class="mb-3 col-12">
  <div class="row imputacion">
    <div class="mb-4 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Control de detención</h4>
      </div>
    </div>    
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_forma_de_conduccion_del_imputado_a_proceso" class="form-label">Forma de conducción del imputado al proceso:</label>
      <select class="form-select" name="causa_H_forma_de_conduccion_del_imputado_a_proceso" id="causa_H_forma_de_conduccion_del_imputado_a_proceso">
        <option value="-1">Seleccione una opción</option>
        @foreach ($conduccionImp as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach      
     </select>
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_fecha_control" class="form-label">Fecha de audiencia de control de la detención:</label>
      <input type="date" class="form-control" name="causa_H_fecha_control" id="causa_H_fecha_control" value="">
    </div>        
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_decreto_legal_detencion" class="form-label">Decreto legal de detención:</label>
      <select class="form-select" name="causa_H_decreto_legal_detencion" id="causa_H_decreto_legal_detencion">
        <option value="-1">Seleccione una opción</option>
        @foreach ($SiNo as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach      
     </select>
    </div>  

    <div class="mb-4 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Formulación de imputación </h4>
      </div>
    </div>    
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_fecha_form" class="form-label">Fecha de formulación de la imputación:</label>
      <input type="date" class="form-control" name="causa_H_fecha_form" id="causa_H_fecha_form" value="">
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_formulacion" class="form-label">Formulación de la imputación:</label>
        <select class="form-select" name="causa_H_formulacion" id="causa_H_formulacion">
          <option value="-1">Seleccione una opción</option>
          @foreach ($SiNoNoI as $item)      
            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
          @endforeach        
       </select>
    </div>
    <div class="mb-3 col-12 obsForm" style="display:none;">
      <label for="causa_H_observaciones" class="form-label">Observaciones:</label>
      <textarea type="textarea" class="form-control" maxlength="255" rows="2" name="causa_H_observaciones" id="causa_H_observaciones" 
      placeholder="">{{$imputado->OBSERVACIONES??''}}</textarea>
        @if($errors->has('causa_H_observaciones'))
         <span class="text-danger">{{ $errors->first('causa_H_observaciones') }}</span>
        @endif
    </div>            
    <div class="mb-4 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Vinculación a proceso</h4>
      </div>
    </div> 

    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_fecha_resol" class="form-label">Fecha en que se dictó el auto de vinculación a proceso:</label>
      <input type="date" class="form-control" name="causa_H_fecha_resol" id="causa_H_fecha_resol" value="">
    </div>   
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_resolucion" class="form-label">Resolución del auto de vinculación a proceso:</label>
      <select class="form-select" name="causa_H_resolucion" id="causa_H_resolucion">
        <option value="-1">Seleccione una opción</option>
        @foreach ($resolAuto as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach      
     </select>
    </div>
    <div class="mb-3 col-sm-12 col-md-12 col-lg-12">
      <label for="causa_H_delito_vinculo" class="form-label">Delito por el que se vinculó</label>
      <select multiple class="form-select" name="causa_H_delito_vinculo[]" id="causa_H_delito_vinculo">
        <!-- <option disabled value="-1">Seleccione una opción</option> -->
        @foreach ($delitosCP as $item)      
          <option value="{{ $item->idDelito }}">{{$item->Valor}}</option>      
        @endforeach
     </select>
    </div>
    <div class="mb-3 col-sm-12 col-md-6 col-lg-4 d-none">
      <label for="causa_H_inv_con_detenido" class="form-label">¿Se encuentra detenido?</label>
      <select class="form-select" name="causa_H_inv_con_detenido" id="causa_H_inv_con_detenido">
        <option value="-1">Seleccione una opción</option>
        @foreach ($SiNo as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach
     </select>
    </div>
  </div>
</div>
{{--  
  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Medida cautelar</h4>
    </div>
  </div>
  <div class="mb-3 col-12">
    <div class="accordion" id="accordionFiltrosMedidas_0">
      <div class="accordion-item">
        <h2 class="accordion-header" id="panelsFiltrosMedidas_0">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" 
          data-bs-target="#panelsStayOpen-collapseOneMedidas_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneMedidas_0">
            Listado de medidas cautelares
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOneMedidas_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosMedidas_0">
          <div class="accordion-body row">
            <div class="mb-3 col-sm-12 input-group">
              <label for="causa_H_medidas_cautelares" class="input-group-text">Medidas:</label>
              <select class="form-select imp0" name="causa_H_medidas_cautelares" id="causa_H_medidas_cautelares">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNoNoI as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>
                @endforeach
              </select> 
              <label for="causa_H_tipo_medidas_cautelares" class="input-group-text">Tipo:</label>
              <select class="form-select imp0" name="causa_H_tipo_medidas_cautelares" id="causa_H_tipo_medidas_cautelares">
                <option value="-1">Seleccione una opción</option>
                @foreach ($TMCautelares as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach        
              </select>         
              <label for="causa_H_temporalidad_medida" class="input-group-text">Temporalidad:</label>
              <select class="form-select imp0" name="causa_H_temporalidad_medida" id="causa_H_temporalidad_medida">
                <option value="-1">Seleccione una opción</option>
                @for ($i=1;$i<4;$i++)      
                  <option value="{{ $i }}">{{$i>1? $i.' MESES':$i.' MES'}}</option>      
                @endfor
              </select>
              <button type="button" class="btn btn-primary"onclick="javascript:addMedida(0)">
                Agregar medida
              </button>
            </div> 
            <input type="hidden" name="hdnMedidas0" id="hdnMedidas0">
            <table id="medidas0" class="col-12 table table-striped table-hover table-responsive caption-top">
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
              </tbody>
            </table>    
          </div>
        </div>
      </div>
    </div>
  </div> 
  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Salidas alternas</h4>
    </div>
  </div>
  <div class="mb-3 col-12">
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
        <input type="date" class="form-control" name="causa_H_fecha_acuerdos_reparatorios" id="causa_H_fecha_acuerdos_reparatorios">
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
        <input type="text" class="form-control monto" name="causa_H_monto_rep_daño" id="causa_H_monto_rep_daño" placeholder="">
      </div> 
      <!--     <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_condicion_impuesta" class="form-label">Condición impuesta:</label>
        <input type="text" class="form-control alfanum" name="causa_H_condicion_impuesta" id="causa_H_condicion_impuesta" placeholder="">
      </div> -->
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_temporalidad" class="form-label">Temporalidad de la condición impuesta:</label>
        <input type="text" class="form-control temporalidadMA" name="causa_H_temporalidad" id="causa_H_temporalidad" 
          placeholder="xx años, xx meses">
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_reparacion_del_daño_" class="form-label">Tipo de reparación del daño:</label>
        <input type="text" class="form-control alfanum" name="causa_H_reparacion_del_daño_" id="causa_H_reparacion_del_daño_" placeholder="">
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_temporalidad_salidad_alternas" class="form-label">Temporalidad de salidas alternas:</label>
        <input type="text" class="form-control temporalidad" name="causa_H_temporalidad_salidad_alternas" id="causa_H_temporalidad_salidad_alternas" 
        placeholder="xxx días">
      </div>
    </div>
  </div> 
  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Suspensión del proceso</h4>
    </div>
  </div>
  <div class="mb-3 col-12">
    <div class="row suspension">
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_suspension_condicional" class="form-label">Suspensión condicional del proceso:</label>
        <select class="form-select" name="causa_H_suspension_condicional" id="causa_H_suspension_condicional">
          <option value="-1">Seleccione una opción</option>
          @foreach ($SiNoNoI as $item)      
            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
          @endforeach
       </select>
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_fecha_suspension" class="form-label">Fecha en que se dictó la suspensión condicional del proceso:</label>
        <input type="date" class="form-control" name="causa_H_fecha_suspension" id="causa_H_fecha_suspension" value="">
      </div> 
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_tipo_suspension" class="form-label">Tipo de condiciones impuestas durante la suspensión condicional del proceso:</label>
        <select class="form-select" name="causa_H_tipo_suspension" id="causa_H_tipo_suspension">
          <option value="-1">Seleccione una opción</option>
          @foreach ($tipoConImp as $item)      
            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
          @endforeach      
        </select>
      </div>   
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_fecha_cumpl" class="form-label">Fecha en que se cumplimentó la suspensión condicional del proceso:</label>
        <input type="date" class="form-control" name="causa_H_fecha_cumpl" id="causa_H_fecha_cumpl" value="">
      </div>              
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4 d-none">
        <label for="causa_H_suspension_del_proceso" class="form-label">Suspensión del proceso:</label>
        <input type="text" class="form-control nonum" name="causa_H_suspension_del_proceso" id="causa_H_suspension_del_proceso" placeholder="">
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
          <label for="causa_H_causa_proceso" class="form-label">Causa de la suspensión:</label>
          <select class="form-select" name="causa_H_causa_proceso" id="causa_H_causa_proceso">
            <option value="-1">Seleccione una opción</option>
            @foreach ($causasSus as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
            @endforeach        
         </select>
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_fecha_de_reanudacion" class="form-label">Fecha de reanudación de audiencia:</label>
        <input type="date" class="form-control" name="causa_H_fecha_de_reanudacion" id="causa_H_fecha_de_reanudacion" value="">
      </div> 
    </div>
  </div> 
  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Sobreseimiento</h4>
    </div>
  </div> 
  <div class="mb-3 col-12">
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
  </div>
--}}
<script type="text/javascript">
  $("#frmCausasPenalesAI_0 #causa_H_formulacion").change(function() {
    if (this.value==0) {$("#frmCausasPenalesAI_0 .obsForm").show();}
    else
    {
      $("#frmCausasPenalesAI_0 .obsForm").hide();
      $("#frmCausasPenalesAI_0 .obsForm textarea").val('');
    }
  });
  // $("#frmCausasPenalesAI_0 #causa_H_acuerdo_reparatorio").change(function() {
  //   if (this.value==2) {$("#frmCausasPenalesAI_0 .fechaCump").show();}
  //   else
  //   {
  //     $("#frmCausasPenalesAI_0 .fechaCump").hide();
  //     $("#frmCausasPenalesAI_0 .fechaCump #causa_H_fecha_cumplimiento").val('');
  //   }
  // });  
</script>
      
   