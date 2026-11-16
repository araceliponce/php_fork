<?php
declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class AuxRolModel extends BaseDbModel
{
    public function getAll(): array
    {
        $sql = 'SELECT * FROM `aux_rol` ORDER BY orden';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

}