<table class="table table-striped table-hover table-responsive caption-top">
    <caption>Listado de causas penales</caption>    
    <thead class="table-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Causa Penal</th>  
      <th scope="col">NUC</th>
      <th scope="col">Imputados</th>
      <th scope="col">Delitos</th>
      <th scope="col">Vícitmas</th>    
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
   @foreach($listados['causas'] as $causa)
    <tr>      
      <th scope="row">{{$causa->id}}</th>
      <td>{{$causa->CAUSA_PENAL_ID}}</td>
      <td>{{$causa->NUC}}</td>
      <td>{{$causa->imputados}}</td>
      <td>{{$causa->delitos}}</td>
      <td>{{$causa->victimas}}</td>
      <td>
        <a class="btn btn-outline-primary btn-sm" href="#" onclick="javascript:addCausa('{{$causa->id}}')" role="button">Ver</a>
         <!-- <a class="btn btn-outline-danger btn-sm" href="#" onclick="javascript:eliminarReload({{$causa->id}},'cp')" role="button">Eliminar</a>  -->
        @if($causa->Vigencia)
        <span class="badge bg-danger" title="Por vencer">!</span>
        @endif
      </td>
    </tr>
   @endforeach
  </tbody>
</table>