@extends('layouts.aspirasi')
@section('title', 'Dashboard Staff')
@section('content')
<h4 class="mb-3">Dashboard Staff</h4>

<div class="row g-3 mb-4">
  @foreach (['diajukan' => 'secondary', 'diverifikasi' => 'info', 'diproses' => 'warning', 'selesai' => 'success', 'ditolak' => 'danger'] as $s => $warna)
    <div class="col-6 col-md-2">
      <a href="{{ route('staff.tiket.index', ['status' => $s]) }}" class="text-decoration-none">
        <div class="card text-bg-{{ $warna }} text-center shadow-sm"><div class="card-body py-3">
          <div class="fs-3 fw-bold">{{ $counts[$s] ?? 0 }}</div>
          <div class="small">{{ ucfirst($s) }}</div>
        </div></div>
      </a>
    </div>
  @endforeach
  <div class="col-6 col-md-2">
    <a href="{{ route('staff.tiket.index', ['publish_status' => 'menunggu']) }}" class="text-decoration-none">
      <div class="card text-bg-dark text-center shadow-sm"><div class="card-body py-3">
        <div class="fs-3 fw-bold">{{ $menungguPublikasi }}</div>
        <div class="small">Menunggu publikasi</div>
      </div></div>
    </a>
  </div>
</div>

<div class="card shadow-sm"><div class="card-body">
  <h6>Tiket terbaru</h6>
  <table class="table table-sm align-middle mb-0">
    <tbody>
      @forelse ($terbaru as $t)
        <tr>
          <td>{{ $t->kode_tiket }}</td>
          <td>{{ $t->judul }}</td>
          <td><span class="badge text-bg-{{ $t->status_badge }}">{{ ucfirst($t->status) }}</span></td>
          <td><a href="{{ route('staff.tiket.show', $t) }}" class="btn btn-sm btn-outline-primary">Buka</a></td>
        </tr>
      @empty
        <tr><td class="text-muted text-center">Belum ada tiket.</td></tr>
      @endforelse
    </tbody>
  </table>
</div></div>
@endsection