<?php
setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
date_default_timezone_set('America/Mexico_City');

$fecha = new DateTime($fechaBD);
$ahora = new DateTime('now', new DateTimeZone('America/Mexico_City'));

$diferencia = $ahora->getTimestamp() - $fecha->getTimestamp();

if ($diferencia < 60) {
    $formato_fecha = 'hace unos segundos';
} elseif ($diferencia < 3600) {
    $minutos = floor($diferencia / 60);
    $formato_fecha = 'hace ' . $minutos . ($minutos > 1 ? ' minutos' : ' minuto');
} elseif ($diferencia < 86400) {
    $horas = floor($diferencia / 3600);
    $formato_fecha = 'hace ' . $horas . ($horas > 1 ? ' horas' : ' hora');
} elseif ($diferencia < 172800) {
    $formato_fecha = 'ayer';
} else {
    $formato_fecha = strftime('%e de %B', $fecha->getTimestamp());
}
?>
