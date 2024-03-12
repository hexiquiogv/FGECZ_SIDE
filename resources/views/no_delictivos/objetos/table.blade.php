<table class="table table-striped table-hover table-responsive caption-top">
    <caption>Listado de objetos</caption>    
    <thead class="table-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Objeto(s)</th>
      <th scope="col">Narcótico(s)</th>
      <th scope="col">Vehículo</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
   @foreach($listados['objetos'] as $objeto)    
    <tr>
      <th scope="row">{{$objeto->id}}</th>
      <td>{{rtrim(strtoupper($objeto->v1.' / '.$objeto->v2.' / '.$objeto->v3),'/ ')}}</td>
      <td>{{rtrim(strtoupper($objeto->vn1.' / '.$objeto->vn2.' / '.$objeto->vn3),'/ ')}}</td>
      <td>{{$objeto->MARCA_NO_DELICTIVOS.' '.$objeto->MODELO_NO_DELICTIVOS.' '.$objeto->COLOR_NO_DELICTIVOS}}</td>
      <td>
        <a class="btn btn-outline-primary btn-sm" href="#" onclick="javascript:fnObjeto('{{$objeto->id}}')" role="button">Ver</a>
        <a class="btn btn-outline-danger btn-sm" href="#" onclick="javascript:eliminarReload({{$objeto->id}},'ndo')" role="button">Eliminar</a>
      </td>
    </tr>
   @endforeach
  </tbody>
</table>