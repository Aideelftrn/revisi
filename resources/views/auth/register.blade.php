@extends('layouts.app')

@section('content')
<div class="card mx-auto" style="max-width: 600px;">
    <div class="card-header">{{ $judul }}</div>
    <div class="card-body">
        <form action="{{ route('registrasi.registerNasabahStore') }}" method="POST">
            @csrf

            <div class="form-group mt-3">
                <label for="nama_nasabah">Nama Nasabah</label>
                <input type="text" name="nama_nasabah" class="form-control" value="{{ old('nama_nasabah') }}" autofocus />
                <span class="text-danger">{{ $errors->first('nama_nasabah') }}</span>
            </div>
            <div class="form-group mt-3">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" value="{{ old('email') }}" />
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>
            <div class="form-group mt-3">
                <label for="nomor_telp">Nomor Telepon</label>
                <input name="nomor_telp" class="form-control">{{ old('nomor_telp') }}</input>
                <span class="text-danger">{{ $errors->first('nomor_telp') }}</span>
            </div>

            <div class="form-group mt-3">
                <label for="jenis_kelamin">Jenis Kelamin</label><br>
                <div class="form-check form-check-inline mt-2">
                    <input type="radio" name="jenis_kelamin" value="Laki-laki" class="form-check-input" id="lk" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }}>
                    <label class="form-check-label" for="lk">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline mt-2">
                    <input type="radio" name="jenis_kelamin" value="Perempuan" class="form-check-input" id="pr" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                    <label class="form-check-label" for="pr">Perempuan</label>
                </div>
                <span class="text-danger">{{ $errors->first('jenis_kelamin') }}</span>
            </div>

            <div class="form-group mt-3">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" rows="3" class="form-control">{{ old('alamat') }}</textarea>
                <span class="text-danger">{{ $errors->first('alamat') }}</span>
            </div>
            {{-- <div class="row mb-3 mt-3">
                <div class="col-md-6 form-group">
                    <label for="umur">Umur</label>
                    <input type="text" name="umur" class="form-control" value="{{ old('umur') }}" />
                    <span class="text-danger">{{ $errors->first('umur') }}</span>
                </div>
                <div class="col-md-6 form-group">
                    <label for="nik">NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" />
                    <span class="text-danger">{{ $errors->first('nik') }}</span>
                </div>
            </div> --}}

            <div class="form-group mt-3">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" value="{{ old('password') }}">
                <span class="text-danger">{{ $errors->first('password') }}</span>
            </div>
            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary">Daftar</button>
            </div>
        </form>
    </div>
</div>
@endsection
