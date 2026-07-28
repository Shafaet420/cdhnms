<?php

namespace Database\Seeders;

use App\Models\AcademicSession;
use App\Models\Institution;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoInstitutionSeeder extends Seeder
{
    public function run(): void
    {
        $institution = Institution::create([
            'institution_code' => 'INST-0001',
            'name_en' => 'Chongaon Model School & Madrasa',
            'name_bn' => 'চড়গাঁও মডেল স্কুল ও মাদ্রাসা',
            'type' => 'school',
            'status' => 'active',
        ]);

        $session = AcademicSession::create([
            'institution_id' => $institution->id,
            'name' => '2025-2026',
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
            'is_current' => true,
        ]);

        foreach (['Class One', 'Class Two', 'Class Three'] as $i => $name) {
            SchoolClass::create([
                'institution_id' => $institution->id,
                'name_en' => $name,
                'display_order' => $i + 1,
            ]);
        }

        $admin = User::create([
            'name' => 'Institution Admin',
            'email' => 'admin@demo.test',
            'password' => Hash::make('password'),
            'public_user_id' => 'USR-0001',
            'institution_id' => $institution->id,
            'account_status' => 'active',
            'must_change_password' => false,
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Institution Admin');

        $teacher = User::create([
            'name' => 'Demo Teacher',
            'email' => 'teacher@demo.test',
            'password' => Hash::make('password'),
            'public_user_id' => 'USR-0002',
            'institution_id' => $institution->id,
            'account_status' => 'active',
            'must_change_password' => false,
            'email_verified_at' => now(),
        ]);
        $teacher->assignRole('Teacher');

        // Super Admin has no institution_id — sees every institution (Part-3 data scope)
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@demo.test',
            'password' => Hash::make('password'),
            'public_user_id' => 'USR-0000',
            'institution_id' => null,
            'account_status' => 'active',
            'must_change_password' => false,
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('Super Admin');
    }
}
