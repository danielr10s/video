<?php

namespace App\Http\Controllers;

use App\Models\Rentals;
use App\Models\Movies;
use App\Models\Clients;
use Illuminate\Http\Request;

class RentalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datosRental["rentals"] = Rentals::all();
        $datosRental["movies"] = Movies::all();
        $datosRental["clients"] = Clients::all();
        return view("rentals.index", $datosRental);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datosRental["rentals"] = Rentals::all();
        $datosRental["movies"] = Movies::all();
        $datosRental["clients"] = Clients::all();
        return view("rentals.create", $datosRental);
    }

    public function getTotalPrice($dias, $movieType, $moviePrice){
        $valorTotal = 0;
        if ($movieType == 1) {
            $valorTotal = $moviePrice * $dias;

        } else if ($movieType == 2) {
            if ($dias <= 3) {
                $valorTotal = $moviePrice * $dias;
            }else {
                $diasExtras = $dias - 3;
                $percent = $moviePrice + ($moviePrice * 0.15);
                $valorTotal = ($moviePrice * 3) + ($diasExtras * $percent);
            }
            
        } else if ($movieType == 3) {
            if ($dias <= 5) {
                $valorTotal = $moviePrice * $dias;
            }else {
                $diasExtras = $dias - 5;
                $percent = $moviePrice + ($moviePrice * 0.1);
                $valorTotal = ($moviePrice * 5) + ($diasExtras * $percent);
            }
        }
        return $valorTotal;
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
            "id_client" => "required|int",
            "id_movie" => "required|int",
            "date_rental" => "required|date",
            "date_rental_return" => "required|date",
        ];
        $mensaje = [
            "id_client.required" => "El nombre es obligatorio",
            "id_movie.required" => "La sinopsis es obligatoria",
            "date_rental.required" => "La fecha es obligatoria",
            "date_rental_return.required" => "La fecha de retorno es obligatoria",
        ];
        $this->validate($request, $campos, $mensaje);

        $datosRental = request()->except("_token");

        $diff = strtotime($datosRental["date_rental_return"]) - strtotime($datosRental["date_rental"]);
        $dias = abs(round($diff / 86400));

        $movie = Movies::findOrFail($datosRental["id_movie"]);
        $movieType = $movie->id_movie_type;
        $moviePrice = $movie->movie_unit_price;

        $datosRental["id_rental_cost"] = $this->getTotalPrice($dias, $movieType, $moviePrice);

        Rentals::insert($datosRental);
        
        return redirect("rentals")->with("mensaje", "Renta registrada correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rentals  $rentals
     * @return \Illuminate\Http\Response
     */
    public function show(Rentals $rentals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rentals  $rentals
     * @return \Illuminate\Http\Response
     */
    public function edit($rentalId)
    {
        $datosRental["rental"] = Rentals::findOrFail($rentalId);
        $datosRental["movies"] = Movies::all();
        $datosRental["clients"] = Clients::all();
        return view("rentals.edit", $datosRental);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rentals  $rentals
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rentalId)
    {
        $campos = [
            "id_client" => "required|int",
            "id_movie" => "required|int",
            "date_rental" => "required|date",
            "date_rental_return" => "required|date",
        ];
        $mensaje = [
            "id_client.required" => "El nombre es obligatorio",
            "id_movie.required" => "La sinopsis es obligatoria",
            "date_rental.required" => "La fecha es obligatoria",
            "date_rental_return.required" => "La fecha de retorno es obligatoria",
        ];
        $this->validate($request, $campos, $mensaje);



        $datosRental = request()->except("_token", "_method");

        $diff = strtotime($datosRental["date_rental_return"]) - strtotime($datosRental["date_rental"]);
        $dias = abs(round($diff / 86400));

        $movie = Movies::findOrFail($datosRental["id_movie"]);
        $movieType = $movie->id_movie_type;
        $moviePrice = $movie->movie_unit_price;

        $datosRental["id_rental_cost"] = $this->getTotalPrice($dias, $movieType, $moviePrice);

        Rentals::where("id", "=", $rentalId)->update($datosRental);
        $movie = Rentals::findOrFail($rentalId);
        return redirect("rentals")->with("mensaje", "Renta editada correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rentals  $rentals
     * @return \Illuminate\Http\Response
     */
    public function destroy($rentalId)
    {
        Rentals::destroy($rentalId);
        return redirect("rentals")->with("mensaje", "Renta eliminada correctamente");
    }
}
