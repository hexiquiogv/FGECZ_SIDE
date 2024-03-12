    <div class="pagination overflow-auto">
        <style type="text/css">
            .noDecoration
            {
                text-decoration: none;
                width: 100%;
                font-size: calc(1.275rem + .3vw);
            }
            .noDecoration:not(.disabled):not(.current):focus, .noDecoration:not(.disabled):not(.current):hover {
              color: var(--bs-dropdown-link-hover-color);
              background-color: #f8f9fa;
            }
        </style>
        @if($expedientes->hasPages())
            @if ($expedientes->onFirstPage())
                <span class="disabled noDecoration p-2">«</span>
            @else
                <a href="{{ $expedientes->path()."?page=".($expedientes->currentPage()-1)."&".$flag."=".($expedientes->currentPage()-1) }}" class="noDecoration p-2" rel="prev">«</a>
            @endif
            @if ($expedientes->currentPage() > 3)
            <a href="{{ $expedientes->path()."?page=1&".$flag."=1" }}" class="noDecoration p-2">1</a>
                @if ($expedientes->currentPage() > 4)
                    <span class="noDecoration current p-2">...</span>
                @endif
            @endif

            @foreach (range(1, $expedientes->lastPage()) as $i)
                @if ($i >= $expedientes->currentPage() - 2 && $i <= $expedientes->currentPage() + 2)
                    @if ($i == $expedientes->currentPage())
                        <span class="noDecoration current p-2">{{ $i }}</span>
                    @else
                        <a class="noDecoration p-2" href="{{ $expedientes->path()."?page=".$i."&".$flag."=".$i }}">{{ $i }}</a>
                    @endif
                @endif
            @endforeach
            @if ($expedientes->currentPage() < $expedientes->lastPage() - 2)
                @if ($expedientes->currentPage() < $expedientes->lastPage() - 3)
                    <span class="noDecoration current p-2">...</span>
                @endif          
                <a class="noDecoration p-2" href="{{ $expedientes->path()."?page=".$expedientes->lastPage()."&".$flag."=".$expedientes->lastPage() }}">{{ $expedientes->lastPage() }}</a>
            @endif  
            @if ($expedientes->hasMorePages())
                <a href="{{ $expedientes->path()."?page=".($expedientes->currentPage()+1)."&".$flag."=".($expedientes->currentPage()+1) }}" class="noDecoration p-2" rel="next">»</a>
            @else
                <span class="noDecoration disabled p-2">»</span>
            @endif
        @endif

    </div>