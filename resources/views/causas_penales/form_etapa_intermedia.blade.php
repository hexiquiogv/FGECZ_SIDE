<div class="row causasEtapaIntermedia">
    <div class="mb-4 mt-5 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Acusación</h4>
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
      <form method='post' name="frmCausasPenalesEI_A_0" id="frmCausasPenalesEI_A_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="row">
            @csrf  
          <input type="hidden" name="idImputadoEI" id="idImputadoEI" value="0">
          <input type="hidden" name="idImputado" id="idImputado" value="">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="A">

            <div class="mb-3 input-group">
              <label for="causa_H_acusacion" class="input-group-text">¿Hubo acusación?</label>
              <select class="form-select" name="causa_H_acusacion" id="causa_H_acusacion">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNoNoI as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach          
              </select>

              <label for="causa_H_fecha_escrito_acus" class="input-group-text">Fecha del escrito de acusación:</label>
              <input type="date" class="form-control" name="causa_H_fecha_escrito_acus" id="causa_H_fecha_escrito_acus">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>       
        </div>
      </form> 
    </div>
    @foreach($listados['imputadosCP_A'] as $imputado)
     <div class="accordion mb-2" id="accordionFiltrosAudienciaI_A_{{$imputado->id}}">
      <div class="accordion-item">
        <h2 class="accordion-header" id="panelsFiltrosAudienciaI_A_{{$imputado->id}}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
          data-bs-target="#panelsStayOpen-collapseOneAudienciaI_A_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaI_A_{{$imputado->id}}">
            Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOneAudienciaI_A_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaI_A_{{$imputado->id}}">
         <form method='post' name="frmCausasPenalesEI_A_{{$imputado->id}}" id="frmCausasPenalesEI_A_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoEI" id="idImputadoEI" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="A">
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_acusacion" class="form-label">¿Hubo acusación?</label>
              <select class="form-select" name="causa_H_acusacion" id="causa_H_acusacion">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNoNoI as $item)      
                  <option value="{{ $item->id }}" 
                    {{isset($imputado->ACUSACION)?$imputado->ACUSACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
                @endforeach          
             </select>
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_fecha_escrito_acus" class="form-label">Fecha del escrito de acusación:</label>
              <input type="date" class="form-control" name="causa_H_fecha_escrito_acus" id="causa_H_fecha_escrito_acus" value="{{$imputado->FECHA_ESCRITO_ACUS??''}}">
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
        <h4>Audiencia Intermedia</h4>
      </div>
    </div> 
    <div class="mb-3 input-group {{count($listados['imputadosDDL_I'])<1?'d-none':''}}">
      <label for="ddlImputados_I" class="input-group-text">Imputado:</label>        
      <select class="form-select" id="ddlImputados_I" name="ddlImputados_I" onchange="javascript:addImputadoFormModal('_I')">
        <option value="-1">Seleccione una opción</option>
        @foreach ($listados['imputadosDDL_I'] as $item)      
          <option value="{{$item->id}}" data-forma="{{$item->FORMA_}}"
            data-detencion="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
        @endforeach       
      </select>
      <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button> -->
    </div>
    <div id="addImputadoForm_I" style="display: none;">
      <form method='post' name="frmCausasPenalesEI_I_0" id="frmCausasPenalesEI_I_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="row">
            @csrf  
          <input type="hidden" name="idImputadoEI" id="idImputadoEI" value="0">
          <input type="hidden" name="idImputado" id="idImputado" value="">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="I">

          <div class="input-group">
            <label for="causa_H_intermedia" class="input-group-text">Celebración de la audiencia intermedia:</label>
            <select class="form-select" name="causa_H_intermedia" id="causa_H_intermedia">
              <option value="-1">Seleccione una opción</option>
              @foreach ($SiNoNoI as $item)      
                <option value="{{ $item->id }}">{{$item->Valor}}</option>      
              @endforeach
            </select>
            <!-- </div>
            <div class="input-group siCelebracion" style="display:none;"> -->
            <label for="causa_H_fecha_audiencia_intermedia" style="display:none;" class="input-group-text siCelebracion">Fecha de la celebración de la audiencia intermedia:
            </label>
            <input type="date" class="form-control siCelebracion" style="display:none;" name="causa_H_fecha_audiencia_intermedia" id="causa_H_fecha_audiencia_intermedia">
            <!-- </div> 
            <div class="input-group noCelebracion" style="display:none;"> -->
            <label for="causa_H_suspension_de_audiencia" class="input-group-text noCelebracion" style="display:none;">Fecha de suspensión de audiencia:</label>
            <input type="date" class="form-control noCelebracion" style="display:none;" name="causa_H_suspension_de_audiencia" id="causa_H_suspension_de_audiencia">
          </div> 
          <div class="input-group noCelebracion" style="display:none;">
            <label for="causa_H_causas_suspension_intermedia" class="input-group-text">Causas de suspensión de audiencia intermedia:</label>
            <input type="text" class="form-control alfanum" name="causa_H_causas_suspension_intermedia" id="causa_H_causas_suspension_intermedia">
          </div>
          <div class="mb-3 input-group">
            <label for="causa_H_fecha_de_reanudacion_intermedia" style="display:none;" class="input-group-text noCelebracion">Fecha de reanudación de audiencia intermedia:</label>
            <input type="date" class="form-control noCelebracion" style="display:none;" name="causa_H_fecha_de_reanudacion_intermedia" id="causa_H_fecha_de_reanudacion_intermedia">
          <!-- </div>
            <div class="mb-3 input-group"> -->
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>       
        </div>
      </form> 
      <script type="text/javascript">
          $("#frmCausasPenalesEI_I_0 #causa_H_intermedia").change(function() {
          if (this.value==1) {
            $("#frmCausasPenalesEI_I_0 .siCelebracion").show();
            $("#frmCausasPenalesEI_I_0 .noCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_0 .noCelebracion #causa_H_suspension_de_audiencia").val('');
            $("#frmCausasPenalesEI_I_0 .noCelebracion #causa_H_causas_suspension_intermedia").val('');
            $("#frmCausasPenalesEI_I_0 .noCelebracion #causa_H_fecha_de_reanudacion_intermedia").val('');
            
          }
          else if (this.value==0) {
            $("#frmCausasPenalesEI_I_0 .noCelebracion").show();
            $("#frmCausasPenalesEI_I_0 .siCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_0 .siCelebracion #causa_H_fecha_audiencia_intermedia").val('');
          }
          else
          {
            $("#frmCausasPenalesEI_I_0 .noCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_0 .noCelebracion #causa_H_suspension_de_audiencia").val('');
            $("#frmCausasPenalesEI_I_0 .noCelebracion #causa_H_causas_suspension_intermedia").val('');
            $("#frmCausasPenalesEI_I_0 .noCelebracion #causa_H_fecha_de_reanudacion_intermedia").val('');
              $("#frmCausasPenalesEI_I_0 .siCelebracion").hide();//hide
              $("#frmCausasPenalesEI_I_0 .siCelebracion #causa_H_fecha_audiencia_intermedia").val('');
          }
        }); 

          if ($("#frmCausasPenalesEI_I_0 #causa_H_intermedia").val()==1) {
            $("#frmCausasPenalesEI_I_0 .siCelebracion").show();
            $("#frmCausasPenalesEI_I_0 .noCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_0 .noCelebracion #causa_H_suspension_de_audiencia").val('');
            $("#frmCausasPenalesEI_I_0 .noCelebracion #causa_H_causas_suspension_intermedia").val('');
            $("#frmCausasPenalesEI_I_0 .noCelebracion #causa_H_fecha_de_reanudacion_intermedia").val('');      
          }
          else if ($("#frmCausasPenalesEI_I_0 #causa_H_intermedia").val()==0) {
            $("#frmCausasPenalesEI_I_0 .noCelebracion").show();
            $("#frmCausasPenalesEI_I_0 .siCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_0 .siCelebracion #causa_H_fecha_audiencia_intermedia").val('');
          }
          else
          {
            $("#frmCausasPenalesEI_I_0 .noCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_0 .noCelebracion #causa_H_suspension_de_audiencia").val('');
            $("#frmCausasPenalesEI_I_0 .noCelebracion #causa_H_causas_suspension_intermedia").val('');
            $("#frmCausasPenalesEI_I_0 .noCelebracion #causa_H_fecha_de_reanudacion_intermedia").val('');
              $("#frmCausasPenalesEI_I_0 .siCelebracion").hide();//hide
              $("#frmCausasPenalesEI_I_0 .siCelebracion #causa_H_fecha_audiencia_intermedia").val('');
          }
      </script>
    </div>
    @foreach($listados['imputadosCP_I'] as $imputado)
     <div class="accordion mb-2" id="accordionFiltrosAudienciaI_I_{{$imputado->id}}">
      <div class="accordion-item">
        <h2 class="accordion-header" id="panelsFiltrosAudienciaI_I_{{$imputado->id}}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
          data-bs-target="#panelsStayOpen-collapseOneAudienciaI_I_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaI_I_{{$imputado->id}}">
            Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOneAudienciaI_I_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaI_I_{{$imputado->id}}">
         <form method='post' name="frmCausasPenalesEI_I_{{$imputado->id}}" id="frmCausasPenalesEI_I_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoEI" id="idImputadoEI" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="I">

            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_intermedia" class="form-label">Celebración de la audiencia intermedia:</label>
              <select class="form-select" name="causa_H_intermedia" id="causa_H_intermedia">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNoNoI as $item)      
                  <option value="{{ $item->id }}" 
                    {{isset($imputado->INTERMEDIA) ? $imputado->INTERMEDIA==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
                @endforeach
             </select>
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 siCelebracion" style="display:none;">
              <label for="causa_H_fecha_audiencia_intermedia" class="form-label">Fecha de la celebración de la audiencia intermedia:
              </label>
              <input type="date" class="form-control" name="causa_H_fecha_audiencia_intermedia" id="causa_H_fecha_audiencia_intermedia" 
              value="{{isset($imputado->INTERMEDIA) ? $imputado->INTERMEDIA != 0 ? $imputado->FECHA_AUDIENCIA_INTERMEDIA ?? '' : '' : ''}}">
            </div> 
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 noCelebracion" style="display:none;">
              <label for="causa_H_suspension_de_audiencia" class="form-label">Fecha de suspensión de audiencia:</label>
              <input type="date" class="form-control" name="causa_H_suspension_de_audiencia" id="causa_H_suspension_de_audiencia" 
              value="{{isset($imputado->INTERMEDIA) ? $imputado->INTERMEDIA != 0 ? $imputado->SUSPENSION_DE_AUDIENCIA ?? '' : '' : ''}}">
            </div> 
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 noCelebracion" style="display:none;">
              <label for="causa_H_causas_suspension_intermedia" class="form-label">Causas de suspensión de audiencia intermedia:</label>
              <input type="text" class="form-control alfanum" name="causa_H_causas_suspension_intermedia" id="causa_H_causas_suspension_intermedia" 
              value="{{isset($imputado->INTERMEDIA) ? $imputado->INTERMEDIA != 0 ? $imputado->CAUSAS_SUSPENSION_INTERMEDIA ?? '' : '' : ''}}">
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 noCelebracion" style="display:none;">
              <label for="causa_H_fecha_de_reanudacion_intermedia" class="form-label">Fecha de reanudación de audiencia intermedia:</label>
              <input type="date" class="form-control" name="causa_H_fecha_de_reanudacion_intermedia" id="causa_H_fecha_de_reanudacion_intermedia" 
              value="{{isset($imputado->INTERMEDIA) ? $imputado->INTERMEDIA != 0 ? $imputado->FECHA_DE_REANUDACION_INTERMEDIA ?? '' : '' : ''}}">
            </div>
            <div class="mb-3 col-12 noCelebracion">
              <div class="accordion" id="accordionFiltrosNoCelebraciones_{{$imputado->id}}">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsFiltrosNoCelebraciones_{{$imputado->id}}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#panelsStayOpen-collapseOneNoCelebraciones_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneNoCelebraciones_{{$imputado->id}}">
                      Registro de suspenciones de audencias
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseOneNoCelebraciones_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosNoCelebraciones_{{$imputado->id}}">
                    <div class="accordion-body row">

                      <input type="hidden" name="hdnNoCelebraciones" id="hdnNoCelebraciones">
                      <table id="NoCelebraciones{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
                          <caption><sup>*últimos 5 registros</sup></caption>    
                          <thead class="table-light">
                          <tr>
                            <th scope="col">Fecha de suspensión de audiencia</th>
                            <th scope="col">Causas de suspensión de audiencia intermedia</th>
                            <th scope="col">Fecha de reanudación de audiencia intermedia</th>
                          </tr>
                        </thead>
                        <tbody>                   
                          @foreach($CelebracionesEI[$imputado->id] as $celeb)
                            <tr class="trV{{$celeb->id}}">
                              <td>{{$celeb->SUSPENSION_DE_AUDIENCIA}}</td>
                              <td>{{$celeb->CAUSAS_SUSPENSION_INTERMEDIA}}</td>
                              <td>{{$celeb->FECHA_DE_REANUDACION_INTERMEDIA}}</td>
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
          $("#frmCausasPenalesEI_I_{{$imputado->id}} #causa_H_intermedia").change(function() {
          if (this.value==1) {
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .siCelebracion").show();
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion #causa_H_suspension_de_audiencia").val('');
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion #causa_H_causas_suspension_intermedia").val('');
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion #causa_H_fecha_de_reanudacion_intermedia").val('');
            
          }
          else if (this.value==0) {
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion").show();
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .siCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .siCelebracion #causa_H_fecha_audiencia_intermedia").val('');
          }
          else
          {
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion #causa_H_suspension_de_audiencia").val('');
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion #causa_H_causas_suspension_intermedia").val('');
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion #causa_H_fecha_de_reanudacion_intermedia").val('');
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .siCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .siCelebracion #causa_H_fecha_audiencia_intermedia").val('');
          }
        }); 

          if ($("#frmCausasPenalesEI_I_{{$imputado->id}} #causa_H_intermedia").val()==1) {
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .siCelebracion").show();
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion #causa_H_suspension_de_audiencia").val('');
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion #causa_H_causas_suspension_intermedia").val('');
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion #causa_H_fecha_de_reanudacion_intermedia").val('');      
          }
          else if ($("#frmCausasPenalesEI_I_{{$imputado->id}} #causa_H_intermedia").val()==0) {
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion").show();
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .siCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .siCelebracion #causa_H_fecha_audiencia_intermedia").val('');
          }
          else
          {
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion #causa_H_suspension_de_audiencia").val('');
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion #causa_H_causas_suspension_intermedia").val('');
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .noCelebracion #causa_H_fecha_de_reanudacion_intermedia").val('');
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .siCelebracion").hide();//hide
            $("#frmCausasPenalesEI_I_{{$imputado->id}} .siCelebracion #causa_H_fecha_audiencia_intermedia").val('');
          }
      </script>    
    @endforeach

    <div class="mb-4 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Acuerdos probatorios</h4>
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
      <form method='post' name="frmCausasPenalesEI_P_0" id="frmCausasPenalesEI_P_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="row">
            @csrf  
          <input type="hidden" name="idImputadoEI" id="idImputadoEI" value="0">
          <input type="hidden" name="idImputado" id="idImputado" value="">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="P">
            <div class="input-group">
              <label for="causa_H_acuerdos_prop" class="input-group-text">¿Contó con acuerdos probatorios?</label>
              <select class="form-select" name="causa_H_acuerdos_prop" id="causa_H_acuerdos_prop">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNoNoI as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach        
              </select>
            </div>
            <div class="input-group siAcuerdos" style="display:none;">
              <label for="causa_H_observaciones_acuerdos" class="input-group-text">Observaciones de los acuerdos probatorios:</label>
              <input type="text" class="form-control alfanum" name="causa_H_observaciones_acuerdos" id="causa_H_observaciones_acuerdos">
            </div>  
            <div class="mb-3 input-group">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>       
        </div>
      </form> 
      <script type="text/javascript">
        $("#frmCausasPenalesEI_P_0 #causa_H_acuerdos_prop").change(function() {
          if (this.value==1) {
            $("#frmCausasPenalesEI_P_0 .siAcuerdos").show();
          }
          else
          {
            $("#frmCausasPenalesEI_P_0 .siAcuerdos").hide();
            $("#frmCausasPenalesEI_P_0 #causa_H_observaciones_acuerdos").val('');
          }      
        });

        if ($("#frmCausasPenalesEI_P_0 #causa_H_acuerdos_prop").val()==1) {
          $("#frmCausasPenalesEI_P_0 .siAcuerdos").show();            
        }    
        else
        {
          $("#frmCausasPenalesEI_P_0 .siAcuerdos").hide();
          $("#frmCausasPenalesEI_P_0 #causa_H_observaciones_acuerdos").val('');
        }
      </script>      
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
         <form method='post' name="frmCausasPenalesEI_P_{{$imputado->id}}" id="frmCausasPenalesEI_P_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoEI" id="idImputadoEI" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="P">
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_acuerdos_prop" class="form-label">¿Contó con acuerdos probatorios?</label>
              <select class="form-select" name="causa_H_acuerdos_prop" id="causa_H_acuerdos_prop">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNoNoI as $item)      
                  <option value="{{ $item->id }}" 
                    {{isset($imputado->ACUERDOS_PROP)?$imputado->ACUERDOS_PROP==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
                @endforeach        
             </select>
            </div>
            <div class="mb-3 col-sm-12 col-md-12 col-lg-12 siAcuerdos" style="display:none;">
              <label for="causa_H_observaciones_acuerdos" class="form-label">Observaciones de los acuerdos probatorios:</label>
              <input type="text" class="form-control alfanum" name="causa_H_observaciones_acuerdos" id="causa_H_observaciones_acuerdos" 
              value="{{$imputado->OBSERVACIONES_ACUERDOS??''}}">
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
        $("#frmCausasPenalesEI_P_{{$imputado->id}} #causa_H_acuerdos_prop").change(function() {
          if (this.value==1) {
            $("#frmCausasPenalesEI_P_{{$imputado->id}} .siAcuerdos").show();
          }
          else
          {
            $("#frmCausasPenalesEI_P_{{$imputado->id}} .siAcuerdos").hide();
            $("#frmCausasPenalesEI_P_{{$imputado->id}} #causa_H_observaciones_acuerdos").val('');
          }      
        });

        if ($("#frmCausasPenalesEI_P_{{$imputado->id}} #causa_H_acuerdos_prop").val()==1) {
          $("#frmCausasPenalesEI_P_{{$imputado->id}} .siAcuerdos").show();            
        }    
        else
        {
          $("#frmCausasPenalesEI_P_{{$imputado->id}} .siAcuerdos").hide();
          $("#frmCausasPenalesEI_P_{{$imputado->id}} #causa_H_observaciones_acuerdos").val('');
        }
      </script>    
    @endforeach

    <div class="mb-4 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Datos del juicio oral</h4>
      </div>
    </div>    
    <div class="mb-3 input-group {{count($listados['imputadosDDL_D'])<1?'d-none':''}}">
      <label for="ddlImputados_D" class="input-group-text">Imputado:</label>        
      <select class="form-select" id="ddlImputados_D" name="ddlImputados_D" onchange="javascript:addImputadoFormModal('_D')">
        <option value="-1">Seleccione una opción</option>
        @foreach ($listados['imputadosDDL_D'] as $item)      
          <option value="{{$item->id}}" data-forma="{{$item->FORMA_}}"
            data-detencion="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
        @endforeach       
      </select>
      <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button> -->
    </div>
    <div id="addImputadoForm_D" style="display: none;">
      <form method='post' name="frmCausasPenalesEI_D_0" id="frmCausasPenalesEI_D_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="row">
            @csrf  
          <input type="hidden" name="idImputadoEI" id="idImputadoEI" value="0">
          <input type="hidden" name="idImputado" id="idImputado" value="">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <input type="hidden" name="frmSecc" id="frmSecc" value="D">
            <div class="input-group">
              <label for="causa_H_juicio_oral" class="input-group-text">Auto de apertura a juicio oral:</label>
              <select class="form-select" name="causa_H_juicio_oral" id="causa_H_juicio_oral">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNoNoI as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach
              </select>
              <label for="causa_H_auto_de_apertura" class="input-group-text">Fecha de auto de apertura:</label>
              <input type="date" class="form-control" name="causa_H_auto_de_apertura" id="causa_H_auto_de_apertura">
            </div><div class="mb-3 input-group">              
              <label for="causa_H_fecha_audiencia_juicio" class="input-group-text">Fecha de la celebración de la audiencia de juicio:</label>
              <input type="date" class="form-control" name="causa_H_fecha_audiencia_juicio" id="causa_H_fecha_audiencia_juicio">

              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>       
        </div>
      </form> 
    </div>
    @foreach($listados['imputadosCP_D'] as $imputado)
     <div class="accordion mb-2" id="accordionFiltrosAudienciaI_D_{{$imputado->id}}">
      <div class="accordion-item">
        <h2 class="accordion-header" id="panelsFiltrosAudienciaI_D_{{$imputado->id}}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
          data-bs-target="#panelsStayOpen-collapseOneAudienciaI_D_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaI_D_{{$imputado->id}}">
            Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOneAudienciaI_D_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaI_D_{{$imputado->id}}">
         <form method='post' name="frmCausasPenalesEI_D_{{$imputado->id}}" id="frmCausasPenalesEI_D_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoEI" id="idImputadoEI" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="D">

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
   <form method='post' name="frmCausasPenalesEI" id="frmCausasPenalesEI" action="{{ route('saveCP') }}" 
   enctype="multipart/form-data">
    <div class="row">
      @csrf      
      <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
      <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
      <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">            
      <div class="mb-4 col-12 pestanaBase">
        <div class="pestanaTop">
          <h4>Acusación</h4>
        </div>
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_acusacion" class="form-label">¿Hubo acusación?</label>
        <select class="form-select" name="causa_H_acusacion" id="causa_H_acusacion">
          <option value="-1">Seleccione una opción</option>
          @foreach ($SiNoNoI as $item)      
            <option value="{{ $item->id }}" 
              {{isset($etapaintermedia->ACUSACION)?$etapaintermedia->ACUSACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach          
       </select>
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_fecha_escrito_acus" class="form-label">Fecha del escrito de acusación:</label>
        <input type="date" class="form-control" name="causa_H_fecha_escrito_acus" id="causa_H_fecha_escrito_acus" value="{{$etapaintermedia->FECHA_ESCRITO_ACUS??''}}">
      </div> 
      <div class="mb-4 col-12 pestanaBase">
        <div class="pestanaTop">
          <h4>Audiencia Intermedia</h4>
        </div>
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_intermedia" class="form-label">Celebración de la audiencia intermedia:</label>
        <select class="form-select" name="causa_H_intermedia" id="causa_H_intermedia">
          <option value="-1">Seleccione una opción</option>
          @foreach ($SiNoNoI as $item)      
            <option value="{{ $item->id }}" 
              {{isset($etapaintermedia->INTERMEDIA)?$etapaintermedia->INTERMEDIA==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach
       </select>
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4 siCelebracion" style="display:none;">
        <label for="causa_H_fecha_audiencia_intermedia" class="form-label">Fecha de la celebración de la audiencia intermedia:
        </label>
        <input type="date" class="form-control" name="causa_H_fecha_audiencia_intermedia" id="causa_H_fecha_audiencia_intermedia" 
        value="{{$etapaintermedia->FECHA_AUDIENCIA_INTERMEDIA??''}}">
      </div> 
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4 noCelebracion" style="display:none;">
        <label for="causa_H_suspension_de_audiencia" class="form-label">Fecha de suspensión de audiencia:</label>
        <input type="date" class="form-control" name="causa_H_suspension_de_audiencia" id="causa_H_suspension_de_audiencia" 
        value="{{$etapaintermedia->SUSPENSION_DE_AUDIENCIA??''}}">
      </div> 
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4 noCelebracion" style="display:none;">
        <label for="causa_H_causas_suspension_intermedia" class="form-label">Causas de suspensión de audiencia intermedia:</label>
        <input type="text" class="form-control alfanum" name="causa_H_causas_suspension_intermedia" id="causa_H_causas_suspension_intermedia" 
        value="{{$etapaintermedia->CAUSAS_SUSPENSION_INTERMEDIA??''}}">
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4 noCelebracion" style="display:none;">
        <label for="causa_H_fecha_de_reanudacion_intermedia" class="form-label">Fecha de reanudación de audiencia intermedia:</label>
        <input type="date" class="form-control" name="causa_H_fecha_de_reanudacion_intermedia" id="causa_H_fecha_de_reanudacion_intermedia" 
        value="{{$etapaintermedia->FECHA_DE_REANUDACION_INTERMEDIA??''}}">
      </div>
      <div class="mb-3 col-12 noCelebracion">
        <div class="accordion" id="accordionFiltrosNoCelebraciones_0">
          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsFiltrosNoCelebraciones_0">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
              data-bs-target="#panelsStayOpen-collapseOneNoCelebraciones_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneNoCelebraciones_0">
                Registro de suspenciones de audencias
              </button>
            </h2>
            <div id="panelsStayOpen-collapseOneNoCelebraciones_0" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosNoCelebraciones_0">
              <div class="accordion-body row">

                <input type="hidden" name="hdnNoCelebraciones" id="hdnNoCelebraciones">
                <table id="NoCelebraciones0" class="col-12 table table-striped table-hover table-responsive caption-top">
                    <caption><sup>*últimos 5 registros</sup></caption>    
                    <thead class="table-light">
                    <tr>
                      <th scope="col">Fecha de suspensión de audiencia</th>
                      <th scope="col">Causas de suspensión de audiencia intermedia</th>
                      <th scope="col">Fecha de reanudación de audiencia intermedia</th>
                    </tr>
                  </thead>
                  <tbody>                   
                    @foreach($CelebracionesEI as $celeb)
                      <tr class="trV{{$celeb->id}}">
                        <td>{{$celeb->SUSPENSION_DE_AUDIENCIA}}</td>
                        <td>{{$celeb->CAUSAS_SUSPENSION_INTERMEDIA}}</td>
                        <td>{{$celeb->FECHA_DE_REANUDACION_INTERMEDIA}}</td>
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
          <h4>Acuerdos probatorios</h4>
        </div>
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4 d-none">
        <label for="causa_H_medio_prueba" class="form-label">¿Hubo presentación de medios de prueba?</label>
        <select class="form-select" name="causa_H_medio_prueba" id="causa_H_medio_prueba">
          <option value="-1">Seleccione una opción</option>
          --}}{{--@foreach ($SiNoNoI as $item)      
            <option value="{{ $item->id }}" 
              {{isset($etapaintermedia->MEDIO_PRUEBA)?$etapaintermedia->MEDIO_PRUEBA==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach        --}}{{--
       </select>
      </div>
      <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
        <label for="causa_H_acuerdos_prop" class="form-label">¿Contó con acuerdos probatorios?</label>
        <select class="form-select" name="causa_H_acuerdos_prop" id="causa_H_acuerdos_prop">
          <option value="-1">Seleccione una opción</option>
          @foreach ($SiNoNoI as $item)      
            <option value="{{ $item->id }}" 
              {{isset($etapaintermedia->ACUERDOS_PROP)?$etapaintermedia->ACUERDOS_PROP==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
          @endforeach        
       </select>
      </div>
      <div class="mb-3 col-sm-12 col-md-12 col-lg-12 siAcuerdos" style="display:none;">
        <label for="causa_H_observaciones_acuerdos" class="form-label">Observaciones de los acuerdos probatorios:</label>
        <input type="text" class="form-control alfanum" name="causa_H_observaciones_acuerdos" id="causa_H_observaciones_acuerdos" 
        value="{{$etapaintermedia->OBSERVACIONES_ACUERDOS??''}}">
      </div>        
      <div class="mb-3 col-12 d-none">
        <div class="accordion" id="accordionFiltrosMedidas_0">
          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsFiltrosMedidas_0">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" 
              data-bs-target="#panelsStayOpen-collapseOneMedidas_0" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneMedidas_0">
                Listado de medios de prueba
              </button>
            </h2>
            <div id="panelsStayOpen-collapseOneMedidas_0" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosMedidas_0">
              <div class="accordion-body row">
                <div class="col-sm-12 input-group">
                  <label for="causa_H_medios_pruebas" class="input-group-text">
                  Medio de prueba</label>
                  <select class="form-select" name="causa_H_medios_pruebas" id="causa_H_medios_pruebas">
                    <option value="-1">Seleccione una opción</option>
                    @foreach ($mediosPruebas as $item)      
                      <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                    @endforeach        
                  </select>
                </div>
                <div class="col-sm-12 input-group">                
                  <label for="causa_H_medios_pruebas_pe" class="input-group-text">
                  Presentados /excluidos</label>
                  <select class="form-select" name="causa_H_medios_pruebas_pe" id="causa_H_medios_pruebas_pe">
                    <option value="-1">Seleccione una opción</option>
                    @foreach ($presex as $item)      
                      <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                    @endforeach                    
                  </select>
                  <label for="causa_H_acuerdos_reparatorios" class="input-group-text d-none">¿Contó con acuerdos reparatorio?</label>
                  <select class="form-select d-none" name="causa_H_acuerdos_reparatorios" id="causa_H_acuerdos_reparatorios">
                    <option value="-1">Seleccione una opción</option>
                    @foreach ($SiNo as $item)      
                      <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                    @endforeach        
                 </select>                                    
                  <button type="button" class="btn btn-primary"onclick="javascript:addMedida(0)">
                    Agregar medio de prueba
                  </button>
                </div>                         
                <input type="hidden" name="hdnMedidas0" id="hdnMedidas0">
                <table id="medidas0" class="col-12 table table-striped table-hover table-responsive caption-top">
                    <caption></caption>    
                    <thead class="table-light">
                    <tr>
                      <th scope="col">Medios de prueba</th>
                      <th scope="col">presentados /excluidos</th>
                      <!-- <th scope="col">¿Contó con acuerdos reparatorio?</th> -->
                      <th scope="col">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody> 
                   @foreach ($mediosEI as $medio)
                    <tr class="tr0_{{$medio->id}}">
                      <td>{{$medio->Valor}}</td>
                      <td>{{$medio->Valor2}}</td>
                      <td>
                        <button type="button" title="Eliminar medio" class="btn btn-danger" 
                        onclick="eliminarMedida('0','{{$medio->id}}',1)">×</button>
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
          <h4>Datos del juicio oral</h4>
        </div>
      </div>            
        <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
          <label for="causa_H_juicio_oral" class="form-label">Auto de apertura a juicio oral:</label>
          <select class="form-select" name="causa_H_juicio_oral" id="causa_H_juicio_oral">
            <option value="-1">Seleccione una opción</option>
            @foreach ($SiNoNoI as $item)      
              <option value="{{ $item->id }}" 
                {{isset($etapaintermedia->JUICIO_ORAL)?$etapaintermedia->JUICIO_ORAL==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
            @endforeach
         </select>
        </div>
        <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
          <label for="causa_H_auto_de_apertura" class="form-label">Fecha de auto de apertura:</label>
          <input type="date" class="form-control" name="causa_H_auto_de_apertura" id="causa_H_auto_de_apertura" 
            value="{{$etapaintermedia->AUTO_DE_APERTURA??''}}">
        </div> 
        <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
          <label for="causa_H_fecha_audiencia_juicio" class="form-label">Fecha de la celebración de la audiencia de juicio:</label>
          <input type="date" class="form-control" name="causa_H_fecha_audiencia_juicio" id="causa_H_fecha_audiencia_juicio" 
            value="{{$etapaintermedia->FECHA_AUDIENCIA_JUICIO??''}}">
        </div>
      --}}{{--
        <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
          <label for="causa_H_fecha_acusacion" class="form-label">Fecha de acusación:</label>
          <input type="date" class="form-control" name="causa_H_fecha_acusacion" id="causa_H_fecha_acusacion" value="{{$etapaintermedia->FECHA_ACUSACION??''}}">
        </div>   

        <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
          <label for="causa_H_causas_no_admision" class="form-label">Causas de la no admisión:</label>
          <input type="text" class="form-control alfanum" maxlength="255" name="causa_H_causas_no_admision" id="causa_H_causas_no_admision" 
          value="{{$etapaintermedia->CAUSAS_NO_ADMISION??''}}">
        </div>
      --}}{{--    

        <div class="border-bottom py-2 mb-4 modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>     
    </div>      
   </form>
 --}}
 {{--
    <div class="mb-3 input-group">      
      <label for="ddlImputados" class="input-group-text">Imputado:</label>        
      <select class="form-select" id="ddlImputados" name="ddlImputados">
        <option value="-1">Seleccione una opción</option>
        @foreach ($listados['imputadosDDL'] as $item)      
          <option value="{{$item->id}}">{{$item->Valor}}</option>      
        @endforeach       
      </select>
      <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">
      Agregar persona imputada</button>      
    </div> 
    @foreach($listados['imputadosCP'] as $imputado)
     <div class="accordion mb-2" id="accordionFiltrosEtapaInt_{{$imputado->id}}">
      <div class="accordion-item">
        <h2 class="accordion-header" id="panelsFiltrosEtapaInt_{{$imputado->id}}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
          data-bs-target="#panelsStayOpen-collapseOneEtapaInt_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneEtapaInt_{{$imputado->id}}">
            Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOneEtapaInt_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosEtapaInt_{{$imputado->id}}">
         <form method='post' name="frmCausasPenalesEI_{{$imputado->id}}" id="frmCausasPenalesEI_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoEI" id="idImputadoEI" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">            
            @include("causas_penales.etapa_intermedia.form")
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
</div>
{{--
  <div class="modal fade" id="addImputadoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addImputadoFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addImputadoFormLabel">Datos de etapa intermedia del imputado</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method='post' name="frmCausasPenalesEI_0" id="frmCausasPenalesEI_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
            <div class="row">
                @csrf  
              <input type="hidden" name="idImputadoEI" id="idImputadoEI" value="0">
              <input type="hidden" name="idImputado" id="idImputado" value="">
              <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
              <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
              <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
               @include("causas_penales.etapa_intermedia.formModal")
            </div>        
          </form>   
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="closeaddImputadoForm" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesEI_0').submit()">Guardar</button>
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
  $("#causa_H_medio_prueba").change(function() {
    if (this.value==1) {
      $("#accordionFiltrosMedidas_0").show();            
    }
    // else if (this.value==0) {
    //   $("#accordionFiltrosMedidas_0").hide(); 
    //   $("#causa_H_medios_pruebas").val(-1); 
    //   $("#causa_H_medios_pruebas_pe").val(-1); 
    //   $("tr.new").remove();
    //   $("#hdnMedidas0").val('');
    // }
    else
    {
      $("#accordionFiltrosMedidas_0").hide();
      $("#causa_H_medios_pruebas").val(-1); 
      $("#causa_H_medios_pruebas_pe").val(-1);       
      $("#causa_H_acuerdos_reparatorios").val(-1);
      $("tr.new").remove();
      $("#hdnMedidas0").val('');
    }      
  });

    if ($("#causa_H_medio_prueba").val()==1) {
      $("#accordionFiltrosMedidas_0").show();            
    }
    else if ($("#causa_H_medio_prueba").val()==0) {
      $("#accordionFiltrosMedidas_0").hide(); 
      $("#causa_H_medios_pruebas").val(-1); 
      $("#causa_H_medios_pruebas_pe").val(-1);
      $("#causa_H_acuerdos_reparatorios").val(-1);
      $("tr.new").remove();
      $("#hdnMedidas0").val('');       
    }
    else
    {
      $("#accordionFiltrosMedidas_0").hide();
      $("#causa_H_medios_pruebas").val(-1); 
      $("#causa_H_medios_pruebas_pe").val(-1);   
      $("#causa_H_acuerdos_reparatorios").val(-1);      
      $("tr.new").remove();
      $("#hdnMedidas0").val('');          
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
 
  function addImputadoFormModal(Seccion)
  {
    if ($("#ddlImputados"+Seccion).val()>-1) {
     $("#frmCausasPenalesEI"+Seccion+"_0 #idImputado").val($("#ddlImputados"+Seccion).val());
     $("#addImputadoForm"+Seccion).show();
    }
    else{$("#addImputadoForm"+Seccion).hide();}   
  }
  function addMedida(imputado)
  {      
    if ($("#causa_H_medios_pruebas").val()>-1 &&
        $("#causa_H_medios_pruebas_pe").val()>-1) {

      var jsonn="";        
      var idjson=0;
      if ($("#hdnMedidas"+imputado).val().length>0) {
       var json=JSON.parse("["+$("#hdnMedidas"+imputado).val().replace(/,+$/,"")+"]");
       idjson= json.sort(function(a, b) {
                 return parseFloat(b['id']) - parseFloat(a['id']);
              })[0]['id']+1;
      }
      
      jsonn='{"id":'+idjson+',"imputado":'+imputado+
      ',"medios":"' +$("#causa_H_medios_pruebas").val()+'"'+
      ',"repara":"' +$("#causa_H_acuerdos_reparatorios").val()+'"'+
      ',"medios_pe":"' +$("#causa_H_medios_pruebas_pe").val()+'"}';

      $("#hdnMedidas"+imputado).val($("#hdnMedidas"+imputado).val()+jsonn+",");        
      
      var newrow="<tr class='new tr"+imputado+"_"+idjson+"'>"+
        "<td>"+$("#causa_H_medios_pruebas :selected").text()+"</td>"+
        "<td>"+$("#causa_H_medios_pruebas_pe :selected").text()+"</td>"+
        // "<td>"+$("#causa_H_acuerdos_reparatorios :selected").text()+"</td>"+
        "<td><button type='button' title='Eliminar medio' class='btn btn-danger' "+
        "onclick='eliminarMedida(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";

      $("#medidas"+imputado+" tbody").append(newrow);  

      $("#causa_H_medios_pruebas").val(-1);
      $("#causa_H_medios_pruebas_pe").val(-1);
      $("#causa_H_acuerdos_reparatorios").val(-1);
    }
  }
  function eliminarMedida(imputado,id,DB=0)
  {
    if (DB==1) {
      eliminarReload(id,'cpeime');
    }
    else
    {
      var json=JSON.parse("["+$("#hdnMedidas"+imputado).val().replace(/,+$/,"")+"]");
      var filtro=json.filter(function(arr){return arr.id!=id});
      $("#hdnMedidas"+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
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
