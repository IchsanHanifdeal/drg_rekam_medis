<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $existingNumbers = Pendaftaran::pluck('nomor_rekam_medis')->toArray();

        $newNumber = $this->findAvailableNomor($existingNumbers);

        return view('dashboard.pendaftaran', [
            'pendaftaran' => Pendaftaran::orderBy('created_at', 'desc')->get(),
            'nomor_rekam_medis' => $newNumber,
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'umur' => 'required|date',
                'jenis_kelamin' => 'required|in:laki-laki,perempuan',
                'alamat' => 'required|string|max:255',
                'no_hp' => 'required|string|max:15',
            ], [
                'nama.required' => 'Nama pasien wajib diisi.',
                'umur.required' => 'Tanggal lahir wajib diisi.',
                'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                'jenis_kelamin.in' => 'Jenis kelamin harus "laki-laki" atau "perempuan".',
                'alamat.required' => 'Alamat wajib diisi.',
                'no_hp.required' => 'Nomor HP wajib diisi.',
            ]);

            $existingNumbers = Pendaftaran::pluck('nomor_rekam_medis')->toArray();
            $newNomorRekamMedis = $this->findAvailableNomor($existingNumbers);

            $validatedData['nomor_rekam_medis'] = $newNomorRekamMedis;

            Pendaftaran::create($validatedData);

            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Pendaftaran pasien berhasil.',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'message' => 'Gagal menyimpan data pendaftaran. Silakan coba lagi. Error: ' . $e->getMessage()
            ])->withInput();
        }
    }

    private function findAvailableNomor(array $existingNumbers)
    {
        $existingNumbers = array_map(function ($item) {
            return (int) substr($item, -5);
        }, $existingNumbers);

        sort($existingNumbers);

        for ($i = 1; $i <= count($existingNumbers); $i++) {
            if (!in_array($i, $existingNumbers)) {
                return str_pad($i, 5, '0', STR_PAD_LEFT);
            }
        }

        return str_pad(count($existingNumbers) + 1, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendaftaran $pendaftaran)
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
                'jenis_kelamin' => 'required|in:laki-laki,perempuan',
                'alamat' => 'required|string|max:255',
                'no_hp' => 'required|string|max:15',
            ], [
                'nama.required' => 'Nama pasien wajib diisi.',
                'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                'jenis_kelamin.in' => 'Jenis kelamin harus "laki-laki" atau "perempuan".',
                'alamat.required' => 'Alamat wajib diisi.',
                'no_hp.required' => 'Nomor HP wajib diisi.',
            ]);

            $pendaftaran = Pendaftaran::findOrFail($id);

            $pendaftaran->update($validatedData);

            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Pendaftaran pasien berhasil diperbarui.',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'message' => 'Gagal memperbarui data pendaftaran. Silakan coba lagi. Error: ' . $e->getMessage()
            ])->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Pendaftaran::findOrFail($id);

            $data->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
