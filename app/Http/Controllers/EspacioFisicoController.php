<?php

namespace App\Http\Controllers;

use App\Models\espacio_fisico;
use App\Models\bloque;
use App\Models\reserva;
use Illuminate\Http\Request;

class EspacioFisicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Generamos bloques universitarios
        
        //Validamos que el parametro sea una fecha.
        $date = $request->date;
        $salas = espacio_fisico::all();
        $bloques = bloque::all();
        $reservas = reserva::all();

        if (date('Y-m-d', strtotime($date)) == $date) {
            return view('salas.index', compact('date', 'salas', 'bloques', 'reservas'));
        }
        else{         //MEJORAR ESTA PARTEEEE
            $mensaje = "no existe la ruta";
            return view('reservas.index')->with('mensaje');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $espacio_fisico = new espacio_fisico();
        $espacio_fisico->descripcion = $request->nombre;
        $espacio_fisico->sillas = $request->cantidadsillas;
        $espacio_fisico->save();
        return response($espacio_fisico);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\espacio_fisico  $espacio_fisico
     * @return \Illuminate\Http\Response
     */
    public function show(espacio_fisico $espacio_fisico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\espacio_fisico  $espacio_fisico
     * @return \Illuminate\Http\Response
     */
    public function edit($espacio_fisico)
    {
        $sala = espacio_fisico::find($espacio_fisico);
        return response($sala);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\espacio_fisico  $espacio_fisico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, espacio_fisico $espacio_fisico)
    {
        $sala = espacio_fisico::find($request->id);
        $sala->descripcion = $request->nombre;
        $sala->sillas = $request->sillas;
        $sala->save();
        return response($sala);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\espacio_fisico  $espacio_fisico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, espacio_fisico $espacio_fisico)
    {
        $sala = espacio_fisico::find($request->id);
        $sala->delete();
        return response($sala);
    }

    public function management()
    {
        $salas = espacio_fisico::all();
        return view('gestion.index', compact('salas'));
    }
}
