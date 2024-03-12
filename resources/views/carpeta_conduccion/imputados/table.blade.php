<table class="table table-striped table-hover table-responsive caption-top">
    <caption>Listado de imputados</caption>    
    <thead class="table-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Imputado</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
   @foreach($listados['imputados'] as $imputado)
    <tr>
      <th scope="row">{{$imputado->id}}</th>
      @if($imputado->TIPO_IMPUTADO_CONDUCCION==2)
        <td>{{strtoupper($imputado->RAZON_SOCIAL)}}</td>
      @elseif($imputado->TIPO_IMPUTADO_CONDUCCION==3)
        <td>LA SOCIEDAD</td>
      @elseif($imputado->TIPO_IMPUTADO_CONDUCCION==5)
        <td>SIN IDENTIFICAR/DESCONOCIDO</td>
      @elseif($imputado->TIPO_IMPUTADO_CONDUCCION==7)
        <td>LA SALUD</td>
      @else
        <td>{{strtoupper($imputado->NOMBRE_IMPUTADO.' '.$imputado->PRIMER_APELLIDO.' '.$imputado->SEGUNDO_APELLIDO_IMPUTADOS_CONDUCCION)}}</td>
      @endif      
      
      <td>
        <a class="btn btn-outline-primary btn-sm" href="#" onclick="javascript:fnImputado('{{$imputado->id}}')" role="button">Ver</a>
        <a class="btn btn-outline-danger btn-sm" href="#" onclick="javascript:eliminarReload({{$imputado->id}},'cci')" role="button">Eliminar</a>
      </td>
    </tr>
   @endforeach
  </tbody>
</table>