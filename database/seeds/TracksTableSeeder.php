<?php

use Illuminate\Database\Seeder;

class TracksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Track::class, 20)->create();
    }
}
