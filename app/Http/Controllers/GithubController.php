<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GithubController extends Controller
{
    public function getAllIssues()
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
            $issues = array_map(function ($issue) {
                if (empty($issue['labels'])) return $issue;

                if (!empty($issue['labels'])) {
                    $exclude = false;
                    foreach($issue['labels'] as $label) {
                        if ($label['name'] === "wontfix") $exclude = true;
                    }

                    if (!$exclude) {
                        return $issue;
                    }
                }

            }, $issues);
           $issues = array_filter($issues);
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

    public function getIssueDetail($owner, $repo, $issue_number)
    {
        $token = \Config::get('app.github_access_token');

        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'X-GitHub-Api-Version' => '2022-11-28',
        ])
        ->accept("application/vnd.github+json")
        ->get("https://api.github.com/repos/$owner/$repo/issues/$issue_number");

        if ($response->successful()) {
            $issue = $response->json();

            return view('pages.detail', [
                'issue' => $issue,
                'status' => $response->status()
            ]);
        } else {
            return view('pages.detail', [
                'message' => $response->json()['message'] ?? 'An error occurred',
                'status' => $response->status()
            ]);
        }
    }
}
