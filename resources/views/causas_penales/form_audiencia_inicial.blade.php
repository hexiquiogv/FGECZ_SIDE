<div class="row causasInicial">
  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Celebración de audiencia inicial</h4>
    </div>
  </div>
  <div class="mb-3 input-group {{count($listados['imputadosDDL_C'])<1?'d-none':''}}">
    <label for="ddlImputados_C" class="input-group-text">Imputado:</label>        
    <select class="form-select" id="ddlImputados_C" name="ddlImputados_C" onchange="javascript:addImputadoFormModal('_C')">
      <option value="-1">Seleccione una opción</option>
      @foreach ($listados['imputadosDDL_C'] as $item)      
        <option value="{{$item->id}}" data-forma="{{$item->FORMA_}}"
          data-detencion="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
      @endforeach       
    </select>
    <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button> -->
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
        <!-- <div class="mb-4 col-12 pestanaBase">
          <div class="pestanaTop">
            <h4>Celebración de audiencia inicial</h4>
          </div>
        </div> -->
        <div class="input-group">
          <label for="causa_H_fecha_audiencia_inicial" class="input-group-text">Fecha de audiencia inicial:</label>
          <input type="date" class="form-control" name="causa_H_fecha_audiencia_inicial" id="causa_H_fecha_audiencia_inicial">        
        
          <label for="causa_H_audiencia_inicial" class="input-group-text">Celebración audiencia inicial:</label>
          <select class="form-select" name="causa_H_audiencia_inicial" id="causa_H_audiencia_inicial">
            <option value="-1">Seleccione una opción</option>
            @foreach ($SiNoNoI as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>
            @endforeach       
         </select>
        </div>
        <div class="input-group">
          <!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-4 motivoNo" style="display:none;"> -->
          <label for="causa_H_motivo_noaud" class="input-group-text motivoNo">Motivo por el que no se celebró la audiencia inicial:</label>
          <select class="form-select motivoNo" name="causa_H_motivo_noaud" id="causa_H_motivo_noaud">
            <option value="-1">Seleccione una opción</option>
            @foreach ($motivoNoAud as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>
            @endforeach       
         </select>
          <!-- </div> -->
        </div>
        <div class="mb-3 input-group">
          <label for="causa_H_nombre_juez_control" class="input-group-text">Nombre del juez de control:</label>
          <input type="text" class="form-control nonum" name="causa_H_nombre_juez_control" id="causa_H_nombre_juez_control">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div> 

      {{--
        <div class="mb-3 col-12">
          <div class="accordion" id="accordionFiltrosCelebraciones_0">
            <div class="accordion-item">
              <h2 class="accordion-header" id="panelsFiltrosCelebraciones_0">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                data-bs-target="#panelsStayOpen-collapseOneCelebraciones_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneCelebraciones_0">
                  Registro de celebraciones de audencia inicial
                </button>
              </h2>
              <div id="panelsStayOpen-collapseOneCelebraciones_0" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosCelebraciones_0">
                <div class="accordion-body row">

                  <input type="hidden" name="hdnCelebraciones" id="hdnCelebraciones">
                  <table id="Celebraciones0" class="col-12 table table-striped table-hover table-responsive caption-top">
                      <caption><sup>*últimos 5 registros</sup></caption>    
                      <thead class="table-light">
                      <tr>
                        <th scope="col">Fecha de audiencia inicial</th>
                        <th scope="col">Celebración audiencia inicial</th>
                        <th scope="col">Motivo por el que no se celebró la audiencia inicial</th>
                        <th scope="col">Nombre del juez de control</th>
                        <th scope="col">Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>                   
                      @foreach($CelebracionesAI as $celeb)
                        <tr class="trV{{$celeb->id}}">
                          <td>{{$celeb->FECHA_AUDIENCIA_INICIAL}}</td>
                          <td>{{$celeb->Valor}}</td>
                          <td>{{$celeb->Valor1}}</td>
                          <td>{{$celeb->NOMBRE_JUEZ_CONTROL}}</td>
                          <td><button type="button" title="Eliminar registro" class="btn btn-danger" onclick="javascript:eliminarCelebracionAudencia(0,{{$celeb->id}},1)">&times;</button></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>    
                </div>
              </div>
            </div>
          </div>              
        </div>
      --}}    

      {{--
        <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
          <label for="causa_H_prorroga" class="form-label">Prórroga del plazo de investigación:</label>
          <input type="text" class="form-control alfanum" name="causa_H_prorroga" id="causa_H_prorroga" placeholder=""
          value="{{$audienciaInicial->PRORROGA??''}}">
        </div>
      --}}

    </div>      
   </form>
   <script type="text/javascript">
    $("#frmCausasPenalesAI_C_0 #causa_H_audiencia_inicial").change(function() {
      if (this.value==0) {$("#frmCausasPenalesAI_C_0 .motivoNo").show();}
      else
      {
        $("#frmCausasPenalesAI_C_0 .motivoNo").hide();
        $("#frmCausasPenalesAI_C_0 #causa_H_motivo_noaud").val('-1');
      }
    });
    if ($("#frmCausasPenalesAI_C_0 #causa_H_audiencia_inicial").val()==0) 
      {$("#frmCausasPenalesAI_C_0 .motivoNo").show();}
      else
      {
        $("#frmCausasPenalesAI_C_0 .motivoNo").hide();
        $("#frmCausasPenalesAI_C_0 #causa_H_motivo_noaud").val('-1');
      }       
   </script>
  </div>
  @foreach($listados['imputadosCP_C'] as $imputado)
   <div class="accordion mb-2" id="accordionFiltrosAudienciaI_C_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosAudienciaI_C_{{$imputado->id}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneAudienciaI_C_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaI_C_{{$imputado->id}}">
          Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneAudienciaI_C_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaI_C_{{$imputado->id}}">
       <form method='post' name="frmCausasPenalesAI_C_{{$imputado->id}}" id="frmCausasPenalesAI_C_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="accordion-body row">
          @csrf  
          <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="{{$imputado->id}}">
          <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">            
          <input type="hidden" name="frmSecc" id="frmSecc" value="C">
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_fecha_audiencia_inicial" class="form-label">Fecha de audiencia inicial:</label>
            <input type="date" class="form-control" name="causa_H_fecha_audiencia_inicial" id="causa_H_fecha_audiencia_inicial">
            {{--value="{{$imputado->FECHA_AUDIENCIA_INICIAL??''}}">--}}
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_audiencia_inicial" class="form-label">Celebración audiencia inicial:</label>
            <select class="form-select" name="causa_H_audiencia_inicial" id="causa_H_audiencia_inicial">
              <option value="-1">Seleccione una opción</option>
              @foreach ($SiNoNoI as $item)      
                {{--<option value="{{ $item->id }}" 
                  {{isset($imputado->AUDIENCIA_INICIAL)?$imputado->AUDIENCIA_INICIAL==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>--}}
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>
              @endforeach       
           </select>
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 motivoNo" style="display:none;">
            <label for="causa_H_motivo_noaud" class="form-label motivoNo">Motivo por el que no se celebró la audiencia inicial:</label>
            <select class="form-select motivoNo" name="causa_H_motivo_noaud" id="causa_H_motivo_noaud">
              <option value="-1">Seleccione una opción</option>
              @foreach ($motivoNoAud as $item)      
                {{--<option value="{{ $item->id }}" 
                  {{isset($imputado->MOTIVO_NOAUD)?$imputado->MOTIVO_NOAUD==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>--}}
                <option value="{{ $item->id }}">{{$item->Valor}}</option>
              @endforeach       
           </select>
          </div>
          <div class="mb-3 col-sm-12 col-md-12 col-lg-12">
            <label for="causa_H_nombre_juez_control" class="form-label">Nombre del juez de control:</label>
            <input type="text" class="form-control nonum" name="causa_H_nombre_juez_control" id="causa_H_nombre_juez_control">
            {{-- value="{{$imputado->NOMBRE_JUEZ_CONTROL??''}}"> --}}
          </div> 
          <div class="mb-3 border-top pt-2 modal-footer">
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div> 
          <div class="mb-3 col-12">
            <div class="accordion" id="accordionFiltrosCelebraciones_{{$imputado->id}}">
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsFiltrosCelebraciones_{{$imputado->id}}">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                  data-bs-target="#panelsStayOpen-collapseOneCelebraciones_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneCelebraciones_{{$imputado->id}}">
                    Registro de celebraciones de audencia inicial
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOneCelebraciones_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosCelebraciones_{{$imputado->id}}">
                  <div class="accordion-body row">
                    <input type="hidden" name="hdnCelebraciones{{$imputado->id}}" id="hdnCelebraciones{{$imputado->id}}">
                    <table id="Celebraciones{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
                        <caption><sup>*últimos 5 registros</sup></caption>    
                        <thead class="table-light">
                        <tr>
                          <th scope="col">Fecha de audiencia inicial</th>
                          <th scope="col">Celebración audiencia inicial</th>
                          <th scope="col">Motivo por el que no se celebró la audiencia inicial</th>
                          <th scope="col">Nombre del juez de control</th>
                          <th scope="col">Eliminar</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(isset($CelebracionesAI[$imputado->id]))
                          @foreach($CelebracionesAI[$imputado->id] as $celeb)
                            <tr class="trV{{$celeb->id}}">
                              <td>{{$celeb->FECHA_AUDIENCIA_INICIAL}}</td>
                              <td>{{$celeb->Valor}}</td>
                              <td>{{$celeb->Valor1}}</td>
                              <td>{{$celeb->NOMBRE_JUEZ_CONTROL}}</td>
                              <td><button type="button" title="Eliminar registro" class="btn btn-danger" 
                                onclick="javascript:eliminarCelebracionAudencia({{$imputado->id}},{{$celeb->id}},1)">&times;</button></td>
                            </tr>
                          @endforeach
                        @endif
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
    </div>
   </div>
   <script type="text/javascript">
    $("#frmCausasPenalesAI_C_{{$imputado->id}} #causa_H_audiencia_inicial").change(function() {
      if (this.value==0) {$("#frmCausasPenalesAI_C_{{$imputado->id}} .motivoNo").show();}
      else
      {
        $("#frmCausasPenalesAI_C_{{$imputado->id}} .motivoNo").hide();
        $("#frmCausasPenalesAI_C_{{$imputado->id}} #causa_H_motivo_noaud").val('-1');
      }
    });
    if ($("#frmCausasPenalesAI_C_{{$imputado->id}} #causa_H_audiencia_inicial").val()==0) 
    {   $("#frmCausasPenalesAI_C_{{$imputado->id}} .motivoNo").show();}
    else
    {
      $("#frmCausasPenalesAI_C_{{$imputado->id}} .motivoNo").hide();
      $("#frmCausasPenalesAI_C_{{$imputado->id}} #causa_H_motivo_noaud").val('-1');
    }       
   </script>   
  @endforeach 

  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Control de detención</h4>
    </div>
  </div>   
  <div class="mb-3 input-group {{count($listados['imputadosDDL_O'])<1?'d-none':''}}">
    <label for="ddlImputados_O" class="input-group-text">Imputado:</label>        
    <select class="form-select" id="ddlImputados_O" name="ddlImputados_O" onchange="javascript:addImputadoFormModal('_O')">
      <option value="-1">Seleccione una opción</option>
      @foreach ($listados['imputadosDDL_O'] as $item)      
        <option value="{{$item->id}}" data-forma="{{$item->FORMA_}}"
          data-detencion="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
      @endforeach       
    </select>
    <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button> -->
  </div>
  <div id="addImputadoForm_O" style="display: none;">
   <form method='post' name="frmCausasPenalesAI_O_0" id="frmCausasPenalesAI_O_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
    <div class="row">
      @csrf
        <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="0">
        <input type="hidden" name="idImputado" id="idImputado" value="">
        <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
        <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
        <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
        <input type="hidden" name="frmSecc" id="frmSecc" value="O">

        <div class="input-group">
          <label for="causa_H_forma_de_conduccion_del_imputado_a_proceso" class="input-group-text">Forma de conducción del imputado al proceso:</label>
          <select class="form-select" name="causa_H_forma_de_conduccion_del_imputado_a_proceso" id="causa_H_forma_de_conduccion_del_imputado_a_proceso">
            <option value="-1">Seleccione una opción</option>
            @foreach ($conduccionImp as $item)      
             <option value="{{ $item->id }}">{{$item->Valor}}</option>      
            @endforeach      
          </select>
        <!-- </div>
        <div class="mb-3 col-sm-12 col-md-6 col-lg-4"> -->
        </div>
        <div class="input-group">
          <label for="causa_H_fecha_control" class="input-group-text">Fecha de audiencia de control de la detención:</label>
          <input type="date" class="form-control" name="causa_H_fecha_control" id="causa_H_fecha_control">
        <!-- </div>        
        <div class="mb-3 col-sm-12 col-md-6 col-lg-4"> -->
        </div>
        <div class="mb-3 input-group">
          <label for="causa_H_decreto_legal_detencion" class="input-group-text">Decreto legal de detención:</label>
          <select class="form-select" name="causa_H_decreto_legal_detencion" id="causa_H_decreto_legal_detencion">
            <option value="-1">Seleccione una opción</option>
            @foreach ($SiNo as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>
            @endforeach      
          </select>
         <button type="submit" class="btn btn-primary">Guardar</button>
        </div> 
    </div>      
   </form>
  </div>    
  @foreach($listados['imputadosCP_O'] as $imputado)
   <div class="accordion mb-2" id="accordionFiltrosAudienciaI_O_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosAudienciaI_O_{{$imputado->id}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneAudienciaI_O_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaI_O_{{$imputado->id}}">
          Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneAudienciaI_O_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaI_O_{{$imputado->id}}">
       <form method='post' name="frmCausasPenalesAI_O_{{$imputado->id}}" id="frmCausasPenalesAI_O_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="accordion-body row">
          @csrf  
          <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="{{$imputado->id}}">
          <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="O">

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

          <div class="border-top pt-2 modal-footer">
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div> 
        </div>
       </form>
      </div>
    </div>
   </div>
  @endforeach 

    <div class="mb-4 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Formulación de imputación </h4>
      </div>
    </div> 
  <div class="mb-3 input-group {{count($listados['imputadosDDL_F'])<1?'d-none':''}}">
    <label for="ddlImputados_F" class="input-group-text">Imputado:</label>        
    <select class="form-select" id="ddlImputados_F" name="ddlImputados_F" onchange="javascript:addImputadoFormModal('_F')">
      <option value="-1">Seleccione una opción</option>
      @foreach ($listados['imputadosDDL_F'] as $item)      
        <option value="{{$item->id}}" data-forma="{{$item->FORMA_}}"
          data-detencion="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
      @endforeach       
    </select>
    <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button> -->
  </div>
  <div id="addImputadoForm_F" style="display: none;">
   <form method='post' name="frmCausasPenalesAI_F_0" id="frmCausasPenalesAI_F_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
    <div class="row">
      @csrf
        <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="0">
        <input type="hidden" name="idImputado" id="idImputado" value="">
        <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
        <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
        <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
        <input type="hidden" name="frmSecc" id="frmSecc" value="F">

        <div class="input-group"><!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-4"> -->
          <label for="causa_H_fecha_form" class="input-group-text">Fecha de formulación de la imputación:</label>
          <input type="date" class="form-control" name="causa_H_fecha_form" id="causa_H_fecha_form">
            <label for="causa_H_formulacion" class="input-group-text">Formulación de la imputación:</label>
            <select class="form-select" name="causa_H_formulacion" id="causa_H_formulacion">
              <option value="-1">Seleccione una opción</option>
              @foreach ($SiNoNoI as $item)      
                <option value="{{ $item->id }}">{{$item->Valor}}</option>      
              @endforeach        
           </select>
        </div>       
        <div class="input-group obsForm" style="display:none;">
          <label for="causa_H_observaciones" class="input-group-text">Observaciones:</label>
          <textarea type="textarea" class="form-control" maxlength="255" rows="2" name="causa_H_observaciones" id="causa_H_observaciones" 
          placeholder=""></textarea>
            @if($errors->has('causa_H_observaciones'))
             <span class="text-danger">{{ $errors->first('causa_H_observaciones') }}</span>
            @endif
        </div>
        <div class="mb-3 pe-2 modal-footer input-group">  
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

    </div>      
   </form>
     <script type="text/javascript">
      $("#frmCausasPenalesAI_F_0 #causa_H_formulacion").change(function() {
      if (this.value==0) {$("#frmCausasPenalesAI_F_0 .obsForm").show();}
      else
      {
        $("#frmCausasPenalesAI_F_0 .obsForm").hide();
        $("#frmCausasPenalesAI_F_0 .obsForm textarea").val('');
      }
    });
    if ($("#frmCausasPenalesAI_F_0 #causa_H_formulacion").val()==0) 
      {$("#frmCausasPenalesAI_F_0 .obsForm").show();}
      else
      {
        $("#frmCausasPenalesAI_F_0 .obsForm").hide();
        $("#frmCausasPenalesAI_F_0 .obsForm textarea").val('');
      }
  </script> 
  </div>    
  @foreach($listados['imputadosCP_F'] as $imputado)
   <div class="accordion mb-2" id="accordionFiltrosAudienciaI_F_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosAudienciaI_F_{{$imputado->id}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneAudienciaI_F_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaI_F_{{$imputado->id}}">
          Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneAudienciaI_F_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaI_F_{{$imputado->id}}">
       <form method='post' name="frmCausasPenalesAI_F_{{$imputado->id}}" id="frmCausasPenalesAI_F_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="accordion-body row">
          @csrf  
          <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="{{$imputado->id}}">
          <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="F">

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


          <div class="border-top pt-2 modal-footer">
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div> 
        </div>
       </form>
      </div>
    </div>
   </div>
    <script type="text/javascript">
        $("#frmCausasPenalesAI_F_{{$imputado->id}} #causa_H_formulacion").change(function() {
        if (this.value==0) {$("#frmCausasPenalesAI_F_{{$imputado->id}} .obsForm").show();}
        else
        {
          $("#frmCausasPenalesAI_F_{{$imputado->id}} .obsForm").hide();
          $("#frmCausasPenalesAI_F_{{$imputado->id}} .obsForm textarea").val('');
        }
      });
      if ($("#frmCausasPenalesAI_F_{{$imputado->id}} #causa_H_formulacion").val()==0) 
        {$("#frmCausasPenalesAI_F_{{$imputado->id}} .obsForm").show();}
        else
        {
          $("#frmCausasPenalesAI_F_{{$imputado->id}} .obsForm").hide();
          $("#frmCausasPenalesAI_F_{{$imputado->id}} .obsForm textarea").val('');
        }
    </script>   
  @endforeach 

  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Vinculación a proceso</h4>
    </div>
  </div>
  <div class="mb-3 input-group {{count($listados['imputadosDDL_V'])<1?'d-none':''}}">
    <label for="ddlImputados_V" class="input-group-text">Imputado:</label>        
    <select class="form-select" id="ddlImputados_V" name="ddlImputados_V" onchange="javascript:addImputadoFormModal('_V')">
      <option value="-1">Seleccione una opción</option>
      @foreach ($listados['imputadosDDL_V'] as $item)      
        <option value="{{$item->id}}" data-forma="{{$item->FORMA_}}"
          data-detencion="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
      @endforeach       
    </select>
    <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button> -->
  </div>
  <div id="addImputadoForm_V" style="display: none;">
   <form method='post' name="frmCausasPenalesAI_V_0" id="frmCausasPenalesAI_V_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
    <div class="row">
      @csrf
        <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="0">
        <input type="hidden" name="idImputado" id="idImputado" value="">
        <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
        <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
        <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
        <input type="hidden" name="frmSecc" id="frmSecc" value="V">

        <div class="input-group">
          <label for="causa_H_fecha_resol" class="input-group-text">Fecha en que se dictó el auto de vinculación a proceso:</label>
          <input type="date" class="form-control" name="causa_H_fecha_resol" id="causa_H_fecha_resol">
        </div>    
        <div class="input-group">
          <label for="causa_H_resolucion" class="input-group-text">Resolución del auto de vinculación a proceso:</label>
          <select class="form-select" name="causa_H_resolucion" id="causa_H_resolucion">
            <option value="-1">Seleccione una opción</option>
            @foreach ($resolAuto as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
            @endforeach      
         </select>
        </div>    
        <div class="mb-3 col-sm-12 col-md-12 col-lg-12">
          <label for="causa_H_delito_vinculo" class="input-group-text">Delito por el que se vinculó</label>
          <select multiple class="form-select" name="causa_H_delito_vinculo[]" id="causa_H_delito_vinculo">
            <!-- <option disabled value="-1">Seleccione una opción</option> -->
            @foreach ($delitosCP as $item)                
              <option value="{{ $item->idDelito }}">{{$item->Valor}}</option>      
            @endforeach
         </select>
        </div> 
        <div class="mb-3 pe-2 modal-footer input-group">  
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

    </div>      
   </form>
  </div>    
  @foreach($listados['imputadosCP_V'] as $imputado)
   <div class="accordion mb-2" id="accordionFiltrosAudienciaI_V_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosAudienciaI_V_{{$imputado->id}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneAudienciaI_V_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaI_V_{{$imputado->id}}">
          Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneAudienciaI_V_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaI_V_{{$imputado->id}}">
       <form method='post' name="frmCausasPenalesAI_V_{{$imputado->id}}" id="frmCausasPenalesAI_V_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="accordion-body row">
          @csrf  
          <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="{{$imputado->id}}">
          <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="V">

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


          <div class="border-top pt-2 modal-footer">
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div> 
        </div>
       </form>
      </div>
    </div>
   </div>
  @endforeach 


  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Plazo de investigación complementaria</h4>
    </div>
  </div>
  <div class="mb-3 input-group {{count($listados['imputadosDDL_P'])<1?'d-none':''}}">
    <label for="ddlImputados_P" class="input-group-text">Imputado:</label>        
    <select class="form-select" id="ddlImputados_P" name="ddlImputados_P" onchange="javascript:addImputadoFormModal('_P')">
      <option value="-1">Seleccione una opción</option>
      @foreach ($listados['imputadosDDL_P'] as $item)      
        <option value="{{$item->id}}" data-forma="{{$item->FORMA_}}"
          data-detencion="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
      @endforeach       
    </select>
    <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button> -->
  </div>
  <div id="addImputadoForm_P" style="display: none;">
   <form method='post' name="frmCausasPenalesAI_P_0" id="frmCausasPenalesAI_P_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
    <div class="row">
      @csrf
        <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="0">
        <input type="hidden" name="idImputado" id="idImputado" value="">
        <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
        <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
        <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
        <input type="hidden" name="frmSecc" id="frmSecc" value="P">

      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_fecha_inicio_investigacion" class="form-label">Fecha de inicio del plazo de investigación:</label>
        <input type="date" class="form-control" name="causa_H_fecha_inicio_investigacion" id="causa_H_fecha_inicio_investigacion">
      </div> 
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_fecha_cierre" class="form-label">Fecha de cierre del plazo de investigación:</label>
        <input type="date" class="form-control noValidate" name="causa_H_fecha_cierre" id="causa_H_fecha_cierre">
      </div>

      <div class="mb-3 col-12">
        <div class="accordion" id="accordionFiltrosProrrogas_0">
          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsFiltrosProrrogas_0">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" 
              data-bs-target="#panelsStayOpen-collapseOneProrrogas_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneProrrogas_0">
                Listado de prorrogas del plazo de investigación
              </button>
            </h2>
            <div id="panelsStayOpen-collapseOneProrrogas_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosProrrogas_0">
              <div class="accordion-body row">
                <div class="mb-3 col-sm-12 input-group">
                    <label for="causa_H_prorroga" class="input-group-text">¿Quien solicitó la prórroga?:</label>
                    <select class="form-select prr0" name="causa_H_prorroga" id="causa_H_prorroga">
                      <option value="-1">Seleccione una opción</option>
                      @foreach ($TipoProrroga as $item)      
                        <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                      @endforeach      
                    </select>  
                    <label for="causa_H_temporalidad_prorroga" class="input-group-text">Temporalidad de la prórroga:</label>
                    <input type="text" class="form-control prr0 alfanum" name="causa_H_temporalidad_prorroga" id="causa_H_temporalidad_prorroga">

                    <button type="button" class="btn btn-primary"onclick="javascript:addProrroga(0)">
                      Agregar prorroga
                    </button>  
                </div>
                <input type="hidden" name="hdnProrrogas0" id="hdnProrrogas0">
                <input type="hidden" name="hdnGuardarSinProrrogas0" id="hdnGuardarSinProrrogas0" value="1">
                <table id="prorrogas0" class="col-12 table table-striped table-hover table-responsive caption-top">
                    <caption></caption>    
                    <thead class="table-light">
                    <tr>
                      <th scope="col">¿Quien solicitó la prórroga?</th>
                      <th scope="col">Temporalidad de la prórroga</th>
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
      <div class="border-bottom py-2 mb-4 modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div> 

    </div>      
   </form>
  </div>    
  @foreach($listados['imputadosCP_P'] as $imputado)
   <div class="accordion mb-2" id="accordionFiltrosAudienciaI_P_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosAudienciaI_P_{{$imputado->id}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneAudienciaI_P_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaI_P_{{$imputado->id}}">
          Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneAudienciaI_P_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaI_P_{{$imputado->id}}">
       <form method='post' name="frmCausasPenalesAI_P_{{$imputado->id}}" id="frmCausasPenalesAI_P_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="accordion-body row">
          @csrf  
          <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="{{$imputado->id}}">
          <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="P">

          @if($imputado->Vigencia??0)        
           <div class="alert alert-danger alert-dismissible fade show" id="" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#fail-circle-fill"/></svg>
            El plazo de investigación vence en <b>{{$imputado->dias}} días</b>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>  
          @endif
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_fecha_inicio_investigacion" class="form-label">Fecha de inicio del plazo de investigación:</label>
            <input type="date" class="form-control" name="causa_H_fecha_inicio_investigacion" id="causa_H_fecha_inicio_investigacion" 
            value="{{$imputado->FECHA_INICIO_INVESTIGACION??''}}">
          </div> 
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_fecha_cierre" class="form-label">Fecha de cierre del plazo de investigación:</label>
            <input type="date" class="form-control noValidate" name="causa_H_fecha_cierre" id="causa_H_fecha_cierre" value="{{$imputado->FECHA_CIERRE??''}}">
          </div>
          <div class="mb-3 col-12">
            <div class="accordion" id="accordionFiltrosProrrogas_{{$imputado->id}}">
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsFiltrosProrrogas_{{$imputado->id}}">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                  data-bs-target="#panelsStayOpen-collapseOneProrrogas_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneProrrogas_{{$imputado->id}}">
                    Listado de prorrogas del plazo de investigación
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOneProrrogas_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosProrrogas_{{$imputado->id}}">
                  <div class="accordion-body row">
                    <div class="mb-3 col-sm-12 input-group">
                        <label for="causa_H_prorroga" class="input-group-text">¿Quien solicitó la prórroga?:</label>
                        <select class="form-select prr{{$imputado->id}}" name="causa_H_prorroga" id="causa_H_prorroga">
                          <option value="-1">Seleccione una opción</option>
                          @foreach ($TipoProrroga as $item)      
                            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                          @endforeach      
                        </select>  
                        <label for="causa_H_temporalidad_prorroga" class="input-group-text">Temporalidad de la prórroga:</label>
                        <input type="text" class="form-control prr{{$imputado->id}} alfanum" name="causa_H_temporalidad_prorroga" id="causa_H_temporalidad_prorroga">

                        <button type="button" class="btn btn-primary"onclick="javascript:addProrroga({{$imputado->id}})">
                          Agregar prorroga
                        </button>  
                    </div>
                    <input type="hidden" name="hdnProrrogas{{$imputado->id}}" id="hdnProrrogas{{$imputado->id}}">
                    <input type="hidden" name="hdnGuardarSinProrrogas{{$imputado->id}}" id="hdnGuardarSinProrrogas{{$imputado->id}}" value="1">
                    <table id="prorrogas{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
                        <caption></caption>    
                        <thead class="table-light">
                        <tr>
                          <th scope="col">¿Quien solicitó la prórroga?</th>
                          <th scope="col">Temporalidad de la prórroga</th>
                          <th scope="col">Eliminar</th>
                        </tr>
                      </thead>
                      <tbody>   
                      @if(isset($prorrogasAI[$imputado->id]))                
                        @foreach($prorrogasAI[$imputado->id] as $prorroga)
                          <tr class="trV{{$prorroga->id}}">
                            <td>{{$prorroga->Valor}}</td>
                            <td>{{$prorroga->TEMPORALIDAD_PRORROGA}}</td>
                          <td><button type="button" title="Eliminar prorroga" class="btn btn-danger" onclick="javascript:eliminarProrroga({{$imputado->id}},{{$prorroga->id}},1)">&times;</button></td></tr>
                        @endforeach
                      @endif
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

 {{--
   <form method='post' name="frmCausasPenalesAIpt2" id="frmCausasPenalesAIpt2" action="{{ route('saveCP') }}" 
    enctype="multipart/form-data">
    <div class="row">
      @csrf      
      <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
      <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
      <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">  
        <div class="mb-4 col-12 pestanaBase">
          <div class="pestanaTop">
            <h4>Plazo de investigación complementaria</h4>
          </div>
        </div>
        @if($audienciaInicial->Vigencia??0)
         <div class="alert alert-danger alert-dismissible fade show" id="" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#fail-circle-fill"/></svg>
          El plazo de investigación vence en <b>{{$audienciaInicial->dias}} días</b>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>  
        @endif
        <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
          <label for="causa_H_fecha_inicio_investigacion" class="form-label">Fecha de inicio del plazo de investigación:</label>
          <input type="date" class="form-control" name="causa_H_fecha_inicio_investigacion" id="causa_H_fecha_inicio_investigacion" 
          value="{{$audienciaInicial->FECHA_INICIO_INVESTIGACION??''}}">
        </div> 
        <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
          <label for="causa_H_fecha_cierre" class="form-label">Fecha de cierre del plazo de investigación:</label>
          <input type="date" class="form-control" name="causa_H_fecha_cierre" id="causa_H_fecha_cierre" value="{{$audienciaInicial->FECHA_CIERRE??''}}">
        </div>

      <div class="mb-3 col-12">
        <div class="accordion" id="accordionFiltrosProrrogas_0">
          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsFiltrosProrrogas_0">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" 
              data-bs-target="#panelsStayOpen-collapseOneProrrogas_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneProrrogas_0">
                Listado de prorrogas del plazo de investigación
              </button>
            </h2>
            <div id="panelsStayOpen-collapseOneProrrogas_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosProrrogas_0">
              <div class="accordion-body row">
                <div class="mb-3 col-sm-12 input-group">
                    <label for="causa_H_prorroga" class="input-group-text">¿Quien solicitó la prórroga?:</label>
                    <select class="form-select prr0" name="causa_H_prorroga" id="causa_H_prorroga">
                      <option value="-1">Seleccione una opción</option>
                      @foreach ($TipoProrroga as $item)      
                        <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                      @endforeach      
                    </select>  
                    <label for="causa_H_temporalidad_prorroga" class="input-group-text">Temporalidad de la prórroga:</label>
                    <input type="text" class="form-control prr0 alfanum" name="causa_H_temporalidad_prorroga" id="causa_H_temporalidad_prorroga">

                    <button type="button" class="btn btn-primary"onclick="javascript:addProrroga(0)">
                      Agregar prorroga
                    </button>  
                </div>
                <input type="hidden" name="hdnProrrogas" id="hdnProrrogas">
                <table id="prorrogas0" class="col-12 table table-striped table-hover table-responsive caption-top">
                    <caption></caption>    
                    <thead class="table-light">
                    <tr>
                      <th scope="col">¿Quien solicitó la prórroga?</th>
                      <th scope="col">Temporalidad de la prórroga</th>
                      <th scope="col">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>                   
                    @foreach($prorrogasAI as $prorroga)
                      <tr class="trV{{$prorroga->id}}">
                        <td>{{$prorroga->Valor}}</td>
                        <td>{{$prorroga->TEMPORALIDAD_PRORROGA}}</td>
                      <td><button type="button" title="Eliminar prorroga" class="btn btn-danger" onclick="javascript:eliminarProrroga(0,{{$prorroga->id}},1)">&times;</button></td></tr>
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
 --}}
</div>
{{--
  <div class="modal fade" id="addImputadoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addImputadoFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addImputadoFormLabel">Datos de la audiencia inicial del imputado</h1>
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
               @include("causas_penales.audiencia_inicial.formModal")
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
      var conjunto = [];
      var prorrogas=false;
      if (!conjunto.includes(this.id.replace(/_([^_]+)$/, ''))) {
        event.preventDefault(); // Prevent the default form submission
        var respuesta=true;
        var campos=[];
        if (this.id.replace(/_([^_]+)$/, '')=="frmCausasPenalesAI_P") {
          var idImp=this.id.split("_").pop();
        $("#"+this.id+" input:not(.noValidate):not(.prr"+idImp+"):visible").each(function(){
            if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
            else{$(this).removeClass("border-3 border-danger");}
          });      

          $("#"+this.id+" select:not(.noValidate):not(.prr"+idImp+"):visible").each(function(){
            if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
            else{$(this).removeClass("border-3 border-danger");}        
          });

          if (respuesta && $("#prorrogas"+this.id.split("_").pop()+" tbody tr").length<1
              && $("#hdnGuardarSinProrrogas"+this.id.split("_").pop()).val()=="0")
          { prorrogas=respuesta;
            //respuesta=false; showtoast('Se debe agregar por lo menos una prorroga','danger_prorr');
            respuesta=false; showtoast('No hay ninguna prorroga registrada para guardar.<br/>Si aún así deseas continuar vuelve a presionar el botón de Guardar/Actualizar','info_prorr');
            $("#hdnGuardarSinProrrogas"+this.id.split("_").pop()).val("1");
          }

        }
        else
        {
          $("#"+this.id+" input:not(.noValidate):visible").each(function(){
            if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
            else{$(this).removeClass("border-3 border-danger");}
          });      

          $("#"+this.id+" select:not(.noValidate):visible").each(function(){
            if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
            else{$(this).removeClass("border-3 border-danger");}        
          });
          if (this.id.replace(/_([^_]+)$/, '')=="frmCausasPenalesAI_V") {
            if($("#"+this.id+" #causa_H_delito_vinculo").val().length<1)
            {respuesta=false;$("#"+this.id+" #causa_H_delito_vinculo").addClass("border-3 border-danger");campos.push("causa_H_delito_vinculo" );}
            else{$(this).removeClass("border-3 border-danger");}  
          }
        }
        if (respuesta) {this.submit();}
        else
        {
          if (!prorrogas) {showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');}
        }
      }
    });
});

function validateAddRow(formularioID)
{
  var respuesta=true;
  var campos=[];
  $("#"+formularioID+" input:not(.noValidate):not(#causa_H_fecha_inicio_investigacion):visible").each(function(){
    if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
    else{$(this).removeClass("border-3 border-danger");}
  });      

  $("#"+formularioID+" select:not(.noValidate):visible").each(function(){
    if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
    else{$(this).removeClass("border-3 border-danger");}
  });

  if (!respuesta) {showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');}
    return respuesta;
}

  $(".monto").mask("#,##0.00",{reverse: true});
  $(".temporalidadMA").mask('TTTT',
    {translation:  {'T': {pattern: /[0-9añosmeAÑOSME\,\s]/, recursive: true}}});
  $(".alfanum").mask('XXXX',
      {translation:  {'X': {pattern: /[0-9a-zA-Z\s]/, recursive: true}}});
  $(".temporalidad").mask('YYYY',
    {translation:  {'Y': {pattern: /[0-9díiasDÍIAS\s]/, recursive: true}}});      
  $(".nonum").mask('ZZZZ',
    {translation:  {'Z': {pattern: /[a-zA-Z\s]/, recursive: true}}});

  function addProrroga(imputado)
  {
    if (validateAddRow("frmCausasPenalesAI_P_"+imputado)) {
      if ($("#causa_H_prorroga.prr"+imputado).val()>-1 
            && $("#causa_H_temporalidad_prorroga.prr"+imputado).val().trim().length>0) {
        var jsonn="";        
        var idjson=0;
        if ($("#hdnProrrogas"+imputado).val().length>0) {
         var json=JSON.parse("["+$("#hdnProrrogas"+imputado).val().replace(/,+$/,"")+"]");
         idjson= json.sort(function(a, b) {
                   return parseFloat(b['id']) - parseFloat(a['id']);
                })[0]['id']+1;
        }
        
        jsonn='{"id":'+idjson+',"imputado":'+imputado+',"prorroga":"' +$("#causa_H_prorroga.prr"+imputado).val()+'",'+
        '"temporalidad":"' +$("#causa_H_temporalidad_prorroga.prr"+imputado).val().trim()+'"}';

        $("#hdnProrrogas"+imputado).val($("#hdnProrrogas"+imputado).val()+jsonn+",");        

        var newrow="<tr class='tr"+imputado+"_"+idjson+"'><td>"+$("#causa_H_prorroga.prr"+imputado+" :selected").text()+"</td>"+
          "<td>"+$("#causa_H_temporalidad_prorroga.prr"+imputado).val().trim()+"</td>"+
          "<td><button type='button' title='Eliminar prorroga' class='btn btn-danger' "+
          "onclick='eliminarProrroga(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";

        $("#prorrogas"+imputado+" tbody").append(newrow);
        $("#causa_H_prorroga.prr"+imputado).val(-1);
        $("#causa_H_temporalidad_prorroga.prr"+imputado).val('');
      }
    }
  }
  function eliminarProrroga(imputado,id,DB=0)
  {
    if (DB==1) {
      eliminarReload(id,'cpaipr');
    }
    else
    {
      var json=JSON.parse("["+$("#hdnProrrogas"+imputado).val().replace(/,+$/,"")+"]");
      var filtro=json.filter(function(arr){return arr.id!=id});
      $("#hdnProrrogas"+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
      window.event.target.parentElement.parentElement.remove();
      // $('.tr'+imputado+"_"+id).remove();                
    }
  }

  function eliminarCelebracionAudencia(imputado,id,DB=0)
  {
    if (DB==1) {
      eliminarReload(id,'cpaica');
    }
    else
    {
      var json=JSON.parse("["+$("#hdnCelebraciones"+imputado).val().replace(/,+$/,"")+"]");
      var filtro=json.filter(function(arr){return arr.id!=id});
    $("#hdnCelebraciones"+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
      window.event.target.parentElement.parentElement.remove();             
    }
  }  

  function addImputadoFormModal(Seccion)
  {
   @if($CP_AI>=0)
    if ($("#ddlImputados"+Seccion).val()>-1) {
     $("#frmCausasPenalesAI"+Seccion+"_0 #idImputado").val($("#ddlImputados"+Seccion).val());
     //$("#addImputadoFormLabel").text("Datos de la audiencia inicial del imputado: "+$("#ddlImputados :selected").text());
     if($("#ddlImputados"+Seccion+" :selected").data().detencion==1)
     {
     $("#frmCausasPenalesAI"+Seccion+"_0 #causa_H_decreto_legal_detencion").val(1);
     }
     if($("#ddlImputados"+Seccion+" :selected").data().detencion==2)
     {
     $("#frmCausasPenalesAI"+Seccion+"_0 #causa_H_decreto_legal_detencion").val(0); 
     }
     if($("#ddlImputados"+Seccion+" :selected").data().forma==1)
     {
     $("#frmCausasPenalesAI"+Seccion+"_0 #causa_H_forma_de_conduccion_del_imputado_a_proceso").val(5); 
     }          

     $("#addImputadoForm"+Seccion).show()
    }
    else
    {
     $("#addImputadoForm"+Seccion).hide() 
    }
   @else
    showtoast('<h6>&times; Es necesario capturar datos de la "audiencia inicial" antes de registrar datos de algún imputado.','danger');
   @endif
  }
  function addMedida(imputado)
  {
    if ($("#causa_H_medidas_cautelares.imp"+imputado).val()>-1 
      && $("#causa_H_tipo_medidas_cautelares.imp"+imputado).val()>-1 
      && $("#causa_H_temporalidad_medida.imp"+imputado).val()>-1) {

      var jsonn="";        
      var idjson=0;
      if ($("#hdnMedidas"+imputado).val().length>0) {
       var json=JSON.parse("["+$("#hdnMedidas"+imputado).val().replace(/,+$/,"")+"]");
       idjson= json.sort(function(a, b) {
                 return parseFloat(b['id']) - parseFloat(a['id']);
              })[0]['id']+1;
      }
      
      jsonn='{"id":'+idjson+',"imputado":'+imputado+',"medida":"'+$("#causa_H_medidas_cautelares.imp"+imputado).val()+'",'+
      '"tipo":"' +$("#causa_H_tipo_medidas_cautelares.imp"+imputado).val()+'",'+
      '"temporalidad":"' +$("#causa_H_temporalidad_medida.imp"+imputado).val()+'"}';

      $("#hdnMedidas"+imputado).val($("#hdnMedidas"+imputado).val()+jsonn+",");        

      var newrow="<tr class='tr"+imputado+"_"+idjson+"'><td>"+$("#causa_H_medidas_cautelares.imp"+imputado+" :selected").text()+
      "</td><td>"+$("#causa_H_tipo_medidas_cautelares.imp"+imputado+" :selected").text()+"</td>"+
        "<td>"+$("#causa_H_temporalidad_medida.imp"+imputado+" :selected").text()+"</td>"+
        "<td><button type='button' title='Eliminar medida' class='btn btn-danger' "+
        "onclick='eliminarMedida(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";

      $("#medidas"+imputado+" tbody").append(newrow);
      $("#causa_H_medidas_cautelares.imp"+imputado).val(-1);
      $("#causa_H_tipo_medidas_cautelares.imp"+imputado).val(-1);
      $("#causa_H_temporalidad_medida.imp"+imputado).val(-1);
    }
  }
  function eliminarMedida(imputado,id,DB=0)
  {
    if (DB==1) {
      eliminarReload(id,'cpaime');
    }
    else
    {
      var json=JSON.parse("["+$("#hdnMedidas"+imputado).val().replace(/,+$/,"")+"]");
      var filtro=json.filter(function(arr){return arr.id!=id});
      $("#hdnMedidas"+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
      window.event.target.parentElement.parentElement.remove();
      //$('.tr'+imputado+"_"+id).remove();                
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

