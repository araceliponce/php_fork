<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use Com\Daw2\Libraries\SQLConditions;
use PDO;
use PDOException;

class UsuarioSistemaModel extends BaseDbModel
{


  // private const  SELECT_FROM = "SELECT u.*, u.nombre as username, r.rol as nombre_rol, r.descripcion_en as descripcion_rol_en, r.descripcion_es as descripcion_rol_es FROM usuario_sistema u LEFT JOIN aux_rol r ON r.id_rol = u.id_rol";

  private const SELECT = 'SELECT u.* , u.nombre as username, ar.rol as nombre_rol, ar.descripcion_en as descripcion_rol_en, ar.descripcion_es as descripcion_rol_es';
  private const FROM = ' FROM usuario_sistema u LEFT JOIN aux_rol ar ON ar.id_rol = u.id_rol';
  private const SELECT_COUNT = 'SELECT COUNT(*)' . self::FROM;
  private const SELECT_FROM = self::SELECT . self::FROM;


  private const array COLUMNAS_ORDENADORAS = ['u.nombre', 'ar.rol', 'u.email', 'u.last_date', 'u.idioma'];
  private const array COLUMNAS_NOMBRES = ['nombre', 'rol', 'email', 'last_date', 'idioma', 'acciones'];

  private const DEFAULT_ORDER = 1;
  private const PAGE_SIZE = 10;


  // self:: se usa para private things
  // $this -> se usa para public things
  public function simplyGetProductos(): array
  {
    $res = $this->pdo->query('SELECT * FROM producto')->fetchAll();
    return $res;
  }

  public function getColumnsNames(): array
  {
    return self::COLUMNAS_NOMBRES;
  }

  public function nofilters_getUsuarios(): array
  {
    $sql = self::SELECT_FROM;
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
  }


  private function countUsuarios(array $filtros): int
  {
    $sql = self::SELECT_COUNT;
    $whereData = $this->buildTheWhere($filtros);
    $sql .= $whereData->whereSQL;
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($whereData->valores);
    return (int)$stmt->fetchColumn();
  }


  //recibo el $_get completo y retorno un array resultado
  public function getUsuarios(array $filtros): array
  {
    $sql = self::SELECT_FROM;

    // obtengo thewhere sql y se lo añado
    $theWhere = $this->buildTheWhere($filtros);
    $sql .= $theWhere->whereSQL;

    var_dump($this->getIntOrder($filtros));
    // $intOrder = 
    $order = self::COLUMNAS_ORDENADORAS[abs($this->getIntOrder($filtros)) - 1];
    $direction = $this->getIntOrder($filtros) < 0 ? 'DESC' : 'ASC';

    $sql .= ' ORDER BY ' . $order;
    $sql .= ' ' . $direction;
    $sql .= ' LIMIT ' . (($this->getCurrentPage($filtros) - 1) * self::PAGE_SIZE) . ',' . self::PAGE_SIZE;

    var_dump($sql);
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($theWhere->valores);
    return $stmt->fetchAll();
  }

  //devuelve positivo  o negativo
  public function getIntOrder($filtros): int
  {
    //si esta vacio, si no es valido int, si es igual a 0 o mayor que el length del array
    if (
      !isset($filtros['order']) ||
      filter_var($filtros['order'], FILTER_VALIDATE_INT) === false ||
      (int)$filtros['order'] === 0 ||
      abs((int)$filtros['order']) > count(self::COLUMNAS_ORDENADORAS)
    ) {
      return self::DEFAULT_ORDER;
    }

    return (int)$filtros['order'];
  }

  public function getDirectionOrder(int $order): string
  {
    return $order < 0 ? ' DESC ' : ' ASC ';
  }



  public function getCurrentPage($filtros): int
  {
    //si esta vacio, si no es valido int, si es < 0 o mayor que max pages
    //solo verifica dos cosas ¡porque????   || (int)$filtros['order'] < 0 || abs((int)$filtros['page']) > MAX_PAGES
    if (empty($filtros['page']) || !filter_var($filtros['page'], FILTER_VALIDATE_INT)) {
      return 1; //1 es default page
    } else {
      return (int)$filtros['page'];
    }
  }

  public function getMaxPage($filtros): int
  {
    return (int)ceil($this->countUsuarios($filtros) / self::PAGE_SIZE);
  }





  public function buildTheWhere($filtros): SQLConditions
  {

    $condiciones = [];
    $valores = [];

    //IMPORTANTE: where solo puede usar nombres originales de las columnas
    if (!empty($filtros['username'])) {
      $condiciones[] = "nombre LIKE :username";
      $valores['username'] = "%" . $filtros['username'] . "%";
    }

    // seleccion multiple: si no esta vacio y es un array...
    if (!empty($filtros['roles']) && is_array($filtros['roles'])) {
      //relleno un array llaves distintas
      $roles_valores = [];
      $i = 1;
      foreach ($filtros['roles'] as $value) {
        $roles_valores[":roles{$i}"] = $value;
        $i++;
      }
      //le saco las llaves
      $llaves = array_keys($roles_valores);
      //lo imploto y se suma a condiciones[]
      $condiciones[] = "id_rol IN (" . implode(",", $llaves) . ")";
      //uno ambos valores
      $valores = array_merge($valores, $roles_valores);
      var_dump($valores);
    }

    // si condiciones esta vacio devuelve '', de lo contrario devuelve 'where ....and...and....'
    $where = ($condiciones === []) ? '' : ' WHERE ' . implode(' AND ', $condiciones);
    return new SQLConditions($where, $valores);
  }


  /////////////////////////////
}
