<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PDOException;

use const ast\flags\RETURNS_REF;

class TrabajadorModel extends BaseDbModel
{
    private const SELECT_FROM = "SELECT t.*, art.nombre_rol, ac.country_name FROM trabajadores t LEFT JOIN aux_rol_trabajador art ON art.id_rol = t.id_rol LEFT JOIN aux_countries ac ON ac.id = t.id_country";
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
        $addedFilters = [];
        // $sql .= implode(" AND ", $addedFilters);

        $values = [];
        if (!empty($filtros['username'])) {
            $addedFilters[] .= " username LIKE :username";
            $values["username"] = "%" . $filtros['username'] . "%";
        }
        if (!empty($filtros['id_rol'])) {
            $addedFilters[] .= " t.id_rol = :id_rol";
            $values["id_rol"] = $filtros['id_rol'];
        }
        if (!empty($filtros['min_salarioBruto']) || !empty($filtros['max_salarioBruto'])) {
            $salarConditions = [];
            if (!empty($filtros['min_salarioBruto'])) {
                $salarConditions[] = "salarioBruto >= :min_salarioBruto";
                $values["min_salarioBruto"] = $filtros['min_salarioBruto'];
            }
            if (!empty($filtros['max_salarioBruto'])) {
                $salarConditions[] = "salarioBruto <= :max_salarioBruto";
                $values["max_salarioBruto"] = $filtros['max_salarioBruto'];
            }
            $addedFilters[] .=  implode(" AND ", $salarConditions);
        }
        if (!empty($filtros['min_retencionIRPF']) || !empty($filtros['max_retencionIRPF'])) {
            $salarConditions = [];
            if (!empty($filtros['min_retencionIRPF'])) {
                $salarConditions[] = "retencionIRPF >= :min_retencionIRPF";
                $values["min_retencionIRPF"] = $filtros['min_retencionIRPF'];
            }
            if (!empty($filtros['max_retencionIRPF'])) {
                $salarConditions[] = "retencionIRPF <= :max_retencionIRPF";
                $values["max_retencionIRPF"] = $filtros['max_retencionIRPF'];
            }
            $addedFilters[] .=  implode(" AND ", $salarConditions);
        }
        if (!empty($filtros['id_country']) && is_array($filtros['id_country'])) {
            $countries = [];
            $i = 1;
            foreach ($filtros['id_country'] as $idCountry) {
                $countries[":id_country{$i}"] = $idCountry;
                $i++;
            }
            $claves = array_keys($countries);
            $addedFilters[] .= " t.id_country IN (" . implode(", ", $claves) . ")";
            $values = array_merge($values, $countries);
        }


        var_dump($filtros); //

        if ($addedFilters == []) return [];






        $sql .= " WHERE " . implode(" AND ", $addedFilters);
        // var_dump($sql); //ver

        //order by siempredespues del where:
        //si existe el filtro orderingBy y esta dentro de un array de filtros aceptados, usar el orderby al sql
        //order by es por defecto asc
        //no usar el nombre de las columnas reales
        // http_build_query
        if (!empty($filtros['orderingBy'])) {

            //los nombres reales
            $columnas = ['username', 'salarioBruto', 'retencionIRPF', 'nombre_rol', 'id_country'];
            // https://centros.edu.xunta.gal/iespazomerce/aulavirtual/mod/book/view.php?id=95335&chapterid=4972
            $orderBy = 'username'; //default 


            $orderBy =  $columnas[$filtros['orderingBy'] - 1];

            $sql .= " ORDER BY " . $orderBy;
            var_dump($sql); //ver


            if (!empty($filtros['direction'])) {

                $direction = $filtros['direction'];


                $sql .= " " . $direction;
                var_dump($sql); //ver

            }
        }




        var_dump($sql); //ver
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll();
    }

    public function getFilterByOriginal(array $filtros): array
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
            foreach ($filtros['id_country'] as $idCountry) {
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
