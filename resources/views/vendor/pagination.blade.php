@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination"
        class="flex flex-wrap justify-center items-center space-x-0 md:space-x-2 mt-6 gap-y-2">
        <!-- Previous Page Link -->
        @if ($paginator->onFirstPage())
            <span class="btn btn-disabled text-white bg-neutral cursor-not-allowed text-sm md:text-base">
                Sebelumnya
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="btn text-white bg-neutral hover:bg-warning rounded-lg transition-colors text-sm md:text-base">
                Sebelumnya
            </a>
        @endif

        <!-- Pagination Elements -->
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="btn btn-warning text-white rounded-lg text-sm md:text-base">
                            {!! $page !!}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="btn text-white bg-neutral hover:bg-warning rounded-lg transition-colors text-sm md:text-base">
                            {!! $page !!}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        <!-- Next Page Link -->
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="btn text-white bg-neutral hover:bg-warning rounded-lg transition-colors text-sm md:text-base">
                Selanjutnya
            </a>
        @else
            <span class="btn btn-disabled text-white bg-neutral cursor-not-allowed text-sm md:text-base">
                Selanjutnya
            </span>
        @endif
    </nav>
@endif
