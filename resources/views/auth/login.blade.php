@extends('admin_panel::_layouts.guest')

@section('title','Login')

@section('content')
	<div class="page page-center">
		<div class="container-tight py-4">
			<div class="text-center mb-4">
				<a href="/" class="h1">
					IsotopeKit
				</a>
			</div>
			
			@component('admin_panel::_layouts.components.alert')
        	@endcomponent

			<form class="card card-md" action="{{ route('post_login_route') }}" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="login_type" value="admin"/>
				<div class="card-body">
					<h2 class="card-title text-center mb-4">Login to your account</h2>
					<div class="mb-3">
						<label class="form-label">Email address</label>
						<input
							type="email" name="email" placeholder="Enter email"
							value="{{ old('email') }}"
							@if($errors->has('email'))
								class="form-control is-invalid"
							@else
								class="form-control"
							@endif
						/>
						@if($errors->has('email'))
							<div class="invalid-feedback">{{ $errors->first('email') }}</div>
						@endif
					</div>
					<div class="mb-2">
						<label class="form-label">
							Password
							<span class="form-label-description">
								<a href="{{ route('get_admin_reset_route') }}">I forgot password</a>
							</span>
						</label>
						<input
							type="password" name="password" placeholder="Password"
							@if($errors->has('password'))
								class="form-control is-invalid"
							@else
								class="form-control"
							@endif
						/>
						@if ($errors->has('password'))
							<div class="invalid-feedback">{{ $errors->first('password') }}</div>
						@endif
					</div>
					<div class="mb-2">
						<label class="form-check">
							<input type="checkbox" class="form-check-input" name="remember_me" />
							<span class="form-check-label">Remember me on this device</span>
						</label>
					</div>
					<div class="form-footer">
						<button type="submit" class="btn btn-primary w-100">Sign in</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection