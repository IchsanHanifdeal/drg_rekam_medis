<x-dashboard.main title="Pasien">
    <div class="flex gap-5">
        @foreach (['data_pasien'] as $item)
            <div class="flex flex-col border border-gray-200 rounded-xl w-full bg-white">
                <div class="p-5 sm:p-7 rounded-t-xl bg-white border-b border-gray-100">
                    <h1 class="flex items-start gap-3 font-semibold font-[onest] text-lg capitalize text-black">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <p class="text-sm opacity-60 text-black">
                        Jelajahi dan ketahui pasien.
                    </p>
                </div>
                <form action="{{ route('pasien') }}" method="GET" class="w-full">
                    <div class="w-full px-5 sm:px-7 my-4 text-black">
                        <input type="text" id="searchInput" placeholder="Cari data disini...." name="nama"
                            value="{{ request('nama') }}" class="input input-sm border border-gray-300 w-full text-black bg-white focus:outline-none focus:ring-1 focus:ring-gray-400">
                    </div>
                </form>
                <div class="flex flex-col rounded-b-xl gap-3 divide-y pt-0 p-5 sm:p-7">
                    <div class="overflow-x-auto">
                        <table class="table w-full text-black" id="dataTable">
                            <thead class="text-sm">
                                <tr>
                                    @foreach (['No', 'No. RM', 'Nama', 'Umur', 'Gender', 'Alamat', 'No. HP', 'Aksi'] as $header)
                                        <th class="uppercase font-bold text-center border-b">{{ $header }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendaftaran as $i => $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <th class="font-semibold capitalize text-center">
                                            {{ $pendaftaran->firstItem() + $i }}</th>
                                        <td class="font-semibold text-center">
                                            {{ $item->nomor_rekam_medis }}</td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->nama }}</td>
                                        <td class="font-semibold text-center text-xs">
                                            @php
                                                $umur = \Carbon\Carbon::parse($item->umur);
                                                $today = \Carbon\Carbon::today();
                                                $diff = $umur->diff($today);
                                            @endphp
                                            {{ $diff->y }} thn, {{ $diff->m }} bln, {{ $diff->d }} hr
                                        </td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->jenis_kelamin }}</td>
                                        <td class="font-semibold text-center text-xs max-w-[150px] truncate">
                                            {{ $item->alamat }}</td>
                                        <td class="font-semibold text-center">
                                            {{ $item->no_hp }}</td>
                                        <td class="flex items-center gap-3 justify-center">
                                            <x-lucide-pencil class="size-5 stroke-yellow-500 hover:opacity-70 cursor-pointer"
                                                onclick="document.getElementById('update_modal_{{ $item->id }}').showModal();" />
                                            <dialog id="update_modal_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <div class="modal-box bg-white text-black border border-gray-200">
                                                    <h3 class="text-lg font-bold border-b pb-2 mb-4 text-left">Update Data Pasien</h3>
                                                    <div class="mt-3 text-left">
                                                        <form method="POST"
                                                            action="{{ route('update.pendaftaran', $item->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            @foreach (['nama', 'jenis_kelamin', 'alamat', 'no_hp'] as $field)
                                                                <div class="mb-4">
                                                                    <label for="edit_{{ $field }}_{{ $item->id }}"
                                                                        class="block mb-2 text-sm font-medium">
                                                                        {{ ucfirst(str_replace('_', ' ', $field)) }}
                                                                    </label>

                                                                    @if ($field === 'jenis_kelamin')
                                                                        <select id="edit_{{ $field }}_{{ $item->id }}"
                                                                            name="{{ $field }}"
                                                                            class="bg-gray-100 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 @error($field) border-red-500 @enderror">
                                                                            <option value="">Pilih Jenis Kelamin</option>
                                                                            <option value="laki-laki" {{ old($field, $item->$field) === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                                            <option value="perempuan" {{ old($field, $item->$field) === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                                        </select>
                                                                    @else
                                                                        <input type="text" id="edit_{{ $field }}_{{ $item->id }}"
                                                                            name="{{ $field }}"
                                                                            class="bg-gray-100 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 @error($field) border-red-500 @enderror"
                                                                            value="{{ old($field, $item->$field) }}" />
                                                                    @endif

                                                                    @error($field)
                                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            @endforeach

                                                            <div class="modal-action border-t pt-4">
                                                                <button type="button"
                                                                    onclick="document.getElementById('update_modal_{{ $item->id }}').close()"
                                                                    class="btn">Batal</button>
                                                                <button type="submit"
                                                                    class="btn text-white" style="background-color: {{ $web_config->theme_colors['accent'] }}">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </dialog>
                                            <x-lucide-trash class="size-5 stroke-red-500 hover:opacity-70 cursor-pointer"
                                                onclick="document.getElementById('hapus_{{ $item->id }}').showModal();" />
                                            <dialog id="hapus_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <div class="modal-box bg-white text-black border border-gray-200">
                                                    <h3 class="text-lg font-bold text-red-600 border-b pb-2 mb-4 text-left">Hapus Pasien</h3>
                                                    <div class="mt-3 text-left">
                                                        <p class="text-gray-800">
                                                            Apakah Anda yakin ingin menghapus data pasien 
                                                            <strong class="font-bold capitalize">{{ $item->nama }}</strong>?
                                                        </p>
                                                        <p class="text-xs text-gray-500 mt-2 italic">Tindakan ini akan menghapus semua riwayat tindakan terkait.</p>
                                                    </div>
                                                    <div class="modal-action border-t pt-4">
                                                        <button type="button"
                                                            onclick="document.getElementById('hapus_{{ $item->id }}').close()"
                                                            class="btn">Batal</button>
                                                        <form action="{{ route('delete.pendaftaran', $item->id) }}"
                                                            method="POST" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-error text-white">Ya, Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </dialog>
                                            <x-lucide-eye class="size-5 hover:opacity-70 cursor-pointer stroke-blue-500"
                                                onclick="document.getElementById('detail_modal_{{ $item->id }}').showModal();" />

                                            <dialog id="detail_modal_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <div class="modal-box w-screen max-w-screen-xl bg-white text-black"
                                                    style="max-width: 1400px">
                                                    <h3 class="font-bold text-xl border-b pb-3 text-left">Riwayat Tindakan Pasien</h3>
                                                    <p class="py-4 text-left">
                                                        Detail riwayat untuk: <strong>{{ $item->nama }}</strong> (RM: {{ $item->nomor_rekam_medis }})
                                                    </p>

                                                    <div class="overflow-x-auto">
                                                        <table class="table w-full text-black border">
                                                            <thead class="text-sm bg-gray-50">
                                                                <tr class="text-black">
                                                                    <th class="border">Tanggal</th>
                                                                    <th class="border">Tensi Darah</th>
                                                                    <th class="border">Berat Badan</th>
                                                                    <th class="border">Biaya</th>
                                                                    <th class="border">Opsi Tindakan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($tindakan->where('pendaftaran', $item->id) as $data)
                                                                    <tr class="hover:bg-gray-50">
                                                                        <td class="font-semibold text-center border">
                                                                            {{ $data->tanggal }}</td>
                                                                        <td class="font-semibold text-center border">
                                                                            {{ $data->tensi_darah }}</td>
                                                                        <td class="font-semibold text-center border">
                                                                            {{ $data->berat_badan }} kg</td>
                                                                        <td class="font-semibold text-center border">
                                                                            {{ $data->biaya ? 'Rp' . number_format($data->biaya, 0, ',', '.') : '-' }}
                                                                        </td>
                                                                        <td class="font-semibold text-center border">
                                                                            {{ $data->opsi->nama ?? '-' }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada riwayat tindakan.</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="modal-action border-t pt-4">
                                                        <button class="btn"
                                                            onclick="document.getElementById('detail_modal_{{ $item->id }}').close();">Tutup</button>
                                                    </div>
                                                </div>
                                            </dialog>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-6 font-semibold text-gray-500 text-center" colspan="8">
                                            Tidak ada data pasien ditemukan.</td>
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
</x-dashboard.main>
