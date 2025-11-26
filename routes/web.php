<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GithubController;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [GithubController::class, 'getAllIssues'])->name('home');


Route::get('/detail/{owner}/{repo}/{issue_number}', [GithubController::class, 'getIssueDetail'])->name('detail');
