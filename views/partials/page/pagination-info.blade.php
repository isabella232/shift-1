@if ($paginator->getTotal() > 0)
    <div class="pagination-info">
        <div class="summary">
            Displaying <b class="ng-binding">{{$paginator->getFrom()}} - {{$paginator->getTo()}}</b> of <b class="ng-binding">{{$paginator->getTotal()}}</b>
        </div>
    </div>
@endif
