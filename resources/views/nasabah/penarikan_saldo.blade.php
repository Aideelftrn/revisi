@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">{{ $judul }}</div>
  <div class="card-body">
    <form action="{{ route('nasabah.tarikSaldo') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="jumlah">Jumlah Tarik</label>
        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required>
        @error('jumlah')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <label for="tujuan">Tujuan Tarik</label>
        <select class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" name="tujuan" required>
          <option value="bank">Bank</option>
          <option value="e-wallet">E-Wallet</option>
        </select>
        @error('tujuan')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary">Ajukan Tarik Saldo</button>
    </form>
  </div>
</div>
@endsection