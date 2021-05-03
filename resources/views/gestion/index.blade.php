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
                                                <td><a class="btn btn-warning" onclick="obtenerImplementos('{{$sala->id}}')">Ver</a></td></td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-info" onclick="editarSala('{{$sala->id}}')">Editar</a>
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
                                <label for="cantidadImplementos">Seleccionar implementos</label>
                                @foreach($implementos as $implemento)
                                    <div class="form-row align-items-center">
                                        <div class="col-auto">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input crearSalaCheck" name="checks[]" type="checkbox" value="{{$implemento->id}}" id="implemento{{$implemento->id}}">
                                                    <label class="form-check-label" for="flexCheckChecked">
                                                        {{ $implemento->nombre}}
                                                    </label>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                           <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div id="marco{{$implemento->id}}" class="input-group-text" style="visibility:hidden"><i id="icon{{$implemento->id}}" class="fas fa-sort-numeric-up" style="visibility:hidden"></i></div>
                                                </div>
                                                <input type="number" class="form-control" id="cantidadImplemento{{$implemento->id}}" placeholder="Cantidad" style="visibility:hidden">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
                        <label for="cantidadImplementos">Seleccionar implementos</label>
                            <!--- Agregar elementos con jquery-->
                            <div id="contendioEditar" class="myEditModal"></div>
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
                    <!-- aqui deberin mostrarse los implementos y footer modal-->
                </div>
            </div>
        </div>
    </div>

    <!-- Obtenemos id de implementos checkeados para habilitar vista de cantidades en el modal Crear-->
    <script>
       $(document).ready(function() {
            $(document).on('click keyup','.crearSalaCheck',function() {
                $('.crearSalaCheck:checked').each(function(){
                    $("#icon"+this.value).css({
                        "visibility": "visible"
                    });
                    $("#marco"+this.value).css({
                        "visibility": "visible"
                    });
                    $("#cantidadImplemento"+this.value).css({
                        "visibility": "visible"
                    });
                });
                $('.crearSalaCheck:not(:checked)').each(function(){
                    $("#icon"+this.value).css({
                        "visibility": "hidden"
                    });
                    $("#marco"+this.value).css({
                        "visibility": "hidden"
                    });
                    $("#cantidadImplemento"+this.value).css({
                        "visibility": "hidden"
                    });
                });
            });
        }); 
    </script>

    <!-- Obtenemos id de implementos checkeados para habilitar vista de cantidades en el modal Editar -->
    <script>
       $(document).ready(function() {
            $(document).on('click keyup','.editarSalaCheck',function() {
                $('.editarSalaCheck:checked').each(function(){
                    $("#iconEditar"+this.value).css({
                        "visibility": "visible"
                    });
                    $("#marcoEditar"+this.value).css({
                        "visibility": "visible"
                    });
                    $("#cantidadImplementoEditar"+this.value).css({
                        "visibility": "visible"
                    });
                });
                $('.editarSalaCheck:not(:checked)').each(function(){
                    $("#iconEditar"+this.value).css({
                        "visibility": "hidden"
                    });
                    $("#marcoEditar"+this.value).css({
                        "visibility": "hidden"
                    });
                    $("#cantidadImplementoEditar"+this.value).css({
                        "visibility": "hidden"
                    });
                });
            });
        }); 
    </script>
    
    <!-- Script para crear una sala -->
    <script>
        $("#FormcrearSala").submit(function(e){
            e.preventDefault();

            let nombre = $("#nombre").val();
            let cantidadsillas = $("#cantidadsillas").val();
            let _token = $("input[name=_token]").val();
            let implementos = [];
            let cantidadesImplementos = [];

            $('.crearSalaCheck:checked').each(function(){
                implementos.push(this.value);
            });

            for (let i = 0; i < implementos.length; i++) {
                cantidadesImplementos.push($("#cantidadImplemento"+implementos[i]).val());
            }
    
            $.ajax({
                url:"{{route('espacioFisico.store')}}",
                type:"POST",
                data:{
                      nombre:nombre,
                      cantidadsillas:cantidadsillas,
                      implementos:implementos,
                      cantidadesImplementos:cantidadesImplementos,
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

    <!--- Script que toma el id de la sala para buscar sus datos especificos y mostrarlos por pantalla-->
    <script>
        function editarSala(id) {
                $.ajax({
                        url:"{{route('sala.edit')}}",
                        type:"GET",
                        data:{
                            id:id,
                        },
                        success:function(response){
                            let implementos_especificos = response[0];
                            let todos_implementos = response[1];
                            let datos_sala = response[2];

                           let no_tiene_implemento;
                            let text=""
                            let aux_index;
                            for(let i=0; i < todos_implementos.length; i++){
                                no_tiene_implemento=true;
                                for(let j=0; j < implementos_especificos.length; j++){
                                    if(implementos_especificos[j].implemento_id == todos_implementos[i].id){
                                        no_tiene_implemento = false;
                                        aux_index = j;
                                    }
                                }
                                if(no_tiene_implemento){
                                    text = text+'<div class="form-row align-items-center"><div class="col-auto"><div class="form-check mb-3"><input class="form-check-input editarSalaCheck" name="checks[]" type="checkbox" value="'+todos_implementos[i].id+'" id="implementoEditar'+todos_implementos[i].id+'"><label class="form-check-label" for="flexCheckChecked">'+todos_implementos[i].nombre+'</label></div></div><div class="col-auto"><div class="input-group mb-2"><div class="input-group-prepend"><div id="marcoEditar'+todos_implementos[i].id+'" class="input-group-text" style="visibility:hidden"><i id="iconEditar'+todos_implementos[i].id+'" class="fas fa-sort-numeric-up" style="visibility:hidden"></i></div></div><input type="number" class="form-control" id="cantidadImplementoEditar'+todos_implementos[i].id+'" placeholder="Cantidad" style="visibility:hidden"></div></div></div>';
                                }
                                else{
                                    text = text+'<div class="form-row align-items-center"><div class="col-auto"><div class="form-check mb-3"><input class="form-check-input editarSalaCheck" name="checks[]" type="checkbox" value="'+todos_implementos[i].id+'" id="implementoEditar'+todos_implementos[i].id+'" checked><label class="form-check-label" for="flexCheckChecked">'+todos_implementos[i].nombre+'</label></div></div><div class="col-auto"><div class="input-group mb-2"><div class="input-group-prepend"><div id="marcoEditar'+todos_implementos[i].id+'" class="input-group-text"><i id="iconEditar'+todos_implementos[i].id+'" class="fas fa-sort-numeric-up"></i></div></div><input type="number" value="'+implementos_especificos[aux_index].cantidad+'" class="form-control" id="cantidadImplementoEditar'+todos_implementos[i].id+'" placeholder="Cantidad"></div></div></div>';
                                }
                            }
                            text = text+'<div class="modal-footer"><button type="submit" class="btn btn-success">Editar</button><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div>';
                            
                            $("#idSala").val(datos_sala.id);
                            $("#nombreEditar").val(datos_sala.descripcion);
                            $("#cantidadsillasEditar").val(datos_sala.sillas);
                            $('.myEditModal').html(text);
                            $("#editarSala").modal('show');
                        }
                    });
            }
    </script>

    <!-- Script para eliminar sala -->
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
   
   <!-- Script para editar Sala-->
    <script>
        $("#FormeditarSala").submit(function(e){
                e.preventDefault();

                let id = $("#idSala").val();
                let nombre = $("#nombreEditar").val();
                let sillas = $("#cantidadsillasEditar").val();
                let _token = $("input[name=_token]").val();

                let implementos = [];
                let cantidadesImplementos = [];

                $('.editarSalaCheck:checked').each(function(){
                    implementos.push(this.value);
                });

                for (let i = 0; i < implementos.length; i++) {
                    cantidadesImplementos.push($("#cantidadImplementoEditar"+implementos[i]).val());
                }
 
                $.ajax({
                    url:"{{route('sala.update')}}",
                    type:"PUT",
                    data:{
                        id:id,
                        nombre:nombre,
                        sillas:sillas,
                        implementos:implementos,
                        cantidadesImplementos:cantidadesImplementos,
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
@endsection