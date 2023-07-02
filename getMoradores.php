<?php

require_once 'models/Moradores.php';

$morador = new Moradores();


if ($_SERVER['REQUEST_METHOD'] == "GET") {
	$ret = $morador->getMoradores();

	if (!empty($ret)) {

		http_response_code(200);
		print json_encode($ret, JSON_UNESCAPED_UNICODE);

	} else {

		http_response_code(404);
		print json_encode(['error' => 'Morador não encontrado'], JSON_UNESCAPED_UNICODE);

	}
} else {

	http_response_code(500);
	print json_encode(['error' => 'Internal Server Error'], JSON_UNESCAPED_UNICODE);
}