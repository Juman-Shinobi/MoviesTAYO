<?php

namespace App\Http\Controllers;

use App\Models\Theater;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim();

        $theaters = Theater::query()
            ->when($search->isNotEmpty(), function ($query) use ($search) {
                $query->where('theater_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            })
            ->orderBy('theater_name')
            ->get();

        return view('theaters.index', [
            'theaters' => $theaters,
            'search' => $search,
        ]);
    }
}
