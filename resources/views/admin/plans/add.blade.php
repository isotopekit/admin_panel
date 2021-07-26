@extends('admin_panel::_layouts.admin')
@section('title','Add Plan')
@section('content')

	<div class="container-xl">
		<!-- Page title -->
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col">
					<div class="page-pretitle">
						Plans
					</div>
					<h2 class="page-title">
						Add Plan
					</h2>
				</div>
			</div>
		</div>
	</div>

	<div class="page-body">
		<div class="container-xl">
			<div class="row">
				<div class="col-12">

					@component('admin_panel::_layouts.components.alert')
        			@endcomponent
					
					<form action="{{ route('post_admin_plans_add') }}" method="post">
						{{ csrf_field() }}

						<div class="card mb-4" id="general">
							<div class="card-header">
								<h3 class="card-title">General</h3>
							</div>
							<div class="card-body">
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Name</label>
									<div class="col">
										<input
											type="text" name="name"
											@if($errors->has('name'))
												class="form-control is-invalid"
											@else
												class="form-control"
											@endif
											value="{{ old('name') }}"
										/>
										@if($errors->has('name'))
											<div class="invalid-feedback">{{ $errors->first('name') }}</div>
										@endif
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Price ($)</label>
									<div class="col">
										<input
											type="number" name="price" step="0.1" min="0"
											@if($errors->has('price'))
												class="form-control is-invalid"
											@else
												class="form-control"
											@endif
											value="{{ old('price') }}"
										/>
										@if($errors->has('price'))
											<div class="invalid-feedback">{{ $errors->first('price') }}</div>
										@endif
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Valid Time (in Days)</label>
									<div class="col">
										<input
											type="number" name="valid_time" min="1"
											@if($errors->has('valid_time'))
												class="form-control is-invalid"
											@else
												class="form-control"
											@endif
											value="{{ old('valid_time') }}"
										/>
										@if($errors->has('valid_time'))
											<div class="invalid-feedback">{{ $errors->first('valid_time') }}</div>
										@endif
									</div>
								</div>

								<div class="form-group mb-3 row">
									<label class="form-label col-12 col-sm-3 col-form-label">Active</label>
									<div class="col">
										<select name="enabled" id="" class="form-control">
											<option value="1">Yes</option>
											<option value="0">No</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="card mb-4" id="branding">
							<div class="card-header">
								<h3 class="card-title">Branding</h3>
							</div>
							<div class="card-body">
								<div class="form-group mb-3 row">
									<label class="form-label col-12 col-sm-3 col-form-label">Remove Branding</label>
									<div class="col">
										<select name="remove_branding" id="" class="form-control">
											<option value="1">Yes</option>
											<option value="0" selected>No</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label class="form-label col-12 col-sm-3 col-form-label">Custom Branding</label>
									<div class="col">
										<select name="custom_branding" id="" class="form-control">
											<option value="1">Yes</option>
											<option value="0" selected>No</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="card mb-4" id="team">
							<div class="card-header">
								<h3 class="card-title">Team</h3>
							</div>
							<div class="card-body">
								<div class="form-group mb-3 row">
									<label class="form-label col-12 col-sm-3 col-form-label">Enable Teams</label>
									<div class="col">
										<select name="enable_team" id="" class="form-control">
											<option value="1">Yes</option>
											<option value="0" selected>No</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Team Members</label>
									<div class="col">
										<input type="number" name="team_members" min="0" class="form-control" />
									</div>
								</div>
							</div>
						</div>

						<div class="card mb-4" id="domains">
							<div class="card-header">
								<h3 class="card-title">Custom Domains</h3>
							</div>
							<div class="card-body">
								<div class="form-group mb-3 row">
									<label class="form-label col-12 col-sm-3 col-form-label">Enable Custom Domains</label>
									<div class="col">
										<select name="enable_custom_domains" id="" class="form-control">
											<option value="1">Yes</option>
											<option value="0" selected>No</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Custom Domains</label>
									<div class="col">
										<input type="number" name="custom_domains" min="0" class="form-control" />
									</div>
								</div>
							</div>
						</div>

						<div class="card mb-4" id="agency">
							<div class="card-header">
								<h3 class="card-title">Agency Specific</h3>
							</div>
							<div class="card-body">
								<div class="form-group mb-3 row">
									<label class="form-label col-12 col-sm-3 col-form-label">Enable Agency</label>
									<div class="col">
										<select name="enable_agency" id="" class="form-control">
											<option value="1">Yes</option>
											<option value="0" selected>No</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Clients</label>
									<div class="col">
										<input type="number" min="0" name="agency_members" class="form-control" />
									</div>
								</div>

								<hr>

								<h4 class="text-muted">Team (applied to users)</h4>

								<div class="form-group mb-3 row">
									<label class="form-label col-12 col-sm-3 col-form-label">Enable Teams</label>
									<div class="col">
										<select name="agency_enable_team" id="" class="form-control">
											<option value="1">Yes</option>
											<option value="0" selected>No</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Team Members</label>
									<div class="col">
										<input type="number" name="agency_team_members" min="0" class="form-control" />
									</div>
								</div>

								<hr>

								<h4 class="text-muted">Custom Domains (applied to users)</h4>

								<div class="form-group mb-3 row">
									<label class="form-label col-12 col-sm-3 col-form-label">Enable Custom Domains</label>
									<div class="col">
										<select name="agency_enable_custom_domains" id="" class="form-control">
											<option value="1">Yes</option>
											<option value="0" selected>No</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Custom Domains</label>
									<div class="col">
										<input type="number" name="agency_custom_domains" min="0" class="form-control" />
									</div>
								</div>
							</div>
						</div>

						<div class="d-flex">
							<a href="{{ route('get_admin_plans_index') }}" class="btn btn-link">Cancel</a>
							<button type="submit" class="btn btn-success ms-auto">Save Changes</a>
						</div>
						
					</form>
				</div>

			</div>
		</div>
	</div>

@endsection