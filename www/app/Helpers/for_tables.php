<?php

declare(strict_types=1);

if (!function_exists('renderTableHead')) {

  function renderTableHead(
    array $columnas,
    int $currentOrder = 1,
    string $queryParams = '',
    ?string $baseUrl = null
  ): string {

    $result = "<thead>  <tr>";


    //  strtok(cadena, '?'); divide la cadena en partes, se queda con lo que esta antes del '?' 
    // aqui si no hay request uri, imprimiria /
    // y a eso le quita lo de despues de ? (si hubiese algun ?)
    if ($baseUrl === null) {
      $baseUrl = strtok(($_SERVER['REQUEST_URI'] ?? '/'), '?');
    }

    $i = 1;


    foreach ($columnas as $columna) {
      //el orden del link to go es -actual si ya estamos en actual, y actual si estamos en otro
      $order = ($currentOrder === $i) ? -$i : $i;

      $urlOrdenacion = "{$baseUrl}?order={$order}";

      if ($queryParams !== '') {
        $urlOrdenacion .= "&{$queryParams}";
      } else {
        //no cambies nada en url ordenacion
      }

      $result .= '<th><a href="' . htmlspecialchars($urlOrdenacion) . '">'
        . htmlspecialchars($columna)
        . '</a>';

      // icono depende la dirección actual.
      if (abs($currentOrder) === $i) {

        $result .= ($currentOrder < 0)
          ? ' <i class="fas fa-sort-amount-down-alt"></i>'
          : ' <i class="fas fa-sort-amount-up-alt"></i>';
      }

      $result .= '</th>';

      $i++;
    }
    $result .= " </tr></thead>";
    return $result;
  }
}
