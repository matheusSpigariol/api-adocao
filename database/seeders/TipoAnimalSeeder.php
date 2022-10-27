<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoAnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Carbon::now();

        DB::table('tipo_animal')->insert([
            'titulo' => "cão",
            "created_at" => $data,
            "updated_at" =>  $data
        ]);

        DB::table('tipo_animal')->insert([
            'titulo' => "gato",
            "created_at" => $data,
            "updated_at" =>  $data
        ]);
    }
}
