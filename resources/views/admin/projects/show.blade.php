@extends('layouts.app')

@section('title')
	<div class="container">
		<div class="d-flex align-items-center justify-content-between">
			<h3 class="my-4"> Progetto: {{ $project->title }}</h3>

			<a href="{{ route('admin.projects.index') }}" class="btn btn-primary">Torna all'indice</a>

		</div>
	</div>
@endsection

@section('content')
	<div class="container">
		{{-- @dump($project); --}}

		<div class="row justify-content-center align-items-center mb-3">
			<div class="card col-8 p-3">

				<div class=" row d-flex justify-content-between">
					<h3 class="col-md-6 col-12 card-title mb-4 ">Titolo: <br> {{ $project->title }}</h3>
					<img class="img-fluid col-12 col-md-6 mb-3" src="{{ $project->getLinkUri() }}" alt="{{ $project->title }}">
				</div>

				<p class="card-text mb-4 "><strong>Tipologia:</strong> <br> <span class="badge rounded-pill"
						style="background-color:{{ $project->type?->color }} ">{{ $project->type?->label }}</span>
				</p>

				<div class="d-flex align-items-center">
					<p class="card-text m-0 mb-3 p-0 me-3 "><strong>Tecnologie:</strong><br>

						@foreach ($project->technologies as $technology)
							<span class="badge rounded-pill me-2"
								style="background-color:{{ $technology->color }} ">{{ $technology->label }}</span>
						@endforeach
					</p>
				</div>

				<p class=""><strong>Descrizione: <br></strong> {{ $project->description }}</p>

				<a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary w-75 align-self-center"> Modifica
					progetto</a>
			</div>
		</div>
	</div>
@endsection
