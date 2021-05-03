<?php

namespace App\Http\Controllers;

use App\Models\implementos_de_espacio;
use Illuminate\Http\Request;
use DB;

class ImplementosDeEspacioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\implementos_de_espacio  $implementos_de_espacio
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //obtenemos los id de implementos de espacio fisico que tiene la sala a consultar.
        $id = $request->id;
        $sql = "SELECT * FROM `implementos_de_espacios` WHERE implementos_de_espacios.espacioFisico_id = $id";
        $implementos_de_espacio_sala_especifica = DB::select($sql);

        //con los id obtenemos los datos de los implementos asociados a la sala.
        $implementos = array();
        $cantidad = array();
        foreach($implementos_de_espacio_sala_especifica as $implementos_sala){
            $id = $implementos_sala->implemento_id;
            $cantidad = $implementos_sala->cantidad;
            $sql = "SELECT nombre,cantidad FROM `implemento`, `implementos_de_espacios` WHERE implemento.id = $id AND implementos_de_espacios.cantidad = $cantidad";
            $elemento = DB::select($sql);
            array_push($implementos, $elemento);
        }
        return response($implementos);   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\implementos_de_espacio  $implementos_de_espacio
     * @return \Illuminate\Http\Response
     */
    public function edit(implementos_de_espacio $implementos_de_espacio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\implementos_de_espacio  $implementos_de_espacio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, implementos_de_espacio $implementos_de_espacio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\implementos_de_espacio  $implementos_de_espacio
     * @return \Illuminate\Http\Response
     */
    public function destroy(implementos_de_espacio $implementos_de_espacio)
    {
        //
    }
}
