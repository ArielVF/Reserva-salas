@extends('layouts.app')

@section('content')


<script>
        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
          var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'Es',
            
            headerToolbar:{
              left: 'prev,next today',
              center: 'title',
              right: 'dayGridMonth',
            },

            //events:"http://localhost:8000/reserva/mostrar",
            eventSources: [
              // your event source
              {
                url: 'http://localhost:8000/reserva/mostrar', // use the `url` property
                display: 'background',
                color: '#AAD696'
              }
              // any other sources...
            ],
            
            dateClick:function(info){
              var date = info.dateStr;
              var url = "{{ url('/salas', ['id' => 'temp']) }}";
              url = url.replace('temp', date);
              location.href = url;
            }

          });
          calendar.render();
        });
    </script>
    
    <style>
      .scroll {
        max-height: 675px;
        overflow-y: auto;
      }
    </style>

    <div class="row" style="margin-top:60px">
      <div class="col-sm-5">
         <div class="card bg-light mb-3">
            @if(Auth::user()->role == 'admin')
              <div class="card-header"><h3>Todas las Reservas</h3></div>
            @else
              <div class="card-header"><h3>Mis Reservas</h3></div>
            @endif
            <div class="card-body" style="height:702px">
                <div class="col-sm-12 scroll">
                @if(Auth::user()->role == 'admin')
                   @if(empty($todas_las_reservas))
                    <p class="card-text">Ningún Profesor tiene reservas activas</p>
                    @else
                     <p class="card-text">
                      @foreach($todas_las_reservas as $reserva)
                        <label class="col-6">{{ $reserva->start }}</label>
                        <button type="button" style="float:right" onclick="eliminarReserva('{{$reserva->id}}', '{{$reserva->descripcion}}')" class="btn btn-danger">Eliminar Reserva</button>
                        <hr>
                        @foreach($users as $user)
                          @if($user->id == $reserva->usuario_id)
                            <label class ="col-12" style="float:left" >Propietario: {{ $user->name }}</label>
                            @break
                          @endif
                        @endforeach
                        @foreach($salas as $sala)
                          @if($sala->id == $reserva->espacioFisico_id)
                            <label class ="col-12" style="float:left" >Sector: {{ $sala->descripcion }}</label>
                            @break
                          @endif
                        @endforeach
                        <label class="col-12">Asunto: {{ $reserva->descripcion }}</label>
                        <label class="col-12">Bloque: {{ $reserva->bloque_id }}</label>
                        @foreach($bloques as $bloque)
                          @if($bloque->id == $reserva->bloque_id)
                            <label class="col-6">Inicio: {{ $bloque->hora_inicio }}</label>
                            <label class="col-6">Termino: {{ $bloque->hora_termino }}</label>
                            <hr style="height:2px;border:none;color:#333;background-color:#333;" />
                          @endif
                        @endforeach  
                      @endforeach
                    @endif
                @else
                  @if(empty($reservas))
                    <p class="card-text">Sin reservas asociadas</p>
                  @else
                    <p class="card-text">
                    @foreach($reservas as $reserva)
                      <label class="col-6">{{ $reserva->start }}</label>
                      <button type="button" style="float:right" onclick="eliminarReserva('{{$reserva->id}}', '{{$reserva->descripcion}}')" class="btn btn-danger">Eliminar Reserva</button>
                      <hr>
                      @foreach($salas as $sala)
                        @if($sala->id == $reserva->espacioFisico_id)
                          <label class ="col-12" style="float:left" >Sector: {{ $sala->descripcion }}</label>
                        @endif
                      @endforeach
                      <label class="col-12">Asunto: {{ $reserva->descripcion }}</label>
                      <label class="col-12">Bloque: {{ $reserva->bloque_id }}</label>
                      @foreach($bloques as $bloque)
                        @if($bloque->id == $reserva->bloque_id)
                          <label class="col-6">Inicio: {{ $bloque->hora_inicio }}</label>
                          <label class="col-6">Termino: {{ $bloque->hora_termino }}</label>
                          <hr style="height:2px;border:none;color:#333;background-color:#333;" />
                        @endif
                      @endforeach  
                    @endforeach
                    </p>
                  @endif
                @endif
                </div>
            </div>
          </div>
      </div>
      <div class="col-sm-6">
        <div class="card bg-light mb-3">
          <div class="card-header"><h3>Calendario</h3></div>
          <div class="card-body">
              <div class="row" id='calendar'></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
        function eliminarReserva(id, nombre){
            let _token = $("input[name=_token]").val();
            
            swal({
                title: "¿Está seguro de eliminar la reserva para Asunto: "+nombre+"?",
                text: "Una vez eliminado este elemento no habrá opción de recuperar sus datos.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url:"{{route('reserva.destroy')}}",
                        type:"DELETE",
                        data:{
                            id:id,
                            _token:_token,
                        },
                        success:function(response){
                            swal("La reserva ha sido eliminada", {
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