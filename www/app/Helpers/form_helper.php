<?php

declare(strict_types=1);

if (!function_exists('printTableHeader')) {

  function printTableHeader(
    array $cabeceras,
    int $currentOrder = 1,
    string $queryParams = '',
    ?string $baseUrl = null
  ): string {

    $result = '<thead><tr>';

    if ($baseUrl === null) {
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
