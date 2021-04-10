<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">StockboxBoard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">

            <div class="btn-group mr-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                This week
            </button>
        </div>
    </div>

    <div id="app">
        <h3 class="h3 stockbox__heading--h3">Depot Total Performance</h3>
        <dashboard-chart-component
            @if ((Auth()->user()->depot) != null)
            :stocks="{{Auth()->user()->depot->stocks}}"
            :depot="{{ Auth()->user()->depot }}"
            @else
            @endif
            >
        </dashboard-chart-component>
    </div>
</main>
