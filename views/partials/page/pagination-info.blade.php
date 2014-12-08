@if ($roles->getTotal() > 0)
    <div class="pagination-info">
        <div class="summary">
            Displaying <b class="ng-binding">{{$roles->getFrom()}} - {{$roles->getTo()}}</b> of <b class="ng-binding">{{$roles->getTotal()}}</b>
        </div>
    </div>
@endif
