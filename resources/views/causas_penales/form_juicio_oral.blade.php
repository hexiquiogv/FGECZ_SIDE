
<div class="row causasJuicio">
  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Suspensión de juicio</h4>
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
      <form method='post' name="frmCausasPenalesJO_S_0" id="frmCausasPenalesJO_S_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="row">
            @csrf  
          <input type="hidden" name="idImputadoJO" id="idImputadoJO" value="0">
          <input type="hidden" name="idImputado" id="idImputado" value="">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="S">

          <div class="mb-3 col-12">
            <div class="accordion" id="accordionFiltrosSuspension_0">
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsFiltrosSuspension_0">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                  data-bs-target="#panelsStayOpen-collapseOneSuspension_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneSuspension_0">
                    Listado de Causas de Suspensión
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOneSuspension_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosSuspension_0">
                  <div class="accordion-body row">
                    <div class="col-sm-12 input-group">                                 
                        <label for="causa_H_fecha_suspension" class="input-group-text">Fecha en que se suspendió el juicio:</label>
                        <input type="date" class="form-control imp0" name="causa_H_fecha_suspension" 
                          id="causa_H_fecha_suspension">
                    </div>
                    <div class="col-sm-12 input-group">
                        <label for="causa_H_causas_suspension" class="input-group-text">Causas de suspensión del juicio:</label>
                        <input type="text" class="form-control imp0 nonum" name="causa_H_causas_suspension" 
                          id="causa_H_causas_suspension">
                    </div>
                    <div class="col-sm-12 input-group">                          
                        <label for="causa_H_reanudacion_juicio" class="input-group-text">Fecha de reanudación del juicio:</label>
                        <input type="date" class="form-control imp0 noValidate" name="causa_H_reanudacion_juicio" 
                          id="causa_H_reanudacion_juicio">                          
                      <button type="button" class="btn btn-primary"onclick="javascript:addCausaS(0)">
                        Agregar causas de suspensión
                      </button>
                    </div> 
                    <input type="hidden" name="hdnSuspension0" id="hdnSuspension0">
                    <table id="Suspension0" class="col-12 table table-striped table-hover table-responsive caption-top">
                        <caption></caption>    
                        <thead class="table-light">
                        <tr>
                          <th scope="col">Fecha en que se suspendió el juicio</th>
                          <th scope="col">Causa de suspensión</th>
                          <th scope="col">Fecha de reanudación del juicio</th>
                          <th scope="col">Eliminar</th>
                        </tr>
                      </thead>
                      <tbody> 

                      </tbody>
                    </table> 
                    <div class="pt-2 modal-footer">
                      <button type="submit" class="btn btn-primary">Guardar</button>
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
     <div class="accordion mb-2" id="accordionFiltrosAudienciaI_S_{{$imputado->id}}">
      <div class="accordion-item">
        <h2 class="accordion-header" id="panelsFiltrosAudienciaI_S_{{$imputado->id}}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
          data-bs-target="#panelsStayOpen-collapseOneAudienciaI_S_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaI_S_{{$imputado->id}}">
            Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOneAudienciaI_S_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaI_S_{{$imputado->id}}">
         <form method='post' name="frmCausasPenalesJO_S_{{$imputado->id}}" id="frmCausasPenalesJO_S_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoJO" id="idImputadoJO" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="S">

            <div class="mb-3 col-12">
              <div class="accordion" id="accordionFiltrosSuspension_{{$imputado->id}}">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsFiltrosSuspension_{{$imputado->id}}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#panelsStayOpen-collapseOneSuspension_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneSuspension_{{$imputado->id}}">
                      Listado de Causas de Suspensión
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseOneSuspension_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosSuspension_{{$imputado->id}}">
                    <div class="accordion-body row">
                      <div class="col-sm-12 input-group">                                 
                          <label for="causa_H_fecha_suspension" class="input-group-text">Fecha en que se suspendió el juicio:</label>
                          <input type="date" class="form-control imp{{$imputado->id}}" name="causa_H_fecha_suspension" 
                            id="causa_H_fecha_suspension">
                      </div>
                      <div class="col-sm-12 input-group">
                          <label for="causa_H_causas_suspension" class="input-group-text">Causas de suspensión del juicio:</label>
                          <input type="text" class="form-control imp{{$imputado->id}} nonum" name="causa_H_causas_suspension" 
                            id="causa_H_causas_suspension">
                      </div>
                      <div class="col-sm-12 input-group">                          
                          <label for="causa_H_reanudacion_juicio" class="input-group-text">Fecha de reanudación del juicio:</label>
                          <input type="date" class="form-control imp{{$imputado->id}} noValidate" name="causa_H_reanudacion_juicio" 
                            id="causa_H_reanudacion_juicio">                          
                        <button type="button" class="btn btn-primary"onclick="javascript:addCausaS({{$imputado->id}})">
                          Agregar causas de suspensión
                        </button>
                      </div> 
                      <input type="hidden" name="hdnSuspension{{$imputado->id}}" id="hdnSuspension{{$imputado->id}}">
                      <table id="Suspension{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
                          <caption></caption>    
                          <thead class="table-light">
                          <tr>
                            <th scope="col">Fecha en que se suspendió el juicio</th>
                            <th scope="col">Causa de suspensión</th>
                            <th scope="col">Fecha de reanudación del juicio</th>
                            <th scope="col">Eliminar</th>
                          </tr>
                        </thead>
                        <tbody> 
                        @if(isset($suspension[$imputado->id]))
                         @foreach ($suspension[$imputado->id] as $causa)
                          <tr class="tr{{$imputado->id}}_{{$causa->id}}">
                            <td>{{$causa->FECHA_SUSPENSION}}</td>
                            <td>{{$causa->CAUSAS_SUSPENSION}}</td>
                            <td>{{$causa->REANUDACION_JUICIO}}</td>
                            <td>
                              <button type="button" title="Eliminar causa" class="btn btn-danger" 
                              onclick="eliminarCausaS('{{$imputado->id}}','{{$causa->id}}',1)">×</button>
                            </td>
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

            <div class="border-top pt-2 modal-footer">
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div> 
          </div>
         </form>
        </div>
      </div>
     </div>
      <script type="text/javascript">  

      </script>
    @endforeach


  <div class="mb-4 col-12 pestanaBase">
    <div class="pestanaTop">
      <h4>Pruebas</h4>
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
      <form method='post' name="frmCausasPenalesJO_P_0" id="frmCausasPenalesJO_P_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="row">
            @csrf  
          <input type="hidden" name="idImputadoJO" id="idImputadoJO" value="0">
          <input type="hidden" name="idImputado" id="idImputado" value="">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="P">
          <div class="mb-3 col-12">
            <div class="accordion" id="accordionFiltrosPruebas_0">
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsFiltrosPruebas_0">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                  data-bs-target="#panelsStayOpen-collapseOnePruebas_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOnePruebas_0">
                    Listado de pruebas
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOnePruebas_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosPruebas_0">
                  <div class="accordion-body row">
                    <div class="col-sm-12 input-group">
                        <label for="causa_H_fecha_pruebas" class="input-group-text">Fecha en que se presentó la prueba:</label>
                        <input type="date" class="form-control imp0" name="causa_H_fecha_pruebas" 
                          id="causa_H_fecha_pruebas">                      
                      <label for="causa_H_tipos_de_pruebas" class="input-group-text">Tipos de pruebas desahogadas:</label>
                      <select class="form-select imp0" name="causa_H_tipos_de_pruebas" id="causa_H_tipos_de_pruebas">
                        <option value="-1">Seleccione una opción</option>
                        @foreach ($tipoPruebas as $item)      
                          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                        @endforeach                 
                     </select>

                    </div>
                    <div class="col-sm-12 input-group">                      
                      <label for="causa_H_actor_pruebas" class="input-group-text">Actor que las presenta:</label>
                      <!-- <input type="text" class="form-control imp0 nonum" name="causa_H_actor_pruebas" id="causa_H_actor_pruebas" placeholder=""> -->
                      <select class="form-select imp0" name="causa_H_actor_pruebas" id="causa_H_actor_pruebas">
                        <option value="-1">Seleccione una opción</option>
                        @foreach ($actorPruebas as $item)      
                          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                        @endforeach                 
                     </select>

                    </div>
                    <div class="col-sm-12 input-group">
                      <label for="causa_H_cantidad_pruebas" class="input-group-text">Cantidad de pruebas:</label>
                      <input type="text" class="form-control anios imp0" name="causa_H_cantidad_pruebas" 
                      id="causa_H_cantidad_pruebas" placeholder="">                      
                      <button type="button" class="btn btn-primary"onclick="javascript:addPrueba(0)">
                        Agregar pruebas
                      </button>
                    </div> 
                    <input type="hidden" name="hdnPruebas0" id="hdnPruebas0">
                    <table id="pruebas0" class="col-12 table table-striped table-hover table-responsive caption-top">
                        <caption></caption>    
                        <thead class="table-light">
                        <tr>
                          <th scope="col">Tipo de pruebas desahogadas</th>
                          <th scope="col">Actor que las presenta</th>
                          <th scope="col">Fecha en que se presentó la prueba</th>
                          <th scope="col">Cantidad de pruebas</th>
                          <th scope="col">Eliminar</th>
                        </tr>
                      </thead>
                      <tbody> 
                       
                      </tbody>
                    </table>  
                    <div class="pt-2 modal-footer">
                      <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

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
         <form method='post' name="frmCausasPenalesJO_P_{{$imputado->id}}" id="frmCausasPenalesJO_P_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoJO" id="idImputadoJO" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="P">
          <div class="mb-3 col-12">

            <div class="accordion" id="accordionFiltrosPruebas_{{$imputado->id}}">
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsFiltrosPruebas_{{$imputado->id}}">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                  data-bs-target="#panelsStayOpen-collapseOnePruebas_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOnePruebas_{{$imputado->id}}">
                    Listado de pruebas
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOnePruebas_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosPruebas_{{$imputado->id}}">
                  <div class="accordion-body row">
                    <div class="col-sm-12 input-group">
                        <label for="causa_H_fecha_pruebas" class="input-group-text">Fecha en que se presentó la prueba:</label>
                        <input type="date" class="form-control imp{{$imputado->id}}" name="causa_H_fecha_pruebas" 
                          id="causa_H_fecha_pruebas">                      
                      <label for="causa_H_tipos_de_pruebas" class="input-group-text">Tipos de pruebas desahogadas:</label>
                      <select class="form-select imp{{$imputado->id}}" name="causa_H_tipos_de_pruebas" id="causa_H_tipos_de_pruebas">
                        <option value="-1">Seleccione una opción</option>
                        @foreach ($tipoPruebas as $item)      
                          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                        @endforeach                 
                     </select>

                    </div>
                    <div class="col-sm-12 input-group">                      
                      <label for="causa_H_actor_pruebas" class="input-group-text">Actor que las presenta:</label>
                      <!-- <input type="text" class="form-control imp0 nonum" name="causa_H_actor_pruebas" id="causa_H_actor_pruebas" placeholder=""> -->
                      <select class="form-select imp{{$imputado->id}}" name="causa_H_actor_pruebas" id="causa_H_actor_pruebas">
                        <option value="-1">Seleccione una opción</option>
                        @foreach ($actorPruebas as $item)      
                          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                        @endforeach                 
                     </select>

                    </div>
                    <div class="col-sm-12 input-group">
                      <label for="causa_H_cantidad_pruebas" class="input-group-text">Cantidad de pruebas:</label>
                      <input type="text" class="form-control anios imp{{$imputado->id}}" name="causa_H_cantidad_pruebas" 
                      id="causa_H_cantidad_pruebas" placeholder="">                      
                      <button type="button" class="btn btn-primary"onclick="javascript:addPrueba({{$imputado->id}})">
                        Agregar pruebas
                      </button>
                    </div> 
                    <input type="hidden" name="hdnPruebas{{$imputado->id}}" id="hdnPruebas{{$imputado->id}}">
                    <table id="pruebas{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
                        <caption></caption>    
                        <thead class="table-light">
                        <tr>
                          <th scope="col">Tipo de pruebas desahogadas</th>
                          <th scope="col">Actor que las presenta</th>
                          <th scope="col">Fecha en que se presentó la prueba</th>
                          <th scope="col">Cantidad de pruebas</th>
                          <th scope="col">Eliminar</th>
                        </tr>
                      </thead>
                      <tbody> 
                      @if(isset($pruebas[$imputado->id]))
                       @foreach ($pruebas[$imputado->id] as $prueba)
                        <tr class="tr{{$imputado->id}}_{{$prueba->id}}">
                          <td>{{$prueba->PRUEBA}}</td>
                          <td>{{$prueba->ACTOR}}</td>
                          <td>{{$prueba->FECHA_PRUEBAS}}</td>
                          <td>{{$prueba->CANTIDAD}}</td>
                          <td>
                            <button type="button" title="Eliminar prueba" class="btn btn-danger" 
                            onclick="eliminarPrueba('{{$imputado->id}}','{{$prueba->id}}',1)">×</button>
                          </td>
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

            <div class="border-top pt-2 modal-footer">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            </div> 
          </div>
         </form>
        </div>
      </div>
     </div>
      <script type="text/javascript">  

      </script>
    @endforeach

  {{--
   <form method='post' name="frmCausasPenalesJO" id="frmCausasPenalesJO" action="{{ route('saveCP') }}" enctype="multipart/form-data">
    <div class="row">
      @csrf   
      <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
      <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
      <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">      

            <div class="mb-4 col-12 pestanaBase">
              <div class="pestanaTop">
                <h4>Suspensión de juicio</h4>
              </div>
            </div>   
            <div class="mb-3 col-12">
              <div class="accordion" id="accordionFiltrosSuspension_0">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsFiltrosSuspension_0">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#panelsStayOpen-collapseOneSuspension_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneSuspension_0">
                      Listado de Causas de Suspensión
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseOneSuspension_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosSuspension_0">
                    <div class="accordion-body row">
                      <div class="col-sm-12 input-group">                                 
                          <label for="causa_H_fecha_suspension" class="input-group-text">Fecha en que se suspendió el juicio:</label>
                          <input type="date" class="form-control imp0" name="causa_H_fecha_suspension" 
                            id="causa_H_fecha_suspension">
                      </div>
                      <div class="col-sm-12 input-group">
                          <label for="causa_H_causas_suspension" class="input-group-text">Causas de suspensión del juicio:</label>
                          <input type="text" class="form-control imp0 nonum" name="causa_H_causas_suspension" 
                            id="causa_H_causas_suspension">
                      </div>
                      <div class="col-sm-12 input-group">                          
                          <label for="causa_H_reanudacion_juicio" class="input-group-text">Fecha de reanudación del juicio:</label>
                          <input type="date" class="form-control imp0" name="causa_H_reanudacion_juicio" 
                            id="causa_H_reanudacion_juicio">                          
                        <button type="button" class="btn btn-primary"onclick="javascript:addCausaS(0)">
                          Agregar causas de suspensión
                        </button>
                      </div> 
                      <input type="hidden" name="hdnSuspension0" id="hdnSuspension0">
                      <table id="Suspension0" class="col-12 table table-striped table-hover table-responsive caption-top">
                          <caption></caption>    
                          <thead class="table-light">
                          <tr>
                            <th scope="col">Fecha en que se suspendió el juicio</th>
                            <th scope="col">Causa de suspensión</th>
                            <th scope="col">Fecha de reanudación del juicio</th>
                            <th scope="col">Eliminar</th>
                          </tr>
                        </thead>
                        <tbody> 

                         @foreach ($suspension as $causa)            
                          <tr class="tr0_{{$causa->id}}">
                            <td>{{$causa->FECHA_SUSPENSION}}</td>
                            <td>{{$causa->CAUSAS_SUSPENSION}}</td>
                            <td>{{$causa->REANUDACION_JUICIO}}</td>
                            <td>
                              <button type="button" title="Eliminar causa" class="btn btn-danger" 
                              onclick="eliminarCausaS('0','{{$causa->id}}',1)">×</button>
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
            <div class="mb-4 col-12 pestanaBase">
              <div class="pestanaTop">
                <h4>Pruebas</h4>
              </div>
            </div>   
            <div class="mb-3 col-12">

              <div class="accordion" id="accordionFiltrosPruebas_0">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsFiltrosPruebas_0">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#panelsStayOpen-collapseOnePruebas_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOnePruebas_0">
                      Listado de pruebas
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseOnePruebas_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosPruebas_0">
                    <div class="accordion-body row">
                      <div class="col-sm-12 input-group">
                          <label for="causa_H_fecha_pruebas" class="input-group-text">Fecha en que se presentó la prueba:</label>
                          <input type="date" class="form-control imp0" name="causa_H_fecha_pruebas" 
                            id="causa_H_fecha_pruebas">                      
                        <label for="causa_H_tipos_de_pruebas" class="input-group-text">Tipos de pruebas desahogadas:</label>
                        <select class="form-select imp0" name="causa_H_tipos_de_pruebas" id="causa_H_tipos_de_pruebas">
                          <option value="-1">Seleccione una opción</option>
                          @foreach ($tipoPruebas as $item)      
                            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                          @endforeach                 
                       </select>

                      </div>
                      <div class="col-sm-12 input-group">                      
                        <label for="causa_H_actor_pruebas" class="input-group-text">Actor que las presenta:</label>
                        <!-- <input type="text" class="form-control imp0 nonum" name="causa_H_actor_pruebas" id="causa_H_actor_pruebas" placeholder=""> -->
                        <select class="form-select imp0" name="causa_H_actor_pruebas" id="causa_H_actor_pruebas">
                          <option value="-1">Seleccione una opción</option>
                          @foreach ($actorPruebas as $item)      
                            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                          @endforeach                 
                       </select>

                      </div>
                      <div class="col-sm-12 input-group">
                        <label for="causa_H_cantidad_pruebas" class="input-group-text">Cantidad de pruebas:</label>
                        <input type="text" class="form-control anios imp0" name="causa_H_cantidad_pruebas" 
                        id="causa_H_cantidad_pruebas" placeholder="">                      
                        <button type="button" class="btn btn-primary"onclick="javascript:addPrueba(0)">
                          Agregar pruebas
                        </button>
                      </div> 
                      <input type="hidden" name="hdnPruebas0" id="hdnPruebas0">
                      <table id="pruebas0" class="col-12 table table-striped table-hover table-responsive caption-top">
                          <caption></caption>    
                          <thead class="table-light">
                          <tr>
                            <th scope="col">Tipo de pruebas desahogadas</th>
                            <th scope="col">Actor que las presenta</th>
                            <th scope="col">Fecha en que se presentó la prueba</th>
                            <th scope="col">Cantidad de pruebas</th>
                            <th scope="col">Eliminar</th>
                          </tr>
                        </thead>
                        <tbody> 

                         @foreach ($pruebas as $prueba)            
                          <tr class="tr0_{{$prueba->id}}">
                            <td>{{$prueba->PRUEBA}}</td>
                            <td>{{$prueba->ACTOR}}</td>
                            <td>{{$prueba->FECHA_PRUEBAS}}</td>
                            <td>{{$prueba->CANTIDAD}}</td>
                            <td>
                              <button type="button" title="Eliminar prueba" class="btn btn-danger" 
                              onclick="eliminarPrueba('0','{{$prueba->id}}',1)">×</button>
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

      <div class="border-bottom py-2 mb-4 modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div> 
    </div>       
   </form>  
  --}}
    <div class="mb-4 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Sentencia</h4>
      </div>
    </div>

  {{--  <div class="mb-3 input-group">    
      <label for="ddlImputados" class="input-group-text">Imputado:</label>        
      <select class="form-select" id="ddlImputados" name="ddlImputados">
        <option value="-1">Seleccione una opción</option>
        @foreach ($listados['imputadosDDL'] as $item)      
          <option value="{{$item->id}}" data-tiempo="{{floor($item->tiempo??0)}}">{{$item->Valor}}</option>
        @endforeach
      </select>
      <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button>
    </div> 
  --}}
    <div class="mb-3 input-group {{count($listados['imputadosDDL'])<1?'d-none':''}}">
      <label for="ddlImputados_N" class="input-group-text">Imputado:</label>        
      <select class="form-select" id="ddlImputados_N" name="ddlImputados_N" onchange="javascript:addImputadoFormModal('_N')">
        <option value="-1">Seleccione una opción</option>
        @foreach ($listados['imputadosDDL'] as $item)      
          <option value="{{$item->id}}" data-tiempo="{{floor($item->tiempo??0)}}" data-forma="{{$item->FORMA_}}"
            data-detencion="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
        @endforeach       
      </select>
      <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button> -->
    </div>
    <div id="addImputadoForm_N" style="display: none;">
      <form method='post' name="frmCausasPenalesJO_N_0" id="frmCausasPenalesJO_N_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="row">
            @csrf  
          <input type="hidden" name="idImputadoJO" id="idImputadoJO" value="0">
          <input type="hidden" name="idImputado" id="idImputado" value="">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="N">
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_fecha_sentencia" class="form-label">Fecha en que se dictó la sentencia:</label>
              <input type="date" class="form-control" name="causa_H_fecha_sentencia" id="causa_H_fecha_sentencia" value="">
            </div> 
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_libertad_condicional" class="form-label">Libertad condicional:</label>
              <select class="form-select" name="causa_H_libertad_condicional" id="causa_H_libertad_condicional">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNo as $item)      
                  <option value="{{ $item->id }}">
                    {{$item->Valor}}</option>      
                @endforeach              
             </select>
            </div> 
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_tipo_sentencia" class="form-label">Tipo de sentencia:</label>
              <select class="form-select" name="causa_H_tipo_sentencia" id="causa_H_tipo_sentencia">
                <option value="-1">Seleccione una opción</option>
                @foreach ($tipoSentencia as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach                
             </select>
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 condena" style="display:none;">
              <label for="causa_H_sentencia_condenatoria" class="form-label">Sentencia condenatoria (pena impuesta):</label>
              <input type="text" class="form-control temporalidadMA" name="causa_H_sentencia_condenatoria" 
               id="causa_H_sentencia_condenatoria" placeholder="xx años o meses">
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 condena" style="display:none;">
              <label for="causa_H_firme" class="form-label">¿La sentencia se encuentra firme?</label>
              <select class="form-select" name="causa_H_firme" id="causa_H_firme">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNoNoI as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach                
             </select>
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 condena" style="display:none;">
              <label for="causa_H_tiempo" class="form-label">Tiempo transcurrido en prisión (años):</label>
              <input disabled type="text" class="form-control anios" name="causa_H_tiempo" id="causa_H_tiempo" placeholder="">
            </div>
            <div class="mb-3 col-12 obsForm" style="display:none;">
              <label for="causa_H_observaciones" class="form-label">Observaciones sentencia absolutoria:</label>
              <textarea type="textarea" class="form-control" maxlength="255" rows="2" name="causa_H_observaciones" 
              id="causa_H_observaciones" placeholder=""></textarea>
                @if($errors->has('causa_H_observaciones'))
                 <span class="text-danger">{{ $errors->first('causa_H_observaciones') }}</span>
                @endif
            </div>  
          <div class="border-top pt-2 modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </div>
      </form> 
    </div>

  @foreach($listados['imputadosCP'] as $imputado)
   <div class="accordion mb-2" id="accordionFiltrosJuicio_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosJuicio_{{$imputado->id}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneJuicio_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneJuicio_{{$imputado->id}}">
        Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneJuicio_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosJuicio_{{$imputado->id}}">
       <form method='post' name="frmCausasPenalesJO_N_{{$imputado->id}}" id="frmCausasPenalesJO_N_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="accordion-body row">
          @csrf  
          <input type="hidden" name="idImputadoJO" id="idImputadoJO" value="{{$imputado->id}}">
          <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="N">
          {{--
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_juicio_oral" class="form-label">Auto de apertura a juicio oral:</label>
              <select class="form-select" name="causa_H_juicio_oral" id="causa_H_juicio_oral">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNoNoI as $item)      
                  <option value="{{ $item->id }}" 
                    {{isset($imputado->JUICIO_ORAL)?$imputado->JUICIO_ORAL==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
                @endforeach
             </select>
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_auto_de_apertura" class="form-label">Fecha de auto de apertura:</label>
              <input type="date" class="form-control" name="causa_H_auto_de_apertura" id="causa_H_auto_de_apertura" 
                value="{{$imputado->AUTO_DE_APERTURA??''}}">
            </div> 
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_fecha_audiencia_juicio" class="form-label">Fecha de la celebración de la audiencia de juicio:</label>
              <input type="date" class="form-control" name="causa_H_fecha_audiencia_juicio" id="causa_H_fecha_audiencia_juicio" 
                value="{{$imputado->FECHA_AUDIENCIA_JUICIO??''}}">
            </div>  

            <div class="mb-4 col-12 pestanaBase">
              <div class="pestanaTop">
                <h4>Suspensión de juicio</h4>
              </div>
            </div>   
            <div class="mb-3 col-12">
              @include("causas_penales.juicio_oral.suspension")
            </div>
            <div class="mb-4 col-12 pestanaBase">
              <div class="pestanaTop">
                <h4>Pruebas</h4>
              </div>
            </div>   
          	<div class="mb-3 col-12">
          		@include("causas_penales.juicio_oral.pruebas")
          	</div>
          --}}
          <div class="mb-4 col-12 pestanaBase d-none">
            <div class="pestanaTop">
              <h4>Sentencia</h4>
            </div>
          </div>   
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_fecha_sentencia" class="form-label">Fecha en que se dictó la sentencia:</label>
            <input type="date" class="form-control" name="causa_H_fecha_sentencia" id="causa_H_fecha_sentencia" 
             value="{{$imputado->FECHA_SENTENCIA??''}}">
          </div> 
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_libertad_condicional" class="form-label">Libertad condicional:</label>
            <select class="form-select" name="causa_H_libertad_condicional" id="causa_H_libertad_condicional">
              <option value="-1">Seleccione una opción</option>
              @foreach ($SiNo as $item)      
                <option value="{{ $item->id }}" 
                  {{isset($imputado->LIBERTAD_CONDICIONAL)?$imputado->LIBERTAD_CONDICIONAL==$item->id ?'selected':'':''}}>
                  {{$item->Valor}}</option>      
              @endforeach              
           </select>
          </div>          
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_tipo_sentencia" class="form-label">Tipo de sentencia:</label>
            <select class="form-select" name="causa_H_tipo_sentencia" id="causa_H_tipo_sentencia">
              <option value="-1">Seleccione una opción</option>
              @foreach ($tipoSentencia as $item)      
                <option value="{{ $item->id }}" 
                  {{isset($imputado->TIPO_SENTENCIA)?$imputado->TIPO_SENTENCIA==$item->id ?'selected':'':''}}>
                  {{$item->Valor}}</option>      
              @endforeach              
           </select>
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 condena" style="display:none;">
            <label for="causa_H_sentencia_condenatoria" class="form-label">Sentencia condenatoria (pena impuesta):</label>
            <input type="text" class="form-control temporalidadMA" name="causa_H_sentencia_condenatoria" 
             id="causa_H_sentencia_condenatoria" placeholder="xx años o meses" value="{{$imputado->SENTENCIA_CONDENATORIA??''}}">
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 condena" style="display:none;">
            <label for="causa_H_firme" class="form-label">¿La sentencia se encuentra firme?</label>
            <select class="form-select" name="causa_H_firme" id="causa_H_firme">
              <option value="-1">Seleccione una opción</option>
              @foreach ($SiNoNoI as $item)      
                <option value="{{ $item->id }}" 
                  {{isset($imputado->FIRME)?$imputado->FIRME==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
              @endforeach              
           </select>
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 condena" style="display:none;">
        	  <label for="causa_H_tiempo" class="form-label">Tiempo transcurrido en prisión (años):</label>
        	  <input disabled type="text" class="form-control anios" name="causa_H_tiempo" id="causa_H_tiempo" 
              placeholder="" value="{{$imputado->TIEMPO??''}}">
          </div>
          <div class="mb-3 col-12 obsForm" style="display:none;">
            <label for="causa_H_observaciones" class="form-label">Observaciones sentencia absolutoria:</label>
            <textarea type="textarea" class="form-control" maxlength="255" rows="2" name="causa_H_observaciones" id="causa_H_observaciones" 
            placeholder="">{{$imputado->OBSERVACIONES??''}}</textarea>
              @if($errors->has('causa_H_observaciones'))
               <span class="text-danger">{{ $errors->first('causa_H_observaciones') }}</span>
              @endif
          </div>
          {{--
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_fecha_proced_abrev" class="form-label">Fecha en que se dictó el procedimiento abreviado:</label>
              <input type="date" class="form-control" name="causa_H_fecha_proced_abrev" id="causa_H_fecha_proced_abrev" 
                value="{{$imputado->FECHA_PROCED_ABREV??''}}">
            </div> 


            <div class="mb-4 col-12 pestanaBase">
              <div class="pestanaTop">
                <h4>Recurso</h4>
              </div>
            </div> 
            <div class="mb-3 col-12">
              @include("causas_penales.juicio_oral.recursos")
            </div>  
          --}}
          <div class="border-top pt-2 modal-footer">
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div>
        </div>
       </form>
      </div>
    </div>
   </div>
   <script type="text/javascript">

    $("#frmCausasPenalesJO_N_{{$imputado->id}} #causa_H_tipo_sentencia").change(function() {
      if (this.value==1) {
      $("#frmCausasPenalesJO_N_{{$imputado->id}} .obsForm").show();
      $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena").hide();
      $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena #causa_H_sentencia_condenatoria").val('');
      $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena #causa_H_firme").val(-1);
      // $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena #causa_H_tiempo").val('');
      }
      else if (this.value==2) {
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena").show(); 
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .obsForm").hide();
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .obsForm textarea").val('');      
      }
      else
      {
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .obsForm").hide();
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .obsForm textarea").val('');
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena").hide();
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena #causa_H_sentencia_condenatoria").val('');
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena #causa_H_firme").val(-1);
        // $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena #causa_H_tiempo").val('');      
      }
    });

      if ($("#frmCausasPenalesJO_N_{{$imputado->id}} #causa_H_tipo_sentencia").val()==1) {
      $("#frmCausasPenalesJO_N_{{$imputado->id}} .obsForm").show();
      $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena").hide();
      $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena #causa_H_sentencia_condenatoria").val('');
      $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena #causa_H_firme").val(-1);
      // $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena #causa_H_tiempo").val('');
      }
      else if ($("#frmCausasPenalesJO_N_{{$imputado->id}} #causa_H_tipo_sentencia").val()==2) {
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena").show(); 
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .obsForm").hide();
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .obsForm textarea").val('');      
      }
      else
      {
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .obsForm").hide();
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .obsForm textarea").val('');
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena").hide();
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena #causa_H_sentencia_condenatoria").val('');
        $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena #causa_H_firme").val(-1);
        // $("#frmCausasPenalesJO_N_{{$imputado->id}} .condena #causa_H_tiempo").val('');      
      }

   </script>
 
  @endforeach
</div>
<div class="modal fade" id="addImputadoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
aria-labelledby="addImputadoFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-fullscreen"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addImputadoFormLabel">Datos del juicio oral del imputado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method='post' name="frmCausasPenalesJO_0" id="frmCausasPenalesJO_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
          <div class="row">
              @csrf  
            <input type="hidden" name="idImputadoJO" id="idImputadoJO" value="0">
            <input type="hidden" name="idImputado" id="idImputado" value="">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="N">
          {{--
              <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                <label for="causa_H_juicio_oral" class="form-label">Auto de apertura a juicio oral:</label>
                <select class="form-select" name="causa_H_juicio_oral" id="causa_H_juicio_oral">
                  <option value="-1">Seleccione una opción</option>
                  @foreach ($SiNoNoI as $item)      
                    <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                  @endforeach
               </select>
              </div>
              <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                <label for="causa_H_auto_de_apertura" class="form-label">Fecha de auto de apertura:</label>
                <input type="date" class="form-control" name="causa_H_auto_de_apertura" id="causa_H_auto_de_apertura" value="">
              </div> 
              <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                <label for="causa_H_fecha_audiencia_juicio" class="form-label">Fecha de la celebración de la audiencia de juicio:</label>
                <input type="date" class="form-control" name="causa_H_fecha_audiencia_juicio" id="causa_H_fecha_audiencia_juicio" value="">
              </div> 
             
              <div class="mb-4 col-12 pestanaBase">
                <div class="pestanaTop">
                  <h4>Suspensión de juicio</h4>
                </div>
              </div>   
              <div class="mb-3 col-12">
                <div class="accordion" id="accordionFiltrosSuspension_0">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsFiltrosSuspension_0">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                      data-bs-target="#panelsStayOpen-collapseOneSuspension_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneSuspension_0">
                        Listado de Causas de Suspensión
                      </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOneSuspension_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosSuspension_0">
                      <div class="accordion-body row">
                        <div class="mb-3 col-sm-12 input-group">
                            <label for="causa_H_suspension_juicio" class="input-group-text">Suspensión del juicio:</label>
                            <select class="form-select imp0" name="causa_H_suspension_juicio" id="causa_H_suspension_juicio">
                              <option value="-1">Seleccione una opción</option>
                              @foreach ($SiNoNoI as $item)      
                                <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                              @endforeach
                           </select>          
                            <label for="causa_H_causas_suspension" class="input-group-text">Causas de suspensión del juicio:</label>
                            <input type="text" class="form-control imp0 nonum" name="causa_H_causas_suspension" 
                              id="causa_H_causas_suspension" placeholder="">
                          <button type="button" class="btn btn-outline-primary"onclick="javascript:addCausaS(0)">
                            Agregar causas de suspensión
                          </button>
                        </div> 
                        <input type="hidden" name="hdnSuspension0" id="hdnSuspension0">
                        <table id="Suspension0" class="col-12 table table-striped table-hover table-responsive caption-top">
                            <caption></caption>    
                            <thead class="table-light">
                            <tr>
                              <th scope="col">Suspensión del Juicio</th>
                              <th scope="col">Causa de suspensión</th>
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
                  <h4>Pruebas</h4>
                </div>
              </div>   
              <div class="mb-3 col-12">
                <div class="accordion" id="accordionFiltrosPruebas_0">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsFiltrosPruebas_0">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                      data-bs-target="#panelsStayOpen-collapseOnePruebas_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOnePruebas_0">
                        Listado de pruebas
                      </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOnePruebas_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosPruebas_0">
                      <div class="accordion-body row">

                          <div class="mb-3 col-sm-12 input-group">
                            <label for="causa_H_tipos_de_pruebas" class="input-group-text">Tipos de pruebas desahogadas:</label>
                            <select class="form-select imp0" name="causa_H_tipos_de_pruebas" id="causa_H_tipos_de_pruebas">
                              <option value="-1">Seleccione una opción</option>
                              @foreach ($tipoPruebas as $item)      
                                <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                              @endforeach                 
                           </select>
                            <label for="causa_H_actor_pruebas" class="input-group-text">Actor que las presenta:</label>
                            <input type="text" class="form-control imp0 nonum" name="causa_H_actor_pruebas" id="causa_H_actor_pruebas" placeholder="">
                            <button type="button" class="btn btn-outline-primary" onclick="javascript:addPrueba(0)">
                              Agregar pruebas
                            </button>
                          </div> 
                          <input type="hidden" name="hdnPruebas0" id="hdnPruebas0">
                          <table id="pruebas0" class=" col-12 table table-striped table-hover table-responsive caption-top">
                              <caption></caption>    
                              <thead class="table-light">
                              <tr>
                                <th scope="col">Tipo de pruebas desahogadas</th>
                                <th scope="col">Actor que las presenta</th>
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
          --}}            
            <div class="mb-4 col-12 pestanaBase">
              <div class="pestanaTop">
                <h4>Sentencia</h4>
              </div>
            </div>   
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_fecha_sentencia" class="form-label">Fecha en que se dictó la sentencia:</label>
              <input type="date" class="form-control" name="causa_H_fecha_sentencia" id="causa_H_fecha_sentencia" value="">
            </div> 
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_libertad_condicional" class="form-label">Libertad condicional:</label>
              <select class="form-select" name="causa_H_libertad_condicional" id="causa_H_libertad_condicional">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNo as $item)      
                  <option value="{{ $item->id }}">
                    {{$item->Valor}}</option>      
                @endforeach              
             </select>
            </div> 
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_tipo_sentencia" class="form-label">Tipo de sentencia:</label>
              <select class="form-select" name="causa_H_tipo_sentencia" id="causa_H_tipo_sentencia">
                <option value="-1">Seleccione una opción</option>
                @foreach ($tipoSentencia as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach                
             </select>
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 condena" style="display:none;">
              <label for="causa_H_sentencia_condenatoria" class="form-label">Sentencia condenatoria (pena impuesta):</label>
              <input type="text" class="form-control temporalidadMA" name="causa_H_sentencia_condenatoria" 
               id="causa_H_sentencia_condenatoria" placeholder="xx años o meses">
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 condena" style="display:none;">
              <label for="causa_H_firme" class="form-label">¿La sentencia se encuentra firme?</label>
              <select class="form-select" name="causa_H_firme" id="causa_H_firme">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNoNoI as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach                
             </select>
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 condena" style="display:none;">
              <label for="causa_H_tiempo" class="form-label">Tiempo transcurrido en prisión (años):</label>
              <input disabled type="text" class="form-control anios" name="causa_H_tiempo" id="causa_H_tiempo" placeholder="">
            </div>
          <div class="mb-3 col-12 obsForm" style="display:none;">
              <label for="causa_H_observaciones" class="form-label">Observaciones sentencia absolutoria:</label>
              <textarea type="textarea" class="form-control" maxlength="255" rows="2" name="causa_H_observaciones" 
              id="causa_H_observaciones" placeholder=""></textarea>
                @if($errors->has('causa_H_observaciones'))
                 <span class="text-danger">{{ $errors->first('causa_H_observaciones') }}</span>
                @endif
            </div>              
          {{--
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_fecha_proced_abrev" class="form-label">Fecha en que se dictó el procedimiento abreviado:</label>
              <input type="date" class="form-control" name="causa_H_fecha_proced_abrev" id="causa_H_fecha_proced_abrev" value="">
            </div> 
  

            <div class="mb-4 col-12 pestanaBase">
              <div class="pestanaTop">
                <h4>Recurso</h4>
              </div>
            </div> 
            <div class="mb-3 col-12">
              <div class="accordion" id="accordionFiltrosRecursos_0">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsFiltrosRecursos_0">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#panelsStayOpen-collapseOneRecursos_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneRecursos_0">
                      Listado de recursos
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseOneRecursos_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosRecursos_0">
                    <div class="accordion-body row">
                      <div class="mb-3 col-sm-12 input-group">
                        <label for="causa_H_fecha_recurso" class="input-group-text">Fecha:</label>
                        <input type="date" class="form-control imp0" name="causa_H_fecha_recurso" id="causa_H_fecha_recurso">
                        <label for="causa_H_tipo_de_recurso" class="input-group-text">Tipo:</label>
                        <select class="form-select imp0" name="causa_H_tipo_de_recurso" id="causa_H_tipo_de_recurso">
                          <option value="-1">Seleccione una opción</option>
                          @foreach ($tipoRecurso as $item)      
                            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                          @endforeach              
                        </select>
                        <label for="causa_H_resolucion_del_recurso" class="input-group-text">Resolución:</label>
                        <input type="text" class="form-control imp0" name="causa_H_resolucion_del_recurso" 
                          id="causa_H_resolucion_del_recurso" maxlength="255">
                        <button type="button" class="btn btn-outline-primary"onclick="javascript:addRecurso(0)">
                          Agregar recurso
                        </button>
                      </div> 
                      <input type="hidden" name="hdnRecursos0" id="hdnRecursos0">
                      <table id="recursos0" class="col-12 table table-striped table-hover table-responsive caption-top">
                          <caption></caption>    
                          <thead class="table-light">
                          <tr>
                            <th scope="col">Fecha de recurso</th>
                            <th scope="col">Tipo de recurso</th>
                            <th scope="col">Resolución del recurso</th>
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
          --}} 
          </div>        
        </form>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="closeaddImputadoForm" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesJO_0').submit()">Guardar</button>
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
        var conjunto = ['frmCausasPenalesJO_P','frmCausasPenalesJO_S'];
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

    if (!respuesta) {showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');}
      return respuesta;
  }    
  $("#frmCausasPenalesJO_N_0 #causa_H_tipo_sentencia").change(function() {
    if (this.value==1) {
      $("#frmCausasPenalesJO_N_0 .obsForm").show();
      $("#frmCausasPenalesJO_N_0 .condena").hide();
      $("#frmCausasPenalesJO_N_0 .condena #causa_H_sentencia_condenatoria").val('');
      $("#frmCausasPenalesJO_N_0 .condena #causa_H_firme").val(-1);
      // $("#frmCausasPenalesJO_N_0 .condena #causa_H_tiempo").val('');

    }
    else if (this.value==2) {
      $("#frmCausasPenalesJO_N_0 .condena").show(); 
      $("#frmCausasPenalesJO_N_0 .obsForm").hide();
      $("#frmCausasPenalesJO_N_0 .obsForm textarea").val('');      
    }
    else
    {
      $("#frmCausasPenalesJO_N_0 .obsForm").hide();
      $("#frmCausasPenalesJO_N_0 .obsForm textarea").val('');
      $("#frmCausasPenalesJO_N_0 .condena").hide();
      $("#frmCausasPenalesJO_N_0 .condena #causa_H_sentencia_condenatoria").val('');
      $("#frmCausasPenalesJO_N_0 .condena #causa_H_firme").val(-1);
      // $("#frmCausasPenalesJO_N_0 .condena #causa_H_tiempo").val('');      
    }
  });

  $(".anios").mask("00");
  $(".monto").mask("#,##0.00",{reverse: true});
  $(".temporalidadMA").mask('TTTT',
      {translation:  {'T': {pattern: /[0-9añosmeAÑOSME\s]/, recursive: true}}});      
  $(".alfanum").mask('XXXX',
      {translation:  {'X': {pattern: /[0-9a-zA-Z\s]/, recursive: true}}}); 
  $(".temporalidad").mask('YYYY',
      {translation:  {'Y': {pattern: /[0-9díiasDÍIAS\s]/, recursive: true}}});      
    $(".nonum").mask('ZZZZ',
      {translation:  {'Z': {pattern: /[a-zA-Z\s]/, recursive: true}}});
    
  function addImputadoFormModal(Seccion)
  {
    if ($("#ddlImputados"+Seccion).val()>-1) {
     $("#frmCausasPenalesJO"+Seccion+"_0 #idImputado").val($("#ddlImputados"+Seccion).val());
     $("#frmCausasPenalesJO"+Seccion+"_0 #causa_H_tiempo").val($("#ddlImputados"+Seccion+" :selected").data().tiempo);
     $("#addImputadoForm"+Seccion).show();
    }
    else{$("#addImputadoForm"+Seccion).hide();}   
  }    
    {{--
     function addImputadoFormModal()
     {
      @if($pruebas->count()>0)
       if ($("#ddlImputados").val()>-1) {
        $("#frmCausasPenalesJO_0 #idImputado").val($("#ddlImputados").val());
        $("#frmCausasPenalesJO_0 #causa_H_tiempo").val($("#ddlImputados :selected").data().tiempo);
        $("#addImputadoForm").modal("show");
       }
      @else
       showtoast('<h6>&times; Es necesario capturar datos de "pruebas" antes de registrar información de sentencia para algún imputado.','danger');
      @endif
     }
    --}}
    function addPrueba(imputado)
    {
     if (validateAddRow("frmCausasPenalesJO_P_"+imputado)){
      if ($("#causa_H_tipos_de_pruebas.imp"+imputado).val()>-1 
            && $("#causa_H_actor_pruebas.imp"+imputado).val()>-1 
            && $("#causa_H_fecha_pruebas.imp"+imputado).val().trim().length>0
            && $("#causa_H_cantidad_pruebas.imp"+imputado).val().trim().length>0) {

        var jsonn="";        
        var idjson=0;
        if ($("#hdnPruebas"+imputado).val().length>0) {
         var json=JSON.parse("["+$("#hdnPruebas"+imputado).val().replace(/,+$/,"")+"]");
         idjson= json.sort(function(a, b) {
                   return parseFloat(b['id']) - parseFloat(a['id']);
                })[0]['id']+1;
        }
        
        jsonn='{"id":'+idjson+',"imputado":'+imputado+
        ',"prueba":"'+$("#causa_H_tipos_de_pruebas.imp"+imputado).val()+'"'+
        ',"actor":"'+$("#causa_H_actor_pruebas.imp"+imputado).val()+'"'+
        ',"fecha":"'+$("#causa_H_fecha_pruebas.imp"+imputado).val().trim()+'"'+
        ',"cantidad":"' +$("#causa_H_cantidad_pruebas.imp"+imputado).val().trim()+'"}';

        $("#hdnPruebas"+imputado).val($("#hdnPruebas"+imputado).val()+jsonn+",");        

        var newrow="<tr class='tr"+imputado+"_"+idjson+"'><td>"+$("#causa_H_tipos_de_pruebas.imp"+imputado+" :selected").text()+"</td>"+
          "<td>"+$("#causa_H_actor_pruebas.imp"+imputado+" :selected").text()+"</td>"+
          "<td>"+$("#causa_H_fecha_pruebas.imp"+imputado).val().trim()+"</td>"+
          "<td>"+$("#causa_H_cantidad_pruebas.imp"+imputado).val().trim()+"</td>"+
          "<td><button type='button' title='Eliminar prueba' class='btn btn-danger' "+
          "onclick='eliminarPrueba(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";

        $("#pruebas"+imputado+" tbody").append(newrow);
        $("#causa_H_tipos_de_pruebas.imp"+imputado).val(-1);
        $("#causa_H_actor_pruebas.imp"+imputado).val(-1);
        $("#causa_H_fecha_pruebas.imp"+imputado).val('');
        $("#causa_H_cantidad_pruebas.imp"+imputado).val('');

      }
     }
    }
    function eliminarPrueba(imputado,id,DB=0)
    {
      if (DB==1) {
        eliminarReload(id,'cpjopb');
      }
      else
      {
        var json=JSON.parse("["+$("#hdnPruebas"+imputado).val().replace(/,+$/,"")+"]");
        var filtro=json.filter(function(arr){return arr.id!=id});
        $("#hdnPruebas"+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
        window.event.target.parentElement.parentElement.remove();
        // $('.tr'+imputado+"_"+id).remove();                
      }
    }

    // function addRecurso(imputado)
    // {
    //   if ($("#causa_H_tipo_de_recurso.imp"+imputado).val()>-1 
    //         && $("#causa_H_fecha_recurso.imp"+imputado).val().trim().length>0
    //         && $("#causa_H_resolucion_del_recurso.imp"+imputado).val().trim().length>0) {

    //     var jsonn="";        
    //     var idjson=0;
    //     if ($("#hdnRecursos"+imputado).val().length>0) {
    //      var json=JSON.parse("["+$("#hdnRecursos"+imputado).val().replace(/,+$/,"")+"]");
    //      idjson= json.sort(function(a, b) {
    //                return parseFloat(b['id']) - parseFloat(a['id']);
    //             })[0]['id']+1;
    //     }
        
    //     jsonn='{"id":'+idjson+',"imputado":'+imputado+',"fecha":"'+$("#causa_H_fecha_recurso.imp"+imputado).val().trim()+'",'+
    //     '"tipo":"' +$("#causa_H_tipo_de_recurso.imp"+imputado).val()+'",'+
    //     '"resolucion":"' +$("#causa_H_resolucion_del_recurso.imp"+imputado).val().trim()+'"}';

    //     $("#hdnRecursos"+imputado).val($("#hdnRecursos"+imputado).val()+jsonn+",");        

    //     var newrow="<tr class='tr"+imputado+"_"+idjson+"'><td>"+$("#causa_H_fecha_recurso.imp"+imputado).val().trim()+"</td><td>"+
    //       $("#causa_H_tipo_de_recurso.imp"+imputado+" :selected").text()+"</td>"+
    //       "<td>"+$("#causa_H_resolucion_del_recurso.imp"+imputado).val().trim()+"</td>"+
    //       "<td><button type='button' title='Eliminar recurso' class='btn btn-danger' "+
    //       "onclick='eliminarRecurso(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";

    //     $("#recursos"+imputado+" tbody").append(newrow);
    //     $("#causa_H_tipo_de_recurso.imp"+imputado).val(-1);
    //     $("#causa_H_fecha_recurso.imp"+imputado).val('');
    //     $("#causa_H_resolucion_del_recurso.imp"+imputado).val('');

    //   }
    // }
    // function eliminarRecurso(imputado,id,DB=0)
    // {
    //   if (DB==1) {
    //     eliminarReload(id,'cpjore');
    //   }
    //   else
    //   {
    //     var json=JSON.parse("["+$("#hdnRecursos"+imputado).val().replace(/,+$/,"")+"]");
    //     var filtro=json.filter(function(arr){return arr.id!=id});
    //     $("#hdnRecursos"+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
    //     window.event.target.parentElement.parentElement.remove();
    //     // $('.tr'+imputado+"_"+id).remove();                
    //   }
    // }

    function addCausaS(imputado)
    {
     if (validateAddRow("frmCausasPenalesJO_S_"+imputado)){      
      //if ($("#causa_H_suspension_juicio.imp"+imputado).val()>-1 
      if ($("#causa_H_fecha_suspension.imp"+imputado).val().trim().length>0
            && $("#causa_H_causas_suspension.imp"+imputado).val().trim().length>0) {

        var jsonn="";        
        var idjson=0;
        if ($("#hdnSuspension"+imputado).val().length>0) {
         var json=JSON.parse("["+$("#hdnSuspension"+imputado).val().replace(/,+$/,"")+"]");
         idjson= json.sort(function(a, b) {
                   return parseFloat(b['id']) - parseFloat(a['id']);
                })[0]['id']+1;
        }
        
        jsonn='{"id":'+idjson+',"imputado":'+imputado+
        ',"fecha":"'+$("#causa_H_fecha_suspension.imp"+imputado).val().trim()+'"'+
        ',"suspension":"'+$("#causa_H_causas_suspension.imp"+imputado).val().trim()+'"'+
        ',"reanudacion":"' +$("#causa_H_reanudacion_juicio.imp"+imputado).val().trim()+'"}';

        $("#hdnSuspension"+imputado).val($("#hdnSuspension"+imputado).val()+jsonn+",");        

        var newrow="<tr class='tr"+imputado+"_"+idjson+"'>"+
          "<td>"+$("#causa_H_fecha_suspension.imp"+imputado).val().trim()+"</td>"+
          "<td>"+$("#causa_H_causas_suspension.imp"+imputado).val().trim()+"</td>"+
          "<td>"+$("#causa_H_reanudacion_juicio.imp"+imputado).val().trim()+"</td>"+
          "<td><button type='button' title='Eliminar causa' class='btn btn-danger' "+
          "onclick='eliminarCausaS(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";

        $("#Suspension"+imputado+" tbody").append(newrow);
        $("#causa_H_fecha_suspension.imp"+imputado).val('');
        $("#causa_H_causas_suspension.imp"+imputado).val('');
        $("#causa_H_reanudacion_juicio.imp"+imputado).val('');

      }
     }
    }
    function eliminarCausaS(imputado,id,DB=0)
    {
      if (DB==1) {
        eliminarReload(id,'cpjosu');
      }
      else
      {
        var json=JSON.parse("["+$("#hdnSuspension"+imputado).val().replace(/,+$/,"")+"]");
        var filtro=json.filter(function(arr){return arr.id!=id});
        $("#hdnSuspension"+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
        window.event.target.parentElement.parentElement.remove();
        // $('.tr'+imputado+"_"+id).remove();                
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
