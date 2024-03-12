<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIDE | FGE Coahuila</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset('/logo-fge.png')}}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<style type="text/css">
/* fill='%237E6D54' aquí el %23 es el # y lo demás es el código del color */
    .accordion {
        /*    --bs-accordion-btn-icon:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%237E6D54'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");*/
            --bs-accordion-btn-active-icon:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23FFF'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        --bs-accordion-active-color:#FFF;
        --bs-accordion-active-bg:#7E6D54;
        --bs-accordion-btn-focus-box-shadow: 0 0 0 0.25rem rgba(126, 109, 84, 0.25);   
    }   
    
    .btn-primary
    {
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
    .btn-outline-primary     
    {
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
</style>
    <div>
        <img src="{{URL::asset('/LOGO-SUPERIOR-IZQUIERDO.png')}}"  id="upperNav" class="photo" width="35%">
    </div>
    <nav class="navbar navbar-dark navbar-expand-lg mb-5" style="background-color: #415860;">
        <div class="container">
            <a class="navbar-brand mr-auto" href="#">Menú Principal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" style="justify-content: flex-end;" id="navbarNav">
                    
                <ul class="navbar-nav">
                    @guest

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
<!--                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('registration') }}">Register</a>
                    </li> -->

                    @else

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Salir</a>
                    </li>

                    @endguest
                </ul>
                
            </div>
        </div>
    </nav>
    <div class="container mt-5">

        @yield('content')
        
    </div>
    
</body>
</html>