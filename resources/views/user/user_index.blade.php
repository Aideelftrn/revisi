@extends('layouts.sbadmin2')

@section('content')
<div class="card">
    <div class="card-header">{{ $judul }}</div>
    <div class="card-body">

        <div class="d-flex mb-2">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Pilih Tabel
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" onclick="showTable('semua')">Semua User</a>
                    <a class="dropdown-item" href="#" onclick="showTable('admin')">Admin</a>
                    <a class="dropdown-item" href="#" onclick="showTable('nasabah')">Nasabah</a>
                    <a class="dropdown-item" href="#" onclick="showTable('pengepul')">Pengepul</a>
                </div>
            </div>
            <a href="/user/create" class="btn btn-primary ml-3">Tambah Data</a>
        </div>

        <div id="tabelSemua" class="table-responsive">
            <h5>Semua User</h5>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Role</th>
                        <th>Nama</th>
                        <th>Username / Email</th>
                        <th>Tanggal Buat</th>
                        <th width="16%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->role }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('D MMMM YYYY, HH:mm:ss') }}</td>
                        <td>
                            <a href="/user/{{ $item->id }}/edit" class="btn btn-primary ">
                                Edit
                            </a>
                            <form action="/user/{{ $item->id }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger ">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="tabelAdmin" class="table-responsive" style="display: none;">
            <h5>User Admin</h5>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Buat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $item)
                    @if ($item->role == 'admin')
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('D MMMM YYYY, HH:mm:ss') }}</td>
                        <td>
                            <a href="/user/{{ $item->id }}/edit" class="btn btn-primary ">
                                Edit
                            </a>
                            <form action="/user/{{ $item->id }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger ">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="tabelNasabah" class="table-responsive" style="display: none;">
            <h5>User Nasabah</h5>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Buat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $item)
                    @if ($item->role == 'nasabah')
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('D MMMM YYYY, HH:mm:ss') }}</td>
                        <td>
                            <a href="/user/{{ $item->id }}/edit" class="btn btn-primary ">
                                Edit
                            </a>
                            <form action="/user/{{ $item->id }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger ">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="tabelPengepul" class="table-responsive" style="display: none;">
            <h5>User Pengepul</h5>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Buat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $item)
                    @if ($item->role == 'pengepul')
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('D MMMM YYYY, HH:mm:ss') }}</td>
                        <td>
                            <a href="/user/{{ $item->id }}/edit" class="btn btn-primary ">
                                Edit
                            </a>
                            <form action="/user/{{ $item->id }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger ">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    function showTable(tableId) {
        document.querySelectorAll('.table-responsive').forEach(function(el) {
            el.style.display = 'none';
        });
        document.getElementById('tabel' + tableId.charAt(0).toUpperCase() + tableId.slice(1)).style.display = 'block';
    }
</script>
@endsection