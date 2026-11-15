# Architecture

The app is one Laravel 12 codebase. Business code lives under `app/Modules/<Module>` with its own models, policies, Filament resources, and migrations. Each module service provider loads those migrations.

`CompanyContext` limits queries to the signed-in company when the table has `company_id`. Documents that reach `approved`, `posted`, `closed`, or `delivered` cannot be edited. A reversal is a new document.

Stock and journal lines extend `AppendOnlyModel`. Balances are sums of the lines. `StockLedgerService` locks the current layers, refuses a negative balance, and ignores a repeated `movement_key`.

`DocumentNumberer` locks `document_sequences` and issues `PREFIX/FY/UNIT/00001`. The financial year starts on 1 July. `ApprovalEngine` uses an active workflow for the document type, or approves immediately when none is configured. A level can move forward when its timeout has passed.

`KnitCycle` is the demo path: sales order, BOM, purchase, GRN, yarn issue, rolls, grey inspection, dye batch, packing, challan, invoice, collection. Yarn, grey, and finished quantities return to zero, and the journals balance.

`IssueEngine` evaluates the 25 rules in `IssueCatalog`. A hit becomes an `issues` row with an owner role and an SLA. `Issues Today` lists the open rows.
