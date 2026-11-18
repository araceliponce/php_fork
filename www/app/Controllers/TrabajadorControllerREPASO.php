<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxCountriesModel;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\AuxRolTrabajadorModel;
use Com\Daw2\Models\TrabajadorModel;
use Com\Daw2\Models\TrabajadorModelREPASO;

class TrabajadorControllerREPASO extends BaseController
{


    public function getTrabajadores(): void
    {
        $data = array(
            'titulo' => 'Listado trabajadores',
            'breadcrumb' => ['Inicio', 'Trabajadores'],
        );

        $model = new TrabajadorModelREPASO();
        $modelCountries = new AuxCountriesModel();
        $modelRoles = new AuxRolModel();

        $data['trabajadores'] = $model->getFilterBy($_GET);
        $data['found_trabajadores'] = $model->getTotal($_GET);
        $data['all_trabajadores'] = $model->getTotalNoFilter();


        $data['countries'] = $modelCountries->getAll();
        $data['roles'] = $modelRoles->getAll();
        $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['order'] = $model->getOrderIndex($_GET);

        //para  usar en el nav de view.php:
        $data['currentPage'] = $model->getCurrentPage($_GET); //este no se usa como valor del hiddeninput............. usa currentpage para distinguir el valor de pagina que estamos obteniendo , del valor(numero o letras, o etc) que este en el url
        $data['maxPage'] = $model->getLastPage($_GET);



        //1. obtener un baseurl
        $data['baseUrl'] = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');

        $getOrder = $_GET;
        unset($getOrder['order']);
        $data['queryParams'] = http_build_query($getOrder);

        //si obtengo estas variables. le reestablezco el order
        $getPagination = $_GET;
        unset($getPagination['page']);
        $data['queryParamsPage'] = http_build_query($getPagination);




        $this->view->showViews(array('templates/header.view.php', 'trabajadores.view.php', 'templates/footer.view.php'), $data);
    }
}
