<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\SupervisorController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//     return view('inicio.main');
// })->name('main');
// Route::view('/','inicio.main')->name('main');
// Route::get('login',function () {
//     return view('inicio.login');
// })->name('login');
Route::view('/','inicio.login')->name('login');
//Route::view('/','inicio.login')->name('login');

Route::controller(InicioController::class)->group(function(){
    Route::get('IniciarSesion','index')->name('index');
    Route::get('Registrarse', 'registration')->name('registration');
    Route::get('Salir', 'logout')->name('logout');
    Route::post('ValidarRegistro','validate_registration')->name('Inicio.validate_registration');
    Route::post('ValidarEntrada', 'validate_login')->name('Inicio.validate_login');
    Route::get('Inicio', 'dashboard')->name('dashboard');
    Route::post('importdata', 'importData')->name('inicio.importdata');
    Route::post('validateandimportdata', 'validateAndImportdata')->name('inicio.validateandimportdata');    
    Route::post('importexcel', 'importExcel')->name('inicio.importExcel');
     Route::get('o8w5qe93s','listadoExpedientes')->name('listado');
    Route::post('o8w5qe93s','listadoExpedientes')->name('listado');    
});
Route::controller(SupervisorController::class)->group(function(){
     Route::get('o8w5qe9w04','listadoExpedientesSuper')->name('listado.super');
    Route::post('o8w5qe9w04','listadoExpedientesSuper')->name('listado.super');
     Route::get('3w5qe8w58dq','estadistica')->name('estadistica.super');
    Route::post('3w5qe8w58dq','estadistica')->name('estadistica.super');    
     Route::get('e35qoo3/{tb}/{idExp}','detalleExpedientesSuper')->name('detalle.super');
    Route::post('correccion','correccionExpedientesSuper')->name('correccion.super');
    Route::post('validacion','validacionExpedientesSuper')->name('validacion.super');
    Route::post('redirigir','redirigirExpedientesSuper')->name('redirect.super');

    Route::post('reasignar','reasignar')->name('reasignarExp');

    Route::post('fillChart','GraficaPorDesagregacion')->name('fillChart');
    Route::post('exportar', 'exportDE_DG')->name('exportarDatos');
    Route::post('exportarinegi', 'exportINEGI')->name('exportarINEGI');
});

Route::controller(DashboardController::class)->group(function(){
  #region Index
    Route::get('eqwyg9q4e/{Ctrl}/{idExp?}/{idCausa?}','index')->name('dash');
  #endregion  
    Route::post('GuardarDatos','Guardar')->name('save');
    Route::post('GuardarDatosCP','GuardarCP')->name('saveCP');
    Route::post('SolcitarRevisionSup','SolcitarRevision')->name('revision');

  #region AJAX calls
    Route::post('getMunDel','GetMunicipiosByDelegacion')->name('getM');
    Route::post('loadAddDelitos','CargarAddDelitos')->name('addDelitos');
    Route::post('loadAddVicitmas','CargarAddVictimas')->name('addVictimas');
    Route::post('loadAddObjetos','CargarAddObjetos')->name('addObjetos');   
    Route::post('loadAddImputados','CargarAddImputados')->name('addImputados'); 
    Route::post('loadAddRelacion','CargarAddRelacion')->name('addRelacion'); 
    Route::post('getDelitosG','GetDelitosByOrdenamiento')->name('delitosG');
    Route::post('getDelitosE','GetDelitosByGeneral')->name('delitosE');
    Route::post('getDelitosJUR','GetDelitosByOrdenamientoJUR')->name('delitosJUR');
    Route::post('getMunEnt','GetMunicipiosByEntidad')->name('getME');
    Route::post('getCol','GetColoniasByMunicipios')->name('getCol');
    Route::post('loadCausas','CargarCausas')->name('Causas');

    Route::post('BuscarRelacionDE','BuscarRelacion')->name('buscarR');

    Route::post('deleteCausasData','eliminarDatosCP')->name('delDataCP');
    Route::post('deleteDatosExpedienteData','eliminarDatosDE')->name('delDataDE');
    #region validaciones
      Route::post('valCausas','ValidarCausasDuplicadas')->name('CausasDuplicadas');
      Route::post('valRelacion','ValidarRelacionDuplicadas')->name('RelacionDuplicadas');
      Route::post('buscarCausa','BuscarCP')->name('BuscarCausaPenal');
    #endregion
    Route::post('editarMASC_CP','EditarMASC_CP')->name('editarMASC_CP');
    Route::post('eliminarMASC_CP','EliminarMASC_CP')->name('eliminarMASC_CP');
  #endregion
});
