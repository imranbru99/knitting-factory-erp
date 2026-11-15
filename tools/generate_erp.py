#!/usr/bin/env python3
"""Generate knitting-factory module migrations, models, policies, and Filament resources."""

from __future__ import annotations

import os
from pathlib import Path
from textwrap import dedent

ROOT = Path(__file__).resolve().parents[1]


def F(name, type, **kw):
    return {"name": name, "type": type, **kw}


def fk(column, model, table, module, method=None, title="name", req=False):
    return {
        "name": column,
        "type": "fk",
        "model": model,
        "table": table,
        "module": module,
        "method": method or column.removesuffix("_id"),
        "title": title,
        "req": req,
    }


def E(module, name, table, fields, **kw):
    return {"module": module, "name": name, "table": table, "fields": fields, **kw}


GROUPS = {
    "Core": "Company",
    "Masters": "Masters",
    "Commercial": "Merchandising",
    "Procurement": "Procurement",
    "Inventory": "Yarn Store",
    "Knitting": "Knitting",
    "Dyeing": "Dyeing",
    "Quality": "Quality",
    "Delivery": "Delivery",
    "Waste": "Waste",
    "Maintenance": "Maintenance",
    "HumanResources": "HR & Payroll",
    "Accounts": "Accounts",
    "Operations": "Issues & Tasks",
    "Website": "Website",
}

MODULES = [
    "Core",
    "Masters",
    "Commercial",
    "Procurement",
    "Inventory",
    "Knitting",
    "Dyeing",
    "Quality",
    "Delivery",
    "Waste",
    "Maintenance",
    "HumanResources",
    "Accounts",
    "Operations",
    "Website",
]

ENTITIES = [
    E("Core", "Company", "companies", [
        F("code", "s", req=True, uniq=True), F("name", "s", req=True), F("name_bn", "s"),
        F("address", "t"), F("phone", "s"), F("email", "s"), F("vat_bin", "s"), F("tin", "s"),
        F("website", "s"), F("timezone", "s"), F("default_currency", "s"),
    ], company=False, title="name", search=["code", "name"]),
    E("Core", "Unit", "units", [
        fk("company_id", "Company", "companies", "Core", req=True),
        F("code", "s", req=True), F("name", "s", req=True),
        F("type", "e", options=["factory", "warehouse", "office", "dyeing"], req=True),
        F("address", "t"),
    ], title="name", search=["code", "name"]),
    E("Core", "Floor", "floors", [
        fk("unit_id", "Unit", "units", "Core", req=True),
        F("code", "s", req=True), F("name", "s", req=True),
    ], title="name"),
    E("Core", "Warehouse", "warehouses", [
        fk("unit_id", "Unit", "units", "Core", req=True),
        F("code", "s", req=True), F("name", "s", req=True),
        F("kind", "e", options=["yarn", "grey", "finished", "spare", "waste", "chemical"], req=True),
    ], title="name", search=["code", "name"]),
    E("Core", "Rack", "racks", [
        fk("warehouse_id", "Warehouse", "warehouses", "Core", req=True),
        F("code", "s", req=True),
    ], title="code"),
    E("Core", "Bin", "bins", [
        fk("rack_id", "Rack", "racks", "Core", req=True),
        F("code", "s", req=True),
    ], title="code"),
    E("Core", "Role", "roles", [
        fk("company_id", "Company", "companies", "Core"),
        F("name", "s", req=True), F("slug", "s", req=True), F("is_system", "b"),
    ], title="name"),
    E("Core", "Permission", "permissions", [
        F("name", "s", req=True, uniq=True), F("module", "s", req=True), F("description", "s"),
    ], company=False, title="name", search=["name", "module"]),
    E("Core", "FinancialYear", "financial_years", [
        F("name", "s", req=True), F("code", "s", req=True), F("starts_on", "date", req=True),
        F("ends_on", "date", req=True), F("is_current", "b"), F("is_locked", "b"),
    ], title="name"),
    E("Core", "Currency", "currencies", [
        F("code", "s", req=True, uniq=True), F("name", "s", req=True), F("symbol", "s"), F("decimal_places", "i"),
    ], company=False, title="code"),
    E("Core", "ExchangeRate", "exchange_rates", [
        F("currency_code", "s", req=True), F("rate_date", "date", req=True), F("rate_to_bdt", "qty", req=True),
    ], title="currency_code"),
    E("Core", "TaxRule", "tax_rules", [
        F("name", "s", req=True), F("kind", "e", options=["vat", "ait", "tds"], req=True),
        F("rate", "qty", req=True), F("applies_to", "s"),
    ], title="name"),
    E("Core", "Uom", "uoms", [
        F("code", "s", req=True, uniq=True), F("name", "s", req=True), F("family", "s"),
    ], company=False, title="code"),
    E("Core", "UomConversion", "uom_conversions", [
        fk("from_uom_id", "Uom", "uoms", "Core", method="fromUom", title="code", req=True),
        fk("to_uom_id", "Uom", "uoms", "Core", method="toUom", title="code", req=True),
        F("factor", "qty", req=True),
    ], company=False, title="id"),
    E("Core", "ModuleRecord", "modules", [
        F("key", "s", req=True, uniq=True), F("name", "s", req=True), F("description", "t"),
    ], company=False, title="name"),
    E("Core", "CompanyModule", "company_modules", [
        fk("company_id", "Company", "companies", "Core", req=True),
        F("module_key", "s", req=True), F("enabled", "b"),
    ], title="module_key"),
    E("Core", "Setting", "settings", [
        F("key", "s", req=True), F("value", "j"),
    ], title="key"),
    E("Core", "DocumentSequence", "document_sequences", [
        fk("unit_id", "Unit", "units", "Core"),
        F("doc_type", "s", req=True), F("prefix", "s", req=True), F("fy_code", "s"), F("last_number", "i"),
    ], title="doc_type"),
    E("Core", "ApprovalWorkflow", "approval_workflows", [
        F("doc_type", "s", req=True), F("name", "s", req=True), F("is_active", "b"),
    ], title="name"),
    E("Core", "ApprovalLevel", "approval_levels", [
        fk("approval_workflow_id", "ApprovalWorkflow", "approval_workflows", "Core", req=True),
        F("level", "i", req=True), F("role_slug", "s", req=True), F("timeout_hours", "i"),
    ], nav=False, title="role_slug"),
    E("Core", "ApprovalRequest", "approval_requests", [
        fk("approval_workflow_id", "ApprovalWorkflow", "approval_workflows", "Core"),
        F("approvable_type", "s", req=True), F("approvable_id", "i", req=True),
        F("status", "e", options=["pending", "approved", "rejected", "escalated"], req=True),
        F("current_level", "i"), F("submitted_by", "i"),
    ], title="id"),
    E("Core", "ApprovalActionRecord", "approval_actions", [
        fk("approval_request_id", "ApprovalRequest", "approval_requests", "Core", req=True),
        F("level", "i"), F("user_id", "i"), F("decision", "s"), F("comment", "t"), F("acted_at", "dt"),
    ], nav=False, title="id"),
    E("Core", "Attachment", "attachments", [
        F("attachable_type", "s", req=True), F("attachable_id", "i", req=True),
        F("disk", "s"), F("path", "s", req=True), F("original_name", "s"), F("version", "i"), F("expires_on", "date"),
    ], title="original_name"),
    E("Core", "Holiday", "holidays", [
        F("holiday_date", "date", req=True), F("name", "s", req=True), F("name_bn", "s"),
        F("kind", "e", options=["public", "factory", "friday"]),
    ], title="name"),
    E("Core", "Shift", "shifts", [
        F("name", "s", req=True), F("starts_at", "s", req=True), F("ends_at", "s", req=True),
        F("is_night", "b"), F("break_minutes", "i"),
    ], title="name"),
    E("Masters", "Department", "departments", [
        F("code", "s", req=True), F("name", "s", req=True),
    ], title="name"),
    E("Masters", "Party", "parties", [
        F("code", "s", req=True), F("name", "s", req=True), F("name_bn", "s"),
        F("party_type", "e", options=["buyer", "supplier", "subcontractor", "bank", "cf_agent", "transporter"], req=True),
        F("phone", "s"), F("email", "s"), F("address", "t"), F("credit_limit", "money"), F("credit_days", "i"),
        F("rating", "qty"), F("is_blacklisted", "b"), F("currency_code", "s"), F("vat_bin", "s"),
        F("documents_expire_on", "date"),
    ], title="name", search=["code", "name", "phone"]),
    E("Masters", "PartyContact", "party_contacts", [
        fk("party_id", "Party", "parties", "Masters", req=True),
        F("name", "s", req=True), F("phone", "s"), F("email", "s"), F("designation", "s"),
    ], nav=False, title="name"),
    E("Masters", "YarnCount", "yarn_counts", [
        F("system", "e", options=["Ne", "Nm", "Denier", "Dtex"], req=True),
        F("value", "s", req=True), F("label", "s", req=True),
    ], title="label"),
    E("Masters", "YarnType", "yarn_types", [
        F("name", "s", req=True), F("slug", "s", req=True),
    ], title="name"),
    E("Masters", "YarnItem", "yarn_items", [
        fk("yarn_count_id", "YarnCount", "yarn_counts", "Masters", title="label"),
        fk("yarn_type_id", "YarnType", "yarn_types", "Masters"),
        F("code", "s", req=True), F("name", "s", req=True), F("brand", "s"), F("composition", "s"),
        F("ply", "s"), F("twist", "s"), F("uom", "s"), F("reorder_level", "qty"), F("min_qty", "qty"),
        F("max_qty", "qty"), F("lead_time_days", "i"), F("last_rate", "money"),
    ], title="name", search=["code", "name", "brand"]),
    E("Masters", "FabricConstruction", "fabric_constructions", [
        F("name", "s", req=True), F("slug", "s", req=True),
        F("family", "e", options=["single_jersey", "lacoste", "pique", "rib", "interlock", "fleece", "terry", "french_terry", "waffle", "jacquard", "collar", "flat"], req=True),
    ], title="name"),
    E("Masters", "Color", "colors", [
        F("name", "s", req=True), F("pantone", "s"), F("buyer_code", "s"), F("hex", "s"),
    ], title="name"),
    E("Masters", "FabricItem", "fabric_items", [
        fk("fabric_construction_id", "FabricConstruction", "fabric_constructions", "Masters"),
        fk("color_id", "Color", "colors", "Masters"),
        F("code", "s", req=True), F("name", "s", req=True), F("gsm_target", "qty"), F("gsm_min", "qty"),
        F("gsm_max", "qty"), F("dia", "qty"), F("composition", "s"), F("gauge", "qty"),
        F("stitch_length", "qty"), F("uom", "s"),
    ], title="name", search=["code", "name"]),
    E("Masters", "ShadeBand", "shade_bands", [
        F("name", "s", req=True), F("delta_e_max", "qty"),
    ], title="name"),
    E("Masters", "Defect", "defects", [
        F("code", "s", req=True), F("name", "s", req=True), F("process", "s"), F("points", "i"),
    ], title="name"),
    E("Masters", "Process", "processes", [
        F("name", "s", req=True), F("stage", "s", req=True),
    ], title="name"),
    E("Masters", "MachineBrand", "machine_brands", [
        F("name", "s", req=True),
    ], title="name"),
    E("Masters", "Employee", "employees", [
        fk("department_id", "Department", "departments", "Masters"),
        fk("shift_id", "Shift", "shifts", "Core"),
        F("code", "s", req=True), F("name", "s", req=True), F("name_bn", "s"), F("designation", "s"),
        F("grade", "s"), F("employment_type", "e", options=["permanent", "contract", "piece_rate", "daily"]),
        F("phone", "s"), F("joining_date", "date"), F("basic_salary", "money"), F("is_operator", "b"),
        F("biometric_uid", "s"), F("status", "e", options=["active", "left", "suspended"]),
    ], title="name", search=["code", "name"]),
    E("Commercial", "Inquiry", "inquiries", [
        fk("party_id", "Party", "parties", "Masters"),
        fk("fabric_item_id", "FabricItem", "fabric_items", "Masters"),
        F("number", "s"), F("subject", "s", req=True), F("qty_kg", "qty"), F("target_date", "date"),
        F("status", "e", options=["open", "quoted", "won", "lost"]), F("source", "s"), F("notes", "t"),
    ], doc="INQ", title="number", search=["number", "subject"]),
    E("Commercial", "Sample", "samples", [
        fk("inquiry_id", "Inquiry", "inquiries", "Commercial", title="number"),
        F("kind", "e", options=["swatch", "lab_dip", "hanger"], req=True),
        F("status", "e", options=["pending", "submitted", "approved", "rejected"]),
        F("comments", "t"), F("approved_on", "date"),
    ], title="kind"),
    E("Commercial", "CostSheet", "cost_sheets", [
        fk("party_id", "Party", "parties", "Masters"),
        fk("fabric_item_id", "FabricItem", "fabric_items", "Masters"),
        F("number", "s"), F("yarn_rate", "money"), F("knitting_charge", "money"), F("dyeing_charge", "money"),
        F("process_loss_pct", "qty"), F("wastage_pct", "qty"), F("overhead_pct", "qty"),
        F("finance_pct", "qty"), F("profit_pct", "qty"), F("cost_per_kg", "money"),
        F("cost_per_yard", "money"), F("quoted_rate", "money"),
        F("status", "e", options=["draft", "approved", "rejected"]),
    ], doc="CST", title="number"),
    E("Commercial", "CostSheetLine", "cost_sheet_lines", [
        fk("cost_sheet_id", "CostSheet", "cost_sheets", "Commercial", title="number", req=True),
        F("component", "s", req=True), F("amount", "money"),
    ], nav=False, title="component"),
    E("Commercial", "Quotation", "quotations", [
        fk("party_id", "Party", "parties", "Masters", req=True),
        fk("cost_sheet_id", "CostSheet", "cost_sheets", "Commercial", title="number"),
        F("number", "s"), F("status", "e", options=["draft", "submitted", "approved", "rejected", "converted"]),
        F("valid_until", "date"), F("currency_code", "s"), F("notes", "t"),
    ], doc="QT", title="number", lines="QuotationLine"),
    E("Commercial", "QuotationLine", "quotation_lines", [
        fk("quotation_id", "Quotation", "quotations", "Commercial", title="number", req=True),
        fk("fabric_item_id", "FabricItem", "fabric_items", "Masters"),
        fk("color_id", "Color", "colors", "Masters"),
        F("qty", "qty"), F("rate", "money"), F("uom", "s"),
    ], nav=False, title="id"),
    E("Commercial", "PriceList", "price_lists", [
        fk("party_id", "Party", "parties", "Masters"),
        F("name", "s", req=True), F("currency_code", "s"),
    ], title="name", lines="PriceListItem"),
    E("Commercial", "PriceListItem", "price_list_items", [
        fk("price_list_id", "PriceList", "price_lists", "Commercial", req=True),
        fk("fabric_item_id", "FabricItem", "fabric_items", "Masters"),
        F("rate", "money"), F("uom", "s"),
    ], nav=False, title="id"),
    E("Commercial", "SalesOrder", "sales_orders", [
        fk("party_id", "Party", "parties", "Masters", req=True),
        fk("unit_id", "Unit", "units", "Core"),
        fk("inquiry_id", "Inquiry", "inquiries", "Commercial", title="number"),
        F("number", "s"), F("buyer_po", "s"), F("order_date", "date"), F("delivery_date", "date"),
        F("currency_code", "s"), F("shipment_terms", "s"), F("tolerance_pct", "qty"),
        F("yarn_source", "e", options=["own", "buyer", "mixed"]),
        F("status", "e", options=["draft", "approved", "in_production", "closed", "cancelled"]),
        F("notes", "t"),
    ], doc="SO", title="number", search=["number", "buyer_po"], lines="SalesOrderLine"),
    E("Commercial", "SalesOrderLine", "sales_order_lines", [
        fk("sales_order_id", "SalesOrder", "sales_orders", "Commercial", title="number", req=True),
        fk("fabric_item_id", "FabricItem", "fabric_items", "Masters"),
        fk("color_id", "Color", "colors", "Masters"),
        F("gsm", "qty"), F("dia", "qty"), F("qty_kg", "qty"), F("qty_yd", "qty"), F("rate", "money"),
        F("delivery_date", "date"),
    ], nav=False, title="id"),
    E("Commercial", "Bom", "boms", [
        fk("sales_order_id", "SalesOrder", "sales_orders", "Commercial", title="number", req=True),
        fk("fabric_item_id", "FabricItem", "fabric_items", "Masters"),
        F("number", "s"), F("process_loss_pct", "qty"), F("wastage_pct", "qty"),
        F("status", "e", options=["draft", "approved"]),
    ], doc="BOM", title="number", lines="BomLine"),
    E("Commercial", "BomLine", "bom_lines", [
        fk("bom_id", "Bom", "boms", "Commercial", title="number", req=True),
        fk("yarn_item_id", "YarnItem", "yarn_items", "Masters"),
        F("ratio_pct", "qty"), F("requirement_kg", "qty"), F("is_lycra", "b"),
    ], nav=False, title="id"),
    E("Commercial", "OrderMilestone", "order_milestones", [
        fk("sales_order_id", "SalesOrder", "sales_orders", "Commercial", title="number", req=True),
        F("name", "s", req=True), F("planned_on", "date"), F("actual_on", "date"),
        F("status", "e", options=["pending", "done", "late"]),
    ], title="name"),
    E("Commercial", "OrderAmendment", "order_amendments", [
        fk("sales_order_id", "SalesOrder", "sales_orders", "Commercial", title="number", req=True),
        F("reason", "t", req=True), F("changes", "j"), F("revised_delivery", "date"),
    ], title="id"),
    E("Procurement", "Requisition", "requisitions", [
        F("number", "s"), F("source", "s"), F("needed_on", "date"),
        F("status", "e", options=["draft", "submitted", "approved", "rejected", "ordered"]),
        F("notes", "t"),
    ], doc="REQ", title="number", lines="RequisitionLine"),
    E("Procurement", "RequisitionLine", "requisition_lines", [
        fk("requisition_id", "Requisition", "requisitions", "Procurement", title="number", req=True),
        fk("yarn_item_id", "YarnItem", "yarn_items", "Masters"),
        F("qty", "qty"), F("uom", "s"),
    ], nav=False, title="id"),
    E("Procurement", "Rfq", "rfqs", [
        fk("requisition_id", "Requisition", "requisitions", "Procurement", title="number"),
        F("number", "s"), F("status", "e", options=["draft", "sent", "compared", "awarded"]),
        F("due_on", "date"),
    ], doc="RFQ", title="number", lines="RfqLine"),
    E("Procurement", "RfqLine", "rfq_lines", [
        fk("rfq_id", "Rfq", "rfqs", "Procurement", title="number", req=True),
        fk("yarn_item_id", "YarnItem", "yarn_items", "Masters"),
        F("qty", "qty"),
    ], nav=False, title="id"),
    E("Procurement", "RfqQuote", "rfq_quotes", [
        fk("rfq_id", "Rfq", "rfqs", "Procurement", title="number", req=True),
        fk("party_id", "Party", "parties", "Masters", req=True),
        fk("yarn_item_id", "YarnItem", "yarn_items", "Masters"),
        F("rate", "money"), F("lead_days", "i"), F("score", "qty"),
    ], title="id"),
    E("Procurement", "PurchaseOrder", "purchase_orders", [
        fk("party_id", "Party", "parties", "Masters", req=True),
        fk("requisition_id", "Requisition", "requisitions", "Procurement", title="number"),
        F("number", "s"), F("status", "e", options=["draft", "submitted", "approved", "partial", "received", "cancelled"]),
        F("currency_code", "s"), F("order_date", "date"), F("expected_on", "date"), F("notes", "t"),
    ], doc="PO", title="number", search=["number"], lines="PurchaseOrderLine"),
    E("Procurement", "PurchaseOrderLine", "purchase_order_lines", [
        fk("purchase_order_id", "PurchaseOrder", "purchase_orders", "Procurement", title="number", req=True),
        fk("yarn_item_id", "YarnItem", "yarn_items", "Masters", req=True),
        F("qty", "qty"), F("rate", "money"), F("received_qty", "qty"),
    ], nav=False, title="id"),
    E("Procurement", "GoodsReceipt", "goods_receipts", [
        fk("purchase_order_id", "PurchaseOrder", "purchase_orders", "Procurement", title="number"),
        fk("party_id", "Party", "parties", "Masters"),
        fk("warehouse_id", "Warehouse", "warehouses", "Core", req=True),
        F("number", "s"), F("challan_no", "s"), F("received_on", "date"),
        F("status", "e", options=["draft", "approved"]), F("notes", "t"),
    ], doc="GRN", title="number", lines="GoodsReceiptLine"),
    E("Procurement", "GoodsReceiptLine", "goods_receipt_lines", [
        fk("goods_receipt_id", "GoodsReceipt", "goods_receipts", "Procurement", title="number", req=True),
        fk("purchase_order_line_id", "PurchaseOrderLine", "purchase_order_lines", "Procurement", title="id"),
        fk("yarn_item_id", "YarnItem", "yarn_items", "Masters", req=True),
        F("lot_no", "s", req=True), F("bags", "i"), F("cones", "i"),
        F("challan_weight", "qty"), F("actual_weight", "qty"), F("shortage", "qty"),
        F("qc_status", "e", options=["pending", "pass", "hold", "reject"]),
    ], nav=False, title="lot_no"),
    E("Procurement", "YarnLot", "yarn_lots", [
        fk("yarn_item_id", "YarnItem", "yarn_items", "Masters", req=True),
        fk("party_id", "Party", "parties", "Masters"),
        fk("warehouse_id", "Warehouse", "warehouses", "Core"),
        F("lot_no", "s", req=True), F("received_on", "date"),
        F("qc_status", "e", options=["pending", "pass", "hold", "reject"]),
        F("count_actual", "s"), F("csp", "qty"), F("u_percent", "qty"), F("moisture", "qty"),
        F("shade_note", "t"), F("barcode", "s"), F("net_kg", "qty"),
    ], title="lot_no", search=["lot_no", "barcode"]),
    E("Procurement", "ImportLc", "import_lcs", [
        fk("party_id", "Party", "parties", "Masters"),
        F("number", "s", req=True), F("kind", "e", options=["lc", "btb", "upas", "bond"]),
        F("currency_code", "s"), F("amount", "money"), F("margin", "money"),
        F("maturity_on", "date"), F("status", "e", options=["open", "accepted", "matured", "settled"]),
    ], title="number"),
    E("Procurement", "Shipment", "shipments", [
        fk("import_lc_id", "ImportLc", "import_lcs", "Procurement", title="number"),
        F("bl_no", "s"), F("eta", "date"), F("duty", "money"), F("freight", "money"), F("landed_cost", "money"),
    ], title="bl_no"),
    E("Procurement", "SupplierBill", "supplier_bills", [
        fk("party_id", "Party", "parties", "Masters", req=True),
        fk("purchase_order_id", "PurchaseOrder", "purchase_orders", "Procurement", title="number"),
        fk("goods_receipt_id", "GoodsReceipt", "goods_receipts", "Procurement", title="number"),
        F("number", "s"), F("amount", "money"), F("status", "e", options=["draft", "matched", "mismatch", "posted"]),
        F("match_status", "s"), F("notes", "t"),
    ], doc="BILL", title="number", lines="SupplierBillLine"),
    E("Procurement", "SupplierBillLine", "supplier_bill_lines", [
        fk("supplier_bill_id", "SupplierBill", "supplier_bills", "Procurement", title="number", req=True),
        F("description", "s"), F("qty", "qty"), F("amount", "money"),
    ], nav=False, title="description"),
    E("Procurement", "DebitNote", "debit_notes", [
        fk("party_id", "Party", "parties", "Masters", req=True),
        fk("supplier_bill_id", "SupplierBill", "supplier_bills", "Procurement", title="number"),
        F("number", "s"), F("amount", "money"), F("reason", "t"),
        F("status", "e", options=["draft", "approved"]),
    ], doc="DN", title="number"),
    E("Inventory", "StockLedger", "stock_ledgers", [
        fk("warehouse_id", "Warehouse", "warehouses", "Core", req=True),
        fk("unit_id", "Unit", "units", "Core"),
        F("stock_type", "s", req=True), F("item_id", "i", req=True), F("lot_id", "i"),
        F("qty_in", "qty"), F("qty_out", "qty"), F("balance_qty", "qty"), F("rate", "money"),
        F("amount", "money"), F("ref_type", "s"), F("ref_id", "i"), F("movement_key", "s"),
        F("moved_at", "dt"),
    ], append=True, readonly=True, title="id", search=["stock_type", "movement_key"]),
    E("Inventory", "YarnIssue", "yarn_issues", [
        fk("knitting_program_id", "KnittingProgram", "knitting_programs", "Knitting", title="number"),
        fk("warehouse_id", "Warehouse", "warehouses", "Core", req=True),
        F("number", "s"), F("issued_on", "date"),
        F("status", "e", options=["draft", "approved"]), F("notes", "t"),
    ], doc="YIS", title="number", lines="YarnIssueLine"),
    E("Inventory", "YarnIssueLine", "yarn_issue_lines", [
        fk("yarn_issue_id", "YarnIssue", "yarn_issues", "Inventory", title="number", req=True),
        fk("yarn_lot_id", "YarnLot", "yarn_lots", "Procurement", title="lot_no", req=True),
        fk("yarn_item_id", "YarnItem", "yarn_items", "Masters"),
        F("qty", "qty"), F("approved_mix", "b"),
    ], nav=False, title="id"),
    E("Inventory", "YarnReturn", "yarn_returns", [
        fk("yarn_issue_id", "YarnIssue", "yarn_issues", "Inventory", title="number"),
        fk("yarn_lot_id", "YarnLot", "yarn_lots", "Procurement", title="lot_no", req=True),
        fk("warehouse_id", "Warehouse", "warehouses", "Core", req=True),
        F("number", "s"), F("qty", "qty", req=True), F("reason", "s"),
        F("status", "e", options=["draft", "approved"]),
    ], doc="YRT", title="number"),
    E("Inventory", "YarnTransfer", "yarn_transfers", [
        fk("from_sales_order_id", "SalesOrder", "sales_orders", "Commercial", method="fromOrder", title="number"),
        fk("to_sales_order_id", "SalesOrder", "sales_orders", "Commercial", method="toOrder", title="number"),
        fk("yarn_lot_id", "YarnLot", "yarn_lots", "Procurement", title="lot_no", req=True),
        F("number", "s"), F("qty", "qty"), F("status", "e", options=["draft", "approved", "rejected"]),
    ], doc="YTR", title="number"),
    E("Inventory", "StockCount", "stock_counts", [
        fk("warehouse_id", "Warehouse", "warehouses", "Core", req=True),
        F("number", "s"), F("counted_on", "date"),
        F("status", "e", options=["draft", "approved"]),
    ], doc="SC", title="number", lines="StockCountLine"),
    E("Inventory", "StockCountLine", "stock_count_lines", [
        fk("stock_count_id", "StockCount", "stock_counts", "Inventory", title="number", req=True),
        F("stock_type", "s"), F("item_id", "i"), F("lot_id", "i"),
        F("book_qty", "qty"), F("physical_qty", "qty"), F("variance", "qty"),
    ], nav=False, title="id"),
    E("Inventory", "ReorderRule", "reorder_rules", [
        fk("yarn_item_id", "YarnItem", "yarn_items", "Masters", req=True),
        F("min_qty", "qty"), F("max_qty", "qty"), F("lead_days", "i"),
    ], title="id"),
    E("Knitting", "Machine", "machines", [
        fk("unit_id", "Unit", "units", "Core"),
        fk("floor_id", "Floor", "floors", "Core"),
        fk("machine_brand_id", "MachineBrand", "machine_brands", "Masters"),
        F("code", "s", req=True), F("name", "s", req=True),
        F("machine_type", "e", options=["single_jersey", "double_jersey", "rib", "fleece", "jacquard", "terry", "flat", "collar"], req=True),
        F("dia", "qty"), F("gauge", "qty"), F("feeders", "i"), F("rpm", "qty"),
        F("capacity_kg_shift", "qty"), F("status", "e", options=["idle", "running", "setup", "down"]),
        F("installed_on", "date"),
    ], title="code", search=["code", "name"]),
    E("Knitting", "KnittingProgram", "knitting_programs", [
        fk("sales_order_id", "SalesOrder", "sales_orders", "Commercial", title="number"),
        fk("sales_order_line_id", "SalesOrderLine", "sales_order_lines", "Commercial", title="id"),
        fk("machine_id", "Machine", "machines", "Knitting", title="code"),
        fk("fabric_item_id", "FabricItem", "fabric_items", "Masters"),
        fk("color_id", "Color", "colors", "Masters"),
        fk("operator_id", "Employee", "employees", "Masters", method="operator"),
        F("number", "s"), F("target_kg", "qty"), F("target_gsm", "qty"), F("stitch_length", "qty"),
        F("dia", "qty"), F("status", "e", options=["planned", "running", "done", "cancelled"]),
        F("planned_start", "dt"), F("planned_end", "dt"), F("special_instruction", "t"),
    ], doc="KP", title="number", lines="KnittingProgramYarn"),
    E("Knitting", "KnittingProgramYarn", "knitting_program_yarns", [
        fk("knitting_program_id", "KnittingProgram", "knitting_programs", "Knitting", title="number", req=True),
        fk("yarn_lot_id", "YarnLot", "yarn_lots", "Procurement", title="lot_no"),
        fk("yarn_item_id", "YarnItem", "yarn_items", "Masters"),
        F("ratio_pct", "qty"),
    ], nav=False, title="id"),
    E("Knitting", "ProductionEntry", "production_entries", [
        fk("machine_id", "Machine", "machines", "Knitting", title="code", req=True),
        fk("shift_id", "Shift", "shifts", "Core"),
        fk("operator_id", "Employee", "employees", "Masters", method="operator"),
        fk("knitting_program_id", "KnittingProgram", "knitting_programs", "Knitting", title="number"),
        F("started_at", "dt"), F("ended_at", "dt"), F("produced_kg", "qty"), F("rpm_actual", "qty"),
        F("note", "t"),
    ], title="id"),
    E("Knitting", "Roll", "rolls", [
        fk("knitting_program_id", "KnittingProgram", "knitting_programs", "Knitting", title="number"),
        fk("machine_id", "Machine", "machines", "Knitting", title="code"),
        fk("warehouse_id", "Warehouse", "warehouses", "Core"),
        fk("sales_order_id", "SalesOrder", "sales_orders", "Commercial", title="number"),
        F("number", "s"), F("barcode", "s"), F("gross_kg", "qty"), F("net_kg", "qty"),
        F("gsm", "qty"), F("dia", "qty"), F("yards", "qty"),
        F("grade", "s"), F("stage", "e", options=["grey", "inspected", "issued_dye", "finished", "packed", "delivered", "rejected", "hold"]),
        F("yarn_lots", "j"), F("produced_at", "dt"),
    ], doc="ROLL", title="number", search=["number", "barcode"]),
    E("Knitting", "MachineStoppage", "machine_stoppages", [
        fk("machine_id", "Machine", "machines", "Knitting", title="code", req=True),
        fk("operator_id", "Employee", "employees", "Masters", method="operator"),
        F("reason", "e", options=["yarn_break", "needle_break", "lycra_break", "power", "no_yarn", "no_operator", "mechanical", "electrical", "program_change", "cleaning", "lunch"], req=True),
        F("started_at", "dt", req=True), F("ended_at", "dt"), F("minutes", "i"),
    ], title="reason"),
    E("Knitting", "NeedleLog", "needle_logs", [
        fk("machine_id", "Machine", "machines", "Knitting", title="code", req=True),
        F("kind", "s", req=True), F("qty", "i"), F("changed_on", "date"), F("reason", "s"),
    ], title="kind"),
    E("Knitting", "GreyInspection", "grey_inspections", [
        fk("roll_id", "Roll", "rolls", "Knitting", title="number", req=True),
        fk("inspector_id", "Employee", "employees", "Masters", method="inspector"),
        F("gsm", "qty"), F("dia", "qty"), F("points", "qty"), F("grade", "s"),
        F("length_m", "qty"), F("status", "e", options=["draft", "released", "hold"]),
    ], title="grade", lines="GreyInspectionDefect"),
    E("Knitting", "GreyInspectionDefect", "grey_inspection_defects", [
        fk("grey_inspection_id", "GreyInspection", "grey_inspections", "Knitting", title="id", req=True),
        fk("defect_id", "Defect", "defects", "Masters"),
        F("position_m", "qty"), F("points", "i"),
    ], nav=False, title="id"),
    E("Knitting", "SubcontractJob", "subcontract_jobs", [
        fk("party_id", "Party", "parties", "Masters", req=True),
        fk("sales_order_id", "SalesOrder", "sales_orders", "Commercial", title="number"),
        F("number", "s"), F("direction", "e", options=["out", "in"], req=True),
        F("yarn_sent_kg", "qty"), F("rolls_received_kg", "qty"), F("charge_per_kg", "money"),
        F("status", "e", options=["draft", "sent", "received", "closed"]),
    ], doc="SUB", title="number"),
    E("Dyeing", "LabDip", "lab_dips", [
        fk("party_id", "Party", "parties", "Masters"),
        fk("fabric_item_id", "FabricItem", "fabric_items", "Masters"),
        fk("color_id", "Color", "colors", "Masters"),
        F("number", "s"), F("status", "e", options=["requested", "submitted", "approved", "rejected"]),
        F("comments", "t"),
    ], doc="LD", title="number"),
    E("Dyeing", "Recipe", "recipes", [
        fk("color_id", "Color", "colors", "Masters"),
        fk("fabric_item_id", "FabricItem", "fabric_items", "Masters"),
        F("name", "s", req=True), F("liquor_ratio", "qty"), F("cost_per_kg", "money"),
    ], title="name", lines="RecipeLine"),
    E("Dyeing", "RecipeLine", "recipe_lines", [
        fk("recipe_id", "Recipe", "recipes", "Dyeing", req=True),
        F("chemical_name", "s", req=True), F("gpl", "qty"), F("cost", "money"),
    ], nav=False, title="chemical_name"),
    E("Dyeing", "DyeMachine", "dye_machines", [
        F("code", "s", req=True), F("brand", "s"), F("capacity_kg", "qty"),
        F("status", "e", options=["idle", "running", "down"]),
    ], title="code"),
    E("Dyeing", "DyeBatch", "dye_batches", [
        fk("dye_machine_id", "DyeMachine", "dye_machines", "Dyeing", title="code"),
        fk("recipe_id", "Recipe", "recipes", "Dyeing"),
        fk("color_id", "Color", "colors", "Masters"),
        fk("party_id", "Party", "parties", "Masters"),
        F("number", "s"), F("input_kg", "qty"), F("output_kg", "qty"), F("process_loss_pct", "qty"),
        F("shade_de", "qty"), F("status", "e", options=["planned", "running", "finished", "hold"]),
        F("is_subcontract", "b"),
    ], doc="BAT", title="number"),
    E("Dyeing", "DyeBatchRoll", "dye_batch_rolls", [
        fk("dye_batch_id", "DyeBatch", "dye_batches", "Dyeing", title="number", req=True),
        fk("roll_id", "Roll", "rolls", "Knitting", title="number", req=True),
        F("kg", "qty"),
    ], nav=False, title="id"),
    E("Dyeing", "ChemicalIssue", "chemical_issues", [
        fk("dye_batch_id", "DyeBatch", "dye_batches", "Dyeing", title="number", req=True),
        F("chemical_name", "s", req=True), F("qty", "qty"), F("recipe_qty", "qty"),
    ], title="chemical_name"),
    E("Dyeing", "FinishingLog", "finishing_logs", [
        fk("dye_batch_id", "DyeBatch", "dye_batches", "Dyeing", title="number", req=True),
        F("process", "s", req=True), F("machine_name", "s"), F("gsm_after", "qty"), F("dia_after", "qty"),
        F("shrinkage_l", "qty"), F("shrinkage_w", "qty"), F("done_at", "dt"),
    ], title="process"),
    E("Dyeing", "ShadeMatch", "shade_matches", [
        fk("dye_batch_id", "DyeBatch", "dye_batches", "Dyeing", title="number", req=True),
        F("l_star", "qty"), F("a_star", "qty"), F("b_star", "qty"), F("delta_e", "qty"), F("approved", "b"),
    ], title="id"),
    E("Quality", "FinishedInspection", "finished_inspections", [
        fk("roll_id", "Roll", "rolls", "Knitting", title="number", req=True),
        F("points_per_100", "qty"), F("grade", "s"), F("length_yd", "qty"), F("width_in", "qty"),
        F("status", "e", options=["draft", "released", "hold"]),
    ], title="grade", lines="FinishedInspectionDefect"),
    E("Quality", "FinishedInspectionDefect", "finished_inspection_defects", [
        fk("finished_inspection_id", "FinishedInspection", "finished_inspections", "Quality", title="id", req=True),
        fk("defect_id", "Defect", "defects", "Masters"),
        F("position_m", "qty"), F("points", "i"),
    ], nav=False, title="id"),
    E("Quality", "LabTest", "lab_tests", [
        fk("roll_id", "Roll", "rolls", "Knitting", title="number"),
        fk("dye_batch_id", "DyeBatch", "dye_batches", "Dyeing", title="number"),
        F("test_name", "s", req=True), F("standard", "s"), F("result_value", "s"), F("unit", "s"),
        F("passed", "b"),
    ], title="test_name"),
    E("Quality", "QcHold", "qc_holds", [
        F("holdable_type", "s", req=True), F("holdable_id", "i", req=True),
        F("reason", "t", req=True), F("status", "e", options=["hold", "released"]),
    ], title="id"),
    E("Quality", "Capa", "capas", [
        fk("owner_id", "Employee", "employees", "Masters", method="owner"),
        F("number", "s"), F("source", "s"), F("due_on", "date"), F("root_cause", "t"),
        F("action", "t"), F("status", "e", options=["open", "verified", "closed"]),
    ], doc="CAPA", title="number"),
    E("Quality", "BuyerClaim", "buyer_claims", [
        fk("party_id", "Party", "parties", "Masters", req=True),
        fk("sales_order_id", "SalesOrder", "sales_orders", "Commercial", title="number"),
        F("number", "s"), F("amount", "money"), F("status", "e", options=["open", "accepted", "rejected", "recovered"]),
        F("root_cause", "t"),
    ], doc="CLM", title="number"),
    E("Quality", "ComplianceDocument", "compliance_documents", [
        F("name", "s", req=True), F("kind", "s", req=True), F("expires_on", "date"), F("file_path", "s"),
    ], title="name"),
    E("Delivery", "PackingList", "packing_lists", [
        fk("sales_order_id", "SalesOrder", "sales_orders", "Commercial", title="number", req=True),
        F("number", "s"), F("net_kg", "qty"), F("gross_kg", "qty"), F("yards", "qty"),
        F("status", "e", options=["draft", "approved"]),
    ], doc="PL", title="number", lines="PackingListLine"),
    E("Delivery", "PackingListLine", "packing_list_lines", [
        fk("packing_list_id", "PackingList", "packing_lists", "Delivery", title="number", req=True),
        fk("roll_id", "Roll", "rolls", "Knitting", title="number", req=True),
        F("net_kg", "qty"), F("yards", "qty"),
    ], nav=False, title="id"),
    E("Delivery", "DeliveryChallan", "delivery_challans", [
        fk("packing_list_id", "PackingList", "packing_lists", "Delivery", title="number"),
        fk("party_id", "Party", "parties", "Masters", req=True),
        F("number", "s"), F("vehicle_no", "s"), F("driver", "s"), F("mushak", "s"),
        F("status", "e", options=["draft", "approved", "delivered"]),
    ], doc="DC", title="number", lines="DeliveryChallanLine"),
    E("Delivery", "DeliveryChallanLine", "delivery_challan_lines", [
        fk("delivery_challan_id", "DeliveryChallan", "delivery_challans", "Delivery", title="number", req=True),
        fk("roll_id", "Roll", "rolls", "Knitting", title="number", req=True),
        F("kg", "qty"),
    ], nav=False, title="id"),
    E("Delivery", "SalesInvoice", "sales_invoices", [
        fk("delivery_challan_id", "DeliveryChallan", "delivery_challans", "Delivery", title="number"),
        fk("party_id", "Party", "parties", "Masters", req=True),
        F("number", "s"), F("subtotal", "money"), F("vat", "money"), F("total", "money"),
        F("currency_code", "s"), F("invoice_date", "date"), F("due_date", "date"),
        F("status", "e", options=["draft", "posted", "paid", "partial"]),
    ], doc="INV", title="number", lines="SalesInvoiceLine"),
    E("Delivery", "SalesInvoiceLine", "sales_invoice_lines", [
        fk("sales_invoice_id", "SalesInvoice", "sales_invoices", "Delivery", title="number", req=True),
        F("description", "s"), F("qty", "qty"), F("rate", "money"), F("amount", "money"),
    ], nav=False, title="description"),
    E("Delivery", "CreditNote", "credit_notes", [
        fk("sales_invoice_id", "SalesInvoice", "sales_invoices", "Delivery", title="number"),
        F("number", "s"), F("amount", "money"), F("reason", "t"),
        F("status", "e", options=["draft", "approved"]),
    ], doc="CN", title="number"),
    E("Delivery", "GatePass", "gate_passes", [
        F("number", "s"), F("direction", "e", options=["in", "out"], req=True),
        F("ref_type", "s"), F("ref_id", "i"), F("vehicle_no", "s"),
        F("status", "e", options=["draft", "approved", "verified"]), F("verified_at", "dt"),
    ], doc="GP", title="number"),
    E("Delivery", "GateLog", "gate_logs", [
        F("kind", "e", options=["visitor", "vehicle", "material", "worker"], req=True),
        F("name", "s", req=True), F("purpose", "s"), F("in_at", "dt"), F("out_at", "dt"),
    ], title="name"),
    E("Delivery", "Vehicle", "vehicles", [
        fk("transporter_id", "Party", "parties", "Masters", method="transporter"),
        F("number", "s", req=True), F("capacity_kg", "qty"),
    ], title="number"),
    E("Delivery", "Trip", "trips", [
        fk("vehicle_id", "Vehicle", "vehicles", "Delivery", title="number"),
        fk("delivery_challan_id", "DeliveryChallan", "delivery_challans", "Delivery", title="number"),
        F("fuel_cost", "money"), F("started_on", "date"), F("note", "t"),
    ], title="id"),
    E("Waste", "WasteEntry", "waste_entries", [
        fk("sales_order_id", "SalesOrder", "sales_orders", "Commercial", title="number"),
        fk("machine_id", "Machine", "machines", "Knitting", title="code"),
        fk("warehouse_id", "Warehouse", "warehouses", "Core"),
        F("number", "s"), F("kind", "e", options=["yarn", "fabric", "cut_piece", "lycra", "packing"], req=True),
        F("qty_kg", "qty"), F("rate", "money"), F("value", "money"),
        F("status", "e", options=["draft", "approved"]),
    ], doc="WST", title="number"),
    E("Waste", "WasteSale", "waste_sales", [
        fk("party_id", "Party", "parties", "Masters", req=True),
        fk("gate_pass_id", "GatePass", "gate_passes", "Delivery", title="number"),
        F("number", "s"), F("qty_kg", "qty"), F("amount", "money"),
        F("status", "e", options=["draft", "approved"]),
    ], doc="WSL", title="number"),
    E("Maintenance", "Asset", "assets", [
        fk("machine_id", "Machine", "machines", "Knitting", title="code"),
        F("code", "s", req=True), F("name", "s", req=True), F("category", "s", req=True),
        F("cost", "money"), F("installed_on", "date"), F("life_years", "i"),
    ], title="name", search=["code", "name"]),
    E("Maintenance", "MaintenanceSchedule", "maintenance_schedules", [
        fk("asset_id", "Asset", "assets", "Maintenance", req=True),
        F("every_hours", "i"), F("every_days", "i"), F("last_done_on", "date"), F("next_due_on", "date"),
    ], title="id"),
    E("Maintenance", "WorkOrder", "work_orders", [
        fk("asset_id", "Asset", "assets", "Maintenance"),
        fk("machine_id", "Machine", "machines", "Knitting", title="code"),
        F("number", "s"), F("kind", "e", options=["pm", "breakdown"], req=True),
        F("priority", "e", options=["low", "normal", "high", "critical"]),
        F("status", "e", options=["open", "in_progress", "closed"]),
        F("opened_at", "dt"), F("closed_at", "dt"), F("cost", "money"), F("downtime_minutes", "i"),
        F("description", "t"),
    ], doc="WO", title="number"),
    E("Maintenance", "SparePart", "spare_parts", [
        F("code", "s", req=True), F("name", "s", req=True), F("gauge", "s"),
        F("min_qty", "qty"), F("max_qty", "qty"), F("rate", "money"),
    ], title="name", search=["code", "name"]),
    E("Maintenance", "UtilityMeter", "utility_meters", [
        F("kind", "e", options=["power", "gas", "water", "steam", "fuel"], req=True),
        F("name", "s", req=True),
    ], title="name"),
    E("Maintenance", "UtilityReading", "utility_readings", [
        fk("utility_meter_id", "UtilityMeter", "utility_meters", "Maintenance", req=True),
        fk("shift_id", "Shift", "shifts", "Core"),
        F("read_on", "date", req=True), F("reading", "qty"), F("consumption", "qty"),
        F("cost", "money"), F("production_kg", "qty"),
    ], title="id"),
    E("HumanResources", "LeaveType", "leave_types", [
        F("name", "s", req=True), F("days_per_year", "i"),
    ], title="name"),
    E("HumanResources", "LeaveRequest", "leave_requests", [
        fk("employee_id", "Employee", "employees", "Masters", req=True),
        fk("leave_type_id", "LeaveType", "leave_types", "HumanResources"),
        F("starts_on", "date", req=True), F("ends_on", "date", req=True),
        F("status", "e", options=["draft", "approved", "rejected"]), F("reason", "t"),
    ], title="id"),
    E("HumanResources", "AttendanceDay", "attendance_days", [
        fk("employee_id", "Employee", "employees", "Masters", req=True),
        F("work_date", "date", req=True),
        F("status", "e", options=["present", "absent", "late", "leave", "holiday"]),
        F("in_at", "dt"), F("out_at", "dt"), F("ot_minutes", "i"), F("source", "s"),
    ], title="work_date"),
    E("HumanResources", "SalaryStructure", "salary_structures", [
        fk("employee_id", "Employee", "employees", "Masters", req=True),
        F("basic", "money"), F("house_rent", "money"), F("medical", "money"), F("conveyance", "money"),
        F("attendance_bonus", "money"),
    ], title="id"),
    E("HumanResources", "PayrollRun", "payroll_runs", [
        F("year", "i", req=True), F("month", "i", req=True),
        F("status", "e", options=["draft", "approved", "posted"]),
    ], title="id"),
    E("HumanResources", "Payslip", "payslips", [
        fk("payroll_run_id", "PayrollRun", "payroll_runs", "HumanResources", title="id", req=True),
        fk("employee_id", "Employee", "employees", "Masters", req=True),
        F("gross", "money"), F("deductions", "money"), F("net", "money"),
    ], title="id", lines="PayslipLine"),
    E("HumanResources", "PayslipLine", "payslip_lines", [
        fk("payslip_id", "Payslip", "payslips", "HumanResources", title="id", req=True),
        F("kind", "s", req=True), F("amount", "money"),
    ], nav=False, title="kind"),
    E("HumanResources", "Loan", "loans", [
        fk("employee_id", "Employee", "employees", "Masters", req=True),
        F("principal", "money"), F("balance", "money"), F("installment", "money"), F("status", "s"),
    ], title="id"),
    E("HumanResources", "Incident", "incidents", [
        fk("employee_id", "Employee", "employees", "Masters"),
        F("occurred_on", "date", req=True), F("severity", "e", options=["low", "medium", "high"]),
        F("description", "t", req=True),
    ], title="id"),
    E("HumanResources", "PpeIssue", "ppe_issues", [
        fk("employee_id", "Employee", "employees", "Masters", req=True),
        F("item", "s", req=True), F("qty", "i"), F("issued_on", "date"),
    ], title="item"),
    E("HumanResources", "JobPosting", "job_postings", [
        F("title", "s", req=True), F("title_bn", "s"), F("slug", "s"), F("description", "t"),
        F("status", "e", options=["draft", "published", "closed"]), F("closes_on", "date"),
    ], slug=True, title="title"),
    E("HumanResources", "JobApplication", "job_applications", [
        fk("job_posting_id", "JobPosting", "job_postings", "HumanResources", title="title", req=True),
        F("name", "s", req=True), F("email", "s"), F("phone", "s"),
        F("status", "e", options=["new", "shortlisted", "rejected", "hired"]), F("note", "t"),
    ], title="name"),
    E("HumanResources", "DisciplinaryAction", "disciplinary_actions", [
        fk("employee_id", "Employee", "employees", "Masters", req=True),
        F("kind", "e", options=["warning", "show_cause", "suspension", "termination"], req=True),
        F("note", "t"), F("issued_on", "date"),
    ], title="kind"),
    E("Accounts", "Account", "accounts", [
        fk("parent_id", "Account", "accounts", "Accounts", method="parent"),
        F("code", "s", req=True), F("name", "s", req=True),
        F("type", "e", options=["asset", "liability", "equity", "income", "expense"], req=True),
    ], title="name", search=["code", "name"]),
    E("Accounts", "CostCenter", "cost_centers", [
        F("code", "s", req=True), F("name", "s", req=True),
        F("kind", "e", options=["department", "machine", "order"]),
    ], title="name"),
    E("Accounts", "Journal", "journals", [
        F("number", "s"), F("journal_date", "date", req=True), F("source_type", "s"), F("source_id", "i"),
        F("narration", "t"), F("status", "e", options=["draft", "posted"]),
    ], doc="JV", title="number", lines="JournalLine"),
    E("Accounts", "JournalLine", "journal_lines", [
        fk("journal_id", "Journal", "journals", "Accounts", title="number", req=True),
        fk("account_id", "Account", "accounts", "Accounts", req=True),
        fk("cost_center_id", "CostCenter", "cost_centers", "Accounts"),
        fk("party_id", "Party", "parties", "Masters"),
        F("debit", "money"), F("credit", "money"), F("currency_code", "s"),
    ], append=True, nav=False, title="id"),
    E("Accounts", "Voucher", "vouchers", [
        fk("party_id", "Party", "parties", "Masters"),
        fk("journal_id", "Journal", "journals", "Accounts", title="number"),
        F("kind", "e", options=["receipt", "payment", "journal", "contra"], req=True),
        F("number", "s"), F("voucher_date", "date"), F("amount", "money"),
        F("status", "e", options=["draft", "posted"]), F("narration", "t"),
    ], doc="VCH", title="number"),
    E("Accounts", "BankAccount", "bank_accounts", [
        fk("gl_account_id", "Account", "accounts", "Accounts", method="glAccount"),
        F("name", "s", req=True), F("account_no", "s"),
    ], title="name"),
    E("Accounts", "BankLine", "bank_lines", [
        fk("bank_account_id", "BankAccount", "bank_accounts", "Accounts", req=True),
        F("txn_date", "date"), F("amount", "money"), F("reference", "s"), F("matched", "b"),
    ], title="reference"),
    E("Accounts", "Budget", "budgets", [
        fk("financial_year_id", "FinancialYear", "financial_years", "Core"),
        F("name", "s", req=True), F("status", "e", options=["draft", "approved"]),
    ], title="name", lines="BudgetLine"),
    E("Accounts", "BudgetLine", "budget_lines", [
        fk("budget_id", "Budget", "budgets", "Accounts", req=True),
        fk("account_id", "Account", "accounts", "Accounts", req=True),
        F("amount", "money"),
    ], nav=False, title="id"),
    E("Accounts", "PeriodLock", "period_locks", [
        F("year", "i", req=True), F("month", "i", req=True), F("locked_at", "dt"),
    ], title="id"),
    E("Operations", "Issue", "issues", [
        F("rule_key", "s", req=True), F("severity", "e", options=["info", "low", "medium", "high", "critical"], req=True),
        F("title", "s", req=True), F("detail", "t"), F("suggested_solution", "t"),
        F("owner_role", "s"), F("status", "e", options=["open", "snoozed", "justified", "resolved", "escalated"]),
        F("sla_due_at", "dt"), F("subject_type", "s"), F("subject_id", "i"), F("escalated_level", "i"),
        F("snooze_reason", "t"),
    ], title="title", search=["title", "rule_key"]),
    E("Operations", "IssueRule", "issue_rules", [
        F("key", "s", req=True), F("enabled", "b"), F("thresholds", "j"),
        F("owner_role", "s"), F("severity", "s"), F("sla_hours", "i"),
    ], title="key"),
    E("Operations", "IssueEvent", "issue_events", [
        fk("issue_id", "Issue", "issues", "Operations", req=True),
        F("kind", "s"), F("note", "t"), F("user_id", "i"),
    ], nav=False, title="kind"),
    E("Operations", "TaskItem", "tasks", [
        F("title", "s", req=True), F("from_department", "s"), F("to_department", "s"),
        F("status", "e", options=["open", "done", "overdue"]), F("due_at", "dt"), F("sla_hours", "i"),
        F("detail", "t"),
    ], title="title"),
    E("Operations", "NotificationDispatch", "notification_dispatches", [
        F("channel", "s", req=True), F("recipient", "s"), F("subject", "s"), F("body", "t"),
        F("status", "e", options=["queued", "sent", "failed"]),
    ], title="subject"),
    E("Operations", "WebhookEndpoint", "webhook_endpoints", [
        F("url", "s", req=True), F("event", "s", req=True), F("secret", "s"), F("is_active", "b"),
    ], title="event"),
    E("Website", "CmsPage", "cms_pages", [
        F("title", "s", req=True), F("title_bn", "s"), F("slug", "s"), F("body", "t"), F("body_bn", "t"),
        F("seo_title", "s"), F("seo_description", "t"), F("published_at", "dt"),
        F("status", "e", options=["draft", "published"]),
    ], slug=True, company=False, title="title"),
    E("Website", "CmsSection", "cms_sections", [
        fk("cms_page_id", "CmsPage", "cms_pages", "Website", title="title"),
        F("key", "s", req=True), F("content", "j"),
    ], company=False, nav=False, title="key"),
    E("Website", "CmsMenu", "cms_menus", [
        F("name", "s", req=True), F("location", "s", req=True),
    ], company=False, title="name"),
    E("Website", "CmsMenuItem", "cms_menu_items", [
        fk("cms_menu_id", "CmsMenu", "cms_menus", "Website", req=True),
        F("label", "s", req=True), F("label_bn", "s"), F("url", "s", req=True), F("sort", "i"),
    ], company=False, title="label"),
    E("Website", "CmsPost", "cms_posts", [
        F("title", "s", req=True), F("title_bn", "s"), F("slug", "s"), F("body", "t"), F("body_bn", "t"),
        F("published_at", "dt"), F("status", "e", options=["draft", "published"]),
    ], slug=True, company=False, title="title"),
    E("Website", "CmsBanner", "cms_banners", [
        F("title", "s", req=True), F("image_path", "s"), F("link", "s"), F("sort", "i"), F("is_active", "b"),
    ], company=False, title="title"),
    E("Website", "CmsFaq", "cms_faqs", [
        F("question", "s", req=True), F("question_bn", "s"), F("answer", "t"), F("answer_bn", "t"), F("sort", "i"),
    ], company=False, title="question"),
    E("Website", "CmsMedia", "cms_media", [
        F("path", "s", req=True), F("alt", "s"), F("alt_bn", "s"),
    ], company=False, title="alt"),
    E("Website", "CatalogProduct", "catalog_products", [
        fk("fabric_item_id", "FabricItem", "fabric_items", "Masters"),
        F("title", "s", req=True), F("title_bn", "s"), F("slug", "s"), F("composition", "s"),
        F("gsm", "s"), F("uses", "s"), F("description", "t"), F("description_bn", "t"),
        F("image_path", "s"), F("published", "b"),
    ], slug=True, company=False, title="title"),
    E("Website", "FormSubmission", "form_submissions", [
        F("form", "s", req=True), F("payload", "j"), F("status", "e", options=["new", "read", "converted"]),
    ], company=False, title="form"),
]


def php_string(value: str) -> str:
    return "'" + value.replace("\\", "\\\\").replace("'", "\\'") + "'"


def studly(name: str) -> str:
    return name


def write(path: Path, content: str) -> None:
    path.parent.mkdir(parents=True, exist_ok=True)
    path.write_text(content, encoding="utf-8")


def migration_column(field: dict, entity_table: str) -> str:
    name = field["name"]
    kind = field["type"]
    if kind == "fk":
        if field["table"] == entity_table:
            null = "" if field.get("req") else "->nullable()"
            return f"$table->unsignedBigInteger('{name}'){null}"
        line = f"$table->foreignId('{name}')"
        if field.get("req"):
            return line + f"->constrained('{field['table']}')->cascadeOnUpdate()->restrictOnDelete()"
        return line + f"->nullable()->constrained('{field['table']}')->nullOnDelete()"
    mapping = {
        "s": f"$table->string('{name}')",
        "t": f"$table->text('{name}')",
        "qty": f"$table->decimal('{name}', 18, 4)->default(0)",
        "money": f"$table->decimal('{name}', 18, 2)->default(0)",
        "i": f"$table->integer('{name}')",
        "b": f"$table->boolean('{name}')->default(false)",
        "date": f"$table->date('{name}')",
        "dt": f"$table->dateTime('{name}')",
        "j": f"$table->json('{name}')",
        "e": f"$table->string('{name}')",
    }
    line = mapping[kind]
    if kind in {"qty", "money", "b"}:
        return line
    if not field.get("req"):
        line += "->nullable()"
    if field.get("uniq") and kind == "s":
        line += "->unique()"
    return line


def entity_company(entity: dict) -> bool:
    return entity.get("company", True)


def model_base(entity: dict) -> str:
    return "AppendOnlyModel" if entity.get("append") else "ErpModel"


def emit_migration(module: str, entities: list[dict], stamp: str) -> None:
    chunks = []
    if module == "Core":
        chunks.append(dedent("""
            Schema::create('companies', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('name');
                $table->string('name_bn')->nullable();
                $table->text('address')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->string('vat_bin')->nullable();
                $table->string('tin')->nullable();
                $table->string('website')->nullable();
                $table->string('timezone')->nullable();
                $table->string('default_currency', 3)->default('BDT');
                $table->timestamps();
                $table->softDeletes();
            });
            Schema::create('units', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
                $table->string('code');
                $table->string('name');
                $table->string('type');
                $table->text('address')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->unique(['company_id', 'code']);
            });
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
                $table->string('portal')->default('staff');
                $table->string('locale', 5)->default('en');
                $table->boolean('is_super_admin')->default(false);
                $table->boolean('bangla_numerals')->default(false);
                $table->text('two_factor_secret')->nullable();
                $table->timestamp('two_factor_confirmed_at')->nullable();
                $table->timestamp('last_login_at')->nullable();
                $table->unsignedBigInteger('party_id')->nullable();
                $table->unsignedBigInteger('employee_id')->nullable();
            });
        """).strip())
        entities = [e for e in entities if e["table"] not in {"companies", "units"}]

    for entity in entities:
        cols = []
        cols.append("            $table->id();")
        if entity_company(entity):
            cols.append("            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();")
        if entity.get("doc") and not any(f["name"] == "unit_id" for f in entity["fields"]):
            cols.append("            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();")
        for field in entity["fields"]:
            if field["name"] in {"company_id"}:
                continue
            cols.append("            " + migration_column(field, entity["table"]) + ";")
        if any(f["name"] == "created_by" for f in entity["fields"]) is False:
            cols.append("            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();")
        if entity.get("doc"):
            cols.append("            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();")
        cols.append("            $table->timestamps();")
        if not entity.get("append"):
            cols.append("            $table->softDeletes();")
        if entity.get("doc"):
            cols.append("            $table->index(['company_id', 'number']);")
        if entity["table"] == "stock_ledgers":
            cols.append("            $table->index(['company_id', 'stock_type', 'item_id', 'lot_id'], 'stock_ledgers_balance_idx');")
            cols.append("            $table->unique('movement_key');")
        body = "\n".join(cols)
        chunks.append(
            f"Schema::create('{entity['table']}', function (Blueprint $table) {{\n{body}\n        }});"
        )

    if module == "Core":
        chunks.append(dedent("""
            Schema::create('permission_role', function (Blueprint $table) {
                $table->id();
                $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
                $table->foreignId('role_id')->constrained()->cascadeOnDelete();
                $table->unique(['permission_id', 'role_id']);
            });
            Schema::create('role_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('role_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->unique(['role_id', 'user_id']);
            });
        """).strip())

    if module == "Website":
        chunks.append(dedent("""
            Schema::create('slug_histories', function (Blueprint $table) {
                $table->id();
                $table->morphs('sluggable');
                $table->string('slug')->index();
                $table->string('field')->default('slug');
                $table->timestamps();
                $table->unique(['sluggable_type', 'slug', 'field'], 'slug_histories_unique');
            });
        """).strip())

    up = "\n\n        ".join(chunks)
    tables = [e["table"] for e in entities]
    if module == "Website":
        tables.append("slug_histories")
    down_tables = list(reversed(tables))
    if module == "Core":
        down_tables = [
            "Schema::dropIfExists('role_user');",
            "Schema::dropIfExists('permission_role');",
            "Schema::table('users', function (Blueprint $table) { $table->dropConstrainedForeignId('unit_id'); $table->dropConstrainedForeignId('company_id'); $table->dropColumn(['portal', 'locale', 'is_super_admin', 'bangla_numerals', 'two_factor_secret', 'two_factor_confirmed_at', 'last_login_at', 'party_id', 'employee_id']); });",
        ] + [f"Schema::dropIfExists('{t}');" for t in down_tables] + ["Schema::dropIfExists('units');", "Schema::dropIfExists('companies');"]
        down = "\n        ".join(down_tables)
    else:
        down = "\n        ".join([f"Schema::dropIfExists('{t}');" for t in down_tables])
    content = f"""<?php

declare(strict_types=1);

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{{
    public function up(): void
    {{
        {up}
    }}

    public function down(): void
    {{
        {down}
    }}
}};
"""
    path = ROOT / "app" / "Modules" / module / "Database" / "Migrations" / f"{stamp}_create_{module.lower()}_tables.php"
    write(path, content)


def relation_uses(entity: dict) -> set[str]:
    uses = set()
    if any(f["type"] == "fk" for f in entity["fields"]):
        uses.add("Illuminate\\Database\\Eloquent\\Relations\\BelongsTo")
    if entity.get("lines"):
        uses.add("Illuminate\\Database\\Eloquent\\Relations\\HasMany")
    return uses


def emit_model(entity: dict) -> None:
    module = entity["module"]
    name = entity["name"]
    base = model_base(entity)
    uses = [
        f"use App\\Modules\\Support\\{base};",
    ]
    uses.extend(f"use {u};" for u in sorted(relation_uses(entity)))
    casts = []
    for field in entity["fields"]:
        if field["type"] == "qty":
            casts.append(f"'{field['name']}' => 'decimal:4'")
        elif field["type"] == "money":
            casts.append(f"'{field['name']}' => 'decimal:2'")
        elif field["type"] == "b":
            casts.append(f"'{field['name']}' => 'boolean'")
        elif field["type"] == "date":
            casts.append(f"'{field['name']}' => 'date'")
        elif field["type"] == "dt":
            casts.append(f"'{field['name']}' => 'datetime'")
        elif field["type"] == "j":
            casts.append(f"'{field['name']}' => 'array'")
    methods = []
    seen = set()
    for field in entity["fields"]:
        if field["type"] != "fk":
            continue
        method = field["method"]
        if method in seen:
            continue
        seen.add(method)
        fq = f"\\App\\Modules\\{field['module']}\\Models\\{field['model']}"
        methods.append(
            f"""    public function {method}(): BelongsTo\n    {{\n        return $this->belongsTo({fq}::class, '{field['name']}');\n    }}"""
        )
    if entity.get("lines"):
        child = next(e for e in ENTITIES if e["name"] == entity["lines"])
        methods.append(
            f"""    public function lines(): HasMany\n    {{\n        return $this->hasMany(\\App\\Modules\\{child['module']}\\Models\\{child['name']}::class);\n    }}"""
        )
    scope = ""
    if not entity_company(entity):
        scope = "\n    protected bool $scopesCompany = false;\n"
    slug = ""
    if entity.get("slug"):
        uses.append("use ImranDev\\UniversalSlug\\Attributes\\Slug;")
        uses.append("use ImranDev\\UniversalSlug\\Traits\\HasUniversalSlug;")
        slug = "\n#[Slug(from: 'title', to: 'slug')]\n"
        trait = "\n    use HasUniversalSlug;\n"
    else:
        trait = ""
    doc = ""
    if entity.get("doc"):
        doc = f"\n    public string $documentType = '{entity['doc']}';\n"
    cast_body = ",\n            ".join(casts)
    cast_method = ""
    if casts:
        cast_method = f"""
    protected function casts(): array
    {{
        return [
            {cast_body},
        ];
    }}
"""
    content = f"""<?php

declare(strict_types=1);

namespace App\\Modules\\{module}\\Models;

{chr(10).join(uses)}
{slug}class {name} extends {base}
{{{trait}{scope}{doc}{cast_method}
    protected $table = '{entity['table']}';

{chr(10).join(methods)}
}}
"""
    write(ROOT / "app" / "Modules" / module / "Models" / f"{name}.php", content)


def form_component(field: dict) -> str:
    name = field["name"]
    kind = field["type"]
    if kind == "fk":
        req = "->required()" if field.get("req") else "->nullable()"
        return f"Select::make('{name}')->label('{name.replace('_', ' ').title()}')->relationship('{field['method']}', '{field['title']}'){req}->searchable()->preload()"
    if kind == "e":
        opts = ", ".join(f"{php_string(o)} => {php_string(o.replace('_', ' ').title())}" for o in field["options"])
        req = "->required()" if field.get("req") else "->nullable()"
        return f"Select::make('{name}')->options([{opts}]){req}"
    if kind == "b":
        return f"Toggle::make('{name}')"
    if kind == "t":
        return f"Textarea::make('{name}')->rows(3)->columnSpanFull()"
    if kind == "j":
        return f"Textarea::make('{name}')->rows(4)->columnSpanFull()->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)"
    if kind == "date":
        return f"DatePicker::make('{name}')"
    if kind == "dt":
        return f"DateTimePicker::make('{name}')"
    if kind in {"qty", "money", "i"}:
        req = "->required()" if field.get("req") else ""
        return f"TextInput::make('{name}')->numeric(){req}"
    req = "->required()" if field.get("req") else ""
    return f"TextInput::make('{name}')->maxLength(255){req}"


def table_column(field: dict) -> str:
    name = field["name"]
    if field["type"] == "fk":
        return f"TextColumn::make('{field['method']}.{field['title']}')->label('{name.replace('_', ' ').title()}')->toggleable()"
    if field["type"] == "b":
        return f"IconColumn::make('{name}')->boolean()->toggleable()"
    if field["type"] in {"t", "j"}:
        return f"TextColumn::make('{name}')->limit(40)->toggleable(isToggledHiddenByDefault: true)"
    searchable = "->searchable()" if field["type"] in {"s", "e"} else ""
    return f"TextColumn::make('{name}'){searchable}->sortable()->toggleable()"


def emit_resource(entity: dict) -> None:
    if entity.get("nav") is False:
        return
    module = entity["module"]
    name = entity["name"]
    model = f"App\\Modules\\{module}\\Models\\{name}"
    fields = [f for f in entity["fields"] if f["name"] not in {"company_id"}]
    form_bits = [form_component(f) for f in fields if f["type"] != "j"]
    if entity.get("lines"):
        child = next(e for e in ENTITIES if e["name"] == entity["lines"])
        child_fields = [f for f in child["fields"] if not (f["type"] == "fk" and f["model"] == name)]
        inner = ",\n                        ".join(form_component(f) for f in child_fields)
        form_bits.append(
            "Repeater::make('lines')->relationship()->schema([\n                        "
            + inner
            + "\n                    ])->columnSpanFull()->collapsible()"
        )
    columns = [table_column(f) for f in fields if f["type"] not in {"t", "j"}][:8]
    if not columns:
        columns = [f"TextColumn::make('{entity.get('title', 'id')}')"]
    search = entity.get("search") or [entity.get("title", "id")]
    search_php = ", ".join(php_string(s) for s in search if s != "id")
    readonly = ""
    pages = """'index' => Pages\\ListRecords::route('/'),
            'create' => Pages\\CreateRecord::route('/create'),
            'edit' => Pages\\EditRecord::route('/{record}/edit'),"""
    if entity.get("readonly"):
        readonly = """
    public static function canCreate(): bool
    {
        return false;
    }
"""
        pages = "'index' => Pages\\ListRecords::route('/'),"
    group = GROUPS[module]
    icon = "heroicon-o-rectangle-stack"
    form_inner = ",\n                    ".join(form_bits)
    col_inner = ",\n                ".join(columns)
    content = f"""<?php

declare(strict_types=1);

namespace App\\Modules\\{module}\\Filament;

use {model};
use Filament\\Actions\\BulkActionGroup;
use Filament\\Actions\\DeleteBulkAction;
use Filament\\Actions\\EditAction;
use Filament\\Forms\\Components\\DatePicker;
use Filament\\Forms\\Components\\DateTimePicker;
use Filament\\Forms\\Components\\Repeater;
use Filament\\Forms\\Components\\Select;
use Filament\\Forms\\Components\\Textarea;
use Filament\\Forms\\Components\\TextInput;
use Filament\\Forms\\Components\\Toggle;
use Filament\\Resources\\Resource;
use Filament\\Schemas\\Components\\Section;
use Filament\\Schemas\\Schema;
use Filament\\Tables\\Columns\\IconColumn;
use Filament\\Tables\\Columns\\TextColumn;
use Filament\\Tables\\Table;
use Illuminate\\Database\\Eloquent\\Model;

class {name}Resource extends Resource
{{
    protected static ?string $model = {name}::class;

    protected static ?string $navigationGroup = '{group}';

    protected static ?string $navigationIcon = '{icon}';

    protected static ?string $recordTitleAttribute = '{entity.get('title', 'id')}';

    public static function moduleKey(): string
    {{
        return '{module.lower()}';
    }}

    public static function form(Schema $schema): Schema
    {{
        return $schema->components([
            Section::make('{name}')->columns(2)->schema([
                    {form_inner}
                ]),
        ]);
    }}

    public static function table(Table $table): Table
    {{
        return $table
            ->columns([
                {col_inner}
            ])
            ->recordActions([
                {"EditAction::make()," if not entity.get("readonly") else ""}
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }}

    public static function getGloballySearchableAttributes(): array
    {{
        return [{search_php}];
    }}

    public static function getGlobalSearchResultTitle(Model $record): string
    {{
        return (string) ($record->{entity.get('title', 'id')} ?? $record->getKey());
    }}
{readonly}
    public static function getPages(): array
    {{
        return [
            {pages}
        ];
    }}
}}
"""
    write(ROOT / "app" / "Modules" / module / "Filament" / f"{name}Resource.php", content)
    page_dir = ROOT / "app" / "Modules" / module / "Filament" / f"{name}Resource" / "Pages"
    write(page_dir / "ListRecords.php", f"""<?php

declare(strict_types=1);

namespace App\\Modules\\{module}\\Filament\\{name}Resource\\Pages;

use App\\Filament\\Pages\\ErpListRecords;
use App\\Modules\\{module}\\Filament\\{name}Resource;

class ListRecords extends ErpListRecords
{{
    protected static string $resource = {name}Resource::class;
}}
""")
    if not entity.get("readonly"):
        write(page_dir / "CreateRecord.php", f"""<?php

declare(strict_types=1);

namespace App\\Modules\\{module}\\Filament\\{name}Resource\\Pages;

use App\\Modules\\{module}\\Filament\\{name}Resource;
use Filament\\Resources\\Pages\\CreateRecord;

class CreateRecord extends CreateRecord
{{
    protected static string $resource = {name}Resource::class;
}}
""")
        write(page_dir / "EditRecord.php", f"""<?php

declare(strict_types=1);

namespace App\\Modules\\{module}\\Filament\\{name}Resource\\Pages;

use App\\Modules\\{module}\\Filament\\{name}Resource;
use Filament\\Actions\\DeleteAction;
use Filament\\Resources\\Pages\\EditRecord;

class EditRecord extends EditRecord
{{
    protected static string $resource = {name}Resource::class;

    protected function getHeaderActions(): array
    {{
        return [DeleteAction::make()];
    }}
}}
""")


def emit_policy(entity: dict) -> None:
    module = entity["module"]
    name = entity["name"]
    content = f"""<?php

declare(strict_types=1);

namespace App\\Modules\\{module}\\Policies;

use App\\Models\\User;
use App\\Modules\\{module}\\Models\\{name};
use App\\Modules\\Support\\ModuleGate;

class {name}Policy
{{
    public function viewAny(User $user): bool
    {{
        return $this->allows($user, 'view');
    }}

    public function view(User $user, {name} $model): bool
    {{
        return $this->allows($user, 'view');
    }}

    public function create(User $user): bool
    {{
        return $this->allows($user, 'create');
    }}

    public function update(User $user, {name} $model): bool
    {{
        return $this->allows($user, 'update');
    }}

    public function delete(User $user, {name} $model): bool
    {{
        return $this->allows($user, 'delete');
    }}

    private function allows(User $user, string $action): bool
    {{
        if (! ModuleGate::allows('{module.lower()}')) {{
            return false;
        }}

        return $user->is_super_admin || $user->hasPermission($action.' {name}');
    }}
}}
"""
    write(ROOT / "app" / "Modules" / module / "Policies" / f"{name}Policy.php", content)


def emit_provider(module: str, stamp: str) -> None:
    content = f"""<?php

declare(strict_types=1);

namespace App\\Modules\\{module};

use Illuminate\\Support\\ServiceProvider;

class {module}ServiceProvider extends ServiceProvider
{{
    public function boot(): void
    {{
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }}
}}
"""
    write(ROOT / "app" / "Modules" / module / f"{module}ServiceProvider.php", content)


def emit_permissions() -> None:
    names = []
    for entity in ENTITIES:
        if entity.get("nav") is False:
            continue
        for action in ("view", "create", "update", "delete", "export"):
            names.append(f"{action} {entity['name']}|{entity['module'].lower()}")
    rows = ",\n        ".join(php_string(n) for n in names)
    content = f"""<?php

declare(strict_types=1);

namespace App\\Modules\\Access;

final class PermissionCatalog
{{
    /** @return list<string> */
    public static function all(): array
    {{
        return [
        {rows},
        ];
    }}
}}
"""
    write(ROOT / "app" / "Modules" / "Access" / "PermissionCatalog.php", content)


def main() -> None:
    order = [
        "Core", "Masters", "Commercial", "Procurement", "Knitting", "Inventory",
        "Dyeing", "Quality", "Delivery", "Waste", "Maintenance", "HumanResources",
        "Accounts", "Operations", "Website",
    ]
    by_module: dict[str, list[dict]] = {m: [] for m in order}
    for entity in ENTITIES:
        by_module[entity["module"]].append(entity)
    for index, module in enumerate(order):
        stamp = f"2026_11_15_{100000 + index * 10:06d}"
        emit_migration(module, by_module[module], stamp)
        emit_provider(module, stamp)
        for entity in by_module[module]:
            emit_model(entity)
            emit_policy(entity)
            emit_resource(entity)
    emit_permissions()
    providers = ["App\\Providers\\AppServiceProvider::class", "App\\Providers\\Filament\\AdminPanelProvider::class"]
    providers += [f"App\\Modules\\{m}\\{m}ServiceProvider::class" for m in MODULES]
    body = ",\n    ".join(providers)
    write(ROOT / "bootstrap" / "providers.php", f"""<?php

return [
    {body},
];
""")
    print(f"Generated {len(ENTITIES)} entities")


if __name__ == "__main__":
    main()
