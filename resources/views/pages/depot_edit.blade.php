@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('components.sidebar')

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                @include('components.depot.edit')
            </main>
        </div>
    </div>

    <div>
        @include('components.footer')
    </div>
@endsection
