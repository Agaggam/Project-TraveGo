<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromoController extends Controller
{
    /**
     * Display a listing of promos.
     */
    public function index(Request $request)
    {
        $query = Promo::query();

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->valid();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'expired') {
                $query->where('end_date', '<', now());
            }
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('code', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('name', 'LIKE', '%' . $request->search . '%');
            });
        }

        $promos = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.promos.index', compact('promos'));
    }

    /**
     * Show the form for creating a new promo.
     */
    public function create()
    {
        return view('admin.promos.create');
    }

    /**
     * Store a newly created promo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promos,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'applicable_to' => 'nullable|array',
            'applicable_to.*' => 'in:destinasi,hotel,tiket,paket',
        ]);

        // Convert code to uppercase
        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['applicable_to'] = $request->applicable_to ?: null;

        Promo::create($validated);

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified promo.
     */
    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    /**
     * Update the specified promo.
     */
    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('promos')->ignore($promo->id)],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'min_order' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'applicable_to' => 'nullable|array',
            'applicable_to.*' => 'in:destinasi,hotel,tiket,paket',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['applicable_to'] = $request->applicable_to ?: null;

        $promo->update($validated);

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil diupdate.');
    }

    /**
     * Remove the specified promo.
     */
    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dihapus.');
    }

    /**
     * Toggle promo active status.
     */
    public function toggleStatus(Promo $promo)
    {
        $promo->update(['is_active' => !$promo->is_active]);

        $status = $promo->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Promo berhasil {$status}.");
    }
}
