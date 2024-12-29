<?php

namespace App\Http\Controllers;

use App\Models\OpsiTindakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpsiTindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.opsi_tindakan', [
            'OpsiTindakan' => OpsiTindakan::all(),
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
            ]);

            OpsiTindakan::create($validatedData);

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

    /**
     * Display the specified resource.
     */
    public function show(OpsiTindakan $opsiTindakan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OpsiTindakan $opsiTindakan)
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
            ]);

            $opsiTindakan = OpsiTindakan::findOrFail($id);

            $opsiTindakan->update($validatedData);

            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Data opsi tindakan berhasil diperbarui.',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'message' => 'Gagal memperbarui data opsi tindakan. Silakan coba lagi. Error: ' . $e->getMessage()
            ])->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = OpsiTindakan::findOrFail($id);

            $data->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
