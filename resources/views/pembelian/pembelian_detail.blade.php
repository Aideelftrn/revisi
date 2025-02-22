@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">
    {{ $judul }}
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <tr>
        <th>ID Penyetoran</th>
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
        <td>{{ $penyetoranSampah->berat }} kg</td>
      </tr>
      <tr>
        <th>Total Harga Jual</th>
        <td>Rp. {{ number_format($penyetoranSampah->total_harga_jual, 0, ',', '.') }}</td>
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
      <tr>
        <th>Nama Pengepul</th>
        <td>{{ $pembelianSampah->pengepul->nama_pengepul }}</td>
      </tr>
      <tr>
        <th>Harga Pembelian</th>
        <td>Rp. {{ number_format($pembelianSampah->harga_pembelian, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <th>Tanggal Pembelian</th>
        <td>{{ \Carbon\Carbon::parse($pembelianSampah->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
      </tr>
    </table>
    <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali</a>
  </div>
</div>
@endsection