<?php
declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxCountriesModel;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\AuxRolTrabajadorModel;
use Com\Daw2\Models\TrabajadorModel;

class TrabajadorController extends BaseController
{
    public function testDb()
    {
        $model = new TrabajadorModel();
        $model->getTrabajadores();
    }

    public function getAllTrabajadores(): void
    {
        $data = array(
            'titulo' => 'Todos los trabajadores',
            'breadcrumb' => ['Inicio', 'Consultas simples'],
        );
        $model = new TrabajadorModel();
        $data['trabajadores'] = $model->getAllTrabajadores();
        $this->view->showViews(array('templates/header.view.php', 'trabajadores.view.php', 'templates/footer.view.php'), $data);
    }

    public function getAllTrabajadoresOrdenadosSalario(): void
    {
        $data = array(
            'titulo' => 'Todos los trabajadores ordenados',
            'breadcrumb' => ['Inicio', 'Consultas simples'],
        );
        $model = new TrabajadorModel();
        $data['trabajadores'] = $model->getAllTrabajadoresOrdenados();
        $this->view->showViews(array('templates/header.view.php', 'trabajadores.view.php', 'templates/footer.view.php'), $data);
    }

    public function getTrabajadores(): void
    {
        $data = array(
            'titulo' => 'Listado trabajadores',
            'breadcrumb' => ['Inicio', 'Trabajadores'],
        );
        $model = new TrabajadorModel();
        $data['trabajadores'] = $model->getFilterBy($_GET);
        $data['order'] = $model->getOrderIndex($_GET);
        $data['currentPage'] = $model->getCurrentPage($_GET);
        $data['maxPage'] = $model->getLastPage($_GET);
        $auxTrabajadorRolModel = new AuxRolTrabajadorModel();
        $data['roles'] = $auxTrabajadorRolModel->getAll();
        $countriesModel = new AuxCountriesModel();
        $data['countries'] = $countriesModel->getAll();
        $input = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['input'] = $input;
        //No modificamos la superglobal, la copiamos en $getOrder
        $getOrder = $_GET;
        $data['baseUrl'] = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
        unset($getOrder['order']);
        unset($getOrder['sentido']);
        $data['queryParams'] = http_build_query($getOrder);

        $getPage = $_GET;
        unset($getPage['page']);
        $data['queryParamsPage'] = http_build_query($getPage);
        $this->view->showViews(array('templates/header.view.php', 'trabajadores.view.php', 'templates/footer.view.php'), $data);
    }

    public function new(array $input = [], array $errores = []): void
    {
        $data = array(
            'titulo' => 'Alta trabajador',
            'breadcrumb' => ['Inicio', 'Trabajadores', 'Alta'],
            'input' => $input,
            'errors' => $errores,
        );
        $auxTrabajadorRolModel = new AuxRolTrabajadorModel();
        $data['roles'] = $auxTrabajadorRolModel->getAll();
        $countriesModel = new AuxCountriesModel();
        $data['countries'] = $countriesModel->getAll();
        $this->view->showViews(array('templates/header.view.php', 'trabajadores.edit.php', 'templates/footer.view.php'), $data);
    }

    public function doNew(): void
    {
        $errores = $this->checkTrabajadorForm($_POST);
        if ($errores !== []) {
            $this->new(
                filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                $errores
            );
        } else {
            $trabajadoresModel = new TrabajadorModel();
            $res = $trabajadoresModel->insert($_POST);
            if ($res !== true) {
                echo 'Error';
            } else {
                if (!isset($_POST['insertar_otro'])) {
                    header('Location: /trabajadores');
                } else {
                    header('Location: /trabajadores/new');
                }
            }
        }
    }

    private function checkTrabajadorForm(array $datos): array
    {
        $errores = [];
        if (empty($datos['username'])) {
            $errores['username'] = 'Campo obligatorio';
        } elseif (!preg_match('/^[\p{L}0-9_]{4,50}$/', $datos['username'])) {
            $errores['username'] = 'Username solo acepta caracteres alfanuméricos y _. Longitud mínima: 4, máxima: 50';
        } else {
            $trabajadorModel = new TrabajadorModel();
            $trabajador = $trabajadorModel->find($datos['username']);
            if ($trabajador !== false) {
                $errores['username'] = 'El nombre de usuario ya está en uso';
            }
        }

        if (empty($datos['salarioBruto'])) {
            $errores['salarioBruto'] = 'Campo obligatorio';
        } elseif (!is_numeric($datos['salarioBruto'])) {
            $errores['salarioBruto'] = 'Inserte un número';
        } elseif ($datos['salarioBruto'] < 500) {
            $errores['salarioBruto'] = 'El debe ser mayor que 500';
        }

        if (empty($datos['retencionIRPF'])) {
            $errores['retencionIRPF'] = 'Campo obligatorio';
        } elseif (!is_numeric($datos['retencionIRPF'])) {
            $errores['retencionIRPF'] = 'Inserte un número';
        } elseif ($datos['retencionIRPF'] < 0 || $datos['retencionIRPF'] > 100) {
            $errores['retencionIRPF'] = 'La retención debe tener un valor comprendido entre 0 y 100';
        }

        if (empty($datos['id_rol'])) {
            $errores['id_rol'] = 'Campo obligatorio';
        } elseif (filter_var($datos['id_rol'], FILTER_VALIDATE_INT) === false) {
            $errores['id_rol'] = 'Rol no válido';
        } else {
            $rolModel = new AuxRolTrabajadorModel();
            $rol = $rolModel->find((int)$datos['id_rol']);
            if ($rol === false) {
                $errores['id_rol'] = 'Rol no válido';
            }
        }

        if (empty($datos['id_country'])) {
            $errores['id_country'] = 'Campo obligatorio';
        } elseif (filter_var($datos['id_country'], FILTER_VALIDATE_INT) === false) {
            $errores['id_country'] = 'País no válido';
        } else {
            $countryModel = new AuxCountriesModel();
            $country = $countryModel->find((int)$datos['id_country']);
            if ($country === false) {
                $errores['id_country'] = 'País no válido';
            }
        }
        return $errores;
    }

}