<?php
require_once('autoload.php');
$m = new MP;
$m->setData_hora("2019-08-08 10:12:19");

$mp = new MPThread;
$mp->setMensagem($m);

var_dump($mp->tempoDesdeUltimaMsg());

?>