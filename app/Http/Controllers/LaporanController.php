<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Laporan;
use App\Models\Tindakan;
use Barryvdh\DomPDF\Facade\PDF;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth()->toDateString();
        $range = $request->range;

        $pengeluaranQuery = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate]);
        $pengeluaran = $pengeluaranQuery->get();
        $totalPengeluaran = $pengeluaran->sum('jumlah');

        $tindakanQuery = Tindakan::whereBetween('tanggal', [$startDate, $endDate]);
        $tindakan = $tindakanQuery->get();
        $totalPemasukan = $tindakan->sum('biaya');

        if ($range == '7_days') {
            $startDate = Carbon::now()->subDays(7)->toDateString();
        } elseif ($range == '30_days') {
            $startDate = Carbon::now()->subDays(30)->toDateString();
        }

        return view('dashboard.laporan', [
            'pemasukan' => $tindakanQuery->get(),
            'pengeluaran' => $pengeluaranQuery->get(),
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
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

    public function exportPdf(Request $request)
    {
        $pemasukanQuery = Tindakan::query();
        $pengeluaranQuery = Pengeluaran::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $pemasukanQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            $pengeluaranQuery->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('range')) {
            $range = $request->range == '7_days' ? 7 : 30;
            $pemasukanQuery->where('tanggal', '>=', now()->subDays($range));
            $pengeluaranQuery->where('tanggal', '>=', now()->subDays($range));
        }

        $pemasukan = $pemasukanQuery->get();
        $pengeluaran = $pengeluaranQuery->get();

        $data = [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'totalPemasukan' => $pemasukan->sum('biaya'),
            'totalPengeluaran' => $pengeluaran->sum('jumlah'),
        ];

        $filename = 'laporan-keuangan-' . now()->format('YmdHis') . '.pdf';
        $pdf = Pdf::loadView('vendor.pdf_laporan', $data)->setPaper('A4', 'portrait');
        $pdf->save(storage_path("app/public/{$filename}"));

        return redirect()->route('laporan.download.pdf', ['filename' => $filename]);
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new LaporanExport($request), 'laporan-keuangan.xlsx');
    }
}
