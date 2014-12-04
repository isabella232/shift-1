@extends('shift::content.main')

@section('breadcrumbs')
    <h1>Roles</h1>
@stop

@section('buttons')
    <a class="primary big button icon" href="/roles/new/" permissions="create:Role" behaviour="hide" icon="plus">
        <span class="icon icon-plus"></span><span>New role</span>
    </a>
@stop

@section('filters')
    @include('shift::partials.page.filters')
@stop

@section('content')
    <!-- New role button -->
    <div class="container">
        <div class="row island">

        </div>
    </div>

    <!-- Result set -->
    <div class="container ng-scope">
    	<div class="row">
    		<div class="column-full">
    			<div class="row">
    				<div class="column-two-thirds">
    					<div class="button-group">
    						<ul class="horizontal">
    							<li><span class="icon-batch-action"></span></li>
    							<li><a class="small button icon" href="javascript:;" allowed="delete()" permissions="delete:Role">
    	<span ng-class="icon" ng-show="icon" style="display: none;"></span><span ng-transclude=""><span class="ng-scope">Delete</span></span>
    </a></li>
    						</ul>
    					</div>
    				</div>
    				<div class="column-third">
    					<div pagination-info=""><div class="pagination-info" ng-show="total">
    	<div class="summary">Displaying <b class="ng-binding">1 - 5</b> of <b class="ng-binding">5</b></div>
    </div></div>
    				</div>
    			</div>

    			<table>
    				<thead>
    					<tr>
    						<th class="checkbox"><input type="checkbox" ng-click="markAll()"></th>
    						<th><a href="javascript:;" sort="roles.name" class="sortable">Name</a></th>
    						<th><a href="javascript:;" sort="roles.name" class="sortable"># Users</a></th>
    						<th><a href="javascript:;" sort="roles.created_at" class="sortable">Created</a></th>
    					</tr>
    				</thead>
    				<tbody>
    					<!-- ngRepeat: role in roles.results --><tr ng-repeat="role in roles.results" ng-class-even="'even'" class="ng-scope">
    						<td class="checkbox"><input type="checkbox" name="" id="" ng-model="role.marked" class="ng-pristine ng-valid"></td>
    						<td><span ng-hide="hideUnauth" link="" permissions="update:Role" href="/roles/5">
    	<a ng-href="/roles/5" class="" ng-show="showLink" href="/roles/5">
    		<span ng-transclude=""><span class="ng-scope ng-binding">Convenor</span></span>
    	</a>
    	<span ng-hide="showLink" ng-transclude="" style="display: none;"><span class="ng-scope ng-binding">Convenor</span></span>
    </span></td>
    						<td class="ng-binding">2</td>
    						<td class="ng-binding">2 months ago</td>
    					</tr><tr ng-repeat="role in roles.results" ng-class-even="'even'" class="ng-scope even">
    						<td class="checkbox"><input type="checkbox" name="" id="" ng-model="role.marked" class="ng-pristine ng-valid"></td>
    						<td><span ng-hide="hideUnauth" link="" permissions="update:Role" href="/roles/4">
    	<a ng-href="/roles/4" class="" ng-show="showLink" href="/roles/4">
    		<span ng-transclude=""><span class="ng-scope ng-binding">Chapter convenor</span></span>
    	</a>
    	<span ng-hide="showLink" ng-transclude="" style="display: none;"><span class="ng-scope ng-binding">Chapter convenor</span></span>
    </span></td>
    						<td class="ng-binding">0</td>
    						<td class="ng-binding">2 months ago</td>
    					</tr><tr ng-repeat="role in roles.results" ng-class-even="'even'" class="ng-scope">
    						<td class="checkbox"><input type="checkbox" name="" id="" ng-model="role.marked" class="ng-pristine ng-valid"></td>
    						<td><span ng-hide="hideUnauth" link="" permissions="update:Role" href="/roles/3">
    	<a ng-href="/roles/3" class="" ng-show="showLink" href="/roles/3">
    		<span ng-transclude=""><span class="ng-scope ng-binding">Judge</span></span>
    	</a>
    	<span ng-hide="showLink" ng-transclude="" style="display: none;"><span class="ng-scope ng-binding">Judge</span></span>
    </span></td>
    						<td class="ng-binding">6</td>
    						<td class="ng-binding">2 months ago</td>
    					</tr><tr ng-repeat="role in roles.results" ng-class-even="'even'" class="ng-scope even">
    						<td class="checkbox"><input type="checkbox" name="" id="" ng-model="role.marked" class="ng-pristine ng-valid"></td>
    						<td><span ng-hide="hideUnauth" link="" permissions="update:Role" href="/roles/2">
    	<a ng-href="/roles/2" class="" ng-show="showLink" href="/roles/2">
    		<span ng-transclude=""><span class="ng-scope ng-binding">Entrant</span></span>
    	</a>
    	<span ng-hide="showLink" ng-transclude="" style="display: none;"><span class="ng-scope ng-binding">Entrant</span></span>
    </span></td>
    						<td class="ng-binding">8</td>
    						<td class="ng-binding">2 months ago</td>
    					</tr><tr ng-repeat="role in roles.results" ng-class-even="'even'" class="ng-scope">
    						<td class="checkbox"><input type="checkbox" name="" id="" ng-model="role.marked" class="ng-pristine ng-valid"></td>
    						<td><span ng-hide="hideUnauth" link="" permissions="update:Role" href="/roles/1">
    	<a ng-href="/roles/1" class="" ng-show="showLink" href="/roles/1">
    		<span ng-transclude=""><span class="ng-scope ng-binding">Tectician</span></span>
    	</a>
    	<span ng-hide="showLink" ng-transclude="" style="display: none;"><span class="ng-scope ng-binding">Tectician</span></span>
    </span></td>
    						<td class="ng-binding">0</td>
    						<td class="ng-binding">2 months ago</td>
    					</tr>
    				</tbody>
    			</table>

    			<div pagination=""><div class="pagination">
    	<select ng-model="params.per_page" ng-change="update()" class="ng-pristine ng-valid">
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
    </div>

    			<div ng-hide="roles.results.length" style="display: none;">
    				<p>There are currently no roles, or none matching your search criteria.</p>
    			</div>
    		</div>
    	</div>
    </div>
@stop