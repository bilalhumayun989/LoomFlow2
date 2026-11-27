<?php

namespace App\Http\Controllers;

use App\Models\BagPurchase;
use App\Models\BagTransaction;
use App\Models\Expense;
use App\Models\FabricStock;
use App\Models\Invoice;
use App\Models\KachiParchi;
use App\Models\Ledger;
use App\Models\LoomAssignment;
use App\Models\LoomStoppage;
use App\Models\Part;
use App\Models\Production;
use App\Models\Sale;
use App\Models\SalesContract;
use App\Models\SizingBeam;
use App\Models\SizingSlip;
use App\Models\ThaanRoll;
use App\Models\WorkOrder;
use App\Models\YarnMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $dashboardMode = $request->query('mode') === 'display' ? 'display' : 'operator';

        // 1. Bag Stock summary
        $totalPurchasedBags = BagPurchase::sum('total_bags');

        $bagsToFactory = BagPurchase::sum('bags_to_factory');
        $bagsIssuedToSizing = BagTransaction::where('transaction_type', 'issue_to_sizing')->sum('quantity_bags');
        $bagsReturnedFromSizing = BagTransaction::where('transaction_type', 'return_from_sizing')->sum('quantity_bags');
        $factoryBagStock = max(0, $bagsToFactory - $bagsIssuedToSizing + $bagsReturnedFromSizing);

        $bagsToSizingDirect = BagPurchase::sum('bags_to_sizing');
        $bagsUsedInSizing = SizingSlip::sum('bags_used');
        $sizingBagsInHand = max(0, ($bagsToSizingDirect + $bagsIssuedToSizing) - ($bagsUsedInSizing + $bagsReturnedFromSizing));

        // 2. Sizing & Beams summary
        $activeBeamsCount = SizingBeam::where('status', 'mounted_on_loom')->count();
        $readyBeamsCount = SizingBeam::where('status', 'ready_in_store')->count();
        $totalBeamMetersRemaining = SizingBeam::where('status', 'mounted_on_loom')->sum('remaining_length_meters');
        $sizingSlipCount = SizingSlip::count();
        $totalBeamCount = SizingBeam::count();
        $todayStoppedLoomCount = LoomStoppage::query()->whereDate('stopped_on', today())->distinct()->count('loom_no');

        // 3. Parts summary
        $totalPartsStock = Part::sum('stock_quantity');
        $lowStockPartsCount = Part::whereColumn('stock_quantity', '<=', 'min_alert_threshold')->count();

        // 4. Fabric Stock summary
        $totalFabricStockMeters = FabricStock::sum('current_stock_meters');
        $openFabricMeters = FabricStock::sum('available_open_meters');
        $committedFabricMeters = FabricStock::sum('committed_contract_meters');

        // 5. Sales & Contracts
        $activeContractsCount = SalesContract::where('status', 'active')->count();
        $totalSalesAmount = Sale::sum('net_total');
        $monthExpenseTotal = Expense::whereBetween('expense_date', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])->sum('amount');

        // 6. Production & Efficiency
        $todayProductionMeters = Production::whereDate('production_date', today())->sum('net_meters_produced');
        $totalProductionMeters = Production::sum('net_meters_produced');
        $avgEfficiency = Production::avg('efficiency_percentage') ?? 0;
        $totalLeakageMeters = Production::sum('leakage_waste_meters');
        $monthProductionMeters = Production::query()
            ->whereBetween('production_date', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
            ->sum('net_meters_produced');
        $monthCheckedMeters = ThaanRoll::query()
            ->whereBetween('checked_on', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
            ->sum('length_meters');
        $monthAcceptedMeters = WorkOrder::query()->where('type', 'job')->sum('accepted_meters');

        $activeJobWorkOrders = WorkOrder::query()
            ->with('fabricStock')
            ->where('type', 'job')
            ->where('status', 'active')
            ->orderBy('party_name')
            ->get();
        $activeJobWorkOrderTargetMeters = (float) $activeJobWorkOrders->sum('target_meters');
        $activeJobWorkOrderAcceptedMeters = (float) $activeJobWorkOrders->sum('accepted_meters');

        $yarnStockByQuality = YarnMovement::query()
            ->selectRaw("yarn_count, owner_type, SUM(CASE WHEN movement_type IN ('receipt', 'return', 'adjustment_in') THEN weight_kg WHEN movement_type IN ('issue', 'adjustment_out') THEN -weight_kg ELSE 0 END) as net_movement_kg")
            ->groupBy('yarn_count', 'owner_type')
            ->orderBy('yarn_count')
            ->orderBy('owner_type')
            ->get();
        $recentInvoices = Invoice::query()->with('customer')->latest('invoice_date')->latest('id')->limit(5)->get();
        $recentExpenses = Expense::query()->latest('expense_date')->latest('id')->limit(5)->get();
        $recentDispatches = KachiParchi::query()->with('order')->latest('dispatch_date')->latest('id')->limit(5)->get();
        $recentCheckedRolls = ThaanRoll::query()->with(['fabricStock', 'order'])->latest('checked_on')->latest('id')->limit(5)->get();

        $runningLooms = SizingBeam::with('fabricStock')
            ->where('status', 'mounted_on_loom')->orderBy('assigned_loom_no')->get();
        $activeLoomAssignments = LoomAssignment::with('order.fabricStock')->whereNull('end_date')->orderBy('loom_no')->get();
        $activeContractRows = SalesContract::with('fabricStock')->where('status', 'active')->orderBy('end_date')->get();
        $contractDispatchedMeters = KachiParchi::join('work_orders', 'work_orders.id', '=', 'kachi_parchis.work_order_id')
            ->whereNotNull('work_orders.sales_contract_id')
            ->selectRaw('work_orders.sales_contract_id, SUM(kachi_parchis.dispatched_meters) as dispatched_meters')
            ->groupBy('work_orders.sales_contract_id')->pluck('dispatched_meters', 'sales_contract_id');
        $contractProductionMeters = Production::join('work_orders', 'work_orders.id', '=', 'productions.work_order_id')
            ->whereNotNull('work_orders.sales_contract_id')
            ->selectRaw('work_orders.sales_contract_id, SUM(productions.net_meters_produced) as produced_meters')
            ->groupBy('work_orders.sales_contract_id')->pluck('produced_meters', 'sales_contract_id');
        $jobWorkBalanceMeters = (float) ThaanRoll::where('owner_type', 'customer')
            ->whereIn('status', ['ready', 'returned_ready'])->sum('length_meters');
        $todayCheckedMeters = (float) ThaanRoll::whereDate('checked_on', today())->sum('length_meters');
        $totalAcceptedMeters = (float) WorkOrder::where('type', 'job')->sum('accepted_meters');

        $customerLedgerBalances = Ledger::query()
            ->where('party_type', 'fabric_buyer')
            ->selectRaw('customer_id, party_name, SUM(debit - credit) as balance')
            ->groupBy('customer_id', 'party_name')
            ->get()
            ->groupBy(fn (object $balance): string => $balance->customer_id
                ? 'customer:'.$balance->customer_id
                : 'name:'.mb_strtolower(trim($balance->party_name)))
            ->map(fn (Collection $balances): float => (float) $balances->sum('balance'));
        $receivables = $customerLedgerBalances->sum(fn (float $balance): float => max(0, $balance));

        $payables = Ledger::query()
            ->whereIn('party_type', ['yarn_supplier', 'sizing_mill', 'parts_vendor'])
            ->selectRaw('party_name, party_type, SUM(credit - debit) as balance')
            ->groupBy('party_name', 'party_type')
            ->get()
            ->sum(fn (object $balance): float => max(0, (float) $balance->balance));

        $openInvoices = Invoice::query()
            ->withSum('allocations as received_total', 'amount')
            ->where('status', 'issued')
            ->get()
            ->map(function (Invoice $invoice): Invoice {
                $invoice->setAttribute('outstanding_amount', max(0, round((float) $invoice->total - (float) ($invoice->received_total ?? 0), 2)));

                return $invoice;
            })
            ->filter(fn (Invoice $invoice): bool => $invoice->outstanding_amount > 0)
            ->values();
        $openInvoiceCount = $openInvoices->count();
        $openInvoiceBalance = (float) $openInvoices->sum('outstanding_amount');
        $overdueInvoiceBalance = (float) $openInvoices
            ->filter(fn (Invoice $invoice): bool => $invoice->due_date?->lt(today()) ?? false)
            ->sum('outstanding_amount');

        $fabricInventoryValue = (float) (FabricStock::query()
            ->selectRaw('SUM(current_stock_meters * unit_cost_meter) as total')
            ->value('total') ?? 0);
        $totalLoomCount = count(config('loomflow.looms', []));
        $reportedTodayLoomsCount = Production::query()
            ->whereDate('production_date', today())
            ->distinct()
            ->count('loom_no');

        $pendingPakkiCount = KachiParchi::whereDoesntHave('pakki')->count();
        $pendingPakkiMeters = (float) KachiParchi::whereDoesntHave('pakki')->sum('dispatched_meters');
        $pendingPakkis = $dashboardMode === 'operator'
            ? KachiParchi::query()
                ->with('order.fabricStock')
                ->whereDoesntHave('pakki')
                ->latest('dispatch_date')
                ->latest('id')
                ->limit(5)
                ->get()
            : collect();

        // Recent items for live feed
        $recentPurchases = BagPurchase::latest()->take(3)->get();
        $recentProductions = Production::latest()->take(3)->get();
        $recentSales = Sale::latest()->take(3)->get();

        $dashboardData = compact(
            'dashboardMode',
            'pendingPakkis',
            'receivables',
            'payables',
            'openInvoiceBalance',
            'openInvoiceCount',
            'overdueInvoiceBalance',
            'fabricInventoryValue',
            'totalLoomCount',
            'reportedTodayLoomsCount',
            'totalPurchasedBags',
            'factoryBagStock',
            'sizingBagsInHand',
            'activeBeamsCount',
            'readyBeamsCount',
            'totalBeamMetersRemaining',
            'sizingSlipCount',
            'totalBeamCount',
            'todayStoppedLoomCount',
            'totalPartsStock',
            'lowStockPartsCount',
            'totalFabricStockMeters',
            'openFabricMeters',
            'committedFabricMeters',
            'activeContractsCount',
            'totalSalesAmount',
            'monthExpenseTotal',
            'todayProductionMeters',
            'totalProductionMeters',
            'monthProductionMeters',
            'monthCheckedMeters',
            'monthAcceptedMeters',
            'avgEfficiency',
            'totalLeakageMeters',
            'runningLooms',
            'activeLoomAssignments',
            'todayCheckedMeters',
            'totalAcceptedMeters',
            'activeContractRows',
            'activeJobWorkOrders',
            'activeJobWorkOrderTargetMeters',
            'activeJobWorkOrderAcceptedMeters',
            'contractDispatchedMeters',
            'contractProductionMeters',
            'jobWorkBalanceMeters',
            'pendingPakkiCount',
            'pendingPakkiMeters',
            'recentPurchases',
            'recentProductions',
            'recentSales',
            'yarnStockByQuality',
            'recentInvoices',
            'recentExpenses',
            'recentDispatches',
            'recentCheckedRolls'
        );

        return view(
            $dashboardMode === 'display' ? 'dashboard.hub' : 'dashboard.operator',
            $dashboardData
        );
    }
}
