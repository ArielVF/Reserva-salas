@extends('layouts.app')


@section('content')

<section style="padding-top:15px">
            <div class="container col-10" style="margin-top:70px">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Salas  <button type="button" class="btn btn-success" style="float:right" data-toggle="modal" data-target="#crearSala">Crear una sala</button>
                            </div>
                            <div class="card-body">
                                <table id="salasTable" class="table table-striped">
                                    <thead>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Numero sillas</th>
                                        <th>Implementos</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($salas as $sala)
                                            <tr id="pid{{ $sala->id }}">
                                                <td>{{$sala->id}}</td>
                                                <td>{{$sala->descripcion}}</td>
                                                <td>{{ $sala->sillas}}</td>
                                                <td><button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#implementosSala">Ver</button></td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-info" onclick="editarSala({{$sala->id}})">Editar</a>
                                                    <button type="button" class="btn btn-danger" onclick="eliminarSala('{{$sala->id}}', '{{$sala->descripcion}}')">Eliminar</button>
                                                </td>
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

    <!-- Modal crear sala -->
    <div class="modal fade" id="crearSala" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear una Sala</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FormcrearSala">
                            @csrf
                            <div class="form-group">
                                <label for="nombre">Sala</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Sala E5">
                            </div>
                            <div class="form-group">
                                <label for="cantidadsillas">Cantidad de sillas</label>
                                <input type="number" class="form-control" id="cantidadsillas" placeholder="Ej: 45">
                            </div>
                            <div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Crear</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal editar sala -->
    <div class="modal fade" id="editarSala" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar una Sala</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FormeditarSala">
                        @csrf
                        <input type="hidden" name="idSala" id="idSala">
                        <div class="form-group">
                            <label for="nombre">Sala</label>
                            <input type="text" class="form-control" id="nombreEditar" placeholder="Sala E5">
                        </div>
                        <div class="form-group">
                            <label for="cantidadsillas">Cantidad de sillas</label>
                            <input type="number" class="form-control" id="cantidadsillasEditar" placeholder="Ej: 45">
                        </div>
                        <div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Editar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#FormcrearSala").submit(function(e){
            e.preventDefault();

            let nombre = $("#nombre").val();
            let cantidadsillas = $("#cantidadsillas").val();
            let _token = $("input[name=_token]").val();

            console.log(nombre);

            $.ajax({
                url:"{{route('espacioFisico.store')}}",
                type:"POST",
                data:{
                      nombre:nombre,
                      cantidadsillas:cantidadsillas,
                      _token:_token
                    },
                    success:function(response)
                    {
                        //DEBO MEJORAR ESTA PARTE
                        if(response){
                            swal({
                                title: "El registro de "+response.nombre+" fue exitoso",
                                icon: "success",
                            });
                            setTimeout(location.reload(), 2000);
                            
                        }
                    }
                });
             });
        </script>

    <script>
        function editarSala(id){
                $.get('/sala/'+id, function(sala){
                    $("#idSala").val(sala.id);
                    $("#nombreEditar").val(sala.descripcion);
                    $("#cantidadsillasEditar").val(sala.sillas);
                    $("#editarSala").modal('toggle');
                })
            }
    </script>

     <script>
        function eliminarSala(id, nombre){
            let _token = $("input[name=_token]").val();
            
            swal({
                title: "¿Está seguro de eliminar "+nombre+"?",
                text: "Una vez eliminado este elemento no habrá opción de recuperar sus datos.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url:"{{route('sala.destroy')}}",
                        type:"DELETE",
                        data:{
                            id:id,
                            _token:_token,
                        },
                        success:function(response){
                            swal(nombre+" ha sido eliminada", {
                                icon: "success",
                            });
                            location.reload();
                        }
                    });
                } else {
                    swal("No se ha realizado ningún cambio");
                }
            });
        }
    </script>
   
    <script>
        $("#FormeditarSala").submit(function(e){
                e.preventDefault();

                let id = $("#idSala").val();
                let nombre = $("#nombreEditar").val();
                let sillas = $("#cantidadsillasEditar").val();
                let _token = $("input[name=_token]").val();

                $.ajax({
                    url:"{{route('sala.update')}}",
                    type:"PUT",
                    data:{
                        id:id,
                        nombre:nombre,
                        sillas:sillas,
                        _token:_token,
                    },
                    success:function(response){
                        $('#pid' + response.id +' td:nth-child(1) ').text(response.id);
                        $('#pid' + response.id +' td:nth-child(2) ').text(response.descripcion);
                        $('#pid' + response.id +' td:nth-child(3) ').text(response.sillas);
                        $("#editarSala").modal('toggle');
                        $("#FormeditarSala")[0].reset();
                        swal({
                                title: "Modificacion realizada correctamente",
                                icon: "success",
                            });
                    }
                });
            });
    </script>

@endsection