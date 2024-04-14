<?php

namespace Database\Seeders;

use App\Models\Role;
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
            $exist = Role::whereName($datum['name'])->first();

            if(!$exist){
                Role::create($datum);
            }
        }
    }
}
