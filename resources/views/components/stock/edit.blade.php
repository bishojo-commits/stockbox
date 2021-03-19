<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Stocks in Depot <span>"{{ $depot->depot_title }}"</span></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('depot.show', ['depot' => $depot]) }}">
                <button type="button" class="btn btn-sm btn-outline-secondary">See Depot Statistics</button>
            </a>
        </div>
    </div>
</div>

@include('components.stock.update', ['depot' => $depot, 'stock' => $stock])
