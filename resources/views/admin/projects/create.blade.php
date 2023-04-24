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
					<input type="text" name="title" id="title" class="form-control mb-3">

					<label for="type_id">Tipo</label>
					<select name="type_id" id="type_id" class="form-select mb-3">
						<option value="">Nessun tipo</option>
						@foreach ($types as $type)
							<option value="{{ $type->id }}">{{ $type->label }}</option>
						@endforeach
					</select>

					<div>
						<label for="is_published">Published </label>
						<input type="checkbox" name="is_published" id="is_published" class="form-check-control d-inline-block mb-3"
							value="1">
					</div>

					<label for="link">link</label>
					<input type="file" name="link" id="link" class="form-control mb-3">

					<label for="description">description</label>
					<textarea type="textarea" name="description" id="description" class="form-control mb-3" rows="3"></textarea>

					<input type="submit" class="btn btn-primary" value="Salva">
				</form>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
@endsection
