@extends('layouts.aspirasi')
@section('title', 'Daftar')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm"><div class="card-body">
      <h4 class="mb-3">Daftar Mahasiswa</h4>
      <form method="POST" action="{{ route('register') }}">
        @csrf
        @foreach ([['name','Nama lengkap','text'],['username','Username','text'],['email','Email','email']] as [$f,$label,$type])
          <div class="mb-3">
            <label class="form-label">{{ $label }}</label>
            <input type="{{ $type }}" name="{{ $f }}" value="{{ old($f) }}" class="form-control @error($f) is-invalid @enderror">
            @error($f) <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        @endforeach
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Ulangi password</label>
          <input type="password" name="password_confirmation" class="form-control">
        </div>
        <button class="btn btn-primary w-100">Daftar</button>
      </form>
      <p class="mt-3 mb-0 small">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
    </div></div>
  </div>
</div>
@endsection