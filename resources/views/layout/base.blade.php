<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Templates</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

	@stack('stylesheets')
</head>
<body>
	<div id="app" class="relative">
		@yield('app')
	</div>
</body>
</html>
