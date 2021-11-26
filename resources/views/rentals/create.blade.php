@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{ url('/rentals') }}" method="post">
        @csrf
        @include('rentals.form', ["modo" => "Crear"])
    </form>

</div>
@endsection