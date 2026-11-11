@extends('layouts.aspirasi')
@section('title', 'Semua Tiket')
@section('content')
<h4 class="mb-3">Semua Tiket</h4>

<form method="GET" class="row g-2 mb-3">
  <div class="col-md-3">
    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari judul / kode tiket">
  </div>
  <div class="col-md-2">
    <select name="status" class="form-select">
      <option value="">Semua status</option>
      @foreach (['diajukan', 'diverifikasi', 'diproses', 'selesai', 'ditolak'] as $s)
        <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3">
    <select name="category_id" class="form-select">
      <option value="">Semua kategori</option>
      @foreach ($categories as $c)
        <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->nama }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-2">
    <select name="publish_status" class="form-select">
      <option value="">Semua publikasi</option>
      @foreach (['tidak_diajukan', 'menunggu', 'tampil', 'ditolak'] as $p)
        <option value="{{ $p }}" @selected(request('publish_status') === $p)>{{ str_replace('_', ' ', ucfirst($p)) }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-2 d-flex gap-2">
    <button class="btn btn-primary">Filter</button>
    <a href="{{ route('staff.tiket.index') }}" class="btn btn-outline-secondary">Reset</a>
  </div>
</form>

<div class="card shadow-sm"><div class="table-responsive">
  <table class="table table-hover mb-0 align-middle">
    <thead><tr><th>Kode</th><th>Judul</th><th>Pelapor</th><th>Kategori</th><th>Status</th><th>Publikasi</th><th>Dibuat</th><th></th></tr></thead>
    <tbody>
      @forelse ($tickets as $t)
        <tr>
          <td>{{ $t->kode_tiket }}</td>
          <td>{{ $t->judul }}</td>
          <td>{{ $t->is_anonim ? 'Anonim' : $t->user->username }}</td>
          <td>{{ $t->category->nama }}</td>
          <td><span class="badge text-bg-{{ $t->status_badge }}">{{ ucfirst($t->status) }}</span></td>
          <td class="small">{{ str_replace('_', ' ', $t->publish_status) }}</td>
          <td>{{ $t->created_at->format('d M Y H:i') }}</td>
          <td><a href="{{ route('staff.tiket.show', $t) }}" class="btn btn-sm btn-outline-primary">Buka</a></td>
        </tr>
      @empty
        <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada tiket yang cocok.</td></tr>
      @endforelse
    </tbody>
  </table>
</div></div>

<div class="mt-3">{{ $tickets->links() }}</div>
@endsection