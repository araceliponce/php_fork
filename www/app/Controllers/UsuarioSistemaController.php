<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxRolUsuarioModel;
use Com\Daw2\Models\UsuarioSistemaModel;

class UsuarioSistemaController extends BaseController
{



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
    $data['columnasNames'] = $model->getColumnasNames();



    //sanitiza todos los campos de formulario
    $input = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $data['input'] = $input;

    $this->view->showViews(array('templates/header.view.php', 'usuarios-sistema.view.php', 'templates/footer.view.php'), $data);
  }
}
