<x-site-layout :title="$page['title']" :description="$page['body']" :locale="$locale">
    <h1 class="text-3xl font-semibold">{{ $locale === 'bn' ? $page['title_bn'] : $page['title'] }}</h1>
    <p class="mt-4 max-w-3xl leading-7">{{ $page['body'] }}</p>
    @if (($products ?? collect())->isNotEmpty() || request()->routeIs('fabrics'))
        <form method="get" class="mt-6 flex gap-2">
            <input name="gsm" value="{{ $filters['gsm'] ?? '' }}" placeholder="GSM" class="rounded border px-3 py-2">
            <input name="composition" value="{{ $filters['composition'] ?? '' }}" placeholder="Composition" class="rounded border px-3 py-2">
            <button class="rounded bg-stone-900 px-3 py-2 text-white">Filter</button>
        </form>
        <ul class="mt-6 space-y-3">
            @forelse ($products as $product)
                <li class="rounded border bg-white p-4">
                    <strong>{{ $locale === 'bn' ? ($product->title_bn ?: $product->title) : $product->title }}</strong>
                    <span class="text-sm text-stone-600">{{ $product->composition }} · {{ $product->gsm }} GSM</span>
                </li>
            @empty
                <li class="text-stone-600">The catalog is empty until a fabric is published.</li>
            @endforelse
        </ul>
    @endif
</x-site-layout>
