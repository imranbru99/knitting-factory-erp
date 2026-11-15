# Issue rules

Each rule lives in `App\Modules\Operations\Services\IssueCatalog`. `IssueEngine::evaluate()` returns a hit or null. `raise()` stores one open issue per subject. `escalateOverdue()` steps `escalated_level` after `sla_due_at`.

| Key | Fires when |
|---|---|
| lot_mix | More than one yarn lot on a program and mix is not approved |
| yarn_over_bom | Issued kilograms exceed the BOM |
| yarn_shortage | On hand plus open PO is below the requirement |
| machine_idle | Idle minutes pass the limit (15) |
| wrong_machine | Dia, gauge, or type does not match |
| gsm_out | GSM is outside the fabric min and max |
| repeated_defect | The same defect reaches the count limit (3) |
| duplicate_roll | A roll number or barcode is already used |
| dye_short | Process loss is above the dyer tolerance |
| delivery_delay | The delivery date has passed and the order is not delivered |
| shipment_tolerance | Shipment variance is outside the order tolerance |
| receivable_overdue | A buyer balance is past due |
| three_way_mismatch | PO quantity, GRN quantity, or bill amount disagree |
| repeated_breakdown | Breakdown count reaches the limit (3) |
| spare_stockout | On hand is below the spare minimum |
| power_cost | Power cost per kilogram is above the limit |
| attendance_anomaly | Absent without approved leave |
| price_creep | The new rate is above the last rate by the limit percent |
| stock_variance | Book quantity and physical quantity differ |
| document_expiry | A license expires inside the warning window |
| unrecorded_waste | Gate kilograms exceed the waste ledger |
| month_end_open | The period is still open after the close date |
| data_entry_lag | Floor entry is older than the lag limit |
| buyer_status | A T&A milestone is late |
| management_digest | Any issue is still open for the daily note |

Thresholds can be changed on the Issue Rule screen. The stored rule supplies owner, severity, and SLA hours when a row exists.
