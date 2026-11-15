<x-site-layout
    :title="$locale === 'bn' ? 'গাজীপুর নিট — বৃত্তাকার নিটিং' : 'Gazipur Knit — circular knitting, held to the kilogram'"
    :description="$page['body']"
    :locale="$locale"
    :landing="true"
>
    <style>
        .hero {
            min-height: 100vh;
            padding: 8.5rem 6vw 4.5rem;
            display: grid;
            align-items: end;
            color: white;
            background:
                linear-gradient(100deg, rgba(10, 8, 6, .82) 0%, rgba(10, 8, 6, .45) 48%, rgba(10, 8, 6, .2) 100%),
                url('{{ asset('images/mill-hero.jpg') }}') center/cover no-repeat;
        }
        .kicker { letter-spacing: .22em; text-transform: uppercase; font-size: .78rem; color: #e6c98a; margin: 0 0 1rem; }
        .hero h1 { font-size: clamp(3.1rem, 7vw, 6.4rem); line-height: .92; max-width: 12ch; margin: 0; }
        .hero p.lead { max-width: 38rem; font-size: 1.15rem; line-height: 1.6; color: rgba(255,255,255,.86); }
        .actions { display: flex; flex-wrap: wrap; gap: .75rem; margin-top: 1.6rem; }
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: rgba(255,255,255,.18);
            margin-top: 3.5rem;
            max-width: 52rem;
        }
        .stats div { background: rgba(12, 10, 8, .45); padding: 1rem 1.1rem; backdrop-filter: blur(8px); }
        .stats strong { display: block; font-family: Fraunces, Georgia, serif; font-size: 1.7rem; }
        .stats span { font-size: .85rem; opacity: .8; }
        .section { padding: 4.5rem 6vw; }
        .section h2 { font-family: Fraunces, Georgia, serif; font-size: clamp(2rem, 4vw, 3.3rem); letter-spacing: -.03em; margin: 0 0 .4rem; }
        .grid-3, .grid-4 { display: grid; gap: 1rem; margin-top: 1.8rem; }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-4 { grid-template-columns: 1.1fr .9fr; align-items: center; }
        .card {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 1.2rem;
            padding: 1.3rem 1.35rem 1.45rem;
        }
        .card em { font-style: normal; color: var(--teal); font-size: .78rem; letter-spacing: .14em; text-transform: uppercase; }
        .card h3 { font-family: Fraunces, Georgia, serif; font-size: 1.55rem; margin: .45rem 0; }
        .split { display: grid; grid-template-columns: 1.05fr .95fr; gap: 2rem; align-items: center; }
        .split img { border-radius: 1.4rem; height: 100%; object-fit: cover; min-height: 22rem; }
        .ink { background: var(--ink); color: white; }
        .ink .card { background: #1d1915; color: white; border-color: rgba(255,255,255,.08); }
        @media (max-width: 860px) {
            .stats, .grid-3, .split { grid-template-columns: 1fr; }
            .hero { padding-top: 7rem; }
            .nav-links a:not(.nav-cta) { display: none; }
        }
    </style>

    <section class="hero">
        <div>
            <p class="kicker">{{ $locale === 'bn' ? 'টঙ্গি · গাজীপুর · বাংলাদেশ' : 'Tongi · Gazipur · Bangladesh' }}</p>
            <h1>{{ $locale === 'bn' ? 'প্রথম কোন থেকে শেষ চালান।' : 'From the first cone to the last challan.' }}</h1>
            <p class="lead">{{ $locale === 'bn' ? 'সিঙ্গেল জার্সি, রিব, ইন্টারলক, ফ্লিস, পিকে ও কলার-কাফ। জিএসএম ধরে বোনা, রোল ধরে পরীক্ষা, অর্ডারের ওজনে ডেলিভারি।' : 'Single jersey, rib, interlock, fleece, pique, and collar-cuff. Knitted to a GSM, inspected roll by roll, and shipped with the weight on the order.' }}</p>
            <div class="actions">
                <a class="btn" href="{{ url('/quote') }}">{{ $locale === 'bn' ? 'নমুনা ও দর চাই' : 'Request a quote' }}</a>
                <a class="btn btn-ghost" href="{{ url('/fabrics') }}">{{ $locale === 'bn' ? 'কাপড়ের তালিকা' : 'View the fabrics' }}</a>
            </div>
            <div class="stats">
                <div><strong>160+</strong><span>{{ $locale === 'bn' ? 'জিএসএম রেঞ্জ' : 'GSM programs on the floor' }}</span></div>
                <div><strong>6</strong><span>{{ $locale === 'bn' ? 'মূল কনস্ট্রাকশন' : 'Core constructions' }}</span></div>
                <div><strong>A–C</strong><span>{{ $locale === 'bn' ? '৪-পয়েন্ট গ্রেড' : 'Four-point roll grades' }}</span></div>
                <div><strong>BDT</strong><span>{{ $locale === 'bn' ? 'রপ্তানিতে ইউএসডি' : 'Home currency, USD for export' }}</span></div>
            </div>
        </div>
    </section>

    <section class="section">
        <p class="kicker" style="color: var(--teal);">{{ $locale === 'bn' ? 'যা বোনা হয়' : 'What the mill knits' }}</p>
        <h2>{{ $locale === 'bn' ? 'ক্রেতা যে কাপড় চেনে।' : 'The cloth a buyer already knows.' }}</h2>
        <div class="grid-3">
            <article class="card">
                <em>Jersey</em>
                <h3>{{ $locale === 'bn' ? 'সিঙ্গেল জার্সি' : 'Single jersey' }}</h3>
                <p>Combed cotton and CVC, 140–180 GSM, open width for tee programs.</p>
            </article>
            <article class="card">
                <em>Rib & cuff</em>
                <h3>{{ $locale === 'bn' ? 'রিব ও কলার' : 'Rib and collar' }}</h3>
                <p>1×1 and 2×2 rib, plus flat-bed collar and cuff matched to the body.</p>
            </article>
            <article class="card">
                <em>Double knit</em>
                <h3>{{ $locale === 'bn' ? 'ইন্টারলক ও ফ্লিস' : 'Interlock and fleece' }}</h3>
                <p>Stable interlock, 2-thread and 3-thread fleece, French terry, pique.</p>
            </article>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="split">
            <img src="{{ asset('images/mill-floor.jpg') }}" alt="Roll weight and GSM entered on the knitting floor">
            <div>
                <p class="kicker" style="color: var(--teal);">{{ $locale === 'bn' ? 'ফ্লোরেই লেখা হয়' : 'Written on the floor' }}</p>
                <h2>{{ $locale === 'bn' ? 'রোল নম্বর আর ছাড়ে না।' : 'The roll number does not go missing.' }}</h2>
                <p>{{ $page['body'] }}</p>
                <p>Yarn lot, machine, operator, GSM, and net weight sit on the same tag the inspector reads. A second lot on one program waits for approval.</p>
                <div class="actions">
                    <a class="btn btn-dark" href="{{ url('/process') }}">{{ $locale === 'bn' ? 'প্রক্রিয়া দেখুন' : 'See the process' }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section ink">
        <p class="kicker">{{ $locale === 'bn' ? 'কেন মিল বদলায়' : 'Why a mill switches' }}</p>
        <h2>{{ $locale === 'bn' ? 'সন্ধ্যায় এক্সেল নয়।' : 'No evening spent rebuilding Excel.' }}</h2>
        <div class="grid-3">
            <article class="card">
                <h3>{{ $locale === 'bn' ? 'সুতা' : 'Yarn' }}</h3>
                <p>Lot, count, and challan weight against the scale. Issue only what the program is allowed to take.</p>
            </article>
            <article class="card">
                <h3>{{ $locale === 'bn' ? 'মেশিন' : 'Machine' }}</h3>
                <p>Diameter, gauge, and type decide the allocation. Idle time asks for a reason before the shift ends.</p>
            </article>
            <article class="card">
                <h3>{{ $locale === 'bn' ? 'হিসাব' : 'Accounts' }}</h3>
                <p>The receipt, the invoice, and the collection post the same kilograms. Stock and cash finish together.</p>
            </article>
        </div>
        <div class="actions">
            <a class="btn" href="{{ url('/quote') }}">{{ $locale === 'bn' ? 'আজই কথা বলুন' : 'Talk to merchandising' }}</a>
            <a class="btn btn-ghost" href="{{ url('/contact') }}">{{ $locale === 'bn' ? 'মিলের ঠিকানা' : 'Mill address' }}</a>
        </div>
    </section>
</x-site-layout>
