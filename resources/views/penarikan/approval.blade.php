@extends('layouts.sbadmin2')
@section('content')
<div class="card">
  <div class="card-header">
    Daftar Penarikan Saldo
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
          <th>Nasabah ID</th>
          <th>Jumlah</th>
          <th>Tujuan</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($penarikans as $penarikan)
        <tr>
          <td>{{ $penarikan->id }}</td>
          <td>{{ $penarikan->nasabah_id }}</td>
          <td>Rp. {{ number_format($penarikan->jumlah, 0, ',', '.') }}</td>
          <td>{{ $penarikan->tujuan }}</td>
          <td>
            <span class="badge badge-pill 
                      @if($penarikan->status == 'approved')
                          badge-success
                      @elseif($penarikan->status == 'pending')
                          badge-primary
                      @else
                          badge-yellow
                      @endif" style="font-size: 100% !important;">
              {{ $penarikan->status }}
            </span>
          </td>
          <td>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#approveModal{{ $penarikan->id }}">
                Approve
              </button>
              <form action="{{ route('penarikan.reject', $penarikan->id) }}" method="POST" style="margin-left: 5px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Reject</button>
              </form>
            </div>
          </td>
        </tr>

        <div id="approveModal{{ $penarikan->id }}" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Approve Penarikan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form action="{{ route('penarikan.approve', $penarikan->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="bukti_pembayaran">Upload Gambar</label>
                    <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" required>
                  </div>
                  <button type="submit" class="btn btn-success mt-2">Approve</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection