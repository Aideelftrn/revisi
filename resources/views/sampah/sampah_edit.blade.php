@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">{{ $judul }}</div>
  <div class="card-body">
    <form action="{{ route('sampah.update', $sampah->id) }}" method="POST">
      @method('PUT')
      @csrf

      <div class="form-group mt-3">
        <label for="jenis_sampah">Jenis Sampah</label>
        <select name="jenis_sampah" class="form-control">
          @foreach (App\Models\Sampah::jenisSampahOptions() as $value => $label)
          <option value="{{ $value }}" {{ $sampah->jenis_sampah == $value ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
        <span class="text-danger">{{ $errors->first('jenis_sampah') }}</span>
      </div>

      <div class="form-group mt-3">
        <label for="nama_sampah">Nama Sampah</label>
        <input type="text" name="nama_sampah" class="form-control" value="{{ old('nama_sampah', $sampah->nama_sampah) }}">
        <span class="text-danger">{{ $errors->first('nama_sampah') }}</span>
      </div>

      <div class="form-group mt-3">
        <label for="berat">Berat</label>
        <input type="number" name="berat" class="form-control" step="0.01" value="{{ old('berat', $sampah->berat) }}">
        <span class="text-danger">{{ $errors->first('berat') }}</span>
      </div>



      <div class="form-group mt-3">
        <label for="harga_jual">Harga Jual</label>
        <input type="number" name="harga_jual" class="form-control" step="0.01" value="{{ old('harga_jual', $sampah->harga_jual) }}">
        <span class="text-danger">{{ $errors->first('harga_jual') }}</span>
      </div>

      <div class="form-group mt-2">
        <button type="submit" class="btn btn-primary">Update Sampah</button>
      </div>
    </form>
  </div>
</div>
@endsection