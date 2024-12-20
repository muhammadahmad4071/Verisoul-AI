<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function index(Request $request)
    {
        $results = $request->session()->get('results', []);
        return view('results', compact('results'));
    }
}
