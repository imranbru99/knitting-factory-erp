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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,460;9..144,620&family=Outfit:wght@380;500;640&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #14110e;
            --cream: #f6f1e8;
            --paper: #fffdf8;
            --teal: #0f6e67;
            --teal-deep: #0b3f3c;
            --gold: #c6a15b;
            --line: rgba(20, 17, 14, .12);
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Outfit, "Noto Sans Bengali", sans-serif; background: var(--cream); color: var(--ink); }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }
        .nav {
            position: sticky; top: 0; z-index: 20;
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
            padding: .85rem 6vw;
            background: rgba(246, 241, 232, .9);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--line);
        }
        .nav-overlay { position: absolute; left: 0; right: 0; background: linear-gradient(to bottom, rgba(10, 8, 6, .55), transparent); border: 0; color: white; }
        .brand { font-family: Fraunces, Georgia, serif; font-size: 1.35rem; letter-spacing: -.03em; }
        .brand span { color: var(--gold); }
        .nav-links { display: flex; flex-wrap: wrap; gap: .35rem 1rem; align-items: center; font-size: .92rem; }
        .nav-links a { opacity: .86; }
        .nav-cta, button, .btn {
            background: var(--teal); color: white; border: 0; border-radius: 999px;
            padding: .7rem 1.1rem; font: inherit; cursor: pointer;
        }
        .btn-ghost { background: transparent; color: white; border: 1px solid rgba(255,255,255,.45); }
        .btn-dark { background: var(--ink); }
        main { max-width: 72rem; margin: 0 auto; padding: 2.5rem 1.25rem 4rem; }
        main.landing { max-width: none; margin: 0; padding: 0; }
        h1 { font-family: Fraunces, Georgia, serif; font-weight: 460; letter-spacing: -.04em; }
        input, textarea { width: 100%; padding: .75rem .9rem; border: 1px solid #ddd4c6; border-radius: .7rem; background: white; font: inherit; }
        .site-foot { padding: 1.25rem 6vw 2rem; color: #5c564e; font-size: .92rem; }
        .cookie { display: flex; gap: 1rem; align-items: center; justify-content: space-between; }
    </style>
    <script type="application/ld+json">
        {"@@context":"https://schema.org","@@type":"TextileManufacturer","name":"Gazipur Knit Ltd","address":{"@@type":"PostalAddress","addressLocality":"Gazipur","addressCountry":"BD"}}
    </script>
</head>
<body>
    <header class="nav {{ !empty($landing) ? 'nav-overlay' : '' }}">
        <a class="brand" href="{{ url('/') }}">Gazipur <span>Knit</span></a>
        <nav class="nav-links">
            <a href="{{ url('/fabrics') }}">{{ $locale === 'bn' ? 'কাপড়' : 'Fabrics' }}</a>
            <a href="{{ url('/process') }}">{{ $locale === 'bn' ? 'প্রক্রিয়া' : 'Process' }}</a>
            <a href="{{ url('/quality') }}">{{ $locale === 'bn' ? 'মান' : 'Quality' }}</a>
            <a href="{{ url('/capacity') }}">{{ $locale === 'bn' ? 'ক্ষমতা' : 'Capacity' }}</a>
            <a href="{{ url('/career') }}">{{ $locale === 'bn' ? 'চাকরি' : 'Career' }}</a>
            <a href="{{ url('/admin/login') }}">{{ $locale === 'bn' ? 'স্টাফ' : 'Staff' }}</a>
            <a href="{{ request()->fullUrlWithQuery(['lang' => $locale === 'bn' ? 'en' : 'bn']) }}">{{ $locale === 'bn' ? 'English' : 'বাংলা' }}</a>
            <a class="nav-cta" href="{{ url('/quote') }}">{{ $locale === 'bn' ? 'নমুনা চাই' : 'Request a sample' }}</a>
        </nav>
    </header>
    <main class="{{ !empty($landing) ? 'landing' : '' }}">
        @if (session('sent'))
            <p style="margin: 1rem 6vw; padding: .8rem 1rem; background: #e7f5f3; border-radius: .8rem;">{{ session('sent') }}</p>
        @endif
        {{ $slot }}
    </main>
    <footer class="site-foot">
        @if (! request()->cookie('gk_cookie'))
            <form class="cookie" method="post" action="{{ url('/cookie') }}">
                @csrf
                <p style="margin:0;">{{ $locale === 'bn' ? 'ভাষা পছন্দ সেশনে রাখা হয়।' : 'The site keeps your language choice in this session.' }}</p>
                <button type="submit">{{ $locale === 'bn' ? 'ঠিক আছে' : 'Accept' }}</button>
            </form>
        @endif
    </footer>
</body>
</html>
