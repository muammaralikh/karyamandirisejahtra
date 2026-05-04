@if ($paginator->hasPages())
    <ul class="pagination pagination-sm mb-0">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="Previous">
                <span class="page-link" aria-hidden="true">&laquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous">&laquo;</a>
            </li>
        @endif

        @php
            $lastPage = $paginator->lastPage();
            $currentPage = $paginator->currentPage();
            $maxPages = 5;
            $start = max(1, min($currentPage - 2, $lastPage - ($maxPages - 1)));
            $end = min($lastPage, $start + ($maxPages - 1));
        @endphp

        @if ($start > 1)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>
            @if ($start > 2)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($start - 1) }}" aria-label="More pages">&hellip;</a>
                </li>
            @endif
        @endif

        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $currentPage)
                <li class="page-item active" aria-current="page">
                    <span class="page-link">{{ $page }}</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                </li>
            @endif
        @endfor

        @if ($end < $lastPage)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($end + 1) }}" aria-label="More pages">&hellip;</a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next">&raquo;</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="Next">
                <span class="page-link" aria-hidden="true">&raquo;</span>
            </li>
        @endif
    </ul>
@endif
