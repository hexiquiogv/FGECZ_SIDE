<table class="table table-striped table-hover table-responsive caption-top">
    <caption>Listado de delitos</caption>    
    <thead class="table-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Delito</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
   @foreach($listados['hechos'] as $delito)        
    <tr>
      <th scope="row">{{$delito->id}}</th>
      <td>{{strtoupper($delito->Valor)}}</td>
      <td>
        <a class="btn btn-outline-primary btn-sm" href="#" onclick="javascript:fnDelito('{{$delito->id}}')" role="button">Ver</a>
        <a class="btn btn-outline-danger btn-sm" href="#" onclick="javascript:eliminarReload({{$delito->id}},'ded')" role="button">Eliminar</a>
      </td>
    </tr>
   @endforeach    
  </tbody>
</table>