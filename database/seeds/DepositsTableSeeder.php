<?php

use Illuminate\Database\Seeder;
use App\Models\Deposits;

class DepositsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Deposits::class, 10)->create();
    }
}
