@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">
    Daftar Penjualan Sampah
  </div>
  <div class="card-body">
    @if(session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
    @endif
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th>
          <!-- <th>Nama Nasabah</th> -->
          <th>Nama Sampah</th>
          <th>Berat</th>
          <th>Harga Jual</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($penyetoranSampahs as $penyetoran)
        <tr>
          <td>{{ $penyetoran->id }}</td>
          <!-- <td>{{ $penyetoran->nasabah->nama_nasabah }}</td> -->
          <td>{{ $penyetoran->sampah->nama_sampah }}</td>
          <td>{{ $penyetoran->berat }} kg</td>
          <td>Rp. {{ number_format($penyetoran->total_harga_jual , 0, ',', '.') }}</td>

          <td>
            <span class="badge badge-pill 
                      @if($penyetoran->status == 'baru')
                          badge-primary
                      @elseif($penyetoran->status == 'terjual')
                          badge-success
                      @elseif($penyetoran->status == 'pending')
                          badge-purple
                      @else
                          badge-success
                      @endif" style="font-size: 100% !important;">
              {{ $penyetoran->status }}
            </span>
          </td>
          <td>
            <form action="{{ route('pembelian.store') }}" method="POST">
              @csrf
              <input type="hidden" name="penyetoran_sampah_id" value="{{ $penyetoran->id }}">

              @if (auth()->user()->role != 'admin')
              <button type="submit" class="btn btn-primary">Beli</button>
              @elseif($penyetoran->status == 'terjual')
              <a href="{{ route('pembelian.show', $penyetoran->id) }}" class="btn btn-primary">Detail</a>
              @endif

            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection