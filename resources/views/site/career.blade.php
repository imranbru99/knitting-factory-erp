<x-site-layout title="Careers" :locale="$locale">
    <h1 class="text-3xl font-semibold">{{ $locale === 'bn' ? 'চাকরি' : 'Careers' }}</h1>
    @forelse ($jobs as $job)
        <article class="mt-6 rounded border bg-white p-4">
            <h2 class="text-xl">{{ $locale === 'bn' ? ($job->title_bn ?: $job->title) : $job->title }}</h2>
            <p class="mt-2">{{ $job->description }}</p>
            <form method="post" action="{{ url('/career') }}" class="mt-3 grid gap-2">
                @csrf
                <input type="hidden" name="job_posting_id" value="{{ $job->id }}">
                <input name="company_website" class="hidden" tabindex="-1" autocomplete="off">
                <input name="name" required placeholder="Name" class="rounded border px-3 py-2">
                <input name="email" type="email" placeholder="Email" class="rounded border px-3 py-2">
                <input name="phone" placeholder="Phone" class="rounded border px-3 py-2">
                <textarea name="note" class="rounded border px-3 py-2" placeholder="Experience"></textarea>
                <button class="rounded bg-stone-900 px-3 py-2 text-white">Apply</button>
            </form>
        </article>
    @empty
        <p class="mt-4">No open posts. The HR desk publishes jobs from the panel.</p>
    @endforelse
</x-site-layout>
