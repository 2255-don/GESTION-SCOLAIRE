<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/note', function () {
    return view('admin.note');
});

//profil super-admin
Route::get('/profil/{id?}',[App\Http\Controllers\supadmin::class, 'profil'])->name('supadmin.profil')->middleware('App\Http\Middleware\Authentificate')->can('viewProfile', User::class);
Route::post('/profil/store',[App\Http\Controllers\supadmin::class, 'storeprofil'])->name('supadmin.storeprofil')->middleware('App\Http\Middleware\Authentificate')->can('viewProfile', User::class);
Route::get('/profil/delete/{id}',[App\Http\Controllers\supadmin::class, 'delateprofil'])->name('supadmin.deleteProfil')->middleware('App\Http\Middleware\Authentificate')->can('viewProfile', User::class);

//admin super-admin
Route::get('/dashboard/{id?}',[App\Http\Controllers\supadmin::class, 'user'])->name('supadmin.user')->middleware('App\Http\Middleware\Authentificate')->can('viewProfile', User::class);
Route::post('/user/store',[App\Http\Controllers\supadmin::class, 'userStore'])->name('supadmin.userStore');
Route::delete('/user/delete/{id}',[App\Http\Controllers\supadmin::class, 'delateUser'])->name('supadmin.delateUser');

//admin-superAdmin Cour
Route::get('/cour/{id?}',[App\Http\Controllers\Cours::class, 'Cour'])->name('user.cour')->middleware('App\Http\Middleware\Authentificate');
Route::post('/cour/store',[App\Http\Controllers\Cours::class, 'courStore'])->name('user.courStore')->middleware('App\Http\Middleware\Authentificate');
Route::delete('/cour/delete/{id}',[App\Http\Controllers\Cours::class, 'delateCour'])->name('user.delateCour')->middleware('App\Http\Middleware\Authentificate');

//superAdmin filiere
Route::get('/filiere/{id?}',[App\Http\Controllers\Filieres::class, 'filiere'])->name('admin.filiere');
Route::post('/filiere/store',[App\Http\Controllers\Filieres::class, 'filiereStore'])->name('user.filiereStore');
Route::delete('/fiere/delete/{id}',[App\Http\Controllers\Filieres::class, 'delateFiliere'])->name('user.delateFiliere');

//superAdmin planing
Route::get('/planing/{id?}',[App\Http\Controllers\PlaningController::class, 'planing'])->name('admin.planing')->middleware('App\Http\Middleware\Authentificate');
Route::post('/planing/store',[App\Http\Controllers\PlaningController::class, 'planingStore'])->name('user.planingStore')->middleware('App\Http\Middleware\Authentificate');
// Route::delete('/planing/delete/{id}',[App\Http\Controllers\Filieres::class, 'delateFiliere'])->name('user.delateFiliere');

//login
Route::get('/login',[App\Http\Controllers\LoginController::class, 'Login'])->name('user.login');
Route::post('/login',[App\Http\Controllers\LoginController::class, 'doLogin']);
Route::get('/logout',[App\Http\Controllers\LoginController::class, 'logout'])->name('user.logout');

//admin dashboard
Route::get('/adminDashboard/{id?}',[App\Http\Controllers\AdminDashboardController::class, 'inscription'])->name('admin.dashboard')->middleware('App\Http\Middleware\Authentificate')->can('dashboard', User::class);
Route::post('/adminUser/store',[App\Http\Controllers\AdminDashboardController::class, 'inscriptionStorre'])->name('supadmin.adminUserStore')->middleware('App\Http\Middleware\Authentificate')->can('dashboard', User::class);
Route::delete('/adminUser/delete/{id}',[App\Http\Controllers\AdminDashboardController::class, 'inscriptionDelete'])->name('supadmin.adminUserDelateUser')->middleware('App\Http\Middleware\Authentificate')->can('dashboard', User::class);

//admin etudiant
Route::get('/etudiant/{id?}',[App\Http\Controllers\AdminDashboardController::class, 'Etudiant'])->name('admin.etudiant')->middleware('App\Http\Middleware\Authentificate')->can('dashboard', User::class);
Route::post('/etudiant/store',[App\Http\Controllers\AdminDashboardController::class, 'StoreEtudiant'])->name('admin.etudiantStore')->middleware('App\Http\Middleware\Authentificate')->can('dashboard', User::class);
// Route::delete('/adminUser/delete/{id}',[App\Http\Controllers\AdminDashboardController::class, 'inscriptionDelete'])->name('supadmin.adminUserDelateUser');

//admin Proffesseur notes
Route::get('/acceuil',[App\Http\Controllers\ProfesseurControlleur::class, 'acceuilAdmin'])->name('prof.acceuil')->middleware('App\Http\Middleware\Authentificate');
// Route::post('/set-periode', [App\Http\Controllers\ProfesseurControlleur::class, 'setPeriode'])->name('set.periode');
Route::post('/acceuil/filiere',[App\Http\Controllers\ProfesseurControlleur::class, 'choixFiliere'])->name('prof.filiere')->middleware('App\Http\Middleware\Authentificate');
Route::get('/acceuil/note/{id?}',[App\Http\Controllers\ProfesseurControlleur::class, 'note'])->name('prof.note')->middleware('App\Http\Middleware\Authentificate');
Route::post('/acceuil/note/store',[App\Http\Controllers\ProfesseurControlleur::class, 'noteStore'])->name('prof.noteStore')->middleware('App\Http\Middleware\Authentificate');
// Route::delete('/adminUser/delete/{id}',[App\Http\Controllers\AdminDashboardController::class, 'inscriptionDelete'])->name('supadmin.adminUserDelateUser');

//route de reccuperation
Route::get('/etudiants/{filiere}', [App\Http\Controllers\ProfesseurControlleur::class, 'getEtudiantByNiveauFiliere']);
Route::get('/note-details/{noteId}', [App\Http\Controllers\ProfesseurControlleur::class, 'noteEtudiant']);

//gestion bulletin admin
Route::get('admin/bulletin/form', [\App\Http\Controllers\AdminNoteController::class, 'choixFiliere']);
Route::post('admin/bulletin/etudiant', [\App\Http\Controllers\AdminNoteController::class, 'infoEtudiant'])->name('admin.infoEtudiant');
Route::get('admin/bulletin/etudiant/show/{id}', [\App\Http\Controllers\AdminNoteController::class, 'bulletin'])->name('admin.show-bulletin');



