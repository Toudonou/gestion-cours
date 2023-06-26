<?php

use App\Http\Controllers\DirecteurController;
use App\Http\Controllers\EnseignantLocalController;
use App\Http\Controllers\EnseignantMissionnaireController;
use App\Http\Controllers\EtudiantController;
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
    return view('login');
})->name('login');

Route::get('/login', function () {
    return view('login');
});

Route::get('/logout', function () {
    return view('login');
})->name('logout');


/** ACTIONS DIRECTEURS */
Route::get('/directeurs/login', [DirecteurController::class, 'index'])->name('login-directeurs');
Route::post('/directeurs/login', [DirecteurController::class, 'login'])->name('login-directeurs');

Route::get('/directeurs/{id}/home', [DirecteurController::class, 'home'])->name('home-directeur');
Route::get('/directeurs/logout', [DirecteurController::class, 'logout'])->name('logout-directeur');

Route::get('/directeurs/{id}/edition', [DirecteurController::class, 'indexEditer'])->name('editer-directeur');
Route::post('/directeurs/{id}/edition', [DirecteurController::class, 'editer'])->name('editer-directeur');

/** ENSEIGNANTS */
Route::get('/directeurs/{id}/gererEnseignants', [DirecteurController::class, 'gererEnseignants'])->name('gerer-enseignants');

/** ENSEIGNANTS LOCAUX */
Route::get('/directeurs/{id}/gererEnseignantsLocaux', [DirecteurController::class, 'gererEnseignantsLocaux'])->name('gerer-enseignants-locaux');

Route::get('/directeurs/{id}/ajouterEnseignantLocal', [DirecteurController::class, 'indexAjouterEnseignantLocal'])->name('ajouter-enseignant-local');
Route::post('/directeurs/{id}/ajouterEnseignantLocal', [DirecteurController::class, 'ajouterEnseignantLocal'])->name('ajouter-enseignant-local');

Route::get('/directeurs/{idDirecteur}/editerEnseignantLocal/{idEnseignant}', [DirecteurController::class, 'indexEditerEnseignantLocal'])->name('editer-enseignant-local');
Route::post('/directeurs/{idDirecteur}/editerEnseignantLocal/{idEnseignant}', [DirecteurController::class, 'editerEnseignantLocal'])->name('editer-enseignant-local');

Route::delete('/directeurs/{idDirecteur}/supprimerEnseignantLocal/{idEnseignant}', [DirecteurController::class, 'supprimerEnseignantLocal'])->name('supprimer-enseignant-local');


/** ENSEIGNANTS MISSIONNAIRES */
Route::get('/directeurs/{id}/gererEnseignantsMissionnaires', [DirecteurController::class, 'gererEnseignantsMissionnaires'])->name('gerer-enseignants-missionnaires');

Route::get('/directeurs/{id}/ajouterEnseignantMissionnaire', [DirecteurController::class, 'indexAjouterEnseignantMissionnaire'])->name('ajouter-enseignant-missionnaire');
Route::post('/directeurs/{id}/ajouterEnseignantMissionnaire', [DirecteurController::class, 'ajouterEnseignantMissionnaire'])->name('ajouter-enseignant-missionnaire');

Route::get('/directeurs/{idDirecteur}/editerEnseignantMissionnaire/{idEnseignant}', [DirecteurController::class, 'indexEditerEnseignantMissionnaire'])->name('editer-enseignant-missionnaire');
Route::post('/directeurs/{idDirecteur}/editerEnseignantMissionnaire/{idEnseignant}', [DirecteurController::class, 'editerEnseignantMissionnaire'])->name('editer-enseignant-missionnaire');

Route::delete('/directeurs/{idDirecteur}/supprimerEnseignantMissionnaire/{idEnseignant}', [DirecteurController::class, 'supprimerEnseignantMissionnaire'])->name('supprimer-enseignant-missionnaire');


/** ETUDIANTS */
Route::get('/directeurs/{id}/gererEtudiants', [DirecteurController::class, 'gererEtudiants'])->name('gerer-etudiants');

Route::get('/directeurs/{id}/ajouterEtudiant', [DirecteurController::class, 'indexAjouterEtudiant'])->name('ajouter-etudiant');
Route::post('/directeurs/{id}/ajouterEtudiant', [DirecteurController::class, 'ajouterEtudiant'])->name('ajouter-etudiant');

Route::get('/directeurs/{idDirecteur}/editerEtudiant/{idEtudiant}', [DirecteurController::class, 'indexEditerEtudiant'])->name('editer-etudiant');
Route::post('/directeurs/{idDirecteur}/editerEtudiant/{idEtudiant}', [DirecteurController::class, 'editerEtudiant'])->name('editer-etudiant');

Route::delete('/directeurs/{idDirecteur}/supprimerEtudiant/{idEtudiant}', [DirecteurController::class, 'supprimerEtudiant'])->name('supprimer-etudiant');


/** COURS LOCAUX */
Route::get('/directeurs/{id}/gererCoursLocaux', [DirecteurController::class, 'gererCoursLocaux'])->name('gerer-cours-locaux');

Route::get('/directeurs/{id}/ajouterCoursLocal', [DirecteurController::class, 'indexAjouterCoursLocal'])->name('ajouter-cours-local');
Route::post('/directeurs/{id}/ajouterCoursLocal', [DirecteurController::class, 'ajouterCoursLocal'])->name('ajouter-cours-local');

Route::get('/directeurs/{idDirecteur}/editerCoursLocal/{idCours}', [DirecteurController::class, 'indexEditerCoursLocal'])->name('editer-cours-local');
Route::post('/directeurs/{idDirecteur}/editerCoursLocal/{idCours}', [DirecteurController::class, 'editerCoursLocal'])->name('editer-cours-local');

Route::delete('/directeurs/{idDirecteur}/supprimerCoursLocal/{idCours}', [DirecteurController::class, 'supprimerCoursLocal'])->name('supprimer-cours-local');


/** COURS MISSIONNAIRES */
Route::get('/directeurs/{id}/gererCoursMissionnaires', [DirecteurController::class, 'gererCoursMissionnaires'])->name('gerer-cours-missionnaires');

Route::get('/directeurs/{id}/ajouterCoursMissionnaire', [DirecteurController::class, 'indexAjouterCoursMissionnaire'])->name('ajouter-cours-missionnaire');
Route::post('/directeurs/{id}/ajouterCoursMissionnaire', [DirecteurController::class, 'ajouterCoursMissionnaire'])->name('ajouter-cours-missionnaire');

Route::get('/directeurs/{idDirecteur}/editerCoursMissionnaire/{idCours}', [DirecteurController::class, 'indexEditerCoursMissionnaire'])->name('editer-cours-missionnaire');
Route::post('/directeurs/{idDirecteur}/editerCoursMissionnaire/{idCours}', [DirecteurController::class, 'editerCoursMissionnaire'])->name('editer-cours-missionnaire');

Route::delete('/directeurs/{idDirecteur}/supprimerCoursMissionnaire/{idCours}', [DirecteurController::class, 'supprimerCoursMissionnaire'])->name('supprimer-cours-missionnaire');
/** FIN ACTIONS DIRECTEUR */


/** ACTIONS ENSEIGNANT LOCAL*/
Route::get('/enseignantLocal/login', [EnseignantLocalController::class, 'index'])->name('login-enseignant-local');
Route::post('/enseignantLocal/login', [EnseignantLocalController::class, 'login'])->name('login-enseignant-local');

Route::get('/enseignantLocal/{id}/home', [EnseignantLocalController::class, 'home'])->name('home-enseignant-local');

Route::get('/enseignantLocal/{id}/editer', [EnseignantLocalController::class, 'indexEditer'])->name('self-editer-enseignant-local');
Route::post('/enseignantLocal/{id}/editer', [EnseignantLocalController::class, 'editer'])->name('self-editer-enseignant-local');

Route::get('/enseignantLocal/{idEnseignant}/uploadCours/{idCours}', [EnseignantLocalController::class, 'uploadCours'])->name('self-enseignant-local-upload-cours');
Route::post('/enseignantLocal/{idEnseignant}/uploadCours/{idCours}', [EnseignantLocalController::class, 'uploadCours'])->name('self-enseignant-local-upload-cours');

Route::get('/enseignantLocal/{idEnseignant}/uploadTd/{idCours}', [EnseignantLocalController::class, 'uploadTd'])->name('self-enseignant-local-upload-td');
Route::post('/enseignantLocal/{idEnseignant}/uploadTd/{idCours}', [EnseignantLocalController::class, 'uploadTd'])->name('self-enseignant-local-upload-td');

Route::get('/enseignantLocal/{id}/gererSupportCours', [EnseignantLocalController::class, 'gererSupportCours'])->name('self-enseignant-local-gererCours');
Route::get('/enseignantLocal/{id}/gererSupportTd', [EnseignantLocalController::class, 'gererSupportTd'])->name('self-enseignant-local-gererTd');

Route::delete('/enseignantLocal/{id}/supprimerSupportCours/{idCours}', [EnseignantLocalController::class, 'supprimerSupportCours'])->name('self-enseignant-local-supprimer-cours');
Route::delete('/enseignantLocal/{id}/supprimerSupportTd/{idTd}', [EnseignantLocalController::class, 'supprimerSupportTd'])->name('self-enseignant-local-supprimer-td');


/** ACTION ENSEIGNANT MISSIONNAIRE */
Route::get('/enseignantMissionnaire/login', [EnseignantMissionnaireController::class, 'index'])->name('login-enseignant-missionnaire');
Route::post('/enseignantMissionnaire/login', [EnseignantMissionnaireController::class, 'login'])->name('login-enseignant-missionnaire');

Route::get('/enseignantMissionnaire/{id}/home', [EnseignantMissionnaireController::class, 'home'])->name('home-enseignant-missionnaire');

Route::get('/enseignantMissionnaire/{id}/editer', [EnseignantMissionnaireController::class, 'indexEditer'])->name('self-editer-enseignant-missionnaire');
Route::post('/enseignantMissionnaire/{id}/editer', [EnseignantMissionnaireController::class, 'editer'])->name('self-editer-enseignant-missionnaire');

Route::get('/enseignantMissionnaire/{idEnseignant}/uploadCours/{idCours}', [EnseignantMissionnaireController::class, 'uploadCours'])->name('self-enseignant-missionnaire-upload-cours');
Route::post('/enseignantMissionnaire/{idEnseignant}/uploadCours/{idCours}', [EnseignantMissionnaireController::class, 'uploadCours'])->name('self-enseignant-missionnaire-upload-cours');

Route::get('/enseignantMissionnaire/{idEnseignant}/uploadTd/{idCours}', [EnseignantMissionnaireController::class, 'uploadTd'])->name('self-enseignant-missionnaire-upload-td');
Route::post('/enseignantMissionnaire/{idEnseignant}/uploadTd/{idCours}', [EnseignantMissionnaireController::class, 'uploadTd'])->name('self-enseignant-missionnaire-upload-td');

Route::get('/enseignantMissionnaire/{id}/gererSupportCours', [EnseignantMissionnaireController::class, 'gererSupportCours'])->name('self-enseignant-missionnaire-gererCours');
Route::get('/enseignantMissionnaire/{id}/gererSupportTd', [EnseignantMissionnaireController::class, 'gererSupportTd'])->name('self-enseignant-missionnaire-gererTd');

Route::delete('/enseignantMissionnaire/{id}/supprimerSupportCours/{idCours}', [EnseignantMissionnaireController::class, 'supprimerSupportCours'])->name('self-enseignant-missionnaire-supprimer-cours');
Route::delete('/enseignantMissionnaire/{id}/supprimerSupportTd/{idTd}', [EnseignantMissionnaireController::class, 'supprimerSupportTd'])->name('self-enseignant-missionnaire-supprimer-td');




/** ACTION ETUDIANT */
Route::get('/etudiant/login', [EtudiantController::class, 'index'])->name('login-etudiant');
Route::post('/etudiant/login', [EtudiantController::class, 'login'])->name('login-etudiant');

Route::get('/etudiant/{id}/home', [EtudiantController::class, 'home'])->name('home-etudiant');

Route::get('/etudiant/{id}/homeCoursLocal', [EtudiantController::class, 'homeCoursLocal'])->name('home-etudiant-local');
Route::get('/etudiant/{id}/homeCoursMission', [EtudiantController::class, 'homeCoursMission'])->name('home-etudiant-mission');


Route::get('/etudiant/{id}/editer', [EtudiantController::class, 'indexEditer'])->name('self-editer-etudiant');
Route::post('/etudiant/{id}/editer', [EtudiantController::class, 'editer'])->name('self-editer-etudiant');

Route::get('/etudiant/{id}/supportCours/{type}/{idCours}', [EtudiantController::class, 'supportCours'])->name('self-cours-etudiant');
Route::get('/etudiant/{id}/supportTd/{type}/{idCours}', [EtudiantController::class, 'supportTd'])->name('self-td-etudiant');
