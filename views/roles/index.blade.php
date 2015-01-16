@section('main')
	<div class="row island">
		<div class="column-half">
			<div class="title">
				<h1>{!! trans('roles.titles.main') !!}</h1>
			</div>

			<div class="buttons">
				{!! Button::link(route('roles.new'), trans('roles.titles.new'), ['type' => 'primary', 'icon' => 'plus']) !!}
			</div>
		</div>
		<div class="search-pagination">
			<div class="filter-details"></div>
		</div>
	</div>

	@include('shift::partials.errors.display')

	<div class="row">
		@if ($roles->count())
			<table>
				<thead>
					<tr>
						<th class="checkbox"><input type="checkbox"></th>
						<th><a href="javascript:;" sort="roles.name" class="sortable">{!! trans('roles.table.columns.name') !!}</a></th>
						<th># {!! trans('roles.table.columns.users') !!}</th>
						<th>{!! trans('roles.table.columns.default') !!}</th>
						<th><a href="javascript:;" sort="roles.updatedAt" class="sortable">{!! trans('roles.table.columns.updated') !!}</a></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($roles->items() as $i => $role)
						<tr @if ($i % 2 == 1) class="even"@endif>
							<td class="checkbox"><input type="checkbox"></td>
							<td><a href="{!! route('roles.show', $role->slug) !!}">{!! lang($role, 'name') !!}</a></td>
							<td>TBI</td>
							<td>{!! $role->default ? 'Yes' : 'No' !!}</td>
							<td>{!! HTML::relativeTime($role->updatedAt) !!}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<div class="row">
				<div class="two-thirds">
					{!! HTML::pagination($roles) !!}
				</div>
			</div>
		@else
			<div>
				<p>There are currently no roles, or none matching your search criteria.</p>
			</div>
		@endif
    </div>
@stop
