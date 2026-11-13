<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxRolUsuarioModel;
use Com\Daw2\Models\UsuarioSistemaModel;

class UsuarioSistemaController extends BaseController
{

  private const array IDIOMAS = ['en', 'es', 'gl'];


  public function getUsuarios(): void
  {
    $data = array(
      'titulo' => 'Listado usuarios',
      'breadcrumb' => ['Inicio', 'usuarios'],
    );

    $model = new UsuarioSistemaModel();
    $modelRoles = new AuxRolUsuarioModel();
    $data['usuarios'] = $model->getUsuarios($_GET);
    $data['roles'] = $modelRoles->getAll();
    $data['columnsNames'] = $model->getColumnsNames();

    $data['currentOrder'] = $model->getIntOrder($_GET);
    $data['direction'] = $data['currentOrder'] < 0 ? 'DESC' : 'ASC';

    $data['maxPage'] = $model->getMaxPage($_GET);
    $data['currentPage'] = $model->getCurrentPage($_GET);


    $data['idiomas'] = self::IDIOMAS;

    $getOrder = $_GET;
    unset($getOrder['order']);
    // unset($getOrder['sentido']);
    unset($getOrder['page']);
    $getPage = $_GET;
    unset($getPage['page']);
    $data['queryPage'] = http_build_query($getPage);
    $data['queryParams'] = http_build_query($getOrder);

    //sanitiza todos los campos de formulario
    $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);;





    $this->view->showViews(array('templates/header.view.php', 'usuarios-sistema.view.php', 'templates/footer.view.php'), $data);
  }
}
