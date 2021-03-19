<?php

namespace App\Http\Controllers\Depot;

use App\Data\Messages;
use App\Http\Requests\DepotUpdateRequest;
use App\Models\Depot;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepotStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DepotController extends Controller
{
    /**
     * DepotController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function index(Request $request)
    {
        return $request->user()->depot->stocks;
    }

    public function show(Depot $depot)
    {
        return view('pages.depot_show', compact('depot'));
    }

    public function create()
    {
        return view('pages.depot_create');
    }

    public function store(DepotStoreRequest $request)
    {
        $depot = Depot::make($request->all());
        $request->user()->depot()->save($depot);

        return Redirect::route('stock.create', $depot)
            ->with('message', Messages::DEPOT_CREATED);
    }

    public function edit(Depot $depot)
    {
        return view('pages.depot_edit', compact('depot'));
    }

    public function update(DepotUpdateRequest $request, Depot $depot)
    {
        $depot->update($request->all());

        return Redirect::back()->with('message', Messages::DEPOT_UPDATED);
    }

    public function destroy(Depot $depot)
    {
        $depot->stocks()->detach();
        $depot->delete();

        return Redirect::route('dashboard')->with('message', Messages::DEPOT_REMOVED);
    }
}
