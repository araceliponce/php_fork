<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PDOException;

class ProductoModel extends BaseDbModel
{
  // private const  ORDER_FIELDS = ['t.username', 't.salarioBruto', 't.retencionIRPF', 'nombre_rol', 'country_name'];
  // private const DEFAULT_ORDER_INDEX = 1;

  private const  SELECT_FROM = "SELECT prod.* FROM producto prod LEFT JOIN proveedor prov ON prod.proveedor = prov.cif LEFT JOIN categoria cat ON cat.id_categoria = prod.id_categoria";

  public function simplyGetProductos(): array
  {
    $res = $this->pdo->query('SELECT * FROM producto')->fetchAll();
    return $res;
  }
  public function getProductos(): array
  {
    $sql = self::SELECT_FROM;
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
  }

  public function getAppending(): array
  {
    $sql = self::SELECT_FROM . " ORDER BY ... DESC";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
  }
}
