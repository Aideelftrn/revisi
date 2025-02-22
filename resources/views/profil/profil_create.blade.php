@extends('layouts.sbadmin2')

@section('content')
<div class="card">
    <div class="card-header">PROFIL SAYA - {{ strtoupper($user->name) }}</div>
    <div class="card-body">
        <form action="/profil" method="POST">
            @method('POST')
            @csrf
            <div class="form-group mt-1">
                <label for="name">Nama</label>
                <input class="form-control" type="text" name="name" value="{{ $user->name }}" autofocus>
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
            <div class="form-group mt-3">
                <label for="username">Username</label>
                <input class="form-control" type="text" name="username" value="{{ $user->email }}">
                <span class="text-danger">{{ $errors->first('username') }}</span>
            </div>

            <div class="form-group mt-3">
                <label for="nomor_telp">Nomor Telepon</label>
                <input class="form-control" type="text" name="nomor_telp" value="{{ $user->nomor_telp }}">
                <span class="text-danger">{{ $errors->first('nomor_telp') }}</span>
            </div>

            <div class="form-group mt-3">
                <label for="password">Password</label>
                <input class="form-control" type="text" name="password" value="{{ old('password') }}">
                <span class="text-danger">{{ $errors->first('password') }}</span>
            </div>


            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary">UPDATE</button>
            </div>
            <div class="form-group mt-2">
                <a href="{{ route('profil.createAkun') }}" class="btn btn-secondary">Tambah Akun Bank</a>
            </div>

            <div class="form-group mt-3">
                <h5>Akun Bank</h5>
                @if($akunBanks->isEmpty())
                <p>Belum ada akun bank yang ditambahkan.</p>
                @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis Akun</th>
                            <th>Nomor Akun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($akunBanks as $akunBank)
                        <tr>
                            <td>{{ $akunBank->jenis }}</td>
                            <td>{{ $akunBank->nomor_akun }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection