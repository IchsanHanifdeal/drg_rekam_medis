<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tindakan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        // Data Pendaftar
        $pendaftar = Pendaftaran::orderBy('created_at', 'desc')->get();

        // Membuat data deret waktu 7 hari terakhir untuk grafik fungsional
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $last7Days[now()->subDays($i)->format('Y-m-d')] = [
                'pendaftaran' => 0,
                'tindakan' => 0
            ];
        }

        foreach ($pendaftar as $item) {
            $date = Carbon::parse($item->created_at)->format('Y-m-d');
            if (isset($last7Days[$date])) {
                $last7Days[$date]['pendaftaran']++;
            }
        }

        $tindakans = Tindakan::where('tanggal', '>=', now()->subDays(6)->format('Y-m-d'))->get();
        foreach ($tindakans as $item) {
            $date = Carbon::parse($item->tanggal)->format('Y-m-d');
            if (isset($last7Days[$date])) {
                $last7Days[$date]['tindakan']++;
            }
        }

        $chartLabels = [];
        $chartPendaftaran = [];
        $chartTindakan = [];

        foreach ($last7Days as $date => $counts) {
            $chartLabels[] = Carbon::parse($date)->translatedFormat('d M');
            $chartPendaftaran[] = $counts['pendaftaran'];
            $chartTindakan[] = $counts['tindakan'];
        }

        // Aktivitas terbaru
        $recentActivities = collect()
            ->merge(
                Pendaftaran::select('id', 'nama', 'created_at')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'type' => 'Pendaftaran Pasien Baru',
                            'message' => $item->nama,
                            'time' => $item->created_at,
                        ];
                    })
            )
            ->merge(
                Tindakan::select('id', 'pendaftaran', 'tanggal', 'opsi_tindakan', 'created_at')
                    ->with('pendaftarans')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'type' => 'Melakukan tindakan ' . $item->opsi_tindakan . ' kepada pasien',
                            'message' => $item->pendaftarans->nama,
                            'time' => $item->created_at,
                        ];
                    })
            )
            ->sortByDesc('time')
            ->take(5);

        // Data untuk tampilan
        return view('dashboard.index', [
            'pendaftar' => $pendaftar,
            'chartLabels' => $chartLabels,
            'chartPendaftaran' => $chartPendaftaran,
            'chartTindakan' => $chartTindakan,
            'tindakan' => Tindakan::all(),
            'pemasukan' => Tindakan::whereMonth('tanggal', $bulanIni)
                ->whereYear('tanggal', $tahunIni)
                ->sum('biaya'),
            'recentActivities' => $recentActivities,
        ]);
    }

    public function filterAjax(Request $request)
    {
        $date = $request->get('filter_date');

        // Hitung total pemasukan berdasarkan tanggal
        $pemasukan = Tindakan::whereDate('tanggal', $date)->sum('biaya');

        return response()->json([
            'pemasukan' => number_format($pemasukan, 0, ',', '.'),
        ]);
    }

    public function pemasukanHarian(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Tindakan::query()
            ->select('tanggal', \DB::raw('SUM(CAST(biaya AS UNSIGNED)) as total_pemasukan'), \DB::raw('COUNT(id) as total_tindakan'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc');

        if ($startDate) {
            $query->where('tanggal', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('tanggal', '<=', $endDate);
        }

        $pemasukanHarian = $query->paginate(10);
        $pemasukanHarian->appends($request->all());

        return view('dashboard.pemasukan_harian', [
            'pemasukanHarian' => $pemasukanHarian,
            'startDate' => $startDate,
            'endDate' => $endDate,
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
