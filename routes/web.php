<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamenController;

// Rutas accesibles sin iniciar sesión
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/loguear', [AuthController::class, 'loguear'])->name('loguear');
    Route::get('/login', [AuthController::class, 'index'])->name('login'); 
});
Route::get('/examen', function () {
    return view('examen');
})->name('examen');


// Rutas que requieren inicio de sesión
Route::middleware('auth')->group(function () {
    Route::get('/home', [AuthController::class, 'home'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/registro', [AuthController::class, 'registro'])->name('registro');
    Route::post('/registrar', [AuthController::class, 'registrar'])->name('registrar');

    // Módulo de exámenes
    Route::get('/crear-examen', [ExamenController::class, 'create'])->name('crear.examen');
    Route::post('/subir-examen', [ExamenController::class, 'subirExamen'])->name('subir.examen');
   
Route::post('/buscar-examen', [ExamenController::class, 'buscarExamen'])->name('aplicar.examen');
Route::post('/guardar-respuestas', [ExamenController::class, 'guardarRespuestas'])->name('guardar.respuestas');
 Route::get('/examenes', [ExamenController::class, 'filtrarExamenes'])->name('examenes.index');
  Route::resource('examenes', ExamenController::class)->except(['destroy']);
 Route::delete('/examenes/{id}', [ExamenController::class, 'destroy'])->name('examenes.destroy');
Route::post('/guardar-codigo', [ExamenController::class, 'guardarCodigo'])->name('guardar.codigo');
Route::post('/verificar-codigo', [ExamenController::class, 'verificarCodigo'])->name('verificar.codigo');
Route::get('/exam/{codigo}', [ExamenController::class, 'mostrarExamen']);
Route::post('/examen/submit', [ExamenController::class, 'submitExamen'])->name('examen.submit');
Route::post('/examen/submit', [ExamenController::class, 'submitExamen'])->name('examen.submitExamen');

});
Route::get('/examen/resultados', function () {
    return view('examen.resultados');
})->name('examen.resultado');
