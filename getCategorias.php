<?php

require_once 'models/Categorias.php';
$categoria = new Categorias();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
	$ret = $categoria->getCategorias();
	if (!empty($ret)) {
		http_response_code(200);
		print json_encode($ret, JSON_UNESCAPED_UNICODE);
	} else {
		http_response_code(404);
		print json_encode(array("message" => "Não há categorias"), JSON_UNESCAPED_UNICODE);
	}
} else {
	http_response_code(405);
	print json_encode(array("message" => "Método não permitido"), JSON_UNESCAPED_UNICODE);
}