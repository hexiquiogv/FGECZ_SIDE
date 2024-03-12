
<div class="p-3 bg-body rounded shadow">
    <h6 class="border-bottom w-100 pb-2 mb-3 text-center">No. de expediente</h6>
    <h5 class="text-primary-emphasis text-center">{{ str_replace("/"," / ",$resumen['NO_EXPEDIENTE'] ?? "-") }}</h5>

    <div class="d-flex text-muted pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
        <strong class="d-block text-gray-dark">Delegación:</strong>
        {{ $resumen['DELEGACION'] ?? "-" }}
      </p>
    </div>
    <div class="d-flex text-muted pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
        <strong class="d-block text-gray-dark">Unidad de investigación:</strong>
        {{str_replace("_"," ",($resumen['UNIDAD'] ?? "-")) }}
      </p>
    </div>
    <div class="d-flex text-muted pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
        <strong class="d-block text-gray-dark">Agente del M.P. responsable:</strong>
        {{str_replace("_"," ",($resumen['RESPONSABLE'] ?? "-"))}}
      </p>
    </div>      
     <div class="d-flex text-muted pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
        <strong class="d-block text-gray-dark">Semana estadística:</strong>
        {{Carbon\Carbon::now()->startOfWeek()->format('Y-m-d')}} al {{Carbon\Carbon::now()->endOfWeek()->format('Y-m-d')}}
      </p>
    </div>
    <div class="d-flex text-muted pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
        <strong class="d-block text-gray-dark">N.U.C.:</strong>
        {{str_replace("/"," / ",$resumen['NUC'] ?? "-")}}
      </p>
    </div>
    <div class="d-flex text-muted pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
        <strong class="d-block text-gray-dark">Fecha de inicio de la carpeta(AAAA-MM-DD):</strong>
        {{$resumen['FECHA_INICIO_CARPETA'] ?? "-"}}
      </p>
    </div>
    <div class="d-flex text-muted pt-3">

      @if($resumen['validacion']??0 > 0)

     <div class="alert alert-success alert-dismissible fade show" id="" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#check-circle-fill"/></svg>
      Validado
     </div>
      @elseif($resumen['correccion']??0 > 0)

        <form method='post' name="frmRevision" id="frmRevision" action="{{route('revision')}}" enctype="multipart/form-data">
          @csrf 
          <input type="hidden" name="idExpCorr" value="{{$resumen['idExpCorr']}}">
          <input type="hidden" name="tablaCorr" value="{{$resumen['tablaCorr']}}">
          <button type="button" class="btn btn-warning" onclick="javascript:SolicitarRevision()">
            Solicitar revisión
          </button>
        </form>
      
      @endif
    </div>
</div>
  <script>
    function SolicitarRevision()
    {
      $("#frmRevision").submit();
    }
  </script>