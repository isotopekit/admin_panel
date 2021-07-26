@if(session('status.success'))
	<div class="alert alert-important alert-success">
		{{ session('status.success') }}
	</div>
@endif

@if(session('status.error'))
	<div class="alert alert-important alert-danger">
		{{ session('status.error') }}
	</div>
@endif

<? /*
@if ($errors->has('general'))
	<div class="alert alert-important alert-danger">
		<strong>{{ $errors->first('general') }}</strong>
	</div>
@endif
*/ ?>

@if ($errors->any())
    <div class="alert alert-important alert-warning">
        <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif