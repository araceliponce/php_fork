<?php

function escapar(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE,        'UTF-8');
}

function euros(float|int $cantidad): string
{

    return number_format($cantidad, 2, ',', '.') . ' €'; // numero, cuantos decimales, separador de decimales, separador de miles                   
}

// $mejores = [];
// $pocasVentas = [];
// $destacados = [];
// $porDebajo = [];

// foreach ($empleados as $nombre => $datosEmpleado) {
//     if ($datosEmpleado['total'] > 500) {
//         $mejores[] = $nombre;
//     }

//     if ($datosEmpleado['total'] < 200) {
//         $pocasVentas[] = $nombre;
//     }

//     if ($datosEmpleado['numeroProductos'] >= 3) {
//         $destacados[] = $nombre;
//     }

//     if ($datosEmpleado['total'] < 500) {
//         $porDebajo[] = $nombre;
//     }
// }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ejercicio</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        :root {
            color-scheme: dark;
            --bs-body-bg: unset;
            --bs-body-color: unset;
        }
    </style>
</head>

<body>
    <div class="container py-4">



        <?php if ($errores === [] && $resultado !== []): ?>

            <h2 class="h4">Estadísticas por producto</h2>

            <div class="table-responsive mb-4">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Total vendido</th>
                            <th>Número de ventas</th>
                            <th>Precio medio</th>
                            <th>Mejor vendedor</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($resultado as $producto => $datos): ?>
                            <tr>
                                <td><?= escapar((string) $producto) ?></td>

                                <td><?= euros($datos['total']) ?></td>

                                <td><?= $datos['numeroVentas'] ?></td>

                                <td><?= euros($datos['media']) ?></td>

                                <td>
                                    <?= escapar($datos['mejorVendedor']) ?>
                                    (<?= euros($datos['ingresosMejorVendedor']) ?>)
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <h2 class="h4">Clasificación de empleados</h2>

            <div class="row">

                <div class="col-12 col-lg-6 mb-3">
                    <div class="alert alert-success">
                        <h3 class="h5">Mejores vendedores</h3>


                    </div>
                </div>

                <div class="col-12 col-lg-6 mb-3">
                    <div class="alert alert-warning">
                        <h3 class="h5">Vendedores con pocas ventas</h3>


                    </div>
                </div>

                <div class="col-12 col-lg-6 mb-3">
                    <div class="alert alert-info">
                        <h3 class="h5">Vendedores destacados</h3>


                    </div>
                </div>

                <div class="col-12 col-lg-6 mb-3">
                    <div class="alert alert-danger">
                        <h3 class="h5">Vendedores por debajo del objetivo</h3>


                    </div>
                </div>

            </div>

        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $errores === []): ?>

            <div class="alert alert-info">
                No hay resultados que mostrar.
            </div>

        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                Introducir datos de ventas
            </div>

            <div class="card-body">
                <form method="post" action="FrontController.php">

                    <div class="mb-3">
                        <label for="json" class="form-label">
                            JSON con los datos:
                        </label>

                        <textarea
                            class="form-control"
                            id="json"
                            name="json"
                            rows="12"
                            required><?= $json ?? '' ?></textarea>

                        <?php if ($errores['json'] !== []): ?>
                            <div class="text-danger mt-2">
                                <ul class="mb-0">
                                    <?php foreach ($errores['json'] as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Calcular ventas
                    </button>

                </form>
            </div>
        </div>

    </div>
</body>

</html>