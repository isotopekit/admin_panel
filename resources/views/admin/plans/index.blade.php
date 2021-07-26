@extends('admin_panel::_layouts.admin')

@section('content')

<div class="container-xl">
	<!-- Page title -->
	<div class="page-header d-print-none">
		<div class="row align-items-center">
			<div class="col">
				<h2 class="page-title">
					Plans
				</h2>
				<div class="text-muted mt-1">Total {{ sizeof($plans) }}</div>
			</div>
			<!-- Page title actions -->
			<div class="col-auto ms-auto d-print-none">
				<div class="d-flex">
					<a href="{{ route('get_admin_plans_add') }}" class="btn btn-primary">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
							<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
							<line x1="12" y1="5" x2="12" y2="19"></line>
							<line x1="5" y1="12" x2="19" y2="12"></line>
						</svg>
						New Plan
					</a>
				</div>
			</div>
		</div>
	</div>

	<br>

	@component('admin_panel::_layouts.components.alert')
	@endcomponent

</div>

<!-- content -->
<div class="page-body">
	<div class="container-xl">
		<div class="row">

			@foreach($plans as $plan)
			<div class="col-sm-6 col-lg-3">
				<div class="card card-md">
					<div class="card-body text-center">
						<div class="text-uppercase text-muted font-weight-medium">
							{{ $plan->name }}
						</div>
						<div class="display-5 my-3">${{ $plan->price }}</div>
						<div class="my-3">
							@if($plan->enabled)
							<span class="badge bg-success">Enabled</span>
							@else
							<span class="badge bg-red">Disabled</span>
							@endif
						</div>
						<ul class="list-unstyled lh-lg">
							<li><strong>{{ $plan->valid_time }}</strong> days</li>
						</ul>
						<div class="text-center mt-4">
							<div class="btn-group w-100" role="group" aria-label="Basic example">
								<a href="{{ route('get_admin_plans_edit', $plan->id) }}" class="btn w-100">Edit</a>

								<button class="btn btn-icon" data-bs-boundary="viewport" data-bs-toggle="dropdown">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dots-vertical" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
										<circle cx="12" cy="12" r="1"></circle>
										<circle cx="12" cy="19" r="1"></circle>
										<circle cx="12" cy="5" r="1"></circle>
									</svg>
								</button>
								<div class="dropdown-menu dropdown-menu-end">
									<a class="dropdown-item" href="#">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
											<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
											<line x1="18" y1="6" x2="6" y2="18"></line>
											<line x1="6" y1="6" x2="18" y2="18"></line>
										</svg>&nbsp;Disable
									</a>
									<a class="dropdown-item text-red" href="#">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
											<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
											<line x1="4" y1="7" x2="20" y2="7"></line>
											<line x1="10" y1="11" x2="10" y2="17"></line>
											<line x1="14" y1="11" x2="14" y2="17"></line>
											<path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
											<path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
										</svg>&nbsp;Delete
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach

		</div>
	</div>
</div>

@endsection