<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PDOException;

class TrabajadorModel extends BaseDbModel
{

    public function getTrabajadores(): array
    {
        $trabajadores = $this->pdo->query('SELECT * FROM trabajadores')->fetchAll();
        // var_dump($trabajadores);
        return $trabajadores;
    }
    public function getTrabajadoresBySalario(): array
    {
        $trabajadores = $this->pdo->query('SELECT * FROM trabajadores t ORDER BY t.salarioBruto DESC')->fetchAll();
        return $trabajadores;
    }

    public function getTrabajadoresCarlos(): array
    {
        $trabajadores = $this->pdo->query('SELECT * FROM trabajadores t WHERE t.username LIKE "CARLOS%"')->fetchAll();
        return $trabajadores;
    }

    // serachs string on the username
    public function getTrabajadoresByUsername(string $username): array
    {
        $sql = "SELECT * FROM trabajadores t WHERE t.username LIKE :username";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => '%' . $username . '%']);
        $trabajadores = $stmt->fetchAll();

        return $trabajadores;
    }

    public function getTrabajadoresByRol(string $rol): array
    {
        $sql = "SELECT * FROM trabajadores t WHERE t.id_rol = :rol";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['rol' =>  $rol]);
        $trabajadores = $stmt->fetchAll();

        return $trabajadores;
    }

    public function getRoles(): array
    {
        $sql = "SELECT * FROM aux_rol_trabajador";
        $roles = $this->pdo->query($sql)->fetchAll();

        return $roles;
    }
}
