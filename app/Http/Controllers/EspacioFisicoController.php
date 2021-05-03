<?php

namespace App\Http\Controllers;

use App\Models\espacio_fisico;
use App\Models\bloque;
use App\Models\implementos;
use App\Models\reserva;
use DB;
use App\Models\implementos_de_espacio;
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

        //Obtenemos id de la insercion anterior.
        $sql = "SELECT MAX(id) AS id FROM `espacio_fisico`";
        $salas = DB::select($sql);
        foreach($salas as $sala){
             $id = $sala->id;
        }
    
        //Creamos el enlace entre EspacioFisico e Implementos (si es que existen)
        if(!(empty($request->implementos))){
            for ($i = 0; $i < (sizeof($request->implementos)); $i++) {
                $implementosDeEspacio = new implementos_de_espacio();
                $implementosDeEspacio->implemento_id = $request->implementos[$i];
                $implementosDeEspacio->espacioFisico_id = $id;
                $implementosDeEspacio->cantidad = $request->cantidadesImplementos[$i]; //<--- hay que cambiar eso en el futuro
                $implementosDeEspacio->save();
            }
        }
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
    public function edit(Request $request)
    {
        $datos = array();
        $sala = espacio_fisico::find($request->id);

        $id = $sala->id;
        $sql = "SELECT T1.implemento_id, T1.cantidad FROM (SELECT implemento_id, cantidad FROM implementos_de_espacios WHERE implementos_de_espacios.espacioFisico_id = $id) AS T1, implemento WHERE T1.implemento_id = implemento.id";
        array_push($datos, DB::select($sql));
        array_push($datos, implementos::all());
        array_push($datos, $sala);

        return response($datos);
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
        
        //Si el usuario selecciono implementos a modificar se debe hacer el analisis para la actualizacion
        if(!(empty($request->implementos))){
            $id = $sala->id;
            $sql = "SELECT * FROM implementos_de_espacios WHERE implementos_de_espacios.espacioFisico_id = $id";
            $implementos_de_espacio_especifico = DB::select($sql); //Obtenemos los implementos que tiene la sala.
            
            //Si la sala no tiene implementos asociados, se crean
            if((sizeof($implementos_de_espacio_especifico)) == 0){
                for($i=0; $i < (sizeof($request->implementos)); $i++){
                    $implementosDeEspacio = new implementos_de_espacio();
                    $implementosDeEspacio->implemento_id = $request->implementos[$i];
                    $implementosDeEspacio->espacioFisico_id = $id;
                    $implementosDeEspacio->cantidad = $request->cantidadesImplementos[$i];
                    $implementosDeEspacio->save();
                }
            }
            //Si la sala ya tiene implementos asociados, se revisan las actualizaciones y agregaciones (si es una mezcla)
            else{
                    foreach($implementos_de_espacio_especifico as $implemento_de_espacio_especifico){
                        for($i=0; $i < sizeof($request->implementos); $i++){
                            if(($implemento_de_espacio_especifico->implemento_id) == ($request->implementos[$i])){
                                $id_implemento_de_espacio = $implemento_de_espacio_especifico->id;
                                $cantidad = $request->cantidadesImplementos[$i];
                                //Si una cantidad es 0, significa que ese elemnento no existe para esa sala, por tanto, se elimina.
                                if($cantidad == 0){
                                    $sql = "DELETE FROM `implementos_de_espacios` WHERE implementos_de_espacios.id = $id_implemento_de_espacio";
                                    DB::delete($sql);
                                } 
                                //caso contrario, se actualiza por el valor solicitado.
                                else{
                                    $sql = "UPDATE `implementos_de_espacios` SET implementos_de_espacios.cantidad = $cantidad WHERE implementos_de_espacios.id = $id_implemento_de_espacio";
                                    DB::update($sql);
                                }
                                
                                $aux_implemento = $request->implementos;
                                $aux_cantidad = $request->cantidadesImplementos;
                                echo sizeof($aux_implemento);
                                
                                //Eliminamos el elemento agregado.
                                array_splice($aux_implemento, $i, 1);
                                array_splice($aux_cantidad, $i, 1); 

                                echo sizeof($aux_implemento);
                                
                                $request->implementos = $aux_implemento;
                                $request->cantidadesImplementos = $aux_cantidad;
                            }
                        }
                    }
                    //Cuando se termina el for anterior, se comienza con la asignacion de nuevos elementos, como eliminamos los ya existentes, en nuestro array solo quedan los implementos que no se han agregado.
                    for($i=0; $i < (sizeof($request->implementos)); $i++){
                        $implementosDeEspacio = new implementos_de_espacio();
                        $implementosDeEspacio->implemento_id = $request->implementos[$i];
                        $implementosDeEspacio->espacioFisico_id = $id;
                        $implementosDeEspacio->cantidad = $request->cantidadesImplementos[$i];
                        $implementosDeEspacio->save();
                    }
                }
                
        }
        //si no, se retorna a la vista
        else{
            return response($sala);
        }    
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
        $implementos = implementos::all();
        return view('gestion.index', compact('salas', 'implementos'));
    }
}
