<div class="row causasProcedimiento">
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
   <div class="accordion mb-2" id="accordionFiltrosProcedimiento_{{$imputado->id}}">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsFiltrosProcedimiento_{{$imputado->id}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
        data-bs-target="#panelsStayOpen-collapseOneProcedimiento_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneProcedimiento_{{$imputado->id}}">
        Persona imputada {{$imputado->id}}: {{$imputado->encabezado}}
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOneProcedimiento_{{$imputado->id}}" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosProcedimiento_{{$imputado->id}}">
       <form method='post' name="frmCausasPenalesPA_{{$imputado->id}}" id="frmCausasPenalesPA_{{$imputado->id}}" action="{{ route('saveCP') }}" enctype="multipart/form-data">
        <div class="accordion-body row">
          @csrf  
          <input type="hidden" name="idImputadoPA" id="idImputadoPA" value="{{$imputado->id}}">
          <input type="hidden" name="idImputado" id="idImputado" value="{{$imputado->idImputado}}">
          <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">          
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_no_admision_del_abreviado" class="form-label">¿Se admitió el abreviado?</label>
            <select class="form-select" name="causa_H_no_admision_del_abreviado" id="causa_H_no_admision_del_abreviado">
              <option value="-1">Seleccione una opción</option>
              @foreach ($SiNo as $item)      
               <option value="{{$item->id}}"
               {{isset($imputado->NO_ADMISION_DEL_ABREVIADO) ? $imputado->NO_ADMISION_DEL_ABREVIADO==$item->id ?'selected':'':''}}>
               {{$item->Valor}}</option>      
              @endforeach                  
           </select>                
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 siabreviado" style="display:none;">
            <label for="causa_H_procedimiento_abreviado" class="form-label">Fecha en que se dictó el procedimiento abreviado:</label>
            <input type="date" class="form-control" name="causa_H_procedimiento_abreviado" id="causa_H_procedimiento_abreviado" 
            value="{{$imputado->PROCEDIMIENTO_ABREVIADO}}">
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 siabreviado" style="display:none;">
            <label for="causa_H_pena_condenatoria_en_abreviado" class="form-label">Pena condenatoria en abreviado:</label>
            <input type="text" class="form-control temporalidad" name="causa_H_pena_condenatoria_en_abreviado" id="causa_H_pena_condenatoria_en_abreviado" 
            value="{{$imputado->PENA_CONDENATORIA_EN_ABREVIADO}}" placeholder="xx años">
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 siabreviado d-none" style="display:none;">
            <label for="causa_H_estatus_abreviado" class="form-label">Estatus:</label>
            <select class="form-select" name="causa_H_estatus_abreviado" id="causa_H_estatus_abreviado">
              <option value="-1">Seleccione una opción</option>
              @foreach ($EstatusAb as $item)      
                <option value="{{$item->id}}"
           {{isset($imputado->ESTATUS_ABREVIADO) ? $imputado->ESTATUS_ABREVIADO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
              @endforeach                  
           </select>                
          </div>
          <div class="mb-3 col-sm-12 col-md-12 col-lg-12 siabreviado" style="display:none;">
            <label for="causa_H_narracion_procedimiento" class="form-label">Narración del procedimiento:</label>
            <input type="text" class="form-control alfanum" name="causa_H_narracion_procedimiento"
              id="causa_H_narracion_procedimiento" value="{{$imputado->NARRACION_PROCEDIMIENTO}}">
          </div>                     
          {{--
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="causa_H_abreviado" class="form-label">Sentencia derivada de un procedimiento abreviado:</label>
              <select class="form-select" name="causa_H_abreviado" id="causa_H_abreviado">
                <option value="-1">Seleccione una opción</option>
                @foreach ($SiNoNoI as $item)      
                  <option value="{{$item->id}}"
                    {{isset($imputado->ABREVIADO) ? $imputado->ABREVIADO==$item->id ?'selected':'':''}}>
                    {{$item->Valor}}</option>      
                @endforeach                    
             </select>
            </div>                
          --}}
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 noabreviado"  style="display:none;">
            <label for="causa_H_causas_abreviado" class="form-label">Causa de la no admisión:</label>
            <input type="text" class="form-control" name="causa_H_causas_abreviado" id="causa_H_causas_abreviado" 
            value="{{$imputado->CAUSAS_ABREVIADO}}">
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
      $("#frmCausasPenalesPA_{{$imputado->id}} #causa_H_no_admision_del_abreviado").change(function() {     
        if (this.value==1) {
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado").show();
          $("#frmCausasPenalesPA_{{$imputado->id}} .noabreviado").hide();//hide
          $("#frmCausasPenalesPA_{{$imputado->id}} .noabreviado #causa_H_causas_abreviado").val('');
        }
        else if (this.value==0) {
          $("#frmCausasPenalesPA_{{$imputado->id}} .noabreviado").show();
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado").hide();//hide
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_procedimiento_abreviado").val('');
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_pena_condenatoria_en_abreviado").val('');
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_estatus_abreviado").val('-1');
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_narracion_procedimiento").val('');
             
        }
        else
        {
          $("#frmCausasPenalesPA_{{$imputado->id}} .noabreviado").hide();//hide
          $("#frmCausasPenalesPA_{{$imputado->id}} .noabreviado #causa_H_causas_abreviado").val('');
            $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado").hide();//hide
            $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_procedimiento_abreviado").val('');
            $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_pena_condenatoria_en_abreviado").val('');
            $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_estatus_abreviado").val('-1');
            $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_narracion_procedimiento").val('');
        }
      });
      
        if ($("#frmCausasPenalesPA_{{$imputado->id}} #causa_H_no_admision_del_abreviado").val()==1) {
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado").show();
          $("#frmCausasPenalesPA_{{$imputado->id}} .noabreviado").hide();//hide
          $("#frmCausasPenalesPA_{{$imputado->id}} .noabreviado #causa_H_causas_abreviado").val('');
        }
        else if ($("#frmCausasPenalesPA_{{$imputado->id}} #causa_H_no_admision_del_abreviado").val()==0) {
          $("#frmCausasPenalesPA_{{$imputado->id}} .noabreviado").show();
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado").hide();//hide
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_procedimiento_abreviado").val('');
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_pena_condenatoria_en_abreviado").val('');
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_estatus_abreviado").val('-1');
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_narracion_procedimiento").val('');
        }
        else
        {
          $("#frmCausasPenalesPA_{{$imputado->id}} .noabreviado").hide();//hide
          $("#frmCausasPenalesPA_{{$imputado->id}} .noabreviado #causa_H_causas_abreviado").val('');
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado").hide();//hide
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_procedimiento_abreviado").val('');
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_pena_condenatoria_en_abreviado").val('');       
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_estatus_abreviado").val('-1');
          $("#frmCausasPenalesPA_{{$imputado->id}} .siabreviado #causa_H_narracion_procedimiento").val('');
        }      
    </script>
  @endforeach
</div>
<div class="modal fade" id="addImputadoForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addImputadoFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addImputadoFormLabel">Datos de procedimiento abreviado del imputado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method='post' name="frmCausasPenalesPA_0" id="frmCausasPenalesPA_0" action="{{ route('saveCP') }}" enctype="multipart/form-data">           
          <div class="row">
              @csrf  
            <input type="hidden" name="idImputadoPA" id="idImputadoPA" value="0">
            <input type="hidden" name="idImputado" id="idImputado" value="">
            <input type="hidden" name="idCausa" id="idCausa" value="{{$idRegistro}}">
            <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
            <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
              <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                <label for="causa_H_no_admision_del_abreviado" class="form-label">¿Se admitió el abreviado?</label>
                <select class="form-select" name="causa_H_no_admision_del_abreviado" id="causa_H_no_admision_del_abreviado">
                  <option value="-1">Seleccione una opción</option>
                  @foreach ($SiNo as $item)      
                    <option value="{{$item->id}}">{{$item->Valor}}</option>      
                  @endforeach                  
               </select>                
              </div>
              <div class="mb-3 col-sm-12 col-md-6 col-lg-4 siabreviado" style="display:none;">
                <label for="causa_H_procedimiento_abreviado" class="form-label">Fecha en que se dictó el procedimiento abreviado:</label>
                <input type="date" class="form-control" name="causa_H_procedimiento_abreviado" id="causa_H_procedimiento_abreviado" value="">
              </div>
              <div class="mb-3 col-sm-12 col-md-6 col-lg-4 siabreviado" style="display:none;">
                <label for="causa_H_pena_condenatoria_en_abreviado" class="form-label">Pena condenatoria en abreviado:</label>
                <input type="text" class="form-control temporalidad" name="causa_H_pena_condenatoria_en_abreviado" id="causa_H_pena_condenatoria_en_abreviado" 
                placeholder="xx años">
              </div>
              <div class="mb-3 col-sm-12 col-md-6 col-lg-4 siabreviado d-none" style="display:none;">
                <label for="causa_H_estatus_abreviado" class="form-label">Estatus:</label>
                <select class="form-select" name="causa_H_estatus_abreviado" id="causa_H_estatus_abreviado">
                  <option value="-1">Seleccione una opción</option>
                  @foreach ($EstatusAb as $item)      
                    <option value="{{$item->id}}">{{$item->Valor}}</option>      
                  @endforeach                  
               </select>                
              </div> 
              <div class="mb-3 col-sm-12 col-md-12 col-lg-12 siabreviado" style="display:none;">
                <label for="causa_H_narracion_procedimiento" class="form-label">Narración del procedimiento:</label>
                <input type="text" class="form-control alfanum" name="causa_H_narracion_procedimiento"
                  id="causa_H_narracion_procedimiento">
              </div>                           
              {{--
                <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
                  <label for="causa_H_abreviado" class="form-label">Sentencia derivada de un procedimiento abreviado:</label>
                  <select class="form-select" name="causa_H_abreviado" id="causa_H_abreviado">
                    <option>Seleccione una opción</option>
                    @foreach ($SiNoNoI as $item)      
                      <option value="{{$item->id}}">{{$item->Valor}}</option>      
                    @endforeach                  
                 </select>
                </div>                
              --}}
              <div class="mb-3 col-sm-12 col-md-6 col-lg-4 noabreviado"  style="display:none;">
                <label for="causa_H_causas_abreviado" class="form-label">Causa de la no admisión:</label>
                <input type="text" class="form-control" name="causa_H_causas_abreviado" id="causa_H_causas_abreviado">
              </div>
          </div>        
        </form>   
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="closeaddImputadoForm" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:$('#frmCausasPenalesPA_0').submit()">Guardar</button>
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

// function validateAddRow(formularioID)
// {
//   var respuesta=true;
//   var campos=[];
//   $("#"+formularioID+" input:not(.noValidate):visible").each(function(){
//     if (this.value.trim().length<1){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
//     else{$(this).removeClass("border-3 border-danger");}
//   });      

//   $("#"+formularioID+" select:not(.noValidate):visible").each(function(){
//     if (this.value<0){respuesta=false;$(this).addClass("border-3 border-danger");campos.push(this.id );}
//     else{$(this).removeClass("border-3 border-danger");}
//   });

//   if (!respuesta) {showtoast('<h6>&times; Validación</h6><hr>Algunos campos no tienen valores válidos','danger');}
//     return respuesta;
// }

  
  $(".temporalidadDMA").mask('YYYY',
    {translation:  {'Y': {pattern: /[0-9añosdíimeAÑOSDÍIME\,\s]/, recursive: true}}});    
    $(".temporalidad").mask('YYYY',
    {translation:  {'Y': {pattern: /[0-9añosAÑOS\,\s]/, recursive: true}}});    
  $(".nonum").mask('ZZZZ',
    {translation:  {'Z': {pattern: /[a-zA-Z\s]/, recursive: true}}});    
  $(".noletra").mask('NNNN',
    {translation:  {'N': {pattern: /[0-9]/, recursive: true}}});    
  
  $("#frmCausasPenalesPA_0 #causa_H_no_admision_del_abreviado").change(function() {     
    if (this.value==1) {
      $("#frmCausasPenalesPA_0 .siabreviado").show();
      $("#frmCausasPenalesPA_0 .noabreviado").hide();//hide
      $("#frmCausasPenalesPA_0 .noabreviado #causa_H_causas_abreviado").val('');
    }
    else if (this.value==0) {
      $("#frmCausasPenalesPA_0 .noabreviado").show();
      $("#frmCausasPenalesPA_0 .siabreviado").hide();//hide
      $("#frmCausasPenalesPA_0 .siabreviado #causa_H_procedimiento_abreviado").val('');
      $("#frmCausasPenalesPA_0 .siabreviado #causa_H_pena_condenatoria_en_abreviado").val('');      
      $("#frmCausasPenalesPA_0 .siabreviado #causa_H_estatus_abreviado").val('-1');
    }
    else
    {
      $("#frmCausasPenalesPA_0 .noabreviado").hide();//hide
      $("#frmCausasPenalesPA_0 .noabreviado #causa_H_causas_abreviado").val('');
        $("#frmCausasPenalesPA_0 .siabreviado").hide();//hide
        $("#frmCausasPenalesPA_0 .siabreviado #causa_H_procedimiento_abreviado").val('');
        $("#frmCausasPenalesPA_0 .siabreviado #causa_H_pena_condenatoria_en_abreviado").val('');
        $("#frmCausasPenalesPA_0 .siabreviado #causa_H_estatus_abreviado").val('-1');
    }
  });
  function addImputadoFormModal()
  {
    if ($("#ddlImputados").val()>-1) {
     $("#frmCausasPenalesPA_0 #idImputado").val($("#ddlImputados").val());
     $("#addImputadoForm").modal("show");
    }
  }  
</script>
