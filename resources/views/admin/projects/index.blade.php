@extends('layouts.app')

@section('title')
	<div class="container">
		<div class="d-flex align-items-center justify-content-between">
			<h3 class="my-4"> Tutti i progetti</h3>
			<div>
				<a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Nuovo progetto</a>
				<a href="{{ route('admin.projects.trash') }}" class="btn btn-secondary">Cestino</a>
			</div>

		</div>
	</div>
@endsection

@section('content')
	<div class="container">
		<table class="table table-dark table-striped mt-5">
			<thead>
				<tr>
					<th scope="col">
						<a
							href="{{ route('admin.projects.index') }}?sort=id&order=@if ($sort == 'id' && $order != 'DESC') DESC @else ASC @endif">ID
							@if ($sort == 'id')
								<i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
							@endif
						</a>
					</th>
					<th scope="col"><a
							href="{{ route('admin.projects.index') }}?sort=title&order=@if ($sort == 'title' && $order != 'DESC') DESC @else ASC @endif">Nome
							@if ($sort == 'title')
								<i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
							@endif
						</a>
					</th>
					<th scope="col"><a
							href="{{ route('admin.projects.index') }}?sort=type_id&order=@if ($sort == 'type_id' && $order != 'DESC') DESC @else ASC @endif">Tipo
							@if ($sort == 'type_id')
								<i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
							@endif
						</a>
					</th>
					<th scope="col">Tecnologie</th>
					<th scope="col"><a
							href="{{ route('admin.projects.index') }}?sort=description&order=@if ($sort == 'description' && $order != 'DESC') DESC @else ASC @endif">Descrizione
							@if ($sort == 'description')
								<i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
							@endif
						</a></th>
					<th scope="col">Link</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($projects as $project)
					<tr>
						<th scope="row">{{ $project->id }}</th>
						<td>{{ $project->title }}</td>
						<td><span class="badge rounded-pill p-2 d-inline-block me-3"
								style="background-color:{{ $project->type?->color }} ">{{ $project->type?->label }}</span></td>
						<td>
							@forelse ($project->technologies as $technology)
								<span class="badge rounded-pill p-2 d-inline-block me-1 mb-1"
									style="background-color:{{ $technology->color }} ">{{ $technology->label }}</span>
							@empty
								-
							@endforelse
						</td>
						<td>{{ $project->getAbstract() }}</td>
						<td>{{ $project->getLinkUri() }}</td>

						<td>
							<div>
								<a href="{{ route('admin.projects.show', $project) }}">
									<i class=" bi bi-eye mx-2"></i>
								</a>
								<a href="{{ route('admin.projects.edit', $project) }}" class="text-warning">
									<i class="bi bi-pencil mx-2"></i>
								</a>

								<a type="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $project->id }}">
									<i class="bi bi-trash mx-2"></i>
								</a>
								@foreach ($projects as $project)
									<!-- Modal -->
									<div class="modal fade text-dark" id="delete-modal-{{ $project->id }}" tabindex="-1"
										aria-labelledby="delete-modal-{{ $project->id }}-label" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h1 class="modal-title fs-5" id="delete-modal-{{ $project->id }}-label">
														Conferma eliminazione</h1>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body text-start">
													Sei sicuro di voler eliminare il progetto
													<strong>{{ $project->title }}</strong>
													<br>
													L'operazione non è reversibile
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

													<form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="">
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
		{{ $projects->links('pagination::bootstrap-5') }}
	</div>
@endsection
