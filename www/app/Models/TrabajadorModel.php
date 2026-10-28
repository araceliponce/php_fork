<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PDOException;

class TrabajadorModel extends BaseDbModel
{
    private const array ORDER_FIELDS = ['t.username', 't.salarioBruto', 't.retencionIRPF', 'nombre_rol', 'country_name'];
    private const DEFAULT_ORDER_INDEX = 1;

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
        $condiciones = [];
        if (!empty($filtros['username'])) {
            $condiciones[] = "username LIKE :username";
            $values["username"] = "%" . $filtros['username'] . "%";
        }
        if (!empty($filtros['id_rol'])) {
            $condiciones[] = "t.id_rol = :id_rol";
            $values["id_rol"] = $filtros['id_rol'];
        }
        if (!empty($filtros['min_salarioBruto'])) {
            $condiciones[] = "salarioBruto >= :min_salarioBruto";
            $values["min_salarioBruto"] = $filtros['min_salarioBruto'];
        }
        if (!empty($filtros['max_salarioBruto'])) {
            $condiciones[] = "salarioBruto <= :max_salarioBruto";
            $values["max_salarioBruto"] = $filtros['max_salarioBruto'];
        }
        if (!empty($filtros['min_retencionIRPF'])) {
            $condiciones[] = "retencionIRPF >= :min_retencionIRPF";
            $values["min_retencionIRPF"] = $filtros['min_retencionIRPF'];
        }
        if (!empty($filtros['max_retencionIRPF'])) {
            $condiciones[] = "retencionIRPF <= :max_retencionIRPF";
            $values["max_retencionIRPF"] = $filtros['max_retencionIRPF'];
        }
        if (!empty($filtros['id_country']) && is_array($filtros['id_country'])) {
            $countries = [];
            $i = 1;
            foreach ($filtros['id_country'] as $idCountry) {
                $countries[":id_country{$i}"] = $idCountry;
                $i++;
            }
            $claves = array_keys($countries);
            $condiciones[] =  "t.id_country IN (" . implode(", ", $claves) . ")";
            $values = array_merge($values, $countries);
        }
        if ($condiciones !== []) {
            $sql .= " WHERE " . implode(" AND ", $condiciones);
        }
        $sql .= " ORDER BY " . self::ORDER_FIELDS[$this->getOrderIndex($filtros) - 1] . " " . $this->getOrderDireccion($filtros);
        // var_dump($sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll();
    }

    public function getOrderIndex(array $filtros): int
    {
        //si no se envia ningun param order en el url usa default
        if (empty($filtros['order'])) {
            return self::DEFAULT_ORDER_INDEX;
        } elseif (filter_var($filtros['order'], FILTER_VALIDATE_INT) === false || $filtros['order'] < 1 || $filtros['order'] > count(self::ORDER_FIELDS)) {
            //tambien usa default si no es un int valido, o si esta fuera del rango
            return self::DEFAULT_ORDER_INDEX;
        } else {
            return (int)$filtros['order'];
        }
    }


    public function getOrderDireccion(array $filtros): string
    {
        //si no se envia ningun param order o si no es valido devulve ""
        if (empty($filtros['order']) || filter_var($filtros['order'], FILTER_VALIDATE_INT) === false) {
            return '';
        } elseif ($filtros['order'] < 0) {
            return 'DESC';
        } else {
            return 'ASC';
        }
    }
}
