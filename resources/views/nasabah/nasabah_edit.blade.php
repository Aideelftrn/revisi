@extends('layouts.sbadmin2')

@section('content')
<div class="card">
    <div class="card-header">{{ $judul }}</div>
    <div class="card-body">
        <form action="/nasabah/{{ $nasabah->id }}" method="POST">
            @method('PUT')
            @csrf
                <div class="form-group mt-3">
                    <label for="nama_nasabah">Nama Nasabah</label>
                    <input type="text" name="nama_nasabah" class="form-control" value="{{ old('nama_nasabah') ?? $nasabah->nama_nasabah }}" autofocus />
                    <span class="text-danger">{{ $errors->first('nama_nasabah') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="email">Email / Username</label>
                    <input class="form-control" type="text" name="email" value="{{ old('email') ?? $nasabah->email }}">
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="nomor_telp">Nomor HP</label>
                    <input type="text" name="nomor_telp" class="form-control" value="{{ old('nomor_telp') ?? $nasabah->nomor_telp }}" autofocus />
                    <span class="text-danger">{{ $errors->first('nomor_telp') }}</span>
                </div>
            <div class="form-group mt-3">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" rows="3" class="form-control">{{ old('alamat') ?? $nasabah->alamat }}</textarea>
                <span class="text-danger">{{ $errors->first('alamat') }}</span>
            </div>

            <!-- <div class="row mb-3 mt-3">
                <div class="col-md-6 form-group">
                    <label for="umur">Umur</label>
                    <input type="text" name="umur" class="form-control" value="{{ old('umur') ?? $nasabah->umur }} " />
                    <span class="text-danger">{{ $errors->first('umur') }}</span>
                </div>
                <div class="col-md-6 form-group">
                    <label for="nik">NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik') ?? $nasabah->nik}}" />
                    <span class="text-danger">{{ $errors->first('nik') }}</span>
                </div>
            </div> -->


            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/nasabah" class="btn btn-dark">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection