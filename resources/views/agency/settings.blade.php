@extends('admin_panel::_layouts.agency')
@section('title','Settings')
@section('content')

<div class="container-xl">
	<!-- Page title -->
	<div class="page-header d-print-none">
		<div class="row align-items-center">
			<div class="col">
				<h2 class="page-title">
					Settings
				</h2>
				<div class="text-muted mt-1">Agency Settings</div>
			</div>
		</div>
	</div>
</div>

<div class="page-body">
	<div class="container-xl">
		<div class="row">
			<div class="d-none d-lg-block col-lg-3">
				<div class="list-group bg-white" id="settings-list">
					<a href="#general" class="list-group-item list-group-item-action active" aria-current="true">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle"
							width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
							fill="none" stroke-linecap="round" stroke-linejoin="round">
							<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
							<circle cx="12" cy="12" r="9"></circle>
							<line x1="12" y1="8" x2="12.01" y2="8"></line>
							<polyline points="11 12 12 12 12 16 13 16"></polyline>
						</svg>
						General
					</a>
					<a href="#email" class="list-group-item list-group-item-action">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24"
							height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
							stroke-linecap="round" stroke-linejoin="round">
							<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
							<rect x="3" y="5" width="18" height="14" rx="2"></rect>
							<polyline points="3 7 12 13 21 7"></polyline>
						</svg>
						Email Setup
					</a>
					<a href="#domain" class="list-group-item list-group-item-action">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-link" width="24"
							height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
							stroke-linecap="round" stroke-linejoin="round">
							<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
							<path d="M10 14a3.5 3.5 0 0 0 5 0l4 -4a3.5 3.5 0 0 0 -5 -5l-.5 .5"></path>
							<path d="M14 10a3.5 3.5 0 0 0 -5 0l-4 4a3.5 3.5 0 0 0 5 5l.5 -.5"></path>
						</svg>
						Domain Setup
					</a>
					<a href="#security" class="list-group-item list-group-item-action">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock" width="24"
							height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
							stroke-linecap="round" stroke-linejoin="round">
							<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
							<rect x="5" y="11" width="14" height="10" rx="2"></rect>
							<circle cx="12" cy="16" r="1"></circle>
							<path d="M8 11v-4a4 4 0 0 1 8 0v4"></path>
						</svg>
						Security
					</a>
				</div>
			</div>
			<div class="col-lg-9 overflow-auto" style="max-height: 70vh;" data-bs-spy="scroll" data-bs-target="#settings-list">

				@component('admin_panel::_layouts.components.alert')
        		@endcomponent

				<div class="card mb-4" id="general">
					<div class="card-header">
						<h3 class="card-title">General</h3>
					</div>
					<form action="{{ route('post_agency_settings_general') }}" method="post">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Name</label>
								<div class="col">
									<input
										type="text" required name="name"
										@if($errors->has('name'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('name', $settings->name) }}"
									/>
									@if($errors->has('name'))
										<div class="invalid-feedback">{{ $errors->first('name') }}</div>
									@endif
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">About</label>
								<div class="col">
									<textarea
										name="page_description" rows="4"
										@if($errors->has('page_description'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
									>{{ $settings->page_description }}</textarea>
									@if($errors->has('page_description'))
										<div class="invalid-feedback">{{ $errors->first('page_description') }}</div>
									@endif
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Logo</label>
								<div class="col">
									<input type="file" class="form-control" placeholder="" />
								</div>
							</div>

							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Favicon</label>
								<div class="col">
									<input type="file" class="form-control" placeholder="" />
								</div>
							</div>

							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Theme</label>
								<div class="col">
									<select name="theme" required class="form-control">
										<option  {{ old('theme', $settings->theme) == "blue" ? "selected": "" }} value="blue">Default</option>
										<option  {{ old('theme', $settings->theme) == "green" ? "selected": "" }} value="green">Green</option>
									</select>
								</div>
							</div>

							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Default Language</label>
								<div class="col">
									<select name="language" required class="form-control">
										<option  {{ old('language', $settings->language) == "en" ? "selected": "" }} value="en">English</option>
										<option  {{ old('language', $settings->language) == "hi" ? "selected": "" }} value="hi">Hindi</option>
									</select>
								</div>
							</div>

							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Support Email</label>
								<div class="col">
									<input
										type="text" name="support_email"
										@if($errors->has('support_email'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('support_email', $settings->support_email) }}"
									/>
									@if($errors->has('support_email'))
										<div class="invalid-feedback">{{ $errors->first('support_email') }}</div>
									@endif
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Support URL</label>
								<div class="col">
									<input
										type="text" name="support_url"
										@if($errors->has('support_url'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('support_url', $settings->support_url) }}"
									/>
									@if($errors->has('support_url'))
										<div class="invalid-feedback">{{ $errors->first('support_url') }}</div>
									@endif
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Show Training URL</label>
								<div class="col">
									<select name="show_training_url" class="form-control">
										<option  {{ old('show_training_url', $settings->show_training_url) == 1 ? "selected": "" }} value="1">Yes</option>
										<option  {{ old('show_training_url', $settings->show_training_url) == 0 ? "selected": "" }} value="0">No</option>
									</select>
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Training URL</label>
								<div class="col">
									<input
										type="text" name="training_url"
										@if($errors->has('training_url'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('training_url', $settings->training_url) }}"
									/>
									@if($errors->has('training_url'))
										<div class="invalid-feedback">{{ $errors->first('training_url') }}</div>
									@endif
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="d-flex">
								<a href="{{ route('get_agency_index') }}" class="btn btn-link">Cancel</a>
								<button type="submit" class="btn btn-success ms-auto">Save Changes</button>
							</div>
						</div>
					</form>
				</div>

				<div class="card mb-4" id="email">
					<div class="card-header">
						<h3 class="card-title">Email Setup</h3>
					</div>
					<form action="{{ route('post_agency_settings_email') }}" method="post">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="form-group mb-3 row" style="display: none;">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Host</label>
								<div class="col">
									<input
										type="text" name="host"
										@if($errors->has('host'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('host', $settings->host) }}"
									/>
									@if($errors->has('host'))
										<div class="invalid-feedback">{{ $errors->first('host') }}</div>
									@endif
								</div>
							</div>
							<div class="form-group mb-3 row" style="display: none;">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Port</label>
								<div class="col">
									<input
										type="text" name="port"
										@if($errors->has('port'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('port', $settings->port) }}"
									/>
									@if($errors->has('port'))
										<div class="invalid-feedback">{{ $errors->first('port') }}</div>
									@endif
								</div>
							</div>
							<div class="form-group mb-3 row" style="display: none;">
								<label class="form-label col-12 col-sm-3 col-form-label">Encryption</label>
								<div class="col">
									<select name="encryption" class="form-control">
										<option  {{ old('encryption', $settings->encryption) == "tls" ? "selected": "" }} value="tls">TLS</option>
									</select>
								</div>
							</div>
							<div class="form-group mb-3 row" style="display: none;">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Username</label>
								<div class="col">
									<input
										type="text" name="username"
										@if($errors->has('username'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('username', $settings->username) }}"
									/>
									@if($errors->has('username'))
										<div class="invalid-feedback">{{ $errors->first('username') }}</div>
									@endif
								</div>
							</div>
							<div class="form-group mb-3 row" style="display: none;">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Password</label>
								<div class="col">
									<input
										type="text" name="password"
										@if($errors->has('password'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('password', $settings->password) }}"
									/>
									@if($errors->has('password'))
										<div class="invalid-feedback">{{ $errors->first('password') }}</div>
									@endif
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">From Address</label>
								<div class="col">
									<input
										type="text" required name="from_address"
										@if($errors->has('from_address'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('from_address', $settings->from_address) }}"
									/>
									@if($errors->has('from_address'))
										<div class="invalid-feedback">{{ $errors->first('from_address') }}</div>
									@endif
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">From Name</label>
								<div class="col">
									<input
										type="text" required name="from_name"
										@if($errors->has('from_name'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('from_name', $settings->from_name) }}"
									/>
									@if($errors->has('from_name'))
										<div class="invalid-feedback">{{ $errors->first('from_name') }}</div>
									@endif
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="d-flex">
								<a href="{{ route('get_agency_index') }}" class="btn btn-link">Cancel</a>
								<div class="ms-auto">
									<a href="#" class="btn btn-outline-warning" style="display: none;">Test Configuration</a>
									<button type="submit" class="btn btn-success">Save Changes</button>
								</div>

							</div>
						</div>
					</form>
				</div>

				<div class="card mb-4" id="domain">
					<div class="card-header">
						<h3 class="card-title">Domain Setup</h3>
					</div>
					<form action="{{ route('post_agency_settings_domain') }}" method="post">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Custom Domain</label>
								<div class="col">
									<div class="input-group">
										<span class="input-group-text">
											https://
										</span>
										<input
											type="text" required name="unique_name" placeholder="subdomain" autocomplete="off"
											@if($errors->has('unique_name'))
												class="form-control is-invalid"
											@else
												class="form-control"
											@endif
											value="{{ old('unique_name', $settings->unique_name) }}"
										>
										<span class="input-group-text">
											.{{ config('isotopekit_admin.domain') }}
										</span>
									</div>
									@if($errors->has('name'))
										<div class="invalid-feedback">{{ $errors->first('name') }}</div>
									@endif
								</div>
							</div>
							<div class="alert alert-important alert-info bg-blue-lt">
								<div class="d-flex">
									<div>
										
									</div>
									<div>
										to connect domain, Point your domain (example.com)
										<br>
										<b>A</b> <b>domain.com</b> points to <b>X.XX.X.XX</b>
										<br>
										<b>A</b> <b>*.domain.com</b> points to <b>X.XX.X.XX</b>
										<br>
										in your domain DNS settings
									</div>
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">External URL</label>
								<div class="col">
									<input
										type="text" name="external_url"
										@if($errors->has('external_url'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value="{{ old('external_url', $settings->external_url) }}"
									/>
									@if($errors->has('external_url'))
										<div class="invalid-feedback">{{ $errors->first('external_url') }}</div>
									@endif
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="d-flex">
								<a href="{{ route('get_agency_index') }}" class="btn btn-link">Cancel</a>
								<div class="ms-auto">
									<a href="#" class="btn btn-outline-warning">Test Configuration</a>
									<button type="submit" class="btn btn-success">Save Changes</button>
								</div>

							</div>
						</div>
					</form>
				</div>

				<div class="card mb-4" id="security">
					<div class="card-header">
						<h3 class="card-title">Security</h3>
					</div>
					<form action="{{ route('post_agency_settings_password') }}" method="post">
						{{ csrf_field() }}

						<div class="card-body">
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Email</label>
								<div class="col">
									<input type="email" name="" class="form-control" disabled id=""
										value="{{ Auth::user()->email }}" />
								</div>
							</div>
							<!-- <div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Old Password</label>
								<div class="col">
									<input type="password" class="form-control" placeholder="Password">
								</div>
							</div> -->

							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">New Password</label>
								<div class="col">
									<input
										type="password" name="password" required
										@if($errors->has('password'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value=""
										placeholder="Password"
									/>
									@if($errors->has('password'))
										<div class="invalid-feedback">{{ $errors->first('password') }}</div>
									@endif
									<small class="form-hint">
										Your password must be 8-20 characters long, contain letters and numbers, and
										must not contain
										spaces, special characters, or emoji.
									</small>
								</div>
							</div>

							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Confirm Password</label>
								<div class="col">
									<input
										type="password" class="form-control" placeholder="Password" required name="password_confirm"
										@if($errors->has('password_confirm'))
											class="form-control is-invalid"
										@else
											class="form-control"
										@endif
										value=""
									/>
									@if($errors->has('password_confirm'))
										<div class="invalid-feedback">{{ $errors->first('password_confirm') }}</div>
									@endif
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="d-flex">
								<a href="{{ route('get_agency_index') }}" class="btn btn-link">Cancel</a>
								<button type="submit" class="btn btn-success ms-auto">Change Password</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection