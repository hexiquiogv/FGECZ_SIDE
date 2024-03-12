
<div class="row accordion accordion-flush shadow mb-4" style="justify-content: center;" id="accordionPanelsStayOpenExample">
 @if(Auth::user()->TipoUsuario==99)
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsAgregarUsuariosHeading">
      <button class="accordion-button @yield('collapsedAU','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsAgregarUsuariosCollapseOne" aria-expanded="true" 
      aria-controls="panelsAgregarUsuariosCollapseOne">
        Agregar Usuario
      </button>
    </h2>
    <div id="panelsAgregarUsuariosCollapseOne" class="accordion-collapse collapse border m-0 p-0" 
    aria-labelledby="panelsAgregarUsuariosHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsCargaMasivaHeading">
      <button class="accordion-button @yield('collapsedCM','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsCargaMasivaCollapse" aria-expanded="false" aria-controls="panelsCargaMasivaCollapse">
        Carga masiva de Usuario
      </button>
    </h2>
    <div id="panelsCargaMasivaCollapse" class="accordion-collapse collapse" 
    aria-labelledby="panelsCargaMasivaHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>   
 @else
  @if(View::hasSection('collapsedNT'))   
  <div class="accordion-item col-3 px-0 d-none">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsNotificacionesHeading">
      <button class="accordion-button @yield('collapsedNT','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsNotificacionesCollapseOne" aria-expanded="true" 
      aria-controls="panelsNotificacionesCollapseOne">
        Notificaciones
      </button>
    </h2>
    <div id="panelsNotificacionesCollapseOne" class="accordion-collapse collapse border m-0 p-0" 
    aria-labelledby="panelsNotificacionesHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>
  @endif 
  @if(View::hasSection('collapsedLI') || View::hasSection('collapsedLICC') || View::hasSection('collapsedLIND'))
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsListadoExpHeading">
      <button class="accordion-button @yield('collapsedLI','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsListadoExpCollapseOne" aria-expanded="false" 
      aria-controls="panelsListadoExpCollapseOne">
        Listado de Expedientes Delictivos
      </button>
    </h2>
    <div id="panelsListadoExpCollapseOne" class="accordion-collapse collapse" 
    aria-labelledby="panelsListadoExpHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>  
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsListadoExpCCHeading">
      <button class="accordion-button @yield('collapsedLICC','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsListadoExpCCCollapseOne" aria-expanded="false" 
      aria-controls="panelsListadoExpCCCollapseOne">
        Listado de Expedientes Conducción
      </button>
    </h2>
    <div id="panelsListadoExpCCCollapseOne" class="accordion-collapse collapse" 
    aria-labelledby="panelsListadoExpCCHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>  
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsListadoExpNDHeading">
      <button class="accordion-button @yield('collapsedLIND','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsListadoExpNDCollapseOne" aria-expanded="false" 
      aria-controls="panelsListadoExpNDCollapseOne">
        Listado de Expedientes No delictivos
      </button>
    </h2>
    <div id="panelsListadoExpNDCollapseOne" class="accordion-collapse collapse" 
    aria-labelledby="panelsListadoExpNDHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>      
  @endif    
  @if(View::hasSection('collapsedFX'))   
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsFormExcelHeading">
      <button class="accordion-button @yield('collapsedFX','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsFormExcelCollapse" aria-expanded="false" aria-controls="panelsFormExcelCollapse">
        Carga de Formulario Excel
      </button>
    </h2>
    <div id="panelsFormExcelCollapse" class="accordion-collapse collapse" 
    aria-labelledby="panelsFormExcelHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>
  @endif
  @if(View::hasSection('collapsedLS') || View::hasSection('collapsedLSCC') || View::hasSection('collapsedLSND'))
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsListadoSupHeading">
      <button class="accordion-button @yield('collapsedLS','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsListadoSupCollapseOne" aria-expanded="false" 
      aria-controls="panelsListadoSupCollapseOne">
        Carpetas Iniciadas
      </button>
    </h2>
    <div id="panelsListadoSupCollapseOne" class="accordion-collapse collapse" 
    aria-labelledby="panelsListadoSupHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div> 
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsListadoSupCCHeading">
      <button class="accordion-button @yield('collapsedLSCC','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsListadoSupCCCollapseOne" aria-expanded="false" 
      aria-controls="panelsListadoSupCCCollapseOne">
        Conducción
      </button>
    </h2>
    <div id="panelsListadoSupCCCollapseOne" class="accordion-collapse collapse" 
    aria-labelledby="panelsListadoSupCCHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div> 
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsListadoSupNDHeading">
      <button class="accordion-button @yield('collapsedLSND','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsListadoSupNDCollapseOne" aria-expanded="false" 
      aria-controls="panelsListadoSupNDCollapseOne">
        Hechos no delictivos
      </button>
    </h2>
    <div id="panelsListadoSupNDCollapseOne" class="accordion-collapse collapse" 
    aria-labelledby="panelsListadoSupNDHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>      

  @endif 
  @if(View::hasSection('collapsedDE') || View::hasSection('collapsedCP')) 
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsDatosExpedienteHeading">
      <button class="accordion-button @yield('collapsedDE','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsDatosExpedienteCollapseOne" aria-expanded="true" 
      aria-controls="panelsDatosExpedienteCollapseOne">
        Datos expediente
      </button>
    </h2>
    <div id="panelsDatosExpedienteCollapseOne" class="accordion-collapse collapse border m-0 p-0" 
    aria-labelledby="panelsDatosExpedienteHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>
  @endif
  @if(View::hasSection('collapsedCO'))   
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsConduccionHeading">
      <button class="accordion-button @yield('collapsedCO','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsConduccionCollapseOne" aria-expanded="false" 
      aria-controls="panelsConduccionCollapseOne">
        Expediente Conducción
      </button>
    </h2>
    <div id="panelsConduccionCollapseOne" class="accordion-collapse collapse" 
    aria-labelledby="panelsConduccionHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>  
  @endif
  @if(View::hasSection('collapsedND'))   
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsNoDelictivosHeading">
      <button class="accordion-button @yield('collapsedND','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsNoDelictivosCollapseOne" aria-expanded="false" 
      aria-controls="panelsNoDelictivosCollapseOne">
        Expediente No Delictivos
      </button>
    </h2>
    <div id="panelsNoDelictivosCollapseOne" class="accordion-collapse collapse" 
    aria-labelledby="panelsNoDelictivosHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>  
  @endif
  @if(View::hasSection('collapsedDE') || View::hasSection('collapsedCP'))     
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsCausasPenalesHeading">
      <button class="accordion-button @yield('collapsedCP','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsCausasPenalesCollapseOne" aria-expanded="false" 
      aria-controls="panelsCausasPenalesCollapseOne">
        Causas penales
      </button>
    </h2>
    <div id="panelsCausasPenalesCollapseOne" class="accordion-collapse collapse" 
    aria-labelledby="panelsCausasPenalesHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>
  @endif

  @if(View::hasSection('collapsedDBE') || View::hasSection('collapsedTDE') || View::hasSection('collapsedDDE') )
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsDashboardEstadHeading">
      <button class="accordion-button @yield('collapsedDBE','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsDashboarEstadCollapseOne" aria-expanded="false" 
      aria-controls="panelsDashboarEstadCollapseOne">
        Tablero dinámico
      </button>
    </h2>
    <div id="panelsDashboarEstadCollapseOne" class="accordion-collapse collapse" 
    aria-labelledby="panelsDashboarEstadHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div> 
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelstabladatosEstadHeading">
      <button class="accordion-button @yield('collapsedTDE','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelstabladatosEstadCollapseOne" aria-expanded="false" 
      aria-controls="panelstabladatosEstadCollapseOne">
        Tabla de datos
      </button>
    </h2>
    <div id="panelstabladatosEstadCollapseOne" class="accordion-collapse collapse" 
    aria-labelledby="panelstabladatosEstadHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div> 
  <div class="accordion-item col-3 px-0">
    <h2 class="accordion-header option_menu_causa_penal" id="panelsdescargaDatosHeading">
      <button class="accordion-button @yield('collapsedDDE','collapsed')" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsdescargaDatosCollapseOne" aria-expanded="false" 
      aria-controls="panelsdescargaDatosCollapseOne">
        Descarga de datos
      </button>
    </h2>
    <div id="panelsdescargaDatosCollapseOne" class="accordion-collapse collapse" 
    aria-labelledby="panelsdescargaDatosHeading" data-bs-parent="#accordionPanelsStayOpenExample">
      <div class="accordion-body m-0 p-0">
      </div>
    </div>
  </div>
   

  @endif 
  <!--<div class="accordion-item">
		<h2 class="accordion-header option_menu_causa_penal" id="panelsPersonasJudicializadasHeading">
		  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
		  data-bs-target="#panelsPersonasJudicializadasCollapse" aria-expanded="false" 
		  aria-controls="panelsPersonasJudicializadasCollapse">
			Personas judicializadas
		  </button>
		</h2>
		<div id="panelsPersonasJudicializadasCollapse" class="accordion-collapse collapse" 
		aria-labelledby="panelsPersonasJudicializadasHeading" data-bs-parent="#accordionPanelsStayOpenExample">
		  <div class="accordion-body">
		  {{-- @include("personas_judicializadas.list")--}}
		  </div>
		</div>
	  </div>-->

 @endif
</div>