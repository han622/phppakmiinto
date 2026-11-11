@extends('layouts.aspirasi')
@section('title', 'Tiket Saya')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Tiket Saya</h4>
  <a href="{{ route('tiket.create') }}" class="btn btn-primary">Buat Tiket</a>
</div>

@if (session('sukses'))
  <div class="alert alert-success">{{ session('sukses') }}</div>
@endif

<div class="card shadow-sm"><div class="table-responsive">
  <table class="table table-hover mb-0 align-middle">
    <thead><tr><th>Kode</th><th>Judul</th><th>Jenis</th><th>Kategori</th><th>Status</th><th>Dibuat</th><th></th></tr></thead>
    <tbody>
      @forelse ($tickets as $t)
        <tr>
          <td>{{ $t->kode_tiket }}</td>
          <td>{{ $t->judul }}</td>
          <td>{{ ucfirst($t->jenis) }}</td>
          <td>{{ $t->category->nama }}</td>
          <td><span class="badge text-bg-{{ $t->status_badge }}">{{ ucfirst($t->status) }}</span></td>
          <td>{{ $t->created_at->format('d M Y H:i') }}</td>
          <td><a href="{{ route('tiket.show', $t) }}" class="btn btn-sm btn-outline-primary">Buka</a></td>
        </tr>
      @empty
        <tr><td colspan="7" class="text-center text-muted py-4">Kamu belum punya tiket.</td></tr>
      @endforelse
    </tbody>
  </table>
</div></div>
@endsection