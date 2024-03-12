<div class="row causasCarpeta">
 <!--   <div class="mb-3">
    <label for="expediente_nuc" class="form-label">N.U.C:</label>
    <input type="text" class="form-control" name="expediente_nuc" id="expediente_nuc"
 placeholder="92778">
  </div>   -->
	<div class="mb-3 col-sm-12 col-md-6">
	  <label for="causa_H_aplicacion_de_medida_de_restriccion" class="form-label">Aplicación de medida de restricción:</label>
	  <select class="form-select" name="causa_H_aplicacion_de_medida_de_restriccion" id="causa_H_aplicacion_de_medida_de_restriccion">
		<option selected>Seleccione una opción</option>
        @foreach ($SiNoNoA as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach 
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6">
	  <label for="causa_H_tipo_de_medida" class="form-label">Tipo de medida de restricción:</label>
	  <select class="form-select" name="causa_H_tipo_de_medida" id="causa_H_tipo_de_medida">
		<option selected>Seleccione una opción</option>
        @foreach ($TMRestriccion as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach 
	 </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_temporalidad_de_la_medida" class="form-label">Temporalidad de la medida de restricción:</label>
		<input type="text" class="form-control" name="causa_H_temporalidad_de_la_medida" id="causa_H_temporalidad_de_la_medida" placeholder="">
	</div>
	<div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_tipos_de_actos_sin_control" class="form-label">Tipos de actos sin control judicial:</label>
      <select class="form-select" name="causa_H_tipos_de_actos_sin_control" id="causa_H_tipos_de_actos_sin_control">
        <option selected>Seleccione una opción</option>
        @foreach ($actosSin as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach 
     </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_audiencia_de_garantias" class="form-label">Audiencia de garantías:</label>
		<input type="text" class="form-control" name="causa_H_audiencia_de_garantias" id="causa_H_audiencia_de_garantias" placeholder="">
	</div>
	<div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_promovida_por" class="form-label">Audiencia promovida por:</label>
      <select class="form-select" name="causa_H_promovida_por" id="causa_H_promovida_por">
        <option selected>Seleccione una opción</option>
        @foreach ($audineciaPx as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach 
     </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_resultado_audiencia_de_garantias" class="form-label">Resultado de la audiencia:</label>
		<input type="text" class="form-control" name="causa_H_resultado_audiencia_de_garantias" id="causa_H_resultado_audiencia_de_garantias" placeholder="">
	</div>
	<div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_fecha_inicio_atencion" class="form-label">Fecha de inicio de la atención:</label>
		<input type="date" class="form-control" name="causa_H_fecha_inicio_atencion" id="causa_H_fecha_inicio_atencion" value="">
	</div> 
	<div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_fecha_conclusion_atencion" class="form-label">Fecha de conclusión de la atención:</label>
		<input type="date" class="form-control" name="causa_H_fecha_conclusion_atencion" id="causa_H_fecha_conclusion_atencion" value="">
	</div> 
	<div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_tipo_de_atencion" class="form-label">Tipo de atencion:</label>
      <select class="form-select" name="causa_H_tipo_de_atencion" id="causa_H_tipo_de_atencion">
        <option selected>Seleccione una opción</option>
        @foreach ($tipoAtencion as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach 
     </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_sentido" class="form-label">Sentido de la conclusión de la atención:</label>
      <select class="form-select" name="causa_H_sentido" id="causa_H_sentido">
        <option selected>Seleccione una opción</option>
        @foreach ($sentidoConc as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach 
     </select>
	</div>	
	<div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_fecha_determinacion" class="form-label">Fecha de la determinación:</label>
		<input type="date" class="form-control" name="causa_H_fecha_determinacion" id="causa_H_fecha_determinacion" value="">		
	</div> 
	<div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_sentido_determinacion" class="form-label">Sentido de la determinación:</label>
      <select class="form-select" name="causa_H_sentido_determinacion" id="causa_H_sentido_determinacion">
        <option selected>Seleccione una opción</option>
        @foreach ($sentidoDete as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach 
     </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_fecha_denuncia" class="form-label">Fecha de presentación de la denuncia o querella:</label>
		<input type="date" class="form-control" name="causa_H_fecha_denuncia" id="causa_H_fecha_denuncia" value="">
	</div> 	
	<div class="mb-3 col-sm-12 col-md-6">
	  <label for="causa_H_reactivacion" class="form-label">Reactivación de carpeta de investigación:</label>
      <select class="form-select" name="causa_H_reactivacion" id="causa_H_reactivacion">
		<option selected>Seleccione una opción</option>
        @foreach ($SiNoNoI as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach 
     </select>
	</div>	
	<div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_normativa" class="form-label">Señalamiento normativo:</label>
		<input type="text" class="form-control" name="causa_H_normativa" id="causa_H_normativa" placeholder="">
	</div>
	<div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_aseguramiento" class="form-label">Aseguramientos:</label>
      <select class="form-select" name="causa_H_aseguramiento" id="causa_H_aseguramiento">
        <option selected>Seleccione una opción</option>
        @foreach ($SiNoNoI as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach 

     </select>
	</div>
	<div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_tipo_de_bien" class="form-label">Tipo de bien asegurado:</label>
		<input type="text" class="form-control" name="causa_H_tipo_de_bien" id="causa_H_tipo_de_bien"
 placeholder="">
	</div>
	<div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_oportunidad" class="form-label">Tipo de criterios de oportunidad:</label>
      <select class="form-select" name="causa_H_oportunidad" id="causa_H_oportunidad">
        <option selected>Seleccione una opción</option>
        @foreach ($tipoCriterio as $item)      
          <option value="{{ $item->id }}">{{$item->Valor}}</option>      
        @endforeach 
     </select>
	</div>
	<div class="mb-3 col-12">
		<label for="causa_H_observaciones" class="form-label">Observaciones:</label>
		<textarea type="textarea" class="form-control" rows="3" name="causa_H_observaciones" id="causa_H_observaciones" placeholder=""></textarea>
			@if($errors->has('causa_H_observaciones'))
			 <span class="text-danger">{{ $errors->first('causa_H_observaciones') }}</span>
			@endif
	</div>	
</div>
<script type="text/javascript">
$("#causa_H_temporalidad_de_la_medida").mask("0000");
</script>
