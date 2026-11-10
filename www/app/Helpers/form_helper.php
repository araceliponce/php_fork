<?php

declare(strict_types=1);

if (!function_exists('printTableHeader')) {


  /**
   * @param array $cabeceras array obligatorio con los nombres de las cabeceras
   * @param int $currentOrder campo por el que se está ordenando el listado actualmente
   * @param string $queryParams parámetros get de filtrado
   * @param string|null $baseUrl url relativa del enlace. Si es vacía se asume la current_url
   * @return string thead completo para una tabla
   */
  function printTableHeader(
    array $cabeceras,
    int $currentOrder = 1,
    string $queryParams = '',
    ?string $baseUrl = null
  ): string {

    $result = '<thead><tr>';




    // en http://localhost/plantas?categoria=2&page=3
    // $_SERVER['REQUEST_URI'] es /plantas?categoria=2&page=3

    //  strtok($uri, '?'); divide la cadena en partes, se queda con lo que esta antes del '?' /plants

    if ($baseUrl === null) {
      // si no hay request uri, imprimiria /
      // y a eso le quita lo de despues de ? (si hubiese algun ?)
      $baseUrl = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    }

    $i = 1;

    foreach ($cabeceras as $value) {

      // Si estamos en la columna actual, invertimos el orden.
      // Si no, empezamos en ASC.
      $order = ($currentOrder === $i) ? -$i : $i;

      $urlOrdenacion = "{$baseUrl}?order={$order}";

      $urlOrdenacion .= ($queryParams === '')
        ? ''
        : "&{$queryParams}";

      $result .= '<th><a href="' . htmlspecialchars($urlOrdenacion) . '">'
        . htmlspecialchars($value)
        . '</a>';

      // Indicamos visualmente la dirección actual.
      if (abs($currentOrder) === $i) {

        $result .= ($currentOrder < 0)
          ? ' <i class="fas fa-sort-amount-down-alt"></i>'
          : ' <i class="fas fa-sort-amount-up-alt"></i>';
      }

      $result .= '</th>';

      $i++;
    }

    $result .= '</tr></thead>';

    return $result;
  }
}
