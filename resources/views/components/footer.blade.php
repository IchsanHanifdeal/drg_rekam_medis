<footer class='p-5 border-t border-b border-base-300' style="background-color: {{ $web_config->theme_colors['accent'] ?? '#A5B985' }};">
    <div class="text-center">
        <div class="container mx-auto flex justify-between items-center text-sm text-center font-semibold text-white">
            <span>{{ $web_config->alamat ?? 'default' }}</span>
            <span>Made by Ivan Hanifdeal</span>
        </div>
    </div>
</footer>