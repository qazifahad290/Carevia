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

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_patient_can_view_doctors_list(): void
    {
        $specialty = Specialty::create(['name' => 'Cardiology', 'slug' => 'cardiology', 'icon' => '❤️']);
        Doctor::create([
            'specialty_id'    => $specialty->id,
            'name'            => 'Test Doctor',
            'rating'          => 4.5,
            'price'           => 50,
            'years_experience'=> 5,
            'is_active'       => true,
        ]);

        $user = User::factory()->create();
        $this->actingAs($user)
            ->get('/doctors')
            ->assertOk()
            ->assertSee('Test Doctor')
            ->assertSee('Cardiology');
    }

    public function test_patient_can_book_an_appointment(): void
    {
        $specialty = Specialty::create(['name' => 'Cardiology', 'slug' => 'cardiology']);
        $doctor = Doctor::create([
            'specialty_id'    => $specialty->id,
            'name'            => 'Test Doctor',
            'rating'          => 4.5,
            'price'           => 50,
            'years_experience'=> 5,
            'is_active'       => true,
        ]);

        $date = Carbon::tomorrow();
        DoctorSchedule::create([
            'doctor_id'   => $doctor->id,
            'day_of_week' => $date->dayOfWeekIso,
            'start_time'  => '09:00',
            'end_time'    => '17:00',
            'slot_minutes'=> 30,
        ]);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post("/doctors/{$doctor->id}/book", [
                'date'  => $date->toDateString(),
                'time'  => '10:00',
                'notes' => 'Headache for 3 days',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $user->id,
            'doctor_id'  => $doctor->id,
            'time'       => '10:00',
            'status'     => 'confirmed',
        ]);
    }

    public function test_double_booking_same_slot_is_rejected(): void
    {
        $specialty = Specialty::create(['name' => 'Cardiology', 'slug' => 'cardiology']);
        $doctor = Doctor::create([
            'specialty_id'    => $specialty->id,
            'name'            => 'Test Doctor',
            'rating'          => 4.5,
            'price'           => 50,
            'years_experience'=> 5,
            'is_active'       => true,
        ]);

        $date = Carbon::tomorrow();
        DoctorSchedule::create([
            'doctor_id'   => $doctor->id,
            'day_of_week' => $date->dayOfWeekIso,
            'start_time'  => '09:00',
            'end_time'    => '17:00',
            'slot_minutes'=> 30,
        ]);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user1)->post("/doctors/{$doctor->id}/book", [
            'date' => $date->toDateString(),
            'time' => '10:00',
        ])->assertRedirect();

        $this->actingAs($user2)->post("/doctors/{$doctor->id}/book", [
            'date' => $date->toDateString(),
            'time' => '10:00',
        ])->assertSessionHasErrors('time');

        $this->assertSame(1, Appointment::count());
    }

    public function test_patient_can_submit_quick_care_request(): void
    {
        $specialty = Specialty::create(['name' => 'General Practice', 'slug' => 'gp']);
        $user = User::factory()->create();

        $this->actingAs($user)->post('/quick-care', [
            'specialty_id' => $specialty->id,
            'reason'       => 'I have had a sore throat and mild fever for 2 days.',
            'urgency'      => 'normal',
        ])->assertRedirect();

        $this->assertDatabaseHas('quick_care_requests', [
            'patient_id'   => $user->id,
            'specialty_id' => $specialty->id,
            'status'       => 'pending',
        ]);
    }
}
