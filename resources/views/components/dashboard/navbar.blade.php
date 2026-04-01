<div class="navbar sticky top-0 border-b border-base-300 shadow-md z-10" style="background-color: {{ $web_config->theme_colors['primary'] ?? '#A5B985' }};">
    <div class="flex-none md:hidden">
        <label for="aside-dashboard" aria-label="Open sidebar" class="btn btn-square btn-ghost">
            <x-lucide-align-left class="w-6 h-6 stroke-[1.5]" />
        </label>
    </div>

    <div class="flex-1 px-2 mx-2"></div>

    <div class="flex-none flex justify-end items-center gap-4 relative">
        <p class='font-[onest] font-extrabold text-xl text-3xl' style="color: {{ $web_config->theme_colors['accent'] ?? '#eb873b' }};">{{ $web_config->nama_dokter ?? 'Default' }}</p>

        <div class="dropdown dropdown-end">
            <button class="btn btn-ghost btn-square">
                <x-lucide-cog class="w-6 h-6 stroke-[1.5]" />
            </button>
            <ul class="dropdown-content menu p-2 shadow rounded-box w-40" style="background-color: {{ $web_config->theme_colors['primary'] ?? '#A5B985' }};">
                <li><a href="{{ route('opsi_tindakan') }}" class="text-base">Tambah Tindakan</a></li>
                <li><a href="{{ route('profile') }}" class="text-base">Pengaturan Akun</a></li>
                <li>
                    <button type="button" id="logoutButton" class="text-base">
                        <span>Logout</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Logout Modal -->
<dialog id="logoutModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box text-[#333333] border shadow-xl rounded-xl" style="background-color: {{ $web_config->theme_colors['secondary'] ?? '#eae3cd' }}; border-color: {{ $web_config->theme_colors['primary'] ?? '#aa8f55' }};">
        <h3 class="text-lg font-bold capitalize text-center">Konfirmasi Logout</h3>

        <div class="mt-3 text-sm sm:text-base">
            <p class="text-center">
                Anda yakin ingin keluar dari akun ini? Semua sesi yang belum disimpan akan hilang.
            </p>
        </div>

        <div class="modal-action flex justify-between mt-6">
            <button type="button" onclick="document.getElementById('logoutModal').close()"
                class="btn bg-white hover:bg-yellow-400 text-[#333333] border" style="border-color: {{ $web_config->theme_colors['primary'] ?? '#aa8f55' }};">
                Batal
            </button>

            <form action="{{ route('logout') }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" class="btn text-white shadow-md hover:brightness-90" style="background-color: {{ $web_config->theme_colors['primary'] ?? '#aa8f55' }};"
                    onclick="closeAllModals(event)">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</dialog>

<script>
    // Open logout modal when logout button is clicked
    document.getElementById('logoutButton').addEventListener('click', function() {
        document.getElementById('logoutModal').showModal();
    });
</script>
