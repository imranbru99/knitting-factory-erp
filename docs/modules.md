# Modules

Each module has Filament resources under `app/Modules/<Module>/Filament` and tables from its migration. Staff reach them from `/admin`.

| Module | What it holds |
|---|---|
| Core | Company, unit, warehouse, roles, financial year, currency, tax, UOM, sequences, approvals, attachments, shifts, holidays |
| Masters | Parties, yarn, fabric, color, defect, process, machine brand, employees |
| Commercial | Inquiry, sample, costing, quotation, price list, sales order, BOM, milestones |
| Procurement | Requisition, RFQ, purchase order, GRN, yarn lot, LC, shipment, supplier bill |
| Knitting | Machine, program, production, roll, stoppage, needle log, grey inspection, subcontract |
| Inventory | Stock ledger, yarn issue, return, transfer, stock count, reorder rule |
| Dyeing | Lab dip, recipe, dye machine, batch, chemical issue, finishing, shade |
| Quality | Finished inspection, lab test, hold, CAPA, buyer claim, compliance document |
| Delivery | Packing list, challan, invoice, credit note, gate pass, vehicle, trip |
| Waste | Waste entry and waste sale |
| Maintenance | Asset, schedule, work order, spare, utility meter and reading |
| Human resources | Leave, attendance day, payroll, loan, incident, PPE, jobs, discipline |
| Accounts | Chart of accounts, journal, voucher, bank, budget, period lock |
| Operations | Issues, rules, tasks, notification dispatches, webhooks |
| Website | CMS pages, menus, posts, banners, FAQ, catalog, form submissions |

## Department notes

Merchandising starts at Inquiry and ends at the sales order and BOM. Store works GRN, yarn issue, and the stock ledger. Knitting works the program, roll entry, and stoppage log. QC works grey and finished inspection. Dyeing works the batch card. Accounts posts from GRN, issue, production, invoice, and collection. HR works attendance and payroll. The GM uses Issues Today.

`php artisan db:seed` loads Gazipur Knit and runs one reconciled order.
