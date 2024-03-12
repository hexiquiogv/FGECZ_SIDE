<form method='post' name="frmDE_O" id="frmDE_O" action="{{ route('save') }}" enctype="multipart/form-data">
  @csrf        
  <input type="hidden" name="idObjeto" id="idObjeto" value="">
  <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
  <input type="hidden" name="Ctrl" id="Ctrl" value="{{$Ctrl}}">
	<div class="row objetos">
		<div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionObjeto_objeto_1" class="form-label">Objeto 1:</label>
		  <select class="form-select noValidate noVacios" name="conduccionObjeto_objeto_1" id="conduccionObjeto_objeto_1">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="conduccionObjeto_desc_obj_1" class="form-label">Descripción:</label>
		<input type="text" class="form-control alfanum noValidate obj1" name="conduccionObjeto_desc_obj_1" id="conduccionObjeto_desc_obj_1"
	 placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="conduccionObjeto_cant_obj_1" class="form-label">Cantidad:</label>
		<input type="text" class="form-control alfanum noValidate obj1" name="conduccionObjeto_cant_obj_1" id="conduccionObjeto_cant_obj_1"
	 placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="conduccionObjeto_valor_obj_1" class="form-label">Valor aproximado:</label>
		<input type="text" class="form-control valor noValidate obj1" name="conduccionObjeto_valor_obj_1" id="conduccionObjeto_valor_obj_1"
	 placeholder="">
	  </div>
	 	<div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		  <label for="objeto_estatus_obj_1" class="form-label">Estatus:</label>
		  <select class="form-select noValidate obj1" name="objeto_estatus_obj_1" id="objeto_estatus_obj_1">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-2 col-12"><hr></div>
		<div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionObjeto_objeto_2" class="form-label">Objeto 2:</label>
		  <select class="form-select noValidate noVacios" name="conduccionObjeto_objeto_2" id="conduccionObjeto_objeto_2">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="conduccionObjeto_desc_obj_2" class="form-label">Descripción :</label>
		<input type="text" class="form-control alfanum noValidate obj2" name="conduccionObjeto_desc_obj_2" id="conduccionObjeto_desc_obj_2"
	 placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="conduccionObjeto_cant_obj_2" class="form-label">Cantidad:</label>
		<input type="text" class="form-control alfanum noValidate obj2" name="conduccionObjeto_cant_obj_2" id="conduccionObjeto_cant_obj_2"
	 placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="conduccionObjeto_valor_obj_2" class="form-label">Valor aproximado:</label>
		<input type="text" class="form-control valor noValidate obj2" name="conduccionObjeto_valor_obj_2" id="conduccionObjeto_valor_obj_2"
	 placeholder="">
	  </div>
	 	<div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		  <label for="objeto_estatus_obj_2" class="form-label">Estatus:</label>
		  <select class="form-select noValidate obj2" name="objeto_estatus_obj_2" id="objeto_estatus_obj_2">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>	

			<div class="mb-2 col-12"><hr></div>
		<div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		  <label for="conduccionObjeto_objeto_3" class="form-label">Objeto 3:</label>
		  <select class="form-select noValidate noVacios" name="conduccionObjeto_objeto_3" id="conduccionObjeto_objeto_3">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="conduccionObjeto_desc_obj_3" class="form-label">Descripción :</label>
		<input type="text" class="form-control alfanum noValidate obj3" name="conduccionObjeto_desc_obj_3" id="conduccionObjeto_desc_obj_3"
	 placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="conduccionObjeto_cant_obj_3" class="form-label">Cantidad:</label>
		<input type="text" class="form-control alfanum noValidate obj3" name="conduccionObjeto_cant_obj_3" id="conduccionObjeto_cant_obj_3"
	 placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="conduccionObjeto_valor_obj_3" class="form-label">Valor aproximado:</label>
		<input type="text" class="form-control valor noValidate obj3" name="conduccionObjeto_valor_obj_3" id="conduccionObjeto_valor_obj_3"
	 placeholder="">
	  </div>
		<div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		  <label for="objeto_estatus_obj_3" class="form-label">Estatus:</label>
		  <select class="form-select noValidate obj3" name="objeto_estatus_obj_3" id="objeto_estatus_obj_3">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>

		<div class="mb-4 col-12"><hr></div>

	 	<div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		  <label for="objeto_tipo_narcotico_1" class="form-label">Tipo de narcótico 1:</label>
		  <select class="form-select noValidate noVacios" name="objeto_tipo_narcotico_1" id="objeto_tipo_narcotico_1">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4 d-none">
		<label for="objeto_presentacion_narco_1" class="form-label">Presentación:</label>
		<input type="text" class="form-control alfanum" maxlength="50" name="objeto_presentacion_narco_1" id="objeto_presentacion_narco_1" placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_cantidad_narco_1" class="form-label">Cantidad:</label>
		<input type="text" class="form-control alfanum noValidate nar1" name="objeto_cantidad_narco_1" id="objeto_cantidad_narco_1" placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_gramaje_narco_1" class="form-label">Gramaje:</label>
		<input type="text" class="form-control alfanum noValidate nar1" name="objeto_gramaje_narco_1" id="objeto_gramaje_narco_1">
	  </div>
	  	
	 	<div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		  <label for="objeto_tipo_narcotico_2" class="form-label">Tipo de narcótico 2:</label>
		  <select class="form-select noValidate noVacios" name="objeto_tipo_narcotico_2" id="objeto_tipo_narcotico_2">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	 	<div class="mb-1 col-sm-12 col-md-6 col-lg-4 d-none">
		<label for="objeto_presentacion_narco_2" class="form-label">Presentación:</label>
		<input type="text" class="form-control alfanum" maxlength="50" name="objeto_presentacion_narco_2" id="objeto_presentacion_narco_2" placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_cantidad_narco_2" class="form-label">Cantidad:</label>
		<input type="text" class="form-control alfanum noValidate nar2" name="objeto_cantidad_narco_2" id="objeto_cantidad_narco_2" placeholder="">
	  </div>
		<div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_gramaje_narco_2" class="form-label">Gramaje:</label>
		<input type="text" class="form-control alfanum noValidate nar2" name="objeto_gramaje_narco_2" id="objeto_gramaje_narco_2">
	  </div>
	 	<div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		  <label for="objeto_tipo_narcotico_3" class="form-label">Tipo de narcótico 3:</label>
		  <select class="form-select noValidate noVacios" name="objeto_tipo_narcotico_3" id="objeto_tipo_narcotico_3">
			<option value="-1">Seleccione una opción</option>
		 </select>
		</div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4 d-none">
		<label for="objeto_presentacion_narco_3" class="form-label">Presentación:</label>
		<input type="text" class="form-control alfanum" maxlength="50" name="objeto_presentacion_narco_3" id="objeto_presentacion_narco_3" placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_cantidad_narco_3" class="form-label">Cantidad:</label>
		<input type="text" class="form-control alfanum noValidate nar3" name="objeto_cantidad_narco_3" id="objeto_cantidad_narco_3" placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_gramaje_narco_3" class="form-label">Gramaje:</label>
		<input type="text" class="form-control alfanum noValidate nar3" name="objeto_gramaje_narco_3" id="objeto_gramaje_narco_3">
	  </div>
		<div class="mb-4 col-12"><hr></div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_estatus" class="form-label">Estatus del vehículo:</label>
		<!-- <input type="text" class="form-control nonum" name="objeto_estatus" id="objeto_estatus" placeholder=""> -->
	   <select class="form-select noValidate noVacios" name="objeto_estatus" id="objeto_estatus">
			<option value="-1">Seleccione una opción</option>
		 </select>		
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 siAseg noDevuelto noRobado" style="display: none;">
		<label for="objeto_fecha_asegurado" class="form-label">Fecha asegurado:</label>
		<input type="date" class="form-control" name="objeto_fecha_asegurado" id="objeto_fecha_asegurado">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 noAseg siDevuelto noRobado" style="display: none;">
		<label for="objeto_fecha_devuelto" class="form-label">Fecha devuelto:</label>
		<input type="date" class="form-control" name="objeto_fecha_devuelto" id="objeto_fecha_devuelto">
	  </div>
	  <div class="mb-3 col-sm-12 col-md-6 col-lg-4 noAseg noDevuelto siRobado" style="display: none;">
		<label for="objeto_fecha_robado" class="form-label">Fecha robado:</label>
		<input type="date" class="form-control" name="objeto_fecha_robado" id="objeto_fecha_robado">
	  </div>	  	  
	  
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_marca" class="form-label">Marca:</label>
		<input type="text" class="form-control nonum noValidate vehiculo" name="objeto_marca" id="objeto_marca" placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_modelo" class="form-label">Modelo:</label>
		<input type="text" class="form-control alfanum noValidate vehiculo" name="objeto_modelo" id="objeto_modelo" placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_color" class="form-label">Color:</label>
		<input type="text" class="form-control nonum noValidate vehiculo" name="objeto_color" id="objeto_color" placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_tipo" class="form-label">Tipo:</label>
		<input type="text" class="form-control nonum noValidate vehiculo" name="objeto_tipo" id="objeto_tipo" placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_placa" class="form-label">Placa:</label>
		<input type="text" class="form-control alfanum noValidate vehiculo" name="objeto_placa" id="objeto_placa" placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_numero" class="form-label">Número de serie:</label>
		<input type="text" class="form-control alfanum noValidate vehiculo" maxlength="17" name="objeto_numero" id="objeto_numero" placeholder="">
	  </div>
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_estado_placas" class="form-label">Estado de las placas:</label>
		<input type="text" class="form-control nonum noValidate vehiculo" name="objeto_estado_placas" id="objeto_estado_placas" placeholder="">
	  </div>	
	  <div class="mb-1 col-sm-12 col-md-6 col-lg-4">
		<label for="objeto_lugar_vehiculo" class="form-label">Lugar donde se encuentra el vehículo:</label>
		<input type="text" class="form-control alfanum noValidate" name="objeto_lugar_vehiculo" id="objeto_lugar_vehiculo">
	  </div>
	</div>
</form>
	 		
<script type="text/javascript">
$(".cantidad").mask("0000");
$(".valor").mask("#,##0.00",{reverse: true});

	@for ($i = 1; $i <= 3; $i++)
		$("#conduccionObjeto_objeto_{{$i}}").change(function(){
			if (this.value>-1) { $(".obj{{$i}}").removeClass('noValidate'); }
			else
			{ $(".obj{{$i}}").addClass('noValidate'); $(".obj{{$i}}").removeClass("border-3 border-danger");}
		});	

		$("#objeto_tipo_narcotico_{{$i}}").change(function(){
			if (this.value>-1) { $(".nar{{$i}}").removeClass('noValidate'); }
			else
			{ $(".nar{{$i}}").addClass('noValidate'); $(".nar{{$i}}").removeClass("border-3 border-danger");}
		});
	@endfor
	$(function() {
		@for ($i = 1; $i <= 3; $i++)
				if ($("#conduccionObjeto_objeto_{{$i}}").val()>-1) { $(".obj{{$i}}").removeClass('noValidate'); }
				else
				{ $(".obj{{$i}}").addClass('noValidate'); $(".obj{{$i}}").removeClass("border-3 border-danger");}

				if ($("#objeto_tipo_narcotico_{{$i}}").val()>-1) { $(".nar{{$i}}").removeClass('noValidate'); }
				else
				{ $(".nar{{$i}}").addClass('noValidate'); $(".nar{{$i}}").removeClass("border-3 border-danger");}
		@endfor
	});

	$("#objeto_estatus").change(function(){
				$(".vehiculo").removeClass("noValidate");
		if (this.value==1) {
			$(".siAseg").show();
			$(".noAseg").hide();
			$("#objeto_fecha_devuelto").val('');
			$("#objeto_fecha_robado").val('');		 
		}
		else if (this.value==2) {
			$(".siDevuelto").show();
			$(".noDevuelto").hide();
			$("#objeto_fecha_asegurado").val('');
			$("#objeto_fecha_robado").val('');		
		}
		else if (this.value==3) {
			$(".siRobado").show();
			$(".noRobado").hide();
			$("#objeto_fecha_asegurado").val('');
			$("#objeto_fecha_devuelto").val('');
		}
		else{
			$("#objeto_fecha_asegurado").val('');
			$(".siAseg").hide(); 
			$("#objeto_fecha_devuelto").val('');
			$(".siDevuelto").hide(); 
			$("#objeto_fecha_robado").val('');
			$(".siRobado").hide(); 
			$(".vehiculo").addClass("noValidate").removeClass("border-3 border-danger");
		}
	});
</script>