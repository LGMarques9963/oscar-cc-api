<?php

require_once 'models/Votos.php';

$votos = new Votos();
$ret = $votos->getVotos();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
	if (!empty($ret)) {

		http_response_code(200);
		print json_encode($ret, JSON_UNESCAPED_UNICODE);

	} else {

		http_response_code(404);
		print json_encode(['error' => 'No hay votos'], JSON_UNESCAPED_UNICODE);

	}

} else {

	http_response_code(405);
	print json_encode(['error' => 'Método no permitido'], JSON_UNESCAPED_UNICODE);

}