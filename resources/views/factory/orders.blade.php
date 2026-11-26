@extends('layouts.app')
@section('title', 'Factory Orders & Parta')
@php
    $factoryOrdersMode = request()->query('mode') === 'display' ? 'display' : 'operator';
    $activeFactoryEntry = request()->query('entry') === 'order' ? 'order' : 'parta';
@endphp
@section('content')
<div class="max-w-7xl mx-auto pb-12 space-y-6">
    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#15803d]">WEAVING PRODUCTION</span>
            <h1 class="text-2xl sm:text-3xl font-black text-[#133e2b] tracking-tight">Factory Orders &amp; Parta</h1>
            <p class="text-xs sm:text-sm text-stone-500 mt-0.5">{{ $factoryOrdersMode === 'operator' ? 'Create fabric Parta versions and own or job-work production orders.' : 'Review saved Parta costing and production order records.' }}</p>
        </div>
    </header>

    @if($factoryOrdersMode === 'operator')
    <nav class="flex flex-wrap gap-2 rounded-2xl border border-stone-200 bg-white p-3 shadow-sm" aria-label="Factory order entry forms">
        <a href="{{ route('factory.orders', ['mode' => 'operator', 'entry' => 'parta']) }}" data-factory-order-shortcut="1" @class(['rounded-xl px-4 py-2 text-xs font-bold transition', 'bg-[#133e2b] text-white' => $activeFactoryEntry === 'parta', 'bg-stone-100 text-stone-700 hover:bg-stone-200' => $activeFactoryEntry !== 'parta']) @if($activeFactoryEntry === 'parta') aria-current="page" @endif>
            Save Quality Parta <kbd class="ml-1 text-[10px]">Ctrl+1</kbd>
        </a>
        <a href="{{ route('factory.orders', ['mode' => 'operator', 'entry' => 'order']) }}" data-factory-order-shortcut="2" @class(['rounded-xl px-4 py-2 text-xs font-bold transition', 'bg-[#133e2b] text-white' => $activeFactoryEntry === 'order', 'bg-stone-100 text-stone-700 hover:bg-stone-200' => $activeFactoryEntry !== 'order']) @if($activeFactoryEntry === 'order') aria-current="page" @endif>
            Create Production Order <kbd class="ml-1 text-[10px]">Ctrl+2</kbd>
        </a>
    </nav>
    <script>
        document.addEventListener('keydown', (event) => {
            if (!event.ctrlKey || event.shiftKey || event.altKey || event.metaKey || !['1', '2'].includes(event.key)) return;
            const tab = document.querySelector(`[data-factory-order-shortcut="${event.key}"]`);
            if (tab instanceof HTMLAnchorElement) {
                event.preventDefault();
                window.location.assign(tab.href);
            }
        });
    </script>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"><p class="font-bold">Please check these entries:</p><ul class="mt-1 list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="space-y-6" id="setup">
        
        <!-- SAVE QUALITY PARTA -->
        @if($activeFactoryEntry === 'parta')
        <section class="card p-6 space-y-4 shadow-2xs">
            <div class="pb-3 border-b border-[#e2e8e0]">
                <h2 class="font-extrabold text-base text-[#133e2b]">Save Quality Parta</h2>
                <p class="text-xs text-stone-500">Saves a new costing version. Local yarn-weight divisor = 800; old order costing is retained.</p>
            </div>
            
            <form method="POST" action="{{ route('factory.parta') }}" class="space-y-3.5" id="parta-form">
                @csrf
                <label class="block text-xs font-bold text-stone-700">
                    Quality
                    <select name="quality_mode" id="parta-quality-mode" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2.5 text-xs bg-white" required>
                        <option value="existing">Use existing quality</option>
                        <option value="new">Create a quality</option>
                    </select>
                </label>
                <label class="block text-xs font-bold text-stone-700" id="parta-existing-quality-field">
                    Fabric Quality
                    <select name="fabric_stock_id" id="parta-fabric-stock" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2.5 text-xs bg-white focus:outline-none focus:border-[#133e2b] focus:ring-1 focus:ring-[#133e2b]">
                        @foreach($fabrics as $f)
                            <option value="{{ $f->id }}">{{ $f->display_name }}</option>
                        @endforeach
                    </select>
                </label>
                <div class="hidden grid grid-cols-2 gap-3 sm:col-span-2" id="parta-new-quality-field">
                    <label class="text-xs font-bold text-stone-700">New Quality Name
                        <input name="quality_name" id="parta-quality-name" maxlength="150" placeholder="e.g. 40x40 Cotton Grey" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2.5 text-xs">
                    </label>
                    <label class="text-xs font-bold text-stone-700">Quality Code
                        <input name="quality_code" maxlength="50" placeholder="e.g. FAB-001" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2.5 text-xs">
                    </label>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    @foreach(['read'=>'Read (ends/in)', 'pick'=>'Pick (picks/in)', 'width_inches'=>'Panna/Width (in)', 'warp_count'=>'Taana Count', 'weft_count'=>'Baana Count', 'warp_rate_per_lb'=>'Taana rate (Rs/lb)', 'weft_rate_per_lb'=>'Baana rate (Rs/lb)', 'conversion_rate_per_pick'=>'Mazdoori per pick (Rs)'] as $field=>$label)
                        <label class="block text-xs font-bold text-stone-700">
                            {{ $label }}
                            <input name="{{ $field }}" type="number" step="any" min="0" required value="{{ old($field, 0) }}" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#133e2b] focus:ring-1 focus:ring-[#133e2b] parta-field">
                        </label>
                    @endforeach
                </div>

                <div class="bg-emerald-50/70 border border-emerald-200/60 rounded-xl p-3 text-xs text-[#133e2b] space-y-1 font-medium" id="parta-preview">
                    <strong>Preview:</strong> enter read, pick, counts and width to calculate weight and cost.
                </div>

                <button class="w-full rounded-xl bg-[#133e2b] hover:bg-[#1b5239] text-white font-bold p-3 text-xs shadow-2xs transition-all">
                    Save Parta Version
                </button>
            </form>
        </section>
        @endif

        <!-- CREATE PRODUCTION ORDER -->
        @if($activeFactoryEntry === 'order')
        <section class="card p-6 space-y-4 shadow-2xs">
            <div class="pb-3 border-b border-[#e2e8e0]">
                <h2 class="font-extrabold text-base text-[#133e2b]">Create Production Order</h2>
                <p class="text-xs text-stone-500">One order may run on several looms. Own-manufacturing target can be blank.</p>
            </div>

            <form method="POST" action="{{ route('factory.order.store') }}" class="space-y-3.5">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <label class="block text-xs font-bold text-stone-700">
                        Order no.
                        <input required name="order_no" value="{{ old('order_no') }}" placeholder="PO-001" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#133e2b] focus:ring-1 focus:ring-[#133e2b]">
                    </label>
                    <label class="block text-xs font-bold text-stone-700">
                        Type
                        <select name="type" id="order-type" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2.5 text-xs bg-white focus:outline-none focus:border-[#133e2b] focus:ring-1 focus:ring-[#133e2b]">
                            <option value="own">Own Manufacturing</option>
                            <option value="job">Job Work</option>
                        </select>
                    </label>
                </div>

                <label class="block text-xs font-bold text-stone-700">
                    Fabric Quality
                    <select required name="fabric_stock_id" id="order-fabric-stock" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2.5 text-xs bg-white focus:outline-none focus:border-[#133e2b] focus:ring-1 focus:ring-[#133e2b]">
                        @foreach($fabrics as $f)
                            <option value="{{ $f->id }}">{{ $f->display_name }}</option>
                        @endforeach
                    </select>
                </label>

                <div class="grid grid-cols-2 gap-3">
                    <label class="text-xs font-bold text-stone-700">
                        Target metres <span id="target-optional-note">(own: optional)</span>
                        <input name="target_meters" id="order-target-meters" type="number" step="0.01" min="0.01" class="mt-1 w-full border border-[#133e2b] rounded-xl p-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-[#133e2b]">
                    </label>
                    <label class="text-xs font-bold text-stone-700">
                        Start Date
                        <input name="start_date" type="date" required value="{{ date('Y-m-d') }}" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#133e2b] focus:ring-1 focus:ring-[#133e2b]">
                    </label>
                </div>

                <div id="job-order-fields" class="space-y-3 bg-stone-50 rounded-xl p-3.5 border border-stone-200">
                    <label class="block text-xs font-bold text-stone-700">
                        Link job-work contract
                        <select name="existing_contract_id" id="existing-contract-id" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2 text-xs bg-white">
                            <option value="">Create a new contract</option>
                            @foreach($existingContracts as $c)
                                <option value="{{ $c->id }}" data-customer-id="{{ $c->customer_id }}" data-fabric-stock-id="{{ $c->fabric_stock_id }}" data-target-meters="{{ $c->total_meters }}" data-rate-per-pick="{{ $c->conversion_rate }}">
                                    {{ $c->contract_no }} - {{ $c->customer?->name ?? $c->buyer_name }} - {{ $c->fabricStock?->display_name }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <div id="new-contract-fields" class="grid grid-cols-2 gap-3">
                        <label class="text-xs font-bold text-stone-700">
                            New Contract No.
                            <input name="contract_no" id="new-contract-no" placeholder="JC-001" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2 text-xs">
                        </label>
                        <label class="text-xs font-bold text-stone-700">
                            Customer
                            <select name="customer_id" id="order-customer-id" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2 text-xs bg-white">
                                <option value="">Choose customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}{{ $customer->phone ? ' - '.$customer->phone : '' }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <label class="block text-xs font-bold text-stone-700">
                        Weaving rate per pick (Rs.)
                        <input name="rate_per_pick" id="order-rate-per-pick" type="number" min="0" step="any" placeholder="e.g. 0.50" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2 text-xs">
                    </label>
                    <p class="text-[11px] text-stone-500">Linked bag receipts and measured kg appear on the order automatically.</p>
                </div>
                <label class="block text-xs font-bold text-stone-700">
                    Notes
                    <textarea name="notes" rows="2" class="mt-1 w-full border border-[#e2e8e0] rounded-xl p-2 text-xs focus:outline-none focus:border-[#133e2b]"></textarea>
                </label>
                
                <button class="w-full bg-[#133e2b] hover:bg-[#1b5239] text-white rounded-xl p-3 font-bold text-xs shadow-2xs transition-all">
                    Save Production Order
                </button>
            </form>
        </section>
        @endif

    </div>
    @endif

    <!-- PRODUCTION ORDERS TABLE -->
    @if($factoryOrdersMode === 'display')
    <section class="card p-6 space-y-4 shadow-2xs" id="parta-register">
        <div class="pb-3 border-b border-[#e2e8e0]"><h2 class="text-base font-extrabold text-[#133e2b]">Saved Quality Parta</h2><p class="text-xs text-stone-500">Current costing version for each fabric quality.</p></div>
        <div class="overflow-x-auto"><table class="min-w-full text-xs"><thead><tr class="text-left bg-stone-50 border-b border-stone-200 text-stone-600 font-bold uppercase text-[10px] tracking-wider"><th class="p-3">Fabric Quality</th><th class="p-3">Version</th><th class="p-3">Read / Pick</th><th class="p-3">Width</th><th class="p-3">Taana / Baana</th><th class="p-3">Rates per lb</th><th class="p-3">Mazdoori per pick</th><th class="p-3 text-right">Cost per metre</th></tr></thead><tbody class="divide-y divide-stone-100">
            @forelse($partas as $parta)
                <tr><td class="p-3 font-bold text-stone-900">{{ $parta->fabricStock?->display_name ?? '—' }}</td><td class="p-3">v{{ $parta->version }}</td><td class="p-3">{{ $parta->read }} / {{ $parta->pick }}</td><td class="p-3">{{ number_format((float) $parta->width_inches, 2) }} in</td><td class="p-3">{{ $parta->warp_count }} / {{ $parta->weft_count }}</td><td class="p-3">{{ number_format((float) $parta->warp_rate_per_lb, 2) }} / {{ number_format((float) $parta->weft_rate_per_lb, 2) }}</td><td class="p-3">Rs {{ number_format((float) $parta->conversion_rate_per_pick, 2) }}</td><td class="p-3 text-right font-bold">Rs {{ number_format((float) $parta->cost_per_meter, 2) }}</td></tr>
            @empty
                <tr><td colspan="8" class="p-6 text-center text-stone-400 italic">No Parta versions saved yet.</td></tr>
            @endforelse
        </tbody></table></div>
    </section>

    <section class="card p-6 space-y-4 shadow-2xs" id="orders">
        <div class="flex justify-between items-center pb-3 border-b border-[#e2e8e0]">
            <div>
                <h2 class="text-base font-extrabold text-[#133e2b]">Production Orders</h2>
                <p class="text-xs text-stone-500">Completed target = Pakki accepted metres for job work</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-xs">
                <thead>
                    <tr class="text-left bg-stone-50 border-b border-stone-200 text-stone-600 font-bold uppercase text-[10px] tracking-wider">
                        <th class="p-3">Order / Type</th>
                        <th class="p-3">Party</th>
                        <th class="p-3">Quality</th>
                        <th class="p-3">Target</th>
                        <th class="p-3">Accepted (job)</th>
                        <th class="p-3">Parta cost/m</th>
                        <th class="p-3">Bags received</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($orders as $o)
                        <tr class="hover:bg-stone-50/70 transition-colors">
                            <td class="p-3 font-bold text-stone-900">
                                {{ $o->order_no }}
                                <span class="block text-[10px] font-semibold text-stone-400">{{ strtoupper($o->type) }}</span>
                            </td>
                            <td class="p-3 text-stone-700">{{ $o->customer?->name ?? $o->party_name ?? 'Factory' }}</td>
                            <td class="p-3 text-stone-700">{{ $o->fabricStock?->display_name }}</td>
                            <td class="p-3 text-stone-700">{{ $o->target_meters ? number_format($o->target_meters, 0).'m' : 'Open target' }}</td>
                            <td class="p-3 font-semibold text-stone-800">{{ number_format((float) $o->accepted_meters, 2) }}m</td>
                            <td class="p-3 text-stone-700">Rs {{ number_format((float) $o->parta?->cost_per_meter, 2) }}</td>
                            <td class="p-3 text-stone-700">
                                @php($bagReceipt = $orderBagReceipts->get($o->id))
                                @if($bagReceipt)
                                    {{ number_format((float) $bagReceipt->bags_received, 2) }} bags
                                    <span class="block text-[10px] text-stone-400">{{ number_format((float) $bagReceipt->weight_received_kg, 3) }} kg</span>
                                @else
                                    <span class="text-stone-400">0 bags received</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold {{ $o->status === 'active' ? 'bg-[#e6f4ea] text-[#137333]' : 'bg-stone-100 text-stone-700' }}">
                                    {{ ucfirst($o->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-6 text-center text-stone-400 italic">No production orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    </section>
    @endif

</div>

<script>
(function () {
    const partaMode = document.getElementById('parta-quality-mode');
    if (partaMode) {
        const existingQualityField = document.getElementById('parta-existing-quality-field');
        const existingQualitySelect = document.getElementById('parta-fabric-stock');
        const newQualityField = document.getElementById('parta-new-quality-field');
        const newQualityName = document.getElementById('parta-quality-name');

        function updatePartaQualityMode() {
            const creatingQuality = partaMode.value === 'new';
            existingQualityField.classList.toggle('hidden', creatingQuality);
            existingQualitySelect.disabled = creatingQuality;
            existingQualitySelect.required = !creatingQuality;
            newQualityField.classList.toggle('hidden', !creatingQuality);
            newQualityName.required = creatingQuality;
            newQualityName.disabled = !creatingQuality;
        }

        partaMode.addEventListener('change', updatePartaQualityMode);
        updatePartaQualityMode();
    }

    const orderType = document.getElementById('order-type');
    if (orderType) {
    const jobFields = document.getElementById('job-order-fields');
    const contractSelect = document.getElementById('existing-contract-id');
    const newContractFields = document.getElementById('new-contract-fields');
    const contractNumber = document.getElementById('new-contract-no');
    const customerSelect = document.getElementById('order-customer-id');
    const fabricSelect = document.getElementById('order-fabric-stock');
    const targetMeters = document.getElementById('order-target-meters');
    const ratePerPick = document.getElementById('order-rate-per-pick');
    let manualTargetMeters = targetMeters.value;
    let manualRatePerPick = ratePerPick.value;
    let manualCustomerId = customerSelect.value;
    let hadLinkedContract = false;

    function updateOrderFields() {
        const isJobWork = orderType.value === 'job';
        const selectedContract = contractSelect.selectedOptions[0];
        const hasExistingContract = isJobWork && Boolean(contractSelect.value);

        jobFields.classList.toggle('hidden', !isJobWork);
        contractSelect.disabled = !isJobWork;
        newContractFields.classList.toggle('hidden', hasExistingContract || !isJobWork);
        contractNumber.disabled = !isJobWork || hasExistingContract;
        contractNumber.required = isJobWork && !hasExistingContract;
        customerSelect.disabled = !isJobWork || hasExistingContract;
        customerSelect.required = isJobWork && !hasExistingContract;
        targetMeters.required = isJobWork;
        targetMeters.readOnly = hasExistingContract;
        ratePerPick.readOnly = hasExistingContract;

        if (hasExistingContract) {
            if (!hadLinkedContract) {
                manualTargetMeters = targetMeters.value;
                manualRatePerPick = ratePerPick.value;
                manualCustomerId = customerSelect.value;
            }
            const contractCustomerId = selectedContract.dataset.customerId || '';
            if (contractCustomerId) {
                customerSelect.value = contractCustomerId;
            }
            fabricSelect.value = selectedContract.dataset.fabricStockId || fabricSelect.value;
            targetMeters.value = selectedContract.dataset.targetMeters || '';
            ratePerPick.value = selectedContract.dataset.ratePerPick || '';
        } else if (hadLinkedContract) {
            targetMeters.value = manualTargetMeters;
            ratePerPick.value = manualRatePerPick;
            customerSelect.value = manualCustomerId;
        }

        hadLinkedContract = hasExistingContract;
    }

    contractSelect.addEventListener('change', updateOrderFields);
    orderType.addEventListener('change', updateOrderFields);
    targetMeters.addEventListener('input', () => {
        manualTargetMeters = targetMeters.value;
    });
    ratePerPick.addEventListener('input', () => {
        manualRatePerPick = ratePerPick.value;
    });
    customerSelect.addEventListener('change', () => {
        manualCustomerId = customerSelect.value;
    });
    updateOrderFields();
    }

    const form = document.getElementById('parta-form');
    const preview = document.getElementById('parta-preview');
    if (form && preview) {

    function updatePartaPreview() {
        const value = (name) => Number(form.elements[name].value) || 0;
        const read = value('read');
        const pick = value('pick');
        const width = value('width_inches');
        const warpCount = value('warp_count');
        const weftCount = value('weft_count');

        if (!read || !pick || !width || !warpCount || !weftCount) {
            preview.textContent = 'Enter read, pick, counts and width to calculate weight and cost.';
            return;
        }

        const truncate = (amount, places) => Math.floor((amount + 0.000000001) * (10 ** places)) / (10 ** places);
        const warp = truncate(read * width / warpCount * 1.0936 / 800, 4);
        const weft = truncate(pick * width / weftCount * 1.0936 / 800, 4);
        const kilogramsPerMeter = (warp + weft) / 2.2046226218;
        const paisa = (amount) => truncate(amount, 2);
        const cost = paisa(warp * value('warp_rate_per_lb'))
            + paisa(weft * value('weft_rate_per_lb'))
            + paisa(pick * value('conversion_rate_per_pick'));
        const gsm = (read / warpCount + pick / weftCount) * 25.25;

        preview.textContent = `Taana ${warp.toFixed(4)} lb/m · Baana ${weft.toFixed(4)} lb/m · Total ${paisa(kilogramsPerMeter * 1000).toFixed(2)} grams/m · GSM ${gsm.toFixed(2)} · Cost Rs ${cost.toFixed(2)}/m`;
    }

    form.querySelectorAll('input').forEach((input) => input.addEventListener('input', updatePartaPreview));
    updatePartaPreview();
    }
})();
</script>
@endsection
