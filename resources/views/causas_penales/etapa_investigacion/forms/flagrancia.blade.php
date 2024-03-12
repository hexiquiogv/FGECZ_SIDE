{{--<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_forma_proceso" class="form-label">Forma en la que lleva su proceso:</label>
  <select class="form-select noValidate" name="causa_H_forma_proceso" id="causa_H_forma_proceso">
    <option value="-1">Seleccione una opción</option>
    @foreach ($formaProc as $item)      
      <option value="{{ $item->id }}" {{isset($imputado->FORMA_PROCESO) ? $imputado->FORMA_PROCESO==$item->id ?'selected':'':''}}>{{$item->Valor}}</option>      
    @endforeach              
 </select>
</div>--}}
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_fecha_detencion" class="form-label">Fecha de detención:</label>
  <input type="date" class="form-control" name="causa_H_fecha_detencion" id="causa_H_fecha_detencion" 
  value="{{$imputado->FECHA_DETENCION??''}}">
</div>
<div class="mb-3 col-sm-12 col-md-6 col-lg-4">
  <label for="causa_H_detencion_legal" class="form-label">Tipo de detención:</label>
  <input type="text" class="form-control" name="causa_H_detencion_legal" id="causa_H_detencion_legal" 
  value="{{$imputado->DETENCION_LEGAL??''}}">
</div>
<script type="text/javascript">

</script>