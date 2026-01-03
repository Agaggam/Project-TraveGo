<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::latest()->paginate(20);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('admin.tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_transportasi' => 'required|string|max:255',
            'jenis_transportasi' => 'required|in:pesawat,kereta,bus',
            'kode_transportasi' => 'required|string|max:50',
            'asal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'waktu_berangkat' => 'required|date',
            'waktu_tiba' => 'required|date|after:waktu_berangkat',
            'durasi_menit' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'tersedia' => 'required|integer|min:0',
            'kelas' => 'required|in:ekonomi,bisnis,eksekutif',
            'fasilitas' => 'nullable|string',
            'aktif' => 'nullable|boolean',
        ]);

        $validated['aktif'] = $request->has('aktif');

        Ticket::create($validated);

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Tiket berhasil ditambahkan');
    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('admin.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'nama_transportasi' => 'required|string|max:255',
            'jenis_transportasi' => 'required|in:pesawat,kereta,bus',
            'kode_transportasi' => 'required|string|max:50',
            'asal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'waktu_berangkat' => 'required|date',
            'waktu_tiba' => 'required|date|after:waktu_berangkat',
            'durasi_menit' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'tersedia' => 'required|integer|min:0',
            'kelas' => 'required|in:ekonomi,bisnis,eksekutif',
            'fasilitas' => 'nullable|string',
            'aktif' => 'nullable|boolean',
        ]);

        $validated['aktif'] = $request->has('aktif');

        $ticket->update($validated);

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Tiket berhasil diperbarui');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Tiket berhasil dihapus');
    }
}
