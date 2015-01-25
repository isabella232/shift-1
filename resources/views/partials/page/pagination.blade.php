<div class="pagination">
    <select>
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>

    <ul class="horizontal">
        <li class="turn disabled" ng-class="{disabled: params.page == 1}"><a href="javascript:;" ng-click="firstPage()">«</a></li>
        <li class="turn disabled" ng-class="{disabled: params.page == 1}" ng-click="prevPage()"><a href="javascript:;">‹</a></li>
        <!-- ngRepeat: n in pages --><li class="numbered ng-scope active" ng-repeat="n in pages" ng-class="{active: n == params.page}" ng-click="setPage(n)">
            <a href="javascript:;" ng-bind="n" class="ng-binding">1</a>
        </li>
        <li class="turn disabled" ng-class="{disabled: params.page == totalPages}"><a ng-click="nextPage()" href="javascript:;">›</a></li>
        <li class="turn disabled" ng-class="{disabled: params.page == totalPages}"><a href="javascript:;" ng-click="lastPage()">»</a></li>
    </ul>
</div>