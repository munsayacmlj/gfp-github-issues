@extends('layouts.default')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">
    @if ($status == '200')
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Issues assigned to you:</h1>
        <ul class="space-y-4">
            @foreach ($issues as $issue)
                <li class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <a href="{{ route('detail', ['owner' => $issue['repository']['owner']['login'], 'repo' => $issue['repository']['name'], 'issue_number' => $issue['number']]) }}"
                        class="block hover:bg-gray-100 p-2 rounded"
                    >
                        <div class="mb-2">
                            <span class="text-sm text-gray-500">Repository:</span>
                            <span class="text-sm font-semibold text-indigo-600">{{ $issue['repository']['name'] ?? 'N/A' }}</span>
                        </div>
                        <p>Issue Number: {{ $issue['number'] }}</p>
                        <strong class="text-lg text-blue-700">{{ $issue['title'] }}</strong><br>
                        <em class="text-xs text-gray-500">
                            @if (!empty($issue['created_at']))
                                {{ \Carbon\Carbon::parse($issue['created_at'])->format('F j, Y \a\t g:i A') }}
                            @else
                                N/A
                            @endif
                        </em>
                    </a>
                </li>
            @endforeach
        </ul>
    @elseif ($status)
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="font-bold">Warning:</span> Login failed with status code: {{ $status }}<br>
            <span>{{ $message ?? '' }}</span>
        </div>
    @endif
</div>
@endsection