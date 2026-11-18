<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateursController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\MedicamentsController;
use App\Http\Controllers\PosologiesController;
use App\Http\Controllers\OrdonnancesController;
use App\Http\Controllers\ExamensController;
use App\Http\Controllers\TraitementController;
use App\Http\Controllers\ConsultationsController;
use App\Http\Controllers\RdvController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AntecedentsController;
use App\Http\Controllers\ParamsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\planingController;

Route::get('/', [UtilisateursController::class, 'acceuil'])->name('accueil'); 

Route::get('/aide', [UtilisateursController::class, 'aide']); 

Route::get("locale/{lang}",[LocalizationController::class,"setLocale"]);

// Authentification

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// resources


Route::get('/show-patients/{id}', [PatientsController::class, 'show_patient']);

 
Route::get('/listespatients', [PatientsController::class, 'listepatients'])->name('patient');

Route::get('/imprimer', [PatientsController::class, 'imprimer']);

Route::get('/listesCAs', [UtilisateursController::class, 'listeresources'])->name('CA');

Route::get('/listeinfirmieres', [UtilisateursController::class, 'listeresources'])->name('infirmiere');

Route::get('/listepharmaciens', [UtilisateursController::class, 'listeresources'])->name('pharmacien');

Route::get('/listelabos', [UtilisateursController::class, 'listeresources'])->name('labo');

Route::get('/listemedecins', [UtilisateursController::class, 'listeresources'])->name('medecin');

Route::post('/ajouter/resources', [UtilisateursController::class, 'ajout_resources']);

Route::post('/update/resources', [UtilisateursController::class, 'update_resources_traitement']);
 
Route::get('/update-resources/{id}', [UtilisateursController::class, 'update_id_resources']);
 
Route::get('/delete-resources/{id}', [UtilisateursController::class, 'delete_id_resources']);

// params

Route::get('/listeparams', [ParamsController::class, 'listeparams']);

Route::post('/ajouter/param', [ParamsController::class, 'ajout_param']);

Route::post('/update/param', [ParamsController::class, 'update_param_traitement']);
 
Route::get('/update-params/{id}', [ParamsController::class, 'update_id_param']);
 
Route::get('/delete-params/{id}', [ParamsController::class, 'delete_id_param']);


// antecedent

Route::get('/listeantecedents', [AntecedentsController::class, 'listeantecedent']);

Route::post('/ajouter/antecedent', [AntecedentsController::class, 'ajout_antecedent']);

Route::post('/update/antecedent', [AntecedentsController::class, 'update_antecedent_traitement']);
 
Route::get('/update-antecedents/{id}', [AntecedentsController::class, 'update_id_antecedent']);
 
Route::get('/delete-antecedents/{id}', [AntecedentsController::class, 'delete_id_antecedent']);


// consultation

Route::get('/listesconsultations', [ConsultationsController::class, 'listesconsultations']);

Route::post('/ajouter/consultation', [ConsultationsController::class, 'ajout_consultation']);

Route::post('/update/consultations', [ConsultationsController::class, 'update_consultation_traitement']);
 
Route::get('/update-consultations/{id}', [ConsultationsController::class, 'update_id_consultation']);
 
Route::get('/delete-consultations/{id}', [ConsultationsController::class, 'delete_id_consultation']);

Route::get('/vue-consultations/{id}', [ConsultationsController::class, 'vue_id_consultation']);

Route::get('/dossier/{id}', [ConsultationsController::class, 'dossier_id_consultation']);


// categories

Route::get('/listecategories', [CategoriesController::class, 'listecategories']);

Route::post('/ajouter/categorie', [CategoriesController::class, 'ajout_categorie']);

Route::post('/update/categories', [CategoriesController::class, 'update_categorie_traitement']);
 
Route::get('/update-categories/{id}', [CategoriesController::class, 'update_id_categorie']);
 
Route::get('/delete-categories/{id}', [CategoriesController::class, 'delete_id_categorie']);


// medicaments

Route::get('/listemedicaments', [MedicamentsController::class, 'listemedicaments']);

Route::post('/ajouter/medicament', [MedicamentsController::class, 'ajout_medicament']);

Route::post('/update/medicaments', [MedicamentsController::class, 'update_medicament_traitement']);
 
Route::get('/update-medicaments/{id}', [MedicamentsController::class, 'update_id_medicament']);
 
Route::get('/delete-medicaments/{id}', [MedicamentsController::class, 'delete_id_medicament']);


// posologies

Route::get('/listeposologies', [PosologiesController::class, 'listeposologies']);

Route::post('/ajouter/posologie', [PosologiesController::class, 'ajout_posologie']);

Route::post('/update/posologies', [PosologiesController::class, 'update_posologie_traitement']);
 
Route::get('/update-posologies/{id}', [PosologiesController::class, 'update_id_posologie']);
 
Route::get('/delete-posologies/{id}', [PosologiesController::class, 'delete_id_posologie']);


// ordonnances

Route::get('/listesordonnances', [OrdonnancesController::class, 'listeordonnances']);

Route::get('/certificat/{id}', [OrdonnancesController::class, 'certificat']);

Route::post('/ajouter/ordonnance', [OrdonnancesController::class, 'ajout_ordonnance']);

Route::post('/update/ordonnances', [OrdonnancesController::class, 'update_ordonnance_traitement']);
 
Route::get('/update-ordonnances/{id}', [OrdonnancesController::class, 'update_id_ordonnance']);

Route::get('/imprimer/{id}', [OrdonnancesController::class, 'imprimer']);
 
Route::get('/delete-ordonnances/{id}', [OrdonnancesController::class, 'delete_id_ordonnance']);


// examens

Route::get('/listesexamens', [ExamensController::class, 'listeexamens']);

Route::post('/ajouter/examen', [ExamensController::class, 'ajout_examen']);

Route::post('/update/examens', [ExamensController::class, 'update_examen_traitement']);
 
Route::get('/update-examens/{id}', [ExamensController::class, 'update_id_examen']);
 
Route::get('/delete-examens/{id}', [ExamensController::class, 'delete_id_examen']);


// traitement == faire

Route::get('/listestraitements', [TraitementController::class, 'listetraitement']);

Route::post('/ajouter/traitement', [TraitementController::class, 'ajout_traitement']);

Route::post('/update/traitement', [TraitementController::class, 'update_traitement_traitement']);
 
Route::get('/update-traitement/{id}', [TraitementController::class, 'update_id_traitement']);
 
Route::get('/delete-traitement/{id}', [TraitementController::class, 'delete_id_traitement']);


// RDV

Route::get('/listesRDV', [RdvController::class, 'listeRDV']);

Route::post('/ajouter/RDV', [RdvController::class, 'ajout_RDV']);

Route::post('/update/RDV', [RdvController::class, 'update_RDV_traitement']);
 
Route::get('/update-RDV/{id}', [RdvController::class, 'update_id_RDV'])->name('update_id_RDV');
 
Route::get('/delete-RDV/{id}', [RdvController::class, 'delete_id_RDV']);

//planning

Route::get('/planing',[RdvController::class, 'calendar'])->name('calendar');