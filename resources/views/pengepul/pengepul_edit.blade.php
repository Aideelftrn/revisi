@extends('layouts.sbadmin2')

@section('content')
<div class="card">
    <div class="card-header">{{ $judul }}</div>
    <div class="card-body">
        <form action="/pengepul/{{ $pengepul->id }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row mb-3">
                <div class="col-md-6 form-group ">
                    <label for="nama_pengepul">Nama Pengepul</label>
                    <input type="text" name="nama_pengepul" class="form-control" value="{{ old('nama_pengepul') ?? $pengepul->nama_pengepul }}" autofocus />
                    <span class="text-danger">{{ $errors->first('nama_pengepul') }}</span>
                </div>
                <div class="col-md-6 form-group ">
                    <label for="nomor_telp">Nomor HP</label>
                    <input type="text" name="nomor_telp" class="form-control" value="{{ old('nomor_telp') ?? $pengepul->nomor_telp }}" autofocus />
                    <span class="text-danger">{{ $errors->first('nomor_telp') }}</span>
                </div>
            </div>
         
            <div class="form-group mt-3">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" rows="3" class="form-control">{{ old('alamat') ?? $pengepul->alamat }}</textarea>
                <span class="text-danger">{{ $errors->first('alamat') }}</span>
            </div>

            <!-- <div class="row mb-3 mt-3">
                <div class="col-md-6 form-group">
                    <label for="umur">Umur</label>
                    <input type="text" name="umur" class="form-control" value="{{ old('umur') ?? $pengepul->umur }} " />
                    <span class="text-danger">{{ $errors->first('umur') }}</span>
                </div>
                <div class="col-md-6 form-group">
                    <label for="nik">NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik') ?? $pengepul->nik}}" />
                    <span class="text-danger">{{ $errors->first('nik') }}</span>
                </div>
            </div> -->


            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/pengepul" class="btn btn-dark">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection