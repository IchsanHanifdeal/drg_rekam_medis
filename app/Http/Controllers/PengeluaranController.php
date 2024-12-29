<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pengeluaran::query();

        // Fitur Pencarian
        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        return view('dashboard.pengeluaran', [
            'pengeluaran' => $query->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'tanggal' => 'required|date',
                'jumlah_raw' => 'required',
            ], [
                'nama.required' => 'Nama pasien wajib diisi.',
                'tanggal.required' => 'Tanggal wajib diisi.',
                'jumlah_raw.required' => 'Jumlah wajib diisi.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'message' => 'Gagal menyimpan data pendaftaran. Silakan coba lagi. Error: ' . $e->getMessage()
            ])->withInput();
        }

        $pengeluaran = Pengeluaran::create([
            'nama' => $validatedData['nama'],
            'tanggal' => $validatedData['tanggal'],
            'jumlah' => $validatedData['jumlah_raw'],
        ]);

        if (!$pengeluaran) {
            throw new \Exception('Gagal menyimpan data pengeluaran.');
        }

        DB::commit();

        return redirect()->back()->with('toast', [
            'message' => 'Pencatatan Pengeluaran berhasil.',
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'tanggal' => 'required|date',
                'jumlah_raw' => 'required|numeric',
            ], [
                'nama.required' => 'Nama pasien wajib diisi.',
                'tanggal.required' => 'Tanggal wajib diisi.',
                'jumlah_raw.required' => 'Jumlah wajib diisi.',
                'jumlah_raw.numeric' => 'Jumlah harus berupa angka.',
            ]);

            $pengeluaran = Pengeluaran::findOrFail($id);

            $pengeluaran->update([
                'nama' => $validatedData['nama'],
                'tanggal' => $validatedData['tanggal'],
                'jumlah' => $validatedData['jumlah_raw'],
            ]);

            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Data pengeluaran berhasil diperbarui.',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error memperbarui data pengeluaran: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'message' => 'Gagal memperbarui data pengeluaran. Silakan coba lagi. Error: ' . $e->getMessage(),
            ])->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Pengeluaran::findOrFail($id);

            $data->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
