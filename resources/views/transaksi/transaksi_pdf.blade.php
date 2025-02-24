<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: white;
            margin: 0;
            padding: 0;
        }

        .container-fluid {
            padding: 20px;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .text-center {
            text-align: center;
        }

        .my-3 {
            margin: 20px 0;
        }

        .table-responsive {
            width: 100%;
            overflow: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
            vertical-align: top;
        }

        th {
            background-color: #343a40;
            color: white;
            text-align: center;
        }

        td {
            text-align: left;
        }

        /* Proporsional untuk setiap kolom */
        th:nth-child(1),
        td:nth-child(1) {
            width: 5%;
            text-align: center;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 10%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 15%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 15%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 10%;
            text-align: right;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 10%;
            text-align: right;
        }

        th:nth-child(7),
        td:nth-child(7) {
            width: 10%;
            text-align: right;
        }

        th:nth-child(8),
        td:nth-child(8) {
            width: 10%;
            text-align: center;
        }

        .badge {
            font-size: 12px;
            color: black;
        }

        .no-data {
            color: red;
        }

        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        .signature-area {
            position: absolute;
            bottom: 20px;
            right: 20px;
            text-align: right;
        }

        .signature-line {
            height: 50px;
            border-bottom: 1px solid black;
            width: 200px;
            margin: 10px 0;
        }

        .text-kol {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .empty-cell {
            background-color: #343a40;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <h3>Laporan Transaksi Pemasukan dan Pengeluaran Keuangan Bank Sampah Suka Bestari</h3>
        <div class="text-center my-3">
            Periode Laporan:
            {{ \Carbon\Carbon::parse($tanggalAwal)->locale('id')->isoFormat('D MMMM YYYY') }}
            -
            {{ \Carbon\Carbon::parse($tanggalAkhir)->locale('id')->isoFormat('D MMMM YYYY') }}
        </div>


        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Transaksi</th>
                        <th>Nasabah</th>
                        <th>Pengepul</th>
                        <th>Pendapatan Nasabah</th>
                        <th>Laba Admin</th>
                        <th>Harga Penjualan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksiAdmin as $transaksi)
                        <tr>
                            <td>{{ $transaksi->id }}</td>
                            <td>{{ $transaksi->kode_transaksi }}</td>
                            <td>{{ $transaksi->nasabah->nama_nasabah }}</td>
                            <td>{{ $transaksi->pengepul->nama_pengepul }}</td>
                            <td>Rp {{ number_format($transaksi->penyetoranSampah->total_harga, 0, ',', '.') }}</td>
                            <td>Rp
                                {{ number_format($transaksi->penyetoranSampah->pembelian->harga_pembelian - $transaksi->penyetoranSampah->sampah->harga_jual, 0, ',', '.') }}
                            </td>
                            <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->locale('id')->isoFormat('D MMMM YYYY') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right">Total</th>

                        <!-- <td colspan="1" class="empty-cell"></td> -->
                        <td class="text-kol">
                            <strong>Rp {{ number_format($totalSelisihAdmin, 0, ',', '.') }}</strong>
                        </td>
                        <td class="text-kol">
                            <strong>Rp {{ number_format($transaksiAdmin->sum('jumlah'), 0, ',', '.') }}</strong>
                        </td>
                        <td colspan="1" class="empty-cell"></td>

                    </tr>
                </tfoot>

            </table>
        </div>

        <div class="signature-area">
            <p>Tanggal: <strong>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}</strong></p>
            <br><br><br>
            <div class="signature-line"></div>
            <p><strong>{{ auth()->user()->name }}</strong></p>
            <!-- <p><strong>Bendahara Suka Bestari</strong></p> -->
        </div>
    </div>
</body>

</html>
