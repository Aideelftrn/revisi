@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">
    {{ $judul }}
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <tr>
        <th>ID</th>
        <td>{{ $penyetoranSampah->id }}</td>
      </tr>
      <tr>
        <th>Nama Nasabah</th>
        <td>{{ $penyetoranSampah->nasabah->nama_nasabah }}</td>
      </tr>
      <tr>
        <th>Nama Sampah</th>
        <td>{{ $penyetoranSampah->sampah->nama_sampah }}</td>
      </tr>
      <tr>
        <th>Berat</th>
        <td>{{ $penyetoranSampah->berat }} Kg</td>
      </tr>
      <tr>
        <th>Total Harga</th>
        <td>Rp. {{ number_format($penyetoranSampah->total_harga, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <th>Total Harga Jual</th>
        <td>Rp. {{ number_format($penyetoranSampah->total_harga_jual, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <th>Tanggal</th>
        <td>{{ \Carbon\Carbon::parse($penyetoranSampah->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
      </tr>
      <tr>
        <th>Status</th>
        <td>
          <span class="badge badge-pill 
                      @if($penyetoranSampah->status == 'baru')
                          badge-primary
                      @elseif($penyetoranSampah->status == 'terjual')
                          badge-success
                      @elseif($penyetoranSampah->status == 'pending')
                          badge-purple
                      @else
                          badge-success
                      @endif" style="font-size: 100% !important;">
            {{ $penyetoranSampah->status }}
          </span>
        </td>
      </tr>
    </table>
    <a href="{{ route('penyetoran.index') }}" class="btn btn-secondary">Kembali</a>
  </div>
</div>
@endsection