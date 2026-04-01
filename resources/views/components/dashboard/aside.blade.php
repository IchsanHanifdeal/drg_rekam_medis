<div class="drawer-side border-r border-base-300 shadow-md z-20">
    <!-- Close Sidebar Overlay for Mobile -->
    <label for="aside-dashboard" aria-label="Close sidebar" class="drawer-overlay"></label>

    <ul
        class="menu flex flex-col p-4 w-64 lg:w-72 min-h-full [&>li>a]:gap-4 [&>li]:my-1.5 [&>li]:text-[14.3px] [&>li]:font-medium [&>li]:text-opacity-80 [&>li]:text-base [&>_*_svg]:stroke-[1.5] [&>_*_svg]:size-[23px]" style="background-color: {{ $web_config->theme_colors['primary'] ?? '#A5B985' }};">

        <!-- Sidebar Header (Brand or Logo) -->
        <div class="border-b border-white/10 -m-4 mb-2 p-4" style="background-color: {{ $web_config->theme_colors['secondary'] ?? '#aa8f55' }};">
            @include('components.brands', ['class' => 'btn btn-ghost text-3xl'])
        </div>

        <div>

            <li class="my-2">
                <a href="{{ route('dashboard') }}"
                    class="{{ Request::path() == 'dashboard' ? 'text-white rounded px-2.5' : '' }} flex items-center text-white px-2.5 font-semibold"
                    @if(Request::path() == 'dashboard') style="background-color: {{ $web_config->theme_colors['accent'] ?? '#aa8f55' }};" @endif>
                    <x-lucide-bar-chart-2 /> Dashboard
                </a>
            </li>
            <li class="my-2">
                <a href="{{ route('pendaftaran') }}"
                    class="{{ Str::startsWith(Request::path(), 'dashboard/pendaftaran') ? 'text-white rounded px-2.5' : '' }} flex items-center text-white px-2.5 font-semibold"
                    @if(Str::startsWith(Request::path(), 'dashboard/pendaftaran')) style="background-color: {{ $web_config->theme_colors['accent'] ?? '#aa8f55' }};" @endif>
                    <x-lucide-user-plus /> Pendaftaran
                </a>
            </li>
            <li class="my-2">
                <a href="{{ route('tindakan') }}"
                    class="{{ Str::startsWith(Request::path(), 'dashboard/tindakan') ? 'text-white rounded px-2.5' : '' }} flex items-center text-white px-2.5 font-semibold"
                    @if(Str::startsWith(Request::path(), 'dashboard/tindakan')) style="background-color: {{ $web_config->theme_colors['accent'] ?? '#aa8f55' }};" @endif>
                    <x-lucide-stethoscope /> Tindakan
                </a>
            </li>
            {{-- <li class="my-2">
                <a href="{{ route('opsi_tindakan') }}"
                    class="{{ Str::startsWith(Request::path(), 'opsi_tindakan') ? 'text-white rounded px-2.5' : '' }} flex items-center px-2.5 font-semibold"
                    @if(Str::startsWith(Request::path(), 'opsi_tindakan')) style="background-color: {{ $web_config->theme_colors['secondary'] ?? '#aa8f55' }};" @endif>
                    <x-lucide-stethoscope /> Opsi Tindakan
                </a>
            </li> --}}
            <li class="my-2">
                <a href="{{ route('pengeluaran') }}"
                    class="{{ Str::startsWith(Request::path(), 'dashboard/pengeluaran') ? 'text-white rounded px-2.5' : '' }} flex items-center text-white px-2.5 font-semibold"
                    @if(Str::startsWith(Request::path(), 'dashboard/pengeluaran')) style="background-color: {{ $web_config->theme_colors['accent'] ?? '#aa8f55' }};" @endif>
                    <x-lucide-dollar-sign /> Pengeluaran
                </a>
            </li>
            <li class="my-2">
                <a href="{{ route('laporan') }}"
                    class="{{ Str::startsWith(Request::path(), 'dashboard/laporan') ? 'text-white rounded px-2.5' : '' }} flex items-center text-white px-2.5 font-semibold"
                    @if(Str::startsWith(Request::path(), 'dashboard/laporan')) style="background-color: {{ $web_config->theme_colors['accent'] ?? '#aa8f55' }};" @endif>
                    <x-lucide-clipboard-list /> Laporan
                </a>
            </li>
            @role('super admin')
            <li class="my-2">
                <a href="{{ route('theme_setting') }}"
                    class="{{ Str::startsWith(Request::path(), 'dashboard/theme_setting') ? 'text-white rounded px-2.5' : '' }} flex items-center text-white px-2.5 font-semibold"
                    @if(Str::startsWith(Request::path(), 'dashboard/theme_setting')) style="background-color: {{ $web_config->theme_colors['accent'] ?? '#aa8f55' }};" @endif>
                    <x-lucide-palette /> Theme Setting
                </a>
            </li>
            @endrole
        </div>

    </ul>
</div>
