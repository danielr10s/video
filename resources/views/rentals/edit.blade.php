@extends('layouts.app')

@section('content')
<div class="container">
    
    <form action="{{ url('/rentals/'.$rental->id) }}" method="post">
        @csrf
        {{ method_field('PATCH') }}
        @include('rentals.form', ["modo" => "Editar"])
    </form>
    
</div>
@endsection