<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Depot <span>"{{ $depot->depot_title }}"</span></h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                    <span data-feather="calendar"></span>
                    Edit Stocks
                </button>

                <div class="dropdown-menu">
                    @foreach($depot->stocks as $stock)
                        <a class="dropdown-item"
                           href="{{ route('stock.edit', ['depot' => $depot, 'stock' => $stock]) }}">
                            {{ $stock->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('stock.create', ['depot' => $depot]) }}">
                <button type="button" class="btn btn-sm btn-outline-secondary">Add Stock to Depot</button>
            </a>
        </div>
    </div>
</div>

@include('components.depot.update', ['depot' => $depot])
@include('components.depot.remove', ['depot' => $depot])

@if(count($depot->stocks) > 0)
    @include('components.stock.remove', ['depot' => $depot])
@endif







