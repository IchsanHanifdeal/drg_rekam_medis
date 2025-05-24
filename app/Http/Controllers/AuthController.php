<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function auth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email salah.',
            'password.required' => 'Password harus diisi.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $userRole = $user->role;

            $loginTime = Carbon::now();
            $request->session()->put([
                'login_time' => $loginTime->toDateTimeString(),
                'nama' => $user->name,
                'id_user' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at
            ]);


            if ($userRole === 'admin') {
                return redirect()->intended('dashboard')->with('toast', [
                    'message' => 'Login berhasil!',
                    'type' => 'success'
                ]);
            }

            return back()->with('toast', [
                'message' => 'Login gagal, role pengguna tidak dikenali.',
                'type' => 'error'
            ]);
        }

        return back()->withErrors([
            'loginError' => 'Email atau password salah.',
        ])->with('toast', [
            'message' => 'Email atau password salah.',
            'type' => 'error'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('toast', [
            'message' => 'Logout berhasil!',
            'type' => 'success'
        ]);;
    }

    /**
     * Display the specified resource.
     */
    public function update_info(Request $request, $id)
    {
        // Cegah user update data milik user lain
        if (Auth::id() != $id) {
            abort(403, 'Unauthorized');
        }

        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
            ], [
                'nama.required' => 'Nama lengkap wajib diisi.',
            ]);

            // Gunakan findOrFail agar error jika user tidak ditemukan
            $user = User::findOrFail($id);
            $user->name = $validated['nama'];
            $user->save(); // <-- ini penting, jangan lupa simpan

            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Profil berhasil diperbarui.',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error update profil: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'message' => 'Gagal memperbarui profil. Silakan coba lagi. Error: ' . $e->getMessage(),
            ])->withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function update_password(Request $request, $id)
    {
        if (Auth::id() != $id) {
            abort(403, 'Unauthorized');
        }

        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'password_lama' => 'required',
                'password_baru' => 'required|min:8|confirmed',
            ], [
                'password_lama.required' => 'Password lama wajib diisi.',
                'password_baru.required' => 'Password baru wajib diisi.',
                'password_baru.min' => 'Password baru minimal 8 karakter.',
                'password_baru.confirmed' => 'Konfirmasi password tidak cocok.',
            ]);

            $user = User::findOrFail($id);

            if (!Hash::check($validated['password_lama'], $user->password)) {
                throw new \Exception('Password lama tidak sesuai.');
            }

            $user->password = Hash::make($validated['password_baru']);
            $user->save(); // Jangan lupa disimpan

            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Password berhasil diperbarui.',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error update password: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'message' => 'Gagal memperbarui password. Silakan coba lagi. Error: ' . $e->getMessage(),
            ])->withInput();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
