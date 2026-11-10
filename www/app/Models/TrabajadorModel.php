<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PDOException;



// username Primaria 	varchar(50) 	utf8mb4_0900_ai_ci 		No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
// 2 	salarioBruto 	decimal(10,2) 			No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
// 3 	retencionIRPF 	decimal(10,2) 			No 	Ninguna 			Cambiar Cambiar 	Eliminar Eliminar 	
// 4 	activo 	tinyint(1) 			No 	0 			Cambiar Cambiar 	Eliminar Eliminar 	
// 5 	id_rol Índice 	int 			No 	1 			Cambiar Cambiar 	Eliminar Eliminar 	
// 6 	id_country 	int 

class TrabajadorModel extends BaseDbModel
{
    private const array ORDER_FIELDS = ['t.username', 't.salarioBruto', 't.retencionIRPF', 'nombre_rol', 'country_name'];
    private const array COLUMNS_TO_DISPLAY = ['username', 'salarioBruto', 'retencionIRPF', 'rol', 'country', 'acciones'];

    private const DEFAULT_ORDER_INDEX = 1;

    private const string SELECT_FROM = "SELECT t.*, art.nombre_rol, ac.country_name FROM trabajadores t LEFT JOIN aux_rol_trabajador art ON art.id_rol = t.id_rol LEFT JOIN aux_countries ac ON ac.id = t.id_country";





    private const INSERT = "
    INSERT INTO `trabajadores`
    (`username`, `salarioBruto`, `retencionIRPF`, `activo`, `id_rol`, `id_country`)
    VALUES
    (:username, :salarioBruto, :retencionIRPF, :activo, :id_rol, :id_country)
";

    public function getColumnsToDisplay(): array
    {

        return self::COLUMNS_TO_DISPLAY;
    }

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

    // NUEVO TRABAJADOR
    // $input['activo'] === 'on' ? 1 : 0 puede provocar un warning si activo no existe en $input.
    public function create(array $input): bool|array
    {



        $errores = $this->validateInput($input);
        if (!empty($errores)) {

            // recarga la pagina, muestra mensajes de rror?

            return $errores;
        } else {


            //crea
            $sql = self::INSERT;

            $valores = [
                ':username' => trim($input['username']),
                ':salarioBruto' => $input['salarioBruto'],
                ':retencionIRPF' => $input['retencionIRPF'],
                ':activo' => isset($input['activo']) ? 1 : 0,
                ':id_rol' => $input['id_rol'],
                ':id_country' => $input['id_country'],
            ];




            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute($valores);;
        }
    }

    public function validateInput(array $input): array
    {


        $errores = [];

        //solo existe en esta funcion, no importa si repite el nombre no cambia el valor del original
        $username = trim($input['username'] ?? '');


        if (mb_strlen($username) < 2 || mb_strlen($username) > 50) {
            $errores['username'] = 'necesita tener entre 2 y 50 characteres';
        }

        $salarioBruto = $input['salarioBruto'] ?? ''; //si input de salariobruto se quedo vacio se vuelve ''
        // esta el campo vacio, o no es numero, o es menor o igual que 500
        if ($salarioBruto = '' || is_numeric($salarioBruto) || $salarioBruto <= 500) {
            $errores['salarioBruto'] = 'dejaste vacio o es menor o igual que 500';
        }



        //irpf si esta vacio, si no es numero y si es menor o mayor a un limite maximo?

        //id rol poddria revisar que es alguno de los ids validos de rolModel.php

        //no revisa el valor checkbox. si existe (comprueba con isset) entonces tiene attr checked, y si no existe no tiene el attr

        $retencionIRPF = $input['retencionIRPF'] ?? ''; //si input de salariobruto se quedo vacio se vuelve ''

        if (
            $retencionIRPF === '' ||
            !is_numeric($retencionIRPF) ||
            $retencionIRPF < 0 ||
            $retencionIRPF > 100
        ) {
            $errores['retencionIRPF'] = 'Introduce una retención entre 0 y 100';
        }

        // ID ROL
        $idRol = $input['id_rol'] ?? '';

        if (filter_var($idRol, FILTER_VALIDATE_INT) === false || $idRol < 1) {
            $errores['id_rol'] = 'Selecciona un rol válido';
        }

        // ID COUNTRY
        $idCountry = $input['id_country'] ?? '';

        if (filter_var($idCountry, FILTER_VALIDATE_INT) === false || $idCountry < 1) {
            $errores['id_country'] = 'Selecciona un país válido';
        }




        return $errores;
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
                $countries[":id_country_{$i}"] = $idCountry;
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
