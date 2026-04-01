<x-main title="{{ $title }}" class="!p-0" full>
    <div class="drawer lg:drawer-open">
        <input id="aside-dashboard" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            @include('components.dashboard.navbar')
            
            <div class="p-4 md:p-6 flex-1" style="background-color: {{ $web_config->theme_colors['primary'] ?? '#A5B985' }};">
                <div class="flex flex-col gap-6">
                    @if (session('success'))
                        <div role="alert" class="alert alert-success shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div role="alert" class="alert alert-error shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-warning shadow-lg mb-4">
                            <ul class="list-disc ml-5">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm font-bold">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </div>
            
            @include('components.footer')
        </div>
        @include('components.dashboard.aside')
    </div>
</x-main>