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

    public function getCountFilteredTrabajadores(): array
    {
        $sql = self::SELECT_FROM;
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


        // LIMIT 10 ;;;;;;;clause to show only the top 10 records 
        // LIMIT indice de inicio, cantidad (por ejemplo si son 10 itemsperpage sera limit 0,10.....limit 10,10......limit 20,10....)

        $order = $this->getOrderIndex($filtros);

        $sql .= " ORDER BY "
            . self::ORDER_FIELDS[abs($order) - 1]
            . " "
            . $this->getOrderDireccion($filtros)
            . " LIMIT "
            . $this->getPage($filtros) * $this->getItemsPerPage($filtros)
            . ", "
            . $this->getItemsPerPage($filtros);

        var_dump($sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll();
    }
    //todo: deberia tener otra funcion para obtener sin el limit, o para contar?


    public function oldgetOrderIndex(array $filtros): int
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


    public function getOrderIndex(array $filtros): int
    {
        $order = filter_var(
            $filtros['order'] ?? null,
            FILTER_VALIDATE_INT
        );

        // Si order no es un entero válido, usa el valor por defecto
        if ($order === false) {
            return self::DEFAULT_ORDER_INDEX;
        }

        // Comprueba que la columna existe
        if (abs($order) < 1 || abs($order) > count(self::ORDER_FIELDS)) {
            return self::DEFAULT_ORDER_INDEX;
        }

        // Conserva el signo
        return $order;
    }


    public function oldgetOrderDireccion(array $filtros): string
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



    public function getOrderDireccion(array $filtros): string
    {
        $order = $this->getOrderIndex($filtros);

        return $order < 0 ? 'DESC' : 'ASC';
    }

    // LIMIT offset, cantidad;
    public function getItemsPerPage(array $filtros): int
    {
        if (empty($filtros['itemsPerPage']) || filter_var($filtros['itemsPerPage'], FILTER_VALIDATE_INT) === false || $filtros['itemsPerPage'] < 3) {
            return 3;
        } else {
            return (int)$filtros['itemsPerPage'];
        }
    }

    //todo: enconntrar la cantidad de paginas, 
    //por el momento no verifica si coloca un numero superior, igualmente solo retornaria no hay datos de esta query
    /**
     * recibe 1 y retorna 0, recibe 2 y retorna 1....
     * si no recibe nada retorna default (0)
     */
    public function getPage(array $filtros): int
    {
        if (empty($filtros['page'])) {
            return 0;
        } elseif (filter_var($filtros['page'], FILTER_VALIDATE_INT) === false || $filtros['page'] < 1) {
            return 0;
        } else {
            return (int)$filtros['page'] - 1;
        }
    }
}
