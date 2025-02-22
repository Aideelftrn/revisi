<?php

namespace App\Http\Controllers;

use App\Models\Pengepul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Topup;
use App\Models\User;

class PengepulController extends Controller
{

    public function index()
    {
        $cari = request('q');
        if ($cari) {
            $data['pengepul'] = \App\Models\Pengepul::where('nama_pengepul', 'like', '%' . $cari . '%')
                ->orWhere('kode_pengepul', 'like', '%' . $cari . '%')
                ->paginate(10);
        } else {
            $data['pengepul'] = \App\Models\Pengepul::latest()->paginate(10);
        }
        $data['judul'] = 'Data-data Pengepul';
        return view('pengepul.pengepul_index', $data);
    }

    public function create()
    {
        $data['judul'] = 'Tambah Data Pengepul';
        $data['list_jk'] = [
            'Pria' => 'Pria',
            'Wanita' => 'Wanita'
        ];


        if (auth()->check()) {
            $user = auth()->user();
            $pengepul = \App\Models\Pengepul::where('nama_pengepul', $user->name)->first();

            if ($pengepul) {
                $data['user_name'] = $pengepul->nama_pengepul;
                $data['email'] = $pengepul->email;
                $data['nomor_telp'] = $pengepul->nomor_telp;
                $data['jenis_kelamin'] = $pengepul->jenis_kelamin;
                $data['alamat'] = $pengepul->alamat;
            } else {
                $data['user_name'] = null;
                $data['email'] = null;
                $data['nomor_telp'] = null;
                $data['jenis_kelamin'] = null;
                $data['alamat'] = null;
            }
        } else {
            $data['user_name'] = null;
            $data['email'] = null;
            $data['nomor_telp'] = null;
            $data['jenis_kelamin'] = null;
            $data['alamat'] = null;
        }

        return view('pengepul.pengepul_create', $data);
    }

    public function store(Request $request)
    {
        $validasiData = $request->validate([
            'nama_pengepul' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'saldo' => 'nullable|numeric|min:0',
            'email' => 'required|email',
            'password' => 'required',
            'nomor_telp' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $pengepulExist = \App\Models\Pengepul::where('nama_pengepul', $request->nama_pengepul)->first();
            $kode = 'P0001';
            if (!$pengepulExist) {
                $kodeQuery = \App\Models\Pengepul::orderBy('id', 'desc')->first();
                if ($kodeQuery) {
                    $kode = 'P' . sprintf('%04d', $kodeQuery->id + 1);
                }

                $user = new \App\Models\User();
                $user->name = $validasiData['nama_pengepul'];
                $user->email = $validasiData['email'];
                $user->nomor_telp = $validasiData['nomor_telp'];
                $user->password = bcrypt($request->password);
                $user->role = 'pengepul';
                $user->save();


                $pengepul = new \App\Models\Pengepul();
                $pengepul->kode_pengepul = $kode;
                $pengepul->nama_pengepul = $request->nama_pengepul;
                $pengepul->jenis_kelamin = $request->jenis_kelamin;
                $pengepul->alamat = $request->alamat;
                $pengepul->nomor_telp = $request->nomor_telp;
                // $pengepul->nik = $request->nik;
                // $pengepul->umur = $request->umur;
                $pengepul->email = $request->email;
                $pengepul->saldo = $request->saldo;
                $pengepul->user_id = $user->id;
                $pengepul->password = bcrypt($request->password);
                $pengepul->save();
            }

            DB::commit();
            flash('Berhasil tambah data Pengepul');
            return redirect('/pengepul');
        } catch (\Throwable $e) {
            DB::rollback();
            flash('Ops... Terjadi kesalahan: ' . $e->getMessage())->error();
            return back();
        }
    }


    public function registerAkunPengepul()
    {
        $data['judul'] = 'Registrasi Pengepul Baru';
        return view('auth.register', $data);
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $data['pengepul'] = \App\Models\Pengepul::findOrFail($id);
        $data['judul'] = 'Tambah Data';
        return view('pengepul.pengepul_edit', $data);
    }


    public function update(Request $request, string $id)
    {

        $pengepul = \App\Models\Pengepul::findOrFail($id);
        $pengepul->nama_pengepul = $request->nama_pengepul;
        $pengepul->nomor_telp = $request->nomor_telp;
        // $pengepul->umur = $request->umur;
        // $pengepul->nik = $request->nik;
        $pengepul->alamat = $request->alamat;
        $pengepul->save();

        flash('Data berhasil diubah');
        return redirect('pengepul');
    }


    public function destroy(string $id)
    {
        $pengepul = \App\Models\Pengepul::findOrFail($id);

        $pengepul->delete();
        flash('Data berhasil dihapus');
        return back();
    }

    public function showTopUpForm($id)
    {
        $data['pengepul'] = \App\Models\Pengepul::findOrFail($id);
        $data['judul'] = 'Top Up Saldo Pengepul';
        return view('pengepul.topup_form', $data);
    }

    public function topUp(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'metode' => 'required|in:bank,e-wallet',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $pengepul = Pengepul::findOrFail($id);

            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

            $topup = new Topup();
            $topup->pengepul_id = $pengepul->id;
            $topup->jumlah = $request->jumlah;
            $topup->metode = $request->metode;
            $topup->status = 'pending';
            $topup->bukti_pembayaran = $buktiPath;
            $topup->save();

            DB::commit();
            flash('Top Up berhasil dikirim untuk persetujuan')->success();
            return redirect()->route('pengepul.riwayatTopup', ['id' => $pengepul->id]);
        } catch (\Throwable $e) {
            DB::rollback();
            flash('Ops... Terjadi kesalahan: ' . $e->getMessage())->error();
            return back();
        }
    }



    public function indexTopups()
    {

        $topups = Topup::where('status', 'pending')->get();
        return view('penarikan.topups_index', compact('topups'));
    }

    public function approveTopup($id)
    {
        DB::beginTransaction();
        try {
            $topup = Topup::findOrFail($id);

            $adminFee = $topup->jumlah * 0.01;

            $pengepulAmount = $topup->jumlah - $adminFee;

            $topup->status = 'approved';
            $topup->save();

            $pengepul = $topup->pengepul;
            $pengepul->saldo += $pengepulAmount;
            $pengepul->save();

            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                $admin->saldo += $adminFee;
                $admin->save();
            } else {
                throw new \Exception('Admin tidak ditemukan.');
            }

            DB::commit();
            flash('Top Up berhasil disetujui')->success();
            return redirect()->route('pengepul.topups');
        } catch (\Throwable $e) {
            DB::rollback();
            flash('Ops... Terjadi kesalahan: ' . $e->getMessage())->error();
            return back();
        }
    }



    public function rejectTopup($id)
    {
        DB::beginTransaction();
        try {
            $topup = Topup::findOrFail($id);
            $topup->status = 'rejected';
            $topup->save();

            DB::commit();
            flash('Top Up berhasil ditolak')->success();
            return redirect()->route('pengepul.topups');
        } catch (\Throwable $e) {
            DB::rollback();
            flash('Ops... Terjadi kesalahan: ' . $e->getMessage())->error();
            return back();
        }
    }



    public function riwayatTopup($id)
    {
        $pengepul = Pengepul::findOrFail($id);
        $topups = Topup::where('pengepul_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pengepul.riwayat_topup', [
            'pengepul' => $pengepul,
            'topups' => $topups
        ]);
    }
}
