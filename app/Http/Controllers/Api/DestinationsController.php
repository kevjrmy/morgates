<?php

namespace App\Http\Controllers\Api;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DestinationsController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
        ]);

        $destinations = Destination::search($request->input('q'))
            ->orderedForSearch($request->input('q'))
            ->limit(8)
            ->get(['id', 'name', 'type', 'region']);

        return response()->json($destinations);
    }
}
