@extends('layouts.app')


@section('content')

    <section style="padding-top:15px">
            <div class="container col-10" style="margin-top:70px">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
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
                                                        @foreach($reservas as $reserva)
                                                            @if($reserva->bloque_id == $bloque->id && $sala->id == $reserva->espacioFisico_id && $date == $reserva->start)
                                                                @if($reserva->usuario_id == auth()->user()->id)
                                                                    <a class="btn btn-primary" onclick="editarBloque('{{$bloque->id}}', '{{$bloque->hora_inicio}}', '{{$bloque->hora_termino}}', '{{$sala->id}}', '{{$date}}')">{{$bloque->id}}</a>
                                                                @else
                                                                    <a class="btn btn-danger" onclick="bloqueOcupado('{{$bloque->id}}', '{{$bloque->hora_inicio}}', '{{$bloque->hora_termino}}', '{{$sala->id}}', '{{$date}}')">{{$bloque->id}}</a>
                                                                @endif
                                                            <!--Agregar ifs por hora de inicio y termino de los blouqes -->
                                                                
                                                            @endif
                                                        @endforeach
                                                        <a class="btn btn-success" onclick="asignarBloque('{{$bloque->id}}', '{{$bloque->hora_inicio}}', '{{$bloque->hora_termino}}', '{{$sala->id}}', '{{$date}}')">{{$bloque->id}}</a>
                                                    @endforeach
                                                    
                                                </td>
                                                <td><button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#implementosSala">Ver</button></td>
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

    

    <!-- jquery -->
    <script  src="https://code.jquery.com/jquery-3.5.1.js"></script> 
    <script  src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" defer></script>
    <script  src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js" defer></script>
    
    <script>
        $(document).ready(function() {
            $('#salasTable').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
            });
        } );
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