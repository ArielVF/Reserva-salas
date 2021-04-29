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
            <div class="card-header"><h3>Mis Reservas</h3></div>
            <div class="card-body" style="height:702px">
                <div class="col-sm-12 scroll">
                @if(empty($reservas))
                  <p class="card-text">Sin reservas asociadas</p>
                @else
                  <p class="card-text">
                  @foreach($reservas as $reserva)
                    <label class="col-12">{{ $reserva->start }}</label>
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
  
@endsection