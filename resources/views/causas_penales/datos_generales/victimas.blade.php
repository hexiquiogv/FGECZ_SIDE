<div class="accordion" id="accordionFiltrosVictimas">
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsFiltrosVictimas">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsStayOpen-collapseOneVictimas" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneVictimas">
        Víctimas
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOneVictimas" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosVictimas">
      <div class="accordion-body">
        <input type="hidden" name="hdnVictimasCP" id="hdnVictimasCP">
        <div class="mb-3 input-group">
            
            <label for="ddlVictimas" class="input-group-text">Víctima:</label>        
            <select class="form-select noValidate" id="ddlVictimas" name="ddlVictimas">
                <option value="-1">Seleccione una opción</option>
                @foreach ($listados['victimas'] as $item)      
                  <option value="{{ $item->id }}" data-addrow="{{$item->addrow}}">{{$item->Valor}}</option>      
                @endforeach       
            </select>
            <button type="button" title="Agregar víctima" class="btn btn-primary" onclick="javascript:saveVicitmaCP()">
            Agregar persona víctima</button>
        </div>        

          <table class="table table-striped table-hover table-responsive caption-top" id="tbVitimasCP">
            <caption>Listado de víctimas de la causa penal</caption>    
            <thead class="table-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Primer Apellido</th>
              <th scope="col">Segundo Apellido</th>
              <th scope="col">Sexo</th>
              <th scope="col">Edad al momento de los hechos</th>
              <th scope="col">Eliminar</th>
              
            </tr>
          </thead>
          <tbody>
            
            @foreach($victimasCP as $victima)
              <tr class="trV{{$victima->id}}" ><th scope="row">{{$victima->idVictima}}</th>
              @if($victima->TIPO_VICTIMA==2)
                <td>{{strtoupper($victima->RAZON_SOCIAL)}}</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
              @elseif($victima->TIPO_VICTIMA==3)
                <td>LA SOCIEDAD</td><td>-</td><td>-</td><td>-</td><td>-</td>
              @elseif($victima->TIPO_VICTIMA==5)
                <td>SIN IDENTIFICAR/DESCONOCIDO</td><td>-</td><td>-</td><td>-</td><td>-</td>
              @elseif($victima->TIPO_VICTIMA==7)
                <td>LA SALUD</td><td>-</td><td>-</td><td>-</td><td>-</td>
              @else
                <td>{{$victima->NOMBRE_VICTIMA}}</td>
                <td>{{$victima->PRIMER_APELLIDO}}</td>
                <td>{{$victima->SEGUNDO_APELLIDO_VICTIMAS}}</td>
                <td>{{$victima->Sexo}}</td>
                <td>{{$victima->EDAD_HECHOS_VICTIMAS}}</td>
              @endif


              <td><button type="button" title="Eliminar víctima" class="btn btn-danger" onclick="javascript:delVicitmaCP({{$victima->id}},1)">&times;</button></td></tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
   $(function() {
    $("#hdnVictimasCP").val('');
  });
  
  function saveVicitmaCP()
  {
    var ddlVictimasID=$("#ddlVictimas :selected").val();
   if (ddlVictimasID > -1) {    
     $("#ddlVictimas").removeClass("border-3 border-danger");
    var idV = JSON.parse("["+$("#hdnVictimasCP").val()+"]");
    if (!(idV.includes(parseInt(ddlVictimasID)))) {
      idV.push(ddlVictimasID);
      $("#hdnVictimasCP").val(idV.toString());
      var newrow='<tr class="trV'+ddlVictimasID+'" ><th scope="row">'+ddlVictimasID+'</th>'+
      '<td>'+$("#ddlVictimas :selected").data().addrow.split("|")[0]+'</td>'+
      '<td>'+$("#ddlVictimas :selected").data().addrow.split("|")[1]+'</td>'+
      '<td>'+$("#ddlVictimas :selected").data().addrow.split("|")[2]+'</td>'+
      '<td>'+$("#ddlVictimas :selected").data().addrow.split("|")[3]+'</td>'+
      '<td>'+$("#ddlVictimas :selected").data().addrow.split("|")[4]+'</td>'+
      '<td><button type="button" title="Eliminar víctima" class="btn btn-danger"'+
      ' onclick="javascript:delVicitmaCP(\''+ddlVictimasID+'\')">&times;</button></td></tr>';
      $("#ddlVictimas :selected").attr('disabled',true);
      $("#ddlV").append('<option value="' + ddlVictimasID+ '">' + $('#ddlVictimas :selected').text() + '</option>');
      $("#tbVitimasCP tbody").append(newrow);
      $("#ddlVictimas").val(-1);
    }
   }
   else
   {
    $("#ddlVictimas").addClass("border-3 border-danger");
   }
  }

  function delVicitmaCP(idVictima,DB=0)
  {
    if (DB>0) {
      eliminarReload(idVictima,'cpdgvc');
    }
    else
    {
      var idV = JSON.parse("["+$("#hdnVictimasCP").val()+"]");    
      if (idV.includes(parseInt(idVictima))) {              
          var result=idV.filter(function(ele){  return ele != idVictima; });
          $("#hdnVictimasCP").val(result.toString());
          $("#ddlVictimas option[value="+idVictima+"]").attr('disabled',false);
          $("#ddlV option[value="+idVictima+"]").remove();        
          $('.trV'+idVictima).remove();
        var json=JSON.parse("["+$("#hdnImputadosCP").val().replace(/,+$/,"")+"]");
        var filtro=json.filter(function(arr){return arr.victimas.indexOf(idVictima)>-1});
        $.each(filtro,function(key,value){
            delImputadoCP(value.id);
        });
      }      
    }  
  }
</script>