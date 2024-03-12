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
       <option value="{{ $item->id }}"
        {{isset($imputado->FORMA_DE_CONDUCCION_DEL_IMPUTADO_A_PROCESO)?$imputado->FORMA_DE_CONDUCCION_DEL_IMPUTADO_A_PROCESO==$item->id ?'selected':'':''}}>
        {{$item->Valor}}
       </option>      
      @endforeach      
   </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_fecha_control" class="form-label">Fecha de audiencia de control de la detención:</label>
    <input type="date" class="form-control" name="causa_H_fecha_control" id="causa_H_fecha_control" value="{{$imputado->FECHA_CONTROL}}">
  </div>        
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_decreto_legal_detencion" class="form-label">Decreto legal de detención:</label>
    <select class="form-select" name="causa_H_decreto_legal_detencion" id="causa_H_decreto_legal_detencion">
      <option value="-1">Seleccione una opción</option>
      @foreach ($SiNo as $item)      
        <option value="{{ $item->id }}" 
          {{isset($imputado->DECRETO_LEGAL_DETENCION)?$imputado->DECRETO_LEGAL_DETENCION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
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
    <input type="date" class="form-control" name="causa_H_fecha_form" id="causa_H_fecha_form" value="{{$imputado->FECHA_FORM}}">
  </div> 
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_formulacion" class="form-label">Formulación de la imputación:</label>
      <select class="form-select" name="causa_H_formulacion" id="causa_H_formulacion">
        <option value="-1">Seleccione una opción</option>
        @foreach ($SiNoNoI as $item)      
          <option value="{{ $item->id }}"
            {{isset($imputado->FORMULACION)?$imputado->FORMULACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
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
    <input type="date" class="form-control" name="causa_H_fecha_resol" id="causa_H_fecha_resol" value="{{$imputado->FECHA_RESOL}}">
  </div> 
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_resolucion" class="form-label">Resolución del auto de vinculación a proceso:</label>
    <select class="form-select" name="causa_H_resolucion" id="causa_H_resolucion">
      <option value="-1">Seleccione una opción</option>
      @foreach ($resolAuto as $item)      
        <option value="{{ $item->id }}"
          {{isset($imputado->RESOLUCION)?$imputado->RESOLUCION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach      
   </select>
  </div>    
  <div class="mb-3 col-sm-12 col-md-12 col-lg-12">
    <label for="causa_H_delito_vinculo" class="form-label">Delito por el que se vinculó</label>
    <select multiple class="form-select" name="causa_H_delito_vinculo[]" id="causa_H_delito_vinculo">
      <!-- <option disabled value="-1">Seleccione una opción</option> -->
      @foreach ($delitosCP as $item)                
        <option value="{{ $item->idDelito }}"
          {{in_array($item->idDelito,explode(',',$imputado->DELITO_VINCULO)) ?'selected':''}}>{{$item->Valor}}</option>      
      @endforeach
   </select>
  </div>  
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 d-none">
    <label for="causa_H_inv_con_detenido" class="form-label">¿Se encuentra detenido?</label>
    <select class="form-select" name="causa_H_inv_con_detenido" id="causa_H_inv_con_detenido">
      <option value="-1">Seleccione una opción</option>
      @foreach ($SiNo as $item)      
        <option value="{{ $item->id }}"
          {{isset($imputado->INV_CON_DETENIDO)?$imputado->INV_CON_DETENIDO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
      @endforeach
   </select>
  </div>
</div>
<script type="text/javascript">
    $("#frmCausasPenalesAI_{{$imputado->id}} #causa_H_formulacion").change(function() {
    if (this.value==0) {$("#frmCausasPenalesAI_{{$imputado->id}} .obsForm").show();}
    else
    {
      $("#frmCausasPenalesAI_{{$imputado->id}} .obsForm").hide();
      $("#frmCausasPenalesAI_{{$imputado->id}} .obsForm textarea").val('');
    }
  });
  if ($("#frmCausasPenalesAI_{{$imputado->id}} #causa_H_formulacion").val()==0) 
    {$("#frmCausasPenalesAI_{{$imputado->id}} .obsForm").show();}
    else
    {
      $("#frmCausasPenalesAI_{{$imputado->id}} .obsForm").hide();
      $("#frmCausasPenalesAI_{{$imputado->id}} .obsForm textarea").val('');
    }
</script>