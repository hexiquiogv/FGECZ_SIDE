{{--COMENTADO 29/05/2023 MxCONJ01_Ajustes SIDE (Causas Penales)_20230504
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_aplicacion_de_medida_de_restriccion" class="form-label">Aplicación de medida de protección:</label>
    <select class="form-select" name="causa_H_aplicacion_de_medida_de_restriccion" id="causa_H_aplicacion_de_medida_de_restriccion">
    <option value="-1">Seleccione una opción</option>
        @foreach ($SiNoNoA as $item)      
          <option value="{{ $item->id }}" 
            {{isset($imputado->APLICACION_DE_MEDIDA_DE_RESTRICCION) ? $imputado->APLICACION_DE_MEDIDA_DE_RESTRICCION==$item->id ?'selected':'':''}}>
            {{$item->Valor}}</option>      
        @endforeach 
   </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_tipo_de_medida" class="form-label">Tipo de medida de protección:</label>
    <select class="form-select" name="causa_H_tipo_de_medida" id="causa_H_tipo_de_medida">
    <option value="-1">Seleccione una opción</option>
        @foreach ($TMRestriccion as $item)      
          <option value="{{ $item->id }}" {{isset($imputado->TIPO_DE_MEDIDA) ? $imputado->TIPO_DE_MEDIDA==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach 
   </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_temporalidad_de_la_medida" class="form-label">Temporalidad de la medida de protección:</label>
      <select class="form-select" name="causa_H_temporalidad_de_la_medida" id="causa_H_temporalidad_de_la_medida">
        <option value="-1">Seleccione una opción</option>
        @for ($i=1;$i<4;$i++)      
          <option value="{{ $i }}" {{isset($imputado->TEMPORALIDAD_DE_LA_MEDIDA) ?
           $imputado->TEMPORALIDAD_DE_LA_MEDIDA==$i ?'selected':'':''}}>{{$i>1? $i.' MESES':$i.' MES'}}</option>      
        @endfor
      </select>
     <!-- <input type="text" class="form-control temporalidad" name="causa_H_temporalidad_de_la_medida" id="causa_H_temporalidad_de_la_medida" maxlength="70" 
     placeholder="xxx días"
     value="{{$imputado->TEMPORALIDAD_DE_LA_MEDIDA??''}}"> -->
      <!--onkeydown="return jsIsLetter(event);"  -->
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
      <label for="causa_H_actos_de_inv" class="form-label">Actos de investigación:</label>
      <select class="form-select" name="causa_H_actos_de_inv" id="causa_H_actos_de_inv">
        <option value="-1">Seleccione una opción</option>
        @foreach ($SiNoNoI as $item)      
          <option value="{{ $item->id }}" {{isset($imputado->ACTOS_DE_INV) ? $imputado->ACTOS_DE_INV==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach      
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 TipoActoInv" style="display:none;">
      <label for="causa_H_tipo_actos_de_inv" class="form-label" >Tipo de actos de investigación:</label>
      <select class="form-select" name="causa_H_tipo_actos_de_inv" id="causa_H_tipo_actos_de_inv">
        <option value="-1">Seleccione una opción</option>
        @foreach ($TipoActo as $item)      
          <option value="{{ $item->id }}" {{isset($imputado->TIPO_ACTOS_DE_INV) ? $imputado->TIPO_ACTOS_DE_INV==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
        @endforeach      
     </select>
  </div>
--}}

<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_forma_proceso" class="form-label">Forma en la que lleva su proceso:</label>
  <select class="form-select noValidate" name="causa_H_forma_proceso" id="causa_H_forma_proceso">
    <option value="-1">Seleccione una opción</option>
    @foreach ($formaProc as $item)      
      <option value="{{ $item->id }}" {{isset($imputado->FORMA_PROCESO) ? $imputado->FORMA_PROCESO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
    @endforeach              
 </select>
</div>

{{--<div class="mb-4 col-12 pestanaBase">
  <div class="pestanaTop">
    <h4>Forma de conducción</h4>
  </div>
</div>   
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_solicitud_de_orden_de_aprehension" class="form-label">Fecha de la solicitud de orden de aprehensión:</label>
  <input type="date" class="form-control" name="causa_H_solicitud_de_orden_de_aprehension" id="causa_H_solicitud_de_orden_de_aprehension" placeholder=""
  value="{{$imputado->SOLICITUD_DE_ORDEN_DE_APREHENSION??''}}">
</div>      
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_oa_sin_efecto" class="form-label">Fecha de orden de aprehensión sin efecto:</label>
  <input type="date" class="form-control" name="causa_H_oa_sin_efecto" id="causa_H_oa_sin_efecto" placeholder=""
  value="{{$imputado->OA_SIN_EFECTO??''}}">
</div>  
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_oa_negada" class="form-label">Fecha de orden de aprehensión negada:</label>
  <input type="date" class="form-control" name="causa_H_oa_negada" id="causa_H_oa_negada" placeholder=""
  value="{{$imputado->OA_NEGADA??''}}">
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_oa_cumplida" class="form-label">Fecha de orden de aprehensión cumplida:</label>
  <input type="date" class="form-control" name="causa_H_oa_cumplida" id="causa_H_oa_cumplida" placeholder=""
  value="{{$imputado->OA_CUMPLIDA??''}}">
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_orden_de_comparecencia_girada" class="form-label">Fecha de orden de comparecencia girada:</label>
  <input type="date" class="form-control" name="causa_H_orden_de_comparecencia_girada" id="causa_H_orden_de_comparecencia_girada" placeholder=""
  value="{{$imputado->ORDEN_DE_COMPARECENCIA_GIRADA??''}}">
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_orden_de_comparecencia_negada" class="form-label">Fecha de orden de comparecencia negada:</label>
  <input type="date" class="form-control" name="causa_H_orden_de_comparecencia_negada" id="causa_H_orden_de_comparecencia_negada" placeholder=""
  value="{{$imputado->ORDEN_DE_COMPARECENCIA_NEGADA??''}}">
</div>--}}



<div class="mb-4 col-12 pestanaBase">
  <div class="pestanaTop">
    <h4>Flagrancia</h4>
  </div>
</div> 
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_fecha_detencion" class="form-label">Fecha de detención:</label>
  <input type="date" class="form-control" name="causa_H_fecha_detencion" id="causa_H_fecha_detencion" 
  value="{{$imputado->FECHA_DETENCION??''}}">
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_detencion_legal" class="form-label">Tipo de detención:</label>
  <input type="text" class="form-control" name="causa_H_detencion_legal" id="causa_H_detencion_legal" 
  value="{{$imputado->DETENCION_LEGAL??''}}">
</div>


<div class="mb-4 col-12 pestanaBase">
  <div class="pestanaTop">
    <h4>Mandamientos Judiciales</h4>
  </div>
</div> 
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_tipo_mandamiento" class="form-label">Tipo de mandamiento:</label>
    <select class="form-select" name="causa_H_tipo_mandamiento" id="causa_H_tipo_mandamiento">
      <option value="-1">Seleccione una opción</option>
      @foreach ($TipoMJ as $item)      
        <option value="{{ $item->id }}" 
          {{isset($imputado->TIPO_MANDAMIENTO) ? $imputado->TIPO_MANDAMIENTO==$item->id ?'selected':'':''}}>
          {{$item->Valor}}</option>      
      @endforeach 
   </select>
</div>

<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_solicitud_de_mandamiento_judicial" class="form-label">Fecha de solicitud del mandamiento judicial:</label>
  <input type="date" class="form-control" name="causa_H_solicitud_de_mandamiento_judicial" id="causa_H_solicitud_de_mandamiento_judicial" value="{{$imputado->SOLICITUD_DE_MANDAMIENTO_JUDICIAL??''}}">
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_estatus_mandamiento" class="form-label">Estatus de mandamiento judicial:</label>
  <select class="form-select noValidate" name="causa_H_estatus_mandamiento" id="causa_H_estatus_mandamiento">
    <option value="-1">Seleccione una opción</option>
    @foreach ($estatusMJ as $item)      
      <option value="{{ $item->id }}" 
        {{isset($imputado->ESTATUS_MANDAMIENTO) ? $imputado->ESTATUS_MANDAMIENTO==$item->id ?'selected':'':''}}>
        {{$item->Valor}}</option>      
    @endforeach               
 </select>
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_fecha_libera" class="form-label">Fecha de libramiento del mandamiento:</label>
  <input type="date" class="form-control noValidate" name="causa_H_fecha_libera" id="causa_H_fecha_libera" 
  value="{{$imputado->FECHA_LIBERA??''}}">
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_fecha_mandamiento" class="form-label">Fecha de cumplimiento del mandamiento:</label>
  <input type="date" class="form-control" name="causa_H_fecha_mandamiento" id="causa_H_fecha_mandamiento" 
  value="{{$imputado->FECHA_MANDAMIENTO??''}}">
</div>

<div class="mb-4 col-12 pestanaBase">
  <div class="pestanaTop">
    <h4>Audiencia de garantías</h4>
  </div>
</div>
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

<div class="mb-4 col-12 pestanaBase">
  <div class="pestanaTop">
    <h4>Caso Urgente</h4>
  </div>
</div> 
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_caso_urgente_fecha_libramiento" class="form-label">Fecha de libramiento:</label>
  <input type="date" class="form-control" name="causa_H_caso_urgente_fecha_libramiento" id="causa_H_caso_urgente_fecha_libramiento" 
  value="{{$imputado->CASO_URGENTE_FECHA_LIBRAMIENTO??''}}">
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_caso_urgente_estatus" class="form-label">Tipo de mandamiento:</label>
    <select class="form-select" name="causa_H_caso_urgente_estatus" id="causa_H_caso_urgente_estatus">
      <option value="-1">Seleccione una opción</option>
      @foreach ($EstatusCU as $item)      
        <option value="{{ $item->id }}" 
          {{isset($imputado->CASO_URGENTE_ESTATUS) ? $imputado->CASO_URGENTE_ESTATUS==$item->id ?'selected':'':''}}>
          {{$item->Valor}}</option>      
      @endforeach 
   </select>
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_caso_urgente_fecha_cumplimiento" class="form-label">Fecha de cumplimiento:</label>
  <input type="date" class="form-control" name="causa_H_caso_urgente_fecha_cumplimiento" id="causa_H_caso_urgente_fecha_cumplimiento" 
  value="{{$imputado->CASO_URGENTE_FECHA_CUMPLIMIENTO??''}}">
</div>

<div class="mb-4 col-12 pestanaBase d-none">
  <div class="pestanaTop">
    <h4>Actos con y sin control judicial</h4>
  </div>
</div> 
<div class="mb-3 col-12 d-none">
  <div class="accordion" id="accordionFiltrosActos_con_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosActos_con_{{$imputado->id}}">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneActos_con_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneActos_con_{{$imputado->id}}">
          Listado de actos con control judicial
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneActos_con_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosActos_con_{{$imputado->id}}">
        <div class="accordion-body row">
          <div class="mb-3 col-sm-12 input-group">
              <label for="causa_H_tipos_de_actos_con_control" class="input-group-text">Tipos de actos con control judicial:</label>
              <select class="form-select actcon{{$imputado->id}}" name="causa_H_tipos_de_actos_con_control" id="causa_H_tipos_de_actos_con_control">
                <option value="-1">Seleccione una opción</option>
                  @foreach ($actosCon as $item)      
                    <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                  @endforeach  
             </select>           
            <button type="button" class="btn btn-primary"onclick="javascript:addActoConSin('con',{{$imputado->id}})">
              Agregar acto
            </button>  
          </div>
          <input type="hidden" name="hdnActos_con{{$imputado->id}}" id="hdnActos_con{{$imputado->id}}">
          <table id="actos_con{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
              <caption></caption>    
              <thead class="table-light">
              <tr>                
                <th scope="col">Tipo de acto con control judicial</th>
                <th scope="col">Eliminar</th>
              </tr>
            </thead>
            <tbody>
             @foreach ($actosConL[$imputado->id] as $actoC)                         
              <tr class="tr{{$imputado->id}}_{{$actoC->id}}">
                <td>{{$actoC->ACTO}}</td>
                <td>
                  <button type="button" title="Eliminar acto" class="btn btn-danger" 
                  onclick="eliminarActoConSin('con','{{$imputado->id}}','{{$actoC->id}}',1)">×</button>
                </td>
              </tr>
             @endforeach               
            </tbody>
          </table>    
        </div>
      </div>
    </div>
  </div>              
</div> 

<div class="mb-3 col-12 d-none">
  <div class="accordion" id="accordionFiltrosActos_sin_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosActos_sin_{{$imputado->id}}">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneActos_sin_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneActos_sin_{{$imputado->id}}">
          Listado de actos sin control judicial
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneActos_sin_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosActos_sin_{{$imputado->id}}">
        <div class="accordion-body row">
          <div class="mb-3 col-sm-12 input-group">
              <label for="causa_H_tipos_de_actos_sin_control" class="input-group-text">Tipos de actos sin control judicial:</label>
              <select class="form-select actsin{{$imputado->id}}" name="causa_H_tipos_de_actos_sin_control" id="causa_H_tipos_de_actos_sin_control">
                <option value="-1">Seleccione una opción</option>
                @foreach ($actosSin as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach   
             </select>             
            <button type="button" class="btn btn-primary"onclick="javascript:addActoConSin('sin',{{$imputado->id}})">
              Agregar acto
            </button>  
          </div>
          <input type="hidden" name="hdnActos_sin{{$imputado->id}}" id="hdnActos_sin{{$imputado->id}}">
          <table id="actos_sin{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
              <caption></caption>    
              <thead class="table-light">
              <tr>
                <th scope="col">Tipo de acto sin control judicial</th>
                <th scope="col">Eliminar</th>
              </tr>
            </thead>
            <tbody>  
             @foreach ($actosSinL[$imputado->id] as $actoS)                         
              <tr class="tr{{$imputado->id}}_{{$actoS->id}}">
                <td>{{$actoS->ACTO}}</td>
                <td>
                  <button type="button" title="Eliminar acto" class="btn btn-danger" 
                  onclick="eliminarActoConSin('sin','{{$imputado->id}}','{{$actoS->id}}',1)">×</button>
                </td>
              </tr>
             @endforeach                                               
            </tbody>
          </table>    
        </div>
      </div>
    </div>
  </div>              
</div> 

{{--COMENTADO 29/05/2023 MxCONJ01_Ajustes SIDE (Causas Penales)_20230504
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_cierre_inv" class="form-label">Fecha del cierre de la investigación :</label>
  <input type="date" class="form-control" name="causa_H_cierre_inv" id="causa_H_cierre_inv" value="{{$imputado->CIERRE_INV??''}}">
</div>
--}}
<script type="text/javascript">

</script>