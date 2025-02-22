<?php

namespace App\Http\Controllers;

use App\Models\PembelianSampah;
use App\Models\PenyetoranSampah;
use App\Models\Transaksi;
use App\Models\Pengepul;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PembelianSampahController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $penyetoranSampahs = PenyetoranSampah::with('sampah')->get();
        } else {
            $penyetoranSampahs = PenyetoranSampah::where('status', 'baru')->with('sampah')->get();
        }

        return view('pembelian.pembelian_index', compact('penyetoranSampahs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'penyetoran_sampah_id' => 'required|exists:penyetoran_sampahs,id',
        ]);

        $penyetoranSampahId = $request->input('penyetoran_sampah_id');
        $penyetoranSampah = PenyetoranSampah::find($penyetoranSampahId);

        $hargaNasabah = $penyetoranSampah->total_harga;
        $hargaJual = $penyetoranSampah->total_harga_jual;
        $selisihAdmin = $hargaJual - $hargaNasabah;

        $pengepul = Pengepul::where('user_id', Auth::id())->first();

        if (!$pengepul) {
            return redirect()->route('pembelian.index')->with('error', 'Pengepul tidak ditemukan.');
        }

        if ($pengepul->saldo < $hargaJual) {
            return redirect()->route('pembelian.index')->with('error', 'Saldo tidak mencukupi untuk melakukan pembelian.');
        }

        DB::transaction(function () use ($penyetoranSampah, $hargaNasabah, $hargaJual, $selisihAdmin, $pengepul) {
            PembelianSampah::create([
                'pengepul_id' => $pengepul->id,
                'penyetoran_sampah_id' => $penyetoranSampah->id,
                'harga_pembelian' => $hargaJual,
                'jumlah' => $penyetoranSampah->berat,
            ]);

            Transaksi::create([
                'kode_transaksi' => 'TRX-' . uniqid(),
                'nasabah_id' => $penyetoranSampah->nasabah_id,
                'pengepul_id' => $pengepul->id,
                'jumlah' => $hargaJual,
                'tanggal_transaksi' => now(),
            ]);

            $penyetoranSampah->nasabah->update([
                'saldo' => $penyetoranSampah->nasabah->saldo + $hargaNasabah,
            ]);

            $admin = User::find($penyetoranSampah->created_by);
            if ($admin) {

                $newSaldoAdmin = $admin->saldo + $selisihAdmin;
                $admin->update([
                    'saldo' => $newSaldoAdmin,
                ]);
                // flash('Berhasil update saldo admin');
            } else {
                flash('Admin tidak ditemukan');
            }

            $pengepul->update([
                'saldo' => $pengepul->saldo - $hargaJual,
            ]);

            $penyetoranSampah->update(['status' => 'terjual']);
        });

        flash('Berhasil membeli sampah');
        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dilakukan.');
    }


    public function show($id)
    {
        try {
            $penyetoranSampah = PenyetoranSampah::with(['nasabah', 'sampah'])->findOrFail($id);

            $pembelianSampah = PembelianSampah::where('penyetoran_sampah_id', $id)->with('pengepul')->first();

            if (!$pembelianSampah) {
                return redirect()->route('pembelian.index')->with('error', 'Pembelian sampah tidak ditemukan.');
            }

            $data['judul'] = 'Detail Pembelian Sampah';
            $data['penyetoranSampah'] = $penyetoranSampah;
            $data['pembelianSampah'] = $pembelianSampah;

            return view('pembelian.pembelian_detail', $data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Error pada PembelianSampahController@show: ' . $e->getMessage());
            return redirect()->route('pembelian.index')->with('error', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error pada PembelianSampahController@show: ' . $e->getMessage());
            return redirect()->route('pembelian.index')->with('error', 'Terjadi kesalahan saat mengambil data.');
        }
    }
}
