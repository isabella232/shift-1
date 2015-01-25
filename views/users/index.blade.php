@section('main')
	<div class="row island">
		<div class="column-half">
			<div class="title">
				<h1>{!! trans('users.titles.main') !!}</h1>
			</div>

			<div class="buttons">
				{!! Button::link(route('users.new'), trans('users.titles.new'), ['type' => 'primary', 'icon' => 'plus']) !!}
			</div>
		</div>
		<div class="search-pagination">
			<div class="filter-details">

			</div>

			@if ($users->count())
				@include('shift::partials.page.pagination-info', ['paginator' => $users])
			@endif
		</div>
	</div>

    <!-- Result set -->
	<div class="row">
		@if ($users->count())
			<table>
				<thead>
					<tr>
						<th class="checkbox"><input type="checkbox"></th>
						<th><a href="javascript:;" sort="users.name" class="sortable">{!! trans('users.table.columns.name') !!}</a></th>
						<th># {!! trans('users.table.columns.email') !!}</th>
						<th><a href="javascript:;" sort="users.updatedAt" class="sortable">{!! trans('users.table.columns.updated') !!}</a></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($users->items() as $i => $user)
						<tr @if ($i % 2 == 1) class="even"@endif>
							<td class="checkbox"><input type="checkbox"></td>
							<td><a href="{!! route('users.show', $user->slug) !!}">{!! HTML::fullName($user) !!}</a></td>
							<td>{!! $user->email !!}</td>
							<td>{!! HTML::relativeTime($user->updatedAt) !!}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<div class="row">
				<div class="two-thirds">
					{!! HTML::pagination($users) !!}
				</div>
			</div>
		@else
			<div>
				<p>There are currently no users, or none matching your search criteria.</p>
			</div>
		@endif
    </div>
@stop
