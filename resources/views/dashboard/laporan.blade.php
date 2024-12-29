<x-dashboard.main title="Laporan">
    <div class="flex gap-5">
        {{-- Bagian Laporan Keuangan --}}
        <div class="flex flex-col border-back bg-neutral rounded-xl w-full">
            <div class="p-5 sm:p-7 bg-neutral rounded-t-xl">
                <h1 class="flex items-start gap-3 font-semibold font-[onest] text-lg capitalize text-white">
                    Laporan Keuangan
                </h1>
                <p class="text-sm opacity-60 text-white">
                    Detail laporan keuangan untuk periode tertentu.
                </p>
            </div>
            <div class="flex flex-col bg-neutral rounded-b-xl gap-3 divide-y pt-0 p-5 sm:p-7">
                {{-- Form Filter --}}
                <div class="flex justify-between items-center mb-4 gap-4">
                    <form method="GET" action="{{ route('laporan') }}" class="flex gap-3 items-center">
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="input input-sm shadow-md w-36 bg-neutral text-white" placeholder="Dari Tanggal">
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="input input-sm shadow-md w-36 bg-neutral text-white" placeholder="Sampai Tanggal">
                        <select name="range" class="input input-sm shadow-md w-36 bg-neutral text-white">
                            <option value="">Pilih Rentang</option>
                            <option value="7_days" {{ request('range') == '7_days' ? 'selected' : '' }}>7 Hari Terakhir
                            </option>
                            <option value="30_days" {{ request('range') == '30_days' ? 'selected' : '' }}>30 Hari
                                Terakhir</option>
                        </select>
                        <button type="submit" class="btn btn text-white"
                            style="background-color: #eb873b;">Filter</button>
                    </form>

                    {{-- Export Buttons --}}
                    <div class="flex gap-3">
                        <form method="GET" action="{{ route('laporan.export.pdf') }}">
                            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                            <input type="hidden" name="range" value="{{ request('range') }}">
                            <button type="submit" class="btn btn-sm text-white" style="background-color: #eb873b;">
                                Export PDF
                            </button>
                        </form>
                        <form method="GET" action="{{ route('laporan.export.excel') }}">
                            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                            <input type="hidden" name="range" value="{{ request('range') }}">
                            <button type="submit" class="btn btn-sm text-white" style="background-color: #eb873b;">
                                Export Excel
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Tabel Laporan --}}
                @if (!$pemasukan->isNotEmpty() && !$pengeluaran->isNotEmpty() && !request()->filled(['start_date', 'end_date', 'range']))
                    <p class="text-gray-300">Silahkan filter terlebih dahulu untuk melihat laporan.</p>
                @elseif(!$pemasukan->isNotEmpty() && !$pengeluaran->isNotEmpty())
                    <p class="text-gray-300">Tidak ada data untuk periode yang dipilih.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="table w-full text-white">
                            <thead class="text-sm">
                                <tr class="text-white">
                                    <th class="uppercase font-bold text-center">No</th>
                                    <th class="uppercase font-bold text-center">Tanggal</th>
                                    <th class="uppercase font-bold text-center">Keterangan</th>
                                    <th class="uppercase font-bold text-center">Pemasukan</th>
                                    <th class="uppercase font-bold text-center">Pengeluaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Pemasukan --}}
                                @foreach ($pemasukan as $i => $item)
                                    <tr>
                                        <td class="font-semibold capitalize text-center">{{ $i + 1 }}</td>
                                        <td class="font-semibold capitalize text-center">{{ $item->tanggal }}</td>
                                        <td class="font-semibold capitalize text-center">{{ $item->opsi->nama ?? '-' }}
                                        </td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ formatRupiah($item->biaya) }}
                                        </td>
                                        <td class="font-semibold capitalize text-center">-</td>
                                    </tr>
                                @endforeach

                                {{-- Pengeluaran --}}
                                @foreach ($pengeluaran as $i => $item)
                                    <tr>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $pemasukan->count() + $i + 1 }}</td>
                                        <td class="font-semibold capitalize text-center">{{ $item->tanggal }}</td>
                                        <td class="font-semibold capitalize text-center">{{ $item->nama ?? '-' }}</td>
                                        <td class="font-semibold capitalize text-center">-</td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ formatRupiah($item->jumlah) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Total Section --}}
                    <div class="mt-4">
                        <div
                            class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-neutral-light p-4 rounded-lg">
                            <p class="font-semibold text-white">
                                Total Pemasukan: <span
                                    class="text-green-400">{{ formatRupiah($totalPemasukan) }}</span>
                            </p>
                            <p class="font-semibold text-white">
                                Total Pengeluaran: <span
                                    class="text-red-400">{{ formatRupiah($totalPengeluaran) }}</span>
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard.main>