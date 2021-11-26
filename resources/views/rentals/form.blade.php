<h1>{{$modo}} renta</h1>

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
    <label for="id_client">Cliente</label>
    <select class="form-control" name="id_client" id="id_client">
        @foreach ($clients as $client) 
            <option value="{{$client->id}}"
                @if(isset($rental->id_client) && $client->id == $rental->id_client)
                    selected="selected"
                @endif
            >{{$client->firstname." ".$client->lastname }}</option>    
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="id_movie">Película</label>
    <select class="form-control" name="id_movie" id="id_movie">
        @foreach ($movies as $movie) 
            <option value="{{$movie->id}}"
                @if(isset($rental->id_movie) && $movie->id == $rental->id_movie)
                    selected="selected"
                @endif
            >{{$movie->movie_name}}</option>    
        @endforeach
    </select>
</div>  

<div class="form-group">
    <label for="date_rental">Fecha</label>
    <input class="form-control" type="date" name="date_rental" id="date_rental"
        value="{{ isset($rental->date_rental) ? date('Y-m-d', strtotime( $rental->date_rental )) : old('date_rental') }}">
</div> 

<div class="form-group">
    <label for="date_rental_return">Fecha de retorno</label>
    <input class="form-control" type="date" name="date_rental_return" id="date_rental_return"
        value="{{ isset($rental->date_rental_return) ? date('Y-m-d', strtotime( $rental->date_rental_return )) : old('date_rental_return') }}">
</div> 

<input class="btn btn-success" class="" type="submit" id="guardar_movie" value="{{$modo}} renta">
<a class="btn btn-warning" href="{{ url('/movies') }}">Regresar</a>

