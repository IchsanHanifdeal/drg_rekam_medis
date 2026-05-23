<x-dashboard.main title="Tindakan">
    <div class="flex flex-col lg:flex-row gap-5">
        <div class="bg-neutral flex flex-col border-back rounded-xl w-full p-5 sm:p-7">
            <h1 class="text-white font-semibold flex items-start gap-3 font-[onest] sm:text-lg capitalize">
                Tambah Tindakan
            </h1>
            <p class="text-sm opacity-60 text-white">
                Fitur Tambah tindakan memungkinkan pengguna untuk menambahkan data tindakan ke sistem.
            </p>
            <form method="POST" action="{{ route('store.tindakan') }}" enctype="multipart/form-data" class="mt-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
                    <div class="flex items-center gap-3">
                        <label for="pasien" class="text-md font-medium text-white dark:text-white w-32">Pasien</label>
                        <select id="pasien" name="pasien"
                            class="searchable-select bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1 @error('pasien') border-red-500 @enderror">
                            <option value="">Pilih Pasien</option>
                        </select>
                        @error('pasien')
                            <span class="text-red-500 text-md">{{ $message }}</span>
                        @enderror
                    </div>

                    @foreach (['tanggal', 'TD/BB'] as $type)
                        <div class="flex items-center gap-3">
                            <label for="{{ $type }}"
                                class="text-md font-medium text-white dark:text-white w-32">
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </label>
                            @if ($type == 'tanggal')
                                <input type="date" id="{{ $type }}" name="{{ $type }}"
                                    class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1 @error($type) border-red-500 @enderror"
                                    value="{{ old($type, date('Y-m-d')) }}" />
                            @elseif ($type == 'TD/BB')
                                <div class="flex items-center gap-1 flex-1">
                                    <input type="number" id="td" name="td" placeholder="Masukan TD..."
                                        class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 w-full @error('td') border-red-500 @enderror"
                                        value="{{ old('td') }}" />
                                    <span class="text-white">/</span>
                                    <input type="number" id="bb" name="bb" placeholder="Masukan BB..."
                                        class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 w-full @error('bb') border-red-500 @enderror"
                                        value="{{ old('bb') }}" />
                                </div>
                            @endif
                            @error($type)
                                <span class="text-red-500 text-md">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach

                    <div class="flex items-center gap-3">
                        <label class="text-md font-medium text-white dark:text-white w-32">Odontogram</label>
                        <div class="flex flex-1 gap-2 flex-col sm:flex-row items-stretch sm:items-center">
                            <div class="flex gap-2 flex-1">
                                <input type="text" id="display_tooth" class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg p-2.5 w-1/2 sm:w-1/3 placeholder-gray-600" placeholder="Pilih Gigi di Peta..." readonly />
                                <input type="text" id="display_surface" class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg p-2.5 w-1/2 sm:w-1/3 placeholder-gray-600" placeholder="Permukaan..." readonly />
                            </div>
                            <select name="condition_code" id="condition_code" onchange="window.dispatchEvent(new CustomEvent('condition-code-changed', { detail: this.value }))" class="bg-gray-300 border border-red-300 text-gray-900 rounded-lg focus:ring-red-500 p-2.5 flex-1 font-semibold">
                                <option value="" selected>Kondisi Gigi (Opsional)</option>
                                <option value="karies">Karies</option>
                                <option value="restorasi">Restorasi</option>
                                <option value="cabut">Missing / Cabut</option>
                                <option value="lainnya">Sehat / Lainnya</option>
                            </select>
                        </div>
                        <input type="hidden" name="odontogram_selections" id="input_odontogram_selections" value="[]" />
                    </div>

                    <div class="flex items-center gap-3">
                        <label for="tindakan"
                            class="text-md font-medium text-white dark:text-white w-32">Tindakan</label>
                        <select id="tindakan" name="tindakan"
                            class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1 @error('tindakan') border-red-500 @enderror">
                            <option value="">Pilih Tindakan</option>
                            @foreach (\App\Models\OpsiTindakan::all() as $opsi)
                                <option value="{{ $opsi->id }}"
                                    {{ old('tindakan') == $opsi->id ? 'selected' : '' }}>
                                    {{ $opsi->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('tindakan')
                            <span class="text-red-500 text-md">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <label for="biaya" class="text-md font-medium text-white dark:text-white w-32">Biaya</label>
                        <input type="text" id="biaya" name="formatted_biaya"
                            class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1"
                            placeholder="Masukan Biaya..." value="{{ old('formatted_biaya') }}"
                            oninput="formatRupiah(this)" />
                        <input type="hidden" id="biaya_raw" name="biaya" value="{{ old('biaya') }}" />
                        @error('biaya')
                            <span class="text-red-500 text-md">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <script>
                    function formatRupiah(element) {
                        let value = element.value.replace(/[^,\d]/g, '');
                        let split = value.split(',');
                        let sisa = split[0].length % 3;
                        let rupiah = split[0].substr(0, sisa);
                        let ribuan = split[0].substr(sisa).match(/\d{3}/g);

                        if (ribuan) {
                            let separator = sisa ? '.' : '';
                            rupiah += separator + ribuan.join('.');
                        }

                        element.value = 'Rp' + (split[1] !== undefined ? rupiah + ',' + split[1] : rupiah);
                        document.getElementById('biaya_raw').value = value;
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        new TomSelect('#pasien', {
                            create: false,
                            sortField: {
                                field: 'text',
                                direction: 'asc'
                            },
                            placeholder: "Pilih Pasien",
                            searchField: 'text',
                            load: function(query, callback) {
                                // Load data only when search query is entered
                                if (query.length) {
                                    // Fetch data from server or use the predefined options in the select box
                                    const pasienData = @json(\App\Models\Pendaftaran::all());
                                    const filteredPasien = pasienData.filter(function(pasien) {
                                        return pasien.nama.toLowerCase().includes(query.toLowerCase());
                                    });

                                    // Callback to populate search results
                                    callback(filteredPasien.map(function(pasien) {
                                        return {
                                            value: pasien.id,
                                            text: pasien.nama
                                        };
                                    }));
                                } else {
                                    callback();
                                }
                            },
                            onSearchChange: function(query) {
                                if (query.length) {
                                    this.load(query);
                                }
                            },
                            onChange: function(value) {
                                if (value) {
                                    fetch(`/dashboard/tindakan/odontogram/${value}`)
                                        .then(res => res.json())
                                        .then(data => {
                                            window.dispatchEvent(new CustomEvent('odontogram-loaded', { detail: data }));
                                        })
                                        .catch(err => console.error("Error fetching odontogram data:", err));
                                } else {
                                    window.dispatchEvent(new CustomEvent('odontogram-loaded', { detail: {} }));
                                }
                            }
                        });
                    });
                </script>

                <div class="flex gap-3 justify-end mt-4">
                    <button type="reset" class="btn">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ODONTOGRAM SECTION -->
    <div class="flex flex-col gap-5 mt-5"
         x-data="{ 
            selections: [],
            toggleSelection(tooth, surface, surfaceName) {
                const index = this.selections.findIndex(s => s.tooth === tooth && s.surface === surface);
                if (index > -1) {
                    this.selections.splice(index, 1);
                } else {
                    this.selections.push({ tooth, surface, surfaceName });
                }
                
                // Update inputs
                document.getElementById('input_odontogram_selections').value = JSON.stringify(this.selections);
                
                const toothDisplay = Array.from(new Set(this.selections.map(s => s.tooth))).join(', ');
                const surfaceDisplay = this.selections.map(s => s.surfaceName + '('+s.surface+')').join(', ');
                
                document.getElementById('display_tooth').value = toothDisplay ? 'Gigi: ' + toothDisplay : '';
                document.getElementById('display_surface').value = surfaceDisplay ? surfaceDisplay : '';
                
                // Broadcast that selection changed to visually highlight the UI
                window.dispatchEvent(new CustomEvent('tooth-selection-changed', { detail: this.selections }));
            }
         }"
         @tooth-surface-clicked.window="toggleSelection($event.detail.tooth, $event.detail.surface, $event.detail.surfaceName)"
    >
        <div class="flex flex-col border-back rounded-xl w-full bg-neutral">
            <div class="p-5 sm:p-7 bg-neutral rounded-t-xl">
                <h1 class="flex items-start gap-3 font-semibold font-[onest] text-lg capitalize text-white">
                    Peta Gigi (Odontogram)
                </h1>
                <p class="text-sm opacity-60 text-white mt-1">
                    Pilih permukaan gigi untuk mencatat tindakan medis spesifik pada Odontogram.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-6 p-4 bg-white/5 rounded-xl text-white">
                    <div class="text-xs">
                        <span class="font-bold">Urutan Penomoran:</span> FDI World Dental Federation System
                    </div>
                    <div class="flex flex-wrap gap-4 text-xs">
                        <div class="flex items-center gap-1.5"><div class="w-3 h-3 bg-error rounded border border-white/20"></div> Karies</div>
                        <div class="flex items-center gap-1.5"><div class="w-3 h-3 bg-warning rounded border border-white/20"></div> Restorasi</div>
                        <div class="flex items-center gap-1.5"><div class="w-3 h-3 bg-info rounded border border-white/20"></div> Cabut</div>
                        <div class="flex items-center gap-1.5"><div class="w-3 h-3 bg-gray-500 rounded border border-white/20"></div> Sehat / Lainnya</div>
                    </div>
                </div>
            </div>
            
            <div class="p-5 sm:p-7 flex justify-center pb-12 overflow-x-auto w-full bg-neutral rounded-b-xl">
                <div class="flex flex-col items-center min-w-[700px] mx-auto relative px-4 text-white">
                    
                    <div class="flex flex-col gap-8 w-full border-b border-white/10 pb-12 relative pt-4">
                        <div class="absolute bottom-[-14px] left-1/2 transform -translate-x-1/2 bg-neutral px-4 text-xs font-bold tracking-widest text-white uppercase rounded-full shadow-sm border border-white/10 z-20">Atas • Bawah</div>
                        <div class="absolute left-1/2 top-0 bottom-0 w-px bg-white/10 transform -translate-x-1/2 z-0"></div>

                        <div class="flex justify-center gap-6 sm:gap-8 w-full relative z-10">
                            <div class="flex flex-1 justify-end gap-1.5 sm:gap-2">
                                @foreach (range(18, 11) as $toothNumber)
                                    <div class="w-max shrink-0"><x-odontogram-tooth :number="$toothNumber" /></div>
                                @endforeach
                            </div>
                            <div class="flex flex-1 justify-start gap-1.5 sm:gap-2">
                                @foreach (range(21, 28) as $toothNumber)
                                    <div class="w-max shrink-0"><x-odontogram-tooth :number="$toothNumber" /></div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="flex justify-center gap-6 sm:gap-8 w-full relative z-10">
                            <div class="flex flex-1 justify-end gap-1.5 sm:gap-2">
                                @foreach (range(55, 51) as $toothNumber)
                                    <div class="w-max shrink-0"><x-odontogram-tooth :number="$toothNumber" :is-deciduous="true" /></div>
                                @endforeach
                            </div>
                            <div class="flex flex-1 justify-start gap-1.5 sm:gap-2">
                                @foreach (range(61, 65) as $toothNumber)
                                    <div class="w-max shrink-0"><x-odontogram-tooth :number="$toothNumber" :is-deciduous="true" /></div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-8 w-full pt-12 relative pb-4">
                        <div class="absolute left-1/2 top-0 bottom-0 w-px bg-white/10 transform -translate-x-1/2 z-0"></div>

                        <div class="flex justify-center gap-6 sm:gap-8 w-full relative z-10">
                            <div class="flex flex-1 justify-end gap-1.5 sm:gap-2">
                                @foreach (range(85, 81) as $toothNumber)
                                    <div class="w-max shrink-0"><x-odontogram-tooth :number="$toothNumber" :is-deciduous="true" /></div>
                                @endforeach
                            </div>
                            <div class="flex flex-1 justify-start gap-1.5 sm:gap-2">
                                @foreach (range(71, 75) as $toothNumber)
                                    <div class="w-max shrink-0"><x-odontogram-tooth :number="$toothNumber" :is-deciduous="true" /></div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-center gap-6 sm:gap-8 w-full relative z-10">
                            <div class="flex flex-1 justify-end gap-1.5 sm:gap-2">
                                @foreach (range(48, 41) as $toothNumber)
                                    <div class="w-max shrink-0"><x-odontogram-tooth :number="$toothNumber" /></div>
                                @endforeach
                            </div>
                            <div class="flex flex-1 justify-start gap-1.5 sm:gap-2">
                                @foreach (range(31, 38) as $toothNumber)
                                    <div class="w-max shrink-0"><x-odontogram-tooth :number="$toothNumber" /></div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="flex gap-5">
        @foreach (['data_tindakan'] as $item)
            <div class="flex flex-col border-back bg-neutral rounded-xl w-full">
                <div class="p-5 sm:p-7 bg-neutral rounded-t-xl">
                    <h1 class="flex items-start gap-3 font-semibold font-[onest] text-lg capitalize text-white">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <p class="text-sm opacity-60 text-white">
                        Jelajahi dan ketahui Tindakan.
                    </p>
                </div>
                <form action="{{ route('tindakan') }}" method="GET" class="w-full">
                    <div class="w-full px-5 sm:px-7 bg-neutral my-4">
                        <input type="text" id="searchInput" placeholder="Cari data disini...." name="nama"
                            value="{{ request('nama') }}"
                            class="input input-sm shadow-md w-full bg-neutral text-white">
                    </div>
                </form>

                <div class="flex flex-col rounded-b-xl gap-3 divide-y pt-0 p-5 sm:p-7">
                    <div class="overflow-x-auto">
                        <table class="table w-full text-white" id="dataTable">
                            <thead class="text-sm">
                                <tr class="text-white">
                                    @foreach (['No', 'Nomor Rekam Medis', 'Nama', 'hari/tanggal', 'TD/BB', 'Gigi/Bagian', 'Pemeriksaan, Tindakan, dan Pengobatan', 'biaya', 'Aksi'] as $header)
                                        <th class="uppercase font-bold text-center">{{ $header }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tindakan as $i => $item)
                                    <tr>
                                        <th class="font-semibold capitalize text-center">
                                            {{ $tindakan->firstItem() + $i }}</th>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->pendaftarans->nomor_rekam_medis }}</td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->pendaftarans->nama }}</td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd/DD-MM-YYYY') : '-' }}
                                        </td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ ($item->tensi_darah ?? '-') . '/' . ($item->berat_badan ? $item->berat_badan . 'kg' : '-') }}
                                        </td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->tooth_number ? 'Gigi ' . $item->tooth_number : '-' }}
                                        </td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->opsi->nama }}
                                        </td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->biaya ? 'Rp' . number_format($item->biaya, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="flex items-center gap-4">
                                            <x-lucide-pencil class="size-5 hover:stroke-yellow-500 cursor-pointer"
                                                onclick="document.getElementById('update_modal_{{ $item->id }}').showModal();" />
                                            <dialog id="update_modal_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <div class="modal-box bg-neutral text-white">
                                                    <h3 class="text-lg font-bold">Update Tindakan</h3>
                                                    <div class="mt-3">
                                                        <form method="POST"
                                                            action="{{ route('update.tindakan', $item->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
                                                                <div class="flex items-center gap-3">
                                                                    <label for="pasien_{{ $item->id }}"
                                                                        class="text-md font-medium text-white dark:text-white w-32">Pasien</label>
                                                                    <select id="pasien_{{ $item->id }}"
                                                                        name="pasien"
                                                                        class="searchable-select bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1 @error('pasien') border-red-500 @enderror">
                                                                        <option value="">Pilih Pasien</option>
                                                                        @foreach (\App\Models\Pendaftaran::all() as $pasien)
                                                                            <option value="{{ $pasien->id }}"
                                                                                {{ old('pasien', $item->pendaftaran) == $pasien->id ? 'selected' : '' }}>
                                                                                {{ $pasien->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('pasien')
                                                                        <span
                                                                            class="text-red-500 text-md">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                @foreach (['tanggal', 'TD/BB'] as $type)
                                                                    <div class="flex items-center gap-3">
                                                                        <label
                                                                            for="{{ $type }}_{{ $item->id }}"
                                                                            class="text-md font-medium text-white dark:text-white w-32">
                                                                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                                                                        </label>
                                                                        @if ($type == 'tanggal')
                                                                            <input type="date"
                                                                                id="{{ $type }}_{{ $item->id }}"
                                                                                name="{{ $type }}"
                                                                                class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1 @error($type) border-red-500 @enderror"
                                                                                value="{{ old($type, $item->tanggal) }}" />
                                                                        @elseif ($type == 'TD/BB')
                                                                            <div
                                                                                class="flex items-center gap-1 flex-1">
                                                                                <input type="number"
                                                                                    id="td_{{ $item->id }}"
                                                                                    name="td"
                                                                                    placeholder="Masukan TD..."
                                                                                    class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 w-full @error('td') border-red-500 @enderror"
                                                                                    value="{{ old('td', $item->tensi_darah) }}" />
                                                                                <span class="text-white">/</span>
                                                                                <input type="number"
                                                                                    id="bb_{{ $item->id }}"
                                                                                    name="bb"
                                                                                    placeholder="Masukan BB..."
                                                                                    class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 w-full @error('bb') border-red-500 @enderror"
                                                                                    value="{{ old('bb', $item->berat_badan) }}" />
                                                                            </div>
                                                                        @endif
                                                                        @error($type)
                                                                            <span
                                                                                class="text-red-500 text-md">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                @endforeach

                                                                <div class="flex items-center gap-3">
                                                                    <label for="tindakan_{{ $item->id }}"
                                                                        class="text-md font-medium text-white dark:text-white w-32">Tindakan</label>
                                                                    <select id="tindakan_{{ $item->id }}"
                                                                        name="tindakan"
                                                                        class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1 @error('tindakan') border-red-500 @enderror">
                                                                        <option value="">Pilih Tindakan</option>
                                                                        @foreach (\App\Models\OpsiTindakan::all() as $opsi)
                                                                            <option value="{{ $opsi->id }}"
                                                                                {{ old('tindakan', $item->opsi_tindakan) == $opsi->id ? 'selected' : '' }}>
                                                                                {{ $opsi->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('tindakan')
                                                                        <span
                                                                            class="text-red-500 text-md">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="flex items-center gap-3">
                                                                    <label for="biaya_{{ $item->id }}"
                                                                        class="text-md font-medium text-white dark:text-white w-32">Biaya</label>
                                                                    <input type="text"
                                                                        id="biaya_{{ $item->id }}"
                                                                        name="formatted_biaya"
                                                                        class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1"
                                                                        placeholder="Masukan Biaya..."
                                                                        value="{{ old('formatted_biaya', $item->biaya) }}"
                                                                        oninput="formatRupiah(this)" />
                                                                    <input type="hidden"
                                                                        id="biaya_raw_{{ $item->id }}"
                                                                        name="biaya"
                                                                        value="{{ old('biaya', $item->biaya) }}" />
                                                                    @error('biaya')
                                                                        <span
                                                                            class="text-red-500 text-md">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="modal-action">
                                                                <button type="button"
                                                                    onclick="document.getElementById('update_modal_{{ $item->id }}').close()"
                                                                    class="btn">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </dialog>

                                            <x-lucide-trash class="size-5 hover:stroke-red-500 cursor-pointer"
                                                onclick="document.getElementById('hapus_{{ $item->id }}').showModal();" />
                                            <dialog id="hapus_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <div class="modal-box bg-neutral">
                                                    <h3 class="text-lg text-white font-bold capitalize">Hapus
                                                        tindakan
                                                    </h3>
                                                    <div class="mt-3">
                                                        <p class="text-red-800 font-semibold">Perhatian! Anda
                                                            sedang
                                                            mencoba untuk menghapus data tindakan
                                                            <span class="text-white">Tindakan ini akan menghapus
                                                                semua data terkait. Apakah Anda yakin ingin
                                                                melanjutkan?</span>
                                                        </p>
                                                    </div>
                                                    <div class="modal-action">
                                                        <button type="button"
                                                            onclick="document.getElementById('hapus_{{ $item->id }}').close()"
                                                            class="btn">Batal</button>
                                                        <form action="{{ route('delete.tindakan', $item->id) }}"
                                                            method="POST" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-error">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </dialog>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="font-semibold capitalize text-center" colspan="7">
                                            Tidak ada tindakan terdaftar</td>
                                    </tr>
                                @endforelse
                        </table>
                        <div class="mt-4">
                            {{ $tindakan->links('vendor.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const dataTable = document.getElementById('dataTable');
        const tableRows = dataTable.querySelectorAll('tbody tr');
        const noDataRow = document.createElement('tr');
        const noDataCell = document.createElement('td');

        noDataCell.colSpan = tableRows[0].cells.length;
        noDataCell.textContent = 'Data tidak ditemukan';
        noDataRow.appendChild(noDataCell);

        searchInput.addEventListener('keyup', function() {
            const query = searchInput.value.toLowerCase();
            let rowVisible = false;

            tableRows.forEach(row => {
                let rowMatch = false;

                for (let i = 0; i < row.cells.length; i++) {
                    const cellText = row.cells[i].textContent.toLowerCase();

                    if (cellText.includes(query)) {
                        rowMatch = true;
                        break;
                    }
                }

                if (rowMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
                rowVisible = rowVisible || rowMatch;
            });

            if (!rowVisible && !dataTable.querySelector('tbody tr[data-no-data]')) {
                noDataRow.setAttribute('data-no-data', 'true');
                dataTable.querySelector('tbody').appendChild(noDataRow);
            } else if (rowVisible && dataTable.querySelector('tbody tr[data-no-data]')) {
                dataTable.querySelector('tbody tr[data-no-data]').remove();
            }
        });
    </script>

</x-dashboard.main>
