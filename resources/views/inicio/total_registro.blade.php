<div class="p-3 bg-body rounded shadow">
  <h4 class="border-bottom w-100 pb-2 mb-4 text-center">Total de registros</h4>
  <h3 class="text-primary-emphasis text-center">{{ $RegistrosTT ?? "0" }}</h3>

  <h6 class="border-bottom w-100 pb-2 mt-5 text-center">Carpetas de investigación</h6>
  <h5 class="text-primary-emphasis text-center">{{ $RegistrosDE ?? "0" }}</h5>
  <h6 class="border-bottom w-100 pb-2 mt-5 text-center">Expedientes Conducción</h6>
  <h5 class="text-primary-emphasis text-center">{{ $RegistrosCC ?? "0" }}</h5>
  <h6 class="border-bottom w-100 pb-2 mt-5 text-center">Expedientes de hechos no delictivos</h6>
  <h5 class="text-primary-emphasis text-center">{{ $RegistrosND ?? "0" }}</h5>
  <h6 class="border-bottom w-100 pb-2 mt-5 text-center">Expedientes Validados</h6>
  <h5 class="text-primary-emphasis text-center">{{ $RegistrosTV ?? "0" }}</h5>


<!--   <div class="d-flex text-muted pt-3 text-center">
    <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
      <strong class="d-block text-gray-dark">Carpeta de investigación</strong>
      {{ $RegistrosDE ?? "0" }}
  </div>
  <div class="d-flex text-muted pt-3 text-center">
    <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
      <strong class="d-block text-gray-dark">Expedientes Conducción</strong>
      {{ $RegistrosCC ?? "0" }}
    </p>
  </div>  
  <div class="d-flex text-muted pt-3 text-center">
    <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
      <strong class="d-block text-gray-dark">Expedientes de hechos no delictivos</strong>
      {{ $RegistrosND ?? "0" }}
    </p>
  </div>  -->
</div>