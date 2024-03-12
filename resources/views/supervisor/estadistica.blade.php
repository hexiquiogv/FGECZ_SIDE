@extends('layouts.dashboard')

@section('navBarTitle')
Estadística
 @stop
@section('navBarListado') 
	<a class="dropdown-item" href='{{ route("listado.super") }}'>Inicio</a>
	<div class="dropdown-divider"></div>
	@if(Auth::User()->TipoUsuario!=2)
		<a class="dropdown-item" href='{{ route("estadistica.super") }}'>Apartado estadístico</a>
		<div class="dropdown-divider"></div>
	@endif
 @stop
@section('navBarSalir') 
	<a class="dropdown-item" href="{{ route('logout') }}">Cerrar sesión</a>
 @stop

 @section('collapsedDBE','')
 @section('activeDBE','active')
 @section('indexDBE')
 <style type="text/css">
	.form-check-input:checked {
		background-color: #7E6D54;
		border-color: #7E6D54;
	}
 </style>
 <div class="p-3 my-3 bg-body rounded shadow">
	<div class="row pt-4">
		<div class="col-12 mb-5 text-center">
		<div class="mb-3">
			<div class="input-group w-25 mx-auto">
			  <label class="input-group-text" for="periodoI_1">Periodo del</label>
			  <input class="form-control periodoMask" type="text" id="periodoI_1" name="periodoI_1" placeholder="00/0000"
			   onblur="validar('1')">
			  <label class="input-group-text" for="periodoF_1">al</label>
			  <input class="form-control periodoMask" type="text" id="periodoF_1" name="periodoF_1" placeholder="00/0000"
			   onblur="validar('1')">
			</div>
			<div class="form-check form-check-inline form-switch mx-auto">
			  <input class="form-check-input" type="radio" name="grafica1" id="grafica1_1" value="1" disabled="disabled">
			  <label class="form-check-label" for="grafica1_1">Meses</label>
			</div>		 
		</div>
		 <div class="mb-3">
			<div class="form-check form-check-inline form-switch mx-5">
			  <input class="form-check-input" type="radio" name="grafica1" id="grafica1_2" value="2" checked>
			  <label class="form-check-label" for="grafica1_2">Delegación</label>
			</div>
			<div class="form-check form-check-inline form-switch mx-5">
			  <input class="form-check-input" type="radio" name="grafica1" id="grafica1_3" value="3">
			  <label class="form-check-label" for="grafica1_3">Unidad de investigación</label>
			</div>
		 </div>							
			<canvas id="CarpetasIniciadasResuletasEnTramite" style="width:100%;max-height:305px"></canvas>			
		</div>
	</div>
 </div>
 <div class="p-3 my-3 bg-body rounded shadow">
	<div class="row pt-4">		
		<div class="col-12 mb-5 text-center">
			<div class="mb-3">
				<div class="input-group w-25 mx-auto">
				  <label class="input-group-text" for="periodoI_2">Periodo del</label>
				  <input class="form-control periodoMask" type="text" id="periodoI_2" name="periodoI_2" placeholder="00/0000"
				   onblur="validar('2')">
				  <label class="input-group-text" for="periodoF_2">al</label>
				  <input class="form-control periodoMask" type="text" id="periodoF_2" name="periodoF_2" placeholder="00/0000"
				   onblur="validar('2')">
				</div>
				<div class="form-check form-check-inline form-switch mx-auto">
				  <input class="form-check-input" type="radio" name="grafica2" id="grafica2_1" value="1" disabled="disabled">
				  <label class="form-check-label" for="grafica2_1">Meses</label>
				</div>
			</div>
			<div class="mb-3">				
				<div class="form-check form-check-inline form-switch mx-5">
				  <input class="form-check-input" type="radio" name="grafica2" id="grafica2_2" value="2" checked>
				  <label class="form-check-label" for="grafica2_2">Delegación</label>
				</div>
				<div class="form-check form-check-inline form-switch mx-5">
				  <input class="form-check-input" type="radio" name="grafica2" id="grafica2_3" value="3">
				  <label class="form-check-label" for="grafica2_3">Unidad de investigación</label>
				</div>
			</div>			
		</div>
		<div class="col-8 my-3">
			<canvas id="CarpetasConcluidasDeterminacion" style="width:100%;max-height:305px"></canvas>
		</div>
		<div class="col-4 my-5">			
			<div class="text-center mb-3 btn btn-primary w-100"><p>TOTAL DE CARPETAS CONCLUIDAS POR ARCHIVO TEMPORAL</p><span id="totAT">-</span></div>
			<div class="text-center mb-3 btn btn-primary w-100"><p>TOTAL DE CARPETAS CONCLUIDAS POR DETERMINACIÓN</p><span id="totDT">-</span></div>
		</div>
	</div>
 </div>
 <div class="p-3 my-3 bg-body rounded shadow">
	<div class="row pt-4">
		<div class="col-12 mb-5 text-center">
	 	 <div class="mb-3">
			<div class="input-group w-25 mx-auto">
			  <label class="input-group-text" for="periodoI_3">Periodo del</label>
			  <input class="form-control periodoMask" type="text" id="periodoI_3" name="periodoI_3" placeholder="00/0000"
			   onblur="validar('3')">
			  <label class="input-group-text" for="periodoF_3">al</label>
			  <input class="form-control periodoMask" type="text" id="periodoF_3" name="periodoF_3" placeholder="00/0000"
			   onblur="validar('3')">
			</div>				
			<div class="form-check form-check-inline form-switch mx-auto">
			  <input class="form-check-input" type="radio" name="grafica3" id="grafica3_1" value="1" disabled="disabled">
			  <label class="form-check-label" for="grafica3_1">Meses</label>
			</div>
		 </div>
		 <div class="mb-3">
			<div class="form-check form-check-inline form-switch mx-5">
			  <input class="form-check-input" type="radio" name="grafica3" id="grafica3_2" value="2" checked>
			  <label class="form-check-label" for="grafica3_2">Delegación</label>
			</div>
			<div class="form-check form-check-inline form-switch mx-5">
			  <input class="form-check-input" type="radio" name="grafica3" id="grafica3_3" value="3">
			  <label class="form-check-label" for="grafica3_3">Unidad de investigación</label>
			</div>
		 </div>							
			<canvas id="TotalDeterminaciones" style="width:100%;max-height:305px"></canvas>
		</div>
	</div>
 </div>
 <div class="p-3 my-3 bg-body rounded shadow">
	<div class="row pt-4">		
		<div class="col-12 mb-5 text-center">
			<div class="mb-3">
				<div class="input-group w-25 mx-auto">
				  <label class="input-group-text" for="periodoI_4">Periodo del</label>
				  <input class="form-control periodoMask" type="text" id="periodoI_4" name="periodoI_4" placeholder="00/0000"
				   onblur="validar('4')">
				  <label class="input-group-text" for="periodoF_4">al</label>
				  <input class="form-control periodoMask" type="text" id="periodoF_4" name="periodoF_4" placeholder="00/0000"
				   onblur="validar('4')">
				</div>				
				<div class="form-check form-check-inline form-switch mx-auto">
				  <input class="form-check-input" type="radio" name="grafica4" id="grafica4_1" value="1" disabled="disabled">
				  <label class="form-check-label" for="grafica4_1">Meses</label>
				</div>
		 </div>
		 <div class="mb-3">				
				<div class="form-check form-check-inline form-switch mx-5">
				  <input class="form-check-input" type="radio" name="grafica4" id="grafica4_2" value="2" checked>
				  <label class="form-check-label" for="grafica4_2">Delegación</label>
				</div>				
			</div>			
		</div>
		<div class="col-8 my-3">
			<canvas id="CarpetasJudicializadas" style="width:100%;max-height:305px"></canvas>
		</div>
		<div class="col-4 my-5">			
			<div class="text-center mb-3 btn btn-primary w-100"><p>CARPETAS JUDICIALIZADAS</p><p><span id="totJD">-</span></p><p><span id="totPJ">-</span></p></div>
		</div>
	</div>
 </div>
 <div class="p-3 my-3 bg-body rounded shadow">
	<div class="row pt-4">		
		<div class="col-12 mb-5 text-center">
			<div class="mb-3">
				<div class="input-group w-25 mx-auto">
				  <label class="input-group-text" for="periodoI_5">Periodo del</label>
				  <input class="form-control periodoMask" type="text" id="periodoI_5" name="periodoI_5" placeholder="00/0000"
				   onblur="validar('5')">
				  <label class="input-group-text" for="periodoF_5">al</label>
				  <input class="form-control periodoMask" type="text" id="periodoF_5" name="periodoF_5" placeholder="00/0000"
				   onblur="validar('5')">
				</div>				
				<div class="form-check form-check-inline form-switch mx-auto">
				  <input class="form-check-input" type="radio" name="grafica5" id="grafica5_1" value="1" disabled="disabled">
				  <label class="form-check-label" for="grafica5_1">Meses</label>
				</div>
		 </div>
		 <div class="mb-3">				
				<div class="form-check form-check-inline form-switch mx-5">
				  <input class="form-check-input" type="radio" name="grafica5" id="grafica5_2" value="2" checked>
				  <label class="form-check-label" for="grafica5_2">Delegación</label>
				</div>				
			</div>			
		</div>
		<div class="col-6 my-3">
			<canvas id="CarpetasVinculadas" style="width:100%;max-height:305px"></canvas>
		</div>
		<div class="col-6 my-3">
			<canvas id="CarpetasNoVinculadas" style="width:100%;max-height:305px"></canvas>
		</div>
	</div>
 </div>
 <div class="p-3 my-3 bg-body rounded shadow">
	<div class="row pt-4">		
		<div class="col-12 mb-5 text-center">
			<div class="mb-3">
				<div class="input-group w-25 mx-auto">
				  <label class="input-group-text" for="periodoI_6">Periodo del</label>
				  <input class="form-control periodoMask" type="text" id="periodoI_6" name="periodoI_6" placeholder="00/0000"
				   onblur="validar('6')">
				  <label class="input-group-text" for="periodoF_6">al</label>
				  <input class="form-control periodoMask" type="text" id="periodoF_6" name="periodoF_6" placeholder="00/0000"
				   onblur="validar('6')">
				</div>				
				<div class="form-check form-check-inline form-switch mx-auto">
				  <input class="form-check-input" type="radio" name="grafica6" id="grafica6_1" value="1" disabled="disabled">
				  <label class="form-check-label" for="grafica6_1">Meses</label>
				</div>
		 </div>
		 <div class="mb-3">				
				<div class="form-check form-check-inline form-switch mx-5">
				  <input class="form-check-input" type="radio" name="grafica6" id="grafica6_2" value="2" checked>
				  <label class="form-check-label" for="grafica6_2">Delegación</label>
				</div>
			</div>			
		</div>
		<div class="col-12 my-3">
			<canvas id="SalidasAlternas" style="width:100%;max-height:305px"></canvas>
		</div>
	</div>
 </div>
 <div class="p-3 my-3 bg-body rounded shadow">
	<div class="row pt-4">		
		<div class="col-12 mb-5 text-center">
			<div class="mb-3">
				<div class="input-group w-25 mx-auto">
				  <label class="input-group-text" for="periodoI_7">Periodo del</label>
				  <input class="form-control periodoMask" type="text" id="periodoI_7" name="periodoI_7" placeholder="00/0000"
				   onblur="validar('7')">
				  <label class="input-group-text" for="periodoF_7">al</label>
				  <input class="form-control periodoMask" type="text" id="periodoF_7" name="periodoF_7" placeholder="00/0000"
				   onblur="validar('7')">
				</div>				
				<div class="form-check form-check-inline form-switch mx-auto">
				  <input class="form-check-input" type="radio" name="grafica7" id="grafica7_1" value="1" disabled="disabled">
				  <label class="form-check-label" for="grafica7_1">Meses</label>
				</div>
		 </div>
		 <div class="mb-3">				
				<div class="form-check form-check-inline form-switch mx-5">
				  <input class="form-check-input" type="radio" name="grafica7" id="grafica7_2" value="2" checked>
				  <label class="form-check-label" for="grafica7_2">Delegación</label>
				</div>
				<div class="form-check form-check-inline form-switch mx-5">
				  <input class="form-check-input" type="radio" name="grafica7" id="grafica7_3" value="3">
				  <label class="form-check-label" for="grafica7_3">Sexo</label>
				</div>
			</div>			
		</div>
		<div class="col-6 my-3">
			<canvas id="SentenciasCondenatorias" style="width:100%;max-height:305px"></canvas>
		</div>
		<div class="col-6 my-3">
			<canvas id="SentenciasJO" style="width:100%;max-height:305px"></canvas>
		</div>

	</div>
 </div> 
 <div class="p-3 my-3 bg-body rounded shadow">
	<div class="row pt-4">
		<div class="col-12 mb-5 text-center">
		 <div class="mb-3">
			<div class="input-group w-25 mx-auto">
			  <label class="input-group-text" for="periodoI_8">Periodo del</label>
			  <input class="form-control periodoMask" type="text" id="periodoI_8" name="periodoI_8" placeholder="00/0000"
			   onblur="validar('8')">
			  <label class="input-group-text" for="periodoF_8">al</label>
			  <input class="form-control periodoMask" type="text" id="periodoF_8" name="periodoF_8" placeholder="00/0000"
			   onblur="validar('8')">
			</div>				
			<div class="form-check form-check-inline form-switch mx-auto">
			  <input class="form-check-input" type="radio" name="grafica8" id="grafica8_1" value="1" disabled="disabled">
			  <label class="form-check-label" for="grafica8_1">Meses</label>
			</div>
			<div class="form-check form-check-inline form-switch mx-5">
			  <input class="form-check-input" type="radio" name="grafica8" id="grafica8_2" value="2" disabled="disabled">
			  <label class="form-check-label" for="grafica8_2">Año</label>
			</div>
		 </div>
		 <div class="mb-3">			
			<div class="form-check form-check-inline form-switch mx-5">
			  <input class="form-check-input" type="radio" name="grafica8" id="grafica8_3" value="3" checked>
			  <label class="form-check-label" for="grafica8_3">Delegación</label>
			</div>
		 </div>							
			<canvas id="MontoReparacion" style="width:100%;max-height:305px"></canvas>
		</div>
	</div>
 </div>
 <div class="p-3 my-3 bg-body rounded shadow">
	<div class="row pt-4">		
		<div class="col-12 mb-5 text-center">
			<div class="mb-3">
				<div class="input-group w-25 mx-auto">
				  <label class="input-group-text" for="periodoI_9">Periodo del</label>
				  <input class="form-control periodoMask" type="text" id="periodoI_9" name="periodoI_9" placeholder="00/0000"
				   onblur="validar('9')">
				  <label class="input-group-text" for="periodoF_9">al</label>
				  <input class="form-control periodoMask" type="text" id="periodoF_9" name="periodoF_9" placeholder="00/0000"
				   onblur="validar('9')">
				</div>
				<div class="form-check form-check-inline form-switch mx-auto">
				  <input class="form-check-input" type="radio" name="grafica9" id="grafica9_1" value="1" disabled="disabled">
				  <label class="form-check-label" for="grafica9_1">Meses</label>
				</div>
			</div>
			<div class="mb-3">				
				<div class="form-check form-check-inline form-switch mx-5">
				  <input class="form-check-input" type="radio" name="grafica9" id="grafica9_2" value="2" checked>
				  <label class="form-check-label" for="grafica9_2">Delegación</label>
				</div>
				<div class="form-check form-check-inline form-switch mx-5">
				  <input class="form-check-input" type="radio" name="grafica9" id="grafica9_3" value="3">
				  <label class="form-check-label" for="grafica9_3">Unidad de investigación</label>
				</div>
			</div>			
		</div>
		<div class="col-8 my-3">
			<canvas id="TipoDetencion" style="width:100%;max-height:305px"></canvas>
		</div>
		<div class="col-4 my-5">			
			<div class="text-center mb-3 btn btn-primary w-100"><p>TOTAL DE DETENCIONES LEGALES</p><span id="totDL">-</span></div>
			<div class="text-center mb-3 btn btn-primary w-100"><p>TOTAL DE DETENCIONES ILEGALES</p><span id="totDI">-</span></div>
		</div>
	</div>
 </div>
<script>
	$(".periodoMask").mask("00/0000");
	$(".periodoMask").on('blur', function() {
		var respuesta=false;
		var valor = $(this).val();
	    var partes = valor.split('/');

	    if (partes.length === 2) {
	        var mes = parseInt(partes[0], 10);
	        var ano = parseInt(partes[1], 10);

	        if (mes >= 1 && mes <= 12 && ano >= 1950 && ano <= 3000) {
	            respuesta=true;
	        }
	        $("[name=grafica"+$(this)[0].id.split("_")[1]+"]").prop('checked', false);
	    }
	    if (!respuesta) {$(this).val('');}
	});		
	function validar(idGrafica)
	{
		if($("#periodoI_"+idGrafica).val().length>0 && $("#periodoF_"+idGrafica).val().length>0)
		{
			$("#grafica"+idGrafica+"_1").attr("disabled",false);
			if (idGrafica==8) { $("#grafica"+idGrafica+"_2").attr("disabled",false); }
		}
		else
		{
			$("#grafica"+idGrafica+"_1").attr("disabled",true);
			if (idGrafica==8) { $("#grafica"+idGrafica+"_2").attr("disabled",false); }
		}
	}	
	let MyCarpetasIniciadasResuletasEnTramite;	
	let MyCarpetasConcluidasDeterminacion;
	let MyTotalDeterminaciones;
	let MyCarpetasJudicializadas;
	let MyCarpetasVinculadas;
	let MyCarpetasNoVinculadas;
	let MySalidasAlternas;
	let MySentenciasCondenatorias;
	let MySentenciasJO;
	let MyMontoReparacion;
	let MyTipoDetencion;

	$("[name=grafica1]").change(function(){		
		fillGrafica1(this.value);
	});
	$("[name=grafica2]").change(function(){		
		fillGrafica2(this.value);
	});
	$("[name=grafica3]").change(function(){		
		fillGrafica3(this.value);
	});	
	$("[name=grafica4]").change(function(){		
		fillGrafica4(this.value);
	});	
	$("[name=grafica5]").change(function(){		
		fillGrafica5(this.value);
	});	
	$("[name=grafica6]").change(function(){		
		fillGrafica6(this.value);
	});	
	$("[name=grafica7]").change(function(){		
		fillGrafica7(this.value);
	});	
	$("[name=grafica8]").change(function(){		
		fillGrafica8(this.value);
	});	
	$("[name=grafica9]").change(function(){		
		fillGrafica9(this.value);
	});		
	function CrearTabla(Chart)
	{
	 $("#tb"+$(Chart.canvas)[0].id).remove();
	 $("#div"+$(Chart.canvas)[0].id).remove();
	 $(Chart.canvas).after('<div style="overflow-x: auto;" id="div'+$(Chart.canvas)[0].id +'"><table id="tb'+$(Chart.canvas)[0].id +'" class="table" style="font-size: 9px;"><thead></thead><tbody></tbody></table></div>');
	 var tableBody = document.getElementById('tb'+$(Chart.canvas)[0].id).getElementsByTagName('tbody')[0];
	 var tableHead = document.getElementById('tb'+$(Chart.canvas)[0].id).getElementsByTagName('thead')[0];
	 var labels = Chart.data.labels;

	    // Clear existing rows
	    tableBody.innerHTML = '';
	    tableHead.innerHTML = '';				
	    // Add new rows based on chart data
		        var row = tableHead.insertRow(0);
		        var cell = row.insertCell(0);
		        cell.innerHTML = "";
	    for (var j = 1; j < labels.length+1; j++) {
		        var cell = row.insertCell(j);
		        cell.innerHTML = labels[j-1];
	    	}

	    for (var i = 0; i < Chart.data.datasets.length; i++) {
			var row = tableBody.insertRow(i);
			var cell = row.insertCell(0);
			cell.innerHTML = Chart.data.datasets[i].label;
		    for (var j = 1; j < labels.length+1; j++) {
		        var cell = row.insertCell(j);
		        cell.innerHTML = Chart.data.datasets[i].data[j-1];
		    }
		}		
	}		
	function fillGrafica1(desagregacion)
	{
	 if((desagregacion=="1" && $("#periodoI_1").val().length>0 && $("#periodoF_1").val().length>0)
	 	|| desagregacion>1){
		if (MyCarpetasIniciadasResuletasEnTramite) {
			MyCarpetasIniciadasResuletasEnTramite.destroy();
		}
	  var params = new Object();
	  params.desagregacion = desagregacion;
	  params.grafica = 1;
	  params.periodoI = $("#periodoI_1").val();
	  params.periodoF = $("#periodoF_1").val();
	  params._token = '{{csrf_token()}}';
	  params = JSON.stringify(params);
	  $.ajax({      
	      url: "{{Route('fillChart')}}",
	      type: "POST",
	      data: params,
	      contentType: "application/json; charset=utf-8",
	      dataType: 'json',
	      async: false,
	      success: function (result) {
          //console.log(result);
			MyCarpetasIniciadasResuletasEnTramite=new Chart("CarpetasIniciadasResuletasEnTramite", {
			  type: "line",
			  data: {
			    labels: result.xValues,
			    datasets: [
				    {
					  label: 'CONCLUIDAS',
				      data: result.yValues1,
				      fill: false,      
				      backgroundColor: "#415860",
				      borderColor:"#415860",
				      tension: 0.1
				    },
				    {
				    	label: 'EN TRÁMITE',
				      data: result.yValues2,
				      fill: false,      
				      backgroundColor: "#7E6D54",
				      borderColor:"#7E6D54",
				      tension: 0.1    
				    },			   
				    {
				    	label: 'INICIADAS',
				      data: result.yValues3,
				      fill: false,      
				      backgroundColor: "#A5A5A5",
				      borderColor:"#A5A5A5",
				      tension: 0.1    
				    },
			    ]
			  },
			  options: {
			    interaction: {
			      intersect: false,
			      mode: 'index',
			    },  	
			    responsive: true,	
				plugins: {							
				  	legend: {
				  		display: true, 
				  		position: 'bottom',
				        labels: {
			       		// This more specific font property overrides the global property
					        font: {
					            size: 10
					        }
				    	}
			        },
				    title: {
				      display: true,
				      text: "TOTAL DE CARPETAS INICIADAS, RESUELTAS Y EN TRÁMITE"
				    },
			    filler:{drawTime : 'beforeDraw'},	    
			    },
				scales: {
			      x: {
			        ticks: {font: {size:10}},
			        grid: {
			          display: true,
			          drawBorder: true,
			          drawOnChartArea: false,
			          drawTicks: false,
		        	}
			      },
			    }     
			  }
			});
			CrearTabla(MyCarpetasIniciadasResuletasEnTramite);
			
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
	        alert(textStatus + ": " + XMLHttpRequest.responseText);
	        }
	    });
	 }
	}
	function fillGrafica2(desagregacion)
	{
	 if((desagregacion=="1" && $("#periodoI_2").val().length>0 && $("#periodoF_2").val().length>0)
	 	|| desagregacion>1){		
		if (MyCarpetasConcluidasDeterminacion) {
			MyCarpetasConcluidasDeterminacion.destroy();
		}
	  var params = new Object();
	  params.desagregacion = desagregacion;
	  params.grafica = 2;
	  params.periodoI = $("#periodoI_2").val();
	  params.periodoF = $("#periodoF_2").val();	  
	  params._token = '{{csrf_token()}}';
	  params = JSON.stringify(params);
	  $.ajax({      
	      url: "{{Route('fillChart')}}",
	      type: "POST",
	      data: params,
	      contentType: "application/json; charset=utf-8",
	      dataType: 'json',
	      async: false,
	      success: function (result) {

          $("#totAT").text(result.totAT);
          $("#totDT").text(result.totDT);
          
			MyCarpetasConcluidasDeterminacion=new Chart('CarpetasConcluidasDeterminacion', {
			  type: "bar",
			  data: {
			    labels: result.xValues,
			    datasets: [
				    {
				    	label: 'ARCHIVO TEMPORAL',
				      backgroundColor: "#7E6D54",
				      data: result.yValues1
				    },{
				    	label: 'POR DETERMINACIÓN',
				      backgroundColor: "#415860",
				      data: result.yValues2
				    }
			    ]
			  },
			  options: {
			    interaction: {
			      intersect: false,
			      mode: 'index',
			    },  					  	
			    responsive: true,	
				plugins: {
			      legend: {
				  		display: true, 
				  		position: 'bottom',
				        labels: {
			       		// This more specific font property overrides the global property
					        font: {
					            size: 10
					        }
					    	}
			        },
			      title: {
			        display: true,
			        text: 'TOTAL DE CARPETAS CONCLUIDAS POR TIPO DE CONCLUSIÓN'
			      }
			    },
				scales: {
				      x: { stacked: true },
				      y: { stacked: true }

				    }    
			  }
			});
			CrearTabla(MyCarpetasConcluidasDeterminacion);
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
	        alert(textStatus + ": " + XMLHttpRequest.responseText);
	        }
	    });
	 }
	}
	function fillGrafica3(desagregacion)
	{
	 if((desagregacion=="1" && $("#periodoI_3").val().length>0 && $("#periodoF_3").val().length>0)
	 	|| desagregacion>1){		
		if (MyTotalDeterminaciones) {
			MyTotalDeterminaciones.destroy();
		}
	  var params = new Object();
	  params.desagregacion = desagregacion;
	  params.grafica = 3;
	  params.periodoI = $("#periodoI_3").val();
	  params.periodoF = $("#periodoF_3").val();	  
	  params._token = '{{csrf_token()}}';
	  params = JSON.stringify(params);
	  $.ajax({      
	      url: "{{Route('fillChart')}}",
	      type: "POST",
	      data: params,
	      contentType: "application/json; charset=utf-8",
	      dataType: 'json',
	      async: false,
	      success: function (result) {
          
			MyTotalDeterminaciones=new Chart('TotalDeterminaciones', {
			  type: "bar",
			  data: {
			    labels: result.xValues,
			    datasets: [
				    {
				    	label: 'DESISTIMIENTO',
				      backgroundColor: "#7E6D54",
				      data: result.yValues1
				    },
				    {
				    	label: 'ACUERDO REPARATORIO',
				      backgroundColor: "#415860",
				      data: result.yValues2
				    },
				    {
				    	label: 'FACULTAD DE ABSTENERSE DE INVESTIGAR',
				      backgroundColor: "#A5A5A5",
				      data: result.yValues3
				    },
				    {
				    	label: 'ARCHIVO TEMPORAL',
				      backgroundColor: "#7E6D54",
				      data: result.yValues4
				    },
				    {
				    	label: 'CRITERIO DE OPORTUNIDAD',
				      backgroundColor: "#415860",
				      data: result.yValues5
				    },
				    {
				    	label: 'NO EJERCICIO DE LA ACCIÓN PENAL',
				      backgroundColor: "#A5A5A5",
				      data: result.yValues6
				    },
				    {
				    	label: 'ACTO EQUIVALENTE',
				      backgroundColor: "#7E6D54",
				      data: result.yValues7
				    },
				    {
				    	label: 'INCOMPETENCIA',
				      backgroundColor: "#415860",
				      data: result.yValues8
				    },
				    {
				    	label: 'ACUMULACIÓN',
				      backgroundColor: "#A5A5A5",
				      data: result.yValues9
				    }
			    ]
			  },
			  options: {
			    interaction: {
			      intersect: false,
			      mode: 'index',
			    },  					  	
			    responsive: true,	
				plugins: {
				  	legend: {
				  		display: true, 
				  		position: 'bottom',
				        labels: {
			       		// This more specific font property overrides the global property
					        font: {
					            size: 10
					        }
					    	}
			        },
			      title: {
			        display: true,
			        text: 'TOTAL DE CARPETAS CONCLUIDAS POR TIPO DE CONCLUSIÓN'
			      }
			    },

			  }
			});	
			CrearTabla(MyTotalDeterminaciones);
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
	        alert(textStatus + ": " + XMLHttpRequest.responseText);
	        }
	    });
     }	  
	}
	function fillGrafica4(desagregacion)
	{
	 if((desagregacion=="1" && $("#periodoI_4").val().length>0 && $("#periodoF_4").val().length>0)
	 	|| desagregacion>1){		
		if (MyCarpetasJudicializadas) {
			MyCarpetasJudicializadas.destroy();
		}
	  var params = new Object();
	  params.desagregacion = desagregacion;
	  params.grafica = 4;
	  params.periodoI = $("#periodoI_4").val();
	  params.periodoF = $("#periodoF_4").val();	  
	  params._token = '{{csrf_token()}}';
	  params = JSON.stringify(params);
	  $.ajax({      
	      url: "{{Route('fillChart')}}",
	      type: "POST",
	      data: params,
	      contentType: "application/json; charset=utf-8",
	      dataType: 'json',
	      async: false,
	      success: function (result) {

          $("#totJD").text(result.totalCP);
          $("#totPJ").text(((result.totalCP/result.totalExp)*100).toFixed(3)+"%");
          
			MyCarpetasJudicializadas=new Chart('CarpetasJudicializadas', {
			  type: "bar",
			  data: {
			    labels: result.xValues,
			    datasets: [
				    {
				    	label: 'CARPETAS JUDICIALIZADAS',
				      backgroundColor: "#415860",
				      data: result.yValues1
				    }
			    ]
			  },
			  options: {
			    interaction: {
			      intersect: false,
			      mode: 'index',
			    },  					  	
			    responsive: true,	
				plugins: {
			      legend: {
				  		display: false, 
			        },
			      title: {
			        display: true,
			        text: 'TOTAL DE CARPETAS JUDICIALIZADAS'
			      }
			    },
				scales: {
				      x: { stacked: true },
				      y: { stacked: true }

				    }    
			  }
			});
			CrearTabla(MyCarpetasJudicializadas);
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
	        alert(textStatus + ": " + XMLHttpRequest.responseText);
	        }
	    });
	 }
	}
	function fillGrafica5(desagregacion)
	{
	 if((desagregacion=="1" && $("#periodoI_5").val().length>0 && $("#periodoF_5").val().length>0)
	 	|| desagregacion>1){	
		if (MyCarpetasVinculadas) {
			MyCarpetasVinculadas.destroy();
		}
	
		if (MyCarpetasNoVinculadas) {
			MyCarpetasNoVinculadas.destroy();
		}
	  var params = new Object();
	  params.desagregacion = desagregacion;
	  params.grafica = 5;
	  params.periodoI = $("#periodoI_5").val();
	  params.periodoF = $("#periodoF_5").val();	  
	  params._token = '{{csrf_token()}}';
	  params = JSON.stringify(params);
	  $.ajax({      
	      url: "{{Route('fillChart')}}",
	      type: "POST",
	      data: params,
	      contentType: "application/json; charset=utf-8",
	      dataType: 'json',
	      async: false,
	      success: function (result) {

			MyCarpetasVinculadas=new Chart('CarpetasVinculadas', {
			  type: "bar",
			  data: {
			    labels: result.xValues,
			    datasets: [
				    {
				    	label: 'CARPETAS VINCULADAS',
				      backgroundColor: "#415860",
				      data: result.yValues1
				    }
			    ]
			  },
			  options: {
			    interaction: {
			      intersect: false,
			      mode: 'index',
			    },  					  	
			    responsive: true,	
					plugins: {
			      legend: {
				  		display: false, 
			        },
			      title: {
			        display: true,
			        text: 'TOTAL DE CARPETAS VINCULADAS A PROCESO'
			      }
			    },
			  }
			});	          
			CrearTabla(MyCarpetasVinculadas);
			MyCarpetasNoVinculadas=new Chart('CarpetasNoVinculadas', {
			  type: "bar",
			  data: {
			    labels: result.xValues,
			    datasets: [
				    {
				    	label: 'CARPETAS NO VINCULADAS',
				      backgroundColor: "#415860",
				      data: result.yValues2
				    }
			    ]
			  },
			  options: {
			    interaction: {
			      intersect: false,
			      mode: 'index',
			    },  					  	
			    responsive: true,	
					plugins: {
			      legend: {
				  		display: false, 
			        },
			      title: {
			        display: true,
			        text: 'TOTAL DE CARPETAS NO VINCULADAS A PROCESO'
			      }
			    },
			  }
			});
			CrearTabla(MyCarpetasNoVinculadas);
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
	        alert(textStatus + ": " + XMLHttpRequest.responseText);
	        }
	    });
	 }
	}
	function fillGrafica6(desagregacion)
	{
	 if((desagregacion=="1" && $("#periodoI_6").val().length>0 && $("#periodoF_6").val().length>0)
	 	|| desagregacion>1){		
		if (MySalidasAlternas) {
			MySalidasAlternas.destroy();
		}
	  var params = new Object();
	  params.desagregacion = desagregacion;
	  params.grafica = 6;
	  params.periodoI = $("#periodoI_6").val();
	  params.periodoF = $("#periodoF_6").val();	  
	  params._token = '{{csrf_token()}}';
	  params = JSON.stringify(params);
	  $.ajax({
	      url: "{{Route('fillChart')}}",
	      type: "POST",
	      data: params,
	      contentType: "application/json; charset=utf-8",
	      dataType: 'json',
	      async: false,
	      success: function (result) {

          // $("#totAT").text(result.totAT);
          // $("#totDT").text(result.totDT);
          
			MySalidasAlternas=new Chart('SalidasAlternas', {
			  type: "bar",
			  data: {
			    labels: result.xValues,
			    datasets: [
				    {
				    	label: 'TOTAL DE SALIDAS ALTERNAS',
				      backgroundColor: "#785215",
				      data: result.yValues1,
				      stack: 'Stack 0',
				    },{
				    	label: 'SUSPENSIÓN CONDICIONAL',
				      backgroundColor: "#7E6D54",
				      data: result.yValues2,
				      stack: 'Stack 1',
				    },{
				    	label: 'ACUERDOS REPARATORIOS INMEDIATO',
				      backgroundColor: "#415860",
				      data: result.yValues3,
				      stack: 'Stack 1',
				    },{
				    	label: 'ACUERDOS REPARATORIOS DIFERIDO',
				      backgroundColor: "#A5A5A5",
				      data: result.yValues4,
				      stack: 'Stack 1',
				    }
			    ]
			  },
			  options: {
			    interaction: {
			      intersect: false,
			      mode: 'index',
			    },  					  	
			    responsive: true,	
					plugins: {
			      legend: {
				  		display: true, 
				  		position: 'bottom',
				        labels: {
			       		// This more specific font property overrides the global property
					        font: {
					            size: 10
					        }
					    	}
			        },
			      title: {
			        display: true,
			        text: 'TOTAL DE SALIDAS ALTERNAS POR TIPO'
			      }
			    },
					scales: {
				      x: { stacked: true },
				      y: { stacked: true }

				    }    
			  }
			});
			CrearTabla(MySalidasAlternas);
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
	        alert(textStatus + ": " + XMLHttpRequest.responseText);
	        }
	    });
	 }
	}
	function fillGrafica7(desagregacion)
	{
	 if((desagregacion=="1" && $("#periodoI_7").val().length>0 && $("#periodoF_7").val().length>0)
	 	|| desagregacion>1){		
		if (MySentenciasCondenatorias) {
			MySentenciasCondenatorias.destroy();
		}
		if (MySentenciasJO) {
			MySentenciasJO.destroy();
		}
	  var params = new Object();
	  params.desagregacion = desagregacion;
	  params.grafica = 7;
	  params.periodoI = $("#periodoI_7").val();
	  params.periodoF = $("#periodoF_7").val();	  
	  params._token = '{{csrf_token()}}';
	  params = JSON.stringify(params);
	  $.ajax({
	      url: "{{Route('fillChart')}}",
	      type: "POST",
	      data: params,
	      contentType: "application/json; charset=utf-8",
	      dataType: 'json',
	      async: false,
	      success: function (result) {
          
			MySentenciasCondenatorias=new Chart('SentenciasCondenatorias', {
			  type: "bar",
			  data: {
			    labels: result.xValues,
			    datasets: [
				    {
				    	label: 'TOTAL DE SENTENCIAS CONDENATORIAS',
				      backgroundColor: "#7E6D54",
				      data: result.yValues1,
				      stack: 'Stack 0',
				    },{
				    	label: 'SENTENCIAS CONDENATORIAS  EN PROCEDIMIENTO ABREVIADO',
				      backgroundColor: "#415860",
				      data: result.yValues2,
				      stack: 'Stack 1',
				    },{
				    	label: 'SENTENCIAS CONDENATORIAS EN JUICIO ORAL',
				      backgroundColor: "#A5A5A5",
				      data: result.yValues3,
				      stack: 'Stack 1',
				    }
			    ]
			  },
			  options: {
			    interaction: {
			      intersect: false,
			      mode: 'index',
			    },  					  	
			    responsive: true,	
					plugins: {
			      legend: {
				  		display: true, 
				  		position: 'bottom',
				        labels: {
			       		// This more specific font property overrides the global property
					        font: {
					            size: 10
					        }
					    	}
			        },
			      title: {
			        display: true,
			        text: 'TOTAL DE SENTENCIAS CONDENATORIAS'
			      }
			    },
					scales: {
				      x: { stacked: true },
				      y: { stacked: true }

				    }    
			  }
			});
			CrearTabla(MySentenciasCondenatorias);          
			MySentenciasJO=new Chart('SentenciasJO', {
			  type: "bar",
			  data: {
			    labels: result.xValues,
			    datasets: [
				    {
				    	label: 'TOTAL DE SENTENCIAS POR JUICIO ORAL',
				      backgroundColor: "#7E6D54",
				      data: result.yValues4,
				      stack: 'Stack 0',
				    },{
				    	label: 'CONDENATORIAS',
				      backgroundColor: "#415860",
				      data: result.yValues5,
				      stack: 'Stack 1',
				    },{
				    	label: 'ABSOLUTORIAS',
				      backgroundColor: "#A5A5A5",
				      data: result.yValues6,
				      stack: 'Stack 1',
				    }
			    ]
			  },
			  options: {
			    interaction: {
			      intersect: false,
			      mode: 'index',
			    },  					  	
			    responsive: true,	
					plugins: {
			      legend: {
				  		display: true, 
				  		position: 'bottom',
				        labels: {
			       		// This more specific font property overrides the global property
					        font: {
					            size: 10
					        }
					    	}
			        },
			      title: {
			        display: true,
			        text: 'TOTAL DE SENTENCIAS POR JUICIO ORAL POR TIPO'
			      }
			    },
					scales: {
				      x: { stacked: true },
				      y: { stacked: true }

				    }    
			  }
			});
			CrearTabla(MySentenciasJO);
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
	        alert(textStatus + ": " + XMLHttpRequest.responseText);
	        }
	    });
	 }
	}	
	function fillGrafica8(desagregacion)
	{
	 if(((desagregacion=="1" || desagregacion=="2") && $("#periodoI_8").val().length>0 && $("#periodoF_8").val().length>0)
	 	|| desagregacion>2){	
		if (MyMontoReparacion) {
			MyMontoReparacion.destroy();
		}
	  var params = new Object();
	  params.desagregacion = desagregacion;
	  params.grafica = 8;
	  params.periodoI = $("#periodoI_8").val();
	  params.periodoF = $("#periodoF_8").val();	  
	  params._token = '{{csrf_token()}}';
	  params = JSON.stringify(params);
	  $.ajax({      
	      url: "{{Route('fillChart')}}",
	      type: "POST",
	      data: params,
	      contentType: "application/json; charset=utf-8",
	      dataType: 'json',
	      async: false,
	      success: function (result) {

			MyMontoReparacion=new Chart('MontoReparacion', {
			  type: "bar",
			  data: {
			    labels: result.xValues,
			    datasets: [
				    {
				    	label: 'MONTO RECABADO',
				      backgroundColor: "#7E6D54",
				      data: result.yValues1
				    }
			    ]
			  },
			  options: {
			    interaction: {
			      intersect: false,
			      mode: 'index',
			    },  					  	
			    responsive: true,	
				plugins: {
			      legend: {
				  		display: false, 
			        },
			      title: {
			        display: true,
			        text: 'TOTAL DEL MONTO RECABADO POR REPARACIÓN DEL DAÑO'
			      }
			    },
			  }
			});
			CrearTabla(MyMontoReparacion);
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
	        alert(textStatus + ": " + XMLHttpRequest.responseText);
	        }
	    });
	 }
	}
	function fillGrafica9(desagregacion)
	{
	 if((desagregacion=="1" && $("#periodoI_9").val().length>0 && $("#periodoF_9").val().length>0)
	 	|| desagregacion>1){		
		if (MyTipoDetencion) {
			MyTipoDetencion.destroy();
		}
	  var params = new Object();
	  params.desagregacion = desagregacion;
	  params.grafica = 9;
	  params.periodoI = $("#periodoI_9").val();
	  params.periodoF = $("#periodoF_9").val();	  
	  params._token = '{{csrf_token()}}';
	  params = JSON.stringify(params);
	  $.ajax({      
	      url: "{{Route('fillChart')}}",
	      type: "POST",
	      data: params,
	      contentType: "application/json; charset=utf-8",
	      dataType: 'json',
	      async: false,
	      success: function (result) {

          $("#totDL").text(result.totDL);
          $("#totDI").text(result.totDI);
          
			MyTipoDetencion=new Chart('TipoDetencion', {
			  type: "bar",
			  data: {
			    labels: result.xValues,
			    datasets: [
				    {
				    	label: 'DETENCIONES LEGALES',
				      backgroundColor: "#7E6D54",
				      data: result.yValues1
				    },{
				    	label: 'DETENCIONES ILEGALES',
				      backgroundColor: "#415860",
				      data: result.yValues2
				    }
			    ]
			  },
			  options: {
			    interaction: {
			      intersect: false,
			      mode: 'index',
			    },  					  	
			    responsive: true,	
				plugins: {
			      legend: {
				  		display: true, 
				  		position: 'bottom',
				        labels: {
			       		// This more specific font property overrides the global property
					        font: {
					            size: 10
					        }
					    	}
			        },
			      title: {
			        display: true,
			        text: 'TOTAL DE DETENIDOS POR TIPO DE DETENCIÓN'
			      }
			    },
				scales: {
				      x: { stacked: true },
				      y: { stacked: true }

				    }    
			  }
			});
			CrearTabla(MyTipoDetencion);
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
	        alert(textStatus + ": " + XMLHttpRequest.responseText);
	        }
	    });
	 }
	}
	fillGrafica1($("[name=grafica1]:checked").val());
	fillGrafica2($("[name=grafica2]:checked").val());
	fillGrafica3($("[name=grafica3]:checked").val());
	fillGrafica4($("[name=grafica4]:checked").val());
	fillGrafica5($("[name=grafica5]:checked").val());
	fillGrafica6($("[name=grafica6]:checked").val());
	fillGrafica7($("[name=grafica7]:checked").val());
	fillGrafica8($("[name=grafica8]:checked").val());
	fillGrafica9($("[name=grafica9]:checked").val());	

 //
	// var xValues = ["SURESTE", "LAGUNA I", "LAGUNA II", "CENTRO", "CARBONIFERA", "NORTE I", "NORTE II", "COE SURESTE", "COE LAGUNA"];
	// var yValues1 = [2120328,5650560,501946,2129732,223729,670908,10800,0,0];
	// var yValues2 = [4676195,8722513,966531,624174,376187,568899,166540,0,0];
	// var yValues3 = [4676195,8722513,10,624174,376187,568899,166540,624174,10];
	


	// var xValues = ["SURESTE", "LAGUNA I", "LAGUNA II", "CENTRO", "CARBONIFERA", "NORTE I", "NORTE II", "COE SURESTE", "COE LAGUNA"];
	// var yValues = [1329,1789,509,952,635,813,796,561,602,];
	// var barColors = "#7E6D54";//["red", "green","blue","orange","brown"];
	//  new Chart('CarpetasIniciadasDelegacion', {
	//   type: "bar",
	//   data: {
	//     labels: xValues,
	//     datasets: [{
	//       backgroundColor: barColors,
	//       data: yValues
	//     }]
	//   },
	//   options: {
	//   	indexAxis: 'y',
	//     responsive: true,	
	// 	plugins: {
	//       legend: {
	//         display: false,
	//       },
	//       title: {
	//         display: true,
	//         text: 'Total de carpetas iniciadas por delegación'
	//       }
	//     },
	// 	scales: {
	// 	      x: {
	// 	        ticks: {
	//   	          beginAtZero: true,
	// 			// // For a category axis, the val is the index so the lookup via getLabelForValue is needed
	// 			//           callback: function(val, index) {
	// 			//             // Hide every 2nd tick label
	// 			//             return index % 2 === 0 ? this.getLabelForValue(val) : '';
	// 			//           },
	// 	          //stepSize: 200,
	// 	          font: {size:10}          
	// 	        },        
	// 	      },
	// 	      y:{
	// 	        grid: {
	// 	          display: true,
	// 	          drawBorder: true,
	// 	          drawOnChartArea: false,
	// 	          drawTicks: true,
	//         	}		      	
	// 	      }

	// 	    }    
	//   }
	// });
           
	// var xValues = ["SURESTE", "LAGUNA I", "LAGUNA II", "CENTRO", "CARBONIFERA", "NORTE I", "NORTE II", "COE SURESTE", "COE LAGUNA"];
	// var yValues1 = [725,1089,78,282,155,111,49,7,4];
	// var yValues2 = [321,922,78,165,154,111,48,7,4];
	// var yValues3 = [404,167,0,117,1,0,1,0,0];

	// 	  //   if (MyCarpetasIniciadasDelegacion) {
  //   //     MyCarpetasIniciadasDelegacion.destroy();
  //   // }
	// new Chart("CarpetasConcluidasDelegacion", {
	//   type: "line",
	//   data: {
	//     labels: xValues,
	//     datasets: [
	// 		{
	// 	      label: 'ARCHIVO TEMPORAL',
	// 	      data: yValues3,
	// 	      fill: true,      
	// 	      backgroundColor: "#BFA377",
	// 	      borderColor:"#BFA377",
	// 	      tension: 0.1     
	// 	    }, 
	// 	    {
	// 	    	label: 'POR DETERMINACIÓN',
	// 	      data: yValues2,
	// 	      fill: true,      
	// 	      backgroundColor: "#7E6D54",
	// 	      borderColor:"#7E6D54",
	// 	      tension: 0.1      
	// 	    },	    
	// 	    {
	// 		  label: 'TOTAL DE CARPETAS CONCLUIDAS',
	// 	      data: yValues1,
	// 	      fill: true,      
	// 	      backgroundColor: "#415860",
	// 	      borderColor:"#415860",
	// 	      tension: 0.1
	// 	    },	
	//     ]
	//   },
	//   options: {
	//     interaction: {
	//       intersect: false,
	//       mode: 'index',
	//     },  	
	//     responsive: true,	
	// 	plugins: {
	// 	  	legend: {
	// 	  		display: true, 
	// 	  		position: 'bottom',
	// 	        labels: {
	//        		// This more specific font property overrides the global property
	// 		        font: {
	// 		            size: 10
	// 		        }
	// 		    }
	//         },
	// 	    title: {
	// 	      display: true,
	// 	      text: "Total de carpetas concluidas por tipo de conclusión"
	// 	    },
	//     filler:{drawTime : 'beforeDraw'},	    
	//     },
	// 	scales: {
	// 	      x: {
	// 	        ticks: {font: {size:8}},
	// 	        grid: {
	// 	          display: true,
	// 	          drawBorder: true,
	// 	          drawOnChartArea: false,
	// 	          drawTicks: false,
	//         	}
	// 	      },
	// 	    }     
	//   }
	// });

	// var xValues = ["CONDENATORIA", "ABSOLUTORIA"];
	// var yValues = [10,30,];
	// var barColors = ["#415860","#0A324A",];
	// function handleHover(evt, item, legend) {
	//   legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
	//     colors[index] = index === item.index || color.length === 9 ? color : color + '4D';
	//   });
	//   legend.chart.update();
	// }
	// function handleLeave(evt, item, legend) {
	//   legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
	//     colors[index] = color.length === 9 ? color.slice(0, -2) : color;
	//   });
	//   legend.chart.update();
	// }
	// new Chart("SentenciasObtenidas", {
	//   type: "pie",
	//   data: {
	//     labels: xValues,
	//     datasets: [{
	//       backgroundColor: barColors,
	//       data: yValues
	//     }]
	//   },
	//   options: {
	//     responsive: true,	
	// 	plugins: {
	//       legend: {display: true, position: 'bottom',
	// 	        onHover: handleHover,
	// 	        onLeave: handleLeave	            
	// 	        },
	//       title: {
	//         display: true,
	//         text: 'Porcentaje de sentencias obtenidas por tipo de sentencia'
	//       }
	//     },
	//   }
	// });
 //

</script>

 @stop 
 @section('indexTDE')
 <div class="p-3 bg-body rounded shadow">
<div class="mb-4 col-12 pestanaBase">
  <div class="pestanaTop">
    <h4>INEGI</h4>
  </div>
</div> 
	<form method='post' id="frmDwnINEGI" action="{{ route('exportarINEGI') }}" enctype="multipart/form-data">
	@csrf
		<div class="row pt-4">
		 <div class="mb-3 col-sm-12 col-md-6 col-lg-4">		
			<div class="form-group mb-3">
			  <select class="form-select" name="anio" id="anio">
			    <option selected disabled value="0">Año de descarga:</option>
			    <option value="2023">2023</option>
			  </select>
				@if($errors->has('anio'))
					<span class="text-danger">{{ $errors->first('anio') }}</span>
				@endif
			</div>	
		 </div>			

		 <div class="mb-3 col-sm-12 col-md-6 col-lg-4">		
			<div class="form-group mb-3">
			  <select class="form-select" name="parte" id="parte">
			    <option selected disabled value="0">Partición de la descarga:</option>
			    @for($i=1;$i<=41;$i++)
			    <option value="INEGI{{$i}}">Parte {{$i}}</option>
			    @endfor		    
			  </select>
				@if($errors->has('anio'))
					<span class="text-danger">{{ $errors->first('parte') }}</span>
				@endif
			</div>	
		 </div>	
		 <div class="mb-3 col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-center">		 
	     	<button type="button" onclick="javascript:descargarTabla()" class="btn btn-primary btn-sm">Descargar</button>
	 	 </div>
		</div>  
	</form>

<div class="mb-4 col-12 pestanaBase">
  <div class="pestanaTop">
    <h4>SESNSP</h4>
  </div>
</div> 	
	<form method='post' id="frmDwnSESNSP" action="{{ route('exportarINEGI') }}" enctype="multipart/form-data">
	@csrf
		<div class="row pt-4">
		 <div class="mb-3 col-sm-12 col-md-6 col-lg-4">		
			<div class="form-group mb-3">
			  <select class="form-select" name="anio2" id="anio2">
			    <option selected disabled value="0">Año de descarga:</option>
			    <option value="2023">2023</option>
			  </select>
				@if($errors->has('anio2'))
					<span class="text-danger">{{ $errors->first('anio2') }}</span>
				@endif
			</div>	
		 </div>			

		 <div class="mb-3 col-sm-12 col-md-6 col-lg-4">		
			<div class="form-group mb-3">
			  <select class="form-select" name="parte2" id="parte2">
			    <option selected disabled value="0">Partición de la descarga:</option>
			    <option value="SESNSP1">Parte 1</option>
			    <!-- <option value="SESNSP2">Parte 2</option>
			    <option value="SESNSP3">Parte 3</option>
			    <option value="SESNSP4">Parte 4</option>
			    <option value="SESNSP5">Parte 5</option>
			    <option value="SESNSP6">Parte 6</option>
			    <option value="SESNSP7">Parte 7</option> -->
			  </select>
				@if($errors->has('parte2'))
					<span class="text-danger">{{ $errors->first('parte2') }}</span>
				@endif
			</div>	
		 </div>	
		 <div class="mb-3 col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-center">		 
	     	<button type="button" onclick="javascript:descargarTabla2()" class="btn btn-primary btn-sm">Descargar</button>
	 	 </div>
		</div>  
	</form>	
</div>
 @stop 
 @section('indexDDE')
<div class="p-3 bg-body rounded shadow">
	<div class="mb-4 col-12 pestanaBase">
	  <div class="pestanaTop">
	    <h4>Descargar base general de los datos</h4>
	  </div>
	</div> 	 	
	<form method='post' id="frmDwnExcel" action="{{ route('exportarDatos') }}" enctype="multipart/form-data">
	@csrf
		<div class="row pt-4">
		 <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="fechaInicio" class="form-label">Rango inicial:</label>
		  <input type="date" class="form-control busqueda" name="fechaInicio" id="fechaInicio">
			@if($errors->has('fechaInicio'))
				<span class="text-danger">{{ $errors->first('fechaInicio') }}</span>
			@endif
		 </div>
		 <div class="mb-3 col-sm-12 col-md-6 col-lg-4">
		  <label for="fechaFin" class="form-label">Rango final:</label>
		  <input type="date" class="form-control busqueda" name="fechaFin" id="fechaFin">
			@if($errors->has('fechaFin'))
				<span class="text-danger">{{ $errors->first('fechaFin') }}</span>
			@endif
		 </div>
		 <div class="mb-3 col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-center">		 
	     	<button type="button" onclick="javascript:descargar()" class="btn btn-primary btn-sm">Descargar</button>
	 	 </div>
		</div>  
	</form>
</div>
 @stop 


@section('script')
	<script type="text/javascript">
	 function descargarTabla()
	 {
	 	if ($("#anio :selected").val()!=0 && $("#parte :selected").val()!=0) {
			$("#frmDwnINEGI").submit();
		}
		else
		{showtoast('Alguno de los filtros no tiene un valor válido','danger');}
	 }
 	 function descargarTabla2()
	 {
	 	if ($("#anio2 :selected").val()!=0 && $("#parte2 :selected").val()!=0) {
			$("#frmDwnSESNSP").submit();
		}
		else
		{showtoast('Alguno de los filtros no tiene un valor válido','danger');}
	 }
	 function descargar()
	 {
	 	if ($("#fechaInicio").val().trim().length>0 && $("#fechaFin").val().trim().length>0) {
			$("#frmDwnExcel").submit();
		}
		else		
		{showtoast('Alguno de los filtros no tiene un valor válido','danger');}
	 }



	</script>
 @stop

 