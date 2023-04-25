<?php

namespace Database\Seeders;

use App\Http\Controllers\System\DataInitController;
use App\Http\Controllers\System\UserInitController;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $initCtrl = new UserInitController();
        $initCtrl->user_init();
    }
}
