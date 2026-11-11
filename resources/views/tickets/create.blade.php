@extends('layouts.aspirasi')
@section('title', 'Buat Tiket')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card shadow-sm"><div class="card-body">
      <h4 class="mb-3">Buat Pengaduan / Aspirasi</h4>
      <form method="POST" action="{{ route('tiket.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Jenis</label>
            <select name="jenis" class="form-select @error('jenis') is-invalid @enderror">
              <option value="pengaduan" @selected(old('jenis') === 'pengaduan')>Pengaduan (keluhan)</option>
              <option value="aspirasi" @selected(old('jenis') === 'aspirasi')>Aspirasi (usulan)</option>
            </select>
            @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
              <option value="">-- pilih kategori --</option>
              @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id') == $c->id)>{{ $c->nama }}</option>
              @endforeach
            </select>
            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Judul</label>
          <input type="text" name="judul" value="{{ old('judul') }}" class="form-control @error('judul') is-invalid @enderror">
          @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Isi (minimal 20 karakter)</label>
          <textarea name="isi" rows="5" class="form-control @error('isi') is-invalid @enderror">{{ old('isi') }}</textarea>
          @error('isi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Lampiran (opsional, maks. 3 file JPG/PNG/PDF, 2 MB per file)</label>
          <input type="file" name="lampiran[]" multiple class="form-control @error('lampiran.*') is-invalid @enderror">
          @error('lampiran.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-check mb-2">
          <input type="checkbox" name="is_anonim" value="1" id="is_anonim" class="form-check-input" @checked(old('is_anonim'))>
          <label class="form-check-label" for="is_anonim">
            <strong>Kirim sebagai anonim.</strong>
            Identitasmu tidak disimpan sama sekali, bahkan staff tidak tahu. Kamu akan menerima
            <em>kode tiket</em> dan <em>kode akses</em> yang hanya tampil sekali. Kalau hilang, tiket tidak bisa dibuka lagi.
          </label>
        </div>

        <div class="form-check mb-3">
          <input type="checkbox" name="ajukan_publikasi" value="1" id="ajukan_publikasi" class="form-check-input" @checked(old('ajukan_publikasi'))>
          <label class="form-check-label" for="ajukan_publikasi">
            Ajukan untuk dipublikasikan (tampil di halaman publik setelah disetujui staff)
          </label>
        </div>

        <button class="btn btn-primary">Kirim</button>
        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-secondary">Batal</a>
      </form>
    </div></div>
  </div>
</div>
@endsection