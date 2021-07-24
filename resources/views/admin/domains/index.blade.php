@extends('admin_panel::_layouts.admin')

@section('content')

	<div class="container-xl">
		<!-- Page title -->
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col">
					<h2 class="page-title">
						Domains
					</h2>
					<div class="text-muted mt-1">43 domains</div>
				</div>
				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<div>
						<a href="#" class="btn btn-primary">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-scan" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
								<path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
								<path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
								<path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
								<path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
								<line x1="5" y1="12" x2="19" y2="12"></line>
							</svg>
							Check All
						</a>
						<a href="#" class="btn btn-primary">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
								<path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
								<path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
							</svg>
							Refresh
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
											URL
											<svg xmlns="http://www.w3.org/2000/svg"
												class="icon icon-sm text-dark icon-thick" width="24" height="24"
												viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
												stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<polyline points="6 15 12 9 18 15" />
											</svg>
										</th>
										<th>Type</th>
										<th>User</th>
										<th>Checked</th>
										<th>Error Found</th>
										<th>Secured</th>
										<th class="w-1"></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice">
										</td>
										<td>
											<div class="d-flex py-1 align-items-center">
												<div class="flex-fill">
													<div class="font-weight-medium">example.com</div>
												</div>
											</div>
										</td>
										<td>
											<span class="badge bg-blue-lt">Video Page</span>
										</td>
										<td>
											<div class="d-flex py-1 align-items-center">
												<div class="flex-fill">
													<div class="font-weight-medium">Lorry Mion</div>
													<div class="text-muted">
														<a href="#" class="text-reset">lmiona@livejournal.com</a>
													</div>
												</div>
											</div>
										</td>
										<td>
											<span class="badge bg-success me-1"></span> Yes
										</td>
										<td>
											<span class="badge bg-success me-1"></span> Yes
										</td>
										<td>
											<span class="badge bg-danger me-1"></span> No
										</td>
										<td>
											<div class="btn-list flex-nowrap">
												<a href="#" class="btn btn-white">
													Check Now
												</a>
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

@endsection