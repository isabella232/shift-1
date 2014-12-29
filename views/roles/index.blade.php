@extends('shift::content.main')

@section('breadcrumbs')
    <h1>Roles</h1>
@stop

@section('buttons')
    {{Button::link(action('Tectonic\Shift\Controllers\RoleController@getNew'), 'New role', ['type' => 'primary', 'icon' => 'plus'])}}
@stop

@section('filters')
    @include('shift::partials.page.filters')
@stop

@section('content')
    <!-- Result set -->
    <div class="container">
    	<div class="row">
    		<div class="column-full">
    			<div class="row">
    				<div class="column-two-thirds">
    					<div class="button-group">
    						<ul class="horizontal">
    							<li><span class="icon-batch-action"></span></li>
    							<li>{{Button::link(action('Tectonic\Shift\Controllers\RoleController@getNew'), 'Delete', ['size' => 'small', 'icon' => 'icon'])}}</li>
    						</ul>
    					</div>
    				</div>
    				<div class="column-third">
    					@include('shift::partials.page.pagination-info')
    				</div>
    			</div>

    			<table>
    				<thead>
    					<tr>
    						<th class="checkbox"><input type="checkbox"></th>
    						<th><a href="javascript:;" sort="roles.name" class="sortable">Name</a></th>
    						<th># Users</th>
    						<th><a href="javascript:;" sort="roles.created_at" class="sortable">Created</a></th>
    					</tr>
    				</thead>
    				<tbody>
						@foreach ($roles->getItems() as $i => $role)
							<tr @if ($i % 2 == 0) class="even"@endif>
								<td class="checkbox"><input type="checkbox"></td>
								<td><a href="{{ action('Tectonic\Shift\Controllers\RoleController@getNew@getShow', $role->slug) }}">{{ lang($role, 'name') }}</a></td>
								<!--<td></td>-->
								<td>{{ $role->createdAt }}</td>
							</tr>
						@endforeach
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