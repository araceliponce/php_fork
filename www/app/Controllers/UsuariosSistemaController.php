<?php
declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\UsuariosSistemaModel;

class UsuariosSistemaController extends BaseController
{
    private const array IDIOMAS = ['en', 'es', 'gl'];
    public function index(): void
    {
        $data =
            [
                'titulo' => 'Usuarios Sistema',
                'breadcrumb' => ['Inicio', 'Usuarios Sistema'],
                'js' => ['assets/js/pages/usuarios-sistema.js']
            ];
        $model = new UsuariosSistemaModel();
        $data['usuarios'] = $model->getFilterBy($_GET);
        $data['maxPage'] = $model->getMaxPage($_GET);
        $data['currentPage'] = $model->getCurrentPage($_GET);

        $data['currentOrder'] = $model->getIntOrder($_GET);
        $data['sentido'] = $model->getCurrentSentido($_GET);

        $data['cabeceras'] = ['Nombre', 'Rol', 'Email', 'Últ. acceso', 'Idioma'];
        $data['idiomas'] = self::IDIOMAS;
        $rolesModel = new AuxRolModel();
        $data['roles'] = $rolesModel->getAll();
        $getOrder = $_GET;
        unset($getOrder['order']);
        unset($getOrder['sentido']);
        unset($getOrder['page']);
        $getPage = $_GET;
        unset($getPage['page']);
        $data['queryPage'] = http_build_query($getPage);
        $data['queryParams'] = http_build_query($getOrder);
        $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['js'] = ['assets/js/pages/usuarios-sistema.js'];
        $this->view->showViews(array('templates/header.view.php', 'usuarios-sistema.view.php', 'templates/footer.view.php'), $data);
    }

}