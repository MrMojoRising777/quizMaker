<?php

namespace App\Http\Controllers;

use App\Models\Round;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    public function store(Round $round, Request $request)
    {
        try {
            $round->processThreeSixNine($request->all());
            return back()->with('success', 'Questions saved successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to save questions.']);
        }
    }

    public function storeOpenDeur(Round $round, Request $request)
    {
        try {
            $round->processOpenDeur($request->all());
            return back()->with('success', 'Questions saved successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to save questions.']);
        }
    }

    public function storePuzzel(Round $round, Request $request)
    {
        try {
            $round->processPuzzel($request->all());
            return back()->with('success', 'Questions saved successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to save questions.']);
        }
    }

    public function storeIngelijst(Round $round, Request $request)
    {
        try {
            $round->processIngelijst($request->all());
            return back()->with('success', 'Questions saved successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to save questions.']);
        }
    }

    public function storeFinale(Round $round, Request $request)
    {
        try {
            $round->processFinale($request->all());
            return back()->with('success', 'Questions saved successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to save questions.']);
        }
    }
}
