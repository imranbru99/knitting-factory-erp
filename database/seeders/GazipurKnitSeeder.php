<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Access\PermissionCatalog;
use App\Modules\Core\Models\Company;
use App\Modules\Core\Models\CompanyModule;
use App\Modules\Core\Models\Currency;
use App\Modules\Core\Models\FinancialYear;
use App\Modules\Core\Models\ModuleRecord;
use App\Modules\Core\Models\Permission;
use App\Modules\Core\Models\Role;
use App\Modules\Core\Models\Unit;
use App\Modules\Core\Models\Uom;
use App\Modules\Operations\Models\IssueRule;
use App\Modules\Operations\Services\IssueCatalog;
use App\Modules\Support\CompanyContext;
use App\Modules\Support\KnitCycle;
use App\Modules\Website\Models\CatalogProduct;
use App\Modules\Website\Models\CmsPage;
use Illuminate\Database\Seeder;

class GazipurKnitSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::query()->updateOrCreate(
            ['code' => 'GK'],
            [
                'name' => 'Gazipur Knit Ltd',
                'name_bn' => 'গাজীপুর নিট লিমিটেড',
                'address' => 'Tongi, Gazipur, Bangladesh',
                'phone' => '+8801711000000',
                'email' => 'hello@gazipurknit.test',
                'timezone' => 'Asia/Dhaka',
                'default_currency' => 'BDT',
            ],
        );
        $unit = Unit::query()->updateOrCreate(
            ['company_id' => $company->id, 'code' => 'U1'],
            ['name' => 'Tongi knitting unit', 'type' => 'factory', 'address' => 'Tongi, Gazipur'],
        );

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@gazipurknit.test'],
            [
                'name' => 'Factory GM',
                'password' => 'password',
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'portal' => 'staff',
                'locale' => 'en',
                'is_super_admin' => true,
            ],
        );
        $this->command?->info('Login admin@gazipurknit.test / password');

        CompanyContext::set($company->id, $unit->id);
        auth()->login($admin);

        $role = Role::query()->updateOrCreate(
            ['company_id' => $company->id, 'slug' => 'gm'],
            ['name' => 'General Manager', 'is_system' => true],
        );
        foreach (PermissionCatalog::all() as $row) {
            [$name, $module] = explode('|', $row, 2);
            $permission = Permission::query()->firstOrCreate(
                ['name' => $name],
                ['module' => $module, 'description' => $name],
            );
            $role->permissions()->syncWithoutDetaching([$permission->id]);
        }
        $admin->roles()->syncWithoutDetaching([$role->id]);

        Currency::query()->updateOrCreate(['code' => 'BDT'], ['name' => 'Taka', 'symbol' => '৳']);
        Currency::query()->updateOrCreate(['code' => 'USD'], ['name' => 'US Dollar', 'symbol' => '$']);
        Currency::query()->updateOrCreate(['code' => 'EUR'], ['name' => 'Euro', 'symbol' => '€']);
        FinancialYear::query()->updateOrCreate(
            ['company_id' => $company->id, 'code' => '2627'],
            ['name' => '2026-27', 'starts_on' => '2026-07-01', 'ends_on' => '2027-06-30', 'is_current' => true],
        );
        foreach (['kg' => 'Kilogram', 'lb' => 'Pound', 'cone' => 'Cone', 'bag' => 'Bag', 'roll' => 'Roll', 'pcs' => 'Piece', 'yd' => 'Yard', 'm' => 'Meter', 'dz' => 'Dozen'] as $code => $name) {
            Uom::query()->updateOrCreate(['code' => $code], ['name' => $name, 'family' => 'measure']);
        }

        foreach (['core', 'masters', 'commercial', 'procurement', 'knitting', 'inventory', 'dyeing', 'quality', 'delivery', 'waste', 'maintenance', 'humanresources', 'accounts', 'operations', 'website'] as $key) {
            ModuleRecord::query()->updateOrCreate(['key' => $key], ['name' => str($key)->headline()->toString()]);
            CompanyModule::query()->updateOrCreate(
                ['company_id' => $company->id, 'module_key' => $key],
                ['enabled' => true],
            );
        }

        foreach (IssueCatalog::all() as $key => $rule) {
            IssueRule::query()->updateOrCreate(
                ['company_id' => $company->id, 'key' => $key],
                [
                    'enabled' => true,
                    'thresholds' => [],
                    'owner_role' => $rule['owner_role'],
                    'severity' => $rule['severity'],
                    'sla_hours' => $rule['sla_hours'],
                ],
            );
        }

        $pages = [
            'home' => ['Gazipur Knit', 'গাজীপুর নিট', 'Circular knitting in Tongi: single jersey, rib, interlock, fleece, and collar-cuff, with dyeing when the order needs it.'],
            'about' => ['About the mill', 'মিল সম্পর্কে', 'The unit started as a 20-machine knitting floor and now runs planning, yarn, knitting, inspection, and delivery from one book.'],
            'capacity' => ['Capacity and machinery', 'ক্ষমতা', 'Mayer, Terrot, and Pailung circular machines, plus flat-bed collar and cuff. Monthly knitting capacity is published on the capacity page.'],
            'process' => ['Production flow', 'প্রক্রিয়া', 'Yarn in, program card, grey roll, inspection, dyeing or direct sale, finished inspection, challan, gate.'],
            'quality' => ['Quality and compliance', 'মান', 'Four-point inspection, GSM and shrinkage tests, and certificate expiry tracking for buyer audits.'],
            'sustainability' => ['ETP and energy', 'পরিবেশ', 'Effluent goes through the ETP. Utility meters feed cost per kilogram.'],
            'clients' => ['Buyers', 'ক্রেতা', 'Export and local apparel buyers. Order status is on the buyer portal.'],
            'gallery' => ['Factory floor', 'গ্যালারি', 'Knitting floor, grey store, and inspection frames.'],
            'contact' => ['Contact', 'যোগাযোগ', 'Tongi, Gazipur. Phone +8801711000000. Email hello@gazipurknit.test.'],
            'faq' => ['Questions', 'প্রশ্ন', 'Job work and own-yarn orders both run through the same order, BOM, and roll register.'],
        ];
        foreach ($pages as $slug => [$title, $titleBn, $body]) {
            CmsPage::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'title_bn' => $titleBn,
                    'body' => $body,
                    'body_bn' => $body,
                    'status' => 'published',
                    'published_at' => now(),
                    'seo_title' => $title.' | Gazipur Knit',
                    'seo_description' => $body,
                ],
            );
        }

        CatalogProduct::query()->updateOrCreate(
            ['slug' => 'single-jersey-160'],
            [
                'title' => 'Single jersey 160 GSM',
                'title_bn' => 'সিঙ্গেল জার্সি ১৬০',
                'composition' => '100% cotton',
                'gsm' => '160',
                'uses' => 'T-shirt',
                'description' => 'Combed cotton single jersey, 30 inch dia, 24 gauge.',
                'published' => true,
            ],
        );

        app(KnitCycle::class)->run($company, $unit);
        CompanyContext::forget();
    }
}
