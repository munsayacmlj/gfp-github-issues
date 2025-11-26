<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function login()
    {
        $token = \Config::get('app.github_access_token');

        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'X-GitHub-Api-Version' => '2022-11-28',
        ])
        ->accept("application/vnd.github+json")
        ->withQueryParameters([
            'filter' => 'assigned',
            'state' => 'open',
        ])
        ->get('https://api.github.com/issues');

        if ($response->successful()) {
            $issues = $response->json();

            dd($issues); exit;

            return view('pages.home', [
                'issues' => $issues,
                'status' => $response->status()
            ]);
        } else {
            return view('pages.home', [
                'message' => $response->json()['message'] ?? 'An error occurred',
                'status' => $response->status()
            ]);
        }
    }
}
