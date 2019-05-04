<?php
/**
 * Home page
 *
 * Basically just the main page for now.
 *
 * @package eph\trainerdb
 * @since 2019-04-21
 */

require_once 'config.php';

use Pokemon\Pokemon;
require __DIR__ . '/vendor/autoload.php';

$setmap = array();

/**
 * Change 'verify' option to true to fix the following error:
 *
 * Fatal error: Uncaught exception 'GuzzleHttp\Exception\ConnectException' with message
 * 'cURL error 35: Unknown SSL protocol error in connection to api.pokemontcg.io:-9838
 * (see http://curl.haxx.se/libcurl/c/libcurl-errors.html)'
 */
$options = [ 'verify' => false ];
$response = Pokemon::Set( $options )->all();
foreach ( $response as $set ) {
	$setinfo = $set->toArray();
	$setmap[ $setinfo['code'] ] = $setinfo['symbolUrl'];
}

$options = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO('mysql:host=' . TDB_DBSERVER . ';dbname=' . TDB_DBNAME,
							 TDB_DBUSER,
							 TDB_DBPASS, $options);

 
$cardquery->execute();
$allcards = $cardquery->fetchAll();
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
		<div class="container">
			<h1>All cards</h1>

			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">Name</th>
						<th scope="col">Set</th>
						<th scope="col">Normal</th>
						<th scope="col">Reverse</th>
						<th scope="col">Alt. Art Promo</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ( $allcards as $card ) :
							try {
								$cardresponse = Pokemon::Card( $options )->find( $card['pk_setnum'] . '-' . $card['pk_cardnum'] );
								$cardinfo     = $cardresponse->toArray();
							} catch ( InvalidArgumentException $ex ) {
								$cardinfo = [ 'name' => '-- not found ' . $card['pk_cardnum'] ];
							}
					?>
					<tr>
						<th scope="row"><?= $cardinfo['name'] ?></th>
						<td><img style="max-width:50px;height:auto;" src="<?= $setmap[ $card['pk_setnum'] ] ?>"></td>
						<td><?= $card['quantity'] ?></td>
						<td><?= $card['quantity_alt'] ?></td>
						<td><?= $card['quantity_promo'] ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>

