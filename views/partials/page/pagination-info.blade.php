@if ($paginator->total() > 0)
    <div class="pagination-info">
        <div class="summary">
            Displaying
            <b>{!! $paginator->firstItem() !!} - {!! $paginator->lastItem() !!}</b> of <b>{!! $paginator->total() !!}</b>
        </div>
    </div>
@endif
