@extends('admin_panel::_layouts.admin')
@section('title','Plans Schema')
@section('content')

<div class="container-xl">
	<!-- Page title -->
	<div class="page-header d-print-none">
		<div class="row align-items-center">
			<div class="col">
				<h2 class="page-title">
					Plans Schema
				</h2>
				<small>Add additional properties for plan details</small>
			</div>
			<!-- Page title actions -->
			<div class="col-auto ms-auto d-print-none">
				<div class="btn-list">
					<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-new-property">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
							<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
							<line x1="12" y1="5" x2="12" y2="19"></line>
							<line x1="5" y1="12" x2="19" y2="12"></line>
						</svg>
						Add Property
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
			<div class="col-12">
				<div class="card">
				<table class="table table-vcenter card-table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Unique Name</th>
							<th>Type</th>
							<th>Agency Owner Enabled?</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($custom_properties as $key => $custom_property)
							<tr>
								<td>{{ $key + 1 }}</td>
								<td>{{ $custom_property->name }}</td>
								<td>{{ $custom_property->unique_name }}</td>
								<td>{{ $custom_property->type }}</td>
								<td>
									@if($custom_property->agency_enabled)
										<span class="badge bg-success">Yes</span>
									@else
										<span class="badge bg-danger">No</span>
									@endif
								</td>
								<td>
									<a href="{{ route('get_admin_plans_schema_delete', $custom_property->id) }}" class="btn btn-danger btn-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
											<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
											<line x1="4" y1="7" x2="20" y2="7"></line>
											<line x1="10" y1="11" x2="10" y2="17"></line>
											<line x1="14" y1="11" x2="14" y2="17"></line>
											<path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
											<path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
										</svg> Delete
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal modal-blur fade" id="modal-new-property" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">New Property</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('post_admin_plans_schema') }}" method="POST">
				{{ csrf_field() }}
				<div class="modal-body">
					@component('admin_panel::_layouts.components.alert')
					@endcomponent

					<div class="mb-3">
						<label class="form-label">Name</label>
						<input type="text" name="name" required placeholder="Name"
						@if($errors->has('name'))
							class="form-control is-invalid"
						@else
							class="form-control"
						@endif
						value="{{ old('name') }}"
						>
						@if($errors->has('name'))
							<div class="invalid-feedback">{{ $errors->first('name') }}</div>
						@endif
					</div>

					<div class="mb-3">
						<label class="form-label">Unique Name</label>
						<input type="text" name="unique_name" required placeholder="Unique Name"
						@if($errors->has('unique_name'))
							class="form-control is-invalid"
						@else
							class="form-control"
						@endif
						value="{{ old('unique_name') }}"
						>
						@if($errors->has('unique_name'))
							<div class="invalid-feedback">{{ $errors->first('unique_name') }}</div>
						@endif
					</div>

					<div class="mb-3">
						<label class="form-label">Type</label>
						<select name="type" required class="form-control" id="">
							<option value="int">Number</option>
							<option value="boolean">Yes / No</option>
						</select>
						@if($errors->has('type'))
						<div class="invalid-feedback">{{ $errors->first('type') }}</div>
						@endif
					</div>

					<div class="mb-3">
						<label class="form-label">Enable for Agency Owner</label>
						<select name="agency_enabled" required class="form-control" id="">
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
						@if($errors->has('agency_enabled'))
						<div class="invalid-feedback">{{ $errors->first('agency_enabled') }}</div>
						@endif
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
						Cancel
					</a>
					<button type="submit" class="btn btn-success ms-auto">
						Add
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection