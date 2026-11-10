<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxCountriesModel;
use Com\Daw2\Models\AuxRolTrabajadorModel;
use Com\Daw2\Models\TrabajadorModel;

class TrabajadorNewController extends BaseController
{
    public function demo()
    {

        $data = array(
            'titulo' => 'new',
            'breadcrumb' => ['Inicio', 'new'],
        );
        $model = new TrabajadorModel();
        $data['trabajador'] = $model->create($_GET);

        //filtervar array sanitize
        $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['errores'] = $model->validateInput($_GET);

        $this->view->showViews(array('templates/header.view.php', 'trabajadores-new.view.php', 'templates/footer.view.php'), $data);
    }



    public function getTrabajadores(): void
    {
        $data = array(
            'titulo' => 'Listado trabajadores',
            'breadcrumb' => ['Inicio', 'Trabajadores'],
        );
        $model = new TrabajadorModel();
        $data['trabajadores'] = $model->getFilterBy($_GET);
        $data['columnsToDisplay'] = $model->getColumnsToDisplay();

        $data['order'] = $model->getOrderIndex($_GET);
        $data['page'] = $model->getPage($_GET);
        $data['itemsPerPage'] = $model->getItemsPerPage($_GET);

        $auxTrabajadorRolModel = new AuxRolTrabajadorModel();
        $data['roles'] = $auxTrabajadorRolModel->getAll();
        $countriesModel = new AuxCountriesModel();
        $data['countries'] = $countriesModel->getAll();
        $input = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['input'] = $input;

        //No modificamos la superglobal, la copiamos con todos los parámetros actuales
        $getParams = $_GET;
        // El controlador no necesita eliminar order
        // porque los enlaces actualizarán su valor
        $data['queryParams'] = http_build_query($getParams);

        $this->view->showViews(array('templates/header.view.php', 'trabajadores-new.view.php', 'templates/footer.view.php'), $data);
    }
}
