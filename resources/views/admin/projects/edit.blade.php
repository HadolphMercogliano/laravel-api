@extends('layouts.app')

@section('title')
	<div class="container">
		<div class="d-flex align-items-center justify-content-between">
			<h3 class="my-4"> Modifica Progetto</h3>

			<a href="{{ route('admin.projects.index') }}" class="btn btn-primary">Torna all'indice</a>

		</div>
	</div>
@endsection

@section('content')
	<div class="container">
		<div class="card">
			<div class="card-body">
				<form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
					@csrf
					@method('put')

					<label for="title">title</label>
					<input type="text" name="title" id="title" class="form-control mb-3 @error('title') is-invalid @enderror"
						value="{{ old('title') ?? $project->title }}">
					@error('title')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
					<label for="type_id">Tipo</label>
					<select name="type_id" id="type_id" class="form-select mb-3 @error('type_id') is-invalid @enderror">
						<option value="">Nessun tipo</option>
						@foreach ($types as $type)
							<option @if (old('type_id', $project->type_id) == $type->id) selected @endif value="{{ $type->id }}">{{ $type->label }}</option>
						@endforeach
					</select>
					@error('type_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror

					<div>
						<p>Tecnologie:</p>
						<div class="d-flex w-75 justify-content-between">
							@foreach ($technologies as $technology)
								<div>

									<label for="technology-{{ $technology->id }}" class="">{{ $technology->label }}</label>
									<input class="form-check-control me-3 @error('technologies') is-invalid @enderror"
										id="technology-{{ $technology->id }}" name="technologies[]" type="checkbox" value="{{ $technology->id }}"
										@if (in_array($technology->id, old('technologies', $project_technologies ?? []))) checked @endif>
								</div>
							@endforeach
						</div>
						@error('technologies')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror
					</div>

					<div class="mt-4">
						<label for="is_published">Published</label>

						<input type="checkbox" name="is_published" id="is_published" class="form-check-control mb-3"
							@checked(old('is_published', $project->is_published)) value="1">
					</div>

					<div class="row align-items-center">
						<div class="col-10">
							<label for="link">link</label>
							<input type="file" name="link" id="link" class="form-control mb-3 @error('link') is-invalid @enderror"
								value="{{ old('link') ?? $project->link }}">
						</div>
						@error('link')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror
						<div class="col-2">
							<img class="img-fluid" src="{{ $project->getLinkUri() }}" alt="">
						</div>
					</div>

					<label for="description">description</label>
					<textarea type="textarea" name="description" id="description"
					 class="form-control mb-3 @error('description') is-invalid @enderror" rows="3">{{ old('description') ?? $project->description }}</textarea>
					@error('description')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror

					<input type="submit" class="btn btn-primary" value="Salva">
				</form>
			</div>
		</div>
	</div>
@endsection
