<div class="row causasInicial">
    <div class="mb-4 mt-5 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Acuerdos reparatorios</h4>
      </div>
    </div>  
    <div class="mb-3 input-group {{count($listados['imputadosDDL_A'])<1?'d-none':''}}">
      <label for="ddlImputados_A" class="input-group-text">Imputado:</label>        
      <select class="form-select" id="ddlImputados_A" name="ddlImputados_A" onchange="javascript:addImputadoFormModal('_A')">
        <option value="-1">Seleccione una opción</option>
        @foreach ($listados['imputadosDDL_A'] as $item)      
          <option value="{{$item->id}}" data-forma="{{$item->FORMA_}}"
            data-detencion="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
        @endforeach       
      </select>
      <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button> -->
    </div>
    <div id="addImputadoForm_A" style="display: none;">
      <form method='post' name="frmCausasPenalesAI_A_0" id="frmCausasPenalesAI_A_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="row">
            @csrf  
          <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="0">
          <input type="hidden" name="idImputado" id="idImputado" value="">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="A">

          <div class="mb-3 col-12">
            <div class="accordion" id="accordionFiltrosAcuerdos_0">
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsFiltrosAcuerdos_0">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                  data-bs-target="#panelsStayOpen-collapseOneAcuerdos_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAcuerdos_0">
                    Listado de acuerdos reparatorios
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOneAcuerdos_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosAcuerdos_0">
                  <div class="accordion-body row">
                    <div class="col-sm-12 input-group">
                      <label for="causa_H_acuerdo_reparatorio" class="input-group-text">Acuerdo reparatorio:</label>
                      <select class="form-select imp0" name="causa_H_acuerdo_reparatorio" id="causa_H_acuerdo_reparatorio">
                        <option value="-1">Seleccione una opción</option>
                        @foreach ($acuerdo as $item)      
                          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                        @endforeach
                      </select>
                      <label for="causa_H_fecha_cumplimiento" class="input-group-text fechaCump" style="display:none;">
                      Fecha de cumplimiento:</label>
                      <input type="date" class="form-control imp0 fechaCump" style="display:none;" 
                      name="causa_H_fecha_cumplimiento" id="causa_H_fecha_cumplimiento">
                    </div>
                    <div class="col-sm-12 input-group">
                      <label for="causa_H_fecha_acuerdos_reparatorios" class="input-group-text">
                      Fecha de acuerdo reparatorio:</label>
                      <input type="date" class="form-control imp0" name="causa_H_fecha_acuerdos_reparatorios" id="causa_H_fecha_acuerdos_reparatorios">

                      <label for="causa_H_acuerdos_reparatorios" class="input-group-text">
                      Tipo de acuerdos reparatorios:</label>
                      <select class="form-select imp0" name="causa_H_acuerdos_reparatorios" id="causa_H_acuerdos_reparatorios">
                        <option value="-1">Seleccione una opción</option>
                        @foreach ($tipoAcuerdo as $item)      
                          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                        @endforeach      
                      </select>
                    </div>
                    <div class="col-sm-12 input-group obsReparatorios" style="display:none;">
                      <label for="causa_H_acuerdos_reparatorios_observaciones" class="input-group-text">Observaciones:</label>
                      <input type="text" class="form-control imp0 alfanum" name="causa_H_acuerdos_reparatorios_observaciones" 
                      id="causa_H_acuerdos_reparatorios_observaciones">
                    </div>                      
                    <div class="col-sm-12 input-group">

                      <label for="causa_H_monto_rep_daño" class="input-group-text">Monto de la reparación del daño:</label>
                      <input type="text" class="form-control imp0 monto" name="causa_H_monto_rep_daño" id="causa_H_monto_rep_daño">

                      <label for="causa_H_reparacion_del_daño_" class="input-group-text d-none">Tipo de reparación del daño:</label>
                      <input type="text" class="form-control imp0 alfanum d-none" name="causa_H_reparacion_del_daño_" id="causa_H_reparacion_del_daño_">
                    <!-- </div>
                    <div class="col-sm-12 input-group"> -->
                      <label for="causa_H_temporalidad_salidad_alternas" class="input-group-text">Temporalidad de acuerdo reparatorio:</label>
                      <input type="text" class="form-control imp0 temporalidad" name="causa_H_temporalidad_salidad_alternas" id="causa_H_temporalidad_salidad_alternas" placeholder="xx días">
                      <button type="button" class="btn btn-primary"onclick="javascript:addAcuerdo(0)">
                        Agregar acuerdo
                      </button>
                    </div>                         
                    <input type="hidden" name="hdnAcuerdos0" id="hdnAcuerdos0">
                    <table id="acuerdos0" class="col-12 table table-striped table-hover table-responsive caption-top">
                        <caption></caption>    
                        <thead class="table-light">
                        <tr>
                          <th scope="col">Acuerdo reparatorio</th>
                          <th scope="col">Fecha de cumplimiento</th>
                          <th scope="col">Fecha de acuerdo</th>
                          <th scope="col">Tipo de acuerdos</th>
                          <th scope="col"></th>
                          <th scope="col">Monto de la reparación del daño</th>
                          <!-- <th scope="col">Tipo de reparación del daño</th> -->
                          <th scope="col">Temporalidad de acuerdo</th>                            
                          <th scope="col">Eliminar</th>
                        </tr>
                      </thead>
                      <tbody> 
                     
                      </tbody>
                    </table>    
                  <div class="modal-footer">            
                    <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesAI_A_0').submit()">Guardar</button>
                  </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          
        </div>
      </form> 
    </div>
    @foreach($listados['imputadosCP_A'] as $imputado)
     <div class="accordion mb-2" id="accordionFiltrosAudienciaIA_{{$imputado->id}}">
      <div class="accordion-item">
        <h2 class="accordion-header" id="panelsFiltrosAudienciaIA_{{$imputado->id}}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
          data-bs-target="#panelsStayOpen-collapseOneAudienciaIA_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaIA_{{$imputado->id}}">
            Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOneAudienciaIA_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaIA_{{$imputado->id}}">
         <form method='post' name="frmCausasPenalesAI_A_{{$imputado->id}}" id="frmCausasPenalesAI_A_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="A">

            <div class="mb-3 col-12">
              <div class="accordion" id="accordionFiltrosAcuerdos_{{$imputado->id}}">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsFiltrosAcuerdos_{{$imputado->id}}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#panelsStayOpen-collapseOneAcuerdos_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAcuerdos_{{$imputado->id}}">
                      Listado de acuerdos reparatorios
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseOneAcuerdos_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosAcuerdos_{{$imputado->id}}">
                    <div class="accordion-body row">
                      <div class="col-sm-12 input-group">
                        <label for="causa_H_acuerdo_reparatorio" class="input-group-text">Acuerdo reparatorio:</label>
                        <select class="form-select imp{{$imputado->id}}" name="causa_H_acuerdo_reparatorio" id="causa_H_acuerdo_reparatorio">
                          <option value="-1">Seleccione una opción</option>
                          @foreach ($acuerdo as $item)      
                            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                          @endforeach
                        </select>
                        <label for="causa_H_fecha_cumplimiento" class="input-group-text fechaCump" style="display:none;">
                        Fecha de cumplimiento:</label>
                        <input type="date" class="form-control imp{{$imputado->id}} fechaCump" style="display:none;"
                        name="causa_H_fecha_cumplimiento" id="causa_H_fecha_cumplimiento">
                      </div>
                      <div class="col-sm-12 input-group">
                        <label for="causa_H_fecha_acuerdos_reparatorios" class="input-group-text">
                        Fecha de acuerdo reparatorio:</label>
                        <input type="date" class="form-control imp{{$imputado->id}}" name="causa_H_fecha_acuerdos_reparatorios" id="causa_H_fecha_acuerdos_reparatorios">

                        <label for="causa_H_acuerdos_reparatorios" class="input-group-text">
                        Tipo de acuerdos reparatorios:</label>
                        <select class="form-select imp{{$imputado->id}}" name="causa_H_acuerdos_reparatorios" id="causa_H_acuerdos_reparatorios">
                          <option value="-1">Seleccione una opción</option>
                          @foreach ($tipoAcuerdo as $item)      
                            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                          @endforeach      
                        </select>
                      </div>
                      <div class="col-sm-12 input-group obsReparatorios" style="display:none;">
                        <label for="causa_H_acuerdos_reparatorios_observaciones" class="input-group-text">Observaciones:</label>
                        <input type="text" class="form-control imp{{$imputado->id}} alfanum" 
                        name="causa_H_acuerdos_reparatorios_observaciones" id="causa_H_acuerdos_reparatorios_observaciones">
                      </div>
                      <div class="col-sm-12 input-group">

                        <label for="causa_H_monto_rep_daño" class="input-group-text">Monto de la reparación del daño:</label>
                        <input type="text" class="form-control imp{{$imputado->id}} monto" name="causa_H_monto_rep_daño" id="causa_H_monto_rep_daño">
 
                        <label for="causa_H_reparacion_del_daño_" class="input-group-text d-none">Tipo de reparación del daño:</label>
                        <input type="text" class="form-control imp{{$imputado->id}} alfanum d-none" name="causa_H_reparacion_del_daño_" id="causa_H_reparacion_del_daño_">
                      <!-- </div>
                      <div class="col-sm-12 input-group"> -->
                        <label for="causa_H_temporalidad_salidad_alternas" class="input-group-text">Temporalidad de acuerdo reparatorio:</label>
                        <input type="text" class="form-control imp{{$imputado->id}} temporalidad" name="causa_H_temporalidad_salidad_alternas" id="causa_H_temporalidad_salidad_alternas" placeholder="xx días">
                        <button type="button" class="btn btn-primary"onclick="javascript:addAcuerdo({{$imputado->id}})">
                          Agregar acuerdo
                        </button>
                      </div>                         
                      <input type="hidden" name="hdnAcuerdos{{$imputado->id}}" id="hdnAcuerdos{{$imputado->id}}">
                      <table id="acuerdos{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
                          <caption></caption>    
                          <thead class="table-light">
                          <tr>
                            <th scope="col">Acuerdo reparatorio</th>
                            <th scope="col">Fecha de cumplimiento</th>
                            <th scope="col">Fecha de acuerdo</th>
                            <th scope="col">Tipo de acuerdos</th>
                            <th scope="col"></th>
                            <th scope="col">Monto de la reparación del daño</th>
                            <!-- <th scope="col">Tipo de reparación del daño</th> -->
                            <th scope="col">Temporalidad de acuerdo</th>                            
                            <th scope="col">Eliminar</th>
                          </tr>
                        </thead>
                        <tbody> 
                         @foreach ($acuerdos[$imputado->id] as $acuerdor)
                          <tr class="tr{{$imputado->id}}_{{$acuerdor->id}}">
                            <td>{{$acuerdor->ACUERDO}}</td>
                            <td>{{$acuerdor->FECHA_CUMPLIMIENTO}}</td>
                            <td>{{$acuerdor->FECHA_ACUERDOS_REPARATORIOS}}</td>
                            <td>{{$acuerdor->ACUERDOS}}</td>
                            <td>{{$acuerdor->ACUERDOS_REPARATORIOS_OBSERVACIONES}}</td>
                            <td>{{$acuerdor->MONTO_REP_DAÑO}}</td>
                            {{-- <td>{{$acuerdor->REPARACION_DEL_DAÑO}}</td> --}}
                            <td>{{$acuerdor->TEMPORALIDAD}}</td>
                            <td>
                              <button type="button" title="Eliminar acuerdo" class="btn btn-danger" 
                              onclick="eliminarAcuerdo('{{$imputado->id}}','{{$acuerdor->id}}',1)">×</button>
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

            <div class="border-top pt-2 modal-footer">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            </div> 
          </div>
         </form>
        </div>
      </div>
     </div>
      <script type="text/javascript">  
      $("#frmCausasPenalesAI_A_{{$imputado->id}} #causa_H_acuerdo_reparatorio").change(function() {
        if (this.value==2) {$("#frmCausasPenalesAI_A_{{$imputado->id}} .fechaCump").show();}
        else
        {
          $("#frmCausasPenalesAI_A_{{$imputado->id}} .fechaCump").hide();
          $("#frmCausasPenalesAI_A_{{$imputado->id}} .fechaCump #causa_H_fecha_cumplimiento").val('');
        }
      });
      $("#frmCausasPenalesAI_A_{{$imputado->id}} #causa_H_acuerdos_reparatorios").change(function() {
        if (this.value==4) {$("#frmCausasPenalesAI_A_{{$imputado->id}} .obsReparatorios").show();}
        else
        {
          $("#frmCausasPenalesAI_A_{{$imputado->id}} .obsReparatorios").hide();
          $("#frmCausasPenalesAI_A_{{$imputado->id}} .obsReparatorios #causa_H_acuerdos_reparatorios_observaciones").val('');
        }
      }); 

      </script>     
    @endforeach

    <div class="mb-4 mt-5 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Suspensión condicional del proceso</h4>
      </div>
    </div>  
    <div class="mb-3 input-group {{count($listados['imputadosDDL_S'])<1?'d-none':''}}">
      <label for="ddlImputados_S" class="input-group-text">Imputado:</label>        
      <select class="form-select" id="ddlImputados_S" name="ddlImputados_S" onchange="javascript:addImputadoFormModal('_S')">
        <option value="-1">Seleccione una opción</option>
        @foreach ($listados['imputadosDDL_S'] as $item)      
          <option value="{{$item->id}}" data-forma="{{$item->FORMA_}}"
            data-detencion="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
        @endforeach       
      </select>
      <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button> -->
    </div>
    <div id="addImputadoForm_S" style="display: none;">
      <form method='post' name="frmCausasPenalesAI_S_0" id="frmCausasPenalesAI_S_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="row">
            @csrf  
          <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="0">
          <input type="hidden" name="idImputado" id="idImputado" value="">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="S">

          <div class="mb-3 col-12">
            <div class="accordion" id="accordionFiltrosSuspensiones_0">
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsFiltrosSuspensiones_0">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                  data-bs-target="#panelsStayOpen-collapseOneSuspensiones_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneSuspensiones_0">
                    Listado de suspensiones condicionales
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOneSuspensiones_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosSuspensiones_0">
                  <div class="accordion-body row">
                    {{--
                    <div class="col-sm-12 input-group">

                      <label for="causa_H_suspension_condicional" class="input-group-text">Suspensión condicional del proceso:</label>
                      <select class="form-select imp0" name="causa_H_suspension_condicional" id="causa_H_suspension_condicional">
                        <option value="-1">Seleccione una opción</option>
                        @foreach ($SiNoNoI as $item)      
                          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                        @endforeach
                      </select>
                    </div>
                    --}}
                    <div class="col-sm-12 input-group">

                      <label for="causa_H_fecha_suspension" class="input-group-text">Fecha en que se dictó la suspensión condicional del proceso:</label>
                      <input type="date" class="form-control imp0" name="causa_H_fecha_suspension" id="causa_H_fecha_suspension">
                    </div>
                    <div class="col-sm-12 input-group">
                      <label for="causa_H_tipo_suspension" class="input-group-text">Tipo de condiciones impuestas durante la suspensión condicional del proceso:</label>
                      <select class="form-select imp0" name="causa_H_tipo_suspension" id="causa_H_tipo_suspension">
                        <option value="-1">Seleccione una opción</option>
                        @foreach ($tipoConImp as $item)      
                          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                        @endforeach      
                      </select>
                      <button type="button" title="Acumular condición" class="btn btn-outline-success" 
                      onclick="javascript:acumularCondicion(0)">Acumular condición</button>                      
                    </div>
                      <div>        
                        <input type="hidden" id="hdnacumulado0" name="hdnacumulado0">
                        <div class="alert alert-dark mb-0" id="txtacumulado0"></div>                          
                      </div>
                    <div class="col-sm-12 input-group obsSuspension" style="display:none;">
                      <label for="causa_H_suspension_observaciones" class="input-group-text">Observaciones:</label>
                      <input type="text" class="form-control imp0 alfanum" 
                      name="causa_H_suspension_observaciones" id="causa_H_suspension_observaciones">
                    </div>                        
                    <div class="col-sm-12 input-group">

                      <label for="causa_H_fecha_cumpl" class="input-group-text">Fecha en que se cumplimentó la suspensión condicional del proceso:</label>
                      <input type="date" class="form-control imp0" name="causa_H_fecha_cumpl" id="causa_H_fecha_cumpl">

                    </div>
                    <div class="col-sm-12 input-group">
                      <label for="causa_H_revocacion_suspension" class="input-group-text">
                      Revocación de suspensión del proceso:</label>
                      <select class="form-select imp0" name="causa_H_revocacion_suspension" 
                        id="causa_H_revocacion_suspension">
                        <option value="-1">Seleccione una opción</option>
                        @foreach ($SiNo as $item)      
                          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                        @endforeach
                      </select>
                      <label for="causa_H_motivo_revocacion" class="input-group-text">Motivo de revocación:</label>
                      <input type="text" class="form-control imp0 alfanum" 
                      name="causa_H_motivo_revocacion" id="causa_H_motivo_revocacion">                        
                    </div>
                    <div class="col-sm-12 input-group">
                      <label for="causa_H_reapertura" class="input-group-text">Reapertura del proceso:</label>
                      <select class="form-select imp0" name="causa_H_reapertura" id="causa_H_reapertura">
                        <option value="-1">Seleccione una opción</option>
                        @foreach ($SiNoNoI as $item)      
                          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                        @endforeach         
                     </select>
                      <label for="causa_H_fecha_reapertura" class="input-group-text">Fecha de la reapertura del proceso:</label>
                      <input type="date" class="form-control imp0" name="causa_H_fecha_reapertura" 
                      id="causa_H_fecha_reapertura">
                    </div>                        
                    <div class="col-sm-12 input-group">
                      <button type="button" class="btn btn-primary"onclick="javascript:addSuspension(0)">
                        Agregar suspensión
                      </button>
                    </div>                                               
                    <input type="hidden" name="hdnSuspensiones0" id="hdnSuspensiones0">
                    <table id="suspensiones0" class="col-12 table table-striped table-hover table-responsive caption-top">
                        <caption></caption>    
                        <thead class="table-light">
                        <tr>
                          <th scope="col">Fecha en que se dictó la suspensión</th>
                          <th scope="col">Tipo de condiciones impuestas durante la suspensión</th>
                          <th scope="col"></th>
                          <th scope="col">Fecha en que se cumplimentó la suspensión</th>
                          <th scope="col">Revocación de suspensión del proceso</th>
                          <th scope="col">Motivo de revocación</th>
                          <th scope="col">Reapertura del proceso</th>
                          <th scope="col">Fecha de la reapertura del proceso</th>                            
                          <th scope="col">Eliminar</th>
                        </tr>
                      </thead>
                      <tbody> 

                      </tbody>
                    </table>    
                  <div class="modal-footer">            
                    <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesAI_S_0').submit()">Guardar</button>
                  </div>

                  </div>
                </div>
              </div>
            </div>
          </div>             
        </div>
      </form> 
    </div>
    @foreach($listados['imputadosCP_S'] as $imputado)
     <div class="accordion mb-2" id="accordionFiltrosAudienciaIS_{{$imputado->id}}">
      <div class="accordion-item">
        <h2 class="accordion-header" id="panelsFiltrosAudienciaIS_{{$imputado->id}}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
          data-bs-target="#panelsStayOpen-collapseOneAudienciaIS_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaIS_{{$imputado->id}}">
            Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOneAudienciaIS_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaIS_{{$imputado->id}}">
         <form method='post' name="frmCausasPenalesAI_S_{{$imputado->id}}" id="frmCausasPenalesAI_S_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">            
            <input type="hidden" name="frmSecc" id="frmSecc" value="S">

            <div class="mb-4 col-12 pestanaBase">
              <div class="pestanaTop">
                <h4>Suspensión condicional del proceso</h4>
              </div>
            </div>
            <div class="mb-3 col-12">
              <div class="accordion" id="accordionFiltrosSuspensiones_{{$imputado->id}}">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsFiltrosSuspensiones_{{$imputado->id}}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#panelsStayOpen-collapseOneSuspensiones_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneSuspensiones_{{$imputado->id}}">
                      Listado de suspensiones condicionales
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseOneSuspensiones_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosSuspensiones_{{$imputado->id}}">
                    <div class="accordion-body row">
                      {{--
                      <div class="col-sm-12 input-group">
                        <label for="causa_H_suspension_condicional" class="input-group-text">Suspensión condicional del proceso:</label>
                        <select class="form-select imp{{$imputado->id}}" name="causa_H_suspension_condicional" 
                          id="causa_H_suspension_condicional">
                          <option value="-1">Seleccione una opción</option>
                          @foreach ($SiNoNoI as $item)      
                            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                          @endforeach
                        </select>
                      </div>
                      --}}
                      <div class="col-sm-12 input-group">

                        <label for="causa_H_fecha_suspension" class="input-group-text">Fecha en que se dictó la suspensión condicional del proceso:</label>
                        <input type="date" class="form-control imp{{$imputado->id}}" name="causa_H_fecha_suspension" 
                        id="causa_H_fecha_suspension">
                      </div>
                      <div class="col-sm-12 input-group">
                        <label for="causa_H_tipo_suspension" class="input-group-text">Tipo de condiciones impuestas durante la suspensión condicional del proceso:</label>
                        <select class="form-select imp{{$imputado->id}}" name="causa_H_tipo_suspension" id="causa_H_tipo_suspension">
                          <option value="-1">Seleccione una opción</option>
                          @foreach ($tipoConImp as $item)      
                            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                          @endforeach      
                        </select>
                        <button type="button" title="Acumular condición" class="btn btn-outline-success" 
                        onclick="javascript:acumularCondicion({{$imputado->id}})">Acumular condición</button>
                      </div>
                      <div>        
                        <input type="hidden" id="hdnacumulado{{$imputado->id}}" name="hdnacumulado{{$imputado->id}}">
                        <div class="alert alert-dark mb-0" id="txtacumulado{{$imputado->id}}"></div>                          
                      </div>                       
                      <div class="col-sm-12 input-group obsSuspension" style="display:none;">
                        <label for="causa_H_suspension_observaciones" class="input-group-text">Observaciones:</label>
                        <input type="text" class="form-control imp{{$imputado->id}} alfanum" 
                        name="causa_H_suspension_observaciones" id="causa_H_suspension_observaciones">
                      </div>  
                      <div class="col-sm-12 input-group">

                        <label for="causa_H_fecha_cumpl" class="input-group-text">Fecha en que se cumplimentó la suspensión condicional del proceso:</label>
                        <input type="date" class="form-control imp{{$imputado->id}}" name="causa_H_fecha_cumpl" 
                        id="causa_H_fecha_cumpl">

                      </div>                       
                      <div class="col-sm-12 input-group">
                        <label for="causa_H_revocacion_suspension" class="input-group-text">
                        Revocación de suspensión del proceso:</label>
                        <select class="form-select imp{{$imputado->id}}" name="causa_H_revocacion_suspension" 
                          id="causa_H_revocacion_suspension">
                          <option value="-1">Seleccione una opción</option>
                          @foreach ($SiNo as $item)      
                            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                          @endforeach
                        </select>
                        <label for="causa_H_motivo_revocacion" class="input-group-text">Motivo de revocación:</label>
                        <input type="text" class="form-control imp{{$imputado->id}} alfanum" 
                        name="causa_H_motivo_revocacion" id="causa_H_motivo_revocacion">                        
                      </div>
                      <div class="col-sm-12 input-group">
                        <label for="causa_H_reapertura" class="input-group-text">Reapertura del proceso:</label>
                        <select class="form-select imp{{$imputado->id}}" name="causa_H_reapertura" id="causa_H_reapertura">
                          <option value="-1">Seleccione una opción</option>
                          @foreach ($SiNoNoI as $item)      
                            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                          @endforeach         
                       </select>
                        <label for="causa_H_fecha_reapertura" class="input-group-text">Fecha de la reapertura del proceso:</label>
                        <input type="date" class="form-control imp{{$imputado->id}}" name="causa_H_fecha_reapertura" 
                        id="causa_H_fecha_reapertura">
                      </div>                        
                      <div class="col-sm-12 input-group">
                        <button type="button" class="btn btn-primary"onclick="javascript:addSuspension({{$imputado->id}})">
                          Agregar suspensión
                        </button>
                      </div>                         
                      <input type="hidden" name="hdnSuspensiones{{$imputado->id}}" id="hdnSuspensiones{{$imputado->id}}">
                      <table id="suspensiones{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
                          <caption></caption>    
                          <thead class="table-light">
                          <tr>
                            <th scope="col">Fecha en que se dictó la suspensión</th>
                            <th scope="col">Tipo de condiciones impuestas durante la suspensión</th>
                            <th scope="col"></th>
                            <th scope="col">Fecha en que se cumplimentó la suspensión</th>
                            <th scope="col">Revocación de suspensión del proceso</th>
                            <th scope="col">Motivo de revocación</th>
                            <th scope="col">Reapertura del proceso</th>
                            <th scope="col">Fecha de la reapertura del proceso</th>
                            <th scope="col">Eliminar</th>
                          </tr>
                        </thead>
                        <tbody> 
                       @foreach ($suspensiones[$imputado->id] as $suspension)
                        <tr class="tr{{$imputado->id}}_{{$suspension->id}}">
                          <td>{{$suspension->FECHA_SUSPENSION}}</td>
                          <td>{{$suspension->TIPOSUSPENSION}}</td>
                          <td>{{$suspension->SUSPENSION_OBSERVACIONES}}</td>
                          <td>{{$suspension->FECHA_CUMPL}}</td> 
                          <td>{{$suspension->REVOCACION}}</td> 
                          <td>{{$suspension->MOTIVO_REVOCACION}}</td> 
                          <td>{{$suspension->REAPERTURAVALOR}}</td> 
                          <td>{{$suspension->FECHA_REAPERTURA}}</td>                          
                          <td>
                            <button type="button" title="Eliminar suspensión" class="btn btn-danger" 
                            onclick="eliminarSuspension('{{$imputado->id}}','{{$suspension->id}}',1)">×</button>
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

            <div class="border-top pt-2 modal-footer">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            </div> 
          </div>
         </form>
        </div>
      </div>
     </div>    
      <script type="text/javascript">
        $("#frmCausasPenalesAI_S_{{$imputado->id}} #causa_H_tipo_suspension").change(function() {
          if (this.value==14) {$("#frmCausasPenalesAI_S_{{$imputado->id}} .obsSuspension").show();}
          else
          {
            $("#frmCausasPenalesAI_S_{{$imputado->id}} .obsSuspension").hide();
            $("#frmCausasPenalesAI_S_{{$imputado->id}} .obsSuspension #causa_H_suspension_observaciones").val('');
          }
        }); 
      </script>
    @endforeach 

    <div class="mb-4 mt-5 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Acto equivalente</h4>
      </div>
    </div>  
    <div class="mb-3 input-group {{count($listados['imputadosDDL'])<1?'d-none':''}}">
      <label for="ddlImputados_C" class="input-group-text">Imputado:</label>        
      <select class="form-select" id="ddlImputados_C" name="ddlImputados_C" onchange="javascript:addImputadoFormModal('_C')">
        <option value="-1">Seleccione una opción</option>
        @foreach ($listados['imputadosDDL'] as $item)      
          <option value="{{$item->id}}">{{$item->Valor}}</option>      
        @endforeach       
      </select>      
    </div>
    <div id="addImputadoForm_C" style="display: none;">
      <form method='post' name="frmCausasPenalesAI_C_0" id="frmCausasPenalesAI_C_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="row">
            @csrf  
          <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="0">
          <input type="hidden" name="idImputado" id="idImputado" value="">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="C">
          <div class="mb-3 col-sm-12 input-group">                      
            <label for="expediente_H_Folio_AE" class="input-group-text">Folio:</label>
            <input type="text" class="form-control alfanum" name="expediente_H_Folio_AE" id="expediente_H_Folio_AE">
            <label for="expediente_H_acto_equivalente_monto" class="input-group-text">Monto:</label>
            <input type="text" class="form-control monto" name="expediente_H_acto_equivalente_monto" id="expediente_H_acto_equivalente_monto">
            <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesAI_C_0').submit()">Guardar</button>
          </div>
        </div>
      </form> 
    </div>
    @foreach($listados['imputadosCP'] as $imputado)    
     <div class="accordion mb-2" id="accordionFiltrosAudienciaIC_{{$imputado->id}}">
      <div class="accordion-item">
        <h2 class="accordion-header" id="panelsFiltrosAudienciaIC_{{$imputado->id}}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
          data-bs-target="#panelsStayOpen-collapseOneAudienciaIC_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaIC_{{$imputado->id}}">
            Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOneAudienciaIC_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaIC_{{$imputado->id}}">
         <form method='post' name="frmCausasPenalesAI_C_{{$imputado->id}}" id="frmCausasPenalesAI_C_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="C">
            <div class="mb-3 col-sm-12 input-group">                      
              <label for="expediente_H_Folio_AE" class="input-group-text">Folio:</label>
              <input type="text" class="form-control alfanum" name="expediente_H_Folio_AE" 
              id="expediente_H_Folio_AE" value="{{$imputado->FOLIO_AE}}">
              <label for="expediente_H_acto_equivalente_monto" class="input-group-text">Monto:</label>
              <input type="text" class="form-control monto" name="expediente_H_acto_equivalente_monto" 
              id="expediente_H_acto_equivalente_monto" value="{{$imputado->ACTO_EQUIVALENTE_MONTO}}">
              <button type="submit" class="btn btn-primary">Actualizar</button>              
            </div>
          </div>
         </form>
        </div>
      </div>
     </div>
      <script type="text/javascript">  
      $("#frmCausasPenalesAI_A_{{$imputado->id}} #causa_H_acuerdo_reparatorio").change(function() {
        if (this.value==2) {$("#frmCausasPenalesAI_A_{{$imputado->id}} .fechaCump").show();}
        else
        {
          $("#frmCausasPenalesAI_A_{{$imputado->id}} .fechaCump").hide();
          $("#frmCausasPenalesAI_A_{{$imputado->id}} .fechaCump #causa_H_fecha_cumplimiento").val('');
        }
      });
      $("#frmCausasPenalesAI_A_{{$imputado->id}} #causa_H_acuerdos_reparatorios").change(function() {
        if (this.value==4) {$("#frmCausasPenalesAI_A_{{$imputado->id}} .obsReparatorios").show();}
        else
        {
          $("#frmCausasPenalesAI_A_{{$imputado->id}} .obsReparatorios").hide();
          $("#frmCausasPenalesAI_A_{{$imputado->id}} .obsReparatorios #causa_H_acuerdos_reparatorios_observaciones").val('');
        }
      }); 

      </script>     
    @endforeach      
</div>
{{--
  <div class="modal fade" id="addImputadoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addImputadoFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addImputadoFormLabel">Salidas alternas del imputado</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method='post' name="frmCausasPenalesAI_0" id="frmCausasPenalesAI_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
            <div class="row">
                @csrf  
              <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="0">
              <input type="hidden" name="idImputado" id="idImputado" value="">
              <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
              <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
              <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
              <div class="mb-4 col-12 pestanaBase">
                <div class="pestanaTop">
                  <h4>Acuerdos reparatorios</h4>
                </div>
              </div>
              <div class="mb-3 col-12">
                <div class="accordion" id="accordionFiltrosAcuerdos_0">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsFiltrosAcuerdos_0">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                      data-bs-target="#panelsStayOpen-collapseOneAcuerdos_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAcuerdos_0">
                        Listado de acuerdos reparatorios
                      </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOneAcuerdos_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosAcuerdos_0">
                      <div class="accordion-body row">
                        <div class="col-sm-12 input-group">
                          <label for="causa_H_acuerdo_reparatorio" class="input-group-text">Acuerdo reparatorio:</label>
                          <select class="form-select imp0" name="causa_H_acuerdo_reparatorio" id="causa_H_acuerdo_reparatorio">
                            <option value="-1">Seleccione una opción</option>
                            @foreach ($acuerdo as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                            @endforeach
                          </select>
                          <label for="causa_H_fecha_cumplimiento" class="input-group-text fechaCump" style="display:none;">
                          Fecha de cumplimiento:</label>
                          <input type="date" class="form-control imp0 fechaCump" style="display:none;" 
                          name="causa_H_fecha_cumplimiento" id="causa_H_fecha_cumplimiento">
                        </div>
                        <div class="col-sm-12 input-group">
                          <label for="causa_H_fecha_acuerdos_reparatorios" class="input-group-text">
                          Fecha de acuerdo reparatorio:</label>
                          <input type="date" class="form-control imp0" name="causa_H_fecha_acuerdos_reparatorios" id="causa_H_fecha_acuerdos_reparatorios">

                          <label for="causa_H_acuerdos_reparatorios" class="input-group-text">
                          Tipo de acuerdos reparatorios:</label>
                          <select class="form-select imp0" name="causa_H_acuerdos_reparatorios" id="causa_H_acuerdos_reparatorios">
                            <option value="-1">Seleccione una opción</option>
                            @foreach ($tipoAcuerdo as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                            @endforeach      
                          </select>
                        </div>
                        <div class="col-sm-12 input-group obsReparatorios" style="display:none;">
                          <label for="causa_H_acuerdos_reparatorios_observaciones" class="input-group-text">Observaciones:</label>
                          <input type="text" class="form-control imp0 alfanum" name="causa_H_acuerdos_reparatorios_observaciones" 
                          id="causa_H_acuerdos_reparatorios_observaciones">
                        </div>                      
                        <div class="col-sm-12 input-group">

                          <label for="causa_H_monto_rep_daño" class="input-group-text">Monto de la reparación del daño:</label>
                          <input type="text" class="form-control imp0 monto" name="causa_H_monto_rep_daño" id="causa_H_monto_rep_daño">

                          <label for="causa_H_reparacion_del_daño_" class="input-group-text">Tipo de reparación del daño:</label>
                          <input type="text" class="form-control imp0 alfanum" name="causa_H_reparacion_del_daño_" id="causa_H_reparacion_del_daño_">
                        </div>
                        <div class="col-sm-12 input-group">
                          <label for="causa_H_temporalidad_salidad_alternas" class="input-group-text">Temporalidad de acuerdo reparatorio:</label>
                          <input type="text" class="form-control imp0 temporalidad" name="causa_H_temporalidad_salidad_alternas" id="causa_H_temporalidad_salidad_alternas" placeholder="xx días">
                          <button type="button" class="btn btn-primary"onclick="javascript:addAcuerdo(0)">
                            Agregar acuerdo
                          </button>
                        </div>                         
                        <input type="hidden" name="hdnAcuerdos0" id="hdnAcuerdos0">
                        <table id="acuerdos0" class="col-12 table table-striped table-hover table-responsive caption-top">
                            <caption></caption>    
                            <thead class="table-light">
                            <tr>
                              <th scope="col">Acuerdo reparatorio</th>
                              <th scope="col">Fecha de cumplimiento</th>
                              <th scope="col">Fecha de acuerdo</th>
                              <th scope="col">Tipo de acuerdos</th>
                              <th scope="col"></th>
                              <th scope="col">Monto de la reparación del daño</th>
                              <th scope="col">Tipo de reparación del daño</th>
                              <th scope="col">Temporalidad de acuerdo</th>                            
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
                  <h4>Suspensión condicional del proceso</h4>
                </div>
              </div>
              <div class="mb-3 col-12">
                <div class="accordion" id="accordionFiltrosSuspensiones_0">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsFiltrosSuspensiones_0">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                      data-bs-target="#panelsStayOpen-collapseOneSuspensiones_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneSuspensiones_0">
                        Listado de suspensiones condicionales
                      </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOneSuspensiones_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosSuspensiones_0">
                      <div class="accordion-body row">
                        --}}{{--
                        <div class="col-sm-12 input-group">

                          <label for="causa_H_suspension_condicional" class="input-group-text">Suspensión condicional del proceso:</label>
                          <select class="form-select imp0" name="causa_H_suspension_condicional" id="causa_H_suspension_condicional">
                            <option value="-1">Seleccione una opción</option>
                            @foreach ($SiNoNoI as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                            @endforeach
                          </select>
                        </div>
                        --}}{{--
                        <div class="col-sm-12 input-group">

                          <label for="causa_H_fecha_suspension" class="input-group-text">Fecha en que se dictó la suspensión condicional del proceso:</label>
                          <input type="date" class="form-control imp0" name="causa_H_fecha_suspension" id="causa_H_fecha_suspension">
                        </div>
                        <div class="col-sm-12 input-group">
                          <label for="causa_H_tipo_suspension" class="input-group-text">Tipo de condiciones impuestas durante la suspensión condicional del proceso:</label>
                          <select class="form-select imp0" name="causa_H_tipo_suspension" id="causa_H_tipo_suspension">
                            <option value="-1">Seleccione una opción</option>
                            @foreach ($tipoConImp as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                            @endforeach      
                          </select>
                        </div>
                        <div class="col-sm-12 input-group obsSuspension" style="display:none;">
                          <label for="causa_H_suspension_observaciones" class="input-group-text">Observaciones:</label>
                          <input type="text" class="form-control imp0 alfanum" 
                          name="causa_H_suspension_observaciones" id="causa_H_suspension_observaciones">
                        </div>                        
                        <div class="col-sm-12 input-group">

                          <label for="causa_H_fecha_cumpl" class="input-group-text">Fecha en que se cumplimentó la suspensión condicional del proceso:</label>
                          <input type="date" class="form-control imp0" name="causa_H_fecha_cumpl" id="causa_H_fecha_cumpl">

                        </div>
                        <div class="col-sm-12 input-group">
                          <label for="causa_H_revocacion_suspension" class="input-group-text">
                          Revocación de suspensión del proceso:</label>
                          <select class="form-select imp0" name="causa_H_revocacion_suspension" 
                            id="causa_H_revocacion_suspension">
                            <option value="-1">Seleccione una opción</option>
                            @foreach ($SiNo as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                            @endforeach
                          </select>
                          <label for="causa_H_motivo_revocacion" class="input-group-text">Motivo de revocación:</label>
                          <input type="text" class="form-control imp0 alfanum" 
                          name="causa_H_motivo_revocacion" id="causa_H_motivo_revocacion">                        
                        </div>
                        <div class="col-sm-12 input-group">
                          <label for="causa_H_reapertura" class="input-group-text">Reapertura del proceso:</label>
                          <select class="form-select imp0" name="causa_H_reapertura" id="causa_H_reapertura">
                            <option value="-1">Seleccione una opción</option>
                            @foreach ($SiNoNoI as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                            @endforeach         
                         </select>
                          <label for="causa_H_fecha_reapertura" class="input-group-text">Fecha de la reapertura del proceso:</label>
                          <input type="date" class="form-control imp0" name="causa_H_fecha_reapertura" 
                          id="causa_H_fecha_reapertura">
                        </div>                        
                        <div class="col-sm-12 input-group">
                          <button type="button" class="btn btn-primary"onclick="javascript:addSuspension(0)">
                            Agregar suspensión
                          </button>
                        </div>                                               
                        <input type="hidden" name="hdnSuspensiones0" id="hdnSuspensiones0">
                        <table id="suspensiones0" class="col-12 table table-striped table-hover table-responsive caption-top">
                            <caption></caption>    
                            <thead class="table-light">
                            <tr>
                              <th scope="col">Fecha en que se dictó la suspensión</th>
                              <th scope="col">Tipo de condiciones impuestas durante la suspensión</th>
                              <th scope="col"></th>
                              <th scope="col">Fecha en que se cumplimentó la suspensión</th>
                              <th scope="col">Revocación de suspensión del proceso</th>
                              <th scope="col">Motivo de revocación</th>
                              <th scope="col">Reapertura del proceso</th>
                              <th scope="col">Fecha de la reapertura del proceso</th>                            
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
            </div>
          </form>   
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="closeaddImputadoForm" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesAI_0').submit()">Guardar</button>
        </div>
      </div>
    </div>
  </div>
--}}
<div class="modal fade" id="eliminarReloadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarReloadModalLabel"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="eliminarReloadModalLabel">Eliminar permanentemente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Realmente deseas eliminar un registro anteriormente guardado?
        <input type="hidden" id="idR">
        <input type="hidden" id="idT">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:eliminarReload(0,0,true)">Eliminar</button>
      </div>
    </div>
  </div>
</div> 
<script type="text/javascript">
$(document).ready(function() {
    $('form').submit(function(event) {
      if (this.id.replace(/_([^_]+)$/, '')=="frmCausasPenalesAI_A") {
          if ($("#acuerdos"+this.id.split("_").pop()+" tbody tr").length<1)
          {
            event.preventDefault(); // Prevent the default form submission
            //respuesta=false; showtoast('Se debe agregar por lo menos un acuerdo reparatorio','danger_acuerdo');
            respuesta=false; showtoast('No hay ningún acuerdo reparatorio registrado para guardar.','info_acuerdo');
          }
        }
      if (this.id.replace(/_([^_]+)$/, '')=="frmCausasPenalesAI_S") {
          if ($("#suspensiones"+this.id.split("_").pop()+" tbody tr").length<1)
          {
            event.preventDefault(); // Prevent the default form submission
            //respuesta=false; showtoast('Se debe agregar por lo menos una suspensión condicional','danger_susp');
            respuesta=false; showtoast('No hay ninguna suspensión condicional registrada para guardar.','info_susp');
          }
        }              
      var conjunto = ['frmCausasPenalesAI_A','frmCausasPenalesAI_S'];
      if (!conjunto.includes(this.id.replace(/_([^_]+)$/, ''))) {
        event.preventDefault(); // Prevent the default form submission
        var respuesta=true;
        var campos=[];
        $("#"+this.id+" input:not(.noValidate):visible").each(function(){
          if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
          else{$(this).removeClass("border-3 border-danger");}
        });      

        $("#"+this.id+" select:not(.noValidate):visible").each(function(){
          if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
          else{$(this).removeClass("border-3 border-danger");}        
        });
        if (respuesta) {this.submit();}
        else
        {
          showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
        }
      }
    });
});

// function validateAddRow(formularioID)
// {
//   var respuesta=true;
//   var campos=[];
//   $("#"+formularioID+" input:not(.noValidate):visible").each(function(){
//     if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
//     else{$(this).removeClass("border-3 border-danger");}
//   });      

//   $("#"+formularioID+" select:not(.noValidate):visible").each(function(){
//     if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
//     else{$(this).removeClass("border-3 border-danger");}
//   });

//   if (!respuesta) {showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');}
//     return respuesta;
// }
  $("#frmCausasPenalesAI_A_0 #causa_H_acuerdo_reparatorio").change(function() {
    if (this.value==2) {$("#frmCausasPenalesAI_A_0 .fechaCump").show();}
    else
    {
      $("#frmCausasPenalesAI_A_0 .fechaCump").hide();
      $("#frmCausasPenalesAI_A_0 .fechaCump #causa_H_fecha_cumplimiento").val('');
    }
  });

  $("#frmCausasPenalesAI_A_0 #causa_H_acuerdos_reparatorios").change(function() {
    if (this.value==4) {$("#frmCausasPenalesAI_A_0 .obsReparatorios").show();}
    else
    {
      $("#frmCausasPenalesAI_A_0 .obsReparatorios").hide();
      $("#frmCausasPenalesAI_A_0 .obsReparatorios #causa_H_acuerdos_reparatorios_observaciones").val('');
    }
  });
      $("#frmCausasPenalesAI_S_0 #causa_H_tipo_suspension").change(function() {
    if (this.value==14) {$("#frmCausasPenalesAI_S_0 .obsSuspension").show();}
    else
    {
      $("#frmCausasPenalesAI_S_0 .obsSuspension").hide();
      $("#frmCausasPenalesAI_S_0 .obsSuspension #causa_H_suspension_observaciones").val('');
    }
  });
  $(".monto").mask("#,##0.00",{reverse: true});
  $(".solonum").mask("00");
  $(".temporalidadMA").mask('TTTT',
    {translation:  {'T': {pattern: /[0-9añosmeAÑOSME\,\s]/, recursive: true}}});
  $(".alfanum").mask('XXXX',
      {translation:  {'X': {pattern: /[0-9a-zA-ZñÑ\s]/, recursive: true}}});
  $(".temporalidad").mask('YYYY',
    {translation:  {'Y': {pattern: /[0-9díiasDÍIAS\s]/, recursive: true}}});      
  $(".nonum").mask('ZZZZ',
    {translation:  {'Z': {pattern: /[a-zA-Z\s]/, recursive: true}}});
  

  function addImputadoFormModal(Seccion)
  {
    if ($("#ddlImputados"+Seccion).val()>-1) {
     $("#frmCausasPenalesAI"+Seccion+"_0 #idImputado").val($("#ddlImputados"+Seccion).val());
     $("#addImputadoForm"+Seccion).show();
    }
    else{$("#addImputadoForm"+Seccion).hide();}   
  }
    function addAcuerdo(imputado)
    {      
      if ($("#causa_H_acuerdo_reparatorio.imp"+imputado).val()>-1 && 
          $("#causa_H_fecha_acuerdos_reparatorios.imp"+imputado).val().trim().length>0 && 
          $("#causa_H_acuerdos_reparatorios.imp"+imputado).val()>-1 &&
          $("#causa_H_monto_rep_daño.imp"+imputado).val().trim().length>0 && 
          //$("#causa_H_reparacion_del_daño_.imp"+imputado).val().trim().length>0 && 
          $("#causa_H_temporalidad_salidad_alternas.imp"+imputado).val().trim().length>0) {

        if($("#causa_H_acuerdo_reparatorio.imp"+imputado).val()>-1){
          $("#causa_H_acuerdo_reparatorio.imp"+imputado).removeClass("border-3 border-danger");
        }else{ $("#causa_H_acuerdo_reparatorio.imp"+imputado).addClass("border-3 border-danger"); }
        
        if($("#causa_H_fecha_acuerdos_reparatorios.imp"+imputado).val().trim().length>0){
          $("#causa_H_fecha_acuerdos_reparatorios.imp"+imputado).removeClass("border-3 border-danger");
        }else{ $("#causa_H_fecha_acuerdos_reparatorios.imp"+imputado).addClass("border-3 border-danger"); }
        
        if($("#causa_H_acuerdos_reparatorios.imp"+imputado).val()>-1){
          $("#causa_H_acuerdos_reparatorios.imp"+imputado).removeClass("border-3 border-danger");
        }else{ $("#causa_H_acuerdos_reparatorios.imp"+imputado).addClass("border-3 border-danger"); }
        
        if($("#causa_H_monto_rep_daño.imp"+imputado).val().trim().length>0){
          $("#causa_H_monto_rep_daño.imp"+imputado).removeClass("border-3 border-danger");
        }else{ $("#causa_H_monto_rep_daño.imp"+imputado).addClass("border-3 border-danger"); }
        
        // if($("#causa_H_reparacion_del_daño_.imp"+imputado).val().trim().length>0){
        //   $("#causa_H_reparacion_del_daño_.imp"+imputado).removeClass("border-3 border-danger");
        // }else{ $("#causa_H_reparacion_del_daño_.imp"+imputado).addClass("border-3 border-danger"); }
        
        if($("#causa_H_temporalidad_salidad_alternas.imp"+imputado).val().trim().length>0){
          $("#causa_H_temporalidad_salidad_alternas.imp"+imputado).removeClass("border-3 border-danger");
        }else{ $("#causa_H_temporalidad_salidad_alternas.imp"+imputado).addClass("border-3 border-danger"); }


        var jsonn="";        
        var idjson=0;
        if ($("#hdnAcuerdos"+imputado).val().length>0) {
         var json=JSON.parse("["+$("#hdnAcuerdos"+imputado).val().replace(/,+$/,"")+"]");
         idjson= json.sort(function(a, b) {
                   return parseFloat(b['id']) - parseFloat(a['id']);
                })[0]['id']+1;
        }
        
        jsonn='{"id":'+idjson+',"imputado":'+imputado+
        ',"acuerdo":"'+$("#causa_H_acuerdo_reparatorio.imp"+imputado).val()+'"'+
        ',"cumplimiento":"' +$("#causa_H_fecha_cumplimiento.imp"+imputado).val().trim()+'"'+
        ',"fecha_acuerdos":"' +$("#causa_H_fecha_acuerdos_reparatorios.imp"+imputado).val().trim()+'"'+
        ',"acuerdos":"' +$("#causa_H_acuerdos_reparatorios.imp"+imputado).val()+'"'+
        ',"acuerdos_obs":"' +$("#causa_H_acuerdos_reparatorios_observaciones.imp"+imputado).val().trim()+'"'+
        ',"monto":"' +$("#causa_H_monto_rep_daño.imp"+imputado).val().trim()+'"'+
        ',"reparacion":"' +$("#causa_H_reparacion_del_daño_.imp"+imputado).val().trim()+'"'+
        ',"temporalidad":"' +$("#causa_H_temporalidad_salidad_alternas.imp"+imputado).val().trim()+'"}';

        $("#hdnAcuerdos"+imputado).val($("#hdnAcuerdos"+imputado).val()+jsonn+",");        
        
        var newrow="<tr class='tr"+imputado+"_"+idjson+"'>"+
          "<td>"+$("#causa_H_acuerdo_reparatorio.imp"+imputado+" :selected").text()+"</td>"+
          "<td>"+$("#causa_H_fecha_cumplimiento.imp"+imputado).val().trim()+"</td>"+
          "<td>"+$("#causa_H_fecha_acuerdos_reparatorios.imp"+imputado).val().trim()+"</td>"+
          "<td>"+$("#causa_H_acuerdos_reparatorios.imp"+imputado+" :selected").text()+"</td>"+
          "<td>"+$("#causa_H_acuerdos_reparatorios_observaciones.imp"+imputado).val().trim()+"</td>"+
          "<td>"+$("#causa_H_monto_rep_daño.imp"+imputado).val().trim()+"</td>"+
          //"<td>"+$("#causa_H_reparacion_del_daño_.imp"+imputado).val().trim()+"</td>"+
          "<td>"+$("#causa_H_temporalidad_salidad_alternas.imp"+imputado).val().trim()+"</td>"+
          "<td><button type='button' title='Eliminar acuerdo' class='btn btn-danger' "+
          "onclick='eliminarAcuerdo(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";
            // causa_H_acuerdo_reparatorio
            //// causa_H_fecha_cumplimiento
            // causa_H_fecha_acuerdos_reparatorios
            // causa_H_acuerdos_reparatorios
            //// causa_H_acuerdos_reparatorios_observaciones
            // causa_H_monto_rep_daño
            // causa_H_reparacion_del_daño_
            // causa_H_temporalidad_salidad_alternas
        $("#acuerdos"+imputado+" tbody").append(newrow);  

        $("#causa_H_acuerdo_reparatorio.imp"+imputado).val(-1);
        $("#causa_H_fecha_cumplimiento.imp"+imputado).val('');
        $("#causa_H_fecha_acuerdos_reparatorios.imp"+imputado).val('');
        $("#causa_H_acuerdos_reparatorios.imp"+imputado).val(-1);
        $("#causa_H_acuerdos_reparatorios_observaciones.imp"+imputado).val('');
        $("#causa_H_monto_rep_daño.imp"+imputado).val('');
        $("#causa_H_reparacion_del_daño_.imp"+imputado).val('');
        $("#causa_H_temporalidad_salidad_alternas.imp"+imputado).val('');

        $("#frmCausasPenalesAI_A_"+imputado+" .fechaCump").hide();
        $("#frmCausasPenalesAI_A_"+imputado+" .obsReparatorios").hide();
      }
      else
      {
        showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
        if($("#causa_H_acuerdo_reparatorio.imp"+imputado).val()>-1){
          $("#causa_H_acuerdo_reparatorio.imp"+imputado).removeClass("border-3 border-danger");
        }else{ $("#causa_H_acuerdo_reparatorio.imp"+imputado).addClass("border-3 border-danger"); }
        
        if($("#causa_H_fecha_acuerdos_reparatorios.imp"+imputado).val().trim().length>0){
          $("#causa_H_fecha_acuerdos_reparatorios.imp"+imputado).removeClass("border-3 border-danger");
        }else{ $("#causa_H_fecha_acuerdos_reparatorios.imp"+imputado).addClass("border-3 border-danger"); }
        
        if($("#causa_H_acuerdos_reparatorios.imp"+imputado).val()>-1){
          $("#causa_H_acuerdos_reparatorios.imp"+imputado).removeClass("border-3 border-danger");
        }else{ $("#causa_H_acuerdos_reparatorios.imp"+imputado).addClass("border-3 border-danger"); }
        
        if($("#causa_H_monto_rep_daño.imp"+imputado).val().trim().length>0){
          $("#causa_H_monto_rep_daño.imp"+imputado).removeClass("border-3 border-danger");
        }else{ $("#causa_H_monto_rep_daño.imp"+imputado).addClass("border-3 border-danger"); }
        
        // if($("#causa_H_reparacion_del_daño_.imp"+imputado).val().trim().length>0){
        //   $("#causa_H_reparacion_del_daño_.imp"+imputado).removeClass("border-3 border-danger");
        // }else{ $("#causa_H_reparacion_del_daño_.imp"+imputado).addClass("border-3 border-danger"); }
        
        if($("#causa_H_temporalidad_salidad_alternas.imp"+imputado).val().trim().length>0){
          $("#causa_H_temporalidad_salidad_alternas.imp"+imputado).removeClass("border-3 border-danger");
        }else{ $("#causa_H_temporalidad_salidad_alternas.imp"+imputado).addClass("border-3 border-danger"); }
                    
          
      }
    }
    function eliminarAcuerdo(imputado,id,DB=0)
    {
      if (DB==1) {
        eliminarReload(id,'cpsaac');
      }
      else
      {
        var json=JSON.parse("["+$("#hdnAcuerdos"+imputado).val().replace(/,+$/,"")+"]");
        var filtro=json.filter(function(arr){return arr.id!=id});
        $("#hdnAcuerdos"+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
        window.event.target.parentElement.parentElement.remove();
                        
      }
    }
  function acumularCondicion(imputado)
  {   
    var id=-1;
    var valor='';
    id=$("#causa_H_tipo_suspension.imp"+imputado+" :selected").val();
    valor=$("#causa_H_tipo_suspension.imp"+imputado+" :selected").text();

    if (id>-1) {
      var badge="<span class='mx-1 badge rounded-pill bg-info text-dark' id='span_"+id+"'>"+valor+
      "<button type='button' class='btn-close' onclick='eliminarCondicionA(this,\""+imputado+"\")'></button></span>";
      
      var ids = JSON.parse("["+$("#hdnacumulado"+imputado).val()+"]");      
         if (!(ids.includes(parseInt(id)))) {
            ids.push(id.toString());
            $("#causa_H_tipo_suspension.imp"+imputado+" :selected").attr('disabled',true);
            $("#causa_H_tipo_suspension.imp"+imputado).val(-1);
            $("#hdnacumulado"+imputado).val(ids.toString());
            $("#txtacumulado"+imputado).append(badge);
        }
    }
  }
    function eliminarCondicionA(element,imputado)
    {   
      var ids = JSON.parse("["+$("#hdnacumulado"+imputado).val()+"]");
      var id=element.parentElement.id.slice(5);      
      if (ids.includes(parseInt(id))) {              
              var result=ids.filter(function(ele){  return ele != id; });
          $("#hdnacumulado"+imputado).val(result.toString());
          $("#causa_H_tipo_suspension.imp"+imputado+" option[value="+id+"]").attr('disabled',false);
          element.parentElement.remove();
      }
      //mostrarobservaciones(imputado);
      if ($("#frmCausasPenalesAI_S_"+imputado+" #causa_H_tipo_suspension").val()==14) {
        $("#frmCausasPenalesAI_S_"+imputado+" .obsSuspension").show();
      }
      else
      {
        if ($("#frmCausasPenalesAI_S_"+imputado+" #causa_H_tipo_suspension.imp"+imputado+" option[value=14]:disabled").length == 0) {
        $("#frmCausasPenalesAI_S_"+imputado+" .obsSuspension").hide();
        $("#frmCausasPenalesAI_S_"+imputado+" .obsSuspension #causa_H_suspension_observaciones").val('');
        }
        else
        {$("#frmCausasPenalesAI_S_"+imputado+" .obsSuspension").show();}        
      }
    }
    
    function addSuspension(imputado,ciclo=0)
    {
      if ($("#hdnacumulado"+imputado).val().length>0 && ciclo==0) {
        if ($("#causa_H_fecha_suspension.imp"+imputado).val().trim().length>0 && 
          //$("#causa_H_fecha_cumpl.imp"+imputado).val().trim().length>0 &&
          $("#causa_H_revocacion_suspension.imp"+imputado).val()>-1 &&
          $("#causa_H_reapertura.imp"+imputado).val()>-1) {

            if($("#causa_H_fecha_suspension.imp"+imputado).val().trim().length>0){
            $("#causa_H_fecha_suspension.imp"+imputado).removeClass("border-3 border-danger");
            }else{ $("#causa_H_fecha_suspension.imp"+imputado).addClass("border-3 border-danger"); }

            if($("#causa_H_revocacion_suspension.imp"+imputado).val()>-1){
            $("#causa_H_revocacion_suspension.imp"+imputado).removeClass("border-3 border-danger");
            }else{ $("#causa_H_revocacion_suspension.imp"+imputado).addClass("border-3 border-danger"); }

            if($("#causa_H_reapertura.imp"+imputado).val()>-1){
            $("#causa_H_reapertura.imp"+imputado).removeClass("border-3 border-danger");
            }else{ $("#causa_H_reapertura.imp"+imputado).addClass("border-3 border-danger"); }


            var seleccionado=$("#causa_H_tipo_suspension.imp"+imputado).val();
          var valores = $("#hdnacumulado"+imputado).val().split(",");
          $.each(valores, function(index, value) {
            $("#span_"+value+" .btn-close").click() 
            $("#causa_H_tipo_suspension.imp"+imputado).val(value);
            addSuspension(imputado,1);
          });
          $("#hdnacumulado"+imputado).val('');
          if (seleccionado < 0) {
            $("#causa_H_fecha_suspension.imp"+imputado).val('');
            $("#causa_H_suspension_observaciones.imp"+imputado).val('');
            $("#causa_H_fecha_cumpl.imp"+imputado).val('');   
            $("#causa_H_revocacion_suspension.imp"+imputado).val(-1);
            $("#causa_H_motivo_revocacion.imp"+imputado).val('');
            $("#causa_H_reapertura.imp"+imputado).val(-1);
            $("#causa_H_fecha_reapertura.imp"+imputado).val('');
          }
          $("#causa_H_tipo_suspension.imp"+imputado).val(seleccionado);
        }
        else
        {
            showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
            if($("#causa_H_fecha_suspension.imp"+imputado).val().trim().length>0){
              $("#causa_H_fecha_suspension.imp"+imputado).removeClass("border-3 border-danger");
            }else{ $("#causa_H_fecha_suspension.imp"+imputado).addClass("border-3 border-danger"); }

            if($("#causa_H_revocacion_suspension.imp"+imputado).val()>-1){
              $("#causa_H_revocacion_suspension.imp"+imputado).removeClass("border-3 border-danger");
            }else{ $("#causa_H_revocacion_suspension.imp"+imputado).addClass("border-3 border-danger"); }

            if($("#causa_H_reapertura.imp"+imputado).val()>-1){
              $("#causa_H_reapertura.imp"+imputado).removeClass("border-3 border-danger");
            }else{ $("#causa_H_reapertura.imp"+imputado).addClass("border-3 border-danger"); }
          }
      }
      else
      {
        if ($("#causa_H_tipo_suspension.imp"+imputado).val()>-1){
          $("#causa_H_tipo_suspension.imp"+imputado).removeClass("border-3 border-danger");
          if($("#causa_H_fecha_suspension.imp"+imputado).val().trim().length>0 && 
            //$("#causa_H_fecha_cumpl.imp"+imputado).val().trim().length>0 &&
            $("#causa_H_revocacion_suspension.imp"+imputado).val()>-1 &&
            $("#causa_H_reapertura.imp"+imputado).val()>-1) {

            if($("#causa_H_fecha_suspension.imp"+imputado).val().trim().length>0){
            $("#causa_H_fecha_suspension.imp"+imputado).removeClass("border-3 border-danger");
            }else{ $("#causa_H_fecha_suspension.imp"+imputado).addClass("border-3 border-danger"); }

            if($("#causa_H_revocacion_suspension.imp"+imputado).val()>-1){
            $("#causa_H_revocacion_suspension.imp"+imputado).removeClass("border-3 border-danger");
            }else{ $("#causa_H_revocacion_suspension.imp"+imputado).addClass("border-3 border-danger"); }

            if($("#causa_H_reapertura.imp"+imputado).val()>-1){
            $("#causa_H_reapertura.imp"+imputado).removeClass("border-3 border-danger");
            }else{ $("#causa_H_reapertura.imp"+imputado).addClass("border-3 border-danger"); }

            var jsonn="";        
            var idjson=0;
            if ($("#hdnSuspensiones"+imputado).val().length>0) {
             var json=JSON.parse("["+$("#hdnSuspensiones"+imputado).val().replace(/,+$/,"")+"]");
             idjson= json.sort(function(a, b) {
                       return parseFloat(b['id']) - parseFloat(a['id']);
                    })[0]['id']+1;
            }
            
            jsonn='{"id":'+idjson+',"imputado":'+imputado+
            ',"fecha_sus":"' +$("#causa_H_fecha_suspension.imp"+imputado).val().trim()+'"'+
            ',"tipo_sus":"' +$("#causa_H_tipo_suspension.imp"+imputado).val()+'"'+
            ',"sus_obs":"' +$("#causa_H_suspension_observaciones.imp"+imputado).val().trim()+'"'+
            ',"fecha_cumpl":"' +$("#causa_H_fecha_cumpl.imp"+imputado).val().trim()+'"'+
            ',"revocacion":"' +$("#causa_H_revocacion_suspension.imp"+imputado).val()+'"'+
            ',"motivo":"' +$("#causa_H_motivo_revocacion.imp"+imputado).val().trim()+'"'+
            ',"reapertura":"' +$("#causa_H_reapertura.imp"+imputado).val()+'"'+
            ',"fecha_reapertura":"' +$("#causa_H_fecha_reapertura.imp"+imputado).val().trim()+'"}';

            $("#hdnSuspensiones"+imputado).val($("#hdnSuspensiones"+imputado).val()+jsonn+",");        
            
            var newrow="<tr class='tr"+imputado+"_"+idjson+"'>"+
              "<td>"+$("#causa_H_fecha_suspension.imp"+imputado).val().trim()+"</td>"+
              "<td>"+$("#causa_H_tipo_suspension.imp"+imputado+" :selected").text()+"</td>"+
              "<td>"+$("#causa_H_suspension_observaciones.imp"+imputado).val().trim()+"</td>"+
              "<td>"+$("#causa_H_fecha_cumpl.imp"+imputado).val().trim()+"</td>"+
              "<td>"+$("#causa_H_revocacion_suspension.imp"+imputado+" :selected").text()+"</td>"+
              "<td>"+$("#causa_H_motivo_revocacion.imp"+imputado).val().trim()+"</td>"+
              "<td>"+$("#causa_H_reapertura.imp"+imputado+" :selected").text()+"</td>"+
              "<td>"+$("#causa_H_fecha_reapertura.imp"+imputado).val().trim()+"</td>"+
              "<td><button type='button' title='Eliminar suspensión' class='btn btn-danger' "+
              "onclick='eliminarSuspension(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";

            $("#suspensiones"+imputado+" tbody").append(newrow);  

            $("#causa_H_tipo_suspension.imp"+imputado).val(-1);
           if (ciclo==0) {
            $("#causa_H_fecha_suspension.imp"+imputado).val('');
            $("#causa_H_suspension_observaciones.imp"+imputado).val('');
            $("#causa_H_fecha_cumpl.imp"+imputado).val('');   
            $("#causa_H_revocacion_suspension.imp"+imputado).val(-1);
            $("#causa_H_motivo_revocacion.imp"+imputado).val('');
            $("#causa_H_reapertura.imp"+imputado).val(-1);
            $("#causa_H_fecha_reapertura.imp"+imputado).val('');
            $("#frmCausasPenalesAI_S_"+imputado+" .obsSuspension").hide();
           }
          }
          else
          {
            showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
            if($("#causa_H_fecha_suspension.imp"+imputado).val().trim().length>0){
              $("#causa_H_fecha_suspension.imp"+imputado).removeClass("border-3 border-danger");
            }else{ $("#causa_H_fecha_suspension.imp"+imputado).addClass("border-3 border-danger"); }

            if($("#causa_H_revocacion_suspension.imp"+imputado).val()>-1){
              $("#causa_H_revocacion_suspension.imp"+imputado).removeClass("border-3 border-danger");
            }else{ $("#causa_H_revocacion_suspension.imp"+imputado).addClass("border-3 border-danger"); }

            if($("#causa_H_reapertura.imp"+imputado).val()>-1){
              $("#causa_H_reapertura.imp"+imputado).removeClass("border-3 border-danger");
            }else{ $("#causa_H_reapertura.imp"+imputado).addClass("border-3 border-danger"); }
          }
        }
        else
        {
          showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');          
          $("#causa_H_tipo_suspension.imp"+imputado).addClass("border-3 border-danger");
        }
      }
    }
    function eliminarSuspension(imputado,id,DB=0)
    {
      if (DB==1) {
        eliminarReload(id,'cpsasc');
      }
      else
      {
        var json=JSON.parse("["+$("#hdnSuspensiones"+imputado).val().replace(/,+$/,"")+"]");
        var filtro=json.filter(function(arr){return arr.id!=id});
        $("#hdnSuspensiones"+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
        window.event.target.parentElement.parentElement.remove();
                        
      }
    }    
  function eliminarReload(idR,idT,modalOn=false)
  {
    if (modalOn) {    
      var params = new Object();
      params.idR = $("#idR").val();
      params.idT = $("#idT").val();
      params._token = '{{csrf_token()}}';
      params = JSON.stringify(params);
      $.ajax({      
          url: "{{Route('delDataCP')}}",
          type: "POST",
          data: params,
          contentType: "application/json; charset=utf-8",
          dataType: 'json',
          async: false,
          success: function (result) {
            if (result>0) {
              location.reload();
            }else{$("#eliminarReloadModal").modal('hide');}
          },
          error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert(textStatus + ": " + XMLHttpRequest.responseText);
            }
        });
      
    }
    else
    {
      $("#idR").val(idR);
      $("#idT").val(idT);
      $("#eliminarReloadModal").modal('show');}
  }  
</script>

