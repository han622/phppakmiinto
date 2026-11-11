<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LacakController extends Controller
{
    public function form()
    {
        return view('lacak.form');
    }

    public function cari(Request $request)
    {
        $data = $request->validate([
            'kode_tiket' => ['required', 'string'],
            'kode_akses' => ['required', 'string'],
        ]);

        $ticket = Ticket::where('kode_tiket', strtoupper(trim($data['kode_tiket'])))
            ->where('is_anonim', true)
            ->first();

        if (! $ticket || ! Hash::check(strtoupper(trim($data['kode_akses'])), $ticket->kode_akses)) {
            return back()
                ->withErrors(['kode_tiket' => 'Kode tiket atau kode akses salah.'])
                ->onlyInput('kode_tiket');
        }

        $ticket->load(['category', 'attachments', 'statusLogs']);

        return view('tickets.show', ['ticket' => $ticket, 'anonim' => true]);
    }
}