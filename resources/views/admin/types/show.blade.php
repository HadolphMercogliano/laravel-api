@extends('layouts.app')

@section('title')
	<div class="container">
		<div class="d-flex align-items-center justify-content-between">
			<h3 class="my-4"> Tipologia: {{ $type->label }}</h3>

			<a href="{{ route('admin.types.index') }}" class="btn btn-primary">Torna all'indice</a>

		</div>
	</div>
@endsection

@section('content')
	<div class="container">

		<div class="row justify-content-center align-items-center mb-3">
			<div class="card col-12 p-3">
				<div class="card-body d-flex justify-content-between align-items-center">

					<h3 class="card-title mb-4 "><strong>Label:</strong> {{ $type->label }}</h3>
					<p class="card-text mb-4"><strong>Colore:</strong> <span class="badge rounded-pill"
							style="background-color:{{ $type->color }} ">{{ $type->color }}</span></p>

					<p class="card-text mb-4"><strong>Data creazione:</strong> <br>{{ $type->created_at }}</p>
					<p class="card-text mb-4"><strong>Ultima modifica:</strong> <br>{{ $type->updated_at }}</p>

					<a href="{{ route('admin.types.edit', $type) }}" class=" btn btn-primary"> Modifica tipologia</a>
				</div>
			</div>
		@endsection
