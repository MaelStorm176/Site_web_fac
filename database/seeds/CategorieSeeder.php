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
        for($i=101;$i<103;$i++) {
            DB::table('categorie')->insert([
                'matiere' => 'INFO_' . $i,
                'licence' => 'L1'
            ]);
        }
        DB::table('categorie')->insert([
            ['matiere' => 'INFO_' . $i,
            'licence' => 'L1'],
            ['matiere' => 'MA0101',
            'licence' => 'L1'],
            ['matiere' => 'MA0102',
            'licence' => 'L1'],
            ['matiere' => 'ANGLAIS100',
            'licence' => 'L1']
        ]);

        for($i=201;$i<206;$i++) {
            DB::table('categorie')->insert([
                ['matiere' => 'INFO_'.$i,
                'licence' => 'L1']
            ]);
        }
        DB::table('categorie')->insert([
            ['matiere' => 'PPRO200',
                'licence' => 'L1'],
            ['matiere' => 'ANGLAIS200',
                'licence' => 'L1']
        ]);


        //L2

        for($i=301;$i<307;$i++)
        {
            DB::table('categorie')->insert([
                'matiere' => 'INFO_'.$i,
                'licence' => 'L2'
            ]);
        }
        DB::table('categorie')->insert([
            ['matiere' => 'PPRO300',
                'licence' => 'L2'],
            ['matiere' => 'ANGLAIS300',
                'licence' => 'L2']
        ]);

        for($i=401;$i<404;$i++)
        {
            DB::table('categorie')->insert([
                'matiere' => 'INFO_'.$i,
                'licence' => 'L2'
            ]);
        }
        DB::table('categorie')->insert([
            ['matiere' => 'PPRO400',
                'licence' => 'L2'],
            ['matiere' => 'ANGLAIS400',
                'licence' => 'L2'],
            ['matiere' => 'MINF0401',
                'licence' => 'L2'],
            ['matiere' => 'MINF0402',
                'licence' => 'L2']
        ]);

        //L3

        for($i=501;$i<504;$i++)
        {
            DB::table('categorie')->insert([
                'matiere' => 'INFO_'.$i,
                'licence' => 'L3'
            ]);
        }
        DB::table('categorie')->insert([
            ['matiere' => 'PPRO500',
            'licence' => 'L3'],
            ['matiere' => 'ANGLAIS500',
            'licence' => 'L3']
        ]);

        for($i=601;$i<607;$i++)
        {
            DB::table('categorie')->insert([
                'matiere' => 'INFO_'.$i,
                'licence' => 'L3'
            ]);
        }
        DB::table('categorie')->insert([
            ['matiere' => 'PPRO600',
                'licence' => 'L3'],
            ['matiere' => 'ANGLAIS600',
                'licence' => 'L3']
        ]);
    }
}
