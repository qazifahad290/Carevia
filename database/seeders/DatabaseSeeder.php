<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            Specialty::create($s);
        }

        $doctors = [
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

        foreach ($doctors as $i => [$name, $specId, $rating, $price, $years, $location]) {
            Doctor::create([
                'specialty_id'    => $specId,
                'name'            => $name,
                'bio'             => $bios[$i % count($bios)],
                'rating'          => $rating,
                'price'           => $price,
                'years_experience'=> $years,
                'location'        => $location,
                'is_active'       => true,
            ]);
        }

        foreach (Doctor::all() as $doctor) {
            for ($day = 1; $day <= 5; $day++) {
                DoctorSchedule::create([
                    'doctor_id'   => $doctor->id,
                    'day_of_week' => $day,
                    'start_time'  => '09:00',
                    'end_time'    => '17:00',
                    'slot_minutes'=> 30,
                ]);
            }
        }

        User::create([
            'name'     => 'Demo Patient',
            'email'    => 'patient@demo.com',
            'password' => Hash::make('password'),
            'phone'    => '+1 (555) 123-4567',
            'dob'      => '1995-06-15',
            'address'  => '123 Main St, New York, NY',
        ]);
    }
}
