<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::first() ?? Company::create(['name' => 'Test Company']);

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'       => 'Admin User',
                'password'   => Hash::make('password'),
                'role'       => 'admin',
                'company_id' => $company->id,
            ]
        );
    }
}
