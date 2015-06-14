<?php

$result = [
	'surname' => 'John',
	'lastname' => 'Doe',
	'email' => 'john@doe.com'
];

header("Content-Type: text/javascript");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
echo json_encode($result);
exit;
