@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('components.sidebar')
        </div>
    </div>

    <div>
        @include('components.footer')
    </div>
@endsection
