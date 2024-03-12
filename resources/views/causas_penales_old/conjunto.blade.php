<!------- form_datos_generales.blade.php ------->
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
<!------- causas.blade.php ------->
<div class="row causasCausas">
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_actos_de_inv" class="form-label">Actos de investigación:</label>
      <select class="form-select" name="causa_H_actos_de_inv" id="causa_H_actos_de_inv">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_tipos_de_actos_con_control" class="form-label">Tipos de actos con control judicial:</label>
      <select class="form-select" name="causa_H_tipos_de_actos_con_control" id="causa_H_tipos_de_actos_con_control">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_acuerdos_prop" class="form-label">Acuerdos probatorios:</label>
      <select class="form-select" name="causa_H_acuerdos_prop" id="causa_H_acuerdos_prop">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_masc" class="form-label">Asunto derivado a MASC:</label>
      <select class="form-select" name="causa_H_masc" id="causa_H_masc">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_autoridad_deriva_masc" class="form-label">Autoridad que deriva el MASC :</label>
      <select class="form-select" name="causa_H_autoridad_deriva_masc" id="causa_H_autoridad_deriva_masc">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_tipo_suspension" class="form-label">Tipo de condiciones impuestas durante la suspensión condicional del proceso:</label>
      <select class="form-select" name="causa_H_tipo_suspension" id="causa_H_tipo_suspension">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_audiencia_inicial" class="form-label">Celebración audiencia inicial:</label>
      <select class="form-select" name="causa_H_audiencia_inicial" id="causa_H_audiencia_inicial">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_intermedia" class="form-label">Celebración de la audiencia intermedia:</label>
      <select class="form-select" name="causa_H_intermedia" id="causa_H_intermedia">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_estatus_mandamiento" class="form-label">Estatus de mandamiento judicial:</label>
      <select class="form-select" name="causa_H_estatus_mandamiento" id="causa_H_estatus_mandamiento">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_etapa_suspension" class="form-label">
      Etapa en la que se dictó  la suspensión condicional del proceso :</label>
      <select class="form-select" name="causa_H_etapa_suspension" id="causa_H_etapa_suspension">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_etapa_sobreseimiento" class="form-label">
      Etapa en la que se dictó el sobreseimiento:</label>
      <select class="form-select" name="causa_H_etapa_sobreseimiento" id="causa_H_etapa_sobreseimiento">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_etapa_proces" class="form-label">Etapa procesal en que se encuentra la carpeta de investigación:</label>
      <select class="form-select" name="causa_H_etapa_proces" id="causa_H_etapa_proces">
        <option selected>Seleccione una opción</option>
     </select>
  </div> 
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_reapertura" class="form-label">Reapertura del proceso:</label>
      <select class="form-select" name="causa_H_reapertura" id="causa_H_reapertura">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_reapertura" class="form-label">Fecha de la reapertura del proceso:</label>
    <input type="date" class="form-control" name="causa_H_fecha_reapertura" id="causa_H_fecha_reapertura"
 value="">
    </div>  
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_momento_reclas" class="form-label">Momento reclasificación:</label>
      <select class="form-select" name="causa_H_momento_reclas" id="causa_H_momento_reclas">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_reclas" class="form-label">Fecha de reclasificación:</label>
    <input type="date" class="form-control" name="causa_H_fecha_reclas" id="causa_H_fecha_reclas"
 value="">
    </div>
</div>
<!------- etapa_inicial.blade.php ------->
<div class="row causasInicial">
  <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_causa_penal_id" class="form-label">Causa penal:</label>
    <input type="text" class="form-control" name="causa_H_causa_penal_id" id="causa_H_causa_penal_id"
 placeholder="1571/2019">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_causa_penal" class="form-label">Fecha de inicio causa penal:</label>
    <input type="date" class="form-control" name="causa_H_fecha_causa_penal" id="causa_H_fecha_causa_penal"

        value="">
  </div>
  <div class="mb-3 col-12">
    <label for="causa_H_delito_de_acuerdo_con_ley" class="form-label">
    Delito de acuerdo con la ley penal:</label>
    <input type="text" class="form-control" name="causa_H_delito_de_acuerdo_con_ley" id="causa_H_delito_de_acuerdo_con_ley"
 placeholder="">
  </div>
    <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_decreto_legal_detencion" class="form-label">Decreto legal de detención:</label>
      <select class="form-select" name="causa_H_decreto_legal_detencion" id="causa_H_decreto_legal_detencion">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_imputado_conocido" class="form-label">Imputado conocido:</label>
      <select class="form-select" name="causa_H_imputado_conocido" id="causa_H_imputado_conocido">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_unidad_de_investigacion" class="form-label">Unidad de investigación:</label>
      <select class="form-select" name="causa_H_unidad_de_investigacion" id="causa_H_unidad_de_investigacion">
        <option selected>Seleccione una opción</option>
     </select>
  </div>

  <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_solicitud_de_orden_de_aprehension" class="form-label">Solicitud de orden de aprehensión:</label>
  <input type="text" class="form-control" name="causa_H_solicitud_de_orden_de_aprehension" id="causa_H_solicitud_de_orden_de_aprehension"
 placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_oa_cumplida" class="form-label">Orden de aprehensión cumplida:</label>
  <input type="text" class="form-control" name="causa_H_oa_cumplida" id="causa_H_oa_cumplida"
 placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_oa_negada" class="form-label">Orden de aprehensión negada:</label>
  <input type="text" class="form-control" name="causa_H_oa_negada" id="causa_H_oa_negada"
 placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_oa_sin_efecto" class="form-label">Orden de aprehensión sin efecto:</label>
  <input type="text" class="form-control" name="causa_H_oa_sin_efecto" id="causa_H_oa_sin_efecto"
 placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_orden_de_comaprecencia_girada" class="form-label">Orden de comparecencia girada:</label>
  <input type="text" class="form-control" name="causa_H_orden_de_comaprecencia_girada" id="causa_H_orden_de_comaprecencia_girada"
 placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_orden_de_comaprecencia_negada" class="form-label">Orden de comparecencia negada:</label>
  <input type="text" class="form-control" name="causa_H_orden_de_comaprecencia_negada" id="causa_H_orden_de_comaprecencia_negada"
 placeholder="">
  </div>
  
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_forma_de_conduccion_del_imputado_a_proceso" class="form-label">Forma de conducción del imputado al proceso:</label>
      <select class="form-select" name="causa_H_forma_de_conduccion_del_imputado_a_proceso" id="causa_H_forma_de_conduccion_del_imputado_a_proceso">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_formulacion" class="form-label">Formulación de la imputación:</label>
      <select class="form-select" name="causa_H_formulacion" id="causa_H_formulacion">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_causa_proceso" class="form-label">Causa de la suspensión:</label>
      <select class="form-select" name="causa_H_causa_proceso" id="causa_H_causa_proceso">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_medidas_cautelares" class="form-label">Medidas cautelares:</label>
      <select class="form-select" name="causa_H_medidas_cautelares" id="causa_H_medidas_cautelares">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_tipo_medidas_cautelares" class="form-label">
      Tipo de medidas cautelares impuestas:</label>
      <select class="form-select" name="causa_H_tipo_medidas_cautelares" id="causa_H_tipo_medidas_cautelares">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_temporalidad_medida" class="form-label">Temporalidad de la medida:</label>
  <input type="text" class="form-control" name="causa_H_temporalidad_medida" id="causa_H_temporalidad_medida"
 placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_inicio_investigacion" class="form-label">Fecha de inicio del plazo de investigación:</label>
    <input type="date" class="form-control" name="causa_H_fecha_inicio_investigacion" id="causa_H_fecha_inicio_investigacion"
 value="">
  </div> 
  <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_cierre" class="form-label">Fecha de cierre del plazo de investigación:</label>
    <input type="date" class="form-control" name="causa_H_fecha_cierre" id="causa_H_fecha_cierre"
 value="">
  </div>
 <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_prorroga" class="form-label">Prórroga del plazo de investigación:</label>
  <input type="text" class="form-control" name="causa_H_prorroga" id="causa_H_prorroga"
 placeholder="">
  </div>
 <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_nombre_juez_control" class="form-label">Nombre del juez de control:</label>
  <input type="text" class="form-control" name="causa_H_nombre_juez_control" id="causa_H_nombre_juez_control"
 placeholder="">
  </div>
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_control" class="form-label">Fecha de audiencia de control de la detención:</label>
    <input type="date" class="form-control" name="causa_H_fecha_control" id="causa_H_fecha_control"
 value="">
    </div> 
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_form" class="form-label">Fecha de formulación de la imputación:</label>
    <input type="date" class="form-control" name="causa_H_fecha_form" id="causa_H_fecha_form"
 value="">
    </div> 
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_libera" class="form-label">Fecha de libramiento del mandamiento:</label>
    <input type="date" class="form-control" name="causa_H_fecha_libera" id="causa_H_fecha_libera"
 value="">
    </div> 
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_mandamiento" class="form-label">Fecha de solicitud del mandamiento judicial:</label>
    <input type="date" class="form-control" name="causa_H_fecha_mandamiento" id="causa_H_fecha_mandamiento"
 value="">
    </div> 
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_cierre_inv" class="form-label">Fecha del cierre de la investigación :</label>
    <input type="date" class="form-control" name="causa_H_cierre_inv" id="causa_H_cierre_inv"
 value="">
    </div> 
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_resol" class="form-label">Fecha en que se dictó el auto de vinculación a proceso:</label>
    <input type="date" class="form-control" name="causa_H_fecha_resol" id="causa_H_fecha_resol"
 value="">
    </div> 
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_forma_proceso" class="form-label">Forma en la que lleva su proceso:</label>
      <select class="form-select" name="causa_H_forma_proceso" id="causa_H_forma_proceso">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_liberacion" class="form-label">Liberación:</label>
      <select class="form-select" name="causa_H_liberacion" id="causa_H_liberacion">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_medio_de_conocimiento" class="form-label">Medio de conocimiento de los hechos:</label>
      <select class="form-select" name="causa_H_medio_de_conocimiento" id="causa_H_medio_de_conocimiento">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_motivo_noaud" class="form-label">Motivo por el que no se celebró la audiencia inicial:</label>
      <select class="form-select" name="causa_H_motivo_noaud" id="causa_H_motivo_noaud">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_reclasificacion" class="form-label">Reclasificación:</label>
      <select class="form-select" name="causa_H_reclasificacion" id="causa_H_reclasificacion">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_resolucion" class="form-label">Resolución del auto de vinculación a proceso:</label>
      <select class="form-select" name="causa_H_resolucion" id="causa_H_resolucion">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_inv_con_detenido" class="form-label">Investigación con detenido:</label>
      <select class="form-select" name="causa_H_inv_con_detenido" id="causa_H_inv_con_detenido">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_auto_de_no_vinculacion" class="form-label">Fecha de auto de no vinculación:</label>
    <input type="date" class="form-control" name="causa_H_auto_de_no_vinculacion" id="causa_H_auto_de_no_vinculacion"
 value="">
    </div>   
</div>
<!------- etapa_intermedia.blade.php ------->
<div class="row causasIntermedia">
  <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_audiencia_intermedia" class="form-label">Fecha de la celebración de la audiencia intermedia:</label>
    <input type="date" class="form-control" name="causa_H_fecha_audiencia_intermedia" id="causa_H_fecha_audiencia_intermedia"
 value="">
    </div> 
  <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_suspension_de_audiencia" class="form-label">Fecha de suspensión de audiencia:</label>
    <input type="date" class="form-control" name="causa_H_suspension_de_audiencia" id="causa_H_suspension_de_audiencia"
 value="">
    </div> 
  <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_causas_suspension_intermedia" class="form-label">Causas de suspensión intermedia:</label>
  <input type="text" class="form-control" name="causa_H_causas_suspension_intermedia" id="causa_H_causas_suspension_intermedia"
 placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_de_reanudacion_intermedia" class="form-label">Fecha de reanudación de audiencia intermedia:</label>
    <input type="date" class="form-control" name="causa_H_fecha_de_reanudacion_intermedia" id="causa_H_fecha_de_reanudacion_intermedia"
 value="">
    </div> 
  <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_causas_no_admision" class="form-label">Causas de la no admisión:</label>
  <input type="text" class="form-control" name="causa_H_causas_no_admision" id="causa_H_causas_no_admision"
 placeholder="">
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_medio_prueba" class="form-label">Presentación de medios de prueba</label>
      <select class="form-select" name="causa_H_medio_prueba" id="causa_H_medio_prueba">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_medios_pruebas" class="form-label">Medios de prueba (presentados /excluidos)</label>
      <select class="form-select" name="causa_H_medios_pruebas" id="causa_H_medios_pruebas">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
</div>
<!------- salidas_alternas.blade.php ------->
<div class="row causasSalidas">
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_acuerdo_reparatorio" class="form-label">Acuerdo reparatorio:</label>
      <select class="form-select" name="causa_H_acuerdo_reparatorio" id="causa_H_acuerdo_reparatorio">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_acuerdos_reparatorios" class="form-label">Tipo de acuerdos reparatorios:</label>
      <select class="form-select" name="causa_H_acuerdos_reparatorios" id="causa_H_acuerdos_reparatorios">
        <option selected>Seleccione una opción</option>
     </select>
  </div>  
 <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_condicion_impuesta" class="form-label">Condición impuesta:</label>
  <input type="text" class="form-control" name="causa_H_condicion_impuesta" id="causa_H_condicion_impuesta"
 placeholder="">
  </div>
 <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_temporalidad" class="form-label">Temporalidad de la condición impuesta:</label>
  <input type="text" class="form-control" name="causa_H_temporalidad" id="causa_H_temporalidad"
 placeholder="">
  </div>
 <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_temporalidad_salidad_alternas" class="form-label">Temporalidad de salidas alternas:</label>
  <input type="text" class="form-control" name="causa_H_temporalidad_salidad_alternas" id="causa_H_temporalidad_salidad_alternas"
 placeholder="">
  </div>
 <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_reparacion_del_daño_" class="form-label">Tipo de reparación del daño:</label>
  <input type="text" class="form-control" name="causa_H_reparacion_del_daño_" id="causa_H_reparacion_del_daño_"
 placeholder="">
  </div>
 <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_monto_rep_daño" class="form-label">Monto de la reparación del daño:</label>
  <input type="text" class="form-control" name="causa_H_monto_rep_daño" id="causa_H_monto_rep_daño"
 placeholder="">
  </div>
  
    <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_suspension_condicional" class="form-label">Suspensión condicional del proceso:</label>
      <select class="form-select" name="causa_H_suspension_condicional" id="causa_H_suspension_condicional">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
 <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_suspension_del_proceso" class="form-label">Suspensión del proceso:</label>
  <input type="text" class="form-control" name="causa_H_suspension_del_proceso" id="causa_H_suspension_del_proceso"
 placeholder="">
  </div>
 <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_causa_suspension" class="form-label">Causa suspensión de juicio:</label>
  <input type="text" class="form-control" name="causa_H_causa_suspension" id="causa_H_causa_suspension"
 placeholder="">
  </div>
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_suspension" class="form-label">Fecha en que se dictó la suspensión condicional del proceso:</label>
    <input type="date" class="form-control" name="causa_H_fecha_suspension" id="causa_H_fecha_suspension"
 value="">
    </div> 
    <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_tipo_cumplimiento" class="form-label">Tipo de cumplimiento:</label>
      <select class="form-select" name="causa_H_tipo_cumplimiento" id="causa_H_tipo_cumplimiento">
        <option selected>Seleccione una opción</option>
     </select>
  </div>

    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_cumpl" class="form-label">Fecha en que se cumplimentó la suspensión condicional del proceso:</label>
    <input type="date" class="form-control" name="causa_H_fecha_cumpl" id="causa_H_fecha_cumpl"
 value="">
    </div> 
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_de_reanudacion" class="form-label">Fecha de reanudación de audiencia:</label>
    <input type="date" class="form-control" name="causa_H_fecha_de_reanudacion" id="causa_H_fecha_de_reanudacion"
 value="">
    </div> 
  
</div>
<!------- juicio.blade.php ------->
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
<!------- complementarios.blade.php ------->
<div class="row causasComplementarios">
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_acusacion" class="form-label">Hubo acusación</label>
      <select class="form-select" name="causa_H_acusacion" id="causa_H_acusacion">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_acusacion" class="form-label">Fecha de acusación:</label>
    <input type="date" class="form-control" name="causa_H_fecha_acusacion" id="causa_H_fecha_acusacion"
 value="">
  </div> 
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_escrito_acus" class="form-label">Fecha del escrito de acusación:</label>
    <input type="date" class="form-control" name="causa_H_fecha_escrito_acus" id="causa_H_fecha_escrito_acus"
 value="">
    </div> 

    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_cumpl_mas" class="form-label">Fecha en que se cumplimentó el MASC:</label>
    <input type="date" class="form-control" name="causa_H_fecha_cumpl_mas" id="causa_H_fecha_cumpl_mas"
 value="">
    </div> 
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_deriva_masc" class="form-label">Fecha en que se deriva a MASC:</label>
    <input type="date" class="form-control" name="causa_H_fecha_deriva_masc" id="causa_H_fecha_deriva_masc"
 value="">
    </div> 

    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_recurso" class="form-label">Fecha de recurso:</label>
    <input type="date" class="form-control" name="causa_H_fecha_recurso" id="causa_H_fecha_recurso"
 value="">
    </div> 
  <div class="mb-3 col-sm-12 col-md-6">
  <label for="causa_H_resolucion_del_recurso" class="form-label">Resolución del recurso:</label>
  <input type="text" class="form-control" name="causa_H_resolucion_del_recurso" id="causa_H_resolucion_del_recurso"
 placeholder="">
  </div>
    <div class="mb-3 col-sm-12 col-md-6">
    <label for="causa_H_fecha_sobreseimiento" class="form-label">Fecha sobreseimiento:</label>
    <input type="date" class="form-control" name="causa_H_fecha_sobreseimiento" id="causa_H_fecha_sobreseimiento"
 value="">
    </div> 

  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_causas_sobreseimiento" class="form-label">Causas de sobreseimiento</label>
      <select class="form-select" name="causa_H_causas_sobreseimiento" id="causa_H_causas_sobreseimiento">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_tipo_sobreseimiento" class="form-label">Tipo de sobreseimiento</label>
      <select class="form-select" name="causa_H_tipo_sobreseimiento" id="causa_H_tipo_sobreseimiento">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_tipo_de_recurso" class="form-label">Tipo de recurso</label>
      <select class="form-select" name="causa_H_tipo_de_recurso" id="causa_H_tipo_de_recurso">
        <option selected>Seleccione una opción</option>
     </select>
  </div>
  <div class="mb-3 col-sm-12 col-md-6">
      <label for="causa_H_tipo_masc" class="form-label">Tipo de MASC</label>
      <select class="form-select" name="causa_H_tipo_masc" id="causa_H_tipo_masc">
        <option selected>Seleccione una opción</option>
     </select>
  </div>  
</div>
