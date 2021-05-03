<?php

namespace App\Http\Controllers;

use App\Models\reserva;
use App\Models\bloque;
use App\Models\espacio_fisico;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role == 'admin'){
            $todas_las_reservas = reserva::all()->sortByDesc("start");
            $users = User::all();
            $bloques = bloque::all();
            $salas = espacio_fisico::all();
            return view('reservas.index', compact('users','todas_las_reservas', 'bloques', 'salas'));
        }
        else{
            $id = auth()->user()->id;
            $sql = "SELECT * FROM `reserva` WHERE reserva.usuario_id = $id ORDER BY reserva.start DESC";
            $reservas = DB::select($sql);
            $bloques = bloque::all();
            $salas = espacio_fisico::all();
            return view('reservas.index', compact('reservas', 'bloques', 'salas'));
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
        $reserva = new reserva();
        $reserva->descripcion = $request->asunto;
        $reserva->start = $request->fecha;
        $reserva->end = $request->fecha;
        $reserva->usuario_id = auth()->user()->id;
        $reserva->espacioFisico_id = $request->salaid;
        $reserva->bloque_id = $request->numero;
        $reserva->save();
        return response($reserva);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function show(reserva $reserva)
    {
        $reservas = reserva::all();
        return response()->json($reservas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function edit(reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $reserva = reserva::find($request->id);
        $reserva->delete();
        return response($reserva);
    }
}
