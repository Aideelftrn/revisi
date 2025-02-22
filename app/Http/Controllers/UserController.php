<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $data['user'] = \App\Models\User::latest()->get();
        $data['judul'] = 'Data-data User';
        return view('user.user_index', $data);
    }


    public function create()
    {
        return view('user.user_create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'nomor_telp' => 'required',
            'password' => 'required',
        ]);
        $user = new \App\Models\User();
        $user->password = bcrypt($request->password);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nomor_telp = $request->nomor_telp;
        $user->role = $request->role;
        $user->save();
        flash('Data berhasil dibuat')->success();
        return redirect('/user');
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $data['user'] = \App\Models\User::findOrFail($id);
        return view('user.user_edit', $data);
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'nomor_telp' => 'required',
            'password' => 'nullable',
        ]);
        $user = \App\Models\User::findOrFail($id);

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nomor_telp = $request->nomor_telp;
        $user->role = $request->role;
        $user->save();
        flash('Data berhasil diupdate')->success();
        return back();
    }


    public function destroy(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        if ($user->name == 'admin') {
            flash('Data user admin tidak bisa dihapus')->error();
            return back();
        }
        $user->delete();
        flash('Data berhasil dihapus')->success();
        return back();
    }
}
