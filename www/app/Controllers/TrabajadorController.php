<?php
declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\TrabajadorModel;

class TrabajadorController extends BaseController
{
    public function testDb()
    {
        $model = new TrabajadorModel();
        $model->getTrabajadores();
    }

}