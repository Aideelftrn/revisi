@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">Tambah Akun Bank/E-Wallet</div>
  <div class="card-body">
    <form action="{{ route('profil.storeAkun') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="jenis">Jenis Akun</label>
        <select class="form-control @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
          <option value="Bank">Bank</option>
          <option value="E-Wallet">E-Wallet</option>
        </select>
        @error('jenis')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <label for="nomor_akun">Nomor Akun</label>
        <input type="text" class="form-control @error('nomor_akun') is-invalid @enderror" id="nomor_akun" name="nomor_akun" value="{{ old('nomor_akun') }}" required>
        @error('nomor_akun')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary">Tambah Akun</button>
    </form>
  </div>
</div>
@endsection