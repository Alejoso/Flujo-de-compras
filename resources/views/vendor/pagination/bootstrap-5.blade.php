@if ($paginator->hasPages())
    <nav class="d-flex flex-column align-items-center gap-2">
        <p class="small text-muted mb-0">
            {{ __('messages.pagination_showing') }} <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
            {{ __('messages.pagination_to') }} <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
            {{ __('messages.pagination_of') }} <span class="fw-semibold">{{ $paginator->total() }}</span> {{ __('messages.pagination_results') }}
        </p>

        <ul class="pagination mb-0">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
