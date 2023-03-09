<?php

namespace Database\Seeders;

use App\Http\Controllers\Admin\DataInitController;
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
        $initCtrl = new DataInitController();
        $initCtrl->init();
    }
}
