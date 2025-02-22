@extends('layouts.sbadmin2')

@section('content')

<div class="card">
  <div class="card-header">{{ __('Top Up Saldo Pengepul') }}</div>
  <div class="card-body">
    <form action="{{ route('pengepul.topup', $pengepul->id) }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label for="current_balance">Saldo Saat Ini</label>
        <input type="text" id="current_balance" class="form-control" value="{{ number_format($pengepul->saldo, 2) }}" readonly>
      </div>

      <div class="form-group">
        <label for="jumlah">Jumlah Top Up</label>
        <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah') }}" required>
        @error('jumlah')
        <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="metode">Metode Top Up</label>
        <select name="metode" id="metode" class="form-control" required>
          <option value="">Pilih Metode</option>
          <option value="bank">Bank</option>
          <option value="e-wallet">E-Wallet</option>
        </select>
        @error('metode')
        <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="bukti_pembayaran">Upload Bukti Pembayaran</label>
        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" accept="image/*" required>
        @error('bukti_pembayaran')
        <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Top Up</button>
    </form>
  </div>
</div>

@endsection