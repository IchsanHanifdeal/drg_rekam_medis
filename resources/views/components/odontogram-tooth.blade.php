@props([
    'number',
    'isDeciduous' => false,
])

@php
    // Basic positions for tooltips mapping
    // 1x, 2x, 5x, 6x are Maxillary (Atas)
    $isMaxillary = in_array(floor($number / 10), [1, 2, 5, 6]);
    // 1, 2, 3 are Anteroior (Depan)
    $isAnterior = in_array($number % 10, [1, 2, 3]); 
    
    // Naming surfaces
    $topName    = $isMaxillary ? ($isAnterior ? 'Labial (L)' : 'Buccal (B)') : 'Lingual (L)';
    $bottomName = $isMaxillary ? 'Palatal (P)' : ($isAnterior ? 'Labial (L)' : 'Buccal (B)');
    $centerName = $isAnterior ? 'Incisal (I)' : 'Occlusal (O)';
    
    // Mesial / Distal relative to quadrant
    $isRightSide = in_array(floor($number / 10), [1, 4, 5, 8]);
    $leftName    = $isRightSide ? 'Mesial (M)' : 'Distal (D)';
    $rightName   = $isRightSide ? 'Distal (D)' : 'Mesial (M)';
@endphp

<div 
    x-data="{
        tooth: {{ $number }},
        status: null, // e.g. 'cabut'
        surfaces: {
            top: null,
            right: null,
            bottom: null,
            left: null,
            center: null
        },
        selections: [],
        currentCondition: '',
        getSurfaceClass(surface) {
            const isSelected = this.selections.some(s => s.tooth === this.tooth && s.surface === surface);
            
            if (isSelected) {
                if (this.currentCondition === 'karies') return 'fill-error/80 text-error stroke-error-content stroke-[5px] drop-shadow-md';
                if (this.currentCondition === 'restorasi') return 'fill-warning/80 text-warning stroke-warning-content stroke-[5px] drop-shadow-md';
                if (this.currentCondition === 'cabut') return 'fill-info/80 text-info stroke-info-content stroke-[5px] drop-shadow-md';
                if (this.currentCondition === 'lainnya') return 'fill-neutral/80 text-neutral stroke-neutral-content stroke-[5px] drop-shadow-md';
                return 'fill-emerald-400/50 text-emerald-600 stroke-emerald-500 stroke-[5px] drop-shadow-md';
            }

            const state = this.surfaces[surface];
            if (state === 'karies') return 'fill-error/80 text-error stroke-error-content hover:fill-error/80';
            if (state === 'restorasi') return 'fill-warning/80 text-warning stroke-warning-content hover:fill-warning/80';
            if (state === 'cabut') return 'fill-info/80 text-info stroke-info-content hover:fill-info/80';
            if (state === 'lainnya') return 'fill-neutral/80 text-neutral stroke-neutral-content hover:fill-neutral/80';
            return 'fill-transparent text-base-300 hover:fill-emerald-400/20';
        },
        toggleSurface(surface, event) {
            // Emit event so the parent page can handle form actions
            $dispatch('tooth-surface-clicked', { 
                tooth: this.tooth, 
                surface: surface,
                surfaceName: event.target.getAttribute('data-surface-name')
            });
        },
        updateData(data) {
            this.status = null;
            this.surfaces = { top: null, right: null, bottom: null, left: null, center: null };
            
            if (data && data[this.tooth]) {
                data[this.tooth].forEach(item => {
                    if (item.condition_code === 'cabut') {
                        this.status = 'cabut';
                    } else {
                        if (['top', 'right', 'bottom', 'left', 'center'].includes(item.surface)) {
                            this.surfaces[item.surface] = item.condition_code;
                        }
                    }
                });
            }
        },
        updateSelections(selections) {
            this.selections = selections || [];
        },
        updateCondition(condition) {
            this.currentCondition = condition;
        }
    }"
    @odontogram-loaded.window="updateData($event.detail)"
    @tooth-selection-changed.window="updateSelections($event.detail)"
    @condition-code-changed.window="updateCondition($event.detail)"
    class="flex flex-col items-center gap-1.5 group w-full"
    x-bind:class="{'opacity-50 grayscale': status === 'cabut' || (selections.some(s => s.tooth === tooth) && currentCondition === 'cabut')}"
>
    {{-- Nomor Gigi --}}
    <span class="text-[11px] sm:text-xs font-bold tracking-wider transition-all duration-300 group-hover:text-primary group-hover:scale-125 px-2 py-0.5 rounded {{ $isDeciduous ? 'bg-cyan-950/90 text-cyan-300 border border-cyan-800' : 'bg-slate-800/90 text-white border border-slate-700 shadow-sm' }}">
        {{ $number }}
    </span>

    {{-- Ikon Gigi SVG Kompleks --}}
    <div class="relative w-10 h-10 sm:w-[46px] sm:h-[46px] transition-transform duration-300 group-hover:scale-[1.05]">
        <svg fill="none" viewBox="0 0 100 100" class="w-full h-full tooth-diagram select-none overflow-visible drop-shadow-sm">
            
            {{-- Background Base Square --}}
            <rect x="5" y="5" width="90" height="90" rx="10" ry="10" 
                  fill="#ffffff" 
                  stroke="currentColor" 
                  class="text-base-200 stroke-[4px] shadow-sm transition-all duration-300" />

            {{-- Top Surface --}}
            <path d="M 14 14 H 86 L 68 32 H 32 Z" 
                  stroke="currentColor" 
                  stroke-linejoin="round"
                  data-surface-name="{{ $topName }}"
                  class="surface stroke-base-300 stroke-[3px] cursor-pointer transition-colors duration-200"
                  x-bind:class="getSurfaceClass('top')"
                  @click="toggleSurface('top', $event)">
                <title>{{ $topName }}</title>
            </path>

            {{-- Right Surface --}}
            <path d="M 86 14 V 86 L 68 68 V 32 Z" 
                  stroke="currentColor" 
                  stroke-linejoin="round"
                  data-surface-name="{{ $rightName }}"
                  class="surface stroke-base-300 stroke-[3px] cursor-pointer transition-colors duration-200"
                  x-bind:class="getSurfaceClass('right')"
                  @click="toggleSurface('right', $event)">
                <title>{{ $rightName }}</title>
            </path>

            {{-- Bottom Surface --}}
            <path d="M 86 86 H 14 L 32 68 H 68 Z" 
                  stroke="currentColor" 
                  stroke-linejoin="round"
                  data-surface-name="{{ $bottomName }}"
                  class="surface stroke-base-300 stroke-[3px] cursor-pointer transition-colors duration-200"
                  x-bind:class="getSurfaceClass('bottom')"
                  @click="toggleSurface('bottom', $event)">
                <title>{{ $bottomName }}</title>
            </path>

            {{-- Left Surface --}}
            <path d="M 14 86 V 14 L 32 32 V 68 Z" 
                  stroke="currentColor" 
                  stroke-linejoin="round"
                  data-surface-name="{{ $leftName }}"
                  class="surface stroke-base-300 stroke-[3px] cursor-pointer transition-colors duration-200"
                  x-bind:class="getSurfaceClass('left')"
                  @click="toggleSurface('left', $event)">
                <title>{{ $leftName }}</title>
            </path>

            {{-- Center Surface --}}
            <rect x="32" y="32" width="36" height="36" rx="4" ry="4" 
                  stroke="currentColor" 
                  data-surface-name="{{ $centerName }}"
                  class="surface stroke-base-300 stroke-[3px] cursor-pointer transition-colors duration-200"
                  x-bind:class="getSurfaceClass('center')"
                  @click="toggleSurface('center', $event)">
                <title>{{ $centerName }}</title>
            </rect>

            {{-- Nomor Gigi di Tengah (Sangat Jelas & Kontras) --}}
            <text x="50" y="52" 
                  text-anchor="middle" 
                  dominant-baseline="middle" 
                  font-size="18" 
                  font-weight="bold"
                  fill="#334155" 
                  class="font-mono font-bold pointer-events-none select-none">
                {{ $number }}
            </text>

            {{-- Cross indicator for missing/cabut --}}
            <g x-show="status === 'cabut' || (selections.some(s => s.tooth === tooth) && currentCondition === 'cabut')" style="display: none;" class="pointer-events-none">
                <path d="M 20 20 L 80 80 M 80 20 L 20 80" 
                      stroke="currentColor" 
                      stroke-linecap="round"
                      class="text-info stroke-[10] opacity-90 drop-shadow-md" />
            </g>
        </svg>
    </div>
</div>
