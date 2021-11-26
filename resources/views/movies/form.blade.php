<h1>{{$modo}} película</h1>

@if(count($errors) > 0)

    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error) 
                <li>{{$error}}</li>
            @endforeach  
        </ul>
    </div>

@endif

<div class="form-group">
    <label for="movie_name">Nombre</label>
    <input class="form-control" type="text" name="movie_name" id="movie_name"
        value="{{ isset($movie->movie_name) ? $movie->movie_name : old('movie_name') }}">
</div>

<div class="form-group">    
    <label for="movie_synopsis">Sinopsis</label>
    <input class="form-control" type="text" name="movie_synopsis" id="movie_synopsis"
        value="{{ isset($movie->movie_synopsis) ? $movie->movie_synopsis : old('movie_synopsis') }}">
</div>

<div class="form-group">
    <label for="movie_unit_price">Precio</label>
    <input class="form-control" type="number" name="movie_unit_price" id="movie_unit_price"
        value="{{ isset($movie->movie_unit_price) ? $movie->movie_unit_price : old('movie_unit_price') }}">
</div>

<div class="form-group">
    <label for="movie_genre">Género</label>
    <input class="form-control" type="text" name="movie_genre" id="movie_genre"
        value="{{ isset($movie->movie_genre) ? $movie->movie_genre : old('movie_genre') }}">
</div>

<div class="form-group">
    <label for="movie_release_date">Fecha de lanzamiento</label>
    <input class="form-control" type="date" name="movie_release_date" id="movie_release_date"
        value="{{ isset($movie->movie_release_date) ? date('Y-m-d', strtotime( $movie->movie_release_date )) : old('movie_release_date') }}">
</div>

<div class="form-group">
    <label for="id_movie_type">Tipo de película</label>
    <select class="form-control" name="id_movie_type" id="id_movie_type">
        @foreach ($movieTypes as $type) 
            <option value="{{$type->id}}"
                @if(isset($movie->id_movie_type) && $type->id == $movie->id_movie_type)
                    selected="selected"
                @endif
            >{{$type->movie_type}}</option>    
        @endforeach
    </select>
</div>  

<input class="btn btn-success" class="" type="submit" id="guardar_movie" value="{{$modo}} película">
<a class="btn btn-warning" href="{{ url('/movies') }}">Regresar</a>

