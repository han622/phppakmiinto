<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StaffTicketController extends Controller
{
    public function dashboard()
    {
        $counts = Ticket::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $menungguPublikasi = Ticket::where('publish_status', 'menunggu')->count();
        $terbaru = Ticket::with('category')->latest()->take(5)->get();

        return view('dashboard.staff', compact('counts', 'menungguPublikasi', 'terbaru'));
    }

    public function index(Request $request)
    {
        $query = Ticket::with(['category', 'user'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('publish_status')) {
            $query->where('publish_status', $request->publish_status);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('judul', 'like', "%{$q}%")
                  ->orWhere('kode_tiket', 'like', "%{$q}%");
            });
        }

        $tickets    = $query->paginate(10)->withQueryString();
        $categories = Category::orderBy('nama')->get();

        return view('staff.tickets.index', compact('tickets', 'categories'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['category', 'user', 'attachments', 'statusLogs']);

        return view('staff.tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'status'  => ['required', Rule::in($ticket->statusBerikutnya())],
            'catatan' => ['required_if:status,ditolak', 'nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($ticket, $data) {
            $ticket->status = $data['status'];

            if ($data['status'] === 'ditolak') {
                $ticket->alasan_penolakan = $data['catatan'];
                // Tiket ditolak tidak boleh lanjut ke publikasi
                if ($ticket->publish_status === 'menunggu') {
                    $ticket->publish_status = 'ditolak';
                }
            }
            $ticket->save();

            $ticket->statusLogs()->create([
                'status'     => $data['status'],
                'catatan'    => $data['catatan'] ?? null,
                'changed_by' => auth()->id(),
            ]);
        });

        return back()->with('sukses', 'Status tiket diperbarui.');
    }

    public function moderasi(Request $request, Ticket $ticket)
    {
        abort_unless($ticket->publish_status === 'menunggu', 422);

        $data = $request->validate([
            'keputusan' => ['required', 'in:setujui,tolak'],
        ]);

        if ($data['keputusan'] === 'setujui' && $ticket->status === 'diajukan') {
            return back()->withErrors([
                'keputusan' => 'Verifikasi tiket terlebih dahulu sebelum menyetujui publikasi.',
            ]);
        }

        $setuju = $data['keputusan'] === 'setujui';
        $ticket->update(['publish_status' => $setuju ? 'tampil' : 'ditolak']);

        $ticket->statusLogs()->create([
            'status'     => $ticket->status,
            'catatan'    => $setuju ? 'Publikasi disetujui staff.' : 'Publikasi ditolak staff.',
            'changed_by' => auth()->id(),
        ]);

        return back()->with('sukses', $setuju ? 'Tiket dipublikasikan.' : 'Permintaan publikasi ditolak.');
    }
}