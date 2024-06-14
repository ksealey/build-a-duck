<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DuckController extends Controller
{
    /**
     * List all ducks owned by a user
     * 
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'nullable|max:255',
            'limit'  => 'nullable|numeric|min:1|max:200',
            'offset' => 'nullable|numeric|min:0'
        ]);

        $query = $request->user()->ducks();
        if($request->filled('search')){
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $query->limit($request->limit ?? 200, $request->offset ?? 0);

        return response()->json([
            'data' => $query->get()
        ]);
    }
}
