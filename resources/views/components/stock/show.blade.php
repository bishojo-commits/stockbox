<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ $stock->name }} ({{ $stock->ticker_symbol }})</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <div class="btn-group">
                    <a href="{{ route('stock.edit', ['depot' => Auth()->user()->depot, 'stock' => $stock]) }}">
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            Edit {{ $stock->name }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-2 text-secondary">
        Currency in USD |
        Depot Price {{ $stock->pivot->buy_price }} |
        WKN {{ $stock->wkn_number }}
    </div>

    <div id="app">
        <stock-show-component :stock="{{ $stock }}" :depot="{{ Auth()->user()->depot }}">
        </stock-show-component>
    </div>
</main>
