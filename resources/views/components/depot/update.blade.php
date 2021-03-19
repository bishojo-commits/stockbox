<form method="POST" action="{{ route('depot.update', ['depot' => $depot]) }}">
    @csrf
    @method('PATCH')
    <h3 class="h3 stockbox__heading--h3">Update Depot</h3>

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="form-row">
        <div class="form-group col-md-10">
            <label for="depot_title">Depot title</label>
            <input type="text"
                   class="form-control"
                   id="depot_title"
                   name="depot_title"
                   value="{{ $depot->depot_title }}">
        </div>

        <div class="form-group col-md-2">
            <label for="depot_currency">Depot currency</label>
            <input type="text"
                   class="form-control"
                   id="depot_currency"
                   name="depot_currency"
                   value="{{ $depot->depot_currency }}">
        </div>
    </div>

    <button type="submit"
            class="btn btn-secondary btn-lg btn-block">
        Update Depot
    </button>
</form>
