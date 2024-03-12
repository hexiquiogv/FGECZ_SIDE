
          <div class="mb-4 col-12 pestanaBase">
            <div class="pestanaTop">
              <h4>Datos MASC de Poder Judicial</h4>
            </div>
          </div>
        <div id="divImputadoMASC">
          <div class="input-group">            
            <label for="ddlImputadosMASC" class="input-group-text">Imputado:</label>        
            <select class="form-select noValidate" id="ddlImputadosMASC" name="ddlImputadosMASC">
                <option value="-1">Seleccione una opción</option>                
                @foreach ($imputadosMASC as $item)
                @if(!isset($item->MASC))
                  <option value="{{ $item->id }}" data-addrow="{{$item->addrow}}">{{$item->Nombre}}</option>
                @endif
                @endforeach       
            </select>            
          <!-- </div>        
          <div class="input-group"> -->
            <label for="causa_H_masc" class="input-group-text">¿El asunto se derivó a MASC de Poder Judicial?</label>
            <select class="form-select noValidate" name="causa_H_masc" id="causa_H_masc">
              <option value="-1">Seleccione una opción</option>
              @foreach ($SiNoNoI as $item)      
                <option value="{{ $item->id }}">{{$item->Valor}}</option>
              @endforeach   
           </select>
          </div>  
          <div class="input-group masc">
            <label for="causa_H_fecha_deriva_masc" class="input-group-text">Fecha en que se deriva a MASC:</label>
            <input type="date" class="form-control noValidate" name="causa_H_fecha_deriva_masc" id="causa_H_fecha_deriva_masc" value="">
          <!--</div>
          <div class="input-group"> -->
            <label for="causa_H_fecha_cumpl_mas" class="input-group-text">Fecha en que se cumplimentó el MASC:</label>
            <input type="date" class="form-control noValidate" name="causa_H_fecha_cumpl_mas" id="causa_H_fecha_cumpl_mas" 
            value="">
          </div> 
          <div class="input-group masc">
            <label for="causa_H_tipo_cumplimiento" class="input-group-text">Tipo de cumplimiento:</label>
            <select class="form-select noValidate" name="causa_H_tipo_cumplimiento" id="causa_H_tipo_cumplimiento">
              <option value="-1">Seleccione una opción</option>
              @foreach ($tipoCump as $item)      
                <option value="{{ $item->id }}">{{$item->Valor}}</option>      
              @endforeach   
            </select>
          <!--</div>  
          <div class="input-group"> -->
              <label for="causa_H_tipo_masc" class="input-group-text">Tipo de MASC:</label>
              <select class="form-select noValidate" name="causa_H_tipo_masc" id="causa_H_tipo_masc">
                <option value="-1">Seleccione una opción</option>
                @foreach ($tipoMASC as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach  
             </select>
          </div>  
          <div class="input-group">
            <label for="causa_H_autoridad_deriva_masc" class="input-group-text masc">Autoridad que deriva a MASC :</label>
            <select class="form-select noValidate masc" name="causa_H_autoridad_deriva_masc" id="causa_H_autoridad_deriva_masc">
              <option value="-1">Seleccione una opción</option>
                @foreach ($autMASC as $item)      
                  <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                @endforeach  
           </select>
          </div>
            <button type="button" title="Registrar" class="btn btn-primary float-end" onclick="javascript:saveImputadoMASC()">
            Agregar</button>          
        </div>     
        <table class="table table-sm align-middle table-responsive-sm caption-top" id="tbImputadosMASC">
            <caption>Listado MASC</caption>    
          <thead class="table-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">¿El asunto se derivó a MASC?</th>
              <th scope="col">Fecha en que se deriva a MASC</th>
              <th scope="col">Fecha en que se cumplimentó el MASC</th>
              <th scope="col">Tipo de cumplimiento</th>
              <th scope="col">Tipo de MASC</th>
              <th scope="col">Autoridad que deriva a MASC</th>
              <th scope="col">Acción</th>
            </tr>
          </thead>
          <tbody>
            @foreach($imputadosMASC as $imputado)
            @if(isset($imputado->MASC))
              <tr class="trMASC{{$imputado->id}}">
                <th scope="row">{{$imputado->id}}</th>
                <td>{{$imputado->Nombre}}</td>
                <td>{{$imputado->MASC1}}</td>
                <td>{{$imputado->FECHA_DERIVA_MASC}}</td>
                <td>{{$imputado->FECHA_CUMPL_MAS}}</td>
                <td>{{$imputado->MASC4}}</td>
                <td>{{$imputado->MASC5}}</td>
                <td>{{$imputado->MASC6}}</td>
                <td><a class="btn btn-outline-primary btn-sm" onclick="javascript:editarMASC('{{$imputado->id}}')"
                 role="button">Editar</a></td>
              </tr>
               <tr class="editarMASC{{$imputado->id}}" style="display:none;">              
                <th scope="row">{{$imputado->id}}</th>
                <td>{{$imputado->Nombre}}</td>
                <td>
                  <select class="form-select noValidate" name="causa_H_masc_edit" id="causa_H_masc_edit">
                    <option value="-1">Seleccione una opción</option>
                    @foreach ($SiNoNoI as $item)      
                      <option value="{{ $item->id }}">{{$item->Valor}}</option>
                    @endforeach   
                  </select>
                </td>
                <td><input type="date" class="form-control noValidate" name="causa_H_fecha_deriva_masc_edit" id="causa_H_fecha_deriva_masc_edit"></td>
                <td><input type="date" class="form-control noValidate" name="causa_H_fecha_cumpl_mas_edit" id="causa_H_fecha_cumpl_mas_edit"></td>
                <td>
                  <select class="form-select noValidate" name="causa_H_tipo_cumplimiento_edit" id="causa_H_tipo_cumplimiento_edit">
                    <option value="-1">Seleccione una opción</option>
                    @foreach ($tipoCump as $item)      
                      <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                    @endforeach   
                  </select>
                </td>
                <td>
                  <select class="form-select noValidate" name="causa_H_tipo_masc_edit" id="causa_H_tipo_masc_edit">
                    <option value="-1">Seleccione una opción</option>
                    @foreach ($tipoMASC as $item)      
                      <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                    @endforeach  
                 </select>
                </td>
                <td>
                  <select class="form-select noValidate" name="causa_H_autoridad_deriva_masc_edit" id="causa_H_autoridad_deriva_masc_edit">
                    <option value="-1">Seleccione una opción</option>
                      @foreach ($autMASC as $item)      
                        <option value="{{ $item->id }}">{{$item->Valor}}</option>      
                      @endforeach  
                  </select>
                </td>
                <td><a class="btn btn-outline-success btn-sm" onclick="javascript:GuardarMASC('{{$imputado->id}}')"
                 role="button">Guardar</a></td>
               </tr>
            @endif
            @endforeach
          </tbody>
        </table>      
<script type="text/javascript">
  function editarMASC(idImputado)
  { $(".trMASC"+idImputado).hide();
    $(".editarMASC"+idImputado).show();
  }
  function GuardarMASC(idImputado)
  {
    var respuesta=true;
    if ($(".editarMASC"+idImputado+" #causa_H_masc_edit").val()<0){
      respuesta=false;$(".editarMASC"+idImputado+" #causa_H_masc_edit").addClass("border-3 border-danger");
    }
    else{
      $(".editarMASC"+idImputado+" input:visible").removeClass("border-3 border-danger");
      $(".editarMASC"+idImputado+" select:visible").removeClass("border-3 border-danger");
      if ($(".editarMASC"+idImputado+"  #causa_H_masc_edit").val()==1) {
        $(".editarMASC"+idImputado+" input:visible").each(function(){
          if (this.value.length<1){respuesta=false;$(this).addClass("border-3 border-danger");}
          else{$(this).removeClass("border-3 border-danger");}
        });      
        
        $(".editarMASC"+idImputado+" select:visible").each(function(){
          if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");}
          else{$(this).removeClass("border-3 border-danger");}        
        });
        }
      }
      if (respuesta) {
        var resultado=false;
        var params = new Object(); 
        params._token = '{{csrf_token()}}';
        params.idImputado = idImputado;
        params.MASC1 = $(".editarMASC"+idImputado+" #causa_H_masc_edit").val();
        params.MASC2 = $(".editarMASC"+idImputado+" #causa_H_fecha_deriva_masc_edit").val();
        params.MASC3 = $(".editarMASC"+idImputado+" #causa_H_fecha_cumpl_mas_edit").val();
        params.MASC4 = $(".editarMASC"+idImputado+" #causa_H_tipo_cumplimiento_edit").val();
        params.MASC5 = $(".editarMASC"+idImputado+" #causa_H_tipo_masc_edit").val();
        params.MASC6 = $(".editarMASC"+idImputado+" #causa_H_autoridad_deriva_masc_edit").val();
        params.idExp = $("#idExp").val();
        params.idCausa = $("#idCausa").val();
        params = JSON.stringify(params);
         $.ajax({      
          url: "{{Route('editarMASC_CP')}}",
          type: "POST",
          data: params,
          contentType: "application/json; charset=utf-8",
          dataType: 'json',
          async: false,
          success: function (result) {
            if (result.respuesta) {
            window.location.href = result.redirect; // Redirigir a la URL indicada
            }
            resultado=result.respuesta;            
          },
          error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert(textStatus + ": " + XMLHttpRequest.responseText);
            }
        });
      }
  }
  function eliminarMASC(idImputado)
  {
    // JSON original
    var arrayJSON=JSON.parse("["+$("#hdnImputadosCP").val().replace(/,+$/,"")+"]");

    // Iterar sobre los objetos en el array
    for (var i = 0; i < arrayJSON.length; i++) {
        if (arrayJSON[i].id == idImputado) {
            arrayJSON[i].masc1 = "MASC1__"+idImputado+"__";
            arrayJSON[i].masc2 = "MASC2__"+idImputado+"__";
            arrayJSON[i].masc3 = "MASC3__"+idImputado+"__";
            arrayJSON[i].masc4 = "MASC4__"+idImputado+"__";
            arrayJSON[i].masc5 = "MASC5__"+idImputado+"__";
            arrayJSON[i].masc6 = "MASC6__"+idImputado+"__";
            break; // Terminar la iteración después de encontrar el objeto con id=1
        }
    }
// '[{"id":0,"imputado":92,"victimas":"16","delitos":"10","forma":"2","detencion":"-1","formaproceso":"-1","observaciones":"","masc1":"MASC1__0__","masc2":"MASC2__0__","masc3":"MASC3__0__","masc4":"MASC4__0__","masc5":"MASC5__0__","masc6":"MASC6__0__"}]' 

    // Convertir de nuevo a JSON
    var nuevoJSON = JSON.stringify(arrayJSON).replace("[","").replace("]",",").replace(/^,+/,"");
    $("#hdnImputadosCP").val(nuevoJSON);
    $('#ddlImputadosMASC option[data-idimp="'+idImputado+'"]').attr('disabled',false);
    $(".trMASC"+idImputado).remove();
  }
  function validSaveImputadoMASC()

  {
    var respuesta=true;
      $("#divImputadoMASC input:visible").each(function(){
        if (this.value.length<1){respuesta=false;$(this).addClass("border-3 border-danger");}
        else{$(this).removeClass("border-3 border-danger");}
      });      
      
      $("#divImputadoMASC select:visible").each(function(){
        if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");}
        else{$(this).removeClass("border-3 border-danger");}        
      });   
    return respuesta;
  }
   function saveImputadoMASC()
  {
    
    if (!validSaveImputadoMASC()) {
      showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');
    }
    else
    {
        //#region Sección 1
          var id=$("#ddlImputadosMASC :selected").val();var Nombre=$("#ddlImputadosMASC :selected").text(); 
          var MASC1=$("#causa_H_masc :selected").val();
          var MASC1TXT=MASC1<0?'':$("#causa_H_masc :selected").text();
          var MASC2=$("#causa_H_fecha_deriva_masc").val();
          var MASC3=$("#causa_H_fecha_cumpl_mas").val();
          var MASC4=$("#causa_H_tipo_cumplimiento :selected").val();
          var MASC4TXT=MASC4<0?'':$("#causa_H_tipo_cumplimiento :selected").text();
          var MASC5=$("#causa_H_tipo_masc :selected").val();
          var MASC5TXT=MASC5<0?'':$("#causa_H_tipo_masc :selected").text();
          var MASC6=$("#causa_H_autoridad_deriva_masc :selected").val();
          var MASC6TXT=MASC6<0?'':$("#causa_H_autoridad_deriva_masc :selected").text();

            var newJSON=$("#hdnImputadosCP").val();

            newJSON=newJSON.replace(new RegExp('MASC1__'+id+'__', 'g'),MASC1+'__'+id+'__')
            .replace(new RegExp('MASC2__'+id+'__', 'g'),MASC2+'__'+id+'__')
            .replace(new RegExp('MASC3__'+id+'__', 'g'),MASC3+'__'+id+'__')
            .replace(new RegExp('MASC4__'+id+'__', 'g'),MASC4+'__'+id+'__')
            .replace(new RegExp('MASC5__'+id+'__', 'g'),MASC5+'__'+id+'__')
            .replace(new RegExp('MASC6__'+id+'__', 'g'),MASC6+'__'+id+'__');
            $("#hdnImputadosCP").val(newJSON);
            var newrow='<tr class="trMASC'+id+'" ><th scope="row">'+id+'</th>'+
      '<td>'+Nombre+'</td>'+
      '<td>'+MASC1TXT+'</td>'+
      '<td>'+MASC2+'</td>'+
      '<td>'+MASC3+'</td>'+
      '<td>'+MASC4TXT+'</td>'+
      '<td>'+MASC5TXT+'</td>'+
      '<td>'+MASC6TXT+'</td>'+
      '<td><a class="btn btn-outline-danger btn-sm" onclick="javascript:eliminarMASC(\''+id+'\')" role="button">Eliminar</a>'+
      '</tr>';
      $("#ddlImputadosMASC :selected").attr('disabled',true);
            $("#tbImputadosMASC tbody").append(newrow);
            $("#ddlImputadosMASC").val(-1);
            $("#causa_H_masc").val(-1).change();$("#causa_H_fecha_deriva_masc").val('');
            $("#causa_H_fecha_cumpl_mas").val('');$("#causa_H_tipo_cumplimiento").val(-1);
            $("#causa_H_tipo_masc").val(-1);$("#causa_H_autoridad_deriva_masc").val(-1);
        //#endregion Sección 1
    }     

  }

</script>