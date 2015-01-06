@extends('shift::content.main')

@section('breadcrumbs')
    <h1>Roles</h1>
@stop

@section('buttons')
    {{ Button::link(action('Tectonic\Shift\Controllers\RoleController@getNew'), 'New role', ['type' => 'primary', 'icon' => 'plus']) }}
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
    							<li>{{ Button::link(route('roles.new'), 'Delete', ['size' => 'small', 'icon' => 'icon']) }}</li>
    						</ul>
    					</div>
    				</div>
    				<div class="column-third">
    					@include('shift::partials.page.pagination-info')
    				</div>
    			</div>

				@if ($roles->count())
					<div class="row">
						<table>
							<thead>
								<tr>
									<th class="checkbox"><input type="checkbox"></th>
									<th><a href="javascript:;" sort="roles.name" class="sortable">Name</a></th>
									<th># Users</th>
									<th>Default</th>
									<th><a href="javascript:;" sort="roles.created_at" class="sortable">Created</a></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($roles->getItems() as $i => $role)
									<tr @if ($i % 2 == 1) class="even"@endif>
										<td class="checkbox"><input type="checkbox"></td>
										<td><a href="{{ route('roles.show', $role->slug) }}">{{ lang($role, 'name') }}</a></td>
										<td>TBI</td>
										<td>{{ $role->default ? 'Yes' : 'No' }}</td>
										<td>{{ HTML::relativeTime($role->createdAt) }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<div class="row">
						<div class="two-thirds">
							{{ HTML::pagination($roles) }}
						</div>
					</div>
				@else
					<div>
						<p>There are currently no roles, or none matching your search criteria.</p>
					</div>
				@endif
    		</div>
    	</div>
    </div>
@stop
