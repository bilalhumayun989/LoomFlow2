@extends('layouts.app')

@section('title', 'Operator Workspace')

@section('content')
@php
    $dailyTransactions = [
        ['title' => 'Checking Report', 'description' => 'Thaan measuring / folding', 'route' => route('factory.checking')],
        ['title' => 'Kachi Parchi', 'description' => 'Dispatch checked Thaans', 'route' => route('factory.parchis')],
        ['title' => 'Pakki Parchi', 'description' => 'Customer acceptance totals', 'route' => route('factory.parchis')],
        ['title' => 'Yarn Receipt / Issue', 'description' => 'Taana, baana and bag balances', 'route' => route('bags.index')],
        ['title' => 'Sizing / Expense Bill', 'description' => 'Sizing slips and linked costing', 'route' => route('sizing.index')],
        ['title' => 'Payments / Receipts', 'description' => 'Party settlements and balances', 'route' => route('invoices.payments')],
        ['title' => 'Job-work Billing', 'description' => 'Invoices from accepted metres', 'route' => route('invoices.index')],
    ];

    $moreTasks = [
        ['title' => 'Loom Readings', 'route' => route('production.index')],
        ['title' => 'Rejected Returns', 'route' => route('factory.parchis')],
        ['title' => 'Beam Movement', 'route' => route('sizing.beams')],
        ['title' => 'Own Fabric Sales', 'route' => route('sales.index')],
        ['title' => 'Parts / Maintenance', 'route' => route('parts.index')],
        ['title' => 'Contracts / IPO', 'route' => route('sales.contracts')],
        ['title' => 'Records & Quick Print', 'route' => route('sales.index')],
        ['title' => 'New Contract / IPO', 'route' => route('sales.contracts')],
        ['title' => 'Parta / Quality Register', 'route' => route('factory.orders')],
        ['title' => 'Loom Assignment', 'route' => route('factory.orders')],
        ['title' => 'Beam Ownership Settlement', 'route' => route('sizing.balance')],
        ['title' => 'Contract Closure', 'route' => route('factory.orders')],
        ['title' => 'Rejected Fabric Disposition', 'route' => route('sales.index')],
    ];

    $commonLookups = [
        ['title' => 'Contracts', 'route' => route('sales.contracts')],
        ['title' => 'Parta', 'route' => route('factory.orders')],
        ['title' => 'Quick print', 'route' => route('sales.index')],
    ];
@endphp

<div class="space-y-4 pb-8">
    <header class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#15803d]">
                LoomFlow Operator Workspace
            </p>
            <h1 class="mt-1 text-2xl font-black tracking-tight text-[#133e2b] sm:text-3xl">
                Daily Transactions
            </h1>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">
                Open a transaction or jump straight to an active task.
            </p>
        </div>
    </header>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-5">
        <div class="space-y-4 xl:col-span-3">
            <section class="overflow-hidden rounded-xl border border-[#cbd6e2] bg-white shadow-sm">
                <header class="border-b border-[#cbd6e2] bg-[#edf3f8] px-4 py-3">
                    <h2 class="text-xs font-extrabold uppercase tracking-wide text-[#18334f]">Daily Transactions</h2>
                </header>
                <div class="divide-y divide-[#e2e8f0]">
                    @foreach($dailyTransactions as $index => $transaction)
                        <a href="{{ $transaction['route'] }}"
                           data-dashboard-shortcut="{{ $index + 1 }}"
                           class="group grid grid-cols-[2rem_minmax(0,1fr)_auto] items-center gap-3 px-3 py-2.5 transition hover:bg-[#edf5fc] focus-visible:outline focus-visible:outline-2 focus-visible:outline-inset focus-visible:outline-[#3b82f6]">
                            <span class="flex h-7 w-7 items-center justify-center rounded border border-[#cbd6e2] bg-[#f2f6fa] text-xs font-bold text-[#254461]">
                                {{ $index + 1 }}
                            </span>
                            <span class="min-w-0">
                                <span class="block truncate text-xs font-extrabold text-[#18334f]">{{ $transaction['title'] }}</span>
                                <span class="mt-0.5 block truncate text-[11px] text-slate-500">{{ $transaction['description'] }}</span>
                            </span>
                            <span class="rounded border border-[#d6e0e8] bg-[#f7f9fb] px-2 py-1 text-[10px] font-medium text-slate-500">
                                Alt+{{ $index + 1 }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="overflow-hidden rounded-xl border border-[#cbd6e2] bg-white shadow-sm">
                <header class="border-b border-[#cbd6e2] bg-[#edf3f8] px-4 py-3">
                    <h2 class="text-xs font-extrabold uppercase tracking-wide text-[#18334f]">More Tasks</h2>
                </header>
                <div class="grid grid-cols-1 gap-2 p-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($moreTasks as $task)
                        <a href="{{ $task['route'] }}"
                           class="rounded border border-[#cbd6e2] bg-[#f9fbfd] px-3 py-2 text-[11px] font-medium text-[#254461] transition hover:border-[#8eabc5] hover:bg-[#edf5fc] focus-visible:outline focus-visible:outline-2 focus-visible:outline-[#3b82f6]">
                            {{ $task['title'] }}
                        </a>
                    @endforeach
                </div>
            </section>

            <p class="px-2 text-[11px] text-slate-500">
                Use Alt+1-7 for daily transactions, or select a task above.
            </p>
        </div>

        <aside class="space-y-4 xl:col-span-2">
            <section class="overflow-hidden rounded-xl border border-[#cbd6e2] bg-white shadow-sm">
                <header class="flex items-center justify-between gap-3 border-b border-[#cbd6e2] bg-[#edf3f8] px-4 py-3">
                    <h2 class="text-xs font-extrabold uppercase tracking-wide text-[#18334f]">Pending Work</h2>
                    <span class="rounded-full bg-amber-100 px-2.5 py-1 text-[10px] font-bold text-amber-800">
                        {{ $pendingPakkiCount }} {{ $pendingPakkiCount === 1 ? 'Kachi' : 'Kachis' }}
                    </span>
                </header>
                <div class="divide-y divide-[#e2e8f0]">
                    @forelse($pendingPakkis as $kachi)
                        <div class="flex items-center justify-between gap-3 px-4 py-3">
                            <div class="min-w-0">
                                <p class="truncate text-xs font-extrabold text-[#18334f]">
                                    {{ $kachi->parchi_no }} · {{ $kachi->order?->party_name ?? $kachi->order?->customer_name ?? 'Customer' }}
                                </p>
                                <p class="mt-0.5 text-[11px] text-slate-500">
                                    {{ number_format((float) $kachi->dispatched_meters, 0) }} m awaiting Pakki
                                </p>
                            </div>
                            <a href="{{ route('factory.parchis') }}"
                               class="shrink-0 rounded border border-[#cbd6e2] bg-white px-3 py-1.5 text-[11px] font-semibold text-[#254461] hover:bg-[#edf5fc]">
                                Pakki
                            </a>
                        </div>
                    @empty
                        <p class="px-4 py-5 text-center text-xs text-slate-500">
                            No Kachi Parchis are waiting for Pakki.
                        </p>
                    @endforelse
                </div>
            </section>

            <section class="overflow-hidden rounded-xl border border-[#cbd6e2] bg-white shadow-sm">
                <header class="flex items-center justify-between gap-3 border-b border-[#cbd6e2] bg-[#edf3f8] px-4 py-3">
                    <h2 class="text-xs font-extrabold uppercase tracking-wide text-[#18334f]">Recent Records · Quick Print</h2>
                    <a href="{{ route('sales.index') }}"
                       class="rounded border border-[#cbd6e2] bg-white px-2.5 py-1 text-[10px] font-semibold text-[#254461] hover:bg-[#f7f9fb]">
                        All records
                    </a>
                </header>
                <div class="divide-y divide-[#e2e8f0]">
                    @forelse($recentDispatches as $dispatch)
                        <div class="flex items-center justify-between gap-3 px-4 py-2.5">
                            <div class="min-w-0">
                                <p class="truncate text-xs font-extrabold text-[#18334f]">
                                    {{ $dispatch->parchi_no }} · Kachi Parchi
                                </p>
                                <p class="mt-0.5 truncate text-[11px] text-slate-500">
                                    {{ $dispatch->order?->party_name ?? $dispatch->order?->customer_name ?? 'Customer' }}
                                    · {{ number_format((float) $dispatch->dispatched_meters, 0) }} m
                                </p>
                            </div>
                            <a href="{{ route('factory.kachi.print', $dispatch) }}"
                               target="_blank"
                               rel="noopener"
                               class="shrink-0 rounded border border-[#cbd6e2] bg-white px-3 py-1.5 text-[11px] font-semibold text-[#254461] hover:bg-[#edf5fc]">
                                Print
                            </a>
                        </div>
                    @empty
                        <p class="px-4 py-5 text-center text-xs text-slate-500">
                            No recent Parchis to print.
                        </p>
                    @endforelse
                </div>
            </section>

            <section class="overflow-hidden rounded-xl border border-[#cbd6e2] bg-white shadow-sm">
                <header class="border-b border-[#cbd6e2] bg-[#edf3f8] px-4 py-3">
                    <h2 class="text-xs font-extrabold uppercase tracking-wide text-[#18334f]">Common Lookups</h2>
                </header>
                <div class="grid grid-cols-3 gap-2 p-3">
                    @foreach($commonLookups as $lookup)
                        <a href="{{ $lookup['route'] }}"
                           class="rounded border border-[#cbd6e2] bg-[#f9fbfd] px-2 py-2 text-center text-[10px] font-semibold text-[#254461] transition hover:bg-[#edf5fc]">
                            {{ $lookup['title'] }}
                        </a>
                    @endforeach
                </div>
            </section>
        </aside>
    </div>
</div>
@endsection
