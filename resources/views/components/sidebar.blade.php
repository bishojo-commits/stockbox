<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active font-weight-bold" href="{{ route('dashboard')}}">
                   StockboxBoard<span class="sr-only">(current)</span>
                </a>
            </li>
            @if(Auth::user()->depot)
                <ul class="nav">
                    @foreach (Auth::user()->depot->stocks as $stock)
                        <li>
                            <a class="nav-link"
                               href="{{ route('stock.show', ['depot' => Auth::user()->depot, 'stock' => $stock]) }}">
                                <span>
                                    @include('components.icons.stock')
                                </span>
                                 {{ $stock->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span class="text-info">Actions</span>
            <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column mb-2">
            @if(Auth::user()->depot === null)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('depot.create', []) }}">
                        <span data-feather="file-text"></span>
                        Create Depot
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('depot.edit', ['depot' => Auth::user()->depot]) }}">
                        <span data-feather="file-text"></span>
                       Manage Depot
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('stock.create', ['depot' => Auth::user()->depot]) }}">
                       @include('components.icons.plus') Add Stock
                    </a>
                </li>
                @foreach (Auth::user()->depot->stocks as $stock)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('stock.edit', ['depot' => Auth::user()->depot, 'stock' => $stock]) }}">
                            @include('components.icons.edit') Edit {{ $stock->name }}
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</nav>
