@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">{{ $judul }}</div>
        <div class="card-body">
            <form action="{{ route('penyetoran.update', $penyetoranSampah->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mt-3">
                    <label>Nama Nasabah</label>
                    <input type="text" class="form-control" value="{{ $penyetoranSampah->nasabah->nama_nasabah }}" disabled>
                </div>

                <div class="form-group mt-3">
                    <label>Nama Sampah</label>
                    <input type="text" class="form-control" value="{{ $penyetoranSampah->sampah->nama_sampah }}"
                        disabled>
                </div>

                <div class="form-group mt-3">
                    <label>Berat</label>
                    <div class="input-group">
                        <input type="text" name="berat" class="form-control" value="{{ $penyetoranSampah->berat }}">
                        <div class="input-group-append">
                            <span class="input-group-text">Kg</span>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>Total Harga</label>
                    <input type="text" class="form-control"
                        value="Rp. {{ number_format($penyetoranSampah->total_harga, 0, ',', '.') }}" disabled>
                </div>

                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
