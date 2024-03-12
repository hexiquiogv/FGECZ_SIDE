
<div class="accordion" id="accordionFiltrosImputados">
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsFiltrosImputados">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsStayOpen-collapseOneImputados" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneImputados">
        Imputados
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOneImputados" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosImputados">
      <div class="accordion-body">
        <div class="text-end">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addImputadoForm">
            agregar persona imputada
            <!-- <span class="badge rounded-pill bg-primary position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">+</span> -->
          </button>
        </div>
        <input type="hidden" name="hdnImputadosCP" id="hdnImputadosCP">
        <table class="table table-sm align-middle table-responsive-sm caption-top" id="tbImputadosCP">
            <caption>Listado de imputados</caption>    
          <thead class="table-light">     
          </thead>
          <tbody>
            @foreach($imputadosCP as $imputado)
              <tr class="tr{{$imputado->id}} table-secondary">
                <th rowspan="5">{{$imputado->id}}</th>
                <th colspan="8"></th>
                <th>Eliminar</th>
              </tr>
              <tr class="tr{{$imputado->id}}">
                <th>Nombre</th><td colspan="3">{{$imputado->Nombre}}</td>
                <th>Sexo</th><td>{{$imputado->Sexo}}</td>
                <th colspan="2">Edad al momento de los hechos</th><td>{{$imputado->EDAD_HECHOS_IMPUTADOS}}</td>                
              </tr>
              <tr class="tr{{$imputado->id}}">
                <th>Delitos</th><td colspan="3">{{$imputado->delitos}}</td>
                <th>Victimas</th><td colspan="3">{{$imputado->victimas}}</td>
                <th class="text-center">
                  <button type="button" title="Eliminar imputado" class="btn btn-danger" onclick="delImputadoCP('{{$imputado->id}}',1)">&times;</button>
                </th>
              </tr>
              <tr class="tr{{$imputado->id}}">
                <th>Tipo de mandamiento judicial</th><td>{{$imputado->tipoMandamiento}}</td>
                <th>¿Con o sin detenido?</th><td>{{$imputado->forma}}</td>
                <th>Tipo de detención</th><td>{{$imputado->detencion}}</td>
                <th colspan="2">Forma en la que lleva su proceso</th><td>{{$imputado->forma_proceso}}</td>
                <!--<th>Forma en la que lleva su proceso:</th><td>{{$imputado->forma}}</td>
                <th>Fecha de mandamiento judicial:</th><td>{{$imputado->FECHA_MANDAMIENTO}}</td>
                <th>Estatus de mandamiento judicial:</th><td>{{$imputado->estatus}}</td>
                <th>Fecha de libramiento del mandamiento:</th><td>{{$imputado->FECHA_LIBERA}}</td> -->
              </tr>
              <tr class="tr{{$imputado->id}}"><th>Observaciones</th><td colspan="7">{{$imputado->OBSERVACIONES_ILEGAL}}</td></tr>
              {{--<tr class="tr{{$imputado->id}}">
                <th>¿El asunto se derivó a MASC?</th><td>{{$imputado->MASC1}}</td>
                <th>Fecha en que se deriva a MASC</th><td>{{$imputado->FECHA_DERIVA_MASC}}</td>
                <th>Fecha en que se cumplimentó el MASC</th><td>{{$imputado->FECHA_CUMPL_MAS}}</td>
              </tr>
              <tr class="tr{{$imputado->id}}">
                <th>Tipo de cumplimiento</th><td>{{$imputado->MASC4}}</td>
                <th>Tipo de MASC</th><td>{{$imputado->MASC5}}</td>
                <th>Autoridad que deriva a MASC</th><td>{{$imputado->MASC6}}</td>
              </tr>--}}
              <tr class="tr{{$imputado->id}} border-top">
                <td colspan="10"></td>
              </tr>
            @endforeach
          </tbody>
        </table>      
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="addImputadoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addImputadoFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addImputadoFormLabel">Agregar imputado a causa penal</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="mb-3 input-group">
            <label for="ddlImputado" class="input-group-text">Imputado:</label>
            <select class="form-select" name="ddlImputado" id="ddlImputado" onchange="SINOdetenido(this)">
              <option value="-1">Seleccione una opción</option>
              @foreach ($listados['imputados'] as $item)      
                <option value="{{ $item->id }}" data-addrow="{{$item->addrow}}" 
                  data-detenido="{{$item->DETENIDO_IMPUTADOS}}">{{$item->Valor}}</option>      
              @endforeach                 
           </select>
          </div>    
          <div class="mb-3 input-group">
              <label for="ddlD" class="input-group-text">Delito:</label>
              <select class="form-select noValidate" id="ddlD" name="ddlD">
                <option value="-1">Seleccione una opción</option>
                @foreach($delitosCP as $delito2)
                  <option value="{{$delito2->idDelito}}">{{$delito2->Valor}}</option>
                @endforeach
              </select>
              <button type="button" title="Agregar delito" class="btn btn-outline-success" onclick="javascript:acumularRelacion('D')">Agregar delito</button>
          </div>
          <div class="mb-3">        
            <input type="hidden" id="hdnacumuladoD" name="hdnacumuladoD">
            <div class="alert alert-dark" id="txtacumuladoD">                  
            </div>                          
          </div>
          <div class="mb-3 input-group">
            <label for="ddlV" class="input-group-text">Víctima:</label>        
            <select class="form-select noValidate" id="ddlV" name="ddlV">
                <option value="-1">Seleccione una opción</option>
                @foreach($victimasCP as $victima2)
                  <option value="{{$victima2->idVictima}}">{{$victima2->TIPO_VICTIMA == 2 ? $victima2->RAZON_SOCIAL:
                    ($victima2->TIPO_VICTIMA == 3 ? 'LA SOCIEDAD':
                      ($victima2->TIPO_VICTIMA == 5 ? 'SIN IDENTIFICAR/DESCONOCIDO':
                        ($victima2->TIPO_VICTIMA == 7 ? 'LA SALUD':
                          $victima2->NOMBRE_VICTIMA.' '.$victima2->PRIMER_APELLIDO.' '.$victima2->SEGUNDO_APELLIDO_VICTIMAS)))}}
                  </option>
                @endforeach                  
            </select>
            <button type="button" title="Agregar víctima" class="btn btn-outline-success" onclick="javascript:acumularRelacion('V')">Agregar víctima</button>        
          </div>
          <div class="mb-3">        
              <input type="hidden" id="hdnacumuladoV" name="hdnacumuladoV">
              <div class="alert alert-dark" id="txtacumuladoV">    
              </div>                          
          </div>                     
          <div class="col-12"></div>
          {{--COMENTADO 29/05/2023 MxCONJ01_Ajustes SIDE (Causas Penales)_20230504
            <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
              <label for="causa_H_forma_proceso" class="form-label">Forma en la que lleva su proceso:</label>
              <select class="form-select noValidate" name="causa_H_forma_proceso" id="causa_H_forma_proceso">
                <option value="-1">Seleccione una opción</option>
                @foreach ($formaProc as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach              
             </select>
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
              <label for="causa_H_fecha_mandamiento" class="form-label">Fecha de mandamiento judicial:</label>
              <input type="date" class="form-control noValidate" name="causa_H_fecha_mandamiento" id="causa_H_fecha_mandamiento" value="">
            </div> 
            <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
              <label for="causa_H_estatus_mandamiento" class="form-label">Estatus de mandamiento judicial:</label>
              <select class="form-select noValidate" name="causa_H_estatus_mandamiento" id="causa_H_estatus_mandamiento">
                <option value="-1">Seleccione una opción</option>
                @foreach ($estatusMJ as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach               
             </select>
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
              <label for="causa_H_fecha_libera" class="form-label">Fecha de libramiento del mandamiento:</label>
              <input type="date" class="form-control noValidate" name="causa_H_fecha_libera" id="causa_H_fecha_libera" value="">
            </div> 
          --}}
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_forma_" class="form-label">¿Con o sin detenido?</label>
            <select class="form-select" name="causa_H_forma_" id="causa_H_forma_">
            <option value="-1">Seleccione una opción</option>
                @foreach ($formaInicioCarpeta as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach     
           </select>
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_detencion_legal_ilegal" class="form-label">Tipo de detención:</label>
            <select class="form-select noValidate" name="causa_H_detencion_legal_ilegal" id="causa_H_detencion_legal_ilegal">
            <option value="-1">Seleccione una opción</option>
                @foreach ($detencionLI as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>
                @endforeach
           </select>
          </div>
          <div class="mb-3 col-sm-12 col-md-12 col-lg-12 ilegal" style="display:none;">
            <label for="causa_H_observaciones_ilegal" class="form-label">Observaciones:</label>
            <input type="text" class="form-control noValidate alfanum" name="causa_H_observaciones_ilegal" id="causa_H_observaciones_ilegal">
          </div>                    
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_forma_proceso" class="form-label">Forma en la que lleva su proceso:</label>
            <select class="form-select noValidate" name="causa_H_forma_proceso" id="causa_H_forma_proceso">
              <option value="-1">Seleccione una opción</option>
              @foreach ($formaProc as $item)      
                <option value="{{ $item->id }}">{{$item->Valor}}</option>      
              @endforeach              
           </select>
          </div>          
          {{--
            <div class="mb-4 col-12 pestanaBase">
              <div class="pestanaTop">
                <h4>Datos MASC de Poder Judicial</h4>
              </div>
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_masc" class="form-label">¿El asunto se derivó a MASC de Poder Judicial?</label>
              <select class="form-select" name="causa_H_masc" id="causa_H_masc">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNoNoI as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>
                @endforeach   
             </select>
            </div>  
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 masc">
              <label for="causa_H_fecha_deriva_masc" class="form-label">Fecha en que se deriva a MASC:</label>
              <input type="date" class="form-control noValidate" name="causa_H_fecha_deriva_masc" id="causa_H_fecha_deriva_masc" value="">
            </div>
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 masc">
              <label for="causa_H_fecha_cumpl_mas" class="form-label">Fecha en que se cumplimentó el MASC:</label>
              <input type="date" class="form-control noValidate" name="causa_H_fecha_cumpl_mas" id="causa_H_fecha_cumpl_mas" 
              value="">
            </div> 
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 masc">
              <label for="causa_H_tipo_cumplimiento" class="form-label">Tipo de cumplimiento:</label>
              <select class="form-select noValidate" name="causa_H_tipo_cumplimiento" id="causa_H_tipo_cumplimiento">
                <option value="-1">Seleccione una opción</option>
                @foreach ($tipoCump as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach   
              </select>
            </div>  
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 masc">
                <label for="causa_H_tipo_masc" class="form-label">Tipo de MASC:</label>
                <select class="form-select noValidate" name="causa_H_tipo_masc" id="causa_H_tipo_masc">
                  <option value="-1">Seleccione una opción</option>
                  @foreach ($tipoMASC as $item)      
                    <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                  @endforeach  
               </select>
            </div>  
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 masc">
              <label for="causa_H_autoridad_deriva_masc" class="form-label">Autoridad que deriva a MASC :</label>
              <select class="form-select noValidate" name="causa_H_autoridad_deriva_masc" id="causa_H_autoridad_deriva_masc">
                <option value="-1">Seleccione una opción</option>
                  @foreach ($autMASC as $item)      
                    <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                  @endforeach  
             </select>
            </div>
          --}}          
        </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="closeaddImputadoForm" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:saveImputadoCP()">Agregar</button>
      </div>
      <p class=" p-2 text-end">* Para guarda los datos de esta sección se debe dar clic en el botón de "Guardar", abajo de Observaciones.</p>
    </div>
  </div>
</div>  
<script type="text/javascript">
  $("#causa_H_detencion_legal_ilegal").change(function(){
    if (this.value==2) {
      $(".ilegal").show();
    }
    else
    {
      $("#causa_H_observaciones_ilegal").val('');
      $(".ilegal").hide();
    }
  });
 $(function() {
    $("#hdnImputadosCP").val('');
  });
  $("#causa_H_forma_").on("change",function(){
    if (this.value==1) { $("#causa_H_detencion_legal_ilegal").removeClass("noValidate");}
    else{$("#causa_H_detencion_legal_ilegal").addClass("noValidate");$("#causa_H_detencion_legal_ilegal").removeClass("border-3 border-danger");}
  });
   function SINOdetenido(element)
   {
    if($("#"+element.id+" :selected").data().detenido==1)
    {$("#causa_H_forma_").val(1).change();}
    else if($("#"+element.id+" :selected").data().detenido==0)
    {$("#causa_H_forma_").val(2).change();} 
    else{$("#causa_H_forma_").val(-1).change();}

   }
  function acumularRelacion(tipo)
  {   
    var id=-1;
    var valor='';
    id=$("#ddl"+tipo+" :selected").val();
    valor=$("#ddl"+tipo+" :selected").text();

    if (id>-1) {
     if ($("#ddlImputado :selected").val()>=0) {
      var badge="<span class='mx-1 badge rounded-pill bg-info text-dark' id='span_"+id+"'>"+valor+
      "<button type='button' class='btn-close' onclick='eliminarRelacion(this,\""+tipo+"\")'></button></span>";
      
      var ids = JSON.parse("["+$("#hdnacumulado"+tipo).val()+"]");      
        if (!(ids.includes(parseInt(id)))) {
            ids.push(id.toString());
            var victimas="";delitos="";
            if (tipo=='V') {
              victimas=ids.toString();delitos=$("#hdnacumuladoD").val();
            }
            else{
              delitos=ids.toString();;victimas=$("#hdnacumuladoV").val()
            }
          if (ValidarRelacion($("#ddlImputado :selected").val(),victimas,delitos)) {
            $("#ddl"+tipo+" :selected").attr('disabled',true);
            $("#ddl"+tipo).val(-1);
            $("#hdnacumulado"+tipo).val(ids.toString());
            $("#txtacumulado"+tipo).append(badge);
          }
          else{showtoast('&times; Esa relación de imputado-delito-víctima ya existe','danger');}
        }
     }else{showtoast('Antes de agregar un'+(tipo=='V'?'a víctima':' delito')+' es necesario elegir un imputado','warning');}
    }
  }
  function eliminarRelacion(element,tipo)
  {   
      var ids = JSON.parse("["+$("#hdnacumulado"+tipo).val()+"]");
      var id=element.parentElement.id.slice(5);
      if (ids.includes(parseInt(id))) {              
              var result=ids.filter(function(ele){  return ele != id; });
          $("#hdnacumulado"+tipo).val(result.toString());
          $("#ddl"+tipo+" option[value="+id+"]").attr('disabled',false);
          element.parentElement.remove();

      }       
  }
  function validSaveImputadoCP()
  {
    var respuesta=true;
      $("#addImputadoForm input:not(.noValidate)").each(function(){
        if (this.value.length<1){respuesta=false;$(this).addClass("border-3 border-danger");}
        else{$(this).removeClass("border-3 border-danger");}
      });
      
      $("#addImputadoForm div .alert-dark").each(function(){
        if($(this).html().trim(" ").length<1){respuesta=false;$(this).addClass("border-3 border-danger");}
          else{$(this).removeClass("border-3 border-danger");}
      });
      
      $("#addImputadoForm select:not(.noValidate)").each(function(){
        if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");}
        else{$(this).removeClass("border-3 border-danger");}        
      });
    return respuesta;
  }
  function saveImputadoCP()
  {
    
    if (!validSaveImputadoCP()) {
      showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
    }
    else
    {
        //#region Sección 1
          var idsD = JSON.parse("["+$("#hdnacumuladoD").val()+"]");
          var idsV = JSON.parse("["+$("#hdnacumuladoV").val()+"]");
          var txtdelitos="";
          var txtvictimas="";
          $.each(idsD,function(key,value)
          {
            txtdelitos+=$("#ddlD option[value="+value+"]").text()+",";
          });
          txtdelitos=txtdelitos.replace(/,+$/,"");

          $.each(idsV,function(key,value)
          {
            txtvictimas+=$("#ddlV option[value="+value+"]").text()+",";
          });
          txtvictimas=txtvictimas.replace(/,+$/,"");

          var id=$("#ddlImputado :selected").val();var Nombre=$("#ddlImputado :selected").text(); 
          var Sexo=$("#ddlImputado :selected").data().addrow.split("|")[0]; var Edad=$("#ddlImputado :selected").data().addrow.split("|")[1];
          var Delitos=txtdelitos;var Victimas=txtvictimas; var TipoM=$("#ddlImputado :selected").data().addrow.split("|")[2];
          var Forma=$("#causa_H_forma_ :selected").val();var FormaTXT=$("#causa_H_forma_ :selected").text();          
          var Detencion=$("#causa_H_detencion_legal_ilegal :selected").val();
          var DetencionTXT=Detencion>=0?$("#causa_H_detencion_legal_ilegal :selected").text():'';
          var ObsIlegal=$("#causa_H_observaciones_ilegal").val();
          var FormaProceso=$("#causa_H_forma_proceso :selected").val();
          var FormaProcesoTXT=FormaProceso>=0?$("#causa_H_forma_proceso :selected").text():'';
          
          
            // var MASC1=$("#causa_H_masc :selected").val();
            // var MASC1TXT=$("#causa_H_masc :selected").text();
            // var MASC2=$("#causa_H_fecha_deriva_masc").val();
            // var MASC3=$("#causa_H_fecha_cumpl_mas").val();
            // var MASC4=$("#causa_H_tipo_cumplimiento :selected").val();
            // var MASC4TXT=$("#causa_H_tipo_cumplimiento :selected").text();
            // var MASC5=$("#causa_H_tipo_masc :selected").val();
            // var MASC5TXT=$("#causa_H_tipo_masc :selected").text();
            // var MASC6=$("#causa_H_autoridad_deriva_masc :selected").val();
            // var MASC6TXT=$("#causa_H_autoridad_deriva_masc :selected").text();
            // var Forma=$("#causa_H_forma_proceso :selected").val();var FormaTXT=$("#causa_H_forma_proceso :selected").text();var FechaM=$("#causa_H_fecha_mandamiento").val();
            // var Estatus=$("#causa_H_estatus_mandamiento :selected").val();var EstatusTXT=$("#causa_H_estatus_mandamiento :selected").text();var FechaL=$("#causa_H_fecha_libera").val();

           var jsonn="";        
           var idjson=0;
          if ($("#hdnImputadosCP").val().length>0) {
             var json=JSON.parse("["+$("#hdnImputadosCP").val().replace(/,+$/,"")+"]");
             idjson= json.sort(function(a, b) {
                       return parseFloat(b['id']) - parseFloat(a['id']);
                    })[0]['id']+1;
            }
            
             //jsonn=id+"=>"+$("#hdnacumuladoV").val()+"=>"+$("#hdnacumuladoD").val()+"=>"+Forma+"=>"+FechaM+"=>"+Estatus+"=>"+FechaL;
             // jsonn='{"id":'+idjson+',"imputado":'+id+',"victimas":"'+$("#hdnacumuladoV").val()+'",'+
             // '"delitos":"' +$("#hdnacumuladoD").val()+'","forma":"'+Forma+'","fechaM":"'+FechaM+'","estatus":"'+Estatus+'",'+
             // '"fechaL":"'+FechaL+'"}';
             //  jsonn='{"id":'+idjson+',"imputado":'+id+',"victimas":"'+$("#hdnacumuladoV").val()+'",'+
             // '"delitos":"' +$("#hdnacumuladoD").val()+'","forma":"'+Forma+'","detencion":"'+Detencion+'"'+
             // ',"masc1":"'+MASC1+'","masc2":"'+MASC2+'","masc3":"'+MASC3+'"'+
             // ',"masc4":"'+MASC4+'","masc5":"'+MASC5+'","masc6":"'+MASC6+'"}';
           jsonn='{"id":'+idjson+',"imputado":'+id+',"victimas":"'+$("#hdnacumuladoV").val()+'",'+
           '"delitos":"' +$("#hdnacumuladoD").val()+'","forma":"'+Forma+'","detencion":"'+Detencion+'","formaproceso":"'+FormaProceso+'","observaciones":"'+ObsIlegal+'"'+
           ',"masc1":"MASC1__'+idjson+'__","masc2":"MASC2__'+idjson+'__","masc3":"MASC3__'+idjson+'__"'+
           ',"masc4":"MASC4__'+idjson+'__","masc5":"MASC5__'+idjson+'__","masc6":"MASC6__'+idjson+'__"}';
           if (ValidarRelacion(id,$("#hdnacumuladoV").val(),$("#hdnacumuladoD").val())) {
            var select = document.getElementById('ddlImputadosMASC');
            var existeOpcion = false;            
            for (var i = 0; i < select.options.length; i++) {
                if (select.options[i].value === id) {
                    existeOpcion = true;
                    break;
                }
            }
              // var filaConNombre= $("#tbImputadosMASC tr").filter(function() {
              //   return $(this).find("td").text().includes('ALEJANDRO QUESADA BENAVIDES');
              // });
              //existeOpcion=filaConNombre.length>0;
            if (!existeOpcion) {$("#ddlImputadosMASC").append('<option data-idImp="'+idjson+'" value="' + idjson + '">'+idjson+ ' : ' + Nombre + '</option>')};
            $("#hdnImputadosCP").val($("#hdnImputadosCP").val()+jsonn+",");
              // var newrow='<tr class="tr'+idjson+' table-secondary"><th rowspan="6">'+id+'</th><th colspan="8"></th><th>Eliminar</th></tr>'+
              //     '<tr class="tr'+idjson+'"><th>Nombre</th><td colspan="3">'+Nombre+'</td>'+
              //     '<th>Sexo</th><td>'+Sexo+'</td><th>Edad al momento de los hechos</th><td>'+Edad+'</td>'+
              //     '<th rowspan="5" class="text-center">'+
              //     '<button type="button" title="Eliminar imputado" class="btn btn-danger" onclick="delImputadoCP(\''+idjson+'\')">&times;</button>'+
              //     '</th></tr>'+
              //     '<tr class="tr'+idjson+'"><th>Delitos</th><td colspan="3">'+Delitos+'</td>'+
              //     '<th>Victimas</th><td colspan="3">'+Victimas+'</td></tr><tr class="tr'+idjson+'">'+
              //     '<th>Tipo de mandamiento judicial</th><td>'+TipoM+'</td><th>¿Con o sin detenido?</th>'+
              //     '<td>'+FormaTXT+'</td><th>Tipo de detención</th><td>'+DetencionTXT+'</td></tr>'+            
              //     '<tr class="tr'+idjson+'"><th>¿El asunto se derivó a MASC?</th><td>'+MASC1TXT+'</td>'+
              //     '<th>Fecha en que se deriva a MASC</th><td>'+MASC2+'</td>'+
              //     '<th>Fecha en que se cumplimentó el MASC</th><td>'+MASC3+'</td>'+
              //     '</tr><tr class="tr'+idjson+'"><th>Tipo de cumplimiento</th><td>'+MASC4TXT+'</td>'+
              //     '<th>Tipo de MASC</th><td>'+MASC5TXT+'</td>'+
              //     '<th>Autoridad que deriva a MASC</th><td>'+MASC6TXT+'</td></tr>'+
              //     '<tr class="tr'+idjson+' border-top"><td colspan="10"></td></tr>';
            var newrow='<tr class="tr'+idjson+' table-secondary"><th rowspan="5">'+idjson+'</th><th colspan="8"></th><th>Eliminar</th></tr>'+
                '<tr class="tr'+idjson+'"><th>Nombre</th><td colspan="3">'+Nombre+'</td>'+
                '<th>Sexo</th><td>'+Sexo+'</td><th colspan="2">Edad al momento de los hechos</th><td>'+Edad+'</td></tr>'+
                '<tr class="tr'+idjson+'"><th>Delitos</th><td colspan="3">'+Delitos+'</td>'+
                '<th>Victimas</th><td colspan="3">'+Victimas+'</td>'+
                '<th class="text-center">'+
                '<button type="button" title="Eliminar imputado" class="btn btn-danger" onclick="delImputadoCP(\''+idjson+'\')">&times;</button>'+
                '</th></tr><tr class="tr'+idjson+'">'+
                '<th>Tipo de mandamiento judicial</th><td>'+TipoM+'</td><th>¿Con o sin detenido?</th>'+
                '<td>'+FormaTXT+'</td><th>Tipo de detención</th><td>'+DetencionTXT+'</td>'+
                '<th colspan="2">Forma en la que lleva su proceso</th><td>'+FormaProcesoTXT+'</td></tr>'+
                '<tr class="tr'+idjson+'"><th>Observaciones</th><td colspan="7">'+ObsIlegal+'</td></tr>'+
                '<tr class="tr'+idjson+' border-top"><td colspan="10"></td></tr>';            
            $("#tbImputadosCP tbody").append(newrow);
            $("#closeaddImputadoForm").click();
            $("#ddlImputado").val(-1);
            $("#ddlD").val(-1); $("#ddlD option").attr('disabled',false); $("#hdnacumuladoD").val(''); $("#txtacumuladoD").html('');
            $("#ddlV").val(-1); $("#ddlV option").attr('disabled',false); $("#hdnacumuladoV").val(''); $("#txtacumuladoV").html('');
            $("#causa_H_forma_").val(-1);$("#causa_H_detencion_legal_ilegal").val(-1);$("#causa_H_forma_proceso").val(-1);
            $("#causa_H_observaciones_ilegal").val('');
            $("#causa_H_masc").val(-1);$("#causa_H_fecha_deriva_masc").val('');
            $("#causa_H_fecha_cumpl_mas").val('');$("#causa_H_tipo_cumplimiento").val(-1);
            $("#causa_H_tipo_masc").val(-1);$("#causa_H_autoridad_deriva_masc").val(-1);
           }
           else
           {showtoast('&times; Esa relación de imputado-delito-víctima ya existe','danger');}

            // $("#causa_H_fecha_mandamiento").val('');$("#causa_H_forma_proceso").val(-1);
            // $("#causa_H_estatus_mandamiento").val(-1);$("#causa_H_fecha_libera").val('');
        //#endregion Sección 1
    }     

  }
  function delImputadoCP(idImputado,DB=0)
  {
    if (DB>0) {
      eliminarReload(idImputado,'cpdgim');
    }
    else
    {
      var json=JSON.parse("["+$("#hdnImputadosCP").val().replace(/,+$/,"")+"]");
      var filtro=json.filter(function(arr){return arr.id!=idImputado});
      $("#hdnImputadosCP").val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
      $('.tr'+idImputado).remove();
      $('#ddlImputadosMASC option[data-idimp="'+idImputado+'"]').remove();
      $('.trMASC'+idImputado).remove();
    }
  }
  function ValidarRelacion(idImputado,jsonVictimas,jsonDelitos)
  { 
    var resultado=false;
    var params = new Object(); 
    var jsonV='{"imputado":'+idImputado+',"victimas":"'+jsonVictimas+'","delitos":"' +jsonDelitos+'"}';   
    console.log(jsonV);
    params._token = '{{csrf_token()}}';
    params.json=jsonV;
    params.idCausa = $("#idCausa").val();
    params = JSON.stringify(params);
         $.ajax({      
          url: "{{Route('RelacionDuplicadas')}}",
          type: "POST",
          data: params,
          contentType: "application/json; charset=utf-8",
          dataType: 'json',
          async: false,
          success: function (result) {
            resultado=result.respuesta;            
          },
          error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert(textStatus + ": " + XMLHttpRequest.responseText);
            }
        });
    if ($("#hdnImputadosCP").val().length > 0) {
      jsonDelitos.toString().split(',').forEach(function(delito){
        jsonVictimas.toString().split(',').forEach(function(victima){
          JSON.parse("["+$("#hdnImputadosCP").val().replace(/,+$/,"")+"]").forEach(function(obj) {
            if(obj.victimas.toString().split(',').includes(victima.toString()) && 
              obj.delitos.toString().split(',').includes(delito.toString()) &&
              obj.imputado.toString().split(',').includes(idImputado.toString())){
                resultado=false;
            }
          });           
        });
      });      
    }
    return resultado;
  }

</script>