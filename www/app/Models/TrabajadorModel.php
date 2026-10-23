<?php
declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PDOException;

class TrabajadorModel extends BaseDbModel
{
    private const string SELECT_FROM = "SELECT t.*, art.nombre_rol, ac.country_name FROM trabajadores t LEFT JOIN aux_rol_trabajador art ON art.id_rol = t.id_rol LEFT JOIN aux_countries ac ON ac.id = t.id_country";
    public function getTrabajadores(): array
    {
        $trabajadores = $this->pdo->query('SELECT * FROM trabajadores')->fetchAll();
        var_dump($trabajadores);
        return $trabajadores;
    }
    public function getAllTrabajadores(): array
    {
        $sql = self::SELECT_FROM;
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getAllTrabajadoresOrdenados(): array
    {
        $sql = self::SELECT_FROM . " ORDER BY salarioBruto DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getFilterBy(array $filtros): array
    {
        $sql = self::SELECT_FROM;
        $values = [];
        if (!empty($filtros['username'])) {
            $sql .= " WHERE username LIKE :username";
            $values["username"] = "%" . $filtros['username'] . "%";
        } else if (!empty($filtros['id_rol'])) {
            $sql .= " WHERE t.id_rol = :id_rol";
            $values["id_rol"] = $filtros['id_rol'];
        } elseif (!empty($filtros['min_salarioBruto']) || !empty($filtros['max_salarioBruto'])) {
            $salarConditions = [];
            if (!empty($filtros['min_salarioBruto'])) {
                $salarConditions[] = "salarioBruto >= :min_salarioBruto";
                $values["min_salarioBruto"] = $filtros['min_salarioBruto'];
            }
            if (!empty($filtros['max_salarioBruto'])) {
                $salarConditions[] = "salarioBruto <= :max_salarioBruto";
                $values["max_salarioBruto"] = $filtros['max_salarioBruto'];
            }
            $sql .= " WHERE " . implode(" AND ", $salarConditions);
        } elseif (!empty($filtros['min_retencionIRPF']) || !empty($filtros['max_retencionIRPF'])) {
            $salarConditions = [];
            if (!empty($filtros['min_retencionIRPF'])) {
                $salarConditions[] = "retencionIRPF >= :min_retencionIRPF";
                $values["min_retencionIRPF"] = $filtros['min_retencionIRPF'];
            }
            if (!empty($filtros['max_retencionIRPF'])) {
                $salarConditions[] = "retencionIRPF <= :max_retencionIRPF";
                $values["max_retencionIRPF"] = $filtros['max_retencionIRPF'];
            }
            $sql .= " WHERE " . implode(" AND ", $salarConditions);
        } else if (!empty($filtros['id_country']) && is_array($filtros['id_country'])) {
            $countries = [];
            $i = 1;
            foreach($filtros['id_country'] as $idCountry) {
                $countries[":id_country{$i}"] = $idCountry;
                $i++;
            }
            $claves = array_keys($countries);
            $sql .= " WHERE t.id_country IN (" . implode(", ", $claves) . ")";
            $values = array_merge($values, $countries);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll();
    }
}