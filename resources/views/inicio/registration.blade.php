
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="p-3 bg-body rounded shadow">
			<h6 class="border-bottom pb-2 mb-3">Agregar usuarios</h6>
			<form action="{{ route('Inicio.validate_registration') }}" method="POST">
				@csrf
				<div class="form-group mb-3">
					<input type="text" name="name" class="form-control" placeholder="Nombre" />
					@if($errors->has('name'))
						<span class="text-danger">{{ $errors->first('name') }}</span>
					@endif
				</div>
				<div class="form-group mb-3">
					<input type="text" name="email" class="form-control" placeholder="Correo" />
					@if($errors->has('email'))
						<span class="text-danger">{{ $errors->first('email') }}</span>
					@endif
				</div>
				<div class="form-group mb-3">
					<input type="password" name="password" class="form-control" placeholder="Password" />
					@if($errors->has('password'))
						<span class="text-danger">{{ $errors->first('password') }}</span>
					@endif
				</div>
				<div class="form-group mb-3">
				  <select class="form-select" name="tipo" id="tipo">
				    <option selected disabled>Tipo de usuario:</option>
				    <option value="1">Operador</option>
				    <option value="2">Supervisor</option>
				    <option value="3">Super usuario</option>
				  </select>
 					@if($errors->has('tipo'))
						<span class="text-danger">{{ $errors->first('tipo') }}</span>
					@endif
				</div>				
				<div class="form-group mb-3">
				  <select class="form-select" name="unidad" id="unidad">
				    <option selected disabled>Unidad:</option>
				    <option value="1">ATENCION TEMPRANA RAMOS ARIZPE</option>
				    <option value="2">ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO RAMOS ARIZPE</option>
				    <option value="3">UNIDAD DE TRAMITACION MASIVA DE CASOS RAMOS ARIZPE</option>
				    <option value="4">ATENCION TEMPRANA ARTEAGA</option>
				    <option value="5">ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO ARTEAGA</option>
				    <option value="6">UNIDAD DE TRAMITACION MASIVA DE CASOS ARTEAGA</option>
				    <option value="7">ATENCION TEMPRANA GENERAL CEPEDA</option>
				    <option value="8">ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO GENERAL CEPEDA</option>
				    <option value="9">UNIDAD DE TRAMITACION MASIVA DE CASOS GENERAL CEPEDA</option>
				    <option value="10">ATENCION TEMPRANA SALTILLO</option>
				    <option value="11">ATENCION TEMPRANA CON DETENIDO SALTILLO</option>
				    <option value="12">ATENCION TEMPRANA DE IMPUTADO DESCONOCIDO SALTILLO</option>
				    <option value="13">ATENCION TEMPRANA CON DETENIDO DEL CENTRO DE OPERACIONES ESTRATEGICAS</option>
				    <option value="80">UNIDAD I</option>
				    <option value="31000">DIRECCION GENERAL DE INFORMATICA Y TELECOMUNICACIONES</option>
				    <option value="31002">DIRECCION GENERAL DE UNIDADES DE INVESTIGACION</option>
				  </select>
 					@if($errors->has('unidad'))
						<span class="text-danger">{{ $errors->first('unidad') }}</span>
					@endif
				</div>
				<div class="form-group mb-3">
				  <select class="form-select" name="nivel" id="nivel">
				    <option selected disabled>Nivel:</option>
				    <option value="1">Nivel 1</option>
				    <option value="2">Nivel 2</option>
				    <option value="3">Nivel 3</option>
				    <option value="4">Nivel 4</option>
				    <option value="5">Nivel 5</option>
				  </select>
 					@if($errors->has('nivel'))
						<span class="text-danger">{{ $errors->first('nivel') }}</span>
					@endif
				</div>

				<div class="d-grid mx-auto">
					<button type="submit" class="btn btn-primary">Registrar</button>
				</div>
			</form>
		</div>
	</div>
</div>