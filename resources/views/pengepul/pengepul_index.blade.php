@extends('layouts.sbadmin2')

@section('content')
<div class="card">
    <div class="card-header">
        {{ $judul }}
    </div>
    <div class="card-body">
        <a href="/pengepul/create" class="btn btn-primary mb-2">Tambah Pengepul</a>

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
                @forelse ($pengepul as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->kode_pengepul }}</td>
                    <td>{{ $item->nama_pengepul }}</td>

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
                        <a href="/pengepul/{{ $item->id }}/edit" class="btn btn-primary">
                            Edit
                        </a>
                        <form action="/pengepul/{{ $item->id }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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