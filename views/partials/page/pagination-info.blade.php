@if ($paginator->getTotal() > 0)
    <div class="pagination-info">
        <div class="summary">
            Displaying
            <b>{!! $roles->getFrom() !!} - {!! $roles->getTo() !!}</b> of <b>{!! $roles->getTotal() !!}</b>
        </div>
    </div>
@endif
