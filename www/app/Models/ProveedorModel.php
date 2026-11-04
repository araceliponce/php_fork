<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PDOException;

class ProveedorModel extends BaseDbModel
{

  private const string SELECT_FROM = "SELECT cif as proveedor_cif, nombre as proveedor_nombre FROM proveedor";

  public function getAll(): array
  {
    $sql = self::SELECT_FROM;
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
  }
}
