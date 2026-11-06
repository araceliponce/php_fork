<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CategoriaModel;
use Com\Daw2\Models\ProductoModel;
use Com\Daw2\Models\ProveedorModel;

class ProductoController extends BaseController
{


  public function getProductos(): void
  {
    $data = array(
      'titulo' => 'Todos los productos',
      'breadcrumb' => ['Inicio', 'Consultas simples'],
    );
    $model = new ProductoModel();
    $modelProveedores = new ProveedorModel();
    $modelCategorias = new CategoriaModel();

    $input = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $data['input'] = $input;
    $data['productos'] = $model->getProductos($_GET);
    $data['proveedores'] = $modelProveedores->getAll();
    $data['supercategorias'] = $modelCategorias->getSuper();
    $data['subcategorias'] = $modelCategorias->getSub();



    $data['order'] = $model->getColumnaOrdenadora($_GET);
    $data['currentPage'] = $model->getCurrentPage($_GET);
    $data['maxPage'] = $model->getLastPage($_GET);

    //pendiente
    //No modificamos la superglobal, la copiamos en $getOrder
    $getOrder = $_GET;
    $data['baseUrl'] = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    unset($getOrder['order']);
    // unset($getOrder['sentido']);
    $data['queryParams'] = http_build_query($getOrder);

    $getPage = $_GET;
    unset($getPage['page']);
    $data['queryParamsPage'] = http_build_query($getPage);

    $this->view->showViews(array('templates/header.view.php', 'productos.view.php', 'templates/footer.view.php'), $data);
  }
}
