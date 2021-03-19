<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create new stock depot</h1>
    <div class="btn-group mr-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">Manage Depot</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Show Depot</button>
    </div>
</div>

<form method="POST" action="{{ route('depot.store') }}">
    @csrf
    <h3 class="h3 stockbox__heading--h3">Depot</h3>
    <div class="form-row">
        <div class="form-group col-md-10">
            <label for="depot_title">Depot title</label>
            <input type="text"
                   class="form-control @error('depot_title') is-invalid @enderror"
                   id="depot_title"
                   name="depot_title"
                   placeholder="depot title">

            @error('depot_title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-md-2">
            <label for="depot_currency">Depot currency</label>
            <input type="text"
                   class="form-control @error('depot_currency') is-invalid @enderror"
                   id="depot_currency"
                   name="depot_currency"
                   placeholder="depot currency">

            @error('depot_currency')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <button type="submit"
            class="btn btn-primary btn-lg btn-block">
        Create new depot
    </button>
</form>


