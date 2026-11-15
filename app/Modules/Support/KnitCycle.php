<?php

declare(strict_types=1);

namespace App\Modules\Support;

use App\Modules\Accounts\Models\Account;
use App\Modules\Accounts\Models\JournalLine;
use App\Modules\Accounts\Models\Voucher;
use App\Modules\Accounts\Services\LedgerPoster;
use App\Modules\Commercial\Models\Bom;
use App\Modules\Commercial\Models\BomLine;
use App\Modules\Commercial\Models\SalesOrder;
use App\Modules\Commercial\Models\SalesOrderLine;
use App\Modules\Commercial\Services\BomCalculator;
use App\Modules\Core\Models\Company;
use App\Modules\Core\Models\Unit;
use App\Modules\Core\Models\Warehouse;
use App\Modules\Core\Services\ApprovalEngine;
use App\Modules\Core\Services\DocumentNumberer;
use App\Modules\Delivery\Models\DeliveryChallan;
use App\Modules\Delivery\Models\DeliveryChallanLine;
use App\Modules\Delivery\Models\GatePass;
use App\Modules\Delivery\Models\PackingList;
use App\Modules\Delivery\Models\PackingListLine;
use App\Modules\Delivery\Models\SalesInvoice;
use App\Modules\Delivery\Models\SalesInvoiceLine;
use App\Modules\Dyeing\Models\DyeBatch;
use App\Modules\Dyeing\Models\DyeBatchRoll;
use App\Modules\Inventory\Models\YarnIssue;
use App\Modules\Inventory\Models\YarnIssueLine;
use App\Modules\Inventory\Services\StockLedgerService;
use App\Modules\Knitting\Models\GreyInspection;
use App\Modules\Knitting\Models\KnittingProgram;
use App\Modules\Knitting\Models\Machine;
use App\Modules\Knitting\Models\Roll;
use App\Modules\Knitting\Services\MachineSuggester;
use App\Modules\Masters\Models\Color;
use App\Modules\Masters\Models\FabricConstruction;
use App\Modules\Masters\Models\FabricItem;
use App\Modules\Masters\Models\Party;
use App\Modules\Masters\Models\YarnCount;
use App\Modules\Masters\Models\YarnItem;
use App\Modules\Masters\Models\YarnType;
use App\Modules\Procurement\Models\GoodsReceipt;
use App\Modules\Procurement\Models\GoodsReceiptLine;
use App\Modules\Procurement\Models\PurchaseOrder;
use App\Modules\Procurement\Models\PurchaseOrderLine;
use App\Modules\Procurement\Models\YarnLot;
use App\Modules\Quality\Models\FinishedInspection;
use App\Modules\Quality\Services\FourPointGrader;
use App\Modules\Waste\Models\WasteEntry;
use Illuminate\Support\Facades\DB;

/**
 * Demo path: order, BOM, purchase, receipt, issue, knitting, inspection, dyeing, packing, invoice, payment.
 */
final class KnitCycle
{
    public function __construct(
        private readonly DocumentNumberer $numbers,
        private readonly ApprovalEngine $approvals,
        private readonly StockLedgerService $stock,
        private readonly LedgerPoster $ledger,
        private readonly BomCalculator $bomCalculator,
        private readonly MachineSuggester $machines,
        private readonly FourPointGrader $grader,
    ) {}

    /**
     * @return array<string, float|int|string>
     */
    public function run(Company $company, Unit $unit): array
    {
        return DB::transaction(function () use ($company, $unit): array {
            CompanyContext::set($company->id, $unit->id);
            $existing = SalesOrder::query()->where('buyer_po', 'PO-DEMO-1000')->first();
            if ($existing instanceof SalesOrder) {
                return $this->snapshot($company->id, $unit->id);
            }

            $this->accounts($company->id);
            $warehouse = Warehouse::query()->firstOrCreate(
                ['company_id' => $company->id, 'code' => 'YRN'],
                ['unit_id' => $unit->id, 'name' => 'Yarn godown', 'kind' => 'yarn'],
            );
            $greyStore = Warehouse::query()->firstOrCreate(
                ['company_id' => $company->id, 'code' => 'GRY'],
                ['unit_id' => $unit->id, 'name' => 'Grey store', 'kind' => 'grey'],
            );
            $fgStore = Warehouse::query()->firstOrCreate(
                ['company_id' => $company->id, 'code' => 'FIN'],
                ['unit_id' => $unit->id, 'name' => 'Finished store', 'kind' => 'finished'],
            );

            $buyer = Party::query()->firstOrCreate(
                ['company_id' => $company->id, 'code' => 'BYR-01'],
                ['name' => 'Dhaka Apparel Ltd', 'party_type' => 'buyer', 'credit_limit' => 5000000, 'credit_days' => 30, 'currency_code' => 'BDT'],
            );
            $spinner = Party::query()->firstOrCreate(
                ['company_id' => $company->id, 'code' => 'SPN-01'],
                ['name' => 'Square Spinning', 'party_type' => 'supplier', 'currency_code' => 'BDT'],
            );
            $count = YarnCount::query()->firstOrCreate(
                ['company_id' => $company->id, 'label' => '30 Ne'],
                ['system' => 'Ne', 'value' => '30'],
            );
            $type = YarnType::query()->firstOrCreate(
                ['company_id' => $company->id, 'slug' => 'combed-cotton'],
                ['name' => 'Combed cotton'],
            );
            $yarn = YarnItem::query()->firstOrCreate(
                ['company_id' => $company->id, 'code' => 'Y30C'],
                ['yarn_count_id' => $count->id, 'yarn_type_id' => $type->id, 'name' => '30s combed cotton', 'composition' => '100% cotton', 'uom' => 'kg', 'last_rate' => 450],
            );
            $color = Color::query()->firstOrCreate(
                ['company_id' => $company->id, 'name' => 'Optical white'],
                ['pantone' => '11-0601', 'buyer_code' => 'OW'],
            );
            $construction = FabricConstruction::query()->firstOrCreate(
                ['company_id' => $company->id, 'slug' => 'single-jersey'],
                ['name' => 'Single jersey', 'family' => 'single jersey'],
            );
            $fabric = FabricItem::query()->firstOrCreate(
                ['company_id' => $company->id, 'code' => 'SJ160'],
                [
                    'fabric_construction_id' => $construction->id,
                    'color_id' => $color->id,
                    'name' => 'Single jersey 160 GSM',
                    'gsm_target' => 160,
                    'gsm_min' => 155,
                    'gsm_max' => 165,
                    'dia' => 30,
                    'composition' => '100% cotton',
                    'gauge' => 24,
                    'uom' => 'kg',
                ],
            );

            $fabricKg = 1000.0;
            $yarnKg = $this->bomCalculator->yarnKilograms($fabricKg, 100, 3, 2);
            $yarnRate = 450.0;
            $yarnValue = round($yarnKg * $yarnRate, 2);
            $sellRate = 650.0;

            $order = SalesOrder::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'party_id' => $buyer->id,
                'number' => $this->numbers->next('SO', 'SO', $company->id, $unit->id, $unit->code),
                'buyer_po' => 'PO-DEMO-1000',
                'order_date' => now()->toDateString(),
                'delivery_date' => now()->addDays(21)->toDateString(),
                'currency_code' => 'BDT',
                'shipment_terms' => 'EXW Gazipur',
                'tolerance_pct' => 5,
                'yarn_source' => 'own',
                'status' => 'draft',
            ]);
            $line = SalesOrderLine::query()->create([
                'company_id' => $company->id,
                'sales_order_id' => $order->id,
                'fabric_item_id' => $fabric->id,
                'color_id' => $color->id,
                'gsm' => 160,
                'dia' => 30,
                'qty_kg' => $fabricKg,
                'rate' => $sellRate,
            ]);
            $this->approvals->submit($order);

            $bom = Bom::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'sales_order_id' => $order->id,
                'fabric_item_id' => $fabric->id,
                'number' => $this->numbers->next('BOM', 'BOM', $company->id, $unit->id, $unit->code),
                'process_loss_pct' => 3,
                'wastage_pct' => 2,
                'status' => 'draft',
            ]);
            BomLine::query()->create([
                'company_id' => $company->id,
                'bom_id' => $bom->id,
                'yarn_item_id' => $yarn->id,
                'ratio_pct' => 100,
                'requirement_kg' => $yarnKg,
            ]);
            $this->approvals->submit($bom);

            $po = PurchaseOrder::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'party_id' => $spinner->id,
                'number' => $this->numbers->next('PO', 'PO', $company->id, $unit->id, $unit->code),
                'status' => 'draft',
                'currency_code' => 'BDT',
                'order_date' => now()->toDateString(),
            ]);
            $poLine = PurchaseOrderLine::query()->create([
                'company_id' => $company->id,
                'purchase_order_id' => $po->id,
                'yarn_item_id' => $yarn->id,
                'qty' => $yarnKg,
                'rate' => $yarnRate,
            ]);
            $this->approvals->submit($po);

            $challanWeight = 1052.0;
            $shortage = round($challanWeight - $yarnKg, 4);
            $grn = GoodsReceipt::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'purchase_order_id' => $po->id,
                'party_id' => $spinner->id,
                'warehouse_id' => $warehouse->id,
                'number' => $this->numbers->next('GRN', 'GRN', $company->id, $unit->id, $unit->code),
                'challan_no' => 'CH-1052',
                'received_on' => now()->toDateString(),
                'status' => 'draft',
            ]);
            GoodsReceiptLine::query()->create([
                'company_id' => $company->id,
                'goods_receipt_id' => $grn->id,
                'purchase_order_line_id' => $poLine->id,
                'yarn_item_id' => $yarn->id,
                'lot_no' => 'L-2401',
                'bags' => 42,
                'challan_weight' => $challanWeight,
                'actual_weight' => $yarnKg,
                'shortage' => $shortage,
                'qc_status' => 'pass',
            ]);
            $poLine->received_qty = $yarnKg;
            $poLine->save();
            $lot = YarnLot::query()->create([
                'company_id' => $company->id,
                'yarn_item_id' => $yarn->id,
                'party_id' => $spinner->id,
                'warehouse_id' => $warehouse->id,
                'lot_no' => 'L-2401',
                'received_on' => now()->toDateString(),
                'qc_status' => 'pass',
                'barcode' => 'LOT-L-2401',
                'net_kg' => $yarnKg,
            ]);
            $this->stock->move([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'warehouse_id' => $warehouse->id,
                'stock_type' => 'yarn',
                'item_id' => $yarn->id,
                'lot_id' => $lot->id,
                'qty_in' => $yarnKg,
                'rate' => $yarnRate,
                'ref_type' => 'grn',
                'ref_id' => $grn->id,
                'movement_key' => 'grn-'.$grn->id.'-yarn',
            ]);
            $this->ledger->post($company->id, $unit->id, 'Yarn GRN '.$grn->number, [
                ['account' => '1300', 'debit' => $yarnValue, 'party_id' => $spinner->id],
                ['account' => '2000', 'credit' => $yarnValue, 'party_id' => $spinner->id],
            ], GoodsReceipt::class, $grn->id);
            $this->approvals->submit($grn);

            $machine = Machine::query()->firstOrCreate(
                ['company_id' => $company->id, 'code' => 'SJ-14'],
                ['unit_id' => $unit->id, 'name' => 'Mayer single jersey 14', 'machine_type' => 'single jersey', 'dia' => 30, 'gauge' => 24, 'feeders' => 90, 'rpm' => 28, 'capacity_kg_shift' => 280, 'status' => 'running'],
            );
            if (! $this->machines->compatible($machine, 'single jersey', 30, 24)) {
                throw new \RuntimeException('Demo machine is not compatible with the order.');
            }

            $program = KnittingProgram::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'sales_order_id' => $order->id,
                'sales_order_line_id' => $line->id,
                'machine_id' => $machine->id,
                'fabric_item_id' => $fabric->id,
                'color_id' => $color->id,
                'number' => $this->numbers->next('KP', 'KP', $company->id, $unit->id, $unit->code),
                'target_kg' => $fabricKg,
                'target_gsm' => 160,
                'dia' => 30,
                'stitch_length' => 2.8,
                'status' => 'draft',
            ]);
            $this->approvals->submit($program);

            $issue = YarnIssue::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'knitting_program_id' => $program->id,
                'warehouse_id' => $warehouse->id,
                'number' => $this->numbers->next('YIS', 'YIS', $company->id, $unit->id, $unit->code),
                'issued_on' => now()->toDateString(),
                'status' => 'draft',
            ]);
            YarnIssueLine::query()->create([
                'company_id' => $company->id,
                'yarn_issue_id' => $issue->id,
                'yarn_lot_id' => $lot->id,
                'yarn_item_id' => $yarn->id,
                'qty' => $yarnKg,
                'approved_mix' => false,
            ]);
            $this->stock->move([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'warehouse_id' => $warehouse->id,
                'stock_type' => 'yarn',
                'item_id' => $yarn->id,
                'lot_id' => $lot->id,
                'qty_out' => $yarnKg,
                'ref_type' => 'yarn_issue',
                'ref_id' => $issue->id,
                'movement_key' => 'issue-'.$issue->id,
            ]);
            $this->ledger->post($company->id, $unit->id, 'Yarn to knitting '.$issue->number, [
                ['account' => '1330', 'debit' => $yarnValue],
                ['account' => '1300', 'credit' => $yarnValue],
            ], YarnIssue::class, $issue->id);
            $this->approvals->submit($issue);

            $rollKg = 98.0;
            $rollCount = 10;
            $greyKg = round($rollKg * $rollCount, 4);
            $rolls = [];
            for ($i = 1; $i <= $rollCount; $i++) {
                $roll = Roll::query()->create([
                    'company_id' => $company->id,
                    'unit_id' => $unit->id,
                    'knitting_program_id' => $program->id,
                    'machine_id' => $machine->id,
                    'warehouse_id' => $greyStore->id,
                    'sales_order_id' => $order->id,
                    'number' => $this->numbers->next('ROLL', 'ROLL', $company->id, $unit->id, $unit->code),
                    'gross_kg' => $rollKg + 0.4,
                    'net_kg' => $rollKg,
                    'gsm' => 160,
                    'dia' => 30,
                    'yards' => 120,
                    'grade' => 'A',
                    'stage' => 'grey',
                    'yarn_lots' => ['L-2401'],
                    'produced_at' => now(),
                ]);
                $roll->barcode = 'R-'.$roll->id;
                $roll->save();
                GreyInspection::query()->create([
                    'company_id' => $company->id,
                    'roll_id' => $roll->id,
                    'gsm' => 160,
                    'dia' => 30,
                    'points' => 0,
                    'grade' => 'A',
                    'length_m' => 110,
                    'status' => 'released',
                ]);
                $roll->stage = 'inspected';
                $roll->save();
                $rolls[] = $roll;
            }
            $this->stock->move([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'warehouse_id' => $greyStore->id,
                'stock_type' => 'grey',
                'item_id' => $fabric->id,
                'qty_in' => $greyKg,
                'rate' => round($yarnValue / $greyKg, 4),
                'ref_type' => 'knitting',
                'ref_id' => $program->id,
                'movement_key' => 'grey-in-'.$program->id,
            ]);
            $this->ledger->post($company->id, $unit->id, 'Grey from knitting '.$program->number, [
                ['account' => '1310', 'debit' => $yarnValue],
                ['account' => '1330', 'credit' => $yarnValue],
            ], KnittingProgram::class, $program->id);

            $finishedKg = 950.0;
            $lossPct = round((($greyKg - $finishedKg) / $greyKg) * 100, 4);
            $batch = DyeBatch::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'color_id' => $color->id,
                'number' => $this->numbers->next('BAT', 'BAT', $company->id, $unit->id, $unit->code),
                'input_kg' => $greyKg,
                'output_kg' => $finishedKg,
                'process_loss_pct' => $lossPct,
                'shade_de' => 0.4,
                'status' => 'draft',
                'is_subcontract' => false,
            ]);
            foreach ($rolls as $roll) {
                DyeBatchRoll::query()->create([
                    'company_id' => $company->id,
                    'dye_batch_id' => $batch->id,
                    'roll_id' => $roll->id,
                    'kg' => $rollKg,
                ]);
                $roll->warehouse_id = $fgStore->id;
                $roll->stage = 'finished';
                $roll->net_kg = round($finishedKg / $rollCount, 4);
                $roll->save();
            }
            $this->stock->move([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'warehouse_id' => $greyStore->id,
                'stock_type' => 'grey',
                'item_id' => $fabric->id,
                'qty_out' => $greyKg,
                'ref_type' => 'dye_batch',
                'ref_id' => $batch->id,
                'movement_key' => 'grey-out-'.$batch->id,
            ]);
            $this->stock->move([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'warehouse_id' => $fgStore->id,
                'stock_type' => 'finished',
                'item_id' => $fabric->id,
                'qty_in' => $finishedKg,
                'rate' => round($yarnValue / $finishedKg, 4),
                'ref_type' => 'dye_batch',
                'ref_id' => $batch->id,
                'movement_key' => 'fg-in-'.$batch->id,
            ]);
            $this->ledger->post($company->id, $unit->id, 'Finished from batch '.$batch->number, [
                ['account' => '1320', 'debit' => $yarnValue],
                ['account' => '1310', 'credit' => $yarnValue],
            ], DyeBatch::class, $batch->id);
            $this->approvals->submit($batch);

            $points = $this->grader->pointsPerHundredSquareYards(8, 100, 60);
            FinishedInspection::query()->create([
                'company_id' => $company->id,
                'roll_id' => $rolls[0]->id,
                'points_per_100' => $points,
                'grade' => $this->grader->grade($points),
                'length_yd' => 100,
                'width_in' => 60,
                'status' => 'released',
            ]);

            $packing = PackingList::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'sales_order_id' => $order->id,
                'number' => $this->numbers->next('PL', 'PL', $company->id, $unit->id, $unit->code),
                'net_kg' => $finishedKg,
                'gross_kg' => $finishedKg + 4,
                'yards' => 1200,
                'status' => 'draft',
            ]);
            foreach ($rolls as $roll) {
                PackingListLine::query()->create([
                    'company_id' => $company->id,
                    'packing_list_id' => $packing->id,
                    'roll_id' => $roll->id,
                    'net_kg' => $roll->net_kg,
                    'yards' => 120,
                ]);
                $roll->stage = 'packed';
                $roll->save();
            }

            $challan = DeliveryChallan::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'packing_list_id' => $packing->id,
                'party_id' => $buyer->id,
                'number' => $this->numbers->next('DC', 'DC', $company->id, $unit->id, $unit->code),
                'vehicle_no' => 'DHAKA-METRO-T-11-2401',
                'driver' => 'Karim',
                'mushak' => '6.3',
                'status' => 'draft',
            ]);
            foreach ($rolls as $roll) {
                DeliveryChallanLine::query()->create([
                    'company_id' => $company->id,
                    'delivery_challan_id' => $challan->id,
                    'roll_id' => $roll->id,
                    'kg' => $roll->net_kg,
                ]);
                $roll->stage = 'delivered';
                $roll->save();
            }
            GatePass::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'number' => $this->numbers->next('GP', 'GP', $company->id, $unit->id, $unit->code),
                'direction' => 'out',
                'ref_type' => DeliveryChallan::class,
                'ref_id' => $challan->id,
                'vehicle_no' => 'DHAKA-METRO-T-11-2401',
                'status' => 'verified',
                'verified_at' => now(),
            ]);
            $this->stock->move([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'warehouse_id' => $fgStore->id,
                'stock_type' => 'finished',
                'item_id' => $fabric->id,
                'qty_out' => $finishedKg,
                'ref_type' => 'delivery',
                'ref_id' => $challan->id,
                'movement_key' => 'fg-out-'.$challan->id,
            ]);

            $subtotal = round($finishedKg * $sellRate, 2);
            $vat = round($subtotal * 0.15, 2);
            $total = round($subtotal + $vat, 2);
            $invoice = SalesInvoice::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'delivery_challan_id' => $challan->id,
                'party_id' => $buyer->id,
                'number' => $this->numbers->next('INV', 'INV', $company->id, $unit->id, $unit->code),
                'subtotal' => $subtotal,
                'vat' => $vat,
                'total' => $total,
                'currency_code' => 'BDT',
                'invoice_date' => now()->toDateString(),
                'due_date' => now()->addDays(30)->toDateString(),
                'status' => 'draft',
            ]);
            SalesInvoiceLine::query()->create([
                'company_id' => $company->id,
                'sales_invoice_id' => $invoice->id,
                'description' => 'Single jersey 160 GSM',
                'qty' => $finishedKg,
                'rate' => $sellRate,
                'amount' => $subtotal,
            ]);
            $this->ledger->post($company->id, $unit->id, 'Delivery '.$invoice->number, [
                ['account' => '5000', 'debit' => $yarnValue],
                ['account' => '1320', 'credit' => $yarnValue],
                ['account' => '1200', 'debit' => $total, 'party_id' => $buyer->id],
                ['account' => '4000', 'credit' => $subtotal, 'party_id' => $buyer->id],
                ['account' => '2100', 'credit' => $vat],
            ], SalesInvoice::class, $invoice->id);
            $this->approvals->submit($invoice);

            $receipt = $this->ledger->post($company->id, $unit->id, 'Collection '.$invoice->number, [
                ['account' => '1010', 'debit' => $total],
                ['account' => '1200', 'credit' => $total, 'party_id' => $buyer->id],
            ], SalesInvoice::class, $invoice->id);
            Voucher::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'party_id' => $buyer->id,
                'journal_id' => $receipt->id,
                'kind' => 'receipt',
                'number' => $this->numbers->next('VCH', 'RV', $company->id, $unit->id, $unit->code),
                'voucher_date' => now()->toDateString(),
                'amount' => $total,
                'status' => 'posted',
                'narration' => 'Buyer collection',
            ]);

            WasteEntry::query()->create([
                'company_id' => $company->id,
                'unit_id' => $unit->id,
                'sales_order_id' => $order->id,
                'machine_id' => $machine->id,
                'warehouse_id' => $warehouse->id,
                'number' => $this->numbers->next('WST', 'WST', $company->id, $unit->id, $unit->code),
                'kind' => 'yarn',
                'qty_kg' => round($yarnKg - $greyKg, 4),
                'rate' => $yarnRate,
                'value' => round(($yarnKg - $greyKg) * $yarnRate, 2),
                'status' => 'posted',
            ]);

            return $this->snapshot($company->id, $unit->id, [
                'yarn_kg' => $yarnKg,
                'yarn_value' => $yarnValue,
                'grey_kg' => $greyKg,
                'finished_kg' => $finishedKg,
                'invoice_total' => $total,
                'invoice_subtotal' => $subtotal,
                'vat' => $vat,
                'order_id' => $order->id,
                'invoice_number' => $invoice->number,
            ]);
        });
    }

    /**
     * @param  array<string, float|int|string>  $extra
     * @return array<string, float|int|string>
     */
    private function snapshot(int $companyId, int $unitId, array $extra = []): array
    {
        $yarnWarehouse = Warehouse::query()->where('code', 'YRN')->where('company_id', $companyId)->first();
        $greyWarehouse = Warehouse::query()->where('code', 'GRY')->where('company_id', $companyId)->first();
        $fgWarehouse = Warehouse::query()->where('code', 'FIN')->where('company_id', $companyId)->first();
        $yarn = YarnItem::query()->where('code', 'Y30C')->where('company_id', $companyId)->first();
        $fabric = FabricItem::query()->where('code', 'SJ160')->where('company_id', $companyId)->first();

        $debit = round((float) JournalLine::query()->where('company_id', $companyId)->sum('debit'), 2);
        $credit = round((float) JournalLine::query()->where('company_id', $companyId)->sum('credit'), 2);

        return array_merge($extra, [
            'company_id' => $companyId,
            'unit_id' => $unitId,
            'yarn_on_hand' => $yarn && $yarnWarehouse ? $this->stock->onHand($companyId, $yarnWarehouse->id, 'yarn', $yarn->id, YarnLot::query()->where('lot_no', 'L-2401')->value('id')) : 0,
            'grey_on_hand' => $fabric && $greyWarehouse ? $this->stock->onHand($companyId, $greyWarehouse->id, 'grey', $fabric->id) : 0,
            'finished_on_hand' => $fabric && $fgWarehouse ? $this->stock->onHand($companyId, $fgWarehouse->id, 'finished', $fabric->id) : 0,
            'journal_difference' => round($debit - $credit, 2),
            'ar_balance' => $this->ledger->balance($companyId, '1200'),
            'yarn_gl' => $this->ledger->balance($companyId, '1300'),
            'grey_gl' => $this->ledger->balance($companyId, '1310'),
            'finished_gl' => $this->ledger->balance($companyId, '1320'),
        ]);
    }

    private function accounts(int $companyId): void
    {
        $chart = [
            '1000' => ['Cash', 'asset'],
            '1010' => ['Bank', 'asset'],
            '1200' => ['Accounts receivable', 'asset'],
            '1300' => ['Yarn stock', 'asset'],
            '1310' => ['Grey fabric', 'asset'],
            '1320' => ['Finished fabric', 'asset'],
            '1330' => ['Work in process', 'asset'],
            '2000' => ['Accounts payable', 'liability'],
            '2100' => ['VAT payable', 'liability'],
            '4000' => ['Fabric sales', 'income'],
            '5000' => ['Cost of goods', 'expense'],
        ];

        foreach ($chart as $code => [$name, $type]) {
            Account::query()->firstOrCreate(
                ['company_id' => $companyId, 'code' => $code],
                ['name' => $name, 'type' => $type],
            );
        }
    }
}
