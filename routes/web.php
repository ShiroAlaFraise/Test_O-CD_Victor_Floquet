<?php

use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


// Route d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (accessible uniquement pour les utilisateurs authentifiés)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes liées au profil utilisateur (protégées par auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes publiques pour la gestion des personnes
Route::get('/people', [PersonController::class, 'index'])->name('people.index');


// Routes protégées par authentification pour la création et l'enregistrement des personnes
Route::middleware('auth')->group(function () {
    Route::get('/people/create', [PersonController::class, 'create'])->name('people.create');
    Route::post('/people', [PersonController::class, 'store'])->name('people.store');
});

Route::get('/people/{id}', [PersonController::class, 'show'])->name('people.show');


Route::get('/degre', function () {
    return view('degre_form');
});

Route::post('/degre', function (Request $request) {
    $start = (int) $request->input('start_id');
    $end = (int) $request->input('end_id');

    // Appel à la méthode getDegreeWith modifiée pour inclure le temps
    [$degree, $path, $queryCount, $duration] = Person::getDegreeWith($start, $end);

    // Retourner la vue avec les résultats, y compris le temps et les requêtes
    return view('degre_result', [
        'degree' => $degree,
        'path' => $path,
        'queryCount' => $queryCount,
        'duration' => $duration,
        'startId' => $start,
        'targetId' => $end
    ]);
});


// Inclure les routes d'authentification générées par Breeze
require __DIR__.'/auth.php';
