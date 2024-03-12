<!------- form_datos_generales.blade.php ------->
<div class="row causasCarpeta">

  
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_normativa" class="form-label">Señalamiento normativo:</label>
    <input type="text" class="form-control" name="causa_H_normativa" id="causa_H_normativa" placeholder="">
  </div>


</div>
  <!------- causas.blade.php ------->
<div class="row causasCausas">

  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_etapa_suspension" class="form-label">
    Etapa en la que se dictó  la suspensión condicional del proceso :</label>
    <select class="form-select" name="causa_H_etapa_suspension" id="causa_H_etapa_suspension">
      <option value="-1">Seleccione una opción</option>
   </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_etapa_sobreseimiento" class="form-label">
    Etapa en la que se dictó el sobreseimiento:</label>
    <select class="form-select" name="causa_H_etapa_sobreseimiento" id="causa_H_etapa_sobreseimiento">
      <option value="-1">Seleccione una opción</option>
   </select>
  </div>

</div>
  <!------- etapa_inicial.blade.php ------->
<div class="row causasInicial">

 
  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_liberacion" class="form-label">Liberación:</label>
    <select class="form-select" name="causa_H_liberacion" id="causa_H_liberacion">
      <option value="-1">Seleccione una opción</option>
   </select>
  </div>



  <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_auto_de_no_vinculacion" class="form-label">Fecha de auto de no vinculación:</label>
    <input type="date" class="form-control" name="causa_H_auto_de_no_vinculacion" id="causa_H_auto_de_no_vinculacion" value="">
  </div>   
</div>
  <!------- etapa_intermedia.blade.php ------->
<div class="row causasIntermedia">




</div>
  <!------- salidas_alternas.blade.php ------->
<div class="row causasSalidas">


<!--   <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
    <label for="causa_H_causa_suspension" class="form-label">Causa suspensión de juicio:</label>
    <input type="text" class="form-control" name="causa_H_causa_suspension" id="causa_H_causa_suspension" placeholder="">
  </div> -->



</div>
  <!------- juicio.blade.php ------->
<div class="row causasJuicio">



</div>
  <!------- complementarios.blade.php ------->
<div class="row causasComplementarios">


</div>

<script type="text/javascript">
$("#causa_H_tiempo").mask("00");
</script>