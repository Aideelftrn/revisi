@extends('layouts.sbadmin2')

@section('content')
<div class="card">
    <div class="card-header">
        {{ $judul }}
    </div>
    <div class="card-body">
        <a href="/nasabah/create" class="btn btn-primary mb-2">Tambah Nasabah</a>
        <!-- <div class="row mb-2">
            <div class="col">
                <form method="GET">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Cari data nasabah" value="{{ request('q') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> -->
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nomor HP</th>
                    <th>Tanggal Buat</th>
                    <th>Saldo</th>
                    <th width="18%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($nasabah as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->kode_nasabah }}</td>
                    <td>{{ $item->nama_nasabah }}</td>

                    <td>
                        @if ($item->email)
                        {{ $item->email }}
                        @else
                        Daftar Offline
                        @endif
                    </td>
                    <td>{{ $item->nomor_telp }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('D MMMM YYYY, HH:mm:ss') }}</td>
                    <td>Rp. {{ number_format($item->saldo , 0, ',', '.') }}</td>
                    <td>
                        <a href="/nasabah/{{ $item->id }}/edit" class="btn btn-primary">
                            Edit
                        </a>
                        <form action="/nasabah/{{ $item->id }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Data tidak ada</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
