@extends('layouts.aspirasi')
@section('title', 'Lacak Tiket Anonim')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm"><div class="card-body">
      <h4 class="mb-3">Lacak Tiket Anonim</h4>
      <form method="POST" action="{{ route('lacak.cari') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Kode tiket</label>
          <input type="text" name="kode_tiket" value="{{ old('kode_tiket') }}" class="form-control @error('kode_tiket') is-invalid @enderror" placeholder="TKT-20261109-XXXXX">
          @error('kode_tiket') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Kode akses</label>
          <input type="text" name="kode_akses" class="form-control" autocomplete="off">
        </div>
        <button class="btn btn-primary w-100">Cari</button>
      </form>
    </div></div>
  </div>
</div>
@endsection