@extends('layouts.app')

@section('title', 'Bags (Yarn) Management & Stock')

@section('workspace_sidebar')
    @if($page !== 'dashboard' || $mode === 'display')
    <aside class="hidden w-[250px] shrink-0 self-start rounded-3xl border border-zinc-200 bg-white p-4 shadow-sm lg:sticky lg:top-24 lg:my-6 lg:ml-6 lg:mr-4 lg:block">

        {{-- Dashboard main link --}}
        <a href="{{ route('bags.index', ['mode' => $mode]) }}"
           class="mb-4 flex items-center gap-3 rounded-2xl px-4 py-3 transition-all
                  {{ $page === 'dashboard'
                       ? 'bg-zinc-900 text-zinc-50 shadow-md'
                       : 'bg-zinc-50 text-zinc-700 border border-zinc-200 hover:bg-zinc-100 hover:text-zinc-900' }}">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                         {{ $page === 'dashboard' ? 'bg-zinc-700' : 'bg-zinc-200' }}">
                <svg class="h-5 w-5 {{ $page === 'dashboard' ? 'text-zinc-100' : 'text-zinc-600' }}"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </span>
            <div>
                <span class="block text-sm font-extrabold leading-tight">Bags Dashboard</span>
                <span class="block text-[10px] {{ $page === 'dashboard' ? 'text-zinc-400' : 'text-zinc-400' }} mt-0.5">Overview & all stats</span>
            </div>
        </a>

        <div class="mb-2 px-1 text-[10px] font-bold uppercase tracking-widest text-zinc-400">Sections</div>

        <nav class="space-y-1.5" aria-label="Bags sections">

            {{-- Purchases --}}
            <a href="{{ route('bags.purchases', ['mode' => $mode]) }}"
               class="flex items-center gap-3 w-full rounded-2xl px-3 py-2.5 text-xs font-bold transition-all
                      {{ $page === 'purchases'
                           ? 'bg-zinc-900 text-zinc-50 shadow-sm'
                           : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900' }}">
                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg
                             {{ $page === 'purchases' ? 'bg-zinc-700' : 'bg-zinc-100' }}">
                    <svg class="h-3.5 w-3.5 {{ $page === 'purchases' ? 'text-zinc-100' : 'text-zinc-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </span>
                <div>
                    <span class="block leading-tight">Bags Purchases</span>
                    <span class="block text-[10px] font-normal {{ $page === 'purchases' ? 'text-zinc-400' : 'text-zinc-400' }}">Split history & challan log</span>
                </div>
                @if($page === 'purchases')
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-zinc-400 shrink-0"></span>
                @endif
            </a>

            {{-- Daily Issuance --}}
            <a href="{{ route('bags.ledger', ['mode' => $mode]) }}"
               class="flex items-center gap-3 w-full rounded-2xl px-3 py-2.5 text-xs font-bold transition-all
                      {{ $page === 'ledger'
                           ? 'bg-zinc-900 text-zinc-50 shadow-sm'
                           : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900' }}">
                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg
                             {{ $page === 'ledger' ? 'bg-zinc-700' : 'bg-zinc-100' }}">
                    <svg class="h-3.5 w-3.5 {{ $page === 'ledger' ? 'text-zinc-100' : 'text-zinc-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </span>
                <div>
                    <span class="block leading-tight">Daily Stock Issuance</span>
                    <span class="block text-[10px] font-normal {{ $page === 'ledger' ? 'text-zinc-400' : 'text-zinc-400' }}">Factory to sizing ledger</span>
                </div>
                @if($page === 'ledger')
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-zinc-400 shrink-0"></span>
                @endif
            </a>

            {{-- Sizing Consumption --}}
            <a href="{{ route('bags.sizing-usage', ['mode' => $mode]) }}"
               class="flex items-center gap-3 w-full rounded-2xl px-3 py-2.5 text-xs font-bold transition-all
                      {{ $page === 'sizing'
                           ? 'bg-zinc-900 text-zinc-50 shadow-sm'
                           : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900' }}">
                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg
                             {{ $page === 'sizing' ? 'bg-zinc-700' : 'bg-zinc-100' }}">
                    <svg class="h-3.5 w-3.5 {{ $page === 'sizing' ? 'text-zinc-100' : 'text-zinc-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </span>
                <div>
                    <span class="block leading-tight">Sizing Bag Consumption</span>
                    <span class="block text-[10px] font-normal {{ $page === 'sizing' ? 'text-zinc-400' : 'text-zinc-400' }}">Usage, returns & held bags</span>
                </div>
                @if($page === 'sizing')
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-zinc-400 shrink-0"></span>
                @endif
            </a>

        </nav>

    </aside>
    @endif

@endsection

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="lg:col-span-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-900" role="status">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="lg:col-span-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-900" role="alert">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="lg:col-span-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900" role="alert">
            <p class="font-bold">Please correct these details:</p>
            <ul class="mt-1 list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <div class="min-w-0 space-y-6">

    @if($page !== 'dashboard' || $mode === 'display')
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-zinc-200">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-zinc-700"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-zinc-500">Module 01</span>
            </div>
            <h1 class="text-2xl font-black text-zinc-900 tracking-tight">{{ $page === 'dashboard' ? 'Bags Dashboard' : ['purchases' => 'Bags Purchases', 'ledger' => 'Daily Stock Issuance', 'sizing' => 'Sizing Bag Consumption'][$page] }}</h1>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            @if($mode === 'display')
                @if($page === 'dashboard')
                <a href="{{ route('sizing.index', ['mode' => 'display']) }}" class="px-3.5 py-2 rounded-xl bg-zinc-100 hover:bg-zinc-200 text-zinc-700 border border-zinc-300 text-xs font-bold transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Open Sizing</span>
                </a>
                @else
                <a href="{{ route('bags.index', ['mode' => 'display']) }}" class="px-3.5 py-2 rounded-xl bg-zinc-100 hover:bg-zinc-200 text-zinc-700 border border-zinc-300 text-xs font-bold transition-colors">Bags Dashboard</a>
                @endif
            @else
            <a href="#bag-purchase-entry" class="px-4 py-2 rounded-xl bg-zinc-900 hover:bg-zinc-700 text-zinc-50 font-extrabold text-xs shadow-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Buy Bags</span>
            </a>
            <a href="{{ route('bags.split') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-zinc-50 text-zinc-700 border border-zinc-300 text-xs font-bold transition-colors">Split Existing Bags</a>
            <a href="#bag-issue-entry" class="px-3.5 py-2 rounded-xl bg-zinc-100 hover:bg-zinc-200 text-zinc-700 border border-zinc-300 text-xs font-bold transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Issue Bags Daily</span>
            </a>
            <a href="#bag-return-entry" class="px-3.5 py-2 rounded-xl bg-zinc-100 hover:bg-zinc-200 text-zinc-700 border border-zinc-300 text-xs font-bold transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                <span>Receive Bags Return</span>
            </a>
            @endif
        </div>
    </div>
    @endif

@if($mode === 'operator')
@php
    $activeBagForm = $errors->has('name') ? 'quality' : match (old('purchase_form') === 'bag_purchase' ? 'purchase' : old('operation_form')) {
        'bag_issue' => 'issue',
        'bag_return' => 'return',
        default => 'purchase',
    };
@endphp
@if($page === 'dashboard' && $mode === 'operator')
<nav class="mb-4 flex flex-wrap items-center gap-2 rounded-2xl border border-zinc-200 bg-white p-3 shadow-sm" aria-label="Bag entry forms" role="tablist">
    <span class="mr-2 text-xs font-bold uppercase tracking-wide text-zinc-500">Entry form</span>
    <button type="button" class="bag-form-tab rounded-xl bg-zinc-900 px-4 py-2 text-xs font-bold text-white" data-bag-form-tab="purchase" role="tab" aria-controls="bag-purchase-entry" aria-selected="true">Purchase <kbd class="ml-1 text-[10px] text-zinc-300">Ctrl+1</kbd></button>
    <button type="button" class="bag-form-tab rounded-xl bg-zinc-100 px-4 py-2 text-xs font-bold text-zinc-700 hover:bg-zinc-200" data-bag-form-tab="issue" role="tab" aria-controls="bag-issue-entry" aria-selected="false">Issue stock daily <kbd class="ml-1 text-[10px]">Ctrl+2</kbd></button>
    <button type="button" class="bag-form-tab rounded-xl bg-zinc-100 px-4 py-2 text-xs font-bold text-zinc-700 hover:bg-zinc-200" data-bag-form-tab="return" role="tab" aria-controls="bag-return-entry" aria-selected="false">Receive return <kbd class="ml-1 text-[10px]">Ctrl+3</kbd></button>
    <button type="button" class="bag-form-tab rounded-xl bg-zinc-100 px-4 py-2 text-xs font-bold text-zinc-700 hover:bg-zinc-200" data-bag-form-tab="quality" role="tab" aria-controls="yarn-quality-entry" aria-selected="false">Create yarn quality <kbd class="ml-1 text-[10px]">Ctrl+4</kbd></button>
</nav>
@endif
<!-- On-page purchase entry -->
<section id="bag-purchase-entry" data-bag-form-panel="purchase" @if($page === 'dashboard' && $mode === 'operator' && $activeBagForm !== 'purchase') hidden @endif class="scroll-mt-28 rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm sm:p-6">
    <div class="mx-auto max-w-5xl">
        <div class="flex items-center justify-between pb-3 border-b border-zinc-100">
            <div>
                <h3 class="text-lg font-bold text-zinc-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-zinc-700"></span>
                    New Bag Purchase (Yarn)
                </h3>
                <p class="text-xs text-zinc-400">Enter purchase & split between Sizing and Factory Stock Store</p>
            </div>
        </div>
        <form id="bag-purchase-form" action="{{ route('bags.purchase') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <input type="hidden" name="purchase_form" value="bag_purchase">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 mb-1">Challan / Invoice # *</label>
                    <input type="text" name="challan_no" required placeholder="e.g. CH-8901" value="{{ old('challan_no') }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 mb-1">Purchase Date *</label>
                    <input type="date" name="purchase_date" required value="{{ old('purchase_date', date('Y-m-d')) }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 mb-1">Spinning Mill / Supplier *</label>
                    <input type="text" name="supplier_name" required placeholder="e.g. Al-Karam Spinning" value="{{ old('supplier_name') }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 mb-1">Yarn Quality / Count *</label>
                    <div class="flex gap-2">
                        <select name="quality" required data-yarn-quality-select class="min-w-0 flex-1 bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                            <option value="">Select yarn quality</option>
                            @foreach($yarnQualities as $yarnQuality)<option value="{{ $yarnQuality->name }}" @selected(old('quality') === $yarnQuality->name)>{{ $yarnQuality->display_name }}</option>@endforeach
                        </select>
                        <a href="#yarn-quality-entry" class="shrink-0 rounded-xl border border-zinc-300 bg-white px-3 py-2 text-xs font-bold text-zinc-700 transition-colors hover:bg-zinc-100">+ Add quality below</a>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 mb-1">Total Bags Purchased *</label>
                    <input type="number" step="0.01" id="inpTotalBags" name="total_bags" required min="0.01" placeholder="100" value="{{ old('total_bags') }}" oninput="calculateSplit()" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-zinc-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 mb-1">Rate Per Bag (Rs.) *</label>
                    <input type="number" step="0.01" id="inpRatePerBag" name="rate_per_bag" required min="0" placeholder="14500" value="{{ old('rate_per_bag') }}" oninput="calculateSplit()" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 font-mono focus:outline-none focus:ring-2 focus:ring-zinc-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 mb-1">Cones in Each Bag *</label>
                    <input type="number" name="cones_per_bag" required min="1" max="1000" step="1" placeholder="e.g. 48" value="{{ old('cones_per_bag') }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 font-mono focus:outline-none focus:ring-2 focus:ring-zinc-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 mb-1">Paid From Account *</label>
                    <select name="financial_account_id" required class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                        <option value="">Select cash / bank account</option>
                        @foreach($activeAccounts as $account)<option value="{{ $account->id }}" @selected((string) old('financial_account_id') === (string) $account->id)>{{ $account->name }}</option>@endforeach
                    </select>
                </div>
            </div>
            <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-3">
                @if($errors->any() && old('purchase_form') === 'bag_purchase')
                    <div class="rounded-xl border border-red-200 bg-red-50 p-3 text-xs text-red-800">
                        <p class="font-bold">Please correct the purchase details below:</p>
                        <ul class="mt-1 list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @elseif(session('error') && old('purchase_form') === 'bag_purchase')
                    <div class="rounded-xl border border-red-200 bg-red-50 p-3 text-xs font-semibold text-red-800">{{ session('error') }}</div>
                @endif
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-zinc-600">📦 Dispatch Split: Sizing vs Factory</span>
                    <span id="splitStatus" class="text-xs font-bold font-mono text-zinc-500">Total: 0 Bags</span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-600 mb-1">Direct to Sizing (Bags)</label>
                        <input type="number" step="0.01" id="inpBagsToSizing" name="bags_to_sizing" value="{{ old('bags_to_sizing', 0) }}" min="0" oninput="markPurchaseSplitAsManual()" class="w-full bg-white border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-zinc-500">
                        <span class="text-[10px] text-zinc-400">Leave 0 or blank if none are sent directly</span>
                        @error('bags_to_sizing')<span class="mt-1 block text-[10px] font-semibold text-red-700">{{ $message }}</span>@enderror
                        <span id="displaySizingBagWeight" class="block text-[10px] font-semibold text-zinc-600">0 bags · 0.00 kg / 0 lb</span>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-600 mb-1">To Factory Godown (Bags)</label>
                        <input type="number" step="0.01" id="inpBagsToFactory" name="bags_to_factory" value="{{ old('bags_to_factory', 0) }}" min="0" oninput="markPurchaseSplitAsManual()" class="w-full bg-white border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-zinc-500">
                        <span class="text-[10px] text-zinc-400">Stored in mill warehouse</span>
                    </div>
                </div>
                <div id="sizingDestinationWrap" class="hidden">
                    <label class="block text-[11px] font-semibold text-zinc-600 mb-1">Sizing Mill / Contractor *</label>
                    <input type="text" id="inpSizingDestination" name="sizing_destination" value="{{ old('sizing_destination') }}" placeholder="e.g. National Sizing Mill" class="w-full bg-white border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                    @error('sizing_destination')<span class="mt-1 block text-[10px] font-semibold text-red-700">{{ $message }}</span>@enderror
                    <span class="mt-1 block text-[10px] text-zinc-500">This will appear as a pending sizing entry with the bag quantity and quality already filled.</span>
                </div>
                <div class="pt-2 border-t border-zinc-200 flex items-center justify-between text-xs">
                    <span class="text-zinc-500">Calculated Total Amount:</span>
                    <strong id="displayTotalAmount" class="font-mono text-zinc-900 text-sm">Rs. 0.00</strong>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-600 mb-1">Notes / Contract Details</label>
                <textarea name="notes" rows="2" placeholder="e.g. Contract #889, direct dispatch" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">{{ old('notes') }}</textarea>
            </div>
            <div class="pt-3 border-t border-zinc-100 flex justify-end gap-3">
                <button type="submit" id="btnSubmitPurchase" class="px-5 py-2 rounded-xl bg-zinc-900 hover:bg-zinc-700 text-zinc-50 text-xs font-black shadow-sm">Save Purchase & Split</button>
            </div>
        </form>
    </div>
</section>

<!-- On-page stock issue entry -->
<section id="bag-issue-entry" data-bag-form-panel="issue" @if($page === 'dashboard' && $mode === 'operator' && $activeBagForm !== 'issue') hidden @endif class="scroll-mt-28 rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm sm:p-6">
    <div class="mx-auto max-w-5xl">
        <div class="flex items-center justify-between pb-3 border-b border-zinc-100">
            <h3 class="text-lg font-bold text-zinc-900 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-zinc-600"></span>
                Issue Stock Daily (From Factory)
            </h3>
        </div>
        <form id="bag-issue-form" action="{{ route('bags.issue') }}" method="POST" class="mt-4 grid gap-4 sm:grid-cols-2">
            @csrf
            <input type="hidden" name="operation_form" value="bag_issue">
            <div>
                <label class="block text-xs font-semibold text-zinc-600 mb-1">Issuance Reference / Slip # *</label>
                <input type="text" name="reference_no" required placeholder="e.g. ISS-105" value="{{ old('reference_no') }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 mb-1">Date *</label>
                    <input type="date" name="transaction_date" required value="{{ old('transaction_date', date('Y-m-d')) }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 mb-1">Quantity (Bags) *</label>
                    <input type="number" id="inpIssueBags" name="quantity_bags" required min="0.01" step="0.01" max="{{ $factoryStoreStock }}" placeholder="10" value="{{ old('quantity_bags') }}" oninput="updateIssueBagWeight()" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-zinc-500">
                    <span class="text-[10px] text-zinc-500">In Godown: {{ $factoryStoreStock }} bags · <span id="displayIssueBagWeight">0.00 kg</span></span>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-600 mb-1">Yarn Quality *</label>
                <div class="flex gap-2">
                    <select name="quality" required data-yarn-quality-select class="min-w-0 flex-1 bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                        <option value="">Select yarn quality</option>
                        @foreach($yarnQualities as $yarnQuality)<option value="{{ $yarnQuality->name }}" @selected(old('quality') === $yarnQuality->name)>{{ $yarnQuality->display_name }}</option>@endforeach
                    </select>
                <a href="#yarn-quality-entry" class="shrink-0 rounded-xl border border-zinc-300 bg-white px-3 py-2 text-xs font-bold text-zinc-700 transition-colors hover:bg-zinc-100">+ Add quality below</a>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-600 mb-1">Destination / Sizing Mill *</label>
                <input type="text" name="destination" required placeholder="e.g. National Sizing Mill" value="{{ old('destination') }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-600 mb-1">Receiver Name / Contractor *</label>
                <input type="text" name="party_name" required placeholder="e.g. Master Aslam" value="{{ old('party_name') }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-600 mb-1">Link to Work Order (optional)</label>
                <select name="work_order_id" id="issueWorkOrder" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                    <option value="">General factory issue (no order khata)</option>
                    @foreach($activeWorkOrders as $workOrder)
                        <option value="{{ $workOrder->id }}" @selected((string) old('work_order_id') === (string) $workOrder->id)>{{ $workOrder->order_no }} · {{ $workOrder->party_name ?? 'Factory' }}</option>
                    @endforeach
                </select>
                <p class="mt-1 text-[10px] text-zinc-500">Select an order to create its yarn issue automatically. Enter the actual measured weight below.</p>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <label class="block text-xs font-semibold text-zinc-600">Order component
                    <select name="component" id="issueComponent" class="w-full mt-1 bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900">
                        <option value="">Select when linking order</option>
                        <option value="warp" @selected(old('component') === 'warp')>Taana / Warp</option>
                        <option value="weft" @selected(old('component') === 'weft')>Baana / Weft</option>
                    </select>
                </label>
                <label class="block text-xs font-semibold text-zinc-600">Measured net weight (kg)
                    <input type="number" name="net_weight_kg" min=".001" step=".001" value="{{ old('net_weight_kg') }}" class="w-full mt-1 bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900" placeholder="Required for order link">
                </label>
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-600 mb-1">Remarks</label>
                <input type="text" name="notes" value="{{ old('notes') }}" placeholder="e.g. Lot for beam set 4" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>
            <div class="sm:col-span-2 pt-3 border-t border-zinc-100 flex justify-end gap-3">
                <button type="submit" class="px-5 py-2 rounded-xl bg-zinc-900 hover:bg-zinc-700 text-zinc-50 text-xs font-black">Confirm Issuance</button>
            </div>
        </form>
    </div>
</section>

<!-- On-page return entry -->
<section id="bag-return-entry" data-bag-form-panel="return" @if($page === 'dashboard' && $mode === 'operator' && $activeBagForm !== 'return') hidden @endif class="scroll-mt-28 rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm sm:p-6">
    <div class="mx-auto max-w-5xl">
        <div class="flex items-center justify-between pb-3 border-b border-zinc-100">
            <h3 class="text-lg font-bold text-zinc-900 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-zinc-500"></span>
                Receive Unused Bags Back
            </h3>
        </div>
        <form id="bag-return-form" action="{{ route('bags.return') }}" method="POST" class="mt-4 grid gap-4 sm:grid-cols-2">
            @csrf
            <input type="hidden" name="operation_form" value="bag_return">
            <div>
                <label class="block text-xs font-semibold text-zinc-600 mb-1">Return Slip / Ref # *</label>
                <input type="text" name="reference_no" required placeholder="e.g. RET-45" value="{{ old('reference_no') }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 mb-1">Date *</label>
                    <input type="date" name="transaction_date" required value="{{ old('transaction_date', date('Y-m-d')) }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 mb-1">Quantity Returned (Bags) *</label>
                    <input type="number" name="quantity_bags" required min="0.01" step="0.01" placeholder="5" value="{{ old('quantity_bags') }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-zinc-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-600 mb-1">Yarn Quality *</label>
                <div class="flex gap-2">
                    <select name="quality" required data-yarn-quality-select class="min-w-0 flex-1 bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                        <option value="">Select yarn quality</option>
                        @foreach($yarnQualities as $yarnQuality)<option value="{{ $yarnQuality->name }}" @selected(old('quality') === $yarnQuality->name)>{{ $yarnQuality->display_name }}</option>@endforeach
                    </select>
                    <a href="#yarn-quality-entry" class="shrink-0 rounded-xl border border-zinc-300 bg-white px-3 py-2 text-xs font-bold text-zinc-700 transition-colors hover:bg-zinc-100">+ Add quality below</a>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-600 mb-1">Returning Sizing Mill / Party *</label>
                <input type="text" name="source" required placeholder="e.g. National Sizing Mill" value="{{ old('source') }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-600 mb-1">Contractor / Person Name *</label>
                <input type="text" name="party_name" required placeholder="e.g. Sizing Contractor" value="{{ old('party_name') }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-600 mb-1">Reason / Notes</label>
                <input type="text" name="notes" placeholder="e.g. Surplus bags from completed beam set" value="{{ old('notes') }}" class="w-full bg-zinc-50 border border-zinc-300 rounded-xl px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
            </div>
            <div class="sm:col-span-2 pt-3 border-t border-zinc-100 flex justify-end gap-3">
                <button type="submit" class="px-5 py-2 rounded-xl bg-zinc-900 hover:bg-zinc-700 text-zinc-50 text-xs font-black">Receive into Godown</button>
            </div>
        </form>
    </div>
</section>
@endif

@push('scripts')
@if($page !== 'dashboard' || $mode === 'operator')
<script>
    let purchaseSplitManuallyAdjusted = false;

    @if($page === 'dashboard' && $mode === 'operator')
    function showBagEntryForm(formName, focusInput = false) {
        document.querySelectorAll('[data-bag-form-panel]').forEach((panel) => {
            panel.hidden = panel.dataset.bagFormPanel !== formName;
        });

        document.querySelectorAll('[data-bag-form-tab]').forEach((tab) => {
            const isSelected = tab.dataset.bagFormTab === formName;
            tab.setAttribute('aria-selected', String(isSelected));
            tab.classList.toggle('bg-zinc-900', isSelected);
            tab.classList.toggle('text-white', isSelected);
            tab.classList.toggle('bg-zinc-100', !isSelected);
            tab.classList.toggle('text-zinc-700', !isSelected);
        });

        if (focusInput) {
            document.querySelector(`[data-bag-form-panel="${formName}"] input:not([type="hidden"]), [data-bag-form-panel="${formName}"] select, [data-bag-form-panel="${formName}"] textarea`)?.focus();
        }
    }

    document.querySelectorAll('[data-bag-form-tab]').forEach((tab) => {
        tab.addEventListener('click', () => showBagEntryForm(tab.dataset.bagFormTab, true));
    });

    if (window.location.hash === '#yarn-quality-entry') {
        showBagEntryForm('quality');
    }

    document.addEventListener('keydown', (event) => {
        if (!event.ctrlKey || event.altKey || event.metaKey) {
            return;
        }

        const formByShortcut = { '1': 'purchase', '2': 'issue', '3': 'return', '4': 'quality' };
        const formName = formByShortcut[event.key];
        if (!formName) {
            return;
        }

        event.preventDefault();
        showBagEntryForm(formName, true);
    });
    @endif

    function updateSizingDestination() {
        const quantity = parseFloat(document.getElementById('inpBagsToSizing').value) || 0;
        const wrap = document.getElementById('sizingDestinationWrap');
        const destination = document.getElementById('inpSizingDestination');
        wrap.classList.toggle('hidden', quantity <= 0);
        destination.required = quantity > 0;
    }

    function updateSizingBagWeight() {
        const bags = parseFloat(document.getElementById('inpBagsToSizing').value) || 0;
        document.getElementById('displaySizingBagWeight').innerText = `${bags} bags · ${(bags * 45.359237).toFixed(2)} kg / ${(bags * 100).toLocaleString()} lb`;
    }

    function updateIssueBagWeight() {
        const bags = parseFloat(document.getElementById('inpIssueBags').value) || 0;
        document.getElementById('displayIssueBagWeight').innerText = `${(bags * 45.359237).toFixed(2)} kg (${(bags * 100).toLocaleString()} lb)`;
    }

    function calculateSplit() {
        const total = parseFloat(document.getElementById('inpTotalBags').value) || 0;
        if (!purchaseSplitManuallyAdjusted) {
            const half = Math.floor(total * 50) / 100;
            document.getElementById('inpBagsToSizing').value = half;
            document.getElementById('inpBagsToFactory').value = total - half;
        }
        updateSizingDestination();
        updateSizingBagWeight();
        validateSplitNumbers();
    }

    function markPurchaseSplitAsManual() {
        purchaseSplitManuallyAdjusted = true;
        validateSplitNumbers();
        updateSizingDestination();
        updateSizingBagWeight();
    }

    function validateSplitNumbers() {
        const total = parseFloat(document.getElementById('inpTotalBags').value) || 0;
        const rate = parseFloat(document.getElementById('inpRatePerBag').value) || 0;
        const sizing = parseFloat(document.getElementById('inpBagsToSizing').value) || 0;
        const factory = parseFloat(document.getElementById('inpBagsToFactory').value) || 0;
        const sum = sizing + factory;
        const statusEl = document.getElementById('splitStatus');
        const submitBtn = document.getElementById('btnSubmitPurchase');
        document.getElementById('displayTotalAmount').innerText = 'Rs. ' + (total * rate).toLocaleString('en-US', {minimumFractionDigits: 2});
        if (Math.round(sum * 100) === Math.round(total * 100) && total > 0) {
            statusEl.innerText = `Matched: ${sizing} Sizing + ${factory} Factory = ${total} ✓`;
            statusEl.className = 'text-xs font-bold font-mono text-zinc-700';
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            statusEl.innerText = `Sum: ${sum} / ${total} Bags ✗`;
            statusEl.className = 'text-xs font-bold font-mono text-zinc-400';
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    updateSizingDestination();
    updateSizingBagWeight();
    validateSplitNumbers();
    @if(old('purchase_form') === 'bag_purchase')
        purchaseSplitManuallyAdjusted = true;
        document.getElementById('bag-purchase-entry')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    @elseif(old('operation_form') === 'bag_issue')
        document.getElementById('bag-issue-entry')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    @elseif(old('operation_form') === 'bag_return')
        document.getElementById('bag-return-entry')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    @endif
</script>
@endpush
@include('yarn-qualities.modal')
@endif

    <!-- KPI Metric Cards -->
    @if ($page === 'dashboard' && $mode === 'display')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="glass-card rounded-2xl p-4 border border-zinc-300 bg-zinc-50">
            <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-700 flex items-center justify-between">
                <span>Total Bags Purchased</span>
                <span class="w-2 h-2 rounded-full bg-zinc-700"></span>
            </div>
            <div class="text-2xl font-black text-zinc-900 mt-1">{{ number_format($totalPurchased) }} <span class="text-xs font-normal text-zinc-400">bags</span></div>
            <div class="text-[11px] text-zinc-400 mt-1 font-mono">Rs. {{ number_format($totalYarnInvestment, 0) }}</div>
        </div>

        <div class="glass-card rounded-2xl p-4 border border-zinc-300 bg-zinc-50">
            <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-700 flex items-center justify-between">
                <span>Factory Stock Store</span>
                <span class="w-2 h-2 rounded-full bg-zinc-700"></span>
            </div>
            <div class="text-2xl font-black text-zinc-900 mt-1">{{ number_format((float) $factoryStoreStock, 2) }} <span class="text-xs font-normal text-zinc-400">bags</span></div>
            <div class="text-[11px] text-zinc-500 mt-1">Ready in Mill Godown</div>
        </div>

        <div class="glass-card rounded-2xl p-4 border border-zinc-200">
            <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-500 flex items-center justify-between">
                <span>With Sizing Persons</span>
                <span class="w-2 h-2 rounded-full bg-zinc-400"></span>
            </div>
            <div class="text-2xl font-black text-zinc-900 mt-1">{{ number_format((float) $sizingStockRemaining, 2) }} <span class="text-xs font-normal text-zinc-400">bags</span></div>
            <div class="text-[11px] text-zinc-500 mt-1">Allocated to Sizing Mills</div>
        </div>

        <div class="glass-card rounded-2xl p-4 border border-zinc-300 bg-zinc-50">
            <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-700 flex items-center justify-between">
                <span>Bags Used In Beams</span>
                <span class="w-2 h-2 rounded-full bg-zinc-600"></span>
            </div>
            <div class="text-2xl font-black text-zinc-900 mt-1">{{ number_format((float) $totalBagsUsedInBeams, 2) }} <span class="text-xs font-normal text-zinc-400">bags</span></div>
            <div class="text-[11px] text-zinc-500 mt-1">Converted to Sizing Beams</div>
        </div>

        <div class="glass-card rounded-2xl p-4 border border-zinc-300 bg-zinc-50">
            <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-700 flex items-center justify-between">
                <span>Unused Bags Status</span>
                <span class="w-2 h-2 rounded-full bg-zinc-500"></span>
            </div>
            <div class="text-xs font-bold text-zinc-800 mt-1">
                <div class="flex justify-between py-0.5"><span class="text-zinc-500">Returned:</span> <span class="font-mono">{{ number_format((float) $unusedBagsReturned, 2) }} bags</span></div>
                <div class="flex justify-between py-0.5"><span class="text-zinc-500">Held in Sizing:</span> <span class="font-mono">{{ number_format((float) $unusedBagsHeldWithSizing, 2) }} bags</span></div>
            </div>
        </div>
    </div>
    <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm">
        <div class="mb-3">
            <h2 class="text-sm font-extrabold text-zinc-900">Stock by Yarn Quality</h2>
            <p class="mt-1 text-[11px] text-zinc-500">Each quality is balanced separately across the factory store and sizing mills.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[520px] text-xs">
                <thead><tr class="border-b border-zinc-100 text-left text-[10px] uppercase tracking-wide text-zinc-400"><th class="py-2 pr-3">Yarn quality</th><th class="px-3 py-2 text-right">Factory stock</th><th class="px-3 py-2 text-right">With sizing</th><th class="py-2 pl-3 text-right">Total remaining</th></tr></thead>
                <tbody>
                    @forelse($qualityBalances as $balance)
                        <tr class="border-b border-zinc-50 last:border-0"><td class="py-2.5 pr-3 font-semibold text-zinc-800">{{ $balance['display_name'] }}</td><td class="px-3 py-2.5 text-right font-mono">{{ number_format($balance['factory_stock'], 2) }}</td><td class="px-3 py-2.5 text-right font-mono">{{ number_format($balance['sizing_stock'], 2) }}</td><td class="py-2.5 pl-3 text-right font-mono font-bold">{{ number_format($balance['total'], 2) }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="py-4 text-center text-zinc-400">Create a yarn quality to start tracking stock.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ============================================================
         SECTION 1 — Bag Purchases
    ============================================================ --}}
    @if (in_array($page, ['dashboard', 'purchases'], true) && ($page !== 'dashboard' || $mode === 'display'))
    <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm overflow-hidden">

        {{-- Card header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 bg-zinc-50">
            <div class="flex items-center gap-2.5">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-zinc-900">
                    <svg class="h-4 w-4 text-zinc-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </span>
                <div>
                    <h2 class="text-sm font-extrabold text-zinc-900 leading-tight">
                        {{ $page === 'dashboard' ? 'Recent Purchases' : 'Bags Purchases & Split History' }}
                    </h2>
                    <p class="text-[10px] text-zinc-400 mt-0.5">Challan-wise purchase log with sizing / factory split</p>
                </div>
            </div>
            @if($page === 'dashboard')
                <a href="{{ route('bags.purchases', ['mode' => $mode]) }}" class="text-[11px] font-bold text-zinc-500 hover:text-zinc-900 transition-colors">
                    View all &rarr;
                </a>
            @endif
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-zinc-200 text-zinc-500 font-semibold uppercase text-[10px] tracking-wider bg-zinc-50">
                        <th class="px-4 py-3">Challan #</th>
                        <th class="px-4 py-3">Purchase Date</th>
                        <th class="px-4 py-3">Spinning Supplier</th>
                        <th class="px-4 py-3">Quality / Count</th>
                        <th class="px-4 py-3 text-right">Total Bags</th>
                        <th class="px-4 py-3 text-center bg-zinc-100/70 text-zinc-600 border-x border-zinc-200">To Sizing</th>
                        <th class="px-4 py-3 text-center bg-zinc-100/70 text-zinc-600 border-r border-zinc-200">To Factory Store</th>
                        <th class="px-4 py-3 text-right">Rate / Bag</th>
                        <th class="px-4 py-3 text-right">Total Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($purchases as $p)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-4 py-3 font-mono font-bold text-zinc-900">{{ $p->challan_no }}</td>
                            <td class="px-4 py-3 text-zinc-500">{{ $p->purchase_date->format('d M, Y') }}</td>
                            <td class="px-4 py-3 font-semibold text-zinc-800">{{ $p->supplier_name }}</td>
                            <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-md bg-zinc-100 text-zinc-700 font-mono text-[11px]">{{ $p->yarnQuality?->display_name ?? $p->quality }}</span><span class="block mt-1 text-[10px] text-zinc-500">{{ number_format((int) $p->cones_per_bag) }} cones / bag</span></td>
                            <td class="px-4 py-3 text-right font-black text-zinc-900">{{ number_format((float) $p->total_bags, 2) }}</td>
                            <td class="px-4 py-3 text-center font-bold font-mono text-zinc-800 bg-zinc-50 border-x border-zinc-200">
                                {{ number_format((float) $p->bags_to_sizing, 2) }}
                                <span class="block text-[10px] font-normal text-zinc-500">{{ $p->sizing_destination ?: '—' }} · {{ number_format((float) $p->bags_to_sizing * 45.359237, 2) }} kg</span>
                            </td>
                            <td class="px-4 py-3 text-center font-bold font-mono text-zinc-800 bg-zinc-50 border-r border-zinc-200">{{ number_format((float) $p->bags_to_factory, 2) }}</td>
                            <td class="px-4 py-3 text-right font-mono text-zinc-500">Rs. {{ number_format($p->rate_per_bag, 2) }}</td>
                            <td class="px-4 py-3 text-right font-mono font-bold text-zinc-900">Rs. {{ number_format($p->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="px-4 py-8 text-center text-zinc-400">No bag purchases entered yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($page === 'purchases')
            <div class="px-6 py-4 border-t border-zinc-100">{{ $purchases->links() }}</div>
        @endif
    </div>
    @endif


    {{-- ============================================================
         SECTION 2 — Daily Stock Issuance Ledger
    ============================================================ --}}
    @if (in_array($page, ['dashboard', 'ledger'], true) && ($page !== 'dashboard' || $mode === 'display'))
    <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm overflow-hidden">

        <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 bg-zinc-50">
            <div class="flex items-center gap-2.5">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-zinc-900">
                    <svg class="h-4 w-4 text-zinc-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </span>
                <div>
                    <h2 class="text-sm font-extrabold text-zinc-900 leading-tight">
                        {{ $page === 'dashboard' ? 'Recent Stock Movements' : 'Daily Stock Issuance & Ledger Log' }}
                    </h2>
                    <p class="text-[10px] text-zinc-400 mt-0.5">Factory yarn, customer-owned receipts, sizing issues, and returns</p>
                </div>
            </div>
            @if($page === 'dashboard')
                <a href="{{ route('bags.ledger', ['mode' => $mode]) }}" class="text-[11px] font-bold text-zinc-500 hover:text-zinc-900 transition-colors">
                    View all &rarr;
                </a>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-zinc-200 text-zinc-500 font-semibold uppercase text-[10px] tracking-wider bg-zinc-50">
                        <th class="px-4 py-3">Date</th><th class="px-4 py-3">Type</th><th class="px-4 py-3">Ref #</th>
                        <th class="px-4 py-3">Quality</th><th class="px-4 py-3 text-right">Qty</th>
                        <th class="px-4 py-3">Source</th><th class="px-4 py-3">Destination</th>
                        <th class="px-4 py-3">Party / Mill</th><th class="px-4 py-3">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-4 py-3 text-zinc-500 font-mono">{{ $tx->transaction_date->format('d M, Y') }}</td>
                            <td class="px-4 py-3">
                                @if($tx->transaction_type === 'purchase_factory')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-zinc-200 text-zinc-700 border border-zinc-300">Factory Purchase</span>
                                @elseif($tx->transaction_type === 'purchase_sizing')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-zinc-200 text-zinc-700 border border-zinc-300">Direct Sizing</span>
                                @elseif($tx->transaction_type === 'issue_to_sizing')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-zinc-900 text-zinc-50">Issued To Sizing</span>
                                @elseif($tx->transaction_type === 'return_from_sizing')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-zinc-100 text-zinc-600 border border-zinc-200">Returned</span>
                                @elseif($tx->transaction_type === 'customer_sizing_receipt')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-200">Customer Bags Received</span>
                                @elseif($tx->transaction_type === 'customer_return_sizing')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">Customer Bags Returned</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-zinc-100 text-zinc-500">{{ $tx->transaction_type }}</span>
                                @endif
                                @if($tx->owner_type === 'customer')
                                    <span class="mt-1 block text-[9px] font-extrabold uppercase tracking-wide text-amber-800">Customer property</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-mono font-semibold text-zinc-900">{{ $tx->reference_no ?? '-' }}</td>
                            <td class="px-4 py-3 font-medium text-zinc-700">{{ $tx->yarnQuality?->display_name ?? $tx->quality }}</td>
                            <td class="px-4 py-3 text-right font-mono font-bold text-zinc-900">
                                {{ number_format((float) $tx->quantity_bags, 2) }} Bags
                                @if($tx->cones_per_bag)<span class="block text-[10px] font-medium text-zinc-500">{{ number_format((int) $tx->cones_per_bag) }} cones / bag</span>@endif
                                @if($tx->net_weight_kg)<span class="block text-[10px] font-medium text-zinc-500">{{ number_format((float) $tx->net_weight_kg, 3) }} kg</span>@endif
                                @if($tx->transaction_type === 'customer_sizing_receipt')<span class="block text-[10px] font-medium text-zinc-500">{{ number_format((float) $tx->quantity_bags * 100, 2) }} lb · 100 lb / bag</span>@endif
                            </td>
                            <td class="px-4 py-3 text-zinc-500">{{ $tx->source }}</td>
                            <td class="px-4 py-3 text-zinc-700 font-semibold">{{ $tx->destination }}</td>
                            <td class="px-4 py-3 text-zinc-600">{{ $tx->party_name ?? '-' }}</td>
                            <td class="px-4 py-3 text-zinc-400 italic">{{ $tx->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="px-4 py-8 text-center text-zinc-400">No stock transactions logged yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($page === 'ledger')
            <div class="px-6 py-4 border-t border-zinc-100">{{ $transactions->links() }}</div>
        @endif
    </div>
    @endif


    {{-- ============================================================
         SECTION 3 — Sizing Bag Consumption & Returns
    ============================================================ --}}
    @if (in_array($page, ['dashboard', 'sizing'], true) && ($page !== 'dashboard' || $mode === 'display'))
    <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm overflow-hidden">

        <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 bg-zinc-50">
            <div class="flex items-center gap-2.5">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-zinc-900">
                    <svg class="h-4 w-4 text-zinc-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </span>
                <div>
                    <h2 class="text-sm font-extrabold text-zinc-900 leading-tight">
                        {{ $page === 'dashboard' ? 'Recent Sizing Usage & Returns' : 'Sizing Bag Consumption & Returns' }}
                    </h2>
                    <p class="text-[10px] text-zinc-400 mt-0.5">Bags used in beams, returned to factory, or held with sizing persons</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($page === 'dashboard')
                    <a href="{{ route('bags.sizing-usage', ['mode' => $mode]) }}" class="text-[11px] font-bold text-zinc-500 hover:text-zinc-900 transition-colors">
                        View all &rarr;
                    </a>
                @endif
                <a href="{{ route('sizing.index', ['mode' => $mode]) }}" class="px-3 py-1.5 rounded-xl bg-zinc-900 hover:bg-zinc-700 text-zinc-50 font-bold text-[11px] transition-colors">
                    Open Sizing &rarr;
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-zinc-200 text-zinc-500 font-semibold uppercase text-[10px] tracking-wider bg-zinc-50">
                        <th class="px-4 py-3">Sizing Slip #</th>
                        <th class="px-4 py-3">Sizing Party</th>
                        <th class="px-4 py-3">Quality</th>
                        <th class="px-4 py-3 text-center">Bags Allocated</th>
                        <th class="px-4 py-3 text-center bg-zinc-900/5 text-zinc-700 border-x border-zinc-200">Used in Beams</th>
                        <th class="px-4 py-3 text-center bg-zinc-100/70 text-zinc-600 border-r border-zinc-200">Returned to Factory</th>
                        <th class="px-4 py-3 text-center bg-zinc-100/70 text-zinc-600 border-r border-zinc-200">Held With Sizing</th>
                        <th class="px-4 py-3 text-center">Beams Made</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($sizingSlips as $slip)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-4 py-3 font-mono font-bold text-zinc-900">{{ $slip->slip_no }}</td>
                            <td class="px-4 py-3 font-semibold text-zinc-800">{{ $slip->sizing_party }}</td>
                            <td class="px-4 py-3 text-zinc-600">{{ $slip->yarnQuality?->display_name ?? $slip->yarn_quality }}</td>
                            <td class="px-4 py-3 text-center font-bold text-zinc-900 font-mono">{{ number_format((float) $slip->bags_allocated, 2) }}</td>
                            <td class="px-4 py-3 text-center font-black text-zinc-900 bg-zinc-50 border-x border-zinc-200 font-mono">{{ number_format((float) $slip->bags_used, 2) }}</td>
                            <td class="px-4 py-3 text-center font-bold text-zinc-700 bg-zinc-50 border-r border-zinc-200 font-mono">{{ number_format((float) $slip->bags_returned_to_factory, 2) }}</td>
                            <td class="px-4 py-3 text-center font-bold text-zinc-700 bg-zinc-50 border-r border-zinc-200 font-mono">{{ number_format((float) $slip->bags_held_with_sizing, 2) }}</td>
                            <td class="px-4 py-3 text-center font-bold text-zinc-700">{{ $slip->total_beams }} Beams ({{ number_format($slip->total_length_meters) }}m)</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                             {{ $slip->status === 'completed'
                                                  ? 'bg-zinc-900 text-zinc-50'
                                                  : 'bg-zinc-100 text-zinc-500 border border-zinc-200' }}">
                                    {{ $slip->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="px-4 py-8 text-center text-zinc-400">No sizing slips found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($page === 'sizing')
            <div class="px-6 py-4 border-t border-zinc-100">{{ $sizingSlips->links() }}</div>
        @endif
    </div>
    @endif

    </div>
</div>
@endsection
