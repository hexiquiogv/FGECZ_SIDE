<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <!-- <button class="nav-link active" id="pills-carpeta-tab" data-bs-toggle="pill" data-bs-target="#pills-carpeta" type="button" role="tab" aria-controls="pills-carpeta"  -->
    <button class="nav-link {{$menuActivo['1m']}}" id="pills-carpeta-tab" data-bs-toggle="pill" 
    onclick="location.replace('{{ route("dash",["d0",Request::segment(3),Request::segment(4)]) }}');" type="button" role="tab" aria-controls="pills-carpeta" aria-selected="true">Datos generales</button>
  </li>
  <li class="nav-item" role="presentation">
    <!-- <button class="nav-link" id="pills-etapa_investigacion-tab" data-bs-toggle="pill" data-bs-target="#pills-etapa_investigacion" type="button" role="tab" aria-controls=" -->
		<button class="nav-link {{$menuActivo['2m']}}" id="pills-etapa_investigacion-tab" data-bs-toggle="pill"
		onclick="location.replace('{{ route("dash",["d0ev",Request::segment(3),Request::segment(4)]) }}');"  type="button" role="tab" aria-controls="    	
    pills-etapa_investigacion" aria-selected="false">Investigación inicial</button>
  </li>
  <li class="nav-item" role="presentation">
    <!-- <button class="nav-link" id="pills-audiencia_inicial-tab" data-bs-toggle="pill" data-bs-target="#pills-audiencia_inicial" type="button" role="tab" aria-controls=" -->
    <button class="nav-link {{$menuActivo['3m']}} position-relative" id="pills-audiencia_inicial-tab" data-bs-toggle="pill"
    onclick="location.replace('{{ route("dash",["d0ai",Request::segment(3),Request::segment(4)]) }}');"  type="button" role="tab" aria-controls="
    pills-audiencia_inicial" aria-selected="false">Audiencia inicial
    @if($audienciaInicial->Vigencia??0)
<!--       <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
        <span class="visually-hidden">!</span>
      </span> -->
      <span class="badge text-bg-danger">!</span>
    @endif
    </button>
  </li>     
  <li class="nav-item" role="presentation">
    <button class="nav-link {{$menuActivo['7m']}}" id="pills-medidas_cautelares-tab" data-bs-toggle="pill"
    onclick="location.replace('{{ route("dash",["d0mc",Request::segment(3),Request::segment(4)]) }}');"  type="button" role="tab" aria-controls="
    pills-medidas_cautelares" aria-selected="false">Medidas cautelares</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link {{$menuActivo['8m']}}" id="pills-salidas_alternas-tab" data-bs-toggle="pill"
    onclick="location.replace('{{ route("dash",["d0sa",Request::segment(3),Request::segment(4)]) }}');"  type="button" role="tab" 
    aria-controls="pills-salidas_alternas" aria-selected="false">Salidas alternas</button>
  </li>

  <li class="nav-item" role="presentation">
    <!-- <button class="nav-link" id="pills-procedimiento_abreviado-tab" data-bs-toggle="pill" data-bs-target="#pills-procedimiento_abreviado" type="button" role="tab" aria-controls="pills-procedimiento_abreviado" -->
    <button class="nav-link {{$menuActivo['4m']}}" id="pills-procedimiento_abreviado-tab" data-bs-toggle="pill"
    onclick="location.replace('{{ route("dash",["d0pa",Request::segment(3),Request::segment(4)]) }}');"  type="button" role="tab" aria-controls="
    pills-procedimiento_abreviado" aria-selected="false">Procedimiento abreviado</button>
  </li>
  <li class="nav-item" role="presentation">    
    <button class="nav-link {{$menuActivo['9m']}}" id="pills-suspension_sobreseimiento-tab" data-bs-toggle="pill"
    onclick="location.replace('{{ route("dash",["d0ss",Request::segment(3),Request::segment(4)]) }}');"  type="button" role="tab" aria-controls="
    pills-suspension_sobreseimiento" aria-selected="false">Suspensión y sobreseimiento</button>
  </li>
  <li class="nav-item" role="presentation">
    <!-- <button class="nav-link" id="pills-etapa_intermedia-tab" data-bs-toggle="pill" data-bs-target="#pills-etapa_intermedia" type="button" role="tab" aria-controls="pills-etapa_intermedia" -->
    <button class="nav-link {{$menuActivo['5m']}}" id="pills-etapa_intermedia-tab" data-bs-toggle="pill"
    onclick="location.replace('{{ route("dash",["d0ei",Request::segment(3),Request::segment(4)]) }}');"  type="button" role="tab" aria-controls="
    pills-etapa_intermedia" aria-selected="false">Etapa intermedia</button>
  </li>
  <li class="nav-item" role="presentation">
    <!-- <button class="nav-link" id="pills-juicio_oral-tab" data-bs-toggle="pill" data-bs-target="#pills-juicio_oral" type="button" role="tab" aria-controls="pills-juicio_oral"  -->
		<button class="nav-link {{$menuActivo['6m']}}" id="pills-juicio_oral-tab" data-bs-toggle="pill"
		onclick="location.replace('{{ route("dash",["d0jo",Request::segment(3),Request::segment(4)]) }}');" type="button" role="tab" aria-controls="pills-juicio_oral"     	
    aria-selected="false">Juicio oral</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link {{$menuActivo['10m']}}" id="pills-recursos-tab" data-bs-toggle="pill"
    onclick="location.replace('{{ route("dash",["d0re",Request::segment(3),Request::segment(4)]) }}');" type="button" role="tab" aria-controls="pills-recursos-tab"      
    aria-selected="false">Recursos</button>
  </li>  
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade {{$menuActivo['1d']}}" id="pills-carpeta" role="tabpanel" aria-labelledby="pills-carpeta-tab" tabindex="0">
    @if($menuActivo['1d']!='')
      @if($mostrarCP==0)
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        El expediente debe contar con un ejercicio de la acción penal como determinación para iniciar una Causa Penal
       </div>   
      @else
        @include("causas_penales.form_datos_generales")
      @endif
    @endif
  </div>
  <div class="tab-pane fade {{$menuActivo['2d']}}" id="pills-etapa_investigacion" role="tabpanel" aria-labelledby="pills-etapa_investigacion-tab" tabindex="0">
    @if($menuActivo['2d']!='')
      @if($idRegistro=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos generales de la causa penal capturar estos datos
       </div>   
      @else
        @if($mostrarCP==0)
         <div class="alert alert-warning" id="">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          El expediente debe contar con un ejercicio de la acción penal como determinación para iniciar una Causa Penal
         </div>   
        @else      
          @include("causas_penales.form_etapa_investigacion")
        @endif
      @endif
		@endif
  </div> 
  <div class="tab-pane fade {{$menuActivo['3d']}}" id="pills-audiencia_inicial" role="tabpanel" aria-labelledby="pills-audiencia_inicial-tab" tabindex="0">
    @if($menuActivo['3d']!='')
      @if($idRegistro=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos generales de la causa penal capturar estos datos
       </div>   
      @else
        @if($mostrarCP==0)
         <div class="alert alert-warning" id="">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          El expediente debe contar con un ejercicio de la acción penal como determinación para iniciar una Causa Penal
         </div>   
        @else            
        @include("causas_penales.form_audiencia_inicial")
        @endif
      @endif
		@endif
  </div>   
  <div class="tab-pane fade {{$menuActivo['4d']}}" id="pills-procedimiento_abreviado" role="tabpanel" aria-labelledby="pills-procedimiento_abreviado-tab" tabindex="0">
    @if($menuActivo['4d']!='')
      @if($idRegistro=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos generales de la causa penal capturar estos datos
       </div>   
      @else
        @if($mostrarCP==0)
         <div class="alert alert-warning" id="">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          El expediente debe contar con un ejercicio de la acción penal como determinación para iniciar una Causa Penal
         </div>   
        @else            
        @include("causas_penales.form_procedimiento_abreviado")
        @endif
      @endif
		@endif
  </div>   
  <div class="tab-pane fade {{$menuActivo['5d']}}" id="pills-etapa_intermedia" role="tabpanel" aria-labelledby="pills-etapa_intermedia-tab" tabindex="0">
    @if($menuActivo['5d']!='')
      @if($idRegistro=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos generales de la causa penal capturar estos datos
       </div>   
      @else
        @if($mostrarCP==0)
         <div class="alert alert-warning" id="">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          El expediente debe contar con un ejercicio de la acción penal como determinación para iniciar una Causa Penal
         </div>   
        @else            
        @include("causas_penales.form_etapa_intermedia")
        @endif
      @endif
		@endif
  </div>   
  <div class="tab-pane fade {{$menuActivo['6d']}}" id="pills-juicio_oral" role="tabpanel" aria-labelledby="pills-juicio_oral-tab" tabindex="0">
    @if($menuActivo['6d']!='')
      @if($idRegistro=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos generales de la causa penal capturar estos datos
       </div>   
      @else
        @if($mostrarCP==0)
         <div class="alert alert-warning" id="">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          El expediente debe contar con un ejercicio de la acción penal como determinación para iniciar una Causa Penal
         </div>   
        @else            
        @include("causas_penales.form_juicio_oral")
        @endif
      @endif
		@endif
  </div>    
  <div class="tab-pane fade {{$menuActivo['7d']}}" id="pills-medidas_cautelares" role="tabpanel" aria-labelledby="pills-medidas_cautelares-tab" tabindex="0">
    @if($menuActivo['7d']!='')
      @if($idRegistro=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos generales de la causa penal capturar estos datos
       </div>   
      @else
        @if($mostrarCP==0)
         <div class="alert alert-warning" id="">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          El expediente debe contar con un ejercicio de la acción penal como determinación para iniciar una Causa Penal
         </div>   
        @else            
        @include("causas_penales.form_medidas_cautelares")
        @endif
      @endif
    @endif
  </div>  
  <div class="tab-pane fade {{$menuActivo['8d']}}" id="pills-salidas_alternas" role="tabpanel" aria-labelledby="pills-salidas_alternas-tab" tabindex="0">
    @if($menuActivo['8d']!='')
      @if($idRegistro=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos generales de la causa penal capturar estos datos
       </div>   
      @else
        @if($mostrarCP==0)
         <div class="alert alert-warning" id="">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          El expediente debe contar con un ejercicio de la acción penal como determinación para iniciar una Causa Penal
         </div>   
        @else            
        @include("causas_penales.form_salidas_alternas")
        @endif
      @endif
    @endif
  </div>  
  <div class="tab-pane fade {{$menuActivo['9d']}}" id="pills-suspension_sobreseimiento" role="tabpanel" aria-labelledby="pills-suspension_sobreseimiento-tab" tabindex="0">
    @if($menuActivo['9d']!='')
      @if($idRegistro=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos generales de la causa penal capturar estos datos
       </div>   
      @else
        @if($mostrarCP==0)
         <div class="alert alert-warning" id="">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          El expediente debe contar con un ejercicio de la acción penal como determinación para iniciar una Causa Penal
         </div>   
        @else            
        @include("causas_penales.form_suspension_sobreseimiento")
        @endif
      @endif
    @endif
  </div>  
  <div class="tab-pane fade {{$menuActivo['10d']}}" id="pills-recursos" role="tabpanel" aria-labelledby="pills-recursos-tab" tabindex="0">
    @if($menuActivo['10d']!='')
      @if($idRegistro=='30')
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        Deben registrarse los datos generales de la causa penal capturar estos datos
       </div>   
      @else
        @if($mostrarCP==0)
         <div class="alert alert-warning" id="">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          El expediente debe contar con un ejercicio de la acción penal como determinación para iniciar una Causa Penal
         </div>   
        @else            
        @include("causas_penales.form_recursos")
        @endif
      @endif
    @endif
  </div>        
</div>

<script type="text/javascript">

</script>