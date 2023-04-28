@extends('layouts.app')

@section('title')
	<div class="container">
		<div class="d-flex align-items-center justify-content-between">
			<h3 class="my-4"> Crea nuovo progetto</h3>

			<a href="{{ route('admin.projects.index') }}" class="btn btn-primary">Torna all'indice</a>

		</div>
	</div>
@endsection

@section('content')
	<div class="container">
		<div class="card">
			<div class="card-body">
				<form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
					@csrf

					<label for="title">title</label>
					<input type="text" name="title" id="title" class="form-control mb-3 @error('title') is-invalid @enderror"
						value="{{ old('title') }}">
					@error('title')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror

					<label for="type_id">Tipo</label>
					<select name="type_id" id="type_id" class="form-select mb-3 @error('type_id') is-invalid @enderror">
						<option value="">Nessun tipo</option>
						@foreach ($types as $type)
							<option @if (old('type_id') == $type->id) selected @endif value="{{ $type->id }}">{{ $type->label }}</option>
						@endforeach
					</select>
					@error('type_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
					<div>
						<p>Tecnologie:</p>
						@foreach ($technologies as $technology)
							<label for="technology-{{ $technology->id }}" class="me-2">{{ $technology->label }}</label>
							<input class="form-check-control mb-3 @error('technologies') is-invalid @enderror"
								id="technology-{{ $technology->id }}" name="technologies[]" type="checkbox" value="{{ $technology->id }}"
								@if (in_array($technology->id, old('technologies', $project_technologies ?? []))) checked @endif>
						@endforeach
						@error('technologies')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror
					</div>

					<div>
						<label for="is_published">Published </label>
						<input type="checkbox" name="is_published" id="is_published" class="form-check-control d-inline-block mb-3"
							@checked(old('is_published')) value="1">
					</div>

					<label for="link">link</label>
					<input type="file" name="link" id="link" class="form-control mb-3  @error('link') is-invalid @enderror"
						value="{{ old('link') }}">
					@error('link')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror

					<label for="description">description</label>
					<textarea type="textarea" name="description" id="description"
					 class="form-control mb-3 @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
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

@section('scripts')
@endsection
