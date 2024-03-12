<div class="col">
  @if(isset($SupExpV) && count($SupExpV)>0)
   <div class="alert alert-info alert-dismissible fade show" id="" role="alert">	
    	<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#check-circle-fill"/></svg>
    	<b>Expedientes por validar</b>
      <p>Semana estadística: {{Carbon\Carbon::now()->startOfWeek()->format('Y-m-d')}} al {{Carbon\Carbon::now()->endOfWeek()->format('Y-m-d')}}</p>
      <p>{{$SumaExpV}} expedientes históricos</p>      
  	 <hr>
      <p>{{count($SupExpV)}} registros</p>      
      <table class="table table-striped table-hover table-responsive caption-top" id="tbVitimasCP">
        <thead>
          <tr>
            <th scope="col">NUC</th>
            <th scope="col">Agente del M.P. responsable</th>
            <th scope="col">Unidad</th>
            <th scope="col">Delegación</th>
            <th scope="col">No. Expediente</th>
            <th scope="col">tipo de expediente</th>
          </tr>
        </thead>
        <tbody>
         @foreach($SupExpV as $item)

           <tr onclick="javascript:parent.location.href='{{ route("detalle.super",[$item->carpeta,$item->idExpediente]) }}'">
            <td scope="col">{{$item->NUC}}</td>
            <td scope="col">{{$item->MP_NAME}}</td>
            <td scope="col">{{$item->MP_UNIDAD}}</td>
            <td scope="col">{{$item->MP_DELEGACION}}</td>
            <td scope="col">{{$item->NO_EXPEDIENTE}}</td>
            <td>{{$item->tabla}}</td>
          </tr>

         @endforeach
        </tbody>
      </table>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>	
  @endif
  @if(isset($ExpV) && count($ExpV)>0)
   <div class="alert alert-success alert-dismissible fade show" id="" role="alert">  
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#check-circle-fill"/></svg>
      <b>Expedientes validados</b>
    <hr>
      <table class="table table-striped table-hover table-responsive caption-top" id="tbVitimasCP">
        <thead>
          <tr>
            <th scope="col">NUC</th>
            <th scope="col">No. Expediente</th>
            <th scope="col">tipo de expediente</th>
          </tr>
        </thead>
        <tbody>
         @foreach($ExpV as $item)

           <tr onclick="javascript:parent.location.href='{{ route("dash",[$item->carpeta,$item->idExpediente]) }}'">
            <td scope="col">{{$item->NUC}}</td>
            <td scope="col">{{$item->NO_EXPEDIENTE}}</td>
            <td>{{$item->tabla}}</td>
          </tr>

         @endforeach
        </tbody>
      </table>      
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div> 
  @endif  
  @if(isset($SupExpP) && count($SupExpP)>0)
   <div class="alert alert-danger alert-dismissible fade show" id="" role="alert"> 
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#check-circle-fill"/></svg>
      <b>Expedientes por vencer el plazo de investigación</b>
    <hr>
      <table class="table table-striped table-hover table-responsive caption-top" id="tbVitimasCP">
        <thead>
          <tr>
            <th scope="col">NUC</th>
            <th scope="col">Agente del M.P. responsable</th>
            <th scope="col">Unidad</th>
            <th scope="col">Delegación</th>            
            <th scope="col">No. Expediente</th>
            <th scope="col">días para el vencimiento</th>
          </tr>
        </thead>
        <tbody>
         @foreach($SupExpP as $item)
          <tr onclick="javascript:parent.location.href='{{ route("detalle.super",[$item->carpeta,$item->idExpediente]) }}'">
            <td scope="col">{{$item->NUC}}</td>
            <td scope="col">{{$item->MP_NAME}}</td>
            <td scope="col">{{$item->MP_UNIDAD}}</td>
            <td scope="col">{{$item->MP_DELEGACION}}</td>
            <td scope="col">{{$item->NO_EXPEDIENTE}}</td>
            <td>{{$item->dias}} días</td>
          </tr>                        
         @endforeach
        </tbody>
      </table>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div> 
  @endif
  @if(isset($SupExpC) && count($SupExpC)>0)
   <div class="alert alert-warning alert-dismissible fade show" id="" role="alert"> 
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
      <b>Expedientes en espera de corrección</b>
    <hr>
      <table class="table table-striped table-hover table-responsive caption-top" id="tbVitimasCP">
        <thead>
          <tr>
            <th scope="col">NUC</th>
            <th scope="col">Agente del M.P. responsable</th>
            <th scope="col">Unidad</th>
            <th scope="col">Delegación</th>
            <th scope="col">No. Expediente</th>
            <th scope="col">tipo de expediente</th>
          </tr>
        </thead>
        <tbody>
         @foreach($SupExpC as $item)
          <tr onclick="javascript:parent.location.href='{{ route("detalle.super",[$item->carpeta,$item->idExpediente]) }}'">
            <td scope="col">{{$item->NUC}}</td>
            <td scope="col">{{$item->MP_NAME}}</td>
            <td scope="col">{{$item->MP_UNIDAD}}</td>
            <td scope="col">{{$item->MP_DELEGACION}}</td>
            <td scope="col">{{$item->NO_EXPEDIENTE}}</td>
            <td>{{$item->tabla}}</td>
          </tr>                        
         @endforeach
        </tbody>
      </table>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div> 
  @endif
  @if(isset($ExpC) && count($ExpC)>0)
   <div class="alert alert-warning alert-dismissible fade show" id="" role="alert"> 
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
      <b>Expedientes en espera de corrección</b>
    <hr>
      <table class="table table-striped table-hover table-responsive caption-top" id="tbVitimasCP">
        <thead>
          <tr>
            <th scope="col">NUC</th>
            <th scope="col">No. Expediente</th>
            <th scope="col">Observaciones</th>
            <th scope="col">tipo de expediente</th>
          </tr>
        </thead>
        <tbody>
         @foreach($ExpC as $item)
          <tr onclick="javascript:parent.location.href='{{ route("dash",[$item->carpeta,$item->idExpediente]) }}'">
            <td scope="col">{{$item->NUC}}</td>
            <td scope="col">{{$item->NO_EXPEDIENTE}}</td>
            <td>{{$item->Observaciones}}</td>
            <td>{{$item->tabla}}</td>
          </tr>                        
         @endforeach
        </tbody>
      </table>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div> 
  @endif  
  @foreach($arrAlert??[] as $alert)
    <div class="alert alert-{{$alert['tipo']??'info'}} alert-dismissible fade show" id="" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#{{$alert['icon']??''}}"/></svg>
      {!!$alert['mensaje']??''!!}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>    
  @endforeach

  
  <!--  <div class="alert alert-secondary alert-dismissible fade show" id="" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
    Notificación de alerta
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>

   <div class="alert alert-primary alert-dismissible fade show" id="" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
    Notificación de alerta
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>

   <div class="alert alert-danger alert-dismissible fade show" id="" role="alert">
  	<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#fail-circle-fill"/></svg>
  	Notificación de alerta
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div> 

   <div class="alert alert-success alert-dismissible fade show" id="" role="alert">
  	<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#check-circle-fill"/></svg>
  	Notificación de alerta
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>

   <div class="alert alert-info alert-dismissible fade show" id="" role="alert">
  	<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  	Notificación de alerta
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>

   <div class="alert alert-warning alert-dismissible fade show" id="" role="alert">
  	<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  	Notificación de alerta
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div> 	
  -->
</div>