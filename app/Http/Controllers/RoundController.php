<?php

namespace App\Http\Controllers;

use App\Models\Round;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    public function store(Round $round, Request $request)
    {
        $round->processThreeSixNine($request->all());
    }

    public function storeOpenDeur(Round $round, Request $request)
    {
        $round->processOpenDeur($request->all());
    }
}
