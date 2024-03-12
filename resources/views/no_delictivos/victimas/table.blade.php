<table class="table table-striped table-hover table-responsive caption-top">
    <caption>Listado de víctimas</caption>    
    <thead class="table-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Víctima</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>    
   @foreach($listados['victimas'] as $victima)
    <tr>
      <th scope="row">{{$victima->id}}</th>
      @if($victima->TIPO_VICTIMA_NO_DELICTIVO==2)
        <td>PERSONA MORAL</td>
      @elseif($victima->TIPO_VICTIMA_NO_DELICTIVO==3)
        <td>LA SOCIEDAD</td>
      @elseif($victima->TIPO_VICTIMA_NO_DELICTIVO==5)
        <td>SIN IDENTIFICAR/DESCONOCIDO</td>
      @elseif($victima->TIPO_VICTIMA_NO_DELICTIVO==7)
        <td>LA SALUD</td>
      @else
        <td>{{strtoupper($victima->NOMBRE_VICTIMA.' '.$victima->PRIMER_APELLIDO.' '.$victima->SEGUNDO_APELLIDO_VICTIMAS_NO_DELICTIVO)}}</td>
      @endif       
      
      <td>
        <a class="btn btn-outline-primary btn-sm" href="#" onclick="javascript:fnVictima('{{$victima->id}}')" role="button">Ver</a>
        <a class="btn btn-outline-danger btn-sm" href="#" onclick="javascript:eliminarReload({{$victima->id}},'ndv')" role="button">Eliminar</a>
      </td>
    </tr>
   @endforeach  </tbody>
</table>