<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create new stock</h1>
    <div class="btn-group mr-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">Manage Depot</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Show Depot</button>
    </div>
</div>

<form method="POST" action="{{ route('stock.store', ['depot' => $depot]) }}">
    @csrf
    <h3 class="h3 stockbox__heading--h3">Add Stock To Depot "{{ Auth::user()->depot->depot_title }}" </h3>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Stock Title</label>
            <input type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   id="name"
                   name="name"
                   placeholder="stock title">
            @error('name')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="wkn_number">WKN Number</label>
            <input type="text"
                   class="form-control @error('wkn_number') is-invalid @enderror"
                   id="wkn_number"
                   name="wkn_number"
                   placeholder="WKN number">

            @error('wkn_number')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-md-2">
            <label for="ticker_symbol">Ticker Symbol</label>
            <input type="text"
                   class="form-control @error('ticker_symbol') is-invalid @enderror"
                   id="ticker_symbol"
                   name="ticker_symbol"
                   placeholder="ticker symbol">

            @error('ticker_symbol')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col">
            <label for="buy_price">Buy price</label>
            <input type="text"
                   class="form-control @error('buy_price') is-invalid @enderror"
                   id="buy_price"
                   name="buy_price"
                   placeholder="buy price">

            @error('buy_price')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col">
            <label for="buy_currency">currency (USD available)</label>
            <input type="text"
                   value="USD"
                   class="form-control @error('buy_currency') is-invalid @enderror"
                   id="buy_currency"
                   name="buy_currency"
                   placeholder="buy currency">

            @error('buy_currency')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col">
            <label class="control-label" for="buy_date">Date</label>
            <input type="text"
                   class="form-control @error('buy_date') is-invalid @enderror"
                   id="buy_date"
                   name="buy_date"
                   placeholder="MM/DD/YYY"/>

            @error('buy_date')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col">
            <label for="quantity">Quantity</label>
            <input type="text"
                   class="form-control @error('quantity') is-invalid @enderror"
                   id="quantity"
                   name="quantity"
                   placeholder="quantity">

            @error('quantity')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg btn-block">Add new stock</button>
</form>

<div id="app">
    <h3 class="h3 stockbox__heading--h3">Depot Total Statistics Chart</h3>
    <chart-component></chart-component>
</div>

