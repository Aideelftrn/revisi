<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\Nasabah;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{

    public function index()
    {
        $cari = request('q');
        $user = auth()->user();

        if ($user->role == 'admin') {
            if ($cari) {
                $data['transaksi'] = Transaksi::with('nasabah', 'pengepul')
                    ->where('kode_transaksi', 'like', '%' . $cari . '%')
                    ->orWhereHas('nasabah', function ($query) use ($cari) {
                        $query->where('nama_nasabah', 'like', '%' . $cari . '%');
                    })
                    ->paginate(10);
            } else {
                $data['transaksi'] = Transaksi::with('nasabah', 'pengepul')
                    ->latest()
                    ->paginate(10);
            }

            $userId = $user->id;
            $transaksiAdmin = Transaksi::whereHas('penyetoranSampah', function ($query) use ($userId) {
                $query->where('created_by', $userId);
            })->get();

            $totalSelisihAdmin = 0;
            $totalTransaksi = 0;
            foreach ($transaksiAdmin as $transaksi) {
                $penyetoranSampah = $transaksi->penyetoranSampah;
                $selisihAdmin = $penyetoranSampah->total_harga_jual - $penyetoranSampah->total_harga;
                $totalSelisihAdmin += $selisihAdmin;
                $totalTransaksi += $transaksi->jumlah;
            }

            $data['transaksiAdmin'] = $transaksiAdmin;
            $data['totalSelisihAdmin'] = $totalSelisihAdmin;
            $data['totalTransaksi'] = $totalTransaksi;
        } else {
            if ($cari) {
                $data['transaksi'] = Transaksi::with('nasabah', 'pengepul')
                    ->where(function ($query) use ($user, $cari) {
                        $query->whereHas('nasabah', function ($query) use ($user, $cari) {
                            $query->where('nama_nasabah', 'like', '%' . $cari . '%');
                        })->orWhereHas('pengepul', function ($query) use ($user, $cari) {
                            $query->where('nama_pengepul', 'like', '%' . $cari . '%');
                        });
                    })
                    ->paginate(10);
            } else {
                $data['transaksi'] = Transaksi::with('nasabah', 'pengepul')
                    ->where(function ($query) use ($user) {
                        $query->whereHas('nasabah', function ($query) use ($user) {
                            $query->where('user_id', $user->id);
                        })->orWhereHas('pengepul', function ($query) use ($user) {
                            $query->where('user_id', $user->id);
                        });
                    })
                    ->latest()
                    ->paginate(10);
            }
        }

        $data['judul'] = 'Data Transaksi';
        return view('transaksi.transaksi_index', $data);
    }




    public function store(Request $request)
    {
        $validasiData = $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $kodeQuery = Transaksi::orderBy('id', 'desc')->first();
            $kode = 'KT0001';
            if ($kodeQuery) {
                $kode = 'KT' . sprintf('%04d', $kodeQuery->id + 1);
            }

            $transaksi = new Transaksi();
            $transaksi->kode_transaksi = $kode;
            $transaksi->nasabah_id = $request->nasabah_id;
            $transaksi->jumlah = $request->jumlah;
            $transaksi->tanggal_transaksi = $request->tanggal;
            $transaksi->save();

            DB::commit();
            flash('Transaksi Berhasil Ditambahkan')->success();
            return redirect('transaksi');
        } catch (\Throwable $e) {
            DB::rollback();
            flash('Ops... Terjadi kesalahan, ' . $e->getMessage())->error();
            return back();
        }
    }



    public function edit($id)
    {
        $data['transaksi'] = Transaksi::findOrFail($id);
        $data['judul'] = 'Edit Data Transaksi';
        $data['nasabah'] = Nasabah::all();
        return view('transaksi.transaksi_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validasiData = $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->kode_transaksi = $request->kode_transaksi;
            $transaksi->nasabah_id = $request->nasabah_id;
            $transaksi->jumlah = $request->jumlah;
            $transaksi->tanggal_transaksi = $request->tanggal;
            $transaksi->save();

            DB::commit();
            flash('Transaksi Berhasil Diupdate')->success();
            return redirect('transaksi');
        } catch (\Throwable $e) {
            DB::rollback();
            flash('Ops... Terjadi kesalahan, ' . $e->getMessage())->error();
            return back();
        }
    }


    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        flash('Transaksi Berhasil Dihapus')->success();
        return back();
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('nasabah', 'pengepul')->findOrFail($id);

        $data['transaksi'] = $transaksi;
        $data['judul'] = 'Detail Transaksi';

        return view('transaksi.transaksi_show', $data);
    }


    public function laporanIndex()
    {
        $transaksiAdmin = Transaksi::whereHas('penyetoranSampah')->get();

        return view('transaksi.laporan_index', [
            'transaksiAdmin' => $transaksiAdmin,
        ]);
    }

    public function generatePdf(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        $transaksiAdmin = Transaksi::whereHas('penyetoranSampah', function ($query) use ($tanggalAwal, $tanggalAkhir) {
            $query->whereBetween('tanggal_transaksi', [$tanggalAwal, $tanggalAkhir]);
        })->get();

        $totalSelisihAdmin = 0;
        foreach ($transaksiAdmin as $transaksi) {
            $penyetoranSampah = $transaksi->penyetoranSampah;
            $selisihAdmin = $penyetoranSampah->total_harga_jual - $penyetoranSampah->total_harga;
            $totalSelisihAdmin += $selisihAdmin;
        }

        $pdf = Pdf::loadView('transaksi.transaksi_pdf', [
            'transaksiAdmin' => $transaksiAdmin,
            'totalSelisihAdmin' => $totalSelisihAdmin,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
        ]);

        return $pdf->download('daftar_uang_masuk.pdf');
    }
}
