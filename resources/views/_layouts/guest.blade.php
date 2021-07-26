<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Panel : @yield('title')</title>
	
	<!-- CSS files -->
    <link href="{{ asset('admin_panel/dist/css/tabler.min.css') }}" rel="stylesheet"/>
    
</head>

<body class="antialiased border-top-wide border-primary d-flex flex-column">
	
	@yield('content')
	
	<!-- JS files -->
	<script src="{{ asset('admin_panel/dist/js/tabler.min.js') }}"></script>
</body>

</html>