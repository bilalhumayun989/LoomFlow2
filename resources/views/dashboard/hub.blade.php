@extends('layouts.app')

@section('title', 'LoomFlow Dashboard')

@section('content')
<div class="space-y-7 pb-10">

    {{-- ═══════════════════════════════════════════════════
         PAGE HEADER
    ═══════════════════════════════════════════════════ --}}
    <header class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#15803d]">
                Factory overview · {{ now()->format('d M Y, H:i') }}
            </p>
            <h1 class="mt-1 text-2xl sm:text-3xl font-black tracking-tight text-[#133e2b]">
                LoomFlow Dashboard
            </h1>
            <p class="mt-1 text-xs sm:text-sm text-stone-500">
                Live view across production, stock, parchis, contracts and accounts.
            </p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('factory.checking') }}"
               class="inline-flex items-center gap-1.5 rounded-xl bg-[#133e2b] px-4 py-2 text-xs font-extrabold text-white shadow-sm hover:bg-[#1b5239] transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Checking Entry
            </a>
            <a href="{{ route('factory.parchis') }}"
               class="inline-flex items-center gap-1.5 rounded-xl border border-[#e2e8e0] bg-white px-4 py-2 text-xs font-bold text-stone-700 shadow-sm hover:bg-stone-50 transition-colors">
                Parchis
            </a>
        </div>
    </header>

    {{-- ═══════════════════════════════════════════════════
         TOP KPI STRIP — 4 KEY NUMBERS AT A GLANCE
    ═══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">

        {{-- Looms running --}}
        <a href="{{ route('production.index') }}"
           class="group relative overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white p-4 sm:p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md hover:border-[#c6f16d] transition-all">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#f0fdf4] text-[#133e2b]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="mt-1 h-2 w-2 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
            </div>
            <p class="mt-3 text-[11px] font-bold uppercase tracking-wider text-stone-500">Looms Running</p>
            <p class="mt-1 text-3xl font-black text-[#133e2b] tabular-nums leading-none">
                {{ $activeLoomAssignments->count() }}<span class="text-base font-semibold text-stone-400 ml-1">/ {{ $totalLoomCount }}</span>
            </p>
            <p class="mt-1.5 text-[11px] text-stone-500">
                {{ number_format($todayProductionMeters, 0) }} m produced today
            </p>
        </a>

        {{-- Beam meters remaining --}}
        <a href="{{ route('sizing.index') }}"
           class="group relative overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white p-4 sm:p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md hover:border-[#c6f16d] transition-all">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#f0fdf4] text-[#133e2b]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <span class="mt-1 rounded-full bg-[#f0fdf4] px-2 py-0.5 text-[10px] font-bold text-[#133e2b]">{{ $activeBeamsCount }} on loom</span>
            </div>
            <p class="mt-3 text-[11px] font-bold uppercase tracking-wider text-stone-500">Beam Meters Left</p>
            <p class="mt-1 text-3xl font-black text-[#133e2b] tabular-nums leading-none">
                {{ number_format($totalBeamMetersRemaining, 0) }}<span class="text-base font-semibold text-stone-400 ml-1">m</span>
            </p>
            <p class="mt-1.5 text-[11px] text-stone-500">
                {{ $readyBeamsCount }} ready in store
            </p>
        </a>

        {{-- Fabric stock --}}
        <a href="{{ route('fabric.index') }}"
           class="group relative overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white p-4 sm:p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md hover:border-[#c6f16d] transition-all">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#f0fdf4] text-[#133e2b]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <span class="mt-1 rounded-full bg-[#f0fdf4] px-2 py-0.5 text-[10px] font-bold text-[#133e2b]">{{ number_format($openFabricMeters, 0) }}m open</span>
            </div>
            <p class="mt-3 text-[11px] font-bold uppercase tracking-wider text-stone-500">Fabric Stock</p>
            <p class="mt-1 text-3xl font-black text-[#133e2b] tabular-nums leading-none">
                {{ number_format($totalFabricStockMeters, 0) }}<span class="text-base font-semibold text-stone-400 ml-1">m</span>
            </p>
            <p class="mt-1.5 text-[11px] text-stone-500">
                {{ number_format($committedFabricMeters, 0) }} m committed
            </p>
        </a>

        {{-- Pending Parchis — alert card --}}
        <a href="{{ route('factory.parchis') }}"
           class="group relative overflow-hidden rounded-2xl p-4 sm:p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition-all
                  {{ $pendingPakkiCount > 0 ? 'border border-amber-300 bg-amber-50 hover:border-amber-400' : 'border border-[#e2e8e0] bg-white hover:border-[#c6f16d]' }}">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                            {{ $pendingPakkiCount > 0 ? 'bg-amber-100 text-amber-700' : 'bg-[#f0fdf4] text-[#133e2b]' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                @if($pendingPakkiCount > 0)
                    <span class="mt-1 h-2 w-2 rounded-full bg-amber-500 animate-pulse shrink-0"></span>
                @endif
            </div>
            <p class="mt-3 text-[11px] font-bold uppercase tracking-wider {{ $pendingPakkiCount > 0 ? 'text-amber-700' : 'text-stone-500' }}">
                Pakki Parchis Pending
            </p>
            <p class="mt-1 text-3xl font-black tabular-nums leading-none {{ $pendingPakkiCount > 0 ? 'text-amber-900' : 'text-[#133e2b]' }}">
                {{ $pendingPakkiCount }}
            </p>
            <p class="mt-1.5 text-[11px] {{ $pendingPakkiCount > 0 ? 'text-amber-700' : 'text-stone-500' }}">
                {{ $pendingPakkiCount > 0 ? number_format($pendingPakkiMeters, 0).' m to record' : 'All parchis recorded' }}
            </p>
        </a>
    </div>

    {{-- ═══════════════════════════════════════════════════
         SECOND ROW — 4 MORE STAT CARDS
    ═══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">

        <a href="{{ route('bags.index') }}"
           class="group rounded-2xl border border-[#e2e8e0] bg-white p-4 sm:p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md hover:border-[#c6f16d] transition-all">
            <p class="text-[11px] font-bold uppercase tracking-wider text-stone-500">Yarn Bags — Factory</p>
            <p class="mt-2 text-2xl font-black text-[#133e2b] tabular-nums">{{ number_format($factoryBagStock, 1) }} <span class="text-sm font-normal text-stone-400">bags</span></p>
            <p class="mt-1 text-[11px] text-stone-500">{{ number_format($sizingBagsInHand, 1) }} with sizing</p>
        </a>

        <a href="{{ route('parts.index') }}"
           class="group rounded-2xl border border-[#e2e8e0] bg-white p-4 sm:p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md hover:border-[#c6f16d] transition-all">
            <p class="text-[11px] font-bold uppercase tracking-wider text-stone-500">Parts Store</p>
            <p class="mt-2 text-2xl font-black text-[#133e2b] tabular-nums">{{ number_format($totalPartsStock) }} <span class="text-sm font-normal text-stone-400">units</span></p>
            <p class="mt-1 text-[11px] {{ $lowStockPartsCount > 0 ? 'text-amber-700 font-semibold' : 'text-stone-500' }}">
                {{ $lowStockPartsCount > 0 ? $lowStockPartsCount.' at/below minimum' : 'All items above minimum' }}
            </p>
        </a>

        <a href="{{ route('accounts.index') }}"
           class="group rounded-2xl border border-[#e2e8e0] bg-white p-4 sm:p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md hover:border-[#c6f16d] transition-all">
            <p class="text-[11px] font-bold uppercase tracking-wider text-stone-500">Receivables</p>
            <p class="mt-2 text-2xl font-black text-[#133e2b] tabular-nums">Rs. {{ number_format($receivables, 0) }}</p>
            <p class="mt-1 text-[11px] text-stone-500">Rs. {{ number_format($payables, 0) }} payable</p>
        </a>

        <a href="{{ route('invoices.index') }}"
           class="group rounded-2xl border border-[#e2e8e0] bg-white p-4 sm:p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md hover:border-[#c6f16d] transition-all">
            <p class="text-[11px] font-bold uppercase tracking-wider text-stone-500">Open Invoices</p>
            <p class="mt-2 text-2xl font-black text-[#133e2b] tabular-nums">Rs. {{ number_format($openInvoiceBalance, 0) }}</p>
            <p class="mt-1 text-[11px] {{ $overdueInvoiceBalance > 0 ? 'text-amber-700 font-semibold' : 'text-stone-500' }}">
                {{ $openInvoiceCount }} open · Rs. {{ number_format($overdueInvoiceBalance, 0) }} overdue
            </p>
        </a>
    </div>

    {{-- ═══════════════════════════════════════════════════
         MAIN CONTENT GRID — LOOMS + DO THIS NEXT
    ═══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

        {{-- Left col: Looms at a glance --}}
        <div class="lg:col-span-7 overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white shadow-sm">
            <div class="flex items-center justify-between gap-3 border-b border-[#e2e8e0] px-5 py-4">
                <div>
                    <h2 class="text-sm font-extrabold text-[#133e2b] tracking-tight">Looms at a glance</h2>
                    <p class="text-[11px] text-stone-500">Active assignments and running status</p>
                </div>
                <a href="{{ route('production.index') }}"
                   class="shrink-0 text-xs font-bold text-[#133e2b] hover:underline flex items-center gap-1">
                    Full board &nearr;
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-50 text-[10px] font-bold uppercase tracking-wider text-stone-400">
                        <tr>
                            <th class="px-5 py-2.5">Loom</th>
                            <th class="px-5 py-2.5">Quality</th>
                            <th class="px-5 py-2.5">Order</th>
                            <th class="px-5 py-2.5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @php
                            $displayLooms = [];
                            foreach ($activeLoomAssignments as $assignment) {
                                $displayLooms[$assignment->loom_no] = [
                                    'loom'    => str_pad($assignment->loom_no, 2, '0', STR_PAD_LEFT),
                                    'quality' => $assignment->order?->fabricStock?->quality_name ?? 'Grey Standard',
                                    'order'   => $assignment->order?->order_no ?? 'Active',
                                    'status'  => 'Running',
                                ];
                            }
                            $displayLoomLimit = max(6, count($displayLooms) + 2);
                            for ($i = 1; $i <= $displayLoomLimit; $i++) {
                                if (! isset($displayLooms[$i])) {
                                    $displayLooms[$i] = [
                                        'loom'    => str_pad($i, 2, '0', STR_PAD_LEFT),
                                        'quality' => '—',
                                        'order'   => '—',
                                        'status'  => 'Stopped',
                                    ];
                                }
                            }
                            ksort($displayLooms);
                            $displayLooms = array_slice($displayLooms, 0, 8, true);
                        @endphp
                        @foreach($displayLooms as $loomRow)
                            <tr class="hover:bg-stone-50/50 transition-colors">
                                <td class="px-5 py-3 font-black text-stone-900 font-mono">{{ $loomRow['loom'] }}</td>
                                <td class="px-5 py-3 text-stone-700">{{ $loomRow['quality'] }}</td>
                                <td class="px-5 py-3 font-semibold text-stone-600">{{ $loomRow['order'] }}</td>
                                <td class="px-5 py-3 text-right">
                                    @if($loomRow['status'] === 'Running')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-[#dcfce7] px-2.5 py-0.5 text-[11px] font-bold text-[#15803d]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#15803d]"></span>
                                            Running
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-stone-100 px-2.5 py-0.5 text-[11px] font-bold text-stone-500">
                                            <span class="h-1.5 w-1.5 rounded-full bg-stone-400"></span>
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

        {{-- Right col: Do this next --}}
        <div class="lg:col-span-5 overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white shadow-sm flex flex-col">
            <div class="border-b border-[#e2e8e0] px-5 py-4">
                <h2 class="text-sm font-extrabold text-[#133e2b] tracking-tight">Do this next</h2>
                <p class="text-[11px] text-stone-500">Common daily actions</p>
            </div>
            <div class="flex flex-col divide-y divide-stone-100 flex-1 px-1">
                @php
                    $quickTasks = [
                        ['label' => 'Enter checked Thaans',      'sub' => 'Measured checking report',              'route' => route('factory.checking'),    'cta' => 'Enter'],
                        ['label' => 'Record loom production',     'sub' => 'Shift meter readings & beam waste',     'route' => route('production.index'),    'cta' => 'Record'],
                        ['label' => 'Receive yarn / bags',        'sub' => 'Factory or customer-owned material',    'route' => route('bags.index'),          'cta' => 'Enter'],
                        ['label' => 'Create Kachi Parchi',        'sub' => 'Dispatch fabric to customer',          'route' => route('factory.parchis'),     'cta' => 'Open'],
                        ['label' => 'Review active contracts',    'sub' => 'Quality, Parta, looms and acceptance',  'route' => route('factory.orders'),      'cta' => 'Review'],
                        ['label' => 'Post an expense',            'sub' => 'Cash or bank spend this week',          'route' => route('expenses.index'),      'cta' => 'Post'],
                    ];
                @endphp
                @foreach($quickTasks as $task)
                    <div class="flex items-center justify-between gap-3 px-4 py-3.5">
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-stone-900 truncate">{{ $task['label'] }}</div>
                            <div class="text-[11px] text-stone-500 mt-0.5">{{ $task['sub'] }}</div>
                        </div>
                        <a href="{{ $task['route'] }}"
                           class="shrink-0 inline-flex items-center gap-1 rounded-xl border border-stone-200 bg-white px-3 py-1.5 text-xs font-bold text-stone-700 hover:bg-stone-50 hover:border-stone-300 transition-all shadow-2xs">
                            {{ $task['cta'] }} &nearr;
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-stone-100 px-5 py-3 flex items-center justify-between text-[11px] text-stone-400">
                <span>Daily operations</span>
                <span class="font-black text-[#133e2b]">LoomFlow ERP</span>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         ACTIVE CONTRACTS TABLE
    ═══════════════════════════════════════════════════ --}}
    <div class="overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-[#e2e8e0] px-5 py-4">
            <div>
                <h2 class="text-sm font-extrabold text-[#133e2b] tracking-tight">Active Contracts &amp; Delivery Status</h2>
                <p class="text-[11px] text-stone-500">Target, production, dispatched, accepted and remaining meters</p>
            </div>
            <a href="{{ route('sales.contracts') }}" class="shrink-0 text-xs font-bold text-[#133e2b] hover:underline">
                View all &rarr;
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-xs">
                <thead class="bg-stone-50 text-[10px] font-bold uppercase tracking-wider text-stone-400">
                    <tr>
                        <th class="px-5 py-3">Contract / Quality</th>
                        <th class="px-5 py-3 text-right">Target</th>
                        <th class="px-5 py-3 text-right">Produced</th>
                        <th class="px-5 py-3 text-right">Dispatched</th>
                        <th class="px-5 py-3 text-right">Accepted</th>
                        <th class="px-5 py-3 text-right">Remaining</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($activeContractRows as $contract)
                        @php
                            $dispatchedMeters = (float) ($contractDispatchedMeters[$contract->id] ?? 0);
                            $remainingMeters  = max(0, (float) $contract->total_meters - (float) $contract->accepted_meters);
                            $producedMeters   = $contract->fabric_stock_id ? (float) ($contractProductionMeters[$contract->id] ?? 0) : null;
                        @endphp
                        <tr class="hover:bg-stone-50/60 transition-colors">
                            <td class="px-5 py-3.5">
                                <span class="block font-bold text-stone-900">{{ $contract->contract_no }}</span>
                                <span class="text-[11px] text-stone-500">{{ $contract->fabricStock?->quality_name ?? $contract->fabric_quality }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-right font-semibold tabular-nums text-stone-700">{{ number_format((float)$contract->total_meters, 0) }}m</td>
                            <td class="px-5 py-3.5 text-right tabular-nums text-stone-600">{{ $producedMeters === null ? '—' : number_format($producedMeters, 0).'m' }}</td>
                            <td class="px-5 py-3.5 text-right tabular-nums text-stone-600">{{ number_format($dispatchedMeters, 0) }}m</td>
                            <td class="px-5 py-3.5 text-right tabular-nums text-stone-600">{{ number_format((float)$contract->accepted_meters, 0) }}m</td>
                            <td class="px-5 py-3.5 text-right font-black tabular-nums text-[#133e2b]">{{ number_format($remainingMeters, 0) }}m</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-stone-400 italic">
                                No active customer contracts. Create one in Sales or Orders.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         LIVE FEED — 4-COL RECENT ACTIVITY
    ═══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Recent Production --}}
        <div class="overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white shadow-sm flex flex-col">
            <div class="flex items-center justify-between gap-2 border-b border-[#e2e8e0] px-4 py-3">
                <h3 class="text-xs font-extrabold text-[#133e2b]">Latest Production</h3>
                <a href="{{ route('production.index') }}" class="text-[11px] font-bold text-stone-500 hover:text-[#133e2b]">View →</a>
            </div>
            <div class="flex flex-col divide-y divide-stone-100 flex-1">
                @forelse($recentProductions as $production)
                    <div class="flex items-center justify-between gap-2 px-4 py-3">
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-stone-900 truncate">{{ $production->loom_no }} · {{ $production->shift ?? 'Shift' }}</span>
                            <span class="text-[11px] text-stone-500">{{ $production->production_date?->format('d M Y') }}</span>
                        </div>
                        <span class="shrink-0 text-xs font-black text-[#133e2b] tabular-nums">{{ number_format((float)$production->net_meters_produced, 0) }}m</span>
                    </div>
                @empty
                    <p class="px-4 py-6 text-center text-xs text-stone-400">No production records.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Checking --}}
        <div class="overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white shadow-sm flex flex-col">
            <div class="flex items-center justify-between gap-2 border-b border-[#e2e8e0] px-4 py-3">
                <h3 class="text-xs font-extrabold text-[#133e2b]">Recent Checking</h3>
                <a href="{{ route('factory.checking') }}" class="text-[11px] font-bold text-stone-500 hover:text-[#133e2b]">View →</a>
            </div>
            <div class="flex flex-col divide-y divide-stone-100 flex-1">
                @forelse($recentCheckedRolls as $roll)
                    <div class="flex items-center justify-between gap-2 px-4 py-3">
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-stone-900 truncate">{{ $roll->roll_no }} · {{ $roll->fabricStock?->quality_name ?? 'Fabric' }}</span>
                            <span class="text-[11px] text-stone-500">{{ $roll->grade ?? 'Unclassified' }} · {{ filled($roll->checked_on) ? \Illuminate\Support\Carbon::parse($roll->checked_on)->format('d M') : '—' }}</span>
                        </div>
                        <span class="shrink-0 text-xs font-black text-[#133e2b] tabular-nums">{{ number_format((float)$roll->length_meters, 0) }}m</span>
                    </div>
                @empty
                    <p class="px-4 py-6 text-center text-xs text-stone-400">No checked thaans.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Dispatches --}}
        <div class="overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white shadow-sm flex flex-col">
            <div class="flex items-center justify-between gap-2 border-b border-[#e2e8e0] px-4 py-3">
                <h3 class="text-xs font-extrabold text-[#133e2b]">Recent Dispatches</h3>
                <a href="{{ route('factory.parchis') }}" class="text-[11px] font-bold text-stone-500 hover:text-[#133e2b]">View →</a>
            </div>
            <div class="flex flex-col divide-y divide-stone-100 flex-1">
                @forelse($recentDispatches as $dispatch)
                    <div class="flex items-center justify-between gap-2 px-4 py-3">
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-stone-900 truncate">{{ $dispatch->parchi_no }} · {{ $dispatch->order?->party_name ?? 'Customer' }}</span>
                            <span class="text-[11px] text-stone-500">{{ filled($dispatch->dispatch_date) ? \Illuminate\Support\Carbon::parse($dispatch->dispatch_date)->format('d M Y') : '—' }}</span>
                        </div>
                        <span class="shrink-0 text-xs font-black text-[#133e2b] tabular-nums">{{ number_format((float)$dispatch->dispatched_meters, 0) }}m</span>
                    </div>
                @empty
                    <p class="px-4 py-6 text-center text-xs text-stone-400">No dispatches recorded.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Expenses --}}
        <div class="overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white shadow-sm flex flex-col">
            <div class="flex items-center justify-between gap-2 border-b border-[#e2e8e0] px-4 py-3">
                <h3 class="text-xs font-extrabold text-[#133e2b]">Latest Expenses</h3>
                <a href="{{ route('expenses.index') }}" class="text-[11px] font-bold text-stone-500 hover:text-[#133e2b]">View →</a>
            </div>
            <div class="flex flex-col divide-y divide-stone-100 flex-1">
                @forelse($recentExpenses as $expense)
                    <div class="flex items-center justify-between gap-2 px-4 py-3">
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-stone-900 truncate">{{ $expense->title }}</span>
                            <span class="text-[11px] text-stone-500">{{ $expense->expense_date?->format('d M Y') }}</span>
                        </div>
                        <span class="shrink-0 text-xs font-black text-[#133e2b] tabular-nums">Rs. {{ number_format((float)$expense->amount, 0) }}</span>
                    </div>
                @empty
                    <p class="px-4 py-6 text-center text-xs text-stone-400">No expenses recorded.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         MODULE QUICK-ACCESS GRID
    ═══════════════════════════════════════════════════ --}}
    <div>
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-extrabold uppercase tracking-wider text-stone-600">All Factory Modules</h2>
                <p class="text-xs text-stone-400 mt-0.5">Jump directly to any section</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            @php
                $modules = [
                    [
                        'route'   => route('bags.index'),
                        'icon'    => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                        'tag'     => 'Sutar',
                        'title'   => 'Yarn Bags',
                        'desc'    => 'Godown stock, sizing usage and unused bag returns.',
                        'stat_l'  => 'Factory stock',
                        'stat_v'  => number_format((float)$factoryBagStock, 1).' Bags',
                    ],
                    [
                        'route'   => route('sizing.index'),
                        'icon'    => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                        'tag'     => 'Beams',
                        'title'   => 'Sizing & Beams',
                        'desc'    => 'Sizing slips, beam generation and loom-wise mounting.',
                        'stat_l'  => 'Active beams',
                        'stat_v'  => $activeBeamsCount.' Mounted',
                    ],
                    [
                        'route'   => route('production.index'),
                        'icon'    => 'M13 10V3L4 14h7v7l9-11h-7z',
                        'tag'     => 'Looms',
                        'title'   => 'Production Board',
                        'desc'    => 'Shift meters, efficiency and beam leakage analysis.',
                        'stat_l'  => 'Total produced',
                        'stat_v'  => number_format($totalProductionMeters, 0).'m',
                    ],
                    [
                        'route'   => route('fabric.index'),
                        'icon'    => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4',
                        'tag'     => 'Stock',
                        'title'   => 'Fabric Stock',
                        'desc'    => 'Open sale stock vs committed contract across all qualities.',
                        'stat_l'  => 'Open ready',
                        'stat_v'  => number_format($openFabricMeters, 0).'m',
                    ],
                    [
                        'route'   => route('invoices.index'),
                        'icon'    => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
                        'tag'     => 'Khata',
                        'title'   => 'Invoices & Accounts',
                        'desc'    => 'Customer bills, payments, bank receipts & ledger postings.',
                        'stat_l'  => 'Revenue recorded',
                        'stat_v'  => 'Rs. '.number_format($totalSalesAmount, 0),
                    ],
                    [
                        'route'   => route('parts.index'),
                        'icon'    => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
                        'tag'     => 'Tools',
                        'title'   => 'Factory Parts & Tools',
                        'desc'    => 'Grippers, rapier tapes, sensors and loom maintenance.',
                        'stat_l'  => 'Items in store',
                        'stat_v'  => number_format($totalPartsStock).' Units',
                    ],
                ];
            @endphp

            @foreach($modules as $mod)
                <a href="{{ $mod['route'] }}"
                   class="group card card-hover relative flex flex-col justify-between overflow-hidden p-5">
                    <div>
                        <div class="flex items-start justify-between">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#f0fdf4] text-[#133e2b] group-hover:scale-105 transition-transform">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $mod['icon'] }}"/>
                                </svg>
                            </div>
                            <span class="mt-1 rounded-full bg-[#f0fdf4] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#133e2b]">
                                {{ $mod['tag'] }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-base font-black text-stone-900 group-hover:text-[#133e2b] transition-colors leading-tight">{{ $mod['title'] }}</h3>
                            <p class="mt-1 text-xs text-stone-500 line-clamp-2">{{ $mod['desc'] }}</p>
                        </div>
                    </div>
                    <div class="mt-5 flex items-center justify-between border-t border-stone-100 pt-3 text-xs">
                        <span class="text-stone-500">{{ $mod['stat_l'] }}</span>
                        <strong class="font-bold text-stone-900">{{ $mod['stat_v'] }}</strong>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         BOTTOM SECONDARY FEED — invoices + purchases + sales
    ═══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        {{-- Latest Invoices --}}
        <div class="overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white shadow-sm flex flex-col">
            <div class="flex items-center justify-between gap-2 border-b border-[#e2e8e0] px-4 py-3">
                <h3 class="text-xs font-extrabold text-[#133e2b]">Latest Invoices</h3>
                <a href="{{ route('invoices.index') }}" class="text-[11px] font-bold text-stone-500 hover:text-[#133e2b]">View →</a>
            </div>
            <div class="flex flex-col divide-y divide-stone-100 flex-1">
                @forelse($recentInvoices as $invoice)
                    <div class="flex items-center justify-between gap-2 px-4 py-3">
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-stone-900 truncate">{{ $invoice->invoice_no }} · {{ $invoice->customer?->name ?? 'Customer' }}</span>
                            <span class="text-[11px] text-stone-500">{{ $invoice->invoice_date?->format('d M Y') }} · {{ ucfirst($invoice->status) }}</span>
                        </div>
                        <span class="shrink-0 text-xs font-black text-[#133e2b] tabular-nums">Rs. {{ number_format((float)$invoice->total, 0) }}</span>
                    </div>
                @empty
                    <p class="px-4 py-6 text-center text-xs text-stone-400">No invoices recorded.</p>
                @endforelse
            </div>
        </div>

        {{-- Latest Yarn Purchases --}}
        <div class="overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white shadow-sm flex flex-col">
            <div class="flex items-center justify-between gap-2 border-b border-[#e2e8e0] px-4 py-3">
                <h3 class="text-xs font-extrabold text-[#133e2b]">Latest Yarn Purchases</h3>
                <a href="{{ route('bags.purchases') }}" class="text-[11px] font-bold text-stone-500 hover:text-[#133e2b]">View →</a>
            </div>
            <div class="flex flex-col divide-y divide-stone-100 flex-1">
                @forelse($recentPurchases as $purchase)
                    <div class="flex items-center justify-between gap-2 px-4 py-3">
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-stone-900 truncate">{{ $purchase->challan_no }} · {{ $purchase->quality }}</span>
                            <span class="text-[11px] text-stone-500">{{ $purchase->supplier_name }} · {{ $purchase->purchase_date?->format('d M Y') }}</span>
                        </div>
                        <span class="shrink-0 text-xs font-black text-[#133e2b] tabular-nums">{{ number_format((float)$purchase->total_bags, 1) }} bags</span>
                    </div>
                @empty
                    <p class="px-4 py-6 text-center text-xs text-stone-400">No yarn purchases recorded.</p>
                @endforelse
            </div>
        </div>

        {{-- Latest Sales --}}
        <div class="overflow-hidden rounded-2xl border border-[#e2e8e0] bg-white shadow-sm flex flex-col">
            <div class="flex items-center justify-between gap-2 border-b border-[#e2e8e0] px-4 py-3">
                <h3 class="text-xs font-extrabold text-[#133e2b]">Latest Sales</h3>
                <a href="{{ route('sales.index') }}" class="text-[11px] font-bold text-stone-500 hover:text-[#133e2b]">View →</a>
            </div>
            <div class="flex flex-col divide-y divide-stone-100 flex-1">
                @forelse($recentSales as $sale)
                    <div class="flex items-center justify-between gap-2 px-4 py-3">
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-stone-900 truncate">{{ $sale->invoice_no ?? $sale->sale_no ?? 'Sale' }} · {{ $sale->customer_name ?? 'Customer' }}</span>
                            <span class="text-[11px] text-stone-500">{{ $sale->sale_date?->format('d M Y') }}</span>
                        </div>
                        <span class="shrink-0 text-xs font-black text-[#133e2b] tabular-nums">Rs. {{ number_format((float)$sale->net_total, 0) }}</span>
                    </div>
                @empty
                    <p class="px-4 py-6 text-center text-xs text-stone-400">No sales recorded.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
