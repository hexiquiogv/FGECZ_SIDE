<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="content">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIDE | FGE Coahuila</title>    
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset('/logo-fge.png')}}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <link href="{{URL::asset('/bootstrap5.3.0/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{URL::asset('/bootstrap5.3.0/bootstrap.bundle.min.js')}}" rel="stylesheet"></script>
    <script src="{{URL::asset('/bootstrap5.3.0/jquery-3.6.3.min.js')}}"></script>
    <script src="{{URL::asset('/bootstrap5.3.0/jquery.mask.min.js')}}"></script>
    <script src="{{URL::asset('/bootstrap5.3.0/Chart.js/3.9.1/chart.min.js')}}" ></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> -->

</head>
<body>
 @auth  

  <style type="text/css">
   .pestanaBase{ 
    border-bottom: 1px solid #cfe2ff;
    }
   .pestanaTop{
    border-radius: 6px 6px 0 0; 
    display: inline-block;position: relative; 
    border: 1px solid #cfe2ff;
    border-bottom: 2px solid #FFF;
    padding: 5px 15px 0 15px;
    margin-bottom: -1px;
    color: #4958ca;
    }
    /* fill='%237E6D54' aquí el %23 es el # y lo demás es el código del color */
    .accordion {
        /*    --bs-accordion-btn-icon:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%237E6D54'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");*/
            --bs-accordion-btn-active-icon:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23FFF'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        --bs-accordion-active-color:#FFF;
        --bs-accordion-active-bg:#7E6D54;
        --bs-accordion-btn-focus-box-shadow: 0 0 0 0.25rem rgba(126, 109, 84, 0.25);   
    }      
    .btn-primary {
        --bs-btn-bg: #7E6D54;
        --bs-btn-border-color: #7E6D54;
        --bs-btn-hover-bg: #7C5D2E;
        --bs-btn-hover-border-color: #785721;
        --bs-btn-active-bg: #785721;
        --bs-btn-active-border-color: #785215;
        --bs-btn-disabled-bg: #7E6D54;
        --bs-btn-disabled-border-color: #7E6D54;
        --bs-btn-focus-shadow-rgb: 126, 109, 84;
    }
    .btn-outline-primary {
        --bs-btn-color: #7E6D54;
        --bs-btn-border-color: #7E6D54;
        --bs-btn-hover-bg: #7E6D54;
        --bs-btn-hover-border-color: #7E6D54;  
        --bs-btn-active-bg: #7E6D54;
        --bs-btn-active-border-color: #7E6D54;         
        --bs-btn-focus-shadow-rgb: 126, 109, 84;
    }
    :root{
        --bs-primary-text: #785721;
        --bs-font-sans-serif: Arial;
        /*        --bs-font-sans-serif: Arial,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue","Noto Sans","Liberation Sans",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";*/
    }
    .dropdown-item.active, .dropdown-item:active {
        background-color: #415860;
    }
    .form-select:focus {
        border-color: #785721;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(126, 109, 84,.25);
    } 
    .form-control:focus {
    color: var(--bs-body-color);
    background-color: var(--bs-form-control-bg);
    border-color: #785721;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(126, 109, 84,.25);
    }
    .nav {
        --bs-nav-link-color: #29435C;        
    }
    .nav-pills {    
        --bs-nav-pills-link-active-bg: #29435C;
    }
    .pestanaTop h4{
        color: #785721;
    }

  </style> 
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
      <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
      </symbol>
      <symbol id="fail-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M0 8A.8.8 90 0116 8 .8.8 90 010 8ZM12 5.6A.8.8 90 0010.4 4L8 6.4 5.6 4A.8.8 90 004 5.6L6.4 8 4 10.4A.8.8 90 005.6 12L8 9.6 10.4 12A.8.8 90 0012 10.4L9.6 8Z"/>
      </symbol> 
      <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
      </symbol>
      <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
      </symbol>
    </svg>
    <div aria-live="polite" aria-atomic="true" class="fixed-top" style="z-index: 1100;">
      <!-- Position it: -->
      <!-- - `.toast-container` for spacing between toasts -->
      <!-- - `.position-absolute`, `top-0` & `end-0` to position the toasts in the upper right corner -->
      <!-- - `.p-3` to prevent the toasts from sticking to the edge of the container  -->
      <div class="toast-container position-absolute top-0 end-0 p-3">

        <!-- Then put toasts within -->
      </div>
    </div>       
  <div id="app">
    <div>
        <img src="{{URL::asset('/LOGO-SUPERIOR-IZQUIERDO.png')}}"  id="upperNav" class="photo" width="36%">
    </div>    
    <nav class="navbar navbar-expand-md navbar-dark shadow-sm navbar-expand-lg " style="background-color: #415860;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">@yield('navBarTitle')</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{Auth::User()->name}}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
    						@yield('navBarListado')
    						@yield('navBarSalir')
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Success message -->
    <main class="">
        

        <div class="container-fluid">
            <div class="row">
                @if(View::hasSection('activeAU') || View::hasSection('activeCM') || View::hasSection('activeFX') ||
                View::hasSection('activeDE') || View::hasSection('activeCO') ||
                View::hasSection('activeND') || View::hasSection('activeCP') ||
                View::hasSection('activeLI') || View::hasSection('activeLS') || View::hasSection('activeDS') ||
                View::hasSection('activeDBE'))
                <div class="col-12">
                    @include("layouts.menu_lateral_izquierdo")
                </div>
                @endif
				@if(View::hasSection('activeAU') || View::hasSection('activeCM') || View::hasSection('activeFX') ||
				View::hasSection('activeDE') || View::hasSection('activeCO') ||
				View::hasSection('activeND') || View::hasSection('activeCP') || 
                View::hasSection('activeLI') || View::hasSection('activeLS') || View::hasSection('activeDS')||
                View::hasSection('activeDBE'))
				<div id="workArea" class="col">
					@include("layouts.area_trabajo")
				</div>
				@endif
				@if(View::hasSection('activeDE') || View::hasSection('activeCO') ||
				View::hasSection('activeND') || View::hasSection('activeCP'))
					@if(Auth::user()->TipoUsuario!=99)
						<div class="col-2">
							@include("layouts.resumen_causa_penal")
						</div>
					@endif
				@endif
				
            </div>
        </div>
    </main>   
</div>

	@yield('script')
  <script type="text/javascript">    
@if((Auth::user()->TipoUsuario==2 || Auth::user()->TipoUsuario==3) && 
    !(View::hasSection('activeLS') || View::hasSection('activeDBE') || View::hasSection('activeTDE') || View::hasSection('activeDDE')))
$(".btn.btn-primary").hide();
$(".btn.btn-outline-danger.btn-sm:contains('Eliminar')").hide();
$(".btn.btn-danger[title*='Eliminar']").hide();
$(".btn.btn-warning:contains('Solicitar revisión')").hide();
$(".btn.btn-outline-primary.btn-sm:contains('Acumular')").hide();
$(".btn.btn-outline-primary.btn-sm:contains('Editar')").hide();
$(".badge.rounded-pill.bg-info .btn-close").hide();


@endif

function showtoast(mensaje,tipo='light', delay='5500')
{   $("#toast"+tipo).remove();
    if ($("#toast"+tipo).length>0) {$("#toast"+tipo+" .toast-body").html(mensaje);$("#toast"+tipo).attr('data-bs-delay',delay);}
        else
        {
        var divtoast='<div class="toast align-items-center text-bg-'+tipo.split("_")[0]+' border-0 bg-opacity-75"'+
          ' id="toast'+tipo+'" role="alert" data-bs-delay="'+delay+'" aria-live="assertive" aria-atomic="true">'+
          '<div class="d-flex">'+
            '<div class="toast-body">'+mensaje+'</div>'+
            '<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>'+
          '</div>'+
        '</div>';
        $(".toast-container").append(divtoast);
        }
    var toastLive = document.getElementById('toast'+tipo);
    var toast = new bootstrap.Toast(toastLive);
    toast.show();
}
    $(document).ready(function() {
      $('form').keydown(function(event){
        if( (event.keyCode == 13) && event.target.tagName.toLowerCase() !== 'textarea' ){/////&& (validationFunction() == false) ) {
          event.preventDefault();
          return false;
        }
      });
    });
   document.querySelectorAll(".option_menu_causa_penal").forEach(item => 
        item.addEventListener("click", () =>{

            console.log(item.id)
			if (item.id === "panelsAgregarUsuariosHeading") {
				let tab = new bootstrap.Tab('#myTab button[data-bs-target="#agregar-usuario"]');
				//tab.show();
				location.replace("{{ route('dash',['q7']) }}");
			}
			if (item.id === "panelsCargaMasivaHeading") {
				let tab = new bootstrap.Tab('#myTab button[data-bs-target="#carga-masiva"]');
				// tab.show();
				location.replace("{{ route('dash',['dj']) }}");
			}            
            if (item.id === "panelsFormExcelHeading") {
                let tab = new bootstrap.Tab('#myTab button[data-bs-target="#form-excel"]');
                // tab.show();
                location.replace("{{ route('dash',['rs']) }}");
            } 
            if (item.id === "panelsDatosExpedienteHeading") {
                let tab = new bootstrap.Tab('#myTab button[data-bs-target="#datos-expediente"]');
                // tab.show();
				location.replace("{{ route('dash',['e3',Request::segment(3)]) }}");
            }
            if (item.id === "panelsConduccionHeading") {
                let tab = new bootstrap.Tab('#myTab button[data-bs-target="#conduccion"]');
                // tab.show();				
 				location.replace("{{ route('dash',['d9',Request::segment(3)]) }}");
            }			
            if (item.id === "panelsNoDelictivosHeading") {
                let tab = new bootstrap.Tab('#myTab button[data-bs-target="#no-delictivos"]');
                // tab.show();
				location.replace("{{ route('dash',['he',Request::segment(3)]) }}");
            }	
            if (item.id === "panelsCausasPenalesHeading") {
                let tab = new bootstrap.Tab('#myTab button[data-bs-target="#causas-penales"]');
                // tab.show();
				
				location.replace("{{ route('dash',['od0',Request::segment(3)]) }}");
            }
            if (item.id === "panelsListadoExpHeading") {
                if (item.getElementsByClassName('collapsed').length < 1) 
                {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#listado-exp"]');
                 tab.show();
                }
                else
                {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#notificaciones"]');
                 tab.show();
                }
            }
            if (item.id === "panelsListadoExpCCHeading") {
                if (item.getElementsByClassName('collapsed').length < 1) 
                {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#listado-expCC"]');
                 tab.show();
                }
                else
                {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#notificaciones"]');
                 tab.show();
                }
            }
            if (item.id === "panelsListadoExpNDHeading") {
                if (item.getElementsByClassName('collapsed').length < 1) 
                {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#listado-expND"]');
                 tab.show();
                }
                else
                {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#notificaciones"]');
                 tab.show();
                }
            }
            if (item.id === "panelsListadoSupHeading") {
                if (item.getElementsByClassName('collapsed').length < 1) 
                {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#listado-sup"]');
                 tab.show();
                }
                else
                {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#notificaciones"]');
                 tab.show();
                }
            }
            if (item.id === "panelsListadoSupCCHeading") {
                if (item.getElementsByClassName('collapsed').length < 1) 
                {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#listado-supCC"]');
                 tab.show();
                }
                else
                {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#notificaciones"]');
                 tab.show();
                }
            }
            if (item.id === "panelsListadoSupNDHeading") {
                if (item.getElementsByClassName('collapsed').length < 1) 
                {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#listado-supND"]');
                 tab.show();
                }
                else
                {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#notificaciones"]');
                 tab.show();
                }
            }

            if (item.id === "panelsDashboardEstadHeading") {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#dashboardestad"]');
                 tab.show();
            }
            if (item.id === "panelstabladatosEstadHeading") {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#tabladatosestad"]');
                 tab.show();
            }
            if (item.id === "panelsdescargaDatosHeading") {
                 let tab = new bootstrap.Tab('#myTab button[data-bs-target="#descargadatos"]');
                 tab.show();
            }
            // if (item.id === "panelsPersonasJudicializadasHeading") {
                // let tab = new bootstrap.Tab('#myTab button[data-bs-target="#personas-judicializadas"]');
                // tab.show();
            // }
            
        })
    )

    var typeOfNumber = { "Decimals": 0, "NoDecimals": 1 };
    function jsIsLetter(e) {
        var evt = (e) ? e : window.event;
        var key = (evt.keycode) ? evt.keycode : evt.which;
        if (key != null) {
            key = parseInt(key, 10);
            if (key < 65 || key > 90) {
                if (!((key == 8 || key == 9 || key == 13 || key == 45 || key == 46 || key == 32) || ((key > 16 && key < 21) || (key > 34 && key < 41)))) {
                    return false;
                }
            } else {
                if (evt.shiftkey) {
                    return false;
                }
            }
        }
        return true;
    }

    function jsIsNumeric(e) {
        var evt = (e) ? e : window.event;
        var key = (evt.keycode) ? evt.keycode : evt.which;
        if (key != null) {
            key = parseInt(key, 10);
            if ((key < 48 || key > 57) && (key < 96 || key > 105)) {
                if (!jsIsAllowedDecimalCharacter(key, typeOfNumber.NoDecimals)) {
                    return false;
                }
            } else {
                if (evt.shiftkey) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Valida el ingreso de caracteres decimales numéricos
     * @param {any} val Valor a validar
     * @param {any} step Indica el tipo de validación
     */
    function jsIsAllowedDecimalCharacter(val, step) {
        // Backspace, Tab, Enter, Insert, y Delete
        if (val == 8 || val == 9 || val == 13 || val == 45 || val == 46) {
            return true;
        }
        // Ctrl, Alt, CapsLock, Home, End, y flechas
        if ((val > 16 && val < 21) || (val > 34 && val < 41)) {
            return true;
        }
        // Evalua si se permiten caracteres de números decimales
        if (step == typeOfNumber.Decimals) {
            if (val == 190 || val == 110 || val == 188) {
                // El código de clave del punto(.) o coma(,) debe ser permitido
                return true;
            }
        }
        return false;
    }
  </script>

@else
 <script type="text/javascript">  
  location.replace("{{ route('logout') }}");
 </script>
@endauth
</body>
</html>

