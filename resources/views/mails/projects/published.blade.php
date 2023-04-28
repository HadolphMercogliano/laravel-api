<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<style type="text/css">
		/* Style per il body */
		body {
			background-color: #fff5f5;
			font-family: Arial, sans-serif;
			font-size: 16px;
			line-height: 1.4;
			color: #333333;
			margin: 0;
			padding: 0;
		}

		/* Style per il contenitore principale */
		.container {
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			background-color: #ffffff;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		/* Style per il titolo della email */
		h1 {
			font-size: 24px;
			font-weight: bold;
			margin-bottom: 20px;
			text-align: center;
		}

		/* Style per i dettagli del post */
		.post-details {
			background-color: #f8f8f8;
			border: 1px solid #e3e3e3;
			border-radius: 5px;
			margin-bottom: 20px;
			padding: 10px;
		}

		/* Style per il testo in grassetto */
		strong {
			font-weight: bold;
		}
	</style>
</head>

<body>
	<div class="container">
		<h1>Progetto {{ $is_published }} correttamente </h1>
		<p>Ciao Utente,</p>
		<p>Ti informiamo che il progetto intitolato "<strong>{{ $project->title }}</strong>" è stato {{ $is_published }}
			correttamente.</p>
		<div class="post-details">
			<p><strong>Titolo:</strong> {{ $project->title }}</p>
			<p><strong>Estratto:</strong> {{ $project->getAbstract(100) }}</p>
		</div>
		<p>Il team di {{ config('app.name') }}</p>
	</div>
</body>

</html>
