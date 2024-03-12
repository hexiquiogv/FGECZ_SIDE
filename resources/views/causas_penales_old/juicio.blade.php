<div class="row causasJuicio">
  <div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_procedimiento_abreviado" class="form-label">Fecha de procedimiento abreviado:</label>
		<input type="date" class="form-control" name="causa_H_procedimiento_abreviado" id="causa_H_procedimiento_abreviado"
 value="">
  	</div>
  <div class="mb-3 col-sm-12 col-md-6">
	<label for="causa_H_pena_condenatoria_en_abreviado" class="form-label">Pena condenatoria en abreviado:</label>
	<input type="text" class="form-control" name="causa_H_pena_condenatoria_en_abreviado" id="causa_H_pena_condenatoria_en_abreviado"
 placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
	<label for="causa_H_no_admision_del_abreviado" class="form-label">No admisión del abreviado:</label>
	<input type="text" class="form-control" name="causa_H_no_admision_del_abreviado" id="causa_H_no_admision_del_abreviado"
 placeholder="">
  </div>

  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_abreviado" class="form-label">Sentencia derivada de un procedimiento abreviado:</label>
      <select class="form-select" name="causa_H_abreviado" id="causa_H_abreviado">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_fecha_proced_abrev" class="form-label">Fecha en que se dictó el procedimiento abreviado:</label>
		<input type="date" class="form-control" name="causa_H_fecha_proced_abrev" id="causa_H_fecha_proced_abrev"
 value="">
  	</div> 
  <div class="mb-3 col-sm-12 col-md-6">
	<label for="causa_H_causas_abreviado" class="form-label">Causas no admisión abreviado:</label>
	<input type="text" class="form-control" name="causa_H_causas_abreviado" id="causa_H_causas_abreviado"
 placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_juicio_oral" class="form-label">Auto de apertura a juicio oral:</label>
      <select class="form-select" name="causa_H_juicio_oral" id="causa_H_juicio_oral">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_auto_de_apertura" class="form-label">Fecha de auto de apertura:</label>
		<input type="date" class="form-control" name="causa_H_auto_de_apertura" id="causa_H_auto_de_apertura"
 value="">
  	</div> 
  	<div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_fecha_audiencia_juicio" class="form-label">Fecha de la celebración de la audiencia de juicio:</label>
		<input type="date" class="form-control" name="causa_H_fecha_audiencia_juicio" id="causa_H_fecha_audiencia_juicio"
 value="">
  	</div> 
  <div class="mb-3 col-sm-12 col-md-6">
	<label for="causa_H_suspension_juicio" class="form-label">Suspensión del juicio:</label>
	<input type="text" class="form-control" name="causa_H_suspension_juicio" id="causa_H_suspension_juicio"
 placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
	<label for="causa_H_causas_suspension" class="form-label">Causas suspensión de juicio:</label>
	<input type="text" class="form-control" name="causa_H_causas_suspension" id="causa_H_causas_suspension"
 placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
	<label for="causa_H_sentencia_condenatoria" class="form-label">Sentencia condenatoria (pena impuesta):</label>
	<input type="text" class="form-control" name="causa_H_sentencia_condenatoria" id="causa_H_sentencia_condenatoria"
 placeholder="">
  </div>
  	<div class="mb-3 col-sm-12 col-md-6">
		<label for="causa_H_fecha_sentencia" class="form-label">Fecha en que se dictó la sentencia:</label>
		<input type="date" class="form-control" name="causa_H_fecha_sentencia" id="causa_H_fecha_sentencia"
 value="">
  	</div> 
  
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_tipo_sentencia" class="form-label">Tipo de sentencia:</label>
      <select class="form-select" name="causa_H_tipo_sentencia" id="causa_H_tipo_sentencia">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_firme" class="form-label">Sentencia se encuentra firme:</label>
      <select class="form-select" name="causa_H_firme" id="causa_H_firme">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
	<label for="causa_H_tiempo" class="form-label">Tiempo en prisión (años):</label>
	<input type="text" class="form-control" name="causa_H_tiempo" id="causa_H_tiempo"
 placeholder="">
  </div>

  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_tipos_de_pruebas" class="form-label">Tipos de pruebas desahogadas durante la audiencia de juicio:</label>
      <select class="form-select" name="causa_H_tipos_de_pruebas" id="causa_H_tipos_de_pruebas">
        <option selected>Seleccione una opción</option>
     </select>
  </div>	
</div>
<script type="text/javascript">
$("#causa_H_tiempo").mask("00");
</script>
