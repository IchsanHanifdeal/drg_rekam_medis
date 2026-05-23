<x-dashboard.main title="Pemasukan per Hari">
    <div class="grid grid-cols-1 gap-5">
        {{-- Card Header & Filter --}}
        <div class="flex flex-col border-back bg-neutral rounded-xl w-full">
            <div class="p-5 sm:p-7 bg-neutral rounded-t-xl">
                <h1 class="font-semibold font-[onest] text-lg capitalize text-white flex items-center gap-3">
                    <x-lucide-trending-up class="text-green-400 size-6" /> Laporan Pemasukan per Hari
                </h1>
                <p class="text-sm opacity-60 text-white mt-1">
                    Analisis data pemasukan harian klinik secara ringkas, akurat, dan mudah dipantau.
                </p>
            </div>

            {{-- Form Filter --}}
            <div class="px-5 sm:px-7 bg-neutral pb-4 border-b border-white/5">
                <form method="GET" action="{{ route('pemasukan_harian') }}" class="flex flex-col sm:flex-row gap-3 items-end w-full">
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-semibold text-gray-300 mb-1">Mulai Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="input input-sm shadow-md w-full bg-neutral text-white border-white/10" placeholder="Dari Tanggal">
                    </div>
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-semibold text-gray-300 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="input input-sm shadow-md w-full bg-neutral text-white border-white/10" placeholder="Sampai Tanggal">
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="btn btn-sm text-white border-none flex-1 sm:flex-initial" style="background-color: #eb873b;">
                            <x-lucide-filter class="size-4" /> Filter
                        </button>
                        <a href="{{ route('pemasukan_harian') }}" class="btn btn-sm bg-slate-700 text-white border-none flex-1 sm:flex-initial">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Stats Summary Section --}}
            <div class="px-5 sm:px-7 pt-6 bg-neutral">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Total Pemasukan --}}
                    <div class="p-4 bg-white/5 border border-white/5 rounded-xl flex items-center gap-4">
                        <div class="p-3 bg-green-500/20 text-green-400 rounded-lg">
                            <x-lucide-dollar-sign class="size-6" />
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 font-semibold uppercase">Total Pemasukan</span>
                            <h2 class="text-lg sm:text-xl font-bold text-white mt-0.5">
                                Rp {{ number_format($pemasukanHarian->sum('total_pemasukan'), 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>

                    {{-- Total Tindakan --}}
                    <div class="p-4 bg-white/5 border border-white/5 rounded-xl flex items-center gap-4">
                        <div class="p-3 bg-blue-500/20 text-blue-400 rounded-lg">
                            <x-lucide-stethoscope class="size-6" />
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 font-semibold uppercase">Total Tindakan</span>
                            <h2 class="text-lg sm:text-xl font-bold text-white mt-0.5">
                                {{ $pemasukanHarian->sum('total_tindakan') }} Kali
                            </h2>
                        </div>
                    </div>

                    {{-- Rata-rata Pemasukan --}}
                    <div class="p-4 bg-white/5 border border-white/5 rounded-xl flex items-center gap-4">
                        <div class="p-3 bg-amber-500/20 text-amber-400 rounded-lg">
                            <x-lucide-activity class="size-6" />
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 font-semibold uppercase">Rata-Rata / Hari</span>
                            <h2 class="text-lg sm:text-xl font-bold text-white mt-0.5">
                                @php
                                    $count = $pemasukanHarian->count();
                                    $avg = $count > 0 ? $pemasukanHarian->sum('total_pemasukan') / $count : 0;
                                @endphp
                                Rp {{ number_format($avg, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table Daily Income --}}
            <div class="flex flex-col rounded-b-xl gap-3 pt-6 p-5 sm:p-7 bg-neutral">
                <div class="overflow-x-auto w-full">
                    <table class="table w-full text-white text-sm sm:text-base" id="pemasukanTable">
                        <thead>
                            <tr class="text-white text-center">
                                <th class="uppercase font-bold">No</th>
                                <th class="uppercase font-bold">Tanggal</th>
                                <th class="uppercase font-bold">Total Tindakan</th>
                                <th class="uppercase font-bold">Total Pemasukan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pemasukanHarian as $i => $item)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="text-center font-semibold">
                                        {{ $pemasukanHarian->firstItem() + $i }}
                                    </td>
                                    <td class="text-center font-semibold">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}
                                    </td>
                                    <td class="text-center font-semibold text-blue-400">
                                        {{ $item->total_tindakan }} Tindakan
                                    </td>
                                    <td class="text-center font-bold text-green-400">
                                        Rp {{ number_format($item->total_pemasukan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center py-6 text-gray-400" colspan="4">
                                        Tidak ada catatan pemasukan untuk rentang tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4 flex justify-center w-full">
                    {{ $pemasukanHarian->links('vendor.pagination') }}
                </div>
            </div>
        </div>
    </div>
</x-dashboard.main>
