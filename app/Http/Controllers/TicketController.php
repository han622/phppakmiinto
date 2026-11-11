<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = auth()->user()->tickets()->with('category')->latest()->get();

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama')->get();

        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis'            => ['required', 'in:pengaduan,aspirasi'],
            'category_id'      => ['required', 'exists:categories,id'],
            'judul'            => ['required', 'string', 'max:150'],
            'isi'              => ['required', 'string', 'min:20'],
            'is_anonim'        => ['nullable', 'boolean'],
            'ajukan_publikasi' => ['nullable', 'boolean'],
            'lampiran'         => ['nullable', 'array', 'max:3'],
            'lampiran.*'       => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $anonim    = $request->boolean('is_anonim');
        $kodeAkses = $anonim ? $this->buatKodeAkses() : null;

        $ticket = Ticket::create([
            'kode_tiket'     => $this->buatKodeTiket(),
            'kode_akses'     => $anonim ? Hash::make($kodeAkses) : null,
            'user_id'        => $anonim ? null : auth()->id(), // anonim: tidak ada jejak akun
            'category_id'    => $request->category_id,
            'jenis'          => $request->jenis,
            'judul'          => $request->judul,
            'isi'            => $request->isi,
            'is_anonim'      => $anonim,
            'publish_status' => $request->boolean('ajukan_publikasi') ? 'menunggu' : 'tidak_diajukan',
        ]);

        $ticket->statusLogs()->create([
            'status'     => 'diajukan',
            'catatan'    => 'Tiket dibuat.',
            'changed_by' => null,
        ]);

        foreach ($request->file('lampiran', []) as $i => $file) {
            $ticket->attachments()->create([
                'path'      => $file->store('lampiran', 'public'),
                'nama_asli' => $anonim
                    ? 'lampiran-' . ($i + 1) . '.' . $file->extension()
                    : $file->getClientOriginalName(),
            ]);
        }

        if ($anonim) {
            // Sengaja tidak redirect: kode akses tidak boleh disimpan di session
            return view('tickets.sukses-anonim', compact('ticket', 'kodeAkses'));
        }

        return redirect()->route('tiket.show', $ticket)->with('sukses', 'Tiket berhasil dikirim.');
    }

    public function show(Ticket $ticket)
    {
        // Hanya pemilik; tiket anonim (user_id kosong) otomatis tertolak di sini
        abort_unless($ticket->user_id === auth()->id(), 403);

        $ticket->load(['category', 'attachments', 'statusLogs']);

        return view('tickets.show', compact('ticket'));
    }

    private function buatKodeTiket(): string
    {
        do {
            $kode = 'TKT-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
        } while (Ticket::where('kode_tiket', $kode)->exists());

        return $kode;
    }

    private function buatKodeAkses(): string
    {
        $huruf = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // tanpa I, O, 0, 1 agar tidak membingungkan
        $kode  = '';
        for ($i = 0; $i < 8; $i++) {
            $kode .= $huruf[random_int(0, strlen($huruf) - 1)];
        }

        return $kode;
    }
}