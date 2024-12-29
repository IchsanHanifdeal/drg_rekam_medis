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
            </ul>
        </div>
    </div>
</div>
