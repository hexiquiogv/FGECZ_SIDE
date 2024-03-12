<div class="row causasInicial">
    <div class="mb-3 input-group">
      <label for="ddlImputados" class="input-group-text">Imputado:</label>        
      <select class="form-select" id="ddlImputados" name="ddlImputados">
        <option value="-1">Seleccione una opción</option>
        @foreach ($listados['imputadosDDL'] as $item)      
          <option value="{{$item->id}}" data-forma="{{$item->FORMA_}}"
            data-detencion="{{$item->DETENCION_LEGAL_ILEGAL}}">{{$item->Valor}}</option>      
        @endforeach       
      </select>
      <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button>
    </div>     
    @foreach($listados['imputadosCP'] as $imputado)
     <div class="accordion mb-2" id="accordionFiltrosAudienciaI_{{$imputado->id}}">
      <div class="accordion-item">
        <h2 class="accordion-header" id="panelsFiltrosAudienciaI_{{$imputado->id}}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
          data-bs-target="#panelsStayOpen-collapseOneAudienciaI_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneAudienciaI_{{$imputado->id}}">
            Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOneAudienciaI_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosAudienciaI_{{$imputado->id}}">
         <form method='post' name="frmCausasPenalesAI_{{$imputado->id}}" id="frmCausasPenalesAI_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
          <div class="accordion-body row">
            @csrf  
            <input type="hidden" name="idImputadoAI" id="idImputadoAI" value="{{$imputado->id}}">
            <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">            
              <div class="mb-4 col-12 pestanaBase">
                <div class="pestanaTop">
                  <h4>Medida cautelar</h4>
                </div>
              </div>
              <div class="mb-3 col-12">
                <div class="accordion" id="accordionFiltrosMedidas_{{$imputado->id}}">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsFiltrosMedidas_{{$imputado->id}}">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                      data-bs-target="#panelsStayOpen-collapseOneMedidas_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneMedidas_{{$imputado->id}}">
                        Listado de medidas cautelares
                      </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOneMedidas_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosMedidas_{{$imputado->id}}">
                      <div class="accordion-body row">
                        <div class="col-sm-12 input-group">
                          {{--
                          <label for="causa_H_medidas_cautelares" class="input-group-text">Medidas:</label>
                          <select class="form-select imp{{$imputado->id}}" name="causa_H_medidas_cautelares" id="causa_H_medidas_cautelares">
                            <option value="-1">Seleccione una opción</option>
                            @foreach ($SiNoNoI as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>
                            @endforeach
                          </select> 
                          --}}
                          <label for="causa_H_tipo_medidas_cautelares" class="input-group-text">Tipo:</label>
                          <select class="form-select imp{{$imputado->id}} noValidate" name="causa_H_tipo_medidas_cautelares" 
                          id="causa_H_tipo_medidas_cautelares" onchange="mostrarobservaciones({{$imputado->id}})">
                            <option value="-1">Seleccione una opción</option>
                            @foreach ($TMCautelares as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                            @endforeach        
                          </select>
                          <button type="button" title="Acumular medida" class="btn btn-outline-success" onclick="javascript:acumularMedida({{$imputado->id}})">
                          Acumular medida</button>
                        </div>
                        <div>        
                          <input type="hidden" id="hdnacumulado{{$imputado->id}}" name="hdnacumulado{{$imputado->id}}">
                          <div class="alert alert-dark mb-0" id="txtacumulado{{$imputado->id}}"></div>                          
                        </div>                      
                        <div class="col-sm-12 input-group">                        
                          <label for="causa_H_medidas_observaciones" class="input-group-text mddObs{{$imputado->id}}" style="display: none;">
                          Observaciones:</label>
                          <input type="text" class="form-control imp{{$imputado->id}} alfanum mddObs{{$imputado->id}}" 
                          style="display: none;" name="causa_H_medidas_observaciones" id="causa_H_medidas_observaciones">

                        </div>
                        <div class="col-sm-12 input-group">
                          <label for="" class="input-group-text">Temporalidad de la medida:</label>
                          <label for="" class="input-group-text">Día(s):</label>
                          <input type="text" class="form-control imp{{$imputado->id}} solonum dias noValidate" 
                          name="causa_H_temporalidad_medida_d" id="causa_H_temporalidad_medida_d">
                          <label for="" class="input-group-text">Mes(es):</label>
                          <input type="text" class="form-control imp{{$imputado->id}} solonum meses noValidate"
                          name="causa_H_temporalidad_medida_m" id="causa_H_temporalidad_medida_m">
                          <label for="" class="input-group-text">Año(s):</label>
                          <input type="text" class="form-control imp{{$imputado->id}} solonum noValidate" 
                          name="causa_H_temporalidad_medida_a" id="causa_H_temporalidad_medida_a">
                        </div>
                        <div class="mb-3 col-sm-12 input-group">                          
                          <label for="causa_H_recurrencia" class="input-group-text">Recurrencia:</label>
                          <input type="text" class="form-control imp{{$imputado->id}} alfanum" name="causa_H_recurrencia" id="causa_H_recurrencia">                          
                          {{--
                            <label for="causa_H_temporalidad_medida" class="input-group-text">Temporalidad:</label>
                            <select class="form-select imp{{$imputado->id}}" name="causa_H_temporalidad_medida" id="causa_H_temporalidad_medida">
                              <option value="-1">Seleccione una opción</option>
                              @for ($i=1;$i<4;$i++)      
                                <option value="{{ $i }}">{{$i>1? $i.' MESES':$i.' MES'}}</option>      
                              @endfor
                              <option value="4">TODO EL PROCESO</option>
                            </select>
                          --}}                          
                          <button type="button" class="btn btn-primary"onclick="javascript:addMedida({{$imputado->id}})">
                            Agregar medida
                          </button>
                        </div>
                        <input type="hidden" name="hdnMedidas{{$imputado->id}}" id="hdnMedidas{{$imputado->id}}">
                        <table id="medidas{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
                            <caption></caption>    
                            <thead class="table-light">
                            <tr>
                              <!-- <th scope="col">Medidas cautelares</th> -->
                              <th scope="col">Tipo de medida cautelar impuesta</th>
                              <th scope="col">Temporalidad de la medida</th>
                              <th scope="col">Recurrencia</th>
                              <th scope="col">Observaciones</th>
                              <th scope="col">Eliminar</th>
                            </tr>
                          </thead>
                          <tbody> 

                           @foreach ($medidas[$imputado->id] as $medida)
                            <tr class="tr{{$imputado->id}}_{{$medida->id}}">
                              {{--<td>{{$medida->MEDIDAS}}</td>--}}
                              <td>{{$medida->TIPOMEDIDA}}</td>
                              <td>{{(empty($medida->TEMPORALIDAD_MEDIDA_D??"")?"0":$medida->TEMPORALIDAD_MEDIDA_D)." día(s) ".
                                (empty($medida->TEMPORALIDAD_MEDIDA_M??"")?"0":$medida->TEMPORALIDAD_MEDIDA_M)." mes(es) ".
                                (empty($medida->TEMPORALIDAD_MEDIDA_A??"")?"0":$medida->TEMPORALIDAD_MEDIDA_A)." año(s) "}}</td>
                                <td>{{$medida->RECURRENCIA??""}}</td>
                              <td>{{$medida->MEDIDAS_OBSERVACIONES}}</td>
                              <td>
                                <button type="button" title="Eliminar medida" class="btn btn-danger" 
                                onclick="eliminarMedida('{{$imputado->id}}','{{$medida->id}}',1)">×</button>
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
<div class="modal fade" id="addImputadoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addImputadoFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-fullscreen"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addImputadoFormLabel">Medidas cautelares del imputado</h1>
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
                      <div class="col-sm-12 input-group">
                        {{--
                          <label for="causa_H_medidas_cautelares" class="input-group-text">Medidas:</label>
                          <select class="form-select imp0" name="causa_H_medidas_cautelares" id="causa_H_medidas_cautelares">
                            <option value="-1">Seleccione una opción</option>
                            @foreach ($SiNoNoI as $item)      
                              <option value="{{ $item->id }}">{{$item->Valor}}</option>
                            @endforeach
                          </select> 
                        --}}
                        <label for="causa_H_tipo_medidas_cautelares" class="input-group-text">Tipo:</label>
                        <select class="form-select imp0 noValidate" name="causa_H_tipo_medidas_cautelares" 
                        id="causa_H_tipo_medidas_cautelares" onchange="mostrarobservaciones(0)">
                          <option value="-1">Seleccione una opción</option>
                          @foreach ($TMCautelares as $item)      
                            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                          @endforeach        
                        </select>
                        <button type="button" title="Acumular medida" class="btn btn-outline-success" onclick="javascript:acumularMedida(0)">
                        Acumular medida</button>
                      </div>
                      <div>        
                        <input type="hidden" id="hdnacumulado0" name="hdnacumulado0">
                        <div class="alert alert-dark mb-0" id="txtacumulado0"></div>                          
                      </div>                      
                      <div class="col-sm-12 input-group">
                        <label for="causa_H_medidas_observaciones" class="input-group-text mddObs0" style="display: none;">
                        Observaciones:</label>
                        <input type="text" class="form-control imp0 alfanum mddObs0" 
                          style="display: none;" name="causa_H_medidas_observaciones" id="causa_H_medidas_observaciones">

                      </div>
                      <div class="col-sm-12 input-group">
                          <label for="" class="input-group-text">Temporalidad de la medida:</label>
                          <label for="causa_H_temporalidad_medida_d" class="input-group-text">Día(s):</label>
                          <input type="text" class="form-control imp0 solonum dias noValidate" 
                          name="causa_H_temporalidad_medida_d" id="causa_H_temporalidad_medida_d">
                          <label for="causa_H_temporalidad_medida_m" class="input-group-text">Mes(es):</label>
                          <input type="text" class="form-control imp0 solonum meses noValidate" 
                          name="causa_H_temporalidad_medida_m" id="causa_H_temporalidad_medida_m">
                          <label for="causa_H_temporalidad_medida_a" class="input-group-text">Año(s):</label>
                          <input type="text" class="form-control imp0 solonum noValidate" 
                          name="causa_H_temporalidad_medida_a" id="causa_H_temporalidad_medida_a">
                      </div>
                      <div class="mb-3 col-sm-12 input-group">                          
                          <label for="causa_H_recurrencia" class="input-group-text">Recurrencia:</label>
                          <input type="text" class="form-control imp0 alfanum" name="causa_H_recurrencia" id="causa_H_recurrencia">                          
                          {{--
                            <label for="causa_H_temporalidad_medida" class="input-group-text">Temporalidad:</label>
                            <select class="form-select imp0" name="causa_H_temporalidad_medida" id="causa_H_temporalidad_medida">
                              <option value="-1">Seleccione una opción</option>
                              @for ($i=1;$i<4;$i++)      
                                <option value="{{ $i }}">{{$i>1? $i.' MESES':$i.' MES'}}</option>
                              @endfor
                              <option value="4">TODO EL PROCESO</option>
                            </select>
                          --}}
                        <button type="button" class="btn btn-primary"onclick="javascript:addMedida(0)">
                          Agregar medida
                        </button>
                      </div>
                      
                      <input type="hidden" name="hdnMedidas0" id="hdnMedidas0">
                      <table id="medidas0" class="col-12 table table-striped table-hover table-responsive caption-top">
                          <caption></caption>    
                          <thead class="table-light">
                          <tr>
                            <!-- <th scope="col">Medidas cautelares</th> -->
                            <th scope="col">Tipo de medida cautelar impuesta</th>
                            <th scope="col">Temporalidad de la medida</th>
                            <th scope="col">Recurrencia</th>
                            <th scope="col">Observaciones</th>
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
        // var conjunto = [];
        // if (!conjunto.includes(this.id.replace(/_([^_]+)$/, ''))) {
        //   event.preventDefault(); // Prevent the default form submission
        //   var respuesta=true;
        //   var campos=[];
        //   $("#"+this.id+" input:not(.noValidate):visible").each(function(){
        //     if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        //     else{$(this).removeClass("border-3 border-danger");}
        //   });      

        //   $("#"+this.id+" select:not(.noValidate):visible").each(function(){
        //     if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
        //     else{$(this).removeClass("border-3 border-danger");}        
        //   });
        //   if (respuesta) {this.submit();}
        //   else
        //   {
        //     showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
        //   }
        // }
      if (this.id.replace(/_([^_]+)$/, '')=="frmCausasPenalesAI") {
          if ($("#medidas"+this.id.split("_").pop()+" tbody tr").length<1)
          {
            event.preventDefault(); // Prevent the default form submission
            //respuesta=false; showtoast('Se debe agregar por lo menos una medida','danger_medidas');
            respuesta=false; showtoast('No hay ninguna medida registrada para guardar.','info_medidas');
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

  if (formularioID.replace(/_([^_]+)$/, '')=="frmCausasPenalesAI") {
    var hdnacumulado=$("#hdnacumulado"+formularioID.split("_").pop());
    var tipoMand=$("#causa_H_tipo_medidas_cautelares.imp"+formularioID.split("_").pop());
    if (hdnacumulado.val().length<1 && tipoMand.val()<0) {
      respuesta=false;tipoMand.addClass("border-3 border-danger");campos.push("causa_H_tipo_medidas_cautelares");
      $("#txtacumulado"+formularioID.split("_").pop()).addClass("border-3 border-danger");
    }
    else{tipoMand.removeClass("border-3 border-danger");
      $("#txtacumulado"+formularioID.split("_").pop()).removeClass("border-3 border-danger");}

      if ($("#"+formularioID+" #causa_H_temporalidad_medida_d").val().trim().length<1 &&
        $("#"+formularioID+" #causa_H_temporalidad_medida_m").val().trim().length<1 &&
        $("#"+formularioID+" #causa_H_temporalidad_medida_a").val().trim().length<1) {
        respuesta=false;
        $("#"+formularioID+" #causa_H_temporalidad_medida_d").addClass("border-3 border-danger");
        $("#"+formularioID+" #causa_H_temporalidad_medida_m").addClass("border-3 border-danger");
        $("#"+formularioID+" #causa_H_temporalidad_medida_a").addClass("border-3 border-danger");
        showtoast('<h6>&times; Validación</h6><hr>Debe capturarse la temporalidad de la medida','danger_dma');
      }
      else{
        $("#"+formularioID+" #causa_H_temporalidad_medida_d").removeClass("border-3 border-danger");
        $("#"+formularioID+" #causa_H_temporalidad_medida_m").removeClass("border-3 border-danger");
        $("#"+formularioID+" #causa_H_temporalidad_medida_a").removeClass("border-3 border-danger");
      }
  }

  if (!respuesta) {showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');}
    return respuesta;
}

$(".dias").on( "keyup", function() {
  if(this.value>31)
    {this.value='';}
} );
$(".meses").on( "keyup", function() {
  if(this.value>12)
    {this.value='';}
} );
$(".monto").mask("#,##0.00",{reverse: true});
$(".solonum").mask("00");
$(".temporalidadMA").mask('TTTT',
  {translation:  {'T': {pattern: /[0-9añosmeAÑOSME\,\s]/, recursive: true}}});
$(".alfanum").mask('XXXX',
    {translation:  {'X': {pattern: /[0-9a-zA-Z\s]/, recursive: true}}});
$(".temporalidad").mask('YYYY',
    {translation:  {'Y': {pattern: /[0-9díiasDÍIAS\s]/, recursive: true}}});      
  $(".nonum").mask('ZZZZ',
    {translation:  {'Z': {pattern: /[a-zA-Z\s]/, recursive: true}}});
  
    $("#causa_H_audiencia_inicial").change(function() {
    if (this.value==0) {$(".motivoNo").show();}
    else
    {
      $(".motivoNo").hide();
      $("#causa_H_motivo_noaud").val('-1');
    }
      });
  if ($("#causa_H_audiencia_inicial").val()==0) 
    {$(".motivoNo").show();}
    else
    {
      $(".motivoNo").hide();
      $("#causa_H_motivo_noaud").val('-1');
    }  

  function addImputadoFormModal()
  {
    if ($("#ddlImputados").val()>-1) {
     $("#frmCausasPenalesAI_0 #idImputado").val($("#ddlImputados").val());
     if($("#ddlImputados :selected").data().detencion==1)
     {
     $("#frmCausasPenalesAI_0 #causa_H_decreto_legal_detencion").val(1); 
     }
     if($("#ddlImputados :selected").data().detencion==2)
     {
     $("#frmCausasPenalesAI_0 #causa_H_decreto_legal_detencion").val(0); 
     }
     if($("#ddlImputados :selected").data().forma==1)
     {
     $("#frmCausasPenalesAI_0 #causa_H_forma_de_conduccion_del_imputado_a_proceso").val(5); 
     }          
     $("#addImputadoForm").modal("show");
    }
  }
    function mostrarobservaciones(imputado)
    {
      if ($("#causa_H_tipo_medidas_cautelares.imp"+imputado).val()==17)
        {$(".mddObs"+imputado).show();}
      else
        {
          if ($("#causa_H_tipo_medidas_cautelares.imp"+imputado+" option[value=17]:disabled").length == 0) {
          $(".mddObs"+imputado).hide();
          }
          else
          {$(".mddObs"+imputado).show();}
        }
    }
  function acumularMedida(imputado)
  {   
    var id=-1;
    var valor='';
    id=$("#causa_H_tipo_medidas_cautelares.imp"+imputado+" :selected").val();
    valor=$("#causa_H_tipo_medidas_cautelares.imp"+imputado+" :selected").text();

    if (id>-1) {
      var badge="<span class='mx-1 badge rounded-pill bg-info text-dark' id='span_"+id+"'>"+valor+
      "<button type='button' class='btn-close' onclick='eliminarMedidaA(this,\""+imputado+"\")'></button></span>";
      
      var ids = JSON.parse("["+$("#hdnacumulado"+imputado).val()+"]");      
         if (!(ids.includes(parseInt(id)))) {
            ids.push(id.toString());
            $("#causa_H_tipo_medidas_cautelares.imp"+imputado+" :selected").attr('disabled',true);
            $("#causa_H_tipo_medidas_cautelares.imp"+imputado).val(-1);
            $("#hdnacumulado"+imputado).val(ids.toString());
            $("#txtacumulado"+imputado).append(badge);
        }
    }
  }
  function eliminarMedidaA(element,imputado)
  {   
      var ids = JSON.parse("["+$("#hdnacumulado"+imputado).val()+"]");
      var id=element.parentElement.id.slice(5);      
      if (ids.includes(parseInt(id))) {              
              var result=ids.filter(function(ele){  return ele != id; });
          $("#hdnacumulado"+imputado).val(result.toString());
          $("#causa_H_tipo_medidas_cautelares.imp"+imputado+" option[value="+id+"]").attr('disabled',false);
          element.parentElement.remove();
      }
      mostrarobservaciones(imputado);
  }    
    function addMedida(imputado,ciclo=0)
    {
      if(validateAddRow("frmCausasPenalesAI_"+imputado)){
        var temporalidadtxt="";
        if($("#causa_H_temporalidad_medida_d.imp"+imputado).val().trim().length>0)
        {temporalidadtxt+=$("#causa_H_temporalidad_medida_d.imp"+imputado).val().trim()+" día(s) "}
        if($("#causa_H_temporalidad_medida_m.imp"+imputado).val().trim().length>0)
        {temporalidadtxt+=$("#causa_H_temporalidad_medida_m.imp"+imputado).val().trim()+" mes(es) "}
        if($("#causa_H_temporalidad_medida_a.imp"+imputado).val().trim().length>0)
        {temporalidadtxt+=$("#causa_H_temporalidad_medida_a.imp"+imputado).val().trim()+" año(s) "}

       if ($("#hdnacumulado"+imputado).val().length>0 && ciclo==0) {
        if (temporalidadtxt.length > 0) {
            var seleccionado=$("#causa_H_tipo_medidas_cautelares.imp"+imputado).val();
          var valores = $("#hdnacumulado"+imputado).val().split(",");
          $.each(valores, function(index, value) {
            $("#span_"+value+" .btn-close").click() 
            $("#causa_H_tipo_medidas_cautelares.imp"+imputado).val(value);
            addMedida(imputado,1);
          });
          $("#hdnacumulado"+imputado).val('');
          if (seleccionado<0) {
            $("#causa_H_temporalidad_medida_d.imp"+imputado).val('');
            $("#causa_H_temporalidad_medida_m.imp"+imputado).val('');
            $("#causa_H_temporalidad_medida_a.imp"+imputado).val('');
            $("#causa_H_recurrencia.imp"+imputado).val('');
            $("#causa_H_medidas_observaciones.imp"+imputado).val('');
          }
          $("#causa_H_tipo_medidas_cautelares.imp"+imputado).val(seleccionado);
        }
       }
        if ($("#causa_H_tipo_medidas_cautelares.imp"+imputado).val()>-1 ) {
          if (temporalidadtxt.length>0) {

            var jsonn="";        
            var idjson=0;
            if ($("#hdnMedidas"+imputado).val().length>0) {
             var json=JSON.parse("["+$("#hdnMedidas"+imputado).val().replace(/,+$/,"")+"]");
             idjson= json.sort(function(a, b) {
                       return parseFloat(b['id']) - parseFloat(a['id']);
                    })[0]['id']+1;
            }
            
            // jsonn='{"id":'+idjson+',"imputado":'+imputado+',"medida":"'+$("#causa_H_medidas_cautelares.imp"+imputado).val()+'",'+
            var vtipo=$("#causa_H_tipo_medidas_cautelares.imp"+imputado).val();
            var vobservaciones=vtipo==17?$("#causa_H_medidas_observaciones.imp"+imputado).val().trim():"";
            jsonn='{"id":'+idjson+',"imputado":'+imputado+',"observaciones":"'+vobservaciones+'",'+'"tipo":"' +vtipo+'"'+
            ',"temporalidad_d":"' +$("#causa_H_temporalidad_medida_d.imp"+imputado).val().trim()+'"'+
            ',"temporalidad_m":"' +$("#causa_H_temporalidad_medida_m.imp"+imputado).val().trim()+'"'+
            ',"temporalidad_a":"' +$("#causa_H_temporalidad_medida_a.imp"+imputado).val().trim()+'"'+
            ',"recurrencia":"' +$("#causa_H_recurrencia.imp"+imputado).val().trim()+'"}';

            $("#hdnMedidas"+imputado).val($("#hdnMedidas"+imputado).val()+jsonn+",");        

            // var newrow="<tr class='tr"+imputado+"_"+idjson+"'><td>"+$("#causa_H_medidas_cautelares.imp"+imputado+" :selected").text()+
            var newrow="<tr class='tr"+imputado+"_"+idjson+"'>"+
              "<td>"+$("#causa_H_tipo_medidas_cautelares.imp"+imputado+" :selected").text()+"</td>"+
              "<td>"+temporalidadtxt+"</td><td>"+$("#causa_H_recurrencia.imp"+imputado).val().trim()+"</td>"+
              "<td>"+vobservaciones+"</td>"+
              "<td><button type='button' title='Eliminar medida' class='btn btn-danger' "+
              "onclick='eliminarMedida(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";

            $("#medidas"+imputado+" tbody").append(newrow);
            //$("#causa_H_medidas_cautelares.imp"+imputado).val(-1);
            $("#causa_H_tipo_medidas_cautelares.imp"+imputado).val(-1);
            if (ciclo==0) {
              $("#causa_H_temporalidad_medida_d.imp"+imputado).val('');
              $("#causa_H_temporalidad_medida_m.imp"+imputado).val('');
              $("#causa_H_temporalidad_medida_a.imp"+imputado).val('');
              $("#causa_H_recurrencia.imp"+imputado).val('');
              $("#causa_H_medidas_observaciones.imp"+imputado).val('');        
              $(".mddObs"+imputado).hide();
            }
          }
        }
      }
    }
    function eliminarMedida(imputado,id,DB=0)
    {
      if (DB==1) {
        eliminarReload(id,'cpmcme');
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

