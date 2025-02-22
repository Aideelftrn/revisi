@extends('layouts.sbadmin2')

@section('content')
<div class="card">
    <div class="card-header">{{ $judul }}</div>
    <div class="card-body">
        <form action="{{ route('penyetoran.store') }}" method="POST">
            @csrf

            <div class="form-group mt-3">
                <label for="nasabah_id">Nama Nasabah</label>
                <select name="nasabah_id" class="form-control" {{ auth()->user()->role != 'admin' ? 'disabled' : '' }}>
                    @if(auth()->user()->role != 'admin')
                    <option value="{{ auth()->user()->nasabah->id }}">{{ auth()->user()->nasabah->nama_nasabah }}</option>
                    @else
                    <option value="">Pilih Nasabah</option>
                    @foreach($nasabahs as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_nasabah }}</option>
                    @endforeach
                    @endif
                </select>
                <span class="text-danger">{{ $errors->first('nasabah_id') }}</span>
            </div>



            <div class="form-group mt-3">
                <label for="sampah_id">Nama Sampah</label>
                <select name="sampah_id" class="form-control">
                    <option value="">Pilih Sampah</option>
                    @foreach($sampahs as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_sampah }}</option>
                    @endforeach
                </select>
                <span class="text-danger">{{ $errors->first('sampah_id') }}</span>
            </div>

            <div class="form-group mt-3">
                <label for="berat">Berat</label>
                <input type="number" name="berat" class="form-control" step="0.01" value="{{ old('berat') }}">
                <span class="text-danger">{{ $errors->first('berat') }}</span>
            </div>

            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary">Simpan Penyetoran</button>
            </div>
        </form>
    </div>
</div>
@endsection