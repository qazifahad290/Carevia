<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Specialty;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleBasedDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_created_with_patient_role_by_default(): void
    {
        $user = User::factory()->create();
        $this->assertSame('patient', $user->role);
    }

    public function test_patient_login_redirects_to_dashboard(): void
    {
        $user = User::factory()->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/dashboard');
    }

    public function test_doctor_login_redirects_to_doctor_dashboard(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_DOCTOR]);
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/doctor/dashboard');
    }

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/admin/dashboard');
    }

    public function test_patient_cannot_access_doctor_dashboard(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/doctor/dashboard')->assertForbidden();
    }

    public function test_patient_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/admin/dashboard')->assertForbidden();
    }

    public function test_doctor_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_DOCTOR]);
        $this->actingAs($user)->get('/admin/dashboard')->assertForbidden();
    }

    public function test_doctor_sees_only_their_appointments(): void
    {
        $specialty = Specialty::create(['name' => 'Cardiology', 'slug' => 'cardiology']);
        $doctorUser = User::factory()->create(['role' => User::ROLE_DOCTOR]);
        $doctor = Doctor::create([
            'user_id'         => $doctorUser->id,
            'specialty_id'    => $specialty->id,
            'name'            => 'Dr. Sarah',
            'rating'          => 4.8,
            'price'           => 50,
            'years_experience'=> 5,
            'is_active'       => true,
        ]);
        $otherDoctor = Doctor::create([
            'specialty_id'    => $specialty->id,
            'name'            => 'Dr. Other',
            'rating'          => 4.0,
            'price'           => 50,
            'years_experience'=> 5,
            'is_active'       => true,
        ]);

        $patientA = User::factory()->create();
        $patientB = User::factory()->create();

        $apptMine = Appointment::create([
            'patient_id' => $patientA->id,
            'doctor_id'  => $doctor->id,
            'date'       => Carbon::tomorrow()->toDateString(),
            'time'       => '10:00',
            'status'     => 'confirmed',
        ]);
        Appointment::create([
            'patient_id' => $patientB->id,
            'doctor_id'  => $otherDoctor->id,
            'date'       => Carbon::tomorrow()->toDateString(),
            'time'       => '10:00',
            'status'     => 'confirmed',
        ]);

        $this->actingAs($doctorUser)
            ->get('/doctor/dashboard')
            ->assertOk()
            ->assertSee($patientA->name)
            ->assertDontSee($patientB->name);
    }

    public function test_doctor_can_mark_appointment_complete(): void
    {
        $specialty = Specialty::create(['name' => 'Cardiology', 'slug' => 'cardiology']);
        $doctorUser = User::factory()->create(['role' => User::ROLE_DOCTOR]);
        $doctor = Doctor::create([
            'user_id'         => $doctorUser->id,
            'specialty_id'    => $specialty->id,
            'name'            => 'Dr. Sarah',
            'rating'          => 4.8,
            'price'           => 50,
            'years_experience'=> 5,
            'is_active'       => true,
        ]);
        $patient = User::factory()->create();
        $appt = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id'  => $doctor->id,
            'date'       => Carbon::today()->toDateString(),
            'time'       => '10:00',
            'status'     => 'confirmed',
        ]);

        $this->actingAs($doctorUser)
            ->patch("/doctor/appointments/{$appt->id}/complete")
            ->assertRedirect();

        $this->assertSame('completed', $appt->fresh()->status);
    }

    public function test_doctor_cannot_modify_other_doctors_appointments(): void
    {
        $specialty = Specialty::create(['name' => 'Cardiology', 'slug' => 'cardiology']);
        $doctorA = User::factory()->create(['role' => User::ROLE_DOCTOR]);
        $docProfileA = Doctor::create([
            'user_id'         => $doctorA->id,
            'specialty_id'    => $specialty->id,
            'name'            => 'Dr. A',
            'rating'          => 4.8,
            'price'           => 50,
            'years_experience'=> 5,
            'is_active'       => true,
        ]);
        $doctorB = User::factory()->create(['role' => User::ROLE_DOCTOR]);
        $docProfileB = Doctor::create([
            'user_id'         => $doctorB->id,
            'specialty_id'    => $specialty->id,
            'name'            => 'Dr. B',
            'rating'          => 4.8,
            'price'           => 50,
            'years_experience'=> 5,
            'is_active'       => true,
        ]);
        $patient = User::factory()->create();
        $appt = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id'  => $docProfileA->id,
            'date'       => Carbon::today()->toDateString(),
            'time'       => '10:00',
            'status'     => 'confirmed',
        ]);

        $this->actingAs($doctorB)
            ->patch("/doctor/appointments/{$appt->id}/complete")
            ->assertForbidden();

        $this->assertSame('confirmed', $appt->fresh()->status);
    }

    public function test_admin_sees_system_stats_on_dashboard(): void
    {
        $specialty = Specialty::create(['name' => 'Cardiology', 'slug' => 'cardiology']);
        $doctor = Doctor::create([
            'specialty_id'    => $specialty->id,
            'name'            => 'Dr. X',
            'rating'          => 4.8,
            'price'           => 50,
            'years_experience'=> 5,
            'is_active'       => true,
        ]);
        Appointment::create([
            'patient_id' => User::factory()->create()->id,
            'doctor_id'  => $doctor->id,
            'date'       => Carbon::today()->toDateString(),
            'time'       => '10:00',
            'status'     => 'confirmed',
        ]);

        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('System overview')
            ->assertSee('Appointments')
            ->assertSee('Providers');
    }

    public function test_admin_can_view_all_users(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $patient = User::factory()->create(['name' => 'Alice Patient']);
        $this->actingAs($admin)
            ->get('/admin/users')
            ->assertOk()
            ->assertSee('Alice Patient');
    }

    public function test_registered_users_get_patient_role(): void
    {
        $this->post('/register', [
            'name' => 'New User',
            'email' => 'newuser@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'email' => 'newuser@test.com',
            'role'  => 'patient',
        ]);
    }
}
