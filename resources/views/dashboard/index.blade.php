<x-dashboard.main title="Dashboard">
    <div class="p-4 lg:p-6">
        <!-- Dashboard Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-base-content">Selamat Datang di <span style="color:#eb873b">SDC DENTAL
                    CLINIC</span></h1>
        </div>

        @php
            $stats = [
                [
                    'title' => 'Total Pasien',
                    'value' => $pendaftar->count() ?? '0',
                    'color' => 'green',
                    'bg_color' => 'from-green-100 to-green-200',
                ],
                [
                    'title' => 'Total Tindakan',
                    'value' => $tindakan->count() ?? '0',
                    'color' => 'blue',
                    'bg_color' => 'from-blue-100 to-blue-200',
                ],
                [
                    'title' => 'Pemasukan Bulan Ini',
                    'value' => isset($pemasukan) ? 'Rp' . number_format($pemasukan, 0, ',', '.') : 'Rp0',
                    'color' => 'yellow',
                    'bg_color' => 'from-yellow-100 to-yellow-200',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach ($stats as $stat)
                <div class="card shadow-lg bg-gradient-to-br {{ $stat['bg_color'] }} border border-{{ $stat['color'] }}-300 cursor-pointer"
                    @if ($stat['title'] === 'Total Pasien') onclick="window.location.href='{{ route('pasien') }}'"
            @elseif($stat['title'] === 'Pemasukan Bulan Ini')
                onclick="document.getElementById('calendar_modal').showModal()" @endif>
                    <div class="card-body">
                        <h2 class="card-title">{{ $stat['title'] }}</h2>
                        <p class="text-4xl font-extrabold text-{{ $stat['color'] }}-600"
                            id="{{ $stat['title'] === 'Pemasukan Bulan Ini' ? 'pemasukan_value' : '' }}">
                            {{ $stat['value'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <dialog id="calendar_modal" class="modal modal-bottom sm:modal-middle">
            <div class="modal-box bg-neutral text-white">
                <h3 class="text-lg font-bold text-center">Pilih Tanggal atau Bulan</h3>
                <div class="mt-3 flex justify-center items-center">
                    <!-- Kalender -->
                    <div id="calendar_container" class="flex justify-center"></div>
                </div>

                <p class="text-center mt-4 font-semibold">
                    <span id="selected_date" class="text-yellow-400">Tidak ada tanggal yang dipilih</span>
                </p>

                <div class="modal-action">
                    <button type="button" onclick="document.getElementById('calendar_modal').close()"
                        class="btn">Tutup</button>
                </div>
            </div>
        </dialog>

        <!-- Grafik dan Informasi -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Grafik Statistik -->
            <div class="card shadow-lg bg-[#eae3cd] border border-[#aa8f55]/30 text-[#333333]">
                <div class="card-body p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-[#aa8f55] flex items-center gap-2">
                                <x-lucide-trending-up class="w-5 h-5 stroke-[2.5]" />
                                <span>Aktivitas Pasien & Tindakan</span>
                            </h2>
                            <p class="text-xs opacity-75 mt-0.5 font-[onest]">Statistik pendaftaran pasien baru & tindakan medis (7 hari terakhir)</p>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-[onest]">
                            <span class="flex items-center gap-1.5 font-semibold">
                                <span class="w-3 h-3 rounded-full bg-[#aa8f55]"></span>
                                <span>Pasien Baru</span>
                            </span>
                            <span class="flex items-center gap-1.5 font-semibold">
                                <span class="w-3 h-3 rounded-full bg-[#14b8a6]"></span>
                                <span>Tindakan</span>
                            </span>
                        </div>
                    </div>
                    <div class="relative w-full bg-white/40 backdrop-blur rounded-xl p-3 border border-[#aa8f55]/10 h-72">
                        <canvas id="chart-kunjungan" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg bg-base-100 border border-base-300">
                <div class="card-body">
                    <h2 class="card-title">Aktivitas Terbaru</h2>
                    <ul class="menu menu-compact">
                        @forelse ($recentActivities as $activity)
                            <li>
                                <a class="flex justify-between hover:bg-base-200 font-[onest]">
                                    <span class="flex-1">{{ $activity['type'] }}: {{ $activity['message'] }}</span>
                                    <span class="badge badge-info ml-2">
                                        {{ \Carbon\Carbon::parse($activity['time'])->locale('id')->diffForHumans() }}
                                    </span>
                                </a>
                            </li>
                        @empty
                            <li><a class="hover:bg-base-200">Tidak ada aktivitas terbaru</a></li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="card shadow-lg bg-base-100 border border-base-300">
            <div class="card-body">
                <h2 class="card-title">Pasien Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            @foreach (['No', 'Nomor Rekam Medis', 'Nama', 'Umur', 'Jenis Kelamin', 'alamat', 'nomor hp', 'created at'] as $header)
                                <th class="font-bold text-center uppercase">{{ $header }}</th>
                            @endforeach
                        </thead>
                        <tbody>
                            @forelse ($pendaftar->slice(0, 5) as $i => $item)
                                <tr>
                                    <th class="text-center">{{ $i + 1 }}</th>
                                    <td class="font-semibold text-center capitalize">{{ $item->nomor_rekam_medis }}
                                    </td>
                                    <td class="font-semibold text-center capitalize">{{ $item->nama }}</td>
                                    <td class="font-semibold text-center capitalize">{{ $item->umur }}</td>
                                    <td class="font-semibold text-center capitalize">{{ $item->jenis_kelamin }}</td>
                                    <td class="font-semibold text-center capitalize">{{ $item->alamat }}</td>
                                    <td class="font-semibold text-center capitalize">{{ $item->no_hp }}</td>
                                    <td class="font-semibold text-center capitalize">{{ $item->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="font-semibold text-center capitalize" colspan="8">Tidak ada Data
                                        Pendaftar</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const labels = @json($chartLabels);
        const pendaftaranData = @json($chartPendaftaran);
        const tindakanData = @json($chartTindakan);

        const ctx = document.getElementById('chart-kunjungan').getContext('2d');
        
        // Create custom gradients for a highly premium look!
        const gradientPendaftaran = ctx.createLinearGradient(0, 0, 0, 300);
        gradientPendaftaran.addColorStop(0, 'rgba(170, 143, 85, 0.4)');
        gradientPendaftaran.addColorStop(1, 'rgba(170, 143, 85, 0.0)');

        const gradientTindakan = ctx.createLinearGradient(0, 0, 0, 300);
        gradientTindakan.addColorStop(0, 'rgba(20, 184, 166, 0.4)');
        gradientTindakan.addColorStop(1, 'rgba(20, 184, 166, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Pasien Baru',
                        data: pendaftaranData,
                        borderColor: '#aa8f55',
                        backgroundColor: gradientPendaftaran,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#aa8f55',
                        pointHoverRadius: 7,
                        pointRadius: 4,
                    },
                    {
                        label: 'Tindakan',
                        data: tindakanData,
                        borderColor: '#14b8a6',
                        backgroundColor: gradientTindakan,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#14b8a6',
                        pointHoverRadius: 7,
                        pointRadius: 4,
                    }
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false, // We use our custom legend in HTML!
                    },
                    tooltip: {
                        backgroundColor: '#eae3cd',
                        titleColor: '#aa8f55',
                        bodyColor: '#333333',
                        borderColor: '#aa8f55',
                        borderWidth: 1,
                        padding: 10,
                        cornerRadius: 8,
                        titleFont: {
                            family: 'Quicksand',
                            weight: 'bold'
                        },
                        bodyFont: {
                            family: 'Quicksand'
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#555555',
                            font: {
                                family: 'Quicksand',
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(170, 143, 85, 0.1)'
                        },
                        ticks: {
                            color: '#555555',
                            stepSize: 1,
                            font: {
                                family: 'Quicksand',
                                weight: 'bold'
                            }
                        }
                    },
                },
            },
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const calendarContainer = document.getElementById('calendar_container');
            const selectedDateText = document.getElementById('selected_date');

            flatpickr(calendarContainer, {
                inline: true,
                dateFormat: "Y-m-d",
                locale: 'id', // Bahasa Indonesia untuk bulan/hari
                onChange: function(selectedDates, dateStr) {
                    selectedDateText.textContent = `Tanggal yang dipilih: ${dateStr}`;
                    fetchPemasukan(dateStr);
                }
            });
        });

        function fetchPemasukan(date) {
            const selectedDateText = document.getElementById('selected_date');
            const pemasukanValueElement = document.getElementById('pemasukan_value');

            selectedDateText.textContent = `Sedang memuat pemasukan...`;

            fetch(`{{ url('/pemasukan/filter') }}?filter_date=${date}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    selectedDateText.textContent = `Tanggal: ${date} - Pemasukan: Rp ${data.pemasukan}`;
                    // Update nilai pemasukan pada statistik
                    pemasukanValueElement.textContent = `Rp ${data.pemasukan}`;
                })
                .catch(error => {
                    selectedDateText.textContent = `Gagal memuat pemasukan. Coba lagi.`;
                    console.error('Fetch error:', error);
                });
        }
    </script>

</x-dashboard.main>
