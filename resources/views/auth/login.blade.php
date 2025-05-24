<x-main title="Login" class="p-0" full>
    <section class="min-h-screen flex items-center justify-center bg-[#eae3cd] p-4 sm:p-6 md:p-8">
        <div class="w-full max-w-sm sm:max-w-md lg:max-w-lg p-6 sm:p-8 rounded-2xl shadow-2xl border border-[#aa8f55] bg-[#eae3cd] text-[#333333]">
            <div class="w-full mb-6 flex items-center justify-center">
                <img src="{{ asset('image/logo.png') }}" alt="SDC Clinic Logo" class="w-32 sm:w-40 md:w-48 object-contain" />
            </div>

            <h1 class="text-2xl sm:text-3xl font-bold text-center mb-6">
                Selamat Datang di <br><span class="text-[#aa8f55]">SDC Clinic</span>
            </h1>

            <form action="{{ route('auth') }}" method="POST" class="space-y-4">
                @csrf

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-[#333333]">Email</span>
                    </label>
                    <input type="text" name="email" placeholder="Masukkan email"
                        class="input input-bordered w-full bg-white text-[#333333] border-[#aa8f55] focus:outline-none focus:ring-2 focus:ring-[#aa8f55] focus:border-[#aa8f55] transition-all"
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
                        class="input input-bordered w-full bg-white text-[#333333] border-[#aa8f55] focus:outline-none focus:ring-2 focus:ring-[#aa8f55] focus:border-[#aa8f55] transition-all">
                    @error('password')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn w-full bg-[#aa8f55] text-white text-lg shadow-md transition-all hover:scale-105 hover:bg-[#9a7e44]">
                    Masuk
                </button>
            </form>
        </div>
    </section>
</x-main>
