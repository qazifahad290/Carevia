<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Specialty;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            ['name' => 'Cardiology',          'slug' => 'cardiology',          'icon' => '❤️'],
            ['name' => 'Dermatology',         'slug' => 'dermatology',         'icon' => '🧴'],
            ['name' => 'Pediatrics',          'slug' => 'pediatrics',          'icon' => '👶'],
            ['name' => 'General Practice',    'slug' => 'general-practice',    'icon' => '🩺'],
            ['name' => 'Neurology',           'slug' => 'neurology',           'icon' => '🧠'],
            ['name' => 'Orthopedics',         'slug' => 'orthopedics',         'icon' => '🦴'],
        ];

        foreach ($specialties as $s) {
            Specialty::firstOrCreate(['slug' => $s['slug']], $s);
        }

        $doctorSeed = [
            ['Sarah Johnson',     1, 4.9, 75,  8, 'New York, NY'],
            ['Michael Chen',      1, 4.7, 90, 12, 'New York, NY'],
            ['Priya Patel',       2, 4.8, 60,  6, 'Brooklyn, NY'],
            ['Emily Rodriguez',   2, 4.6, 55,  4, 'Queens, NY'],
            ['James Williams',    3, 4.9, 70, 15, 'Manhattan, NY'],
            ['Aisha Khan',        3, 4.8, 65, 10, 'Bronx, NY'],
            ['David Kim',         4, 4.5, 45,  3, 'New York, NY'],
            ['Olivia Brown',      4, 4.7, 50,  7, 'Brooklyn, NY'],
            ['Liam Garcia',       5, 4.9, 110, 14, 'Manhattan, NY'],
            ['Noah Martinez',     6, 4.6, 95,  9, 'Queens, NY'],
        ];

        $bios = [
            'Board-certified specialist with extensive experience. Focused on patient-centered care and evidence-based treatment plans.',
            'Compassionate clinician dedicated to helping patients achieve their best health. Published researcher in the field.',
            'Experienced practitioner with a warm, attentive approach. Specializes in personalized treatment for every patient.',
            'Skilled professional committed to delivering high-quality care and building long-term patient relationships.',
        ];

        $demoPatient = User::updateOrCreate(
            ['email' => 'patient@demo.com'],
            [
                'name'     => 'Demo Patient',
                'password' => Hash::make('password'),
                'role'     => User::ROLE_PATIENT,
                'phone'    => '+1 (555) 123-4567',
                'dob'      => '1995-06-15',
                'address'  => '123 Main St, New York, NY',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@carevia.test'],
            [
                'name'     => 'Site Admin',
                'password' => Hash::make('password'),
                'role'     => User::ROLE_ADMIN,
                'phone'    => '+1 (555) 000-0001',
            ]
        );

        $extraPatients = [
            ['John Carter',     'john@example.com',    '+1 (555) 220-1010'],
            ['Maria Lopez',     'maria@example.com',   '+1 (555) 220-2020'],
            ['Robert Singh',    'robert@example.com',  '+1 (555) 220-3030'],
        ];
        foreach ($extraPatients as [$name, $email, $phone]) {
            User::updateOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => Hash::make('password'), 'role' => User::ROLE_PATIENT, 'phone' => $phone]
            );
        }

        foreach ($doctorSeed as $i => [$name, $specId, $rating, $price, $years, $location]) {
            $slug = Str::slug($name, '.');
            $email = "dr.{$slug}@carevia.test";

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'     => $name,
                    'password' => Hash::make('password'),
                    'role'     => User::ROLE_DOCTOR,
                    'phone'    => '+1 (555) 100-' . str_pad((string) (1000 + $i), 4, '0', STR_PAD_LEFT),
                ]
            );

            $doctor = Doctor::updateOrCreate(
                ['name' => $name],
                [
                    'user_id'         => $user->id,
                    'specialty_id'    => $specId,
                    'bio'             => $bios[$i % count($bios)],
                    'rating'          => $rating,
                    'price'           => $price,
                    'years_experience'=> $years,
                    'location'        => $location,
                    'is_active'       => true,
                ]
            );

            for ($day = 1; $day <= 5; $day++) {
                DoctorSchedule::updateOrCreate(
                    ['doctor_id' => $doctor->id, 'day_of_week' => $day],
                    [
                        'start_time'  => '09:00',
                        'end_time'    => '17:00',
                        'slot_minutes'=> 30,
                    ]
                );
            }
        }

        $sarah  = Doctor::where('name', 'Sarah Johnson')->first();
        $james  = Doctor::where('name', 'James Williams')->first();
        $michael = Doctor::where('name', 'Michael Chen')->first();
        $john   = User::where('email', 'john@example.com')->first();
        $maria  = User::where('email', 'maria@example.com')->first();

        $samples = [
            [$demoPatient, $sarah,   Carbon::today()->addDays(2)->toDateString(), '10:00', 'confirmed', 'Annual checkup'],
            [$demoPatient, $james,   Carbon::today()->addDays(5)->toDateString(), '14:30', 'confirmed', null],
            [$demoPatient, $michael, Carbon::today()->subDays(7)->toDateString(), '11:00', 'completed', 'Follow-up'],
            [$john,        $sarah,   Carbon::today()->addDays(1)->toDateString(), '09:30', 'confirmed', null],
            [$maria,       $sarah,   Carbon::today()->addDays(3)->toDateString(), '15:00', 'confirmed', 'New patient'],
        ];

        foreach ($samples as [$patient, $doctor, $date, $time, $status, $notes]) {
            Appointment::firstOrCreate(
                ['doctor_id' => $doctor->id, 'date' => $date, 'time' => $time],
                [
                    'patient_id' => $patient->id,
                    'status'     => $status,
                    'notes'      => $notes,
                ]
            );
        }
    }
}
