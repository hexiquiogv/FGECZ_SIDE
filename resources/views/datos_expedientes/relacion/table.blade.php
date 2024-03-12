<table class="table table-striped table-hover table-responsive caption-top" id="relDelImpVic">
    <caption>Listado de delitos-imputados-víctimas</caption>    
    <thead class="table-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Delito</th>
      <th scope="col">Imputado(s)</th>
      <th scope="col">Víctima(s)</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
   @foreach($listados['relaciones'] as $relacion)
    <tr>
      <th scope="row">{{$relacion->id}}</th>
      <td>{{$relacion->delito}}</td>
      <td>{{$relacion->imputados}}</td>      
      <td>{{$relacion->victimas}}</td>
      <td>
        <!-- <a class="btn btn-outline-primary btn-sm" href="#" onclick="javascript:fnRelacion('{{$relacion->id}}')" role="button">Ver</a> -->
        <a class="btn btn-outline-danger btn-sm" href="#" onclick="javascript:eliminarReload({{$relacion->id}},'der')" role="button">Eliminar</a>
      </td>
    </tr>
   @endforeach    
  </tbody>
</table>