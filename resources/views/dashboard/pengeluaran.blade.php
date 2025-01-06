<x-dashboard.main title="Pengeluaran">
    <div class="flex flex-col lg:flex-row gap-5">
        <div class="bg-neutral flex flex-col border-back rounded-xl w-full p-5 sm:p-7">
            <h1 class="text-white font-semibold flex items-start gap-3 font-[onest] sm:text-lg capitalize">
                Tambah Pengeluaran
            </h1>
            <p class="text-sm opacity-60 text-white">
                Fitur Tambah pengeluaran memungkinkan pengguna untuk menambahkan data pengeluaran ke sistem.
            </p>
            <form method="POST" action="{{ route('store.pengeluaran') }}" enctype="multipart/form-data" class="mt-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
                    @foreach (['keterangan', 'tanggal', 'jumlah'] as $type)
                        <div class="flex items-center gap-3">
                            <label for="{{ $type }}"
                                class="text-md font-medium text-white dark:text-white w-32">
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </label>
                            @if ($type == 'tanggal')
                                <input type="date" id="{{ $type }}" name="{{ $type }}"
                                    class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1 @error($type) border-red-500 @enderror"
                                    value="{{ old($type, date('Y-m-d')) }}" />
                            @elseif ($type == 'jumlah')
                                <div class="w-full flex-1">
                                    <input type="text" id="{{ $type }}" name="{{ $type }}"
                                        class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 w-full"
                                        placeholder="Masukan {{ $type }}..." value=""
                                        oninput="formatRupiah(this)" />
                                    <!-- Input tersembunyi untuk nilai mentah -->
                                    <input type="hidden" id="jumlah_raw" name="jumlah_raw" value="">
                                </div>
                            @elseif ($type == 'keterangan')
                                <input type="text" id="{{ $type }}" name="nama"
                                    class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1"
                                    placeholder="Masukan {{ $type }}..." value="" />
                            @else
                                <input type="text" id="{{ $type }}" name="{{ $type }}"
                                    class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1"
                                    placeholder="Masukan {{ $type }}..." value="" />
                            @endif
                            @error($type)
                                <span class="text-red-500 text-md">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <script>
                    function formatRupiah(element) {
                        let value = element.value.replace(/[^,\d]/g, ''); // Hapus karakter non-numerik
                        let split = value.split(',');
                        let sisa = split[0].length % 3;
                        let rupiah = split[0].substr(0, sisa);
                        let ribuan = split[0].substr(sisa).match(/\d{3}/g);

                        if (ribuan) {
                            let separator = sisa ? '.' : '';
                            rupiah += separator + ribuan.join('.');
                        }

                        element.value = 'Rp' + (split[1] !== undefined ? rupiah + ',' + split[1] : rupiah);

                        // Update input tersembunyi dengan nilai mentah
                        document.getElementById('jumlah_raw').value = value;
                    }
                </script>

                <div class="flex gap-3 justify-end mt-4">
                    <button type="reset" class="btn">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="flex gap-5">
        @foreach (['data_pengeluaran'] as $item)
            <div class="flex flex-col border-back bg-neutral rounded-xl w-full">
                <div class="p-5 sm:p-7 bg-neutral rounded-t-xl">
                    <h1 class="flex items-start gap-3 font-semibold font-[onest] text-lg capitalize text-white">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <p class="text-sm opacity-60 text-white">
                        Jelajahi dan ketahui Pengeluaran.
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
                                    @foreach (['No', 'Nama Pengeluaran', 'Hari/Tanggal', 'Jumlah', ''] as $header)
                                        <th class="uppercase font-bold text-center">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengeluaran as $i => $item)
                                    <tr>
                                        <th class="font-semibold capitalize text-center">
                                            {{ $loop->iteration + ($pengeluaran->currentPage() - 1) * $pengeluaran->perPage() }}
                                        </th>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->nama }}</td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->tanggal? \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd/DD-MM-YYYY'): '-' }}
                                        </td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->jumlah ? 'Rp' . number_format($item->jumlah, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="flex items-center gap-4">
                                            <x-lucide-pencil class="size-5 hover:stroke-yellow-500 cursor-pointer"
                                                onclick="document.getElementById('update_modal_{{ $item->id }}').showModal();" />
                                            <dialog id="update_modal_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <div class="modal-box bg-neutral text-white">
                                                    <h3 class="text-lg font-bold">Update Pengeluaran</h3>
                                                    <div class="mt-3">
                                                        <form method="POST"
                                                            action="{{ route('update.pengeluaran', $item->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
                                                                @foreach (['nama', 'tanggal', 'jumlah'] as $type)
                                                                    <div class="flex items-center gap-3">
                                                                        <label for="{{ $type }}"
                                                                            class="text-md font-medium text-white dark:text-white w-32">
                                                                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                                                                        </label>
                                                                        @if ($type == 'tanggal')
                                                                            <input type="date"
                                                                                id="{{ $type }}"
                                                                                name="{{ $type }}"
                                                                                class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1 @error($type) border-red-500 @enderror"
                                                                                value="{{ old($type, $item->$type) }}" />
                                                                        @elseif ($type == 'jumlah')
                                                                            <div class="w-full flex-1">
                                                                                <input type="text"
                                                                                    id="{{ $type }}"
                                                                                    name="{{ $type }}"
                                                                                    class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 w-full"
                                                                                    placeholder="Masukan {{ $type }}..."
                                                                                    value="{{ old($type, number_format($item->$type, 0, ',', '.')) }}"
                                                                                    oninput="formatRupiah(this)"
                                                                                    disabled />
                                                                                <input type="hidden"
                                                                                    id="jumlah_raw_edit"
                                                                                    name="jumlah_raw_edit"
                                                                                    value="{{ old('jumlah_raw', $item->jumlah) }}">
                                                                            </div>
                                                                        @elseif ($type == 'keterangan')
                                                                            <input type="text"
                                                                                id="{{ $type }}"
                                                                                name="{{ $type }}"
                                                                                class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1"
                                                                                placeholder="Masukan {{ $type }}..."
                                                                                value="{{ old($type, $item->nama) }}" />
                                                                        @else
                                                                            <input type="text"
                                                                                id="{{ $type }}"
                                                                                name="{{ $type }}"
                                                                                class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1"
                                                                                placeholder="Masukan {{ $type }}..."
                                                                                value="{{ old($type, $item->$type) }}" />
                                                                        @endif
                                                                        @error($type)
                                                                            <span
                                                                                class="text-red-500 text-md">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            {{-- <script>
                                                                function formatRupiah(element) {
                                                                    let value = element.value.replace(/[^,\d]/g, ''); // Hapus karakter non-numerik
                                                                    let split = value.split(',');
                                                                    let sisa = split[0].length % 3;
                                                                    let rupiah = split[0].substr(0, sisa);
                                                                    let ribuan = split[0].substr(sisa).match(/\d{3}/g);

                                                                    if (ribuan) {
                                                                        let separator = sisa ? '.' : '';
                                                                        rupiah += separator + ribuan.join('.');
                                                                    }

                                                                    element.value = 'Rp' + (split[1] !== undefined ? rupiah + ',' + split[1] : rupiah);

                                                                    document.getElementById('jumlah_raw_edit').value = value.replace(/[^\d]/g, '');
                                                                }
                                                            </script> --}}

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
                                                        pengeluaran {{ $item->nama }}
                                                    </h3>
                                                    <div class="mt-3">
                                                        <p class="text-red-800 font-semibold">Perhatian! Anda
                                                            sedang
                                                            mencoba untuk menghapus data pengeluaran
                                                            <strong
                                                                class="text-red-800 font-bold capitalize">{{ $item->nama }}</strong>.
                                                            <span class="text-white">Tindakan ini akan menghapus
                                                                semua data terkait. Apakah Anda yakin ingin
                                                                melanjutkan?</span>
                                                        </p>
                                                    </div>
                                                    <div class="modal-action">
                                                        <button type="button"
                                                            onclick="document.getElementById('hapus_{{ $item->id }}').close()"
                                                            class="btn">Batal</button>
                                                        <form action="{{ route('delete.pengeluaran', $item->id) }}"
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
                                        <th class="font-semibold capitalize text-center" colspan="5">Tidak ada data
                                            pengeluaran</th>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-center font-bold text-sm text-white">Total
                                        Pengeluaran:</td>
                                    <td class="font-bold text-center text-sm text-white">
                                        Rp{{ number_format($pengeluaran->sum('jumlah'), 0, ',', '.') }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $pengeluaran->links('pagination::tailwind') }}
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
