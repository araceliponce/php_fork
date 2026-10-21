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
        $carloses = $model->getTrabajadoresByUsername('pepe');


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





    public function conFiltros(array $roles = [], array $errores = [], array $resultado = []): void
    {

        $model = new TrabajadorModel();
        $roles = $model->getRoles();
        $data = array(
            'titulo' => 'trabajadores con filtros',
            'breadcrumb' => ['Inicio', '........'],
        );



        if (isset($_GET['usernameInput'])) {
            $input = filter_var($_GET['usernameInput'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $resultado = $model->getTrabajadoresByUsername($input);

            //para poder ver los valores de los input tras enviar el form
            // $data['usernameInput'] = $input;
        }

        if (isset($_GET['rolSelect'])) {
            $input = filter_var($_GET['rolSelect'][0], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $resultado = $model->getTrabajadoresByRol($input);
        }

        //busca por un rango de salario especifico
        // Para desinfectar y validar números de punto flotante en PHP evitando que se borren los puntos o las comas decimales, debes permitir explícitamente estos caracteres. El filtro por defecto FILTER_SANITIZE_NUMBER_FLOAT elimina ambos a menos que uses banderas (flags).


        /*

2. La solución recomendada: Convertir a formato flotante real (Float)

Desinfectar solo limpia el texto, pero no lo convierte en un número utilizable por PHP (PHP usa estrictamente el punto . para los decimales). Si tu entrada usa comas ,, debes reemplazarlas antes de validar o castear:
php
$input = "1.234,56"; // Formato común con coma decimal

// 1. Reemplazar la coma por punto (y eliminar puntos de miles si los hubiera)
$clean = str_replace(',', '.', $input); 

// 2. Validar que sea un float correcto
$float = filter_var($clean, FILTER_VALIDATE_FLOAT);

if ($float !== false) {
    echo "Número válido: " . $float; // 1234.56
} else {
    echo "No es un número válido";
}
*/

        if (isset($_GET['salarioMinInput']) & isset($_GET['salarioMaxInput'])) {
            $min = (float) filter_var($_GET['salarioMinInput'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $max = (float) filter_var($_GET['salarioMaxInput'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $resultado = $model->getTrabajadoresBySalarioRango($min, $max);

            //para poder ver los valores de los input tras enviar el form
            // $data['salarioMinInput'] = $min;
            // $data['salarioMaxInput'] = $max;
        }


        if (isset($_GET['countriesSelect'])) {
            $input =  filter_var_array($_GET['countriesSelect'], FILTER_SANITIZE_SPECIAL_CHARS);

            $resultado = $model->getTrabajadoresByCountries($input);

            $data['countriesSelected'] = $input;
        }




        if (empty($_GET)) {
            $resultado = $model->getTrabajadoreS();
        }


        // Source - https://stackoverflow.com/a/45287155
        // Posted by Just_Do_It
        // Retrieved 2026-10-21, License - CC BY-SA 3.0

        if (isset($_GET['reset'])) {
            // $_GET = array();
            // Source - https://stackoverflow.com/a/1251603
            // Posted by Matt Bridges, modified by community. See post 'Timeline' for change history
            // Retrieved 2026-10-21, License - CC BY-SA 2.5

            $pos = strpos($url, "?");
            $url = substr($url, 0, $pos);
        }



        $data['errores'] = $errores;
        $data['resultado'] = $resultado;
        $data['roles'] = $roles;
        $data['countries'] = $model->getCountries();;




        $this->view->showViews(array('templates/header.view.php', 'trabajadores-con-filtros.view.php', 'templates/footer.view.php'), $data);
    }


    //donde colocar el model ???


}
