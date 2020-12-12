<style>
    .pagination{
       margin-left:30px
    }
</style>

@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">

                </li>
            @else
                <li class="page-item">
                </li>
            @endif

            {{-- Pagination Elements --}}

            {{-- Next Page Link --}}
        </ul>
    </nav>
@endif
