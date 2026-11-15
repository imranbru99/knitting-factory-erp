<?php

declare(strict_types=1);

namespace App\Modules\Operations\Services;

final class IssueCatalog
{
    /**
     * @return array<string, array{title: string, severity: string, owner_role: string, sla_hours: int, solution: string, detect: callable, positive: array<string, mixed>, negative: array<string, mixed>}>
     */
    public static function all(): array
    {
        return [
            'lot_mix' => self::rule('Yarn lot mixed on one program', 'high', 'store', 4, 'Stop the issue or record an approved lot mix before knitting starts.', fn (array $f): bool => (int) ($f['distinct_lots'] ?? 1) > 1 && ! ($f['mix_approved'] ?? false), ['distinct_lots' => 2, 'mix_approved' => false], ['distinct_lots' => 1, 'mix_approved' => false]),
            'yarn_over_bom' => self::rule('Yarn issued above the BOM', 'high', 'store', 4, 'Cut the issue back to the BOM quantity or get a revised allowance.', fn (array $f): bool => (float) ($f['issued_kg'] ?? 0) > (float) ($f['bom_kg'] ?? 0) + 0.01, ['issued_kg' => 1100, 'bom_kg' => 1050.6], ['issued_kg' => 1050.6, 'bom_kg' => 1050.6]),
            'yarn_shortage' => self::rule('Yarn will not cover the open program', 'high', 'merchandiser', 8, 'Raise a requisition and tell the supplier the shortage date.', fn (array $f): bool => ((float) ($f['on_hand'] ?? 0) + (float) ($f['open_po'] ?? 0)) + 0.01 < (float) ($f['requirement'] ?? 0), ['on_hand' => 100, 'open_po' => 200, 'requirement' => 1050], ['on_hand' => 800, 'open_po' => 300, 'requirement' => 1050]),
            'machine_idle' => self::rule('Machine idle beyond the limit', 'high', 'production', 1, 'Supervisor must enter a stoppage reason and restart or replan the machine.', fn (array $f): bool => (int) ($f['idle_minutes'] ?? 0) > (int) ($f['limit'] ?? 15), ['idle_minutes' => 40, 'limit' => 15], ['idle_minutes' => 10, 'limit' => 15]),
            'wrong_machine' => self::rule('Program allocated to an incompatible machine', 'high', 'planning', 4, 'Move the program to a machine with the matching type, dia, and gauge.', fn (array $f): bool => ($f['compatible'] ?? true) === false, ['compatible' => false], ['compatible' => true]),
            'gsm_out' => self::rule('Roll GSM is outside tolerance', 'medium', 'production', 4, 'Hold the roll and adjust stitch length before the next doff.', fn (array $f): bool => (float) ($f['gsm'] ?? 0) < (float) ($f['min'] ?? 0) || (float) ($f['gsm'] ?? 0) > (float) ($f['max'] ?? 0), ['gsm' => 180, 'min' => 155, 'max' => 165], ['gsm' => 160, 'min' => 155, 'max' => 165]),
            'repeated_defect' => self::rule('Same defect keeps repeating', 'high', 'qc', 24, 'Open a CAPA against the machine, operator, or yarn lot.', fn (array $f): bool => (int) ($f['count'] ?? 0) >= (int) ($f['limit'] ?? 3), ['count' => 4, 'limit' => 3], ['count' => 1, 'limit' => 3]),
            'duplicate_roll' => self::rule('Duplicate roll number or barcode', 'high', 'store', 1, 'Reject the second scan and reprint the original roll tag.', fn (array $f): bool => ($f['duplicate'] ?? false) === true, ['duplicate' => true], ['duplicate' => false]),
            'dye_short' => self::rule('Dye-house return is short', 'high', 'dyeing', 8, 'Hold the dyer bill and raise a shortage claim.', fn (array $f): bool => (float) ($f['loss_pct'] ?? 0) > (float) ($f['tolerance'] ?? 5), ['loss_pct' => 8.5, 'tolerance' => 5], ['loss_pct' => 3.1, 'tolerance' => 5]),
            'delivery_delay' => self::rule('Order delivery is late', 'high', 'merchandiser', 8, 'Send a revised ETA to the buyer and flag the blocking milestone.', fn (array $f): bool => (int) ($f['delay_days'] ?? 0) > 0 && ! ($f['delivered'] ?? false), ['delay_days' => 3, 'delivered' => false], ['delay_days' => 0, 'delivered' => false]),
            'shipment_tolerance' => self::rule('Shipment is outside the order tolerance', 'high', 'merchandiser', 4, 'Get buyer approval before the gate pass is printed.', fn (array $f): bool => abs((float) ($f['variance_pct'] ?? 0)) > (float) ($f['tolerance_pct'] ?? 0), ['variance_pct' => -8, 'tolerance_pct' => 5], ['variance_pct' => -5, 'tolerance_pct' => 5]),
            'receivable_overdue' => self::rule('Buyer receivable is overdue', 'high', 'accounts', 24, 'Send a reminder and block the next delivery until an override is approved.', fn (array $f): bool => (float) ($f['balance'] ?? 0) > 0 && (int) ($f['days_overdue'] ?? 0) > 0, ['balance' => 710125, 'days_overdue' => 12], ['balance' => 0, 'days_overdue' => 12]),
            'three_way_mismatch' => self::rule('PO, GRN, and bill do not match', 'medium', 'accounts', 24, 'Ask the supplier for a revised bill or a debit note.', fn (array $f): bool => abs((float) ($f['po_qty'] ?? 0) - (float) ($f['grn_qty'] ?? 0)) > 0.01 || abs((float) ($f['grn_value'] ?? 0) - (float) ($f['bill_amount'] ?? 0)) > 0.01, ['po_qty' => 100, 'grn_qty' => 98, 'grn_value' => 45000, 'bill_amount' => 47000], ['po_qty' => 100, 'grn_qty' => 100, 'grn_value' => 45000, 'bill_amount' => 45000]),
            'repeated_breakdown' => self::rule('Machine breakdown is repeating', 'high', 'maintenance', 8, 'Create a preventive work order and check the spare that failed.', fn (array $f): bool => (int) ($f['count'] ?? 0) >= (int) ($f['limit'] ?? 3), ['count' => 3, 'limit' => 3], ['count' => 1, 'limit' => 3]),
            'spare_stockout' => self::rule('Spare or needle stock is below minimum', 'high', 'maintenance', 8, 'Raise a requisition before the next shift.', fn (array $f): bool => (float) ($f['on_hand'] ?? 0) < (float) ($f['min_qty'] ?? 0), ['on_hand' => 2, 'min_qty' => 20], ['on_hand' => 40, 'min_qty' => 20]),
            'power_cost' => self::rule('Power cost per kilogram is high', 'medium', 'maintenance', 24, 'Compare the shift meter with production and check idle machines.', fn (array $f): bool => (float) ($f['cost_per_kg'] ?? 0) > (float) ($f['limit'] ?? 15), ['cost_per_kg' => 22, 'limit' => 15], ['cost_per_kg' => 9, 'limit' => 15]),
            'attendance_anomaly' => self::rule('Absent without leave', 'medium', 'hr', 8, 'Confirm the biometric punch and hold overtime until a leave or correction is approved.', fn (array $f): bool => ($f['absent'] ?? false) === true && ($f['leave_approved'] ?? false) === false, ['absent' => true, 'leave_approved' => false], ['absent' => true, 'leave_approved' => true]),
            'price_creep' => self::rule('Purchase rate moved up', 'medium', 'procurement', 24, 'Compare with the last PO and send the rate for approval.', fn (array $f): bool => (float) ($f['last_rate'] ?? 0) > 0 && (float) ($f['new_rate'] ?? 0) > (float) $f['last_rate'] * (1 + ((float) ($f['limit_pct'] ?? 5) / 100)), ['last_rate' => 450, 'new_rate' => 490, 'limit_pct' => 5], ['last_rate' => 450, 'new_rate' => 460, 'limit_pct' => 5]),
            'stock_variance' => self::rule('Book stock does not match the count', 'high', 'store', 24, 'Post a variance only after the count is approved.', fn (array $f): bool => abs((float) ($f['book_qty'] ?? 0) - (float) ($f['physical_qty'] ?? 0)) > 0.01, ['book_qty' => 1000, 'physical_qty' => 970], ['book_qty' => 1000, 'physical_qty' => 1000]),
            'document_expiry' => self::rule('License or certificate is nearing expiry', 'medium', 'compliance', 72, 'Renew the document and upload the new copy.', fn (array $f): bool => (int) ($f['days_left'] ?? 999) <= (int) ($f['warn_days'] ?? 30), ['days_left' => 7, 'warn_days' => 30], ['days_left' => 120, 'warn_days' => 30]),
            'unrecorded_waste' => self::rule('Waste left the gate without a ledger entry', 'high', 'store', 4, 'Weigh the waste and post the ledger line before the gate pass.', fn (array $f): bool => (float) ($f['gate_kg'] ?? 0) > 0 && (float) ($f['ledger_kg'] ?? 0) + 0.01 < (float) $f['gate_kg'], ['gate_kg' => 40, 'ledger_kg' => 0], ['gate_kg' => 40, 'ledger_kg' => 40]),
            'month_end_open' => self::rule('Month is still open after the close date', 'medium', 'accounts', 24, 'Finish the closing checklist and lock the period.', fn (array $f): bool => (int) ($f['days_after_close'] ?? 0) >= 2 && ! ($f['locked'] ?? false), ['days_after_close' => 3, 'locked' => false], ['days_after_close' => 3, 'locked' => true]),
            'data_entry_lag' => self::rule('Floor data is still on paper', 'medium', 'production', 8, 'Enter the shift from the tablet or scan the roll tags.', fn (array $f): bool => (int) ($f['lag_hours'] ?? 0) > (int) ($f['limit'] ?? 8), ['lag_hours' => 20, 'limit' => 8], ['lag_hours' => 2, 'limit' => 8]),
            'buyer_status' => self::rule('Buyer milestone was missed', 'medium', 'merchandiser', 8, 'Update the T&A and send the buyer the current stage.', fn (array $f): bool => ($f['milestone_late'] ?? false) === true, ['milestone_late' => true], ['milestone_late' => false]),
            'management_digest' => self::rule('Open issues need a management digest', 'low', 'gm', 24, 'Review the Issues Today board and clear the red items first.', fn (array $f): bool => (int) ($f['open_issues'] ?? 0) > 0, ['open_issues' => 6], ['open_issues' => 0]),
        ];
    }

    /** @return list<string> */
    public static function keys(): array
    {
        return array_keys(self::all());
    }

    /**
     * @param  callable(array<string, mixed>): bool  $detect
     * @param  array<string, mixed>  $positive
     * @param  array<string, mixed>  $negative
     * @return array{title: string, severity: string, owner_role: string, sla_hours: int, solution: string, detect: callable, positive: array<string, mixed>, negative: array<string, mixed>}
     */
    private static function rule(string $title, string $severity, string $owner, int $sla, string $solution, callable $detect, array $positive, array $negative): array
    {
        return [
            'title' => $title,
            'severity' => $severity,
            'owner_role' => $owner,
            'sla_hours' => $sla,
            'solution' => $solution,
            'detect' => $detect,
            'positive' => $positive,
            'negative' => $negative,
        ];
    }
}
