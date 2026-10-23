<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxCountriesModel;
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
        $auxTrabajadorRolModel = new AuxRolTrabajadorModel();
        $countriesModel = new AuxCountriesModel();

        $input = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data['trabajadores'] = $model->getFilterBy($_GET);
        $data['sortedTrabajadores'] =  $this->sortByKey($data['trabajadores'], 'salarioBruto');

        $data['roles'] = $auxTrabajadorRolModel->getAll();
        $data['countries'] = $countriesModel->getAll();
        $data['input'] = $input;
        $this->view->showViews(array('templates/header.view.php', 'trabajadores.view.php', 'templates/footer.view.php'), $data);
    }

    private function sortByKey(array $array, string $clave)
    {

        // en PHP las funciones anónimas (o closures) no heredan automáticamente las variables del ámbito exterior. La variable $clave existe dentro del método sortByKey, pero la función interna de usort no la puede ver.
        // Para solucionarlo, debes "importar" la variable dentro de la función interna, agregando: use ($clave).
        $res = usort($array, function ($a, $b) use ($clave) {
            return $a[$clave] <=> $b[$clave]; // Orden ascendente
        });
        return $res;
    }
}
