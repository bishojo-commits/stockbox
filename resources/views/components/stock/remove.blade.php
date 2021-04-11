<form method="POST" action="{{ route('stock.destroy', ['depot' => $depot]) }}">
    @csrf
    @method('DELETE')
    <h3 class="h3 stockbox__heading--h3">Remove Stocks from Depot </h3>

    <div class="form-row">
        <div class="form-group col">
            <label for="exampleFormControlSelect1">Select stock</label>
            <select class="form-control" name="stock_id">
                @foreach($depot->stocks as $stock)
                    <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-danger btn-lg btn-block">
        Remove Stock from Depot
    </button>
</form>
