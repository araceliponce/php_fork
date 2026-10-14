<?php

class EjercicioController
{


    // Crea una página web que permita introducir un JSON mediante un formulario con un campo textarea. El JSON contendrá las ventas realizadas por varios empleados en diferentes productos.
    // El programa debe calcular, para cada producto, el importe total vendido, el número de ventas realizadas, el precio medio por venta y el empleado que ha generado más ingresos.
    // Además, debe mostrar los siguientes listados:
    // - Mejores vendedores: empleados que han generado más de 500 € en ventas (div verde).
    // - Vendedores con pocas ventas: empleados que han generado menos de 200 € (div amarillo).
    // - Vendedores destacados: empleados que han vendido al menos 3 productos diferentes (div azul).
    // - Vendedores por debajo del objetivo: empleados que han generado menos de 500 € en ventas (div rojo).
    public function ejercicio(
        string $json = '',
        array $errores = [],
        array $resultado = [],
        array $empleados = []
    ): void {
        require 'ejercicio.view.php';
    }

    public function doEjercicio(): void
    {
        $json = $_POST['json'] ?? '';

        $errores = $this->checkEjercicio($_POST);

        // if ($errores === []) {
        //     $datos = json_decode($json, true);

        //     $resultado = $this->calcularProductos($datos);
        //     $empleados = $this->calcularEmpleados($datos);

        //     $this->ejercicio(
        //         $json,
        //         $errores,
        //         $resultado,
        //         $empleados
        //     );
        // } else {
        $this->ejercicio($json, $errores);
        // }
    }
    private function checkEjercicio(array $datos): array
    {
        $errores = [];

        //json debe ser un array de categorias de productos, cada categoria tiene un array de vendedores,cada vendedor un array con los precios a los que vendieron productos de esa cat

        // 1ro revisa si envió json
        if (!isset($datos['json'])) {
            $errores['json'][] = 'es un campo obligatorio';
        } else {
            $jsonText = $datos['json'];

            //luego si no lo dejo vacio
            if (trim($jsonText) === '') {
                $errores['json'][] = 'es un campo obligatorio';
            } else {
                //es no  valido?
                if (!json_validate($jsonText)) {
                    $errores['json'][] = 'inserta un json válido';
                } else {
                    //paso los filtros? a decodificar y verificar los tipos
                    $data = json_decode($jsonText, true);
                    foreach ($data as $categoria => $personas) {
                        foreach ($personas as $ventas) {
                            foreach ($ventas as $venta) {
                                $errores['json'][] = $venta;
                            }
                        }
                    }
                }
            }
        }



        return $errores;
    }

    private function calcularProductos(array $datos): array
    {
        $resultado = [];

        return $resultado;
    }

    private function calcularEmpleados(array $datos): array
    {
        $empleados = [];

        return $empleados;
    }
}
