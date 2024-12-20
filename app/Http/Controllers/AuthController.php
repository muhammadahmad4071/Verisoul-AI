<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        \Log::info('Incoming Request:', $request->all());
    
        $request->validate([
            'account_id' => 'required|string',
            'session_id' => 'required|string',
        ]);
    
        try {
            $response = Http::withHeaders([
                'x-api-key' => env('VERISOUL_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post("https://api." . env('VERISOUL_ENV') . ".verisoul.ai/session/authenticate", [
                'session_id' => $request->session_id,
                'account' => ['id' => $request->account_id],
            ]);
    
            \Log::info('Verisoul Response:', $response->json());
            // dd($response->json());

            if ($response->successful()) {
                session(['accountIdentifier' => $request->account_id, 'results' => $response->json()]);
                return redirect()->route('results');
            }
    
            return back()->withErrors(['error' => 'Authentication failed.']);
        } catch (\Exception $e) {
            \Log::error('Error:', ['message' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }
    

    public function logout()
    {
        session()->forget(['accountIdentifier', 'results']);
        return redirect()->route('login');
    }

    public function showResults()
    {
        $results = session('results');
        return view('auth.results', compact('results'));
    }
}
