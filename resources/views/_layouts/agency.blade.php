<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ IsotopeKit\AuthAPI\Models\Site::settings()['name'] }} : @yield('title')</title>

	<!-- CSS files -->
	<link href="{{ asset('admin_panel/dist/css/tabler.min.css') }}" rel="stylesheet" />
	<link rel="stylesheet" href="https://unpkg.com/@tabler/icons@latest/iconfont/tabler-icons.min.css"/>

	<style>
		body {
			overflow-y: auto;
		}
	</style>

	@yield('header')
</head>

<body class="antialiased">

	<div class="wrapper">
		<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
			<div class="container-fluid">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
					<span class="navbar-toggler-icon"></span>
				</button>
				<h1 class="navbar-brand navbar-brand-autodark">
					<a href="/" class="h1">
						{{ config('isotopekit_admin.app_name') }}
					</a>
				</h1>
				<div class="navbar-nav flex-row d-lg-none">
					<div class="nav-item dropdown">
						<a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
							aria-label="Open user menu">
							<span class="avatar avatar-sm bg-blue-lt">{{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}</span>
							<div class="d-none d-xl-block ps-2">
								<div>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
								<div class="mt-1 small text-muted">{{ Auth::user()->email }}</div>
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
							<a href="{{ route('get_agency_settings') }}" class="dropdown-item">Settings</a>
							<button type="button" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</button>
						</div>
					</div>
				</div>
				<div class="collapse navbar-collapse" id="navbar-menu">
					<ul class="navbar-nav pt-lg-3">
						<li class="nav-item" style="display: none;">
							<a class="nav-link" href="{{ route('get_agency_index') }}">
								<span class="nav-link-icon d-md-none d-lg-inline-block">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
										viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
										stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none" />
										<polyline points="5 12 3 12 12 3 21 12 19 12" />
										<path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
										<path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
									</svg>
								</span>
								<span class="nav-link-title">
									Home
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{ route('get_agency_users_index') }}">
								<span class="nav-link-icon d-md-none d-lg-inline-block">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
										<circle cx="9" cy="7" r="4"></circle>
										<path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
										<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
										<path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
									</svg>
								</span>
								<span class="nav-link-title">
									Users
								</span>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="{{ route('get_agency_settings') }}">
								<span class="nav-link-icon d-md-none d-lg-inline-block">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
										<path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
										<circle cx="12" cy="12" r="3"></circle>
									</svg>
								</span>
								<span class="nav-link-title">
									Settings
								</span>
							</a>
						</li>

						@if(array_key_exists('agency_training_link', config('isotopekit_admin')))
							@if(config('isotopekit_admin.agency_training_link') != '')
							<li class="nav-item">
								<a class="nav-link" target="blank" href="{{ config('isotopekit_admin.agency_training_link') }}">
									<span class="nav-link-icon d-md-none d-lg-inline-block">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-movie" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
										<rect x="4" y="4" width="16" height="16" rx="2"></rect>
										<line x1="8" y1="4" x2="8" y2="20"></line>
										<line x1="16" y1="4" x2="16" y2="20"></line>
										<line x1="4" y1="8" x2="8" y2="8"></line>
										<line x1="4" y1="16" x2="8" y2="16"></line>
										<line x1="4" y1="12" x2="20" y2="12"></line>
										<line x1="16" y1="8" x2="20" y2="8"></line>
										<line x1="16" y1="16" x2="20" y2="16"></line>
									</svg>
									</span>
									<span class="nav-link-title">
										Training
									</span>
								</a>
							</li>
							@endif
						@endif

						@if(array_key_exists('agency_guide_link', config('isotopekit_admin')))
							@if(config('isotopekit_admin.agency_guide_link') != '')
							<li class="nav-item">
								<a class="nav-link" target="blank" href="{{ config('isotopekit_admin.agency_guide_link') }}">
									<span class="nav-link-icon d-md-none d-lg-inline-block">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-book-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
										<path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z"></path>
										<path d="M19 16h-12a2 2 0 0 0 -2 2"></path>
										<path d="M9 8h6"></path>
									</svg>
									</span>
									<span class="nav-link-title">
										@if(array_key_exists('agency_guide_link_text', config('isotopekit_admin')))
											@if(config('isotopekit_admin.agency_guide_link_text') != '')
												{{ config('isotopekit_admin.agency_guide_link_text') != '' ? config('isotopekit_admin.agency_guide_link_text') : 'Guide' }}
											@endif
										@else
											Guide
										@endif
									</span>
								</a>
							</li>
							@endif
						@endif
						
					</ul>
				</div>
			</div>
		</aside>

		<header class="navbar navbar-expand-md navbar-light sticky-top d-none d-lg-flex d-print-none">
			<div class="container-xl">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="navbar-nav flex-row order-md-last">
					<div class="nav-item pe-2">
						<a class="btn btn-outline-primary" href="/{{ config('isotopekit_admin.route_user') }}">
							Access as User
						</a>
					</div>
					<div class="nav-item dropdown">
						<a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
							aria-label="Open user menu">
							<span class="avatar avatar-sm bg-blue-lt">{{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}</span>
							<div class="d-none d-xl-block ps-2">
								<div>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }} </div>
								<div class="mt-1 small text-muted">{{ Auth::user()->email }}</div>
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
							<a href="{{ route('get_agency_settings') }}" class="dropdown-item">Settings</a>
							<button type="button" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</button>
							<form id="logout-form" action="{{ route('post_agency_logout_route') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
								<input type="hidden" name="login_type" value="admin"/>
							</form>
						</div>
					</div>
				</div>
				<div class="collapse navbar-collapse" id="navbar-menu">
				</div>
			</div>
		</header>

		<div class="page-wrapper">

			@yield('content')

			<!-- footer -->
			<footer class="footer footer-transparent d-print-none">
				<div class="container-xl">
					<div class="row text-center align-items-center flex-row-reverse">
						<div class="col-lg-auto ms-lg-auto">
							<ul class="list-inline list-inline-dots mb-0" style="display: none;">
								<li class="list-inline-item"><a target="blank" href="{{ config('isotopekit_admin.links')['feedback'] }}" class="link-secondary">Feedback</a></li>
								<li class="list-inline-item"><a target="blank" href="{{ config('isotopekit_admin.links')['support'] }}" class="link-secondary">Support</a></li>
								<li class="list-inline-item"><a target="blank" href="{{ config('isotopekit_admin.links')['about'] }}" target="_blank" class="link-secondary" rel="noopener">About</a></li>
							</ul>
						</div>
						<div class="col-12 col-lg-auto mt-3 mt-lg-0">
							<ul class="list-inline list-inline-dots mb-0">
								<li class="list-inline-item">
									&copy; 2022
									<a href="/" class="link-secondary">{{ IsotopeKit\AuthAPI\Models\Site::settings()['name'] }}</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>

		</div>
	</div>

	<!-- JS files -->
	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<!-- <script src="{{ asset('admin_panel/dist/js/tabler.min.js') }}"></script> -->
	<script src="{{ asset('admin_panel/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
	
	<script>
		// get query string
		function getUrlVars()
		{
			var vars = [], hash;
			var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			for(var i = 0; i < hashes.length; i++)
			{
				hash = hashes[i].split('=');
				vars.push(hash[0]);
				vars[hash[0]] = hash[1];
			}
			return vars;
		}

		// active nav
		var _c_url = window.location.href;
		$("#navbar-menu a[href='"+_c_url+"']").addClass("active");

		// confirm delete
		// $(".delete_a_thing").click(function(e){
		// 	var answer = confirm("Do you want to delete ?");
			
		// 	if(!answer) {
		// 		e.preventDefault();
		// 	}
		// });
	</script>
	@yield('footer')
</body>

</html>