<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Depot Statistics</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="{{ route('depot.edit', ['depot' => Auth()->user()->depot]) }}">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Manage Depot</button>
                </a>
            </div>
        </div>
    </div>

    <div id="app">
        <h3 class="h3 stockbox__heading--h3">Depot Total Statistics Chart</h3>
        <chart-component></chart-component>
    </div>

    <h3 class="h3 stockbox__heading--h3">Depot Total Statistics Data</h3>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1,001</td>
                <td>Lorem</td>
                <td>ipsum</td>
                <td>dolor</td>
                <td>sit</td>
            </tr>
            <tr>
                <td>1,002</td>
                <td>amet</td>
                <td>consectetur</td>
                <td>adipiscing</td>
                <td>elit</td>
            </tr>
            </tbody>
        </table>
    </div>
</main>


