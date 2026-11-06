<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PDOException;

class CategoriaModel extends BaseDbModel
{

  private const string SELECT_FROM = "SELECT cat.id_categoria as subcategoria_id, cat.nombre_categoria as subcategoria_nombre, cat.id_padre as subcategoria_padre FROM categoria cat";

  //se une a si mismo, si el id de la supercat  = padre de la categoria
  //selecciona solo las supercategorias
  private const SELECT_SUPER = "SELECT
	distinct supercat.nombre_categoria as supercategoria_nombre,
    supercat.id_categoria as supercategoria_id
  FROM
    categoria cat
  LEFT JOIN categoria supercat 
  ON	supercat.id_categoria = cat.id_padre
  where supercat.id_categoria is not null;";


  private const string SELECT_SUB = self::SELECT_FROM . " WHERE cat.id_padre IS NOT null";



  public function getAll(): array
  {
    $sql = self::SELECT_FROM;
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
  }

  public function getSuper(): array
  {
    $sql = self::SELECT_SUPER;
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
  }
  public function getSub(): array
  {
    $sql = self::SELECT_SUB;
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
  }
}
