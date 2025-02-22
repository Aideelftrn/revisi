<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;
use App\Models\Nasabah;
use Illuminate\Support\Facades\Auth;
class ProfilController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        $user = auth()->user();

        $akunBanks = Akun::where('user_id', $user->id)->get(); 

        return view('profil.profil_create', [
            'user' => $user,
            'akunBanks' => $akunBanks
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,email,' . auth()->id(),
            'password' => 'required',
            'nomor_telp' => 'required',
        ]);
        $user = \App\Models\User::find(auth()->id());
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->name = $request->name;
        $user->email = $request->username;
        $user->nomor_telp = $request->nomor_telp;
        $user->save();
        flash('Profil berhasil diubah')->success();
        return back();
    }

    public function createAkun()
    {
        return view('profil.create-akun');
    }

    public function storeAkun(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string',
            'nomor_akun' => 'required|string|unique:akuns,nomor_akun', 
        ]);

        Akun::create([
            'user_id' => auth()->id(), 
            'jenis' => $request->jenis,
            'nomor_akun' => $request->nomor_akun,
        ]);

        return redirect()->route('profil.create')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
