@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{ url('/movies') }}" method="post">
        @csrf
        @include('movies.form', ["modo" => "Crear"])
    </form>

</div>
@endsection
