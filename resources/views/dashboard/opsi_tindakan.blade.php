<x-dashboard.main title="Opsi Tindakan">
    <div class="flex flex-col lg:flex-row gap-5">
        @foreach (['tambah_tindakan'] as $item)
            <div onclick="{{ $item . '_modal' }}.showModal()"
                class="flex items-center justify-between p-5 sm:p-7 hover:shadow-md active:scale-[.97] border border-gray-200 cursor-pointer bg-white rounded-xl w-full">
                <div>
                    <h1
                        class="text-black font-semibold flex items-start gap-3 font-[onest] sm:text-lg capitalize">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <p class="text-sm opacity-60 text-black">
                        {{ $item == 'tambah_tindakan' ? 'Fitur Tambah tindakan memungkinkan pengguna untuk menambahkan data tindakan baru ke sistem.' : '' }}
                    </p>
                </div>
                <x-lucide-plus
                    class="{{ $item == 'tambah_tindakan' ? '' : 'hidden' }} size-5 sm:size-7 font-semibold text-black" />
            </div>
        @endforeach
    </div>

    <div class="flex gap-5 mt-5">
        @foreach (['opsi_tindakan'] as $item)
            <div class="flex flex-col border border-gray-200 rounded-xl w-full bg-white">
                <div class="p-5 sm:p-7 rounded-t-xl bg-white border-b border-gray-100">
                    <h1 class="flex items-start gap-3 font-semibold font-[onest] text-lg capitalize text-black">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <p class="text-sm opacity-60 text-black">
                        Jelajahi dan ketahui Opsi Tindakan Tersedia.
                    </p>
                </div>
                <div class="flex flex-col rounded-b-xl gap-3 divide-y pt-0 p-5 sm:p-7">
                    <div class="overflow-x-auto">
                        <table class="table w-full text-black" id="anggotaTable">
                            <thead>
                                <tr class="text-black">
                                    @foreach (['No', 'Nama', 'created at', 'updated at', ''] as $header)
                                        <th class="uppercase font-bold text-center border-b">{{ $header }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($OpsiTindakan as $i => $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <th class="font-semibold capitalize text-center">
                                            {{ $i + 1 }}</th>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->nama }}</td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->created_at ?? '-' }}
                                        </td>
                                        <td class="font-semibold capitalize text-center">
                                            {{ $item->updated_at ?? '-' }}
                                        </td>
                                        <td class="flex items-center gap-4 justify-center">
                                            <x-lucide-pencil class="size-5 stroke-yellow-500 hover:opacity-70 cursor-pointer"
                                                onclick="document.getElementById('update_modal_{{ $item->id }}').showModal();" />
                                            <dialog id="update_modal_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <div class="modal-box bg-white text-black border border-gray-200">
                                                    <h3 class="text-lg font-bold border-b pb-2">Update Data
                                                    </h3>
                                                    <div class="mt-3">
                                                        <form method="POST"
                                                            action="{{ route('update.opsi_tindakan', $item->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            @foreach (['nama'] as $type)
                                                                <div class="mb-4 capitalize">
                                                                    <label
                                                                        for="update_{{ $type }}_{{ $item->id }}"
                                                                        class="block mb-2 text-sm font-medium text-black">{{ ucfirst(str_replace('_', ' ', $type)) }}</label>
                                                                    <input type="text"
                                                                        id="update_{{ $type }}_{{ $item->id }}"
                                                                        name="{{ $type }}"
                                                                        placeholder="Masukan {{ str_replace('_', ' ', $type) }}..."
                                                                        class="bg-gray-100 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 @error($type) border-red-500 @enderror capitalize"
                                                                        value="{{ old($type, $item->$type) }}" />
                                                                    @error($type)
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
                                                    <h3 class="text-lg font-bold capitalize text-red-600 border-b pb-2">
                                                        Hapus
                                                        Opsi Tindakan
                                                    </h3>
                                                    <div class="mt-3">
                                                        <p class="text-gray-800">
                                                            Apakah Anda yakin ingin menghapus 
                                                            <strong class="font-bold capitalize">{{ $item->nama }}</strong>?
                                                        </p>
                                                        <p class="text-sm text-gray-500 mt-1">Tindakan ini tidak dapat dibatalkan.</p>
                                                    </div>
                                                    <div class="modal-action">
                                                        <button type="button"
                                                            onclick="document.getElementById('hapus_{{ $item->id }}').close()"
                                                            class="btn">Batal</button>
                                                        <form action="{{ route('delete.opsi_tindakan', $item->id) }}"
                                                            method="POST" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-error text-white">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </dialog>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-6 font-semibold text-gray-500 text-center" colspan="5">
                                            Tidak ada Opsi Tindakan terdaftar</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <dialog id="tambah_tindakan_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-white text-black border border-gray-200">
            <h3 class="text-lg font-bold border-b pb-2">Tambah Data Tindakan</h3>
            <div class="mt-3">
                <form method="POST" action="{{ route('store.opsi_tindakan') }}" enctype="multipart/form-data">
                    @csrf
                    @foreach (['nama'] as $type)
                        <div class="mb-4 capitalize">
                            <label for="{{ $type }}"
                                class="block mb-2 text-sm font-medium text-black">{{ ucfirst(str_replace('_', ' ', $type)) }}</label>
                            <input type="text" id="{{ $type }}" name="{{ $type }}"
                                placeholder="Masukan {{ str_replace('_', ' ', $type) }}..."
                                class="bg-gray-100 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 @error($type) border-red-500 @enderror capitalize"
                                value="{{ old($type) }}" />
                            @error($type)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                    <div class="modal-action">
                        <button type="button" onclick="document.getElementById('tambah_tindakan_modal').close()"
                            class="btn">Batal</button>
                        <button type="submit" class="btn text-white" style="background-color: {{ $web_config->theme_colors['accent'] }}">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </dialog>
</x-dashboard.main>
