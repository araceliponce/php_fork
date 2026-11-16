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

    public function find(int $idCountry): array|false
    {
        $sql = "SELECT * FROM aux_countries WHERE id = :idCountry";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['idCountry' => $idCountry]);
        return $stmt->fetch();
    }
}