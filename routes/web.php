<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateursController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\MedicamentsController;
use App\Http\Controllers\OrdonnancesController;
use App\Http\Controllers\PosologiesController;
use App\Http\Controllers\ExamensController;
use App\Http\Controllers\TraitementController;
use App\Http\Controllers\ConsultationsController;
use App\Http\Controllers\RdvController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AntecedentsController;
use App\Http\Controllers\ParamsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\LocalizationController;

/*
|--------------------------------------------------------------------------
| Pages publiques
|--------------------------------------------------------------------------
*/

Route::get('locale/{lang}', [LocalizationController::class, 'setLocale']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Pages réservées aux utilisateurs connectés
|--------------------------------------------------------------------------
| Les accès (patients, consultations...) de chaque rôle sont dans la table role_acces
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dossier médical : le patient voit le sien, le personnel soignant voit tous les dossiers
    Route::get('/dossier/{id}', [ConsultationsController::class, 'dossier_id_consultation']);

    // Tableau de bord (un patient est renvoyé vers son dossier)
    Route::get('/', [UtilisateursController::class, 'acceuil'])->name('accueil');

    Route::middleware('acces:tableau_de_bord')->group(function () {
        Route::get('/aide', [UtilisateursController::class, 'aide']);
    });

    // Comptes (patients et personnel) : ajout, modification, suppression
    // Le contrôleur vérifie en plus que seul « gestion_personnel » gère les comptes du personnel
    Route::middleware('acces:patients,gestion_personnel')->group(function () {
        Route::post('/ajouter/resources', [UtilisateursController::class, 'ajout_resources']);
        Route::post('/update/resources', [UtilisateursController::class, 'update_resources_traitement']);
        Route::get('/update-resources/{id}', [UtilisateursController::class, 'update_id_resources']);
        Route::get('/delete-resources/{id}', [UtilisateursController::class, 'delete_id_resources']);
    });

    // Liste du personnel : un onglet par rôle, ex. /personnel/medecin
    Route::middleware('acces:gestion_personnel')->group(function () {
        Route::get('/personnel/{role?}', [UtilisateursController::class, 'listeresources'])->name('personnel');
    });

    // Patients, paramètres, antécédents
    Route::middleware('acces:patients')->group(function () {
        Route::get('/listespatients', [PatientsController::class, 'listepatients'])->name('patient');
        Route::get('/show-patients/{id}', [PatientsController::class, 'show_patient']);
        Route::get('/imprimer', [PatientsController::class, 'imprimer']);

        Route::get('/listeparams', [ParamsController::class, 'listeparams']);
        Route::post('/ajouter/param', [ParamsController::class, 'ajout_param']);
        Route::post('/update/param', [ParamsController::class, 'update_param_traitement']);
        Route::get('/update-params/{id}', [ParamsController::class, 'update_id_param']);
        Route::get('/delete-params/{id}', [ParamsController::class, 'delete_id_param']);

        Route::get('/listeantecedents', [AntecedentsController::class, 'listeantecedent']);
        Route::post('/ajouter/antecedent', [AntecedentsController::class, 'ajout_antecedent']);
        Route::post('/update/antecedent', [AntecedentsController::class, 'update_antecedent_traitement']);
        Route::get('/update-antecedents/{id}', [AntecedentsController::class, 'update_id_antecedent']);
        Route::get('/delete-antecedents/{id}', [AntecedentsController::class, 'delete_id_antecedent']);
    });

    // Consultations
    Route::middleware('acces:consultations')->group(function () {
        Route::get('/listesconsultations', [ConsultationsController::class, 'listesconsultations']);
        Route::post('/ajouter/consultation', [ConsultationsController::class, 'ajout_consultation']);
        Route::post('/update/consultations', [ConsultationsController::class, 'update_consultation_traitement']);
        Route::get('/update-consultations/{id}', [ConsultationsController::class, 'update_id_consultation']);
        Route::get('/vue-consultations/{id}', [ConsultationsController::class, 'vue_id_consultation']);
    });
    Route::get('/delete-consultations/{id}', [ConsultationsController::class, 'delete_id_consultation'])
        ->middleware('acces:consultations_suppression');

    // Médicaments, catégories, posologies : consultation
    Route::middleware('acces:medicaments')->group(function () {
        Route::get('/listecategories', [CategoriesController::class, 'listecategories']);
        Route::get('/listemedicaments', [MedicamentsController::class, 'listemedicaments']);
        // Les posologies sont créées avec les ordonnances : ici on peut seulement les lister ou les supprimer
        Route::get('/listeposologies', [PosologiesController::class, 'listeposologies']);
    });

    // Médicaments : ajout, modification, suppression
    Route::middleware('acces:medicaments_gestion')->group(function () {
        Route::post('/ajouter/medicament', [MedicamentsController::class, 'ajout_medicament']);
        Route::post('/update/medicaments', [MedicamentsController::class, 'update_medicament_traitement']);
        Route::get('/update-medicaments/{id}', [MedicamentsController::class, 'update_id_medicament']);
        Route::get('/delete-medicaments/{id}', [MedicamentsController::class, 'delete_id_medicament']);
    });

    // Catégories et posologies : ajout, modification, suppression
    Route::middleware('acces:categories_gestion')->group(function () {
        Route::post('/ajouter/categorie', [CategoriesController::class, 'ajout_categorie']);
        Route::post('/update/categories', [CategoriesController::class, 'update_categorie_traitement']);
        Route::get('/update-categories/{id}', [CategoriesController::class, 'update_id_categorie']);
        Route::get('/delete-categories/{id}', [CategoriesController::class, 'delete_id_categorie']);
        Route::get('/delete-posologies/{id}', [PosologiesController::class, 'delete_id_posologie']);
    });

    // Ordonnances : consultation et impression
    Route::middleware('acces:ordonnances')->group(function () {
        Route::get('/listesordonnances', [OrdonnancesController::class, 'listeordonnances']);
        Route::get('/certificat/{id}', [OrdonnancesController::class, 'certificat']);
        Route::get('/imprimer/{id}', [OrdonnancesController::class, 'imprimer']);
    });

    // Ordonnances : rédaction, modification, suppression
    Route::middleware('acces:prescription')->group(function () {
        Route::post('/ajouter/ordonnance', [OrdonnancesController::class, 'ajout_ordonnance']);
        Route::post('/update/ordonnances', [OrdonnancesController::class, 'update_ordonnance_traitement']);
        Route::get('/update-ordonnances/{id}', [OrdonnancesController::class, 'update_id_ordonnance']);
        Route::get('/delete-ordonnances/{id}', [OrdonnancesController::class, 'delete_id_ordonnance']);
    });

    // Examens et résultats d'examens : consultation
    Route::middleware('acces:examens')->group(function () {
        Route::get('/listesexamens', [ExamensController::class, 'listeexamens']);
        Route::get('/listestraitements', [TraitementController::class, 'listetraitement']);
    });

    // Examens et résultats d'examens : ajout, modification, suppression
    Route::middleware('acces:examens_gestion')->group(function () {
        Route::post('/ajouter/examen', [ExamensController::class, 'ajout_examen']);
        Route::post('/update/examens', [ExamensController::class, 'update_examen_traitement']);
        Route::get('/update-examens/{id}', [ExamensController::class, 'update_id_examen']);
        Route::get('/delete-examens/{id}', [ExamensController::class, 'delete_id_examen']);

        Route::post('/ajouter/traitement', [TraitementController::class, 'ajout_traitement']);
        Route::post('/update/traitement', [TraitementController::class, 'update_traitement_traitement']);
        Route::get('/update-traitement/{id}', [TraitementController::class, 'update_id_traitement']);
        Route::get('/delete-traitement/{id}', [TraitementController::class, 'delete_id_traitement']);
    });

    // Rendez-vous et planning
    Route::middleware('acces:rendez_vous')->group(function () {
        Route::get('/listesRDV', [RdvController::class, 'listeRDV']);
        Route::post('/ajouter/RDV', [RdvController::class, 'ajout_RDV']);
        Route::post('/update/RDV', [RdvController::class, 'update_RDV_traitement']);
        Route::get('/update-RDV/{id}', [RdvController::class, 'update_id_RDV'])->name('update_id_RDV');
        Route::get('/planing', [RdvController::class, 'calendar'])->name('calendar');
    });
    Route::get('/delete-RDV/{id}', [RdvController::class, 'delete_id_RDV'])
        ->middleware('acces:rendez_vous_suppression');
});
