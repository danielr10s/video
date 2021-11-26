<?php

namespace App\Http\Controllers;

use App\Models\Movies;
use App\Models\MovieTypes;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datosMovie["movies"] = Movies::all();
        $datosMovie["movieTypes"] = MovieTypes::all();
        return view("movies.index", $datosMovie);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datosMovie["movieTypes"] = MovieTypes::all();
        return view("movies.create", $datosMovie);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campos = [
            "movie_name" => "required|string|max:250",
            "movie_synopsis" => "required|string|max:250",
            "movie_unit_price" => "required|integer",
            "movie_genre" => "required|string|max:250",
            "movie_release_date" => "required|date",
            "id_movie_type" => "required|integer",
        ];
        $mensaje = [
            "movie_name.required" => "El nombre es obligatorio",
            "movie_synopsis.required" => "La sinopsis es obligatoria",
            "movie_unit_price.required" => "El precio unitario es obligatorio",
            "movie_genre.required" => "El género es obligatorio",
            "movie_release_date.required" => "La fecha de estreno es obligatoria",
            "id_movie_type.required" => "El tipo es obligatorio",
        ];
        $this->validate($request, $campos, $mensaje);
        $datosMovie = request()->except("_token");
        Movies::insert($datosMovie);
        
        return redirect("movies")->with("mensaje", "Película registrada correctamente");
        // return response()->json($datosMovie);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function show(Movies $movies)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function edit($movieId)
    {
        $datosMovie["movie"] = Movies::findOrFail($movieId);
        $datosMovie["movieTypes"] = MovieTypes::all();
        return view("movies.edit", $datosMovie);
        // return view("movies.edit", compact("movie"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $movieId)
    {
        $campos = [
            "movie_name" => "required|string|max:250",
            "movie_synopsis" => "required|string|max:250",
            "movie_unit_price" => "required|integer",
            "movie_genre" => "required|string|max:250",
            "movie_release_date" => "required|date",
            "id_movie_type" => "required|integer",
        ];
        $mensaje = [
            "movie_name.required" => "El nombre es obligatorio",
            "movie_synopsis.required" => "La sinopsis es obligatoria",
            "movie_unit_price.required" => "El precio unitario es obligatorio",
            "movie_genre.required" => "El género es obligatorio",
            "movie_release_date.required" => "La fecha de estreno es obligatoria",
            "id_movie_type.required" => "El tipo es obligatorio",
        ];
        $this->validate($request, $campos, $mensaje);

        $datosMovie = request()->except("_token", "_method");
        Movies::where("id", "=", $movieId)->update($datosMovie);
        $movie = Movies::findOrFail($movieId);
        // return view("movies.edit", compact("movie"));   
        return redirect("movies")->with("mensaje", "Película editada correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movies  $movies
     * @return \Illuminate\Http\Response
     */
    public function destroy($movieId)
    {
        Movies::destroy($movieId);
        return redirect("movies")->with("mensaje", "Película eliminada correctamente");
    }
}
