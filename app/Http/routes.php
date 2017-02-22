<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('auth/login', 'Auth\AuthController@getLogin')->name('login');
Route::post('auth/login', ['as' =>'login', 'uses' => 'UsuariosController@loginModal']);
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

Route::get('auth/modalLogin', 'Auth\AuthController@login')->name('myLoginModal');
Route::post('loginmodal','UsuariosController@loginModal')->name('loginModal');



Route::group(['middleware' => ['auth', 'superAdmin']], function () {
    Route::get('superAdmin','SuperAdminController@index')->name('superAdmin');
    Route::get('registrarsitio','SuperAdminController@registrarSitio')->name('registrarSitio');
    Route::post('addSitio','SuperAdminController@addSitio')->name('addSitio');

    Route::post('addCancha','SuperAdminController@addCancha')->name('addCancha');
    Route::post('removeCancha','SuperAdminController@removeCancha')->name('removeCancha');
    Route::post('cambiarTipoCancha','SuperAdminController@cambiarTipoCancha')->name('cambiarTipoCancha');


    Route::get('sitiosRegistrados','SuperAdminController@sitiosRegistrados')->name('sitiosRegistrados');
    Route::get('modalHistorialPagos/{id}','SuperAdminController@modalHistorialPagos')->name('modalHistorialPagos');
    Route::get('modalDetallesSitio/{id}','SuperAdminController@modalDetallesSitio')->name('modalDetallesSitio');
    Route::get('modalEditarCanchas/{id}','SuperAdminController@modalEditarCanchas')->name('modalEditarCanchas');
    Route::post('addPago','SuperAdminController@addPago')->name('addPago');
    Route::post('pagosTorneoUser','SuperAdminController@pagosTorneoUser')->name('pagosTorneoUser');

    Route::get('superTorneos','SuperAdminController@superTorneos')->name('superTorneos');

    Route::get('autoCompleUser','SuperAdminController@autoCompleUser')->name('autoCompleUser');



});

Route::group(['middleware' => ['auth', 'administrador']], function () {
    Route::get('administrador','AdministradorController@index')->name('administrador');
    Route:: POST('administrador/editDesc', 'AdministradorController@editarDescripcion')->name('editarDescripcion');
    Route:: post('administrador/borarImagen', 'AdministradorController@deleteImage')->name('deleteImage');
    Route::post('administrador/subirimagen', 'AdministradorController@subirImagen')->name('subirImagen');
    Route::get('administrador/horarios', 'AdministradorController@editHorarios')->name('editHorarios');
    Route::get('adminCanchas','AdministradorController@adminCanchas')->name('adminCanchas');
    Route::post('imagenCancha', 'AdministradorController@updateImagenCancha')->name('updateImagenCancha');
    Route::get('reservasYsanciones','AdministradorController@disponibilidades')->name('reservasysanciones');
    Route::post('getDisponibilidad','AdministradorController@getDisponibilidad')->name('getDisponibilidad');
    Route::post('addInfoCanchas','AdministradorController@addInfoCanchas')->name('addInfoCanchas');
    Route::post('addNuevaReserva','AdministradorController@addNuevaReserva')->name('addNuevaReserva');
    Route::post('infoCancelarReserva','AdministradorController@infoCancelarReserva')->name('infoCancelarReserva');
    Route::post('cancelarReserva','AdministradorController@cancelarReserva')->name('cancelarReserva');
    Route::post('buscarAddToken','AdministradorController@buscarAddToken')->name('buscarAddToken');
    Route::post('addToken','AdministradorController@addToken')->name('addToken');
    Route::post('retirarToken','AdministradorController@retirarToken')->name('retirarToken');
    Route::get('infoToken/{id}','AdministradorController@infoToken')->name('infoToken');
    Route::get('adminTokens','AdministradorController@adminTokens')->name('adminTokens');
    Route::post('imagenperfil', 'AdministradorController@updateProfilePic')->name('updateProfilePic');
    Route::post('autoCompleUsuarios','AdministradorController@autoCompleUsuarios')->name('autoCompleUsuarios');
    Route::post('editHorario', 'AdministradorController@updateHorario')->name('updateHorario');
    Route::post('ubicacion', 'AdministradorController@updateUbicacion')->name('updateUbicacion');
    Route::post('servicios', 'AdministradorController@updateServicio')->name('updateServicio');
    Route::post('socialUpdate', 'AdministradorController@updateRedes')->name('updateRedes');
    Route::get('disponibilidades','AdministradorController@planilla')->name('planilla');
    Route::post('getPlanillas','AdministradorController@getPlanillas')->name('getPlanillas');


});

Route::group(['middleware' => ['auth']], function () {
    Route::get('perfilUsuario','UsuariosController@perfilUsuario')->name('perfilUsuario');

    Route::post('solicidarPago','TorneosController@solicidarPago')->name('solicidarPago');


    Route::get('adminTorneos','TorneosController@index')->name('adminTorneos');
    Route::get('nuevoTorneo','TorneosController@torneoNuevo')->name('torneoNuevo');
    Route::post('insertTorneo','TorneosController@insertTorneo')->name('insertTorneo');
    Route::post('deleteTorneo','TorneosController@deleteTorneo')->name('deleteTorneo');
    Route::get('adminTorneo/{id}','TorneosController@adminTorneo')->name('adminTorneo');
    Route::post('updateTorneo','TorneosController@updateTorneo')->name('updateTorneo');

    Route::post('aceptarSolicitud','TorneosController@aceptarSolicitud')->name('aceptarSolicitud');
    Route::post('rechazarSolicitud','TorneosController@rechazarSolicitud')->name('rechazarSolicitud');

    Route::post('iniciarTorneo','TorneosController@iniciarTorneo')->name('iniciarTorneo');

    Route::get('adminEquipo/{id}','TorneosController@adminEquipo')->name('adminEquipo');
    //rutas para los torneos
    Route::get('adminTorneos/fase/{torneo_id}','TorneosController@adminFases')->name('adminFases');

});


Route::group(['middleware' => ['auth', 'jugador']], function () {

    Route::post('validarPassword','UsuariosController@validarPassword')->name('validarPassword');
    Route::post('cambiarPassword','UsuariosController@cambiarPassword')->name('cambiarPassword');
    Route::post('avatarUsuario', 'UsuariosController@updateAvatarU')->name('updateAvatarU');
    Route::post('updateJugador', 'UsuariosController@updateJugador')->name('updateJugador');
    Route::get('misReservas','UsuariosController@misReservas')->name('misReservas');
    Route::post('cancelReservaUser', 'UsuariosController@cancelReservaUser')->name('cancelReservaUser');

});

Route::get('/','UsuariosController@index')->name('home');
Route::get('buscar','UsuariosController@buscar')->name('buscar');
Route::post('buscar','UsuariosController@getCanchasBusqueda')->name('getCanchasBusqueda');
Route::get('sitio/{id}','UsuariosController@getSitio')->name('getSitio');
Route::post('canchas','UsuariosController@getCanchaXtipo')->name('getCanchaXtipo');
Route::post('disponibilidades','UsuariosController@disponibilidad')->name('disponibilidades');
Route::get('getInfoToken/{id_sitio}','UsuariosController@getInfoToken')->name('getInfoToken');
Route::post('addNuevaReservaUsuario','UsuariosController@addNuevaReservaUsuario')->name('addNuevaReservaUsuario');

Route::post('mail','MailController@enviar')->name('enviar');


Route::get('password/email', 'Auth\PasswordController@getEmail')->name('getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail')->name('postEmail');

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset')->name('getReset');
Route::post('password/reset/{token}', 'Auth\PasswordController@postReset')->name('postReset');


Route::post('municipios','UsuariosController@getMunicipios')->name('municipios');
Route::get('registro', 'UsuariosController@registrarJugador')->name('registrarJugador');
Route::post('addJugador','UsuariosController@addJugador')->name('addJugador');


Route::get('mapas', 'UsuariosController@geoLocalizacionMover')->name('geoLocalizacionMover');

Route::get('completarFormulario', 'UsuariosController@completarFormulario')->name('completarFormulario');
Route::post('completarRegistro', 'UsuariosController@completarRegistro')->name('completarRegistro');
Route::get('activaruser/{email}', 'UsuariosController@activarUser')->name('activarUser');


Route::get("prueba", function (){

    dd(\Auth::user());

});


/*Route::get('mapas', function(){
    $config = array();
    $config['center'] = 'auto';
    $config['onclick'] = 'marker_0.setOptions({
                position: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng())
            });';
    $config['onboundschanged'] = 'if (!centreGot) {
            var mapCentre = map.getCenter();
            marker_0.setOptions({
                position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
            });
        }
        centreGot = true;';

    Gmaps::initialize($config);

    // set up the marker ready for positioning   AIzaSyDfAkQfWbTfV2wDE06kaR1UlynH34WrPNs
    // once we know the users location
    $marker = array();
    $marker['draggable'] = true;
    $marker['ondragend'] = 'alert(\'You just dropped me at: \' + event.latLng.lat() + \', \' + event.latLng.lng());';
    Gmaps::add_marker($marker);



    $map = Gmaps::create_map();
    echo "<html><head> <script src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyC9fjt2dmc7HtvNLTC2_0IIe7y2x9b7qic\" type=\"text/javascript\"></script><script type='text/javascript'>var centreGot = false;</script>".$map['js']."</head><body>".$map['html']."</body></html>";

    dd($map);

});*/
