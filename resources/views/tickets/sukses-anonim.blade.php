@extends('layouts.aspirasi')
@section('title', 'Tiket Anonim Terkirim')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm border-warning"><div class="card-body text-center">
      <h4>Tiket anonim terkirim</h4>
      <p class="text-muted">Catat atau foto kedua kode ini sekarang.</p>
      <p class="mb-1 small text-muted">Kode tiket</p>
      <p class="fs-4 fw-bold">{{ $ticket->kode_tiket }}</p>
      <p class="mb-1 small text-muted">Kode akses</p>
      <p class="fs-3 fw-bold text-danger">{{ $kodeAkses }}</p>
      <div class="alert alert-warning small text-start">
        Kode akses <strong>tidak akan ditampilkan lagi</strong> dan tidak bisa dipulihkan.
        Jangan refresh atau kirim ulang halaman ini, nanti tiketnya terbuat dua kali.
      </div>
      <a href="{{ route('lacak') }}" class="btn btn-primary">Ke halaman lacak</a>
      <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
    </div></div>
  </div>
</div>
@endsection