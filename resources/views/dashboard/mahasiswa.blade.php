@extends('layouts.aspirasi')
@section('title', 'Dashboard Mahasiswa')
@section('content')
<h4>Dashboard Mahasiswa</h4>
<p>Halo, {{ auth()->user()->name }}!</p>
<a href="{{ route('tiket.create') }}" class="btn btn-primary">Buat Tiket</a>
<a href="{{ route('tiket.index') }}" class="btn btn-outline-primary">Tiket Saya</a>
@endsection