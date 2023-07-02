<?php

require_once 'models/Votos.php';

$votos = new Votos();

foreach ($_POST['data'] as $voto) {
    $sql = $votos->insertVotos($voto);
}
http_response_code(200);