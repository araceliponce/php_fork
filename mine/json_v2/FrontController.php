<?php

require_once 'EjercicioController.php';

$controller = new EjercicioController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->doEjercicio();
} else {
    $controller->ejercicio();
}
