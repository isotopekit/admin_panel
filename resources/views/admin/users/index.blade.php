@extends('admin_panel::_layouts.admin')

@section('header')

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
					<div class="text-muted mt-1">413 people</div>
				</div>
				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<div class="d-flex">
						<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-new-user">
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
	</div>

	<!-- content -->
	<div class="page-body">
		<div class="container-xl">
			<div class="row row-cards">
				<div class="col-12">
					<div class="card">
						<div class="card-body border-bottom py-3">
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
										<th>Plan</th>
										<th>Status</th>
										<th>Added on</th>
										<th class="w-1"></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select User">
										</td>
										<td>
											<div class="d-flex py-1 align-items-center">
												<span class="avatar me-2">LM</span>
												<div class="flex-fill">
													<div class="font-weight-medium">Lorry Mion</div>
													<div class="text-muted">
														<a href="#" class="text-reset">lmiona@livejournal.com</a>
													</div>
												</div>
											</div>
										</td>
										<td>
											<span class="badge bg-blue-lt">Agency</span>
										</td>
										<td>
											<span class="badge bg-success me-1"></span> Active
										</td>
										<td>
											15 Dec 2017
										</td>
										<td>
											<div class="btn-list flex-nowrap">
												<a href="/user-edit.html" class="btn btn-white">
													Edit
												</a>
												<div class="dropdown">
													<button class="btn dropdown-toggle align-text-top"
														data-bs-boundary="viewport"
														data-bs-toggle="dropdown">Actions</button>
													<div class="dropdown-menu dropdown-menu-end">
														<a class="dropdown-item" href="#">
															<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-login" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
																<path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
																<path d="M20 12h-13l3 -3m0 6l-3 -3"></path>
															</svg>&nbsp;Access
														</a>
														<a class="dropdown-item" href="#">
															<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
																<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
																<line x1="10" y1="14" x2="21" y2="3"></line>
																<path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5"></path>
															</svg>&nbsp;Reset
														</a>
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
										</td>
									</tr>
									<tr>
										<td>
											<input class="form-check-input m-0 align-middle" type="checkbox"
												aria-label="Select invoice">
										</td>
										<td>
											<div class="d-flex py-1 align-items-center">
												<span class="avatar me-2">LM</span>
												<div class="flex-fill">
													<div class="font-weight-medium">Lorry Mion</div>
													<div class="text-muted">
														<a href="#" class="text-reset">lmiona@livejournal.com</a>
													</div>
												</div>
											</div>
										</td>
										<td>
											<span class="badge bg-blue-lt">Agency</span>
										</td>
										<td>
											<span class="badge bg-success me-1"></span> Active
										</td>
										<td>
											15 Dec 2017
										</td>
										<td>
											<div class="btn-list flex-nowrap">
												<a href="#" class="btn btn-white">
													Edit
												</a>
												<div class="dropdown">
													<button class="btn dropdown-toggle align-text-top"
														data-bs-boundary="viewport"
														data-bs-toggle="dropdown">Actions</button>
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
										</td>
									</tr>
									<tr>
										<td>
											<input class="form-check-input m-0 align-middle" type="checkbox"
												aria-label="Select invoice">
										</td>
										<td>
											<div class="d-flex py-1 align-items-center">
												<span class="avatar me-2">LM</span>
												<div class="flex-fill">
													<div class="font-weight-medium">Lorry Mion</div>
													<div class="text-muted">
														<a href="#" class="text-reset">lmiona@livejournal.com</a>
													</div>
												</div>
											</div>
										</td>
										<td>
											<span class="badge bg-blue-lt">Agency</span>
										</td>
										<td>
											<span class="badge bg-success me-1"></span> Active
										</td>
										<td>
											15 Dec 2017
										</td>
										<td>
											<div class="btn-list flex-nowrap">
												<a href="#" class="btn btn-white">
													Edit
												</a>
												<div class="dropdown">
													<button class="btn dropdown-toggle align-text-top"
														data-bs-boundary="viewport"
														data-bs-toggle="dropdown">Actions</button>
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
										</td>
									</tr>
									<tr>
										<td>
											<input class="form-check-input m-0 align-middle" type="checkbox"
												aria-label="Select invoice">
										</td>
										<td>
											<div class="d-flex py-1 align-items-center">
												<span class="avatar me-2">LM</span>
												<div class="flex-fill">
													<div class="font-weight-medium">Lorry Mion</div>
													<div class="text-muted">
														<a href="#" class="text-reset">lmiona@livejournal.com</a>
													</div>
												</div>
											</div>
										</td>
										<td>
											<span class="badge bg-blue-lt">Agency</span>
										</td>
										<td>
											<span class="badge bg-success me-1"></span> Active
										</td>
										<td>
											15 Dec 2017
										</td>
										<td>
											<div class="btn-list flex-nowrap">
												<a href="#" class="btn btn-white">
													Edit
												</a>
												<div class="dropdown">
													<button class="btn dropdown-toggle align-text-top"
														data-bs-boundary="viewport"
														data-bs-toggle="dropdown">Actions</button>
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
										</td>
									</tr>
									<tr>
										<td>
											<input class="form-check-input m-0 align-middle" type="checkbox"
												aria-label="Select invoice">
										</td>
										<td>
											<div class="d-flex py-1 align-items-center">
												<span class="avatar me-2">LM</span>
												<div class="flex-fill">
													<div class="font-weight-medium">Lorry Mion</div>
													<div class="text-muted">
														<a href="#" class="text-reset">lmiona@livejournal.com</a>
													</div>
												</div>
											</div>
										</td>
										<td>
											<span class="badge bg-blue-lt">Agency</span>
										</td>
										<td>
											<span class="badge bg-success me-1"></span> Active
										</td>
										<td>
											15 Dec 2017
										</td>
										<td>
											<div class="btn-list flex-nowrap">
												<a href="#" class="btn btn-white">
													Edit
												</a>
												<div class="dropdown">
													<button class="btn dropdown-toggle align-text-top"
														data-bs-boundary="viewport"
														data-bs-toggle="dropdown">Actions</button>
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
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="card-footer d-flex align-items-center">
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
				<form action="/" method="POST">
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="mb-3">
									<label class="form-label">First name</label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="mb-3">
									<label class="form-label">Last Name</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="mb-3">
							<label class="form-label">Email</label>
							<input type="text" class="form-control" name="example-text-input" placeholder="Your report name">
						</div>

						<div class="mb-3">
							<label class="form-label">Password</label>
							<input type="password" class="form-control" name="example-text-input" placeholder="Your report name">
						</div>

						<div class="mb-3">
							<label class="form-label">Plan / Level</label>
							<select name="" class="form-control" id="">
								<option value="1">Level 1</option>
							</select>
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