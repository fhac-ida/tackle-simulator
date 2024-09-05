<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_profiles')->insert([
            'profile_name' => 'Test123',
            'user_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
