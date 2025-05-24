<x-dashboard.main title="Pendaftaran">
    <div class="flex flex-col lg:flex-row gap-5">
        <div class="bg-neutral flex flex-col border-back rounded-xl w-full p-5 sm:p-7">
            <h1 class="text-white font-semibold flex items-start gap-3 font-[onest] sm:text-lg capitalize">
                Tambah Pasien
            </h1>
            <p class="text-sm opacity-60 text-white">
                Fitur Tambah pasien memungkinkan pengguna untuk menambahkan data pasien ke sistem.
            </p>

            <div class="flex justify-end mb-4">
                <div class="bg-[#aa8f55] text-white font-semibold rounded-lg px-4 py-2">
                    No. Rekam Medis: <span id="registrationNumber">{{ $nomor_rekam_medis }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('store.pendaftaran') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
                        @foreach (['nama', 'umur', 'jenis_kelamin', 'alamat', 'no_hp'] as $type)
                            <div class="flex items-center gap-3">
                                <label for="{{ $type }}"
                                    class="text-md font-medium text-white dark:text-white w-32">
                                    {{ ucfirst(str_replace('_', ' ', $type)) }}
                                </label>

                                @if ($type == 'umur')
                                    <div class="flex-1 relative">
                                        <input type="date" id="{{ $type }}" name="{{ $type }}"
                                            class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-3 @error($type) border-red-500 @enderror"
                                            value="" onchange="calculateAge()" aria-label="Pilih umur" />

                                        <input type="text" id="ageInput" name="umur_tampil"
                                            class="hidden bg-gray-200 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-3 @error($type) border-red-500 @enderror"
                                            readonly value="{{ old('umur') }}" />

                                        <button type="button" id="editAgeButton"
                                            class="absolute right-3 top-3 text-white btn hidden"
                                            style="background-color:#aa8f55" onclick="enableDateInput()">Edit</button>
                                    </div>
                                @elseif ($type == 'jenis_kelamin')
                                    <select id="{{ $type }}" name="{{ $type }}"
                                        class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full flex-1 p-3 @error($type) border-red-500 @enderror"
                                        aria-label="Pilih jenis kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="laki-laki" {{ old($type) == 'laki-laki' ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>
                                        <option value="perempuan" {{ old($type) == 'perempuan' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                @else
                                    <input type="text" id="{{ $type }}" name="{{ $type }}"
                                        placeholder="Masukkan {{ str_replace('_', ' ', $type) }}..."
                                        class="bg-gray-200 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full flex-1 p-3 @error($type) border-red-500 @enderror capitalize"
                                        value="" aria-label="Masukkan {{ str_replace('_', ' ', $type) }}" />
                                @endif

                                @error($type)
                                    <span class="text-red-500 text-md">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-action">
                    <button type="submit" class="btn w-full text-white sm:w-auto" style="background-color: #aa8f55;">
                        Simpan
                    </button>
                </div>
            </form>

            <script>
                function calculateAge() {
                    const birthDate = new Date(document.getElementById('umur').value);
                    const currentDate = new Date();

                    if (!birthDate.getTime()) return;

                    let years = currentDate.getFullYear() - birthDate.getFullYear();
                    let months = currentDate.getMonth() - birthDate.getMonth();
                    let days = currentDate.getDate() - birthDate.getDate();

                    if (months < 0 || (months === 0 && days < 0)) {
                        years--;
                        months += 12;
                    }

                    if (days < 0) {
                        const lastMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 0);
                        days += lastMonth.getDate();
                    }

                    const ageInput = document.getElementById('ageInput');
                    ageInput.value = `${years} tahun, ${months} bulan, ${days} hari`;

                    document.getElementById('umur').classList.add('hidden');
                    ageInput.classList.remove('hidden');
                    document.getElementById('editAgeButton').classList.remove('hidden');
                }

                function enableDateInput() {
                    const ageInput = document.getElementById('ageInput');
                    const dateInput = document.getElementById('umur');

                    dateInput.classList.remove('hidden');
                    ageInput.classList.add('hidden');
                    document.getElementById('editAgeButton').classList.add('hidden');
                }

                if (document.getElementById('umur').value) {
                    calculateAge();
                }
            </script>
        </div>
    </div>


    <div class="flex gap-5">
        @foreach (['data_pasien'] as $item)
            <div class="flex flex-col border-back bg-neutral rounded-xl w-full">
                <div class="p-5 sm:p-7 bg-neutral rounded-t-xl">
                    <h1 class="flex items-start gap-3 font-semibold font-[onest] text-lg capitalize text-white">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <p class="text-sm opacity-60 text-white">
                        Jelajahi dan ketahui pasien.
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
                                    @foreach (['No', 'Nomor Rekam Medis', 'Nama', 'Umur', 'Jenis Kelamin', 'Alamat', 'No Handphone', ''] as $header)
                                        <th class="uppercase font-bold text-center">{{ $header }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendaftaran as $i => $item)
                                    <tr>
                                        <th class="font-semibold capitalize text-center">
                                            {{ $pendaftaran->firstItem() + $i }}</th>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->nomor_rekam_medis }}</td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->nama }}</td>
                                        <td class="font-semibold capitalize text-center">
                                            @php
                                                $umur = \Carbon\Carbon::parse($item->umur);
                                                $today = \Carbon\Carbon::today();
                                                $diff = $umur->diff($today);
                                            @endphp
                                            {{ $diff->y }} tahun, {{ $diff->m }} bulan, {{ $diff->d }}
                                            hari
                                        </td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->jenis_kelamin }}</td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->alamat }}</td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->no_hp }}</td>
                                        <td class="flex items-center gap-4">
                                            <x-lucide-pencil class="size-5 hover:stroke-yellow-500 cursor-pointer"
                                                onclick="document.getElementById('update_modal_{{ $item->id }}').showModal();" />
                                            <dialog id="update_modal_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <div class="modal-box bg-neutral text-white">
                                                    <h3 class="text-lg font-bold">Update Pendaftaran Pasien</h3>
                                                    <div class="mt-3">
                                                        <form method="POST"
                                                            action="{{ route('update.pendaftaran', $item->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            @foreach (['nama', 'jenis_kelamin', 'alamat', 'no_hp'] as $field)
                                                                <div class="mb-4">
                                                                    <label for="{{ $field }}"
                                                                        class="block mb-2 text-sm font-medium text-white">
                                                                        {{ ucfirst(str_replace('_', ' ', $field)) }}
                                                                    </label>

                                                                    @if ($field === 'jenis_kelamin')
                                                                        <!-- Dropdown untuk jenis kelamin -->
                                                                        <select id="{{ $field }}"
                                                                            name="{{ $field }}"
                                                                            class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error($field) border-red-500 @enderror">
                                                                            <option value="">Pilih Jenis Kelamin
                                                                            </option>
                                                                            <option value="laki-laki"
                                                                                {{ old($field, $item->$field) === 'laki-laki' ? 'selected' : '' }}>
                                                                                Laki-laki
                                                                            </option>
                                                                            <option value="perempuan"
                                                                                {{ old($field, $item->$field) === 'perempuan' ? 'selected' : '' }}>
                                                                                Perempuan
                                                                            </option>
                                                                        </select>
                                                                    @else
                                                                        <input type="text" id="{{ $field }}"
                                                                            name="{{ $field }}"
                                                                            class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error($field) border-red-500 @enderror"
                                                                            value="{{ old($field, $item->$field) }}" />
                                                                    @endif

                                                                    @error($field)
                                                                        <span
                                                                            class="text-red-500 text-sm">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            @endforeach

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
                                                        Pasien {{ $item->nama }}
                                                    </h3>
                                                    <div class="mt-3">
                                                        <p class="text-red-800 font-semibold">Perhatian! Anda
                                                            sedang
                                                            mencoba untuk menghapus data pasien
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
                                                        <form action="{{ route('delete.pendaftaran', $item->id) }}"
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
                            </tbody>
                        </table>
                        <div class="mt-4 flex justify-center">
                            {{ $pendaftaran->links('vendor.pagination') }}
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
