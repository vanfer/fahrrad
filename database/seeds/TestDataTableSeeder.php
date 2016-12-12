<?php

use App\Abschnitt;
use App\Fahrer;
use App\Fahrrad;
use App\Modus;
use App\Strecke;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('fahrer')->truncate();
        Fahrer::create(['name' => 'test', 'email' => 'test@test.local']);
        Fahrer::create(['name' => 'test2']);
        Fahrer::create(['name' => 'test3', 'groesse' => 1.85, 'gewicht' => 85]);
        Fahrer::create(['name' => 'test4', 'email' => 'test4@test.local', 'gewicht' => 87]);


        DB::table('strecke')->truncate();
        for($i = 1; $i <= 3; $i++){
            Strecke::create(['name' => 'Strecke '.$i]);
        }

        DB::table('modus')->truncate();
        Modus::create(['name' => 'Strecke']);
        Modus::create(['name' => 'Konstantes Drehmoment']);
        Modus::create(['name' => 'Konstante Leistung']);

        DB::table('abschnitt')->truncate();
        for($i = 1; $i <= 3; $i++){
            for($j = 0; $j <= 9; $j++){
                Abschnitt::create(['strecke_id' => $i, 'hoehe' => (rand(5, 15) * 10), 'laenge' => rand(10, 300)]);
            }
        }

        DB::table('fahrrad')->truncate();
        for($i = 1; $i <= 3; $i++){
            Fahrrad::create(['ip' => '10.0.0.'.$i, 'mac' => '00:00:00:00:00:0'.$i]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
