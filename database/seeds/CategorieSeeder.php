<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=100;$i<508;$i++)
        {
            if (in_array($i,[107,207,307,407,507]))
            {
                $i+=100-7;
            }
            if($i<300)
            {
                DB::table('categorie')->insert([
                    'matiere' => 'info_'.$i,
                    'licence' => 'L1'
                ]);
            }
            elseif ($i<500)
            {
                DB::table('categorie')->insert([
                    'matiere' => 'info_'.$i,
                    'licence' => 'L2'
                ]);
            }
            elseif ($i<700)
            {
                DB::table('categorie')->insert([
                    'matiere' => 'info_'.$i,
                    'licence' => 'L3'
                ]);
            }
        }
    }
}
