<x-main title="Login" class="p-0" full>
    <section class="min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-8" style="background-color: {{ $web_config->theme_colors['primary'] ?? '#A5B985' }};">
        <div class="w-full max-w-sm sm:max-w-md lg:max-w-lg p-6 sm:p-8 rounded-2xl shadow-2xl border text-[#333333]" style="border-color: {{ $web_config->theme_colors['primary'] ?? '#aa8f55' }}; background-color: {{ $web_config->theme_colors['secondary'] ?? '#eae3cd' }};">
            <div class="w-full mb-6 flex items-center justify-center">
                @php
                    $rawLogo = $web_config->logo ?? 'default/logo.png';
                    $logoUrl = Str::startsWith($rawLogo, 'images/settings') ? Storage::url($rawLogo) : asset($rawLogo);
                @endphp
                <img src="{{ $logoUrl }}" alt="{{ $web_config->nama_klinik ?? 'Klinik Default' }} Logo" class="w-32 sm:w-40 md:w-48 object-contain" />
            </div>

            <h1 class="text-2xl sm:text-3xl font-bold text-center mb-6">
                Selamat Datang di <br><span style="color: {{ $web_config->theme_colors['accent'] ?? '#aa8f55' }};">{{ $web_config->nama_klinik ?? 'Klinik Default' }}</span>
            </h1>

            <form action="{{ route('auth') }}" method="POST" class="space-y-4">
                @csrf

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-[#333333]">Email</span>
                    </label>
                    <input type="text" name="email" placeholder="Masukkan email"
                        class="input w-full bg-white text-[#333333] transition-all border"
                        style="border-color: {{ $web_config->theme_colors['primary'] ?? '#aa8f55' }};"
                        onfocus="this.style.borderColor='{{ $web_config->theme_colors['primary'] ?? '#aa8f55' }}'; this.style.boxShadow='0 0 0 2px {{ $web_config->theme_colors['primary'] ?? '#aa8f55' }}';"
                        onblur="this.style.borderColor='{{ $web_config->theme_colors['primary'] ?? '#aa8f55' }}'; this.style.boxShadow='none';"
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-[#333333]">Password</span>
                    </label>
                    <input type="password" name="password" placeholder="Masukkan Password"
                        class="input w-full bg-white text-[#333333] transition-all border"
                        style="border-color: {{ $web_config->theme_colors['primary'] ?? '#aa8f55' }};"
                        onfocus="this.style.borderColor='{{ $web_config->theme_colors['primary'] ?? '#aa8f55' }}'; this.style.boxShadow='0 0 0 2px {{ $web_config->theme_colors['primary'] ?? '#aa8f55' }}';"
                        onblur="this.style.borderColor='{{ $web_config->theme_colors['primary'] ?? '#aa8f55' }}'; this.style.boxShadow='none';">
                    @error('password')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn w-full text-white text-lg shadow-md transition-all hover:scale-105 hover:brightness-90"
                    style="background-color: {{ $web_config->theme_colors['primary'] ?? '#aa8f55' }};">
                    Masuk
                </button>
            </form>
        </div>
    </section>
</x-main>
