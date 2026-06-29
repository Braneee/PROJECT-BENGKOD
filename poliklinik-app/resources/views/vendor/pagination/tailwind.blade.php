@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between items-center w-full">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-5 py-2.5 text-sm font-semibold text-slate-400 bg-slate-50 border border-slate-200 cursor-not-allowed rounded-xl gap-2">
                <i class="fas fa-chevron-left text-xs"></i>
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-5 py-2.5 text-sm font-semibold text-primary bg-white hover:bg-primary/10 border-2 border-primary rounded-xl transition gap-2 group">
                <i class="fas fa-chevron-left text-xs group-hover:-translate-x-1 transition-transform"></i>
                Previous
            </a>
        @endif

        {{-- Page Info --}}
        <div class="text-sm font-semibold text-slate-600 flex items-center gap-2 hidden sm:flex">
            <span class="bg-primary/10 text-primary px-3 py-1 rounded-lg">
                {{ $paginator->currentPage() }} 
            </span>
            of 
            <span class="bg-primary/10 text-primary px-3 py-1 rounded-lg">
                {{ $paginator->lastPage() }}
            </span>
        </div>
        
        {{-- Mobile Page Info --}}
        <div class="text-sm font-semibold text-slate-600 flex items-center gap-1 sm:hidden">
             <span class="bg-primary/10 text-primary px-2 py-1 rounded-lg">
                {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
            </span>
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-5 py-2.5 text-sm font-semibold text-primary bg-white hover:bg-primary/10 border-2 border-primary rounded-xl transition gap-2 group">
                Next
                <i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        @else
            <span class="relative inline-flex items-center px-5 py-2.5 text-sm font-semibold text-slate-400 bg-slate-50 border border-slate-200 cursor-not-allowed rounded-xl gap-2">
                Next
                <i class="fas fa-chevron-right text-xs"></i>
            </span>
        @endif
    </nav>
@endif
