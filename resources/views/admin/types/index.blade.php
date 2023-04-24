@extends('layouts.app')

@section('title')
	<div class="container">
		<div class="d-flex align-items-center justify-content-between">
			<h3 class="my-4"> Tutte le tipologie</h3>

			<a href="{{ route('admin.types.create') }}" class="btn btn-primary">Nuova tipologia</a>
		</div>
	</div>
@endsection

@section('content')
	<div class="container">
		<table class="table table-dark table-striped mt-5">
			<thead>
				<tr>
					<th scope="col">
						<a href="{{ route('admin.types.index') }}?sort=id&order=@if ($sort == 'id' && $order != 'DESC') DESC @else ASC @endif">ID
							@if ($sort == 'id')
								<i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
							@endif
						</a>
					</th>
					<th scope="col"><a
							href="{{ route('admin.types.index') }}?sort=label&order=@if ($sort == 'label' && $order != 'DESC') DESC @else ASC @endif">Label
							@if ($sort == 'label')
								<i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
							@endif
						</a>
					</th>
					<th scope="col"><a
							href="{{ route('admin.types.index') }}?sort=color&order=@if ($sort == 'color' && $order != 'DESC') DESC @else ASC @endif">Colore
							@if ($sort == 'color')
								<i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
							@endif
						</a>
					</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($types as $type)
					<tr>
						<th scope="row">{{ $type->id }}</th>
						<td>{{ $type->label }}</td>
						<td>
							<span class="badge rounded p-2 d-inline-block me-3"
								style="background-color:{{ $type->color }} "></span>{{ $type->color }}
						</td>
						<td>
							<div>
								<a href="{{ route('admin.types.show', $type) }}">
									<i class=" bi bi-eye mx-2"></i>
								</a>
								<a href="{{ route('admin.types.edit', $type) }}" class="text-warning">
									<i class="bi bi-pencil mx-2"></i>
								</a>

								<a type="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $type->id }}">
									<i class="bi bi-trash mx-2"></i>
								</a>

								@foreach ($types as $type)
									<!-- Modal -->
									<div class="modal fade text-dark" id="delete-modal-{{ $type->id }}" tabindex="-1"
										aria-labelledby="delete-modal-{{ $type->id }}-label" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h1 class="modal-title fs-5" id="delete-modal-{{ $type->id }}-label">
														Conferma eliminazione</h1>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body text-start">
													Sei sicuro di voler eliminare la tipologia
													<strong>{{ $type->label }}</strong>
													<br>
													L'operazione non è reversibile
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

													<form action="{{ route('admin.types.destroy', $type) }}" method="POST" class="">
														@method('DELETE')
														@csrf

														<button type="submit" class="btn btn-danger">Elimina</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		{{ $types->links('pagination::bootstrap-5') }}
	</div>
@endsection
