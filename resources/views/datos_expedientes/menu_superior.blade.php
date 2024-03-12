<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <!-- <button class="nav-link {{$menuActivo['1m']}}" id="pills-expediente-tab" data-bs-toggle="pill" data-bs-target="#pills-expediente"  -->
    <button class="nav-link {{$menuActivo['1m']}}" id="pills-expediente-tab" data-bs-toggle="pill" 
    onclick="location.replace('{{ route("dash",["e3",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-expediente" aria-selected="true">
    Datos generales</button>
  </li>
  <li class="nav-item" role="presentation">
    <!-- <button class="nav-link {{$menuActivo['2m']}}" id="pills-victimas-tab" data-bs-toggle="pill" data-bs-target="#pills-victimas" -->
    <button class="nav-link {{$menuActivo['2m']}}" id="pills-victimas-tab" data-bs-toggle="pill" 
    onclick="location.replace('{{ route("dash",["e3v",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-victimas" aria-selected="false">Víctimas</button>
  </li>
  <li class="nav-item" role="presentation">
    <!-- <button class="nav-link {{$menuActivo['3m']}}" id="pills-imputados-tab" data-bs-toggle="pill" data-bs-target="#pills-imputados" -->
    <button class="nav-link {{$menuActivo['3m']}}" id="pills-imputados-tab" data-bs-toggle="pill" 
    onclick="location.replace('{{ route("dash",["e3i",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-imputados" aria-selected="false">
    Imputados</button>
  </li>
  <li class="nav-item" role="presentation">
    <!-- <button class="nav-link {{$menuActivo['4m']}}" id="pills-hechos-tab" data-bs-toggle="pill" data-bs-target="#pills-hechos" -->
    <button class="nav-link {{$menuActivo['4m']}}" id="pills-hechos-tab" data-bs-toggle="pill" 
    onclick="location.replace('{{ route("dash",["e3d",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-hechos" aria-selected="false">Delitos</button>
  </li>
  <li class="nav-item" role="presentation">
    <!-- <button class="nav-link {{$menuActivo['5m']}}" id="pills-objetos-tab" data-bs-toggle="pill" data-bs-target="#pills-objetos" -->
    <button class="nav-link {{$menuActivo['5m']}}" id="pills-objetos-tab" data-bs-toggle="pill" 
    onclick="location.replace('{{ route("dash",["e3o",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-objetos" aria-selected="false">
    Objetos, narcóticos y vehículos</button>
  </li>
  <li class="nav-item" role="presentation">
    <!-- <button class="nav-link {{$menuActivo['6m']}}" id="pills-relacion-tab" data-bs-toggle="pill" data-bs-target="#pills-relacion" -->
    <button class="nav-link {{$menuActivo['6m']}}" id="pills-relacion-tab" data-bs-toggle="pill" 
    onclick="location.replace('{{ route("dash",["e3r",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-relacion" aria-selected="false">Relación</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link {{$menuActivo['8m']}}" id="pills-etapa_investigacion-tab" data-bs-toggle="pill" 
    onclick="location.replace('{{ route("dash",["e3ev",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-etapa_investigacion" aria-selected="false">Investigación inicial</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link {{$menuActivo['9m']}}" id="pills-MASC-tab" data-bs-toggle="pill" 
    onclick="location.replace('{{ route("dash",["e3masc",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-MASC" aria-selected="false">MASC</button>
  </li>  
  <li class="nav-item" role="presentation">
    <button class="nav-link {{$menuActivo['7m']}}" id="pills-determinacion-tab" data-bs-toggle="pill" 
    onclick="location.replace('{{ route("dash",["e3t",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-determinacion" aria-selected="false">Determinación</button>
  </li>
</ul>        
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade {{$menuActivo['1d']}}" id="pills-expediente" role="tabpanel" aria-labelledby="pills-expediente-tab" tabindex="0">
    @if($menuActivo['1d']!='')
      @include("datos_expedientes.form_datos_generales")
    @endif
  </div>
  <div class="tab-pane fade {{$menuActivo['2d']}}" id="pills-victimas" role="tabpanel" aria-labelledby="pills-victimas-tab" tabindex="0">
    @if($menuActivo['2d']!='')
      @if($idExp=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos del expediente para capturar estos datos
       </div>   
      @else
        @include("datos_expedientes.victimas.index")
      @endif
      
    @endif
  </div>
  <div class="tab-pane fade {{$menuActivo['3d']}}" id="pills-imputados" role="tabpanel" aria-labelledby="pills-imputados-tab" tabindex="0">
    @if($menuActivo['3d']!='')
      @if($idExp=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos del expediente para capturar estos datos
       </div>   
      @else
        @include("datos_expedientes.imputados.index")
      @endif
    @endif
  </div>
  <div class="tab-pane fade {{$menuActivo['4d']}}" id="pills-hechos" role="tabpanel" aria-labelledby="pills-hechos-tab" tabindex="0">
    @if($menuActivo['4d']!='')
      @if($idExp=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos del expediente para capturar estos datos
       </div>   
      @else
        @include("datos_expedientes.hechos.index")
      @endif
    @endif
  </div>
  <div class="tab-pane fade {{$menuActivo['5d']}}" id="pills-objetos" role="tabpanel" aria-labelledby="pills-objetos-tab" tabindex="0">
    @if($menuActivo['5d']!='')
      @if($idExp=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos del expediente para capturar estos datos
       </div>   
      @else
        @include("datos_expedientes.objetos.index")
      @endif
    @endif
  </div>
  <div class="tab-pane fade {{$menuActivo['6d']}}" id="pills-relacion" role="tabpanel" aria-labelledby="pills-relacion-tab" tabindex="0">
    @if($menuActivo['6d']!='')
      @if($idExp=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos del expediente para capturar estos datos
       </div>   
      @else
        @include("datos_expedientes.relacion.index")
      @endif
    @endif
  </div>
  <div class="tab-pane fade {{$menuActivo['8d']}}" id="pills-etapa_investigacion" role="tabpanel" aria-labelledby="pills-etapa_investigacion-tab" tabindex="0">
    @if($menuActivo['8d']!='')
      @if($idExp=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos del expediente para capturar estos datos
       </div>   
      @else
        @include("causas_penales.form_etapa_investigacion")
      @endif
    @endif
  </div>    
  <div class="tab-pane fade {{$menuActivo['9d']}}" id="pills-MASC" role="tabpanel" aria-labelledby="pills-MASC-tab" tabindex="0">
    @if($menuActivo['9d']!='')
      @if($idExp=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos del expediente para capturar estos datos
       </div>   
      @else
        <form method='post' name="frmDE_Det" id="frmDE_Det" action="{{ route('save') }}" enctype="multipart/form-data">
         <div class="row"> 
          @csrf  
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">      
                  <div class="mb-4 col-12 pestanaBase">
                    <div class="pestanaTop">
                      <h4>Datos MASC de Fiscalía</h4>
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
                    <button type="button" title="Guardar" class="btn btn-primary float-end" 
                      onclick="javascript:saveImputadoMASC()">Guardar</button>
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
                          <td><a class="btn btn-outline-danger btn-sm" onclick="javascript:eliminarMASC('{{$imputado->id}}')"
                 role="button">Eliminar</a></td>              
                        </tr>
                       @endif
                      @endforeach
                    </tbody>
                  </table>      
          <script type="text/javascript">
              function eliminarMASC(idImputado)
              {    
                var resultado=false;
                var params = new Object(); 
                params._token = '{{csrf_token()}}';
                params.idImputado = idImputado;
                params.idExp = $("#idExp").val();
                params = JSON.stringify(params);
                 $.ajax({      
                  url: "{{Route('eliminarMASC_CP')}}",
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

              $("#causa_H_masc").change(function(){
              console.log(this.value);
              if (this.value==1) {$(".masc").show();}
              else
              {
                $(".masc").hide();
                $(".masc select").val(-1);
                $(".masc input").val('');
              }
            });

            if ($("#causa_H_masc").val()==1) {$(".masc").show();}
            else
            {
              $(".masc").hide();
              $(".masc select").val(-1);
              $(".masc input").val('');
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
                $("#frmDE_Det").submit();
                  //#region Sección 1
                    // $("#ddlImputadosMASC :selected").attr('disabled',true);
                    // $("#tbImputadosMASC tbody").append(newrow);
                    // $("#ddlImputadosMASC").val(-1);
                    // $("#causa_H_masc").val(-1).change();$("#causa_H_fecha_deriva_masc").val('');
                    // $("#causa_H_fecha_cumpl_mas").val('');$("#causa_H_tipo_cumplimiento").val(-1);
                    // $("#causa_H_tipo_masc").val(-1);$("#causa_H_autoridad_deriva_masc").val(-1);
                  //#endregion Sección 1
              }     

            }
          </script>

         </div>
           <!-- <div class="border-top pt-2 modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
           </div>  -->
        </form>

      @endif
    @endif
  </div>

  <div class="tab-pane fade {{$menuActivo['7d']}}" id="pills-determinacion" role="tabpanel" aria-labelledby="pills-determinacion-tab" tabindex="0">
    @if($menuActivo['7d']!='')
      @if($idExp=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos del expediente para capturar estos datos
       </div>   
      @else
        <form method='post' name="frmDE_Det" id="frmDE_Det" action="{{ route('save') }}" enctype="multipart/form-data">
         <div class="row"> 
          @csrf  
          <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
          <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_fecha_determinacion" class="form-label">Fecha de la determinación:</label>
            <input type="date" class="form-control" name="causa_H_fecha_determinacion" id="causa_H_fecha_determinacion" value="{{$datos->FECHA_DETERMINACION??''}}">   
          </div>
          {{--
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
              <label for="expediente_H_remision_otra_area" class="form-label">Remisión a otra área:</label>
              <input type="text" class="form-control alfanum" name="expediente_H_remision_otra_area" id="expediente_H_remision_otra_area"
              value="{{$datos->REMISION_OTRA_AREA??''}}">
            </div>
          --}}
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="expediente_H_remision_otra_area" class="form-label">Remisión a otra área:</label>
            <select class="form-select" name="expediente_H_remision_otra_area" id="expediente_H_remision_otra_area">
              <option value="-1">Seleccione una opción</option>
              @foreach ($respuestas['remisionOtraArea'] as $item)      
                <option value="{{ $item->id }}" {{isset($datos->REMISION_OTRA_AREA)?$datos->REMISION_OTRA_AREA==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
              @endforeach 
           </select>
          </div>           

          <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
            <label for="causa_H_sentido_determinacion" class="form-label">Sentido de la determinación:</label>
            <select class="form-select" name="causa_H_sentido_determinacion" id="causa_H_sentido_determinacion">
              <option value="-1">Seleccione una opción</option>
              @foreach ($respuestas['sentidoDete'] as $item)      
                <option value="{{ $item->id }}" {{isset($datos->SENTIDO_DETERMINACION)?$datos->SENTIDO_DETERMINACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
              @endforeach 
           </select>
          </div>
          <input type="hidden" name="hdntpDete" id="hdntpDete" value='{{strtr($respuestas["tipoDete"],array(
                    "\u00c0" =>"À", "\u00c1" =>"Á", "\u00c2" =>"Â", "\u00c3" =>"Ã", "\u00c4" =>"Ä", "\u00c5" =>"Å",
                    "\u00c6" =>"Æ", "\u00c7" =>"Ç", "\u00c8" =>"È", "\u00c9" =>"É", "\u00ca" =>"Ê", "\u00cb" =>"Ë",
                    "\u00cc" =>"Ì", "\u00cd" =>"Í", "\u00ce" =>"Î", "\u00cf" =>"Ï", "\u00d1" =>"Ñ", "\u00d2" =>"Ò",
                    "\u00d3" =>"Ó", "\u00d4" =>"Ô", "\u00d5" =>"Õ", "\u00d6" =>"Ö", "\u00d8" =>"Ø", "\u00d9" =>"Ù",
                    "\u00da" =>"Ú", "\u00db" =>"Û", "\u00dc" =>"Ü", "\u00dd" =>"Ý", "\u00df" =>"ß", "\u00e0" =>"à",
                    "\u00e1" =>"á", "\u00e2" =>"â", "\u00e3" =>"ã", "\u00e4" =>"ä", "\u00e5" =>"å", "\u00e6" =>"æ",
                    "\u00e7" =>"ç", "\u00e8" =>"è", "\u00e9" =>"é", "\u00ea" =>"ê", "\u00eb" =>"ë", "\u00ec" =>"ì",
                    "\u00ed" =>"í", "\u00ee" =>"î", "\u00ef" =>"ï", "\u00f0" =>"ð", "\u00f1" =>"ñ", "\u00f2" =>"ò",
                    "\u00f3" =>"ó", "\u00f4" =>"ô", "\u00f5" =>"õ", "\u00f6" =>"ö", "\u00f8" =>"ø", "\u00f9" =>"ù",
                    "\u00fa" =>"ú", "\u00fb" =>"û", "\u00fc" =>"ü", "\u00fd" =>"ý", "\u00ff" =>"ÿ"))}}'>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 TipoDet" style="display:none;">
            <label for="causa_H_tipo_determinacion" class="form-label">Tipo de determinación:</label>
            <select class="form-select" name="causa_H_tipo_determinacion" id="causa_H_tipo_determinacion">
              <option value="-1">Seleccione una opción</option>
           </select>
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 accionPenal" style="display:none;">
            <label for="causa_H_tipo_accion_penal" class="form-label">Tipo de acción penal:</label>
            <select class="form-select" name="causa_H_tipo_accion_penal" id="causa_H_tipo_accion_penal">
              <option value="-1">Seleccione una opción</option>
              @foreach ($respuestas['accionPenal'] as $item)      
                <option value="{{ $item->id }}" {{isset($datos->TIPO_ACCION_PENAL)?$datos->TIPO_ACCION_PENAL==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
              @endforeach 
           </select>
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 pagoEmonto" style="display:none;">
            <label for="expediente_H_pago_economico_monto" class="form-label">Monto:</label>
            <input type="text" class="form-control monto" name="expediente_H_pago_economico_monto" id="expediente_H_pago_economico_monto"
            value="{{$datos->PAGO_ECONOMICO_MONTO??''}}">
          </div>
          {{--
            <div class="mb-3 col-sm-12 col-md-6 col-lg-4 archivoTemp" style="display:none;">
              <label for="expediente_H_motivo_determina" class="form-label">Motivo por el que se determina:</label>
              <input type="text" class="form-control" name="expediente_H_motivo_determina" id="expediente_H_motivo_determina"
              value="{{$datos->MOTIVO_DETERMINA??''}}">
            </div>
          --}}
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 archivoTemp" style="display:none;">
            <label for="expediente_H_motivo_determina" class="form-label">Motivo por el que se determina:</label>
            <select class="form-select" name="expediente_H_motivo_determina" id="expediente_H_motivo_determina">
              <option value="-1">Seleccione una opción</option>
              @foreach ($respuestas['motivoDetermina'] as $item)      
                <option value="{{ $item->id }}" {{isset($datos->MOTIVO_DETERMINA)?$datos->MOTIVO_DETERMINA==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>
              @endforeach 
           </select>
          </div>
          <!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-4 archivoTemp" style="display:none;"> -->
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4" style="display:none;">
            <label for="causa_H_archivo_temporal" class="form-label">Archivo temporal reactivo:</label>
            <select class="form-select" name="causa_H_archivo_temporal" id="causa_H_archivo_temporal">
              <option value="-1">Seleccione una opción</option>
              @foreach ($respuestas['SiNo'] as $item)      
                <option value="{{ $item->id }}" {{isset($datos->ARCHIVO_TEMPORAL)?$datos->ARCHIVO_TEMPORAL==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>
              @endforeach 
           </select>
          </div>
          <!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-4 archivoTemp" style="display:none;"> -->
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4" style="display:none;">
            <label for="causa_H_motivo_reactivacion" class="form-label">Motivo de la reactivación:</label>
            <select class="form-select" name="causa_H_motivo_reactivacion" id="causa_H_motivo_reactivacion">
              <option value="-1">Seleccione una opción</option>
              @foreach ($respuestas['motivoReac'] as $item)      
                <option value="{{ $item->id }}" {{isset($datos->MOTIVO_REACTIVACION)?$datos->MOTIVO_REACTIVACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
              @endforeach 
           </select>
          </div>                                            

          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 actoEq" style="display:none;">
            <label for="expediente_H_Folio_AE" class="form-label">Folio:</label>
            <input type="text" class="form-control alfanum" name="expediente_H_Folio_AE" id="expediente_H_Folio_AE"
            value="{{$datos->FOLIO_AE??''}}">
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 actoEq" style="display:none;">
            <label for="expediente_H_acto_equivalente_monto" class="form-label">Monto:</label>
            <input type="text" class="form-control monto" name="expediente_H_acto_equivalente_monto" id="expediente_H_acto_equivalente_monto"
            value="{{$datos->ACTO_EQUIVALENTE_MONTO??''}}">
          </div>
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 ejercicioAP" style="display:none;">
            <label for="expediente_H_fecha_EAP" class="form-label">Fecha:</label>
            <input type="date" class="form-control" name="expediente_H_fecha_EAP" id="expediente_H_fecha_EAP" 
            value="{{$datos->FECHA_EJERCICIO_ACCION_PENAL??''}}">   
          </div>         
          <div class="mb-3 col-sm-12 col-md-6 col-lg-4 acuerdo_P_RD" style="display:none;">
            <label for="causa_H_tipo_acuerdo_perdon_reparacion" class="form-label">Tipo de acuerdo:</label>
            <select class="form-select" name="causa_H_tipo_acuerdo_perdon_reparacion" id="causa_H_tipo_acuerdo_perdon_reparacion">
              <option value="-1">Seleccione una opción</option>
              @foreach ($respuestas['acuerdo_P_RD'] as $item)      
                <option value="{{ $item->id }}" {{isset($datos->TIPO_ACUERDO_PERDON_REPARACION)?$datos->TIPO_ACUERDO_PERDON_REPARACION==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
              @endforeach 
           </select>
          </div>
         </div>

         <div class="border-top pt-2 modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
         </div> 
        </form>
        <script type="text/javascript">
          $(".TipoDet").hide();
            $(".accionPenal").hide();
            $(".pagoEmonto").hide();  
            $(".acuerdo_P_RD").hide();          
            $("#causa_H_tipo_determinacion").html('<option value="-1">Seleccione una opción</option>');
          if($("#causa_H_sentido_determinacion").val()==2)
          {
            $(".TipoDet").show();
            var data=JSON.parse($("#hdntpDete").val()).filter(function(arr){return arr.id<5});
            data.forEach(obj => {        
                $("#causa_H_tipo_determinacion").append('<option value="'+obj.id+'">'+obj.Valor+'</option>'); 
            });   
          }
          if($("#causa_H_sentido_determinacion").val()==3)
          {
            $(".TipoDet").show();
            var data=JSON.parse($("#hdntpDete").val()).filter(function(arr){return (arr.id>4 && arr.id<7)});
            data.forEach(obj => {        
                $("#causa_H_tipo_determinacion").append('<option value="'+obj.id+'">'+obj.Valor+'</option>'); 
            });   
          }
          if($("#causa_H_sentido_determinacion").val()==6)
          {
            $(".TipoDet").show();
            var data=JSON.parse($("#hdntpDete").val()).filter(function(arr){return arr.id>6});
            data.forEach(obj => {        
                $("#causa_H_tipo_determinacion").append('<option value="'+obj.id+'">'+obj.Valor+'</option>'); 
            });
          }
          $("#causa_H_tipo_determinacion").val({{isset($datos->TIPO_DETERMINACION)?$datos->TIPO_DETERMINACION:-1}});
          $(".archivoTemp").hide();
          if($("#causa_H_sentido_determinacion").val()==4)
          {
            $(".archivoTemp").show();
          }
          $(".actoEq").hide();
          if($("#causa_H_sentido_determinacion").val()==7)
          {
            $(".actoEq").show();
          }
          $(".ejercicioAP").hide();          
          if($("#causa_H_sentido_determinacion").val()==10)
          {
            $(".ejercicioAP").show();
          }
          if($("#causa_H_tipo_determinacion").val()==12)
          {
            $(".accionPenal").show();
          } 
          if($("#causa_H_tipo_determinacion").val()==1)
          {
            $(".pagoEmonto").show();
          }          

            if($("#causa_H_tipo_accion_penal").val()==2 || $("#causa_H_tipo_accion_penal").val()==4)
            {
              $(".acuerdo_P_RD").show();
            }

          $("#causa_H_sentido_determinacion").change(function(){              
              $(".TipoDet").hide();
              $(".accionPenal").hide();
              $(".accionPenal select").val(-1);
              $(".pagoEmonto").hide();
              $(".acuerdo_P_RD").hide();
              $(".acuerdo_P_RD select").val(-1);
              $(".pagoEmonto input").val('');              
              $("#causa_H_tipo_determinacion").html('<option value="-1">Seleccione una opción</option>');              
            if(this.value==2)
            {
              $(".TipoDet").show();
              var data=JSON.parse($("#hdntpDete").val()).filter(function(arr){return arr.id<5});
              data.forEach(obj => {        
                  $("#causa_H_tipo_determinacion").append('<option value="'+obj.id+'">'+obj.Valor+'</option>'); 
              });   
            }
            if(this.value==3)
            {
              $(".TipoDet").show();
              var data=JSON.parse($("#hdntpDete").val()).filter(function(arr){return (arr.id>4 && arr.id<7)});
              data.forEach(obj => {        
                  $("#causa_H_tipo_determinacion").append('<option value="'+obj.id+'">'+obj.Valor+'</option>'); 
              });   
            }
            if(this.value==6)
            {
              $(".TipoDet").show();
              var data=JSON.parse($("#hdntpDete").val()).filter(function(arr){return arr.id>6});
              data.forEach(obj => {        
                  $("#causa_H_tipo_determinacion").append('<option value="'+obj.id+'">'+obj.Valor+'</option>'); 
              });   
            }
            $(".archivoTemp").hide();
            $(".archivoTemp select").val(-1);
            $(".archivoTemp input").val('');             
            if(this.value==4)
            {
              $(".archivoTemp").show();
            }

            $(".actoEq").hide();
            $(".actoEq input").val('');             
            if(this.value==7)
            {
              $(".actoEq").show();
            }

            $(".ejercicioAP").hide();
            $(".ejercicioAP input").val('');             
            if(this.value==10)
            {
              $(".ejercicioAP").show();
            }            
          });
          
          $("#causa_H_tipo_determinacion").change(function(){
            $(".accionPenal").hide();
            $(".accionPenal select").val(-1);
            $(".acuerdo_P_RD").hide();
              $(".acuerdo_P_RD select").val(-1);
            if(this.value==12)
            {
              $(".accionPenal").show();
            }                            

            $(".pagoEmonto").hide();
            $(".pagoEmonto input").val('');
            if(this.value==1)
            {
              $(".pagoEmonto").show();
            }

          });               
          $("#causa_H_tipo_accion_penal").change(function(){
            $(".acuerdo_P_RD").hide();
            $(".acuerdo_P_RD select").val(-1);
            if(this.value==1 || this.value==4)
            {
              $(".acuerdo_P_RD").show();
            } 
          }); 
        </script>
      @endif
    @endif
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

  function eliminarReload(idR,idT,modalOn=false)
  {
    if (modalOn) {    
      var params = new Object();
      params.idR = $("#idR").val();
      params.idT = $("#idT").val();
      params._token = '{{csrf_token()}}';
      params = JSON.stringify(params);
      $.ajax({      
          url: "{{Route('delDataDE')}}",
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
  $(".monto").mask("#,##0.00",{reverse: true});
  $(".noletra").mask('NNNN',
  {translation:  {'N': {pattern: /[0-9]/, recursive: true}}});
  $(".alfanum").mask('XXXX',
      {translation:  {'X': {pattern: /[0-9a-zA-ZñÑ\s]/, recursive: true}}}); 
  $(".temporalidad").mask('YYYY',
    {translation:  {'Y': {pattern: /[0-9díiasDÍIAS\s]/, recursive: true}}});      
  $(".nonum").mask('ZZZZ',
    {translation:  {'Z': {pattern: /[a-zA-Z\s]/, recursive: true}}});
</script>