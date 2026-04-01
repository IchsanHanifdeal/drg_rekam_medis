<x-dashboard.main title="Theme Setting">
    <div class="flex flex-col lg:flex-row gap-5">
        <div class="bg-white flex flex-col border-back rounded-xl w-full p-5 sm:p-7">
            <h1 class="text-black font-semibold flex items-start gap-3 font-[onest] sm:text-lg capitalize">
                Theme & General Setting
            </h1>
            <p class="text-sm opacity-60 text-black">
                Pengaturan utama untuk menyesuaikan detail klinik, logo, dan profil warna aplikasi.
            </p>

            <form method="POST" action="{{ route('update.theme_setting') }}" enctype="multipart/form-data" class="mt-8">
                @csrf
                <!-- General Info -->
                <h2 class="text-black font-semibold mb-4 border-b border-gray-700 pb-2">Informasi Klinik</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    @foreach([
                        'nama_klinik' => 'Nama Klinik',
                        'nama_dokter' => 'Nama Dokter',
                        'alamat' => 'Alamat Lengkap',
                        'no_telp' => 'No Telepon',
                        'email' => 'Alamat Email'
                    ] as $field => $label)
                        <div class="flex flex-col gap-2 {{ $field == 'alamat' ? 'sm:col-span-2' : '' }}">
                            <label for="{{ $field }}" class="text-sm font-medium text-black">{{ $label }}</label>
                            @if($field == 'alamat')
                                <textarea id="{{ $field }}" name="{{ $field }}" rows="3"
                                    class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary focus:border-primary p-2.5 w-full @error($field) border-red-500 @enderror"
                                    required>{{ old($field, $setting->$field ?? '') }}</textarea>
                            @else
                                <input type="{{ $field == 'email' ? 'email' : 'text' }}" id="{{ $field }}" name="{{ $field }}"
                                    class="bg-gray-300 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary focus:border-primary p-2.5 w-full @error($field) border-red-500 @enderror"
                                    value="{{ old($field, $setting->$field ?? '') }}" {{ $field != 'email' ? 'required' : '' }} />
                            @endif
                            @error($field) <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    @endforeach
                </div>

                <!-- Assets / Uploads -->
                <h2 class="text-black font-semibold mb-4 border-b border-gray-700 pb-2">Logo & Favicon</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                    @foreach(['logo' => 'Logo Utama', 'favicon' => 'Logo Favicon (Ikon atas website)'] as $field => $label)
                        <div class="flex flex-col gap-2">
                            <label for="{{ $field }}" class="text-sm font-medium text-black">{{ $label }}</label>
                            @if(isset($setting) && $setting->$field)
                                <div class="mb-2 p-2 bg-white/10 rounded max-w-max border border-white/10">
                                    <img src="{{ Str::startsWith($setting->$field, 'default') ? asset($setting->$field) : Storage::url($setting->$field) }}" alt="Current {{ $label }}" class="h-16 object-contain">
                                </div>
                            @endif
                            <input type="file" id="{{ $field }}" name="{{ $field }}" accept="image/*"
                                class="file-input file-input-bordered bg-gray-300 border-gray-300 text-gray-900 w-full @error($field) border-red-500 @enderror" />
                            <span class="text-xs opacity-60 text-black">Biarkan kosong jika tidak ingin mengubah.</span>
                            @error($field) <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    @endforeach
                </div>

                <!-- Theme Colors -->
                <h2 class="text-black font-semibold mb-4 border-b border-gray-700 pb-2">Palet Warna (Theme Colors)</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
                    @php
                        $colors = [
                            'primary' => ['alias' => 'Warna Utama', 'desc' => 'Color Utama (Primary)'],
                            'secondary' => ['alias' => 'Warna Kedua', 'desc' => 'Color Kedua (Secondary)'], 
                            'accent' => ['alias' => 'Warna Tulisan', 'desc' => 'Color Tulisan'], 
                            'neutral' => ['alias' => 'Warna Untuk Table', 'desc' => 'Warna Untuk Table'],
                            'success' => ['alias' => 'Warna Sukses', 'desc' => 'Sukses (Success/Green)'],
                            'error' => ['alias' => 'Warna Error', 'desc' => 'Error/Karies (Red)']
                        ];
                        $themeColors = isset($setting) && $setting->theme_colors ? $setting->theme_colors : [];
                    @endphp
                    @foreach($colors as $key => $info)
                        <div class="flex gap-3 items-center bg-slate-300 p-3 rounded-xl border border-white/10 hover:bg-slate-500 transition-colors">
                            <input type="color" id="{{ $key }}" name="{{ $key }}" 
                                class="w-10 h-10 rounded border-0 bg-transparent cursor-pointer shrink-0" 
                                value="{{ old($key, $themeColors[$key] ?? '#000000') }}">
                            <div class="flex flex-col">
                                <label for="{{ $key }}" class="text-xs font-semibold text-black uppercase">{{ $info['alias'] }}</label>
                                <span class="text-[10px] text-black/50 leading-tight">{{ $info['desc'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex gap-3 justify-end mt-4 pt-4 border-t border-gray-700">
                    <button type="reset" class="btn border-none text-black hover:bg-neutral-focus">Reset</button>
                    <button type="submit" class="btn border-none text-white" style="background-color: {{ $web_config->theme_colors['accent'] }};">Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.main>
