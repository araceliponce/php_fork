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
        $data['trabajadores'] = $model->getFilterBy($_GET);
        $auxTrabajadorRolModel = new AuxRolTrabajadorModel();
        $data['roles'] = $auxTrabajadorRolModel->getAll();
        $countriesModel = new AuxCountriesModel();
        $data['countries'] = $countriesModel->getAll();
        $input = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['input'] = $input;
        $this->view->showViews(array('templates/header.view.php', 'trabajadores.view.php', 'templates/footer.view.php'), $data);
    }

}