<?php

declare(strict_types=1);

if (!function_exists('creaTablaHeader')) {

  function creaTablaHeader(
    array $columnas,
    int $currentOrder = 1,
    string $queryParams = '',
    ?string $baseUrl = null
  ): string {

    $res = "<theader>  <tr>";

    if ($baseUrl === null) {
      $baseUrl = strtok(($_SERVER['REQUEST_URI'] ?? '/'), '?');
    }

    $i = 1;

    //el orden del link to go es -actual si ya estamos en actual, y actual si estamos en otro
    $order = ($currentOrder === $i) ? -$i : $i;

    $urlOrdenacion = "{$baseUrl}?order={$order}";

    if ($queryParams !== '') {
      $urlOrdenacion .= "&{$queryParams}";
    }


    // $res.= '<th> <a href="'. htmlspecialchars($urlOrdenacion). '">' . htmlspecialchars($columna)'</th>'
    foreach ($columnas as $columna) {
      $urlToGo = htmlspecialchars($urlOrdenacion);
      $res .= "<td><a href='{$urlToGo}'>" . htmlspecialchars($columna) . "</a></td>";
    }
    $res .= " </tr></theader>";
    return $res;
  }
}
