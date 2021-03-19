<form method="POST" action="{{ route('stock.update', ['depot' => $depot, 'stock' => $stock]) }}">
    @csrf
    @method('PATCH')
    <h3 class="h3 stockbox__heading--h3">Edit Stock {{ $stock->name }}</h3>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Stock Title</label>
            <input type="text"
                   class="form-control  @error('name') is-invalid @enderror"
                   id="name"
                   name="name"
                   placeholder="stock title"
                   value="{{ $stock->name }}"
                   readonly>

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
                   placeholder="WKN number"
                   value="{{ $stock->wkn_number}}"
                   readonly>

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
                   placeholder="ticker symbol"
                   value="{{ $stock->ticker_symbol }}"
                   readonly>

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
                   placeholder="buy price"
                   value="{{ $stock->pivot->buy_price }}">

            @error('buy_price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group col">
            <label for="buy_currency">currency</label>
            <input type="text"
                   class="form-control  @error('buy_currency') is-invalid @enderror"
                   id="buy_currency"
                   name="buy_currency"
                   placeholder="buy currency"
                   value="{{ $stock->pivot->buy_currency }}">

            @error('buy_currency')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col">
            <label class="control-label" for="buy_date">Buy Date</label>
            <input type="text"
                   class="form-control @error('buy_date') is-invalid @enderror"
                   id="buy_date"
                   name="buy_date"
                   placeholder="MM/DD/YYYY"
                   value="{{ date('m/d/Y', strtotime($stock->pivot->buy_date)) }}">

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
                   placeholder="quantity"
                   value="{{ $stock->pivot->quantity }}">

            @error('quantity')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-secondary btn-lg btn-block">Update stock</button>
</form>
