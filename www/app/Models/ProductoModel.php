<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use Com\Daw2\Libraries\SQLConditions;
use PDO;
use PDOException;

class ProductoModel extends BaseDbModel
{


  private const  ORDER_FIELDS = ['p.id_producto', 'p.codigo', 'p.nombre', 'p.coste', 'p.margen', 'p.stock', 'p.iva', 'prov.nombre'];
  private const DEFAULT_ORDER_INDEX = 1;
  private const ROWS_PER_PAGE = 20;

  // IMPORTANTE: proveedor_cif es un alias, no una columna real de la tabla proveedor. LLAMALO POR SU NOMBRE EN EL WHERE y en order_fields (el alias es solo par alos tds de la tabla????)
  // https://dev.mysql.com/doc/refman/9.7/en/problems-with-alias.html 
  // You can use the alias in GROUP BY, ORDER BY, or HAVING clauses to refer to the column. standard SQL disallows references to column aliases in a WHERE clause. 

  private const  FROM = " FROM producto p 
  LEFT JOIN proveedor prov ON p.proveedor = prov.cif 
  LEFT JOIN categoria cat ON cat.id_categoria = p.id_categoria
  ";

  private const SELECT_COUNT = "SELECT COUNT(*) as total " . self::FROM;
  private const  SELECT_FROM = "SELECT 
  p.*, prov.cif as proveedor_cif, 
  prov.nombre as proveedor_nombre, 
  cat.id_categoria as categoria_id, 
  cat.nombre_categoria as categoria_nombre  
  " . self::FROM;

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

    $sqlConditions = $this->generateWhereByFilter($filtros);
    $sql .= $sqlConditions->whereSQL;

    // añade el orden, usando el valor limpio de la columna (ejemplo si es -2, usa 2 y direccion desc) 
    $order = $this->getColumnaOrdenadora($filtros); //positivo o negativo
    $direccion = $order < 0 ? ' DESC ' : ' ASC ';
    $sql .= " ORDER BY " . self::ORDER_FIELDS[abs($order) - 1]  . " " . $direccion;

    var_dump($sql);


    $currentPage = $this->getCurrentPage($filtros);
    $sql .= " LIMIT " . (($currentPage - 1) * self::ROWS_PER_PAGE) . ", " . self::ROWS_PER_PAGE;

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($sqlConditions->values);
    return $stmt->fetchAll();
  }



  //tendra condiciones[], valores[] y todos los filtros y returna objeto SQLCONDITIONS
  private function generateWhereByFilter(array $filtros): SQLConditions
  {
    $condiciones = [];
    $valores = [];

    if (!empty($filtros['nombre'])) {
      $condiciones[] = "p.nombre LIKE :nombre";
      $valores[':nombre'] = "%" . $filtros['nombre'] . "%";
    }

    if (!empty($filtros['codigo'])) {
      $condiciones[] = "p.codigo LIKE :codigo";
      $valores[':codigo'] = "%" . $filtros['codigo'] . "%";
    }

    if (!empty($filtros['min_coste'])) {
      $condiciones[] = "p.coste >= :min_coste";
      $valores[':min_coste'] = $filtros['min_coste'];
    }
    if (!empty($filtros['max_coste'])) {
      $condiciones[] = "p.coste <= :max_coste";
      $valores[':max_coste'] = $filtros['max_coste'];
    }

    if (!empty($filtros['min_iva'])) {
      $condiciones[] = 'p.iva >= :p_iva';
      $valores[':p_iva'] = $filtros['min_iva'];
    }

    //categorias
    if (!empty($filtros['categorias']) && is_array($filtros['categorias'])) {

      //hago un for
      //le quito las llvaes a lo que se obtuvo
      // implode con , las llaves
      //merge sin corchetes , de los valores

      $categoriasvalores = [];
      $i = 1;
      foreach ($filtros['categorias'] as $item) {
        $categoriasvalores[":categorias_{$i}"] = $item;
        $i++;
      }
      $llaves = array_keys($categoriasvalores);
      $condiciones[] = "p.id_categoria IN (" . implode(" , ", $llaves) . " ) ";
      $valores = array_merge($valores, $categoriasvalores);
    }

    if (!empty($filtros['proveedores']) && is_array($filtros['proveedores'])) {
      $proveedoresvalores = [];
      $i = 1;
      foreach ($filtros['proveedores'] as $item) {
        $proveedoresvalores[":proveedores_{$i}"] = $item;
        $i++;
      }
      // obtengo las llaves del array local
      $llaves = array_keys($proveedoresvalores);
      //uso implode en las llaves...... atributo in(llave1, llave2,....)
      $condiciones[] = "prov.cif in (" . implode(', ', $llaves) . ")";
      //mergeo de valores superior y array local
      $valores = array_merge($valores, $proveedoresvalores);
    }


    // var_dump($condiciones);
    //si condiciones no esta vacio
    if ($condiciones !== []) {
      return new SQLConditions(" WHERE " . implode(" AND ", $condiciones), $valores);
    } else {
      return new SQLConditions("", []);
    }
  }

  private function getCountFilterBy(array $filtros): int
  {
    $sql = self::SELECT_COUNT;
    $sqlConditions = $this->generateWhereByFilter($filtros);
    $sql .= $sqlConditions->whereSQL;
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($sqlConditions->values);
    return $stmt->fetchColumn(0);
  }


  public function getLastPage(array $filtros): int
  {
    return (int)ceil($this->getCountFilterBy($filtros) / self::ROWS_PER_PAGE);
  }

  public function getCurrentPage(array $filtros): int
  {
    return !empty($filtros['page']) && filter_var($filtros['page'], FILTER_VALIDATE_INT) ? (int)$filtros['page'] : 1;
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
