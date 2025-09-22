<style>
    .pagination {
    display: flex;
    list-style-type: none;
    padding: 0;
    justify-content: center; /* Center the pagination links */
}

.pagination li {
    margin: 0 5px; /* Space between pagination items */
}

.pagination a,
.pagination span {
    display: block;
    padding: 8px 12px;
    text-decoration: none;
    color: #007bff; /* Link color */
    border: 1px solid #ddd; /* Border color */
    border-radius: 4px;
    transition: background-color 0.2s, color 0.2s; /* Smooth transition */
}

.pagination a:hover {
    background-color: #007bff; /* Background color on hover */
    color: #fff; /* Text color on hover */
}

.pagination .active span {
    background-color: #007bff; /* Active page background */
    color: #fff; /* Active page text color */
    border-color: #007bff; /* Active page border color */
}

.pagination .disabled span {
    color: #ccc; /* Disabled link color */
    border-color: #ddd; /* Disabled border color */
    pointer-events: none; /* Disable click */
}
@media (max-width: 600px) {
    .pagination {
        flex-wrap: wrap; /* Allow pagination to wrap on small screens */
    }

    .pagination a,
    .pagination span {
        padding: 6px 10px; /* Smaller padding for mobile */
    }
}
</style>
@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif