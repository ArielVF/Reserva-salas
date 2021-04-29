<?php

namespace App\Http\Controllers;

use App\Models\implementos;
use Illuminate\Http\Request;

class ImplementosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $implementos = implementos::all();
        return view('implemento.index', compact('implementos'));
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
        $implemento = new implementos();
        $implemento->nombre = $request->nombre;
        $implemento->save();
        return response($implemento);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\implementos  $implementos
     * @return \Illuminate\Http\Response
     */
    public function show(implementos $implementos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\implementos  $implementos
     * @return \Illuminate\Http\Response
     */
    public function edit($implementos)
    {
        $implemento = implementos::find($implementos);
        return response($implemento);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\implementos  $implementos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, implementos $implementos)
    {
        $implemento = implementos::find($request->id);
        $implemento->nombre = $request->nombre;
        $implemento->save();
        return response($implemento);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\implementos  $implementos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $implemento = implementos::find($request->id);
        $implemento->delete();
        return response($implemento);
    }
}
