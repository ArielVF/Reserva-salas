@extends('layouts.app')

@section('content')

    <section style="padding-top:15px">
            <div class="container col-10" style="margin-top:70px">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Reservar salas para {{$date}}
                            </div>
                            <div class="card-body">
                                <table id="salasTable" class="table table-striped">
                                    <thead>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Numero sillas</th>
                                        <th>Bloques</th>
                                        <th>Implementos</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($salas as $sala)
                                            <tr id="pid{{ $sala->id }}">
                                                <td>{{$sala->id}}</td>
                                                <td>{{$sala->descripcion}}</td>
                                                <td>{{ $sala->sillas}}</td>
                                                <td>
                                                <!--Filtramos de acuerdo a los bloques disponibles o asignados -->
                                                    @foreach($bloques as $bloque)
                                                        <?php $no_asignado=true ?> 
                                                        @foreach($reservas as $reserva)
                                                            @if($reserva->bloque_id == $bloque->id && $reserva->espacioFisico_id == $sala->id && $reserva->start == $date)
                                                                @if($reserva->usuario_id == auth()->user()->id)
                                                                    <a class="btn btn-primary" onclick="modificarBloque()">{{$bloque->id}}</a>
                                                                @else
                                                                    <a class="btn btn-danger" onclick="verBloque()">{{$bloque->id}}</a>
                                                                @endif 
                                                            <?php $no_asignado=false ?> 
                                                            @break
                                                            @endif
                                                        @endforeach
                                                        @if($no_asignado)
                                                            <a class="btn btn-success" onclick="asignarBloque('{{$bloque->id}}', '{{$bloque->hora_inicio}}', '{{$bloque->hora_termino}}', '{{$sala->id}}', '{{$date}}')">{{$bloque->id}}</a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td><a class="btn btn-warning" onclick="obtenerImplementos('{{$sala->id}}')">Ver</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <!-- Modal asignar Bloque -->
    <div class="modal fade" id="asignarBloque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content col-10">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar Bloque</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FormBloque">
                        @csrf
                        <input type="hidden" name="salaid" id="salaid">
                        <input type="hidden" name="fecha_actual" id="fecha_actual">
                        <div class="form-group row" style="float:center">
                            <label for="numBloque" class="col-sm-2 col-form-label">Bloque</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="numero" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="horaInicio" class="col-sm-2 col-form-label">Inicio</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="horaInicio" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="horaTermino" class="col-sm-2 col-form-label">Termino</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="horaTermino" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="asunto" class="col-sm-2 col-form-label">Asunto</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="asunto" placeholder="Ej: Clase Cálculo 3">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Asignar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal ver Implementos -->
    <div class="modal fade" id="implementosSala" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content col-12">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Implementos Sala</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="contenido" class="modal-body">
                    <!-- aqui se muestran los implementos y footer modal-->
                </div>
            </div>
        </div>
    </div>

    <!-- Script para obtener implementos especificos de una sala al pulsar el boton ver -->
    <script>
        function obtenerImplementos(id) {
            $.ajax({
                url:"{{route('espaciotieneimplemento.show')}}",
                    type:"GET",
                    data:{
                        id:id,
                    },
                    success:function(response){
                        var texto = '<table class="table"><thead><tr><th>Nombre Implemento</th><th>Cantidad</th></tr></thead><tbody>';
                        if(Object.entries(response).length === 0){
                            texto = texto+'<tr><td>Sin implementos</td><td>0</td></tr>';
                        }
                        else{
                            response.forEach(myFunction);
                            function myFunction(value) {
                                texto = texto+'<tr><td>'+value[0].nombre+'</td><td>'+value[0].cantidad+'</td></tr>';
                            }

                        }
                        texto = texto+'</tbody></table><div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div>';
                        $("#contenido").html(texto);
                        $("#implementosSala").modal('show');
                       
                    }
                });
        }
    </script>

    <script>
        function asignarBloque(id, hora_inicio, hora_termino, sala_id, fecha_actual){
            $("#fecha_actual").val(fecha_actual);
            $("#salaid").val(sala_id);
            $("#numero").val(id);
            $("#horaInicio").val(hora_inicio);
            $("#horaTermino").val(hora_termino);
            $("#asignarBloque").modal('toggle');
        }
    </script>

    <script>
        $("#FormBloque").submit(function(e){
            e.preventDefault();

            let asunto = $("#asunto").val();
            let salaid = $("#salaid").val();
            let numero = $("#numero").val();
            let fecha = $("#fecha_actual").val();
            let _token = $("input[name=_token]").val();

            console.log(fecha);

            $.ajax({
                url:"{{route('reserva.store')}}",
                type:"POST",
                data:{
                      asunto:asunto,
                      salaid:salaid,
                      numero:numero,
                      fecha:fecha,
                      _token:_token
                    },
                    success:function(response)
                    {
                        //DEBO MEJORAR ESTA PARTE
                        if(response){
                            swal({
                                title: "La asignacion del bloque "+response.bloque_id+" fue exitosa.",
                                icon: "success",
                            });
                            setTimeout(location.reload(), 2000);   
                        }
                    }
                });
             });
        </script>
        
@endsection