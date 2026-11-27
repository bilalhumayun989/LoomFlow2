@extends('layouts.app')

@section('title', 'LoomFlow Dashboard')

@section('content')
<div class="mx-auto max-w-[1600px] space-y-5 px-4 py-5 sm:px-6 lg:px-8">
    <header class="flex flex-wrap items-end justify-between gap-4"><div><p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-800">Factory overview · {{ now()->format('d M Y, H:i') }}</p><h1 class="mt-1 text-3xl font-black tracking-tight text-slate-900">LoomFlow Dashboard</h1><p class="mt-1 text-sm text-slate-600">One live view for factory operations, production, stock, sales and accounts.</p></div></header>
    <section class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4" aria-label="Factory status cards">
        <a href="{{ route('production.index') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Looms reported today</p>
            <p class="mt-2 text-2xl font-black">{{ $reportedTodayLoomsCount }} <span class="text-sm text-slate-500">/ {{ $totalLoomCount }}</span></p>
            <p class="text-xs text-slate-500">{{ number_format($todayProductionMeters, 0) }} m produced</p>
        </a>
        <a href="{{ route('production.index') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Looms running</p>
            <p class="mt-2 text-2xl font-black">{{ $activeLoomAssignments->count() }} <span class="text-sm text-slate-500">/ {{ $totalLoomCount }}</span></p>
            <p class="text-xs text-slate-500">{{ max(0, $totalLoomCount - $activeLoomAssignments->count()) }} currently stopped</p>
        </a>
        <a href="{{ route('factory.orders') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Running looms / beams</p>
            <p class="mt-2 text-2xl font-black">{{ $activeLoomAssignments->count() }} / {{ $activeBeamsCount }}</p>
            <p class="text-xs text-slate-500">{{ number_format($totalBeamMetersRemaining, 0) }} m remaining on mounted beams</p>
        </a>
        <a href="{{ route('sizing.index') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Sizing &amp; beams</p>
            <p class="mt-2 text-2xl font-black">{{ $readyBeamsCount }} ready</p>
            <p class="text-xs text-slate-500">{{ $sizingSlipCount }} slips · {{ $totalBeamCount }} total beams</p>
        </a>
        <a href="{{ route('factory.checking') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Checked fabric</p>
            <p class="mt-2 text-2xl font-black">{{ number_format($jobWorkBalanceMeters > 0 ? $jobWorkBalanceMeters : $todayCheckedMeters, 0) }} m</p>
            <p class="text-xs text-slate-500">Actual measured stock</p>
        </a>
        <a href="{{ route('bags.index') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Yarn bags</p>
            <p class="mt-2 text-2xl font-black">{{ number_format($factoryBagStock, 2) }} factory</p>
            <p class="text-xs text-slate-500">{{ number_format($sizingBagsInHand, 2) }} with sizing</p>
        </a>
        <a href="{{ route('fabric.index') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Fabric stock</p>
            <p class="mt-2 text-2xl font-black">{{ number_format($totalFabricStockMeters, 0) }} m</p>
            <p class="text-xs text-slate-500">{{ number_format($openFabricMeters, 0) }} open · {{ number_format($committedFabricMeters, 0) }} committed</p>
        </a>
        <a href="{{ route('parts.index') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Parts store</p>
            <p class="mt-2 text-2xl font-black">{{ number_format($totalPartsStock) }} units</p>
            <p class="text-xs text-amber-700">{{ $lowStockPartsCount }} at/below minimum</p>
        </a>
        <a href="{{ route('factory.parchis') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-amber-200 bg-amber-50 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-700">
            <p class="text-xs font-bold uppercase text-amber-800">Pakki Parchis to record</p>
            <p class="mt-2 text-2xl font-black text-amber-950">{{ $pendingPakkiCount }}</p>
            <p class="text-xs text-amber-800">
                @if($pendingPakkiCount > 0)
                    {{ $pendingPakkiCount }} Pakki {{ $pendingPakkiCount === 1 ? 'Parchi needs' : 'Parchis need' }} recording · {{ number_format($pendingPakkiMeters, 0) }} m
                @else
                    No pending Parchis
                @endif
            </p>
        </a>
        <a href="{{ route('sales.contracts') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Active contracts</p>
            <p class="mt-2 text-2xl font-black">{{ $activeContractsCount }} active</p>
            <p class="text-xs text-slate-500">Production, delivery and acceptance progress</p>
        </a>
        <a href="{{ route('accounts.index') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Receivables / Payables</p>
            <p class="mt-2 text-lg font-black">Rs. {{ number_format($receivables, 0) }} receivable</p>
            <p class="text-xs text-slate-500">Rs. {{ number_format($payables, 0) }} payable</p>
        </a>
        <a href="{{ route('invoices.index') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Open / overdue invoices</p>
            <p class="mt-2 text-lg font-black">Rs. {{ number_format($openInvoiceBalance, 0) }}</p>
            <p class="text-xs text-slate-500">{{ $openInvoiceCount }} open · Rs. {{ number_format($overdueInvoiceBalance, 0) }} overdue</p>
        </a>
        <a href="{{ route('expenses.index') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Monthly activity</p>
            <p class="mt-2 text-lg font-black">{{ number_format($monthProductionMeters, 0) }} m produced</p>
            <p class="text-xs text-slate-500">Rs. {{ number_format($monthExpenseTotal, 0) }} expenses · {{ number_format($avgEfficiency, 1) }}% efficiency</p>
        </a>
        <a href="{{ route('factory.reports') }}" class="group flex min-h-32 flex-col justify-between rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">
            <p class="text-xs font-bold uppercase text-slate-500">Loom stoppages today</p>
            <p class="mt-2 text-2xl font-black">{{ $todayStoppedLoomCount }}</p>
            <p class="text-xs text-slate-500">Review factory reports</p>
        </a>
    </section>
    <section class="grid items-start gap-4 xl:grid-cols-2">
        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><header class="flex justify-between gap-3 border-b px-4 py-3"><div><h2 class="font-extrabold">Active Contracts &amp; Delivery Status</h2><p class="text-xs text-slate-500">Production, dispatch, acceptance and remaining meters</p></div><a href="{{ route('sales.contracts') }}" class="shrink-0 text-xs font-bold text-emerald-800">View all →</a></header><div class="max-h-80 overflow-auto"><table class="w-full min-w-[620px] text-left text-xs"><thead class="sticky top-0 bg-slate-50 text-[10px] uppercase text-slate-500"><tr><th class="p-2">Contract / quality</th><th class="p-2 text-right">Target</th><th class="p-2 text-right">Produced</th><th class="p-2 text-right">Dispatched</th><th class="p-2 text-right">Accepted</th><th class="p-2 text-right">Remaining</th></tr></thead><tbody class="divide-y">
            @forelse($activeContractRows as $contract)
                <tr><td class="p-2"><strong>{{ $contract->contract_no }}</strong><span class="block text-slate-500">{{ $contract->fabricStock?->display_name ?? $contract->fabric_quality }}</span></td><td class="p-2 text-right">{{ number_format((float) $contract->total_meters, 0) }} m</td><td class="p-2 text-right">{{ $contract->fabric_stock_id ? number_format((float) ($contractProductionMeters[$contract->id] ?? 0), 0).' m' : '—' }}</td><td class="p-2 text-right">{{ number_format((float) ($contractDispatchedMeters[$contract->id] ?? 0), 0) }} m</td><td class="p-2 text-right">{{ number_format((float) $contract->accepted_meters, 0) }} m</td><td class="p-2 text-right font-bold">{{ number_format(max(0, (float) $contract->total_meters - (float) $contract->accepted_meters), 0) }} m</td></tr>
            @empty<tr><td colspan="6" class="p-8 text-center text-slate-500">No active contracts.</td></tr>@endforelse
        </tbody></table></div></article>
        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><header class="flex justify-between gap-3 border-b px-4 py-3"><div><h2 class="font-extrabold">Latest Invoices</h2><p class="text-xs text-slate-500">Recent bills, customers and due dates</p></div><a href="{{ route('invoices.index') }}" class="shrink-0 text-xs font-bold text-emerald-800">View all →</a></header><div class="max-h-80 divide-y overflow-y-auto">
            @forelse($recentInvoices as $invoice)<div class="flex justify-between gap-3 px-4 py-3"><div><strong class="block text-sm">{{ $invoice->invoice_no }} · {{ $invoice->customer?->name ?? 'Customer' }}</strong><span class="text-xs text-slate-500">{{ $invoice->invoice_date?->format('d M Y') }} · {{ ucfirst($invoice->status) }}</span></div><strong class="shrink-0 text-sm">Rs. {{ number_format((float) $invoice->total, 0) }}<span class="block text-right text-xs font-normal text-slate-500">Due {{ $invoice->due_date?->format('d M Y') ?? 'Not set' }}</span></strong></div>@empty<p class="p-8 text-center text-sm text-slate-500">No invoices recorded.</p>@endforelse
        </div></article>
        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><header class="flex justify-between gap-3 border-b px-4 py-3"><div><h2 class="font-extrabold">Latest Production</h2><p class="text-xs text-slate-500">Loom output and shift records</p></div><a href="{{ route('production.index') }}" class="shrink-0 text-xs font-bold text-emerald-800">View production →</a></header><div class="max-h-80 divide-y overflow-y-auto">
            @forelse($recentProductions as $production)<div class="flex justify-between gap-3 px-4 py-3"><div><strong class="text-sm">{{ $production->loom_no }} · {{ $production->shift ?? 'Shift' }}</strong><span class="block text-xs text-slate-500">{{ $production->production_date?->format('d M Y') }} · {{ $production->operator_name ?? 'Operator not set' }}</span></div><strong class="shrink-0 text-sm">{{ number_format((float) $production->net_meters_produced, 0) }} m</strong></div>@empty<p class="p-8 text-center text-sm text-slate-500">No production records.</p>@endforelse
        </div></article>
        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><header class="flex justify-between gap-3 border-b px-4 py-3"><div><h2 class="font-extrabold">Recent Checking / Thaans</h2><p class="text-xs text-slate-500">Quality, ownership and checked length</p></div><a href="{{ route('factory.checking') }}" class="shrink-0 text-xs font-bold text-emerald-800">View checking →</a></header><div class="max-h-80 divide-y overflow-y-auto">
            @forelse($recentCheckedRolls as $roll)<div class="flex justify-between gap-3 px-4 py-3"><div class="min-w-0"><strong class="block truncate text-sm">{{ $roll->roll_no }} · {{ $roll->fabricStock?->display_name ?? 'Fabric' }}</strong><span class="text-xs text-slate-500">{{ ucfirst(str_replace('_', ' ', $roll->owner_type ?? 'factory')) }} · {{ $roll->grade ?? 'Unclassified' }} · {{ filled($roll->checked_on) ? \Illuminate\Support\Carbon::parse($roll->checked_on)->format('d M Y') : '—' }}</span></div><strong class="shrink-0 text-sm">{{ number_format((float) $roll->length_meters, 0) }} m</strong></div>@empty<p class="p-8 text-center text-sm text-slate-500">No checked thaans.</p>@endforelse
        </div></article>
        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><header class="flex justify-between gap-3 border-b px-4 py-3"><div><h2 class="font-extrabold">Latest Yarn Purchases</h2><p class="text-xs text-slate-500">Challan, quality, bags and supplier</p></div><a href="{{ route('bags.purchases') }}" class="shrink-0 text-xs font-bold text-emerald-800">View purchases →</a></header><div class="max-h-80 divide-y overflow-y-auto">
            @forelse($recentPurchases as $purchase)<div class="flex justify-between gap-3 px-4 py-3"><div class="min-w-0"><strong class="block truncate text-sm">{{ $purchase->challan_no }} · {{ $purchase->quality }}</strong><span class="text-xs text-slate-500">{{ $purchase->supplier_name }} · {{ $purchase->purchase_date?->format('d M Y') }}</span></div><strong class="shrink-0 text-sm">{{ number_format((float) $purchase->total_bags, 2) }} bags</strong></div>@empty<p class="p-8 text-center text-sm text-slate-500">No yarn purchases recorded.</p>@endforelse
        </div></article>
        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><header class="flex justify-between gap-3 border-b px-4 py-3"><div><h2 class="font-extrabold">Latest Sales</h2><p class="text-xs text-slate-500">Recent sale records and net amount</p></div><a href="{{ route('sales.index') }}" class="shrink-0 text-xs font-bold text-emerald-800">View sales →</a></header><div class="max-h-80 divide-y overflow-y-auto">
            @forelse($recentSales as $sale)<div class="flex justify-between gap-3 px-4 py-3"><div class="min-w-0"><strong class="block truncate text-sm">{{ $sale->invoice_no ?? $sale->sale_no ?? 'Sale' }} · {{ $sale->customer_name ?? 'Customer' }}</strong><span class="text-xs text-slate-500">{{ $sale->sale_date?->format('d M Y') }}</span></div><strong class="shrink-0 text-sm">Rs. {{ number_format((float) $sale->net_total, 0) }}</strong></div>@empty<p class="p-8 text-center text-sm text-slate-500">No sales recorded.</p>@endforelse
        </div></article>
        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><header class="flex justify-between gap-3 border-b px-4 py-3"><div><h2 class="font-extrabold">Latest Dispatches</h2><p class="text-xs text-slate-500">Customer and dispatched meters</p></div><a href="{{ route('factory.parchis') }}" class="shrink-0 text-xs font-bold text-emerald-800">View parchis →</a></header><div class="max-h-80 divide-y overflow-y-auto">
            @forelse($recentDispatches as $dispatch)<div class="flex justify-between gap-3 px-4 py-3"><div><strong class="block text-sm">{{ $dispatch->parchi_no }} · {{ $dispatch->order?->customer_name ?? $dispatch->order?->party_name ?? 'Customer' }}</strong><span class="text-xs text-slate-500">{{ filled($dispatch->dispatch_date) ? \Illuminate\Support\Carbon::parse($dispatch->dispatch_date)->format('d M Y') : '—' }}</span></div><strong class="shrink-0 text-sm">{{ number_format((float) $dispatch->dispatched_meters, 0) }} m</strong></div>@empty<p class="p-8 text-center text-sm text-slate-500">No dispatches recorded.</p>@endforelse
        </div></article>
        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><header class="flex justify-between gap-3 border-b px-4 py-3"><div><h2 class="font-extrabold">Latest Expenses</h2><p class="text-xs text-slate-500">Recent posted expense records</p></div><a href="{{ route('expenses.index') }}" class="shrink-0 text-xs font-bold text-emerald-800">View expenses →</a></header><div class="max-h-80 divide-y overflow-y-auto">
            @forelse($recentExpenses as $expense)<div class="flex justify-between gap-3 px-4 py-3"><div class="min-w-0"><strong class="block truncate text-sm">{{ $expense->title }}</strong><span class="text-xs text-slate-500">{{ $expense->expense_date?->format('d M Y') }} · {{ $expense->payee ?? $expense->expense_type }}</span></div><strong class="shrink-0 text-sm">Rs. {{ number_format((float) $expense->amount, 0) }}</strong></div>@empty<p class="p-8 text-center text-sm text-slate-500">No expenses recorded.</p>@endforelse
        </div></article>
    </section>
</div>
<div class="mt-8 space-y-6 max-w-7xl mx-auto">

    <!-- LOWER DUAL GRID (LOOMS AT A GLANCE + DO THIS NEXT) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Looms at a glance (Col 7) -->
        <div class="lg:col-span-7 card p-6 shadow-2xs">
            <div class="flex items-center justify-between pb-4 border-b border-[#e2e8e0]">
                <h3 class="text-sm font-extrabold text-[#133e2b] tracking-tight">Looms at a glance</h3>
                <a href="{{ route('production.index') }}" class="text-xs font-bold text-stone-600 hover:text-[#133e2b] transition-colors flex items-center gap-1">
                    <span>Full Loom Board</span>
                    <span>&nearr;</span>
                </a>
            </div>

            <div class="overflow-x-auto mt-4">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-[10px] font-bold uppercase tracking-wider text-stone-400 border-b border-stone-100 pb-2">
                            <th class="py-2 pr-3">Loom</th>
                            <th class="py-2 px-3">Quality</th>
                            <th class="py-2 px-3">Order</th>
                            <th class="py-2 pl-3 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @php
                            $displayLooms = [];
                            // Populate active loom assignments
                            foreach($activeLoomAssignments as $assignment) {
                                $displayLooms[$assignment->loom_no] = [
                                    'loom' => str_pad($assignment->loom_no, 2, '0', STR_PAD_LEFT),
                                    'quality' => $assignment->order?->fabricStock?->display_name ?? 'Grey Standard',
                                    'order' => $assignment->order?->order_no ?? 'Active',
                                    'status' => 'Running'
                                ];
                            }
                            // Fill sample or stopped looms up to 6 rows if few running
                            for($i = 1; $i <= 6; $i++) {
                                if(!isset($displayLooms[$i])) {
                                    $displayLooms[$i] = [
                                        'loom' => str_pad($i, 2, '0', STR_PAD_LEFT),
                                        'quality' => '&mdash;',
                                        'order' => '&mdash;',
                                        'status' => 'Stopped'
                                    ];
                                }
                            }
                            ksort($displayLooms);
                            $displayLooms = array_slice($displayLooms, 0, 6, true);
                        @endphp

                        @foreach($displayLooms as $loom)
                            <tr class="hover:bg-stone-50/60 transition-colors">
                                <td class="py-3 pr-3 font-black text-stone-800">
                                    {{ $loom['loom'] }}
                                </td>
                                <td class="py-3 px-3 font-medium text-stone-700">
                                    {!! $loom['quality'] !!}
                                </td>
                                <td class="py-3 px-3 font-semibold text-stone-600">
                                    {!! $loom['order'] !!}
                                </td>
                                <td class="py-3 pl-3 text-right">
                                    @if($loom['status'] === 'Running')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#e6f4ea] text-[#137333]">
                                            Running
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#fef3c7] text-[#92400e]">
                                            Stopped
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Do this next (Col 5) -->
        <div class="lg:col-span-5 card p-6 shadow-2xs flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-extrabold text-[#133e2b] tracking-tight pb-4 border-b border-[#e2e8e0]">
                    Do this next
                </h3>

                <div class="divide-y divide-stone-100 mt-2">
                    
                    <!-- Item 1 -->
                    <div class="py-3.5 flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-stone-900">Enter checked Thaans</div>
                            <div class="text-[11px] text-stone-500 mt-0.5">Measured checking report</div>
                        </div>
                        <a href="{{ route('factory.checking') }}" class="px-3 py-1.5 rounded-xl border border-stone-200 bg-white text-stone-700 hover:bg-stone-50 hover:border-stone-300 text-xs font-bold flex items-center gap-1 shadow-2xs transition-all shrink-0">
                            <span>Enter</span>
                            <span>&nearr;</span>
                        </a>
                    </div>

                    <!-- Item 2 -->
                    <div class="py-3.5 flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-stone-900">Receive yarn or bags</div>
                            <div class="text-[11px] text-stone-500 mt-0.5">Factory or customer-owned material</div>
                        </div>
                        <a href="{{ route('bags.index') }}" class="px-3 py-1.5 rounded-xl border border-stone-200 bg-white text-stone-700 hover:bg-stone-50 hover:border-stone-300 text-xs font-bold flex items-center gap-1 shadow-2xs transition-all shrink-0">
                            <span>Enter</span>
                            <span>&nearr;</span>
                        </a>
                    </div>

                    <!-- Item 3 -->
                    <div class="py-3.5 flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-stone-900">Review active contracts</div>
                            <div class="text-[11px] text-stone-500 mt-0.5">Quality, Parta, looms and acceptance</div>
                        </div>
                        <a href="{{ route('factory.orders') }}" class="px-3 py-1.5 rounded-xl border border-stone-200 bg-white text-stone-700 hover:bg-stone-50 hover:border-stone-300 text-xs font-bold flex items-center gap-1 shadow-2xs transition-all shrink-0">
                            <span>Review</span>
                            <span>&nearr;</span>
                        </a>
                    </div>

                    <!-- Item 4 -->
                    <div class="py-3.5 flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-stone-900">Record loom production</div>
                            <div class="text-[11px] text-stone-500 mt-0.5">Shift meter readings & beam waste</div>
                        </div>
                        <a href="{{ route('production.index') }}" class="px-3 py-1.5 rounded-xl border border-stone-200 bg-white text-stone-700 hover:bg-stone-50 hover:border-stone-300 text-xs font-bold flex items-center gap-1 shadow-2xs transition-all shrink-0">
                            <span>Record</span>
                            <span>&nearr;</span>
                        </a>
                    </div>

                </div>
            </div>

            <div class="pt-4 border-t border-stone-100 flex items-center justify-between text-xs text-stone-500">
                <span>Daily operations</span>
                <span class="font-bold text-[#133e2b]">LoomFlow 100% Weaving ERP</span>
            </div>
        </div>

    </div>

    <!-- CONTRACT PRODUCTION FLOW SECTION -->
    <section class="card p-6 sm:p-8 shadow-2xs">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-5 border-b border-[#e2e8e0]">
            <div>
                <h2 class="text-base sm:text-lg font-black text-[#133e2b] tracking-tight">Active Contracts & Delivery Status</h2>
                <p class="text-xs text-stone-500 mt-0.5">Contract meters, factory production, dispatches, and accepted totals.</p>
            </div>
            <a href="{{ route('sales.index') }}" class="text-xs font-bold text-[#133e2b] hover:underline flex items-center gap-1">
                <span>View all contracts</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-stone-50 text-[10px] font-bold uppercase tracking-wider text-stone-500 border-b border-stone-200">
                        <th class="px-4 py-3">Contract / Quality</th>
                        <th class="px-4 py-3 text-right">Target</th>
                        <th class="px-4 py-3 text-right">Produced*</th>
                        <th class="px-4 py-3 text-right">Dispatched</th>
                        <th class="px-4 py-3 text-right">Accepted</th>
                        <th class="px-4 py-3 text-right">Remaining</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($activeContractRows as $contract)
                        @php
                            $dispatchedMeters = (float) ($contractDispatchedMeters[$contract->id] ?? 0);
                            $remainingMeters = max(0, (float) $contract->total_meters - (float) $contract->accepted_meters);
                            $producedMeters = $contract->fabric_stock_id ? (float) ($contractProductionMeters[$contract->id] ?? 0) : null;
                        @endphp
                        <tr class="hover:bg-stone-50/70 transition-colors">
                            <td class="px-4 py-3.5">
                                <span class="font-bold text-stone-900 block">{{ $contract->contract_no }}</span>
                                <span class="text-stone-500 text-[11px]">{{ $contract->fabricStock?->display_name ?? $contract->fabric_quality }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-right tabular-nums text-stone-700 font-semibold">
                                {{ number_format((float) $contract->total_meters, 0) }}m
                            </td>
                            <td class="px-4 py-3.5 text-right tabular-nums text-stone-700">
                                {{ $producedMeters === null ? '—' : number_format($producedMeters, 0).'m' }}
                            </td>
                            <td class="px-4 py-3.5 text-right tabular-nums text-stone-700 font-medium">
                                {{ number_format($dispatchedMeters, 0) }}m
                            </td>
                            <td class="px-4 py-3.5 text-right tabular-nums text-stone-700 font-medium">
                                {{ number_format((float)$contract->accepted_meters, 0) }}m
                            </td>
                            <td class="px-4 py-3.5 text-right tabular-nums font-black text-[#133e2b]">
                                {{ number_format($remainingMeters, 0) }}m
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-stone-400 italic">
                                No active customer contracts found. Create one in Sales or Orders.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- CORE ERP MODULES DIRECT ACCESS (ELEGANT WHITE CARDS) -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-stone-600">All Factory Modules</h3>
                <p class="text-xs text-stone-400">Directly jump to any mill station</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

            <!-- MODULE 1: BAGS -->
            <a href="{{ route('bags.index') }}" class="card p-6 card-hover group relative overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#133e2b] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100/70 text-[#133e2b]">Sutar</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-lg font-black text-stone-900 group-hover:text-[#133e2b] transition-colors">Yarn Bags</h4>
                        <p class="text-xs text-stone-500 mt-1 line-clamp-2">Godown stock, Sizing usage, and unused bag returns.</p>
                    </div>
                </div>
                <div class="mt-5 pt-3 border-t border-stone-100 flex items-center justify-between text-xs">
                    <span class="text-stone-500">Stock in Godown:</span>
                    <strong class="text-stone-900 font-bold">{{ number_format((float) $factoryBagStock, 1) }} Bags</strong>
                </div>
            </a>

            <!-- MODULE 2: SIZING -->
            <a href="{{ route('sizing.index') }}" class="card p-6 card-hover group relative overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#133e2b] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100/70 text-[#133e2b]">Beams</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-lg font-black text-stone-900 group-hover:text-[#133e2b] transition-colors">Sizing & Beams</h4>
                        <p class="text-xs text-stone-500 mt-1 line-clamp-2">Sizing slips, beam generation & loom-wise beam mounting.</p>
                    </div>
                </div>
                <div class="mt-5 pt-3 border-t border-stone-100 flex items-center justify-between text-xs">
                    <span class="text-stone-500">Active Beams:</span>
                    <strong class="text-stone-900 font-bold">{{ $activeBeamsCount }} Mounted</strong>
                </div>
            </a>

            <!-- MODULE 3: PRODUCTION -->
            <a href="{{ route('production.index') }}" class="card p-6 card-hover group relative overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#133e2b] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100/70 text-[#133e2b]">Looms</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-lg font-black text-stone-900 group-hover:text-[#133e2b] transition-colors">Production Board</h4>
                        <p class="text-xs text-stone-500 mt-1 line-clamp-2">Loom-wise shift meters, efficiency and beam leakage analysis.</p>
                    </div>
                </div>
                <div class="mt-5 pt-3 border-t border-stone-100 flex items-center justify-between text-xs">
                    <span class="text-stone-500">Total Produced:</span>
                    <strong class="text-stone-900 font-bold">{{ number_format($totalProductionMeters, 0) }}m</strong>
                </div>
            </a>

            <!-- MODULE 4: FABRIC STOCK -->
            <a href="{{ route('fabric.index') }}" class="card p-6 card-hover group relative overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#133e2b] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100/70 text-[#133e2b]">Stock</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-lg font-black text-stone-900 group-hover:text-[#133e2b] transition-colors">Fabric Stock</h4>
                        <p class="text-xs text-stone-500 mt-1 line-clamp-2">Open sale stock vs committed contract stock across all qualities.</p>
                    </div>
                </div>
                <div class="mt-5 pt-3 border-t border-stone-100 flex items-center justify-between text-xs">
                    <span class="text-stone-500">Open Ready:</span>
                    <strong class="text-stone-900 font-bold">{{ number_format($openFabricMeters, 0) }}m</strong>
                </div>
            </a>

            <!-- MODULE 5: INVOICES & KHATA -->
            <a href="{{ route('invoices.index') }}" class="card p-6 card-hover group relative overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#133e2b] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100/70 text-[#133e2b]">Khata</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-lg font-black text-stone-900 group-hover:text-[#133e2b] transition-colors">Khata & Invoices</h4>
                        <p class="text-xs text-stone-500 mt-1 line-clamp-2">Customer bills, payments, bank receipts & ledger postings.</p>
                    </div>
                </div>
                <div class="mt-5 pt-3 border-t border-stone-100 flex items-center justify-between text-xs">
                    <span class="text-stone-500">Revenue Recorded:</span>
                    <strong class="text-stone-900 font-bold">Rs. {{ number_format($totalSalesAmount, 0) }}</strong>
                </div>
            </a>

            <!-- MODULE 6: TOOLS & PARTS -->
            <a href="{{ route('parts.index') }}" class="card p-6 card-hover group relative overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#133e2b] flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100/70 text-[#133e2b]">Tools</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-lg font-black text-stone-900 group-hover:text-[#133e2b] transition-colors">Factory Tools & Parts</h4>
                        <p class="text-xs text-stone-500 mt-1 line-clamp-2">Grippers, rapier tapes, sensors, and loom maintenance issuance.</p>
                    </div>
                </div>
                <div class="mt-5 pt-3 border-t border-stone-100 flex items-center justify-between text-xs">
                    <span class="text-stone-500">Items in Store:</span>
                    <strong class="text-stone-900 font-bold">{{ number_format($totalPartsStock) }} Units</strong>
                </div>
            </a>

        </div>
    </div>

</div>
@endsection
