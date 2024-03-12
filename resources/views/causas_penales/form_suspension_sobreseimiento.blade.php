<div class="row causasInicial">
    <div class="mb-4 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Suspensión</h4>
      </div>
    </div> 
    <div id="addImputadoForm_SU">
      <form method='post' name="frmCausasPenalesAI_SU_0" id="frmCausasPenalesAI_SU_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
        <div class="row">
            @csrf  
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">

          <div class="mb-3 col-12">
            <div class="row suspension">                     
              <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                <label for="causa_H_fecha_suspension" class="form-label">Fecha en que se determinó la suspensión:</label>
                <input type="date" class="form-control" name="causa_H_fecha_suspension" id="causa_H_fecha_suspension"
                value="{{$suspension->FECHA_SUSPENSION ?? ''}}">
              </div>
              <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                  <label for="causa_H_causa_proceso" class="form-label">Causa de la suspensión:</label>
                  <select class="form-select" name="causa_H_causa_proceso" id="causa_H_causa_proceso">
                    <option value="-1">Seleccione una opción</option>
                    @foreach ($causasSus as $item)      
                      <option value="{{ $item->id }}" {{isset($suspension->CAUSA_PROCESO)?$suspension->CAUSA_PROCESO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
                    @endforeach        
                 </select>
              </div>
              <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                  <label for="causa_H_reapertura_proceso" class="form-label">¿Hubo reapertura del proceso?</label>
                  <select class="form-select" name="causa_H_reapertura_proceso" id="causa_H_reapertura_proceso">
                    <option value="-1">Seleccione una opción</option>
                    @foreach ($SiNo as $item)      
                      <option value="{{ $item->id }}" {{isset($suspension->REAPERTURA_PROCESO)?$suspension->REAPERTURA_PROCESO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
                    @endforeach        
                 </select>
              </div>      
              <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                <label for="causa_H_fecha_de_reanudacion" class="form-label">Fecha de reapertura del proceso:</label>
                <input type="date" class="form-control" name="causa_H_fecha_de_reanudacion" id="causa_H_fecha_de_reanudacion"
                value="{{$suspension->FECHA_DE_REANUDACION ?? ''}}">
              </div> 
            </div>
          </div>              
        </div>  
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>           
    </div>  


    <div class="mb-4 col-12 pestanaBase">
      <div class="pestanaTop">
        <h4>Sobreseimiento</h4>
      </div>
    </div> 
    <div class="mb-3 input-group">
      <label for="ddlImputados_SO" class="input-group-text">Imputado:</label>        
      <select class="form-select" id="ddlImputados_SO" name="ddlImputados_SO" onchange ="javascript:addImputadoFormModal('_SO')">
        <option value="-1">Seleccione una opción</option>
        @foreach ($listados['imputadosDDL'] as $item)      
          <option value="{{$item->id}}" data-forma="{{$item->FORMA_}}"
            data-detencion="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
        @endforeach       
      </select>
      <!-- <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button> -->
    </div>  
      <div id="addImputadoForm_SO" style="display: none;">
        <form method='post' name="frmCausasPenalesAI_SO_0" id="frmCausasPenalesAI_SO_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
          <div class="row">
              @csrf  
            <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="0">
            <input type="hidden" name="idImputado" id="idImputado" value="">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <input type="hidden" name="frmSecc" id="frmSecc" value="SO">
                <div class="input-group">
                  <label for="causa_H_fecha_sobreseimiento" class="input-group-text">Fecha sobreseimiento:</label>
                  <input type="date" class="form-control" name="causa_H_fecha_sobreseimiento" id="causa_H_fecha_sobreseimiento" value="">

                  <label for="causa_H_tipo_sobreseimiento" class="input-group-text">Tipo de sobreseimiento:</label>
                  <select class="form-select" name="causa_H_tipo_sobreseimiento" id="causa_H_tipo_sobreseimiento">
                    <option value="-1">Seleccione una opción</option>
                    @foreach ($tipoSobre as $item)      
                      <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                    @endforeach      
                 </select>                
                </div><div class="input-group">
                    <label for="causa_H_causas_sobreseimiento" class="input-group-text">Causas de sobreseimiento:</label>
                    <select class="form-select" name="causa_H_causas_sobreseimiento" id="causa_H_causas_sobreseimiento">
                      <option value="-1">Seleccione una opción</option>
                      @foreach ($causasSobre as $item)      
                        <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                      @endforeach
                   </select>
                </div> 
                <div class="mb-3 input-group">
                  <label for="causa_H_sobreseimiento_observaciones" class="input-group-text">Observaciones:</label>
                  <input type="text" class="form-control alfanum noValidate" name="causa_H_sobreseimiento_observaciones" 
                  id="causa_H_sobreseimiento_observaciones">
                  <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesAI_SO_0').submit()">Guardar</button>
                </div>                         
          </div>        
        </form>   
      </div>  
   
    @foreach($listados['imputadosCP'] as $imputado)    
     <div class="accordion mb-2" id="accordionFiltrosAudienciaI_SO_{{$imputado->id}}">
      <div class="accordion-item">
        <h2 class="accordion-header" id="panelsFiltrosAudienciaI_SO_{{$imputado->id}}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
          data-bs-target="#panelsStayOpen-collapseOneAudienciaI_SO_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaI_SO_{{$imputado->id}}">
            Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOneAudienciaI_SO_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaI_SO_{{$imputado->id}}">
         <form method='post' name="frmCausasPenalesAI_SO_{{$imputado->id}}" id="frmCausasPenalesAI_SO_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
            <div class="mb-3 col-12">
              <div class="row sobreseimiento">
                <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                  <label for="causa_H_fecha_sobreseimiento" class="form-label">Fecha sobreseimiento:</label>
                  <input type="date" class="form-control" name="causa_H_fecha_sobreseimiento" id="causa_H_fecha_sobreseimiento" value="{{$imputado->FECHA_SOBRESEIMIENTO}}">
                </div>
                <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                  <label for="causa_H_tipo_sobreseimiento" class="form-label">Tipo de sobreseimiento:</label>
                  <select class="form-select" name="causa_H_tipo_sobreseimiento" id="causa_H_tipo_sobreseimiento">
                    <option value="-1">Seleccione una opción</option>
                    @foreach ($tipoSobre as $item)      
                      <option value="{{ $item->id }}"
                        {{isset($imputado->TIPO_SOBRESEIMIENTO)?$imputado->TIPO_SOBRESEIMIENTO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
                    @endforeach      
                 </select>
                </div>                 
                <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                    <label for="causa_H_causas_sobreseimiento" class="form-label">Causas de sobreseimiento:</label>
                    <select class="form-select" name="causa_H_causas_sobreseimiento" id="causa_H_causas_sobreseimiento">
                      <option value="-1">Seleccione una opción</option>
                      @foreach ($causasSobre as $item)      
                        <option value="{{ $item->id }}"
                          {{isset($imputado->CAUSAS_SOBRESEIMIENTO)?$imputado->CAUSAS_SOBRESEIMIENTO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
                      @endforeach
                   </select>
                </div> 

                <div class="mb-3 col-12">
                  <label for="causa_H_sobreseimiento_observaciones" class="form-label">Observaciones:</label>
                  <input type="text" class="form-control alfanum" name="causa_H_sobreseimiento_observaciones" 
                  id="causa_H_sobreseimiento_observaciones" value="{{$imputado->SOBRESEIMIENTO_OBSERVACIONES}}">
                </div>
              </div>           
            </div>            
            <div class="border-top pt-2 modal-footer">
              <button type="button" class="btn btn-primary" onclick="javascript:GuardarSyS('frmCausasPenalesAI_SO_{{$imputado->id}}');">Actualizar</button>
              <!-- <button type="submit" class="btn btn-primary">Actualizar</button> -->
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
          <h1 class="modal-title fs-5" id="addImputadoFormLabel">Sobreseimiento y suspensión del imputado</h1>
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
                    <label for="causa_H_tipo_sobreseimiento" class="form-label">Tipo de sobreseimiento:</label>
                    <select class="form-select" name="causa_H_tipo_sobreseimiento" id="causa_H_tipo_sobreseimiento">
                      <option value="-1">Seleccione una opción</option>
                      @foreach ($tipoSobre as $item)      
                        <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                      @endforeach      
                   </select>
                  </div>                
                  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                      <label for="causa_H_causas_sobreseimiento" class="form-label">Causas de sobreseimiento:</label>
                      <select class="form-select" name="causa_H_causas_sobreseimiento" id="causa_H_causas_sobreseimiento">
                        <option value="-1">Seleccione una opción</option>
                        @foreach ($causasSobre as $item)      
                          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                        @endforeach
                     </select>
                  </div> 
                  <div class="mb-3 col-12">
                    <label for="causa_H_sobreseimiento_observaciones" class="form-label">Observaciones:</label>
                    <input type="text" class="form-control alfanum noValidate" name="causa_H_sobreseimiento_observaciones" 
                    id="causa_H_sobreseimiento_observaciones">
                  </div>                   
                </div>
              </div> 
              <div class="mb-4 col-12 pestanaBase">
                <div class="pestanaTop">
                  <h4>Suspensión</h4>
                </div>
              </div>
              <div class="mb-3 col-12">
                <div class="row suspension">
                         
                  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                    <label for="causa_H_fecha_suspension" class="form-label">Fecha en que se determinó la suspensión:</label>
                    <input type="date" class="form-control nonum" name="causa_H_fecha_suspension" id="causa_H_fecha_suspension">
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
                      <label for="causa_H_reapertura_proceso" class="form-label">¿Hubo reapertura del proceso?</label>
                      <select class="form-select" name="causa_H_reapertura_proceso" id="causa_H_reapertura_proceso">
                        <option value="-1">Seleccione una opción</option>
                        @foreach ($SiNo as $item)      
                          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                        @endforeach        
                     </select>
                  </div>      
                  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                    <label for="causa_H_fecha_de_reanudacion" class="form-label">Fecha de reapertura del proceso:</label>
                    <input type="date" class="form-control" name="causa_H_fecha_de_reanudacion" id="causa_H_fecha_de_reanudacion">
                  </div> 
                </div>
              </div>              
            </div>        
          </form>   
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="closeaddImputadoForm" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="javascript:GuardarSyS('frmCausasPenalesAI_0');">Guardar</button>
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
  $("#causa_H_reapertura_proceso").change(function(){
    if (this.value==1) {$("#causa_H_fecha_de_reanudacion").removeClass("noValidate");}
    else{$("#causa_H_fecha_de_reanudacion").addClass("noValidate").removeClass("border-3 border-danger");}
  });

if ($("#causa_H_reapertura_proceso").val()==1) {$("#causa_H_fecha_de_reanudacion").removeClass("noValidate");}
    else{$("#causa_H_fecha_de_reanudacion").addClass("noValidate").removeClass("border-3 border-danger");}

  function GuardarSyS(formularioStr)
  {
    var respuesta=true;
    // $("#"+formularioStr+" input:not(.noValidate)").each(function(){
    //   if (this.value.length<1){respuesta=false;$(this).addClass("border-3 border-danger");}
    //   else{$(this).removeClass("border-3 border-danger");}
    // });      
    
    // $("#"+formularioStr+" select:not(.noValidate)").each(function(){
    //   if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");}
    //   else{$(this).removeClass("border-3 border-danger");}        
    // });
      if (respuesta) {
    $('#'+formularioStr).submit()
    }
    else
    {
      showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
    }

  }
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
      else
        {$("#addImputadoForm"+Seccion).hide();}
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

