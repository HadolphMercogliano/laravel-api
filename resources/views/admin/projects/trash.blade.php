@extends('layouts.app')

@section('title')
	<div class="container">
		<div class="d-flex align-items-center justify-content-between">
			<h3 class="my-4"> Progetti cestinati</h3>

			<a href="{{ route('admin.projects.index') }}" class="btn btn-primary">Torna alla lista</a>
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
							href="{{ route('admin.projects.trash') }}?sort=id&order=@if ($sort == 'id' && $order != 'DESC') DESC @else ASC @endif">ID
							@if ($sort == 'id')
								<i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
							@endif
						</a>
					</th>
					<th scope="col">
						<a
							href="{{ route('admin.projects.trash') }}?sort=title&order=@if ($sort == 'title' && $order != 'DESC') DESC @else ASC @endif">Nome
							@if ($sort == 'title')
								<i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
							@endif
						</a>
					</th>
					<th scope="col">
						<a
							href="{{ route('admin.projects.trash') }}?sort=description&order=@if ($sort == 'description' && $order != 'DESC') DESC @else ASC @endif">Descrizione
							@if ($sort == 'description')
								<i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
							@endif
						</a>
					</th>
					<th scope="col">
						<a
							href="{{ route('admin.projects.trash') }}?sort=deleted_at&order=@if ($sort == 'deleted_at' && $order != 'DESC') DESC @else ASC @endif">
							Cancellato il:
							@if ($sort == 'deleted_at')
								<i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
							@endif
						</a>
					</th>
					<th scope="col">Link</th>
					<th scope="col">Actions</th>

				</tr>
			</thead>
			<tbody>
				@forelse ($projects as $project)
					<tr>
						<th scope="row">{{ $project->id }}</th>
						<td>{{ $project->title }}</td>
						<td>{{ $project->getAbstract() }}</td>
						<td>{{ $project->deleted_at }}</td>
						<td>{{ $project->getLinkUri() }}</td>
						<td>
							<a type="button" data-bs-toggle="modal" data-bs-target="#restore-modal-{{ $project->id }}">
								<i class="bi bi-box-arrow-up-left mx-2"></i>
							</a>
							<a type="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $project->id }}">
								<i class="bi bi-trash mx-2"></i>
							</a>
							@foreach ($projects as $project)
								<!-- Modal -->
								<div class="modal fade text-dark" id="restore-modal-{{ $project->id }}" tabindex="-1"
									aria-labelledby="restore-modal-{{ $project->id }}-label" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h1 class="modal-title fs-5" id="restore-modal-{{ $project->id }}-label">
													Conferma ripristino</h1>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body text-start">
												Sei sicuro di voler ripristinare il progetto
												<strong>{{ $project->title }}</strong>?
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

												<form action="{{ route('admin.projects.restore', $project) }}" method="POST" class="">
													@method('put')
													@csrf

													<button type="submit" class="btn btn-primary">Ripristina</button>
												</form>
											</div>
										</div>
									</div>
								</div>

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
												Sei sicuro di voler eliminare definitivamente il progetto
												<strong>{{ $project->title }}</strong>
												<br>
												L'operazione non è reversibile
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

												<form action="{{ route('admin.projects.force-delete', $project) }}" method="POST" class="">
													@method('DELETE')
													@csrf

													<button type="submit" class="btn btn-danger">Elimina</button>
												</form>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</td>
					</tr>
				@empty
					<th colspan="6">Nessun progetto nel cestino</th>
				@endforelse
			</tbody>
		</table>
		{{ $projects->links('pagination::bootstrap-5') }}
	</div>
@endsection
