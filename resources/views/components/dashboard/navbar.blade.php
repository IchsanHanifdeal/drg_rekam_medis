<div class="navbar sticky top-0 bg-base-100 border-b border-base-300 shadow-md z-10">
    <div class="flex-none md:hidden">
        <label for="aside-dashboard" aria-label="Open sidebar" class="btn btn-square btn-ghost">
            <x-lucide-align-left class="w-6 h-6 stroke-[1.5]" />
        </label>
    </div>

    <div class="flex-1 px-2 mx-2"></div>

    <div class="flex-none flex justify-end items-center gap-4 relative">
        <p class='font-[onest] font-extrabold text-xl text-[#eb873b] text-3xl'>Drg. Laudia Martasari</p>

        <div class="dropdown dropdown-end">
            <button class="btn btn-ghost btn-square">
                <x-lucide-cog class="w-6 h-6 stroke-[1.5]" />
            </button>
            <ul class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-40">
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
    <div class="modal-box bg-[#eae3cd] text-[#333333] border border-[#aa8f55] shadow-xl rounded-xl">
        <h3 class="text-lg font-bold capitalize text-center">Konfirmasi Logout</h3>

        <div class="mt-3 text-sm sm:text-base">
            <p class="text-center">
                Anda yakin ingin keluar dari akun ini? Semua sesi yang belum disimpan akan hilang.
            </p>
        </div>

        <div class="modal-action flex justify-between mt-6">
            <button type="button" onclick="document.getElementById('logoutModal').close()"
                class="btn bg-white hover:bg-yellow-400 text-[#333333] border border-[#aa8f55]">
                Batal
            </button>

            <form action="{{ route('logout') }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" class="btn bg-[#aa8f55] hover:bg-[#9a7e44] text-white shadow-md"
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
