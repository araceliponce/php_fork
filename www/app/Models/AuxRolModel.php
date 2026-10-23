<?php

use Com\Daw2\Core\BaseDbModel;

class AuxRolTrabajadorModel extends BaseDbModel
{


  public function getRoles(): array
  {
    $sql = 'select * from aux_rol_trabajador order by id_rol';
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
  }
}
