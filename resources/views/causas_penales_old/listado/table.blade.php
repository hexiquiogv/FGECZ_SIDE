<table class="table table-striped table-hover table-responsive caption-top">
    <caption>Listado de víctimas</caption>    
    <thead class="table-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">NUC</th>      
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
   @foreach($listados['causasZero'] as $causa)
    <tr>      
      <th scope="row">{{$causa->id}}</th>
      <td>{{$causa->NUC}}</td>
      <td>
        <a class="btn btn-outline-primary btn-sm" href="#" onclick="javascript:addCausa('{{$causa->id}}')" role="button">Ver</a>
        <a class="btn btn-outline-danger btn-sm" href="#" role="button">Eliminar</a>
      </td>
    </tr>
   @endforeach
  </tbody>
</table>