<div class="flex items-center">
    {{-- <img src="{{ asset('image/logo.png') }}" alt="Logo Sioner" class="w-12 h-12 mr-2"> --}}
    <a class="{{ $class ?? '' }} font-[onest] font-extrabold text-xl text-uppercase text-white">
        {{ $web_config->nama_klinik ?? 'Default' }}
    </a>
</div>
