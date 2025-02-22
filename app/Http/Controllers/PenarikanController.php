<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\Nasabah;
use App\Models\Penarikan;
use App\Models\User;

class PenarikanController extends Controller
{
  public function approval()
  {
    $penarikans = Penarikan::where('status', 'pending')->get();
    return view('penarikan.approval', compact('penarikans'));
  }


  public function approve(Request $request, $id)
  {
    $request->validate([
      'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    DB::beginTransaction();
    try {
      $penarikan = Penarikan::findOrFail($id);
      $nasabah = Nasabah::findOrFail($penarikan->nasabah_id);

      if ($request->hasFile('bukti_pembayaran')) {
        $file = $request->file('bukti_pembayaran');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/penarikan_images', $filename);
        $penarikan->bukti_pembayaran = $filename;
      }

      $penarikan->status = 'approved';
      $penarikan->save();

      $nasabah->saldo -= $penarikan->jumlah;
      $nasabah->save();

      DB::commit();
      flash('Approve Penarikan Berhasil');
      return redirect()->route('penarikan.approval')->with('success', 'Penarikan disetujui dan saldo nasabah diperbarui');
    } catch (\Throwable $e) {
      DB::rollback();
      flash('Approve Penarikan Gagal');
      return redirect()->route('penarikan.approval')->with('error', 'Ops... Terjadi kesalahan: ' . $e->getMessage());
    }
  }



  public function reject($id)
  {
    $penarikan = Penarikan::findOrFail($id);

    $penarikan->update(['status' => 'rejected']);
    flash('Reject Penarikan Berhasil');
    return redirect()->route('penarikan.approval')->with('error', 'Penarikan ditolak');
  }
}
