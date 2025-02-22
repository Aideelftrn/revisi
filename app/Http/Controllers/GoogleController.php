<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Nasabah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class GoogleController extends Controller
{
    use AuthenticatesUsers;

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                Auth::login($user);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make('123'),
                    'role' => 'nasabah',
                ]);

                Nasabah::create([
                    'user_id' => $user->id,
                    'kode_nasabah' => 'N' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'nama_nasabah' => $user->name,
                    'jenis_kelamin' => 'Laki-Laki',
                    'email' => $user->email,
                    'nomor_telp' => '',
                    'alamat' => '',
                    'password' => Hash::make('123'),
                    'umur' => null,
                    'nik' => '',
                    'role' => 'nasabah',
                    'saldo' => 0,
                ]);

                Auth::login($user);
            }

            // Log::info('User logged in', ['user' => Auth::user()]);

            return redirect()->route(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
            // Log::error('Google login failed', ['error' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'Failed to authenticate with Google.');
        }
    }
}
