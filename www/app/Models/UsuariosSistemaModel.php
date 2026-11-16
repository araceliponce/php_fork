<?php
declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use Com\Daw2\Libraries\SQLConditions;

class UsuariosSistemaModel extends BaseDbModel
{

    private const SELECT = 'SELECT u.*, ar.rol';
    private const SELECT_COUNT = 'SELECT COUNT(*)';
    private const FROM = ' FROM usuario_sistema u LEFT JOIN aux_rol ar ON ar.id_rol = u.id_rol';

    private const array ORDER_BY = ['u.nombre', 'ar.rol', 'u.email', 'u.last_date', 'u.idioma'];
    private const int ORDER_DEFECTO = 1;
    private const int PAGE_SIZE = 1;

    public function getFilterBy(array $filtros): array
    {
        $sql = self::SELECT . self::FROM;
        $whereData = $this->getWhere($filtros);
        $sql .= $whereData->whereSQL;
        $sql .= ' ORDER BY ' . self::ORDER_BY[$this->getIntOrder($filtros) - 1];
        $sql .= $this->getCurrentSentido($filtros);
        $sql .= ' LIMIT ' . (($this->getCurrentPage($filtros) - 1) * self::PAGE_SIZE) . ',' . self::PAGE_SIZE;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($whereData->values);
        return $stmt->fetchAll();
    }

    private function getCountBy(array $filtros): int
    {
        $sql = self::SELECT_COUNT . self::FROM;
        $whereData = $this->getWhere($filtros);
        $sql .= $whereData->whereSQL;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($whereData->values);
        return (int)$stmt->fetchColumn();
    }

    public function getMaxPage($filtros): int
    {
        return (int)ceil($this->getCountBy($filtros) / self::PAGE_SIZE);

    }

    public function getCurrentPage(array $filtros): int
    {
        if (empty($filtros['page']) || !filter_var($filtros['page'], FILTER_VALIDATE_INT)) {
            return 1;
        } else {
            return intval($filtros['page']);
        }
    }

    public function getIntOrder(array $filtros): int
    {
        if (empty($filtros['order']) || !filter_var($filtros['order'], FILTER_VALIDATE_INT) || (int)$filtros['order'] <= 0 || (int)$filtros['order'] > count(self::ORDER_BY)) {
            return self::ORDER_DEFECTO;
        } else {
            return (int)$filtros['order'];
        }
    }

    public function getCurrentSentido(array $filtros): string
    {
        return (!empty($filtros['sentido']) && $filtros['sentido'] === 'desc') ? " desc" : " asc";
    }

    private function getWhere(array $filtros): SQLConditions {
        $values = [];
        $condiciones = [];
        if (isset($filtros['id_rol']) && is_array($filtros['id_rol'])) {
            $i = 1;
            foreach ($filtros['id_rol'] as $id_rol) {
                $values[":id_rol{$i}"] = $id_rol;
                $i++;
            }
            $condiciones[] = 'u.id_rol IN (' . implode(',', array_keys($values)) . ')';
        }
        if (!empty($filtros['nombre'])) {
            $condiciones[] = 'nombre like :nombre';
            $values['nombre'] = "%" . $filtros['nombre'] . "%";
        }
        if (!empty($filtros['email'])) {
            $condiciones[] = 'email like :email';
            $values['email'] = "%" . $filtros['email'] . "%";
        }
        if (!empty($filtros['idioma'])) {
            $condiciones[] = 'idioma = :idioma';
            $values['idioma'] = $filtros['idioma'];
        }
        if(!empty($filtros['last_date_from'])){
            $fromdate = \DateTimeImmutable::createFromFormat('d/m/Y H:i:s', $filtros['last_date_from']);
            if ($fromdate !== false) {
                $condiciones[] = 'u.last_date >= :last_date_from';
                $values['last_date_from'] = $fromdate->format('Y-m-d H:i:s');
            }
        }
        if(!empty($filtros['last_date_to'])){
            $toDate = \DateTimeImmutable::createFromFormat('d/m/Y H:i:s', $filtros['last_date_to']);
            if ($toDate !== false) {
                $condiciones[] = 'u.last_date >= :last_date_to';
                $values['last_date_to'] = $toDate->format('Y-m-d H:i:s');
            }
        }
        $where = ($condiciones === []) ? '' : ' WHERE ' . implode(' AND ', $condiciones);
        return new SQLConditions($where, $values);
    }

}