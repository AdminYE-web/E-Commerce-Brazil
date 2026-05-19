@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        @if ($paginator->onFirstPage())
            <span class="blog-page-disabled blog-page-prev">&lt; Anterior</span>
        @else
            <a class="blog-page-link blog-page-prev" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lt; Anterior</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="blog-page-ellipsis">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="blog-page-current" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="blog-page-link" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="blog-page-link blog-page-next" href="{{ $paginator->nextPageUrl() }}" rel="next">Próximo &gt;</a>
        @else
            <span class="blog-page-disabled blog-page-next">Próximo &gt;</span>
        @endif
    </nav>
@endif
