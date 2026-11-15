<x-site-layout title="Request a quote" :locale="$locale">
    <h1 class="text-3xl font-semibold">{{ $locale === 'bn' ? 'নমুনা ও দর' : 'Request a quote or sample' }}</h1>
    <form method="post" action="{{ url('/quote') }}" class="mt-6 grid max-w-xl gap-3">
        @csrf
        <input name="company_website" tabindex="-1" autocomplete="off" class="hidden">
        <input name="name" required placeholder="Name" class="rounded border px-3 py-2" value="{{ old('name') }}">
        <input name="email" type="email" required placeholder="Email" class="rounded border px-3 py-2" value="{{ old('email') }}">
        <input name="phone" placeholder="Phone" class="rounded border px-3 py-2" value="{{ old('phone') }}">
        <input name="fabric" required placeholder="Fabric, GSM, composition" class="rounded border px-3 py-2" value="{{ old('fabric') }}">
        <input name="qty_kg" type="number" min="1" step="0.1" required placeholder="Kilograms" class="rounded border px-3 py-2" value="{{ old('qty_kg') }}">
        <textarea name="note" placeholder="Shade, dia, delivery" class="rounded border px-3 py-2">{{ old('note') }}</textarea>
        <button class="rounded bg-teal-800 px-3 py-2 text-white">Send to merchandising</button>
        @if ($errors->any())
            <p class="text-red-700">{{ $errors->first() }}</p>
        @endif
    </form>
</x-site-layout>
