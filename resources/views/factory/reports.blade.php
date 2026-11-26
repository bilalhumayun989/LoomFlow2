@extends('layouts.app')
@section('title', 'Factory Reports')
@php
    $factoryReportsMode = request()->query('mode') === 'display' ? 'display' : 'operator';
    $activeFactoryReport = request()->query('report') === 'downtime' ? 'downtime' : 'production';
@endphp
@section('content')
<div class="max-w-7xl mx-auto pb-12 space-y-6">
    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#15803d]">FACTORY OPERATIONS REPORTS</span>
            <h1 class="text-2xl sm:text-3xl font-black text-[#133e2b] tracking-tight">Factory Reports</h1>
            <p class="text-xs sm:text-sm text-stone-500 mt-0.5">{{ $factoryReportsMode === 'operator' ? 'Record machine stoppages and maintenance.' : 'Review order production, party quantities, machine downtime, and stoppage history.' }}</p>
        </div>
    </header>

    @if($factoryReportsMode === 'operator')
        @if(session('success'))<div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"><p class="font-bold">Please check these entries:</p><ul class="mt-1 list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        <nav aria-label="Downtime entry" class="rounded-2xl border border-[#e2e8e0] bg-white p-3 shadow-sm">
            <button type="button" id="factory-stoppage-entry-shortcut" class="rounded-xl bg-[#133e2b] px-4 py-2 text-xs font-bold text-white">Loom Downtime / Maintenance <kbd class="ml-1 text-[10px]">Ctrl+1</kbd></button>
        </nav>

        <section id="factory-stoppage-entry" class="card p-6 space-y-4 shadow-2xs scroll-mt-24">
            <div class="pb-3 border-b border-[#e2e8e0]">
                <h2 class="font-extrabold text-base text-[#133e2b]">Loom Downtime / Maintenance</h2>
                <p class="text-xs text-stone-500">Record machine breakdowns, causes, and estimated repair costs.</p>
            </div>
            <form method="POST" action="{{ route('factory.stoppage.store') }}" class="space-y-3.5">
                @csrf
                <div class="grid sm:grid-cols-2 gap-3">
                    <label class="block text-xs font-bold text-stone-700">Loom
                        <select name="loom_no" required class="w-full border border-[#e2e8e0] rounded-xl p-2.5 mt-1 text-xs bg-white">
                            @foreach($looms as $loom)<option value="{{ $loom }}" @selected(old('loom_no') === $loom)>{{ $loom }}</option>@endforeach
                        </select>
                    </label>
                    <label class="block text-xs font-bold text-stone-700">Order (if applicable)
                        <select name="work_order_id" class="w-full border border-[#e2e8e0] rounded-xl p-2.5 mt-1 text-xs bg-white">
                            <option value="">General machine fault</option>
                            @foreach($orders as $order)<option value="{{ $order->id }}" @selected((string) old('work_order_id') === (string) $order->id)>{{ $order->order_no }}</option>@endforeach
                        </select>
                    </label>
                    <label class="block text-xs font-bold text-stone-700">Date
                        <input name="stopped_on" type="date" required value="{{ old('stopped_on', date('Y-m-d')) }}" class="w-full border border-[#e2e8e0] rounded-xl p-2.5 mt-1 text-xs">
                    </label>
                    <label class="block text-xs font-bold text-stone-700">Downtime (minutes)
                        <input name="downtime_minutes" required min="1" max="1440" type="number" value="{{ old('downtime_minutes') }}" placeholder="60" class="w-full border border-[#e2e8e0] rounded-xl p-2.5 mt-1 text-xs">
                    </label>
                </div>
                <label class="block text-xs font-bold text-stone-700">Reason
                    <input name="reason" required maxlength="150" value="{{ old('reason') }}" placeholder="Yarn break, beam change, mechanical, motor fault..." class="w-full border border-[#e2e8e0] rounded-xl p-2.5 mt-1 text-xs focus:outline-none focus:border-[#133e2b]">
                </label>
                <label class="block text-xs font-bold text-stone-700">Estimated Repair Cost (Rs)
                    <input name="repair_cost" min="0" step=".01" type="number" value="{{ old('repair_cost') }}" placeholder="0.00" class="w-full border border-[#e2e8e0] rounded-xl p-2.5 mt-1 text-xs focus:outline-none focus:border-[#133e2b]">
                </label>
                <textarea name="notes" rows="2" maxlength="1000" placeholder="Notes, parts used, electrician / mechanic name" class="w-full border border-[#e2e8e0] rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#133e2b]">{{ old('notes') }}</textarea>
                <button class="w-full bg-[#133e2b] hover:bg-[#1b5239] text-white rounded-xl p-3 font-bold text-xs shadow-2xs transition-all">Record Stoppage</button>
                <p class="text-[11px] text-stone-400">Issue spare parts through Parts. Record actual paid repairs through Expenses.</p>
            </form>
        </section>
        <script>
            document.getElementById('factory-stoppage-entry-shortcut')?.addEventListener('click', () => {
                document.querySelector('#factory-stoppage-entry input, #factory-stoppage-entry select')?.focus();
            });
            document.addEventListener('keydown', (event) => {
                if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && event.key === '1') {
                    event.preventDefault();
                    document.querySelector('#factory-stoppage-entry input, #factory-stoppage-entry select')?.focus();
                }
            });
        </script>
    @else
        <nav class="flex flex-wrap gap-2 rounded-2xl border border-[#e2e8e0] bg-white p-3 shadow-sm" aria-label="Factory report sections">
            <a href="{{ route('factory.reports', ['mode' => 'display', 'report' => 'production']) }}" data-factory-report-shortcut="1" @class(['rounded-xl px-4 py-2 text-xs font-bold transition', 'bg-[#133e2b] text-white' => $activeFactoryReport === 'production', 'bg-stone-100 text-stone-700 hover:bg-stone-200' => $activeFactoryReport !== 'production']) @if($activeFactoryReport === 'production') aria-current="page" @endif>Order Production <kbd class="ml-1 text-[10px]">Ctrl+1</kbd></a>
            <a href="{{ route('factory.reports', ['mode' => 'display', 'report' => 'downtime']) }}" data-factory-report-shortcut="2" @class(['rounded-xl px-4 py-2 text-xs font-bold transition', 'bg-[#133e2b] text-white' => $activeFactoryReport === 'downtime', 'bg-stone-100 text-stone-700 hover:bg-stone-200' => $activeFactoryReport !== 'downtime']) @if($activeFactoryReport === 'downtime') aria-current="page" @endif>Loom Downtime &amp; Stoppages <kbd class="ml-1 text-[10px]">Ctrl+2</kbd></a>
        </nav>
        <script>
            document.addEventListener('keydown', (event) => {
                if (!event.ctrlKey || event.shiftKey || event.altKey || event.metaKey || !['1', '2'].includes(event.key)) return;
                const tab = document.querySelector(`[data-factory-report-shortcut="${event.key}"]`);
                if (tab instanceof HTMLAnchorElement) {
                    event.preventDefault();
                    window.location.assign(tab.href);
                }
            });
        </script>

        @if($activeFactoryReport === 'production')
            <section id="order-production" class="card p-6 space-y-4 shadow-2xs scroll-mt-24">
                <div class="pb-3 border-b border-[#e2e8e0]">
                    <h2 class="text-base font-extrabold text-[#133e2b]">Order-wise Production and Party Hisaab</h2>
                    <p class="text-xs text-stone-500">Parta yarn estimates use checked metres and are converted from lb to kg. Recorded Taana/Baana issues are shown in kg. Metre variance is loom output minus checked length; investigate any difference before settling.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead><tr class="bg-stone-50 border-b border-stone-200 text-stone-600 text-[10px] font-bold uppercase tracking-wider">
                            <th class="p-3 text-left">Order / Type</th><th class="p-3">Quality</th><th class="p-3 text-right">Loom (m)</th><th class="p-3 text-right">Checked (m)</th><th class="p-3 text-right">Loom − Checked (m)</th><th class="p-3 text-right">Dispatched (m)</th><th class="p-3 text-right">Accepted (m)</th><th class="p-3 text-right">Job Bill (Rs)</th><th class="p-3 text-right">Parta estimate (kg)</th><th class="p-3 text-right">Recorded yarn issued (kg)</th>
                        </tr></thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($rows as $row)
                                <tr class="hover:bg-stone-50/70 transition-colors">
                                    <td class="p-3 font-bold text-stone-900">{{ $row['order']->order_no }}<small class="block text-stone-400 font-medium text-[10px]">{{ $row['order']->type }} &middot; {{ $row['order']->party_name ?? 'Factory' }}</small></td>
                                    <td class="p-3 text-stone-700">{{ $row['order']->fabricStock?->display_name }}</td>
                                    <td class="p-3 text-right text-stone-700 tabular-nums">{{ number_format($row['meterOutput'], 2) }}</td>
                                    <td class="p-3 text-right text-stone-700 tabular-nums">{{ number_format($row['checked'], 2) }}</td>
                                    <td class="p-3 text-right font-semibold tabular-nums {{ abs($row['meterVariance']) > 0.01 ? 'text-amber-700' : 'text-stone-700' }}" title="Loom output minus checked metres">{{ $row['meterVariance'] > 0 ? '+' : '' }}{{ number_format($row['meterVariance'], 2) }}</td>
                                    <td class="p-3 text-right text-stone-700 tabular-nums">{{ number_format($row['dispatched'], 2) }}</td>
                                    <td class="p-3 text-right text-stone-700 tabular-nums">{{ number_format($row['accepted'], 2) }}</td>
                                    <td class="p-3 text-right font-black text-[#133e2b] tabular-nums">Rs {{ number_format($row['billed'], 2) }}</td>
                                    <td class="p-3 text-right text-stone-700 tabular-nums">Taana {{ number_format($row['partaTaanaKg'], 2) }} / Baana {{ number_format($row['partaBaanaKg'], 2) }}</td>
                                    <td class="p-3 text-right font-semibold text-stone-700 tabular-nums">Taana {{ number_format($row['issuedTaana'], 2) }} / Baana {{ number_format($row['issuedBaana'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="10" class="p-6 text-center text-stone-400 italic">No orders created yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <p class="text-[11px] text-stone-400 leading-relaxed">Do not call these amounts net profit: full energy, labour, preparation and overhead allocation is not automated. The report shows traceable amounts, not an invented margin.</p>
            </section>
        @else
            <div class="space-y-6">
                <section class="card p-6 space-y-4 shadow-2xs">
                    <div class="pb-3 border-b border-[#e2e8e0]">
                        <h2 class="font-extrabold text-base text-[#133e2b]">Loom Downtime / Maintenance</h2>
                        <p class="text-xs text-stone-500">Review machine stoppage records and maintenance notes.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs">
                            <thead><tr class="bg-stone-50 border-b border-stone-200 text-stone-600 text-[10px] font-bold uppercase tracking-wider"><th class="p-3 text-left">Machine / Date</th><th class="p-3 text-left">Order</th><th class="p-3 text-left">Reason / Notes</th><th class="p-3 text-right">Minutes</th><th class="p-3 text-right">Repair Cost</th></tr></thead>
                            <tbody class="divide-y divide-stone-100">
                                @forelse($stoppages as $stoppage)
                                    <tr class="hover:bg-stone-50/60">
                                        <td class="p-3 font-bold text-stone-900">{{ $stoppage->loom_no }}<small class="block text-stone-400 font-medium text-[10px]">{{ $stoppage->stopped_on }}</small></td>
                                        <td class="p-3 text-stone-700">{{ $stoppage->order?->order_no ?? 'General fault' }}</td>
                                        <td class="p-3 text-stone-700">{{ $stoppage->reason }}@if($stoppage->notes)<small class="block text-stone-400">{{ $stoppage->notes }}</small>@endif</td>
                                        <td class="p-3 text-right font-bold text-amber-700">{{ $stoppage->downtime_minutes }}m</td>
                                        <td class="p-3 text-right font-semibold text-stone-800 tabular-nums">Rs {{ number_format((float) $stoppage->repair_cost, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="p-6 text-center text-stone-400 italic">No machine stoppages recorded yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        @endif
    @endif
</div>
@endsection
