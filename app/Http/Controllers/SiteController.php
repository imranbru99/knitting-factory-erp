<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Commercial\Models\Inquiry;
use App\Modules\Core\Models\Company;
use App\Modules\Core\Services\DocumentNumberer;
use App\Modules\HumanResources\Models\JobApplication;
use App\Modules\HumanResources\Models\JobPosting;
use App\Modules\Support\CompanyContext;
use App\Modules\Website\Models\CatalogProduct;
use App\Modules\Website\Models\CmsPage;
use App\Modules\Website\Models\FormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class SiteController extends Controller
{
    /** @var array<string, array{title: string, title_bn: string, body: string}> */
    private array $pages = [
        'home' => ['title' => 'Gazipur Knit', 'title_bn' => 'গাজীপুর নিট', 'body' => 'Circular knitting in Tongi for single jersey, rib, interlock, fleece, pique, and collar-cuff.'],
        'about' => ['title' => 'About the mill', 'title_bn' => 'মিল সম্পর্কে', 'body' => 'Planning, yarn, knitting, inspection, dyeing, and delivery run from one register.'],
        'capacity' => ['title' => 'Capacity and machinery', 'title_bn' => 'ক্ষমতা', 'body' => 'Mayer, Terrot, and Pailung circular machines plus flat-bed collar and cuff.'],
        'process' => ['title' => 'Production flow', 'title_bn' => 'প্রক্রিয়া', 'body' => 'Inquiry, costing, order, BOM, yarn, knitting program, grey roll, dye, finish, challan, gate.'],
        'quality' => ['title' => 'Quality and compliance', 'title_bn' => 'মান', 'body' => 'Four-point inspection, GSM, shrinkage, and certificate expiry tracking.'],
        'sustainability' => ['title' => 'ETP and energy', 'title_bn' => 'পরিবেশ', 'body' => 'Effluent treatment and utility meters feed the cost per kilogram.'],
        'clients' => ['title' => 'Buyers', 'title_bn' => 'ক্রেতা', 'body' => 'Export and local apparel buyers can follow the order on the buyer portal.'],
        'gallery' => ['title' => 'Factory floor', 'title_bn' => 'গ্যালারি', 'body' => 'Knitting floor, grey store, and inspection frames at the Tongi unit.'],
        'news' => ['title' => 'News', 'title_bn' => 'খবর', 'body' => 'Mill notices and buyer visits are published here.'],
        'downloads' => ['title' => 'Downloads', 'title_bn' => 'ডাউনলোড', 'body' => 'Company profile and fabric list are available from the office.'],
        'contact' => ['title' => 'Contact', 'title_bn' => 'যোগাযোগ', 'body' => 'Tongi, Gazipur. Phone +8801711000000. Email hello@gazipurknit.test.'],
        'faq' => ['title' => 'Questions', 'title_bn' => 'প্রশ্ন', 'body' => 'Own-yarn and buyer-supplied job work use the same order, BOM, and roll register.'],
    ];

    public function home(Request $request): View
    {
        $page = $this->pages['home'];
        if (Schema::hasTable('cms_pages')) {
            $stored = CmsPage::query()->where('slug', 'home')->where('status', 'published')->first();
            if ($stored instanceof CmsPage) {
                $page = [
                    'title' => $stored->title,
                    'title_bn' => $stored->title_bn ?: $page['title_bn'],
                    'body' => $stored->body ?: $page['body'],
                ];
            }
        }

        return view('site.home', [
            'locale' => $this->locale($request),
            'page' => $page,
            'landing' => true,
        ]);
    }

    public function page(Request $request, string $slug): View
    {
        abort_unless(isset($this->pages[$slug]), 404);

        return $this->show($request, $slug);
    }

    public function fabrics(Request $request): View
    {
        $products = collect();
        if (Schema::hasTable('catalog_products')) {
            $products = CatalogProduct::query()
                ->where('published', true)
                ->when($request->string('composition')->toString() !== '', fn ($query) => $query->where('composition', 'like', '%'.$request->string('composition').'%'))
                ->when($request->string('gsm')->toString() !== '', fn ($query) => $query->where('gsm', $request->string('gsm')->toString()))
                ->orderBy('title')
                ->get();
        }

        return view('site.page', [
            'locale' => $this->locale($request),
            'page' => ['title' => 'Fabrics', 'title_bn' => 'কাপড়', 'body' => 'Filter the knitting range by GSM and composition, then add a swatch request.'],
            'products' => $products,
            'filters' => $request->only(['gsm', 'composition']),
        ]);
    }

    public function quoteForm(Request $request): View
    {
        return view('site.quote', ['locale' => $this->locale($request)]);
    }

    public function quote(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:40'],
            'fabric' => ['required', 'string', 'max:160'],
            'qty_kg' => ['required', 'numeric', 'min:1'],
            'note' => ['nullable', 'string', 'max:2000'],
            'company_website' => ['nullable', 'size:0'],
        ]);

        $company = Schema::hasTable('companies') ? Company::query()->where('code', 'GK')->first() ?? Company::query()->first() : null;
        if ($company instanceof Company) {
            CompanyContext::set($company->id);
            $number = app(DocumentNumberer::class)->next('INQ', 'INQ', $company->id, null, '00');
            Inquiry::query()->create([
                'company_id' => $company->id,
                'number' => $number,
                'subject' => $data['fabric'].' sample from '.$data['name'],
                'qty_kg' => $data['qty_kg'],
                'status' => 'open',
                'source' => 'website',
                'notes' => trim(($data['email'] ?? '').' '.($data['phone'] ?? '').' '.($data['note'] ?? '')),
            ]);
        }

        if (Schema::hasTable('form_submissions')) {
            FormSubmission::query()->create([
                'form' => 'quote',
                'payload' => $data,
                'status' => 'new',
            ]);
        }

        return back()->with('sent', 'The merchandiser has the inquiry.');
    }

    public function career(Request $request): View
    {
        $jobs = collect();
        if (Schema::hasTable('job_postings')) {
            $jobs = JobPosting::query()->where('status', 'open')->orderBy('title')->get();
        }

        return view('site.career', ['locale' => $this->locale($request), 'jobs' => $jobs]);
    }

    public function apply(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'job_posting_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:40'],
            'note' => ['nullable', 'string', 'max:2000'],
            'company_website' => ['nullable', 'size:0'],
        ]);

        $job = JobPosting::query()->findOrFail($data['job_posting_id']);
        JobApplication::query()->create([
            'company_id' => $job->company_id,
            'job_posting_id' => $job->id,
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'note' => $data['note'] ?? null,
            'status' => 'received',
        ]);

        return back()->with('sent', 'Application received.');
    }

    public function sitemap(): \Illuminate\Http\Response
    {
        $urls = ['/', '/fabrics', '/quote', '/career', '/contact', '/faq'];
        $body = collect($urls)->map(fn (string $path): string => '<url><loc>'.e(url($path)).'</loc></url>')->implode('');

        return response('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$body.'</urlset>', 200, ['Content-Type' => 'application/xml']);
    }

    public function health(): \Illuminate\Http\JsonResponse
    {
        $database = true;
        try {
            \Illuminate\Support\Facades\DB::select('select 1');
        } catch (\Throwable) {
            $database = false;
        }

        return response()->json(['app' => 'gazipur-knit', 'database' => $database], $database ? 200 : 503);
    }

    private function show(Request $request, string $slug): View
    {
        $page = $this->pages[$slug];
        if (Schema::hasTable('cms_pages')) {
            $stored = CmsPage::query()->where('slug', $slug)->where('status', 'published')->first();
            if ($stored instanceof CmsPage) {
                $page = [
                    'title' => $stored->title,
                    'title_bn' => $stored->title_bn ?: $page['title_bn'],
                    'body' => $stored->body ?: $page['body'],
                ];
            }
        }

        return view('site.page', [
            'locale' => $this->locale($request),
            'page' => $page,
            'products' => collect(),
            'filters' => [],
        ]);
    }

    private function locale(Request $request): string
    {
        $locale = $request->query('lang', $request->session()->get('locale', 'en'));
        $locale = $locale === 'bn' ? 'bn' : 'en';
        $request->session()->put('locale', $locale);

        return $locale;
    }
}
