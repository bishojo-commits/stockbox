<form method="POST" action="{{ route('depot.destroy', ['depot' => $depot]) }}">
    @csrf
    @method('DELETE')
    <h3 class="h3 stockbox__heading--h3">Remove Depot</h3>

    <div class="form-row">
        <div class="form-group col">
            <label for="depot_title">Select depot</label>
            <select class="form-control" id="exampleFormControlSelect1">
                <option>{{ $depot->depot_title }}</option>
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-danger btn-lg btn-block">
        Remove Depot
    </button>
</form>
