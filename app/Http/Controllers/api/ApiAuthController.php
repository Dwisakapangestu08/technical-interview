<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function index(Request $request)
    {

        $validasi = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
        ]);
        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'validasi' => true,
                'errors' => $validasi->errors()
            ]);
        }

        $email = $request->email;
        $password = $request->password;
        $cek_akun = User::where('email', $email)->first();
        if (!$cek_akun || !Hash::check($password, $cek_akun->password)) {
            return response()->json([
                'success' => false,
                'validasi' => false,
                'message' => 'Email atau password yang anda masukkan salah atau tidak terdaftar',
            ]);
        }

        $redirect = '';
        if ($cek_akun->role == 1) {
            $redirect = 'admin';
        } else if ($cek_akun->role == 2) {
            $redirect = 'member';
        }

        return response()->json([
            'success' => true,
            'redirect' => $redirect,
            'message' => 'Anda berhasil login, akan dialihkan ke halaman utama',
            'remember_token' => $cek_akun->remember_token
        ]);
    }
    public function register(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Nama harus diisi',
            'password.required' => 'Kata sandi harus diisi',
            'password.min' => 'Kata sandi minimal 8 karakter',
            'password.confirmed' => 'Kata sandi tidak cocok',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'validasi' => true,
                'errors' => $validasi->errors(),
            ]);
        }

        $value = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ];

        $save = User::create($value);
        if ($save) {
            return response()->json([
                'success' => true,
                'message' => 'Anda berhasil mendaftarkan akun',
            ]);
        }

        return response()->json([
            'success' => false,
            'validasi' => false,
            'message' => 'Anda gagal mendaftarkan akun',
        ]);
    }
}
