

@if ($paginator->hasPages()) 
<ul class="pagination">
      @if ($paginator->onFirstPage()) 
      <li class="paginate_button page-item previous" id="DataTables_Table_3_previous">
        <a href="#" aria-controls="DataTables_Table_3" role="link" data-dt-idx="previous" tabindex="0" class="page-link">First</a>
      </li>
      {{-- <li class="page-item disabled"> 
         <a class="page-link" href="#"
         tabindex="-1">Previous</a> 
         
      </li> --}}
      @else 
      
      <li class="page-item"><a class="page-link"
         href="{{ $paginator->previousPageUrl() }}"> 
         Previous</a> 
         
      </li>
      @endif 
      
      @foreach ($elements as $element) 
      @if (is_string($element)) 
      <li class="paginate_button page-item next disabled" id="DataTables_Table_3_next"><a href="#" aria-controls="DataTables_Table_3" role="link" data-dt-idx="next" tabindex="0" class="page-link">...</a></li>
      {{-- <li class="page-item disabled">{{ $element }}</li> --}}
      @endif 
      
      @if (is_array($element)) 
      @foreach ($element as $page => $url) 
      @if ($page == $paginator->currentPage()) 
      <li class="paginate_button page-item active"><a href="#" aria-controls="DataTables_Table_3" role="link" data-dt-idx="0" tabindex="0" class="page-link">{{ $page }}</a></li>
      {{-- <li class="page-item active"> 
         <a class="page-link">{{ $page }}</a> 
         
      </li> --}}
      @else 
      <li class="paginate_button page-item "><a href="{{ $url }}" aria-controls="DataTables_Table_3" role="link" data-dt-idx="1" tabindex="0" class="page-link">{{ $page }}</a></li>
      {{-- <li class="page-item"> 
         <a class="page-link"
         href="{{ $url }}">{{ $page }}</a> 
         
      </li> --}}
      @endif 
      @endforeach 
      @endif 
      @endforeach 
      
      @if ($paginator->hasMorePages()) 
      <li class="paginate_button page-item next " id="DataTables_Table_3_next"><a href="{{ $paginator->nextPageUrl() }}" aria-controls="DataTables_Table_3" role="link" data-dt-idx="next" tabindex="0" class="page-link">Next</a></li>
      {{-- <li class="page-item"> 
         <a class="page-link"
         href="{{ $paginator->nextPageUrl() }}" 
         rel="next">Next</a> 
         
      </li> --}}
      @else 
      
      <li class="paginate_button page-item next disabled" id="DataTables_Table_3_next"><a href="{{ $paginator->nextPageUrl() }}" aria-controls="DataTables_Table_3" role="link" data-dt-idx="next" tabindex="0" class="page-link">Next</a></li>
      @endif 
      
   </ul>
@endif