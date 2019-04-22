<?php
/**
 * Home page
 *
 * Basically just the main page for now.
 *
 * @package eph\trainerdb
 * @since 2019-04-21
 */

use Pokemon\Pokemon;
require __DIR__ . '/vendor/autoload.php';

/**
 * Change 'verify' option to true to fix the following error:
 *
 * Fatal error: Uncaught exception 'GuzzleHttp\Exception\ConnectException' with message
 * 'cURL error 35: Unknown SSL protocol error in connection to api.pokemontcg.io:-9838
 * (see http://curl.haxx.se/libcurl/c/libcurl-errors.html)'
 */
$options = [ 'verify' => false ];
$response = Pokemon::Set( $options )->all();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<title>TrainerDB</title>
	</head>
  <body>
		<h1>All sets</h1>

		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">Code</th>
					<th scope="col">Icon</th>
					<th scope="col">Name</th>
					<th scope="col">Released</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $response as $set ) : $setinfo = $set->toArray(); ?>
				<tr>
					<th scope="row"><?= $setinfo['code'] ?></th>
					<td><img src="<?= $setinfo['symbolUrl'] ?>"></td>
					<td><?= $setinfo['name'] ?></td>
					<td><?= $setinfo['releaseDate'] ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>

