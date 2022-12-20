@if ($paginator->hasPages())
   <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
         {{-- Previous Page Link --}}
         @if ($paginator->onFirstPage())
            <li class="page-item disabled mr-2"><a class="page-link">Previous</a></li>
         @else
            <li class="page-item mr-2"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a></li>
         @endif

         @if($paginator->currentPage() > 3)
            <li class="hidden-xs mr-2"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
         @endif
         @if($paginator->currentPage() > 4)
            <li class="page-item mr-2"><a class="page-link">...</a></li>
         @endif
         @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                  @if ($i == $paginator->currentPage())
                     <li class="page-item active mr-2"><a class="page-link">{{ $i }}</a></li>
                  @else
                     <li class="page-item mr-2"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                  @endif
            @endif
         @endforeach
         @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="page-item mr-2"><a class="page-link">...</a></li>
         @endif
         @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item hidden-xs mr-2"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
         @endif

         {{-- Next Page Link --}}
         @if ($paginator->hasMorePages())
            <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
         @else
            <li class="page-item disabled"><a class="page-link">Next</a></li>
         @endif
      </ul>
   </nav>
@endif
