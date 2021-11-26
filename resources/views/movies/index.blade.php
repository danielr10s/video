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

    <a href="{{ url('/movies/create') }}" class="btn btn-success">Registrar nueva película</a>
    <br><br>

    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>Película</th>
                <th>Sinopsis</th>
                <th>Precio</th>
                <th>Género</th>
                <th>Fecha de lanzamiento</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movies as $movie)
            <tr>
                <td>{{$movie->movie_name}}</td>
                <td>{{$movie->movie_synopsis}}</td>
                <td>{{$movie->movie_unit_price}}</td>
                <td>{{$movie->movie_genre}}</td>
                <td>{{ date('Y-m-d', strtotime( $movie->movie_release_date )) }}</td>
                <td>
                    @foreach ($movieTypes as $type)
                        @if( $type->id == $movie->id_movie_type)
                            {{$type->movie_type}}
                        @endif
                    @endforeach
                </td>
                <td>
                    <a href="{{ url('/movies/'.$movie->id.'/edit') }}" class="btn btn-warning">
                        Editar
                    </a>
                    <form action="{{ url('/movies/'.$movie->id) }}" method="post" class="d-inline">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input type="submit" onclick="return confirm('¿Deseas eliminar la película?')" class="btn btn-danger" value="Borrar">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection