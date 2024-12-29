<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <!-- Link DaisyUI and Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/daisyui@2.40.0/dist/full.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-5">
        <h1 class="text-center text-2xl font-bold mb-5">Laporan Keuangan</h1>

        <!-- Tabel Laporan Keuangan -->
        <div class="overflow-x-auto bg-white p-4 rounded-xl shadow-lg">
            <table class="table w-full table-striped table-hover">
                <thead class="bg-neutral text-white">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Pemasukan</th>
                        <th>Pengeluaran</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; $totalPemasukan = 0; $totalPengeluaran = 0; @endphp

                    {{-- Pemasukan --}}
                    @foreach ($pemasukan as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->opsi->nama ?? '-' }}</td>
                            <td>{{ 'Rp. ' . number_format($item->biaya, 0, ',', '.') }}</td>
                            <td>-</td>
                            @php $totalPemasukan += $item->biaya; @endphp
                        </tr>
                    @endforeach

                    {{-- Pengeluaran --}}
                    @foreach ($pengeluaran as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->nama ?? '-' }}</td>
                            <td>-</td>
                            <td>{{ 'Rp. ' . number_format($item->jumlah, 0, ',', '.') }}</td>
                            @php $totalPengeluaran += $item->jumlah; @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Total Pemasukan dan Pengeluaran --}}
        <div class="flex justify-between mt-6 bg-white p-4 rounded-xl shadow-lg">
            <div class="font-bold text-lg">
                <p>Total Pemasukan: <span class="text-green-500">{{ 'Rp. ' . number_format($totalPemasukan, 0, ',', '.') }}</span></p>
                <p>Total Pengeluaran: <span class="text-red-500">{{ 'Rp. ' . number_format($totalPengeluaran, 0, ',', '.') }}</span></p>
            </div>
            <div class="font-bold text-lg">
                <p>
                    <span class="text-blue-500">Total Keuntungan: </span> 
                    <span class="{{ $totalPemasukan >= $totalPengeluaran ? 'text-green-600' : 'text-red-600' }}">
                        {{ 'Rp. ' . number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
