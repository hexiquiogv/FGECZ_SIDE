@extends('layouts.dashboard')

@section('navBarTitle','Datos Expediente')
@section('navBarListado')
  @if(Auth::User()->TipoUsuario==1)
    <a class="dropdown-item" href='{{ route("listado") }}'>Inicio</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('dash',['rs']) }}">Carga de Formulario Excel</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('dash',['e3',0]) }}">Registro de causa penal de años anteriores</a>
    <div class="dropdown-divider"></div>
  @else
    <a class="dropdown-item" href='{{ route("listado.super") }}'>Inicio</a>
    <div class="dropdown-divider"></div>
    @if(Auth::User()->TipoUsuario!=2)
      <a class="dropdown-item" href='{{ route("estadistica.super") }}'>Apartado estadístico</a>
      <div class="dropdown-divider"></div>   
    @endif
  @endif
 @stop
@section('navBarSalir') 
	<a class="dropdown-item" href="{{ route('logout') }}">Cerrar sesión</a>
 @stop

@section('collapsedCP','')
@section('activeCP','active')
@section('indexCP')
  @if($mostrarCP==0)
       <div class="alert alert-warning" id="">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        El expediente debe contar con un ejercicio de la acción penal como determinación para iniciar una Causa Penal
       </div>     
  @else
    @if($Ctrl=='od0')
  	@include("causas_penales.listado.index")
    @else
      @include("causas_penales.index")
    @endif
  @endif
@stop
@section('script')        
  <script>
    
	// function cargaCausasCarpeta()
	// {
	//  $(".causasCarpeta select").html(""); 

    //  var params = new Object();    
    //  params._token = '{{csrf_token()}}';
    //  params.seccion = 1;
    //  params = JSON.stringify(params);
    //  $.ajax({      
    //     url: "{{Route('Causas')}}",
    //     type: "POST",
    //     data: params,
    //     contentType: "application/json; charset=utf-8",
    //     dataType: 'json',
    //     async: false,
    //     success: function (result) {
    //         $('#causa_H_aplicacion_de_medida_de_restriccion').html('<option selected>Seleccione una opción</option>');
    //         $.each(result.respuestas.SiNoNoA, function (key, value) {
    //             $("#causa_H_aplicacion_de_medida_de_restriccion").append('<option value="' + value
    //                 .id + '">' + value.Valor + '</option>');
    //         });
    //         $('#causa_H_tipo_de_medida').html('<option selected>Seleccione una opción</option>');
    //         $.each(result.respuestas.TMRestriccion, function (key, value) {
    //             $("#causa_H_tipo_de_medida").append('<option value="' + value
    //                 .id + '">' + value.Valor + '</option>');
    //         });
    //         $('#causa_H_tipos_de_actos_sin_control').html('<option selected>Seleccione una opción</option>');
    //         $.each(result.respuestas.actosSin, function (key, value) {
    //             $("#causa_H_tipos_de_actos_sin_control").append('<option value="' + value
    //                 .id + '">' + value.Valor + '</option>');
    //         });
    //         $('#causa_H_promovida_por').html('<option selected>Seleccione una opción</option>');
    //         $.each(result.respuestas.audineciaPx, function (key, value) {
    //             $("#causa_H_promovida_por").append('<option value="' + value
    //                 .id + '">' + value.Valor + '</option>');
    //         });
    //         $('#causa_H_tipo_de_atencion').html('<option selected>Seleccione una opción</option>');
    //         $.each(result.respuestas.tipoAtencion, function (key, value) {
    //             $("#causa_H_tipo_de_atencion").append('<option value="' + value
    //                 .id + '">' + value.Valor + '</option>');
    //         });
    //         $('#causa_H_sentido').html('<option selected>Seleccione una opción</option>');
    //         $.each(result.respuestas.sentidoConc, function (key, value) {
    //             $("#causa_H_sentido").append('<option value="' + value
    //                 .id + '">' + value.Valor + '</option>');
    //         });
    //         $('#causa_H_sentido_determinacion').html('<option selected>Seleccione una opción</option>');
    //         $.each(result.respuestas.sentidoDete, function (key, value) {
    //             $("#causa_H_sentido_determinacion").append('<option value="' + value
    //                 .id + '">' + value.Valor + '</option>');
    //         });
    //         $('#causa_H_reactivacion').html('<option selected>Seleccione una opción</option>');
    //         $.each(result.respuestas.SiNoNoI, function (key, value) {
    //             $("#causa_H_reactivacion").append('<option value="' + value
    //                 .id + '">' + value.Valor + '</option>');
    //         });
    //         $('#causa_H_aseguramiento').html('<option selected>Seleccione una opción</option>');
    //         $.each(result.respuestas.SiNoNoI, function (key, value) {
    //             $("#causa_H_aseguramiento").append('<option value="' + value
    //                 .id + '">' + value.Valor + '</option>');
    //         });
    //         $('#causa_H_oportunidad').html('<option selected>Seleccione una opción</option>');
    //         $.each(result.respuestas.tipoCriterio, function (key, value) {
    //             $("#causa_H_oportunidad").append('<option value="' + value
    //                 .id + '">' + value.Valor + '</option>');
    //         });			            
    //       },
    //     error: function (XMLHttpRequest, textStatus, errorThrown) {
    //       alert(textStatus + ": " + XMLHttpRequest.responseText);
    //       }
    //   });
	// }
    // const triggerEl = document.querySelector('#myTab button[data-bs-target="#profile"]')

    // var tab = new bootstrap.Tab('#myTab button[data-bs-target="#profile"]');
    // tab.show();
    // bootstrap.Tab.getInstance(triggerEl).show() // Select tab by name


    // document.getElementById('myProfile').onclick = () => {

    // }
  </script>
 @stop