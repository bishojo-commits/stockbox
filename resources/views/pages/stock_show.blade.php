@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('components.sidebar')
            @include('components.stock.show', ['stock' => $stock])
        </div>

        <div>
            @include('components.footer')
        </div>
    </div>
@endsection
