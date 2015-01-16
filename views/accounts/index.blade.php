@section('main')
	<div class="row island">
		<div class="column-half">
			<div class="title">
				<h1>{!! trans('accounts.titles.main') !!}</h1>
			</div>

			<div class="buttons">
				{!! Button::link(route('accounts.new'), trans('accounts.titles.new'), ['type' => 'primary', 'icon' => 'plus']) !!}
			</div>
		</div>
		<div class="search-pagination">
			<div class="filter-details">

			</div>

			@if ($accounts->count())
				@include('partials.page.pagination-info', ['paginator' => $accounts])
			@endif
		</div>
	</div>

	<!-- Result set -->
	<div class="row">
		@if ($accounts->count())
			<table>
				<thead>
					<tr>
						<th class="checkbox"><input type="checkbox"></th>
						<th><a href="javascript:;" sort="accounts.name" class="sortable">{!! trans('accounts.table.columns.name') !!}</a></th>
						<th>{!! trans('accounts.table.columns.domain') !!}</th>
						<th>{!! trans('accounts.table.columns.owner') !!}</th>
						<th><a href="javascript:;" sort="accounts.updatedAt" class="sortable">{!! trans('accounts.table.columns.updated') !!}</a></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($accounts->getItems() as $i => $account)
						<tr @if ($i % 2 == 1) class="even"@endif>
							<td class="checkbox"><input type="checkbox"></td>
							<td><a href="{!! route('accounts.show', $account->slug) !!}">{!! lang($account, 'name') !!}</a></td>
							<td>{!! $account->domains->first()->domain !!}</td>
							<td>
								@if ($account->owner)
									{!! $account->owner->firstName.' '.$account->owner->lastName !!}
								@else
									No owner assigned
								@endif
							</td>
							<td>{!! HTML::relativeTime($account->updatedAt) !!}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<div class="row">
				<div class="two-thirds">
					{!! HTML::pagination($accounts) !!}
				</div>
			</div>
		@else
			<div>
				<p>There are currently no accounts, or none matching your search criteria.</p>
			</div>
		@endif
	</div>
@stop
