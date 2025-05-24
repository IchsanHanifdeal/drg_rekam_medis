<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.tindakan', [
            'tindakan' => Tindakan::orderBy('created_at', 'desc')->paginate('10'),
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
                'pasien' => 'required',
                'tanggal' => 'required|date',
                'td' => 'required|string',
                'bb' => 'required|numeric',
                'tindakan' => 'required|string',
                'biaya' => 'required|numeric',
            ], [
                'pasien.required' => 'Pasien wajib dipilih.',
                'tanggal.required' => 'Tanggal wajib diisi.',
                'tanggal.date' => 'Format tanggal tidak valid.',
                'td.required' => 'Tensi darah wajib diisi.',
                'bb.required' => 'Berat badan wajib diisi.',
                'tindakan.required' => 'Tindakan wajib dipilih.',
                'biaya.required' => 'Biaya wajib diisi.',
            ]);

            $tindakan = Tindakan::create([
                'pendaftaran' => $validatedData['pasien'],
                'tanggal' => $validatedData['tanggal'],
                'tensi_darah' => $validatedData['td'],
                'berat_badan' => $validatedData['bb'],
                'opsi_tindakan' => $validatedData['tindakan'],
                'biaya' => $validatedData['biaya'],
            ]);

            if (!$tindakan) {
                throw new \Exception('Gagal menyimpan data tindakan.');
            }

            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Tindakan pasien berhasil disimpan.',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error menyimpan tindakan: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'message' => 'Gagal menyimpan data tindakan. Silakan coba lagi. Error: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tindakan $tindakan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tindakan $tindakan)
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
                'pasien' => 'required',
                'tanggal' => 'required|date',
                'td' => 'required|string',
                'bb' => 'required|numeric',
                'tindakan' => 'required|string',
                'biaya' => 'required|numeric',
            ], [
                'pasien.required' => 'Pasien wajib dipilih.',
                'tanggal.required' => 'Tanggal wajib diisi.',
                'tanggal.date' => 'Format tanggal tidak valid.',
                'td.required' => 'Tensi darah wajib diisi.',
                'bb.required' => 'Berat badan wajib diisi.',
                'tindakan.required' => 'Tindakan wajib dipilih.',
                'biaya.required' => 'Biaya wajib diisi.',
            ]);

            $tindakan = Tindakan::findOrFail($id);

            $tindakan->update([
                'pendaftaran' => $validatedData['pasien'],
                'tanggal' => $validatedData['tanggal'],
                'tensi_darah' => $validatedData['td'],
                'berat_badan' => $validatedData['bb'],
                'opsi_tindakan' => $validatedData['tindakan'],
                'biaya' => $validatedData['biaya'],
            ]);

            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Tindakan pasien berhasil diperbarui.',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error memperbarui tindakan: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'message' => 'Gagal memperbarui data tindakan. Silakan coba lagi. Error: ' . $e->getMessage(),
            ])->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Tindakan::findOrFail($id);

            $data->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function filterAjax(Request $request)
    {
        $date = $request->get('filter_date');
        $pemasukan = Tindakan::whereDate('tanggal', $date)->sum('jumlah');

        return response()->json([
            'pemasukan' => number_format($pemasukan, 0, ',', '.'),
        ]);
    }
}
