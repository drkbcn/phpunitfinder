<?php
/**
 * 2020 Labelgrup.com
 *
 * NOTICE OF LICENSE
 *
 * READ ATTACHED LICENSE.TXT
 *
 *  @author    Manel Alonso <malonso@labelgrup.com>
 *  @copyright 2020 Labelgrup
 *  @license   LICENSE.TXT
 */
/*
 * Función que busca de forma recursiva un patrón
 */
function rsearch($folder, $pattern) {
    $iti = new RecursiveDirectoryIterator($folder);
    foreach (new RecursiveIteratorIterator($iti) as $file) {
        if (strpos($file, $pattern) !== false) {
            return $file;
        }
    }
    return false;
}

// Llamamos a la función en busca de PHPUnit, fichero
$ruta = rsearch('modules', 'eval-stdin.php');

if ($ruta !== false) {
    echo '<span style="color:red">Posible vulnerabilidad encontrada en: </span><i>' . $ruta . '</i>';
    // Abrimos el fichero para buscar si usa php://input en vez de php://stdin
    $contenido = file_get_contents($ruta);
    $texto_repetir = '<br><br><b>Una vez eliminado, vuelve a ejecutar ésta utilidad.</b>';
    if (strpos($contenido, 'input') !== false) {
        echo '<br>!!! Fichero vulnerable !!!.' . $texto_repetir;
    } else {
        echo '<br>Fichero no vulnerable. Por precaución ejecuta: "composer install --no-dev" en el directorio.'
        . $texto_repetir;
    }
} else {
    echo '<br>No se encontró la vulnerabilidad';
}

?>