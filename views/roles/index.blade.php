@extends('shift::content.main')

@section('content')
	<div class="title">
		<h1>{{ trans('shift::roles.titles.main') }}</h1>
	</div>

	{{ Button::link(route('roles.new'), trans('shift::roles.titles.new'), ['type' => 'primary', 'icon' => 'plus']) }}

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
    					@include('shift::partials.page.pagination-info', ['paginator' => $roles])
    				</div>
    			</div>

				@if ($roles->count())
					<div class="row">
						<table>
							<thead>
								<tr>
									<th class="checkbox"><input type="checkbox"></th>
									<th><a href="javascript:;" sort="roles.name" class="sortable">{{ trans('shift::roles.table.columns.name') }}</a></th>
									<th># {{ trans('shift::roles.table.columns.users') }}</th>
									<th>{{ trans('shift::roles.table.columns.default') }}</th>
									<th><a href="javascript:;" sort="roles.created_at" class="sortable">{{ trans('shift::roles.table.columns.created') }}</a></th>
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
