<?php

namespace App\Exports;

use App\Models\Tindakan;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $pemasukan = Tindakan::query();
        $pengeluaran = Pengeluaran::query();

        // Filter data
        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $pemasukan->whereBetween('tanggal', [$this->request->start_date, $this->request->end_date]);
            $pengeluaran->whereBetween('tanggal', [$this->request->start_date, $this->request->end_date]);
        }

        if ($this->request->filled('range')) {
            $range = $this->request->range == '7_days' ? 7 : 30;
            $pemasukan->where('tanggal', '>=', now()->subDays($range));
            $pengeluaran->where('tanggal', '>=', now()->subDays($range));
        }

        // Combine data
        $pemasukanData = $pemasukan->get()->map(function ($item) {
            return [
                $item->tanggal,
                $item->opsi->nama ?? '-',
                $item->biaya,
                '-',
            ];
        });

        $pengeluaranData = $pengeluaran->get()->map(function ($item) {
            return [
                $item->tanggal,
                $item->nama ?? '-',
                '-',
                $item->jumlah,
            ];
        });

        return $pemasukanData->merge($pengeluaranData);
    }

    public function headings(): array
    {
        return ['Tanggal', 'Keterangan', 'Pemasukan', 'Pengeluaran'];
    }
}
