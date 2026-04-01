<x-dashboard.main title="Tindakan">
    <!-- TAMBAH TINDAKAN FORM -->
    <div class="flex flex-col lg:flex-row gap-5">
        <div class="flex flex-col border-back rounded-xl w-full p-5 sm:p-7 bg-white">
            <h1 class="text-black font-semibold flex items-start gap-3 font-[onest] sm:text-lg capitalize">
                Tambah Tindakan
            </h1>
            <p class="text-sm opacity-60 text-black">
                Fitur Tambah tindakan memungkinkan pengguna untuk menambahkan data tindakan ke sistem.
            </p>
            <form method="POST" action="{{ route('store.tindakan') }}" enctype="multipart/form-data" class="mt-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
                    <div class="flex items-center gap-3">
                        <label for="pasien" class="text-md font-medium text-black dark:text-black w-32">Pasien</label>
                        <select id="pasien" name="pasien"
                            class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5 flex-1 w-full @error('pasien') border-red-500 @enderror">
                            <option value="">Pilih Pasien</option>
                            @foreach ($pendaftarans as $pasien)
                                <option value="{{ $pasien->id }}">{{ $pasien->nomor_rekam_medis }} - {{ $pasien->nama }}</option>
                            @endforeach
                        </select>
                        @error('pasien')
                            <span class="text-red-500 text-md">{{ $message }}</span>
                        @enderror
                    </div>

                    @foreach (['tanggal', 'TD/BB'] as $type)
                        <div class="flex items-center gap-3">
                            <label for="{{ $type }}"
                                class="text-md font-medium text-black dark:text-black w-32">
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
                                    <span class="text-black">/</span>
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
                        <label class="text-md font-medium text-black dark:text-black w-32">Odontogram</label>
                        <div class="flex flex-1 gap-2 flex-col sm:flex-row items-stretch sm:items-center">
                            <div class="flex gap-2 flex-1">
                                <input type="text" id="display_tooth" class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg p-2.5 w-1/2 sm:w-1/3" placeholder="Pilih Gigi di Peta..." readonly />
                                <input type="text" id="display_surface" class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg p-2.5 w-1/2 sm:w-1/3" placeholder="Permukaan..." readonly />
                            </div>
                            <select name="condition_code" id="condition_code" onchange="window.dispatchEvent(new CustomEvent('condition-code-changed', { detail: this.value }))" class="bg-gray-300 border border-red-300 rounded-lg focus:ring-red-500 p-2.5 flex-1 font-semibold">
                                <option value="" selected>Kondisi Gigi (Opsional)</option>
                                <option value="karies">Karies</option>
                                <option value="restorasi">Restorasi</option>
                                <option value="cabut">Missing / Cabut</option>
                                <option value="lainnya">Lainnya / Sehat</option>
                            </select>
                        </div>
                        <input type="hidden" name="odontogram_selections" id="input_odontogram_selections" value="[]" />
                    </div>

                    <div class="flex items-center gap-3">
                        <label for="tindakan"
                            class="text-md font-medium text-black dark:text-black w-32">Tindakan</label>
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
                        <label for="biaya" class="text-md font-medium text-black dark:text-black w-32">Biaya</label>
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

                <div class="flex gap-3 justify-end mt-4">
                    <button type="reset" class="btn border-none text-black hover:bg-neutral-focus">Reset</button>
                    <button type="submit" class="btn border-none text-white" style="background-color: {{ $web_config->theme_colors['accent'] }};">Simpan</button>
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
        <div class="flex flex-col border-back rounded-xl w-full bg-white">
            <div class="p-5 sm:p-7 rounded-t-xl border-b border-white/10 bg-white">
                <h1 class="flex items-start gap-3 font-semibold font-[onest] text-lg capitalize text-black">
                    Peta Gigi (Odontogram)
                </h1>
                <p class="text-sm opacity-60 text-black mt-1">
                    Pilih permukaan gigi untuk mencatat tindakan medis spesifik pada Odontogram.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-6 p-4 bg-white/5 rounded-xl text-black">
                    <div class="text-xs">
                        <span class="font-bold">Urutan Penomoran:</span> FDI World Dental Federation System
                    </div>
                    <div class="flex flex-wrap gap-4 text-xs">
                        <div class="flex items-center gap-1.5"><div class="w-3 h-3 bg-error rounded border border-white/20"></div> Karies</div>
                        <div class="flex items-center gap-1.5"><div class="w-3 h-3 bg-warning rounded border border-white/20"></div> Restorasi</div>
                        <div class="flex items-center gap-1.5"><div class="w-3 h-3 bg-info rounded border border-white/20"></div> Cabut</div>
                        <div class="flex items-center gap-1.5"><div class="w-3 h-3 bg-gray-500 rounded border border-white/20"></div> Lainnya</div>
                    </div>
                </div>
            </div>

            <div class="p-5 sm:p-7 flex justify-center pb-12 overflow-x-auto w-full rounded-b-xl bg-white">
                <div class="flex flex-col items-center min-w-[700px] mx-auto relative px-4 text-gray-800">
                    
                    <div class="flex flex-col gap-8 w-full border-b border-gray-300 pb-12 relative pt-4">
                        <div class="absolute bottom-[-14px] left-1/2 transform -translate-x-1/2 bg-white px-4 text-xs font-bold tracking-widest text-gray-500 uppercase rounded-full shadow-sm border border-gray-200 z-20">Atas • Bawah</div>
                        <div class="absolute left-1/2 top-0 bottom-0 w-px bg-gray-300 transform -translate-x-1/2 z-0"></div>

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
                        
                        <div class="flex justify-center gap-6 sm:gap-8 w-full relative z-10 hidden-adult">
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
                        <div class="absolute left-1/2 top-0 bottom-0 w-px bg-gray-300 transform -translate-x-1/2 z-0"></div>

                        <div class="flex justify-center gap-6 sm:gap-8 w-full relative z-10 hidden-adult">
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

        <!-- MODAL REMOVED - Odontogram now populates the main form directly -->
    </div>

    <!-- DATA TINDAKAN SECTION -->
    <div class="flex gap-5 mt-5">
        @foreach (['data_tindakan'] as $item)
            <div class="flex flex-col border-back rounded-xl w-full bg-white">
                <div class="p-5 sm:p-7 rounded-t-xl bg-white">
                    <h1 class="flex items-start gap-3 font-semibold font-[onest] text-lg capitalize text-black">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <p class="text-sm opacity-60 text-black">
                        Jelajahi dan ketahui Tindakan.
                    </p>
                </div>
                <form action="{{ route('tindakan') }}" method="GET" class="w-full">
                    <div class="w-full px-5 sm:px-7 my-4">
                        <input type="text" id="searchInput" placeholder="Cari data disini...." name="nama"
                            value="{{ request('nama') }}"
                            class="input input-sm shadow-md w-full text-black border-white/20">
                    </div>
                </form>

                <div class="flex flex-col rounded-b-xl gap-3 divide-y divide-white/10 pt-0 p-5 sm:p-7">
                    <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm w-full">
                        <table class="w-full text-sm text-center border-collapse" id="dataTable">
                            <thead class="text-white" style="background-color: {{ $web_config->theme_colors['accent'] }};">
                                <tr>
                                    @foreach (['No', 'No. RM', 'Nama', 'Hari/Tanggal', 'TD/BB', 'Gigi/Bagian', 'Tindakan', 'Biaya', 'Aksi'] as $header)
                                        <th class="py-3 px-4 font-bold uppercase tracking-wider border-r border-white/30 last:border-r-0">
                                            {{ $header }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            
                            <tbody class="bg-white">
                                @forelse ($tindakan as $i => $item)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-200">
                                            {{ $tindakan->firstItem() + $i }}
                                        </td>
                                        <td class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-200">
                                            {{ $item->pendaftarans->nomor_rekam_medis }}
                                        </td>
                                        <td class="py-3 px-4 font-semibold text-gray-800 capitalize border-r border-gray-200">
                                            {{ $item->pendaftarans->nama }}
                                        </td>
                                        <td class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-200">
                                            {{-- Pindahin ini ke Model Accessor: $item->tanggal_formatted --}}
                                            {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd/DD-MM-YYYY') : '-' }}
                                        </td>
                                        <td class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-200">
                                            {{ $item->tensi_darah }}/{{ $item->berat_badan }}kg
                                        </td>
                                        <td class="py-3 px-4 font-semibold border-r border-gray-200">
                                            {{ $item->tooth_number ? 'Gigi ' . $item->tooth_number : '-' }}
                                        </td>
                                        <td class="py-3 px-4 font-semibold text-gray-800 capitalize border-r border-gray-200">
                                            {{ $item->opsi->nama ?? '-' }}
                                        </td>
                                        <td class="py-3 px-4 font-semibold text-gray-800 border-r border-gray-200">
                                            {{ $item->biaya ? 'Rp ' . number_format($item->biaya, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="py-3 px-4 border border-gray-300">
                                            <div class="flex items-center justify-center gap-3">
                                                <x-lucide-pencil class="size-5 stroke-yellow-500 hover:opacity-70 cursor-pointer transition-opacity"
                                                    onclick="document.getElementById('update_modal_{{ $item->id }}').showModal();" />
                                                
                                                <dialog id="update_modal_{{ $item->id }}" class="modal modal-bottom sm:modal-middle text-left">
                                                    <div class="modal-box bg-white text-black border border-gray-200 shadow-xl">
                                                        <h3 class="text-lg font-bold border-b pb-2 mb-4">Update Tindakan</h3>
                                                        
                                                        <form method="POST" action="{{ route('update.tindakan', $item->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="grid grid-cols-1 gap-4">
                                                                <div class="flex items-center gap-3">
                                                                    <label for="pasien_{{ $item->id }}" class="text-sm font-medium w-32">Pasien</label>
                                                                    <select id="pasien_{{ $item->id }}" name="pasien"
                                                                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-[#7cb342] focus:border-[#7cb342] p-2 flex-1 w-full @error('pasien') border-red-500 @enderror">
                                                                        <option value="">Pilih Pasien</option>
                                                                        @foreach (\App\Models\Pendaftaran::all() as $pasien)
                                                                            <option value="{{ $pasien->id }}" {{ old('pasien', $item->pendaftaran) == $pasien->id ? 'selected' : '' }}>
                                                                                {{ $pasien->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="flex items-center gap-3">
                                                                    <label for="tanggal_{{ $item->id }}" class="text-sm font-medium w-32">Tanggal</label>
                                                                    <input type="date" id="tanggal_{{ $item->id }}" name="tanggal"
                                                                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-[#7cb342] focus:border-[#7cb342] p-2 flex-1 w-full @error('tanggal') border-red-500 @enderror"
                                                                        value="{{ old('tanggal', $item->tanggal) }}" />
                                                                </div>

                                                                <div class="flex items-center gap-3">
                                                                    <label class="text-sm font-medium w-32">TD/BB</label>
                                                                    <div class="flex items-center gap-2 flex-1">
                                                                        <input type="number" id="td_{{ $item->id }}" name="td" placeholder="TD..."
                                                                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-[#7cb342] focus:border-[#7cb342] p-2 w-full @error('td') border-red-500 @enderror"
                                                                            value="{{ old('td', $item->tensi_darah) }}" />
                                                                        <span>/</span>
                                                                        <input type="number" id="bb_{{ $item->id }}" name="bb" placeholder="BB..."
                                                                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-[#7cb342] focus:border-[#7cb342] p-2 w-full @error('bb') border-red-500 @enderror"
                                                                            value="{{ old('bb', $item->berat_badan) }}" />
                                                                    </div>
                                                                </div>

                                                                <div class="flex items-center gap-3">
                                                                    <label for="tindakan_{{ $item->id }}" class="text-sm font-medium w-32">Tindakan</label>
                                                                    <select id="tindakan_{{ $item->id }}" name="tindakan"
                                                                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-[#7cb342] focus:border-[#7cb342] p-2 flex-1 w-full @error('tindakan') border-red-500 @enderror">
                                                                        <option value="">Pilih Tindakan</option>
                                                                        @foreach (\App\Models\OpsiTindakan::all() as $opsi)
                                                                            <option value="{{ $opsi->id }}" {{ old('tindakan', $item->opsi_tindakan) == $opsi->id ? 'selected' : '' }}>
                                                                                {{ $opsi->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="flex items-center gap-3">
                                                                    <label for="biaya_{{ $item->id }}" class="text-sm font-medium w-32">Biaya</label>
                                                                    <input type="text" id="biaya_{{ $item->id }}" name="formatted_biaya"
                                                                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-[#7cb342] focus:border-[#7cb342] p-2 flex-1 w-full"
                                                                        placeholder="Masukan Biaya..."
                                                                        value="{{ old('formatted_biaya', $item->biaya) }}"
                                                                        oninput="formatRupiah(this)" />
                                                                    <input type="hidden" id="biaya_raw_{{ $item->id }}" name="biaya"
                                                                        value="{{ old('biaya', $item->biaya) }}" />
                                                                </div>
                                                            </div>

                                                            <div class="modal-action mt-6 border-t pt-4">
                                                                <button type="button" onclick="document.getElementById('update_modal_{{ $item->id }}').close()"
                                                                    class="btn bg-gray-200 hover:bg-gray-300 text-gray-800 border-none">Batal</button>
                                                                <button type="submit" class="btn bg-[#7cb342] hover:bg-[#689f38] text-white border-none">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </dialog>

                                                <x-lucide-trash class="size-5 stroke-red-500 hover:opacity-70 cursor-pointer transition-opacity"
                                                    onclick="document.getElementById('hapus_{{ $item->id }}').showModal();" />
                                                
                                                <dialog id="hapus_{{ $item->id }}" class="modal modal-bottom sm:modal-middle text-left">
                                                    <div class="modal-box bg-white text-black border border-gray-200 shadow-xl">
                                                        <h3 class="text-lg font-bold text-red-600 border-b pb-2 mb-4">Hapus Tindakan</h3>
                                                        
                                                        <div class="mb-6">
                                                            <p class="font-semibold mb-1">Perhatian!</p>
                                                            <p class="text-sm text-gray-600">Anda sedang mencoba menghapus data tindakan. Tindakan ini akan menghapus semua data terkait secara permanen. Apakah Anda yakin?</p>
                                                        </div>
                                                        
                                                        <div class="modal-action border-t pt-4">
                                                            <button type="button" onclick="document.getElementById('hapus_{{ $item->id }}').close()"
                                                                class="btn bg-gray-200 hover:bg-gray-300 text-gray-800 border-none">Batal</button>
                                                            <form action="{{ route('delete.tindakan', $item->id) }}" method="POST" class="inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn bg-red-500 hover:bg-red-600 text-white border-none">Ya, Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </dialog>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-6 font-semibold text-gray-500 text-center" colspan="9">
                                            Tidak ada data tindakan terdaftar
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <style>
        /* Override Select2 default styling to mimic Tailwind's 'bg-gray-300 border-gray-300 text-gray-900 rounded-lg p-2.5 flex-1' */
        .select2-container .select2-selection--single {
            background-color: #D1D5DB !important; /* bg-gray-300 */
            border: 1px solid #D1D5DB !important; /* border-gray-300 */
            border-radius: 0.5rem !important; /* rounded-lg */
            height: auto !important; /* let padding define height */
            padding: 0.625rem !important; /* p-2.5 */
            display: flex;
            align-items: center;
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            color: #111827 !important; /* text-gray-900 */
            padding-left: 0 !important;
            padding-right: 0 !important;
            line-height: normal !important;
        }
        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            right: 0.75rem !important;
        }
        .select2-container {
            flex: 1 1 0%;
            width: 100% !important;
        }
        .select2-dropdown {
            background-color: #E5E7EB !important; /* bg-gray-200 */
            border: 1px solid #D1D5DB !important;
            border-radius: 0.5rem !important;
            overflow: hidden;
            margin-top: 4px;
        }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #c97433 !important; /* Match text-primary/hover theme */
            color: white !important;
        }
        .select2-search__field {
            border-radius: 0.375rem !important;
            border: 1px solid #9CA3AF !important;
            background-color: white !important;
            padding: 0.4rem !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #4B5563 !important; /* text-gray-600 */
        }
        .select2-search--dropdown {
            padding: 0.5rem !important;
        }
    </style>

    <!-- SCRIPTS FOR FORMATTING & SEARCH -->
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
            
            // Nge-update input hidden biar masuk database raw integer
            let hiddenInputId = element.id + '_raw'; 
            if(document.getElementById(hiddenInputId)) {
                document.getElementById(hiddenInputId).value = value;
            } else if (element.nextElementSibling && element.nextElementSibling.type === 'hidden') {
                element.nextElementSibling.value = value;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if ($('#pasien').length) {
                $('#pasien').select2({
                    placeholder: "Cari Nama atau No Rekam Medis...",
                    allowClear: true,
                    width: '100%'
                }).on('select2:select', function (e) {
                    let value = e.params.data.id;
                    if (value) {
                        fetch(`/dashboard/tindakan/odontogram/${value}`)
                            .then(res => res.json())
                            .then(data => {
                                window.dispatchEvent(new CustomEvent('odontogram-loaded', { detail: data }));
                            })
                            .catch(err => console.error("Error fetching odontogram data:", err));
                    }
                }).on('select2:clear', function() {
                    window.dispatchEvent(new CustomEvent('odontogram-loaded', { detail: {} }));
                });
            }

            const searchInput = document.getElementById('searchInput');
            const dataTable = document.getElementById('dataTable');
            if (searchInput && dataTable) {
                const tableRows = dataTable.querySelectorAll('tbody tr');
                const noDataRow = document.createElement('tr');
                const noDataCell = document.createElement('td');

                noDataCell.colSpan = dataTable.querySelectorAll('thead th').length;
                noDataCell.textContent = 'Data tidak ditemukan';
                noDataCell.className = "text-center py-4 font-semibold text-black/50";
                noDataRow.appendChild(noDataCell);

                searchInput.addEventListener('keyup', function() {
                    const query = searchInput.value.toLowerCase();
                    let rowVisible = false;

                    tableRows.forEach(row => {
                        let rowMatch = false;

                        for (let i = 0; i < row.cells.length - 1; i++) { // Skip the 'Aksi' column
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
            }
        });
    </script>
</x-dashboard.main>