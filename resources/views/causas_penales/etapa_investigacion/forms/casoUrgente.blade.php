<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_caso_urgente_fecha_libramiento" class="form-label">Fecha de libramiento:</label>
  <input type="date" class="form-control" name="causa_H_caso_urgente_fecha_libramiento" id="causa_H_caso_urgente_fecha_libramiento" 
  value="{{$imputado->CASO_URGENTE_FECHA_LIBRAMIENTO??''}}">
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_caso_urgente_estatus" class="form-label">Tipo de mandamiento:</label>
    <select class="form-select" name="causa_H_caso_urgente_estatus" id="causa_H_caso_urgente_estatus">
      <option value="-1">Seleccione una opción</option>
      @foreach ($EstatusCU as $item)      
        <option value="{{ $item->id }}" 
          {{isset($imputado->CASO_URGENTE_ESTATUS) ? $imputado->CASO_URGENTE_ESTATUS==$item->id ?'selected':'':''}}>
          {{$item->Valor}}</option>      
      @endforeach 
   </select>
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_caso_urgente_fecha_cumplimiento" class="form-label">Fecha de cumplimiento:</label>
  <input type="date" class="form-control" name="causa_H_caso_urgente_fecha_cumplimiento" id="causa_H_caso_urgente_fecha_cumplimiento" 
  value="{{$imputado->CASO_URGENTE_FECHA_CUMPLIMIENTO??''}}">
</div>

<script type="text/javascript">

</script>