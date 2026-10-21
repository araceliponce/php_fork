<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;
use PDOException;

class TrabajadorModel extends BaseDbModel
{

    // a partir de php 8..3 puedes usar "string "
    // private const string SELECT_FROM = "SELECT t.*, art.nombre_rol, ac.country_name FROM trabajadores t LEFT JOIN aux_rol_trabajador art ON art.id_rol = t.id_rol LEFT JOIN aux_countries ac ON ac.id = t.id_country";

    private const SELECT_FROM = "SELECT t.*, art.nombre_rol, ac.country_name FROM trabajadores t LEFT JOIN aux_rol_trabajador art ON art.id_rol = t.id_rol LEFT JOIN aux_countries ac ON ac.id = t.id_country";

    public function getTrabajadores(): array
    {
        $sql = self::SELECT_FROM;
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getTrabajadoresBySalario(): array
    {
        $sql = self::SELECT_FROM . " ORDER BY t.salarioBruto DESC";
        $trabajadores = $this->pdo->query($sql)->fetchAll();
        return $trabajadores;
    }

    public function getTrabajadoresCarlos(): array
    {
        $trabajadores = $this->pdo->query('SELECT * FROM trabajadores t WHERE t.username LIKE "CARLOS%"')->fetchAll();
        return $trabajadores;
    }

    // serachs string on the username
    public function getTrabajadoresByUsername(string $username): array
    {
        $sql = self::SELECT_FROM . " WHERE t.username LIKE :username";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => '%' . $username . '%']);
        $trabajadores = $stmt->fetchAll();

        return $trabajadores;
    }

    public function getTrabajadoresByRol(string $rol): array
    {
        $sql = self::SELECT_FROM . " WHERE t.id_rol = :rol";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['rol' =>  $rol]);
        $trabajadores = $stmt->fetchAll();

        return $trabajadores;
    }

    public function getTrabajadoresBySalarioRango(float $min, float $max): array
    {
        $sql = self::SELECT_FROM . " WHERE t.salarioBruto > :min AND t.salarioBruto <:max";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['min' =>  $min, 'max' =>  $max]);
        $trabajadores = $stmt->fetchAll();

        return $trabajadores;
    }

    public function getTrabajadoresByCountries(array $countries): array
    {
        // $sql = self::SELECT_FROM . " WHERE t.id_country IN :countries";
        // $stringDeCountries = implode(',', $countries); //No puedes pasar una lista de valores mediante un único parámetro de PDO. Aunque construyas la cadena '(1,2,3)', PDO la interpreta como un único valor, no como varios elementos del IN. ..... ['countries' => '(' . $stringDeCountries . ')']   X

        if (empty($countries)) {
            return [];
        }
        //crea un string agregando ,s en medio de array de ['?','?','?'.....]
        $placeholders = implode(',', array_fill(0, count($countries), '?'));
        $sql = self::SELECT_FROM . " WHERE t.id_country IN ($placeholders)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($countries); //es un array de codigos como : ['az','dz']... en ese orden reemplazan cada ?,?

        return $stmt->fetchAll();
    }
    // select c.FirstName, c.LastName, c.Country, c.Email
    // from Customer c 
    // where c.Country in ("USA", "Canada") and (c.Email like ('%@gmail.com') or c.Email like ('%@hotmail.com'))
    // order by c.LastName, c.FirstName;







    public function getRoles(): array
    {
        $sql = "SELECT * FROM aux_rol_trabajador";
        $roles = $this->pdo->query($sql)->fetchAll();

        return $roles;
    }

    public function getCountries(): array
    {
        $sql = "SELECT * FROM aux_countries";
        $roles = $this->pdo->query($sql)->fetchAll();

        return $roles;
    }
}
