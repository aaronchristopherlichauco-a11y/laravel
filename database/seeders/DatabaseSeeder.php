<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@edutrack.com',
            'password' => Hash::make('password'),
            'gender'   => 'Prefer not to say',
            'phone'    => '09XX-XXX-XXXX',
            'address'  => 'CvSU Campus, Indang, Cavite',
        ]);

        // Demo student
        $student = User::create([
            'name'     => 'Juan Dela Cruz',
            'email'    => 'juan@edutrack.com',
            'password' => Hash::make('password'),
            'gender'   => 'Male',
            'phone'    => '0912-345-6789',
            'address'  => 'Indang, Cavite',
        ]);

        $colors = ['#2d6a4f','#40916c','#1e6091','#7b2d8b','#e9c46a','#f4a261','#168aad'];

        // Sample schedules for admin
        $schedules = [
            ['subject_name' => 'Web Systems and Technologies', 'subject_code' => 'ITEC 106', 'instructor' => 'Prof. Reyes', 'room' => 'Lab 301', 'day' => 'Monday', 'start_time' => '07:30', 'end_time' => '10:30'],
            ['subject_name' => 'Platform Technologies', 'subject_code' => 'ITEC 107', 'instructor' => 'Prof. Santos', 'room' => 'Lab 302', 'day' => 'Tuesday', 'start_time' => '10:30', 'end_time' => '13:30'],
            ['subject_name' => 'Data Structures and Algorithms', 'subject_code' => 'COSC 204', 'instructor' => 'Prof. Cruz', 'room' => 'Room 201', 'day' => 'Wednesday', 'start_time' => '13:30', 'end_time' => '15:30'],
            ['subject_name' => 'Database Management Systems', 'subject_code' => 'ITEC 85', 'instructor' => 'Prof. Garcia', 'room' => 'Lab 303', 'day' => 'Thursday', 'start_time' => '07:30', 'end_time' => '10:30'],
            ['subject_name' => 'Object-Oriented Programming', 'subject_code' => 'COSC 101', 'instructor' => 'Prof. Diaz', 'room' => 'Lab 304', 'day' => 'Friday', 'start_time' => '10:30', 'end_time' => '12:30'],
            ['subject_name' => 'Mathematics in the Modern World', 'subject_code' => 'GEED 101', 'instructor' => 'Prof. Flores', 'room' => 'Room 105', 'day' => 'Monday', 'start_time' => '15:30', 'end_time' => '17:00'],
        ];

        foreach ($schedules as $i => $s) {
            Schedule::create(array_merge($s, [
                'user_id'     => $admin->id,
                'semester'    => '2nd Semester',
                'school_year' => '2024-2025',
                'color'       => $colors[$i % count($colors)],
            ]));
        }
    }
}
