@extends('layouts.aspirasi')
@section('title', 'Detail Tiket')
@section('content')
@if (session('sukses'))
  <div class="alert alert-success">{{ session('sukses') }}</div>
@endif

<div class="card shadow-sm mb-3"><div class="card-body">
  <div class="d-flex justify-content-between">
    <div>
      <div class="text-muted small">{{ $ticket->kode_tiket }} &middot; {{ ucfirst($ticket->jenis) }} &middot; {{ $ticket->category->nama }}</div>
      <h4 class="mt-1">{{ $ticket->judul }}</h4>
    </div>
    <div class="text-end">
      <span class="badge text-bg-{{ $ticket->status_badge }}">{{ ucfirst($ticket->status) }}</span>
      @if ($ticket->is_anonim) <span class="badge text-bg-dark">Anonim</span> @endif
    </div>
  </div>
  <hr>
  <p style="white-space: pre-line">{{ $ticket->isi }}</p>

  @if ($ticket->status === 'ditolak' && $ticket->alasan_penolakan)
    <div class="alert alert-danger">Alasan penolakan: {{ $ticket->alasan_penolakan }}</div>
  @endif

  @if ($ticket->attachments->isNotEmpty())
    <h6>Lampiran</h6>
    <ul>
      @foreach ($ticket->attachments as $a)
        <li><a href="{{ asset('storage/' . $a->path) }}" target="_blank">{{ $a->nama_asli }}</a></li>
      @endforeach
    </ul>
  @endif

  <p class="small text-muted mb-0">Publikasi: {{ str_replace('_', ' ', $ticket->publish_status) }}</p>
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
@endsection