@if ($paginator->hasPages())
    {{-- Pagination Elements --}}
    @foreach ($elements as $element)

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <a href="#" class="item-pagination flex-c-m trans-0-4 active-pagination">{{ $page }}</a>
                @else
                    <a href="{{ $url }}" class="item-pagination flex-c-m trans-0-4">{{ $page }}</a>
                @endif
            @endforeach
        @endif

    @endforeach
@endif
