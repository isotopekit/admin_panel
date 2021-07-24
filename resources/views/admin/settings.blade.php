@extends('admin_panel::_layouts.admin')

@section('content')

<div class="container-xl">
	<!-- Page title -->
	<div class="page-header d-print-none">
		<div class="row align-items-center">
			<div class="col">
				<h2 class="page-title">
					Settings
				</h2>
				<div class="text-muted mt-1">Super Admin Settings</div>
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

				<div class="card mb-4" id="general">
					<div class="card-header">
						<h3 class="card-title">General</h3>
					</div>
					<form action="">
						<div class="card-body">
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Name</label>
								<div class="col">
									<input type="text" name="" class="form-control" />
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">About</label>
								<div class="col">
									<textarea name="" class="form-control" id="" cols="30" rows="4"></textarea>
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
								<label class="form-label col-12 col-sm-3 col-form-label">Default Language</label>
								<div class="col">
									<select name="" id="" class="form-control">
										<option value="1">English</option>
										<option value="0">Hindi</option>
									</select>
								</div>
							</div>

							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Support Email</label>
								<div class="col">
									<input type="text" class="form-control" placeholder="">
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Support URL</label>
								<div class="col">
									<input type="text" class="form-control" placeholder="">
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Show Training URL</label>
								<div class="col">
									<select name="" id="" class="form-control">
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Training URL</label>
								<div class="col">
									<input type="text" class="form-control" placeholder="">
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="d-flex">
								<a href="#" class="btn btn-link">Cancel</a>
								<a href="#" class="btn btn-success ms-auto">Save Changes</a>
							</div>
						</div>
					</form>
				</div>

				<div class="card mb-4" id="email">
					<div class="card-header">
						<h3 class="card-title">Email Setup</h3>
					</div>
					<form action="">
						<div class="card-body">
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Host</label>
								<div class="col">
									<input type="text" name="" class="form-control" />
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Port</label>
								<div class="col">
									<input type="text" name="" class="form-control" />
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Encryption</label>
								<div class="col">
									<input type="text" name="" class="form-control" />
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Username</label>
								<div class="col">
									<input type="text" name="" class="form-control" />
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Password</label>
								<div class="col">
									<input type="text" name="" class="form-control" />
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">From Address</label>
								<div class="col">
									<input type="text" name="" class="form-control" />
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">From Name</label>
								<div class="col">
									<input type="text" name="" class="form-control" />
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="d-flex">
								<a href="#" class="btn btn-link">Cancel</a>
								<div class="ms-auto">
									<a href="#" class="btn btn-outline-warning">Test Configuration</a>
									<a href="#" class="btn btn-success">Save Changes</a>
								</div>

							</div>
						</div>
					</form>
				</div>

				<div class="card mb-4" id="domain">
					<div class="card-header">
						<h3 class="card-title">Domain Setup</h3>
					</div>
					<form action="">
						<div class="card-body">
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Custom Domain</label>
								<div class="col">
									<div class="input-group">
										<span class="input-group-text">
											https://
										</span>
										<input type="text" class="form-control" placeholder="subdomain"
											autocomplete="off">
										<span class="input-group-text">
											.isotopekit.com
										</span>
									</div>
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
									<input type="text" name="" class="form-control" />
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="d-flex">
								<a href="#" class="btn btn-link">Cancel</a>
								<div class="ms-auto">
									<a href="#" class="btn btn-outline-warning">Test Configuration</a>
									<a href="#" class="btn btn-success">Save Changes</a>
								</div>

							</div>
						</div>
					</form>
				</div>

				<div class="card mb-4" id="security">
					<div class="card-header">
						<h3 class="card-title">Security</h3>
					</div>
					<form action="">
						<div class="card-body">
							<div class="form-group mb-3 row">
								<label for="" class="form-label col-12 col-sm-3 col-form-label">Email</label>
								<div class="col">
									<input type="email" name="" class="form-control" disabled id=""
										value="admin@gmail.com" />
								</div>
							</div>
							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">Old Password</label>
								<div class="col">
									<input type="password" class="form-control" placeholder="Password">
								</div>
							</div>

							<div class="form-group mb-3 row">
								<label class="form-label col-12 col-sm-3 col-form-label">New Password</label>
								<div class="col">
									<input type="password" class="form-control" placeholder="Password">
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
									<input type="password" class="form-control" placeholder="Password">
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="d-flex">
								<a href="#" class="btn btn-link">Cancel</a>
								<a href="#" class="btn btn-success ms-auto">Change Password</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection