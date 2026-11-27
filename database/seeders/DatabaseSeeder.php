<?php

namespace Database\Seeders;

use App\Models\FabricStock;
use App\Models\User;
use App\Services\FactoryStockService;
use App\Services\LedgerPostingService;
use App\Services\PartaService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

/**
 * Seed the fictional traditional-textile sample records and initial administrator.
 */
class DatabaseSeeder extends Seeder
{
    private const FIXTURE_IDENTITY_COLUMNS = [
        'customers' => ['name'],
        'suppliers' => ['name'],
        'financial_accounts' => ['name'],
        'parts' => ['part_code'],
        'fabric_stocks' => ['quality_name'],
        'sales_contracts' => ['contract_no'],
        'bag_purchases' => ['challan_no'],
        'sales' => ['slip_no'],
        'work_orders' => ['order_no'],
        'sizing_slips' => ['slip_no'],
        'sizing_beams' => ['beam_no'],
        'thaan_rolls' => ['roll_no'],
        'kachi_parchis' => ['parchi_no'],
        'pakki_parchis' => ['parchi_no'],
        'invoices' => ['invoice_no'],
        'payment_receipts' => ['receipt_no'],
        'expenses' => ['reference'],
    ];

    private const DERIVED_MUTABLE_COLUMNS = [
        'parts' => ['stock_quantity'],
        'fabric_stocks' => [
            'current_stock_meters',
            'committed_contract_meters',
            'available_open_meters',
            'daily_received_meters',
            'total_rolls_in_stock',
            'unit_cost_meter',
            'warp_weight_per_meter_lb',
            'weft_weight_per_meter_lb',
            'total_weight_per_meter_lb',
        ],
        'parta_records' => [
            'warp_lb_per_meter',
            'weft_lb_per_meter',
            'total_lb_per_meter',
            'kg_per_meter',
            'grams_per_meter',
            'gsm',
            'cost_per_meter',
        ],
        'sales' => ['cost_per_meter', 'cost_of_goods_sold'],
    ];

    private const FIXTURE_JSON = <<<'LOOMFLOW_TRADITIONAL_FIXTURE_JSON'
{
  "title": "LoomFlow — Faisalabad Traditional Textile Sample Records",
  "source_basis": "DATABASE_SCHEMA_README.md supplied by user; migrations remain authoritative",
  "fictional_data": true,
  "as_of_date": "2026-11-26",
  "currency": "PKR",
  "language_style": "Traditional Faisalabad textile trade language: Soot, Taana, Baana, Panna, Thaan, Kachi, Pakki, Mazdoori, Khaata, Wasooli, Baqaya",
  "schema_assumptions": [
    "Base fixture rows are imported without business postings; the unified seeder then derives ledgers and stock through application services and refuses unrelated or partial data.",
    "Do not treat illustrative Parta costing as an approved formula; recompute with actual verified divisor-800 model.",
    "Ledgers and fabric_stock_movements are generated through application services; do not insert those records directly.",
    "Sizing weight stored in sizing_weight_pounds; sizing bill rate is per kg. Screen should derive kg consistently.",
    "No real client phone numbers or login passwords are included.",
    "Final real database schema and controller validation may differ from this guide."
  ],
  "tables": {
    "customers": [
      {
        "ref": "C_YAQOOB",
        "name": "Haji Yaqoob Grey Cloth",
        "address": "Jhang Road, Faisalabad",
        "opening_balance": 0,
        "status": "active"
      },
      {
        "ref": "C_REHMAN",
        "name": "Rehman Kapra Merchants",
        "address": "Rail Bazar, Faisalabad",
        "opening_balance": 0,
        "status": "active"
      },
      {
        "ref": "C_SAEED",
        "name": "Saeed Textile Commission",
        "address": "Karkhana Bazar, Faisalabad",
        "opening_balance": 0,
        "status": "active"
      },
      {
        "ref": "C_AZEEM",
        "name": "Azeem Cloth Traders",
        "address": "Montgomery Bazar, Faisalabad",
        "opening_balance": 0,
        "status": "active"
      },
      {
        "ref": "C_BARKAT",
        "name": "Barkat Fabric House",
        "address": "Sargodha Road, Faisalabad",
        "opening_balance": 0,
        "status": "active"
      }
    ],
    "suppliers": [
      {
        "ref": "S_HAMD",
        "name": "Al-Hamd Soot Bhandar",
        "type": "yarn_supplier",
        "address": "Soot Mandi, Faisalabad",
        "opening_payable": 0,
        "status": "active"
      },
      {
        "ref": "S_IQBAL",
        "name": "Iqbal Soot Agency",
        "type": "yarn_supplier",
        "address": "Jhang Bazar, Faisalabad",
        "opening_payable": 0,
        "status": "active"
      },
      {
        "ref": "S_FAQEER",
        "name": "Faqeer Soot Commission",
        "type": "yarn_supplier",
        "address": "Faisalabad",
        "opening_payable": 0,
        "status": "active"
      },
      {
        "ref": "S_RAFIQ",
        "name": "Rafiq Sizing Ghar",
        "type": "sizing_mill",
        "address": "Jhang Road, Faisalabad",
        "opening_payable": 0,
        "status": "active"
      },
      {
        "ref": "S_BISMILLAH",
        "name": "Bismillah Sizing Works",
        "type": "sizing_mill",
        "address": "Samundri Road, Faisalabad",
        "opening_payable": 0,
        "status": "active"
      },
      {
        "ref": "S_NAWAB",
        "name": "Nawab Loom Parts",
        "type": "parts_vendor",
        "address": "Rail Bazar, Faisalabad",
        "opening_payable": 0,
        "status": "active"
      }
    ],
    "yarn_qualities": [
      {
        "ref": "Y40T",
        "name": "40/1 Taana Soot",
        "warp_count": 40,
        "weft_count": 40
      },
      {
        "ref": "Y40B",
        "name": "40/1 Baana Soot",
        "warp_count": 40,
        "weft_count": 40
      },
      {
        "ref": "Y30",
        "name": "30/1 Taana-Baana Soot",
        "warp_count": 30,
        "weft_count": 30
      }
    ],
    "financial_accounts": [
      {
        "ref": "A_CASH",
        "name": "Naqad Khaata",
        "type": "cash",
        "opening_balance": 320000,
        "is_active": true
      },
      {
        "ref": "A_BANK",
        "name": "Bank Khaata",
        "type": "bank",
        "opening_balance": 1200000,
        "is_active": true
      }
    ],
    "fixed_expenses": [
      {
        "ref": "FX_BIJLI",
        "name": "Bijli ka Bill",
        "payee": "FESCO",
        "default_amount": 150000,
        "frequency": "monthly",
        "due_day": 10,
        "is_active": true
      },
      {
        "ref": "FX_KIRAYA",
        "name": "Karkhana Kiraya",
        "payee": "Makan Malik",
        "default_amount": 90000,
        "frequency": "monthly",
        "due_day": 5,
        "is_active": true
      }
    ],
    "parts": [
      {
        "ref": "PART_PICKER",
        "part_code": "P-101",
        "part_name": "Picker",
        "category": "Mechanical",
        "stock_quantity": 18,
        "min_alert_threshold": 5,
        "unit": "pcs",
        "unit_price": 480
      },
      {
        "ref": "PART_SHUTTLE",
        "part_code": "P-102",
        "part_name": "Shuttle",
        "category": "Mechanical",
        "stock_quantity": 12,
        "min_alert_threshold": 3,
        "unit": "pcs",
        "unit_price": 1450
      },
      {
        "ref": "PART_BELT",
        "part_code": "P-103",
        "part_name": "Loom Belt",
        "category": "Mechanical",
        "stock_quantity": 16,
        "min_alert_threshold": 4,
        "unit": "pcs",
        "unit_price": 1850
      },
      {
        "ref": "PART_BEARING",
        "part_code": "P-104",
        "part_name": "Bearing",
        "category": "Mechanical",
        "stock_quantity": 30,
        "min_alert_threshold": 8,
        "unit": "pcs",
        "unit_price": 750
      },
      {
        "ref": "PART_REED",
        "part_code": "P-105",
        "part_name": "Reed / Kanghi",
        "category": "Mechanical",
        "stock_quantity": 7,
        "min_alert_threshold": 2,
        "unit": "pcs",
        "unit_price": 6500
      },
      {
        "ref": "PART_OIL",
        "part_code": "P-106",
        "part_name": "Machine Oil",
        "category": "Consumable",
        "stock_quantity": 55,
        "min_alert_threshold": 10,
        "unit": "pcs",
        "unit_price": 380
      }
    ],
    "fabric_stocks": [
      {
        "ref": "F_6060",
        "quality_name": "60×60 / 63 Panna",
        "construction": "40s × 40s Grey",
        "width_inches": 63,
        "read": 60,
        "pick": 60,
        "warp_count": 40,
        "weft_count": 40,
        "total_meters_produced": 1628,
        "current_stock_meters": 952,
        "committed_contract_meters": 332,
        "available_open_meters": 620,
        "daily_received_meters": 0,
        "total_rolls_in_stock": 11,
        "unit_cost_meter": 68.58,
        "notes": "Maqami grey kapra; Panna aur Thaan alag record hon"
      },
      {
        "ref": "F_7668",
        "quality_name": "76×68 / 63 Panna",
        "construction": "40s × 40s Grey",
        "width_inches": 63,
        "read": 76,
        "pick": 68,
        "warp_count": 40,
        "weft_count": 40,
        "total_meters_produced": 360,
        "current_stock_meters": 219,
        "committed_contract_meters": 219,
        "available_open_meters": 0,
        "daily_received_meters": 0,
        "total_rolls_in_stock": 3,
        "unit_cost_meter": 76.02,
        "notes": "Maqami grey kapra; Panna aur Thaan alag record hon"
      },
      {
        "ref": "F_5252",
        "quality_name": "52×52 / 58 Panna",
        "construction": "30s × 30s Grey",
        "width_inches": 58,
        "read": 52,
        "pick": 52,
        "warp_count": 30,
        "weft_count": 30,
        "total_meters_produced": 302,
        "current_stock_meters": 151,
        "committed_contract_meters": 151,
        "available_open_meters": 0,
        "daily_received_meters": 0,
        "total_rolls_in_stock": 2,
        "unit_cost_meter": 77.73,
        "notes": "Maqami grey kapra; Panna aur Thaan alag record hon"
      }
    ],
    "parta_records": [
      {
        "ref": "PARTA_6060",
        "fabric_stock_id_ref": "F_6060",
        "version": 1,
        "read": 60,
        "pick": 60,
        "width_inches": 63,
        "warp_count": 40,
        "weft_count": 40,
        "warp_rate_per_lb": 200,
        "weft_rate_per_lb": 185,
        "conversion_rate_per_pick": 0.5,
        "warp_lb_per_meter": 0.105,
        "weft_lb_per_meter": 0.095,
        "total_lb_per_meter": 0.2,
        "kg_per_meter": 0.090719,
        "grams_per_meter": 90.719,
        "gsm": 56.692,
        "cost_per_meter": 68.575
      },
      {
        "ref": "PARTA_7668",
        "fabric_stock_id_ref": "F_7668",
        "version": 1,
        "read": 76,
        "pick": 68,
        "width_inches": 63,
        "warp_count": 40,
        "weft_count": 40,
        "warp_rate_per_lb": 215,
        "weft_rate_per_lb": 205,
        "conversion_rate_per_pick": 0.45,
        "warp_lb_per_meter": 0.114,
        "weft_lb_per_meter": 0.102,
        "total_lb_per_meter": 0.216,
        "kg_per_meter": 0.097976,
        "grams_per_meter": 97.976,
        "gsm": 61.227,
        "cost_per_meter": 76.02
      },
      {
        "ref": "PARTA_5252",
        "fabric_stock_id_ref": "F_5252",
        "version": 1,
        "read": 52,
        "pick": 52,
        "width_inches": 58,
        "warp_count": 30,
        "weft_count": 30,
        "warp_rate_per_lb": 195,
        "weft_rate_per_lb": 190,
        "conversion_rate_per_pick": 0.55,
        "warp_lb_per_meter": 0.135,
        "weft_lb_per_meter": 0.12,
        "total_lb_per_meter": 0.255,
        "kg_per_meter": 0.115666,
        "grams_per_meter": 115.666,
        "gsm": 78.514,
        "cost_per_meter": 77.725
      }
    ],
    "sales_contracts": [
      {
        "ref": "SC_YAQOOB",
        "customer_id_ref": "C_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "contract_no": "M-111/26",
        "buyer_name": "Haji Yaqoob Grey Cloth",
        "fabric_quality": "60×60 / 63 Panna",
        "total_meters": 4000,
        "delivered_meters": 587,
        "remaining_meters": 3497,
        "accepted_meters": 503,
        "rate_per_meter": 30,
        "total_amount": 120000.0,
        "start_date": "2026-11-01",
        "status": "active",
        "contract_type": "Conversion",
        "yarn_supply": "Mixed",
        "pick": 60,
        "tax_enabled": false,
        "notes": "Job-work: Mazdoori sirf Pakki accepted metres par"
      },
      {
        "ref": "SC_REHMAN",
        "customer_id_ref": "C_REHMAN",
        "fabric_stock_id_ref": "F_7668",
        "contract_no": "M-112/26",
        "buyer_name": "Rehman Kapra Merchants",
        "fabric_quality": "76×68 / 63 Panna",
        "total_meters": 2800,
        "delivered_meters": 213,
        "remaining_meters": 2659,
        "accepted_meters": 141,
        "rate_per_meter": 30.6,
        "total_amount": 85680.0,
        "start_date": "2026-11-03",
        "status": "active",
        "contract_type": "Conversion",
        "yarn_supply": "Mixed",
        "pick": 68,
        "tax_enabled": false,
        "notes": "Job-work: Mazdoori sirf Pakki accepted metres par"
      },
      {
        "ref": "SC_SAEED",
        "customer_id_ref": "C_SAEED",
        "fabric_stock_id_ref": "F_5252",
        "contract_no": "M-113/26",
        "buyer_name": "Saeed Textile Commission",
        "fabric_quality": "52×52 / 58 Panna",
        "total_meters": 3200,
        "delivered_meters": 151,
        "remaining_meters": 3200,
        "accepted_meters": 0,
        "rate_per_meter": 28.6,
        "total_amount": 91520.0,
        "start_date": "2026-11-06",
        "status": "active",
        "contract_type": "Conversion",
        "yarn_supply": "Mixed",
        "pick": 52,
        "tax_enabled": false,
        "notes": "Job-work: Mazdoori sirf Pakki accepted metres par"
      }
    ],
    "bag_purchases": [
      {
        "ref": "BP_01",
        "challan_no": "CH-2461",
        "supplier_name": "Al-Hamd Soot Bhandar",
        "quality": "40/1 Taana Soot",
        "total_bags": 15,
        "bags_to_sizing": 10,
        "bags_to_factory": 5,
        "rate_per_bag": 62000,
        "total_amount": 930000.0,
        "purchase_date": "2026-10-28",
        "notes": "Soot ki khareed; chalaan ke mutabiq"
      },
      {
        "ref": "BP_02",
        "challan_no": "CH-2462",
        "supplier_name": "Iqbal Soot Agency",
        "quality": "40/1 Baana Soot",
        "total_bags": 18,
        "bags_to_sizing": 8,
        "bags_to_factory": 10,
        "rate_per_bag": 59000,
        "total_amount": 1062000.0,
        "purchase_date": "2026-11-02",
        "notes": "Soot ki khareed; chalaan ke mutabiq"
      },
      {
        "ref": "BP_03",
        "challan_no": "CH-2463",
        "supplier_name": "Faqeer Soot Commission",
        "quality": "30/1 Taana-Baana Soot",
        "total_bags": 12,
        "bags_to_sizing": 6,
        "bags_to_factory": 6,
        "rate_per_bag": 57000,
        "total_amount": 684000.0,
        "purchase_date": "2026-11-05",
        "notes": "Soot ki khareed; chalaan ke mutabiq"
      }
    ],
    "sales": [
      {
        "ref": "SALE_OWN",
        "customer_id_ref": "C_AZEEM",
        "fabric_stock_id_ref": "F_6060",
        "slip_no": "FAR-017/26",
        "sale_type": "open_market",
        "buyer_name": "Azeem Cloth Traders",
        "fabric_quality": "60×60 / 63 Panna",
        "meters_sold": 173,
        "rolls_sold": 2,
        "rate_per_meter": 205,
        "subtotal": 35465,
        "discount": 0,
        "net_total": 35465,
        "cost_per_meter": 68.58,
        "cost_of_goods_sold": 11864.34,
        "payment_type": "credit",
        "payment_status": "unpaid",
        "sale_date": "2026-11-23",
        "notes": "Apna maal: Thaan 020 aur 021; packing/challan match karna"
      }
    ],
    "work_orders": [
      {
        "ref": "WO_YAQOOB",
        "order_no": "JW-0261",
        "type": "job",
        "fabric_stock_id_ref": "F_6060",
        "parta_record_id_ref": "PARTA_6060",
        "target_meters": 4000,
        "accepted_meters": 503,
        "rate_per_pick": 0.5,
        "warp_supply": "customer",
        "weft_supply": "factory",
        "status": "active",
        "start_date": "2026-11-01",
        "notes": "Grey thaan weaving; check/folding ke baad stock",
        "customer_id_ref": "C_YAQOOB",
        "sales_contract_id_ref": "SC_YAQOOB",
        "party_name": "Haji Yaqoob Grey Cloth"
      },
      {
        "ref": "WO_REHMAN",
        "order_no": "JW-0262",
        "type": "job",
        "fabric_stock_id_ref": "F_7668",
        "parta_record_id_ref": "PARTA_7668",
        "target_meters": 2800,
        "accepted_meters": 141,
        "rate_per_pick": 0.45,
        "warp_supply": "customer",
        "weft_supply": "customer",
        "status": "active",
        "start_date": "2026-11-03",
        "notes": "Grey thaan weaving; check/folding ke baad stock",
        "customer_id_ref": "C_REHMAN",
        "sales_contract_id_ref": "SC_REHMAN",
        "party_name": "Rehman Kapra Merchants"
      },
      {
        "ref": "WO_SAEED",
        "order_no": "JW-0263",
        "type": "job",
        "fabric_stock_id_ref": "F_5252",
        "parta_record_id_ref": "PARTA_5252",
        "target_meters": 3200,
        "accepted_meters": 0,
        "rate_per_pick": 0.55,
        "warp_supply": "mixed",
        "weft_supply": "factory",
        "status": "active",
        "start_date": "2026-11-06",
        "notes": "Grey thaan weaving; check/folding ke baad stock",
        "customer_id_ref": "C_SAEED",
        "sales_contract_id_ref": "SC_SAEED",
        "party_name": "Saeed Textile Commission"
      },
      {
        "ref": "WO_OWN",
        "order_no": "IPO-017/26",
        "type": "own",
        "fabric_stock_id_ref": "F_6060",
        "parta_record_id_ref": "PARTA_6060",
        "target_meters": null,
        "accepted_meters": 0,
        "rate_per_pick": 0,
        "warp_supply": "factory",
        "weft_supply": "factory",
        "status": "active",
        "start_date": "2026-11-10",
        "notes": "Grey thaan weaving; check/folding ke baad stock"
      }
    ],
    "bag_transactions": [
      {
        "ref": "BT_01",
        "transaction_type": "purchase_factory",
        "reference_no": "CH-2461",
        "quality": "40/1 Taana Soot",
        "quantity_bags": 5,
        "source": "Al-Hamd Soot Bhandar",
        "destination": "Factory Soot Godam",
        "party_name": "Al-Hamd Soot Bhandar",
        "transaction_date": "2026-10-28",
        "owner_type": "factory",
        "component": "warp",
        "net_weight_kg": 250
      },
      {
        "ref": "BT_02",
        "transaction_type": "purchase_sizing",
        "reference_no": "CH-2461",
        "quality": "40/1 Taana Soot",
        "quantity_bags": 10,
        "source": "Al-Hamd Soot Bhandar",
        "destination": "Rafiq Sizing Ghar",
        "party_name": "Al-Hamd Soot Bhandar",
        "transaction_date": "2026-10-28",
        "owner_type": "factory",
        "component": "warp",
        "net_weight_kg": 500
      },
      {
        "ref": "BT_03",
        "transaction_type": "issue_to_sizing",
        "reference_no": "GI-26017",
        "quality": "40/1 Taana Soot",
        "quantity_bags": 14,
        "source": "Customer Soot Godam",
        "destination": "Rafiq Sizing Ghar",
        "party_name": "Haji Yaqoob Grey Cloth",
        "transaction_date": "2026-11-04",
        "owner_type": "customer",
        "component": "warp",
        "net_weight_kg": 700,
        "work_order_id_ref": "WO_YAQOOB",
        "sales_contract_id_ref": "SC_YAQOOB"
      },
      {
        "ref": "BT_04",
        "transaction_type": "issue_to_loom",
        "reference_no": "GI-26018",
        "quality": "40/1 Baana Soot",
        "quantity_bags": 4,
        "source": "Factory Soot Godam",
        "destination": "Loom 01 & 02",
        "party_name": "Haji Yaqoob Grey Cloth",
        "transaction_date": "2026-11-10",
        "owner_type": "factory",
        "component": "weft",
        "net_weight_kg": 200,
        "work_order_id_ref": "WO_YAQOOB",
        "sales_contract_id_ref": "SC_YAQOOB"
      },
      {
        "ref": "BT_05",
        "transaction_type": "return_from_sizing",
        "reference_no": "WA-26008",
        "quality": "40/1 Taana Soot",
        "quantity_bags": 1,
        "source": "Rafiq Sizing Ghar",
        "destination": "Customer Soot Godam",
        "party_name": "Haji Yaqoob Grey Cloth",
        "transaction_date": "2026-11-15",
        "owner_type": "customer",
        "component": "warp",
        "net_weight_kg": 50,
        "work_order_id_ref": "WO_YAQOOB",
        "sales_contract_id_ref": "SC_YAQOOB"
      }
    ],
    "sizing_slips": [
      {
        "ref": "SZ_YAQOOB",
        "slip_no": "SZ-2611",
        "slip_type": "raw_perch",
        "sizing_party": "Rafiq Sizing Ghar",
        "yarn_quality": "40/1 Taana Soot",
        "bags_allocated": 16,
        "bags_used": 14,
        "bags_returned_to_factory": 1,
        "bags_held_with_sizing": 1,
        "total_beams": 2,
        "total_length_meters": 3050,
        "set_length_unit": "meters",
        "sizing_weight_pounds": 2425.08,
        "sizing_rate_per_kg": 46,
        "sizing_bill_amount": 50600,
        "slip_date": "2026-11-02",
        "status": "completed",
        "work_order_id_ref": "WO_YAQOOB",
        "notes": "Sizing bill: 1100 kg × Rs 46/kg; beam/order allocation ke sath"
      },
      {
        "ref": "SZ_REHMAN",
        "slip_no": "SZ-2612",
        "slip_type": "raw_perch",
        "sizing_party": "Bismillah Sizing Works",
        "yarn_quality": "40/1 Taana Soot",
        "bags_allocated": 12,
        "bags_used": 11,
        "bags_returned_to_factory": 0,
        "bags_held_with_sizing": 1,
        "total_beams": 1,
        "total_length_meters": 1800,
        "set_length_unit": "meters",
        "sizing_weight_pounds": 1785.74,
        "sizing_rate_per_kg": 45,
        "sizing_bill_amount": 36450,
        "slip_date": "2026-11-04",
        "status": "completed",
        "work_order_id_ref": "WO_REHMAN",
        "notes": "Sizing bill: 810 kg × Rs 45/kg; beam/order allocation ke sath"
      },
      {
        "ref": "SZ_SAEED",
        "slip_no": "SZ-2613",
        "slip_type": "raw_perch",
        "sizing_party": "Rafiq Sizing Ghar",
        "yarn_quality": "30/1 Taana-Baana Soot",
        "bags_allocated": 10,
        "bags_used": 9,
        "bags_returned_to_factory": 1,
        "bags_held_with_sizing": 0,
        "total_beams": 1,
        "total_length_meters": 1600,
        "set_length_unit": "meters",
        "sizing_weight_pounds": 1488.12,
        "sizing_rate_per_kg": 44,
        "sizing_bill_amount": 29700,
        "slip_date": "2026-11-07",
        "status": "completed",
        "work_order_id_ref": "WO_SAEED",
        "notes": "Sizing bill: 675 kg × Rs 44/kg; beam/order allocation ke sath"
      },
      {
        "ref": "SZ_OWN",
        "slip_no": "SZ-2614",
        "slip_type": "raw_perch",
        "sizing_party": "Bismillah Sizing Works",
        "yarn_quality": "40/1 Taana Soot",
        "bags_allocated": 6,
        "bags_used": 6,
        "bags_returned_to_factory": 0,
        "bags_held_with_sizing": 0,
        "total_beams": 2,
        "total_length_meters": 2700,
        "set_length_unit": "meters",
        "sizing_weight_pounds": 1102.31,
        "sizing_rate_per_kg": 47,
        "sizing_bill_amount": 23500,
        "slip_date": "2026-11-09",
        "status": "completed",
        "work_order_id_ref": "WO_OWN",
        "notes": "Sizing bill: 500 kg × Rs 47/kg; beam/order allocation ke sath"
      }
    ],
    "sizing_beams": [
      {
        "ref": "B_101",
        "sizing_slip_id_ref": "SZ_YAQOOB",
        "work_order_id_ref": "WO_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "beam_no": "BM-2601",
        "yarn_quality": "40/1 Taana Soot",
        "total_length_meters": 1650,
        "remaining_length_meters": 595,
        "assigned_loom_no": "L-01",
        "status": "mounted_on_loom",
        "mounted_date": "2026-11-03"
      },
      {
        "ref": "B_102",
        "sizing_slip_id_ref": "SZ_YAQOOB",
        "work_order_id_ref": "WO_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "beam_no": "BM-2602",
        "yarn_quality": "40/1 Taana Soot",
        "total_length_meters": 1400,
        "remaining_length_meters": 670,
        "assigned_loom_no": "L-02",
        "status": "mounted_on_loom",
        "mounted_date": "2026-11-06"
      },
      {
        "ref": "B_103",
        "sizing_slip_id_ref": "SZ_REHMAN",
        "work_order_id_ref": "WO_REHMAN",
        "fabric_stock_id_ref": "F_7668",
        "beam_no": "BM-2603",
        "yarn_quality": "40/1 Taana Soot",
        "total_length_meters": 1800,
        "remaining_length_meters": 1140,
        "assigned_loom_no": "L-03",
        "status": "mounted_on_loom",
        "mounted_date": "2026-11-05"
      },
      {
        "ref": "B_104",
        "sizing_slip_id_ref": "SZ_SAEED",
        "work_order_id_ref": "WO_SAEED",
        "fabric_stock_id_ref": "F_5252",
        "beam_no": "BM-2604",
        "yarn_quality": "30/1 Taana-Baana Soot",
        "total_length_meters": 1600,
        "remaining_length_meters": 1265,
        "assigned_loom_no": "L-04",
        "status": "mounted_on_loom",
        "mounted_date": "2026-11-08"
      },
      {
        "ref": "B_105",
        "sizing_slip_id_ref": "SZ_OWN",
        "work_order_id_ref": "WO_OWN",
        "fabric_stock_id_ref": "F_6060",
        "beam_no": "BM-2605",
        "yarn_quality": "40/1 Taana Soot",
        "total_length_meters": 1500,
        "remaining_length_meters": 730,
        "assigned_loom_no": "L-05",
        "status": "mounted_on_loom",
        "mounted_date": "2026-11-11"
      },
      {
        "ref": "B_106",
        "sizing_slip_id_ref": "SZ_OWN",
        "work_order_id_ref": "WO_OWN",
        "fabric_stock_id_ref": "F_6060",
        "beam_no": "BM-2606",
        "yarn_quality": "40/1 Taana Soot",
        "total_length_meters": 1200,
        "remaining_length_meters": 815,
        "assigned_loom_no": "L-06",
        "status": "mounted_on_loom",
        "mounted_date": "2026-11-12"
      }
    ],
    "loom_assignments": [
      {
        "ref": "LA_01",
        "work_order_id_ref": "WO_YAQOOB",
        "loom_no": "L-01",
        "start_date": "2026-11-03"
      },
      {
        "ref": "LA_02",
        "work_order_id_ref": "WO_YAQOOB",
        "loom_no": "L-02",
        "start_date": "2026-11-06"
      },
      {
        "ref": "LA_03",
        "work_order_id_ref": "WO_REHMAN",
        "loom_no": "L-03",
        "start_date": "2026-11-05"
      },
      {
        "ref": "LA_04",
        "work_order_id_ref": "WO_SAEED",
        "loom_no": "L-04",
        "start_date": "2026-11-08"
      },
      {
        "ref": "LA_05",
        "work_order_id_ref": "WO_OWN",
        "loom_no": "L-05",
        "start_date": "2026-11-11"
      },
      {
        "ref": "LA_06",
        "work_order_id_ref": "WO_OWN",
        "loom_no": "L-06",
        "start_date": "2026-11-12"
      }
    ],
    "beam_events": [
      {
        "ref": "BE_01",
        "sizing_beam_id_ref": "B_101",
        "to_loom": "L-01",
        "action": "mount",
        "remaining_length_meters": 1650,
        "event_date": "2026-11-03"
      },
      {
        "ref": "BE_02",
        "sizing_beam_id_ref": "B_102",
        "to_loom": "L-02",
        "action": "mount",
        "remaining_length_meters": 1400,
        "event_date": "2026-11-06"
      },
      {
        "ref": "BE_03",
        "sizing_beam_id_ref": "B_103",
        "to_loom": "L-03",
        "action": "mount",
        "remaining_length_meters": 1800,
        "event_date": "2026-11-05"
      },
      {
        "ref": "BE_04",
        "sizing_beam_id_ref": "B_104",
        "to_loom": "L-04",
        "action": "mount",
        "remaining_length_meters": 1600,
        "event_date": "2026-11-08"
      },
      {
        "ref": "BE_05",
        "sizing_beam_id_ref": "B_105",
        "to_loom": "L-05",
        "action": "mount",
        "remaining_length_meters": 1500,
        "event_date": "2026-11-11"
      },
      {
        "ref": "BE_06",
        "sizing_beam_id_ref": "B_106",
        "to_loom": "L-06",
        "action": "mount",
        "remaining_length_meters": 1200,
        "event_date": "2026-11-12"
      }
    ],
    "yarn_movements": [
      {
        "ref": "YM_01",
        "work_order_id_ref": "WO_YAQOOB",
        "component": "warp",
        "owner_type": "customer",
        "movement_type": "receipt",
        "weight_kg": 900,
        "bags": 18,
        "reference_no": "YRN-0101",
        "movement_date": "2026-11-02",
        "destination_type": "factory_store"
      },
      {
        "ref": "YM_02",
        "work_order_id_ref": "WO_YAQOOB",
        "component": "warp",
        "owner_type": "customer",
        "movement_type": "issue",
        "weight_kg": 700,
        "bags": 14,
        "reference_no": "GI-26017",
        "movement_date": "2026-11-04",
        "destination_type": "sizing"
      },
      {
        "ref": "YM_03",
        "work_order_id_ref": "WO_YAQOOB",
        "component": "weft",
        "owner_type": "factory",
        "movement_type": "receipt",
        "weight_kg": 300,
        "bags": 6,
        "reference_no": "YRN-0102",
        "movement_date": "2026-11-04",
        "destination_type": "factory_store"
      },
      {
        "ref": "YM_04",
        "work_order_id_ref": "WO_YAQOOB",
        "component": "weft",
        "owner_type": "factory",
        "movement_type": "issue",
        "weight_kg": 200,
        "bags": 4,
        "reference_no": "GI-26018",
        "movement_date": "2026-11-10",
        "destination_type": "loom"
      },
      {
        "ref": "YM_05",
        "work_order_id_ref": "WO_REHMAN",
        "component": "warp",
        "owner_type": "customer",
        "movement_type": "receipt",
        "weight_kg": 600,
        "bags": 12,
        "reference_no": "YRN-0103",
        "movement_date": "2026-11-04",
        "destination_type": "factory_store"
      },
      {
        "ref": "YM_06",
        "work_order_id_ref": "WO_REHMAN",
        "component": "weft",
        "owner_type": "customer",
        "movement_type": "receipt",
        "weight_kg": 450,
        "bags": 9,
        "reference_no": "YRN-0104",
        "movement_date": "2026-11-04",
        "destination_type": "factory_store"
      },
      {
        "ref": "YM_07",
        "work_order_id_ref": "WO_SAEED",
        "component": "warp",
        "owner_type": "customer",
        "movement_type": "receipt",
        "weight_kg": 350,
        "bags": 7,
        "reference_no": "YRN-0105",
        "movement_date": "2026-11-07",
        "destination_type": "factory_store"
      },
      {
        "ref": "YM_08",
        "work_order_id_ref": "WO_SAEED",
        "component": "weft",
        "owner_type": "factory",
        "movement_type": "receipt",
        "weight_kg": 250,
        "bags": 5,
        "reference_no": "YRN-0106",
        "movement_date": "2026-11-07",
        "destination_type": "factory_store"
      },
      {
        "ref": "YM_09",
        "work_order_id_ref": "WO_OWN",
        "component": "warp",
        "owner_type": "factory",
        "movement_type": "receipt",
        "weight_kg": 400,
        "bags": 8,
        "reference_no": "YRN-0107",
        "movement_date": "2026-11-10",
        "destination_type": "factory_store"
      },
      {
        "ref": "YM_10",
        "work_order_id_ref": "WO_OWN",
        "component": "weft",
        "owner_type": "factory",
        "movement_type": "receipt",
        "weight_kg": 400,
        "bags": 8,
        "reference_no": "YRN-0108",
        "movement_date": "2026-11-10",
        "destination_type": "factory_store"
      },
      {
        "ref": "YM_11",
        "work_order_id_ref": "WO_YAQOOB",
        "component": "warp",
        "owner_type": "customer",
        "movement_type": "return",
        "weight_kg": 50,
        "bags": 1,
        "reference_no": "WA-26008",
        "movement_date": "2026-11-15",
        "destination_type": "factory_store",
        "notes": "Sizing se bacha hua Taana soot wapas"
      }
    ],
    "productions": [
      {
        "ref": "P01",
        "work_order_id_ref": "WO_YAQOOB",
        "loom_assignment_id_ref": "LA_01",
        "sizing_beam_id_ref": "B_101",
        "fabric_stock_id_ref": "F_6060",
        "production_date": "2026-11-15",
        "shift": "Day",
        "loom_no": "L-01",
        "operator_name": "Loom Muharrir",
        "fabric_quality": "60×60 / 63 Panna",
        "start_meter": 0,
        "end_meter": 350,
        "net_meters_produced": 350,
        "beam_meters_consumed": 355,
        "expected_fabric_meters": 350,
        "leakage_waste_meters": 5,
        "leakage_percentage": 1.41,
        "is_provisional": true,
        "remarks": "Meter reading; Thaan stock sirf checking se"
      },
      {
        "ref": "P02",
        "work_order_id_ref": "WO_YAQOOB",
        "loom_assignment_id_ref": "LA_01",
        "sizing_beam_id_ref": "B_101",
        "fabric_stock_id_ref": "F_6060",
        "production_date": "2026-11-16",
        "shift": "Day",
        "loom_no": "L-01",
        "operator_name": "Loom Muharrir",
        "fabric_quality": "60×60 / 63 Panna",
        "start_meter": 350,
        "end_meter": 700,
        "net_meters_produced": 350,
        "beam_meters_consumed": 355,
        "expected_fabric_meters": 350,
        "leakage_waste_meters": 5,
        "leakage_percentage": 1.41,
        "is_provisional": true,
        "remarks": "Meter reading; Thaan stock sirf checking se"
      },
      {
        "ref": "P03",
        "work_order_id_ref": "WO_YAQOOB",
        "loom_assignment_id_ref": "LA_01",
        "sizing_beam_id_ref": "B_101",
        "fabric_stock_id_ref": "F_6060",
        "production_date": "2026-11-17",
        "shift": "Day",
        "loom_no": "L-01",
        "operator_name": "Loom Muharrir",
        "fabric_quality": "60×60 / 63 Panna",
        "start_meter": 700,
        "end_meter": 1040,
        "net_meters_produced": 340,
        "beam_meters_consumed": 345,
        "expected_fabric_meters": 340,
        "leakage_waste_meters": 5,
        "leakage_percentage": 1.45,
        "is_provisional": true,
        "remarks": "Meter reading; Thaan stock sirf checking se"
      },
      {
        "ref": "P04",
        "work_order_id_ref": "WO_YAQOOB",
        "loom_assignment_id_ref": "LA_02",
        "sizing_beam_id_ref": "B_102",
        "fabric_stock_id_ref": "F_6060",
        "production_date": "2026-11-17",
        "shift": "Day",
        "loom_no": "L-02",
        "operator_name": "Loom Muharrir",
        "fabric_quality": "60×60 / 63 Panna",
        "start_meter": 0,
        "end_meter": 370,
        "net_meters_produced": 370,
        "beam_meters_consumed": 375,
        "expected_fabric_meters": 370,
        "leakage_waste_meters": 5,
        "leakage_percentage": 1.33,
        "is_provisional": true,
        "remarks": "Meter reading; Thaan stock sirf checking se"
      },
      {
        "ref": "P05",
        "work_order_id_ref": "WO_YAQOOB",
        "loom_assignment_id_ref": "LA_02",
        "sizing_beam_id_ref": "B_102",
        "fabric_stock_id_ref": "F_6060",
        "production_date": "2026-11-18",
        "shift": "Day",
        "loom_no": "L-02",
        "operator_name": "Loom Muharrir",
        "fabric_quality": "60×60 / 63 Panna",
        "start_meter": 370,
        "end_meter": 720,
        "net_meters_produced": 350,
        "beam_meters_consumed": 355,
        "expected_fabric_meters": 350,
        "leakage_waste_meters": 5,
        "leakage_percentage": 1.41,
        "is_provisional": true,
        "remarks": "Meter reading; Thaan stock sirf checking se"
      },
      {
        "ref": "P06",
        "work_order_id_ref": "WO_REHMAN",
        "loom_assignment_id_ref": "LA_03",
        "sizing_beam_id_ref": "B_103",
        "fabric_stock_id_ref": "F_7668",
        "production_date": "2026-11-18",
        "shift": "Day",
        "loom_no": "L-03",
        "operator_name": "Loom Muharrir",
        "fabric_quality": "76×68 / 63 Panna",
        "start_meter": 0,
        "end_meter": 330,
        "net_meters_produced": 330,
        "beam_meters_consumed": 335,
        "expected_fabric_meters": 330,
        "leakage_waste_meters": 5,
        "leakage_percentage": 1.49,
        "is_provisional": true,
        "remarks": "Meter reading; Thaan stock sirf checking se"
      },
      {
        "ref": "P07",
        "work_order_id_ref": "WO_REHMAN",
        "loom_assignment_id_ref": "LA_03",
        "sizing_beam_id_ref": "B_103",
        "fabric_stock_id_ref": "F_7668",
        "production_date": "2026-11-19",
        "shift": "Day",
        "loom_no": "L-03",
        "operator_name": "Loom Muharrir",
        "fabric_quality": "76×68 / 63 Panna",
        "start_meter": 330,
        "end_meter": 650,
        "net_meters_produced": 320,
        "beam_meters_consumed": 325,
        "expected_fabric_meters": 320,
        "leakage_waste_meters": 5,
        "leakage_percentage": 1.54,
        "is_provisional": true,
        "remarks": "Meter reading; Thaan stock sirf checking se"
      },
      {
        "ref": "P08",
        "work_order_id_ref": "WO_SAEED",
        "loom_assignment_id_ref": "LA_04",
        "sizing_beam_id_ref": "B_104",
        "fabric_stock_id_ref": "F_5252",
        "production_date": "2026-11-20",
        "shift": "Day",
        "loom_no": "L-04",
        "operator_name": "Loom Muharrir",
        "fabric_quality": "52×52 / 58 Panna",
        "start_meter": 0,
        "end_meter": 330,
        "net_meters_produced": 330,
        "beam_meters_consumed": 335,
        "expected_fabric_meters": 330,
        "leakage_waste_meters": 5,
        "leakage_percentage": 1.49,
        "is_provisional": true,
        "remarks": "Meter reading; Thaan stock sirf checking se"
      },
      {
        "ref": "P09",
        "work_order_id_ref": "WO_OWN",
        "loom_assignment_id_ref": "LA_05",
        "sizing_beam_id_ref": "B_105",
        "fabric_stock_id_ref": "F_6060",
        "production_date": "2026-11-20",
        "shift": "Day",
        "loom_no": "L-05",
        "operator_name": "Loom Muharrir",
        "fabric_quality": "60×60 / 63 Panna",
        "start_meter": 0,
        "end_meter": 385,
        "net_meters_produced": 385,
        "beam_meters_consumed": 390,
        "expected_fabric_meters": 385,
        "leakage_waste_meters": 5,
        "leakage_percentage": 1.28,
        "is_provisional": true,
        "remarks": "Meter reading; Thaan stock sirf checking se"
      },
      {
        "ref": "P10",
        "work_order_id_ref": "WO_OWN",
        "loom_assignment_id_ref": "LA_05",
        "sizing_beam_id_ref": "B_105",
        "fabric_stock_id_ref": "F_6060",
        "production_date": "2026-11-21",
        "shift": "Day",
        "loom_no": "L-05",
        "operator_name": "Loom Muharrir",
        "fabric_quality": "60×60 / 63 Panna",
        "start_meter": 385,
        "end_meter": 760,
        "net_meters_produced": 375,
        "beam_meters_consumed": 380,
        "expected_fabric_meters": 375,
        "leakage_waste_meters": 5,
        "leakage_percentage": 1.32,
        "is_provisional": true,
        "remarks": "Meter reading; Thaan stock sirf checking se"
      },
      {
        "ref": "P11",
        "work_order_id_ref": "WO_OWN",
        "loom_assignment_id_ref": "LA_06",
        "sizing_beam_id_ref": "B_106",
        "fabric_stock_id_ref": "F_6060",
        "production_date": "2026-11-21",
        "shift": "Day",
        "loom_no": "L-06",
        "operator_name": "Loom Muharrir",
        "fabric_quality": "60×60 / 63 Panna",
        "start_meter": 0,
        "end_meter": 380,
        "net_meters_produced": 380,
        "beam_meters_consumed": 385,
        "expected_fabric_meters": 380,
        "leakage_waste_meters": 5,
        "leakage_percentage": 1.3,
        "is_provisional": true,
        "remarks": "Meter reading; Thaan stock sirf checking se"
      }
    ],
    "thaan_rolls": [
      {
        "ref": "TH_001",
        "roll_no": "TH-0001",
        "work_order_id_ref": "WO_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-01",
        "checked_on": "2026-11-18",
        "length_meters": 85,
        "grade": "A",
        "status": "accepted",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_002",
        "roll_no": "TH-0002",
        "work_order_id_ref": "WO_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-01",
        "checked_on": "2026-11-18",
        "length_meters": 82,
        "grade": "A",
        "status": "accepted",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_003",
        "roll_no": "TH-0003",
        "work_order_id_ref": "WO_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-01",
        "checked_on": "2026-11-18",
        "length_meters": 84,
        "grade": "A",
        "status": "accepted",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_004",
        "roll_no": "TH-0004",
        "work_order_id_ref": "WO_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-01",
        "checked_on": "2026-11-18",
        "length_meters": 81,
        "grade": "A",
        "status": "accepted",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_005",
        "roll_no": "TH-0005",
        "work_order_id_ref": "WO_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-01",
        "checked_on": "2026-11-18",
        "length_meters": 83,
        "grade": "A",
        "status": "ready",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_006",
        "roll_no": "TH-0006",
        "work_order_id_ref": "WO_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-01",
        "checked_on": "2026-11-18",
        "length_meters": 80,
        "grade": "A",
        "status": "ready",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_007",
        "roll_no": "TH-0007",
        "work_order_id_ref": "WO_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-02",
        "checked_on": "2026-11-19",
        "length_meters": 87,
        "grade": "A",
        "status": "accepted",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_008",
        "roll_no": "TH-0008",
        "work_order_id_ref": "WO_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-02",
        "checked_on": "2026-11-19",
        "length_meters": 84,
        "grade": "A",
        "status": "accepted",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_009",
        "roll_no": "TH-0009",
        "work_order_id_ref": "WO_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-02",
        "checked_on": "2026-11-19",
        "length_meters": 86,
        "grade": "A",
        "status": "ready",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_010",
        "roll_no": "TH-0010",
        "work_order_id_ref": "WO_YAQOOB",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-02",
        "checked_on": "2026-11-19",
        "length_meters": 83,
        "grade": "A",
        "status": "ready",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_011",
        "roll_no": "TH-0011",
        "work_order_id_ref": "WO_REHMAN",
        "fabric_stock_id_ref": "F_7668",
        "loom_no": "L-03",
        "checked_on": "2026-11-20",
        "length_meters": 71,
        "grade": "A",
        "status": "accepted",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_012",
        "roll_no": "TH-0012",
        "work_order_id_ref": "WO_REHMAN",
        "fabric_stock_id_ref": "F_7668",
        "loom_no": "L-03",
        "checked_on": "2026-11-20",
        "length_meters": 72,
        "grade": "A",
        "status": "returned_hold",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_013",
        "roll_no": "TH-0013",
        "work_order_id_ref": "WO_REHMAN",
        "fabric_stock_id_ref": "F_7668",
        "loom_no": "L-03",
        "checked_on": "2026-11-20",
        "length_meters": 70,
        "grade": "A",
        "status": "accepted",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_014",
        "roll_no": "TH-0014",
        "work_order_id_ref": "WO_REHMAN",
        "fabric_stock_id_ref": "F_7668",
        "loom_no": "L-03",
        "checked_on": "2026-11-20",
        "length_meters": 73,
        "grade": "A",
        "status": "ready",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_015",
        "roll_no": "TH-0015",
        "work_order_id_ref": "WO_REHMAN",
        "fabric_stock_id_ref": "F_7668",
        "loom_no": "L-03",
        "checked_on": "2026-11-20",
        "length_meters": 74,
        "grade": "A",
        "status": "ready",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_016",
        "roll_no": "TH-0016",
        "work_order_id_ref": "WO_SAEED",
        "fabric_stock_id_ref": "F_5252",
        "loom_no": "L-04",
        "checked_on": "2026-11-21",
        "length_meters": 75,
        "grade": "A",
        "status": "dispatched",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_017",
        "roll_no": "TH-0017",
        "work_order_id_ref": "WO_SAEED",
        "fabric_stock_id_ref": "F_5252",
        "loom_no": "L-04",
        "checked_on": "2026-11-21",
        "length_meters": 76,
        "grade": "A",
        "status": "dispatched",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_018",
        "roll_no": "TH-0018",
        "work_order_id_ref": "WO_SAEED",
        "fabric_stock_id_ref": "F_5252",
        "loom_no": "L-04",
        "checked_on": "2026-11-21",
        "length_meters": 74,
        "grade": "A",
        "status": "ready",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_019",
        "roll_no": "TH-0019",
        "work_order_id_ref": "WO_SAEED",
        "fabric_stock_id_ref": "F_5252",
        "loom_no": "L-04",
        "checked_on": "2026-11-21",
        "length_meters": 77,
        "grade": "A",
        "status": "ready",
        "owner_type": "customer",
        "notes": null
      },
      {
        "ref": "TH_020",
        "roll_no": "TH-0020",
        "work_order_id_ref": "WO_OWN",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-05",
        "checked_on": "2026-11-22",
        "length_meters": 88,
        "grade": "A",
        "status": "dispatched",
        "owner_type": "factory",
        "notes": "Apna maal: FAR-017/26 se sale"
      },
      {
        "ref": "TH_021",
        "roll_no": "TH-0021",
        "work_order_id_ref": "WO_OWN",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-05",
        "checked_on": "2026-11-22",
        "length_meters": 85,
        "grade": "A",
        "status": "dispatched",
        "owner_type": "factory",
        "notes": "Apna maal: FAR-017/26 se sale"
      },
      {
        "ref": "TH_022",
        "roll_no": "TH-0022",
        "work_order_id_ref": "WO_OWN",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-05",
        "checked_on": "2026-11-22",
        "length_meters": 89,
        "grade": "A",
        "status": "ready",
        "owner_type": "factory",
        "notes": null
      },
      {
        "ref": "TH_023",
        "roll_no": "TH-0023",
        "work_order_id_ref": "WO_OWN",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-05",
        "checked_on": "2026-11-22",
        "length_meters": 86,
        "grade": "A",
        "status": "ready",
        "owner_type": "factory",
        "notes": null
      },
      {
        "ref": "TH_024",
        "roll_no": "TH-0024",
        "work_order_id_ref": "WO_OWN",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-05",
        "checked_on": "2026-11-22",
        "length_meters": 87,
        "grade": "A",
        "status": "ready",
        "owner_type": "factory",
        "notes": null
      },
      {
        "ref": "TH_025",
        "roll_no": "TH-0025",
        "work_order_id_ref": "WO_OWN",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-06",
        "checked_on": "2026-11-22",
        "length_meters": 90,
        "grade": "A",
        "status": "ready",
        "owner_type": "factory",
        "notes": null
      },
      {
        "ref": "TH_026",
        "roll_no": "TH-0026",
        "work_order_id_ref": "WO_OWN",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-06",
        "checked_on": "2026-11-22",
        "length_meters": 88,
        "grade": "A",
        "status": "ready",
        "owner_type": "factory",
        "notes": null
      },
      {
        "ref": "TH_027",
        "roll_no": "TH-0027",
        "work_order_id_ref": "WO_OWN",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-06",
        "checked_on": "2026-11-22",
        "length_meters": 91,
        "grade": "A",
        "status": "ready",
        "owner_type": "factory",
        "notes": null
      },
      {
        "ref": "TH_028",
        "roll_no": "TH-0028",
        "work_order_id_ref": "WO_OWN",
        "fabric_stock_id_ref": "F_6060",
        "loom_no": "L-06",
        "checked_on": "2026-11-22",
        "length_meters": 89,
        "grade": "A",
        "status": "ready",
        "owner_type": "factory",
        "notes": null
      }
    ],
    "part_issuances": [
      {
        "ref": "PI01",
        "part_id_ref": "PART_PICKER",
        "loom_no": "L-01",
        "issued_to_person": "Ustad Aslam",
        "quantity": 2,
        "unit_price": 480,
        "total_cost": 960,
        "issuance_date": "2026-11-20"
      },
      {
        "ref": "PI02",
        "part_id_ref": "PART_BELT",
        "loom_no": "L-04",
        "issued_to_person": "Ustad Nadeem",
        "quantity": 1,
        "unit_price": 1850,
        "total_cost": 1850,
        "issuance_date": "2026-11-21"
      }
    ],
    "loom_stoppages": [
      {
        "ref": "STOP01",
        "loom_no": "L-04",
        "work_order_id_ref": "WO_SAEED",
        "stopped_on": "2026-11-20",
        "downtime_minutes": 45,
        "reason": "Belt kharab",
        "repair_cost": 1850,
        "notes": "Belt store se issue ki"
      },
      {
        "ref": "STOP02",
        "loom_no": "L-01",
        "work_order_id_ref": "WO_YAQOOB",
        "stopped_on": "2026-11-21",
        "downtime_minutes": 25,
        "reason": "Picker change",
        "repair_cost": 960,
        "notes": "2 Picker issue"
      }
    ],
    "factory_worker_wages": [
      {
        "ref": "WAGE01",
        "worker_name": "Ustad Aslam",
        "work_order_id_ref": "WO_YAQOOB",
        "loom_no": "L-01",
        "wage_date": "2026-11-21",
        "basis": "day",
        "quantity": 5,
        "rate": 1800,
        "gross_amount": 9000,
        "advance_adjustment": 1000,
        "paid_amount": 8000,
        "balance_amount": 0,
        "notes": "Ujrat; alag wage register"
      },
      {
        "ref": "WAGE02",
        "worker_name": "Ustad Nadeem",
        "work_order_id_ref": "WO_SAEED",
        "loom_no": "L-04",
        "wage_date": "2026-11-22",
        "basis": "day",
        "quantity": 4,
        "rate": 1900,
        "gross_amount": 7600,
        "advance_adjustment": 0,
        "paid_amount": 4000,
        "balance_amount": 3600,
        "notes": "Mazdoori baqaya"
      }
    ],
    "kachi_parchis": [
      {
        "ref": "K_01",
        "parchi_no": "KCH-0261",
        "work_order_id_ref": "WO_YAQOOB",
        "dispatch_date": "2026-11-20",
        "dispatched_meters": 332,
        "thaan_count": 4,
        "vehicle_no": "FSD-2854",
        "notes": "Thaan ginti aur meter checking se auto"
      },
      {
        "ref": "K_02",
        "parchi_no": "KCH-0262",
        "work_order_id_ref": "WO_YAQOOB",
        "dispatch_date": "2026-11-21",
        "dispatched_meters": 171,
        "thaan_count": 2,
        "vehicle_no": null,
        "notes": "Thaan ginti aur meter checking se auto"
      },
      {
        "ref": "K_03",
        "parchi_no": "KCH-0263",
        "work_order_id_ref": "WO_REHMAN",
        "dispatch_date": "2026-11-22",
        "dispatched_meters": 213,
        "thaan_count": 3,
        "vehicle_no": null,
        "notes": "Thaan ginti aur meter checking se auto"
      },
      {
        "ref": "K_04",
        "parchi_no": "KCH-0264",
        "work_order_id_ref": "WO_YAQOOB",
        "dispatch_date": "2026-11-24",
        "dispatched_meters": 84,
        "thaan_count": 1,
        "vehicle_no": null,
        "notes": "Resend rejected thaan; nayi Kachi"
      },
      {
        "ref": "K_05",
        "parchi_no": "KCH-0265",
        "work_order_id_ref": "WO_SAEED",
        "dispatch_date": "2026-11-24",
        "dispatched_meters": 151,
        "thaan_count": 2,
        "vehicle_no": null,
        "notes": "Thaan ginti aur meter checking se auto"
      }
    ],
    "kachi_parchi_items": [
      {
        "ref": "K_01_TH_001",
        "kachi_parchi_id_ref": "K_01",
        "thaan_roll_id_ref": "TH_001",
        "length_meters": 85
      },
      {
        "ref": "K_01_TH_002",
        "kachi_parchi_id_ref": "K_01",
        "thaan_roll_id_ref": "TH_002",
        "length_meters": 82
      },
      {
        "ref": "K_01_TH_003",
        "kachi_parchi_id_ref": "K_01",
        "thaan_roll_id_ref": "TH_003",
        "length_meters": 84
      },
      {
        "ref": "K_01_TH_004",
        "kachi_parchi_id_ref": "K_01",
        "thaan_roll_id_ref": "TH_004",
        "length_meters": 81
      },
      {
        "ref": "K_02_TH_007",
        "kachi_parchi_id_ref": "K_02",
        "thaan_roll_id_ref": "TH_007",
        "length_meters": 87
      },
      {
        "ref": "K_02_TH_008",
        "kachi_parchi_id_ref": "K_02",
        "thaan_roll_id_ref": "TH_008",
        "length_meters": 84
      },
      {
        "ref": "K_03_TH_011",
        "kachi_parchi_id_ref": "K_03",
        "thaan_roll_id_ref": "TH_011",
        "length_meters": 71
      },
      {
        "ref": "K_03_TH_012",
        "kachi_parchi_id_ref": "K_03",
        "thaan_roll_id_ref": "TH_012",
        "length_meters": 72
      },
      {
        "ref": "K_03_TH_013",
        "kachi_parchi_id_ref": "K_03",
        "thaan_roll_id_ref": "TH_013",
        "length_meters": 70
      },
      {
        "ref": "K_04_TH_003",
        "kachi_parchi_id_ref": "K_04",
        "thaan_roll_id_ref": "TH_003",
        "length_meters": 84
      },
      {
        "ref": "K_05_TH_016",
        "kachi_parchi_id_ref": "K_05",
        "thaan_roll_id_ref": "TH_016",
        "length_meters": 75
      },
      {
        "ref": "K_05_TH_017",
        "kachi_parchi_id_ref": "K_05",
        "thaan_roll_id_ref": "TH_017",
        "length_meters": 76
      }
    ],
    "thaan_returns": [
      {
        "ref": "RET01",
        "kachi_parchi_id_ref": "K_01",
        "thaan_roll_id_ref": "TH_003",
        "returned_on": "2026-11-23"
      },
      {
        "ref": "RET02",
        "kachi_parchi_id_ref": "K_03",
        "thaan_roll_id_ref": "TH_012",
        "returned_on": "2026-11-24"
      }
    ],
    "thaan_dispositions": [
      {
        "ref": "DSP01",
        "thaan_roll_id_ref": "TH_003",
        "from_work_order_id_ref": "WO_YAQOOB",
        "action": "resend_a",
        "action_date": "2026-11-24",
        "notes": "Original Thaan 0003, 84m; new Kachi KCH-0264"
      }
    ],
    "pakki_parchis": [
      {
        "ref": "PK_01",
        "parchi_no": "PKK-0261",
        "kachi_parchi_id_ref": "K_01",
        "received_date": "2026-11-23",
        "accepted_thaans": 3,
        "accepted_meters": 248,
        "rejected_meters": 84,
        "bill_amount": 7440.0,
        "notes": "Pakki: sirf accepted Thaan ginti aur metres"
      },
      {
        "ref": "PK_02",
        "parchi_no": "PKK-0262",
        "kachi_parchi_id_ref": "K_02",
        "received_date": "2026-11-23",
        "accepted_thaans": 2,
        "accepted_meters": 171,
        "rejected_meters": 0,
        "bill_amount": 5130.0,
        "notes": "Pakki: sirf accepted Thaan ginti aur metres"
      },
      {
        "ref": "PK_03",
        "parchi_no": "PKK-0263",
        "kachi_parchi_id_ref": "K_03",
        "received_date": "2026-11-24",
        "accepted_thaans": 2,
        "accepted_meters": 141,
        "rejected_meters": 72,
        "bill_amount": 4314.6,
        "notes": "Pakki: sirf accepted Thaan ginti aur metres"
      },
      {
        "ref": "PK_04",
        "parchi_no": "PKK-0264",
        "kachi_parchi_id_ref": "K_04",
        "received_date": "2026-11-25",
        "accepted_thaans": 1,
        "accepted_meters": 84,
        "rejected_meters": 0,
        "bill_amount": 2520.0,
        "notes": "Pakki: sirf accepted Thaan ginti aur metres"
      }
    ],
    "invoices": [
      {
        "ref": "INV_01",
        "invoice_no": "INV-0261",
        "customer_id_ref": "C_YAQOOB",
        "invoice_date": "2026-11-23",
        "subtotal": 7440.0,
        "discount": 0,
        "total": 7440.0,
        "status": "issued",
        "notes": "Faisalabad kapra hisaab",
        "sales_contract_id_ref": "SC_YAQOOB"
      },
      {
        "ref": "INV_02",
        "invoice_no": "INV-0262",
        "customer_id_ref": "C_YAQOOB",
        "invoice_date": "2026-11-23",
        "subtotal": 5130.0,
        "discount": 0,
        "total": 5130.0,
        "status": "issued",
        "notes": "Faisalabad kapra hisaab",
        "sales_contract_id_ref": "SC_YAQOOB"
      },
      {
        "ref": "INV_03",
        "invoice_no": "INV-0263",
        "customer_id_ref": "C_REHMAN",
        "invoice_date": "2026-11-24",
        "subtotal": 4314.6,
        "discount": 0,
        "total": 4314.6,
        "status": "issued",
        "notes": "Faisalabad kapra hisaab",
        "sales_contract_id_ref": "SC_REHMAN"
      },
      {
        "ref": "INV_04",
        "invoice_no": "INV-0264",
        "customer_id_ref": "C_YAQOOB",
        "invoice_date": "2026-11-25",
        "subtotal": 2520.0,
        "discount": 0,
        "total": 2520.0,
        "status": "issued",
        "notes": "Faisalabad kapra hisaab",
        "sales_contract_id_ref": "SC_YAQOOB"
      },
      {
        "ref": "INV_05",
        "invoice_no": "INV-0265",
        "customer_id_ref": "C_AZEEM",
        "invoice_date": "2026-11-23",
        "subtotal": 35465.0,
        "discount": 0,
        "total": 35465.0,
        "status": "issued",
        "notes": "Faisalabad kapra hisaab",
        "sale_id_ref": "SALE_OWN"
      }
    ],
    "invoice_items": [
      {
        "ref": "INV_01_ITEM",
        "invoice_id_ref": "INV_01",
        "description": "Bunai Mazdoori — PKK-0261",
        "quantity": 248,
        "unit": "Meter",
        "rate": 30,
        "amount": 7440.0
      },
      {
        "ref": "INV_02_ITEM",
        "invoice_id_ref": "INV_02",
        "description": "Bunai Mazdoori — PKK-0262",
        "quantity": 171,
        "unit": "Meter",
        "rate": 30,
        "amount": 5130.0
      },
      {
        "ref": "INV_03_ITEM",
        "invoice_id_ref": "INV_03",
        "description": "Bunai Mazdoori — PKK-0263",
        "quantity": 141,
        "unit": "Meter",
        "rate": 30.6,
        "amount": 4314.6
      },
      {
        "ref": "INV_04_ITEM",
        "invoice_id_ref": "INV_04",
        "description": "Bunai Mazdoori — Pakki resend",
        "quantity": 84,
        "unit": "Meter",
        "rate": 30,
        "amount": 2520.0
      },
      {
        "ref": "INV_05_ITEM",
        "invoice_id_ref": "INV_05",
        "description": "Apna Grey Kapra — 60×60 / 63 Panna",
        "quantity": 173,
        "unit": "Meter",
        "rate": 205,
        "amount": 35465.0
      }
    ],
    "payment_receipts": [
      {
        "ref": "REC_01",
        "receipt_no": "RCP-0261",
        "customer_id_ref": "C_YAQOOB",
        "financial_account_id_ref": "A_BANK",
        "payment_date": "2026-11-24",
        "amount": 10000,
        "method": "bank_transfer",
        "reference": "TR-10231",
        "notes": "Wasooli / Raqam Dakhil"
      },
      {
        "ref": "REC_02",
        "receipt_no": "RCP-0262",
        "customer_id_ref": "C_REHMAN",
        "financial_account_id_ref": "A_CASH",
        "payment_date": "2026-11-25",
        "amount": 3000,
        "method": "cash",
        "reference": null,
        "notes": "Wasooli / Raqam Dakhil"
      },
      {
        "ref": "REC_03",
        "receipt_no": "RCP-0263",
        "customer_id_ref": "C_AZEEM",
        "financial_account_id_ref": "A_BANK",
        "payment_date": "2026-11-25",
        "amount": 10000,
        "method": "bank_transfer",
        "reference": "TR-10232",
        "notes": "Wasooli / Raqam Dakhil"
      }
    ],
    "invoice_payment_allocations": [
      {
        "ref": "ALLOC01",
        "payment_receipt_id_ref": "REC_01",
        "invoice_id_ref": "INV_01",
        "amount": 7440
      },
      {
        "ref": "ALLOC02",
        "payment_receipt_id_ref": "REC_01",
        "invoice_id_ref": "INV_02",
        "amount": 2560
      },
      {
        "ref": "ALLOC03",
        "payment_receipt_id_ref": "REC_02",
        "invoice_id_ref": "INV_03",
        "amount": 3000
      },
      {
        "ref": "ALLOC04",
        "payment_receipt_id_ref": "REC_03",
        "invoice_id_ref": "INV_05",
        "amount": 10000
      }
    ],
    "expenses": [
      {
        "ref": "EXP_BIJLI",
        "financial_account_id_ref": "A_BANK",
        "expense_type": "utility",
        "title": "Bijli ka Bill — November",
        "expense_date": "2026-11-22",
        "amount": 155000,
        "payee": "FESCO",
        "reference": "VCH-BIJLI",
        "notes": "Naqdi/bank adaigi; mukhtasar kharcha entry",
        "fixed_expense_id_ref": "FX_BIJLI"
      },
      {
        "ref": "EXP_MAZDOORI",
        "financial_account_id_ref": "A_CASH",
        "expense_type": "labour",
        "title": "Office Staff Ujrat",
        "expense_date": "2026-11-23",
        "amount": 32500,
        "payee": "Office Staff",
        "reference": "VCH-MAZDOORI",
        "notes": "Naqdi/bank adaigi; mukhtasar kharcha entry"
      },
      {
        "ref": "EXP_MARAMMAT",
        "financial_account_id_ref": "A_CASH",
        "expense_type": "repair",
        "title": "Loom Marammat",
        "expense_date": "2026-11-24",
        "amount": 8500,
        "payee": "Nawab Loom Parts",
        "reference": "VCH-MARAMMAT",
        "notes": "Naqdi/bank adaigi; mukhtasar kharcha entry"
      },
      {
        "ref": "EXP_KIRAYA",
        "financial_account_id_ref": "A_CASH",
        "expense_type": "transport",
        "title": "Transport Kiraya",
        "expense_date": "2026-11-25",
        "amount": 6500,
        "payee": "Maal Bardari",
        "reference": "VCH-KIRAYA",
        "notes": "Naqdi/bank adaigi; mukhtasar kharcha entry"
      }
    ],
    "account_transactions": [
      {
        "ref": "AT_REC1",
        "financial_account_id_ref": "A_BANK",
        "transaction_date": "2026-11-24",
        "direction": "in",
        "amount": 10000,
        "description": "Wasooli — Haji Yaqoob",
        "party_name": "Haji Yaqoob Grey Cloth",
        "payment_receipt_id_ref": "REC_01"
      },
      {
        "ref": "AT_REC2",
        "financial_account_id_ref": "A_CASH",
        "transaction_date": "2026-11-25",
        "direction": "in",
        "amount": 3000,
        "description": "Wasooli — Rehman",
        "party_name": "Rehman Kapra Merchants",
        "payment_receipt_id_ref": "REC_02"
      },
      {
        "ref": "AT_REC3",
        "financial_account_id_ref": "A_BANK",
        "transaction_date": "2026-11-25",
        "direction": "in",
        "amount": 10000,
        "description": "Wasooli — Azeem",
        "party_name": "Azeem Cloth Traders",
        "payment_receipt_id_ref": "REC_03"
      },
      {
        "ref": "AT_EXP1",
        "financial_account_id_ref": "A_BANK",
        "transaction_date": "2026-11-22",
        "direction": "out",
        "amount": 155000,
        "description": "Bijli ka Bill",
        "party_name": "FESCO",
        "expense_id_ref": "EXP_BIJLI"
      },
      {
        "ref": "AT_EXP2",
        "financial_account_id_ref": "A_CASH",
        "transaction_date": "2026-11-23",
        "direction": "out",
        "amount": 32500,
        "description": "Mazdoor Ujrat",
        "party_name": "Mazdoor Khaata",
        "expense_id_ref": "EXP_MAZDOORI"
      },
      {
        "ref": "AT_EXP3",
        "financial_account_id_ref": "A_CASH",
        "transaction_date": "2026-11-24",
        "direction": "out",
        "amount": 8500,
        "description": "Loom Marammat",
        "party_name": "Nawab Loom Parts",
        "expense_id_ref": "EXP_MARAMMAT"
      },
      {
        "ref": "AT_EXP4",
        "financial_account_id_ref": "A_CASH",
        "transaction_date": "2026-11-25",
        "direction": "out",
        "amount": 6500,
        "description": "Transport Kiraya",
        "party_name": "Maal Bardari",
        "expense_id_ref": "EXP_KIRAYA"
      }
    ]
  },
  "deferred_updates": [
    {
      "table": "pakki_parchis",
      "ref": "PK_01",
      "invoice_id_ref": "INV_01"
    },
    {
      "table": "pakki_parchis",
      "ref": "PK_02",
      "invoice_id_ref": "INV_02"
    },
    {
      "table": "pakki_parchis",
      "ref": "PK_03",
      "invoice_id_ref": "INV_03"
    },
    {
      "table": "pakki_parchis",
      "ref": "PK_04",
      "invoice_id_ref": "INV_04"
    }
  ],
  "proposed_accounts": [
    {
      "name": "Factory Muharrir",
      "email": "operator@loomflow.example.invalid",
      "role": "operator"
    },
    {
      "name": "Factory Malik",
      "email": "owner@loomflow.example.invalid",
      "role": "owner"
    }
  ]
}
LOOMFLOW_TRADITIONAL_FIXTURE_JSON;

    public function run(): void
    {
        if (app()->environment('production')) {
            throw new RuntimeException('Refusing to seed production. This fixture is for development and staging only.');
        }

        $initialAdmin = [
            'name' => trim((string) config('app.initial_admin.name')),
            'email' => trim((string) config('app.initial_admin.email')),
            'password' => (string) config('app.initial_admin.password'),
        ];

        if ($initialAdmin['name'] === '' || filter_var($initialAdmin['email'], FILTER_VALIDATE_EMAIL) === false || strlen($initialAdmin['password']) < 12) {
            throw new RuntimeException('Set LOOMFLOW_INITIAL_ADMIN_NAME, LOOMFLOW_INITIAL_ADMIN_EMAIL, and a password of at least 12 characters in .env before seeding.');
        }

        $fixture = json_decode(self::FIXTURE_JSON, true, 512, JSON_THROW_ON_ERROR);
        $tables = $fixture['tables'] ?? null;

        if (! is_array($tables) || $tables === []) {
            throw new RuntimeException('Fixture must contain a non-empty tables object.');
        }

        $columnsByTable = [];
        foreach ($tables as $table => $rows) {
            if (! Schema::hasTable($table)) {
                throw new RuntimeException("Missing table {$table}. Run the application's real migrations first.");
            }

            $columnsByTable[$table] = array_flip(Schema::getColumnListing($table));
            foreach ($rows as $row) {
                foreach ($row as $field => $value) {
                    if ($field === 'ref') {
                        continue;
                    }

                    $column = str_ends_with($field, '_ref') ? substr($field, 0, -4) : $field;
                    if (! isset($columnsByTable[$table][$column])) {
                        throw new RuntimeException("Schema mismatch: {$table}.{$column}. Compare the fixture against the migrations.");
                    }
                }
            }
        }

        foreach (['ledgers', 'fabric_stock_movements'] as $derivedTable) {
            if (! Schema::hasTable($derivedTable)) {
                throw new RuntimeException("Missing table {$derivedTable}. Run the application's real migrations first.");
            }
        }

        $alreadySeeded = false;
        DB::transaction(function () use ($tables, $fixture, $columnsByTable, $initialAdmin, &$alreadySeeded): void {
            $baseTablesAreEmpty = true;
            foreach (array_keys($tables) as $table) {
                if (DB::table($table)->exists()) {
                    $baseTablesAreEmpty = false;
                    break;
                }
            }

            $references = [];
            if ($baseTablesAreEmpty) {
                if (DB::table('ledgers')->exists() || DB::table('fabric_stock_movements')->exists()) {
                    throw new RuntimeException('Ledger or fabric movement data already exists without the sample base records; refusing to overwrite it.');
                }

                $references = $this->importFixture($tables, $fixture, $columnsByTable);
            } else {
                $references = $this->resolveFixtureReferences($tables);
                $this->assertExistingFixtureMatches($tables, $references);

                if (DB::table('ledgers')->exists() || DB::table('fabric_stock_movements')->exists()) {
                    if (! $this->derivedRecordsAreComplete($tables, $references)) {
                        throw new RuntimeException('Derived ledgers or fabric movements are partial or differ from this fixture; refusing to duplicate or overwrite them.');
                    }

                    $this->ensureInitialAdmin($initialAdmin);
                    $alreadySeeded = true;

                    return;
                }
            }

            $this->recalculatePartaAndSalesCosts($tables, $references);
            $this->rebuildFabricStockMovements($tables, $references);
            $this->postLedgerEntries($tables, $references);
            $this->ensureInitialAdmin($initialAdmin);

            if (! $this->derivedRecordsAreComplete($tables, $references)) {
                throw new RuntimeException('Application service reconciliation did not match the sample stock and ledger totals; all changes have been rolled back.');
            }
        });

        $this->command?->info($alreadySeeded
            ? 'Traditional sample data and application-derived records are already complete.'
            : 'Traditional sample data, application-derived stock and ledgers, and initial administrator are ready.');
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $tables
     * @param  array<string, mixed>  $fixture
     * @param  array<string, array<string, int>>  $columnsByTable
     * @return array<string, int>
     */
    private function importFixture(array $tables, array $fixture, array $columnsByTable): array
    {
        $references = [];

        foreach ($tables as $table => $rows) {
            foreach ($rows as $row) {
                if (! isset($row['ref']) || ! is_string($row['ref']) || $row['ref'] === '') {
                    throw new RuntimeException("Every row in {$table} must have a non-empty symbolic ref.");
                }

                $payload = [];
                foreach ($row as $field => $value) {
                    if ($field === 'ref') {
                        continue;
                    }

                    $isSymbolicForeignKey = str_ends_with($field, '_ref');
                    $column = $isSymbolicForeignKey ? substr($field, 0, -4) : $field;
                    if ($isSymbolicForeignKey) {
                        if ($value !== null && ! isset($references[$value])) {
                            throw new RuntimeException("Unresolved parent {$value} for {$table}.{$column}");
                        }

                        $payload[$column] = $value === null ? null : $references[$value];

                        continue;
                    }

                    $payload[$column] = $value;
                }

                if (isset($columnsByTable[$table]['created_at'])) {
                    $payload['created_at'] = now();
                }

                if (isset($columnsByTable[$table]['updated_at'])) {
                    $payload['updated_at'] = now();
                }

                $references[$row['ref']] = (int) DB::table($table)->insertGetId($payload);
            }
        }

        foreach ($fixture['deferred_updates'] ?? [] as $update) {
            $table = $update['table'];
            $target = $update['ref'];
            if (! isset($references[$target], $columnsByTable[$table])) {
                throw new RuntimeException("Unresolved deferred update target {$target} for {$table}.");
            }

            $values = [];
            foreach ($update as $field => $symbol) {
                if (in_array($field, ['table', 'ref'], true)) {
                    continue;
                }

                $column = str_ends_with($field, '_ref') ? substr($field, 0, -4) : $field;
                if (! isset($references[$symbol])) {
                    throw new RuntimeException("Unresolved deferred reference {$symbol}.");
                }

                if (! isset($columnsByTable[$table][$column])) {
                    throw new RuntimeException("Missing deferred column {$table}.{$column}.");
                }

                $values[$column] = $references[$symbol];
            }

            DB::table($table)->where('id', $references[$target])->update($values);
        }

        return $references;
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $tables
     * @return array<string, int>
     */
    private function resolveFixtureReferences(array $tables): array
    {
        $references = [];

        foreach ($tables as $table => $rows) {
            $records = DB::table($table)->orderBy('id')->get();
            if ($records->count() !== count($rows)) {
                throw new RuntimeException("{$table} does not contain the exact sample row count; refusing to seed over unrelated data.");
            }

            foreach ($rows as $index => $row) {
                if (! isset($row['ref']) || ! is_string($row['ref']) || $row['ref'] === '') {
                    throw new RuntimeException("Every row in {$table} must have a non-empty symbolic ref.");
                }

                $references[$row['ref']] = (int) $records[$index]->id;
            }
        }

        return $references;
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $tables
     * @param  array<string, int>  $references
     */
    private function assertExistingFixtureMatches(array $tables, array $references): void
    {
        foreach ($tables as $table => $rows) {
            $records = DB::table($table)->orderBy('id')->get();
            $mutableColumns = self::DERIVED_MUTABLE_COLUMNS[$table] ?? [];

            foreach ($rows as $index => $row) {
                $record = $records[$index];
                foreach ($row as $field => $expected) {
                    if ($field === 'ref') {
                        continue;
                    }

                    $symbolicForeignKey = str_ends_with($field, '_ref');
                    $column = $symbolicForeignKey ? substr($field, 0, -4) : $field;
                    if (in_array($column, $mutableColumns, true)) {
                        continue;
                    }

                    if ($symbolicForeignKey) {
                        if ($expected !== null && ! isset($references[$expected])) {
                            throw new RuntimeException("Unresolved fixture reference {$expected} for {$table}.{$column}.");
                        }

                        $expected = $expected === null ? null : $references[$expected];
                    }

                    if (! $this->fixtureValuesMatch($record->{$column}, $expected)) {
                        throw new RuntimeException("Existing row {$table}.{$column} does not match the sample fixture; refusing to seed.");
                    }
                }

                foreach (self::FIXTURE_IDENTITY_COLUMNS[$table] ?? [] as $column) {
                    if (! $this->fixtureValuesMatch($record->{$column}, $row[$column] ?? null)) {
                        throw new RuntimeException("Existing {$table} identities are not in fixture order; refusing to guess reference IDs.");
                    }
                }
            }
        }
    }

    private function fixtureValuesMatch(mixed $actual, mixed $expected): bool
    {
        if ($expected === null) {
            return $actual === null;
        }

        if (is_bool($expected)) {
            return (bool) $actual === $expected;
        }

        if (is_numeric($actual) && is_numeric($expected)) {
            return abs((float) $actual - (float) $expected) < 0.0001;
        }

        return (string) $actual === (string) $expected;
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $tables
     * @param  array<string, int>  $references
     */
    private function recalculatePartaAndSalesCosts(array $tables, array $references): void
    {
        $partaService = app(PartaService::class);
        $costByFabricReference = [];
        $versionByFabricReference = [];

        foreach ($tables['parta_records'] ?? [] as $row) {
            $calculated = $partaService->calculate($row);
            $partaId = $references[$row['ref']];
            $fabricId = $references[$row['fabric_stock_id_ref']];
            DB::table('parta_records')->where('id', $partaId)->update($calculated);
            DB::table('fabric_stocks')->where('id', $fabricId)->update([
                'read' => $row['read'],
                'pick' => $row['pick'],
                'width_inches' => $row['width_inches'],
                'warp_count' => $row['warp_count'],
                'weft_count' => $row['weft_count'],
                'warp_weight_per_meter_lb' => $calculated['warp_lb_per_meter'],
                'weft_weight_per_meter_lb' => $calculated['weft_lb_per_meter'],
                'total_weight_per_meter_lb' => $calculated['total_lb_per_meter'],
                'unit_cost_meter' => $calculated['cost_per_meter'],
            ]);

            $fabricReference = $row['fabric_stock_id_ref'];
            if (! isset($versionByFabricReference[$fabricReference]) || (int) $row['version'] >= $versionByFabricReference[$fabricReference]) {
                $versionByFabricReference[$fabricReference] = (int) $row['version'];
                $costByFabricReference[$fabricReference] = (float) $calculated['cost_per_meter'];
            }
        }

        foreach ($tables['sales'] ?? [] as $row) {
            $fabricReference = $row['fabric_stock_id_ref'];
            if (! isset($costByFabricReference[$fabricReference])) {
                throw new RuntimeException("No Parta cost exists for sale {$row['ref']}.");
            }

            $costPerMeter = $costByFabricReference[$fabricReference];
            DB::table('sales')->where('id', $references[$row['ref']])->update([
                'cost_per_meter' => $costPerMeter,
                'cost_of_goods_sold' => round((float) $row['meters_sold'] * $costPerMeter, 2),
            ]);
        }
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $tables
     * @param  array<string, int>  $references
     */
    private function rebuildFabricStockMovements(array $tables, array $references): void
    {
        if (DB::table('fabric_stock_movements')->exists()) {
            throw new RuntimeException('Fabric movements already exist; refusing to replay stock events.');
        }

        foreach ($tables['fabric_stocks'] as $row) {
            DB::table('fabric_stocks')->where('id', $references[$row['ref']])->update([
                'current_stock_meters' => 0,
                'committed_contract_meters' => 0,
                'available_open_meters' => 0,
                'daily_received_meters' => 0,
                'total_rolls_in_stock' => 0,
            ]);
        }

        $events = $this->stockEvents($tables, $references);
        $stockService = app(FactoryStockService::class);
        foreach ($events as $event) {
            $stockService->move(
                FabricStock::findOrFail($event['fabric_stock_id']),
                $event['meters'],
                $event['roll_delta'],
                $event['date'],
                $event['note'],
                $event['movement_type']
            );
        }

        $dailyReceiptsByFabric = [];
        foreach ($events as $event) {
            if ($event['movement_type'] === 'receipt' && $event['date'] === now()->toDateString()) {
                $dailyReceiptsByFabric[$event['fabric_stock_id']] = ($dailyReceiptsByFabric[$event['fabric_stock_id']] ?? 0) + $event['meters'];
            }
        }

        foreach ($tables['fabric_stocks'] as $row) {
            $fabricId = $references[$row['ref']];
            DB::table('fabric_stocks')->where('id', $fabricId)->update([
                'daily_received_meters' => round((float) ($dailyReceiptsByFabric[$fabricId] ?? 0), 2),
            ]);
        }

        if (! $this->stockMovementsMatch($tables, $references, $events) || ! $this->stockSnapshotsMatch($tables, $references)) {
            throw new RuntimeException('Replayed fabric movements do not reconcile with the sample ending balances.');
        }
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $tables
     * @param  array<string, int>  $references
     * @return array<int, array{date: string, priority: int, fabric_stock_id: int, meters: float, roll_delta: int, movement_type: string, note: string}>
     */
    private function stockEvents(array $tables, array $references): array
    {
        $events = [];
        $rollsByReference = [];
        $kachisByReference = [];

        foreach ($tables['thaan_rolls'] ?? [] as $roll) {
            $rollsByReference[$roll['ref']] = $roll;
            $events[] = [
                'date' => $roll['checked_on'],
                'priority' => 0,
                'fabric_stock_id' => $references[$roll['fabric_stock_id_ref']],
                'meters' => (float) $roll['length_meters'],
                'roll_delta' => 1,
                'movement_type' => 'receipt',
                'note' => 'Traditional sample checking '.$roll['roll_no'],
            ];
        }

        foreach ($tables['kachi_parchis'] ?? [] as $kachi) {
            $kachisByReference[$kachi['ref']] = $kachi;
        }

        foreach ($tables['kachi_parchi_items'] ?? [] as $item) {
            $kachi = $kachisByReference[$item['kachi_parchi_id_ref']] ?? null;
            $roll = $rollsByReference[$item['thaan_roll_id_ref']] ?? null;
            if (! $kachi || ! $roll || abs((float) $item['length_meters'] - (float) $roll['length_meters']) > 0.01) {
                throw new RuntimeException("Kachi item {$item['ref']} does not match its original Thaan length.");
            }

            $events[] = [
                'date' => $kachi['dispatch_date'],
                'priority' => 2,
                'fabric_stock_id' => $references[$roll['fabric_stock_id_ref']],
                'meters' => -(float) $item['length_meters'],
                'roll_delta' => -1,
                'movement_type' => 'dispatch',
                'note' => 'Traditional sample Kachi '.$kachi['parchi_no'].' / '.$roll['roll_no'],
            ];
        }

        foreach ($tables['thaan_returns'] ?? [] as $return) {
            $roll = $rollsByReference[$return['thaan_roll_id_ref']] ?? null;
            if (! $roll) {
                throw new RuntimeException("Return {$return['ref']} references a missing Thaan.");
            }

            $events[] = [
                'date' => $return['returned_on'],
                'priority' => 1,
                'fabric_stock_id' => $references[$roll['fabric_stock_id_ref']],
                'meters' => (float) $roll['length_meters'],
                'roll_delta' => 1,
                'movement_type' => 'return',
                'note' => 'Traditional sample rejected return '.$roll['roll_no'],
            ];
        }

        foreach ($tables['sales'] ?? [] as $sale) {
            $events[] = [
                'date' => $sale['sale_date'],
                'priority' => 3,
                'fabric_stock_id' => $references[$sale['fabric_stock_id_ref']],
                'meters' => -(float) $sale['meters_sold'],
                'roll_delta' => -(int) $sale['rolls_sold'],
                'movement_type' => 'dispatch',
                'note' => 'Traditional sample sale '.$sale['slip_no'],
            ];
        }

        usort($events, static fn (array $left, array $right): int => [
            $left['date'], $left['priority'], $left['note'],
        ] <=> [
            $right['date'], $right['priority'], $right['note'],
        ]);

        return $events;
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $tables
     * @param  array<string, int>  $references
     */
    private function postLedgerEntries(array $tables, array $references): void
    {
        $posting = app(LedgerPostingService::class);
        foreach ($tables['financial_accounts'] ?? [] as $account) {
            $amount = (float) $account['opening_balance'];
            if ($amount <= 0) {
                continue;
            }

            $accountId = $references[$account['ref']];
            $voucher = 'OPEN-ACC-'.$accountId;
            $date = now()->toDateString();
            $posting->post('account_opening_balance', $accountId, [
                $this->ledgerLine('account', $account['name'], 'cash_bank', $date, $voucher, 'Cash/bank opening balance', $amount, 0, null),
                $this->ledgerLine('equity', 'Opening Balance Equity', 'equity', $date, $voucher, 'Opening cash/bank balance', 0, $amount, null),
            ]);
        }

        foreach ($tables['bag_purchases'] ?? [] as $purchase) {
            $amount = (float) $purchase['total_amount'];
            $posting->post('bag_purchase', $references[$purchase['ref']], [
                $this->ledgerLine('supplier', $purchase['supplier_name'], 'yarn_supplier', $purchase['purchase_date'], $purchase['challan_no'], "Yarn Purchase: {$purchase['total_bags']} bags ({$purchase['quality']}) @ Rs. {$purchase['rate_per_bag']}", 0, $amount, $purchase['notes'] ?? null),
                $this->ledgerLine('inventory', 'Yarn Inventory', 'inventory', $purchase['purchase_date'], $purchase['challan_no'], 'Yarn inventory received', $amount, 0, $purchase['notes'] ?? null),
            ]);
        }

        $partsByReference = [];
        $issuedByPartReference = [];
        foreach ($tables['parts'] ?? [] as $part) {
            $partsByReference[$part['ref']] = $part;
        }
        foreach ($tables['part_issuances'] ?? [] as $issuance) {
            $issuedByPartReference[$issuance['part_id_ref']] = ($issuedByPartReference[$issuance['part_id_ref']] ?? 0) + (int) $issuance['quantity'];
        }
        foreach ($tables['parts'] ?? [] as $part) {
            $partId = $references[$part['ref']];
            $openingQuantity = (int) $part['stock_quantity'];
            $issueQuantity = (int) ($issuedByPartReference[$part['ref']] ?? 0);
            if ($openingQuantity < $issueQuantity) {
                throw new RuntimeException("Part {$part['part_code']} has fewer opening units than its sample issues.");
            }

            $openingValue = $openingQuantity * (float) $part['unit_price'];
            if ($openingValue > 0) {
                $date = now()->toDateString();
                $voucher = 'PART-OPEN-'.$partId;
                $posting->post('part_opening_inventory', $partId, [
                    $this->ledgerLine('inventory', 'Parts Inventory', 'inventory', $date, $voucher, 'Opening parts inventory: '.$part['part_name'], $openingValue, 0, $part['part_code']),
                    $this->ledgerLine('equity', 'Opening Inventory Equity', 'equity', $date, $voucher, 'Opening value for parts inventory', 0, $openingValue, $part['part_code']),
                ]);
            }

            DB::table('parts')->where('id', $partId)->update([
                'stock_quantity' => $openingQuantity - $issueQuantity,
            ]);
        }

        foreach ($tables['part_issuances'] ?? [] as $issuance) {
            $part = $partsByReference[$issuance['part_id_ref']];
            $amount = (float) $issuance['total_cost'];
            if ($amount <= 0) {
                continue;
            }

            $voucher = 'PART-ISSUE-'.$references[$issuance['ref']];
            $posting->post('part_issuance', $references[$issuance['ref']], [
                $this->ledgerLine('expense', 'Factory Parts Expense', 'expense', $issuance['issuance_date'], $voucher, 'Parts issued to '.$issuance['loom_no'].': '.$part['part_name'], $amount, 0, $issuance['remarks'] ?? null),
                $this->ledgerLine('inventory', 'Parts Inventory', 'inventory', $issuance['issuance_date'], $voucher, 'Parts issued from inventory: '.$part['part_name'], 0, $amount, $issuance['remarks'] ?? null),
            ]);
        }

        foreach ($tables['sizing_slips'] ?? [] as $slip) {
            $amount = (float) $slip['sizing_bill_amount'];
            if ($amount <= 0) {
                continue;
            }

            $posting->post('sizing_slip', $references[$slip['ref']], [
                $this->ledgerLine('sizing_mill', $slip['sizing_party'], 'sizing_mill', $slip['slip_date'], $slip['slip_no'], 'Sizing service bill for '.$slip['slip_no'], 0, $amount, $slip['notes'] ?? null),
                $this->ledgerLine('expense', 'Sizing Service Expense', 'expense', $slip['slip_date'], $slip['slip_no'], 'Sizing service expense for '.$slip['slip_no'], $amount, 0, $slip['notes'] ?? null),
            ]);
        }

        foreach ($tables['invoices'] ?? [] as $invoice) {
            if (isset($invoice['sale_id_ref'])) {
                continue;
            }

            $customerId = $references[$invoice['customer_id_ref']];
            $customer = $this->rowByReference($tables['customers'], $invoice['customer_id_ref']);
            $amount = (float) $invoice['total'];
            $posting->post('invoice', $references[$invoice['ref']], [
                $this->ledgerLine('customer', $customer['name'], 'fabric_buyer', $invoice['invoice_date'], $invoice['invoice_no'], 'Invoice issued to customer', $amount, 0, $invoice['notes'] ?? null, $customerId),
                $this->ledgerLine('revenue', 'Fabric Sales Revenue', 'income', $invoice['invoice_date'], $invoice['invoice_no'], 'Revenue from customer invoice', 0, $amount, $invoice['notes'] ?? null),
            ]);
        }

        foreach ($tables['sales'] ?? [] as $sale) {
            $customerId = $references[$sale['customer_id_ref']];
            $customer = $this->rowByReference($tables['customers'], $sale['customer_id_ref']);
            $amount = (float) $sale['net_total'];
            $cost = (float) DB::table('sales')->where('id', $references[$sale['ref']])->value('cost_of_goods_sold');
            $lines = [
                $this->ledgerLine('buyer', $customer['name'], 'fabric_buyer', $sale['sale_date'], $sale['slip_no'], 'Own-fabric sale', $amount, 0, $sale['notes'] ?? null, $customerId),
                $this->ledgerLine('revenue', 'Fabric Sales Revenue', 'income', $sale['sale_date'], $sale['slip_no'], 'Own-fabric sale', 0, $amount, $sale['notes'] ?? null),
            ];
            if ($cost > 0) {
                $lines[] = $this->ledgerLine('cost_of_goods_sold', 'Cost of Goods Sold', 'expense', $sale['sale_date'], $sale['slip_no'], 'Own-fabric cost', $cost, 0, null);
                $lines[] = $this->ledgerLine('inventory', 'Finished Fabric Inventory', 'inventory', $sale['sale_date'], $sale['slip_no'], 'Own-fabric cost released', 0, $cost, null);
            }

            $posting->post('sale', $references[$sale['ref']], $lines);
        }

        foreach ($tables['payment_receipts'] ?? [] as $receipt) {
            $account = $this->rowByReference($tables['financial_accounts'], $receipt['financial_account_id_ref']);
            $customer = $this->rowByReference($tables['customers'], $receipt['customer_id_ref']);
            $amount = (float) $receipt['amount'];
            $posting->post('payment_receipt', $references[$receipt['ref']], [
                $this->ledgerLine('account', $account['name'], 'cash_bank', $receipt['payment_date'], $receipt['receipt_no'], 'Customer payment received into '.$account['name'], $amount, 0, $receipt['notes'] ?? null),
                $this->ledgerLine('customer', $customer['name'], 'fabric_buyer', $receipt['payment_date'], $receipt['receipt_no'], 'Customer receipt applied / held as credit', 0, $amount, $receipt['notes'] ?? null, $references[$receipt['customer_id_ref']]),
            ]);
        }

        foreach ($tables['expenses'] ?? [] as $expense) {
            $account = $this->rowByReference($tables['financial_accounts'], $expense['financial_account_id_ref']);
            $amount = (float) $expense['amount'];
            $voucher = $expense['reference'] ?: 'EXP-'.$references[$expense['ref']];
            $description = ucfirst($expense['expense_type']).' expense: '.$expense['title'];
            $payee = $expense['payee'] ?: 'Expense: '.$expense['title'];
            $posting->post('expense', $references[$expense['ref']], [
                $this->ledgerLine('expense', $payee, 'expense', $expense['expense_date'], $voucher, $description, $amount, 0, $expense['notes'] ?? null),
                $this->ledgerLine('account', $account['name'], 'cash_bank', $expense['expense_date'], $voucher, 'Payment for '.$expense['title'], 0, $amount, $expense['notes'] ?? null),
            ]);
        }
    }

    /**
     * @return array{role: string, party_name: string, party_type: string, transaction_date: string, voucher_no: ?string, description: string, debit: float, credit: float, notes: ?string, customer_id?: int}
     */
    private function ledgerLine(
        string $role,
        string $partyName,
        string $partyType,
        string $date,
        ?string $voucher,
        string $description,
        float $debit,
        float $credit,
        ?string $notes,
        ?int $customerId = null
    ): array {
        $line = [
            'role' => $role,
            'party_name' => $partyName,
            'party_type' => $partyType,
            'transaction_date' => $date,
            'voucher_no' => $voucher,
            'description' => $description,
            'debit' => $debit,
            'credit' => $credit,
            'notes' => $notes,
        ];

        if ($customerId !== null) {
            $line['customer_id'] = $customerId;
        }

        return $line;
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     * @return array<string, mixed>
     */
    private function rowByReference(array $rows, string $reference): array
    {
        foreach ($rows as $row) {
            if (($row['ref'] ?? null) === $reference) {
                return $row;
            }
        }

        throw new RuntimeException("Missing fixture row {$reference}.");
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $tables
     * @param  array<string, int>  $references
     */
    private function derivedRecordsAreComplete(array $tables, array $references): bool
    {
        if (DB::table('ledgers')->count() !== $this->expectedLedgerLineCount($tables)) {
            return false;
        }

        $debits = (float) DB::table('ledgers')->sum('debit');
        $credits = (float) DB::table('ledgers')->sum('credit');
        if (abs($debits - $credits) > 0.01) {
            return false;
        }

        $events = $this->stockEvents($tables, $references);
        if (! $this->stockMovementsMatch($tables, $references, $events)
            || ! $this->stockSnapshotsMatch($tables, $references)
            || ! $this->partQuantitiesMatch($tables, $references)) {
            return false;
        }

        return true;
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $tables
     */
    private function expectedLedgerLineCount(array $tables): int
    {
        $lineCount = 0;
        foreach ($tables['financial_accounts'] ?? [] as $account) {
            if ((float) $account['opening_balance'] > 0) {
                $lineCount += 2;
            }
        }
        $lineCount += count($tables['bag_purchases'] ?? []) * 2;
        foreach ($tables['parts'] ?? [] as $part) {
            if ((int) $part['stock_quantity'] * (float) $part['unit_price'] > 0) {
                $lineCount += 2;
            }
        }
        foreach ($tables['part_issuances'] ?? [] as $issuance) {
            if ((float) $issuance['total_cost'] > 0) {
                $lineCount += 2;
            }
        }
        foreach ($tables['sizing_slips'] ?? [] as $slip) {
            if ((float) $slip['sizing_bill_amount'] > 0) {
                $lineCount += 2;
            }
        }
        foreach ($tables['invoices'] ?? [] as $invoice) {
            if (! isset($invoice['sale_id_ref'])) {
                $lineCount += 2;
            }
        }
        foreach ($tables['sales'] ?? [] as $sale) {
            $lineCount += 2 + ((float) $sale['cost_of_goods_sold'] > 0 ? 2 : 0);
        }
        $lineCount += count($tables['payment_receipts'] ?? []) * 2;
        $lineCount += count($tables['expenses'] ?? []) * 2;

        return $lineCount;
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $tables
     * @param  array<string, int>  $references
     * @param  array<int, array{date: string, priority: int, fabric_stock_id: int, meters: float, roll_delta: int, movement_type: string, note: string}>  $events
     */
    private function stockMovementsMatch(array $tables, array $references, array $events): bool
    {
        $expected = [];
        $balances = [];

        foreach ($events as $event) {
            $fabricId = $event['fabric_stock_id'];
            $key = $fabricId.'|'.$event['date'];
            $balances[$fabricId] ??= 0.0;
            $expected[$key] ??= [
                'fabric_stock_id' => $fabricId,
                'movement_date' => $event['date'],
                'previous_stock_meters' => $balances[$fabricId],
                'received_meters' => 0.0,
                'returned_meters' => 0.0,
                'dispatch_meters' => 0.0,
                'rolls_received' => 0,
                'rolls_returned' => 0,
                'closing_stock_meters' => 0.0,
            ];

            if ($event['movement_type'] === 'receipt') {
                $expected[$key]['received_meters'] += max(0, $event['meters']);
                $expected[$key]['rolls_received'] += max(0, $event['roll_delta']);
            } elseif ($event['movement_type'] === 'return') {
                $expected[$key]['returned_meters'] += max(0, $event['meters']);
                $expected[$key]['rolls_returned'] += max(0, $event['roll_delta']);
            }

            $expected[$key]['dispatch_meters'] += max(0, -$event['meters']);
            $balances[$fabricId] = round($balances[$fabricId] + $event['meters'], 2);
            $expected[$key]['closing_stock_meters'] = $balances[$fabricId];
        }

        $fabricIds = array_map(fn (array $row): int => $references[$row['ref']], $tables['fabric_stocks'] ?? []);
        $actualRows = DB::table('fabric_stock_movements')
            ->whereIn('fabric_stock_id', $fabricIds)
            ->get()
            ->keyBy(fn (object $row): string => $row->fabric_stock_id.'|'.substr((string) $row->movement_date, 0, 10));
        if ($actualRows->count() !== count($expected)) {
            return false;
        }

        foreach ($expected as $key => $values) {
            $actual = $actualRows->get($key);
            if (! $actual) {
                return false;
            }

            foreach (['previous_stock_meters', 'received_meters', 'returned_meters', 'dispatch_meters', 'closing_stock_meters'] as $column) {
                if (! $this->fixtureValuesMatch($actual->{$column}, $values[$column])) {
                    return false;
                }
            }

            foreach (['rolls_received', 'rolls_returned'] as $column) {
                if ((int) $actual->{$column} !== $values[$column]) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $tables
     * @param  array<string, int>  $references
     */
    private function stockSnapshotsMatch(array $tables, array $references): bool
    {
        foreach ($tables['fabric_stocks'] ?? [] as $fixtureRow) {
            $actual = DB::table('fabric_stocks')->where('id', $references[$fixtureRow['ref']])->first();
            if (! $actual
                || ! $this->fixtureValuesMatch($actual->current_stock_meters, $fixtureRow['current_stock_meters'])
                || ! $this->fixtureValuesMatch($actual->available_open_meters, $fixtureRow['available_open_meters'])
                || (int) $actual->total_rolls_in_stock !== (int) $fixtureRow['total_rolls_in_stock']) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $tables
     * @param  array<string, int>  $references
     */
    private function partQuantitiesMatch(array $tables, array $references): bool
    {
        $issuesByPart = [];
        foreach ($tables['part_issuances'] ?? [] as $issuance) {
            $issuesByPart[$issuance['part_id_ref']] = ($issuesByPart[$issuance['part_id_ref']] ?? 0) + (int) $issuance['quantity'];
        }

        foreach ($tables['parts'] ?? [] as $part) {
            $expected = (int) $part['stock_quantity'] - (int) ($issuesByPart[$part['ref']] ?? 0);
            $actual = DB::table('parts')->where('id', $references[$part['ref']])->value('stock_quantity');
            if ((int) $actual !== $expected) {
                return false;
            }
        }

        return true;
    }

    /** @param array{name: string, email: string, password: string} $initialAdmin */
    private function ensureInitialAdmin(array $initialAdmin): void
    {
        $user = User::firstOrCreate(
            ['email' => $initialAdmin['email']],
            [
                'name' => $initialAdmin['name'],
                'password' => Hash::make($initialAdmin['password']),
            ]
        );

        if ($user->role !== 'admin') {
            throw new RuntimeException("The email {$initialAdmin['email']} already belongs to a non-admin account.");
        }
    }
}
