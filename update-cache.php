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

$setcheck  = $pdo->prepare('SELECT `id` FROM `sets` where `pk_id` = ?');
$setinsert = $pdo->prepare('INSERT INTO `sets` (`pk_id`, `pk_imgurl`, `pk_name`, `pk_date`) VALUES (?, ?, ?, ?)');
$setupdate = $pdo->prepare('UPDATE `sets` SET `pk_id` = ?, `pk_imgurl` = ?, `pk_name` = ?, `pk_date` = ? WHERE `id` = ?');

$cardcheck  = $pdo->prepare('SELECT TOP(1) `id` FROM `cards` where `pk_cardnum` = ? AND `set_id` = ?');
$cardinsert = $pdo->prepare('INSERT INTO `cards` (`pk_id`, `pk_imgurl`, `pk_name`, `pk_date`) VALUES (?, ?, ?, ?)');
$cardupdate = $pdo->prepare('UPDATE `cards` SET `pk_imgurl` = ?, `pk_name` = ?, `pk_date` = ? WHERE `id` = ?');



use Pokemon\Pokemon;
require __DIR__ . '/vendor/autoload.php';

$options = [ 'verify' => false ];

$set_response = Pokemon::Set( $options )->all();
foreach ( $set_response as $set_obj ) {
	$set = $set_obj->toArray();
	
}

