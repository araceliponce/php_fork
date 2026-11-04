<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PDOException;

class ProductoModel extends BaseDbModel
{


  private const  ORDER_FIELDS = ['p.id_producto', 'p.codigo', 'p.nombre', 'p.coste', 'p.margen', 'p.stock', 'p.iva', 'prov.nombre'];
  private const DEFAULT_ORDER_INDEX = 1;

  // IMPORTANTE: proveedor_cif es un alias, no una columna real de la tabla proveedor. LLAMALO POR SU NOMBRE EN EL WHERE y en order_fields (el alias es solo par alos tds de la tabla????)
  private const  SELECT_FROM = "SELECT p.*, prov.cif as proveedor_cif, prov.nombre as proveedor_nombre, cat.id_categoria as categoria_id, cat.nombre_categoria as categoria_nombre FROM producto p LEFT JOIN proveedor prov ON p.proveedor = prov.cif LEFT JOIN categoria cat ON cat.id_categoria = p.id_categoria";

  public function simplyGetProductos(): array
  {
    $res = $this->pdo->query('SELECT * FROM producto')->fetchAll();
    return $res;
  }
  public function oldgetProductos(): array
  {
    $sql = self::SELECT_FROM;
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
  }

  public function getProductos(array $filtros): array
  {
    $sql = self::SELECT_FROM;
    $condiciones = [];
    $valores = [];

    $order = $this->getColumnaOrdenadora($filtros); // puede ser positiva o negativa
    $direction = $order < 0 ? 'desc' : 'asc';

    if (!empty($filtros['nombre'])) {
      $condiciones[] = "p.nombre LIKE :nombre";
      $valores[':nombre'] = '%' . $filtros['nombre'] . '%';
    }
    if (!empty($filtros['codigo'])) {
      $condiciones[] = "p.codigo LIKE :codigo";
      $valores[':codigo'] = '%' . $filtros['codigo'] . '%';
    }

    if (!empty($filtros['proveedores']) && is_array($filtros['proveedores'])) {
      $proveedoresvalores = [];
      $i = 1;
      //uso un foreach con guion bajo      abro corchetes dolar i cierro corchetes
      foreach ($filtros['proveedores'] as $item) {
        $proveedoresvalores[":proveedores_{$i}"] = $item;
        $i++;
      }

      //obtengo las keys
      $llaves = array_keys($proveedoresvalores);
      //implode
      $condiciones[] = "prov.cif IN (" . implode(', ', $llaves) . ")";
      //merge
      $valores = array_merge($valores, $proveedoresvalores);
    }


    //añade el where condicio1 and condicion2....
    if ($condiciones !== []) {
      $sql .= " WHERE " . implode(' AND ', $condiciones);
    }



    // añade el orden, usando el valor limpio de la columna (ejemplo si es -2, usa 2 y direccion desc) 
    $sql .= " ORDER BY "
      . self::ORDER_FIELDS[abs($order) - 1]
      . " "
      . $direction;

    var_dump($sql);
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($valores);
    return $stmt->fetchAll();
  }

  public function getColumnaOrdenadora(array $filtros): int
  {
    if (empty($filtros['order'])) {
      return self::DEFAULT_ORDER_INDEX;
    } else if ($filtros['order'] == 0 && filter_var($filtros['order'], FILTER_VALIDATE_INT) === false) {
      return self::DEFAULT_ORDER_INDEX;
    } else {
      return (int)$filtros['order'];
    }
  }
}
