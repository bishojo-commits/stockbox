@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('components.sidebar')
            @include('components.dashboard.main')
        </div>

        <div>
            @include('components.footer')
        </div>
    </div>
@endsection
