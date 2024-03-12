<div class="row causasJuicio"> 
  <div class="mb-3 input-group">    
    <label for="ddlImputados" class="input-group-text">Imputado:</label>        
    <select class="form-select" id="ddlImputados" name="ddlImputados">
      <option value="-1">Seleccione una opción</option>
      @foreach ($listados['imputadosDDL'] as $item)      
        <option value="{{$item->id}}">{{$item->Valor}}</option>      
      @endforeach
    </select>
    <button type="button" title="Agregar imputado" class="btn btn-outline-primary" onclick="javascript:addImputadoFormModal()">Agregar persona imputada</button>
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
       <form method='post' name="frmCausasPenalesJO_{{$imputado->id}}" id="frmCausasPenalesJO_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="accordion-body row">
          @csrf  
          <input type="hidden" name="idImputadoJO" id="idImputadoJO" value="{{$imputado->id}}">
          <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">          
          
            <div class="mb-4 col-12 pestanaBase">
              <div class="pestanaTop">
                <h4>Recurso</h4>
              </div>
            </div> 
            <div class="mb-3 col-12">
              @include("causas_penales.juicio_oral.recursos")
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
</div>
<div class="modal fade" id="addImputadoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
aria-labelledby="addImputadoFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-fullscreen"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addImputadoFormLabel">Recursos del imputado</h1>
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
              <!--           <input type="text" class="form-control imp0" name="causa_H_resolucion_del_recurso" 
                          id="causa_H_resolucion_del_recurso" maxlength="255"> -->
                       <select class="form-select imp0" name="causa_H_resolucion_del_recurso" id="causa_H_resolucion_del_recurso">
                          <option value="-1">Seleccione una opción</option>
                          @foreach ($Resol as $item)      
                            <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                          @endforeach              
                        </select>                           
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
        if (this.id.replace(/_([^_]+)$/, '')=="frmCausasPenalesJO") {
            if ($("#recursos"+this.id.split("_").pop()+" tbody tr").length<1)
            {
              event.preventDefault(); // Prevent the default form submission
              //respuesta=false; showtoast('Se debe agregar por lo menos un recurso','danger_rec');
              respuesta=false; showtoast('No hay ningún recurso registrado para guardar.','info_rec');
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
    
    
    function addImputadoFormModal()
    {
      if ($("#ddlImputados").val()>-1) {
       $("#frmCausasPenalesJO_0 #idImputado").val($("#ddlImputados").val());
       $("#addImputadoForm").modal("show");
      }
    }  


    function addRecurso(imputado)
    {
     if(validateAddRow("frmCausasPenalesJO_"+imputado)){
      if ($("#causa_H_tipo_de_recurso.imp"+imputado).val()>-1 
            && $("#causa_H_fecha_recurso.imp"+imputado).val().trim().length>0
            && $("#causa_H_resolucion_del_recurso.imp"+imputado).val()>-1) {

        var jsonn="";        
        var idjson=0;
        if ($("#hdnRecursos"+imputado).val().length>0) {
         var json=JSON.parse("["+$("#hdnRecursos"+imputado).val().replace(/,+$/,"")+"]");
         idjson= json.sort(function(a, b) {
                   return parseFloat(b['id']) - parseFloat(a['id']);
                })[0]['id']+1;
        }
        
        jsonn='{"id":'+idjson+',"imputado":'+imputado+',"fecha":"'+$("#causa_H_fecha_recurso.imp"+imputado).val().trim()+'",'+
        '"tipo":"' +$("#causa_H_tipo_de_recurso.imp"+imputado).val()+'",'+
        '"resolucion":"' +$("#causa_H_resolucion_del_recurso.imp"+imputado).val()+'"}';

        $("#hdnRecursos"+imputado).val($("#hdnRecursos"+imputado).val()+jsonn+",");        

        var newrow="<tr class='tr"+imputado+"_"+idjson+"'><td>"+$("#causa_H_fecha_recurso.imp"+imputado).val().trim()+"</td><td>"+
          $("#causa_H_tipo_de_recurso.imp"+imputado+" :selected").text()+"</td>"+
          "<td>"+$("#causa_H_resolucion_del_recurso.imp"+imputado+" :selected").text()+"</td>"+
          "<td><button type='button' title='Eliminar recurso' class='btn btn-danger' "+
          "onclick='eliminarRecurso(\""+imputado+"\",\""+idjson+"\")'>&times;</button></td></tr>";

        $("#recursos"+imputado+" tbody").append(newrow);
        $("#causa_H_tipo_de_recurso.imp"+imputado).val(-1);
        $("#causa_H_fecha_recurso.imp"+imputado).val('');
        $("#causa_H_resolucion_del_recurso.imp"+imputado).val(-1);

      }
     }
    }
    function eliminarRecurso(imputado,id,DB=0)
    {
      if (DB==1) {
        eliminarReload(id,'cpjore');
      }
      else
      {
        var json=JSON.parse("["+$("#hdnRecursos"+imputado).val().replace(/,+$/,"")+"]");
        var filtro=json.filter(function(arr){return arr.id!=id});
        $("#hdnRecursos"+imputado).val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));
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
