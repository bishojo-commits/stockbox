<?php

namespace App\Http\Controllers\Depot;

use App\Data\Messages;
use App\Models\Stock;
use App\Models\Depot;
use App\Traits\DataComposer;
use App\Traits\RelationComposer;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockStoreRequest;
use App\Http\Requests\StockUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StockController extends Controller
{
    use RelationComposer;
    use DataComposer;

    /**
     * StockController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function show(Depot $depot, Stock $stock)
    {
        $stock = $this->loadPivot($depot, $stock);
        return view('pages.stock_show', compact('stock'));
    }

    public function create(Depot $depot)
    {
        return view('pages.stock_create', compact('depot'));
    }

    public function store(Depot $depot, StockStoreRequest $request)
    {
        $stock = Stock::make($this->model($request));
        $depot->stocks()->save($stock, $this->pivot($request));

        return Redirect::route('stock.create', compact('depot'))
            ->with('message', Messages::STOCK_CREATED);
    }

    public function edit(Depot $depot, Stock $stock)
    {
        $stock = $this->loadPivot($depot, $stock);
        return view('pages.stock_edit', ['depot' => $depot, 'stock' => $stock]);
    }

    public function update(StockUpdateRequest $request, Depot $depot, Stock $stock)
    {
        $stock->update($this->model($request));
        $depot->stocks()->updateExistingPivot($stock, $this->pivot($request));

        return Redirect::route('stock.edit', ['depot' => $depot, 'stock' => $stock])
            ->with('message', Messages::STOCK_UPDATED);
    }

    public function destroy(Depot $depot, Request $request)
    {
        $depot->stocks()->detach($request->stock_id);

        return Redirect::route('depot.edit', compact('depot'))
            ->with('message', Messages::STOCK_REMOVED);
    }
}
