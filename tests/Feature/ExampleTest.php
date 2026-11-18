<?php

namespace Tests\Feature;

use App\Models\Examen;
use App\Models\Ordonnance;
use App\Models\Resource;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Les rôles et leurs accès sont en base : on les charge avant chaque test
        $this->seed(RoleSeeder::class);
    }

    private function compte(string $role, string $email): Resource
    {
        return Resource::create([
            'nom_prenom' => ucfirst($role).' Test',
            'adresse' => 'Bafoussam',
            'date_naissance' => '2000-01-01',
            'telephone' => '600000000',
            'sexe' => 'F',
            'email' => $email,
            'password' => 'password',
            'role' => $role,
        ]);
    }

    public function test_un_visiteur_non_connecte_est_renvoye_vers_la_connexion(): void
    {
        $this->get('/listespatients')->assertRedirect('/login');
    }

    public function test_un_admin_peut_se_connecter_et_voir_l_accueil(): void
    {
        $this->compte('admin', 'admin@test.cm');

        $this->post('/login', ['email' => 'admin@test.cm', 'password' => 'password'])
            ->assertRedirect('/');

        $this->get('/')->assertOk();
    }

    public function test_un_patient_ne_voit_que_son_propre_dossier(): void
    {
        $patient = $this->compte('patient', 'patient@test.cm');
        $autre = $this->compte('patient', 'autre@test.cm');

        $this->actingAs($patient)->get('/dossier/'.$patient->id)->assertOk();
        $this->actingAs($patient)->get('/dossier/'.$autre->id)->assertForbidden();
        $this->actingAs($patient)->get('/listespatients')->assertForbidden();
    }

    public function test_une_ordonnance_peut_etre_creee_sans_medicament(): void
    {
        $medecin = $this->compte('medecin', 'medecin@test.cm');
        $patient = $this->compte('patient', 'patient@test.cm');
        $examen = Examen::create(['type' => 'NFS', 'description' => 'Sang', 'cout' => 2000]);

        $this->actingAs($medecin)->post('/ajouter/ordonnance', [
            'description' => 'En attente des résultats',
            'patient' => $patient->id,
            'examen' => $examen->id,
        ])->assertRedirect('/listesordonnances');

        $this->assertSame(1, Ordonnance::whereNull('medicament_id')->count());
    }
}
