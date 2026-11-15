<x-filament-panels::page>
    <div class="space-y-3">
        @forelse ($issues as $issue)
            <article class="rounded-lg border p-4">
                <strong>{{ $issue->title }}</strong>
                <p>{{ $issue->severity }} · {{ $issue->owner_role }} · {{ $issue->status }}</p>
                <p>{{ $issue->suggested_solution }}</p>
            </article>
        @empty
            <p>No open issues.</p>
        @endforelse
    </div>
</x-filament-panels::page>
