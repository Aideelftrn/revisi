@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">{{ $judul }}</div>
  <div class="card-body">
    <form action="/penyetoran/{{ $penyetoranSampah->id }}" method="POST">
      @method('PUT')
      @csrf

      <div class="form-group mt-3">
        <label for="nasabah_id">Nama Nasabah</label>
        <input type="text" class="form-control" value="{{ $penyetoranSampah->nasabah->nama_nasabah }}" disabled>
      </div>

      <div class="form-group mt-3">
        <label for="sampah_id">Nama Sampah</label>
        <input type="text" class="form-control" value="{{ $penyetoranSampah->sampah->nama_sampah }}" disabled>
      </div>

      <div class="form-group mt-3">
        <label for="berat">Berat</label>
        <input type="text" class="form-control" value="{{ $penyetoranSampah->berat }} Kg" disabled>
      </div>

      <div class="form-group mt-3">
        <label for="total_harga">Total Harga</label>
        <input type="text" class="form-control" value="Rp. {{ number_format($penyetoranSampah->total_harga, 0, ',', '.') }}" disabled>
      </div>

      <div class="form-group mt-3">
        <label for="total_harga_jual">Total Harga Jual</label>
        <input type="number" name="total_harga_jual" class="form-control" value="{{ old('total_harga_jual', $penyetoranSampah->total_harga_jual) }}" step="0.01">
        <span class="text-danger">{{ $errors->first('total_harga_jual') }}</span>
      </div>


      <div class="form-group mt-2">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection