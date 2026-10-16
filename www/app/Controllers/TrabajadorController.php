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
        // $model->getTrabajadores();

        $data = array(
            'titulo' => 'titulo',
            'breadcrumb' => ['Inicio', 'titulo'],
        );

        $trabajadores = $model->getTrabajadores();
        $carloses = $model->getTrabajadoresCarlos();


        //para ordenar segun sus salarios (opcion1: crear nuevo array donde el salario sea la clave????)
        // para encontrar el valor menor se compara constantemente con otro valor, este otro valor inicia con 
        $menorSalario = PHP_FLOAT_MAX;
        $algo = '';
        $menosPagado = '';

        $arrayUsernameSalario = [];
        $arrayStandard = [];


        // 100, 200, 140, 300

        foreach ($trabajadores as $trabajador) {

            $item = [
                'username' => $trabajador['username'],
                'salario' => $trabajador['salarioBruto']
            ];
            array_push($arrayUsernameSalario, $item);

            //complicada cosa para ordenar
            usort($arrayUsernameSalario, function ($a, $b) {
                // return $a['salario'] <=> $b['salario']; //ordena de menor a mayor
                return $b['salario'] <=> $a['salario']; //ordena de mayor a menor

            });



            if ($trabajador['salarioBruto'] < $menorSalario) {
                // $algo = 'algo';
                $menosPagado = $trabajador['username'];
                $menorSalario = $trabajador['salarioBruto'];
            };
            // array_shift   elimina/desaparece el elemento del inicio del array
            // array_unshift coloca un item como item 0 de un array
            // array_push es array.append




            if ($trabajador['id_rol'] == 3) {
                array_push($arrayStandard, $item);
            };
        }

        $data['trabajadores'] = $trabajadores;
        $data['algo'] = $algo;
        $data['menosPagado'] = $menosPagado;
        $data['arrayUsernameSalario'] = $arrayUsernameSalario;
        $data['arrayStandard'] = $arrayStandard;
        $data['carloses'] = $carloses;


        $this->view->showViews(array('templates/header.view.php', 'trabajadores.view.php', 'templates/footer.view.php'), $data);
    }
}
