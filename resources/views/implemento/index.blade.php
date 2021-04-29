@extends('layouts.app')

@section('content')

    <section style="padding-top:15px">
            <div class="container col-10" style="margin-top:70px">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Implementos <button type="button" class="btn btn-success" style="float:right" data-toggle="modal" data-target="#crearImplemento">Crear Implemento</button>
                            </div>
                            <div class="card-body">
                                <table id="salasTable" class="table table-striped">
                                    <thead>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($implementos as $implemento)
                                            <tr id="pid{{ $implemento->id }}">
                                                <td>{{$implemento->id}}</td>
                                                <td>{{$implemento->nombre}}</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-info" onclick="editarImplemento('{{$implemento->id}}')">Editar</a>
                                                    <button type="button" class="btn btn-danger" onclick="eliminarImplemento('{{$implemento->id}}', '{{$implemento->nombre}}')">Eliminar</button>
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

    <!-- Modal crear implemento -->
    <div class="modal fade" id="crearImplemento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear implemento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FormcrearImplemento">
                            @csrf
                            <div class="form-group">
                                <label for="nombre">Sala</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Ej: Proyector Data"> 
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

    <!-- Modal editar implemento -->
    <div class="modal fade" id="editarImplemento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Implemento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FormeditarImplemento">
                        @csrf
                        <input type="hidden" name="idImplemento" id="idImplemento">
                        <div class="form-group">
                            <label for="nombre">Implemento</label>
                            <input type="text" class="form-control" id="nombreEditar" placeholder="Ej: Proyector Data">
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
        $("#FormcrearImplemento").submit(function(e){
            e.preventDefault();
            let nombre = $("#nombre").val();
            let _token = $("input[name=_token]").val();

            $.ajax({
                url:"{{route('implemento.store')}}",
                type:"POST",
                data:{
                      nombre:nombre,
                      _token:_token,
                    },
                    success:function(response)
                    {
                        //DEBO MEJORAR ESTA PARTE
                        if(response){
                            swal({
                                title: "El registro del implemento "+response.nombre+" fue exitoso",
                                icon: "success",
                            });
                            setTimeout(location.reload(), 2000);
                            
                        }
                    }
                });
             });
        </script>

    <script>
        function editarImplemento(id){
                $.get('/implemento/'+id, function(implemento){
                    $("#idImplemento").val(implemento.id);
                    $("#nombreEditar").val(implemento.nombre);
                    $("#editarImplemento").modal('toggle');
                })
            }
    </script>

    <script>
        $("#FormeditarImplemento").submit(function(e){
                e.preventDefault();

                let id = $("#idImplemento").val();
                let nombre = $("#nombreEditar").val();
                let _token = $("input[name=_token]").val();

                $.ajax({
                    url:"{{route('implemento.update')}}",
                    type:"PUT",
                    data:{
                        id:id,
                        nombre:nombre,
                        _token:_token,
                    },
                    success:function(response){
                        $('#pid' + response.id +' td:nth-child(1) ').text(response.id);
                        $('#pid' + response.id +' td:nth-child(2) ').text(response.nombre);
                        $("#editarImplemento").modal('toggle');
                        $("#FormeditarImplemento")[0].reset();
                        swal({
                                title: "Modificación realizada correctamente",
                                icon: "success",
                            });
                    }
                });
            });
    </script>

     <script>
        function eliminarImplemento(id, nombre){
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
                        url:"{{route('implemento.destroy')}}",
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
   
    

@endsection