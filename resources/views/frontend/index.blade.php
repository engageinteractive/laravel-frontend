@extends('frontend::layout/base')

@push('stylesheets')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@1.0.4/dist/tailwind.min.css">
@endpush

@section('app')
	<div class="container mx-auto py-12 px-5">
		<h1 class="text-4xl xl:text-5xl text-gray-900 font-bold antialiased">Project templates</h1>

		<p class="text-gray-900 antialiased">Static templates provide a <em class="italic">mocked</em> representation of the frontend.</p>

		<div class="mt-3">
			@include('frontend::frontend/templates', ['templates' => $templates])
		</div>

		@if ($links)
			<div class="mt-3">
				@include('frontend::frontend/links')		
			</div>
		@endif
	</div>
@endsection
