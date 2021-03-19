@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('components.sidebar')
            @include('components.depot.show')
        </div>
    </div>

    <div>
        @include('components.footer')
    </div>
@endsection
