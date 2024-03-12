<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link {{$menuActivo['1m']}}" id="pills-expediente-tab" data-bs-toggle="pill"
     onclick="location.replace('{{ route("dash",["d9",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-expediente" aria-selected="true">Datos generales</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link {{$menuActivo['2m']}}" id="pills-victimas-tab" data-bs-toggle="pill"
     onclick="location.replace('{{ route("dash",["d9v",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-victimas" aria-selected="false">Víctimas</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link {{$menuActivo['3m']}}" id="pills-imputados-tab" data-bs-toggle="pill" 
    onclick="location.replace('{{ route("dash",["d9i",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-imputados" aria-selected="false">Imputados</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link {{$menuActivo['4m']}}" id="pills-hechos-tab" data-bs-toggle="pill"
     onclick="location.replace('{{ route("dash",["d9d",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-hechos" aria-selected="false">Delitos</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link {{$menuActivo['5m']}}" id="pills-objetos-tab" data-bs-toggle="pill"
     onclick="location.replace('{{ route("dash",["d9o",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-objetos" aria-selected="false">
   Objetos, narcóticos y vehículos</button>
  </li>
<!--   <li class="nav-item" role="presentation">
    <button class="nav-link {{$menuActivo['6m']}}" id="pills-relacion-tab" data-bs-toggle="pill"
     onclick="location.replace('{{ route("dash",["d9r",Request::segment(3)]) }}');" type="button" role="tab" aria-controls="pills-relacion" aria-selected="false">Relación</button>
  </li> -->

</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade {{$menuActivo['1d']}}" id="pills-expediente" role="tabpanel" aria-labelledby="pills-expediente-tab" tabindex="0">
   @if($menuActivo['1d']!='')
    @include("carpeta_conduccion.form_datos_generales")
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
        @include("carpeta_conduccion.victimas.index")
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
        @include("carpeta_conduccion.imputados.index")
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
        @include("carpeta_conduccion.hechos.index")
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
        @include("carpeta_conduccion.objetos.index")
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
        @include("carpeta_conduccion.relacion.index")
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
  $(".noletra").mask('NNNN',
  {translation:  {'N': {pattern: /[0-9]/, recursive: true}}});
  $(".alfanum").mask('XXXX',
      {translation:  {'X': {pattern: /[0-9a-zA-Z\s]/, recursive: true}}}); 
  $(".temporalidad").mask('YYYY',
    {translation:  {'Y': {pattern: /[0-9díiasDÍIAS\s]/, recursive: true}}});      
  $(".nonum").mask('ZZZZ',
    {translation:  {'Z': {pattern: /[a-zA-Z\s]/, recursive: true}}});  
</script>