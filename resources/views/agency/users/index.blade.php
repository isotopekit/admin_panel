@extends('admin_panel::_layouts.agency')
@section('title','Users')
@section('header')

<style>
	.table-responsive {
		overflow-x: visible;
	}
</style>

@endsection

@section('content')

	<div class="container-xl">
		<!-- Page title -->
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col">
					<h2 class="page-title">
						Users
					</h2>
					<div class="text-muted mt-1">{{ $current_users }} / {{ $total_users }} people</div>
				</div>
				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<div class="d-flex">
						<a href="#" @if($can_add_more) class="btn btn-primary" @else class="btn btn-primary disabled" disabled @endif data-bs-toggle="modal" data-bs-target="#modal-new-user">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
								stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
								stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
								<line x1="12" y1="5" x2="12" y2="19"></line>
								<line x1="5" y1="12" x2="19" y2="12"></line>
							</svg>
							New user
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
			<div class="row row-cards">
				<div class="col-12">
					<div class="card">
						<div class="card-body border-bottom py-3" style="display: none;">
							<div class="d-flex">
								<div class="text-muted">
									Show
									<div class="mx-2 d-inline-block">
										<input type="text" class="form-control form-control-sm" value="8" size="3"
											aria-label="Invoices count">
									</div>
									entries
								</div>
								<div class="ms-auto text-muted">
									Search:
									<div class="ms-2 d-inline-block">
										<input type="text" class="form-control form-control-sm" aria-label="Search invoice">
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table card-table table-vcenter table-mobile-md datatable">
								<thead>
									<tr>
										<th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox"
												aria-label="Select all users"></th>
										<th>
											Name
											<svg xmlns="http://www.w3.org/2000/svg"
												class="icon icon-sm text-dark icon-thick" width="24" height="24"
												viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
												stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<polyline points="6 15 12 9 18 15" />
											</svg>
										</th>
										<th style="display: none;">Plan</th>
										<th>Status</th>
										<th>Added on</th>
										<th class="w-1"></th>
									</tr>
								</thead>
								<tbody>
									@foreach($users as $user)
										<tr>
											<td>
												<input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select User">
											</td>
											<td>
												<div class="d-flex py-1 align-items-center">
													<span class="avatar me-2">
														{{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
													</span>
													<div class="flex-fill">
														<div class="font-weight-medium text-capitalize">{{ $user->first_name }} {{ $user->last_name }}</div>
														<div class="text-muted">
															<a href="#" class="text-reset">{{ $user->email }}</a>
														</div>
													</div>
												</div>
											</td>
											<td style="display: none;">
												@if($user->plan_name != null)
												<span class="badge bg-blue-lt">{{ $user->plan_name }}</span>
												@endif
											</td>
											<td>
												@if($user->enabled)
												<span class="badge bg-success me-1"></span> Active
												@else
												<span class="badge bg-danger me-1"></span> Disabled
												@endif
											</td>
											<td>
												{{ $user->created_at }}
											</td>
											<td>
												<div class="btn-list flex-nowrap">
													<a href="{{ route('get_agency_users_edit', ['id' => $user->id]) }}" class="btn btn-white">
														Edit
													</a>
													<div class="dropdown">
														<button class="btn dropdown-toggle align-text-top"
															data-bs-boundary="viewport"
															data-bs-toggle="dropdown">Actions</button>
														<div class="dropdown-menu dropdown-menu-end">
															<button class="dropdown-item" onclick="event.preventDefault();document.getElementById('access-user-{{ $user->id }}').submit();">
																<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-login" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																	<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
																	<path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
																	<path d="M20 12h-13l3 -3m0 6l-3 -3"></path>
																</svg>&nbsp;Access
															</button>
															<form id="access-user-{{ $user->id }}" action="{{ route('post_agency_users_access', $user->id) }}" method="POST" style="display: none;">
																{{ csrf_field() }}
															</form>
															<a class="dropdown-item" href="#" style="display: none;">
																<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																	<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
																	<line x1="10" y1="14" x2="21" y2="3"></line>
																	<path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5"></path>
																</svg>&nbsp;Reset
															</a>
															<button type="button" class="dropdown-item" onclick="event.preventDefault();document.getElementById('change-user-status-{{ $user->id }}').submit();">
																@if($user->enabled)
																<span class="text-danger">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																		<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
																		<line x1="18" y1="6" x2="6" y2="18"></line>
																		<line x1="6" y1="6" x2="18" y2="18"></line>
																	</svg>&nbsp;Disable
																</span>
																@else
																<span class="text-success">
																	<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																		<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
																		<path d="M5 12l5 5l10 -10"></path>
																	</svg>&nbsp;Enable
																</span>
																@endif
															</button>
															<form id="change-user-status-{{ $user->id }}" action="{{ route('post_agency_users_edit_status', $user->id) }}" method="POST" style="display: none;">
																{{ csrf_field() }}
																@if($user->enabled)
																	<input type="hidden" name="enabled" value="0">
																@else
																	<input type="hidden" name="enabled" value="1">
																@endif
															</form>
															<button class="dropdown-item text-red" onclick="event.preventDefault();document.getElementById('delete-user-{{ $user->id }}').submit();">
																<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																	<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
																	<line x1="4" y1="7" x2="20" y2="7"></line>
																	<line x1="10" y1="11" x2="10" y2="17"></line>
																	<line x1="14" y1="11" x2="14" y2="17"></line>
																	<path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
																	<path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
																</svg>&nbsp;Delete
															</button>
															<form id="delete-user-{{ $user->id }}" action="{{ route('post_agency_users_delete', $user->id) }}" method="POST" style="display: none;">
																{{ csrf_field() }}
															</form>
														</div>
													</div>
												</div>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="card-footer d-flex align-items-center" style="display: none !important;">
							<p class="m-0 text-muted">Showing <span>1</span> to <span>8</span> of <span>16</span> entries
							</p>
							<ul class="pagination m-0 ms-auto">
								<li class="page-item disabled">
									<a class="page-link" href="#" tabindex="-1" aria-disabled="true">
										<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
										<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
											viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
											stroke-linecap="round" stroke-linejoin="round">
											<path stroke="none" d="M0 0h24v24H0z" fill="none" />
											<polyline points="15 6 9 12 15 18" />
										</svg>
										prev
									</a>
								</li>
								<li class="page-item"><a class="page-link" href="#">1</a></li>
								<li class="page-item active"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item"><a class="page-link" href="#">4</a></li>
								<li class="page-item"><a class="page-link" href="#">5</a></li>
								<li class="page-item">
									<a class="page-link" href="#">
										next
										<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
										<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
											viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
											stroke-linecap="round" stroke-linejoin="round">
											<path stroke="none" d="M0 0h24v24H0z" fill="none" />
											<polyline points="9 6 15 12 9 18" />
										</svg>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal modal-blur fade" id="modal-new-user" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">New User</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="{{ route('post_agency_users_add') }}" method="POST">
					{{ csrf_field() }}
					<div class="modal-body">
						@component('admin_panel::_layouts.components.alert')
						@endcomponent
						<div class="row">
							<div class="col-lg-6">
								<div class="mb-3">
									<label class="form-label">First name</label>
									<input
										type="text" name="first_name" required placeholder="First Name"
										@if($errors->has('first_name'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('first_name') }}"
									>
									@if($errors->has('first_name'))
										<div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
									@endif
								</div>
							</div>
							<div class="col-lg-6">
								<div class="mb-3">
									<label class="form-label">Last Name</label>
									<input
										type="text" name="last_name" required placeholder="Last Name"
										@if($errors->has('last_name'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('last_name') }}"
									>
									@if($errors->has('last_name'))
										<div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
									@endif
								</div>
							</div>
						</div>

						<div class="mb-3">
							<label class="form-label">Email</label>
							<input type="text" name="email" required placeholder="User Email"
								@if($errors->has('email'))
									class="form-control is-invalid"
								@else
									class="form-control"
								@endif
								value="{{ old('email') }}"
							>
							@if($errors->has('email'))
								<div class="invalid-feedback">{{ $errors->first('email') }}</div>
							@endif
						</div>

						<div class="mb-3">
							<label class="form-label">Password</label>
							<div class="input-group mb-2">
								<input
									type="password" name="password" required placeholder="User Password"
									@if($errors->has('password'))
										class="form-control is-invalid"
									@else
										class="form-control"
									@endif
									value=""
								>
								<button type="button" class="btn toggle_password" data-state="hidden">
									<span class="hidden">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
											<desc>Download more icon variants from https://tabler-icons.io/i/eye-off</desc>
											<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
											<line x1="3" y1="3" x2="21" y2="21"></line>
											<path d="M10.584 10.587a2 2 0 0 0 2.828 2.83"></path>
											<path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341"></path>
										</svg>
									</span>
									<span class="shown" style="display: none;">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
											<desc>Download more icon variants from https://tabler-icons.io/i/eye</desc>
											<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
											<circle cx="12" cy="12" r="2"></circle>
											<path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path>
										</svg>
									</span>
								</button>
							</div>
							@if($errors->has('password'))
								<div class="invalid-feedback">{{ $errors->first('password') }}</div>
							@endif
						</div>

						<div class="mb-3">
							<label class="form-label">Confirm Password</label>
							<div class="input-group mb-2">
								<input
									type="password" name="password_confirmation" required placeholder="User Password"
									@if($errors->has('password_confirmation'))
										class="form-control is-invalid"
									@else
										class="form-control"
									@endif
									value=""
								>
								<button type="button" class="btn toggle_password" data-state="hidden">
									<span class="hidden">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
											<desc>Download more icon variants from https://tabler-icons.io/i/eye-off</desc>
											<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
											<line x1="3" y1="3" x2="21" y2="21"></line>
											<path d="M10.584 10.587a2 2 0 0 0 2.828 2.83"></path>
											<path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341"></path>
										</svg>
									</span>
									<span class="shown" style="display: none;">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
											<desc>Download more icon variants from https://tabler-icons.io/i/eye</desc>
											<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
											<circle cx="12" cy="12" r="2"></circle>
											<path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path>
										</svg>
									</span>
								</button>
							</div>
							@if($errors->has('password_confirmation'))
								<div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
							@endif
						</div>

						<div class="mb-3">
							<label class="form-label"><span class="badge bg-info">Tip</span></label>
							You can customized User Features after account Setup, from "Edit" Section.
						</div>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
							Cancel
						</a>
						<button type="submit" class="btn btn-success ms-auto">
							Create User
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

@section('footer')

	<script>
		var _mode = getUrlVars()["mode"];
		if(_mode == "user_add")
		{
			var myModal = new bootstrap.Modal(document.getElementById('modal-new-user'), {
				keyboard: false
			})
			myModal.show();
		}
	</script>

	<script>
		$(".toggle_password").click(function(){
			
			var _this = $(this);
			var _this_attr = $(this).attr("data-state");

			if(_this_attr == "hidden")
			{
				var _ne = $(this).closest('div').find('[type=password]');
				_ne.attr("type", "text");

				$(_this).attr("data-state", "show");

				$(_this).children(".hidden").hide();
				$(_this).children(".shown").show();
			}
			else
			{
				var _ne = $(this).closest('div').find('[type=text]');
				_ne.attr("type", "password");

				$(_this).attr("data-state", "hidden");

				$(_this).children(".hidden").show();
				$(_this).children(".shown").hide();
			}
		})
	</script>

@endsection