<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThemeSettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('dashboard.theme_setting', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first() ?? new Setting();

        $request->validate([
            'nama_klinik' => 'required|string|max:255',
            'nama_dokter' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
        ]);

        $setting->nama_klinik = $request->nama_klinik;
        $setting->nama_dokter = $request->nama_dokter;
        $setting->alamat = $request->alamat;
        $setting->no_telp = $request->no_telp;
        $setting->email = $request->email;

        // Handle file uploads
        if ($request->hasFile('logo')) {
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }
            $setting->logo = $request->file('logo')->store('images/settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon && Storage::disk('public')->exists($setting->favicon)) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $setting->favicon = $request->file('favicon')->store('images/settings', 'public');
        }

        // Handle JSON Theme Colors
        $themeColors = $request->only(['primary', 'secondary', 'accent', 'neutral', 'success', 'error']);
        $setting->theme_colors = array_merge($setting->theme_colors ?? [], $themeColors);

        $setting->save();

        return redirect()->back()->with('toast', [
            'message' => 'Detail aplikasi dan tema berhasil diperbarui!',
            'type' => 'success'
        ]);
    }
}
