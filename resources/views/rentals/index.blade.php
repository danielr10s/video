@extends('layouts.app')

@section('content')
<div class="container">
    @if(Session::has("mensaje"))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{Session::get("mensaje")}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">X</span>
            </button>
        </div>
    @endif

    <a href="{{ url('/rentals/create') }}" class="btn btn-success">Registrar nueva renta</a>
    <br><br>

    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>Cliente</th>
                <th>Película</th>
                <th>Fecha</th>
                <th>Fecha de retorno</th>
                <th>Valor total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentals as $rental)
            <tr>
                <td>
                    @foreach ($clients as $client)
                        @if( $client->id == $rental->id_client)
                            {{$client->firstname." ".$client->lastname}}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($movies as $movie)
                        @if( $movie->id == $rental->id_movie)
                            {{$movie->movie_name}}
                        @endif
                    @endforeach
                </td>
                <td>{{ date('Y-m-d', strtotime( $rental->date_rental )) }}</td>
                <td>{{ date('Y-m-d', strtotime( $rental->date_rental_return )) }}</td>
                <td>{{$rental->id_rental_cost}}</td>
                <td>
                    <a href="{{ url('/rentals/'.$rental->id.'/edit') }}" class="btn btn-warning">
                        Editar
                    </a>
                    <form action="{{ url('/rentals/'.$rental->id) }}" method="post" class="d-inline">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input type="submit" onclick="return confirm('¿Deseas eliminar la renta?')" class="btn btn-danger" value="Borrar">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection