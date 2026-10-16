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
}
