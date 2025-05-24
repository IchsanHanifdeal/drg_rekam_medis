<div class="drawer-side border-r border-base-300 shadow-md z-20">
    <!-- Close Sidebar Overlay for Mobile -->
    <label for="aside-dashboard" aria-label="Close sidebar" class="drawer-overlay"></label>

    <ul
        class="bg-base-100 menu flex flex-col justify-between p-4 w-64 lg:w-72 min-h-full [&>li>a]:gap-4 [&>li]:my-1.5 [&>li]:text-[14.3px] [&>li]:font-medium [&>li]:text-opacity-80 [&>li]:text-base [&>_*_svg]:stroke-[1.5] [&>_*_svg]:size-[23px]">

        <!-- Sidebar Header (Brand or Logo) -->
        <div>
            <div class="pb-4 border-b border-base-300">
                @include('components.brands', ['class' => 'btn btn-ghost text-3xl'])
            </div>

            <li class="my-2">
                <a href="{{ route('dashboard') }}"
                    class="{{ Request::path() == 'dashboard' ? 'bg-[#aa8f55] text-white rounded px-2.5' : '' }} flex items-center px-2.5 font-semibold">
                    <x-lucide-bar-chart-2 /> Dashboard
                </a>
            </li>
            <li class="my-2">
                <a href="{{ route('pendaftaran') }}"
                    class="{{ Str::startsWith(Request::path(), 'dashboard/pendaftaran') ? 'bg-[#aa8f55] text-white rounded px-2.5' : '' }} flex items-center px-2.5 font-semibold">
                    <x-lucide-user-plus /> Pendaftaran
                </a>
            </li>
            <li class="my-2">
                <a href="{{ route('tindakan') }}"
                    class="{{ Str::startsWith(Request::path(), 'dashboard/tindakan') ? 'bg-[#aa8f55] text-white rounded px-2.5' : '' }} flex items-center px-2.5 font-semibold">
                    <x-lucide-stethoscope /> Tindakan
                </a>
            </li>
            {{-- <li class="my-2">
                <a href="{{ route('opsi_tindakan') }}"
                    class="{{ Str::startsWith(Request::path(), 'opsi_tindakan') ? 'bg-[#aa8f55] text-white rounded px-2.5' : '' }} flex items-center px-2.5 font-semibold">
                    <x-lucide-stethoscope /> Opsi Tindakan
                </a>
            </li> --}}
            <li class="my-2">
                <a href="{{ route('pengeluaran') }}"
                    class="{{ Str::startsWith(Request::path(), 'dashboard/pengeluaran') ? 'bg-[#aa8f55] text-white rounded px-2.5' : '' }} flex items-center px-2.5 font-semibold">
                    <x-lucide-dollar-sign /> Pengeluaran
                </a>
            </li>
            <li class="my-2">
                <a href="{{ route('laporan') }}"
                    class="{{ Str::startsWith(Request::path(), 'dashboard/laporan') ? 'bg-[#aa8f55] text-white rounded px-2.5' : '' }} flex items-center px-2.5 font-semibold">
                    <x-lucide-clipboard-list /> Laporan
                </a>
            </li>
        </div>

    </ul>
</div>
