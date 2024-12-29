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
                        <label for="pasien"
                            class="text-md font-medium text-gray-900 dark:text-white w-32">Pasien</label>
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
                                class="text-md font-medium text-gray-900 dark:text-white w-32">
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
                        <label for="tindakan"
                            class="text-md font-medium text-gray-900 dark:text-white w-32">Tindakan</label>
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
                        <label for="biaya"
                            class="text-md font-medium text-gray-900 dark:text-white w-32">Biaya</label>
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
                <div class="w-full px-5 sm:px-7 bg-neutral my-4">
                    <input type="text" id="searchInput" placeholder="Cari data disini...." name="nama"
                        value="{{ request('nama') }}" class="input input-sm shadow-md w-full bg-neutral text-white">
                </div>
                <div class="flex flex-col rounded-b-xl gap-3 divide-y pt-0 p-5 sm:p-7">
                    <div class="overflow-x-auto">
                        <table class="table w-full text-white" id="dataTable">
                            <thead class="text-sm">
                                <tr class="text-white">
                                    @foreach (['No', 'Nomor Rekam Medis', 'Nama', 'hari/tanggal', 'TD/BB', 'Pemeriksaan, Tindakan, dan Pengobatan', 'biaya'] as $header)
                                        <th class="uppercase font-bold text-center">{{ $header }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tindakan as $i => $item)
                                    <tr>
                                        <th class="font-semibold capitalize text-center">
                                            {{ $i + 1 }}</th>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->pendaftarans->nomor_rekam_medis }}</td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->pendaftarans->nama }}</td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->tanggal? \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd/DD-MM-YYYY'): '-' }}
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->tensi_darah . '/' . $item->berat_badan . 'kg' }}</td>
                                        </td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->opsi->nama }}</td>
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
                                                                        class="text-md font-medium text-gray-900 dark:text-white w-32">Pasien</label>
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
                                                                            class="text-md font-medium text-gray-900 dark:text-white w-32">
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
                                                                        class="text-md font-medium text-gray-900 dark:text-white w-32">Tindakan</label>
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
                                                                        class="text-md font-medium text-gray-900 dark:text-white w-32">Biaya</label>
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
