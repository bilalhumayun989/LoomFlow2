<?php

namespace App\Http\Controllers;

use App\Models\YarnQuality;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class YarnQualityController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('code')) {
            $request->merge(['code' => strtoupper(trim((string) $request->input('code')))]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:yarn_qualities,name',
            'code' => 'required|string|max:50|alpha_dash|unique:yarn_qualities,code',
        ]);

        $quality = YarnQuality::create($validated);

        return back()->with('createdYarnQuality', $quality->name)
            ->with('success', "Yarn quality {$quality->display_name} added and selected.");
    }
}
