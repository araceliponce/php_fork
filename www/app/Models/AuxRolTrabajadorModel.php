<?php
declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class AuxRolTrabajadorModel extends BaseDbModel
{
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM `aux_rol_trabajador` ORDER BY nombre_rol ASC");
        return $stmt->fetchAll();
    }

    public function find(int $idRol): array|false
    {
        $sql = "SELECT * FROM `aux_rol_trabajador` WHERE `id_rol` = :idRol";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['idRol' => $idRol]);
        return $stmt->fetch();
    }

}