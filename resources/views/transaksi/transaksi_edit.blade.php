@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">{{ $judul }}</div>
  <div class="card-body">
    <form action="/transaksi/{{ $transaksi->id }}" method="POST">
      @method('PUT')
      @csrf



      <div class="form-group mt-3">
        <label for="nasabah_id">Nama Nasabah</label>
        <select name="nasabah_id" class="form-control" readonly>
          <option value="">Pilih Nasabah</option>
          @foreach($nasabah as $item)
          <option value="{{ $item->id }}" {{ $item->id == $transaksi->nasabah_id ? 'selected' : '' }}>
            {{ $item->nama_nasabah }}
          </option>
          @endforeach
        </select>
        <span class="text-danger">{{ $errors->first('nasabah_id') }}</span>
      </div>

      <div class="form-group mt-3">
        <label for="jumlah">Jumlah</label>
        <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') ?? $transaksi->jumlah }}" />
        <span class="text-danger">{{ $errors->first('jumlah') }}</span>
      </div>

      <div class="form-group mt-3">
        <label for="tanggal">Tanggal Transaksi</label>
        <input id="tanggal" class="form-control" type="date" name="tanggal" value="{{ date('Y-m-d') }}">
        <span class="text-danger">{{ $errors->first('tanggal') }}</span>
      </div>

      <div class="form-group mt-2">
        <button type="submit" class="btn btn-primary">Update Transaksi</button>
      </div>
    </form>
  </div>
</div>
@endsection