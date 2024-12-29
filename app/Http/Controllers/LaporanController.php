<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Laporan;
use App\Models\Tindakan;
use Barryvdh\DomPDF\PDF;
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
        $pemasukan = Tindakan::query();
        $pengeluaran = Pengeluaran::query();

        // Filter data
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $pemasukan->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            $pengeluaran->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('range')) {
            $range = $request->range == '7_days' ? 7 : 30;
            $pemasukan->where('tanggal', '>=', now()->subDays($range));
            $pengeluaran->where('tanggal', '>=', now()->subDays($range));
        }

        $data = [
            'pemasukan' => $pemasukan->get(),
            'pengeluaran' => $pengeluaran->get(),
            'totalPemasukan' => $pemasukan->sum('biaya'),
            'totalPengeluaran' => $pengeluaran->sum('jumlah'),
        ];

        // Render view secara manual
        $html = view('vendor.pdf_laporan', $data)->render();

        // Konfigurasi DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Download PDF langsung tanpa menyimpannya
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="laporan-keuangan.pdf"',
        ]);
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new LaporanExport($request), 'laporan-keuangan.xlsx');
    }
}
