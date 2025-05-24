<x-dashboard.main title="Profile">
    <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-5 md:gap-6">
        @foreach (['waktu', 'role', 'terakhir_login', 'register'] as $type)
            <div class="flex items-center px-4 py-3 bg-white border-back rounded-xl">
                <span
                    class="
                  {{ $type == 'waktu' ? 'bg-blue-300' : '' }}
                  {{ $type == 'role' ? 'bg-green-300' : '' }}
                  {{ $type == 'terakhir_login' ? 'bg-rose-300' : '' }}
                  {{ $type == 'register' ? 'bg-amber-300' : '' }}
                  p-3 mr-4 text-gray-700 rounded-full"></span>
                <div>
                    <p class="text-sm font-medium capitalize text-gray-600 line-clamp-1">
                        {{ str_replace('_', ' ', $type) }}
                    </p>
                    <p id="{{ $type }}" class="text-lg uppercase font-semibold text-gray-700 line-clamp-1">
                        {{ $type == 'waktu' ? '0' : '' }}
                        {{ $type == 'role' ? Auth::user()->role : '' }}
                        {{ $type == 'terakhir_login' ? Session::get('login_time', 'Belum pernah login') : '' }}
                        {{ $type == 'register' ? Auth::user()->created_at : '' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="flex flex-col lg:flex-row gap-5">
        <div class="flex flex-col gap-5 p-5 sm:p-7 bg-white border-back rounded-xl w-full">
            <div class="flex gap-5 border-b pb-7">
                <div class="flex flex-col items-center gap-3 h-fit">

                    <!-- Foto Profil -->
                    <div class="w-24 h-24 rounded-xl overflow-hidden border-2 border-gray-300 relative group">
                        <img id="profile_preview"
                            src="{{ Auth::user()->photo_profile ? asset('storage/' . Auth::user()->photo_profile) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                            alt="Profile Photo"
                            class="w-full h-full object-cover rounded-xl transition duration-300 group-hover:opacity-80" />
                    </div>

                    <!-- Role Badge -->
                    <span class="badge badge-sm font-medium uppercase bg-[#E7F1A8] text-black">
                        {{ Auth::user()->role }}
                    </span>
                    </form>

                </div>
                <div>
                    <h1 class="flex items-start gap-3 lowercase line-clamp-1 font-semibold font-[onest] sm:text-lg">
                        {{-- name --}}
                        {{ '@' . Auth::user()->name }}
                    </h1>
                    <p class="text-sm opacity-60 line-clamp-1">
                        {{ Auth::user()->email }}
                    </p>
                    <div class="mt-3">
                        <div>
                            <h1 class="text-sm font-semibold">Nama Panggilan:</h1>
                            <p class="text-sm opacity-60 line-clamp-1">
                                {{ Auth::user()->name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <form class="flex flex-col gap-4" method="POST"
                action="{{ route('update.profile', ['id' => Auth::user()->id]) }}">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div class="flex flex-col gap-1">
                    <label for="nama" class="text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <input id="nama" name="nama" type="text" placeholder="Nama Lengkap"
                        value="{{ Auth::user()->name }}"
                        class="input w-full rounded-lg bg-gray-100 border-2 border-gray-300 p-3 focus:outline-none focus:border-[#E7F1A8] transition duration-200"
                        required />
                    @error('nama')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Username -->
                {{-- <div class="flex flex-col gap-1">
                    <label for="name" class="text-sm font-semibold text-gray-700">Asal Negara</label>
                    <input id="name" name="name" type="text" placeholder="name"
                        value="{{ Auth::user()->name }}"
                        class="input w-full rounded-lg bg-gray-100 border-2 border-gray-300 p-3 focus:outline-none focus:border-[#E7F1A8] transition duration-200 cursor-not-allowed"
                        required readonly />
                    @error('name')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div> --}}

                <!-- Email (Read-Only) -->
                <div class="flex flex-col gap-1">
                    <label for="email" class="text-sm font-semibold text-gray-700">Email</label>
                    <input id="email" type="email" placeholder="Email" value="{{ Auth::user()->email }}" disabled
                        class="input w-full rounded-lg bg-gray-200 border-2 border-gray-300 p-3 cursor-not-allowed focus:outline-none" />
                </div>

                <button type="submit"
                    class="btn bg-[#E7F1A8] text-black font-semibold rounded-lg p-3 mt-4 hover:bg-yellow-400 transition duration-200">
                    Update Profile
                </button>
            </form>

        </div>
        <div class="flex flex-col gap-5 p-5 sm:p-7 bg-white border-back rounded-xl w-full h-fit">
            <form class="flex flex-col gap-4" method="POST"
                action="{{ route('update.password', ['id' => Auth::user()->id]) }}">
                @csrf
                @method('PUT')

                <!-- Password Lama -->
                <div class="flex flex-col gap-1">
                    <label for="password_lama" class="text-sm font-semibold text-gray-700">Password Lama</label>
                    <input id="password_lama" name="password_lama" type="password" placeholder="Password Lama"
                        class="input w-full rounded-lg bg-gray-100 border-2 border-gray-300 p-3 focus:outline-none focus:border-[#E7F1A8] transition duration-200"
                        required />
                    @error('password_lama')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Baru -->
                <div class="flex flex-col gap-1">
                    <label for="password_baru" class="text-sm font-semibold text-gray-700">Password Baru</label>
                    <input id="password_baru" name="password_baru" type="password" placeholder="Password Baru"
                        class="input w-full rounded-lg bg-gray-100 border-2 border-gray-300 p-3 focus:outline-none focus:border-[#E7F1A8] transition duration-200"
                        required />
                    @error('password_baru')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="flex flex-col gap-1">
                    <label for="konfirmasi_password_baru" class="text-sm font-semibold text-gray-700">Konfirmasi
                        Password Baru</label>
                    <input id="konfirmasi_password_baru" name="konfirmasi_password_baru" type="password"
                        placeholder="Konfirmasi Password Baru"
                        class="input w-full rounded-lg bg-gray-100 border-2 border-gray-300 p-3 focus:outline-none focus:border-[#E7F1A8] transition duration-200"
                        required />
                    @error('konfirmasi_password_baru')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="btn bg-[#E7F1A8] text-black font-semibold rounded-lg p-3 mt-4 hover:bg-yellow-400 transition duration-200">
                    Update Password
                </button>
            </form>

        </div>
    </div>
</x-dashboard.main>

<script>
    setInterval(() => {
        document.getElementById('waktu')
            .innerText = dayjs().format('HH:mm:ss DD/MM/YY')
    }, 1000);
</script>
