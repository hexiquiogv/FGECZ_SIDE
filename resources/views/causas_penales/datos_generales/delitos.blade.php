<div class="accordion" id="accordionFiltrosDelitos">
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsFiltrosDelitos">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsStayOpen-collapseOneDelitos" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneDelitos">
        Delitos
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOneDelitos" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosDelitos">
      <div class="accordion-body">
        <div class="text-end">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDelitoForm">
            Agregar delito a causa penal
          </button>
        </div>
        <input type="hidden" name="hdnDelitosCP" id="hdnDelitosCP">
        <table class="table table-striped table-hover table-responsive caption-top" id="tbDelitosCP">
            <caption>Listado de delitos de la causa penal</caption>    
            <thead class="table-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Delito</th>
              <th scope="col">¿Se reclasificó el delito?</th>
              <th scope="col">Momento reclasificación</th>
              <th scope="col">Fecha de reclasificación</th>
              <th scope="col">Delito por el que se reclasifica</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>
            @foreach($delitosCP as $delito)
              <tr class='trD{{$delito->id}}'>                
                <th scope='row'>{{$delito->idDelito}}</th>
                <td>{{$delito->Valor}}</td>
                <td>{{$delito->RECLASIFICACION}}</td>
                <td>{{$delito->MOMENTO}}</td>
                <td>{{$delito->FECHA_RECLAS}}</td>
                <td>{{$delito->DELITO_DE_ACUERDO_CON_LEY}}</td>
                <td>
                  <button type='button' title='Eliminar delito' class='btn btn-danger' onclick='javascript:delDelitoCP("{{$delito->id}}",1)'>&times;</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="addDelitoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDelitoFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addDelitoFormLabel">Agregar delito a causa penal</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="mb-3 col-sm-12 col-md-12">
            <label for="ddlDelitos" class="form-label">Delito registrado:</label>
            <select class="form-select" name="ddlDelitos" id="ddlDelitos">
              <option value="-1">Seleccione una opción</option>
              @foreach ($listados['delitos'] as $item)      
                <option value="{{ $item->id }}">{{$item->Valor}}</option>      
              @endforeach                 
           </select>
          </div>
          <div class="mb-3 col-sm-12 col-md-4">
            <label for="causa_H_reclasificacion" class="form-label">¿Se reclasificó el delito?</label>
            <select class="form-select" name="causa_H_reclasificacion" id="causa_H_reclasificacion">
              <option  value="-1">Seleccione una opción</option>
              @foreach ($SiNo as $item)      
                <option value="{{ $item->id }}">{{$item->Valor}}</option>      
              @endforeach                 
           </select>
          </div>
          <div class="mb-3 col-sm-12 col-md-8">
            <label for="causa_H_delito_de_acuerdo_con_ley" class="form-label">Delito por el que se reclasifica:</label>
            <input type="text" class="form-control nonum" name="causa_H_delito_de_acuerdo_con_ley" id="causa_H_delito_de_acuerdo_con_ley" placeholder="">
          </div>
          <div class="mb-3 col-sm-12 col-md-6">
            <label for="causa_H_momento_reclas" class="form-label">Momento reclasificación:</label>
            <select class="form-select" name="causa_H_momento_reclas" id="causa_H_momento_reclas">
              <option value="-1">Seleccione una opción</option>
              @foreach ($momentoReclas as $item)      
                <option value="{{ $item->id }}">{{$item->Valor}}</option>      
              @endforeach         
           </select>
          </div>
          <div class="mb-3 col-sm-12 col-md-6">
            <label for="causa_H_fecha_reclas" class="form-label">Fecha de reclasificación:</label>
            <input type="date" class="form-control" name="causa_H_fecha_reclas" id="causa_H_fecha_reclas" value="">
          </div>            
        </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="closeaddDelitoForm" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:saveDelitoCP()">Agregar</button>
      </div>
      <p class=" p-2 text-end">* Para guarda los datos de esta sección se debe dar clic en el botón de "Guardar", abajo de Observaciones.</p>
    </div>
  </div>
</div>   
<script type="text/javascript">
  $(function() {
    $("#hdnDelitosCP").val('');    
  });
  function saveDelitoCP()
  {
    var respuesta=true;
    if ($("#ddlDelitos").val() > -1) {$("#ddlDelitos").removeClass("border-3 border-danger");}
    else{respuesta=false; $("#ddlDelitos").addClass("border-3 border-danger");}
    if ($("#causa_H_reclasificacion").val() > -1) {
      $("#causa_H_reclasificacion").removeClass("border-3 border-danger");
      if (($("#causa_H_reclasificacion").val()==0 && $("#causa_H_delito_de_acuerdo_con_ley").val()=='') ||
          ($("#causa_H_reclasificacion").val()==1 && $("#causa_H_delito_de_acuerdo_con_ley").val()!='')) {
        $("#causa_H_delito_de_acuerdo_con_ley").removeClass("border-3 border-danger");}
      else{respuesta=false; $("#causa_H_delito_de_acuerdo_con_ley").addClass("border-3 border-danger");}

      if (($("#causa_H_reclasificacion").val()==0 && $("#causa_H_momento_reclas").val()<0) ||
          ($("#causa_H_reclasificacion").val()==1 && $("#causa_H_momento_reclas").val()>-1)) {
        $("#causa_H_momento_reclas").removeClass("border-3 border-danger");}
      else{respuesta=false; $("#causa_H_momento_reclas").addClass("border-3 border-danger");}

      if (($("#causa_H_reclasificacion").val()==0 && $("#causa_H_fecha_reclas").val()=='') ||
          ($("#causa_H_reclasificacion").val()==1 && $("#causa_H_fecha_reclas").val()!='')) {
        $("#causa_H_fecha_reclas").removeClass("border-3 border-danger");}
      else{respuesta=false; $("#causa_H_fecha_reclas").addClass("border-3 border-danger");}      
    }
    else{respuesta=false; $("#causa_H_reclasificacion").addClass("border-3 border-danger");}
    

    // if ($("#ddlDelitos").val() > -1 && $("#causa_H_reclasificacion").val() > -1 &&
    //      (($("#causa_H_reclasificacion").val()==0 && $("#causa_H_delito_de_acuerdo_con_ley").val()=='') ||
    //       ($("#causa_H_reclasificacion").val()==1 && $("#causa_H_delito_de_acuerdo_con_ley").val()!=''))) {
    if (respuesta) {
     var ddlDelitosID=$("#ddlDelitos").val();
     if ($("#hdnDelitosCP").val().indexOf(ddlDelitosID+",")<0) {    
     var jsonn="";
     jsonn='{"idDelito":'+ddlDelitosID+',"reclas":'+$("#causa_H_reclasificacion").val()+
           ',"momento":'+$("#causa_H_momento_reclas").val()+
           ',"fecha":"'+$("#causa_H_fecha_reclas").val()+'"'+
           ',"delitoReclas":"'+$("#causa_H_delito_de_acuerdo_con_ley").val()+'"}';

       $("#ddlDelitos :selected").attr('disabled',true);
       $("#hdnDelitosCP").val($("#hdnDelitosCP").val()+jsonn+",");

     var newrow="<tr class='trD"+ddlDelitosID+"'><th scope='row'>"+ddlDelitosID+"</th><td>"+
         $('#ddlDelitos :selected').text()+"</td><td>"+
         $("#causa_H_reclasificacion :selected").text()+"</td><td>"+
         ($("#causa_H_momento_reclas").val()<0 ? "" : $("#causa_H_momento_reclas :selected").text())+"</td><td>"+
         $("#causa_H_fecha_reclas").val()+"</td><td>"+
         $("#causa_H_delito_de_acuerdo_con_ley").val()+"</td><td>"+
         "<button type='button' title='Eliminar delito' class='btn btn-danger' onclick='javascript:delDelitoCP(\""+ddlDelitosID+"\")'>&times;</button></td></tr>";
       $("#tbDelitosCP tbody").append(newrow);

       $("#ddlD").append('<option value="' + ddlDelitosID+ '">' + $('#ddlDelitos :selected').text() + '</option>');

       $("#closeaddDelitoForm").click();
       $("#ddlDelitos").val(-1);
       $("#causa_H_reclasificacion").val(-1);
       $("#causa_H_momento_reclas").val(-1);
       $("#causa_H_fecha_reclas").val('');
       $("#causa_H_delito_de_acuerdo_con_ley").val('');
      }
    }
    else
    {
      showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
    }
  }
  function delDelitoCP(idDelito,DB=0)
  {  
    if (DB>0) {
      eliminarReload(idDelito,'cpdgdl');      
    }
    else
    {
      var json=JSON.parse("["+$("#hdnDelitosCP").val().replace(/,+$/,"")+"]");
      var filtro=json.filter(function(arr){return arr.idDelito!=idDelito});
      $("#hdnDelitosCP").val(JSON.stringify(filtro).replace("[","").replace("]",",").replace(/^,+/,""));       
      $("#ddlDelitos option[value="+idDelito+"]").attr('disabled',false);
      $("#ddlD option[value="+idDelito+"]").remove();    
      $('.trD'+idDelito).remove();
      var json=JSON.parse("["+$("#hdnImputadosCP").val().replace(/,+$/,"")+"]");
      var filtro=json.filter(function(arr){return arr.delitos.indexOf(idDelito)>-1});
      $.each(filtro,function(key,value){
          delImputadoCP(value.id);
      });
    }
  }
</script>