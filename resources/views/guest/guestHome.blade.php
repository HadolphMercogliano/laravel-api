@extends('layouts.guest')
@section('content')
	<div class="container">
		<h2 class="fs-4 text-secondary my-4">
			{{ __('Progetti Publicati') }}
		</h2>
		<div class="row mb-4 justify-content-center">
			@foreach ($published_projects as $project)
				<div class="col-4">
					<div class="card h-100">
						<img src="{{ $project->getLinkUri() }}" alt="">
						<div class="p-2">
							<h3 class="">Titolo: {{ $project->title }}</h3>

						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection
