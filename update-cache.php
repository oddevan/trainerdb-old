<?php

require_once 'config.php';

$options = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO('mysql:host=' . TDB_DBSERVER . ';dbname=' . TDB_DBNAME,
							 TDB_DBUSER,
							 TDB_DBPASS, $options);

use Pokemon\Pokemon;
require __DIR__ . '/vendor/autoload.php';

$options = [ 'verify' => false ];

$set_response = Pokemon::Set( $options )->all();
foreach ( $set_response as $set_obj ) {
	$set = $set_obj->toArray();
}

