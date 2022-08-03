@extends('admin_panel::_layouts.admin')
@section('title','Domains')
@section('content')

	<div class="container-xl">
		<!-- Page title -->
		<div class="page-header d-print-none">
			<div class="row align-items-center">
				<div class="col">
					<h2 class="page-title">
						Domains
					</h2>
					<div class="text-muted mt-1">{{ count($domains) }} domains</div>
				</div>
				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<div>
						<a href="{{ route('get_admin_domains_check') }}" class="btn btn-primary">
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
						<a href="{{ route('get_admin_domains_refresh') }}" class="btn btn-primary">
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
		<style>
			.alert {
				margin-bottom: 0px;
				margin-top: 16px;
			}
		</style>
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
										<th style="display: none;">User</th>
										<th>Checked</th>
										<th>Error Found</th>
										<th>Secured</th>
										<th class="w-1"></th>
									</tr>
								</thead>
								<tbody>
									@foreach($domains as $domain)
									<tr>
										<td>
											<input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice">
										</td>
										<td>
											<div class="d-flex py-1 align-items-center">
												<div class="flex-fill">
													<div class="font-weight-medium">{{ $domain->url }}</div>
												</div>
											</div>
										</td>
										<td>
											<span class="badge bg-blue-lt">{{ $domain->use_type }}</span>
										</td>
										<td style="display: none;">
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
											@if($domain->checked)
												<span class="badge bg-success me-1"></span> Yes
											@else
												<span class="badge bg-danger me-1"></span> No
											@endif
										</td>
										<td>
											@if($domain->has_error)
												<span class="badge bg-success me-1"></span> Yes
											@else
												<span class="badge bg-danger me-1"></span> No
											@endif
										</td>
										<td>
											@if($domain->is_secured)
												<span class="badge bg-success me-1"></span> Yes
											@else
												<span class="badge bg-danger me-1"></span> No
											@endif
										</td>
										<td>
											<div class="btn-list flex-nowrap">
												<a href="{{ route('get_admin_domains_check_index', ['id' => $domain->id ]) }}" class="btn btn-white">
													Check Now
												</a>
											</div>
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
	</div>

@endsection