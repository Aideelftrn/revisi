@extends('layouts.sbadmin2')

@section('content')
<div class="card">
    <div class="card-header">Buat User</div>
    <div class="card-body">
        <form action="/user/{{ $user->id }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="name">Nama</label>
                    <input class="form-control" type="text" name="name" value="{{ old('name') ?? $user->name }}" autofocus>
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                <div class="col-md-6 form-group">
                    <label for="email">Email / email</label>
                    <input class="form-control" type="text" name="email" value="{{ old('email') ?? $user->email }}">
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
            </div>
            <div class="form-group mt-1">
                <label for="nomor_telp">Nomor Telepon</label>
                <input class="form-control" type="text" name="nomor_telp" value="{{ old('nomor_telp') ?? $user->nomor_telp }}">
                <span class="text-danger">{{ $errors->first('nomor_telp') }}</span>
            </div>
            <div class="form-group mt-1">
                <label for="role">Role</label>
                <select name="role" class="form-control">
                    <option value="operator" @selected($user->role == 'apoteker')> Operator</option>
                    <option value="admin" @selected($user->role == 'admin')> Admin </option>
                </select>
                <span class="text-danger">{{ $errors->first('role') }}</span>
            </div>
            <div class="form-group mt-3">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" value="{{ old('password') }}">
                <span class="text-danger">{{ $errors->first('password') }}</span>
            </div>

            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </div>
        </form>
    </div>
</div>
@endsection