@if((request()->routeIs('bags.*') && ($mode ?? null) === 'operator') || (request()->routeIs('sizing.*') && ($sizingMode ?? null) === 'operator'))
<section id="yarn-quality-entry" data-bag-form-panel="quality" @if(request()->routeIs('sizing.*')) data-sizing-form-panel="quality" @if(($sizingMode ?? null) === 'operator' && ($activeSizingForm ?? 'slip') !== 'quality' && !($errors->has('name') || $errors->has('code'))) hidden @endif @endif @if(($page ?? null) === 'dashboard' && ($mode ?? null) === 'operator' && !($errors->has('name') || $errors->has('code'))) hidden @endif class="scroll-mt-28 rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm sm:p-6">
    <div class="mx-auto max-w-5xl">
        <div class="flex items-start justify-between border-b border-zinc-100 pb-4">
            <div>
                <h2 class="text-lg font-extrabold text-zinc-900">Yarn Quality List</h2>
                <p class="mt-1 text-xs text-zinc-500">Add a unique code and yarn quality name for bag purchases and sizing records.</p>
            </div>
        </div>

        <div class="mt-4 max-h-40 overflow-y-auto rounded-xl border border-zinc-100 bg-zinc-50 p-3">
            @forelse($yarnQualities as $yarnQuality)
                <span class="mb-1 mr-1 inline-flex rounded-lg border border-zinc-200 bg-white px-2.5 py-1 text-xs font-semibold text-zinc-700">{{ $yarnQuality->display_name }}</span>
            @empty
                <span class="text-xs text-zinc-400">No yarn qualities yet.</span>
            @endforelse
        </div>

        <form id="yarn-quality-form" action="{{ route('yarn-qualities.store') }}" method="POST" class="mt-4 space-y-3">
            @csrf
            <div>
                <label for="newYarnQualityName" class="mb-1 block text-xs font-semibold text-zinc-600">New Yarn Quality Name *</label>
                <input id="newYarnQualityName" type="text" name="name" required maxlength="100" value="{{ old('name') }}" placeholder="e.g. 30/1 PC Combed" class="w-full rounded-xl border border-zinc-300 bg-zinc-50 px-3 py-2.5 text-sm text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                @error('name')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="newYarnQualityCode" class="mb-1 block text-xs font-semibold text-zinc-600">Yarn Quality Code *</label>
                <input id="newYarnQualityCode" type="text" name="code" required maxlength="50" value="{{ old('code') }}" placeholder="e.g. YRN-001" class="w-full rounded-xl border border-zinc-300 bg-zinc-50 px-3 py-2.5 text-sm uppercase text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500">
                @error('code')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </div>
            <div class="flex justify-end gap-2 border-t border-zinc-100 pt-3">
                <button type="submit" class="rounded-xl bg-zinc-900 px-5 py-2 text-xs font-bold text-white hover:bg-zinc-700">Add Yarn Quality</button>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
    const createdYarnQuality = @js(session('createdYarnQuality'));
    if (createdYarnQuality) {
        document.querySelectorAll('[data-yarn-quality-select]').forEach((select) => {
            select.value = createdYarnQuality;
        });
        setTimeout(() => {
            document.getElementById('inpYarnQuality')?.dispatchEvent(new Event('change'));
        }, 0);
    }
    @if($errors->has('name') || $errors->has('code'))
        document.getElementById('yarn-quality-entry')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    @endif
</script>
@endpush
@endif
