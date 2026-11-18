<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use Com\Daw2\Libraries\SQLConditions;
use PDO;
use PDOException;

class TrabajadorModelREPASO extends BaseDbModel
{
    private const array ORDER_FIELDS = ['t.username', 't.salarioBruto', 't.retencionIRPF', 'nombre_rol', 'country_name'];
    private const DEFAULT_ORDER_INDEX = 1;
    private const ROWS_PER_PAGE = 3;
    private const SELECT = "SELECT t.*, art.nombre_rol, ac.country_name";
    private const SELECT_COUNT = "SELECT COUNT(*) as total";
    private const string FROM = " FROM trabajadores t LEFT JOIN aux_rol_trabajador art ON art.id_rol = t.id_rol LEFT JOIN aux_countries ac ON ac.id = t.id_country";
    private array $allowedFields = ['username', 'salarioBruto', 'retencionIRPF', 'activo', 'id_rol', 'id_country']; //profesor no incluyó .activo

    public function getTrabajadores(): array
    {
        $trabajadores = $this->pdo->query('SELECT * FROM trabajadores')->fetchAll();
        return $trabajadores;
    }

    //agrega filtros, orden y al final limit
    // /var/www/html/app/Models/TrabajadorModelREPASO.php:47:string 'SELECT t.*, art.nombre_rol, ac.country_name FROM trabajadores t LEFT JOIN aux_rol_trabajador art ON art.id_rol = t.id_rol LEFT JOIN aux_countries ac ON ac.id = t.id_country ORDER BY t.username ASC LIMIT 0, 20' (length=208)
    public function getFilterBy(array $filtros): array
    {

        $sql = self::SELECT . self::FROM;
        $sqlConditions = $this->generateWhereByFilter($filtros);
        $sql .= $sqlConditions->whereSQL;



        $columnaOrdenadora = self::ORDER_FIELDS[abs($this->getOrderIndex($filtros)) - 1];
        $direccion = $columnaOrdenadora < 0 ? 'DESC' : 'ASC';
        $sql .= ' ORDER BY ' . $columnaOrdenadora . ' ' . $direccion;


        // limit 20, 10 --inicia 20, acontiene 10 rows
        $currentPage = $this->getCurrentPage($filtros) - 1;
        $sql .= ' LIMIT ' . $currentPage * self::ROWS_PER_PAGE . ', ' . self::ROWS_PER_PAGE;

        var_dump($sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($sqlConditions->values);
        return $stmt->fetchAll();
    }

    private function getCountFilterBy(array $filtros): int
    {

        $sql = self::SELECT_COUNT . self::FROM;
        //al select count from se le agregan tmb los filtros
        $sqlConditions = $this->generateWhereByFilter($filtros);
        $sql .= $sqlConditions->whereSQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($sqlConditions->values);
        //fetch column 0
        return $stmt->fetchColumn(0);
    }


    // public string $whereSQL,
    // public array $values
    private function generateWhereByFilter(array $filtros): SQLConditions
    {


        $condiciones = [];
        $valores = [];
        if (!empty($filtros['username'])) {
            $condiciones[] = 't.username like :username';
            $valores[':username'] = '%' . $filtros['username'] . '%';
        }

        if (!empty($filtros['id_rol'])) {
            $condiciones[] = 'art.id_rol like :id_rol';
            $valores[':id_rol'] = '%' . $filtros['id_rol'] . '%';
        }

        // no valida si es un int valido        filter_var(...,validate_int)

        // GET
        // http://localhost:8080/trabajadores-repaso?order=1&page=&username=al&id_rol=3&min_salarioBruto=a&max_salarioBruto=&min_retencionIRPF=sfdfdsf&max_retencionIRPF=&enviar=Aplicar filtros
        if (!empty($filtros['min_salarioBruto'])) {
            $condiciones[] = 't.salarioBruto >= :min_salarioBruto';
            $valores[':min_salarioBruto'] =  $filtros['min_salarioBruto'];
        }
        if (!empty($filtros['max_salarioBruto'])) {
            $condiciones[] = 't.salarioBruto <= :max_salarioBruto';
            $valores[':max_salarioBruto'] =  $filtros['max_salarioBruto'];
        }
        //retencion es lo mismo que salariobruto
        if (!empty($filtros['min_retencionIRPF'])) {
            $condiciones[] = 't.retencionIRPF >= :min_retencionIRPF';
            $valores[':min_retencionIRPF'] =  $filtros['min_retencionIRPF'];
        }
        if (!empty($filtros['max_retencionIRPF'])) {
            $condiciones[] = 't.retencionIRPF <= :max_retencionIRPF';
            $valores[':max_retencionIRPF'] =  $filtros['max_retencionIRPF'];
        }


        //si condiciones cambio despues de que la inicializaste como array vacio
        if (($condiciones) !== []) {
            return new SQLConditions(' WHERE ' . implode(' AND ', $condiciones), $valores);
        } else {
            return new SQLConditions('', []);
        };
    }

    private function getCountNoFilter(): int
    {

        $sql = self::SELECT_COUNT . self::FROM;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }
    public function getTotalNoFilter(): int
    {
        return (int)$this->getCountNoFilter();
    }
    public function getTotal(array $filtros): int
    {
        return (int)$this->getCountFilterBy($filtros);
    }


    public function getLastPage(array $filtros): int
    {
        return (int)ceil($this->getCountFilterBy($filtros) / self::ROWS_PER_PAGE);
    }

    public function getCurrentPage(array $filtros): int
    {
        if (empty($filtros['page']) || filter_var($filtros['page'], FILTER_VALIDATE_INT) === false) {
            return 1;
        } else {
            return (int)$filtros['page'];
        }
    }

    public function getOrderIndex(array $filtros): int
    {

        if (empty($filtros['order'])) {
            return self::DEFAULT_ORDER_INDEX;
        } elseif (filter_var($filtros['order'], FILTER_VALIDATE_INT) === false || $filtros['order'] < 1 || $filtros['order'] > count(self::ORDER_FIELDS)) {
            return self::DEFAULT_ORDER_INDEX;
        } else {
            return (int)$filtros['order'];
        }
    }
}
