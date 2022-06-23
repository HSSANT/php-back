<?php

use Illuminate\Database\Seeder;
use App\Models\Buys;

class BuysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Buys::class, 50)->create();
    }
}
