@extends('layouts.app')
@section('title', 'Checking and Thaan Stock')
@php
    $factoryCheckingMode = request()->query('mode') === 'display' ? 'display' : 'operator';
@endphp
@section('content')
<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#15803d]">QUALITY CONTROL &amp; INVENTORY</span>
            <h1 class="text-2xl sm:text-3xl font-black text-[#133e2b] tracking-tight">Checking &amp; Thaan Register</h1>
            <p class="text-xs sm:text-sm text-stone-500 mt-0.5">{{ $factoryCheckingMode === 'operator' ? 'Record measured Thaans against the matching order, loom, and production date.' : 'Review checked fabric stock, loom assignments, and provisional production readings.' }}</p>
        </div>
    </header>

    @if($factoryCheckingMode === 'operator')
        @if(session('success'))<div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800">{{ session('error') }}</div>@endif
        @if($errors->any())<div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"><p class="font-bold">Please check these entries:</p><ul class="mt-1 list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <nav aria-label="Checking entry form" class="rounded-2xl border border-stone-200 bg-white p-3 shadow-sm">
            <button type="button" id="checking-entry-shortcut" class="rounded-xl bg-[#133e2b] px-4 py-2 text-xs font-bold text-white">Enter Checking Report <kbd class="ml-1 text-[10px]">Ctrl+1</kbd></button>
        </nav>
    @endif

    @if($factoryCheckingMode === 'operator')
    <div class="space-y-6">
        
        <!-- ENTER OFFICE CHECKING REPORT (3 Cols) -->
        <section class="card p-6 space-y-4 shadow-2xs" id="checking-entry">
            <div class="pb-3 border-b border-[#e2e8e0]">
                <h2 class="font-extrabold text-base text-[#133e2b]">Enter Office Checking Report</h2>
                <p class="text-xs text-stone-500">Choose own or job work, link the order or contract, and record each Thaan marking and measured length into that order's fabric quality stock.</p>
            </div>

            <form method="POST" action="{{ route('factory.checking.store') }}" id="checking-form" class="space-y-4">
                @csrf
                <div class="grid sm:grid-cols-2 gap-3.5">
                    <label class="text-xs font-bold text-stone-700">
                        Work Type
                        <select name="work_type" id="checking-work-type" required class="w-full mt-1 border border-[#e2e8e0] rounded-xl p-2.5 text-xs bg-white">
                            <option value="own">Own Factory Work</option>
                            <option value="job">Job Work</option>
                        </select>
                    </label>
                    <label class="text-xs font-bold text-stone-700" id="own-order-field">
                        Own Production Order
                        <select name="work_order_id" id="own-work-order" required class="w-full mt-1 border border-[#e2e8e0] rounded-xl p-2.5 text-xs bg-white">
                            <option value="">Choose own order</option>
                            @foreach($orders->where('type', 'own') as $order)
                                <option value="{{ $order->id }}" data-quality-id="{{ $order->fabric_stock_id }}">{{ $order->order_no }} · {{ $order->fabricStock?->quality_name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="hidden text-xs font-bold text-stone-700" id="job-order-field">
                        Job Contract
                        <select name="work_order_id" id="job-work-order" disabled class="w-full mt-1 border border-[#e2e8e0] rounded-xl p-2.5 text-xs bg-white">
                            <option value="">Choose job contract</option>
                            @foreach($orders->where('type', 'job')->filter(fn ($order) => $order->contract) as $order)
                                <option value="{{ $order->id }}" data-quality-id="{{ $order->fabric_stock_id }}">{{ $order->contract->contract_no }} · {{ $order->customer?->name ?? $order->contract->buyer_name }} · {{ $order->order_no }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="text-xs font-bold text-stone-700">
                        Fabric Quality
                        <select name="fabric_stock_id" id="checking-quality" required class="w-full mt-1 border border-[#e2e8e0] rounded-xl p-2.5 text-xs bg-white">
                            <option value="">Select an order first</option>
                            @foreach($fabrics as $fabric)
                                <option value="{{ $fabric->id }}">{{ $fabric->quality_name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="text-xs font-bold text-stone-700">
                        Production date
                        <input name="production_date" id="production-date" type="date" required value="{{ date('Y-m-d') }}" class="w-full mt-1 border border-[#e2e8e0] rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#133e2b] focus:ring-1 focus:ring-[#133e2b]">
                    </label>
                    <label class="text-xs font-bold text-stone-700">
                        Date checked
                        <input name="checked_on" id="checking-date" type="date" required value="{{ date('Y-m-d') }}" class="w-full mt-1 border border-[#e2e8e0] rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#133e2b] focus:ring-1 focus:ring-[#133e2b]">
                    </label>
                    <label class="text-xs font-bold text-stone-700">
                        Loom Number
                        <select name="loom_no" id="checking-loom" class="w-full mt-1 border border-[#e2e8e0] rounded-xl p-2.5 text-xs bg-white focus:outline-none focus:border-[#133e2b] focus:ring-1 focus:ring-[#133e2b]" required>
                            <option value="">Choose order and date first</option>
                        </select>
                    </label>
                </div>

                <div id="production-capacity" class="rounded-xl border border-blue-200 bg-blue-50 p-3 text-xs font-semibold text-blue-900" aria-live="polite">
                    Choose the order, production date, and loom to see how many production meters are still available to check.
                </div>

                <div class="border border-[#e2e8e0] rounded-2xl overflow-hidden">
                    <table class="w-full text-xs" id="roll-table">
                        <thead class="bg-stone-50 border-b border-stone-200 text-stone-600 text-[10px] font-bold uppercase tracking-wider">
                            <tr>
                                <th class="p-2.5 text-left">Auto Thaan Number</th>
                                <th class="p-2.5 text-left">Measured Length (m)</th>
                                <th class="p-2.5 text-center w-16">Remove</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            <tr>
                                <td class="p-2">
                                    <input name="rolls[0][roll_no]" type="text" value="{{ $nextThaanNumber }}" readonly aria-label="Automatically assigned Thaan number" class="w-full rounded-xl border border-[#e2e8e0] bg-stone-50 p-2 text-xs font-bold text-stone-700">
                                </td>
                                <td class="p-2">
                                    <input name="rolls[0][length_meters]" required type="number" min="0.01" step=".01" placeholder="0.00" class="w-full border border-[#e2e8e0] rounded-xl p-2 text-xs focus:outline-none focus:border-[#133e2b]">
                                </td>
                                <td class="text-center text-stone-300 font-bold">&mdash;</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 p-3 bg-stone-50 border border-stone-200 rounded-xl">
                    <button type="button" id="more-rolls" class="border border-stone-300 bg-white hover:bg-stone-50 text-stone-700 rounded-xl py-2 px-3.5 font-bold text-xs shadow-2xs transition-all">
                        + Add Another Thaan
                    </button>
                    <div class="text-xs font-bold text-stone-800">
                        Total: <span id="checked-total" class="text-sm font-black text-[#133e2b]">0.00</span>m &middot; <span id="checked-pieces" class="text-sm font-black text-[#133e2b]">1</span> Thaans
                    </div>
                </div>

                <input name="notes" class="w-full border border-[#e2e8e0] rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#133e2b]" placeholder="Optional checking report notes (inspector name, lot details)">

                <button id="save-checking-report" class="w-full rounded-xl bg-[#133e2b] hover:bg-[#1b5239] text-white p-3 font-bold text-xs shadow-2xs transition-all" onclick="return confirm('Confirm each Thaan number and length? These metres will enter stock as A-grade.')">
                    Save Checked Thaans
                </button>
            </form>
        </section>
    </div>
    @endif

    @if($factoryCheckingMode === 'display')
        <!-- ACTIVE LOOM QUALITY MAPPING (2 Cols) -->
        <section class="card p-6 space-y-4 shadow-2xs">
            <div class="pb-3 border-b border-[#e2e8e0]">
                <h2 class="font-extrabold text-base text-[#133e2b]">Active Loom &rarr; Quality</h2>
            <p class="text-xs text-stone-500">Each checking entry must match the order assigned to the loom on the selected date.</p>
            </div>

            <div class="max-h-96 overflow-auto border border-stone-200 rounded-xl text-xs">
                <table class="w-full">
                    <thead class="bg-stone-50 border-b border-stone-200 text-[10px] font-bold uppercase text-stone-600">
                        <tr>
                            <th class="p-2.5 text-left">Loom</th>
                            <th class="p-2.5 text-left">Order</th>
                            <th class="p-2.5 text-left">Quality</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($assignments as $a)
                            <tr class="hover:bg-stone-50/60">
                                <td class="p-2.5 font-bold text-stone-900">{{ $a->loom_no }}</td>
                                <td class="p-2.5 text-stone-700">{{ $a->order?->order_no }}</td>
                                <td class="p-2.5 text-stone-600">{{ $a->order?->fabricStock?->quality_name }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="p-4 text-center text-stone-400 italic">Allocate a loom first in Sizing &gt; Beams Tracking.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <p class="text-[11px] text-stone-400">One loom can work on only one contract per day. Switching contracts is handled in the order allocation screen.</p>
        </section>

    <!-- CHECKED THAAN STOCK HISTORY -->
    <section class="card p-6 space-y-4 shadow-2xs">
        <div class="pb-3 border-b border-[#e2e8e0] flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-base text-[#133e2b]">Checked Thaan Stock and History</h2>
                <p class="text-xs text-stone-500">Every saved Thaan with its work type, contract or order, quality, marking, length, owner, and checking notes.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-[1400px] w-full text-xs">
                <thead>
                    <tr class="bg-stone-50 border-b border-stone-200 text-[10px] font-bold uppercase tracking-wider text-stone-600">
                        <th class="text-left p-3">Checked</th>
                        <th class="text-left p-3">Production date</th>
                        <th class="text-left p-3">Thaan marking</th>
                        <th class="p-3">Work type</th>
                        <th class="text-left p-3">Contract / Order</th>
                        <th class="text-left p-3">Quality</th>
                        <th class="p-3">Loom</th>
                        <th class="text-right p-3">Measured (m)</th>
                        <th class="text-center p-3">Owner</th>
                        <th class="text-center p-3">Status</th>
                        <th class="text-left p-3">Checking notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($rolls as $r)
                        <tr class="hover:bg-stone-50/70 transition-colors">
                            <td class="p-3 text-stone-500">{{ $r->checked_on }}</td>
                            <td class="p-3 text-stone-500">{{ $r->production_date?->toDateString() ?? $r->checked_on }}</td>
                            <td class="p-3 font-bold text-stone-900">{{ $r->roll_no }}</td>
                            <td class="text-center p-3 text-stone-700">{{ $r->order?->type === 'job' ? 'Job Work' : 'Own Factory' }}</td>
                            <td class="p-3 text-stone-700">
                                @if($r->order?->type === 'job')
                                    {{ $r->order?->contract?->contract_no ?? 'Contract not linked' }}
                                    <span class="block text-[10px] text-stone-400">Order {{ $r->order?->order_no }}</span>
                                @else
                                    {{ $r->order?->order_no ?? 'Order unavailable' }}
                                @endif
                            </td>
                            <td class="p-3 text-stone-700">{{ $r->fabricStock?->quality_name ?? $r->order?->fabricStock?->quality_name }}</td>
                            <td class="p-3 text-stone-700">{{ $r->loom_no }}</td>
                            <td class="text-right p-3 font-black text-[#133e2b] tabular-nums">{{ number_format((float)$r->length_meters,2) }}m</td>
                            <td class="text-center p-3">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold {{ $r->owner_type === 'customer' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-[#133e2b]' }}">
                                    {{ $r->owner_type }}
                                </span>
                            </td>
                            <td class="text-center p-3">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold {{ $r->status === 'ready' ? 'bg-[#e6f4ea] text-[#137333]' : 'bg-stone-100 text-stone-700' }}">
                                    {{ str_replace('_',' ',$r->status) }}
                                </span>
                            </td>
                            <td class="p-3 text-stone-600">{{ $r->notes ?: '—' }}</td>
                        </tr>
                    @empty
                        <tr><td class="p-6 text-center text-stone-400 italic" colspan="11">No checked Thaans yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $rolls->links() }}
    </section>

    <!-- PROVISIONAL METER READINGS -->
    <section class="card p-6 shadow-2xs space-y-3">
        <div class="pb-3 border-b border-[#e2e8e0]">
            <h2 class="font-extrabold text-base text-[#133e2b]">Recent Provisional Loom Meter Readings</h2>
            <p class="text-xs text-stone-500">These readings track production; they do not create inventory. Compare with the checking report by loom and date.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-stone-50 border-b border-stone-200 text-[10px] font-bold uppercase tracking-wider text-stone-600">
                        <th class="text-left p-3">Date</th>
                        <th class="p-3 text-left">Loom</th>
                        <th class="p-3">Work type / order / customer</th>
                        <th class="text-left p-3">Quality</th>
                        <th class="p-3 text-right">Loom output (m)</th>
                        <th class="p-3 text-right">Already checked (m)</th>
                        <th class="p-3 text-right">Available to check (m)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($loomMeters as $m)
                        <tr class="hover:bg-stone-50/60">
                            @php
                                $batchKey = $m->work_order_id.'|'.$m->loom_no.'|'.$m->production_date->toDateString();
                                $capacity = $productionCapacity[$batchKey] ?? ['checked' => 0, 'available' => (float) $m->loom_meters];
                            @endphp
                            <td class="p-3 text-stone-600">{{ $m->production_date->toDateString() }}</td>
                            <td class="p-3 font-bold text-stone-900">{{ $m->loom_no }}</td>
                            <td class="p-3 text-stone-700">{{ $m->workOrder?->type === 'job' ? 'Job Work' : 'Own Factory' }} · {{ $m->workOrder?->order_no }}<span class="block text-[10px] text-stone-400">{{ $m->workOrder?->contract?->contract_no ?? $m->workOrder?->customer?->name ?? 'Factory order' }}</span></td>
                            <td class="p-3 text-stone-700">{{ $m->workOrder?->fabricStock?->quality_name }}</td>
                            <td class="p-3 text-right font-bold tabular-nums">{{ number_format((float) $m->loom_meters, 2) }}</td>
                            <td class="p-3 text-right tabular-nums">{{ number_format((float) $capacity['checked'], 2) }}</td>
                            <td class="p-3 text-right font-black text-[#133e2b] tabular-nums">{{ number_format((float) $capacity['available'], 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="p-4 text-center text-stone-400 italic">No loom meter readings entered yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    @endif
</div>

@if($factoryCheckingMode === 'operator')
<script>
(function(){
    document.getElementById('checking-entry-shortcut')?.addEventListener('click', () => {
        document.querySelector('#checking-form select, #checking-form input')?.focus();
    });
    document.addEventListener('keydown', (event) => {
        if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && event.key === '1') {
            event.preventDefault();
            document.querySelector('#checking-form select, #checking-form input')?.focus();
        }
    });
    let n = 1;
    const table = document.querySelector('#roll-table tbody');
    const workType = document.getElementById('checking-work-type');
    const ownOrderField = document.getElementById('own-order-field');
    const jobOrderField = document.getElementById('job-order-field');
    const ownOrder = document.getElementById('own-work-order');
    const jobOrder = document.getElementById('job-work-order');
    const quality = document.getElementById('checking-quality');
    const productionDate = document.getElementById('production-date');
    const loom = document.getElementById('checking-loom');
    const capacityMessage = document.getElementById('production-capacity');
    const saveButton = document.getElementById('save-checking-report');
    const productionCapacity = @json($productionCapacity);
    const checkingAssignments = @json($checkingAssignments);
    const allLoomNumbers = @json($looms);
    const updateLoomOptions = () => {
        const selectedOrder = workType.value === 'job' ? jobOrder : ownOrder;
        const orderId = selectedOrder.value;
        const date = productionDate.value;
        const previousLoom = loom.value;
        const assignedLoomNumbers = new Set(checkingAssignments
            .filter((assignment) => String(assignment.work_order_id) === String(orderId)
                && assignment.start_date <= date
                && (!assignment.end_date || assignment.end_date >= date))
            .map((assignment) => assignment.loom_no));
        const options = [...assignedLoomNumbers]
            .map((loomNumber) => ({
                loomNumber,
                capacity: productionCapacity[`${orderId}|${loomNumber}|${date}`],
            }))
            .filter(({ capacity }) => Boolean(capacity))
            .sort((left, right) => allLoomNumbers.indexOf(left.loomNumber) - allLoomNumbers.indexOf(right.loomNumber));

        loom.replaceChildren(new Option('Choose loom', ''));
        options.forEach(({ loomNumber, capacity }) => {
            const remaining = Math.max(0, capacity.available);
            const suffix = remaining > 0 ? ` · ${remaining.toFixed(2)} m available` : ' · fully checked';
            const option = new Option(`${loomNumber}${suffix}`, loomNumber);
            option.disabled = remaining <= 0;
            loom.add(option);
        });

        if (options.some(({ loomNumber, capacity }) => loomNumber === previousLoom && capacity.available > 0)) {
            loom.value = previousLoom;
        }
        loom.disabled = options.length === 0;
        updateProductionCapacity();
    };
    const updateProductionCapacity = () => {
        const selectedOrder = workType.value === 'job' ? jobOrder : ownOrder;
        const capacity = productionCapacity[`${selectedOrder.value}|${loom.value}|${productionDate.value}`];
        const enteredMeters = Number(document.getElementById('checked-total').textContent) || 0;
        if (!capacity) {
            capacityMessage.textContent = 'No production meter reading exists for this order, loom, and date. Record production first.';
            capacityMessage.className = 'rounded-xl border border-amber-200 bg-amber-50 p-3 text-xs font-semibold text-amber-900';
            saveButton.disabled = true;
            return;
        }
        const remaining = Math.max(0, capacity.available);
        const exceedsAvailable = enteredMeters > remaining + 0.01;
        capacityMessage.textContent = `Loom output: ${capacity.produced.toFixed(2)} m · Already checked: ${capacity.checked.toFixed(2)} m · Available to check: ${remaining.toFixed(2)} m${exceedsAvailable ? ' · Entered Thaan lengths exceed the available output.' : ''}`;
        capacityMessage.className = exceedsAvailable
            ? 'rounded-xl border border-red-200 bg-red-50 p-3 text-xs font-semibold text-red-900'
            : 'rounded-xl border border-blue-200 bg-blue-50 p-3 text-xs font-semibold text-blue-900';
        saveButton.disabled = remaining <= 0 || exceedsAvailable;
    };
    const updateWorkSelection = () => {
        const isJob = workType.value === 'job';
        ownOrderField.classList.toggle('hidden', isJob);
        jobOrderField.classList.toggle('hidden', !isJob);
        ownOrder.disabled = isJob;
        ownOrder.required = !isJob;
        jobOrder.disabled = !isJob;
        jobOrder.required = isJob;
        updateQuality();
    };
    const updateQuality = () => {
        const selectedOrder = workType.value === 'job' ? jobOrder : ownOrder;
        const qualityId = selectedOrder.selectedOptions[0]?.dataset.qualityId || '';
        Array.from(quality.options).forEach((option) => {
            option.disabled = option.value !== '' && option.value !== qualityId;
        });
        quality.value = qualityId;
        updateLoomOptions();
    };
    workType.addEventListener('change', updateWorkSelection);
    ownOrder.addEventListener('change', updateQuality);
    jobOrder.addEventListener('change', updateQuality);
    productionDate.addEventListener('change', updateLoomOptions);
    loom.addEventListener('change', updateProductionCapacity);
    updateWorkSelection();
    const recalc = () => {
        const l = [...table.querySelectorAll('input[type=number]')];
        document.getElementById('checked-total').textContent = l.reduce((t,x) => t + (Number(x.value)||0), 0).toFixed(2);
        document.getElementById('checked-pieces').textContent = table.rows.length;
        updateProductionCapacity();
    };
    document.getElementById('more-rolls').addEventListener('click', () => {
        if (n >= 200) return;
        let tr = document.createElement('tr');
        const numberBytes = crypto.getRandomValues(new Uint8Array(4));
        const thaanNumber = 'TH-' + Array.from(numberBytes, byte => byte.toString(16).padStart(2, '0')).join('').toUpperCase();
        tr.innerHTML = '<td class="p-2"><input type="text" name="rolls['+n+'][roll_no]" value="'+thaanNumber+'" readonly aria-label="Automatically assigned Thaan number" class="w-full rounded-xl border border-[#e2e8e0] bg-stone-50 p-2 text-xs font-bold text-stone-700"></td><td class="p-2"><input required type="number" name="rolls['+n+'][length_meters]" min="0.01" step=".01" placeholder="0.00" class="w-full border border-[#e2e8e0] rounded-xl p-2 text-xs focus:outline-none focus:border-[#133e2b]"></td><td class="text-center"><button type="button" class="text-rose-600 hover:text-rose-800 font-bold px-3 text-sm">&times;</button></td>';
        tr.querySelector('button').addEventListener('click', () => { tr.remove(); recalc(); });
        table.appendChild(tr);
        n++;
        recalc();
    });
    table.addEventListener('input', recalc);
    recalc();
})();
</script>
@endif
@endsection
