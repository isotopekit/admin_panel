@extends('admin_panel::_layouts.admin')
@section('title','Edit Plan')
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
						{{ $plan->name }}
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
					
					<form action="{{ route('post_admin_plans_edit', $plan->id) }}" method="post">
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
											type="text" name="name" required
											@if($errors->has('name'))
												class="form-control is-invalid"
											@else
												class="form-control"
											@endif
											value="{{ old('name', $plan->name) }}"
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
											type="number" name="price" step="0.1" min="0" required
											@if($errors->has('price'))
												class="form-control is-invalid"
											@else
												class="form-control"
											@endif
											value="{{ old('price', $plan->price) }}"
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
											type="number" name="valid_time" min="1" required
											@if($errors->has('valid_time'))
												class="form-control is-invalid"
											@else
												class="form-control"
											@endif
											value="{{ old('valid_time', $plan->valid_time) }}"
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
											<option value="1" {{ old('enabled', $plan->enabled) == 1 ? "selected": "" }}>Yes</option>
											<option value="0" {{ old('enabled', $plan->enabled) == 0 ? "selected": "" }}>No</option>
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
											<option value="1" {{ old('remove_branding', $plan->remove_branding) == 1 ? "selected": "" }}>Yes</option>
											<option value="0" {{ old('remove_branding', $plan->remove_branding) == 0 ? "selected": "" }}>No</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label class="form-label col-12 col-sm-3 col-form-label">Custom Branding</label>
									<div class="col">
										<select name="custom_branding" id="" class="form-control">
											<option value="1" {{ old('custom_branding', $plan->custom_branding) == 1 ? "selected": "" }}>Yes</option>
											<option value="0" {{ old('custom_branding', $plan->custom_branding) == 0 ? "selected": "" }}>No</option>
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
											<option value="1" {{ old('enable_team', $plan->enable_team) == 1 ? "selected": "" }}>Yes</option>
											<option value="0" {{ old('enable_team', $plan->enable_team) == 0 ? "selected": "" }}>No</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Team Members</label>
									<div class="col">
										<input type="number" name="team_members" min="0" class="form-control" value="{{ old('team_members', $plan->team_members) }}" />
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
											<option value="1" {{ old('enable_custom_domains', $plan->enable_custom_domains) == 1 ? "selected": "" }}>Yes</option>
											<option value="0" {{ old('enable_custom_domains', $plan->enable_custom_domains) == 0 ? "selected": "" }}>No</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Custom Domains</label>
									<div class="col">
										<input type="number" name="custom_domains" min="0" class="form-control" value="{{ old('custom_domains', $plan->custom_domains) }}"/>
									</div>
								</div>
							</div>
						</div>

						<div class="card mb-4" id="domains">
							<div class="card-header">
								<h3 class="card-title">Custom Properties</h3>
							</div>
							<div class="card-body">
								@foreach($custom_properties as $custom_property)
									<div class="form-group mb-3 row">
										<label for="" class="form-label col-12 col-sm-3 col-form-label">{{ $custom_property->name }}</label>
										<div class="col">
											<input type="hidden" name="custom_properties_id[]" value="{{ $custom_property->id }}"/>
											<?php
												$item_val = 0;
												$array_utility = new \IsotopeKit\Utility\ArrayUtils();
												$search_in_array = $array_utility->objArraySearch(json_decode($plan->custom_properties), "id", $custom_property->id);
												if($search_in_array)
												{
													$item_val = $search_in_array->value;
												}
											?>
											@if($custom_property->type == "int")
												<input type="number" name="custom_properties_value[]" min="0" class="form-control" value="{{ $item_val }}"/>
											@else
												<select name="custom_properties_value[]" class="form-control">
													<option value="0" @if($item_val == 0) selected @endif>No</option>
													<option value="1" @if($item_val == 1) selected @endif>Yes</option>
												</select>
											@endif
										</div>
									</div>
								@endforeach
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
											<option value="1" {{ old('enable_agency', $plan->enable_agency) == 1 ? "selected": "" }}>Yes</option>
											<option value="0" {{ old('enable_agency', $plan->enable_agency) == 0 ? "selected": "" }}>No</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Clients</label>
									<div class="col">
										<input type="number" min="0" name="agency_members" class="form-control" value="{{ old('agency_members', $plan->agency_members) }}"/>
									</div>
								</div>

								<hr>

								<h4 class="text-muted">Team (applied to users)</h4>

								<div class="form-group mb-3 row">
									<label class="form-label col-12 col-sm-3 col-form-label">Enable Teams</label>
									<div class="col">
										<select name="agency_enable_team" id="" class="form-control">
											<option value="1" {{ old('agency_enable_team', $plan->agency_enable_team) == 1 ? "selected": "" }}>Yes</option>
											<option value="0" {{ old('agency_enable_team', $plan->agency_enable_team) == 0 ? "selected": "" }}>No</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Team Members</label>
									<div class="col">
										<input type="number" name="agency_team_members" min="0" class="form-control" value="{{ old('agency_team_members', $plan->agency_team_members) }}"/>
									</div>
								</div>

								<hr>

								<h4 class="text-muted">Custom Domains (applied to users)</h4>

								<div class="form-group mb-3 row">
									<label class="form-label col-12 col-sm-3 col-form-label">Enable Custom Domains</label>
									<div class="col">
										<select name="agency_enable_custom_domains" id="" class="form-control">
											<option value="1" {{ old('agency_enable_custom_domains', $plan->agency_enable_custom_domains) == 1 ? "selected": "" }}>Yes</option>
											<option value="0" {{ old('agency_enable_custom_domains', $plan->agency_enable_custom_domains) == 0 ? "selected": "" }}>No</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 row">
									<label for="" class="form-label col-12 col-sm-3 col-form-label">Custom Domains</label>
									<div class="col">
										<input type="number" name="agency_custom_domains" min="0" class="form-control" value="{{ old('agency_custom_domains', $plan->agency_custom_domains) }}"/>
									</div>
								</div>

								<hr>

								<h4 class="text-muted">Custom Properties</h4>
								@foreach($custom_properties as $custom_property)
									@if($custom_property->agency_enabled)
									<div class="form-group mb-3 row">
										<label for="" class="form-label col-12 col-sm-3 col-form-label">{{ $custom_property->name }}</label>
										<div class="col">
											<input type="hidden" name="agency_custom_properties_id[]" value="{{ $custom_property->id }}"/>
											<?php
												$agency_item_val = 0;
												$agency_array_utility = new \IsotopeKit\Utility\ArrayUtils();
												$agency_search_in_array = $agency_array_utility->objArraySearch(json_decode($plan->agency_custom_properties), "id", $custom_property->id);
												if($agency_search_in_array)
												{
													$agency_item_val = $agency_search_in_array->value;
												}
											?>
											@if($custom_property->type == "int")
												<input type="number" name="agency_custom_properties_value[]" min="0" class="form-control" value="{{ $agency_item_val }}" />
											@else
												<select name="agency_custom_properties_value[]" class="form-control">
													<option value="0" @if($agency_item_val == 0) selected @endif>No</option>
													<option value="1" @if($agency_item_val == 1) selected @endif>Yes</option>
												</select>
											@endif
										</div>
									</div>
									@endif
								@endforeach
							</div>
						</div>

						<div class="d-flex">
							<a href="{{ route('get_admin_plans_index') }}" class="btn btn-link">Cancel</a>
							<button type="submit" class="btn btn-success ms-auto">Update</a>
						</div>
						
					</form>
				</div>

			</div>
		</div>
	</div>

@endsection