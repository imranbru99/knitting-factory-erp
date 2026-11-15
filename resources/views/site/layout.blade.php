<!DOCTYPE html>
<html lang="{{ $locale === 'bn' ? 'bn' : 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Gazipur Knit' }}</title>
    <meta name="description" content="{{ $description ?? 'Knitting factory in Gazipur: yarn to finished fabric.' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}?lang=en">
    <link rel="alternate" hreflang="bn" href="{{ url()->current() }}?lang=bn">
    <meta property="og:title" content="{{ $title ?? 'Gazipur Knit' }}">
    <meta property="og:type" content="website">
    <style>
        body { margin: 0; font-family: Georgia, "Noto Sans Bengali", sans-serif; background: #faf7f2; color: #1c1917; }
        a { color: #115e59; }
        header, main, footer { max-width: 64rem; margin: 0 auto; padding: 1rem; }
        header { display: flex; justify-content: space-between; gap: 1rem; align-items: center; }
        nav { display: flex; flex-wrap: wrap; gap: .75rem; }
        input, textarea { width: 100%; padding: .5rem .75rem; border: 1px solid #d6d3d1; }
        button { background: #115e59; color: white; border: 0; padding: .5rem .75rem; }
        .card { background: white; border: 1px solid #e7e5e4; padding: 1rem; margin-top: 1rem; }
    </style>
    <script type="application/ld+json">
        {"@@context":"https://schema.org","@@type":"TextileManufacturer","name":"Gazipur Knit Ltd","address":{"@@type":"PostalAddress","addressLocality":"Gazipur","addressCountry":"BD"}}
    </script>
</head>
<body class="bg-stone-50 text-stone-900">
    <header class="border-b border-stone-200 bg-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-4 py-4">
            <a href="{{ url('/') }}" class="text-lg font-semibold">Gazipur Knit</a>
            <nav class="flex flex-wrap gap-3 text-sm">
                <a href="{{ url('/fabrics') }}">Fabrics</a>
                <a href="{{ url('/process') }}">Process</a>
                <a href="{{ url('/quality') }}">Quality</a>
                <a href="{{ url('/career') }}">Career</a>
                <a href="{{ url('/quote') }}">Quote</a>
                <a href="{{ url('/admin/login') }}">Staff</a>
                <a href="{{ request()->fullUrlWithQuery(['lang' => $locale === 'bn' ? 'en' : 'bn']) }}">{{ $locale === 'bn' ? 'English' : 'বাংলা' }}</a>
            </nav>
        </div>
    </header>
    <main class="mx-auto max-w-5xl px-4 py-8">
        @if (session('sent'))
            <p class="mb-4 rounded bg-teal-50 px-3 py-2 text-teal-900">{{ session('sent') }}</p>
        @endif
        {{ $slot }}
    </main>
    <footer>
        @if (! request()->cookie('gk_cookie'))
            <form method="post" action="{{ url('/cookie') }}">
                @csrf
                <p>The site keeps your language in the session. <button type="submit">Accept</button></p>
            </form>
        @endif
    </footer>
</body>
</html>
