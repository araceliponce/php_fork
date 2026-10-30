<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ProductoModel;

// use Com\Daw2\Models\AuxCountriesModel;
// use Com\Daw2\Models\AuxRolTrabajadorModel;
// use Com\Daw2\Models\TrabajadorModel;

class ProductoController extends BaseController
{


  public function getProductos(): void
  {
    $data = array(
      'titulo' => 'Todos los productos',
      'breadcrumb' => ['Inicio', 'Consultas simples'],
    );
    $model = new ProductoModel();
    $data['productos'] = $model->getProductos();
    $this->view->showViews(array('templates/header.view.php', 'productos.view.php', 'templates/footer.view.php'), $data);
  }
}
