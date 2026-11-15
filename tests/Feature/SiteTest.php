<?php

use App\Models\User;
use App\Modules\Commercial\Models\Inquiry;
use App\Modules\Core\Models\Company;
use App\Modules\HumanResources\Models\JobApplication;
use App\Modules\HumanResources\Models\JobPosting;
use App\Modules\Website\Models\CatalogProduct;

it('opens the staff panel for a signed-in manager', function () {
    $user = User::factory()->create([
        'is_super_admin' => true,
        'portal' => 'staff',
    ]);

    $this->actingAs($user)->get('/admin')->assertOk();
});

it('publishes the mill site', function () {
    $this->get('/')->assertOk();
    $this->get('/process')->assertOk();
    $this->get('/fabrics')->assertOk();
    $this->get('/sitemap.xml')->assertOk();
    $this->get('/robots.txt')->assertOk();
    $this->get('/floor')->assertOk();
    $this->get('/health')->assertOk();
});

it('turns a quote into a merchandising inquiry', function () {
    Company::query()->create(['code' => 'GK', 'name' => 'Gazipur Knit', 'default_currency' => 'BDT']);
    CatalogProduct::query()->create([
        'title' => 'Single jersey 160 GSM',
        'composition' => '100% cotton',
        'gsm' => '160',
        'published' => true,
    ]);

    $this->get('/fabrics?gsm=160')->assertOk()->assertSee('Single jersey');

    $this->post('/quote', [
        'name' => 'Rina',
        'email' => 'rina@buyer.test',
        'fabric' => 'Single jersey 160',
        'qty_kg' => 500,
        'company_website' => '',
    ])->assertRedirect();

    expect(Inquiry::query()->count())->toBe(1);
    expect(Inquiry::query()->first()->source)->toBe('website');
});

it('accepts a job application', function () {
    $company = Company::query()->create(['code' => 'GK', 'name' => 'Gazipur Knit', 'default_currency' => 'BDT']);
    $job = JobPosting::query()->create([
        'company_id' => $company->id,
        'title' => 'Knitting operator',
        'status' => 'open',
        'description' => 'Night shift, circular floor.',
    ]);

    $this->post('/career', [
        'job_posting_id' => $job->id,
        'name' => 'Sohel',
        'phone' => '01700000000',
        'company_website' => '',
    ])->assertRedirect();

    expect(JobApplication::query()->where('job_posting_id', $job->id)->count())->toBe(1);
});
