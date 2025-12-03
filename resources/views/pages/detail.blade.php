@extends('layouts.default')

@section('content')
<div class="max-w-xl mx-auto p-8 bg-white rounded shadow mt-8">
    @if ($status == '200')
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Issue Details</h2>
        <div class="mb-4">
            <span class="text-sm text-gray-500">Issue Number:</span>
            <span class="text-lg font-semibold text-indigo-700">{{ $issue['number'] ?? 'N/A' }}</span>
        </div>
        <div class="mb-4">
            <span class="text-sm text-gray-500">Title:</span>
            <span class="text-lg font-semibold text-blue-700">{{ $issue['title'] ?? 'N/A' }}</span>
        </div>
        <div class="mb-4">
            <span class="text-sm text-gray-500">Created At:</span>
            <span class="text-base text-gray-700">
                @if (!empty($issue['created_at']))
                    {{ \Carbon\Carbon::parse($issue['created_at'])->format('F j, Y \a\t g:i A') }}
                @else
                    N/A
                @endif
            </span>
        </div>
        <div class="mb-4">
            <span class="text-sm text-gray-500">Body:</span>
            <div class="mt-2 p-4 bg-gray-50 rounded text-gray-800">
                <textarea id="issueBody" cols="30" rows="10" contenteditable="true">
                    {{ $issue['body'] ?? 'No description provided.' }}
                </textarea>
            </div>
        </div>
    @elseif ($status)
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="font-bold">Warning:</span> Failed to fetch issue details with status code: {{ $status }}<br>
            <span>{{ $message ?? '' }}</span>
        </div>
    @endif
</div>
@endsection