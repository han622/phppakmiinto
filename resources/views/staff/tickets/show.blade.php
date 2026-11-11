@extends('layouts.aspirasi')
@section('title', 'Detail Tiket (Staff)')
@section('content')
<a href="{{ route('staff.tiket.index') }}" class="small">&larr; Kembali ke daftar</a>

@if (session('sukses'))
  <div class="alert alert-success mt-2">{{ session('sukses') }}</div>
@endif
@if ($errors->any())
  <div class="alert alert-danger mt-2">{{ $errors->first() }}</div>
@endif

<div class="row mt-2">
  <div class="col-lg-8">
    <div class="card shadow-sm mb-3"><div class="card-body">
      <div class="d-flex justify-content-between">
        <div>
          <div class="text-muted small">{{ $ticket->kode_tiket }} &middot; {{ ucfirst($ticket->jenis) }} &middot; {{ $ticket->category->nama }}</div>
          <h4 class="mt-1">{{ $ticket->judul }}</h4>
        </div>
        <span class="badge text-bg-{{ $ticket->status_badge }} align-self-start">{{ ucfirst($ticket->status) }}</span>
      </div>
      <p class="small text-muted mb-2">
        Pelapor:
        @if ($ticket->is_anonim)
          <strong>Anonim</strong> (identitas tidak tersimpan)
        @else
          <strong>{{ $ticket->user->name }}</strong> ({{ $ticket->user->username }}, {{ $ticket->user->email }})
        @endif
      </p>
      <hr>
      <p style="white-space: pre-line">{{ $ticket->isi }}</p>

      @if ($ticket->attachments->isNotEmpty())
        <h6>Lampiran</h6>
        <ul>
          @foreach ($ticket->attachments as $a)
            <li><a href="{{ asset('storage/' . $a->path) }}" target="_blank">{{ $a->nama_asli }}</a></li>
          @endforeach
        </ul>
      @endif
    </div></div>

    <div class="card shadow-sm"><div class="card-body">
      <h6>Riwayat Status</h6>
      <ul class="list-group list-group-flush">
        @foreach ($ticket->statusLogs as $log)
          <li class="list-group-item px-0">
            <strong>{{ ucfirst($log->status) }}</strong>
            <span class="text-muted small">&middot; {{ $log->created_at->format('d M Y H:i') }}</span>
            @if ($log->catatan) <div class="small">{{ $log->catatan }}</div> @endif
          </li>
        @endforeach
      </ul>
    </div></div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-sm mb-3"><div class="card-body">
      <h6>Ubah status</h6>
      @if (count($ticket->statusBerikutnya()))
        <form method="POST" action="{{ route('staff.tiket.status', $ticket) }}">
          @csrf @method('PATCH')
          <select name="status" class="form-select mb-2">
            @foreach ($ticket->statusBerikutnya() as $s)
              <option value="{{ $s }}">{{ ucfirst($s) }}</option>
            @endforeach
          </select>
          <textarea name="catatan" rows="3" class="form-control mb-2" placeholder="Catatan (wajib diisi jika menolak)">{{ old('catatan') }}</textarea>
          <button class="btn btn-primary w-100">Simpan</button>
        </form>
      @else
        <p class="text-muted small mb-0">Status sudah final, tidak bisa diubah lagi.</p>
      @endif
    </div></div>

    <div class="card shadow-sm"><div class="card-body">
      <h6>Publikasi</h6>
      <p class="small mb-2">Status: <strong>{{ str_replace('_', ' ', $ticket->publish_status) }}</strong></p>
      @if ($ticket->publish_status === 'menunggu')
        <form method="POST" action="{{ route('staff.tiket.publikasi', $ticket) }}" class="d-flex gap-2">
          @csrf @method('PATCH')
          <button name="keputusan" value="setujui" class="btn btn-success flex-fill">Setujui</button>
          <button name="keputusan" value="tolak" class="btn btn-outline-danger flex-fill">Tolak</button>
        </form>
      @else
        <p class="text-muted small mb-0">Tidak ada permintaan publikasi yang menunggu.</p>
      @endif
    </div></div>
  </div>
</div>
@endsection