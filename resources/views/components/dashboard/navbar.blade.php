<div class="navbar sticky top-0 bg-base-100 border-b border-base-300 shadow-md z-10">
    <div class="flex-none md:hidden">
        <label for="aside-dashboard" aria-label="Open sidebar" class="btn btn-square btn-ghost">
            <x-lucide-align-left class="w-6 h-6 stroke-[1.5]" />
        </label>
    </div>

    <div class="flex-1 px-2 mx-2"></div>

    <div class="flex-none flex justify-end items-center gap-4 relative">
        <p class="font-[onest] font-extrabold text-sm sm:text-lg md:text-2xl text-[#eb873b] truncate max-w-[140px] xs:max-w-[200px] sm:max-w-none">
            Drg. Laudia Martasari
        </p>

        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-square">
                <x-lucide-cog class="w-6 h-6 stroke-[1.5]" />
            </div>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-48">
                <li><a href="{{ route('opsi_tindakan') }}" class="text-base">Tambah Tindakan</a></li>
                <li><a href="{{ route('profile') }}" class="text-base">Pengaturan Akun</a></li>
                <li id="pwaInstallLi" style="display: none;">
                    <button type="button" id="pwaInstallButton" class="text-base flex items-center justify-between">
                        <span>Download App</span>
                        <x-lucide-download class="w-4 h-4 stroke-[1.5]" />
                    </button>
                </li>
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

<!-- PWA Install Modal -->
<dialog id="pwaInstallModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-[#eae3cd] text-[#333333] border border-[#aa8f55] shadow-xl rounded-xl">
        <h3 class="text-lg font-bold capitalize text-center text-[#aa8f55] flex items-center justify-center gap-2">
            <x-lucide-download class="w-5 h-5 stroke-[2.5]" />
            <span>Pasang Aplikasi Sioner</span>
        </h3>

        <div class="mt-4 text-sm sm:text-base space-y-4">
            <div id="pwaInstructionIOS" style="display: none;" class="space-y-3">
                <p class="text-center font-medium">Ikuti langkah mudah ini untuk memasang di Apple iOS / Safari Anda:</p>
                <ol class="list-decimal list-inside space-y-2 text-[#555555]">
                    <li>Ketuk tombol <strong>Bagikan (Share)</strong> (ikon kotak dengan panah atas <x-lucide-share class="w-4 h-4 inline stroke-[2]" />) di bilah bawah Safari.</li>
                    <li>Gulir ke bawah lalu pilih opsi <strong>Tambahkan ke Layar Utama (Add to Home Screen)</strong>.</li>
                    <li>Ketuk tombol <strong>Tambah (Add)</strong> di sudut kanan atas untuk menyelesaikan.</li>
                </ol>
            </div>
            
            <div id="pwaInstructionGeneric" style="display: none;" class="space-y-3">
                <p class="text-center font-medium">Cara memasang aplikasi ini di browser Anda:</p>
                <ol class="list-decimal list-inside space-y-2 text-[#555555]">
                    <li>Cari ikon <strong>Instal (Download App)</strong> di sebelah kanan bilah alamat (address bar) browser Anda.</li>
                    <li>Atau ketuk menu pengaturan browser (ikon titik tiga) dan pilih <strong>Instal Aplikasi (Install App / Add to Home Screen)</strong>.</li>
                </ol>
            </div>
        </div>

        <div class="modal-action flex justify-center mt-6">
            <button type="button" onclick="document.getElementById('pwaInstallModal').close()"
                class="btn bg-[#aa8f55] hover:bg-[#9a7e44] text-white shadow-md w-full">
                Mengerti
            </button>
        </div>
    </div>
</dialog>

<script>
    // Open logout modal when logout button is clicked
    document.getElementById('logoutButton').addEventListener('click', function() {
        document.getElementById('logoutModal').showModal();
    });

    // PWA Install Prompt Interceptor
    (function() {
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;
        
        if (!isStandalone) {
            const installLi = document.getElementById('pwaInstallLi');
            const installBtn = document.getElementById('pwaInstallButton');

            // Selalu tampilkan tombol Download App bila dibuka di tab browser biasa
            if (installLi) {
                installLi.style.display = 'block';
            }

            const handleInstall = async () => {
                const promptEvent = window.deferredPrompt;
                if (promptEvent) {
                    // Pemicu instalasi native (Android Chrome / PC Chrome & Edge)
                    promptEvent.prompt();
                    const { outcome } = await promptEvent.userChoice;
                    console.log(`PWA install prompt user choice: ${outcome}`);
                    window.deferredPrompt = null;
                    if (installLi) {
                        installLi.style.display = 'none';
                    }
                } else {
                    // Dukungan khusus iOS & Browser tanpa beforeinstallprompt
                    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
                    const isIOSModern = isIOS || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
                    
                    const iosDiv = document.getElementById('pwaInstructionIOS');
                    const genericDiv = document.getElementById('pwaInstructionGeneric');
                    
                    if (isIOSModern) {
                        if (iosDiv) iosDiv.style.display = 'block';
                        if (genericDiv) genericDiv.style.display = 'none';
                    } else {
                        if (iosDiv) iosDiv.style.display = 'none';
                        if (genericDiv) genericDiv.style.display = 'block';
                    }
                    
                    document.getElementById('pwaInstallModal').showModal();
                }
            };

            if (installBtn) {
                installBtn.addEventListener('click', handleInstall);
            }

            // Munculkan bila event tertangkap setelah halaman termuat
            window.addEventListener('pwa-installable', () => {
                if (installLi) {
                    installLi.style.display = 'block';
                }
            });

            window.addEventListener('appinstalled', () => {
                console.log('PWA installed successfully');
                window.deferredPrompt = null;
                if (installLi) {
                    installLi.style.display = 'none';
                }
            });
        }
    })();
</script>
