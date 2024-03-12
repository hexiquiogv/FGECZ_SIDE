<!-- Nav tabs -->
<ul class="nav nav-tabs visually-hidden" id="myTab" role="tablist">
  @if(Auth::User()->TipoUsuario==99)
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeAU')" id="agregar-usuario-tab" data-bs-toggle="tab" 
    data-bs-target="#agregar-usuario" type="button" role="tab" aria-controls="agregar-usuario" 
    aria-selected="@yield('selectedAU')">agregar-usuario</button>
  </li>  
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeCM')" id="carga-masiva-tab" data-bs-toggle="tab" data-bs-target="#carga-masiva" 
    type="button" role="tab" aria-controls="carga-masiva" aria-selected="@yield('selectedCM')">carga-masiva</button>
  </li>    
  @else
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeDE')" id="datos-expediente-tab" data-bs-toggle="tab" data-bs-target="#datos-expediente" type="button" role="tab" aria-controls="datos-expediente" aria-selected="@yield('selectedDE')">datos-expediente</button>
  </li>  
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeCO')" id="conduccion-tab" data-bs-toggle="tab" data-bs-target="#conduccion" type="button" role="tab" aria-controls="conduccion" aria-selected="@yield('selectedCO')">conduccion</button>
  </li>   
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeND')" id="no-delictivos-tab" data-bs-toggle="tab" data-bs-target="#no-delictivos" type="button" role="tab" aria-controls="no-delictivos" aria-selected="@yield('selectedND')">no-delictivos</button>
  </li>     
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeCP')" id="causas-penales-tab" data-bs-toggle="tab" data-bs-target="#causas-penales" type="button" role="tab" aria-controls="causas-penales" aria-selected="@yield('selectedCP')">causas-penales</button>
  </li> 
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeNT')" id="notificaciones-tab" data-bs-toggle="tab" data-bs-target="#notificaciones" type="button" role="tab" aria-controls="notificaciones" aria-selected="@yield('selectedNT')">notificaciones</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeLI')" id="listado-exp-tab" data-bs-toggle="tab" data-bs-target="#listado-exp" type="button" role="tab" aria-controls="listado-exp" aria-selected="@yield('selectedLI')">listado-exp</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeLICC')" id="listado-expCC-tab" data-bs-toggle="tab" data-bs-target="#listado-expCC" type="button" role="tab" aria-controls="listado-expCC" aria-selected="@yield('selectedLICC')">listado-expCC</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeLIND')" id="listado-expND-tab" data-bs-toggle="tab" data-bs-target="#listado-expND" type="button" role="tab" aria-controls="listado-expND" aria-selected="@yield('selectedLIND')">listado-expND</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeLS')" id="listado-sup-tab" data-bs-toggle="tab" data-bs-target="#listado-sup" type="button" role="tab" aria-controls="listado-sup" aria-selected="@yield('selectedLS')">listado-sup</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeLSCC')" id="listado-supCC-tab" data-bs-toggle="tab" data-bs-target="#listado-supCC" type="button" role="tab" aria-controls="listado-supCC" aria-selected="@yield('selectedLSCC')">listado-supCC</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeLSND')" id="listado-supND-tab" data-bs-toggle="tab" data-bs-target="#listado-supND" type="button" role="tab" aria-controls="listado-supND" aria-selected="@yield('selectedLSND')">listado-supND</button>
  </li>    
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeDS')" id="detalle-sup-tab" data-bs-toggle="tab" data-bs-target="#detalle-sup" type="button" role="tab" aria-controls="detalle-sup" 
    aria-selected="@yield('selectedDS')">detalle-sup</button>
  </li>  
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeFX')" id="form-excel-tab" data-bs-toggle="tab" data-bs-target="#form-excel" 
    type="button" role="tab" aria-controls="form-excel" aria-selected="@yield('selectedFX')">form-excel</button>
  </li>



  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeDBE')" id="dashboardestad-tab" data-bs-toggle="tab" data-bs-target="#dashboardestad" type="button" role="tab" aria-controls="dashboardestad" aria-selected="@yield('selectedDBE')">dashboardestad</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeTDE')" id="tabladatosestad-tab" data-bs-toggle="tab" data-bs-target="#tabladatosestad" type="button" role="tab" aria-controls="tabladatosestad" aria-selected="@yield('selectedTDE')">tabladatosestad</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link @yield('activeDDE')" id="descargadatos-tab" data-bs-toggle="tab" data-bs-target="#descargadatos" type="button" role="tab" aria-controls="descargadatos" aria-selected="@yield('selectedDDE')">descargadatos</button>
  </li>
    
  <!--<li class="nav-item" role="presentation">
    <button class="nav-link" id="personas-judicializadas-tab" data-bs-toggle="tab" 
    data-bs-target="#personas-judicializadas" type="button" role="tab" aria-controls="personas-judicializadas" 
    aria-selected="false">personas-judicializadas</button>
  </li>-->
  <!--<li class="nav-item" role="presentation">
    <button class="nav-link" id="detalle-persona-judicializada-1-tab" data-bs-toggle="tab" data-bs-target="#detalle-persona-judicializada-1" type="button" role="tab" aria-controls="detalle-persona-judicializada-1" aria-selected="false">detalle-persona-judicializada-1</button>
  </li>-->
  @endif
</ul>
  
<!-- Tab panes -->
<div class="tab-content">
 @if(Auth::User()->TipoUsuario==99)
  <div class="tab-pane @yield('activeAU')" id="agregar-usuario" role="tabpanel" aria-labelledby="agregar-usuario-tab" tabindex="0">
    @yield('indexAU')
  </div>
  <div class="tab-pane @yield('activeCM')" id="carga-masiva" role="tabpanel" aria-labelledby="carga-masiva-tab" tabindex="0">
    @yield('indexCM')
  </div>   
 @else
  <div class="tab-pane @yield('activeDE')" id="datos-expediente" role="tabpanel" aria-labelledby="datos-expediente-tab" tabindex="0">
    @yield('indexDE')
  </div>
  <div class="tab-pane @yield('activeCO')" id="conduccion" role="tabpanel" aria-labelledby="conduccion-tab" tabindex="0">
    @yield('indexCO')
  </div>  
  <div class="tab-pane @yield('activeND')" id="no-delictivos" role="tabpanel" aria-labelledby="no-delictivos-tab" tabindex="0">
    @yield('indexND')
  </div>  
  <div class="tab-pane @yield('activeCP')" id="causas-penales" role="tabpanel" aria-labelledby="causas-penales-tab" tabindex="0">
    @yield('indexCP')
  </div>
  <div class="tab-pane @yield('activeNT')" id="notificaciones" role="tabpanel" aria-labelledby="notificaciones-tab" tabindex="0">
    @yield('indexNT')
  </div>  
  <div class="tab-pane @yield('activeLI')" id="listado-exp" role="tabpanel" aria-labelledby="listado-exp-tab" tabindex="0">
    @yield('indexLI')
  </div> 
  <div class="tab-pane @yield('activeLICC')" id="listado-expCC" role="tabpanel" aria-labelledby="listado-expCC-tab" tabindex="0">
    @yield('indexLICC')
  </div> 
  <div class="tab-pane @yield('activeLIND')" id="listado-expND" role="tabpanel" aria-labelledby="listado-expND-tab" tabindex="0">
    @yield('indexLIND')
  </div>   
  <div class="tab-pane @yield('activeLS')" id="listado-sup" role="tabpanel" aria-labelledby="listado-sup-tab" tabindex="0">
    @yield('indexLS')
  </div>  
  <div class="tab-pane @yield('activeLSCC')" id="listado-supCC" role="tabpanel" aria-labelledby="listado-supCC-tab" tabindex="0">
    @yield('indexLSCC')
  </div>  
  <div class="tab-pane @yield('activeLSND')" id="listado-supND" role="tabpanel" aria-labelledby="listado-supND-tab" tabindex="0">
    @yield('indexLSND')
  </div>
  <div class="tab-pane @yield('activeDS')" id="detalle-sup" role="tabpanel" aria-labelledby="detalle-sup-tab" tabindex="0">
    @yield('indexDS')
  </div>        
  <div class="tab-pane @yield('activeFX')" id="form-excel" role="tabpanel" aria-labelledby="form-excel-tab" tabindex="0">
    @yield('indexFX')
  </div>   
  
  <div class="tab-pane @yield('activeDBE')" id="dashboardestad" role="tabpanel" aria-labelledby="dashboardestad-tab" tabindex="0">
    @yield('indexDBE')
  </div>  
  <div class="tab-pane @yield('activeTDE')" id="tabladatosestad" role="tabpanel" aria-labelledby="tabladatosestad-tab" tabindex="0">
    @yield('indexTDE')
  </div>  
  <div class="tab-pane @yield('activeDDE')" id="descargadatos" role="tabpanel" aria-labelledby="descargadatos-tab" tabindex="0">
    @yield('indexDDE')
  </div>

  <!--<div class="tab-pane" id="personas-judicializadas" role="tabpanel" 
  aria-labelledby="personas-judicializadas-tab" tabindex="0">
  {{--@include("personas_judicializadas.index")--}}
  </div>-->
  <!--<div class="tab-pane" id="detalle-persona-judicializada-1" role="tabpanel" 
  aria-labelledby="detalle-persona-judicializada-1-tab" tabindex="0">
  {{-- @include("personas_judicializadas.detalle_persona_judicializada_1")--}}
  </div>-->
 @endif  
  @if(Session::has('registration'))
  <div class="alert alert-success">
   {{ Session::get('registration') }}
  </div>
  @endif
  @if(Session::has('correoRepetido'))
  <div class="alert alert-danger">
   {!! Session::get('correoRepetido') !!}
  </div>
  @endif    
</div>
