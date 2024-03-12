<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<div class="row causasInvestigacion">
 <form method='post' name="frmCausasPenalesEN" id="frmCausasPenalesEN" action="{{ route('saveCP') }}" enctype="multipart/form-data">
  <div class="row">
    @csrf   
    <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
    <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
    <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">      
    <div class="mb-4 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Actos de Investigación</h4>
      </div>
    </div> 
    <div class="mb-3 col-12">
      <div class="accordion" id="accordionFiltrosActos_0">
        <div class="accordion-item">
          <h2 class="accordion-header" id="panelsFiltrosActos_0">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" 
            data-bs-target="#panelsStayOpen-collapseOneActos_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneActos_0">
              Listado de actos de investigación
            </button>
          </h2>
          <div id="panelsStayOpen-collapseOneActos_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosActos_0">
            <div class="accordion-body row">
              <div class="col-sm-12 input-group">
                  <label for="causa_H_fecha_actos_de_inv" class="input-group-text">Fecha del acto:</label>
                  <input type="date" class="form-control act0" name="causa_H_fecha_actos_de_inv" id="causa_H_fecha_actos_de_inv" value="">
                  <input type="hidden" name="hdntpActos" id="hdntpActos" value='{{strtr($TipoActo,array(
                    "\u00c0" =>"À", "\u00c1" =>"Á", "\u00c2" =>"Â", "\u00c3" =>"Ã", "\u00c4" =>"Ä", "\u00c5" =>"Å",
                    "\u00c6" =>"Æ", "\u00c7" =>"Ç", "\u00c8" =>"È", "\u00c9" =>"É", "\u00ca" =>"Ê", "\u00cb" =>"Ë",
                    "\u00cc" =>"Ì", "\u00cd" =>"Í", "\u00ce" =>"Î", "\u00cf" =>"Ï", "\u00d1" =>"Ñ", "\u00d2" =>"Ò",
                    "\u00d3" =>"Ó", "\u00d4" =>"Ô", "\u00d5" =>"Õ", "\u00d6" =>"Ö", "\u00d8" =>"Ø", "\u00d9" =>"Ù",
                    "\u00da" =>"Ú", "\u00db" =>"Û", "\u00dc" =>"Ü", "\u00dd" =>"Ý", "\u00df" =>"ß", "\u00e0" =>"à",
                    "\u00e1" =>"á", "\u00e2" =>"â", "\u00e3" =>"ã", "\u00e4" =>"ä", "\u00e5" =>"å", "\u00e6" =>"æ",
                    "\u00e7" =>"ç", "\u00e8" =>"è", "\u00e9" =>"é", "\u00ea" =>"ê", "\u00eb" =>"ë", "\u00ec" =>"ì",
                    "\u00ed" =>"í", "\u00ee" =>"î", "\u00ef" =>"ï", "\u00f0" =>"ð", "\u00f1" =>"ñ", "\u00f2" =>"ò",
                    "\u00f3" =>"ó", "\u00f4" =>"ô", "\u00f5" =>"õ", "\u00f6" =>"ö", "\u00f8" =>"ø", "\u00f9" =>"ù",
                    "\u00fa" =>"ú", "\u00fb" =>"û", "\u00fc" =>"ü", "\u00fd" =>"ý", "\u00ff" =>"ÿ"))}}'>
                  <label for="causa_H_tipo_control_actos_de_inv" class="input-group-text">Tipo de control:</label>
                  <select class="form-select act0" name="causa_H_tipo_control_actos_de_inv" id="causa_H_tipo_control_actos_de_inv">
                    <option value="-1">Seleccione una opción</option>
                    @foreach ($TipoControl as $item)      
                      <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                    @endforeach      
                  </select>  
              </div>
              <div class="mb-3 col-sm-12 input-group">
                  <label for="causa_H_tipo_actos_de_inv" class="input-group-text">Tipo de acto:</label>
                  <select class="form-select act0" name="causa_H_tipo_actos_de_inv" id="causa_H_tipo_actos_de_inv">
                    <option value="-1">Seleccione una opción</option>
                    {{--@foreach ($TipoActo as $item)      
                      <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                    @endforeach--}}
                  </select>                 
                  <label for="causa_H_observaciones_actos_de_inv" class="input-group-text">Observaciones:</label>
                  <input type="text" class="form-control nonum act0 noValidate" name="causa_H_observaciones_actos_de_inv" 
                  id="causa_H_observaciones_actos_de_inv" maxlength="70" placeholder="">

                  <button type="button" class="btn btn-primary"onclick="javascript:addActo(0)">
                    Agregar acto
                  </button>  
              </div>
              <input type="hidden" name="hdnActos" id="hdnActos">
              <table id="actos0" class="col-12 table table-striped table-hover table-responsive caption-top">
                  <caption></caption>    
                  <thead class="table-light">
                  <tr>
                    <th scope="col">Fecha del acto</th>
                    <th scope="col">Tipo de control</th>
                    <th scope="col">Tipo de acto</th>
                    <th scope="col">Observaciones</th>
                    <th scope="col">Eliminar</th>
                  </tr>
                </thead>
                <tbody> 
                @if(isset($actosEV_DE))
                  @foreach($actosEV_DE as $acto)
                    <tr class="trV{{$acto->id}}">
                      <td>{{$acto->FECHA_ACTOS_DE_INV}}</td>
                      <td>{{$acto->Control}}</td>
                      <td>{{$acto->Valor}}</td>
                      <td>{{$acto->OBSERVACIONES_ACTOS_DE_INV}}</td>
                      <td></td>
                      {{--<button type="button" title="Eliminar acto" class="btn btn-danger" onclick="javascript:eliminarActo(0,{{$acto->id}},1)">&times;</button>--}}
                    </tr>
                  @endforeach
                @endif
                  @foreach($actosEV as $acto)
                    <tr class="trV{{$acto->id}}">
                      <td>{{$acto->FECHA_ACTOS_DE_INV}}</td>
                      <td>{{$acto->Control}}</td>
                      <td>{{$acto->Valor}}</td>
                      <td>{{$acto->OBSERVACIONES_ACTOS_DE_INV}}</td>
                    <td><button type="button" title="Eliminar acto" class="btn btn-danger" onclick="javascript:eliminarActo(0,{{$acto->id}},1)">&times;</button></td></tr>
                  @endforeach
                </tbody>
              </table>    
            </div>
          </div>
        </div>
      </div>              
    </div> 
    <div class="border-bottom py-2 mb-4 modal-footer">
      <button type="submit" class="btn btn-primary">Guardar</button>
    </div> 
  </div>
 </form>

@if($Ctrl!='e3ev')
  <div class="mb-4 mt-5 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Flagrancia</h4>
    </div>
  </div>
  <div class="mb-3 input-group {{count($listados['imputadosDDL_F'])<1?'d-none':''}}">
    <label for="ddlImputados_F" class="input-group-text">Agregar imputado:</label>        
    <select class="form-select" id="ddlImputados_F" name="ddlImputados_F" onchange="javascript:addImputadoFormModal('_F')">
      <option value="-1">Seleccione una opción</option>
      @foreach ($listados['imputadosDDL_F'] as $item)      
        <option value="{{$item->id}}" data-fechad="{{$item->FECHA_DETENCION}}"data-tipod="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>    
      @endforeach
    </select>
    <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal('_F')">Agregar persona imputada</button> -->
  </div> 
  <div id="addImputadoForm_F" style="display: none;">
    <form method='post' name="frmCausasPenalesEN_F_0" id="frmCausasPenalesEN_F_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
      <div class="row">
          @csrf  
        <input type="hidden" name="idImputadoEN" id="idImputadoEN" value="0">
        <input type="hidden" name="idImputado" id="idImputado" value="">
        <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
        <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
        <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
        <input type="hidden" name="frmSecc" id="frmSecc" value="F">
        <div class="mb-3 input-group">
          <label for="causa_H_fecha_detencion" class="input-group-text">Fecha de detención:</label>
          <input type="date" class="form-control" name="causa_H_fecha_detencion" id="causa_H_fecha_detencion" placeholder="">
          <label for="causa_H_detencion_legal" class="input-group-text">Tipo de detención:</label>
          <input type="text" class="form-control" name="causa_H_detencion_legal" id="causa_H_detencion_legal" placeholder="">
          <!-- <button type="button" class="btn btn-secondary" id="closeaddImputadoForm" data-bs-dismiss="modal">Cerrar</button> -->
          <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesEN_F_0').submit()">Guardar</button>
        </div>

      </div>        
    </form> 
  </div>
  @foreach($listados['imputadosCP_F'] as $imputado)
   <div class="accordion mb-2" id="accordionFiltrosEtapaInvF_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosEtapaInvF_{{$imputado->id}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneEtapaInvF_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneEtapaInvF_{{$imputado->id}}">
          Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneEtapaInvF_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosEtapaInvF_{{$imputado->id}}">      
        <form method='post' name="frmCausasPenalesEN_F_{{$imputado->id}}" id="frmCausasPenalesEN_F_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoEN" id="idImputadoEN" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="F">
             @include("causas_penales.etapa_investigacion.forms.flagrancia")
            <div class="border-top pt-2 modal-footer">
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div> 
          </div>
        </form>   
        
      </div>
    </div>
   </div>
  @endforeach

  <div class="mb-4 mt-5 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Mandamientos Judiciales</h4>
    </div>
  </div>
  <div class="mb-3 input-group {{count($listados['imputadosDDL_M'])<1?'d-none':''}}">
    <label for="ddlImputados_M" class="input-group-text">Agregar Imputado:</label>        
    <select class="form-select" id="ddlImputados_M" name="ddlImputados_M" onchange="javascript:addImputadoFormModal('_M')">
      <option value="-1">Seleccione una opción</option>
      @foreach ($listados['imputadosDDL_M'] as $item)      
        <option value="{{$item->id}}" data-fechad="{{$item->FECHA_DETENCION}}"data-tipod="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>    
      @endforeach
    </select>
    <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal('_M')">Agregar persona imputada</button> -->
  </div> 
  <div id="addImputadoForm_M" style="display: none;">
    <form method='post' name="frmCausasPenalesEN_M_0" id="frmCausasPenalesEN_M_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
      <div class="row">
          @csrf  
        <input type="hidden" name="idImputadoEN" id="idImputadoEN" value="0">
        <input type="hidden" name="idImputado" id="idImputado" value="">
        <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
        <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
        <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
        <input type="hidden" name="frmSecc" id="frmSecc" value="M">
        <div class="input-group">
          <label for="causa_H_tipo_mandamiento" class="input-group-text">Tipo de mandamiento:</label>
          <select class="form-select mand0 noValidate" name="causa_H_tipo_mandamiento" id="causa_H_tipo_mandamiento">
            <option value="-1">Seleccione una opción</option>
            @foreach ($TipoMJ as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
            @endforeach 
          </select>
          <button type="button" title="Acumular mandamiento" class="btn btn-outline-success" onclick="javascript:acumularMandamiento(0)">
          Acumular mandamiento</button>
        </div>
        <div>        
          <input type="hidden" id="hdnacumulado0" name="hdnacumulado0">
          <div class="alert alert-dark mb-0" id="txtacumulado0"></div>                          
        </div>
        <div class="input-group"> 
          <label for="causa_H_solicitud_de_mandamiento_judicial" class="input-group-text">Fecha de solicitud del mandamiento judicial:</label>
          <input type="date" class="form-control mand0" name="causa_H_solicitud_de_mandamiento_judicial" 
          id="causa_H_solicitud_de_mandamiento_judicial">  
                           
          <label for="causa_H_estatus_mandamiento" class="input-group-text">Estatus de mandamiento judicial:</label>
          <select class="form-select mand0" name="causa_H_estatus_mandamiento" id="causa_H_estatus_mandamiento">
            <option value="-1">Seleccione una opción</option>
            @foreach ($estatusMJ as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
            @endforeach               
          </select>
          <label for="causa_H_fecha_libera" class="input-group-text d-none">Fecha de libramiento del mandamiento:</label>
          <input type="date" class="form-control mand0 d-none" name="causa_H_fecha_libera" id="causa_H_fecha_libera">
        </div>
        <div class="input-group">          
          <label for="causa_H_fecha_mandamiento" class="input-group-text">Fecha de cumplimiento del mandamiento:</label>
          <input type="date" class="form-control mand0 noValidate" name="causa_H_fecha_mandamiento" id="causa_H_fecha_mandamiento" placeholder="">
          <button type="button" class="btn btn-primary" onclick="javascript:addMandamiento(0)">Agregar mandamiento</button>
        </div>
        <input type="hidden" name="hdnMandamientos0" id="hdnMandamientos0">
        <table id="mandamientos0" class="col-12 table table-striped table-hover table-responsive caption-top">
            <caption></caption>    
            <thead class="table-light">
            <tr>                            
              <th scope="col">Tipo de mandamiento</th>
              <th scope="col">Fecha de solicitud del mandamiento judicial</th>
              <th scope="col">Estatus de mandamiento judicial</th>
              <!-- <th scope="col">Fecha de libramiento del mandamiento</th> -->
              <th scope="col">Fecha de cumplimiento del mandamiento</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody> 
          </tbody>
        </table>    
        <div class="border-bottom py-2 mb-4 modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div> 
      </div>        
    </form> 
  </div>
  @foreach($listados['imputadosCP_M'] as $imputado)
   <div class="accordion mb-2" id="accordionFiltrosEtapaInvM_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosEtapaInvM_{{$imputado->id}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneEtapaInvM_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneEtapaInvM_{{$imputado->id}}">
          Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneEtapaInvM_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosEtapaInvM_{{$imputado->id}}">      
        <form method='post' name="frmCausasPenalesEN_M_{{$imputado->id}}" id="frmCausasPenalesEN_M_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoEN" id="idImputadoEN" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="M">
             @include("causas_penales.etapa_investigacion.forms.mandamientos")
            <div class="border-top pt-2 modal-footer">
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div> 
          </div>
        </form>   
        
      </div>
    </div>
   </div>
  @endforeach

  <div class="mb-4 mt-5 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Audiencia de garantías</h4>
    </div>
  </div>
  <div class="mb-3 input-group {{count($listados['imputadosDDL_A'])<1?'d-none':''}}">
    <label for="ddlImputados_A" class="input-group-text">Agregar Imputado:</label>        
    <select class="form-select" id="ddlImputados_A" name="ddlImputados_A" onchange="javascript:addImputadoFormModal('_A')">
      <option value="-1">Seleccione una opción</option>
      @foreach ($listados['imputadosDDL_A'] as $item)      
        <option value="{{$item->id}}" data-fechad="{{$item->FECHA_DETENCION}}"data-tipod="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>    
      @endforeach
    </select>
    <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal('_A')">Agregar persona imputada</button> -->
  </div> 
  <div id="addImputadoForm_A" style="display: none;">
    <form method='post' name="frmCausasPenalesEN_A_0" id="frmCausasPenalesEN_A_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
      <div class="row">
          @csrf  
        <input type="hidden" name="idImputadoEN" id="idImputadoEN" value="0">
        <input type="hidden" name="idImputado" id="idImputado" value="">
        <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
        <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
        <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
        <input type="hidden" name="frmSecc" id="frmSecc" value="A">
          <div class="input-group">
            <label for="causa_H_audiencia_de_garantias" class="input-group-text">Audiencia de garantías:</label>
            <input type="text" class="form-control nonum" name="causa_H_audiencia_de_garantias" id="causa_H_audiencia_de_garantias" maxlength="70" placeholder="">
          </div>
          <div class="input-group">
              <label for="causa_H_promovida_por" class="input-group-text">Audiencia promovida por:</label>
              <select class="form-select" name="causa_H_promovida_por" id="causa_H_promovida_por">
                <option value="-1">Seleccione una opción</option>
                @foreach ($audineciaPx as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach 
             </select>
          </div>
          <div class="input-group">
            <label for="causa_H_resultado_audiencia_de_garantias" class="input-group-text">Resultado de la audiencia:</label>
            <input type="text" class="form-control nonum" name="causa_H_resultado_audiencia_de_garantias" id="causa_H_resultado_audiencia_de_garantias" placeholder="">
          </div>
          <div class="mb-3 input-group">
            <label for="causa_H_fecha_cita" class="input-group-text">Fecha para la cita para imputación:</label>
            <input type="date" class="form-control" name="causa_H_fecha_cita" id="causa_H_fecha_cita" value="">
          <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesEN_A_0').submit()">Guardar</button>
          </div>          


      </div>        
    </form> 
  </div>
  @foreach($listados['imputadosCP_A'] as $imputado)
   <div class="accordion mb-2" id="accordionFiltrosEtapaInvA_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosEtapaInvA_{{$imputado->id}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneEtapaInvA_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneEtapaInvA_{{$imputado->id}}">
          Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneEtapaInvA_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosEtapaInvA_{{$imputado->id}}">      
        <form method='post' name="frmCausasPenalesEN_A_{{$imputado->id}}" id="frmCausasPenalesEN_A_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoEN" id="idImputadoEN" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="A">
             @include("causas_penales.etapa_investigacion.forms.audiencia")
            <div class="border-top pt-2 modal-footer">
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div> 
          </div>
        </form>   
        
      </div>
    </div>
   </div>
  @endforeach  

  <div class="mb-4 mt-5 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Caso Urgente</h4>
    </div>
  </div>
  <div class="mb-3 input-group {{count($listados['imputadosDDL_C'])<1?'d-none':''}}">
    <label for="ddlImputados_C" class="input-group-text">Agregar Imputado:</label>        
    <select class="form-select" id="ddlImputados_C" name="ddlImputados_C" onchange="javascript:addImputadoFormModal('_C')">
      <option value="-1">Seleccione una opción</option>
      @foreach ($listados['imputadosDDL_C'] as $item)      
        <option value="{{$item->id}}" data-fechad="{{$item->FECHA_DETENCION}}"data-tipod="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>    
      @endforeach
    </select>
    <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal('_C')">Agregar persona imputada</button> -->
  </div> 
  <div id="addImputadoForm_C" style="display: none;">
    <form method='post' name="frmCausasPenalesEN_C_0" id="frmCausasPenalesEN_C_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
      <div class="row">
          @csrf  
        <input type="hidden" name="idImputadoEN" id="idImputadoEN" value="0">
        <input type="hidden" name="idImputado" id="idImputado" value="">
        <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
        <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
        <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
        <input type="hidden" name="frmSecc" id="frmSecc" value="C">
        <div class="input-group">
          <label for="causa_H_caso_urgente_fecha_libramiento" class="input-group-text">Fecha de libramiento:</label>
          <input type="date" class="form-control" name="causa_H_caso_urgente_fecha_libramiento" id="causa_H_caso_urgente_fecha_libramiento">
            <label for="causa_H_caso_urgente_estatus" class="input-group-text">Tipo de mandamiento:</label>
            <select class="form-select" name="causa_H_caso_urgente_estatus" id="causa_H_caso_urgente_estatus">
              <option value="-1">Seleccione una opción</option>
              @foreach ($EstatusCU as $item)      
                <option value="{{ $item->id }}">
                  {{$item->Valor}}</option>      
              @endforeach 
           </select>
        </div>
        <div class="mb-3 input-group">
          <label for="causa_H_caso_urgente_fecha_cumplimiento" class="input-group-text">Fecha de cumplimiento:</label>
          <input type="date" class="form-control" name="causa_H_caso_urgente_fecha_cumplimiento" id="causa_H_caso_urgente_fecha_cumplimiento" >

          <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesEN_C_0').submit()">Guardar</button>
        </div>

      </div>        
    </form> 
  </div>
  @foreach($listados['imputadosCP_C'] as $imputado)
   <div class="accordion mb-2" id="accordionFiltrosEtapaInvC_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosEtapaInvC_{{$imputado->id}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneEtapaInvC_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneEtapaInvC_{{$imputado->id}}">
          Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneEtapaInvC_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosEtapaInvC_{{$imputado->id}}">      
        <form method='post' name="frmCausasPenalesEN_C_{{$imputado->id}}" id="frmCausasPenalesEN_C_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoEN" id="idImputadoEN" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="C">
             @include("causas_penales.etapa_investigacion.forms.casoUrgente")
            <div class="border-top pt-2 modal-footer">
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div> 
          </div>
        </form>   
        
      </div>
    </div>
   </div>
  @endforeach
@endif  
{{--
     <div class="mb-4 mt-5 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Imputados</h4>
      </div>
    </div>
  <div class="mb-3 input-group">
    <label for="ddlImputados" class="input-group-text">Imputado:</label>        
    <select class="form-select" id="ddlImputados" name="ddlImputados">
      <option value="-1">Seleccione una opción</option>
      @foreach ($listados['imputadosDDL'] as $item)      
        <option value="{{$item->id}}" data-fechad="{{$item->FECHA_DETENCION}}"data-tipod="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
      @endforeach
    </select>
    <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button>
  </div> 
    
  @foreach($listados['imputadosCP'] as $imputado)
   <div class="accordion mb-2" id="accordionFiltrosEtapaInv_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosEtapaInv_{{$imputado->id}}">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneEtapaInv_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneEtapaInv_{{$imputado->id}}">
          Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneEtapaInv_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosEtapaInv_{{$imputado->id}}">      
        <form method='post' name="frmCausasPenalesEN_{{$imputado->id}}" id="frmCausasPenalesEN_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoEN" id="idImputadoEN" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
             @include("causas_penales.etapa_investigacion.form")
            <div class="border-top pt-2 modal-footer">
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div> 
          </div>
        </form>   
        
      </div>
    </div>
   </div>
  @endforeach
--}}
    <div class="mb-4 mt-5 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Medidas de protección</h4>
      </div>
    </div>
  <div class="mb-3 input-group">
    <label for="ddlVictimas" class="input-group-text">Victima:</label>        
    <select class="form-select" id="ddlVictimas" name="ddlVictimas">
      <option value="-1">Seleccione una opción</option>
      @foreach ($listados['victimasDDL'] as $item)      
        <option value="{{$item->id}}">{{$item->Valor}}</option>      
      @endforeach
    </select>
    <button type="button" title="Agregar víctima" class="btn btn-outline-primary" onclick="javascript:addVictimaFormModal()">Agregar víctima</button>
  </div>   
  @foreach($listados['victimasCP'] as $victima)
   <div class="accordion mb-2" id="accordionFiltrosEtapaInvV_{{$victima->idcp_ev_victimas}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosEtapaInvV_{{$victima->idcp_ev_victimas}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneEtapaInvV_{{$victima->idcp_ev_victimas}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneEtapaInvV_{{$victima->idcp_ev_victimas}}">
          Persona víctima {{$victima->id}}: {{$victima->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneEtapaInvV_{{$victima->idcp_ev_victimas}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosEtapaInvV_{{$victima->idcp_ev_victimas}}">      
        <form method='post' name="frmCausasPenalesENv_{{$victima->idcp_ev_victimas}}" id="frmCausasPenalesENv_{{$victima->idcp_ev_victimas}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idVictimaEN" id="idVictimaEN" value="{{$victima->idcp_ev_victimas}}">
            <input type="hidden" name="idVictima" id="idVictima" value="{{$victima->id}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <!-- <div class="mb-4 col-12 pestanaBase">
              <div class="pestanaTop">
                <h4>Medidas de protección</h4>
              </div>
            </div>  -->
            <div class="mb-3 col-12">
              <div class="accordion" id="accordionFiltrosMedidas_{{$victima->idcp_ev_victimas}}">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsFiltrosMedidas_{{$victima->idcp_ev_victimas}}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#panelsStayOpen-collapseOneMedidas_{{$victima->idcp_ev_victimas}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneMedidas_{{$victima->idcp_ev_victimas}}">
                      Listado de medidas de protección
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseOneMedidas_{{$victima->idcp_ev_victimas}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosMedidas_{{$victima->idcp_ev_victimas}}">
                    <div class="accordion-body row">
                      <div class="input-group">
                        <label for="causa_H_tipo_de_medida" class="input-group-text">Tipo de medida:</label>
                        <select class="form-select mdd{{$victima->idcp_ev_victimas}}" name="causa_H_tipo_de_medida" id="causa_H_tipo_de_medida">
                        <option value="-1">Seleccione una opción</option>
                            @foreach ($TMRestriccion as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                            @endforeach 
                        </select>
                        <label for="causa_H_temporalidad_de_la_medida" class="input-group-text">Temporalidad de la medida:</label>
                        <input type="text" class="form-control alfanum mdd{{$victima->idcp_ev_victimas}}" name="causa_H_temporalidad_de_la_medida" 
                        id="causa_H_temporalidad_de_la_medida">                        
                        {{--
                          <select class="form-select mdd{{$victima->idcp_ev_victimas}}" name="causa_H_temporalidad_de_la_medida" 
                            id="causa_H_temporalidad_de_la_medida">
                            <option value="-1">Seleccione una opción</option>
                            @for ($i=1;$i<4;$i++)      
                              <option value="{{ $i }}">{{$i>1? $i.' MESES':$i.' MES'}}</option>      
                            @endfor
                          </select>
                        --}}
                      </div><div class="mb-3 col-sm-12 input-group">
                        <label for="causa_H_medida_impuesta_por" class="input-group-text">
                        Impuesta por:</label>
                        <select class="form-select mdd{{$victima->idcp_ev_victimas}}" name="causa_H_medida_impuesta_por" id="causa_H_medida_impuesta_por">
                          @if($Ctrl!='e3ev')<option value="-1">Seleccione una opción</option> @endif
                            @foreach ($impuestaPor as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                            @endforeach 
                        </select>
                        <button type="button" class="btn btn-primary"onclick="javascript:addMedida({{$victima->idcp_ev_victimas}})">
                          Agregar medida
                        </button>  
                      </div>
                      <input type="hidden" name="hdnMedidas{{$victima->idcp_ev_victimas}}" id="hdnMedidas{{$victima->idcp_ev_victimas}}">
                      <table id="medidas{{$victima->idcp_ev_victimas}}" class="col-12 table table-striped table-hover table-responsive caption-top">
                          <caption></caption>    
                          <thead class="table-light">
                          <tr>                            
                            <th scope="col">Tipo de medida</th>
                            <th scope="col">Temporalidad de la medida</th>
                            <th scope="col">Impuesta por</th>
                            <th scope="col">Eliminar</th>
                          </tr>
                        </thead>
                        <tbody> 
                        @if(isset($medidas_DE[$victima->id]))
                         @foreach ($medidas_DE[$victima->id] as $medida)                         
                          <tr class="tr{{$victima->id}}_{{$medida->id}}">
                            <td>{{$medida->TIPOMEDIDA}}</td>
                            {{--<td>{{$medida->TEMPORALIDAD_DE_LA_MEDIDA>1? $medida->TEMPORALIDAD_DE_LA_MEDIDA.' MESES':
                              $medida->TEMPORALIDAD_DE_LA_MEDIDA.' MES'}}</td>--}}
                            <td>{{$medida->TEMPORALIDAD_DE_LA_MEDIDA}}</td>
                            <td>{{$medida->IMPUESTAPOR}}</td>
                            <td>
                              {{--<button type="button" title="Eliminar medida" class="btn btn-danger" 
                              onclick="eliminarMedida('{{$victima->id}}','{{$medida->id}}',1)">×</button>--}}
                            </td>
                          </tr>
                         @endforeach
                        @endif
                         @foreach ($medidas[$victima->id] as $medida)                         
                          <tr class="tr{{$victima->id}}_{{$medida->id}}">
                            <td>{{$medida->TIPOMEDIDA}}</td>
                            {{--<td>{{$medida->TEMPORALIDAD_DE_LA_MEDIDA>1? $medida->TEMPORALIDAD_DE_LA_MEDIDA.' MESES':
                              $medida->TEMPORALIDAD_DE_LA_MEDIDA.' MES'}}</td>--}}
                            <td>{{$medida->TEMPORALIDAD_DE_LA_MEDIDA}}</td>
                            <td>{{$medida->IMPUESTAPOR}}</td>
                            <td>
                              <button type="button" title="Eliminar medida" class="btn btn-danger" 
                              onclick="eliminarMedida('{{$victima->id}}','{{$medida->id}}',1)">×</button>
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
  @endforeach  
</div>
{{--
  <div class="modal fade" id="addImputadoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addImputadoFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addImputadoFormLabel">Datos de investigación inicial del imputado</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method='post' name="frmCausasPenalesEN_0" id="frmCausasPenalesEN_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
            <div class="row">
                @csrf  
              <input type="hidden" name="idImputadoEN" id="idImputadoEN" value="0">
              <input type="hidden" name="idImputado" id="idImputado" value="">
              <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
              <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
              <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
               @include("causas_penales.etapa_investigacion.formModal")
            </div>        
          </form>   
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="closeaddImputadoForm" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesEN_0').submit()">Guardar</button>
        </div>
      </div>
    </div>
  </div>
--}}

<div class="modal fade" id="addVictimaForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addVictimaFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addVictimaFormLabel">Datos de investigación inicial de la víctima</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method='post' name="frmCausasPenalesENv_0" id="frmCausasPenalesENv_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
          <div class="row">
              @csrf  
            <input type="hidden" name="idVictimaEN" id="idVictimaEN" value="0">
            <input type="hidden" name="idVictima" id="idVictima" value="">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <div class="mb-4 col-12 pestanaBase">
              <div class="pestanaTop">
                <h4>Medidas de protección</h4>
              </div>
            </div> 
            <div class="mb-3 col-12">
              <div class="accordion" id="accordionFiltrosMedidas_0">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsFiltrosMedidas_0">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#panelsStayOpen-collapseOneMedidas_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneMedidas_0">
                      Listado de medidas de protección
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseOneMedidas_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosMedidas_0">
                    <div class="accordion-body row">
                      <div class="input-group">
                        <label for="causa_H_tipo_de_medida" class="input-group-text">Tipo de medida:</label>
                        <select class="form-select mdd0" name="causa_H_tipo_de_medida" id="causa_H_tipo_de_medida">
                        <option value="-1">Seleccione una opción</option>
                            @foreach ($TMRestriccion as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                            @endforeach 
                        </select>
                        <label for="causa_H_temporalidad_de_la_medida" class="input-group-text">
                        Temporalidad de la medida:</label>
                        <input type="text" class="form-control alfanum mdd0" name="causa_H_temporalidad_de_la_medida" 
                        id="causa_H_temporalidad_de_la_medida">
                        {{--
                          <select class="form-select mdd0" name="causa_H_temporalidad_de_la_medida" id="causa_H_temporalidad_de_la_medida">
                            <option value="-1">Seleccione una opción</option>
                            @for ($i=1;$i<4;$i++)      
                              <option value="{{ $i }}">{{$i>1? $i.' MESES':$i.' MES'}}</option>      
                            @endfor
                          </select>
                        --}}       
                        </div><div class="mb-3 col-sm-12 input-group">                 
                        <label for="causa_H_medida_impuesta_por" class="input-group-text">
                        Impuesta por:</label>
                        <select class="form-select mdd0" name="causa_H_medida_impuesta_por" id="causa_H_medida_impuesta_por">                          
                          @if($Ctrl!='e3ev')<option value="-1">Seleccione una opción</option> @endif
                            @foreach ($impuestaPor as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                            @endforeach 
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
                            <th scope="col">Tipo de medida</th>
                            <th scope="col">Temporalidad de la medida</th>
                            <th scope="col">Impuesta por</th>
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
        <button type="button" class="btn btn-secondary" id="closeaddVictimaForm" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesENv_0').submit()">Guardar</button>
      </div>
    </div>
  </div>
</div>

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
      if (this.id.replace(/_([^_]+)$/, '')=="frmCausasPenalesEN_M") {
          if ($("#mandamientos"+this.id.split("_").pop()+" tbody tr").length<1)
          {
            event.preventDefault(); // Prevent the default form submission
            //respuesta=false; showtoast('Se debe agregar por lo menos un mandamiento judicial','info_mand');
            respuesta=false; showtoast('No hay ningún mandamiento judicial registrado para guardar.','info_mand');
          }
        }
      if (this.id.replace(/_([^_]+)$/, '')=="frmCausasPenalesEN") {
          if ($("#actos0 tbody tr").length<1)
          {
            event.preventDefault(); // Prevent the default form submission
            // respuesta=false; showtoast('Se debe agregar por lo menos un acto de investigación','danger_acto');
            respuesta=false; showtoast('No hay ningún acto de investigación registrado para guardar.','info_acto');
          }
        }
      if (this.id.replace(/_([^_]+)$/, '')=="frmCausasPenalesENv") {
          if ($("#medidas"+this.id.split("_").pop()+" tbody tr").length<1)
          {
            event.preventDefault(); // Prevent the default form submission
            //respuesta=false; showtoast('Se debe agregar por lo menos una medida de protección','danger_med');
            respuesta=false; showtoast('No hay ninguna medida de protección registrada para guardar.','info_med');            
          }
        }        
      var conjunto = ['frmCausasPenalesEN','frmCausasPenalesENv','frmCausasPenalesEN_M'];
      //var conjunto = ['frmCausasPenalesEN','frmCausasPenalesENv'];
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

function validateAddRow(formularioID)
{
  var respuesta=true;
  var campos=[];
  $("#"+formularioID+" input:not(.noValidate):visible").each(function(){
    if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
    else{$(this).removeClass("border-3 border-danger");}
  });      

  $("#"+formularioID+" select:not(.noValidate):visible").each(function(){
    if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
    else{$(this).removeClass("border-3 border-danger");}
  });

  if (formularioID.replace(/_([^_]+)$/, '')=="frmCausasPenalesEN_M") {
    var hdnacumulado=$("#hdnacumulado"+formularioID.split("_").pop());
    var tipoMand=$("#causa_H_tipo_mandamiento.mand"+formularioID.split("_").pop());
    if (hdnacumulado.val().length<1 && tipoMand.val()<0) {
      respuesta=false;tipoMand.addClass("border-3 border-danger");campos.push("causa_H_tipo_mandamiento");
      $("#txtacumulado"+formularioID.split("_").pop()).addClass("border-3 border-danger");
    }
    else{tipoMand.removeClass("border-3 border-danger");
      $("#txtacumulado"+formularioID.split("_").pop()).removeClass("border-3 border-danger");}

  }

  if (!respuesta) {showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');}
    return respuesta;
}

$(".temporalidad").mask('YYYY',
    {translation:  {'Y': {pattern: /[0-9díiasDÍIAS\s]/, recursive: true}}});      
  $(".nonum").mask('ZZZZ',
    {translation:  {'Z': {pattern: /[a-zA-Z\s]/, recursive: true}}});

$("#causa_H_tipo_control_actos_de_inv").change(function(){
    $("#causa_H_tipo_actos_de_inv").html('<option value="-1">Seleccione una opción</option>');
  if(this.value==1)
  {
    var data=JSON.parse($("#hdntpActos").val()).filter(function(arr){return arr.id<8});
    data.forEach(obj => {        
        $("#causa_H_tipo_actos_de_inv").append('<option value="'+obj.id+'">'+obj.Valor+'</option>'); 
    });   
  }
  if(this.value==2)
  {
    var data=JSON.parse($("#hdntpActos").val()).filter(function(arr){return arr.id>7});
    data.forEach(obj => {        
        $("#causa_H_tipo_actos_de_inv").append('<option value="'+obj.id+'">'+obj.Valor+'</option>'); 
    });   
  }    
});


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
  
  function addImputadoFormModal(Seccion)
  { @if($CP_EV>=0)
      if (Seccion=='_F') {
        $("#frmCausasPenalesEN"+Seccion+"_0 #causa_H_fecha_detencion").val('');
        $("#frmCausasPenalesEN"+Seccion+"_0 #causa_H_detencion_legal").val('');
        if ($("#ddlImputados"+Seccion).val()>-1) {
         $("#frmCausasPenalesEN"+Seccion+"_0 #idImputado").val($("#ddlImputados"+Seccion).val());
         $("#frmCausasPenalesEN"+Seccion+"_0 #causa_H_fecha_detencion").val($("#ddlImputados"+Seccion+" :selected").data().fechad);
         $("#frmCausasPenalesEN"+Seccion+"_0 #causa_H_detencion_legal").val($("#ddlImputados"+Seccion+" :selected").data().tipod);
         $("#addImputadoForm"+Seccion).show();
        }
        else{$("#addImputadoForm"+Seccion).hide();}
      }
      if (Seccion=='_M') {
        if ($("#ddlImputados"+Seccion).val()>-1) {
         $("#frmCausasPenalesEN"+Seccion+"_0 #idImputado").val($("#ddlImputados"+Seccion).val());
         $("#addImputadoForm"+Seccion).show();
        }
        else{$("#addImputadoForm"+Seccion).hide();}
      }
      if (Seccion=='_A') {
        if ($("#ddlImputados"+Seccion).val()>-1) {
         $("#frmCausasPenalesEN"+Seccion+"_0 #idImputado").val($("#ddlImputados"+Seccion).val());
         $("#addImputadoForm"+Seccion).show();
        }
        else{$("#addImputadoForm"+Seccion).hide();}
      }
      if (Seccion=='_C') {
        if ($("#ddlImputados"+Seccion).val()>-1) {
         $("#frmCausasPenalesEN"+Seccion+"_0 #idImputado").val($("#ddlImputados"+Seccion).val());
         $("#addImputadoForm"+Seccion).show();
        }
        else{$("#addImputadoForm"+Seccion).hide();}
      }
    @else
      showtoast('<h6>&times; Es necesario capturar datos de la "investigación inicial" antes de registrar datos de algún imputado.','danger');
    @endif
  }
    function addVictimaFormModal()
  { @if($CP_EV>=0)
      if ($("#ddlVictimas").val()>-1) {
       $("#frmCausasPenalesENv_0 #idVictima").val($("#ddlVictimas").val());
       $("#addVictimaForm").modal("show");
      }
    @else
      showtoast('<h6>&times; Es necesario capturar datos de la "investigación inicial" antes de registrar datos de alguna vícitma.','danger');
    @endif
  }

    function addActoConSin(ConSin,imputado)
  {
    if ($("#causa_H_tipos_de_actos_"+ConSin+"_control.act"+ConSin+imputado).val()>-1) {
      var jsonn="";        
      var idjson=0;
      if ($("#hdnActos_"+ConSin+imputado).val().length>0) {
       var json=JSON.parse("["+$("#hdnActos_"+ConSin+imputado).val().replace(/,+$/,"")+"]");
       idjson= json.sort(function(a, b) {
                 return parseFloat(b['id']) - parseFloat(a['id']);
              })[0]['id']+1;
      }
      
      jsonn='{"id":'+idjson+',"imputado":'+imputado+',"acto":"' +
      $("#causa_H_tipos_de_actos_"+ConSin+"_control.act"+ConSin+imputado).val()+'"}';

      $("#hdnActos_"+ConSin+imputado).val($("#hdnActos_"+ConSin+imputado).val()+jsonn+",");        

      var newrow="<tr class='tr"+imputado+"_"+idjson+"'><td>"+
        $("#causa_H_tipos_de_actos_"+ConSin+"_control.act"+ConSin+imputado+" :selected").text()+"</td>"+        
        "<td><button type='button' title='Eliminar acto' class='btn btn-danger' "+
        "onclick='eliminarActoConSin(\""+ConSin+"\",\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";

      $("#actos_"+ConSin+imputado+" tbody").append(newrow);
      $("#causa_H_tipos_de_actos_"+ConSin+"_control.act"+ConSin+imputado).val(-1);
    }
  }
  function eliminarActoConSin(ConSin,imputado,id,DB=0)
  {
    if (DB==1) {
      @if($Ctrl!='e3ev')
        eliminarReload(id,'cpevac'+ConSin);
      @else
        eliminarReload(id,'deevac'+ConSin);
      @endif
      
    }
    else
    {
      var json=JSON.parse("["+$("#hdnActos_"+ConSin+imputado).val().replace(/,+$/,"")+"]");
      var filtro=json.filter(function(arr){return arr.id!=id});
      $("#hdnActos_"+ConSin+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
      window.event.target.parentElement.parentElement.remove();
      // $('.tr'+imputado+"_"+id).remove();
    }
  }
  
  function addActo(imputado)
  {
    if(validateAddRow("frmCausasPenalesEN")) {
      if ($("#causa_H_tipo_actos_de_inv.act"+imputado).val()>-1 && $("#causa_H_tipo_control_actos_de_inv.act"+imputado).val()>-1
        && $("#causa_H_fecha_actos_de_inv.act"+imputado).val().trim().length>0) {
        // && $("#causa_H_observaciones_actos_de_inv.act"+imputado).val().trim().length>0) {

        var jsonn="";        
        var idjson=0;
        if ($("#hdnActos").val().length>0) {
         var json=JSON.parse("["+$("#hdnActos").val().replace(/,+$/,"")+"]");
         idjson= json.sort(function(a, b) {
                   return parseFloat(b['id']) - parseFloat(a['id']);
                })[0]['id']+1;
        }
        
        jsonn='{"id":'+idjson+',"imputado":'+imputado+',"fecha":"'+$("#causa_H_fecha_actos_de_inv.act"+imputado).val().trim()+'",'+
        '"tipo":"' +$("#causa_H_tipo_actos_de_inv.act"+imputado).val()+'",'+
        '"control":"' +$("#causa_H_tipo_control_actos_de_inv.act"+imputado).val()+'",'+
        '"observacion":"' +$("#causa_H_observaciones_actos_de_inv.act"+imputado).val().trim()+'"}';

        $("#hdnActos").val($("#hdnActos").val()+jsonn+",");        

        var newrow="<tr class='tr"+imputado+"_"+idjson+"'><td>"+$("#causa_H_fecha_actos_de_inv.act"+imputado).val().trim()+
        "</td><td>"+$("#causa_H_tipo_control_actos_de_inv.act"+imputado+" :selected").text()+"</td>"+
        "</td><td>"+$("#causa_H_tipo_actos_de_inv.act"+imputado+" :selected").text()+"</td>"+
          "<td>"+$("#causa_H_observaciones_actos_de_inv.act"+imputado).val().trim()+"</td>"+
          "<td><button type='button' title='Eliminar acto' class='btn btn-danger' "+
          "onclick='eliminarActo(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";

        $("#actos"+imputado+" tbody").append(newrow);
        $("#causa_H_tipo_control_actos_de_inv.act"+imputado).val(-1);
        $("#causa_H_tipo_actos_de_inv.act"+imputado).val(-1);
        $("#causa_H_fecha_actos_de_inv.act"+imputado).val('');
        $("#causa_H_observaciones_actos_de_inv.act"+imputado).val('');

      }
    }
  }
  function eliminarActo(imputado,id,DB=0)
  {
    if (DB==1) {
      @if($Ctrl!='e3ev')
        eliminarReload(id,'cpevac');
      @else
        eliminarReload(id,'deevac');
      @endif
      
    }
    else
    {
      var json=JSON.parse("["+$("#hdnActos").val().replace(/,+$/,"")+"]");
      var filtro=json.filter(function(arr){return arr.id!=id});
      $("#hdnActos").val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
      window.event.target.parentElement.parentElement.remove();
      // $('.tr'+imputado+"_"+id).remove();                
    }
  }
  function acumularMandamiento(imputado)
  {   
    var id=-1;
    var valor='';
    id=$("#causa_H_tipo_mandamiento.mand"+imputado+" :selected").val();
    valor=$("#causa_H_tipo_mandamiento.mand"+imputado+" :selected").text();

    if (id>-1) {
      var badge="<span class='mx-1 badge rounded-pill bg-info text-dark' id='span_"+id+"'>"+valor+
      "<button type='button' class='btn-close' onclick='eliminarMandamientoA(this,\""+imputado+"\")'></button></span>";
      
      var ids = JSON.parse("["+$("#hdnacumulado"+imputado).val()+"]");      
         if (!(ids.includes(parseInt(id)))) {
            ids.push(id.toString());
            $("#causa_H_tipo_mandamiento.mand"+imputado+" :selected").attr('disabled',true);
            $("#causa_H_tipo_mandamiento.mand"+imputado).val(-1);
            $("#hdnacumulado"+imputado).val(ids.toString());
            $("#txtacumulado"+imputado).append(badge);
        }
    }
  }
  function eliminarMandamientoA(element,imputado)
  {   
      var ids = JSON.parse("["+$("#hdnacumulado"+imputado).val()+"]");
      var id=element.parentElement.id.slice(5);
      if (ids.includes(parseInt(id))) {              
              var result=ids.filter(function(ele){  return ele != id; });
          $("#hdnacumulado"+imputado).val(result.toString());
          $("#causa_H_tipo_mandamiento.mand"+imputado+" option[value="+id+"]").attr('disabled',false);
          element.parentElement.remove();

      }       
  }

  function addMandamiento(imputado,ciclo=0)
  {
    if (validateAddRow("frmCausasPenalesEN_M_"+imputado)) {
     if ($("#hdnacumulado"+imputado).val().length>0 && ciclo==0) {
      if($("#causa_H_solicitud_de_mandamiento_judicial.mand"+imputado).val().length>0 
          && $("#causa_H_estatus_mandamiento.mand"+imputado).val()>-1
          //&& $("#causa_H_fecha_libera.mand"+imputado).val().length>0
          && $("#causa_H_fecha_mandamiento.mand"+imputado).val().length>0) { 
          var seleccionado=$("#causa_H_tipo_mandamiento.mand"+imputado).val();
        var valores = $("#hdnacumulado"+imputado).val().split(",");
        $.each(valores, function(index, value) {
          $("#span_"+value+" .btn-close").click() 
          $("#causa_H_tipo_mandamiento.mand"+imputado).val(value);
          addMandamiento(imputado,1);
        });
        $("#hdnacumulado"+imputado).val('');
        if (seleccionado<0) {
          $("#causa_H_solicitud_de_mandamiento_judicial.mand"+imputado).val('');
          $("#causa_H_estatus_mandamiento.mand"+imputado).val(-1);
          $("#causa_H_fecha_libera.mand"+imputado).val('');
          $("#causa_H_fecha_mandamiento.mand"+imputado).val('');
        }
        $("#causa_H_tipo_mandamiento.mand"+imputado).val(seleccionado);
      }
     }
     if ($("#causa_H_tipo_mandamiento.mand"+imputado).val()>-1)
     {
        if($("#causa_H_solicitud_de_mandamiento_judicial.mand"+imputado).val().length>0 
            && $("#causa_H_estatus_mandamiento.mand"+imputado).val()>-1
            //&& $("#causa_H_fecha_libera.mand"+imputado).val().length>0
            && $("#causa_H_fecha_mandamiento.mand"+imputado).val().length>0) {

        var jsonn="";        
        var idjson=0;
        if ($("#hdnMandamientos"+imputado).val().length>0) {
         var json=JSON.parse("["+$("#hdnMandamientos"+imputado).val().replace(/,+$/,"")+"]");
         idjson= json.sort(function(a, b) {
                   return parseFloat(b['id']) - parseFloat(a['id']);
                })[0]['id']+1;
        }
        
        jsonn='{"id":'+idjson+',"imputado":'+imputado+',"tipo":"'+$("#causa_H_tipo_mandamiento.mand"+imputado).val()+'",'+
        '"fSolicitud":"' +$("#causa_H_solicitud_de_mandamiento_judicial.mand"+imputado).val()+'",'+
        '"estatus":"' +$("#causa_H_estatus_mandamiento.mand"+imputado).val()+'",'+
        '"fLibramineto":"' +$("#causa_H_fecha_libera.mand"+imputado).val()+'",'+
        '"fMandamiento":"' +$("#causa_H_fecha_mandamiento.mand"+imputado).val()+'"}';

        $("#hdnMandamientos"+imputado).val($("#hdnMandamientos"+imputado).val()+jsonn+",");        

        var newrow="<tr class='tr"+imputado+"_"+idjson+"'><td>"+$("#causa_H_tipo_mandamiento.mand"+imputado+" :selected").text()+
        "</td><td>"+$("#causa_H_solicitud_de_mandamiento_judicial.mand"+imputado).val()+"</td>"+
          "<td>"+$("#causa_H_estatus_mandamiento.mand"+imputado+" :selected").text()+"</td>"+
          // "<td>"+$("#causa_H_fecha_libera.mand"+imputado).val()+"</td>"+
          "<td>"+$("#causa_H_fecha_mandamiento.mand"+imputado).val()+"</td>"+
          "<td><button type='button' title='Eliminar mandamiento' class='btn btn-danger' "+
          "onclick='eliminarMandamiento(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";
        $("#mandamientos"+imputado+" tbody").append(newrow);
        $("#causa_H_tipo_mandamiento.mand"+imputado).val(-1);
        if (ciclo==0) {
        $("#causa_H_solicitud_de_mandamiento_judicial.mand"+imputado).val('');
        $("#causa_H_estatus_mandamiento.mand"+imputado).val(-1);
        $("#causa_H_fecha_libera.mand"+imputado).val('');
        $("#causa_H_fecha_mandamiento.mand"+imputado).val('');
        }
      }
     }
    }
  }
  function eliminarMandamiento(imputado,id,DB=0)
  {
    if (DB==1) {
      @if($Ctrl!='e3ev')
        eliminarReload(id,'cpevmn');
      @else
        eliminarReload(id,'deevmn');
      @endif      
    }
    else
    {
      var json=JSON.parse("["+$("#hdnMandamientos"+imputado).val().replace(/,+$/,"")+"]");
      var filtro=json.filter(function(arr){return arr.id!=id});
      $("#hdnMandamientos"+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
      window.event.target.parentElement.parentElement.remove();
      // $('.tr'+imputado+"_"+id).remove();                
    }
  }
  function addMedida(imputado)
  {
    if(validateAddRow("frmCausasPenalesENv_"+imputado)){
      if ($("#causa_H_tipo_de_medida.mdd"+imputado).val()>-1 
            && $("#causa_H_temporalidad_de_la_medida.mdd"+imputado).val().length>0 
            && $("#causa_H_medida_impuesta_por.mdd"+imputado).val()>-1 ) {

        var jsonn="";        
        var idjson=0;
        if ($("#hdnMedidas"+imputado).val().length>0) {
         var json=JSON.parse("["+$("#hdnMedidas"+imputado).val().replace(/,+$/,"")+"]");
         idjson= json.sort(function(a, b) {
                   return parseFloat(b['id']) - parseFloat(a['id']);
                })[0]['id']+1;
        }
        
        jsonn='{"id":'+idjson+',"imputado":'+imputado+',"tipo":"'+$("#causa_H_tipo_de_medida.mdd"+imputado).val()+'",'+
        '"temporalidad":"' +$("#causa_H_temporalidad_de_la_medida.mdd"+imputado).val()+'",'+
        '"impuesta":"' +$("#causa_H_medida_impuesta_por.mdd"+imputado).val()+'"}';

        $("#hdnMedidas"+imputado).val($("#hdnMedidas"+imputado).val()+jsonn+",");        

        var newrow="<tr class='tr"+imputado+"_"+idjson+"'><td>"+$("#causa_H_tipo_de_medida.mdd"+imputado+" :selected").text()+
        "</td><td>"+$("#causa_H_temporalidad_de_la_medida.mdd"+imputado).val()+"</td>"+
          "<td>"+$("#causa_H_medida_impuesta_por.mdd"+imputado+" :selected").text()+"</td>"+
          "<td><button type='button' title='Eliminar medida' class='btn btn-danger' "+
          "onclick='eliminarMedida(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";

        $("#medidas"+imputado+" tbody").append(newrow);
        $("#causa_H_tipo_de_medida.mdd"+imputado).val(-1);
        $("#causa_H_temporalidad_de_la_medida.mdd"+imputado).val('');
        @if($Ctrl!='e3ev') 
          $("#causa_H_medida_impuesta_por.mdd"+imputado).val(-1); 
        @endif
      }
    }
  }
  function eliminarMedida(imputado,id,DB=0)
  {
    if (DB==1) {
      @if($Ctrl!='e3ev')
        eliminarReload(id,'cpevmd');
      @else
        eliminarReload(id,'deevmd');
      @endif


    }
    else
    {
      var json=JSON.parse("["+$("#hdnMedidas"+imputado).val().replace(/,+$/,"")+"]");
      var filtro=json.filter(function(arr){return arr.id!=id});
      $("#hdnMedidas"+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
      window.event.target.parentElement.parentElement.remove();
      // $('.tr'+imputado+"_"+id).remove();                
    }
  }  
</script>
