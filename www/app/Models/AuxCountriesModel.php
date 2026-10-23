<?php
declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class AuxCountriesModel extends BaseDbModel
{
    public function getAll(): array
    {
        return $this->pdo->query("SELECT *, id as id_country FROM aux_countries ORDER BY country_name")->fetchAll();
    }
}