<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PDOException;

class UsuarioSistemaModel extends BaseDbModel
{
  // private const  ORDER_FIELDS = ['t.username', 't.salarioBruto', 't.retencionIRPF', 'nombre_rol', 'country_name'];
  // private const DEFAULT_ORDER_INDEX = 1;

  private const  SELECT_FROM = "SELECT us.*, us.nombre as username, r.rol as nombre_rol, r.descripcion_en as descripcion_rol_en, r.descripcion_es as descripcion_rol_es FROM usuario_sistema us LEFT JOIN aux_rol r ON r.id_rol = us.id_rol";

  private const COLUMNAS_NAMES = ['id', 'nombre', 'rol', 'last access', 'acciones'];

  public function simplyGetProductos(): array
  {
    $res = $this->pdo->query('SELECT * FROM producto')->fetchAll();
    return $res;
  }

  public function getColumnasNames(): array
  {
    return self::COLUMNAS_NAMES;
  }

  public function nofilters_getUsuarios(): array
  {
    $sql = self::SELECT_FROM;
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
  }


  //recibo el $_get completo y retorno un array resultado
  public function getUsuarios(array $filtros): array
  {
    $sql = self::SELECT_FROM;
    $condiciones = [];
    $valores = [];




    //si el formulario envió un username no vacio
    //lo agrego al array de condiciones (luego se concatenan con un implode usando AND como intermediario)
    //y a los values usados despues en stmt->execute(array asociativo de values)

    //IMPORTANTE: cambie el nombre de la columna, el where sigue el nombre de la columna original
    if (!empty($filtros['username'])) {
      $condiciones[] = "nombre LIKE :username";
      $valores['username'] = "%" . $filtros['username'] . "%";
    }

    // if ($filtros['roles'] !== []) {
    // seleccion multiple: si no esta vacio y es un array...
    if (!empty($filtros['roles']) && is_array($filtros['roles'])) {
      //relleno un array llaves distintas
      $roles = [];
      $i = 1;
      foreach ($filtros['roles'] as $value) {
        $roles[":roles{$i}"] = $value;
        $i++;
      }
      //le saco las llaves
      $claves = array_keys($roles);
      //lo imploto
      $condiciones[] = "id_rol IN (" . implode(",", $claves) . ")";
      var_dump($valores);
      //lo transformo
      $valores = array_merge($valores, $roles);
      var_dump($valores);
    }



    if ($condiciones !== []) {
      $sql .= " WHERE " . implode(" AND ", $condiciones);
    }

    var_dump($sql);

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($valores);
    return $stmt->fetchAll();
  }
}
