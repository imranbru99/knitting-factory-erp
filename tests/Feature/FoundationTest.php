<?php

use App\Models\User;
use App\Modules\Commercial\Models\SalesOrder;
use App\Modules\Core\Models\ApprovalLevel;
use App\Modules\Core\Models\ApprovalWorkflow;
use App\Modules\Core\Models\Company;
use App\Modules\Core\Models\Role;
use App\Modules\Core\Models\Unit;
use App\Modules\Core\Models\Warehouse;
use App\Modules\Core\Services\ApprovalEngine;
use App\Modules\Core\Services\DocumentNumberer;
use App\Modules\Inventory\Services\StockLedgerService;
use App\Modules\Masters\Models\Party;
use App\Modules\Support\CompanyContext;
use Illuminate\Support\Carbon;

it('issues gap-free document numbers for the financial year', function () {
    $company = Company::query()->create(['code' => 'GK', 'name' => 'Gazipur Knit', 'default_currency' => 'BDT']);
    $unit = Unit::query()->create(['company_id' => $company->id, 'code' => 'U1', 'name' => 'Tongi', 'type' => 'factory']);
    $numbers = app(DocumentNumberer::class);
    $fy = $numbers->financialYearCode(Carbon::parse('2026-11-15'));

    expect($fy)->toBe('2627');
    expect($numbers->next('SO', 'SO', $company->id, $unit->id, 'U1', $fy))->toBe('SO/2627/U1/00001');
    expect($numbers->next('SO', 'SO', $company->id, $unit->id, 'U1', $fy))->toBe('SO/2627/U1/00002');
});

it('keeps each company on its own records and walks a two-step approval', function () {
    $first = Company::query()->create(['code' => 'A', 'name' => 'Mill A', 'default_currency' => 'BDT']);
    $second = Company::query()->create(['code' => 'B', 'name' => 'Mill B', 'default_currency' => 'BDT']);
    $unit = Unit::query()->create(['company_id' => $first->id, 'code' => 'U1', 'name' => 'Unit', 'type' => 'factory']);
    $buyer = Party::query()->create(['company_id' => $first->id, 'code' => 'B1', 'name' => 'Buyer', 'party_type' => 'buyer']);
    CompanyContext::set($second->id);
    expect(Party::query()->count())->toBe(0);
    CompanyContext::set($first->id, $unit->id);
    expect(Party::query()->count())->toBe(1);

    $gm = User::factory()->create(['company_id' => $first->id, 'unit_id' => $unit->id, 'is_super_admin' => false]);
    $role = Role::query()->create(['company_id' => $first->id, 'name' => 'GM', 'slug' => 'gm', 'is_system' => true]);
    $gm->roles()->attach($role);
    $this->actingAs($gm);

    $workflow = ApprovalWorkflow::query()->create([
        'company_id' => $first->id,
        'doc_type' => 'SO',
        'name' => 'Sales order',
        'is_active' => true,
    ]);
    ApprovalLevel::query()->create(['company_id' => $first->id, 'approval_workflow_id' => $workflow->id, 'level' => 1, 'role_slug' => 'gm', 'timeout_hours' => 1]);
    ApprovalLevel::query()->create(['company_id' => $first->id, 'approval_workflow_id' => $workflow->id, 'level' => 2, 'role_slug' => 'gm', 'timeout_hours' => 1]);

    $order = SalesOrder::query()->create([
        'company_id' => $first->id,
        'unit_id' => $unit->id,
        'party_id' => $buyer->id,
        'status' => 'draft',
        'currency_code' => 'BDT',
    ]);
    $request = app(ApprovalEngine::class)->submit($order);
    expect($order->fresh()->status)->toBe('pending');

    app(ApprovalEngine::class)->approve($request, $gm, 'Merchandising checked');
    expect($order->fresh()->status)->toBe('pending');
    app(ApprovalEngine::class)->approve($request->fresh(), $gm, 'GM checked');
    $order = $order->fresh();
    expect($order->status)->toBe('approved');

    $order->notes = 'changed';
    expect(fn () => $order->save())->toThrow(RuntimeException::class);
});

it('refuses to issue yarn that is not in the godown', function () {
    $company = Company::query()->create(['code' => 'GK', 'name' => 'Gazipur Knit', 'default_currency' => 'BDT']);
    $unit = Unit::query()->create(['company_id' => $company->id, 'code' => 'U1', 'name' => 'Tongi', 'type' => 'factory']);
    $warehouse = Warehouse::query()->create(['company_id' => $company->id, 'unit_id' => $unit->id, 'code' => 'YRN', 'name' => 'Yarn', 'kind' => 'yarn']);
    $stock = app(StockLedgerService::class);
    $stock->move([
        'company_id' => $company->id,
        'unit_id' => $unit->id,
        'warehouse_id' => $warehouse->id,
        'stock_type' => 'yarn',
        'item_id' => 1,
        'lot_id' => 9,
        'qty_in' => 10,
        'rate' => 450,
        'movement_key' => 'in-1',
    ]);

    expect(fn () => $stock->move([
        'company_id' => $company->id,
        'warehouse_id' => $warehouse->id,
        'stock_type' => 'yarn',
        'item_id' => 1,
        'lot_id' => 9,
        'qty_out' => 12,
        'movement_key' => 'out-1',
    ]))->toThrow(RuntimeException::class);
    expect($stock->onHand($company->id, $warehouse->id, 'yarn', 1, 9))->toBe(10.0);
});
