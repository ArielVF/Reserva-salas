<?php

namespace Database\Seeders;

use App\Models\bloque;
use Illuminate\Database\Seeder;

class bloqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Agregamos los bloques de la universidad
        $bloque = new Bloque();
        $bloque->hora_inicio = '08:30:00';
        $bloque->hora_termino = '09:30:00';
        $bloque->save();

        $bloque2 = new Bloque();
        $bloque2->hora_inicio = '09:40:00';
        $bloque2->hora_termino = '10:40:00';
        $bloque2->save();

        $bloque3 = new Bloque();
        $bloque3->hora_inicio = '10:50:00';
        $bloque3->hora_termino = '11:50:00';
        $bloque3->save();

        $bloque4 = new Bloque();
        $bloque4->hora_inicio = '12:00:00';
        $bloque4->hora_termino = '13:00:00';
        $bloque4->save();

        $bloque5 = new Bloque();
        $bloque5->hora_inicio = '13:10:00';
        $bloque5->hora_termino = '14:10:00';
        $bloque5->save();

        $bloque6 = new Bloque();
        $bloque6->hora_inicio = '14:20:00';
        $bloque6->hora_termino = '15:20:00';
        $bloque6->save();

        $bloque7 = new Bloque();
        $bloque7->hora_inicio = '15:30:00';
        $bloque7->hora_termino = '16:30:00';
        $bloque7->save();

        $bloque8 = new Bloque();
        $bloque8->hora_inicio = '16:40:00';
        $bloque8->hora_termino = '17:40:00';
        $bloque8->save();

        $bloque9 = new Bloque();
        $bloque9->hora_inicio = '17:50:00';
        $bloque9->hora_termino = '18:50:00';
        $bloque9->save();

        $bloque10 = new Bloque();
        $bloque10->hora_inicio = '19:00:00';
        $bloque10->hora_termino = '20:00:00';
        $bloque10->save();

        $bloque11 = new Bloque();
        $bloque11->hora_inicio = '20:10:00';
        $bloque11->hora_termino = '21:10:00';
        $bloque11->save();

        $bloque12 = new Bloque();
        $bloque12->hora_inicio = '21:20:00';
        $bloque12->hora_termino = '22:20:00';
        $bloque12->save();
    }
}
