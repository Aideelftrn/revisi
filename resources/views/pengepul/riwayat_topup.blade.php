@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">
    Riwayat Penarikan Saldo untuk {{ $pengepul->nama_pengepul }}
  </div>
  <div class="card-body">
    <h3>Saldo saat ini : Rp.{{ number_format($pengepul->saldo, 0, ',', '.') }}</h3>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Jumlah</th>
          <th>Metode</th>
          <th>Status</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($topups as $topup)
        <tr>
          <td>{{ $topup->id }}</td>
          <td>Rp. {{ number_format($topup->jumlah, 0, ',', '.') }}</td>
          <td>{{ $topup->metode }}</td>
          <td>
            <span class="badge badge-pill 
                      @if($topup->status == 'approved')
                          badge-success
                      @elseif($topup->status == 'pending')
                          badge-primary
                      @else
                          badge-yellow
                      @endif" style="font-size: 100% !important;">
              {{ $topup->status }}
            </span>
          </td>
          <td>{{ \Carbon\Carbon::parse($topup->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection