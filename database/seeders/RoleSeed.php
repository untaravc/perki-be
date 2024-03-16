<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => "Superadmin",
            ],
        ];

        foreach ($data as $datum) {
            try {
                DB::table('roles')->insert($datum);
            } catch (\Exception $e) {
            }
        }
    }
}
